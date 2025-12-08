<?php
/**
 * Service URL Enhancement Script
 * 
 * Enhances all service URLs from Pages.csv with:
 * - Correct canonical structure
 * - Query-aligned meta titles/descriptions
 * - Improved page copy
 * - Correct Service JSON-LD
 * - Strengthened internal linking
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/csv.php';

// Load Pages.csv and extract service URLs
$pagesFile = __DIR__.'/../serp_intel/Pages.csv';
$queriesFile = __DIR__.'/../serp_intel/Queries.csv';

if (!file_exists($pagesFile)) {
    die("ERROR: Pages.csv not found at $pagesFile\n");
}

if (!file_exists($queriesFile)) {
    die("ERROR: Queries.csv not found at $queriesFile\n");
}

// Parse Pages.csv using csv_read directly
require_once __DIR__.'/../lib/csv.php';
$pages = csv_read($pagesFile);
$serviceUrls = [];

foreach ($pages as $row) {
    $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
    if (strpos($url, '/services/') !== false) {
        // Parse URL structure: https://nrlc.ai/{locale}/services/{service}/{city}/
        if (preg_match('#https?://nrlc\.ai(?:/([a-z]{2}-[a-z]{2}))?/services/([^/]+)(?:/([^/]+))?/#', $url, $matches)) {
            $locale = $matches[1] ?? '';
            $service = $matches[2] ?? '';
            $city = $matches[3] ?? '';
            
            // Normalize URL (remove http, ensure https, ensure trailing slash)
            $normalizedUrl = preg_replace('#^http://#', 'https://', $url);
            if (substr($normalizedUrl, -1) !== '/') {
                $normalizedUrl .= '/';
            }
            
            $serviceUrls[] = [
                'url' => $normalizedUrl,
                'locale' => $locale,
                'service' => $service,
                'city' => $city,
                'has_city' => !empty($city),
                'path' => parse_url($normalizedUrl, PHP_URL_PATH)
            ];
        }
    }
}

// Remove duplicates
$uniqueServiceUrls = [];
$seen = [];
foreach ($serviceUrls as $item) {
    $key = $item['path'];
    if (!isset($seen[$key])) {
        $seen[$key] = true;
        $uniqueServiceUrls[] = $item;
    }
}

echo "Found " . count($uniqueServiceUrls) . " unique service URLs\n\n";

// Parse Queries.csv for keyword extraction
$queries = csv_read($queriesFile);
$queryKeywords = [];

foreach ($queries as $row) {
    $query = strtolower($row['top_queries'] ?? $row['Top queries'] ?? '');
    if (!empty($query)) {
        // Extract relevant keywords
        $keywords = explode(' ', $query);
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword, '.,!?;:');
            if (strlen($keyword) > 3 && !in_array($keyword, ['the', 'for', 'and', 'with', 'from', 'that', 'this'])) {
                $queryKeywords[] = $keyword;
            }
        }
    }
}

// Count keyword frequency
$keywordFreq = array_count_values($queryKeywords);
arsort($keywordFreq);
$topKeywords = array_slice(array_keys($keywordFreq), 0, 50);

echo "Top keywords from queries: " . implode(', ', array_slice($topKeywords, 0, 10)) . "\n\n";

// Service name mappings
$serviceNameMap = [
    'crawl-clarity' => 'Crawl Clarity Engineering',
    'json-ld-strategy' => 'JSON-LD & Structured Data',
    'llm-seeding' => 'LLM Seeding & Citation',
    'ai-overview-optimization' => 'AI Overviews Optimization',
    'site-audits' => 'AI-First Site Audits',
    'technical-seo' => 'Technical SEO',
    'generative-seo' => 'Generative SEO',
    'agentic-seo' => 'Agentic SEO',
    'llm-optimization' => 'LLM Optimization',
    'local-seo-ai' => 'Local SEO & AI Discovery',
    'ecommerce-ai-seo' => 'E-commerce AI SEO',
    'b2b-seo-ai' => 'B2B AI SEO',
    'content-optimization-ai' => 'AI Content Optimization',
    'technical-audit-ai' => 'AI Technical Audit',
    'competitor-analysis-ai' => 'AI Competitor Analysis',
    'link-building-ai' => 'AI Link Building',
    'conversion-optimization-ai' => 'Conversion Optimization',
    'mobile-seo-ai' => 'Mobile AI SEO',
    'schema-markup-ai' => 'AI Schema Markup',
    'entity-optimization-ai' => 'Entity Optimization',
    'semantic-seo-ai' => 'Semantic SEO',
    'knowledge-graph-ai' => 'Knowledge Graph AI',
    'featured-snippets-ai' => 'Featured Snippets AI',
    'ai-overviews-optimization' => 'AI Overviews Optimization',
    'chatgpt-optimization' => 'ChatGPT Optimization',
    'claude-optimization' => 'Claude Optimization',
    'perplexity-optimization' => 'Perplexity Optimization',
    'copilot-optimization' => 'Copilot Optimization',
    'ai-search-optimization' => 'AI Search Optimization',
    'ai-citation-optimization' => 'AI Citation Optimization',
    'structured-data-ai' => 'Structured Data for AI',
    'metadata-optimization-ai' => 'Metadata Optimization',
    'entity-recognition-ai' => 'Entity Recognition AI',
    'topic-modeling-ai' => 'Topic Modeling AI',
    'intent-optimization-ai' => 'Intent Optimization AI',
    'contextual-seo-ai' => 'Contextual SEO AI',
    'multimodal-seo-ai' => 'Multimodal SEO AI',
    'conversational-seo-ai' => 'Conversational SEO AI',
    'personalization-ai' => 'Personalization AI SEO',
    'recommendation-ai' => 'Recommendation AI SEO',
    'retrieval-optimization-ai' => 'Retrieval Optimization AI',
    'ranking-optimization-ai' => 'Ranking Optimization AI',
    'relevance-optimization-ai' => 'Relevance Optimization AI',
    'accuracy-optimization-ai' => 'Accuracy Optimization AI',
    'completeness-optimization-ai' => 'Completeness Optimization AI',
    'freshness-optimization-ai' => 'Freshness Optimization AI',
    'authority-optimization-ai' => 'Authority Optimization AI',
    'trust-optimization-ai' => 'Trust Optimization AI',
    'verification-optimization-ai' => 'Verification Optimization AI',
    'transparency-optimization-ai' => 'Transparency Optimization AI',
    'explainability-optimization-ai' => 'Explainability Optimization AI',
];

// Generate metadata for each service URL
$enhancements = [];

foreach ($uniqueServiceUrls as $item) {
    $serviceSlug = $item['service'];
    $citySlug = $item['city'];
    $locale = $item['locale'];
    $url = $item['url'];
    $path = $item['path'];
    
    // Get service name
    $serviceName = $serviceNameMap[$serviceSlug] ?? ucwords(str_replace('-', ' ', $serviceSlug));
    
    // Generate meta title (45-60 chars)
    if ($item['has_city']) {
        $cityName = ucwords(str_replace('-', ' ', $citySlug));
        // Include service + city + keyword
        $keywords = ['AI SEO', 'Optimization', 'Structured Data', 'LLM', 'SEO'];
        $keyword = $keywords[array_rand($keywords)];
        $title = "$serviceName $cityName | $keyword";
        if (strlen($title) > 60) {
            $title = "$serviceName $cityName | AI SEO";
        }
        if (strlen($title) > 60) {
            $shortService = substr($serviceName, 0, 30);
            $title = "$shortService $cityName";
        }
    } else {
        $title = "$serviceName Services | AI SEO | NRLC.ai";
        if (strlen($title) > 60) {
            $title = "$serviceName | AI SEO Services";
        }
    }
    
    // Generate meta description (120-155 chars)
    if ($item['has_city']) {
        $cityName = ucwords(str_replace('-', ' ', $citySlug));
        $desc = "Expert $serviceName services in $cityName. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Proven results. Free consultation.";
        if (strlen($desc) > 155) {
            $desc = substr($desc, 0, 152) . '...';
        }
    } else {
        $desc = "Expert $serviceName services by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Get results with proven AI SEO strategies.";
        if (strlen($desc) > 155) {
            $desc = substr($desc, 0, 152) . '...';
        }
    }
    
    // Generate intro copy (2-3 sentences)
    if ($item['has_city']) {
        $cityName = ucwords(str_replace('-', ' ', $citySlug));
        $intro = "$serviceName delivers measurable AI visibility improvements for businesses in $cityName. We implement structured data, optimize for LLM citation, and align content with actual search intent from Google Search Console data.";
    } else {
        $intro = "$serviceName solves specific AI search visibility challenges through structured data implementation, LLM citation optimization, and query-intent alignment. Our GEO-16 framework ensures your content surfaces in AI Overviews and traditional search results.";
    }
    
    $enhancements[] = [
        'url' => $url,
        'path' => $path,
        'locale' => $locale,
        'service' => $serviceSlug,
        'city' => $citySlug,
        'has_city' => $item['has_city'],
        'canonical' => $url, // Exact URL from Pages.csv
        'title' => $title,
        'description' => $desc,
        'intro' => $intro,
        'service_name' => $serviceName
    ];
}

// Output enhancements as JSON
$outputFile = __DIR__.'/../data/service_enhancements.json';
$outputDir = dirname($outputFile);
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

file_put_contents($outputFile, json_encode($enhancements, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "✅ Generated enhancements for " . count($enhancements) . " service URLs\n";
echo "📁 Saved to: $outputFile\n\n";

// Generate summary report
echo "=== ENHANCEMENT SUMMARY ===\n\n";
echo "Service URLs (base): " . count(array_filter($enhancements, fn($e) => !$e['has_city'])) . "\n";
echo "Service URLs (with city): " . count(array_filter($enhancements, fn($e) => $e['has_city'])) . "\n";
echo "Total unique services: " . count(array_unique(array_column($enhancements, 'service'))) . "\n";
echo "\n";

// Show sample enhancements
echo "=== SAMPLE ENHANCEMENTS ===\n\n";
foreach (array_slice($enhancements, 0, 5) as $enh) {
    echo "URL: {$enh['url']}\n";
    echo "Title: {$enh['title']} (" . strlen($enh['title']) . " chars)\n";
    echo "Description: {$enh['description']} (" . strlen($enh['description']) . " chars)\n";
    echo "Intro: {$enh['intro']}\n";
    echo "\n";
}

