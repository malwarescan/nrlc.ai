<?php
declare(strict_types=1);
// Prechunking SEO Core Concepts Documentation

require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/core-concepts/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Core Concepts</h1>
      </div>
    </div>

    <!-- Data Shaping -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Data Shaping</h2>
      </div>
      <div class="content-block__body">
        <p>Data shaping is the practice of structuring content so that facts remain accurate when extracted from context.</p>
        <p>Shaped content uses declarative statements instead of narrative flow.</p>
        <p>Each statement must be self-contained. It cannot depend on previous sentences for meaning.</p>
        <p>Shaping requires identifying what information is essential versus what is explanatory.</p>
        <p>Essential information becomes croutons. Explanatory information becomes supporting structure.</p>
      </div>
    </div>

    <!-- Croutons -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Croutons</h2>
      </div>
      <div class="content-block__body">
        <p>Croutons are atomic, retrievable fact structures.</p>
        <p>A crouton is a single sentence or statement that contains a complete fact.</p>
        <p>Croutons must be self-contained. They cannot require surrounding context to be understood.</p>
        <p>When AI systems extract a crouton, it must remain accurate without the rest of the page.</p>
        <p>Croutons are the unit of retrieval. AI systems cite croutons, not pages.</p>
        <p>See the <a href="/docs/prechunking-seo/croutons/">Crouton Specification</a> for detailed rules.</p>
      </div>
    </div>

    <!-- Precogs -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Precogs</h2>
      </div>
      <div class="content-block__body">
        <p>Precogs are predicted information needs that users will have.</p>
        <p>Prechunking requires anticipating what questions users will ask and what follow-up questions will emerge.</p>
        <p>Precog modeling identifies trust gaps where users need additional information to believe or act on a claim.</p>
        <p>Each precog maps to required croutons. Missing croutons cause AI systems to cite other sources or generate incomplete answers.</p>
        <p>Precogs are validated through query analysis and answer inspection.</p>
        <p>See <a href="/docs/prechunking-seo/precogs/">Precog Modeling</a> for implementation details.</p>
      </div>
    </div>

    <!-- Chunk Boundaries -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Chunk Boundaries</h2>
      </div>
      <div class="content-block__body">
        <p>Chunk boundaries define where one retrievable unit ends and another begins.</p>
        <p>AI systems extract content in chunks. These chunks are determined by token limits, semantic breaks, and structural markers.</p>
        <p>Prechunking engineers content so that chunk boundaries do not split related facts.</p>
        <p>Facts that must be retrieved together must exist within the same potential chunk.</p>
        <p>Boundaries are controlled through paragraph structure, list formatting, and section breaks.</p>
        <p>Poor boundary placement causes facts to be separated from necessary context, leading to mutation or omission.</p>
      </div>
    </div>

    <!-- Retrieval vs Ranking -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Retrieval vs Ranking</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking operates at the retrieval layer, not the ranking layer.</p>
        <p>Ranking algorithms determine which pages appear in search results. Retrieval algorithms determine which facts appear in AI-generated answers.</p>
        <p>A page can rank first but have zero facts retrieved if its chunks are ambiguous or incomplete.</p>
        <p>A page can rank tenth but have multiple facts retrieved if its chunks are clear and complete.</p>
        <p>Prechunking ensures facts are available for retrieval. It does not ensure pages rank higher.</p>
        <p>Retrieval happens before ranking in AI systems. Content must pass retrieval gates before ranking signals matter.</p>
        <p>This is why high-ranking pages are often ignored by AI systems. Their chunks fail retrieval tests.</p>
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
          <li><a href="/docs/prechunking-seo/croutons/">Crouton Specification</a></li>
          <li><a href="/docs/prechunking-seo/precogs/">Precog Modeling</a></li>
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
  'name' => 'Prechunking SEO: Core Concepts',
  'description' => 'Core concepts of prechunking SEO: data shaping, croutons, precogs, chunk boundaries, and retrieval vs ranking.',
  'isPartOf' => ['@id' => absolute_url('/docs/prechunking-seo/') . '#collection'],
  'breadcrumb' => breadcrumb_schema([
    ['name' => 'Home', 'url' => absolute_url('/')],
    ['name' => 'Documentation', 'url' => absolute_url('/docs/prechunking-seo/')],
    ['name' => 'Core Concepts', 'url' => $canonicalUrl]
  ])
]));
?>

