<?php
declare(strict_types=1);
// Prechunking Workflow Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/workflow/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Prechunking Workflow</h1>
      </div>
    </div>

    <!-- Intent Decomposition -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Intent Decomposition</h2>
      </div>
      <div class="content-block__body">
        <p>Intent decomposition breaks user information needs into discrete questions.</p>
        <p>Start with primary queries. Identify what users are asking and why they are asking it.</p>
        <p>Decompose primary queries into follow-up questions. What information will users need next?</p>
        <p>Identify trust gaps. What information is required for users to believe claims?</p>
        <p>Map each decomposed intent to required information. This becomes the crouton inventory.</p>
        <p>Decomposition is validated through query data, answer inspection, and user research.</p>
      </div>
    </div>

    <!-- Crouton Inventory -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Crouton Inventory</h2>
      </div>
      <div class="content-block__body">
        <p>Crouton inventory is the list of atomic facts required to answer decomposed intents.</p>
        <p>Each intent maps to specific croutons. Missing croutons cause incomplete or incorrect answers.</p>
        <p>Inventory is created by mapping decomposed intents to required facts.</p>
        <p>Each crouton must meet the crouton specification: atomic, self-contained, explicit.</p>
        <p>Inventory is organized by intent and dependency. Related croutons are grouped for chunk boundary planning.</p>
        <p>Inventory gaps are identified by comparing required croutons to existing content.</p>
      </div>
    </div>

    <!-- Data Shaping -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Data Shaping</h2>
      </div>
      <div class="content-block__body">
        <p>Data shaping transforms narrative content into declarative croutons.</p>
        <p>Existing content is audited for crouton compliance. Non-compliant statements are identified and refactored.</p>
        <p>New content is written as croutons from the start, not as narrative later shaped.</p>
        <p>Shaping requires removing narrative connectors, replacing pronouns with explicit nouns, and splitting compound facts.</p>
        <p>Shaped content uses declarative statements. Each statement is a complete, standalone fact.</p>
        <p>Shaping is validated through crouton specification compliance checks.</p>
      </div>
    </div>

    <!-- Structured Publishing -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Structured Publishing</h2>
      </div>
      <div class="content-block__body">
        <p>Structured publishing organizes croutons into pages while preserving chunk boundaries.</p>
        <p>Related croutons are grouped within potential chunk boundaries. Dependencies are kept together.</p>
        <p>Chunk boundaries are controlled through paragraph structure, list formatting, and section breaks.</p>
        <p>Structured data reinforces croutons where possible. Schema markup provides additional retrieval signals.</p>
        <p>Publishing validates that croutons can be extracted accurately without surrounding context.</p>
        <p>Structured publishing ensures pages function as containers while chunks function as retrievable assets.</p>
      </div>
    </div>

    <!-- Retrieval Validation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Retrieval Validation</h2>
      </div>
      <div class="content-block__body">
        <p>Retrieval validation tests whether croutons are actually retrieved by AI systems.</p>
        <p>Validation methods include:</p>
        <ul>
          <li>AI answer inspection to confirm croutons appear in generated responses</li>
          <li>Citation tracking to verify croutons are attributed correctly</li>
          <li>Extraction testing to ensure facts remain accurate when isolated</li>
          <li>Chunk boundary testing to confirm related facts are retrieved together</li>
          <li>Competitive comparison to identify missing or inferior croutons</li>
        </ul>
        <p>Failed validation requires revision of croutons, chunk boundaries, or data shaping.</p>
        <p>Validation is ongoing. AI systems evolve, requiring continuous monitoring and adjustment.</p>
      </div>
    </div>

    <!-- Workflow Iteration -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Workflow Iteration</h2>
      </div>
      <div class="content-block__body">
        <p>The prechunking workflow is iterative, not linear.</p>
        <p>Intent decomposition reveals new information needs. Precog modeling identifies gaps. Crouton inventory expands.</p>
        <p>Retrieval validation reveals failures. Failed retrievals require returning to data shaping or intent decomposition.</p>
        <p>Content audits discover non-compliant statements. These require refactoring back through data shaping.</p>
        <p>Iteration continues until validation passes and retrieval goals are met.</p>
        <p>Workflow documentation captures patterns and decisions for consistency across content systems.</p>
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
          <li><a href="/docs/prechunking-seo/precogs/">Precog Modeling</a></li>
          <li><a href="/docs/prechunking-seo/course/">Operator Training Course</a></li>
        </ul>
      </div>
    </div>

  </div>
</section>
</main>

<?php
?>

<?php
// Note: JSON-LD schemas should be added to $GLOBALS['__jsonld'] array
// Footer is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
