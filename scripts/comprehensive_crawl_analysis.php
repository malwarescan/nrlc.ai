<?php
/**
 * Comprehensive Crawl Clarity & Content Depth Analysis
 * Scans entire website for crawl issues, content depth, and optimization opportunities
 */

require_once __DIR__ . '/../bootstrap/env.php';
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/deterministic.php';

class CrawlAnalysis {
    private $baseUrl = 'http://localhost:8000';
    private $results = [];
    private $issues = [];
    private $recommendations = [];
    
    public function __construct() {
        echo "🔍 Starting Comprehensive Crawl Analysis...\n\n";
    }
    
    public function analyzeWebsite() {
        // 1. Generate URL list
        $urls = $this->generateUrlList();
        echo "📋 Found " . count($urls) . " URLs to analyze\n\n";
        
        // 2. Analyze each URL
        foreach ($urls as $url) {
            $this->analyzeUrl($url);
        }
        
        // 3. Generate comprehensive report
        $this->generateReport();
        
        return $this->results;
    }
    
    private function generateUrlList() {
        $urls = [];
        
        // Core pages
        $urls[] = '/';
        $urls[] = '/services/';
        $urls[] = '/insights/';
        $urls[] = '/careers/';
        $urls[] = '/api/book/';
        
        // Service pages
        $services = ['site-audits', 'crawl-clarity', 'json-ld-strategy', 'llm-seeding', 'international-seo'];
        foreach ($services as $service) {
            $urls[] = "/services/{$service}/";
        }
        
        // Insights pages
        $insights = [
            'geo16-framework', 'llm-ontology-generation', 'tool-reviews', 
            'industry-insights', 'open-seo-tools', 'ontology-based-search',
            'yago-entity-mapping', 'ocrplus-data-ingestion', 'semantic-drift-tracking'
        ];
        foreach ($insights as $insight) {
            $urls[] = "/insights/{$insight}/";
        }
        
        // Service + City combinations (sample)
        $cities = ['new-york', 'london', 'san-francisco', 'toronto'];
        foreach ($services as $service) {
            foreach ($cities as $city) {
                $urls[] = "/services/{$service}/{$city}/";
            }
        }
        
        // Career + City combinations (sample)
        $roles = ['seo-specialist', 'technical-seo-engineer', 'content-strategist', 'data-analyst'];
        foreach ($roles as $role) {
            foreach ($cities as $city) {
                $urls[] = "/careers/{$role}/{$city}/";
            }
        }
        
        return array_unique($urls);
    }
    
