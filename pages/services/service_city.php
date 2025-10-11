<?php
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/schema_builders.php';

$serviceSlug = $_GET['service'] ?? '';
$citySlug    = $_GET['city'] ?? '';

$servicesMap = csv_to_map('services.csv','slug');
$citiesMap   = csv_to_map('cities.csv','city');

$service = $servicesMap[$serviceSlug] ?? ['slug'=>$serviceSlug,'name'=>ucwords(str_replace('-',' ',$serviceSlug))];
$city    = $citiesMap[$citySlug] ?? ['city_name'=>ucwords(str_replace('-',' ',$citySlug)),'country'=>'US','subdivision'=>'','lat'=>null,'lng'=>null,'lang'=>'en','tld'=>'.com'];

$painPoints = get_pain_points_for_service($serviceSlug);

// FAQs pool (extend or externalize)
$faqs = [
  ['q'=>'How do you ensure crawl clarity?','a'=>'We enforce canonical paths, deterministic trailing slashes, and strip query noise at the edge.'],
  ['q'=>'Do you support hreflang?','a'=>'Yes. We emit full hreflang clusters with x-default and locale-prefixed routing.'],
  ['q'=>'Will pages be unique for each city?','a'=>'Yes. We use a deterministic token system to generate hefty, unique copy per URL.'],
  ['q'=>'What schemas are included?','a'=>'Service, LocalBusiness, FAQPage, WebSite (with SearchAction), and BreadcrumbList.']
];

$path = "/services/{$serviceSlug}/{$citySlug}/";
$desc = generate_service_description($service, $city, $painPoints, $path);

inject_jsonld([
  ld_service($service, $city, $painPoints, $desc),
  ld_local_business($city),
  ld_faq($faqs),
]);

echo generate_hefty_body($service, $city, $faqs, $painPoints, $path);

