<?php
/**
 * Service Enhancement Helpers
 * Query alignment and service name mapping
 */

/**
 * Get service name from slug
 */
function get_service_name_from_slug(string $slug): string {
  $map = [
    'crawl-clarity' => 'Crawl Clarity Engineering',
    'json-ld-strategy' => 'JSON-LD & Structured Data Strategy',
    'llm-seeding' => 'LLM Seeding & Citation Readiness',
    'ai-overview-optimization' => 'AI Overviews Optimization',
    'site-audits' => 'AI-First Site Audits',
    'technical-seo' => 'Technical SEO & Sitemaps',
    'generative-seo' => 'Generative SEO',
    'agentic-seo' => 'Agentic SEO',
    'llm-optimization' => 'LLM Optimization',
    'local-seo-ai' => 'Local SEO & AI Discovery',
    'ecommerce-ai-seo' => 'E-commerce AI SEO',
    'b2b-seo-ai' => 'B2B AI SEO',
    'content-optimization-ai' => 'AI Content Optimization',
    'technical-audit-ai' => 'AI Technical Audit',
    'competitor-analysis-ai' => 'AI Competitor Analysis',
    'link-building-ai' => 'AI Link Building',
    'conversion-optimization-ai' => 'Conversion Optimization',
    'mobile-seo-ai' => 'Mobile AI SEO',
    'schema-markup-ai' => 'AI Schema Markup',
    'entity-optimization-ai' => 'Entity Optimization',
    'semantic-seo-ai' => 'Semantic SEO',
    'knowledge-graph-ai' => 'Knowledge Graph AI',
    'featured-snippets-ai' => 'Featured Snippets AI',
    'chatgpt-optimization' => 'ChatGPT Optimization',
    'claude-optimization' => 'Claude Optimization',
    'perplexity-optimization' => 'Perplexity Optimization',
    'copilot-optimization' => 'Copilot Optimization',
    'ai-search-optimization' => 'AI Search Optimization',
    'ai-citation-optimization' => 'AI Citation Optimization',
    'structured-data-ai' => 'Structured Data for AI',
    'metadata-optimization-ai' => 'Metadata Optimization',
    'entity-recognition-ai' => 'Entity Recognition AI',
    'topic-modeling-ai' => 'Topic Modeling AI',
    'intent-optimization-ai' => 'Intent Optimization AI',
    'contextual-seo-ai' => 'Contextual SEO AI',
    'multimodal-seo-ai' => 'Multimodal SEO AI',
    'conversational-seo-ai' => 'Conversational SEO AI',
    'personalization-ai' => 'Personalization AI SEO',
    'recommendation-ai' => 'Recommendation AI SEO',
    'retrieval-optimization-ai' => 'Retrieval Optimization AI',
    'ranking-optimization-ai' => 'Ranking Optimization AI',
    'relevance-optimization-ai' => 'Relevance Optimization AI',
    'accuracy-optimization-ai' => 'Accuracy Optimization AI',
    'completeness-optimization-ai' => 'Completeness Optimization AI',
    'freshness-optimization-ai' => 'Freshness Optimization AI',
    'authority-optimization-ai' => 'Authority Optimization AI',
    'trust-optimization-ai' => 'Trust Optimization AI',
    'verification-optimization-ai' => 'Verification Optimization AI',
    'transparency-optimization-ai' => 'Transparency Optimization AI',
    'explainability-optimization-ai' => 'Explainability Optimization AI',
  ];
  
  return $map[$slug] ?? ucwords(str_replace('-', ' ', $slug));
}

/**
 * Get service type from slug
 */
function get_service_type_from_slug(string $slug): string {
  if (strpos($slug, 'seo') !== false) {
    return 'AI SEO Optimization';
  }
  if (strpos($slug, 'structured-data') !== false || strpos($slug, 'schema') !== false) {
    return 'Structured Data Engineering';
  }
  if (strpos($slug, 'llm') !== false || strpos($slug, 'claude') !== false || strpos($slug, 'chatgpt') !== false) {
    return 'LLM Strategy & Architecture';
  }
  if (strpos($slug, 'ranking') !== false) {
    return 'Search Ranking Optimization';
  }
  if (strpos($slug, 'mobile') !== false) {
    return 'Mobile SEO Performance';
  }
  
  return 'AI-First SEO Services';
}

