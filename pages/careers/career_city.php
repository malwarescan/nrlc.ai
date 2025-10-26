<?php
require_once __DIR__.'/../../templates/head.php';
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/deterministic.php';
require_once __DIR__.'/../../lib/SchemaNormalizers.php';

$roleSlug = $_GET['role'] ?? '';
$citySlug = $_GET['city'] ?? '';

// Simple role mapping with fallback
$role = ['slug'=>$roleSlug,'title'=>ucwords(str_replace('-',' ',$roleSlug))];

// Get city data
$citiesData = csv_read_data('cities.csv');
$city = null;
foreach ($citiesData as $c) {
  if ($c['city_name'] === $citySlug) {
    $city = $c;
    break;
  }
}
if (!$city) {
  $city = ['city_name'=>ucwords(str_replace('-',' ',$citySlug)),'country'=>'US','subdivision'=>''];
}

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

$impact = "<h2 class=\"h2\">Impact at NRLC.ai</h2><p>Your work directly influences how AI systems understand and surface our clients' services. You'll be building the infrastructure that makes brands discoverable to both search engines and large language models, ensuring accurate citations and improved visibility across all major AI platforms.</p><p>As part of our technical team, you'll work on challenging problems that sit at the intersection of traditional SEO and emerging AI technologies. Your implementations will directly impact how hundreds of websites appear in ChatGPT citations, Claude conversations, and Perplexity search results. You'll see measurable results from your work—improved citation accuracy, increased AI engine visibility, and enhanced crawl efficiency—often within weeks of implementation.</p>";

$qualifications = "<h2 class=\"h2\">Required Qualifications</h2><ul><li>3+ years of technical SEO experience with focus on crawl optimization, structured data, or international SEO</li><li>Strong understanding of JSON-LD, schema.org vocabularies, and semantic web technologies</li><li>Experience with PHP, Python, or similar server-side languages for SEO automation</li><li>Proficiency in analyzing server logs, crawl data, and search console metrics</li><li>Understanding of HTTP protocols, URL normalization, canonical tags, and hreflang implementation</li><li>Excellent problem-solving skills and attention to detail</li><li>Strong written and verbal communication skills for client interaction and technical documentation</li></ul><p><strong>Preferred Qualifications:</strong> Experience with AI/LLM technologies, knowledge of entity recognition systems, familiarity with multi-regional content delivery, background in information architecture or data modeling.</p>";

$benefits = "<h2 class=\"h2\">Benefits & Compensation</h2><p>We offer competitive compensation packages that reflect your experience and impact. Base salary ranges from \$80,000 to \$150,000 depending on experience level and location, with additional performance bonuses and equity participation for senior roles.</p><p><strong>Health & Wellness:</strong> Comprehensive health, dental, and vision insurance with employer-paid premiums. Mental health support and wellness stipends. Flexible PTO policy with minimum vacation requirements to ensure work-life balance.</p><p><strong>Remote Work:</strong> Fully distributed team with flexible hours. Home office stipend for equipment and internet. Co-working space allowances for those who prefer external office environments.</p><p><strong>Professional Development:</strong> Conference attendance budget, online course subscriptions, and dedicated learning time. Regular technical workshops and knowledge sharing sessions with team experts.</p>";

$cityContext = "<h2 class=\"h2\">Working in ".htmlspecialchars($city['city_name'])."</h2><p>Our ".htmlspecialchars($city['city_name'])." team members contribute to our global SEO expertise while understanding local market nuances. We value the diverse perspectives that come from our distributed team across multiple time zones and cultural backgrounds.</p><p>Team members in ".htmlspecialchars($city['city_name'])." work closely with colleagues across North America, Europe, and Asia, bringing regional insights that improve our strategies and implementations. Whether you're collaborating on multi-regional hreflang configurations, debugging crawl issues specific to local hosting providers, or sharing cultural context that informs content strategy, your location expertise adds value to every project.</p>";

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
  'description_html'=>$intro.$impact.$qualifications.$benefits.$cityContext.$faqHtml,
  'datePosted'=>gmdate('Y-m-d'),
  'validThrough'=>gmdate('Y-m-d', strtotime('+45 days')),
  'employmentType'=>'FULL_TIME'
];
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
  <?=$qualifications?>
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

