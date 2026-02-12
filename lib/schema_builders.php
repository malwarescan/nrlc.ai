<?php
/**
 * Schema Builders - Core Schema Markup Functions
 * 
 * CRITICAL RULE: Person Entity
 * - Never mint new Person entities
 * - All author references must use JOEL_PERSON_ID from lib/person_entity.php
 * - Full Person payload exists ONLY on /en-us/about/joel-maldonado/
 * - See docs/PERSON_ENTITY_IMPLEMENTATION.md for details
 */

require_once __DIR__.'/helpers.php';
require_once __DIR__.'/SchemaFixes.php';
require_once __DIR__.'/gbp_config.php';

use NRLC\Schema\SchemaFixes;

function base_schemas(): array {
  return [
    ld_organization(),
    ld_website_with_searchaction(),
    ld_breadcrumbs(),
  ];
}

function ld_organization(): array {
  // Google Search Gallery compliant Organization schema
  // GBP-ALIGNED: All fields must match Google Business Profile exactly
  // @id is stable and reused everywhere - single canonical Organization entity sitewide
  // logo must be ImageObject for rich results eligibility
  
  // Use stable @id based on website URL (not locale-specific)
  $orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';
  $homeUrl = SchemaFixes::ensureHttps(absolute_url('/en-us/'));
  
  $org = [
    '@context'=>'https://schema.org',
    '@type'=>'Organization',
    '@id'=>$orgId,
    'name'=>gbp_business_name(), // Must match GBP exactly
    'legalName'=>gbp_legal_name(), // Must match GBP exactly
    'url'=>SchemaFixes::ensureHttps(gbp_website()), // Must match GBP website URL exactly
    'telephone'=>gbp_phone(), // Must match GBP primary phone exactly
    'address'=>gbp_address(), // Full PostalAddress matching GBP exactly
    'logo'=>[
      '@type'=>'ImageObject',
      'url'=>SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png')),
      'width'=>43,
      'height'=>43
    ],
    'sameAs'=>gbp_same_as() // Includes GBP URL and other profiles
  ];
  
  // Add founder relationship if set on homepage
  if (isset($GLOBALS['__homepage_org_founder'])) {
    $org['founder'] = $GLOBALS['__homepage_org_founder'];
  }
  
  return $org;
}

function ld_website_with_searchaction(): array {
  // Google Search Gallery compliant WebSite schema with SearchAction
  // Required for site search box rich result eligibility; stable @id for graph reference
  $baseUrl = SchemaFixes::ensureHttps(gbp_website());
  $homeUrl = SchemaFixes::ensureHttps(absolute_url('/en-us/'));
  return [
    '@context'=>'https://schema.org',
    '@type'=>'WebSite',
    '@id'=>$baseUrl . '#website',
    'url'=>$homeUrl,
    'name'=>'NRLC.ai',
    'potentialAction'=>[
      '@type'=>'SearchAction',
      'target'=>SchemaFixes::ensureHttps(absolute_url('/?q={search_term_string}')),
      'query-input'=>'required name=search_term_string'
    ]
  ];
}

function ld_breadcrumbs(): array {
  // Context-aware BreadcrumbList (Google Search Gallery compliant)
  // Homepage: minimal (Home only)
  // Hub pages: Home + Hub (e.g., Home + Insights)
  // Article pages: Home + Hub + Article
  $crumbs = current_breadcrumbs();
  $items = [];
  $i=1;
  foreach ($crumbs as $c) {
    $items[] = [
      '@type'=>'ListItem',
      'position'=>$i++,
      'name'=>$c['name'],
      'item'=>SchemaFixes::ensureHttps($c['url'])
    ];
  }
  // If no breadcrumbs, provide minimal Home breadcrumb
  if (empty($items)) {
    $homeUrl = SchemaFixes::ensureHttps(absolute_url('/en-us/'));
    $items[] = [
      '@type'=>'ListItem',
      'position'=>1,
      'name'=>'Home',
      'item'=>$homeUrl
    ];
  }
  
  // Add @id for insights hub and other hub pages
  $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  $breadcrumbId = null;
  // Remove locale prefix for matching
  $pathWithoutLocale = preg_replace('#^/[a-z]{2}-[a-z]{2}#i', '', $path);
  if ($pathWithoutLocale === '') {
    $pathWithoutLocale = '/';
  }
  // Add @id for hub pages (insights, services, careers)
  if (preg_match('#^/(insights|services|careers)/?$#', $pathWithoutLocale)) {
    $canonicalUrl = SchemaFixes::ensureHttps(absolute_url($path));
    $breadcrumbId = $canonicalUrl . '#breadcrumb';
  }
  
  $breadcrumb = [
    '@context'=>'https://schema.org',
    '@type'=>'BreadcrumbList',
    'itemListElement'=>$items
  ];
  
  if ($breadcrumbId) {
    $breadcrumb['@id'] = $breadcrumbId;
  }
  
  return $breadcrumb;
}

