<?php
// Glossary Entry: Inference Context Stability
// Short, explicit, definition-only page

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/glossary/inference-context-stability/');

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
        'name' => 'Inference Context Stability',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // DefinedTerm
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTerm',
    '@id' => $canonicalUrl . '#term',
    'name' => 'Inference Context Stability',
    'description' => 'Whether a generative system infers the same meaning from a content segment across different prompts, queries, and retrieval contexts. In AI search, unstable inference reduces confidence and leads to suppression even when content is correct and extractable.',
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
          <h1 class="content-block__title heading-1">Inference Context Stability</h1>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Inference context stability describes whether a generative system infers the same meaning from a content segment across different prompts, queries, and retrieval contexts. In AI search, unstable inference reduces confidence and leads to suppression even when content is correct and extractable.</p>
          </div>
          
          <p>Full reference: <a href="<?= absolute_url('/en-us/generative-engine-optimization/inference-context-stability/') ?>">Inference Context Stability in Generative Search</a></p>
        </div>
      </div>

    </div>
  </section>
</main>

