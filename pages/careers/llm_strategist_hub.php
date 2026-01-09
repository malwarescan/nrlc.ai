<?php
/**
 * TIER 0 HUB: LLM Strategist Definition-First Page
 * URL: /en-gb/careers/norwich/llm-strategist/
 * Goal: Be the definitive document for query "llm strategist"
 */

$GLOBALS['pageDesc'] = 'An LLM Strategist designs and runs the systems that influence how large language models retrieve, cite, and summarize information about a brand, product, or topic across AI answer engines.';
// Note: head.php and header.php are already included by router.php render_page()
// Do not duplicate them here to avoid double headers
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/deterministic.php';
require_once __DIR__.'/../../lib/SchemaNormalizers.php';

$roleSlug = $_GET['role'] ?? '';
$citySlug = $_GET['city'] ?? '';

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

// TIER 0 HUB: Definition-first structure
$hubDefinition = "<p class=\"lead\">An LLM Strategist designs and runs the systems that influence how large language models retrieve, cite, and summarize information about a brand, product, or topic across AI answer engines.</p>";

$coreResponsibilities = [
  "Design structured data architectures that enable accurate entity recognition and citation in AI systems",
  "Develop retrieval optimization strategies that increase brand visibility in ChatGPT, Claude, Perplexity, and Google AI Overviews",
  "Create and maintain canonical control systems that ensure AI engines cite the correct authoritative sources"
];

$whyRoleExists = "<p>This role exists because AI answer engines (ChatGPT, Claude, Google AI Overviews, Perplexity) have become primary discovery channels. Traditional SEO optimizes for search rankings, but LLM Strategists optimize for retrieval, citation accuracy, and entity alignment—ensuring AI systems understand and reference brands correctly when users ask questions.</p>";

$success90Days = [
  "Citation rate increases: Brand appears in 3+ AI answer engines with accurate attribution",
  "Retrieval surface area expands: Structured data enables AI systems to find and cite 5+ key brand entities",
  "Entity alignment improves: AI systems correctly associate brand with intended topics and services"
];

// H2 Sections
$whatIsSection = "<h2>What is an LLM Strategist?</h2>
<p>An LLM Strategist is a technical role that bridges traditional SEO and AI system optimization. Unlike SEO Strategists who focus on search engine rankings, LLM Strategists focus on how large language models retrieve, process, and cite information.</p>
<p>The role emerged as AI answer engines became primary discovery channels. When users ask ChatGPT \"What is [your product]?\" or when Google AI Overviews surface your brand, the LLM Strategist ensures accurate retrieval, proper citation, and correct entity alignment.</p>
<p>LLM Strategists work with structured data (JSON-LD, schema.org), entity recognition systems, canonical control mechanisms, and citation seeding strategies to influence how AI systems understand and reference brands.</p>";

$dayToDaySection = "<h2>What does an LLM Strategist do day to day?</h2>
<p>Daily work includes:</p>
<ul>
  <li><strong>Structured data architecture:</strong> Designing and implementing JSON-LD schemas that enable accurate entity recognition</li>
  <li><strong>Retrieval optimization:</strong> Analyzing how AI systems retrieve information and optimizing content structure for better discoverability</li>
  <li><strong>Citation tracking:</strong> Monitoring when and how AI systems cite your brand, identifying gaps and opportunities</li>
  <li><strong>Entity alignment:</strong> Ensuring AI systems correctly associate your brand with intended topics, services, and attributes</li>
  <li><strong>Canonical control:</strong> Managing which URLs AI systems treat as authoritative sources</li>
  <li><strong>Testing and validation:</strong> Running queries in ChatGPT, Claude, Perplexity to verify retrieval and citation accuracy</li>
</ul>";

