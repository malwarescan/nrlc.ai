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
$careersRows = csv_read_data('career_matrix.csv');
$insightsRows = csv_read_data('insights.csv');
$imagesMap = csv_read_data('images_map.csv');

// Get all service types (from service map in meta_directive.php)
$allServices = [
  'llm-optimization',
  'semantic-seo-ai',
  'voice-search-optimization',
  'chatgpt-optimization',
  'conversion-optimization-ai',
  'verification-optimization-ai',
  'multimodal-seo-ai',
  'generative-seo',
  'freshness-optimization-ai',
  'completeness-optimization-ai',
  'metadata-optimization-ai',
  'local-seo-ai',
  'technical-seo',
  'link-building-ai',
  'site-audits',
  'analytics',
  'perplexity-optimization',
  'ai-overviews-optimization',
  'entity-optimization-ai',
  'international-seo',
  'mobile-seo-ai',
  'bard-optimization',
  'conversational-seo-ai',
  'ai-search-optimization',
  'llm-seeding',
  'agentic-seo',
  'ecommerce-ai-seo',
  'b2b-seo-ai',
  'content-optimization-ai',
  'technical-audit-ai',
  'competitor-analysis-ai',
  'crawl-clarity',
  'json-ld-strategy',
  'training',
  // Additional services found in Pages.csv
  'ranking-optimization-ai',
  'trust-optimization-ai',
  'structured-data-ai',
  'relevance-optimization-ai',
  'llm-content-strategy',
  'explainability-optimization-ai',
  'copilot-optimization',
  'contextual-seo-ai',
  'claude-optimization',
  'ai-citation-optimization',
  'transparency-optimization-ai',
  'intent-optimization-ai',
  'featured-snippets-ai',
  'accuracy-optimization-ai',
  'entity-recognition-ai',
  'knowledge-graph-ai',
  'knowledge-graph', // Alternative slug format
  'retrieval-optimization-ai',
  'schema-markup-ai',
  'topic-modeling-ai',
  'personalization-ai',
  'recommendation-ai',
  'authority-optimization-ai'
];

// Get all cities
$citiesData = csv_read_data('cities.csv');
$allCities = [];
foreach ($citiesData as $row) {
  $citySlug = $row['city_name'] ?? '';
  if ($citySlug) {
    $allCities[] = $citySlug;
  }
}

$sitemaps = [];

// 1. Services sitemap - Generate ALL service+city combinations + service overview pages
$serviceEntries = [];
require_once __DIR__ . '/../lib/helpers.php';

// Add service overview pages (e.g., /services/site-audits/)
foreach ($allServices as $service) {
  $overviewPath = "/services/{$service}/";
  $overviewHreflangUrls = sitemap_generate_hreflang_urls($overviewPath);
  $overviewCanonicalUrl = $overviewHreflangUrls['x-default'] ?? $overviewHreflangUrls['en-us'] ?? '';
  if ($overviewCanonicalUrl) {
    $serviceEntries[] = sitemap_entry_simple($overviewCanonicalUrl, $today, 'weekly', '0.9');
  }
  
  // Load city locale rules (authoritative source)
  $cityLocaleRulesFile = __DIR__ . '/../data/city_locale_rules.json';
  $cityLocaleRules = [];
  if (file_exists($cityLocaleRulesFile)) {
    $cityLocaleRules = json_decode(file_get_contents($cityLocaleRulesFile), true) ?? [];
  }
  
  // Add service+city combinations
  foreach ($allCities as $city) {
    // Determine canonical locale from city locale rules (authoritative)
    $canonicalLocale = 'en-us'; // Default
    if (isset($cityLocaleRules[$city])) {
      $canonicalLocale = $cityLocaleRules[$city]['canonical_locale'] ?? 'en-us';
    } else {
      // Fallback to is_uk_city if rules not available
      $isUK = function_exists('is_uk_city') ? is_uk_city($city) : false;
      $canonicalLocale = $isUK ? 'en-gb' : 'en-us';
    }
    
    $canonicalUrl = "https://nrlc.ai/{$canonicalLocale}/services/{$service}/{$city}/";
    $serviceEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'weekly', '0.8');
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
  
  // Extract canonical URLs from XML entries for registry generation
  $canonicalUrlsFile = __DIR__ . '/../data/canonical_urls_from_sitemap.json';
  $canonicalUrls = [];
  foreach ($serviceEntries as $entry) {
    // Extract URL from XML entry string
    if (preg_match('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $entry, $matches)) {
      $canonicalUrls[] = $matches[1];
    }
  }
  if (!is_dir(dirname($canonicalUrlsFile))) {
    mkdir(dirname($canonicalUrlsFile), 0755, true);
  }
  file_put_contents($canonicalUrlsFile, json_encode($canonicalUrls, JSON_PRETTY_PRINT));
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
    
    // SITEMAP CANONICAL ONLY: Use the canonical locale URL
    $canonicalUrl = $hreflangUrls['x-default'] ?? $hreflangUrls['en-us'] ?? $hreflangUrls['en-gb'] ?? '';
    if ($canonicalUrl) {
      $careerEntries[] = sitemap_entry_simple($canonicalUrl, $lastmod, 'monthly', '0.7');
    }
  }
}

