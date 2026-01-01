<?php
/**
 * Comprehensive QA for all Search Console URLs
 * Reads URLs from Pages.csv and runs all QA checks
 */

declare(strict_types=1);

$baseUrl = 'https://nrlc.ai';
$csvFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2026-01-01/Pages.csv';
$outputFile = __DIR__ . '/../docs/search_console_qa_results.csv';

// Read URLs from CSV
function readUrlsFromCsv($csvFile): array {
  $urls = [];
  if (!file_exists($csvFile)) {
    echo "❌ CSV file not found: $csvFile\n";
    return $urls;
  }
  
  $handle = fopen($csvFile, 'r');
  if ($handle === false) {
    echo "❌ Could not open CSV file\n";
    return $urls;
  }
  
  // Skip header
  @fgetcsv($handle, 0, ',', '"', '\\');
  
  while (($row = @fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
    if (isset($row[0]) && !empty($row[0])) {
      $url = trim($row[0]);
      // Skip header row if present
      if (strpos($url, 'Top pages') === false && strpos($url, 'http') === 0) {
        $urls[] = $url;
      }
    }
  }
  
  fclose($handle);
  return array_unique($urls);
}

function fetchUrl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SEO-QA/1.0)');
  curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
  $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
  $error = curl_error($ch);
  @curl_close($ch);
  
  if ($response === false || !empty($error)) {
    return [
      'status' => 0,
      'headers' => '',
      'body' => '',
      'load_time' => 0,
      'final_url' => $url,
      'error' => $error ?: 'Request failed'
    ];
  }
  
  $headers = substr($response, 0, $headerSize);
  $body = substr($response, $headerSize);
  
  return [
    'status' => $httpCode ?: 0,
    'headers' => $headers,
    'body' => $body,
    'load_time' => $totalTime,
    'final_url' => $finalUrl ?: $url
  ];
}

function checkCanonical($body, $expectedUrl) {
  preg_match_all('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']+)["\']/i', $body, $matches);
  if (empty($matches[1]) || !is_array($matches[1])) {
    return ['found' => false, 'count' => 0, 'value' => null, 'matches' => false];
  }
  
  $canonical = $matches[1][0];
  $expectedPath = parse_url($expectedUrl, PHP_URL_PATH);
  $canonicalPath = parse_url($canonical, PHP_URL_PATH);
  
  // Normalize paths
  $expectedPathNorm = rtrim($expectedPath ?: '', '/') ?: '/';
  $canonicalPathNorm = rtrim($canonicalPath ?: '', '/') ?: '/';
  
  $matchesUrl = ($canonicalPathNorm === $expectedPathNorm);
  
  return [
    'found' => true,
    'count' => count($matches[1]),
    'value' => $canonical,
    'matches' => $matchesUrl
  ];
}

function extractMetaTitle($body) {
  if (preg_match('/<title[^>]*>([^<]+)<\/title>/i', $body, $matches)) {
    return trim(html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8'));
  }
  return false;
}

function extractMetaDescription($body) {
  if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^"\']+)["\']/i', $body, $matches)) {
    return trim(html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8'));
  }
  return false;
}

function extractH1($body) {
  preg_match_all('/<h1[^>]*>([^<]+)<\/h1>/i', $body, $matches);
  if (empty($matches[1])) {
    return ['found' => false, 'count' => 0, 'value' => null];
  }
  return [
    'found' => true,
    'count' => count($matches[1]),
    'value' => trim(strip_tags($matches[1][0]))
  ];
}

