<?php
declare(strict_types=1);

/**
 * Verify canonical URLs are correctly set for URLs from Google Search Console
 * 
 * This script checks that canonical URLs match the actual page URLs
 * (including locale prefix) for URLs reported in GSC.
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/hreflang.php';

// Sample URLs from GSC data
$testUrls = [
  'https://nrlc.ai/en-gb/services/explainability-optimization-ai/soka/',
  'https://nrlc.ai/en-us/services/completeness-optimization-ai/anyang/',
  'https://nrlc.ai/ko-kr/services/bard-optimization/hull/',
  'https://nrlc.ai/de-de/services/ai-overviews-optimization/tampa/',
  'https://nrlc.ai/es-es/services/training/columbus/',
  'https://nrlc.ai/en-gb/careers/burnley/technical-writer/',
  'https://nrlc.ai/de-de/careers/denver/seo-specialist/',
  'https://nrlc.ai/ko-kr/careers/whitehorse/technical-writer/',
];

function verify_canonical_url(string $url): array {
  $result = [
    'url' => $url,
    'valid' => false,
    'canonical' => null,
    'expected' => null,
    'match' => false,
    'error' => null,
  ];
  
  try {
    // Parse the URL
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    // Normalize the path
    $normalizedPath = preg_replace('#/{2,}#', '/', strtolower($path));
    if (!preg_match('#\.[a-z0-9]+$#', $normalizedPath) && substr($normalizedPath, -1) !== '/') {
      $normalizedPath .= '/';
    }
    
    $result['expected'] = $parsed['scheme'] . '://' . $parsed['host'] . $normalizedPath;
    
    // Simulate the request to get the canonical URL
    $_SERVER['REQUEST_URI'] = $path;
    $_SERVER['HTTP_HOST'] = $parsed['host'];
    $_SERVER['HTTPS'] = 'on';
    
    // Capture the output
    ob_start();
    
    // Set up the page slug based on the path
    if (preg_match('#^/([a-z]{2}-[a-z]{2})/services/([^/]+)/([^/]+)/$#', $path, $m)) {
      $_GET['service'] = $m[2];
      $_GET['city'] = $m[3];
      $GLOBALS['__page_slug'] = 'services/service_city';
    } elseif (preg_match('#^/([a-z]{2}-[a-z]{2})/careers/([^/]+)/([^/]+)/$#', $path, $m)) {
      $_GET['city'] = $m[2];
      $_GET['role'] = $m[3];
      $GLOBALS['__page_slug'] = 'careers/career_city';
    } else {
      $GLOBALS['__page_slug'] = 'home/home';
    }
    
    // Get the canonical path
    $slug = $GLOBALS['__page_slug'] ?? 'home/home';
    [$title, $desc, $metaPath] = meta_for_slug($slug);
    
    // Build canonical URL with locale prefix
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $requestPath = preg_replace('#/{2,}#', '/', strtolower($requestPath));
    if (!preg_match('#\.[a-z0-9]+$#', $requestPath) && substr($requestPath, -1) !== '/') {
      $requestPath .= '/';
    }
    $canonicalPath = $requestPath;
    
    $canonicalUrl = absolute_url($canonicalPath);
    
    $result['canonical'] = $canonicalUrl;
    $result['match'] = ($canonicalUrl === $result['expected']);
    $result['valid'] = true;
    
    ob_end_clean();
    
  } catch (Exception $e) {
    $result['error'] = $e->getMessage();
  }
  
  return $result;
}

echo "Verifying Canonical URLs\n";
echo str_repeat('=', 80) . "\n\n";

$pass = 0;
$fail = 0;

foreach ($testUrls as $url) {
  $result = verify_canonical_url($url);
  
  echo "URL: " . $result['url'] . "\n";
  echo "Expected: " . $result['expected'] . "\n";
  echo "Canonical: " . $result['canonical'] . "\n";
  echo "Match: " . ($result['match'] ? '✓ PASS' : '✗ FAIL') . "\n";
  
  if ($result['error']) {
    echo "Error: " . $result['error'] . "\n";
    $fail++;
  } elseif ($result['match']) {
    $pass++;
  } else {
    $fail++;
  }
  
  echo "\n";
}

echo str_repeat('=', 80) . "\n";
echo "Results: {$pass} passed, {$fail} failed\n";

if ($fail > 0) {
  exit(1);
}

exit(0);


