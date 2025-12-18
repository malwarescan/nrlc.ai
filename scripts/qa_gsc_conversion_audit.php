<?php
/**
 * GSC Conversion QA Audit Script
 * 
 * Tests all pages from GSC performance data for:
 * - Technical SEO (status, canonical, meta, schema)
 * - Conversion elements (phone, email, CTAs)
 * - Content quality indicators
 * 
 * Usage: php scripts/qa_gsc_conversion_audit.php [base_url] [csv_path]
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(600); // 10 minutes

// Configuration
$baseUrl = $argv[1] ?? 'https://nrlc.ai';
$csvPath = $argv[2] ?? '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-18/Pages.csv';
$outputCsv = __DIR__ . '/gsc_conversion_audit_report.csv';
$verbose = in_array('-v', $argv) || in_array('--verbose', $argv);

// Expected conversion elements
$expectedPhone = ['+12135628438', '+1-213-562-8438', '213-562-8438'];
$expectedEmail = ['hirejoelm@gmail.com', 'contact@neuralcommandllc.com'];
$ctaKeywords = ['call', 'email', 'book', 'schedule', 'contact', 'request', 'consultation', 'demo', 'evaluation'];

// Helper functions
function fetchUrl($url, $timeout = 10) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; NRLC-QA-Bot/1.0)',
        CURLOPT_HTTPHEADER => ['Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8']
    ]);
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        return ['error' => $error, 'http_code' => 0];
    }
    
    return [
        'html' => $html,
        'http_code' => $httpCode,
        'final_url' => $finalUrl,
        'content_type' => $contentType
    ];
}

function extractMeta($html) {
    $meta = [
        'title' => '',
        'description' => '',
        'canonical' => '',
        'noindex' => false,
        'og_title' => '',
        'og_description' => ''
    ];
    
    // Title
    if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $m)) {
        $meta['title'] = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES, 'UTF-8'));
    }
    
    // Meta description
    if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^"\']+)["\']/i', $html, $m)) {
        $meta['description'] = trim(html_entity_decode($m[1], ENT_QUOTES, 'UTF-8'));
    }
    
    // Canonical
    if (preg_match('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']+)["\']/i', $html, $m)) {
        $meta['canonical'] = trim($m[1]);
    }
    
    // Noindex
    if (preg_match('/<meta[^>]*name=["\']robots["\'][^>]*content=["\']([^"\']+)["\']/i', $html, $m)) {
        $content = strtolower($m[1]);
        $meta['noindex'] = strpos($content, 'noindex') !== false;
    }
    
    // OG tags
    if (preg_match('/<meta[^>]*property=["\']og:title["\'][^>]*content=["\']([^"\']+)["\']/i', $html, $m)) {
        $meta['og_title'] = trim(html_entity_decode($m[1], ENT_QUOTES, 'UTF-8'));
    }
    if (preg_match('/<meta[^>]*property=["\']og:description["\'][^>]*content=["\']([^"\']+)["\']/i', $html, $m)) {
        $meta['og_description'] = trim(html_entity_decode($m[1], ENT_QUOTES, 'UTF-8'));
    }
    
    return $meta;
}

function checkConversionElements($html, $expectedPhone, $expectedEmail, $ctaKeywords) {
    $results = [
        'has_phone' => false,
        'phone_count' => 0,
        'phone_links' => [],
        'has_email' => false,
        'email_count' => 0,
        'email_links' => [],
        'has_cta' => false,
        'cta_count' => 0,
        'cta_types' => [],
        'has_contact_form' => false,
        'has_opencontactsheet' => false
    ];
    
    // Check for phone numbers
    $phonePatterns = [
        '/tel:([+\d\s\-\(\)]+)/i',
        '/\+1[\d\s\-\(\)]{10,}/',
        '/\(\d{3}\)\s*\d{3}[\-\s]?\d{4}/',
        '/\d{3}[\-\s]?\d{3}[\-\s]?\d{4}/'
    ];
    
    foreach ($phonePatterns as $pattern) {
        if (preg_match_all($pattern, $html, $matches)) {
            $results['phone_count'] += count($matches[0]);
            $results['phone_links'] = array_merge($results['phone_links'], $matches[1] ?? $matches[0]);
            $results['has_phone'] = true;
        }
    }
    
    // Check for email addresses
    if (preg_match_all('/mailto:([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/i', $html, $matches)) {
        $results['email_count'] = count($matches[1]);
        $results['email_links'] = $matches[1];
        $results['has_email'] = true;
    }
    
    // Check for CTA buttons/links
    $ctaPatterns = [
        '/<button[^>]*>(.*?)<\/button>/is',
        '/<a[^>]*class=["\'][^"\']*btn[^"\']*["\'][^>]*>(.*?)<\/a>/is',
        '/<a[^>]*>(.*?)(?:call|email|book|schedule|contact|request|consultation|demo|evaluation)(.*?)<\/a>/is'
    ];
    
    foreach ($ctaPatterns as $pattern) {
        if (preg_match_all($pattern, $html, $matches)) {
            $results['cta_count'] += count($matches[0]);
            foreach ($matches[1] as $ctaText) {
                $ctaText = strtolower(strip_tags($ctaText));
                foreach ($ctaKeywords as $keyword) {
                    if (strpos($ctaText, $keyword) !== false) {
                        $results['cta_types'][] = $keyword;
                        $results['has_cta'] = true;
                        break;
                    }
                }
            }
        }
    }
    
    // Check for openContactSheet function
    if (preg_match('/openContactSheet\s*\(/i', $html)) {
        $results['has_opencontactsheet'] = true;
        $results['has_cta'] = true;
    }
    
    // Check for contact forms
    if (preg_match('/<form[^>]*>(.*?)<\/form>/is', $html, $m)) {
        $formHtml = strtolower($m[1]);
        if (preg_match('/(contact|email|message|inquiry|consultation)/i', $formHtml)) {
            $results['has_contact_form'] = true;
        }
    }
    
    return $results;
}

function checkSchema($html) {
    $results = [
        'has_schema' => false,
        'schema_types' => [],
        'schema_count' => 0
    ];
    
    // Check for JSON-LD schema
    if (preg_match_all('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $matches)) {
        $results['schema_count'] = count($matches[1]);
        $results['has_schema'] = true;
        
        foreach ($matches[1] as $json) {
            $data = json_decode($json, true);
            if ($data && isset($data['@type'])) {
                $type = is_array($data['@type']) ? $data['@type'][0] : $data['@type'];
                $results['schema_types'][] = $type;
            }
        }
    }
    
    return $results;
}

function calculateConversionScore($conversion, $meta, $schema) {
    $score = 0;
    $maxScore = 100;
    
    // Conversion elements (50 points)
    if ($conversion['has_phone']) $score += 15;
    if ($conversion['has_email']) $score += 15;
    if ($conversion['has_cta'] || $conversion['has_opencontactsheet']) $score += 20;
    
    // Technical SEO (30 points)
    if (!empty($meta['title']) && strlen($meta['title']) > 10) $score += 5;
    if (!empty($meta['description']) && strlen($meta['description']) > 50) $score += 5;
    if (!empty($meta['canonical'])) $score += 10;
    if (!$meta['noindex']) $score += 10;
    
    // Schema (20 points)
    if ($schema['has_schema']) $score += 20;
    
    return min($score, $maxScore);
}

// Main execution
echo "GSC Conversion QA Audit\n";
echo "=======================\n\n";
echo "Base URL: $baseUrl\n";
echo "CSV Path: $csvPath\n";
echo "Output: $outputCsv\n\n";

if (!file_exists($csvPath)) {
    die("Error: CSV file not found: $csvPath\n");
}

// Read CSV
$pages = [];
$handle = fopen($csvPath, 'r');
if ($handle === false) {
    die("Error: Could not open CSV file\n");
}

// Skip header
$header = fgetcsv($handle, 1000, ',', '"', '\\');
if ($header === false) {
    die("Error: Could not read CSV header\n");
}

// Read all pages
$rowNum = 0;
while (($row = fgetcsv($handle, 1000, ',', '"', '\\')) !== false) {
    $rowNum++;
    if (count($row) < 5) continue;
    
    $url = trim($row[0]);
    $clicks = intval($row[1]);
    $impressions = intval($row[2]);
    $ctr = floatval(str_replace('%', '', $row[3]));
    $position = floatval($row[4]);
    
    if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
        continue;
    }
    
    $pages[] = [
        'url' => $url,
        'clicks' => $clicks,
        'impressions' => $impressions,
        'ctr' => $ctr,
        'position' => $position
    ];
}

fclose($handle);

echo "Found " . count($pages) . " pages to test\n\n";

// Test pages
$results = [];
$tested = 0;
$total = count($pages);
$progressFile = __DIR__ . '/gsc_conversion_audit_progress.txt';

foreach ($pages as $page) {
    $tested++;
    $url = $page['url'];
    
    // Write progress to file
    file_put_contents($progressFile, "Progress: $tested/$total pages tested\nLast URL: $url\n");
    
    if ($verbose) {
        echo "[$tested/$total] Testing: $url\n";
    } else {
        echo ".";
        if ($tested % 50 == 0) echo " $tested/$total\n";
    }
    
    $result = [
        'url' => $url,
        'clicks' => $page['clicks'],
        'impressions' => $page['impressions'],
        'ctr' => $page['ctr'],
        'position' => $page['position'],
        'http_code' => 0,
        'final_url' => '',
        'has_error' => false,
        'error_message' => '',
        'title' => '',
        'description' => '',
        'canonical' => '',
        'noindex' => false,
        'has_phone' => false,
        'has_email' => false,
        'has_cta' => false,
        'has_opencontactsheet' => false,
        'has_contact_form' => false,
        'has_schema' => false,
        'schema_types' => '',
        'conversion_score' => 0,
        'recommendations' => ''
    ];
    
    // Fetch page
    $fetch = fetchUrl($url);
    
    if (isset($fetch['error'])) {
        $result['has_error'] = true;
        $result['error_message'] = $fetch['error'];
        $results[] = $result;
        continue;
    }
    
    $result['http_code'] = $fetch['http_code'];
    $result['final_url'] = $fetch['final_url'];
    
    if ($fetch['http_code'] !== 200 || empty($fetch['html'])) {
        $result['has_error'] = true;
        $result['error_message'] = "HTTP {$fetch['http_code']} or empty content";
        $results[] = $result;
        continue;
    }
    
    // Extract meta
    $meta = extractMeta($fetch['html']);
    $result['title'] = $meta['title'];
    $result['description'] = $meta['description'];
    $result['canonical'] = $meta['canonical'];
    $result['noindex'] = $meta['noindex'];
    
    // Check conversion elements
    $conversion = checkConversionElements($fetch['html'], $expectedPhone, $expectedEmail, $ctaKeywords);
    $result['has_phone'] = $conversion['has_phone'];
    $result['has_email'] = $conversion['has_email'];
    $result['has_cta'] = $conversion['has_cta'];
    $result['has_opencontactsheet'] = $conversion['has_opencontactsheet'];
    $result['has_contact_form'] = $conversion['has_contact_form'];
    
    // Check schema
    $schema = checkSchema($fetch['html']);
    $result['has_schema'] = $schema['has_schema'];
    $result['schema_types'] = implode(', ', array_unique($schema['schema_types']));
    
    // Calculate conversion score
    $result['conversion_score'] = calculateConversionScore($conversion, $meta, $schema);
    
    // Generate recommendations
    $recommendations = [];
    if (!$result['has_phone']) $recommendations[] = 'Add phone number with tel: link';
    if (!$result['has_email']) $recommendations[] = 'Add email with mailto: link';
    if (!$result['has_cta'] && !$result['has_opencontactsheet']) $recommendations[] = 'Add CTA button (Call/Email/Book)';
    if (empty($result['description']) || strlen($result['description']) < 50) $recommendations[] = 'Improve meta description (min 50 chars)';
    if (empty($result['canonical'])) $recommendations[] = 'Add canonical tag';
    if ($result['noindex']) $recommendations[] = 'Remove noindex meta tag';
    if (!$result['has_schema']) $recommendations[] = 'Add JSON-LD schema markup';
    
    $result['recommendations'] = implode('; ', $recommendations);
    
    $results[] = $result;
    
    // Rate limiting
    usleep(100000); // 0.1 second delay
}

echo "\n\nTesting complete!\n\n";

// Write results to CSV
$outputHandle = fopen($outputCsv, 'w');
if ($outputHandle === false) {
    die("Error: Could not create output CSV\n");
}

// Write header
fputcsv($outputHandle, [
    'URL',
    'Clicks',
    'Impressions',
    'CTR',
    'Position',
    'HTTP Code',
    'Final URL',
    'Has Error',
    'Error Message',
    'Title',
    'Description',
    'Canonical',
    'Noindex',
    'Has Phone',
    'Has Email',
    'Has CTA',
    'Has openContactSheet',
    'Has Contact Form',
    'Has Schema',
    'Schema Types',
    'Conversion Score',
    'Recommendations'
], ',', '"', '\\');

// Write results
foreach ($results as $result) {
    fputcsv($outputHandle, [
        $result['url'],
        $result['clicks'],
        $result['impressions'],
        $result['ctr'],
        $result['position'],
        $result['http_code'],
        $result['final_url'],
        $result['has_error'] ? 'Yes' : 'No',
        $result['error_message'],
        $result['title'],
        $result['description'],
        $result['canonical'],
        $result['noindex'] ? 'Yes' : 'No',
        $result['has_phone'] ? 'Yes' : 'No',
        $result['has_email'] ? 'Yes' : 'No',
        $result['has_cta'] ? 'Yes' : 'No',
        $result['has_opencontactsheet'] ? 'Yes' : 'No',
        $result['has_contact_form'] ? 'Yes' : 'No',
        $result['has_schema'] ? 'Yes' : 'No',
        $result['schema_types'],
        $result['conversion_score'],
        $result['recommendations']
    ], ',', '"', '\\');
}

fclose($outputHandle);

// Summary statistics
$totalPages = count($results);
$successful = count(array_filter($results, fn($r) => $r['http_code'] === 200 && !$r['has_error']));
$hasPhone = count(array_filter($results, fn($r) => $r['has_phone']));
$hasEmail = count(array_filter($results, fn($r) => $r['has_email']));
$hasCta = count(array_filter($results, fn($r) => $r['has_cta'] || $r['has_opencontactsheet']));
$hasSchema = count(array_filter($results, fn($r) => $r['has_schema']));
$avgScore = $totalPages > 0 ? array_sum(array_column($results, 'conversion_score')) / $totalPages : 0;

echo "Summary Statistics\n";
echo "==================\n";
echo "Total pages tested: $totalPages\n";
echo "Successful (HTTP 200): $successful\n";
echo "Pages with phone: $hasPhone (" . round($hasPhone / $totalPages * 100, 1) . "%)\n";
echo "Pages with email: $hasEmail (" . round($hasEmail / $totalPages * 100, 1) . "%)\n";
echo "Pages with CTA: $hasCta (" . round($hasCta / $totalPages * 100, 1) . "%)\n";
echo "Pages with schema: $hasSchema (" . round($hasSchema / $totalPages * 100, 1) . "%)\n";
echo "Average conversion score: " . round($avgScore, 1) . "/100\n\n";

echo "Report saved to: $outputCsv\n";
echo "\nTop pages needing conversion optimization:\n";
echo "==========================================\n";

// Sort by impressions and conversion score
usort($results, function($a, $b) {
    if ($a['impressions'] != $b['impressions']) {
        return $b['impressions'] - $a['impressions'];
    }
    return $a['conversion_score'] - $b['conversion_score'];
});

$topIssues = array_slice($results, 0, 20);
foreach ($topIssues as $i => $page) {
    if ($page['impressions'] > 0 && $page['conversion_score'] < 70) {
        echo ($i + 1) . ". {$page['url']}\n";
        echo "   Impressions: {$page['impressions']}, Score: {$page['conversion_score']}/100\n";
        if (!empty($page['recommendations'])) {
            echo "   Issues: {$page['recommendations']}\n";
        }
        echo "\n";
    }
}

