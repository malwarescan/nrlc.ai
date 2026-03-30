#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Audit live URLs for render failures.
 *
 * render_page() no longer returns a fake 200 stub; router errors surface as HTTP 500.
 *
 * Detection (any triggers a hit):
 * - HTTP status >= 500
 * - Legacy: <!-- NRLC_RENDER_FALLBACK -->, multiple <!DOCTYPE (old responses/CDN cache)
 *
 * Logs: grep host logs for: render_page failed:
 *
 * Usage:
 *   php scripts/audit_render_stub.php --base-url=https://nrlc.ai
 *   php scripts/audit_render_stub.php --base-url=https://nrlc.ai --max=500
 *   php scripts/audit_render_stub.php --base-url=http://127.0.0.1:8000 --urls=urls.txt
 *   php scripts/audit_render_stub.php --critical-only
 */

$opts = getopt('', ['base-url:', 'max:', 'sleep-ms:', 'urls:', 'sitemap:', 'critical-only', 'help']);

if (isset($opts['help'])) {
  fwrite(STDOUT, <<<HELP
Usage: php scripts/audit_render_stub.php [--base-url=URL] [--max=N] [--sleep-ms=N] [--urls=FILE] [--sitemap=URL] [--critical-only]

  --base-url     Origin (default https://nrlc.ai). Used to build sitemap URL and --critical-only paths.
  --max          Cap number of URLs after dedupe (default: no cap).
  --sleep-ms     Delay between HTTP requests.
  --urls         Newline-separated URLs (overrides sitemap mode).
  --sitemap      Sitemap URL (default: {base-url}/sitemap.xml).
  --critical-only  Only check a small built-in list of hub paths.

Logs: grep production logs for: render_page failed:

HELP);
  exit(0);
}

$baseUrl = rtrim($opts['base-url'] ?? 'https://nrlc.ai', '/');
$max = isset($opts['max']) ? max(1, (int)$opts['max']) : PHP_INT_MAX;
$sleepUs = isset($opts['sleep-ms']) ? max(0, (int)$opts['sleep-ms']) * 1000 : 0;
$criticalOnly = array_key_exists('critical-only', $opts);

$criticalPaths = [
  '/',
  '/ai-optimization/',
  '/en-us/ai-optimization/',
  '/en-us/generative-engine-optimization/',
  '/en-us/insights/',
  '/training/',
  '/glossary/',
];

$urls = [];
if ($criticalOnly) {
  foreach ($criticalPaths as $p) {
    $urls[] = $baseUrl . $p;
  }
} elseif (!empty($opts['urls'])) {
  $path = $opts['urls'];
  if (!is_readable($path)) {
    fwrite(STDERR, "Cannot read --urls file: {$path}\n");
    exit(1);
  }
  foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line !== '' && $line[0] !== '#') {
      $urls[] = $line;
    }
  }
} else {
  $sitemapUrl = isset($opts['sitemap']) ? $opts['sitemap'] : ($baseUrl . '/sitemap.xml');
  $urls = collect_sitemap_urls($sitemapUrl, $baseUrl);
}

$urls = array_values(array_unique($urls));
if (count($urls) > $max) {
  $urls = array_slice($urls, 0, $max);
}

$report = [];
$failCount = 0;

foreach ($urls as $url) {
  if ($sleepUs > 0) {
    usleep($sleepUs);
  }
  $res = http_get($url);
  $reasons = detect_stub($res['body'], $res['headers_raw'], $res['status']);
  if ($reasons !== []) {
    $failCount++;
    $report[] = [
      'url' => $url,
      'status' => $res['status'],
      'reasons' => implode('; ', $reasons),
    ];
  }
}

$ts = date('Y-m-d_H-i-s');
$outCsv = __DIR__ . '/../reports/render_stub_audit_' . $ts . '.csv';
@mkdir(dirname($outCsv), 0755, true);
$fh = fopen($outCsv, 'w');
if ($fh === false) {
  fwrite(STDERR, "Cannot write {$outCsv}\n");
  exit(1);
}
$csvRow = static function ($handle, array $row): void {
  if (PHP_VERSION_ID >= 80400) {
    fputcsv($handle, $row, ',', '"', '\\');
  } else {
    fputcsv($handle, $row);
  }
};
$csvRow($fh, ['url', 'http_status', 'stub_reasons']);
foreach ($report as $row) {
  $csvRow($fh, [$row['url'], (string)$row['status'], $row['reasons']]);
}
fclose($fh);

