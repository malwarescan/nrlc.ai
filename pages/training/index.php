<?php
/**
 * Training Hub Page - /training/
 * 
 * META DIRECTIVE: Training & Classes Offering
 * Role: Operational training for teams running production systems
 * Intent: Skill transfer for agent supervision and MCP governance
 * 
 * This is NOT beginner education.
 * This is operational training for teams running real systems.
 */

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$canonicalUrl = absolute_url('/training/');
$domain = absolute_url('/');

// Set page metadata
$GLOBALS['__page_slug'] = 'training/index';
$GLOBALS['__page_meta'] = [
  'title' => 'Operating AI Search Systems Safely, At Scale | NRLC.ai',
  'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems. Agent supervision, schema governance, Search Console telemetry, and content for AI extraction.',
  'keywords' => 'AI agent training, MCP training, Model Context Protocol, agent supervision, schema governance, AI search training, Neural Command OS training, ChatGPT training, Perplexity training, Google AI Overviews training, AI SEO training, technical SEO training, agent-driven SEO, MCP governance, AI retrieval mechanics',
  'canonicalPath' => '/training/'
];

// Build JSON-LD Schema (EducationalOccupationalProgram, NOT Service)
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';
$personId = SchemaFixes::ensureHttps(gbp_website()) . '#joel-maldonado';

$GLOBALS['__jsonld'] = [
  // Organization schema (GBP-aligned)
  ld_organization(),
  
  // BreadcrumbList
  ld_breadcrumbs(),
  
  // Person schema (Joel Maldonado as instructor)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $personId,
    'name' => 'Joel Maldonado',
    'givenName' => 'Joel',
    'familyName' => 'Maldonado',
    'jobTitle' => 'Founder & AI Search Researcher',
    'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
    'knowsAbout' => [
      'AI Search Optimization', 'AEO', 'GEO', 'Agent Supervision', 
      'Model Context Protocol', 'Schema Governance', 'AI Search Training',
      'MCP Governance', 'AI Retrieval Mechanics', 'Agent-Driven SEO'
    ],
    'worksFor' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'affiliation' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'url' => $domain,
    'sameAs' => [
      'https://www.linkedin.com/company/neural-command/',
      'https://twitter.com/neuralcommand',
      'https://www.crunchbase.com/person/joel-maldonado'
    ]
  ],
  
  // EducationalOccupationalProgram schema (PRIMARY - Training is education, not service)
  [
    '@context' => 'https://schema.org',
    '@type' => 'EducationalOccupationalProgram',
    '@id' => $canonicalUrl . '#program',
    'name' => 'AI Search Systems & Agent Governance Training',
    'alternateName' => 'Operating AI Search Systems Safely, At Scale',
    'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems. Focused on agent supervision, schema governance, Google Search Console telemetry, and content designed for reliable extraction by AI search surfaces.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $orgId,
      'name' => 'Neural Command, LLC',
      'url' => $domain
    ],
    'teaches' => [
      'MCP literacy and governance',
      'Agent supervision and safety boundaries',
      'Schema as a control layer, not markup',
      'AI retrieval and grounding mechanics',
      'Content standards for AI extraction',
      'How to read Search Console as telemetry',
      'How to avoid AI-induced SEO regressions',
      'Agent operation and supervision',
      'AI search surfaces and retrieval mechanics',
      'Content as machine-interpretable information',
      'Model Context Protocol (MCP) constraints',
      'Entity resolution and canonical law',
      'Grounding budget management',
      'Indexing behavior and silent failures',
      'AI retrieval signal optimization'
    ],
    'educationalCredentialAwarded' => 'Certificate of Completion',
    'programType' => 'Professional Training',
    'timeRequired' => 'PT8H', // 8 hours minimum
    'occupationalCategory' => 'Technical SEO',
    'educationalLevel' => 'Professional',
    'inLanguage' => 'en-US',
    'audience' => [
      '@type' => 'EducationalAudience',
      'educationalRole' => 'Professional',
      'audienceType' => 'Heads of SEO, Technical SEOs, Founders, Engineering Teams, Content Leads'
    ],
    'instructor' => [
      '@type' => 'Person',
      '@id' => $personId,
      'name' => 'Joel Maldonado'
    ]
  ],
  
  // WebPage schema (ENHANCED)
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Operating AI Search Systems Safely, At Scale | NRLC.ai',
    'url' => $canonicalUrl,
    'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems.',
    'inLanguage' => 'en-US',
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d'),
    'keywords' => 'AI agent training, MCP training, Model Context Protocol, agent supervision, schema governance, AI search training, Neural Command OS training, ChatGPT training, Perplexity training, Google AI Overviews training',
    'about' => [
      [
        '@type' => 'EducationalOccupationalProgram',
        '@id' => $canonicalUrl . '#program'
      ],
      [
        '@type' => 'Thing',
        'name' => 'Model Context Protocol',
        'alternateName' => 'MCP',
        'description' => 'A protocol for constraining AI agent behavior in SEO systems, ensuring agents operate within defined boundaries and safety constraints'
      ],
      [
        '@type' => 'Thing',
        'name' => 'Agent Supervision',
        'description' => 'The practice of monitoring and governing AI agents operating in production systems, including approving, blocking, or rolling back agent actions safely'
      ],
      [
        '@type' => 'Thing',
        'name' => 'Schema Governance',
        'description' => 'The practice of using schema markup as a control layer for AI systems, not just markup for search engines'
      ]
    ],
    'mentions' => [
      [
        '@type' => 'SoftwareApplication',
        'name' => 'ChatGPT',
        'description' => 'AI language model by OpenAI'
      ],
      [
        '@type' => 'SoftwareApplication',
        'name' => 'Perplexity',
        'description' => 'AI-powered search engine'
      ],
      [
        '@type' => 'SoftwareApplication',
        'name' => 'Google AI Overviews',
        'description' => 'Google\'s AI-powered search overview feature'
      ],
      [
        '@type' => 'SoftwareApplication',
        'name' => 'Neural Command OS',
        'description' => 'Operating system for AI-driven SEO that installs the Model Context Protocol and agent execution layer'
      ]
    ],
    'author' => [
      '@type' => 'Person',
      '@id' => $personId
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => gbp_business_name(),
      'url' => $domain
    ],
    'speakable' => [
      '@type' => 'SpeakableSpecification',
      'cssSelector' => ['h1', '.lead']
    ]
  ],
  
  // Thing schemas for key concepts
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'MCP',
    'alternateName' => 'Model Context Protocol',
    'description' => 'Model Context Protocol - A protocol for constraining AI agent behavior in SEO systems'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Thing',
    'name' => 'Agent Supervision',
    'description' => 'The practice of monitoring and governing AI agents operating in production systems'
  ]
];

