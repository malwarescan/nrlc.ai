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

// Assume $serviceSlug, $citySlug, $currentUrl are provided by router
$serviceSlug = $_GET['service'] ?? 'crawl-clarity';
$citySlug    = $_GET['city']    ?? detect_user_city();
$pathKey = "/services/$serviceSlug/$citySlug/";

det_seed($pathKey);

$serviceTitle = ucfirst(str_replace('-',' ', $serviceSlug));
$cityTitle = titleCaseCity($citySlug);

// Use router's meta title for H1 (ensures H1 matches title for SERP control)
$meta = $GLOBALS['__page_meta'] ?? null;
if ($meta && isset($meta['title'])) {
  // Extract H1 from title (remove " | NRLC.ai" suffix for H1)
  $h1Title = preg_replace('/\s*\|\s*NRLC\.ai\s*$/i', '', $meta['title']);
  $pageTitle = $h1Title;
} else {
  // Fallback if meta not set
  $pageTitle = "Local SEO Services in $cityTitle";
}

// Load city data for schema
$citiesData = csv_read_data('cities.csv');
$cityRow = null;
foreach ($citiesData as $c) {
  if (($c['city_name'] ?? '') === $citySlug) {
    $cityRow = $c;
    break;
  }
}
if (!$cityRow) {
  $cityRow = ['city_name' => $cityTitle, 'country' => 'US', 'subdivision' => ''];
}

// Set page metadata for head.php (must be set before router includes head.php)
// This runs when the file is included, so metadata is available to head.php
$GLOBALS['__page_slug'] = 'services/service_city';

// Try to get enhanced intro from service_enhancements.json
$enhancement = get_service_enhancement($serviceSlug, $citySlug);
$enhancedIntro = $enhancement['intro'] ?? null;

$intro   = $enhancedIntro ?? service_long_intro($serviceSlug, $citySlug);
$local   = local_context_block($citySlug);
$market  = local_market_insights($citySlug);
$competition = local_competition_analysis($citySlug);
$strategy = local_implementation_strategy($citySlug);
$pain    = pain_point_section($serviceSlug, $citySlug, 4);
$appro   = approach_section($serviceSlug);
$why     = why_this_matters_section($serviceSlug, $citySlug);
$timeline= implementation_timeline_section($citySlug);
$metrics = success_metrics_section($serviceSlug, $citySlug);
$faqsHtml= faq_block($serviceSlug, $citySlug, 6);

// Build content with proper structure
$content = $intro . $local;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
        
        <!-- Hero Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h1 class="content-block__title"><?= htmlspecialchars($pageTitle) ?></h1>
          </div>
          <div class="content-block__body">
            <?php
            $queryAlignedContent = get_query_aligned_content($serviceSlug, $citySlug);
            ?>
            <?php if ($enhancedIntro): ?>
            <p class="lead"><?= htmlspecialchars($enhancedIntro) ?><?= $queryAlignedContent ? ' ' . htmlspecialchars($queryAlignedContent) : '' ?></p>
            <?php else: ?>
            <p class="lead"><?= htmlspecialchars($intro) ?><?= $queryAlignedContent ? ' ' . htmlspecialchars($queryAlignedContent) : '' ?></p>
            <?php if (!empty($local)): ?>
            <p><?= htmlspecialchars($local) ?></p>
            <?php endif; ?>
            <?php endif; ?>
            <!-- SERP CONTROL: Above-fold CTA row (Call | Email | Book) -->
            <div class="btn-group text-center" style="margin: 1.5rem 0;">
              <a href="tel:+12135628438" class="btn btn--primary">Call</a>
              <a href="mailto:hirejoelm@gmail.com" class="btn btn--primary">Email</a>
              <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($pageTitle) ?>')">Book a Call</button>
            </div>
            <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Response within 24 hours</p>
            
            <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> and discover related <a href="/insights/geo16-introduction/">AI SEO Research & Insights</a>. Learn more about our <a href="/tools/">SEO Tools & Resources</a> for technical SEO optimization.</p>
          </div>
        </div>

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

        <!-- Localized Strategy Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Localized Strategy</h2>
          </div>
          <div class="content-block__body">
            <?= $strategy ?>
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

        <!-- Why This Matters Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Why This Matters</h2>
          </div>
          <div class="content-block__body">
            <div class="grid grid-auto-fit">
              <?= $why ?>
            </div>
          </div>
        </div>

        <!-- Our Approach Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Our Approach</h2>
          </div>
          <div class="content-block__body">
            <div class="grid grid-auto-fit">
              <?= $appro ?>
            </div>
          </div>
        </div>

        <!-- Implementation Timeline Content Block -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Implementation Timeline</h2>
          </div>
          <div class="content-block__body">
            <?= $timeline ?>
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

        <!-- FAQ Content Block -->
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

  </div>
