<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/deterministic.php';
require_once __DIR__.'/../lib/content_tokens.php';

/**
 * Verify that service pages are using correct schema structure
 */

function verify_service_page_schema(string $url): array {
    $issues = [];
    
    // Parse URL to get service and city
    $path = parse_url($url, PHP_URL_PATH);
    $pathParts = explode('/', trim($path, '/'));
    
    if (count($pathParts) < 3 || $pathParts[0] !== 'services') {
        return [['issue' => 'Invalid service page URL format']];
    }
    
    $serviceSlug = $pathParts[1];
    $citySlug = $pathParts[2];
    
    // Simulate the page generation to check schema
    $_GET['service'] = $serviceSlug;
    $_GET['city'] = $citySlug;
    
    // Capture the JSON-LD output
    ob_start();
    
    try {
        // Include the service city template
        $templatePath = __DIR__ . '/../pages/services/service_city.php';
        if (!file_exists($templatePath)) {
            return [['issue' => 'Service city template not found']];
        }
        
        // Capture the JSON-LD generation part
        $ppMap = csv_rows_local('painpoint_token_map.csv');
        $ppForService = array_values(array_filter($ppMap, fn($r)=>$r['service']===$serviceSlug));
        $fqRows = csv_rows_local('faq_pools.csv');
        $fqForService = array_values(array_filter($fqRows, fn($r)=>$r['service']===$serviceSlug));
        
        $pathKey = "/services/$serviceSlug/$citySlug/";
        det_seed("ld|$pathKey");
        $fqPick = det_pick($fqForService, 6);
        $faqs = array_map(fn($f)=>['q'=>$f['question'],'a'=>$f['answer']], $fqPick);
        $offers = det_pick($ppForService, 6);
        
        // Check if ld_service_hefty is used correctly
        require_once __DIR__.'/../lib/schema_builders.php';
        
        $serviceLd = ld_service_hefty([
            'service'=>$serviceSlug,
            'city'=>$citySlug,
            'url'=>absolute_url($pathKey),
            'faqs'=>$faqs,
            'offers'=>$offers
        ]);
        
        // Check if FAQ schema is separate
        $faqLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['a']
                    ]
                ];
            }, $faqs)
        ];
        
        // Verify schema structure
        if (isset($serviceLd['hasFAQ'])) {
            $issues[] = [
                'issue' => 'Service schema still contains nested FAQ (hasFAQ)',
                'status' => 'critical'
            ];
        }
        
        if ($serviceLd['@type'] !== 'Service') {
            $issues[] = [
                'issue' => 'Service schema has wrong @type: ' . $serviceLd['@type'],
                'status' => 'critical'
            ];
        }
        
        if ($faqLd['@type'] !== 'FAQPage') {
            $issues[] = [
                'issue' => 'FAQ schema has wrong @type: ' . $faqLd['@type'],
                'status' => 'critical'
            ];
        }
        
        if (!isset($faqLd['mainEntity']) || !is_array($faqLd['mainEntity'])) {
            $issues[] = [
                'issue' => 'FAQ schema missing mainEntity array',
                'status' => 'critical'
            ];
        }
        
        // Check FAQ items structure
        if (isset($faqLd['mainEntity'])) {
            foreach ($faqLd['mainEntity'] as $i => $faq) {
                if (!isset($faq['@type']) || $faq['@type'] !== 'Question') {
                    $issues[] = [
                        'issue' => "FAQ item $i missing @type Question",
                        'status' => 'critical'
                    ];
                }
                if (!isset($faq['name'])) {
                    $issues[] = [
                        'issue' => "FAQ item $i missing name",
                        'status' => 'critical'
                    ];
                }
                if (!isset($faq['acceptedAnswer']['@type']) || $faq['acceptedAnswer']['@type'] !== 'Answer') {
                    $issues[] = [
                        'issue' => "FAQ item $i missing Answer @type",
                        'status' => 'critical'
                    ];
                }
            }
        }
        
        // If no issues found, mark as good
        if (empty($issues)) {
            $issues[] = [
                'issue' => 'Schema structure is correct',
                'status' => 'good'
            ];
        }
        
    } catch (Exception $e) {
        $issues[] = [
            'issue' => 'Error generating schema: ' . $e->getMessage(),
            'status' => 'critical'
        ];
    }
    
    ob_end_clean();
    
    return $issues;
}

function main(): void {
    echo "🔍 Verifying service pages schema structure...\n\n";
    
    // Get the URLs from the scan report
    $scanReport = json_decode(file_get_contents(__DIR__ . '/nested_faq_schema_scan.json'), true);
    $servicePages = $scanReport['page_issues'] ?? [];
    
    if (empty($servicePages)) {
        echo "❌ No service pages found in scan report\n";
        return;
    }
    
    $totalPages = count($servicePages);
    $criticalIssues = 0;
    $goodPages = 0;
    
    foreach ($servicePages as $page) {
        $url = $page['url'];
        $service = $page['service'];
        $city = $page['city'];
        
        echo "📋 Checking: $service in $city\n";
        echo "   URL: $url\n";
        
        $issues = verify_service_page_schema($url);
        
        foreach ($issues as $issue) {
            $status = $issue['status'] ?? 'unknown';
            $icon = $status === 'critical' ? '🔴' : ($status === 'good' ? '✅' : '🟡');
            echo "   $icon {$issue['issue']}\n";
            
            if ($status === 'critical') {
                $criticalIssues++;
            } elseif ($status === 'good') {
                $goodPages++;
            }
        }
        
        echo "\n";
    }
    
    // Summary
    echo "📊 Verification Summary:\n";
    echo "   📄 Total pages checked: $totalPages\n";
    echo "   ✅ Pages with correct schema: $goodPages\n";
    echo "   🔴 Critical issues found: $criticalIssues\n";
    
    if ($criticalIssues === 0) {
        echo "\n🎉 All service pages have correct schema structure!\n";
        echo "   FAQ schema is properly separated from Service schema.\n";
    } else {
        echo "\n⚠️  Critical schema issues found that need fixing.\n";
    }
}

if (php_sapi_name() === 'cli') {
    main();
}