<?php
// Normalize experience and education requirements
$rawExperience = '3+ years of technical SEO experience';
$normExperience = App\Schema\SchemaNormalizers::normalizeExperienceRequirements($rawExperience);

$rawEducation = 'Bachelor\'s degree in Computer Science, Marketing, or related field';
$normEducation = App\Schema\SchemaNormalizers::normalizeEducationRequirements($rawEducation);

// JobPosting Schema
$jobPostingLd = [
  '@context' => 'https://schema.org',
  '@type' => 'JobPosting',
  '@id' => 'https://nrlc.ai/careers/' . $citySlug . '/' . $roleSlug . '/#jobposting',
  'title' => $role['title'],
  'description' => "Join NRLC.ai in {$city['city_name']} to build world-class JSON-LD, LLM seeding systems, and multi-regional SEO infrastructure that powers AI-first search experiences.",
  'datePosted' => date('Y-m-d'),
  'validThrough' => gmdate('Y-m-d', strtotime('+45 days')),
  'employmentType' => 'FULL_TIME',
  'hiringOrganization' => [
    '@type' => 'Organization',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai',
    'logo' => 'https://nrlc.ai/assets/images/nrlcai%20logo%200.png'
  ],
  'jobLocation' => [
    '@type' => 'Place',
    'address' => [
      '@type' => 'PostalAddress',
      'streetAddress' => 'Remote', // Remote work - no physical address required
      'addressLocality' => $city['city_name'],
      'addressRegion' => $city['subdivision'] ?? '',
      'postalCode' => '00000', // Generic postal code for remote positions
      'addressCountry' => $city['country'] ?? 'US'
    ]
  ],
  'baseSalary' => [
    '@type' => 'MonetaryAmount',
    'currency' => 'USD',
    'value' => [
      '@type' => 'QuantitativeValue',
      'minValue' => '80000',
      'maxValue' => '150000',
      'unitText' => 'YEAR'
    ]
  ],
  // Use normalized experience and education requirements
  'experienceRequirements' => $normExperience,
  'educationRequirements' => $normEducation,
  'qualifications' => 'Bachelor\'s degree in Computer Science, Marketing, or related field. Experience with SEO, structured data, and AI technologies preferred.',
  'responsibilities' => [
    'Design and implement crawl clarity solutions for enterprise clients',
    'Build deterministic content generation systems for LLM seeding',
    'Develop JSON-LD schema strategies across multiple industries',
    'Optimize multi-regional SEO with proper hreflang implementation',
    'Create agent surfaces for AI discoverability and citation accuracy'
  ],
  'skills' => ['SEO', 'JSON-LD', 'LLM Optimization', 'Structured Data', 'AI SEO'],
  'workHours' => '40 hours per week',
  'benefits' => 'Health insurance, dental, vision, 401k, flexible PTO, remote work options'
];

// Drop nulls
$jobPostingLd = array_filter($jobPostingLd, static function($v) { return $v !== null && $v !== ''; });

// LocalBusiness Schema
$localBusinessLd = [
  '@context' => 'https://schema.org',
  '@type' => 'LocalBusiness',
  'name' => 'NRLC.ai',
  'url' => absolute_url('/'),
  'description' => "AI-first SEO services with career opportunities in {$city['city_name']}.",
  'telephone' => '+1-844-568-4624',
  'email' => 'hirejoelm@gmail.com',
  'address' => [
    '@type' => 'PostalAddress',
    'addressLocality' => $city['city_name'],
    'addressCountry' => $city['country'] ?? 'US'
  ],
  'areaServed' => [
    '@type' => 'City',
    'name' => $city['city_name'],
    'containedInPlace' => [
      '@type' => 'Country',
      'name' => $city['country'] ?? 'US'
    ]
  ]
];

// Store JSON-LD blocks for footer template
$GLOBALS['__jsonld'] = [$jobPostingLd, $localBusinessLd];

require_once __DIR__.'/../../templates/footer.php';
?>