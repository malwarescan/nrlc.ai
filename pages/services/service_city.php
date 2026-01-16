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

// Enhance metadata with keywords (CRITICAL FOR SEO)
if (isset($GLOBALS['__page_meta']) && is_array($GLOBALS['__page_meta'])) {
  $serviceKeywords = [
    'link-building-ai' => "Link building AI {$cityTitle}, AI link building {$cityTitle}, AI link optimization, ChatGPT link building, Perplexity link building, Google AI Overviews link building, AI link signals, link authority optimization, AI citation services {$cityTitle}",
    'mobile-seo-ai' => "Mobile SEO AI {$cityTitle}, mobile AI search optimization, mobile-first indexing, mobile Core Web Vitals, mobile ChatGPT optimization, mobile Perplexity optimization {$cityTitle}",
    'generative-seo' => "Generative SEO {$cityTitle}, generative search optimization, ChatGPT optimization, Claude optimization, Perplexity optimization, Google AI Overviews optimization, AI citation optimization {$cityTitle}",
    'retrieval-optimization-ai' => "Retrieval Optimization AI {$cityTitle}, AI retrieval optimization, semantic retrieval, query-document matching, AI search visibility, retrieval ranking optimization {$cityTitle}",
  ];
  $defaultKeywords = "AI SEO {$cityTitle}, AI search optimization {$cityTitle}, ChatGPT optimization {$cityTitle}, Perplexity optimization {$cityTitle}, Google AI Overviews optimization {$cityTitle}, AI visibility services {$cityTitle}, structured data services {$cityTitle}";
  $GLOBALS['__page_meta']['keywords'] = $serviceKeywords[$serviceSlug] ?? $defaultKeywords;
}

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