    private function analyzeUrl($url) {
        $fullUrl = $this->baseUrl . $url;
        echo "🔍 Analyzing: {$url}\n";
        
        $analysis = [
            'url' => $url,
            'status' => 'pending',
            'content_length' => 0,
            'word_count' => 0,
            'meta_title' => '',
            'meta_description' => '',
            'h1_count' => 0,
            'h2_count' => 0,
            'h3_count' => 0,
            'image_count' => 0,
            'link_count' => 0,
            'schema_count' => 0,
            'canonical_url' => '',
            'issues' => [],
            'score' => 0
        ];
        
        // Fetch page content
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'NRLC.ai Crawl Analyzer'
            ]
        ]);
        
        $content = @file_get_contents($fullUrl, false, $context);
        
        if ($content === false) {
            $analysis['status'] = 'error';
            $analysis['issues'][] = 'Failed to fetch page';
            $this->results[$url] = $analysis;
            return;
        }
        
        $analysis['status'] = 'success';
        $analysis['content_length'] = strlen($content);
        
        // Parse HTML
        $dom = new DOMDocument();
        @$dom->loadHTML($content);
        $xpath = new DOMXPath($dom);
        
        // Content analysis
        $this->analyzeContent($xpath, $analysis);
        $this->analyzeMeta($xpath, $analysis);
        $this->analyzeStructure($xpath, $analysis);
        $this->analyzeSchema($xpath, $analysis);
        $this->analyzeCrawlClarity($url, $analysis);
        
        // Calculate score
        $analysis['score'] = $this->calculateScore($analysis);
        
        $this->results[$url] = $analysis;
    }
    
    private function analyzeContent($xpath, &$analysis) {
        // Get text content
        $textContent = '';
        $textNodes = $xpath->query('//text()[not(ancestor::script) and not(ancestor::style)]');
        foreach ($textNodes as $node) {
            $textContent .= $node->textContent . ' ';
        }
        
        // Clean and count words
        $cleanText = preg_replace('/\s+/', ' ', trim($textContent));
        $words = str_word_count($cleanText);
        $analysis['word_count'] = $words;
        
        // Check content depth
        if ($words < 300) {
            $analysis['issues'][] = 'Very low content depth (' . $words . ' words)';
        } elseif ($words < 600) {
            $analysis['issues'][] = 'Low content depth (' . $words . ' words)';
        } elseif ($words < 900) {
            $analysis['issues'][] = 'Moderate content depth (' . $words . ' words)';
        }
    }
    
    private function analyzeMeta($xpath, &$analysis) {
        // Meta title
        $titleNodes = $xpath->query('//title');
        if ($titleNodes->length > 0) {
            $analysis['meta_title'] = trim($titleNodes->item(0)->textContent);
            if (strlen($analysis['meta_title']) < 30) {
                $analysis['issues'][] = 'Title too short (' . strlen($analysis['meta_title']) . ' chars)';
            } elseif (strlen($analysis['meta_title']) > 60) {
                $analysis['issues'][] = 'Title too long (' . strlen($analysis['meta_title']) . ' chars)';
            }
        } else {
            $analysis['issues'][] = 'Missing title tag';
        }
        
        // Meta description
        $descNodes = $xpath->query('//meta[@name="description"]/@content');
        if ($descNodes->length > 0) {
            $analysis['meta_description'] = trim($descNodes->item(0)->textContent);
            if (strlen($analysis['meta_description']) < 120) {
                $analysis['issues'][] = 'Meta description too short (' . strlen($analysis['meta_description']) . ' chars)';
            } elseif (strlen($analysis['meta_description']) > 160) {
                $analysis['issues'][] = 'Meta description too long (' . strlen($analysis['meta_description']) . ' chars)';
            }
        } else {
            $analysis['issues'][] = 'Missing meta description';
        }
        
        // Canonical URL
        $canonicalNodes = $xpath->query('//link[@rel="canonical"]/@href');
        if ($canonicalNodes->length > 0) {
            $analysis['canonical_url'] = trim($canonicalNodes->item(0)->textContent);
        } else {
            $analysis['issues'][] = 'Missing canonical URL';
        }
    }
    
    private function analyzeStructure($xpath, &$analysis) {
        // Heading structure
        $analysis['h1_count'] = $xpath->query('//h1')->length;
        $analysis['h2_count'] = $xpath->query('//h2')->length;
        $analysis['h3_count'] = $xpath->query('//h3')->length;
        
        if ($analysis['h1_count'] === 0) {
            $analysis['issues'][] = 'Missing H1 tag';
        } elseif ($analysis['h1_count'] > 1) {
            $analysis['issues'][] = 'Multiple H1 tags (' . $analysis['h1_count'] . ')';
        }
        
        if ($analysis['h2_count'] === 0 && $analysis['word_count'] > 500) {
            $analysis['issues'][] = 'No H2 tags for content structure';
        }
        
        // Media and links
        $analysis['image_count'] = $xpath->query('//img')->length;
        $analysis['link_count'] = $xpath->query('//a[@href]')->length;
        
        // Check for missing alt tags
        $imagesWithoutAlt = $xpath->query('//img[not(@alt) or @alt=""]');
        if ($imagesWithoutAlt->length > 0) {
            $analysis['issues'][] = $imagesWithoutAlt->length . ' images missing alt text';
        }
    }
    
    private function analyzeSchema($xpath, &$analysis) {
        // Count JSON-LD scripts
        $schemaNodes = $xpath->query('//script[@type="application/ld+json"]');
        $analysis['schema_count'] = $schemaNodes->length;
        
        if ($analysis['schema_count'] === 0) {
            $analysis['issues'][] = 'No structured data (JSON-LD)';
        }
        
        // Validate schema content
        $validSchemas = 0;
        foreach ($schemaNodes as $node) {
            $json = json_decode($node->textContent, true);
            if ($json !== null && isset($json['@type'])) {
                $validSchemas++;
            }
        }
        
        if ($validSchemas < $analysis['schema_count']) {
            $analysis['issues'][] = 'Invalid JSON-LD schemas found';
        }
    }
    
    private function analyzeCrawlClarity($url, &$analysis) {
        // Check for problematic URL patterns
        if (strpos($url, '?') !== false) {
            $analysis['issues'][] = 'URL contains query parameters';
        }
        
        if (strpos($url, '#') !== false) {
            $analysis['issues'][] = 'URL contains fragment identifier';
        }
        
        // Check for trailing slashes consistency
        if (strlen($url) > 1 && substr($url, -1) !== '/' && strpos($url, '.') === false) {
            $analysis['issues'][] = 'Missing trailing slash';
        }
        
        // Check for duplicate content indicators
        if (strpos($url, '/new-york/') !== false || strpos($url, '/london/') !== false) {
            // This is a location-specific page - check for proper localization
            if (strpos($url, '/services/') !== false || strpos($url, '/careers/') !== false) {
                // Should have proper hreflang and location-specific content
                if ($analysis['word_count'] < 800) {
                    $analysis['issues'][] = 'Location-specific page needs more localized content';
                }
            }
        }
    }
    
    private function calculateScore($analysis) {
        $score = 100;
        
        // Deduct points for issues
        foreach ($analysis['issues'] as $issue) {
            if (strpos($issue, 'Failed to fetch') !== false) {
                $score -= 50;
            } elseif (strpos($issue, 'Missing') !== false) {
                $score -= 10;
            } elseif (strpos($issue, 'too short') !== false || strpos($issue, 'too long') !== false) {
                $score -= 5;
            } elseif (strpos($issue, 'content depth') !== false) {
                $score -= 15;
            } elseif (strpos($issue, 'Multiple H1') !== false) {
                $score -= 8;
            } elseif (strpos($issue, 'No structured data') !== false) {
                $score -= 20;
            } elseif (strpos($issue, 'images missing alt') !== false) {
                $score -= 3;
            } else {
                $score -= 5;
            }
        }
        
        // Bonus points for good practices
        if ($analysis['word_count'] >= 900) {
            $score += 5;
        }
        if ($analysis['schema_count'] >= 3) {
            $score += 5;
        }
        if ($analysis['h2_count'] >= 3) {
            $score += 3;
        }
        
        return max(0, min(100, $score));
    }
    
    private function generateReport() {
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "📊 COMPREHENSIVE CRAWL CLARITY & CONTENT DEPTH REPORT\n";
        echo str_repeat("=", 80) . "\n\n";
        
        // Overall statistics
        $totalUrls = count($this->results);
        $successfulUrls = array_filter($this->results, fn($r) => $r['status'] === 'success');
        $errorUrls = array_filter($this->results, fn($r) => $r['status'] === 'error');
        
        echo "📈 OVERALL STATISTICS:\n";
        echo "   Total URLs analyzed: {$totalUrls}\n";
        echo "   Successful: " . count($successfulUrls) . "\n";
        echo "   Errors: " . count($errorUrls) . "\n\n";
        
        // Score distribution
        $scores = array_column($successfulUrls, 'score');
        $avgScore = count($scores) > 0 ? round(array_sum($scores) / count($scores), 1) : 0;
        $excellent = count(array_filter($scores, fn($s) => $s >= 90));
        $good = count(array_filter($scores, fn($s) => $s >= 80 && $s < 90));
        $fair = count(array_filter($scores, fn($s) => $s >= 70 && $s < 80));
        $poor = count(array_filter($scores, fn($s) => $s < 70));
        
        echo "🎯 SCORE DISTRIBUTION:\n";
        echo "   Average Score: {$avgScore}/100\n";
        echo "   Excellent (90-100): {$excellent} pages\n";
        echo "   Good (80-89): {$good} pages\n";
        echo "   Fair (70-79): {$fair} pages\n";
        echo "   Poor (<70): {$poor} pages\n\n";
        
        // Content depth analysis
        $wordCounts = array_column($successfulUrls, 'word_count');
        $avgWords = count($wordCounts) > 0 ? round(array_sum($wordCounts) / count($wordCounts)) : 0;
        $deepContent = count(array_filter($wordCounts, fn($w) => $w >= 900));
        $moderateContent = count(array_filter($wordCounts, fn($w) => $w >= 600 && $w < 900));
        $shallowContent = count(array_filter($wordCounts, fn($w) => $w < 600));
        
        echo "📝 CONTENT DEPTH ANALYSIS:\n";
        echo "   Average word count: {$avgWords}\n";
        echo "   Deep content (900+ words): {$deepContent} pages\n";
        echo "   Moderate content (600-899 words): {$moderateContent} pages\n";
        echo "   Shallow content (<600 words): {$shallowContent} pages\n\n";
        
        // Common issues
        $allIssues = [];
        foreach ($successfulUrls as $result) {
            $allIssues = array_merge($allIssues, $result['issues']);
        }
        
        $issueCounts = array_count_values($allIssues);
        arsort($issueCounts);
        
        echo "⚠️  TOP ISSUES:\n";
        $topIssues = array_slice($issueCounts, 0, 10, true);
        foreach ($topIssues as $issue => $count) {
            echo "   {$count}x: {$issue}\n";
        }
        echo "\n";
        
        // Page type analysis
        $this->analyzePageTypes();
        
        // Recommendations
        $this->generateRecommendations();
        
        // Detailed page results
        echo "📋 DETAILED PAGE RESULTS:\n";
        echo str_repeat("-", 80) . "\n";
        
        // Sort by score (worst first)
        uasort($this->results, fn($a, $b) => $a['score'] <=> $b['score']);
        
        foreach ($this->results as $url => $result) {
            if ($result['status'] === 'error') {
                echo "❌ {$url} - ERROR\n";
                continue;
            }
            
            $grade = $this->getGrade($result['score']);
            echo "{$grade} {$url}\n";
            echo "   Score: {$result['score']}/100 | Words: {$result['word_count']} | Schema: {$result['schema_count']}\n";
            
            if (!empty($result['issues'])) {
                echo "   Issues: " . implode(', ', array_slice($result['issues'], 0, 3)) . "\n";
            }
            echo "\n";
        }
    }
    
    private function analyzePageTypes() {
        echo "📊 PAGE TYPE ANALYSIS:\n";
        
        $pageTypes = [
            'Homepage' => ['/'],
            'Service Index' => ['/services/'],
            'Service Pages' => array_filter(array_keys($this->results), fn($url) => strpos($url, '/services/') !== false && substr_count($url, '/') === 3),
            'Service+City' => array_filter(array_keys($this->results), fn($url) => strpos($url, '/services/') !== false && substr_count($url, '/') === 4),
            'Insights' => array_filter(array_keys($this->results), fn($url) => strpos($url, '/insights/') !== false),
            'Careers' => array_filter(array_keys($this->results), fn($url) => strpos($url, '/careers/') !== false),
        ];
        
        foreach ($pageTypes as $type => $urls) {
            if (empty($urls)) continue;
            
            $scores = [];
            $wordCounts = [];
            
            foreach ($urls as $url) {
                if (isset($this->results[$url]) && $this->results[$url]['status'] === 'success') {
                    $scores[] = $this->results[$url]['score'];
                    $wordCounts[] = $this->results[$url]['word_count'];
                }
            }
            
            if (!empty($scores)) {
                $avgScore = round(array_sum($scores) / count($scores), 1);
                $avgWords = round(array_sum($wordCounts) / count($wordCounts));
                echo "   {$type}: {$avgScore}/100 avg score, {$avgWords} avg words (" . count($urls) . " pages)\n";
            }
        }
        echo "\n";
    }
    
    private function generateRecommendations() {
        echo "💡 RECOMMENDATIONS:\n";
        
        $recommendations = [];
        
        // Analyze patterns in issues
        $allIssues = [];
        foreach ($this->results as $result) {
            if ($result['status'] === 'success') {
                $allIssues = array_merge($allIssues, $result['issues']);
            }
        }
        
        $issueCounts = array_count_values($allIssues);
        
        // Content depth recommendations
        $shallowPages = array_filter($this->results, fn($r) => $r['word_count'] < 600 && $r['status'] === 'success');
        if (count($shallowPages) > 0) {
            $recommendations[] = "Expand content on " . count($shallowPages) . " pages with <600 words";
        }
        
        // Schema recommendations
        $noSchemaPages = array_filter($this->results, fn($r) => $r['schema_count'] === 0 && $r['status'] === 'success');
        if (count($noSchemaPages) > 0) {
            $recommendations[] = "Add structured data to " . count($noSchemaPages) . " pages missing schema";
        }
        
        // Meta tag recommendations
        $missingTitles = count(array_filter($allIssues, fn($issue) => strpos($issue, 'Missing title') !== false));
        if ($missingTitles > 0) {
            $recommendations[] = "Add missing title tags to {$missingTitles} pages";
        }
        
        $missingDescriptions = count(array_filter($allIssues, fn($issue) => strpos($issue, 'Missing meta description') !== false));
        if ($missingDescriptions > 0) {
            $recommendations[] = "Add missing meta descriptions to {$missingDescriptions} pages";
        }
        
        // Image optimization
        $missingAltText = count(array_filter($allIssues, fn($issue) => strpos($issue, 'images missing alt') !== false));
        if ($missingAltText > 0) {
            $recommendations[] = "Add alt text to images on pages with missing alt attributes";
        }
        
        // URL structure
        $urlIssues = count(array_filter($allIssues, fn($issue) => strpos($issue, 'URL contains') !== false));
        if ($urlIssues > 0) {
            $recommendations[] = "Clean up URL structure - remove query parameters and fragments";
        }
        
        if (empty($recommendations)) {
            $recommendations[] = "Website is well-optimized! Consider adding more schema types for enhanced visibility";
        }
        
        foreach ($recommendations as $i => $rec) {
            echo "   " . ($i + 1) . ". {$rec}\n";
        }
        echo "\n";
    }
    
    private function getGrade($score) {
        if ($score >= 90) return "🟢";
        if ($score >= 80) return "🟡";
        if ($score >= 70) return "🟠";
        return "🔴";
    }
}

// Run the analysis
$analyzer = new CrawlAnalysis();
$results = $analyzer->analyzeWebsite();

echo "\n✅ Analysis complete!\n";
?>
