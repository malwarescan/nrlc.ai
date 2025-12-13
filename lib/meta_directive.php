<?php
declare(strict_types=1);

/**
 * SUDO-POWERED META DIRECTIVE SYSTEM
 * 
 * Authoritative metadata enforcement that analyzes page content
 * and ensures titles/descriptions match page intent.
 * 
 * This system has SUDO authority - it overrides and validates
 * all metadata to ensure SEO alignment with content intent.
 */

require_once __DIR__.'/helpers.php';
require_once __DIR__.'/csv.php';

/**
 * Extract page intent from content analysis
 * Returns: h1, lead, keyPhrases, pageType, primaryKeyword, intent
 */
function analyze_page_intent(string $filePath, string $slug): array {
  if (!file_exists($filePath)) {
    return ['error' => 'File not found'];
  }
  
  $content = file_get_contents($filePath);
  $html = $content; // Start with raw content
  
  // For PHP files, try to extract HTML patterns from the source code
  // This is safer than executing the file which may have dependencies
  if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
    // Look for HTML patterns in PHP strings and echo statements
    // Extract H1 from PHP code (e.g., <h1>...</h1> or echo "<h1>...</h1>")
    // This approach is safer and doesn't require executing the file
  }
  
  // Extract H1 from both HTML and PHP source code
  $h1 = '';
  // Try HTML pattern first
  if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $matches)) {
    $h1 = trim(strip_tags($matches[1]));
  }
  // Check for content-block__title pattern (common in this codebase)
  if (!$h1 && preg_match('/<h1[^>]*class=["\'].*?content-block__title.*?["\'][^>]*>(.*?)<\/h1>/is', $content, $matches)) {
    $h1 = trim(strip_tags($matches[1]));
  }
  // Check for content-block__title in div/span before h1
  if (!$h1 && preg_match('/content-block__title["\'][^>]*>(.*?)</is', $content, $matches)) {
    $h1 = trim(strip_tags($matches[1]));
  }
  // Also check PHP echo/print statements for H1
  if (!$h1 && preg_match('/(?:echo|print)\s*[\'"](?:.*?)<h1[^>]*>(.*?)<\/h1>(?:.*?)[\'"]/is', $content, $matches)) {
    $h1 = trim(strip_tags($matches[1]));
  }
  // Check for H1 in PHP variables
  if (!$h1 && preg_match('/\$[a-zA-Z_][a-zA-Z0-9_]*\s*=\s*[\'"](.*?)["\']/is', $content, $matches)) {
    // This is a fallback - less reliable
  }
  
  // Extract lead paragraph
  $lead = '';
  // Try HTML pattern first
  if (preg_match('/<p[^>]*class=["\']lead["\'][^>]*>(.*?)<\/p>/is', $html, $matches)) {
    $lead = trim(strip_tags($matches[1]));
  }
  // Also check PHP source for lead paragraphs
  if (!$lead && preg_match('/<p[^>]*class=["\']lead["\'][^>]*>(.*?)<\/p>/is', $content, $matches)) {
    $lead = trim(strip_tags($matches[1]));
  }
  // Fallback to first substantial paragraph
  if (!$lead && preg_match('/<p[^>]*>(.*?)<\/p>/is', $html, $matches)) {
    $lead = trim(strip_tags($matches[1]));
    if (strlen($lead) < 20) {
      $lead = '';
    }
  }
  
  // Extract key phrases from H2s
  $keyPhrases = [];
  if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $html, $matches)) {
    foreach ($matches[1] as $h2) {
      $text = trim(strip_tags($h2));
      if (strlen($text) > 5 && strlen($text) < 100) {
        $keyPhrases[] = $text;
      }
    }
  }
  // Also check PHP source for H2s
  if (empty($keyPhrases) && preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches)) {
    foreach ($matches[1] as $h2) {
      $text = trim(strip_tags($h2));
      if (strlen($text) > 5 && strlen($text) < 100) {
        $keyPhrases[] = $text;
      }
    }
  }
  
  // Determine page type from slug
  $pageType = 'general';
  if (strpos($slug, 'services/') === 0) $pageType = 'service';
  elseif (strpos($slug, 'products/') === 0) $pageType = 'product';
  elseif (strpos($slug, 'insights/') === 0 || strpos($slug, 'blog/') === 0) $pageType = 'article';
  elseif (strpos($slug, 'careers/') === 0) $pageType = 'career';
  elseif (strpos($slug, 'home/') === 0 || $slug === 'home/home') $pageType = 'homepage';
  elseif (strpos($slug, 'case-studies/') === 0) $pageType = 'case-study';
  elseif (strpos($slug, 'tools/') === 0) $pageType = 'tool';
  elseif (strpos($slug, 'catalog/') === 0) $pageType = 'catalog';
  
  // Extract primary keyword from H1 or slug
  $primaryKeyword = '';
  if ($h1) {
    // If H1 is too long, extract key phrase or use first part
    if (strlen($h1) > 50) {
      // Try to extract a shorter key phrase
      $words = explode(' ', $h1);
      if (count($words) > 3) {
        // Use first 3-4 words
        $primaryKeyword = implode(' ', array_slice($words, 0, 4));
      } else {
        $primaryKeyword = $h1;
      }
    } else {
      $primaryKeyword = $h1;
    }
  }
  
  // Fallback to slug-based keyword
  if (!$primaryKeyword) {
    $slugParts = explode('/', trim($slug, '/'));
    $lastPart = end($slugParts);
    if ($lastPart === 'index') {
      // For index pages, use the parent directory
      $slugParts = array_slice($slugParts, 0, -1);
      $lastPart = end($slugParts) ?: 'page';
    }
    $primaryKeyword = ucwords(str_replace('-', ' ', $lastPart));
  }
  
  // Special handling for common page types
  if ($pageType === 'service' && $slug === 'services/index') {
    $primaryKeyword = 'AI SEO Services';
  } elseif ($pageType === 'service' && strpos($slug, 'services/') === 0) {
    // Extract service name from slug
    $serviceSlug = str_replace('services/', '', $slug);
    $serviceSlug = str_replace('/index', '', $serviceSlug);
    $serviceSlug = trim($serviceSlug, '/');
    if ($serviceSlug) {
      $primaryKeyword = ucwords(str_replace('-', ' ', $serviceSlug)) . ' Services';
    }
  }
  
  // Determine intent
  $intent = determine_intent($h1, $lead, $slug, $pageType);
  
  return [
    'h1' => $h1,
    'lead' => $lead,
    'keyPhrases' => array_slice($keyPhrases, 0, 5),
    'pageType' => $pageType,
    'primaryKeyword' => $primaryKeyword,
    'intent' => $intent
  ];
}

