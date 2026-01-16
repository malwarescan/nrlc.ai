<?php
// Glossary Pillar Page
// Entity anchor for terminology

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/en-us/glossary/');
$domain = absolute_url('/');
$orgId = SchemaFixes::ensureHttps($domain) . '#organization';
$personId = SchemaFixes::ensureHttps($domain) . '#joel-maldonado';

// Enhance metadata with keywords
if (isset($GLOBALS['__page_meta']) && is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'AI search glossary, generative search terminology, AI search definitions, decision traces, extractability, inference context stability, confidence band filtering, compression integrity, retrieval failure patterns, AI search terms, LLM terminology, AI-mediated search, generative engine optimization terms';
}

$glossarySections = [
  [
    'slug' => 'decision-traces',
    'name' => 'Decision Traces',
    'description' => 'The observable record of how generative AI systems decide what to retrieve, cite, or suppress.'
  ],
  [
    'slug' => 'extractability',
    'name' => 'Extractability',
    'description' => 'The degree to which content can be isolated and reused by generative systems without semantic loss or ambiguity.'
  ],
  [
    'slug' => 'inference-context-stability',
    'name' => 'Inference Context Stability',
    'description' => 'Whether a generative system infers the same meaning from content segments across different prompts, queries, and retrieval contexts.'
  ],
  [
    'slug' => 'confidence-band-filtering',
    'name' => 'Confidence Band Filtering',
    'description' => 'How generative systems exclude content that falls below an internal confidence threshold for reuse.'
  ],
  [
    'slug' => 'compression-integrity',
    'name' => 'Compression Integrity',
    'description' => 'Whether content segments preserve their meaning when generative systems compress them for inference and reuse.'
  ],
  [
    'slug' => 'generative-search-terms',
    'name' => 'Generative Search Terms',
    'description' => 'Core terminology for generative search and AI-mediated search environments.'
  ],
  [
    'slug' => 'retrieval-failure-patterns',
    'name' => 'Retrieval Failure Patterns',
    'description' => 'Terms and definitions for failure patterns in generative retrieval.'
  ],
  [
    'slug' => 'ai-search-definitions',
    'name' => 'AI Search Definitions',
    'description' => 'Standard definitions for AI search concepts and mechanics.'
  ]
];

