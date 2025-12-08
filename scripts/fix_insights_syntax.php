<?php
/**
 * Fix syntax errors in insights articles
 * Remove PHP tags and fix broken HTML structure
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 FIXING SYNTAX ERRORS IN INSIGHTS ARTICLES\n";
echo "============================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Remove PHP tags (these files should be pure HTML)
    $content = preg_replace('/<\?php.*?\?>/s', '', $content);
    
    // Remove status-bar divs (handled by article.php)
    $content = preg_replace('/<div class="status-bar[^"]*">.*?<\/div>/is', '', $content);
    $content = preg_replace('/<div class="status-bar-field[^"]*">.*?<\/div>/is', '', $content);
    
    // Fix broken closing tags - ensure proper structure
    // Remove any orphaned closing divs before </section>
    $content = preg_replace('/<\/div>\s*<\/div>\s*<\/div>\s*<\/section>/', '</div></section>', $content);
    
    // Ensure proper closing structure
    if (!preg_match('/<\/main>\s*$/', $content)) {
        // Fix any broken structure at the end
        $content = preg_replace('/<\/section>\s*<\/main>\s*.*$/s', '</section></main>', $content);
    }
    
    // Clean up extra whitespace
    $content = preg_replace('/\n{3,}/', "\n\n", $content);
    
    if ($content !== $original_content) {
        file_put_contents($file, $content);
        echo "✅ Fixed: $filename\n";
        $fixed_count++;
    } else {
        echo "⏭️  Skipped: $filename\n";
    }
}

echo "\n📊 Fixed: $fixed_count files\n";
echo "✅ All syntax errors fixed!\n";


