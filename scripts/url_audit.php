<?php
declare(strict_types=1);
/**
 * Per-URL auditor: status, robots, canonical, title/H1, wordcount, JSON-LD presence
 * Reads: ./data/Table.csv ; writes: ./data/url_audit_output.csv
 * Usage: php scripts/url_audit.php ./data/Table.csv 200
 */
if (php_sapi_name()!=='cli'){fwrite(STDERR,"CLI only\n");exit(1);} 
$csvPath = $argv[1] ?? getenv('CSV') ?? './data/Table.csv';
$limit   = (int)($argv[2] ?? getenv('LIMIT') ?? 0);

if (!is_file($csvPath)) { fwrite(STDERR, "CSV not found: $csvPath\n"); exit(1); }

function http_head(string $url): array {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 20,
    CURLOPT_USERAGENT => 'NRLC-AuditBot/1.0',
    CURLOPT_HEADER => true,
  ]);
  $hdr = curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
  curl_close($ch);
  $headers = [];
  foreach (explode("\n", (string)$hdr) as $line) {
    $line = trim($line);
    if (strpos($line, ':') !== false) {
      [$k,$v] = array_map('trim', explode(':', $line, 2));
      $headers[strtolower($k)] = $v;
    }
  }
  return [$code, $headers];
}

function http_get(string $url): array {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 25,
    CURLOPT_USERAGENT => 'NRLC-AuditBot/1.0',
  ]);
  $body = curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
  curl_close($ch);
  return [$code, (string)$body];
}

function extract_tag(string $html, string $tag, string $attr, string $name): ?string {
  $pattern = sprintf('#<%s[^>]*\s%s=["\']%s["\'][^>]*>(?:</%s>)?#i', $tag, $attr, preg_quote($name,'#'), $tag);
  if (!preg_match($pattern, $html, $m)) return null;
  if (preg_match('#\scontent=["\']([^"\']+)#i', $m[0], $c)) return $c[1];
  return null;
}

function extract_canonical(string $html): ?string {
  if (preg_match('#<link[^>]+rel=["\']canonical["\'][^>]+>#i', $html, $m)) {
    if (preg_match('#href=["\']([^"\']+)#i', $m[0], $h)) return $h[1];
  }
  return null;
}

function title_text(string $html): ?string {
  return preg_match('#<title[^>]*>(.*?)</title>#is', $html, $m) ? trim(html_entity_decode($m[1], ENT_QUOTES|ENT_HTML5)) : null;
}
function h1_text(string $html): ?string {
  return preg_match('#<h1[^>]*>(.*?)</h1>#is', $html, $m) ? trim(strip_tags($m[1])) : null;
}
function word_count(string $html): int {
  $text = strip_tags($html);
  $text = preg_replace('/\s+/', ' ', $text);
  return str_word_count($text);
}
function jsonld_types(string $html): array {
  $types = [];
  if (preg_match_all('#<script[^>]+type=["\']application/ld\+json["\'][^>]*>(.*?)</script>#is', $html, $m)) {
    foreach ($m[1] as $chunk) {
      $chunk = html_entity_decode($chunk, ENT_QUOTES|ENT_HTML5);
      $json = json_decode($chunk, true);
      if (!$json) continue;
      $list = is_assoc($json) ? [$json] : $json;
      foreach ($list as $obj) {
        if (is_array($obj) && isset($obj['@type'])) {
          $t = is_array($obj['@type']) ? implode('|', $obj['@type']) : (string)$obj['@type'];
          $types[] = $t;
        }
      }
    }
  }
  return array_values(array_unique($types));
}
function is_assoc($a) { return is_array($a) && array_keys($a)!==range(0,count($a)-1); }
function same_url(string $a, string $b): bool {
  return rtrim($a, '/ ') === rtrim($b, '/ ');
}
function slug_to_headline(string $url): string {
  $p = parse_url($url, PHP_URL_PATH) ?? '';
  $p = trim($p, '/');
  $last = $p ? basename($p) : 'untitled';
  $last = str_replace(['-','_','%20'], ' ', $last);
  $words = preg_split('/\s+/', $last);
  $title = [];
  foreach ($words as $w) { $title[] = ctype_digit($w) ? $w : ucfirst($w); }
  return trim(implode(' ', $title)) ?: 'Untitled';
}

