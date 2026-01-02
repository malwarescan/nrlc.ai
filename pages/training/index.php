<?php
/**
 * Training Hub Page - /training/
 * 
 * META DIRECTIVE: Training & Classes Offering
 * Role: Educational offering hub (NOT sales page, NOT curriculum dump)
 * Intent: Skill transfer, not delivery
 * 
 * Must clearly state (above the fold):
 * - This is training
 * - For marketing teams and operators
 * - Focused on modern search (SEO + AEO + GEO)
 * 
 * Must NOT:
 * - Compete with service pages
 * - Promise execution outcomes
 * - Use "we'll do it for you" language
 */

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$canonicalUrl = absolute_url('/training/');
$domain = absolute_url('/');

// Set page metadata
$GLOBALS['__page_slug'] = 'training/index';
$GLOBALS['__page_meta'] = [
  'title' => 'SEO, AEO & GEO Training | Operator-Level Skill Transfer | Neural Command, LLC',
  'description' => 'Training for marketing teams and operators focused on modern search: SEO, AEO (AI Engine Optimization), and GEO (Generative Engine Optimization). Hands-on, operator-level skill transfer.',
  'canonicalPath' => '/training/'
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
    'name' => 'SEO, AEO & GEO Training',
    'url' => $canonicalUrl,
    'description' => 'Training for marketing teams and operators focused on modern search optimization.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '/#website',
      'name' => gbp_business_name(),
      'url' => $domain
    ]
  ],
  
  // EducationalOccupationalProgram (NOT Service schema)
  [
    '@context' => 'https://schema.org',
    '@type' => 'EducationalOccupationalProgram',
    '@id' => $canonicalUrl . '#program',
    'name' => 'Modern Search Optimization Training',
    'description' => 'Operator-level training for marketing teams and operators focused on SEO, AEO (AI Engine Optimization), and GEO (Generative Engine Optimization). Skill transfer for modern search systems.',
    'provider' => [
      '@type' => 'Organization',
      '@id' => $orgId
    ],
    'programType' => 'Professional Development',
    'educationalCredentialAwarded' => 'Certificate of Completion',
    'occupationalCategory' => 'Marketing and SEO',
    'teaches' => [
      'SEO (Search Engine Optimization)',
      'AEO (AI Engine Optimization)',
      'GEO (Generative Engine Optimization)',
      'Modern search system understanding',
      'Operator-level execution frameworks'
    ],
    'url' => $canonicalUrl
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- ABOVE THE FOLD: Clear Classification -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">AI Search Training for Marketing Teams</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">NRLC provides hands-on training for marketing teams and operators who need to understand how modern search systems work — including SEO, Answer Engine Optimization (AEO), and Generative Engine Optimization (GEO).</p>
          <p>This training focuses on decision frameworks, execution mechanics, and evaluation models used by AI-driven search systems. It is designed to transfer capability, not replace internal teams.</p>
        </div>
      </div>
      
      <!-- Who This Is For -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Who This Is For</h2>
        </div>
        <div class="content-block__body">
          <p>This training is for:</p>
          <ul>
            <li>In-house marketing teams</li>
            <li>Technical SEO leads</li>
            <li>Product and growth operators</li>
            <li>Agencies training internal staff</li>
          </ul>
        </div>
      </div>
      
      <!-- What This Is (Explicit) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Is (Explicit)</h2>
        </div>
        <div class="content-block__body">
          <p><strong>This is education and skill transfer.</strong></p>
          <p>We do not execute changes, manage sites, or act as an agency during training.</p>
        </div>
      </div>
      
      <!-- What This Covers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Covers (High Level, Non-Exhaustive)</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>How AI search systems classify and retrieve information</li>
            <li>Why traditional SEO signals break down in AI Overviews</li>
            <li>How AEO and GEO differ from keyword SEO</li>
            <li>How to evaluate visibility without third-party tooling</li>
            <li>How to reason about fulfillment, eligibility, and risk</li>
          </ul>
        </div>
      </div>
      
      <!-- Navigation Handoff -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Training Formats</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/training/one-on-one/') ?>">One-on-One Operator Training</a></li>
            <li>Team & Group Sessions (coming soon)</li>
          </ul>
        </div>
      </div>
      
      
    </div>
  </section>
</main>