// Add LLM Strategist hub (en-gb canonical only, high priority)
$llmHubUrl = "https://nrlc.ai/en-gb/careers/norwich/llm-strategist/";
$careerEntries[] = sitemap_entry_simple($llmHubUrl, $today, 'weekly', '0.9');

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
    // SITEMAP CANONICAL ONLY
    $canonicalUrl = $hreflangUrls['x-default'] ?? $hreflangUrls['en-us'] ?? '';
    if ($canonicalUrl) {
      $insightEntries[] = sitemap_entry_simple($canonicalUrl, $lastmod, 'monthly', '0.8');
    }
  }
}

// Add LLM Strategist cluster pages (en-gb canonical only)
$llmClusterPages = [
  ['slug' => 'glossary/llm-strategist', 'priority' => '0.9'],
  ['slug' => 'llm-strategist-vs-seo-strategist', 'priority' => '0.9'],
  ['slug' => 'ai-search-roles', 'priority' => '0.8'],
  ['slug' => 'llm-search-strategy-framework', 'priority' => '0.8'],
  ['slug' => 'how-llm-strategists-influence-retrieval', 'priority' => '0.8'],
  ['slug' => 'llm-strategist-faq', 'priority' => '0.8'],
  ['slug' => 'how-to-become-an-llm-strategist', 'priority' => '0.7']
];

foreach ($llmClusterPages as $page) {
  $slug = $page['slug'];
  $path = "/insights/{$slug}/";
  // These are en-gb canonical only
  $canonicalUrl = "https://nrlc.ai/en-gb{$path}";
  $insightEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'monthly', $page['priority']);
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
      // SITEMAP CANONICAL ONLY
      $canonicalUrl = $hreflangUrls['x-default'] ?? $hreflangUrls['en-us'] ?? '';
      $entry = "  <url>\n    <loc>{$canonicalUrl}</loc>\n";
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
  'canonical-sentinel',  // Canonical Sentinel - Free SEO tool (high priority)
  'chatgpt', 'claude', 'perplexity', 'bard', 'copilot', 'google-ai-overviews',
  'schema-generator', 'json-ld-validator', 'structured-data-testing',
  'screaming-frog', 'sitebulb', 'ahrefs', 'semrush', 'moz', 'brightedge', 'seer-interactive'
];

foreach ($toolPages as $tool) {
  // SITEMAP CANONICAL ONLY
  // Canonical Sentinel gets higher priority (0.9) as it's a free tool we want to promote
  $priority = ($tool === 'canonical-sentinel') ? '0.9' : '0.7';
  $changefreq = ($tool === 'canonical-sentinel') ? 'weekly' : 'monthly';
  $canonicalUrl = "https://nrlc.ai/en-us/tools/{$tool}/";
  $toolEntries[] = sitemap_entry_simple($canonicalUrl, $today, $changefreq, $priority);
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
// CANONICAL: Use slug-based URLs (SEO-friendly, semantic, ontology-aligned)
$caseStudySlugs = [
  25 => 'b2b-saas',
  26 => 'ecommerce',
  27 => 'healthcare',
  28 => 'fintech',
  29 => 'education',
  30 => 'real-estate'
];

$caseStudyEntries = [];
foreach ($caseStudySlugs as $id => $slug) {
  // SITEMAP CANONICAL ONLY - Use semantic slug-based URLs
  $canonicalUrl = "https://nrlc.ai/en-us/case-studies/{$slug}/";
  $caseStudyEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'monthly', '0.7');
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
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us/blog/blog-post-{$i}/";
  $blogEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'weekly', '0.8');
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
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us/resources/resource-{$i}/";
  $resourceEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'monthly', '0.6');
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
  '/videos/',  // Video guides hub
  '/case-studies/',
  '/blog/',
  '/resources/',
  '/catalog/',
  '/ai-visibility/',  // AI Visibility main hub page
  '/ai-visibility-dictionary/',  // AI Visibility Dictionary (DefinedTermSet)
  '/training/ai-search-systems/',  // Training page
];

