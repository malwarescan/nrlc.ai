<?php
declare(strict_types=1);

/**
 * Sections D, E, F of Evidence Package
 */

require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/meta_directive.php';
require_once __DIR__.'/../lib/helpers.php';

$pages = csv_read(__DIR__.'/../serp_intel/Pages.csv');
$evidenceData = json_decode(file_get_contents(__DIR__.'/../sudo_evidence_data.json'), true);

// D) META RULES VS REAL PAGES
echo "=" . str_repeat("=", 79) . "\n";
echo "D) META RULES VS REAL PAGES (FROM Pages.csv + IMPLEMENTATION)\n";
echo "=" . str_repeat("=", 79) . "\n\n";

// Group pages by family
$families = [
  'Homepage' => [],
  'Services' => [],
  'Insights' => [],
  'Careers' => []
];

foreach ($pages as $row) {
  $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
  if (!$url) continue;
  
  $impressions = (int)(str_replace(',', '', $row['impressions'] ?? $row['Impressions'] ?? '0'));
  
  if (preg_match('#^https?://[^/]+/?$#', $url) || preg_match('#^https?://[^/]+/en-us/?$#', $url)) {
    $families['Homepage'][] = ['url' => $url, 'impressions' => $impressions];
  } elseif (preg_match('#/services/#', $url)) {
    $families['Services'][] = ['url' => $url, 'impressions' => $impressions];
  } elseif (preg_match('#/insights/#', $url)) {
    $families['Insights'][] = ['url' => $url, 'impressions' => $impressions];
  } elseif (preg_match('#/careers/#', $url)) {
    $families['Careers'][] = ['url' => $url, 'impressions' => $impressions];
  }
}

// Sort by impressions and take top 5
foreach ($families as $family => &$urls) {
  usort($urls, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
  $urls = array_slice($urls, 0, 5);
}

// Extract metadata for each URL
function extract_meta_from_url(string $url): array {
  // Parse URL to determine slug
  $path = parse_url($url, PHP_URL_PATH);
  $slug = 'home/home';
  
  if (preg_match('#/services/([^/]+)/([^/]+)/#', $path, $m)) {
    $slug = 'services/service_city';
    $service = $m[1];
    $city = $m[2];
  } elseif (preg_match('#/insights/([^/]+)/#', $path, $m)) {
    $slug = 'insights/article';
  } elseif (preg_match('#/careers/([^/]+)/([^/]+)/#', $path, $m)) {
    $slug = 'careers/career_city';
  } elseif ($path === '/' || $path === '/en-us/' || $path === '') {
    $slug = 'home/home';
  }
  
  // Try to load page file
  $filePath = __DIR__.'/../pages/'.$slug.'.php';
  if (!file_exists($filePath)) {
    return ['error' => 'File not found'];
  }
  
  // Analyze intent
  $intent = analyze_page_intent($filePath, $slug);
  if (isset($intent['error'])) {
    return $intent;
  }
  
  // Generate recommended metadata
  $recommendedTitle = generate_meta_title($intent, $slug);
  $recommendedDesc = generate_meta_description($intent, $slug);
  
  // Try to extract current metadata from router or page file
  $currentTitle = null;
  $currentDesc = null;
  
  $content = file_get_contents($filePath);
  if (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\']((?:[^\'\\\\]|\\\\.)*)[\']\s*;/s', $content, $matches)) {
    $currentTitle = stripcslashes($matches[1]);
  }
  if (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\']((?:[^\'\\\\]|\\\\.)*)[\']\s*;/s', $content, $matches)) {
    $currentDesc = stripcslashes($matches[1]);
  }
  
  // Determine reason
  $reason = 'Intent alignment: ' . ($intent['pageType'] ?? 'general') . ' page targeting ' . ($intent['intent'] ?? 'informational') . ' intent';
  
  return [
    'current_title' => $currentTitle,
    'current_desc' => $currentDesc,
    'recommended_title' => $recommendedTitle,
    'recommended_desc' => $recommendedDesc,
    'reason' => $reason
  ];
}

foreach ($families as $family => $urls) {
  if (empty($urls)) continue;
  
  echo "\n$family Family (Top 5 by impressions):\n";
  echo str_repeat("-", 150) . "\n";
  echo "url | current title | current description | recommended title | recommended description | reason\n";
  echo str_repeat("-", 150) . "\n";
  
  foreach ($urls as $urlData) {
    $url = $urlData['url'];
    $meta = extract_meta_from_url($url);
    
    if (isset($meta['error'])) {
      printf("%-60s | ERROR: %s\n", substr($url, 0, 60), $meta['error']);
      continue;
    }
    
    printf("%-60s | %-30s | %-40s | %-30s | %-40s | %s\n",
      substr($url, 0, 60),
      substr($meta['current_title'] ?? 'N/A', 0, 30),
      substr($meta['current_desc'] ?? 'N/A', 0, 40),
      substr($meta['recommended_title'], 0, 30),
      substr($meta['recommended_desc'], 0, 40),
      substr($meta['reason'], 0, 50)
    );
  }
}

// Check for duplicate first 8 words
echo "\n\nChecking for duplicate first 8 words in recommended descriptions...\n";
$firstWords = [];
foreach ($families as $family => $urls) {
  foreach ($urls as $urlData) {
    $url = $urlData['url'];
    $meta = extract_meta_from_url($url);
    if (!isset($meta['error']) && isset($meta['recommended_desc'])) {
      $words = explode(' ', $meta['recommended_desc']);
      $first8 = implode(' ', array_slice($words, 0, 8));
      if (!isset($firstWords[$first8])) {
        $firstWords[$first8] = [];
      }
      $firstWords[$first8][] = $url;
    }
  }
}

$duplicates = array_filter($firstWords, fn($urls) => count($urls) > 1);
if (empty($duplicates)) {
  echo "✓ No duplicate first 8 words found\n";
} else {
  echo "✗ Found duplicate first 8 words:\n";
  foreach ($duplicates as $words => $urls) {
    echo "  '$words' appears in:\n";
    foreach ($urls as $url) {
      echo "    - $url\n";
    }
  }
}

echo "\n";

