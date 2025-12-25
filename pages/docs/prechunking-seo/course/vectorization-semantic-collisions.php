<?php
declare(strict_types=1);
// Module 3: Vectorization and Semantic Collisions

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/vectorization-semantic-collisions/');
$moduleNum = 3;
$moduleTitle = 'Vectorization and Semantic Collisions';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/chunk-atomicity-inference-cost/">← Previous: Module 2</a></p>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Module <?= $moduleNum ?>: <?= htmlspecialchars($moduleTitle) ?></h1>
        <p style="font-size: 0.875rem; color: #666; margin-top: 0.5rem;">Module <?= $moduleNum ?> of 9</p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Teaches</h2>
      </div>
      <div class="content-block__body">
        <p>Why vague chunks lose embedding battles.</p>
        <p>Embeddings collapse meaning into dense vectors. If a chunk contains multiple ideas, mixed intent, or generic language, its vector becomes non-dominant.</p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Embedding Reality</h2>
      </div>
      <div class="content-block__body">
        <p>Embeddings collapse meaning into dense vectors.</p>
        <p><strong>If a chunk contains:</strong></p>
        <ul>
          <li>multiple ideas</li>
          <li>mixed intent</li>
          <li>generic language</li>
        </ul>
        <p><strong>Its vector becomes non-dominant.</strong></p>
        <p><strong>Result:</strong> Your content exists but never wins nearest-neighbor retrieval.</p>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Each chunk must be:</strong></p>
        <ul>
          <li>semantically narrow</li>
          <li>lexically explicit</li>
          <li>intent-pure</li>
        </ul>
      </div>
    </div>
    <!-- Optional Operator Task -->
    <div class="content-block module" style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #6c757d;">
      <div class="content-block__header">
        <h2 class="content-block__title">Optional Operator Task</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Task:</strong> Take three chunks from an existing page. Rewrite each chunk to be semantically narrow and intent-pure. Remove generic language and mixed ideas.</p>
        <p><strong>Constraint:</strong> Each rewritten chunk must focus on a single concept. If a chunk contains multiple ideas, split it into separate chunks.</p>
        <p><strong>What success looks like:</strong> You produce chunks where each chunk has a dominant semantic vector. When you read a chunk, you can immediately identify its single purpose without inference.</p>
        <p style="font-size: 0.875rem; color: #666; margin-top: 1rem;"><em>This task is optional. No submission required. No validation. Use it to convert theory into applied thinking.</em></p>
      </div>
    </div>

    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/data-structuring-beyond-pages/">Module 4: Data Structuring Beyond Pages</a></p>
    </div>
  </div>
</section>
</main>
<?php
if (!isset($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}
// TechArticle schema for lesson page
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'TechArticle',
  '@id' => SchemaFixes::ensureHttps($canonicalUrl) . '#techarticle',
  'headline' => $moduleTitle,
  'description' => 'A technical explanation of why vague chunks lose embedding battles and how to make chunks semantically narrow and intent-pure. Covers vectorization, semantic collisions, and nearest-neighbor retrieval.',
  'author' => [
    '@type' => 'Organization',
    'name' => 'Neural Command',
    'url' => 'https://nrlc.ai'
  ],
  'isPartOf' => [
    '@type' => 'Course',
    '@id' => 'https://nrlc.ai/en-us/docs/prechunking-seo/course/#course'
  ],
  'proficiencyLevel' => 'Advanced',
  'about' => [
    'Vectorization',
    'Semantic collisions',
    'Embedding models',
    'Nearest-neighbor retrieval'
  ],
  'breadcrumb' => [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Docs', 'item' => SchemaFixes::ensureHttps(absolute_url('/docs/'))],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Prechunking SEO', 'item' => SchemaFixes::ensureHttps(absolute_url('/docs/prechunking-seo/'))],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Course', 'item' => SchemaFixes::ensureHttps(absolute_url('/docs/prechunking-seo/course/'))],
      ['@type' => 'ListItem', 'position' => 4, 'name' => $moduleTitle, 'item' => SchemaFixes::ensureHttps($canonicalUrl)]
    ]
  ]
];
?>

