<?php
// Cambridge AI Overviews Optimization Service Page
// URL: /en-gb/services/ai-overviews-optimization/cambridge/
// High-intent local service conversion surface

require_once __DIR__.'/../../../lib/schema_builders.php';
require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/meta_directive.php';

$canonicalUrl = absolute_url('/en-gb/services/ai-overviews-optimization/cambridge/');
$domain = absolute_url('/');

// Set page metadata
$GLOBALS['__page_meta'] = [
  'title' => 'AI Overviews Optimization for Cambridge Businesses | Eligibility Audit | NRLC.ai',
  'description' => 'Cambridge businesses lose AI Overview visibility due to eligibility failures, not content problems. Diagnostic service identifies structural failures preventing AI citation in Google AI Overviews.',
  'keywords' => 'AI Overviews Optimization Cambridge, AI eligibility audit Cambridge, Google AI Overviews Cambridge, AI citation optimization Cambridge, AI visibility Cambridge, structural eligibility Cambridge',
  'canonicalPath' => '/en-gb/services/ai-overviews-optimization/cambridge/'
];

// Add cache control headers to force refresh
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Build JSON-LD Schema with Cambridge locality
$GLOBALS['__jsonld'] = [
  ld_organization(),
  ld_website(),
  // PAGE-PERTINENT SERVICE SCHEMA (REQUIRED)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'AI Overviews Optimization',
    'description' => 'Diagnostic and structural optimization service that enables Cambridge businesses to qualify for visibility and citation in Google AI Overviews.',
    'areaServed' => [
      '@type' => 'AdministrativeArea',
      'name' => 'Cambridge, England'
    ],
    'audience' => [
      '@type' => 'Audience',
      'audienceType' => 'Business decision-makers'
    ],
    'provider' => [
      '@id' => absolute_url('/') . '#organization'
    ],
    'serviceType' => 'AI Overviews Optimization',
    'availableChannel' => [
      '@type' => 'ServiceChannel',
      'serviceLocation' => [
        '@type' => 'Place',
        'address' => [
          '@type' => 'PostalAddress',
          'addressLocality' => 'Cambridge',
          'addressCountry' => 'GB'
        ]
      ]
    ]
  ],
  // CORRECTED WEBPAGE SCHEMA
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'url' => $canonicalUrl,
    'name' => 'AI Overview Visibility for Cambridge Businesses',
    'description' => 'Cambridge businesses lose AI Overview visibility due to eligibility failures, not content problems. Diagnostic service identifies structural failures preventing AI citation.',
    'isPartOf' => [
      '@id' => absolute_url('/') . '#website'
    ],
    'about' => [
      '@type' => 'Service',
      'name' => 'AI Overviews Optimization'
    ],
    'primaryImageOfPage' => [
      '@type' => 'ImageObject',
      'url' => absolute_url('/assets/images/nrlc-logo.png'),
      'width' => 43,
      'height' => 43,
      'caption' => 'NRLC.ai - AI Search Optimization'
    ],
    'keywords' => 'AI Overviews Optimization Cambridge, AI eligibility audit Cambridge, Google AI Overviews Cambridge, AI citation optimization Cambridge, AI visibility Cambridge, structural eligibility Cambridge',
    'about' => [
      ['@type' => 'Thing', 'name' => 'AI Search Optimization', 'description' => 'Optimization of content for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'],
      ['@type' => 'Thing', 'name' => 'AI Visibility', 'description' => 'Visibility of businesses in AI-generated search results and AI system citations'],
      ['@id' => $canonicalUrl . '#service']
    ],
    'mentions' => [
      ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT', 'description' => 'AI language model by OpenAI'],
      ['@type' => 'SoftwareApplication', 'name' => 'Perplexity', 'description' => 'AI-powered search engine'],
      ['@type' => 'SoftwareApplication', 'name' => 'Google AI Overviews', 'description' => 'Google\'s AI-powered search overview feature'],
      ['@type' => 'SoftwareApplication', 'name' => 'Claude', 'description' => 'AI language model by Anthropic']
    ],
    'author' => [
      '@type' => 'Person',
      '@id' => $domain . '#joel-maldonado',
      'name' => 'Joel Maldonado'
    ],
    'publisher' => [
      '@id' => $domain . '#organization'
    ],
    'speakable' => [
      '@type' => 'SpeakableSpecification',
      'cssSelector' => ['h1', 'h2', '.lead']
    ],
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d')
  ],
  // CORRECTED BREADCRUMB LIST (en-gb paths)
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
        'name' => 'Services',
        'item' => absolute_url('/en-gb/services/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'AI Overviews Optimization',
        'item' => absolute_url('/en-gb/services/ai-overviews-optimization/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Cambridge',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // CAMBRIDGE FAQ SCHEMA
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'Why do Cambridge sites rank but not appear in AI Overviews?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Because rankings measure relevance, while AI Overviews require structural eligibility, grounding clarity, and citation confidence.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Is AI Overview visibility a content problem?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No. It is a systems alignment problem involving authority signals, entity clarity, and retrieval confidence.'
        ]
      ]
    ]
  ],
  // PERSON SCHEMA (Joel Maldonado)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $domain . '#joel-maldonado',
    'name' => 'Joel Maldonado',
    'givenName' => 'Joel',
    'familyName' => 'Maldonado',
    'jobTitle' => 'Founder & AI Search Researcher',
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
    'knowsAbout' => [
      'AI Search Optimization',
      'AEO',
      'GEO',
      'AI Overviews Optimization',
      'Eligibility Audits',
      'Structural Optimization',
      'AI Citation Optimization',
      'Structured Data'
    ],
    'worksFor' => [
      '@type' => 'Organization',
      '@id' => $domain . '#organization'
    ],
    'affiliation' => [
      '@type' => 'Organization',
      '@id' => $domain . '#organization'
    ],
    'url' => $domain,
    'sameAs' => [
      'https://www.linkedin.com/company/neural-command/',
      'https://twitter.com/neuralcommand',
      'https://www.crunchbase.com/person/joel-maldonado'
    ]
  ],
  // THING SCHEMAS (Key Concepts)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Search Optimization',
    'description' => 'Optimization of content for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'AI Visibility',
    'description' => 'Visibility of businesses in AI-generated search results and AI system citations'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'Eligibility Audit',
    'description' => 'Diagnostic service that determines whether a website structurally qualifies for AI citation in Google AI Overviews'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <h1>AI Overview Visibility for Cambridge Businesses</h1>
      <p class="lead">If your competitors appear in <strong>AI Overviews</strong> and you do not, this is not a content problem.
      It is an <strong>eligibility failure</strong>.</p>

      <h2>Why Cambridge Sites Lose AI Overview Visibility</h2>
      <p>Cambridge businesses are not excluded from <strong>AI Overviews</strong> because they lack authority.
      They are excluded because authority is assumed, not made <strong>structurally explicit</strong>.</p>

      <p>In research-heavy and technically sophisticated markets, AI systems default to sources that are easy to evaluate, ground, and cite.
      Correct but ambiguous sites are skipped.</p>

      <p>This creates a <strong>silent failure state</strong>.
      Rankings remain. Brand credibility remains. <strong>AI visibility disappears</strong>.</p>

      <p><strong>AI Overviews</strong> do not reward effort.
      They reward <strong>eligibility</strong>.</p>

      <h2>What We Diagnose Before Any Optimization</h2>
      <p>We do not optimize until we determine whether a site qualifies.</p>

      <p>We diagnose:</p>
      <ul>
        <li>Why <strong>Cambridge competitors</strong> are cited instead of your site</li>
        <li>Which <strong>eligibility signals</strong> your pages fail to assert</li>
        <li>Where <strong>authority</strong> is diluted or misclassified</li>
        <li>Why rankings do not translate into <strong>AI inclusion</strong></li>
      </ul>

      <p>If your site does not qualify, optimization is irrelevant.</p>

      <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; margin: 2rem 0; padding: 1.5rem;">
        <h2 id="decision-point">Stop Here If This Sounds Familiar</h2>
        <p>
          If your site ranks but does not appear in <strong>AI Overviews</strong>, continuing to read will not fix that.
          Either your site qualifies for <strong>AI citation</strong> or it does not.
        </p>
        <p>
          The only useful next step is to determine <strong>eligibility</strong>.
        </p>
        <p>
          <a href="#primary-cta" class="btn btn--primary">Run an AI Overview Eligibility Audit</a>
        </p>
      </div>

      <div class="content-block module" style="background: #fff; border: 2px solid #4a90e2; margin: 2rem 0; padding: 2rem; text-align: center;">
        <a id="primary-cta"></a>
        <h2>Assess Your AI Overview Eligibility</h2>
        <p class="lead">
          Determine why <strong>Cambridge competitors</strong> are being cited and whether your site <strong>structurally qualifies</strong>
          before visibility loss compounds.
        </p>
        <p>
          <a href="/contact?service=ai-overviews&location=cambridge" class="btn btn--primary" style="font-size: 1.1rem; padding: 0.75rem 2rem;">
            Run an AI Overview Eligibility Audit
          </a>
        </p>
        <p style="margin-top: 1rem; font-size: 0.9rem; color: #666;">
          No obligation. Response within 24 hours.
        </p>
      </div>

      <details>
        <summary>How the engagement works</summary>
        <p>We assess eligibility, identify structural failures, and enforce alignment across content, entities, and authority signals.
        This is a diagnostic-first engagement, not a checklist service.</p>
      </details>

      <section class="content-block module">
        <h2>Frequently Asked Questions</h2>
        
        <details class="card" style="margin-bottom: 1rem;">
          <summary><strong>Why do Cambridge sites rank but not appear in AI Overviews?</strong></summary>
          <p class="small muted">Because rankings measure relevance, while <strong>AI Overviews</strong> require <strong>structural eligibility</strong>, grounding clarity, and citation confidence.</p>
        </details>

        <details class="card" style="margin-bottom: 1rem;">
          <summary><strong>Is AI Overview visibility a content problem?</strong></summary>
          <p class="small muted">No. It is a <strong>systems alignment problem</strong> involving authority signals, entity clarity, and retrieval confidence.</p>
        </details>
      </section>

      <section class="content-block module">
        <h2>Related Resources</h2>
        <ul>
          <li><a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization</a> — Learn about AI search optimization principles</li>
          <li><a href="<?= absolute_url('/en-gb/services/site-audits/cambridge/') ?>">Site Audits in Cambridge</a> — Comprehensive technical audits</li>
          <li><a href="<?= absolute_url('/en-gb/services/technical-seo/cambridge/') ?>">Technical SEO in Cambridge</a> — Technical infrastructure optimization</li>
          <li><a href="<?= absolute_url('/insights/') ?>">Research & Insights</a> — Technical analyses of AI search systems</li>
        </ul>
      </section>

    </div>
  </section>
</main>