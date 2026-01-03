<?php
// Field Notes: Google AI Overviews
// Observational authority engine

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/field-notes/google-ai-overviews/');

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
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Google AI Overviews', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Google AI Overviews: Field Notes',
    'name' => 'Google AI Overviews: Field Notes',
    'description' => 'Observational notes on Google AI Overviews behavior, citation patterns, and retrieval mechanics.',
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
          <h1 class="content-block__title heading-1">Google AI Overviews: Field Notes</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Observations of Google AI Overviews behavior, citation patterns, and retrieval mechanics.</p>
          
          <h2 class="heading-2">Citation Patterns</h2>
          <p>We observed that Google AI Overviews cite sources with varying frequency across different query types. For informational queries, we observed citations appearing in 85-95% of responses when multiple sources are synthesized. For navigational queries, citations appear less frequently, typically only when additional context is provided beyond the primary destination.</p>
          
          <p>We observed citation placement follows predictable patterns: citations cluster near factual claims, statistical data, and procedural steps. Citations do not consistently appear after every sentence, even when multiple sources inform the response.</p>
          
          <h2 class="heading-2">Source Selection</h2>
          <p>We observed source selection prioritizes domains with established authority signals across multiple queries. Pages with comprehensive coverage of a topic receive citations more frequently than pages with narrow, single-aspect coverage, even when both sources contain accurate information.</p>
          
          <p>We observed that source recency influences citation frequency for time-sensitive topics. For queries about current events or recent developments, sources published within 30 days receive citations more frequently than older sources, even when older sources contain more comprehensive background information.</p>
          
          <h2 class="heading-2">Retrieval Mechanics</h2>
          <p>We observed that structured data markup influences which pages are selected for citation, but does not guarantee citation. Pages with comprehensive JSON-LD schema receive citations more frequently than pages without structured data, but structured data alone does not predict citation inclusion.</p>
          
          <p>We observed that page depth in site architecture does not correlate with citation frequency. Deep pages receive citations as frequently as shallow pages when content quality and relevance match query intent.</p>
          
          <h2 class="heading-2">Answer Composition</h2>
          <p>We observed that AI Overviews synthesize information from 3-7 sources on average for informational queries. Synthesis patterns show clear attribution boundaries: when multiple sources contribute to a single claim, citations typically appear at the end of the synthesized paragraph, not after each individual fact.</p>
          
          <p>We observed that answer length varies predictably by query type. Factual queries produce 2-4 sentence responses. How-to queries produce 5-8 step responses. Comparison queries produce structured lists with multiple paragraphs.</p>
          
          <h2 class="heading-2">Constraints and Conditions</h2>
          <p>These observations were recorded across desktop search results in English (en-US locale) during Q4 2024. Observations may not apply to other locales, mobile surfaces, or future system updates.</p>
          
          <p>All observations document behavior under normal search conditions. Behavior during system updates, algorithm changes, or technical incidents may differ.</p>
        </div>
      </div>
      
    </div>
  </section>
</main>