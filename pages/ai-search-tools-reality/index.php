<?php
// AI Search Tools Reality Pillar Page
// Demand Stage: Stage 2 → 3

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-tools-reality/');

$toolsPages = [
  [
    'slug' => 'what-seo-tools-can-and-cannot-see',
    'name' => 'What SEO Tools Can and Cannot See',
    'description' => 'Honest assessment of what SEO tools can observe in AI-mediated search.'
  ],
  [
    'slug' => 'limitations-of-ai-visibility-tools',
    'name' => 'Limitations of AI Visibility Tools',
    'description' => 'Why AI visibility tools provide incomplete data and what they miss.'
  ],
  [
    'slug' => 'why-ai-search-data-is-incomplete',
    'name' => 'Why AI Search Data Is Incomplete',
    'description' => 'Technical reasons why complete AI search data is not available.'
  ],
  [
    'slug' => 'tool-metrics-vs-reality',
    'name' => 'Tool Metrics vs Reality',
    'description' => 'How to interpret tool metrics in context of actual AI search behavior.'
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
        'name' => 'The Limits of SEO Tooling in AI Search',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'The Limits of SEO Tooling in AI Search',
    'name' => 'The Limits of SEO Tooling in AI Search',
    'description' => 'Honest assessment of what SEO tools can and cannot see in AI-mediated search. Prevents false expectations and builds credibility.',
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
      'name' => 'AI Search Tools Reality',
      'description' => 'Honest assessment of SEO tool limitations in AI-mediated search environments.'
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
          <h1 class="content-block__title heading-1">The Limits of SEO Tooling in AI Search</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Honest assessment of what SEO tools can and cannot see</p>
          <div class="callout-system-truth">
            <p>
              This prevents false expectations and builds credibility by being transparent about tool limitations.
            </p>
          </div>
        </div>
      </div>

      <!-- Tools Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Tool Reality Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($toolsPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-tools-reality/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-tools-reality/' . $page['slug'] . '/') ?>">Read guide →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Why This Builds Credibility -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why This Builds Credibility</h2>
        </div>
        <div class="content-block__body">
          <p>Most SEO content overpromises what tools can do. This content:</p>
          <ul>
            <li>Sets realistic expectations</li>
            <li>Explains why data is incomplete</li>
            <li>Helps teams interpret metrics correctly</li>
            <li>Prevents false conclusions from tool data</li>
          </ul>
          <p>Transparency builds trust faster than overpromising.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> — What can be measured</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> — Troubleshooting issues</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — Foundational mechanics</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

