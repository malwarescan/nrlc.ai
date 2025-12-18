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
  
  // Check if we're on localhost (any port)
  $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  $isLocalhost = in_array($host, ['localhost', '127.0.0.1']) || 
                 strpos($host, 'localhost:') === 0 || 
                 strpos($host, '127.0.0.1:') === 0;
  
  // Use HTTP for localhost, HTTPS for production
  $scheme = ($isLocalhost || !$isHttps) ? 'http' : 'https';
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

/**
 * Check if a city slug is a UK city
 * Returns true if the city is known to be in the UK
 */
/**
 * SUDO POWERED: Detect if a page is LOCAL (city-based) vs GLOBAL (translatable)
 * 
 * LOCAL pages:
 * - Have a city slug in the URL path
 * - Are geography-anchored
 * - Must NOT use hreflang
 * 
 * GLOBAL pages:
 * - Do not have city slugs
 * - Can be translated
 * - May use hreflang if translations are real
 * 
 * @param string $pathWithoutLocale Path without locale prefix (e.g., /services/technical-seo/)
 * @return bool True if LOCAL (city-based), false if GLOBAL
 */
function is_local_page(string $pathWithoutLocale): bool {
  // Check for city-based service pages: /services/{service}/{city}/
  if (preg_match('#^/services/([^/]+)/([^/]+)/#', $pathWithoutLocale, $m)) {
    $citySlug = $m[2];
    // If it's a known city (UK or US), it's LOCAL
    if (function_exists('is_uk_city') && is_uk_city($citySlug)) {
      return true;
    }
    // For now, assume any city slug in service path is LOCAL
    // Could enhance with US city detection
    return true;
  }
  
  // Check for city-based career pages: /careers/{city}/{role}/
  if (preg_match('#^/careers/([^/]+)/([^/]+)/#', $pathWithoutLocale)) {
    return true;
  }
  
  // All other pages are GLOBAL
  return false;
}

function is_uk_city(string $citySlug): bool {
  $ukCities = [
    'norwich', 'stockport', 'stoke-on-trent', 'derby', 'southport',
    'huddersfield', 'blackpool', 'burnley', 'oldham', 'halifax',
    'sudbury', 'nottingham', 'sheffield', 'southampton', 'london',
    'manchester', 'birmingham', 'leeds', 'glasgow', 'liverpool',
    'bristol', 'edinburgh', 'cardiff', 'belfast', 'newcastle',
    'cambridge', 'oxford', 'brighton', 'plymouth', 'coventry',
    'leicester', 'sunderland', 'wolverhampton', 'northampton',
    'middlesbrough', 'peterborough', 'bolton', 'reading', 'bournemouth',
    'swansea', 'southend-on-sea', 'hull', 'portsmouth', 'york'
  ];
  
  $cityLower = strtolower($citySlug);
  foreach ($ukCities as $ukCity) {
    if ($cityLower === $ukCity || strpos($cityLower, str_replace('-', '', $ukCity)) !== false) {
      return true;
    }
  }
  return false;
}

/**
 * Determine the canonical locale for a LOCAL page based on city
 * 
 * @param string $citySlug City slug from URL
 * @return string Canonical locale code (e.g., 'en-gb' for UK cities, 'en-us' for others)
 */
function get_canonical_locale_for_city(string $citySlug): string {
  if (is_uk_city($citySlug)) {
    return 'en-gb';
  }
  // Default to en-us for all other cities (US, Canadian, etc.)
  return 'en-us';
}

/**
 * Check if current locale is canonical for a LOCAL page
 * 
 * @param string $pathWithoutLocale Path without locale prefix (e.g., /services/technical-seo/london/)
 * @param string $currentLocale Current locale code (e.g., 'en-gb')
 * @return bool True if current locale is canonical for this LOCAL page
 */
function is_canonical_locale_for_local_page(string $pathWithoutLocale, string $currentLocale): bool {
  // Extract city from path
  if (preg_match('#^/services/([^/]+)/([^/]+)/#', $pathWithoutLocale, $m)) {
    $citySlug = $m[2];
    $canonicalLocale = get_canonical_locale_for_city($citySlug);
    return $currentLocale === $canonicalLocale;
  }
  
  if (preg_match('#^/careers/([^/]+)/([^/]+)/#', $pathWithoutLocale, $m)) {
    $citySlug = $m[1];
    $canonicalLocale = get_canonical_locale_for_city($citySlug);
    return $currentLocale === $canonicalLocale;
  }
  
  // Not a LOCAL page, so locale is always canonical
  return true;
}

