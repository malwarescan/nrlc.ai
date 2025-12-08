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
function get_related_services_for_linking(string $serviceSlug, string $locale = ''): array {
  // Core services that should be linked
  $coreServices = [
    'crawl-clarity' => 'Crawl Clarity Engineering',
    'json-ld-strategy' => 'JSON-LD & Structured Data',
    'llm-seeding' => 'LLM Seeding & Citation',
    'ai-overview-optimization' => 'AI Overviews Optimization',
  ];
  
  // Remove current service
  unset($coreServices[$serviceSlug]);
  
  // Return first 3
  $related = [];
  $count = 0;
  foreach ($coreServices as $slug => $name) {
    if ($count >= 3) break;
    $related[] = [
      'slug' => $slug,
      'name' => $name,
      'url' => ($locale ? "/$locale" : '') . "/services/$slug/"
    ];
    $count++;
  }
  
  return $related;
}