// FAQ Schema: Based on "What We Teach / What We Don't" content
try {
  $GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'What is this training for?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'This is operational training for teams running real systems. We train teams to understand, supervise, and govern AI agents operating inside a Model Context Protocol (MCP), and to produce content that AI search systems can reliably extract, ground, and cite without destabilizing production SEO.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Who is this training for?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Heads of SEO, Technical SEOs, Founders running production systems, Engineering teams interfacing with search, and Content leads working inside AI-driven workflows. If your site is already large, visible, or revenue-critical, this training is preventative infrastructure.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What does this training cover?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Agent operation and supervision, AI search surfaces and retrieval mechanics, content as machine-interpretable information, MCP literacy and governance, schema as a control layer, AI retrieval and grounding mechanics, and how to avoid AI-induced SEO regressions.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What does this training NOT cover?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'We do not teach prompt engineering for bloggers, AI writing tricks, keyword hacks for LLMs, "Rank in AI Overviews" shortcuts, generic SEO fundamentals, or content automation without constraints. If someone is looking for growth hacks or AI copywriting shortcuts, this training is not a fit.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Do I need Neural Command OS to take this training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Training assumes a production system. If Neural Command OS is not installed, this training focuses on preparing teams for MCP-based search systems rather than replacing execution.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What is MCP (Model Context Protocol)?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Model Context Protocol (MCP) is a protocol for constraining AI agent behavior in SEO systems, ensuring agents operate within defined boundaries and safety constraints. MCP prevents agents from overriding canonical law, breaking entity resolution, wasting grounding budget, introducing silent indexing failures, or poisoning AI retrieval with low-signal content.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What is agent supervision?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Agent supervision is the practice of monitoring and governing AI agents operating in production systems. Teams learn to understand how SEO agents reason and act, interpret agent decisions through MCP constraints, approve/block/roll back agent actions safely, distinguish between advisory signals and executable actions, and avoid unbounded or heuristic-driven automation.'
        ]
      ]
    ]
  ];
} catch (Throwable $e) {
  // Silent fail - FAQ schema is optional
}
?>

