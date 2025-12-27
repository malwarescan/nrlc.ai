<?php
/**
 * Analyze "Alternate page with proper canonical tag" GSC data
 */

$csvFile = '/Users/malware/Downloads/nrlc.ai-Coverage-Drilldown-2025-12-27 (4)/Table.csv';

if (!file_exists($csvFile)) {
    die("CSV file not found: $csvFile\n");
}

$urls = [];
$handle = fopen($csvFile, 'r');
if ($handle === false) {
    die("Could not open CSV file\n");
}

// Skip header
fgetcsv($handle);

while (($row = fgetcsv($handle)) !== false) {
    if (isset($row[0])) {
        $urls[] = $row[0];
    }
}
fclose($handle);

echo "=== Alternate Page with Proper Canonical Tag Analysis ===\n\n";
echo "Total URLs: " . count($urls) . "\n\n";

// Categorize URLs
$categories = [
    'service_city_multilocale' => [],
    'career_multilocale' => [],
    'query_params' => [],
    'index_pages' => [],
    'other' => []
];

$localeCounts = [];
$serviceCityCombos = [];

foreach ($urls as $url) {
    // Extract locale
    if (preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})/#', $url, $m)) {
        $locale = $m[1];
        $localeCounts[$locale] = ($localeCounts[$locale] ?? 0) + 1;
    }
    
    // Service+city pages
    if (preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})/services/([^/]+)/([^/]+)/#', $url, $m)) {
        $locale = $m[1];
        $service = $m[2];
        $city = $m[3];
        $key = "$service/$city";
        if (!isset($serviceCityCombos[$key])) {
            $serviceCityCombos[$key] = [];
        }
        $serviceCityCombos[$key][] = $locale;
        $categories['service_city_multilocale'][] = $url;
    }
    // Career pages
    elseif (preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})/careers/([^/]+)/([^/]+)/#', $url, $m)) {
        $locale = $m[1];
        $city = $m[2];
        $role = $m[3];
        $categories['career_multilocale'][] = $url;
    }
    // Query parameters
    elseif (strpos($url, '?') !== false) {
        $categories['query_params'][] = $url;
    }
    // Index pages
    elseif (preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})/?$#', $url) || 
            preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})/(services|careers|ai-visibility)/?$#', $url)) {
        $categories['index_pages'][] = $url;
    }
    else {
        $categories['other'][] = $url;
    }
}

echo "=== URL Categories ===\n";
foreach ($categories as $category => $items) {
    $count = count($items);
    if ($count > 0) {
        $percentage = count($urls) > 0 ? round(($count / count($urls)) * 100, 1) : 0;
        echo sprintf("%-30s: %5d (%5.1f%%)\n", ucfirst(str_replace('_', ' ', $category)), $count, $percentage);
    }
}
echo "\n";

echo "=== Locale Distribution ===\n";
arsort($localeCounts);
foreach ($localeCounts as $locale => $count) {
    $percentage = count($urls) > 0 ? round(($count / count($urls)) * 100, 1) : 0;
    echo sprintf("%-10s: %5d (%5.1f%%)\n", $locale, $count, $percentage);
}
echo "\n";

// Find service+city combos with multiple locales
$multiLocaleCombos = [];
foreach ($serviceCityCombos as $combo => $locales) {
    if (count($locales) > 1) {
        $multiLocaleCombos[$combo] = $locales;
    }
}

echo "=== Service+City Combinations with Multiple Locales ===\n";
echo "Total unique service+city combos: " . count($serviceCityCombos) . "\n";
echo "Combos with multiple locales: " . count($multiLocaleCombos) . "\n";
echo "\n";

// Sample some multi-locale combos
echo "Sample multi-locale service+city combinations (first 10):\n";
$sampleCount = 0;
foreach ($multiLocaleCombos as $combo => $locales) {
    if ($sampleCount++ >= 10) break;
    echo "  $combo: " . implode(', ', $locales) . "\n";
}
echo "\n";

// Check for UK cities in non-en-gb locales
echo "=== UK Cities in Non-en-gb Locales ===\n";
require_once __DIR__.'/lib/helpers.php';
$ukCitiesNonGB = [];
foreach ($urls as $url) {
    if (preg_match('#^https://nrlc\.ai/([a-z]{2}-[a-z]{2})/services/([^/]+)/([^/]+)/#', $url, $m)) {
        $locale = $m[1];
        $city = $m[3];
        if (function_exists('is_uk_city') && is_uk_city($city) && $locale !== 'en-gb') {
            $key = "$city";
            if (!isset($ukCitiesNonGB[$key])) {
                $ukCitiesNonGB[$key] = [];
            }
            $ukCitiesNonGB[$key][] = $locale;
        }
    }
}
echo "UK cities found in non-en-gb locales: " . count($ukCitiesNonGB) . "\n";
if (count($ukCitiesNonGB) > 0) {
    echo "Sample (first 10):\n";
    $sampleCount = 0;
    foreach ($ukCitiesNonGB as $city => $locales) {
        if ($sampleCount++ >= 10) break;
        echo "  $city: " . implode(', ', array_unique($locales)) . "\n";
    }
}
echo "\n";

echo "=== Root Cause Analysis ===\n";
echo "1. 'Alternate page with proper canonical tag' means:\n";
echo "   - These pages have canonical tags pointing to other pages (correct)\n";
echo "   - But Google is flagging them as 'alternate' pages\n";
echo "   - This is expected for non-canonical locale versions\n";
echo "\n";
echo "2. Current Implementation:\n";
echo "   - Non-canonical locale versions should redirect (301) to canonical version\n";
echo "   - If redirects are working, these URLs shouldn't be accessible\n";
echo "   - If they ARE accessible, they should have noindex + canonical tag\n";
echo "\n";
echo "3. Issue:\n";
echo "   - " . count($multiLocaleCombos) . " service+city combos exist in multiple locales\n";
echo "   - These should redirect to canonical locale (UK → en-gb, others → en-us)\n";
echo "   - If redirects aren't working, these pages are being served with canonical tags\n";
echo "\n";

echo "=== Recommendations ===\n";
echo "1. Verify redirects are working for non-canonical locale versions\n";
echo "2. If redirects work, these URLs shouldn't be accessible (should be 301 redirects)\n";
echo "3. If redirects don't work, ensure noindex + canonical tag is set\n";
echo "4. This issue may resolve itself as Google re-crawls and follows redirects\n";

