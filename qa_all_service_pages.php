#!/usr/bin/env php
<?php
/**
 * QA Script for All Service Pages from Performance CSV
 * Tests H1, CTA, and Meta alignment for intent taxonomy
 */

$baseUrl = 'http://localhost:8000';
$csvFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-27/Pages.csv';

$failed = 0;
$passed = 0;
$total = 0;
$results = [];

echo "=== Service Intent Taxonomy QA ===\n\n";

// Read CSV
if (!file_exists($csvFile)) {
    die("Error: CSV file not found: $csvFile\n");
}

$handle = fopen($csvFile, 'r');
if (!$handle) {
    die("Error: Could not open CSV file\n");
}

// Skip header
fgetcsv($handle);

// Process each URL
while (($row = fgetcsv($handle)) !== false) {
    $url = trim($row[0] ?? '');
    
    // Skip empty lines
    if (empty($url)) {
        continue;
    }
    
    // Only test /services/ pages
    if (strpos($url, '/services/') === false) {
        continue;
    }
    
    $total++;
    
    // Extract path from full URL
    $path = parse_url($url, PHP_URL_PATH);
    
    echo "Testing: $path\n";
    
    // Fetch page
    $fullUrl = $baseUrl . $path;
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'follow_location' => true,
            'max_redirects' => 5
        ]
    ]);
    
    $html = @file_get_contents($fullUrl, false, $context);
    
    if ($html === false) {
        echo "  ❌ FAIL: Could not fetch page\n";
        $failed++;
        $results[] = [
            'url' => $path,
            'status' => 'FAIL',
            'reason' => 'Could not fetch page'
        ];
        continue;
    }
    
    // Extract H1
    preg_match('/<h1[^>]*class="[^"]*content-block__title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
    $h1 = isset($h1Matches[1]) ? strip_tags(trim($h1Matches[1])) : '';
    
    // Extract CTA button text (look for onclick with openContactSheet)
    preg_match('/onclick="openContactSheet\([^)]+\)"[^>]*>(.*?)<\/button>/is', $html, $ctaMatches);
    $cta = isset($ctaMatches[1]) ? strip_tags(trim($ctaMatches[1])) : '';
    
    // Extract meta title
    preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatches);
    $title = isset($titleMatches[1]) ? trim($titleMatches[1]) : '';
    
    // Extract meta description
    preg_match('/<meta\s+name="description"\s+content="([^"]*)"/is', $html, $descMatches);
    $desc = isset($descMatches[1]) ? trim($descMatches[1]) : '';
    
    $issues = [];
    
    // Check 1: H1 exists and is not empty
    if (empty($h1)) {
        $issues[] = 'No H1 found';
    }
    
    // Check 2: CTA exists
    if (empty($cta)) {
        $issues[] = 'No CTA found';
    }
    
    // Check 3: CTA is not generic
    $genericCTAs = ['contact us', 'learn more', 'get in touch', 'book a call'];
    $isGeneric = false;
    foreach ($genericCTAs as $generic) {
        if (stripos($cta, $generic) !== false) {
            $isGeneric = true;
            $issues[] = "Generic CTA detected: '$cta'";
            break;
        }
    }
    
    // Check 4: Meta title follows formula (for geo pages)
    $isGeoPage = preg_match('#/services/[^/]+/[^/]+/#', $path);
    if ($isGeoPage && !empty($title)) {
        if (stripos($title, ' in ') === false) {
            $issues[] = "Meta title may not follow geo formula: '$title'";
        }
    }
    
    // Check 5: Meta description exists
    if (empty($desc)) {
        $issues[] = 'No meta description found';
    }
    
    if (!empty($issues)) {
        echo "  ❌ FAIL\n";
        foreach ($issues as $issue) {
            echo "     - $issue\n";
        }
        $failed++;
        $results[] = [
            'url' => $path,
            'status' => 'FAIL',
            'h1' => $h1,
            'cta' => $cta,
            'title' => $title,
            'issues' => $issues
        ];
    } else {
        echo "  ✅ PASS\n";
        echo "     H1: $h1\n";
        echo "     CTA: $cta\n";
        echo "     Title: " . substr($title, 0, 80) . "...\n";
        echo "\n";
        $passed++;
        $results[] = [
            'url' => $path,
            'status' => 'PASS',
            'h1' => $h1,
            'cta' => $cta,
            'title' => $title
        ];
    }
}

fclose($handle);

echo "\n=== Summary ===\n";
echo "Total tested: $total\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n\n";

if ($failed > 0) {
    echo "=== Failed Pages ===\n";
    foreach ($results as $result) {
        if ($result['status'] === 'FAIL') {
            echo "\n{$result['url']}\n";
            foreach ($result['issues'] as $issue) {
                echo "  - $issue\n";
            }
        }
    }
    exit(1);
} else {
    echo "✅ All pages passed QA\n";
    exit(0);
}

