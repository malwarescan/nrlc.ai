<?php
declare(strict_types=1);
// Note: head.php and header.php are already included by router.php render_page()
// Do not duplicate them here to avoid double headers

require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/deterministic.php';
require_once __DIR__.'/../../lib/csv.php';
require_once __DIR__.'/../../lib/service_enhancements.php';
require_once __DIR__.'/../../lib/service_intent_taxonomy.php';
require_once __DIR__.'/../../lib/gbp_config.php';

// Assume $serviceSlug, $citySlug, $currentUrl are provided by router
$serviceSlug = $_GET['service'] ?? 'crawl-clarity';
$citySlug    = $_GET['city']    ?? detect_user_city();
$pathKey = "/services/$serviceSlug/$citySlug/";

det_seed($pathKey);

$serviceTitle = ucfirst(str_replace('-',' ', $serviceSlug));
// Safely get city title
try {
  $cityTitle = function_exists('titleCaseCity') ? titleCaseCity($citySlug) : ucwords(str_replace(['-','_'],' ',$citySlug));
} catch (Throwable $e) {
  error_log("titleCaseCity failed for {$citySlug}: " . $e->getMessage());
  $cityTitle = ucwords(str_replace(['-','_'],' ',$citySlug));
}

// INTENT TAXONOMY: Generate H1, subhead, and CTA based on URL contract (CLASS 2: Geo Service)
// Ensure locale is set from original REQUEST_URI (router may have modified path)
if (!isset($GLOBALS['locale'])) {
  $originalPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  if (preg_match('#^/([a-z]{2})-([a-z]{2})/#i', $originalPath, $m)) {
    $GLOBALS['locale'] = strtolower($m[1].'-'.$m[2]);
  } else {
    $GLOBALS['locale'] = 'en-us';
  }
}
// Safely get intent content
try {
  $intentContent = service_intent_content($serviceSlug, $citySlug);
  $pageTitle = $intentContent['h1'] ?? ucwords(str_replace('-', ' ', $serviceSlug)) . ' in ' . $cityTitle;
  $subhead = $intentContent['subhead'] ?? "Professional {$serviceTitle} services in {$cityTitle}.";
  $ctaText = $intentContent['cta'] ?? "Request {$serviceTitle}";
  $ctaQualifier = $intentContent['cta_qualifier'] ?? "No obligation. Response within 24 hours.";
} catch (Throwable $e) {
  error_log("service_intent_content failed for {$serviceSlug}/{$citySlug}: " . $e->getMessage());
  // Fallback content
  $pageTitle = ucwords(str_replace('-', ' ', $serviceSlug)) . ' in ' . $cityTitle;
  $subhead = "Professional {$serviceTitle} services in {$cityTitle}.";
  $ctaText = "Request {$serviceTitle}";
  $ctaQualifier = "No obligation. Response within 24 hours.";
}

// Load city data for schema
try {
  $citiesData = csv_read_data('cities.csv');
  $cityRow = null;
  foreach ($citiesData as $c) {
    // Match by city_name (slug) or city_slug if available
    if (($c['city_name'] ?? '') === $citySlug || ($c['city_slug'] ?? '') === $citySlug) {
      $cityRow = $c;
      break;
    }
  }
  if (!$cityRow) {
    // Fallback: create minimal city row
    $cityRow = ['city_name' => $cityTitle, 'country' => 'US', 'subdivision' => ''];
  }
} catch (Throwable $e) {
  // If city data lookup fails, use fallback
  error_log("City data lookup failed for {$citySlug}: " . $e->getMessage());
  $cityRow = ['city_name' => $cityTitle, 'country' => 'US', 'subdivision' => ''];
}

// Set page metadata for head.php (must be set before router includes head.php)
// This runs when the file is included, so metadata is available to head.php
$GLOBALS['__page_slug'] = 'services/service_city';

// Try to get enhanced intro from service_enhancements.json
$enhancement = get_service_enhancement($serviceSlug, $citySlug);
$enhancedIntro = $enhancement['intro'] ?? null;

