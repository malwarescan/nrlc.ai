<?php
require_once __DIR__.'/helpers.php';
require_once __DIR__.'/SchemaFixes.php';

use NRLC\Schema\SchemaFixes;

/**
 * Universal schemas for all product pages
 */
function product_universal_schemas(string $productSlug, string $productName, string $productDescription, ?string $imageUrl = null): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/' . $productSlug . '/';
  $productId = $productUrl . '#product';
  
  return [
    // WebSite
    [
      '@context' => 'https://schema.org',
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => $baseUrl,
      'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => $baseUrl . '?q={search_term_string}',
        'query-input' => 'required name=search_term_string'
      ]
    ],
    
    // WebPage
    [
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      'name' => $productName . ' | NRLC.ai',
      'description' => $productDescription,
      'url' => $productUrl,
      'isPartOf' => [
        '@type' => 'WebSite',
        'name' => 'NRLC.ai',
        'url' => $baseUrl
      ],
      'about' => [
        '@id' => $productId
      ]
    ],
    
    // Organization
    [
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => 'Neural Command',
      'legalName' => 'Neural Command LLC',
      'url' => $baseUrl,
      'logo' => SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png')),
      'sameAs' => [
        'https://www.linkedin.com/company/neural-command/'
      ],
      'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => '+1-213-562-8438',
        'contactType' => 'Customer Service',
        'email' => 'contact@neuralcommandllc.com',
        'availableLanguage' => ['English']
      ]
    ],
    
    // Product
    [
      '@context' => 'https://schema.org',
      '@type' => 'Product',
      '@id' => $productId,
      'name' => $productName,
      'description' => $productDescription,
      'url' => $productUrl,
      'brand' => [
        '@type' => 'Brand',
        'name' => 'Neural Command'
      ],
      'manufacturer' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'image' => $imageUrl ? SchemaFixes::ensureHttps($imageUrl) : SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png')),
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // Offer (required by Google)
    [
      '@context' => 'https://schema.org',
      '@type' => 'Offer',
      'itemOffered' => [
        '@id' => $productId
      ],
      'availability' => 'https://schema.org/InStock',
      'priceCurrency' => 'USD',
      'price' => '0',
      'seller' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ]
    ],
    
    // Brand
    [
      '@context' => 'https://schema.org',
      '@type' => 'Brand',
      'name' => 'Neural Command',
      'logo' => SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png')),
      'url' => $baseUrl
    ],
    
    // BreadcrumbList
    [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        [
          '@type' => 'ListItem',
          'position' => 1,
          'name' => 'Home',
          'item' => $baseUrl
        ],
        [
          '@type' => 'ListItem',
          'position' => 2,
          'name' => 'Products',
          'item' => $baseUrl . 'products/'
        ],
        [
          '@type' => 'ListItem',
          'position' => 3,
          'name' => $productName,
          'item' => $productUrl
        ]
      ]
    ]
  ];
}

/**
 * Platform/SaaS schemas for Neural Command OS, Precogs, Croutons, Googlebot Renderer
 */
