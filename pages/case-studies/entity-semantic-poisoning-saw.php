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
      <div class="content-block__body" style="max-width: 800px; margin: 0 auto;">
        
        <p style="color: #666; font-size: 0.95rem; margin-bottom: var(--spacing-md);"><em>Client engagement: SAW.com. Scope: Entity repair and semantic constraint enforcement. Duration: 8 weeks. Intervention type: Structured data governance and organization entity consolidation.</em></p>
        
        <p>For over a year, SAW.com had a problem that looked invisible on the surface.</p>

        <p>Pages were indexed. Content was solid. Links were fine. Rankings were not catastrophically bad. But Google consistently associated the brand with industries SAW has nothing to do with. Transportation. Car rentals. Consumer services.</p>

        <p>That kind of misclassification is easy to miss if you are only looking at rankings.</p>

        <p>This was not an SEO problem.<br>
        It was an identity problem.</p>

        <p>Google did not misunderstand a page. It misunderstood what SAW is.</p>

        <p>The root cause turned out to be historical. SAW had sold high-value domains to companies in unrelated verticals. Those companies built real businesses on those domains. Over time, Google retained those associations and quietly folded them back into SAW's perceived identity.</p>

        <p>Because SAW never explicitly constrained its entity, Google filled in the gaps on its own.</p>

        <p>That is how semantic poisoning happens.</p>

        <p>Most traditional fixes failed immediately. Disavowing links did nothing. Updating copy did nothing. Publishing more content did nothing. None of that addresses entity inference. Google was not confused about relevance. It was confused about classification.</p>

        <p>When an organization is not clearly defined, Google relies on indirect signals. Historical ownership. Link neighborhoods. Co-occurring brand mentions. Service schema without a parent organization. All of those signals existed here, and they pointed in the wrong direction.</p>

        <p>So the approach changed.</p>

        <p>This was not treated as optimization. It was treated as repair.</p>

        <p>The first step was locking SAW into a single authoritative Organization entity and using it everywhere. No variations. No ambiguity. No silence. Google was explicitly told what SAW knows about and operates in: domain brokerage, domain acquisition, digital assets. Just as importantly, it was explicitly constrained from associating SAW with industries it does not operate in.</p>

        <p>Once the organization was defined, every service page had to resolve back to it.</p>

        <p>Pages like /buy, /sell, and /appraisals previously existed as standalone services. To a machine, that looks like consumer-facing offerings unless stated otherwise. Each one was re-anchored so Google understands they are professional brokerage services operated by a single firm, not products, marketplaces, or SaaS tools.</p>

        <p>Utility pages were another source of silent drift.</p>

        <p>Login flows, upgrade paths, and affiliate pages are easy for Google to misclassify if they are left vague. These were clarified as functional platform utilities, not services, not subscriptions, and not standalone offerings. This alone removed a major source of SaaS-style misinterpretation.</p>

        <p>The blog and podcast were also part of the problem.</p>

        <p>They had been treated as generic blog content. That matters more than most people realize. Media entities carry different trust, attribution, and classification rules than blogs. The entire section was rebuilt as a branded media property owned by SAW, with a proper PodcastSeries and clearly modeled episodes.</p>

        <p>Each podcast episode now resolves cleanly. It exists as a WebPage, an editorial BlogPosting, a PodcastEpisode, and a VideoObject when applicable. Every layer points back to SAW as the publisher. Nothing floats on its own. Nothing leaves room for inference.</p>

        <p>After these changes, the effect was immediate and measurable.</p>

        <p>Google stopped associating SAW with transportation and car rental verticals. The brand stabilized as a domain brokerage and digital asset firm. Services, media, and utilities all reinforced the same identity instead of competing with each other. AI summaries and citations became cleaner because the entity graph stopped contradicting itself.</p>

        <p>No rankings were chased. No tricks were used.</p>

        <p>This was about telling Google who the company is, and just as importantly, who it is not.</p>

        <p>If you sell digital assets, domains, or businesses, your past associations do not disappear on their own. Google has memory. If you do not define your entity, Google will infer it for you.</p>

        <p>And once inference compounds, undoing it gets expensive.</p>

        <p>Entity clarity is not a nice-to-have anymore. It is the foundation.</p>

        <p style="margin-top: var(--spacing-lg); padding-top: var(--spacing-md); border-top: 1px solid var(--color-border); color: #666; font-size: 0.95rem;"><strong>Pattern:</strong> This type of misclassification occurs when historical domain associations, link neighborhoods, or unconstrained service schema create conflicting entity signals. Companies that have sold domains, acquired businesses, or expanded into adjacent verticals are most at risk. The fix requires explicit entity definition at the organization level, not page-level optimization.</p>

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
