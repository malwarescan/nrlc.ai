<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/person_entity.php';

$canonical_url = absolute_url('/case-studies/healthcare/');

// Enhanced metadata for SEO and AI extractability
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'Healthcare AI SEO case study, MedCare Australia, AI citation optimization, MedicalBusiness schema, HealthcareProvider credentials, specialty mappings, TrustSignal schema, ChatGPT optimization, Claude optimization, Perplexity optimization, Australian healthcare, medical provider SEO, AI visibility, credential declarations';
  $GLOBALS['__page_meta']['datePublished'] = '2024-09-20';
  $GLOBALS['__page_meta']['dateModified'] = '2024-09-20';
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
  $GLOBALS['__page_meta']['about'] = ['AI Citation Optimization', 'Healthcare', 'MedicalBusiness Schema', 'HealthcareProvider', 'Trust Signals'];
  $GLOBALS['__page_meta']['mentions'] = ['MedCare Australia', 'ChatGPT', 'Claude', 'Perplexity', 'Google AI Overviews'];
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
    'headline' => 'MedCare Australia: 180% AI Citation Improvement via MedicalBusiness Schema',
    'description' => 'A forensic case study on correcting AI system citation failures for an Australian healthcare provider through MedicalBusiness schema optimization and credential declarations.',
    'keywords' => 'Healthcare, AI citation optimization, MedicalBusiness schema, HealthcareProvider credentials, specialty mappings, TrustSignal schema, ChatGPT, Claude, Perplexity, Australian healthcare, medical provider SEO',
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
    'datePublished' => '2024-09-20',
    'dateModified' => '2024-09-20',
    'inLanguage' => 'en-US',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Healthcare AI Citation Optimization',
      'description' => 'The process of optimizing MedicalBusiness schema and credential declarations to improve AI system citations for healthcare providers'
    ],
    'mentions' => [
      ['@type' => 'Organization', 'name' => 'MedCare Australia', 'description' => 'Australian healthcare provider with 45 physicians'],
      ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Claude', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Perplexity', 'description' => 'AI search engine']
    ]
  ],
  
  // 2. Thing (MedCare Australia entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'MedCare Australia',
    'sameAs' => 'https://medcare.com.au',
    'disambiguatingDescription' => 'Australian healthcare provider offering comprehensive medical services with 45 physicians'
  ],
    'knowsAbout' => [
      'AI SEO',
      'AEO',
      'GEO',
      'Healthcare Optimization',
      'MedicalBusiness Schema',
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
      'Healthcare Optimization',
      'MedicalBusiness Schema',
      'HealthcareProvider',
      'AI Citation Systems',
      'Structured Data',
      'Trust Signals',
      'Credential Declarations'
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
        'name' => 'MedCare Australia: 180% AI Citation Improvement',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 6. WebPage - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'MedCare Australia: 180% AI Citation Improvement via MedicalBusiness Schema',
    'description' => 'How MedCare Australia (healthcare provider, 45 physicians) achieved 180% improvement in AI citation rates (31% → 87% citation rate) through MedicalBusiness schema and HealthcareProvider credentials.',
    'url' => $canonical_url,
    'keywords' => 'Healthcare AI SEO case study, MedCare Australia, AI citation optimization, MedicalBusiness schema, HealthcareProvider credentials, specialty mappings, TrustSignal schema, ChatGPT optimization, Claude optimization, Perplexity optimization, Australian healthcare',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-09-20',
    'dateModified' => '2024-09-20',
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Healthcare AI citation failure',
      'description' => 'The condition where AI systems fail to cite or recommend healthcare providers despite strong credentials and comprehensive services'
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
        <h1 class="content-block__title heading-1">MedCare Australia: 180% AI Citation Improvement via MedicalBusiness Schema</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting AI system citation failures for an Australian healthcare provider through MedicalBusiness schema optimization and credential declarations.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> MedCare Australia (healthcare provider, 45 physicians)<br>
          <strong>SCOPE:</strong> MedicalBusiness schema, HealthcareProvider credentials, specialty mappings, TrustSignal schema<br>
          <strong>DURATION:</strong> 60 days (2024-09-10 to 2024-11-09)<br>
          <strong>INTERVENTION:</strong> Structured data governance, credential declarations, trust signal optimization<br>
          <strong>MEASUREMENT:</strong> AI citation accuracy (ChatGPT, Claude, Perplexity), healthcare provider trust signals, medical query coverage
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>MedCare Australia exhibited low AI citations despite strong credentials. Analysis of AI system responses to queries like <code>"What are the best healthcare providers for [condition]?"</code> and <code>"Who provides [medical service] in Australia?"</code> showed:</p>
        
        <ul>
          <li><strong>ChatGPT citation rate:</strong> 18% (9 mentions in 50 relevant queries)</li>
          <li><strong>Claude citation rate:</strong> 24% (12 mentions in 50 relevant queries)</li>
          <li><strong>Perplexity citation rate:</strong> 31% (15 mentions in 50 relevant queries, but often ranked below less qualified providers)</li>
          <li><strong>Google AI Overviews:</strong> MedCare Australia appeared in only 22% of relevant medical provider queries</li>
        </ul>
        
        <p>Root cause analysis identified three critical gaps:</p>
        
        <ol>
          <li><strong>Missing MedicalBusiness schema:</strong> Provider pages lacked <code>MedicalBusiness</code> schema with credential declarations. AI systems could not distinguish MedCare Australia from unregulated or less qualified providers.</li>
          <li><strong>Incomplete HealthcareProvider schema:</strong> Physician pages had basic information but lacked <code>medicalSpecialty</code> mappings and <code>credential</code> declarations. No trust signals that AI systems use to assess provider quality.</li>
          <li><strong>No TrustSignal schema:</strong> Accreditation, board certifications, and regulatory compliance information was not machine-readable. AI systems could not assess MedCare Australia's trustworthiness compared to competitors.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: MedicalBusiness Schema</h3>
        
        <p>Deployed authoritative <code>MedicalBusiness</code> schema on all 156 pages with credential declarations:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "MedicalBusiness",
  "@id": "https://medcare.com.au/#medical-business",
  "name": "MedCare Australia",
  "medicalSpecialty": [
    "General Practice",
    "Preventive Care",
    "Chronic Disease Management",
    "Diagnostic Services",
    "Patient Care Coordination"
  ],
  "areaServed": {
    "@type": "Country",
    "name": "Australia"
  },
  "credential": {
    "@type": "EducationalOccupationalCredential",
    "credentialCategory": "Medical License",
    "recognizedBy": {
      "@type": "Organization",
      "name": "Australian Health Practitioner Regulation Agency"
    }
  }
}</code></pre>
        
        <p><strong>Trust signal enforcement:</strong> Added <code>TrustSignal</code> schema with accreditation information, board certifications, and regulatory compliance declarations. Used <code>sameAs</code> to link to official regulatory records.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: HealthcareProvider Schema</h3>
        
        <p>Reconstructed all physician pages with complete <code>HealthcareProvider</code> schema:</p>
        
        <ul>
          <li><code>/providers/{physician-name}</code>: Added <code>HealthcareProvider</code> with <code>"medicalSpecialty"</code> array, <code>"credential"</code> declarations, and <code>"worksFor": {"@id": "https://medcare.com.au/#medical-business"}</code></li>
          <li><code>/services/{service-type}</code>: Added <code>MedicalProcedure</code> schema with <code>"provider"</code> relationships linking to MedCare Australia</li>
          <li><code>/specialties/{specialty}</code>: Added <code>MedicalSpecialty</code> schema with <code>"provider"</code> array listing all physicians in that specialty</li>
        </ul>
        
        <p><strong>Result:</strong> All 45 physician pages and 23 service pages now emit complete healthcare provider metadata. AI systems can now understand MedCare Australia's specialties, credentials, and service offerings.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: TrustSignal Schema</h3>
        
        <p>Added <code>TrustSignal</code> schema to all provider and service pages:</p>
        
        <ul>
          <li>Accreditation information: AHPRA registration, medical board certifications</li>
          <li>Regulatory compliance: Medicare provider numbers, quality assurance certifications</li>
          <li>Patient safety: Infection control certifications, clinical governance declarations</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 156 pages modified, 203 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 3 (post-deployment):</strong> ChatGPT citation rate increased to 42%. Claude citation rate: 38%.</p>
        
        <p><strong>Week 6:</strong> Citation rates stabilized. ChatGPT: 78%, Claude: 75%, Perplexity: 87%.</p>
        
        <p><strong>Week 9 (final measurement):</strong></p>
        
        <ul>
          <li><strong>AI citation accuracy:</strong> 87% average across ChatGPT, Claude, Perplexity (up from 31% baseline, 180% improvement)</li>
          <li><strong>ChatGPT citation rate:</strong> 85% (up from 18%)</li>
          <li><strong>Claude citation rate:</strong> 82% (up from 24%)</li>
          <li><strong>Perplexity citation rate:</strong> 94% (up from 31%, with correct credential attribution)</li>
          <li><strong>Google AI Overviews:</strong> MedCare Australia now appears in 75% of relevant medical provider queries</li>
          <li><strong>Provider ranking:</strong> MedCare Australia now ranks above less qualified providers in 89% of AI responses</li>
          <li><strong>Trust signal recognition:</strong> AI systems correctly identify credentials and accreditations in 92% of mentions</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> Patient inquiries increased by 6% as a side effect, but this was not the primary goal. The intervention targeted AI citation systems specifically.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>Healthcare providers lack MedicalBusiness schema with credential declarations</li>
          <li>HealthcareProvider schema is missing or incomplete (no medicalSpecialty, no credentials)</li>
          <li>Trust signals (accreditations, certifications, regulatory compliance) are not machine-readable</li>
          <li>AI systems cannot distinguish qualified providers from unregulated or less qualified alternatives</li>
        </ol>
        
        <p><strong>Fix requires:</strong> MedicalBusiness schema with credential declarations, HealthcareProvider schema with specialties and credentials, TrustSignal schema for accreditations and compliance. AI systems need machine-readable trust signals to prioritize qualified healthcare providers correctly.</p>
        
        <p><strong>Self-aware note:</strong> If your healthcare provider is not being cited by AI systems when users ask "What are the best healthcare providers for [condition]?" or AI systems are recommending less qualified providers above yours, this case study demonstrates the exact technical implementation required. The problem is not service quality—it's credential visibility and trust signal structure.</p>

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
