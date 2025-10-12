<?php
declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

foreach ($files as $file) {
  $filename = basename($file);
  if ($filename === 'index.php' || $filename === 'article.php') {
    continue; // Skip index and article files
  }
  
  $content = file_get_contents($file);
  
  // Remove prose class to match homepage styling
  $content = str_replace('class="window prose"', 'class="window"', $content);
  
  file_put_contents($file, $content);
  echo "Fixed $filename - removed prose class\n";
}

echo "Done!\n";
?>
