<?php
/**
 * Fix Directive Generator
 * 
 * Generates plain-English, dev-ready fix instructions for each mismatch.
 */

require_once __DIR__ . '/analyze.php';

/**
 * Generate fix directive for a mismatch type
 * 
 * @param string $mismatchType Mismatch type constant
 * @param array $urlData URL data with signals
 * @param array $analysis Analysis result
 * @return string Fix directive text
 */
function generate_fix_directive(string $mismatchType, array $urlData, array $analysis): string {
    $url = $urlData['final_url'];
    $signals = $urlData['signals'] ?? [];
    $htmlCanonical = $signals['html_canonical'] ?? null;
    
    switch ($mismatchType) {
        case MISMATCH_SELF_CANONICAL_FAILURE:
            if (!$htmlCanonical) {
                return "Add self-referencing canonical tag: <link rel=\"canonical\" href=\"$url\" />";
            } else {
                $declared = $analysis['declared_canonical'] ?? '';
                return "Update canonical tag to self-reference. Current: $declared, Should be: $url";
            }
            
        case MISMATCH_CANONICAL_REDIRECT:
            $declared = $analysis['declared_canonical'] ?? '';
            return "Canonical URL redirects: $declared. Ensure canonical points directly to final URL (no redirects).";
            
        case MISMATCH_CANONICAL_NON_200:
            $declared = $analysis['declared_canonical'] ?? '';
            $status = $analysis['canonical_status'] ?? $analysis['status'] ?? 'unknown';
            $pageStatus = $analysis['status'] ?? 0;
            
            if ($pageStatus >= 500 && $pageStatus < 600) {
                return "Page returned $pageStatus error. Server error prevents canonical tag extraction. Fix server issues first.";
            } elseif ($declared) {
                return "Canonical URL returns non-200 status ($status): $declared. Fix canonical URL to return 200 OK.";
            } else {
                return "Page returned non-200 status ($status). Fix server issues to allow canonical tag extraction.";
            }
            
        case MISMATCH_HEADER_HTML_SPLIT:
            $htmlCanonical = $signals['html_canonical'] ?? '';
            $headerCanonical = $signals['header_canonical'] ?? '';
            return "Canonical mismatch: HTML says $htmlCanonical, Header says $headerCanonical. Align both to same URL.";
            
        case MISMATCH_SITEMAP_CONFLICT:
            $declared = $analysis['declared_canonical'] ?? '';
            return "URL in sitemap but canonical ($declared) points elsewhere. Either remove from sitemap or update canonical to match sitemap entry.";
            
        case MISMATCH_INTERNAL_LINK_OVERRIDE:
            return "Internal links point to non-canonical version of this page. Update all internal links to use canonical URL: " . ($htmlCanonical ?: $url);
            
        case MISMATCH_HREFLANG_CONFLICT:
            $hreflangTargets = $signals['hreflang_targets'] ?? [];
            $targetsList = implode(', ', array_values($hreflangTargets));
            return "Hreflang targets don't match canonical structure. Targets: $targetsList. Ensure hreflang URLs align with canonical structure.";
            
        case MISMATCH_PARAMETER_COLLAPSE:
            $queryParams = $signals['query_parameters'] ?? [];
            $paramsList = implode(', ', array_keys($queryParams));
            return "Query parameters in URL ($paramsList) but missing from canonical. Either strip params from URL or include in canonical.";
            
        case MISMATCH_PROTOCOL_HOST_DRIFT:
            $declared = $analysis['declared_canonical'] ?? '';
            return "Canonical uses different protocol or host: $declared. Ensure canonical uses same protocol (https) and host as page URL.";
            
        default:
            return "Unknown mismatch type: $mismatchType";
    }
}

/**
 * Generate all fix directives for a URL
 * 
 * @param array $urlData URL data
 * @param array $analysis Analysis result
 * @return array Array of fix directive strings
 */
function generate_fix_directives(array $urlData, array $analysis): array {
    $directives = [];
    $mismatches = $analysis['mismatch_types'] ?? [];
    
    foreach ($mismatches as $mismatchType) {
        $directive = generate_fix_directive($mismatchType, $urlData, $analysis);
        $directives[] = $directive;
    }
    
    return $directives;
}

/**
 * Emit fix directives to file
 * 
 * @param array $results Array of all analysis results
 * @param string $outputFile Output file path
 * @return int Number of directives written
 */
function emit_directives(array $results, string $outputFile): int {
    $count = 0;
    $fp = fopen($outputFile, 'w');
    
    if (!$fp) {
        throw new RuntimeException("Cannot write to directives file: $outputFile");
    }
    
    foreach ($results as $result) {
        $url = $result['url'] ?? $result['final_url'] ?? 'unknown';
        $mismatches = $result['mismatch_types'] ?? [];
        
        if (empty($mismatches)) {
            continue; // Skip URLs with no issues
        }
        
        fwrite($fp, "\n" . str_repeat('=', 80) . "\n");
        fwrite($fp, "URL: $url\n");
        fwrite($fp, "Score: " . ($result['canonical_integrity_score'] ?? 0) . "/100\n");
        fwrite($fp, "Risk: " . ($result['risk_level'] ?? 'unknown') . "\n");
        fwrite($fp, str_repeat('-', 80) . "\n");
        
        $directives = generate_fix_directives($result, $result);
        foreach ($directives as $directive) {
            fwrite($fp, "- $directive\n");
            $count++;
        }
    }
    
    fclose($fp);
    return $count;
}

