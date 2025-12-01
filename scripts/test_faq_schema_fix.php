<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/deterministic.php';
require_once __DIR__.'/../lib/content_tokens.php';

/**
 * Test FAQ schema generation for services with and without FAQ data
 */

function test_service_faq_schema(string $serviceSlug, string $citySlug): array {
    $pathKey = "/services/$serviceSlug/$citySlug/";
    
    // Simulate the FAQ data retrieval
    $fqRows = csv_rows_local('faq_pools.csv');
    $fqForService = array_values(array_filter($fqRows, fn($r)=>$r['service']===$serviceSlug));
    
    det_seed("ld|$pathKey");
    $fqPick = det_pick($fqForService, 6);
    $faqs = array_map(fn($f)=>['q'=>$f['question'],'a'=>$f['answer']], $fqPick);
    
    // Test FAQPage schema generation
    $jsonldSchemas = ['Service', 'LocalBusiness'];
    
    if (!empty($faqs)) {
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
        $jsonldSchemas[] = 'FAQPage';
        
        return [
            'service' => $serviceSlug,
            'city' => $citySlug,
            'faq_count' => count($faqs),
            'schemas' => $jsonldSchemas,
            'faq_schema' => $faqLd,
            'status' => 'has_faqs'
        ];
    } else {
        return [
            'service' => $serviceSlug,
            'city' => $citySlug,
            'faq_count' => 0,
            'schemas' => $jsonldSchemas,
            'faq_schema' => null,
            'status' => 'no_faqs'
        ];
    }
}

function main(): void {
    echo "🧪 Testing FAQ schema generation...\n\n";
    
    // Test services mentioned in GSC errors
    $testServices = [
        ['copilot-optimization', 'austin'],
        ['analytics', 'goyang']
    ];
    
    foreach ($testServices as [$service, $city]) {
        echo "📋 Testing: $service in $city\n";
        
        $result = test_service_faq_schema($service, $city);
        
        echo "   FAQ count: {$result['faq_count']}\n";
        echo "   Schemas: " . implode(', ', $result['schemas']) . "\n";
        echo "   Status: {$result['status']}\n";
        
        if ($result['faq_schema']) {
            echo "   ✅ FAQPage schema generated with {$result['faq_count']} questions\n";
            echo "   📝 Sample FAQ: " . substr($result['faq_schema']['mainEntity'][0]['name'], 0, 50) . "...\n";
        } else {
            echo "   ⚠️  No FAQPage schema (empty FAQs)\n";
        }
        
        echo "\n";
    }
    
    // Test a few more services to verify the fix
    echo "🔍 Testing additional services...\n";
    
    $additionalServices = [
        ['crawl-clarity', 'new-york'],
        ['llm-seeding', 'london'],
        ['technical-seo', 'toronto']
    ];
    
    foreach ($additionalServices as [$service, $city]) {
        $result = test_service_faq_schema($service, $city);
        $icon = $result['status'] === 'has_faqs' ? '✅' : '⚠️';
        echo "   $icon $service in $city: {$result['faq_count']} FAQs\n";
    }
    
    echo "\n🎉 FAQ schema testing complete!\n";
    echo "   Services with FAQ data will generate proper FAQPage schema.\n";
    echo "   Services without FAQ data will skip FAQPage schema to prevent empty mainEntity.\n";
}

if (php_sapi_name() === 'cli') {
    main();
}














