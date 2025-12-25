<?php
declare(strict_types=1);
// Prechunking SEO Documentation Index
// Canonical documentation page defining the discipline

// Note: schema_builders.php is already included by router/head.php
// Only require if not already included
if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/docs/prechunking-seo/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Prechunking SEO</h1>
      </div>
      <div class="content-block__body">
        <p><a href="/docs/prechunking-seo/course/" class="link--primary">Prechunking SEO Operator Training</a> - Structured learning system for applying prechunking to real content systems.</p>
      </div>
    </div>

    <!-- What Is Prechunking SEO -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What Is Prechunking SEO</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking SEO is an engineering discipline for structuring content so that facts survive extraction and retrieval by AI systems.</p>
        <p>Traditional SEO assumes pages are ranked as documents. AI systems retrieve fragments. Prechunking ensures those fragments are accurate, complete, and citable.</p>
        <p>The name refers to shaping content into chunks before AI systems extract it. This happens at the publishing stage, not during retrieval.</p>
      </div>
    </div>

    <!-- What Problem It Solves -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What Problem It Solves</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems extract information from web content without preserving context.</p>
        <p>This causes three problems:</p>
        <ul>
          <li>Facts mutate when separated from surrounding text</li>
          <li>Competitors get cited instead when their chunks are clearer</li>
          <li>High-ranking pages are ignored because their chunks are ambiguous</li>
        </ul>
        <p>Prechunking solves these by engineering content at the chunk level, not the page level.</p>
      </div>
    </div>

    <!-- What It Replaces -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What It Replaces</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking SEO replaces content strategies that assume pages matter more than chunks.</p>
        <p>It replaces keyword optimization that treats pages as ranked documents.</p>
        <p>It replaces authority building that relies on link signals and page-level metrics.</p>
        <p>Prechunking operates at the retrieval layer, before ranking algorithms evaluate pages.</p>
      </div>
    </div>

    <!-- What It Does NOT Do -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What It Does Not Do</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking SEO does not replace technical SEO or structured data.</p>
        <p>It does not work through keyword density or content length.</p>
        <p>It does not require AI systems to access your site directly.</p>
        <p>It does not prevent competitors from being cited.</p>
        <p>It does not work if content quality is low or facts are incorrect.</p>
      </div>
    </div>

    <!-- What It Does Not Guarantee -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What It Does Not Guarantee</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking SEO does not guarantee rankings.</p>
        <p>It does not guarantee AI systems will cite your content.</p>
        <p>It does not guarantee increased traffic or conversions.</p>
        <p>It ensures facts are available for retrieval. It does not ensure retrieval occurs.</p>
      </div>
    </div>

    <!-- Related Documentation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Documentation</h2>
      </div>
      <div class="content-block__body">
        <p>For implementation details, see:</p>
        <ul>
          <li><a href="/docs/prechunking-seo/core-concepts/">Core Concepts</a> - Data shaping, croutons, precogs, chunk boundaries, retrieval vs ranking</li>
          <li><a href="/docs/prechunking-seo/croutons/">Crouton Specification</a> - Atomic fact structures that survive extraction</li>
          <li><a href="/docs/prechunking-seo/precogs/">Precog Modeling</a> - Intent forecasting and follow-up question mapping</li>
          <li><a href="/docs/prechunking-seo/workflow/">Prechunking Workflow</a> - Intent decomposition, crouton inventory, data shaping, publishing</li>
          <li><a href="/docs/prechunking-seo/failure-modes/">Failure Modes</a> - Why AI ignores content, why facts mutate, common anti-patterns</li>
          <li><a href="/docs/prechunking-seo/measurement/">Measurement & KPIs</a> - AI citation rates, answer inclusion, cross-engine consistency</li>
          <li><a href="/docs/prechunking-seo/doctrine/">NRLC Doctrine</a> - Core axioms: pages are containers, chunks are assets, truth must survive isolation</li>
          <li><a href="/docs/prechunking-seo/academic-signals/">Academic Signals</a> - Evidence-backed research alignment for extractability and citation</li>
        </ul>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>For training and implementation:</p>
        <ul>
          <li><a href="/docs/prechunking-seo/course/">Prechunking SEO Operator Training</a> - Structured learning system for applying prechunking</li>
        </ul>
      </div>
    </div>

    <!-- Core Axioms -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Axioms</h2>
      </div>
      <div class="content-block__body">
        <p>All prechunking work must align with these axioms:</p>
        <ol>
          <li>Pages are containers. Chunks are assets.</li>
          <li>AI retrieves fragments, not documents.</li>
          <li>If a fact cannot stand alone, it will not be cited.</li>
          <li>Prechunking happens before ranking.</li>
          <li>Truth must be engineered to survive extraction.</li>
        </ol>
        <p>Any practice that contradicts these axioms is not prechunking SEO.</p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema
// Note: Schema is added via $GLOBALS['__jsonld'] array, which is rendered in footer.php

if (!isset($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

// WebPage schema
require_once __DIR__.'/../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'url' => SchemaFixes::ensureHttps($canonicalUrl),
  'name' => 'Prechunking SEO Documentation',
  'description' => 'Prechunking SEO documentation. Engineering discipline for ensuring content survives AI extraction and retrieval.',
  'isPartOf' => [
    '@id' => SchemaFixes::ensureHttps(absolute_url('/docs/prechunking-seo/')) . '#collection'
  ],
  'breadcrumb' => [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => SchemaFixes::ensureHttps(absolute_url('/'))
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Documentation',
        'item' => SchemaFixes::ensureHttps(absolute_url('/docs/prechunking-seo/'))
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Prechunking SEO',
        'item' => SchemaFixes::ensureHttps($canonicalUrl)
      ]
    ]
  ]
];
?>

