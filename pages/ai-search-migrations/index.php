<?php
// AI Search Migrations Pillar Page
// Demand Stage: Stage 4 — "we need to fix this properly"

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-migrations/');

$migrationPages = [
  [
    'slug' => 'restructuring-content-for-ai',
    'name' => 'Restructuring Content for AI',
    'description' => 'How to restructure existing content for generative retrieval and citation.'
  ],
  [
    'slug' => 'migrating-legacy-blogs',
    'name' => 'Migrating Legacy Blogs',
    'description' => 'Step-by-step process for migrating legacy blog content to AI-retrievable formats.'
  ],
  [
    'slug' => 'chunking-existing-content',
    'name' => 'Chunking Existing Content',
    'description' => 'How to apply content chunking and prechunking to existing content libraries.'
  ],
  [
    'slug' => 'retiring-low-confidence-pages',
    'name' => 'Retiring Low-Confidence Pages',
    'description' => 'How to identify and retire pages that cannot be retrieved by generative engines.'
  ],
  [
    'slug' => 'rebuilding-sites-for-retrieval',
    'name' => 'Rebuilding Sites for Retrieval',
    'description' => 'Complete site architecture rebuild for generative retrieval optimization.'
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
        'name' => 'Rebuilding Content for Generative Retrieval',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Rebuilding Content for Generative Retrieval',
    'name' => 'Rebuilding Content for Generative Retrieval',
    'description' => 'Step-by-step procedural guides for restructuring, migrating, and rebuilding content for AI retrieval. People will follow these line-by-line.',
    'url' => $canonicalUrl,
    'author' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d'),
    'about' => [
      '@type' => 'DefinedTerm',
      'name' => 'AI Search Migrations',
      'description' => 'Procedural guides for rebuilding content and sites for generative retrieval.'
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Rebuilding Content for Generative Retrieval</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Step-by-step procedural guides for restructuring and migrating content</p>
        </div>
      </div>

      <!-- Migration Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Migration Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($migrationPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-migrations/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-migrations/' . $page['slug'] . '/') ?>">Read guide →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Procedural Nature -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Procedural Guides</h2>
        </div>
        <div class="content-block__body">
          <p>These guides are procedural. People will follow them line-by-line.</p>
          <p>Each guide includes:</p>
          <ul>
            <li>Step-by-step instructions</li>
            <li>Verification checkpoints</li>
            <li>Common pitfalls</li>
            <li>Success criteria</li>
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
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — Foundational mechanics</li>
            <li><a href="<?= absolute_url('/en-us/insights/content-chunking-seo/') ?>">Content Chunking</a> — Presentation structure</li>
            <li><a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">Prechunking</a> — Extraction structure</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-operations/') ?>">AI Search Operations</a> — What to stop doing</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

