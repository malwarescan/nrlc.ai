<?php
/**
 * Router for PHP built-in server (Railway deployment)
 * This handles all requests when using: php -S host:port -t public
 */

// Serve static files directly
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    
    // If it's a real file (not a directory), serve it
    if (is_file($file)) {
        return false;
    }
}

// Otherwise, route through index.php
require_once __DIR__ . '/index.php';

