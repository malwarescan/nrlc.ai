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
      case 'insight':
        // Insights title formula from audit: "{Topic} — Guide, Checklist, and Implementation Notes | Neural Command"
        // But trim to fit 60 chars
        if (strlen($base) > 40) {
          $base = $base . ' Guide' . $suffix;
        } else {
          $base = $base . ' — Guide & Implementation' . $suffix;
        }
        // Ensure it fits
        if (strlen($base) > 60) {
          $base = substr($base, 0, 40) . ' Guide' . $suffix;
        }
        break;
        
      case 'case-study':
        $base = $base . ' | AI SEO Research' . $suffix;
        break;
      
      case 'career':
        // Careers title formula from audit
        $isRealJob = $intent['isRealJob'] ?? false;
        $cityName = ucwords(str_replace(['-', '_'], ' ', $intent['city'] ?? ''));
        if ($isRealJob) {
          // "{Role Title} — {City} | Careers at Neural Command"
          $base = $base . ' — ' . $cityName . ' | Careers at Neural Command';
        } else {
          // "{Role Title} Jobs in {City} — Hiring Guide | Neural Command"
          $base = $base . ' Jobs in ' . $cityName . ' — Hiring Guide' . $suffix;
        }
        break;
      
      case 'homepage':
        // Homepage title from audit report
        $base = 'Neural Command — AI Search Optimization, Schema, and LLM Visibility';
        // Trim to 60 chars if needed
        if (strlen($base) > 60) {
          $base = substr($base, 0, 57) . '...';
        }
        break;
      
    default:
      $base = $base . $suffix;
  }
  
  // Ensure title is 50-60 characters (optimal for SEO, hard max 65)
  if (strlen($base) > 65) {
    // Truncate intelligently at word boundary
    $truncated = substr($base, 0, 62);
    $lastSpace = strrpos($truncated, ' ');
    if ($lastSpace !== false && $lastSpace > 50) {
      $base = substr($truncated, 0, $lastSpace) . '...';
    } else {
      $base = $truncated . '...';
    }
  } elseif (strlen($base) < 30) {
    // Add more context if too short
    $base = $base . ' | Expert AI SEO';
  }
  
  return $base;
}

/**
 * Generate optimal description based on intent analysis
 * SUDO: This is the authoritative description generator
 * Uses deterministic rules from SUDO META DIRECTIVE KERNEL audit
 */
