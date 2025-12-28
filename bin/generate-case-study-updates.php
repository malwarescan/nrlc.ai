#!/usr/bin/env php
<?php
/**
 * NRLC AI Case Study System - Deltas → Auto-Update Case Studies
 * 
 * Pulls latest ai_checks, compares to previous run, detects meaningful deltas,
 * and patches machine-owned blocks in case study markdown files.
 * 
 * Usage: php bin/generate-case-study-updates.php
 */

require_once __DIR__ . '/../lib/case_study_registry.php';

$dataDir = __DIR__ . '/../data/';
$caseStudiesDir = $dataDir . 'case-studies/';
$aiVerificationDir = $dataDir . 'ai_verification/';
$previousRunFile = $dataDir . 'ai_verification_previous.json';

// Load previous run data
$previousData = [];
if (file_exists($previousRunFile)) {
  $previousData = json_decode(file_get_contents($previousRunFile), true) ?? [];
}

// Load current verification data
$currentData = [];
$verificationFiles = glob($aiVerificationDir . '*_aggregate_*.json');
if (empty($verificationFiles)) {
  // Try date-based pattern
  $verificationFiles = glob($aiVerificationDir . 'aggregate_*.json');
}

if (!empty($verificationFiles)) {
  // Get most recent
  usort($verificationFiles, function($a, $b) {
    return filemtime($b) - filemtime($a);
  });
  $latestFile = $verificationFiles[0];
  $currentData = json_decode(file_get_contents($latestFile), true) ?? [];
}

// Calculate deltas
$deltas = [];
$registry = get_case_study_registry();

foreach ($registry as $slug => $caseData) {
  $previous = $previousData[$slug] ?? null;
  $current = $currentData[$slug] ?? null;
  
  if (!$current) {
    continue; // No current data for this case study
  }
  
  $delta = calculate_delta($previous, $current);
  if ($delta['has_changes']) {
    $deltas[$slug] = $delta;
  }
}

// Update case study markdown files with verification blocks
foreach ($deltas as $slug => $delta) {
  // Sanitize slug to prevent path traversal
  $safeSlug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));
  $mdFile = $caseStudiesDir . $safeSlug . '.md';
  
  if (!file_exists($mdFile)) {
    echo "Warning: Markdown file not found: {$mdFile}\n";
    continue;
  }
  
  $content = file_get_contents($mdFile);
  
  // Generate verification block
  $verificationBlock = generate_verification_block($slug, $delta, $currentData[$slug] ?? []);
  
  // Replace or insert verification block
  $pattern = '/<!-- NRLC_AI_VERIFICATION_BLOCK:START -->.*?<!-- NRLC_AI_VERIFICATION_BLOCK:END -->/s';
  
  if (preg_match($pattern, $content)) {
    // Replace existing block
    $content = preg_replace($pattern, $verificationBlock, $content);
  } else {
    // Insert at end
    $content .= "\n\n" . $verificationBlock . "\n";
  }
  
  // Validate block is present and unmodified
  if (!preg_match($pattern, $content)) {
    fwrite(STDERR, "Error: Failed to insert verification block in {$mdFile}\n");
    exit(1); // Fail hard if machine block missing
  }
  
  // Validate JSON-LD if it exists
  $jsonldFile = $caseStudiesDir . $safeSlug . '.jsonld';
  if (file_exists($jsonldFile)) {
    $validationCmd = __DIR__ . '/validate-case-study.php';
    $output = [];
    $returnVar = 0;
    exec("php {$validationCmd} {$jsonldFile} 2>&1", $output, $returnVar);
    if ($returnVar !== 0) {
      fwrite(STDERR, "Error: JSON-LD validation failed for {$slug}\n");
      fwrite(STDERR, implode("\n", $output) . "\n");
      exit(1); // Fail hard if JSON-LD invalid
    }
  }
  
  file_put_contents($mdFile, $content);
  echo "Updated: {$mdFile}\n";
}

// Save current data as previous for next run
if (!empty($currentData)) {
  file_put_contents($previousRunFile, json_encode($currentData, JSON_PRETTY_PRINT));
}

echo "Case study updates complete.\n";

/**
 * Calculate delta between previous and current verification data
 */