$skillsSection = "<h2>Skills an LLM Strategist must have</h2>
<ul>
  <li><strong>Technical SEO foundation:</strong> Understanding of structured data, schema.org, canonical tags, hreflang</li>
  <li><strong>Entity recognition systems:</strong> Knowledge of how AI systems identify and classify entities</li>
  <li><strong>Data modeling:</strong> Ability to structure information in ways AI systems can accurately retrieve</li>
  <li><strong>Retrieval optimization:</strong> Understanding of how LLMs search and retrieve information from web sources</li>
  <li><strong>Citation mechanics:</strong> Knowledge of how AI systems attribute sources and generate citations</li>
  <li><strong>Analytics and measurement:</strong> Ability to track citation rates, retrieval surface area, entity alignment metrics</li>
  <li><strong>Technical implementation:</strong> Experience with JSON-LD, schema markup, API integrations</li>
</ul>";

$comparisonSection = "<h2>LLM Strategist vs SEO Strategist</h2>
<p>While both roles optimize for visibility, they target different systems:</p>
<table class=\"table\" style=\"width:100%; border-collapse:collapse; margin:1rem 0;\">
  <thead>
    <tr style=\"background:#f5f5f5;\">
      <th style=\"padding:0.5rem; border:1px solid #ddd;\">Aspect</th>
      <th style=\"padding:0.5rem; border:1px solid #ddd;\">SEO Strategist</th>
      <th style=\"padding:0.5rem; border:1px solid #ddd;\">LLM Strategist</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\"><strong>Primary Goal</strong></td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Rank #1 in search results</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Accurate retrieval and citation in AI systems</td>
    </tr>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\"><strong>Key Metrics</strong></td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Organic rankings, click-through rate, traffic</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Citation rate, retrieval surface area, entity alignment</td>
    </tr>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\"><strong>Primary Tools</strong></td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Search Console, keyword tools, backlink analyzers</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Structured data validators, entity recognition systems, AI answer engines</td>
    </tr>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\"><strong>Time Horizon</strong></td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">3-6 months for ranking improvements</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">30-90 days for citation and retrieval improvements</td>
    </tr>
  </tbody>
</table>
<p>For more detailed comparison, see <a href=\"/en-gb/insights/llm-strategist-vs-seo-strategist/\">LLM Strategist vs SEO Strategist</a>.</p>";

$influenceSection = "<h2>How LLM Strategists influence retrieval and citations</h2>
<p>LLM Strategists influence AI systems through four primary mechanisms:</p>
<ol>
  <li><strong>Entity grounding:</strong> Ensuring AI systems correctly identify and classify brand entities using structured data</li>
  <li><strong>Structured data execution:</strong> Implementing JSON-LD schemas that provide clear, machine-readable information about products, services, and organizations</li>
  <li><strong>Canonical control:</strong> Managing which URLs AI systems treat as authoritative sources through proper canonical tags and internal linking</li>
  <li><strong>Citation seeding:</strong> Creating content structures that make it easy for AI systems to extract and cite accurate information</li>
</ol>
<p>For detailed examples, see <a href=\"/en-gb/insights/how-llm-strategists-influence-retrieval/\">How LLM Strategists Influence Retrieval and Citations</a>.</p>";

$successSection = "<h2>What success looks like in 30/60/90 days</h2>
<h3>30 Days</h3>
<ul>
  <li>Structured data architecture implemented across key brand pages</li>
  <li>Initial citation tracking baseline established</li>
  <li>Entity recognition systems configured</li>
</ul>
<h3>60 Days</h3>
<ul>
  <li>Citation rate increases: Brand appears in 2+ AI answer engines</li>
  <li>Retrieval surface area expands: 3+ key brand entities discoverable by AI systems</li>
  <li>Canonical control mechanisms in place</li>
</ul>
<h3>90 Days</h3>
<ul>
  <li>Citation rate increases: Brand appears in 3+ AI answer engines with accurate attribution</li>
  <li>Retrieval surface area expands: Structured data enables AI systems to find and cite 5+ key brand entities</li>
  <li>Entity alignment improves: AI systems correctly associate brand with intended topics and services</li>
</ul>";

