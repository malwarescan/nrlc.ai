<?php
/**
 * GSC Redirect Pages Remediation Script
 * 
 * Analyzes GSC "Page with redirect" issue
 * and identifies which URLs need remediation
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../lib/helpers.php';

$gscTableCsv = $argv[1] ?? __DIR__ . '/../../Downloads/nrlc.ai-Coverage-Drilldown-2025-12-18 (1)/Table.csv';
$outputCsv = $argv[2] ?? __DIR__ . '/gsc_redirect_remediation_report.csv';

if (!file_exists($gscTableCsv)) {
  die("Error: GSC Table CSV not found: $gscTableCsv\n");
}

$results = [];
$stats = [
  'total' => 0,
  'http_instead_of_https' => 0,
  'missing_locale_prefix' => 0,
  'invalid_query_params' => 0,
  'products_path' => 0,
  'careers_path' => 0,
  'other' => 0
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
  
  $issueType = 'other';
  $canonicalUrl = null;
  $action = 'investigate';
  
  // Check for HTTP instead of HTTPS
  if (strpos($url, 'http://') === 0) {
    $stats['http_instead_of_https']++;
    $issueType = 'http_instead_of_https';
    $canonicalUrl = str_replace('http://', 'https://', $url);
    $action = 'redirect_301_https';
  }
  // Check for missing locale prefix
  elseif (preg_match('#^https://nrlc\.ai/(services|careers|products|insights|about|contact)(/|$)#i', $url, $m)) {
    $stats['missing_locale_prefix']++;
    $issueType = 'missing_locale_prefix';
    
    // Determine canonical locale based on path
    $path = parse_url($url, PHP_URL_PATH);
    $query = parse_url($url, PHP_URL_QUERY);
    
    // Check if it's a LOCAL page (has city)
    if (preg_match('#/(services|careers)/([^/]+)/([^/]+)/#', $path, $pathMatch)) {
      $citySlug = $pathMatch[3];
      require_once __DIR__ . '/../lib/helpers.php';
      $canonicalLocale = function_exists('get_canonical_locale_for_city') 
        ? get_canonical_locale_for_city($citySlug) 
        : 'en-us';
      
      // For UK cities with service pages, enforce local-seo-ai service
      if ($pathMatch[1] === 'services' && function_exists('is_uk_city') && is_uk_city($citySlug)) {
        $canonicalUrl = 'https://nrlc.ai/' . $canonicalLocale . '/services/local-seo-ai/' . $citySlug . '/';
      } else {
        $canonicalUrl = 'https://nrlc.ai/' . $canonicalLocale . $path;
      }
    } else {
      // GLOBAL page - default to en-us
      $canonicalUrl = 'https://nrlc.ai/en-us' . $path;
    }
    
    if ($query) {
      $canonicalUrl .= '?' . $query;
    }
    
    $action = 'redirect_301_locale';
  }
  // Check for products path (should redirect or noindex)
  elseif (strpos($url, '/products/') !== false) {
    $stats['products_path']++;
    $issueType = 'products_path';
    $canonicalUrl = 'https://nrlc.ai/en-us/';
    $action = 'redirect_301_home';
  }
  // Check for invalid query params
  elseif (strpos($url, '?q=%7Bsearch_term_string%7D') !== false || 
          strpos($url, '?q={search_term_string}') !== false) {
    $stats['invalid_query_params']++;
    $issueType = 'invalid_query_params';
    $canonicalUrl = preg_replace('#\?.*$#', '', $url);
    $action = 'redirect_301_clean';
  }
  // Check for careers path without locale (should have locale)
  elseif (preg_match('#^https://nrlc\.ai/careers/#', $url)) {
    $stats['careers_path']++;
    $issueType = 'careers_path_missing_locale';
    $path = parse_url($url, PHP_URL_PATH);
    $canonicalUrl = 'https://nrlc.ai/en-us' . $path;
    $action = 'redirect_301_locale';
  }
  else {
    $stats['other']++;
    $issueType = 'other';
    $canonicalUrl = $url;
    $action = 'investigate';
  }
  
  $results[] = [
    'url' => $url,
    'last_crawled' => $lastCrawled,
    'issue_type' => $issueType,
    'canonical_url' => $canonicalUrl,
    'action' => $action,
    'status' => 'needs_fix'
  ];
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
  'Issue Type',
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
echo "\n=== GSC Redirect Pages Remediation Report ===\n\n";
echo "Total URLs analyzed: {$stats['total']}\n";
echo "\n";
echo "Issue breakdown:\n";
echo "  - HTTP instead of HTTPS: {$stats['http_instead_of_https']}\n";
echo "  - Missing locale prefix: {$stats['missing_locale_prefix']}\n";
echo "  - Invalid query params: {$stats['invalid_query_params']}\n";
echo "  - Products path: {$stats['products_path']}\n";
echo "  - Careers path (missing locale): {$stats['careers_path']}\n";
echo "  - Other: {$stats['other']}\n";
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

