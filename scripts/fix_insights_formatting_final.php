<?php
/**
 * Final comprehensive formatting fix for all insights articles
 * Properly rebuilds HTML structure from content
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 FINAL FORMATTING FIX FOR ALL INSIGHTS ARTICLES\n";
echo "=================================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Remove all existing wrappers and structure
    $content = preg_replace('/<main[^>]*>.*?<section[^>]*>.*?<div class="section__content">/is', '', $content);
    $content = preg_replace('/<\/div>\s*<\/section>\s*<\/main>.*$/is', '', $content);
    
    // Remove schema scripts
    $content = preg_replace('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>.*?<\/script>/is', '', $content);
    
    // Remove PHP tags
    $content = preg_replace('/<\?php.*?\?>/s', '', $content);
    
    // Remove old window structure
    $content = preg_replace('/<div class="window"[^>]*>.*?<div class="title-bar">.*?<\/div>/is', '', $content);
    $content = preg_replace('/<div class="window-body">/i', '', $content);
    
    // Remove broken/empty divs
    $content = preg_replace('/<div[^>]*>\s*<\/div>/i', '', $content);
    $content = preg_replace('/<div class="content-block__body">\s*<\/div>/i', '', $content);
    $content = preg_replace('/<div class="content-block__header">\s*<\/div>/i', '', $content);
    
    // Extract all headings and their following content
    preg_match_all('/(<h[12][^>]*>.*?<\/h[12]>)([\s\S]*?)(?=<h[12]|$)/i', $content, $matches, PREG_SET_ORDER);
    
    if (empty($matches)) {
        // Try to find any content
        if (preg_match('/(<h[12][^>]*>.*)/s', $content, $single_match)) {
            $content = $single_match[1];
            $matches = [['', $content, '']];
        }
    }
    
    // Rebuild with proper structure
    $output = "<main role=\"main\" class=\"container\">\n";
    $output .= "<section class=\"section\">\n";
    $output .= "  <div class=\"section__content\">\n";
    
    foreach ($matches as $match) {
        $heading = trim($match[1] ?? '');
        $body_content = trim($match[2] ?? '');
        
        if (empty($heading)) continue;
        
        // Extract heading text and level
        if (preg_match('/<h([12])[^>]*>(.*?)<\/h[12]>/is', $heading, $h_match)) {
            $level = $h_match[1];
            $text = strip_tags($h_match[2]);
            
            $output .= "    <div class=\"content-block module\">\n";
            $output .= "      <div class=\"content-block__header\">\n";
            $output .= "        <h{$level} class=\"content-block__title\">" . htmlspecialchars(trim($text)) . "</h{$level}>\n";
            $output .= "      </div>\n";
            $output .= "      <div class=\"content-block__body\">\n";
            
            // Clean up body content
            $body_content = preg_replace('/<div[^>]*class="content-block[^"]*"[^>]*>/i', '', $body_content);
            $body_content = preg_replace('/<\/div>/i', '', $body_content);
            $body_content = preg_replace('/^\s*<\/div>\s*/', '', $body_content);
            $body_content = trim($body_content);
            
            if (!empty($body_content)) {
                // Indent body content
                $body_lines = explode("\n", $body_content);
                foreach ($body_lines as $line) {
                    $line = trim($line);
                    if (!empty($line)) {
                        $output .= "        " . $line . "\n";
                    }
                }
            }
            
            $output .= "      </div>\n";
            $output .= "    </div>\n";
        }
    }
    
    $output .= "  </div>\n";
    $output .= "</section>\n";
    $output .= "</main>\n";
    
    // Clean up
    $output = preg_replace('/\n{3,}/', "\n\n", $output);
    $output = preg_replace('/\s+<\/div>/', '</div>', $output);
    
    if ($output !== $original_content) {
        file_put_contents($file, $output);
        echo "✅ Fixed: $filename\n";
        $fixed_count++;
    } else {
        echo "⏭️  Skipped: $filename\n";
    }
}

echo "\n📊 Fixed: $fixed_count files\n";
echo "✅ All insights articles formatted!\n";



