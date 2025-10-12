<?php
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/hreflang.php';

$slug = $GLOBALS['__page_slug'] ?? 'home/home';
[$title,$desc,$path] = meta_for_slug($slug);
$baseSchemas = base_schemas();

header('Content-Type: text/html; charset=utf-8');
?><!doctype html>
<html lang="<?=htmlspecialchars(substr(current_locale(),0,2))?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=htmlspecialchars($title)?></title>
<meta name="description" content="<?=htmlspecialchars($desc)?>">
<link rel="canonical" href="<?=absolute_url($path)?>">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?= asset_url('/assets/css/98.min.css') ?>">
<link rel="stylesheet" href="<?= asset_url('/assets/css/nrlc98.css') ?>">
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

