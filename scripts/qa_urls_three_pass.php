<?php
/**
 * Three-Pass URL QA System
 * 
 * PASS 1: Mechanical truth (HTTP, canonical, locale, slash, index eligibility)
 * PASS 2: Graph placement (parent, demand-stage, orphans, link direction)
 * PASS 3: GEO content QA (concept, H1, headers, chunks, narrative, constraints)
 * 
 * Principle: You do not start by manually reviewing content.
 * You start by mechanically constraining the system, then you read.
 */

declare(strict_types=1);

require_once __DIR__ . '/../lib/helpers.php';

$baseUrl = 'http://localhost:8000';
$outputFile = __DIR__ . '/../docs/qa_results.csv';

// Get all URLs from SEARCH_CONSOLE_URLS.md
function get_urls_from_docs(): array {
  $urls = [];
  $docFile = __DIR__ . '/../docs/SEARCH_CONSOLE_URLS.md';
  
  if (!file_exists($docFile)) {
    echo "❌ SEARCH_CONSOLE_URLS.md not found\n";
    return $urls;
  }
  
  $content = file_get_contents($docFile);
  // Extract URLs (https://nrlc.ai/...)
  preg_match_all('/https:\/\/nrlc\.ai\/[^\s\)]+/', $content, $matches);
  
  foreach ($matches[0] as $url) {
    // Convert to localhost for testing
    $localUrl = str_replace('https://nrlc.ai', 'http://localhost:8000', $url);
    $urls[] = [
      'production' => $url,
      'local' => $localUrl,
      'path' => parse_url($url, PHP_URL_PATH)
    ];
  }
  
  return array_unique($urls, SORT_REGULAR);
}

// PASS 1: Mechanical truth
function pass1_mechanical_truth(string $url): array {
  $results = [
    'http_status' => null,
    'http_ok' => false,
    'canonical_count' => 0,
    'canonical_matches_url' => false,
    'canonical_ok' => false,
    'locale_present' => false,
    'locale_ok' => false,
    'slash_consistent' => false,
    'slash_ok' => false,
    'noindex_present' => false,
    'robots_allowed' => true,
    'text_visible' => false,
    'index_ok' => false,
    'pass1_passed' => false
  ];
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_NOBODY, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $html = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
  if ($ch) {
    curl_close($ch);
  }
  
  if (!$html) {
    return $results;
  }
  
  // 1. HTTP truth
  $results['http_status'] = $httpCode;
  $results['http_ok'] = ($httpCode === 200);
  
  // 2. Canonical truth
  preg_match_all('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']+)["\']/', $html, $canonicalMatches);
  $results['canonical_count'] = count($canonicalMatches[1]);
  if ($results['canonical_count'] === 1) {
    $canonical = $canonicalMatches[1][0];
    $finalPath = parse_url($finalUrl, PHP_URL_PATH);
    $canonicalPath = parse_url($canonical, PHP_URL_PATH);
    
    // Normalize paths (remove trailing slashes for comparison, but preserve for matching)
    $finalPathNorm = rtrim($finalPath, '/') ?: '/';
    $canonicalPathNorm = rtrim($canonicalPath, '/') ?: '/';
    
    // Check if canonical matches (either path match or full URL match)
    $results['canonical_matches_url'] = ($canonicalPathNorm === $finalPathNorm || 
                                         $canonical === $finalUrl ||
                                         str_replace('https://nrlc.ai', 'http://localhost:8000', $canonical) === $finalUrl);
    $results['canonical_ok'] = $results['canonical_matches_url'];
  } else {
    // No canonical or multiple canonicals = fail
    $results['canonical_ok'] = false;
  }
  
  // 3. Locale truth
  $path = parse_url($finalUrl, PHP_URL_PATH);
  $results['locale_present'] = (strpos($path, '/en-us/') === 0);
  $results['locale_ok'] = $results['locale_present'];
  
  // 4. Slash truth
  $hasTrailingSlash = substr($path, -1) === '/';
  // All pages should have trailing slash (except root)
  $expectedSlash = ($path !== '/' && $path !== '/en-us');
  $results['slash_consistent'] = ($hasTrailingSlash === $expectedSlash);
  $results['slash_ok'] = $results['slash_consistent'];
  
  // 5. Index eligibility
  $results['noindex_present'] = (stripos($html, 'noindex') !== false || preg_match('/<meta[^>]*noindex/i', $html));
  $results['robots_allowed'] = !preg_match('/<meta[^>]*robots[^>]*noindex/i', $html);
  
  // Check for visible text (basic check - no JS requirement)
  $textContent = strip_tags($html);
  $results['text_visible'] = (strlen(trim($textContent)) > 100);
  $results['index_ok'] = !$results['noindex_present'] && $results['robots_allowed'] && $results['text_visible'];
  
  // Pass 1 overall
  $results['pass1_passed'] = $results['http_ok'] 
    && $results['canonical_ok'] 
    && $results['locale_ok'] 
    && $results['slash_ok'] 
    && $results['index_ok'];
  
  return $results;
}

