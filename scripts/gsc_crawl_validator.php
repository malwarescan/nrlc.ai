<?php
/**
 * SUDO META DIRECTIVE — GSC-DERIVED URL CRAWL & TRUTH ENFORCEMENT KERNEL
 * 
 * Google-grade crawler, auditor, and gatekeeper.
 * Verifies every URL that has appeared in GSC.
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(0);

// Configuration
$GSC_PAGES_CSV = $argv[1] ?? __DIR__ . '/../../Downloads/nrlc.ai-Performance-on-Search-2025-12-17 2/Pages.csv';
$OUTPUT_CSV = $argv[2] ?? __DIR__ . '/../gsc_validation_report.csv';
$BASE_URL = 'https://nrlc.ai';

// Results storage
$results = [];
$failures = [];

/**
 * STEP 1: URL NORMALIZATION
 */
function normalize_url(string $url): array {
  $original = $url;
  
  // Normalize protocol
  $url = preg_replace('#^http://#', 'https://', $url);
  
  // Resolve www vs non-www (prefer non-www for nrlc.ai)
  $url = preg_replace('#^https://www\.nrlc\.ai#', 'https://nrlc.ai', $url);
  
  // Strip tracking params (keep canonical params)
  $parsed = parse_url($url);
  if (isset($parsed['query'])) {
    parse_str($parsed['query'], $params);
    // Remove common tracking params
    unset($params['utm_source'], $params['utm_medium'], $params['utm_campaign'], 
          $params['utm_term'], $params['utm_content'], $params['fbclid'], 
          $params['gclid'], $params['ref']);
    $parsed['query'] = http_build_query($params);
    if (empty($parsed['query'])) {
      unset($parsed['query']);
    }
    $url = build_url($parsed);
  }
  
  return [
    'original' => $original,
    'normalized' => $url,
    'variants' => [$url] // Could expand for www variants if needed
  ];
}

function build_url(array $parts): string {
  $url = $parts['scheme'] . '://' . $parts['host'];
  if (isset($parts['port'])) $url .= ':' . $parts['port'];
  if (isset($parts['path'])) $url .= $parts['path'];
  if (isset($parts['query'])) $url .= '?' . $parts['query'];
  if (isset($parts['fragment'])) $url .= '#' . $parts['fragment'];
  return $url;
}

/**
 * PASS A: RAW HTML FETCH (NO JS)
 */
function pass_a_raw_fetch(string $url): array {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 5,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; GSC-Validator/1.0)',
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_HEADER => true,
  ]);
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $error = curl_error($ch);
  curl_close($ch);
  
  if ($error) {
    return [
      'http_status' => 0,
      'error' => $error,
      'html_size' => 0,
      'text_length' => 0,
      'has_title' => false,
      'has_meta_desc' => false,
      'has_canonical' => false,
      'has_jsonld' => false,
      'flags' => ['FETCH_ERROR']
    ];
  }
  
  $headers = substr($response, 0, $headerSize);
  $html = substr($response, $headerSize);
  $htmlSize = strlen($html);
  $textLength = strlen(strip_tags($html));
  
  // Extract meta tags
  $hasTitle = preg_match('#<title[^>]*>(.*?)</title>#is', $html, $titleMatch);
  $hasMetaDesc = preg_match('#<meta\s+name=["\']description["\']\s+content=["\']([^"\']+)["\']#i', $html);
  $hasCanonical = preg_match('#<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']#i', $html, $canonicalMatch);
  $hasJsonld = preg_match('#<script\s+type=["\']application/ld\+json["\']#i', $html);
  
  $flags = [];
  if ($htmlSize < 300 || $textLength < 100) {
    $flags[] = 'THIN_OR_JS_DEPENDENT';
  }
  
  return [
    'http_status' => $httpCode,
    'html_size' => $htmlSize,
    'text_length' => $textLength,
    'has_title' => (bool)$hasTitle,
    'has_meta_desc' => (bool)$hasMetaDesc,
    'has_canonical' => (bool)$hasCanonical,
    'canonical_url' => $hasCanonical ? $canonicalMatch[1] : null,
    'has_jsonld' => (bool)$hasJsonld,
    'flags' => $flags,
    'raw_html' => $html
  ];
}

/**
 * PASS B: RENDERED FETCH (GOOGLEBOT MOBILE PARITY)
 * Note: This requires headless Chrome or similar. For now, we'll use a simplified check.
 */