foreach ($indexPages as $path) {
  // SITEMAP CANONICAL ONLY: Only include en-us canonical
  $canonicalUrl = $path === '/' 
    ? "https://nrlc.ai/en-us/" 
    : "https://nrlc.ai/en-us{$path}";
  $indexPageEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'weekly', '1.0');
}

// Add en-gb careers index (canonical for UK)
$indexPageEntries[] = sitemap_entry_simple('https://nrlc.ai/en-gb/careers/', $today, 'weekly', '0.9');

// Add LLM Strategy Team about page (en-gb canonical only)
$indexPageEntries[] = sitemap_entry_simple('https://nrlc.ai/en-gb/about/llm-strategy-team/', $today, 'monthly', '0.7');

if ($indexPageEntries) {
  $xmlFile = "{$outDir}index-pages-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($indexPageEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built index pages sitemap: " . count($indexPageEntries) . " URLs\n";
}

// 12a. Learn & Course pages sitemap (Beginner Education Hub)
$learnEntries = [];
$learnPages = [
  '/learn/',  // Hub page
  '/learn/can-ai-do-seo/',
  '/learn/types-of-seo/',
  '/learn/seo-80-20-rule/',
  // Future learn pages will be added here:
  // '/learn/chatgpt-seo/',
  // '/learn/ai-30-percent-rule/',
];

// Add Answer First Architecture page (research methodology)
$learnPages[] = '/answer-first-architecture/';

foreach ($learnPages as $path) {
  // SITEMAP CANONICAL ONLY: Only include en-us canonical (learn pages are en-us for now)
  $canonicalUrl = "https://nrlc.ai/en-us{$path}";
  
  // Check if page file exists to get actual lastmod
  $pageFile = __DIR__ . '/../pages' . str_replace('/', '', $path) . '.php';
  if (!file_exists($pageFile)) {
    // Try index.php for hub pages
    $pageFile = __DIR__ . '/../pages' . rtrim($path, '/') . '/index.php';
  }
  
  $lastmod = file_exists($pageFile) ? date('Y-m-d', filemtime($pageFile)) : $today;
  $priority = ($path === '/learn/' || $path === '/answer-first-architecture/') ? '0.9' : '0.8';
  
  $learnEntries[] = sitemap_entry_simple($canonicalUrl, $lastmod, 'weekly', $priority);
}

if ($learnEntries) {
  $xmlFile = "{$outDir}learn-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($learnEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built learn sitemap: " . count($learnEntries) . " URLs\n";
}

// 12b. Semantic infrastructure service pages sitemap
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
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us/services/{$service}/";
  $semanticServiceEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'weekly', '0.8');
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
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us/{$page}";
  $promptwareEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'monthly', '0.7');
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

// 14. Products sitemap
$productEntries = [];
// Add products index page
$productEntries[] = sitemap_entry_simple("https://nrlc.ai/en-us/products/", $today, 'weekly', '0.9');
// Add individual product pages
$productFiles = glob(__DIR__.'/../pages/products/*.php');
foreach ($productFiles as $file) {
  $slug = basename($file, '.php');
  if ($slug === 'index') continue;
  
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us/products/{$slug}/";
  $productEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'monthly', '0.8');
}

if ($productEntries) {
  $xmlFile = "{$outDir}products-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($productEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built products sitemap: " . count($productEntries) . " URLs\n";
}

// 15. Catalog sitemap
$catalogEntries = [];
require_once __DIR__.'/../lib/csv.php';
$catalogData = csv_read_data('catalog.csv');
foreach ($catalogData as $item) {
  $slug = $item['slug'] ?? '';
  if (empty($slug)) continue;
  
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us/catalog/{$slug}/";
  $catalogEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'weekly', '0.8');
}

if ($catalogEntries) {
  $xmlFile = "{$outDir}catalog-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($catalogEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built catalog sitemap: " . count($catalogEntries) . " URLs\n";
}