/**
 * Determine user intent from content
 */
function determine_intent(string $h1, string $lead, string $slug, string $pageType): string {
  $text = strtolower($h1 . ' ' . $lead . ' ' . $slug);
  
  // Transactional intent (buying, hiring, services)
  if (preg_match('/\b(service|hire|buy|purchase|get|order|book|demo|consult|expert|professional|agency|company)\b/i', $text)) {
    return 'transactional';
  }
  
  // Informational intent (learning, guides, research)
  if (preg_match('/\b(what|how|why|guide|tutorial|learn|research|insight|article|blog|study|analysis)\b/i', $text)) {
    return 'informational';
  }
  
  // Navigational intent (brand, company pages)
  if (preg_match('/\b(about|team|career|contact|home)\b/i', $text) || $pageType === 'homepage') {
    return 'navigational';
  }
  
  // Local intent (location-based)
  if (preg_match('/\b(in|at|near|local|city|location)\b/i', $text) || strpos($slug, '/') !== false && preg_match('/[a-z]+-[a-z]+/', $slug)) {
    return 'local';
  }
  
  // Default based on page type
  switch ($pageType) {
    case 'service':
    case 'product':
      return 'transactional';
    case 'article':
    case 'case-study':
      return 'informational';
    case 'career':
      return 'transactional';
    default:
      return 'informational';
  }
}

