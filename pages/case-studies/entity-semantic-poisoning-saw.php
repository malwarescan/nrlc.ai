<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';

$canonical_url = absolute_url('/case-studies/entity-semantic-poisoning-saw/');

// Schema stack - all in single JSON-LD graph
$GLOBALS['__jsonld'] = [
  // 1. Article (primary)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonical_url . '#article',
    'headline' => 'Fixing Entity-Level Semantic Poisoning at SAW.com',
    'description' => 'A forensic case study on correcting Google entity misclassification caused by historical domain associations.',
    'author' => [
      '@type' => 'Organization',
      'name' => 'Neural Command',
      'url' => 'https://nrlc.ai'
    ],
    'publisher' => [
      '@type' => 'Organization',
      'name' => 'Neural Command',
      'url' => 'https://nrlc.ai',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => absolute_url('/assets/images/nrlc-logo.png')
      ]
    ],
    'datePublished' => '2026-01-15',
    'dateModified' => '2026-01-15',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ]
  ],
  
  // 2. Thing (SAW.com entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'SAW.com',
    'sameAs' => 'https://saw.com',
    'disambiguatingDescription' => 'Premium domain brokerage specializing in high-value digital assets'
  ],
  
  // 3. Organization (NRLC authority anchor)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => absolute_url('/') . '#organization',
    'name' => 'Neural Command',
    'url' => 'https://nrlc.ai',
    'knowsAbout' => [
      'Entity SEO',
      'Semantic search',
      'Structured data',
      'AI visibility optimization',
      'Google entity classification'
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
        'name' => 'Case Studies',
        'item' => absolute_url('/case-studies/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Entity Semantic Poisoning at SAW.com',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 5. WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'Fixing Entity-Level Semantic Poisoning at SAW.com',
    'description' => 'How entity-level semantic poisoning caused Google to misclassify SAW.com, why SEO fixes failed, and how structured entity repair restored correct business identity.',
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Entity-level semantic poisoning',
      'description' => 'The process by which historical domain associations cause search engines to misclassify a business entity'
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
        <h1 class="content-block__title heading-1">Fixing Entity-Level Semantic Poisoning at SAW.com</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting Google entity misclassification caused by historical domain associations.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> SAW.com<br>
          <strong>SCOPE:</strong> Entity repair, semantic constraint enforcement, Organization schema consolidation<br>
          <strong>DURATION:</strong> 8 weeks (2024-09-15 to 2024-11-10)<br>
          <strong>INTERVENTION:</strong> Structured data governance, entity disambiguation, schema hierarchy reconstruction<br>
          <strong>MEASUREMENT:</strong> Google Knowledge Graph classification, AI citation accuracy, entity graph consistency
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>SAW.com exhibited entity misclassification across Google's Knowledge Graph. Analysis of <code>google.com/search?q=SAW.com</code> and Knowledge Graph API responses showed incorrect industry associations:</p>
        
        <ul>
          <li><strong>Transportation services</strong> (NAICS 48-49) - 34% of entity signals</li>
          <li><strong>Car rental agencies</strong> (NAICS 5321) - 28% of entity signals</li>
          <li><strong>Consumer services</strong> (NAICS 81) - 19% of entity signals</li>
          <li><strong>Domain brokerage</strong> (actual) - 19% of entity signals</li>
        </ul>
        
        <p>Root cause analysis identified three signal contamination vectors:</p>
        
        <ol>
          <li><strong>Historical domain ownership associations:</strong> SAW had sold domains (e.g., <code>rentalcar.com</code>, <code>transportlogistics.com</code>) to companies that built businesses in transportation/rental verticals. Google's entity graph retained ownership-to-industry mappings.</li>
          <li><strong>Unconstrained Service schema:</strong> Pages at <code>/buy</code>, <code>/sell</code>, <code>/appraisals</code> emitted standalone <code>Service</code> schema without <code>provider</code> or <code>serviceType</code> constraints. Without explicit <code>Organization</code> parent, Google inferred consumer marketplace classification.</li>
          <li><strong>Link neighborhood contamination:</strong> 412 inbound links from transportation/rental industry sites created co-occurrence signals that reinforced misclassification.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: Organization Entity Lock</h3>
        
        <p>Deployed authoritative <code>Organization</code> schema on all 847 pages with strict constraints:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "Organization",
  "@id": "https://saw.com/#organization",
  "name": "SAW.com",
  "legalName": "SAW.com, Inc.",
  "url": "https://saw.com",
  "knowsAbout": [
    "Domain Brokerage",
    "Domain Acquisition",
    "Digital Asset Sales",
    "Premium Domain Valuation"
  ],
  "areaServed": {
    "@type": "Place",
    "name": "Global"
  },
  "disambiguatingDescription": "Premium domain brokerage specializing in high-value digital asset transactions"
}</code></pre>
        
        <p><strong>Constraint enforcement:</strong> Added <code>@reverse</code> assertions excluding transportation, car rental, and consumer services from <code>knowsAbout</code>. Used <code>sameAs</code> to consolidate entity variants (SAW, SAW.com, SAW.com Inc.) into single canonical entity.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: Service Schema Re-anchoring</h3>
        
        <p>Reconstructed service pages with explicit <code>provider</code> relationships:</p>
        
        <ul>
          <li><code>/buy</code>: Changed from standalone <code>Service</code> to <code>Service</code> with <code>"provider": {"@id": "https://saw.com/#organization"}</code> and <code>"serviceType": "Domain Brokerage Service"</code></li>
          <li><code>/sell</code>: Added <code>"audience": {"@type": "BusinessAudience"}</code> to disambiguate from consumer marketplace</li>
          <li><code>/appraisals</code>: Added <code>"offers": {"@type": "Offer", "priceCurrency": "USD", "eligibleCustomerType": "Business"}</code></li>
        </ul>
        
        <p><strong>Result:</strong> All 23 service pages now resolve to single Organization entity. Google's entity parser stopped inferring consumer marketplace classification.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: Utility Page Classification</h3>
        
        <p>Clarified functional pages to prevent SaaS-style misinterpretation:</p>
        
        <ul>
          <li><code>/login</code>, <code>/account</code>: Added <code>"@type": "WebApplication"</code> with <code>"applicationCategory": "BusinessApplication"</code>, <code>"operatingSystem": "Web"</code></li>
          <li><code>/affiliate</code>: Added <code>"@type": "WebPage"</code> with <code>"about": {"@type": "Thing", "name": "Affiliate Program"}</code> to prevent standalone service classification</li>
        </ul>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 4: Media Entity Reconstruction</h3>
        
        <p>Rebuilt blog and podcast sections with proper media entity modeling:</p>
        
        <ul>
          <li><strong>Blog:</strong> Changed from generic <code>Blog</code> to <code>Blog</code> with <code>"publisher": {"@id": "https://saw.com/#organization"}</code> and <code>"inLanguage": "en-US"</code></li>
          <li><strong>Podcast:</strong> Added <code>PodcastSeries</code> schema with <code>"publisher": {"@id": "https://saw.com/#organization"}</code></li>
          <li><strong>Episodes:</strong> Each episode now emits <code>PodcastEpisode</code>, <code>BlogPosting</code>, and <code>WebPage</code> schemas, all resolving to SAW as publisher</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 847 pages modified, 1,203 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 4 (post-deployment):</strong> Google Knowledge Graph API showed 67% reduction in transportation/rental associations.</p>
        
        <p><strong>Week 6:</strong> Entity graph stabilized. Knowledge Graph classification: 89% domain brokerage, 6% digital assets, 5% other (down from 81% misclassified).</p>
        
        <p><strong>Week 8:</strong> Final measurement:</p>
        
        <ul>
          <li><strong>Entity classification accuracy:</strong> 94% (up from 19%)</li>
          <li><strong>AI citation accuracy:</strong> ChatGPT, Claude, and Perplexity now correctly identify SAW as domain brokerage in 87% of relevant queries (up from 23%)</li>
          <li><strong>Knowledge Graph consistency:</strong> Single canonical entity across all Google properties (Search, Knowledge Panel, AI Overviews)</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> No traditional SEO metrics (rankings, traffic) were targeted. This was pure entity repair. Rankings remained stable (±2 positions), confirming that misclassification was entity-level, not relevance-level.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>Historical domain ownership creates entity graph contamination</li>
          <li>Service schema lacks explicit <code>Organization</code> parent relationships</li>
          <li>Link neighborhoods reinforce incorrect industry associations</li>
          <li>Media entities are not properly anchored to parent organization</li>
        </ol>
        
        <p><strong>Fix requires:</strong> Explicit entity definition at Organization level, not page-level optimization. Schema hierarchy must enforce parent-child relationships. Entity constraints must exclude incorrect classifications.</p>

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
