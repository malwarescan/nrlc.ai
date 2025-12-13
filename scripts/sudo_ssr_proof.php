<?php
declare(strict_types=1);

/**
 * E) SSR PROOF - Extract actual HTML tags from rendered pages
 */

require_once __DIR__.'/../bootstrap/router.php';
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/meta_directive.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/hreflang.php';
require_once __DIR__.'/../config/locales.php';

// Priority URLs from evidence data
$evidenceData = json_decode(file_get_contents(__DIR__.'/../sudo_evidence_data.json'), true);
$priorityUrls = array_merge(
  array_slice(array_column($evidenceData['priority1'], 'url'), 0, 5),
  array_slice(array_column($evidenceData['priority2'], 'url'), 0, 3),
  array_slice(array_column($evidenceData['priority3'], 'url'), 0, 2)
);

// If no priority URLs, use top impressions
if (empty($priorityUrls)) {
  $pages = csv_read(__DIR__.'/../serp_intel/Pages.csv');
  $urls = [];
  foreach ($pages as $row) {
    $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
    if ($url && preg_match('#^https://#', $url)) {
      $impressions = (int)(str_replace(',', '', $row['impressions'] ?? $row['Impressions'] ?? '0'));
      $urls[] = ['url' => $url, 'impressions' => $impressions];
    }
  }
  usort($urls, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
  $priorityUrls = array_slice(array_column($urls, 'url'), 0, 10);
}

function extract_ssr_tags(string $url): array {
  // Parse URL
  $parsed = parse_url($url);
  $path = $parsed['path'] ?? '/';
  
  // Simulate request
  $_SERVER['REQUEST_URI'] = $path;
  $_SERVER['HTTP_HOST'] = $parsed['host'] ?? 'nrlc.ai';
  $_SERVER['HTTPS'] = 'on';
  $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
  
  // Capture output
  ob_start();
  
  try {
    // Route and render
    route_request();
    $html = ob_get_clean();
  } catch (Exception $e) {
    ob_end_clean();
    return ['error' => $e->getMessage()];
  }
  
  // Extract tags
  $tags = [];
  
  // Title
  if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches)) {
    $tags['title'] = trim(html_entity_decode(strip_tags($matches[1]), ENT_QUOTES, 'UTF-8'));
  }
  
  // Meta description
  if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\']([^"\']+)["\']/i', $html, $matches)) {
    $tags['meta_description'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  // Canonical
  if (preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']/i', $html, $matches)) {
    $tags['canonical'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  // og:url
  if (preg_match('/<meta\s+property=["\']og:url["\']\s+content=["\']([^"\']+)["\']/i', $html, $matches)) {
    $tags['og_url'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  return $tags;
}

echo "=" . str_repeat("=", 79) . "\n";
echo "E) SSR PROOF (RAW HTML, NOT HYDRATED DOM)\n";
echo "=" . str_repeat("=", 79) . "\n\n";

echo "Testing " . count($priorityUrls) . " priority URLs...\n\n";

$results = [];
foreach ($priorityUrls as $url) {
  echo "Testing: $url\n";
  $tags = extract_ssr_tags($url);
  $results[$url] = $tags;
  
  if (isset($tags['error'])) {
    echo "  ERROR: {$tags['error']}\n";
    continue;
  }
  
  // Verify
  $canonical = $tags['canonical'] ?? '';
  $ogUrl = $tags['og_url'] ?? '';
  $isHttps = strpos($canonical, 'https://') === 0;
  $isSelfRef = $canonical === $url || $canonical === str_replace('http://', 'https://', $url);
  $matches = ($canonical === $ogUrl);
  
  echo "  title: " . substr($tags['title'] ?? 'MISSING', 0, 60) . "\n";
  echo "  meta description: " . substr($tags['meta_description'] ?? 'MISSING', 0, 60) . "\n";
  echo "  canonical: " . ($tags['canonical'] ?? 'MISSING') . "\n";
  echo "  og:url: " . ($tags['og_url'] ?? 'MISSING') . "\n";
  echo "  ✓ canonical == og:url: " . ($matches ? 'YES' : 'NO') . "\n";
  echo "  ✓ canonical is self-referencing: " . ($isSelfRef ? 'YES' : 'NO') . "\n";
  echo "  ✓ canonical is https: " . ($isHttps ? 'YES' : 'NO') . "\n";
  echo "\n";
}

// Summary table
echo "\nSSR PROOF SUMMARY TABLE:\n";
echo str_repeat("-", 150) . "\n";
echo "url | title (length) | description (length) | canonical | og:url | canonical==og:url | self-ref | https\n";
echo str_repeat("-", 150) . "\n";

foreach ($results as $url => $tags) {
  if (isset($tags['error'])) {
    printf("%-60s | ERROR\n", substr($url, 0, 60));
    continue;
  }
  
  $title = $tags['title'] ?? 'MISSING';
  $desc = $tags['meta_description'] ?? 'MISSING';
  $canon = $tags['canonical'] ?? 'MISSING';
  $og = $tags['og_url'] ?? 'MISSING';
  $matches = ($canon === $og);
  $isSelfRef = $canon === $url || $canon === str_replace('http://', 'https://', $url);
  $isHttps = strpos($canon, 'https://') === 0;
  
  printf("%-60s | %s (%d) | %s (%d) | %s | %s | %s | %s | %s\n",
    substr($url, 0, 60),
    substr($title, 0, 30),
    strlen($title),
    substr($desc, 0, 30),
    strlen($desc),
    substr($canon, 0, 40),
    substr($og, 0, 40),
    $matches ? 'YES' : 'NO',
    $isSelfRef ? 'YES' : 'NO',
    $isHttps ? 'YES' : 'NO'
  );
}

