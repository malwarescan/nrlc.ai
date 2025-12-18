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
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Get a Free AI Visibility Audit for Your Norwich Business')">Get a Free AI Visibility Audit for Your Norwich Business</button>
        </p>
      </div>
    </div>

    <!-- PROOF & AUTHORITY SECTION (Conversion Upgrade) -->
    <div class="content-block module" id="norwich-proof">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Norwich Companies Trust Us With High-Value Search Visibility</h2>
      </div>
      <div class="content-block__body">
        <p>When businesses in Norwich invest in SEO, they're often paying for rankings that don't translate into AI visibility. Google AI Overviews, ChatGPT summaries, and Perplexity answers bypass traditional search results entirely. If your competitors have clearer service definitions, consistent terminology, and structured authority signals, AI systems will recommend them instead of you—regardless of your search rankings. This isn't a traffic problem. It's a trust gap that wastes retainers and hands competitive advantage to firms that understand how AI systems choose who gets cited.</p>
        
        <p>Traditional SEO agencies optimize for keywords and backlinks. They measure success by position and traffic volume. But AI systems don't rank pages the way Google does. They evaluate which sources provide clear, structured, trustworthy information that can be safely summarized and cited. NRLC.ai addresses this structural trust layer directly—we engineer content so AI systems understand your business, map your expertise, and cite you when answering relevant questions.</p>

        <h3>Recent Work With Norwich-Area Businesses</h3>

        <div style="margin-bottom: var(--spacing-lg);">
          <h4 style="margin-top: 0;">Norwich-Based Professional Services Firm</h4>
          <ul>
            <li><strong>Diagnosis:</strong> Identified that competitors were appearing in AI-generated answers despite lower search rankings, due to clearer service definitions and consistent entity signals.</li>
            <li><strong>Entity / Service Signal Restructuring:</strong> Restructured service pages to provide unambiguous definitions that AI systems could extract and cite confidently.</li>
            <li><strong>Intent Mismatch Correction:</strong> Aligned content with actual search and AI intent, removing keyword-focused pages that confused both users and AI systems.</li>
            <li><strong>Outcome:</strong> Sustained trust visibility across Google AI Overviews and ChatGPT responses, with the firm now consistently referenced when AI systems explain their service category.</li>
          </ul>
        </div>

        <div style="margin-bottom: var(--spacing-lg);">
          <h4 style="margin-top: 0;">Norwich-Based B2B Company With National Reach</h4>
          <ul>
            <li><strong>Authority Gap Identification:</strong> Discovered that while the company ranked well, AI systems couldn't confidently extract their expertise or service boundaries, leading to generic or competitor recommendations.</li>
            <li><strong>LLM-Oriented Content Restructuring:</strong> Rebuilt key pages with structured signals, clear entity relationships, and verifiable authority markers that AI systems prioritize for citation.</li>
            <li><strong>Removal of Indexed-But-Untrusted Pages:</strong> Eliminated pages that appeared in search but lacked the structural signals needed for AI citation, consolidating authority to core service pages.</li>
            <li><strong>Outcome:</strong> Qualified inquiries tied to trust signals, with prospects referencing AI-generated summaries that now accurately describe the company's services and expertise.</li>
          </ul>
        </div>

        <p style="font-size: 0.9rem; color: #666; font-style: italic; margin-top: var(--spacing-md);">
          <strong>Note:</strong> No sensitive client data is published here. No vanity screenshots or unverifiable metrics. Our focus is on the durable trust signals that Google and AI systems actually use—service definition clarity, consistent terminology, structured data completeness, and authority patterns that survive algorithmic changes.
        </p>

        <h3>Why This Matters If You're Competing in Norwich</h3>
        
        <p>Norwich is deceptively competitive. Local agencies recycle outdated playbooks—keyword optimization, content volume, link building. But AI systems now bypass those tactics entirely. When someone asks ChatGPT "What's the best [service] in Norwich?" or when Google AI Overviews summarize options, they're not ranking pages. They're evaluating which businesses provide clear, trustworthy information that can be safely cited.</p>
        
        <p>If your competitors have structured their digital presence for AI understanding while you're still optimizing for search rankings, you're losing visibility in the fastest-growing segment of search. The buyer's problem isn't content volume or keyword density. It's structural trust—how AI systems understand, describe, and recommend your business.</p>

        <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-lg);">
          <div class="content-block__body">
            <p style="margin: 0 0 var(--spacing-sm) 0; font-weight: 500;"><strong>See Why Google Chooses Your Competitors Instead</strong></p>
            <p style="margin: 0 0 var(--spacing-md) 0; font-size: 0.9rem; color: #666;">Free AI Visibility Audit • Norwich & UK Businesses</p>
            <p style="margin: 0;">
              <a href="/en-us/services/ai-search-optimization/" class="btn btn--primary">Get Your AI Visibility Audit</a>
            </p>
          </div>
        </div>
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

