<?php
declare(strict_types=1);
require_once __DIR__.'/../../templates/head.php';
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/deterministic.php';

// Assume $serviceSlug, $citySlug, $currentUrl are provided by router
$serviceSlug = $_GET['service'] ?? 'crawl-clarity';
$citySlug    = $_GET['city']    ?? detect_user_city();
$pathKey = "/services/$serviceSlug/$citySlug/";

det_seed($pathKey);

$serviceTitle = ucfirst(str_replace('-',' ', $serviceSlug));
$cityTitle = titleCaseCity($citySlug);
$pageTitle = "$serviceTitle in $cityTitle";

$intro   = service_long_intro($serviceSlug, $citySlug);
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
            <p class="lead"><?= $content ?></p>
            <div class="btn-group text-center">
              <a href="/api/book/" class="btn btn--primary">Schedule Consultation</a>
              <a href="/services/" class="btn">View All Services</a>
            </div>
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
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Frequently Asked Questions</h2>
          </div>
          <div class="content-block__body">
            <?= $faqsHtml ?>
          </div>
        </div>

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

$serviceLd = ld_service_hefty([
  'service'=>$serviceSlug,
  'city'=>$citySlug,
  'url'=>absolute_url($pathKey),
  'faqs'=>$faqs,
  'offers'=>$offers
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


