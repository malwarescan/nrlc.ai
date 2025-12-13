<?php
declare(strict_types=1);

/**
 * CI META GUARDRAIL - RENDERED OUTPUT CHECK
 * 
 * Checks actual SSR HTML output from real URLs, not file contents.
 * This is the REAL guarantee that metadata is unique and correct.
 */

require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../bootstrap/router.php';
require_once __DIR__.'/../lib/helpers.php';

// Test URLs from Pages.csv plus generated routes
$pages = csv_read(__DIR__.'/../serp_intel/Pages.csv');
$testUrls = [];

// Extract top URLs from CSV
foreach (array_slice($pages, 0, 50) as $row) {
  $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
  if ($url && preg_match('#^https://#', $url)) {
    $testUrls[] = $url;
  }
}

// Add generated routes for each family
$testUrls[] = 'https://nrlc.ai/';
$testUrls[] = 'https://nrlc.ai/en-us/';
$testUrls[] = 'https://nrlc.ai/en-us/blog/blog-post-1/';
$testUrls[] = 'https://nrlc.ai/en-us/blog/blog-post-2/';
$testUrls[] = 'https://nrlc.ai/en-us/case-studies/case-study-1/';
$testUrls[] = 'https://nrlc.ai/en-us/case-studies/case-study-2/';
$testUrls[] = 'https://nrlc.ai/en-us/resources/resource-1/';
$testUrls[] = 'https://nrlc.ai/en-us/resources/resource-2/';
$testUrls[] = 'https://nrlc.ai/en-us/tools/chatgpt/';
$testUrls[] = 'https://nrlc.ai/en-us/tools/claude/';
$testUrls[] = 'https://nrlc.ai/en-us/industries/healthcare/';
$testUrls[] = 'https://nrlc.ai/en-us/industries/fintech/';

