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
 * 
 * LOCALE-AWARE: All content is localized for fr-fr, es-es, de-de, ko-kr
 */

/**
 * Get localized strings for service content
 */
function get_localized_service_strings(string $locale): array {
  $strings = [
    'en-us' => [
      'meta_modifier' => 'Conversion + AI Visibility',
      'meta_desc' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'See Proof / Case Studies',
      'cta_qualifier' => 'No obligation. Response within 24 hours.',
    ],
    'en-gb' => [
      'meta_modifier' => 'Conversion + AI Visibility',
      'meta_desc' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'See Proof / Case Studies',
      'cta_qualifier' => 'No obligation. Response within 24 hours.',
    ],
    'en-sg' => [
      'meta_modifier' => 'Conversion + AI Visibility',
      'meta_desc' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'See Proof / Case Studies',
      'cta_qualifier' => 'No obligation. Response within 24 hours.',
    ],
    'en-au' => [
      'meta_modifier' => 'Conversion + AI Visibility',
      'meta_desc' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'See Proof / Case Studies',
      'cta_qualifier' => 'No obligation. Response within 24 hours.',
    ],
    'fr-fr' => [
      'meta_modifier' => 'Conversion + visibilité IA',
      'meta_desc' => 'Un plan clair pour améliorer le classement et la conversion: technique, contenu, et visibilité IA (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Un plan clair pour améliorer le classement et la conversion: technique, contenu, et visibilité IA (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'Voir des preuves / études de cas',
      'cta_qualifier' => 'Sans engagement. Réponse sous 24 heures.',
    ],
    'es-es' => [
      'meta_modifier' => 'Conversión + visibilidad IA',
      'meta_desc' => 'Un plan accionable para subir rankings y conversión: técnica, contenido y visibilidad IA (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Un plan accionable para subir rankings y conversión: técnica, contenido y visibilidad IA (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'Ver pruebas / casos',
      'cta_qualifier' => 'Sin compromiso. Respuesta en 24 horas.',
    ],
    'de-de' => [
      'meta_modifier' => 'Conversion + KI-Sichtbarkeit',
      'meta_desc' => 'Ein klarer Plan für bessere Rankings und Conversion: Technik, Content-Lücken und KI-Auffindbarkeit (ChatGPT, Claude, Google AI Overviews).',
      'subhead' => 'Ein klarer Plan für bessere Rankings und Conversion: Technik, Content-Lücken und KI-Auffindbarkeit (ChatGPT, Claude, Google AI Overviews).',
      'cta_secondary' => 'Nachweise / Cases ansehen',
      'cta_qualifier' => 'Keine Verpflichtung. Antwort innerhalb von 24 Stunden.',
    ],
    'ko-kr' => [
      'meta_modifier' => '전환 + AI 가시성',
      'meta_desc' => '순위와 전환을 빠르게 끌어올리는 실행 계획: 기술 문제, 콘텐츠 공백, AI 검색 노출(챗GPT/클로드/Google AI Overviews).',
      'subhead' => '순위와 전환을 빠르게 끌어올리는 실행 계획: 기술 문제, 콘텐츠 공백, AI 검색 노출(챗GPT/클로드/Google AI Overviews).',
      'cta_secondary' => '사례/증거 보기',
      'cta_qualifier' => '의무 없음. 24시간 내 응답.',
    ],
  ];
  
  return $strings[$locale] ?? $strings['en-us'];
}

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
      // Apply locale-aware terminology
      require_once __DIR__ . '/locale_terminology.php';
      $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
      $subhead = "We help businesses improve search rankings and AI visibility through structured data, semantic optimization, and technical SEO.";
      $subhead = localize_terminology($subhead, $locale);
      
      return [
        'h1' => "Professional $serviceTitle for Growth-Focused Businesses",
        'subhead' => $subhead,
        'cta' => "Request $serviceTitle Services",
        'cta_qualifier' => "No obligation. Response within 24 hours."
      ];
    }
  }
  
  // CLASS 2: Geo Service (Primary) - /services/{service}/{city}/
  if ($citySlug && !$subService) {
    // Get current locale for localization (check GLOBALS first, then URL)
    $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
    $localized = get_localized_service_strings($locale);
    
    // Localize service and city titles
    $serviceTitleLocalized = $serviceTitle; // Keep English for now (service names are often kept in English)
    $cityTitleLocalized = $cityTitle;
    
    // Localize CTA patterns based on locale
    $ctaPatterns = [
      'en-us' => "Request a $cityTitle $serviceTitle",
      'en-gb' => "Request a $cityTitle $serviceTitle",
      'fr-fr' => "Demander $serviceTitle à $cityTitle",
      'es-es' => "Solicitar $serviceTitle en $cityTitle",
      'de-de' => "$serviceTitle in $cityTitle anfordern",
      'ko-kr' => "$cityTitle $serviceTitle 요청하기",
    ];
    
    if ($isAudit) {
      // CLASS 4: Audit/Diagnostic (geo)
      // Fix pluralization: "Site Audits" -> "Site Audit" for CTA
      $ctaServiceTitle = $serviceTitle;
      if (substr($serviceTitle, -1) === 's' && strpos($serviceTitle, ' ') !== false) {
        $ctaServiceTitle = rtrim($serviceTitle, 's');
      }
      
      // Localize audit CTAs
      $auditCtaPatterns = [
        'en-us' => "Request a $cityTitle $ctaServiceTitle",
        'en-gb' => "Request a $cityTitle $ctaServiceTitle",
        'en-sg' => "Request a $cityTitle $ctaServiceTitle",
        'en-au' => "Request a $cityTitle $ctaServiceTitle",
        'fr-fr' => "Demander $ctaServiceTitle à $cityTitle",
        'es-es' => "Solicitar $ctaServiceTitle en $cityTitle",
        'de-de' => "$ctaServiceTitle in $cityTitle anfordern",
        'ko-kr' => "$cityTitle $ctaServiceTitle 요청하기",
      ];
      
      return [
        'h1' => $locale === 'fr-fr' ? "$serviceTitle pour les entreprises de $cityTitle" :
               ($locale === 'es-es' ? "$serviceTitle para negocios en $cityTitle" :
               ($locale === 'de-de' ? "$serviceTitle für Unternehmen in $cityTitle" :
               ($locale === 'ko-kr' ? "$cityTitle 비즈니스를 위한 $serviceTitle" :
               "$serviceTitle for $cityTitle Businesses"))),
        'subhead' => $localized['subhead'],
        'cta' => $auditCtaPatterns[$locale] ?? $auditCtaPatterns['en-us'],
        'cta_qualifier' => $locale === 'fr-fr' ? "Vous recevez un diagnostic écrit. Sans engagement." :
                          ($locale === 'es-es' ? "Recibes un diagnóstico escrito. Sin compromiso." :
                          ($locale === 'de-de' ? "Sie erhalten eine schriftliche Diagnose. Keine Verpflichtung." :
                          ($locale === 'ko-kr' ? "서면 진단을 받습니다. 의무 없음." :
                          "You receive a written diagnostic. No obligation.")))
      ];
    } else {
      // CLASS 2: Geo Service - CONVERSION-FIRST STRUCTURE (LOCALIZED)
      return [
        'h1' => $locale === 'fr-fr' ? "$serviceTitle pour les entreprises de $cityTitle" :
               ($locale === 'es-es' ? "$serviceTitle para negocios en $cityTitle" :
               ($locale === 'de-de' ? "$serviceTitle für Unternehmen in $cityTitle" :
               ($locale === 'ko-kr' ? "$cityTitle 비즈니스를 위한 $serviceTitle" :
               "$serviceTitle for $cityTitle Businesses"))),
        'subhead' => $localized['subhead'],
        'cta' => $ctaPatterns[$locale] ?? $ctaPatterns['en-us'],
        'cta_qualifier' => $localized['cta_qualifier']
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
  // Use proper service name mapping to ensure correct capitalization (e.g., "Generative SEO" not "Generative Seo")
  require_once __DIR__ . '/service_enhancements.php';
  $serviceTitle = get_service_name_from_slug($serviceSlug);
  $cityTitle = $citySlug ? (function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-', '_'], ' ', $citySlug))) : null;
  
  // Get current locale for localization (check GLOBALS first, then URL)
  $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
  $localized = get_localized_service_strings($locale);
  $modifier = $localized['meta_modifier'];
  
  // Apply locale-specific terminology (UK spelling for en-gb, en-sg, en-au)
  require_once __DIR__ . '/locale_terminology.php';
  $modifier = localize_terminology($modifier, $locale);
  
  if ($cityTitle) {
    // Localize "in" preposition
    $prepositions = [
      'en-us' => 'in',
      'en-gb' => 'in',
      'en-sg' => 'in',
      'en-au' => 'in',
      'fr-fr' => 'à',
      'es-es' => 'en',
      'de-de' => 'in',
      'ko-kr' => '', // Korean puts city first
    ];
    $prep = $prepositions[$locale] ?? 'in';
    
    if ($locale === 'ko-kr') {
      return "$cityTitle $serviceTitle | $modifier | NRLC.ai";
    }
    
    return "$serviceTitle $prep $cityTitle | $modifier | NRLC.ai";
  }
  
  // Non-geo services
  if (in_array($serviceSlug, ['site-audits', 'technical-seo-audits'])) {
    $auditModifier = $serviceSlug === 'site-audits' ? 'Technical & Structural Website Audits' : 'Crawl & Indexing Diagnostics';
    $auditModifier = localize_terminology($auditModifier, $locale);
    return "$serviceTitle | $auditModifier | NRLC.ai";
  }
  
  $servicesText = "$serviceTitle Services";
  $servicesText = localize_terminology($servicesText, $locale);
  return "$serviceTitle | $servicesText | NRLC.ai";
}

/**
 * Generate meta description following the formula
 * 
 * @param string $serviceSlug
 * @param string|null $citySlug
 * @return string
 */
function service_meta_description(string $serviceSlug, ?string $citySlug = null): string {
  // CONVERSION-FIRST: Service and city-specific meta description
  require_once __DIR__ . '/service_enhancements.php';
  $serviceName = get_service_name_from_slug($serviceSlug);
  
  // Get current locale
  $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
  
  // Apply locale-specific terminology (UK spelling for en-gb, en-sg, en-au)
  require_once __DIR__ . '/locale_terminology.php';
  
  if ($citySlug) {
    $cityTitle = function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-', '_'], ' ', $citySlug));
    $localized = get_localized_service_strings($locale);
    $modifier = $localized['meta_modifier'];
    
    // Apply locale terminology to description
    $modifier = localize_terminology($modifier, $locale);
    $description = "$serviceName services for $cityTitle businesses. Professional implementation, measurable results. $modifier. Call or email to start.";
    return localize_terminology($description, $locale);
  }
  
  // Non-geo services fallback
  $localized = get_localized_service_strings($locale);
  $desc = $localized['meta_desc'];
  return localize_terminology($desc, $locale);
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