function calculate_delta(?array $previous, array $current): array {
  if (!$previous) {
    return [
      'has_changes' => true,
      'type' => 'initial',
      'summary' => 'Initial verification data'
    ];
  }
  
  $changes = [];
  
  // Compare mention rates
  $prevMentions = count_mentions($previous);
  $currMentions = count_mentions($current);
  
  if ($currMentions['total'] > $prevMentions['total']) {
    $changes[] = "Mention rate increased: {$prevMentions['total']} → {$currMentions['total']}";
  } elseif ($currMentions['total'] < $prevMentions['total']) {
    $changes[] = "Mention rate decreased: {$prevMentions['total']} → {$currMentions['total']} (REGRESSION)";
  }
  
  // Compare citation rates
  $prevCitations = count_citations($previous);
  $currCitations = count_citations($current);
  
  if ($currCitations['total'] > $prevCitations['total']) {
    $changes[] = "Citation rate increased: {$prevCitations['total']} → {$currCitations['total']}";
  } elseif ($currCitations['total'] < $prevCitations['total']) {
    $changes[] = "Citation rate decreased: {$prevCitations['total']} → {$currCitations['total']} (REGRESSION)";
  }
  
  return [
    'has_changes' => !empty($changes),
    'type' => !empty($changes) ? 'update' : 'no_change',
    'summary' => implode('; ', $changes),
    'changes' => $changes
  ];
}

function count_mentions(array $data): array {
  $counts = ['chatgpt' => 0, 'claude' => 0, 'google_ai_overviews' => 0, 'total' => 0];
  
  if (!isset($data['prompts'])) {
    return $counts;
  }
  
  foreach ($data['prompts'] as $prompt) {
    if ($prompt['chatgpt']['mentions_brand'] ?? false) {
      $counts['chatgpt']++;
      $counts['total']++;
    }
    if ($prompt['claude']['mentions_brand'] ?? false) {
      $counts['claude']++;
      if (!$prompt['chatgpt']['mentions_brand'] ?? false) {
        $counts['total']++;
      }
    }
    if ($prompt['google_ai_overviews']['mentions_brand'] ?? false) {
      $counts['google_ai_overviews']++;
      if (!($prompt['chatgpt']['mentions_brand'] ?? false) && !($prompt['claude']['mentions_brand'] ?? false)) {
        $counts['total']++;
      }
    }
  }
  
  return $counts;
}

function count_citations(array $data): array {
  $counts = ['chatgpt' => 0, 'claude' => 0, 'google_ai_overviews' => 0, 'total' => 0];
  
  if (!isset($data['prompts'])) {
    return $counts;
  }
  
  foreach ($data['prompts'] as $prompt) {
    if ($prompt['chatgpt']['citation'] ?? false) {
      $counts['chatgpt']++;
      $counts['total']++;
    }
    if ($prompt['claude']['citation'] ?? false) {
      $counts['claude']++;
      if (!$prompt['chatgpt']['citation'] ?? false) {
        $counts['total']++;
      }
    }
    if ($prompt['google_ai_overviews']['citation'] ?? false) {
      $counts['google_ai_overviews']++;
      if (!($prompt['chatgpt']['citation'] ?? false) && !($prompt['claude']['citation'] ?? false)) {
        $counts['total']++;
      }
    }
  }
  
  return $counts;
}

function generate_verification_block(string $slug, array $delta, array $currentData): string {
  $windowStart = date('Y-m-d', strtotime('-7 days'));
  $windowEnd = date('Y-m-d');
  
  $mentions = count_mentions($currentData);
  $citations = count_citations($currentData);
  $totalPrompts = count($currentData['prompts'] ?? []);
  
  $block = "<!-- NRLC_AI_VERIFICATION_BLOCK:START -->\n";
  $block .= "AI Verification Log\n";
  $block .= "- Window: {$windowStart} to {$windowEnd}\n";
  $block .= "- Models: ChatGPT, Claude, Google AI Overviews\n";
  $block .= "- Prompt Cluster: " . ($currentData['prompt_cluster'] ?? 'unknown') . "\n";
  $block .= "- Signals:\n";
  $block .= "  - Mentions: {$mentions['total']}/{$totalPrompts} prompts\n";
  $block .= "  - Citations: {$citations['total']}/{$totalPrompts} prompts\n";
  $block .= "  - Regressions: " . (strpos($delta['summary'], 'REGRESSION') !== false ? '1' : '0') . "\n";
  $block .= "  - Wins: " . (strpos($delta['summary'], 'increased') !== false ? '1' : '0') . "\n";
  
  if (!empty($delta['summary'])) {
    $block .= "- Notable change: " . str_replace('REGRESSION', '', $delta['summary']) . "\n";
  }
  
  $block .= "<!-- NRLC_AI_VERIFICATION_BLOCK:END -->";
  
  return $block;
}

