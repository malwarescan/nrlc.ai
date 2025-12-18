<?php
/**
 * GSC Alternate Pages Remediation Script
 * 
 * Analyzes GSC "Alternate page with proper canonical tag" issue
 * and identifies which URLs need remediation (redirect or noindex)
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../lib/helpers.php';

$gscTableCsv = $argv[1] ?? __DIR__ . '/../../Downloads/nrlc.ai-Coverage-Drilldown-2025-12-18/Table.csv';
$outputCsv = $argv[2] ?? __DIR__ . '/gsc_alternate_remediation_report.csv';

if (!file_exists($gscTableCsv)) {
  die("Error: GSC Table CSV not found: $gscTableCsv\n");
}

// Load helper functions
require_once __DIR__ . '/../lib/helpers.php';

$results = [];
$stats = [
  'total' => 0,
  'local_pages' => 0,
  'non_canonical_locale' => 0,
  'uk_cities' => 0,
  'us_cities' => 0,
  'career_pages' => 0,
  'service_pages' => 0
];

// Read GSC data
$fh = fopen($gscTableCsv, 'r');
if (!$fh) {
  die("Error: Could not open $gscTableCsv\n");
}

// Skip header
$header = fgetcsv($fh);
if ($header === false || $header[0] !== 'URL') {
  die("Error: Invalid CSV format. Expected 'URL' as first column.\n");
}

// Process each URL
while (($row = fgetcsv($fh)) !== false) {
  if (empty($row[0])) continue;
  
  $url = $row[0];
  $lastCrawled = $row[1] ?? '';
  
  $stats['total']++;
  
  // Parse URL
  if (!preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})(.+)$#i', $url, $m)) {
    continue; // Skip invalid URLs
  }
  
  $locale = strtolower($m[1]);
  $pathWithoutLocale = $m[2];
  
  // Check if LOCAL page
  if (!is_local_page($pathWithoutLocale)) {
    continue; // Skip GLOBAL pages
  }
  
  $stats['local_pages']++;
  
  // Determine canonical locale
  $canonicalLocale = null;
  $citySlug = null;
  $pageType = null;
  
  if (preg_match('#^/services/([^/]+)/([^/]+)/#', $pathWithoutLocale, $serviceMatch)) {
    $pageType = 'service';
    $citySlug = $serviceMatch[2];
    $canonicalLocale = get_canonical_locale_for_city($citySlug);
    $stats['service_pages']++;
  } elseif (preg_match('#^/careers/([^/]+)/([^/]+)/#', $pathWithoutLocale, $careerMatch)) {
    $pageType = 'career';
    $citySlug = $careerMatch[1];
    $canonicalLocale = get_canonical_locale_for_city($citySlug);
    $stats['career_pages']++;
  } else {
    continue; // Unknown LOCAL page type
  }
  
  // Check if UK city
  if (is_uk_city($citySlug)) {
    $stats['uk_cities']++;
  } else {
    $stats['us_cities']++;
  }
  
  // Check if current locale is canonical
  $isCanonical = ($locale === $canonicalLocale);
  
  if (!$isCanonical) {
    $stats['non_canonical_locale']++;
    
    // Build canonical URL
    $canonicalUrl = 'https://nrlc.ai/' . $canonicalLocale . $pathWithoutLocale;
    
    // For UK cities with service pages, enforce local-seo-ai service
    if ($pageType === 'service' && is_uk_city($citySlug)) {
      $canonicalUrl = 'https://nrlc.ai/' . $canonicalLocale . '/services/local-seo-ai/' . $citySlug . '/';
    }
    
    $results[] = [
      'url' => $url,
      'last_crawled' => $lastCrawled,
      'current_locale' => $locale,
      'canonical_locale' => $canonicalLocale,
      'city_slug' => $citySlug,
      'page_type' => $pageType,
      'is_uk_city' => is_uk_city($citySlug) ? 'yes' : 'no',
      'canonical_url' => $canonicalUrl,
      'action' => 'redirect_301',
      'status' => 'needs_fix'
    ];
  } else {
    // Canonical locale - should be indexed
    $results[] = [
      'url' => $url,
      'last_crawled' => $lastCrawled,
      'current_locale' => $locale,
      'canonical_locale' => $canonicalLocale,
      'city_slug' => $citySlug,
      'page_type' => $pageType,
      'is_uk_city' => is_uk_city($citySlug) ? 'yes' : 'no',
      'canonical_url' => $url,
      'action' => 'keep_indexed',
      'status' => 'canonical'
    ];
  }
}

fclose($fh);

// Write results to CSV
$outputFh = fopen($outputCsv, 'w');
if (!$outputFh) {
  die("Error: Could not create output file: $outputCsv\n");
}

// Write header
fputcsv($outputFh, [
  'URL',
  'Last Crawled',
  'Current Locale',
  'Canonical Locale',
  'City Slug',
  'Page Type',
  'Is UK City',
  'Canonical URL',
  'Action',
  'Status'
], ',', '"', '');

// Write results
foreach ($results as $result) {
  fputcsv($outputFh, $result, ',', '"', '');
}

fclose($outputFh);

// Print summary
echo "\n=== GSC Alternate Pages Remediation Report ===\n\n";
echo "Total URLs analyzed: {$stats['total']}\n";
echo "LOCAL pages found: {$stats['local_pages']}\n";
echo "  - Service pages: {$stats['service_pages']}\n";
echo "  - Career pages: {$stats['career_pages']}\n";
echo "  - UK cities: {$stats['uk_cities']}\n";
echo "  - US/Other cities: {$stats['us_cities']}\n";
echo "\n";
echo "Non-canonical locale versions: {$stats['non_canonical_locale']}\n";
echo "  (These need 301 redirects or noindex)\n";
echo "\n";
echo "Report written to: $outputCsv\n";
echo "\n";

// Count by action
$actionCounts = [];
foreach ($results as $result) {
  $action = $result['action'];
  $actionCounts[$action] = ($actionCounts[$action] ?? 0) + 1;
}

echo "Actions needed:\n";
foreach ($actionCounts as $action => $count) {
  echo "  - $action: $count\n";
}
echo "\n";

