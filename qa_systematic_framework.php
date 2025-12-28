<?php
/**
 * Systematic QA Framework for GSC Pages
 * 
 * Phase 1: Inventory & Classification
 * Phase 2: Discovery QA
 * Phase 3: Canonical Consistency QA
 * Phase 4: Locale & Hreflang QA
 * Phase 5: Sitemap QA
 * Phase 6: Internal Link Graph QA
 * Phase 7: Intent Eligibility QA
 * Phase 8: Automated Fail-Safe Rules
 */

error_reporting(E_ALL & ~E_DEPRECATED);

require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/sitemap.php';

$pagesCsv = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-28 (1)/Pages.csv';
$queriesCsv = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-28 (1)/Queries.csv';

if (!file_exists($pagesCsv)) {
    die("Pages.csv not found: $pagesCsv\n");
}

echo "=== SYSTEMATIC QA FRAMEWORK ===\n\n";

// Load data
$pages = [];
$handle = fopen($pagesCsv, 'r');
if ($handle === false) die("Could not open Pages.csv\n");
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

// Load queries for Phase 7
$queries = [];
if (file_exists($queriesCsv)) {
    $handle = fopen($queriesCsv, 'r');
    if ($handle !== false) {
        fgetcsv($handle); // Skip header
        while (($row = fgetcsv($handle)) !== false) {
            if (isset($row[0])) {
                $queries[] = [
                    'query' => $row[0],
                    'clicks' => (int)($row[1] ?? 0),
                    'impressions' => (int)($row[2] ?? 0),
                    'ctr' => $row[3] ?? '0%',
                    'position' => (float)($row[4] ?? 0)
                ];
            }
        }
        fclose($handle);
    }
}

echo "Loaded " . count($pages) . " pages from Pages.csv\n";
echo "Loaded " . count($queries) . " queries from Queries.csv\n\n";

// ========================================================================
// PHASE 1: INVENTORY & CLASSIFICATION
// ========================================================================
echo "=== PHASE 1: INVENTORY & CLASSIFICATION ===\n\n";

$classified = [];
$mismatches = [];
$stats = [
    'total' => 0,
    'locale_mismatches' => 0,
    'uk_cities_en_us' => 0,
    'us_cities_en_gb' => 0,
    'no_locale' => 0,
    'service_pages' => 0,
    'city_pages' => 0
];

foreach ($pages as $page) {
    $url = $page['url'];
    $stats['total']++;
    
    // Parse URL
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    // Extract locale
    $locale = null;
    if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $path, $m)) {
        $locale = strtolower($m[1]);
    } else {
        $stats['no_locale']++;
    }
    
    // Extract city and service
    $citySlug = null;
    $serviceSlug = null;
    $pageType = 'other';
    $intentType = 'other';
    
    if (preg_match('#/services/([^/]+)/([^/]+)/#', $path, $m)) {
        $serviceSlug = $m[1];
        $citySlug = $m[2];
        $pageType = 'service_city';
        $intentType = 'local_service';
        $stats['city_pages']++;
    } elseif (preg_match('#/services/([^/]+)/#', $path, $m)) {
        $serviceSlug = $m[1];
        $pageType = 'service';
        $intentType = 'national_service';
        $stats['service_pages']++;
    }
    
    // Determine country target
    $countryTarget = 'Global';
    if ($citySlug) {
        $isUK = is_uk_city($citySlug);
        $countryTarget = $isUK ? 'UK' : 'US';
        
        // Check for locale mismatch
        if ($locale) {
            if ($isUK && $locale !== 'en-gb') {
                $mismatches[] = [
                    'url' => $url,
                    'city' => $citySlug,
                    'locale' => $locale,
                    'expected_locale' => 'en-gb',
                    'issue' => 'UK city in non-en-gb locale'
                ];
                $stats['locale_mismatches']++;
                $stats['uk_cities_en_us']++;
            } elseif (!$isUK && $locale === 'en-gb') {
                $mismatches[] = [
                    'url' => $url,
                    'city' => $citySlug,
                    'locale' => $locale,
                    'expected_locale' => 'en-us',
                    'issue' => 'US city in en-gb locale'
                ];
                $stats['locale_mismatches']++;
                $stats['us_cities_en_gb']++;
            }
        }
    }
    
    $classified[] = [
        'url' => $url,
        'locale' => $locale,
        'country_target' => $countryTarget,
        'city_target' => $citySlug,
        'service' => $serviceSlug,
        'intent_type' => $intentType,
        'page_type' => $pageType,
        'clicks' => $page['clicks'],
        'impressions' => $page['impressions'],
        'position' => $page['position'],
        'has_mismatch' => !empty($mismatches) && end($mismatches)['url'] === $url
    ];
}

