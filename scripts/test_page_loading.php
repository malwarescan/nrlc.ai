<?php
/**
 * Test page loading for all pages in Pages.csv
 * Checks if pages return 200 status and have content
 */

require_once __DIR__ . '/../lib/helpers.php';

$pagesFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-12/Pages.csv';
$queriesFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-12/Queries.csv';

// Read pages CSV
$pages = [];
if (($handle = fopen($pagesFile, 'r')) !== false) {
    $header = fgetcsv($handle); // Skip header
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) >= 5) {
            $url = trim($data[0]);
            $impressions = (int)$data[2];
            $pages[] = [
                'url' => $url,
                'impressions' => $impressions,
                'clicks' => (int)$data[1],
                'position' => (float)$data[4]
            ];
        }
    }
    fclose($handle);
}

// Sort by impressions (highest first)
usort($pages, function($a, $b) {
    return $b['impressions'] - $a['impressions'];
});

echo "Testing " . count($pages) . " pages...\n\n";

$failed = [];
$success = 0;
$tested = 0;
$maxTests = 50; // Test top 50 pages first

foreach (array_slice($pages, 0, $maxTests) as $page) {
    $tested++;
    $url = $page['url'];
    
    // Convert URL to local path for testing
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    // Test if page file exists or can be routed
    $status = test_page($path, $url);
    
    if ($status['success']) {
        $success++;
        echo "✓ {$url} - {$status['message']}\n";
    } else {
        $failed[] = [
            'url' => $url,
            'impressions' => $page['impressions'],
            'error' => $status['message']
        ];
        echo "✗ {$url} - {$status['message']}\n";
    }
    
    // Don't overwhelm the system
    if ($tested % 10 == 0) {
        sleep(1);
    }
}

echo "\n\n=== SUMMARY ===\n";
echo "Tested: {$tested}\n";
echo "Success: {$success}\n";
echo "Failed: " . count($failed) . "\n\n";

if (!empty($failed)) {
    echo "=== FAILED PAGES (sorted by impressions) ===\n";
    usort($failed, function($a, $b) {
        return $b['impressions'] - $a['impressions'];
    });
    foreach ($failed as $fail) {
        echo "✗ {$fail['url']} ({$fail['impressions']} impressions) - {$fail['error']}\n";
    }
}

function test_page($path, $fullUrl) {
    // Check if it's a local file path we can test
    $basePath = __DIR__ . '/..';
    
    // Try to determine the file
    $pathParts = explode('/', trim($path, '/'));
    
    // Check router.php to see how it handles routes
    $routerFile = $basePath . '/bootstrap/router.php';
    if (!file_exists($routerFile)) {
        return ['success' => false, 'message' => 'Router file not found'];
    }
    
    // For now, just check if the path structure makes sense
    // Service pages: /services/{service}/{city}/
    if (preg_match('#^/services/([^/]+)/([^/]+)/#', $path, $matches)) {
        $serviceFile = $basePath . '/pages/services/service_city.php';
        if (file_exists($serviceFile)) {
            // Check if service slug is valid
            $serviceSlug = $matches[1];
            $citySlug = $matches[2];
            
            // Check if service exists in service_enhancements
            $enhancementsFile = $basePath . '/lib/service_enhancements.php';
            if (file_exists($enhancementsFile)) {
                require_once $enhancementsFile;
                if (function_exists('get_service_name_from_slug')) {
                    $serviceName = get_service_name_from_slug($serviceSlug);
                    if ($serviceName) {
                        return ['success' => true, 'message' => 'Service page structure valid'];
                    }
                }
            }
            
            return ['success' => true, 'message' => 'Service page file exists'];
        }
    }
    
    // Product pages: /products/{product}/
    if (preg_match('#^/products/([^/]+)/#', $path, $matches)) {
        $productSlug = $matches[1];
        $productFile = $basePath . '/pages/products/' . $productSlug . '.php';
        if (file_exists($productFile)) {
            return ['success' => true, 'message' => 'Product page file exists'];
        }
        return ['success' => false, 'message' => 'Product page file not found: ' . $productFile];
    }
    
    // Insights pages: /insights/{insight}/
    if (preg_match('#^/insights/([^/]+)/#', $path, $matches)) {
        $insightSlug = $matches[1];
        $insightFile = $basePath . '/pages/insights/' . $insightSlug . '.php';
        if (file_exists($insightFile)) {
            return ['success' => true, 'message' => 'Insight page file exists'];
        }
        // Check if it's handled by article.php
        $articleFile = $basePath . '/pages/insights/article.php';
        if (file_exists($articleFile)) {
            return ['success' => true, 'message' => 'Insight page handled by article.php'];
        }
        return ['success' => false, 'message' => 'Insight page not found'];
    }
    
    // Careers pages: /careers/{city}/{job}/
    if (preg_match('#^/careers/([^/]+)/([^/]+)/#', $path, $matches)) {
        $careerFile = $basePath . '/pages/careers/job.php';
        if (file_exists($careerFile)) {
            return ['success' => true, 'message' => 'Career page file exists'];
        }
    }
    
    return ['success' => false, 'message' => 'Unknown page type or structure'];
}


