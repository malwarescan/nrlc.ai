<?php
// AI Visibility Service Landing Page
// Metadata is handled by router via $GLOBALS['__page_meta']
require_once __DIR__ . '/../../lib/schema_builders.php';

$industries = require __DIR__ . '/../../lib/ai_visibility_industries.php';
$canonicalUrl = absolute_url('/ai-visibility/');
$domain = absolute_url('/');

// Build JSON-LD Schema
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'AI Visibility | Control How AI Recommends Your Business',
    'description' => 'Control how AI systems describe, recommend, and reference your business. Industry-specific AI visibility optimization for high-trust industries.',
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
    'name' => 'AI Visibility Optimization',
    'serviceType' => 'AI Search Optimization',
    'description' => 'Control how AI systems describe, recommend, and reference your business. We restructure your website and digital signals so AI assistants understand exactly what you do, trust your expertise, and prefer you when explaining options.',
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
    
    <!-- HERO -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Control How AI Talks About Your Business</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">AI assistants like ChatGPT now answer the exact questions your customers ask before they ever search Google. We make sure your business is the one AI systems trust, reference, and recommend.</p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
          <a href="/api/book/" class="btn" data-ripple>See How AI Describes Your Business</a>
          <a href="/api/book/" class="btn btn--secondary" data-ripple>Request an AI Visibility Audit</a>
        </div>
      </div>
    </div>

    <!-- SECTION: YOUR CUSTOMERS ARE ASKING AI FIRST -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Your Customers Are Asking AI First</h2>
      </div>
      <div class="content-block__body">
        <p>People no longer start with search results. They start by asking AI questions like:</p>
        <ul>
          <li>"Do I need a [service provider] for my situation?"</li>
          <li>"What happens if I wait too long?"</li>
          <li>"Which option applies to me?"</li>
          <li>"What are the risks if I do this incorrectly?"</li>
        </ul>
        <p><strong>AI now answers these questions directly.</strong> Whoever AI trusts becomes the default option.</p>
      </div>
    </div>

    <!-- SECTION: SEO GETS YOU RANKED. AI DECIDES WHO GETS TRUSTED. -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">SEO Gets You Ranked. AI Decides Who Gets Trusted.</h2>
      </div>
      <div class="content-block__body">
        <p>Search results are shrinking. AI assistants summarize instead of linking.</p>
        <p>AI doesn't rank pages the way Google does. It pulls from:</p>
        <ul>
          <li>Clear service definitions</li>
          <li>Consistent explanations</li>
          <li>Structured, machine-readable signals</li>
          <li>Repeated authority patterns across the web</li>
        </ul>
        <p>If your business is unclear, AI fills in the gaps — often with competitors.</p>
      </div>
    </div>

    <!-- SECTION: WHAT WE DO -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Do (In Plain English)</h2>
      </div>
      <div class="content-block__body">
        <p>We analyze how AI systems currently describe your business, your services, and your competitors.</p>
        <p>Then we restructure your website and digital signals so AI assistants:</p>
        <ul>
          <li>Understand exactly what you do</li>
          <li>Trust your expertise</li>
          <li>Reference your business accurately</li>
          <li>Prefer you when explaining options</li>
        </ul>
        <p><strong>We don't try to trick AI. We make your business unambiguous.</strong></p>
      </div>
    </div>

    <!-- SECTION: INDUSTRY-SPECIFIC PAGES -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Industry-Specific AI Visibility</h2>
      </div>
      <div class="content-block__body">
        <p>We provide specialized AI visibility optimization for high-trust industries where customers research extensively before making decisions:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-md); margin-top: var(--spacing-md);">
          <?php foreach ($industries as $slug => $industry): ?>
            <div style="padding: var(--spacing-md); border: 1px solid var(--color-border, #e0e0e0); border-radius: 4px;">
              <h3 style="margin-top: 0; font-size: 1.1rem;"><a href="/ai-visibility/<?= htmlspecialchars($slug) ?>/"><?= htmlspecialchars($industry['name']) ?></a></h3>
              <p style="font-size: 0.9rem; color: #666;"><?= htmlspecialchars($industry['core_fear']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- SECTION: THIS IS ALREADY HAPPENING -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">This Is Already Happening</h2>
      </div>
      <div class="content-block__body">
        <p>AI assistants already:</p>
        <ul>
          <li>Summarize reviews instead of users reading them</li>
          <li>Answer "do I need a [service provider]?" directly</li>
          <li>Explain risks and timelines without visiting websites</li>
          <li>Mention specific businesses by name when authority is clear</li>
        </ul>
        <p><strong>Ignoring this layer means losing control of how your business is represented.</strong></p>
      </div>
    </div>

    <!-- SECTION: THE OFFER -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Offer</h2>
      </div>
      <div class="content-block__body">
        <h3>AI Visibility & Trust Audit</h3>
        <p>You receive:</p>
        <ul>
          <li>A breakdown of how AI currently describes your business</li>
          <li>Where competitors are being favored</li>
          <li>What signals are missing or unclear</li>
          <li>A prioritized fix list</li>
        </ul>
        <p><strong>This is a diagnostic, not a contract.</strong></p>
        <p style="margin-top: var(--spacing-lg);">
          <a href="/api/book/" class="btn" data-ripple>Request Your AI Visibility Audit</a>
        </p>
      </div>
    </div>

    <!-- FAQ SECTION -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; font-size: 1.1rem;">Can you control what ChatGPT says about my business?</h3>
          <p>We can't force AI to say anything, but we can control the signals it learns from.</p>
        </div>
        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; font-size: 1.1rem;">Is this different from SEO?</h3>
          <p>Yes. SEO targets rankings. This targets AI understanding and trust.</p>
        </div>
        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; font-size: 1.1rem;">Will this replace Google rankings?</h3>
          <p>No. It complements SEO and protects you as AI replaces clicks.</p>
        </div>
        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; font-size: 1.1rem;">Is this safe and compliant?</h3>
          <p>Yes. We use transparent, compliance-safe methods.</p>
        </div>
        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; font-size: 1.1rem;">How long does it take to see changes?</h3>
          <p>AI visibility changes as signals propagate. Early improvements often appear within weeks.</p>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

