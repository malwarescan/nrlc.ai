<?php
// Failure Mode: Canonical Drift
// Template for all failure mode pages

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/failure-modes/canonical-drift/');

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
        'name' => 'Generative Engine Optimization',
        'item' => absolute_url('/generative-engine-optimization/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Failure Modes',
        'item' => absolute_url('/generative-engine-optimization/failure-modes/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Canonical Drift',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Canonical Drift: Why Multiple URLs Cause Retrieval Failure',
    'name' => 'Canonical Drift',
    'description' => 'Canonical drift occurs when multiple URLs serve the same content, causing retrieval confusion and confidence loss in generative engines.',
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
      'name' => 'Canonical Drift',
      'description' => 'A GEO failure mode where multiple URLs serve identical content, causing retrieval confusion.'
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Back Links -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <div class="content-block__body">
          <p>
            <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>" class="btn btn--secondary">← Failure Modes Index</a>
            <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" class="btn btn--secondary" style="margin-left: var(--spacing-sm);">← GEO Overview</a>
          </p>
        </div>
      </div>

      <!-- Failure Name -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Canonical Drift</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Multiple URLs serve the same content, causing retrieval confusion and confidence loss.</p>
        </div>
      </div>

      <!-- What the Model Sees -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the Model Sees</h2>
        </div>
        <div class="content-block__body">
          <p>When multiple URLs serve identical or near-identical content, generative engines observe:</p>
          <ul>
            <li>Duplicate content segments across different URLs</li>
            <li>Conflicting canonical signals (self-referencing canonicals on duplicate pages)</li>
            <li>Ambiguous entity resolution (which URL is authoritative?)</li>
            <li>Fragmented confidence scores across duplicate segments</li>
          </ul>
          <p>The model cannot determine which URL is the source of truth, so confidence drops for all variants.</p>
        </div>
      </div>

      <!-- Why Confidence Drops -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Confidence Drops</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-system-truth">
            <p>
              Generative engines require unambiguous source identification. When multiple URLs serve the same content, the system cannot determine which segment is authoritative, causing confidence scores to fragment across duplicates.
            </p>
          </div>
          <p>Confidence drops because:</p>
          <ol>
            <li><strong>Entity ambiguity:</strong> The system cannot resolve which URL represents the canonical entity</li>
            <li><strong>Signal dilution:</strong> Engagement and authority signals split across duplicates</li>
            <li><strong>Citation uncertainty:</strong> The system cannot cite a single authoritative URL</li>
            <li><strong>Retrieval fragmentation:</strong> Segments from different URLs compete, reducing individual scores</li>
          </ol>
        </div>
      </div>

      <!-- What Gets Ignored -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Gets Ignored</h2>
        </div>
        <div class="content-block__body">
          <p>When canonical drift occurs, generative engines ignore:</p>
          <ul>
            <li>All duplicate URL variants (none achieve sufficient confidence)</li>
            <li>Content segments that appear on multiple URLs</li>
            <li>Self-referencing canonical tags on duplicate pages</li>
            <li>Internal links pointing to duplicate URLs</li>
          </ul>
          <p>The system defaults to ignoring all variants rather than selecting one arbitrarily.</p>
        </div>
      </div>

      <!-- Common Triggers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Triggers</h2>
        </div>
        <div class="content-block__body">
          <p>Canonical drift is triggered by:</p>
          <ul>
            <li><strong>WWW vs non-WWW:</strong> Both www.example.com and example.com serve identical content</li>
            <li><strong>HTTP vs HTTPS:</strong> Both protocols serve the same content without redirects</li>
            <li><strong>Trailing slash variants:</strong> /page/ and /page serve identical content</li>
            <li><strong>Query parameter duplicates:</strong> /page?ref=source and /page serve identical content</li>
            <li><strong>Faceted navigation:</strong> /products?color=red and /products?color=blue serve identical product pages</li>
            <li><strong>Session IDs in URLs:</strong> /page?sid=123 and /page?sid=456 serve identical content</li>
          </ul>
        </div>
      </div>

      <!-- Observed Outcomes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observed Outcomes</h2>
        </div>
        <div class="content-block__body">
          <p>When canonical drift occurs, we observe:</p>
          <ul>
            <li>Content disappears from AI Overviews and LLM answers</li>
            <li>No single URL variant achieves citation eligibility</li>
            <li>Retrieval confidence scores remain below threshold across all duplicates</li>
            <li>Competitor content with unambiguous URLs replaces the drifted content</li>
            <li>Internal linking signals fragment across duplicate URLs</li>
          </ul>
          <p>These outcomes are observable and measurable through retrieval monitoring.</p>
        </div>
      </div>

      <!-- Mitigation Strategy -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Strategy</h2>
        </div>
        <div class="content-block__body">
          <p>This failure pattern represents a negative decision trace, where confidence drops below retrieval thresholds. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> explain how these patterns accumulate and influence future retrieval decisions.</p>
          <p>To mitigate canonical drift:</p>
          <ol>
            <li><strong>Establish single canonical URL:</strong> Choose one authoritative URL variant</li>
            <li><strong>Implement 301 redirects:</strong> Redirect all duplicate variants to the canonical</li>
            <li><strong>Set canonical tags:</strong> Use self-referencing canonical tags on the canonical URL. NRLC standard: canonical pages use self-referencing canonicals; alternate pages point their canonicals to the canonical URL.</li>
            <li><strong>Consolidate internal links:</strong> Update all internal links to point to the canonical URL</li>
            <li><strong>Remove query parameters:</strong> Use rel="canonical" to consolidate query parameter variants</li>
            <li><strong>Monitor for drift:</strong> Regularly audit for new duplicate URL patterns</li>
          </ol>
          <p>Once a single canonical URL is established, confidence scores consolidate and retrieval probability increases.</p>
        </div>
      </div>

      <!-- Related Failure Modes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Failure Modes</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">All Failure Modes →</a></li>
          </ul>
        </div>
      </div>

      <!-- Implementation Support (Contextual) -->
      <div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-8);">
        <div class="content-block__body">
          <p style="font-size: 0.95rem; color: #666; margin: 0;">
            When a failure mode repeats under different fixes, recovery usually requires coordinated changes rather than isolated adjustments. On complex sites, that coordination is often the limiting factor.
          </p>
          <p style="margin-top: var(--spacing-sm); margin-bottom: 0;">
            <a href="<?= absolute_url('/implementation/') ?>" style="font-size: 0.95rem;">Implementation Support</a>
          </p>
        </div>
      </div>

    </div>
  </section>
</main>

