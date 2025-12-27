<?php
declare(strict_types=1);
// Local SEO AI City Page - Production Template (Reusable for All Cities)
// URL: /en-gb/services/local-seo-ai/{city}/
// Role: Commercial Service Page - Hire AI + SEO services
// Template: Locked H1/H2/H3 structure, scalable city-by-city

require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/deterministic.php';
require_once __DIR__.'/../../lib/csv.php';
require_once __DIR__.'/../../lib/service_enhancements.php';
require_once __DIR__.'/../../lib/service_intent_taxonomy.php';

// Get service and city from router
$serviceSlug = $_GET['service'] ?? 'local-seo-ai';
$citySlug    = $_GET['city']    ?? 'norwich';
$pathKey = "/services/$serviceSlug/$citySlug/";

det_seed($pathKey);

$cityTitle = titleCaseCity($citySlug);

// INTENT TAXONOMY: Generate H1, subhead, and CTA based on URL contract (CLASS 2: Geo Service)
$intentContent = service_intent_content($serviceSlug, $citySlug);
$pageTitle = $intentContent['h1'];
$subhead = $intentContent['subhead'];
$ctaText = $intentContent['cta'];
$ctaQualifier = $intentContent['cta_qualifier'];

// Load city data for schema
$citiesData = csv_read_data('cities.csv');
$cityRow = null;
foreach ($citiesData as $c) {
  if (($c['city_name'] ?? '') === $citySlug) {
    $cityRow = $c;
    break;
  }
}
if (!$cityRow) {
  $cityRow = ['city_name' => $cityTitle, 'country' => 'US', 'subdivision' => ''];
}

$GLOBALS['__page_slug'] = 'services/service_local_seo_ai_city';

