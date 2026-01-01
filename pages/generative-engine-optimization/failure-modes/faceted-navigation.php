<?php
// Failure Mode: Faceted Navigation
// Template for all failure mode pages

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/failure-modes/faceted-navigation/');

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
        'item' => absolute_url('/en-us/generative-engine-optimization/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Failure Modes',
        'item' => absolute_url('/en-us/generative-engine-optimization/failure-modes/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Faceted Navigation',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Faceted Navigation: Why Dynamic URLs Fragment Retrieval Confidence',
    'name' => 'Faceted Navigation',
    'description' => 'Faceted navigation creates duplicate content signals through dynamic URLs, fragmenting retrieval confidence in generative engines.',
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
      'name' => 'Faceted Navigation',
      'description' => 'A GEO failure mode where dynamic URLs create duplicate content signals that fragment retrieval confidence.'
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
          <h1 class="content-block__title heading-1">Faceted Navigation</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Dynamic URLs create duplicate content signals that fragment retrieval confidence.</p>
        </div>
      </div>

      <!-- What the Model Sees -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the Model Sees</h2>
        </div>
        <div class="content-block__body">
          <p>When the same content is accessible via multiple query parameter URLs, generative engines observe:</p>
          <ul>
            <li>Identical content segments on different URLs (/products?color=red vs /products?color=blue)</li>
            <li>Multiple URL variants competing for the same content</li>
            <li>Fragmented engagement signals across duplicate URLs</li>
            <li>Ambiguous canonical signals for faceted pages</li>
            <li>Duplicate content segments with different URL identifiers</li>
          </ul>
          <p>The model cannot determine which URL variant is authoritative, so confidence fragments across all variants.</p>
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
              Generative engines require unambiguous URL identification for content segments. When faceted navigation creates multiple URLs for the same content, each variant competes for retrieval, fragmenting confidence scores.
            </p>
          </div>
          <p>Confidence drops because:</p>
          <ol>
            <li><strong>Signal fragmentation:</strong> Engagement and authority signals split across multiple URL variants</li>
            <li><strong>Competing variants:</strong> Each faceted URL competes with others, reducing individual scores</li>
            <li><strong>Canonical ambiguity:</strong> The system cannot determine which faceted URL is the canonical version</li>
            <li><strong>Retrieval uncertainty:</strong> Multiple identical segments create confusion about which to retrieve</li>
          </ol>
        </div>
      </div>

      <!-- What Gets Ignored -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Gets Ignored</h2>
        </div>
        <div class="content-block__body">
          <p>When faceted navigation creates duplicate URLs, generative engines ignore:</p>
          <ul>
            <li>All faceted URL variants (none achieve sufficient confidence individually)</li>
            <li>Content segments that appear on multiple faceted URLs</li>
            <li>Canonical tags on faceted pages if they conflict with other variants</li>
            <li>Internal links pointing to faceted URL variants</li>
          </ul>
          <p>The system defaults to ignoring all faceted variants rather than selecting one arbitrarily.</p>
        </div>
      </div>

      <!-- Common Triggers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Triggers</h2>
        </div>
        <div class="content-block__body">
          <p>Faceted navigation fragmentation is triggered by:</p>
          <ul>
            <li><strong>E-commerce filters:</strong> /products?color=red, /products?size=large, /products?color=red&size=large</li>
            <li><strong>Search parameters:</strong> /search?q=term&sort=price, /search?q=term&sort=relevance</li>
            <li><strong>Pagination variants:</strong> /products?page=1, /products?page=2 serving similar content</li>
            <li><strong>Sorting options:</strong> /products?sort=price, /products?sort=name showing same products</li>
            <li><strong>Multiple filter combinations:</strong> Hundreds of URL variants for the same product set</li>
            <li><strong>Missing canonical consolidation:</strong> Faceted URLs not pointing to a single canonical version</li>
          </ul>
        </div>
      </div>

      <!-- Observed Outcomes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observed Outcomes</h2>
        </div>
        <div class="content-block__body">
          <p>When faceted navigation fragments confidence, we observe:</p>
          <ul>
            <li>Content disappears from AI Overviews and LLM answers</li>
            <li>No single faceted URL variant achieves citation eligibility</li>
            <li>Retrieval confidence scores remain below threshold across all variants</li>
            <li>Competitor content with clean, canonical URLs replaces the fragmented content</li>
            <li>Internal linking signals fragment across multiple faceted URLs</li>
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
          <p>To mitigate faceted navigation fragmentation:</p>
          <ol>
            <li><strong>Establish canonical URLs:</strong> Choose one canonical URL for each content set (often the base URL without filters)</li>
            <li><strong>Use rel="canonical":</strong> Point all faceted URL variants to their canonical URL</li>
            <li><strong>Implement 301 redirects:</strong> Redirect faceted URLs to canonical when appropriate</li>
            <li><strong>Consolidate internal links:</strong> Update internal links to point to canonical URLs, not faceted variants</li>
            <li><strong>Use robots.txt or noindex:</strong> Block or de-index unnecessary faceted URL variants</li>
            <li><strong>Monitor for new variants:</strong> Regularly audit for new faceted URL patterns that fragment signals</li>
          </ol>
          <p>Once faceted URLs are consolidated to canonical versions, confidence scores improve and retrieval probability increases.</p>
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
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/canonical-drift/') ?>">Canonical Drift →</a> (related: multiple URLs serving same content)</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

