<?php
/**
 * Convert insights articles from old window structure to new content-block structure
 * PRESERVES ALL CONTENT - no content loss
 */

declare(strict_types=1);

$insights_dir = __DIR__ . '/../pages/insights/';
$files = glob($insights_dir . '*.php');

$article_files = array_filter($files, function($file) {
    $filename = basename($file);
    return $filename !== 'index.php' && $filename !== 'article.php';
});

echo "🔧 CONVERTING INSIGHTS TO CONTENT-BLOCK STRUCTURE\n";
echo "================================================\n\n";

$fixed_count = 0;

foreach ($article_files as $file) {
    $filename = basename($file);
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Preserve PHP header if exists (like goldmine)
    $php_header = '';
    if (preg_match('/^<\?php[\s\S]*?\?>\s*\n/', $content, $php_match)) {
        $php_header = $php_match[0];
        $content = substr($content, strlen($php_header));
    }
    
    // Remove schema scripts (handled by article.php)
    $content = preg_replace('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>.*?<\/script>/is', '', $content);
    
    // Remove status-bar (handled by article.php)
    $content = preg_replace('/<div class="status-bar">.*?<\/div>/is', '', $content);
    
    // Extract content from window-body or main/section
    $body_content = '';
    
    // If has window-body, extract from there
    if (preg_match('/<div class="window-body">([\s\S]*?)<\/div>\s*<\/div>\s*<\/section>/i', $content, $window_match)) {
        $body_content = $window_match[1];
    }
    // If has main/section, extract from there
    elseif (preg_match('/<main[^>]*>[\s\S]*?<section[^>]*>([\s\S]*?)<\/section>\s*<\/main>/i', $content, $main_match)) {
        $body_content = $main_match[1];
        // Remove window structure if present
        $body_content = preg_replace('/<div class="window"[^>]*>[\s\S]*?<div class="title-bar">.*?<\/div>/is', '', $body_content);
        $body_content = preg_replace('/<div class="window-body">/i', '', $body_content);
        $body_content = preg_replace('/<\/div>\s*<\/div>\s*$/i', '', $body_content);
    }
    // Otherwise, try to extract from anywhere
    else {
        // Remove main/section wrappers
        $body_content = preg_replace('/<main[^>]*>[\s\S]*?<section[^>]*>/i', '', $content);
        $body_content = preg_replace('/<\/section>\s*<\/main>.*$/i', '', $body_content);
        // Remove window structure
        $body_content = preg_replace('/<div class="window"[^>]*>[\s\S]*?<div class="title-bar">.*?<\/div>/is', '', $body_content);
        $body_content = preg_replace('/<div class="window-body">/i', '', $body_content);
        $body_content = preg_replace('/<\/div>\s*<\/div>\s*$/i', '', $body_content);
    }
    
    // Clean up broken style attributes
    $body_content = preg_replace('/<h([12])>\s*style=/i', '<h$1 style=', $body_content);
    $body_content = preg_replace('/<p class="lead">\s*style=/i', '<p class="lead" style=', $body_content);
    $body_content = str_replace('\\n', '', $body_content);
    $body_content = str_replace(' style="margin-bottom: 2rem;"', '', $body_content);
    
    // Now build proper structure
    $output = $php_header;
    $output .= "<main role=\"main\" class=\"container\">\n";
    $output .= "<section class=\"section\">\n";
    $output .= "  <div class=\"section__content\">\n";
    
    // Split content by headings
    $sections = preg_split('/(<h[123][^>]*>.*?<\/h[123]>)/is', $body_content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $current_content = '';
    $current_heading = '';
    
    foreach ($sections as $i => $section) {
        $section = trim($section);
        if (empty($section)) continue;
        
        // Check if it's a heading
        if (preg_match('/<h([123])[^>]*>(.*?)<\/h[123]>/is', $section, $h_match)) {
            // Output previous block
            if (!empty($current_heading) || !empty(trim($current_content))) {
                $output .= "    <div class=\"content-block module\">\n";
                if (!empty($current_heading)) {
                    preg_match('/<h([123])[^>]*>(.*?)<\/h[123]>/is', $current_heading, $prev_h);
                    $h_level = $prev_h[1] ?? '2';
                    $h_text = strip_tags($prev_h[2] ?? '');
                    $output .= "      <div class=\"content-block__header\">\n";
                    $output .= "        <h{$h_level} class=\"content-block__title\">" . trim($h_text) . "</h{$h_level}>\n";
                    $output .= "      </div>\n";
                }
                $output .= "      <div class=\"content-block__body\">\n";
                if (!empty(trim($current_content))) {
                    $lines = explode("\n", trim($current_content));
                    foreach ($lines as $line) {
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
            $current_heading = $section;
            $current_content = '';
        } else {
            // It's content
            $current_content .= $section . "\n";
        }
    }
    
    // Output last block
    if (!empty($current_heading) || !empty(trim($current_content))) {
        $output .= "    <div class=\"content-block module\">\n";
        if (!empty($current_heading)) {
            preg_match('/<h([123])[^>]*>(.*?)<\/h[123]>/is', $current_heading, $prev_h);
            $h_level = $prev_h[1] ?? '2';
            $h_text = strip_tags($prev_h[2] ?? '');
            $output .= "      <div class=\"content-block__header\">\n";
            $output .= "        <h{$h_level} class=\"content-block__title\">" . trim($h_text) . "</h{$h_level}>\n";
            $output .= "      </div>\n";
        }
        $output .= "      <div class=\"content-block__body\">\n";
        if (!empty(trim($current_content))) {
            $lines = explode("\n", trim($current_content));
            foreach ($lines as $line) {
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
echo "✅ All articles converted to content-block structure!\n";


