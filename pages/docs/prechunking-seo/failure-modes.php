<?php
declare(strict_types=1);
// Failure Modes Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/failure-modes/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Failure Modes</h1>
      </div>
    </div>

    <!-- Why AI Ignores Content -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why AI Ignores Content</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems ignore content when chunks fail retrieval tests.</p>
        <p>Common failure causes:</p>
        <ul>
          <li>Ambiguous statements that require context to understand</li>
          <li>Pronouns without clear antecedents</li>
          <li>Compound facts that cannot be split accurately</li>
          <li>Vague qualifiers that reduce fact confidence</li>
          <li>Narrative flow that obscures facts</li>
          <li>Missing entity names or explicit relationships</li>
        </ul>
        <p>AI systems skip chunks that fail confidence thresholds. High-ranking pages are ignored if their chunks are ambiguous.</p>
        <p>Content is ignored when it cannot be extracted as standalone facts. Narrative content fails extraction more often than declarative content.</p>
      </div>
    </div>

    <!-- Why Facts Mutate -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Facts Mutate</h2>
      </div>
      <div class="content-block__body">
        <p>Facts mutate when extracted without necessary context.</p>
        <p>Mutation occurs when:</p>
        <ul>
          <li>Chunk boundaries split related facts</li>
          <li>Facts depend on surrounding explanation</li>
          <li>Claims require supporting evidence that is not included</li>
          <li>Contextual qualifiers are removed during extraction</li>
          <li>Entity relationships are implied rather than explicit</li>
        </ul>
        <p>Mutated facts appear in AI answers but are inaccurate or incomplete. This damages credibility and causes misinformation.</p>
        <p>Mutation is prevented by ensuring facts are self-contained and explicitly stated, not inferred or implied.</p>
      </div>
    </div>

    <!-- Why Competitors Get Cited Instead -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Competitors Get Cited Instead</h2>
      </div>
      <div class="content-block__body">
        <p>Competitors get cited when their chunks pass retrieval tests while yours fail.</p>
        <p>This happens when:</p>
        <ul>
          <li>Competitors have clearer, more explicit croutons</li>
          <li>Competitors answer questions your content does not address</li>
          <li>Competitors use declarative statements instead of narrative</li>
          <li>Competitors structure facts more explicitly</li>
          <li>Competitors provide required trust signals that you omit</li>
        </ul>
        <p>Ranking does not protect against competitor citation. AI systems retrieve from any source that passes retrieval tests.</p>
        <p>Preventing competitor citation requires matching or exceeding their crouton quality and completeness.</p>
      </div>
    </div>

    <!-- Common Anti-Patterns -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Common Anti-Patterns</h2>
      </div>
      <div class="content-block__body">
        <p>Anti-patterns are practices that cause prechunking failures:</p>
        <ul>
          <li>Writing narrative content and expecting AI to extract facts</li>
          <li>Using pronouns without explicit antecedents</li>
          <li>Burying facts in long paragraphs</li>
          <li>Assuming context will be preserved during extraction</li>
          <li>Focusing on page rankings instead of chunk retrieval</li>
          <li>Writing for humans first and machines second</li>
          <li>Using vague language to sound authoritative</li>
          <li>Separating related facts across sections</li>
          <li>Relying on formatting or design to convey meaning</li>
          <li>Assuming high rankings guarantee AI citation</li>
        </ul>
        <p>Each anti-pattern causes specific failure modes. Avoiding anti-patterns requires understanding why they fail.</p>
      </div>
    </div>

    <!-- Failure Prevention -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Failure Prevention</h2>
      </div>
      <div class="content-block__body">
        <p>Failures are prevented through compliance with prechunking principles:</p>
        <ul>
          <li>Write declarative croutons, not narrative content</li>
          <li>Use explicit entity names, not pronouns</li>
          <li>Keep related facts within chunk boundaries</li>
          <li>Validate facts are self-contained</li>
          <li>Test retrieval through answer inspection</li>
          <li>Audit content for crouton compliance</li>
          <li>Map intents to required croutons</li>
          <li>Structure content for extraction, not reading</li>
        </ul>
        <p>Prevention requires discipline and validation. Assumptions about retrieval must be tested, not assumed.</p>
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
          <li><a href="/docs/prechunking-seo/croutons/">Crouton Specification</a></li>
          <li><a href="/docs/prechunking-seo/workflow/">Prechunking Workflow</a></li>
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
  'name' => 'Failure Modes',
  'description' => 'Prechunking SEO failure modes. Why AI ignores content, why facts mutate, and why competitors get cited instead.',
  'isPartOf' => ['@id' => absolute_url('/docs/prechunking-seo/') . '#collection'],
  'breadcrumb' => breadcrumb_schema([
    ['name' => 'Home', 'url' => absolute_url('/')],
    ['name' => 'Documentation', 'url' => absolute_url('/docs/prechunking-seo/')],
    ['name' => 'Failure Modes', 'url' => $canonicalUrl]
  ])
]));
?>

