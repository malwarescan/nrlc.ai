<?php
declare(strict_types=1);
/**
 * NRLC AUTO-CRAWL GLOBAL LINKING KERNEL
 * 
 * Sudo-level command that automatically discovers, crawls, and analyzes every
 * single page in the NRLC.ai ecosystem for linking compliance.
 */

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/nrlc_linking_kernel.php';

/**
 * Discover all pages in the project
 */
function discover_all_pages(): array {
  $manifest = [
    'insights' => [],
    'services' => [],
    'tools' => [],
    'products' => [],
    'catalog' => [],
    'industries' => [],
    'careers' => [],
    'case-studies' => [],
    'resources' => [],
    'blog' => [],
    'home' => [],
    'other' => []
  ];
  
  $base_dir = __DIR__ . '/../pages';
  
  // Discover insights pages
  $insights_dir = $base_dir . '/insights';
  if (is_dir($insights_dir)) {
    $files = glob($insights_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['insights'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/insights/' . ($slug === 'index' ? '' : $slug . '/'),
        'type' => $slug === 'index' ? 'index' : ($slug === 'article' ? 'router' : 'article')
      ];
    }
  }
  
  // Discover services pages
  $services_dir = $base_dir . '/services';
  if (is_dir($services_dir)) {
    $files = glob($services_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['services'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/services/' . ($slug === 'index' ? '' : ($slug === 'service' ? '{service}/' : $slug . '/')),
        'type' => $slug === 'index' ? 'index' : ($slug === 'service' ? 'dynamic' : 'static')
      ];
    }
  }
  
  // Discover tools pages
  $tools_dir = $base_dir . '/tools';
  if (is_dir($tools_dir)) {
    $files = glob($tools_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['tools'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/tools/' . ($slug === 'index' ? '' : ($slug === 'tool' ? '{tool}/' : $slug . '/')),
        'type' => $slug === 'index' ? 'index' : ($slug === 'tool' ? 'dynamic' : 'static')
      ];
    }
  }
  
  // Discover products pages
  $products_dir = $base_dir . '/products';
  if (is_dir($products_dir)) {
    $files = glob($products_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['products'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/products/' . ($slug === 'index' ? '' : $slug . '/'),
        'type' => $slug === 'index' ? 'index' : 'product'
      ];
    }
  }
  
  // Discover catalog pages
  $catalog_dir = $base_dir . '/catalog';
  if (is_dir($catalog_dir)) {
    $files = glob($catalog_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['catalog'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/catalog/' . ($slug === 'index' ? '' : ($slug === 'item' ? '{slug}/' : $slug . '/')),
        'type' => $slug === 'index' ? 'index' : 'item'
      ];
    }
  }
  
  // Discover industries pages
  $industries_dir = $base_dir . '/industries';
  if (is_dir($industries_dir)) {
    $files = glob($industries_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['industries'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/industries/' . ($slug === 'index' ? '' : $slug . '/'),
        'type' => $slug === 'index' ? 'index' : 'industry'
      ];
    }
  }
  
  // Discover careers pages
  $careers_dir = $base_dir . '/careers';
  if (is_dir($careers_dir)) {
    $files = glob($careers_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['careers'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/careers/' . ($slug === 'index' ? '' : ($slug === 'career_city' ? '{city}/{role}/' : $slug . '/')),
        'type' => $slug === 'index' ? 'index' : 'career'
      ];
    }
  }
  
  // Discover home page
  $home_dir = $base_dir . '/home';
  if (is_dir($home_dir)) {
    $files = glob($home_dir . '/*.php');
    foreach ($files as $file) {
      $slug = basename($file, '.php');
      $manifest['home'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/',
        'type' => 'home'
      ];
    }
  }
  
  // Discover case studies (sample a few)
  $case_studies_dir = $base_dir . '/case-studies';
  if (is_dir($case_studies_dir)) {
    $files = glob($case_studies_dir . '/*.php');
    // Sample first 10 for audit
    $sample = array_slice($files, 0, 10);
    foreach ($sample as $file) {
      $slug = basename($file, '.php');
      $manifest['case-studies'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/case-studies/' . $slug . '/',
        'type' => 'case-study'
      ];
    }
  }
  
  // Discover resources (sample a few)
  $resources_dir = $base_dir . '/resources';
  if (is_dir($resources_dir)) {
    $files = glob($resources_dir . '/*.php');
    // Sample first 10 for audit
    $sample = array_slice($files, 0, 10);
    foreach ($sample as $file) {
      $slug = basename($file, '.php');
      $manifest['resources'][] = [
        'file' => $file,
        'slug' => $slug,
        'url' => '/resources/' . $slug . '/',
        'type' => 'resource'
      ];
    }
  }
  
  return $manifest;
}

