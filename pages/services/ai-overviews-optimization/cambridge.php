<?php
// Cambridge AI Overviews Optimization Service Page
// URL: /en-gb/services/ai-overviews-optimization/cambridge/
// High-intent local service conversion surface

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/en-gb/services/ai-overviews-optimization/cambridge/');
// Cache buster for immediate refresh
$cacheBuster = '?v=' . time();
$domain = absolute_url('/');

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
      'url' => absolute_url('/logo.png')
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
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <h1>AI Overview Visibility for Cambridge Businesses</h1>
      <p>If your competitors appear in AI Overviews and you do not, this is not a content problem.
      It is an eligibility failure.</p>

      <h2>Why Cambridge Sites Lose AI Overview Visibility</h2>
      <p>Cambridge businesses are not excluded from AI Overviews because they lack authority.
      They are excluded because authority is assumed, not made structurally explicit.</p>

      <p>In research-heavy and technically sophisticated markets, AI systems default to sources that are easy to evaluate, ground, and cite.
      Correct but ambiguous sites are skipped.</p>

      <p>This creates a silent failure state.
      Rankings remain. Brand credibility remains. AI visibility disappears.</p>

      <p>AI Overviews do not reward effort.
      They reward eligibility.</p>

      <h2>What We Diagnose Before Any Optimization</h2>
      <p>We do not optimize until we determine whether a site qualifies.</p>

      <p>We diagnose:</p>
      <ul>
        <li>Why Cambridge competitors are cited instead of your site</li>
        <li>Which eligibility signals your pages fail to assert</li>
        <li>Where authority is diluted or misclassified</li>
        <li>Why rankings do not translate into AI inclusion</li>
      </ul>

      <p>If your site does not qualify, optimization is irrelevant.</p>

      <section class="decision-interruption" aria-labelledby="decision-point">
        <h2 id="decision-point">Stop Here If This Sounds Familiar</h2>
        <p>
          If your site ranks but does not appear in AI Overviews, continuing to read will not fix that.
          Either your site qualifies for AI citation or it does not.
        </p>
        <p>
          The only useful next step is to determine eligibility.
        </p>
        <p>
          <a href="#primary-cta">Run an AI Overview eligibility audit</a>
        </p>
      </section>

      <section class="primary-cta-block" role="region" aria-label="Primary Call to Action">
        <a id="primary-cta"></a>
        <h2>Assess Your AI Overview Eligibility</h2>
        <p>
          Determine why Cambridge competitors are being cited and whether your site structurally qualifies
          before visibility loss compounds.
        </p>
        <p>
          <a href="/contact?service=ai-overviews&location=cambridge">
            Run an AI Overview eligibility audit
          </a>
        </p>
      </section>

      <details>
        <summary>How the engagement works</summary>
        <p>We assess eligibility, identify structural failures, and enforce alignment across content, entities, and authority signals.
        This is a diagnostic-first engagement, not a checklist service.</p>
      </details>

      <h2>Frequently Asked Questions</h2>

      <h3>Why do Cambridge sites rank but not appear in AI Overviews?</h3>
      <p>Because rankings measure relevance, while AI Overviews require structural eligibility, grounding clarity, and citation confidence.</p>

      <h3>Is AI Overview visibility a content problem?</h3>
      <p>No. It is a systems alignment problem involving authority signals, entity clarity, and retrieval confidence.</p>

    </div>
  </section>
</main>