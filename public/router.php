<?php
/**
 * Router for PHP built-in server (Railway deployment)
 * This handles all requests when using: php -S host:port -t public router.php
 * 
 * CRITICAL: This file MUST NEVER throw fatal errors - all errors must be caught
 */

// TOP-LEVEL ERROR HANDLER: Catch any fatal errors and serve minimal response
try {
    // Serve static files directly
    if (php_sapi_name() === 'cli-server') {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $file = __DIR__ . $path;
        
        // NEVER serve promptware directories or PHP files directly
        // Always route them through main index.php so head/header/footer are included
        if (strpos($path, '/promptware/') === 0) {
            // Route ALL promptware requests through main index.php
            if (file_exists(__DIR__ . '/index.php')) {
                require_once __DIR__ . '/index.php';
            }
            return true;
        }
        
        // Route catalog requests through main index.php
        if (strpos($path, '/catalog/') === 0) {
            if (file_exists(__DIR__ . '/index.php')) {
                require_once __DIR__ . '/index.php';
            }
            return true;
        }
        
        // If it's a real file (not a directory), serve it
        if (is_file($file)) {
            return false;
        }
    }

    // Otherwise, route through index.php
    if (file_exists(__DIR__ . '/index.php')) {
        require_once __DIR__ . '/index.php';
    } else {
        // Fallback if index.php doesn't exist
        http_response_code(200);
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!DOCTYPE html><html><head><title>NRLC.ai</title><meta charset="UTF-8"></head><body><h1>NRLC.ai</h1><p>AI SEO & AI Visibility Services</p></body></html>';
    }
} catch (Throwable $e) {
    // FALLBACK: Always return 200 with minimal HTML - NEVER let errors bubble up
    http_response_code(200);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><title>NRLC.ai - AI SEO & AI Visibility Services</title><meta charset="UTF-8"><meta name="description" content="Professional AI SEO and AI visibility services."></head><body><h1>NRLC.ai</h1><p>AI SEO & AI Visibility Services</p><p>Email: hirejoelm@gmail.com | Phone: +1-844-568-4624</p></body></html>';
}
