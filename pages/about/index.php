<?php
/**
 * About Page - GBP-RECONCILIATION REQUIRED
 * 
 * First section must clearly state:
 * - Business name as per GBP
 * - What the company sells (AI SEO / AI search optimization services)
 * - Who it serves (businesses)
 * - Where it operates (consistent with GBP service area)
 * - How engagement works
 * 
 * No manifesto language in the first screen.
 * Google uses this page to validate GBP legitimacy.
 */

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$canonicalUrl = absolute_url('/about/');
$domain = absolute_url('/');

// Set page metadata
$GLOBALS['__page_slug'] = 'about/index';
$GLOBALS['__page_meta'] = [
  'title' => 'About ' . gbp_business_name() . ' | AI SEO & AI Visibility Services',
  'description' => gbp_business_name() . ' provides AI SEO and AI search optimization services for businesses. Learn about our AI visibility services, structured data implementation, and technical SEO expertise.',
  'canonicalPath' => '/about/'
];

// Build JSON-LD Schema (GBP-ALIGNED)
$GLOBALS['__jsonld'] = [
  // Organization schema (uses ld_organization() which is GBP-aligned)
  ld_organization(),
  
  // BreadcrumbList
  ld_breadcrumbs(),
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'About ' . gbp_business_name(),
    'url' => $canonicalUrl,
    'description' => 'About ' . gbp_business_name() . ' - AI SEO and AI search optimization services for businesses.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '/#website',
      'name' => gbp_business_name(),
      'url' => $domain
    ]
  ]
];

$gbpName = gbp_business_name();
$gbpAddress = gbp_address_display();
$gbpPhone = gbp_phone();
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- GBP-RECONCILIATION SECTION: First screen (no manifesto language) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">About <?= htmlspecialchars($gbpName) ?></h1>
        </div>
        <div class="content-block__body">
          <p class="lead"><?= htmlspecialchars($gbpName) ?> provides AI SEO and AI search optimization services for businesses.</p>
          
          <h2>What We Provide</h2>
          <p><?= htmlspecialchars($gbpName) ?> sells AI SEO and AI search optimization services. We help businesses improve their visibility in AI-powered search engines including Google AI Overviews, ChatGPT, Perplexity, and Claude.</p>
          
          <h2>Who We Serve</h2>
          <p>We serve businesses that need to improve their presence in AI-generated answers and generative search results. Our clients include companies across the United States and United Kingdom.</p>
          
          <h2>Where We Operate</h2>
          <p>We operate in <?= htmlspecialchars($gbpAddress) ?>. Services are delivered remotely to businesses across our service area.</p>
          
          <h2>How Engagement Works</h2>
          <p>Engagement typically begins with an AI visibility audit to assess how your business currently appears in AI-generated answers. We then provide structured data implementation, technical SEO optimization, and content strategy to improve AI citations and brand mentions. Services are customized based on your specific business needs and industry requirements.</p>
          
          <div style="margin-top: 2rem; padding: 1.5rem; background: #f0f7ff; border-left: 3px solid #4a90e2;">
            <h3 style="margin-top: 0;">Contact Information</h3>
            <p style="margin-bottom: 0.5rem;"><strong>Business Name:</strong> <?= htmlspecialchars($gbpName) ?></p>
            <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> <?= htmlspecialchars($gbpAddress) ?></p>
            <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(str_replace([' ', '-', '(', ')'], '', $gbpPhone)) ?>"><?= htmlspecialchars($gbpPhone) ?></a></p>
            <p style="margin-bottom: 0;"><strong>Website:</strong> <a href="<?= htmlspecialchars(gbp_website()) ?>"><?= htmlspecialchars(gbp_website()) ?></a></p>
          </div>
        </div>
      </div>
      
      <!-- Additional Information (after first screen) -->
      <div class="content-block module" style="margin-top: 2rem;">
        <div class="content-block__header">
          <h2 class="content-block__title">Our Services</h2>
        </div>
        <div class="content-block__body">
          <p>Our primary services include:</p>
          <ul>
            <li><strong>AI Visibility Audits</strong> - Comprehensive analysis of how your business appears in AI-generated answers</li>
            <li><strong>Structured Data Implementation</strong> - JSON-LD schema markup to improve AI comprehension</li>
            <li><strong>Technical SEO Optimization</strong> - Core web vitals, crawl efficiency, and indexing optimization</li>
            <li><strong>AI Citation Readiness</strong> - Content optimization for AI citation and brand mention</li>
            <li><strong>LLM Optimization</strong> - Advanced strategies for improving visibility in large language model responses</li>
          </ul>
          <p><a href="/services/">View all services →</a></p>
        </div>
      </div>
      
    </div>
  </section>
</main>

