<?php
declare(strict_types=1);
// Module 4: Data Structuring Beyond Pages

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/data-structuring-beyond-pages/');
$moduleNum = 4;
$moduleTitle = 'Data Structuring Beyond Pages';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/vectorization-semantic-collisions/">← Previous: Module 3</a></p>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Module <?= $moduleNum ?>: <?= htmlspecialchars($moduleTitle) ?></h1>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Teaches</h2>
      </div>
      <div class="content-block__body">
        <p>Prechunking is not just page layout.</p>
        <p>This is where most SEO thinking breaks. Structured layers matter more than prose.</p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Structured Layers That Matter</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><strong>JSON-LD:</strong> Machine-readable structured data</li>
          <li><strong>Lists:</strong> Ordered and unordered lists provide clear boundaries</li>
          <li><strong>Tables:</strong> Tabular data is easier to extract and verify</li>
          <li><strong>Definitions:</strong> Explicit term definitions reduce ambiguity</li>
          <li><strong>Repeated factual patterns:</strong> Consistent structure across pages</li>
        </ul>
      </div>
    </div>
    <div class="content-block module" style="background: #fff3cd; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #ffc107;">
      <div class="content-block__header">
        <h2 class="content-block__title">Why</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Structured data reduces:</strong></p>
        <ul>
          <li>inference depth</li>
          <li>ambiguity</li>
          <li>retrieval risk</li>
        </ul>
        <p><strong>LLMs trust structured repetition more than prose.</strong></p>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Important facts must exist in multiple structural forms.</strong></p>
        <p>Don't rely on prose alone. Use JSON-LD, lists, tables, and definitions to reinforce key facts.</p>
      </div>
    </div>
    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/cross-page-consistency/">Module 5: Cross-Page Consistency as Signal Amplification</a></p>
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
  'description' => 'A technical explanation of why structured data (JSON-LD, lists, tables) reduces inference depth and retrieval risk. Covers structured layers beyond page layout and how LLMs trust structured repetition.',
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
    'Structured data',
    'JSON-LD',
    'Data structuring',
    'Inference reduction'
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

