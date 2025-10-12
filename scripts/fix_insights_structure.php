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
  
  // Skip if already has main wrapper
  if (strpos($content, '<main role="main">') !== false) {
    echo "Skipping $filename - already has main wrapper\n";
    continue;
  }
  
  // Add main wrapper after header
  $content = preg_replace(
    '/(<\?php\s*require_once[^;]+header\.php[^;]+;\s*\?>)\s*<section class="window container prose">/',
    '$1

<main role="main">
<section class="window container prose">',
    $content
  );
  
  // Add closing tags and footer
  $content = preg_replace(
    '/(<\/script>)\s*$/',
    '$1
</section>
</main>

<?php require_once __DIR__ . \'/../../templates/footer.php\'; ?>',
    $content
  );
  
  file_put_contents($file, $content);
  echo "Fixed $filename\n";
}

echo "Done!\n";
?>
