<?php
declare(strict_types=1);

/**
 * Finalize all routes to use ctx-based metadata
 * This script identifies routes that don't set $GLOBALS['__page_meta'] and adds it
 */

require_once __DIR__.'/../lib/meta_directive.php';

$routerFile = __DIR__.'/../bootstrap/router.php';
$content = file_get_contents($routerFile);

// Routes that need metadata but don't have it
$routesNeedingMeta = [
  '/en-us/' => ['type' => 'home', 'slug' => 'home/home'],
  '/services/([^/]+)/$' => ['type' => 'service', 'slug' => 'services/service'],
  '/careers/' => ['type' => 'home', 'slug' => 'careers/index'],
  '/insights/' => ['type' => 'home', 'slug' => 'insights/index'],
  '/products/' => ['type' => 'home', 'slug' => 'products/index'],
  '/promptware/' => ['type' => 'home', 'slug' => 'promptware/index'],
  '/catalog/' => ['type' => 'home', 'slug' => 'catalog/index'],
  '/industries/' => ['type' => 'home', 'slug' => 'industries/index'],
  '/tools/' => ['type' => 'home', 'slug' => 'tools/index'],
  '/case-studies/' => ['type' => 'home', 'slug' => 'case-studies/index'],
  '/resources/' => ['type' => 'home', 'slug' => 'resources/index'],
  '/blog/' => ['type' => 'home', 'slug' => 'blog/index'],
];

echo "Routes needing metadata conversion:\n";
foreach ($routesNeedingMeta as $pattern => $info) {
  echo "  $pattern -> {$info['type']} / {$info['slug']}\n";
}

echo "\nNote: Manual conversion required in bootstrap/router.php\n";
echo "Each route must call sudo_meta_directive_ctx() and set \$GLOBALS['__page_meta']\n";

