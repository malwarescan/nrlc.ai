<?php
// Guard require_once for locales
if (file_exists(__DIR__.'/../config/locales.php')) {
  try {
    require_once __DIR__.'/../config/locales.php';
  } catch (Throwable $e) {
    // Silent fail - define X_DEFAULT if not defined
    if (!defined('X_DEFAULT')) {
      define('X_DEFAULT', 'en-us');
    }
  }
} else {
  // Fallback if locales.php doesn't exist
  if (!defined('X_DEFAULT')) {
    define('X_DEFAULT', 'en-us');
  }
}

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
  $staticPaths = ['/robots.txt', '/favicon.ico', '/sitemap', '/sitemaps', '/healthcheck.html', '/healthz', '/search', '/audit', '/api'];
  foreach ($staticPaths as $staticPath) {
    if (strpos($uri, $staticPath) === 0) {
      return;
    }
  }
  
  // Skip canonical redirects for .md URLs (Markdown exposure)
  // These are handled by router.php which strips .md before routing
  if (preg_match('#\.md$#', $uri)) {
    return;
  }

  // Force HTTPS redirect (fallback if .htaccess doesn't catch it)
  // Skip HTTPS enforcement for localhost/127.0.0.1 (local development)
  $isLocalhost = in_array($host, ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000', 'localhost:8001', '127.0.0.1:8001']) || 
                 strpos($host, 'localhost:') === 0 || 
                 strpos($host, '127.0.0.1:') === 0;
  
  if (!$isLocalhost && 
      empty($_SERVER['HTTPS']) && 
      empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
      empty($_SERVER['HTTP_X_FORWARDED_SSL'])) {
    $redirectUrl = $scheme.'://'.$host.$_SERVER['REQUEST_URI'];
    header("Location: $redirectUrl", true, 301);
    exit;
  }
  
  // Use HTTP scheme for localhost
  if ($isLocalhost) {
    $scheme = 'http';
  }

  // Force non-www redirect (www.nrlc.ai -> nrlc.ai)
  if (strpos($host, 'www.') === 0) {
    $newHost = substr($host, 4);
    $redirectUrl = $scheme.'://'.$newHost.$_SERVER['REQUEST_URI'];
    header("Location: $redirectUrl", true, 301);
    exit;
  }

  // Root "/" must remain canonical as "/" (do not force locale).
  // This prevents breaking the homepage URL.
  if ($uri === '/' || $uri === '') {
    return;
  }
  
  // Global hub pages that must remain canonical without locale prefix
  // These pages are explicitly listed in sitemaps without locale prefixes
  // and must return 200 (not redirect) to prevent redirect loops
  // CRITICAL: A URL listed in a sitemap must return a stable 200 response
  // with a self-consistent canonical and no locale-dependent redirects
  $globalHubPages = ['/industries/', '/services/', '/products/', '/insights/', '/careers/', '/catalog/', '/blog/', '/case-studies/', '/resources/', '/tools/', '/ai-optimization/'];
  if (in_array($uri, $globalHubPages)) {
    return; // Allow these pages to exist without locale prefix (they are global hubs)
  }
  
  // Products paths are now active - removed redirect to homepage
  // Products page is accessible at /products/ and individual product pages

  // ========================================================================
  // SUDO POWERED LOCALE AUTHORITY ENFORCEMENT (HARD)
  // ========================================================================
  // City-based service pages: locale is dictated by geography, not language
  // UK cities → /en-gb/ ONLY
  // US cities → /en-us/ ONLY
  // Any other locale variant MUST 301 redirect immediately
  // ========================================================================
  
  // Handle service+city LOCAL pages
  if (preg_match('#^/([a-z]{2}-[a-z]{2})/services/([^/]+)/([^/]+)/#', $uri, $m)) {
    $locale = $m[1];
    $serviceSlug = $m[2];
    $citySlug = $m[3];
    
    // Guard require_once and function calls
    if (file_exists(__DIR__.'/../lib/helpers.php')) {
      try {
        require_once __DIR__.'/../lib/helpers.php';
      } catch (Throwable $e) {
        // Silent fail
      }
    }
    $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
    
    if ($isUK) {
      // UK city: MUST be en-gb, redirect all others
      if ($locale !== 'en-gb') {
        // PRESERVE SERVICE TYPE - do not force to local-seo-ai
        $canonical = '/en-gb/services/' . $serviceSlug . '/' . $citySlug . '/';
        $queryString = count($query) ? '?'.http_build_query($query) : '';
        $redirectUrl = $scheme.'://'.$host.$canonical.$queryString;
        header("Location: $redirectUrl", true, 301);
        exit;
      }
      // REMOVED: Service type forcing - each service type must have unique intent
      // This was causing massive intent collision (all services → local-seo-ai)
    } else {
      // US city or non-city: MUST be en-us (default locale)
      // Allow other locales only if they're genuinely translated (future enhancement)
      // For now, redirect non-en-us to en-us for city pages
      if ($locale !== 'en-us') {
        // Check if this is actually a US city (could add US city detection)
        // For now, assume non-UK cities are US
        $canonical = '/en-us/services/' . $serviceSlug . '/' . $citySlug . '/';
        $queryString = count($query) ? '?'.http_build_query($query) : '';
        $redirectUrl = $scheme.'://'.$host.$canonical.$queryString;
        header("Location: $redirectUrl", true, 301);
        exit;
      }
    }
  }
  
  // Handle career+city LOCAL pages
  if (preg_match('#^/([a-z]{2}-[a-z]{2})/careers/([^/]+)/([^/]+)/#', $uri, $m)) {
    $locale = $m[1];
    $citySlug = $m[2];
    $roleSlug = $m[3];
    
    // Guard require_once and function calls
    if (file_exists(__DIR__.'/../lib/helpers.php')) {
      try {
        require_once __DIR__.'/../lib/helpers.php';
      } catch (Throwable $e) {
        // Silent fail
      }
    }
    $canonicalLocale = function_exists('get_canonical_locale_for_city') 
      ? get_canonical_locale_for_city($citySlug) 
      : 'en-us';
    
    // Redirect non-canonical locale versions to canonical locale
    if ($locale !== $canonicalLocale) {
      $canonical = '/' . $canonicalLocale . '/careers/' . $citySlug . '/' . $roleSlug . '/';
      $queryString = count($query) ? '?'.http_build_query($query) : '';
      $redirectUrl = $scheme.'://'.$host.$canonical.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
  }
  
  // Handle GLOBAL service pages in non-canonical locales
  // GLOBAL service pages (without city) should only exist in en-us unless translated
  // Redirect non-en-us GLOBAL service pages to en-us
  if (preg_match('#^/([a-z]{2}-[a-z]{2})/services/([^/]+)/$#', $uri, $m)) {
    $locale = $m[1];
    $serviceSlug = $m[2];
    
    // Fix service slug mismatches FIRST (before locale redirects)
    // Redirect /structured-data/ to /structured-data-ai/ (correct service slug)
    // Also ensure correct locale (en-us only for GLOBAL service pages)
    if ($serviceSlug === 'structured-data') {
      $canonical = '/en-us/services/structured-data-ai/';
      $queryString = count($query) ? '?'.http_build_query($query) : '';
      $redirectUrl = $scheme.'://'.$host.$canonical.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
    
    // Fix service slug inconsistency: ai-overview-optimization (singular) → ai-overviews-optimization (plural)
    // Also ensure correct locale (en-us only for GLOBAL service pages)
    if ($serviceSlug === 'ai-overview-optimization') {
      $canonical = '/en-us/services/ai-overviews-optimization/';
      $queryString = count($query) ? '?'.http_build_query($query) : '';
      $redirectUrl = $scheme.'://'.$host.$canonical.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
    
    // Only en-us is canonical for GLOBAL service pages (unless translated)
    // For now, redirect all non-en-us to en-us
    if ($locale !== 'en-us') {
      $canonical = '/en-us/services/' . $serviceSlug . '/';
      $queryString = count($query) ? '?'.http_build_query($query) : '';
      $redirectUrl = $scheme.'://'.$host.$canonical.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
  }
  
  // Handle locale index pages that don't exist
  // Only en-us and en-gb index pages should exist (others redirect to en-us)
  if (preg_match('#^/(es-es|fr-fr|de-de|ko-kr)/?$#', $uri, $m)) {
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    $redirectUrl = $scheme.'://'.$host.'/en-us/'.$queryString;
    header("Location: $redirectUrl", true, 301);
    exit;
  }
  
  // Handle locale insights pages that don't exist
  // Only en-us insights should exist (others redirect to en-us)
  if (preg_match('#^/(es-es|fr-fr|de-de|ko-kr)/insights/?#', $uri, $m)) {
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    $redirectUrl = $scheme.'://'.$host.'/en-us/insights/'.$queryString;
    header("Location: $redirectUrl", true, 301);
    exit;
  }
  
  // Handle products pages in non-canonical locales
  // Products can exist in multiple locales if they're in hreflang allowlist
  // Only redirect unsupported locales (not in allowlist)
  if (preg_match('#^/(es-es|fr-fr|de-de|ko-kr)/products/#', $uri, $m)) {
    // These locales are not in hreflang allowlist - redirect to en-us
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    // Extract path after /products/
    if (preg_match('#^/[^/]+/products(/.*)$#', $uri, $pathMatch)) {
      $redirectUrl = $scheme.'://'.$host.'/en-us/products'.$pathMatch[1].$queryString;
    } else {
      $redirectUrl = $scheme.'://'.$host.'/en-us/products/'.$queryString;
    }
    header("Location: $redirectUrl", true, 301);
    exit;
  }
  // en-gb products are allowed (in hreflang allowlist) - no redirect
  
  // Handle careers index in non-canonical locales (excluding en-us and en-gb)
  // Careers index should only exist in en-us and en-gb
  if (preg_match('#^/(es-es|fr-fr|de-de|ko-kr)/careers/?$#', $uri, $m)) {
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    $redirectUrl = $scheme.'://'.$host.'/en-us/careers/'.$queryString;
    header("Location: $redirectUrl", true, 301);
    exit;
  }
  
  // Handle blog pages in non-canonical locales
  // Blog should only exist in en-us
  if (preg_match('#^/(es-es|fr-fr|de-de|ko-kr|en-gb)/blog/#', $uri, $m)) {
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    // Extract path after /blog/
    if (preg_match('#^/[^/]+/blog(/.*)$#', $uri, $pathMatch)) {
      $redirectUrl = $scheme.'://'.$host.'/en-us/blog'.$pathMatch[1].$queryString;
    } else {
      $redirectUrl = $scheme.'://'.$host.'/en-us/blog/'.$queryString;
    }
    header("Location: $redirectUrl", true, 301);
    exit;
  }
  
  // Handle promptware pages in non-canonical locales
  // Promptware should only exist in en-us
  if (preg_match('#^/(es-es|fr-fr|de-de|ko-kr|en-gb)/promptware/#', $uri, $m)) {
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    // Extract path after /promptware/
    if (preg_match('#^/[^/]+/promptware(/.*)$#', $uri, $pathMatch)) {
      $redirectUrl = $scheme.'://'.$host.'/en-us/promptware'.$pathMatch[1].$queryString;
    } else {
      $redirectUrl = $scheme.'://'.$host.'/en-us/promptware/'.$queryString;
    }
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
    
    // Special handling for /promptware/ without locale - redirect to en-us
    if ($uri === '/promptware/' || $uri === '/promptware') {
      $queryString = count($query) ? '?'.http_build_query($query) : '';
      $redirectUrl = $scheme.'://'.$host.'/en-us/promptware/'.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
    
    // Special handling for /booking/ - redirect to /book/ (canonical)
    if ($uri === '/booking/' || $uri === '/booking') {
      $queryString = count($query) ? '?'.http_build_query($query) : '';
      $defaultLocale = defined('X_DEFAULT') ? X_DEFAULT : 'en-us';
      $redirectUrl = $scheme.'://'.$host.'/'.$defaultLocale.'/book/'.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
    
    // Preserve query string (including UTMs for analytics)
    $queryString = count($query) ? '?'.http_build_query($query) : '';
    $defaultLocale = defined('X_DEFAULT') ? X_DEFAULT : 'en-us';
    $redirectUrl = $scheme.'://'.$host.'/'.$defaultLocale.$uri.$queryString;
    header("Location: $redirectUrl", true, 301);
    exit;
  }

  // Strip only known spam/junk params, preserve UTMs for analytics
  // Canonical tags will ignore UTMs, but we keep them in redirects for tracking
  $strip = []; // Keep all params in redirects - canonical tag handles UTM exclusion

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

