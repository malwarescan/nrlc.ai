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

  if ($path === '/' || $path === '') {
    render_page('home/home');
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

  if (preg_match('#^/services/([^/]+)/$#', $path, $m)) {
    $_GET['service'] = $m[1];
    render_page('services/service');
    return;
  }

  if (preg_match('#^/services/([^/]+)/([^/]+)/$#', $path, $m)) {
    $_GET['service'] = $m[1];
    $_GET['city']    = $m[2];
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
    render_page('insights/article');
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
    render_page('services/index');
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

function render_page(string $slug): void {
  $GLOBALS['__page_slug'] = $slug;
  include __DIR__.'/../templates/head.php';
  include __DIR__.'/../templates/header.php';
  include __DIR__.'/../pages/'.$slug.'.php';
  include __DIR__.'/../templates/footer.php';
}

