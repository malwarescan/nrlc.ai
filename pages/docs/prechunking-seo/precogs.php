<?php
declare(strict_types=1);
// Precog Modeling Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/precogs/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Precog Modeling</h1>
      </div>
    </div>

    <!-- Intent Forecasting -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Intent Forecasting</h2>
      </div>
      <div class="content-block__body">
        <p>Intent forecasting predicts what information users will need.</p>
        <p>Forecasting is based on query patterns, user behavior, and information gaps in existing answers.</p>
        <p>Each intent maps to required croutons. Missing croutons cause incomplete or incorrect AI answers.</p>
        <p>Forecasting requires analyzing what users ask, what they ask next, and what they need to believe before acting.</p>
        <p>Intent forecasting identifies not just primary queries but secondary and tertiary information needs.</p>
        <p>Forecasts are validated through search query data, AI answer inspection, and user feedback loops.</p>
      </div>
    </div>

    <!-- Follow-Up Question Mapping -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Follow-Up Question Mapping</h2>
      </div>
      <div class="content-block__body">
        <p>Follow-up questions are predictable information needs that emerge after initial queries.</p>
        <p>Mapping follow-up questions requires understanding information dependency chains.</p>
        <p>Example: A user asking "What is prechunking SEO?" will likely ask "How does prechunking work?" then "What are croutons?" then "How do I implement prechunking?"</p>
        <p>Each follow-up question requires specific croutons. Missing croutons cause AI systems to cite other sources or generate incomplete answers.</p>
        <p>Follow-up mapping is done through query analysis, conversation flow analysis, and answer gap identification.</p>
        <p>Croutons must be structured to answer both primary and follow-up questions without requiring users to read full pages.</p>
      </div>
    </div>

    <!-- Trust-Question Identification -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Trust-Question Identification</h2>
      </div>
      <div class="content-block__body">
        <p>Trust questions are information needs that users must satisfy before believing or acting on a claim.</p>
        <p>Trust gaps occur when claims are made without supporting evidence or context.</p>
        <p>Example: Claiming "NRLC.ai provides AI SEO services" requires trust questions: "What is AI SEO?" "Who is NRLC.ai?" "What results do they deliver?"</p>
        <p>Each trust question must be answered with specific croutons. Missing croutons cause skepticism or citation of alternative sources.</p>
        <p>Trust-question identification requires understanding what information is required to establish credibility for each claim.</p>
        <p>Trust questions vary by audience. Enterprise buyers need different trust signals than individual consumers.</p>
      </div>
    </div>

    <!-- Crouton Dependency Mapping -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Crouton Dependency Mapping</h2>
      </div>
      <div class="content-block__body">
        <p>Crouton dependency mapping identifies which croutons must be retrieved together.</p>
        <p>Some facts depend on other facts for accuracy or completeness.</p>
        <p>Dependencies are mapped to ensure related croutons exist within the same potential chunk boundaries.</p>
        <p>Example: A crouton stating "NRLC.ai operates remotely" may depend on croutons defining what NRLC.ai is and what services it provides.</p>
        <p>Dependency mapping prevents facts from being retrieved without necessary context, which causes mutation or misunderstanding.</p>
        <p>Dependencies are identified through fact analysis and retrieval testing.</p>
      </div>
    </div>

    <!-- Precog Validation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Precog Validation</h2>
      </div>
      <div class="content-block__body">
        <p>Precogs are validated through multiple methods:</p>
        <ul>
          <li>Query data analysis to confirm predicted information needs occur</li>
          <li>AI answer inspection to verify required croutons are present or missing</li>
          <li>User behavior tracking to identify information gaps</li>
          <li>Competitive analysis to see what croutons competitors provide</li>
          <li>Retrieval testing to confirm croutons are extractable and citable</li>
        </ul>
        <p>Invalidated precogs are removed or revised. New precogs are added based on emerging patterns.</p>
        <p>Validation is ongoing. Information needs evolve as markets and user understanding change.</p>
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
?>

<?php
// Note: JSON-LD schemas should be added to $GLOBALS['__jsonld'] array
// Footer is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
