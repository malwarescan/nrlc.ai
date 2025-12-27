<?php
/**
 * QA Script: Verify HTTPS compliance for all AI Visibility pages
 * Tests canonical URLs, JSON-LD schema URLs, and HTTPS enforcement
 */

$baseUrl = 'http://localhost:8000';
$pages = [
    'real-estate',
    'immigration',
    'private-investigator',
    'funeral',
    'auto-repair',
    'senior-care',
    'contractor',
    'financial-advisor',
    'veterinary',
    'private-school'
];

$results = [];
$errors = [];
$warnings = [];

echo "=== AI Visibility Pages HTTPS Compliance QA ===\n\n";

foreach ($pages as $page) {
    $url = "$baseUrl/en-us/ai-visibility/$page/";
    echo "Testing: $page...\n";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    
    curl_close($ch);
    
    $pageResults = [
        'page' => $page,
        'url' => $url,
        'http_code' => $httpCode,
        'errors' => [],
        'warnings' => [],
        'passed' => []
    ];
    
    // Check HTTP status
    if ($httpCode !== 200) {
        $pageResults['errors'][] = "HTTP Status: $httpCode (expected 200)";
    } else {
        $pageResults['passed'][] = "HTTP Status: 200 OK";
    }
    
    // Check for canonical tag
    if (preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']/i', $body, $matches)) {
        $canonical = $matches[1];
        $pageResults['canonical'] = $canonical;
        
        // Check if canonical includes locale prefix
        if (strpos($canonical, '/en-us/') !== false) {
            $pageResults['passed'][] = "Canonical includes locale prefix (/en-us/)";
        } else {
            $pageResults['errors'][] = "Canonical missing locale prefix: $canonical";
        }
        
        // Check if canonical is HTTPS (for production, localhost will be HTTP)
        if (strpos($canonical, 'https://') === 0) {
            $pageResults['passed'][] = "Canonical uses HTTPS";
        } elseif (strpos($canonical, 'http://localhost') === 0) {
            $pageResults['passed'][] = "Canonical uses HTTP (localhost - expected)";
        } else {
            $pageResults['warnings'][] = "Canonical not HTTPS: $canonical";
        }
        
        // Check if canonical matches expected pattern
        $expectedPattern = "/en-us/ai-visibility/$page/";
        if (strpos($canonical, $expectedPattern) !== false) {
            $pageResults['passed'][] = "Canonical matches expected pattern";
        } else {
            $pageResults['errors'][] = "Canonical doesn't match expected pattern. Got: $canonical, Expected: *$expectedPattern";
        }
    } else {
        $pageResults['errors'][] = "Canonical tag not found";
    }
    
    // Check for og:url
    if (preg_match('/<meta\s+property=["\']og:url["\']\s+content=["\']([^"\']+)["\']/i', $body, $matches)) {
        $ogUrl = $matches[1];
        $pageResults['og_url'] = $ogUrl;
        
        // Check if og:url matches canonical
        if (isset($pageResults['canonical']) && $ogUrl === $pageResults['canonical']) {
            $pageResults['passed'][] = "og:url matches canonical";
        } else {
            $pageResults['warnings'][] = "og:url doesn't match canonical. og:url: $ogUrl, canonical: " . ($pageResults['canonical'] ?? 'N/A');
        }
    } else {
        $pageResults['warnings'][] = "og:url meta tag not found";
    }
    
    // Check for JSON-LD schema
    if (preg_match('/<script\s+type=["\']application\/ld\+json["\']>(.*?)<\/script>/is', $body, $matches)) {
        $jsonLd = json_decode($matches[1], true);
        
        if ($jsonLd && is_array($jsonLd)) {
            // Check if it's an array of schemas
            $schemas = isset($jsonLd[0]) ? $jsonLd : [$jsonLd];
            
            foreach ($schemas as $schema) {
                // Check for WebPage schema
                if (isset($schema['@type']) && $schema['@type'] === 'WebPage' && isset($schema['url'])) {
                    $schemaUrl = $schema['url'];
                    if (strpos($schemaUrl, 'https://') === 0 || strpos($schemaUrl, 'http://localhost') === 0) {
                        $pageResults['passed'][] = "JSON-LD WebPage schema URL is HTTPS/localhost";
                    } else {
                        $pageResults['errors'][] = "JSON-LD WebPage schema URL not HTTPS: $schemaUrl";
                    }
                    
                    if (strpos($schemaUrl, '/en-us/') !== false) {
                        $pageResults['passed'][] = "JSON-LD WebPage schema URL includes locale prefix";
                    } else {
                        $pageResults['errors'][] = "JSON-LD WebPage schema URL missing locale prefix: $schemaUrl";
                    }
                }
                
                // Check for Service schema
                if (isset($schema['@type']) && $schema['@type'] === 'Service' && isset($schema['url'])) {
                    $schemaUrl = $schema['url'];
                    if (strpos($schemaUrl, 'https://') === 0 || strpos($schemaUrl, 'http://localhost') === 0) {
                        $pageResults['passed'][] = "JSON-LD Service schema URL is HTTPS/localhost";
                    } else {
                        $pageResults['errors'][] = "JSON-LD Service schema URL not HTTPS: $schemaUrl";
                    }
                }
            }
        }
    } else {
        $pageResults['warnings'][] = "JSON-LD schema not found";
    }
    
    // Check for H1
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $body, $matches)) {
        $h1 = trim(strip_tags($matches[1]));
        if (!empty($h1)) {
            $pageResults['passed'][] = "H1 found: " . substr($h1, 0, 50) . "...";
        } else {
            $pageResults['errors'][] = "H1 is empty";
        }
    } else {
        $pageResults['errors'][] = "H1 not found";
    }
    
    $results[] = $pageResults;
    
    // Print summary
    $errorCount = count($pageResults['errors']);
    $warningCount = count($pageResults['warnings']);
    $passCount = count($pageResults['passed']);
    
    if ($errorCount > 0) {
        echo "  ❌ FAILED: $errorCount error(s), $warningCount warning(s), $passCount check(s) passed\n";
        $errors = array_merge($errors, array_map(function($err) use ($page) {
            return "[$page] $err";
        }, $pageResults['errors']));
    } elseif ($warningCount > 0) {
        echo "  ⚠️  WARNINGS: $warningCount warning(s), $passCount check(s) passed\n";
        $warnings = array_merge($warnings, array_map(function($warn) use ($page) {
            return "[$page] $warn";
        }, $pageResults['warnings']));
    } else {
        echo "  ✅ PASSED: All $passCount check(s) passed\n";
    }
    echo "\n";
}

