<?php
// Failure Mode: Conflicting Entities
// Template for all failure mode pages

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/failure-modes/conflicting-entities/');

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
        'name' => 'Conflicting Entities',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Conflicting Entities: Why Multiple Entity Definitions Create Ambiguity',
    'name' => 'Conflicting Entities',
    'description' => 'Conflicting entities occur when multiple entity definitions for the same concept create ambiguity and reduce confidence in generative engines.',
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
      'name' => 'Conflicting Entities',
      'description' => 'A GEO failure mode where multiple entity definitions for the same concept create ambiguity and reduce confidence.'
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
          <h1 class="content-block__title heading-1">Conflicting Entities</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Multiple entity definitions for the same concept create ambiguity and reduce confidence.</p>
        </div>
      </div>

      <!-- What the Model Sees -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the Model Sees</h2>
        </div>
        <div class="content-block__body">
          <p>When the same entity is defined differently across pages or within a single page, generative engines observe:</p>
          <ul>
            <li>Multiple definitions for the same entity with conflicting information</li>
            <li>Inconsistent entity properties (different names, URLs, or attributes)</li>
            <li>Ambiguous entity resolution signals across pages</li>
            <li>Conflicting schema markup for the same entity</li>
            <li>Unclear which definition is authoritative</li>
          </ul>
          <p>The model cannot resolve which entity definition is authoritative, so confidence drops for all variants.</p>
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
              Generative engines require unambiguous entity definitions. When multiple definitions exist for the same entity, the system cannot determine which is authoritative, causing confidence scores to fragment.
            </p>
          </div>
          <p>Confidence drops because:</p>
          <ol>
            <li><strong>Entity ambiguity:</strong> The system cannot resolve which definition represents the true entity</li>
            <li><strong>Signal conflict:</strong> Conflicting entity properties create contradictory signals</li>
            <li><strong>Trust degradation:</strong> Multiple definitions suggest unreliable or inconsistent data</li>
            <li><strong>Citation uncertainty:</strong> The system cannot cite a single authoritative entity definition</li>
          </ol>
        </div>
      </div>

      <!-- What Gets Ignored -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Gets Ignored</h2>
        </div>
        <div class="content-block__body">
          <p>When conflicting entities occur, generative engines ignore:</p>
          <ul>
            <li>All conflicting entity definitions (none achieve sufficient confidence)</li>
            <li>Entity schema markup that conflicts with other definitions</li>
            <li>Content segments that reference ambiguous entities</li>
            <li>Entity properties that contradict other entity definitions</li>
          </ul>
          <p>The system defaults to ignoring all entity definitions rather than selecting one arbitrarily.</p>
        </div>
      </div>

      <!-- Common Triggers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Triggers</h2>
        </div>
        <div class="content-block__body">
          <p>Conflicting entities are triggered by:</p>
          <ul>
            <li><strong>Multiple Organization schemas:</strong> Different organization names or URLs across pages</li>
            <li><strong>Inconsistent Person entities:</strong> Same person defined with different names or affiliations</li>
            <li><strong>Product conflicts:</strong> Same product with different names, prices, or descriptions</li>
            <li><strong>Location ambiguity:</strong> Same location with different addresses or coordinates</li>
            <li><strong>Schema markup conflicts:</strong> Organization schema on one page conflicts with Organization schema on another</li>
            <li><strong>Content-schema mismatch:</strong> Schema markup that contradicts page content</li>
          </ul>
        </div>
      </div>

      <!-- Observed Outcomes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observed Outcomes</h2>
        </div>
        <div class="content-block__body">
          <p>When conflicting entities occur, we observe:</p>
          <ul>
            <li>Content disappears from AI Overviews and LLM answers</li>
            <li>Entity-based queries fail to retrieve the content</li>
            <li>Retrieval confidence scores remain below threshold</li>
            <li>Competitor content with unambiguous entity definitions replaces the conflicting content</li>
            <li>Schema validation tools report conflicts or errors</li>
          </ul>
          <p>These outcomes are observable and measurable through retrieval monitoring and schema validation.</p>
        </div>
      </div>

      <!-- Mitigation Strategy -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Strategy</h2>
        </div>
        <div class="content-block__body">
          <p>This failure pattern represents a negative decision trace, where confidence drops below retrieval thresholds. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> explain how these patterns accumulate and influence future retrieval decisions.</p>
          <p>To mitigate conflicting entities:</p>
          <ol>
            <li><strong>Establish single entity definition:</strong> Choose one authoritative definition for each entity</li>
            <li><strong>Use consistent schema markup:</strong> Apply the same entity schema consistently across all pages</li>
            <li><strong>Remove conflicting definitions:</strong> Eliminate duplicate or contradictory entity definitions</li>
            <li><strong>Validate entity consistency:</strong> Use schema validation tools to identify conflicts</li>
            <li><strong>Ensure content-schema alignment:</strong> Verify that schema markup matches page content exactly</li>
            <li><strong>Centralize entity definitions:</strong> Use a single source of truth for entity properties</li>
          </ol>
          <p>Once entity definitions are unambiguous and consistent, confidence scores improve and retrieval probability increases.</p>
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
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/schema-noise/') ?>">Schema Noise →</a> (related: conflicting structured data)</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