// Build canonical URL
$canonicalUrl = absolute_url($pathKey);
$domain = absolute_url('/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- H1: ONE ONLY - Intent Taxonomy: URL contract restated -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title"><?= htmlspecialchars($pageTitle) ?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead"><?= htmlspecialchars($subhead) ?></p>
        <?php
        // Add local proof line for UK cities
        if (function_exists('is_uk_city') && is_uk_city($citySlug)) {
          $region = 'Merseyside';
          if (strpos($citySlug, 'norwich') !== false) $region = 'Norfolk';
          elseif (strpos($citySlug, 'stockport') !== false || strpos($citySlug, 'manchester') !== false) $region = 'Greater Manchester';
          echo "<p>We've worked with businesses across $cityTitle and $region and consistently deliver results that automated tools miss.</p>";
        }
        ?>
      </div>
    </div>

    <!-- H2: Why Norwich Businesses Are Missed by AI Answers -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why <?= htmlspecialchars($cityTitle) ?> Businesses Are Missed by AI Answers</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems answer local questions by extracting business information from the web and verifying it before citing sources. Most business websites are written for human readers and search rankings, not for AI extraction.</p>
        <p>Business information is often mixed with promotional language, lacks explicit location boundaries, or appears inconsistently across platforms. AI systems avoid citing this type of content because it cannot be verified safely.</p>
        <p>The result is common across <?= htmlspecialchars($cityTitle) ?>: businesses appear in search results but are invisible in AI-generated answers.</p>
        <!-- H3: Optional -->
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Common visibility failures in local AI results</h3>
        <ul>
          <li>Promotional language that cannot be verified</li>
          <li>Ambiguous location boundaries ("serving the area")</li>
          <li>Inconsistent business names across platforms</li>
          <li>Mixed fact and opinion that confuses AI verification</li>
        </ul>
      </div>
    </div>

    <!-- H2: How AI Systems Choose Local Businesses to Reference -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Choose Local Businesses to Reference</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems evaluate local businesses using three primary signals.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Service clarity</h3>
        <p>Service clarity requires explicitly stating what a business does and under what conditions. Generic descriptions cannot be verified.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Location explicitness</h3>
        <p>Location explicitness requires clearly defining service areas and geographic boundaries. Ambiguous phrases reduce eligibility.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Trust and verification signals</h3>
        <p>Trust indicators include consistent entity naming, factual language, and repeatable signals across platforms.</p>
        
        <p style="margin-top: 1.5rem;">Traditional SEO tactics such as keyword optimization and link building do not address these signals. Rankings do not determine which businesses AI systems cite.</p>
      </div>
    </div>

    <!-- H2: Our Method: Structuring Local Data for AI Retrieval -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Our Method: Structuring Local Data for AI Retrieval</h2>
      </div>
      <div class="content-block__body">
        <p>We combine traditional SEO with AI-focused data structuring.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Traditional SEO</h3>
        <p>Traditional SEO improves crawlability, indexing, and keyword relevance. This remains necessary for organic search performance.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Prechunking SEO principles</h3>
        <p>AI optimization focuses on structuring business information so facts can be extracted without context loss. We apply Prechunking SEO principles to break information into atomic, self-contained statements that survive extraction.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Atomic, verifiable facts</h3>
        <p>Each fact must stand alone and be verifiable. For example, "This business provides X service" is atomic. "This business provides premium X services with trusted expertise" is not atomic because it mixes service definition with promotional language.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Cross-format consistency</h3>
        <p>The same facts are expressed consistently across pages, structured data, and supporting resources. This redundancy improves both search rankings and AI citation eligibility.</p>
      </div>
    </div>

    <!-- H2: What This Engagement Produces -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Engagement Produces</h2>
      </div>
      <div class="content-block__body">
        <p>After engagement, your business information becomes:</p>
        <ul>
          <li>Explicitly defined and scoped</li>
          <li>Consistent across platforms</li>
          <li>Safe for AI systems to extract and verify</li>
          <li>Eligible for citation in AI-generated answers</li>
        </ul>
        <p>You receive both improved traditional SEO performance and improved AI visibility.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Structured service definitions</h3>
        <p>Your services are defined explicitly, with clear scope and conditions. No ambiguous language that AI systems cannot verify.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Clear location boundaries</h3>
        <p>Your service area is defined precisely. "Serves <?= htmlspecialchars($cityTitle) ?>" replaces ambiguous phrases like "serving the area."</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">AI-safe entity signals</h3>
        <p>Your business name, location, and services appear identically across all platforms. This consistency signals reliability to AI systems.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Measurable AI visibility changes</h3>
        <p>We validate that improved information can be retrieved and cited by AI systems. This includes testing specific queries and confirming retrieval accuracy.</p>
      </div>
    </div>

    <!-- H2: Local Data Signals We Engineer for {City} -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Local Data Signals We Engineer for <?= htmlspecialchars($cityTitle) ?></h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($cityTitle) ?> businesses compete within a geographically constrained context. Location signals must be precise and consistent.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Explicit <?= htmlspecialchars($cityTitle) ?> service scope</h3>
        <p>We explicitly define <?= htmlspecialchars($cityTitle) ?> service scope and avoid ambiguous phrasing. For businesses with physical locations in <?= htmlspecialchars($cityTitle) ?>, address data is structured across multiple formats.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Address and geographic consistency</h3>
        <p>Address data is structured across multiple formats, including schema and geographic references. This multi-format approach increases citation eligibility while maintaining consistency.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Local query pattern modeling</h3>
        <p>We analyze local query patterns specific to <?= htmlspecialchars($cityTitle) ?> and model the follow-up questions AI systems must answer confidently. This includes how people ask about local services and what information AI systems require.</p>
      </div>
    </div>

    <!-- H2: What This Service Does and Does Not Do -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Service Does and Does Not Do</h2>
      </div>
      <div class="content-block__body">
        <p><strong>This service does:</strong></p>
        <ul>
          <li>Structure business information for AI retrieval</li>
          <li>Improve eligibility for AI-generated answers</li>
          <li>Reduce ambiguity and misinformation risk</li>
          <li>Combine traditional SEO with AI optimization</li>
        </ul>
        <p><strong>This service does not:</strong></p>
        <ul>
          <li>Guarantee AI mentions</li>
          <li>Control AI outputs</li>
          <li>Manipulate search algorithms</li>
          <li>Replace business licensing or qualifications</li>
        </ul>
      </div>
    </div>

    <!-- H2: How an Engagement Works -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How an Engagement Works</h2>
      </div>
      <div class="content-block__body">
        <h3 style="margin-top: 0; font-size: 1.125rem; font-weight: 600;">Step 1: Audit</h3>
        <p>We analyze how AI systems currently interpret your business.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Step 2: Recommendations</h3>
        <p>We provide prioritized, actionable changes with rationale.</p>
        
        <h3 style="margin-top: 1.5rem; font-size: 1.125rem; font-weight: 600;">Step 3: Implementation and validation</h3>
        <p>We implement improvements and validate retrieval outcomes.</p>
      </div>
    </div>

    <!-- H2: CTA - Intent Taxonomy: Service-named CTA -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Request <?= htmlspecialchars($cityTitle) ?> Local SEO AI Services</h2>
      </div>
      <div class="content-block__body">
        <p>To understand how AI systems currently interpret your business and identify opportunities for improvement, request local SEO AI services.</p>
        <div class="text-center" style="margin: 1.5rem 0;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($ctaText) ?>')"><?= htmlspecialchars($ctaText) ?></button>
        </div>
        <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;"><?= htmlspecialchars($ctaQualifier) ?></p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema
require_once __DIR__.'/../../lib/service_enhancements.php';
$serviceName = get_service_name_from_slug($serviceSlug);
$serviceType = get_service_type_from_slug($serviceSlug);

$serviceLd = [
  "@context" => "https://schema.org",
  "@type" => "Service",
  "name" => $serviceName,
  "serviceType" => $serviceType,
  "provider" => [
    "@type" => "Organization",
    "name" => "Neural Command LLC",
    "url" => "https://nrlc.ai"
  ],
  "areaServed" => [
    ["@type" => "City", "name" => $cityTitle],
    ["@type" => "Country", "name" => $cityRow['country'] ?? 'US']
  ],
  "url" => $canonicalUrl
];

$GLOBALS['__jsonld'] = array_merge($GLOBALS['__jsonld'] ?? [], [
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "@id" => $canonicalUrl . '#webpage',
    "name" => $pageTitle,
    "url" => $canonicalUrl,
    "description" => "We help $cityTitle businesses improve search rankings and AI visibility by structuring local data for safe extraction, trust, and citation.",
    "isPartOf" => [
      "@type" => "WebSite",
      "@id" => $domain . '/#website',
      "name" => "NRLC.ai",
      "url" => $domain
    ]
  ],
  [
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "@id" => $canonicalUrl . '#breadcrumb',
    "itemListElement" => [
      [
        "@type" => "ListItem",
        "position" => 1,
        "name" => "Home",
        "item" => $domain . "/"
      ],
      [
        "@type" => "ListItem",
        "position" => 2,
        "name" => "Services",
        "item" => $domain . "/services/"
      ],
      [
        "@type" => "ListItem",
        "position" => 3,
        "name" => $serviceName,
        "item" => $domain . "/services/$serviceSlug/"
      ],
      [
        "@type" => "ListItem",
        "position" => 4,
        "name" => $cityTitle,
        "item" => $canonicalUrl
      ]
    ]
  ],
  $serviceLd
]);
?>
