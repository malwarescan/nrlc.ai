<?php
declare(strict_types=1);

/**
 * Replace common inline styles with utility classes across all PHP files
 */

$replacements = [
    // Blog post patterns
    'style="color: #666; font-size: 0.9em; margin-bottom: 20px;"' => 'class="muted-text"',
    'style="justify-content: center; margin-top: 30px;"' => 'class="field-row-center"',
    
    // Case study patterns  
    'style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px; margin-top: 20px;"' => 'class="grid grid-auto-fit"',
    'style="gap: 4px;"' => 'class="grid-gap-4"',
    
    // General patterns
    'style="margin-top:20px;"' => 'class="margin-top-20"',
    'style="display:flex;gap:10px;flex-wrap:wrap"' => 'class="flex-wrap"',
];

$directories = [
    'pages/blog/',
    'pages/case-studies/',
    'pages/resources/',
    'pages/tools/',
    'pages/industries/',
];

$processed = 0;
$updated = 0;

foreach ($directories as $dir) {
    if (!is_dir($dir)) continue;
    
    $files = glob($dir . '*.php');
    foreach ($files as $file) {
        $processed++;
        $content = file_get_contents($file);
        $originalContent = $content;
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        
        if ($content !== $originalContent) {
            file_put_contents($file, $content);
            $updated++;
            echo "Updated: $file\n";
        }
    }
}

echo "\nProcessed: $processed files\n";
echo "Updated: $updated files\n";
echo "Done!\n";
