<?php
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/deterministic.php';

$roleSlug = $_GET['role'] ?? '';
$citySlug = $_GET['city'] ?? '';

$rolesMap  = csv_to_map('careers.csv','slug');
$citiesMap = csv_to_map('cities.csv','city_name');

$role = $rolesMap[$roleSlug] ?? ['slug'=>$roleSlug,'title'=>ucwords(str_replace('-',' ',$roleSlug))];
$city = $citiesMap[$citySlug] ?? ['city_name'=>ucwords(str_replace('-',' ',$citySlug)),'country'=>'US','subdivision'=>''];

det_seed("/careers/$citySlug/$roleSlug/");

// Generate hefty job description
$intro = "<p class=\"lead\">Join NRLC.ai in ".htmlspecialchars($city['city_name'])." to build world-class JSON-LD, LLM seeding systems, and multi-regional SEO infrastructure that powers AI-first search experiences.</p>";

$responsibilities = [
  "Design and implement crawl clarity solutions for enterprise clients",
  "Build deterministic content generation systems for LLM seeding",
  "Develop JSON-LD schema strategies across multiple industries",
  "Optimize multi-regional SEO with proper hreflang implementation",
  "Create agent surfaces for AI discoverability and citation accuracy",
  "Monitor and improve Core Web Vitals and technical SEO metrics",
  "Collaborate with engineering teams on scalable SEO infrastructure",
  "Research and implement emerging AI/LLM optimization techniques"
];

$impact = "<h2 class=\"h2\">Impact at NRLC.ai</h2><p>Your work directly influences how AI systems understand and surface our clients' services. You'll be building the infrastructure that makes brands discoverable to both search engines and large language models, ensuring accurate citations and improved visibility across all major AI platforms.</p>";

$benefits = "<h2 class=\"h2\">Benefits & Remote Policy</h2><p>We offer competitive compensation, equity participation, comprehensive health benefits, and a fully remote work environment. Team members in ".htmlspecialchars($city['city_name'])." benefit from our local time zone coordination and occasional in-person meetups.</p>";

$cityContext = "<h2 class=\"h2\">Working in ".htmlspecialchars($city['city_name'])."</h2><p>Our ".htmlspecialchars($city['city_name'])." team members contribute to our global SEO expertise while understanding local market nuances. We value the diverse perspectives that come from our distributed team across multiple time zones.</p>";

$faqs = [
  ["q" => "What's the remote work policy?", "a" => "We're fully remote with flexible hours. Team members can work from anywhere within their country with occasional team meetups."],
  ["q" => "What technologies do you use?", "a" => "PHP 8+, JSON-LD, structured data, sitemap generation, and various AI/LLM optimization tools."],
  ["q" => "How do you measure success?", "a" => "We track crawl efficiency, rich result impressions, LLM citation accuracy, and client satisfaction metrics."],
  ["q" => "What's the team culture like?", "a" => "We're a collaborative, data-driven team focused on solving complex SEO challenges with innovative approaches."],
  ["q" => "Are there growth opportunities?", "a" => "Yes, we encourage professional development and offer clear paths for advancement in technical SEO and AI optimization."]
];

$faqHtml = "<h2 class=\"h2\">Frequently Asked Questions</h2><div class=\"grid grid-gap-4\">";
foreach ($faqs as $faq) {
  $faqHtml .= "<details class=\"card\"><summary><strong>".htmlspecialchars($faq['q'])."</strong></summary><p class=\"small muted\">".htmlspecialchars($faq['a'])."</p></details>";
}
$faqHtml .= "</div>";

$job = [
  'title'=>$role['title'].' — '.$city['city_name'],
  'description_html'=>$intro.$impact.$benefits.$cityContext.$faqHtml,
  'datePosted'=>gmdate('Y-m-d'),
  'validThrough'=>gmdate('Y-m-d', strtotime('+45 days')),
  'employmentType'=>'FULL_TIME'
];

inject_jsonld([ ld_jobposting($job, $city) ]);
?>
<main class="container">
  <h1 class="h1"><?=htmlspecialchars($job['title'])?></h1>
  <?=$intro?>
  
  <section class="section">
    <h2 class="h2">Key Responsibilities</h2>
    <ul>
      <?php foreach ($responsibilities as $resp): ?>
        <li><?=htmlspecialchars($resp)?></li>
      <?php endforeach; ?>
    </ul>
  </section>
  
  <?=$impact?>
  <?=$benefits?>
  <?=$cityContext?>
  <?=$faqHtml?>
  
  <section class="section">
    <div style="padding: 1rem;">
      <p class="lead">Ready to build the future of AI-first SEO?</p>
      <div class="flex-wrap">
        <a href="/api/book" class="btn brand" data-ripple>Apply Now</a>
        <a href="/careers/" class="btn ghost" data-ripple>View All Roles</a>
      </div>
    </div>
  </section>
</main>

