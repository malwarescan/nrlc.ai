<?php
declare(strict_types=1);
// Module 9: Failure Modes (Why Chunks Die)

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/failure-modes-why-chunks-die/');
$moduleNum = 9;
$moduleTitle = 'Failure Modes (Why Chunks Die)';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/measuring-prechunking-success/">← Previous: Module 8</a></p>
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
        <p>Why content disappears from AI answers.</p>
        <p>Common failures prevent chunks from being retrieved, cited, or reused.</p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Common Failures</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><strong>Pronouns:</strong> "It", "they", "this" require context that may not be preserved</li>
          <li><strong>Implied context:</strong> Facts that depend on previous sentences or sections</li>
          <li><strong>Mixed services:</strong> Chunks that describe multiple services or capabilities</li>
          <li><strong>Marketing adjectives:</strong> Superlatives and promotional language reduce citation eligibility</li>
          <li><strong>Narrative transitions:</strong> Sentences that connect ideas but contain no facts</li>
        </ul>
      </div>
    </div>
    <div class="content-block module" style="background: #fff3cd; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #ffc107;">
      <div class="content-block__header">
        <h2 class="content-block__title">Key Truth</h2>
      </div>
      <div class="content-block__body">
        <p>These failures cause chunks to be:</p>
        <ul>
          <li>ignored during retrieval</li>
          <li>skipped during citation</li>
          <li>mutated during extraction</li>
          <li>replaced by competitor content</li>
        </ul>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>If a chunk cannot stand alone, delete it.</strong></p>
        <p>Rewrite it as an atomic fact, or remove it entirely. Broken chunks are worse than no chunks.</p>
      </div>
    </div>
    <div class="content-block module">
      <p><strong>Course Complete:</strong> <a href="/docs/prechunking-seo/course/">Return to Course Overview</a></p>
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
  'description' => 'A technical explanation of common failures (pronouns, implied context, marketing language) that prevent retrieval and citation. Covers why chunks die and how to prevent content from disappearing from AI answers.',
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
    'Failure modes',
    'Chunk failures',
    'Retrieval prevention',
    'Citation avoidance'
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

