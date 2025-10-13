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

<main role="main">
<section class="container">
        
        <!-- Hero Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text"><?= htmlspecialchars($pageTitle) ?></div>
          </div>
          <div class="window-body">
            <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;"><?= $content ?></p>
            <div class="center margin-top-20" style="display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
              <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Schedule Consultation</a>
              <a href="/services/" class="btn" data-ripple style="width: 100%; max-width: 300px;">View All Services</a>
            </div>
          </div>
        </div>

        <!-- Local Market Insights Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Local Market Insights</div>
          </div>
          <div class="window-body">
            <?= $market ?>
          </div>
        </div>

        <!-- Competitive Landscape Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Competitive Landscape</div>
          </div>
          <div class="window-body">
            <?= $competition ?>
          </div>
        </div>

        <!-- Localized Strategy Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Localized Strategy</div>
          </div>
          <div class="window-body">
            <?= $strategy ?>
          </div>
        </div>

        <!-- Pain Points & Solutions Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Pain Points & Solutions</div>
          </div>
          <div class="window-body">
            <div class="grid-auto-fit">
              <?= $pain ?>
            </div>
          </div>
        </div>

        <!-- Why This Matters Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Why This Matters</div>
          </div>
          <div class="window-body">
            <div class="grid-auto-fit">
              <?= $why ?>
            </div>
          </div>
        </div>

        <!-- Our Approach Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Our Approach</div>
          </div>
          <div class="window-body">
            <div class="grid-auto-fit">
              <?= $appro ?>
            </div>
          </div>
        </div>

        <!-- Implementation Timeline Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Implementation Timeline</div>
          </div>
          <div class="window-body">
            <?= $timeline ?>
          </div>
        </div>

        <!-- Success Metrics Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Success Metrics</div>
          </div>
          <div class="window-body">
            <?= $metrics ?>
          </div>
        </div>

        <!-- FAQ Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Frequently Asked Questions</div>
          </div>
          <div class="window-body">
            <h2 style="color: #000080; margin-top: 0;">FAQs</h2>
            <?= $faqsHtml ?>
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

// Add FAQPage schema
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

$GLOBALS['__jsonld'] = [$serviceLd, $localBusinessLd, $faqLd];
?>


