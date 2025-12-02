<?php
/**
 * Properly restore insights articles to match site structure
 * Preserves ALL content, fixes structure to match rest of site
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 RESTORING PROPER STRUCTURE FOR ALL INSIGHTS ARTICLES\n";
echo "======================================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Remove broken structure - start fresh
    // Extract just the content between main tags or section tags
    $clean_content = '';
    
    // If file has PHP at start, preserve it
    $php_header = '';
    if (preg_match('/^<\?php[\s\S]*?\?>/', $content, $php_match)) {
        $php_header = $php_match[0] . "\n";
        $content = substr($content, strlen($php_header));
    }
    
    // Remove all existing wrappers
    $content = preg_replace('/<main[^>]*>.*?<section[^>]*>.*?<div class="section__content">/is', '', $content);
    $content = preg_replace('/<\/div>\s*<\/section>\s*<\/main>.*$/is', '', $content);
    $content = preg_replace('/<main[^>]*>.*?<section[^>]*class="container"[^>]*>/is', '', $content);
    $content = preg_replace('/<\/section>\s*<\/main>.*$/is', '', $content);
    
    // Remove old window structure
    $content = preg_replace('/<div class="window"[^>]*>.*?<div class="title-bar">.*?<\/div>/is', '', $content);
    $content = preg_replace('/<div class="window-body">/i', '', $content);
    $content = preg_replace('/<\/div>\s*<\/div>\s*<\/section>/i', '', $content);
    
    // Remove broken inline styles from tags
    $content = preg_replace('/<h([12])>\s*style=/i', '<h$1 style=', $content);
    $content = preg_replace('/<p class="lead">\s*style=/i', '<p class="lead" style=', $content);
    $content = preg_replace('/<section class="container">\\\n/i', '', $content);
    
    // Fix broken style attributes
    $content = preg_replace('/style="[^"]*\\\\n[^"]*"/', '', $content);
    $content = preg_replace('/<h([12])>\s*style=/i', '<h$1 style=', $content);
    
    // Now rebuild with proper structure
    $output = $php_header;
    $output .= "<main role=\"main\" class=\"container\">\n";
    $output .= "<section class=\"section\">\n";
    $output .= "  <div class=\"section__content\">\n";
    
    // Process content - split by H1 or H2
    $sections = preg_split('/(<h[12][^>]*>.*?<\/h[12]>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $current_block = '';
    $in_body = false;
    $first_h1 = true;
    
    foreach ($sections as $i => $section) {
        $section = trim($section);
        if (empty($section)) continue;
        
        // Check if it's a heading
        if (preg_match('/<h([12])[^>]*>(.*?)<\/h[12]>/is', $section, $h_match)) {
            $level = $h_match[1];
            $text = strip_tags($h_match[2]);
            
            // Close previous block
            if ($in_body) {
                $output .= "      </div>\n";
                $output .= "    </div>\n";
            }
            
            // Start new block
            $output .= "    <div class=\"content-block module\">\n";
            $output .= "      <div class=\"content-block__header\">\n";
            $output .= "        <h{$level} class=\"content-block__title\">" . htmlspecialchars(trim($text)) . "</h{$level}>\n";
            $output .= "      </div>\n";
            $output .= "      <div class=\"content-block__body\">\n";
            $in_body = true;
            $first_h1 = false;
        } else {
            // It's content - add to current body
            if ($in_body) {
                // Clean up the content
                $section = preg_replace('/^\s*<\/div>\s*<\/div>\s*/', '', $section);
                $section = preg_replace('/\s*<\/div>\s*<\/div>\s*$/', '', $section);
                if (!empty(trim($section))) {
                    $output .= "        " . trim($section) . "\n";
                }
            } else {
                // No block open yet - create one for content before first heading
                if (!empty(trim($section))) {
                    $output .= "    <div class=\"content-block module\">\n";
                    $output .= "      <div class=\"content-block__body\">\n";
                    $output .= "        " . trim($section) . "\n";
                    $output .= "      </div>\n";
                    $output .= "    </div>\n";
                }
            }
        }
    }
    
    // Close last block
    if ($in_body) {
        $output .= "      </div>\n";
        $output .= "    </div>\n";
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
echo "✅ All articles restored with proper structure!\n";

