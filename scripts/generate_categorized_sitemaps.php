<?php
declare(strict_types=1);

/**
 * Comprehensive Categorized Sitemap Generator
 * SEO-first XML sitemaps following Google's sitemap protocol
 * 
 * Categories:
 * - Products
 * - Services (base + service/city)
 * - Insights
 * - Tools
 * - Industries
 * - Careers (career/city)
 * - Blog posts
 * - Case studies
 * - Resources
 * - Catalog items
 * - Index pages
 */

require_once __DIR__ . '/../lib/helpers.php';

$baseUrl = 'https://nrlc.ai';
$sitemapDir = __DIR__ . '/../public/sitemaps/';
$today = date('Y-m-d');

// Ensure sitemap directory exists
if (!is_dir($sitemapDir)) {
  mkdir($sitemapDir, 0755, true);
}

// Max URLs per sitemap (Google limit: 50,000)
const MAX_URLS_PER_SITEMAP = 50000;
// Max file size (Google limit: 10MB uncompressed)
const MAX_FILE_SIZE = 10 * 1024 * 1024;

/**
 * Generate XML sitemap content
 */
function generate_sitemap_xml(array $urls): string {
  $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
  
  foreach ($urls as $url) {
    if (empty($url['loc'])) continue; // Skip URLs without location
    
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars((string)$url['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
    
    if (!empty($url['lastmod'])) {
      $xml .= "    <lastmod>" . htmlspecialchars((string)$url['lastmod'], ENT_XML1, 'UTF-8') . "</lastmod>\n";
    }
    
    if (!empty($url['changefreq'])) {
      $xml .= "    <changefreq>" . htmlspecialchars((string)$url['changefreq'], ENT_XML1, 'UTF-8') . "</changefreq>\n";
    }
    
    if (!empty($url['priority'])) {
      $xml .= "    <priority>" . htmlspecialchars((string)$url['priority'], ENT_XML1, 'UTF-8') . "</priority>\n";
    }
    
    $xml .= "  </url>\n";
  }
  
  $xml .= '</urlset>';
  return $xml;
}

/**
 * Write sitemap to file (with sharding if needed)
 */
function write_sitemap(string $category, array $urls, string $sitemapDir, string $baseUrl): array {
  $sitemapFiles = [];
  
  // If URLs exceed limit, split into multiple files
  if (count($urls) > MAX_URLS_PER_SITEMAP) {
    $chunks = array_chunk($urls, MAX_URLS_PER_SITEMAP);
    foreach ($chunks as $index => $chunk) {
      $filename = "{$category}-" . ($index + 1) . ".xml";
      $filepath = $sitemapDir . $filename;
      $xml = generate_sitemap_xml($chunk);
      file_put_contents($filepath, $xml);
      $sitemapFiles[] = [
        'loc' => $baseUrl . '/sitemaps/' . $filename,
        'lastmod' => date('Y-m-d')
      ];
    }
  } else {
    $filename = "{$category}-1.xml";
    $filepath = $sitemapDir . $filename;
    $xml = generate_sitemap_xml($urls);
    file_put_contents($filepath, $xml);
    $sitemapFiles[] = [
      'loc' => $baseUrl . '/sitemaps/' . $filename,
      'lastmod' => date('Y-m-d')
    ];
  }
  
  return $sitemapFiles;
}

/**
 * Get all products
 */
function get_products(): array {
  $products = [];
  $productFiles = glob(__DIR__ . '/../pages/products/*.php');
  
  foreach ($productFiles as $file) {
    $slug = basename($file, '.php');
    if ($slug === 'index') continue;
    
    $products[] = [
      'loc' => "https://nrlc.ai/en-us/products/{$slug}/",
      'lastmod' => date('Y-m-d', filemtime($file)),
      'changefreq' => 'monthly',
      'priority' => '0.8'
    ];
  }
  
  return $products;
}

/**
 * Get all services (base + service/city combinations)
 */
function get_services(): array {
  $services = [];
  
  // Base service pages
  $serviceFiles = glob(__DIR__ . '/../pages/services/*.php');
  foreach ($serviceFiles as $file) {
    $slug = basename($file, '.php');
    if ($slug === 'index' || $slug === 'service' || $slug === 'service_city') continue;
  }
  
  // Read services from CSV
  $servicesData = csv_to_rows('services.csv');
  foreach ($servicesData as $service) {
    $slug = $service['slug'] ?? '';
    if (empty($slug)) continue;
    
    // Base service page
    $services[] = [
      'loc' => "https://nrlc.ai/services/{$slug}/",
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.9'
    ];
    
    // Service/city combinations
    $citiesData = csv_to_rows('cities.csv');
    foreach ($citiesData as $city) {
      $citySlug = $city['city_name'] ?? '';
      if (empty($citySlug)) continue;
      
      $services[] = [
        'loc' => "https://nrlc.ai/services/{$slug}/{$citySlug}/",
        'lastmod' => date('Y-m-d'),
        'changefreq' => 'weekly',
        'priority' => '0.8'
      ];
    }
  }
  
  return $services;
}

/**
 * Get all insights articles
 */
function get_insights(): array {
  $insights = [];
  $insightFiles = glob(__DIR__ . '/../pages/insights/*.php');
  
  foreach ($insightFiles as $file) {
    $slug = basename($file, '.php');
    if ($slug === 'index' || $slug === 'article') continue;
    
    $insights[] = [
      'loc' => "https://nrlc.ai/insights/{$slug}/",
      'lastmod' => date('Y-m-d', filemtime($file)),
      'changefreq' => 'monthly',
      'priority' => '0.7'
    ];
  }
  
  return $insights;
}

/**
 * Get all tools
 */
function get_tools(): array {
  $tools = [];
  $toolFiles = glob(__DIR__ . '/../pages/tools/*.php');
  
  foreach ($toolFiles as $file) {
    $slug = basename($file, '.php');
    if ($slug === 'index' || $slug === 'tool') continue;
    
    $tools[] = [
      'loc' => "https://nrlc.ai/tools/{$slug}/",
      'lastmod' => date('Y-m-d', filemtime($file)),
      'changefreq' => 'monthly',
      'priority' => '0.6'
    ];
  }
  
  return $tools;
}

/**
 * Get all industries
 */
function get_industries(): array {
  $industries = [];
  $industryFiles = glob(__DIR__ . '/../pages/industries/*.php');
  
  foreach ($industryFiles as $file) {
    $slug = basename($file, '.php');
    if ($slug === 'index' || $slug === 'industry') continue;
    
    $industries[] = [
      'loc' => "https://nrlc.ai/industries/{$slug}/",
      'lastmod' => date('Y-m-d', filemtime($file)),
      'changefreq' => 'monthly',
      'priority' => '0.7'
    ];
  }
  
  return $industries;
}

/**
 * Get all careers (career/city combinations)
 */
function get_careers(): array {
  $careers = [];
  
  // Read career data if available
  $careerFile = __DIR__ . '/../config/careers.php';
  if (file_exists($careerFile)) {
    include $careerFile;
    $careerRoles = $careers ?? [];
  } else {
    // Default career roles
    $careerRoles = ['seo-specialist', 'schema-engineer', 'llm-strategist', 'technical-writer'];
  }
  
  $citiesData = csv_to_rows('cities.csv');
  
  foreach ($careerRoles as $role) {
    foreach ($citiesData as $city) {
      $citySlug = $city['city_name'] ?? '';
      if (empty($citySlug)) continue;
      
      $careers[] = [
        'loc' => "https://nrlc.ai/careers/{$citySlug}/{$role}/",
        'lastmod' => date('Y-m-d'),
        'changefreq' => 'weekly',
        'priority' => '0.7'
      ];
    }
  }
  
  return $careers;
}

/**
 * Get all blog posts
 */
function get_blog_posts(): array {
  $blogPosts = [];
  $blogFiles = glob(__DIR__ . '/../pages/blog/blog-post-*.php');
  
  foreach ($blogFiles as $file) {
    preg_match('/blog-post-(\d+)\.php$/', basename($file), $matches);
    if (isset($matches[1])) {
      $postNum = $matches[1];
      $blogPosts[] = [
        'loc' => "https://nrlc.ai/blog/blog-post-{$postNum}/",
        'lastmod' => date('Y-m-d', filemtime($file)),
        'changefreq' => 'monthly',
        'priority' => '0.6'
      ];
    }
  }
  
  return $blogPosts;
}

/**
 * Get all case studies
 */
function get_case_studies(): array {
  $caseStudies = [];
  $caseFiles = glob(__DIR__ . '/../pages/case-studies/case-study-*.php');
  
  foreach ($caseFiles as $file) {
    preg_match('/case-study-(\d+)\.php$/', basename($file), $matches);
    if (isset($matches[1])) {
      $caseNum = $matches[1];
      $caseStudies[] = [
        'loc' => "https://nrlc.ai/case-studies/case-study-{$caseNum}/",
        'lastmod' => date('Y-m-d', filemtime($file)),
        'changefreq' => 'monthly',
        'priority' => '0.7'
      ];
    }
  }
  
  return $caseStudies;
}

/**
 * Get all resources
 */
if (!function_exists('get_resources')) {
function get_resources(): array {
  $resources = [];
  $resourceFiles = glob(__DIR__ . '/../pages/resources/resource-*.php');
  
  foreach ($resourceFiles as $file) {
    preg_match('/resource-(\d+)\.php$/', basename($file), $matches);
    if (isset($matches[1])) {
      $resourceNum = $matches[1];
      $resources[] = [
        'loc' => "https://nrlc.ai/resources/resource-{$resourceNum}/",
        'lastmod' => date('Y-m-d', filemtime($file)),
        'changefreq' => 'monthly',
        'priority' => '0.5'
      ];
    }
  }
  
  return $resources;
}
}

/**
 * Get all catalog items
 */
function get_catalog_items(): array {
  $catalogItems = [];
  
  $catalogData = csv_to_rows('catalog.csv');
  foreach ($catalogData as $item) {
    $slug = $item['slug'] ?? '';
    if (empty($slug)) continue;
    
    $catalogItems[] = [
      'loc' => "https://nrlc.ai/en-us/catalog/{$slug}/",
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.8'
    ];
  }
  
  return $catalogItems;
}

/**
 * Get index pages
 */
function get_index_pages(): array {
  return [
    [
      'loc' => 'https://nrlc.ai/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'daily',
      'priority' => '1.0'
    ],
    [
      'loc' => 'https://nrlc.ai/services/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.9'
    ],
    [
      'loc' => 'https://nrlc.ai/products/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.9'
    ],
    [
      'loc' => 'https://nrlc.ai/insights/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.9'
    ],
    [
      'loc' => 'https://nrlc.ai/tools/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'monthly',
      'priority' => '0.8'
    ],
    [
      'loc' => 'https://nrlc.ai/industries/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'monthly',
      'priority' => '0.8'
    ],
    [
      'loc' => 'https://nrlc.ai/careers/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.8'
    ],
    [
      'loc' => 'https://nrlc.ai/catalog/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.8'
    ],
    [
      'loc' => 'https://nrlc.ai/blog/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'daily',
      'priority' => '0.8'
    ],
    [
      'loc' => 'https://nrlc.ai/case-studies/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.7'
    ],
    [
      'loc' => 'https://nrlc.ai/resources/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'weekly',
      'priority' => '0.7'
    ],
    [
      'loc' => 'https://nrlc.ai/promptware/',
      'lastmod' => date('Y-m-d'),
      'changefreq' => 'monthly',
      'priority' => '0.7'
    ]
  ];
}

/**
 * Generate sitemap index
 */
function generate_sitemap_index(array $sitemapFiles, string $sitemapDir, string $baseUrl): void {
  $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
  
  foreach ($sitemapFiles as $sitemap) {
    $xml .= "  <sitemap>\n";
    $xml .= "    <loc>" . htmlspecialchars($sitemap['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
    $xml .= "    <lastmod>" . htmlspecialchars($sitemap['lastmod'], ENT_XML1, 'UTF-8') . "</lastmod>\n";
    $xml .= "  </sitemap>\n";
  }
  
  $xml .= '</sitemapindex>';
  
  file_put_contents($sitemapDir . 'sitemap-index.xml', $xml);
}

// Main execution
echo "🚀 Generating categorized sitemaps...\n\n";

$allSitemapFiles = [];

// Generate each category sitemap
$categories = [
  'products' => get_products(),
  'services' => get_services(),
  'insights' => get_insights(),
  'tools' => get_tools(),
  'industries' => get_industries(),
  'careers' => get_careers(),
  'blog' => get_blog_posts(),
  'case-studies' => get_case_studies(),
  'resources' => get_resources(),
  'catalog' => get_catalog_items(),
  'index-pages' => get_index_pages()
];

foreach ($categories as $category => $urls) {
  echo "📄 Generating {$category} sitemap (" . count($urls) . " URLs)...\n";
  $sitemapFiles = write_sitemap($category, $urls, $sitemapDir, $baseUrl);
  $allSitemapFiles = array_merge($allSitemapFiles, $sitemapFiles);
}

// Generate sitemap index
echo "\n📑 Generating sitemap index...\n";
generate_sitemap_index($allSitemapFiles, $sitemapDir, $baseUrl);

echo "\n✅ Sitemap generation complete!\n";
echo "   Total sitemap files: " . count($allSitemapFiles) . "\n";
echo "   Sitemap index: {$baseUrl}/sitemaps/sitemap-index.xml\n\n";

