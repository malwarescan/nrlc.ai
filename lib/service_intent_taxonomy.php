<?php
/**
 * SERVICE INTENT TAXONOMY HELPER
 * 
 * GLOBAL RULE: URL is the contract. Hero confirms it. CTA fulfills it.
 * 
 * Four intent classes:
 * 1. Core Service (Non-Geo): /services/{service}/
 * 2. Geo Service (Primary): /services/{service}/{city}/
 * 3. Sub-Service: /services/{service}/{sub-service}/
 * 4. Audit/Diagnostic: /services/{audit-type}/ or /services/{audit-type}/{city}/
 */

/**
 * Generate H1, subhead, and CTA based on service URL pattern
 * 
 * @param string $serviceSlug Service slug (e.g., 'site-audits')
 * @param string|null $citySlug City slug (e.g., 'southport') or null for non-geo
 * @param string|null $subService Sub-service slug or null
 * @return array ['h1' => string, 'subhead' => string, 'cta' => string, 'cta_qualifier' => string]
 */
function service_intent_content(string $serviceSlug, ?string $citySlug = null, ?string $subService = null): array {
  $serviceTitle = ucwords(str_replace(['-', '_'], ' ', $serviceSlug));
  $cityTitle = $citySlug ? (function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-', '_'], ' ', $citySlug))) : null;
  
  // Detect audit/diagnostic services
  $isAudit = in_array($serviceSlug, ['site-audits', 'technical-seo-audits', 'ai-visibility-audits', 'crawl-audits']);
  
  // CLASS 1: Core Service (Non-Geo) - /services/{service}/
  if (!$citySlug && !$subService) {
    if ($isAudit) {
      // CLASS 4: Audit/Diagnostic (non-geo)
      // Fix pluralization: "Site Audits" -> "Site Audit" for CTA
      $ctaServiceTitle = $serviceTitle;
      if (substr($serviceTitle, -1) === 's' && strpos($serviceTitle, ' ') !== false) {
        $ctaServiceTitle = rtrim($serviceTitle, 's');
      }
      return [
        'h1' => "Professional $serviceTitle for Growth-Focused Businesses",
        'subhead' => "We identify the technical, structural, and trust issues holding your website back — and provide clear, actionable fixes.",
        'cta' => "Request a $ctaServiceTitle",
        'cta_qualifier' => "Written diagnostic. No generic reports."
      ];
    } else {
      // CLASS 1: Core Service
      return [
        'h1' => "Professional $serviceTitle for Growth-Focused Businesses",
        'subhead' => "We help businesses improve search rankings and AI visibility through structured data, semantic optimization, and technical SEO.",
        'cta' => "Request $serviceTitle Services",
        'cta_qualifier' => "No obligation. Response within 24 hours."
      ];
    }
  }
  
  // CLASS 2: Geo Service (Primary) - /services/{service}/{city}/
  if ($citySlug && !$subService) {
    if ($isAudit) {
      // CLASS 4: Audit/Diagnostic (geo)
      // Fix pluralization: "Site Audits" -> "Site Audit" for CTA
      $ctaServiceTitle = $serviceTitle;
      if (substr($serviceTitle, -1) === 's' && strpos($serviceTitle, ' ') !== false) {
        $ctaServiceTitle = rtrim($serviceTitle, 's');
      }
      return [
        'h1' => "$serviceTitle for $cityTitle Businesses",
        'subhead' => "Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).",
        'cta' => "Request a $cityTitle $ctaServiceTitle",
        'cta_qualifier' => "You receive a written diagnostic. No obligation."
      ];
    } else {
      // CLASS 2: Geo Service - CONVERSION-FIRST STRUCTURE
      return [
        'h1' => "$serviceTitle for $cityTitle Businesses",
        'subhead' => "Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).",
        'cta' => "Request a $cityTitle $serviceTitle",
        'cta_qualifier' => "No obligation. Response within 24 hours."
      ];
    }
  }
  
  // CLASS 3: Sub-Service - /services/{service}/{sub-service}/
  if ($subService) {
    $subServiceTitle = ucwords(str_replace(['-', '_'], ' ', $subService));
    return [
      'h1' => "$serviceTitle: $subServiceTitle",
      'subhead' => "We provide specialized $subServiceTitle capabilities within our $serviceTitle offering.",
      'cta' => "Request $subServiceTitle $serviceTitle",
      'cta_qualifier' => "Focused service. Not a full engagement."
    ];
  }
  
  // Fallback
  return [
    'h1' => "$serviceTitle Services",
    'subhead' => "Professional $serviceTitle services to improve your search visibility and AI eligibility.",
    'cta' => "Request $serviceTitle Services",
    'cta_qualifier' => "No obligation. Response within 24 hours."
  ];
}

/**
 * Generate meta title following the formula: {Service} in {Location} | {Service Modifier}
 * 
 * @param string $serviceSlug
 * @param string|null $citySlug
 * @return string
 */
function service_meta_title(string $serviceSlug, ?string $citySlug = null): string {
  $serviceTitle = ucwords(str_replace(['-', '_'], ' ', $serviceSlug));
  $cityTitle = $citySlug ? (function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-', '_'], ' ', $citySlug))) : null;
  
  // CONVERSION-FIRST: All geo service pages use "Conversion + AI Visibility" modifier
  $modifier = "Conversion + AI Visibility";
  
  if ($cityTitle) {
    return "$serviceTitle in $cityTitle | $modifier | NRLC.ai";
  }
  
  // Non-geo services
  if (in_array($serviceSlug, ['site-audits', 'technical-seo-audits'])) {
    $auditModifier = $serviceSlug === 'site-audits' ? 'Technical & Structural Website Audits' : 'Crawl & Indexing Diagnostics';
    return "$serviceTitle | $auditModifier | NRLC.ai";
  }
  
  return "$serviceTitle | $serviceTitle Services | NRLC.ai";
}

/**
 * Generate meta description following the formula
 * 
 * @param string $serviceSlug
 * @param string|null $citySlug
 * @return string
 */
function service_meta_description(string $serviceSlug, ?string $citySlug = null): string {
  // CONVERSION-FIRST: Standard meta description for all geo service pages
  return "Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).";
}

/**
 * Validate CTA text - fails if generic
 * 
 * @param string $ctaText
 * @return bool True if valid (service-named), false if generic
 */
function validate_service_cta(string $ctaText): bool {
  $genericCTAs = ['contact us', 'learn more', 'get in touch', 'book a call'];
  $ctaLower = strtolower($ctaText);
  
  foreach ($genericCTAs as $generic) {
    if (strpos($ctaLower, $generic) !== false) {
      return false;
    }
  }
  
  // Must contain service-related keywords
  $serviceKeywords = ['request', 'audit', 'service', 'consultation', 'diagnostic'];
  $hasServiceKeyword = false;
  foreach ($serviceKeywords as $keyword) {
    if (strpos($ctaLower, $keyword) !== false) {
      $hasServiceKeyword = true;
      break;
    }
  }
  
  return $hasServiceKeyword;
}

