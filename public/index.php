<?php
// Router errors propagate here; do not mask failures with fake 200 "success" HTML.

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
  // CRITICAL: Force HTTPS security headers for production (helps Google recognize HTTPS)
  $host = $_SERVER['HTTP_HOST'] ?? '';
  $isLocalhost = in_array($host, ['localhost', '127.0.0.1']) || 
                 strpos($host, 'localhost:') === 0 || 
                 strpos($host, '127.0.0.1:') === 0;
  
  if (!$isLocalhost) {
    // Force HTTPS headers to help Google recognize the page is served over HTTPS
    // Railway sets HTTP_X_FORWARDED_PROTO, but we also set explicit headers
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
      $_SERVER['HTTPS'] = 'on';
    }
    // Set Strict-Transport-Security header (HSTS) to signal HTTPS is required
    if (!headers_sent()) {
      header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
  }
  
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
  error_log("NRLC ROUTER ERROR: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
  error_log("Stack trace: " . $e->getTraceAsString());

  if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
  }
  http_response_code(500);

  $host = $_SERVER['HTTP_HOST'] ?? '';
  $isLocal = in_array($host, ['localhost', '127.0.0.1'], true)
    || (strpos($host, 'localhost:') === 0)
    || (strpos($host, '127.0.0.1:') === 0);
  $appDebug = $_ENV['APP_DEBUG'] ?? getenv('APP_DEBUG') ?: '';
  $debug = $isLocal || $appDebug === '1' || strtolower((string)$appDebug) === 'true';

  if ($debug) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Error</title></head><body><h1>500 — Router error</h1><pre>'
      . htmlspecialchars($e->getMessage() . "\n\n" . $e->getFile() . ':' . $e->getLine() . "\n\n" . $e->getTraceAsString(), ENT_QUOTES, 'UTF-8')
      . '</pre></body></html>';
  } else {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Error</title></head><body><h1>Something went wrong</h1><p>Please try again later.</p></body></html>';
  }
}

