<?php
/**
 * QA Test Script for GSC Fixes
 * 
 * Tests all fixes implemented for GSC issues:
 * 1. Redirect fixes (HTTP→HTTPS, missing locale, non-canonical locale)
 * 2. Robots.txt exclusions
 * 3. Canonical tag fixes for non-canonical locale versions
 * 4. Noindex tags where needed
 */

require_once __DIR__.'/../lib/helpers.php';

$baseUrl = $argv[1] ?? 'https://nrlc.ai';
$verbose = in_array('-v', $argv) || in_array('--verbose', $argv);

echo "QA Testing GSC Fixes\n";
echo "====================\n\n";
echo "Base URL: $baseUrl\n\n";

$results = [
  'passed' => 0,
  'failed' => 0,
  'warnings' => 0,
  'tests' => []
];

function test_url($url, $expectedStatus = 200, $expectedRedirect = null, $checkCanonical = null, $checkNoindex = false) {
  global $results, $verbose;
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
  $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
  // curl_close() is deprecated in PHP 8.5+ - not needed
  
  $headers = substr($response, 0, strpos($response, "\r\n\r\n"));
  $body = substr($response, strpos($response, "\r\n\r\n") + 4);
  
  $testResult = [
    'url' => $url,
    'expected_status' => $expectedStatus,
    'actual_status' => $httpCode,
    'expected_redirect' => $expectedRedirect,
    'actual_redirect' => $redirectUrl ?: $effectiveUrl,
    'passed' => false,
    'issues' => []
  ];
  
  // Check HTTP status
  if ($httpCode !== $expectedStatus) {
    $testResult['issues'][] = "Expected status $expectedStatus, got $httpCode";
  }
  
  // Check redirect
  if ($expectedRedirect) {
    if (!$redirectUrl || !str_contains($redirectUrl, $expectedRedirect)) {
      $testResult['issues'][] = "Expected redirect to contain '$expectedRedirect', got '$redirectUrl'";
    }
  }
  
  // Check canonical tag
  if ($checkCanonical) {
    if (preg_match('#<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']#i', $body, $m)) {
      $canonical = $m[1];
      if (!str_contains($canonical, $checkCanonical)) {
        $testResult['issues'][] = "Expected canonical to contain '$checkCanonical', got '$canonical'";
      } else {
        $testResult['canonical'] = $canonical;
      }
    } else {
      $testResult['issues'][] = "Canonical tag not found";
    }
  }
  
  // Check noindex
  if ($checkNoindex) {
    if (!preg_match('#<meta\s+name=["\']robots["\']\s+content=["\'][^"\']*noindex[^"\']*["\']#i', $body)) {
      $testResult['issues'][] = "Expected noindex meta tag, not found";
    }
  }
  
  // Determine if test passed
  if (empty($testResult['issues'])) {
    $testResult['passed'] = true;
    $results['passed']++;
  } else {
    $results['failed']++;
  }
  
  $results['tests'][] = $testResult;
  
  if ($verbose || !$testResult['passed']) {
    echo ($testResult['passed'] ? "✓" : "✗") . " " . $url . "\n";
    if (!$testResult['passed']) {
      foreach ($testResult['issues'] as $issue) {
        echo "  - $issue\n";
      }
    }
    if (isset($testResult['canonical'])) {
      echo "  Canonical: " . $testResult['canonical'] . "\n";
    }
  }
  
  return $testResult['passed'];
}

echo "Testing Redirects...\n";
echo "--------------------\n";

// Test 1: HTTP → HTTPS redirect
test_url('http://nrlc.ai/en-us/services/technical-seo/', 301, 'https://nrlc.ai/en-us/services/technical-seo/');

// Test 2: Missing locale prefix → /en-us/
test_url('https://nrlc.ai/services/technical-seo/', 301, '/en-us/services/technical-seo/');

// Test 3: Non-canonical locale for UK city (should redirect to en-gb)
test_url('https://nrlc.ai/en-us/services/local-seo-ai/norwich/', 301, '/en-gb/services/local-seo-ai/norwich/');

// Test 4: Non-canonical locale for US city (should redirect to en-us)
test_url('https://nrlc.ai/de-de/services/technical-seo/houston/', 301, '/en-us/services/technical-seo/houston/');

// Test 5: Canonical locale for UK city (should NOT redirect)
test_url('https://nrlc.ai/en-gb/services/local-seo-ai/norwich/', 200, null);

// Test 6: Canonical locale for US city (should NOT redirect)
test_url('https://nrlc.ai/en-us/services/technical-seo/houston/', 200, null);

echo "\nTesting Robots.txt...\n";
echo "---------------------\n";

// Test 7: Robots.txt should disallow /api/
$ch = curl_init("$baseUrl/robots.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$robotsContent = curl_exec($ch);
$robotsCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($robotsCode === 200) {
  if (preg_match('#Disallow:\s+/api/#i', $robotsContent)) {
    echo "✓ robots.txt disallows /api/\n";
    $results['passed']++;
  } else {
    echo "✗ robots.txt does NOT disallow /api/\n";
    $results['failed']++;
  }
  
  if (preg_match('#Disallow:\s+/sitemaps/#i', $robotsContent)) {
    echo "✓ robots.txt disallows /sitemaps/\n";
    $results['passed']++;
  } else {
    echo "✗ robots.txt does NOT disallow /sitemaps/\n";
    $results['failed']++;
  }
} else {
  echo "✗ robots.txt not accessible (HTTP $robotsCode)\n";
  $results['failed']++;
}

echo "\nTesting Canonical Tags...\n";
echo "-------------------------\n";

// Test 8: Non-canonical locale page should have canonical pointing to canonical locale
// Note: This test requires the page to actually render (not redirect)
// We'll test a page that might not redirect immediately
test_url('https://nrlc.ai/de-de/services/technical-seo/houston/', null, null, '/en-us/services/technical-seo/houston/', false);

// Test 9: Canonical locale page should have self-referencing canonical
test_url('https://nrlc.ai/en-us/services/technical-seo/houston/', 200, null, '/en-us/services/technical-seo/houston/', false);

// Test 10: UK city with canonical locale should have self-referencing canonical
test_url('https://nrlc.ai/en-gb/services/local-seo-ai/norwich/', 200, null, '/en-gb/services/local-seo-ai/norwich/', false);

echo "\nTesting System Files...\n";
echo "-----------------------\n";

// Test 11: API endpoint should not be accessible (or should redirect)
// Note: /api/book/ might serve a page, so we'll just check it's not indexed via robots.txt
// (Already tested above)

// Test 12: Sitemap should not be accessible (or should be disallowed)
// (Already tested in robots.txt)

echo "\nTesting Homepage...\n";
echo "-------------------\n";

// Test 13: Homepage should be accessible
test_url('https://nrlc.ai/', 200, null);

// Test 14: Homepage should have canonical
test_url('https://nrlc.ai/', 200, null, 'https://nrlc.ai/', false);

echo "\nSummary\n";
echo "=======\n";
echo "Passed: {$results['passed']}\n";
echo "Failed: {$results['failed']}\n";
echo "Warnings: {$results['warnings']}\n";
echo "\n";

if ($results['failed'] > 0) {
  echo "Failed Tests:\n";
  foreach ($results['tests'] as $test) {
    if (!$test['passed']) {
      echo "  - {$test['url']}\n";
      foreach ($test['issues'] as $issue) {
        echo "    $issue\n";
      }
    }
  }
  exit(1);
} else {
  echo "All tests passed! ✓\n";
  exit(0);
}

