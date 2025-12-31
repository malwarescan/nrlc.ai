<?php
// AI Search Risk & Governance Pillar Page
// Demand Stage: Stage 5 — long-term control

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-risk/');

$riskPages = [
  [
    'slug' => 'ai-citation-risk',
    'name' => 'AI Citation Risk',
    'description' => 'Risks associated with AI citations, misattribution, and brand mention in generative results.'
  ],
  [
    'slug' => 'hallucinated-brand-mentions',
    'name' => 'Hallucinated Brand Mentions',
    'description' => 'How to identify and correct false brand mentions in AI-generated content.'
  ],
  [
    'slug' => 'correcting-ai-misinformation',
    'name' => 'Correcting AI Misinformation',
    'description' => 'Processes for correcting false information about your brand in AI systems.'
  ],
  [
    'slug' => 'trust-and-authority-governance',
    'name' => 'Trust and Authority Governance',
    'description' => 'Long-term governance for maintaining trust and authority in AI-mediated search.'
  ],
  [
    'slug' => 'ai-search-compliance',
    'name' => 'AI Search Compliance',
    'description' => 'Compliance considerations for AI search visibility and citation.'
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
        'name' => 'Managing Risk in AI-Mediated Search',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Managing Risk in AI-Mediated Search',
    'name' => 'Managing Risk in AI-Mediated Search',
    'description' => 'Brand protection, governance, and institutional trust in AI-mediated search. Enterprise risk management for AI citations and visibility.',
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
      'name' => 'AI Search Risk',
      'description' => 'Risk management and governance for AI-mediated search visibility and citation.'
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
          <h1 class="content-block__title heading-1">Managing Risk in AI-Mediated Search</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Brand protection, governance, and institutional trust</p>
          <div class="callout-system-truth">
            <p>
              This is where NRLC moves upstream: brand protection, governance, and institutional trust. Few competitors will touch this.
            </p>
          </div>
        </div>
      </div>

      <!-- Risk Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Risk Management Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($riskPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-risk/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-risk/' . $page['slug'] . '/') ?>">Read guide →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Enterprise Focus -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Enterprise Focus</h2>
        </div>
        <div class="content-block__body">
          <p>This system addresses:</p>
          <ul>
            <li><strong>Brand protection:</strong> Preventing and correcting false information</li>
            <li><strong>Governance:</strong> Long-term control and monitoring</li>
            <li><strong>Institutional trust:</strong> Maintaining authority in AI systems</li>
            <li><strong>Compliance:</strong> Regulatory and legal considerations</li>
          </ul>
          <p>Few competitors address these enterprise concerns comprehensively.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> — Troubleshooting issues</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> — Why content disappears</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> — Monitoring visibility</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

