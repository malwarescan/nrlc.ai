<?php
// Glossary Pillar Page
// Entity anchor for terminology

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/glossary/');

$glossarySections = [
  [
    'slug' => 'decision-traces',
    'name' => 'Decision Traces',
    'description' => 'The observable record of how generative AI systems decide what to retrieve, cite, or suppress.'
  ],
  [
    'slug' => 'generative-search-terms',
    'name' => 'Generative Search Terms',
    'description' => 'Core terminology for generative search and AI-mediated search environments.'
  ],
  [
    'slug' => 'retrieval-failure-patterns',
    'name' => 'Retrieval Failure Patterns',
    'description' => 'Terms and definitions for failure patterns in generative retrieval.'
  ],
  [
    'slug' => 'ai-search-definitions',
    'name' => 'AI Search Definitions',
    'description' => 'Standard definitions for AI search concepts and mechanics.'
  ]
];

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
        'item' => $canonicalUrl
      ]
    ]
  ],
  // CollectionPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $canonicalUrl . '#page',
    'headline' => 'AI Search Glossary',
    'name' => 'AI Search Glossary',
    'description' => 'Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics. Stabilizes terminology across the site and for LLMs.',
    'url' => $canonicalUrl
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">AI Search Glossary</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Standard terminology and definitions for generative search</p>
          <div class="callout-system-truth">
            <p>
              This stabilizes terminology across the site and for LLMs. Consistent definitions create entity anchors that improve retrieval and citation.
            </p>
          </div>
        </div>
      </div>

      <!-- Glossary Sections Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Glossary Sections</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($glossarySections as $section): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/glossary/' . $section['slug'] . '/') ?>">
                    <?= htmlspecialchars($section['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($section['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/glossary/' . $section['slug'] . '/') ?>">View terms →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Purpose -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Purpose</h2>
        </div>
        <div class="content-block__body">
          <p>The glossary serves as:</p>
          <ul>
            <li><strong>Entity anchor:</strong> Stable definitions that LLMs can reference</li>
            <li><strong>Terminology stabilization:</strong> Consistent language across all content</li>
            <li><strong>Retrieval optimization:</strong> Definitions improve segment retrieval</li>
            <li><strong>Citation source:</strong> LLMs cite definitions verbatim</li>
          </ul>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — Core concepts</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> — Failure pattern definitions</li>
            <li><a href="<?= absolute_url('/en-us/field-notes/') ?>">Field Notes</a> — Observational terminology</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