// META KERNEL DIRECTIVE: Required content sections (8-section template)
// Wrap all content generation in try-catch to prevent fatal errors
try {
  $intro   = $enhancedIntro ?? (function_exists('service_long_intro') ? service_long_intro($serviceSlug, $citySlug) : "<p>Professional {$serviceTitle} services in {$cityTitle}.</p>");
  $serviceOverview = function_exists('service_overview_section') ? service_overview_section($serviceSlug, $citySlug, $cityRow) : '';
  $whyChooseUs = function_exists('why_this_matters_section') ? why_this_matters_section($serviceSlug, $citySlug) : '';
  $process = function_exists('approach_section') ? approach_section($serviceSlug, $citySlug) : '';
  $pricing = function_exists('pricing_section') ? pricing_section($serviceSlug, $citySlug, $cityRow) : '';
  $faqsHtml = function_exists('city_specific_faq_block') ? city_specific_faq_block($serviceSlug, $citySlug, 6) : '';
  $serviceAreaCoverage = function_exists('service_area_coverage_section') ? service_area_coverage_section($citySlug, $cityRow) : '';
} catch (Throwable $e) {
  error_log("Content generation failed for {$serviceSlug}/{$citySlug}: " . $e->getMessage());
  // Fallback content
  $intro = "<p>Professional {$serviceTitle} services in {$cityTitle}.</p>";
  $serviceOverview = '';
  $whyChooseUs = '';
  $process = '';
  $pricing = '';
  $faqsHtml = '';
  $serviceAreaCoverage = '';
}

// Additional sections for depth (used after required sections)
try {
  $local   = function_exists('local_context_block') ? local_context_block($citySlug) : '';
  $market  = function_exists('local_market_insights') ? local_market_insights($citySlug) : '';
  $competition = function_exists('local_competition_analysis') ? local_competition_analysis($citySlug) : '';
  $strategy = function_exists('local_implementation_strategy') ? local_implementation_strategy($citySlug) : '';
  $pain    = function_exists('pain_point_section') ? pain_point_section($serviceSlug, $citySlug, 4) : '';
  $timeline= function_exists('implementation_timeline_section') ? implementation_timeline_section($citySlug) : '';
  $metrics = function_exists('success_metrics_section') ? success_metrics_section($serviceSlug, $citySlug) : '';
} catch (Throwable $e) {
  error_log("Additional content generation failed for {$serviceSlug}/{$citySlug}: " . $e->getMessage());
  $local = '';
  $market = '';
  $competition = '';
  $strategy = '';
  $pain = '';
  $timeline = '';
  $metrics = '';
}

