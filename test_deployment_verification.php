#!/usr/bin/env php
<?php
/**
 * Deployment Verification Test
 * Tests all critical changes: healthcheck, meta/H1/CTA alignment, localization
 */

$baseUrl = 'http://localhost:8000';
$passed = 0;
$failed = 0;
$issues = [];

echo "=== Deployment Verification Test ===\n\n";

// Test 1: Healthcheck endpoint
echo "1. Testing /healthz endpoint...\n";
$healthcheckUrl = $baseUrl . '/healthz';
$context = stream_context_create([
    'http' => [
        'timeout' => 5,
        'method' => 'GET'
    ]
]);
$response = @file_get_contents($healthcheckUrl, false, $context);
$headers = $http_response_header ?? [];

if ($response === 'OK' && !empty($headers)) {
    $statusCode = null;
    foreach ($headers as $header) {
        if (preg_match('/HTTP\/[\d.]+ (\d+)/', $header, $m)) {
            $statusCode = (int)$m[1];
            break;
        }
    }
    if ($statusCode === 200) {
        echo "   ✅ PASS: /healthz returns 200 OK\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: /healthz returned status $statusCode (expected 200)\n";
        $failed++;
        $issues[] = "/healthz returned status $statusCode";
    }
} else {
    echo "   ❌ FAIL: Could not fetch /healthz\n";
    $failed++;
    $issues[] = "Could not fetch /healthz";
}

// Test 2: Meta/H1/CTA alignment for en-us
echo "\n2. Testing en-us service page (meta/H1/CTA alignment)...\n";
$testUrl = $baseUrl . '/en-us/services/chatgpt-optimization/southport/';
$html = @file_get_contents($testUrl, false, $context);

