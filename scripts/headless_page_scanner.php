<?php
declare(strict_types=1);

/**
 * Headless Page Scanner for NRLC.ai
 * Validates content without triggering header conflicts
 */

function headless_word_count(string $html): int {
  $text = trim(strip_tags(preg_replace('/\s+/', ' ', $html)));
  return $text ? str_word_count($text) : 0;
}

function scan_page_content(string $url): array {
  // Set up environment
  $_SERVER['REQUEST_URI'] = $url;
  $_SERVER['HTTP_HOST'] = 'nrlc.ai';
  $_SERVER['HTTPS'] = 'on';
  
  // Capture output
  ob_start();
  
  // Suppress all output and errors
  $oldErrorReporting = error_reporting(0);
  $oldDisplayErrors = ini_set('display_errors', 0);
  
  try {
    include __DIR__ . '/../public/index.php';
    $html = (string)ob_get_clean();
  } catch (Exception $e) {
    ob_end_clean();
    return ['error' => $e->getMessage()];
  } finally {
    // Restore settings
    error_reporting($oldErrorReporting);
    ini_set('display_errors', $oldDisplayErrors);
  }
  
  // Analyze content
  $wordCount = headless_word_count($html);
  $hasSchema = strpos($html, 'application/ld+json') !== false;
  $hasFAQ = strpos($html, 'FAQPage') !== false;
  $hasH1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $html, $matches);
  $h1Text = $hasH1 ? trim(strip_tags($matches[1])) : '';
  $meetsLength = $wordCount >= 900 && $wordCount <= 1500;
  
  return [
    'url' => $url,
    'word_count' => $wordCount,
    'has_schema' => $hasSchema,
    'has_faq' => $hasFAQ,
    'has_h1' => $hasH1,
    'h1_text' => $h1Text,
    'meets_length' => $meetsLength,
    'html_length' => strlen($html)
  ];
}

function run_comprehensive_scan(): void {
  echo "NRLC.ai Comprehensive Page Scanner\n";
  echo "==================================\n\n";
  
  // Sample URLs from each category
  $sampleUrls = [
    // Service pages (sample from different services and cities)
    '/services/crawl-clarity/new-york/',
    '/services/json-ld-strategy/london/',
    '/services/llm-seeding/san-francisco/',
    '/services/ai-first-site-audits/chicago/',
    '/services/international-seo/toronto/',
    
    // Industry pages
    '/industries/healthcare/',
    '/industries/fintech/',
    '/industries/ecommerce/',
    
    // Tool pages
    '/tools/chatgpt/',
    '/tools/claude/',
    '/tools/perplexity/',
    
    // Case study pages
    '/case-studies/case-study-1/',
    '/case-studies/case-study-50/',
    '/case-studies/case-study-100/',
    
    // Blog pages
    '/blog/blog-post-1/',
    '/blog/blog-post-100/',
    '/blog/blog-post-250/',
    
    // Resource pages
    '/resources/resource-1/',
    '/resources/resource-500/',
    '/resources/resource-1000/',
    
    // Insight pages
    '/insights/geo16-framework/',
    '/insights/geo16-introduction/',
    '/insights/llm-ontology-generation/',
    
    // Career pages
    '/careers/new-york/seo-specialist/',
    '/careers/london/content-manager/',
    
    // Homepage
    '/'
  ];
  
  $results = [];
  $totalWords = 0;
  $pagesWithSchema = 0;
  $pagesWithFAQ = 0;
  $pagesWithH1 = 0;
  $pagesMeetingLength = 0;
  $errors = 0;
  
  foreach ($sampleUrls as $url) {
    echo "Scanning: {$url}";
    
    $result = scan_page_content($url);
    
    if (isset($result['error'])) {
      echo " - ERROR: {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $hasSchema = $result['has_schema'];
    $hasFAQ = $result['has_faq'];
    $hasH1 = $result['has_h1'];
    $meetsLength = $result['meets_length'];
    
    echo " - {$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($hasSchema ? "✓" : "✗");
    echo " | FAQ: " . ($hasFAQ ? "✓" : "✗");
    echo " | H1: " . ($hasH1 ? "✓" : "✗");
    echo "\n";
    
    $results[] = $result;
    $totalWords += $wordCount;
    if ($hasSchema) $pagesWithSchema++;
    if ($hasFAQ) $pagesWithFAQ++;
    if ($hasH1) $pagesWithH1++;
  }
  
  $totalPages = count($results);
  $avgWords = $totalPages > 0 ? round($totalWords / $totalPages) : 0;
  
  echo "\n" . str_repeat("=", 70) . "\n";
  echo "COMPREHENSIVE SCAN RESULTS\n";
  echo str_repeat("=", 70) . "\n";
  echo "Total pages scanned: {$totalPages}\n";
  echo "Pages with errors: {$errors}\n";
  echo "Average word count: {$avgWords} words\n";
  echo "Pages meeting length (900-1500): {$pagesMeetingLength}/{$totalPages} (" . round($pagesMeetingLength/$totalPages*100, 1) . "%)\n";
  echo "Pages with schema markup: {$pagesWithSchema}/{$totalPages} (" . round($pagesWithSchema/$totalPages*100, 1) . "%)\n";
  echo "Pages with FAQ sections: {$pagesWithFAQ}/{$totalPages} (" . round($pagesWithFAQ/$totalPages*100, 1) . "%)\n";
  echo "Pages with H1 headings: {$pagesWithH1}/{$totalPages} (" . round($pagesWithH1/$totalPages*100, 1) . "%)\n";
  
  // Word count statistics
  $wordCounts = array_column($results, 'word_count');
  if (!empty($wordCounts)) {
    $minWords = min($wordCounts);
    $maxWords = max($wordCounts);
    echo "\nWord count range: {$minWords} - {$maxWords} words\n";
  }
  
  // Identify specific issues
  $issues = [];
  foreach ($results as $result) {
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
    foreach (array_slice($issues, 0, 15) as $issue) {
      echo "• {$issue}\n";
    }
    if (count($issues) > 15) {
      echo "... and " . (count($issues) - 15) . " more issues\n";
    }
  } else {
    echo "\n✓ All sample pages meet requirements!\n";
  }
  
  // Recommendations
  echo "\n" . str_repeat("=", 70) . "\n";
  echo "RECOMMENDATIONS\n";
  echo str_repeat("=", 70) . "\n";
  
  if ($pagesMeetingLength < $totalPages * 0.9) {
    echo "• Content length: Some pages below 900 words - consider adding more content\n";
  }
  
  if ($pagesWithSchema < $totalPages * 0.9) {
    echo "• Schema markup: Some pages missing structured data - ensure all pages have JSON-LD\n";
  }
  
  if ($pagesWithFAQ < $totalPages * 0.9) {
    echo "• FAQ sections: Some pages missing FAQ content - add FAQ sections for better AI optimization\n";
  }
  
  if ($pagesWithH1 < $totalPages * 0.9) {
    echo "• H1 headings: Some pages missing H1 - ensure proper heading structure\n";
  }
  
  if ($avgWords < 1000) {
    echo "• Content depth: Average word count below 1000 - consider expanding content\n";
  }
  
  echo "\nScan complete!\n";
}

// Run the comprehensive scan
run_comprehensive_scan();
