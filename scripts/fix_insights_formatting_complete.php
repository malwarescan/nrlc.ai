<?php
/**
 * Complete formatting fix for all insights articles
 * Converts all articles to proper content-block structure
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 COMPLETE FORMATTING FIX FOR ALL INSIGHTS ARTICLES\n";
echo "====================================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Remove any existing schema scripts (they'll be added by article.php)
    $content = preg_replace('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>.*?<\/script>/is', '', $content);
    
    // Remove PHP closing tag if present
    $content = preg_replace('/\?>\s*$/', '', $content);
    
    // Remove any existing main/section wrappers
    $content = preg_replace('/<main[^>]*>[\s\S]*?<section[^>]*>[\s\S]*?<div class="section__content">/i', '', $content);
    $content = preg_replace('/<\/div>\s*<\/section>\s*<\/main>/i', '', $content);
    
    // Remove old window structure completely
    $content = preg_replace('/<div class="window"[^>]*>[\s\S]*?<div class="title-bar">[\s\S]*?<\/div>/i', '', $content);
    $content = preg_replace('/<div class="window-body">/i', '', $content);
    $content = preg_replace('/<\/div>\s*<\/div>\s*<\/section>/i', '', $content);
    
    // Remove any broken content-block structures
    $content = preg_replace('/<div class="content-block module">\s*<\/div>/i', '', $content);
    $content = preg_replace('/<div class="content-block__body">\s*<\/div>/i', '', $content);
    
    // Extract the actual content (everything that's not a wrapper)
    // Find the first H1 or H2 to start
    if (preg_match('/(<h[12][^>]*>.*)/s', $content, $matches)) {
        $content = $matches[1];
    }
    
    // Now rebuild with proper structure
    $output = "<main role=\"main\" class=\"container\">\n";
    $output .= "<section class=\"section\">\n";
    $output .= "  <div class=\"section__content\">\n";
    
    // Split content by H2 headings to create content blocks
    $sections = preg_split('/(<h2[^>]*>.*?<\/h2>)/s', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $current_block = '';
    $in_block = false;
    
    foreach ($sections as $section) {
        $section = trim($section);
        if (empty($section)) continue;
        
        // If it's an H2, start a new content block
        if (preg_match('/<h2[^>]*>(.*?)<\/h2>/s', $section, $h2_match)) {
            // Close previous block if open
            if ($in_block) {
                $output .= "    </div>\n";
                $output .= "  </div>\n";
            }
            
            // Start new block
            $h2_text = strip_tags($h2_match[1]);
            $output .= "    <div class=\"content-block module\">\n";
            $output .= "      <div class=\"content-block__header\">\n";
            $output .= "        <h2 class=\"content-block__title\">" . htmlspecialchars($h2_text) . "</h2>\n";
            $output .= "      </div>\n";
            $output .= "      <div class=\"content-block__body\">\n";
            $in_block = true;
            $current_block = '';
        } 
        // If it's an H1, create a hero block
        elseif (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $section, $h1_match)) {
            // Close previous block if open
            if ($in_block) {
                $output .= "    </div>\n";
                $output .= "  </div>\n";
                $in_block = false;
            }
            
            $h1_text = strip_tags($h1_match[1]);
            $output .= "    <div class=\"content-block module\">\n";
            $output .= "      <div class=\"content-block__header\">\n";
            $output .= "        <h1 class=\"content-block__title\">" . htmlspecialchars($h1_text) . "</h1>\n";
            $output .= "      </div>\n";
            $output .= "      <div class=\"content-block__body\">\n";
            $in_block = true;
            
            // Get content after H1
            $after_h1 = preg_replace('/<h1[^>]*>.*?<\/h1>/s', '', $section);
            if (!empty(trim($after_h1))) {
                $output .= "        " . trim($after_h1) . "\n";
            }
        }
        // Otherwise, it's content for the current block
        else {
            if ($in_block) {
                $output .= "        " . trim($section) . "\n";
            } else {
                // If no block is open, create one
                $output .= "    <div class=\"content-block module\">\n";
                $output .= "      <div class=\"content-block__body\">\n";
                $output .= "        " . trim($section) . "\n";
                $in_block = true;
            }
        }
    }
    
    // Close last block
    if ($in_block) {
        $output .= "      </div>\n";
        $output .= "    </div>\n";
    }
    
    // Remove status-bar and navigation (handled by article.php)
    $output = preg_replace('/<div class="status-bar">.*?<\/div>/is', '', $output);
    
    $output .= "  </div>\n";
    $output .= "</section>\n";
    $output .= "</main>\n";
    
    // Clean up extra whitespace
    $output = preg_replace('/\n{3,}/', "\n\n", $output);
    
    if ($output !== $original_content) {
        file_put_contents($file, $output);
        echo "✅ Fixed: $filename\n";
        $fixed_count++;
    } else {
        echo "⏭️  Skipped: $filename (no changes needed)\n";
    }
}

echo "\n";
echo "📊 SUMMARY\n";
echo "==========\n";
echo "Fixed: $fixed_count files\n";
echo "\n✅ All insights articles now have proper formatting!\n";

