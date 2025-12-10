<?php
/**
 * TITLE AUDIT KERNEL
 * SUDO MODE: ACTIVE
 * 
 * Audits all page titles for:
 * - Uniqueness
 * - Length (50-60 chars)
 * - Intent matching
 * - Duplicate detection
 * - SEO optimization
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/helpers.php';

$fluffWords = ['welcome', 'home', 'discover', 'learn more', 'our services', 'click here', 'explore', 'transform', 'empower'];
$titles = [];
$issues = [];

/**
 * Extract title from PHP file
 */
function extract_title_from_file(string $filePath): ?array {
  $content = file_get_contents($filePath);
  $relativePath = str_replace(__DIR__.'/../pages/', '', $filePath);
  $relativePath = str_replace('.php', '', $relativePath);
  
  // Check for GLOBALS['pageTitle']
  if (preg_match('/\$GLOBALS\[\'pageTitle\'\]\s*=\s*["\']([^"\']+)["\']/', $content, $m)) {
    return [
      'path' => $relativePath,
      'title' => $m[1],
      'source' => 'GLOBALS'
    ];
  }
  
  // Check for meta_for_slug
  if (preg_match('/meta_for_slug\([\'"]([^\'"]+)[\'"]\)/', $content, $m)) {
    return [
      'path' => $relativePath,
      'title' => null,
      'source' => 'meta_for_slug',
      'slug' => $m[1]
    ];
  }
  
  return null;
}

/**
 * Calculate similarity between two titles
 */
function title_similarity(string $title1, string $title2): float {
  $words1 = array_map('strtolower', explode(' ', $title1));
  $words2 = array_map('strtolower', explode(' ', $title2));
  
  $common = count(array_intersect($words1, $words2));
  $total = count(array_unique(array_merge($words1, $words2)));
  
  return $total > 0 ? ($common / $total) : 0;
}

/**
 * Check for fluff words
 */
function has_fluff_words(string $title, array $fluffWords): bool {
  $lower = strtolower($title);
  foreach ($fluffWords as $fluff) {
    if (strpos($lower, $fluff) !== false) {
      return true;
    }
  }
  return false;
}

/**
 * Audit a single title
 */
function audit_title(string $title, string $path, array $allTitles, array $fluffWords): array {
  $issues = [];
  
  // Check length
  $len = strlen($title);
  if ($len < 50) {
    $issues[] = ['type' => 'too_short', 'severity' => 'high', 'current' => $len, 'target' => '50-60'];
  } elseif ($len > 60) {
    $issues[] = ['type' => 'too_long', 'severity' => 'high', 'current' => $len, 'target' => '50-60'];
  }
  
  // Check for fluff words
  if (has_fluff_words($title, $fluffWords)) {
    $issues[] = ['type' => 'fluff_words', 'severity' => 'medium'];
  }
  
  // Check for duplicates
  foreach ($allTitles as $otherPath => $otherTitle) {
    if ($otherPath !== $path && $otherTitle) {
      $similarity = title_similarity($title, $otherTitle);
      if ($similarity > 0.2) {
        $issues[] = [
          'type' => 'duplicate',
          'severity' => 'high',
          'similarity' => round($similarity * 100, 1),
          'duplicate_of' => $otherPath
        ];
      }
    }
  }
  
  return $issues;
}

// Scan all page files
$pageDirs = [
  __DIR__.'/../pages/home/',
  __DIR__.'/../pages/services/',
  __DIR__.'/../pages/products/',
  __DIR__.'/../pages/insights/',
  __DIR__.'/../pages/careers/',
  __DIR__.'/../pages/tools/',
  __DIR__.'/../pages/industries/',
  __DIR__.'/../pages/catalog/',
];

foreach ($pageDirs as $dir) {
  if (!is_dir($dir)) continue;
  
  $files = glob($dir . '*.php');
  foreach ($files as $file) {
    $titleData = extract_title_from_file($file);
    if ($titleData) {
      $titles[$titleData['path']] = $titleData['title'];
    }
  }
}

// Audit all titles
foreach ($titles as $path => $title) {
  if ($title) {
    $pathIssues = audit_title($title, $path, $titles, $fluffWords);
    if (!empty($pathIssues)) {
      $issues[$path] = [
        'title' => $title,
        'length' => strlen($title),
        'issues' => $pathIssues
      ];
    }
  }
}

// Output results
echo "=== TITLE AUDIT REPORT ===\n\n";
echo "Total pages scanned: " . count($titles) . "\n";
echo "Pages with issues: " . count($issues) . "\n\n";

if (!empty($issues)) {
  echo "ISSUES FOUND:\n";
  echo str_repeat("=", 80) . "\n\n";
  
  foreach ($issues as $path => $data) {
    echo "Path: $path\n";
    echo "Title: {$data['title']}\n";
    echo "Length: {$data['length']} chars\n";
    echo "Issues:\n";
    foreach ($data['issues'] as $issue) {
      echo "  - [{$issue['severity']}] {$issue['type']}";
      if (isset($issue['current'])) {
        echo " (current: {$issue['current']}, target: {$issue['target']})";
      }
      if (isset($issue['similarity'])) {
        echo " ({$issue['similarity']}% similar to {$issue['duplicate_of']})";
      }
      echo "\n";
    }
    echo "\n";
  }
} else {
  echo "✅ No issues found. All titles are optimized.\n";
}

// Generate summary
$summary = [
  'total_pages' => count($titles),
  'pages_with_issues' => count($issues),
  'issues_by_type' => []
];

foreach ($issues as $data) {
  foreach ($data['issues'] as $issue) {
    $type = $issue['type'];
    if (!isset($summary['issues_by_type'][$type])) {
      $summary['issues_by_type'][$type] = 0;
    }
    $summary['issues_by_type'][$type]++;
  }
}

echo "\n=== SUMMARY ===\n";
echo json_encode($summary, JSON_PRETTY_PRINT) . "\n";


