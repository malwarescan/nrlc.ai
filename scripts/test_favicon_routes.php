<?php
/**
 * Test script to verify favicon routes are working correctly
 * Run: php scripts/test_favicon_routes.php
 */

require_once __DIR__.'/../bootstrap/env.php';

$favicon_urls = [
    '/favicon.ico',
    '/favicon-16x16.png',
    '/favicon-32x32.png',
    '/favicon-48x48.png',
    '/favicon-192.png',
    '/apple-touch-icon.png',
    '/android-chrome-192x192.png',
    '/android-chrome-512x512.png',
    '/site.webmanifest',
];

$base_path = __DIR__.'/../public';
$all_passed = true;

echo "Testing favicon file routes...\n\n";

foreach ($favicon_urls as $url) {
    $expected_files = [
        '/favicon.ico' => $base_path.'/favicon.ico',
        '/favicon-16x16.png' => $base_path.'/favicon-16x16.png',
        '/favicon-32x32.png' => $base_path.'/favicon-32x32.png',
        '/favicon-48x48.png' => $base_path.'/favicon-48x48.png',
        '/favicon-192.png' => $base_path.'/android-chrome-192x192.png',
        '/apple-touch-icon.png' => $base_path.'/apple-touch-icon.png',
        '/android-chrome-192x192.png' => $base_path.'/android-chrome-192x192.png',
        '/android-chrome-512x512.png' => $base_path.'/android-chrome-512x512.png',
        '/site.webmanifest' => $base_path.'/site.webmanifest',
    ];
    
    $file_path = $expected_files[$url] ?? null;
    
    if (!$file_path) {
        echo "❌ $url - No mapping found\n";
        $all_passed = false;
        continue;
    }
    
    if (file_exists($file_path)) {
        $size = filesize($file_path);
        echo "✅ $url - File exists ({$size} bytes)\n";
    } else {
        echo "❌ $url - File missing: $file_path\n";
        $all_passed = false;
    }
}

echo "\n";
if ($all_passed) {
    echo "✅ All favicon files exist!\n";
    echo "\nTo test locally, start the server:\n";
    echo "  cd public && php -S localhost:8000 router.php\n";
    echo "\nThen visit:\n";
    echo "  http://localhost:8000/favicon.ico\n";
    echo "  http://localhost:8000/favicon-48x48.png\n";
} else {
    echo "❌ Some favicon files are missing!\n";
    exit(1);
}



