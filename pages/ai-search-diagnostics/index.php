<?php
// AI Search Diagnostics Pillar Page
// Demand Stage: Stage 1 — "something broke"

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-diagnostics/');

$diagnosticPages = [
  [
    'slug' => 'site-not-showing-in-ai-results',
    'name' => 'Site Not Showing in AI Results',
    'description' => 'Diagnose why your site is not appearing in AI-generated answers, AI Overviews, or LLM citations.'
  ],
  [
    'slug' => 'traffic-down-rankings-stable',
    'name' => 'Traffic Down, Rankings Stable',
    'description' => 'Understand why organic traffic declines while traditional rankings remain unchanged.'
  ],
  [
    'slug' => 'not-cited-in-ai-overviews',
    'name' => 'Not Cited in AI Overviews',
    'description' => 'Identify why content is indexed but not cited in Google AI Overviews or other generative results.'
  ],
  [
    'slug' => 'indexed-but-not-retrieved',
    'name' => 'Indexed But Not Retrieved',
    'description' => 'Diagnose why pages are indexed by search engines but not retrieved by generative AI systems.'
  ],
  [
    'slug' => 'schema-stopped-working',
    'name' => 'Schema Stopped Working',
    'description' => 'Troubleshoot why structured data that previously worked is now ignored by generative engines.'
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
        'name' => 'AI Search Diagnostics',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'AI Search Diagnostics: Troubleshooting Visibility Issues',
    'name' => 'AI Search Diagnostics',
    'description' => 'Diagnostic guides for AI search visibility issues. Symptom-first troubleshooting for sites not showing in AI results, traffic declines, and citation failures.',
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
      'name' => 'AI Search Diagnostics',
      'description' => 'Symptom-first troubleshooting for generative search visibility issues.'
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
          <h1 class="content-block__title heading-1">AI Search Diagnostics: Identifying Retrieval and Citation Failures</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Symptom-first troubleshooting for generative search visibility issues</p>
          <div class="callout-system-truth">
            <p>
              People do not Google "best practices" when things break. They Google symptoms. These diagnostic guides map symptoms to failure modes and solutions.
            </p>
          </div>
          <p>Each diagnostic symptom maps to underlying decision traces. When a site is not showing in AI results, or content is not cited in AI Overviews, these behaviors are explained by <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">decision traces in generative search</a>—the observable record of how AI systems decide what to retrieve, cite, or ignore.</p>
          <p>Many persistent visibility failures are not indexing problems. They are <a href="<?= absolute_url('/en-us/generative-engine-optimization/extractability/') ?>">extractability</a> problems.</p>
          <p>Many intermittent AI visibility failures are caused by <a href="<?= absolute_url('/en-us/generative-engine-optimization/inference-context-stability/') ?>">inference context instability</a> rather than indexing or authority issues.</p>
          <p>Some systems retrieve your content but still refuse to reuse it because it does not clear a <a href="<?= absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/') ?>">confidence band</a>.</p>
          <p>Some segments fail not because they are wrong, but because their meaning does not survive <a href="<?= absolute_url('/en-us/generative-engine-optimization/compression-integrity/') ?>">compression</a>.</p>
        </div>
      </div>

      <!-- Diagnostic Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Diagnostic Guides</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <?php foreach ($diagnosticPages as $page): ?>
              <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/ai-search-diagnostics/' . $page['slug'] . '/') ?>">
                    <?= htmlspecialchars($page['name']) ?>
                  </a>
                </h3>
                <p><?= htmlspecialchars($page['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/ai-search-diagnostics/' . $page['slug'] . '/') ?>">Diagnose issue →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- How Diagnostics Work -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Diagnostic Guides Work</h2>
        </div>
        <div class="content-block__body">
          <p>Each diagnostic guide follows a symptom-first approach:</p>
          <ol>
            <li><strong>What the system is doing:</strong> Observable behavior that indicates the issue</li>
            <li><strong>Why the symptom appears:</strong> Root cause explanation tied to retrieval mechanics</li>
            <li><strong>Which failure mode it maps to:</strong> Links to specific failure patterns in the GEO system</li>
            <li><strong>Diagnostic steps:</strong> How to verify the cause</li>
            <li><strong>Mitigation path:</strong> How to resolve the issue</li>
          </ol>
          <p>These guides funnel directly into <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">GEO Failure Modes</a> for detailed mechanics.</p>
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
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> — Detailed failure patterns</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> — How to measure visibility</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

