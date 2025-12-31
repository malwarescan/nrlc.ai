<?php
// Glossary Entry: Decision Traces
// Short, explicit, definition-only page

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/glossary/decision-traces/');

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
        'name' => 'Glossary',
        'item' => absolute_url('/en-us/glossary/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Decision Traces',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // DefinedTerm
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTerm',
    '@id' => $canonicalUrl . '#term',
    'name' => 'Decision Trace',
    'description' => 'The observable record of a generative AI system\'s judgment about content. When an AI system retrieves, cites, or suppresses a content segment, that action creates a trace.',
    'url' => $canonicalUrl,
    'inDefinedTermSet' => [
      '@type' => 'DefinedTermSet',
      'name' => 'AI Search Glossary',
      'url' => absolute_url('/en-us/glossary/')
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Back Link -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/en-us/glossary/') ?>">← Back to Glossary</a></p>
        </div>
      </div>

      <!-- Definition -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Decision Trace</h1>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>A decision trace is the observable record of a generative AI system's judgment about content. When an AI system retrieves, cites, or suppresses a content segment, that action creates a trace.</p>
          </div>
          
          <h2 class="heading-2">Key Characteristics</h2>
          <ul>
            <li><strong>Records judgments, not events:</strong> Traces document why decisions were made, not just that they occurred</li>
            <li><strong>Preserves context:</strong> Each trace includes the conditions that produced the decision</li>
            <li><strong>Accumulates into patterns:</strong> Multiple traces form patterns that influence future decisions</li>
            <li><strong>Enables context graph formation:</strong> Accumulated traces create emergent knowledge structures</li>
          </ul>
          
          <h2 class="heading-2">Decision Trace Elements</h2>
          <p>Each trace contains three elements:</p>
          <ul>
            <li><strong>The content segment:</strong> What was evaluated</li>
            <li><strong>The decision:</strong> Retrieve, cite, or suppress</li>
            <li><strong>The confidence level:</strong> How certain the system was</li>
          </ul>
          
          <h2 class="heading-2">Related Concepts</h2>
          <ul>
            <li><strong>Retrieval decisions:</strong> Traces that record when segments meet confidence thresholds</li>
            <li><strong>Citation decisions:</strong> Traces that record when segments are judged authoritative</li>
            <li><strong>Suppression decisions:</strong> Traces that record when segments fail confidence or relevance thresholds</li>
            <li><strong>Context graphs:</strong> Emergent knowledge structures formed by accumulated decision traces</li>
          </ul>
          
          <h2 class="heading-2">Full Article</h2>
          <p>For a complete explanation of how decision traces work in generative search, see <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision Traces in Generative Search</a>.</p>
        </div>
      </div>

    </div>
  </section>
</main>

