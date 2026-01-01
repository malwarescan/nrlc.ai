<?php
/**
 * Comprehensive SEO QA - Test all URLs for perfect SEO
 * Checks HTTP status, canonical tags, meta tags, schema, content structure, and more
 */

$baseUrl = 'https://nrlc.ai';

// URLs from LIVE_URLS_QA.md
$urlsToTest = [
  '/en-us/generative-engine-optimization/decision-traces/',
  '/en-us/glossary/decision-traces/',
  '/en-us/generative-engine-optimization/failure-modes/schema-noise/',
  '/en-us/generative-engine-optimization/failure-modes/faceted-navigation/',
  '/en-us/generative-engine-optimization/failure-modes/ai-content-collapse/',
  '/en-us/generative-engine-optimization/failure-modes/conflicting-entities/',
  '/en-us/generative-engine-optimization/',
  '/en-us/generative-engine-optimization/failure-modes/',
  '/en-us/generative-engine-optimization/failure-modes/canonical-drift/',
  '/en-us/ai-search-diagnostics/',
  '/en-us/ai-search-diagnostics/site-not-showing-in-ai-results/',
  '/en-us/field-notes/',
  '/en-us/glossary/',
];

function fetchUrl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SEO-QA/1.0)');
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
  @curl_close($ch);
  
  $headers = substr($response, 0, $headerSize);
  $body = substr($response, $headerSize);
  
  return [
    'status' => $httpCode,
    'headers' => $headers,
    'body' => $body,
    'load_time' => $totalTime
  ];
}

function checkCanonical($body, $expectedUrl) {
  if (preg_match('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']+)["\']/i', $body, $matches)) {
    $canonical = $matches[1];
    // Normalize for comparison
    $normalizedCanonical = strtolower(str_replace(['http://localhost:8000', 'https://nrlc.ai', 'http://nrlc.ai'], '', $canonical));
    $normalizedExpected = strtolower($expectedUrl);
    return strpos($normalizedCanonical, $normalizedExpected) !== false || 
           strpos($normalizedExpected, $normalizedCanonical) !== false;
  }
  return false;
}

function extractMetaTitle($body) {
  if (preg_match('/<title[^>]*>([^<]+)<\/title>/i', $body, $matches)) {
    return trim($matches[1]);
  }
  return false;
}

function extractMetaDescription($body) {
  if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^"\']+)["\']/i', $body, $matches)) {
    return trim($matches[1]);
  }
  return false;
}

function extractH1($body) {
  if (preg_match('/<h1[^>]*>([^<]+)<\/h1>/i', $body, $matches)) {
    return trim(strip_tags($matches[1]));
  }
  return false;
}

