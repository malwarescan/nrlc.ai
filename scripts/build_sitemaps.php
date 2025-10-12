<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/sitemap.php';
require_once __DIR__ . '/../lib/csv.php';

$today = gmdate('Y-m-d');
$outDir = __DIR__ . '/../public/sitemaps/';

// Ensure output directory exists
if (!is_dir($outDir)) {
  mkdir($outDir, 0777, true);
}

// Load data
$servicesRows = csv_read_data('matrix.csv');
$careersRows = csv_read_data('career_matrix.csv');
$insightsRows = csv_read_data('insights.csv');
$imagesMap = csv_read_data('images_map.csv');

$sitemaps = [];

// 1. Services sitemap
$serviceEntries = [];
foreach ($servicesRows as $row) {
  $service = $row['service'] ?? '';
  $city = $row['city'] ?? '';
  $lastmod = $row['lastmod'] ?? $today;
  
  if ($service && $city) {
    $path = "/services/{$service}/{$city}/";
    $hreflangUrls = sitemap_generate_hreflang_urls($path);
    $serviceEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
  }
}

if ($serviceEntries) {
  $xmlFile = "{$outDir}services-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($serviceEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built services sitemap: " . count($serviceEntries) . " URLs\n";
}

// 2. Careers sitemap
$careerEntries = [];
foreach ($careersRows as $row) {
  $role = $row['role'] ?? '';
  $service = $row['service'] ?? '';
  $city = $row['city'] ?? '';
  $lastmod = $row['lastmod'] ?? $today;
  
  if ($role && $city) {
    $path = "/careers/{$city}/{$role}/";
    $hreflangUrls = sitemap_generate_hreflang_urls($path);
    $careerEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
  }
}

if ($careerEntries) {
  $xmlFile = "{$outDir}careers-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($careerEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built careers sitemap: " . count($careerEntries) . " URLs\n";
}

// 3. Insights sitemap
$insightEntries = [];
foreach ($insightsRows as $row) {
  $slug = $row['slug'] ?? '';
  $lastmod = $row['lastmod'] ?? $today;
  
  if ($slug) {
    $path = "/insights/{$slug}/";
    $hreflangUrls = sitemap_generate_hreflang_urls($path);
    $insightEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
  }
}

if ($insightEntries) {
  $xmlFile = "{$outDir}insights-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($insightEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built insights sitemap: " . count($insightEntries) . " URLs\n";
}

// 4. Images sitemap
$imageEntries = [];
foreach ($imagesMap as $row) {
  $url = $row['url'] ?? '';
  $imageUrl = $row['image_url'] ?? '';
  $imageTitle = $row['image_title'] ?? '';
  $imageCaption = $row['image_caption'] ?? '';
  
  if ($url && $imageUrl) {
    $entry = "  <url>\n    <loc>{$url}</loc>\n";
    $entry .= "    <image:image>\n";
    $entry .= "      <image:loc>{$imageUrl}</image:loc>\n";
    if ($imageTitle) $entry .= "      <image:title>{$imageTitle}</image:title>\n";
    if ($imageCaption) $entry .= "      <image:caption>{$imageCaption}</image:caption>\n";
    $entry .= "    </image:image>\n";
    $entry .= "  </url>\n";
    $imageEntries[] = $entry;
  }
}

if ($imageEntries) {
  $xmlFile = "{$outDir}images-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_images($imageEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built images sitemap: " . count($imageEntries) . " URLs\n";
}

// 5. News sitemap (recent insights only)
$newsEntries = [];
$cutoff = new DateTimeImmutable('-48 hours');
foreach ($insightsRows as $row) {
  $slug = $row['slug'] ?? '';
  $pubDate = $row['publication_date'] ?? '';
  
  if ($slug && $pubDate) {
    $pubDateTime = new DateTimeImmutable($pubDate);
    if ($pubDateTime > $cutoff) {
      $path = "/insights/{$slug}/";
      $hreflangUrls = sitemap_generate_hreflang_urls($path);
      $entry = "  <url>\n    <loc>{$hreflangUrls['en-us']}</loc>\n";
      $entry .= "    <news:news>\n";
      $entry .= "      <news:publication>\n";
      $entry .= "        <news:name>NRLC.ai</news:name>\n";
      $entry .= "        <news:language>en</news:language>\n";
      $entry .= "      </news:publication>\n";
      $entry .= "      <news:publication_date>{$pubDate}</news:publication_date>\n";
      $entry .= "      <news:title>" . htmlspecialchars($row['title'] ?? '') . "</news:title>\n";
      $entry .= "    </news:news>\n";
      $entry .= "  </url>\n";
      $newsEntries[] = $entry;
    }
  }
}

if ($newsEntries) {
  $xmlFile = "{$outDir}news-insights-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_news($newsEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built news sitemap: " . count($newsEntries) . " URLs\n";
}

// 6. Videos sitemap (from insights with video data)
$videoEntries = [];
foreach ($insightsRows as $row) {
  $slug = $row['slug'] ?? '';
  $videoUrl = $row['video_url'] ?? '';
  $videoThumbnail = $row['video_thumbnail'] ?? '';
  $videoDuration = $row['video_duration'] ?? '';
  $title = $row['title'] ?? '';
  $pubDate = $row['publication_date'] ?? '';
  
  if ($slug && $videoUrl) {
    $path = "/insights/{$slug}/";
    $hreflangUrls = sitemap_generate_hreflang_urls($path);
    
    $entry = "  <url>\n    <loc>{$hreflangUrls['en-us']}</loc>\n";
    $entry .= "    <video:video>\n";
    if ($videoThumbnail) $entry .= "      <video:thumbnail_loc>{$videoThumbnail}</video:thumbnail_loc>\n";
    $entry .= "      <video:content_loc>{$videoUrl}</video:content_loc>\n";
    if ($title) $entry .= "      <video:title>{$title}</video:title>\n";
    $entry .= "      <video:description>{$title} — NRLC.ai</video:description>\n";
    if ($videoDuration) $entry .= "      <video:duration>{$videoDuration}</video:duration>\n";
    if ($pubDate) $entry .= "      <video:publication_date>{$pubDate}</video:publication_date>\n";
    $entry .= "    </video:video>\n";
    $entry .= "  </url>\n";
    $videoEntries[] = $entry;
  }
}

if ($videoEntries) {
  $xmlFile = "{$outDir}videos-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_videos($videoEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built videos sitemap: " . count($videoEntries) . " URLs\n";
}

// 7. Generate unified index
$indexFile = "{$outDir}sitemap-index.xml";
$indexContent = sitemap_render_index($sitemaps);
file_put_contents($indexFile, $indexContent);
sitemap_write_gzipped("{$indexFile}.gz", $indexContent);

// 7. Update robots.txt
$robotsContent = "User-agent: *\nAllow: /\nSitemap: https://nrlc.ai/sitemaps/sitemap-index.xml.gz\n";
file_put_contents(__DIR__ . '/../public/robots.txt', $robotsContent);

echo "Built " . count($sitemaps) . " sitemap shards + unified index\n";
echo "Index URL: https://nrlc.ai/sitemaps/sitemap-index.xml.gz\n";