<?php
declare(strict_types=1);
// NRLC Doctrine Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/doctrine/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">NRLC Doctrine</h1>
      </div>
    </div>

    <!-- Pages Are Containers -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Pages Are Containers</h2>
      </div>
      <div class="content-block__body">
        <p>Pages are organizational containers for chunks. They do not exist as retrievable units in AI systems.</p>
        <p>AI systems extract chunks from pages. Pages function as delivery mechanisms, not retrieval targets.</p>
        <p>Page structure exists to organize chunks and control chunk boundaries, not to rank as documents.</p>
        <p>Page-level metrics like rankings and traffic are outputs of container performance, not chunk performance.</p>
        <p>Optimizing pages as containers requires understanding how chunk boundaries affect retrieval.</p>
        <p>This doctrine contradicts traditional SEO that treats pages as ranked documents. Prechunking operates at the chunk level.</p>
      </div>
    </div>

    <!-- Chunks Are Assets -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Chunks Are Assets</h2>
      </div>
      <div class="content-block__body">
        <p>Chunks are the actual assets that AI systems retrieve and cite. They are the units of value in AI search.</p>
        <p>Chunk quality determines retrieval success. Poor chunks are ignored. Good chunks are cited.</p>
        <p>Chunks must be engineered as standalone assets. They cannot depend on page context for accuracy.</p>
        <p>Chunk inventory is the asset portfolio. Missing chunks cause incomplete answers and competitor citation.</p>
        <p>Chunk performance is measured through citation rates and answer inclusion, not page rankings.</p>
        <p>This doctrine requires treating chunks as first-class assets, not as page components.</p>
      </div>
    </div>

    <!-- Retrieval Precedes Ranking -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Retrieval Precedes Ranking</h2>
      </div>
      <div class="content-block__body">
        <p>Retrieval algorithms determine which chunks are available for AI answers. Ranking algorithms determine which pages appear in search results.</p>
        <p>Retrieval happens before ranking in AI systems. Chunks must pass retrieval tests before ranking signals matter.</p>
        <p>A page can rank first but have zero chunks retrieved if its chunks fail retrieval tests.</p>
        <p>A page can rank tenth but have multiple chunks retrieved if its chunks pass retrieval tests.</p>
        <p>Prechunking optimizes for retrieval, not ranking. Ranking optimization is separate and secondary.</p>
        <p>This doctrine explains why high-ranking pages are often ignored by AI systems. They fail at retrieval, not ranking.</p>
      </div>
    </div>

    <!-- Truth Must Survive Isolation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Truth Must Survive Isolation</h2>
      </div>
      <div class="content-block__body">
        <p>Facts must remain accurate when extracted from context. Truth cannot depend on surrounding text for correctness.</p>
        <p>Isolation testing validates that facts are self-contained. Facts that mutate when isolated are not true croutons.</p>
        <p>Truth engineering requires explicit statements, not implied meanings. Implied truth does not survive extraction.</p>
        <p>Facts must be stated clearly enough to be understood without explanation. Context-dependent truth is not retrievable truth.</p>
        <p>This doctrine requires discipline in content creation. Narrative truth must be transformed into declarative truth.</p>
        <p>Truth that survives isolation is truth that can be trusted when cited by AI systems.</p>
      </div>
    </div>

    <!-- Doctrine Enforcement -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Doctrine Enforcement</h2>
      </div>
      <div class="content-block__body">
        <p>These doctrines are non-negotiable. Practices that contradict them are not prechunking SEO.</p>
        <p>Doctrine enforcement requires:</p>
        <ul>
          <li>Auditing content for compliance with container and asset separation</li>
          <li>Validating that chunks can survive isolation</li>
          <li>Measuring retrieval performance, not just ranking performance</li>
          <li>Rejecting practices that optimize pages at the expense of chunks</li>
          <li>Prioritizing chunk quality over page metrics</li>
        </ul>
        <p>Doctrine violations cause prechunking failures. Compliance ensures retrieval success.</p>
        <p>All prechunking work must align with these doctrines. No exceptions.</p>
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
  'name' => 'NRLC Doctrine',
  'description' => 'NRLC doctrine for prechunking SEO. Pages are containers, chunks are assets, retrieval precedes ranking, truth must survive isolation.',
  'isPartOf' => ['@id' => absolute_url('/docs/prechunking-seo/') . '#collection'],
  'breadcrumb' => breadcrumb_schema([
    ['name' => 'Home', 'url' => absolute_url('/')],
    ['name' => 'Documentation', 'url' => absolute_url('/docs/prechunking-seo/')],
    ['name' => 'Doctrine', 'url' => $canonicalUrl]
  ])
]));
?>