<main role="main" class="container" itemscope itemtype="https://schema.org/Service">
<article itemscope itemtype="https://schema.org/Article" class="section">
  <div class="section__content">
        
        <!-- Hero Content Block (GBP-ALIGNED: Above-the-fold classifier) -->
        <header class="content-block module">
          <div class="content-block__header">
            <h1 class="content-block__title" itemprop="headline"><?= htmlspecialchars($pageTitle) ?></h1>
          </div>
          <div class="content-block__body">
            <?php
            // GBP-ALIGNED: First sentence must clearly state business provides service
            $gbpName = gbp_business_name();
            $serviceTitleEscaped = htmlspecialchars($serviceTitle);
            echo '<p class="lead" itemprop="description">' . htmlspecialchars($gbpName) . ' provides <strong>' . $serviceTitleEscaped . '</strong> for businesses.</p>';
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
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Service Overview</h2>
          </div>
          <div class="content-block__body">
            <?= $serviceOverview ?>
          </div>
        </section>

        <!-- META KERNEL DIRECTIVE: SECTION 3 - Why Choose Us in [City] -->
        <section class="content-block module">
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
        </section>

        <!-- META KERNEL DIRECTIVE: SECTION 4 - Process / How It Works -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Process / How It Works</h2>
          </div>
          <div class="content-block__body">
            <?php
            // approach_section() returns approach blocks + step-by-step section separated by delimiter
            // Split the output to handle grid vs full-width sections properly
            $processOutput = $process;
            
            // Split on the delimiter
            if (strpos($processOutput, '<!--STEP_BY_STEP_DELIMITER-->') !== false) {
              list($approachBlocks, $stepByStepSection) = explode('<!--STEP_BY_STEP_DELIMITER-->', $processOutput, 2);
              
              // Display approach blocks in grid
              if (!empty(trim($approachBlocks))) {
                echo '<div class="grid grid-auto-fit">' . trim($approachBlocks) . '</div>';
              }
              
              // Display step-by-step section full-width (not in grid)
              if (!empty(trim($stepByStepSection))) {
                echo trim($stepByStepSection);
              }
            } else {
              // Fallback: if no delimiter, display all in grid (backward compatibility)
              echo '<div class="grid grid-auto-fit">' . $processOutput . '</div>';
            }
            ?>
            
            <?php if (!empty($timeline)): ?>
            <div class="box-padding">
              <?= $timeline ?>
            </div>
            <?php endif; ?>
          </div>
        </section>

        <!-- META KERNEL DIRECTIVE: SECTION 5 - Pricing -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Pricing for <?= htmlspecialchars($serviceTitle) ?> in <?= htmlspecialchars($cityTitle) ?></h2>
          </div>
          <div class="content-block__body">
            <?= $pricing ?>
          </div>
        </section>

        <!-- META KERNEL DIRECTIVE: SECTION 6 - FAQ (5-7 questions, city-specific) -->
        <?php if (!empty($faqsHtml)): ?>
        <section class="content-block module" itemscope itemtype="https://schema.org/FAQPage">
          <div class="content-block__header">
            <h2 class="content-block__title">Frequently Asked Questions</h2>
          </div>
          <div class="content-block__body">
            <?= $faqsHtml ?>
          </div>
        </section>
        <?php endif; ?>

        <!-- META KERNEL DIRECTIVE: SECTION 7 - Service Area Coverage -->
        <section class="content-block module">
          <div class="content-block__body">
            <?= $serviceAreaCoverage ?>
          </div>
        </section>

        <!-- META KERNEL DIRECTIVE: SECTION 8 - Primary CTA (Conversion-focused) -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Ready to Improve Your <strong>AI Engine Visibility</strong> in <?= htmlspecialchars($cityTitle) ?>?</h2>
          </div>
          <div class="content-block__body">
            <p class="lead">Get started with <strong><?= htmlspecialchars($serviceTitle) ?></strong> in <strong><?= htmlspecialchars($cityTitle) ?></strong> today. Our <strong>AI-first SEO</strong> approach delivers measurable improvements in <strong>citation accuracy</strong>, <strong>crawl efficiency</strong>, and <strong>AI engine visibility</strong>.</p>
            <div class="btn-group text-center" style="margin: 1.5rem 0; gap: 1rem; display: flex; justify-content: center; flex-wrap: wrap;">
              <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($ctaText) ?>')"><?= htmlspecialchars($ctaText) ?></button>
              <a href="<?= absolute_url('/en-us/insights/') ?>" class="btn btn--secondary">Research & Insights</a>
            </div>
            <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;"><?= htmlspecialchars($ctaQualifier) ?></p>
          </div>
        </section>

        <!-- Additional Depth Sections (after required 8 sections) -->
        <!-- Local Market Insights Content Block -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Local Market Insights</h2>
          </div>
          <div class="content-block__body">
            <?= $market ?>
          </div>
        </section>

        <!-- Competitive Landscape Content Block -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Competitive Landscape</h2>
          </div>
          <div class="content-block__body">
            <?= $competition ?>
          </div>
        </section>

        <!-- Pain Points & Solutions Content Block -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Pain Points & Solutions</h2>
          </div>
          <div class="content-block__body">
            <div class="grid grid-auto-fit">
              <?= $pain ?>
            </div>
          </div>
        </section>

        <!-- Success Metrics Content Block -->
        <section class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Success Metrics</h2>
          </div>
          <div class="content-block__body">
            <?= $metrics ?>
          </div>
        </section>

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
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Services</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <?php foreach ($relatedServices as $related): ?>
          <li><a href="<?= htmlspecialchars($related['url']) ?>"><?= htmlspecialchars($related['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <p><a href="<?= htmlspecialchars($localePrefix . '/') ?>">Home</a> | <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>">All Services</a> | <a href="<?= absolute_url('/en-us/ai-optimization/') ?>">AI Optimization</a> | <a href="<?= absolute_url('/en-us/insights/') ?>">Research & Insights</a></p>
      </div>
    </section>

    <?php
    // LINKING KERNEL: Add required internal links
    if (function_exists('render_internal_links_section')) {
      echo render_internal_links_section('services', $serviceSlug, ['city' => $citySlug], 'Related Resources');
    }
    ?>

  </div>
</article>
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
$personId = SchemaFixes::ensureHttps(gbp_website()) . '#joel-maldonado';
$domain = SchemaFixes::ensureHttps(gbp_website());

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

// Person schema (Joel Maldonado) - CRITICAL FOR AUTHORITY
$serviceSpecificKnowsAbout = [
  'link-building-ai' => ['Link Building AI', 'AI Link Optimization', 'AI Citation Services', 'Link Authority Optimization', 'AI Link Signals', 'ChatGPT Link Building', 'Perplexity Link Building', 'Google AI Overviews Link Building'],
  'mobile-seo-ai' => ['Mobile SEO AI', 'Mobile-First Indexing', 'Mobile Core Web Vitals', 'Mobile AI Search Optimization', 'Mobile ChatGPT Optimization', 'Mobile Perplexity Optimization'],
  'generative-seo' => ['Generative SEO', 'Generative Search Optimization', 'ChatGPT Optimization', 'Claude Optimization', 'Perplexity Optimization', 'Google AI Overviews Optimization', 'AI Citation Optimization'],
  'retrieval-optimization-ai' => ['Retrieval Optimization AI', 'AI Retrieval Optimization', 'Semantic Retrieval', 'Query-Document Matching', 'AI Search Visibility', 'Retrieval Ranking Optimization'],
];
$defaultKnowsAbout = ['AI Search Optimization', 'AEO', 'GEO', 'SEO', 'Structured Data', 'LLM Seeding', 'AI Visibility'];
$personKnowsAbout = $serviceSpecificKnowsAbout[$serviceSlug] ?? $defaultKnowsAbout;

$jsonldSchemas[] = [
  '@context' => 'https://schema.org',
  '@type' => 'Person',
  '@id' => $personId,
  'name' => 'Joel Maldonado',
  'givenName' => 'Joel',
  'familyName' => 'Maldonado',
  'jobTitle' => 'Founder & AI Search Researcher',
  'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
  'knowsAbout' => $personKnowsAbout,
  'worksFor' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'affiliation' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'url' => $domain,
  'sameAs' => [
    'https://www.linkedin.com/company/neural-command/',
    'https://twitter.com/neuralcommand',
    'https://www.crunchbase.com/person/joel-maldonado'
  ]
];

// ADVANCED: Enhanced WebPage schema
$webPageDesc = "$serviceTitle in $cityTitle. Professional implementation with measurable results. Get a plan that fixes rankings and conversions fast: technical issues, content gaps, and AI retrieval (ChatGPT, Claude, Google AI Overviews).";
if ($serviceSlug === 'technical-seo') {
  $webPageDesc = "Technical SEO services in $cityTitle. Fix crawl issues, improve Core Web Vitals, optimize sitemaps, and enhance mobile performance. Professional technical SEO implementation with measurable results for businesses in $cityTitle.";
}

// Service-specific about and mentions arrays
$serviceAbout = [
  'link-building-ai' => [
    ['@type' => 'Thing', 'name' => 'Link Building AI', 'description' => 'AI-first link building service that optimizes link profiles for AI search systems'],
    ['@type' => 'Thing', 'name' => 'AI Link Optimization', 'description' => 'Optimization of link profiles for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'],
    ['@type' => 'Thing', 'name' => 'AI Link Signals', 'description' => 'Signals that AI systems use to evaluate and value link profiles'],
  ],
  'mobile-seo-ai' => [
    ['@type' => 'Thing', 'name' => 'Mobile SEO AI', 'description' => 'Mobile-first AI search optimization for mobile AI systems'],
    ['@type' => 'Thing', 'name' => 'Mobile-First Indexing', 'description' => 'Search engine indexing that prioritizes mobile-optimized content'],
  ],
  'generative-seo' => [
    ['@type' => 'Thing', 'name' => 'Generative SEO', 'description' => 'Optimization for generative AI systems that create summaries and citations'],
    ['@type' => 'Thing', 'name' => 'AI Citation Optimization', 'description' => 'Optimization of content for accurate AI system citations'],
  ],
  'retrieval-optimization-ai' => [
    ['@type' => 'Thing', 'name' => 'Retrieval Optimization AI', 'description' => 'Optimization of content structure for AI system retrieval and extraction'],
    ['@type' => 'Thing', 'name' => 'Semantic Retrieval', 'description' => 'AI system retrieval based on semantic relationships and entity understanding'],
  ],
];
$defaultAbout = [
  ['@type' => 'Thing', 'name' => 'AI Search Optimization', 'description' => 'Optimization of content for AI search systems'],
  ['@type' => 'Thing', 'name' => 'AI Visibility', 'description' => 'Visibility of businesses in AI-generated search results'],
];

$jsonldSchemas[] = [
  "@context" => "https://schema.org",
  "@type" => "WebPage",
  "@id" => $canonical_url . '#webpage',
  "name" => $pageTitle,
  "url" => $canonical_url,
  "description" => $webPageDesc,
  "inLanguage" => $currentLocale === 'en-gb' ? 'en-GB' : 'en-US',
  "datePublished" => "2024-01-01",
  "dateModified" => date('Y-m-d'),
  "keywords" => $GLOBALS['__page_meta']['keywords'] ?? "AI SEO {$cityTitle}, AI search optimization {$cityTitle}",
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
  "about" => array_merge(
    [["@id" => $canonical_url . '#service']],
    $serviceAbout[$serviceSlug] ?? $defaultAbout
  ),
  "mentions" => [
    [
      "@type" => "SoftwareApplication",
      "name" => "ChatGPT",
      "description" => "AI language model by OpenAI"
    ],
    [
      "@type" => "SoftwareApplication",
      "name" => "Perplexity",
      "description" => "AI-powered search engine"
    ],
    [
      "@type" => "SoftwareApplication",
      "name" => "Google AI Overviews",
      "description" => "Google's AI-powered search overview feature"
    ],
    [
      "@type" => "SoftwareApplication",
      "name" => "Claude",
      "description" => "AI language model by Anthropic"
    ]
  ],
  "primaryImageOfPage" => [
    "@type" => "ImageObject",
    "url" => "https://nrlc.ai/assets/images/nrlc-logo.png",
    "width" => 43,
    "height" => 43,
    "caption" => "NRLC.ai - AI Search Optimization"
  ],
  "author" => [
    "@type" => "Person",
    "@id" => $personId
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

// Thing schemas for key service concepts (CRITICAL FOR ENTITY CLARITY)
$serviceThingSchemas = [
  'link-building-ai' => [
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'Link Building AI',
      'description' => 'AI-first link building service that optimizes link profiles for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'
    ],
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'AI Link Optimization',
      'description' => 'Optimization of link profiles for AI search systems to improve link authority and citation likelihood'
    ],
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'AI Link Signals',
      'description' => 'Signals that AI systems use to evaluate and value link profiles, including link quality indicators and authority markers'
    ],
  ],
  'mobile-seo-ai' => [
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'Mobile SEO AI',
      'description' => 'Mobile-first AI search optimization for mobile AI systems including mobile ChatGPT and mobile Perplexity'
    ],
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'Mobile-First Indexing',
      'description' => 'Search engine indexing that prioritizes mobile-optimized content for mobile AI systems'
    ],
  ],
  'generative-seo' => [
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'Generative SEO',
      'description' => 'Optimization for generative AI systems that create summaries and citations, including ChatGPT, Claude, and Perplexity'
    ],
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'AI Citation Optimization',
      'description' => 'Optimization of content for accurate AI system citations and mentions'
    ],
  ],
  'retrieval-optimization-ai' => [
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'Retrieval Optimization AI',
      'description' => 'Optimization of content structure for AI system retrieval and extraction'
    ],
    [
      '@context' => 'https://schema.org',
      '@type' => 'Thing',
      'name' => 'Semantic Retrieval',
      'description' => 'AI system retrieval based on semantic relationships and entity understanding'
    ],
  ],
];

$defaultThingSchemas = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Search Optimization',
    'description' => 'Optimization of content for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Visibility',
    'description' => 'Visibility of businesses in AI-generated search results and AI system citations'
  ],
];

// Add Thing schemas for this service
$thingSchemas = $serviceThingSchemas[$serviceSlug] ?? $defaultThingSchemas;
foreach ($thingSchemas as $thingSchema) {
  $jsonldSchemas[] = $thingSchema;
}

$GLOBALS['__jsonld'] = $jsonldSchemas;
?>