// Build comprehensive JSON-LD Schema (ENHANCED)
$GLOBALS['__jsonld'] = [
  // Person schema (Joel Maldonado)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $personId,
    'name' => 'Joel Maldonado',
    'givenName' => 'Joel',
    'familyName' => 'Maldonado',
    'jobTitle' => 'Founder & AI Search Researcher',
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in AI search terminology, retrieval mechanics, and extractability for AI-powered search engines.',
    'knowsAbout' => [
      'AI Search Glossary', 'Generative Search Terminology', 'Decision Traces',
      'Extractability', 'Inference Context Stability', 'Confidence Band Filtering',
      'Compression Integrity', 'Retrieval Failure Patterns', 'AI Search Definitions',
      'LLM Terminology', 'AI-Mediated Search'
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
  ],
  
  // Organization (site-wide anchor)
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => $orgId,
        'name' => 'Neural Command LLC',
        'url' => $domain,
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => $domain . '#logo',
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
        'item' => $domain
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Glossary',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // CollectionPage (ENHANCED)
  [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $canonicalUrl . '#page',
    'headline' => 'AI Search Glossary',
    'name' => 'AI Search Glossary',
    'description' => 'Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics. Stabilizes terminology across the site and for LLMs.',
    'url' => $canonicalUrl,
    'inLanguage' => 'en-US',
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d'),
    'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'AI search glossary, generative search terminology, AI search definitions',
    'about' => [
      [
        '@type' => 'Thing',
        'name' => 'AI Search Terminology',
        'description' => 'Standard terminology and definitions for generative search and AI-mediated search environments'
      ],
      [
        '@type' => 'Thing',
        'name' => 'Generative Search Glossary',
        'description' => 'Glossary of terms for generative search, retrieval mechanics, and AI-mediated search'
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
      '@type' => 'DefinedTermSet',
      '@id' => $canonicalUrl . '#definedtermset',
      'name' => 'AI Search Glossary',
      'description' => 'Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics',
      'hasDefinedTerm' => array_map(function($section) use ($canonicalUrl) {
        return [
          '@type' => 'DefinedTerm',
          'name' => $section['name'],
          'description' => $section['description'],
          'url' => absolute_url('/en-us/glossary/' . $section['slug'] . '/')
        ];
      }, $glossarySections)
    ]
  ],
  
  // WebPage schema (ENHANCED)
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => $GLOBALS['__page_meta']['title'] ?? 'AI Search Glossary: Terms & Definitions | NRLC.ai',
    'url' => $canonicalUrl,
    'description' => $GLOBALS['__page_meta']['description'] ?? 'Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics.',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d'),
    'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'AI search glossary, generative search terminology',
    'about' => [
      [
        '@type' => 'Thing',
        'name' => 'AI Search Terminology',
        'description' => 'Standard terminology and definitions for generative search and AI-mediated search environments'
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
  ],
  
  // DefinedTermSet schema (PRIMARY - Glossary authority)
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTermSet',
    '@id' => $canonicalUrl . '#definedtermset',
    'name' => 'AI Search Glossary',
    'description' => 'Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics. Stabilizes terminology across the site and for LLMs.',
    'url' => $canonicalUrl,
    'hasDefinedTerm' => array_map(function($section) use ($canonicalUrl) {
      return [
        '@type' => 'DefinedTerm',
        'name' => $section['name'],
        'description' => $section['description'],
        'url' => absolute_url('/en-us/glossary/' . $section['slug'] . '/')
      ];
    }, $glossarySections)
  ],
  
  // ItemList schema for glossary sections
  [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    '@id' => $canonicalUrl . '#glossary-sections',
    'name' => 'AI Search Glossary Sections',
    'description' => 'Collection of glossary sections covering decision traces, extractability, inference context stability, and other AI search terminology',
    'numberOfItems' => count($glossarySections),
    'itemListElement' => array_map(function($section, $index) use ($canonicalUrl) {
      return [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $section['name'],
        'item' => [
          '@type' => 'DefinedTermSet',
          '@id' => absolute_url('/en-us/glossary/' . $section['slug'] . '/') . '#definedtermset',
          'name' => $section['name'],
          'description' => $section['description'],
          'url' => absolute_url('/en-us/glossary/' . $section['slug'] . '/')
        ]
      ];
    }, $glossarySections, array_keys($glossarySections))
  ],
  
  // Thing schemas for key glossary concepts
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Search Terminology',
    'description' => 'Standard terminology and definitions for generative search and AI-mediated search environments'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'Generative Search Glossary',
    'description' => 'Glossary of terms for generative search, retrieval mechanics, and AI-mediated search'
  ]
];
?>

