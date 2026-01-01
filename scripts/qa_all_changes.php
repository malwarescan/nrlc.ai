<?php
/**
 * QA All Changes - Test all URLs we've created/modified
 * Checks HTTP status, canonical tags, schema, content, and links
 */

$baseUrl = 'http://localhost:8000';

// URLs to test
$urlsToTest = [
  // New pages created
  [
    'url' => '/en-us/generative-engine-optimization/decision-traces/',
    'type' => 'new_page',
    'checks' => ['status', 'canonical', 'schema', 'content', 'title'],
    'expected_content' => ['Decision Traces in Generative Search', 'What a Decision Trace Is', 'Context Graphs']
  ],
  [
    'url' => '/en-us/glossary/decision-traces/',
    'type' => 'new_page',
    'checks' => ['status', 'canonical', 'schema', 'content'],
    'expected_content' => ['Decision Trace', 'Definition', 'Key Characteristics']
  ],
  // New failure mode pages
  [
    'url' => '/en-us/generative-engine-optimization/failure-modes/schema-noise/',
    'type' => 'new_page',
    'checks' => ['status', 'canonical', 'schema', 'content'],
    'expected_content' => ['Schema Noise', 'What the Model Sees', 'Mitigation Strategy']
  ],
  [
    'url' => '/en-us/generative-engine-optimization/failure-modes/faceted-navigation/',
    'type' => 'new_page',
    'checks' => ['status', 'canonical', 'schema', 'content'],
    'expected_content' => ['Faceted Navigation', 'What the Model Sees', 'Mitigation Strategy']
  ],
  [
    'url' => '/en-us/generative-engine-optimization/failure-modes/ai-content-collapse/',
    'type' => 'new_page',
    'checks' => ['status', 'canonical', 'schema', 'content'],
    'expected_content' => ['AI Content Collapse', 'What the Model Sees', 'Mitigation Strategy']
  ],
  [
    'url' => '/en-us/generative-engine-optimization/failure-modes/conflicting-entities/',
    'type' => 'new_page',
    'checks' => ['status', 'canonical', 'schema', 'content'],
    'expected_content' => ['Conflicting Entities', 'What the Model Sees', 'Mitigation Strategy']
  ],
  // Updated pages (with Decision Traces links)
  [
    'url' => '/en-us/generative-engine-optimization/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['Decision traces', 'decision-traces']
  ],
  [
    'url' => '/en-us/generative-engine-optimization/failure-modes/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['decision-traces', 'schema-noise', 'faceted-navigation']
  ],
  [
    'url' => '/en-us/generative-engine-optimization/failure-modes/canonical-drift/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['decision-traces', 'Decision traces']
  ],
  [
    'url' => '/en-us/ai-search-diagnostics/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['decision-traces', 'Decision traces']
  ],
  [
    'url' => '/en-us/ai-search-diagnostics/site-not-showing-in-ai-results/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['decision-traces', 'Decision traces']
  ],
  [
    'url' => '/en-us/field-notes/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['decision-traces', 'Decision traces']
  ],
  [
    'url' => '/en-us/glossary/',
    'type' => 'updated_page',
    'checks' => ['status', 'canonical', 'content'],
    'expected_content' => ['decision-traces', 'Decision Traces']
  ],
];

function fetchUrl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  @curl_close($ch); // Suppress deprecation warning in PHP 8.5+
  
  $headers = substr($response, 0, $headerSize);
  $body = substr($response, $headerSize);
  
  return [
    'status' => $httpCode,
    'headers' => $headers,
    'body' => $body
  ];
}

function checkStatus($status, $expected = 200) {
  return $status === $expected;
}

function checkCanonical($body, $expectedUrl) {
  // Check for canonical tag
  if (preg_match('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']+)["\']/', $body, $matches)) {
    $canonical = $matches[1];
    // Normalize URLs for comparison (remove protocol, lowercase)
    $normalizedCanonical = strtolower(str_replace(['http://localhost:8000', 'https://nrlc.ai'], '', $canonical));
    $normalizedExpected = strtolower($expectedUrl);
    
    // Check if canonical ends with expected path
    return strpos($normalizedCanonical, $normalizedExpected) !== false || 
           strpos($normalizedExpected, $normalizedCanonical) !== false;
  }
  return false;
}

function checkContent($body, $expectedStrings, $shouldNotContain = []) {
  $results = [];
  foreach ($expectedStrings as $str) {
    $results[$str] = stripos($body, $str) !== false;
  }
  
  if (!empty($shouldNotContain)) {
    foreach ($shouldNotContain as $str) {
      $results["NOT: $str"] = stripos($body, $str) === false;
    }
  }
  
  return $results;
}

