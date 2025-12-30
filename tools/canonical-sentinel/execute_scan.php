<?php
/**
 * Canonical Sentinel - Core Execution Engine
 * 
 * Shared execution logic for both CLI and web modes.
 * Returns scan results as array (no file I/O).
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/normalize.php';
require_once __DIR__ . '/crawl.php';
require_once __DIR__ . '/extract.php';
require_once __DIR__ . '/analyze.php';
require_once __DIR__ . '/score.php';

/**
 * Execute a canonical scan
 * 
 * @param string $startUrl Starting URL to scan
 * @param array $options Options: scope, depth, max_urls
 * @return array Scan results with summary and URL data
 */
function execute_canonical_scan(string $startUrl, array $options = []): array {
    $config = require __DIR__ . '/config.php';
    
    // Merge options with config
    if (isset($options['depth'])) {
        $config['crawl']['max_depth'] = $options['depth'];
    }
    if (isset($options['max_urls'])) {
        $config['crawl']['max_urls'] = $options['max_urls'];
    }
    
    // Validate URL
    if (!filter_var($startUrl, FILTER_VALIDATE_URL)) {
        throw new InvalidArgumentException("Invalid URL: $startUrl");
    }
    
    // Phase 1: Crawl
    $crawledUrls = crawl_website($startUrl, $config);
    
    // Phase 2: Discover sitemap URLs
    $sitemapUrls = discover_sitemap_urls($startUrl, $config);
    
    // Phase 3: Extract signals
    $urlsWithSignals = [];
    foreach ($crawledUrls as $urlData) {
        $signals = extract_signals($urlData, $startUrl, $config);
        $urlsWithSignals[] = array_merge($urlData, ['signals' => $signals]);
    }
    
    // Phase 4: Analyze
    $analyses = [];
    foreach ($urlsWithSignals as $urlData) {
        $analysis = analyze_url($urlData, $urlsWithSignals, $sitemapUrls, $config);
        
        // Check canonical status if declared (skip for fast web scans to avoid timeouts)
        if ($analysis['declared_canonical'] && ($config['crawl']['max_urls'] ?? 100) > 10) {
            $canonicalCheck = check_canonical_status($analysis['declared_canonical'], $config);
            $analysis['canonical_status'] = $canonicalCheck['status'];
        } else {
            $analysis['canonical_status'] = 200; // Assume OK for fast scans
        }
        
        $analyses[] = array_merge($urlData, $analysis);
    }
    
    // Phase 5: Score
    $results = [];
    foreach ($analyses as $analysis) {
        $scoring = score_canonical_integrity($analysis, $analysis, $config);
        $results[] = array_merge($analysis, $scoring);
    }
    
    // Generate summary
    $summary = [
        'scan_date' => date('c'),
        'start_url' => $startUrl,
        'total_urls' => count($results),
        'urls_with_mismatches' => count(array_filter($results, fn($r) => !empty($r['mismatch_types']))),
        'average_score' => count($results) > 0 
            ? round(array_sum(array_column($results, 'canonical_integrity_score')) / count($results), 1)
            : 0,
        'risk_distribution' => [
            'critical' => count(array_filter($results, fn($r) => ($r['risk_level'] ?? '') === 'critical')),
            'high' => count(array_filter($results, fn($r) => ($r['risk_level'] ?? '') === 'high')),
            'low' => count(array_filter($results, fn($r) => ($r['risk_level'] ?? '') === 'low')),
        ],
        'mismatch_types' => [],
    ];
    
    // Count mismatch types
    foreach ($results as $result) {
        foreach ($result['mismatch_types'] ?? [] as $type) {
            $summary['mismatch_types'][$type] = ($summary['mismatch_types'][$type] ?? 0) + 1;
        }
    }
    
    return [
        'summary' => $summary,
        'results' => $results,
    ];
}

