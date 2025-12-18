<?php
// Metadata is now set by the router via sudo_meta_directive_ctx()
// See bootstrap/router.php lines 64-76 for homepage metadata configuration
// Note: head.php and header.php are already included by router.php render_page()
// Do not set $GLOBALS['pageTitle'] or $GLOBALS['pageDesc'] here - they are ignored

require_once __DIR__ . '/../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/');
$domain = absolute_url('/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- HERO SECTION -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h1 class="content-block__title">Search Visibility Isn't Enough Anymore. AI Systems Decide What Gets Cited.</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-md);">
          We help brands turn search authority into AI citations across Google AI Overviews, ChatGPT, and emerging answer engines.
        </p>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-sm);">
          Led by Joel Maldonado - 20+ years in search, structured data, and algorithmic visibility.
        </p>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-lg);">
          Serving companies across the United States and United Kingdom, with proven results in competitive local and international markets.
        </p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Free AI Visibility Audit (US & UK)')">Free AI Visibility Audit (US & UK)</button>
          <a href="#authority-explanation" class="btn btn--secondary">Why Traditional SEO Stops Working</a>
        </div>
      </div>
    </div>

    <!-- AUTHORITY EXPLANATION BLOCK -->
    <div class="content-block module" id="authority-explanation" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Decide What to Cite</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems do not rank pages the way search engines do. They extract entities, relationships, and evidence. When an AI system needs to answer a question, it evaluates which sources provide clear, structured, and trustworthy information that can be safely summarized and cited.</p>
        <p>Traditional SEO optimizes for crawling and ranking. It measures success by position in search results and traffic volume. This approach assumes that appearing in search results is sufficient for visibility. It is not.</p>
        <p>Pages without structured authority signals are invisible to AI answers. When AI systems cannot confidently extract what your business does, how it operates, or why it should be trusted, they default to sources that provide these signals clearly.</p>
        <p>NRLC.ai engineers content specifically for AI extraction, trust, and reuse. We structure pages so AI systems can confidently understand your business, map your expertise, and cite you when answering relevant questions.</p>
        <p><strong>This is the gap between ranking and being referenced.</strong></p>
      </div>
    </div>

    <!-- COMPARISON BLOCK -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">The Difference</h2>
      </div>
      <div class="content-block__body">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-md);">
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 style="margin-top: 0;">Traditional SEO Agencies</h3>
            <ul>
              <li>Optimize pages for keywords</li>
              <li>Focus on rankings and traffic</li>
              <li>Measure success by impressions and clicks</li>
              <li>Assume AI systems behave like search engines</li>
            </ul>
          </div>
          <div style="border: 1px solid #4a90e2; padding: var(--spacing-md); border-radius: 4px; background: #f0f7ff;">
            <h3 style="margin-top: 0; color: #4a90e2;">NRLC.ai</h3>
            <ul>
              <li>Engineer entities and relationships</li>
              <li>Optimize for AI citation and reuse</li>
              <li>Measure success by AI visibility and reference frequency</li>
              <li>Design content for LLM extraction and trust scoring</li>
            </ul>
          </div>
        </div>
        <style>
          @media (min-width: 768px) {
            .content-block__body > div[style*="grid-template-columns"] {
              grid-template-columns: 1fr 1fr !important;
            }
          }
        </style>
      </div>
    </div>

    <!-- AUTHORITATIVE VOICE INSERT (JOEL MALDONADO) -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8); border-left: 3px solid #4a90e2; padding-left: var(--spacing-md);">
      <div class="content-block__header">
        <h2 class="content-block__title">Why I Built This System</h2>
      </div>
      <div class="content-block__body">
        <p>Modern visibility failures aren't due to "bad SEO." They happen because the web is now read by machines that require structure, evidence, and consistency - and most sites were never built for that.</p>
        <p>When Google AI Overviews or ChatGPT needs to answer a question, it doesn't rank pages. It evaluates which sources provide information that can be extracted, verified, and cited safely. If your site doesn't provide these signals clearly, AI systems won't reference you, regardless of your search rankings.</p>
        <p>This system exists to bridge that gap. We turn search authority into AI citations by engineering content for machine comprehension, not just human readability.</p>
        <p style="margin-top: var(--spacing-lg); font-style: italic;">
          - Joel Maldonado<br>
          <span style="font-size: 0.9rem; color: #666;">Founder, Neural Command LLC</span>
        </p>
      </div>
    </div>

    <!-- SERVICE POSITIONING BLOCK -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Actually Do</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Audit how AI systems currently interpret your brand</li>
          <li>Identify missing or broken authority signals</li>
          <li>Rebuild pages for AI extraction, not just rankings</li>
          <li>Monitor AI visibility across answer engines</li>
          <li>Continuously adapt as models and policies change</li>
        </ul>
        <p style="margin-top: var(--spacing-md); padding: var(--spacing-md); background: #f9f9f9; border-left: 3px solid #4a90e2;">
          <strong>This is not a tool. It's an engineered service.</strong>
        </p>
      </div>
    </div>

    <!-- FINAL CTA -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__body">
        <p class="lead" style="margin-bottom: var(--spacing-md);">
          See how AI systems currently interpret your brand and what needs to change.
        </p>
        <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
          <button type="button" class="btn" onclick="openContactSheet('AI Visibility Analysis')">See How AI Sees Your Brand</button>
          <a href="/services/" class="btn btn--secondary">View Services</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// Homepage-specific JSON-LD: Person (Joel Maldonado) + Organization with founder relationship
require_once __DIR__ . '/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

// Use consistent base URL with /en-us/ prefix to match Organization schema
$baseUrl = SchemaFixes::ensureHttps(absolute_url('/en-us/'));
$joelPersonId = $baseUrl . '#joel-maldonado';
$orgId = $baseUrl . '#organization';

// Add Person schema for Joel Maldonado
$GLOBALS['__jsonld'] = $GLOBALS['__jsonld'] ?? [];
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Person',
  '@id' => $joelPersonId,
  'name' => 'Joel Maldonado',
  'description' => 'Founder of Neural Command LLC. 20+ years in search, structured data, and algorithmic visibility. Expert in AI visibility, structured data strategy, and SEO to AI citation transition.',
  'jobTitle' => 'Founder',
  'worksFor' => [
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => 'Neural Command LLC'
  ],
  'url' => $baseUrl,
  'sameAs' => [
    'https://www.linkedin.com/company/neural-command/'
  ]
];

// Update Organization schema to include founder
// This will be merged with base schemas in head.php
$GLOBALS['__homepage_org_founder'] = [
  '@type' => 'Person',
  '@id' => $joelPersonId,
  'name' => 'Joel Maldonado'
];
?>




