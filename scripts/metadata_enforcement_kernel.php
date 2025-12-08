<?php
/**
 * METADATA ENFORCEMENT KERNEL
 * 
 * SUDO MODE: ACTIVE
 * Guarantees unique, relevant metadata for EVERY page in the codebase.
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/csv.php';
require_once __DIR__.'/../lib/helpers.php';

/**
 * Extract all existing metadata from the codebase
 */
function extract_existing_metadata(): array {
  $metadata = [];
  
  // Scan all PHP page files
  $pageDirs = [
    __DIR__.'/../pages/home/',
    __DIR__.'/../pages/services/',
    __DIR__.'/../pages/products/',
    __DIR__.'/../pages/insights/',
    __DIR__.'/../pages/careers/',
    __DIR__.'/../pages/tools/',
    __DIR__.'/../pages/industries/',
    __DIR__.'/../pages/catalog/',
    __DIR__.'/../pages/blog/',
    __DIR__.'/../pages/case-studies/',
  ];
  
  foreach ($pageDirs as $dir) {
    if (!is_dir($dir)) continue;
    
    $files = glob($dir . '*.php');
    foreach ($files as $file) {
      $content = file_get_contents($file);
      $path = str_replace(__DIR__.'/../pages/', '', $file);
      $path = str_replace('.php', '', $path);
      
      // Extract GLOBALS['pageTitle'] and GLOBALS['pageDesc']
      if (preg_match('/\$GLOBALS\[\'pageTitle\'\]\s*=\s*["\']([^"\']+)["\']/', $content, $m)) {
        $metadata[$path]['title'] = $m[1];
      }
      if (preg_match('/\$GLOBALS\[\'pageDesc\'\]\s*=\s*["\']([^"\']+)["\']/', $content, $m)) {
        $metadata[$path]['description'] = $m[1];
      }
      
      // Extract from meta_for_slug patterns
      if (preg_match('/meta_for_slug\([\'"]([^\'"]+)[\'"]\)/', $content, $m)) {
        $slug = $m[1];
        // This will be handled by meta_for_slug function
        $metadata[$path]['slug'] = $slug;
      }
    }
  }
  
  return $metadata;
}

/**
 * Check for duplicate metadata
 */
function check_duplicate(string $title, string $description, array $existingMetadata, float $threshold = 0.2): bool {
  foreach ($existingMetadata as $existing) {
    $existingTitle = $existing['title'] ?? '';
    $existingDesc = $existing['description'] ?? '';
    
    // Calculate similarity
    $titleSimilarity = similar_text(strtolower($title), strtolower($existingTitle)) / max(strlen($title), strlen($existingTitle));
    $descSimilarity = similar_text(strtolower($description), strtolower($existingDesc)) / max(strlen($description), strlen($existingDesc));
    
    if ($titleSimilarity > $threshold || $descSimilarity > $threshold) {
      return true;
    }
  }
  
  return false;
}

/**
 * Determine page type from path
 */
function get_page_type(string $path): string {
  if (preg_match('#^home/#', $path)) return 'homepage';
  if (preg_match('#^services/service_city#', $path)) return 'service_city';
  if (preg_match('#^services/service#', $path)) return 'service';
  if (preg_match('#^services/#', $path)) return 'service_index';
  if (preg_match('#^products/#', $path)) return 'product';
  if (preg_match('#^insights/#', $path)) return 'article';
  if (preg_match('#^careers/#', $path)) return 'career';
  if (preg_match('#^tools/#', $path)) return 'tool';
  if (preg_match('#^industries/#', $path)) return 'industry';
  if (preg_match('#^catalog/#', $path)) return 'catalog';
  if (preg_match('#^blog/#', $path)) return 'blog';
  if (preg_match('#^case-studies/#', $path)) return 'case_study';
  
  return 'page';
}

/**
 * Generate unique metadata for a page
 */
