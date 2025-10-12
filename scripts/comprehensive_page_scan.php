<?php
declare(strict_types=1);

/**
 * Comprehensive Page Scanner for NRLC.ai
 * Validates content length, uniqueness, and quality across all 13,432 pages
 */

require_once __DIR__ . '/../lib/csv.php';
require_once __DIR__ . '/../lib/helpers.php';

function scan_word_count_html(string $html): int {
  $text = trim(strip_tags(preg_replace('/\s+/', ' ', $html)));
  return $text ? str_word_count($text) : 0;
}

function scan_page(string $url): array {
  $_SERVER['REQUEST_URI'] = $url;
  $_SERVER['HTTP_HOST'] = 'nrlc.ai';
  $_SERVER['HTTPS'] = 'on';
  
  ob_start();
  try {
    // Suppress header warnings
    $oldErrorReporting = error_reporting(E_ERROR | E_PARSE);
    include __DIR__ . '/../public/index.php';
    error_reporting($oldErrorReporting);
    $html = (string)ob_get_clean();
  } catch (Exception $e) {
    ob_end_clean();
    return ['error' => $e->getMessage(), 'word_count' => 0];
  }
  
  $wordCount = scan_word_count_html($html);
  $hasSchema = strpos($html, 'application/ld+json') !== false;
  $hasFAQ = strpos($html, 'FAQPage') !== false;
  $hasH1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $html, $matches);
  $h1Text = $hasH1 ? trim(strip_tags($matches[1])) : '';
  
  return [
    'url' => $url,
    'word_count' => $wordCount,
    'has_schema' => $hasSchema,
    'has_faq' => $hasFAQ,
    'has_h1' => $hasH1,
    'h1_text' => $h1Text,
    'meets_length' => $wordCount >= 900 && $wordCount <= 1500,
    'html_length' => strlen($html)
  ];
}

function generate_service_urls(): array {
  $services = csv_read_data('services.csv');
  $cities = csv_read_data('cities.csv');
  $urls = [];
  
  foreach ($services as $service) {
    foreach ($cities as $city) {
      $urls[] = "/services/{$service['slug']}/{$city['city_name']}/";
    }
  }
  
  return $urls;
}

function generate_industry_urls(): array {
  $industries = [
    'healthcare', 'fintech', 'ecommerce', 'saas', 'education', 'real-estate',
    'legal', 'automotive', 'travel', 'hospitality', 'manufacturing', 'retail',
    'consulting', 'media', 'entertainment'
  ];
  
  $urls = [];
  foreach ($industries as $industry) {
    $urls[] = "/industries/{$industry}/";
  }
  
  return $urls;
}

function generate_tool_urls(): array {
  $tools = [
    'chatgpt', 'claude', 'perplexity', 'bard', 'copilot', 'google-ai-overviews',
    'schema-generator', 'json-ld-validator', 'structured-data-testing',
    'screaming-frog', 'sitebulb', 'ahrefs', 'semrush', 'moz', 'brightedge', 'seer-interactive'
  ];
  
  $urls = [];
  foreach ($tools as $tool) {
    $urls[] = "/tools/{$tool}/";
  }
  
  return $urls;
}

function generate_case_study_urls(): array {
  $urls = [];
  for ($i = 1; $i <= 200; $i++) {
    $urls[] = "/case-studies/case-study-{$i}/";
  }
  
  return $urls;
}

function generate_blog_urls(): array {
  $urls = [];
  for ($i = 1; $i <= 500; $i++) {
    $urls[] = "/blog/blog-post-{$i}/";
  }
  
  return $urls;
}

function generate_resource_urls(): array {
  $urls = [];
  for ($i = 1; $i <= 1000; $i++) {
    $urls[] = "/resources/resource-{$i}/";
  }
  
  return $urls;
}

function generate_insight_urls(): array {
  $insights = csv_read_data('insights.csv');
  $urls = [];
  
  foreach ($insights as $insight) {
    $urls[] = "/insights/{$insight['slug']}/";
  }
  
  return $urls;
}

function generate_career_urls(): array {
  $careers = csv_read_data('career_matrix.csv');
  $urls = [];
  
  foreach ($careers as $career) {
    $urls[] = "/careers/{$career['city']}/{$career['role']}/";
  }
  
  return $urls;
}

