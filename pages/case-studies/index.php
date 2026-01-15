<?php
// Note: Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for case studies index metadata configuration
// Note: head.php and header.php are already included by router.php render_page()

$canonical_url = absolute_url('/case-studies/');

// ADVANCED: Enhance metadata for SEO
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'AI SEO case studies, SEO success stories, entity optimization case study, structured data case study, AI citation case study, ChatGPT optimization results, Claude optimization results, Google AI Overviews case study, LLM citation growth, semantic SEO case study';
  $GLOBALS['__page_meta']['datePublished'] = '2024-01-01';
  $GLOBALS['__page_meta']['dateModified'] = date('Y-m-d');
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
}
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Page Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title heading-1">AI SEO Case Studies & Success Stories</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Real-world examples of AI SEO optimization success, featuring detailed results and implementation strategies.</p>
      </div>
    </div>

    <!-- Case Studies Grid -->
    <div class="content-block module">
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          
          <!-- Entity Semantic Poisoning at SAW.com (Real Case Study) -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Entity Repair Case Study: Fixing Semantic Misclassification at SAW.com</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">How entity-level semantic poisoning caused Google to misclassify SAW.com, why SEO fixes failed, and how structured entity repair restored correct business identity.</p>
              <p>
                <a href="/case-studies/entity-semantic-poisoning-saw/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>

          <!-- B2B SaaS Case Study -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">B2B SaaS Case Study: 340% Increase in AI Citations</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">How a SaaS company increased AI citations by 340% through structured data optimization and entity mapping.</p>
              <p>
                <a href="/case-studies/b2b-saas/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- E-commerce Case Study -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">E-commerce Case Study: 250% Increase in AI Visibility</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">E-commerce platform achieved 250% increase in AI visibility through product schema optimization.</p>
              <p>
                <a href="/case-studies/ecommerce/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Healthcare Case Study -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Healthcare Case Study: 180% Improvement in AI Citation Rates</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">Medical website improved AI citation rates by 180% with healthcare-specific entity optimization.</p>
              <p>
                <a href="/case-studies/healthcare/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Fintech Case Study -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Fintech Case Study: 290% Increase in AI Mentions</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">Financial services company increased AI mentions by 290% through compliance-focused optimization.</p>
              <p>
                <a href="/case-studies/fintech/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Education Case Study -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Education Case Study: 220% Increase in AI Citations</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">Educational platform achieved 220% increase in AI citations through academic content optimization.</p>
              <p>
                <a href="/case-studies/education/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Real Estate Case Study -->
          <div class="box-padding" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Real Estate Case Study: 160% Improvement in AI Visibility</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">Property platform improved AI visibility by 160% with location-based entity optimization.</p>
              <p>
                <a href="/case-studies/real-estate/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </p>
            </div>
          </div>
          
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// ADVANCED: Comprehensive schema markup
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';

