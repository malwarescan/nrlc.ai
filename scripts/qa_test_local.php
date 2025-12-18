<?php
/**
 * Local QA Test for GSC Fixes
 * Tests against localhost:8000
 */

require_once __DIR__.'/../lib/helpers.php';

echo "Local QA Test for GSC Fixes\n";
echo "===========================\n\n";

$baseUrl = 'http://localhost:8000';

// Test that canonical tags include locale prefix
echo "Testing Canonical Tags (Local)...\n";
echo "-----------------------------------\n";

$testUrls = [
  '/en-us/services/technical-seo/houston/',
  '/en-gb/services/local-seo-ai/norwich/',
];

foreach ($testUrls as $url) {
  $fullUrl = $baseUrl . $url;
  echo "Testing: $url\n";
  
  $ch = curl_init($fullUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
  if ($httpCode === 200) {
    if (preg_match('#<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']#i', $response, $m)) {
      $canonical = $m[1];
      if (str_contains($canonical, $url)) {
        echo "  ✓ Canonical includes locale: $canonical\n";
      } else {
        echo "  ✗ Canonical missing locale: $canonical (expected to contain: $url)\n";
      }
    } else {
      echo "  ✗ Canonical tag not found\n";
    }
  } else {
    echo "  ✗ HTTP $httpCode\n";
  }
  echo "\n";
}

echo "Note: Run 'php -S localhost:8000 router.php' from public/ directory to test locally\n";

