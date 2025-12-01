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
        '@type' => 'Product',
        'name' => $productName
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
      'image' => $imageUrl ? SchemaFixes::ensureHttps($imageUrl) : SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png'))
    ],
    
    // Offer (required by Google)
    [
      '@context' => 'https://schema.org',
      '@type' => 'Offer',
      'itemOffered' => [
        '@type' => 'Product',
        'name' => $productName
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
  
  return [
    // SoftwareApplication
    [
      '@context' => 'https://schema.org',
      '@type' => 'SoftwareApplication',
      'name' => $productName,
      'description' => $productDescription,
      'url' => $productUrl,
      'applicationCategory' => $applicationCategory,
      'operatingSystem' => 'Web',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0'
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
      'name' => $productName,
      'url' => $productUrl,
      'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
      'applicationCategory' => $applicationCategory,
      'operatingSystem' => 'Any'
    ],
    
    // Service
    [
      '@context' => 'https://schema.org',
      '@type' => 'Service',
      'name' => $productName,
      'description' => $productDescription,
      'provider' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'areaServed' => 'Worldwide',
      'serviceType' => $productName
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
        '@type' => 'Thing',
        'name' => $productName
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
  
  return [
    // Dataset
    [
      '@context' => 'https://schema.org',
      '@type' => 'Dataset',
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
      ]
    ],
    
    // DataCatalog
    [
      '@context' => 'https://schema.org',
      '@type' => 'DataCatalog',
      'name' => $productName . ' Data Catalog',
      'description' => 'Catalog of structured data and micro-facts',
      'url' => $productUrl,
      'keywords' => ['data catalog', 'micro-facts', 'structured knowledge']
    ],
    
    // DataFeed
    [
      '@context' => 'https://schema.org',
      '@type' => 'DataFeed',
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
  
  return [
    // Residence
    [
      '@context' => 'https://schema.org',
      '@type' => 'Residence',
      'name' => 'Property Intelligence',
      'description' => 'OurCasa.ai provides comprehensive property and neighborhood intelligence'
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
      'name' => 'Property Intelligence Service',
      'serviceType' => 'Home Intelligence',
      'provider' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'areaServed' => 'Worldwide'
    ]
  ];
}

/**
 * NEWFAQ specific schemas
 */
function newfaq_schemas(): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/newfaq/';
  
  return [
    // FAQPage
    [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'What is NEWFAQ?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ is a sentient FAQ and business intelligence engine that learns from customer queries, expands dynamically, and generates breakthrough SEO visibility.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How does NEWFAQ work?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'NEWFAQ uses Precogs ontology and Croutons micro-facts to classify queries, map user intent, generate accurate answers, and detect emerging topics. Every user prompt becomes semantic input that creates new FAQ content.'
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
      'learningResourceType' => 'Tutorial'
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

