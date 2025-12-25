<?php
declare(strict_types=1);
// Module 6: Prompt Reverse-Engineering (Safely)

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/prompt-reverse-engineering/');
$moduleNum = 6;
$moduleTitle = 'Prompt Reverse-Engineering (Safely)';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/cross-page-consistency/">← Previous: Module 5</a></p>
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
        <p>How to infer questions without prompt injection.</p>
        <p><strong>Correct Framing:</strong> You are not manipulating prompts. You are modeling question distributions. <em>Related: <a href="/docs/prechunking-seo/precogs/">Precog Modeling</a></em></p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Steps</h2>
      </div>
      <div class="content-block__body">
        <ol>
          <li><strong>Identify primary user question:</strong> What is the main query users will ask?</li>
          <li><strong>Identify follow-up questions:</strong> What questions naturally follow the primary question?</li>
          <li><strong>Identify trust questions:</strong> What questions test credibility or safety?</li>
          <li><strong>Identify safety constraints:</strong> What boundaries must answers respect?</li>
        </ol>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>If a question can be asked, its answer must already exist as a chunk.</strong></p>
        <p>Don't wait for questions. Anticipate them and publish answers in advance.</p>
      </div>
    </div>
    <!-- Optional Operator Task -->
    <div class="content-block module" style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #6c757d;">
      <div class="content-block__header">
        <h2 class="content-block__title">Optional Operator Task</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Task:</strong> Identify one primary question users ask about your service. List the next five follow-up questions they would naturally ask. For each question, identify what chunk must exist to answer it.</p>
        <p><strong>Constraint:</strong> Each follow-up question must be logically necessary, not speculative. Each required chunk must be a single atomic fact.</p>
        <p><strong>What success looks like:</strong> You produce a question tree where every question has a corresponding chunk that answers it. You've modeled the question distribution and ensured answers exist before questions are asked.</p>
        <p style="font-size: 0.875rem; color: #666; margin-top: 1rem;"><em>This task is optional. No submission required. No validation. Use it to convert theory into applied thinking.</em></p>
      </div>
    </div>

    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/citation-eligibility-engineering/">Module 7: Citation Eligibility Engineering</a></p>
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
  'description' => 'A technical explanation of how to model question distributions and ensure answers exist before questions are asked. Covers prompt reverse-engineering, question modeling, and anticipatory content design.',
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
    'Question modeling',
    'Prompt engineering',
    'Intent forecasting',
    'Content anticipation'
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

