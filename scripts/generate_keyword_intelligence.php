<?php
/**
 * Keyword Intelligence Generator
 * Generates comprehensive keyword CSV with clustering, intent, service mapping, and priority
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/csv.php';

// Load Queries.csv
$queriesFile = __DIR__.'/../serp_intel/Queries.csv';
$queries = csv_read($queriesFile);

// City/Geo detection patterns
$cityPatterns = [
  'new-york', 'new york', 'nyc', 'manhattan', 'brooklyn',
  'london', 'uk', 'united kingdom', 'british',
  'los angeles', 'la', 'california', 'ca',
  'chicago', 'illinois', 'il',
  'houston', 'texas', 'tx',
  'phoenix', 'arizona', 'az',
  'philadelphia', 'pennsylvania', 'pa',
  'san antonio', 'san diego', 'dallas', 'san jose',
  'austin', 'jacksonville', 'san francisco', 'sf',
  'indianapolis', 'columbus', 'fort worth', 'charlotte',
  'seattle', 'denver', 'washington', 'boston', 'el paso',
  'detroit', 'nashville', 'memphis', 'portland', 'oklahoma city',
  'las vegas', 'louisville', 'baltimore', 'milwaukee', 'albuquerque',
  'tucson', 'fresno', 'sacramento', 'kansas city', 'mesa',
  'atlanta', 'omaha', 'raleigh', 'miami', 'long beach',
  'virginia beach', 'oakland', 'minneapolis', 'tulsa', 'tampa',
  'cleveland', 'wichita', 'arlington', 'new orleans', 'honolulu',
  'singapore', 'tokyo', 'seoul', 'sydney', 'toronto', 'vancouver',
  'montreal', 'berlin', 'paris', 'madrid', 'rome', 'amsterdam',
  'stockport', 'birmingham', 'manchester', 'glasgow', 'edinburgh',
  'belfast', 'cardiff', 'liverpool', 'leeds', 'sheffield',
  'bristol', 'coventry', 'leicester', 'sunderland', 'nottingham',
  'newcastle', 'hull', 'southampton', 'portsmouth', 'plymouth',
  'southend-on-sea', 'southport', 'oldham', 'middlesbrough',
  'huddersfield', 'west bromwich', 'northampton', 'blackpool',
  'near me', 'local', 'in my area'
];

/**
 * Determine keyword cluster
 */
function get_cluster(string $keyword): string {
  $kw = strtolower($keyword);
  
  // TECHNICAL_AI_SEO
  if (preg_match('/\b(seo|audit|optimization|schema|ai|llm|structured\s+data|json-ld|technical\s+seo|crawl|sitemap|metadata|entity|semantic)\b/i', $kw)) {
    return 'TECHNICAL_AI_SEO';
  }
  
  // AI_LLM_STRATEGY
  if (preg_match('/\b(llm|ai\s+strategy|chatgpt|claude|perplexity|copilot|bard|ai\s+visibility|agentic|generative)\b/i', $kw)) {
    return 'AI_LLM_STRATEGY';
  }
  
  // GEO_SEO
  global $cityPatterns;
  foreach ($cityPatterns as $pattern) {
    if (stripos($kw, $pattern) !== false) {
      return 'GEO_SEO';
    }
  }
  
  // BRAND_AUTHORITY
  if (preg_match('/\b(neural\s+command|nrlc|nrlc\.ai)\b/i', $kw)) {
    return 'BRAND_AUTHORITY';
  }
  
  // GENERAL_SEO (catch-all for SEO terms)
  if (preg_match('/\b(seo|search\s+engine|ranking|serp|organic)\b/i', $kw)) {
    return 'GENERAL_SEO';
  }
  
  return 'GENERAL_SEO';
}

/**
 * Determine intent
 */
