<?php
declare(strict_types=1);
// Module 1: How LLMs Actually Chunk Content

require_once __DIR__.'/../../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/how-llms-chunk-content/');
$moduleNum = 1;
$moduleTitle = 'How LLMs Actually Chunk Content';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Navigation -->
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a></p>
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
        <p>Why "sections" are not real chunks.</p>
        <p>This module explains how LLMs actually break content into chunks, and why visual structure does not determine chunk boundaries.</p>
      </div>
    </div>

    <!-- Core Concepts -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Concepts</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><strong>Token-based chunking:</strong> LLMs chunk based on token limits, not visual structure</li>
          <li><strong>DOM boundary heuristics:</strong> HTML structure influences but does not control chunking</li>
          <li><strong>Sentence vs semantic chunking:</strong> Chunks may split mid-sentence or combine multiple sentences</li>
          <li><strong>Overlap windows:</strong> Chunks overlap to preserve context, but overlap is not guaranteed</li>
          <li><strong>Truncation bias:</strong> Long sentences or paragraphs are truncated, losing information</li>
        </ul>
      </div>
    </div>

    <!-- Key Truth -->
    <div class="content-block module" style="background: #fff3cd; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #ffc107;">
      <div class="content-block__header">
        <h2 class="content-block__title">Key Truth</h2>
      </div>
      <div class="content-block__body">
        <p><strong>LLMs do not respect:</strong></p>
        <ul>
          <li>paragraphs</li>
          <li>headings</li>
          <li>visual sections</li>
        </ul>
        <p><strong>They chunk based on:</strong></p>
        <ul>
          <li>token limits</li>
          <li>punctuation density</li>
          <li>semantic similarity</li>
          <li>transformer attention patterns</li>
        </ul>
      </div>
    </div>

    <!-- Practical Rule -->
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Practical Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>If a fact requires previous text, it is already broken.</strong></p>
        <p>Design every chunk to be self-contained. Never assume surrounding context will be preserved.</p>
      </div>
    </div>

    <!-- Next Module -->
    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/chunk-atomicity-inference-cost/">Module 2: Chunk Atomicity and Inference Cost</a></p>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema
if (!isset($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

// TechArticle schema for lesson page
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'TechArticle',
  '@id' => SchemaFixes::ensureHttps($canonicalUrl) . '#techarticle',
  'headline' => $moduleTitle,
  'description' => 'A technical breakdown of how large language models segment, embed, and retrieve content during inference. Explains token-based chunking, DOM boundaries, and why visual structure does not determine chunk boundaries.',
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
    'Chunking algorithms',
    'Embedding models',
    'Context windows',
    'Token-based segmentation'
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

