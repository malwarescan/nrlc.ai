<?php
declare(strict_types=1);
// Crouton Specification Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/croutons/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Crouton Specification</h1>
      </div>
    </div>

    <!-- What Qualifies as a Crouton -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What Qualifies as a Crouton</h2>
      </div>
      <div class="content-block__body">
        <p>A crouton is a single, atomic fact statement that remains accurate when extracted from context.</p>
        <p>To qualify as a crouton, a statement must:</p>
        <ul>
          <li>Contain a complete, verifiable fact</li>
          <li>Be self-contained and require no surrounding context</li>
          <li>Use explicit entity names, not pronouns or references</li>
          <li>State relationships clearly without inference</li>
          <li>Be structured for retrieval, not narrative flow</li>
        </ul>
        <p>If a statement fails any of these criteria, it is not a valid crouton.</p>
      </div>
    </div>

    <!-- Allowed Sentence Structures -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Allowed Sentence Structures</h2>
      </div>
      <div class="content-block__body">
        <p>Croutons use declarative statements. The following structures are allowed:</p>
        <ul>
          <li>Subject verb object. Example: "NRLC.ai provides AI SEO services."</li>
          <li>Subject is object. Example: "Prechunking SEO is an engineering discipline."</li>
          <li>Subject has attribute. Example: "The service includes audit and diagnostic phases."</li>
          <li>Subject performs action at location. Example: "NRLC operates remotely across global markets."</li>
          <li>Subject provides service for audience. Example: "We serve enterprise clients requiring AI visibility."</li>
        </ul>
        <p>All structures must use explicit nouns. No pronouns. No implied subjects.</p>
      </div>
    </div>

    <!-- Disallowed Patterns -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Disallowed Patterns</h2>
      </div>
      <div class="content-block__body">
        <p>The following patterns are disallowed in croutons:</p>
        <ul>
          <li>Pronouns without clear antecedents. Example: "We provide services." Use: "NRLC.ai provides AI SEO services."</li>
          <li>References to previous sentences. Example: "This approach works." Use: "Prechunking SEO works by shaping content into atomic facts."</li>
          <li>Conditional statements without context. Example: "If needed, contact us." Use: "Contact NRLC.ai for AI SEO consultation."</li>
          <li>Comparative statements without comparison target. Example: "We are better." Use: "NRLC.ai provides more precise AI visibility diagnosis than checklist audits."</li>
          <li>Vague qualifiers. Example: "Many clients succeed." Use: "Enterprise clients using prechunking SEO achieve consistent AI citation rates."</li>
          <li>Narrative connectors. Example: "Therefore, we recommend." Use: "NRLC.ai recommends prechunking SEO for enterprise content systems."</li>
        </ul>
        <p>Each disallowed pattern causes facts to mutate or become ambiguous when extracted.</p>
      </div>
    </div>

    <!-- Atomicity Rules -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Atomicity Rules</h2>
      </div>
      <div class="content-block__body">
        <p>Atomicity means a crouton contains exactly one fact.</p>
        <p>A single sentence can contain multiple facts. These must be split into separate croutons.</p>
        <p>Example of non-atomic crouton: "NRLC.ai provides AI SEO services and operates remotely."</p>
        <p>Correct atomic croutons: "NRLC.ai provides AI SEO services." and "NRLC.ai operates remotely."</p>
        <p>Atomicity ensures each fact can be retrieved independently without carrying unnecessary information.</p>
        <p>Compound facts are split by logical operators: and, or, but, as well as, in addition to.</p>
        <p>Facts that are inseparable are exceptions. Example: "NRLC.ai operates in the United States and United Kingdom." This is atomic because the locations are a single fact about scope.</p>
      </div>
    </div>

    <!-- Versioning Rules -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Versioning Rules</h2>
      </div>
      <div class="content-block__body">
        <p>Croutons must be versioned when facts change.</p>
        <p>When a fact is updated, the old crouton is deprecated and a new crouton is published.</p>
        <p>Versioning prevents AI systems from retrieving outdated facts.</p>
        <p>Deprecated croutons are removed from published content but may exist in training data.</p>
        <p>Versioning is tracked through structured data when possible. Otherwise, through content audit cycles.</p>
        <p>Time-sensitive facts must include temporal context. Example: "As of 2024, NRLC.ai serves enterprise clients."</p>
        <p>Versioning applies to entity facts, service descriptions, and claims about capabilities or outcomes.</p>
      </div>
    </div>

    <!-- Crouton Examples -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Crouton Examples</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Valid crouton:</strong> "NRLC.ai provides site audit services for AI and search visibility."</p>
        <p>This is atomic, explicit, and self-contained.</p>
        <p><strong>Invalid crouton:</strong> "We provide these services."</p>
        <p>This uses a pronoun and requires context to identify the subject.</p>
        <p><strong>Valid crouton:</strong> "Site audits explain why visibility breaks down, not just surface-level issues."</p>
        <p>This is a complete, standalone fact about what the service does.</p>
        <p><strong>Invalid crouton:</strong> "This approach is better."</p>
        <p>This requires context to identify what approach is being referenced and what it is better than.</p>
      </div>
    </div>

    <!-- Related Documentation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Documentation</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><a href="/docs/prechunking-seo/">Prechunking SEO Overview</a></li>
          <li><a href="/docs/prechunking-seo/core-concepts/">Core Concepts</a></li>
          <li><a href="/docs/prechunking-seo/workflow/">Prechunking Workflow</a></li>
          <li><a href="/docs/prechunking-seo/course/">Operator Training Course</a></li>
        </ul>
      </div>
    </div>

  </div>
</section>
</main>

<?php
add_jsonld(webpage_schema([
  '@id' => $canonicalUrl . '#webpage',
  'url' => $canonicalUrl,
  'name' => 'Crouton Specification',
  'description' => 'Crouton specification for prechunking SEO. Atomic, retrievable fact structures that survive AI extraction.',
  'isPartOf' => ['@id' => absolute_url('/docs/prechunking-seo/') . '#collection'],
  'breadcrumb' => breadcrumb_schema([
    ['name' => 'Home', 'url' => absolute_url('/')],
    ['name' => 'Documentation', 'url' => absolute_url('/docs/prechunking-seo/')],
    ['name' => 'Croutons', 'url' => $canonicalUrl]
  ])
]));
?>