function extract_ssr_meta(string $url): array {
  $parsed = parse_url($url);
  $path = $parsed['path'] ?? '/';
  
  // Simulate request
  $_SERVER['REQUEST_URI'] = $path;
  $_SERVER['HTTP_HOST'] = $parsed['host'] ?? 'nrlc.ai';
  $_SERVER['HTTPS'] = 'on';
  $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
  $_GET = [];
  $_POST = [];
  
  // Capture output
  ob_start();
  
  try {
    route_request();
    $html = ob_get_clean();
  } catch (Exception $e) {
    ob_end_clean();
    return ['error' => $e->getMessage()];
  } catch (Error $e) {
    ob_end_clean();
    return ['error' => $e->getMessage()];
  }
  
  // Extract tags
  $meta = [];
  
  // Title
  if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches)) {
    $meta['title'] = trim(html_entity_decode(strip_tags($matches[1]), ENT_QUOTES, 'UTF-8'));
  }
  
  // Meta description
  if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\']([^"\']+)["\']/i', $html, $matches)) {
    $meta['description'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  // Canonical
  if (preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']/i', $html, $matches)) {
    $meta['canonical'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  // og:url
  if (preg_match('/<meta\s+property=["\']og:url["\']\s+content=["\']([^"\']+)["\']/i', $html, $matches)) {
    $meta['og_url'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  // Robots
  if (preg_match('/<meta\s+name=["\']robots["\']\s+content=["\']([^"\']+)["\']/i', $html, $matches)) {
    $meta['robots'] = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
  }
  
  return $meta;
}

$errors = [];
$warnings = [];
$results = [];
$titles = [];
$descriptions = [];
$first8Words = [];

echo "CI META GUARDRAIL - RENDERED OUTPUT CHECK\n";
echo str_repeat("=", 80) . "\n\n";
echo "Testing " . count($testUrls) . " URLs...\n\n";

foreach ($testUrls as $url) {
  $meta = extract_ssr_meta($url);
  $results[$url] = $meta;
  
  if (isset($meta['error'])) {
    $errors[] = "$url: ERROR - {$meta['error']}";
    continue;
  }
  
  // Check for noindex (bypassed pages)
  if (isset($meta['robots']) && strpos($meta['robots'], 'noindex') !== false) {
    $warnings[] = "$url: Has noindex (may have bypassed router)";
  }
  
  // Collect titles and descriptions for uniqueness check
  if (isset($meta['title'])) {
    if (!isset($titles[$meta['title']])) {
      $titles[$meta['title']] = [];
    }
    $titles[$meta['title']][] = $url;
    
    // Check length
    if (strlen($meta['title']) > 65) {
      $errors[] = "$url: Title too long (" . strlen($meta['title']) . " chars): " . substr($meta['title'], 0, 60) . "...";
    }
  } else {
    $errors[] = "$url: Missing title";
  }
  
  if (isset($meta['description'])) {
    if (!isset($descriptions[$meta['description']])) {
      $descriptions[$meta['description']] = [];
    }
    $descriptions[$meta['description']][] = $url;
    
    // Check length
    if (strlen($meta['description']) > 175) {
      $errors[] = "$url: Description too long (" . strlen($meta['description']) . " chars)";
    }
    
    // Check first 8 words
    $words = explode(' ', $meta['description']);
    $first8 = implode(' ', array_slice($words, 0, 8));
    if (!isset($first8Words[$first8])) {
      $first8Words[$first8] = [];
    }
    $first8Words[$first8][] = $url;
  } else {
    $errors[] = "$url: Missing description";
  }
  
  // Check canonical == og:url
  $canonical = $meta['canonical'] ?? '';
  $ogUrl = $meta['og_url'] ?? '';
  if ($canonical && $ogUrl && $canonical !== $ogUrl) {
    $errors[] = "$url: canonical != og:url (canonical: $canonical, og:url: $ogUrl)";
  }
  
  // Check canonical is HTTPS
  if ($canonical && strpos($canonical, 'https://') !== 0) {
    $errors[] = "$url: Canonical is not HTTPS: $canonical";
  }
  
  // Check canonical is self-referencing
  $expectedCanonical = preg_replace('#^https?://[^/]+#', '', $url);
  if ($canonical && $canonical !== $expectedCanonical && $canonical !== $url) {
    // Allow locale prefix differences
    $canonicalPath = parse_url($canonical, PHP_URL_PATH);
    $expectedPath = parse_url($expectedCanonical, PHP_URL_PATH);
    if ($canonicalPath !== $expectedPath) {
      $warnings[] = "$url: Canonical may not be self-referencing (canonical: $canonical, expected: $expectedCanonical)";
    }
  }
}

// Check for duplicates
$duplicateTitles = array_filter($titles, fn($urls) => count($urls) > 1);
$duplicateDescs = array_filter($descriptions, fn($urls) => count($urls) > 1);
$duplicateFirst8 = array_filter($first8Words, fn($urls) => count($urls) > 1);

if (!empty($duplicateTitles)) {
  foreach ($duplicateTitles as $title => $urls) {
    $errors[] = "Duplicate title '$title' in: " . implode(', ', array_slice($urls, 0, 5));
  }
}

if (!empty($duplicateDescs)) {
  foreach ($duplicateDescs as $desc => $urls) {
    $errors[] = "Duplicate description in: " . implode(', ', array_slice($urls, 0, 5));
  }
}

if (!empty($duplicateFirst8)) {
  foreach ($duplicateFirst8 as $words => $urls) {
    $errors[] = "Duplicate first 8 words '$words' in: " . implode(', ', array_slice($urls, 0, 5));
  }
}

// Output results
echo "RESULTS:\n";
echo str_repeat("-", 80) . "\n";
echo "URLs tested: " . count($testUrls) . "\n";
echo "URLs with errors: " . count($errors) . "\n";
echo "URLs with warnings: " . count($warnings) . "\n";
echo "Duplicate titles: " . count($duplicateTitles) . "\n";
echo "Duplicate descriptions: " . count($duplicateDescs) . "\n";
echo "Duplicate first 8 words: " . count($duplicateFirst8) . "\n\n";

if (!empty($errors)) {
  echo "ERRORS:\n";
  foreach (array_slice($errors, 0, 50) as $error) {
    echo "  ✗ $error\n";
  }
  if (count($errors) > 50) {
    echo "  ... (" . (count($errors) - 50) . " more errors)\n";
  }
  echo "\n";
}

if (!empty($warnings)) {
  echo "WARNINGS:\n";
  foreach (array_slice($warnings, 0, 20) as $warning) {
    echo "  ⚠ $warning\n";
  }
  echo "\n";
}

// Sample titles and descriptions
echo "SAMPLE TITLES (first 20):\n";
foreach (array_slice(array_keys($titles), 0, 20) as $title) {
  echo "  - $title\n";
}
echo "\n";

echo "SAMPLE DESCRIPTIONS (first 20):\n";
foreach (array_slice(array_keys($descriptions), 0, 20) as $desc) {
  echo "  - " . substr($desc, 0, 80) . "...\n";
}
echo "\n";

// Write artifact
$artifact = [
  'timestamp' => date('c'),
  'urls_tested' => count($testUrls),
  'errors_count' => count($errors),
  'warnings_count' => count($warnings),
  'duplicate_titles_count' => count($duplicateTitles),
  'duplicate_descriptions_count' => count($duplicateDescs),
  'duplicate_first8_count' => count($duplicateFirst8),
  'sample_titles' => array_slice(array_keys($titles), 0, 20),
  'sample_descriptions' => array_slice(array_keys($descriptions), 0, 20),
  'errors' => array_slice($errors, 0, 100)
];
file_put_contents(__DIR__.'/../ci_meta_guardrail_rendered_report.json', json_encode($artifact, JSON_PRETTY_PRINT));
echo "Artifact written to: ci_meta_guardrail_rendered_report.json\n\n";

if (empty($errors)) {
  echo "✓ CI META GUARDRAIL PASSED\n";
  exit(0);
} else {
  echo "❌ CI META GUARDRAIL FAILED\n";
  exit(1);
}