$toolsSection = "<h2>Tools and systems used</h2>
<ul>
  <li><strong>Structured data validators:</strong> Google Rich Results Test, Schema.org validator</li>
  <li><strong>Entity recognition systems:</strong> Knowledge Graph APIs, entity extraction tools</li>
  <li><strong>AI answer engines:</strong> ChatGPT, Claude, Perplexity, Google AI Overviews (for testing)</li>
  <li><strong>Citation tracking:</strong> Custom monitoring systems, API integrations</li>
  <li><strong>Data modeling tools:</strong> JSON-LD generators, schema markup builders</li>
  <li><strong>Analytics platforms:</strong> Custom dashboards for citation rates and retrieval metrics</li>
</ul>";

$faqs = [
  ["q" => "What is an LLM Strategist?", "a" => "An LLM Strategist designs and runs systems that influence how large language models retrieve, cite, and summarize information about brands, products, or topics across AI answer engines like ChatGPT, Claude, and Google AI Overviews."],
  ["q" => "What does an LLM Strategist do?", "a" => "LLM Strategists work with structured data, entity recognition systems, canonical control mechanisms, and citation seeding strategies to ensure AI systems accurately retrieve, understand, and cite brand information."],
  ["q" => "What skills does an LLM Strategist need?", "a" => "Required skills include technical SEO foundation (structured data, schema.org), entity recognition systems knowledge, data modeling ability, retrieval optimization understanding, citation mechanics knowledge, and analytics/measurement capabilities."],
  ["q" => "How is an LLM Strategist different from an SEO Strategist?", "a" => "SEO Strategists focus on search engine rankings and organic traffic. LLM Strategists focus on how AI systems retrieve, process, and cite information—optimizing for citation accuracy and entity alignment rather than search rankings."],
  ["q" => "What tools do LLM Strategists use?", "a" => "LLM Strategists use structured data validators, entity recognition systems, AI answer engines for testing, citation tracking tools, data modeling tools, and analytics platforms for measuring citation rates and retrieval metrics."],
  ["q" => "How do you measure LLM Strategist success?", "a" => "Success is measured by citation rate (how often AI systems cite your brand), retrieval surface area (how many brand entities AI systems can find), and entity alignment (how accurately AI systems associate your brand with intended topics)."],
  ["q" => "How long does it take to see results from LLM strategy work?", "a" => "Initial structured data implementation can show results in 30 days. Citation rate improvements typically appear within 60-90 days as AI systems crawl and index updated structured data."],
  ["q" => "Do you need technical skills to be an LLM Strategist?", "a" => "Yes. LLM Strategists need technical SEO skills (JSON-LD, schema markup), data modeling ability, and experience with entity recognition systems. However, the role also requires strategic thinking about how AI systems process information."]
];

$faqHtml = "<h2>FAQ</h2><div class=\"grid\" style=\"gap:1rem;\">";
foreach ($faqs as $faq) {
  $faqHtml .= "<details class=\"card\"><summary><strong>".htmlspecialchars($faq['q'])."</strong></summary><p>".htmlspecialchars($faq['a'])."</p></details>";
}
$faqHtml .= "</div>";

$furtherReading = "<h2>Further Reading</h2>
<ul>
  <li><a href=\"/en-gb/insights/glossary/llm-strategist/\">What is an LLM Strategist? (Glossary)</a></li>
  <li><a href=\"/en-gb/insights/llm-strategist-vs-seo-strategist/\">LLM Strategist vs SEO Strategist</a></li>
  <li><a href=\"/en-gb/insights/ai-search-roles/\">AI Search Roles</a></li>
  <li><a href=\"/en-gb/insights/llm-search-strategy-framework/\">LLM Search Strategy Framework</a></li>
  <li><a href=\"/en-gb/insights/how-llm-strategists-influence-retrieval/\">How LLM Strategists Influence Retrieval and Citations</a></li>
  <li><a href=\"/en-gb/insights/llm-strategist-faq/\">LLM Strategist FAQ</a></li>
  <li><a href=\"/en-gb/insights/how-to-become-an-llm-strategist/\">How to Become an LLM Strategist</a></li>
