<?php
// Metadata is now set by the router via sudo_meta_directive_ctx()
// See bootstrap/router.php lines 64-76 for homepage metadata configuration
// Note: head.php and header.php are already included by router.php render_page()
// Do not set $GLOBALS['pageTitle'] or $GLOBALS['pageDesc'] here - they are ignored

require_once __DIR__ . '/../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/');
$domain = absolute_url('/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- HERO SECTION -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h1 class="content-block__title">Search Visibility Isn't Enough Anymore. AI Systems Decide What Gets Cited.</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-md);">
          We help brands turn search authority into AI citations across Google AI Overviews, ChatGPT, and emerging answer engines.
        </p>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-sm);">
          Led by Joel Maldonado - 20+ years in search, structured data, and algorithmic visibility.
        </p>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-lg);">
          Serving companies across the United States and United Kingdom, with proven results in competitive local and international markets.
        </p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Free AI Visibility Audit')">Free AI Visibility Audit</button>
          <a href="#authority-explanation" class="btn btn--secondary" title="Learn why traditional SEO stops working with AI systems">Why Traditional SEO Stops Working</a>
        </div>
      </div>
    </div>

    <!-- TRAINING BOX: AGENCY TRAINING SURFACE -->
    <div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__body">
        <h3 style="margin-top: 0;">Training for Marketing and SEO Teams Working in AI Search</h3>
        <p>Traditional SEO training focuses on rankings, keywords, and crawl behavior. Modern AI search systems work differently. Large language models evaluate whether information can be extracted, embedded, verified, and cited safely rather than whether a page simply ranks.</p>
        <p>Neural Command provides technical training for marketing and SEO teams on how LLMs ingest web content, how vector representations are formed, and how prechunked, structured information affects retrieval and citation in systems such as Google AI Overviews and ChatGPT.</p>
        <p>This training is designed for agencies and in-house teams responsible for search strategy, content architecture, and information systems. It is not intended for beginners or general marketing education.</p>
        <p><a href="/training/ai-search-systems/" title="View training program for marketing and SEO agencies">View training program for agencies</a></p>
      </div>
    </div>

    <!-- PRECHUNKING SEO COURSE CTA -->
    <div class="content-block module" style="background: #fff3cd; border-left: 3px solid #ffc107; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__body">
        <h3 style="margin-top: 0; color: #856404;">Prechunking SEO Operator Training</h3>
        <p style="color: #856404;"><strong>A hands-on, skills-based course for controlling AI retrieval and citation.</strong></p>
        <p style="color: #856404;">Learn how to structure content so facts survive AI extraction. This is not a reading course—it's an operator course. You'll complete structured modules, produce artifacts, and validate your work against strict criteria.</p>
        <p style="color: #856404; margin-bottom: var(--spacing-md);"><strong>6 modules | 6+ hours | 100% hands-on</strong></p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
          <a href="/docs/prechunking-seo/course/" class="btn btn--primary" title="Start Prechunking SEO Operator Training course">Start Course</a>
          <a href="/docs/prechunking-seo/" class="btn btn--secondary" title="Read Prechunking SEO documentation">View Documentation</a>
        </div>
      </div>
    </div>

    <!-- FAQ SECTION: AI VISIBILITY QUESTIONS -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Questions About AI Search, ChatGPT, and Brand Visibility</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt><strong>How do I get my business mentioned by ChatGPT or AI search tools?</strong></dt>
          <dd>AI systems like ChatGPT do not browse the web or list businesses in directories. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. Businesses are more likely to be mentioned when their identity and services are clearly defined in machine readable formats across the web.</dd>
          
          <dt><strong>How does ChatGPT decide which brands to mention?</strong></dt>
          <dd>ChatGPT and similar systems evaluate whether information about a brand can be confidently extracted and verified across multiple sources. Brands are more likely to be mentioned when their content clearly defines who they are, what they do, and how they relate to a topic, using consistent language and structure across the web.</dd>
          
          <dt><strong>Can businesses influence how they appear in AI-generated answers?</strong></dt>
          <dd>Businesses can't control AI outputs directly, but they can influence eligibility. This is done by structuring content for machine comprehension, aligning on entity definitions, and reducing ambiguity so AI systems can reference the brand without risk of misinformation.</dd>
          
          <dt><strong>Is ranking on Google enough to be featured in AI Overviews or ChatGPT?</strong></dt>
          <dd>No. Traditional rankings measure page relevance, while AI systems prioritize extractability and trust. A page can rank well and still be ignored by AI if its information isn't structured, explicit, and verifiable enough to be cited safely.</dd>
        </dl>
      </div>
    </div>

    <!-- AUTHORITY EXPLANATION BLOCK -->
    <div class="content-block module" id="authority-explanation" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Decide What to Cite</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems do not rank pages the way search engines do. They extract entities, relationships, and evidence. When an AI system needs to answer a question, it evaluates which sources provide clear, structured, and trustworthy information that can be safely summarized and cited.</p>
        <p>Traditional SEO optimizes for crawling and ranking. It measures success by position in search results and traffic volume. This approach assumes that appearing in search results is sufficient for visibility. It is not.</p>
        <p>Pages without structured authority signals are invisible to AI answers. When AI systems cannot confidently extract what your business does, how it operates, or why it should be trusted, they default to sources that provide these signals clearly.</p>
        <p>NRLC.ai engineers content specifically for AI extraction, trust, and reuse. We structure pages so AI systems can confidently understand your business, map your expertise, and cite you when answering relevant questions.</p>
        <p><strong>This is the gap between ranking and being referenced.</strong></p>
      </div>
    </div>

    <!-- COMPARISON BLOCK -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">The Difference</h2>
      </div>
      <div class="content-block__body">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-md);">
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 style="margin-top: 0;">Traditional SEO Agencies</h3>
            <ul>
              <li>Optimize pages for keywords</li>
              <li>Focus on rankings and traffic</li>
              <li>Measure success by impressions and clicks</li>
              <li>Assume AI systems behave like search engines</li>
            </ul>
          </div>
          <div style="border: 1px solid #4a90e2; padding: var(--spacing-md); border-radius: 4px; background: #f0f7ff;">
            <h3 style="margin-top: 0; color: #4a90e2;">NRLC.ai</h3>
            <ul>
              <li>Engineer entities and relationships</li>
              <li>Optimize for AI citation and reuse</li>
              <li>Measure success by AI visibility and reference frequency</li>
              <li>Design content for LLM extraction and trust scoring</li>
            </ul>
          </div>
        </div>
        <style>
          @media (min-width: 768px) {
            .content-block__body > div[style*="grid-template-columns"] {
              grid-template-columns: 1fr 1fr !important;
            }
          }
        </style>
      </div>
    </div>

    <!-- AUTHORITATIVE VOICE INSERT (JOEL MALDONADO) -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8); border-left: 3px solid #4a90e2; padding-left: var(--spacing-md);">
      <div class="content-block__header">
        <h2 class="content-block__title">Why I Built This System</h2>
      </div>
      <div class="content-block__body">
        <p>Modern visibility failures aren't due to "bad SEO." They happen because the web is now read by machines that require structure, evidence, and consistency - and most sites were never built for that.</p>
        <p>When Google AI Overviews or ChatGPT needs to answer a question, it doesn't rank pages. It evaluates which sources provide information that can be extracted, verified, and cited safely. If your site doesn't provide these signals clearly, AI systems won't reference you, regardless of your search rankings.</p>
        <p>This system exists to bridge that gap. We turn search authority into AI citations by engineering content for machine comprehension, not just human readability.</p>
        <p style="margin-top: var(--spacing-lg); font-style: italic;">
          - Joel Maldonado<br>
          <span style="font-size: 0.9rem; color: #666;">Founder, Neural Command LLC</span>
        </p>
      </div>
    </div>

    <!-- SERVICE POSITIONING BLOCK -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Actually Do</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Audit how AI systems currently interpret your brand</li>
          <li>Identify missing or broken authority signals</li>
          <li>Rebuild pages for AI extraction, not just rankings</li>
          <li>Monitor AI visibility across answer engines</li>
          <li>Continuously adapt as models and policies change</li>
        </ul>
        <p style="margin-top: var(--spacing-md); padding: var(--spacing-md); background: #f9f9f9; border-left: 3px solid #4a90e2;">
          <strong>This is not a tool. It's an engineered service.</strong>
        </p>
      </div>
    </div>

    <!-- FINAL CTA -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body">
        <p class="lead" style="margin-bottom: var(--spacing-md);">
          See how AI systems currently interpret your brand and what needs to change.
        </p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
          <button type="button" class="btn" onclick="openContactSheet('AI Visibility Analysis')">See How AI Sees Your Brand</button>
          <a href="/services/" class="btn btn--secondary" title="View all AI SEO services offered by NRLC.ai">View Services</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// PERSON + ORGANIZATION ENTITY DECLARATION - HOMEPAGE
