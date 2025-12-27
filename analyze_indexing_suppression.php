<?php
/**
 * Analyze Google Search Console indexing suppression data
 * Identifies patterns in URLs that are crawled but not indexed
 */

$csvFile = '/Users/malware/Downloads/nrlc.ai-Coverage-Drilldown-2025-12-27 (1)/Table.csv';

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

echo "=== Indexing Suppression Analysis ===\n\n";
echo "Total URLs: " . count($urls) . "\n\n";

// Categorize URLs
$categories = [
    'with_locale' => [],
    'without_locale' => [],
    'http' => [],
    'api' => [],
    'products' => [],
    'careers' => [],
    'insights' => [],
    'resources' => [],
    'other' => []
];

foreach ($urls as $url) {
    if (strpos($url, 'http://') === 0) {
        $categories['http'][] = $url;
    } elseif (strpos($url, '/api/') !== false) {
        $categories['api'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/(en-us|en-gb|es-es|fr-fr|de-de|ko-kr)/#', $url)) {
        $categories['with_locale'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/services/#', $url)) {
        $categories['without_locale'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/(en-us|en-gb|es-es|fr-fr|de-de|ko-kr)/products/#', $url)) {
        $categories['products'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/(en-us|en-gb|es-es|fr-fr|de-de|ko-kr)/careers/#', $url)) {
        $categories['careers'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/(en-us|en-gb|es-es|fr-fr|de-de|ko-kr)/insights/#', $url)) {
        $categories['insights'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/(en-us|en-gb|es-es|fr-fr|de-de|ko-kr)/resources/#', $url)) {
        $categories['resources'][] = $url;
    } else {
        $categories['other'][] = $url;
    }
}

// Service page analysis
$servicePages = array_filter($urls, function($url) {
    return preg_match('#/services/[^/]+/[^/]+/#', $url);
});

$servicePatterns = [];
foreach ($servicePages as $url) {
    if (preg_match('#/services/([^/]+)/([^/]+)/#', $url, $m)) {
        $service = $m[1];
        $city = $m[2];
        $key = "$service:$city";
        if (!isset($servicePatterns[$key])) {
            $servicePatterns[$key] = [];
        }
        $servicePatterns[$key][] = $url;
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

// Print analysis
echo "=== URL Categories ===\n";
foreach ($categories as $category => $items) {
    $count = count($items);
    $percentage = count($urls) > 0 ? round(($count / count($urls)) * 100, 1) : 0;
    echo sprintf("%-20s: %4d (%5.1f%%)\n", ucfirst($category), $count, $percentage);
    if ($count > 0 && $count <= 10) {
        foreach ($items as $item) {
            echo "  - $item\n";
        }
    } elseif ($count > 10) {
        echo "  (showing first 5 examples)\n";
        foreach (array_slice($items, 0, 5) as $item) {
            echo "  - $item\n";
        }
    }
}
echo "\n";

echo "=== Locale Distribution ===\n";
arsort($localeCounts);
foreach ($localeCounts as $locale => $count) {
    $percentage = count($urls) > 0 ? round(($count / count($urls)) * 100, 1) : 0;
    echo sprintf("%-10s: %4d (%5.1f%%)\n", $locale, $count, $percentage);
}
echo "\n";

echo "=== Service Page Patterns ===\n";
echo "Total service pages: " . count($servicePages) . "\n";
echo "Unique service+city combinations: " . count($servicePatterns) . "\n";

// Find duplicate service+city combinations across locales
$duplicateCombos = [];
foreach ($servicePatterns as $key => $urls) {
    if (count($urls) > 1) {
        $duplicateCombos[$key] = $urls;
    }
}

if (count($duplicateCombos) > 0) {
    echo "Service+city combinations with multiple locale versions: " . count($duplicateCombos) . "\n";
    echo "\nFirst 10 examples:\n";
    $i = 0;
    foreach ($duplicateCombos as $key => $urls) {
        if ($i++ >= 10) break;
        list($service, $city) = explode(':', $key);
        echo "  $service / $city:\n";
        foreach ($urls as $url) {
            echo "    - $url\n";
        }
    }
}
echo "\n";

echo "=== Issues Identified ===\n";
$issues = [];

if (count($categories['http']) > 0) {
    $issues[] = sprintf("HTTP URLs (should be HTTPS): %d URLs", count($categories['http']));
}

if (count($categories['without_locale']) > 0) {
    $issues[] = sprintf("URLs without locale prefix (should redirect): %d URLs", count($categories['without_locale']));
}

if (count($categories['api']) > 0) {
    $issues[] = sprintf("API endpoints (should be noindex): %d URLs", count($categories['api']));
}

if (count($duplicateCombos) > 0) {
    $issues[] = sprintf("Service+city combinations with multiple locale versions: %d combinations", count($duplicateCombos));
}

if (count($servicePages) > 0) {
    $issues[] = sprintf("Service pages with city slugs: %d URLs (potential duplicate/low-value content)", count($servicePages));
}

foreach ($issues as $issue) {
    echo "  ⚠️  $issue\n";
}
echo "\n";

echo "=== Recommendations ===\n";
echo "1. Ensure all HTTP URLs redirect to HTTPS (301)\n";
echo "2. Ensure all URLs without locale prefix redirect to locale version (301)\n";
echo "3. Add noindex to API endpoints (/api/*)\n";
echo "4. Review service+city page content differentiation\n";
echo "5. Consider consolidating or improving service+city pages\n";
echo "6. Check if non-English locales (de-de, es-es, fr-fr, ko-kr) have sufficient unique content\n";

