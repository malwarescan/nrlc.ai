<?php
declare(strict_types=1);

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/sitemap.php';
require_once __DIR__.'/../config/locales.php';

// ---------- LOAD DATA ----------
$servicesRows = csv_to_rows('matrix.csv');        // service,city,lastmod
$careersRows  = csv_to_rows('career_matrix.csv'); // role,service,city,lastmod
$insightsRows = csv_to_rows('insights.csv');      // slug,title,lang,publication_date,lastmod,image_url,video_url,video_thumbnail,video_duration,keywords
$imagesMap    = csv_to_rows('images_map.csv');    // url,image_url,image_title,image_caption

// ---------- CONSTRUCT ENTRIES ----------
// STANDARD (hreflang) — services
$servicesEntries = [];
foreach ($servicesRows as $r) {
  $path = "/services/{$r['service']}/{$r['city']}/";
  $servicesEntries[] = [
    'path'    => $path,
    'lastmod' => $r['lastmod'] ?? null,
  ];
}

// STANDARD (hreflang) — careers
$careersEntries = [];
foreach ($careersRows as $r) {
  $path = "/careers/{$r['city']}/{$r['role']}/";
  $careersEntries[] = [
    'path'    => $path,
    'lastmod' => $r['lastmod'] ?? null,
  ];
}

// STANDARD (hreflang) — insights listing (non-news)
$insightsEntries = [];
foreach ($insightsRows as $r) {
  $slug = trim($r['slug']);
  if ($slug === '') continue;
  $path = "/insights/{$slug}/";
  $insightsEntries[] = [
    'path'    => $path,
    'lastmod' => $r['lastmod'] ?? ($r['publication_date'] ?? null),
  ];
}

// IMAGE SITEMAP entries (merge images_map and insights.image_url into URL->images[])
$imageGroups = []; // url => [ [loc,title,caption], ... ]
foreach ($imagesMap as $row) {
  $u = trim($row['url']);
  if ($u === '') continue;
  $imageGroups[$u][] = [
    'loc'     => $row['image_url'],
    'title'   => $row['image_title'] ?? '',
    'caption' => $row['image_caption'] ?? '',
  ];
}
// Also fold in insights hero image if present
foreach ($insightsRows as $r) {
  if (!empty($r['image_url'])) {
    $url = "/insights/{$r['slug']}/";
    $imageGroups[$url][] = [
      'loc'     => $r['image_url'],
      'title'   => $r['title'] ?? '',
      'caption' => 'Hero image',
    ];
  }
}

// VIDEO SITEMAP entries (from insights)
$videoGroups = []; // url => [ [content, thumbnail, title, description, duration, publication_date], ... ]
foreach ($insightsRows as $r) {
  if (!empty($r['video_url']) && !empty($r['video_thumbnail'])) {
    $url = "/insights/{$r['slug']}/";
    $videoGroups[$url][] = [
      'content'          => $r['video_url'],
      'thumbnail'        => $r['video_thumbnail'],
      'title'            => $r['title'] ?? 'Video',
      'description'      => ($r['title'] ?? 'Video').' — NRLC.ai',
      'duration'         => intval($r['video_duration'] ?? 0),
      'publication_date' => $r['publication_date'] ?? null,
    ];
  }
}

// NEWS SITEMAP entries (last 48h only, <=1000 per file)
$now = time();
$newsEntries = [];
foreach ($insightsRows as $r) {
  $pub = strtotime($r['publication_date'] ?? '');
  if (!$pub) continue;
  if (($now - $pub) > 48*3600) continue; // older than 48h => skip for News
  $loc = absolute_url('/'.X_DEFAULT.'/insights/'.$r['slug'].'/');
  $newsEntries[] = [
    'loc'              => $loc,
    'title'            => $r['title'] ?? 'Article',
    'publication_date' => gmdate('c', $pub),
    'language'         => substr(($r['lang'] ?? 'en'),0,2),
    'keywords'         => $r['keywords'] ?? '',
  ];
}

// ---------- WRITE SHARDS ----------
$indexUrls = []; // collect all .xml.gz URLs to list in the unified index
$shardSizeStd   = 10000; // standard sitemaps
$shardSizeNews  = 1000;  // News constraint

$writeStd = function(string $section, array $entries) use (&$indexUrls, $shardSizeStd) {
  $chunks = array_chunk($entries, $shardSizeStd);
  $i = 1;
  foreach ($chunks as $chunk) {
    $urls = [];
    foreach ($chunk as $e) {
      $urls[] = sitemap_entry_with_hreflang($e['path'], X_DEFAULT, $e['lastmod']);
    }
    $xml = sitemap_render_urlset($urls);
    [, $gzUrl] = sitemap_write_files("{$section}-{$i}", $xml);
    $indexUrls[] = $gzUrl;
    $i++;
  }
};

$writeImages = function(string $section, array $groups) use (&$indexUrls, $shardSizeStd) {
  // groups: url => images[]
  $rows = [];
  foreach ($groups as $url => $images) {
    $rows[] = [
      'loc'    => absolute_url('/'.X_DEFAULT.$url),
      'images' => $images
    ];
  }
  $chunks = array_chunk($rows, $shardSizeStd);
  $i = 1;
  foreach ($chunks as $chunk) {
    $xml = sitemap_render_images($chunk);
    [, $gzUrl] = sitemap_write_files("{$section}-{$i}", $xml);
    $indexUrls[] = $gzUrl;
    $i++;
  }
};

$writeVideos = function(string $section, array $groups) use (&$indexUrls, $shardSizeStd) {
  $rows = [];
  foreach ($groups as $url => $videos) {
    $rows[] = [
      'loc'    => absolute_url('/'.X_DEFAULT.$url),
      'videos' => $videos
    ];
  }
  if (empty($rows)) return;
  $chunks = array_chunk($rows, $shardSizeStd);
  $i = 1;
  foreach ($chunks as $chunk) {
    $xml = sitemap_render_videos($chunk);
    [, $gzUrl] = sitemap_write_files("{$section}-{$i}", $xml);
    $indexUrls[] = $gzUrl;
    $i++;
  }
};

$writeNews = function(string $section, array $news) use (&$indexUrls, $shardSizeNews) {
  if (empty($news)) return;
  $chunks = array_chunk($news, $shardSizeNews);
  $i = 1;
  foreach ($chunks as $chunk) {
    // Use site brand + language of first item (News requires a publication language)
    $pubName = 'NRLC.ai';
    $pubLang = $chunk[0]['language'] ?? 'en';

    $xml = sitemap_render_news($chunk, $pubName, $pubLang);
    [, $gzUrl] = sitemap_write_files("news-{$section}-{$i}", $xml);
    $indexUrls[] = $gzUrl;
    $i++;
  }
};

// Standard URL sitemaps (hreflang)
$writeStd('services', $servicesEntries);
$writeStd('careers',  $careersEntries);
$writeStd('insights', $insightsEntries);

// Image sitemap(s)
$writeImages('images', $imageGroups);

// Video sitemap(s)
$writeVideos('videos', $videoGroups);

// News sitemap(s) — last 48h only
$writeNews('insights', $newsEntries);

// ---------- UNIFIED INDEX ----------
$indexXml = sitemap_render_index($indexUrls);
[, $indexGzUrl] = sitemap_write_files('sitemap-index', $indexXml);

// ---------- ROBOTS.TXT ----------
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

echo "Built ".count($indexUrls)." sitemap shards.\n";
echo "Unified index: $indexGzUrl\n";
