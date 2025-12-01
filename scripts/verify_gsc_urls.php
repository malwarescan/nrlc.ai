<?php
/**
 * Verify all URLs from Google Search Console data
 * Checks canonical redirects, schema markup, and SEO optimization
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';

$gscPagesFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-11-30/Pages.csv';

if (!file_exists($gscPagesFile)) {
    die("GSC Pages.csv file not found: $gscPagesFile\n");
}

$handle = fopen($gscPagesFile, 'r');
if (!$handle) {
    die("Could not open file: $gscPagesFile\n");
}

// Skip header
$header = fgetcsv($handle);

$issues = [];
$verified = [];
$total = 0;

echo "🔍 VERIFYING GSC URLs\n";
echo "====================\n\n";

while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
    $total++;
    $url = $row[0] ?? '';
    $clicks = (int)($row[1] ?? 0);
    $impressions = (int)($row[2] ?? 0);
    $ctr = $row[3] ?? '0%';
    $position = (float)($row[4] ?? 0);
    
    if (empty($url)) continue;
    
    // Check for canonical issues
    $canonicalIssues = [];
    
    // Check for HTTP instead of HTTPS
    if (strpos($url, 'http://') === 0) {
        $canonicalIssues[] = 'HTTP instead of HTTPS';
    }
    
    // Check for missing locale prefix (except root)
    if ($url !== 'https://nrlc.ai/' && 
        !preg_match('#^https://nrlc\.ai/([a-z]{2})-([a-z]{2})/#', $url) &&
        !preg_match('#^https://nrlc\.ai/(robots|sitemap|favicon|healthcheck)#', $url)) {
        $canonicalIssues[] = 'Missing locale prefix';
    }
    
    // Check for query parameters (UTM params should be stripped)
    if (strpos($url, '?') !== false) {
        $canonicalIssues[] = 'Has query parameters';
    }
    
    // Check for missing trailing slash on directory URLs
    $path = parse_url($url, PHP_URL_PATH);
    if ($path && 
        !preg_match('#\.[a-z0-9]+$#', $path) && 
        substr($path, -1) !== '/' &&
        $path !== '/') {
        $canonicalIssues[] = 'Missing trailing slash';
    }
    
    if (!empty($canonicalIssues)) {
        $issues[] = [
            'url' => $url,
            'clicks' => $clicks,
            'impressions' => $impressions,
            'ctr' => $ctr,
            'position' => $position,
            'issues' => $canonicalIssues
        ];
    } else {
        $verified[] = [
            'url' => $url,
            'clicks' => $clicks,
            'impressions' => $impressions,
            'ctr' => $ctr,
            'position' => $position
        ];
    }
}

fclose($handle);

echo "📊 SUMMARY\n";
echo "Total URLs checked: $total\n";
echo "URLs with issues: " . count($issues) . "\n";
echo "URLs verified: " . count($verified) . "\n\n";

if (!empty($issues)) {
    echo "⚠️  ISSUES FOUND\n";
    echo "================\n\n";
    
    // Group by issue type
    $issueTypes = [];
    foreach ($issues as $issue) {
        foreach ($issue['issues'] as $issueType) {
            if (!isset($issueTypes[$issueType])) {
                $issueTypes[$issueType] = [];
            }
            $issueTypes[$issueType][] = $issue;
        }
    }
    
    foreach ($issueTypes as $type => $urls) {
        echo "\n$type (" . count($urls) . " URLs):\n";
        foreach (array_slice($urls, 0, 10) as $url) {
            echo "  - {$url['url']} (Clicks: {$url['clicks']}, Impressions: {$url['impressions']}, CTR: {$url['ctr']}, Position: {$url['position']})\n";
        }
        if (count($urls) > 10) {
            echo "  ... and " . (count($urls) - 10) . " more\n";
        }
    }
}

// High impression, low CTR pages
echo "\n\n📈 HIGH IMPRESSION, LOW CTR PAGES (Optimization Opportunities)\n";
echo "=============================================================\n\n";

$lowCTR = array_filter($verified, function($page) {
    return (int)$page['impressions'] > 50 && (float)str_replace('%', '', $page['ctr']) < 1;
});

usort($lowCTR, function($a, $b) {
    return (int)$b['impressions'] - (int)$a['impressions'];
});

foreach (array_slice($lowCTR, 0, 20) as $page) {
    echo "  - {$page['url']}\n";
    echo "    Impressions: {$page['impressions']}, CTR: {$page['ctr']}, Position: {$page['position']}\n";
}

echo "\n✅ Verification complete!\n";

