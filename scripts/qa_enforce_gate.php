<?php
/**
 * QA Gate Enforcer - Hard Fail on Critical Issues
 * 
 * Blocks deployment if any hard invariants fail:
 * - Canonical URLs not in sitemap
 * - Non-canonical URLs in sitemap
 * - Redirect failures
 * - Canonical target not resolvable
 * - Locale/city mismatches
 */

if ($argc < 2) {
    fwrite(STDERR, "Usage: php qa_enforce_gate.php <results.csv>\n");
    exit(2);
}

$path = $argv[1];
if (!file_exists($path)) {
    fwrite(STDERR, "Missing results file: $path\n");
    exit(2);
}

$handle = fopen($path, 'r');
if ($handle === false) {
    fwrite(STDERR, "Could not open results file: $path\n");
    exit(2);
}

$header = fgetcsv($handle);
if ($header === false) {
    fwrite(STDERR, "Could not read header from results file\n");
    exit(2);
}

$idx = array_flip($header);

// Expected columns (adapt to your actual output)
$urlIdx = $idx['URL'] ?? null;
$statusIdx = $idx['Status'] ?? null;
$issuesIdx = $idx['Issues'] ?? null;

if ($urlIdx === null || $statusIdx === null) {
    fwrite(STDERR, "Missing required columns in CSV. Found: " . implode(', ', array_keys($idx)) . "\n");
    exit(2);
}

$critical = 0;
$warnings = 0;
$rows = 0;
$failures = [];

// Hard fail conditions
$hardFailPatterns = [
    'Canonical URL not in sitemap',
    'Non-canonical URL incorrectly in sitemap',
    'Redirect does not go to canonical',
    'Canonical URL returns status',
    'Locale mismatch',
    'Canonical target not in sitemap'
];

while (($row = fgetcsv($handle)) !== false) {
    $rows++;
    $status = strtolower(trim($row[$statusIdx] ?? ''));
    $issues = $row[$issuesIdx] ?? '';
    $url = $row[$urlIdx] ?? '';
    
    if ($status === 'fail') {
        // Check if any hard fail pattern matches
        $isCritical = false;
        foreach ($hardFailPatterns as $pattern) {
            if (stripos($issues, $pattern) !== false) {
                $isCritical = true;
                break;
            }
        }
        
        if ($isCritical) {
            $critical++;
            $failures[] = [
                'url' => $url,
                'issues' => $issues
            ];
        } else {
            $warnings++;
        }
    }
}
fclose($handle);

// Output summary
echo "=== QA GATE RESULTS ===\n\n";
echo "Total URLs checked: $rows\n";
echo "Critical failures: $critical\n";
echo "Warnings: $warnings\n";
echo "\n";

if ($critical > 0) {
    echo "❌ QA GATE FAILED: $critical critical failures found\n\n";
    echo "Critical Failures:\n";
    foreach (array_slice($failures, 0, 20) as $failure) {
        echo "  - {$failure['url']}\n";
        echo "    Issues: {$failure['issues']}\n";
    }
    if (count($failures) > 20) {
        echo "  ... and " . (count($failures) - 20) . " more\n";
    }
    echo "\n";
    echo "Deployment blocked. Fix critical issues before deploying.\n";
    exit(1);
}

if ($warnings > 0) {
    echo "⚠️  QA GATE PASSED with $warnings warnings\n";
    echo "Review warnings but deployment allowed.\n";
    exit(0);
}

echo "✅ QA GATE PASSED: 0 critical failures, 0 warnings\n";
exit(0);