/**
 * Determine service mapping from service slug
 */
function get_service_mapping(string $serviceSlug): string {
  $slug = strtolower($serviceSlug);
  
  // enterprise_ai_hiring
  if (preg_match('/\b(jobs?|hiring|recruiter|applicant|career|position|vacancy)\b/i', $slug)) {
    return 'enterprise_ai_hiring';
  }
  
  // structured_data_engineering
  if (preg_match('/\b(schema|json-ld|structured\s+data|rich\s+results?|microdata|rdfa|semantic\s+markup)\b/i', $slug)) {
    return 'structured_data_engineering';
  }
  
  // llm_strategy
  if (preg_match('/\b(llm|ai\s+strategy|agentic|generative|chatgpt|claude|perplexity|copilot|bard|ai\s+visibility)\b/i', $slug)) {
    return 'llm_strategy';
  }
  
  // ranking_optimization
  if (preg_match('/\b(ranking|rank|position|serp|top\s+results?|first\s+page)\b/i', $slug)) {
    return 'ranking_optimization';
  }
  
  // mobile_ai_seo
  if (preg_match('/\b(mobile|responsive|mobile-first|mobile\s+seo)\b/i', $slug)) {
    return 'mobile_ai_seo';
  }
  
  // ai_seo (catch-all for SEO terms)
  if (preg_match('/\b(seo|audit|optimization|crawl|sitemap|technical)\b/i', $slug)) {
    return 'ai_seo';
  }
  
  return 'ai_seo';
}

/**
 * Get query-aligned content based on URL patterns
 */
function get_query_aligned_content(string $serviceSlug, string $citySlug = ''): string {
  $content = '';
  
  // SEO-related services
  if (strpos($serviceSlug, 'seo') !== false) {
    $content .= "Addresses queries like 'seo jobs' and 'llm jobs' by optimizing your site's visibility in both traditional search and AI-powered engines. ";
  }
  
  // Ranking-related services
  if (strpos($serviceSlug, 'ranking') !== false) {
    $content .= "Targets 'ai visibility' and 'search optimization' queries to improve your position in search results and AI Overviews. ";
  }
  
  // Claude/ChatGPT/LLM services
  if (strpos($serviceSlug, 'claude') !== false || strpos($serviceSlug, 'chatgpt') !== false || strpos($serviceSlug, 'llm') !== false) {
    $content .= "Aligns with 'llm jobs' and 'llm strategist' search intent, ensuring your content surfaces when users query AI assistants. ";
  }
  
  // Mobile services
  if (strpos($serviceSlug, 'mobile') !== false) {
    $content .= "Optimizes for 'ai seo' and 'search performance' queries, ensuring mobile-first experiences rank in both Google and AI search results. ";
  }
  
  // Structured data/schema services
  if (strpos($serviceSlug, 'structured-data') !== false || strpos($serviceSlug, 'schema') !== false) {
    $content .= "Targets 'structured data' and 'schema' queries, implementing machine-readable markup that both search engines and AI models understand. ";
  }
  
  return trim($content);
}

/**
 * Get related services for lateral linking (same locale)
 */