// SUDO META DIRECTIVE: Entity declaration for Knowledge Graph consolidation
require_once __DIR__ . '/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

// Canonical base URL (no locale prefix for entity resolution)
$baseUrl = SchemaFixes::ensureHttps(absolute_url('/'));
$logoUrl = SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png'));

// Add @graph structure to global JSON-LD array
$GLOBALS['__jsonld'] = $GLOBALS['__jsonld'] ?? [];
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'Person',
      '@id' => $baseUrl . '#joel-maldonado',
      'name' => 'Joel Maldonado',
      'jobTitle' => 'Founder',
      'description' => 'Joel Maldonado is the founder of Neural Command, LLC, where he builds systems that convert search authority into AI-readable, citation-safe knowledge for modern search engines and large language models.',
      'worksFor' => [
        '@type' => 'Organization',
        '@id' => $baseUrl . '#neural-command'
      ],
      'affiliation' => [
        '@type' => 'Organization',
        '@id' => $baseUrl . '#neural-command'
      ],
      'url' => $baseUrl,
      'sameAs' => [
        'https://www.linkedin.com/company/neural-command/'
      ]
    ],
    [
      '@type' => 'Organization',
      '@id' => $baseUrl . '#neural-command',
      'name' => 'Neural Command, LLC',
      'url' => $baseUrl,
      'logo' => [
        '@type' => 'ImageObject',
        'url' => $logoUrl
      ],
      'founder' => [
        '@type' => 'Person',
        '@id' => $baseUrl . '#joel-maldonado'
      ],
      'sameAs' => [
        'https://www.linkedin.com/company/neural-command/'
      ]
    ],
    [
      '@type' => 'WebPage',
      '@id' => $baseUrl . '#why-i-built-this-system',
      'name' => 'Why I Built This System',
      'about' => [
        '@type' => 'Person',
        '@id' => $baseUrl . '#joel-maldonado'
      ],
      'isPartOf' => [
        '@type' => 'WebSite',
        '@id' => $baseUrl . '#website'
      ]
    ],
    [
      '@type' => 'WebSite',
      '@id' => $baseUrl . '#website',
      'url' => $baseUrl,
      'name' => 'Neural Command'
    ]
  ]
];

