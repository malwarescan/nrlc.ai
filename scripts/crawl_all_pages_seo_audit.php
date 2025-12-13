<?php
/**
 * Comprehensive SEO Audit Crawler
 * Crawls every page and ensures titles/descriptions match page intent
 */

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/csv.php';

$baseDir = __DIR__ . '/../pages/';
$report = [];
$issues = [];
$fixed = 0;

/**
 * Extract H1 from page content
 */
function extract_h1_from_file(string $filePath): ?string {
    $content = file_get_contents($filePath);
    if (preg_match('/<h1[^>]*class="[^"]*content-block__title[^"]*"[^>]*>(.*?)<\/h1>/is', $content, $matches)) {
        return trim(strip_tags($matches[1]));
    }
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $content, $matches)) {
        return trim(strip_tags($matches[1]));
    }
    return null;
}

/**
 * Extract lead paragraph from page
 */
function extract_lead_from_file(string $filePath): ?string {
    $content = file_get_contents($filePath);
    if (preg_match('/<p[^>]*class="[^"]*lead[^"]*"[^>]*>(.*?)<\/p>/is', $content, $matches)) {
        $text = trim(strip_tags($matches[1]));
        return strlen($text) > 20 ? $text : null;
    }
    return null;
}

/**
 * Extract page intent from content
 */
function extract_page_intent(string $filePath, string $slug): array {
    $h1 = extract_h1_from_file($filePath);
    $lead = extract_lead_from_file($filePath);
    $content = file_get_contents($filePath);
    
    // Extract key phrases
    $keyPhrases = [];
    if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches)) {
        foreach ($matches[1] as $h2) {
            $text = trim(strip_tags($h2));
            if (strlen($text) > 5 && strlen($text) < 100) {
                $keyPhrases[] = $text;
            }
        }
    }
    
    // Determine page type
    $pageType = 'general';
    if (strpos($slug, 'services/') === 0) $pageType = 'service';
    if (strpos($slug, 'products/') === 0) $pageType = 'product';
    if (strpos($slug, 'insights/') === 0) $pageType = 'article';
    if (strpos($slug, 'blog/') === 0) $pageType = 'blog';
    if (strpos($slug, 'careers/') === 0) $pageType = 'career';
    if (strpos($slug, 'home/') === 0) $pageType = 'homepage';
    
    return [
        'h1' => $h1,
        'lead' => $lead,
        'keyPhrases' => array_slice($keyPhrases, 0, 5),
        'pageType' => $pageType
    ];
}

/**
 * Generate optimal title based on intent
 */
function generate_optimal_title(array $intent, string $currentTitle): string {
    $h1 = $intent['h1'] ?? '';
    $pageType = $intent['pageType'];
    
    // If H1 exists and is meaningful, use it as base
    if (!empty($h1) && strlen($h1) > 5) {
        $base = $h1;
        
        // Add context based on page type
        switch ($pageType) {
            case 'service':
                if (strpos($currentTitle, 'Services') === false && strpos($currentTitle, 'Service') === false) {
                    $base .= ' Services';
                }
                if (strpos($currentTitle, 'AI SEO') === false && strpos($currentTitle, 'NRLC') === false) {
                    $base .= ' | AI SEO';
                }
                break;
            case 'product':
                if (strpos($currentTitle, 'Product') === false && strpos($currentTitle, 'NRLC') === false) {
                    $base .= ' | NRLC.ai';
                }
                break;
            case 'article':
            case 'blog':
                if (strpos($currentTitle, 'Research') === false && strpos($currentTitle, 'Insights') === false) {
                    $base .= ' | AI SEO Research';
                }
                break;
        }
        
        // Ensure brand mention if missing
        if (strpos($base, 'NRLC') === false && strlen($base) < 50) {
            $base .= ' | NRLC.ai';
        }
        
        // Trim to 60 chars max
        if (strlen($base) > 60) {
            $base = substr($base, 0, 57) . '...';
        }
        
        return $base;
    }
    
    return $currentTitle; // Keep current if no better option
}

/**
 * Generate optimal description based on intent
 */
function generate_optimal_description(array $intent, string $currentDesc): string {
    $lead = $intent['lead'] ?? '';
    $h1 = $intent['h1'] ?? '';
    $pageType = $intent['pageType'];
    
    // Prefer lead paragraph if available
    if (!empty($lead) && strlen($lead) > 30) {
        $desc = $lead;
        
        // Add value proposition if missing
        if (strpos($desc, 'AI SEO') === false && strpos($desc, 'GEO-16') === false) {
            switch ($pageType) {
                case 'service':
                    $desc .= ' Expert AI SEO services with GEO-16 framework.';
                    break;
                case 'product':
                    $desc .= ' AI SEO product by NRLC.ai.';
                    break;
            }
        }
        
        // Trim to 155 chars
        if (strlen($desc) > 155) {
            $desc = substr($desc, 0, 152) . '...';
        }
        
        return $desc;
    }
    
    // Fallback: use H1 + context
    if (!empty($h1)) {
        $desc = "$h1. ";
        switch ($pageType) {
            case 'service':
                $desc .= "Expert AI SEO services with GEO-16 framework implementation and structured data optimization.";
                break;
            case 'product':
                $desc .= "AI SEO product by NRLC.ai for structured data and LLM optimization.";
                break;
            case 'article':
                $desc .= "Comprehensive research and insights on AI-first SEO optimization.";
                break;
            default:
                $desc .= "AI SEO services and solutions by NRLC.ai.";
        }
        
        if (strlen($desc) > 155) {
            $desc = substr($desc, 0, 152) . '...';
        }
        
        return $desc;
    }
    
    return $currentDesc;
}