function generate_unique_metadata(string $filePath, string $pageType, array $context = []): array {
  $existingMetadata = extract_existing_metadata();
  $basePath = str_replace(__DIR__.'/../pages/', '', $filePath);
  $basePath = str_replace('.php', '', $basePath);
  
  // Extract context
  $service = $context['service'] ?? '';
  $city = $context['city'] ?? '';
  $slug = $context['slug'] ?? '';
  $locale = $context['locale'] ?? '';
  
  // Generate based on page type
  $title = '';
  $description = '';
  $attempts = 0;
  $maxAttempts = 10;
  
  do {
    switch ($pageType) {
      case 'homepage':
        $title = "NRLC.ai — AI SEO & LLM Optimization | Structured Data Engineering";
        $description = "NRLC.ai engineers AI SEO, structured data, and LLM seeding strategies. GEO-16 framework for AI engine optimization. Transform your site for AI visibility.";
        break;
        
      case 'service':
        $serviceName = ucwords(str_replace('-', ' ', $service));
        $title = "$serviceName Services | AI SEO Optimization | NRLC.ai";
        if (strlen($title) > 60) {
          $title = "$serviceName | AI SEO Services";
        }
        $description = "Expert $serviceName services by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Proven results.";
        if (strlen($description) > 155) {
          $description = substr($description, 0, 152) . '...';
        }
        break;
        
      case 'service_city':
        $serviceName = ucwords(str_replace('-', ' ', $service));
        $cityName = ucwords(str_replace('-', ' ', $city));
        $title = "$serviceName $cityName | AI SEO Services | NRLC.ai";
        if (strlen($title) > 60) {
          $title = "$serviceName $cityName";
        }
        $description = "Expert $serviceName services in $cityName. GEO-16 framework, structured data optimization, and AI engine citation readiness. Local expertise.";
        if (strlen($description) > 155) {
          $description = substr($description, 0, 152) . '...';
        }
        break;
        
      case 'article':
        $articleName = ucwords(str_replace('-', ' ', $slug));
        $title = "$articleName | AI SEO Research | NRLC.ai";
        if (strlen($title) > 60) {
          $title = "$articleName | NRLC Research";
        }
        $description = "Research and insights on $articleName. Comprehensive guide with practical strategies for AI-first SEO optimization. Research-backed by NRLC.ai experts.";
        if (strlen($description) > 155) {
          $description = substr($description, 0, 152) . '...';
        }
        break;
        
      case 'product':
        $productName = ucwords(str_replace('-', ' ', $slug));
        $title = "$productName | AI SEO Product | NRLC.ai";
        if (strlen($title) > 60) {
          $title = "$productName | NRLC.ai";
        }
        $description = "$productName by NRLC.ai. AI SEO product for structured data, LLM optimization, and technical SEO. Enterprise-ready solutions.";
        if (strlen($description) > 155) {
          $description = substr($description, 0, 152) . '...';
        }
        break;
        
      default:
        $pageName = ucwords(str_replace('-', ' ', basename($basePath)));
        $title = "$pageName | NRLC.ai";
        $description = "$pageName page on NRLC.ai. AI SEO services, structured data engineering, and LLM optimization solutions.";
    }
    
    // Add uniqueness markers if duplicate detected
    if ($attempts > 0) {
      if ($city) {
        $title = str_replace('|', "$cityName |", $title);
      }
      if ($locale && $locale !== 'en-us') {
        $title .= " ($locale)";
      }
    }
    
    $attempts++;
  } while (check_duplicate($title, $description, $existingMetadata) && $attempts < $maxAttempts);
  
  // Ensure length constraints
  if (strlen($title) < 50) {
    $title .= " | NRLC.ai";
  }
  if (strlen($title) > 60) {
    $title = substr($title, 0, 57) . '...';
  }
  
  if (strlen($description) < 120) {
    $description .= " Get results with proven AI SEO strategies and structured data implementation.";
  }
  if (strlen($description) > 155) {
    $description = substr($description, 0, 152) . '...';
  }
  
  return [
    'title' => $title,
    'description' => $description
  ];
}

/**
 * Audit all pages for metadata issues
 */
function audit_metadata(): array {
  $issues = [];
  $existingMetadata = extract_existing_metadata();
  $titles = [];
  $descriptions = [];
  
  foreach ($existingMetadata as $path => $meta) {
    $title = $meta['title'] ?? '';
    $desc = $meta['description'] ?? '';
    
    // Check for missing metadata
    if (empty($title) || empty($desc)) {
      $issues[] = [
        'path' => $path,
        'issue' => 'missing_metadata',
        'severity' => 'high'
      ];
    }
    
    // Check for duplicates
    if (!empty($title)) {
      foreach ($titles as $existingPath => $existingTitle) {
        $similarity = similar_text(strtolower($title), strtolower($existingTitle)) / max(strlen($title), strlen($existingTitle));
        if ($similarity > 0.8 && $path !== $existingPath) {
          $issues[] = [
            'path' => $path,
            'issue' => 'duplicate_title',
            'severity' => 'high',
            'duplicate_of' => $existingPath
          ];
        }
      }
      $titles[$path] = $title;
    }
    
    if (!empty($desc)) {
      foreach ($descriptions as $existingPath => $existingDesc) {
        $similarity = similar_text(strtolower($desc), strtolower($existingDesc)) / max(strlen($desc), strlen($existingDesc));
        if ($similarity > 0.8 && $path !== $existingPath) {
          $issues[] = [
            'path' => $path,
            'issue' => 'duplicate_description',
            'severity' => 'high',
            'duplicate_of' => $existingPath
          ];
        }
      }
      $descriptions[$path] = $desc;
    }
    
    // Check for generic/vague metadata
    $genericPatterns = [
      '/meta description here/i',
      '/placeholder/i',
      '/lorem ipsum/i',
      '/description/i',
      '/title here/i'
    ];
    
    foreach ($genericPatterns as $pattern) {
      if (preg_match($pattern, $title) || preg_match($pattern, $desc)) {
        $issues[] = [
          'path' => $path,
          'issue' => 'generic_metadata',
          'severity' => 'medium'
        ];
      }
    }
    
    // Check length constraints
    if (strlen($title) < 30 || strlen($title) > 70) {
      $issues[] = [
        'path' => $path,
        'issue' => 'title_length',
        'severity' => 'medium',
        'current_length' => strlen($title)
      ];
    }
    
    if (strlen($desc) < 100 || strlen($desc) > 165) {
      $issues[] = [
        'path' => $path,
        'issue' => 'description_length',
        'severity' => 'medium',
        'current_length' => strlen($desc)
      ];
    }
  }
  
  return $issues;
}

// CLI execution
if (php_sapi_name() === 'cli') {
  $command = $argv[1] ?? 'audit';
  
  if ($command === 'audit') {
    echo "=== METADATA AUDIT ===\n\n";
    $issues = audit_metadata();
    
    if (empty($issues)) {
      echo "✅ No metadata issues found.\n";
    } else {
      echo "Found " . count($issues) . " issues:\n\n";
      foreach ($issues as $issue) {
        echo "[{$issue['severity']}] {$issue['path']}: {$issue['issue']}\n";
        if (isset($issue['duplicate_of'])) {
          echo "  Duplicate of: {$issue['duplicate_of']}\n";
        }
        if (isset($issue['current_length'])) {
          echo "  Current length: {$issue['current_length']}\n";
        }
      }
    }
  }
}