// Also set founder for backward compatibility with existing Organization schema
$GLOBALS['__homepage_org_founder'] = [
  '@type' => 'Person',
  '@id' => $baseUrl . '#joel-maldonado',
  'name' => 'Joel Maldonado'
];

// FAQ SCHEMA: AI Visibility Questions (matches visible FAQ content exactly)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'FAQPage',
  'mainEntity' => [
    [
      '@type' => 'Question',
      'name' => 'How do I get my business mentioned by ChatGPT or AI search tools?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'AI systems like ChatGPT do not browse the web or list businesses in directories. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. Businesses are more likely to be mentioned when their identity and services are clearly defined in machine readable formats across the web.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'How does ChatGPT decide which brands to mention?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'ChatGPT evaluates whether information about a brand can be confidently extracted and verified across multiple sources. Brands with clear entity definitions, consistent language, and corroborating references are more likely to be included in AI-generated answers.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Can businesses influence how they appear in AI-generated answers?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Businesses cannot directly control AI outputs, but they can influence eligibility. This involves structuring content for machine comprehension, aligning on consistent entity signals, and reducing ambiguity so AI systems can reference the brand without risk.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Is ranking on Google enough to be featured in AI Overviews or ChatGPT?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Traditional rankings measure relevance, but AI systems prioritize extractability and trust. A page may rank well and still be excluded from AI-generated answers if its information is not structured, explicit, and verifiable enough to be safely cited.'
      ]
    ]
  ]
];
?>




