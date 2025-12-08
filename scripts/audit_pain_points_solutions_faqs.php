<?php
/**
 * Comprehensive audit and fix script for:
 * 1. Pain points and solutions - ensure SEO-first, keyword-rich content
 * 2. FAQ sections - ensure proper FAQPage schema and content alignment
 */

declare(strict_types=1);
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/content_tokens.php';

$report = [
    'pain_points' => [],
    'solutions' => [],
    'faq_issues' => [],
    'fixes_needed' => []
];

echo "🔍 AUDITING PAIN POINTS, SOLUTIONS, AND FAQ SECTIONS\n";
echo "==================================================\n\n";

// 1. Audit pain point content for SEO-first quality
echo "1. Checking pain point content quality...\n";
$painpointFile = __DIR__ . '/../data/painpoint_token_map.csv';
if (file_exists($painpointFile)) {
    $rows = csv_rows_local('painpoint_token_map.csv');
    foreach ($rows as $row) {
        $problem = $row['problem'] ?? '';
        $solution = $row['solution'] ?? '';
        
        // Check for SEO keywords
        $seoKeywords = ['SEO', 'AI', 'structured data', 'schema', 'crawl', 'canonical', 'entity', 'optimization'];
        $hasKeywords = false;
        foreach ($seoKeywords as $keyword) {
            if (stripos($problem . ' ' . $solution, $keyword) !== false) {
                $hasKeywords = true;
                break;
            }
        }
        
        if (!$hasKeywords) {
            $report['pain_points'][] = [
                'service' => $row['service'] ?? '',
                'headline' => $row['headline'] ?? '',
                'issue' => 'Missing SEO keywords in problem/solution'
            ];
        }
        
        // Check content length
        if (strlen($problem) < 20 || strlen($solution) < 20) {
            $report['pain_points'][] = [
                'service' => $row['service'] ?? '',
                'headline' => $row['headline'] ?? '',
                'issue' => 'Problem or solution too short (needs more detail)'
            ];
        }
    }
}

// 2. Audit FAQ sections
echo "2. Checking FAQ sections...\n";
$files = glob(__DIR__ . '/../pages/**/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    $basename = basename($file);
    
    // Check for FAQ content
    $hasFaqContent = preg_match('/<h[2-6][^>]*>.*?(?:FAQ|Frequently Asked Questions).*?<\/h[2-6]>.*?<[^>]+>/is', $content);
    
    // Check for FAQPage schema
    $hasFaqSchema = preg_match('/"@type"\s*:\s*"FAQPage"/i', $content);
    
    if ($hasFaqContent && !$hasFaqSchema) {
        $report['faq_issues'][] = [
            'file' => $basename,
            'issue' => 'Has FAQ content but missing FAQPage schema',
            'type' => 'missing_schema'
        ];
    } elseif ($hasFaqSchema && !$hasFaqContent) {
        $report['faq_issues'][] = [
            'file' => $basename,
            'issue' => 'Has FAQPage schema but missing FAQ content',
            'type' => 'missing_content'
        ];
    }
}

// 3. Check for empty FAQ sections
echo "3. Checking for empty FAQ sections...\n";
$faqPoolFile = __DIR__ . '/../data/faq_pools.csv';
if (file_exists($faqPoolFile)) {
    $faqRows = csv_rows_local('faq_pools.csv');
    $services = array_unique(array_column($faqRows, 'service'));
    
    foreach ($services as $service) {
        $serviceFaqs = array_filter($faqRows, fn($r) => ($r['service'] ?? '') === $service);
        if (empty($serviceFaqs)) {
            $report['faq_issues'][] = [
                'file' => "service: $service",
                'issue' => 'No FAQ data available for this service',
                'type' => 'empty_pool'
            ];
        }
    }
}

// Output report
echo "\n📊 AUDIT RESULTS\n";
echo "================\n\n";

if (empty($report['pain_points']) && empty($report['faq_issues'])) {
    echo "✅ All pain points, solutions, and FAQ sections are properly configured!\n";
} else {
    if (!empty($report['pain_points'])) {
        echo "⚠️  PAIN POINT ISSUES (" . count($report['pain_points']) . "):\n";
        foreach (array_slice($report['pain_points'], 0, 10) as $issue) {
            echo "  - {$issue['service']} / {$issue['headline']}: {$issue['issue']}\n";
        }
        echo "\n";
    }
    
    if (!empty($report['faq_issues'])) {
        echo "⚠️  FAQ ISSUES (" . count($report['faq_issues']) . "):\n";
        $missingSchema = array_filter($report['faq_issues'], fn($i) => $i['type'] === 'missing_schema');
        $missingContent = array_filter($report['faq_issues'], fn($i) => $i['type'] === 'missing_content');
        
        if (!empty($missingSchema)) {
            echo "\n  Missing FAQPage Schema (" . count($missingSchema) . " files):\n";
            foreach (array_slice($missingSchema, 0, 10) as $issue) {
                echo "    - {$issue['file']}\n";
            }
        }
        
        if (!empty($missingContent)) {
            echo "\n  Missing FAQ Content (" . count($missingContent) . " files):\n";
            foreach (array_slice($missingContent, 0, 10) as $issue) {
                echo "    - {$issue['file']}\n";
            }
        }
    }
}

// Save report
file_put_contents(__DIR__ . '/../logs/pain_points_faq_audit.json', json_encode($report, JSON_PRETTY_PRINT));
echo "\n✅ Report saved to logs/pain_points_faq_audit.json\n";


