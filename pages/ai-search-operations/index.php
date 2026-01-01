<?php
// AI Search Operations Pillar Page
// Demand Stage: Stage 3 → Stage 4

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-operations/');

$operationsPages = [
  [
    'slug' => 'practices-with-diminishing-returns',
    'name' => 'Practices with Diminishing Returns',
    'description' => 'SEO practices that still work but deliver less value in AI-mediated search.'
  ],
  [
    'slug' => 'signals-generative-engines-ignore',
    'name' => 'Signals Generative Engines Ignore',
    'description' => 'Traditional SEO signals that generative AI systems do not use for retrieval.'
  ],
  [
    'slug' => 'what-to-stop-doing-in-seo',
    'name' => 'What to Stop Doing in SEO',
    'description' => 'SEO practices that should be decommissioned or deprioritized.'
  ],
  [
    'slug' => 'what-still-matters-operationally',
    'name' => 'What Still Matters Operationally',
    'description' => 'SEO practices that remain essential in AI-mediated search.'
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
        'name' => 'Operating SEO in an AI-Mediated Search Environment',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Operating SEO in an AI-Mediated Search Environment',
    'name' => 'Operating SEO in an AI-Mediated Search Environment',
    'description' => 'What to stop doing, what to keep doing, and what signals generative engines ignore. Operational guidance for SEO teams.',
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
      'name' => 'AI Search Operations',
      'description' => 'Operational guidance for SEO teams in AI-mediated search environments.'
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
          <h1 class="content-block__title heading-1">Operating SEO in an AI-Mediated Search Environment</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">What to stop doing, what to keep doing, and what signals generative engines ignore</p>
          <div class="callout-system-truth">
            <p>
              Almost nobody tells SEOs what to decommission. This content builds trust fast by being honest about what no longer works.
            </p>
          </div>
        </div>
      </div>

      <!-- Operations Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Operational Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($operationsPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-operations/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-operations/' . $page['slug'] . '/') ?>">Read guide →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Why This Wins -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why This Content Wins</h2>
        </div>
        <div class="content-block__body">
          <p>Most SEO content tells you what to do. This content tells you what to stop doing.</p>
          <p>This builds trust because:</p>
          <ul>
            <li>It's honest about diminishing returns</li>
            <li>It identifies wasted effort</li>
            <li>It helps teams prioritize</li>
            <li>It prevents false expectations</li>
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
            <li><a href="<?= absolute_url('/en-us/ai-search-strategy/') ?>">AI Search Strategy</a> — Strategic assessment</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>">AI Search Migrations</a> — How to rebuild</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — Foundational mechanics</li>
          </ul>
        </div>
      </div>

      <!-- Implementation Support (Contextual) -->
      <div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-8);">
        <div class="content-block__body">
          <p style="font-size: 0.95rem; color: #666; margin: 0;">
            Operational changes only hold when they are applied consistently across systems. Some teams use these frameworks as internal guidance. Others ask for help implementing them across distributed environments.
          </p>
          <p style="margin-top: var(--spacing-sm); margin-bottom: 0;">
            <a href="<?= absolute_url('/implementation/') ?>" style="font-size: 0.95rem;">Implementation Support</a>
          </p>
        </div>
      </div>

    </div>
  </section>
</main>

