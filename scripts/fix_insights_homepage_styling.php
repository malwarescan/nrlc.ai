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
  
  // Skip if already has correct styling
  if (strpos($content, 'style="margin-bottom: 2rem;"') !== false) {
    echo "Skipping $filename - already has correct styling\n";
    continue;
  }
  
  // Add margin-bottom to window div
  $content = preg_replace(
    '/(<div class="window prose">)/',
    '$1 style="margin-bottom: 2rem;"',
    $content
  );
  
  // Add homepage styling to h1
  $content = preg_replace(
    '/(<h1>)([^<]+)(<\/h1>)/',
    '<h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">$2$3',
    $content
  );
  
  // Add homepage styling to lead paragraph
  $content = preg_replace(
    '/(<p class="lead">)([^<]+)(<\/p>)/',
    '<p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">$2$3',
    $content
  );
  
  file_put_contents($file, $content);
  echo "Fixed $filename\n";
}

echo "Done!\n";
?>
