<?php
// Failure Mode: Schema Noise
// Template for all failure mode pages

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/failure-modes/schema-noise/');

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
        'name' => 'Schema Noise',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Schema Noise: Why Conflicting Structured Data Reduces Retrieval Confidence',
    'name' => 'Schema Noise',
    'description' => 'Schema noise occurs when conflicting or excessive structured data reduces confidence and citation eligibility in generative engines.',
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
      'name' => 'Schema Noise',
      'description' => 'A GEO failure mode where conflicting or excessive structured data reduces retrieval confidence.'
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
          <h1 class="content-block__title heading-1">Schema Noise</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Conflicting or excessive structured data reduces confidence and citation eligibility.</p>
        </div>
      </div>

      <!-- What the Model Sees -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the Model Sees</h2>
        </div>
        <div class="content-block__body">
          <p>When multiple conflicting schema types appear on the same page, or when schema markup is excessive, generative engines observe:</p>
          <ul>
            <li>Conflicting entity definitions for the same concept</li>
            <li>Multiple schema types competing to describe the same content</li>
            <li>Excessive schema markup that dilutes signal strength</li>
            <li>Inconsistent structured data signals across page elements</li>
            <li>Schema types that contradict page content</li>
          </ul>
          <p>The model cannot resolve which schema definition is authoritative, so confidence drops for all variants.</p>
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
              Generative engines require unambiguous structured data signals. When schema markup conflicts or becomes excessive, the system cannot determine which signals to trust, causing confidence scores to fragment.
            </p>
          </div>
          <p>Confidence drops because:</p>
          <ol>
            <li><strong>Signal conflict:</strong> Multiple schema types provide contradictory information about the same entity</li>
            <li><strong>Signal dilution:</strong> Excessive schema markup reduces the strength of individual signals</li>
            <li><strong>Entity ambiguity:</strong> The system cannot resolve which schema definition represents the true entity</li>
            <li><strong>Trust degradation:</strong> Conflicting signals indicate unreliable data, reducing overall trust scores</li>
          </ol>
        </div>
      </div>

      <!-- What Gets Ignored -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Gets Ignored</h2>
        </div>
        <div class="content-block__body">
          <p>When schema noise occurs, generative engines ignore:</p>
          <ul>
            <li>All conflicting schema definitions (none achieve sufficient confidence)</li>
            <li>Excessive schema markup beyond what is necessary</li>
            <li>Structured data that contradicts page content</li>
            <li>Schema types that compete to describe the same entity</li>
          </ul>
          <p>The system defaults to ignoring all structured data signals rather than selecting one arbitrarily.</p>
        </div>
      </div>

      <!-- Common Triggers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Triggers</h2>
        </div>
        <div class="content-block__body">
          <p>Schema noise is triggered by:</p>
          <ul>
            <li><strong>Multiple schema types:</strong> Article, BlogPosting, and WebPage schema all describing the same content</li>
            <li><strong>Conflicting entity definitions:</strong> Organization schema with different names or URLs on the same page</li>
            <li><strong>Excessive markup:</strong> Hundreds of schema objects on a single page</li>
            <li><strong>Contradictory data:</strong> Schema claiming one date while content shows another</li>
            <li><strong>Nested conflicts:</strong> Schema objects that contradict their parent schema definitions</li>
            <li><strong>Automated schema generation:</strong> Plugins or tools that add schema without validation</li>
          </ul>
        </div>
      </div>

      <!-- Observed Outcomes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observed Outcomes</h2>
        </div>
        <div class="content-block__body">
          <p>When schema noise occurs, we observe:</p>
          <ul>
            <li>Content disappears from AI Overviews and LLM answers despite having schema markup</li>
            <li>Structured data fails to improve citation eligibility</li>
            <li>Retrieval confidence scores remain below threshold</li>
            <li>Competitor content with clean schema replaces the noisy content</li>
            <li>Schema validation tools report errors or warnings</li>
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
          <p>To mitigate schema noise:</p>
          <ol>
            <li><strong>Use single schema type:</strong> Choose one primary schema type per page that accurately describes the content</li>
            <li><strong>Remove conflicting schemas:</strong> Eliminate duplicate or contradictory schema definitions</li>
            <li><strong>Validate schema markup:</strong> Use schema validation tools to identify conflicts and errors</li>
            <li><strong>Ensure schema accuracy:</strong> Verify that schema data matches page content exactly</li>
            <li><strong>Avoid excessive markup:</strong> Include only necessary schema properties, not every possible field</li>
            <li><strong>Monitor for conflicts:</strong> Regularly audit schema markup for contradictions or duplication</li>
          </ol>
          <p>Once schema markup is clean and unambiguous, confidence scores improve and retrieval probability increases.</p>
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

    </div>
  </section>
</main>

