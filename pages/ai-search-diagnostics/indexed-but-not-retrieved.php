<?php
// AI Search Diagnostics: Indexed But Not Retrieved
// Symptom-first diagnostic guide

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-diagnostics/indexed-but-not-retrieved/');

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => ['@type' => 'ImageObject', '@id' => absolute_url('/') . '#logo', 'url' => absolute_url('/logo.png')],
        'sameAs' => ['https://www.linkedin.com/company/neural-command/']
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Search Diagnostics', 'item' => absolute_url('/en-us/ai-search-diagnostics/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Indexed But Not Retrieved', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Indexed But Not Retrieved: Diagnostic Guide',
    'name' => 'Indexed But Not Retrieved',
    'description' => 'Diagnose why pages are indexed by search engines but not retrieved by generative AI systems.',
    'url' => $canonicalUrl,
    'author' => ['@type' => 'Organization', '@id' => absolute_url('/') . '#organization', 'name' => 'Neural Command LLC'],
    'publisher' => ['@type' => 'Organization', '@id' => absolute_url('/') . '#organization', 'name' => 'Neural Command LLC'],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d')
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <p><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">← Back to AI Search Diagnostics</a></p>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Indexed But Not Retrieved</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Diagnose why pages are indexed by search engines but not retrieved by generative AI systems.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the System Is Doing</h2>
        </div>
        <div class="content-block__body">
          <p>Your pages appear in Google Search Console as indexed, but generative AI systems (ChatGPT, Perplexity, AI Overviews) do not retrieve them when answering relevant queries.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why the Symptom Appears</h2>
        </div>
        <div class="content-block__body">
          <p>Indexing and retrieval are separate processes. A page can be indexed (crawled and stored) but fail retrieval because:</p>
          <ul>
            <li>Content segments lack atomic structure</li>
            <li>Segments cannot be scored for relevance</li>
            <li>Content is ambiguous or context-dependent</li>
            <li>Segments exceed optimal length for retrieval</li>
            <li>Headers do not match query patterns</li>
          </ul>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Which Failure Mode It Maps To</h2>
        </div>
        <div class="content-block__body">
          <p>This maps to retrieval failure patterns. See <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes Index</a> for detailed mechanics.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Diagnostic Steps</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li><strong>Verify indexing status:</strong> Confirm pages are indexed in Search Console</li>
            <li><strong>Test retrieval:</strong> Query AI systems with your target keywords</li>
            <li><strong>Check segment structure:</strong> Are sections atomic and self-contained?</li>
            <li><strong>Review confidence signals:</strong> Does content provide clear, deterministic answers?</li>
          </ol>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Path</h2>
        </div>
        <div class="content-block__body">
          <p>To enable retrieval:</p>
          <ol>
            <li>Restructure content for atomic retrieval</li>
            <li>Implement prechunking framework</li>
            <li>Ensure segments are independently scorable</li>
            <li>See <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">GEO fundamentals</a> for mechanics</li>
          </ol>
        </div>
      </div>

    </div>
  </section>
</main>

