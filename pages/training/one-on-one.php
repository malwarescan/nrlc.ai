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
      
      <!-- ABOVE THE FOLD: Clear Classification -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">One-on-One Training: Modern Search for Operators</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Hands-on, operator-level one-on-one training focused on SEO, AEO, and GEO.</p>
          <p>This is skill transfer, not delivery. You learn execution frameworks, decision-making processes, and instrumentation techniques for modern search optimization.</p>
        </div>
      </div>
      
      <!-- What You Learn -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">What You Learn</h2>
        </div>
        <div class="content-block__body">
          <p>One-on-one training covers:</p>
          <ul>
            <li><strong>Execution Frameworks</strong> - How to implement SEO, AEO, and GEO strategies at an operator level</li>
            <li><strong>Decision Frameworks</strong> - How to make optimization decisions based on data and system understanding</li>
            <li><strong>Instrumentation</strong> - How to measure and track modern search performance</li>
            <li><strong>Hands-On Techniques</strong> - Practical implementation methods you can use immediately</li>
            <li><strong>System Understanding</strong> - How modern search systems (traditional SEO, AI engines, generative search) actually work</li>
          </ul>
          <p>All training is execution-aware and operator-level. You learn how to do the work yourself.</p>
        </div>
      </div>
      
      <!-- Training Format -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Training Format</h2>
        </div>
        <div class="content-block__body">
          <p>One-on-one training sessions are:</p>
          <ul>
            <li><strong>Individual</strong> - Focused on your specific needs and questions</li>
            <li><strong>Hands-On</strong> - Practical exercises and real-world scenarios</li>
            <li><strong>Operator-Level</strong> - Execution-focused, not just concepts</li>
            <li><strong>Flexible</strong> - Tailored to your current skill level and goals</li>
          </ul>
          <p>Sessions can cover specific topics (SEO, AEO, or GEO) or provide comprehensive training across all three areas.</p>
        </div>
      </div>
      
      <!-- Who This Is For -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title">Who This Training Is For</h2>
        </div>
        <div class="content-block__body">
          <p>One-on-one training is designed for:</p>
          <ul>
            <li>Marketing operators who execute search optimization strategies</li>
            <li>Team members building internal SEO and AI visibility capabilities</li>
            <li>Professionals who want hands-on, operator-level understanding</li>
            <li>Individuals who prefer personalized, focused learning</li>
          </ul>
          <p>If you need someone to execute strategies for you, that's a service engagement. If you want to learn how to execute them yourself, this is training.</p>
        </div>
      </div>
      
      <!-- Training vs Services -->
      <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; padding: var(--spacing-md);">
        <div class="content-block__body">
          <h3 style="margin-top: 0;">Training vs Services</h3>
          <p><strong>Training:</strong> We teach you how to execute modern search optimization. You learn operator-level skills, decision frameworks, and instrumentation. You implement strategies yourself.</p>
          <p><strong>Services:</strong> We execute optimization strategies for you. You get results without needing to understand implementation details.</p>
          <p>Both are available. Training is skill transfer. Services are execution. They work together without competing.</p>
        </div>
      </div>
      
      <!-- CTA -->
      <div class="content-block module">
        <div class="content-block__body">
          <p><button type="button" class="btn btn--primary" onclick="openContactSheet('One-on-One Training Inquiry')">Inquire About One-on-One Training</button></p>
          <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Learn operator-level skills for modern search optimization</p>
        </div>
      </div>
      
    </div>
  </section>
</main>

