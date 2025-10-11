<?php
require_once __DIR__.'/deterministic.php';
require_once __DIR__.'/helpers.php';

function get_pain_points_for_service(string $serviceSlug): array {
  $rows = csv_to_rows('painpoint_token_map.csv');
  $out = [];
  foreach ($rows as $r) {
    if ($r['service'] === $serviceSlug) {
      $out[] = ['pain_point'=>$r['pain_point'], 'solution'=>$r['solution']];
    }
  }
  return $out;
}

function generate_service_description(array $service, ?array $cityCtx, array $painPoints, string $path): string {
  $seed = det_seed($path.'|desc');
  $intro = "We implement {$service['name']} with rigorous crawl clarity, machine-parsable JSON-LD, and locale-aware routing.";
  $cityLine = $cityCtx ? " In {$cityCtx['city_name']} ({$cityCtx['country']}), we tailor the approach to local markets and languages." : "";
  $picked = det_pick($painPoints, $seed, 3);
  $bullets = array_map(fn($pp)=>"- {$pp['pain_point']}: {$pp['solution']}", $picked);

  $body = [];
  $body[] = $intro.$cityLine;
  $body[] = "Core outcomes:";
  $body[] = "- Deterministic URL hygiene (canonical, trailing slash, param stripping)";
  $body[] = "- Robust schema coverage (Service, LocalBusiness, FAQPage)";
  $body[] = "- Hreflang + x-default for proper regional clustering";
  $body[] = "Key local challenges & solutions:";
  $body = array_merge($body, $bullets);
  $body[] = "This page is generated with a deterministic token system to ensure unique, stable copy for this URL.";
  return implode("\n", $body);
}

function generate_hefty_body(array $service, ?array $city, array $faqs, array $painPoints, string $path): string {
  $seed = det_seed($path.'|body');
  $ppicked = det_pick($painPoints, $seed, 4);
  $faqPicked = det_pick($faqs, $seed, min(4, count($faqs)));

  ob_start(); ?>
<section class="lede">
  <h1><?=htmlspecialchars($service['name'])?><?= $city ? ' in '.htmlspecialchars($city['city_name']) : '' ?></h1>
  <p>LLM-ready implementation of <?=htmlspecialchars($service['name'])?> with strict crawl clarity, structured data depth, and regional SEO primitives.</p>
</section>

<section class="local-context">
  <?php if ($city): ?>
  <h2>Why <?=htmlspecialchars($city['city_name'])?> needs this</h2>
  <p>This market requires canonical stability, hreflang accuracy, and JSON-LD consistency to be parsed reliably by Google and LLMs.</p>
  <?php endif; ?>
</section>

<section class="pain-points">
  <h2>Common challenges & how we solve them</h2>
  <ul>
    <?php foreach ($ppicked as $pp): ?>
      <li><strong><?=htmlspecialchars($pp['pain_point'])?>:</strong> <?=htmlspecialchars($pp['solution'])?></li>
    <?php endforeach; ?>
  </ul>
</section>

<section class="approach">
  <h2>Our approach</h2>
  <p>We combine URL lattice engineering, schema orchestration, and content determinism to produce 800–1200 words of unique, stable copy per city×service.</p>
  <ul>
    <li>Canonical guard and query stripping</li>
    <li>Locale-prefixed routing with hreflang clusters</li>
    <li>Central schema builders for Service, LocalBusiness, FAQPage</li>
    <li>OfferCatalog of pain-point solutions in JSON-LD</li>
  </ul>
</section>

<section class="faqs">
  <h2>FAQs</h2>
  <dl>
  <?php foreach ($faqPicked as $f): ?>
    <dt><?=htmlspecialchars($f['q'])?></dt>
    <dd><?=htmlspecialchars($f['a'])?></dd>
  <?php endforeach; ?>
  </dl>
</section>

<section class="cta">
  <p><a href="/api/book" class="btn">Book a consult</a> or <a href="/api/quote" class="btn">Request a quote</a></p>
</section>
<?php
  return ob_get_clean();
}