function product_platform_schemas(string $productSlug, string $productName, string $productDescription, array $features = [], ?string $applicationCategory = 'DeveloperApplication'): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/' . $productSlug . '/';
  $productId = $productUrl . '#product';
  
  return [
    // SoftwareApplication
    [
      '@context' => 'https://schema.org',
      '@type' => 'SoftwareApplication',
      '@id' => $productId,
      'name' => $productName,
      'description' => $productDescription,
      'url' => $productUrl,
      'applicationCategory' => $applicationCategory,
      'operatingSystem' => 'Web',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ],
      'featureList' => $features,
      'provider' => [
        '@type' => 'Organization',
        'name' => 'Neural Command',
        'url' => $baseUrl
      ],
      'softwareVersion' => '1.0',
      'releaseNotes' => $productUrl
    ],
    
    // WebApplication
    [
      '@context' => 'https://schema.org',
      '@type' => 'WebApplication',
      '@id' => $productId,
      'name' => $productName,
      'url' => $productUrl,
      'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
      'applicationCategory' => $applicationCategory,
      'operatingSystem' => 'Any',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // Service
    [
      '@context' => 'https://schema.org',
      '@type' => 'Service',
      '@id' => $productId,
      'name' => $productName,
      'description' => $productDescription,
      'provider' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'areaServed' => 'Worldwide',
      'serviceType' => $productName,
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // TechArticle
    [
      '@context' => 'https://schema.org',
      '@type' => 'TechArticle',
      'headline' => $productName . ' - Technical Documentation',
      'description' => $productDescription,
      'url' => $productUrl,
      'author' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'publisher' => [
        '@type' => 'Organization',
        'name' => 'Neural Command',
        'logo' => [
          '@type' => 'ImageObject',
          'url' => SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png'))
        ]
      ],
      'about' => [
        '@id' => $productId
      ]
    ]
  ];
}

/**
 * Dataset schemas for Croutons.ai and Precogs
 */
function product_dataset_schemas(string $productSlug, string $productName, string $productDescription): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/' . $productSlug . '/';
  $productId = $productUrl . '#product';
  
  return [
    // Dataset
    [
      '@context' => 'https://schema.org',
      '@type' => 'Dataset',
      '@id' => $productId,
      'name' => $productName . ' Dataset',
      'description' => $productDescription,
      'url' => $productUrl,
      'keywords' => ['micro-facts', 'data atomization', 'structured data', 'knowledge graph'],
      'creator' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'publisher' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'license' => 'https://creativecommons.org/licenses/by/4.0/',
      'distribution' => [
        '@type' => 'DataDownload',
        'encodingFormat' => 'application/ndjson',
        'contentUrl' => $productUrl . 'data/'
      ],
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // DataCatalog
    [
      '@context' => 'https://schema.org',
      '@type' => 'DataCatalog',
      // Linked to product if appropriate, or separate
      'name' => $productName . ' Data Catalog',
      'description' => 'Catalog of structured data and micro-facts',
      'url' => $productUrl,
      'keywords' => ['data catalog', 'micro-facts', 'structured knowledge']
    ],
    
    // DataFeed
    [
      '@context' => 'https://schema.org',
      '@type' => 'DataFeed',
      '@id' => $productId,
      'name' => $productName . ' Data Feed',
      'description' => 'Real-time feed of structured data and micro-facts',
      'dataFeedElement' => [
        '@type' => 'DataFeedItem',
        'item' => [
          '@type' => 'Thing',
          'name' => 'Micro-fact stream'
        ]
      ]
    ]
  ];
}

/**
 * Applicants.io specific schemas
 */
function applicants_io_schemas(): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/applicants-io/';
  
  return [
    // JobPosting template
    [
      '@context' => 'https://schema.org',
      '@type' => 'JobPosting',
      'title' => 'Job Posting via Applicants.io',
      'description' => 'Applicants.io provides automated JobPosting schema generation for maximum Google Jobs visibility',
      'employmentType' => 'FULL_TIME',
      'hiringOrganization' => [
        '@type' => 'Organization',
        'name' => 'Employer using Applicants.io'
      ],
      'jobLocation' => [
        '@type' => 'Place',
        'address' => [
          '@type' => 'PostalAddress',
          'addressCountry' => 'US'
        ]
      ],
      'baseSalary' => [
        '@type' => 'MonetaryAmount',
        'currency' => 'USD'
      ]
    ],
    
    // Occupation
    [
      '@context' => 'https://schema.org',
      '@type' => 'Occupation',
      'name' => 'Recruiting Platform',
      'occupationLocation' => [
        '@type' => 'City',
        'name' => 'Worldwide'
      ],
      'skills' => ['JobPosting schema', 'Google Jobs optimization', 'Resume parsing', 'AI ranking']
    ]
  ];
}

