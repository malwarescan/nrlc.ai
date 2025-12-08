<?php
/**
 * SECTION B: Enhance All Service URLs Using Keyword Universe
 * 
 * For every URL in Pages.csv that contains "/services/":
 * - Fix canonical
 * - Generate meta title (55-60 chars) with priority 1-2 keywords
 * - Generate meta description (120-155 chars)
 * - Create intro text with H1 + paragraph
 * - Inject Service JSON-LD
 * - Add internal linking
 * - Align content with top 3 keywords
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/service_enhancements.php';

// Load keyword intelligence
$keywordFile = __DIR__.'/../data/keyword_intelligence.csv';
$keywords = csv_read($keywordFile);

// Load Pages.csv
$pagesFile = __DIR__.'/../serp_intel/Pages.csv';
$pages = csv_read($pagesFile);

// Extract service URLs
$serviceUrls = [];
foreach ($pages as $row) {
  $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
  if (strpos($url, '/services/') !== false) {
    // Normalize URL
    $normalizedUrl = preg_replace('#^http://#', 'https://', $url);
    if (substr($normalizedUrl, -1) !== '/') {
      $normalizedUrl .= '/';
    }
    
    // Parse structure
    if (preg_match('#https?://nrlc\.ai(?:/([a-z]{2}-[a-z]{2}))?/services/([^/]+)(?:/([^/]+))?/#', $normalizedUrl, $matches)) {
      $locale = $matches[1] ?? '';
      $service = $matches[2] ?? '';
      $city = $matches[3] ?? '';
      
      $serviceUrls[] = [
        'url' => $normalizedUrl,
        'locale' => $locale,
        'service' => $service,
        'city' => $city,
        'has_city' => !empty($city),
        'path' => parse_url($normalizedUrl, PHP_URL_PATH)
      ];
    }
  }
}

// Remove duplicates
$uniqueServices = [];
$seen = [];
foreach ($serviceUrls as $item) {
  $key = $item['path'];
  if (!isset($seen[$key])) {
    $seen[$key] = true;
    $uniqueServices[] = $item;
  }
}

echo "Processing " . count($uniqueServices) . " unique service URLs...\n\n";

/**
 * Get top keywords for a service mapping
 */
function get_top_keywords_for_service(string $serviceMapping, int $limit = 3): array {
  global $keywords;
  
  $serviceKeywords = array_filter($keywords, function($kw) use ($serviceMapping) {
    return ($kw['service_mapping'] ?? '') === $serviceMapping && 
           in_array($kw['priority'] ?? 4, [1, 2]);
  });
  
  // Sort by priority, then impressions
  usort($serviceKeywords, function($a, $b) {
    if ($a['priority'] !== $b['priority']) {
      return $a['priority'] <=> $b['priority'];
    }
    return ($b['impressions'] ?? 0) <=> ($a['impressions'] ?? 0);
  });
  
  return array_slice($serviceKeywords, 0, $limit);
}

/**
 * Generate meta title (55-60 chars)
 */
function generate_meta_title(string $serviceSlug, string $citySlug, string $locale, array $topKeywords): string {
  $serviceName = get_service_name_from_slug($serviceSlug);
  
  if (!empty($citySlug)) {
    $cityName = ucwords(str_replace('-', ' ', $citySlug));
    $primaryKeyword = $topKeywords[0]['keyword'] ?? 'AI SEO';
    
    // Try: "[Service] [City] | [Keyword]"
    $title = "$serviceName $cityName | $primaryKeyword";
    if (strlen($title) > 60) {
      // Shorten service name if needed
      $shortService = substr($serviceName, 0, 25);
      $title = "$shortService $cityName | $primaryKeyword";
    }
    if (strlen($title) > 60) {
      $title = "$serviceName $cityName";
    }
  } else {
    $primaryKeyword = $topKeywords[0]['keyword'] ?? 'AI SEO';
    $title = "$serviceName Services | $primaryKeyword";
    if (strlen($title) > 60) {
      $title = "$serviceName | $primaryKeyword";
    }
  }
  
  return $title;
}

/**
 * Generate meta description (120-155 chars)
 */
