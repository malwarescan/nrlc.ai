<?php
/**
 * URL Discovery and Fetching
 * 
 * Crawls a website, respects robots.txt, and collects URL data.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/normalize.php';

/**
 * Parse robots.txt and return disallowed paths
 * 
 * @param string $baseUrl Base URL of the site
 * @return array Array of disallowed path patterns
 */
function parse_robots_txt(string $baseUrl): array {
    $robotsUrl = rtrim($baseUrl, '/') . '/robots.txt';
    $disallowed = [];
    
    $ch = curl_init($robotsUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_USERAGENT => 'CanonicalSentinel/1.0',
    ]);
    
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close() deprecated in PHP 8.5 - resource automatically closed
    
    if ($httpCode !== 200 || !$content) {
        return []; // No robots.txt or unreadable
    }
    
    $lines = explode("\n", $content);
    $inUserAgent = false;
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        if (empty($line) || $line[0] === '#') {
            continue;
        }
        
        if (preg_match('/^User-agent:\s*(.+)$/i', $line, $m)) {
            $ua = trim($m[1]);
            $inUserAgent = ($ua === '*' || stripos($ua, 'CanonicalSentinel') !== false);
        } elseif ($inUserAgent && preg_match('/^Disallow:\s*(.+)$/i', $line, $m)) {
            $path = trim($m[1]);
            if ($path) {
                $disallowed[] = $path;
            }
        }
    }
    
    return $disallowed;
}

/**
 * Check if a URL is disallowed by robots.txt
 * 
 * @param string $url URL to check
 * @param array $disallowed Array of disallowed patterns
 * @return bool True if disallowed
 */
function is_disallowed(string $url, array $disallowed): bool {
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    foreach ($disallowed as $pattern) {
        // Convert robots.txt pattern to regex
        $regex = str_replace(['*', '?'], ['.*', '.'], preg_quote($pattern, '/'));
        if (preg_match("/^$regex/", $path)) {
            return true;
        }
    }
    
    return false;
}

/**
 * Fetch a URL and return response data
 * 
 * @param string $url URL to fetch
 * @param array $config Configuration array
 * @return array Response data with url, status, headers, body, redirect_chain
 */
function fetch_url(string $url, array $config): array {
    $redirectChain = [];
    $finalUrl = $url;
    $maxRedirects = $config['crawl']['max_redirects'] ?? 10;
    
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false, // Manual redirect handling
        CURLOPT_TIMEOUT => $config['crawl']['timeout'],
        CURLOPT_CONNECTTIMEOUT => 3, // Max 3 seconds to connect
        CURLOPT_USERAGENT => $config['crawl']['user_agent'],
        CURLOPT_HEADER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);
    
    $response = @curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    
    // Handle curl errors
    if ($response === false && $curlError) {
        // curl_close() deprecated in PHP 8.5 - resource automatically closed
        return [
            'url' => $url,
            'final_url' => $url,
            'status' => 0,
            'error' => $curlError,
            'headers' => [],
            'body' => '',
            'redirect_chain' => [],
        ];
    }
    
    // curl_close() deprecated in PHP 8.5 - resource automatically closed
    
    $headers = [];
    $body = '';
    
    if ($response) {
        $headerText = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);
        
        // Parse headers
        $headerLines = explode("\r\n", $headerText);
        foreach ($headerLines as $line) {
            if (preg_match('/^([^:]+):\s*(.+)$/', $line, $m)) {
                $headers[strtolower(trim($m[1]))] = trim($m[2]);
            }
        }
        
        // Handle redirects manually
        if ($httpCode >= 300 && $httpCode < 400 && $redirectUrl) {
            $redirectChain[] = "$httpCode -> " . $redirectUrl;
            $finalUrl = $redirectUrl;
            
            // Follow redirect if enabled and under limit
            if ($config['crawl']['follow_redirects'] && count($redirectChain) < $maxRedirects) {
                return fetch_url($redirectUrl, $config);
            }
        }
    }
    
    return [
        'url' => $url,
        'final_url' => $finalUrl,
        'status' => $httpCode,
        'headers' => $headers,
        'body' => $body,
        'redirect_chain' => $redirectChain,
    ];
}

/**
 * Extract internal links from HTML
 * 
 * @param string $html HTML content
 * @param string $baseUrl Base URL for resolving relative links
 * @return array Array of absolute URLs
 */
