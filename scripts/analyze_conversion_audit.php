<?php
/**
 * Analyze GSC Conversion Audit Results
 * 
 * Generates actionable insights from the conversion audit report
 */

$csvPath = __DIR__ . '/gsc_conversion_audit_report.csv';

if (!file_exists($csvPath)) {
    die("Error: Audit report not found. Run qa_gsc_conversion_audit.php first.\n");
}

// Read results
$results = [];
$handle = fopen($csvPath, 'r');
$header = fgetcsv($handle, 0, ',', '"', '\\');
$headerMap = array_flip($header);

while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
    if (count($row) < count($header)) continue;
    
    $result = [];
    foreach ($headerMap as $key => $index) {
        $result[$key] = $row[$index] ?? '';
    }
    $results[] = $result;
}
fclose($handle);

// Analysis
$total = count($results);
$successful = count(array_filter($results, fn($r) => ($r['HTTP Code'] ?? '') == '200' && ($r['Has Error'] ?? '') == 'No'));
$hasPhone = count(array_filter($results, fn($r) => ($r['Has Phone'] ?? '') == 'Yes'));
$hasEmail = count(array_filter($results, fn($r) => ($r['Has Email'] ?? '') == 'Yes'));
$hasCta = count(array_filter($results, fn($r) => ($r['Has CTA'] ?? '') == 'Yes' || ($r['Has openContactSheet'] ?? '') == 'Yes'));
$hasSchema = count(array_filter($results, fn($r) => ($r['Has Schema'] ?? '') == 'Yes'));

// Calculate scores
$scores = array_map(function($r) {
    return intval($r['Conversion Score'] ?? 0);
}, $results);

$avgScore = $total > 0 ? array_sum($scores) / $total : 0;
$lowScore = count(array_filter($scores, fn($s) => $s < 50));
$highScore = count(array_filter($scores, fn($s) => $s >= 80));

// Pages needing attention (high impressions, low conversion score)
$needsAttention = array_filter($results, function($r) {
    $impressions = intval($r['Impressions'] ?? 0);
    $score = intval($r['Conversion Score'] ?? 0);
    return $impressions > 50 && $score < 70;
});

// Sort by impressions
usort($needsAttention, function($a, $b) {
    return intval($b['Impressions'] ?? 0) - intval($a['Impressions'] ?? 0);
});

// Generate report
echo "GSC Conversion Audit Analysis\n";
echo "==============================\n\n";

echo "Overall Statistics\n";
echo "------------------\n";
echo "Total pages tested: $total\n";
echo "Successful (HTTP 200): $successful (" . round($successful / $total * 100, 1) . "%)\n";
echo "Pages with phone: $hasPhone (" . round($hasPhone / $total * 100, 1) . "%)\n";
echo "Pages with email: $hasEmail (" . round($hasEmail / $total * 100, 1) . "%)\n";
echo "Pages with CTA: $hasCta (" . round($hasCta / $total * 100, 1) . "%)\n";
echo "Pages with schema: $hasSchema (" . round($hasSchema / $total * 100, 1) . "%)\n";
echo "Average conversion score: " . round($avgScore, 1) . "/100\n";
echo "Low score pages (<50): $lowScore (" . round($lowScore / $total * 100, 1) . "%)\n";
echo "High score pages (>=80): $highScore (" . round($highScore / $total * 100, 1) . "%)\n\n";

echo "Top Priority Pages (High Impressions, Low Conversion Score)\n";
echo "------------------------------------------------------------\n";
$top20 = array_slice($needsAttention, 0, 20);
foreach ($top20 as $i => $page) {
    echo ($i + 1) . ". {$page['URL']}\n";
    echo "   Impressions: {$page['Impressions']}, Clicks: {$page['Clicks']}, CTR: {$page['CTR']}%, Position: {$page['Position']}\n";
    echo "   Conversion Score: {$page['Conversion Score']}/100\n";
    echo "   Phone: " . ($page['Has Phone'] == 'Yes' ? '✓' : '✗') . " | Email: " . ($page['Has Email'] == 'Yes' ? '✓' : '✗') . " | CTA: " . (($page['Has CTA'] == 'Yes' || $page['Has openContactSheet'] == 'Yes') ? '✓' : '✗') . " | Schema: " . ($page['Has Schema'] == 'Yes' ? '✓' : '✗') . "\n";
    if (!empty($page['Recommendations'])) {
        echo "   Issues: {$page['Recommendations']}\n";
    }
    echo "\n";
}

// Recommendations by issue type
echo "Recommendations by Issue Type\n";
echo "------------------------------\n";

$missingPhone = array_filter($results, fn($r) => ($r['Has Phone'] ?? '') == 'No' && intval($r['Impressions'] ?? 0) > 0);
$missingEmail = array_filter($results, fn($r) => ($r['Has Email'] ?? '') == 'No' && intval($r['Impressions'] ?? 0) > 0);
$missingCta = array_filter($results, fn($r) => ($r['Has CTA'] ?? '') == 'No' && ($r['Has openContactSheet'] ?? '') == 'No' && intval($r['Impressions'] ?? 0) > 0);
$missingSchema = array_filter($results, fn($r) => ($r['Has Schema'] ?? '') == 'No' && intval($r['Impressions'] ?? 0) > 0);
$noindexPages = array_filter($results, fn($r) => ($r['Noindex'] ?? '') == 'Yes' && intval($r['Impressions'] ?? 0) > 0);

echo "Pages missing phone number: " . count($missingPhone) . "\n";
echo "Pages missing email: " . count($missingEmail) . "\n";
echo "Pages missing CTA: " . count($missingCta) . "\n";
echo "Pages missing schema: " . count($missingSchema) . "\n";
echo "Pages with noindex: " . count($noindexPages) . "\n\n";

// High-value pages (high impressions) missing conversion elements
echo "High-Value Pages Missing Conversion Elements\n";
echo "--------------------------------------------\n";

$highValueMissing = array_filter($results, function($r) {
    $impressions = intval($r['Impressions'] ?? 0);
    $hasPhone = ($r['Has Phone'] ?? '') == 'Yes';
    $hasEmail = ($r['Has Email'] ?? '') == 'Yes';
    $hasCta = ($r['Has CTA'] ?? 'Yes') == 'Yes' || ($r['Has openContactSheet'] ?? 'Yes') == 'Yes';
    return $impressions > 100 && (!$hasPhone || !$hasEmail || !$hasCta);
});

usort($highValueMissing, function($a, $b) {
    return intval($b['Impressions'] ?? 0) - intval($a['Impressions'] ?? 0);
});

$top10 = array_slice($highValueMissing, 0, 10);
foreach ($top10 as $i => $page) {
    echo ($i + 1) . ". {$page['URL']}\n";
    echo "   Impressions: {$page['Impressions']}, Missing: ";
    $missing = [];
    if ($page['Has Phone'] != 'Yes') $missing[] = 'Phone';
    if ($page['Has Email'] != 'Yes') $missing[] = 'Email';
    if ($page['Has CTA'] != 'Yes' && $page['Has openContactSheet'] != 'Yes') $missing[] = 'CTA';
    echo implode(', ', $missing) . "\n\n";
}

echo "\nReport complete. Review the full CSV for detailed analysis.\n";

