<?php
declare(strict_types=1);

/**
 * Direct Content Scanner for NRLC.ai
 * Analyzes content by directly including page files without headers
 */

function analyze_content(string $filePath): array {
  if (!file_exists($filePath)) {
    return ['error' => 'File not found: ' . $filePath];
  }
  
  ob_start();
  try {
    include $filePath;
    $content = (string)ob_get_clean();
  } catch (Exception $e) {
    ob_end_clean();
    return ['error' => $e->getMessage()];
  }
  
  // Count words in content
  $text = trim(strip_tags(preg_replace('/\s+/', ' ', $content)));
  $wordCount = $text ? str_word_count($text) : 0;
  
  // Check for schema markers
  $hasSchema = strpos($content, 'application/ld+json') !== false;
  $hasFAQ = strpos($content, 'FAQPage') !== false;
  $hasH1 = preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $content, $matches);
  $h1Text = $hasH1 ? trim(strip_tags($matches[1])) : '';
  
  return [
    'word_count' => $wordCount,
    'has_schema' => $hasSchema,
    'has_faq' => $hasFAQ,
    'has_h1' => $hasH1,
    'h1_text' => $h1Text,
    'meets_length' => $wordCount >= 900 && $wordCount <= 1500,
    'content_length' => strlen($content)
  ];
}

function scan_all_page_types(): void {
  echo "NRLC.ai Direct Content Scanner\n";
  echo "==============================\n\n";
  
  $results = [];
  $totalWords = 0;
  $pagesWithSchema = 0;
  $pagesWithFAQ = 0;
  $pagesWithH1 = 0;
  $pagesMeetingLength = 0;
  $errors = 0;
  
  // Service pages
  echo "Scanning Service Pages...\n";
  $servicePages = [
    'services/service_city.php'
  ];
  
  foreach ($servicePages as $page) {
    $filePath = __DIR__ . '/../pages/' . $page;
    echo "  {$page}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'service', 'file' => $page]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Industry pages
  echo "\nScanning Industry Pages...\n";
  $industryPages = [
    'industries/industry.php'
  ];
  
  foreach ($industryPages as $page) {
    $filePath = __DIR__ . '/../pages/' . $page;
    echo "  {$page}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'industry', 'file' => $page]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Tool pages
  echo "\nScanning Tool Pages...\n";
  $toolPages = [
    'tools/tool.php'
  ];
  
  foreach ($toolPages as $page) {
    $filePath = __DIR__ . '/../pages/' . $page;
    echo "  {$page}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'tool', 'file' => $page]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Case study pages
  echo "\nScanning Case Study Pages...\n";
  $caseStudyPages = [
    'case-studies/case-study.php'
  ];
  
  foreach ($caseStudyPages as $page) {
    $filePath = __DIR__ . '/../pages/' . $page;
    echo "  {$page}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'case-study', 'file' => $page]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Blog pages
  echo "\nScanning Blog Pages...\n";
  $blogPages = [
    'blog/blog-post.php'
  ];
  
  foreach ($blogPages as $page) {
    $filePath = __DIR__ . '/../pages/' . $page;
    echo "  {$page}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'blog', 'file' => $page]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Resource pages
  echo "\nScanning Resource Pages...\n";
  $resourcePages = [
    'resources/resource.php'
  ];
  
  foreach ($resourcePages as $page) {
    $filePath = __DIR__ . '/../pages/' . $page;
    echo "  {$page}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'resource', 'file' => $page]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Insight pages
  echo "\nScanning Insight Pages...\n";
  $insightFiles = glob(__DIR__ . '/../pages/insights/*.php');
  
  foreach ($insightFiles as $filePath) {
    $fileName = basename($filePath);
    echo "  {$fileName}: ";
    
    $result = analyze_content($filePath);
    
    if (isset($result['error'])) {
      echo "ERROR - {$result['error']}\n";
      $errors++;
      continue;
    }
    
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'insight', 'file' => $fileName]);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Homepage
  echo "\nScanning Homepage...\n";
  $homepagePath = __DIR__ . '/../pages/home/home.php';
  echo "  home.php: ";
  
  $result = analyze_content($homepagePath);
  
  if (isset($result['error'])) {
    echo "ERROR - {$result['error']}\n";
    $errors++;
  } else {
    $wordCount = $result['word_count'];
    $meetsLength = $result['meets_length'];
    
    echo "{$wordCount} words";
    if ($meetsLength) {
      echo " ✓";
      $pagesMeetingLength++;
    } else {
      echo " ✗";
    }
    echo " | Schema: " . ($result['has_schema'] ? "✓" : "✗");
    echo " | FAQ: " . ($result['has_faq'] ? "✓" : "✗");
    echo " | H1: " . ($result['has_h1'] ? "✓" : "✗");
    echo "\n";
    
    $results[] = array_merge($result, ['type' => 'homepage', 'file' => 'home.php']);
    $totalWords += $wordCount;
    if ($result['has_schema']) $pagesWithSchema++;
    if ($result['has_faq']) $pagesWithFAQ++;
    if ($result['has_h1']) $pagesWithH1++;
  }
  
  // Generate summary
  $totalPages = count($results);
  $avgWords = $totalPages > 0 ? round($totalWords / $totalPages) : 0;
  
  echo "\n" . str_repeat("=", 70) . "\n";
  echo "CONTENT ANALYSIS SUMMARY\n";
  echo str_repeat("=", 70) . "\n";
  echo "Total page types analyzed: {$totalPages}\n";
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
  
  // Issues by type
  echo "\nIssues by page type:\n";
  $issuesByType = [];
  foreach ($results as $result) {
    $type = $result['type'];
    if (!isset($issuesByType[$type])) {
      $issuesByType[$type] = ['total' => 0, 'issues' => 0];
    }
    $issuesByType[$type]['total']++;
    
    if (!$result['meets_length'] || !$result['has_schema'] || !$result['has_faq'] || !$result['has_h1']) {
      $issuesByType[$type]['issues']++;
    }
  }
  
  foreach ($issuesByType as $type => $stats) {
    $percentage = round($stats['issues'] / $stats['total'] * 100, 1);
    echo "• {$type}: {$stats['issues']}/{$stats['total']} pages with issues ({$percentage}%)\n";
  }
  
  echo "\nScan complete!\n";
}

// Run the direct content scan
scan_all_page_types();
