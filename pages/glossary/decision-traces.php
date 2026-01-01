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
            <p>A decision trace is an inferred representation of how a generative system evaluates competing content configurations and arrives at a confidence judgment. Decision traces are not stored artifacts or telemetry logs—they are reconstructed through repetition, revealing how the same structural conditions reliably produce the same outcomes across queries and time.</p>
          </div>
          
          <p>When the same structural conditions reliably produce the same outcome across queries and time, the system is revealing its judgment indirectly. That revealed judgment is the decision trace. Decision traces explain why certain failures persist despite surface changes, and why certain fragments become default references across varied contexts.</p>
          
          <p>For a complete explanation of how decision traces work in generative search, see <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision Traces in Generative Search</a>.</p>
        </div>
      </div>

    </div>
  </section>
</main>

