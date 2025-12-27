#!/usr/bin/env php
<?php
/**
 * Comprehensive Intent Alignment QA
 * Tests SEO title, meta description, H1, subhead, and CTA alignment with URL
 */

$baseUrl = 'http://localhost:8000';
$csvFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-27 (1)/Pages.csv';

$failed = 0;
$passed = 0;
$total = 0;
$results = [];
$issues = [];

echo "=== Intent Alignment QA (Title → Meta → Content) ===\n\n";

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
    
    // Extract service and city from path
    preg_match('#/services/([^/]+)/([^/]+)/#', $path, $matches);
    if (empty($matches)) {
        continue;
    }
    
    $serviceSlug = $matches[1];
    $citySlug = $matches[2];
    
    echo "Testing: $path\n";
    echo "  Service: $serviceSlug | City: $citySlug\n";
    
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
        echo "  ❌ FAIL: Could not fetch page\n\n";
        $failed++;
        $issues[] = [
            'url' => $path,
            'issue' => 'Could not fetch page'
        ];
        continue;
    }
    
    // Extract meta title
    preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatches);
    $metaTitle = isset($titleMatches[1]) ? html_entity_decode(trim($titleMatches[1]), ENT_QUOTES, 'UTF-8') : '';
    
    // Extract meta description
    preg_match('/<meta\s+name="description"\s+content="([^"]*)"/is', $html, $descMatches);
    $metaDesc = isset($descMatches[1]) ? html_entity_decode(trim($descMatches[1]), ENT_QUOTES, 'UTF-8') : '';
    
    // Extract H1
    preg_match('/<h1[^>]*class="[^"]*content-block__title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
    $h1 = isset($h1Matches[1]) ? html_entity_decode(strip_tags(trim($h1Matches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    // Extract subhead (first <p class="lead">)
    preg_match('/<p[^>]*class="[^"]*lead[^"]*"[^>]*>(.*?)<\/p>/is', $html, $subheadMatches);
    $subhead = isset($subheadMatches[1]) ? html_entity_decode(strip_tags(trim($subheadMatches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    // Extract CTA button text
    preg_match('/onclick="openContactSheet\([^)]+\)"[^>]*>(.*?)<\/button>/is', $html, $ctaMatches);
    $cta = isset($ctaMatches[1]) ? html_entity_decode(strip_tags(trim($ctaMatches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    $pageIssues = [];
    
    // Check 1: Meta title follows formula: {Service} in {Location} | {Modifier} | NRLC.ai
    $expectedTitlePattern = '/^(.+?)\s+in\s+(.+?)\s+\|\s+(.+?)\s+\|\s+NRLC\.ai$/i';
    if (!preg_match($expectedTitlePattern, $metaTitle)) {
        $pageIssues[] = "Meta title doesn't follow formula. Got: '$metaTitle'";
        $pageIssues[] = "  Expected: '{Service} in {Location} | {Modifier} | NRLC.ai'";
    }
    
    // Check 2: Meta description references service and location
    $serviceTitle = ucwords(str_replace(['-', '_'], ' ', $serviceSlug));
    $cityTitle = ucwords(str_replace(['-', '_'], ' ', $citySlug));
    
    if (empty($metaDesc)) {
        $pageIssues[] = "Meta description is empty";
    } else {
        // Check if description mentions service (case-insensitive)
        if (stripos($metaDesc, $serviceTitle) === false && stripos($metaDesc, $serviceSlug) === false) {
            $pageIssues[] = "Meta description doesn't mention service: '$serviceTitle'";
        }
        
        // Check if description mentions location (case-insensitive)
        if (stripos($metaDesc, $cityTitle) === false && stripos($metaDesc, $citySlug) === false) {
            $pageIssues[] = "Meta description doesn't mention location: '$cityTitle'";
        }
    }
    
    // Check 3: H1 restates URL promise
    if (empty($h1)) {
        $pageIssues[] = "H1 is missing";
    } else {
        // H1 should mention service and city
        $h1Lower = strtolower($h1);
        $serviceLower = strtolower($serviceTitle);
        $cityLower = strtolower($cityTitle);
        
        // Check if H1 mentions service (allow partial matches, handle abbreviations)
        $serviceFound = false;
        $serviceWords = explode(' ', $serviceLower);
        foreach ($serviceWords as $word) {
            // For short words (like "b2b", "ai", "seo"), check if they appear in H1
            if (strlen($word) >= 2 && strpos($h1Lower, $word) !== false) {
                $serviceFound = true;
                break;
            }
            // For longer words, require at least 3 chars
            if (strlen($word) > 3 && strpos($h1Lower, $word) !== false) {
                $serviceFound = true;
                break;
            }
        }
        
        // Also check if service slug appears in H1 (for cases like "b2b-seo-ai")
        if (!$serviceFound) {
            $serviceSlugLower = strtolower($serviceSlug);
            $serviceSlugWords = explode('-', $serviceSlugLower);
            foreach ($serviceSlugWords as $word) {
                if (strlen($word) >= 2 && strpos($h1Lower, $word) !== false) {
                    $serviceFound = true;
                    break;
                }
            }
        }
        
        if (!$serviceFound && strpos($h1Lower, str_replace([' ', '-'], '', $serviceLower)) === false) {
            $pageIssues[] = "H1 doesn't mention service. H1: '$h1' | Service: '$serviceTitle'";
        }
        
        // Check if H1 mentions city
        if (strpos($h1Lower, $cityLower) === false) {
            $pageIssues[] = "H1 doesn't mention city. H1: '$h1' | City: '$cityTitle'";
        }
    }
    
    // Check 4: Subhead confirms contract
    if (empty($subhead)) {
        $pageIssues[] = "Subhead (lead paragraph) is missing";
    } else {
        // Subhead should mention service or city
        $subheadLower = strtolower($subhead);
        if (stripos($subhead, $cityTitle) === false && stripos($subhead, $citySlug) === false) {
            $pageIssues[] = "Subhead doesn't mention location. Subhead: '$subhead'";
        }
    }
    
    // Check 5: CTA names service explicitly (not generic)
    if (empty($cta)) {
        $pageIssues[] = "CTA is missing";
    } else {
        $genericCTAs = ['contact us', 'learn more', 'get in touch', 'book a call'];
        $isGeneric = false;
        foreach ($genericCTAs as $generic) {
            if (stripos($cta, $generic) !== false) {
                $isGeneric = true;
                $pageIssues[] = "Generic CTA detected: '$cta'";
                break;
            }
        }
        
        // CTA should mention service or location
        if (!$isGeneric) {
            $ctaLower = strtolower($cta);
            $serviceWords = explode(' ', strtolower($serviceTitle));
            $hasService = false;
            foreach ($serviceWords as $word) {
                if (strlen($word) > 3 && strpos($ctaLower, $word) !== false) {
                    $hasService = true;
                    break;
                }
            }
            
            if (!$hasService && stripos($cta, $cityTitle) === false) {
                $pageIssues[] = "CTA doesn't mention service or location. CTA: '$cta'";
            }
        }
    }
    
    if (!empty($pageIssues)) {
        echo "  ❌ FAIL\n";
        foreach ($pageIssues as $issue) {
            echo "     - $issue\n";
        }
        $failed++;
        $issues[] = [
            'url' => $path,
            'service' => $serviceSlug,
            'city' => $citySlug,
            'meta_title' => $metaTitle,
            'meta_desc' => substr($metaDesc, 0, 80) . '...',
            'h1' => $h1,
            'cta' => $cta,
            'issues' => $pageIssues
        ];
    } else {
        echo "  ✅ PASS\n";
        echo "     Title: " . substr($metaTitle, 0, 70) . "...\n";
        echo "     H1: $h1\n";
        echo "     CTA: $cta\n";
        $passed++;
    }
    echo "\n";
}

fclose($handle);

echo "=== Summary ===\n";
echo "Total tested: $total\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n\n";

if ($failed > 0) {
    echo "=== Failed Pages (Detailed) ===\n";
    foreach ($issues as $issue) {
        echo "\n{$issue['url']}\n";
        echo "  Service: {$issue['service']} | City: {$issue['city']}\n";
        echo "  Meta Title: {$issue['meta_title']}\n";
        echo "  Meta Desc: {$issue['meta_desc']}\n";
        echo "  H1: {$issue['h1']}\n";
        echo "  CTA: {$issue['cta']}\n";
        echo "  Issues:\n";
        foreach ($issue['issues'] as $i) {
            echo "    - $i\n";
        }
    }
    exit(1);
} else {
    echo "✅ All pages passed intent alignment QA\n";
    exit(0);
}

