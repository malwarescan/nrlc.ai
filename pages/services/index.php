<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set in router.php before head.php is included
require_once __DIR__.'/../../lib/helpers.php';

// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Add UK city links for en-GB locale (discovery path for canonical collapse fix)
if ($locale === 'en-gb' || $locale === '') {
  $featuredUKCities = ['norwich', 'london', 'manchester', 'birmingham', 'leeds', 'sheffield', 'southampton'];
  $ukCityLinks = [];
  foreach ($featuredUKCities as $city) {
    if (function_exists('is_uk_city') && is_uk_city($city)) {
      $ukCityLinks[] = [
        'name' => ucwords(str_replace(['-', '_'], ' ', $city)),
        'url' => '/en-gb/services/local-seo-ai/' . $city . '/'
      ];
    }
  }
}
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Services Header Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI SEO and Generative Search Optimization Services</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Professional AI SEO and AI visibility services for businesses that need real improvements in search rankings, AI citations, and generative engine visibility.</p>
        <p>We provide hireable services that improve how search engines and AI systems find, understand, and cite your business. Services include AI visibility audits, structured data implementation, technical SEO optimization, and AI citation growth.</p>
        <p>Explore our <a href="<?= htmlspecialchars($localePrefix . '/insights/') ?>" title="AI SEO research and insights">AI SEO Research & Insights</a> and learn more about our <a href="<?= htmlspecialchars($localePrefix . '/tools/') ?>" title="SEO tools and resources">SEO Tools & Resources</a>.</p>
      </div>
    </div>

    <!-- AI SEO Services List -->
    <div class="content-block module">
      <div class="content-block__body">
        
        <!-- AI Search Optimization -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">AI Search Optimization – AI Overview & Generative Search Visibility Service</h2>
          </div>
          <div class="content-block__body">
            <p>Professional service that improves how your business appears in Google AI Overviews, ChatGPT, Perplexity, and other generative search engines. We optimize content structure, entity signals, and citation readiness to increase AI visibility and recommendations.</p>
            <p><strong>What improves:</strong> AI citations, generative search visibility, AI Overview appearances, brand mentions in AI-generated answers.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" class="btn" title="AI search optimization service for generative engines">View AI Search Optimization Service</a>
            </div>
          </div>
        </div>

        <!-- Site Audits -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Site Audits – AI & Search Visibility Diagnostic Service</h2>
          </div>
          <div class="content-block__body">
            <p>Comprehensive site audits that explain why visibility breaks down, not just surface-level issues. We analyze how search engines and AI systems interpret your site, identify ambiguity, and provide prioritized fixes that improve rankings and AI citations.</p>
            <p><strong>What improves:</strong> Search rankings, AI visibility, technical SEO issues, content structure, entity clarity.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/site-audits/') ?>" class="btn" title="Site audit service for AI and search visibility">View Site Audit Service</a>
            </div>
          </div>
        </div>

        <!-- Crawl Clarity Engineering -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Crawl Clarity Engineering – URL Normalization & Canonical Enforcement Service</h2>
          </div>
          <div class="content-block__body">
            <p>Systematic URL normalization and canonical enforcement service that eliminates duplicate content issues and ensures search engines crawl the correct versions of your pages. We fix crawl budget waste, canonical conflicts, and indexing problems.</p>
            <p><strong>What improves:</strong> Crawl efficiency, indexing rates, duplicate content issues, search engine understanding of page relationships.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/crawl-clarity/') ?>" class="btn" title="Crawl clarity engineering service for URL normalization">View Crawl Clarity Service</a>
            </div>
          </div>
        </div>

        <!-- JSON-LD & Structured Data -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">JSON-LD & Structured Data – Schema Markup Implementation Service</h2>
          </div>
          <div class="content-block__body">
            <p>Comprehensive schema markup implementation service that structures your content for search engines and AI systems. We implement JSON-LD, microdata, and structured data that improves rich results, knowledge graph inclusion, and AI citation eligibility.</p>
            <p><strong>What improves:</strong> Rich results, knowledge graph inclusion, AI citation eligibility, structured data accuracy, search result appearance.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/json-ld-strategy/') ?>" class="btn" title="JSON-LD and structured data implementation service">View Structured Data Service</a>
            </div>
          </div>
        </div>

        <!-- LLM Seeding & Citation -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">LLM Seeding & Citation – AI Citation Growth & Visibility Service</h2>
          </div>
          <div class="content-block__body">
            <p>Content optimization service that prepares your business for AI citations in ChatGPT, Google AI Overviews, and other generative engines. We structure content for AI extraction, improve entity clarity, and build citation-ready authority signals.</p>
            <p><strong>What improves:</strong> AI citations, brand mentions in AI answers, generative search visibility, entity recognition by AI systems.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/llm-seeding/') ?>" class="btn" title="LLM seeding and citation service for AI visibility">View LLM Seeding Service</a>
            </div>
          </div>
        </div>

        <!-- Technical SEO -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Technical SEO – Core Web Vitals & Crawl Optimization Service</h2>
          </div>
          <div class="content-block__body">
            <p>Technical SEO service that fixes crawl issues, improves site speed, and optimizes Core Web Vitals. We resolve technical barriers that prevent search engines from indexing and ranking your content effectively.</p>
            <p><strong>What improves:</strong> Site speed, Core Web Vitals scores, crawl efficiency, indexing rates, technical SEO barriers.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/technical-seo/') ?>" class="btn" title="Technical SEO service for crawl optimization">View Technical SEO Service</a>
            </div>
          </div>
        </div>

        <!-- International SEO -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">International SEO – Multi-Regional Search Optimization Service</h2>
          </div>
          <div class="content-block__body">
            <p>Multi-regional SEO service that implements hreflang tags, manages international site structure, and optimizes for multiple markets. We ensure search engines understand your international presence and serve the correct content to the right audiences.</p>
            <p><strong>What improves:</strong> International rankings, hreflang accuracy, multi-regional visibility, local search performance.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/international-seo/') ?>" class="btn" title="International SEO service for multi-regional optimization">View International SEO Service</a>
            </div>
          </div>
        </div>

        <!-- AI Visibility & Analytics -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">AI Visibility & Analytics – AI Engine Performance Tracking Service</h2>
          </div>
          <div class="content-block__body">
            <p>Analytics and tracking service that measures how your business appears in AI-generated answers, tracks AI citations, and monitors generative search visibility. We provide reporting on AI Overview appearances, ChatGPT mentions, and AI citation frequency.</p>
            <p><strong>What improves:</strong> AI visibility measurement, citation tracking, performance reporting, AI search analytics.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/analytics/') ?>" class="btn" title="AI visibility and analytics service for performance tracking">View Analytics Service</a>
            </div>
          </div>
        </div>

        <!-- Training -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title">Training – AI Search Systems Education & Implementation Service</h2>
          </div>
          <div class="content-block__body">
            <p>Training service for marketing and SEO teams on how AI search systems work, how LLMs ingest content, and how to optimize for generative engines. We provide workshops, documentation, and implementation guidance for in-house teams and agencies.</p>
            <p><strong>What improves:</strong> Team knowledge, implementation capability, AI search optimization skills, internal execution quality.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/training/') ?>" class="btn" title="Training service for AI search systems">View Training Service</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" title="AI SEO services">AI SEO Services</a> including <a href="<?= htmlspecialchars($localePrefix . '/services/crawl-clarity/') ?>" title="Crawl clarity engineering service">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="<?= htmlspecialchars($localePrefix . '/insights/') ?>" title="AI SEO research and insights">AI SEO Research & Insights</a> including the <a href="<?= htmlspecialchars($localePrefix . '/insights/geo16-introduction/') ?>" title="GEO-16 framework for AI citation optimization">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="<?= htmlspecialchars($localePrefix . '/tools/') ?>" title="SEO tools and resources">SEO Tools & Resources</a> for technical SEO optimization.</p>
        <div class="btn-group text-center">
          <a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" class="btn btn--primary" title="Get started with AI search optimization services">Get Started with AI SEO</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// LINKING KERNEL: Add required internal links
