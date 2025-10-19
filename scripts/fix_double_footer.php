<?php
/**
 * Fix double footer issue by removing footer.php includes from individual article files
 * since router.php render_page() already includes it
 */

$insightsDir = __DIR__ . '/../pages/insights/';
$files = glob($insightsDir . '*.php');

$fixed = 0;
$skipped = 0;

foreach ($files as $file) {
    $basename = basename($file);
    
    // Skip article.php router itself
    if ($basename === 'article.php') {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Check if file has footer include
    if (strpos($content, "require_once __DIR__ . '/../../templates/footer.php'") !== false ||
        strpos($content, 'require_once __DIR__ . \'/../../templates/footer.php\'') !== false) {
        
        // Replace footer include with comment
        $newContent = preg_replace(
            '/\<\?php\s+require_once __DIR__ \. \'\/\.\.\/\.\.\/templates\/footer\.php\'\;\s+\?\>/',
            '<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>',
            $content
        );
        
        if ($newContent !== $content) {
            file_put_contents($file, $newContent);
            echo "✓ Fixed: $basename\n";
            $fixed++;
        } else {
            echo "⚠ Could not auto-fix: $basename (manual review needed)\n";
            $skipped++;
        }
    }
}

echo "\n=================\n";
echo "Fixed: $fixed files\n";
echo "Skipped: $skipped files\n";
echo "=================\n";


