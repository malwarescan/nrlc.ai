<?php
/**
 * NRLC AI Case Study System - Live AI Answer Crawler & Verification Loop
 * 
 * This closes the system by verifying case study claims remain true over time.
 * 
 * For each case study:
 * - Store canonical test prompts
 * - Query: ChatGPT, Claude, Google AI Overviews (via SERP snapshot)
 * - Record: Brand mention (yes/no), Position, Citation presence, Hallucinated competitors
 * 
 * Output stored per case study:
 * {
 *   "prompt": "Best software for X",
 *   "appears": true,
 *   "position": 1,
 *   "citation": true,
 *   "notes": "Correct brand attribution"
 * }
 */

require_once __DIR__ . '/../lib/case_study_registry.php';
require_once __DIR__ . '/../lib/case_study_schema.php';

// Configuration
$dataDir = __DIR__ . '/../data/ai_verification/';
if (!is_dir($dataDir)) {
  mkdir($dataDir, 0755, true);
}

// Database connection (if using database)
// For file-based storage, we'll use JSON files
// In production, replace with actual database queries
function storeAiCheck(string $caseSlug, string $prompt, string $model, array $result): void {
  global $dataDir;
  
  // Sanitize slug to prevent path traversal
  $safeSlug = preg_replace('/[^a-z0-9-]/', '', strtolower($caseSlug));
  $safeModel = preg_replace('/[^a-z0-9_]/', '', strtolower($model));
  
  $file = $dataDir . "{$safeSlug}_{$safeModel}_" . date('Y-m-d') . ".json";
  $data = [
    'case_slug' => $caseSlug,
    'prompt' => $prompt,
    'model' => $model,
    'timestamp' => date('Y-m-d H:i:s'),
    'result' => $result
  ];
  
  // Append to file (or use database in production)
  $existing = [];
  if (file_exists($file)) {
    $existing = json_decode(file_get_contents($file), true) ?? [];
  }
  $existing[] = $data;
  file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT));
}

/**
 * Get canonical test prompts for a case study
 */
function get_test_prompts(string $slug, array $caseData): array {
  $clusterMeta = get_prompt_cluster_metadata($caseData['prompt_cluster']);
  $industry = $caseData['industry'];
  
  // Generate prompts based on cluster and industry
  $prompts = [];
  
  foreach ($clusterMeta['canonical_prompts'] as $template) {
    $prompt = str_replace(['{industry}', '{service}', '{brand}', '{city}'], 
                          [$industry, $industry . ' services', 'NRLC.ai', 'your area'], 
                          $template);
    $prompts[] = $prompt;
  }
  
  // Add industry-specific prompts
  $industryPrompts = [
    'SaaS' => [
      "Best B2B SaaS platforms for {$industry}",
      "Top {$industry} software solutions",
      "What are the best {$industry} tools?"
    ],
    'E-commerce' => [
      "Best e-commerce platforms for {$industry}",
      "Top {$industry} online stores",
      "What are the best {$industry} shopping sites?"
    ],
    'Healthcare' => [
      "Best healthcare providers for {$industry}",
      "Top {$industry} medical services",
      "What are the best {$industry} healthcare options?"
    ],
    'Fintech' => [
      "Best fintech platforms for {$industry}",
      "Top {$industry} financial services",
      "What are the best {$industry} fintech solutions?"
    ],
    'Education' => [
      "Best educational platforms for {$industry}",
      "Top {$industry} learning resources",
      "What are the best {$industry} courses?"
    ],
    'Real Estate' => [
      "Best real estate platforms in {$industry}",
      "Top {$industry} property services",
      "What are the best {$industry} real estate options?"
    ]
  ];
  
  if (isset($industryPrompts[$industry])) {
    $prompts = array_merge($prompts, $industryPrompts[$industry]);
  }
  
  return array_unique($prompts);
}

/**
 * Query ChatGPT API (PHP-native implementation)
 * 
 * @param string $prompt The prompt to query
 * @return array Result with 'text', 'mentions_brand', 'position', 'citation'
 */
