<?php
/**
 * AI Visibility Audit Example Page
 * Demonstrates diagnostic process without exposing client data
 */

require_once __DIR__ . '/../../lib/schema_builders.php';

$industries = require __DIR__ . '/../../lib/ai_visibility_industries.php';
$industrySlug = $_GET['industry'] ?? 'immigration';
$industry = $industries[$industrySlug] ?? $industries['immigration'];

$canonicalUrl = absolute_url("/ai-visibility/audit-example/{$industrySlug}/");
$domain = absolute_url('/');

// Build JSON-LD Schema
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => "AI Visibility Audit Example: {$industry['name']}",
    'description' => "See how we diagnose AI visibility issues for {$industry['name']}. This audit example demonstrates our diagnostic process without exposing client data.",
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumbs',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $domain
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'AI Visibility',
        'item' => absolute_url('/ai-visibility/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => $industry['name'],
        'item' => absolute_url("/ai-visibility/{$industrySlug}/")
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Audit Example',
        'item' => $canonicalUrl
      ]
    ]
  ],
  ld_organization()
];
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- TITLE -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI Visibility Audit Example: <?= htmlspecialchars($industry['name']) ?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead">This page demonstrates our diagnostic process for <?= htmlspecialchars($industry['name']) ?>. We measured how AI systems described a typical business in this category, identified missing signals, and documented the changes needed to become the trusted recommendation.</p>
      </div>
    </div>

    <!-- PROMPT SET USED -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Prompt Set Used</h2>
      </div>
      <div class="content-block__body">
        <p>We tested how AI answers the most common questions in this industry:</p>
        <ul>
          <?php foreach ($industry['common_ai_prompts'] as $prompt): ?>
            <li>"<?= htmlspecialchars($prompt) ?>"</li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- WHAT AI ANSWERED BEFORE -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What AI Answered Before</h2>
      </div>
      <div class="content-block__body">
        <p>Before optimization, AI systems provided generic, non-committal answers that avoided naming specific providers. Responses lacked clear decision frameworks, jurisdiction-specific guidance, and structured explanations of risks and timelines. AI tended to default to vague phrases like "it depends" or "consult a professional" without providing actionable context.</p>
        <p><strong>Key issues identified:</strong></p>
        <ul>
          <li>Generic language that didn't differentiate between providers</li>
          <li>Lack of clear decision steps or evaluation criteria</li>
          <li>Missing jurisdiction-specific or industry-specific terminology</li>
          <li>No structured explanation of risks, timelines, or process</li>
        </ul>
      </div>
    </div>

    <!-- WHAT WE CHANGED -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Changed (Signals)</h2>
      </div>
      <div class="content-block__body">
        <p>We restructured the website to provide clear, extractable signals that AI systems trust:</p>
        <ul>
          <li><strong>Service definition clarity:</strong> Explicit definitions of services, processes, and eligibility criteria using consistent terminology</li>
          <li><strong>Consistent terminology:</strong> Standardized entity names and industry-specific terms throughout all content</li>
          <li><strong>FAQ coverage aligned to prompts:</strong> Direct answers to common AI questions, structured as question-answer pairs</li>
          <li><strong>Structured data completeness:</strong> JSON-LD schema that mirrors visible content and declares entity relationships explicitly</li>
          <li><strong>Internal linking + hub reinforcement:</strong> Clear internal link structure that establishes the page as a canonical explainer node</li>
        </ul>
      </div>
    </div>

    <!-- WHAT AI ANSWERED AFTER -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What AI Answered After</h2>
      </div>
      <div class="content-block__body">
        <p>After optimization, AI systems began providing structured, decision-focused answers that included clear evaluation steps, jurisdiction-aware guidance, and specific risk assessments. Responses became more actionable and trustworthy, with AI systems able to reference the business by name when explaining options.</p>
        <p><strong>Key improvements:</strong></p>
        <ul>
          <li>Structured decision frameworks with clear evaluation steps</li>
          <li>Industry-specific terminology and jurisdiction-aware language</li>
          <li>Explicit risk and timeline explanations</li>
          <li>Business name mentioned when authority signals are clear</li>
        </ul>
      </div>
    </div>

    <!-- CTA -->
    <div class="content-block module">
      <div class="content-block__body">
        <p><button type="button" class="btn" onclick="openContactSheet('Request Your AI Visibility Audit')" data-ripple>Request Your AI Visibility Audit</button></p>
        <p><a href="/ai-visibility/<?= htmlspecialchars($industrySlug) ?>/" class="btn btn--secondary" data-ripple>← Back to <?= htmlspecialchars($industry['name']) ?> Page</a></p>
      </div>
    </div>

  </div>
</section>
</main>

