<?php
// Glossary Entry: Confidence Band Filtering
// Short, explicit, definition-only page

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/glossary/confidence-band-filtering/');

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
        'name' => 'Confidence Band Filtering',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // DefinedTerm
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTerm',
    '@id' => $canonicalUrl . '#term',
    'name' => 'Confidence Band Filtering',
    'description' => 'How generative systems exclude content that falls below an internal confidence threshold for reuse. In AI search, a segment can be relevant and retrieved yet still be filtered out because the system cannot justify citation with sufficient confidence.',
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
          <h1 class="content-block__title heading-1">Confidence Band Filtering</h1>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Confidence band filtering describes how generative systems exclude content that falls below an internal confidence threshold for reuse. In AI search, a segment can be relevant and retrieved yet still be filtered out because the system cannot justify citation with sufficient confidence.</p>
          </div>
          
          <p>Full reference: <a href="<?= absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/') ?>">Confidence Band Filtering in Generative Search</a></p>
        </div>
      </div>

    </div>
  </section>
</main>