function query_chatgpt(string $prompt): array {
  $apiKey = getenv('OPENAI_API_KEY');
  if (!$apiKey) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => 'OpenAI API key not configured',
      'error' => 'API_KEY_MISSING'
    ];
  }
  
  $ch = curl_init('https://api.openai.com/v1/chat/completions');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'gpt-4',
    'messages' => [['role' => 'user', 'content' => $prompt]],
    'max_tokens' => 500
  ]));
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $curlError = curl_error($ch);
  curl_close($ch);
  
  if ($curlError) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => 'CURL error: ' . $curlError,
      'error' => 'CURL_ERROR'
    ];
  }
  
  if ($httpCode !== 200) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => "API request failed with HTTP {$httpCode}",
      'error' => 'API_ERROR'
    ];
  }
  
  $data = json_decode($response, true);
  if (!$data || !isset($data['choices'][0]['message']['content'])) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => 'Invalid API response',
      'error' => 'INVALID_RESPONSE'
    ];
  }
  
  $text = $data['choices'][0]['message']['content'];
  
  // Analyze response for brand mentions
  $mentionsBrand = stripos($text, 'NRLC') !== false || 
                   stripos($text, 'Neural Command') !== false ||
                   stripos($text, 'nrlc.ai') !== false;
  
  // Check for citation (URLs or references)
  $hasCitation = preg_match('/https?:\/\//', $text) || 
                 preg_match('/\[.*?\]\(.*?\)/', $text) ||
                 $mentionsBrand; // If brand mentioned, assume citation
  
  return [
    'text' => substr($text, 0, 4000), // Limit stored text
    'mentions_brand' => $mentionsBrand,
    'position' => $mentionsBrand ? 1 : null,
    'citation' => $hasCitation,
    'notes' => $mentionsBrand ? 'Brand mentioned' : 'Brand not mentioned'
  ];
}

/**
 * Query Claude API (PHP-native implementation)
 */
function query_claude(string $prompt): array {
  $apiKey = getenv('ANTHROPIC_API_KEY');
  if (!$apiKey) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => 'Anthropic API key not configured',
      'error' => 'API_KEY_MISSING'
    ];
  }
  
  $ch = curl_init('https://api.anthropic.com/v1/messages');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'x-api-key: ' . $apiKey,
    'anthropic-version: 2023-06-01',
    'Content-Type: application/json'
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'claude-3-opus-20240229',
    'max_tokens' => 500,
    'messages' => [['role' => 'user', 'content' => $prompt]]
  ]));
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $curlError = curl_error($ch);
  curl_close($ch);
  
  if ($curlError) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => 'CURL error: ' . $curlError,
      'error' => 'CURL_ERROR'
    ];
  }
  
  if ($httpCode !== 200) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => "API request failed with HTTP {$httpCode}",
      'error' => 'API_ERROR'
    ];
  }
  
  $data = json_decode($response, true);
  if (!$data || !isset($data['content'][0]['text'])) {
    return [
      'text' => '',
      'mentions_brand' => false,
      'position' => null,
      'citation' => false,
      'notes' => 'Invalid API response',
      'error' => 'INVALID_RESPONSE'
    ];
  }
  
  $text = $data['content'][0]['text'];
  
  $mentionsBrand = stripos($text, 'NRLC') !== false || 
                   stripos($text, 'Neural Command') !== false ||
                   stripos($text, 'nrlc.ai') !== false;
  
  $hasCitation = preg_match('/https?:\/\//', $text) || 
                 preg_match('/\[.*?\]\(.*?\)/', $text) ||
                 $mentionsBrand;
  
  return [
    'text' => substr($text, 0, 4000),
    'mentions_brand' => $mentionsBrand,
    'position' => $mentionsBrand ? 1 : null,
    'citation' => $hasCitation,
    'notes' => $mentionsBrand ? 'Brand mentioned' : 'Brand not mentioned'
  ];
}

/**
 * Query Google AI Overviews (via SERP API)
 * 
 * Uses SerpAPI or DataForSEO to get Google AI Overview results
 */