// Build content with proper structure
$content = $intro . $local;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
        
        <!-- Hero Content Block (GBP-ALIGNED: Above-the-fold classifier) -->
        <div class="content-block module">
          <div class="content-block__header">
            <h1 class="content-block__title"><?= htmlspecialchars($pageTitle) ?></h1>
          </div>
          <div class="content-block__body">
            <?php
            // GBP-ALIGNED: First sentence must clearly state business provides service
            $gbpName = gbp_business_name();
            echo '<p class="lead">' . htmlspecialchars($gbpName . ' provides ' . $serviceTitle . ' for businesses.') . '</p>';
            ?>
            <p class="lead"><?= htmlspecialchars($subhead) ?></p>
            <?php
            // Add local proof line for UK cities
            if (function_exists('is_uk_city') && is_uk_city($citySlug)) {
              $region = 'Merseyside';
              if (strpos($citySlug, 'norwich') !== false) $region = 'Norfolk';
              elseif (strpos($citySlug, 'stockport') !== false || strpos($citySlug, 'manchester') !== false) $region = 'Greater Manchester';
              echo "<p>We've worked with businesses across $cityTitle and $region and consistently deliver results that automated tools miss.</p>";
            }
            ?>
            <!-- CONVERSION-FIRST CTAs: Primary (service-named) + Secondary (proof) -->
            <?php
            $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
            $localized = get_localized_service_strings($locale);
            $secondaryCta = $localized['cta_secondary'] ?? 'See Proof / Case Studies';
            ?>
            <div class="btn-group text-center" style="margin: 1.5rem 0; gap: 1rem; display: flex; justify-content: center; flex-wrap: wrap;">
              <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($ctaText) ?>')"><?= htmlspecialchars($ctaText) ?></button>
              <a href="/case-studies/" class="btn" style="background: transparent; border: 1px solid #4a90e2; color: #4a90e2;"><?= htmlspecialchars($secondaryCta) ?></a>
            </div>
            <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;"><?= htmlspecialchars($ctaQualifier) ?></p>
          </div>
        </div>

        <!-- META KERNEL DIRECTIVE: SECTION 2 - Service Overview (~150 words) -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Service Overview</h2>
          </div>
          <div class="content-block__body">
            <?= $serviceOverview ?>
          </div>
        </div>

        <!-- META KERNEL DIRECTIVE: SECTION 3 - Why Choose Us in [City] -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Why Choose Us in <?= htmlspecialchars($cityTitle) ?></h2>
          </div>
          <div class="content-block__body">
            <div class="grid grid-auto-fit">
              <?= $whyChooseUs ?>
            </div>
            <?php
            // Add city-specific trust signals
            if (function_exists('is_uk_city') && is_uk_city($citySlug)) {
              $region = 'Merseyside';
              if (strpos($citySlug, 'norwich') !== false) $region = 'Norfolk';
              elseif (strpos($citySlug, 'stockport') !== false || strpos($citySlug, 'manchester') !== false) $region = 'Greater Manchester';
              echo "<div class=\"box-padding\"><p><strong>Local Expertise:</strong> We've worked with businesses across $cityTitle and $region, consistently delivering AI-first SEO results that automated tools miss. Our understanding of {$cityTitle}'s market dynamics and search behavior patterns enables us to optimize for both traditional search and AI engines effectively.</p></div>";
            }
            ?>
          </div>
        </div>

        <!-- META KERNEL DIRECTIVE: SECTION 4 - Process / How It Works -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Process / How It Works</h2>
          </div>
          <div class="content-block__body">
            <div class="grid grid-auto-fit">
              <?= $process ?>
            </div>
            <?= $timeline ?>
          </div>
        </div>

        <!-- META KERNEL DIRECTIVE: SECTION 5 - Pricing -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Pricing for <?= htmlspecialchars($serviceTitle) ?> in <?= htmlspecialchars($cityTitle) ?></h2>
          </div>
          <div class="content-block__body">
            <?= $pricing ?>
          </div>
        </div>

        <!-- META KERNEL DIRECTIVE: SECTION 6 - FAQ (5-7 questions, city-specific) -->
        <?php if (!empty($faqsHtml)): ?>
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Frequently Asked Questions</h2>
          </div>
          <div class="content-block__body">
            <?= $faqsHtml ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- META KERNEL DIRECTIVE: SECTION 7 - Service Area Coverage -->
        <div class="content-block module">
          <div class="content-block__body">
            <?= $serviceAreaCoverage ?>
          </div>
        </div>

        <!-- META KERNEL DIRECTIVE: SECTION 8 - Primary CTA (Conversion-focused) -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Ready to Improve Your AI Engine Visibility in <?= htmlspecialchars($cityTitle) ?>?</h2>
          </div>
          <div class="content-block__body">
            <p class="lead">Get started with <?= htmlspecialchars($serviceTitle) ?> in <?= htmlspecialchars($cityTitle) ?> today. Our AI-first SEO approach delivers measurable improvements in citation accuracy, crawl efficiency, and AI engine visibility.</p>
            <div class="btn-group text-center" style="margin: 1.5rem 0; gap: 1rem; display: flex; justify-content: center; flex-wrap: wrap;">
              <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($ctaText) ?>')"><?= htmlspecialchars($ctaText) ?></button>
            </div>
            <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;"><?= htmlspecialchars($ctaQualifier) ?></p>
          </div>
        </div>

        <!-- Additional Depth Sections (after required 8 sections) -->
        <!-- Local Market Insights Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Local Market Insights</h2>
          </div>
          <div class="content-block__body">
            <?= $market ?>
          </div>
        </div>

        <!-- Competitive Landscape Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Competitive Landscape</h2>
          </div>
          <div class="content-block__body">
            <?= $competition ?>
          </div>
        </div>

        <!-- Pain Points & Solutions Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Pain Points & Solutions</h2>
          </div>
          <div class="content-block__body">
            <div class="grid grid-auto-fit">
              <?= $pain ?>
            </div>
          </div>
        </div>

        <!-- Success Metrics Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Success Metrics</h2>
          </div>
          <div class="content-block__body">
            <?= $metrics ?>
          </div>
        </div>

    <?php
    // STEP 5: Internal Linking Repair
    // Detect locale from URL
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $locale = '';
    if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
      $locale = $matches[1];
    }
    $localePrefix = $locale ? "/$locale" : '';

    // Get related services for lateral linking (include city for city-specific links)
    $relatedServices = get_related_services_for_linking($serviceSlug, $locale, $citySlug);
    ?>

    <!-- STEP 5: Related Services Footer Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Services</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <?php foreach ($relatedServices as $related): ?>
          <li><a href="<?= htmlspecialchars($related['url']) ?>"><?= htmlspecialchars($related['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <p><a href="<?= htmlspecialchars($localePrefix . '/') ?>">Home</a> | <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>">All Services</a></p>
      </div>
    </div>

    <?php
    // LINKING KERNEL: Add required internal links
    if (function_exists('render_internal_links_section')) {
      echo render_internal_links_section('services', $serviceSlug, ['city' => $citySlug], 'Related Resources');
    }
    ?>

  </div>
</section>
</main>

<?php
// JSON-LD (Service + FAQPage embedded)
$ppMap = csv_rows_local('painpoint_token_map.csv');
$ppForService = array_values(array_filter($ppMap, fn($r)=>$r['service']===$serviceSlug));
$fqRows = csv_rows_local('faq_pools.csv');
$fqForService = array_values(array_filter($fqRows, fn($r)=>$r['service']===$serviceSlug));
det_seed("ld|$pathKey");
$fqPick = det_pick($fqForService, 6);
$faqs = array_map(fn($f)=>['q'=>$f['question'],'a'=>$f['answer']], $fqPick);
$offers = det_pick($ppForService, 6);

$domain = 'https://nrlc.ai';

// CANONICAL ENFORCEMENT: Use locale-prefixed URL as canonical for crawled page
// This prevents GSC indexing issues where crawled URL != canonical URL
$currentLocale = $GLOBALS['locale'] ?? 'en-us';
$localePrefix = ($currentLocale === 'en-us') ? '' : '/' . $currentLocale;
$canonical_url = absolute_url($localePrefix . $pathKey);

// Verify enhancement canonical matches our locale-prefixed canonical
$enhancement = get_service_enhancement($serviceSlug, $citySlug);
$enhancementCanonical = $enhancement['canonical'] ?? null;
if ($enhancementCanonical && $enhancementCanonical !== $canonical_url) {
  // Log mismatch but use our locale-prefixed canonical for indexing
  error_log("Canonical mismatch for {$pathKey}: enhancement={$enhancementCanonical}, using={$canonical_url}");
}

// STEP 4: Exact Service JSON-LD structure as specified
require_once __DIR__.'/../../lib/service_enhancements.php';
$serviceName = get_service_name_from_slug($serviceSlug);
$serviceType = get_service_type_from_slug($serviceSlug);

// GBP-ALIGNED: Service schema references single canonical Organization @id
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization'; // Stable @id reused everywhere

// CANONICAL ENFORCEMENT: Ensure proper canonical URL for locale-specific content
// Local pages (city-specific) should NOT have hreflang - they are location-specific

// ADVANCED: Enhanced Service schema for technical-seo
$serviceLd = [
  "@context" => "https://schema.org",
  "@type" => "Service",
  "name" => $serviceName,
  "serviceType" => $serviceType,
  "provider" => [
    "@type" => "Organization",
    "@id" => $orgId // Reference to single canonical Organization entity
  ],
  "areaServed" => array_filter([
    "@type" => "City",
    "name" => $cityTitle,
    "containedIn" => !empty($cityRow['subdivision']) ? [
      "@type" => "State",
      "name" => $cityRow['subdivision']
    ] : null
  ], function($v) { return $v !== null; }),
  "url" => $canonical_url,
  "description" => "$serviceName in $cityTitle. Professional implementation with localized expertise, measurable results, and ongoing support."
];

// ADVANCED: Special enhancements for technical-seo
if ($serviceSlug === 'technical-seo') {
  $serviceLd['serviceType'] = 'Technical SEO & Core Web Vitals Optimization';
  $serviceLd['category'] = 'Technical SEO';
  $serviceLd['hasOfferCatalog'] = [
    '@type' => 'OfferCatalog',
    'name' => 'Technical SEO Services',
    'itemListElement' => [
      [
        '@type' => 'Offer',
        'itemOffered' => [
          '@type' => 'Service',
          'name' => 'Core Web Vitals Optimization',
          'description' => 'Improve LCP, FID, and CLS scores for better search rankings'
        ]
      ],
      [
        '@type' => 'Offer',
        'itemOffered' => [
          '@type' => 'Service',
          'name' => 'Crawl Efficiency Optimization',
          'description' => 'Optimize sitemap structure and crawl budget utilization'
        ]
      ],
      [
        '@type' => 'Offer',
        'itemOffered' => [
          '@type' => 'Service',
          'name' => 'Mobile Performance Engineering',
          'description' => 'Responsive design and mobile-optimized loading'
        ]
      ],
      [
        '@type' => 'Offer',
        'itemOffered' => [
          '@type' => 'Service',
          'name' => 'Sitemap Architecture',
          'description' => 'Efficient sitemap structures with proper sharding and indexing'
        ]
      ]
    ]
  ];
  $serviceLd['audience'] = [
    '@type' => 'Audience',
    'audienceType' => 'Businesses needing technical SEO improvements',
    'geographicArea' => [
      '@type' => 'City',
      'name' => $cityTitle
    ]
  ];
}

// Build complete schema array (avoid duplicates)
// Start with existing schemas if any (from router or other includes)
$jsonldSchemas = $GLOBALS['__jsonld'] ?? [];

// ADVANCED: Enhanced WebPage schema
$webPageDesc = "$serviceTitle in $cityTitle. Professional implementation with measurable results. Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).";
if ($serviceSlug === 'technical-seo') {
  $webPageDesc = "Technical SEO services in $cityTitle. Fix crawl issues, improve Core Web Vitals, optimize sitemaps, and enhance mobile performance. Professional technical SEO implementation with measurable results for businesses in $cityTitle.";
}

$jsonldSchemas[] = [
  "@context" => "https://schema.org",
  "@type" => "WebPage",
  "@id" => $canonical_url . '#webpage',
  "name" => $pageTitle,
  "url" => $canonical_url,
  "description" => $webPageDesc,
  "isPartOf" => [
    "@type" => "WebSite",
    "@id" => $domain . '/#website',
    "name" => "NRLC.ai",
    "url" => $domain,
    "potentialAction" => [
      "@type" => "SearchAction",
      "target" => [
        "@type" => "EntryPoint",
        "urlTemplate" => "https://nrlc.ai/search?q={search_term_string}"
      ],
      "query-input" => "required name=search_term_string"
    ]
  ],
  "about" => [
    "@id" => $canonical_url . '#service'
  ],
  "primaryImageOfPage" => [
    "@type" => "ImageObject",
    "url" => "https://nrlc.ai/assets/images/nrlc-logo.png",
    "width" => 43,
    "height" => 43,
    "caption" => "NRLC.ai - AI Search Optimization"
  ],
  "inLanguage" => $currentLocale === 'en-gb' ? 'en-GB' : 'en-US',
  "datePublished" => "2024-01-01",
  "dateModified" => date('Y-m-d'),
  "author" => [
    "@type" => "Person",
    "name" => "Joel Maldonado",
    "jobTitle" => "Founder & AI Search Researcher",
    "worksFor" => [
      "@id" => $orgId
    ]
  ],
  "publisher" => [
    "@id" => $orgId
  ],
  "breadcrumb" => [
    "@id" => $canonical_url . '#breadcrumb'
  ],
  "mainEntity" => [
    "@id" => $canonical_url . '#service'
  ],
  "speakable" => [
    "@type" => "SpeakableSpecification",
    "cssSelector" => ["h1", ".lead"]
  ]
];

// Add BreadcrumbList schema
$jsonldSchemas[] = [
  "@context" => "https://schema.org",
  "@type" => "BreadcrumbList",
  "@id" => $canonical_url . '#breadcrumb',
  "itemListElement" => [
    [
      "@type" => "ListItem",
      "position" => 1,
      "name" => "Home",
      "item" => $domain . "/"
    ],
    [
      "@type" => "ListItem",
      "position" => 2,
      "name" => "Services",
      "item" => $domain . "/services/"
    ],
    [
      "@type" => "ListItem",
      "position" => 3,
      "name" => $serviceTitle,
      "item" => $domain . "/services/$serviceSlug/"
    ],
    [
      "@type" => "ListItem",
      "position" => 4,
      "name" => $cityTitle,
      "item" => $canonical_url
    ]
  ]
];

// Add Service schema with @id for reference
$serviceLd['@id'] = $canonical_url . '#service';
$jsonldSchemas[] = $serviceLd;

// ADVANCED: Add Organization schema reference with enhanced details
$jsonldSchemas[] = [
  "@context" => "https://schema.org",
  "@type" => "Organization",
  "@id" => $orgId,
  "name" => "Neural Command",
  "legalName" => "Neural Command, LLC",
  "url" => "https://nrlc.ai",
  "logo" => [
    "@type" => "ImageObject",
    "url" => "https://nrlc.ai/assets/images/nrlc-logo.png",
    "width" => 43,
    "height" => 43
  ],
  "knowsAbout" => $serviceSlug === 'technical-seo' ? [
    "Technical SEO",
    "Core Web Vitals Optimization",
    "Crawl Efficiency",
    "Sitemap Architecture",
    "Mobile Performance",
    "Site Speed Optimization",
    "AI Search Optimization",
    "Structured Data",
    "Schema Markup",
    "Entity Optimization"
  ] : [
    "AI Search Optimization",
    "AEO",
    "GEO",
    "SEO",
    "Structured Data",
    "LLM Seeding",
    "AI Visibility"
  ],
  "areaServed" => [
    "@type" => "City",
    "name" => $cityTitle
  ],
  "offers" => [
    "@id" => $canonical_url . '#service'
  ]
];

// GBP-ALIGNED: LocalBusiness schema removed per directive
// Service pages use Organization schema only (via base_schemas() or explicit Organization schema)
// LocalBusiness should only be used if GBP category explicitly implies a storefront model

// Add FAQPage schema ONLY ONCE if FAQs exist
// Check if FAQPage already exists in schemas to avoid duplicates
$hasFAQPage = false;
foreach ($jsonldSchemas as $schema) {
  if (isset($schema['@type']) && $schema['@type'] === 'FAQPage') {
    $hasFAQPage = true;
    break;
  }
}

if (!empty($faqs) && !$hasFAQPage) {
  $faqLd = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(function($faq) {
      return [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $faq['a']
        ]
      ];
    }, $faqs)
  ];
  $jsonldSchemas[] = $faqLd;
}

$GLOBALS['__jsonld'] = $jsonldSchemas;
?>


