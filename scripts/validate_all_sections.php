<?php
declare(strict_types=1);

/**
 * Comprehensive validation script to check all sections of service city pages
 * Ensures every section has content and is complete
 */

require_once __DIR__ . '/../lib/content_tokens.php';
require_once __DIR__ . '/../lib/service_enhancements.php';
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/deterministic.php';
require_once __DIR__ . '/../lib/csv.php';

$pagesCsvPath = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-13/Pages.csv';
$reportPath = __DIR__ . '/../section_validation_report.json';

// Function to read CSV data
function readCsv(string $filePath): array {
    $data = [];
    if (!file_exists($filePath)) {
        fwrite(STDERR, "Error: CSV file not found at $filePath\n");
        return $data;
    }
    if (($handle = fopen($filePath, 'r')) !== false) {
        $headers = fgetcsv($handle, 0, ',', '"', '\\');
        if ($headers) {
            while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
                if (count($row) === count($headers)) {
                    $data[] = array_combine($headers, $row);
                }
            }
        }
        fclose($handle);
    }
    return $data;
}

// Function to extract service and city from URL
function extractServiceCity(string $url): ?array {
    // Match pattern: /services/{service}/{city}/
    if (preg_match('#/services/([^/]+)/([^/]+)/#', $url, $matches)) {
        return [
            'service' => $matches[1],
            'city' => $matches[2]
        ];
    }
    return null;
}

