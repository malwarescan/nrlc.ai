<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is loaded automatically by router before head.php is included
require_once __DIR__ . '/../../lib/csv.php';
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

// Load insights data
$insights = csv_read_data('insights.csv');
$featured_insights = array_slice($insights, -6); // Get last 6 insights

// Get canonical URL and domain
$canonicalUrl = absolute_url('/insights/');
$domain = absolute_url('/');

// Get organization ID for schema
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps($domain) . '#organization';
$personId = SchemaFixes::ensureHttps($domain) . '#joel-maldonado';

// Build comprehensive schema for insights hub
if (!isset($GLOBALS['__jsonld']) || !is_array($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

// Person schema (Joel Maldonado as researcher/author)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Person',
  '@id' => $personId,
  'name' => 'Joel Maldonado',
  'givenName' => 'Joel',
  'familyName' => 'Maldonado',
  'jobTitle' => 'Founder & AI Search Researcher',
  'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
  'knowsAbout' => [
    'AI Search Optimization', 'AEO', 'GEO', 'AI Retrieval Research',
    'Citation Analysis', 'Structured Data Research', 'AI SEO Insights',
    'ChatGPT Research', 'Perplexity Research', 'Google AI Overviews Research',
    'Retrieval Mechanics', 'Citation Behavior', 'AI Search Systems'
  ],
  'worksFor' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'affiliation' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'url' => $domain,
  'sameAs' => [
    'https://www.linkedin.com/company/neural-command/',
    'https://twitter.com/neuralcommand',
    'https://www.crunchbase.com/person/joel-maldonado'
  ]
];

// CollectionPage schema (PRIMARY - This is a content collection)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  '@id' => $canonicalUrl . '#collection',
  'name' => 'AI Search & Retrieval Insights',
  'description' => 'Technical analyses and research-backed explanations of how AI search and answer engines extract, evaluate, and cite web content.',
  'url' => $canonicalUrl,
  'inLanguage' => 'en-US',
  'datePublished' => '2024-01-01',
  'dateModified' => date('Y-m-d'),
  'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'AI search insights, AI retrieval research, AI citation analysis, ChatGPT research, Perplexity research, Google AI Overviews research, AEO research, GEO research, structured data research',
  'about' => [
    [
      '@type' => 'Thing',
      'name' => 'AI Search Research',
      'description' => 'Research and analysis of AI search systems, retrieval mechanics, and citation behavior'
    ],
    [
      '@type' => 'Thing',
      'name' => 'Retrieval Mechanics',
      'description' => 'The technical processes by which AI systems extract, chunk, prioritize, and ground content from web sources'
    ],
    [
      '@type' => 'Thing',
      'name' => 'Citation Analysis',
      'description' => 'Analysis of how AI systems cite and attribute web content in their responses'
    ]
  ],
  'mentions' => [
    [
      '@type' => 'SoftwareApplication',
      'name' => 'ChatGPT',
      'description' => 'AI language model by OpenAI'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Perplexity',
      'description' => 'AI-powered search engine'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Google AI Overviews',
      'description' => 'Google\'s AI-powered search overview feature'
    ]
  ],
  'author' => [
    '@type' => 'Person',
    '@id' => $personId
  ],
  'publisher' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => $domain . '#website'
  ],
  'speakable' => [
    '@type' => 'SpeakableSpecification',
    'cssSelector' => ['h1', '.lead']
  ],
  'mainEntity' => [
    '@type' => 'ItemList',
    '@id' => $canonicalUrl . '#article-list',
    'name' => 'AI Search & Retrieval Insights Articles',
    'description' => 'Collection of technical analyses and research on AI search systems',
    'numberOfItems' => count($insights),
    'itemListElement' => array_map(function($insight, $index) use ($canonicalUrl) {
      $insightUrl = absolute_url('/en-us/insights/' . $insight['slug'] . '/');
      return [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'item' => [
          '@type' => 'Article',
          '@id' => $insightUrl . '#article',
          'headline' => $insight['title'] ?? '',
          'description' => $insight['excerpt'] ?? $insight['keywords'] ?? '',
          'url' => $insightUrl
        ]
      ];
    }, array_reverse($insights), array_keys(array_reverse($insights)))
  ]
];

