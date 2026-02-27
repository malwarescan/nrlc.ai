<?php
// Prevent double inclusion - if head already rendered, return early
if (defined('HEAD_PHP_INCLUDED')) {
  return;
}
define('HEAD_PHP_INCLUDED', true);

// Set header FIRST before any output
if (!headers_sent()) {
  header('Content-Type: text/html; charset=utf-8');
}

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/hreflang.php';
require_once __DIR__.'/../config/locales.php'; // Required for locale metadata in HTML lang and Content-Language
require_once __DIR__.'/../config/clarity.php'; // Microsoft Clarity configuration

$slug = $GLOBALS['__page_slug'] ?? 'home/home';

// SINGLE SOURCE OF TRUTH: Only accept metadata from router's ctx-based system
// Fail-closed if $meta is missing (prevents bypassed metadata)
if (!isset($GLOBALS['__page_meta']) || !is_array($GLOBALS['__page_meta'])) {
  // FAIL-CLOSED: No metadata from router means this page bypassed the router
  $isProduction = !in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000']);
  
  if ($isProduction) {
    // Production: Output noindex to prevent indexing of bypassed pages
    // Note: This output happens AFTER header is set, so it's safe
    $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
    // Still provide minimal metadata to prevent errors
    $title = 'NRLC.ai';
    $desc = 'AI SEO services and solutions';
  } else {
    // Non-production: Hard error to catch bypasses during development
    trigger_error("CRITICAL: templates/head.php called without router metadata. Page bypassed router meta system. Slug: $slug", E_USER_ERROR);
    $title = 'ERROR: Missing Metadata';
    $desc = 'This page bypassed the router metadata system';
    $noindexMeta = '';
  }
  
  // Build canonical from request path
  $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  if ($requestPath === '/' || $requestPath === '') {
    $canonicalPath = '/';
  } else {
    require_once __DIR__.'/../config/locales.php';
    if (!preg_match('#^/([a-z]{2})-([a-z]{2})(/|$)#i', $requestPath)) {
      $canonicalPath = '/'.X_DEFAULT.$requestPath;
    } else {
      $canonicalPath = $requestPath;
    }
  }
  
  // --- OG defaults (NRLC) - fallback case ---
  $siteName = "NRLC.ai";
  $baseUrl  = "https://nrlc.ai";
  $canonical = absolute_url($canonicalPath);
  $ogImage = $baseUrl . "/assets/og/nrlc-og-1200x630.jpg";
  $ogImageVersion = "1";
  $ogImageWithVer = $ogImage . "?v=" . rawurlencode($ogImageVersion);
  $ogLocale = str_replace('-', '_', current_locale());
} else {
  // Router metadata exists - use it exclusively
  $meta = $GLOBALS['__page_meta'];
  $title = $meta['title'] ?? 'NRLC.ai';
  $desc = $meta['description'] ?? 'AI SEO services and solutions';
  $canonicalPath = $meta['canonicalPath'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  $customKeywords = $meta['keywords'] ?? null;
  
  // --- OG defaults (NRLC) ---
  $siteName = "NRLC.ai";
  $baseUrl  = "https://nrlc.ai";
  $canonical = absolute_url($canonicalPath);
  $ogImage = $meta['ogImage'] ?? ($baseUrl . "/assets/og/nrlc-og-1200x630.jpg");
  $ogImageVersion = $meta['ogImageVersion'] ?? "1";
  $ogImageWithVer = $ogImage . "?v=" . rawurlencode($ogImageVersion);
  $ogLocale = str_replace('-', '_', current_locale());
  
  // Check if noindex is explicitly set in metadata (e.g., for API endpoints)
  $noindexMeta = (!empty($meta['noindex'])) ? '<meta name="robots" content="noindex,nofollow">' . "\n" : '';
  
  // GSC FIX: Fix canonical tag for non-canonical locale versions
  // This prevents "Duplicate, Google chose different canonical than user" issues
  $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  if (preg_match('#^/([a-z]{2})-([a-z]{2})(.+)$#i', $requestPath, $m)) {
    $currentLocale = strtolower($m[1] . '-' . $m[2]);
    $pathWithoutLocale = $m[3];
    
    // Check if this is a LOCAL page
    if (function_exists('is_local_page') && is_local_page($pathWithoutLocale)) {
      // Check if current locale is canonical for this LOCAL page
      if (function_exists('is_canonical_locale_for_local_page')) {
        if (!is_canonical_locale_for_local_page($pathWithoutLocale, $currentLocale)) {
          // Non-canonical locale version of LOCAL page
          // CRITICAL: Set canonical tag to canonical locale version, NOT to self
          if (function_exists('get_canonical_locale_for_city')) {
            // Extract city from path
            if (preg_match('#/services/[^/]+/([^/]+)/#', $pathWithoutLocale, $cityMatch)) {
              $citySlug = $cityMatch[1];
              $canonicalLocale = get_canonical_locale_for_city($citySlug);
              // Override canonical path to point to canonical locale version
              $canonicalPath = '/' . $canonicalLocale . $pathWithoutLocale;
            } else if (preg_match('#/careers/([^/]+)/#', $pathWithoutLocale, $cityMatch)) {
              $citySlug = $cityMatch[1];
              $canonicalLocale = get_canonical_locale_for_city($citySlug);
              // Override canonical path to point to canonical locale version
              $canonicalPath = '/' . $canonicalLocale . $pathWithoutLocale;
            }
          }
          // Also add noindex as backup (redirects should catch these, but noindex is extra protection)
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
      }
    } else {
      // This is a GLOBAL page
      // GLOBAL pages should only exist in en-us unless translated
      // For now, all GLOBAL pages default to en-us canonical
      
      // Handle GLOBAL service pages (without city)
      // GLOBAL service pages should only exist in en-us
      if (preg_match('#^/services/([^/]+)/$#', $pathWithoutLocale, $serviceMatch)) {
        if ($currentLocale !== 'en-us') {
          // Non-en-us GLOBAL service page - canonicalize to en-us
          $canonicalPath = '/en-us' . $pathWithoutLocale;
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
      }
      // Handle insights pages (GLOBAL)
      // Insights should only exist in en-us
      else if (preg_match('#^/insights(/.*)?$#', $pathWithoutLocale)) {
        if ($currentLocale !== 'en-us') {
          // Non-en-us insights page - canonicalize to en-us
          $canonicalPath = '/en-us' . $pathWithoutLocale;
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
      }
      // Handle careers index page (GLOBAL)
      // Careers index should only exist in en-us and en-gb
      else if ($pathWithoutLocale === '/careers/' || $pathWithoutLocale === '/careers') {
        if ($currentLocale !== 'en-us' && $currentLocale !== 'en-gb') {
          // Non-en-us/en-gb careers index - canonicalize to en-us
          $canonicalPath = '/en-us/careers/';
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
      }
      // Handle products pages in non-en-us locales
      // Products can exist in multiple locales if they're in hreflang allowlist
      else if (preg_match('#^/products/#', $pathWithoutLocale)) {
        // Check if products are in hreflang allowlist
        require_once __DIR__.'/../lib/hreflang_allowlist.php';
        $allowlist = require __DIR__.'/../lib/hreflang_allowlist.php';
        $productsInAllowlist = isset($allowlist['/products/']) && in_array($currentLocale, $allowlist['/products/']);
        
        if (!$productsInAllowlist && $currentLocale !== 'en-us') {
          // Non-en-us products page not in allowlist - canonicalize to en-us
          $canonicalPath = '/en-us' . $pathWithoutLocale;
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
        // en-us and allowlisted locale products pages are legitimate and should be indexed
      }
      // Handle promptware pages in non-en-us locales
      else if (preg_match('#^/promptware/#', $pathWithoutLocale)) {
        if ($currentLocale !== 'en-us') {
          // Non-en-us promptware page - canonicalize to en-us
          $canonicalPath = '/en-us' . $pathWithoutLocale;
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
      }
      // Handle blog pages in non-en-us locales
      else if (preg_match('#^/blog/#', $pathWithoutLocale)) {
        if ($currentLocale !== 'en-us') {
          // Non-en-us blog page - canonicalize to en-us
          $canonicalPath = '/en-us' . $pathWithoutLocale;
          $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
        }
      }
      // Handle other non-canonical locale GLOBAL pages (es-es, fr-fr, de-de, ko-kr)
      else if (in_array($currentLocale, ['es-es', 'fr-fr', 'de-de', 'ko-kr'])) {
        // These locales are not supported for GLOBAL pages - canonicalize to en-us
        $canonicalPath = '/en-us' . $pathWithoutLocale;
        $noindexMeta = '<meta name="robots" content="noindex,nofollow">' . "\n";
      }
    }
  }
}

$baseSchemas = base_schemas();
// CRITICAL: Language signals for Google Translated Results
// - HTML lang attribute with full locale code (e.g., en-US)
// - Content-Language meta tag
// These help Google detect page language and enable automatic translation
$currentLocale = current_locale();
$localeMeta = LOCALES[$currentLocale] ?? LOCALES[X_DEFAULT];
$htmlLang = $localeMeta['lang'] . '-' . strtoupper($localeMeta['region']);
$contentLanguage = $localeMeta['lang'] . '-' . strtolower($localeMeta['region']);
?><!doctype html>
<html lang="<?=htmlspecialchars($htmlLang)?>">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TKNQCB74W7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TKNQCB74W7');
</script>

<?php if (clarity_should_load()): ?>
<!-- Microsoft Clarity Configuration -->
<script>
  window.clarityConfig = <?= clarity_get_js_config() ?>;
</script>

<!-- Microsoft Clarity - Behavioral Analytics -->
<script src="<?= asset_url('/assets/js/clarity.js') ?>"></script>
<?php endif; ?>
<?php if (isset($noindexMeta)) echo $noindexMeta; ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Language" content="<?= htmlspecialchars($contentLanguage) ?>">
<title><?=htmlspecialchars($title)?></title>
<meta name="description" content="<?=htmlspecialchars($desc)?>">
<?php if (!empty($customKeywords)): ?>
<meta name="keywords" content="<?= htmlspecialchars(is_array($customKeywords) ? implode(', ', $customKeywords) : $customKeywords) ?>">
<?php endif; ?>
<!-- Base ICO (legacy + broad UA support) -->
<link rel="icon" href="/favicon.ico" sizes="any">

<!-- PNG favicons -->
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">

<!-- Apple touch -->
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

<!-- PWA (optional but recommended) -->
<link rel="manifest" href="/site.webmanifest">

<!-- Minimal browser UI hint -->
<meta name="theme-color" content="#0B1220">
<link rel="canonical" href="<?=absolute_url($canonicalPath)?>">
<!-- AI/LLM discovery: plain-text site summary for crawlers -->
<link rel="alternate" type="text/plain" href="<?= htmlspecialchars($baseUrl ?? 'https://nrlc.ai', ENT_QUOTES) ?>/llms.txt" title="LLM-oriented site summary">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= htmlspecialchars($siteName ?? 'NRLC.ai', ENT_QUOTES) ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonical ?? absolute_url($canonicalPath), ENT_QUOTES) ?>">
<meta property="og:title" content="<?= htmlspecialchars($title, ENT_QUOTES) ?>">
<meta property="og:description" content="<?= htmlspecialchars($desc, ENT_QUOTES) ?>">
<meta property="og:locale" content="<?= htmlspecialchars($ogLocale ?? str_replace('-', '_', current_locale()), ENT_QUOTES) ?>">
<meta property="og:image" content="<?= htmlspecialchars($ogImageWithVer ?? ($baseUrl ?? 'https://nrlc.ai') . '/assets/og/nrlc-og-1200x630.jpg', ENT_QUOTES) ?>">
<meta property="og:image:secure_url" content="<?= htmlspecialchars($ogImageWithVer ?? ($baseUrl ?? 'https://nrlc.ai') . '/assets/og/nrlc-og-1200x630.jpg', ENT_QUOTES) ?>">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?= htmlspecialchars($title, ENT_QUOTES) ?>">
<?php
// Article meta tags for homepage (author and publisher)
if ($canonicalPath === '/' || $canonicalPath === '/en-us/' || $canonicalPath === ''):
?>
<meta property="article:author" content="Joel Maldonado">
<meta property="article:publisher" content="https://nrlc.ai">
<?php endif; ?>

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($title, ENT_QUOTES) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($desc, ENT_QUOTES) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImageWithVer ?? ($baseUrl ?? 'https://nrlc.ai') . '/assets/og/nrlc-og-1200x630.jpg', ENT_QUOTES) ?>">
<meta name="twitter:creator" content="@neuralcommand">
<meta name="twitter:site" content="@neuralcommand">

<!-- Additional SEO Meta -->
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow">
<meta name="bingbot" content="index, follow">
<meta name="author" content="Joel Maldonado">
<meta name="keywords" content="<?= htmlspecialchars($customKeywords ?? 'AI SEO, GEO-16, LLM Seeding, Structured Data, Crawl Clarity, ' . extract_keywords_from_title($title)) ?>">
<!-- Schema.org Powered -->
<meta name="generator" content="Schema.org Structured Data">
<meta name="schema-org" content="https://schema.org">

<!-- CROUTONS PROTOCOL META TAGS -->
<meta name="croutons-protocol" content="micro-facts">
<meta name="croutons-verified" content="nrlc-ai">
<meta name="croutons-version" content="1.0">
<meta name="croutons-api" content="https://croutons.ai/api">
<?php
// Croutons Protocol: Automated discovery link for atomic facts
$croutonsPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/') ?: 'index';
$croutonsMarkdownUrl = "https://md.croutons.ai/nrlc.ai/{$croutonsPath}.md";
?>
<link rel="alternate" type="text/markdown" href="<?= htmlspecialchars($croutonsMarkdownUrl) ?>">

<!-- W3C Functional Authority Design System -->
<link rel="stylesheet" href="<?= asset_url('/assets/css/w3c-functional.css') ?>">
<!-- Hero Isometric Animation -->
<link rel="stylesheet" href="<?= asset_url('/assets/css/hero-isometric.css') ?>">
<!-- GSAP Animation Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<?php
// SUDO HREFLANG ALLOWLIST — GLOBAL PAGE PILOT + SAFE SCALE
// Use canonicalPath for hreflang (remove locale prefix for hreflang generation)
$hreflangPath = $canonicalPath ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (function_exists('without_locale_prefix')) {
  $hreflangPath = without_locale_prefix($hreflangPath);
}

// Get hreflang links from allowlist (returns empty array for LOCAL pages or if not in allowlist)
// Allowlist is the single source of truth - no need to pass hasRealTranslations parameter
$hreflangLinks = hreflang_links($hreflangPath);

// Output hreflang tags (will be empty for LOCAL pages or pages not in allowlist)
foreach ($hreflangLinks as $alt) {
  echo '<link rel="'.$alt['rel'].'" hreflang="'.$alt['hreflang'].'" href="'.$alt['href'].'">'."\n";
}
foreach ($baseSchemas as $s) {
  echo '<script type="application/ld+json">'.json_encode($s, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}

// Allow pages to inject custom CSS before </head>
if (isset($GLOBALS['__custom_css']) && is_array($GLOBALS['__custom_css'])) {
  foreach ($GLOBALS['__custom_css'] as $cssUrl) {
    echo '<link rel="stylesheet" href="' . htmlspecialchars($cssUrl) . '">' . "\n";
  }
}

// MACHINE-NATIVE MARKDOWN EXPOSURE: Auto-discovery link for eligible pages
require_once __DIR__.'/../lib/markdown_exposure.php';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_markdown_eligible($requestPath)) {
  $markdownUrl = absolute_url(get_markdown_url($requestPath));
  echo '<link rel="alternate" type="text/markdown" href="' . htmlspecialchars($markdownUrl) . '">' . "\n";
}
?>
</head>
<body>

