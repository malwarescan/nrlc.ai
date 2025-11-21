<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/deterministic.php';
require_once __DIR__.'/../lib/content_tokens.php';

/**
 * Fix missing FAQ data for services that don't have FAQ entries
 * This prevents empty mainEntity arrays in FAQPage schema
 */

function get_services_with_faq_data(): array {
    $faqRows = csv_rows_local('faq_pools.csv');
    $services = [];
    foreach ($faqRows as $row) {
        $service = $row['service'] ?? '';
        if ($service && $service !== 'service') { // Skip header
            $services[$service] = true;
        }
    }
    return array_keys($services);
}

function get_all_services(): array {
    $urls = csv_rows_local('Table.csv');
    $services = [];
    foreach ($urls as $row) {
        $url = $row['url'] ?? '';
        if (preg_match('/\/services\/([^\/]+)\//', $url, $matches)) {
            $services[$matches[1]] = true;
        }
    }
    return array_keys($services);
}

function generate_faq_data_for_service(string $service): array {
    $serviceName = ucwords(str_replace('-', ' ', $service));
    
    return [
        [
            'service' => $service,
            'question' => "What is $serviceName?",
            'answer' => "$serviceName is a specialized AI-first SEO service that helps businesses improve their search engine visibility and performance through advanced optimization techniques."
        ],
        [
            'service' => $service,
            'question' => "How does $serviceName work?",
            'answer' => "Our $serviceName service uses cutting-edge AI technology to analyze your website, identify optimization opportunities, and implement data-driven improvements that enhance your search rankings."
        ],
        [
            'service' => $service,
            'question' => "What are the benefits of $serviceName?",
            'answer' => "$serviceName delivers measurable improvements in search rankings, organic traffic, and conversion rates. We provide detailed reporting and ongoing optimization to ensure sustained results."
        ],
        [
            'service' => $service,
            'question' => "How long does $serviceName take to show results?",
            'answer' => "Initial improvements are typically visible within 2-4 weeks, with significant results appearing within 3-6 months. Timeline depends on your current SEO foundation and competition level."
        ],
        [
            'service' => $service,
            'question' => "What's included in $serviceName?",
            'answer' => "Our $serviceName service includes comprehensive analysis, strategy development, implementation, monitoring, and ongoing optimization. We provide regular reports and consultation throughout the process."
        ],
        [
            'service' => $service,
            'question' => "How much does $serviceName cost?",
            'answer' => "Pricing for $serviceName varies based on your website size, industry, and specific requirements. Contact us for a personalized quote and consultation to discuss your needs."
        ]
    ];
}

function main(): void {
    echo "🔍 Analyzing missing FAQ data for services...\n\n";
    
    $servicesWithFaq = get_services_with_faq_data();
    $allServices = get_all_services();
    
    echo "📊 FAQ Data Analysis:\n";
    echo "   Services with FAQ data: " . count($servicesWithFaq) . "\n";
    echo "   Total services: " . count($allServices) . "\n";
    
    $missingFaq = array_diff($allServices, $servicesWithFaq);
    $missingCount = count($missingFaq);
    
    echo "   Services missing FAQ data: $missingCount\n\n";
    
    if ($missingCount === 0) {
        echo "✅ All services have FAQ data!\n";
        return;
    }
    
    echo "🔴 Services missing FAQ data:\n";
    foreach ($missingFaq as $service) {
        echo "   • $service\n";
    }
    
    echo "\n📝 Generating FAQ data for missing services...\n";
    
    $newFaqData = [];
    foreach ($missingFaq as $service) {
        $faqData = generate_faq_data_for_service($service);
        $newFaqData = array_merge($newFaqData, $faqData);
        echo "   ✅ Generated 6 FAQs for: $service\n";
    }
    
    if (!empty($newFaqData)) {
        // Read existing FAQ data
        $existingFaq = csv_rows_local('faq_pools.csv');
        
        // Combine with new data
        $allFaqData = array_merge($existingFaq, $newFaqData);
        
        // Write back to CSV
        $csvFile = __DIR__ . '/../data/faq_pools.csv';
        $fp = fopen($csvFile, 'w');
        if ($fp) {
            // Write header
            fputcsv($fp, ['service', 'question', 'answer']);
            
            // Write data
            foreach ($allFaqData as $row) {
                fputcsv($fp, [
                    $row['service'] ?? '',
                    $row['question'] ?? '',
                    $row['answer'] ?? ''
                ]);
            }
            
            fclose($fp);
            
            echo "\n✅ Added " . count($newFaqData) . " new FAQ entries to faq_pools.csv\n";
            echo "   Total FAQ entries: " . count($allFaqData) . "\n";
        } else {
            echo "\n❌ Failed to write to faq_pools.csv\n";
        }
    }
    
    echo "\n🎉 FAQ data generation complete!\n";
    echo "   All services now have FAQ data to prevent empty mainEntity arrays.\n";
}

if (php_sapi_name() === 'cli') {
    main();
}