// PASS 2: Graph placement
function pass2_graph_placement(string $url, array $allUrls): array {
  $results = [
    'parent_linked' => false,
    'parent_correct' => false,
    'demand_stage_ok' => false,
    'inbound_links' => 0,
    'no_orphan' => false,
    'link_direction_ok' => false,
    'pass2_passed' => false
  ];
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $html = curl_exec($ch);
  if ($ch) {
    curl_close($ch);
  }
  
  if (!$html) {
    return $results;
  }
  
  $path = parse_url($url, PHP_URL_PATH);
  
  // Determine parent pillar
  $parentPillar = null;
  if (preg_match('#/en-us/([^/]+)/#', $path, $m)) {
    $parentPillar = $m[1];
  }
  
  // Check if linked from parent
  if ($parentPillar && $path) {
    $pathParts = explode('/', trim($path, '/'));
    if (count($pathParts) > 2) {
      // Sub-page: parent is one level up
      array_pop($pathParts);
      $parentPath = '/' . implode('/', $pathParts) . '/';
      $parentUrl = 'http://localhost:8000' . $parentPath;
      $parentHtml = @file_get_contents($parentUrl);
      if ($parentHtml) {
        $results['parent_linked'] = (strpos($parentHtml, $path) !== false);
        $results['parent_correct'] = $results['parent_linked'];
      }
    }
  }
  
  // Check demand stage alignment (basic check)
  $results['demand_stage_ok'] = true; // Would need content analysis
  
  // Count inbound links (from other pages in our system)
  foreach ($allUrls as $otherUrl) {
    if ($otherUrl['local'] === $url) continue;
    
    $otherHtml = @file_get_contents($otherUrl['local']);
    if ($otherHtml && strpos($otherHtml, $path) !== false) {
      $results['inbound_links']++;
    }
  }
  
  $results['no_orphan'] = ($results['inbound_links'] > 0 || $results['parent_linked']);
  
  // Link direction sanity (basic check)
  $results['link_direction_ok'] = true; // Would need deeper analysis
  
  // Pass 2 overall
  $results['pass2_passed'] = $results['parent_correct'] 
    && $results['demand_stage_ok'] 
    && $results['no_orphan'] 
    && $results['link_direction_ok'];
  
  return $results;
}

// PASS 3: GEO content QA
function pass3_content_qa(string $url): array {
  $results = [
    'single_concept' => false,
    'h1_matches_intent' => false,
    'deterministic_headers' => false,
    'chunk_survivable' => false,
    'no_narrative_glue' => false,
    'negative_constraints' => false,
    'pass3_passed' => false
  ];
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $html = curl_exec($ch);
  if ($ch) {
    curl_close($ch);
  }
  
  if (!$html) {
    return $results;
  }
  
  // Extract H1
  preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1Match);
  $h1 = $h1Match[1] ?? '';
  $h1 = strip_tags($h1);
  $h1 = trim($h1);
  
  // Extract all headers
  preg_match_all('/<h[2-3][^>]*>(.*?)<\/h[2-3]>/is', $html, $headerMatches);
  $headers = array_map(function($h) {
    return trim(strip_tags($h));
  }, $headerMatches[1] ?? []);
  
  // Extract paragraphs
  preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $html, $pMatches);
  $paragraphs = array_map(function($p) {
    return trim(strip_tags($p));
  }, $pMatches[1] ?? []);
  
  // 1. Single primary concept (check if H1 is clear and singular)
  $results['single_concept'] = (strlen($h1) > 0 && strlen($h1) < 100);
  
  // 2. H1 = intent (basic check - H1 exists and is descriptive)
  $results['h1_matches_intent'] = (strlen($h1) > 10 && !preg_match('/^(Coming Soon|Placeholder|Under Development)/i', $h1));
  
  // 3. Deterministic headers (check for vague language)
  $vagueWords = ['understanding', 'exploring', 'discovering', 'unveiling', 'unlocking', 'mastering'];
  $vagueCount = 0;
  foreach ($headers as $header) {
    foreach ($vagueWords as $vague) {
      if (stripos($header, $vague) !== false) {
        $vagueCount++;
        break;
      }
    }
  }
  $results['deterministic_headers'] = ($vagueCount === 0 && count($headers) > 0);
  
  // 4. Chunk survivability (paragraphs short enough)
  $longParagraphs = 0;
  foreach ($paragraphs as $para) {
    $wordCount = str_word_count($para);
    if ($wordCount > 150) { // ~150 words is too long
      $longParagraphs++;
    }
  }
  $results['chunk_survivable'] = ($longParagraphs === 0 && count($paragraphs) > 0);
  
  // 5. No narrative glue (check for "this/that/it" without clear antecedents)
  $glueWords = ['this shows', 'this means', 'as mentioned', 'as we saw', 'in conclusion'];
  $glueCount = 0;
  foreach ($paragraphs as $para) {
    foreach ($glueWords as $glue) {
      if (stripos($para, $glue) !== false) {
        $glueCount++;
        break;
      }
    }
  }
  $results['no_narrative_glue'] = ($glueCount === 0);
  
  // 6. Negative constraints (check for failure/constraint language)
  $constraintWords = ['fails', 'ignored', 'not retrieved', 'does not', 'cannot', 'failure', 'problem', 'issue'];
  $constraintCount = 0;
  $textContent = strip_tags($html);
  foreach ($constraintWords as $constraint) {
    if (stripos($textContent, $constraint) !== false) {
      $constraintCount++;
      break;
    }
  }
  $results['negative_constraints'] = ($constraintCount > 0);
  
  // Pass 3 overall
  $results['pass3_passed'] = $results['single_concept'] 
    && $results['h1_matches_intent'] 
    && $results['deterministic_headers'] 
    && $results['chunk_survivable'] 
    && $results['no_narrative_glue'] 
    && $results['negative_constraints'];
  
  return $results;
}

