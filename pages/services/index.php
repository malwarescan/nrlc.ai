<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set in router.php before head.php is included
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Get canonical URL and domain
$canonicalUrl = absolute_url('/services/');
$domain = absolute_url('/');
$orgId = SchemaFixes::ensureHttps($domain) . '#organization';
$personId = SchemaFixes::ensureHttps($domain) . '#joel-maldonado';

// Enhance metadata with keywords
if (isset($GLOBALS['__page_meta']) && is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'AI SEO services, AI search optimization, generative search optimization, AI visibility services, ChatGPT optimization, Perplexity optimization, Google AI Overviews optimization, structured data services, technical SEO services, AI citation services, LLM seeding, schema markup services, AEO services, GEO services';
}

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

// Service definitions for schema
$serviceDefinitions = [
  'AI Search Optimization' => 'Professional service that improves how your business appears in Google AI Overviews, ChatGPT, Perplexity, and other generative search engines.',
  'Site Audits' => 'Comprehensive site audits that explain why visibility breaks down, not just surface-level issues.',
  'Crawl Clarity Engineering' => 'Systematic URL normalization and canonical enforcement service that eliminates duplicate content issues.',
  'JSON-LD & Structured Data' => 'Comprehensive schema markup implementation service that structures your content for search engines and AI systems.',
  'LLM Seeding & Citation' => 'Content optimization service that prepares your business for AI citations in ChatGPT, Google AI Overviews, and other generative engines.',
  'Technical SEO' => 'Technical SEO service that fixes crawl issues, improves site speed, and optimizes Core Web Vitals.',
  'International SEO' => 'Multi-regional SEO service that implements hreflang tags, manages international site structure, and optimizes for multiple markets.',
  'AI Visibility & Analytics' => 'Analytics and tracking service that measures how your business appears in AI-generated answers.',
  'Training' => 'Training service for marketing and SEO teams on how AI search systems work and how to optimize for generative engines.'
];
?>

