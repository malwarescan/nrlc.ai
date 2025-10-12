<?php
function absolute_url(string $path): string {
  $scheme = ($_SERVER['HTTPS'] ?? '') === 'on' ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  if ($path === '') $path = '/';
  return $scheme.'://'.$host.$path;
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
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
    return rtrim("$scheme://$host", '/') . '/' . ltrim($path, '/');
  }
}

function meta_for_slug(string $slug): array {
  require_once __DIR__ . '/csv.php';
  
  switch ($slug) {
    case 'home/home':
      return [
        'NRLC.ai — AI SEO & GEO-16 Framework | Optimize for LLM Citation',
        'NRLC.ai engineers crawl clarity, structured data, and LLM seeding strategies. GEO-16 framework for AI engine optimization across major cities.',
        '/'
      ];
      
    case 'services/service':
      $serviceSlug = $_GET['service'] ?? '';
      $services = csv_read_data('services.csv');
      $serviceData = array_filter($services, fn($s) => ($s['slug'] ?? '') === $serviceSlug);
      $serviceName = !empty($serviceData) ? reset($serviceData)['name'] : ucwords(str_replace('-', ' ', $serviceSlug));
      
      return [
        "$serviceName Services | NRLC.ai — AI SEO",
        "Professional $serviceName services by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness.",
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
      
      return [
        "$serviceName in $cityName | NRLC.ai — AI SEO Services",
        "Professional $serviceName services in $cityName by NRLC.ai. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness.",
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
      
      return [
        "$roleTitle Jobs in $cityName | Careers at NRLC.ai",
        "Join NRLC.ai as $roleTitle in $cityName. Work on AI SEO, GEO-16 framework, structured data optimization, and LLM citation strategies.",
        "/careers/$citySlug/$roleSlug/"
      ];
      
    case 'insights/article':
      $articleSlug = $_GET['slug'] ?? '';
      $insights = csv_read_data('insights.csv');
      $articleData = array_filter($insights, fn($i) => ($i['slug'] ?? '') === $articleSlug);
      
      if (!empty($articleData)) {
        $article = reset($articleData);
        $title = $article['title'] ?? ucwords(str_replace('-', ' ', $articleSlug));
        $keywords = $article['keywords'] ?? 'AI SEO, GEO-16, LLM Seeding';
        
        // Truncate title if too long
        $shortTitle = strlen($title) > 45 ? substr($title, 0, 42) . '...' : $title;
        
        // Truncate description if too long
        $desc = "$title - Research by NRLC.ai covering $keywords. GEO-16 framework insights, AI SEO strategies, and LLM optimization.";
        $shortDesc = strlen($desc) > 160 ? substr($desc, 0, 157) . '...' : $desc;
        
        return [
          "$shortTitle | NRLC.ai Research",
          $shortDesc,
          "/insights/$articleSlug/"
        ];
      }
      
      return [
        'AI SEO Research & Insights | NRLC.ai',
        'Latest research and insights on AI SEO, GEO-16 framework, LLM seeding, and structured data optimization by NRLC.ai.',
        '/insights/'
      ];
      
    case 'insights/index':
      return [
        'AI SEO Research & Insights | NRLC.ai — GEO-16 Framework Studies',
        'Research and insights on AI SEO, GEO-16 framework, LLM seeding, structured data optimization, and AI engine citation strategies by NRLC.ai.',
        '/insights/'
      ];
      
    case 'services/index':
      return [
        'AI SEO Services | NRLC.ai — Crawl Clarity & LLM Seeding',
        'Professional AI SEO services by NRLC.ai. Crawl clarity engineering, JSON-LD strategy, LLM seeding optimization, and GEO-16 framework implementation.',
        '/services/'
      ];
      
    case 'careers/index':
      return [
        'Careers at NRLC.ai — AI SEO Jobs & LLM Optimization Roles',
        'Join NRLC.ai team. Careers in AI SEO, GEO-16 framework development, structured data optimization, and LLM citation strategies.',
        '/careers/'
      ];
      
    default:
      return [
        'NRLC.ai — AI SEO & GEO-16 Framework | Optimize for LLM Citation',
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

