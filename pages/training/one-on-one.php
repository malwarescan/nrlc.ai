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

// Set page metadata (META DIRECTIVE KERNEL - Required format)
$GLOBALS['__page_slug'] = 'training/one-on-one';
$GLOBALS['__page_meta'] = [
  'title' => 'One-on-One AI Search Training for Operators | NRLC',
  'description' => 'Private one-on-one AI search training focused on reasoning, evaluation, and decision-making. Educational only. No execution, no optimization, no guarantees.',
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
    'name' => 'One-on-One AI Search Training',
    'url' => $canonicalUrl,
    'description' => 'Private one-on-one AI search training focused on reasoning, evaluation, and decision-making. Educational only. No execution, no optimization, no guarantees.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '/#website',
      'name' => gbp_business_name(),
      'url' => $domain
    ]
  ],
  
  // Course schema (NOT Service) - Schema description must mirror page disclaimers
  [
    '@context' => 'https://schema.org',
    '@type' => 'Course',
    '@id' => $canonicalUrl . '#course',
    'name' => 'One-on-One AI Search Training',
    'description' => 'Private one-on-one AI search training focused on reasoning, evaluation, and decision-making. Educational only. No execution, no optimization, no guarantees. Teaches how to evaluate AI search systems, review decision frameworks, and reason about visibility without performing implementation.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'educationalLevel' => 'Professional',
    'courseMode' => 'One-on-One',
    'teaches' => [
      'How to evaluate AI search system behavior',
      'How to reason about visibility through eligibility and fulfillment lenses',
      'How to review decision frameworks conceptually',
      'How to reason about changes before making them',
      'How to diagnose AI visibility issues independently',
      'How to evaluate risk before deploying changes'
    ],
    'inLanguage' => 'en',
    'url' => $canonicalUrl
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- H1: One-on-One AI Search Training -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">One-on-One AI Search Training</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">This is private, one-on-one training for operators who need a deep, practical understanding of modern search systems.</p>
          <p>Sessions are focused on reasoning, evaluation, and decision frameworks — not outsourced work or implementation.</p>
        </div>
      </div>
      
      <!-- H2 1: Training Scope -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Training Scope</h2>
        </div>
        <div class="content-block__body">
          <p>This training teaches how to evaluate AI search systems, review decision frameworks, and reason about visibility. It is education focused on understanding how systems behave, not on performing changes.</p>
          <p>Training covers:</p>
          <ul>
            <li>How AI search systems classify and retrieve information</li>
            <li>How to evaluate visibility through eligibility and fulfillment lenses</li>
            <li>How to reason about decision frameworks conceptually</li>
            <li>How to review prompts, surfaces, and outcomes without implementing fixes</li>
          </ul>
        </div>
      </div>
      
      <!-- H2 2: How Sessions Work -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">How Sessions Work</h2>
        </div>
        <div class="content-block__body">
          <p>Sessions are structured as educational instruction:</p>
          <ul>
            <li>1:1 live sessions</li>
            <li>Operator-level depth</li>
            <li>Real examples, no canned curriculum</li>
            <li>Questions driven by your environment</li>
          </ul>
          <p>Sessions walk through reasoning processes and explain how systems behave. They do not involve hands-on execution, code changes, or implementation work.</p>
        </div>
      </div>
      
      <!-- H2 3: What Is Reviewed -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What Is Reviewed</h2>
        </div>
        <div class="content-block__body">
          <p>Sessions typically involve reviewing and reasoning about:</p>
          <ul>
            <li>How AI search systems make decisions</li>
            <li>Visibility through eligibility and fulfillment lenses</li>
            <li>Prompts, surfaces, and outcomes conceptually</li>
            <li>How to reason about changes before making them</li>
          </ul>
          <p><strong>Important:</strong> Sessions focus on reviewing and reasoning, not fixing or implementing. This training teaches how to evaluate, not how to execute.</p>
        </div>
      </div>
      
      <!-- H2 4: What This Training Is Not -->
      <div class="content-block module" style="background: #fff3cd; border-left: 3px solid #ffc107; padding: var(--spacing-md);">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Training Is Not</h2>
        </div>
        <div class="content-block__body">
          <p>This training does not include:</p>
          <ul>
            <li>Hands-on execution</li>
            <li>Code changes</li>
            <li>Content production</li>
            <li>Managed optimization</li>
            <li>Ongoing retainers</li>
            <li>Audits performed on behalf of the user</li>
            <li>Performance improvements</li>
            <li>Deliverables</li>
          </ul>
          <p><strong>This section is mandatory for intent safety.</strong> This training teaches how to reason, not how to execute.</p>
        </div>
      </div>
      
      <!-- H2 5: Educational Outcomes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Educational Outcomes</h2>
        </div>
        <div class="content-block__body">
          <p>After training, participants should be able to:</p>
          <ul>
            <li>Diagnose AI visibility issues independently</li>
            <li>Evaluate risk before deploying changes</li>
            <li>Communicate search tradeoffs internally</li>
            <li>Decide when execution help is actually needed</li>
          </ul>
          <p><strong>No rankings. No traffic. No performance guarantees.</strong></p>
        </div>
      </div>
      
      <!-- H2 6: Eligibility -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Eligibility</h2>
        </div>
        <div class="content-block__body">
          <p>This training is best suited for:</p>
          <ul>
            <li>Teams already responsible for search decisions</li>
            <li>Operators with baseline SEO knowledge</li>
            <li>Organizations seeking understanding, not shortcuts</li>
          </ul>
          <p>Training is not appropriate if you are looking for:</p>
          <ul>
            <li>Someone to "fix" search performance</li>
            <li>Done-for-you optimization</li>
            <li>Guaranteed outcomes</li>
          </ul>
          <p><strong>If execution is required, that is a separate conversation.</strong></p>
        </div>
      </div>
      
      <!-- H2 7: Pricing Context -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Pricing Context</h2>
        </div>
        <div class="content-block__body">
          <p>Training is priced per session or per engagement, depending on scope.</p>
          <p><strong>Pricing reflects instructional time and preparation, not execution or implementation.</strong></p>
          <p>Team sessions and extended engagements are available by request.</p>
          <div style="margin-top: 1.5rem; padding: 1rem; background: #f8f9fa; border-left: 3px solid #6c757d;">
            <p><strong>Separation Clause:</strong> Training and execution are intentionally separate to preserve clarity and accountability.</p>
          </div>
        </div>
      </div>
      
      <!-- H2 8: Request Availability -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Request Availability</h2>
        </div>
        <div class="content-block__body">
          <p><button type="button" class="btn btn--primary" onclick="openContactSheet('One-on-One Training Availability Request')">Request Availability for One-on-One Training</button></p>
          <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">This is training, not execution. Language matters.</p>
        </div>
      </div>
      
      <!-- Final Enforcement Statement (META DIRECTIVE KERNEL - Required) -->
      <div class="content-block module" style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #ddd;">
        <div class="content-block__body">
          <p style="font-size: 0.95rem; color: #666; font-style: italic;"><strong>Language matters. This page describes training, not execution.</strong></p>
        </div>
      </div>
      
    </div>
  </section>
</main>

