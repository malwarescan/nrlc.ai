<?php
declare(strict_types=1);

/**
 * SUDO EVIDENCE PACKAGE — Deterministic Audit with Concrete Proof
 * 
 * Generates all required evidence tables and proofs from CSV data and codebase
 */

require_once __DIR__.'/../lib/csv.php';

// Load data
$pages = csv_read(__DIR__.'/../serp_intel/Pages.csv');
$queries = csv_read(__DIR__.'/../serp_intel/Queries.csv');
$countries = csv_read(__DIR__.'/../serp_intel/Countries.csv');

// Normalize URL for comparison
function normalize_url_for_dup(string $url): string {
  $url = preg_replace('#^https?://#i', '', $url);
  $url = preg_replace_callback('#^([^/]+)#', fn($m) => strtolower($m[1]), $url);
  $url = rtrim($url, '/');
  // Remove query params for comparison
  $url = preg_replace('#\?.*$#', '', $url);
  return $url;
}

// Extract URL components
function analyze_url_duplicate(string $url1, string $url2): string {
  $norm1 = normalize_url_for_dup($url1);
  $norm2 = normalize_url_for_dup($url2);
  
  if ($norm1 === $norm2) {
    // Same normalized URL - check what differs
    if (preg_match('#^http://#i', $url1) && preg_match('#^https://#i', $url2)) {
      return 'http/https';
    }
    if (preg_match('#^https://#i', $url1) && preg_match('#^http://#i', $url2)) {
      return 'http/https';
    }
    // Check trailing slash
    if (substr($url1, -1) === '/' && substr($url2, -1) !== '/') {
      return 'trailing_slash';
    }
    if (substr($url1, -1) !== '/' && substr($url2, -1) === '/') {
      return 'trailing_slash';
    }
    // Check query params
    if (strpos($url1, '?') !== false || strpos($url2, '?') !== false) {
      return 'query_params';
    }
    return 'unknown';
  }
  
  // Check locale vs non-locale
  $hasLocale1 = preg_match('#^https?://[^/]+/([a-z]{2})-([a-z]{2})/#i', $url1);
  $hasLocale2 = preg_match('#^https?://[^/]+/([a-z]{2})-([a-z]{2})/#i', $url2);
  if ($hasLocale1 && !$hasLocale2) {
    return 'locale/non-locale';
  }
  if (!$hasLocale1 && $hasLocale2) {
    return 'locale/non-locale';
  }
  
  return 'different_path';
}

// A) DUPLICATE MAP
echo "=" . str_repeat("=", 79) . "\n";
echo "A) DUPLICATE MAP (FROM Pages.csv)\n";
echo "=" . str_repeat("=", 79) . "\n\n";

$urlGroups = [];
foreach ($pages as $row) {
  $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
  if (!$url) continue;
  
  $norm = normalize_url_for_dup($url);
  if (!isset($urlGroups[$norm])) {
    $urlGroups[$norm] = [];
  }
  $urlGroups[$norm][] = [
    'url' => $url,
    'clicks' => (int)(str_replace(',', '', $row['clicks'] ?? $row['Clicks'] ?? '0')),
    'impressions' => (int)(str_replace(',', '', $row['impressions'] ?? $row['Impressions'] ?? '0')),
    'ctr' => (float)(str_replace(['%', ','], '', $row['ctr'] ?? $row['CTR'] ?? '0')),
    'position' => (float)(str_replace(',', '', $row['position'] ?? $row['Position'] ?? '0'))
  ];
}

$duplicates = [];
foreach ($urlGroups as $norm => $variants) {
  if (count($variants) > 1) {
    // Pick canonical (prefer https, then en-us, then highest impressions)
    $canonical = null;
    $canonicalScore = -1;
    
    foreach ($variants as $v) {
      $score = 0;
      if (strpos($v['url'], 'https://') === 0) $score += 1000;
      if (preg_match('#/(en-us|en-gb)/#i', $v['url'])) $score += 100;
      $score += $v['impressions'];
      
      if ($score > $canonicalScore) {
        $canonicalScore = $score;
        $canonical = $v['url'];
      }
    }
    
    if (!$canonical) {
      $canonical = $variants[0]['url'];
    }
    
    foreach ($variants as $v) {
      if ($v['url'] !== $canonical) {
        $reason = analyze_url_duplicate($canonical, $v['url']);
        $duplicates[] = [
          'canonical' => $canonical,
          'duplicate' => $v['url'],
          'reason' => $reason,
          'dup_impressions' => $v['impressions'],
          'dup_clicks' => $v['clicks'],
          'canon_impressions' => array_sum(array_column(array_filter($variants, fn($x) => $x['url'] === $canonical), 'impressions')),
          'canon_clicks' => array_sum(array_column(array_filter($variants, fn($x) => $x['url'] === $canonical), 'clicks'))
        ];
      }
    }
  }
}