fwrite(STDOUT, "URLs checked: " . count($urls) . "\n");
fwrite(STDOUT, "Stub failures: {$failCount}\n");
fwrite(STDOUT, "Report: {$outCsv}\n");
if ($failCount > 0) {
  foreach ($report as $row) {
    fwrite(STDOUT, "  - {$row['url']} ({$row['reasons']})\n");
  }
  exit(2);
}
exit(0);

/**
 * @return list<string>
 */
function collect_sitemap_urls(string $sitemapUrl, string $baseUrl): array {
  $seen = [];
  $out = [];
  collect_sitemap_urls_inner($sitemapUrl, $baseUrl, $seen, $out, 0);
  return $out;
}

/**
 * @param array<string, true> $seen
 * @param list<string> $out
 */
function collect_sitemap_urls_inner(string $sitemapUrl, string $baseUrl, array &$seen, array &$out, int $depth): void {
  if ($depth > 5 || isset($seen[$sitemapUrl])) {
    return;
  }
  $seen[$sitemapUrl] = true;
  $xml = fetch_body($sitemapUrl);
  if ($xml === null) {
    fwrite(STDERR, "Warning: could not fetch sitemap: {$sitemapUrl}\n");
    return;
  }
  $xml = preg_replace('/xmlns="[^"]*"/', '', $xml) ?? $xml;
  if (preg_match_all('#<loc>\s*([^<\s]+)\s*</loc>#i', $xml, $m)) {
    foreach ($m[1] as $loc) {
      $loc = trim(html_entity_decode($loc, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
      if ($loc === '') {
        continue;
      }
      if (strpos($loc, 'example.com') !== false) {
        $path = parse_url($loc, PHP_URL_PATH) ?? '/';
        $loc = rtrim($baseUrl, '/') . $path;
      }
      if (preg_match('#sitemap.*\.xml$#i', $loc)) {
        collect_sitemap_urls_inner($loc, $baseUrl, $seen, $out, $depth + 1);
      } else {
        $out[] = $loc;
      }
    }
  }
}

function fetch_body(string $url): ?string {
  $r = http_get($url);
  return $r['status'] >= 200 && $r['status'] < 400 ? $r['body'] : null;
}

/**
 * @return array{status: int, headers_raw: string, body: string}
 */
function http_get(string $url): array {
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_TIMEOUT => 45,
      CURLOPT_HEADER => true,
      CURLOPT_USERAGENT => 'NRLC-render-stub-audit/1.0',
    ]);
    $raw = curl_exec($ch);
    if ($raw === false) {
      return ['status' => 0, 'headers_raw' => '', 'body' => ''];
    }
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = (int)curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($raw, 0, $headerSize);
    $body = substr($raw, $headerSize);
    return ['status' => $status, 'headers_raw' => $headers, 'body' => $body];
  }
  $ctx = stream_context_create([
    'http' => [
      'timeout' => 45,
      'header' => "User-Agent: NRLC-render-stub-audit/1.0\r\n",
    ],
  ]);
  $body = @file_get_contents($url, false, $ctx);
  return [
    'status' => $body !== false ? 200 : 0,
    'headers_raw' => '',
    'body' => $body !== false ? $body : '',
  ];
}

/**
 * @return list<string>
 */
function detect_stub(string $body, string $headersRaw, int $status): array {
  $reasons = [];
  if ($status >= 500) {
    $reasons[] = 'http:status_' . $status;
  }
  if (strpos($body, '<!-- NRLC_RENDER_FALLBACK -->') !== false) {
    $reasons[] = 'html:NRLC_RENDER_FALLBACK';
  }
  if (substr_count($body, '<!DOCTYPE') >= 2) {
    $reasons[] = 'html:multiple_DOCTYPE';
  }
  return $reasons;
}