function pass_b_rendered_fetch(string $url): array {
  // In production, this would use headless Chrome via Puppeteer/Playwright
  // For now, we'll do a second fetch with mobile user agent and check for JS dependencies
  
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 5,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Linux; Android 10; Mobile) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
    CURLOPT_SSL_VERIFYPEER => true,
  ]);
  
  $html = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $error = curl_error($ch);
  curl_close($ch);
  
  if ($error) {
    return [
      'render_success' => false,
      'js_only_content' => false,
      'render_failure' => true,
      'flags' => ['RENDER_FAILURE']
    ];
  }
  
  // Check for JS-only content indicators
  $jsOnlyIndicators = [
    'id="root"',
    'id="app"',
    'data-react-root',
    'ng-app',
    'vue-app',
    '<noscript>',
  ];
  
  $hasJsOnly = false;
  foreach ($jsOnlyIndicators as $indicator) {
    if (stripos($html, $indicator) !== false) {
      // Check if there's meaningful content outside of these containers
      $textContent = strip_tags($html);
      if (strlen(trim($textContent)) < 200) {
        $hasJsOnly = true;
        break;
      }
    }
  }
  
  $flags = [];
  if ($hasJsOnly) {
    $flags[] = 'JS_ONLY_CONTENT';
  }
  
  return [
    'render_success' => $httpCode === 200,
    'js_only_content' => $hasJsOnly,
    'render_failure' => $httpCode !== 200,
    'flags' => $flags
  ];
}

/**
 * PASS C: LINK GRAPH VALIDATION
 */
function pass_c_link_validation(string $html, string $baseUrl): array {
  // Extract internal links
  preg_match_all('#<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>#i', $html, $matches);
  $allLinks = $matches[1] ?? [];
  
  $internalLinks = [];
  foreach ($allLinks as $link) {
    // Resolve relative URLs
    if (strpos($link, 'http') !== 0) {
      $link = rtrim($baseUrl, '/') . '/' . ltrim($link, '/');
    }
    
    // Check if internal
    if (strpos($link, $baseUrl) === 0) {
      $internalLinks[] = $link;
    }
  }
  
  // Sample check first 10 internal links (to avoid timeout)
  $checkedLinks = array_slice($internalLinks, 0, 10);
  $brokenLinks = [];
  $redirectLinks = [];
  
  foreach ($checkedLinks as $link) {
    $ch = curl_init($link);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_NOBODY => true,
    ]);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 404) {
      $brokenLinks[] = $link;
    } elseif ($httpCode >= 300 && $httpCode < 400) {
      $redirectLinks[] = $link;
    }
  }
  
  return [
    'internal_links_count' => count($internalLinks),
    'checked_links_count' => count($checkedLinks),
    'broken_links' => $brokenLinks,
    'redirect_links' => $redirectLinks,
    'internal_links_ok' => empty($brokenLinks)
  ];
}

/**
 * STEP 3: INDEXABILITY & TRUST CHECKS
 */
function check_indexability(string $html, string $url, array $rawFetch): array {
  // Check meta robots
  preg_match('#<meta\s+name=["\']robots["\']\s+content=["\']([^"\']+)["\']#i', $html, $robotsMatch);
  $robotsContent = $robotsMatch[1] ?? '';
  $isNoindex = stripos($robotsContent, 'noindex') !== false;
  
  // Check canonical
  $canonicalOk = true;
  $canonicalUrl = $rawFetch['canonical_url'] ?? null;
  if ($canonicalUrl) {
    // Normalize for comparison
    $canonicalNormalized = normalize_url($canonicalUrl)['normalized'];
    $urlNormalized = normalize_url($url)['normalized'];
    if ($canonicalNormalized !== $urlNormalized) {
      $canonicalOk = false;
    }
  }
  
  // Check redirect chain
  $redirectChain = [];
  $currentUrl = $url;
  for ($i = 0; $i < 5; $i++) {
    $ch = curl_init($currentUrl);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_NOBODY => true,
    ]);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);
    
    if ($httpCode >= 300 && $httpCode < 400 && $redirectUrl) {
      $redirectChain[] = $redirectUrl;
      $currentUrl = $redirectUrl;
    } else {
      break;
    }
  }
  
  $redirectOk = count($redirectChain) <= 1;
  $redirectsTo404 = !empty($redirectChain) && end($redirectChain) && 
                    pass_a_raw_fetch(end($redirectChain))['http_status'] === 404;
  
  $indexable = !$isNoindex && $rawFetch['http_status'] === 200 && $canonicalOk && $redirectOk && !$redirectsTo404;
  
  $flags = [];
  if ($rawFetch['http_status'] !== 200) {
    $flags[] = 'GSC_GHOST_URL';
  }
  if ($isNoindex) {
    $flags[] = 'NOINDEX';
  }
  if (!$canonicalOk) {
    $flags[] = 'CANONICAL_MISMATCH';
  }
  if (!$redirectOk) {
    $flags[] = 'REDIRECT_CHAIN';
  }
  if ($redirectsTo404) {
    $flags[] = 'REDIRECT_TO_404';
  }
  
  return [
    'indexable' => $indexable,
    'is_noindex' => $isNoindex,
    'canonical_ok' => $canonicalOk,
    'redirect_ok' => $redirectOk,
    'redirects_to_404' => $redirectsTo404,
    'redirect_chain_length' => count($redirectChain),
    'flags' => $flags
  ];
}

