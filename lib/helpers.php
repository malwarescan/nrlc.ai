<?php
function absolute_url(string $path): string {
  // Always use HTTPS for canonicals (modern hosting like Railway/Vercel handles SSL)
  // Check common proxy headers for HTTPS detection
  $isHttps = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') ||
    (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
  );
  // Default to HTTPS for production (canonicals should always be HTTPS)
  $scheme = $isHttps || (($_SERVER['APP_ENV'] ?? 'production') === 'production') ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  if ($path === '') $path = '/';
  return $scheme.'://'.$host.$path;
}

function current_locale(): string {
  // Check for locale in URL path
  $path = $_SERVER['REQUEST_URI'] ?? '/';
  if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $path, $matches)) {
    return $matches[1];
  }
  
  // Check Accept-Language header for geolocation
  $acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
  $languages = explode(',', $acceptLang);
  
  foreach ($languages as $lang) {
    $lang = trim(explode(';', $lang)[0]);
    switch (strtolower($lang)) {
      case 'en-us':
      case 'en':
        return 'en-us';
      case 'en-gb':
        return 'en-gb';
      case 'es':
      case 'es-es':
        return 'es-es';
      case 'fr':
      case 'fr-fr':
        return 'fr-fr';
    }
  }
  
  // Default to US English
  return 'en-us';
}

function detect_user_city(): string {
  // Check for city in URL path first
  $path = $_SERVER['REQUEST_URI'] ?? '/';
  if (preg_match('#/services/[^/]+/([^/]+)/#', $path, $matches)) {
    return $matches[1];
  }
  
  // Check for geolocation headers (Cloudflare, etc.)
  $country = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? $_SERVER['HTTP_X_COUNTRY'] ?? '';
  $region = $_SERVER['HTTP_CF_REGION'] ?? $_SERVER['HTTP_X_REGION'] ?? '';
  
  // Map countries/regions to cities
  $cityMap = [
    'US' => [
      'CA' => 'los-angeles',
      'NY' => 'new-york',
      'TX' => 'houston',
      'FL' => 'miami',
      'IL' => 'chicago',
      'WA' => 'seattle',
      'default' => 'new-york'
    ],
    'GB' => ['default' => 'london'],
    'CA' => ['default' => 'toronto'],
    'AU' => ['default' => 'sydney'],
    'DE' => ['default' => 'berlin'],
    'FR' => ['default' => 'paris'],
    'ES' => ['default' => 'madrid'],
    'IT' => ['default' => 'rome'],
    'NL' => ['default' => 'amsterdam'],
    'default' => 'new-york'
  ];
  
  if ($country && isset($cityMap[$country])) {
    $countryMap = $cityMap[$country];
    if ($region && isset($countryMap[$region])) {
      return $countryMap[$region];
    }
    return $countryMap['default'];
  }
  
  // Default to New York
  return 'new-york';
}

function without_locale_prefix(string $path): string {
  return preg_replace('#^/[a-z]{2}-[a-z]{2}#i','',$path);
}

function current_breadcrumbs(): array {
  return [
    ['name'=>'Home','url'=>absolute_url('/')],
  ];
}

function inject_jsonld(array $schemas): void {
  $GLOBALS['__jsonld'] = array_merge($GLOBALS['__jsonld'] ?? [], $schemas);
}

function csv_to_map(string $file, string $key): array {
  $path = __DIR__.'/../data/'.$file;
  if (!file_exists($path)) return [];
  $fh = fopen($path,'r');
  $hdr = fgetcsv($fh);
  $map = [];
  while ($row = fgetcsv($fh)) {
    $assoc = array_combine($hdr, $row);
    $map[$assoc[$key]] = $assoc;
  }
  fclose($fh);
  return $map;
}

function csv_to_rows(string $file): array {
  $path = __DIR__.'/../data/'.$file;
  if (!file_exists($path)) return [];
  $fh = fopen($path,'r');
  $hdr = fgetcsv($fh);
  $rows = [];
  while ($row = fgetcsv($fh)) {
    if (count($row) === count($hdr) && !empty(array_filter($row))) {
      $rows[] = array_combine($hdr, $row);
    }
  }
  fclose($fh);
  return $rows;
}

function asset_url(string $path): string {
  $abs = __DIR__ . '/../public' . $path;
  $ver = file_exists($abs) ? substr(md5((string)@filemtime($abs)),0,8) : '0';
  return $path . '?v=' . $ver;
}

