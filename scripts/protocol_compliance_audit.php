<?php
/**
 * NRLC AI Optimization Protocol Compliance Audit
 * 
 * This script audits the entire website against the NCAOP standards
 * for SEO, AEO, GEO, Schema, and Croutonization compliance.
 */

// Include required files
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/schema_builders.php';

class ProtocolComplianceAudit {
    private $baseUrl;
    private $results = [];
    private $totalScore = 0;
    private $maxScore = 0;
    
    public function __construct() {
        $this->baseUrl = absolute_url('/');
    }
    
    /**
     * Run complete protocol compliance audit
     */
    public function runAudit() {
        echo "🔍 NRLC AI Optimization Protocol Compliance Audit\n";
        echo "==================================================\n\n";
        
        // Get all pages to audit
        $pages = $this->getAllPages();
        
        foreach ($pages as $page) {
            echo "📄 Auditing: {$page['url']}\n";
            $this->auditPage($page);
            echo "\n";
        }
        
        $this->generateSummaryReport();
    }
    
    /**
     * Get all pages for audit
     */
    private function getAllPages() {
        $pages = [];
        
        // Get all PHP files in pages directory
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(__DIR__ . '/../pages')
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relativePath = str_replace(__DIR__ . '/../pages/', '', $file->getPathname());
                $url = $this->convertPathToUrl($relativePath);
                
                if ($url) {
                    $pages[] = [
                        'path' => $file->getPathname(),
                        'url' => $url,
                        'relative_path' => $relativePath
                    ];
                }
            }
        }
        
        return $pages;
    }
    
    /**
     * Convert file path to URL
     */
    private function convertPathToUrl($path) {
        // Skip certain files
        if (strpos($path, 'index.php') !== false && $path !== 'index.php') {
            return null;
        }
        
        // Convert path to URL format
        $url = str_replace('.php', '', $path);
        $url = str_replace(DIRECTORY_SEPARATOR, '/', $url);
        
        // Handle special cases
        if ($url === 'home/home') {
            return '/';
        }
        
        // Add locale prefix if not present
        if (!preg_match('#^[a-z]{2}-[a-z]{2}/#', $url)) {
            $url = 'en-us/' . $url;
        }
        
        return '/' . $url . '/';
    }
    
    /**
     * Audit individual page
     */
    private function auditPage($page) {
        $pageResults = [
            'url' => $page['url'],
            'technical_seo' => $this->auditTechnicalSEO($page),
            'aeo_compliance' => $this->auditAEOCompliance($page),
            'geo_optimization' => $this->auditGEOOptimization($page),
            'schema_markup' => $this->auditSchemaMarkup($page),
            'croutonization' => $this->auditCroutonization($page)
        ];
        
        // Calculate page score
        $pageScore = array_sum($pageResults) / 5;
        $pageResults['overall_score'] = $pageScore;
        
        $this->results[] = $pageResults;
        $this->totalScore += $pageScore;
        $this->maxScore += 100;
        
        // Display page results
        echo "  Technical SEO: " . $this->formatScore($pageResults['technical_seo']) . "\n";
        echo "  AEO Compliance: " . $this->formatScore($pageResults['aeo_compliance']) . "\n";
        echo "  GEO Optimization: " . $this->formatScore($pageResults['geo_optimization']) . "\n";
        echo "  Schema Markup: " . $this->formatScore($pageResults['schema_markup']) . "\n";
        echo "  Croutonization: " . $this->formatScore($pageResults['croutonization']) . "\n";
        echo "  Overall Score: " . $this->formatScore($pageResults['overall_score']) . "\n";
    }
    
    /**
     * Audit Technical SEO compliance
     */
    private function auditTechnicalSEO($page) {
        $score = 0;
        $maxScore = 20;
        
        // Check file exists and is readable
        if (!file_exists($page['path'])) {
            return 0;
        }
        
        $content = file_get_contents($page['path']);
        
        // HTTPS requirement (5 points)
        if (strpos($content, 'https://') !== false) {
            $score += 5;
        }
        
        // Canonical control (5 points)
        if (strpos($content, 'canonical') !== false) {
            $score += 5;
        }
        
        // Meta title (5 points)
        if (preg_match('/<title[^>]*>/i', $content)) {
            $score += 5;
        }
        
        // Meta description (5 points)
        if (preg_match('/name=["\']description["\']/i', $content)) {
            $score += 5;
        }
        
        return ($score / $maxScore) * 100;
    }
    
    /**
     * Audit AEO compliance
     */
    private function auditAEOCompliance($page) {
        $score = 0;
        $maxScore = 20;
        
        $content = file_get_contents($page['path']);
        
        // Question-answer format (5 points)
        if (preg_match('/<h[1-6][^>]*>.*\?.*<\/h[1-6]>/i', $content)) {
            $score += 5;
        }
        
        // FAQ schema presence (5 points)
        if (strpos($content, 'FAQPage') !== false) {
            $score += 5;
        }
        
        // Explicit definitions (5 points)
        if (preg_match('/<dfn[^>]*>/i', $content) || preg_match('/<strong[^>]*>.*is.*<\/strong>/i', $content)) {
            $score += 5;
        }
        
        // Atomic content structure (5 points)
        if (preg_match('/<div[^>]*class="[^"]*content-block[^"]*"/i', $content)) {
            $score += 5;
        }
        
        return ($score / $maxScore) * 100;
    }
    
    /**
     * Audit GEO optimization
     */
    private function auditGEOOptimization($page) {
        $score = 0;
        $maxScore = 20;
        
        $content = file_get_contents($page['path']);
        
        // Entity consistency (5 points)
        if (strpos($content, 'Neural Command') !== false) {
            $score += 5;
        }
        
        // Entity definitions (5 points)
        if (preg_match('/itemscope[^>]*itemtype="https:\/\/schema\.org\/[^"]*"/i', $content)) {
            $score += 5;
        }
        
        // Context independence (5 points)
        if (preg_match('/<p[^>]*>[^<]*\b(is|are|provides|offers)\b[^<]*<\/p>/i', $content)) {
            $score += 5;
        }
        
        // Verification signals (5 points)
        if (strpos($content, 'structured data') !== false || strpos($content, 'schema') !== false) {
            $score += 5;
        }
        
        return ($score / $maxScore) * 100;
    }
    
    /**
     * Audit schema markup
     */
    private function auditSchemaMarkup($page) {
        $score = 0;
        $maxScore = 20;
        
        $content = file_get_contents($page['path']);
        
        // JSON-LD presence (5 points)
        if (preg_match('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>/i', $content)) {
            $score += 5;
        }
        
        // Organization schema (5 points)
        if (strpos($content, '"@type": "Organization"') !== false) {
            $score += 5;
        }
        
        // WebPage schema (5 points)
        if (strpos($content, '"@type": "WebPage"') !== false) {
            $score += 5;
        }
        
        // Schema validity (basic check) (5 points)
        if (preg_match('/"@context": "https:\/\/schema\.org"/i', $content)) {
            $score += 5;
        }
        
        return ($score / $maxScore) * 100;
    }
    
    /**
     * Audit croutonization
     */
    private function auditCroutonization($page) {
        $score = 0;
        $maxScore = 20;
        
        $content = file_get_contents($page['path']);
        
        // Atomic content blocks (5 points)
        if (preg_match('/<div[^>]*class="[^"]*content-block[^"]*"/i', $content)) {
            $score += 5;
        }
        
        // Stable IDs (5 points)
        if (preg_match('/id="[^"]*"/i', $content)) {
            $score += 5;
        }
        
        // Machine-readable content (5 points)
        if (strpos($content, 'application/ld+json') !== false) {
            $score += 5;
        }
        
        // Citation-ready format (5 points)
        if (preg_match('/<p[^>]*>[^<]{50,200}<\/p>/i', $content)) {
            $score += 5;
        }
        
        return ($score / $maxScore) * 100;
    }
    
    /**
     * Format score for display
     */
    private function formatScore($score) {
        if ($score >= 90) {
            return "✅ {$score}% (Excellent)";
        } elseif ($score >= 80) {
            return "🟡 {$score}% (Good)";
        } elseif ($score >= 70) {
            return "🟠 {$score}% (Fair)";
        } else {
            return "❌ {$score}% (Needs Work)";
        }
    }
    
    /**
     * Generate summary report
     */
    private function generateSummaryReport() {
        $overallScore = $this->maxScore > 0 ? ($this->totalScore / $this->maxScore) * 100 : 0;
        
        echo "📊 PROTOCOL COMPLIANCE SUMMARY\n";
        echo "================================\n\n";
        echo "Overall Site Score: " . $this->formatScore($overallScore) . "\n";
        echo "Pages Audited: " . count($this->results) . "\n\n";
        
        // Category averages
        $technicalAvg = array_sum(array_column($this->results, 'technical_seo')) / count($this->results);
        $aeoAvg = array_sum(array_column($this->results, 'aeo_compliance')) / count($this->results);
        $geoAvg = array_sum(array_column($this->results, 'geo_optimization')) / count($this->results);
        $schemaAvg = array_sum(array_column($this->results, 'schema_markup')) / count($this->results);
        $croutonAvg = array_sum(array_column($this->results, 'croutonization')) / count($this->results);
        
        echo "Category Averages:\n";
        echo "  Technical SEO: " . $this->formatScore($technicalAvg) . "\n";
        echo "  AEO Compliance: " . $this->formatScore($aeoAvg) . "\n";
        echo "  GEO Optimization: " . $this->formatScore($geoAvg) . "\n";
        echo "  Schema Markup: " . $this->formatScore($schemaAvg) . "\n";
        echo "  Croutonization: " . $this->formatScore($croutonAvg) . "\n\n";
        
        // Top performing pages
        usort($this->results, function($a, $b) {
            return $b['overall_score'] <=> $a['overall_score'];
        });
        
        echo "🏆 Top 5 Performing Pages:\n";
        for ($i = 0; $i < min(5, count($this->results)); $i++) {
            $page = $this->results[$i];
            echo "  " . ($i + 1) . ". " . $page['url'] . " - " . round($page['overall_score'], 1) . "%\n";
        }
        
        echo "\n📈 Pages Needing Improvement (< 80%):\n";
        $improvementPages = array_filter($this->results, function($page) {
            return $page['overall_score'] < 80;
        });
        
        foreach ($improvementPages as $page) {
            echo "  " . $page['url'] . " - " . round($page['overall_score'], 1) . "%\n";
        }
        
        // Generate detailed report file
        $this->generateDetailedReport();
    }
    
    /**
     * Generate detailed CSV report
     */
    private function generateDetailedReport() {
        $reportFile = __DIR__ . '/../reports/protocol_compliance_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Ensure reports directory exists
        if (!is_dir(dirname($reportFile))) {
            mkdir(dirname($reportFile), 0755, true);
        }
        
        $handle = fopen($reportFile, 'w');
        
        // Header
        fputcsv($handle, [
            'URL',
            'Technical SEO',
            'AEO Compliance', 
            'GEO Optimization',
            'Schema Markup',
            'Croutonization',
            'Overall Score'
        ], ',', '"', '\\');
        
        // Data rows
        foreach ($this->results as $page) {
            fputcsv($handle, [
                $page['url'],
                round($page['technical_seo'], 1),
                round($page['aeo_compliance'], 1),
                round($page['geo_optimization'], 1),
                round($page['schema_markup'], 1),
                round($page['croutonization'], 1),
                round($page['overall_score'], 1)
            ], ',', '"', '\\');
        }
        
        fclose($handle);
        
        echo "\n📄 Detailed report saved to: " . basename($reportFile) . "\n";
    }
}

// Run the audit
if (php_sapi_name() === 'cli') {
    $audit = new ProtocolComplianceAudit();
    $audit->runAudit();
} else {
    echo "<pre>";
    $audit = new ProtocolComplianceAudit();
    $audit->runAudit();
    echo "</pre>";
}
?>