// 16. Prechunking SEO Documentation sitemap
$docsEntries = [];
$docsPages = [
  '/docs/prechunking-seo/',
  '/docs/prechunking-seo/core-concepts/',
  '/docs/prechunking-seo/croutons/',
  '/docs/prechunking-seo/precogs/',
  '/docs/prechunking-seo/workflow/',
  '/docs/prechunking-seo/failure-modes/',
  '/docs/prechunking-seo/measurement/',
  '/docs/prechunking-seo/doctrine/',
  '/docs/prechunking-seo/academic-signals/',
  '/docs/prechunking-seo/course/',
  '/docs/prechunking-seo/course/how-llms-chunk-content/',
  '/docs/prechunking-seo/course/chunk-atomicity-inference-cost/',
  '/docs/prechunking-seo/course/vectorization-semantic-collisions/',
  '/docs/prechunking-seo/course/data-structuring-beyond-pages/',
  '/docs/prechunking-seo/course/cross-page-consistency/',
  '/docs/prechunking-seo/course/prompt-reverse-engineering/',
  '/docs/prechunking-seo/course/citation-eligibility-engineering/',
  '/docs/prechunking-seo/course/measuring-prechunking-success/',
  '/docs/prechunking-seo/course/failure-modes-why-chunks-die/'
];

foreach ($docsPages as $page) {
  // SITEMAP CANONICAL ONLY
  $canonicalUrl = "https://nrlc.ai/en-us{$page}";
  $docsEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'monthly', '0.8');
}

if ($docsEntries) {
  $xmlFile = "{$outDir}docs-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($docsEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built docs sitemap: " . count($docsEntries) . " URLs\n";
}

// 17. AI Visibility pages sitemap
$aiVisibilityEntries = [];
$aiVisibilityIndustries = require __DIR__.'/../lib/ai_visibility_industries.php';

// Add main AI Visibility hub page
$aiVisibilityEntries[] = sitemap_entry_simple("https://nrlc.ai/en-us/ai-visibility/", $today, 'weekly', '0.9');

// Tier 1 Geo Reinforcement: Add Norwich page
$aiVisibilityEntries[] = sitemap_entry_simple("https://nrlc.ai/en-gb/services/ai-seo-norwich/", $today, 'weekly', '0.8');

// Add all industry-specific AI Visibility pages
foreach ($aiVisibilityIndustries as $industrySlug => $industryData) {
  $path = "/ai-visibility/{$industrySlug}/";
  $hreflangUrls = sitemap_generate_hreflang_urls($path);
  
  // SITEMAP CANONICAL ONLY: Use the canonical locale URL
  $canonicalUrl = $hreflangUrls['x-default'] ?? $hreflangUrls['en-us'] ?? '';
  if ($canonicalUrl) {
    $aiVisibilityEntries[] = sitemap_entry_simple($canonicalUrl, $today, 'weekly', '0.8');
  }
  
  // Add audit example page for each industry (if exists)
  $auditExamplePath = "/ai-visibility/audit-example/{$industrySlug}/";
  $auditHreflangUrls = sitemap_generate_hreflang_urls($auditExamplePath);
  $auditCanonicalUrl = $auditHreflangUrls['x-default'] ?? $auditHreflangUrls['en-us'] ?? '';
  if ($auditCanonicalUrl) {
    // Check if audit example page exists (at minimum, immigration exists)
    // For now, include all - router will handle 404s if page doesn't exist
    $aiVisibilityEntries[] = sitemap_entry_simple($auditCanonicalUrl, $today, 'monthly', '0.7');
  }
}

if ($aiVisibilityEntries) {
  $xmlFile = "{$outDir}ai-visibility-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_urlset($aiVisibilityEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built AI Visibility sitemap: " . count($aiVisibilityEntries) . " URLs\n";
}

// 18. Video watch pages sitemap (Google video discovery: video:video entries)
$videoEntries = [];
require_once __DIR__ . '/../lib/videos.php';
foreach (get_all_videos() as $video) {
  $watchPageLoc = 'https://nrlc.ai/en-us/videos/' . ($video['slug'] ?? '') . '/';
  $videoEntries[] = sitemap_entry_video($watchPageLoc, $video);
}
if ($videoEntries) {
  $xmlFile = "{$outDir}videos-1.xml";
  $gzFile = "{$xmlFile}.gz";
  $content = sitemap_render_videos($videoEntries);
  file_put_contents($xmlFile, $content);
  sitemap_write_gzipped($gzFile, $content);
  $sitemaps[] = ['loc' => "https://nrlc.ai/sitemaps/" . basename($gzFile), 'lastmod' => $today];
  echo "Built video sitemap: " . count($videoEntries) . " URLs\n";
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