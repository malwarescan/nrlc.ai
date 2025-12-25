<?php
// AI Visibility Diagnostic Tool
// Metadata is handled by router via $GLOBALS['__page_meta']
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';

$canonicalUrl = absolute_url('/resources/diagnostic/');
$domain = absolute_url('/');

// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Build JSON-LD Schema
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'AI Visibility Diagnostic Tool',
    'description' => 'Diagnostic tool to understand AI visibility issues before requesting a professional audit.',
    'url' => $canonicalUrl,
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website'
    ],
    'about' => [
      '@type' => 'Service',
      'name' => 'AI Visibility & Trust Audit',
      'provider' => [
        '@type' => 'Organization',
        '@id' => $domain . '#organization'
      ]
    ]
  ]
];

// Set page metadata for head.php
$GLOBALS['__page_slug'] = 'resources/diagnostic';
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- HERO SECTION -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI Visibility Diagnostic</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 1.5rem;">Understand how AI systems like ChatGPT, Google AI Overviews, Perplexity, and Claude interpret your business before requesting a professional audit.</p>
        <p>This diagnostic helps you identify visibility issues and understand what signals AI systems use to describe and trust your business.</p>
      </div>
    </div>

    <!-- WHAT THIS DIAGNOSTIC COVERS -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Diagnostic Covers</h2>
      </div>
      <div class="content-block__body">
        <p>The diagnostic evaluates key areas that influence how AI systems understand and cite your business:</p>
        <ul>
          <li><strong>Entity Clarity:</strong> How clearly your business identity, services, and expertise are defined in machine-readable formats</li>
          <li><strong>Content Structure:</strong> Whether your content is structured for AI extraction and citation safety</li>
          <li><strong>Trust Signals:</strong> The presence of authoritative references, consistent language, and verifiable information</li>
          <li><strong>Visibility Gaps:</strong> Areas where competitors may be favored or where your business is not being referenced</li>
        </ul>
        <p>This is not a traditional SEO audit. It focuses specifically on how AI systems interpret and trust your business information.</p>
      </div>
    </div>

    <!-- HOW IT WORKS -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How It Works</h2>
      </div>
      <div class="content-block__body">
        <p>To begin the diagnostic process, provide your website URL and business information. Our system will analyze:</p>
        <ol>
          <li>How AI systems currently describe your business when asked relevant questions</li>
          <li>What information is being extracted and cited (or not cited) about your business</li>
          <li>Where competitors are being favored in AI-generated answers</li>
          <li>What specific signals are missing or unclear that prevent AI systems from confidently referencing your business</li>
        </ol>
        <p>You will receive a diagnostic report that identifies visibility issues and provides a prioritized list of fixes.</p>
      </div>
    </div>

    <!-- CTA SECTION -->
    <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; margin-top: var(--spacing-lg);">
      <div class="content-block__body">
        <p style="margin: 0 0 var(--spacing-md) 0; font-weight: 500;"><strong>Ready to Run Your Diagnostic?</strong></p>
        <p style="margin: 0 0 var(--spacing-md) 0; font-size: 0.9rem; color: #666;">Request your AI visibility diagnostic to understand how AI systems interpret your business.</p>
        <p style="margin: var(--spacing-md) 0 0 0;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('AI Visibility Diagnostic Request')" title="Request an AI visibility diagnostic">Request Your Diagnostic</button>
        </p>
        <p style="margin: var(--spacing-md) 0 0 0; font-size: 0.9rem; color: #666;">Or, if you're ready for a comprehensive audit:</p>
        <p style="margin: var(--spacing-sm) 0 0 0;">
          <button type="button" class="btn btn--secondary" onclick="openContactSheet('Request AI Visibility Audit')" title="Request a comprehensive AI visibility audit">Request a Full Audit</button>
        </p>
      </div>
    </div>

    <!-- WHAT YOU GET -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What You Receive</h2>
      </div>
      <div class="content-block__body">
        <p>After running the diagnostic, you will receive:</p>
        <ul>
          <li>A breakdown of how AI systems currently describe your business</li>
          <li>Identification of visibility gaps where competitors are being favored</li>
          <li>Analysis of missing or unclear AI trust signals</li>
          <li>A prioritized list of fixes to improve AI visibility and citation</li>
        </ul>
        <p><strong>This is a diagnostic, not a contract.</strong> The diagnostic provides insights and recommendations. Implementation is separate and optional.</p>
      </div>
    </div>

    <!-- NEXT STEPS -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Next Steps</h2>
      </div>
      <div class="content-block__body">
        <p>After reviewing your diagnostic results, you may choose to:</p>
        <ul>
          <li>Request a comprehensive <a href="<?= htmlspecialchars($localePrefix . '/services/site-audits/') ?>" title="Site audits for AI and search visibility">Site Audit for AI & Search Visibility</a> for deeper analysis</li>
          <li>Explore our <a href="<?= htmlspecialchars($localePrefix . '/services/ai-search-optimization/') ?>" title="AI search optimization services">AI Search Optimization services</a> for implementation support</li>
          <li>Review our <a href="<?= htmlspecialchars($localePrefix . '/ai-visibility/') ?>" title="AI visibility and trust audit information">AI Visibility & Trust Audit</a> service for professional analysis</li>
        </ul>
      </div>
    </div>

  </div>
</section>
</main>

