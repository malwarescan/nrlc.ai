<?php
/**
 * Shopify AI SEO, AEO & GEO Optimization Service
 * URL: /en-us/services/shopify-ai-seo/
 * 
 * Positioned as the authority on Shopify AI SEO, AEO, GEO, and LLM optimization.
 * Structured for machines first, buyers second.
 * Explains why Shopify breaks visibility by default and how the system fixes it.
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
    'description' => 'Shopify AI SEO services optimized for Google AI Overviews, ChatGPT, Claude, and Perplexity. Fix canonical failures, schema conflicts, and retrieval shape issues that prevent Shopify stores from being cited by AI systems.',
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
    'description' => 'Shopify SEO services optimized for AI search systems including Google AI Overviews, ChatGPT, Claude, and Perplexity. Fix canonical failures, schema conflicts, and content structure issues that prevent Shopify stores from being cited by AI systems.',
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
        'name' => 'Why is Shopify SEO broken for AI search systems?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Shopify was designed for traditional ranking, not AI extraction. It creates duplicate URLs, canonical conflicts, schema pollution from apps, and human-only content that AI systems cannot safely summarize or cite.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What is Shopify AEO (Answer Engine Optimization)?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'AEO shapes Shopify content so Google and LLMs can answer questions directly from your store. This requires restructuring product pages into extractable fact blocks optimized for AI grounding budgets.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What is Shopify GEO (Generative Engine Optimization)?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'GEO engineers Shopify data so AI systems confidently summarize and reference your brand. This requires clear entity identity, stable canonicals, explicit relationships, and consistent facts across the site.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'How does Shopify AI SEO differ from traditional SEO?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Traditional SEO optimizes for blue links. Shopify AI SEO optimizes for AI extraction, grounding, summarization, and citation. This requires canonical governance, schema conflict resolution, and content restructured for machine interpretation.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Can Shopify apps fix AI SEO issues?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No. Apps add code but cannot enforce canonical logic at scale, control AI grounding behavior, resolve schema conflicts cleanly, or shape extraction-friendly content. This requires search engineering, not plugins.'
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
        <h1 class="content-block__title">Shopify AI SEO, AEO & GEO Optimization</h1>
      </div>
      <div class="content-block__body">
        <p class="lead"><strong>Built for Google, AI Overviews, and LLM Answer Engines</strong></p>
        <p class="lead">Shopify stores do not fail because of bad products.<br>They fail because Shopify was never designed for AI retrieval, answer engines, or generative search systems.</p>
        <p>Google AI Overviews, ChatGPT, Claude, Perplexity, and other LLMs do not "rank pages."<br>They extract, ground, summarize, and cite structured, trusted, and constraint-clean data.</p>
        <p><strong>Shopify breaks that pipeline by default.</strong></p>
        <p><strong>We fix it.</strong></p>
      </div>
    </div>

    <!-- Why Shopify SEO Is Fundamentally Broken -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Shopify SEO Is Fundamentally Broken</h2>
      </div>
      <div class="content-block__body">
        <p>Most Shopify SEO agencies optimize for blue links.<br>AI systems do not work that way anymore.</p>
        <p>Shopify introduces systemic visibility failures:</p>
        <ul>
          <li>Duplicate URLs from collections, tags, filters, and variants</li>
          <li>Canonical dilution across /products, /collections, and query strings</li>
          <li>Schema conflicts caused by apps injecting partial or invalid JSON-LD</li>
          <li>Product pages written for humans, not extraction systems</li>
          <li>No control over grounding priority for AI retrieval</li>
          <li>No answer-shaped content for zero-click environments</li>
        </ul>
        <p><strong>Result:</strong><br>Your store may rank, but AI systems do not trust it enough to cite it.</p>
        <p><strong>Ranking without citation is invisible revenue.</strong></p>
      </div>
    </div>

    <!-- Two Paths to Shopify AI Visibility -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Two Paths to Shopify AI Visibility</h2>
      </div>
      <div class="content-block__body">
        <p>There are two very different Shopify buyer intents:</p>
        
        <h3>1. Infrastructure Buyers</h3>
        <p>Want full canonical control, schema governance, and long-term AI trust. Accept complexity and cost for defensible, scalable systems.</p>
        
        <h3>2. Visibility Buyers</h3>
        <p>Do not care about doctrine. Do not want a rebuild. Just want to appear in Google AI Overviews, "Best X for Y" answers, ChatGPT recommendations, and Perplexity summaries.</p>
        
        <p><strong>The truth:</strong> You can get into AI answers without fixing everything. But if you want to stay there, you need structure.</p>
      </div>
    </div>

    <!-- What "Shopify AI SEO" Actually Means -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Shopify AI SEO (Full Infrastructure)</h2>
      </div>
      <div class="content-block__body">
        <p>We optimize Shopify stores across four simultaneous search layers:</p>
        <ol>
          <li><strong>Traditional SEO (Crawl + Index Control)</strong><br>We enforce deterministic crawl paths, canonical governance, and index eligibility.</li>
          <li><strong>AEO (Answer Engine Optimization)</strong><br>We shape content so Google and LLMs can answer questions directly from your site.</li>
          <li><strong>GEO (Generative Engine Optimization)</strong><br>We engineer your data so AI systems confidently summarize and reference your brand.</li>
          <li><strong>LLM Retrieval Optimization</strong><br>We optimize for how models extract facts, not how humans read paragraphs.</li>
        </ol>
        <p>This is search infrastructure, not content tweaks.</p>
        <p><strong>Who this is for:</strong> Established stores that want reliable, scalable, defensible AI visibility built to last.</p>
      </div>
    </div>

    <!-- Shopify AI Visibility (Lite) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Shopify AI Visibility (Lite)</h2>
      </div>
      <div class="content-block__body">
        <p>If your goal is "I don't need perfection. I just want AI to notice me," the system is simpler.</p>
        
        <p>AI systems do not require perfect canonicals, full schema governance, or re-architected collections. They require:</p>
        <ol>
          <li>A single, clean, authoritative surface</li>
          <li>Clear entity identity</li>
          <li>Extractable answers</li>
          <li>Low contradiction</li>
          <li>External reinforcement</li>
        </ol>
        
        <h3>Minimal Shopify AEO / GEO Stack (Visibility Mode)</h3>
        
        <h4>1. One AI-Optimized Page (Not the Whole Store)</h4>
        <p>You do not optimize the entire Shopify site. You create one canonical "AI landing page," one "Best use case" page, or one "Why our product" explainer. This page is short, explicit, fact-dense, and designed to be summarized. AI prefers one clear surface over many noisy ones.</p>
        
        <h4>2. Explicit Question-Answer Blocks (AEO Core)</h4>
        <p>You include 5–10 direct questions, each with 2–3 sentence answers, no marketing fluff:</p>
        <ul>
          <li>What is [product]?</li>
          <li>Who is it for?</li>
          <li>When should you not use it?</li>
          <li>How is it different from alternatives?</li>
          <li>Why do people choose it?</li>
        </ul>
        <p>This is what AI extracts.</p>
        
        <h4>3. Lightweight, Clean Schema (No Governance Layer)</h4>
        <p>You only deploy Product, FAQPage, and Organization. Rules: one Product, one FAQPage, no app conflicts, no reviews if they are weak. This alone puts you ahead of 90% of Shopify stores.</p>
        
        <h4>4. External AI Reinforcement (Critical)</h4>
        <p>AI does not trust self-assertion alone. You reinforce the same claims on Medium, Reddit (non-promotional), Quora, blog posts on other domains, and mentions in listicles or comparisons. Same facts, same phrasing, same entity name. This collapses AI uncertainty.</p>
        
        <h4>5. Accept the Limits</h4>
        <p>Visibility mode will not fix long-term crawl inefficiency, solve canonical debt, or scale to thousands of SKUs cleanly. But it will get brands into AI answers, trigger Google AI Overview inclusion, surface products in ChatGPT summaries, and do it fast.</p>
        
        <p><strong>Who this is for:</strong> Brands that want proof, early visibility, and a foothold in AI answers without a full store rebuild. This is an entry point and proof layer that can funnel into the full system later.</p>
      </div>
    </div>

    <!-- Our Shopify AI SEO Architecture -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Our Shopify AI SEO Architecture</h2>
      </div>
      <div class="content-block__body">
        
        <h3>Canonical & URL Governance</h3>
        <p>We collapse Shopify's URL sprawl into a single authoritative graph.</p>
        <ul>
          <li>One canonical per product, variant, and collection</li>
          <li>Controlled handling of tags, filters, and pagination</li>
          <li>Index gating based on intent, demand, and retrievability</li>
        </ul>

        <h3>Shopify-Specific Schema Governance</h3>
        <p>We do not "add schema."<br>We govern it.</p>
        <ul>
          <li>Product, Offer, AggregateRating, Review, FAQPage, Breadcrumb</li>
          <li>Variant-safe Offer modeling</li>
          <li>Review schema without spam signals</li>
          <li>No app-conflict JSON-LD collisions</li>
          <li>Machine-first field ordering for extraction reliability</li>
        </ul>

        <h3>AI-Readable Product Pages</h3>
        <p>We restructure product pages into extractable fact blocks:</p>
        <ul>
          <li>What it is</li>
          <li>Who it's for</li>
          <li>Key differentiators</li>
          <li>Trust signals</li>
          <li>Usage constraints</li>
          <li>Comparisons AI can safely summarize</li>
        </ul>
        <p>This is how AI decides what to cite.</p>
      </div>
    </div>

    <!-- Shopify SEO for Google AI Overviews -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Shopify SEO for Google AI Overviews</h2>
      </div>
      <div class="content-block__body">
        <p>Google AI Overviews operate under grounding budgets and confidence thresholds.</p>
        <p>We design Shopify pages to:</p>
        <ul>
          <li>Be short enough to be fully grounded</li>
          <li>Be structured enough to be trusted</li>
          <li>Be authoritative enough to be selected</li>
        </ul>
        <p>This is how products appear inside AI answers, not under them.</p>
      </div>
    </div>

    <!-- Shopify GEO: Optimizing for LLMs -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Shopify GEO: Optimizing for LLMs Like ChatGPT & Claude</h2>
      </div>
      <div class="content-block__body">
        <p>LLMs prefer:</p>
        <ul>
          <li>Clear entity identity</li>
          <li>Stable canonical URLs</li>
          <li>Explicit relationships</li>
          <li>Consistent facts across the site</li>
          <li>Low ambiguity</li>
        </ul>
        <p>We align your Shopify store with how LLMs actually reason.</p>
        <p>That means when someone asks:</p>
        <p><em>"What's the best [product] for [use case]?"</em></p>
        <p><strong>Your store becomes the answer.</strong></p>
      </div>
    </div>

    <!-- What We Do That Shopify Apps Cannot -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Do That Shopify Apps Cannot</h2>
      </div>
      <div class="content-block__body">
        <p>Shopify apps add code.<br>We redesign information architecture.</p>
        <p>Apps cannot:</p>
        <ul>
          <li>Enforce canonical logic at scale</li>
          <li>Control AI grounding behavior</li>
          <li>Resolve schema conflicts cleanly</li>
          <li>Shape extraction-friendly content</li>
          <li>Optimize for LLM trust thresholds</li>
        </ul>
        <p>This requires search engineering, not plugins.</p>
      </div>
    </div>

    <!-- Which Path Should You Choose? -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Which Path Should You Choose?</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Choose Full Infrastructure if:</strong></p>
        <ul>
          <li>You want reliable, scalable, defensible AI visibility</li>
          <li>You have hundreds or thousands of products</li>
          <li>You're building for the next decade of search</li>
          <li>You already rank but don't convert visibility into revenue</li>
          <li>You compete in saturated markets</li>
          <li>You want long-term AI trust and authority</li>
        </ul>
        
        <p><strong>Choose Visibility (Lite) if:</strong></p>
        <ul>
          <li>You want proof that AI can cite your brand</li>
          <li>You need early visibility fast</li>
          <li>You have a focused product or category</li>
          <li>You don't need a full store rebuild</li>
          <li>You want a foothold before committing to infrastructure</li>
        </ul>
        
        <p><strong>When to upgrade from Lite to Full Infrastructure:</strong></p>
        <ul>
          <li>You see AI citations working and want to scale</li>
          <li>You have multiple products or categories</li>
          <li>You're ready to fix canonical debt and schema conflicts</li>
          <li>You want defensible, long-term positioning</li>
        </ul>
      </div>
    </div>

    <!-- The Outcome -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Outcome</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Higher quality organic traffic</li>
          <li>AI citations that compound brand authority</li>
          <li>Zero-click visibility that still drives revenue</li>
          <li>Shopify pages that machines trust</li>
          <li>A store built for the next decade of search</li>
        </ul>
      </div>
    </div>

    <!-- Final Positioning -->
    <div class="content-block module">
      <div class="content-block__body">
        <div class="callout-system-truth" style="margin: 1.5rem 0; padding: 1.5rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
          <p><strong>Shopify did not break.</strong></p>
          <p><strong>Search evolved past it.</strong></p>
          <p><strong>We build the missing layer.</strong></p>
        </div>
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
