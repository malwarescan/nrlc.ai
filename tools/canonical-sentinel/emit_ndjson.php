<?php
/**
 * NDJSON Output Formatter
 * 
 * Emits one JSON object per line (NDJSON format) for Crouton/Graph processing.
 */

/**
 * Emit NDJSON output for all analyzed URLs
 * 
 * @param array $results Array of analysis results with scoring
 * @param string $outputFile Output file path
 * @return int Number of records written
 */
function emit_ndjson(array $results, string $outputFile): int {
    $count = 0;
    $fp = fopen($outputFile, 'w');
    
    if (!$fp) {
        throw new RuntimeException("Cannot write to output file: $outputFile");
    }
    
    foreach ($results as $result) {
        $record = [
            'url' => $result['url'] ?? '',
            'final_url' => $result['final_url'] ?? $result['url'],
            'status' => $result['status'] ?? 0,
            'declared_canonical' => $result['declared_canonical'] ?? null,
            'canonical_status' => $result['canonical_status'] ?? null,
            'redirect_chain' => $result['redirect_chain'] ?? [],
            'mismatch_types' => $result['mismatch_types'] ?? [],
            'canonical_integrity_score' => $result['canonical_integrity_score'] ?? 0,
            'google_likely_ignores' => $result['google_likely_ignores'] ?? false,
            'risk_level' => $result['risk_level'] ?? 'unknown',
        ];
        
        $json = json_encode($record, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        fwrite($fp, $json . "\n");
        $count++;
    }
    
    fclose($fp);
    return $count;
}

