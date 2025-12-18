<?php
/**
 * Router for PHP built-in server (Railway deployment)
 * This handles all requests when using: php -S host:port -t public router.php
 */

// Serve static files directly
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    
    // NEVER serve promptware directories or PHP files directly
    // Always route them through main index.php so head/header/footer are included
    if (strpos($path, '/promptware/') === 0) {
        // Route ALL promptware requests through main index.php
        require_once __DIR__ . '/index.php';
        return true;
    }
    
    // Route catalog requests through main index.php
    if (strpos($path, '/catalog/') === 0) {
        require_once __DIR__ . '/index.php';
        return true;
    }
    
    // If it's a real file (not a directory), serve it
    if (is_file($file)) {
        return false;
    }
}

// Otherwise, route through index.php
require_once __DIR__ . '/index.php';