if ($html === false) {
    echo "   ❌ FAIL: Could not fetch page\n";
    $failed++;
    $issues[] = "Could not fetch en-us test page";
} else {
    // Extract meta title
    preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatches);
    $metaTitle = isset($titleMatches[1]) ? html_entity_decode(trim($titleMatches[1]), ENT_QUOTES, 'UTF-8') : '';
    
    // Extract H1
    preg_match('/<h1[^>]*class="[^"]*content-block__title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
    $h1 = isset($h1Matches[1]) ? html_entity_decode(strip_tags(trim($h1Matches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    // Extract CTA
    preg_match('/onclick="openContactSheet\([^)]+\)"[^>]*>(.*?)<\/button>/is', $html, $ctaMatches);
    $cta = isset($ctaMatches[1]) ? html_entity_decode(strip_tags(trim($ctaMatches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    $checks = [
        'Meta title format' => preg_match('/Chatgpt Optimization in Southport \| Conversion \+ AI Visibility \| NRLC\.ai/i', $metaTitle),
        'H1 mentions service' => stripos($h1, 'Chatgpt Optimization') !== false,
        'H1 mentions city' => stripos($h1, 'Southport') !== false,
        'CTA is service-named' => stripos($cta, 'Request') !== false && stripos($cta, 'Chatgpt') !== false,
        'CTA mentions location' => stripos($cta, 'Southport') !== false,
    ];
    
    $allPassed = true;
    foreach ($checks as $check => $result) {
        if ($result) {
            echo "   ✅ $check\n";
        } else {
            echo "   ❌ $check\n";
            $allPassed = false;
        }
    }
    
    if ($allPassed) {
        $passed++;
    } else {
        $failed++;
        $issues[] = "en-us page alignment issues";
    }
}

// Test 3: Localization - fr-fr
echo "\n3. Testing fr-fr localization...\n";
$testUrl = $baseUrl . '/fr-fr/services/chatgpt-optimization/southport/';
$html = @file_get_contents($testUrl, false, $context);

if ($html === false) {
    echo "   ❌ FAIL: Could not fetch fr-fr page\n";
    $failed++;
    $issues[] = "Could not fetch fr-fr test page";
} else {
    preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatches);
    $metaTitle = isset($titleMatches[1]) ? html_entity_decode(trim($titleMatches[1]), ENT_QUOTES, 'UTF-8') : '';
    
    preg_match('/<h1[^>]*class="[^"]*content-block__title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
    $h1 = isset($h1Matches[1]) ? html_entity_decode(strip_tags(trim($h1Matches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    preg_match('/onclick="openContactSheet\([^)]+\)"[^>]*>(.*?)<\/button>/is', $html, $ctaMatches);
    $cta = isset($ctaMatches[1]) ? html_entity_decode(strip_tags(trim($ctaMatches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    // Debug output
    echo "   DEBUG - Meta Title: " . substr($metaTitle, 0, 80) . "...\n";
    echo "   DEBUG - H1: " . substr($h1, 0, 60) . "...\n";
    echo "   DEBUG - CTA: " . substr($cta, 0, 60) . "...\n";
    
    $checks = [
        'Meta title has French modifier' => stripos($metaTitle, 'visibilité IA') !== false,
        'Meta title uses "à"' => stripos($metaTitle, 'à Southport') !== false,
        'H1 is in French' => stripos($h1, 'pour les entreprises') !== false,
        'CTA is in French' => stripos($cta, 'Demander') !== false,
    ];
    
    $allPassed = true;
    foreach ($checks as $check => $result) {
        if ($result) {
            echo "   ✅ $check\n";
        } else {
            echo "   ❌ $check\n";
            $allPassed = false;
        }
    }
    
    if ($allPassed) {
        $passed++;
    } else {
        $failed++;
        $issues[] = "fr-fr localization issues";
    }
}

// Test 4: Localization - ko-kr
echo "\n4. Testing ko-kr localization...\n";
$testUrl = $baseUrl . '/ko-kr/services/chatgpt-optimization/southport/';
$html = @file_get_contents($testUrl, false, $context);

if ($html === false) {
    echo "   ❌ FAIL: Could not fetch ko-kr page\n";
    $failed++;
    $issues[] = "Could not fetch ko-kr test page";
} else {
    preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatches);
    $metaTitle = isset($titleMatches[1]) ? html_entity_decode(trim($titleMatches[1]), ENT_QUOTES, 'UTF-8') : '';
    
    preg_match('/<h1[^>]*class="[^"]*content-block__title[^"]*"[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
    $h1 = isset($h1Matches[1]) ? html_entity_decode(strip_tags(trim($h1Matches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    preg_match('/onclick="openContactSheet\([^"]+\)"[^>]*>(.*?)<\/button>/is', $html, $ctaMatches);
    $cta = isset($ctaMatches[1]) ? html_entity_decode(strip_tags(trim($ctaMatches[1])), ENT_QUOTES, 'UTF-8') : '';
    
    $checks = [
        'Meta title has Korean modifier' => mb_strpos($metaTitle, 'AI 가시성') !== false || mb_strpos($metaTitle, '전환') !== false,
        'H1 has Korean text' => mb_strpos($h1, '비즈니스') !== false || mb_strpos($h1, '를 위한') !== false,
        'CTA has Korean text' => mb_strpos($cta, '요청') !== false,
    ];
    
    $allPassed = true;
    foreach ($checks as $check => $result) {
        if ($result) {
            echo "   ✅ $check\n";
        } else {
            echo "   ❌ $check\n";
            $allPassed = false;
        }
    }
    
    if ($allPassed) {
        $passed++;
    } else {
        $failed++;
        $issues[] = "ko-kr localization issues";
    }
}

// Test 5: Homepage never returns 5xx
echo "\n5. Testing homepage fallback (should never return 5xx)...\n";
$testUrl = $baseUrl . '/';
$html = @file_get_contents($testUrl, false, $context);
$headers = $http_response_header ?? [];

$statusCode = null;
foreach ($headers as $header) {
    if (preg_match('/HTTP\/[\d.]+ (\d+)/', $header, $m)) {
        $statusCode = (int)$m[1];
        break;
    }
}

if ($statusCode === 200 || $statusCode === 301 || $statusCode === 302) {
    echo "   ✅ PASS: Homepage returns $statusCode (acceptable)\n";
    $passed++;
} else {
    echo "   ❌ FAIL: Homepage returned status $statusCode (expected 200/301/302)\n";
    $failed++;
    $issues[] = "Homepage returned status $statusCode";
}

// Test 6: Secondary CTA exists
echo "\n6. Testing secondary CTA (See Proof / Case Studies)...\n";
$testUrl = $baseUrl . '/en-us/services/chatgpt-optimization/southport/';
$html = @file_get_contents($testUrl, false, $context);

if ($html === false) {
    echo "   ❌ FAIL: Could not fetch page\n";
    $failed++;
    $issues[] = "Could not fetch page for secondary CTA test";
} else {
    if (stripos($html, 'See Proof') !== false || stripos($html, 'Case Studies') !== false) {
        echo "   ✅ PASS: Secondary CTA found\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: Secondary CTA not found\n";
        $failed++;
        $issues[] = "Secondary CTA missing";
    }
}

// Summary
echo "\n=== Test Summary ===\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n\n";

if ($failed > 0) {
    echo "Issues found:\n";
    foreach ($issues as $issue) {
        echo "  - $issue\n";
    }
    echo "\n⚠️  Some tests failed. Review issues before deployment.\n";
    exit(1);
} else {
    echo "✅ All tests passed! Ready for deployment.\n";
    exit(0);
}

