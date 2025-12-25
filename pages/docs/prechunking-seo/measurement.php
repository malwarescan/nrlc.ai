<?php
declare(strict_types=1);
// Measurement & KPIs Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/measurement/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Measurement & KPIs</h1>
      </div>
    </div>

    <!-- AI Citation Rate -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI Citation Rate</h2>
      </div>
      <div class="content-block__body">
        <p>AI citation rate measures how often your croutons appear in AI-generated answers with attribution.</p>
        <p>Citation rate is calculated by tracking mentions of your domain or brand in AI responses.</p>
        <p>High citation rates indicate successful prechunking. Low citation rates indicate retrieval failures.</p>
        <p>Citation tracking requires monitoring multiple AI systems: Google AI Overviews, ChatGPT, Perplexity, Claude, and others.</p>
        <p>Citation rate trends show whether prechunking improvements are effective over time.</p>
        <p>Citation rate does not measure page rankings. It measures chunk retrieval success.</p>
      </div>
    </div>

    <!-- Answer Inclusion -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Answer Inclusion</h2>
      </div>
      <div class="content-block__body">
        <p>Answer inclusion measures whether your facts appear in AI answers, with or without citation.</p>
        <p>Inclusion is broader than citation. Facts may be included without attribution.</p>
        <p>Measuring inclusion requires comparing AI answers to your croutons and identifying matches.</p>
        <p>High inclusion rates indicate successful retrieval even when attribution is missing.</p>
        <p>Inclusion tracking validates that croutons are being extracted and used, not just that citations appear.</p>
        <p>Inclusion trends show retrieval performance across different AI systems and query types.</p>
      </div>
    </div>

    <!-- Cross-Engine Consistency -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Cross-Engine Consistency</h2>
      </div>
      <div class="content-block__body">
        <p>Cross-engine consistency measures whether your facts appear across multiple AI systems.</p>
        <p>Consistent retrieval across engines indicates robust prechunking. Inconsistent retrieval indicates system-specific failures.</p>
        <p>Consistency is measured by comparing citation and inclusion rates across Google AI Overviews, ChatGPT, Perplexity, Claude, and other systems.</p>
        <p>Low consistency indicates that prechunking may be optimized for one system but not others.</p>
        <p>High consistency indicates that croutons are structured correctly for general retrieval, not specific system optimization.</p>
        <p>Consistency tracking identifies which engines retrieve your content and which ignore it.</p>
      </div>
    </div>

    <!-- Zero-Click Dominance -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Zero-Click Dominance</h2>
      </div>
      <div class="content-block__body">
        <p>Zero-click dominance measures how often your facts appear in AI answers that satisfy user queries without requiring clicks.</p>
        <p>AI systems increasingly provide direct answers. Zero-click dominance measures your share of those answers.</p>
        <p>High zero-click dominance indicates that your croutons are primary information sources for AI systems.</p>
        <p>Measuring zero-click dominance requires tracking AI answer content and identifying which sources provide the facts used.</p>
        <p>Zero-click dominance trends show whether prechunking is achieving information authority, not just visibility.</p>
        <p>Zero-click dominance does not require page clicks. It measures retrieval and citation success.</p>
      </div>
    </div>

    <!-- Measurement Methods -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Measurement Methods</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking measurement requires multiple methods:</p>
        <ul>
          <li>Automated citation tracking across AI systems</li>
          <li>Answer inspection and fact matching</li>
          <li>Query analysis to identify information needs</li>
          <li>Retrieval testing to validate crouton extractability</li>
          <li>Competitive comparison to benchmark performance</li>
          <li>Trend analysis to track improvements over time</li>
        </ul>
        <p>Measurement is ongoing. AI systems evolve, requiring continuous monitoring and adjustment.</p>
        <p>Measurement data informs precog modeling and crouton inventory decisions.</p>
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
          <li><a href="/docs/prechunking-seo/failure-modes/">Failure Modes</a></li>
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
  'name' => 'Measurement & KPIs',
  'description' => 'Prechunking SEO measurement and KPIs. AI citation rates, answer inclusion, cross-engine consistency, and zero-click dominance.',
  'isPartOf' => ['@id' => absolute_url('/docs/prechunking-seo/') . '#collection'],
  'breadcrumb' => breadcrumb_schema([
    ['name' => 'Home', 'url' => absolute_url('/')],
    ['name' => 'Documentation', 'url' => absolute_url('/docs/prechunking-seo/')],
    ['name' => 'Measurement', 'url' => $canonicalUrl]
  ])
]));
?>

