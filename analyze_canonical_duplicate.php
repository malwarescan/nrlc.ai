<?php
/**
 * Analyze "Duplicate, Google chose different canonical than user" issue
 */

$csvFile = '/Users/malware/Downloads/nrlc.ai-Coverage-Drilldown-2025-12-27 (2)/Table.csv';

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

echo "=== Canonical Duplicate Analysis ===\n\n";
echo "Total URLs: " . count($urls) . "\n\n";

// Extract service+city combinations
$serviceCityCombos = [];
foreach ($urls as $url) {
    if (preg_match('#^https://nrlc\.ai/([^/]+)/services/([^/]+)/([^/]+)/#', $url, $m)) {
        $locale = $m[1];
        $service = $m[2];
        $city = $m[3];
        $key = "$service:$city";
        if (!isset($serviceCityCombos[$key])) {
            $serviceCityCombos[$key] = [];
        }
        $serviceCityCombos[$key][] = $locale;
    }
}

// Find combinations with multiple locales
$multiLocaleCombos = [];
foreach ($serviceCityCombos as $key => $locales) {
    if (count($locales) > 1) {
        $multiLocaleCombos[$key] = $locales;
    }
}

// Locale distribution
$localeCounts = [];
foreach ($urls as $url) {
    if (preg_match('#^https://nrlc\.ai/([^/]+)/#', $url, $m)) {
        $locale = $m[1];
        if (preg_match('#^[a-z]{2}-[a-z]{2}$#', $locale)) {
            $localeCounts[$locale] = ($localeCounts[$locale] ?? 0) + 1;
        }
    }
}

// UK cities in non-en-gb locales
$ukCities = ['bristol', 'brighton', 'halifax', 'southampton', 'derby', 'cambridge', 'sudbury', 'middlesbrough', 'manchester', 'sheffield', 'coventry', 'london', 'cardiff', 'birmingham', 'newcastle', 'hull', 'glasgow', 'edinburgh', 'norwich', 'leicester', 'peterborough', 'burnley', 'huddersfield', 'southend-on-sea', 'wolverhampton', 'plymouth', 'blackpool', 'stoke-on-trent', 'northampton', 'swansea', 'southport', 'oldham', 'stockport', 'west-bromwich', 'warabi'];
$ukCityIssues = [];
foreach ($urls as $url) {
    if (preg_match('#^https://nrlc\.ai/([^/]+)/services/([^/]+)/([^/]+)/#', $url, $m)) {
        $locale = $m[1];
        $city = $m[3];
        if (in_array($city, $ukCities) && $locale !== 'en-gb') {
            $key = "$city:$locale";
            if (!isset($ukCityIssues[$key])) {
                $ukCityIssues[$key] = [];
            }
            $ukCityIssues[$key][] = $url;
        }
    }
}

echo "=== Locale Distribution ===\n";
arsort($localeCounts);
foreach ($localeCounts as $locale => $count) {
    $percentage = count($urls) > 0 ? round(($count / count($urls)) * 100, 1) : 0;
    echo sprintf("%-10s: %4d (%5.1f%%)\n", $locale, $count, $percentage);
}
echo "\n";

echo "=== Service+City Combinations ===\n";
echo "Total unique service+city combinations: " . count($serviceCityCombos) . "\n";
echo "Combinations with multiple locales: " . count($multiLocaleCombos) . "\n";
echo "\n";

if (count($multiLocaleCombos) > 0) {
    echo "First 20 multi-locale combinations:\n";
    $i = 0;
    foreach ($multiLocaleCombos as $key => $locales) {
        if ($i++ >= 20) break;
        list($service, $city) = explode(':', $key);
        echo "  $service / $city: " . implode(', ', $locales) . "\n";
    }
    echo "\n";
}

echo "=== UK Cities in Non-en-gb Locales ===\n";
echo "UK cities appearing in non-en-gb locales: " . count($ukCityIssues) . " combinations\n";
if (count($ukCityIssues) > 0) {
    echo "\nFirst 10 examples:\n";
    $i = 0;
    foreach ($ukCityIssues as $key => $urls_list) {
        if ($i++ >= 10) break;
        list($city, $locale) = explode(':', $key);
        echo "  $city in $locale:\n";
        foreach (array_slice($urls_list, 0, 2) as $url) {
            echo "    - $url\n";
        }
    }
}
echo "\n";

echo "=== Root Cause Analysis ===\n";
echo "The 'Duplicate, Google chose different canonical than user' issue occurs when:\n";
echo "1. Multiple locale versions of the same page exist (e.g., en-us and en-gb for same service+city)\n";
echo "2. Each version has a canonical tag pointing to itself\n";
echo "3. Google chooses a different canonical (usually the en-us version) than what the page specifies\n";
echo "\n";
echo "For UK cities, the canonical should be en-gb, but if the page exists in multiple locales,\n";
echo "Google may choose en-us as the canonical, causing this error.\n";
echo "\n";

echo "=== Recommendations ===\n";
echo "1. Ensure UK cities only exist in en-gb locale (redirect others)\n";
echo "2. Ensure non-UK cities only exist in en-us locale (redirect others)\n";
echo "3. Verify canonical tags point to the correct locale version\n";
echo "4. Check that non-canonical locale versions have canonical tags pointing to canonical version\n";