if (!function_exists('absolute_url')) {
  function absolute_url(string $path): string {
    // Always use HTTPS for canonicals (modern hosting handles SSL termination)
    $isHttps = (
      (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
      (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
      (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') ||
      (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
    );
    $scheme = $isHttps || (($_SERVER['APP_ENV'] ?? 'production') === 'production') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
    return rtrim("$scheme://$host", '/') . '/' . ltrim($path, '/');
  }
}

function meta_for_slug(string $slug): array {
  require_once __DIR__ . '/csv.php';
  
  switch ($slug) {
    case 'home/home':
      return [
        'NRLC.ai — AI SEO & GEO-16 Framework | LLM Optimization',
        'NRLC.ai engineers crawl clarity, structured data, and LLM seeding strategies. GEO-16 framework for AI engine optimization across major cities.',
        '/'
      ];
      
    case 'services/service':
      $serviceSlug = $_GET['service'] ?? '';
      $services = csv_read_data('services.csv');
      $serviceData = array_filter($services, fn($s) => ($s['slug'] ?? '') === $serviceSlug);
      $serviceName = !empty($serviceData) ? reset($serviceData)['name'] : ucwords(str_replace('-', ' ', $serviceSlug));
      
      // AEO-optimized: Direct answer format
      $desc = "Expert $serviceName services by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Get results with proven AI SEO strategies.";
      
      return [
        "$serviceName Services | Expert AI SEO | NRLC.ai",
        $desc,
        "/services/$serviceSlug/"
      ];
      
    case 'services/service_city':
      $serviceSlug = $_GET['service'] ?? '';
      $citySlug = $_GET['city'] ?? '';
      
      $services = csv_read_data('services.csv');
      $cities = csv_read_data('cities.csv');
      
      $serviceData = array_filter($services, fn($s) => ($s['slug'] ?? '') === $serviceSlug);
      $cityData = array_filter($cities, fn($c) => ($c['city_name'] ?? '') === $citySlug);
      
      $serviceName = !empty($serviceData) ? reset($serviceData)['name'] : ucwords(str_replace('-', ' ', $serviceSlug));
      $cityName = !empty($cityData) ? reset($cityData)['city_name'] : ucwords(str_replace('-', ' ', $citySlug));
      
      // Special optimization for Singapore (high impressions, 0% CTR)
      $isSingapore = strtolower($citySlug) === 'singapore' || stripos($cityName, 'Singapore') !== false;
      
      if ($isSingapore) {
        // CTR-optimized: Include "AI SEO Singapore" in title for query match
        // Keep title under 60 chars for optimal SERP display
        $title = "AI SEO Singapore | $serviceName Services | NRLC.ai";
        if (strlen($title) > 60) {
          // Truncate service name if needed
          $shortService = substr($serviceName, 0, 30);
          $title = "AI SEO Singapore | $shortService | NRLC.ai";
        }
        
        // Benefit-driven description with Singapore-specific value prop
        $desc = "Expert AI SEO services in Singapore. $serviceName with proven results. GEO-16 framework, structured data optimization, and AI engine citation readiness. Free consultation for Singapore businesses.";
        if (strlen($desc) > 160) {
          $desc = substr($desc, 0, 157) . '...';
        }
      } else {
        // AEO-optimized description: Answer-focused, benefit-driven
        $desc = "Get $serviceName in $cityName. Expert AI SEO services with proven results. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Free consultation available.";
        
        $title = "$serviceName in $cityName | Expert AI SEO Services | NRLC.ai";
      }
      
      return [
        $title,
        $desc,
        "/services/$serviceSlug/$citySlug/"
      ];
      
    case 'careers/career_city':
      $citySlug = $_GET['city'] ?? '';
      $roleSlug = $_GET['role'] ?? '';
      
      $cities = csv_read_data('cities.csv');
      $careers = csv_read_data('careers.csv');
      
      $cityData = array_filter($cities, fn($c) => ($c['city_name'] ?? '') === $citySlug);
      $careerData = array_filter($careers, fn($r) => ($r['slug'] ?? '') === $roleSlug);
      
      $cityName = !empty($cityData) ? reset($cityData)['city_name'] : ucwords(str_replace('-', ' ', $citySlug));
      $roleTitle = !empty($careerData) ? reset($careerData)['title'] : ucwords(str_replace('-', ' ', $roleSlug));
      
      // AEO-optimized: Job-focused description
      $desc = "Apply for $roleTitle jobs in $cityName at NRLC.ai. Remote-friendly positions. Work on AI SEO, GEO-16 framework development, structured data optimization, and LLM citation strategies. Competitive salary and benefits.";
      
      return [
        "$roleTitle Jobs in $cityName | Apply Now | NRLC.ai Careers",
        $desc,
        "/careers/$citySlug/$roleSlug/"
      ];
      
    case 'insights/article':
      $articleSlug = $_GET['slug'] ?? '';
      
      // Special handling for silent-hydration-seo article
      if ($articleSlug === 'silent-hydration-seo') {
        return [
          'The Silent Killer of SEO: How JavaScript Hydration Failures Suppress Rankings',
          'Discover how silent JavaScript hydration failures cause Google to index broken versions of modern websites, quietly suppressing rankings despite perfect SEO signals.',
          "/insights/$articleSlug/"
        ];
      }
      
      $insights = csv_read_data('insights.csv');
      $articleData = array_filter($insights, fn($i) => ($i['slug'] ?? '') === $articleSlug);
      
      if (!empty($articleData)) {
        $article = reset($articleData);
        $title = $article['title'] ?? ucwords(str_replace('-', ' ', $articleSlug));
        $keywords = $article['keywords'] ?? 'AI SEO, GEO-16, LLM Seeding';
        
        // Build SEO-optimized title (keep under 60 chars ideally)
        // Use the article title + Research suffix
        $shortTitle = $title;
        if (strlen($shortTitle) > 50) {
          // Truncate smartly at word boundary
          $shortTitle = substr($shortTitle, 0, 47);
          $shortTitle = substr($shortTitle, 0, strrpos($shortTitle, ' ')) . '...';
        }
        
        // AEO-optimized description: Answer-focused
        $desc = "Learn $keywords. Comprehensive guide with practical insights and proven strategies for AI-first SEO optimization. Research-backed by NRLC.ai experts.";
        if (strlen($desc) > 160) {
          $desc = substr($desc, 0, 157) . '...';
        }
        
        return [
          "$shortTitle | NRLC.ai Research",
          $desc,
          "/insights/$articleSlug/"
        ];
      }
      
      return [
        'AI SEO Research & Insights | NRLC.ai',
        'Latest research and insights on AI SEO, GEO-16 framework, LLM seeding, and structured data optimization.',
        '/insights/'
      ];
      
    case 'insights/index':
      return [
        'AI SEO Research & Insights | NRLC.ai — GEO-16 Studies',
        'Research and insights on AI SEO, GEO-16 framework, LLM seeding, structured data optimization, and AI engine citation strategies.',
        '/insights/'
      ];
      
    case 'services/index':
      return [
        'AI SEO Services | NRLC.ai — Crawl Clarity & LLM Seeding',
        'Professional AI SEO services by NRLC.ai. Crawl clarity engineering, JSON-LD strategy, LLM seeding, and GEO-16 framework implementation.',
        '/services/'
      ];
      
    case 'careers/index':
      return [
        'Careers at NRLC.ai — AI SEO Jobs & LLM Roles',
        'Join NRLC.ai team. Careers in AI SEO, GEO-16 framework development, structured data optimization, and LLM citation strategies.',
        '/careers/'
      ];
      
    default:
      return [
        'NRLC.ai — AI SEO & GEO-16 Framework | LLM Optimization',
        'NRLC.ai engineers crawl clarity, structured data, and LLM seeding strategies. GEO-16 framework for AI engine optimization.',
        '/'
      ];
  }
}

function extract_keywords_from_title(string $title): string {
  // Extract relevant keywords from title for meta keywords
  $keywords = [];
  
  // Common AI SEO terms
  $aiTerms = ['AI SEO', 'GEO-16', 'LLM Seeding', 'Structured Data', 'Crawl Clarity', 'AI Engine', 'Citation', 'Optimization'];
  
  // Extract city names (both formatted and slug versions)
  $cities = ['New York', 'London', 'Seoul', 'Tokyo', 'Singapore', 'Toronto', 'new-york', 'london', 'seoul', 'tokyo', 'singapore', 'toronto'];
  
  // Extract service terms
  $services = ['Crawl Clarity', 'JSON-LD', 'LLM Seeding', 'Site Audits', 'International SEO', 'SEO Specialist', 'Research', 'Insights'];
  
  foreach ($aiTerms as $term) {
    if (stripos($title, $term) !== false) {
      $keywords[] = $term;
    }
  }
  
  foreach ($cities as $city) {
    if (stripos($title, $city) !== false) {
      $keywords[] = ucwords(str_replace('-', ' ', $city));
    }
  }
  
  foreach ($services as $service) {
    if (stripos($title, $service) !== false) {
      $keywords[] = $service;
    }
  }
  
  // Add NRLC.ai branding
  $keywords[] = 'NRLC.ai';
  
  return implode(', ', array_unique($keywords));
}

