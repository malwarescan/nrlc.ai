<?php
// Glossary Entry: Generative Search Terms
// Core terminology for generative search and AI-mediated search environments

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/glossary/generative-search-terms/');

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
          'url' => absolute_url('/assets/images/nrlc-logo.png')
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
        'name' => 'Generative Search Terms',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // DefinedTerm
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTerm',
    '@id' => $canonicalUrl . '#term',
    'name' => 'Generative Search Terms',
    'description' => 'Core terminology for generative search, AI-mediated search environments, and generative engine optimization.',
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
          <h1 class="content-block__title heading-1">Generative Search Terms</h1>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Generative search terms are the core terminology used to describe search systems that generate answers using AI, rather than simply ranking existing web pages. These terms define how generative engines retrieve, process, and cite content.</p>
          </div>
          
          <h2 class="heading-2">Core Terms</h2>
          
          <h3 class="heading-3">Generative Search</h3>
          <p>Search systems that use generative AI to create answers from retrieved content segments, rather than only ranking pages. Examples include Google AI Overviews, ChatGPT web search, and Perplexity answers.</p>
          
          <h3 class="heading-3">Generative Engine</h3>
          <p>The AI system that powers generative search. It performs five operations: query interpretation, candidate document selection, segment extraction, segment scoring, and answer generation with citation.</p>
          
          <h3 class="heading-3">AI-Mediated Search</h3>
          <p>Search environments where AI systems act as intermediaries between user queries and web content. The AI retrieves segments, evaluates them, and generates responses rather than directly linking to pages.</p>
          
          <h3 class="heading-3">Segment-Level Retrieval</h3>
          <p>The process by which generative engines extract and evaluate individual content segments (paragraphs, sections) rather than entire pages. Segments are scored independently for relevance, authority, and citation eligibility.</p>
          
          <h3 class="heading-3">Citation Eligibility</h3>
          <p>The threshold condition a content segment must meet to be cited verbatim in an AI-generated answer. Eligibility requires high confidence scores, atomic structure, and clear attribution sources.</p>
          
          <h2 class="heading-2">Key Distinctions</h2>
          
          <h3 class="heading-3">Retrieval vs Ranking</h3>
          <p><strong>Ranking</strong> determines page-level visibility in traditional search results. <strong>Retrieval</strong> determines segment-level visibility in AI-generated answers. A high-ranking page may be ignored if its segments are ambiguous or context-dependent.</p>
          
          <h3 class="heading-3">Page-Level vs Segment-Level Optimization</h3>
          <p>Traditional SEO optimizes at the page level (title tags, meta descriptions, overall content quality). Generative Engine Optimization (GEO) optimizes at the segment level (atomic chunks, self-contained facts, citation-ready statements).</p>
          
          <h2 class="heading-2">Related Concepts</h2>
          <ul>
            <li><strong><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision Traces</a>:</strong> Observable records of how generative AI systems evaluate content segments</li>
            <li><strong>Context Graphs:</strong> Emergent knowledge structures formed by accumulated decision traces and retrieval patterns</li>
            <li><strong>Confidence Scoring:</strong> The mechanism generative engines use to evaluate segment quality and citation eligibility</li>
            <li><strong>Atomic Content:</strong> Self-contained segments that can be understood and cited independently of surrounding context</li>
          </ul>
          
          <h2 class="heading-2">Full Guide</h2>
          <p>For complete explanations of how generative search works, see <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a>.</p>
        </div>
      </div>

    </div>
  </section>
</main>
