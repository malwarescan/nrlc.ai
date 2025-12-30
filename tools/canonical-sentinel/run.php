#!/usr/bin/env php
<?php
/**
 * Canonical Sentinel - CLI Entry Point
 * 
 * Orchestrates the entire canonical scanning process:
 * Crawl → Extract → Normalize → Analyze → Score → Emit
 * 
 * Usage:
 *   php run.php --start=https://example.com --scope=domain --depth=5
 */

require_once __DIR__ . '/execute_scan.php';
require_once __DIR__ . '/emit_ndjson.php';
require_once __DIR__ . '/emit_directives.php';

/**
 * Parse command line arguments
 * 
 * @return array Parsed arguments
 */
function parse_args(): array {
    global $argv;
    
    $args = [
        'start' => null,
        'scope' => 'domain',
        'depth' => 5,
        'output_dir' => __DIR__ . '/output',
    ];
    
    $cliArgs = $argv ?? [];
    foreach ($cliArgs as $arg) {
        if (preg_match('/^--start=(.+)$/', $arg, $m)) {
            $args['start'] = $m[1];
        } elseif (preg_match('/^--scope=(.+)$/', $arg, $m)) {
            $args['scope'] = $m[1];
        } elseif (preg_match('/^--depth=(\d+)$/', $arg, $m)) {
            $args['depth'] = (int)$m[1];
        } elseif (preg_match('/^--output=(.+)$/', $arg, $m)) {
            $args['output_dir'] = $m[1];
        }
    }
    
    return $args;
}

/**
 * Main execution function
 */
function main(): void {
    $config = require __DIR__ . '/config.php';
    $args = parse_args();
    
    // Validate start URL
    if (!$args['start']) {
        fwrite(STDERR, "Error: --start URL is required\n");
        fwrite(STDERR, "Usage: php run.php --start=https://example.com [--scope=domain] [--depth=5] [--output=./output]\n");
        exit(1);
    }
    
    $startUrl = $args['start'];
    if (!filter_var($startUrl, FILTER_VALIDATE_URL)) {
        fwrite(STDERR, "Error: Invalid URL: $startUrl\n");
        exit(1);
    }
    
    // Create output directory
    $outputDir = $args['output_dir'];
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
    }
    
    $config = require __DIR__ . '/config.php';
    $ndjsonFile = $outputDir . '/' . $config['output']['ndjson_file'];
    $summaryFile = $outputDir . '/' . $config['output']['summary_file'];
    $directivesFile = $outputDir . '/' . $config['output']['directives_file'];
    
    fwrite(STDOUT, "Canonical Sentinel v1.0\n");
    fwrite(STDOUT, "=====================\n\n");
    fwrite(STDOUT, "Starting URL: $startUrl\n");
    fwrite(STDOUT, "Scope: {$args['scope']}\n");
    fwrite(STDOUT, "Max Depth: {$args['depth']}\n\n");
    
    // Execute scan
    fwrite(STDOUT, "Executing scan...\n");
    $scanData = execute_canonical_scan($startUrl, [
        'depth' => $args['depth'],
    ]);
    
    $results = $scanData['results'];
    $summary = $scanData['summary'];
    
    fwrite(STDOUT, "   Found " . count($results) . " URLs\n");
    fwrite(STDOUT, "   Average score: {$summary['average_score']}/100\n\n");
    
    // Phase 6: Emit files
    fwrite(STDOUT, "Emitting output files...\n");
    $ndjsonCount = emit_ndjson($results, $ndjsonFile);
    fwrite(STDOUT, "   Wrote $ndjsonCount records to $ndjsonFile\n");
    
    $directiveCount = emit_directives($results, $directivesFile);
    fwrite(STDOUT, "   Wrote $directiveCount directives to $directivesFile\n");
    
    file_put_contents($summaryFile, json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    fwrite(STDOUT, "   Wrote summary to $summaryFile\n\n");
    
    // Print summary
    fwrite(STDOUT, "Scan Complete\n");
    fwrite(STDOUT, "=============\n");
    fwrite(STDOUT, "Total URLs: {$summary['total_urls']}\n");
    fwrite(STDOUT, "URLs with mismatches: {$summary['urls_with_mismatches']}\n");
    fwrite(STDOUT, "Average score: {$summary['average_score']}/100\n");
    fwrite(STDOUT, "Risk distribution:\n");
    fwrite(STDOUT, "  Critical: {$summary['risk_distribution']['critical']}\n");
    fwrite(STDOUT, "  High: {$summary['risk_distribution']['high']}\n");
    fwrite(STDOUT, "  Low: {$summary['risk_distribution']['low']}\n");
    fwrite(STDOUT, "\nOutput files:\n");
    fwrite(STDOUT, "  NDJSON: $ndjsonFile\n");
    fwrite(STDOUT, "  Summary: $summaryFile\n");
    fwrite(STDOUT, "  Directives: $directivesFile\n");
}

// Run if executed directly
if (php_sapi_name() === 'cli') {
    main();
}

