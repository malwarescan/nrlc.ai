<?php
/**
 * One-on-One Training Page - /training/one-on-one/
 * 
 * META DIRECTIVE: Training & Classes Offering
 * Role: High-intent educational offering (skill transfer, not delivery)
 * 
 * Allowed language:
 * - "hands-on"
 * - "operator-level"
 * - "execution-aware"
 * - "instrumentation"
 * - "decision frameworks"
 * 
 * Forbidden language:
 * - "we manage"
 * - "we optimize for you"
 * - "done-for-you"
 * - "agency"
 */

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$canonicalUrl = absolute_url('/training/one-on-one/');
$domain = absolute_url('/');

// Set page metadata
$GLOBALS['__page_slug'] = 'training/one-on-one';
$GLOBALS['__page_meta'] = [
  'title' => 'One-on-One SEO, AEO & GEO Training | Operator-Level Skill Transfer',
  'description' => 'Hands-on, operator-level one-on-one training for modern search optimization. Learn SEO, AEO, and GEO execution frameworks and decision-making processes.',
  'canonicalPath' => '/training/one-on-one/'
];

// Build JSON-LD Schema (Educational, NOT Service)
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';

$GLOBALS['__jsonld'] = [
  // Organization schema (GBP-aligned)
  ld_organization(),
  
  // BreadcrumbList
  ld_breadcrumbs(),
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'One-on-One SEO, AEO & GEO Training',
    'url' => $canonicalUrl,
    'description' => 'Hands-on, operator-level one-on-one training for modern search optimization.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '/#website',
      'name' => gbp_business_name(),
      'url' => $domain
    ]
  ],
  
  // Course schema (NOT Service)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Course',
    '@id' => $canonicalUrl . '#course',
    'name' => 'One-on-One Modern Search Optimization Training',
    'description' => 'Hands-on, operator-level one-on-one training sessions focused on SEO, AEO (AI Engine Optimization), and GEO (Generative Engine Optimization). Skill transfer for marketing teams and operators.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'educationalLevel' => 'Professional',
    'courseMode' => 'One-on-One',
    'teaches' => [
      'SEO execution frameworks',
      'AEO (AI Engine Optimization) strategies',
      'GEO (Generative Engine Optimization) implementation',
      'Operator-level decision frameworks',
      'Modern search system instrumentation',
      'Hands-on execution techniques'
    ],
    'inLanguage' => 'en',
    'url' => $canonicalUrl
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Section 1: Classifier (Above the Fold) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">One-on-One AI Search Training</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">This is private, one-on-one training for operators who need a deep, practical understanding of modern search systems.</p>
          <p>Sessions are focused on reasoning, evaluation, and execution frameworks — not outsourced work or implementation.</p>
        </div>
      </div>
      
      <!-- Section 2: Format -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Training Format</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>1:1 live sessions</li>
            <li>Operator-level depth</li>
            <li>Real examples, no canned curriculum</li>
            <li>Questions driven by your environment</li>
          </ul>
        </div>
      </div>
      
      <!-- Section 3: What Happens in Sessions -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What Happens in Sessions</h2>
        </div>
        <div class="content-block__body">
          <p>Sessions typically involve:</p>
          <ul>
            <li>Breaking down how AI search systems make decisions</li>
            <li>Auditing visibility through eligibility and fulfillment lenses</li>
            <li>Reviewing prompts, surfaces, and outcomes conceptually</li>
            <li>Teaching how to reason about changes before making them</li>
          </ul>
          <p><strong>Important:</strong> Sessions focus on reviewing and reasoning, not fixing or implementing.</p>
        </div>
      </div>
      
      <!-- Section 4: What This Is NOT (Critical - Mandatory for Intent Safety) -->
      <div class="content-block module" style="background: #fff3cd; border-left: 3px solid #ffc107; padding: var(--spacing-md);">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Is NOT (Critical)</h2>
        </div>
        <div class="content-block__body">
          <p>This training does not include:</p>
          <ul>
            <li>Hands-on execution</li>
            <li>Code changes</li>
            <li>Content production</li>
            <li>Managed optimization</li>
            <li>Ongoing retainers</li>
          </ul>
          <p><strong>This section is mandatory for intent safety.</strong></p>
        </div>
      </div>
      
      <!-- Section 5: Outcomes (Educational, Not Performance) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Outcomes (Educational, Not Performance)</h2>
        </div>
        <div class="content-block__body">
          <p>After training, participants should be able to:</p>
          <ul>
            <li>Diagnose AI visibility issues independently</li>
            <li>Evaluate risk before deploying changes</li>
            <li>Communicate search tradeoffs internally</li>
            <li>Decide when execution help is actually needed</li>
          </ul>
          <p><strong>No traffic promises. No rankings.</strong></p>
        </div>
      </div>
      
      <!-- Section 6: Eligibility (Soft Gate) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Eligibility (Soft Gate)</h2>
        </div>
        <div class="content-block__body">
          <p>This training is best suited for:</p>
          <ul>
            <li>Teams already responsible for search decisions</li>
            <li>Operators with baseline SEO knowledge</li>
            <li>Organizations seeking understanding, not shortcuts</li>
          </ul>
        </div>
      </div>
      
      <!-- Pricing & Eligibility Language (Intent-Safe) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Pricing & Eligibility</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Pricing:</strong> Training is priced per session or per engagement, depending on scope.</p>
          <p>Pricing reflects time, preparation, and instructional depth — not execution or deliverables.</p>
          <p>Team sessions and extended engagements are available by request.</p>
          
          <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #ddd;">
            <p><strong>Eligibility:</strong> Training is not appropriate if you are looking for:</p>
            <ul>
              <li>Someone to "fix" search performance</li>
              <li>Done-for-you optimization</li>
              <li>Guaranteed outcomes</li>
            </ul>
            <p><strong>If execution is required, that is a separate conversation.</strong></p>
          </div>
          
          <div style="margin-top: 1.5rem; padding: 1rem; background: #f8f9fa; border-left: 3px solid #6c757d;">
            <p><strong>Separation Clause:</strong> Training and execution are intentionally separate to preserve clarity and accountability.</p>
          </div>
        </div>
      </div>
      
      <!-- Section 7: Action -->
      <div class="content-block module">
        <div class="content-block__body">
          <p><button type="button" class="btn btn--primary" onclick="openContactSheet('One-on-One Training Availability Request')">Request Availability for One-on-One Training</button></p>
          <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Language matters. This is training, not execution.</p>
        </div>
      </div>
      
    </div>
  </section>
</main>

