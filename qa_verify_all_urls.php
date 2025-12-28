<?php
/**
 * Comprehensive URL-by-URL Verification
 * Tests every URL in Pages.csv or sitemap to verify fixes work
 * 
 * Usage:
 *   php qa_verify_all_urls.php [--mode=sitemap|pages] [--sitemap-index=path] [--base=url] [--out=csv] [--summary=md]
 */

error_reporting(E_ALL & ~E_DEPRECATED);

require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/sitemap.php';

// Parse CLI arguments
$options = [
    'mode' => 'pages', // 'pages' or 'sitemap'
    'sitemap-index' => __DIR__ . '/public/sitemaps/sitemap-index.xml',
    'base' => 'http://localhost:8000',
    'out' => __DIR__ . '/qa_url_verification_results.csv',
    'summary' => __DIR__ . '/QA_COMPLETE_VERIFICATION.md'
];

for ($i = 1; $i < $argc; $i++) {
    if (strpos($argv[$i], '--') === 0) {
        $parts = explode('=', $argv[$i], 2);
        $key = substr($parts[0], 2);
        $value = $parts[1] ?? true;
        $options[$key] = $value;
    }
}

$pagesCsv = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-28 (1)/Pages.csv';

echo "=== COMPREHENSIVE URL VERIFICATION ===\n\n";
echo "Mode: {$options['mode']}\n";
echo "Base URL: {$options['base']}\n\n";

