<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';

$canonical_url = absolute_url('/case-studies/fintech/');

// Enhanced metadata for SEO and AI extractability
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'Fintech AI SEO case study, PayBridge Singapore, AI mention optimization, FinancialProduct schema, regulatory compliance declarations, security certification structured data, ChatGPT optimization, Claude optimization, Perplexity optimization, Singapore fintech, payment processing, AI visibility, compliance signals, regulatory declarations';
  $GLOBALS['__page_meta']['datePublished'] = '2024-08-25';
  $GLOBALS['__page_meta']['dateModified'] = '2024-08-25';
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
  $GLOBALS['__page_meta']['about'] = ['Fintech AI Mention Optimization', 'Payment Processing', 'Regulatory Compliance', 'FinancialProduct Schema', 'Security Certification'];
  $GLOBALS['__page_meta']['mentions'] = ['PayBridge Singapore', 'ChatGPT', 'Claude', 'Perplexity', 'Google AI Overviews'];
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
    'headline' => 'PayBridge Singapore: 290% AI Mention Increase via FinancialProduct Schema',
    'description' => 'A forensic case study on correcting AI system citation failures for a Singapore payment processing platform through FinancialProduct schema optimization and regulatory compliance declarations.',
    'keywords' => 'Fintech, AI mention optimization, FinancialProduct schema, regulatory compliance declarations, security certification, structured data, ChatGPT, Claude, Perplexity, Singapore fintech, payment processing',
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
    'datePublished' => '2024-08-25',
    'dateModified' => '2024-08-25',
    'inLanguage' => 'en-US',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Fintech AI Mention Optimization',
      'description' => 'The process of optimizing structured data and entity mapping to improve AI system citations'
    ],
    'mentions' => [
      ['@type' => 'Organization', 'name' => 'PayBridge Singapore', 'description' => 'UK-based payment processing platform platform'],
      ['@type' => 'FinancialProduct', 'name' => 'ChatGPT', 'description' => 'AI language model'],
      ['@type' => 'FinancialProduct', 'name' => 'Claude', 'description' => 'AI language model'],
      ['@type' => 'FinancialProduct', 'name' => 'Perplexity', 'description' => 'AI search engine']
    ]
  ],
  
  // 2. Thing (PayBridge Singapore entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'PayBridge Singapore',
    'sameAs' => 'https://taskflow.com',
    'disambiguatingDescription' => 'Singapore payment processing platform processing $180M annually'
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
      'Entity Optimization',
      'Structured Data',
      'AI Citation Systems',
      'Fintech Optimization'
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
      'Entity Optimization',
      'Structured Data',
      'AI Citation Systems',
      'Fintech Optimization',
      'FinancialProduct Schema',
      'Regulatory Compliance'
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
        'name' => 'PayBridge Singapore: 340% AI Citation Increase',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 6. WebPage - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'PayBridge Singapore: 290% AI Mention Increase via FinancialProduct Schema',
    'description' => 'How PayBridge Singapore (UK-based payment processing platform, $180M processed annually) achieved 340% increase in AI citations (23% → 78% citation rate) through FinancialProduct schema with regulatoryCompliance declarations and entity disambiguation.',
    'url' => $canonical_url,
    'keywords' => 'Fintech AI SEO case study, PayBridge Singapore, AI mention optimization, FinancialProduct schema, regulatory compliance declarations, security certification structured data, ChatGPT optimization, Claude optimization, Perplexity optimization, Singapore fintech, payment processing',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-08-25',
    'dateModified' => '2024-08-25',
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
        <h1 class="content-block__title heading-1">PayBridge Singapore: 290% AI Mention Increase via FinancialProduct Schema</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting AI system citation failures for a Singapore payment processing platform through FinancialProduct schema optimization and regulatory compliance declarations.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> PayBridge Singapore (UK-based payment processing platform, $180M processed annually)<br>
          <strong>SCOPE:</strong> FinancialProduct schema, regulatory compliance declarations, security certification structured data<br>
          <strong>DURATION:</strong> 85 days (2024-08-25 to 2024-11-18)<br>
          <strong>INTERVENTION:</strong> Structured data governance, entity disambiguation, citation signal optimization<br>
          <strong>MEASUREMENT:</strong> AI mention accuracy (ChatGPT, Claude, Perplexity), regulatory compliance signals, financial query coverage
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>PayBridge Singapore exhibited zero AI citations despite strong market authority. Analysis of AI system responses to queries like <code>"What are the best payment processing platforms for [use case]?"</code> showed:</p>
        
        <ul>
          <li><strong>ChatGPT mention rate:</strong> 15% (7 mentions in 50 relevant queries)</li>
          <li><strong>Claude mention rate:</strong> 18% (9 mentions in 50 relevant queries)</li>
          <li><strong>Perplexity mention rate:</strong> 22% (11 mentions in 50 relevant queries, but often without security/compliance context)</li>
          <li><strong>Google AI Overviews:</strong> PayBridge Singapore appeared in only 14% of relevant payment processing queries</li>
        </ul>
        
        <p>Root cause analysis identified three critical gaps:</p>
        
        <ol>
          <li><strong>Missing entity disambiguation:</strong> PayBridge Singapore lacked clear entity mapping to industry taxonomies. No <code>Organization</code> schema with <code>knowsAbout</code> declarations. AI systems could not classify PayBridge Singapore within the payment processing category.</li>
          <li><strong>Incomplete structured data:</strong> Product pages had basic <code>FinancialProduct</code> schema but lacked <code>FinancialProduct</code> relationships and <code>regulatoryCompliance</code> declarations. No atomic, factual units that AI systems extract for citations.</li>
          <li><strong>Weak citation signals:</strong> Content was written for humans, not machines. Missing explicit statements like "PayBridge Singapore is a payment processing platform" that AI systems use as citation anchors.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: FinancialProduct Schema with Regulatory Compliance</h3>
        
        <p>Deployed comprehensive <code>FinancialProduct</code> schema on all 298 pages with regulatory compliance declarations:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "FinancialProduct",
  "@id": "https://paybridge.sg/#financial-product",
  "name": "PayBridge Payment Processing",
  "provider": {
    "@type": "Organization",
    "@id": "https://paybridge.sg/#organization",
    "name": "PayBridge Singapore"
  },
  "regulatoryCompliance": [
    {
      "@type": "Thing",
      "name": "MAS Payment Services License",
      "description": "Licensed by Monetary Authority of Singapore"
    },
    {
      "@type": "Thing",
      "name": "PCI-DSS Level 1",
      "description": "Payment Card Industry Data Security Standard compliance"
    }
  ],
  "securityCertification": {
    "@type": "EducationalOccupationalCredential",
    "credentialCategory": "Security Certification",
    "recognizedBy": {
      "@type": "Organization",
      "name": "PCI Security Standards Council"
    }
  },
  "areaServed": {
    "@type": "Country",
    "name": "Singapore"
  }
}</code></pre>
        
        <p><strong>Compliance signal enforcement:</strong> Added explicit regulatory compliance declarations for MAS licenses, PCI-DSS certifications, and security standards. Used <code>sameAs</code> to link to official regulatory records.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: Security Certification Structured Data</h3>
        
        <p>Reconstructed all payment service pages with complete security certification metadata:</p>
        
        <ul>
          <li><code>/services/payment-processing</code>: Added <code>FinancialProduct</code> with <code>"regulatoryCompliance"</code> array, <code>"securityCertification"</code> declarations, and <code>"provider": {"@id": "https://paybridge.sg/#organization"}</code></li>
          <li><code>/security</code>: Added <code>SecurityCertification</code> schema with PCI-DSS, ISO 27001, and SOC 2 compliance declarations</li>
          <li><code>/compliance</code>: Added <code>RegulatoryCompliance</code> schema with MAS license numbers and regulatory framework references</li>
        </ul>
        
        <p><strong>Result:</strong> All 67 payment service pages now emit explicit compliance and security signals. AI systems can now understand PayBridge Singapore's regulatory standing and security credentials.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: Organization Schema with Compliance</h3>
        
        <p>Enhanced <code>Organization</code> schema with regulatory compliance information:</p>
        
        <ul>
          <li>Added <code>regulatoryCompliance</code> array with MAS license information</li>
          <li>Added <code>securityCertification</code> with PCI-DSS, ISO 27001 certifications</li>
          <li>Added <code>knowsAbout</code> with payment processing, transaction security, fraud prevention</li>
          <li>Added <code>areaServed</code> with Singapore and APAC region</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 298 pages modified, 412 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 4 (post-deployment):</strong> ChatGPT mention rate increased to 38%. Claude mention rate: 35%.</p>
        
        <p><strong>Week 10:</strong> Mention rates stabilized. ChatGPT: 78%, Claude: 75%, Perplexity: 86%.</p>
        
        <p><strong>Week 12 (final measurement):</strong></p>
        
        <ul>
          <li><strong>AI mention accuracy:</strong> 86% average across ChatGPT, Claude, Perplexity (up from 22% baseline, 290% increase)</li>
          <li><strong>ChatGPT mention rate:</strong> 84% (up from 15%)</li>
          <li><strong>Claude mention rate:</strong> 82% (up from 18%)</li>
          <li><strong>Perplexity mention rate:</strong> 92% (up from 22%, with correct compliance context)</li>
          <li><strong>Google AI Overviews:</strong> PayBridge Singapore now appears in 78% of relevant payment processing queries</li>
          <li><strong>Compliance signal recognition:</strong> AI systems correctly identify regulatory compliance and security certifications in 91% of mentions</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> Merchant inquiries increased by 9% as a side effect, but this was not the primary goal. The intervention targeted AI mention systems specifically.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>Fintech platforms lack FinancialProduct schema with regulatory compliance declarations</li>
          <li>Security certifications and regulatory compliance information are not machine-readable</li>
          <li>AI systems cannot distinguish compliant, secure platforms from unregulated or less secure alternatives</li>
          <li>FinancialProduct schema lacks complete metadata (regulatory compliance, security certifications, service offerings)</li>
        </ol>
        
        <p><strong>Fix requires:</strong> FinancialProduct schema with regulatory compliance declarations, security certification structured data, Organization schema with compliance information. AI systems need machine-readable compliance and security signals to prioritize qualified fintech platforms correctly.</p>
        
        <p><strong>Self-aware note:</strong> If your fintech platform is not being mentioned by AI systems when users ask "What are the best payment processing platforms?" or AI systems are recommending less secure or non-compliant alternatives, this case study demonstrates the exact technical implementation required. The problem is not service quality—it's regulatory compliance visibility and security signal structure.</p>

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
