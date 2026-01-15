<?php
// Guard all require_once calls - fail closed, not fatal
if (file_exists(__DIR__.'/../lib/helpers.php')) {
  try {
    require_once __DIR__.'/../lib/helpers.php';
  } catch (Throwable $e) {
    // Silent fail - helpers are optional
  }
}
if (file_exists(__DIR__.'/../lib/i18n.php')) {
  try {
    require_once __DIR__.'/../lib/i18n.php';
  } catch (Throwable $e) {
    // Silent fail - i18n is optional
  }
}

function route_request(): void {
  $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
  $originalPath = $path; // Save original path for redirect checks

  // /{lang}-{region}/ prefix e.g., /en-us/services/..., /ko-kr/...
  if (preg_match('#^/([a-z]{2})-([a-z]{2})/#i', $path, $m)) {
    i18n_set_locale(strtolower($m[1].'-'.$m[2]));
    $path = substr($path, strlen($m[0])-1); // keep leading slash
  } else {
    i18n_set_locale('en-us'); // default
  }

  // Favicon files - MUST be at top before other routes
  $favicon_files = [
    '/favicon.ico' => ['file' => __DIR__.'/../public/favicon.ico', 'type' => 'image/x-icon'],
    '/favicon-16x16.png' => ['file' => __DIR__.'/../public/favicon-16x16.png', 'type' => 'image/png'],
    '/favicon-32x32.png' => ['file' => __DIR__.'/../public/favicon-32x32.png', 'type' => 'image/png'],
    '/favicon-48x48.png' => ['file' => __DIR__.'/../public/favicon-48x48.png', 'type' => 'image/png'],
    '/favicon-192.png' => ['file' => __DIR__.'/../public/android-chrome-192x192.png', 'type' => 'image/png'],
    '/apple-touch-icon.png' => ['file' => __DIR__.'/../public/apple-touch-icon.png', 'type' => 'image/png'],
    '/android-chrome-192x192.png' => ['file' => __DIR__.'/../public/android-chrome-192x192.png', 'type' => 'image/png'],
    '/android-chrome-512x512.png' => ['file' => __DIR__.'/../public/android-chrome-512x512.png', 'type' => 'image/png'],
    '/site.webmanifest' => ['file' => __DIR__.'/../public/site.webmanifest', 'type' => 'application/manifest+json'],
  ];

  if (isset($favicon_files[$path])) {
    $favicon_config = $favicon_files[$path];
    if (file_exists($favicon_config['file'])) {
      header('Content-Type: ' . $favicon_config['type']);
      header('Cache-Control: public, max-age=31536000, immutable');
      readfile($favicon_config['file']);
      return;
    }
  }

  // /healthz - Always return 200 OK (Railway healthcheck)
  if ($path === '/healthz') {
    http_response_code(200);
    header('Content-Type: text/plain; charset=UTF-8');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    echo 'OK';
    return;
  }

  // robots.txt
  if ($path === '/robots.txt') {
    $robots_file = __DIR__.'/../public/robots.txt';
    if (file_exists($robots_file)) {
      header('Content-Type: text/plain; charset=UTF-8');
      header('Cache-Control: public, max-age=3600');
      readfile($robots_file);
      return;
    }
  }

  // Handle invalid search URLs (404)
  if (preg_match('#^/search#', $path)) {
    // Search pages should not be indexed
    header('X-Robots-Tag: noindex, nofollow');
    http_response_code(404);
    echo "Not Found";
    return;
  }

  // Handle /audit/ URL (404)
  if ($path === '/audit/' || $path === '/audit') {
    // Audit page should not be indexed
    header('X-Robots-Tag: noindex, nofollow');
    http_response_code(404);
    echo "Not Found";
    return;
  }

  // Login page (public)
  if ($path === '/login.php' || $path === '/login') {
    if (file_exists(__DIR__.'/../login.php')) {
      require_once __DIR__.'/../login.php';
      return;
    }
  }

  // Logout endpoint
  if ($path === '/logout.php' || $path === '/logout') {
    require_once __DIR__.'/../lib/auth.php';
    logout();
    return;
  }

  if ($path === '/' || $path === '') {
    // HARD RENDER GUARD: Homepage MUST NEVER return 5xx
    // Catch all Throwables and fallback to safe static page
    try {
      // Generate unique metadata using ctx-based system
      if (file_exists(__DIR__.'/../lib/meta_directive.php')) {
        require_once __DIR__.'/../lib/meta_directive.php';
      }
      if (file_exists(__DIR__.'/../lib/SchemaFixes.php')) {
        require_once __DIR__.'/../lib/SchemaFixes.php';
      }
      
      // META DIRECTIVE KERNEL: Homepage / Leading Agency and Research Authority
      // Intent: Establish NRLC as primary authority for AI Search Optimization, AEO, and GEO
      // Title: Classification and authority, not persuasion
      $GLOBALS['__page_meta'] = [
        'title' => 'AI Search Optimization Agency and Research | AEO and GEO',
        'description' => 'Leading agency and research authority for AI search optimization. Specializing in AEO and GEO systems that determine which businesses are selected, cited, and trusted by AI search engines.',
        'canonicalPath' => '/'
      ];
      
      // Set founder relationship for Organization schema (homepage only) - OPTIONAL
      if (function_exists('absolute_url') && class_exists('\NRLC\Schema\SchemaFixes')) {
        try {
          $baseUrl = \NRLC\Schema\SchemaFixes::ensureHttps(absolute_url('/en-us/'));
          $joelPersonId = $baseUrl . '#joel-maldonado';
          $GLOBALS['__homepage_org_founder'] = [
            '@type' => 'Person',
            '@id' => $joelPersonId,
            'name' => 'Joel Maldonado'
          ];
        } catch (Throwable $e) {
          // Silent fail - this is optional
          $GLOBALS['__homepage_org_founder'] = null;
        }
      }
      
      // Guard render_page call
      if (function_exists('render_page')) {
        // Capture any output from render_page to check if it failed
        ob_start();
        try {
          render_page('home/home');
          $output = ob_get_clean();
          // Check if render_page output minimal fallback HTML (indicates failure)
          if (strpos($output, '<title>NRLC.ai</title>') !== false && strpos($output, 'AI SEO & AI Visibility Services</h1>') !== false && strlen($output) < 500) {
            // render_page failed internally, use safe page instead
            ob_end_clean();
            throw new Exception('render_page output fallback HTML');
          }
          echo $output;
        } catch (Throwable $e) {
          ob_end_clean();
          throw $e;
        }
      } else {
        // Fallback if render_page doesn't exist
        throw new Exception('render_page function not found');
      }
      return;
    } catch (Throwable $e) {
      // LOG ERROR FOR DEBUGGING
      error_log("HOMEPAGE RENDER ERROR: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
      error_log("Stack trace: " . $e->getTraceAsString());
      
      // FALLBACK: Always return 200 with safe static page
      http_response_code(200);
      $safePage = __DIR__.'/../pages/home/home_safe.php';
      if (file_exists($safePage)) {
        include $safePage;
      } else {
        // Ultimate fallback - minimal HTML
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!DOCTYPE html><html><head><title>AI SEO Services | NRLC.ai</title><meta charset="UTF-8"></head><body><h1>AI SEO & AI Visibility Services</h1><p>Professional AI SEO services. Email: hirejoelm@gmail.com | Phone: +1-844-568-4624</p></body></html>';
      }
      return;
    }
  }

  // Training routes (META DIRECTIVE: Training & Classes Offering)
  // Training is education, not services. Uses Course/EducationalOccupationalProgram schema, NOT Service.
  
  // /training/ - Training hub
  if ($path === '/training/' || $path === '/training') {
    render_page('training/index');
    return;
  }
  
  // /training/one-on-one/ - One-on-one training
  if ($path === '/training/one-on-one/' || $path === '/training/one-on-one') {
    render_page('training/one-on-one');
    return;
  }
  
  // Existing training page (legacy)
  if ($path === '/training/ai-search-systems/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'training/ai-search-systems',
      'canonicalPath' => '/training/ai-search-systems/'
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    // Override meta for training page
    $GLOBALS['__page_meta']['title'] = 'Training Marketing & SEO Teams for AI Search | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Technical training for marketing and SEO teams on how LLMs ingest web content, vector representations, and structured information for AI search systems.';
    render_page('training/ai-search-systems');
    return;
  }

  if (preg_match('#^/services/([^/]+)/$#', $path, $m)) {
    $_GET['service'] = $m[1];
    
    // TIER 0: Enterprise Schema Markup Services (authoritative answer for "what agencies specialize in enterprise-level schema markup")
    if ($m[1] === 'enterprise-schema-markup') {
      $GLOBALS['__page_meta'] = [
        'title' => 'Enterprise Schema Markup Implementation Services | NRLC.ai',
        'description' => 'Enterprise-level schema markup implementation with governance, validation, automation, and compliance. Specialized agency for large-scale structured data systems.',
        'canonicalPath' => $path
      ];
      render_page('services/enterprise-schema-markup');
      return;
    }
    
    // Shopify AI SEO Service
    if ($m[1] === 'shopify-ai-seo') {
      $GLOBALS['__page_meta'] = [
        'title' => 'Shopify AI SEO, AEO & GEO Optimization | NRLC.ai',
        'description' => 'Shopify AI SEO services optimized for Google AI Overviews, ChatGPT, Claude, and Perplexity. Fix canonical failures, schema conflicts, and retrieval shape issues that prevent Shopify stores from being cited by AI systems.',
        'canonicalPath' => $path
      ];
      render_page('services/shopify-ai-seo');
      return;
    }
    
    // SUDO CANONICAL: Special handling for AI Overviews Optimization
    if ($m[1] === 'ai-overviews-optimization') {
      $GLOBALS['__page_meta'] = [
        'title' => 'AI Overview Optimization for Google AI Search | Neural Command',
        'description' => 'Explains how Google AI Overviews select sources, what makes content citable by AI systems, and how websites optimize for AI-generated answers.',
        'canonicalPath' => $path
      ];
      render_page('services/service');
      return;
    }
    
    // Tier 1 Reinforcement: Custom Norwich page
    if ($m[1] === 'ai-seo-norwich') {
      $GLOBALS['__page_meta'] = [
        'title' => 'AI SEO & AI Visibility Services in Norwich | NRLC.ai',
        'description' => 'AI SEO and AI visibility services for businesses in Norwich. Improve visibility across Google Search, Google AI Overviews, and AI-driven platforms like ChatGPT. Remote delivery.',
        'canonicalPath' => $path
      ];
      render_page('services/ai-seo-norwich');
      return;
    }
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    require_once __DIR__.'/../lib/service_intent_taxonomy.php';
    $serviceSlug = $m[1];
    $serviceTitle = ucfirst(str_replace(['-', '_'], ' ', $serviceSlug));
    
    $ctx = [
      'type' => 'service',
      'slug' => 'services/service',
      'service' => $serviceTitle,
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    // Override with intent taxonomy meta (CLASS 1: Core Service or CLASS 4: Audit)
    // service_meta_title() already includes | NRLC.ai
    $GLOBALS['__page_meta']['title'] = service_meta_title($serviceSlug, null);
    $GLOBALS['__page_meta']['description'] = service_meta_description($serviceSlug, null);
    
    render_page('services/service');
    return;
  }

  // CRITICAL: Service-city pattern MUST come before 404 handler
  // Pattern matches: /services/{service}/{city}/ (after locale stripping)
  // BUT: If originalPath had no locale prefix, redirect to locale-prefixed URL
  if (preg_match('#^/services/([^/]+)/([^/]+)/$#', $path, $m)) {
    // Check if original path had locale prefix (before stripping)
    $hadLocale = preg_match('#^/([a-z]{2})-([a-z]{2})/#i', $originalPath);
    
    // If no locale in original path, redirect to locale-prefixed URL
    if (!$hadLocale) {
      $serviceSlug = $m[1];
      $citySlug = $m[2];
      
      // Determine locale based on city (UK cities → en-gb, others → en-us)
      require_once __DIR__.'/../lib/helpers.php';
      $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
      $locale = $isUK ? 'en-gb' : 'en-us';
      
      $queryString = !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
      $redirectUrl = '/' . $locale . '/services/' . $serviceSlug . '/' . $citySlug . '/';
      header("Location: " . absolute_url($redirectUrl) . $queryString, true, 301);
      exit;
    }
    
    // Continue with normal service-city processing (locale was in original path)
    $_GET['service'] = $m[1];
    $_GET['city']    = $m[2];
    
    // DEBUG: Log that we matched this pattern
    error_log("ROUTER: Matched service-city pattern: service={$m[1]}, city={$m[2]}, path={$path}");
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    require_once __DIR__.'/../lib/helpers.php';
    require_once __DIR__.'/../lib/content_tokens.php';
    $serviceSlug = $m[1];
    $citySlug = $m[2];
    $serviceTitle = ucfirst(str_replace('-',' ', $serviceSlug));
    $cityTitle = function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-','_'],' ',$citySlug));
    
    // Get current locale BEFORE any redirects
    $currentLocale = function_exists('current_locale') ? current_locale() : 'en-us';
    if (!$currentLocale || !preg_match('#^[a-z]{2}-[a-z]{2}$#', $currentLocale)) {
      // Fallback: detect from original request URI
      $originalPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      if (preg_match('#^/([a-z]{2})-([a-z]{2})/#i', $originalPath, $localeMatch)) {
        $currentLocale = strtolower($localeMatch[1].'-'.$localeMatch[2]);
      } else {
        $currentLocale = 'en-us';
      }
    }
    
    // CANONICAL ENFORCEMENT: Redirect query-based URLs to clean URLs
    // Prevents GSC "alternate page with proper canonical tag" issues
    if (!empty($_GET['service']) || !empty($_GET['city'])) {
      $cleanUrl = '/' . $currentLocale . '/services/' . $serviceSlug . '/' . $citySlug . '/';
      if ($_SERVER['REQUEST_URI'] !== $cleanUrl) {
        header("Location: " . absolute_url($cleanUrl), true, 301);
        exit;
      }
    }

    // Check if UK city - if so, enforce en-gb locale
    $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
    $currentLocale = current_locale();

    if ($isUK && $currentLocale !== 'en-gb') {
      // UK city detected but wrong locale - redirect to en-gb
      // PRESERVE SERVICE TYPE - do not force to local-seo-ai
      $canonical = '/en-gb/services/' . $serviceSlug . '/' . $citySlug . '/';
      header("Location: " . absolute_url($canonical), true, 301);
      exit;
    }
    
    // Use actual request path (includes locale prefix) for canonical
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    
    // SPECIAL HANDLING: local-seo-ai uses Prechunking SEO structure + conversion optimization
    if ($serviceSlug === 'local-seo-ai') {
      $ctx = [
        'type' => 'service',
        'slug' => "services/service_local_seo_ai_city",
        'service' => $serviceSlug,
        'city' => $citySlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      // INTENT TAXONOMY: Use intent-based meta (formula: {Service} in {Location} | {Modifier})
      require_once __DIR__.'/../lib/service_intent_taxonomy.php';
      // service_meta_title() already includes | NRLC.ai
      $GLOBALS['__page_meta']['title'] = service_meta_title($serviceSlug, $citySlug);
      $GLOBALS['__page_meta']['description'] = service_meta_description($serviceSlug, $citySlug);
      
      render_page('services/service_local_seo_ai_city');
      return;
    }
    
    // INTENT TAXONOMY: Use service intent taxonomy for meta generation
    require_once __DIR__.'/../lib/service_intent_taxonomy.php';
    
    // SPECIAL HANDLING: site-audits uses specialized conversion-focused template
    if ($serviceSlug === 'site-audits') {
      $ctx = [
        'type' => 'service',
        'slug' => "services/service_city_audit",
        'service' => $serviceSlug,
        'city' => $citySlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      // Override with intent taxonomy meta (formula: {Service} in {Location} | {Modifier})
      // service_meta_title() already includes | NRLC.ai
      $GLOBALS['__page_meta']['title'] = service_meta_title($serviceSlug, $citySlug);
      $GLOBALS['__page_meta']['description'] = service_meta_description($serviceSlug, $citySlug);
      
      render_page('services/service_city_audit');
      return;
    }
    
    $ctx = [
      'type' => 'service',
      'slug' => "services/service_city",
      'service' => $serviceSlug, // Pass slug, not title
      'city' => $citySlug, // Pass slug, not title
      'canonicalPath' => $actualPath // Use actual request path (includes locale prefix)
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    // Override with intent taxonomy meta (formula: {Service} in {Location} | {Modifier})
    // Ensure locale is available for meta generation (router sets it, but ensure it persists)
    if (!isset($GLOBALS['locale'])) {
      // Fallback: detect from original request URI
      $originalPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      if (preg_match('#^/([a-z]{2})-([a-z]{2})/#i', $originalPath, $m)) {
        $GLOBALS['locale'] = strtolower($m[1].'-'.$m[2]);
      } else {
        $GLOBALS['locale'] = 'en-us';
      }
    }
    // service_meta_title() already includes | NRLC.ai
    try {
      $GLOBALS['__page_meta']['title'] = service_meta_title($serviceSlug, $citySlug);
      $GLOBALS['__page_meta']['description'] = service_meta_description($serviceSlug, $citySlug);
    } catch (Throwable $e) {
      // Fallback if service intent taxonomy fails
      error_log("Service meta generation failed for {$serviceSlug}/{$citySlug}: " . $e->getMessage());
      $GLOBALS['__page_meta']['title'] = ucwords(str_replace('-', ' ', $serviceSlug)) . ' in ' . ucwords(str_replace('-', ' ', $citySlug)) . ' | NRLC.ai';
      $GLOBALS['__page_meta']['description'] = "Professional {$serviceSlug} services in {$citySlug}. Improve search rankings and AI visibility.";
    }
    
    // CRITICAL: Always render the page, never return 404 for service-city URLs
    // Even if render_page fails, we output a basic page with 200 status
    try {
      if (function_exists('render_page')) {
        render_page('services/service_city');
      } else {
        // Fallback if render_page doesn't exist
        error_log("CRITICAL: render_page function not found for service-city page");
        http_response_code(200);
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!DOCTYPE html><html><head><title>' . htmlspecialchars($GLOBALS['__page_meta']['title'] ?? ucwords(str_replace('-', ' ', $serviceSlug)) . ' in ' . ucwords(str_replace('-', ' ', $citySlug))) . ' | NRLC.ai</title></head><body><h1>' . htmlspecialchars($GLOBALS['__page_meta']['title'] ?? ucwords(str_replace('-', ' ', $serviceSlug)) . ' in ' . ucwords(str_replace('-', ' ', $citySlug))) . '</h1><p>' . htmlspecialchars($GLOBALS['__page_meta']['description'] ?? '') . '</p></body></html>';
      }
    } catch (Throwable $e) {
      // Log error but ALWAYS return 200, never 404
      error_log("CRITICAL: Service city page render failed for {$serviceSlug}/{$citySlug}: " . $e->getMessage());
      error_log("Stack trace: " . $e->getTraceAsString());
      // Render a basic service page with 200 status (NOT 404)
      http_response_code(200);
      header('Content-Type: text/html; charset=UTF-8');
      $fallbackTitle = ($GLOBALS['__page_meta']['title'] ?? null) ?: ucwords(str_replace('-', ' ', $serviceSlug)) . ' in ' . ucwords(str_replace('-', ' ', $citySlug)) . ' | NRLC.ai';
      $fallbackDesc = $GLOBALS['__page_meta']['description'] ?? "Professional {$serviceSlug} services in {$citySlug}. Improve search rankings and AI visibility.";
      echo '<!DOCTYPE html><html><head><title>' . htmlspecialchars($fallbackTitle) . '</title><meta name="description" content="' . htmlspecialchars($fallbackDesc) . '"></head><body><h1>' . htmlspecialchars($fallbackTitle) . '</h1><p>' . htmlspecialchars($fallbackDesc) . '</p></body></html>';
    }
    return;
  }

  // Handle career pages with city only (redirect to careers index)
  if (preg_match('#^/careers/([^/]+)/$#', $path, $m)) {
    // Redirect city-only career URLs to careers index
    // These URLs don't have a role slug, so they're invalid
    // Determine canonical locale based on city (UK cities → en-gb, others → en-us)
    $citySlug = $m[1];
    require_once __DIR__.'/../lib/helpers.php';
    // Check if UK city to determine correct locale
    $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
    $canonicalLocale = $isUK ? 'en-gb' : 'en-us';
    $careersIndex = '/' . $canonicalLocale . '/careers/';
    header("Location: " . absolute_url($careersIndex), true, 301);
    exit;
  }

  if (preg_match('#^/careers/([^/]+)/([^/]+)/$#', $path, $m)) {
    $_GET['city'] = $m[1];
    $_GET['role'] = $m[2];
    
    $citySlug = $m[1];
    $roleSlug = $m[2];
    
    // TIER 0 HUB: Use definition-first template for LLM Strategist
    if ($roleSlug === 'llm-strategist') {
      require_once __DIR__.'/../lib/meta_directive.php';
      $cityTitle = ucwords(str_replace(['-', '_'], ' ', $citySlug));
      
      $ctx = [
        'type' => 'careers',
        'slug' => "careers/llm_strategist_hub",
        'title' => "LLM Strategist",
        'excerpt' => "An LLM Strategist designs and runs the systems that influence how large language models retrieve, cite, and summarize information about a brand, product, or topic across AI answer engines.",
        'city' => $cityTitle,
        'role' => 'LLM Strategist',
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      render_page('careers/llm_strategist_hub');
      return;
    }
    
    // Standard career page for other roles
    require_once __DIR__.'/../lib/meta_directive.php';
    $cityTitle = ucwords(str_replace(['-', '_'], ' ', $citySlug));
    $roleTitle = ucwords(str_replace(['-', '_'], ' ', $roleSlug));
    
    $ctx = [
      'type' => 'careers',
      'slug' => "careers/career_city",
      'title' => "$roleTitle in $cityTitle",
      'excerpt' => "Apply for $roleTitle in $cityTitle. Remote-friendly role with competitive salary. Responsibilities include technical documentation, SEO content, and LLM optimization guides.",
      'city' => $cityTitle,
      'role' => $roleTitle,
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('careers/career_city');
    return;
  }

  // Handle nested insights paths (e.g., /insights/glossary/llm-strategist/)
  if (preg_match('#^/insights/([^/]+)/([^/]+)/$#', $path, $m)) {
    $category = $m[1];
    $articleSlug = $m[2];
    // Handle glossary/llm-strategist
    if ($category === 'glossary' && $articleSlug === 'llm-strategist') {
      $_GET['slug'] = 'glossary/llm-strategist';
      // Fix: Add proper 404 handling for non-existent glossary terms
    } elseif ($category === 'glossary') {
      // Return 404 for glossary terms that don't exist
      header('X-Robots-Tag: noindex, nofollow');
      http_response_code(404);
      echo "Glossary term not found";
      return;
      $slug = 'glossary/llm-strategist';
    } else {
      // Other nested paths - treat as regular insight
      $_GET['slug'] = $category . '/' . $articleSlug;
      $slug = $category . '/' . $articleSlug;
    }
  } elseif (preg_match('#^/insights/([^/]+)/$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    $slug = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $articleTitle = ucwords(str_replace(['-', '_'], ' ', $slug));
    
    // Special handling for specific articles
    if ($slug === 'content-chunking-seo') {
      $articleTitle = "Content Chunking for SEO: How to Structure Content for Readability and AI";
      $excerpt = "Learn how to structure content into digestible, scannable chunks that improve readability, SEO, and AI parsing.";
    } elseif ($slug === 'prechunking-content-ai-retrieval') {
      $articleTitle = "Prechunking Content for AI Retrieval, AI Overviews, and LLM Citation";
      $excerpt = "Learn how to structure content before writing so each section can be independently retrieved and cited by AI systems.";
    } elseif ($slug === 'ai-retrieval-llm-citation') {
      $articleTitle = "How LLMs Retrieve and Cite Web Content";
      $excerpt = "Understand how AI systems extract, score, and surface content for answers and citations.";
    } elseif ($slug === 'semantic-constraint-medical-information-retrieval') {
      $articleTitle = "Semantic Constraint in Medical Information Retrieval | Medical Schema Governance";
      $excerpt = "Technical analysis of structured medical data as a constraint mechanism for regulated information retrieval systems. Learn how Schema.org medical extensions function as semantic governance interfaces for pharmaceutical organizations, regulatory workflows, and AI answer synthesis systems.";
    } elseif ($slug === 'how-to-get-your-business-mentioned-in-chatgpt') {
      $articleTitle = "How to Get Your Business Mentioned in ChatGPT | AI Citation Guide";
      $excerpt = "Learn what signals matter for your business to be mentioned in ChatGPT, including entity consistency, structured data, and citation readiness.";
    } elseif ($slug === 'google-llms-txt-ai-seo') {
      $articleTitle = "Google LLMs.txt Documentation Analysis & SEO Strategy";
      $excerpt = "Google's llms.txt reveals how Google trains LLMs on Search. Turn that blueprint into executable AI SEO strategy, structured data, and technical SEO.";
    } elseif ($slug === 'semantic-queries') {
      $articleTitle = "Semantic Query Optimization for AI Systems";
      $excerpt = "Learn how semantic queries improve retrieval performance with relationship traversal, compare SQL joins vs graph traversal, and view failure modes and performance metrics.";
    } elseif ($slug === 'semantic-modeling') {
      $articleTitle = "Why Teams Adopt Semantic Modeling";
      $excerpt = "Understanding the business value of semantic infrastructure. How organizations achieve 90% reduction in time-to-consumption and enable reliable AI workflows.";
    } elseif ($slug === 'data-virtualization') {
      $articleTitle = "Data Virtualization";
      $excerpt = "How data virtualization enables unified access to distributed data sources without physical data movement, reducing complexity and improving agility.";
    } elseif ($slug === 'performance-caching') {
      $articleTitle = "Performance Caching for AI & Semantic Systems";
      $excerpt = "A technical guide to performance caching in AI and semantic systems, including latency targets, caching layers, checklists, and failure modes for scalable retrieval.";
    } elseif ($slug === 'enterprise-llm') {
      $articleTitle = "Enterprise LLM Architecture & Governance";
      $excerpt = "Detailed guide to enterprise LLM architecture, governance, provenance tracking, and performance thresholds for reliable AI systems.";
    } elseif ($slug === 'knowledge-graph') {
      $articleTitle = "Knowledge Graph Exploration";
      $excerpt = "Interactive knowledge graph techniques for traversing relationships, surfacing insights, and generating SQL or natural-language queries automatically.";
    } elseif ($slug === 'google-llms-txt-ai-seo') {
      $articleTitle = "Google LLMs.txt Documentation Analysis & SEO Strategy";
      $excerpt = "Google's llms.txt reveals how Google trains LLMs on Search. Turn that blueprint into executable AI SEO strategy, structured data, and technical SEO.";
        } elseif ($slug === 'silent-hydration-seo') {
          $articleTitle = "The Silent Killer of Search Rankings: How Hydration Failure Is Breaking Modern SEO";
          $excerpt = "For years, companies have poured millions into content, backlinks, site speed, and technical optimization—yet their rankings remained stubbornly flat. The culprit? Hydration failure.";
        } elseif ($slug === 'tool-reviews') {
          $articleTitle = "AI SEO Tool Reviews: Comprehensive Platform Analysis";
          $excerpt = "Comprehensive analysis of AI SEO tools and platforms, evaluating features, performance, and optimization capabilities for modern search engine optimization.";
        } elseif ($slug === 'open-seo-tools') {
          $articleTitle = "Open Source SEO Tools - Free Tools for AI Optimization";
          $excerpt = "A comprehensive guide to open-source SEO tools that provide real value for AI-first optimization, including practical implementations and integrations with NRLC.ai's services for maximum impact.";
        } elseif ($slug === 'indexing-suppression-paid-search') {
          $articleTitle = "Indexing Suppression, Perceived Page Quality, and Indirect Effects on Paid Search Auction Dynamics";
          $excerpt = "This paper examines whether page indexing behavior influences perceived page quality and indirectly affects keyword costs within Google Ads auctions. While indexing status is not a direct input into paid auction pricing, structural signals leading to indexing suppression overlap with those used to evaluate landing page experience.";
        } elseif ($slug === 'enterprise-schema-markup') {
          $articleTitle = "Enterprise Schema Markup: What It Actually Means";
          $excerpt = "What enterprise-level schema markup actually means and why most agencies cannot deliver it at scale. Characteristics of real enterprise schema agencies.";
        } elseif ($slug === 'schema-governance-and-validation') {
          $articleTitle = "Schema Governance & Validation: Managing Risk at Scale";
          $excerpt = "Enterprise schema governance and validation processes that prevent costly errors and ensure compliance. Risk management for large-scale structured data systems.";
        } elseif ($slug === 'grounding-budgets-prechunking') {
          $articleTitle = "Grounding Budgets, Prechunking, and Generative Search Visibility";
          $excerpt = "How fixed grounding budgets and fragment-level retrieval shape generative search visibility.";
        } else {
          $excerpt = null; // Will be generated by meta_directive
        }
    
    // Use actual request path for canonical (includes locale prefix)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    
    $ctx = [
      'type' => 'insights',
      'slug' => "insights/$slug",
      'title' => $articleTitle, // Will be formatted as "{Title}: What Actually Works | NRLC.ai"
      'excerpt' => $excerpt, // Will have business bridge appended if not present
      'canonicalPath' => $actualPath // Use actual request path (includes /en-us/)
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('insights/article');
    return;
  }

  // Demo routes
  if ($path === '/demo/progress-demo/') {
    render_page('demo/progress-demo');
    return;
  }

  // Sitemap routes
  if (preg_match('#^/sitemaps/([^/]+)$#', $path, $m)) {
    $sitemap_file = __DIR__.'/../public/sitemaps/'.$m[1];
    if (file_exists($sitemap_file)) {
      header('Content-Type: application/xml; charset=UTF-8');
      header('Cache-Control: public, max-age=3600');
      readfile($sitemap_file);
      return;
    }
  }
  
  // Sitemap index route
  if ($path === '/sitemap.xml' || $path === '/sitemap.xml/') {
    $sitemap_index = __DIR__.'/../public/sitemaps/sitemap-index.xml';
    if (file_exists($sitemap_index)) {
      header('Content-Type: application/xml; charset=UTF-8');
      header('Cache-Control: public, max-age=3600');
      readfile($sitemap_index);
      return;
    }
  }

  // Book page route (GET/HEAD requests to /api/book/ or /api/book) - BLOCKED: Governance violation
  // Direct booking endpoints are NOT permitted before intent qualification
  // Endpoint is POST-only for form submissions, GET/HEAD requests blocked
  if (($path === '/api/book/' || $path === '/api/book') && ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'HEAD')) {
    // Redirect /api/book to /api/book/ for consistency
    if ($path === '/api/book') {
      $queryString = count($_GET) ? '?'.http_build_query($_GET) : '';
      $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
      $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
      $redirectUrl = $scheme.'://'.$host.'/api/book/'.$queryString;
      header("Location: $redirectUrl", true, 301);
      exit;
    }
    http_response_code(403);
    header('Content-Type: application/json');
    header('X-Robots-Tag: noindex, nofollow'); // Prevent indexing of API endpoints
    if ($_SERVER['REQUEST_METHOD'] !== 'HEAD') {
      echo json_encode(['ok' => false, 'error' => 'Direct access not permitted. Please use the contact form.']);
    }
    exit;
  }

  // Book API route (POST requests to /api/book/ or /api/book)
  if (($path === '/api/book/' || $path === '/api/book') && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('X-Robots-Tag: noindex, nofollow'); // Prevent indexing of API endpoints
    $api_file = __DIR__.'/../api/book.php';
    if (file_exists($api_file)) {
      include $api_file;
      return;
    }
  }

  // Other API routes - Add noindex to prevent indexing
  if (preg_match('#^/api/([^/]+)/?$#', $path, $m)) {
    header('X-Robots-Tag: noindex, nofollow'); // Prevent indexing of API endpoints
    $api_file = __DIR__.'/../api/'.$m[1].'.php';
    if (file_exists($api_file)) {
      include $api_file;
      return;
    }
  }

  // Book page route - handle /book/ (canonical)
  // Note: /booking/ is redirected to /book/ by canonical guard
  if ($path === '/book/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'book/index',
      'title' => 'Book AI SEO Consultation | NRLC.ai',
      'excerpt' => 'Schedule a consultation with NRLC.ai experts for AI-first SEO strategy, GEO-16 framework implementation, and LLM optimization.',
      'canonicalPath' => $actualPath // Use actual path with locale prefix
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('book/index');
    return;
  }

  // Contact page route - redirect to homepage with contact modal trigger
  if ($path === '/contact/') {
    $queryString = count($_GET) ? '?'.http_build_query($_GET) : '';
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
      $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
    }
    $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
    // Use current locale or default to en-us
    $currentLocale = function_exists('current_locale') ? current_locale() : 'en-us';
    if (!$currentLocale || !preg_match('#^[a-z]{2}-[a-z]{2}$#', $currentLocale)) {
      $currentLocale = 'en-us';
    }
    $redirectUrl = $scheme.'://'.$host.'/'.$currentLocale.'/?contact=1'.$queryString;
    header("Location: $redirectUrl", true, 301);
    exit;
  }

  // About index page - redirect to homepage (no general about page exists)
  if ($path === '/about/') {
    header('X-Robots-Tag: noindex, nofollow'); // Don't index redirect pages
    http_response_code(404);
    echo "Not Found";
    return;
  }

  // About pages
  if (preg_match('#^/about/([^/]+)/$#', $path, $m)) {
    $aboutSlug = $m[1];
    if ($aboutSlug === 'llm-strategy-team') {
      require_once __DIR__.'/../lib/meta_directive.php';
      $ctx = [
        'type' => 'about',
        'slug' => "about/llm-strategy-team",
        'title' => "LLM Strategy Team",
        'excerpt' => "The LLM Strategy team at NRLC.ai defines the methodology, frameworks, and best practices for LLM Strategist roles.",
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('about/llm-strategy-team');
      return;
    }
    // If about slug doesn't match, return 404
    header('X-Robots-Tag: noindex, nofollow');
    http_response_code(404);
    echo "Not Found";
    return;
  }

  // Fix: Handle /en-us/about/ and similar locale about URLs
  if (preg_match('#^/([a-z]{2}-[a-z]{2})/about/$#', $path, $m)) {
    $locale = $m[1];
    // Redirect locale about URLs to the about index
    header("Location: " . absolute_url('/about/'), true, 301);
    exit;
  }

  // Index pages
  if ($path === '/careers/') {
    render_page('careers/index');
    return;
  }

  // AI Optimization Category Anchor (META DIRECTIVE KERNEL: Category Authority)
  // Intent: Machines-first category definition
  // Title: Declarative, zero persuasion
  if ($path === '/ai-optimization/') {
    $GLOBALS['__page_meta'] = [
      'title' => 'AI Optimization: Definition, Mechanism, and Scope',
      'description' => 'AI Optimization is the discipline of structuring content, data, and systems so they can be retrieved, understood, and cited by AI search engines, AI Overviews, and LLM answer systems. This page defines what AI Optimization is, what it is not, and how it differs from SEO, ML optimization, and automation.',
      'canonicalPath' => '/ai-optimization/'
    ];
    render_page('ai-optimization/index');
    return;
  }

  // GEO Routes
  if ($path === '/generative-engine-optimization/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale if present)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/index',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Generative Engine Optimization Guide | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Complete guide to GEO: how generative engines retrieve information, why traditional SEO fails, and how to structure content for AI retrieval and citation.';
    render_page('generative-engine-optimization/index');
    return;
  }

  if ($path === '/generative-engine-optimization/failure-modes/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/failure-modes/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'GEO Failure Modes: Why Content Disappears | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Observable failure patterns that cause content to disappear from AI-generated answers. Each failure mode documents mechanics, triggers, and mitigation.';
    render_page('generative-engine-optimization/failure-modes/index');
    return;
  }

  // Decision Traces page
  if ($path === '/generative-engine-optimization/decision-traces/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale if present)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/decision-traces',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Decision Traces in Generative Search';
    $GLOBALS['__page_meta']['description'] = 'An operational framework for understanding how generative search systems decide what information to retrieve, cite, or suppress. Grounded in observable system behavior, not speculation.';
    render_page('generative-engine-optimization/decision-traces');
    return;
  }

  // Extractability page
  if ($path === '/generative-engine-optimization/extractability/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale if present)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/extractability',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Extractability in Generative Search';
    $GLOBALS['__page_meta']['description'] = 'Extractability is the degree to which content can be isolated, compressed, and reused by generative systems without semantic loss, enabling retrieval and citation in AI search.';
    render_page('generative-engine-optimization/extractability');
    return;
  }

  // Inference Context Stability page
  if ($path === '/generative-engine-optimization/inference-context-stability/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale if present)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/inference-context-stability',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Inference Context Stability in Generative Search';
    $GLOBALS['__page_meta']['description'] = 'Inference context stability describes whether a generative system infers the same meaning from content segments across different prompts, queries, and retrieval contexts, enabling reliable reuse and citation.';
    render_page('generative-engine-optimization/inference-context-stability');
    return;
  }

  // Confidence Band Filtering page
  if ($path === '/generative-engine-optimization/confidence-band-filtering/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale if present)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/confidence-band-filtering',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Confidence Band Filtering in Generative Search';
    $GLOBALS['__page_meta']['description'] = 'Confidence band filtering describes how generative systems exclude content that falls below an internal confidence threshold for reuse, creating a gate between retrieval and citation.';
    render_page('generative-engine-optimization/confidence-band-filtering');
    return;
  }

  // Compression Integrity page
  if ($path === '/generative-engine-optimization/compression-integrity/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale if present)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'page',
      'slug' => 'generative-engine-optimization/compression-integrity',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Compression Integrity in Generative Search';
    $GLOBALS['__page_meta']['description'] = 'Compression integrity describes whether content segments preserve their meaning when generative systems compress them for inference and reuse, determining semantic survivability under abstraction.';
    render_page('generative-engine-optimization/compression-integrity');
    return;
  }

  // GEO Failure Mode Pages
  if (preg_match('#^/generative-engine-optimization/failure-modes/([^/]+)/$#', $path, $m)) {
    $failureModeSlug = $m[1];
    $failureModeFile = __DIR__.'/../pages/generative-engine-optimization/failure-modes/'.$failureModeSlug.'.php';
    if (file_exists($failureModeFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      $ctx = [
        'type' => 'page',
        'slug' => 'generative-engine-optimization/failure-modes/'.$failureModeSlug,
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      // Generate SEO-optimized title from slug (30-60 chars)
      $failureModeName = ucwords(str_replace(['-', '_'], ' ', $failureModeSlug));
      $title = "$failureModeName: GEO Failure Mode | NRLC.ai";
      if (strlen($title) > 60) {
        $title = "$failureModeName Failure Mode | NRLC.ai";
      }
      if (strlen($title) < 30) {
        $title = "$failureModeName: Failure Mode Guide | NRLC.ai";
      }
      $GLOBALS['__page_meta']['title'] = $title;
      
      render_page('generative-engine-optimization/failure-modes/'.$failureModeSlug);
      return;
    }
  }

  // AI Search System Routes
  // META DIRECTIVE KERNEL: /ai-search-diagnostics/
  // Intent: Problem diagnosis + failure identification
  // Title: Symptom-first, system-aware
  if ($path === '/ai-search-diagnostics/') {
    $GLOBALS['__page_meta'] = [
      'title' => 'AI Search Diagnostics: Identifying Retrieval and Citation Failures',
      'description' => 'Diagnostic frameworks for sites visible in traditional search but absent from AI answers, covering retrieval gaps, structural blockers, and citation suppression patterns.',
      'canonicalPath' => $path
    ];
    render_page('ai-search-diagnostics/index');
    return;
  }

  // META DIRECTIVE KERNEL: /en-us/ai-search-measurement/
  // Intent: Measurement and validation
  // Title: Measurement clarity over metrics hype
  if ($path === '/ai-search-measurement/') {
    $GLOBALS['__page_meta'] = [
      'title' => 'Measuring AI Search Visibility and Citation Presence',
      'description' => 'Methods for evaluating whether content is retrieved, summarized, or cited by AI systems, beyond impressions and traditional ranking metrics.',
      'canonicalPath' => $path
    ];
    render_page('ai-search-measurement/index');
    return;
  }

  if ($path === '/ai-search-strategy/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'ai-search-strategy/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Search Strategy in the Generative Era | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Calm, sober assessment of what SEO controls, what it lost, and how teams should adapt. Non-predictive, non-hype strategic guidance.';
    render_page('ai-search-strategy/index');
    return;
  }

  if ($path === '/ai-search-operations/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'ai-search-operations/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Operating SEO in an AI-Mediated Search Environment | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'What to stop doing, what to keep doing, and what signals generative engines ignore. Operational guidance for SEO teams.';
    render_page('ai-search-operations/index');
    return;
  }

  if ($path === '/ai-search-migrations/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'ai-search-migrations/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Rebuilding Content for Generative Retrieval | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Step-by-step procedural guides for restructuring, migrating, and rebuilding content for AI retrieval. People will follow these line-by-line.';
    render_page('ai-search-migrations/index');
    return;
  }

  if ($path === '/ai-search-risk/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'ai-search-risk/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Managing Risk in AI-Mediated Search | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Brand protection, governance, and institutional trust in AI-mediated search. Enterprise risk management for AI citations and visibility.';
    render_page('ai-search-risk/index');
    return;
  }

  if ($path === '/ai-search-tools-reality/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'ai-search-tools-reality/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'The Limits of SEO Tooling in AI Search | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Honest assessment of what SEO tools can and cannot see in AI-mediated search. Prevents false expectations and builds credibility.';
    render_page('ai-search-tools-reality/index');
    return;
  }

  if ($path === '/field-notes/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'field-notes/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Field Notes: AI Search Behavior Observations | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Observational notes on AI search behavior. Written as "We observed X behavior across Y surfaces under Z constraints." No speculation or predictions.';
    render_page('field-notes/index');
    return;
  }

  if ($path === '/glossary/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'glossary/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'AI Search Glossary: Terms & Definitions | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics. Stabilizes terminology across the site and for LLMs.';
    render_page('glossary/index');
    return;
  }

  // AI Search Diagnostics sub-pages
  if (preg_match('#^/ai-search-diagnostics/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-diagnostics/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-diagnostics/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      // Generate SEO-optimized title from slug (30-60 chars)
      $pageName = ucwords(str_replace(['-', '_'], ' ', $pageSlug));
      $title = "$pageName: Diagnostic Guide | NRLC.ai";
      if (strlen($title) > 60) {
        $title = "$pageName Diagnostic | NRLC.ai";
      }
      if (strlen($title) < 30) {
        $title = "$pageName: Complete Diagnostic Guide | NRLC.ai";
      }
      $GLOBALS['__page_meta']['title'] = $title;
      
      // Ensure description is within 120-160 chars
      if (isset($GLOBALS['__page_meta']['description']) && strlen($GLOBALS['__page_meta']['description']) > 160) {
        $GLOBALS['__page_meta']['description'] = substr($GLOBALS['__page_meta']['description'], 0, 157) . '...';
      }
      
      render_page('ai-search-diagnostics/'.$pageSlug);
      return;
    }
  }

  // AI Search Measurement sub-pages
  if (preg_match('#^/ai-search-measurement/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-measurement/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-measurement/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-search-measurement/'.$pageSlug);
      return;
    }
  }

  // AI Search Strategy sub-pages
  if (preg_match('#^/ai-search-strategy/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-strategy/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-strategy/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-search-strategy/'.$pageSlug);
      return;
    }
  }

  // AI Search Operations sub-pages
  if (preg_match('#^/ai-search-operations/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-operations/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-operations/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-search-operations/'.$pageSlug);
      return;
    }
  }

  // AI Search Migrations sub-pages
  if (preg_match('#^/ai-search-migrations/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-migrations/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-migrations/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-search-migrations/'.$pageSlug);
      return;
    }
  }

  // AI Search Risk sub-pages
  if (preg_match('#^/ai-search-risk/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-risk/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-risk/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-search-risk/'.$pageSlug);
      return;
    }
  }

  // AI Search Tools Reality sub-pages
  if (preg_match('#^/ai-search-tools-reality/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/ai-search-tools-reality/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'ai-search-tools-reality/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-search-tools-reality/'.$pageSlug);
      return;
    }
  }

  // Field Notes sub-pages
  if (preg_match('#^/field-notes/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/field-notes/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'field-notes/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('field-notes/'.$pageSlug);
      return;
    }
  }

  // Glossary sub-pages
  if (preg_match('#^/glossary/([^/]+)/$#', $path, $m)) {
    $pageSlug = $m[1];
    $pageFile = __DIR__.'/../pages/glossary/'.$pageSlug.'.php';
    if (file_exists($pageFile)) {
      require_once __DIR__.'/../lib/meta_directive.php';
      // Use actual request path for canonical (includes locale if present)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      $ctx = [
        'type' => 'page',
        'slug' => 'glossary/'.$pageSlug,
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      // Generate SEO-optimized title from slug (30-60 chars)
      $termName = ucwords(str_replace(['-', '_'], ' ', $pageSlug));
      $title = "$termName: Definition & Guide | NRLC.ai";
      if (strlen($title) > 60) {
        $title = "$termName Definition | NRLC.ai";
      }
      if (strlen($title) < 30) {
        $title = "$termName: Complete Definition Guide | NRLC.ai";
      }
      $GLOBALS['__page_meta']['title'] = $title;
      
      render_page('glossary/'.$pageSlug);
      return;
    }
  }

  if ($path === '/insights/') {
    // Generate unique metadata using ctx-based system for insights hub
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'insights_hub',
      'slug' => 'insights/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('insights/index');
    return;
  }

  // Implementation / Support page
  // META DIRECTIVE KERNEL: /implementation/
  // Intent: Execution after diagnosis
  // Title: Action without hype
  if ($path === '/implementation/' || $path === '/implementation') {
    $GLOBALS['__page_meta'] = [
      'title' => 'Generative Search Implementation for AI-Readable Architectures',
      'description' => 'Hands-on implementation of structural fixes for AI retrieval, including schema execution, content reshaping, entity alignment, and citation-ready formatting.',
      'canonicalPath' => '/implementation/'
    ];
    render_page('implementation/index');
    return;
  }

  // META DIRECTIVE KERNEL: /en-us/services/
  // Intent: Commercial intent, but technical buyer
  // Title: Describe capability, not selling
  if ($path === '/services/') {
    $GLOBALS['__page_meta'] = [
      'title' => 'AI SEO and Generative Search Optimization Services',
      'description' => 'Technical services focused on correcting AI retrieval failures through diagnostics, structured data execution, and system-level content architecture.',
      'canonicalPath' => $path
    ];
    render_page('services/index');
    return;
  }

  // Products routes
  // META DIRECTIVE KERNEL: /en-us/products/
  // Intent: Tooling and systems
  // Title: Utility-driven
  if ($path === '/products/') {
    // Use actual request path for canonical (includes locale prefix)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $GLOBALS['__page_meta'] = [
      'title' => 'AI Search and Structured Knowledge Tools',
      'description' => 'Purpose-built tools for analyzing AI visibility, validating structured data, and shaping content for retrieval and citation by generative engines.',
      'canonicalPath' => $actualPath
    ];
    render_page('products/index');
    return;
  }

  if (preg_match('#^/products/([^/]+)/$#', $path, $m)) {
    $product_slug = $m[1];
    $product_file = __DIR__.'/../pages/products/'.$product_slug.'.php';
    if (file_exists($product_file)) {
      // Generate unique metadata using ctx-based system
      require_once __DIR__.'/../lib/meta_directive.php';
      
      // Extract product name and description from file if available
      $productContent = file_get_contents($product_file);
      $productName = ucwords(str_replace(['-', '_'], ' ', $product_slug));
      $productDescription = null;
      
      // Try to extract productName and productDescription from file
      if (preg_match('/\$productName\s*=\s*[\'"]([^\'"]+)[\'"]/', $productContent, $nameMatch)) {
        $productName = $nameMatch[1];
      }
      if (preg_match('/\$productDescription\s*=\s*[\'"]([^\'"]+)[\'"]/', $productContent, $descMatch)) {
        $productDescription = $descMatch[1];
      }
      
      // Use actual request path for canonical (includes locale prefix)
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      
      $ctx = [
        'type' => 'tool', // G5: TOOL_PAGE formula
        'slug' => "products/$product_slug",
        'title' => $productName,
        'excerpt' => $productDescription, // Use extracted description if available
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      render_page('products/'.$product_slug);
      return;
    }
  }

  // Promptware routes
  if ($path === '/promptware/') {
    render_page('promptware/index');
    return;
  }

  // Handle both /seo-enhancement-kernel/ and /promptware/seo-enhancement-kernel/
  if ($path === '/seo-enhancement-kernel/' || $path === '/seo-enhancement-kernel' || $path === '/promptware/seo-enhancement-kernel/' || $path === '/promptware/seo-enhancement-kernel' || $path === '/en-us/promptware/seo-enhancement-kernel/' || $path === '/en-us/promptware/seo-enhancement-kernel') {
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'tool',
      'slug' => 'promptware/seo-enhancement-kernel/index',
      'title' => 'SEO Enhancement Kernel Promptware for Technical SEO & AI Visibility',
      'excerpt' => 'Full-stack technical SEO promptware for rendering forensics, schema validation, Googlebot simulation, internal link enforcement, and NDJSON microfact extraction.',
      'canonicalPath' => '/promptware/seo-enhancement-kernel/'
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('promptware/seo-enhancement-kernel/index');
    return;
  }

  if ($path === '/promptware/json-stream-seo-ai/') {
    // Set metadata before rendering
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'tool',
      'slug' => 'promptware/json-stream-seo-ai/index',
      'title' => 'JSON Stream + SEO AI · Promptware · NRLC.ai',
      'excerpt' => 'Open-source JSON streaming (NDJSON) utilities and AI manifests for LLM/RAG and internal crawlers.',
      'canonicalPath' => '/promptware/json-stream-seo-ai/'
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('promptware/json-stream-seo-ai/index');
    return;
  }

  if ($path === '/promptware/llm-data-to-citation/') {
    // Set metadata before rendering
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'tool',
      'slug' => 'promptware/llm-data-to-citation/index',
      'title' => 'LLM Data-to-Citation Guide — How Schema & NDJSON Earn Citations',
      'excerpt' => 'A practical playbook for turning your site\'s schema and NDJSON into citations inside LLM answers and AI Overviews.',
      'canonicalPath' => '/promptware/llm-data-to-citation/'
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('promptware/llm-data-to-citation/index');
    return;
  }

  if ($path === '/catalog/') {
    render_page('catalog/index');
    return;
  }

  if (preg_match('#^/catalog/([^/]+)/$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    render_page('catalog/item');
    return;
  }

  // Industries routes
  if (preg_match('#^/industries/([^/]+)/$#', $path, $m)) {
    $_GET['industry'] = $m[1];
    $industrySlug = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $industryName = ucwords(str_replace(['-', '_'], ' ', $industrySlug));
    
    $ctx = [
      'type' => 'industry',
      'slug' => "industries/$industrySlug",
      'title' => $industryName,
      'excerpt' => "SEO and AI visibility for $industryName industry. Specialized strategies, compliance considerations, and proven tactics for sector-specific SEO success.",
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('industries/industry');
    return;
  }

  if ($path === '/industries/') {
    render_page('industries/index');
    return;
  }

  // Canonical Sentinel - Serve static assets first, then route to index
  if (preg_match('#^/tools/canonical-sentinel/#', $path)) {
    // Serve static assets (CSS, JS, images)
    if (preg_match('#^/tools/canonical-sentinel/assets/(.+)$#', $path, $m)) {
      $assetPath = __DIR__ . '/../tools/canonical-sentinel/assets/' . $m[1];
      if (file_exists($assetPath) && is_file($assetPath)) {
        // Set proper content type
        $ext = strtolower(pathinfo($assetPath, PATHINFO_EXTENSION));
        $contentTypes = [
          'css' => 'text/css',
          'js' => 'application/javascript',
          'png' => 'image/png',
          'jpg' => 'image/jpeg',
          'jpeg' => 'image/jpeg',
          'gif' => 'image/gif',
          'svg' => 'image/svg+xml',
        ];
        $contentType = $contentTypes[$ext] ?? 'application/octet-stream';
        header('Content-Type: ' . $contentType);
        readfile($assetPath);
        return;
      }
    }
    
    // Route to index.php
    $sentinelPath = __DIR__ . '/../tools/canonical-sentinel/index.php';
    if (file_exists($sentinelPath)) {
      require $sentinelPath;
      return;
    }
  }

  // Tools routes
  if (preg_match('#^/tools/([^/]+)/$#', $path, $m)) {
    $_GET['tool'] = $m[1];
    $toolSlug = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $toolName = ucwords(str_replace(['-', '_'], ' ', $toolSlug));
    
    $ctx = [
      'type' => 'tool',
      'slug' => "tools/$toolSlug",
      'title' => $toolName,
      'excerpt' => "Use this tool to optimize AI SEO with $toolName. Free AI SEO tool for technical audits, schema validation, and search engine optimization.",
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('tools/tool');
    return;
  }

  if ($path === '/tools/') {
    render_page('tools/index');
    return;
  }

  // Case studies routes
  // CANONICAL: Slug-based URLs (SEO-friendly, semantic, ontology-aligned)
  // Map slugs to case study IDs (for template rendering)
  $caseStudySlugMap = [
    'b2b-saas' => 25,
    'ecommerce' => 26,
    'healthcare' => 27,
    'fintech' => 28,
    'education' => 29,
    'real-estate' => 30,
    'entity-semantic-poisoning-saw' => 'saw' // Special case study with custom page
  ];
  
  // Reverse map: ID → slug (for redirects from old numeric URLs)
  $caseStudyIdToSlug = [
    25 => 'b2b-saas',
    26 => 'ecommerce',
    27 => 'healthcare',
    28 => 'fintech',
    29 => 'education',
    30 => 'real-estate'
  ];
  
  // Route: /case-studies/{id}/view-case-study (301 redirect to slug-based canonical)
  if (preg_match('#^/case-studies/(\d+)/view-case-study/?$#', $path, $m)) {
    $caseNumber = (int)$m[1];
    
    // Preserve locale from original request
    $locale = current_locale();
    $localePrefix = ($locale !== 'en-us') ? '/' . $locale : '';
    
    // Redirect to slug-based canonical if ID exists, otherwise 404
    if (isset($caseStudyIdToSlug[$caseNumber])) {
      $slug = $caseStudyIdToSlug[$caseNumber];
      $canonical = $localePrefix . '/case-studies/' . $slug . '/';
      header("Location: " . absolute_url($canonical), true, 301);
      exit;
    }
    
    // Unknown ID - 404
    http_response_code(404);
    echo "Case study not found";
    return;
  }
  
  // Route: /case-studies/case-study-{id}/ (301 redirect to slug-based canonical)
  if (preg_match('#^/case-studies/case-study-(\d+)/$#', $path, $m)) {
    $caseNumber = (int)$m[1];
    
    // Preserve locale from original request
    $locale = current_locale();
    $localePrefix = ($locale !== 'en-us') ? '/' . $locale : '';
    
    // Redirect to slug-based canonical if ID exists, otherwise 404
    if (isset($caseStudyIdToSlug[$caseNumber])) {
      $slug = $caseStudyIdToSlug[$caseNumber];
      $canonical = $localePrefix . '/case-studies/' . $slug . '/';
      header("Location: " . absolute_url($canonical), true, 301);
      exit;
    }
    
    // Unknown ID - 404
    http_response_code(404);
    echo "Case study not found";
    return;
  }
  
  // Route: /case-studies/{slug}/ (CANONICAL - SEO-friendly, semantic URLs)
  if (preg_match('#^/case-studies/([^/]+)/$#', $path, $m)) {
    $slug = $m[1];
    
    // Special handling for entity-semantic-poisoning-saw (custom page)
    if ($slug === 'entity-semantic-poisoning-saw') {
      require_once __DIR__.'/../lib/meta_directive.php';
      $ctx = [
        'type' => 'case_study',
        'slug' => "case-studies/$slug",
        'title' => 'Entity Repair Case Study: Fixing Semantic Misclassification at SAW.com',
        'excerpt' => 'How entity-level semantic poisoning caused Google to misclassify SAW.com, why SEO fixes failed, and how structured entity repair restored correct business identity.',
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('case-studies/entity-semantic-poisoning-saw');
      return;
    }
    
    // Check if it's a known case study slug
    if (isset($caseStudySlugMap[$slug])) {
      $caseNumber = $caseStudySlugMap[$slug];
      $_GET['case'] = $caseNumber;
      $_GET['slug'] = $slug; // Pass slug to template for semantic context
      
      // Generate unique metadata using ctx-based system
      require_once __DIR__.'/../lib/meta_directive.php';
      
      // Use semantic titles based on slug
      $caseStudyTitles = [
        'b2b-saas' => 'B2B SaaS AI SEO Case Study',
        'ecommerce' => 'E-commerce AI SEO Case Study',
        'healthcare' => 'Healthcare AI SEO Case Study',
        'fintech' => 'Fintech AI SEO Case Study',
        'education' => 'Education AI SEO Case Study',
        'real-estate' => 'Real Estate AI SEO Case Study'
      ];
      
      $caseStudyDescriptions = [
        'b2b-saas' => 'How a SaaS company increased AI citations by 340% through structured data optimization and entity mapping.',
        'ecommerce' => 'E-commerce platform achieved 250% increase in AI visibility through product schema optimization.',
        'healthcare' => 'Medical website improved AI citation rates by 180% with healthcare-specific entity optimization.',
        'fintech' => 'Financial services company increased AI mentions by 290% through compliance-focused optimization.',
        'education' => 'Educational platform achieved 220% increase in AI citations through academic content optimization.',
        'real-estate' => 'Property platform improved AI visibility by 160% with location-based entity optimization.'
      ];
      
      $title = $caseStudyTitles[$slug] ?? 'AI SEO Case Study';
      $excerpt = $caseStudyDescriptions[$slug] ?? 'See how we achieved measurable results with AI SEO. Real-world implementation, data-driven outcomes, and actionable insights.';
      
      $ctx = [
        'type' => 'case_study',
        'slug' => "case-studies/$slug",
        'title' => $title,
        'excerpt' => $excerpt,
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      
      render_page('case-studies/case-study');
      return;
    }
    
    // Unknown slug - 404
    http_response_code(404);
    echo "Case study not found";
    return;
  }

  if ($path === '/case-studies/') {
    render_page('case-studies/index');
    return;
  }

  // AI Prompt-Cluster Landing Pages (routes to proof, not blog posts)
  // These pages answer specific AI prompt patterns and reference case studies
  if (preg_match('#^/ai/([^/]+)/$#', $path, $m)) {
    $aiPageSlug = $m[1];
    $aiPageFile = __DIR__.'/../pages/ai/'.$aiPageSlug.'.php';
    
    if (file_exists($aiPageFile)) {
      // Metadata is set in the page file itself
      render_page('ai/'.$aiPageSlug);
      return;
    }
  }

  // Blog routes
  if (preg_match('#^/blog/blog-post-(\d+)/$#', $path, $m)) {
    $_GET['post'] = $m[1];
    $postNumber = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $topics = ['AI SEO', 'GEO-16 Framework', 'LLM Optimization', 'Structured Data', 'Crawl Clarity', 'Entity Recognition', 'Citation Optimization', 'Technical SEO', 'Content Strategy', 'Analytics'];
    $topic = $topics[($postNumber - 1) % count($topics)];
    $title = "Advanced $topic Strategies for 2025";
    
    $ctx = [
      'type' => 'blog_post',
      'slug' => "blog/blog-post-$postNumber",
      'title' => $title,
      'excerpt' => "Comprehensive guide to $topic optimization, featuring the latest techniques and best practices for AI-powered search engines.",
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('blog/blog-post');
    return;
  }

  if ($path === '/blog/') {
    // Generate metadata for blog index
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'blog',
      'slug' => 'blog/index',
      'title' => 'Blog | AI SEO Insights & Guides',
      'excerpt' => 'Insights, guides, and updates on AI SEO, structured data, and LLM optimization strategies.',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('blog/index');
    return;
  }

  // Resources routes
  if (preg_match('#^/resources/resource-(\d+)/$#', $path, $m)) {
    $_GET['resource'] = $m[1];
    $resourceNumber = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $resourceTypes = ['Schema Guide', 'LLM Optimization Playbook', 'Technical SEO Checklist', 'Structured Data Template', 'AI Citation Framework', 'Entity Mapping Guide', 'Crawl Strategy', 'Content Optimization'];
    $resourceType = $resourceTypes[($resourceNumber - 1) % count($resourceTypes)];
    
    $ctx = [
      'type' => 'resource',
      'slug' => "resources/resource-$resourceNumber",
      'title' => $resourceType,
      'excerpt' => "Download or reference $resourceType. Comprehensive guides, templates, and tools for AI SEO optimization, structured data, and LLM visibility.",
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('resources/resource');
    return;
  }

  if ($path === '/resources/') {
    render_page('resources/index');
    return;
  }

  // Diagnostic page
  if ($path === '/resources/diagnostic/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'resource',
      'slug' => 'resources/diagnostic',
      'title' => 'AI Visibility Diagnostic',
      'excerpt' => 'Diagnostic tool to understand AI visibility issues before requesting a professional audit. Analyze how AI systems interpret your business.',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('resources/diagnostic');
    return;
  }

  // Prechunking SEO Documentation routes
  // Content Chunking Guide
  if ($path === '/docs/content-chunking/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/content-chunking/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Content Chunking Guide - SEO, UX, and AI Parsing | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Learn how to structure content into digestible, scannable chunks that improve readability, SEO, and AI parsing. Complete guide to content chunking principles and best practices.';
    render_page('docs/content-chunking/index');
    return;
  }

  // Prechunking Guide
  if ($path === '/docs/prechunking/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Prechunking Guide - AI Retrieval, AI Overviews, and LLM Citation | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Complete guide to prechunking content for AI retrieval, AI Overviews, and LLM citation. Learn how to structure content before writing so each section can be independently retrieved and cited.';
    render_page('docs/prechunking/index');
    return;
  }

  // AI Retrieval & LLM Citation Guide
  if ($path === '/docs/ai-retrieval/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/ai-retrieval/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'AI Retrieval & LLM Citation Guide | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Expert guide to how AI systems retrieve and cite content. Learn how search engines and LLMs extract segments, score them for answer quality, and surface them in AI Overviews and answers.';
    render_page('docs/ai-retrieval/index');
    return;
  }

  if ($path === '/docs/prechunking-seo/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/index',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Prechunking SEO Documentation | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Official documentation for Prechunking SEO: an engineering discipline for structuring content for AI retrieval and citation. Core concepts, croutons, precogs.';
    render_page('docs/prechunking-seo/index');
    return;
  }

  if ($path === '/docs/prechunking-seo/core-concepts/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/core-concepts',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Prechunking SEO: Core Concepts | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Core concepts of prechunking SEO: data shaping, croutons, precogs, chunk boundaries, and retrieval vs ranking.';
    render_page('docs/prechunking-seo/core-concepts');
    return;
  }

  if ($path === '/docs/prechunking-seo/croutons/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/croutons',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Crouton Specification | Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Crouton specification for prechunking SEO. Atomic, retrievable fact structures that survive AI extraction.';
    render_page('docs/prechunking-seo/croutons');
    return;
  }

  if ($path === '/docs/prechunking-seo/precogs/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/precogs',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Precog Modeling | Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Precog modeling for prechunking SEO. Intent forecasting, follow-up questions, and trust-question identification.';
    render_page('docs/prechunking-seo/precogs');
    return;
  }

  if ($path === '/docs/prechunking-seo/workflow/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/workflow',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Prechunking Workflow | Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Prechunking SEO workflow. Intent decomposition, crouton inventory, data shaping, and structured publishing.';
    render_page('docs/prechunking-seo/workflow');
    return;
  }

  if ($path === '/docs/prechunking-seo/failure-modes/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/failure-modes',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Failure Modes | Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Prechunking SEO failure modes. Why AI ignores content, why facts mutate, and why competitors get cited instead.';
    render_page('docs/prechunking-seo/failure-modes');
    return;
  }

  if ($path === '/docs/prechunking-seo/measurement/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/measurement',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Measurement & KPIs | Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Prechunking SEO measurement and KPIs. AI citation rates, answer inclusion, cross-engine consistency, and zero-click dominance.';
    render_page('docs/prechunking-seo/measurement');
    return;
  }

  if ($path === '/docs/prechunking-seo/doctrine/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/doctrine',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'NRLC Doctrine | Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'NRLC doctrine for prechunking SEO. Pages are containers, chunks are assets, retrieval precedes ranking, truth must survive isolation.';
    render_page('docs/prechunking-seo/doctrine');
    return;
  }

  // Prechunking SEO Course routes - must come before the base course route
  if (preg_match('#^/docs/prechunking-seo/course/([^/]+)/$#', $path, $m)) {
    $moduleSlug = $m[1];
    require_once __DIR__.'/../lib/meta_directive.php';
    
    // Map module slugs to page names
    $modulePages = [
      'how-llms-chunk-content' => 'docs/prechunking-seo/course/how-llms-chunk-content',
      'chunk-atomicity-inference-cost' => 'docs/prechunking-seo/course/chunk-atomicity-inference-cost',
      'vectorization-semantic-collisions' => 'docs/prechunking-seo/course/vectorization-semantic-collisions',
      'data-structuring-beyond-pages' => 'docs/prechunking-seo/course/data-structuring-beyond-pages',
      'cross-page-consistency' => 'docs/prechunking-seo/course/cross-page-consistency',
      'prompt-reverse-engineering' => 'docs/prechunking-seo/course/prompt-reverse-engineering',
      'citation-eligibility-engineering' => 'docs/prechunking-seo/course/citation-eligibility-engineering',
      'measuring-prechunking-success' => 'docs/prechunking-seo/course/measuring-prechunking-success',
      'failure-modes-why-chunks-die' => 'docs/prechunking-seo/course/failure-modes-why-chunks-die'
    ];
    
    if (isset($modulePages[$moduleSlug])) {
      $ctx = [
        'type' => 'training',
        'slug' => $modulePages[$moduleSlug],
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page($modulePages[$moduleSlug]);
      return;
    }
  }
  
  if ($path === '/docs/prechunking-seo/course/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'training',
      'slug' => 'docs/prechunking-seo/course',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Prechunking Content Engineering Course | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'A systems-level course for LLM ingestion, retrieval, and citation. Multi-page course structure optimized for AI ingestion and retrieval.';
    render_page('docs/prechunking-seo/course/index');
    return;
  }

  if ($path === '/docs/prechunking-seo/academic-signals/') {
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'page',
      'slug' => 'docs/prechunking-seo/academic-signals',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    $GLOBALS['__page_meta']['title'] = 'Academic Signals Informing Prechunking SEO | NRLC.ai';
    $GLOBALS['__page_meta']['description'] = 'Evidence-backed research alignment for prechunking SEO. Semantic overlap, atomic extractability, redundant truth reinforcement, and citation-ready assertion design.';
    render_page('docs/prechunking-seo/academic-signals');
    return;
  }

  // AI Visibility Audit Example Pages
  if (preg_match('#^/ai-visibility/audit-example/([^/]+)/$#', $path, $m)) {
    $_GET['industry'] = $m[1];
    $industrySlug = $m[1];
    require_once __DIR__.'/../lib/meta_directive.php';
    $industries = require __DIR__.'/../lib/ai_visibility_industries.php';
    $industryData = $industries[$industrySlug] ?? null;

    if ($industryData) {
      $title = "AI Visibility Audit Example: {$industryData['name']} | Neural Command";
      $excerpt = "See how we diagnose AI visibility issues for {$industryData['name']}. This audit example demonstrates our diagnostic process without exposing client data.";
      $ctx = [
        'type' => 'case-study',
        'slug' => "ai-visibility/audit-example/$industrySlug",
        'title' => $title,
        'excerpt' => $excerpt,
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      render_page('ai-visibility/audit-example');
      return;
    }
  }

  // AI Visibility Landing Pages
  if ($path === '/ai-visibility/') {
    // Set metadata directly for AI Visibility service page
    // ENFORCEMENT: Meta title must explicitly promise AI recommendations
    // Meta description must answer "Why would AI systems trust you?"
    $GLOBALS['__page_meta'] = [
      'title' => 'AI Visibility Optimization: Get Your Business Recommended by ChatGPT & AI Search | NRLC.ai',
      'description' => 'AI visibility optimization helps your business get cited, mentioned, and recommended by ChatGPT, Google AI Overviews, and answer engines. We engineer entity signals, structured data, and citable sources AI systems actually use.',
      'canonicalPath' => $path
    ];
    render_page('ai-visibility/index');
    return;
  }

  // Special handling for Prechunking SEO structure industry pages
  $prechunkingIndustries = [
    'immigration' => ['name' => 'Immigration Services', 'term' => 'immigration'],
    'financial-advisor' => ['name' => 'Financial Advisors', 'term' => 'financial planning'],
    'contractor' => ['name' => 'High-End Contractors', 'term' => 'repairs and renovations'],
    'veterinary' => ['name' => 'Veterinary Practices', 'term' => 'veterinary'],
    'senior-care' => ['name' => 'Senior Care / Assisted Living Advisors', 'term' => 'senior care'],
    'private-school' => ['name' => 'Private Schools / Tutoring', 'term' => 'education'],
    'auto-repair' => ['name' => 'Auto Repair / Specialty Mechanics', 'term' => 'car repairs'],
    'funeral' => ['name' => 'Funeral & Cremation Services', 'term' => 'funeral planning'],
    'real-estate' => ['name' => 'Real Estate Agents (Relocation / Luxury)', 'term' => 'real estate'],
    'private-investigator' => ['name' => 'Private Investigators', 'term' => 'private investigation']
  ];
  
  if (preg_match('#^/ai-visibility/([^/]+)/$#', $path, $m)) {
    $industrySlug = $m[1];
    
    // Check if this industry uses Prechunking SEO structure
    if (isset($prechunkingIndustries[$industrySlug])) {
      require_once __DIR__.'/../lib/meta_directive.php';
      $industry = $prechunkingIndustries[$industrySlug];
      
      // Use actual request path (includes locale prefix) for canonical
      $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
      
      $ctx = [
        'type' => 'service',
        'slug' => "ai-visibility/$industrySlug",
        'canonicalPath' => $actualPath
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      $GLOBALS['__page_meta']['title'] = "AI Visibility for {$industry['name']} | NRLC.ai";
      
      // Contractor-specific meta description (contractor-native language)
      if ($industrySlug === 'contractor') {
        $GLOBALS['__page_meta']['description'] = "When homeowners ask ChatGPT who the best contractor is near them, we help make sure your business shows up. Get more calls and more jobs from AI recommendations.";
      } else {
        $GLOBALS['__page_meta']['description'] = "Engineering service that structures {$industry['term']} information so AI systems can retrieve, verify, and cite it accurately. Prechunking methodology for {$industry['name']}.";
      }
      
      render_page("ai-visibility/$industrySlug");
      return;
    }
    
    // Fall back to generic industry template for any other industries
    $_GET['industry'] = $industrySlug;
    $industrySlug = $m[1];
    $_GET['industry'] = $industrySlug;
    
    // Load industry data
    $industriesFile = __DIR__.'/../lib/ai_visibility_industries.php';
    if (file_exists($industriesFile)) {
      $industries = require $industriesFile;
      if (isset($industries[$industrySlug])) {
        $industry = $industries[$industrySlug];
        
        // Set metadata directly (override meta directive for exact control)
        $GLOBALS['__page_meta'] = [
          'title' => "AI Visibility for {$industry['name']} | Control How AI Recommends Your Business",
          'description' => $industry['subheadline'],
          'canonicalPath' => $path
        ];
        render_page('ai-visibility/industry');
        return;
      }
    }
  }

  // Handle missing docs pages - redirect to main prechunking-seo page
  if (preg_match('#^/docs/prechunking-seo/(academic-signals|measurement|doctrine|failure-modes)/?#', $path, $m)) {
    // These docs pages don't exist - redirect to main prechunking-seo page
    $originalPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $locale = 'en-us';
    if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $originalPath, $localeMatch)) {
      $locale = $localeMatch[1];
    }
    header("Location: " . absolute_url("/$locale/docs/prechunking-seo/"), true, 301);
    exit;
  }
  
  // CRITICAL FIX: Redirect service-city URLs missing /services/ prefix
  // Pattern: /{locale}/{service-slug}/{city}/ -> /{locale}/services/{service-slug}/{city}/
  // This catches URLs like /en-us/content-optimization-ai/sherbrooke/
  // MUST check originalPath (before locale stripping) to catch locale-prefixed URLs
  if (preg_match('#^/([a-z]{2})-([a-z]{2})/([^/]+)/([^/]+)/$#', $originalPath, $m)) {
    $locale = strtolower($m[1].'-'.$m[2]);
    $potentialService = $m[3];
    $city = $m[4];
    
    // Check if this looks like a service-city URL (not already /services/)
    // Common service patterns: ends with -ai, -seo, -optimization, etc.
    if (preg_match('#(-ai|-seo|-optimization|-strategy|-audits?|training)$#i', $potentialService)) {
      $queryString = !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
      $redirectUrl = '/' . $locale . '/services/' . $potentialService . '/' . $city . '/';
      header("Location: " . absolute_url($redirectUrl) . $queryString, true, 301);
      exit;
    }
  }
  
  // Handle service slug mismatches before routing
  // Redirect /services/structured-data/ to /services/structured-data-ai/ (correct slug)
  // Always redirect to en-us (canonical locale for GLOBAL service pages)
  if (preg_match('#^/services/structured-data/?$#', $path)) {
    $queryString = !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
    header("Location: " . absolute_url("/en-us/services/structured-data-ai/") . $queryString, true, 301);
    exit;
  }
  
  // Redirect /services/ai-overview-optimization/ to /services/ai-overviews-optimization/ (plural is correct)
  // Always redirect to en-us (canonical locale for GLOBAL service pages)
  if (preg_match('#^/services/ai-overview-optimization/?$#', $path)) {
    $queryString = !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '';
    header("Location: " . absolute_url("/en-us/services/ai-overviews-optimization/") . $queryString, true, 301);
    exit;
  }

  // NOTE: Career pages are handled above (line 476) - this block is unreachable
  // If we reach here, the career page pattern didn't match, so it's a 404

  // 404 Handler - Add noindex to prevent indexing of 404 pages
  header('X-Robots-Tag: noindex, nofollow');
  http_response_code(404);
  echo "Not Found";
}

/**
 * Load page metadata from a PHP file before head.php is included
 * SUDO-POWERED: Enforces metadata alignment with page intent
 * 
 * 1. Extracts existing metadata from file
 * 2. Analyzes page content to determine intent
 * 3. Validates metadata alignment
 * 4. Enforces optimal metadata if misaligned
 */
function load_page_metadata(string $filePath): void {
  if (!file_exists($filePath)) {
    return;
  }
  
  require_once __DIR__.'/../lib/meta_directive.php';
  
  $slug = $GLOBALS['__page_slug'] ?? 'home/home';
  $currentTitle = null;
  $currentDesc = null;
  
  $content = file_get_contents($filePath);
  
  // Extract $GLOBALS['pageTitle'] assignments (single quotes)
  if (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\']((?:[^\'\\\\]|\\\\.)*)[\']\s*;/s', $content, $matches)) {
    $currentTitle = stripcslashes($matches[1]);
  }
  // Extract $GLOBALS["pageTitle"] assignments (double quotes)
  elseif (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*["]((?:[^"\\\\]|\\\\.)*)["]\s*;/s', $content, $matches)) {
    $currentTitle = stripcslashes($matches[1]);
  }
  
  // Extract $GLOBALS['pageDesc'] assignments (single quotes)
  if (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\']((?:[^\'\\\\]|\\\\.)*)[\']\s*;/s', $content, $matches)) {
    $currentDesc = stripcslashes($matches[1]);
  }
  // Extract $GLOBALS["pageDesc"] assignments (double quotes)
  elseif (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*["]((?:[^"\\\\]|\\\\.)*)["]\s*;/s', $content, $matches)) {
    $currentDesc = stripcslashes($matches[1]);
  }
  
  // SUDO-POWERED META DIRECTIVE: Enforce metadata alignment with intent
  [$enforcedTitle, $enforcedDesc] = sudo_meta_directive($filePath, $slug, $currentTitle, $currentDesc);
  
  // Set enforced metadata (sudo authority - overrides if needed)
  $GLOBALS['pageTitle'] = $enforcedTitle;
  $GLOBALS['pageDesc'] = $enforcedDesc;
}

function render_page(string $slug): void {
  // GUARD: render_page must not throw fatal errors - always return 200
  try {
    // Define router context BEFORE including any page files
    // This prevents numbered files from being executed directly
    if (!defined('ROUTER_CONTEXT')) {
      define('ROUTER_CONTEXT', true);
    }
    
    $GLOBALS['__page_slug'] = $slug;

    // Special handling for promptware pages
    if (strpos($slug, 'promptware/') === 0) {
      define('ROUTER_INCLUDED', true);
      if (file_exists(__DIR__.'/../templates/head.php')) {
        include __DIR__.'/../templates/head.php';
      }
      if (file_exists(__DIR__.'/../templates/header.php')) {
        include __DIR__.'/../templates/header.php';
      }
      $promptwareFile = __DIR__.'/../public/'.$slug.'.php';
      if (file_exists($promptwareFile)) {
        include $promptwareFile;
      }
      if (file_exists(__DIR__.'/../templates/footer.php')) {
        include __DIR__.'/../templates/footer.php';
      }
      return;
    }

    // Special handling for catalog pages - use pages/ directory
    if (strpos($slug, 'catalog/') === 0) {
      $pageFile = __DIR__.'/../pages/'.$slug.'.php';
      if (file_exists($pageFile)) {
        // Include page file to set metadata (capture output to prevent headers sent)
        ob_start();
        try {
          include $pageFile;
        } catch (Throwable $e) {
          // Clear output buffer on error
          ob_end_clean();
          throw $e;
        }
        $pageOutput = ob_get_clean();
        
        // Only call load_page_metadata if page didn't set __page_meta - GUARDED
        if (!isset($GLOBALS['__page_meta']) || !is_array($GLOBALS['__page_meta'])) {
          if (function_exists('load_page_metadata')) {
            try {
              load_page_metadata($pageFile);
            } catch (Throwable $e) {
              // Silent fail - metadata is optional
            }
          }
        }
        
        // Now include templates (metadata should be set by now)
        if (file_exists(__DIR__.'/../templates/head.php')) {
          include __DIR__.'/../templates/head.php';
        }
        if (file_exists(__DIR__.'/../templates/header.php')) {
          include __DIR__.'/../templates/header.php';
        }
        echo $pageOutput;
        if (file_exists(__DIR__.'/../templates/footer.php')) {
          include __DIR__.'/../templates/footer.php';
        }
        return;
      }
    }

    // Load page metadata BEFORE head.php is included - GUARDED
    $pageFile = __DIR__.'/../pages/'.$slug.'.php';
    if (file_exists($pageFile) && function_exists('load_page_metadata')) {
      try {
        load_page_metadata($pageFile);
      } catch (Throwable $e) {
        // Silent fail - metadata is optional
      }
    }
    
    // Include templates with file existence checks
    if (file_exists(__DIR__.'/../templates/head.php')) {
      include __DIR__.'/../templates/head.php';
    }
    if (file_exists(__DIR__.'/../templates/header.php')) {
      include __DIR__.'/../templates/header.php';
    }
    if (file_exists($pageFile)) {
      include $pageFile;
    }
    if (file_exists(__DIR__.'/../templates/footer.php')) {
      include __DIR__.'/../templates/footer.php';
    }
  } catch (Throwable $e) {
    // FALLBACK: If render fails, output minimal HTML - always return 200
    http_response_code(200);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html><head><title>NRLC.ai</title><meta charset="UTF-8"></head><body><h1>NRLC.ai</h1><p>AI SEO & AI Visibility Services</p></body></html>';
  }
}