// Function to validate all sections for a service city page
function validatePageSections(string $serviceSlug, string $citySlug): array {
    $pathKey = "/services/$serviceSlug/$citySlug/";
    det_seed($pathKey);
    
    $results = [
        'service' => $serviceSlug,
        'city' => $citySlug,
        'sections' => [],
        'total_content_length' => 0,
        'missing_sections' => [],
        'empty_sections' => [],
        'all_complete' => true
    ];
    
    // 1. Hero/Intro Section
    $enhancement = get_service_enhancement($serviceSlug, $citySlug);
    $enhancedIntro = $enhancement['intro'] ?? null;
    $intro = $enhancedIntro ?? service_long_intro($serviceSlug, $citySlug);
    $local = local_context_block($citySlug);
    $queryAligned = get_query_aligned_content($serviceSlug, $citySlug);
    
    $introLength = strlen($intro) + strlen($local) + strlen($queryAligned);
    $results['sections']['hero_intro'] = [
        'present' => true,
        'length' => $introLength,
        'has_intro' => !empty($intro),
        'has_local' => !empty($local),
        'has_query_aligned' => !empty($queryAligned),
        'complete' => $introLength > 100
    ];
    $results['total_content_length'] += $introLength;
    
    if ($introLength < 100) {
        $results['empty_sections'][] = 'hero_intro';
        $results['all_complete'] = false;
    }
    
    // 2. Local Market Insights
    $market = local_market_insights($citySlug);
    $marketLength = strlen($market);
    $results['sections']['local_market_insights'] = [
        'present' => true,
        'length' => $marketLength,
        'complete' => $marketLength > 200
    ];
    $results['total_content_length'] += $marketLength;
    
    if ($marketLength < 200) {
        $results['empty_sections'][] = 'local_market_insights';
        $results['all_complete'] = false;
    }
    
    // 3. Competitive Landscape
    $competition = local_competition_analysis($citySlug);
    $competitionLength = strlen($competition);
    $results['sections']['competitive_landscape'] = [
        'present' => true,
        'length' => $competitionLength,
        'complete' => $competitionLength > 200
    ];
    $results['total_content_length'] += $competitionLength;
    
    if ($competitionLength < 200) {
        $results['empty_sections'][] = 'competitive_landscape';
        $results['all_complete'] = false;
    }
    
    // 4. Localized Strategy
    $strategy = local_implementation_strategy($citySlug);
    $strategyLength = strlen($strategy);
    $results['sections']['localized_strategy'] = [
        'present' => true,
        'length' => $strategyLength,
        'complete' => $strategyLength > 200
    ];
    $results['total_content_length'] += $strategyLength;
    
    if ($strategyLength < 200) {
        $results['empty_sections'][] = 'localized_strategy';
        $results['all_complete'] = false;
    }
    
    // 5. Pain Points & Solutions
    $pain = pain_point_section($serviceSlug, $citySlug, 4);
    $painLength = strlen($pain);
    $results['sections']['pain_points'] = [
        'present' => true,
        'length' => $painLength,
        'complete' => $painLength > 100 // Can be empty if no data
    ];
    $results['total_content_length'] += $painLength;
    
    if ($painLength < 100) {
        $results['empty_sections'][] = 'pain_points';
        // Note: This is optional, so don't mark as incomplete
    }
    
    // 6. Why This Matters
    $why = why_this_matters_section($serviceSlug, $citySlug);
    $whyLength = strlen($why);
    $results['sections']['why_this_matters'] = [
        'present' => true,
        'length' => $whyLength,
        'complete' => $whyLength > 200
    ];
    $results['total_content_length'] += $whyLength;
    
    if ($whyLength < 200) {
        $results['empty_sections'][] = 'why_this_matters';
        $results['all_complete'] = false;
    }
    
    // 7. Our Approach
    $appro = approach_section($serviceSlug);
    $approLength = strlen($appro);
    $results['sections']['our_approach'] = [
        'present' => true,
        'length' => $approLength,
        'complete' => $approLength > 100 // Can be empty if no data
    ];
    $results['total_content_length'] += $approLength;
    
    if ($approLength < 100) {
        $results['empty_sections'][] = 'our_approach';
        // Note: This is optional, so don't mark as incomplete
    }
    
    // 8. Implementation Timeline
    $timeline = implementation_timeline_section($citySlug);
    $timelineLength = strlen($timeline);
    $results['sections']['implementation_timeline'] = [
        'present' => true,
        'length' => $timelineLength,
        'complete' => $timelineLength > 300
    ];
    $results['total_content_length'] += $timelineLength;
    
    if ($timelineLength < 300) {
        $results['empty_sections'][] = 'implementation_timeline';
        $results['all_complete'] = false;
    }
    
    // 9. Success Metrics
    $metrics = success_metrics_section($serviceSlug, $citySlug);
    $metricsLength = strlen($metrics);
    $results['sections']['success_metrics'] = [
        'present' => true,
        'length' => $metricsLength,
        'complete' => $metricsLength > 300
    ];
    $results['total_content_length'] += $metricsLength;
    
    if ($metricsLength < 300) {
        $results['empty_sections'][] = 'success_metrics';
        $results['all_complete'] = false;
    }
    
    // 10. FAQs
    $faqs = faq_block($serviceSlug, $citySlug, 6);
    $faqsLength = strlen($faqs);
    $results['sections']['faqs'] = [
        'present' => !empty($faqs),
        'length' => $faqsLength,
        'complete' => $faqsLength > 500
    ];
    $results['total_content_length'] += $faqsLength;
    
    if ($faqsLength < 500) {
        $results['empty_sections'][] = 'faqs';
        // Note: FAQs are optional
    }
    
    return $results;
}

// Main validation logic
$pagesData = readCsv($pagesCsvPath);
$validationResults = [
    'total_pages' => 0,
    'service_city_pages' => 0,
    'complete_pages' => 0,
    'incomplete_pages' => 0,
    'pages' => [],
    'summary' => [
        'sections_missing' => [],
        'total_content_by_section' => []
    ]
];

echo "Validating sections for all pages...\n\n";

$sectionCounts = [];