</section>
</main>

<?php
// STEP 5: Internal Linking Repair
// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Get related services for lateral linking
$relatedServices = get_related_services_for_linking($serviceSlug, $locale);
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
    <p><a href="<?= htmlspecialchars($localePrefix . '/') ?>">Home</a> | <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>">All Services</a></p>
  </div>
</section>

<?php
// LINKING KERNEL: Add required internal links
if (function_exists('render_internal_links_section')) {
  echo render_internal_links_section('services', $serviceSlug, ['city' => $citySlug], 'Related Resources');
}

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

// Use exact canonical URL from Pages.csv if available
$enhancement = get_service_enhancement($serviceSlug, $citySlug);
$canonical_url = $enhancement['canonical'] ?? absolute_url($pathKey);

// STEP 4: Exact Service JSON-LD structure as specified
require_once __DIR__.'/../../lib/service_enhancements.php';
$serviceName = get_service_name_from_slug($serviceSlug);
$serviceType = get_service_type_from_slug($serviceSlug);

$serviceLd = [
  "@context" => "https://schema.org",
  "@type" => "Service",
  "name" => $serviceName,
  "serviceType" => $serviceType,
  "provider" => [
    "@type" => "Organization",
    "name" => "Neural Command LLC",
    "url" => "https://nrlc.ai"
  ],
  "areaServed" => "Global",
  "url" => $canonical_url
];

// Add WebPage and BreadcrumbList schema
$GLOBALS['__jsonld'] = array_merge($GLOBALS['__jsonld'] ?? [], [
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "@id" => $canonical_url . '#webpage',
    "name" => $pageTitle,
    "url" => $canonical_url,
    "description" => "$serviceTitle implementation in $cityTitle with localized expertise and support.",
    "isPartOf" => [
      "@type" => "WebSite",
      "@id" => $domain . '/#website',
      "name" => "NRLC.ai",
      "url" => $domain
    ]
  ],
  [
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
  ],
  $serviceLd
]);

// Add LocalBusiness schema
$localBusinessLd = [
  '@context' => 'https://schema.org',
  '@type' => 'LocalBusiness',
  'name' => 'NRLC.ai',
  'url' => absolute_url('/'),
  'description' => "AI-first SEO services specializing in $serviceTitle for businesses in $cityTitle.",
  'telephone' => '+1-844-568-4624',
  'email' => 'hirejoelm@gmail.com',
  'address' => [
    '@type' => 'PostalAddress',
    'addressLocality' => $cityTitle,
    'addressCountry' => $cityRow['country'] ?? 'US'
  ],
  'areaServed' => [
    '@type' => 'City',
    'name' => $cityTitle,
    'containedInPlace' => [
      '@type' => 'Country',
      'name' => $cityRow['country'] ?? 'US'
    ]
  ],
  'priceRange' => '$$',
  'currenciesAccepted' => 'USD',
  'paymentAccepted' => 'Credit Card, Bank Transfer',
  'openingHours' => 'Mo-Fr 09:00-17:00'
];

// Add FAQPage schema only if FAQs exist
$jsonldSchemas = [$serviceLd, $localBusinessLd];

if (!empty($faqs)) {
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