<main role="main" class="container" itemscope itemtype="https://schema.org/WebPage">
<article itemscope itemtype="https://schema.org/Article" class="section">
    <div class="section__content">
      
      <!-- ABOVE THE FOLD: Operational Training Positioning -->
    <header class="content-block module">
        <div class="content-block__header">
        <h1 class="content-block__title" itemprop="headline">Operating <strong>AI Search Systems</strong> Safely, At Scale</h1>
        </div>
        <div class="content-block__body">
        <p class="lead" itemprop="description">This training exists because <strong>Neural Command OS</strong> is not a tool and <strong>agent-driven SEO</strong> is not something teams should improvise.</p>
          <div class="callout-system-truth" style="margin: 1.5rem 0; padding: 1rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
            <p><strong>This is not education for beginners.</strong></p>
            <p><strong>This is operational training for teams running real systems.</strong></p>
          </div>
        <p>We train teams to understand, supervise, and govern <strong>AI agents</strong> operating inside a <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn>, and to produce content that <strong>AI search systems</strong> can reliably extract, ground, and cite without destabilizing production <abbr title="Search Engine Optimization">SEO</abbr>.</p>
        <div class="btn-group" style="margin-top: var(--spacing-lg);">
          <a href="<?= absolute_url('/training/one-on-one/') ?>" class="btn btn--primary">View One-on-One Training</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary">Book Training Consultation</a>
        </div>
      </div>
    </header>

    <!-- TECHNICAL DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
    <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Terminology: <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn>, <strong>Agent Supervision</strong>, and <strong>Schema Governance</strong></h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt id="mcp" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> <span itemprop="name">(Model Context Protocol)</span>
          </dt>
          <dd itemprop="description">
            A protocol for constraining <strong>AI agent</strong> behavior in <abbr title="Search Engine Optimization">SEO</abbr> systems, ensuring agents operate within defined boundaries and safety constraints. <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> prevents agents from overriding <strong>canonical law</strong>, breaking <strong>entity resolution</strong>, wasting <strong>grounding budget</strong>, introducing <strong>silent indexing failures</strong>, or poisoning <strong>AI retrieval</strong> with low-signal content.
          </dd>
          
          <dt id="agent-supervision" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Agent Supervision</strong></dfn>
          </dt>
          <dd itemprop="description">
            The practice of monitoring and governing <strong>AI agents</strong> operating in production systems, including approving, blocking, or rolling back agent actions safely. Teams learn to understand how <abbr title="Search Engine Optimization">SEO</abbr> agents reason and act, interpret agent decisions through <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> constraints, distinguish between advisory signals and executable actions, and avoid unbounded or heuristic-driven automation.
          </dd>
          
          <dt id="schema-governance" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Schema Governance</strong></dfn>
          </dt>
          <dd itemprop="description">
            The practice of using <strong>schema markup</strong> as a control layer for AI systems, not just markup for search engines. <strong>Schema governance</strong> ensures that structured data serves as a constraint mechanism for <strong>AI agents</strong> and <strong>AI search systems</strong>, enabling reliable extraction, grounding, and citation without destabilizing production <abbr title="Search Engine Optimization">SEO</abbr>.
          </dd>
        </dl>
      </div>
    </section>

      <!-- Why Training Exists -->
    <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Why Training Exists</h2>
        </div>
        <div class="content-block__body">
        <p><strong>AI agents</strong> now touch:</p>
        <ul>
          <li><strong>Indexing behavior</strong></li>
          <li><strong>Canonical resolution</strong></li>
          <li><strong>Schema execution</strong></li>
          <li><strong>Internal linking logic</strong></li>
          <li><strong>AI search visibility</strong> (<strong>ChatGPT</strong>, <strong>Perplexity</strong>, <strong>Google AI Overviews</strong>)</li>
          </ul>
        <p>Without <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> literacy, teams accidentally:</p>
        <ul>
          <li>Override <strong>canonical law</strong></li>
          <li>Break <strong>entity resolution</strong></li>
          <li>Waste <strong>grounding budget</strong></li>
          <li>Introduce <strong>silent indexing failures</strong></li>
          <li>Poison <strong>AI retrieval</strong> with low-signal content</li>
          </ul>
          <p><strong>Training exists to prevent that.</strong></p>
      </div>
    </section>

      <!-- What This Training Covers -->
    <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Training Covers</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">Agent Operation & Supervision</h3>
          <p>Teams are trained to:</p>
          <ul>
          <li>Understand how <abbr title="Search Engine Optimization">SEO</abbr> <strong>agents</strong> reason and act</li>
          <li>Interpret <strong>agent decisions</strong> through <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> constraints</li>
          <li>Approve, block, or roll back <strong>agent actions</strong> safely</li>
          <li>Distinguish between <strong>advisory signals</strong> and <strong>executable actions</strong></li>
          <li>Avoid <strong>unbounded</strong> or <strong>heuristic-driven automation</strong></li>
          </ul>
        <p><strong>Agents</strong> are treated as <strong>search reliability systems</strong>, not content bots.</p>

          <h3 class="heading-3">AI Search Surfaces & Retrieval Mechanics</h3>
          <p><strong>We do not teach "writing for AI".</strong></p>
          <p><strong>We teach how AI search systems consume information.</strong></p>
        <p>Teams learn how systems like <strong>ChatGPT</strong>, <strong>Perplexity</strong>, and <strong>Google AI Overviews</strong>:</p>
          <ul>
          <li>Ingest <strong>structured</strong> and <strong>unstructured data</strong></li>
          <li>Allocate <strong>grounding budgets</strong></li>
            <li>Chunk, truncate, and prioritize content</li>
          <li>Resolve <strong>entities</strong> and <strong>citations</strong></li>
          <li>Select sources under <strong>uncertainty</strong></li>
          </ul>
        <p>This allows teams to design content and structure that is <strong>extractable</strong>, <strong>grounded</strong>, and <strong>stable</strong> across <strong>AI search surfaces</strong>.</p>

          <h3 class="heading-3">Content as Machine-Interpretable Information</h3>
          <p>Content teams are trained to produce:</p>
          <ul>
          <li><strong>High-signal</strong>, <strong>low-ambiguity</strong> information</li>
          <li>Content compatible with <strong>schema</strong> and <strong>entity models</strong></li>
          <li>Formats that survive <strong>summarization</strong> and <strong>citation</strong></li>
          <li>Information that <strong>agents</strong> and <strong>LLMs</strong> can reason about without <strong>hallucination</strong></li>
          </ul>
        <p>The goal is not volume or narrative polish. The goal is <strong>retrievability</strong> and <strong>correctness</strong>.</p>
      </div>
    </section>

      <!-- What We Teach / What We Don't -->
    <section class="content-block module" itemscope itemtype="https://schema.org/FAQPage">
        <div class="content-block__header">
          <h2 class="content-block__title">What We Teach / What We Don't</h2>
        </div>
        <div class="content-block__body">
          <div class="grid grid-auto-fit" style="gap: 2rem;">
            <div>
              <h3 class="heading-3">We Teach</h3>
              <ul>
              <li><dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> literacy and <strong>governance</strong></li>
              <li><strong>Agent supervision</strong> and <strong>safety boundaries</strong></li>
              <li><strong>Schema</strong> as a <strong>control layer</strong>, not markup</li>
              <li><strong>AI retrieval</strong> and <strong>grounding mechanics</strong></li>
              <li><strong>Content standards</strong> for <strong>AI extraction</strong></li>
              <li>How to read <strong>Search Console</strong> as <strong>telemetry</strong></li>
              <li>How to avoid <strong>AI-induced SEO regressions</strong></li>
              </ul>
            </div>
            <div>
              <h3 class="heading-3">We Do Not Teach</h3>
              <ul>
                <li>Prompt engineering for bloggers</li>
                <li>AI writing tricks</li>
                <li>Keyword hacks for LLMs</li>
                <li>"Rank in AI Overviews" shortcuts</li>
              <li>Generic <abbr title="Search Engine Optimization">SEO</abbr> fundamentals</li>
                <li>Content automation without constraints</li>
              </ul>
            </div>
          </div>
          <div class="callout-evidence" style="margin-top: 1.5rem; padding: 1rem; border-left: 4px solid #d4a574; background: #fff8f0;">
            <p><strong>If someone is looking for growth hacks or AI copywriting shortcuts, this training is not a fit.</strong></p>
          </div>
        </div>
    </section>

      <!-- Relationship to Neural Command OS -->
    <section class="content-block module">
        <div class="content-block__header">
        <h2 class="content-block__title">Relationship to <strong>Neural Command OS</strong></h2>
        </div>
        <div class="content-block__body">
          <p><strong>Training does not replace installation.</strong></p>
          <ul>
          <li><strong>Neural Command OS</strong> installs the <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn></li>
          <li><strong>Agents</strong> operate inside that protocol</li>
          <li>Training teaches humans how to <strong>supervise</strong>, <strong>interpret</strong>, and <strong>govern</strong> the system</li>
          </ul>
        <p>This training is designed for teams operating systems built on <a href="<?= absolute_url('/products/neural-command-os/') ?>"><strong>Neural Command OS</strong></a>. <strong>Neural Command OS</strong> installs the <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn> and <strong>agent execution layer</strong>. Training exists to ensure teams understand how that system behaves, how <strong>agents</strong> are constrained, and how to supervise <strong>AI-driven SEO</strong> safely over time.</p>
          <p>Teams leave with the ability to:</p>
          <ul>
          <li>Understand why <strong>agents</strong> act</li>
          <li>Prevent <strong>damaging changes</strong></li>
          <li>Scale <strong>AI SEO</strong> safely</li>
          <li>Maintain long-term <strong>index stability</strong></li>
          </ul>
          <div class="callout-system-truth" style="margin-top: 1.5rem; padding: 1rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
          <p><strong>Training assumes a production system.</strong> If <strong>Neural Command OS</strong> is not installed, this training focuses on preparing teams for <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn>-based search systems rather than replacing execution.</p>
        </div>
      </div>
    </section>

      <!-- Authority Statement -->
    <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Authority Statement</h2>
        </div>
        <div class="content-block__body">
        <p>Neural Command training is built for teams operating at the intersection of <strong>search infrastructure</strong>, <strong>AI agents</strong>, and <strong>large-scale content systems</strong>. We teach how to run <strong>AI-driven SEO</strong> as a <strong>governed system</strong>, not a collection of tools, ensuring <strong>Search Console</strong> stability, <strong>schema integrity</strong>, and reliable visibility across <strong>ChatGPT</strong>, <strong>Perplexity</strong>, and <strong>Google AI Overviews</strong>.</p>
      </div>
    </section>

      <!-- Who This Is For -->
    <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Who This Is For</h2>
        </div>
        <div class="content-block__body">
          <ul>
          <li><strong>Heads of SEO</strong></li>
          <li><strong>Technical SEOs</strong></li>
          <li><strong>Founders</strong> running production systems</li>
          <li><strong>Engineering teams</strong> interfacing with search</li>
          <li><strong>Content leads</strong> working inside <strong>AI-driven workflows</strong></li>
          </ul>
          <p><strong>If your site is already large, visible, or revenue-critical, this training is preventative infrastructure.</strong></p>
      </div>
    </section>

      <!-- Final Note -->
    <section class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Final Note</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-system-truth" style="padding: 1.5rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
            <p><strong>This training exists to reduce risk.</strong></p>
          <p><strong>AI search</strong> rewards systems that are <strong>structured</strong>, <strong>constrained</strong>, and <strong>interpretable</strong>. It punishes those that guess.</p>
            <p><strong>This page should make that unmistakably clear.</strong></p>
        </div>
      </div>
    </section>

      <!-- Training Formats -->
    <section class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-xl);">
        <div class="content-block__body">
        <h2 class="heading-2" style="margin-top: 0;">Training Formats</h2>
        <p>Operational training for teams supervising <strong>AI agents</strong> and <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn>-driven <abbr title="Search Engine Optimization">SEO</abbr> systems.</p>
        <div class="btn-group" style="margin-top: var(--spacing-md);">
          <a href="<?= absolute_url('/training/one-on-one/') ?>" class="btn btn--primary">One-on-One Operator Training</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary">Book Training Consultation</a>
          <a href="<?= absolute_url('/en-us/implementation/') ?>" class="btn btn--secondary">Implementation Support</a>
        </div>
        <p style="margin-top: var(--spacing-md); font-size: 0.9rem; color: #666;">Team & Group Sessions (coming soon)</p>
      </div>
    </section>

    </div>
</article>
  </section>
</main>
