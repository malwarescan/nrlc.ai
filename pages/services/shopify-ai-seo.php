<?php
/**
 * Shopify AI SEO, AEO & GEO Optimization Service
 * URL: /en-us/services/shopify-ai-seo/
 * 
 * Positioned as the authority on Shopify AI SEO, AEO, GEO, and LLM optimization.
 * Structured for machines first, buyers second.
 * Explains two paths: AI Visibility Lite vs Full Infrastructure.
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
    'name' => 'Shopify AI SEO, AEO & GEO Optimization | NRLC.ai',
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
    'name' => 'Shopify AI SEO, AEO & GEO Optimization',
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
        'name' => 'What is the difference between AI Visibility Lite and Full Infrastructure?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'AI Visibility Lite creates one canonical AI-focused page for fast exposure in AI answers. Full Infrastructure rebuilds search visibility as a system with canonical governance, schema governance, and scalable control. You can appear in AI answers without fixing everything, but you cannot stay there without structure.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Which path should I choose for my Shopify store?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Choose AI Visibility Lite if you want fast exposure, have a small catalog, or want proof before investing further. Choose Full Infrastructure if you want durable authority, have a large catalog, compete in saturated markets, or need scalable control.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Does AI Visibility Lite guarantee permanent AI placement?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No. AI Visibility Lite is about entry, not dominance. It creates a single authoritative surface for fast exposure but does not fix Shopify canonical sprawl or scale across large catalogs. Full Infrastructure provides durable authority through structural control.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Can I upgrade from AI Visibility Lite to Full Infrastructure?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Yes. AI Visibility Lite serves as an entry point and proof layer. Brands that see AI citations working and want to scale, have multiple products or categories, or need long-term positioning can upgrade to Full Infrastructure.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Why is Shopify SEO broken for AI search systems?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Shopify was designed for traditional ranking, not AI extraction. It creates duplicate URLs, canonical conflicts, schema pollution from apps, and human-only content that AI systems cannot safely summarize or cite.'
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
        <h1 class="content-block__title">Shopify AI SEO, AEO, and GEO</h1>
      </div>
      <div class="content-block__body">
        <h2>Two Paths to AI Visibility</h2>
        <p class="lead">Not every Shopify brand wants the same outcome.</p>
        <p>Some brands want to appear in AI answers quickly.<br>Others want long term control over how search engines and AI systems understand their store.</p>
        <p>These are different goals.<br>They require different systems.</p>
        <p><strong>We offer both.</strong></p>
      </div>
    </div>

    <!-- Path One: AI Visibility Lite -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Path One: AI Visibility Lite</h2>
      </div>
      <div class="content-block__body">
        <p class="lead"><strong>For Shopify brands that want to appear in AI answers without rebuilding their store</strong></p>
        <p>AI Visibility Lite is designed for brands that want exposure inside:</p>
        <ul>
          <li>Google AI Overviews</li>
          <li>ChatGPT responses</li>
          <li>Perplexity summaries</li>
          <li>"Best product for" style queries</li>
        </ul>
        <p>This path does not restructure your Shopify store.<br>It creates a single authoritative surface that AI systems can safely extract from.</p>
        
        <h3>What We Build</h3>
        <ul>
          <li>One canonical AI focused page</li>
          <li>Clear question and answer blocks</li>
          <li>Explicit product definitions</li>
          <li>Lightweight schema only where needed</li>
          <li>Clean entity identity for brand and product</li>
          <li>External reinforcement so AI systems see consistency</li>
        </ul>
        
        <h3>What This Is For</h3>
        <ul>
          <li>Brands testing AI discovery</li>
          <li>Brands that want proof before investing further</li>
          <li>Brands with small catalogs</li>
          <li>Brands that want speed over completeness</li>
        </ul>
        
        <h3>What This Does Not Do</h3>
        <ul>
          <li>It does not fix Shopify canonical sprawl</li>
          <li>It does not restructure collections or variants</li>
          <li>It does not scale across large catalogs</li>
          <li>It does not guarantee permanent AI placement</li>
        </ul>
        <p>This path is about entry, not dominance.</p>
      </div>
    </div>

    <!-- Path Two: Full Infrastructure -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Path Two: Shopify AI Search Infrastructure</h2>
      </div>
      <div class="content-block__body">
        <p class="lead"><strong>For Shopify brands that want durable AI authority</strong></p>
        <p>This path treats search visibility as a system, not a tactic.</p>
        <p>It is built for brands that want:</p>
        <ul>
          <li>Stable AI citations</li>
          <li>Scalable organic growth</li>
          <li>Control over how products are interpreted</li>
          <li>Reduced ambiguity across AI systems</li>
        </ul>
        
        <h3>What We Build</h3>
        <ul>
          <li>Canonical governance across Shopify URLs</li>
          <li>Controlled index eligibility</li>
          <li>Schema governance that replaces app conflicts</li>
          <li>Product pages rewritten for extraction clarity</li>
          <li>Variant and offer normalization</li>
          <li>Monitoring for drift between ranking and AI retrieval</li>
        </ul>
        <p>This path is structural.<br>It compounds over time.</p>
      </div>
    </div>

    <!-- Decision Table -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Decision Table</h2>
      </div>
      <div class="content-block__body">
        <table style="width: 100%; border-collapse: collapse; margin: 1.5rem 0;">
          <thead>
            <tr style="border-bottom: 2px solid var(--color-brand, #12355e);">
              <th style="text-align: left; padding: 0.75rem; font-weight: 600;">Situation</th>
              <th style="text-align: center; padding: 0.75rem; font-weight: 600;">AI Visibility Lite</th>
              <th style="text-align: center; padding: 0.75rem; font-weight: 600;">Full Infrastructure</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="padding: 0.75rem;">Wants fast AI exposure</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
            </tr>
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="padding: 0.75rem;">Wants minimal Shopify changes</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
              <td style="text-align: center; padding: 0.75rem;">No</td>
            </tr>
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="padding: 0.75rem;">Large product catalog</td>
              <td style="text-align: center; padding: 0.75rem;">No</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
            </tr>
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="padding: 0.75rem;">Competitive market</td>
              <td style="text-align: center; padding: 0.75rem;">Maybe</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
            </tr>
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="padding: 0.75rem;">Long term AI authority</td>
              <td style="text-align: center; padding: 0.75rem;">No</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
            </tr>
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="padding: 0.75rem;">Budget sensitive</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
              <td style="text-align: center; padding: 0.75rem;">No</td>
            </tr>
            <tr>
              <td style="padding: 0.75rem;">Shopify Plus scale</td>
              <td style="text-align: center; padding: 0.75rem;">No</td>
              <td style="text-align: center; padding: 0.75rem;">Yes</td>
            </tr>
          </tbody>
        </table>
        <p>If the answer is unclear, start with Lite and upgrade only if signals justify it.</p>
      </div>
    </div>

    <!-- Scope Boundaries -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Scope Boundaries</h2>
      </div>
      <div class="content-block__body">
        <p>These boundaries are intentional.</p>
        
        <h3>AI Visibility Lite Includes</h3>
        <ul>
          <li>One canonical AI page</li>
          <li>Defined question and answer structure</li>
          <li>Limited schema deployment</li>
          <li>Entity normalization</li>
          <li>Guidance for external reinforcement</li>
        </ul>
        
        <h3>AI Visibility Lite Does Not Include</h3>
        <ul>
          <li>Store wide SEO</li>
          <li>Canonical cleanup across Shopify</li>
          <li>Variant or collection restructuring</li>
          <li>App level conflict resolution</li>
          <li>Ongoing optimization</li>
          <li>Guaranteed AI placement</li>
        </ul>
        
        <h3>Full Infrastructure Includes</h3>
        <ul>
          <li>Canonical governance</li>
          <li>Schema governance</li>
          <li>Content restructuring</li>
          <li>Retrieval optimization</li>
          <li>Ongoing monitoring</li>
        </ul>
        
        <p><strong>Anything outside the selected path requires a scope change.</strong></p>
      </div>
    </div>

    <!-- The Reality -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Reality</h2>
      </div>
      <div class="content-block__body">
        <p>You can appear in AI answers without fixing everything.<br>You cannot stay there without structure.</p>
        <p>That is the difference between the two paths.</p>
      </div>
    </div>

    <!-- How to Start -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How to Start</h2>
      </div>
      <div class="content-block__body">
        <p>Choose AI Visibility Lite if you want speed and proof.<br>Choose full infrastructure if you want durable authority.</p>
        <p>Both are valid.<br>Only one is permanent.</p>
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