function get_related_services_for_linking(string $serviceSlug, string $locale = '', string $citySlug = ''): array {
  require_once __DIR__.'/helpers.php';
  
  // Core services that should be linked
  $coreServices = [
    'crawl-clarity' => 'Crawl Clarity Engineering',
    'json-ld-strategy' => 'JSON-LD & Structured Data',
    'llm-seeding' => 'LLM Seeding & Citation',
    'ai-overview-optimization' => 'AI Overviews Optimization',
  ];
  
  // Remove current service
  unset($coreServices[$serviceSlug]);
  
  // Initialize related array
  $related = [];
  
  // If city is provided, determine canonical locale for city-specific links
  if ($citySlug) {
    $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
    $canonicalLocale = $isUK ? 'en-gb' : ($locale ?: 'en-us');
    
    // Add city-specific service links (same city, different services)
    $cityServices = [
      'site-audits' => 'Site Audits',
      'technical-seo' => 'Technical SEO',
      'link-building-ai' => 'Link Building',
    ];
    
    foreach ($cityServices as $slug => $name) {
      if ($slug !== $serviceSlug && !isset($coreServices[$slug])) {
        $related[] = [
          'slug' => $slug,
          'name' => "$name in " . ucwords(str_replace(['-', '_'], ' ', $citySlug)),
          'url' => canonical_internal_url("/services/$slug/$citySlug/")
        ];
      }
    }
  }
  
  // Return first 3 core services
  $count = 0;
  foreach ($coreServices as $slug => $name) {
    if ($count >= 3) break;
    
    // Generate canonical URL using canonical_internal_url()
    if ($citySlug) {
      $url = canonical_internal_url("/services/$slug/$citySlug/");
    } else {
      $url = canonical_internal_url("/services/$slug/");
    }
    
    $related[] = [
      'slug' => $slug,
      'name' => $name,
      'url' => $url
    ];
    $count++;
  }
  
  return $related;
}

/**
 * Get all cities available for a specific service
 * Returns array of city slugs with their canonical locales
 * 
 * @param string $serviceSlug Service slug (e.g., 'relevance-optimization-ai')
 * @param int $limit Maximum number of cities to return (0 = all)
 * @return array Array of ['city' => citySlug, 'locale' => 'en-gb'|'en-us', 'name' => 'City Name']
 */
function get_cities_for_service(string $serviceSlug, int $limit = 0): array {
  require_once __DIR__.'/helpers.php';
  
  static $serviceCitiesCache = [];
  
  // Check cache first
  if (isset($serviceCitiesCache[$serviceSlug])) {
    $cities = $serviceCitiesCache[$serviceSlug];
    return $limit > 0 ? array_slice($cities, 0, $limit) : $cities;
  }
  
  $enhancementsFile = __DIR__ . '/../data/service_enhancements.json';
  if (!file_exists($enhancementsFile)) {
    return [];
  }
  
  $data = json_decode(file_get_contents($enhancementsFile), true);
  if (!is_array($data)) {
    return [];
  }
  
  $cities = [];
  $seenCities = [];
  
  foreach ($data as $item) {
    // Only include items with cities and matching service
    if (($item['service'] ?? '') === $serviceSlug && 
        !empty($item['city'] ?? '') && 
        ($item['has_city'] ?? false)) {
      
      $citySlug = $item['city'];
      
      // Skip duplicates (use first occurrence)
      if (isset($seenCities[$citySlug])) {
        continue;
      }
      $seenCities[$citySlug] = true;
      
      // Determine canonical locale
      $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
      $isSingapore = (strtolower($citySlug) === 'singapore');
      $isAustralian = function_exists('is_australian_city') ? is_australian_city($citySlug) : false;
      $canonicalLocale = function_exists('get_canonical_locale_for_city') 
        ? get_canonical_locale_for_city($citySlug)
        : ($isUK ? 'en-gb' : ($isSingapore ? 'en-sg' : ($isAustralian ? 'en-au' : 'en-us')));
      
      // Get city name
      $cityName = titleCaseCity($citySlug);
      
      $cities[] = [
        'city' => $citySlug,
        'locale' => $canonicalLocale,
        'name' => $cityName,
        'isUK' => $isUK
      ];
    }
  }
  
  // Sort: UK cities first, then US cities, then alphabetically
  usort($cities, function($a, $b) {
    if ($a['isUK'] !== $b['isUK']) {
      return $b['isUK'] ? 1 : -1; // UK cities first
    }
    return strcmp($a['name'], $b['name']);
  });
  
  // Cache result
  $serviceCitiesCache[$serviceSlug] = $cities;
  
  return $limit > 0 ? array_slice($cities, 0, $limit) : $cities;
}

/**
 * Generate service-specific city description
 * 
 * @param string $serviceSlug Service slug
 * @param string $citySlug City slug
 * @param string $cityName City display name
 * @param bool $isUK Whether city is in UK
 * @return string Service-specific description
 */