function current_breadcrumbs(): array {
  // Context-aware breadcrumbs based on current page
  $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  $crumbs = [
    ['name'=>'Home','url'=>absolute_url('/en-us/')],
  ];
  
  // Remove locale prefix for matching (e.g., /en-us/insights/ -> /insights/)
  $pathWithoutLocale = preg_replace('#^/[a-z]{2}-[a-z]{2}#i', '', $path);
  if ($pathWithoutLocale === '') {
    $pathWithoutLocale = '/';
  }
  
  // Add Insights breadcrumb for insights hub and individual articles
  if (preg_match('#^/insights/#', $pathWithoutLocale) || preg_match('#^/insights$#', $pathWithoutLocale)) {
    $crumbs[] = ['name'=>'Insights','url'=>absolute_url('/en-us/insights/')];
  }
  
  // Add Services breadcrumb for services pages
  if (preg_match('#^/services/#', $pathWithoutLocale) || preg_match('#^/services$#', $pathWithoutLocale)) {
    $crumbs[] = ['name'=>'Services','url'=>absolute_url('/en-us/services/')];
  }
  
  // Add Careers breadcrumb for careers pages
  if (preg_match('#^/careers/#', $pathWithoutLocale) || preg_match('#^/careers$#', $pathWithoutLocale)) {
    $crumbs[] = ['name'=>'Careers','url'=>absolute_url('/en-us/careers/')];
  }
  
  return $crumbs;
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
      
      // Try to load enhancement from service_enhancements.json
      $enhancement = get_service_enhancement($serviceSlug, '');
      if ($enhancement) {
        return [
          $enhancement['title'],
          $enhancement['description'],
          $enhancement['path']
        ];
      }
      
      // Fallback to original logic
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
      
      // Try to load enhancement from service_enhancements.json
      $enhancement = get_service_enhancement($serviceSlug, $citySlug);
      if ($enhancement) {
        return [
          $enhancement['title'],
          $enhancement['description'],
          $enhancement['path']
        ];
      }
      
      // Fallback to original logic
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
      
    case 'resources/index':
      return [
        'AI SEO Resources & Tools | NRLC.ai',
        'Comprehensive AI SEO resources, templates, checklists, and implementation guides. GEO-16 framework resources, structured data templates, and LLM optimization tools.',
        '/resources/'
      ];
      
    case 'resources/resource':
      $resourceNumber = $_GET['resource'] ?? '1';
      // AEO-optimized: Resource-focused description
      $desc = "Access comprehensive AI SEO resource #$resourceNumber. Practical tools, templates, and implementation guides for GEO-16 framework, structured data optimization, and LLM citation strategies.";
      
      return [
        "AI SEO Resource #$resourceNumber | Implementation Guide | NRLC.ai",
        $desc,
        "/resources/resource-$resourceNumber/"
      ];
      
    default:
      return [
        'NRLC.ai — AI SEO & GEO-16 Framework | LLM Optimization',
        'NRLC.ai engineers crawl clarity, structured data, and LLM seeding strategies. GEO-16 framework for AI engine optimization.',
        '/'
      ];
  }
}

/**
 * Get service enhancement from service_enhancements.json
 * Returns enhancement data or null if not found
 */
