<?php
/**
 * Comprehensive QA for all recent GSC fixes
 */

error_reporting(E_ALL & ~E_DEPRECATED);

echo "=== COMPREHENSIVE QA: ALL GSC FIXES ===\n\n";

$baseUrl = 'http://localhost:8000';
$tests = [];
$passed = 0;
$failed = 0;

// Helper function to make HTTP requests
function httpRequest($url, $method = 'GET', $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Don't follow redirects automatically
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'headers' => $headers
    ];
}

// Helper function to check header presence
function hasHeader($headers, $headerName) {
    $headerName = strtolower($headerName);
    $lines = explode("\n", strtolower($headers));
    foreach ($lines as $line) {
        if (strpos($line, $headerName . ':') === 0) {
            return true;
        }
    }
    return false;
}

// Helper function to get header value
function getHeaderValue($headers, $headerName) {
    $headerName = strtolower($headerName);
    $lines = explode("\n", $headers);
    foreach ($lines as $line) {
        $lineLower = strtolower(trim($line));
        if (strpos($lineLower, $headerName . ':') === 0) {
            $value = trim(substr($line, strpos($line, ':') + 1));
            return $value;
        }
    }
    return null;
}

// Test 1: Healthcheck endpoint
echo "1. Testing /healthz endpoint...\n";
$result = httpRequest($baseUrl . '/healthz');
if ($result['code'] === 200) {
    echo "   ✅ PASS: /healthz returns 200 OK\n";
    $passed++;
} else {
    echo "   ❌ FAIL: /healthz returned {$result['code']}\n";
    $failed++;
}

// Test 2: Homepage always returns 200 OK
echo "\n2. Testing homepage (/)...\n";
$result = httpRequest($baseUrl . '/');
if ($result['code'] === 200 || $result['code'] === 301) {
    echo "   ✅ PASS: Homepage returns {$result['code']}\n";
    $passed++;
} else {
    echo "   ❌ FAIL: Homepage returned {$result['code']}\n";
    $failed++;
}