function checkSchema($body) {
  $schemaBlocks = preg_match_all('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $body, $matches);
  if ($schemaBlocks === 0) {
    return ['found' => false, 'count' => 0, 'types' => []];
  }
  
  $schemas = [];
  foreach ($matches[1] as $schemaJson) {
    $decoded = json_decode($schemaJson, true);
    if ($decoded) {
      if (isset($decoded['@graph'])) {
        foreach ($decoded['@graph'] as $item) {
          if (isset($item['@type'])) {
            $schemas[] = $item['@type'];
          }
        }
      } elseif (isset($decoded['@type'])) {
        $schemas[] = $decoded['@type'];
      }
    }
  }
  
  return [
    'found' => true,
    'count' => $schemaBlocks,
    'types' => array_unique($schemas)
  ];
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

function checkFooter($body) {
  // Check for footer presence (multiple possible indicators)
  $hasFooter = (
    preg_match('/<footer[^>]*>/i', $body) !== false ||
    preg_match('/class=["\'][^"\']*footer[^"\']*["\']/i', $body) !== false ||
    preg_match('/id=["\'][^"\']*footer[^"\']*["\']/i', $body) !== false ||
    preg_match('/©|Copyright/i', $body) !== false
  );
  return $hasFooter;
}

function validateTitleLength($title) {
  if (!$title) return ['valid' => false, 'issue' => 'Missing', 'length' => 0];
  $length = mb_strlen($title, 'UTF-8');
  if ($length < 30) return ['valid' => false, 'issue' => "Too short ($length chars, min 30)", 'length' => $length];
  if ($length > 60) return ['valid' => false, 'issue' => "Too long ($length chars, max 60)", 'length' => $length];
  return ['valid' => true, 'length' => $length];
}

function validateDescriptionLength($description) {
  if (!$description) return ['valid' => false, 'issue' => 'Missing', 'length' => 0];
  $length = mb_strlen($description, 'UTF-8');
  if ($length < 120) return ['valid' => false, 'issue' => "Too short ($length chars, min 120)", 'length' => $length];
  if ($length > 160) return ['valid' => false, 'issue' => "Too long ($length chars, max 160)", 'length' => $length];
  return ['valid' => true, 'length' => $length];
}

// Main execution
echo "🔍 Comprehensive QA for Search Console URLs\n";
echo str_repeat("=", 100) . "\n\n";

$urls = readUrlsFromCsv($csvFile);
$totalUrls = count($urls);

echo "Found $totalUrls URLs to test\n\n";

if ($totalUrls === 0) {
  echo "❌ No URLs found. Exiting.\n";
  exit(1);
}

$results = [];
$passed = 0;
$failed = 0;
$warnings = 0;
$processed = 0;

// Open CSV output file
$csvHandle = fopen($outputFile, 'w');
if ($csvHandle) {
  @fputcsv($csvHandle, [
    'URL',
    'HTTP Status',
    'Load Time',
    'Canonical Found',
    'Canonical Matches',
    'Title Found',
    'Title Length',
    'Title Valid',
    'Description Found',
    'Description Length',
    'Description Valid',
    'H1 Found',
    'H1 Count',
    'Schema Found',
    'Schema Count',
    'Schema Types',
    'Viewport',
    'Lang',
    'Charset',
    'Footer',
    'Passed',
    'Issues',
    'Warnings'
  ]);
}

foreach ($urls as $index => $url) {
  $processed++;
  $progress = round(($processed / $totalUrls) * 100, 1);
  
  echo "[$processed/$totalUrls] ($progress%) Testing: $url\n";
  
  $response = fetchUrl($url);
  $body = $response['body'];
  $status = $response['status'];
  $loadTime = $response['load_time'];
  $finalUrl = $response['final_url'];
  
  $testResults = [
    'url' => $url,
    'final_url' => $finalUrl,
    'status' => $status,
    'load_time' => round($loadTime, 2),
    'issues' => [],
    'warnings' => [],
    'checks' => []
  ];
  
  // Skip if not 200
  if ($status !== 200) {
    $testResults['issues'][] = "HTTP $status";
    $testResults['passed'] = false;
    $failed++;
    
    if ($csvHandle) {
      @fputcsv($csvHandle, [
        $url, $status, $loadTime, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',
        'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A',
        'N/A', 'N/A', 'N/A', 'N/A', 'FAIL', 'HTTP ' . $status, ''
      ], ',', '"', '\\');
    }
    
    $results[] = $testResults;
    continue;
  }
  
  // 1. Canonical
  $canonicalCheck = checkCanonical($body, $url);
  if (!$canonicalCheck['found']) {
    $testResults['issues'][] = 'Canonical missing';
  } elseif ($canonicalCheck['count'] > 1) {
    $testResults['issues'][] = "Multiple canonicals ({$canonicalCheck['count']})";
  } elseif (!$canonicalCheck['matches']) {
    $testResults['issues'][] = 'Canonical does not match URL';
  } else {
    $testResults['checks']['canonical'] = true;
  }
  
  // 2. Title
  $title = extractMetaTitle($body);
  $titleValidation = validateTitleLength($title);
  if (!$title) {
    $testResults['issues'][] = 'Title missing';
  } elseif (!$titleValidation['valid']) {
    $testResults['issues'][] = "Title: {$titleValidation['issue']}";
  } else {
    $testResults['checks']['title'] = true;
  }
  
  // 3. Description
  $description = extractMetaDescription($body);
  $descValidation = validateDescriptionLength($description);
  if (!$description) {
    $testResults['issues'][] = 'Description missing';
  } elseif (!$descValidation['valid']) {
    $testResults['issues'][] = "Description: {$descValidation['issue']}";
  } else {
    $testResults['checks']['description'] = true;
  }
  
  // 4. H1
  $h1Check = extractH1($body);
  if (!$h1Check['found']) {
    $testResults['issues'][] = 'H1 missing';
  } elseif ($h1Check['count'] > 1) {
    $testResults['issues'][] = "Multiple H1s ({$h1Check['count']})";
  } else {
    $testResults['checks']['h1'] = true;
  }
  
  // 5. Schema
  $schemaCheck = checkSchema($body);
  if (!$schemaCheck['found']) {
    $testResults['warnings'][] = 'No JSON-LD schema';
  } else {
    $testResults['checks']['schema'] = true;
  }
  
  // 6. Viewport
  $viewport = checkViewport($body);
  if (!$viewport) {
    $testResults['warnings'][] = 'Viewport missing';
  } else {
    $testResults['checks']['viewport'] = true;
  }
  
  // 7. Lang
  $lang = checkLang($body);
  if (!$lang) {
    $testResults['warnings'][] = 'HTML lang missing';
  } else {
    $testResults['checks']['lang'] = true;
  }
  
  // 8. Charset
  $charset = checkCharset($body);
  if (!$charset) {
    $testResults['warnings'][] = 'Charset missing';
  } else {
    $testResults['checks']['charset'] = true;
  }
  
  // 9. Footer
  $footer = checkFooter($body);
  if (!$footer) {
    $testResults['warnings'][] = 'Footer not detected';
  } else {
    $testResults['checks']['footer'] = true;
  }
  
  // Overall result
  $hasCriticalIssues = !empty($testResults['issues']);
  $testResults['passed'] = !$hasCriticalIssues;
  
  if ($hasCriticalIssues) {
    $failed++;
  } else {
    $passed++;
    if (!empty($testResults['warnings'])) {
      $warnings += count($testResults['warnings']);
    }
  }
  
  // Write to CSV
  if ($csvHandle) {
    @fputcsv($csvHandle, [
      $url,
      $status,
      $loadTime,
      $canonicalCheck['found'] ? 'Yes' : 'No',
      $canonicalCheck['matches'] ? 'Yes' : 'No',
      $title ? 'Yes' : 'No',
      $title ? $titleValidation['length'] : 0,
      $titleValidation['valid'] ? 'Yes' : 'No',
      $description ? 'Yes' : 'No',
      $description ? $descValidation['length'] : 0,
      $descValidation['valid'] ? 'Yes' : 'No',
      $h1Check['found'] ? 'Yes' : 'No',
      $h1Check['count'],
      $schemaCheck['found'] ? 'Yes' : 'No',
      $schemaCheck['count'],
      implode(', ', $schemaCheck['types']),
      $viewport ? 'Yes' : 'No',
      $lang ?: 'Missing',
      $charset ? 'Yes' : 'No',
      $footer ? 'Yes' : 'No',
      $testResults['passed'] ? 'PASS' : 'FAIL',
      implode('; ', $testResults['issues']),
      implode('; ', $testResults['warnings'])
    ]);
  }
  
  $results[] = $testResults;
  
  // Progress indicator every 50 URLs
  if ($processed % 50 === 0) {
    echo "  Progress: $passed passed, $failed failed, $warnings warnings\n";
  }
}

if ($csvHandle) {
  fclose($csvHandle);
}

// Summary
echo "\n" . str_repeat("=", 100) . "\n";
echo "📊 QA SUMMARY\n";
echo str_repeat("=", 100) . "\n";
echo "Total URLs tested: $totalUrls\n";
echo "✅ Passed: $passed (" . round(($passed / $totalUrls) * 100, 1) . "%)\n";
echo "❌ Failed: $failed (" . round(($failed / $totalUrls) * 100, 1) . "%)\n";
echo "⚠️  Total Warnings: $warnings\n";
echo "\n";
echo "Results saved to: $outputFile\n";
echo "\n";

// Show failed URLs summary
if ($failed > 0) {
  echo "❌ FAILED URLs (showing first 20):\n";
$shown = 0;
foreach ($results as $result) {
  if (!$result['passed'] && $shown < 20) {
    echo "  {$result['url']}\n";
    foreach ($result['issues'] as $issue) {
      echo "    ❌ $issue\n";
    }
    $shown++;
  }
}
if ($failed > 20) {
  echo "  ... and " . ($failed - 20) . " more (see CSV for full details)\n";
}
echo "\n";
}

// Show top issues
$issueCounts = [];
foreach ($results as $result) {
  foreach ($result['issues'] as $issue) {
    $issueType = explode(':', $issue)[0];
    $issueCounts[$issueType] = ($issueCounts[$issueType] ?? 0) + 1;
  }
}

if (!empty($issueCounts)) {
  arsort($issueCounts);
  echo "📋 TOP ISSUES:\n";
  $top = 0;
  foreach ($issueCounts as $issue => $count) {
    if ($top < 10) {
      echo "  $issue: $count occurrences\n";
      $top++;
    }
  }
  echo "\n";
}

exit($failed > 0 ? 1 : 0);

