<?php
/**
 * NRLC AI Case Study System - "Verified by AI" Badge SVG Endpoint
 * 
 * TTL-bound, score-based badge system.
 * States: VERIFIED / DEGRADED / UNKNOWN
 * Never permanent.
 * 
 * Usage: /api/badge.php?client={id}&scope=client&ref={case-study-slug}
 */

header('Content-Type: image/svg+xml');
header('Cache-Control: public, max-age=300'); // 5 minute cache

$client = $_GET['client'] ?? null;
$scope = $_GET['scope'] ?? 'client';
$ref = $_GET['ref'] ?? null; // Case study slug or prompt cluster

require_once __DIR__ . '/../lib/case_study_registry.php';

// Fetch latest badge data
$badge = fetch_latest_badge($client, $scope, $ref);

// Render badge SVG
echo render_badge_svg($badge);

/**
 * Fetch latest badge data
 * 
 * In production, this would query a database.
 * For now, we'll use file-based storage.
 */
function fetch_latest_badge(?string $client, string $scope, ?string $ref): array {
  $dataDir = __DIR__ . '/../data/ai_verification/';
  
  // Default badge
  $badge = [
    'status' => 'UNKNOWN',
    'score' => 0,
    'ttl' => time() + 300, // 5 minutes
    'message' => 'Verification pending'
  ];
  
  if ($ref) {
    // Sanitize ref to prevent path traversal
    $safeRef = preg_replace('/[^a-z0-9-]/', '', strtolower($ref));
    
    // Load verification data for this case study
    $verificationFiles = glob($dataDir . "{$safeRef}_aggregate_*.json");
    if (empty($verificationFiles)) {
      $verificationFiles = glob($dataDir . "aggregate_*.json");
    }
    
    if (!empty($verificationFiles)) {
      usort($verificationFiles, function($a, $b) {
        return filemtime($b) - filemtime($a);
      });
      
      $latestFile = $verificationFiles[0];
      $data = json_decode(file_get_contents($latestFile), true) ?? [];
      
      if (isset($data[$safeRef])) {
        $caseData = $data[$safeRef];
        $score = calculate_badge_score($caseData);
        $status = get_badge_status($score);
        
        $badge = [
          'status' => $status,
          'score' => $score,
          'ttl' => time() + 300,
          'message' => get_badge_message($status, $score),
          'last_check' => $caseData['timestamp'] ?? date('Y-m-d H:i:s')
        ];
      }
    }
  }
  
  return $badge;
}

/**
 * Calculate badge score (0-100)
 */
function calculate_badge_score(array $caseData): int {
  if (!isset($caseData['prompts']) || empty($caseData['prompts'])) {
    return 0;
  }
  
  $totalPrompts = count($caseData['prompts']);
  $mentions = 0;
  $citations = 0;
  
  foreach ($caseData['prompts'] as $prompt) {
    if ($prompt['chatgpt']['mentions_brand'] ?? false) $mentions++;
    if ($prompt['claude']['mentions_brand'] ?? false) $mentions++;
    if ($prompt['google_ai_overviews']['mentions_brand'] ?? false) $mentions++;
    
    if ($prompt['chatgpt']['citation'] ?? false) $citations++;
    if ($prompt['claude']['citation'] ?? false) $citations++;
    if ($prompt['google_ai_overviews']['citation'] ?? false) $citations++;
  }
  
  $maxPossible = $totalPrompts * 3; // 3 models
  $mentionScore = ($mentions / $maxPossible) * 50; // 50 points for mentions
  $citationScore = ($citations / $maxPossible) * 50; // 50 points for citations
  
  return (int)round($mentionScore + $citationScore);
}

/**
 * Get badge status from score
 */
function get_badge_status(int $score): string {
  if ($score >= 70) {
    return 'VERIFIED';
  } elseif ($score >= 40) {
    return 'DEGRADED';
  } else {
    return 'UNKNOWN';
  }
}

/**
 * Get badge message
 */
function get_badge_message(string $status, int $score): string {
  switch ($status) {
    case 'VERIFIED':
      return "Verified ({$score}% coverage)";
    case 'DEGRADED':
      return "Degraded ({$score}% coverage)";
    default:
      return "Unknown ({$score}% coverage)";
  }
}

/**
 * Render badge SVG
 */
function render_badge_svg(array $badge): string {
  $status = $badge['status'];
  $message = $badge['message'];
  
  // Colors based on status
  $colors = [
    'VERIFIED' => ['bg' => '#10b981', 'text' => '#ffffff'],
    'DEGRADED' => ['bg' => '#f59e0b', 'text' => '#ffffff'],
    'UNKNOWN' => ['bg' => '#6b7280', 'text' => '#ffffff']
  ];
  
  $color = $colors[$status] ?? $colors['UNKNOWN'];
  
  // Calculate text width (approximate)
  $textWidth = strlen($message) * 6 + 20;
  $totalWidth = $textWidth + 60; // Icon + padding
  
  $svg = '<?xml version="1.0" encoding="UTF-8"?>';
  $svg .= '<svg xmlns="http://www.w3.org/2000/svg" width="' . $totalWidth . '" height="20">';
  $svg .= '<linearGradient id="bg" x2="0" y2="100%">';
  $svg .= '<stop offset="0" stop-color="' . $color['bg'] . '" stop-opacity=".1"/>';
  $svg .= '<stop offset="1" stop-color="' . $color['bg'] . '" stop-opacity=".1"/>';
  $svg .= '</linearGradient>';
  $svg .= '<rect rx="3" width="' . $totalWidth . '" height="20" fill="' . $color['bg'] . '"/>';
  $svg .= '<rect rx="3" x="' . ($totalWidth - $textWidth) . '" width="' . $textWidth . '" height="20" fill="' . $color['bg'] . '"/>';
  $svg .= '<path fill="' . $color['text'] . '" d="M3 3h14v14H3z"/>';
  $svg .= '<text x="' . (($totalWidth - $textWidth) + 10) . '" y="14" fill="' . $color['text'] . '" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11">' . htmlspecialchars($message) . '</text>';
  $svg .= '</svg>';
  
  return $svg;
}