function get_intent(string $keyword): string {
  $kw = strtolower($keyword);
  
  // Job intent
  if (preg_match('/\b(jobs?|hiring|recruiter|applicant|career|position|vacancy)\b/i', $kw)) {
    return 'job_intent';
  }
  
  // Local intent
  global $cityPatterns;
  foreach ($cityPatterns as $pattern) {
    if (stripos($kw, $pattern) !== false) {
      return 'local_intent';
    }
  }
  
  // Navigational (brand)
  if (preg_match('/\b(neural\s+command|nrlc)\b/i', $kw)) {
    return 'navigational';
  }
  
  // Transactional
  if (preg_match('/\b(services?|hire|company|agency|provider|consultant|expert|professional|buy|purchase|get|order)\b/i', $kw)) {
    return 'transactional';
  }
  
  // Informational
  if (preg_match('/\b(what\s+is|how\s+to|guide|tutorial|checker|tool|audit|analyze|test|check|learn|compare|best|top|review)\b/i', $kw)) {
    return 'informational';
  }
  
  return 'informational';
}

/**
 * Determine service mapping
 */
function get_service_mapping(string $keyword): string {
  $kw = strtolower($keyword);
  
  // enterprise_ai_hiring
  if (preg_match('/\b(jobs?|hiring|recruiter|applicant|career|position|vacancy)\b/i', $kw)) {
    return 'enterprise_ai_hiring';
  }
  
  // structured_data_engineering
  if (preg_match('/\b(schema|json-ld|structured\s+data|rich\s+results?|microdata|rdfa|semantic\s+markup)\b/i', $kw)) {
    return 'structured_data_engineering';
  }
  
  // llm_strategy
  if (preg_match('/\b(llm|ai\s+strategy|agentic|generative|chatgpt|claude|perplexity|copilot|bard|ai\s+visibility)\b/i', $kw)) {
    return 'llm_strategy';
  }
  
  // ranking_optimization
  if (preg_match('/\b(ranking|rank|position|serp|top\s+results?|first\s+page)\b/i', $kw)) {
    return 'ranking_optimization';
  }
  
  // mobile_ai_seo
  if (preg_match('/\b(mobile|responsive|mobile-first|mobile\s+seo)\b/i', $kw)) {
    return 'mobile_ai_seo';
  }
  
  // ai_seo (catch-all for SEO terms)
  if (preg_match('/\b(seo|audit|optimization|crawl|sitemap|technical)\b/i', $kw)) {
    return 'ai_seo';
  }
  
  return 'ai_seo';
}

/**
 * Detect locale from keyword
 */
function detect_locale(string $keyword): string {
  $kw = strtolower($keyword);
  
  // UK patterns
  if (preg_match('/\b(uk|united\s+kingdom|british|britain|gb|england|scotland|wales|northern\s+ireland)\b/i', $kw)) {
    return 'en-gb';
  }
  
  // US patterns (default)
  if (preg_match('/\b(usa|united\s+states|us\s+city|american)\b/i', $kw)) {
    return 'en-us';
  }
  
  // Other locales can be detected from city names
  return 'en-us'; // default
}

/**
 * Extract geo target
 */
function extract_geo_target(string $keyword): string {
  global $cityPatterns;
  $kw = strtolower($keyword);
  
  foreach ($cityPatterns as $pattern) {
    if (stripos($kw, $pattern) !== false) {
      return ucwords(str_replace('-', ' ', $pattern));
    }
  }
  
  return '';
}

/**
 * Calculate priority based on impressions
 */
function calculate_priority(int $impressions, string $intent, string $cluster): int {
  // High priority: high impressions OR high commercial intent
  if ($impressions >= 50 || $intent === 'transactional') {
    return 1;
  }
  
  // Medium priority: medium impressions OR mid commercial relevance
  if ($impressions >= 20 || ($intent === 'informational' && $cluster === 'TECHNICAL_AI_SEO')) {
    return 2;
  }
  
  // Low but strategic: low impressions but strategically relevant
  if ($impressions >= 5 || in_array($cluster, ['TECHNICAL_AI_SEO', 'AI_LLM_STRATEGY'])) {
    return 3;
  }
  
  // Long-tail filler
  return 4;
}

