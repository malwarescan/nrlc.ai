<?php
/**
 * GSC "Crawled - currently not indexed" Remediation Script
 * 
 * Analyzes GSC data to identify why pages are crawled but not indexed.
 */

require_once __DIR__.'/../lib/helpers.php';

$gscFile = $argv[1] ?? __DIR__.'/../Downloads/nrlc.ai-Coverage-Drilldown-2025-12-18 (3)/Table.csv';
$outputFile = __DIR__.'/gsc_not_indexed_remediation_report.csv';

if (!file_exists($gscFile)) {
  die("GSC file not found: $gscFile\n");
}

echo "Analyzing GSC 'not indexed' data...\n";

$handle = fopen($gscFile, 'r');
if (!$handle) {
  die("Cannot read GSC file: $gscFile\n");
}

// Skip header
fgetcsv($handle, 0, ',', '"', '');

$output = fopen($outputFile, 'w');
fputcsv($output, ['URL', 'Issue Type', 'Root Cause', 'Action', 'Priority'], ',', '"', '');

$stats = [
  'total' => 0,
  'missing_locale' => 0,
  'http_instead_https' => 0,
  'non_canonical_locale' => 0,
  'api_endpoints' => 0,
  'sitemaps' => 0,
  'favicon' => 0,
  'other' => 0
];

while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
  $url = $row[0] ?? '';
  if (empty($url)) continue;
  
  $stats['total']++;
  
  // Parse URL
  $parsed = parse_url($url);
  $scheme = $parsed['scheme'] ?? 'https';
  $path = $parsed['path'] ?? '/';
  
  $issueType = 'other';
  $rootCause = 'unknown';
  $action = 'investigate';
  $priority = 'low';
  
  // Check for HTTP instead of HTTPS
  if ($scheme === 'http') {
    $issueType = 'http_instead_https';
    $rootCause = 'HTTP URLs should redirect to HTTPS';
    $action = 'redirect_301_https';
    $priority = 'high';
    $stats['http_instead_https']++;
  }
  // Check for missing locale prefix
  else if (!preg_match('#^/([a-z]{2}-[a-z]{2})(/|$)#i', $path) && $path !== '/') {
    // Exclude API endpoints, sitemaps, favicon
    if (preg_match('#^/(api|sitemaps|favicon)#i', $path)) {
      if (preg_match('#^/api/#', $path)) {
        $issueType = 'api_endpoints';
        $rootCause = 'API endpoints should not be indexed';
        $action = 'noindex_or_robots_disallow';
        $priority = 'medium';
        $stats['api_endpoints']++;
      } else if (preg_match('#^/sitemaps/#', $path)) {
        $issueType = 'sitemaps';
        $rootCause = 'Sitemap files should not be indexed';
        $action = 'noindex_or_robots_disallow';
        $priority = 'low';
        $stats['sitemaps']++;
      } else if (preg_match('#^/favicon#', $path)) {
        $issueType = 'favicon';
        $rootCause = 'Favicon files should not be indexed';
        $action = 'noindex_or_robots_disallow';
        $priority = 'low';
        $stats['favicon']++;
      }
    } else {
      $issueType = 'missing_locale';
      $rootCause = 'URL missing locale prefix - should redirect to /en-us/ version';
      $action = 'redirect_301_locale';
      $priority = 'high';
      $stats['missing_locale']++;
    }
  }
  // Check for non-canonical locale versions of LOCAL pages
  else if (preg_match('#^/([a-z]{2}-[a-z]{2})(.+)$#i', $path, $m)) {
    $currentLocale = strtolower($m[1]);
    $pathWithoutLocale = $m[2];
    
    // Check if LOCAL page
    if (function_exists('is_local_page') && is_local_page($pathWithoutLocale)) {
      // Determine canonical locale
      if (function_exists('get_canonical_locale_for_city')) {
        if (preg_match('#/services/[^/]+/([^/]+)/#', $pathWithoutLocale, $cityMatch)) {
          $citySlug = $cityMatch[1];
          $canonicalLocale = get_canonical_locale_for_city($citySlug);
          
          if ($currentLocale !== $canonicalLocale) {
            $issueType = 'non_canonical_locale';
            $rootCause = "Non-canonical locale ($currentLocale) for LOCAL page - should be $canonicalLocale";
            $action = 'redirect_301_canonical';
            $priority = 'high';
            $stats['non_canonical_locale']++;
          }
        } else if (preg_match('#/careers/([^/]+)/#', $pathWithoutLocale, $cityMatch)) {
          $citySlug = $cityMatch[1];
          $canonicalLocale = get_canonical_locale_for_city($citySlug);
          
          if ($currentLocale !== $canonicalLocale) {
            $issueType = 'non_canonical_locale';
            $rootCause = "Non-canonical locale ($currentLocale) for LOCAL page - should be $canonicalLocale";
            $action = 'redirect_301_canonical';
            $priority = 'high';
            $stats['non_canonical_locale']++;
          }
        }
      }
    }
  }
  
  // If no specific issue found, mark as other
  if ($issueType === 'other') {
    $rootCause = 'Unknown - needs manual investigation';
    $action = 'investigate';
    $priority = 'low';
    $stats['other']++;
  }
  
  fputcsv($output, [
    $url,
    $issueType,
    $rootCause,
    $action,
    $priority
  ], ',', '"', '');
}

fclose($handle);
fclose($output);

echo "\nAnalysis complete!\n";
echo "Total URLs analyzed: {$stats['total']}\n";
echo "Missing locale prefix: {$stats['missing_locale']}\n";
echo "HTTP instead of HTTPS: {$stats['http_instead_https']}\n";
echo "Non-canonical locale: {$stats['non_canonical_locale']}\n";
echo "API endpoints: {$stats['api_endpoints']}\n";
echo "Sitemaps: {$stats['sitemaps']}\n";
echo "Favicon: {$stats['favicon']}\n";
echo "Other: {$stats['other']}\n";
echo "\nReport saved to: $outputFile\n";

