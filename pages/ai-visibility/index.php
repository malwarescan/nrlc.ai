<?php
// AI Visibility Service Landing Page
// Metadata is handled by router via $GLOBALS['__page_meta']
require_once __DIR__ . '/../../lib/schema_builders.php';

$industries = require __DIR__ . '/../../lib/ai_visibility_industries.php';
$canonicalUrl = absolute_url('/ai-visibility/');
$domain = absolute_url('/');

// Build JSON-LD Schema (STRICT COMPLIANCE: JSON-LD ONLY, NO MICRODATA/RDFa)
// ENFORCEMENT: All schema MUST be JSON-LD, injected into <head>, NO microdata/RDFa, NO duplication

$GLOBALS['__jsonld'] = [
  // 1. Organization (MANDATORY, SINGLE SOURCE OF TRUTH)
  // Requirements: name: NRLC.ai, url: canonical site root, logo: absolute URL
  // Rules: ONE Organization entity only, referenced by all other schemas
  // Purpose: Anchor all AI statements and citations to a real-world entity
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => $domain . '#organization',
    'name' => 'NRLC.ai',
    'url' => $domain,
    'logo' => [
      '@type' => 'ImageObject',
      'url' => absolute_url('/assets/images/nrlc-logo.png'),
      'width' => 43,
      'height' => 43
    ],
    'sameAs' => [
      'https://www.linkedin.com/company/neural-command/',
      'https://g.co/kgs/EP6p5de'
    ]
  ],
  
  // 2. Service (REQUIRED - PRIMARY SCHEMA)
  // This schema defines the page intent. Without this, the page is NOT a service in Google's eyes.
  // This must be the strongest schema on the page.
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'AI Visibility & Trust Audit',
    'serviceType' => 'AI Visibility Optimization',
    'description' => 'Professional analysis of how AI systems describe, summarize, and trust a business, including the signals influencing AI-generated answers.',
    'provider' => [
      '@id' => $domain . '#organization'
    ],
    'url' => $canonicalUrl
  ],
  
  // 3. WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'AI Visibility',
    'description' => 'Professional service offering AI Visibility & Trust Audit. Analysis of how AI systems like ChatGPT, Google AI Overviews, Perplexity, and Claude describe businesses and the signals that influence AI-generated summaries.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ],
    'mainEntity' => [
      '@id' => $canonicalUrl . '#service'
    ]
  ],
  
  // 4. BreadcrumbList (MANDATORY)
  // Structure: Home → AI Visibility
  // Rules: URLs must match real crawlable paths. Reinforces site architecture and topical containment.
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumbs',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $domain
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'AI Visibility',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // 5. FAQPage (STRICT, ZERO TOLERANCE)
  // Rules: ONLY questions that appear verbatim on the page. Answers MUST match visible content word-for-word.
  // NO paraphrasing. NO additional FAQs.
  // Purpose: AI question-answer extraction, Rich eligibility, LLM grounding
  // If content changes, FAQ schema MUST be updated immediately.
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'Can you control what ChatGPT says about my business?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'We can\'t force AI to say anything, but we can control the signals it learns from.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Is this different from SEO?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Yes. SEO targets rankings. This targets AI understanding and trust.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Will this replace Google rankings?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'No. It complements SEO and protects you as AI replaces clicks.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Is this safe and compliant?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Yes. We use transparent, compliance-safe methods.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'How long does it take to see changes?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'AI visibility changes as signals propagate. Early improvements often appear within weeks.'
        ]
      ]
    ]
  ],
  
  // 6. Action (RECOMMENDED - CONVERSION SIGNAL)
  // Tell AI systems this page exists to trigger a professional audit request, not passive reading.
  [
    '@context' => 'https://schema.org',
    '@type' => 'Action',
    'name' => 'Request AI Visibility Audit',
    'actionStatus' => 'https://schema.org/PotentialActionStatus',
    'target' => [
      '@type' => 'EntryPoint',
      'urlTemplate' => $domain . 'api/book/',
      'actionPlatform' => 'http://schema.org/DesktopWebPlatform'
    ]
  ]
];
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- HERO (ABOVE THE FOLD: WHAT, WHO, WHAT PROBLEM) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI Visibility & Trust Audit</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 1.5rem;"><strong>WHAT:</strong> A professional diagnostic service that analyzes how AI systems like ChatGPT, Google AI Overviews, Perplexity, and Claude describe your business.</p>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 1.5rem;"><strong>WHO:</strong> For businesses in high-trust industries where customers research extensively before making decisions.</p>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;"><strong>PROBLEM:</strong> AI assistants now answer customer questions directly, summarizing information instead of linking to websites. If AI systems don't understand or trust your business, they recommend competitors. <strong>This is NOT traditional SEO.</strong> SEO targets search rankings. AI Visibility targets how AI systems understand, describe, and trust your business.</p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
          <a href="/api/book/" class="btn btn--primary" data-ripple>Request AI Visibility Audit</a>
          <a href="/api/book/" class="btn" data-ripple>See How AI Describes Your Business</a>
        </div>
      </div>
    </div>

    <!-- SECTION: YOUR CUSTOMERS ARE ASKING AI FIRST -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Your Customers Are Asking AI First</h2>
      </div>
      <div class="content-block__body">
        <p>People no longer start with search results. They start by asking AI questions like:</p>
        <ul>
          <li>"Do I need a [service provider] for my situation?"</li>
          <li>"What happens if I wait too long?"</li>
          <li>"Which option applies to me?"</li>
          <li>"What are the risks if I do this incorrectly?"</li>
        </ul>
        <p><strong>AI now answers these questions directly.</strong> Whoever AI trusts becomes the default option.</p>
      </div>
    </div>

    <!-- SECTION: SEO GETS YOU RANKED. AI DECIDES WHO GETS TRUSTED. -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">SEO Gets You Ranked. AI Decides Who Gets Trusted.</h2>
      </div>
      <div class="content-block__body">
        <p>Search results are shrinking. AI assistants like ChatGPT, Google AI Overviews, Perplexity, and Claude summarize instead of linking.</p>
        <p>AI doesn't rank pages the way Google does. It pulls from AI Trust Signals:</p>
        <ul>
          <li>Clear service definitions</li>
          <li>Consistent explanations</li>
          <li>Structured, machine-readable signals</li>
          <li>Repeated authority patterns across the web</li>
        </ul>
        <p>If your business is unclear, AI fills in the gaps — often with competitors. This is about how AI describes your business, not search rankings.</p>
      </div>
    </div>

    <!-- SECTION: WHAT WE DO -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Do (In Plain English)</h2>
      </div>
      <div class="content-block__body">
        <p>We analyze how AI systems like ChatGPT, Google AI Overviews, Perplexity, and Claude currently describe your business, your services, and your competitors.</p>
        <p>Then we restructure your website and digital signals so AI assistants:</p>
        <ul>
          <li>Understand exactly what you do</li>
          <li>Trust your expertise</li>
          <li>Reference your business accurately</li>
          <li>Prefer you when explaining options</li>
        </ul>
        <p><strong>We don't try to trick AI. We make your business unambiguous.</strong></p>
        <p><strong>This is NOT SEO.</strong> We focus on AI Trust Signals and how AI describes your business, not search rankings or keyword optimization.</p>
      </div>
    </div>

    <!-- SECTION: INDUSTRY-SPECIFIC PAGES -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Industry-Specific AI Visibility</h2>
      </div>
      <div class="content-block__body">
        <p>We provide specialized AI visibility optimization for high-trust industries where customers research extensively before making decisions:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-md); margin-top: var(--spacing-md);">
          <?php foreach ($industries as $slug => $industry): ?>
            <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #e0e0e0); border-radius: 4px;">
              <h3 style="margin-top: 0; font-size: 1.1rem;"><a href="/ai-visibility/<?= htmlspecialchars($slug) ?>/"><?= htmlspecialchars($industry['name']) ?></a></h3>
              <p style="font-size: 0.9rem; color: #666;"><?= htmlspecialchars($industry['core_fear']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- SECTION: THIS IS ALREADY HAPPENING -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">This Is Already Happening</h2>
      </div>
      <div class="content-block__body">
        <p>AI assistants like ChatGPT, Google AI Overviews, Perplexity, and Claude already:</p>
        <ul>
          <li>Summarize reviews instead of users reading them</li>
          <li>Answer "do I need a [service provider]?" directly</li>
          <li>Explain risks and timelines without visiting websites</li>
          <li>Mention specific businesses by name when authority is clear</li>
        </ul>
        <p><strong>Ignoring AI Visibility means losing control of how your business is represented in AI-generated summaries.</strong></p>
      </div>
    </div>

    <!-- SECTION: THE OFFER -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Offer: AI Visibility & Trust Audit</h2>
      </div>
      <div class="content-block__body">
        <p><strong>AI Visibility & Trust Audit</strong> is a diagnostic that measures how AI systems describe your business and identifies the exact signals needed to become the trusted recommendation.</p>
        <p>You receive:</p>
        <ul>
          <li>A breakdown of how AI currently describes your business</li>
          <li>Where competitors are being favored</li>
          <li>What AI Trust Signals are missing or unclear</li>
          <li>A prioritized fix list</li>
        </ul>
        <p><strong>This is a diagnostic, not a contract.</strong> This is: a diagnostic + prioritized fix list. This isn't: a promise to control AI output or guaranteed rankings.</p>
        <p style="margin-top: var(--spacing-lg);">
          <a href="/api/book/" class="btn btn--primary" data-ripple>Request AI Visibility Audit</a>
        </p>
      </div>
    </div>

    <!-- FAQ SECTION (STRICT: Must match FAQPage schema verbatim) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt><strong>Can you control what ChatGPT says about my business?</strong></dt>
          <dd>We can't force AI to say anything, but we can control the signals it learns from.</dd>
          
          <dt><strong>Is this different from SEO?</strong></dt>
          <dd>Yes. SEO targets rankings. This targets AI understanding and trust.</dd>
          
          <dt><strong>Will this replace Google rankings?</strong></dt>
          <dd>No. It complements SEO and protects you as AI replaces clicks.</dd>
          
          <dt><strong>Is this safe and compliant?</strong></dt>
          <dd>Yes. We use transparent, compliance-safe methods.</dd>
          
          <dt><strong>How long does it take to see changes?</strong></dt>
          <dd>AI visibility changes as signals propagate. Early improvements often appear within weeks.</dd>
        </dl>
      </div>
    </div>

  </div>
</section>
</main>

