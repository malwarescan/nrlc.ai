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
  
  // Add styling to h2 elements
  $content = preg_replace(
    '/(<h2>)([^<]+)(<\/h2>)/',
    '$1 style="color: #000080;">$2$3',
    $content
  );
  
  // Add styling to h3 elements
  $content = preg_replace(
    '/(<h3>)([^<]+)(<\/h3>)/',
    '$1 style="margin-top: 0; color: #000080;">$2$3',
    $content
  );
  
  file_put_contents($file, $content);
  echo "Fixed $filename - added header styling\n";
}

echo "Done!\n";
?>