foreach ($pagesData as $page) {
    $url = $page['Top pages'];
    $validationResults['total_pages']++;
    
    // Only validate service city pages
    $serviceCity = extractServiceCity($url);
    if (!$serviceCity) {
        continue; // Skip non-service-city pages
    }
    
    $validationResults['service_city_pages']++;
    
    echo "Validating: {$serviceCity['service']} in {$serviceCity['city']}...\n";
    
    $pageResult = validatePageSections($serviceCity['service'], $serviceCity['city']);
    $pageResult['url'] = $url;
    $pageResult['impressions'] = (int)$page['Impressions'];
    $pageResult['clicks'] = (int)$page['Clicks'];
    $pageResult['position'] = (float)$page['Position'];
    
    // Track section completeness
    foreach ($pageResult['sections'] as $sectionName => $sectionData) {
        if (!isset($sectionCounts[$sectionName])) {
            $sectionCounts[$sectionName] = ['complete' => 0, 'incomplete' => 0, 'total_length' => 0];
        }
        if ($sectionData['complete']) {
            $sectionCounts[$sectionName]['complete']++;
        } else {
            $sectionCounts[$sectionName]['incomplete']++;
        }
        $sectionCounts[$sectionName]['total_length'] += $sectionData['length'];
    }
    
    if ($pageResult['all_complete']) {
        $validationResults['complete_pages']++;
    } else {
        $validationResults['incomplete_pages']++;
    }
    
    $validationResults['pages'][] = $pageResult;
    
    // Track missing sections
    foreach ($pageResult['empty_sections'] as $missingSection) {
        if (!isset($validationResults['summary']['sections_missing'][$missingSection])) {
            $validationResults['summary']['sections_missing'][$missingSection] = 0;
        }
        $validationResults['summary']['sections_missing'][$missingSection]++;
    }
}

// Calculate averages
foreach ($sectionCounts as $sectionName => $counts) {
    $avgLength = $validationResults['service_city_pages'] > 0 
        ? round($counts['total_length'] / $validationResults['service_city_pages'])
        : 0;
    $validationResults['summary']['total_content_by_section'][$sectionName] = [
        'complete' => $counts['complete'],
        'incomplete' => $counts['incomplete'],
        'avg_length' => $avgLength
    ];
}

// Sort pages by impressions (descending)
usort($validationResults['pages'], function($a, $b) {
    return $b['impressions'] <=> $a['impressions'];
});

// Output summary
echo "\n\n=== VALIDATION SUMMARY ===\n";
echo "Total pages in CSV: {$validationResults['total_pages']}\n";
echo "Service city pages: {$validationResults['service_city_pages']}\n";
echo "Complete pages: {$validationResults['complete_pages']}\n";
echo "Incomplete pages: {$validationResults['incomplete_pages']}\n";
echo "\n=== SECTION COMPLETENESS ===\n";

foreach ($validationResults['summary']['total_content_by_section'] as $section => $stats) {
    $completionRate = $validationResults['service_city_pages'] > 0
        ? round(($stats['complete'] / $validationResults['service_city_pages']) * 100, 1)
        : 0;
    echo sprintf(
        "%-30s: %d/%d complete (%.1f%%) - Avg length: %d chars\n",
        $section,
        $stats['complete'],
        $validationResults['service_city_pages'],
        $completionRate,
        $stats['avg_length']
    );
}

echo "\n=== MISSING SECTIONS (Top 10 by frequency) ===\n";
arsort($validationResults['summary']['sections_missing']);
$topMissing = array_slice($validationResults['summary']['sections_missing'], 0, 10, true);
foreach ($topMissing as $section => $count) {
    echo "$section: $count pages\n";
}

// Show top incomplete pages by impressions
echo "\n=== TOP INCOMPLETE PAGES (by impressions) ===\n";
$incompletePages = array_filter($validationResults['pages'], fn($p) => !$p['all_complete']);
$incompletePages = array_slice($incompletePages, 0, 10);
foreach ($incompletePages as $page) {
    echo sprintf(
        "✗ %s (%d impressions) - Missing: %s - Total content: %d chars\n",
        $page['url'],
        $page['impressions'],
        implode(', ', $page['empty_sections']),
        $page['total_content_length']
    );
}

// Save detailed report
file_put_contents($reportPath, json_encode($validationResults, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "\nDetailed report saved to: {$reportPath}\n";

