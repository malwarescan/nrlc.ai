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
          <h1 class="content-block__title">Training: Modern Search for Marketing Teams and Operators</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">This is training focused on modern search: SEO, AEO (AI Engine Optimization), and GEO (Generative Engine Optimization).</p>
          <p>Training is for marketing teams and operators who need to understand how modern search systems work and how to execute optimization strategies at an operator level.</p>
          <p>This is skill transfer, not delivery. You learn how to do it yourself.</p>
        </div>
      </div>
      
      <!-- What Training Covers -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What This Training Covers</h2>
        </div>
        <div class="content-block__body">
          <p>Training focuses on three core areas of modern search:</p>
          <ul>
            <li><strong>SEO (Search Engine Optimization)</strong> - Traditional search ranking and visibility</li>
            <li><strong>AEO (AI Engine Optimization)</strong> - How AI systems retrieve and cite content</li>
            <li><strong>GEO (Generative Engine Optimization)</strong> - How generative search systems work and how to optimize for them</li>
          </ul>
          <p>All training is hands-on, operator-level, and execution-aware. You learn decision frameworks, instrumentation, and how to implement strategies yourself.</p>
        </div>
      </div>
      
      <!-- Training Formats -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Training Formats</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/training/one-on-one/') ?>">One-on-One Training</a> - Individual skill transfer sessions</li>
            <li>Team Training - Group sessions for marketing teams (coming soon)</li>
            <li>Specialized Tracks - SEO, AEO, and GEO focused training (coming soon)</li>
          </ul>
        </div>
      </div>
      
      <!-- Who This Is For -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Who This Training Is For</h2>
        </div>
        <div class="content-block__body">
          <p>This training is designed for:</p>
          <ul>
            <li>Marketing teams who need to understand modern search systems</li>
            <li>Operators who execute SEO and AI visibility strategies</li>
            <li>Teams building internal search optimization capabilities</li>
            <li>Professionals who want operator-level understanding, not just concepts</li>
          </ul>
          <p>If you need someone to do the work for you, that's a service engagement. If you want to learn how to do it yourself, this is training.</p>
        </div>
      </div>
      
      <!-- Training vs Services -->
      <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; padding: var(--spacing-md);">
        <div class="content-block__body">
          <h3 style="margin-top: 0;">Training vs Services</h3>
          <p><strong>Training:</strong> We teach you how modern search works. You learn operator-level skills and decision frameworks. You implement strategies yourself.</p>
          <p><strong>Services:</strong> We execute optimization strategies for you. You get results without needing to understand the implementation details.</p>
          <p>Both offerings are available. Training is skill transfer. Services are execution. They reinforce each other without competing.</p>
        </div>
      </div>
      
      <!-- CTA -->
      <div class="content-block module">
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/training/one-on-one/') ?>" class="btn btn--primary">Learn More About One-on-One Training</a></p>
        </div>
      </div>
      
    </div>
  </section>
</main>