// WebPage schema (ENHANCED)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => $GLOBALS['__page_meta']['title'] ?? 'AI Search & Retrieval Insights | Research & Analysis | NRLC.ai',
  'url' => $canonicalUrl,
  'description' => $GLOBALS['__page_meta']['description'] ?? 'Technical analyses and research-backed explanations of how AI search and answer engines extract, evaluate, and cite web content.',
  'inLanguage' => 'en-US',
  'datePublished' => '2024-01-01',
  'dateModified' => date('Y-m-d'),
  'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'AI search insights, AI retrieval research, AI citation analysis, ChatGPT research, Perplexity research, Google AI Overviews research',
  'about' => [
    [
      '@type' => 'Thing',
      'name' => 'AI Search Research',
      'description' => 'Research and analysis of AI search systems, retrieval mechanics, and citation behavior'
    ],
    [
      '@type' => 'Thing',
      'name' => 'Retrieval Mechanics',
      'description' => 'The technical processes by which AI systems extract, chunk, prioritize, and ground content from web sources'
    ]
  ],
  'mentions' => [
    [
      '@type' => 'SoftwareApplication',
      'name' => 'ChatGPT',
      'description' => 'AI language model by OpenAI'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Perplexity',
      'description' => 'AI-powered search engine'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Google AI Overviews',
      'description' => 'Google\'s AI-powered search overview feature'
    ]
  ],
  'author' => [
    '@type' => 'Person',
    '@id' => $personId
  ],
  'publisher' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => $domain . '#website'
  ],
  'speakable' => [
    '@type' => 'SpeakableSpecification',
    'cssSelector' => ['h1', '.lead']
  ]
];

// Thing schemas for key concepts
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Thing',
  'name' => 'AI Search Research',
  'description' => 'Research and analysis of AI search systems, retrieval mechanics, and citation behavior'
];
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Thing',
  'name' => 'Retrieval Mechanics',
  'description' => 'The technical processes by which AI systems extract, chunk, prioritize, and ground content from web sources'
];
?>

