<?php
/**
 * Service Page Classifier Audit Script
 * 
 * Audits a service page URL against the SERVICE_PAGE_CLASSIFIER_AUDIT checklist.
 * Usage: php scripts/audit_service_page.php <url>
 * 
 * Example: php scripts/audit_service_page.php https://nrlc.ai/services/ai-search-optimization/
 */

if ($argc < 2) {
    echo "Usage: php scripts/audit_service_page.php <url>\n";
    echo "Example: php scripts/audit_service_page.php https://nrlc.ai/services/ai-search-optimization/\n";
    exit(1);
}

$url = $argv[1];

// Fetch the page
$html = @file_get_contents($url);
if ($html === false) {
    echo "ERROR: Could not fetch URL: $url\n";
    exit(1);
}

$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

$results = [];
$passed = 0;
$failed = 0;

// A. URL + Intent Lock
echo "A. URL + Intent Lock\n";
echo str_repeat("=", 80) . "\n";

$parsedUrl = parse_url($url);
$path = $parsedUrl['path'] ?? '';

// Check if URL is a service URL
if (preg_match('#/services/([^/]+)/?$#', $path, $matches)) {
    $serviceSlug = $matches[1];
    echo "✓ URL is a service URL: /services/$serviceSlug/\n";
    $results['A'] = ['status' => 'PASS', 'slug' => $serviceSlug];
    $passed++;
} else {
    echo "✗ URL does not match service pattern\n";
    $results['A'] = ['status' => 'FAIL', 'reason' => 'URL pattern'];
    $failed++;
}