</ul>";

$responsibilitiesTable = "<h2>Responsibilities → Outputs → Metrics</h2>
<table class=\"table\" style=\"width:100%; border-collapse:collapse; margin:1rem 0;\">
  <thead>
    <tr style=\"background:#f5f5f5;\">
      <th style=\"padding:0.5rem; border:1px solid #ddd;\">Responsibility</th>
      <th style=\"padding:0.5rem; border:1px solid #ddd;\">Output</th>
      <th style=\"padding:0.5rem; border:1px solid #ddd;\">Metric</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Design structured data architecture</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">JSON-LD schemas across key pages</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Schema validation rate, entity recognition accuracy</td>
    </tr>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Optimize retrieval strategies</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Content structures optimized for AI discovery</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Retrieval surface area, citation rate</td>
    </tr>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Manage canonical control</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Authoritative URLs properly marked</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Canonical citation accuracy</td>
    </tr>
    <tr>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Track citations</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Citation reports and analysis</td>
      <td style=\"padding:0.5rem; border:1px solid #ddd;\">Citation rate, attribution accuracy</td>
    </tr>
  </tbody>
</table>";

$norwichContext = "<h2>LLM Strategist Position in ".htmlspecialchars($city['city_name'])."</h2>
<p>This LLM Strategist role is available in ".htmlspecialchars($city['city_name'])." as a remote position. Team members in ".htmlspecialchars($city['city_name'])." contribute to our global AI-first SEO expertise while understanding local market nuances.</p>
<p>We're looking for an LLM Strategist who can help clients optimize for AI answer engines and improve citation accuracy across ChatGPT, Claude, Perplexity, and Google AI Overviews.</p>";

$applySection = "<section class=\"section\">
  <div style=\"padding: 1rem;\">
    <p class=\"lead\">Ready to build the future of AI-first SEO?</p>
    <div class=\"flex-wrap\">
      <button type=\"button\" class=\"btn brand\" data-ripple onclick=\"openContactSheet('Career Application')\">Apply Now</button>
      <a href=\"/en-gb/careers/\" class=\"btn ghost\" data-ripple>View All Roles</a>
    </div>
  </div>
</section>";
?>
<main class="container">
  <h1>LLM Strategist</h1>
  <?=$hubDefinition?>
  
  <ul>
    <?php foreach ($coreResponsibilities as $resp): ?>
      <li><?=htmlspecialchars($resp)?></li>
    <?php endforeach; ?>
  </ul>
  
  <?=$whyRoleExists?>
  
  <ul>
    <?php foreach ($success90Days as $success): ?>
      <li><?=htmlspecialchars($success)?></li>
    <?php endforeach; ?>
  </ul>
  
  <?=$whatIsSection?>
  <?=$dayToDaySection?>
  <?=$skillsSection?>
  <?=$responsibilitiesTable?>
  <?=$comparisonSection?>
  <?=$influenceSection?>
  <?=$successSection?>
  <?=$toolsSection?>
  <?=$faqHtml?>
  <?=$furtherReading?>
  <?=$norwichContext?>
  <?=$applySection?>
</main>

<?php
// Schema: BreadcrumbList
// Get locale from request URL or use default
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
} else {
  // Fallback: determine locale based on city (UK cities → en-gb, others → en-us)
  // Note: helpers.php is already required at the top of this file
  if (function_exists('is_uk_city') && is_uk_city($citySlug)) {
    $locale = 'en-gb';
  } else {
    $locale = 'en-us';
  }
}
$localePrefix = $locale ? "/$locale" : '/en-us';
$canonicalUrl = 'https://nrlc.ai' . $localePrefix . '/careers/' . $citySlug . '/' . $roleSlug . '/';
$breadcrumbLd = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  '@id' => $canonicalUrl . '#breadcrumb',
  'itemListElement' => [
    [
      '@type' => 'ListItem',
      'position' => 1,
      'name' => 'Home',
      'item' => 'https://nrlc.ai/'
    ],
    [
      '@type' => 'ListItem',
      'position' => 2,
      'name' => 'Careers',
      'item' => 'https://nrlc.ai' . $localePrefix . '/careers/'
    ],
    [
      '@type' => 'ListItem',
      'position' => 3,
      'name' => 'LLM Strategist',
      'item' => $canonicalUrl
    ]
  ]
];