function ld_faq(array $faqs): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'FAQPage',
    'mainEntity'=> array_map(function($f){
      return ['@type'=>'Question','name'=>$f['q'],'acceptedAnswer'=>['@type'=>'Answer','text'=>$f['a']]];
    }, $faqs)
  ];
}

/**
 * VideoObject schema for watch pages (Google video discovery, key moments).
 * $video: slug, title, description, thumbnailUrl, uploadDate, duration (ISO 8601), embedUrl, chapters [{start, title}].
 * Optional: publisher array with @id/name/logo; defaults to site Organization.
 */
function ld_video_object(array $video, string $canonicalUrl): array {
  $domain = SchemaFixes::ensureHttps(gbp_website());
  $orgId = $domain . '#organization';
  $vo = [
    '@context' => 'https://schema.org',
    '@type' => 'VideoObject',
    '@id' => $canonicalUrl . '#video',
    'name' => $video['title'] ?? '',
    'description' => $video['description'] ?? ($video['summary'] ?? ''),
    'thumbnailUrl' => isset($video['thumbnailUrl']) ? SchemaFixes::ensureHttps($video['thumbnailUrl']) : null,
    'uploadDate' => $video['uploadDate'] ?? null,
    'duration' => $video['duration'] ?? null,
    'embedUrl' => isset($video['embedUrl']) ? SchemaFixes::ensureHttps($video['embedUrl']) : null,
    'publisher' => [
      '@type' => 'Organization',
      '@id' => $orgId,
    ],
  ];
  $vo = array_filter($vo);

  // Key moments: SeekToAction and/or hasPart Clip
  if (!empty($video['chapters']) && is_array($video['chapters'])) {
    require_once __DIR__ . '/videos.php';
    $clips = [];
    foreach ($video['chapters'] as $i => $ch) {
      $start = $ch['start'] ?? '0:00';
      $sec = chapter_start_to_seconds($start);
      $clips[] = [
        '@type' => 'Clip',
        'name' => $ch['title'] ?? ('Chapter ' . ($i + 1)),
        'startOffset' => $sec,
      ];
    }
    if (!empty($clips)) {
      $vo['hasPart'] = $clips;
    }
  }

  return $vo;
}

function ld_local_business(?array $cityCtx): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'LocalBusiness',
    'name'=>'NRLC.ai',
    'url'=>SchemaFixes::ensureHttps(absolute_url('/')),
    'image'=>SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlcai logo 0.png')),
    'logo'=>SchemaFixes::ensureHttps(absolute_url('/assets/logo.png')),
    'areaServed'=> $cityCtx ? [
      '@type'=>'AdministrativeArea',
      'name'=>$cityCtx['city_name'].' '.$cityCtx['country']
    ] : null,
    'telephone'=>'+1-844-568-4624'
  ];
}

/**
 * Service JSON-LD with nested OfferCatalog of pain-point solutions.
 * GBP-ALIGNED: provider references the single canonical Organization @id
 * $desc should be the deterministic, city-aware description text.
 */
function ld_service(array $service, ?array $cityCtx, array $painPoints, string $desc): array {
  $offers = array_map(function($pp){
    return [
      '@type'=>'Offer',
      'itemOffered'=>[
        '@type'=>'Service',
        'name'=>$pp['pain_point'],
        'description'=>$pp['solution']
      ]
    ];
  }, $painPoints);

  // Reference the single canonical Organization @id (stable, reused everywhere)
  $orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';

  $serviceSchema = [
    '@context'=>'https://schema.org',
    '@type'=>'Service',
    'serviceType'=>$service['name'],
    'name'=>$service['name'] . ($cityCtx ? " in ".$cityCtx['city_name'] : ''),
    'description'=>$desc,
    'provider'=>[
      '@type'=>'Organization',
      '@id'=>$orgId // Reference to single canonical Organization entity
    ],
    'hasOfferCatalog'=>[
      '@type'=>'OfferCatalog',
      'name'=>'Pain Point Solutions',
      'itemListElement'=>$offers
    ],
    'additionalType'=>'https://schema.org/ProfessionalService'
  ];

  // Add areaServed only if cityCtx is provided and doesn't contradict GBP service area
  if ($cityCtx) {
    $serviceArea = gbp_service_area();
    // Only add areaServed if it doesn't contradict GBP service area (if specified)
    if (empty($serviceArea) || _area_matches_gbp($cityCtx, $serviceArea)) {
      $serviceSchema['areaServed'] = [
        '@type'=>'City',
        'name'=>$cityCtx['city_name'],
        'containedInPlace'=>['@type'=>'Country','name'=>$cityCtx['country']]
      ];
    }
  }

  return $serviceSchema;
}