$in = fopen($csvPath, 'r');
$hdr = fgetcsv($in, 0, ',', '"', '\\');
$cols = array_map('trim', $hdr);
$colUrl = array_search('URL', $cols);
if ($colUrl===false) { fwrite(STDERR,"CSV must have a URL column\n"); exit(1); }

$outPath = __DIR__.'/../data/url_audit_output.csv';
$out = fopen($outPath, 'w');
fputcsv($out, [
  'url','http_status','x_robots','robots_meta','canonical_found','canonical_expected',
  'title','h1','wordcount','jsonld_types','issues','fixes','headline_suggestion'
], ',', '"', '\\');

$cnt = 0;
while (($row = fgetcsv($in, 0, ',', '"', '\\')) !== false) {
  $url = trim($row[$colUrl] ?? '');
  if (!$url) continue;
  if ($limit>0 && $cnt >= $limit) break;
  $cnt++;

  [$hcode, $hdrs] = http_head($url);
  [$gcode, $html] = http_get($url);

  $xRobots = $hdrs['x-robots-tag'] ?? '';
  $title = title_text($html) ?? '';
  $h1 = h1_text($html) ?? '';
  $wc = word_count($html);
  $canon = extract_canonical($html);
  $robotsMeta = extract_tag($html, 'meta', 'name', 'robots');
  $types = jsonld_types($html);
  $canonExpected = $url;

  $issues = [];
  $fixes  = [];

  if (!in_array($gcode, [200, 204, 206], true)) {
    $issues[] = "Non-200 status: $gcode";
    $fixes[]  = "Return 200 for indexable content";
  }
  if ($xRobots && stripos($xRobots, 'noindex') !== false) {
    $issues[] = "X-Robots-Tag contains noindex";
    $fixes[]  = "Remove noindex from X-Robots-Tag";
  }
  if ($robotsMeta && stripos($robotsMeta, 'noindex') !== false) {
    $issues[] = "Robots meta contains noindex";
    $fixes[]  = "Remove noindex robots meta";
  }
  if (!$canon) {
    $issues[] = "Missing canonical";
    $fixes[]  = "Add <link rel=\"canonical\" href=\"$canonExpected\"> (self-canonical)";
  } elseif (!same_url($canon, $canonExpected)) {
    $issues[] = "Canonical mismatch ($canon)";
    $fixes[]  = "Set canonical to self: $canonExpected";
  }
  if ($wc < 250) {
    $issues[] = "Low wordcount ($wc)";
    $fixes[]  = "Expand unique body copy to 500–800+ words";
  }
  if (!$title || strlen($title) < 15) {
    $issues[] = "Weak or missing <title>";
    $fixes[]  = "Set descriptive, unique <title> (55–60 chars)";
  }
  if (!$h1) {
    $issues[] = "Missing <h1>";
    $fixes[]  = "Add a clear <h1> matching page intent";
  }
  if (!$types) {
    $issues[] = "No JSON-LD";
    $fixes[]  = "Add Article + WebPage + Organization JSON-LD";
  }
  if ($wc < 80 && $title && preg_match('/(404|not found)/i', $title)) {
    $issues[] = "Possible soft-404";
    $fixes[]  = "Return 404 for missing content or add real content";
  }

  $headline = slug_to_headline($url);

  fputcsv($out, [
    $url, $gcode, $xRobots, $robotsMeta, $canon ?? '', $canonExpected,
    $title, $h1, $wc, implode('|',$types), implode(' ; ', $issues), implode(' ; ', $fixes), $headline
  ], ',', '"', '\\');
}
fclose($in); fclose($out);

echo "Wrote: $outPath\n";


