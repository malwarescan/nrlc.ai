<?php
/**
 * Canonical and Signal Extraction
 * 
 * Extracts canonical tags, meta robots, hreflang, and other signals from HTML.
 */

require_once __DIR__ . '/normalize.php';

/**
 * Extract canonical URL from HTML
 * 
 * @param string $html HTML content
 * @return string|null Canonical URL or null
 */
function extract_html_canonical(string $html): ?string {
    if (empty($html)) {
        return null;
    }
    
    // Try DOMDocument first
    if (class_exists('DOMDocument')) {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);
        
        // Look for <link rel="canonical">
        $canonicalNodes = $xpath->query('//link[@rel="canonical"]');
        foreach ($canonicalNodes as $node) {
            $href = $node->getAttribute('href');
            if ($href) {
                return $href;
            }
        }
    } else {
        // Fallback regex
        if (preg_match('/<link[^>]+rel=["\']canonical["\'][^>]+href=["\']([^"\']+)["\']/i', $html, $matches)) {
            return $matches[1];
        }
    }
    
    return null;
}

/**
 * Extract canonical URL from HTTP headers
 * 
 * @param array $headers HTTP headers array
 * @return string|null Canonical URL from Link header or null
 */
function extract_header_canonical(array $headers): ?string {
    $linkHeader = $headers['link'] ?? null;
    if (!$linkHeader) {
        return null;
    }
    
    // Parse Link header: <url>; rel="canonical"
    if (preg_match('/<([^>]+)>;\s*rel=["\']canonical["\']/i', $linkHeader, $matches)) {
        return $matches[1];
    }
    
    return null;
}

/**
 * Extract meta robots directives
 * 
 * @param string $html HTML content
 * @return array Array of robots directives (e.g., ['noindex', 'nofollow'])
 */
function extract_meta_robots(string $html): array {
    $directives = [];
    
    if (empty($html)) {
        return $directives;
    }
    
    if (class_exists('DOMDocument')) {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);
        
        $metaNodes = $xpath->query('//meta[@name="robots"]');
        foreach ($metaNodes as $node) {
            $content = $node->getAttribute('content');
            if ($content) {
                $directives = array_merge($directives, array_map('trim', explode(',', strtolower($content))));
            }
        }
    } else {
        // Fallback regex
        if (preg_match('/<meta[^>]+name=["\']robots["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $matches)) {
            $directives = array_map('trim', explode(',', strtolower($matches[1])));
        }
    }
    
    return array_unique($directives);
}

/**
 * Extract hreflang targets
 * 
 * @param string $html HTML content
 * @return array Array of ['lang' => 'url'] mappings
 */
function extract_hreflang_targets(string $html): array {
    $targets = [];
    
    if (empty($html)) {
        return $targets;
    }
    
    if (class_exists('DOMDocument')) {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);
        
        $hreflangNodes = $xpath->query('//link[@rel="alternate" and @hreflang]');
        foreach ($hreflangNodes as $node) {
            $lang = $node->getAttribute('hreflang');
            $href = $node->getAttribute('href');
            if ($lang && $href) {
                $targets[$lang] = $href;
            }
        }
    } else {
        // Fallback regex
        if (preg_match_all('/<link[^>]+rel=["\']alternate["\'][^>]+hreflang=["\']([^"\']+)["\'][^>]+href=["\']([^"\']+)["\']/i', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $targets[$match[1]] = $match[2];
            }
        }
    }
    
    return $targets;
}

/**
 * Extract all signals from a crawled URL response
 * 
 * @param array $response Response data from crawl.php
 * @param string $baseUrl Base URL for resolving relative URLs
 * @param array $config Configuration array
 * @return array Extracted signals
 */
function extract_signals(array $response, string $baseUrl, array $config): array {
    $html = $response['body'] ?? '';
    $headers = $response['headers'] ?? [];
    $finalUrl = $response['final_url'] ?? $response['url'];
    
    // Extract canonicals
    $htmlCanonical = extract_html_canonical($html);
    $headerCanonical = extract_header_canonical($headers);
    
    // Resolve relative canonicals
    if ($htmlCanonical && !preg_match('/^https?:\/\//i', $htmlCanonical)) {
        $htmlCanonical = resolve_url($htmlCanonical, $finalUrl);
    }
    if ($headerCanonical && !preg_match('/^https?:\/\//i', $headerCanonical)) {
        $headerCanonical = resolve_url($headerCanonical, $finalUrl);
    }
    
    // Normalize canonicals
    if ($htmlCanonical) {
        $htmlCanonical = normalize_url($htmlCanonical, $config);
    }
    if ($headerCanonical) {
        $headerCanonical = normalize_url($headerCanonical, $config);
    }
    
    // Extract other signals
    $metaRobots = extract_meta_robots($html);
    $hreflangTargets = extract_hreflang_targets($html);
    
    // Extract internal links
    require_once __DIR__ . '/crawl.php';
    $internalLinks = extract_internal_links($html, $finalUrl);
    
    // Normalize internal links
    $normalizedLinks = [];
    foreach ($internalLinks as $link) {
        $normalizedLinks[] = normalize_url($link, $config);
    }
    
    // Determine trailing slash state
    $parsed = parse_url($finalUrl);
    $path = $parsed['path'] ?? '/';
    $hasTrailingSlash = substr($path, -1) === '/' || $path === '/';
    
    // Extract query parameters
    $queryParams = [];
    if (isset($parsed['query'])) {
        parse_str($parsed['query'], $queryParams);
    }
    
    return [
        'html_canonical' => $htmlCanonical,
        'header_canonical' => $headerCanonical,
        'meta_robots' => $metaRobots,
        'hreflang_targets' => $hreflangTargets,
        'outgoing_internal_links' => array_unique($normalizedLinks),
        'trailing_slash_state' => $hasTrailingSlash,
        'query_parameters' => $queryParams,
    ];
}