/**
 * Audit a single page file
 */
function audit_page_file(string $file_path, string $page_type, string $page_slug = ''): array {
  if (!is_file($file_path)) {
    return [
      'error' => 'File not found',
      'score' => 'F'
    ];
  }
  
  $content = file_get_contents($file_path);
  if ($content === false) {
    return [
      'error' => 'Could not read file',
      'score' => 'F'
    ];
  }
  
  // Extract metadata if available
  $metadata = [];
  if (preg_match('/\$GLOBALS\[[\'"]__page_slug[\'"]\]\s*=\s*[\'"]([^\'"]+)[\'"]/', $content, $m)) {
    $metadata['page_slug'] = $m[1];
  }
  
  // Run linking audit
  $audit = audit_page_links($content, $page_type, $page_slug);
  
  // Extract actual links from content
  preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $content, $matches);
  $links_found = [];
  foreach ($matches[1] ?? [] as $idx => $url) {
    $anchor = strip_tags($matches[2][$idx] ?? '');
    $links_found[] = [
      'url' => $url,
      'anchor' => trim($anchor),
      'is_internal' => (strpos($url, 'https://nrlc.ai') === 0 || strpos($url, '/') === 0) && strpos($url, 'http') !== 0
    ];
  }
  
  return [
    'file' => $file_path,
    'page_type' => $page_type,
    'page_slug' => $page_slug,
    'audit' => $audit,
    'links_found' => $links_found,
    'total_links' => count($links_found),
    'internal_links' => count(array_filter($links_found, fn($l) => $l['is_internal'])),
    'external_links' => count(array_filter($links_found, fn($l) => !$l['is_internal']))
  ];
}

/**
 * Generate complete site-wide audit report
 */
function generate_site_audit_report(): array {
  $manifest = discover_all_pages();
  $audit_results = [];
  $orphaned_pages = [];
  $low_score_pages = [];
  
  // Audit each category
  foreach ($manifest as $category => $pages) {
    foreach ($pages as $page) {
      $page_type = $category === 'insights' ? 'insights' : 
                   ($category === 'services' ? 'services' : 
                   ($category === 'tools' ? 'tools' : 
                   ($category === 'products' ? 'products' : 
                   ($category === 'catalog' ? 'catalog' : 'other'))));
      
      $result = audit_page_file($page['file'], $page_type, $page['slug']);
      $result['category'] = $category;
      $result['url'] = $page['url'];
      
      $audit_results[] = $result;
      
      // Track orphaned pages (no internal links)
      if ($result['internal_links'] === 0) {
        $orphaned_pages[] = $result;
      }
      
      // Track low score pages
      if (($result['audit']['score'] ?? 'F') === 'F' || ($result['audit']['score'] ?? 'F') === 'C') {
        $low_score_pages[] = $result;
      }
    }
  }
  
  // Calculate statistics
  $stats = [
    'total_pages' => count($audit_results),
    'orphaned_pages' => count($orphaned_pages),
    'low_score_pages' => count($low_score_pages),
    'score_distribution' => [
      'A' => count(array_filter($audit_results, fn($r) => ($r['audit']['score'] ?? 'F') === 'A')),
      'B' => count(array_filter($audit_results, fn($r) => ($r['audit']['score'] ?? 'F') === 'B')),
      'C' => count(array_filter($audit_results, fn($r) => ($r['audit']['score'] ?? 'F') === 'C')),
      'F' => count(array_filter($audit_results, fn($r) => ($r['audit']['score'] ?? 'F') === 'F'))
    ]
  ];
  
  return [
    'manifest' => $manifest,
    'audit_results' => $audit_results,
    'orphaned_pages' => $orphaned_pages,
    'low_score_pages' => $low_score_pages,
    'statistics' => $stats,
    'generated_at' => date('Y-m-d H:i:s')
  ];
}

