<?php
declare(strict_types=1);
require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/deterministic.php';

// Assume $serviceSlug, $citySlug, $currentUrl are provided by router
$serviceSlug = $_GET['service'] ?? 'crawl-clarity';
$citySlug    = $_GET['city']    ?? 'new-york';
$pathKey = "/services/$serviceSlug/$citySlug/";

det_seed($pathKey);

$intro   = "<p class=\"lead\">".service_long_intro($serviceSlug, $citySlug)."</p>";
$local   = "<p>".local_context_block($citySlug)."</p>";
$pain    = pain_point_section($serviceSlug, $citySlug, 4);
$appro   = approach_section($serviceSlug);
$faqsHtml= faq_block($serviceSlug, $citySlug, 6);

$body = "<section class=\"window container\"><div class=\"title-bar\"><div class=\"title-bar-text\">"
      .ucfirst(str_replace('-',' ', $serviceSlug))." in ".titleCaseCity($citySlug)
      ."</div></div><div class=\"window-body\"><h1 class=\"h1\">"
      .ucfirst(str_replace('-',' ', $serviceSlug))." in ".titleCaseCity($citySlug)
      ."</h1>$intro$local</div></section>"
      ."<section class=\"window container\"><div class=\"title-bar\"><div class=\"title-bar-text\">Pain Points & Solutions</div></div><div class=\"window-body\"><div class=\"grid\">$pain</div></div></section>"
      ."<section class=\"window container\"><div class=\"title-bar\"><div class=\"title-bar-text\">Our Approach</div></div><div class=\"window-body\">$appro</div></section>"
      ."<section class=\"window container\"><div class=\"title-bar\"><div class=\"title-bar-text\">Frequently Asked Questions</div></div><div class=\"window-body\"><h2 class=\"h2\">FAQs</h2>$faqsHtml</div></section>";

$words = word_count_html($body);
$minWords = 900; $maxWords = 1400;

// Pad with deterministic guidance if still short
if ($words < $minWords) {
  $pad = "<section class=\"window container\"><div class=\"title-bar\"><div class=\"title-bar-text\">Governance & Monitoring</div></div><div class=\"window-body\"><h3 class=\"h2\">Governance & Monitoring</h3>"
       ."<p>We operationalize ongoing checks: URL guards, schema validation, and crawl-stat alarms so improvements persist.</p>"
       ."<ul class=\"small\"><li>Daily diffs of sitemaps and canonicals</li><li>Param drift alerts</li><li>Rich results coverage trends</li></ul></div></section>";
  $body .= $pad;
}

// Final safety pad if still below threshold
if (word_count_html($body) < 900) {
  $body .= '<section class="window container"><div class="title-bar"><div class="title-bar-text">Implementation Notes</div></div><div class="window-body"><p class="small">We document tests and monitors so canonical and hreflang improvements persist across deploys, protecting crawl budget month over month.</p></div></section>';
}

$words = word_count_html($body);

// Page HTML
echo $body;

// Footer is included by router

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
echo "<script type=\"application/ld+json\">".json_encode($serviceLd, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)."</script>";

