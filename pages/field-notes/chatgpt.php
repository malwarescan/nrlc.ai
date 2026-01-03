<?php
// Field Notes: ChatGPT
// Observational authority engine

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/field-notes/chatgpt/');

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
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'ChatGPT', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'ChatGPT: Field Notes',
    'name' => 'ChatGPT: Field Notes',
    'description' => 'Observations of ChatGPT web retrieval, citation behavior, and source selection.',
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
          <h1 class="content-block__title heading-1">ChatGPT: Field Notes</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Observations of ChatGPT web retrieval, citation behavior, and source selection.</p>
          
          <h2 class="heading-2">Web Retrieval Behavior</h2>
          <p>We observed that ChatGPT retrieves web content when users enable web browsing functionality. Retrieval occurs automatically when queries require current information, recent events, or real-time data that exceeds the training data cutoff.</p>
          
          <p>We observed that retrieval frequency varies by query type. Factual queries about current events trigger retrieval more frequently than conceptual queries or general knowledge questions that can be answered from training data.</p>
          
          <h2 class="heading-2">Citation Behavior</h2>
          <p>We observed that citations appear as numbered references when web content is retrieved and synthesized into responses. Citations link directly to source pages and appear at the end of relevant paragraphs or sentences that incorporate retrieved information.</p>
          
          <p>We observed that citation placement follows information synthesis patterns. When multiple sources contribute to a single response, citations cluster near the synthesized information rather than appearing after each individual source contribution.</p>
          
          <p>We observed that citations do not appear when responses rely solely on training data, even when that data overlaps with publicly available web content.</p>
          
          <h2 class="heading-2">Source Selection</h2>
          <p>We observed that source selection prioritizes authoritative domains across multiple query types. Established news sources, educational institutions, and recognized industry publications receive citations more frequently than personal blogs or unverified sources.</p>
          
          <p>We observed that source recency influences selection for time-sensitive queries. For queries about recent events, sources published within the past 7 days receive citations more frequently than older sources covering the same topic.</p>
          
          <p>We observed that source selection shows preference for comprehensive coverage. Pages that address multiple aspects of a query receive citations more frequently than pages that address only one aspect, even when both sources contain accurate information.</p>
          
          <h2 class="heading-2">Content Integration</h2>
          <p>We observed that retrieved content is synthesized rather than quoted verbatim. Responses incorporate information from multiple sources into coherent paragraphs, with citations appearing after the synthesized content.</p>
          
          <p>We observed that synthesis maintains source attribution boundaries. When information from multiple sources is combined, citations for all contributing sources appear together, typically at the end of the synthesized paragraph.</p>
          
          <h2 class="heading-2">Constraints and Conditions</h2>
          <p>These observations were recorded using ChatGPT with web browsing enabled (GPT-4 models) during Q4 2024. Behavior may vary across different model versions, subscription tiers, or interface implementations.</p>
          
          <p>All observations document behavior under standard usage conditions. Behavior during system updates, model changes, or technical incidents may differ.</p>
        </div>
      </div>
      
    </div>
  </section>
</main>