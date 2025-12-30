<?php
/**
 * Canonical Sentinel Configuration
 * 
 * Controls crawl behavior, scoring weights, and output settings
 */

return [
    // Crawl settings
    'crawl' => [
        'max_depth' => 5,
        'max_urls' => 1000,
        'timeout' => 5, // Reduced for web requests (5 seconds max per URL)
        'user_agent' => 'CanonicalSentinel/1.0 (+https://nrlc.ai/tools/canonical-sentinel)',
        'follow_redirects' => true,
        'max_redirects' => 10,
        'respect_robots' => true,
        'crawl_delay' => 1, // seconds between requests
    ],
    
    // URL normalization rules
    'normalize' => [
        'strip_tracking_params' => [
            'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
            'fbclid', 'gclid', 'ref', 'source', 'campaign',
            '_ga', '_gid', 'mc_cid', 'mc_eid',
        ],
        'preserve_params' => [], // Params to always preserve (e.g., 'id', 'page')
        'default_trailing_slash' => true, // Prefer trailing slash
    ],
    
    // Scoring weights (must sum to 100)
    'scoring' => [
        'self_canonical_correct' => 30,
        'canonical_returns_200' => 20,
        'redirect_consistency' => 15,
        'internal_link_alignment' => 15,
        'sitemap_alignment' => 10,
        'hreflang_alignment' => 10,
    ],
    
    // Thresholds
    'thresholds' => [
        'indexing_risk' => 70, // Score < 70 = indexing risk
        'canonical_failure' => 40, // Score < 40 = canonical failure
    ],
    
    // Output settings
    'output' => [
        'ndjson_file' => 'canonical_scan.ndjson',
        'summary_file' => 'canonical_summary.json',
        'directives_file' => 'canonical_directives.txt',
    ],
    
    // Sitemap settings
    'sitemap' => [
        'enabled' => true,
        'auto_discover' => true, // Try /sitemap.xml, /sitemap_index.xml
        'max_sitemaps' => 10,
    ],
];