/**
 * OurCasa.ai specific schemas
 */
function ourcasa_ai_schemas(): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/ourcasa-ai/';
  $productId = $productUrl . '#product';
  
  return [
    // Residence
    [
      '@context' => 'https://schema.org',
      '@type' => 'Residence',
      '@id' => $productId,
      'name' => 'Property Intelligence',
      'description' => 'OurCasa.ai provides comprehensive property and neighborhood intelligence',
      // A residence doesn't typically have offers in this context (it's not for sale as a residence), 
      // but if Google treats it as a Product due to context, adding offers is safe.
      // However, better to link it to the Service/Product ID
    ],
    
    // Place with GeoCoordinates
    [
      '@context' => 'https://schema.org',
      '@type' => 'Place',
      'name' => 'Property Location',
      'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => '',
        'longitude' => ''
      ]
    ],
    
    // LocalBusiness (service providers)
    [
      '@context' => 'https://schema.org',
      '@type' => 'LocalBusiness',
      'name' => 'Home Service Provider',
      'description' => 'Service providers connected through OurCasa.ai'
    ],
    
    // Service (home services)
    [
      '@context' => 'https://schema.org',
      '@type' => 'Service',
      '@id' => $productId, // Link to main product ID
      'name' => 'Property Intelligence Service',
      'serviceType' => 'Home Intelligence',
      'provider' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'areaServed' => 'Worldwide',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ]
  ];
}

/**
 * NEWFAQ specific schemas
 */
function newfaq_schemas(): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/newfaq/';
  $productId = $productUrl . '#product';
  
  return [
    // FAQPage
    [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      '@id' => $productId . '#faq',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'What is NEWFAQ and how does it differ from traditional FAQ systems?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ is a sentient FAQ and business intelligence engine that learns from customer queries, expands dynamically, and generates breakthrough SEO visibility. Unlike traditional static FAQ systems, NEWFAQ uses Precogs ontology and Croutons micro-facts to automatically classify queries, map user intent, generate accurate answers, and detect emerging topics. Every user prompt becomes semantic input that creates new FAQ content optimized for AI engines and search visibility.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How does NEWFAQ improve SEO and search visibility?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ creates SEO-optimized pages for location-specific questions, address-intent queries, and hyper-niche questions with no existing competition. This delivers instant indexing, deeper visibility, long-tail traffic capture, and industry vocabulary dominance. The system generates structured data, FAQPage schema, and content that AI engines like ChatGPT, Claude, and Perplexity can easily discover and cite.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'What technical infrastructure does NEWFAQ require?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ leverages the Precogs ontological reasoning engine and Croutons micro-fact infrastructure. It integrates with your existing content management system and requires structured data implementation, JSON-LD schema markup, and API endpoints for real-time query processing. The system works with any web platform that supports dynamic content generation and schema markup.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How quickly can NEWFAQ generate new FAQ content?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ processes queries in real-time. Every prompt entered into the NEWFAQ UI is logged, becomes semantic input, turns into a new seed question, and can be processed into a new public-facing FAQ page if warranted. The system automatically groups similar intents and prioritizes questions based on demand frequency and conversion potential.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'Does NEWFAQ require ongoing maintenance or manual content updates?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'No. NEWFAQ is self-expanding and self-optimizing. It learns from real customer queries, expands FAQ content dynamically, prioritizes questions by demand frequency, and eliminates dead content automatically. The system continuously improves both SEO visibility and business intelligence without manual intervention.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How does NEWFAQ measure success and ROI?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ tracks multiple metrics including SEO visibility improvements, long-tail traffic capture, AI engine citation rates, user engagement with FAQ content, and business intelligence insights from query patterns. The system provides comprehensive analytics showing how customer interactions translate to both SEO gains and actionable business intelligence.'
          ]
        ]
      ]
    ],
    
    // QAPage
    [
      '@context' => 'https://schema.org',
      '@type' => 'QAPage',
      'mainEntity' => [
        '@type' => 'Question',
        'name' => 'How does NEWFAQ improve SEO?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'NEWFAQ creates SEO-optimized pages for location-specific questions, address-intent queries, and hyper-niche questions with no existing competition, delivering instant indexing and long-tail traffic capture.'
        ]
      ]
    ],
    
    // SearchAction
    [
      '@context' => 'https://schema.org',
      '@type' => 'SearchAction',
      'target' => [
        '@type' => 'EntryPoint',
        'urlTemplate' => $productUrl . '?q={search_term_string}'
      ],
      'query-input' => 'required name=search_term_string'
    ]
  ];
}