/**
 * Check if title/description match intent
 */
function check_metadata_match(string $title, string $desc, array $intent): array {
    $issues = [];
    
    $h1 = $intent['h1'] ?? '';
    
    // Check if H1 is in title (should be for most pages)
    if (!empty($h1) && strlen($h1) > 5) {
        $h1Words = explode(' ', strtolower($h1));
        $titleWords = explode(' ', strtolower($title));
        $matchCount = 0;
        foreach ($h1Words as $word) {
            if (in_array($word, $titleWords)) {
                $matchCount++;
            }
        }
        $matchRatio = count($h1Words) > 0 ? $matchCount / count($h1Words) : 0;
        
        if ($matchRatio < 0.3 && strlen($h1) < 40) {
            $issues[] = "Title doesn't match H1 ($h1)";
        }
    }
    
    // Check title length
    if (strlen($title) < 30) {
        $issues[] = "Title too short (" . strlen($title) . " chars)";
    }
    if (strlen($title) > 60) {
        $issues[] = "Title too long (" . strlen($title) . " chars)";
    }
    
    // Check description length
    if (strlen($desc) < 120) {
        $issues[] = "Description too short (" . strlen($desc) . " chars)";
    }
    if (strlen($desc) > 160) {
        $issues[] = "Description too long (" . strlen($desc) . " chars)";
    }
    
    // Check for brand mention in title
    if (strpos($title, 'NRLC') === false && strpos($title, 'nrlc') === false) {
        // Allow for some page types to not have brand
        if (!in_array($intent['pageType'], ['homepage'])) {
            // Not critical, just note it
        }
    }
    
    return $issues;
}

/**
 * Recursively find all PHP pages
 */
function find_all_pages(string $dir, string $baseDir): array {
    $pages = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $relativePath = str_replace($baseDir, '', $file->getPathname());
            $relativePath = str_replace('.php', '', $relativePath);
            $relativePath = str_replace('\\', '/', $relativePath);
            $pages[] = [
                'path' => $file->getPathname(),
                'slug' => $relativePath
            ];
        }
    }
    
    return $pages;
}

// Main execution
echo "🔍 Starting comprehensive SEO audit crawl...\n\n";

$allPages = find_all_pages($baseDir, $baseDir);
echo "Found " . count($allPages) . " pages to audit\n\n";

foreach ($allPages as $page) {
    $filePath = $page['path'];
    $slug = $page['slug'];
    
    // Skip certain files
    if (strpos($slug, 'index') !== false && $slug !== 'home/home') {
        // Check index pages separately
    }
    
    // Extract current metadata
    $currentTitle = '';
    $currentDesc = '';
    
    // Check if page sets custom metadata
    $content = file_get_contents($filePath);
    if (preg_match('/\$GLOBALS\[\'pageTitle\'\]\s*=\s*[\'"](.*?)[\'"]/s', $content, $matches)) {
        $currentTitle = $matches[1];
    }
    if (preg_match('/\$GLOBALS\[\'pageDesc\'\]\s*=\s*[\'"](.*?)[\'"]/s', $content, $matches)) {
        $currentDesc = $matches[1];
    }
    
    // If no custom metadata, check meta_for_slug
    if (empty($currentTitle) || empty($currentDesc)) {
        try {
            list($title, $desc, $path) = meta_for_slug($slug);
            if (empty($currentTitle)) $currentTitle = $title;
            if (empty($currentDesc)) $currentDesc = $desc;
        } catch (Exception $e) {
            // Skip if can't determine
            continue;
        }
    }
    
    // Extract intent
    $intent = extract_page_intent($filePath, $slug);
    
    // Check for issues
    $issues = check_metadata_match($currentTitle, $currentDesc, $intent);
    
    // Generate optimal metadata
    $optimalTitle = generate_optimal_title($intent, $currentTitle);
    $optimalDesc = generate_optimal_description($intent, $currentDesc);
    
    $needsFix = false;
    if ($optimalTitle !== $currentTitle || $optimalDesc !== $currentDesc || !empty($issues)) {
        $needsFix = true;
    }
    
    $report[] = [
        'slug' => $slug,
        'file' => $filePath,
        'currentTitle' => $currentTitle,
        'currentDesc' => $currentDesc,
        'optimalTitle' => $optimalTitle,
        'optimalDesc' => $optimalDesc,
        'h1' => $intent['h1'],
        'issues' => $issues,
        'needsFix' => $needsFix
    ];
    
    if ($needsFix) {
        echo "⚠️  $slug\n";
        if (!empty($issues)) {
            foreach ($issues as $issue) {
                echo "   - $issue\n";
            }
        }
        if ($optimalTitle !== $currentTitle) {
            echo "   Title: \"$currentTitle\" → \"$optimalTitle\"\n";
        }
        if ($optimalDesc !== $currentDesc) {
            echo "   Desc: \"$currentDesc\" → \"$optimalDesc\"\n";
        }
        echo "\n";
    }
}

