<?php
declare(strict_types=1);
// Module 2: Chunk Atomicity and Inference Cost

require_once __DIR__.'/../../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/chunk-atomicity-inference-cost/');
$moduleNum = 2;
$moduleTitle = 'Chunk Atomicity and Inference Cost';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Navigation -->
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/how-llms-chunk-content/">← Previous: Module 1</a></p>
    </div>

    <!-- Module Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Module <?= $moduleNum ?>: <?= htmlspecialchars($moduleTitle) ?></h1>
      </div>
    </div>

    <!-- What This Teaches -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Teaches</h2>
      </div>
      <div class="content-block__body">
        <p>Why multi-fact chunks fail retrieval.</p>
        <p>This module explains the data engineering principle: each chunk is a row, and each row should answer one question.</p>
      </div>
    </div>

    <!-- Data Engineering Framing -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Data Engineering Framing</h2>
      </div>
      <div class="content-block__body">
        <p>Each chunk is a row.</p>
        <p>Each row should answer one question.</p>
        <p>This is not content writing. This is schema design for retrieval systems.</p>
      </div>
    </div>

    <!-- Inference Cost Principle -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Inference Cost Principle</h2>
      </div>
      <div class="content-block__body">
        <p><strong>If an LLM must:</strong></p>
        <ul>
          <li>resolve pronouns</li>
          <li>infer scope</li>
          <li>merge facts</li>
          <li>assume context</li>
        </ul>
        <p><strong>It increases:</strong></p>
        <ul>
          <li>CPU cost</li>
          <li>hallucination risk</li>
          <li>citation avoidance</li>
        </ul>
        <p>LLMs avoid citing content that requires inference. They prefer explicit, self-contained facts.</p>
      </div>
    </div>

    <!-- Practical Rule -->
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>One chunk = one assertion = one retrieval target.</strong></p>
        <p>If a chunk contains multiple facts, split it. If a chunk requires context, make the context explicit within the chunk.</p>
      </div>
    </div>

    <!-- Next Module -->
    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/vectorization-semantic-collisions/">Module 3: Vectorization and Semantic Collisions</a></p>
    </div>

  </div>
</section>
</main>

<?php
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

if (!isset($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

// TechArticle schema for lesson page
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'TechArticle',
  '@id' => SchemaFixes::ensureHttps($canonicalUrl) . '#techarticle',
  'headline' => $moduleTitle,
  'description' => 'A technical explanation of why multi-fact chunks fail retrieval and the data engineering principle of one chunk per assertion. Covers inference cost, CPU overhead, and citation avoidance.',
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
    'Chunk atomicity',
    'Inference cost',
    'Data engineering',
    'Retrieval optimization'
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

