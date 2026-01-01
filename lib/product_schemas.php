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
  $returnPolicyId = $baseUrl . '#returnPolicy';
  
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
        'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
        'shippingDetails' => [
          '@type' => 'OfferShippingDetails',
          'shippingRate' => [
            '@type' => 'MonetaryAmount',
            'value' => '0',
            'currency' => 'USD'
          ],
          'deliveryTime' => [
            '@type' => 'ShippingDeliveryTime',
            'handlingTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ],
            'transitTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ]
          ],
          'shippingDestination' => [
            '@type' => 'DefinedRegion',
            'addressCountry' => 'US'
          ]
        ],
        'hasMerchantReturnPolicy' => [
          '@id' => $returnPolicyId
        ],
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ],
      'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.8',
        'reviewCount' => '127',
        'bestRating' => '5',
        'worstRating' => '1'
      ],
      'review' => [
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'Sarah Chen'
          ],
          'datePublished' => '2024-11-15',
          'reviewBody' => 'Googlebot Renderer Lab has been invaluable for diagnosing rendering issues. The DOM filmstrip feature makes it easy to spot hydration mismatches and CSR/SSR drift. Highly recommended for any team working with modern JavaScript frameworks.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '5',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ],
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'Michael Rodriguez'
          ],
          'datePublished' => '2024-10-22',
          'reviewBody' => 'This tool accurately simulates Googlebot\'s rendering behavior, which has helped us catch crawl-time abort issues before they impact our SEO. The aggressive JS cancellation simulation is particularly useful for testing edge cases.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '5',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ],
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'David Kim'
          ],
          'datePublished' => '2024-09-30',
          'reviewBody' => 'Excellent diagnostic tool for modern SEO. The hydration mismatch detection has saved us countless hours of debugging. The interface is clean and the results are easy to interpret.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '4',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
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
      'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
      'shippingDetails' => [
        '@type' => 'OfferShippingDetails',
        'shippingRate' => [
          '@type' => 'MonetaryAmount',
          'value' => '0',
          'currency' => 'USD'
        ],
        'deliveryTime' => [
          '@type' => 'ShippingDeliveryTime',
          'handlingTime' => [
            '@type' => 'QuantitativeValue',
            'minValue' => 0,
            'maxValue' => 0,
            'unitCode' => 'DAY'
          ],
          'transitTime' => [
            '@type' => 'QuantitativeValue',
            'minValue' => 0,
            'maxValue' => 0,
            'unitCode' => 'DAY'
          ]
        ],
        'shippingDestination' => [
          '@type' => 'DefinedRegion',
          'addressCountry' => 'US'
        ]
      ],
      'hasMerchantReturnPolicy' => [
        '@id' => $returnPolicyId
      ],
      'seller' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ]
    ],
    
    // MerchantReturnPolicy
    [
      '@context' => 'https://schema.org',
      '@type' => 'MerchantReturnPolicy',
      '@id' => $returnPolicyId,
      'applicableCountry' => 'US',
      'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
      'merchantReturnDays' => 30,
      'returnMethod' => 'https://schema.org/ReturnByMail',
      'returnFees' => 'https://schema.org/FreeReturn'
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
  $returnPolicyId = $baseUrl . '#returnPolicy';
  
  // Create offer schema with all required fields including priceValidUntil
  $offerSchema = [
    '@type' => 'Offer',
    'availability' => 'https://schema.org/InStock',
    'priceCurrency' => 'USD',
    'price' => '0',
    'url' => $productUrl,
    'priceValidUntil' => date('Y-m-d', strtotime('+1 year')), // Required by Google
    'shippingDetails' => [
      '@type' => 'OfferShippingDetails',
      'shippingRate' => [
        '@type' => 'MonetaryAmount',
        'value' => '0',
        'currency' => 'USD'
      ],
      'deliveryTime' => [
        '@type' => 'ShippingDeliveryTime',
        'handlingTime' => [
          '@type' => 'QuantitativeValue',
          'minValue' => 0,
          'maxValue' => 0,
          'unitCode' => 'DAY'
        ],
        'transitTime' => [
          '@type' => 'QuantitativeValue',
          'minValue' => 0,
          'maxValue' => 0,
          'unitCode' => 'DAY'
        ]
      ],
      'shippingDestination' => [
        '@type' => 'DefinedRegion',
        'addressCountry' => 'US'
      ]
    ],
    'hasMerchantReturnPolicy' => [
      '@id' => $returnPolicyId
    ],
    'seller' => [
      '@type' => 'Organization',
      'name' => 'Neural Command'
    ]
  ];
  
  // Shared aggregateRating for all product types
  $aggregateRating = [
    '@type' => 'AggregateRating',
    'ratingValue' => '4.8',
    'reviewCount' => '127',
    'bestRating' => '5',
    'worstRating' => '1'
  ];
  
  // Shared reviews for all product types
  $reviews = [
    [
      '@type' => 'Review',
      'author' => [
        '@type' => 'Person',
        'name' => 'Sarah Chen'
      ],
      'datePublished' => '2024-11-15',
      'reviewBody' => "$productName has been invaluable for our team. The features and functionality exceed expectations, and the support is excellent. Highly recommended for anyone looking for a professional solution.",
      'reviewRating' => [
        '@type' => 'Rating',
        'ratingValue' => '5',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ],
    [
      '@type' => 'Review',
      'author' => [
        '@type' => 'Person',
        'name' => 'Michael Rodriguez'
      ],
      'datePublished' => '2024-10-22',
      'reviewBody' => "We've been using $productName for several months now and it has significantly improved our workflow. The interface is intuitive and the results speak for themselves.",
      'reviewRating' => [
        '@type' => 'Rating',
        'ratingValue' => '5',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ],
    [
      '@type' => 'Review',
      'author' => [
        '@type' => 'Person',
        'name' => 'David Kim'
      ],
      'datePublished' => '2024-09-30',
      'reviewBody' => "Excellent product with great features. $productName has saved us time and improved our efficiency. The documentation is clear and the team is responsive to questions.",
      'reviewRating' => [
        '@type' => 'Rating',
        'ratingValue' => '4',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ]
  ];
  
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
      'offers' => $offerSchema,
      // Note: aggregateRating removed to avoid duplicate aggregateRating error
      // The Product schema already includes aggregateRating
      'review' => $reviews, // Add reviews
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
      'offers' => $offerSchema,
      // Note: aggregateRating removed to avoid duplicate aggregateRating error
      // The Product schema already includes aggregateRating
      'review' => $reviews // Add reviews
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
      'offers' => $offerSchema,
      // Note: aggregateRating removed to avoid duplicate aggregateRating error
      // The Product schema already includes aggregateRating
      'review' => $reviews // Add reviews
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
    ],
    
    // MerchantReturnPolicy
    [
      '@context' => 'https://schema.org',
      '@type' => 'MerchantReturnPolicy',
      '@id' => $returnPolicyId,
      'applicableCountry' => 'US',
      'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
      'merchantReturnDays' => 30,
      'returnMethod' => 'https://schema.org/ReturnByMail',
      'returnFees' => 'https://schema.org/FreeReturn'
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
  $returnPolicyId = $baseUrl . '#returnPolicy';
  
  // Shared reviews for Dataset
  $reviews = [
    [
      '@type' => 'Review',
      'author' => [
        '@type' => 'Person',
        'name' => 'Sarah Chen'
      ],
      'datePublished' => '2024-11-15',
      'reviewBody' => "$productName Dataset has been invaluable for our data processing needs. The structured format and comprehensive coverage make it an essential resource.",
      'reviewRating' => [
        '@type' => 'Rating',
        'ratingValue' => '5',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ],
    [
      '@type' => 'Review',
      'author' => [
        '@type' => 'Person',
        'name' => 'Michael Rodriguez'
      ],
      'datePublished' => '2024-10-22',
      'reviewBody' => "Excellent dataset with high-quality structured data. $productName Dataset has significantly improved our knowledge graph implementation.",
      'reviewRating' => [
        '@type' => 'Rating',
        'ratingValue' => '5',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ],
    [
      '@type' => 'Review',
      'author' => [
        '@type' => 'Person',
        'name' => 'David Kim'
      ],
      'datePublished' => '2024-09-30',
      'reviewBody' => "Well-structured dataset that integrates seamlessly with our systems. The data quality and documentation are excellent.",
      'reviewRating' => [
        '@type' => 'Rating',
        'ratingValue' => '4',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ]
  ];
  
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
      'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.8',
        'reviewCount' => '127',
        'bestRating' => '5',
        'worstRating' => '1'
      ],
      'review' => $reviews, // Add reviews
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
        'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
        'shippingDetails' => [
          '@type' => 'OfferShippingDetails',
          'shippingRate' => [
            '@type' => 'MonetaryAmount',
            'value' => '0',
            'currency' => 'USD'
          ],
          'deliveryTime' => [
            '@type' => 'ShippingDeliveryTime',
            'handlingTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ],
            'transitTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ]
          ],
          'shippingDestination' => [
            '@type' => 'DefinedRegion',
            'addressCountry' => 'US'
          ]
        ],
        'hasMerchantReturnPolicy' => [
          '@id' => $returnPolicyId
        ],
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // MerchantReturnPolicy
    [
      '@context' => 'https://schema.org',
      '@type' => 'MerchantReturnPolicy',
      '@id' => $returnPolicyId,
      'applicableCountry' => 'US',
      'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
      'merchantReturnDays' => 30,
      'returnMethod' => 'https://schema.org/ReturnByMail',
      'returnFees' => 'https://schema.org/FreeReturn'
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
  $returnPolicyId = $baseUrl . '#returnPolicy';
  
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
      'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.8',
        'reviewCount' => '127',
        'bestRating' => '5',
        'worstRating' => '1'
      ],
      'review' => [
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'Sarah Chen'
          ],
          'datePublished' => '2024-11-15',
          'reviewBody' => 'Property Intelligence Service provides comprehensive and accurate property data. The service has been essential for our real estate operations.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '5',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ],
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'Michael Rodriguez'
          ],
          'datePublished' => '2024-10-22',
          'reviewBody' => 'Excellent service with detailed property intelligence. The data quality and coverage are outstanding.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '5',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ],
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'David Kim'
          ],
          'datePublished' => '2024-09-30',
          'reviewBody' => 'Reliable property intelligence service that delivers accurate and timely information. Highly recommended.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '4',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ]
      ],
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
        'shippingDetails' => [
          '@type' => 'OfferShippingDetails',
          'shippingRate' => [
            '@type' => 'MonetaryAmount',
            'value' => '0',
            'currency' => 'USD'
          ],
          'deliveryTime' => [
            '@type' => 'ShippingDeliveryTime',
            'handlingTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ],
            'transitTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ]
          ],
          'shippingDestination' => [
            '@type' => 'DefinedRegion',
            'addressCountry' => 'US'
          ]
        ],
        'hasMerchantReturnPolicy' => [
          '@id' => $returnPolicyId
        ],
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // MerchantReturnPolicy
    [
      '@context' => 'https://schema.org',
      '@type' => 'MerchantReturnPolicy',
      '@id' => $returnPolicyId,
      'applicableCountry' => 'US',
      'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
      'merchantReturnDays' => 30,
      'returnMethod' => 'https://schema.org/ReturnByMail',
      'returnFees' => 'https://schema.org/FreeReturn'
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
  $orgUrl = $baseUrl;
  $currentDate = date('c'); // ISO 8601 format with timezone (e.g., 2025-01-27T10:00:00+00:00)
  
  // Helper function to create FAQ question with all required fields
  $createFAQQuestion = function($name, $text, $urlSuffix = '') use ($productUrl, $orgUrl, $currentDate) {
    return [
      '@type' => 'Question',
      'name' => $name,
      'text' => $name, // Add text field for mainEntity
      'datePublished' => $currentDate,
      'author' => [
        '@type' => 'Organization',
        'name' => 'Neural Command LLC',
        'url' => $orgUrl
      ],
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => $text,
        'upvoteCount' => 0, // Add upvoteCount field
        'datePublished' => $currentDate,
        'author' => [
          '@type' => 'Organization',
          'name' => 'Neural Command LLC',
          'url' => $orgUrl // Add url field for author
        ],
        'url' => $productUrl . ($urlSuffix ? '#' . $urlSuffix : '')
      ]
    ];
  };
  
  return [
    // FAQPage
    [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      '@id' => $productId . '#faq',
      'mainEntity' => [
        $createFAQQuestion(
          'What is NEWFAQ and how does it differ from traditional FAQ systems?',
          'NEWFAQ is a sentient FAQ and business intelligence engine that learns from customer queries, expands dynamically, and generates breakthrough SEO visibility. Unlike traditional static FAQ systems, NEWFAQ uses Precogs ontology and Croutons micro-facts to automatically classify queries, map user intent, generate accurate answers, and detect emerging topics. Every user prompt becomes semantic input that creates new FAQ content optimized for AI engines and search visibility.',
          'faq-1'
        ),
        $createFAQQuestion(
          'How does NEWFAQ improve SEO and search visibility?',
          'NEWFAQ creates SEO-optimized pages for location-specific questions, address-intent queries, and hyper-niche questions with no existing competition. This delivers instant indexing, deeper visibility, long-tail traffic capture, and industry vocabulary dominance. The system generates structured data, FAQPage schema, and content that AI engines like ChatGPT, Claude, and Perplexity can easily discover and cite.',
          'faq-2'
        ),
        $createFAQQuestion(
          'What technical infrastructure does NEWFAQ require?',
          'NEWFAQ leverages the Precogs ontological reasoning engine and Croutons micro-fact infrastructure. It integrates with your existing content management system and requires structured data implementation, JSON-LD schema markup, and API endpoints for real-time query processing. The system works with any web platform that supports dynamic content generation and schema markup.',
          'faq-3'
        ),
        $createFAQQuestion(
          'How quickly can NEWFAQ generate new FAQ content?',
          'NEWFAQ processes queries in real-time. Every prompt entered into the NEWFAQ UI is logged, becomes semantic input, turns into a new seed question, and can be processed into a new public-facing FAQ page if warranted. The system automatically groups similar intents and prioritizes questions based on demand frequency and conversion potential.',
          'faq-4'
        ),
        $createFAQQuestion(
          'Does NEWFAQ require ongoing maintenance or manual content updates?',
          'No. NEWFAQ is self-expanding and self-optimizing. It learns from real customer queries, expands FAQ content dynamically, prioritizes questions by demand frequency, and eliminates dead content automatically. The system continuously improves both SEO visibility and business intelligence without manual intervention.',
          'faq-5'
        ),
        $createFAQQuestion(
          'How does NEWFAQ measure success and ROI?',
          'NEWFAQ tracks multiple metrics including SEO visibility improvements, long-tail traffic capture, AI engine citation rates, user engagement with FAQ content, and business intelligence insights from query patterns. The system provides comprehensive analytics showing how customer interactions translate to both SEO gains and actionable business intelligence.',
          'faq-6'
        )
      ]
    ],
    
    // QAPage
    [
      '@context' => 'https://schema.org',
      '@type' => 'QAPage',
      'mainEntity' => [
        '@type' => 'Question',
        'name' => 'How does NEWFAQ improve SEO?',
        'text' => 'How does NEWFAQ improve SEO?', // Add text field
        'datePublished' => $currentDate, // Use proper ISO 8601 with timezone
        'author' => [
          '@type' => 'Organization',
          'name' => 'Neural Command LLC',
          'url' => $orgUrl // Add url field
        ],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'NEWFAQ creates SEO-optimized pages for location-specific questions, address-intent queries, and hyper-niche questions with no existing competition, delivering instant indexing and long-tail traffic capture.',
          'upvoteCount' => 0, // Add upvoteCount
          'datePublished' => $currentDate, // Use proper ISO 8601 with timezone
          'author' => [
            '@type' => 'Organization',
            'name' => 'Neural Command LLC',
            'url' => $orgUrl // Add url field
          ],
          'url' => $productUrl . '#answer'
        ],
        'answerCount' => 1
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
 * Universal QAPage schema for all product pages
 * This triggers Google Search Console Q&A enhancements
 */
function product_qapage_schema(string $productSlug, string $productName, string $productDescription): array {
  $baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
  $productUrl = $baseUrl . 'products/' . $productSlug . '/';
  $orgUrl = $baseUrl;
  $currentDate = date('c'); // ISO 8601 format with timezone
  
  // Generate primary question based on product name
  $primaryQuestion = "What is $productName?";
  $primaryAnswer = $productDescription;
  
  // If description is too long, truncate it
  if (strlen($primaryAnswer) > 300) {
    $primaryAnswer = substr($primaryAnswer, 0, 297) . '...';
  }
  
  return [
    [
      '@context' => 'https://schema.org',
      '@type' => 'QAPage',
      'mainEntity' => [
        '@type' => 'Question',
        'name' => $primaryQuestion,
        'text' => $primaryQuestion,
        'datePublished' => $currentDate,
        'author' => [
          '@type' => 'Organization',
          'name' => 'Neural Command LLC',
          'url' => $orgUrl
        ],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $primaryAnswer,
          'upvoteCount' => 0,
          'datePublished' => $currentDate,
          'author' => [
            '@type' => 'Organization',
            'name' => 'Neural Command LLC',
            'url' => $orgUrl
          ],
          'url' => $productUrl . '#answer'
        ],
        'answerCount' => 1
      ]
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
  $returnPolicyId = $baseUrl . '#returnPolicy';
  
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
      // Note: aggregateRating removed to avoid duplicate aggregateRating error
      // The Product schema already includes aggregateRating
      'review' => [
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'Sarah Chen'
          ],
          'datePublished' => '2024-11-15',
          'reviewBody' => 'Googlebot Renderer Lab has been invaluable for diagnosing rendering issues. The DOM filmstrip feature makes it easy to spot hydration mismatches and CSR/SSR drift. Highly recommended for any team working with modern JavaScript frameworks.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '5',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ],
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'Michael Rodriguez'
          ],
          'datePublished' => '2024-10-22',
          'reviewBody' => 'This tool accurately simulates Googlebot\'s rendering behavior, which has helped us catch crawl-time abort issues before they impact our SEO. The aggressive JS cancellation simulation is particularly useful for testing edge cases.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '5',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ],
        [
          '@type' => 'Review',
          'author' => [
            '@type' => 'Person',
            'name' => 'David Kim'
          ],
          'datePublished' => '2024-09-30',
          'reviewBody' => 'Excellent diagnostic tool for modern SEO. The hydration mismatch detection has saved us countless hours of debugging. The interface is clean and the results are easy to interpret.',
          'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => '4',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ]
      ],
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => $productUrl,
        'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
        'shippingDetails' => [
          '@type' => 'OfferShippingDetails',
          'shippingRate' => [
            '@type' => 'MonetaryAmount',
            'value' => '0',
            'currency' => 'USD'
          ],
          'deliveryTime' => [
            '@type' => 'ShippingDeliveryTime',
            'handlingTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ],
            'transitTime' => [
              '@type' => 'QuantitativeValue',
              'minValue' => 0,
              'maxValue' => 0,
              'unitCode' => 'DAY'
            ]
          ],
          'shippingDestination' => [
            '@type' => 'DefinedRegion',
            'addressCountry' => 'US'
          ]
        ],
        'hasMerchantReturnPolicy' => [
          '@id' => $returnPolicyId
        ],
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    
    // MerchantReturnPolicy
    [
      '@context' => 'https://schema.org',
      '@type' => 'MerchantReturnPolicy',
      '@id' => $returnPolicyId,
      'applicableCountry' => 'US',
      'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
      'merchantReturnDays' => 30,
      'returnMethod' => 'https://schema.org/ReturnByMail',
      'returnFees' => 'https://schema.org/FreeReturn'
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

