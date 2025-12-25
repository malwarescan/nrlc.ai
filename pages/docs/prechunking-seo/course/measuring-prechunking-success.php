<?php
declare(strict_types=1);
// Module 8: Measuring Prechunking Success

require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/measuring-prechunking-success/');
$moduleNum = 8;
$moduleTitle = 'Measuring Prechunking Success';
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <p><a href="/docs/prechunking-seo/course/">← Back to Course Overview</a> | <a href="/docs/prechunking-seo/course/citation-eligibility-engineering/">← Previous: Module 7</a></p>
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
        <p>What to measure instead of rankings.</p>
        <p>Real metrics focus on retrieval and citation, not traffic and impressions.</p>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Real Metrics</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><strong>Retrieval appearance:</strong> Does your content appear in AI-generated answers?</li>
          <li><strong>Answer reuse:</strong> Are your facts reused verbatim or near-verbatim?</li>
          <li><strong>Citation frequency:</strong> How often are you cited as a source?</li>
          <li><strong>Near-verbatim reuse:</strong> Are your chunks extracted with minimal modification?</li>
          <li><strong>Cross-engine consistency:</strong> Do multiple AI systems cite the same facts?</li>
        </ul>
      </div>
    </div>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Anti-Metrics</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Do not measure:</strong></p>
        <ul>
          <li>traffic</li>
          <li>impressions</li>
          <li>CTR</li>
        </ul>
        <p><strong>Those are downstream effects, not controls.</strong></p>
        <p>You cannot control traffic. You can control retrieval and citation.</p>
      </div>
    </div>
    <div class="content-block module" style="background: #d1ecf1; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #0c5460;">
      <div class="content-block__header">
        <h2 class="content-block__title">Prechunking Rule</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Measure retrieval and citation, not traffic and impressions.</strong></p>
        <p>Focus on what you can control: chunk quality, atomicity, and citation eligibility.</p>
      </div>
    </div>
    <div class="content-block module">
      <p><strong>Next:</strong> <a href="/docs/prechunking-seo/course/failure-modes-why-chunks-die/">Module 9: Failure Modes (Why Chunks Die)</a></p>
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
  'description' => 'A technical explanation of real metrics (retrieval appearance, citation frequency) vs anti-metrics (traffic, impressions). Covers measurement methods for prechunking success and what to track.',
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
    'Retrieval metrics',
    'Citation frequency',
    'Measurement methods',
    'AI visibility tracking'
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

