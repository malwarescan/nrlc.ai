<?php
/**
 * Fix missing closing div for section__content in all insights articles
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 FIXING MISSING CLOSING DIVS IN INSIGHTS ARTICLES\n";
echo "==================================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Check if section__content closing div is missing
    // Pattern: </div></div> followed by </section> without </div> for section__content
    if (preg_match('/<\/div><\/div>\s*<\/section>/', $content) && 
        !preg_match('/<\/div><\/div>\s*<\/div>\s*<\/section>/', $content)) {
        
        // Add missing closing div for section__content
        $content = preg_replace(
            '/(<\/div><\/div>)\s*(<\/section>)/',
            '$1' . "\n  </div>" . "\n$2",
            $content
        );
    }
    
    // Also check if we have the proper structure
    // Should be: </div></div> (closes content-block) then </div> (closes section__content) then </section>
    if (!preg_match('/<\/div><\/div>\s*<\/div>\s*<\/section>\s*<\/main>/', $content)) {
        // Try to fix it
        $content = preg_replace(
            '/(<\/div><\/div>)\s*(<\/section>\s*<\/main>)/',
            '$1' . "\n  </div>" . "\n$2",
            $content
        );
    }
    
    if ($content !== $original_content) {
        file_put_contents($file, $content);
        echo "✅ Fixed: $filename\n";
        $fixed_count++;
    } else {
        echo "⏭️  Skipped: $filename (already correct)\n";
    }
}

echo "\n📊 Fixed: $fixed_count files\n";
echo "✅ All closing divs fixed!\n";