$GLOBALS['__jsonld'] = [
  // 1. WebPage Schema - ADVANCED
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url . '#webpage',
    'name' => 'AI SEO Case Studies & Success Stories | Real Results | Neural Command',
    'description' => 'Real-world AI SEO case studies featuring detailed results and implementation strategies. Entity repair, structured data optimization, AI citation growth, and measurable improvements in search visibility.',
    'url' => $canonical_url,
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => 'https://nrlc.ai/#website',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai',
      'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => [
          '@type' => 'EntryPoint',
          'urlTemplate' => 'https://nrlc.ai/search?q={search_term_string}'
        ],
        'query-input' => 'required name=search_term_string'
      ]
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI SEO Case Studies',
      'description' => 'Real-world examples of AI SEO optimization success'
    ],
    'primaryImageOfPage' => [
      '@type' => 'ImageObject',
      'url' => 'https://nrlc.ai/assets/images/nrlc-logo.png',
      'width' => 43,
      'height' => 43,
      'caption' => 'Neural Command - AI SEO Case Studies'
    ],
    'inLanguage' => 'en-US',
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d'),
    'author' => [
      '@type' => 'Person',
      'name' => 'Joel Maldonado',
      'jobTitle' => 'Founder & AI Search Researcher',
      'worksFor' => [
        '@id' => $orgId
      ]
    ],
    'publisher' => [
      '@id' => $orgId
    ],
    'breadcrumb' => [
      '@type' => 'BreadcrumbList',
      '@id' => $canonical_url . '#breadcrumb',
      'itemListElement' => [
        [
          '@type' => 'ListItem',
          'position' => 1,
          'name' => 'Home',
          'item' => 'https://nrlc.ai/'
        ],
        [
          '@type' => 'ListItem',
          'position' => 2,
          'name' => 'Case Studies',
          'item' => $canonical_url
        ]
      ]
    ],
    'mainEntity' => [
      '@id' => $canonical_url . '#itemlist'
    ],
    'speakable' => [
      '@type' => 'SpeakableSpecification',
      'cssSelector' => ['h1', '.lead']
    ]
  ],

  // 2. ItemList Schema - ADVANCED (Case Studies List)
  [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    '@id' => $canonical_url . '#itemlist',
    'name' => 'AI SEO Case Studies & Success Stories',
    'description' => 'Real-world examples of AI SEO optimization success, featuring detailed results and implementation strategies.',
    'numberOfItems' => 7,
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Entity Repair Case Study: Fixing Semantic Misclassification at SAW.com',
        'item' => absolute_url('/case-studies/entity-semantic-poisoning-saw/'),
        'description' => 'How entity-level semantic poisoning caused Google to misclassify SAW.com, why SEO fixes failed, and how structured entity repair restored correct business identity.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'B2B SaaS Case Study: 340% Increase in AI Citations',
        'item' => absolute_url('/case-studies/b2b-saas/'),
        'description' => 'How a SaaS company increased AI citations by 340% through structured data optimization and entity mapping.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'E-commerce Case Study: 250% Increase in AI Visibility',
        'item' => absolute_url('/case-studies/ecommerce/'),
        'description' => 'E-commerce platform achieved 250% increase in AI visibility through product schema optimization.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Healthcare Case Study: 180% Improvement in AI Citation Rates',
        'item' => absolute_url('/case-studies/healthcare/'),
        'description' => 'Medical website improved AI citation rates by 180% with healthcare-specific entity optimization.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 5,
        'name' => 'Fintech Case Study: 290% Increase in AI Mentions',
        'item' => absolute_url('/case-studies/fintech/'),
        'description' => 'Financial services company increased AI mentions by 290% through compliance-focused optimization.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 6,
        'name' => 'Education Case Study: 220% Increase in AI Citations',
        'item' => absolute_url('/case-studies/education/'),
        'description' => 'Educational platform achieved 220% increase in AI citations through academic content optimization.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 7,
        'name' => 'Real Estate Case Study: 160% Improvement in AI Visibility',
        'item' => absolute_url('/case-studies/real-estate/'),
        'description' => 'Property platform improved AI visibility by 160% with location-based entity optimization.'
      ]
    ]
  ],

  // 3. Organization Schema - ADVANCED
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => 'Neural Command',
    'legalName' => 'Neural Command, LLC',
    'url' => 'https://nrlc.ai',
    'logo' => [
      '@type' => 'ImageObject',
      'url' => 'https://nrlc.ai/assets/images/nrlc-logo.png',
      'width' => 43,
      'height' => 43
    ],
    'knowsAbout' => [
      'AI SEO Case Studies',
      'Entity Optimization',
      'Structured Data Optimization',
      'AI Citation Growth',
      'Semantic SEO',
      'ChatGPT Optimization',
      'Claude Optimization',
      'Google AI Overviews',
      'LLM Citation Systems',
      'Search Visibility'
    ]
  ],

  // 4. Person Schema (Joel Maldonado - Author)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => 'https://nrlc.ai/#joel-maldonado',
    'name' => 'Joel Maldonado',
    'jobTitle' => 'Founder & AI Search Researcher',
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
    'worksFor' => [
      '@id' => $orgId
    ],
    'knowsAbout' => [
      'AI SEO',
      'AEO',
      'GEO',
      'AI Search',
      'Search Retrieval',
      'AI Citations',
      'Extractability',
      'Entity Optimization',
      'Structured Data',
      'Case Studies'
    ],
    'url' => 'https://nrlc.ai',
    'sameAs' => [
      'https://www.linkedin.com/in/joelmaldonado/'
    ]
  ],

  // 5. CollectionPage Schema (for case studies collection)
  [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $canonical_url . '#collection',
    'name' => 'AI SEO Case Studies Collection',
    'description' => 'Collection of real-world AI SEO case studies demonstrating measurable improvements in search visibility, AI citations, and entity optimization.',
    'url' => $canonical_url,
    'mainEntity' => [
      '@id' => $canonical_url . '#itemlist'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI SEO Optimization',
      'description' => 'Case studies demonstrating successful AI SEO optimization strategies and results'
    ]
  ]
];
?>
