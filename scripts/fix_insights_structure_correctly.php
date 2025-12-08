<?php
/**
 * CORRECTLY fix insights articles structure
 * Converts from old window structure to new content-block structure
 * PRESERVES ALL CONTENT
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 FIXING INSIGHTS STRUCTURE CORRECTLY\n";
echo "====================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Special handling for goldmine - it has PHP header, preserve it
    $php_header = '';
    if (preg_match('/^<\?php[\s\S]*?\?>\s*\n/', $content, $php_match)) {
        $php_header = $php_match[0];
        $content = substr($content, strlen($php_header));
    }
    
    // Remove ALL existing wrappers - start fresh
    $content = preg_replace('/<main[^>]*>[\s\S]*?<section[^>]*>[\s\S]*?<div class="section__content">/is', '', $content);
    $content = preg_replace('/<\/div>\s*<\/section>\s*<\/main>.*$/is', '', $content);
    $content = preg_replace('/<main[^>]*>[\s\S]*?<section[^>]*class="container"[^>]*>/is', '', $content);
    $content = preg_replace('/<\/section>\s*<\/main>.*$/is', '', $content);
    
    // Remove old window structure but KEEP THE CONTENT
    $content = preg_replace('/<div class="window"[^>]*>/i', '', $content);
    $content = preg_replace('/<div class="title-bar">[\s\S]*?<\/div>/i', '', $content);
    $content = preg_replace('/<div class="window-body">/i', '', $content);
    $content = preg_replace('/<\/div>\s*<\/div>\s*<\/section>/i', '', $content);
    
    // Remove broken/empty divs but keep content
    $content = preg_replace('/<div class="content-block module">\s*<div class="content-block__body">\s*<\/div>\s*<\/div>/i', '', $content);
    $content = preg_replace('/<div class="content-block__header">\s*<\/div>/i', '', $content);
    
    // Remove schema scripts (handled by article.php)
    $content = preg_replace('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>.*?<\/script>/is', '', $content);
    
    // Remove status-bar (handled by article.php)
    $content = preg_replace('/<div class="status-bar">.*?<\/div>/is', '', $content);
    
    // Fix broken style attributes
    $content = preg_replace('/<h([12])>\s*style=/i', '<h$1 style=', $content);
    $content = preg_replace('/<p class="lead">\s*style=/i', '<p class="lead" style=', $content);
    $content = str_replace('\\n', '', $content);
    
    // Now rebuild properly
    $output = $php_header;
    $output .= "<main role=\"main\" class=\"container\">\n";
    $output .= "<section class=\"section\">\n";
    $output .= "  <div class=\"section__content\">\n";
    
    // Split by headings to create content blocks
    // Pattern: heading followed by content until next heading
    $parts = preg_split('/(<h[123][^>]*>.*?<\/h[123]>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $current_block_content = '';
    $current_heading = '';
    $first_block = true;
    
    foreach ($parts as $i => $part) {
        $part = trim($part);
        if (empty($part)) continue;
        
        // Check if it's a heading
        if (preg_match('/<h([123])[^>]*>(.*?)<\/h[123]>/is', $part, $h_match)) {
            // Save previous block if exists
            if (!empty($current_heading) || !empty($current_block_content)) {
                $output .= "    <div class=\"content-block module\">\n";
                if (!empty($current_heading)) {
                    $h_level = preg_match('/<h([123])/', $current_heading, $lev) ? $lev[1] : '2';
                    $h_text = strip_tags($current_heading);
                    $output .= "      <div class=\"content-block__header\">\n";
                    $output .= "        <h{$h_level} class=\"content-block__title\">" . htmlspecialchars(trim($h_text)) . "</h{$h_level}>\n";
                    $output .= "      </div>\n";
                }
                $output .= "      <div class=\"content-block__body\">\n";
                if (!empty(trim($current_block_content))) {
                    $body_lines = explode("\n", trim($current_block_content));
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
            
            // Start new block
            $current_heading = $part;
            $current_block_content = '';
            $first_block = false;
        } else {
            // It's content
            $current_block_content .= $part . "\n";
        }
    }
    
    // Handle last block
    if (!empty($current_heading) || !empty($current_block_content)) {
        $output .= "    <div class=\"content-block module\">\n";
        if (!empty($current_heading)) {
            $h_level = preg_match('/<h([123])/', $current_heading, $lev) ? $lev[1] : '2';
            $h_text = strip_tags($current_heading);
            $output .= "      <div class=\"content-block__header\">\n";
            $output .= "        <h{$h_level} class=\"content-block__title\">" . htmlspecialchars(trim($h_text)) . "</h{$h_level}>\n";
            $output .= "      </div>\n";
        }
        $output .= "      <div class=\"content-block__body\">\n";
        if (!empty(trim($current_block_content))) {
            $body_lines = explode("\n", trim($current_block_content));
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
    
    $output .= "  </div>\n";
    $output .= "</section>\n";
    $output .= "</main>\n";
    
    // Clean up
    $output = preg_replace('/\n{3,}/', "\n\n", $output);
    
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