// Process all queries
$keywordData = [];

foreach ($queries as $row) {
  $query = trim($row['top_queries'] ?? $row['Top queries'] ?? '');
  if (empty($query)) continue;
  
  $impressions = (int)($row['impressions'] ?? $row['Impressions'] ?? 0);
  $clicks = (int)($row['clicks'] ?? $row['Clicks'] ?? 0);
  
  $keyword = strtolower($query);
  $cluster = get_cluster($keyword);
  $intent = get_intent($keyword);
  $serviceMapping = get_service_mapping($keyword);
  $priority = calculate_priority($impressions, $intent, $cluster);
  $locale = detect_locale($keyword);
  $geoTarget = extract_geo_target($keyword);
  
  // Notes
  $notes = [];
  if ($clicks > 0) {
    $notes[] = "Has clicks: $clicks";
  }
  if ($impressions >= 100) {
    $notes[] = "High volume";
  }
  
  $keywordData[] = [
    'keyword' => $keyword,
    'cluster' => $cluster,
    'intent' => $intent,
    'service_mapping' => $serviceMapping,
    'priority' => $priority,
    'locale_detected' => $locale,
    'geo_target' => $geoTarget,
    'impressions' => $impressions,
    'clicks' => $clicks,
    'notes' => implode('; ', $notes)
  ];
}

// Sort by priority, then impressions
usort($keywordData, function($a, $b) {
  if ($a['priority'] !== $b['priority']) {
    return $a['priority'] <=> $b['priority'];
  }
  return $b['impressions'] <=> $a['impressions'];
});

// Write CSV
$outputFile = __DIR__.'/../data/keyword_intelligence.csv';
$outputDir = dirname($outputFile);
if (!is_dir($outputDir)) {
  mkdir($outputDir, 0755, true);
}

$fp = fopen($outputFile, 'w');

// Write header
fputcsv($fp, [
  'keyword',
  'cluster',
  'intent',
  'service_mapping',
  'priority',
  'locale_detected',
  'geo_target',
  'impressions',
  'clicks',
  'notes'
], ',', '"', '\\');

// Write data
foreach ($keywordData as $row) {
  fputcsv($fp, $row, ',', '"', '\\');
}

fclose($fp);

echo "✅ Generated keyword intelligence CSV\n";
echo "📁 File: $outputFile\n";
echo "📊 Total keywords: " . count($keywordData) . "\n";
echo "\n";

// Summary statistics
$clusters = array_count_values(array_column($keywordData, 'cluster'));
$intents = array_count_values(array_column($keywordData, 'intent'));
$services = array_count_values(array_column($keywordData, 'service_mapping'));
$priorities = array_count_values(array_column($keywordData, 'priority'));

echo "=== SUMMARY ===\n\n";
echo "Clusters:\n";
foreach ($clusters as $cluster => $count) {
  echo "  $cluster: $count\n";
}
echo "\nIntents:\n";
foreach ($intents as $intent => $count) {
  echo "  $intent: $count\n";
}
echo "\nService Mappings:\n";
foreach ($services as $service => $count) {
  echo "  $service: $count\n";
}
echo "\nPriorities:\n";
foreach ($priorities as $priority => $count) {
  echo "  Priority $priority: $count\n";
}
echo "\n";

// Show top 20 keywords
echo "=== TOP 20 KEYWORDS (Priority 1-2) ===\n\n";
$topKeywords = array_filter($keywordData, fn($k) => $k['priority'] <= 2);
$topKeywords = array_slice($topKeywords, 0, 20);
foreach ($topKeywords as $kw) {
  echo sprintf(
    "[%d] %s | %s | %s | %s\n",
    $kw['priority'],
    $kw['keyword'],
    $kw['cluster'],
    $kw['intent'],
    $kw['service_mapping']
  );
}

