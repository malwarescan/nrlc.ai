<?php
/**
 * Crawl prechunking SEO docs pages and verify footer presence
 */

$baseUrl = 'https://nrlc.ai';
$startUrl = '/en-us/docs/prechunking-seo/croutons/';

$visited = [];
$toVisit = [$startUrl];
$results = [];

function checkFooter($html, $url) {
    $hasFooter = false;
    $hasSiteFooter = false;
    $hasFooterLinks = false;
    $hasCopyright = false;
    
    // Check for footer element
    if (preg_match('/<footer[^>]*class="[^"]*site-footer[^"]*"/i', $html)) {
        $hasSiteFooter = true;
    }
    
    // Check for footer class
    if (strpos($html, 'site-footer') !== false) {
        $hasFooter = true;
    }
    
    // Check for footer links
    if (preg_match('/<ul[^>]*class="[^"]*site-footer__links[^"]*"/i', $html)) {
        $hasFooterLinks = true;
    }
    
    // Check for copyright
    if (preg_match('/©\s*\d{4}\s*NRLC\.ai/i', $html)) {
        $hasCopyright = true;
    }
    
    return [
        'has_footer' => $hasFooter,
        'has_site_footer' => $hasSiteFooter,
        'has_footer_links' => $hasFooterLinks,
        'has_copyright' => $hasCopyright,
        'all_good' => $hasSiteFooter && $hasFooterLinks && $hasCopyright
    ];
}

function extractLinks($html, $baseUrl, $currentPath) {
    $links = [];
    
    // Extract all href attributes
    preg_match_all('/href=["\']([^"\']+)["\']/i', $html, $matches);
    
    foreach ($matches[1] as $link) {
        // Skip external links
        if (preg_match('/^https?:\/\//', $link)) {
            continue;
        }
        
        // Skip anchors
        if (strpos($link, '#') === 0) {
            continue;
        }
        
        // Skip mailto, tel, etc
        if (preg_match('/^(mailto|tel|javascript):/i', $link)) {
            continue;
        }
        
        // Normalize path
        if (strpos($link, '/') === 0) {
            $normalized = $link;
        } else {
            // Relative link - resolve from current path
            $normalized = dirname($currentPath) . '/' . $link;
            $normalized = preg_replace('#/+#', '/', $normalized);
        }
        
        // Only follow docs/prechunking-seo links
        if (strpos($normalized, '/docs/prechunking-seo/') !== false) {
            // Ensure trailing slash for consistency
            if (substr($normalized, -1) !== '/') {
                $normalized .= '/';
            }
            $links[] = $normalized;
        }
    }
    
    return array_unique($links);
}

function crawlPage($url, $baseUrl) {
    global $visited, $results;
    
    $fullUrl = $baseUrl . $url;
    
    echo "Crawling: $fullUrl\n";
    
    // Fetch page
    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; NRLC Crawler)');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        $results[$url] = [
            'status' => 'error',
            'http_code' => $httpCode,
            'message' => "HTTP $httpCode"
        ];
        echo "  ✗ HTTP $httpCode\n";
        return [];
    }
    
    // Check footer
    $footerCheck = checkFooter($html, $url);
    
    $results[$url] = [
        'status' => 'ok',
        'http_code' => $httpCode,
        'footer' => $footerCheck
    ];
    
    if ($footerCheck['all_good']) {
        echo "  ✓ Footer OK\n";
    } else {
        echo "  ⚠ Footer issues:\n";
        if (!$footerCheck['has_site_footer']) echo "    - Missing site-footer class\n";
        if (!$footerCheck['has_footer_links']) echo "    - Missing footer links\n";
        if (!$footerCheck['has_copyright']) echo "    - Missing copyright\n";
    }
    
    // Extract links
    $links = extractLinks($html, $baseUrl, $url);
    
    return $links;
}

// Main crawl loop
while (!empty($toVisit)) {
    $current = array_shift($toVisit);
    
    if (isset($visited[$current])) {
        continue;
    }
    
    $visited[$current] = true;
    
    $links = crawlPage($current, $baseUrl);
    
    // Add new links to visit queue
    foreach ($links as $link) {
        if (!isset($visited[$link])) {
            $toVisit[] = $link;
        }
    }
    
    echo "\n";
}

// Summary
echo "\n==================\n";
echo "CRAWL SUMMARY\n";
echo "==================\n\n";

$total = count($results);
$ok = 0;
$errors = 0;
$footerIssues = 0;

foreach ($results as $url => $result) {
    if ($result['status'] === 'ok') {
        $ok++;
        if (!$result['footer']['all_good']) {
            $footerIssues++;
        }
    } else {
        $errors++;
    }
}

echo "Total pages: $total\n";
echo "OK: $ok\n";
echo "Errors: $errors\n";
echo "Footer issues: $footerIssues\n\n";

echo "Pages with footer issues:\n";
foreach ($results as $url => $result) {
    if ($result['status'] === 'ok' && !$result['footer']['all_good']) {
        echo "  - $url\n";
    }
}

echo "\nAll pages:\n";
foreach ($results as $url => $result) {
    $status = $result['status'] === 'ok' ? '✓' : '✗';
    $footer = $result['status'] === 'ok' && $result['footer']['all_good'] ? '✓' : '⚠';
    echo "  $status $footer $url\n";
}

