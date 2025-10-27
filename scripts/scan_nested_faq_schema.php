<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/deterministic.php';
require_once __DIR__.'/../lib/content_tokens.php';

/**
 * Scan all pages for nested FAQ schema issues
 * 
 * This script checks for:
 * 1. Pages using ld_service_hefty() with nested FAQ schema
 * 2. Any other patterns that might cause schema validation issues
 */

function scan_for_nested_faq_issues(): array {
    $issues = [];
    
    // Get all URLs from Table.csv
    $urls = csv_rows_local('Table.csv');
    
    foreach ($urls as $row) {
        $url = $row['url'] ?? '';
        if (empty($url)) continue;
        
        $path = parse_url($url, PHP_URL_PATH);
        if (empty($path)) continue;
        
        // Check if this is a service page
        if (strpos($path, '/services/') === 0) {
            $pathParts = explode('/', trim($path, '/'));
            
            // Check for service/city pattern: /services/service-name/city-name/
            if (count($pathParts) >= 3 && $pathParts[0] === 'services') {
                $serviceSlug = $pathParts[1];
                $citySlug = $pathParts[2];
                
                // This would use service_city.php template
                $issues[] = [
                    'url' => $url,
                    'path' => $path,
                    'type' => 'service_city_page',
                    'service' => $serviceSlug,
                    'city' => $citySlug,
                    'template' => 'pages/services/service_city.php',
                    'status' => 'needs_check',
                    'issue' => 'Uses ld_service_hefty() - check if FAQ schema is properly separated'
                ];
            }
        }
    }
    
    return $issues;
}

function check_schema_builders_file(): array {
    $issues = [];
    
    $schemaFile = __DIR__ . '/../lib/schema_builders.php';
    if (!file_exists($schemaFile)) {
        return [['file' => $schemaFile, 'issue' => 'Schema builders file not found']];
    }
    
    $content = file_get_contents($schemaFile);
    
    // Check if ld_service_hefty still has nested FAQ
    if (strpos($content, 'hasFAQ') !== false) {
        $issues[] = [
            'file' => $schemaFile,
            'issue' => 'ld_service_hefty() still contains nested FAQ schema (hasFAQ)',
            'status' => 'critical'
        ];
    }
    
    // Check if FAQ schema is properly separated
    if (strpos($content, 'function ld_faqpage') === false) {
        $issues[] = [
            'file' => $schemaFile,
            'issue' => 'ld_faqpage() function not found - FAQ schema separation incomplete',
            'status' => 'critical'
        ];
    }
    
    return $issues;
}

function check_service_city_template(): array {
    $issues = [];
    
    $templateFile = __DIR__ . '/../pages/services/service_city.php';
    if (!file_exists($templateFile)) {
        return [['file' => $templateFile, 'issue' => 'Service city template not found']];
    }
    
    $content = file_get_contents($templateFile);
    
    // Check if it's using separate FAQ schema
    if (strpos($content, '$faqLd = [') === false) {
        $issues[] = [
            'file' => $templateFile,
            'issue' => 'FAQ schema not properly separated in template',
            'status' => 'needs_check'
        ];
    }
    
    // Check if it's using ld_service_hefty correctly
    if (strpos($content, 'ld_service_hefty') === false) {
        $issues[] = [
            'file' => $templateFile,
            'issue' => 'Not using ld_service_hefty() function',
            'status' => 'info'
        ];
    }
    
    return $issues;
}

function main(): void {
    echo "🔍 Scanning for nested FAQ schema issues...\n\n";
    
    // Check schema builders file
    echo "📋 Checking schema builders file...\n";
    $schemaIssues = check_schema_builders_file();
    foreach ($schemaIssues as $issue) {
        $status = $issue['status'] ?? 'unknown';
        $icon = $status === 'critical' ? '🔴' : ($status === 'needs_check' ? '🟡' : '🟢');
        echo "  $icon {$issue['file']}: {$issue['issue']}\n";
    }
    
    // Check service city template
    echo "\n📋 Checking service city template...\n";
    $templateIssues = check_service_city_template();
    foreach ($templateIssues as $issue) {
        $status = $issue['status'] ?? 'unknown';
        $icon = $status === 'critical' ? '🔴' : ($status === 'needs_check' ? '🟡' : '🟢');
        echo "  $icon {$issue['file']}: {$issue['issue']}\n";
    }
    
    // Scan all service pages
    echo "\n📋 Scanning all service pages...\n";
    $pageIssues = scan_for_nested_faq_issues();
    
    $serviceCount = count($pageIssues);
    echo "  Found $serviceCount service pages that use ld_service_hefty()\n";
    
    if ($serviceCount > 0) {
        echo "\n📊 Service pages breakdown:\n";
        $services = [];
        $cities = [];
        
        foreach ($pageIssues as $issue) {
            $services[$issue['service']] = ($services[$issue['service']] ?? 0) + 1;
            $cities[$issue['city']] = ($cities[$issue['city']] ?? 0) + 1;
        }
        
        echo "  Services: " . implode(', ', array_keys($services)) . "\n";
        echo "  Cities: " . implode(', ', array_keys($cities)) . "\n";
        
        // Show first few examples
        echo "\n📝 Example pages:\n";
        $examples = array_slice($pageIssues, 0, 5);
        foreach ($examples as $issue) {
            echo "  • {$issue['url']}\n";
        }
        
        if (count($pageIssues) > 5) {
            echo "  ... and " . (count($pageIssues) - 5) . " more\n";
        }
    }
    
    // Summary
    $totalIssues = count($schemaIssues) + count($templateIssues);
    $criticalIssues = count(array_filter(array_merge($schemaIssues, $templateIssues), fn($i) => ($i['status'] ?? '') === 'critical'));
    
    echo "\n📊 Summary:\n";
    echo "  🔴 Critical issues: $criticalIssues\n";
    echo "  🟡 Total issues: $totalIssues\n";
    echo "  📄 Service pages: $serviceCount\n";
    
    if ($criticalIssues === 0) {
        echo "\n✅ No critical nested FAQ schema issues found!\n";
        echo "   The ld_service_hefty() function has been properly fixed.\n";
    } else {
        echo "\n⚠️  Critical issues found that need immediate attention.\n";
    }
    
    // Save detailed report
    $report = [
        'scan_date' => date('Y-m-d H:i:s'),
        'schema_issues' => $schemaIssues,
        'template_issues' => $templateIssues,
        'page_issues' => $pageIssues,
        'summary' => [
            'critical_issues' => $criticalIssues,
            'total_issues' => $totalIssues,
            'service_pages' => $serviceCount
        ]
    ];
    
    $reportFile = __DIR__ . '/nested_faq_schema_scan.json';
    file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT));
    echo "\n💾 Detailed report saved to: $reportFile\n";
}

if (php_sapi_name() === 'cli') {
    main();
}
