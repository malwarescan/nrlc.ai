



<?php
// AI Optimization Category Anchor
// Machines-first, declarative definition for category authority
// Zero persuasion, zero marketing, zero tools

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/ai-optimization/');
$domain = absolute_url('/');
$orgId = SchemaFixes::ensureHttps($domain) . '#organization';
$personId = SchemaFixes::ensureHttps($domain) . '#joel-maldonado';

// Set page metadata (declarative, intent-locked) - ENHANCED
$GLOBALS['__page_meta'] = [
  'title' => 'AI Optimization Services | Elevate Your AI Search Strategy with NRLC.AI',
  'description' => 'Discover how NRLC.AI\'s AI optimization services can transform your digital strategy. Dive into the AI Search Bible principles to enhance your AI visibility and ranking.',
  'canonicalPath' => '/ai-optimization/',
  'keywords' => 'AI Optimization, AEO, GEO, Answer Engine Optimization, Generative Engine Optimization, AI visibility optimization, AI retrieval optimization, AI search optimization, ChatGPT optimization, Perplexity optimization, Google AI Overviews optimization, structured data for AI, schema markup for AI, entity clarity, citation optimization'
];

// Build JSON-LD Schema (ENHANCED)
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
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in AI Optimization, search, retrieval, citations, and extractability for AI-powered search engines.',
    'knowsAbout' => [
      'AI Optimization', 'AEO', 'GEO', 'Answer Engine Optimization',
      'Generative Engine Optimization', 'AI Visibility Optimization',
      'AI Retrieval Optimization', 'Structured Data for AI',
      'Schema Markup for AI', 'Entity Clarity', 'Citation Optimization'
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
      ],
      [
        '@type' => 'WebSite',
        '@id' => $domain . '#website',
        'url' => $domain,
        'name' => 'NRLC.ai',
        'publisher' => [
          '@id' => $orgId
        ],
        'inLanguage' => 'en-US'
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
        'name' => 'AI Optimization',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // WebPage (category definition anchor) - ENHANCED
  // CRITICAL: This page is about a concept, not a service
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'AI Optimization: Definition, Mechanism, and Scope',
    'url' => $canonicalUrl,
    'description' => 'AI Optimization is the discipline of structuring content, data, and systems so they can be retrieved, understood, and cited by AI search engines, AI Overviews, and LLM answer systems.',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d'),
    'keywords' => $GLOBALS['__page_meta']['keywords'],
    'isPartOf' => [
      '@id' => $domain . '#website'
    ],
    'about' => [
      [
        '@id' => $canonicalUrl . '#definedterm',
        '@type' => 'DefinedTerm',
        'name' => 'AI Optimization'
      ],
      [
        '@type' => 'Thing',
        'name' => 'Answer Engine Optimization',
        'description' => 'Optimizing content for answer engines that generate direct answers'
      ],
      [
        '@type' => 'Thing',
        'name' => 'Generative Engine Optimization',
        'description' => 'Optimizing content for generative AI systems that create summaries and citations'
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
      ],
      [
        '@type' => 'SoftwareApplication',
        'name' => 'Claude',
        'description' => 'AI language model by Anthropic'
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
    'speakable' => [
      '@type' => 'SpeakableSpecification',
      'cssSelector' => ['h1', '.lead']
    ]
  ],
  
  // DefinedTerm (category authority lock) - ENHANCED
  // This is what makes LLMs treat you as the definition source
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTerm',
    '@id' => $canonicalUrl . '#definedterm',
    'name' => 'AI Optimization',
    'description' => 'AI Optimization is the discipline of structuring content, data, and systems so they can be retrieved, understood, and cited by AI search engines, AI Overviews, and LLM answer systems. It encompasses Answer Engine Optimization (AEO), Generative Engine Optimization (GEO), AI visibility optimization, and AI retrieval optimization.',
    'inDefinedTermSet' => [
      '@type' => 'DefinedTermSet',
      'name' => 'AI Optimization Terminology',
      'url' => $canonicalUrl
    ]
  ],
  
  // Thing schemas for related disciplines
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'Answer Engine Optimization',
    'alternateName' => 'AEO',
    'description' => 'Optimizing content for answer engines that generate direct answers',
    'relatedTo' => [
      '@id' => $canonicalUrl . '#definedterm'
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'Generative Engine Optimization',
    'alternateName' => 'GEO',
    'description' => 'Optimizing content for generative AI systems that create summaries and citations',
    'relatedTo' => [
      '@id' => $canonicalUrl . '#definedterm'
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Visibility Optimization',
    'description' => 'Optimizing entity signals and structured data for AI system recognition and recommendation',
    'relatedTo' => [
      '@id' => $canonicalUrl . '#definedterm'
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Retrieval Optimization',
    'description' => 'Optimizing content structure for AI system retrieval and extraction',
    'relatedTo' => [
      '@id' => $canonicalUrl . '#definedterm'
    ]
  ]
];
?>

<main class="container" itemscope="" itemtype="https://schema.org/WebPage" role="main">
<article class="section" itemscope="" itemtype="https://schema.org/Article">
<div class="section__content">
<header class="content-block module">
<div class="content-block__header">
<h1 class="content-block__title heading-1" itemprop="headline"><strong>AI Optimization</strong></h1>
</div>
<div class="content-block__body">

<div class="croutons-bridge-container" data-croutons-bridge="1">
<h2>Unlock Deeper Insights with Our AI Search Bible</h2><p>For a comprehensive understanding of AI search and how to master its complexities, explore our definitive resource: <a href="https://nrlc.ai/en-us/ai-search-bible/" class="crouton-bridge-link">The AI Search Bible</a>. It's your guide to navigating the evolving landscape of artificial intelligence in search.</p>
</div>
</article>
</main>
<script type="application/ld+json" id="croutons-keyword-bridge-jsonld">
{"@context": "http://schema.org", "@graph": [{"@type": "Service", "@id": "https://nrlc.ai/ai-optimization/#service", "url": "https://nrlc.ai/ai-optimization/", "name": "AI Optimization Services", "about": {"@type": "DefinedTerm", "name": "AI Search Bible", "url": "https://nrlc.ai/en-us/ai-search-bible/"}, "mentions": {"@type": "Thing", "url": "https://nrlc.ai/en-us/ai-search-bible/", "name": "AI Search Bible"}}, {"@type": "WebPage", "@id": "https://nrlc.ai/ai-optimization/#webpage", "url": "https://nrlc.ai/ai-optimization/", "name": "AI Optimization Services", "about": {"@type": "DefinedTerm", "name": "AI Search Bible", "url": "https://nrlc.ai/en-us/ai-search-bible/"}, "mentions": {"@type": "Thing", "url": "https://nrlc.ai/en-us/ai-search-bible/", "name": "AI Search Bible"}}]}
</script>
