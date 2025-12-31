<?php
// AI Search Strategy Pillar Page
// Demand Stage: Stage 3 — "is SEO dead / what now"

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-strategy/');

$strategyPages = [
  [
    'slug' => 'is-seo-still-relevant',
    'name' => 'Is SEO Still Relevant',
    'description' => 'What SEO controls, what it lost, and what remains essential in the generative era.'
  ],
  [
    'slug' => 'what-seo-still-controls',
    'name' => 'What SEO Still Controls',
    'description' => 'Technical and strategic elements that SEO teams still manage effectively.'
  ],
  [
    'slug' => 'what-seo-lost-control-over',
    'name' => 'What SEO Lost Control Over',
    'description' => 'Elements that SEO teams can no longer directly influence in AI-mediated search.'
  ],
  [
    'slug' => 'future-of-seo-teams',
    'name' => 'Future of SEO Teams',
    'description' => 'How SEO team structures and responsibilities are evolving.'
  ],
  [
    'slug' => 'agency-models-in-ai-search',
    'name' => 'Agency Models in AI Search',
    'description' => 'How SEO agencies are adapting service models for generative search.'
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
        'name' => 'Search Strategy in the Generative Era',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Search Strategy in the Generative Era',
    'name' => 'Search Strategy in the Generative Era',
    'description' => 'Calm, sober assessment of what SEO controls, what it lost, and how teams should adapt. Non-predictive, non-hype strategic guidance.',
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
      'name' => 'AI Search Strategy',
      'description' => 'Strategic assessment of SEO relevance and adaptation in generative search environments.'
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
          <h1 class="content-block__title heading-1">Search Strategy in the Generative Era</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Calm, sober assessment of what SEO controls and how teams should adapt</p>
          <div class="callout-system-truth">
            <p>
              This content stabilizes confused teams, reframes responsibilities, and resets expectations. No hype, no predictions, no trend language.
            </p>
          </div>
        </div>
      </div>

      <!-- Strategy Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Strategic Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($strategyPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-strategy/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-strategy/' . $page['slug'] . '/') ?>">Read guide →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Tone and Purpose -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Tone and Purpose</h2>
        </div>
        <div class="content-block__body">
          <p>This content is:</p>
          <ul>
            <li><strong>Calm:</strong> No panic, no urgency, no fear-mongering</li>
            <li><strong>Sober:</strong> Based on observable mechanics, not speculation</li>
            <li><strong>Non-predictive:</strong> Describes current state, not future predictions</li>
            <li><strong>Stabilizing:</strong> Helps teams understand what they can and cannot control</li>
          </ul>
          <p>This creates thought leadership without hype.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/ai-search-operations/') ?>">AI Search Operations</a> — What to stop and start doing</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — Foundational mechanics</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>">AI Search Migrations</a> — How to rebuild</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

