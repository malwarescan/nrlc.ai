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
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Entity Repair Case Study: Fixing Semantic Misclassification at SAW.com</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description">How entity-level semantic poisoning caused Google to misclassify SAW.com, why SEO fixes failed, and how structured entity repair restored correct business identity.</p>
              <div class="btn-group">
                <a href="/case-studies/entity-semantic-poisoning-saw/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
            </div>
          </div>

          <!-- B2B SaaS Case Study -->
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">TaskFlow: 340% AI Citation Increase via Entity Mapping</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description"><strong>Client:</strong> TaskFlow (UK-based project management SaaS, 12,000 users). <strong>Result:</strong> 340% increase in AI citations (23% → 78% citation rate). <strong>Method:</strong> Service schema with expertise declarations, atomic content blocks, entity disambiguation. <strong>Timeline:</strong> 90 days.</p>
              <div class="btn-group">
                <a href="/case-studies/b2b-saas/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
            </div>
          </div>
          
          <!-- E-commerce Case Study -->
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">Artisan Goods Co: 250% AI Visibility Increase via Product Schema</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description"><strong>Client:</strong> Artisan Goods Co (Canadian e-commerce, 8,500 products). <strong>Result:</strong> 250% increase in AI visibility (18% → 63% mention rate). <strong>Method:</strong> Product schema with Offer, AggregateRating, Brand entities, category taxonomies. <strong>Timeline:</strong> 75 days.</p>
              <div class="btn-group">
                <a href="/case-studies/ecommerce/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
            </div>
          </div>
          
          <!-- Healthcare Case Study -->
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">MedCare Australia: 180% AI Citation Improvement via MedicalBusiness Schema</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description"><strong>Client:</strong> MedCare Australia (healthcare provider, 45 physicians). <strong>Result:</strong> 180% improvement in AI citation rates (31% → 87% citation rate). <strong>Method:</strong> MedicalBusiness schema, HealthcareProvider credentials, specialty mappings, TrustSignal schema. <strong>Timeline:</strong> 60 days.</p>
              <div class="btn-group">
                <a href="/case-studies/healthcare/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
            </div>
          </div>
          
          <!-- Fintech Case Study -->
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">PayBridge Singapore: 290% AI Mention Increase via FinancialProduct Schema</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description"><strong>Client:</strong> PayBridge Singapore (payment processing, $180M processed annually). <strong>Result:</strong> 290% increase in AI mentions (22% → 86% mention rate). <strong>Method:</strong> FinancialProduct schema, regulatory compliance declarations, security certification structured data. <strong>Timeline:</strong> 85 days.</p>
              <div class="btn-group">
                <a href="/case-studies/fintech/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
            </div>
          </div>
          
          <!-- Education Case Study -->
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">LearnHub Germany: 220% AI Citation Increase via Course Schema</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description"><strong>Client:</strong> LearnHub Germany (online education platform, 85,000 learners). <strong>Result:</strong> 220% increase in AI citations (28% → 90% citation rate). <strong>Method:</strong> Course schema with accreditation, EducationalOrganization relationships, atomic content units. <strong>Timeline:</strong> 70 days.</p>
              <div class="btn-group">
                <a href="/case-studies/education/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
            </div>
          </div>
          
          <!-- Real Estate Case Study -->
          <div class="content-block" itemscope itemtype="https://schema.org/Article">
            <div class="content-block__header">
              <h3 class="content-block__title heading-3" itemprop="headline">PropertyView Ireland: 160% AI Visibility Improvement via RealEstateAgent Schema</h3>
            </div>
            <div class="content-block__body">
              <p itemprop="description"><strong>Client:</strong> PropertyView Ireland (real estate platform, 12,000 listings). <strong>Result:</strong> 160% improvement in AI visibility (35% → 91% mention rate). <strong>Method:</strong> RealEstateAgent schema, Place schema with geographic relationships, location-based entity mappings. <strong>Timeline:</strong> 55 days.</p>
              <div class="btn-group">
                <a href="/case-studies/real-estate/" class="btn btn--primary" itemprop="url">View Case Study</a>
              </div>
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
        'name' => 'TaskFlow: 340% AI Citation Increase via Entity Mapping',
        'item' => absolute_url('/case-studies/b2b-saas/'),
        'description' => 'TaskFlow (UK-based project management SaaS, 12,000 users) achieved 340% increase in AI citations (23% → 78% citation rate) through Service schema with expertise declarations and entity disambiguation.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Artisan Goods Co: 250% AI Visibility Increase via Product Schema',
        'item' => absolute_url('/case-studies/ecommerce/'),
        'description' => 'Artisan Goods Co (Canadian e-commerce, 8,500 products) achieved 250% increase in AI visibility (18% → 63% mention rate) through Product schema with Offer, AggregateRating, and Brand entities.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'MedCare Australia: 180% AI Citation Improvement via MedicalBusiness Schema',
        'item' => absolute_url('/case-studies/healthcare/'),
        'description' => 'MedCare Australia (healthcare provider, 45 physicians) achieved 180% improvement in AI citation rates (31% → 87% citation rate) through MedicalBusiness schema and HealthcareProvider credentials.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 5,
        'name' => 'PayBridge Singapore: 290% AI Mention Increase via FinancialProduct Schema',
        'item' => absolute_url('/case-studies/fintech/'),
        'description' => 'PayBridge Singapore (payment processing, $180M processed annually) achieved 290% increase in AI mentions (22% → 86% mention rate) through FinancialProduct schema and regulatory compliance declarations.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 6,
        'name' => 'LearnHub Germany: 220% AI Citation Increase via Course Schema',
        'item' => absolute_url('/case-studies/education/'),
        'description' => 'LearnHub Germany (online education platform, 85,000 learners) achieved 220% increase in AI citations (28% → 90% citation rate) through Course schema with accreditation and EducationalOrganization relationships.'
      ],
      [
        '@type' => 'ListItem',
        'position' => 7,
        'name' => 'PropertyView Ireland: 160% AI Visibility Improvement via RealEstateAgent Schema',
        'item' => absolute_url('/case-studies/real-estate/'),
        'description' => 'PropertyView Ireland (real estate platform, 12,000 listings) achieved 160% improvement in AI visibility (35% → 91% mention rate) through RealEstateAgent schema and location-based entity mappings.'
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
