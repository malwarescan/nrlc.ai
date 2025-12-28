<?php
/**
 * Export QA Results to CSV for Tracking
 */

require_once __DIR__ . '/lib/helpers.php';

$pagesCsv = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-28 (1)/Pages.csv';

if (!file_exists($pagesCsv)) {
    die("Pages.csv not found\n");
}

// Load pages
$pages = [];
$handle = fopen($pagesCsv, 'r');
fgetcsv($handle); // Skip header
while (($row = fgetcsv($handle)) !== false) {
    if (isset($row[0])) {
        $pages[] = $row[0];
    }
}
fclose($handle);

// Classify and check
$results = [];
foreach ($pages as $url) {
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    // Extract locale
    $locale = null;
    if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $path, $m)) {
        $locale = strtolower($m[1]);
    }
    
    // Extract city and service
    $citySlug = null;
    $serviceSlug = null;
    $pageType = 'other';
    
    if (preg_match('#/services/([^/]+)/([^/]+)/#', $path, $m)) {
        $serviceSlug = $m[1];
        $citySlug = $m[2];
        $pageType = 'service_city';
    } elseif (preg_match('#/services/([^/]+)/#', $path, $m)) {
        $serviceSlug = $m[1];
        $pageType = 'service';
    }
    
    // Determine country target
    $countryTarget = 'Global';
    $expectedLocale = null;
    $hasMismatch = false;
    
    if ($citySlug) {
        $isUK = is_uk_city($citySlug);
        $countryTarget = $isUK ? 'UK' : 'US';
        $expectedLocale = $isUK ? 'en-gb' : 'en-us';
        
        if ($locale && $locale !== $expectedLocale) {
            $hasMismatch = true;
        }
    }
    
    // Check sitemap
    $sitemapFile = __DIR__ . '/public/sitemaps/services-1.xml';
    $inSitemap = false;
    if (file_exists($sitemapFile)) {
        $sitemapContent = file_get_contents($sitemapFile);
        $inSitemap = strpos($sitemapContent, $url) !== false;
    }
    
    // Determine canonical URL
    $canonicalUrl = $url;
    if ($citySlug && $expectedLocale && $locale !== $expectedLocale) {
        $canonicalPath = "/$expectedLocale/services/$serviceSlug/$citySlug/";
        $canonicalUrl = "https://nrlc.ai$canonicalPath";
    }
    
    // Check if canonical is in sitemap
    $canonicalInSitemap = false;
    if (file_exists($sitemapFile)) {
        $canonicalInSitemap = strpos($sitemapContent, $canonicalUrl) !== false;
    }
    
    // Issues
    $issues = [];
    if ($hasMismatch) {
        $issues[] = 'Locale mismatch';
    }
    if (!$inSitemap && $pageType === 'service_city') {
        $issues[] = 'Not in sitemap';
    }
    if ($hasMismatch && !$canonicalInSitemap) {
        $issues[] = 'Canonical target not in sitemap';
    }
    
    $results[] = [
        'URL' => $url,
        'Locale' => $locale ?? 'none',
        'Country Target' => $countryTarget,
        'City Target' => $citySlug ?? '',
        'Service' => $serviceSlug ?? '',
        'Page Type' => $pageType,
        'Expected Locale' => $expectedLocale ?? '',
        'Has Mismatch' => $hasMismatch ? 'Yes' : 'No',
        'In Sitemap' => $inSitemap ? 'Yes' : 'No',
        'Canonical URL' => $canonicalUrl,
        'Canonical In Sitemap' => $canonicalInSitemap ? 'Yes' : 'No',
        'Issues' => implode('; ', $issues),
        'Status' => empty($issues) ? 'PASS' : 'FAIL'
    ];
}

// Export to CSV
$outputFile = __DIR__ . '/qa_results_export.csv';
$handle = fopen($outputFile, 'w');

// Write header
fputcsv($handle, array_keys($results[0]));

// Write data
foreach ($results as $row) {
    fputcsv($handle, $row);
}

fclose($handle);

echo "Exported " . count($results) . " results to $outputFile\n";

// Summary
$passCount = count(array_filter($results, fn($r) => $r['Status'] === 'PASS'));
$failCount = count($results) - $passCount;

echo "\nSummary:\n";
echo "  PASS: $passCount\n";
echo "  FAIL: $failCount\n";

