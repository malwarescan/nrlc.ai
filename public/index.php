<?php
// TOP-LEVEL ERROR HANDLER: Prevent any fatal error from returning 5xx
// Homepage MUST ALWAYS return 200, even if bootstrap fails
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

