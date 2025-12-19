<?php
/**
 * AI Visibility Landing Page Template
 * Industry-specific landing pages for AI trust and authority
 */

// Metadata is handled by router via $GLOBALS['__page_meta']
require_once __DIR__ . '/../../lib/schema_builders.php';

$industries = require __DIR__ . '/../../lib/ai_visibility_industries.php';
$industrySlug = $_GET['industry'] ?? 'immigration';
$industry = $industries[$industrySlug] ?? $industries['immigration'];

$canonicalUrl = absolute_url("/ai-visibility/{$industrySlug}/");
$domain = absolute_url('/');

// Build JSON-LD Schema
$faqItems = [];
foreach ($industry['faqs'] as $faq) {
  $faqItems[] = [
    '@type' => 'Question',
    'name' => $faq['question'],
    'acceptedAnswer' => [
      '@type' => 'Answer',
      'text' => $faq['answer']
    ]
  ];
}

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => "AI Visibility for {$industry['name']} | Control How AI Recommends Your Business",
    'description' => $industry['subheadline'],
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ],
    'mainEntity' => [
      '@id' => $canonicalUrl . '#service'
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'AI Visibility & Trust Audit',
    'serviceType' => 'AI Search Optimization',
    'description' => "AI Visibility & Trust Audit is a diagnostic that measures how AI systems describe your {$industry['name']} business and identifies the exact signals needed to become the trusted recommendation.",
    'provider' => [
      '@type' => 'Organization',
      '@id' => $domain . '#organization',
      'name' => 'Neural Command',
      'url' => $domain
    ],
    'areaServed' => 'Worldwide',
    'url' => $canonicalUrl
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => $faqItems
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
    
    <!-- HERO (ABOVE THE FOLD) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title"><?= htmlspecialchars($industry['headline']) ?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;"><?= htmlspecialchars($industry['subheadline']) ?></p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
          <button type="button" class="btn" onclick="openContactSheet('See How AI Describes Your Firm')" data-ripple>See How AI Describes Your Firm</button>
          <button type="button" class="btn btn--secondary" onclick="openContactSheet('Request an AI Visibility Audit')" data-ripple>Request an AI Visibility Audit</button>
        </div>
      </div>
    </div>

    <!-- SECTION: YOUR CUSTOMERS ARE ASKING AI FIRST -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title"><?= htmlspecialchars($industry['section_1_title']) ?></h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($industry['section_1_content']) ?></p>
        <ul>
          <?php foreach ($industry['common_ai_prompts'] as $prompt): ?>
            <li>"<?= htmlspecialchars($prompt) ?>"</li>
          <?php endforeach; ?>
        </ul>
        <p><strong>AI now answers these questions directly.</strong> Whoever AI trusts becomes the default option.</p>
      </div>
    </div>

    <!-- SECTION: AI COMPARISON -->
    <div class="content-block module" id="ai-comparison">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Explains This Decision Today</h2>
      </div>
      <div class="content-block__body">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-md);">
          <?php if (isset($industry['ai_comparison_generic_title'])): ?>
            <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
              <h3 style="margin-top: 0; color: #666;"><?= htmlspecialchars($industry['ai_comparison_generic_title']) ?></h3>
              <p><?= htmlspecialchars($industry['ai_comparison_generic_body']) ?></p>
            </div>
            <div style="border: 1px solid #4a90e2; padding: var(--spacing-md); border-radius: 4px; background: #f0f7ff;">
              <h3 style="margin-top: 0; color: #4a90e2;"><?= htmlspecialchars($industry['ai_comparison_preferred_title']) ?></h3>
              <p><?= htmlspecialchars($industry['ai_comparison_preferred_body']) ?></p>
            </div>
          <?php endif; ?>
        </div>
        <style>
          @media (min-width: 768px) {
            #ai-comparison .content-block__body > div[style*="grid-template-columns"] {
              grid-template-columns: 1fr 1fr !important;
            }
          }
        </style>
        <p style="margin-top: var(--spacing-md);">
          <a href="#offer" class="btn btn--secondary" data-ripple>See How AI Describes Your Business</a>
        </p>
      </div>
    </div>

    <!-- SECTION: SEO GETS YOU RANKED. AI DECIDES WHO GETS TRUSTED. -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title"><?= htmlspecialchars($industry['section_2_title']) ?></h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($industry['section_2_content']) ?></p>
      </div>
    </div>

    <!-- SECTION: WHAT WE DO (IN PLAIN ENGLISH) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title"><?= htmlspecialchars($industry['section_3_title']) ?></h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($industry['section_3_content']) ?></p>
      </div>
    </div>

    <!-- SECTION: INDUSTRY-SPECIFIC AI TRUST SIGNALS -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title"><?= htmlspecialchars($industry['name']) ?>-Specific AI Trust Signals</h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($industry['section_4_content']) ?></p>
        <p><strong>This is how AI decides who is credible.</strong></p>
      </div>
    </div>

    <!-- SECTION: THIS IS ALREADY HAPPENING -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title"><?= htmlspecialchars($industry['section_5_title']) ?></h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($industry['section_5_content']) ?></p>
      </div>
    </div>

    <!-- SECTION: THE OFFER -->
    <div class="content-block module" id="offer">
      <div class="content-block__header">
        <h2 class="content-block__title">The Offer</h2>
      </div>
      <div class="content-block__body">
        <h3>AI Visibility & Trust Audit</h3>
        <p><strong>AI Visibility & Trust Audit</strong> is a diagnostic that measures how AI systems describe your business and identifies the exact signals needed to become the trusted recommendation.</p>
        <p>You receive:</p>
        <ul>
          <li>A breakdown of how AI currently describes your firm</li>
          <li>Where competitors are being favored</li>
          <li>What signals are missing or unclear</li>
          <li>A prioritized fix list</li>
        </ul>
        <div style="margin: var(--spacing-md) 0; padding: var(--spacing-md); background: #f9f9f9; border-left: 3px solid #4a90e2;">
          <p style="margin: 0;"><strong>This is:</strong> a diagnostic + prioritized fix list</p>
          <p style="margin: 0;"><strong>This isn't:</strong> a promise to control AI output or guaranteed rankings</p>
        </div>
        <?php if ($industrySlug === 'immigration'): ?>
          <p style="margin-top: var(--spacing-md);">
            <a href="/ai-visibility/audit-example/immigration/" class="btn btn--secondary" data-ripple title="See an example AI Visibility Audit for immigration services">See an Audit Example</a>
          </p>
        <?php endif; ?>
        <p style="margin-top: var(--spacing-lg);">
          <button type="button" class="btn" onclick="openContactSheet('Request Your AI Visibility Audit')" data-ripple>Request Your AI Visibility Audit</button>
        </p>
      </div>
    </div>

    <!-- SECTION: WHAT HAPPENS NEXT -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What Happens Next</h2>
      </div>
      <div class="content-block__body">
        <ol>
          <li><strong>We run the prompt set:</strong> We test how AI answers your industry's most common questions.</li>
          <li><strong>We identify missing signals:</strong> We document where your business is unclear, generic, or non-citable.</li>
          <li><strong>You get a prioritized fix plan:</strong> A concrete list of changes needed to become the trusted recommendation.</li>
          <li><strong>We implement (optional):</strong> We can restructure your content and signals directly, or you can use the plan internally.</li>
        </ol>
      </div>
    </div>

    <!-- FAQ SECTION -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <?php foreach ($industry['faqs'] as $faq): ?>
          <div style="margin-bottom: var(--spacing-md);">
            <h3 style="margin-top: 0; font-size: 1.1rem;"><?= htmlspecialchars($faq['question']) ?></h3>
            <p><?= htmlspecialchars($faq['answer']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- BACK TO AI VISIBILITY HUB -->
    <div class="content-block module">
      <div class="content-block__body">
        <p><a href="/ai-visibility/" class="btn">← View All Industries</a></p>
      </div>
    </div>

  </div>
</section>
</main>

