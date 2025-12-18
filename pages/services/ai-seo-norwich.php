<?php
// Custom Norwich AI SEO page - Tier 1 data-driven reinforcement
// URL: /en-gb/services/ai-seo-norwich/
// Metadata is handled by router via $GLOBALS['__page_meta']

require_once __DIR__.'/../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/en-gb/services/ai-seo-norwich/');
$domain = absolute_url('/');

// Build JSON-LD Schema with areaServed
$GLOBALS['__jsonld'] = [
  ld_organization(),
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'AI SEO & AI Visibility Services in Norwich',
    'serviceType' => 'AI Search Optimization',
    'description' => 'AI SEO and AI visibility services for businesses in Norwich. Improve visibility across Google Search, Google AI Overviews, and AI-driven platforms like ChatGPT. All services delivered remotely.',
    'provider' => [
      '@type' => 'Organization',
      'name' => 'Neural Command LLC',
      'url' => $domain
    ],
    'areaServed' => [
      ['@type' => 'Country', 'name' => 'United Kingdom'],
      ['@type' => 'City', 'name' => 'Norwich']
    ],
    'url' => $canonicalUrl
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'url' => $canonicalUrl,
    'name' => 'AI SEO & AI Visibility Services in Norwich',
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
        'name' => 'Services',
        'item' => $domain . 'services/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'AI SEO Norwich',
        'item' => $canonicalUrl
      ]
    ]
  ]
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Hero Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI SEO & AI Visibility Services in Norwich</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">We help businesses in Norwich improve visibility across Google Search, Google AI Overviews, and AI-driven platforms like ChatGPT. All services are delivered remotely, with a focus on search trust, citations, and intent alignment rather than traditional keyword tactics.</p>
        
        <!-- Above-fold CTA -->
        <div class="btn-group text-center" style="margin: 1.5rem 0;">
          <a href="tel:+12135628438" class="btn btn--primary">Call</a>
          <a href="mailto:hirejoelm@gmail.com" class="btn btn--primary">Email</a>
          <button type="button" class="btn btn--primary" onclick="openContactSheet('AI SEO Norwich')">Book a Call</button>
        </div>
      </div>
    </div>

    <!-- Outcomes Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What You Get</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Improve inclusion in Google AI Overviews</li>
          <li>Align pages with real search and AI intent</li>
          <li>Increase qualified visibility, not vanity traffic</li>
          <li>Identify why competitors surface instead of you</li>
        </ul>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Get Started</h2>
      </div>
      <div class="content-block__body">
        <p class="text-center">
          <a href="/api/book/" class="btn btn--primary">Get a Free AI Visibility Audit for Your Norwich Business</a>
        </p>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt><strong>Do you need to be based in Norwich?</strong></dt>
          <dd>No. All services are delivered remotely. We work with businesses across the UK and internationally.</dd>
          
          <dt><strong>How is AI SEO different from traditional SEO?</strong></dt>
          <dd>Traditional SEO targets rankings. AI SEO targets how AI systems understand, trust, and cite your business. It focuses on structured signals, entity clarity, and citation readiness rather than keyword optimization.</dd>
          
          <dt><strong>How long until results appear?</strong></dt>
          <dd>AI visibility changes as signals propagate. Early improvements often appear within weeks, with more significant gains typically visible within 30-60 days.</dd>
        </dl>
      </div>
    </div>

    <!-- Optional Low-Risk Optimization: Single footer line -->
    <div class="content-block module" style="margin-top: var(--spacing-lg); padding-top: var(--spacing-md); border-top: 1px solid #ddd;">
      <div class="content-block__body">
        <p style="text-align: center; font-size: 0.9rem; color: #666; margin: 0;">Not in Norwich? We also work with companies across the UK and United States.</p>
      </div>
    </div>

  </div>
</section>
</main>

