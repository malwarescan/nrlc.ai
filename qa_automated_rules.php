<?php
/**
 * Automated Fail-Safe Rules for CI/CD
 * 
 * These rules should be enforced before deployment to prevent
 * canonical collapse and indexing issues.
 */

require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/sitemap.php';

echo "=== AUTOMATED FAIL-SAFE RULES ===\n\n";

$errors = [];
$warnings = [];

// ========================================================================
// RULE 1: No city page without sitemap inclusion
// ========================================================================
echo "Rule 1: Checking city pages are in sitemap...\n";

$sitemapFile = __DIR__ . '/public/sitemaps/services-1.xml';
$sitemapUrls = [];
if (file_exists($sitemapFile)) {
    $sitemapContent = file_get_contents($sitemapFile);
    preg_match_all('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $sitemapContent, $matches);
    $sitemapUrls = $matches[1] ?? [];
}

// Find all service+city pages in codebase
$serviceCityPages = [];
$servicesDir = __DIR__ . '/pages/services';
if (is_dir($servicesDir)) {
    // This is a simplified check - in production, you'd scan routes
    // For now, we'll check sitemap generation logic
}

// Check sitemap includes all UK city pages
$ukCities = ['norwich', 'london', 'manchester', 'birmingham', 'leeds', 'sheffield', 'southampton'];
$testServices = ['local-seo-ai', 'site-audits', 'technical-seo'];

foreach ($testServices as $service) {
    foreach ($ukCities as $city) {
        $expectedUrl = "https://nrlc.ai/en-gb/services/$service/$city/";
        if (!in_array($expectedUrl, $sitemapUrls)) {
            $errors[] = "RULE 1 FAIL: City page not in sitemap: $expectedUrl";
        }
    }
}

if (empty($errors)) {
    echo "✅ PASS: All test city pages are in sitemap\n";
} else {
    echo "❌ FAIL: " . count($errors) . " city pages missing from sitemap\n";
    foreach (array_slice($errors, 0, 5) as $error) {
        echo "  - $error\n";
    }
}
echo "\n";

// ========================================================================
// RULE 2: No duplicate city across locales
// ========================================================================
echo "Rule 2: Checking for duplicate city pages across locales...\n";

// This would check the actual routes/URLs generated
// For now, we'll verify the sitemap generation logic
$duplicateCheck = [];
foreach ($sitemapUrls as $url) {
    if (preg_match('#/services/([^/]+)/([^/]+)/#', $url, $m)) {
        $service = $m[1];
        $city = $m[2];
        $key = "$service/$city";
        
        if (!isset($duplicateCheck[$key])) {
            $duplicateCheck[$key] = [];
        }
        
        // Extract locale
        if (preg_match('#/([a-z]{2}-[a-z]{2})/#', $url, $localeMatch)) {
            $locale = strtolower($localeMatch[1]);
            $duplicateCheck[$key][] = $locale;
        }
    }
}

$duplicateErrors = [];
foreach ($duplicateCheck as $key => $locales) {
    $uniqueLocales = array_unique($locales);
    if (count($uniqueLocales) > 1) {
        $city = explode('/', $key)[1];
        $isUK = is_uk_city($city);
        $expectedLocale = $isUK ? 'en-gb' : 'en-us';
        
        // Check if non-canonical locales exist
        $nonCanonical = array_filter($uniqueLocales, fn($l) => $l !== $expectedLocale);
        if (!empty($nonCanonical)) {
            $duplicateErrors[] = "RULE 2 FAIL: Duplicate locales for $key: " . implode(', ', $uniqueLocales) . " (expected: $expectedLocale)";
        }
    }
}

if (empty($duplicateErrors)) {
    echo "✅ PASS: No duplicate city pages across locales\n";
} else {
    echo "❌ FAIL: " . count($duplicateErrors) . " duplicate locale issues found\n";
    foreach (array_slice($duplicateErrors, 0, 5) as $error) {
        echo "  - $error\n";
    }
}
echo "\n";

// ========================================================================
// RULE 3: No canonical to undiscoverable URL
// ========================================================================
echo "Rule 3: Checking canonical targets are discoverable...\n";

// This would require checking actual page canonical tags
// For now, we'll verify the logic in templates/head.php
$canonicalCheck = true; // Simplified - would check actual pages

// Verify canonical generation logic
$testPaths = [
    '/services/local-seo-ai/norwich/' => 'en-gb',
    '/services/local-seo-ai/chicago/' => 'en-us',
];

foreach ($testPaths as $path => $expectedLocale) {
    $hreflangUrls = sitemap_generate_hreflang_urls($path);
    $canonicalUrl = $hreflangUrls['x-default'] ?? '';
    
    if (empty($canonicalUrl)) {
        $errors[] = "RULE 3 FAIL: No canonical URL generated for $path";
        continue;
    }
    
    // Check canonical URL is in sitemap
    if (!in_array($canonicalUrl, $sitemapUrls)) {
        $errors[] = "RULE 3 FAIL: Canonical target not in sitemap: $canonicalUrl";
    }
    
    // Check locale matches expected
    if (preg_match('#/([a-z]{2}-[a-z]{2})/#', $canonicalUrl, $m)) {
        $canonicalLocale = strtolower($m[1]);
        if ($canonicalLocale !== $expectedLocale) {
            $errors[] = "RULE 3 FAIL: Canonical locale mismatch for $path (got $canonicalLocale, expected $expectedLocale)";
        }
    }
}

if ($canonicalCheck && empty($errors)) {
    echo "✅ PASS: Canonical targets are discoverable\n";
} else {
    echo "❌ FAIL: Canonical target issues found\n";
    foreach (array_slice($errors, 0, 5) as $error) {
        echo "  - $error\n";
    }
}
echo "\n";

// ========================================================================
// SUMMARY
// ========================================================================
echo "=== AUTOMATED RULES SUMMARY ===\n\n";

$totalErrors = count($errors) + count($duplicateErrors);
$totalWarnings = count($warnings);

echo "Total Errors: $totalErrors\n";
echo "Total Warnings: $totalWarnings\n";
echo "\n";

if ($totalErrors > 0) {
    echo "❌ DEPLOYMENT BLOCKED: Fail-safe rules violated\n";
    echo "\nFix these issues before deploying:\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
    exit(1);
} else {
    echo "✅ PASS: All automated rules passed\n";
    exit(0);
}

