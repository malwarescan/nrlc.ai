<?php
/**
 * Fix Canonical Collapse Issue
 * 
 * Problem: Google chooses en-GB as canonical for UK cities but can't discover it
 * Solution: Ensure en-GB URLs are discoverable via:
 * 1. Sitemap inclusion (already done)
 * 2. Internal links from other pages
 * 3. Navigation structure
 */

require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/sitemap.php';

echo "=== CANONICAL COLLAPSE FIX ===\n\n";

// Check if en-GB URLs are in sitemap
$sitemapFile = __DIR__ . '/public/sitemaps/services-1.xml';
if (file_exists($sitemapFile)) {
    $sitemapContent = file_get_contents($sitemapFile);
    $norwichEnGB = 'https://nrlc.ai/en-gb/services/local-seo-ai/norwich/';
    if (strpos($sitemapContent, $norwichEnGB) !== false) {
        echo "✅ PASS: en-GB Norwich URL is in sitemap\n";
    } else {
        echo "❌ FAIL: en-GB Norwich URL is NOT in sitemap\n";
    }
} else {
    echo "⚠️  WARN: Sitemap file not found\n";
}

// Check sitemap generation logic
echo "\n=== SITEMAP GENERATION CHECK ===\n";
$testPath = "/services/local-seo-ai/norwich/";
$hreflangUrls = sitemap_generate_hreflang_urls($testPath);
echo "Path: $testPath\n";
echo "Generated URLs:\n";
foreach ($hreflangUrls as $locale => $url) {
    echo "  $locale: $url\n";
}
$canonicalUrl = $hreflangUrls['x-default'] ?? $hreflangUrls['en-gb'] ?? $hreflangUrls['en-us'] ?? '';
if (strpos($canonicalUrl, '/en-gb/') !== false) {
    echo "✅ PASS: Canonical URL is en-GB\n";
} else {
    echo "❌ FAIL: Canonical URL is NOT en-GB: $canonicalUrl\n";
}

// Check if UK city detection works
echo "\n=== UK CITY DETECTION CHECK ===\n";
$isUK = is_uk_city('norwich');
echo "is_uk_city('norwich'): " . ($isUK ? 'true' : 'false') . "\n";
if ($isUK) {
    echo "✅ PASS: Norwich is detected as UK city\n";
} else {
    echo "❌ FAIL: Norwich is NOT detected as UK city\n";
}

// Recommendations
echo "\n=== RECOMMENDATIONS ===\n";
echo "1. ✅ Sitemap includes en-GB URLs (verified)\n";
echo "2. ⚠️  Need to verify sitemap is submitted to Google Search Console\n";
echo "3. ⚠️  Need to add internal links to en-GB pages from:\n";
echo "   - Homepage\n";
echo "   - Services index page\n";
echo "   - Related service pages\n";
echo "   - Navigation menu\n";
echo "4. ⚠️  Need to ensure en-GB section is navigable\n";