// Generate report
$reportFile = __DIR__ . '/../logs/seo_audit_report_' . date('Y-m-d_His') . '.json';
file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

$needsFixCount = count(array_filter($report, fn($r) => $r['needsFix']));

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 Audit Summary\n";
echo str_repeat("=", 60) . "\n";
echo "Total pages audited: " . count($report) . "\n";
echo "Pages needing fixes: $needsFixCount\n";
echo "Report saved to: $reportFile\n";
echo "\n";

// Apply fixes if --fix flag is provided
$shouldFix = in_array('--fix', $argv ?? []);

if ($shouldFix && $needsFixCount > 0) {
    echo "\n🔧 Applying fixes...\n\n";
    
    foreach ($report as $item) {
        if (!$item['needsFix']) continue;
        
        $filePath = $item['file'];
        $content = file_get_contents($filePath);
        $originalContent = $content;
        
        // Fix title
        if ($item['optimalTitle'] !== $item['currentTitle']) {
            // Replace existing pageTitle (handle both single and double quotes, and multiline)
            if (preg_match('/\$GLOBALS\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"](.*?)[\'"]/s', $content)) {
                $content = preg_replace(
                    '/\$GLOBALS\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"](.*?)[\'"]/s',
                    '$GLOBALS[\'pageTitle\'] = ' . var_export($item['optimalTitle'], true),
                    $content
                );
            } else {
                // Add if missing - find the best insertion point
                $insertPoint = 0;
                
                // Try after PHP opening tag
                if (preg_match('/^<\?php\s+/', $content, $matches, PREG_OFFSET_CAPTURE)) {
                    $insertPoint = $matches[0][1] + strlen($matches[0][0]);
                }
                
                // Try after require statements
                if (preg_match('/(require_once[^;]+;[\s\n]*)+/', $content, $matches, PREG_OFFSET_CAPTURE)) {
                    $insertPoint = max($insertPoint, $matches[0][1] + strlen($matches[0][0]));
                }
                
                // Try after __page_slug
                if (preg_match('/\$GLOBALS\[\s*[\'"]__page_slug[\'"]\s*\]\s*=\s*[^;]+;/', $content, $matches, PREG_OFFSET_CAPTURE)) {
                    $insertPoint = max($insertPoint, $matches[0][1] + strlen($matches[0][0]));
                }
                
                $metadata = "\n\$GLOBALS['pageTitle'] = " . var_export($item['optimalTitle'], true) . ";\n";
                $content = substr_replace($content, $metadata, $insertPoint, 0);
            }
        }
        
        // Fix description
        if ($item['optimalDesc'] !== $item['currentDesc']) {
            // Replace existing pageDesc
            if (preg_match('/\$GLOBALS\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"](.*?)[\'"]/s', $content)) {
                $content = preg_replace(
                    '/\$GLOBALS\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"](.*?)[\'"]/s',
                    '$GLOBALS[\'pageDesc\'] = ' . var_export($item['optimalDesc'], true),
                    $content
                );
            } else {
                // Add if missing (after pageTitle)
                if (preg_match('/\$GLOBALS\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[^;]+;/', $content, $matches, PREG_OFFSET_CAPTURE)) {
                    $pos = $matches[0][1] + strlen($matches[0][0]);
                    $content = substr_replace($content, "\n\$GLOBALS['pageDesc'] = " . var_export($item['optimalDesc'], true) . ";\n", $pos, 0);
                } else {
                    // Add at beginning if no pageTitle found
                    $insertPoint = 0;
                    if (preg_match('/^<\?php\s+/', $content, $matches, PREG_OFFSET_CAPTURE)) {
                        $insertPoint = $matches[0][1] + strlen($matches[0][0]);
                    }
                    $metadata = "\n\$GLOBALS['pageDesc'] = " . var_export($item['optimalDesc'], true) . ";\n";
                    $content = substr_replace($content, $metadata, $insertPoint, 0);
                }
            }
        }
        
        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            echo "✅ Fixed: {$item['slug']}\n";
            $fixed++;
        }
    }
    
    echo "\n✅ Fixed $fixed pages\n";
} elseif ($needsFixCount > 0) {
    echo "💡 Run with --fix flag to automatically apply fixes\n";
    echo "   php scripts/crawl_all_pages_seo_audit.php --fix\n";
}