// Sort by total impressions
usort($duplicates, fn($a, $b) => ($b['dup_impressions'] + $b['canon_impressions']) <=> ($a['dup_impressions'] + $a['canon_impressions']));

echo "canonical_target_url | duplicate_variant_url | duplicate_reason | impressions (canon) | impressions (dup) | clicks (canon) | clicks (dup)\n";
echo str_repeat("-", 150) . "\n";
foreach ($duplicates as $dup) {
  printf("%-50s | %-50s | %-15s | %-18d | %-18d | %-13d | %-13d\n",
    substr($dup['canonical'], 0, 50),
    substr($dup['duplicate'], 0, 50),
    $dup['reason'],
    $dup['canon_impressions'],
    $dup['dup_impressions'],
    $dup['canon_clicks'],
    $dup['dup_clicks']
  );
}
echo "\nTotal duplicates found: " . count($duplicates) . "\n\n";

// B) PRIORITY CTR FIX QUEUE
echo "=" . str_repeat("=", 79) . "\n";
echo "B) PRIORITY CTR FIX QUEUE (FROM Pages.csv)\n";
echo "=" . str_repeat("=", 79) . "\n\n";

$priority1 = [];
$priority2 = [];
$priority3 = [];

foreach ($pages as $row) {
  $url = $row['top_pages'] ?? $row['Top pages'] ?? '';
  if (!$url) continue;
  
  $clicks = (int)(str_replace(',', '', $row['clicks'] ?? $row['Clicks'] ?? '0'));
  $impressions = (int)(str_replace(',', '', $row['impressions'] ?? $row['Impressions'] ?? '0'));
  $ctr = (float)(str_replace(['%', ','], '', $row['ctr'] ?? $row['CTR'] ?? '0'));
  $position = (float)(str_replace(',', '', $row['position'] ?? $row['Position'] ?? '0'));
  
  // Determine issue guess
  $issue = 'unknown';
  if ($position <= 8 && $ctr == 0 && $impressions >= 30) {
    $issue = 'snippet/meta mismatch';
    $priority1[] = [
      'url' => $url,
      'clicks' => $clicks,
      'impressions' => $impressions,
      'ctr' => $ctr,
      'position' => $position,
      'issue' => $issue
    ];
  } elseif ($position <= 12 && $ctr < 0.5 && $impressions >= 100) {
    $issue = 'intent mismatch';
    $priority2[] = [
      'url' => $url,
      'clicks' => $clicks,
      'impressions' => $impressions,
      'ctr' => $ctr,
      'position' => $position,
      'issue' => $issue
    ];
  } elseif ($impressions >= 500 && $ctr < 0.8) {
    $issue = 'rich result not eligible';
    $priority3[] = [
      'url' => $url,
      'clicks' => $clicks,
      'impressions' => $impressions,
      'ctr' => $ctr,
      'position' => $position,
      'issue' => $issue
    ];
  }
}

