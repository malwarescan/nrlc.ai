<?php
require_once __DIR__.'/../../templates/head.php';
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../lib/helpers.php';

$service = $_GET['service'] ?? '';
$GLOBALS['__page_slug'] = 'services/service';
?>

<main role="main">
  <section class="window container">
    <div class="title-bar">
      <div class="title-bar-text"><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></div>
    </div>
    <div class="window-body">
      <h1><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></h1>
      <p class="lead">Select a city to see localized implementation and pricing for this service.</p>
      
      <div class="grid-auto-fit margin-top-20">
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
      
      <div class="box-padding margin-top-20" style="background: #f8f8f8;">
        <h3 style="margin-top: 0; color: #000080;">Need Help Choosing?</h3>
        <p>Our team can help you select the right city and service package for your needs. Contact us for personalized recommendations.</p>
        <div class="center">
          <a href="/api/book/" class="btn" data-ripple>Schedule Consultation</a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require_once __DIR__.'/../../templates/footer.php'; ?>