function extract_internal_links(string $html, string $baseUrl): array {
    $links = [];
    $parsedBase = parse_url($baseUrl);
    $baseHost = $parsedBase['host'] ?? '';
    
    if (empty($html)) {
        return $links;
    }
    
    // Use DOMDocument if available
    if (class_exists('DOMDocument')) {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);
        
        $anchorNodes = $xpath->query('//a[@href]');
        foreach ($anchorNodes as $node) {
            $href = $node->getAttribute('href');
            $absolute = resolve_url($href, $baseUrl);
            
            $parsed = parse_url($absolute);
            $host = $parsed['host'] ?? '';
            
            // Only internal links
            if ($host === $baseHost || empty($host)) {
                $links[] = $absolute;
            }
        }
    } else {
        // Fallback regex (less reliable)
        if (preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
            foreach ($matches[1] as $href) {
                $absolute = resolve_url($href, $baseUrl);
                $parsed = parse_url($absolute);
                $host = $parsed['host'] ?? '';
                
                if ($host === $baseHost || empty($host)) {
                    $links[] = $absolute;
                }
            }
        }
    }
    
    return array_unique($links);
}

/**
 * Discover URLs from sitemap
 * 
 * @param string $baseUrl Base URL
 * @param array $config Configuration array
 * @return array Array of URLs from sitemap
 */
function discover_sitemap_urls(string $baseUrl, array $config): array {
    if (!$config['sitemap']['enabled']) {
        return [];
    }
    
    $urls = [];
    $sitemaps = [];
    
    // Try common sitemap locations
    if ($config['sitemap']['auto_discover']) {
        $sitemaps[] = rtrim($baseUrl, '/') . '/sitemap.xml';
        $sitemaps[] = rtrim($baseUrl, '/') . '/sitemap_index.xml';
    }
    
    foreach ($sitemaps as $sitemapUrl) {
        $ch = curl_init($sitemapUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => $config['crawl']['user_agent'],
        ]);
        
        $xml = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close() deprecated in PHP 8.5 - resource automatically closed
        
        if ($httpCode === 200 && $xml) {
            // Parse sitemap XML
            libxml_use_internal_errors(true);
            $dom = @simplexml_load_string($xml);
            
            if ($dom) {
                // Sitemap index
                if (isset($dom->sitemap)) {
                    foreach ($dom->sitemap as $sitemap) {
                        $loc = (string)($sitemap->loc ?? '');
                        if ($loc) {
                            $urls = array_merge($urls, discover_sitemap_urls($loc, $config));
                        }
                    }
                }
                // Regular sitemap
                elseif (isset($dom->url)) {
                    foreach ($dom->url as $url) {
                        $loc = (string)($url->loc ?? '');
                        if ($loc) {
                            $urls[] = $loc;
                        }
                    }
                }
            }
        }
    }
    
    return array_unique($urls);
}

/**
 * Crawl a website starting from a base URL
 * 
 * @param string $startUrl Starting URL
 * @param array $config Configuration array
 * @return array Array of crawled URL data
 */
function crawl_website(string $startUrl, array $config): array {
    $parsed = parse_url($startUrl);
    $baseUrl = $parsed['scheme'] . '://' . $parsed['host'];
    if (isset($parsed['port'])) {
        $baseUrl .= ':' . $parsed['port'];
    }
    
    // Parse robots.txt
    $disallowed = [];
    if ($config['crawl']['respect_robots']) {
        $disallowed = parse_robots_txt($baseUrl);
    }
    
    // Discover sitemap URLs
    $sitemapUrls = discover_sitemap_urls($baseUrl, $config);
    
    // Queue for crawling
    $queue = [normalize_url($startUrl, $config)];
    $visited = [];
    $results = [];
    $maxUrls = $config['crawl']['max_urls'] ?? 1000;
    $maxDepth = $config['crawl']['max_depth'] ?? 5;
    
    // Add sitemap URLs to queue
    foreach ($sitemapUrls as $sitemapUrl) {
        $normalized = normalize_url($sitemapUrl, $config);
        if (!in_array($normalized, $queue)) {
            $queue[] = $normalized;
        }
    }
    
    $depth = 0;
    while (!empty($queue) && count($results) < $maxUrls && $depth < $maxDepth) {
        $currentBatch = $queue;
        $queue = [];
        $depth++;
        
        foreach ($currentBatch as $url) {
            $normalized = normalize_url($url, $config);
            
            // Skip if already visited
            if (isset($visited[$normalized])) {
                continue;
            }
            
            // Check robots.txt
            if ($config['crawl']['respect_robots'] && is_disallowed($url, $disallowed)) {
                continue;
            }
            
            // Fetch URL
            $response = fetch_url($url, $config);
            $visited[$normalized] = true;
            $results[] = $response;
            
            // Extract links if 200 OK
            if ($response['status'] === 200 && $depth < $maxDepth) {
                $links = extract_internal_links($response['body'], $response['final_url']);
                foreach ($links as $link) {
                    $linkNormalized = normalize_url($link, $config);
                    if (!isset($visited[$linkNormalized]) && !in_array($linkNormalized, $queue)) {
                        $queue[] = $linkNormalized;
                    }
                }
            }
            
            // Respect crawl delay
            if ($config['crawl']['crawl_delay'] > 0) {
                usleep($config['crawl']['crawl_delay'] * 1000000);
            }
        }
    }
    
    return $results;
}