<main role="main" class="container" itemscope itemtype="https://schema.org/CollectionPage">
<article itemscope itemtype="https://schema.org/Article" class="section">
  <div class="section__content">
    
    <!-- Insights Header / Intent Declaration -->
    <header class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title" itemprop="headline"><strong>AI Search</strong> & <strong>Retrieval Insights</strong></h1>
      </div>
      <div class="content-block__body">
        <p class="lead" itemprop="description">This section contains <strong>technical analyses</strong>, <strong>research-backed explanations</strong>, and <strong>system-level insights</strong> into how <strong>AI search</strong> and <strong>answer engines</strong> extract, evaluate, and cite information.</p>
        <div class="btn-group" style="margin-top: var(--spacing-lg);">
          <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" class="btn btn--secondary">Knowledge Base: GEO</a>
          <a href="<?= absolute_url('/en-us/training/') ?>" class="btn btn--secondary">Training</a>
        </div>
      </div>
    </header>

    <!-- RESEARCH AREAS DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
    <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Key Research Areas: <strong>AI Search</strong>, <strong>Retrieval Mechanics</strong>, and <strong>Citation Analysis</strong></h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt id="ai-search-research" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>AI Search Research</strong></dfn>
          </dt>
          <dd itemprop="description">
            Technical analyses of how <strong>AI search systems</strong> (<strong>ChatGPT</strong>, <strong>Perplexity</strong>, <strong>Google AI Overviews</strong>) retrieve, evaluate, and cite web content. This research covers <strong>retrieval mechanics</strong>, <strong>citation behavior</strong>, <strong>grounding budgets</strong>, <strong>entity resolution</strong>, and <strong>trust scoring</strong> in AI-mediated search environments.
          </dd>
          
          <dt id="retrieval-mechanics" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Retrieval Mechanics</strong></dfn>
          </dt>
          <dd itemprop="description">
            The technical processes by which <strong>AI systems</strong> extract, chunk, prioritize, and ground content from web sources. This includes <strong>semantic retrieval</strong>, <strong>query-document matching</strong>, <strong>relevance scoring</strong>, <strong>content compression</strong>, and <strong>citation anchor identification</strong>. Understanding retrieval mechanics enables optimization for <strong>AI search visibility</strong> and <strong>citation accuracy</strong>.
          </dd>
          
          <dt id="citation-analysis" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Citation Analysis</strong></dfn>
          </dt>
          <dd itemprop="description">
            Analysis of how <strong>AI systems</strong> cite and attribute web content in their responses. This research examines <strong>citation patterns</strong>, <strong>source selection criteria</strong>, <strong>attribution accuracy</strong>, and <strong>citation suppression factors</strong>. Citation analysis reveals why some content is cited frequently while other content is ignored, regardless of traditional <abbr title="Search Engine Optimization">SEO</abbr> rankings.
          </dd>
        </dl>
      </div>
    </section>

    <!-- Featured Analysis -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Featured Analysis</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          
          <div class="content-block">
            <h3 class="content-block__title">Semantic Queries & Query Optimization</h3>
            <p>Explains how <strong>semantic relationships</strong> collapse query complexity and reduce time to value. Technical breakdown of how traditional <strong>SQL queries</strong> with dozens of <strong>JOINs</strong> become concise, <strong>relationship-aware logic</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/insights/semantic-queries/') ?>" class="btn">Read Analysis</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Performance & Caching Insights</h3>
            <p>Explains <strong>intelligent pushdown optimization</strong>, <strong>query performance tuning</strong>, and <strong>caching engines</strong> that reduce compute spend while maintaining query speed and accuracy.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/insights/performance-caching/') ?>" class="btn">Read Analysis</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Data Virtualization Best Practices</h3>
            <p>Explains how to connect every source into a <strong>semantic, virtualized layer</strong> with no ingestion or duplication. Covers <strong>automatic mapping</strong>, <strong>federated queries</strong>, and <strong>unified graph views</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/insights/data-virtualization/') ?>" class="btn">Read Analysis</a>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Technical Breakdowns -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Technical Breakdowns</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          
          <div class="content-block">
            <h3 class="content-block__title">Enterprise LLM Foundation</h3>
            <p>Explains how to build reliable <strong>AI workflows</strong> on <strong>structured understanding</strong>. Technical analysis of <strong>structured semantic context</strong>, <strong>verified relationships</strong>, and <strong>virtualized access</strong> for trustworthy <strong>LLM operations</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/insights/enterprise-llm/') ?>" class="btn">Read Analysis</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Knowledge Graph Exploration</h3>
            <p>Explains interactive <strong>knowledge graph</strong> techniques for traversing relationships, surfacing insights, and generating <strong>SQL</strong> or <strong>natural-language queries</strong> automatically.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/insights/knowledge-graph/') ?>" class="btn">Read Analysis</a>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Research & Systems -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Research & Systems</h2>
      </div>
      <div class="content-block__body">
        <p>Technical analyses spanning multiple domains within <strong>AI search</strong> and <strong>retrieval systems</strong>, from <strong>extraction mechanics</strong> to <strong>citation behavior</strong>.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem; background: #f8f8f8; border: 1px solid #e0e0e0; border-radius: 4px;">
            <h4 style="margin-top: 0;"><strong>Semantic Layer Architecture</strong></h4>
            <p><strong>SQL-native ontologies</strong>, <strong>reusable logic</strong>, <strong>metrics</strong>, <strong>hierarchies</strong>, and <strong>automated reasoning</strong> across <strong>knowledge graphs</strong>.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8; border: 1px solid #e0e0e0; border-radius: 4px;">
            <h4 style="margin-top: 0;"><strong>Data Virtualization</strong></h4>
            <p><strong>Federated queries</strong>, <strong>intelligent pushdown</strong>, <strong>caching strategies</strong>, and <strong>unified graph views</strong> across all data sources.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8; border: 1px solid #e0e0e0; border-radius: 4px;">
            <h4 style="margin-top: 0;"><strong>AI Workflow Optimization</strong></h4>
            <p>Building reliable <strong>LLM workflows</strong>, <strong>GraphRAG</strong> implementation, <strong>NL2SQL</strong> generation, and <strong>structured semantic context</strong> for <strong>AI</strong>.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8; border: 1px solid #e0e0e0; border-radius: 4px;">
            <h4 style="margin-top: 0;"><strong>Query Performance</strong></h4>
            <p><strong>Semantic query optimization</strong>, <strong>relationship-aware logic</strong>, <strong>query complexity reduction</strong>, and <strong>performance tuning strategies</strong>.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Additional Insights -->
    <?php if (!empty($featured_insights)): ?>
    <section class="content-block module" itemscope itemtype="https://schema.org/ItemList">
      <div class="content-block__header">
        <h2 class="content-block__title">Additional Insights</h2>
      </div>
      <div class="content-block__body">
        <ul style="list-style: none; padding: 0;" itemprop="itemListElement">
          <?php foreach (array_reverse($featured_insights) as $index => $insight): ?>
            <li itemscope itemtype="https://schema.org/ListItem" style="padding: 1rem 0; border-bottom: 1px solid #e0e0e0;">
              <meta itemprop="position" content="<?= $index + 1 ?>">
              <h3 class="content-block__title">
                <a href="<?= absolute_url('/en-us/insights/' . htmlspecialchars($insight['slug']) . '/') ?>" style="text-decoration: none; color: inherit;" itemprop="item">
                  <span itemprop="name"><?= htmlspecialchars($insight['title']) ?></span>
                </a>
              </h3>
              <?php if (!empty($insight['excerpt'])): ?>
                <p style="margin: 0 0 0.5rem 0; font-size: 0.9375rem;" itemprop="description">
                  <?= htmlspecialchars($insight['excerpt']) ?>
                </p>
              <?php elseif (!empty($insight['keywords'])): ?>
                <p style="margin: 0 0 0.5rem 0; font-size: 0.9375rem;">
                  <?= htmlspecialchars(substr($insight['keywords'], 0, 150)) ?>
                </p>
              <?php endif; ?>
              <a href="<?= absolute_url('/en-us/insights/' . htmlspecialchars($insight['slug']) . '/') ?>" class="btn" style="display: inline-block;">Read Analysis</a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <?php endif; ?>

    <!-- Related Research Links -->
    <section class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-xl);">
      <div class="content-block__body">
        <h2 class="heading-2" style="margin-top: 0;">Related Research & Resources</h2>
        <p>Explore related research areas and implementation resources:</p>
        <div class="btn-group" style="margin-top: var(--spacing-md);">
          <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" class="btn btn--secondary">Generative Engine Optimization</a>
          <a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>" class="btn btn--secondary">AI Search Diagnostics</a>
          <a href="<?= absolute_url('/en-us/training/') ?>" class="btn btn--secondary">Training</a>
          <a href="<?= absolute_url('/en-us/implementation/') ?>" class="btn btn--secondary">Implementation Support</a>
        </div>
      </div>
    </section>

  </div>
</article>
</section>
</main>

<?php
// Note: base_schemas() in templates/head.php provides Organization, WebSite, BreadcrumbList
// This page adds: CollectionPage, Person, ItemList, WebPage (enhanced), Thing schemas
// All schemas are properly structured and compliant
?>
