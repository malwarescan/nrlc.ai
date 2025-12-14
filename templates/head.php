<?php
// Prevent double inclusion - if head already rendered, return early
if (defined('HEAD_PHP_INCLUDED')) {
  return;
}
define('HEAD_PHP_INCLUDED', true);

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/hreflang.php';

$slug = $GLOBALS['__page_slug'] ?? 'home/home';

// SINGLE SOURCE OF TRUTH: Only accept metadata from router's ctx-based system
// Fail-closed if $meta is missing (prevents bypassed metadata)
if (!isset($GLOBALS['__page_meta']) || !is_array($GLOBALS['__page_meta'])) {
  // FAIL-CLOSED: No metadata from router means this page bypassed the router
  $isProduction = !in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000']);
  
  if ($isProduction) {
    // Production: Output noindex to prevent indexing of bypassed pages
    echo '<meta name="robots" content="noindex,nofollow">' . "\n";
    // Still provide minimal metadata to prevent errors
    $title = 'NRLC.ai';
    $desc = 'AI SEO services and solutions';
  } else {
    // Non-production: Hard error to catch bypasses during development
    trigger_error("CRITICAL: templates/head.php called without router metadata. Page bypassed router meta system. Slug: $slug", E_USER_ERROR);
    $title = 'ERROR: Missing Metadata';
    $desc = 'This page bypassed the router metadata system';
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
} else {
  // Router metadata exists - use it exclusively
  $meta = $GLOBALS['__page_meta'];
  $title = $meta['title'] ?? 'NRLC.ai';
  $desc = $meta['description'] ?? 'AI SEO services and solutions';
  $canonicalPath = $meta['canonicalPath'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
}

$baseSchemas = base_schemas();

header('Content-Type: text/html; charset=utf-8');
?><!doctype html>
<html lang="<?=htmlspecialchars(substr(current_locale(),0,2))?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=htmlspecialchars($title)?></title>
<meta name="description" content="<?=htmlspecialchars($desc)?>">
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

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?=absolute_url($canonicalPath)?>">
<meta property="og:title" content="<?=htmlspecialchars($title)?>">
<meta property="og:description" content="<?=htmlspecialchars($desc)?>">
<meta property="og:site_name" content="NRLC.ai">
<meta property="og:image" content="https://nrlc.ai/assets/nrlc-og-image.jpg">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?=absolute_url($canonicalPath)?>">
<meta property="twitter:title" content="<?=htmlspecialchars($title)?>">
<meta property="twitter:description" content="<?=htmlspecialchars($desc)?>">
<meta property="twitter:image" content="https://nrlc.ai/assets/nrlc-og-image.jpg">

<!-- Additional SEO Meta -->
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow">
<meta name="bingbot" content="index, follow">
<meta name="author" content="NRLC.ai">
<meta name="keywords" content="AI SEO, GEO-16, LLM Seeding, Structured Data, Crawl Clarity, <?=htmlspecialchars(extract_keywords_from_title($title))?>">
<!-- Schema.org Powered -->
<meta name="generator" content="Schema.org Structured Data">
<meta name="schema-org" content="https://schema.org">
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
?>
</head>
<body>