function generate_meta_description(string $serviceSlug, string $citySlug, array $topKeywords): string {
  $serviceName = get_service_name_from_slug($serviceSlug);
  $clusterKeywords = array_column($topKeywords, 'keyword');
  $keywordPhrase = implode(', ', array_slice($clusterKeywords, 0, 2));
  
  if (!empty($citySlug)) {
    $cityName = ucwords(str_replace('-', ' ', $citySlug));
    $desc = "Expert $serviceName in $cityName. $keywordPhrase optimization with GEO-16 framework, structured data, and AI engine citation readiness. Proven results.";
  } else {
    $desc = "Expert $serviceName services. $keywordPhrase optimization with GEO-16 framework, structured data, and AI engine citation readiness. Get results with proven AI SEO strategies.";
  }
  
  if (strlen($desc) > 155) {
    $desc = substr($desc, 0, 152) . '...';
  }
  
  return $desc;
}

/**
 * Generate intro text
 */
function generate_intro_text(string $serviceSlug, string $citySlug, array $topKeywords): array {
  $serviceName = get_service_name_from_slug($serviceSlug);
  $h1 = $serviceName;
  
  if (!empty($citySlug)) {
    $cityName = ucwords(str_replace('-', ' ', $citySlug));
    $h1 .= " in $cityName";
  }
  
  // Build paragraph with technical-AI-SEO keywords
  $primaryKeyword = $topKeywords[0]['keyword'] ?? 'AI SEO';
  $secondaryKeyword = $topKeywords[1]['keyword'] ?? 'structured data';
  
  $paragraph = "$serviceName delivers measurable improvements in $primaryKeyword and $secondaryKeyword for businesses";
  if (!empty($citySlug)) {
    $cityName = ucwords(str_replace('-', ' ', $citySlug));
    $paragraph .= " in $cityName";
  }
  $paragraph .= ". We implement structured data optimization, align content with actual search intent from Google Search Console data, and ensure your site surfaces in both traditional search and AI-powered engines.";
  
  return [
    'h1' => $h1,
    'paragraph' => $paragraph
  ];
}

// Process each service URL
$enhancements = [];

foreach ($uniqueServices as $item) {
  $serviceSlug = $item['service'];
  $citySlug = $item['city'];
  $locale = $item['locale'];
  $url = $item['url'];
  
  // Get service mapping
  $serviceMapping = get_service_mapping($serviceSlug);
  
  // Get top keywords for this service
  $topKeywords = get_top_keywords_for_service($serviceMapping, 3);
  
  // Generate enhancements
  $title = generate_meta_title($serviceSlug, $citySlug, $locale, $topKeywords);
  $description = generate_meta_description($serviceSlug, $citySlug, $topKeywords);
  $intro = generate_intro_text($serviceSlug, $citySlug, $topKeywords);
  
  // Service JSON-LD
  $serviceName = get_service_name_from_slug($serviceSlug);
  $serviceType = get_service_type_from_slug($serviceSlug);
  
  $enhancements[] = [
    'url' => $url,
    'path' => $item['path'],
    'locale' => $locale,
    'service' => $serviceSlug,
    'city' => $citySlug,
    'canonical' => $url,
    'title' => $title,
    'description' => $description,
    'h1' => $intro['h1'],
    'intro_paragraph' => $intro['paragraph'],
    'service_name' => $serviceName,
    'service_type' => $serviceType,
    'top_keywords' => array_column($topKeywords, 'keyword'),
    'service_mapping' => $serviceMapping
  ];
}

// Save enhancements
$outputFile = __DIR__.'/../data/service_keyword_enhancements.json';
file_put_contents($outputFile, json_encode($enhancements, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "✅ Generated keyword-based enhancements for " . count($enhancements) . " service URLs\n";
echo "📁 Saved to: $outputFile\n\n";

// Summary
echo "=== SUMMARY ===\n\n";
echo "Service URLs (base): " . count(array_filter($enhancements, fn($e) => !$e['city'])) . "\n";
echo "Service URLs (with city): " . count(array_filter($enhancements, fn($e) => $e['city'])) . "\n";
echo "Unique services: " . count(array_unique(array_column($enhancements, 'service'))) . "\n";
echo "\n";

// Show sample
echo "=== SAMPLE ENHANCEMENT ===\n\n";
$sample = $enhancements[0];
echo "URL: {$sample['url']}\n";
echo "Title: {$sample['title']} (" . strlen($sample['title']) . " chars)\n";
echo "Description: {$sample['description']} (" . strlen($sample['description']) . " chars)\n";
echo "H1: {$sample['h1']}\n";
echo "Top Keywords: " . implode(', ', $sample['top_keywords']) . "\n";
echo "\n";

