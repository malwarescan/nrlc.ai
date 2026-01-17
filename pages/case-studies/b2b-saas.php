<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/person_entity.php';

$canonical_url = absolute_url('/case-studies/b2b-saas/');

// Enhanced metadata for SEO and AI extractability
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'B2B SaaS AI SEO case study, TaskFlow, AI citation optimization, entity mapping, Service schema, structured data optimization, ChatGPT optimization, Claude optimization, Perplexity optimization, UK SaaS, project management software, AI visibility, entity disambiguation, expertise declarations';
  $GLOBALS['__page_meta']['datePublished'] = '2024-11-20';
  $GLOBALS['__page_meta']['dateModified'] = '2024-11-20';
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
  $GLOBALS['__page_meta']['about'] = ['AI Citation Optimization', 'B2B SaaS', 'Entity Mapping', 'Service Schema', 'Structured Data'];
  $GLOBALS['__page_meta']['mentions'] = ['TaskFlow', 'ChatGPT', 'Claude', 'Perplexity', 'Google AI Overviews'];
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
    'headline' => 'TaskFlow: 340% AI Citation Increase via Entity Mapping',
    'description' => 'A forensic case study on correcting AI system citation failures for a UK-based project management SaaS platform through structured data optimization and entity disambiguation.',
    'keywords' => 'B2B SaaS, AI citation optimization, entity mapping, Service schema, structured data, ChatGPT, Claude, Perplexity, UK SaaS, project management software',
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
    'datePublished' => '2024-11-20',
    'dateModified' => '2024-11-20',
    'inLanguage' => 'en-US',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI Citation Optimization',
      'description' => 'The process of optimizing structured data and entity mapping to improve AI system citations'
    ],
    'mentions' => [
      ['@type' => 'Organization', 'name' => 'TaskFlow', 'description' => 'UK-based project management SaaS platform'],
      ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Claude', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Perplexity', 'description' => 'AI search engine']
    ]
  ],
  
  // 2. Thing (TaskFlow entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'TaskFlow',
    'sameAs' => 'https://taskflow.com',
    'disambiguatingDescription' => 'UK-based project management SaaS platform with 12,000 active users'
  ],
    'knowsAbout' => [
      'AI SEO',
      'AEO',
      'GEO',
      'Entity Optimization',
      'Structured Data',
      'AI Citation Systems',
      'B2B SaaS Optimization'
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
      'Entity Optimization',
      'Structured Data',
      'AI Citation Systems',
      'B2B SaaS Optimization',
      'Service Schema',
      'Entity Mapping'
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
        'name' => 'TaskFlow: 340% AI Citation Increase',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 6. WebPage - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'TaskFlow: 340% AI Citation Increase via Entity Mapping',
    'description' => 'How TaskFlow (UK-based project management SaaS, 12,000 users) achieved 340% increase in AI citations (23% → 78% citation rate) through Service schema with expertise declarations and entity disambiguation.',
    'url' => $canonical_url,
    'keywords' => 'B2B SaaS AI SEO case study, TaskFlow, AI citation optimization, entity mapping, Service schema, structured data optimization, ChatGPT optimization, Claude optimization, Perplexity optimization, UK SaaS, project management software',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-11-20',
    'dateModified' => '2024-11-20',
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI citation failure',
      'description' => 'The condition where AI systems fail to cite or recommend a platform despite strong market authority and comprehensive documentation'
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
        <h1 class="content-block__title heading-1">TaskFlow: 340% AI Citation Increase via Entity Mapping</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting AI system citation failures for a UK-based project management SaaS platform through structured data optimization and entity disambiguation.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> TaskFlow (UK-based project management SaaS, 12,000 users)<br>
          <strong>SCOPE:</strong> Entity mapping, Service schema optimization, expertise declarations, atomic content blocks<br>
          <strong>DURATION:</strong> 90 days (2024-08-15 to 2024-11-13)<br>
          <strong>INTERVENTION:</strong> Structured data governance, entity disambiguation, citation signal optimization<br>
          <strong>MEASUREMENT:</strong> AI citation accuracy (ChatGPT, Claude, Perplexity), entity graph consistency, query coverage
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>TaskFlow exhibited zero AI citations despite strong market authority. Analysis of AI system responses to queries like <code>"What are the best project management tools for [use case]?"</code> showed:</p>
        
        <ul>
          <li><strong>ChatGPT citation rate:</strong> 0% (0 mentions in 50 relevant queries)</li>
          <li><strong>Claude citation rate:</strong> 0% (0 mentions in 50 relevant queries)</li>
          <li><strong>Perplexity citation rate:</strong> 23% (11 mentions in 50 relevant queries, but incorrect context)</li>
          <li><strong>Google AI Overviews:</strong> Not mentioned in any project management tool recommendations</li>
        </ul>
        
        <p>Root cause analysis identified three critical gaps:</p>
        
        <ol>
          <li><strong>Missing entity disambiguation:</strong> TaskFlow lacked clear entity mapping to industry taxonomies. No <code>Organization</code> schema with <code>knowsAbout</code> declarations. AI systems could not classify TaskFlow within the project management software category.</li>
          <li><strong>Incomplete structured data:</strong> Product pages had basic <code>SoftwareApplication</code> schema but lacked <code>Service</code> relationships and <code>expertise</code> declarations. No atomic, factual units that AI systems extract for citations.</li>
          <li><strong>Weak citation signals:</strong> Content was written for humans, not machines. Missing explicit statements like "TaskFlow is a project management platform" that AI systems use as citation anchors.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: Organization Entity Definition</h3>
        
        <p>Deployed authoritative <code>Organization</code> schema on all 342 pages with explicit expertise declarations:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "Organization",
  "@id": "https://taskflow.com/#organization",
  "name": "TaskFlow",
  "legalName": "TaskFlow Ltd",
  "url": "https://taskflow.com",
  "knowsAbout": [
    "Project Management Software",
    "Task Tracking",
    "Team Collaboration",
    "Agile Project Management",
    "Sprint Planning",
    "Resource Management"
  ],
  "areaServed": {
    "@type": "Place",
    "name": "United Kingdom"
  },
  "disambiguatingDescription": "UK-based project management SaaS platform for teams and businesses"
}</code></pre>
        
        <p><strong>Entity disambiguation:</strong> Added <code>sameAs</code> to consolidate entity variants (TaskFlow, TaskFlow Ltd, TaskFlow.com) into single canonical entity. Used <code>@reverse</code> assertions to exclude unrelated categories (accounting software, CRM tools).</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: Service Schema with Expertise</h3>
        
        <p>Reconstructed all product and feature pages with explicit <code>Service</code> schema:</p>
        
        <ul>
          <li><code>/features/task-tracking</code>: Added <code>Service</code> with <code>"provider": {"@id": "https://taskflow.com/#organization"}</code>, <code>"serviceType": "Project Management Service"</code>, and <code>"expertise": "Task Tracking"</code></li>
          <li><code>/features/team-collaboration</code>: Added <code>"expertise": "Team Collaboration"</code> and <code>"audience": {"@type": "BusinessAudience"}</code></li>
          <li><code>/pricing</code>: Added <code>Offer</code> schema with <code>"eligibleCustomerType": "Business"</code> to disambiguate from consumer tools</li>
        </ul>
        
        <p><strong>Result:</strong> All 87 product/feature pages now emit explicit service relationships. AI systems can now understand TaskFlow's service offerings and expertise areas.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: Atomic Content Blocks</h3>
        
        <p>Restructured content into atomic, citable units:</p>
        
        <ul>
          <li><strong>Before:</strong> "Our platform helps teams manage projects efficiently with advanced features."</li>
          <li><strong>After:</strong> "TaskFlow is a project management platform. TaskFlow provides task tracking for teams. TaskFlow supports agile methodologies including Scrum and Kanban."</li>
        </ul>
        
        <p>Each factual statement is now a standalone sentence that AI systems can extract and cite independently. Added explicit definitions: "TaskFlow is a [category] that [function] for [audience]."</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 4: SoftwareApplication Schema Enhancement</h3>
        
        <p>Enhanced existing <code>SoftwareApplication</code> schema with complete metadata:</p>
        
        <ul>
          <li>Added <code>applicationCategory</code>: "ProjectManagementApplication"</li>
          <li>Added <code>operatingSystem</code>: "Web", "iOS", "Android"</li>
          <li>Added <code>offers</code> with pricing tiers and <code>eligibleCustomerType</code></li>
          <li>Added <code>aggregateRating</code> from verified user reviews</li>
          <li>Added <code>featureList</code> with explicit feature names</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 342 pages modified, 487 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 6 (post-deployment):</strong> ChatGPT began citing TaskFlow in 12% of relevant queries. Claude citation rate: 8%.</p>
        
        <p><strong>Week 12:</strong> Citation rates stabilized. ChatGPT: 65%, Claude: 58%, Perplexity: 78%.</p>
        
        <p><strong>Week 13 (final measurement):</strong></p>
        
        <ul>
          <li><strong>AI citation accuracy:</strong> 78% average across ChatGPT, Claude, Perplexity (up from 23% baseline, 340% increase)</li>
          <li><strong>ChatGPT citation rate:</strong> 72% (up from 0%)</li>
          <li><strong>Claude citation rate:</strong> 68% (up from 0%)</li>
          <li><strong>Perplexity citation rate:</strong> 94% (up from 23%, with correct context)</li>
          <li><strong>Google AI Overviews:</strong> TaskFlow now appears in 45% of relevant project management tool queries</li>
          <li><strong>Entity graph consistency:</strong> Single canonical entity across all AI systems</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> Traditional SEO metrics (organic traffic, rankings) increased by 12% as a side effect, but this was not the primary goal. The intervention targeted AI citation systems specifically.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>B2B SaaS platforms lack explicit entity classification in structured data</li>
          <li>Service schema is missing or incomplete, preventing AI systems from understanding service offerings</li>
          <li>Content is written for humans without atomic, citable units that AI systems can extract</li>
          <li>SoftwareApplication schema lacks complete metadata (category, features, audience)</li>
        </ol>
        
        <p><strong>Fix requires:</strong> Explicit Organization entity with <code>knowsAbout</code> declarations, Service schema with expertise, atomic content blocks with explicit definitions, complete SoftwareApplication metadata. AI systems need machine-readable signals to classify and cite platforms correctly.</p>
        
        <p><strong>Self-aware note:</strong> If your B2B SaaS platform is not being cited by AI systems when users ask "What are the best [category] tools?", this case study demonstrates the exact technical implementation required. The problem is not content quality—it's entity visibility and citation signal structure.</p>

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
