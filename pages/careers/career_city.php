<?php
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';

$roleSlug = $_GET['role'] ?? '';
$citySlug = $_GET['city'] ?? '';

$rolesMap  = csv_to_map('careers.csv','slug');
$citiesMap = csv_to_map('cities.csv','city');

$role = $rolesMap[$roleSlug] ?? ['slug'=>$roleSlug,'title'=>ucwords(str_replace('-',' ',$roleSlug))];
$city = $citiesMap[$citySlug] ?? ['city_name'=>ucwords(str_replace('-',' ',$citySlug)),'country'=>'US','subdivision'=>''];

$job = [
  'title'=>$role['title'].' — '.$city['city_name'],
  'description_html'=>'<p>Join NRLC.ai to build world-class JSON-LD, LLM seeding systems, and multi-regional SEO.</p>',
  'datePosted'=>gmdate('Y-m-d'),
  'validThrough'=>gmdate('Y-m-d', strtotime('+45 days')),
  'employmentType'=>'FULL_TIME'
];

inject_jsonld([ ld_jobposting($job, $city) ]);
?>
<main class="container">
  <h1><?=htmlspecialchars($job['title'])?></h1>
  <p>Based in <?=htmlspecialchars($city['city_name'])?> — remote-friendly within <?=htmlspecialchars($city['country'])?>.</p>
  <a class="btn" href="/api/book">Apply</a>
</main>