// Load pages based on mode
$pages = [];
if ($options['mode'] === 'sitemap') {
    // Load from sitemap
    $sitemapIndex = $options['sitemap-index'];
    if (!file_exists($sitemapIndex)) {
        die("Sitemap index not found: $sitemapIndex\n");
    }
    
    $indexContent = file_get_contents($sitemapIndex);
    preg_match_all('#<loc>(https://nrlc\.ai/sitemaps/[^<]+)</loc>#', $indexContent, $matches);
    $sitemapDir = dirname($sitemapIndex);
    
    foreach ($matches[1] as $sitemapUrl) {
        $filename = basename(parse_url($sitemapUrl, PHP_URL_PATH));
        $sitemapPath = $sitemapDir . '/' . $filename;
        if (!file_exists($sitemapPath)) {
            $sitemapPath = str_replace('.gz', '', $sitemapPath);
        }
        if (file_exists($sitemapPath)) {
            $content = file_get_contents($sitemapPath);
            if (substr($filename, -3) === '.gz') {
                $content = gzdecode($content);
            }
            preg_match_all('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $content, $urlMatches);
            foreach ($urlMatches[1] as $url) {
                $pages[] = ['url' => $url];
            }
        }
    }
    echo "Loaded " . count($pages) . " URLs from sitemap\n\n";
} else {
    // Load from Pages.csv
    if (!file_exists($pagesCsv)) {
        die("Pages.csv not found: $pagesCsv\n");
    }
    
    $handle = fopen($pagesCsv, 'r');
    fgetcsv($handle); // Skip header
    while (($row = fgetcsv($handle)) !== false) {
        if (isset($row[0])) {
            $pages[] = [
                'url' => $row[0],
                'clicks' => (int)($row[1] ?? 0),
                'impressions' => (int)($row[2] ?? 0),
                'ctr' => $row[3] ?? '0%',
                'position' => (float)($row[4] ?? 0)
            ];
        }
    }
    fclose($handle);
    echo "Loaded " . count($pages) . " URLs from Pages.csv\n\n";
}

// Load sitemap
$sitemapFile = __DIR__ . '/public/sitemaps/services-1.xml';
$sitemapUrls = [];
if (file_exists($sitemapFile)) {
    $sitemapContent = file_get_contents($sitemapFile);
    preg_match_all('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $sitemapContent, $matches);
    $sitemapUrls = $matches[1] ?? [];
}
echo "Loaded " . count($sitemapUrls) . " URLs from sitemap\n\n";

// Start local server if not running
$serverRunning = @file_get_contents('http://localhost:8000/healthz') !== false;
if (!$serverRunning) {
    echo "⚠️  Local server not running. Starting...\n";
    exec('cd ' . escapeshellarg(__DIR__) . ' && php -S localhost:8000 -t public > /dev/null 2>&1 &');
    sleep(2);
}

$results = [];
$passCount = 0;
$failCount = 0;
$skipCount = 0;

foreach ($pages as $idx => $page) {
    $url = $page['url'];
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    // Skip non-service pages for now
    if (!preg_match('#/services/#', $path)) {
        $skipCount++;
        continue;
    }
    
    // Extract locale, city, service
    $locale = null;
    if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $path, $m)) {
        $locale = strtolower($m[1]);
    }
    
    $citySlug = null;
    $serviceSlug = null;
    if (preg_match('#/services/([^/]+)/([^/]+)/#', $path, $m)) {
        $serviceSlug = $m[1];
        $citySlug = $m[2];
    }
    
    if (!$citySlug) {
        $skipCount++;
        continue;
    }
    
    // Determine expected canonical
    $isUK = is_uk_city($citySlug);
    $expectedLocale = $isUK ? 'en-gb' : 'en-us';
    $canonicalUrl = "https://nrlc.ai/$expectedLocale/services/$serviceSlug/$citySlug/";
    
    // Test results
    $testResults = [
        'url' => $url,
        'locale' => $locale ?? 'none',
        'city' => $citySlug,
        'expected_locale' => $expectedLocale,
        'canonical_url' => $canonicalUrl,
        'is_canonical' => ($locale === $expectedLocale),
        'redirect_works' => null,
        'canonical_in_sitemap' => in_array($canonicalUrl, $sitemapUrls),
        'non_canonical_in_sitemap' => in_array($url, $sitemapUrls),
        'issues' => []
    ];
    
    // Test 1: If non-canonical, should redirect
    if ($locale && $locale !== $expectedLocale) {
        // Test redirect (using configured base URL)
        $baseUrl = rtrim($options['base'], '/');
        $localUrl = str_replace('https://nrlc.ai', $baseUrl, $url);
        $context = stream_context_create([
            'http' => [
                'method' => 'HEAD',
                'follow_location' => false,
                'ignore_errors' => true
            ]
        ]);
        
        $headers = @get_headers($localUrl, 1, $context);
        if ($headers) {
            $statusCode = (int)substr($headers[0], 9, 3);
            $location = $headers['Location'] ?? $headers['location'] ?? null;
            
            if ($statusCode === 301 || $statusCode === 302) {
                $testResults['redirect_works'] = true;
                $testResults['redirect_to'] = is_array($location) ? $location[0] : $location;
                
                // Check if redirect goes to canonical
                $redirectToCanonical = false;
                if ($location) {
                    $redirectLocation = is_array($location) ? $location[0] : $location;
                    $redirectPath = parse_url($redirectLocation, PHP_URL_PATH);
                    $canonicalPath = parse_url($canonicalUrl, PHP_URL_PATH);
                    // Normalize paths (remove trailing slashes for comparison)
                    $redirectPath = rtrim($redirectPath, '/');
                    $canonicalPath = rtrim($canonicalPath, '/');
                    // Check if redirect path matches canonical path (ignoring domain and scheme)
                    // Normalize both paths for comparison
                    $redirectPathNormalized = rtrim($redirectPath, '/') . '/';
                    $canonicalPathNormalized = rtrim($canonicalPath, '/') . '/';
                    $expectedPathPattern = "/$expectedLocale/services/$serviceSlug/$citySlug/";
                    
                    if ($redirectPathNormalized === $canonicalPathNormalized || 
                        $redirectPathNormalized === $expectedPathPattern ||
                        strpos($redirectPathNormalized, $expectedPathPattern) === 0) {
                        $redirectToCanonical = true;
                    }
                }
                $testResults['redirect_to_canonical'] = $redirectToCanonical;
                
                if (!$redirectToCanonical) {
                    $testResults['issues'][] = 'Redirect does not go to canonical';
                }
            } else {
                $testResults['redirect_works'] = false;
                $testResults['issues'][] = "Non-canonical URL does not redirect (status: $statusCode)";
            }
        } else {
            $testResults['redirect_works'] = false;
            $testResults['issues'][] = 'Could not test redirect (server not accessible)';
        }
    }
    
    // Test 2: Canonical should be in sitemap
    if (!$testResults['canonical_in_sitemap']) {
        $testResults['issues'][] = 'Canonical URL not in sitemap';
    }
    
    // Test 3: Non-canonical should NOT be in sitemap
    if ($testResults['non_canonical_in_sitemap'] && $locale && $locale !== $expectedLocale) {
        $testResults['issues'][] = 'Non-canonical URL incorrectly in sitemap';
    }
    
    // Test 4: If canonical, should be accessible
    if ($testResults['is_canonical']) {
        $baseUrl = rtrim($options['base'], '/');
        $localCanonical = str_replace('https://nrlc.ai', $baseUrl, $canonicalUrl);
        $headers = @get_headers($localCanonical, 1);
        if ($headers) {
            $statusCode = (int)substr($headers[0], 9, 3);
            if ($statusCode !== 200) {
                $testResults['issues'][] = "Canonical URL returns status $statusCode";
            }
        }
    }
    
    // Determine pass/fail and severity
    $testResults['status'] = empty($testResults['issues']) ? 'PASS' : 'FAIL';
    
    // Determine severity
    $testResults['severity'] = 'info';
    if (!empty($testResults['issues'])) {
        $criticalPatterns = [
            'Canonical URL not in sitemap',
            'Non-canonical URL incorrectly in sitemap',
            'Redirect does not go to canonical',
            'Canonical URL returns status',
            'Locale mismatch'
        ];
        foreach ($testResults['issues'] as $issue) {
            foreach ($criticalPatterns as $pattern) {
                if (stripos($issue, $pattern) !== false) {
                    $testResults['severity'] = 'critical';
                    break 2;
                }
            }
        }
        if ($testResults['severity'] !== 'critical') {
            $testResults['severity'] = 'warning';
        }
    }
    
    if ($testResults['status'] === 'PASS') {
        $passCount++;
    } else {
        $failCount++;
    }
    
    $results[] = $testResults;
    
    // Progress indicator
    if (($idx + 1) % 100 === 0) {
        echo "Processed " . ($idx + 1) . " / " . count($pages) . " URLs...\n";
    }
}

