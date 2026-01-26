<?php
/**
 * Trigger Croutons Discovery Webhook for key pages
 */

$domain = 'nrlc.ai';
$baseUrl = 'https://nrlc.ai';
$webhookUrl = 'https://precogs.croutons.ai/v1/discover';

// Check if a specific page was passed via CLI
if (isset($argv[1])) {
    $pages = [$argv[1]];
    // If it's a relative path, prepend base URL
    if (strpos($pages[0], 'http') !== 0) {
        $pages[0] = $baseUrl . '/' . ltrim($pages[0], '/');
    }
} else {
    $pages = [
        '/',
        '/en-us/',
        '/en-gb/',
        '/services/',
        '/insights/',
        '/insights/silent-hydration-seo/',
        '/insights/prechunking-content-ai-retrieval/',
        '/insights/ai-retrieval-llm-citation/',
        '/products/croutons-ai/',
        '/careers/llm-strategist/new-york/'
    ];
}

function trigger_discovery($pageUrl, $webhookUrl, $domain) {
    echo "Triggering discovery for: $pageUrl ... ";
    
    $data = [
        'domain' => $domain,
        'page' => $pageUrl
    ];
    
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close() is deprecated in PHP 8.5 but still works for now, keeping it simple
    @curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        if (isset($result['ok']) && $result['ok']) {
            echo "SUCCESS (Units: " . ($result['ingestion']['units_extracted'] ?? 'unknown') . ")\n";
        } else {
            echo "FAILED: " . ($result['error'] ?? $response) . "\n";
        }
    } else {
        echo "ERROR (HTTP $httpCode): $response\n";
    }
}

foreach ($pages as $pathOrUrl) {
    $fullUrl = (strpos($pathOrUrl, 'http') === 0) ? $pathOrUrl : $baseUrl . $pathOrUrl;
    trigger_discovery($fullUrl, $webhookUrl, $domain);
}