/**
 * STEP 4: INTENT & SERVICE ALIGNMENT
 */
function detect_intent_and_service(string $html, string $url): array {
  $text = strip_tags($html);
  $textLower = strtolower($text);
  
  // Classify page type
  $pageType = 'unknown';
  if (preg_match('#/services/#', $url)) {
    $pageType = 'service';
  } elseif (preg_match('#/products/#', $url)) {
    $pageType = 'product';
  } elseif (preg_match('#/insights/#', $url)) {
    $pageType = 'resource';
  } elseif (preg_match('#/$#', $url) || preg_match('#/en-us/$#', $url)) {
    $pageType = 'hub';
  }
  
  // Extract primary service
  $primaryService = null;
  if ($pageType === 'service') {
    // Try to extract service name from URL or H1
    preg_match('#<h1[^>]*>(.*?)</h1>#is', $html, $h1Match);
    if ($h1Match) {
      $primaryService = trim(strip_tags($h1Match[1]));
    } else {
      // Extract from URL
      if (preg_match('#/services/([^/]+)#', $url, $urlMatch)) {
        $primaryService = str_replace('-', ' ', $urlMatch[1]);
      }
    }
  }
  
  // Determine intent
  $intent = 'informational';
  $transactionalKeywords = ['buy', 'purchase', 'order', 'book', 'schedule', 'request', 'quote', 'pricing', 'cost', 'price'];
  $commercialKeywords = ['service', 'solution', 'consulting', 'agency', 'expert', 'professional'];
  
  $transactionalScore = 0;
  $commercialScore = 0;
  
  foreach ($transactionalKeywords as $keyword) {
    if (stripos($textLower, $keyword) !== false) {
      $transactionalScore++;
    }
  }
  
  foreach ($commercialKeywords as $keyword) {
    if (stripos($textLower, $keyword) !== false) {
      $commercialScore++;
    }
  }
  
  if ($transactionalScore >= 2) {
    $intent = 'transactional';
  } elseif ($commercialScore >= 2 || $pageType === 'service') {
    $intent = 'commercial';
  }
  
  // Check first viewport for service + outcome
  $firstViewport = substr($text, 0, 500);
  $hasServiceStatement = false;
  $hasOutcome = false;
  
  if ($pageType === 'service') {
    $hasServiceStatement = strlen($firstViewport) > 100;
    $hasOutcome = preg_match('#(improve|increase|boost|optimize|enhance|deliver|achieve|result|outcome|benefit)#i', $firstViewport);
  }
  
  $intentOk = true;
  if ($pageType === 'service' && $intent !== 'transactional' && $intent !== 'commercial') {
    $intentOk = false;
  }
  if ($pageType === 'service' && (!$hasServiceStatement || !$hasOutcome)) {
    $intentOk = false;
  }
  
  return [
    'page_type' => $pageType,
    'primary_service' => $primaryService,
    'intent' => $intent,
    'intent_ok' => $intentOk,
    'has_service_statement' => $hasServiceStatement,
    'has_outcome' => $hasOutcome
  ];
}

/**
 * STEP 5: STRUCTURED DATA VERIFICATION
 */
