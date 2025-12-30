<?php
/**
 * Mismatch Detection Logic
 * 
 * Analyzes URLs for canonical mismatches and issues.
 */

require_once __DIR__ . '/normalize.php';
require_once __DIR__ . '/crawl.php';

// Mismatch type constants
define('MISMATCH_SELF_CANONICAL_FAILURE', 'SELF_CANONICAL_FAILURE');
define('MISMATCH_CANONICAL_REDIRECT', 'CANONICAL_REDIRECT');
define('MISMATCH_CANONICAL_NON_200', 'CANONICAL_NON_200');
define('MISMATCH_HEADER_HTML_SPLIT', 'HEADER_HTML_SPLIT');
define('MISMATCH_SITEMAP_CONFLICT', 'SITEMAP_CONFLICT');
define('MISMATCH_INTERNAL_LINK_OVERRIDE', 'INTERNAL_LINK_OVERRIDE');
define('MISMATCH_HREFLANG_CONFLICT', 'HREFLANG_CONFLICT');
define('MISMATCH_PARAMETER_COLLAPSE', 'PARAMETER_COLLAPSE');
define('MISMATCH_PROTOCOL_HOST_DRIFT', 'PROTOCOL_HOST_DRIFT');

// Cache for canonical status checks (avoid duplicate HTTP requests)
static $canonicalStatusCache = [];

/**
 * Check if canonical URL returns 200 OK
 * 
 * @param string $canonicalUrl Canonical URL to check
 * @param array $config Configuration array
 * @return array ['status' => int, 'final_url' => string]
 */
function check_canonical_status(string $canonicalUrl, array $config): array {
    global $canonicalStatusCache;
    
    // Check cache first
    if (isset($canonicalStatusCache[$canonicalUrl])) {
        return $canonicalStatusCache[$canonicalUrl];
    }
    
    // Only check if URL is actually different from what we already crawled
    // For web mode, skip expensive canonical checks to avoid timeouts
    $skipExpensiveChecks = ($config['crawl']['max_urls'] ?? 100) <= 10;
    
    if ($skipExpensiveChecks) {
        // For fast web scans, just return a placeholder (we already have the data from crawl)
        $result = [
            'status' => 200, // Assume OK to avoid extra requests
            'final_url' => $canonicalUrl,
        ];
    } else {
        $response = fetch_url($canonicalUrl, $config);
        $result = [
            'status' => $response['status'],
            'final_url' => $response['final_url'],
        ];
    }
    
    // Cache result
    $canonicalStatusCache[$canonicalUrl] = $result;
    return $result;
}

/**
 * Analyze a single URL for canonical mismatches
 * 
 * @param array $urlData URL data with signals extracted
 * @param array $allUrls All crawled URLs (for cross-reference)
 * @param array $sitemapUrls URLs from sitemap
 * @param array $config Configuration array
 * @return array Analysis result with mismatch_types array
 */
