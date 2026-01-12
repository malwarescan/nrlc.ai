<?php
// AI Search Measurement Pillar Page
// Demand Stage: Stage 2 — "how do I prove value"

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-measurement/');

$measurementPages = [
  [
    'slug' => 'measuring-ai-visibility',
    'name' => 'Measuring AI Visibility',
    'description' => 'What metrics exist for tracking visibility in AI-generated answers and AI Overviews.'
  ],
  [
    'slug' => 'tracking-ai-citations',
    'name' => 'Tracking AI Citations',
    'description' => 'How to monitor when and how your content is cited by generative AI systems.'
  ],
  [
    'slug' => 'reporting-ai-search-performance',
    'name' => 'Reporting AI Search Performance',
    'description' => 'How to report AI search visibility to executives and stakeholders.'
  ],
  [
    'slug' => 'attribution-in-zero-click-search',
    'name' => 'Attribution in Zero-Click Search',
    'description' => 'How to attribute value when users get answers without clicking through to your site.'
  ],
  [
    'slug' => 'what-can-and-cannot-be-measured',
    'name' => 'What Can and Cannot Be Measured',
    'description' => 'Honest assessment of measurement limitations in AI-mediated search.'
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
        'name' => 'Measuring Visibility in AI Search',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Measuring Visibility in AI Search',
    'name' => 'Measuring Visibility in AI Search',
    'description' => 'Complete guide to measuring and reporting visibility in AI-generated answers, AI Overviews, and zero-click search. What metrics exist, what can be measured, and what executives should expect.',
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
      'name' => 'AI Search Measurement',
      'description' => 'Metrics and reporting for visibility in AI-mediated search environments.'
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
          <h1 class="content-block__title heading-1">Measuring AI Search Visibility and Citation Presence</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Metrics and reporting for AI-mediated search environments</p>
        </div>
      </div>

      <!-- Measurement Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Measurement Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($measurementPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-measurement/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-measurement/' . $page['slug'] . '/') ?>">Read guide →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- What This Owns -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What This System Owns</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><strong>What metrics exist:</strong> Observable measurements for AI search visibility</li>
            <li><strong>What metrics are inferred:</strong> Measurements that require interpretation or estimation</li>
            <li><strong>What metrics are fiction:</strong> Claims that cannot be verified or measured</li>
            <li><strong>What executives should expect:</strong> Realistic expectations for AI search measurement</li>
          </ul>
          <p>This is where agencies send clients when they need to explain AI search performance.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> — Troubleshooting visibility issues</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>">AI Search Tools Reality</a> — Limitations of measurement tools</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — How retrieval works</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

