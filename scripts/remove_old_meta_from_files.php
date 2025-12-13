<?php
declare(strict_types=1);

/**
 * Remove old placeholder metadata from individual numbered files
 * These files are rendered through router which sets metadata via ctx-based system
 */

$patterns = [
  // Blog posts
  [
    'glob' => 'pages/blog/blog-post-*.php',
    'old_title' => '/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s',
    'old_desc' => '/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s'
  ],
  // Case studies
  [
    'glob' => 'pages/case-studies/case-study-*.php',
    'old_title' => '/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s',
    'old_desc' => '/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s'
  ],
  // Resources
  [
    'glob' => 'pages/resources/resource-*.php',
    'old_title' => '/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s',
    'old_desc' => '/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s'
  ],
  // Tools (individual files)
  [
    'glob' => 'pages/tools/*.php',
    'exclude' => ['tool.php', 'index.php'],
    'old_title' => '/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s',
    'old_desc' => '/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s'
  ],
  // Industries
  [
    'glob' => 'pages/industries/*.php',
    'exclude' => ['industry.php', 'index.php'],
    'old_title' => '/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s',
    'old_desc' => '/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"][^\'"]*[\'"]\s*;/s'
  ]
];

$total = 0;
$modified = 0;

foreach ($patterns as $pattern) {
  $files = glob(__DIR__.'/../'.$pattern['glob']);
  $exclude = $pattern['exclude'] ?? [];
  
  foreach ($files as $file) {
    $basename = basename($file);
    if (in_array($basename, $exclude)) {
      continue;
    }
    
    $total++;
    $content = file_get_contents($file);
    $original = $content;
    
    // Remove old title
    $content = preg_replace($pattern['old_title'], '// Metadata set by router via ctx-based system', $content);
    
    // Remove old description
    $content = preg_replace($pattern['old_desc'], '', $content);
    
    if ($content !== $original) {
      file_put_contents($file, $content);
      $modified++;
      echo "Modified: $file\n";
    }
  }
}

echo "\nTotal files scanned: $total\n";
echo "Files modified: $modified\n";
echo "\nNote: These files are rendered through router which sets metadata via ctx-based system.\n";
echo "Old metadata assignments have been removed to prevent conflicts.\n";