usort($priority1, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
usort($priority2, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
usort($priority3, fn($a, $b) => $b['impressions'] <=> $a['impressions']);

echo "PRIORITY 1: position <= 8 AND ctr == 0 AND impressions >= 30\n";
echo "url | clicks | impressions | ctr | position | issue_guess\n";
echo str_repeat("-", 120) . "\n";
foreach (array_slice($priority1, 0, 20) as $p) {
  printf("%-60s | %-6d | %-11d | %-5.2f%% | %-8.2f | %s\n",
    substr($p['url'], 0, 60),
    $p['clicks'],
    $p['impressions'],
    $p['ctr'],
    $p['position'],
    $p['issue']
  );
}
echo "\nTotal Priority 1: " . count($priority1) . "\n\n";

echo "PRIORITY 2: position <= 12 AND ctr < 0.5% AND impressions >= 100\n";
echo "url | clicks | impressions | ctr | position | issue_guess\n";
echo str_repeat("-", 120) . "\n";
foreach (array_slice($priority2, 0, 20) as $p) {
  printf("%-60s | %-6d | %-11d | %-5.2f%% | %-8.2f | %s\n",
    substr($p['url'], 0, 60),
    $p['clicks'],
    $p['impressions'],
    $p['ctr'],
    $p['position'],
    $p['issue']
  );
}
echo "\nTotal Priority 2: " . count($priority2) . "\n\n";

echo "PRIORITY 3: impressions >= 500 AND ctr < 0.8%\n";
echo "url | clicks | impressions | ctr | position | issue_guess\n";
echo str_repeat("-", 120) . "\n";
foreach (array_slice($priority3, 0, 20) as $p) {
  printf("%-60s | %-6d | %-11d | %-5.2f%% | %-8.2f | %s\n",
    substr($p['url'], 0, 60),
    $p['clicks'],
    $p['impressions'],
    $p['ctr'],
    $p['position'],
    $p['issue']
  );
}
echo "\nTotal Priority 3: " . count($priority3) . "\n\n";

// C) QUERY INTENT CLUSTERS
echo "=" . str_repeat("=", 79) . "\n";
echo "C) QUERY INTENT CLUSTERS (FROM Queries.csv)\n";
echo "=" . str_repeat("=", 79) . "\n\n";

function cluster_query(string $query): string {
  $q = strtolower($query);
  
  // Brand
  if (preg_match('/\b(neural\s+command|nrlc\.ai|nrlc)\b/i', $q)) {
    return 'Brand';
  }
  
  // Jobs
  if (preg_match('/\b(jobs?|hiring|career|role|position|vacancy|apply|recruiter|technical\s+writer|llm\s+strategist|seo\s+specialist|schema\s+engineer)\b/i', $q)) {
    return 'Careers/Jobs';
  }
  
  // Services (AI SEO, schema, structured data, AI Overviews, LLM visibility)
  if (preg_match('/\b(seo|schema|audit|optimization|ai\s+seo|chatgpt|local\s+seo|link\s+building|conversion|technical\s+seo|structured\s+data|ai\s+overview|llm\s+visibility|perplexity|copilot)\b/i', $q)) {
    return 'Services';
  }
  
  // Tools/Products
  if (preg_match('/\b(tool|software|platform|tracker|open\s+source)\b/i', $q)) {
    return 'Tools/Products';
  }
  
  // Non-English / geo terms
  if (preg_match('/\b(glásgow|glasgow|singapore|belfast|southampton|huddersfield|stockport|birmingham|montreal|edmonton|vancouver|tampa|charlotte|kansas\s+city|jacksonville|albuquerque|omaha|raleigh|san\s+antonio|oklahoma\s+city)\b/i', $q)) {
    return 'Non-English/Geo';
  }
  
  return 'Unmapped';
}

$clusters = [];
foreach ($queries as $row) {
  $query = $row['top_queries'] ?? $row['Top queries'] ?? '';
  if (!$query) continue;
  
  $cluster = cluster_query($query);
  if (!isset($clusters[$cluster])) {
    $clusters[$cluster] = [];
  }
  
  $impressions = (int)(str_replace(',', '', $row['impressions'] ?? $row['Impressions'] ?? '0'));
  $clicks = (int)(str_replace(',', '', $row['clicks'] ?? $row['Clicks'] ?? '0'));
  $position = (float)(str_replace(',', '', $row['position'] ?? $row['Position'] ?? '0'));
  
  $clusters[$cluster][] = [
    'query' => $query,
    'impressions' => $impressions,
    'clicks' => $clicks,
    'position' => $position
  ];
}

// Sort clusters by total impressions
$clusterStats = [];
foreach ($clusters as $name => $queries) {
  $totalImp = array_sum(array_column($queries, 'impressions'));
  $totalClicks = array_sum(array_column($queries, 'clicks'));
  usort($queries, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
  $clusterStats[$name] = [
    'count' => count($queries),
    'total_impressions' => $totalImp,
    'total_clicks' => $totalClicks,
    'top_queries' => array_slice($queries, 0, 10)
  ];
}

uksort($clusterStats, fn($a, $b) => $clusterStats[$b]['total_impressions'] <=> $clusterStats[$a]['total_impressions']);

echo "Cluster name | query count | total impressions | total clicks | representative queries (top 10)\n";
echo str_repeat("-", 150) . "\n";
foreach ($clusterStats as $name => $stats) {
  $queriesStr = implode(', ', array_map(fn($q) => $q['query'] . ' (' . $q['impressions'] . ' imp)', array_slice($stats['top_queries'], 0, 10)));
  printf("%-20s | %-11d | %-17d | %-12d | %s\n",
    $name,
    $stats['count'],
    $stats['total_impressions'],
    $stats['total_clicks'],
    substr($queriesStr, 0, 100)
  );
}

// Unmapped high-impression queries
$unmapped = $clusters['Unmapped'] ?? [];
usort($unmapped, fn($a, $b) => $b['impressions'] <=> $a['impressions']);
echo "\n\nUnmapped high-impression queries (impressions >= 10):\n";
foreach (array_filter($unmapped, fn($q) => $q['impressions'] >= 10) as $q) {
  echo "  - {$q['query']} ({$q['impressions']} impressions, pos {$q['position']})\n";
}

echo "\n";

// Save for later use
file_put_contents(__DIR__.'/../sudo_evidence_data.json', json_encode([
  'duplicates' => $duplicates,
  'priority1' => $priority1,
  'priority2' => $priority2,
  'priority3' => $priority3,
  'clusters' => $clusterStats
], JSON_PRETTY_PRINT));

echo "Evidence data saved to sudo_evidence_data.json\n";