function get_service_enhancement(string $serviceSlug, string $citySlug = ''): ?array {
  static $enhancements = null;
  static $enhancementsLoaded = false;
  
  if (!$enhancementsLoaded) {
    $enhancementsFile = __DIR__ . '/../data/service_enhancements.json';
    if (file_exists($enhancementsFile)) {
      $data = json_decode(file_get_contents($enhancementsFile), true);
      if (is_array($data)) {
        $enhancements = [];
        foreach ($data as $item) {
          $key = $item['service'] . '|' . ($item['city'] ?? '');
          $enhancements[$key] = $item;
        }
      }
    }
    $enhancementsLoaded = true;
  }
  
  $key = $serviceSlug . '|' . $citySlug;
  return $enhancements[$key] ?? null;
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

/**
 * Generate SEO-friendly title and aria-label attributes for buttons
 * 
 * @param string $buttonText The visible button text
 * @param string|null $context Additional context (e.g., article title, service name)
 * @param string|null $action Optional action description
 * @return array Array with 'title' and 'aria-label' keys
 */
function button_seo_attrs(string $buttonText, ?string $context = null, ?string $action = null): array {
  $attrs = [];
  
  // Generate title attribute (for SEO tooltips)
  if ($context) {
    $title = $action ? "$action: $context" : "$buttonText: $context";
  } else {
    // Generate descriptive title based on button text
    $titleMap = [
      'Read Article' => 'Read the full article',
      'View All' => 'View all items',
      'Contact Us' => 'Contact us for more information',
      'Learn More' => 'Learn more about this topic',
      'Get Started' => 'Get started with our services',
      'See More' => 'See more details',
      'View Details' => 'View detailed information',
      'Text Us' => 'Send us a text message',
      'Call Now' => 'Call us now',
      'Email Us' => 'Send us an email',
    ];
    
    $title = $titleMap[$buttonText] ?? $buttonText;
  }
  
  $attrs['title'] = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
  
  // Generate aria-label (for accessibility)
  if ($context) {
    $ariaLabel = $action ? "$action: $context" : "$buttonText: $context";
  } else {
    $ariaLabel = $title;
  }
  
  $attrs['aria-label'] = htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8');
  
  return $attrs;
}

/**
 * Render button HTML with SEO attributes
 * 
 * @param string $href The link URL
 * @param string $text The button text
 * @param string $classes Additional CSS classes (default: 'btn')
 * @param string|null $context Context for SEO attributes
 * @param string|null $action Action description for SEO
 * @return string HTML button/link element
 */
function render_seo_button(string $href, string $text, string $classes = 'btn', ?string $context = null, ?string $action = null): string {
  $attrs = button_seo_attrs($text, $context, $action);
  $escapedHref = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
  $escapedText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  $escapedClasses = htmlspecialchars($classes, ENT_QUOTES, 'UTF-8');
  
  return sprintf(
    '<a href="%s" class="%s" title="%s" aria-label="%s">%s</a>',
    $escapedHref,
    $escapedClasses,
    $attrs['title'],
    $attrs['aria-label'],
    $escapedText
  );
}

/**
 * Generate SEO-friendly title and aria-label attributes for navigation menu items
 * 
 * @param string $linkText The visible link text
 * @param string|null $description Optional description of what the link leads to
 * @return array Array with 'title' and 'aria-label' keys
 */
function menu_item_seo_attrs(string $linkText, ?string $description = null): array {
  $attrs = [];
  
  // Generate title attribute (for SEO tooltips and search engine context)
  if ($description) {
    $title = "$linkText - $description";
  } else {
    // Generate descriptive title based on link text
    $titleMap = [
      'Home' => 'Home - NRLC.ai',
      'Services' => 'Services - AI SEO Services & Solutions',
      'Insights' => 'Insights - AI SEO Research & Best Practices',
      'Careers' => 'Careers - Join the NRLC.ai Team',
      'Products' => 'Products - AI SEO Tools & Software',
      'Catalog' => 'Catalog - Browse All Services & Products',
      'Contact' => 'Contact - Get in Touch with NRLC.ai',
      'All Services' => 'All Services - View All AI SEO Services',
      'All Insights' => 'All Insights - Browse All AI SEO Research',
      'Crawl Clarity' => 'Crawl Clarity - Technical SEO Engineering Service',
      'JSON-LD Strategy' => 'JSON-LD Strategy - Structured Data Implementation',
      'LLM Seeding' => 'LLM Seeding - AI Search Engine Optimization',
      'Technical SEO' => 'Technical SEO - Website Performance & Optimization',
      'Site Audits' => 'Site Audits - Comprehensive SEO Analysis',
      'Semantic Modeling' => 'Semantic Modeling - AI SEO Research',
      'Data Virtualization' => 'Data Virtualization - AI SEO Research',
      'Enterprise LLM' => 'Enterprise LLM - AI SEO Research',
      'Performance & Caching' => 'Performance & Caching - AI SEO Research',
      'Data, But Structured' => 'Data, But Structured - AI SEO Product',
      'Applicants.io' => 'Applicants.io - AI SEO Product',
      'OurCasa.ai' => 'OurCasa.ai - AI SEO Product',
      'Croutons.ai' => 'Croutons.ai - AI SEO Product',
      'Precogs' => 'Precogs - AI SEO Product',
      'Googlebot Renderer Lab' => 'Googlebot Renderer Lab - AI SEO Product',
      'NEWFAQ' => 'NEWFAQ - AI SEO Product',
      'Neural Command OS' => 'Neural Command OS - AI SEO Product',
    ];
    
    $title = $titleMap[$linkText] ?? "$linkText - NRLC.ai";
  }
  
  $attrs['title'] = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
  
  // Generate aria-label (for accessibility - typically same as title for navigation)
  $attrs['aria-label'] = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
  
  return $attrs;
}

