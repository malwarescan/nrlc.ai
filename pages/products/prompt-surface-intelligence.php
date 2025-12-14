<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for product page metadata configuration
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/prompt-surface-intelligence';
$GLOBALS['pageTitle'] = 'Prompt Surface Intelligence | NRLC.ai';
$GLOBALS['pageDesc'] = 'This service reveals the real prompts your website appears for across Google, AI Overviews, ChatGPT, Claude, and Perplexity. AI SEO product by NRLC.ai.';

// Build comprehensive schemas
$productSlug = 'prompt-surface-intelligence';
$productName = 'Prompt Surface Intelligence';
$productDescription = 'Reveals conversational prompts, AI rewrites, and proto-intents your website surfaces for across Google AI Overviews, ChatGPT, Claude, and Perplexity.';

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
  product_qapage_schema($productSlug, $productName, $productDescription),
  [
    // FAQPage schema
    [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'What is Prompt Surface Intelligence?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'It identifies the real conversational prompts, proto-prompts, AI rewrites, and intent clusters your website surfaces for across Google, ChatGPT, Claude, and Perplexity.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Why is prompt visibility important for SEO?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Search is shifting from keywords to conversational prompts. Understanding which prompts your pages satisfy is critical for AI Overview performance and cross-agent visibility.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How does NRLC identify hidden prompts?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'We analyze GSC fragments, reconstruct intent, detect proto-prompts, map LLM rewrites, and measure your site\'s footprint across multiple AI systems.'
          ]
        ]
      ]
    ],
    product_howto_schema($productSlug, $productName)
  ]
);

$GLOBALS['__jsonld'] = $jsonld;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Product Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Prompt Surface Intelligence</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">This service reveals the real prompts your website appears for across Google, AI Overviews, ChatGPT, Claude, and Perplexity.</p>
        <p>It exposes proto-prompts, AI rewrites, semantic intent clusters, and the trigger conditions that determine your brand's visibility inside AI-generated answers.</p>
      </div>
    </div>

    <!-- What This System Identifies -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This System Identifies</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>1. Proto Prompts</h3>
            <p>Early-stage, vague queries LLMs generate internally before choosing a final query: "how do I…", "best place to…", "site that lets me…". These never appear in keyword tools — but they drive AI visibility.</p>
          </div>
          <div>
            <h3>2. LLM Rewrite Variants</h3>
            <p>AI models generate dozens of rewritten prompts to test trust, intent, cost concerns, and readiness to act. We detect every rewrite your pages surface within.</p>
          </div>
          <div>
            <h3>3. AI Overview Triggers</h3>
            <p>Google's AI Overview is activated by answer shape, schema completeness, semantic coverage, and your domain's authority signals. We show exactly which conversational prompts pull your pages into AI answers.</p>
          </div>
          <div>
            <h3>4. ChatGPT / Claude / Perplexity Visibility</h3>
            <p>These agents evaluate your schema, topical completeness, internal linking, and knowledge graph structure. We reveal which prompts associate your pages with high-confidence responses.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Why This Matters -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why This Matters</h2>
      </div>
      <div class="content-block__body">
        <p>SEO is shifting from keyword ranking to prompt ranking. If you don't know which prompts your site satisfies, fails, or nearly wins, you can't influence AI search visibility. This service gives you that full map.</p>
      </div>
    </div>

    <!-- What You Receive -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What You Receive</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Complete prompt visibility report</li>
          <li>Structured Intent Cluster Map</li>
          <li>AI Overview trigger analysis</li>
          <li>ChatGPT/Claude/Perplexity ranking footprint</li>
          <li>Schema and authority recommendations</li>
          <li>Prompt-to-page optimization matrix</li>
          <li>Roadmap to expand prompt dominance</li>
        </ul>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="content-block module">
      <div class="content-block__body">
        <h2 class="content-block__title">Request a Prompt Visibility Audit</h2>
        <p>Get a full report showing the hidden prompt universe your brand appears in — and the ones where competitors outrank you.</p>
        <div class="btn-group">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Prompt Surface Intelligence Audit')">Get Started</button>
          <a href="/products/" class="btn">View All Products</a>
        </div>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="/tools/">SEO Tools & Resources</a> and view all <a href="/products/">Products</a>.</p>
        <div class="btn-group text-center">
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>
