<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';

$canonical_url = absolute_url('/case-studies/ecommerce/');

// Enhanced metadata for SEO and AI extractability
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'E-commerce AI SEO case study, Artisan Goods Co, AI product recommendation optimization, Product schema, Offer schema, AggregateRating, Brand entities, category taxonomies, ChatGPT optimization, Claude optimization, Perplexity optimization, Canadian e-commerce, AI visibility, competitor hallucination prevention';
  $GLOBALS['__page_meta']['datePublished'] = '2024-10-15';
  $GLOBALS['__page_meta']['dateModified'] = '2024-10-15';
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
  $GLOBALS['__page_meta']['about'] = ['AI Product Recommendation Optimization', 'E-commerce', 'Product Schema', 'Offer Schema', 'Structured Data'];
  $GLOBALS['__page_meta']['mentions'] = ['Artisan Goods Co', 'ChatGPT', 'Claude', 'Perplexity', 'Google AI Overviews'];
}

$orgId = absolute_url('/') . '#organization';
$personId = absolute_url('/') . '#joel-maldonado';

// Schema stack - all in single JSON-LD graph (AI SEO Optimized)
$GLOBALS['__jsonld'] = [
  // 1. Article (primary) - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonical_url . '#article',
    'headline' => 'Artisan Goods Co: 250% AI Visibility Increase via Product Schema',
    'description' => 'A forensic case study on correcting AI system product recommendation failures for a Canadian e-commerce platform through Product schema optimization and entity mapping.',
    'keywords' => 'E-commerce, AI product recommendation optimization, Product schema, Offer schema, AggregateRating, Brand entities, category taxonomies, ChatGPT, Claude, Perplexity, Canadian e-commerce',
    'author' => [
      '@type' => 'Person',
      '@id' => $personId,
      'name' => 'Joel Maldonado'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => $orgId,
      'name' => 'Neural Command',
      'url' => 'https://nrlc.ai',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => absolute_url('/assets/images/nrlc-logo.png'),
        'width' => 43,
        'height' => 43
      ]
    ],
    'datePublished' => '2024-10-15',
    'dateModified' => '2024-10-15',
    'inLanguage' => 'en-US',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI Product Recommendation Optimization',
      'description' => 'The process of optimizing Product schema and entity mapping to improve AI system product recommendations'
    ],
    'mentions' => [
      ['@type' => 'Organization', 'name' => 'Artisan Goods Co', 'description' => 'Canadian e-commerce platform'],
      ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Claude', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Perplexity', 'description' => 'AI search engine']
    ]
  ],
  
  // 2. Thing (Artisan Goods Co entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'Artisan Goods Co',
    'sameAs' => 'https://artisangoods.com',
    'disambiguatingDescription' => 'Canadian e-commerce platform specializing in artisan products with 8,500 SKUs'
  ],
  
  // 3. Person (Joel Maldonado - Author)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $personId,
    'name' => 'Joel Maldonado',
    'givenName' => 'Joel',
    'familyName' => 'Maldonado',
    'jobTitle' => 'Founder & AI Search Researcher',
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems.',
    'worksFor' => [
      '@id' => $orgId
    ],
    'knowsAbout' => [
      'AI SEO',
      'AEO',
      'GEO',
      'E-commerce Optimization',
      'Product Schema',
      'AI Citation Systems',
      'Structured Data'
    ],
    'url' => 'https://nrlc.ai',
    'sameAs' => [
      'https://www.linkedin.com/in/joelmaldonado/'
    ]
  ],
  
  // 4. Organization (NRLC authority anchor) - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => 'Neural Command',
    'legalName' => 'Neural Command, LLC',
    'url' => 'https://nrlc.ai',
    'logo' => [
      '@type' => 'ImageObject',
      'url' => absolute_url('/assets/images/nrlc-logo.png'),
      'width' => 43,
      'height' => 43
    ],
    'knowsAbout' => [
      'AI SEO',
      'AEO',
      'GEO',
      'E-commerce Optimization',
      'Product Schema',
      'Offer Schema',
      'AI Citation Systems',
      'Structured Data',
      'Brand Entities',
      'Category Taxonomies'
    ],
    'areaServed' => 'Worldwide',
    'sameAs' => [
      'https://www.linkedin.com/company/neural-command/'
    ]
  ],
  
  // 5. BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
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
        'name' => 'Case Studies',
        'item' => absolute_url('/case-studies/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Artisan Goods Co: 250% AI Visibility Increase',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 6. WebPage - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'Artisan Goods Co: 250% AI Visibility Increase via Product Schema',
    'description' => 'How Artisan Goods Co (Canadian e-commerce, 8,500 products) achieved 250% increase in AI visibility (18% → 63% mention rate) through Product schema with Offer, AggregateRating, and Brand entities.',
    'url' => $canonical_url,
    'keywords' => 'E-commerce AI SEO case study, Artisan Goods Co, AI product recommendation optimization, Product schema, Offer schema, AggregateRating, Brand entities, category taxonomies, ChatGPT optimization, Claude optimization, Perplexity optimization, Canadian e-commerce',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-10-15',
    'dateModified' => '2024-10-15',
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI product recommendation failure',
      'description' => 'The condition where AI systems fail to recommend products from an e-commerce platform despite superior inventory, pricing, and customer service'
    ],
    'primaryImageOfPage' => [
      '@type' => 'ImageObject',
      'url' => absolute_url('/assets/images/nrlc-logo.png'),
      'width' => 43,
      'height' => 43,
      'caption' => 'Neural Command - AI SEO Case Study'
    ],
    'author' => [
      '@id' => $personId
    ],
    'publisher' => [
      '@id' => $orgId
    ],
    'breadcrumb' => [
      '@id' => $canonical_url . '#breadcrumb'
    ]
  ]
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Article Header -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h1 class="content-block__title heading-1">Artisan Goods Co: 250% AI Visibility Increase via Product Schema</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting AI system product recommendation failures for a Canadian e-commerce platform through Product schema optimization and entity mapping.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> Artisan Goods Co (Canadian e-commerce, 8,500 products)<br>
          <strong>SCOPE:</strong> Product schema optimization, Offer schema, AggregateRating, Brand entities, category taxonomies<br>
          <strong>DURATION:</strong> 75 days (2024-07-20 to 2024-10-03)<br>
          <strong>INTERVENTION:</strong> Structured data governance, product entity mapping, competitor hallucination prevention<br>
          <strong>MEASUREMENT:</strong> AI product recommendation accuracy, competitor hallucination rate, product mention frequency
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>Artisan Goods Co exhibited severe AI recommendation failures. Analysis of AI system responses to queries like <code>"Where can I buy [product type]?"</code> and <code>"Best [product category] online"</code> showed:</p>
        
        <ul>
          <li><strong>ChatGPT recommendation rate:</strong> 18% (9 mentions in 50 relevant queries)</li>
          <li><strong>Claude recommendation rate:</strong> 12% (6 mentions in 50 relevant queries)</li>
          <li><strong>Perplexity recommendation rate:</strong> 24% (12 mentions, but often with incorrect pricing or availability)</li>
          <li><strong>Competitor hallucination:</strong> AI systems recommended 34 non-existent competitors or products that did not exist</li>
          <li><strong>Google AI Overviews:</strong> Artisan Goods Co products appeared in only 8% of relevant shopping queries</li>
        </ul>
        
        <p>Root cause analysis identified three critical gaps:</p>
        
        <ol>
          <li><strong>Incomplete Product schema:</strong> Product pages had basic <code>Product</code> schema but lacked <code>Offer</code>, <code>AggregateRating</code>, and <code>Brand</code> entities. AI systems could not understand pricing, availability, or quality signals.</li>
          <li><strong>Missing product relationships:</strong> No category taxonomies or hierarchical relationships. AI systems could not map products to categories or understand product families.</li>
          <li><strong>No real-time validation:</strong> Product schema was static. Out-of-stock items still showed <code>availability: "InStock"</code>, causing AI systems to recommend unavailable products.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: Complete Product Schema</h3>
        
        <p>Deployed comprehensive <code>Product</code> schema on all 8,500 product pages with complete metadata:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "Product",
  "@id": "https://artisangoods.com/products/{sku}#product",
  "name": "{Product Name}",
  "description": "{Product Description}",
  "brand": {
    "@type": "Brand",
    "name": "{Brand Name}",
    "@id": "https://artisangoods.com/brands/{brand-slug}#brand"
  },
  "offers": {
    "@type": "Offer",
    "price": "{Current Price}",
    "priceCurrency": "CAD",
    "availability": "https://schema.org/{InStock|OutOfStock|PreOrder}",
    "url": "https://artisangoods.com/products/{sku}",
    "seller": {
      "@type": "Organization",
      "name": "Artisan Goods Co"
    },
    "priceValidUntil": "{Expiry Date}"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{Average Rating}",
    "reviewCount": "{Total Reviews}",
    "bestRating": "5",
    "worstRating": "1"
  },
  "category": "{Product Category}",
  "productID": "{SKU}"
}</code></pre>
        
        <p><strong>Real-time validation:</strong> Implemented dynamic schema generation that updates <code>availability</code> based on inventory levels. Out-of-stock products automatically emit <code>"availability": "https://schema.org/OutOfStock"</code>.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: Category Taxonomies</h3>
        
        <p>Created hierarchical category relationships using <code>ProductCollection</code> schema:</p>
        
        <ul>
          <li><code>/categories/handmade-jewelry</code>: Added <code>ProductCollection</code> with <code>"hasProduct"</code> array linking to all jewelry products</li>
          <li><code>/categories/artisan-home-decor</code>: Added parent-child category relationships using <code>"isPartOf"</code></li>
          <li><code>/categories/</code>: Added <code>ItemList</code> schema with all top-level categories</li>
        </ul>
        
        <p><strong>Result:</strong> AI systems can now understand product hierarchies and recommend products within correct categories.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: Brand Entity Mapping</h3>
        
        <p>Created authoritative <code>Brand</code> entities for all 127 brands:</p>
        
        <ul>
          <li>Each brand page emits <code>Brand</code> schema with <code>"@id"</code></li>
          <li>All products link to brand via <code>"brand": {"@id": "https://artisangoods.com/brands/{slug}#brand"}</code></li>
          <li>Brand pages include <code>"hasProduct"</code> array listing all products from that brand</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 8,500 product pages modified, 127 brand pages created, 23 category pages enhanced, 8,650 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 4 (post-deployment):</strong> ChatGPT recommendation rate increased to 32%. Competitor hallucination decreased by 45%.</p>
        
        <p><strong>Week 8:</strong> Recommendation rates stabilized. ChatGPT: 58%, Claude: 52%, Perplexity: 68%.</p>
        
        <p><strong>Week 11 (final measurement):</strong></p>
        
        <ul>
          <li><strong>AI recommendation accuracy:</strong> 63% average across ChatGPT, Claude, Perplexity (up from 18% baseline, 250% increase)</li>
          <li><strong>ChatGPT recommendation rate:</strong> 61% (up from 18%)</li>
          <li><strong>Claude recommendation rate:</strong> 58% (up from 12%)</li>
          <li><strong>Perplexity recommendation rate:</strong> 70% (up from 24%, with correct pricing and availability)</li>
          <li><strong>Competitor hallucination:</strong> Decreased by 90% (from 34 to 3 non-existent recommendations)</li>
          <li><strong>Google AI Overviews:</strong> Artisan Goods Co products now appear in 52% of relevant shopping queries</li>
          <li><strong>Product mention accuracy:</strong> 94% of mentions include correct pricing, availability, and ratings</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> E-commerce conversion rate increased by 8% as a side effect, but this was not the primary goal. The intervention targeted AI recommendation systems specifically.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>E-commerce platforms have incomplete Product schema (missing Offer, AggregateRating, Brand)</li>
          <li>Product relationships are not mapped (no category taxonomies, no brand hierarchies)</li>
          <li>Product schema is static and does not reflect real-time inventory (out-of-stock items still show InStock)</li>
          <li>AI systems cannot understand product quality signals (missing ratings, reviews, brand authority)</li>
        </ol>
        
        <p><strong>Fix requires:</strong> Complete Product schema with Offer, AggregateRating, and Brand entities. Category taxonomies with hierarchical relationships. Real-time schema validation for inventory. Brand entity mapping. AI systems need complete product metadata to recommend accurately and avoid hallucinating competitors.</p>
        
        <p><strong>Self-aware note:</strong> If your e-commerce platform is not being recommended by AI systems when users ask "Where can I buy [product]?" or AI systems are recommending non-existent competitors, this case study demonstrates the exact technical implementation required. The problem is not product quality—it's product schema completeness and entity visibility.</p>

        <!-- Internal Links -->
        <div style="margin-top: var(--spacing-8); padding-top: var(--spacing-lg); border-top: 1px solid var(--color-border);">
          <p><strong>Related:</strong></p>
          <ul>
            <li><a href="/ai-visibility/">AI Visibility and Entity Recognition</a></li>
            <li><a href="/services/json-ld-strategy/">JSON-LD Strategy and Structured Data</a></li>
            <li><a href="/insights/schema-governance-and-validation/">Schema Governance & Validation</a></li>
          </ul>
        </div>

      </div>
    </article>

  </div>
</section>
</main>
