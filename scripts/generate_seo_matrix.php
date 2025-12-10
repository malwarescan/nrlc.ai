<?php
/**
 * SECTION C: Programmatic SEO Matrix
 * 
 * Creates a matrix (JSON/CSV) with:
 * - locale
 * - service_url
 * - primary_keyword
 * - secondary_keywords (comma-separated)
 * - schema_type
 * - canonical
 * - internal_links
 * - content_requirements
 * - priority_score
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/service_enhancements.php';

// Load keyword intelligence
$keywordFile = __DIR__.'/../data/keyword_intelligence.csv';
$keywords = csv_read($keywordFile);

// Load service enhancements
$enhancementsFile = __DIR__.'/../data/service_keyword_enhancements.json';
$enhancements = json_decode(file_get_contents($enhancementsFile), true) ?? [];

if (empty($enhancements)) {
  echo "ERROR: Service enhancements not found. Run enhance_services_with_keywords.php first.\n";
  exit(1);
}

/**
 * Get keywords for a service mapping
 */
function get_keywords_for_service(string $serviceMapping, int $limit = 5): array {
  global $keywords;
  
  $serviceKeywords = array_filter($keywords, function($kw) use ($serviceMapping) {
    return ($kw['service_mapping'] ?? '') === $serviceMapping;
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
 * Calculate priority score
 */
function calculate_priority_score(array $keywordList): float {
  if (empty($keywordList)) return 0.0;
  
  $priorities = array_column($keywordList, 'priority');
  return round(array_sum($priorities) / count($priorities), 2);
}

/**
 * Generate internal links
 */
function generate_internal_links(string $locale): array {
  $localePrefix = $locale ? "/$locale" : '';
  
  return [
    "$localePrefix/services/crawl-clarity/",
    "$localePrefix/services/json-ld-strategy/",
    "$localePrefix/services/llm-seeding/",
    "$localePrefix/services/ai-overview-optimization/"
  ];
}

/**
 * Generate content requirements
 */
function generate_content_requirements(array $topKeywords, string $serviceMapping): string {
  $requirements = [];
  
  // Primary keyword requirement
  if (!empty($topKeywords[0])) {
    $requirements[] = "Include primary keyword: '{$topKeywords[0]['keyword']}' in H1 and first paragraph";
  }
  
  // Secondary keywords
  if (count($topKeywords) > 1) {
    $secondary = array_slice($topKeywords, 1, 2);
    $secondaryList = implode("', '", array_column($secondary, 'keyword'));
    $requirements[] = "Reference secondary keywords: '$secondaryList' in body content";
  }
  
  // Service-specific requirements
  switch ($serviceMapping) {
    case 'structured_data_engineering':
      $requirements[] = "Include schema markup examples";
      $requirements[] = "Reference JSON-LD implementation";
      break;
    case 'llm_strategy':
      $requirements[] = "Include LLM citation optimization strategies";
      $requirements[] = "Reference AI Overviews optimization";
      break;
    case 'ai_seo':
      $requirements[] = "Include technical SEO audit elements";
      $requirements[] = "Reference crawl clarity";
      break;
  }
  
  return implode('; ', $requirements);
}

// Build matrix
$matrix = [];

foreach ($enhancements as $enh) {
  $serviceMapping = $enh['service_mapping'];
  $keywordList = get_keywords_for_service($serviceMapping, 5);
  
  $primaryKeyword = $keywordList[0]['keyword'] ?? '';
  $secondaryKeywords = array_slice(array_column($keywordList, 'keyword'), 1);
  
  $priorityScore = calculate_priority_score($keywordList);
  $internalLinks = generate_internal_links($enh['locale']);
  $contentReqs = generate_content_requirements($keywordList, $serviceMapping);
  
  $matrix[] = [
    'locale' => $enh['locale'] ?: 'en-us',
    'service_url' => $enh['url'],
    'primary_keyword' => $primaryKeyword,
    'secondary_keywords' => implode(', ', $secondaryKeywords),
    'schema_type' => 'Service',
    'canonical' => $enh['canonical'],
    'internal_links' => implode(' | ', $internalLinks),
    'content_requirements' => $contentReqs,
    'priority_score' => $priorityScore,
    'service_mapping' => $serviceMapping,
    'service_slug' => $enh['service'],
    'city_slug' => $enh['city'] ?: ''
  ];
}

// Save as JSON
$jsonFile = __DIR__.'/../data/seo_matrix.json';
file_put_contents($jsonFile, json_encode($matrix, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// Save as CSV
$csvFile = __DIR__.'/../data/seo_matrix.csv';
$fp = fopen($csvFile, 'w');

// Write header
fputcsv($fp, [
  'locale',
  'service_url',
  'primary_keyword',
  'secondary_keywords',
  'schema_type',
  'canonical',
  'internal_links',
  'content_requirements',
  'priority_score',
  'service_mapping',
  'service_slug',
  'city_slug'
], ',', '"', '\\');

// Write data
foreach ($matrix as $row) {
  fputcsv($fp, $row, ',', '"', '\\');
}

fclose($fp);

echo "✅ Generated SEO Matrix\n";
echo "📁 JSON: $jsonFile\n";
echo "📁 CSV: $csvFile\n";
echo "📊 Total entries: " . count($matrix) . "\n\n";

// Summary statistics
$locales = array_count_values(array_column($matrix, 'locale'));
$serviceMappings = array_count_values(array_column($matrix, 'service_mapping'));
$avgPriority = round(array_sum(array_column($matrix, 'priority_score')) / count($matrix), 2);

echo "=== SUMMARY ===\n\n";
echo "Locales:\n";
foreach ($locales as $locale => $count) {
  echo "  $locale: $count\n";
}
echo "\nService Mappings:\n";
foreach ($serviceMappings as $mapping => $count) {
  echo "  $mapping: $count\n";
}
echo "\nAverage Priority Score: $avgPriority\n";
echo "\n";

// Show sample
echo "=== SAMPLE MATRIX ENTRY ===\n\n";
$sample = $matrix[0];
foreach ($sample as $key => $value) {
  echo "$key: $value\n";
}