/**
 * Googlebot Renderer Lab specific schemas
 */
function googlebot_renderer_schemas(): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/googlebot-renderer-lab/';
  $productId = $productUrl . '#product';
  
  return [
    // HowTo
    [
      '@context' => 'https://schema.org',
      '@type' => 'HowTo',
      'name' => 'How to Diagnose Googlebot Rendering Issues',
      'description' => 'Step-by-step guide to using Googlebot Renderer Lab to diagnose rendering failures',
      'step' => [
        [
          '@type' => 'HowToStep',
          'name' => 'Enter your URL',
          'text' => 'Enter the URL you want to test in Googlebot Renderer Lab'
        ],
        [
          '@type' => 'HowToStep',
          'name' => 'Analyze rendering',
          'text' => 'Review the DOM filmstrip and identify hydration mismatches'
        ],
        [
          '@type' => 'HowToStep',
          'name' => 'Fix issues',
          'text' => 'Address identified rendering failures and verify fixes'
        ]
      ]
    ],
    
    // LearningResource
    [
      '@context' => 'https://schema.org',
      '@type' => 'LearningResource',
      'name' => 'Googlebot Rendering Diagnostics',
      'description' => 'Learn how to diagnose and fix Googlebot rendering issues',
      'educationalLevel' => 'Advanced',
      'learningResourceType' => 'Tutorial',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ]
  ];
}

/**
 * HowTo schema generator
 */
function product_howto_schema(string $productSlug, string $productName, array $steps = []): array {
  if (empty($steps)) {
    $steps = [
      [
        '@type' => 'HowToStep',
        'name' => 'Get Started',
        'text' => 'Visit the product page to learn more about ' . $productName
      ],
      [
        '@type' => 'HowToStep',
        'name' => 'Explore Features',
        'text' => 'Review the core capabilities and features'
      ],
      [
        '@type' => 'HowToStep',
        'name' => 'Contact Us',
        'text' => 'Reach out to learn how ' . $productName . ' can help your business'
      ]
    ];
  }
  
  return [
    '@context' => 'https://schema.org',
    '@type' => 'HowTo',
    'name' => 'How to Use ' . $productName,
    'description' => 'Step-by-step guide to using ' . $productName,
    'step' => $steps
  ];
}

/**
 * ImageObject schema generator
 */
function product_image_schema(string $imageUrl, string $caption = ''): array {
  return [
    '@context' => 'https://schema.org',
    '@type' => 'ImageObject',
    'url' => SchemaFixes::ensureHttps($imageUrl),
    'caption' => $caption
  ];
}

/**
 * VideoObject schema generator
 */
function product_video_schema(string $videoUrl, string $name, string $description, ?string $thumbnailUrl = null): array {
  return [
    '@context' => 'https://schema.org',
    '@type' => 'VideoObject',
    'name' => $name,
    'description' => $description,
    'contentUrl' => $videoUrl,
    'embedUrl' => $videoUrl,
    'thumbnailUrl' => $thumbnailUrl ? SchemaFixes::ensureHttps($thumbnailUrl) : SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png')),
    'uploadDate' => date('c'),
    'publisher' => [
      '@type' => 'Organization',
      'name' => 'Neural Command',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png'))
      ]
    ]
  ];
}