function generate_meta_description(array $intent, string $slug, ?string $currentDesc = null): string {
  $lead = $intent['lead'] ?? '';
  $h1 = $intent['h1'] ?? '';
  $primaryKeyword = $intent['primaryKeyword'] ?? '';
  $pageType = $intent['pageType'] ?? 'general';
  $intentType = $intent['intent'] ?? 'informational';
  
  // Use lead paragraph if available and good (but trim to 160 chars)
  if ($lead && strlen($lead) > 50 && strlen($lead) < 175) {
    $desc = substr($lead, 0, 160);
  } else {
    // Generate from context using deterministic rules
    switch ($pageType) {
      case 'homepage':
        // Homepage description (trimmed from audit report)
        $desc = "NRLC provides a semantic operating layer for databases, APIs, and data streams. Transform your infrastructure into a queryable knowledge graph with ontologies, SQL reasoning, and automated relationships. Enterprise-ready AI SEO solutions.";
        break;
        
      case 'service':
        if ($slug === 'services/index') {
          // Services index - use lead or default
          $desc = $lead ?: "NRLC provides a semantic operating layer that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.";
          // Trim to 160
          if (strlen($desc) > 160) {
            $desc = substr($desc, 0, 157) . '...';
          }
        } elseif ($intentType === 'local') {
          // Service + City format (deterministic rule from audit)
          $serviceName = ucwords(str_replace(['-', '_'], ' ', $primaryKeyword));
          $cityName = $intent['city'] ?? '';
          if ($cityName) {
            $cityName = ucwords(str_replace(['-', '_'], ' ', $cityName));
          }
          // Rotate outcome keywords to avoid duplication
          $outcomes = ['rankings', 'CTR', 'leads', 'visibility', 'conversions'];
          $outcome = $outcomes[abs(crc32($serviceName . $cityName)) % count($outcomes)];
          $desc = "$serviceName for $cityName teams. Fix indexing, schema, and AI visibility. Fast audits, clear deliverables, measurable lift. Book a call.";
        } else {
          $serviceName = ucwords(str_replace(['-', '_'], ' ', $primaryKeyword));
          $desc = "Expert $serviceName services by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Get results with proven AI SEO strategies.";
        }
        break;
        
      case 'product':
        $desc = "$primaryKeyword by NRLC.ai. AI SEO product for structured data, LLM optimization, and technical SEO. Enterprise-ready solutions.";
        break;
        
      case 'article':
      case 'insight':
        // Insights/Articles - deterministic rule from audit
        $topic = ucwords(str_replace(['-', '_'], ' ', $primaryKeyword ?: $h1));
        // Include deliverable word (guide, framework, checklist, templates)
        $deliverables = ['guide', 'framework', 'checklist', 'templates'];
        $deliverable = $deliverables[abs(crc32($topic)) % count($deliverables)];
        $desc = "Complete $deliverable to $topic. Learn best practices, implementation strategies, and optimization techniques. Includes case studies and actionable insights for AI SEO professionals.";
        break;
        
      case 'case-study':
        $desc = "Research and insights on $primaryKeyword. Comprehensive guide with practical strategies for AI-first SEO optimization. Research-backed by NRLC.ai experts.";
        break;
        
      case 'career':
        // Careers - check if real job or informational
        $isRealJob = $intent['isRealJob'] ?? false;
        if ($isRealJob) {
          $roleTitle = ucwords(str_replace(['-', '_'], ' ', $primaryKeyword ?: $h1));
          $cityName = ucwords(str_replace(['-', '_'], ' ', $intent['city'] ?? ''));
          $desc = "Apply for $roleTitle in $cityName. Remote-friendly role with competitive salary. Responsibilities include technical documentation, SEO content, and LLM optimization guides. Apply now.";
        } else {
          $roleTitle = ucwords(str_replace(['-', '_'], ' ', $primaryKeyword ?: $h1));
          $cityName = ucwords(str_replace(['-', '_'], ' ', $intent['city'] ?? ''));
          $desc = "What $roleTitle roles pay in $cityName, required skills, and how to apply when openings go live. Learn about responsibilities, qualifications, and application process.";
        }
        break;
        
      case 'homepage':
        // Homepage description (trimmed from audit report)
        $desc = "NRLC provides a semantic operating layer for databases, APIs, and data streams. Transform your infrastructure into a queryable knowledge graph with ontologies, SQL reasoning, and automated relationships. Enterprise-ready AI SEO solutions.";
        break;
        
      default:
        $desc = "$primaryKeyword on NRLC.ai. AI SEO services, structured data engineering, and LLM optimization solutions.";
    }
  }
  
  // Ensure description is 140-160 characters (optimal for SEO, hard max 175)
  if (strlen($desc) > 175) {
    // Truncate intelligently at word boundary
    $truncated = substr($desc, 0, 172);
    $lastSpace = strrpos($truncated, ' ');
    if ($lastSpace !== false && $lastSpace > 140) {
      $desc = substr($truncated, 0, $lastSpace) . '...';
    } else {
      $desc = $truncated . '...';
    }
  } elseif (strlen($desc) < 100) {
    // Add more context if too short
    $desc = $desc . ' Learn more about AI SEO, structured data, and LLM optimization strategies.';
    // Re-trim if needed
    if (strlen($desc) > 175) {
      $desc = substr($desc, 0, 172) . '...';
    }
  }
  
  return $desc;
}

/**
 * SUDO-POWERED META DIRECTIVE (Context-Based)
 * Generates deterministic, unique metadata from page context
 * 
 * @param array $ctx Required keys: type, slug. Optional: title, excerpt, city, service, role, canonicalPath
 * @return array ['title' => string, 'description' => string, 'canonicalPath' => string]
 */
