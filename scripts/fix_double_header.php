<?php
/**
 * Remove head.php and header.php includes from individual article files
 * since router.php render_page() already includes them
 */

$insightsDir = __DIR__ . '/../pages/insights/';
$files = glob($insightsDir . '*.php');

$fixed = 0;

foreach ($files as $file) {
    $basename = basename($file);
    
    // Skip article.php router itself
    if ($basename === 'article.php' || $basename === 'goldmine-google-title-selection.php') {
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Remove the <?php and head/header includes from the beginning
    $pattern = '/^<\?php\s+require_once __DIR__ \. \'\/\.\.\/\.\.\/templates\/head\.php\'\;\s+require_once __DIR__ \. \'\/\.\.\/\.\.\/templates\/header\.php\'\;\s+\?>\s*/s';
    $content = preg_replace($pattern, '', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "✓ Fixed head/header: $basename\n";
        $fixed++;
    }
}

echo "\n=================\n";
echo "Fixed: $fixed files\n";
echo "=================\n";


