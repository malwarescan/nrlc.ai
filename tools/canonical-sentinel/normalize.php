<?php
/**
 * URL Normalization Engine
 * 
 * Normalizes URLs before comparison to ensure accurate canonical matching.
 * All URLs must pass through this before any analysis.
 */

require_once __DIR__ . '/config.php';

/**
 * Normalize a URL for canonical comparison
 * 
 * @param string $url The URL to normalize
 * @param array $config Configuration array
 * @return string Normalized URL
 */
function normalize_url(string $url, array $config): string {
    // Parse URL
    $parsed = parse_url($url);
    if (!$parsed) {
        return $url; // Return as-is if unparseable
    }
    
    // Normalize scheme (lowercase, default to https)
    $scheme = strtolower($parsed['scheme'] ?? 'https');
    
    // Normalize host (lowercase, remove default ports)
    $host = strtolower($parsed['host'] ?? '');
    $port = $parsed['port'] ?? null;
    
    // Remove default ports
    if ($port && (
        ($scheme === 'http' && $port == 80) ||
        ($scheme === 'https' && $port == 443)
    )) {
        $port = null;
    }
    
    // Normalize path
    $path = $parsed['path'] ?? '/';
    
    // Decode entities
    $path = urldecode($path);
    
    // Normalize trailing slash
    if ($config['normalize']['default_trailing_slash']) {
        // Add trailing slash to non-file paths
        if (!preg_match('/\.[a-z0-9]{2,4}$/i', $path) && $path !== '/') {
            $path = rtrim($path, '/') . '/';
        }
    } else {
        // Remove trailing slash (except root)
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }
    }
    
    // Normalize query parameters
    $query = $parsed['query'] ?? '';
    if ($query) {
        parse_str($query, $params);
        
        // Strip tracking parameters
        foreach ($config['normalize']['strip_tracking_params'] as $param) {
            unset($params[$param]);
        }
        
        // Sort parameters alphabetically
        ksort($params);
        
        // Rebuild query string
        $query = http_build_query($params);
    }
    
    // Rebuild URL
    $normalized = $scheme . '://' . $host;
    if ($port) {
        $normalized .= ':' . $port;
    }
    $normalized .= $path;
    if ($query) {
        $normalized .= '?' . $query;
    }
    if (isset($parsed['fragment'])) {
        // Fragments are typically ignored for canonical, but preserve if needed
        // $normalized .= '#' . $parsed['fragment'];
    }
    
    return $normalized;
}

/**
 * Check if two URLs are equivalent after normalization
 * 
 * @param string $url1 First URL
 * @param string $url2 Second URL
 * @param array $config Configuration array
 * @return bool True if URLs are equivalent
 */
function urls_equivalent(string $url1, string $url2, array $config): bool {
    $norm1 = normalize_url($url1, $config);
    $norm2 = normalize_url($url2, $config);
    return $norm1 === $norm2;
}

/**
 * Resolve relative URL to absolute
 * 
 * @param string $relative Relative URL
 * @param string $base Base URL
 * @return string Absolute URL
 */
function resolve_url(string $relative, string $base): string {
    // Already absolute
    if (preg_match('/^https?:\/\//i', $relative)) {
        return $relative;
    }
    
    $baseParsed = parse_url($base);
    if (!$baseParsed) {
        return $relative;
    }
    
    $scheme = $baseParsed['scheme'] ?? 'https';
    $host = $baseParsed['host'] ?? '';
    $port = isset($baseParsed['port']) ? ':' . $baseParsed['port'] : '';
    
    // Protocol-relative URL
    if (substr($relative, 0, 2) === '//') {
        return $scheme . ':' . $relative;
    }
    
    // Absolute path
    if (substr($relative, 0, 1) === '/') {
        return $scheme . '://' . $host . $port . $relative;
    }
    
    // Relative path
    $basePath = $baseParsed['path'] ?? '/';
    $baseDir = dirname($basePath);
    if ($baseDir === '.') {
        $baseDir = '/';
    }
    
    $resolved = $scheme . '://' . $host . $port . $baseDir . '/' . $relative;
    
    // Normalize path (remove ./ and ../)
    $parts = explode('/', $resolved);
    $stack = [];
    foreach ($parts as $part) {
        if ($part === '..' && !empty($stack)) {
            array_pop($stack);
        } elseif ($part !== '.' && $part !== '') {
            $stack[] = $part;
        }
    }
    
    return implode('/', $stack);
}

