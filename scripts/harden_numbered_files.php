<?php
declare(strict_types=1);

/**
 * HARDEN NUMBERED FILES - Add guards and remove all metadata
 * 
 * This script:
 * 1. Adds ROUTER_CONTEXT guards to prevent direct execution
 * 2. Removes all metadata assignments and head.php includes
 * 3. Generates redirect URLs for direct access attempts
 */

$patterns = [
  [
    'glob' => 'pages/blog/blog-post-*.php',
    'route_pattern' => '/blog/blog-post-{N}/',
    'extract_number' => '/blog-post-(\d+)\.php$/'
  ],
  [
    'glob' => 'pages/case-studies/case-study-*.php',
    'route_pattern' => '/case-studies/case-study-{N}/',
    'extract_number' => '/case-study-(\d+)\.php$/'
  ],
  [
    'glob' => 'pages/resources/resource-*.php',
    'route_pattern' => '/resources/resource-{N}/',
    'extract_number' => '/resource-(\d+)\.php$/'
  ]
];

$total = 0;
$guarded = 0;
$cleaned = 0;
$errors = [];

foreach ($patterns as $pattern) {
  $files = glob(__DIR__.'/../'.$pattern['glob']);
  
  foreach ($files as $file) {
    $total++;
    $content = file_get_contents($file);
    $original = $content;
    $basename = basename($file);
    
    // Extract number from filename
    if (preg_match($pattern['extract_number'], $file, $m)) {
      $number = $m[1];
      $canonical = str_replace('{N}', $number, $pattern['route_pattern']);
      
      // Add guard at the very top (after opening PHP tag)
      $guard = <<<PHP
<?php
// Prevent direct access. This file is a data/partial for routed templates only.
if (!defined('ROUTER_CONTEXT')) {
  // Compute canonical routed URL
  \$canonical = '$canonical';
  
  // Ensure HTTPS and add locale prefix if needed
  \$scheme = (!empty(\$_SERVER['HTTPS']) || !empty(\$_SERVER['HTTP_X_FORWARDED_PROTO']) && \$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'https';
  \$host = \$_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  
  // Add default locale if not present
  if (!preg_match('#^/([a-z]{2})-([a-z]{2})/#i', \$canonical)) {
    require_once __DIR__.'/../../config/locales.php';
    \$canonical = '/'.X_DEFAULT.\$canonical;
  }
  
  \$redirectUrl = \$scheme.'://'.\$host.\$canonical;
  header("Location: \$redirectUrl", true, 301);
  exit;
}

PHP;
      
      // Check if guard already exists
      if (strpos($content, 'ROUTER_CONTEXT') === false) {
        // Remove opening PHP tag if present, add guard
        $content = preg_replace('/^<\?php\s*/', '', $content);
        $content = $guard . $content;
        $guarded++;
      }
      
      // Remove ALL metadata-related code
      // Remove head.php includes
      $content = preg_replace('/require_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/head\.php[\'"]\s*;/i', '', $content);
      $content = preg_replace('/require\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/head\.php[\'"]\s*;/i', '', $content);
      $content = preg_replace('/include\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/head\.php[\'"]\s*;/i', '', $content);
      $content = preg_replace('/include_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/head\.php[\'"]\s*;/i', '', $content);
      
      // Remove header.php includes (they'll be included by router)
      $content = preg_replace('/require_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/header\.php[\'"]\s*;/i', '', $content);
      
      // Remove metadata assignments
      $content = preg_replace('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[^;]+;/s', '', $content);
      $content = preg_replace('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[^;]+;/s', '', $content);
      $content = preg_replace('/\$page_meta_title\s*=\s*[^;]+;/s', '', $content);
      $content = preg_replace('/\$page_meta_description\s*=\s*[^;]+;/s', '', $content);
      $content = preg_replace('/\$canonicalPath\s*=\s*[^;]+;/s', '', $content);
      
      // Remove any <title> tags
      $content = preg_replace('/<title[^>]*>.*?<\/title>/is', '', $content);
      
      // Remove any meta description tags
      $content = preg_replace('/<meta\s+name=["\']description["\'][^>]*>/i', '', $content);
      
      // Remove comments about metadata
      $content = preg_replace('/\/\/\s*Metadata.*?\n/i', '', $content);
      $content = preg_replace('/\/\*\s*Metadata.*?\*\//is', '', $content);
      
      if ($content !== $original) {
        file_put_contents($file, $content);
        $cleaned++;
      }
    } else {
      $errors[] = "Could not extract number from: $file";
    }
  }
}

// Also handle tools and industries individual files
$toolFiles = glob(__DIR__.'/../pages/tools/*.php');
$excludeTools = ['tool.php', 'index.php'];
foreach ($toolFiles as $file) {
  $basename = basename($file);
  if (in_array($basename, $excludeTools)) continue;
  
  $total++;
  $content = file_get_contents($file);
  $original = $content;
  
  // Extract tool slug from filename
  $toolSlug = str_replace('.php', '', $basename);
  $canonical = "/tools/$toolSlug/";
  
  // Add guard
  $guard = <<<PHP
<?php
// Prevent direct access. This file is a data/partial for routed templates only.
if (!defined('ROUTER_CONTEXT')) {
  \$canonical = '$canonical';
  \$scheme = (!empty(\$_SERVER['HTTPS']) || !empty(\$_SERVER['HTTP_X_FORWARDED_PROTO']) && \$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'https';
  \$host = \$_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  if (!preg_match('#^/([a-z]{2})-([a-z]{2})/#i', \$canonical)) {
    require_once __DIR__.'/../../config/locales.php';
    \$canonical = '/'.X_DEFAULT.\$canonical;
  }
  \$redirectUrl = \$scheme.'://'.\$host.\$canonical;
  header("Location: \$redirectUrl", true, 301);
  exit;
}

PHP;
  
  if (strpos($content, 'ROUTER_CONTEXT') === false) {
    $content = preg_replace('/^<\?php\s*/', '', $content);
    $content = $guard . $content;
    $guarded++;
  }
  
  // Remove metadata
  $content = preg_replace('/require_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/head\.php[\'"]\s*;/i', '', $content);
  $content = preg_replace('/require_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/header\.php[\'"]\s*;/i', '', $content);
  $content = preg_replace('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[^;]+;/s', '', $content);
  $content = preg_replace('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[^;]+;/s', '', $content);
  
  if ($content !== $original) {
    file_put_contents($file, $content);
    $cleaned++;
  }
}

$industryFiles = glob(__DIR__.'/../pages/industries/*.php');
$excludeIndustries = ['industry.php', 'index.php'];
foreach ($industryFiles as $file) {
  $basename = basename($file);
  if (in_array($basename, $excludeIndustries)) continue;
  
  $total++;
  $content = file_get_contents($file);
  $original = $content;
  
  $industrySlug = str_replace('.php', '', $basename);
  $canonical = "/industries/$industrySlug/";
  
  $guard = <<<PHP
<?php
// Prevent direct access. This file is a data/partial for routed templates only.
if (!defined('ROUTER_CONTEXT')) {
  \$canonical = '$canonical';
  \$scheme = (!empty(\$_SERVER['HTTPS']) || !empty(\$_SERVER['HTTP_X_FORWARDED_PROTO']) && \$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'https';
  \$host = \$_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  if (!preg_match('#^/([a-z]{2})-([a-z]{2})/#i', \$canonical)) {
    require_once __DIR__.'/../../config/locales.php';
    \$canonical = '/'.X_DEFAULT.\$canonical;
  }
  \$redirectUrl = \$scheme.'://'.\$host.\$canonical;
  header("Location: \$redirectUrl", true, 301);
  exit;
}

PHP;
  
  if (strpos($content, 'ROUTER_CONTEXT') === false) {
    $content = preg_replace('/^<\?php\s*/', '', $content);
    $content = $guard . $content;
    $guarded++;
  }
  
  $content = preg_replace('/require_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/head\.php[\'"]\s*;/i', '', $content);
  $content = preg_replace('/require_once\s+__DIR__\s*\.\s*[\'"]\s*\.\.\/\.\.\/templates\/header\.php[\'"]\s*;/i', '', $content);
  $content = preg_replace('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[^;]+;/s', '', $content);
  $content = preg_replace('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[^;]+;/s', '', $content);
  
  if ($content !== $original) {
    file_put_contents($file, $content);
    $cleaned++;
  }
}

echo "HARDENING COMPLETE\n";
echo "==================\n";
echo "Total files scanned: $total\n";
echo "Files with guards added: $guarded\n";
echo "Files cleaned (metadata removed): $cleaned\n";
if (!empty($errors)) {
  echo "Errors: " . count($errors) . "\n";
  foreach ($errors as $error) {
    echo "  - $error\n";
  }
}