/**
 * Format audit report as readable text
 */
function format_audit_report(array $report): string {
  $output = "=" . str_repeat("=", 78) . "\n";
  $output .= "NRLC.AI GLOBAL LINKING AUDIT REPORT\n";
  $output .= "Generated: " . $report['generated_at'] . "\n";
  $output .= "=" . str_repeat("=", 78) . "\n\n";
  
  // Statistics
  $stats = $report['statistics'];
  $output .= "OVERALL STATISTICS\n";
  $output .= str_repeat("-", 78) . "\n";
  $output .= "Total Pages Audited: " . $stats['total_pages'] . "\n";
  $output .= "Orphaned Pages (0 internal links): " . $stats['orphaned_pages'] . "\n";
  $output .= "Low Score Pages (C or F): " . $stats['low_score_pages'] . "\n\n";
  
  $output .= "Score Distribution:\n";
  $output .= "  A (Perfect): " . $stats['score_distribution']['A'] . "\n";
  $output .= "  B (Good): " . $stats['score_distribution']['B'] . "\n";
  $output .= "  C (Needs Fix): " . $stats['score_distribution']['C'] . "\n";
  $output .= "  F (Critical): " . $stats['score_distribution']['F'] . "\n\n";
  
  // Orphaned pages
  if (!empty($report['orphaned_pages'])) {
    $output .= "ORPHANED PAGES (CRITICAL - No Internal Links)\n";
    $output .= str_repeat("-", 78) . "\n";
    foreach ($report['orphaned_pages'] as $page) {
      $output .= "  " . $page['file'] . "\n";
      $output .= "    URL: " . ($page['url'] ?? 'N/A') . "\n";
      $output .= "    Score: " . ($page['audit']['score'] ?? 'F') . "\n\n";
    }
  }
  
  // Low score pages
  if (!empty($report['low_score_pages'])) {
    $output .= "LOW SCORE PAGES (Require Immediate Attention)\n";
    $output .= str_repeat("-", 78) . "\n";
    foreach (array_slice($report['low_score_pages'], 0, 20) as $page) {
      $output .= "  " . basename($page['file']) . "\n";
      $output .= "    URL: " . ($page['url'] ?? 'N/A') . "\n";
      $output .= "    Score: " . ($page['audit']['score'] ?? 'F') . "\n";
      $output .= "    Internal Links: " . $page['internal_links'] . "\n";
      if (!empty($page['audit']['issues'])) {
        $output .= "    Issues: " . implode(', ', array_slice($page['audit']['issues'], 0, 3)) . "\n";
      }
      $output .= "\n";
    }
  }
  
  // Detailed audit by category
  $output .= "DETAILED AUDIT BY CATEGORY\n";
  $output .= str_repeat("-", 78) . "\n";
  
  foreach ($report['manifest'] as $category => $pages) {
    $category_results = array_filter($report['audit_results'], fn($r) => $r['category'] === $category);
    if (empty($category_results)) continue;
    
    $output .= "\n" . strtoupper($category) . " (" . count($category_results) . " pages)\n";
    foreach ($category_results as $result) {
      $score = $result['audit']['score'] ?? 'F';
      $output .= "  [" . $score . "] " . basename($result['file']) . "\n";
      $output .= "      Links: " . $result['internal_links'] . " internal, " . $result['external_links'] . " external\n";
      if (!empty($result['audit']['issues'])) {
        $output .= "      Issues: " . count($result['audit']['issues']) . "\n";
      }
    }
  }
  
  return $output;
}

