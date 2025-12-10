<?php
declare(strict_types=1);

/**
 * Generate comprehensive list of all page URLs for Google Schema testing
 */

require_once __DIR__ . '/../lib/helpers.php';

$baseUrl = 'https://nrlc.ai';
$output = [];

// Helper function to add URL
function addUrl(array &$output, string $category, string $url, string $description = '') {
  $output[$category][] = [
    'url' => $url,
    'description' => $description
  ];
}

echo "🔍 Generating comprehensive URL list for schema testing...\n\n";

// 1. INDEX PAGES (High Priority)
echo "📄 Index pages...\n";
$indexPages = [
  '/' => 'Homepage',
  '/services/' => 'Services Index',
  '/products/' => 'Products Index',
  '/insights/' => 'Insights Index',
  '/tools/' => 'Tools Index',
  '/industries/' => 'Industries Index',
  '/careers/' => 'Careers Index',
  '/catalog/' => 'Catalog Index',
  '/blog/' => 'Blog Index',
  '/case-studies/' => 'Case Studies Index',
  '/resources/' => 'Resources Index',
  '/promptware/' => 'Promptware Index'
];

foreach ($indexPages as $path => $desc) {
  addUrl($output, 'Index Pages', $baseUrl . $path, $desc);
}

// 2. PRODUCTS (High Priority - Product Schema)
echo "📦 Products...\n";
$productFiles = glob(__DIR__ . '/../pages/products/*.php');
foreach ($productFiles as $file) {
  $slug = basename($file, '.php');
  if ($slug === 'index') continue;
  addUrl($output, 'Products', $baseUrl . '/products/' . $slug . '/', 'Product: ' . $slug);
}

// 3. SERVICES (High Priority - Service Schema)
echo "🔧 Services (base pages)...\n";
$servicesData = csv_to_rows('services.csv');
foreach ($servicesData as $service) {
  $slug = $service['slug'] ?? '';
  if (empty($slug)) continue;
  addUrl($output, 'Services (Base)', $baseUrl . '/services/' . $slug . '/', 'Service: ' . ($service['name'] ?? $slug));
}

// 4. SERVICE/CITY COMBINATIONS (Sample - High Priority)
echo "🌍 Service/City combinations (sampling)...\n";
$citiesData = csv_to_rows('cities.csv');
$sampleCities = array_slice($citiesData, 0, 5); // Sample first 5 cities
$sampleServices = array_slice($servicesData, 0, 3); // Sample first 3 services

foreach ($sampleServices as $service) {
  $serviceSlug = $service['slug'] ?? '';
  if (empty($serviceSlug)) continue;
  
  foreach ($sampleCities as $city) {
    $citySlug = $city['city_name'] ?? '';
    if (empty($citySlug)) continue;
    addUrl($output, 'Services (City)', $baseUrl . '/services/' . $serviceSlug . '/' . $citySlug . '/', 
      'Service: ' . ($service['name'] ?? $serviceSlug) . ' in ' . ($city['city_name'] ?? $citySlug));
  }
}

// 5. INSIGHTS (High Priority - Article/BlogPosting/ScholarlyArticle Schema)
echo "📚 Insights articles...\n";
$insightFiles = glob(__DIR__ . '/../pages/insights/*.php');
foreach ($insightFiles as $file) {
  $slug = basename($file, '.php');
  if ($slug === 'index' || $slug === 'article') continue;
  addUrl($output, 'Insights', $baseUrl . '/insights/' . $slug . '/', 'Article: ' . $slug);
}

// 6. TOOLS (Medium Priority)
echo "🛠️ Tools...\n";
$toolFiles = glob(__DIR__ . '/../pages/tools/*.php');
foreach ($toolFiles as $file) {
  $slug = basename($file, '.php');
  if ($slug === 'index' || $slug === 'tool') continue;
  addUrl($output, 'Tools', $baseUrl . '/tools/' . $slug . '/', 'Tool: ' . $slug);
}

// 7. INDUSTRIES (Medium Priority)
echo "🏭 Industries...\n";
$industryFiles = glob(__DIR__ . '/../pages/industries/*.php');
foreach ($industryFiles as $file) {
  $slug = basename($file, '.php');
  if ($slug === 'index' || $slug === 'industry') continue;
  addUrl($output, 'Industries', $baseUrl . '/industries/' . $slug . '/', 'Industry: ' . $slug);
}

