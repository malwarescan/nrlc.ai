<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/sitemap.php';
require_once __DIR__ . '/../lib/csv.php';
require_once __DIR__ . '/../config/locales.php';

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
  $lastmod = $row['lastmod'] ?? $pubDate ?? $today;
  $imageUrl = $row['image_url'] ?? '';
  
  if ($slug && $pubDate) {
    $pubDateTime = new DateTimeImmutable($pubDate);
    if ($pubDateTime > $cutoff) {
      $path = "/insights/{$slug}/";
      $hreflangUrls = sitemap_generate_hreflang_urls($path);
      $entry = "  <url>\n    <loc>{$hreflangUrls['en-us']}</loc>\n";
      $entry .= "    <lastmod>{$lastmod}</lastmod>\n";
      $entry .= "    <changefreq>monthly</changefreq>\n";
      $entry .= "    <priority>0.9</priority>\n";
      $entry .= "    <news:news>\n";
      $entry .= "      <news:publication>\n";
      $entry .= "        <news:name>Neural Command</news:name>\n";
      $entry .= "        <news:language>en</news:language>\n";
      $entry .= "      </news:publication>\n";
      $entry .= "      <news:publication_date>{$pubDate}</news:publication_date>\n";
      // Use shortened title for news:title (Google News requirement: max 150 chars)
      $newsTitle = htmlspecialchars($row['title'] ?? '');
      if (strlen($newsTitle) > 150) {
        $newsTitle = substr($newsTitle, 0, 147) . '...';
      }
      $entry .= "      <news:title>{$newsTitle}</news:title>\n";
      $entry .= "    </news:news>\n";
      // Add image if available
      if ($imageUrl) {
        $entry .= "    <image:image>\n";
        $entry .= "      <image:loc>{$imageUrl}</image:loc>\n";
        $entry .= "      <image:title>{$newsTitle}</image:title>\n";
        $entry .= "    </image:image>\n";
      }
      $entry .= "  </url>\n";
      $newsEntries[] = $entry;
    }
  }
}

if ($newsEntries) {
  $xmlFile = "{$outDir}news-insights-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_news_with_images($newsEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built news sitemap: " . count($newsEntries) . " URLs\n";
}

// 6. Industries sitemap
$industryEntries = [];
$industryPages = [
  'healthcare', 'fintech', 'ecommerce', 'saas', 'education', 'real-estate',
  'legal', 'automotive', 'travel', 'hospitality', 'manufacturing', 'retail',
  'consulting', 'media', 'entertainment'
];

foreach ($industryPages as $industry) {
  $hreflangUrls = [];
  foreach (LOCALES as $locale => $data) {
    $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}/industries/{$industry}/";
  }
  $industryEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($industryEntries) {
  $xmlFile = "{$outDir}industries-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($industryEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built industries sitemap: " . count($industryEntries) . " URLs\n";
}

// 7. Tools sitemap
$toolEntries = [];
$toolPages = [
  'chatgpt', 'claude', 'perplexity', 'bard', 'copilot', 'google-ai-overviews',
  'schema-generator', 'json-ld-validator', 'structured-data-testing',
  'screaming-frog', 'sitebulb', 'ahrefs', 'semrush', 'moz', 'brightedge', 'seer-interactive'
];

foreach ($toolPages as $tool) {
  $hreflangUrls = [];
  foreach (LOCALES as $locale => $data) {
    $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}/tools/{$tool}/";
  }
  $toolEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($toolEntries) {
  $xmlFile = "{$outDir}tools-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($toolEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built tools sitemap: " . count($toolEntries) . " URLs\n";
}

// 8. Case studies sitemap
$caseStudyEntries = [];
for ($i = 1; $i <= 200; $i++) {
  $hreflangUrls = [];
  foreach (LOCALES as $locale => $data) {
    $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}/case-studies/case-study-{$i}/";
  }
  $caseStudyEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($caseStudyEntries) {
  $xmlFile = "{$outDir}case-studies-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($caseStudyEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built case studies sitemap: " . count($caseStudyEntries) . " URLs\n";
}