function get_service_city_description(string $serviceSlug, string $cityName, bool $isUK): string {
  $serviceName = get_service_name_from_slug($serviceSlug);
  
  // Service-specific description templates
  $descriptions = [
    'site-audits' => [
      'uk' => "Audit and implementation adapted for international and regulated markets common in {$cityName} business contexts.",
      'us' => "Audit and implementation adapted for multi-entity, multi-location environments common in {$cityName} markets."
    ],
    'relevance-optimization-ai' => [
      'uk' => "Relevance optimization tailored for {$cityName}'s competitive market, ensuring AI systems accurately understand and cite your business.",
      'us' => "Relevance optimization in {$cityName} with local market expertise and AI-first optimization strategies."
    ],
    'crawl-clarity' => [
      'uk' => "Crawl clarity engineering for {$cityName} businesses, eliminating technical barriers that prevent AI systems from understanding your site.",
      'us' => "Crawl clarity implementation in {$cityName} with technical SEO expertise and structured data optimization."
    ],
    'json-ld-strategy' => [
      'uk' => "JSON-LD strategy for {$cityName} businesses, implementing comprehensive structured data for AI engine recognition.",
      'us' => "JSON-LD and structured data strategy in {$cityName} with schema markup expertise."
    ],
    'llm-seeding' => [
      'uk' => "LLM seeding and citation optimization for {$cityName} businesses, ensuring AI systems reference your brand accurately.",
      'us' => "LLM seeding services in {$cityName} to improve AI engine citation rates and visibility."
    ],
    'ai-overviews-optimization' => [
      'uk' => "AI Overviews optimization for {$cityName} businesses, improving eligibility for Google AI Overview citations.",
      'us' => "AI Overviews optimization in {$cityName} with focus on citation eligibility and structured content."
    ]
  ];
  
  // Check for service-specific description
  if (isset($descriptions[$serviceSlug])) {
    $key = $isUK ? 'uk' : 'us';
    return $descriptions[$serviceSlug][$key];
  }
  
  // Generic fallback based on service type
  if (strpos($serviceSlug, 'optimization') !== false) {
    return $isUK 
      ? "Comprehensive {$serviceName} delivery in {$cityName} with UK market expertise."
      : "Full service implementation in {$cityName} with local expertise and support.";
  }
  
  // Default generic description
  return $isUK
    ? "Comprehensive service delivery in {$cityName} with UK market expertise."
    : "Full service implementation in {$cityName} with local expertise and support.";
}

/**
 * Get related services available in the same city
 * 
 * @param string $serviceSlug Current service slug
 * @param string $citySlug City slug
 * @param int $limit Maximum number of related services to return
 * @return array Array of ['slug' => serviceSlug, 'name' => 'Service Name', 'url' => canonicalUrl]
 */
function get_related_services_in_city(string $serviceSlug, string $citySlug, int $limit = 3): array {
  require_once __DIR__.'/helpers.php';
  
  // Core services that are commonly available in cities
  $coreServices = [
    'site-audits' => 'AI-First Site Audits',
    'crawl-clarity' => 'Crawl Clarity Engineering',
    'json-ld-strategy' => 'JSON-LD & Structured Data',
    'llm-seeding' => 'LLM Seeding & Citation',
    'ai-overviews-optimization' => 'AI Overviews Optimization',
    'technical-seo' => 'Technical SEO',
    'relevance-optimization-ai' => 'Relevance Optimization AI',
    'content-optimization-ai' => 'Content Optimization AI'
  ];
  
  $related = [];
  
  foreach ($coreServices as $slug => $name) {
    // Skip current service
    if ($slug === $serviceSlug) {
      continue;
    }
    
    // Check if this service-city combination exists
    $enhancement = get_service_enhancement($slug, $citySlug);
    if ($enhancement) {
      $related[] = [
        'slug' => $slug,
        'name' => $name,
        'url' => canonical_internal_url("/services/{$slug}/{$citySlug}/")
      ];
      
      if (count($related) >= $limit) {
        break;
      }
    }
  }
  
  return $related;
}