/**
 * Helper to check if area matches GBP service area
 * (Private helper - used internally by ld_service)
 */
function _area_matches_gbp(array $cityCtx, array $gbpServiceArea): bool {
  if (empty($gbpServiceArea)) return true; // No GBP restriction means all areas allowed
  
  // Check if city/region matches any GBP service area
  foreach ($gbpServiceArea as $area) {
    if (isset($area['city']) && $area['city'] === $cityCtx['city_name']) return true;
    if (isset($area['region']) && $area['region'] === $cityCtx['subdivision']) return true;
    if (isset($area['country']) && $area['country'] === $cityCtx['country']) return true;
  }
  return false;
}

function ld_jobposting(array $job, array $cityCtx): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'JobPosting',
    'title'=>$job['title'],
    'description'=>$job['description_html'],
    'datePosted'=>$job['datePosted'],
    'validThrough'=>$job['validThrough'],
    'employmentType'=>$job['employmentType'],
    'hiringOrganization'=>[
      '@type'=>'Organization',
      'name'=>'NRLC.ai',
      'sameAs'=>SchemaFixes::ensureHttps(absolute_url('/')),
      'logo'=>SchemaFixes::ensureHttps(absolute_url('/assets/logo.png'))
    ],
    'jobLocation'=>[
      '@type'=>'Place',
      'address'=>[
        '@type'=>'PostalAddress',
        'streetAddress'=>$cityCtx['street_address'] ?? 'Remote',
        'addressLocality'=>$cityCtx['city_name'],
        'addressRegion'=>$cityCtx['subdivision'],
        'postalCode'=>$cityCtx['postal_code'] ?? '',
        'addressCountry'=>$cityCtx['country']
      ]
    ],
    'applicantLocationRequirements'=>[
      '@type'=>'Country','name'=>$cityCtx['country']
    ]
  ];
}

function ld_service_hefty(array $ctx): array {
  // $ctx: service, city, url, currency, price (optional), faqs[], offers[]
  $name = ucfirst(str_replace('-',' ', $ctx['service'])) . " — " . ucwords(str_replace('-',' ', $ctx['city']));
  $desc = "Hefty, locally-relevant coverage of {$ctx['service']} in ".ucwords(str_replace('-',' ',$ctx['city']))." including crawl clarity, schema depth, and LLM seeding.";
  $offers = array_map(fn($o)=>[
    "@type"=>"Offer",
    "name"=>$o['headline']??"Remediation",
    "description"=>($o['solution']??'')." Impact: ".($o['impact']??''),
    "category"=>"SEO",
  ], $ctx['offers'] ?? []);
  $faqItems = array_map(fn($f)=>[
    "@type"=>"Question",
    "name"=>$f['q'],
    "acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]
  ], $ctx['faqs'] ?? []);
  return [
    "@context"=>"https://schema.org",
    "@type"=>"Service",
    "name"=>$name,
    "description"=>$desc,
    "areaServed"=>$ctx['city'],
    "provider"=>["@type"=>"Organization","name"=>"NRLC.ai"],
    "offers"=>[
      "@type"=>"OfferCatalog",
      "name"=>"Pain-point Solutions",
      "itemListElement"=>$offers
    ],
    "mainEntityOfPage"=>$ctx['url'],
    // FAQ schema should be emitted as a separate top-level FAQPage entity, not nested.
  ];
}

function ld_faqpage(array $faqs): array {
  return [
    "@context"=>"https://schema.org",
    "@type"=>"FAQPage",
    "mainEntity"=>array_map(fn($f)=>[
      "@type"=>"Question","name"=>$f['q'],
      "acceptedAnswer"=>["@type"=>"Answer","text"=>$f['a']]
    ], $faqs)
  ];
}