/**
 * Generate optimal title based on intent analysis
 * SUDO: This is the authoritative title generator
 */
function generate_meta_title(array $intent, string $slug, ?string $currentTitle = null): string {
  $h1 = $intent['h1'] ?? '';
  $primaryKeyword = $intent['primaryKeyword'] ?? '';
  $pageType = $intent['pageType'] ?? 'general';
  $intentType = $intent['intent'] ?? 'informational';
  
  // If we have a good H1, use it as base
  if ($h1 && strlen($h1) > 10) {
    // For services/index, use H1 directly if it's descriptive
    if ($pageType === 'service' && $slug === 'services/index') {
      $base = $h1; // Use H1 directly for services index
    } elseif (strlen($h1) < 60) {
      $base = $h1; // Use H1 if it's not too long
    } else {
      // H1 is too long, use primary keyword instead
      $base = $primaryKeyword ?: 'Page';
    }
  } else {
    $base = $primaryKeyword ?: 'Page';
  }
  
  // Add context based on page type and intent
  $suffix = ' | NRLC.ai';
  
  switch ($pageType) {
    case 'service':
      if ($slug === 'services/index') {
        // Services index page - use H1 + suffix
        $base = $base . $suffix;
      } elseif ($intentType === 'local') {
        // Service + City format
        $base = $base . $suffix;
      } else {
        // Don't add "Services" if H1 already contains it or is descriptive
        if (stripos($base, 'service') === false && strlen($base) < 40) {
          $base = $base . ' Services' . $suffix;
        } else {
          $base = $base . $suffix;
        }
      }
      break;
      
    case 'product':
      $base = $base . ' | AI SEO Product' . $suffix;
      break;
      
    case 'article':
    case 'case-study':
      $base = $base . ' | AI SEO Research' . $suffix;
      break;
      
    case 'career':
      $base = $base . ' | Careers' . $suffix;
      break;
      
    case 'homepage':
      $base = 'NRLC.ai — AI SEO & GEO-16 Framework | LLM Optimization';
      break;
      
    default:
      $base = $base . $suffix;
  }
  
  // Ensure title is 50-60 characters (optimal for SEO)
  if (strlen($base) > 60) {
    // Truncate intelligently
    $base = substr($base, 0, 57) . '...';
  } elseif (strlen($base) < 30) {
    // Add more context if too short
    $base = $base . ' | Expert AI SEO';
  }
  
  return $base;
}

/**
 * Generate optimal description based on intent analysis
 * SUDO: This is the authoritative description generator
 */
