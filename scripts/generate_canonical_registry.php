<?php
/**
 * Canonical Registry Generator
 * 
 * Generates data/canonical_registry.json from sitemap
 * This is the single source of truth for canonical URLs
 */

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/sitemap.php';

$sitemapIndex = __DIR__ . '/../public/sitemaps/sitemap-index.xml';
$outputFile = __DIR__ . '/../data/canonical_registry.json';
$cityLocaleRulesFile = __DIR__ . '/../data/city_locale_rules.json';

if (!file_exists($sitemapIndex)) {
    fwrite(STDERR, "ERROR: Sitemap index not found: $sitemapIndex\n");
    fwrite(STDERR, "Run scripts/build_sitemaps.php first\n");
    exit(1);
}

echo "=== GENERATING CANONICAL REGISTRY ===\n\n";

// Load city locale rules
$cityLocaleRules = [];
if (file_exists($cityLocaleRulesFile)) {
    $cityLocaleRules = json_decode(file_get_contents($cityLocaleRulesFile), true) ?? [];
}

// Load sitemap index
$sitemapIndexContent = file_get_contents($sitemapIndex);
preg_match_all('#<loc>(https://nrlc\.ai/sitemaps/[^<]+)</loc>#', $sitemapIndexContent, $sitemapMatches);
$sitemapFiles = $sitemapMatches[1] ?? [];

$registry = [];
$sitemapDir = __DIR__ . '/../public/sitemaps/';

foreach ($sitemapFiles as $sitemapUrl) {
    // Extract filename from URL
    $filename = basename(parse_url($sitemapUrl, PHP_URL_PATH));
    $sitemapPath = $sitemapDir . $filename;
    
    if (!file_exists($sitemapPath)) {
        // Try uncompressed version
        $sitemapPath = str_replace('.gz', '', $sitemapPath);
    }
    
    if (!file_exists($sitemapPath)) {
        echo "⚠️  Sitemap file not found: $sitemapPath\n";
        continue;
    }
    
    // Read sitemap (handle gzipped)
    $content = file_get_contents($sitemapPath);
    if (substr($filename, -3) === '.gz') {
        $content = gzdecode($content);
    }
    
    // Extract URLs
    preg_match_all('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $content, $urlMatches);
    $urls = $urlMatches[1] ?? [];
    
    foreach ($urls as $url) {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '/';
        
        // Extract locale
        $locale = null;
        if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $path, $m)) {
            $locale = strtolower($m[1]);
        }
        
        // Extract service and city
        $serviceSlug = null;
        $citySlug = null;
        if (preg_match('#/services/([^/]+)/([^/]+)/#', $path, $m)) {
            $serviceSlug = $m[1];
            $citySlug = $m[2];
        }
        
        // Determine country
        $country = 'Global';
        if ($citySlug) {
            $isUK = is_uk_city($citySlug);
            $country = $isUK ? 'GB' : 'US';
        }
        
        // Build alternates (non-canonical versions)
        $alternates = [];
        if ($citySlug && isset($cityLocaleRules[$citySlug])) {
            $canonicalLocale = $cityLocaleRules[$citySlug]['canonical_locale'] ?? $locale;
            $forbiddenLocales = $cityLocaleRules[$citySlug]['forbidden_locales'] ?? [];
            
            // Generate alternate URLs for forbidden locales
            foreach ($forbiddenLocales as $altLocale) {
                $altUrl = "https://nrlc.ai/$altLocale/services/$serviceSlug/$citySlug/";
                $alternates[] = $altUrl;
            }
        }
        
        $registry[$url] = [
            'locale' => $locale ?? 'none',
            'country' => $country,
            'city' => $citySlug,
            'service_slug' => $serviceSlug,
            'alternates' => $alternates,
            'sitemap' => $filename,
            'is_canonical' => true, // All URLs in sitemap are canonical
            'sitemap_included' => true // All URLs in registry are from sitemap
        ];
    }
}

// Write registry
$outputDir = dirname($outputFile);
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

file_put_contents($outputFile, json_encode($registry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Generated registry with " . count($registry) . " canonical URLs\n";
echo "Output: $outputFile\n";
echo "\n✅ Canonical registry generated successfully\n";