// 9. Blog posts sitemap
$blogEntries = [];
for ($i = 1; $i <= 500; $i++) {
  $hreflangUrls = [];
  foreach (LOCALES as $locale => $data) {
    $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}/blog/blog-post-{$i}/";
  }
  $blogEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($blogEntries) {
  $xmlFile = "{$outDir}blog-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($blogEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built blog sitemap: " . count($blogEntries) . " URLs\n";
}

// 10. Resources sitemap
$resourceEntries = [];
for ($i = 1; $i <= 1000; $i++) {
  $hreflangUrls = [];
  foreach (LOCALES as $locale => $data) {
    $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}/resources/resource-{$i}/";
  }
  $resourceEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($resourceEntries) {
  $xmlFile = "{$outDir}resources-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($resourceEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built resources sitemap: " . count($resourceEntries) . " URLs\n";
}

// 11. Core index pages sitemap
$indexPageEntries = [];
$indexPages = [
  '/',
  '/services/',
  '/insights/',
  '/careers/',
  '/industries/',
  '/tools/',
  '/case-studies/',
  '/blog/',
  '/resources/',
  '/catalog/',
  '/api/book/'
];

foreach ($indexPages as $path) {
  $hreflangUrls = [];
  foreach (LOCALES as $locale => $data) {
    if ($path === '/') {
      $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}/";
    } else {
      $hreflangUrls[$locale] = "https://nrlc.ai/{$locale}{$path}";
    }
  }
  $hreflangUrls['x-default'] = $hreflangUrls['en-us'];
  $indexPageEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($indexPageEntries) {
  $xmlFile = "{$outDir}index-pages-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($indexPageEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built index pages sitemap: " . count($indexPageEntries) . " URLs\n";
}

// 12. Semantic infrastructure service pages sitemap
$semanticServiceEntries = [];
$semanticServices = [
  'data-mapping',
  'data-virtualization',
  'rest-api',
  'semantic-layer',
  'enterprise-llm-foundation',
  'knowledge-graph',
  'ontology-modeling'
];

foreach ($semanticServices as $service) {
  $path = "/services/{$service}/";
  $hreflangUrls = sitemap_generate_hreflang_urls($path);
  $semanticServiceEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($semanticServiceEntries) {
  $xmlFile = "{$outDir}semantic-services-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($semanticServiceEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built semantic services sitemap: " . count($semanticServiceEntries) . " URLs\n";
}

// 13. Promptware pages sitemap
$promptwareEntries = [];
$promptwarePages = [
  'promptware/',
  'promptware/json-stream-seo-ai/',
  'promptware/llm-data-to-citation/'
];

foreach ($promptwarePages as $page) {
  $path = "/{$page}";
  $hreflangUrls = sitemap_generate_hreflang_urls($path);
  $promptwareEntries[] = sitemap_entry_with_hreflang($hreflangUrls['en-us'], $hreflangUrls);
}

if ($promptwareEntries) {
  $xmlFile = "{$outDir}promptware-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($promptwareEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built promptware sitemap: " . count($promptwareEntries) . " URLs\n";
}

// Generate unified index
$indexFile = "{$outDir}sitemap-index.xml";
$indexContent = sitemap_render_index($sitemaps);
file_put_contents($indexFile, $indexContent);
sitemap_write_gzipped("{$indexFile}.gz", $indexContent);

// 7. Update robots.txt
$robotsContent = "User-agent: *\nAllow: /\nSitemap: https://nrlc.ai/sitemaps/sitemap-index.xml.gz\n";
file_put_contents(__DIR__ . '/../public/robots.txt', $robotsContent);

echo "Built " . count($sitemaps) . " sitemap shards + unified index\n";
echo "Index URL: https://nrlc.ai/sitemaps/sitemap-index.xml.gz\n";