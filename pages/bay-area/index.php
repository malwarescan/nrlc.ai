<?php
/**
 * Bay Area hub — AI Search Optimization for the San Francisco Bay Area
 * Canonical: https://nrlc.ai/en-us/bay-area/
 */
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

$GLOBALS['__page_slug'] = 'bay-area/index';
$canonicalUrl = absolute_url('/en-us/bay-area/');

// Meta set by router; ensure canonical for all variants
if (!isset($GLOBALS['__page_meta']['canonicalPath']) || $GLOBALS['__page_meta']['canonicalPath'] !== '/en-us/bay-area/') {
  $GLOBALS['__page_meta']['canonicalPath'] = '/en-us/bay-area/';
}

$bayAreaCities = [
  ['slug' => 'san-francisco', 'name' => 'San Francisco'],
  ['slug' => 'san-jose', 'name' => 'San Jose'],
  ['slug' => 'oakland', 'name' => 'Oakland'],
  ['slug' => 'palo-alto', 'name' => 'Palo Alto'],
  ['slug' => 'mountain-view', 'name' => 'Mountain View'],
  ['slug' => 'sunnyvale', 'name' => 'Sunnyvale'],
  ['slug' => 'santa-clara', 'name' => 'Santa Clara'],
  ['slug' => 'san-mateo', 'name' => 'San Mateo'],
];

