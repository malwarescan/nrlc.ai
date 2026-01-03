<?php
// AI Visibility Service Landing Page
// Metadata is handled by router via $GLOBALS['__page_meta']
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/gbp_config.php';

$industries = require __DIR__ . '/../../lib/ai_visibility_industries.php';
$canonicalUrl = absolute_url('/ai-visibility/');
$domain = absolute_url('/');

// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Build JSON-LD Schema (STRICT COMPLIANCE: JSON-LD ONLY, NO MICRODATA/RDFa)
// GBP-ALIGNED: Organization schema uses ld_organization() for GBP consistency
// ENFORCEMENT: All schema MUST be JSON-LD, injected into <head>, NO microdata/RDFa, NO duplication

require_once __DIR__ . '/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';

$GLOBALS['__jsonld'] = [
  // 1. Organization (GBP-ALIGNED: Uses ld_organization() for single canonical entity)
  ld_organization(),
  
  // 2. Service (REQUIRED - PRIMARY SCHEMA)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'AI Visibility Services',
    'serviceType' => 'AI Visibility Optimization',
    'description' => 'Professional AI visibility service that improves brand presence in AI-generated answers across ChatGPT, Google AI Overviews, Perplexity, and Claude. Improves AI citations, brand mentions, and generative search visibility.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $orgId // Reference to single canonical Organization entity
    ],
    'url' => $canonicalUrl
  ],
  
  // 3. WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'AI Visibility Services',
    'description' => 'Professional AI visibility service that improves brand presence in AI-generated answers. Service includes AI engine visibility analysis, entity and citation optimization, and schema implementation for generative search engines.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ],
    'mainEntity' => [
      '@id' => $canonicalUrl . '#service'
    ]
  ],
  
  // 4. BreadcrumbList (MANDATORY)
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumbs',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $domain
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'AI Visibility Services',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // 5. FAQPage (STRICT, ZERO TOLERANCE)
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'How do I get my business mentioned in ChatGPT?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'AI systems like ChatGPT don\'t browse the web or "list" businesses the way directories do. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. To be mentioned, a business needs clear entity signals, machine-readable content, and external references that AI systems can safely cite. We optimize these signals so AI systems can confidently reference your business when answering relevant questions.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Can I advertise on ChatGPT?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No, ChatGPT does not offer advertising placements. However, businesses can optimize their online presence so ChatGPT naturally references them when answering relevant questions. This requires structuring content, entity signals, and citation sources that AI systems trust. Unlike paid advertising, this approach builds organic visibility in AI-generated answers.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'How does ChatGPT decide which businesses to recommend?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'ChatGPT and similar systems evaluate whether information about a brand can be confidently extracted and verified across multiple sources. Brands are more likely to be mentioned when their content clearly defines who they are, what they do, and how they relate to a topic, using consistent language and structure across the web. We optimize these signals to increase the likelihood of AI recommendations.'
        ]
      ]
    ]
  ]
];
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- HERO (ABOVE THE FOLD: SERVICE CLASSIFICATION) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Get Your Business Recommended by AI</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">We optimize entity signals, structured data, and citation sources so ChatGPT, Google AI Overviews, and answer engines can confidently reference your business.</p>
        <p>This is a hireable service that analyzes how AI systems describe your business and optimizes content structure, entity signals, and citation readiness to increase AI visibility, brand mentions, and recommendations in generative search engines.</p>
        <p>We provide service engagements that improve AI citations, generative search visibility, and brand inclusion in AI-generated summaries. This service focuses on how AI systems understand, describe, and trust your business.</p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Request AI Visibility Service')" title="Request AI visibility service">Request AI Visibility Service</button>
          <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" class="btn" title="View all AI SEO and AI visibility services">View All Services</a>
        </div>
      </div>
    </div>

    <!-- SERVICE SCOPE: AI Engine Visibility Analysis -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI Engine Visibility Analysis – Brand Presence Across Generative Search</h2>
      </div>
      <div class="content-block__body">
        <p>We analyze how AI systems like ChatGPT, Google AI Overviews, Perplexity, and Claude currently describe your business, your services, and your competitors. This analysis identifies where your brand appears in AI-generated answers and where competitors are being favored.</p>
        <p><strong>What improves:</strong> Brand visibility in AI answers, understanding of current AI representation, identification of visibility gaps.</p>
      </div>
    </div>

    <!-- SERVICE SCOPE: Entity & Citation Optimization -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Entity & Citation Optimization – Improving AI Answer Inclusion</h2>
      </div>
      <div class="content-block__body">
        <p>We optimize entity signals, content structure, and citation readiness so AI systems can confidently extract and reference your business. This includes structuring content for AI extraction, improving entity clarity, and building citation-ready authority signals.</p>
        <p><strong>What improves:</strong> AI citations, brand mentions in AI answers, entity recognition by AI systems, citation eligibility.</p>
      </div>
    </div>

    <!-- SERVICE SCOPE: Schema & Structured Data -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Schema & Structured Data – Machine-Readable Brand Signals</h2>
      </div>
      <div class="content-block__body">
        <p>We implement JSON-LD, microdata, and structured data that structures your content for search engines and AI systems. This improves rich results, knowledge graph inclusion, and AI citation eligibility by making brand information machine-readable and verifiable.</p>
        <p><strong>What improves:</strong> Rich results, knowledge graph inclusion, AI citation eligibility, structured data accuracy, machine-readable brand signals.</p>
      </div>
    </div>

    <!-- SERVICE SCOPE: AI Trust Signal Development -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI Trust Signal Development – Building Authority for Generative Engines</h2>
      </div>
      <div class="content-block__body">
        <p>We develop and align AI Trust Signals including clear service definitions, consistent explanations, structured machine-readable signals, and repeated authority patterns across the web. This ensures AI systems understand and trust your business expertise.</p>
        <p><strong>What improves:</strong> AI trust scoring, authority recognition, business understanding by AI systems, preference in AI recommendations.</p>
      </div>
    </div>

    <!-- SERVICE SCOPE: Content Restructuring for AI Extraction -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Content Restructuring for AI Extraction – Optimizing for Generative Search</h2>
      </div>
      <div class="content-block__body">
        <p>We restructure website content and digital signals so AI assistants understand exactly what you do, trust your expertise, reference your business accurately, and prefer you when explaining options. This work focuses on making your business unambiguous to AI systems.</p>
        <p><strong>What improves:</strong> AI comprehension, content extractability, accurate business representation, preference in AI-generated summaries.</p>
      </div>
    </div>

    <!-- SERVICE DELIVERABLES -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Service Deliverables</h2>
      </div>
      <div class="content-block__body">
        <p>When you hire this service, you receive:</p>
        <ul>
          <li>Analysis of how AI systems currently describe your business</li>
          <li>Identification of where competitors are being favored in AI answers</li>
          <li>Assessment of missing or unclear AI Trust Signals</li>
          <li>Prioritized implementation plan to improve AI visibility</li>
          <li>Content restructuring and entity optimization work</li>
          <li>Schema and structured data implementation</li>
          <li>Ongoing monitoring and optimization recommendations</li>
        </ul>
        <p><strong>This is a service engagement, not a one-time audit.</strong> We provide ongoing work to improve and maintain AI visibility over time.</p>
      </div>
    </div>

    <!-- WHO THIS SERVICE IS FOR -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Who This Service Is For</h2>
      </div>
      <div class="content-block__body">
        <p>This service is designed for businesses in high-trust industries where customers research extensively before making decisions. This includes:</p>
        <ul>
          <li>Businesses where AI assistants answer customer questions directly</li>
          <li>Companies that need accurate representation in AI-generated summaries</li>
          <li>Organizations competing for AI citations and brand mentions</li>
          <li>Businesses that want to improve visibility in generative search engines</li>
        </ul>
        <p>If your customers ask AI questions before visiting websites, this service improves how AI represents your business in those answers.</p>
      </div>
    </div>

    <!-- INDUSTRY-SPECIFIC PAGES -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI Visibility by Industry</h2>
      </div>
      <div class="content-block__body">
        <p>We provide specialized AI visibility services for high-trust industries where AI recommendations matter most. See how we optimize AI visibility for specific industries:</p>
        <p><a href="<?= htmlspecialchars($localePrefix . '/ai-visibility/auto-repair/') ?>" title="AI visibility optimization for auto repair businesses">AI visibility optimization for auto repair businesses</a></p>
        <ul style="columns: 2; column-gap: 2rem; list-style: none; padding: 0;">
          <?php foreach ($industries as $slug => $industry): ?>
          <li style="margin-bottom: 0.5rem;">
            <a href="<?= htmlspecialchars($localePrefix . '/ai-visibility/' . $slug . '/') ?>" title="AI Visibility for <?= htmlspecialchars($industry['name']) ?>">
              <?= htmlspecialchars($industry['name']) ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <p style="margin-top: 1rem;">Each industry page includes industry-specific AI prompts, trust signals, and optimization strategies tailored to how customers in that industry research and make decisions.</p>
      </div>
    </div>

    <!-- RELATED SERVICES -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Services</h2>
      </div>
      <div class="content-block__body">
        <p>This AI visibility service works alongside our other <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" title="AI SEO and AI visibility services">AI SEO & AI Visibility services</a>:</p>
        <ul>
          <li><a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" title="AI search optimization service">AI Search Optimization</a> – AI Overview & Generative Search Visibility Service</li>
          <li><a href="<?= htmlspecialchars($localePrefix . '/services/site-audits/') ?>" title="Site audit service for AI and search visibility">Site Audits</a> – AI & Search Visibility Diagnostic Service</li>
          <li><a href="<?= htmlspecialchars($localePrefix . '/services/llm-seeding/') ?>" title="LLM seeding and citation service">LLM Seeding & Citation</a> – AI Citation Growth & Visibility Service</li>
        </ul>
        <p>Explore our comprehensive <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" title="AI SEO and AI visibility services">AI SEO & AI Visibility services</a> for complete search and generative engine optimization.</p>
      </div>
    </div>

    <!-- FAQ SECTION (STRICT: Must match FAQPage schema verbatim) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt><strong>How do I get my business mentioned in ChatGPT?</strong></dt>
          <dd>AI systems like ChatGPT don't browse the web or "list" businesses the way directories do. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. To be mentioned, a business needs clear entity signals, machine-readable content, and external references that AI systems can safely cite. We optimize these signals so AI systems can confidently reference your business when answering relevant questions.</dd>
          
          <dt><strong>Can I advertise on ChatGPT?</strong></dt>
          <dd>No, ChatGPT does not offer advertising placements. However, businesses can optimize their online presence so ChatGPT naturally references them when answering relevant questions. This requires structuring content, entity signals, and citation sources that AI systems trust. Unlike paid advertising, this approach builds organic visibility in AI-generated answers.</dd>
          
          <dt><strong>How does ChatGPT decide which businesses to recommend?</strong></dt>
          <dd>ChatGPT and similar systems evaluate whether information about a brand can be confidently extracted and verified across multiple sources. Brands are more likely to be mentioned when their content clearly defines who they are, what they do, and how they relate to a topic, using consistent language and structure across the web. We optimize these signals to increase the likelihood of AI recommendations.</dd>
        </dl>
      </div>
    </div>

  </div>
</section>
</main>
