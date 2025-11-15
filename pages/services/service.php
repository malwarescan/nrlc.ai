<?php
require_once __DIR__.'/../../templates/head.php';
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';

$service = $_GET['service'] ?? '';
$GLOBALS['__page_slug'] = 'services/service';

// Service schema for the selection page
$serviceName = ucwords(str_replace('-',' ',$service));
$GLOBALS['__jsonld'] = [
  [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "name" => $serviceName,
    "description" => "Professional $serviceName implementation with localized expertise and support across multiple cities.",
    "provider" => [
      "@type" => "Organization",
      "name" => "NRLC.ai",
      "url" => "https://nrlc.ai"
    ],
    "serviceType" => "AI-First SEO Services",
    "areaServed" => [
      ["@type" => "City", "name" => "New York"],
      ["@type" => "City", "name" => "London"],
      ["@type" => "City", "name" => "San Francisco"],
      ["@type" => "City", "name" => "Toronto"]
    ],
    "offers" => [
      "@type" => "Offer",
      "name" => "Free Consultation",
      "price" => "0",
      "priceCurrency" => "USD",
      "availability" => "https://schema.org/InStock"
    ]
  ]
];
?>

<main role="main">
<section class="container">
    
    <!-- Hero Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text"><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;"><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">Select a city to see localized implementation and pricing for this service.</p>
      </div>
    </div>

    <!-- City Selection Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Available Cities</div>
      </div>
      <div class="window-body">
        <div class="grid-auto-fit">
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">New York</h3>
            <p>Full service implementation in New York with local expertise and support.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/new-york/" class="btn" data-ripple>View in New York</a>
          </div>
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">London</h3>
            <p>Comprehensive service delivery in London with UK market expertise.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/london/" class="btn" data-ripple>View in London</a>
          </div>
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">San Francisco</h3>
            <p>Tech-focused implementation in San Francisco with Silicon Valley insights.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/san-francisco/" class="btn" data-ripple>View in San Francisco</a>
          </div>
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Toronto</h3>
            <p>Canadian market expertise with Toronto-based implementation and support.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/toronto/" class="btn" data-ripple>View in Toronto</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Consultation Window -->
    <div class="window">
      <div class="title-bar">
        <div class="title-bar-text">Need Help Choosing?</div>
      </div>
      <div class="window-body">
        <p>Our team can help you select the right city and service package for your needs. Contact us for personalized recommendations.</p>
        <div class="center margin-top-20">
          <a href="/api/book/" class="btn" data-ripple>Schedule Consultation</a>
        </div>
      </div>
    </div>

</section>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>

