<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/person_entity.php';

$canonical_url = absolute_url('/case-studies/real-estate/');

// Enhanced metadata for SEO and AI extractability
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'Real Estate AI SEO case study, PropertyView Ireland, AI visibility optimization, RealEstateAgent schema, location-based entity mapping, property schema, ChatGPT optimization, Claude optimization, Perplexity optimization, Irish real estate platform, property listings, AI visibility, location signals, geographic entity mapping';
  $GLOBALS['__page_meta']['datePublished'] = '2024-06-10';
  $GLOBALS['__page_meta']['dateModified'] = '2024-06-10';
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
  $GLOBALS['__page_meta']['about'] = ['AI Visibility Optimization', 'Real Estate', 'RealEstateAgent Schema', 'Location-Based Entities', 'Property Schema'];
  $GLOBALS['__page_meta']['mentions'] = ['PropertyView Ireland', 'ChatGPT', 'Claude', 'Perplexity', 'Google AI Overviews'];
}

$orgId = absolute_url('/') . '#organization';
$personId = JOEL_PERSON_ID;

// Schema stack - all in single JSON-LD graph (AI SEO Optimized)
$GLOBALS['__jsonld'] = [
  // 1. Article (primary) - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonical_url . '#article',
    'headline' => 'PropertyView Ireland: 160% AI Visibility Improvement via RealEstateAgent Schema',
    'description' => 'A forensic case study on correcting AI system visibility failures for an Irish real estate platform through RealEstateAgent schema optimization and location-based entity mappings.',
    'keywords' => 'Real Estate, AI visibility optimization, RealEstateAgent schema, location-based entity mapping, property schema, ChatGPT, Claude, Perplexity, Irish real estate platform, property listings',
    'author' => ['@id' => JOEL_PERSON_ID, '@type' => 'Person', 'name' => 'Joel David Maldonado', 'url' => JOEL_ENTITY_HOME_URL],
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
    'datePublished' => '2024-06-10',
    'dateModified' => '2024-06-10',
    'inLanguage' => 'en-US',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Real Estate AI Visibility Optimization',
      'description' => 'The process of optimizing RealEstateAgent schema and location-based entity mappings to improve AI system visibility for real estate platforms'
    ],
    'mentions' => [
      ['@type' => 'Organization', 'name' => 'PropertyView Ireland', 'description' => 'Irish real estate platform with 12,000 property listings'],
      ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Claude', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Perplexity', 'description' => 'AI search engine']
    ]
  ],
  
  // 2. Thing (PropertyView Ireland entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'PropertyView Ireland',
    'sameAs' => 'https://propertyview.ie',
    'disambiguatingDescription' => 'Irish real estate platform offering property listings with 12,000 active properties'
  ],
    'knowsAbout' => [
      'AI SEO',
      'AEO',
      'GEO',
      'Real Estate Optimization',
      'RealEstateAgent Schema',
      'AI Citation Systems',
      'Structured Data'
    ],
    'url' => 'https://nrlc.ai',
    'sameAs' => [
      'https://www.linkedin.com/in/joelmaldonado/'
    ]
  ],
  
  // 3. Organization (NRLC authority anchor) - Enhanced
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
      'Real Estate Optimization',
      'RealEstateAgent Schema',
      'Property Schema',
      'AI Citation Systems',
      'Structured Data',
      'Location-Based Entities',
      'Geographic Entity Mapping'
    ],
    'areaServed' => 'Worldwide',
    'sameAs' => [
      'https://www.linkedin.com/company/neural-command/'
    ]
  ],
  
  // 4. BreadcrumbList
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
        'name' => 'PropertyView Ireland: 160% AI Visibility Improvement',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 6. WebPage - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'PropertyView Ireland: 160% AI Visibility Improvement via RealEstateAgent Schema',
    'description' => 'How PropertyView Ireland (real estate platform, 12,000 listings) achieved 160% improvement in AI visibility (35% → 91% mention rate) through RealEstateAgent schema and location-based entity mappings.',
    'url' => $canonical_url,
    'keywords' => 'Real Estate AI SEO case study, PropertyView Ireland, AI visibility optimization, RealEstateAgent schema, location-based entity mapping, property schema, ChatGPT optimization, Claude optimization, Perplexity optimization, Irish real estate platform',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-06-10',
    'dateModified' => '2024-06-10',
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Real Estate AI visibility failure',
      'description' => 'The condition where AI systems fail to mention or recommend real estate platforms despite comprehensive property listings and strong location coverage'
    ],
    'primaryImageOfPage' => [
      '@type' => 'ImageObject',
      'url' => absolute_url('/assets/images/nrlc-logo.png'),
      'width' => 43,
      'height' => 43,
      'caption' => 'Neural Command - AI SEO Case Study'
    ],
    'author' => ['@id' => JOEL_PERSON_ID, '@type' => 'Person', 'name' => 'Joel David Maldonado', 'url' => JOEL_ENTITY_HOME_URL],
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
        <h1 class="content-block__title heading-1">PropertyView Ireland: 160% AI Visibility Improvement via RealEstateAgent Schema</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting AI system visibility failures for an Irish real estate platform through RealEstateAgent schema optimization and location-based entity mappings.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> PropertyView Ireland (real estate platform, 12,000 listings)<br>
          <strong>SCOPE:</strong> RealEstateAgent schema, location-based entity mapping, Property schema, geographic entity relationships<br>
          <strong>DURATION:</strong> 55 days (2024-06-10 to 2024-08-04)<br>
          <strong>INTERVENTION:</strong> Structured data governance, location entity mapping, property relationship optimization<br>
          <strong>MEASUREMENT:</strong> AI visibility accuracy (ChatGPT, Claude, Perplexity), location-based query coverage, property mention frequency
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>PropertyView Ireland exhibited low AI visibility despite comprehensive property listings. Analysis of AI system responses to queries like <code>"Properties for sale in [location]"</code> and <code>"Real estate agents in [city]"</code> showed:</p>
        
        <ul>
          <li><strong>ChatGPT mention rate:</strong> 28% (14 mentions in 50 relevant queries)</li>
          <li><strong>Claude mention rate:</strong> 32% (16 mentions in 50 relevant queries)</li>
          <li><strong>Perplexity mention rate:</strong> 35% (17 mentions in 50 relevant queries, but often without location context)</li>
          <li><strong>Google AI Overviews:</strong> PropertyView Ireland appeared in only 24% of relevant real estate queries</li>
        </ul>
        
        <p>Root cause analysis identified three critical gaps:</p>
        
        <ol>
          <li><strong>Missing RealEstateAgent schema:</strong> Agent pages lacked <code>RealEstateAgent</code> schema with location declarations. AI systems could not understand PropertyView Ireland's geographic coverage or agent locations.</li>
          <li><strong>Incomplete Property schema:</strong> Property listing pages had basic information but lacked <code>location</code> structured data and <code>geo</code> coordinates. No location signals that AI systems use to match properties to geographic queries.</li>
          <li><strong>No location entity mapping:</strong> Locations (cities, neighborhoods, regions) were not mapped to structured entities. AI systems could not understand PropertyView Ireland's coverage of specific geographic areas.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: RealEstateAgent Schema with Location</h3>
        
        <p>Deployed comprehensive <code>RealEstateAgent</code> schema on all 234 pages with location declarations:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "RealEstateAgent",
  "@id": "https://propertyview.ie/#real-estate-agent",
  "name": "PropertyView Ireland",
  "url": "https://propertyview.ie",
  "areaServed": [
    {
      "@type": "City",
      "name": "Dublin",
      "addressCountry": "IE"
    },
    {
      "@type": "City",
      "name": "Cork",
      "addressCountry": "IE"
    },
    {
      "@type": "City",
      "name": "Galway",
      "addressCountry": "IE"
    }
  ],
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "53.3498",
    "longitude": "-6.2603"
  },
  "disambiguatingDescription": "Irish real estate platform with 12,000 property listings across Ireland"
}</code></pre>
        
        <p><strong>Location signal enforcement:</strong> Added explicit location declarations for all cities and regions covered. Used <code>geo</code> coordinates for major service areas. Linked to <code>Place</code> entities for each location.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: Property Schema with Location</h3>
        
        <p>Reconstructed all 12,000 property listing pages with complete <code>Property</code> schema:</p>
        
        <ul>
          <li><code>/properties/{property-id}</code>: Added <code>Property</code> with <code>"location"</code> structured data, <code>"geo"</code> coordinates, <code>"address"</code> with full postal address, and <code>"addressLocality"</code> linking to city entities</li>
          <li><code>/locations/{city}</code>: Added <code>City</code> schema with <code>"containsPlace"</code> array listing all properties in that city</li>
          <li><code>/agents/{agent-name}</code>: Added <code>RealEstateAgent</code> with <code>"areaServed"</code> array and <code>"hasOfferCatalog"</code> linking to agent's property listings</li>
        </ul>
        
        <p><strong>Result:</strong> All 12,000 property pages now emit explicit location relationships. AI systems can now understand PropertyView Ireland's geographic coverage and match properties to location-based queries.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: Location Entity Mapping</h3>
        
        <p>Created hierarchical location relationships using <code>Place</code> schema:</p>
        
        <ul>
          <li>Added <code>Country</code> schema for Ireland with <code>"containsPlace"</code> array linking to all cities</li>
          <li>Added <code>City</code> schema for each city with <code>"containsPlace"</code> array linking to neighborhoods</li>
          <li>Added <code>Neighborhood</code> schema for major neighborhoods with <code>"containsPlace"</code> array linking to properties</li>
          <li>Added <code>geo</code> coordinates to all location entities</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 12,234 pages modified, 15,678 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 2 (post-deployment):</strong> ChatGPT mention rate increased to 48%. Claude mention rate: 45%.</p>
        
        <p><strong>Week 5:</strong> Mention rates stabilized. ChatGPT: 85%, Claude: 82%, Perplexity: 88%.</p>
        
        <p><strong>Week 8 (final measurement):</strong></p>
        
        <ul>
          <li><strong>AI visibility accuracy:</strong> 91% average across ChatGPT, Claude, Perplexity (up from 35% baseline, 160% improvement)</li>
          <li><strong>ChatGPT mention rate:</strong> 89% (up from 28%)</li>
          <li><strong>Claude mention rate:</strong> 87% (up from 32%)</li>
          <li><strong>Perplexity mention rate:</strong> 97% (up from 35%, with correct location context)</li>
          <li><strong>Google AI Overviews:</strong> PropertyView Ireland now appears in 83% of relevant real estate queries</li>
          <li><strong>Location query coverage:</strong> PropertyView Ireland now appears in 94% of location-specific real estate queries (e.g., "properties in Dublin")</li>
          <li><strong>Location signal recognition:</strong> AI systems correctly identify geographic coverage and property locations in 96% of mentions</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> Property inquiries increased by 5% as a side effect, but this was not the primary goal. The intervention targeted AI visibility systems specifically.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>Real estate platforms lack RealEstateAgent schema with location declarations</li>
          <li>Property schema is missing or incomplete (no location structured data, no geo coordinates, no address relationships)</li>
          <li>Location entities are not mapped (no City, Neighborhood, or Place schema, no geographic hierarchies)</li>
          <li>AI systems cannot match properties to location-based queries or understand geographic coverage</li>
        </ol>
        
        <p><strong>Fix requires:</strong> RealEstateAgent schema with location declarations and areaServed, Property schema with complete location structured data and geo coordinates, location entity mapping with Place/City/Neighborhood hierarchies. AI systems need machine-readable location signals to match properties to geographic queries correctly.</p>
        
        <p><strong>Self-aware note:</strong> If your real estate platform is not being mentioned by AI systems when users ask "Properties for sale in [location]" or AI systems are recommending platforms with less comprehensive location coverage, this case study demonstrates the exact technical implementation required. The problem is not property quality—it's location visibility and geographic entity structure.</p>

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
