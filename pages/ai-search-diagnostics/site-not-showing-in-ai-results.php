<?php
// AI Search Diagnostics: Site Not Showing in AI Results
// Symptom-first diagnostic guide

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-diagnostics/site-not-showing-in-ai-results/');

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
        'name' => 'AI Search Diagnostics',
        'item' => absolute_url('/en-us/ai-search-diagnostics/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Site Not Showing in AI Results',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Site Not Showing in AI Results: Diagnostic Guide',
    'name' => 'Site Not Showing in AI Results',
    'description' => 'Diagnose why your site is not appearing in AI-generated answers, AI Overviews, or LLM citations.',
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
      
      <!-- Back Link -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <p><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">← Back to AI Search Diagnostics</a></p>
      </div>

      <!-- Hero Block -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Site Not Showing in AI Results</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Diagnose why your site is not appearing in AI-generated answers, AI Overviews, or LLM citations.</p>
        </div>
      </div>

      <!-- What the System Is Doing -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the System Is Doing</h2>
        </div>
        <div class="content-block__body">
          <p>Your site is indexed by search engines, but does not appear in:</p>
          <ul>
            <li>Google AI Overviews</li>
            <li>ChatGPT web search results</li>
            <li>Perplexity citations</li>
            <li>Other LLM-generated answers</li>
          </ul>
          <p>Traditional search rankings may be stable or even improving, but AI systems are not retrieving your content.</p>
        </div>
      </div>

      <!-- Why the Symptom Appears -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why the Symptom Appears</h2>
        </div>
        <div class="content-block__body">
          <p>This behavior is explained by <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">decision traces in generative search</a>. When content cannot be cleanly segmented or lacks atomic, self-contained answers, generative engines create negative decision traces—records that the content failed confidence or relevance thresholds.</p>
          <p>Generative engines retrieve content at the segment level, not the page level. If your content cannot be cleanly segmented or lacks atomic, self-contained answers, it will not be retrieved even if the page ranks well.</p>
          <p>Common root causes:</p>
          <ul>
            <li>Content is not prechunked for independent retrieval</li>
            <li>Segments lack clear question-answer structure</li>
            <li>Content depends on page context to make sense</li>
            <li>Headers are vague or abstract rather than query-shaped</li>
            <li>Chunks are too long or contain multiple ideas</li>
          </ul>
        </div>
      </div>

      <!-- Which Failure Mode It Maps To -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Which Failure Mode It Maps To</h2>
        </div>
        <div class="content-block__body">
          <p>This symptom typically maps to:</p>
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes Index</a> — See "Content Not Retrievable" patterns</li>
            <li>Lack of atomic content structure</li>
            <li>Missing prechunking implementation</li>
          </ul>
        </div>
      </div>

      <!-- Diagnostic Steps -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Diagnostic Steps</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li><strong>Check content structure:</strong> Can each section stand alone if extracted?</li>
            <li><strong>Verify headers:</strong> Do headers match actual search queries?</li>
            <li><strong>Test atomicity:</strong> Copy a random paragraph—does it make sense without context?</li>
            <li><strong>Check chunk size:</strong> Are sections 40-120 words with one idea each?</li>
            <li><strong>Review prechunking:</strong> Was content structured before writing for retrieval?</li>
          </ol>
        </div>
      </div>

      <!-- Mitigation Path -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Path</h2>
        </div>
        <div class="content-block__body">
          <p>To resolve this issue:</p>
          <ol>
            <li>Restructure content using the <a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">NRLC Prechunking Framework</a></li>
            <li>Ensure each section answers exactly one question</li>
            <li>Make headers query-shaped and deterministic</li>
            <li>Remove narrative glue and dependencies between sections</li>
            <li>Test each chunk for independent citation eligibility</li>
          </ol>
          <p>See <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> for foundational mechanics.</p>
        </div>
      </div>

      <!-- Implementation Support (Contextual) -->
      <div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-8);">
        <div class="content-block__body">
          <p style="font-size: 0.95rem; color: #666; margin: 0;">
            If these conditions describe your system, the issue is structural rather than tactical. Some teams address this internally. Others ask for help implementing the changes described above across large or high risk sites.
          </p>
          <p style="margin-top: var(--spacing-sm); margin-bottom: 0;">
            <a href="<?= absolute_url('/implementation/') ?>" style="font-size: 0.95rem;">Implementation Support</a>
          </p>
        </div>
      </div>

    </div>
  </section>
</main>