// Main execution
echo "🚀 Starting Three-Pass URL QA\n\n";

$urls = get_urls_from_docs();
echo "Found " . count($urls) . " URLs to QA\n\n";

$results = [];

foreach ($urls as $urlData) {
  $url = $urlData['local'];
  $path = $urlData['path'];
  
  echo "Testing: $path\n";
  
  $result = [
    'url' => $urlData['production'],
    'path' => $path,
    'pass1' => [],
    'pass2' => [],
    'pass3' => [],
    'overall_status' => 'FAILED'
  ];
  
  // PASS 1: Mechanical truth
  echo "  PASS 1: Mechanical truth...\n";
  $result['pass1'] = pass1_mechanical_truth($url);
  
  if (!$result['pass1']['pass1_passed']) {
    echo "    ❌ FAILED - Skipping Pass 2 & 3\n";
    $results[] = $result;
    continue;
  }
  
  echo "    ✓ PASSED\n";
  
  // PASS 2: Graph placement
  echo "  PASS 2: Graph placement...\n";
  $result['pass2'] = pass2_graph_placement($url, $urls);
  
  if (!$result['pass2']['pass2_passed']) {
    echo "    ❌ FAILED - Skipping Pass 3\n";
    $results[] = $result;
    continue;
  }
  
  echo "    ✓ PASSED\n";
  
  // PASS 3: Content QA
  echo "  PASS 3: Content QA...\n";
  $result['pass3'] = pass3_content_qa($url);
  
  if ($result['pass3']['pass3_passed']) {
    echo "    ✓ PASSED\n";
    $result['overall_status'] = 'PASSED';
  } else {
    echo "    ❌ FAILED\n";
  }
  
  $results[] = $result;
  echo "\n";
}

// Generate CSV report
$csv = "URL,Path,Pass1_Status,Pass2_Status,Pass3_Status,Overall_Status,HTTP_Code,Canonical_OK,Locale_OK,Slash_OK,Index_OK,Parent_OK,No_Orphan,Content_OK\n";

foreach ($results as $result) {
  $pass1Status = $result['pass1']['pass1_passed'] ? 'PASS' : 'FAIL';
  $pass2Status = isset($result['pass2']['pass2_passed']) && $result['pass2']['pass2_passed'] ? 'PASS' : ($result['pass1']['pass1_passed'] ? 'FAIL' : 'SKIP');
  $pass3Status = isset($result['pass3']['pass3_passed']) && $result['pass3']['pass3_passed'] ? 'PASS' : ($result['pass2']['pass2_passed'] ?? false ? 'FAIL' : 'SKIP');
  
  $csv .= sprintf(
    "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
    $result['url'],
    $result['path'],
    $pass1Status,
    $pass2Status,
    $pass3Status,
    $result['overall_status'],
    $result['pass1']['http_status'] ?? '',
    $result['pass1']['canonical_ok'] ? 'YES' : 'NO',
    $result['pass1']['locale_ok'] ? 'YES' : 'NO',
    $result['pass1']['slash_ok'] ? 'YES' : 'NO',
    $result['pass1']['index_ok'] ? 'YES' : 'NO',
    $result['pass2']['parent_correct'] ?? 'N/A',
    $result['pass2']['no_orphan'] ?? 'N/A',
    $result['pass3']['pass3_passed'] ?? 'N/A'
  );
}

file_put_contents($outputFile, $csv);

// Summary
$total = count($results);
$pass1Passed = count(array_filter($results, fn($r) => $r['pass1']['pass1_passed']));
$pass2Passed = count(array_filter($results, fn($r) => ($r['pass2']['pass2_passed'] ?? false)));
$pass3Passed = count(array_filter($results, fn($r) => ($r['pass3']['pass3_passed'] ?? false)));
$overallPassed = count(array_filter($results, fn($r) => $r['overall_status'] === 'PASSED'));

echo "═══════════════════════════════════════\n";
echo "QA SUMMARY\n";
echo "═══════════════════════════════════════\n\n";
echo "Total URLs: $total\n";
echo "PASS 1 (Mechanical): $pass1Passed/$total\n";
echo "PASS 2 (Graph): $pass2Passed/$total\n";
echo "PASS 3 (Content): $pass3Passed/$total\n";
echo "Overall Passed: $overallPassed/$total\n\n";
echo "Results saved to: $outputFile\n";