// 8. CATALOG ITEMS (High Priority - Product/Service Schema)
echo "📋 Catalog items...\n";
$catalogData = csv_to_rows('catalog.csv');
foreach ($catalogData as $item) {
  $slug = $item['slug'] ?? '';
  if (empty($slug)) continue;
  addUrl($output, 'Catalog', $baseUrl . '/catalog/' . $slug . '/', 'Catalog: ' . ($item['name'] ?? $slug));
}

// 9. CAREERS (High Priority - JobPosting Schema)
echo "💼 Careers (sampling)...\n";
$careerRoles = ['seo-specialist', 'schema-engineer', 'llm-strategist', 'technical-writer'];
$sampleCareerCities = array_slice($citiesData, 0, 3); // Sample 3 cities

foreach ($sampleCareerCities as $city) {
  $citySlug = $city['city_name'] ?? '';
  if (empty($citySlug)) continue;
  
  foreach ($careerRoles as $role) {
    addUrl($output, 'Careers', $baseUrl . '/careers/' . $citySlug . '/' . $role . '/', 
      'Job: ' . $role . ' in ' . $citySlug);
  }
}

// 10. BLOG POSTS (Sample - Medium Priority)
echo "📝 Blog posts (sampling)...\n";
$blogFiles = glob(__DIR__ . '/../pages/blog/blog-post-*.php');
$sampleBlogs = array_slice($blogFiles, 0, 10); // Sample first 10
foreach ($sampleBlogs as $file) {
  preg_match('/blog-post-(\d+)\.php$/', basename($file), $matches);
  if (isset($matches[1])) {
    addUrl($output, 'Blog Posts', $baseUrl . '/blog/blog-post-' . $matches[1] . '/', 'Blog Post #' . $matches[1]);
  }
}

// 11. CASE STUDIES (Sample - Medium Priority)
echo "📊 Case studies (sampling)...\n";
$caseFiles = glob(__DIR__ . '/../pages/case-studies/case-study-*.php');
$sampleCases = array_slice($caseFiles, 0, 5); // Sample first 5
foreach ($sampleCases as $file) {
  preg_match('/case-study-(\d+)\.php$/', basename($file), $matches);
  if (isset($matches[1])) {
    addUrl($output, 'Case Studies', $baseUrl . '/case-studies/case-study-' . $matches[1] . '/', 'Case Study #' . $matches[1]);
  }
}

// 12. RESOURCES (Sample - Low Priority)
echo "📚 Resources (sampling)...\n";
$resourceFiles = glob(__DIR__ . '/../pages/resources/resource-*.php');
$sampleResources = array_slice($resourceFiles, 0, 5); // Sample first 5
foreach ($sampleResources as $file) {
  preg_match('/resource-(\d+)\.php$/', basename($file), $matches);
  if (isset($matches[1])) {
    addUrl($output, 'Resources', $baseUrl . '/resources/resource-' . $matches[1] . '/', 'Resource #' . $matches[1]);
  }
}

// Output results
echo "\n✅ URL list generated!\n\n";

// Print summary
$total = 0;
foreach ($output as $category => $urls) {
  $count = count($urls);
  $total += $count;
  echo "  {$category}: {$count} URLs\n";
}
echo "\n  TOTAL: {$total} URLs\n\n";

// Generate formatted output
echo "=" . str_repeat("=", 80) . "\n";
echo "GOOGLE SCHEMA TEST URLS\n";
echo "=" . str_repeat("=", 80) . "\n\n";

foreach ($output as $category => $urls) {
  echo "\n## {$category} (" . count($urls) . " URLs)\n\n";
  foreach ($urls as $item) {
    echo $item['url'];
    if (!empty($item['description'])) {
      echo " - " . $item['description'];
    }
    echo "\n";
  }
}

// Also save to file
$filePath = __DIR__ . '/../schema_test_urls.txt';
$fileContent = "GOOGLE SCHEMA TEST URLS\n";
$fileContent .= "Generated: " . date('Y-m-d H:i:s') . "\n";
$fileContent .= str_repeat("=", 80) . "\n\n";

foreach ($output as $category => $urls) {
  $fileContent .= "\n## {$category} (" . count($urls) . " URLs)\n\n";
  foreach ($urls as $item) {
    $fileContent .= $item['url'];
    if (!empty($item['description'])) {
      $fileContent .= " - " . $item['description'];
    }
    $fileContent .= "\n";
  }
}

file_put_contents($filePath, $fileContent);
echo "\n\n✅ Saved to: schema_test_urls.txt\n";