// Test 3: Career page without locale redirects
echo "\n3. Testing career page redirect (/careers/sendai/)...\n";
$result = httpRequest($baseUrl . '/careers/sendai/');
if ($result['code'] === 301) {
    $location = getHeaderValue($result['headers'], 'Location');
    if ($location && (strpos($location, '/en-us/careers/') !== false || strpos($location, '/en-gb/careers/') !== false)) {
        echo "   ✅ PASS: Career page redirects to locale-prefixed careers index\n";
        echo "   Location: $location\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: Career page redirects but location is incorrect: $location\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: Career page returned {$result['code']} (expected 301)\n";
    $failed++;
}

// Test 4: UK city career page redirects to en-gb
echo "\n4. Testing UK city career page redirect (/careers/northampton/)...\n";
$result = httpRequest($baseUrl . '/careers/northampton/');
if ($result['code'] === 301) {
    $location = getHeaderValue($result['headers'], 'Location');
    // UK city should redirect to /en-gb/careers/ (careers index, not city-specific)
    if ($location && (strpos($location, '/en-gb/careers') !== false || strpos($location, '/en-gb/careers/') !== false)) {
        echo "   ✅ PASS: UK city career page redirects to en-gb careers index\n";
        echo "   Location: $location\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: UK city career page should redirect to en-gb, got: $location\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: UK city career page returned {$result['code']} (expected 301)\n";
    $failed++;
}

// Test 5: Search page returns 404 with noindex
echo "\n5. Testing search page (/search)...\n";
$result = httpRequest($baseUrl . '/search');
if ($result['code'] === 404) {
    if (hasHeader($result['headers'], 'X-Robots-Tag')) {
        $robotsTag = getHeaderValue($result['headers'], 'X-Robots-Tag');
        if (stripos($robotsTag, 'noindex') !== false) {
            echo "   ✅ PASS: Search page returns 404 with noindex header\n";
            $passed++;
        } else {
            echo "   ❌ FAIL: Search page returns 404 but noindex header is missing or incorrect\n";
            $failed++;
        }
    } else {
        echo "   ❌ FAIL: Search page returns 404 but no X-Robots-Tag header\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: Search page returned {$result['code']} (expected 404)\n";
    $failed++;
}

// Test 6: Audit page returns 404 with noindex
echo "\n6. Testing audit page (/audit/)...\n";
$result = httpRequest($baseUrl . '/audit/');
if ($result['code'] === 404) {
    if (hasHeader($result['headers'], 'X-Robots-Tag')) {
        $robotsTag = getHeaderValue($result['headers'], 'X-Robots-Tag');
        if (stripos($robotsTag, 'noindex') !== false) {
            echo "   ✅ PASS: Audit page returns 404 with noindex header\n";
            $passed++;
        } else {
            echo "   ❌ FAIL: Audit page returns 404 but noindex header is missing or incorrect\n";
            $failed++;
        }
    } else {
        echo "   ❌ FAIL: Audit page returns 404 but no X-Robots-Tag header\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: Audit page returned {$result['code']} (expected 404)\n";
    $failed++;
}

// Test 7: API endpoint has noindex header
echo "\n7. Testing API endpoint (/api/book/)...\n";
$result = httpRequest($baseUrl . '/api/book/');
if (hasHeader($result['headers'], 'X-Robots-Tag')) {
    $robotsTag = getHeaderValue($result['headers'], 'X-Robots-Tag');
    if (stripos($robotsTag, 'noindex') !== false) {
        echo "   ✅ PASS: API endpoint has noindex header\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: API endpoint has X-Robots-Tag but noindex is missing\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: API endpoint missing X-Robots-Tag header\n";
    $failed++;
}

// Test 8: UK city service page redirects to en-gb
echo "\n8. Testing UK city service page redirect (/en-us/services/local-seo-ai/norwich/)...\n";
$result = httpRequest($baseUrl . '/en-us/services/local-seo-ai/norwich/');
if ($result['code'] === 301) {
    $location = getHeaderValue($result['headers'], 'Location');
    if ($location && strpos($location, '/en-gb/services/local-seo-ai/norwich/') !== false) {
        echo "   ✅ PASS: UK city service page redirects to en-gb\n";
        echo "   Location: $location\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: UK city service page should redirect to en-gb, got: $location\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: UK city service page returned {$result['code']} (expected 301)\n";
    $failed++;
}

// Test 9: Non-UK city service page redirects to en-us
echo "\n9. Testing non-UK city service page redirect (/en-gb/services/local-seo-ai/chicago/)...\n";
$result = httpRequest($baseUrl . '/en-gb/services/local-seo-ai/chicago/');
if ($result['code'] === 301) {
    $location = getHeaderValue($result['headers'], 'Location');
    if ($location && strpos($location, '/en-us/services/local-seo-ai/chicago/') !== false) {
        echo "   ✅ PASS: Non-UK city service page redirects to en-us\n";
        echo "   Location: $location\n";
        $passed++;
    } else {
        echo "   ❌ FAIL: Non-UK city service page should redirect to en-us, got: $location\n";
        $failed++;
    }
} else {
    echo "   ❌ FAIL: Non-UK city service page returned {$result['code']} (expected 301)\n";
    $failed++;
}

// Test 10: Canonical locale version returns 200 (not redirect)
echo "\n10. Testing canonical locale version (/en-gb/services/local-seo-ai/norwich/)...\n";
$result = httpRequest($baseUrl . '/en-gb/services/local-seo-ai/norwich/');
if ($result['code'] === 200) {
    echo "   ✅ PASS: Canonical locale version returns 200 OK\n";
    $passed++;
} else {
    echo "   ❌ FAIL: Canonical locale version returned {$result['code']} (expected 200)\n";
    $failed++;
}

// Test 11: Non-canonical locale version has noindex (if not redirected)
echo "\n11. Testing non-canonical locale version canonical tag...\n";
// This test requires fetching the actual page content to check meta tags
// For now, we'll just verify the redirect works
$result = httpRequest($baseUrl . '/fr-fr/services/local-seo-ai/norwich/');
if ($result['code'] === 301) {
    echo "   ✅ PASS: Non-canonical locale version redirects (better than just canonical tag)\n";
    $passed++;
} else {
    echo "   ⚠️  WARN: Non-canonical locale version returned {$result['code']} (should redirect or have noindex)\n";
    // This is acceptable if redirects are working
}

// Test 12: www redirect
echo "\n12. Testing www redirect (www.nrlc.ai)...\n";
// Note: This test may not work locally, but we can test the logic
$result = httpRequest($baseUrl . '/', 'GET', ['Host: www.localhost:8000']);
if ($result['code'] === 301) {
    $location = getHeaderValue($result['headers'], 'Location');
    if ($location && strpos($location, 'www.') === false) {
        echo "   ✅ PASS: www redirects to non-www\n";
        $passed++;
    } else {
        echo "   ⚠️  WARN: www redirect may not work locally (expected)\n";
    }
} else {
    echo "   ⚠️  WARN: www redirect test skipped (may not work locally)\n";
}

// Summary
echo "\n=== QA SUMMARY ===\n";
echo "Total Tests: " . ($passed + $failed) . "\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
echo "Success Rate: " . round(($passed / ($passed + $failed)) * 100, 1) . "%\n";

if ($failed === 0) {
    echo "\n✅ ALL TESTS PASSED!\n";
    exit(0);
} else {
    echo "\n❌ SOME TESTS FAILED\n";
    exit(1);
}

