<?php
// Field Notes: Perplexity
// Observational authority engine

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/field-notes/perplexity/');

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => ['@type' => 'ImageObject', '@id' => absolute_url('/') . '#logo', 'url' => absolute_url('/logo.png')],
        'sameAs' => ['https://www.linkedin.com/company/neural-command/']
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Field Notes', 'item' => absolute_url('/en-us/field-notes/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Perplexity', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Perplexity: Field Notes',
    'name' => 'Perplexity: Field Notes',
    'description' => 'Observations of Perplexity search behavior, citation patterns, and source attribution.',
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
    'dateModified' => date('Y-m-d')
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <p><a href="<?= absolute_url('/en-us/field-notes/') ?>">← Back to Field Notes</a></p>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Perplexity: Field Notes</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Observations of Perplexity search behavior, citation patterns, and source attribution.</p>
          
          <h2 class="heading-2">Search Behavior</h2>
          <p>We observed that Perplexity performs web searches automatically for all queries, integrating search results into conversational responses. Search occurs in real-time during response generation, with results retrieved and synthesized before response delivery.</p>
          
          <p>We observed that search query generation adapts to user intent. For broad queries, Perplexity generates multiple search queries to retrieve comprehensive information. For specific queries, Perplexity generates focused search queries that target precise information needs.</p>
          
          <h2 class="heading-2">Citation Patterns</h2>
          <p>We observed that citations appear as numbered references throughout responses, with each citation linking directly to source pages. Citations appear immediately after sentences or paragraphs that incorporate information from the cited source.</p>
          
          <p>We observed that citation frequency correlates with information density. Responses that synthesize information from multiple sources show 5-12 citations on average. Responses that draw primarily from a single source show 1-3 citations.</p>
          
          <p>We observed that citations appear for both direct quotes and synthesized information. When information is paraphrased or synthesized from a source, citations still appear, maintaining attribution even when exact wording is not preserved.</p>
          
          <h2 class="heading-2">Source Attribution</h2>
          <p>We observed that source attribution includes domain names, page titles, and publication dates when available. Citation formatting shows source credibility signals: established domains receive full attribution, while newer or less-established domains may show abbreviated attribution.</p>
          
          <p>We observed that source selection shows preference for authoritative domains across query types. Educational institutions, established news sources, and recognized industry publications receive citations more frequently than personal blogs or commercial landing pages.</p>
          
          <p>We observed that source recency influences selection for time-sensitive topics. For queries about current events or recent developments, sources published within the past 30 days receive citations more frequently than older sources covering the same topic.</p>
          
          <h2 class="heading-2">Answer Composition</h2>
          <p>We observed that responses synthesize information from 3-8 sources on average. Synthesis patterns show clear information integration: facts from multiple sources are combined into coherent paragraphs, with citations appearing after the integrated content.</p>
          
          <p>We observed that response structure adapts to query type. Factual queries produce paragraph-form responses with embedded citations. Comparative queries produce structured lists with citations after each comparison point. How-to queries produce step-by-step formats with citations after relevant steps.</p>
          
          <h2 class="heading-2">Constraints and Conditions</h2>
          <p>These observations were recorded using Perplexity Pro and free tiers across desktop and mobile interfaces during Q4 2024. Behavior may vary across different subscription tiers, model versions, or interface implementations.</p>
          
          <p>All observations document behavior under standard usage conditions. Behavior during system updates, model changes, or technical incidents may differ.</p>
        </div>
      </div>
      
    </div>
  </section>
</main>