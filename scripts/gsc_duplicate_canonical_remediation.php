<?php
/**
 * GSC "Duplicate, Google chose different canonical than user" Remediation Script
 * 
 * Analyzes GSC data to identify URLs where Google chose a different canonical
 * and determines the correct canonical URL for each.
 */

require_once __DIR__.'/../lib/helpers.php';

$gscFile = $argv[1] ?? __DIR__.'/../Downloads/nrlc.ai-Coverage-Drilldown-2025-12-18 (2)/Table.csv';
$outputFile = __DIR__.'/gsc_duplicate_canonical_remediation_report.csv';

if (!file_exists($gscFile)) {
  die("GSC file not found: $gscFile\n");
}

echo "Analyzing GSC duplicate canonical data...\n";

$handle = fopen($gscFile, 'r');
if (!$handle) {
  die("Cannot read GSC file: $gscFile\n");
}

// Skip header
fgetcsv($handle, 0, ',', '"', '');

$output = fopen($outputFile, 'w');
fputcsv($output, ['URL', 'Current Locale', 'Is Local Page', 'Canonical Locale', 'Correct Canonical URL', 'Issue Type', 'Action'], ',', '"', '');

$stats = [
  'total' => 0,
  'non_canonical_local' => 0,
  'non_canonical_global' => 0,
  'products' => 0,
  'other' => 0
];

while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
  $url = $row[0] ?? '';
  if (empty($url)) continue;
  
  $stats['total']++;
  
  // Parse URL
  $parsed = parse_url($url);
  $path = $parsed['path'] ?? '/';
  
  // Extract locale
  if (preg_match('#^/([a-z]{2}-[a-z]{2})(.+)$#i', $path, $m)) {
    $currentLocale = strtolower($m[1]);
    $pathWithoutLocale = $m[2];
  } else {
    $currentLocale = '';
    $pathWithoutLocale = $path;
  }
  
  $issueType = 'other';
  $action = 'investigate';
  $canonicalLocale = $currentLocale;
  $correctCanonical = $url;
  
  // Check if products path
  if (preg_match('#/products/#', $path)) {
    $issueType = 'products_path';
    $action = 'redirect_301_homepage';
    $correctCanonical = 'https://nrlc.ai/';
    $stats['products']++;
  }
  // Check if LOCAL page
  else if (function_exists('is_local_page') && is_local_page($pathWithoutLocale)) {
    // Determine canonical locale for this LOCAL page
    if (function_exists('get_canonical_locale_for_city')) {
      // Extract city from path
      if (preg_match('#/services/[^/]+/([^/]+)/#', $pathWithoutLocale, $cityMatch)) {
        $citySlug = $cityMatch[1];
        $canonicalLocale = get_canonical_locale_for_city($citySlug);
      } else if (preg_match('#/careers/([^/]+)/#', $pathWithoutLocale, $cityMatch)) {
        $citySlug = $cityMatch[1];
        $canonicalLocale = get_canonical_locale_for_city($citySlug);
      } else {
        $canonicalLocale = 'en-us'; // Default
      }
    } else {
      $canonicalLocale = 'en-us'; // Fallback
    }
    
    if ($currentLocale !== $canonicalLocale) {
      $issueType = 'non_canonical_local';
      $action = 'redirect_301_canonical';
      // Build correct canonical URL
      $correctCanonical = 'https://nrlc.ai' . '/' . $canonicalLocale . $pathWithoutLocale;
      $stats['non_canonical_local']++;
    } else {
      $issueType = 'canonical_local';
      $action = 'keep_indexed';
    }
  }
  // Check if GLOBAL page (insights, blog, etc.)
  else if (preg_match('#^/(insights|blog|resources|industries)/#', $pathWithoutLocale)) {
    // For GLOBAL pages, en-us is typically canonical unless genuinely translated
    // For now, assume en-us is canonical for all GLOBAL pages
    if ($currentLocale !== 'en-us' && $currentLocale !== '') {
      $issueType = 'non_canonical_global';
      $action = 'redirect_301_en_us';
      $correctCanonical = 'https://nrlc.ai/en-us' . $pathWithoutLocale;
      $stats['non_canonical_global']++;
    } else {
      $issueType = 'canonical_global';
      $action = 'keep_indexed';
    }
  }
  // Other pages (careers index, services index, etc.)
  else {
    // For index pages, en-us is typically canonical
    if ($currentLocale !== 'en-us' && $currentLocale !== '') {
      $issueType = 'non_canonical_other';
      $action = 'redirect_301_en_us';
      $correctCanonical = 'https://nrlc.ai/en-us' . $pathWithoutLocale;
      $stats['other']++;
    } else {
      $issueType = 'canonical_other';
      $action = 'keep_indexed';
    }
  }
  
  fputcsv($output, [
    $url,
    $currentLocale ?: 'none',
    function_exists('is_local_page') && is_local_page($pathWithoutLocale) ? 'yes' : 'no',
    $canonicalLocale,
    $correctCanonical,
    $issueType,
    $action
  ], ',', '"', '');
}

fclose($handle);
fclose($output);

echo "\nAnalysis complete!\n";
echo "Total URLs analyzed: {$stats['total']}\n";
echo "Non-canonical LOCAL pages: {$stats['non_canonical_local']}\n";
echo "Non-canonical GLOBAL pages: {$stats['non_canonical_global']}\n";
echo "Products paths: {$stats['products']}\n";
echo "Other issues: {$stats['other']}\n";
echo "\nReport saved to: $outputFile\n";

