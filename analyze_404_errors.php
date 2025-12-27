<?php
/**
 * Analyze 404 errors from Google Search Console
 */

$csvFile = '/Users/malware/Downloads/nrlc.ai-Coverage-Drilldown-2025-12-27 (3)/Table.csv';

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

echo "=== 404 Error Analysis ===\n\n";
echo "Total URLs: " . count($urls) . "\n\n";

// Categorize URLs
$categories = [
    'careers_no_locale' => [],
    'www_subdomain' => [],
    'search_pages' => [],
    'audit_page' => [],
    'other' => []
];

foreach ($urls as $url) {
    if (strpos($url, 'www.nrlc.ai') !== false) {
        $categories['www_subdomain'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/careers/([^/]+)/$#', $url)) {
        $categories['careers_no_locale'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/search#', $url)) {
        $categories['search_pages'][] = $url;
    } elseif (preg_match('#^https://nrlc\.ai/audit#', $url)) {
        $categories['audit_page'][] = $url;
    } else {
        $categories['other'][] = $url;
    }
}

echo "=== URL Categories ===\n";
foreach ($categories as $category => $items) {
    $count = count($items);
    if ($count > 0) {
        $percentage = count($urls) > 0 ? round(($count / count($urls)) * 100, 1) : 0;
        echo sprintf("%-25s: %2d (%5.1f%%)\n", ucfirst(str_replace('_', ' ', $category)), $count, $percentage);
        foreach ($items as $item) {
            echo "  - $item\n";
        }
    }
}
echo "\n";

echo "=== Root Cause Analysis ===\n";
echo "1. Career pages without locale prefix (13 URLs):\n";
echo "   - These URLs should redirect to locale-prefixed careers index\n";
echo "   - Current logic in router.php (line 321-327) tries to redirect, but may fail if locale detection fails\n";
echo "   - Canonical.php should catch these before router, but may not be handling /careers/{city}/ pattern\n";
echo "\n";

echo "2. www.nrlc.ai (1 URL):\n";
echo "   - Should redirect to nrlc.ai (non-www)\n";
echo "   - This is handled in canonical.php and public/index.php\n";
echo "   - May be a Railway edge issue (www subdomain not configured)\n";
echo "\n";

echo "3. Search pages (2 URLs):\n";
echo "   - /search/?q={query} and /search?q={search_term_string}\n";
echo "   - These have query parameters that may not be handled correctly\n";
echo "   - Router has logic at line 75 to handle /search\n";
echo "\n";

echo "4. /audit/ page (1 URL):\n";
echo "   - Router has logic at line 82 to handle this\n";
echo "   - May need to check if redirect is working\n";
echo "\n";

echo "=== Recommendations ===\n";
echo "1. Fix career page redirects - Ensure /careers/{city}/ redirects to locale-prefixed careers index\n";
echo "2. Verify www redirect is working (may be Railway configuration issue)\n";
echo "3. Check search page handling with query parameters\n";
echo "4. Verify /audit/ redirect is working\n";

