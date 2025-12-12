<?php
/**
 * Validate all pages from Pages.csv to ensure they load properly
 * Tests pages by checking file existence and routing logic
 */

require_once __DIR__ . '/../lib/helpers.php';

$pagesFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-12/Pages.csv';
$basePath = __DIR__ . '/..';

// Read pages CSV
$pages = [];
if (($handle = fopen($pagesFile, 'r')) !== false) {
    $header = fgetcsv($handle, 0, ',', '"', '\\'); // Skip header
    while (($data = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if (count($data) >= 5) {
            $url = trim($data[0]);
            $impressions = (int)$data[2];
            $clicks = (int)$data[1];
            $position = (float)$data[4];
            
            $pages[] = [
                'url' => $url,
                'impressions' => $impressions,
                'clicks' => $clicks,
                'position' => $position
            ];
        }
    }
    fclose($handle);
}

// Sort by impressions (highest first)
usort($pages, function($a, $b) {
    return $b['impressions'] - $a['impressions'];
});

echo "Validating " . count($pages) . " pages...\n\n";

$results = [
    'valid' => [],
    'missing_metadata' => [],
    'file_not_found' => [],
    'routing_issue' => [],
    'other' => []
];

foreach ($pages as $page) {
    $url = $page['url'];
    $parsed = parse_url($url);
    $path = $parsed['path'] ?? '/';
    
    $result = validate_page($path, $url, $basePath);
    
    $result['url'] = $url;
    $result['impressions'] = $page['impressions'];
    $result['clicks'] = $page['clicks'];
    $result['position'] = $page['position'];
    
    switch ($result['status']) {
        case 'valid':
            $results['valid'][] = $result;
            break;
        case 'missing_metadata':
            $results['missing_metadata'][] = $result;
            break;
        case 'file_not_found':
            $results['file_not_found'][] = $result;
            break;
        case 'routing_issue':
            $results['routing_issue'][] = $result;
            break;
        default:
            $results['other'][] = $result;
    }
    
    // Progress indicator
    if ((count($results['valid']) + count($results['missing_metadata']) + 
         count($results['file_not_found']) + count($results['routing_issue']) + 
         count($results['other'])) % 50 == 0) {
        echo "Processed " . (count($results['valid']) + count($results['missing_metadata']) + 
             count($results['file_not_found']) + count($results['routing_issue']) + 
             count($results['other'])) . " pages...\n";
    }
}

// Print summary
echo "\n\n=== VALIDATION SUMMARY ===\n";
echo "Total pages: " . count($pages) . "\n";
echo "Valid: " . count($results['valid']) . "\n";
echo "Missing metadata: " . count($results['missing_metadata']) . "\n";
echo "File not found: " . count($results['file_not_found']) . "\n";
echo "Routing issues: " . count($results['routing_issue']) . "\n";
echo "Other issues: " . count($results['other']) . "\n";

// Print top issues by impressions
if (!empty($results['missing_metadata'])) {
    echo "\n=== TOP MISSING METADATA ISSUES (by impressions) ===\n";
    usort($results['missing_metadata'], function($a, $b) {
        return $b['impressions'] - $a['impressions'];
    });
    foreach (array_slice($results['missing_metadata'], 0, 20) as $issue) {
        echo "✗ {$issue['url']} ({$issue['impressions']} impressions) - {$issue['message']}\n";
    }
}

if (!empty($results['file_not_found'])) {
    echo "\n=== TOP FILE NOT FOUND ISSUES (by impressions) ===\n";
    usort($results['file_not_found'], function($a, $b) {
        return $b['impressions'] - $a['impressions'];
    });
    foreach (array_slice($results['file_not_found'], 0, 20) as $issue) {
        echo "✗ {$issue['url']} ({$issue['impressions']} impressions) - {$issue['message']}\n";
    }
}

if (!empty($results['routing_issue'])) {
    echo "\n=== TOP ROUTING ISSUES (by impressions) ===\n";
    usort($results['routing_issue'], function($a, $b) {
        return $b['impressions'] - $a['impressions'];
    });
    foreach (array_slice($results['routing_issue'], 0, 20) as $issue) {
        echo "✗ {$issue['url']} ({$issue['impressions']} impressions) - {$issue['message']}\n";
    }
}

// Save detailed report
$reportFile = __DIR__ . '/../page_validation_report.json';
file_put_contents($reportFile, json_encode($results, JSON_PRETTY_PRINT));
echo "\n\nDetailed report saved to: {$reportFile}\n";

function validate_page($path, $fullUrl, $basePath) {
    // Service pages: /services/{service}/{city}/ or /{locale}/services/{service}/{city}/
    if (preg_match('#^/(?:[a-z]{2}-[a-z]{2}/)?services/([^/]+)/([^/]+)/$#', $path, $matches)) {
        $serviceSlug = $matches[1];
        $citySlug = $matches[2];
        
        // Check if service_city.php exists
        $serviceFile = $basePath . '/pages/services/service_city.php';
        if (!file_exists($serviceFile)) {
            return ['status' => 'file_not_found', 'message' => 'service_city.php not found'];
        }
        
        // Check if service exists in service_enhancements
        $enhancementsFile = $basePath . '/lib/service_enhancements.php';
        if (file_exists($enhancementsFile)) {
            require_once $enhancementsFile;
            if (function_exists('get_service_name_from_slug')) {
                $serviceName = get_service_name_from_slug($serviceSlug);
                if (!$serviceName) {
                    return ['status' => 'routing_issue', 'message' => "Service '{$serviceSlug}' not found in service_enhancements"];
                }
            }
        }
        
        return ['status' => 'valid', 'message' => 'Service city page'];
    }
    
    // Product pages: /products/{product}/ or /{locale}/products/{product}/
    if (preg_match('#^/(?:[a-z]{2}-[a-z]{2}/)?products/([^/]+)/$#', $path, $matches)) {
        $productSlug = $matches[1];
        $productFile = $basePath . '/pages/products/' . $productSlug . '.php';
        if (file_exists($productFile)) {
            return ['status' => 'valid', 'message' => 'Product page exists'];
        }
        return ['status' => 'file_not_found', 'message' => "Product file not found: {$productSlug}.php"];
    }
    
    // Insights pages: /insights/{insight}/ or /{locale}/insights/{insight}/
    if (preg_match('#^/(?:[a-z]{2}-[a-z]{2}/)?insights/([^/]+)/$#', $path, $matches)) {
        $insightSlug = $matches[1];
        $insightFile = $basePath . '/pages/insights/' . $insightSlug . '.php';
        if (file_exists($insightFile)) {
            return ['status' => 'valid', 'message' => 'Insight page exists'];
        }
        // Check if handled by article.php
        $articleFile = $basePath . '/pages/insights/article.php';
        if (file_exists($articleFile)) {
            return ['status' => 'valid', 'message' => 'Insight page handled by article.php'];
        }
        return ['status' => 'file_not_found', 'message' => "Insight page not found: {$insightSlug}.php"];
    }
    
    // Careers pages: /careers/{city}/{role}/ or /{locale}/careers/{city}/{role}/
    if (preg_match('#^/(?:[a-z]{2}-[a-z]{2}/)?careers/([^/]+)/([^/]+)/$#', $path, $matches)) {
        $careerFile = $basePath . '/pages/careers/career_city.php';
        if (file_exists($careerFile)) {
            return ['status' => 'valid', 'message' => 'Career page file exists'];
        }
        return ['status' => 'file_not_found', 'message' => 'Career page file not found'];
    }
    
    // Blog pages: /blog/blog-post-{id}/ or /{locale}/blog/blog-post-{id}/
    if (preg_match('#^/(?:[a-z]{2}-[a-z]{2}/)?blog/blog-post-(\d+)/$#', $path, $matches)) {
        $blogFile = $basePath . '/pages/blog/blog-post.php';
        if (file_exists($blogFile)) {
            return ['status' => 'valid', 'message' => 'Blog post page exists'];
        }
        return ['status' => 'file_not_found', 'message' => 'Blog post page file not found'];
    }
    
    // Service pages without city: /services/{service}/ or /{locale}/services/{service}/
    if (preg_match('#^/(?:[a-z]{2}-[a-z]{2}/)?services/([^/]+)/$#', $path, $matches)) {
        $serviceSlug = $matches[1];
        $serviceFile = $basePath . '/pages/services/service.php';
        if (file_exists($serviceFile)) {
            // Check if it's a semantic service (handled specially)
            if (in_array($serviceSlug, ['data-mapping', 'data-virtualization', 'rest-api', 'semantic-layer', 'enterprise-llm-foundation', 'knowledge-graph', 'ontology-modeling'])) {
                return ['status' => 'valid', 'message' => 'Semantic service page'];
            }
            // Check if it's an AI SEO service
            if (in_array($serviceSlug, ['ai-overview-optimization', 'ai-first-site-audits'])) {
                return ['status' => 'valid', 'message' => 'AI SEO service page'];
            }
            return ['status' => 'valid', 'message' => 'Service page (no city)'];
        }
        return ['status' => 'file_not_found', 'message' => 'Service page file not found'];
    }
    
    // Root pages
    if ($path === '/' || preg_match('#^/([a-z]{2}-[a-z]{2})/$#', $path)) {
        $homeFile = $basePath . '/pages/home/home.php';
        if (file_exists($homeFile)) {
            return ['status' => 'valid', 'message' => 'Homepage'];
        }
        return ['status' => 'file_not_found', 'message' => 'Homepage file not found'];
    }
    
    // Services index
    if ($path === '/services/' || preg_match('#^/(?:[a-z]{2}-[a-z]{2})/services/$#', $path)) {
        $servicesFile = $basePath . '/pages/services/index.php';
        if (file_exists($servicesFile)) {
            return ['status' => 'valid', 'message' => 'Services index'];
        }
    }
    
    // Careers index
    if ($path === '/careers/' || preg_match('#^/(?:[a-z]{2}-[a-z]{2})/careers/$#', $path)) {
        $careersFile = $basePath . '/pages/careers/index.php';
        if (file_exists($careersFile)) {
            return ['status' => 'valid', 'message' => 'Careers index'];
        }
    }
    
    // Products index
    if ($path === '/products/' || preg_match('#^/(?:[a-z]{2}-[a-z]{2})/products/$#', $path)) {
        $productsFile = $basePath . '/pages/products/index.php';
        if (file_exists($productsFile)) {
            return ['status' => 'valid', 'message' => 'Products index'];
        }
    }
    
    // Catalog
    if ($path === '/catalog/' || preg_match('#^/(?:[a-z]{2}-[a-z]{2})/catalog/$#', $path)) {
        $catalogFile = $basePath . '/pages/catalog/index.php';
        if (file_exists($catalogFile)) {
            return ['status' => 'valid', 'message' => 'Catalog index'];
        }
    }
    
    // Promptware
    if (preg_match('#^/promptware/([^/]+)/$#', $path, $matches)) {
        return ['status' => 'valid', 'message' => 'Promptware page (handled by router)'];
    }
    
    return ['status' => 'routing_issue', 'message' => 'Unknown page type or routing pattern'];
}

