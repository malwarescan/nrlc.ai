<?php
// AI Search Diagnostics: Not Cited in AI Overviews
// Symptom-first diagnostic guide

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-diagnostics/not-cited-in-ai-overviews/');

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
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Not Cited in AI Overviews', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Not Cited in AI Overviews: Diagnostic Guide',
    'name' => 'Not Cited in AI Overviews',
    'description' => 'Identify why content is indexed but not cited in Google AI Overviews or other generative results.',
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
          <h1 class="content-block__title heading-1">Not Cited in AI Overviews</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Identify why content is indexed but not cited in Google AI Overviews or other generative results.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the System Is Doing</h2>
        </div>
        <div class="content-block__body">
          <p>Your content is indexed and may rank well, but Google AI Overviews do not cite your pages as sources. Other sites covering similar topics are being cited instead.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why the Symptom Appears</h2>
        </div>
        <div class="content-block__body">
          <p>AI Overviews require content segments that are:</p>
          <ul>
            <li>Atomic and self-contained</li>
            <li>Verbatim citable without modification</li>
            <li>Query-shaped and deterministic</li>
            <li>Confidently scorable for relevance</li>
          </ul>
          <p>If your content lacks these properties, it will not be selected for citation even if it ranks well.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Which Failure Mode It Maps To</h2>
        </div>
        <div class="content-block__body">
          <p>This maps to citation eligibility failures. See <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes Index</a> for detailed patterns.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Diagnostic Steps</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li><strong>Check segment atomicity:</strong> Can each section be quoted verbatim?</li>
            <li><strong>Verify citation readiness:</strong> Would an LLM quote this without clarification?</li>
            <li><strong>Compare to cited sources:</strong> What structure do cited pages have?</li>
            <li><strong>Test prechunking:</strong> Is content structured for independent retrieval?</li>
          </ol>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Path</h2>
        </div>
        <div class="content-block__body">
          <p>To improve citation eligibility:</p>
          <ol>
            <li>Restructure using <a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">prechunking principles</a></li>
            <li>Ensure verbatim citation readiness</li>
            <li>Make headers query-shaped</li>
            <li>Test each segment for independent meaning</li>
          </ol>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__body">
          <p>This is a failure state within <a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization</a>, where systems fail to retrieve or select a source during AI-driven search and answer generation.</p>
        </div>
      </div>

    </div>
  </section>
</main>