echo "\n=== VERIFICATION RESULTS ===\n\n";
echo "Total URLs tested: " . count($results) . "\n";
echo "Skipped (non-service pages): $skipCount\n";
echo "PASS: $passCount\n";
echo "FAIL: $failCount\n";
echo "\n";

// Summary by issue type
$issueTypes = [];
foreach ($results as $result) {
    foreach ($result['issues'] as $issue) {
        $issueTypes[$issue] = ($issueTypes[$issue] ?? 0) + 1;
    }
}

if (!empty($issueTypes)) {
    echo "=== ISSUE BREAKDOWN ===\n\n";
    arsort($issueTypes);
    foreach ($issueTypes as $issue => $count) {
        echo "  $issue: $count\n";
    }
    echo "\n";
}

// Show sample failures
$failures = array_filter($results, fn($r) => $r['status'] === 'FAIL');
if (!empty($failures)) {
    echo "=== SAMPLE FAILURES (First 20) ===\n\n";
    $sample = array_slice($failures, 0, 20);
    foreach ($sample as $failure) {
        echo "URL: {$failure['url']}\n";
        echo "  Locale: {$failure['locale']}, Expected: {$failure['expected_locale']}\n";
        echo "  Issues: " . implode(', ', $failure['issues']) . "\n";
        echo "\n";
    }
    if (count($failures) > 20) {
        echo "... and " . (count($failures) - 20) . " more failures\n\n";
    }
}

// Export results
$exportFile = $options['out'];
$handle = fopen($exportFile, 'w');
fputcsv($handle, ['URL', 'Locale', 'Expected Locale', 'Is Canonical', 'Redirect Works', 'Canonical In Sitemap', 'Non-Canonical In Sitemap', 'Issues', 'Status', 'Severity']);
foreach ($results as $result) {
    fputcsv($handle, [
        $result['url'],
        $result['locale'],
        $result['expected_locale'],
        $result['is_canonical'] ? 'Yes' : 'No',
        $result['redirect_works'] === null ? 'N/A' : ($result['redirect_works'] ? 'Yes' : 'No'),
        $result['canonical_in_sitemap'] ? 'Yes' : 'No',
        $result['non_canonical_in_sitemap'] ? 'Yes' : 'No',
        implode('; ', $result['issues']),
        $result['status'],
        $result['severity'] ?? 'info'
    ]);
}
fclose($handle);

echo "Results exported to: $exportFile\n";
echo "\n";

// Final verdict
if ($failCount === 0) {
    echo "✅ ALL TESTS PASSED\n";
    exit(0);
} else {
    echo "❌ $failCount TESTS FAILED\n";
    echo "\nReview failures and fix issues.\n";
    exit(1);
}

