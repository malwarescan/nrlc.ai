<?php
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/hreflang.php';

$slug = $GLOBALS['__page_slug'] ?? 'home/home';

// Use custom metadata if provided, otherwise use meta_for_slug
if (isset($GLOBALS['pageTitle']) && isset($GLOBALS['pageDesc'])) {
  $title = $GLOBALS['pageTitle'];
  $desc = $GLOBALS['pageDesc'];
  $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
} else {
  [$title,$desc,$path] = meta_for_slug($slug);
}

$baseSchemas = base_schemas();

// Build canonical URL with locale prefix
// Get the actual request path (includes locale prefix if present)
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Normalize the path (lowercase, remove double slashes, ensure trailing slash for directories)
$requestPath = preg_replace('#/{2,}#', '/', strtolower($requestPath));
if (!preg_match('#\.[a-z0-9]+$#', $requestPath) && substr($requestPath, -1) !== '/') {
  $requestPath .= '/';
}

// Use the request path as canonical (it already includes locale prefix if present)
$canonicalPath = $requestPath;

header('Content-Type: text/html; charset=utf-8');
?><!doctype html>
<html lang="<?=htmlspecialchars(substr(current_locale(),0,2))?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=htmlspecialchars($title)?></title>
<meta name="description" content="<?=htmlspecialchars($desc)?>">
<link rel="icon" type="image/png" href="/favicon.ico.png">
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
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= asset_url('/assets/css/98.min.css') ?>">
<link rel="stylesheet" href="<?= asset_url('/assets/css/nrlc98.css') ?>">
<link rel="stylesheet" href="<?= asset_url('/assets/css/grid-bg.css') ?>">
<link rel="stylesheet" href="<?= asset_url('/assets/css/progress-indicator.css') ?>">
<?php
foreach (hreflang_links(without_locale_prefix($path)) as $alt) {
  echo '<link rel="'.$alt['rel'].'" hreflang="'.$alt['hreflang'].'" href="'.$alt['href'].'">'."\n";
}
foreach ($baseSchemas as $s) {
  echo '<script type="application/ld+json">'.json_encode($s, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
?>
</head>
<body>

