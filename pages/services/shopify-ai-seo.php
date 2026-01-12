<?php
/**
 * Shopify SEO + AEO + GEO Service Page
 * URL: /en-us/services/shopify-ai-seo/
 * 
 * META DIRECTIVE KERNEL: Shopify-specific, operational, scoped service page.
 * No manifesto tone. Buyer decision document.
 */

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';

$canonicalPath = $GLOBALS['__page_meta']['canonicalPath'] ?? '/en-us/services/shopify-ai-seo/';
$canonicalUrl = absolute_url($canonicalPath);
$domain = absolute_url('/');

// Build JSON-LD Schema
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'Shopify SEO for Rankings, AI Overviews, and Answer Engines | NRLC.ai',
    'description' => 'Shopify SEO services that optimize stores for Google rankings, Google AI Overviews, and answer engines. Shopify-specific optimization for products, collections, canonicals, schema, and AI extraction.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ],
    'breadcrumb' => [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => absolute_url('/services/')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Shopify SEO', 'item' => $canonicalUrl]
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'Shopify SEO for Rankings, AI Overviews, and Answer Engines',
    'serviceType' => 'E-commerce SEO and AI Search Optimization',
    'description' => 'Shopify SEO services that optimize stores for Google rankings, Google AI Overviews, and answer engines. Shopify-specific optimization for products, collections, canonicals, schema, and AI extraction.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $domain . '#organization',
      'name' => 'Neural Command LLC',
      'url' => $domain
    ],
    'url' => $canonicalUrl,
    'areaServed' => 'Worldwide'
  ]
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- SECTION 0: Above the Fold -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Shopify SEO for Rankings, AI Overviews, and Answer Engines</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">We optimize Shopify stores so they rank in Google and show up in AI summaries that cite websites.</p>
        <p>This is Shopify specific SEO, not an app install, not generic content writing.</p>
        <p>Outcomes and platforms:</p>
        <ul>
          <li>Google organic rankings</li>
          <li>Google AI Overviews</li>
          <li>Answer style results and summaries</li>
          <li>AI systems that reference sources</li>
        </ul>
      </div>
    </div>

    <!-- SECTION 1: What This Service Does -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Service Does</h2>
      </div>
      <div class="content-block__body">
        <p>We make Shopify stores understandable to search engines and AI systems by controlling index eligibility, canonicals, schema, and extraction friendly content.</p>
        <p>Deliverable classes:</p>
        <ul>
          <li>Governance</li>
          <li>Structure</li>
          <li>Schema</li>
          <li>Content shaping</li>
          <li>Monitoring</li>
        </ul>
      </div>
    </div>

    <!-- SECTION 2: Where You Will Show Up -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Where You Will Show Up</h2>
      </div>
      <div class="content-block__body">
        <p>Placements:</p>
        <ul>
          <li>Google search results</li>
          <li>Google AI Overviews</li>
          <li>Featured answers and summaries</li>
          <li>AI tools that cite sites</li>
        </ul>
        <p><strong>We do not guarantee placements. We build conditions that increase eligibility and trust.</strong></p>
      </div>
    </div>

    <!-- SECTION 3: What We Optimize in Shopify -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Optimize in Shopify</h2>
      </div>
      <div class="content-block__body">
        
        <h3>Products</h3>
        <ul>
          <li>Product template structure</li>
          <li>Title and description shaping for extraction</li>
          <li>Variant handling so products do not compete</li>
          <li>Offer clarity for price and availability</li>
        </ul>
        
        <h3>Collections</h3>
        <ul>
          <li>Index eligibility rules for collections</li>
          <li>Remove or noindex low value collection URLs</li>
          <li>Internal linking between collections and products</li>
        </ul>
        
        <h3>URLs and Canonicals</h3>
        <ul>
          <li>Fix duplicate Shopify URLs</li>
          <li>Control indexed URLs for products and collections</li>
          <li>Prevent tags and filters from diluting rankings</li>
          <li>Enforce one authoritative URL per product</li>
        </ul>
        
        <h3>Schema and Structured Data</h3>
        <ul>
          <li>Product schema</li>
          <li>Offer and availability</li>
          <li>Brand and Organization</li>
          <li>FAQPage only when it supports answering</li>
          <li>Remove or override broken app schema when needed</li>
        </ul>
        
        <h3>AEO and GEO Content Shaping</h3>
        <p>What AI extracts:</p>
        <ul>
          <li>Direct Q and A blocks</li>
          <li>Explicit definitions, use cases, constraints, comparisons</li>
          <li>Remove vague marketing language</li>
          <li>Align phrasing to summarization and citation behavior</li>
        </ul>
      </div>
    </div>

    <!-- SECTION 4: What Changes On Your Store -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What Changes On Your Store</h2>
      </div>
      <div class="content-block__body">
        <p>Concrete surfaces we touch:</p>
        <ul>
          <li>Product templates</li>
          <li>Collection templates</li>
          <li>On page content blocks</li>
          <li>Internal links</li>
          <li>Canonical tags</li>
          <li>Structured data output</li>
          <li>App conflict resolution only if included in the selected scope</li>
        </ul>
      </div>
    </div>

    <!-- SECTION 5: Who This Is For -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Who This Is For</h2>
      </div>
      <div class="content-block__body">
        <p>Ideal clients:</p>
        <ul>
          <li>Real products, real margin</li>
          <li>Competitive keywords</li>
          <li>Wants AI visibility</li>
          <li>Accepts structure changes</li>
        </ul>
        
        <p>Not for:</p>
        <ul>
          <li>Dropship churn</li>
          <li>Guarantee seekers</li>
          <li>Refusal to change structure</li>
          <li>One page shops</li>
        </ul>
      </div>
    </div>

    <!-- SECTION 6: What Results Look Like -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What Results Look Like</h2>
      </div>
      <div class="content-block__body">
        <p>Outcomes without promising:</p>
        <ul>
          <li>Improved product and collection rankings</li>
          <li>Increased qualified organic traffic</li>
          <li>Increased inclusion in AI Overviews and summaries</li>
          <li>Stronger brand query visibility</li>
        </ul>
        <p>SEO and AI visibility compound. This is not a one week tactic.</p>
      </div>
    </div>

    <!-- SECTION 7: How Engagement Works -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How Engagement Works</h2>
      </div>
      <div class="content-block__body">
        <p>Required steps:</p>
        <ol>
          <li>Store review for Shopify mechanics and index state</li>
          <li>Define scope by catalog size and competition</li>
          <li>Implement changes tied to rankings and AI visibility</li>
          <li>Validate indexing and visibility signals post deploy</li>
        </ol>
      </div>
    </div>

    <!-- SECTION 8: Scope Boundaries -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Scope Boundaries</h2>
      </div>
      <div class="content-block__body">
        <p>We do not do undefined retainers.</p>
        <p>Deliverables are scoped to the surfaces listed above.</p>
        <p>Anything outside scope requires a written scope change.</p>
        <p><strong>We do not guarantee placements. We build conditions that increase eligibility and trust.</strong></p>
      </div>
    </div>

    <!-- SECTION 9: CTA -->
    <div class="content-block module">
      <div class="content-block__body">
        <p><strong>Send your Shopify store URL and your top products or collections you want to win on.</strong></p>
        <p>You will receive a scope recommendation tied to either fast visibility work or full infrastructure work.</p>
        <div class="btn-group text-center" style="margin: 2rem 0;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Shopify SEO')">Contact Us</button>
        </div>
        <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Response within 24 hours</p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
