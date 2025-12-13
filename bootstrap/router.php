<?php
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/i18n.php';

function route_request(): void {
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
    render_page('home/home');
    return;
  }

  if (preg_match('#^/services/([^/]+)/$#', $path, $m)) {
    $_GET['service'] = $m[1];
    render_page('services/service');
    return;
  }

  if (preg_match('#^/services/([^/]+)/([^/]+)/$#', $path, $m)) {
    $_GET['service'] = $m[1];
    $_GET['city']    = $m[2];
    
    // Set metadata before rendering page (so head.php can use it)
    require_once __DIR__.'/../lib/helpers.php';
    require_once __DIR__.'/../lib/content_tokens.php';
    $serviceSlug = $m[1];
    $citySlug = $m[2];
    $serviceTitle = ucfirst(str_replace('-',' ', $serviceSlug));
    $cityTitle = function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-','_'],' ',$citySlug));
    $GLOBALS['__page_slug'] = 'services/service_city';
    $GLOBALS['pageTitle'] = "$serviceTitle in $cityTitle";
    
    // Try to get enhanced intro for description
    if (function_exists('get_service_enhancement')) {
      $enhancement = get_service_enhancement($serviceSlug, $citySlug);
      if (!empty($enhancement['intro'])) {
        $GLOBALS['pageDesc'] = $enhancement['intro'];
      } else {
        $GLOBALS['pageDesc'] = "$serviceTitle services in $cityTitle. Professional AI SEO optimization with GEO-16 framework, structured data, and LLM citation readiness.";
      }
    } else {
      $GLOBALS['pageDesc'] = "$serviceTitle services in $cityTitle. Professional AI SEO optimization with GEO-16 framework, structured data, and LLM citation readiness.";
    }
    
    render_page('services/service_city');
    return;
  }

  if (preg_match('#^/careers/([^/]+)/([^/]+)/$#', $path, $m)) {
    $_GET['city'] = $m[1];
    $_GET['role'] = $m[2];
    render_page('careers/career_city');
    return;
  }

  if (preg_match('#^/insights/([^/]+)/$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    $slug = $m[1];
    
    // Set metadata for specific articles BEFORE head.php is included
    if ($slug === 'google-llms-txt-ai-seo') {
      $GLOBALS['pageTitle'] = "Google LLMs.txt Documentation Analysis & SEO Strategy";
      $GLOBALS['pageDesc'] = "Google's llms.txt reveals how Google trains LLMs on Search. Turn that blueprint into executable AI SEO strategy, structured data, and technical SEO.";
    }
    
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

  // Book page route (GET requests to /api/book/)
  if ($path === '/api/book/' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    render_page('book/index');
    return;
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
    render_page('insights/index');
    return;
  }

  if ($path === '/services/') {
    // Set metadata BEFORE head.php is included (so it's available when head.php renders the <title> tag)
    $GLOBALS['pageTitle'] = 'The Semantic Infrastructure for the AI Internet | NRLC.ai';
    $GLOBALS['pageDesc'] = 'NRLC provides a semantic operating layer that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.';
    render_page('services/index');
    return;
  }

  // Products routes
  if ($path === '/products/') {
    render_page('products/index');
    return;
  }

  if (preg_match('#^/products/([^/]+)/$#', $path, $m)) {
    $product_slug = $m[1];
    $product_file = __DIR__.'/../pages/products/'.$product_slug.'.php';
    if (file_exists($product_file)) {
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
  if ($path === '/seo-enhancement-kernel/' || $path === '/seo-enhancement-kernel') {
    // Set SEO-first meta BEFORE rendering
    $GLOBALS['pageTitle'] = 'SEO Enhancement Kernel Promptware for Technical SEO & AI Visibility';
    $GLOBALS['pageDesc'] = 'Full-stack technical SEO promptware for rendering forensics, schema validation, Googlebot simulation, internal link enforcement, and NDJSON microfact extraction.';
    render_page('promptware/seo-enhancement-kernel/index');
    return;
  }

  if ($path === '/promptware/seo-enhancement-kernel/' || $path === '/promptware/seo-enhancement-kernel' || $path === '/en-us/promptware/seo-enhancement-kernel/' || $path === '/en-us/promptware/seo-enhancement-kernel') {
    // Set SEO-first meta BEFORE rendering
    $GLOBALS['pageTitle'] = 'SEO Enhancement Kernel Promptware for Technical SEO & AI Visibility';
    $GLOBALS['pageDesc'] = 'Full-stack technical SEO promptware for rendering forensics, schema validation, Googlebot simulation, internal link enforcement, and NDJSON microfact extraction.';
    render_page('promptware/seo-enhancement-kernel/index');
    return;
  }

  if ($path === '/promptware/json-stream-seo-ai/') {
    render_page('promptware/json-stream-seo-ai/index');
    return;
  }

  if ($path === '/promptware/llm-data-to-citation/') {
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
    render_page('blog/blog-post');
    return;
  }

  if ($path === '/blog/') {
    render_page('blog/index');
    return;
  }

  // Resources routes
  if (preg_match('#^/resources/resource-(\d+)/$#', $path, $m)) {
    $_GET['resource'] = $m[1];
    render_page('resources/resource');
    return;
  }

  if ($path === '/resources/') {
    render_page('resources/index');
    return;
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
  $GLOBALS['__page_slug'] = $slug;

  // Special handling for promptware pages
  if (strpos($slug, 'promptware/') === 0) {
    define('ROUTER_INCLUDED', true);
    include __DIR__.'/../templates/head.php';
    include __DIR__.'/../templates/header.php';
    include __DIR__.'/../public/'.$slug.'.php';
    include __DIR__.'/../templates/footer.php';
    return;
  }

  // Special handling for catalog pages - use pages/ directory
  if (strpos($slug, 'catalog/') === 0) {
    // Load metadata before head.php
    $pageFile = __DIR__.'/../pages/'.$slug.'.php';
    load_page_metadata($pageFile);
    include __DIR__.'/../templates/head.php';
    include __DIR__.'/../templates/header.php';
    include $pageFile;
    include __DIR__.'/../templates/footer.php';
    return;
  }

  // Load page metadata BEFORE head.php is included
  $pageFile = __DIR__.'/../pages/'.$slug.'.php';
  load_page_metadata($pageFile);
  
  include __DIR__.'/../templates/head.php';
  include __DIR__.'/../templates/header.php';
  include $pageFile;
  include __DIR__.'/../templates/footer.php';
}

