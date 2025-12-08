<?php
/**
 * Fix formatting across all insights articles
 * Ensures consistent structure, proper content-block usage, and uniform styling
 */

declare(strict_types=1);
require_once __DIR__ . '/../lib/helpers.php';

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

// Skip index.php and article.php
$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔍 FIXING FORMATTING FOR ALL INSIGHTS ARTICLES\n";
echo "==============================================\n\n";

$fixed_count = 0;
$skipped_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // 1. Ensure proper main/section structure
    // Replace old window-based structure with new content-block structure
    if (preg_match('/<main[^>]*>/', $content) && !preg_match('/<main[^>]*>[\s\S]*?<section[^>]*class=["\']section["\']/', $content)) {
        // Wrap content in proper section structure
        $content = preg_replace(
            '/<main[^>]*>([\s\S]*?)<\/main>/',
            '<main role="main" class="container">' . "\n" . '<section class="section">' . "\n" . '  <div class="section__content">' . "\n" . '$1' . "\n" . '  </div>' . "\n" . '</section>' . "\n" . '</main>',
            $content
        );
    }
    
    // 2. Convert old window-based content blocks to new content-block structure
    // Replace <div class="window"> with <div class="content-block module">
    $content = preg_replace(
        '/<div class="window"[^>]*>/i',
        '<div class="content-block module">',
        $content
    );
    
    // Remove title-bar divs (redundant with content-block__header)
    $content = preg_replace(
        '/<div class="title-bar">[\s\S]*?<\/div>/i',
        '',
        $content
    );
    
    // Convert window-body to content-block__body
    $content = preg_replace(
        '/<div class="window-body">/i',
        '<div class="content-block__body">',
        $content
    );
    
    // 3. Fix H1 formatting - ensure consistent styling
    $content = preg_replace(
        '/<h1[^>]*style="[^"]*"[^>]*>/i',
        '<h1 class="content-block__title">',
        $content
    );
    
    // Wrap H1 in content-block__header if not already wrapped
    if (preg_match('/<h1[^>]*>/', $content) && !preg_match('/<div class="content-block__header">[\s\S]*?<h1/', $content)) {
        $content = preg_replace(
            '/(<h1[^>]*>.*?<\/h1>)/s',
            '<div class="content-block__header">$1</div>',
            $content
        );
    }
    
    // 4. Fix H2 formatting - ensure they're in content-block__header
    // Find H2s that aren't in content-block__header
    $content = preg_replace_callback(
        '/(<h2[^>]*>.*?<\/h2>)/s',
        function($matches) {
            $h2 = $matches[1];
            // Check if already in content-block__header
            if (preg_match('/<div class="content-block__header">[\s\S]*?' . preg_quote($h2, '/') . '/', $matches[0])) {
                return $h2;
            }
            // Wrap in content-block module if not already
            return '<div class="content-block module">' . "\n" . '  <div class="content-block__header">' . $h2 . '</div>' . "\n" . '  <div class="content-block__body">';
        },
        $content
    );
    
    // 5. Fix lead paragraph formatting
    $content = preg_replace(
        '/<p class="lead"[^>]*style="[^"]*"[^>]*>/i',
        '<p class="lead">',
        $content
    );
    
    // 6. Ensure proper closing tags for content-block structure
    // Close any unclosed content-block__body divs before next content-block
    $content = preg_replace(
        '/(<div class="content-block__body">[\s\S]*?)(<div class="content-block module">)/',
        '$1  </div>' . "\n" . '</div>' . "\n" . '$2',
        $content
    );
    
    // 7. Fix inline styles on H2/H3 - remove and use classes instead
    $content = preg_replace(
        '/<h([23])[^>]*style="[^"]*color:\s*#000080[^"]*"[^>]*>/i',
        '<h$1 class="content-block__title">',
        $content
    );
    
    // 8. Ensure all content is within proper content-block structure
    // Wrap loose paragraphs and content in content-block if needed
    if (preg_match('/<div class="content-block__body">/', $content)) {
        // Ensure proper nesting
        $content = preg_replace(
            '/(<\/div>\s*<\/div>\s*<\/section>\s*<\/main>)/',
            '  </div>' . "\n" . '</div>' . "\n" . '$1',
            $content
        );
    }
    
    // 9. Remove redundant spacing and normalize line breaks
    $content = preg_replace('/\n{3,}/', "\n\n", $content);
    
    // 10. Ensure proper container structure
    if (!preg_match('/<main[^>]*class=["\']container["\']/', $content)) {
        $content = preg_replace(
            '/<main[^>]*>/',
            '<main role="main" class="container">',
            $content
        );
    }
    
    if ($content !== $original_content) {
        file_put_contents($file, $content);
        echo "✅ Fixed: $filename\n";
        $fixed_count++;
    } else {
        echo "⏭️  Skipped: $filename (already formatted)\n";
        $skipped_count++;
    }
}

echo "\n";
echo "📊 SUMMARY\n";
echo "==========\n";
echo "Fixed: $fixed_count files\n";
echo "Skipped: $skipped_count files\n";
echo "\n✅ All insights articles now have consistent formatting!\n";