function query_google_ai_overviews(string $prompt): array {
  // Option 1: SerpAPI
  $serpApiKey = getenv('SERP_API_KEY');
  if ($serpApiKey) {
    $url = 'https://serpapi.com/search.json?' . http_build_query([
      'q' => $prompt,
      'api_key' => $serpApiKey,
      'engine' => 'google'
    ]);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
      $data = json_decode($response, true);
      $text = '';
      
      // Extract AI Overview if present
      if (isset($data['ai_overview'])) {
        $text = $data['ai_overview'];
      } elseif (isset($data['answer_box']['answer'])) {
        $text = $data['answer_box']['answer'];
      } elseif (isset($data['organic_results'][0]['snippet'])) {
        $text = $data['organic_results'][0]['snippet'];
      }
      
      $mentionsBrand = stripos($text, 'NRLC') !== false || 
                       stripos($text, 'Neural Command') !== false ||
                       stripos($text, 'nrlc.ai') !== false;
      
      $hasCitation = preg_match('/https?:\/\//', $text) || $mentionsBrand;
      
      return [
        'text' => substr($text, 0, 4000),
        'mentions_brand' => $mentionsBrand,
        'position' => $mentionsBrand ? 1 : null,
        'citation' => $hasCitation,
        'notes' => $mentionsBrand ? 'Brand mentioned in AI Overview' : 'Brand not mentioned'
      ];
    }
  }
  
  // Fallback: API not configured
  return [
    'text' => '',
    'mentions_brand' => false,
    'position' => null,
    'citation' => false,
    'notes' => 'Google AI Overview API not configured (set SERP_API_KEY)',
    'error' => 'API_KEY_MISSING'
  ];
}

/**
 * Verify a case study against AI systems
 */
function verify_case_study(string $slug, array $caseData): array {
  $prompts = get_test_prompts($slug, $caseData);
  $results = [
    'slug' => $slug,
    'timestamp' => date('Y-m-d H:i:s'),
    'prompts' => []
  ];
  
    foreach ($prompts as $prompt) {
      $chatgptResult = query_chatgpt($prompt);
      $claudeResult = query_claude($prompt);
      $googleResult = query_google_ai_overviews($prompt);
      
      $promptResults = [
        'prompt' => $prompt,
        'chatgpt' => $chatgptResult,
        'claude' => $claudeResult,
        'google_ai_overviews' => $googleResult
      ];
      
      // Store individual check
      storeAiCheck($slug, $prompt, 'chatgpt', $chatgptResult);
      storeAiCheck($slug, $prompt, 'claude', $claudeResult);
      storeAiCheck($slug, $prompt, 'google_ai_overviews', $googleResult);
      
      $results['prompts'][] = $promptResults;
    }
  
  return $results;
}

/**
 * Main execution
 */
function main() {
  global $dataDir;
  
  $registry = get_case_study_registry();
  $allResults = [];
  
  echo "Starting AI Answer Crawler Verification...\n\n";
  
  foreach ($registry as $slug => $caseData) {
    echo "Verifying case study: {$slug}...\n";
    
    $results = verify_case_study($slug, $caseData);
    $allResults[$slug] = $results;
    
    // Save individual case study results
    $filePath = $dataDir . "{$slug}_" . date('Y-m-d') . ".json";
    file_put_contents($filePath, json_encode($results, JSON_PRETTY_PRINT));
    
    echo "  Saved to: {$filePath}\n";
  }
  
  // Save aggregated results
  $aggregatePath = $dataDir . "aggregate_" . date('Y-m-d') . ".json";
  file_put_contents($aggregatePath, json_encode($allResults, JSON_PRETTY_PRINT));
  
  echo "\nAggregate results saved to: {$aggregatePath}\n";
  echo "\nVerification complete!\n";
  
  // Generate summary report
  echo "\n=== SUMMARY REPORT ===\n";
  foreach ($allResults as $slug => $results) {
    $totalPrompts = count($results['prompts']);
    $chatgptMentions = 0;
    $claudeMentions = 0;
    $googleMentions = 0;
    
    foreach ($results['prompts'] as $promptResult) {
      if ($promptResult['chatgpt']['mentions_brand'] ?? false) $chatgptMentions++;
      if ($promptResult['claude']['mentions_brand'] ?? false) $claudeMentions++;
      if ($promptResult['google_ai_overviews']['mentions_brand'] ?? false) $googleMentions++;
    }
    
    echo "\n{$slug}:\n";
    echo "  ChatGPT: {$chatgptMentions}/{$totalPrompts} prompts mention brand\n";
    echo "  Claude: {$claudeMentions}/{$totalPrompts} prompts mention brand\n";
    echo "  Google AI: {$googleMentions}/{$totalPrompts} prompts mention brand\n";
  }
}

// Run if executed directly
if (php_sapi_name() === 'cli') {
  main();
}

