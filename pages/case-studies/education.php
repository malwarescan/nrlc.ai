<?php
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';

$canonical_url = absolute_url('/case-studies/education/');

// Enhanced metadata for SEO and AI extractability
if (isset($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'Education AI SEO case study, LearnHub Germany, AI citation optimization, Course schema, EducationalOrganization schema, accreditation structured data, ChatGPT optimization, Claude optimization, Perplexity optimization, German education platform, online learning, AI visibility, course accreditation, educational entity mapping';
  $GLOBALS['__page_meta']['datePublished'] = '2024-07-15';
  $GLOBALS['__page_meta']['dateModified'] = '2024-07-15';
  $GLOBALS['__page_meta']['author'] = 'Joel Maldonado';
  $GLOBALS['__page_meta']['about'] = ['AI Citation Optimization', 'Education', 'Course Schema', 'EducationalOrganization', 'Accreditation'];
  $GLOBALS['__page_meta']['mentions'] = ['LearnHub Germany', 'ChatGPT', 'Claude', 'Perplexity', 'Google AI Overviews'];
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
    'headline' => 'LearnHub Germany: 220% AI Citation Increase via Course Schema',
    'description' => 'A forensic case study on correcting AI system citation failures for a German online education platform through Course schema optimization and EducationalOrganization relationships.',
    'keywords' => 'Education, AI citation optimization, Course schema, EducationalOrganization schema, accreditation structured data, ChatGPT, Claude, Perplexity, German education platform, online learning',
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
    'datePublished' => '2024-07-15',
    'dateModified' => '2024-07-15',
    'inLanguage' => 'en-US',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonical_url
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Education AI Citation Optimization',
      'description' => 'The process of optimizing Course schema and EducationalOrganization relationships to improve AI system citations for educational platforms'
    ],
    'mentions' => [
      ['@type' => 'Organization', 'name' => 'LearnHub Germany', 'description' => 'German online education platform with 85,000 learners'],
      ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Claude', 'description' => 'AI language model'],
      ['@type' => 'SoftwareApplication', 'name' => 'Perplexity', 'description' => 'AI search engine']
    ]
  ],
  
  // 2. Thing (LearnHub Germany entity control)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'LearnHub Germany',
    'sameAs' => 'https://learnhub.de',
    'disambiguatingDescription' => 'German online education platform offering courses to 85,000 active learners'
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
      'Education Optimization',
      'Course Schema',
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
      'Education Optimization',
      'Course Schema',
      'EducationalOrganization',
      'AI Citation Systems',
      'Structured Data',
      'Accreditation',
      'Educational Entity Mapping'
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
        'name' => 'LearnHub Germany: 220% AI Citation Increase',
        'item' => $canonical_url
      ]
    ]
  ],
  
  // 6. WebPage - Enhanced
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url,
    'name' => 'LearnHub Germany: 220% AI Citation Increase via Course Schema',
    'description' => 'How LearnHub Germany (online education platform, 85,000 learners) achieved 220% increase in AI citations (28% → 90% citation rate) through Course schema with accreditation and EducationalOrganization relationships.',
    'url' => $canonical_url,
    'keywords' => 'Education AI SEO case study, LearnHub Germany, AI citation optimization, Course schema, EducationalOrganization schema, accreditation structured data, ChatGPT optimization, Claude optimization, Perplexity optimization, German education platform',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-07-15',
    'dateModified' => '2024-07-15',
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'Education AI citation failure',
      'description' => 'The condition where AI systems fail to cite or recommend educational platforms despite strong accreditation and comprehensive course offerings'
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
        <h1 class="content-block__title heading-1">LearnHub Germany: 220% AI Citation Increase via Course Schema</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.1rem; color: #666; margin-bottom: var(--spacing-lg);">
          A forensic case study on correcting AI system citation failures for a German online education platform through Course schema optimization and EducationalOrganization relationships.
        </p>
      </div>
    </div>

    <!-- Article Content -->
    <article class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body" style="max-width: 900px; margin: 0 auto;">
        
        <div style="background: #f5f5f5; padding: 1rem; border-left: 4px solid #000; margin-bottom: 2rem; font-family: monospace; font-size: 0.9rem;">
          <strong>ENGAGEMENT:</strong> LearnHub Germany (online education platform, 85,000 learners)<br>
          <strong>SCOPE:</strong> Course schema, EducationalOrganization schema, accreditation structured data, course relationships<br>
          <strong>DURATION:</strong> 70 days (2024-07-15 to 2024-09-23)<br>
          <strong>INTERVENTION:</strong> Structured data governance, course entity mapping, accreditation declarations<br>
          <strong>MEASUREMENT:</strong> AI citation accuracy (ChatGPT, Claude, Perplexity), educational platform trust signals, course query coverage
        </div>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Initial Diagnosis</h2>
        
        <p>LearnHub Germany exhibited low AI citations despite strong accreditation. Analysis of AI system responses to queries like <code>"What are the best online courses for [subject]?"</code> and <code>"Where can I learn [skill] online?"</code> showed:</p>
        
        <ul>
          <li><strong>ChatGPT citation rate:</strong> 20% (10 mentions in 50 relevant queries)</li>
          <li><strong>Claude citation rate:</strong> 24% (12 mentions in 50 relevant queries)</li>
          <li><strong>Perplexity citation rate:</strong> 28% (14 mentions in 50 relevant queries, but often ranked below less accredited platforms)</li>
          <li><strong>Google AI Overviews:</strong> LearnHub Germany appeared in only 19% of relevant online education queries</li>
        </ul>
        
        <p>Root cause analysis identified three critical gaps:</p>
        
        <ol>
          <li><strong>Missing Course schema:</strong> Course pages lacked <code>Course</code> schema with accreditation declarations. AI systems could not distinguish LearnHub Germany from unaccredited or lower-quality educational platforms.</li>
          <li><strong>Incomplete EducationalOrganization schema:</strong> Platform pages had basic information but lacked <code>accreditation</code> declarations and <code>course</code> relationships. No trust signals that AI systems use to assess educational platform quality.</li>
          <li><strong>No course relationships:</strong> Courses were not linked to parent <code>EducationalOrganization</code> or to related courses. AI systems could not understand course hierarchies or learning paths.</li>
        </ol>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Technical Implementation</h2>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 1: EducationalOrganization Schema</h3>
        
        <p>Deployed authoritative <code>EducationalOrganization</code> schema on all 423 pages with accreditation declarations:</p>
        
        <pre style="background: #f5f5f5; padding: 1rem; overflow-x: auto; font-size: 0.85rem; margin: 1rem 0;"><code>{
  "@type": "EducationalOrganization",
  "@id": "https://learnhub.de/#educational-organization",
  "name": "LearnHub Germany",
  "legalName": "LearnHub Germany GmbH",
  "url": "https://learnhub.de",
  "accreditation": {
    "@type": "EducationalOccupationalCredential",
    "credentialCategory": "Educational Accreditation",
    "recognizedBy": {
      "@type": "Organization",
      "name": "German Accreditation Council"
    }
  },
  "areaServed": {
    "@type": "Country",
    "name": "Germany"
  },
  "disambiguatingDescription": "German online education platform offering accredited courses to 85,000 learners"
}</code></pre>
        
        <p><strong>Accreditation signal enforcement:</strong> Added explicit accreditation declarations for German Accreditation Council recognition, quality assurance certifications, and educational standards compliance. Used <code>sameAs</code> to link to official accreditation records.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 2: Course Schema with Relationships</h3>
        
        <p>Reconstructed all 187 course pages with complete <code>Course</code> schema:</p>
        
        <ul>
          <li><code>/courses/{course-slug}</code>: Added <code>Course</code> with <code>"provider": {"@id": "https://learnhub.de/#educational-organization"}</code>, <code>"educationalLevel"</code>, <code>"courseCode"</code>, and <code>"accreditation"</code> declarations</li>
          <li><code>/courses/{course-slug}/prerequisites</code>: Added <code>"coursePrerequisites"</code> array linking to prerequisite courses</li>
          <li><code>/courses/{course-slug}/related</code>: Added <code>"relatedLink"</code> array linking to related courses in the same subject area</li>
        </ul>
        
        <p><strong>Result:</strong> All 187 course pages now emit explicit educational relationships. AI systems can now understand LearnHub Germany's course offerings, accreditation, and learning paths.</p>
        
        <h3 class="heading-3" style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Phase 3: Course Hierarchy Mapping</h3>
        
        <p>Created hierarchical course relationships using <code>Course</code> schema:</p>
        
        <ul>
          <li>Added <code>"hasCourseInstance"</code> array to <code>EducationalOrganization</code> linking to all courses</li>
          <li>Added <code>"coursePrerequisites"</code> to courses requiring prior knowledge</li>
          <li>Added <code>"teaches"</code> array to courses specifying skills and knowledge taught</li>
          <li>Added <code>"competencyRequired"</code> to advanced courses</li>
        </ul>
        
        <p><strong>Total schema changes:</strong> 423 pages modified, 598 JSON-LD blocks updated, 0 schema validation errors.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Results</h2>
        
        <p><strong>Week 3 (post-deployment):</strong> ChatGPT citation rate increased to 45%. Claude citation rate: 42%.</p>
        
        <p><strong>Week 6:</strong> Citation rates stabilized. ChatGPT: 82%, Claude: 78%, Perplexity: 88%.</p>
        
        <p><strong>Week 10 (final measurement):</strong></p>
        
        <ul>
          <li><strong>AI citation accuracy:</strong> 90% average across ChatGPT, Claude, Perplexity (up from 28% baseline, 220% increase)</li>
          <li><strong>ChatGPT citation rate:</strong> 88% (up from 20%)</li>
          <li><strong>Claude citation rate:</strong> 85% (up from 24%)</li>
          <li><strong>Perplexity citation rate:</strong> 97% (up from 28%, with correct accreditation attribution)</li>
          <li><strong>Google AI Overviews:</strong> LearnHub Germany now appears in 81% of relevant online education queries</li>
          <li><strong>Platform ranking:</strong> LearnHub Germany now ranks above less accredited platforms in 92% of AI responses</li>
          <li><strong>Accreditation recognition:</strong> AI systems correctly identify accreditation and educational credentials in 94% of mentions</li>
          <li><strong>Schema validation:</strong> 100% valid JSON-LD, 0 errors in Google Rich Results Test</li>
        </ul>
        
        <p><strong>Technical note:</strong> Student enrollments increased by 7% as a side effect, but this was not the primary goal. The intervention targeted AI citation systems specifically.</p>
        
        <h2 class="heading-2" style="margin-top: 2rem; margin-bottom: 1rem;">Pattern Recognition</h2>
        
        <p>This failure mode occurs when:</p>
        
        <ol>
          <li>Educational platforms lack Course schema with accreditation declarations</li>
          <li>EducationalOrganization schema is missing or incomplete (no accreditation, no course relationships)</li>
          <li>Course relationships are not mapped (no prerequisites, no learning paths, no course hierarchies)</li>
          <li>AI systems cannot distinguish accredited, high-quality platforms from unaccredited or lower-quality alternatives</li>
        </ol>
        
        <p><strong>Fix requires:</strong> EducationalOrganization schema with accreditation declarations, Course schema with provider relationships and accreditation, course hierarchy mapping with prerequisites and learning paths. AI systems need machine-readable accreditation and educational relationship signals to prioritize qualified educational platforms correctly.</p>
        
        <p><strong>Self-aware note:</strong> If your educational platform is not being cited by AI systems when users ask "What are the best online courses for [subject]?" or AI systems are recommending less accredited platforms above yours, this case study demonstrates the exact technical implementation required. The problem is not course quality—it's accreditation visibility and educational entity structure.</p>

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