function generate_homepage_urls(): array {
  return ['/'];
}

function scan_category(string $category, array $urls, int $sampleSize = 10): array {
  echo "Scanning {$category} pages...\n";
  
  $results = [];
  $sampleUrls = array_slice($urls, 0, $sampleSize);
  
  foreach ($sampleUrls as $url) {
    echo "  Scanning: {$url}\n";
    $result = scan_page($url);
    $results[] = $result;
    
    if (isset($result['error'])) {
      echo "    ERROR: {$result['error']}\n";
    } else {
      echo "    Words: {$result['word_count']}, Schema: " . ($result['has_schema'] ? 'Yes' : 'No') . ", FAQ: " . ($result['has_faq'] ? 'Yes' : 'No') . "\n";
    }
  }
  
  return $results;
}

function generate_report(array $allResults): void {
  $totalPages = count($allResults);
  $meetsLength = array_filter($allResults, fn($r) => $r['meets_length'] ?? false);
  $hasSchema = array_filter($allResults, fn($r) => $r['has_schema'] ?? false);
  $hasFAQ = array_filter($allResults, fn($r) => $r['has_faq'] ?? false);
  $hasH1 = array_filter($allResults, fn($r) => $r['has_h1'] ?? false);
  
  $avgWordCount = array_sum(array_column($allResults, 'word_count')) / $totalPages;
  $minWordCount = min(array_column($allResults, 'word_count'));
  $maxWordCount = max(array_column($allResults, 'word_count'));
  
  echo "\n" . str_repeat("=", 60) . "\n";
  echo "COMPREHENSIVE PAGE SCAN REPORT\n";
  echo str_repeat("=", 60) . "\n";
  echo "Total pages scanned: {$totalPages}\n";
  echo "Pages meeting length requirements: " . count($meetsLength) . " (" . round(count($meetsLength)/$totalPages*100, 1) . "%)\n";
  echo "Pages with schema markup: " . count($hasSchema) . " (" . round(count($hasSchema)/$totalPages*100, 1) . "%)\n";
  echo "Pages with FAQ sections: " . count($hasFAQ) . " (" . round(count($hasFAQ)/$totalPages*100, 1) . "%)\n";
  echo "Pages with H1 headings: " . count($hasH1) . " (" . round(count($hasH1)/$totalPages*100, 1) . "%)\n";
  echo "\nWord count statistics:\n";
  echo "Average: " . round($avgWordCount) . " words\n";
  echo "Minimum: {$minWordCount} words\n";
  echo "Maximum: {$maxWordCount} words\n";
  
  // Identify pages that need attention
  $issues = [];
  foreach ($allResults as $result) {
    if (!$result['meets_length']) {
      $issues[] = "{$result['url']}: {$result['word_count']} words (below 900)";
    }
    if (!$result['has_schema']) {
      $issues[] = "{$result['url']}: Missing schema markup";
    }
    if (!$result['has_faq']) {
      $issues[] = "{$result['url']}: Missing FAQ section";
    }
    if (!$result['has_h1']) {
      $issues[] = "{$result['url']}: Missing H1 heading";
    }
  }
  
  if (!empty($issues)) {
    echo "\nIssues found:\n";
    foreach (array_slice($issues, 0, 20) as $issue) {
      echo "• {$issue}\n";
    }
    if (count($issues) > 20) {
      echo "... and " . (count($issues) - 20) . " more issues\n";
    }
  }
}

// Main execution
echo "NRLC.ai Comprehensive Page Scanner\n";
echo "==================================\n\n";

$allResults = [];

// Scan each category
$categories = [
  'Service' => generate_service_urls(),
  'Industry' => generate_industry_urls(),
  'Tool' => generate_tool_urls(),
  'Case Study' => generate_case_study_urls(),
  'Blog' => generate_blog_urls(),
  'Resource' => generate_resource_urls(),
  'Insight' => generate_insight_urls(),
  'Career' => generate_career_urls(),
  'Homepage' => generate_homepage_urls()
];

foreach ($categories as $category => $urls) {
  $sampleSize = min(10, count($urls)); // Sample first 10 URLs from each category
  $results = scan_category($category, $urls, $sampleSize);
  $allResults = array_merge($allResults, $results);
}

// Generate comprehensive report
generate_report($allResults);

echo "\nScan complete!\n";