function checkSchema($body) {
  $schemaBlocks = preg_match_all('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $body, $matches);
  if ($schemaBlocks > 0) {
    $schemas = [];
    foreach ($matches[1] as $schemaJson) {
      $decoded = json_decode($schemaJson, true);
      if ($decoded && isset($decoded['@type'])) {
        if (isset($decoded['@graph'])) {
          // Handle @graph arrays
          foreach ($decoded['@graph'] as $item) {
            if (isset($item['@type'])) {
              $schemas[] = $item['@type'];
            }
          }
        } else {
          $schemas[] = $decoded['@type'];
        }
      }
    }
    return ['count' => $schemaBlocks, 'types' => array_unique($schemas)];
  }
  return false;
}

function checkViewport($body) {
  return preg_match('/<meta[^>]*name=["\']viewport["\'][^>]*>/i', $body) !== false;
}

function checkLang($body) {
  if (preg_match('/<html[^>]*lang=["\']([^"\']+)["\']/i', $body, $matches)) {
    return $matches[1];
  }
  return false;
}

function checkCharset($body) {
  return preg_match('/<meta[^>]*charset=["\']?utf-8["\']?/i', $body) !== false;
}

function validateTitleLength($title) {
  if (!$title) return ['valid' => false, 'issue' => 'Missing'];
  $length = strlen($title);
  if ($length < 30) return ['valid' => false, 'issue' => "Too short ($length chars)"];
  if ($length > 60) return ['valid' => false, 'issue' => "Too long ($length chars, max 60)"];
  return ['valid' => true, 'length' => $length];
}

function validateDescriptionLength($description) {
  if (!$description) return ['valid' => false, 'issue' => 'Missing'];
  $length = strlen($description);
  if ($length < 120) return ['valid' => false, 'issue' => "Too short ($length chars, min 120)"];
  if ($length > 160) return ['valid' => false, 'issue' => "Too long ($length chars, max 160)"];
  return ['valid' => true, 'length' => $length];
}

// Run comprehensive SEO QA
echo "🔍 Comprehensive SEO QA Testing\n";
echo str_repeat("=", 100) . "\n\n";

$results = [];
$passed = 0;
$failed = 0;
$warnings = 0;

foreach ($urlsToTest as $urlPath) {
  $fullUrl = $baseUrl . $urlPath;
  echo "Testing: $urlPath\n";
  echo str_repeat("-", 100) . "\n";
  
  $response = fetchUrl($fullUrl);
  $body = $response['body'];
  $status = $response['status'];
  $loadTime = $response['load_time'];
  
  $testResults = [
    'url' => $urlPath,
    'status' => $status,
    'load_time' => round($loadTime, 2),
    'issues' => [],
    'warnings' => [],
    'checks' => []
  ];
  
  // 1. HTTP Status Check
  if ($status !== 200) {
    $testResults['issues'][] = "HTTP $status (expected 200)";
    echo "  ❌ Status: HTTP $status (expected 200)\n";
    $failed++;
    $results[] = $testResults;
    echo "\n";
    continue;
  }
  echo "  ✅ Status: HTTP $status\n";
  $testResults['checks']['status'] = true;
  
  // 2. Load Time
  if ($loadTime > 3.0) {
    $testResults['warnings'][] = "Slow load time: {$loadTime}s";
    echo "  ⚠️  Load Time: {$loadTime}s (slow)\n";
    $warnings++;
  } else {
    echo "  ✅ Load Time: {$loadTime}s\n";
  }
  
  // 3. Canonical Tag
  $canonicalOk = checkCanonical($body, $urlPath);
  if (!$canonicalOk) {
    $testResults['issues'][] = "Canonical tag missing or incorrect";
    echo "  ❌ Canonical: Missing or incorrect\n";
  } else {
    echo "  ✅ Canonical: Present and correct\n";
    $testResults['checks']['canonical'] = true;
  }
  
  // 4. Meta Title
  $title = extractMetaTitle($body);
  $titleValidation = validateTitleLength($title);
  if (!$titleValidation['valid']) {
    $testResults['issues'][] = "Title: {$titleValidation['issue']}";
    echo "  ❌ Title: {$titleValidation['issue']}\n";
    if ($title) echo "     Current: \"$title\"\n";
  } else {
    echo "  ✅ Title: {$titleValidation['length']} chars - \"$title\"\n";
    $testResults['checks']['title'] = true;
  }
  
  // 5. Meta Description
  $description = extractMetaDescription($body);
  $descValidation = validateDescriptionLength($description);
  if (!$descValidation['valid']) {
    $testResults['issues'][] = "Description: {$descValidation['issue']}";
    echo "  ❌ Description: {$descValidation['issue']}\n";
    if ($description) echo "     Current: \"" . substr($description, 0, 80) . "...\"\n";
  } else {
    echo "  ✅ Description: {$descValidation['length']} chars\n";
    $testResults['checks']['description'] = true;
  }
  
  // 6. H1 Tag
  $h1 = extractH1($body);
  if (!$h1) {
    $testResults['issues'][] = "H1 tag missing";
    echo "  ❌ H1: Missing\n";
  } else {
    echo "  ✅ H1: \"$h1\"\n";
    $testResults['checks']['h1'] = true;
  }
  
  // 7. JSON-LD Schema
  $schema = checkSchema($body);
  if (!$schema) {
    $testResults['issues'][] = "No JSON-LD schema found";
    echo "  ❌ Schema: Not found\n";
  } else {
    $types = implode(', ', $schema['types']);
    echo "  ✅ Schema: {$schema['count']} block(s) - Types: $types\n";
    $testResults['checks']['schema'] = true;
  }
  
  // 8. Viewport Meta
  $viewport = checkViewport($body);
  if (!$viewport) {
    $testResults['warnings'][] = "Viewport meta tag missing";
    echo "  ⚠️  Viewport: Missing (mobile-friendly check)\n";
    $warnings++;
  } else {
    echo "  ✅ Viewport: Present\n";
    $testResults['checks']['viewport'] = true;
  }
  
  // 9. HTML Lang Attribute
  $lang = checkLang($body);
  if (!$lang) {
    $testResults['warnings'][] = "HTML lang attribute missing";
    echo "  ⚠️  Lang: Missing\n";
    $warnings++;
  } else {
    echo "  ✅ Lang: $lang\n";
    $testResults['checks']['lang'] = true;
  }
  
  // 10. Charset
  $charset = checkCharset($body);
  if (!$charset) {
    $testResults['warnings'][] = "Charset declaration missing";
    echo "  ⚠️  Charset: Missing\n";
    $warnings++;
  } else {
    echo "  ✅ Charset: UTF-8\n";
    $testResults['checks']['charset'] = true;
  }
  
  // Overall result
  $hasCriticalIssues = !empty($testResults['issues']);
  $testResults['passed'] = !$hasCriticalIssues;
  
  if ($hasCriticalIssues) {
    $failed++;
    echo "  Result: ❌ FAILED\n";
  } else {
    $passed++;
    echo "  Result: ✅ PASSED";
    if (!empty($testResults['warnings'])) {
      echo " (with " . count($testResults['warnings']) . " warning(s))";
    }
    echo "\n";
  }
  
  $results[] = $testResults;
  echo "\n";
}

// Summary
echo str_repeat("=", 100) . "\n";
echo "📊 SEO QA SUMMARY\n";
echo str_repeat("=", 100) . "\n";
echo "Total URLs tested: " . count($urlsToTest) . "\n";
echo "✅ Passed: $passed\n";
echo "❌ Failed: $failed\n";
echo "⚠️  Warnings: $warnings\n";
echo "\n";

if ($failed > 0) {
  echo "❌ FAILED URLs:\n";
  foreach ($results as $result) {
    if (!$result['passed']) {
      echo "\n  {$result['url']}\n";
      foreach ($result['issues'] as $issue) {
        echo "    ❌ $issue\n";
      }
    }
  }
  echo "\n";
}

if ($warnings > 0) {
  echo "⚠️  URLs WITH WARNINGS:\n";
  foreach ($results as $result) {
    if (!empty($result['warnings'])) {
      echo "\n  {$result['url']}\n";
      foreach ($result['warnings'] as $warning) {
        echo "    ⚠️  $warning\n";
      }
    }
  }
  echo "\n";
}

// Detailed breakdown
echo "📋 DETAILED BREAKDOWN:\n\n";
foreach ($results as $result) {
  $statusIcon = $result['passed'] ? '✅' : '❌';
  echo "$statusIcon {$result['url']}\n";
  echo "   Status: {$result['status']} | Load: {$result['load_time']}s\n";
  if (!empty($result['issues'])) {
    echo "   Issues: " . count($result['issues']) . "\n";
  }
  if (!empty($result['warnings'])) {
    echo "   Warnings: " . count($result['warnings']) . "\n";
  }
}

echo "\n";

if ($failed === 0 && $warnings === 0) {
  echo "✅ Perfect! All URLs pass all SEO checks with no warnings.\n";
  exit(0);
} elseif ($failed === 0) {
  echo "✅ All URLs pass critical SEO checks (some warnings present).\n";
  exit(0);
} else {
  echo "❌ Some URLs failed critical SEO checks. Review issues above.\n";
  exit(1);
}