<main role="main" class="container" itemscope itemtype="https://schema.org/WebPage">
<article itemscope itemtype="https://schema.org/Article" class="section">
  <div class="section__content">
    
    <!-- Services Header Content Block -->
    <header class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title" itemprop="headline"><strong>AI SEO</strong> and <strong>Generative Search Optimization</strong> Services</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" itemprop="description">Professional <strong>AI SEO</strong> and <strong>AI visibility</strong> services for businesses that need real improvements in <strong>search rankings</strong>, <strong>AI citations</strong>, and <strong>generative engine visibility</strong>.</p>
        <p>We provide hireable services that improve how <strong>search engines</strong> and <strong>AI systems</strong> find, understand, and cite your business. Services include <strong>AI visibility audits</strong>, <strong>structured data implementation</strong>, <strong>technical SEO optimization</strong>, and <strong>AI citation growth</strong>.</p>
        <p>Explore our <a href="<?= htmlspecialchars($localePrefix . '/insights/') ?>" title="AI SEO research and insights"><strong>AI SEO Research & Insights</strong></a> and learn more about our <a href="<?= htmlspecialchars($localePrefix . '/tools/') ?>" title="SEO tools and resources"><strong>SEO Tools & Resources</strong></a>.</p>
        <div class="btn-group" style="margin-top: var(--spacing-lg);">
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--primary">Book Consultation</a>
          <a href="<?= absolute_url('/en-us/implementation/') ?>" class="btn btn--secondary">Implementation Support</a>
        </div>
      </div>
    </header>

    <!-- SERVICE DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
    <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Service Categories: <strong>AI Search Optimization</strong>, <strong>Structured Data</strong>, and <strong>Technical SEO</strong></h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt id="ai-search-optimization" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>AI Search Optimization</strong></dfn>
          </dt>
          <dd itemprop="description">
            Professional service that improves how your business appears in <strong>Google AI Overviews</strong>, <strong>ChatGPT</strong>, <strong>Perplexity</strong>, and other <strong>generative search engines</strong>. We optimize <strong>content structure</strong>, <strong>entity signals</strong>, and <strong>citation readiness</strong> to increase <strong>AI visibility</strong> and recommendations. This includes <abbr title="Answer Engine Optimization">AEO</abbr> and <abbr title="Generative Engine Optimization">GEO</abbr> practices.
          </dd>
          
          <dt id="structured-data-services" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Structured Data Services</strong></dfn>
          </dt>
          <dd itemprop="description">
            Comprehensive <strong>schema markup implementation</strong> service that structures your content for <strong>search engines</strong> and <strong>AI systems</strong>. We implement <strong>JSON-LD</strong>, <strong>microdata</strong>, and <strong>structured data</strong> that improves <strong>rich results</strong>, <strong>knowledge graph inclusion</strong>, and <strong>AI citation eligibility</strong>.
          </dd>
          
          <dt id="technical-seo-services" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Technical SEO Services</strong></dfn>
          </dt>
          <dd itemprop="description">
            Technical <abbr title="Search Engine Optimization">SEO</abbr> service that fixes <strong>crawl issues</strong>, improves <strong>site speed</strong>, and optimizes <strong>Core Web Vitals</strong>. We resolve technical barriers that prevent <strong>search engines</strong> from indexing and ranking your content effectively. This includes <strong>URL normalization</strong>, <strong>canonical enforcement</strong>, and <strong>crawl budget optimization</strong>.
          </dd>
        </dl>
      </div>
    </section>

    <!-- AI SEO Services List -->
    <nav aria-label="AI SEO Services" class="content-block module" itemscope itemtype="https://schema.org/ItemList">
      <div class="content-block__body">
        
        <!-- AI Search Optimization -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="1">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>AI Search Optimization</strong> – <strong>AI Overview</strong> & <strong>Generative Search Visibility</strong> Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Professional service that improves how your business appears in <strong>Google AI Overviews</strong>, <strong>ChatGPT</strong>, <strong>Perplexity</strong>, and other <strong>generative search engines</strong>. We optimize <strong>content structure</strong>, <strong>entity signals</strong>, and <strong>citation readiness</strong> to increase <strong>AI visibility</strong> and recommendations.</p>
            <p><strong>What improves:</strong> <strong>AI citations</strong>, <strong>generative search visibility</strong>, <strong>AI Overview</strong> appearances, <strong>brand mentions</strong> in <strong>AI-generated answers</strong>.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" class="btn" title="AI search optimization service for generative engines">View AI Search Optimization Service</a>
            </div>
          </div>
        </div>

        <!-- Site Audits -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="2">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/site-audits/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Site Audits</strong> – <strong>AI</strong> & <strong>Search Visibility</strong> Diagnostic Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Comprehensive <strong>site audits</strong> that explain why <strong>visibility breaks down</strong>, not just surface-level issues. We analyze how <strong>search engines</strong> and <strong>AI systems</strong> interpret your site, identify <strong>ambiguity</strong>, and provide prioritized fixes that improve <strong>rankings</strong> and <strong>AI citations</strong>.</p>
            <p><strong>What improves:</strong> <strong>Search rankings</strong>, <strong>AI visibility</strong>, <strong>technical SEO</strong> issues, <strong>content structure</strong>, <strong>entity clarity</strong>.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/site-audits/') ?>" class="btn" title="Site audit service for AI and search visibility">View Site Audit Service</a>
            </div>
          </div>
        </div>

        <!-- Crawl Clarity Engineering -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="3">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/crawl-clarity/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Crawl Clarity Engineering</strong> – <strong>URL Normalization</strong> & <strong>Canonical Enforcement</strong> Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Systematic <strong>URL normalization</strong> and <strong>canonical enforcement</strong> service that eliminates <strong>duplicate content</strong> issues and ensures <strong>search engines</strong> crawl the correct versions of your pages. We fix <strong>crawl budget waste</strong>, <strong>canonical conflicts</strong>, and <strong>indexing problems</strong>.</p>
            <p><strong>What improves:</strong> <strong>Crawl efficiency</strong>, <strong>indexing rates</strong>, <strong>duplicate content</strong> issues, <strong>search engine</strong> understanding of <strong>page relationships</strong>.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/crawl-clarity/') ?>" class="btn" title="Crawl clarity engineering service for URL normalization">View Crawl Clarity Service</a>
            </div>
          </div>
        </div>

        <!-- JSON-LD & Structured Data -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="4">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/json-ld-strategy/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>JSON-LD</strong> & <strong>Structured Data</strong> – <strong>Schema Markup</strong> Implementation Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Comprehensive <strong>schema markup implementation</strong> service that structures your content for <strong>search engines</strong> and <strong>AI systems</strong>. We implement <strong>JSON-LD</strong>, <strong>microdata</strong>, and <strong>structured data</strong> that improves <strong>rich results</strong>, <strong>knowledge graph inclusion</strong>, and <strong>AI citation eligibility</strong>.</p>
            <p><strong>What improves:</strong> <strong>Rich results</strong>, <strong>knowledge graph</strong> inclusion, <strong>AI citation</strong> eligibility, <strong>structured data</strong> accuracy, <strong>search result</strong> appearance.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/json-ld-strategy/') ?>" class="btn" title="JSON-LD and structured data implementation service">View Structured Data Service</a>
            </div>
          </div>
        </div>

        <!-- LLM Seeding & Citation -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="5">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/llm-seeding/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>LLM Seeding</strong> & <strong>Citation</strong> – <strong>AI Citation Growth</strong> & <strong>Visibility</strong> Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Content optimization service that prepares your business for <strong>AI citations</strong> in <strong>ChatGPT</strong>, <strong>Google AI Overviews</strong>, and other <strong>generative engines</strong>. We structure content for <strong>AI extraction</strong>, improve <strong>entity clarity</strong>, and build <strong>citation-ready authority signals</strong>.</p>
            <p><strong>What improves:</strong> <strong>AI citations</strong>, <strong>brand mentions</strong> in <strong>AI answers</strong>, <strong>generative search visibility</strong>, <strong>entity recognition</strong> by <strong>AI systems</strong>.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/llm-seeding/') ?>" class="btn" title="LLM seeding and citation service for AI visibility">View LLM Seeding Service</a>
            </div>
          </div>
        </div>

        <!-- Technical SEO -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="6">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/technical-seo/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Technical SEO</strong> – <strong>Core Web Vitals</strong> & <strong>Crawl Optimization</strong> Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Technical <abbr title="Search Engine Optimization">SEO</abbr> service that fixes <strong>crawl issues</strong>, improves <strong>site speed</strong>, and optimizes <strong>Core Web Vitals</strong>. We resolve technical barriers that prevent <strong>search engines</strong> from indexing and ranking your content effectively.</p>
            <p><strong>What improves:</strong> <strong>Site speed</strong>, <strong>Core Web Vitals</strong> scores, <strong>crawl efficiency</strong>, <strong>indexing rates</strong>, <strong>technical SEO</strong> barriers.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/technical-seo/') ?>" class="btn" title="Technical SEO service for crawl optimization">View Technical SEO Service</a>
            </div>
          </div>
        </div>

        <!-- International SEO -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="7">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/international-seo/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>International SEO</strong> – <strong>Multi-Regional Search Optimization</strong> Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Multi-regional <abbr title="Search Engine Optimization">SEO</abbr> service that implements <strong>hreflang tags</strong>, manages <strong>international site structure</strong>, and optimizes for multiple markets. We ensure <strong>search engines</strong> understand your <strong>international presence</strong> and serve the correct content to the right audiences.</p>
            <p><strong>What improves:</strong> <strong>International rankings</strong>, <strong>hreflang</strong> accuracy, <strong>multi-regional visibility</strong>, <strong>local search</strong> performance.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/international-seo/') ?>" class="btn" title="International SEO service for multi-regional optimization">View International SEO Service</a>
            </div>
          </div>
        </div>

        <!-- AI Visibility & Analytics -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="8">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/services/analytics/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>AI Visibility</strong> & <strong>Analytics</strong> – <strong>AI Engine Performance Tracking</strong> Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Analytics and tracking service that measures how your business appears in <strong>AI-generated answers</strong>, tracks <strong>AI citations</strong>, and monitors <strong>generative search visibility</strong>. We provide reporting on <strong>AI Overview</strong> appearances, <strong>ChatGPT</strong> mentions, and <strong>AI citation frequency</strong>.</p>
            <p><strong>What improves:</strong> <strong>AI visibility</strong> measurement, <strong>citation tracking</strong>, <strong>performance reporting</strong>, <strong>AI search analytics</strong>.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/services/analytics/') ?>" class="btn" title="AI visibility and analytics service for performance tracking">View Analytics Service</a>
            </div>
          </div>
        </div>

        <!-- Training -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="9">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= htmlspecialchars($localePrefix . '/training/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Training</strong> – <strong>AI Search Systems</strong> Education & Implementation Service</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Training service for marketing and <abbr title="Search Engine Optimization">SEO</abbr> teams on how <strong>AI search systems</strong> work, how <strong>LLMs</strong> ingest content, and how to optimize for <strong>generative engines</strong>. We provide workshops, documentation, and implementation guidance for in-house teams and agencies.</p>
            <p><strong>What improves:</strong> <strong>Team knowledge</strong>, <strong>implementation capability</strong>, <strong>AI search optimization</strong> skills, <strong>internal execution</strong> quality.</p>
            <div class="btn-group">
              <a href="<?= htmlspecialchars($localePrefix . '/training/') ?>" class="btn" title="Training service for AI search systems">View Training Service</a>
            </div>
          </div>
        </div>

      </div>
    </nav>

    <!-- Related Resources -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" title="AI SEO services"><strong>AI SEO Services</strong></a> including <a href="<?= htmlspecialchars($localePrefix . '/services/crawl-clarity/') ?>" title="Crawl clarity engineering service"><strong>Crawl Clarity Engineering</strong></a> for <strong>technical SEO</strong> optimization.</p>
        <p>Discover our latest <a href="<?= htmlspecialchars($localePrefix . '/insights/') ?>" title="AI SEO research and insights"><strong>AI SEO Research & Insights</strong></a> including the <a href="<?= htmlspecialchars($localePrefix . '/insights/geo16-introduction/') ?>" title="GEO-16 framework for AI citation optimization"><strong>GEO-16 Framework</strong></a> and our deep dive into <a href="<?= htmlspecialchars($localePrefix . '/insights/agentic-commerce-aps/') ?>"><strong>Agentic Commerce & APS</strong></a>.</p>
        <p>Browse our <a href="<?= htmlspecialchars($localePrefix . '/tools/') ?>" title="SEO tools and resources"><strong>SEO Tools & Resources</strong></a> for <strong>technical SEO</strong> optimization.</p>
        <div class="btn-group text-center" style="margin-top: var(--spacing-md);">
          <a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" class="btn btn--primary" title="Get started with AI search optimization services">Get Started with AI SEO</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary" title="Book consultation">Book Consultation</a>
        </div>
      </div>
    </section>

  </div>
</article>
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
<section class="content-block module">
  <div class="content-block__header">
    <h2 class="content-block__title">Local <abbr title="Search Engine Optimization">SEO</abbr> Services in UK Cities</h2>
  </div>
  <div class="content-block__body">
    <p>Professional <strong>local SEO</strong> services for businesses in major UK cities. We help improve <strong>search rankings</strong>, <strong>AI citations</strong>, and <strong>local visibility</strong>.</p>
    <ul>
      <?php foreach ($ukCityLinks as $link): ?>
      <li><a href="<?= htmlspecialchars($link['url']) ?>" title="Local SEO services in <?= htmlspecialchars($link['name']) ?>"><strong>Local SEO</strong> in <?= htmlspecialchars($link['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endif; ?>

<!-- City-Specific Service Pages (GSC Indexing Fix) -->
<section class="content-block module">
  <div class="content-block__header">
    <h2 class="content-block__title">Service Locations</h2>
  </div>
  <div class="content-block__body">
    <p>Find specialized <strong>AI SEO</strong> services in your city. Our location-specific pages provide tailored insights for local markets.</p>

    <?php
    // Add links to popular city-service combinations to improve internal linking
    $popularCities = ['new-york', 'los-angeles', 'london', 'manchester', 'birmingham', 'tokyo', 'seoul', 'singapore'];
    $popularServices = ['crawl-clarity', 'ai-overviews-optimization', 'generative-seo', 'local-seo-ai'];

    echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">';

    foreach ($popularServices as $service) {
      echo '<div>';
      echo '<h3><strong>' . ucwords(str_replace('-', ' ', $service)) . '</strong></h3>';
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
</section>

<?php
// JSON-LD Schema (ENHANCED)
require_once __DIR__ . '/../../lib/helpers.php';
$domain = 'https://nrlc.ai';
$canonicalUrl = absolute_url('/services/');

// Person schema (Joel Maldonado)
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $personId,
    'name' => 'Joel Maldonado',
    'givenName' => 'Joel',
    'familyName' => 'Maldonado',
    'jobTitle' => 'Founder & AI Search Researcher',
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
    'knowsAbout' => [
      'AI Search Optimization', 'AEO', 'GEO', 'AI SEO Services',
      'Structured Data Services', 'Technical SEO Services', 'AI Citation Services',
      'LLM Seeding', 'Schema Markup', 'AI Visibility Services'
    ],
    'worksFor' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'affiliation' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'url' => $domain,
    'sameAs' => [
      'https://www.linkedin.com/company/neural-command/',
      'https://twitter.com/neuralcommand',
      'https://www.crunchbase.com/person/joel-maldonado'
    ]
  ],
  
  // WebPage schema (ENHANCED)
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "@id" => $canonicalUrl . '#webpage',
    "name" => $GLOBALS['__page_meta']['title'] ?? "AI SEO and Generative Search Optimization Services",
    "url" => $canonicalUrl,
    "description" => $GLOBALS['__page_meta']['description'] ?? "Professional AI SEO and AI visibility services for businesses that need real improvements in search rankings, AI citations, and generative engine visibility.",
    "inLanguage" => "en-US",
    "datePublished" => "2024-01-01",
    "dateModified" => date('Y-m-d'),
    "keywords" => $GLOBALS['__page_meta']['keywords'] ?? "AI SEO services, AI search optimization, generative search optimization, AI visibility services, ChatGPT optimization, Perplexity optimization, Google AI Overviews optimization",
    "about" => [
      [
        "@type" => "Thing",
        "name" => "AI Search Optimization",
        "description" => "Professional service that improves how businesses appear in Google AI Overviews, ChatGPT, Perplexity, and other generative search engines"
      ],
      [
        "@type" => "Thing",
        "name" => "Structured Data Services",
        "description" => "Comprehensive schema markup implementation service that structures content for search engines and AI systems"
      ],
      [
        "@type" => "Thing",
        "name" => "Technical SEO Services",
        "description" => "Technical SEO service that fixes crawl issues, improves site speed, and optimizes Core Web Vitals"
      ]
    ],
    "mentions" => [
      [
        "@type" => "SoftwareApplication",
        "name" => "ChatGPT",
        "description" => "AI language model by OpenAI"
      ],
      [
        "@type" => "SoftwareApplication",
        "name" => "Perplexity",
        "description" => "AI-powered search engine"
      ],
      [
        "@type" => "SoftwareApplication",
        "name" => "Google AI Overviews",
        "description" => "Google's AI-powered search overview feature"
      ]
    ],
    "author" => [
      "@type" => "Person",
      "@id" => $personId
    ],
    "publisher" => [
      "@type" => "Organization",
      "@id" => $orgId
    ],
    "isPartOf" => [
      "@type" => "WebSite",
      "@id" => $domain . '/#website',
      "name" => "NRLC.ai",
      "url" => $domain
    ],
    "speakable" => [
      "@type" => "SpeakableSpecification",
      "cssSelector" => ["h1", ".lead"]
    ]
  ],
  
  // BreadcrumbList
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
  
  // Service schema with OfferCatalog (ENHANCED)
  [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "@id" => $canonicalUrl . '#service',
    "name" => "AI SEO & AI Visibility Services",
    "description" => "Professional AI SEO and AI visibility services including site audits, structured data implementation, technical SEO optimization, and AI citation growth.",
    "provider" => [
      "@type" => "Organization",
      "@id" => $orgId,
      "name" => "Neural Command, LLC",
      "url" => $domain
    ],
    "serviceType" => "AI SEO Services",
    "areaServed" => "Worldwide",
    "hasOfferCatalog" => [
      "@type" => "OfferCatalog",
      "@id" => $canonicalUrl . '#catalog',
      "name" => "AI SEO Services Catalog",
      "itemListElement" => [
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "AI Search Optimization",
            "description" => "Professional service that improves how your business appears in Google AI Overviews, ChatGPT, Perplexity, and other generative search engines."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Site Audits",
            "description" => "Comprehensive site audits that explain why visibility breaks down, not just surface-level issues."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Crawl Clarity Engineering",
            "description" => "Systematic URL normalization and canonical enforcement service that eliminates duplicate content issues."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "JSON-LD & Structured Data",
            "description" => "Comprehensive schema markup implementation service that structures your content for search engines and AI systems."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "LLM Seeding & Citation",
            "description" => "Content optimization service that prepares your business for AI citations in ChatGPT, Google AI Overviews, and other generative engines."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Technical SEO",
            "description" => "Technical SEO service that fixes crawl issues, improves site speed, and optimizes Core Web Vitals."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "International SEO",
            "description" => "Multi-regional SEO service that implements hreflang tags, manages international site structure, and optimizes for multiple markets."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "AI Visibility & Analytics",
            "description" => "Analytics and tracking service that measures how your business appears in AI-generated answers."
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Training",
            "description" => "Training service for marketing and SEO teams on how AI search systems work and how to optimize for generative engines."
          ]
        ]
      ]
    ]
  ],
  
  // ItemList schema for service listings
  [
    "@context" => "https://schema.org",
    "@type" => "ItemList",
    "@id" => $canonicalUrl . '#service-list',
    "name" => "AI SEO Services List",
    "description" => "Complete list of AI SEO and generative search optimization services",
    "numberOfItems" => 9,
    "itemListElement" => [
      [
        "@type" => "ListItem",
        "position" => 1,
        "name" => "AI Search Optimization",
        "item" => absolute_url('/services/ai-search-optimization/')
      ],
      [
        "@type" => "ListItem",
        "position" => 2,
        "name" => "Site Audits",
        "item" => absolute_url('/services/site-audits/')
      ],
      [
        "@type" => "ListItem",
        "position" => 3,
        "name" => "Crawl Clarity Engineering",
        "item" => absolute_url('/services/crawl-clarity/')
      ],
      [
        "@type" => "ListItem",
        "position" => 4,
        "name" => "JSON-LD & Structured Data",
        "item" => absolute_url('/services/json-ld-strategy/')
      ],
      [
        "@type" => "ListItem",
        "position" => 5,
        "name" => "LLM Seeding & Citation",
        "item" => absolute_url('/services/llm-seeding/')
      ],
      [
        "@type" => "ListItem",
        "position" => 6,
        "name" => "Technical SEO",
        "item" => absolute_url('/services/technical-seo/')
      ],
      [
        "@type" => "ListItem",
        "position" => 7,
        "name" => "International SEO",
        "item" => absolute_url('/services/international-seo/')
      ],
      [
        "@type" => "ListItem",
        "position" => 8,
        "name" => "AI Visibility & Analytics",
        "item" => absolute_url('/services/analytics/')
      ],
      [
        "@type" => "ListItem",
        "position" => 9,
        "name" => "Training",
        "item" => absolute_url('/training/')
      ]
    ]
  ],
  
  // Thing schemas for key service concepts
  [
    "@context" => "https://schema.org",
    "@type" => "Thing",
    "name" => "AI Search Optimization",
    "description" => "Professional service that improves how businesses appear in Google AI Overviews, ChatGPT, Perplexity, and other generative search engines"
  ],
  [
    "@context" => "https://schema.org",
    "@type" => "Thing",
    "name" => "Structured Data Services",
    "description" => "Comprehensive schema markup implementation service that structures content for search engines and AI systems"
  ],
  [
    "@context" => "https://schema.org",
    "@type" => "Thing",
    "name" => "Technical SEO Services",
    "description" => "Technical SEO service that fixes crawl issues, improves site speed, and optimizes Core Web Vitals"
  ]
];
?>
