<?php
declare(strict_types=1);

/**
 * Simple Page Scanner for NRLC.ai
 * Validates content length and quality across sample pages
 */

function simple_word_count(string $html): int {
  $text = trim(strip_tags(preg_replace('/\s+/', ' ', $html)));
  return $text ? str_word_count($text) : 0;
}

function scan_sample_pages(): void {
  $sampleUrls = [
    // Service pages
    '/services/crawl-clarity/new-york/',
    '/services/json-ld-strategy/london/',
    '/services/llm-seeding/san-francisco/',
    
    // Industry pages
    '/industries/healthcare/',
    '/industries/fintech/',
    
    // Tool pages
    '/tools/chatgpt/',
    '/tools/claude/',
    
    // Case study pages
    '/case-studies/case-study-1/',
    '/case-studies/case-study-2/',
    
    // Blog pages
    '/blog/blog-post-1/',
    '/blog/blog-post-2/',
    
    // Resource pages
    '/resources/resource-1/',
    '/resources/resource-2/',
    
    // Insight pages
    '/insights/geo16-framework/',
    '/insights/geo16-introduction/',
    
    // Career pages
    '/careers/new-york/seo-specialist/',
    
    // Homepage
    '/'
  ];
  
  echo "NRLC.ai Page Scanner - Sample Analysis\n";
  echo "=====================================\n\n";
  
  $results = [];
  $totalWords = 0;
  $pagesWithSchema = 0;
  $pagesWithFAQ = 0;
  $pagesWithH1 = 0;
  $pagesMeetingLength = 0;
  
  foreach ($sampleUrls as $url) {
    echo "Scanning: {$url}\n";
    
    $_SERVER['REQUEST_URI'] = $url;
    $_SERVER['HTTP_HOST'] = 'nrlc.ai';
    $_SERVER['HTTPS'] = 'on';
    
    ob_start();
    try {
      // Suppress warnings
      $oldErrorReporting = error_reporting(0);
      include __DIR__ . '/../public/index.php';
      error_reporting($oldErrorReporting);
      $html = (string)ob_get_clean();
    } catch (Exception $e) {
      ob_end_clean();
      echo "  ERROR: {$e->getMessage()}\n";
      continue;
    }
    
    $wordCount = simple_word_count($html);
    $hasSchema = strpos($html, 'application/ld+json') !== false;
    $hasFAQ = strpos($html, 'FAQPage') !== false;
    $hasH1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $html, $matches);
    $h1Text = $hasH1 ? trim(strip_tags($matches[1])) : '';
    $meetsLength = $wordCount >= 900 && $wordCount <= 1500;
    
    echo "  Words: {$wordCount}";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($hasSchema ? "✓" : "✗");
    echo " | FAQ: " . ($hasFAQ ? "✓" : "✗");
    echo " | H1: " . ($hasH1 ? "✓" : "✗");
    if ($h1Text) {
      echo " | H1: \"" . substr($h1Text, 0, 50) . "...\"";
    }
    echo "\n";
    
    $results[] = [
      'url' => $url,
      'word_count' => $wordCount,
      'has_schema' => $hasSchema,
      'has_faq' => $hasFAQ,
      'has_h1' => $hasH1,
      'h1_text' => $h1Text,
      'meets_length' => $meetsLength
    ];
    
    $totalWords += $wordCount;
    if ($hasSchema) $pagesWithSchema++;
    if ($hasFAQ) $pagesWithFAQ++;
    if ($hasH1) $pagesWithH1++;
  }
  
  $totalPages = count($results);
  $avgWords = $totalPages > 0 ? round($totalWords / $totalPages) : 0;
  
  echo "\n" . str_repeat("=", 60) . "\n";
  echo "SCAN SUMMARY\n";
  echo str_repeat("=", 60) . "\n";
  echo "Total pages scanned: {$totalPages}\n";
  echo "Average word count: {$avgWords} words\n";
  echo "Pages meeting length (900-1500): {$pagesMeetingLength}/{$totalPages} (" . round($pagesMeetingLength/$totalPages*100, 1) . "%)\n";
  echo "Pages with schema markup: {$pagesWithSchema}/{$totalPages} (" . round($pagesWithSchema/$totalPages*100, 1) . "%)\n";
  echo "Pages with FAQ sections: {$pagesWithFAQ}/{$totalPages} (" . round($pagesWithFAQ/$totalPages*100, 1) . "%)\n";
  echo "Pages with H1 headings: {$pagesWithH1}/{$totalPages} (" . round($pagesWithH1/$totalPages*100, 1) . "%)\n";
  
  // Identify issues
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
    foreach ($issues as $issue) {
      echo "• {$issue}\n";
    }
  } else {
    echo "\n✓ All sample pages meet requirements!\n";
  }
  
  echo "\nScan complete!\n";
}

// Run the scanner
scan_sample_pages();
