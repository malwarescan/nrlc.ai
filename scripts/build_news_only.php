<?php
declare(strict_types=1);

/**
 * Rebuild ONLY News sitemaps from data/insights.csv (48h window, <=1000 per file).
 * Then regenerate the unified sitemap index by scanning existing shards.
 * Finally, update /public/robots.txt to point at the gzipped index.
 *
 * Outputs:
 *   /public/sitemaps/news-insights-*.xml(.gz)
 *   /public/sitemaps/sitemap-index.xml(.gz)   (rebuilt)
 *   /public/robots.txt                        (updated)
 */

require_once __DIR__.'/../lib/sitemap.php';
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../config/locales.php';

function csv_rows(string $file): array {
  return csv_read_data($file);
}

$dir = __DIR__.'/../public/sitemaps';
@mkdir($dir, 0775, true);

// 1) Load insights and build NEWS entries (48h)
$insightsRows = csv_rows('insights.csv'); // slug,title,lang,publication_date,lastmod,keywords...
$now = time();
$news = [];
foreach ($insightsRows as $r) {
  $slug = trim($r['slug'] ?? '');
  if ($slug==='') continue;
  $pub = strtotime($r['publication_date'] ?? '');
  if (!$pub) continue;
  if (($now - $pub) > 48*3600) continue; // older than 48h -> skip

  // News sitemap requires absolute URL; we anchor to X_DEFAULT locale
  $loc = absolute_url('/'.X_DEFAULT.'/insights/'.$slug.'/');
  $news[] = [
    'loc'              => $loc,
    'title'            => $r['title'] ?? 'Article',
    'publication_date' => gmdate('c', $pub),
    'language'         => substr(($r['lang'] ?? 'en'), 0, 2),
    'keywords'         => $r['keywords'] ?? '',
  ];
}

// 2) Remove OLD news shards to prevent index bloat
$oldNews = glob($dir.'/news-insights-*.xml');
$oldNewsGz = glob($dir.'/news-insights-*.xml.gz');
foreach (array_merge($oldNews, $oldNewsGz) as $f) @unlink($f);

// 3) Write NEW news shards (<=1000 per file)
$indexUrls = [];
if (!empty($news)) {
  $chunks = array_chunk($news, 1000);
  $i = 1;
  foreach ($chunks as $chunk) {
    $pubName = 'NRLC.ai';
    $pubLang = $chunk[0]['language'] ?? 'en';
    $xml = sitemap_render_news($chunk, $pubName, $pubLang);
    [, $gzUrl] = sitemap_write_files('news-insights-'.$i, $xml);
    $indexUrls[] = $gzUrl;
    $i++;
  }
}

// 4) Rebuild UNIFIED INDEX by scanning all .xml.gz shards (excluding index itself)
$allGz = glob($dir.'/*.xml.gz');
$shards = [];
foreach ($allGz as $path) {
  $base = basename($path);
  if ($base === 'sitemap-index.xml.gz') continue;
  $shards[] = absolute_url('/sitemaps/'.$base);
}
// If no shards, create an empty index to be safe
$indexXml = sitemap_render_index($shards);
[, $indexGzUrl] = sitemap_write_files('sitemap-index', $indexXml);

// 5) Refresh robots.txt to point to the gzipped index
$robotsPath = __DIR__.'/../public/robots.txt';
$lines = [];
if (file_exists($robotsPath)) {
  $lines = file($robotsPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
$lines = array_values(array_filter($lines, fn($l) => stripos($l, 'sitemap:') === false));
$lines[] = 'User-agent: *';
$lines[] = 'Allow: /';
$lines[] = 'Sitemap: '.$indexGzUrl;
file_put_contents($robotsPath, implode("\n", $lines)."\n");

// 6) Done
echo "News shards: ".(count($news) ? ceil(count($news)/1000) : 0)."\n";
echo "Unified index refreshed: $indexGzUrl\n";