// Check canonical
$canonicals = $xpath->query("//link[@rel='canonical']");
if ($canonicals->length > 0) {
    $canonical = $canonicals->item(0)->getAttribute('href');
    if ($canonical === $url || str_replace('https://', 'http://', $canonical) === str_replace('https://', 'http://', $url)) {
        echo "✓ Canonical is self-referencing: $canonical\n";
        $results['A_canonical'] = ['status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ Canonical does not match URL: $canonical\n";
        $results['A_canonical'] = ['status' => 'FAIL', 'canonical' => $canonical];
        $failed++;
    }
} else {
    echo "✗ No canonical tag found\n";
    $results['A_canonical'] = ['status' => 'FAIL', 'reason' => 'missing'];
    $failed++;
}

// B. Title (Classification Gate)
echo "\nB. <title> (Classification Gate)\n";
echo str_repeat("=", 80) . "\n";

$titleNodes = $xpath->query("//title");
if ($titleNodes->length > 0) {
    $title = trim($titleNodes->item(0)->textContent);
    echo "Title: $title\n";
    
    $checks = [
        'contains_service' => preg_match('/\b(service|optimization|audit|implementation|consulting)\b/i', $title),
        'contains_for_businesses' => preg_match('/for\s+(businesses|companies|organizations)/i', $title),
        'contains_company_name' => preg_match('/Neural Command|NRLC/i', $title),
        'not_research' => !preg_match('/\b(research|philosophy|theory|framework)\b/i', $title),
    ];
    
    foreach ($checks as $check => $result) {
        if ($result) {
            echo "✓ $check\n";
            $passed++;
        } else {
            echo "✗ $check\n";
            $failed++;
        }
    }
    
    $results['B'] = ['status' => $failed === 0 ? 'PASS' : 'FAIL', 'title' => $title, 'checks' => $checks];
} else {
    echo "✗ No title tag found\n";
    $results['B'] = ['status' => 'FAIL', 'reason' => 'missing'];
    $failed++;
}

// C. Meta Description
echo "\nC. Meta Description (Vendor Confirmation)\n";
echo str_repeat("=", 80) . "\n";

$metaDescNodes = $xpath->query("//meta[@name='description']");
if ($metaDescNodes->length > 0) {
    $description = trim($metaDescNodes->item(0)->getAttribute('content'));
    echo "Description: $description\n";
    
    $checks = [
        'has_service_offer' => preg_match('/provides|offers|delivers/i', $description),
        'has_audience' => preg_match('/\b(businesses|companies|organizations|clients)\b/i', $description),
        'has_outcome' => preg_match('/\b(improve|increase|optimize|enhance|get|achieve)\b/i', $description),
        'not_thought_leadership' => !preg_match('/\b(insight|thought|philosophy|vision|future)\b/i', $description),
    ];
    
    foreach ($checks as $check => $result) {
        if ($result) {
            echo "✓ $check\n";
            $passed++;
        } else {
            echo "✗ $check\n";
            $failed++;
        }
    }
    
    $results['C'] = ['status' => array_sum($checks) >= 3 ? 'PASS' : 'FAIL', 'description' => $description];
} else {
    echo "✗ No meta description found\n";
    $results['C'] = ['status' => 'FAIL', 'reason' => 'missing'];
    $failed++;
}

// D. Above-the-Fold Block
echo "\nD. Above-the-Fold Block (Hard Requirement)\n";
echo str_repeat("=", 80) . "\n";

// Find main content area (first 2000 chars)
$mainContent = '';
$bodyNodes = $xpath->query("//main | //body");
if ($bodyNodes->length > 0) {
    $mainContent = substr($bodyNodes->item(0)->textContent, 0, 2000);
}

// Check for H1
$h1Nodes = $xpath->query("//h1");
if ($h1Nodes->length === 1) {
    $h1 = trim($h1Nodes->item(0)->textContent);
    echo "✓ H1 found (exactly one): $h1\n";
    $passed++;
} else {
    echo "✗ H1 count: " . $h1Nodes->length . " (expected: 1)\n";
    $failed++;
}

// Check for definition sentence
$hasDefinition = preg_match('/Neural Command LLC provides .+ for businesses/i', $mainContent);
if ($hasDefinition) {
    echo "✓ Definition sentence found\n";
    $passed++;
} else {
    echo "✗ Definition sentence not found (should contain: 'Neural Command LLC provides {service} for businesses')\n";
    $failed++;
}

// Check for CTA button
$hasCTA = preg_match('/\b(Get|Request|Schedule|Contact|Book).*\b(consultation|audit|assessment|demo)\b/i', $mainContent);
if ($hasCTA) {
    echo "✓ Primary CTA found\n";
    $passed++;
} else {
    echo "✗ Primary CTA not found (should contain service-specific action)\n";
    $failed++;
}

$results['D'] = ['status' => ($h1Nodes->length === 1 && $hasDefinition && $hasCTA) ? 'PASS' : 'FAIL'];

// J. Structured Data Verification
echo "\nJ. Structured Data Verification\n";
echo str_repeat("=", 80) . "\n";

// Extract JSON-LD
$jsonLdScripts = $xpath->query("//script[@type='application/ld+json']");
$hasOrganization = false;
$hasService = false;
$serviceHasProvider = false;
$hasLocalBusiness = false;
$orgId = null;

foreach ($jsonLdScripts as $script) {
    $json = json_decode($script->textContent, true);
    if ($json === null) continue;
    
    // Handle @graph
    $items = isset($json['@graph']) ? $json['@graph'] : [$json];
    
    foreach ($items as $item) {
        if (isset($item['@type'])) {
            if ($item['@type'] === 'Organization') {
                $hasOrganization = true;
                if (isset($item['@id'])) {
                    $orgId = $item['@id'];
                }
            }
            if ($item['@type'] === 'Service') {
                $hasService = true;
                if (isset($item['provider']) && isset($item['provider']['@id'])) {
                    $serviceHasProvider = true;
                }
            }
            if ($item['@type'] === 'LocalBusiness') {
                $hasLocalBusiness = true;
            }
        }
    }
}

if ($hasOrganization) {
    echo "✓ Organization schema found";
    if ($orgId) {
        echo " (@id: $orgId)";
    }
    echo "\n";
    $passed++;
} else {
    echo "✗ Organization schema not found\n";
    $failed++;
}

if ($hasService) {
    echo "✓ Service schema found\n";
    $passed++;
} else {
    echo "✗ Service schema not found\n";
    $failed++;
}

if ($serviceHasProvider) {
    echo "✓ Service → provider references Organization @id\n";
    $passed++;
} else {
    echo "✗ Service schema does not reference Organization @id\n";
    $failed++;
}

if (!$hasLocalBusiness) {
    echo "✓ No LocalBusiness schema (correct)\n";
    $passed++;
} else {
    echo "✗ LocalBusiness schema found (should be removed)\n";
    $failed++;
}

$results['J'] = ['status' => ($hasOrganization && $hasService && $serviceHasProvider && !$hasLocalBusiness) ? 'PASS' : 'FAIL'];

// Summary
echo "\n" . str_repeat("=", 80) . "\n";
echo "SUMMARY\n";
echo str_repeat("=", 80) . "\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
echo "Total Checks: " . ($passed + $failed) . "\n";

if ($failed === 0) {
    echo "\n✓ PAGE PASSES AUDIT - All requirements met.\n";
    exit(0);
} else {
    echo "\n✗ PAGE FAILS AUDIT - Fix issues before launch.\n";
    exit(1);
}


