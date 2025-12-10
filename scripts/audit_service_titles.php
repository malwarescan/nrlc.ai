<?php
/**
 * AUDIT SERVICE TITLES FROM service_enhancements.json
 * Ensures all service page titles follow SUDO kernel rules
 */

declare(strict_types=1);

$enhancementsFile = __DIR__.'/../data/service_enhancements.json';
if (!file_exists($enhancementsFile)) {
  echo "❌ service_enhancements.json not found\n";
  exit(1);
}

$enhancements = json_decode(file_get_contents($enhancementsFile), true);
$issues = [];
$titles = [];

// Collect all titles
foreach ($enhancements as $enhancement) {
  $title = $enhancement['title'] ?? '';
  $path = $enhancement['path'] ?? '';
  if ($title) {
    $titles[$path] = $title;
  }
}

// Audit each title
foreach ($enhancements as $enhancement) {
  $title = $enhancement['title'] ?? '';
  $path = $enhancement['path'] ?? '';
  
  if (empty($title)) continue;
  
  $pathIssues = [];
  $len = strlen($title);
  
  // Check length
  if ($len < 50) {
    $pathIssues[] = ['type' => 'too_short', 'current' => $len, 'target' => '50-60'];
  } elseif ($len > 60) {
    $pathIssues[] = ['type' => 'too_long', 'current' => $len, 'target' => '50-60'];
  }
  
  // Check for duplicates
  foreach ($titles as $otherPath => $otherTitle) {
    if ($otherPath !== $path && $otherTitle) {
      $words1 = array_map('strtolower', explode(' ', $title));
      $words2 = array_map('strtolower', explode(' ', $otherTitle));
      $common = count(array_intersect($words1, $words2));
      $total = count(array_unique(array_merge($words1, $words2)));
      $similarity = $total > 0 ? ($common / $total) : 0;
      
      if ($similarity > 0.2) {
        $pathIssues[] = [
          'type' => 'duplicate',
          'similarity' => round($similarity * 100, 1),
          'duplicate_of' => $otherPath
        ];
      }
    }
  }
  
  if (!empty($pathIssues)) {
    $issues[$path] = [
      'title' => $title,
      'length' => $len,
      'issues' => $pathIssues
    ];
  }
}

// Output
echo "=== SERVICE TITLES AUDIT ===\n\n";
echo "Total service URLs: " . count($enhancements) . "\n";
echo "Service URLs with title issues: " . count($issues) . "\n\n";

if (!empty($issues)) {
  echo "ISSUES FOUND:\n";
  echo str_repeat("=", 80) . "\n\n";
  
  $count = 0;
  foreach ($issues as $path => $data) {
    if ($count++ >= 20) {
      echo "... and " . (count($issues) - 20) . " more issues\n";
      break;
    }
    echo "Path: $path\n";
    echo "Title: {$data['title']}\n";
    echo "Length: {$data['length']} chars\n";
    echo "Issues:\n";
    foreach ($data['issues'] as $issue) {
      echo "  - {$issue['type']}";
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
  echo "✅ No issues found. All service titles are optimized.\n";
}


