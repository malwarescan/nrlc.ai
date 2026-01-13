<?php
// AI Search Diagnostics: Schema Stopped Working
// Symptom-first diagnostic guide

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-diagnostics/schema-stopped-working/');

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
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Schema Stopped Working', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Schema Stopped Working: Diagnostic Guide',
    'name' => 'Schema Stopped Working',
    'description' => 'Troubleshoot why structured data that previously worked is now ignored by generative engines.',
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
          <h1 class="content-block__title heading-1">Schema Stopped Working</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Troubleshoot why structured data that previously worked is now ignored by generative engines.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the System Is Doing</h2>
        </div>
        <div class="content-block__body">
          <p>Your structured data (JSON-LD, microdata, RDFa) validates correctly and may have worked in the past, but generative AI systems are now ignoring it or not using it for retrieval and citation.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why the Symptom Appears</h2>
        </div>
        <div class="content-block__body">
          <p>Generative engines may ignore schema when:</p>
          <ul>
            <li>Schema conflicts with actual content</li>
            <li>Schema is too generic or lacks specificity</li>
            <li>Schema noise dilutes confidence signals</li>
            <li>Content structure doesn't match schema claims</li>
            <li>Multiple conflicting schemas exist on the same page</li>
          </ul>
          <p>See <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/canonical-drift/') ?>">Canonical Drift</a> and schema noise patterns.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Which Failure Mode It Maps To</h2>
        </div>
        <div class="content-block__body">
          <p>This maps to:</p>
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Schema Noise</a> failure mode</li>
            <li>Signal dilution patterns</li>
            <li>Conflicting entity definitions</li>
          </ul>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Diagnostic Steps</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li><strong>Validate schema:</strong> Check for syntax errors and validation issues</li>
            <li><strong>Check for conflicts:</strong> Multiple schemas on the same page?</li>
            <li><strong>Verify content alignment:</strong> Does schema match actual content?</li>
            <li><strong>Test specificity:</strong> Is schema too generic or vague?</li>
            <li><strong>Review entity consistency:</strong> Are entities defined consistently across pages?</li>
          </ol>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Path</h2>
        </div>
        <div class="content-block__body">
          <p>To fix schema issues:</p>
          <ol>
            <li>Remove conflicting or redundant schemas</li>
            <li>Ensure schema matches content exactly</li>
            <li>Use specific, deterministic entity definitions</li>
            <li>Maintain consistency across pages</li>
            <li>See <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">GEO signals</a> for schema best practices</li>
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