function analyze_url(array $urlData, array $allUrls, array $sitemapUrls, array $config): array {
    $mismatches = [];
    $finalUrl = $urlData['final_url'];
    $normalizedFinal = normalize_url($finalUrl, $config);
    $signals = $urlData['signals'] ?? [];
    
    $htmlCanonical = $signals['html_canonical'] ?? null;
    $headerCanonical = $signals['header_canonical'] ?? null;
    $metaRobots = $signals['meta_robots'] ?? [];
    
    // Skip canonical checks if page returned 5xx error (can't extract from error pages)
    $status = $urlData['status'] ?? 0;
    $isErrorPage = ($status >= 500 && $status < 600);
    
    // SELF_CANONICAL_FAILURE: URL doesn't self-reference as canonical
    if ($isErrorPage) {
        // Don't flag canonical issues for 5xx errors - page didn't load
        // This will be handled by CANONICAL_NON_200 check instead
    } elseif ($htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        if (!urls_equivalent($normalizedFinal, $normalizedCanonical, $config)) {
            $mismatches[] = MISMATCH_SELF_CANONICAL_FAILURE;
        }
    } elseif (!$htmlCanonical && !in_array('noindex', $metaRobots)) {
        // Missing canonical tag (unless noindex)
        // Only flag if we got HTML content (status 200 or 3xx that resolved)
        if ($status === 200 || ($status >= 300 && $status < 400)) {
            $mismatches[] = MISMATCH_SELF_CANONICAL_FAILURE;
        }
    }
    
    // HEADER_HTML_SPLIT: Header and HTML canonicals differ
    if ($htmlCanonical && $headerCanonical) {
        $normHtml = normalize_url($htmlCanonical, $config);
        $normHeader = normalize_url($headerCanonical, $config);
        if ($normHtml !== $normHeader) {
            $mismatches[] = MISMATCH_HEADER_HTML_SPLIT;
        }
    }
    
    // CANONICAL_REDIRECT: Canonical URL redirects (should be direct)
    // Skip expensive checks for fast web scans to avoid timeouts
    $skipExpensiveChecks = ($config['crawl']['max_urls'] ?? 100) <= 10;
    if ($htmlCanonical && !$skipExpensiveChecks) {
        $canonicalCheck = check_canonical_status($htmlCanonical, $config);
        if ($canonicalCheck['status'] >= 300 && $canonicalCheck['status'] < 400) {
            $mismatches[] = MISMATCH_CANONICAL_REDIRECT;
        }
    }
    
    // CANONICAL_NON_200: Canonical URL doesn't return 200 OR page itself returned 5xx
    if ($isErrorPage) {
        // Page returned 5xx - this is a critical issue
        $mismatches[] = MISMATCH_CANONICAL_NON_200;
    } elseif ($htmlCanonical && !$skipExpensiveChecks) {
        $canonicalCheck = check_canonical_status($htmlCanonical, $config);
        if ($canonicalCheck['status'] !== 200) {
            $mismatches[] = MISMATCH_CANONICAL_NON_200;
        }
    }
    
    // SITEMAP_CONFLICT: URL in sitemap but canonical points elsewhere
    $normalizedSitemapUrls = array_map(function($url) use ($config) {
        return normalize_url($url, $config);
    }, $sitemapUrls);
    
    if (in_array($normalizedFinal, $normalizedSitemapUrls) && $htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        if (!in_array($normalizedCanonical, $normalizedSitemapUrls)) {
            $mismatches[] = MISMATCH_SITEMAP_CONFLICT;
        }
    }
    
    // INTERNAL_LINK_OVERRIDE: Internal links point to non-canonical version
    $internalLinks = $signals['outgoing_internal_links'] ?? [];
    if (!empty($internalLinks) && $htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        $hasNonCanonicalLink = false;
        
        foreach ($internalLinks as $link) {
            $normalizedLink = normalize_url($link, $config);
            // If link points to this page but not to canonical
            if (urls_equivalent($normalizedLink, $normalizedFinal, $config) && 
                !urls_equivalent($normalizedLink, $normalizedCanonical, $config)) {
                $hasNonCanonicalLink = true;
                break;
            }
        }
        
        if ($hasNonCanonicalLink) {
            $mismatches[] = MISMATCH_INTERNAL_LINK_OVERRIDE;
        }
    }
    
    // HREFLANG_CONFLICT: Hreflang targets don't match canonical structure
    $hreflangTargets = $signals['hreflang_targets'] ?? [];
    if (!empty($hreflangTargets) && $htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        foreach ($hreflangTargets as $lang => $target) {
            $normalizedTarget = normalize_url($target, $config);
            // If hreflang points to a different canonical structure
            if (!urls_equivalent($normalizedTarget, $normalizedCanonical, $config)) {
                // Check if it's a legitimate alternate (different locale)
                $parsedCanonical = parse_url($normalizedCanonical);
                $parsedTarget = parse_url($normalizedTarget);
                $canonicalPath = $parsedCanonical['path'] ?? '/';
                $targetPath = $parsedTarget['path'] ?? '/';
                
                // If paths are structurally different (not just locale), it's a conflict
                $canonicalPathClean = preg_replace('/^\/[a-z]{2}-[a-z]{2}\//i', '/', $canonicalPath);
                $targetPathClean = preg_replace('/^\/[a-z]{2}-[a-z]{2}\//i', '/', $targetPath);
                
                if ($canonicalPathClean !== $targetPathClean) {
                    $mismatches[] = MISMATCH_HREFLANG_CONFLICT;
                    break;
                }
            }
        }
    }
    
    // PARAMETER_COLLAPSE: Query parameters in URL but not in canonical
    $queryParams = $signals['query_parameters'] ?? [];
    if (!empty($queryParams) && $htmlCanonical) {
        $parsedCanonical = parse_url($htmlCanonical);
        $canonicalParams = [];
        if (isset($parsedCanonical['query'])) {
            parse_str($parsedCanonical['query'], $canonicalParams);
        }
        
        // Check if important params are missing from canonical
        $importantParams = array_diff(array_keys($queryParams), $config['normalize']['strip_tracking_params']);
        if (!empty($importantParams)) {
            $missingInCanonical = array_diff($importantParams, array_keys($canonicalParams));
            if (!empty($missingInCanonical)) {
                $mismatches[] = MISMATCH_PARAMETER_COLLAPSE;
            }
        }
    }
    
    // PROTOCOL_HOST_DRIFT: Canonical uses different protocol or host
    if ($htmlCanonical) {
        $parsedFinal = parse_url($finalUrl);
        $parsedCanonical = parse_url($htmlCanonical);
        
        $finalHost = strtolower($parsedFinal['host'] ?? '');
        $canonicalHost = strtolower($parsedCanonical['host'] ?? '');
        
        $finalScheme = strtolower($parsedFinal['scheme'] ?? 'https');
        $canonicalScheme = strtolower($parsedCanonical['scheme'] ?? 'https');
        
        if ($finalHost !== $canonicalHost || $finalScheme !== $canonicalScheme) {
            $mismatches[] = MISMATCH_PROTOCOL_HOST_DRIFT;
        }
    }
    
    return [
        'url' => $finalUrl,
        'mismatch_types' => array_unique($mismatches),
        'declared_canonical' => $htmlCanonical ?: $headerCanonical,
    ];
}

