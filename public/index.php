<?php
// TOP-LEVEL ERROR HANDLER: Prevent any fatal error from returning 5xx
// Homepage MUST ALWAYS return 200, even if bootstrap fails

// EARLY WWW REDIRECT: Handle www redirect before any other code runs
// This ensures www redirects work even if Railway routes www traffic
$host = $_SERVER['HTTP_HOST'] ?? '';
if (strpos($host, 'www.') === 0) {
  $newHost = substr($host, 4);
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  // Also check Railway's forwarded protocol
  if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
  }
  $redirectUrl = $scheme . '://' . $newHost . ($_SERVER['REQUEST_URI'] ?? '/');
  header("Location: $redirectUrl", true, 301);
  exit;
}

try {
  // Guard all require_once calls
  if (file_exists(__DIR__.'/../bootstrap/env.php')) {
    require_once __DIR__.'/../bootstrap/env.php';
  }
  if (file_exists(__DIR__.'/../bootstrap/canonical.php')) {
    require_once __DIR__.'/../bootstrap/canonical.php';
  }
  if (file_exists(__DIR__.'/../bootstrap/router.php')) {
    require_once __DIR__.'/../bootstrap/router.php';
  }

  // Guard function calls
  if (function_exists('canonical_guard')) {
    canonical_guard();
  }
  if (function_exists('route_request')) {
    route_request();
  }
} catch (Throwable $e) {
  // FALLBACK: Always return 200 with minimal HTML
  http_response_code(200);
  header('Content-Type: text/html; charset=UTF-8');
  echo '<!DOCTYPE html><html><head><title>NRLC.ai - AI SEO & AI Visibility Services</title><meta charset="UTF-8"><meta name="description" content="Professional AI SEO and AI visibility services."></head><body><h1>NRLC.ai</h1><p>AI SEO & AI Visibility Services</p><p>Email: hirejoelm@gmail.com | Phone: +1-844-568-4624</p></body></html>';
}