if (function_exists('render_internal_links_section')) {
  echo render_internal_links_section('services', '', [], 'Explore More');
}
?>

<?php if (!empty($ukCityLinks)): ?>
<!-- UK City Services Section (Discovery Path for Canonical Collapse Fix) -->
<div class="content-block module">
  <div class="content-block__header">
    <h2 class="content-block__title">Local SEO Services in UK Cities</h2>
  </div>
  <div class="content-block__body">
    <p>Professional local SEO services for businesses in major UK cities. We help improve search rankings, AI citations, and local visibility.</p>
    <ul>
      <?php foreach ($ukCityLinks as $link): ?>
      <li><a href="<?= htmlspecialchars($link['url']) ?>" title="Local SEO services in <?= htmlspecialchars($link['name']) ?>">Local SEO in <?= htmlspecialchars($link['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php endif; ?>

<!-- City-Specific Service Pages (GSC Indexing Fix) -->
<div class="content-block module">
  <div class="content-block__header">
    <h2 class="content-block__title">Service Locations</h2>
  </div>
  <div class="content-block__body">
    <p>Find specialized AI SEO services in your city. Our location-specific pages provide tailored insights for local markets.</p>

    <?php
    // Add links to popular city-service combinations to improve internal linking
    $popularCities = ['new-york', 'los-angeles', 'london', 'manchester', 'birmingham', 'tokyo', 'seoul', 'singapore'];
    $popularServices = ['crawl-clarity', 'ai-overviews-optimization', 'generative-seo', 'local-seo-ai'];

    echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">';

    foreach ($popularServices as $service) {
      echo '<div>';
      echo '<h3>' . ucwords(str_replace('-', ' ', $service)) . '</h3>';
      echo '<ul style="margin: 0;">';

      foreach ($popularCities as $city) {
        $isUK = in_array($city, ['london', 'manchester', 'birmingham']);
        $locale = $isUK ? 'en-gb' : 'en-us';
        $url = '/' . $locale . '/services/' . $service . '/' . $city . '/';
        $cityName = ucwords(str_replace('-', ' ', $city));

        echo '<li style="margin-bottom: 0.25rem;"><a href="' . htmlspecialchars($url) . '" title="' . ucwords(str_replace('-', ' ', $service)) . ' in ' . $cityName . '">' . $cityName . '</a></li>';
      }

      echo '</ul>';
      echo '</div>';
    }

    echo '</div>';
    ?>
  </div>
</div>

<?php
// JSON-LD Schema
require_once __DIR__ . '/../../lib/helpers.php';
$domain = 'https://nrlc.ai';
$canonicalUrl = absolute_url('/services/');

$jsonld = [
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "@id" => $canonicalUrl . '#webpage',
    "name" => "AI SEO & AI Visibility Services",
    "url" => $canonicalUrl,
    "description" => "Professional AI SEO and AI visibility services for businesses that need real improvements in search rankings, AI citations, and generative engine visibility.",
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
        "item" => $canonicalUrl
      ]
    ]
  ],
  [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "name" => "AI SEO & AI Visibility Services",
    "description" => "Professional AI SEO and AI visibility services including site audits, structured data implementation, technical SEO optimization, and AI citation growth.",
    "provider" => [
      "@type" => "Organization",
      "name" => "NRLC.ai",
      "url" => "https://nrlc.ai"
    ],
    "serviceType" => "AI SEO Services",
    "areaServed" => "Worldwide",
    "hasOfferCatalog" => [
      "@type" => "OfferCatalog",
      "name" => "AI SEO Services Catalog",
      "itemListElement" => [
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "AI Search Optimization"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Site Audits"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Crawl Clarity Engineering"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "JSON-LD & Structured Data"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "LLM Seeding & Citation"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Technical SEO"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "International SEO"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "AI Visibility & Analytics"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Training"
          ]
        ]
      ]
    ]
  ]
];

$GLOBALS['__jsonld'] = $jsonld;
?>