// Summary
echo "=== SUMMARY ===\n\n";
echo "Total pages tested: " . count($results) . "\n";

$totalErrors = count($errors);
$totalWarnings = count($warnings);
$totalPassed = array_sum(array_map(function($r) { return count($r['passed']); }, $results));

$pagesWithErrors = count(array_filter($results, function($r) { return count($r['errors']) > 0; }));
$pagesWithWarnings = count(array_filter($results, function($r) { return count($r['warnings']) > 0; }));
$pagesPassed = count(array_filter($results, function($r) { return count($r['errors']) === 0 && count($r['warnings']) === 0; }));

echo "Pages passed: $pagesPassed\n";
echo "Pages with warnings: $pagesWithWarnings\n";
echo "Pages with errors: $pagesWithErrors\n\n";

echo "Total checks passed: $totalPassed\n";
echo "Total warnings: $totalWarnings\n";
echo "Total errors: $totalErrors\n\n";

if ($totalErrors > 0) {
    echo "=== ERRORS ===\n";
    foreach ($errors as $error) {
        echo "  ❌ $error\n";
    }
    echo "\n";
}

if ($totalWarnings > 0) {
    echo "=== WARNINGS ===\n";
    foreach ($warnings as $warning) {
        echo "  ⚠️  $warning\n";
    }
    echo "\n";
}

if ($totalErrors === 0 && $totalWarnings === 0) {
    echo "✅ ALL CHECKS PASSED!\n";
    exit(0);
} elseif ($totalErrors === 0) {
    echo "⚠️  All critical checks passed, but some warnings exist.\n";
    exit(0);
} else {
    echo "❌ SOME CHECKS FAILED\n";
    exit(1);
}