function sudo_meta_directive_ctx(array $ctx): array {
  $type = $ctx['type'] ?? 'general';
  $slug = $ctx['slug'] ?? 'unknown';
  $title = $ctx['title'] ?? null;
  $excerpt = $ctx['excerpt'] ?? null;
  $city = $ctx['city'] ?? null;
  $service = $ctx['service'] ?? null;
  $role = $ctx['role'] ?? null;
  $canonicalPath = $ctx['canonicalPath'] ?? null;
  
  // Generate title with fallbacks
  if (!$title) {
    // Derive from slug
    $slugParts = explode('/', $slug);
    $lastPart = end($slugParts);
    $title = ucwords(str_replace(['-', '_'], ' ', $lastPart));
  }
  
  // Generate description with type-specific lead-ins to ensure uniqueness
  $desc = '';
  switch ($type) {
    case 'blog_post':
      $leadIn = 'Learn how to';
      $suffix = '| NRLC.ai';
      if ($excerpt) {
        $desc = $excerpt;
      } else {
        $desc = "$leadIn $title. Practical AI SEO strategies, implementation guides, and optimization techniques for modern search engines.";
      }
      $title = $title . ' ' . $suffix;
      break;
      
    case 'case_study':
      $leadIn = 'See how we';
      $suffix = '| Case Study';
      if ($excerpt) {
        $desc = $excerpt;
      } else {
        $desc = "$leadIn helped achieve measurable results with $title. Real-world AI SEO implementation, data-driven outcomes, and actionable insights.";
      }
      $title = $title . ' ' . $suffix;
      break;
      
    case 'resource':
      $leadIn = 'Download or reference';
      $suffix = '| Resource';
      if ($excerpt) {
        $desc = $excerpt;
      } else {
        $desc = "$leadIn $title. Comprehensive guides, templates, and tools for AI SEO optimization, structured data, and LLM visibility.";
      }
      $title = $title . ' ' . $suffix;
      break;
      
    case 'tool':
      $leadIn = 'Use this tool to';
      $suffix = '| NRLC.ai Tools';
      if ($excerpt) {
        $desc = $excerpt;
      } else {
        $desc = "$leadIn $title. Free AI SEO tool for technical audits, schema validation, and search engine optimization.";
      }
      $title = $title . ' ' . $suffix;
      break;
      
    case 'industry':
      $leadIn = 'SEO and AI visibility for';
      $suffix = '| Industry Playbook';
      if ($excerpt) {
        $desc = $excerpt;
      } else {
        $desc = "$leadIn $title industry. Specialized strategies, compliance considerations, and proven tactics for sector-specific SEO success.";
      }
      $title = $title . ' ' . $suffix;
      break;
      
    case 'service':
      if ($city && $service) {
        // Service + City pages: HIGHEST PRIORITY - Hire now intent
        require_once __DIR__.'/helpers.php';
        $isUK = function_exists('is_uk_city') ? is_uk_city($city) : false;
        $cityName = ucwords(str_replace(['-', '_'], ' ', $city));
        
        // For UK cities, always use "Local SEO Services" regardless of service type
        // This aligns with query intent ("seo norwich", "seo stockport")
        // For US cities, also use "Local SEO Services" for consistency
        $title = "Local SEO Services in $cityName | NRLC.ai";
        $desc = "Local SEO for $cityName businesses. Technical audits, Google Business Profile optimization, and measurable leads. Call or email to start.";
      } else {
        // Service hub or non-local service pages
        if ($service === 'services' || $slug === 'services/index') {
          // Service hub page
          $title = 'Technical SEO & AI Search Services | NRLC.ai';
          $desc = 'Professional technical SEO, structured data, and AI search optimization services. Built for sites that need real fixes, not tactics.';
        } else {
          // Non-local service pages (AI SEO, Schema, etc.)
          $serviceName = ucwords(str_replace(['-', '_'], ' ', $service ?: $title));
          $title = "$serviceName — Technical SEO for AI Search | NRLC.ai";
          $desc = "$serviceName focused on crawlability, indexing integrity, and AI-visible structure. Designed for long-term performance. Call or email.";
        }
      }
      break;
      
    case 'careers':
      if ($role && $city) {
        $roleTitle = ucwords(str_replace(['-', '_'], ' ', $role));
        $cityName = ucwords(str_replace(['-', '_'], ' ', $city));
        $title = "$roleTitle — $cityName | Careers at Neural Command";
        $desc = "Apply for $roleTitle in $cityName. Remote-friendly role with competitive salary. Responsibilities include technical documentation, SEO content, and LLM optimization guides.";
      } else {
        $roleTitle = ucwords(str_replace(['-', '_'], ' ', $role ?: $title));
        $title = "$roleTitle Jobs | Careers at Neural Command";
        $desc = "Explore $roleTitle opportunities at Neural Command. Learn about requirements, responsibilities, and how to apply for AI SEO positions.";
      }
      break;
      
    case 'insights':
    case 'article':
      // Insight articles: Informational → trust → funnel
      // Title formula: {Primary Topic}: What Actually Works | NRLC.ai
      if (!$title || strpos($title, ':') === false) {
        // If title doesn't have colon, add "What Actually Works"
        $title = $title . ': What Actually Works';
      }
      $suffix = '| NRLC.ai';
      $title = $title . ' ' . $suffix;
      
      // Description formula: practical breakdown + soft business bridge
      if ($excerpt) {
        $desc = $excerpt;
        // Ensure it ends with business bridge if not already present
        if (stripos($desc, 'call') === false && stripos($desc, 'email') === false) {
          $desc = rtrim($desc, '.') . '. If you want this done, call or email.';
        }
      } else {
        $desc = "A practical breakdown of $title, why it fails, and how to implement it correctly. If you want this done, call or email.";
      }
      break;
      
    case 'home':
      // Homepage: Brand + hireability
      $title = 'NRLC.ai — Technical SEO & AI Search Optimization';
      $desc = 'Technical SEO and AI search optimization focused on crawlability, structured data, and intent clarity. Call or email to discuss your site.';
      break;
      
    case 'insights_hub':
      // Insights hub: Discovery + authority (no commercial CTA)
      $title = 'AI Search & Technical SEO Insights | NRLC.ai';
      $desc = 'Research and analysis on AI-driven search, indexing systems, and modern technical SEO. Built to inform and guide implementation.';
      break;
      
    case 'products_hub':
      // Products hub: Collection of products (no commercial CTA in meta)
      $title = 'AI SEO Products & Tools | NRLC.ai';
      $desc = 'Complete product ecosystem for structured knowledge, AI visibility, and agentic intelligence. Explore our AI SEO tools and solutions.';
      break;
      
    default:
      $suffix = '| NRLC.ai';
      if ($excerpt) {
        $desc = $excerpt;
      } else {
        $desc = "$title on NRLC.ai. AI SEO services, structured data engineering, and LLM optimization solutions.";
      }
      $title = $title . ' ' . $suffix;
  }
  
  // Enforce length limits (SERP CONTROL: prevent Google rewrites)
  // Title: 50-60 chars target, hard max 65
  if (strlen($title) > 65) {
    $truncated = substr($title, 0, 62);
    $lastSpace = strrpos($truncated, ' ');
    $title = ($lastSpace !== false && $lastSpace > 50) ? substr($truncated, 0, $lastSpace) . '...' : $truncated . '...';
  }
  
  // Ensure title is not too short (weak signal)
  if (strlen($title) < 45) {
    // Add brand suffix if missing
    if (strpos($title, '|') === false && strpos($title, 'NRLC') === false) {
      $title = $title . ' | NRLC.ai';
    }
  }
  
  // Description: 150-165 chars target, hard max 175, min 130
  if (strlen($desc) > 175) {
    $truncated = substr($desc, 0, 172);
    $lastSpace = strrpos($truncated, ' ');
    $desc = ($lastSpace !== false && $lastSpace > 140) ? substr($truncated, 0, $lastSpace) . '...' : $truncated . '...';
  } elseif (strlen($desc) < 130) {
    // Add context if too short (weak signal)
    $desc = $desc . ' Professional AI SEO services by NRLC.ai.';
    if (strlen($desc) > 175) {
      $desc = substr($desc, 0, 172) . '...';
    }
  }
  
  // Generate canonical path if not provided
  if (!$canonicalPath) {
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    // Root stays as root, others get locale prefix
    if ($requestPath === '/' || $requestPath === '') {
      $canonicalPath = '/';
    } else {
      require_once __DIR__.'/../config/locales.php';
      if (!preg_match('#^/([a-z]{2})-([a-z]{2})(/|$)#i', $requestPath)) {
        $canonicalPath = '/'.X_DEFAULT.$requestPath;
      } else {
        $canonicalPath = $requestPath;
      }
    }
  }
  
  return [
    'title' => $title,
    'description' => $desc,
    'canonicalPath' => $canonicalPath
  ];
}

/**
 * SUDO-POWERED META DIRECTIVE (Legacy - file-based)
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