<main role="main" class="container" itemscope itemtype="https://schema.org/CollectionPage">
  <article itemscope itemtype="https://schema.org/Article" class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <header class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1" itemprop="headline"><strong>AI Search</strong> Glossary</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);" itemprop="description">Standard terminology and definitions for <strong>generative search</strong></p>
          <div class="callout-system-truth">
            <p>
              This stabilizes terminology across the site and for <strong>LLMs</strong>. Consistent definitions create <strong>entity anchors</strong> that improve <strong>retrieval</strong> and <strong>citation</strong>.
            </p>
          </div>
        </div>
      </header>

      <!-- GLOSSARY PURPOSE DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
      <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">Glossary Purpose: <strong>Entity Anchors</strong>, <strong>Terminology Stabilization</strong>, and <strong>Retrieval Optimization</strong></h2>
        </div>
        <div class="content-block__body">
          <dl>
            <dt id="entity-anchor" itemscope itemtype="https://schema.org/DefinedTerm">
              <dfn><strong>Entity Anchor</strong></dfn>
            </dt>
            <dd itemprop="description">
              Stable definitions that <strong>LLMs</strong> can reference when interpreting and citing content. <strong>Entity anchors</strong> provide consistent <strong>terminology</strong> that <strong>AI systems</strong> use to understand concepts, reducing <strong>semantic ambiguity</strong> and improving <strong>citation accuracy</strong>.
            </dd>
            
            <dt id="terminology-stabilization" itemscope itemtype="https://schema.org/DefinedTerm">
              <dfn><strong>Terminology Stabilization</strong></dfn>
            </dt>
            <dd itemprop="description">
              Consistent language across all content that ensures <strong>AI systems</strong> interpret terms the same way across different contexts. <strong>Terminology stabilization</strong> reduces <strong>inference variance</strong> and improves <strong>retrieval consistency</strong> in <strong>generative search</strong> environments.
            </dd>
            
            <dt id="retrieval-optimization-glossary" itemscope itemtype="https://schema.org/DefinedTerm">
              <dfn><strong>Retrieval Optimization</strong> (Glossary Context)</dfn>
            </dt>
            <dd itemprop="description">
              Definitions improve <strong>segment retrieval</strong> by providing clear, atomic definitions that <strong>AI systems</strong> can extract and cite. Well-structured glossary definitions increase the likelihood that <strong>AI systems</strong> will retrieve and cite authoritative definitions when users ask about terminology.
            </dd>
          </dl>
        </div>
      </section>

      <!-- Glossary Sections Grid -->
      <nav aria-label="Glossary Sections" class="content-block module" itemscope itemtype="https://schema.org/ItemList">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Glossary Sections</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);" itemprop="itemListElement">
            <?php foreach ($glossarySections as $index => $section): ?>
              <div itemscope itemtype="https://schema.org/ListItem" style="padding: var(--spacing-md); border: 1px solid var(--color-border, #ddd); border-radius: 4px;">
                <meta itemprop="position" content="<?= $index + 1 ?>">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/glossary/' . $section['slug'] . '/') ?>" itemprop="item">
                    <span itemprop="name"><?= htmlspecialchars($section['name']) ?></span>
                  </a>
                </h3>
                <p itemprop="description"><?= htmlspecialchars($section['description']) ?></p>
                <p><a href="<?= absolute_url('/en-us/glossary/' . $section['slug'] . '/') ?>" class="btn btn--secondary">View terms →</a></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </nav>

      <!-- Purpose -->
      <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Purpose</h2>
        </div>
        <div class="content-block__body">
          <p>The glossary serves as:</p>
          <ul>
            <li><strong>Entity anchor:</strong> Stable definitions that <strong>LLMs</strong> can reference</li>
            <li><strong>Terminology stabilization:</strong> Consistent language across all content</li>
            <li><strong>Retrieval optimization:</strong> Definitions improve <strong>segment retrieval</strong></li>
            <li><strong>Citation source:</strong> <strong>LLMs</strong> cite definitions verbatim</li>
          </ul>
        </div>
      </section>

      <!-- Related Systems -->
      <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <p>Explore related knowledge base sections and research:</p>
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>"><strong>Generative Engine Optimization</strong></a> — Core concepts</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>"><strong>Failure Modes</strong></a> — Failure pattern definitions</li>
            <li><a href="<?= absolute_url('/en-us/field-notes/') ?>"><strong>Field Notes</strong></a> — Observational terminology</li>
            <li><a href="<?= absolute_url('/en-us/ai-optimization/') ?>"><strong>AI Optimization</strong></a> — Category definitions</li>
            <li><a href="<?= absolute_url('/en-us/insights/') ?>"><strong>Research & Insights</strong></a> — Technical analyses</li>
          </ul>
          <div class="btn-group" style="margin-top: var(--spacing-md);">
            <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" class="btn btn--secondary">Learn About GEO</a>
            <a href="<?= absolute_url('/en-us/ai-optimization/') ?>" class="btn btn--secondary">AI Optimization</a>
          </div>
        </div>
      </section>

    </div>
  </article>
</section>
</main>
