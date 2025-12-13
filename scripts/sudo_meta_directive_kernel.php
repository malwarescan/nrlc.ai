<?php
declare(strict_types=1);

/**
 * SUDO META DIRECTIVE KERNEL — NRLC.ai SEO Structure Audit
 * 
 * Executes comprehensive SEO audit and generates fix requirements
 */

require_once __DIR__.'/../lib/csv.php';

// STEP 1: Ingest + Normalize URLs
function normalize_url(string $url): string {
  // Remove protocol
  $url = preg_replace('#^https?://#i', '', $url);
  // Lowercase host
  $url = preg_replace_callback('#^([^/]+)#', fn($m) => strtolower($m[1]), $url);
  // Remove trailing slash
  $url = rtrim($url, '/');
  return $url;
}

function detect_duplicates(array $pages): array {
  $normalized = [];
  $duplicates = [];
  
  foreach ($pages as $page) {
    // CSV headers are normalized to snake_case
    $url = $page['top_pages'] ?? $page['Top pages'] ?? '';
    if (!$url) continue;
    
    $norm = normalize_url($url);
    
    if (!isset($normalized[$norm])) {
      $normalized[$norm] = [];
    }
    $normalized[$norm][] = $url;
  }
  
  // Find duplicates
  foreach ($normalized as $norm => $variants) {
    if (count($variants) > 1) {
      // Pick canonical (prefer https, then en-us, then shortest)
      $canonical = null;
      foreach ($variants as $v) {
        if (strpos($v, 'https://') === 0) {
          if (!$canonical || strpos($v, '/en-us/') !== false) {
            $canonical = $v;
          }
        }
      }
      if (!$canonical) {
        // Prefer https over http
        foreach ($variants as $v) {
          if (strpos($v, 'https://') === 0) {
            $canonical = $v;
            break;
          }
        }
      }
      if (!$canonical) {
        $canonical = $variants[0];
      }
      
      $duplicates[$canonical] = array_filter($variants, fn($v) => $v !== $canonical);
    }
  }
  
  return $duplicates;
}

// STEP 3: Intent Clustering
function cluster_intent(string $query): string {
  $q = strtolower($query);
  
  // Job intent
  if (preg_match('/\b(jobs?|hiring|career|role|position|vacancy|apply|recruiter)\b/i', $q)) {
    return 'job';
  }
  
  // Brand intent
  if (preg_match('/\b(neural\s+command|nrlc)\b/i', $q)) {
    return 'brand';
  }
  
  // Service intent
  if (preg_match('/\b(seo|schema|audit|optimization|ai\s+seo|chatgpt|local\s+seo|link\s+building|conversion|technical\s+seo)\b/i', $q)) {
    return 'service';
  }
  
  // Research/learn intent
  if (preg_match('/\b(guide|how\s+to|learn|research|insight|article|framework|checklist)\b/i', $q)) {
    return 'informational';
  }
  
  return 'general';
}

// Load data - use csv_read directly since files are in serp_intel/
$pages = csv_read(__DIR__.'/../serp_intel/Pages.csv');
$queries = csv_read(__DIR__.'/../serp_intel/Queries.csv');
$countries = csv_read(__DIR__.'/../serp_intel/Countries.csv');

// STEP 1: Duplicate Detection
$duplicates = detect_duplicates($pages);

// STEP 3: Intent Clustering
$intentClusters = [];
foreach ($queries as $row) {
  $query = $row['top_queries'] ?? $row['Top queries'] ?? '';
  if (!$query) continue;
  $intent = cluster_intent($query);
  if (!isset($intentClusters[$intent])) {
    $intentClusters[$intent] = [];
  }
  $impressions = (int)(str_replace(',', '', $row['impressions'] ?? $row['Impressions'] ?? '0'));
  $position = (float)(str_replace(',', '', $row['position'] ?? $row['Position'] ?? '0'));
  $ctr = (float)(str_replace(['%', ','], '', $row['ctr'] ?? $row['CTR'] ?? '0'));
  $intentClusters[$intent][] = [
    'query' => $query,
    'impressions' => $impressions,
    'position' => $position,
    'ctr' => $ctr
  ];
}

