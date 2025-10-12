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
  
  // Skip if already has correct structure
  if (strpos($content, '<section class="container">') !== false) {
    echo "Skipping $filename - already has correct container structure\n";
    continue;
  }
  
  // Fix the container structure
  $content = preg_replace(
    '/(<main role="main">\s*)<section class="window container prose">/',
    '$1<section class="container">\n  <div class="window prose">',
    $content
  );
  
  // Fix the closing tags
  $content = preg_replace(
    '/(<\/section>)\s*(<\/main>)/',
    '  </div>\n$1\n$2',
    $content
  );
  
  file_put_contents($file, $content);
  echo "Fixed $filename\n";
}

echo "Done!\n";
?>
