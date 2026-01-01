<?php
// Glossary Entry: Extractability
// Short, explicit, definition-only page

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/glossary/extractability/');

$GLOBALS['__jsonld'] = [
  // About / Entity Graph
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => absolute_url('/') . '#logo',
          'url' => absolute_url('/logo.png')
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ]
    ]
  ],
  // BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Glossary',
        'item' => absolute_url('/en-us/glossary/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Extractability',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // DefinedTerm
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTerm',
    '@id' => $canonicalUrl . '#term',
    'name' => 'Extractability',
    'description' => 'The degree to which content can be isolated and reused by a generative system without semantic loss or ambiguity. In AI search, extractability is a prerequisite for retrieval and citation because systems operate on reusable segments, not pages.',
    'url' => $canonicalUrl,
    'inDefinedTermSet' => [
      '@type' => 'DefinedTermSet',
      'name' => 'AI Search Glossary',
      'url' => absolute_url('/en-us/glossary/')
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Back Link -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/en-us/glossary/') ?>">← Back to Glossary</a></p>
        </div>
      </div>

      <!-- Definition -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Extractability</h1>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Extractability is the degree to which content can be isolated and reused by a generative system without semantic loss or ambiguity. In AI search, extractability is a prerequisite for retrieval and citation because systems operate on reusable segments, not pages.</p>
          </div>
          
          <p>Full reference: <a href="<?= absolute_url('/en-us/generative-engine-optimization/extractability/') ?>">Extractability in Generative Search</a></p>
        </div>
      </div>

    </div>
  </section>
</main>

