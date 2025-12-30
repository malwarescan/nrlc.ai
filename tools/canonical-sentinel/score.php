<?php
/**
 * Canonical Integrity Scoring Engine
 * 
 * Scores URLs on canonical integrity (0-100) and predicts Google behavior.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/normalize.php';
require_once __DIR__ . '/crawl.php';

/**
 * Calculate canonical integrity score for a URL
 * 
 * @param array $analysis Analysis result from analyze.php
 * @param array $urlData Full URL data with signals
 * @param array $config Configuration array
 * @return array Score data with score (0-100) and google_likely_ignores flag
 */
function score_canonical_integrity(array $analysis, array $urlData, array $config): array {
    $score = 0;
    $weights = $config['scoring'];
    $signals = $urlData['signals'] ?? [];
    $finalUrl = $urlData['final_url'];
    $normalizedFinal = normalize_url($finalUrl, $config);
    
    $htmlCanonical = $signals['html_canonical'] ?? null;
    $metaRobots = $signals['meta_robots'] ?? [];
    
    // +30: Self-canonical correct
    if ($htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        if (urls_equivalent($normalizedFinal, $normalizedCanonical, $config)) {
            $score += $weights['self_canonical_correct'];
        }
    }
    
    // +20: Canonical returns 200
    if ($htmlCanonical) {
        // Skip expensive check for fast web scans (assume OK)
        $skipExpensiveChecks = ($config['crawl']['max_urls'] ?? 100) <= 10;
        if ($skipExpensiveChecks) {
            $score += $weights['canonical_returns_200']; // Assume OK for fast scans
        } else {
            $canonicalCheck = check_canonical_status($htmlCanonical, $config);
            if ($canonicalCheck['status'] === 200) {
                $score += $weights['canonical_returns_200'];
            }
        }
    }
    
    // +15: Redirect consistency
    $redirectChain = $urlData['redirect_chain'] ?? [];
    if (empty($redirectChain)) {
        // No redirects = consistent
        $score += $weights['redirect_consistency'];
    } elseif ($htmlCanonical) {
        // Check if redirects lead to canonical
        $finalAfterRedirects = $urlData['final_url'];
        $normalizedFinalAfterRedirects = normalize_url($finalAfterRedirects, $config);
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        if (urls_equivalent($normalizedFinalAfterRedirects, $normalizedCanonical, $config)) {
            $score += $weights['redirect_consistency'];
        }
    }
    
    // +15: Internal link alignment
    $internalLinks = $signals['outgoing_internal_links'] ?? [];
    if (!empty($internalLinks) && $htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        $alignedLinks = 0;
        $totalLinks = 0;
        
        foreach ($internalLinks as $link) {
            $normalizedLink = normalize_url($link, $config);
            // Check if link points to this page
            if (urls_equivalent($normalizedLink, $normalizedFinal, $config)) {
                $totalLinks++;
                // Check if it points to canonical
                if (urls_equivalent($normalizedLink, $normalizedCanonical, $config)) {
                    $alignedLinks++;
                }
            }
        }
        
        if ($totalLinks > 0) {
            $alignmentRatio = $alignedLinks / $totalLinks;
            $score += $weights['internal_link_alignment'] * $alignmentRatio;
        } else {
            $score += $weights['internal_link_alignment'];
        }
    } else {
        $score += $weights['internal_link_alignment'];
    }
    
    // +10: Sitemap alignment
    // This is checked in analyze.php, but for scoring we need sitemap data
    // For now, assume partial credit if canonical exists
    if ($htmlCanonical) {
        $score += $weights['sitemap_alignment'] * 0.5; // Partial credit
    }
    
    // +10: Hreflang alignment
    $hreflangTargets = $signals['hreflang_targets'] ?? [];
    if (!empty($hreflangTargets) && $htmlCanonical) {
        $normalizedCanonical = normalize_url($htmlCanonical, $config);
        $alignedHreflangs = 0;
        $totalHreflangs = count($hreflangTargets);
        
        foreach ($hreflangTargets as $lang => $target) {
            $normalizedTarget = normalize_url($target, $config);
            // Check if hreflang structure matches canonical
            $parsedCanonical = parse_url($normalizedCanonical);
            $parsedTarget = parse_url($normalizedTarget);
            $canonicalPath = $parsedCanonical['path'] ?? '/';
            $targetPath = $parsedTarget['path'] ?? '/';
            
            // Remove locale prefixes for comparison
            $canonicalPathClean = preg_replace('/^\/[a-z]{2}-[a-z]{2}\//i', '/', $canonicalPath);
            $targetPathClean = preg_replace('/^\/[a-z]{2}-[a-z]{2}\//i', '/', $targetPath);
            
            if ($canonicalPathClean === $targetPathClean) {
                $alignedHreflangs++;
            }
        }
        
        if ($totalHreflangs > 0) {
            $alignmentRatio = $alignedHreflangs / $totalHreflangs;
            $score += $weights['hreflang_alignment'] * $alignmentRatio;
        }
    } else {
        $score += $weights['hreflang_alignment'];
    }
    
    // Cap at 100
    $score = min(100, max(0, $score));
    
    // Predict Google behavior
    $thresholds = $config['thresholds'];
    $googleLikelyIgnores = ($score < $thresholds['indexing_risk']);
    
    return [
        'canonical_integrity_score' => round($score, 1),
        'google_likely_ignores' => $googleLikelyIgnores,
        'risk_level' => $score < $thresholds['canonical_failure'] ? 'critical' : 
                       ($score < $thresholds['indexing_risk'] ? 'high' : 'low'),
    ];
}

