<?php
declare(strict_types=1);
// Module 5: Cross-Page Consistency as Signal Amplification

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/cross-page-consistency/');
$moduleNum = 5;
$moduleTitle = 'Cross-Page Consistency as Signal Amplification';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/data-structuring-beyond-pages/">← Previous: Module 4</a></p>
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
        <p>Why single-page optimization fails.</p>
        <p>LLMs evaluate cross-source agreement, consistency across contexts, and repeated factual phrasing.</p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">LLM Behavior</h2>
      </div>
      <div class="content-block__body">
        <p><strong>LLMs evaluate:</strong></p>
        <ul>
          <li>cross-source agreement</li>
          <li>consistency across contexts</li>
          <li>repeated factual phrasing</li>
        </ul>
        <p>If a fact appears consistently across multiple pages, it gains trust. If it appears only once, it is less reliable.</p>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Facts must repeat:</strong></p>
        <ul>
          <li>across pages</li>
          <li>across sections</li>
          <li>across formats</li>
        </ul>
        <p><strong>But never change meaning.</strong></p>
        <p>This is not duplication. This is data reinforcement.</p>
      </div>
    </div>
    <!-- Optional Operator Task -->
    <div class="content-block module" style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #6c757d;">
      <div class="content-block__header">
        <h2 class="content-block__title">Optional Operator Task</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Task:</strong> Identify one core fact about your service or product. Republish that fact on three different pages using identical wording.</p>
        <p><strong>Constraint:</strong> The fact must appear verbatim across all three pages. No paraphrasing, no variation, no "synonyms."</p>
        <p><strong>What success looks like:</strong> You produce three pages where the same fact appears with identical phrasing. When an LLM evaluates cross-source agreement, it finds perfect consistency, which increases trust and citation probability.</p>
        <p style="font-size: 0.875rem; color: #666; margin-top: 1rem;"><em>This task is optional. No submission required. No validation. Use it to convert theory into applied thinking.</em></p>
      </div>
    </div>

    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/prompt-reverse-engineering/">Module 6: Prompt Reverse-Engineering (Safely)</a></p>
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
  'description' => 'A technical explanation of why single-page optimization fails and how repeated facts across pages gain trust. Covers cross-source agreement, consistency evaluation, and data reinforcement.',
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
    'Cross-page consistency',
    'Signal amplification',
    'Data reinforcement',
    'Trust signals'
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