echo "Classification Results:\n";
echo "  Total pages: {$stats['total']}\n";
echo "  Service pages: {$stats['service_pages']}\n";
echo "  City pages: {$stats['city_pages']}\n";
echo "  Pages without locale: {$stats['no_locale']}\n";
echo "  Locale mismatches: {$stats['locale_mismatches']}\n";
echo "    - UK cities in en-us: {$stats['uk_cities_en_us']}\n";
echo "    - US cities in en-gb: {$stats['us_cities_en_gb']}\n";
echo "\n";

if (!empty($mismatches)) {
    echo "❌ CRITICAL: Locale/City Mismatches Found:\n";
    foreach (array_slice($mismatches, 0, 10) as $mismatch) {
        echo "  - {$mismatch['url']}\n";
        echo "    City: {$mismatch['city']}, Locale: {$mismatch['locale']}, Expected: {$mismatch['expected_locale']}\n";
    }
    if (count($mismatches) > 10) {
        echo "  ... and " . (count($mismatches) - 10) . " more\n";
    }
    echo "\n";
}

// ========================================================================
// PHASE 2: DISCOVERY QA (Sitemap Check)
// ========================================================================
echo "=== PHASE 2: DISCOVERY QA (Sitemap Check) ===\n\n";

$sitemapFile = __DIR__ . '/public/sitemaps/services-1.xml';
$sitemapUrls = [];
if (file_exists($sitemapFile)) {
    $sitemapContent = file_get_contents($sitemapFile);
    preg_match_all('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $sitemapContent, $matches);
    $sitemapUrls = $matches[1] ?? [];
}

$discoveryIssues = [];
foreach ($classified as $page) {
    $url = $page['url'];
    $inSitemap = in_array($url, $sitemapUrls);
    
    if (!$inSitemap && $page['page_type'] === 'service_city') {
        $discoveryIssues[] = [
            'url' => $url,
            'issue' => 'Not in sitemap',
            'city' => $page['city_target'],
            'locale' => $page['locale']
        ];
    }
}

echo "Sitemap Check Results:\n";
echo "  URLs in sitemap: " . count($sitemapUrls) . "\n";
echo "  Service+city pages not in sitemap: " . count($discoveryIssues) . "\n";
if (!empty($discoveryIssues)) {
    echo "\n❌ CRITICAL: Discovery Issues Found:\n";
    foreach (array_slice($discoveryIssues, 0, 10) as $issue) {
        echo "  - {$issue['url']}\n";
    }
    if (count($discoveryIssues) > 10) {
        echo "  ... and " . (count($discoveryIssues) - 10) . " more\n";
    }
    echo "\n";
}

// ========================================================================
// PHASE 3: CANONICAL CONSISTENCY QA
// ========================================================================
echo "=== PHASE 3: CANONICAL CONSISTENCY QA ===\n\n";

$canonicalIssues = [];
foreach ($classified as $page) {
    if ($page['page_type'] !== 'service_city') continue;
    
    $url = $page['url'];
    $locale = $page['locale'];
    $city = $page['city_target'];
    $countryTarget = $page['country_target'];
    
    if (!$locale || !$city) continue;
    
    // Determine expected canonical locale
    $expectedLocale = $countryTarget === 'UK' ? 'en-gb' : 'en-us';
    
    // Check if URL matches expected canonical
    if ($locale !== $expectedLocale) {
        $canonicalIssues[] = [
            'url' => $url,
            'issue' => 'Non-canonical locale',
            'current_locale' => $locale,
            'expected_locale' => $expectedLocale,
            'city' => $city
        ];
    }
    
    // Check if canonical target exists in sitemap
    $canonicalUrl = "https://nrlc.ai/$expectedLocale/services/{$page['service']}/$city/";
    if (!in_array($canonicalUrl, $sitemapUrls)) {
        $canonicalIssues[] = [
            'url' => $url,
            'issue' => 'Canonical target not in sitemap',
            'canonical_target' => $canonicalUrl,
            'city' => $city
        ];
    }
}

echo "Canonical Consistency Check:\n";
echo "  Canonical issues found: " . count($canonicalIssues) . "\n";
if (!empty($canonicalIssues)) {
    echo "\n❌ CRITICAL: Canonical Issues Found:\n";
    foreach (array_slice($canonicalIssues, 0, 10) as $issue) {
        echo "  - {$issue['url']}\n";
        echo "    Issue: {$issue['issue']}\n";
        if (isset($issue['canonical_target'])) {
            echo "    Canonical target: {$issue['canonical_target']}\n";
        }
    }
    if (count($canonicalIssues) > 10) {
        echo "  ... and " . (count($canonicalIssues) - 10) . " more\n";
    }
    echo "\n";
}

// ========================================================================
// PHASE 4: LOCALE & HREFLANG QA
// ========================================================================
echo "=== PHASE 4: LOCALE & HREFLANG QA ===\n\n";

// Check for duplicate city pages across locales
$cityLocaleMap = [];
foreach ($classified as $page) {
    if ($page['page_type'] !== 'service_city' || !$page['city_target']) continue;
    
    $city = $page['city_target'];
    $locale = $page['locale'] ?? 'none';
    $service = $page['service'] ?? 'unknown';
    $key = "$service/$city";
    
    if (!isset($cityLocaleMap[$key])) {
        $cityLocaleMap[$key] = [];
    }
    $cityLocaleMap[$key][] = [
        'locale' => $locale,
        'url' => $page['url']
    ];
}

$duplicateIssues = [];
foreach ($cityLocaleMap as $key => $locales) {
    if (count($locales) > 1) {
        $city = explode('/', $key)[1];
        $isUK = is_uk_city($city);
        $expectedLocale = $isUK ? 'en-gb' : 'en-us';
        
        // Check if multiple locales exist for same city
        $localeList = array_column($locales, 'locale');
        $uniqueLocales = array_unique($localeList);
        
        if (count($uniqueLocales) > 1) {
            $duplicateIssues[] = [
                'city' => $city,
                'service' => explode('/', $key)[0],
                'locales' => $uniqueLocales,
                'expected_locale' => $expectedLocale,
                'urls' => array_column($locales, 'url')
            ];
        }
    }
}

echo "Locale & Hreflang Check:\n";
echo "  Unique city+service combinations: " . count($cityLocaleMap) . "\n";
echo "  Duplicate locale issues: " . count($duplicateIssues) . "\n";
if (!empty($duplicateIssues)) {
    echo "\n❌ CRITICAL: Duplicate Locale Issues Found:\n";
    foreach (array_slice($duplicateIssues, 0, 10) as $issue) {
        echo "  - {$issue['service']}/{$issue['city']}\n";
        echo "    Locales: " . implode(', ', $issue['locales']) . "\n";
        echo "    Expected: {$issue['expected_locale']}\n";
    }
    if (count($duplicateIssues) > 10) {
        echo "  ... and " . (count($duplicateIssues) - 10) . " more\n";
    }
    echo "\n";
}

// ========================================================================
// PHASE 5: SITEMAP QA
// ========================================================================
echo "=== PHASE 5: SITEMAP QA ===\n\n";

// Check sitemap structure
$sitemapLocales = [];
foreach ($sitemapUrls as $sitemapUrl) {
    if (preg_match('#https://nrlc\.ai/([a-z]{2}-[a-z]{2})/#', $sitemapUrl, $m)) {
        $locale = strtolower($m[1]);
        $sitemapLocales[$locale] = ($sitemapLocales[$locale] ?? 0) + 1;
    }
}

echo "Sitemap Structure:\n";
foreach ($sitemapLocales as $locale => $count) {
    echo "  $locale: $count URLs\n";
}
echo "\n";

// ========================================================================
// PHASE 7: INTENT ELIGIBILITY QA
// ========================================================================
echo "=== PHASE 7: INTENT ELIGIBILITY QA ===\n\n";

// Map queries to pages (simplified - would need full GSC data)
$intentIssues = [];
foreach ($classified as $page) {
    if ($page['impressions'] > 100 && $page['clicks'] === 0 && $page['position'] > 50) {
        $intentIssues[] = [
            'url' => $page['url'],
            'impressions' => $page['impressions'],
            'position' => $page['position'],
            'issue' => 'High impressions, 0 clicks, position > 50'
        ];
    }
}

echo "Intent Eligibility Check:\n";
echo "  Pages with intent issues: " . count($intentIssues) . "\n";
if (!empty($intentIssues)) {
    echo "\n⚠️  WARNING: Intent Eligibility Issues:\n";
    foreach (array_slice($intentIssues, 0, 10) as $issue) {
        echo "  - {$issue['url']}\n";
        echo "    Impressions: {$issue['impressions']}, Position: {$issue['position']}\n";
    }
    if (count($intentIssues) > 10) {
        echo "  ... and " . (count($intentIssues) - 10) . " more\n";
    }
    echo "\n";
}

// ========================================================================
// SUMMARY REPORT
// ========================================================================
echo "=== QA SUMMARY REPORT ===\n\n";

$criticalIssues = count($mismatches) + count($discoveryIssues) + count($canonicalIssues) + count($duplicateIssues);
$warnings = count($intentIssues);

echo "Total Pages Analyzed: {$stats['total']}\n";
echo "Critical Issues: $criticalIssues\n";
echo "Warnings: $warnings\n";
echo "\n";

if ($criticalIssues > 0) {
    echo "❌ FAIL: Critical issues found. Pages are not eligible to rank.\n";
    echo "\nImmediate Actions Required:\n";
    echo "1. Fix locale mismatches (redirect non-canonical locales)\n";
    echo "2. Add missing URLs to sitemap\n";
    echo "3. Fix canonical targets (ensure they're discoverable)\n";
    echo "4. Remove duplicate locale versions\n";
    exit(1);
} elseif ($warnings > 0) {
    echo "⚠️  WARN: Warnings found. Review intent alignment.\n";
    exit(0);
} else {
    echo "✅ PASS: No critical issues found.\n";
    exit(0);
}

