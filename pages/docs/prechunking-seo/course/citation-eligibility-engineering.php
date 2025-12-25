<?php
declare(strict_types=1);
// Module 7: Citation Eligibility Engineering

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/citation-eligibility-engineering/');
$moduleNum = 7;
$moduleTitle = 'Citation Eligibility Engineering';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/prompt-reverse-engineering/">← Previous: Module 6</a></p>
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
        <p>Why AI avoids citing most content.</p>
        <p>LLMs apply citation filters to avoid citing content that sounds promotional, makes guarantees, lacks scope, or mixes opinion and fact. <em>Related: <a href="/docs/prechunking-seo/failure-modes/">Failure Modes</a></em></p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Citation Filters</h2>
      </div>
      <div class="content-block__body">
        <p><strong>LLMs avoid citing content that:</strong></p>
        <ul>
          <li>sounds promotional</li>
          <li>makes guarantees</li>
          <li>lacks scope</li>
          <li>mixes opinion and fact</li>
        </ul>
        <p>Citation is a trust signal. LLMs only cite content they can verify and defend.</p>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Write chunks that are:</strong></p>
        <ul>
          <li>factual</li>
          <li>scoped</li>
          <li>boring</li>
          <li>safe</li>
        </ul>
        <p><strong>Boring content gets cited.</strong></p>
        <p>Remove marketing language, superlatives, and emotional framing. Write declarative facts.</p>
      </div>
    </div>
    <!-- Optional Operator Task -->
    <div class="content-block module" style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #6c757d;">
      <div class="content-block__header">
        <h2 class="content-block__title">Optional Operator Task</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Task:</strong> Take a promotional paragraph from your content. Rewrite it as a factual, scoped, boring chunk that is safe to cite.</p>
        <p><strong>Constraint:</strong> Remove all marketing language, superlatives, emotional framing, and guarantees. Keep only declarative facts with explicit scope.</p>
        <p><strong>What success looks like:</strong> You produce a chunk that sounds like a reference manual entry, not a sales page. An LLM reading this chunk would feel confident citing it because it's factual, scoped, and safe.</p>
        <p style="font-size: 0.875rem; color: #666; margin-top: 1rem;"><em>This task is optional. No submission required. No validation. Use it to convert theory into applied thinking.</em></p>
      </div>
    </div>

    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/measuring-prechunking-success/">Module 8: Measuring Prechunking Success</a></p>
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
  'description' => 'A technical explanation of why AI avoids citing promotional content and how to write factual, scoped chunks that get cited. Covers citation filters, trust signals, and content eligibility.',
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
    'Citation eligibility',
    'Trust signals',
    'Content filters',
    'AI citation behavior'
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