// Sort by impressions
foreach ($intentClusters as &$cluster) {
  usort($cluster, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
}

// STEP 5: CTR + Position Triage
$priority1 = []; // position 1-8, low CTR
$priority2 = []; // high impressions, CTR ~0, position 10-40
$priority3 = []; // high impressions, position 40+

foreach ($pages as $page) {
  $url = $page['top_pages'] ?? $page['Top pages'] ?? '';
  if (!$url) continue;
  $clicks = (int)(str_replace(',', '', $page['clicks'] ?? $page['Clicks'] ?? '0'));
  $impressions = (int)(str_replace(',', '', $page['impressions'] ?? $page['Impressions'] ?? '0'));
  $ctr = (float)(str_replace(['%', ','], '', $page['ctr'] ?? $page['CTR'] ?? '0'));
  $position = (float)(str_replace(',', '', $page['position'] ?? $page['Position'] ?? '0'));
  
  if ($position >= 1 && $position <= 8 && $ctr < 5.0) {
    $priority1[] = ['url' => $url, 'position' => $position, 'ctr' => $ctr, 'impressions' => $impressions];
  } elseif ($impressions >= 10 && $ctr < 1.0 && $position >= 10 && $position <= 40) {
    $priority2[] = ['url' => $url, 'position' => $position, 'ctr' => $ctr, 'impressions' => $impressions];
  } elseif ($impressions >= 10 && $position > 40) {
    $priority3[] = ['url' => $url, 'position' => $position, 'ctr' => $ctr, 'impressions' => $impressions];
  }
}

// Sort priorities
usort($priority1, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
usort($priority2, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
usort($priority3, fn($a, $b) => $b['impressions'] <=> $a['impressions']);

// Output results
echo "=== SUDO META DIRECTIVE KERNEL AUDIT RESULTS ===\n\n";

echo "STEP 1: DUPLICATE MAP + CANONICAL TARGETING\n";
echo str_repeat("=", 80) . "\n";
foreach ($duplicates as $canonical => $variants) {
  echo "Canonical: $canonical\n";
  echo "  Duplicates: " . implode(", ", $variants) . "\n\n";
}

echo "\nSTEP 3: INTENT CLUSTERS\n";
echo str_repeat("=", 80) . "\n";
foreach ($intentClusters as $intent => $queries) {
  echo "\n$intent Intent (Top 10):\n";
  foreach (array_slice($queries, 0, 10) as $q) {
    echo "  - {$q['query']} (Impressions: {$q['impressions']}, Position: {$q['position']})\n";
  }
}

echo "\n\nSTEP 5: PRIORITY FIX QUEUE\n";
echo str_repeat("=", 80) . "\n";
echo "\nPriority 1 (Position 1-8, Low CTR):\n";
foreach (array_slice($priority1, 0, 10) as $p) {
  echo "  - {$p['url']} (Pos: {$p['position']}, CTR: {$p['ctr']}%, Imp: {$p['impressions']})\n";
}

echo "\nPriority 2 (High Impressions, Low CTR, Position 10-40):\n";
foreach (array_slice($priority2, 0, 10) as $p) {
  echo "  - {$p['url']} (Pos: {$p['position']}, CTR: {$p['ctr']}%, Imp: {$p['impressions']})\n";
}

echo "\nPriority 3 (High Impressions, Position 40+):\n";
foreach (array_slice($priority3, 0, 10) as $p) {
  echo "  - {$p['url']} (Pos: {$p['position']}, CTR: {$p['ctr']}%, Imp: {$p['impressions']})\n";
}

// Save to file
file_put_contents(__DIR__.'/../sudo_meta_audit_results.json', json_encode([
  'duplicates' => $duplicates,
  'intentClusters' => $intentClusters,
  'priority1' => array_slice($priority1, 0, 20),
  'priority2' => array_slice($priority2, 0, 20),
  'priority3' => array_slice($priority3, 0, 20)
], JSON_PRETTY_PRINT));

echo "\n\nAudit complete! Results saved to sudo_meta_audit_results.json\n";

