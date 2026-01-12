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
  'title' => 'Operating AI Search Systems Safely, At Scale | Neural Command Training',
  'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems. Focused on agent supervision, schema governance, Google Search Console telemetry, and content designed for reliable extraction by AI search surfaces.',
  'canonicalPath' => '/training/'
];

// Build JSON-LD Schema (WebPage + Service, NOT Course/EducationalOccupationalProgram)
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';

$GLOBALS['__jsonld'] = [
  // Organization schema (GBP-aligned)
  ld_organization(),
  
  // BreadcrumbList
  ld_breadcrumbs(),
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'AI Search & Agent Governance Training',
    'url' => $canonicalUrl,
    'description' => 'Specialized training for teams operating AI agents, Model Context Protocols (MCPs), and AI search systems. Focused on agent supervision, schema governance, Google Search Console telemetry, and content designed for reliable extraction by AI search surfaces.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '/#website',
      'name' => gbp_business_name(),
      'url' => $domain
    ],
    'about' => [
      '@type' => 'Service',
      'name' => 'AI Search & Agent Governance Training',
      'serviceType' => 'Technical SEO and AI Search Governance Training',
      'provider' => [
        '@type' => 'Organization',
        '@id' => $orgId
      ],
      'description' => 'Training for teams supervising AI agents and MCP-driven SEO systems, covering agent safety, schema as governance, Google Search Console telemetry interpretation, and content standards for AI search systems such as ChatGPT, Perplexity, and Google AI Overviews.'
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- ABOVE THE FOLD: Operational Training Positioning -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">Operating AI Search Systems Safely, At Scale</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">This training exists because Neural Command OS is not a tool and agent-driven SEO is not something teams should improvise.</p>
          <div class="callout-system-truth" style="margin: 1.5rem 0; padding: 1rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
            <p><strong>This is not education for beginners.</strong></p>
            <p><strong>This is operational training for teams running real systems.</strong></p>
          </div>
          <p>We train teams to understand, supervise, and govern AI agents operating inside a Model Context Protocol (MCP), and to produce content that AI search systems can reliably extract, ground, and cite without destabilizing production SEO.</p>
        </div>
      </div>

      <!-- Why Training Exists -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Why Training Exists</h2>
        </div>
        <div class="content-block__body">
          <p>AI agents now touch:</p>
          <ul>
            <li>Indexing behavior</li>
            <li>Canonical resolution</li>
            <li>Schema execution</li>
            <li>Internal linking logic</li>
            <li>AI search visibility (ChatGPT, Perplexity, Google AI Overviews)</li>
          </ul>
          <p>Without protocol literacy, teams accidentally:</p>
          <ul>
            <li>Override canonical law</li>
            <li>Break entity resolution</li>
            <li>Waste grounding budget</li>
            <li>Introduce silent indexing failures</li>
            <li>Poison AI retrieval with low-signal content</li>
          </ul>
          <p><strong>Training exists to prevent that.</strong></p>
        </div>
      </div>

      <!-- What This Training Covers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Training Covers</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">Agent Operation & Supervision</h3>
          <p>Teams are trained to:</p>
          <ul>
            <li>Understand how SEO agents reason and act</li>
            <li>Interpret agent decisions through MCP constraints</li>
            <li>Approve, block, or roll back agent actions safely</li>
            <li>Distinguish between advisory signals and executable actions</li>
            <li>Avoid unbounded or heuristic-driven automation</li>
          </ul>
          <p>Agents are treated as search reliability systems, not content bots.</p>

          <h3 class="heading-3">AI Search Surfaces & Retrieval Mechanics</h3>
          <p><strong>We do not teach "writing for AI".</strong></p>
          <p><strong>We teach how AI search systems consume information.</strong></p>
          <p>Teams learn how systems like ChatGPT, Perplexity, and Google AI Overviews:</p>
          <ul>
            <li>Ingest structured and unstructured data</li>
            <li>Allocate grounding budgets</li>
            <li>Chunk, truncate, and prioritize content</li>
            <li>Resolve entities and citations</li>
            <li>Select sources under uncertainty</li>
          </ul>
          <p>This allows teams to design content and structure that is extractable, grounded, and stable across AI search surfaces.</p>

          <h3 class="heading-3">Content as Machine-Interpretable Information</h3>
          <p>Content teams are trained to produce:</p>
          <ul>
            <li>High-signal, low-ambiguity information</li>
            <li>Content compatible with schema and entity models</li>
            <li>Formats that survive summarization and citation</li>
            <li>Information that agents and LLMs can reason about without hallucination</li>
          </ul>
          <p>The goal is not volume or narrative polish. The goal is retrievability and correctness.</p>
        </div>
      </div>

      <!-- What We Teach / What We Don't -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What We Teach / What We Don't</h2>
        </div>
        <div class="content-block__body">
          <div class="grid grid-auto-fit" style="gap: 2rem;">
            <div>
              <h3 class="heading-3">We Teach</h3>
              <ul>
                <li>MCP literacy and governance</li>
                <li>Agent supervision and safety boundaries</li>
                <li>Schema as a control layer, not markup</li>
                <li>AI retrieval and grounding mechanics</li>
                <li>Content standards for AI extraction</li>
                <li>How to read Search Console as telemetry</li>
                <li>How to avoid AI-induced SEO regressions</li>
              </ul>
            </div>
            <div>
              <h3 class="heading-3">We Do Not Teach</h3>
              <ul>
                <li>Prompt engineering for bloggers</li>
                <li>AI writing tricks</li>
                <li>Keyword hacks for LLMs</li>
                <li>"Rank in AI Overviews" shortcuts</li>
                <li>Generic SEO fundamentals</li>
                <li>Content automation without constraints</li>
              </ul>
            </div>
          </div>
          <div class="callout-evidence" style="margin-top: 1.5rem; padding: 1rem; border-left: 4px solid #d4a574; background: #fff8f0;">
            <p><strong>If someone is looking for growth hacks or AI copywriting shortcuts, this training is not a fit.</strong></p>
          </div>
        </div>
      </div>

      <!-- Relationship to Neural Command OS -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Relationship to Neural Command OS</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Training does not replace installation.</strong></p>
          <ul>
            <li>Neural Command OS installs the MCP</li>
            <li>Agents operate inside that protocol</li>
            <li>Training teaches humans how to supervise, interpret, and govern the system</li>
          </ul>
          <p>This training is designed for teams operating systems built on <a href="<?= absolute_url('/products/neural-command-os/') ?>">Neural Command OS</a>. Neural Command OS installs the Model Context Protocol and agent execution layer. Training exists to ensure teams understand how that system behaves, how agents are constrained, and how to supervise AI-driven SEO safely over time.</p>
          <p>Teams leave with the ability to:</p>
          <ul>
            <li>Understand why agents act</li>
            <li>Prevent damaging changes</li>
            <li>Scale AI SEO safely</li>
            <li>Maintain long-term index stability</li>
          </ul>
          <div class="callout-system-truth" style="margin-top: 1.5rem; padding: 1rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
            <p><strong>Training assumes a production system.</strong> If Neural Command OS is not installed, this training focuses on preparing teams for MCP-based search systems rather than replacing execution.</p>
          </div>
        </div>
      </div>

      <!-- Authority Statement -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Authority Statement</h2>
        </div>
        <div class="content-block__body">
          <p>Neural Command training is built for teams operating at the intersection of search infrastructure, AI agents, and large-scale content systems. We teach how to run AI-driven SEO as a governed system, not a collection of tools, ensuring Search Console stability, schema integrity, and reliable visibility across ChatGPT, Perplexity, and Google AI Overviews.</p>
        </div>
      </div>

      <!-- Who This Is For -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Who This Is For</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>Heads of SEO</li>
            <li>Technical SEOs</li>
            <li>Founders running production systems</li>
            <li>Engineering teams interfacing with search</li>
            <li>Content leads working inside AI-driven workflows</li>
          </ul>
          <p><strong>If your site is already large, visible, or revenue-critical, this training is preventative infrastructure.</strong></p>
        </div>
      </div>

      <!-- Final Note -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Final Note</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-system-truth" style="padding: 1.5rem; border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5);">
            <p><strong>This training exists to reduce risk.</strong></p>
            <p>AI search rewards systems that are structured, constrained, and interpretable. It punishes those that guess.</p>
            <p><strong>This page should make that unmistakably clear.</strong></p>
          </div>
        </div>
      </div>

      <!-- Training Formats -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Training Formats</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/training/one-on-one/') ?>">One-on-One Operator Training</a></li>
            <li>Team & Group Sessions (coming soon)</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>