$GLOBALS['__jsonld'] = array_merge(
  base_schemas(),
  [
    [
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      '@id' => $canonicalUrl . '#webpage',
      'url' => $canonicalUrl,
      'name' => $GLOBALS['__page_meta']['title'] ?? 'AI Search Optimization San Francisco Bay Area | Neural Command',
      'description' => $GLOBALS['__page_meta']['description'] ?? 'AI Search Optimization and GEO for the San Francisco Bay Area. San Francisco, San Jose, Palo Alto, Oakland. Book a consultation.',
      'isPartOf' => ['@id' => 'https://nrlc.ai/#website'],
      'inLanguage' => 'en-US'
    ],
    ld_faq([
      ['q' => 'What is AI Search Optimization?', 'a' => 'AI Search Optimization (GEO and AEO) is the practice of optimizing content and technical signals so AI systems like ChatGPT, Perplexity, and Google AI Overviews can retrieve, evaluate, and cite your brand.'],
      ['q' => 'Do you serve the whole Bay Area?', 'a' => 'Yes. We serve San Francisco, San Jose, Oakland, the Peninsula, Silicon Valley, and the greater Bay Area—remotely and with the same GEO-16 methodology we use nationwide.'],
      ['q' => "What's the difference between GEO and AEO?", 'a' => 'GEO (Generative Engine Optimization) optimizes for how generative AI retrieves and cites content. AEO (Answer Engine Optimization) focuses on answer engines that generate direct answers. Both are part of AI Search Optimization.'],
      ['q' => 'Do you work with startups in San Francisco?', 'a' => 'Yes. We work with founders, growth leads, and marketing directors across SF and the Bay Area on AI visibility and citation-ready content.'],
      ['q' => 'How do I get started?', 'a' => 'Book a free consultation at nrlc.ai/en-us/book/. We\'ll review your current AI visibility and outline a strategy for your market.'],
      ['q' => 'Where is Neural Command based?', 'a' => 'Neural Command is headquartered in Santa Monica, CA. We serve the Bay Area and nationwide with remote implementation and strategy.']
    ])
  ]
);
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <header class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">AI Search Optimization for the San Francisco Bay Area</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Neural Command provides <strong>AI Search Optimization</strong> (GEO and AEO) for the <strong>San Francisco Bay Area</strong>—San Francisco, San Jose, Oakland, the Peninsula, and Silicon Valley. We help founders, growth leads, and marketing teams get cited in ChatGPT, Perplexity, and Google AI Overviews. Our GEO-16 framework and structured data engineering improve how AI systems retrieve and cite your brand. Whether you're in San Francisco, Palo Alto, or San Jose, we focus on unique intent and proof, not thin location pages.</p>
          <div class="btn-group" style="margin-top: var(--spacing-lg);">
            <a href="<?= htmlspecialchars(absolute_url('/en-us/book/')) ?>" class="btn btn--primary">Book a Consultation</a>
            <a href="<?= htmlspecialchars(absolute_url('/en-us/services/')) ?>" class="btn btn--secondary">View Services</a>
          </div>
        </div>
      </header>

      <section class="content-block module" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md);">
        <div class="content-block__header">
          <h2 class="content-block__title">Why Neural Command</h2>
        </div>
        <div class="content-block__body">
          <p>Neural Command has worked with B2B and SaaS teams across the Bay Area on GEO and AEO implementation. Our methodology is used to improve AI citation rates for tech and professional services. We serve San Francisco, San Jose, Oakland, and the Peninsula with the same research-backed approach we use nationwide.</p>
        </div>
      </section>

      <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Who We Help in the Bay Area</h2>
        </div>
        <div class="content-block__body">
          <p>We work with <strong>founders</strong>, <strong>growth leads</strong>, <strong>marketing directors</strong>, and <strong>web teams</strong> in San Francisco, Silicon Valley, and the Peninsula. Our clients include startups, enterprise tech, fintech, and professional services that need measurable AI visibility—not just traditional SEO. We tailor GEO-16 and structured data implementation to your market and competitive context.</p>
        </div>
      </section>

      <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Cities We Serve</h2>
        </div>
        <div class="content-block__body">
          <p>AI Search Optimization and GEO/AEO in the following Bay Area cities:</p>
          <div class="city-links" role="list">
            <?php foreach ($bayAreaCities as $c): ?>
            <a href="<?= htmlspecialchars(absolute_url("/en-us/services/ai-search-optimization/{$c['slug']}/")) ?>" class="city-link" role="listitem">AI Search Optimization <?= htmlspecialchars($c['name']) ?></a>
            <?php endforeach; ?>
          </div>
          <p style="margin-top: var(--spacing-md);"><a href="<?= htmlspecialchars(absolute_url('/en-us/services/')) ?>">View all services</a> · <a href="<?= htmlspecialchars(absolute_url('/en-us/book/')) ?>">Book a call</a></p>
        </div>
      </section>
      <style>
        .city-links { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 0.75rem; list-style: none; margin: 0; padding: 0; }
        .city-link { display: block; padding: 0.75rem 1rem; background: var(--win-face, #f0f4f8); border: 1px solid var(--win-dark, #c8d0d8); border-radius: var(--border-radius, 4px); color: var(--brand, #0066cc); text-decoration: none; font-weight: 500; transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease; }
        .city-link:hover { background: #e8eef4; border-color: var(--brand, #0066cc); color: var(--brand-ink, #003366); text-decoration: none; }
      </style>

      <section class="content-block module" id="faq">
        <div class="content-block__header">
          <h2 class="content-block__title">Frequently Asked Questions</h2>
        </div>
        <div class="content-block__body">
          <dl>
            <dt><strong>What is AI Search Optimization?</strong></dt>
            <dd>AI Search Optimization (GEO and AEO) is the practice of optimizing content and technical signals so AI systems like ChatGPT, Perplexity, and Google AI Overviews can retrieve, evaluate, and cite your brand.</dd>
            <dt><strong>Do you serve the whole Bay Area?</strong></dt>
            <dd>Yes. We serve San Francisco, San Jose, Oakland, the Peninsula, Silicon Valley, and the greater Bay Area—remotely and with the same GEO-16 methodology we use nationwide.</dd>
            <dt><strong>What's the difference between GEO and AEO?</strong></dt>
            <dd>GEO (Generative Engine Optimization) optimizes for how generative AI retrieves and cites content. AEO (Answer Engine Optimization) focuses on answer engines that generate direct answers. Both are part of AI Search Optimization.</dd>
            <dt><strong>Do you work with startups in San Francisco?</strong></dt>
            <dd>Yes. We work with founders, growth leads, and marketing directors across SF and the Bay Area on AI visibility and citation-ready content.</dd>
            <dt><strong>How do I get started?</strong></dt>
            <dd>Book a free consultation at nrlc.ai/en-us/book/. We'll review your current AI visibility and outline a strategy for your market.</dd>
            <dt><strong>Where is Neural Command based?</strong></dt>
            <dd>Neural Command is headquartered in Santa Monica, CA. We serve the Bay Area and nationwide with remote implementation and strategy.</dd>
          </dl>
        </div>
      </section>

      <section class="content-block module">
        <div class="content-block__body">
          <div class="btn-group" style="justify-content: center;">
            <a href="<?= htmlspecialchars(absolute_url('/en-us/book/')) ?>" class="btn btn--primary">Book a Consultation</a>
            <a href="<?= htmlspecialchars(absolute_url('/en-us/case-studies/')) ?>" class="btn btn--secondary">Case Studies</a>
            <a href="<?= htmlspecialchars(absolute_url('/en-us/generative-engine-optimization/')) ?>" class="btn btn--secondary">Learn GEO</a>
          </div>
        </div>
      </section>

    </div>
  </section>
</main>
