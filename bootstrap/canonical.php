<?php
function canonical_guard(): void {
  $scheme = 'https';
  $host   = $_SERVER['HTTP_HOST'];
  $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
  $query  = $_GET ?? [];

  // Skip canonical redirects for API paths
  if (strpos($uri, '/api/') === 0) {
    return;
  }

  // strip trackers
  $strip = ['utm_source','utm_medium','utm_campaign','utm_term','utm_content','gclid','fbclid'];
  $query = array_diff_key($query, array_flip($strip));

  // normalize path
  $normalized = preg_replace('#/{2,}#','/', strtolower($uri));
  if (!preg_match('#\.[a-z0-9]+$#', $normalized) && substr($normalized,-1) !== '/') {
    $normalized .= '/';
  }

  $final   = $scheme.'://'.$host.$normalized.(count($query)?'?'.http_build_query($query):'');
  $current = $scheme.'://'.$host.$_SERVER['REQUEST_URI'];

  if ($current !== $final) {
    header("Location: $final", true, 301);
    exit;
  }
}

