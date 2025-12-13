<?php
declare(strict_types=1);

/**
 * F) REDIRECT POLICY PROOF
 */

require_once __DIR__.'/../bootstrap/canonical.php';
require_once __DIR__.'/../config/locales.php';

echo "=" . str_repeat("=", 79) . "\n";
echo "F) REDIRECT POLICY PROOF\n";
echo "=" . str_repeat("=", 79) . "\n\n";

// Show redirect implementation
echo "REDIRECT IMPLEMENTATION (bootstrap/canonical.php):\n";
echo str_repeat("-", 79) . "\n";
$code = file_get_contents(__DIR__.'/../bootstrap/canonical.php');
echo substr($code, 0, 2000) . "\n...\n\n";

// Test matrix
echo "REDIRECT TEST MATRIX:\n";
echo str_repeat("-", 79) . "\n";

$testCases = [
  ['input' => 'http://nrlc.ai/insights/open-seo-tools/', 'expected' => 'https://nrlc.ai/en-us/insights/open-seo-tools/', 'rule' => 'HTTP→HTTPS + locale'],
  ['input' => 'https://www.nrlc.ai/services/site-audits/san-francisco/', 'expected' => 'https://nrlc.ai/en-us/services/site-audits/san-francisco/', 'rule' => 'www→non-www + locale'],
  ['input' => 'https://nrlc.ai/services/site-audits/san-francisco', 'expected' => 'https://nrlc.ai/en-us/services/site-audits/san-francisco/', 'rule' => 'trailing slash + locale'],
  ['input' => 'https://nrlc.ai/insights/open-seo-tools?utm_source=test', 'expected' => 'https://nrlc.ai/en-us/insights/open-seo-tools/', 'rule' => 'strip utm params + locale'],
  ['input' => 'https://nrlc.ai/en-us/services/site-audits/san-francisco/', 'expected' => 'https://nrlc.ai/en-us/services/site-audits/san-francisco/', 'rule' => 'no redirect (already canonical)'],
  ['input' => 'https://nrlc.ai/', 'expected' => 'https://nrlc.ai/en-us/', 'rule' => 'root → locale'],
];

function test_redirect(string $inputUrl): array {
  $parsed = parse_url($inputUrl);
  $path = $parsed['path'] ?? '/';
  $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
  
  $_SERVER['REQUEST_URI'] = $path . $query;
  $_SERVER['HTTP_HOST'] = $parsed['host'] ?? 'nrlc.ai';
  $_SERVER['HTTPS'] = (strpos($inputUrl, 'https://') === 0) ? 'on' : '';
  $_SERVER['HTTP_X_FORWARDED_PROTO'] = (strpos($inputUrl, 'https://') === 0) ? 'https' : '';
  
  // Capture headers
  $headers = [];
  $redirectUrl = null;
  $statusCode = null;
  
  ob_start();
  $oldHeaders = headers_list();
  
  try {
    canonical_guard();
    $statusCode = http_response_code();
  } catch (Exception $e) {
    // Redirect happened
    $headers = headers_list();
    foreach ($headers as $header) {
      if (preg_match('/^Location:\s*(.+)$/i', $header, $m)) {
        $redirectUrl = trim($m[1]);
        $statusCode = 301;
        break;
      }
    }
  }
  
  ob_end_clean();
  
  // Reset
  if (function_exists('header_remove')) {
    header_remove();
  }
  http_response_code(200);
  
  return [
    'input' => $inputUrl,
    'redirect_to' => $redirectUrl,
    'status_code' => $statusCode,
    'headers' => $headers
  ];
}

echo "input_url | expected_final_canonical | actual_redirect | status_code | match\n";
echo str_repeat("-", 120) . "\n";

foreach ($testCases as $test) {
  $result = test_redirect($test['input']);
  $matches = ($result['redirect_to'] === $test['expected'] || (!$result['redirect_to'] && $test['input'] === $test['expected']));
  
  printf("%-50s | %-50s | %-30s | %-11d | %s\n",
    substr($test['input'], 0, 50),
    substr($test['expected'], 0, 50),
    substr($result['redirect_to'] ?? 'NO REDIRECT', 0, 30),
    $result['status_code'] ?? 200,
    $matches ? 'YES' : 'NO'
  );
}

echo "\n\nLOCALE STRATEGY:\n";
echo "Policy: OPTION A — Locale is primary (/en-us/), non-locale redirects to locale\n";
echo "Implementation: bootstrap/canonical.php lines 60-79\n";
echo "Exception: Root / stays as / (no locale prefix) — NEEDS VERIFICATION\n";