function verify_structured_data(string $html, string $pageType): array {
  // Extract JSON-LD
  preg_match_all('#<script\s+type=["\']application/ld\+json["\'][^>]*>(.*?)</script>#is', $html, $jsonMatches);
  
  $schemas = [];
  foreach ($jsonMatches[1] as $jsonStr) {
    $json = json_decode(trim($jsonStr), true);
    if ($json) {
      if (isset($json['@type'])) {
        $schemas[] = $json['@type'];
      } elseif (isset($json['@graph'])) {
        foreach ($json['@graph'] as $item) {
          if (isset($item['@type'])) {
            $schemas[] = $item['@type'];
          }
        }
      }
    }
  }
  
  $requiredSchemas = [];
  if ($pageType === 'service') {
    $requiredSchemas = ['WebPage', 'Service', 'Organization', 'BreadcrumbList'];
  } else {
    $requiredSchemas = ['WebPage'];
  }
  
  $hasRequired = [];
  foreach ($requiredSchemas as $required) {
    $hasRequired[$required] = in_array($required, $schemas);
  }
  
  $schemaOk = true;
  foreach ($hasRequired as $has) {
    if (!$has) {
      $schemaOk = false;
      break;
    }
  }
  
  // Check if schema exists in raw HTML (not JS-injected)
  $schemaInRawHtml = !empty($jsonMatches[0]);
  
  return [
    'schemas_found' => $schemas,
    'required_schemas' => $requiredSchemas,
    'has_required' => $hasRequired,
    'schema_ok' => $schemaOk && $schemaInRawHtml,
    'schema_in_raw_html' => $schemaInRawHtml,
    'missing_schemas' => array_diff($requiredSchemas, $schemas)
  ];
}

/**
 * STEP 6: PAGE SCORING
 */
function score_page(array $rawFetch, array $rendered, array $linkValidation, array $indexability, array $intent, array $schema): int {
  $score = 0;
  
  // Load & render integrity (30 points)
  if ($rawFetch['http_status'] === 200) $score += 10;
  if ($rawFetch['html_size'] > 1000) $score += 5;
  if ($rawFetch['text_length'] > 500) $score += 5;
  if ($rendered['render_success']) $score += 5;
  if (!$rendered['js_only_content']) $score += 5;
  
  // Indexability & canonicals (15 points)
  if ($indexability['indexable']) $score += 10;
  if ($indexability['canonical_ok']) $score += 5;
  
  // Intent clarity (20 points)
  if ($intent['intent_ok']) $score += 15;
  if ($intent['has_service_statement']) $score += 3;
  if ($intent['has_outcome']) $score += 2;
  
  // Service depth & clarity (15 points)
  if ($intent['primary_service']) $score += 10;
  if (strlen($intent['primary_service'] ?? '') > 20) $score += 5;
  
  // Structured data correctness (10 points)
  if ($schema['schema_ok']) $score += 10;
  
  // Internal linking (10 points)
  if ($linkValidation['internal_links_ok']) $score += 5;
  if ($linkValidation['internal_links_count'] > 5) $score += 5;
  
  return min(100, $score);
}

/**
 * Determine required action
 */
function get_required_action(int $score, array $indexability, array $rawFetch, string $pageType, array $schema): string {
  if ($rawFetch['http_status'] !== 200) {
    return 'block';
  }
  if (!$indexability['indexable']) {
    return 'block';
  }
  if ($pageType === 'service' && !$schema['schema_ok']) {
    return 'block';
  }
  if ($score < 70) {
    return 'block';
  }
  if ($score < 85) {
    return 'fix';
  }
  if ($score >= 95) {
    return 'promote';
  }
  return 'fix';
}

/**
 * MAIN EXECUTION
 */
echo "SUDO META DIRECTIVE — GSC CRAWL & VALIDATION KERNEL\n";
echo "==================================================\n\n";

// Read GSC Pages CSV
if (!file_exists($GSC_PAGES_CSV)) {
  die("ERROR: GSC Pages CSV not found: $GSC_PAGES_CSV\n");
}

$handle = fopen($GSC_PAGES_CSV, 'r');
if (!$handle) {
  die("ERROR: Cannot read GSC Pages CSV\n");
}

// Skip header
fgetcsv($handle, 0, ',', '"', '');

$urlCount = 0;
$processedCount = 0;
$maxUrls = $argv[3] ?? null; // Optional limit for testing