function generate_meta_description(array $intent, string $slug, ?string $currentDesc = null): string {
  $lead = $intent['lead'] ?? '';
  $h1 = $intent['h1'] ?? '';
  $primaryKeyword = $intent['primaryKeyword'] ?? '';
  $pageType = $intent['pageType'] ?? 'general';
  $intentType = $intent['intent'] ?? 'informational';
  
  // Use lead paragraph if available and good
  if ($lead && strlen($lead) > 50 && strlen($lead) < 160) {
    $desc = $lead;
  } else {
    // Generate from context
    switch ($pageType) {
      case 'service':
        if ($slug === 'services/index') {
          // Use lead paragraph if available, otherwise generate
          $desc = $lead ?: "NRLC provides a semantic operating layer that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.";
        } elseif ($intentType === 'local') {
          $serviceName = str_replace(' Services', '', $primaryKeyword);
          $desc = "Expert $serviceName services. Professional AI SEO optimization with GEO-16 framework, structured data, and LLM citation readiness.";
        } else {
          $serviceName = str_replace(' Services', '', $primaryKeyword);
          $desc = "Expert $serviceName services by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Get results with proven AI SEO strategies.";
        }
        break;
        
      case 'product':
        $desc = "$primaryKeyword by NRLC.ai. AI SEO product for structured data, LLM optimization, and technical SEO. Enterprise-ready solutions.";
        break;
        
      case 'article':
      case 'case-study':
        $desc = "Research and insights on $primaryKeyword. Comprehensive guide with practical strategies for AI-first SEO optimization. Research-backed by NRLC.ai experts.";
        break;
        
      case 'career':
        $desc = "Join NRLC.ai team. Careers in AI SEO, GEO-16 framework development, structured data optimization, and LLM citation strategies.";
        break;
        
      case 'homepage':
        $desc = "NRLC.ai engineers crawl clarity, structured data, and LLM seeding strategies. GEO-16 framework for AI engine optimization across major cities.";
        break;
        
      default:
        $desc = "$primaryKeyword on NRLC.ai. AI SEO services, structured data engineering, and LLM optimization solutions.";
    }
  }
  
  // Ensure description is 150-160 characters (optimal for SEO)
  if (strlen($desc) > 160) {
    $desc = substr($desc, 0, 157) . '...';
  } elseif (strlen($desc) < 120) {
    // Add more context if too short
    $desc = $desc . ' Professional AI SEO services by NRLC.ai.';
    if (strlen($desc) > 160) {
      $desc = substr($desc, 0, 157) . '...';
    }
  }
  
  return $desc;
}

/**
 * SUDO-POWERED META DIRECTIVE
 * Analyzes page and enforces metadata that matches intent
 * Returns: [title, description] - authoritative metadata
 */
function sudo_meta_directive(string $filePath, string $slug, ?string $currentTitle = null, ?string $currentDesc = null): array {
  // Analyze page intent
  $intent = analyze_page_intent($filePath, $slug);
  
  if (isset($intent['error'])) {
    // Fallback to current or default
    return [
      $currentTitle ?? 'NRLC.ai | AI SEO Services',
      $currentDesc ?? 'AI SEO services, structured data engineering, and LLM optimization solutions.'
    ];
  }
  
  // Generate optimal metadata
  $title = generate_meta_title($intent, $slug, $currentTitle);
  $description = generate_meta_description($intent, $slug, $currentDesc);
  
  // Validate current metadata against intent (optional logging)
  if ($currentTitle && $currentDesc) {
    $titleMatch = validate_metadata_alignment($currentTitle, $title, $intent);
    $descMatch = validate_metadata_alignment($currentDesc, $description, $intent);
    
    // If current metadata is significantly misaligned, use generated
    if ($titleMatch < 0.5) {
      // Current title doesn't match intent - use generated
    }
    if ($descMatch < 0.5) {
      // Current description doesn't match intent - use generated
    }
  }
  
  return [$title, $description];
}

/**
 * Validate how well current metadata aligns with intent
 * Returns: 0.0 to 1.0 (1.0 = perfect alignment)
 */
function validate_metadata_alignment(string $current, string $generated, array $intent): float {
  $currentLower = strtolower($current);
  $generatedLower = strtolower($generated);
  $h1Lower = strtolower($intent['h1'] ?? '');
  $primaryLower = strtolower($intent['primaryKeyword'] ?? '');
  
  $score = 0.0;
  
  // Check if current contains primary keyword
  if ($primaryLower && strpos($currentLower, $primaryLower) !== false) {
    $score += 0.3;
  }
  
  // Check if current contains H1
  if ($h1Lower && strpos($currentLower, $h1Lower) !== false) {
    $score += 0.3;
  }
  
  // Check similarity to generated (optimal) metadata
  similar_text($currentLower, $generatedLower, $similarity);
  $score += ($similarity / 100) * 0.4;
  
  return min(1.0, $score);
}

