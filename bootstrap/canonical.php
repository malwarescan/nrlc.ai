<?php
require_once __DIR__.'/../config/locales.php';

function canonical_guard(): void {
  $scheme = 'https';
  $host   = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
  $query  = $_GET ?? [];

  // Skip canonical redirects for API paths
  if (strpos($uri, '/api/') === 0) {
    return;
  }

  // Skip redirects for static files and special paths
  $staticPaths = ['/robots.txt', '/favicon.ico', '/sitemap', '/sitemaps', '/healthcheck.html'];
  foreach ($staticPaths as $staticPath) {
    if (strpos($uri, $staticPath) === 0) {
      return;
    }
  }

  // Force HTTPS redirect (fallback if .htaccess doesn't catch it)
  if (empty($_SERVER['HTTPS']) && 
      empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
      empty($_SERVER['HTTP_X_FORWARDED_SSL'])) {
    $redirectUrl = $scheme.'://'.$host.$_SERVER['REQUEST_URI'];
    header("Location: $redirectUrl", true, 301);
    exit;
  }

  // Force non-www redirect (www.nrlc.ai -> nrlc.ai)
  if (strpos($host, 'www.') === 0) {
    $newHost = substr($host, 4);
    $redirectUrl = $scheme.'://'.$newHost.$_SERVER['REQUEST_URI'];
    header("Location: $redirectUrl", true, 301);
    exit;
  }

  // Force locale prefix redirect (e.g., /services/... -> /en-us/services/...)
  // This prevents duplicate canonical issues where Google chooses a different canonical
  // Skip redirect for healthcheck requests (HEAD requests or Railway healthcheck)
  // Note: Railway healthcheck now uses /healthcheck.html (static file), so this is mainly for other healthchecks
  $isHealthcheck = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD' || 
                    isset($_SERVER['HTTP_USER_AGENT']) && 
                    (strpos($_SERVER['HTTP_USER_AGENT'], 'Railway') !== false ||
                     strpos($_SERVER['HTTP_USER_AGENT'], 'healthcheck') !== false ||
                     strpos($_SERVER['HTTP_USER_AGENT'], 'kube-probe') !== false ||
                     strpos($_SERVER['HTTP_USER_AGENT'], 'GoogleHC') !== false);
  
  if (!preg_match('#^/([a-z]{2})-([a-z]{2})(/|$)#i', $uri)) {
    // Path doesn't have locale prefix - redirect to default locale
    // But skip redirect for healthcheck requests to allow healthcheck to pass
    if ($isHealthcheck) {
      // For healthcheck, allow the request through without redirect
      // The canonical tag will still point to /en-us/ version
      return;
    }
    
    // Preserve query string
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    // Handle root path specially
    if ($uri === '/' || $uri === '') {
      $redirectUrl = $scheme.'://'.$host.'/'.X_DEFAULT.'/'.$queryString;
    } else {
      $redirectUrl = $scheme.'://'.$host.'/'.X_DEFAULT.$uri.$queryString;
    }
    header("Location: $redirectUrl", true, 301);
    exit;
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

