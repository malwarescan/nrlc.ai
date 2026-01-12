<?php
/**
 * Shopify AI SEO, AEO & GEO Optimization Service
 * URL: /en-us/services/shopify-ai-seo/
 * 
 * Form-less system that forces correct self-selection, controls scope, and protects sales.
 * Done entirely through page copy, page structure, and explicit gating language.
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
    'name' => 'Shopify AI SEO Services | NRLC.ai',
    'description' => 'Shopify AI SEO services optimized for Google AI Overviews, ChatGPT, Claude, and Perplexity. Two paths: AI Visibility Lite for fast exposure, or Full Infrastructure for durable authority.',
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
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Shopify AI SEO', 'item' => $canonicalUrl]
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'Shopify AI SEO Services',
    'serviceType' => 'E-commerce AI Search Optimization',
    'description' => 'Shopify SEO services optimized for AI search systems including Google AI Overviews, ChatGPT, Claude, and Perplexity. Two paths: AI Visibility Lite for fast exposure, or Full Infrastructure for durable authority.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $domain . '#organization',
      'name' => 'Neural Command LLC',
      'url' => $domain
    ],
    'url' => $canonicalUrl,
    'areaServed' => 'Worldwide'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'Can I start with Lite and upgrade later?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Yes. Lite is a proving ground. It is not a foundation.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Will Lite fix my Shopify SEO?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No. It only creates one trusted AI surface.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Can you guarantee AI placement?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No. No one can. We optimize for eligibility and trust.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Why is this so strict?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Because unclear boundaries destroy outcomes.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What is the difference between AI Visibility Lite and Infrastructure?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'AI Visibility Lite creates one canonical AI-focused page for fast exposure. Infrastructure rebuilds search visibility as a system with canonical governance, schema governance, and scalable control. You can enter AI answers without fixing everything, but you cannot stay there without structure.'
        ]
      ]
    ]
  ]
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Hero -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Shopify AI SEO Services</h1>
      </div>
      <div class="content-block__body">
        <h2>Choose the Path That Matches Your Reality</h2>
        <p class="lead">This page is intentionally explicit.</p>
        <p>If you read it carefully, you will already know which path applies to you.<br>If you do not, we will not proceed.</p>
      </div>
    </div>

    <!-- Path One: AI Visibility Lite -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Path One: AI Visibility Lite</h2>
      </div>
      <div class="content-block__body">
        <h3>This path exists for one reason</h3>
        <p>To let Shopify brands appear in AI answers without rebuilding their store.</p>
        <p>You should choose this path only if all of the following are true.</p>
        
        <h3>This Path Is For You If</h3>
        <ul>
          <li>You want AI visibility quickly</li>
          <li>You are testing AI discovery for the first time</li>
          <li>You are not willing to restructure Shopify</li>
          <li>Your catalog is small or tightly focused</li>
          <li>You accept that results are probabilistic</li>
        </ul>
        
        <h3>What We Do</h3>
        <ul>
          <li>Create one canonical AI focused page</li>
          <li>Define the product and brand in explicit language</li>
          <li>Add direct question and answer blocks</li>
          <li>Deploy minimal clean schema</li>
          <li>Align language for AI extraction</li>
          <li>Provide reinforcement guidance outside your site</li>
        </ul>
        
        <h3>What This Path Does Not Do</h3>
        <ul>
          <li>It does not fix Shopify SEO globally</li>
          <li>It does not clean up canonicals</li>
          <li>It does not touch collections or variants</li>
          <li>It does not scale across large catalogs</li>
          <li>It does not guarantee placement</li>
        </ul>
        <p><strong>If you expect more than this, this path is not for you.</strong></p>
      </div>
    </div>

    <!-- Path Two: Infrastructure -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Path Two: Shopify AI Search Infrastructure</h2>
      </div>
      <div class="content-block__body">
        <h3>This path exists to make AI visibility durable</h3>
        <p>You should choose this path only if all of the following are true.</p>
        
        <h3>This Path Is For You If</h3>
        <ul>
          <li>You want long term AI authority</li>
          <li>You have multiple products or collections</li>
          <li>You operate in a competitive market</li>
          <li>You want consistent AI citations</li>
          <li>You accept structural changes</li>
        </ul>
        
        <h3>What We Do</h3>
        <ul>
          <li>Enforce canonical governance</li>
          <li>Control index eligibility</li>
          <li>Replace app level schema with governed schema</li>
          <li>Normalize variants and offers</li>
          <li>Rewrite product pages for extraction clarity</li>
          <li>Monitor drift between ranking and AI retrieval</li>
        </ul>
        <p>This is not a quick win.<br>It is infrastructure.</p>
      </div>
    </div>

    <!-- Read This Before Contacting Us -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Read This Before Contacting Us</h2>
      </div>
      <div class="content-block__body">
        <h3>Non Negotiable Boundaries</h3>
        <p>These rules prevent misalignment.</p>
        
        <h4>AI Visibility Lite Boundaries</h4>
        <ul>
          <li>One page only</li>
          <li>One time deployment</li>
          <li>No ongoing optimization</li>
          <li>No Shopify wide changes</li>
          <li>No expansion of scope</li>
        </ul>
        <p><strong>If you ask for anything outside this list, the project stops or upgrades.</strong></p>
        
        <h4>Infrastructure Boundaries</h4>
        <ul>
          <li>Structural changes are required</li>
          <li>Timeline is measured in months</li>
          <li>Results compound, not spike</li>
          <li>Budget reflects system complexity</li>
        </ul>
        <p><strong>If you want infrastructure results without infrastructure changes, we will not proceed.</strong></p>
      </div>
    </div>

    <!-- How We Decide Without Forms -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How We Decide Without Forms</h2>
      </div>
      <div class="content-block__body">
        <p>We do not use intake forms.</p>
        <p>We decide based on:</p>
        <ul>
          <li>Your initial message</li>
          <li>The language you use</li>
          <li>What you ask for first</li>
          <li>Whether you accept constraints</li>
        </ul>
        <p><strong>If your expectations do not match the path you reference, we will redirect or decline.</strong></p>
      </div>
    </div>

    <!-- Pricing Ladder -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Pricing Ladder</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Designed to Prevent Scope Creep</strong></p>
        
        <h3>AI Visibility Lite</h3>
        <p><strong>One time engagement.</strong></p>
        <p><strong>Includes</strong></p>
        <ul>
          <li>One AI optimized page</li>
          <li>Structured Q and A</li>
          <li>Minimal schema</li>
          <li>Entity normalization</li>
          <li>External reinforcement guidance</li>
        </ul>
        <p><strong>Excludes everything else.</strong></p>
        <p><strong>Lite cannot be expanded.<br>It can only be replaced.</strong></p>
        
        <h3>Shopify AI Search Infrastructure</h3>
        <p><strong>Project based engagement.</strong></p>
        <p><strong>Includes</strong></p>
        <ul>
          <li>Canonical governance</li>
          <li>Schema governance</li>
          <li>Content restructuring</li>
          <li>Retrieval optimization</li>
          <li>Ongoing monitoring</li>
        </ul>
        <p><strong>This tier replaces Lite completely.</strong></p>
        <p><strong>There is no hybrid tier.</strong></p>
      </div>
    </div>

    <!-- FAQ -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Aligned to This Structure</strong></p>
        
        <h4>Can I start with Lite and upgrade later?</h4>
        <p>Yes. Lite is a proving ground. It is not a foundation.</p>
        
        <h4>Will Lite fix my Shopify SEO?</h4>
        <p>No. It only creates one trusted AI surface.</p>
        
        <h4>Can you guarantee AI placement?</h4>
        <p>No. No one can. We optimize for eligibility and trust.</p>
        
        <h4>Why is this so strict?</h4>
        <p>Because unclear boundaries destroy outcomes.</p>
      </div>
    </div>

    <!-- Final Statement -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Final Statement</h2>
      </div>
      <div class="content-block__body">
        <p>You can enter AI answers without fixing everything.<br>You cannot stay there without structure.</p>
        <p><strong>Choose the path that matches your reality.</strong></p>
      </div>
    </div>

    <!-- CTA -->
    <div class="content-block module">
      <div class="content-block__body">
        <div class="btn-group text-center" style="margin: 2rem 0;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Shopify AI SEO')">Discuss Shopify AI SEO</button>
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
