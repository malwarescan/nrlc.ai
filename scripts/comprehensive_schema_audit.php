<?php
/**
 * Comprehensive Schema Audit Script
 * Scans all service + city pages for schema markup
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';

function audit_page_schema($url, $pageType) {
    $html = @file_get_contents($url);
    if (!$html) {
        return ['error' => 'Failed to fetch page'];
    }
    
    // Extract all JSON-LD schemas
    preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);
    
    $schemas = [];
    foreach ($matches[1] as $json) {
        $data = json_decode($json, true);
        if ($data && isset($data['@type'])) {
            $schemas[] = $data['@type'];
        }
    }
    
    return [
        'url' => $url,
        'page_type' => $pageType,
        'schema_count' => count($schemas),
        'schemas' => $schemas
    ];
}

function get_expected_schemas($pageType) {
    $base = ['Organization', 'WebSite', 'BreadcrumbList'];
    
    switch ($pageType) {
        case 'service_city':
            return array_merge($base, ['Service', 'LocalBusiness', 'FAQPage']);
        case 'service_index':
            return array_merge($base, ['Service']);
        case 'career_city':
            return array_merge($base, ['JobPosting', 'LocalBusiness']);
        case 'insight_article':
            return array_merge($base, ['Article', 'FAQPage']);
        default:
            return $base;
    }
}

function check_missing_schemas($actual, $expected) {
    return array_diff($expected, $actual);
}

echo "🔍 COMPREHENSIVE SCHEMA AUDIT\n";
echo "============================\n\n";

// Load data
$services = csv_read_data('services.csv');
$cities = csv_read_data('cities.csv');

// Sample URLs to test
$testUrls = [
    // Service city pages
    ['url' => 'http://localhost:8000/services/crawl-clarity/new-york/', 'type' => 'service_city'],
    ['url' => 'http://localhost:8000/services/json-ld-strategy/london/', 'type' => 'service_city'],
    ['url' => 'http://localhost:8000/services/llm-seeding/tokyo/', 'type' => 'service_city'],
    ['url' => 'http://localhost:8000/services/site-audits/toronto/', 'type' => 'service_city'],
    
    // Service index pages
    ['url' => 'http://localhost:8000/services/crawl-clarity/', 'type' => 'service_index'],
    ['url' => 'http://localhost:8000/services/json-ld-strategy/', 'type' => 'service_index'],
    
    // Career pages
    ['url' => 'http://localhost:8000/careers/new-york/senior-seo-engineer/', 'type' => 'career_city'],
    
    // Insights
    ['url' => 'http://localhost:8000/insights/geo16-framework/', 'type' => 'insight_article'],
];

$results = [];
$totalPages = 0;
$pagesWithIssues = 0;

foreach ($testUrls as $test) {
    echo "📄 Testing: {$test['url']}\n";
    $result = audit_page_schema($test['url'], $test['type']);
    
    if (isset($result['error'])) {
        echo "   ❌ Error: {$result['error']}\n\n";
        continue;
    }
    
    $expected = get_expected_schemas($test['type']);
    $missing = check_missing_schemas($result['schemas'], $expected);
    
    echo "   Found {$result['schema_count']} schemas: " . implode(', ', $result['schemas']) . "\n";
    
    if (!empty($missing)) {
        echo "   ⚠️  Missing: " . implode(', ', $missing) . "\n";
        $pagesWithIssues++;
    } else {
        echo "   ✅ All expected schemas present\n";
    }
    echo "\n";
    
    $results[] = [
        'url' => $test['url'],
        'type' => $test['type'],
        'found' => $result['schemas'],
        'missing' => $missing
    ];
    
    $totalPages++;
}

// Summary report
echo "\n📊 AUDIT SUMMARY\n";
echo "================\n";
echo "Total pages tested: $totalPages\n";
echo "Pages with schema issues: $pagesWithIssues\n";
echo "Schema coverage: " . round((($totalPages - $pagesWithIssues) / $totalPages) * 100, 1) . "%\n\n";

// Count total service + city combinations
$serviceCount = count($services);
$cityCount = count($cities);
$totalServiceCityPages = $serviceCount * $cityCount;

echo "📈 SCALE ANALYSIS\n";
echo "=================\n";
echo "Services: $serviceCount\n";
echo "Cities: $cityCount\n";
echo "Total service+city pages: $totalServiceCityPages\n\n";

// Pages with issues
if ($pagesWithIssues > 0) {
    echo "⚠️  PAGES REQUIRING SCHEMA FIXES:\n";
    echo "================================\n";
    foreach ($results as $result) {
        if (!empty($result['missing'])) {
            echo "• {$result['url']}\n";
            echo "  Missing: " . implode(', ', $result['missing']) . "\n";
        }
    }
    echo "\n";
}

echo "✅ SCHEMA RECOMMENDATIONS:\n";
echo "=========================\n";
echo "Service+City Pages Should Have:\n";
echo "• Organization schema (base)\n";
echo "• WebSite schema (base)\n";
echo "• BreadcrumbList schema (base)\n";
echo "• Service schema with OfferCatalog\n";
echo "• LocalBusiness schema\n";
echo "• FAQPage schema\n\n";

echo "Service Index Pages Should Have:\n";
echo "• Organization schema (base)\n";
echo "• WebSite schema (base)\n";
echo "• BreadcrumbList schema (base)\n";
echo "• Service schema with areaServed\n\n";

echo "Career+City Pages Should Have:\n";
echo "• Organization schema (base)\n";
echo "• WebSite schema (base)\n";
echo "• BreadcrumbList schema (base)\n";
echo "• JobPosting schema\n";
echo "• LocalBusiness schema\n\n";

?>
