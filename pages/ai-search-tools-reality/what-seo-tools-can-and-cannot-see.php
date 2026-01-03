<?php
// What SEO Tools Can and Cannot See
// Honest assessment of tool capabilities

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-tools-reality/what-seo-tools-can-and-cannot-see/');

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
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'The Limits of SEO Tooling in AI Search', 'item' => absolute_url('/en-us/ai-search-tools-reality/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'What SEO Tools Can and Cannot See', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'What SEO Tools Can and Cannot See',
    'name' => 'What SEO Tools Can and Cannot See',
    'description' => 'Honest assessment of what SEO tools can observe in AI-mediated search.',
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
        <p><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>">← Back to The Limits of SEO Tooling in AI Search</a></p>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">What SEO Tools Can and Cannot See</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Honest assessment of what SEO tools can observe in AI-mediated search.</p>
          
          <h2 class="heading-2">What Tools Can See</h2>
          
          <h3 class="heading-3">Traditional Search Metrics</h3>
          <p>SEO tools can observe traditional search metrics reliably: organic search rankings, click-through rates from search results, and indexed page counts. These metrics reflect behavior in traditional Google Search results where tools have established data collection methods.</p>
          
          <h3 class="heading-3">Technical Signals</h3>
          <p>Tools can observe technical signals that are publicly accessible: crawlability, indexing status, structured data markup, page load speeds, and mobile responsiveness. These signals are measurable through standard web protocols and APIs.</p>
          
          <h3 class="heading-3">Content Analysis</h3>
          <p>Tools can analyze on-page content: keyword density, content length, heading structure, internal linking patterns, and content updates. Content analysis works because tools can crawl and parse HTML content directly.</p>
          
          <h2 class="heading-2">What Tools Cannot See</h2>
          
          <h3 class="heading-3">AI Overview Citations</h3>
          <p>SEO tools cannot reliably track when and how often pages appear in Google AI Overviews. AI Overviews appear dynamically, vary by user context, and do not expose citation data through standard APIs. Tools cannot observe AI Overview citation frequency, placement, or context.</p>
          
          <h3 class="heading-3">Answer Engine Visibility</h3>
          <p>Tools cannot measure visibility in answer engines like ChatGPT, Perplexity, or Claude. These systems do not provide APIs for tracking citation frequency, and their retrieval mechanisms operate differently than traditional search. Tools cannot observe answer engine retrieval patterns or citation rates.</p>
          
          <h3 class="heading-3">Retrieval Context</h3>
          <p>Tools cannot observe the context in which AI systems retrieve content. When a page is cited in an AI response, tools cannot see the query that triggered the citation, the user context that influenced retrieval, or the reasoning that led to source selection.</p>
          
          <h3 class="heading-3">Synthesis Patterns</h3>
          <p>Tools cannot observe how AI systems synthesize information from multiple sources. When multiple pages contribute to a single AI response, tools cannot see which pages were used together, how information was combined, or which sources received primary attribution.</p>
          
          <h2 class="heading-2">Why This Matters</h2>
          <p>Understanding tool limitations prevents false expectations. If a page appears in AI Overviews but tools show no visibility, the tools are not broken—they simply cannot observe AI-mediated search behavior. Setting realistic expectations builds credibility and helps teams focus on measurable signals.</p>
          
          <p>Teams should use tools for what they measure well: traditional search rankings, technical signals, and content analysis. For AI-mediated search visibility, teams need observational methods and manual monitoring, not automated tool data.</p>
          
          <h2 class="heading-2">Related Topics</h2>
          <ul>
            <li><a href="<?= absolute_url('/en-us/ai-search-tools-reality/limitations-of-ai-visibility-tools/') ?>">Limitations of AI Visibility Tools</a> — Why AI visibility tools provide incomplete data</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-tools-reality/why-ai-search-data-is-incomplete/') ?>">Why AI Search Data Is Incomplete</a> — Technical reasons for data gaps</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> — What can be measured in AI search</li>
          </ul>
        </div>
      </div>
      
    </div>
  </section>
</main>