// Schema: FAQPage
$faqPageLd = [
  '@context' => 'https://schema.org',
  '@type' => 'FAQPage',
  '@id' => $canonicalUrl . '#faq',
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

// Schema: WebPage
$webPageLd = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => 'LLM Strategist',
  'url' => $canonicalUrl,
  'description' => 'An LLM Strategist designs and runs the systems that influence how large language models retrieve, cite, and summarize information about a brand, product, or topic across AI answer engines.',
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => 'https://nrlc.ai/#website',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai'
  ],
  'inLanguage' => 'en-GB',
  'about' => [
    '@type' => 'Thing',
    'name' => 'LLM Strategist'
  ]
];

// Schema: JobPosting (keep valid but don't dominate)
$fullDescription = strip_tags($hubDefinition . $whatIsSection . $dayToDaySection . $skillsSection);
$fullDescription = preg_replace('/\s+/', ' ', $fullDescription);
$fullDescription = substr($fullDescription, 0, 5000);

// Normalize experience and education requirements
$rawExperience = '3+ years of technical SEO experience';
$normExperience = App\Schema\SchemaNormalizers::normalizeExperienceRequirements($rawExperience);

$rawEducation = 'Bachelor\'s degree in Computer Science, Marketing, or related field';
$normEducation = App\Schema\SchemaNormalizers::normalizeEducationRequirements($rawEducation);

// Ensure address fields are not empty - use defaults if city data is missing
$addressLocality = !empty($city['city_name']) ? $city['city_name'] : ucwords(str_replace('-', ' ', $citySlug));
$addressCountry = !empty($city['country']) ? $city['country'] : 'US';

$jobPostingLd = [
  '@context' => 'https://schema.org',
  '@type' => 'JobPosting',
  '@id' => $canonicalUrl . '#jobposting',
  'title' => 'LLM Strategist',
  'description' => $fullDescription,
  'datePosted' => date('Y-m-d'),
  'validThrough' => gmdate('Y-m-d', strtotime('+45 days')),
  'employmentType' => 'FULL_TIME',
  'hiringOrganization' => [
    '@type' => 'Organization',
    '@id' => 'https://nrlc.ai/#organization',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai',
    'logo' => [
      '@type' => 'ImageObject',
      'url' => 'https://nrlc.ai/assets/images/nrlcai%20logo%200.png'
    ]
  ],
  'jobLocation' => [
    '@type' => 'Place',
    'address' => [
      '@type' => 'PostalAddress',
      'streetAddress' => 'Remote',
      'addressLocality' => $addressLocality,
      'postalCode' => '00000',
      'addressCountry' => $addressCountry
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
  ]
];

// Add experience and education requirements if normalized
if ($normExperience) {
  $jobPostingLd['experienceRequirements'] = $normExperience;
}
if ($normEducation) {
  $jobPostingLd['educationRequirements'] = $normEducation;
}

// Add addressRegion only if city subdivision is available and not empty
if (!empty($city['subdivision'])) {
  $jobPostingLd['jobLocation']['address']['addressRegion'] = $city['subdivision'];
}

// Drop nulls and empty arrays (but keep 0 and false values)
$jobPostingLd = array_filter($jobPostingLd, static function($v) { 
  return $v !== null && $v !== '' && (!is_array($v) || !empty($v)); 
});

$GLOBALS['__jsonld'] = [$breadcrumbLd, $faqPageLd, $webPageLd, $jobPostingLd];
?>