echo "Reading GSC URLs...\n";
while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
  if ($maxUrls && $processedCount >= (int)$maxUrls) {
    echo "Reached max URLs limit ($maxUrls). Stopping.\n";
    break;
  }
  if (count($row) < 2) continue;
  
  $url = trim($row[0]);
  $clicks = (int)($row[1] ?? 0);
  $impressions = (int)($row[2] ?? 0);
  
  if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    continue;
  }
  
  $urlCount++;
  
  // Normalize URL
  $normalized = normalize_url($url);
  $targetUrl = $normalized['normalized'];
  
  echo "[$urlCount] Processing: $targetUrl\n";
  
  // PASS A: Raw HTML fetch
  $rawFetch = pass_a_raw_fetch($targetUrl);
  
  // PASS B: Rendered fetch
  $rendered = pass_b_rendered_fetch($targetUrl);
  
  // PASS C: Link validation (only if we got HTML)
  $linkValidation = ['internal_links_count' => 0, 'checked_links_count' => 0, 
                     'broken_links' => [], 'redirect_links' => [], 'internal_links_ok' => true];
  if ($rawFetch['http_status'] === 200 && !empty($rawFetch['raw_html'])) {
    $linkValidation = pass_c_link_validation($rawFetch['raw_html'], $BASE_URL);
  }
  
  // Indexability checks
  $indexability = check_indexability($rawFetch['raw_html'] ?? '', $targetUrl, $rawFetch);
  
  // Intent & service alignment
  $intent = detect_intent_and_service($rawFetch['raw_html'] ?? '', $targetUrl);
  
  // Structured data verification
  $schema = verify_structured_data($rawFetch['raw_html'] ?? '', $intent['page_type']);
  
  // Score page
  $score = score_page($rawFetch, $rendered, $linkValidation, $indexability, $intent, $schema);
  
  // Required action
  $action = get_required_action($score, $indexability, $rawFetch, $intent['page_type'], $schema);
  
  // Store result
  $results[] = [
    'url' => $targetUrl,
    'gsc_impressions' => $impressions,
    'gsc_clicks' => $clicks,
    'http_status' => $rawFetch['http_status'],
    'render_success' => $rendered['render_success'] ? 'yes' : 'no',
    'js_only_content' => $rendered['js_only_content'] ? 'yes' : 'no',
    'gsc_ghost_url' => in_array('GSC_GHOST_URL', $rawFetch['flags'] ?? []) ? 'yes' : 'no',
    'indexable' => $indexability['indexable'] ? 'yes' : 'no',
    'canonical_ok' => $indexability['canonical_ok'] ? 'yes' : 'no',
    'intent' => $intent['intent'],
    'primary_service' => $intent['primary_service'] ?? '',
    'schema_ok' => $schema['schema_ok'] ? 'yes' : 'no',
    'internal_links_ok' => $linkValidation['internal_links_ok'] ? 'yes' : 'no',
    'score' => $score,
    'required_action' => $action
  ];
  
  // Check for failures
  if ($score < 85 || $rawFetch['http_status'] !== 200 || 
      ($intent['page_type'] === 'service' && !$schema['schema_ok'])) {
    $failures[] = [
      'url' => $targetUrl,
      'score' => $score,
      'http_status' => $rawFetch['http_status'],
      'issues' => array_merge(
        $rawFetch['flags'] ?? [],
        $rendered['flags'] ?? [],
        $indexability['flags'] ?? []
      )
    ];
  }
  
  $processedCount++;
  
  // Rate limiting
  usleep(500000); // 0.5 second delay between requests
}

fclose($handle);

// STEP 8: HARD GUARDRAILS
echo "\n\nVALIDATION RESULTS:\n";
echo "==================\n";
echo "Total URLs processed: $processedCount\n";
echo "Failures detected: " . count($failures) . "\n\n";

if (!empty($failures)) {
  echo "CRITICAL FAILURES:\n";
  foreach ($failures as $failure) {
    echo "  - {$failure['url']} (Score: {$failure['score']}, HTTP: {$failure['http_status']})\n";
    if (!empty($failure['issues'])) {
      echo "    Issues: " . implode(', ', $failure['issues']) . "\n";
    }
  }
  echo "\n";
}

// Write output CSV
$outputHandle = fopen($OUTPUT_CSV, 'w');
if (!$outputHandle) {
  die("ERROR: Cannot write output CSV: $OUTPUT_CSV\n");
}

// Write header
fputcsv($outputHandle, [
  'url', 'gsc_impressions', 'gsc_clicks', 'http_status', 'render_success',
  'js_only_content', 'gsc_ghost_url', 'indexable', 'canonical_ok', 'intent',
  'primary_service', 'schema_ok', 'internal_links_ok', 'score', 'required_action'
]);

// Write results
foreach ($results as $result) {
  fputcsv($outputHandle, $result);
}

fclose($outputHandle);

echo "Output written to: $OUTPUT_CSV\n";
echo "\nVALIDATION COMPLETE.\n";

// Exit with error code if failures found
if (!empty($failures)) {
  exit(1);
}