function checkSchema($body) {
  // Check for JSON-LD schema blocks
  $schemaCount = preg_match_all('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>/', $body);
  return $schemaCount > 0;
}

function checkTitle($body) {
  if (preg_match('/<title[^>]*>([^<]+)<\/title>/', $body, $matches)) {
    return trim($matches[1]);
  }
  return false;
}

// Run QA
echo "🔍 QA Testing All Changes\n";
echo str_repeat("=", 80) . "\n\n";

$results = [];
$passed = 0;
$failed = 0;

foreach ($urlsToTest as $test) {
  $fullUrl = $baseUrl . $test['url'];
  echo "Testing: {$test['url']} ({$test['type']})\n";
  echo str_repeat("-", 80) . "\n";
  
  $response = fetchUrl($fullUrl);
  $body = $response['body'];
  $status = $response['status'];
  
  $testResults = [
    'url' => $test['url'],
    'type' => $test['type'],
    'status' => $status,
    'checks' => []
  ];
  
  // Status check
  if (in_array('status', $test['checks'])) {
    $statusOk = checkStatus($status);
    $testResults['checks']['status'] = $statusOk;
    echo "  Status: " . ($statusOk ? "✅ HTTP $status" : "❌ HTTP $status (expected 200)") . "\n";
    
    if (!$statusOk) {
      $failed++;
      $testResults['passed'] = false;
      echo "\n";
      continue;
    }
  }
  
  // Canonical check
  if (in_array('canonical', $test['checks'])) {
    $canonicalOk = checkCanonical($body, $test['url']);
    $testResults['checks']['canonical'] = $canonicalOk;
    echo "  Canonical: " . ($canonicalOk ? "✅ Present and correct" : "❌ Missing or incorrect") . "\n";
  }
  
  // Schema check
  if (in_array('schema', $test['checks'])) {
    $schemaOk = checkSchema($body);
    $testResults['checks']['schema'] = $schemaOk;
    echo "  Schema: " . ($schemaOk ? "✅ JSON-LD found" : "❌ No JSON-LD schema") . "\n";
  }
  
  // Content check
  if (in_array('content', $test['checks'])) {
    $contentResults = checkContent(
      $body, 
      $test['expected_content'], 
      $test['should_not_contain'] ?? []
    );
    
    $allContentOk = true;
    foreach ($contentResults as $str => $found) {
      $isNotCheck = strpos($str, 'NOT:') === 0;
      $displayStr = str_replace('NOT: ', '', $str);
      if ($isNotCheck) {
        // For NOT checks, found=false means the unwanted content is NOT present (good)
        echo "  Content \"{$displayStr}\" (should NOT be present): " . ($found ? "✅ Not found (good)" : "❌ Found (bad)") . "\n";
        if (!$found) $allContentOk = false;
      } else {
        // For normal checks, found=true means the content IS present (good)
        echo "  Content \"{$displayStr}\": " . ($found ? "✅ Found" : "❌ Missing") . "\n";
        if (!$found) $allContentOk = false;
      }
    }
    $testResults['checks']['content'] = $allContentOk;
  }
  
  // Title check
  if (in_array('title', $test['checks'])) {
    $title = checkTitle($body);
    $testResults['checks']['title'] = $title !== false;
    echo "  Title: " . ($title ? "✅ $title" : "❌ Missing") . "\n";
  }
  
  // Overall result
  $allChecksPassed = true;
  foreach ($testResults['checks'] as $check => $result) {
    if ($result === false) {
      $allChecksPassed = false;
      break;
    }
  }
  
  $testResults['passed'] = $allChecksPassed;
  if ($allChecksPassed) {
    $passed++;
    echo "  Result: ✅ PASSED\n";
  } else {
    $failed++;
    echo "  Result: ❌ FAILED\n";
  }
  
  $results[] = $testResults;
  echo "\n";
}

// Summary
echo str_repeat("=", 80) . "\n";
echo "📊 QA SUMMARY\n";
echo str_repeat("=", 80) . "\n";
echo "Total URLs tested: " . count($urlsToTest) . "\n";
echo "✅ Passed: $passed\n";
echo "❌ Failed: $failed\n";
echo "\n";

if ($failed > 0) {
  echo "Failed URLs:\n";
  foreach ($results as $result) {
    if (!$result['passed']) {
      echo "  - {$result['url']}\n";
      foreach ($result['checks'] as $check => $status) {
        if ($status === false) {
          echo "    ❌ $check\n";
        }
      }
    }
  }
  exit(1);
} else {
  echo "✅ All tests passed!\n";
  exit(0);
}

