<?php
// AI Search Diagnostics: Traffic Down, Rankings Stable
// Symptom-first diagnostic guide

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-diagnostics/traffic-down-rankings-stable/');

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => absolute_url('/') . '#logo',
          'url' => absolute_url('/logo.png')
        ],
        'sameAs' => ['https://www.linkedin.com/company/neural-command/']
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Search Diagnostics', 'item' => absolute_url('/en-us/ai-search-diagnostics/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Traffic Down, Rankings Stable', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Traffic Down, Rankings Stable: Diagnostic Guide',
    'name' => 'Traffic Down, Rankings Stable',
    'description' => 'Understand why organic traffic declines while traditional rankings remain unchanged.',
    'url' => $canonicalUrl,
    'author' => ['@type' => 'Organization', '@id' => absolute_url('/') . '#organization', 'name' => 'Neural Command LLC'],
    'publisher' => ['@type' => 'Organization', '@id' => absolute_url('/') . '#organization', 'name' => 'Neural Command LLC'],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d')
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <p><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">← Back to AI Search Diagnostics</a></p>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Traffic Down, Rankings Stable</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Understand why organic traffic declines while traditional rankings remain unchanged.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What the System Is Doing</h2>
        </div>
        <div class="content-block__body">
          <p>Your pages maintain their traditional search rankings, but organic traffic has declined. This indicates that:</p>
          <ul>
            <li>Pages are still indexed and ranking for keywords</li>
            <li>Traditional search visibility is stable</li>
            <li>But click-through rates have dropped</li>
            <li>Or traffic is being diverted to AI-generated answers</li>
          </ul>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why the Symptom Appears</h2>
        </div>
        <div class="content-block__body">
          <p>Generative search results (AI Overviews, ChatGPT, Perplexity) are answering queries directly, reducing the need for users to click through to source pages. Even if your page ranks #1, users may get their answer from the AI summary without visiting your site.</p>
          <p>This is a zero-click search problem amplified by generative AI.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Which Failure Mode It Maps To</h2>
        </div>
        <div class="content-block__body">
          <p>This symptom maps to:</p>
          <ul>
            <li>Content not being cited in AI Overviews</li>
            <li>Lack of atomic, citable segments</li>
            <li>See <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes Index</a> for detailed patterns</li>
          </ul>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Diagnostic Steps</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li><strong>Check AI Overview visibility:</strong> Are you being cited in Google AI Overviews?</li>
            <li><strong>Review click-through rates:</strong> Has CTR declined even for stable rankings?</li>
            <li><strong>Analyze query intent:</strong> Are informational queries being answered by AI?</li>
            <li><strong>Check citation eligibility:</strong> Is your content structured for verbatim citation?</li>
          </ol>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Mitigation Path</h2>
        </div>
        <div class="content-block__body">
          <p>To address this:</p>
          <ol>
            <li>Optimize for AI citation, not just rankings</li>
            <li>Structure content for verbatim extraction</li>
            <li>Focus on zero-click visibility in AI results</li>
            <li>See <a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> for tracking visibility</li>
          </ol>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__body">
          <p>This is a failure state within <a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization</a>, where systems fail to retrieve or select a source during AI-driven search and answer generation.</p>
        </div>
      </div>

    </div>
  </section>
</main>

