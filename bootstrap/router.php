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
  // GUARD: route_request must not throw fatal errors
  try {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

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
    http_response_code(404);
    echo "Not Found";
    return;
  }

  // Handle /audit/ URL (404)
  if ($path === '/audit/' || $path === '/audit') {
    http_response_code(404);
    echo "Not Found";
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
      
      // Guard optional function calls
      $ctx = [
        'type' => 'home',
        'slug' => 'home/home',
        'canonicalPath' => '/'
      ];
      
      if (function_exists('sudo_meta_directive_ctx')) {
        $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      } else {
        // Fallback metadata if function doesn't exist
        $GLOBALS['__page_meta'] = [
          'title' => 'AI SEO & AI Visibility Services | NRLC.ai',
          'description' => 'Professional AI SEO and AI visibility services. We help businesses improve search rankings and AI-generated answer eligibility.'
        ];
      }
      
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
        render_page('home/home');
      } else {
        // Fallback if render_page doesn't exist
        throw new Exception('render_page function not found');
      }
      return;
    } catch (Throwable $e) {
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

  // Training page route
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
    $serviceSlug = $m[1];
    $serviceTitle = ucfirst(str_replace(['-', '_'], ' ', $serviceSlug));
    
    $ctx = [
      'type' => 'service',
      'slug' => 'services/service',
      'service' => $serviceTitle,
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    // Override meta title for site-audits overview to match directive
    if ($serviceSlug === 'site-audits') {
      $GLOBALS['__page_meta']['title'] = "Site Audits for AI & Search Visibility | NRLC.ai";
      $GLOBALS['__page_meta']['description'] = "Site audits that explain why visibility breaks down, not just surface-level issues. Focus on how search engines and AI systems interpret your site.";
    }
    
    render_page('services/service');
    return;
  }

  if (preg_match('#^/services/([^/]+)/([^/]+)/$#', $path, $m)) {
    $_GET['service'] = $m[1];
    $_GET['city']    = $m[2];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    require_once __DIR__.'/../lib/helpers.php';
    require_once __DIR__.'/../lib/content_tokens.php';
    $serviceSlug = $m[1];
    $citySlug = $m[2];
    $serviceTitle = ucfirst(str_replace('-',' ', $serviceSlug));
    $cityTitle = function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-','_'],' ',$citySlug));
    
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
      // Override meta title/description (locked template, matches GSC Cluster 1)
      // Meta Title: 50 chars - "AI & SEO Services for {City} Businesses | NRLC.ai"
      // Meta Description: 136 chars - bridges traditional + AI
      $cityTitleFormatted = function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-','_'],' ',$citySlug));
      $GLOBALS['__page_meta']['title'] = "AI & SEO Services for $cityTitleFormatted Businesses | NRLC.ai";
      $GLOBALS['__page_meta']['description'] = "We help $cityTitleFormatted businesses improve search rankings and AI visibility by structuring local data for safe extraction, trust, and citation.";
      render_page('services/service_local_seo_ai_city');
      return;
    }
    
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
      // Override meta title for site-audits to match directive (H1 pattern: Site Audits for AI & Search Visibility)
      // Dynamic title with truncation protection for long city names
      $baseTitle = "Site Audits for AI & Search Visibility";
      $cityTitleLen = strlen($cityTitle);
      $suffix = " | NRLC.ai";
      $infix = " in ";
      $maxCityLen = 60 - strlen($baseTitle) - strlen($suffix) - strlen($infix);
      
      if ($cityTitleLen > $maxCityLen) {
        // Truncate city name if needed (preserve at least 3 chars + ellipsis)
        $truncatedLen = max(3, $maxCityLen - 3);
        $cityTitle = substr($cityTitle, 0, $truncatedLen) . '...';
      }
      
      $GLOBALS['__page_meta']['title'] = "$baseTitle$infix$cityTitle$suffix";
      
      // Description with truncation protection
      $baseDesc = "Site audit services in $cityTitle. We explain why visibility breaks down, not just surface-level issues. Focus on how search engines and AI systems interpret your site.";
      if (strlen($baseDesc) > 160) {
        $baseDesc = substr($baseDesc, 0, 157) . '...';
      }
      $GLOBALS['__page_meta']['description'] = $baseDesc;
      
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
    
    render_page('services/service_city');
    return;
  }

  if (preg_match('#^/careers/([^/]+)/([^/]+)/$#', $path, $m)) {
    $_GET['city'] = $m[1];
    $_GET['role'] = $m[2];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $citySlug = $m[1];
    $roleSlug = $m[2];
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

  if (preg_match('#^/insights/([^/]+)/$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    $slug = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $articleTitle = ucwords(str_replace(['-', '_'], ' ', $slug));
    
    // Special handling for specific articles
    if ($slug === 'google-llms-txt-ai-seo') {
      $articleTitle = "Google LLMs.txt Documentation Analysis & SEO Strategy";
      $excerpt = "Google's llms.txt reveals how Google trains LLMs on Search. Turn that blueprint into executable AI SEO strategy, structured data, and technical SEO.";
    } elseif ($slug === 'semantic-queries') {
      $articleTitle = "Semantic Queries & Query Optimization";
      $excerpt = "How semantic relationships collapse query complexity and reduce time to value. Learn how traditional SQL queries with dozens of JOINs become concise, relationship-aware logic.";
    } elseif ($slug === 'semantic-modeling') {
      $articleTitle = "Why Teams Adopt Semantic Modeling";
      $excerpt = "Understanding the business value of semantic infrastructure. How organizations achieve 90% reduction in time-to-consumption and enable reliable AI workflows.";
    } elseif ($slug === 'data-virtualization') {
      $articleTitle = "Data Virtualization";
      $excerpt = "How data virtualization enables unified access to distributed data sources without physical data movement, reducing complexity and improving agility.";
    } elseif ($slug === 'performance-caching') {
      $articleTitle = "Performance & Caching Insights";
      $excerpt = "Intelligent pushdown optimization, query performance tuning, and powerful caching engines that reduce compute spend while maintaining query speed and accuracy.";
    } elseif ($slug === 'enterprise-llm') {
      $articleTitle = "Enterprise LLM Foundation";
      $excerpt = "Building reliable AI workflows on structured understanding. How structured semantic context, verified relationships, and virtualized access enable trustworthy LLM operations.";
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

  // Book page route (GET requests to /api/book/) - BLOCKED: Governance violation
  // Direct booking endpoints are NOT permitted before intent qualification
  // Endpoint is POST-only for form submissions, GET requests blocked
  if ($path === '/api/book/' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'Direct access not permitted. Please use the contact form.']);
    exit;
  }

  // Book API route (POST requests to /api/book/)
  if ($path === '/api/book/' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $api_file = __DIR__.'/../api/book.php';
    if (file_exists($api_file)) {
      include $api_file;
      return;
    }
  }

  // Other API routes
  if (preg_match('#^/api/([^/]+)/?$#', $path, $m)) {
    $api_file = __DIR__.'/../api/'.$m[1].'.php';
    if (file_exists($api_file)) {
      include $api_file;
      return;
    }
  }

  // Index pages
  if ($path === '/careers/') {
    render_page('careers/index');
    return;
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

  if ($path === '/services/') {
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $ctx = [
      'type' => 'service',
      'slug' => 'services/index',
      'service' => 'services',
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    render_page('services/index');
    return;
  }

  // Products routes
  if ($path === '/products/') {
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    // Use actual request path for canonical (includes locale prefix)
    $actualPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $ctx = [
      'type' => 'products_hub',
      'slug' => 'products/index',
      'canonicalPath' => $actualPath
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
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
  if (preg_match('#^/case-studies/case-study-(\d+)/$#', $path, $m)) {
    $_GET['case'] = $m[1];
    $caseNumber = $m[1];
    
    // Generate unique metadata using ctx-based system
    require_once __DIR__.'/../lib/meta_directive.php';
    $companies = ['TechCorp', 'DataFlow Inc', 'CloudSync', 'AI Ventures', 'SearchMax', 'SchemaPro', 'LLM Labs', 'SEO Dynamics'];
    $company = $companies[($caseNumber - 1) % count($companies)];
    $title = "$company AI SEO Case Study";
    
    $ctx = [
      'type' => 'case_study',
      'slug' => "case-studies/case-study-$caseNumber",
      'title' => $title,
      'excerpt' => "See how we helped $company achieve measurable results with AI SEO. Real-world implementation, data-driven outcomes, and actionable insights.",
      'canonicalPath' => $path
    ];
    $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
    
    render_page('case-studies/case-study');
    return;
  }

  if ($path === '/case-studies/') {
    render_page('case-studies/index');
    return;
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
    require_once __DIR__.'/../lib/ai_visibility_industries.php';
    $industryData = AI_VISIBILITY_INDUSTRIES[$industrySlug] ?? null;

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
    // ENFORCEMENT: Meta title must include "AI Visibility Services"
    // Meta description must explain this is a hireable service
    $GLOBALS['__page_meta'] = [
      'title' => 'AI Visibility Services – Brand Presence in AI | NRLC.ai',
      'description' => 'Professional AI visibility service that improves brand presence in AI-generated answers across ChatGPT, Google AI Overviews, Perplexity, and Claude.',
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
      $ctx = [
        'type' => 'service',
        'slug' => "ai-visibility/$industrySlug",
        'canonicalPath' => $path
      ];
      $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
      $GLOBALS['__page_meta']['title'] = "AI Visibility for {$industry['name']} | NRLC.ai";
      $GLOBALS['__page_meta']['description'] = "Engineering service that structures {$industry['term']} information so AI systems can retrieve, verify, and cite it accurately. Prechunking methodology for {$industry['name']}.";
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

