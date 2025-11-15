<?php
/**
 * Fix double footer issue by removing footer.php includes from all page files
 * since router.php render_page() already includes it
 */

$directories = [
    __DIR__ . '/../pages/',
    __DIR__ . '/../public/catalog/',
    __DIR__ . '/../public/promptware/',
];

$patterns = [
    '/\<\?php\s+include\s+__DIR__\s*\.\s*[\'"]\/\.\.\/\.\.\/templates\/footer\.php[\'"]\s*;\s*\?\>/i',
    '/\<\?php\s+require_once\s+__DIR__\s*\.\s*[\'"]\/\.\.\/\.\.\/templates\/footer\.php[\'"]\s*;\s*\?\>/i',
    '/\<\?php\s+include\s+__DIR__\s*\.\s*[\'"]\/\.\.\/\.\.\/\.\.\/templates\/footer\.php[\'"]\s*;\s*\?\>/i',
    '/\<\?php\s+require_once\s+__DIR__\s*\.\s*[\'"]\/\.\.\/\.\.\/\.\.\/templates\/footer\.php[\'"]\s*;\s*\?\>/i',
];

$comment = '<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>';

$fixed = 0;
$skipped = 0;
$total = 0;

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        echo "⚠ Directory not found: $dir\n";
        continue;
    }
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($files as $file) {
        if (!$file->isFile() || $file->getExtension() !== 'php') {
            continue;
        }
        
        $filepath = $file->getRealPath();
        $basename = basename($filepath);
        
        // Skip index files that might be routers
        if ($basename === 'index.php' && strpos($filepath, 'catalog') !== false) {
            // Check if it's a catalog index that includes its own head/header
            $content = file_get_contents($filepath);
            if (strpos($content, "include __DIR__.'/../../templates/head.php'") !== false) {
                // This is a standalone page, might need footer
                continue;
            }
        }
        
        $content = file_get_contents($filepath);
        $originalContent = $content;
        $total++;
        
        // Try each pattern
        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, $comment, $content);
        }
        
        if ($content !== $originalContent) {
            file_put_contents($filepath, $content);
            $relativePath = str_replace(__DIR__ . '/../', '', $filepath);
            echo "✓ Fixed: $relativePath\n";
            $fixed++;
        }
    }
}

echo "\n=================\n";
echo "Total files checked: $total\n";
echo "Fixed: $fixed files\n";
echo "Skipped: $skipped files\n";
echo "=================\n";

