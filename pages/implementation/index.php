<?php
// Implementation / Support Page
// This page exists so that when someone already understands the problem and decides they need help, there is a place to go.
// It does not persuade. It clarifies scope.

if (!function_exists('absolute_url')) {
  require_once __DIR__.'/../../lib/helpers.php';
}

$canonicalUrl = absolute_url('/implementation/');

$GLOBALS['__jsonld'] = [
  // About / Entity Graph
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => absolute_url('/') . '#logo',
          'url' => absolute_url('/assets/images/nrlc-logo.png')
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ]
    ]
  ],
  // BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Implementation',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // Service schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'Search Infrastructure Implementation Support',
    'description' => 'Implementation support for applying generative search frameworks to large, fragile, or high-risk properties.',
    'provider' => [
      '@id' => absolute_url('/') . '#organization'
    ],
    'areaServed' => [
      '@type' => 'Country',
      'name' => 'United States'
    ],
    'serviceType' => 'Technical Consulting'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h1 class="content-block__title">Implementation</h1>
        </div>
        <div class="content-block__body">
          <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-md);">
            This site exists to document how generative and AI search systems behave when traditional SEO explanations stop working.
          </p>
          <p>
            Some organizations ask for help applying these frameworks to large, fragile, or high risk properties. This page explains what that help looks like, and what it does not.
          </p>
        </div>
      </div>

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">What Implementation Means Here</h2>
        </div>
        <div class="content-block__body">
          <p>Implementation work focuses on structural changes rather than tactics.</p>
          <p>That usually includes diagnosing why generative systems consistently suppress or exclude content, identifying failure modes that persist across fixes, and rebuilding content and structure so retrieval becomes stable rather than accidental.</p>
          <p>This is not optimization in the traditional sense. It is systems work.</p>
        </div>
      </div>

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">What We Help With</h2>
        </div>
        <div class="content-block__body">
          <p>We assist teams when internal capacity, risk tolerance, or coordination limits make this difficult to handle alone.</p>
          <p>Typical work includes:</p>
          <ul>
            <li>Diagnosing persistent AI visibility failures that do not respond to conventional SEO changes</li>
            <li>Rebuilding content architecture for generative retrieval rather than ranking</li>
            <li>Correcting schema, canonical, and internal linking patterns that cause inference instability</li>
            <li>Designing migration paths for legacy content without losing accumulated trust</li>
            <li>Establishing measurement systems for AI visibility that reflect actual retrieval behavior</li>
            <li>Stress testing sites against known generative failure modes before or after major changes</li>
          </ul>
          <p>This work usually spans content, technical SEO, structured data, and deployment workflows.</p>
        </div>
      </div>

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">What We Do Not Do</h2>
        </div>
        <div class="content-block__body">
          <p>We do not offer:</p>
          <ul>
            <li>Keyword targeting or content calendars</li>
            <li>Growth hacking or traffic guarantees</li>
            <li>Short term ranking campaigns</li>
            <li>Tool driven audits without structural follow through</li>
          </ul>
          <p>If a problem can be solved with standard SEO adjustments, this is probably not the right place.</p>
        </div>
      </div>

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">Who This Is For</h2>
        </div>
        <div class="content-block__body">
          <p>This is typically a fit when:</p>
          <ul>
            <li>Pages are indexed but never appear in AI results</li>
            <li>Visibility failures persist despite repeated fixes</li>
            <li>Search performance no longer correlates with effort</li>
            <li>The site is large, regulated, or operationally complex</li>
            <li>Internal teams need an external diagnostic lens</li>
          </ul>
          <p>If you are early stage or experimenting, the knowledge base is usually enough on its own.</p>
        </div>
      </div>

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">Engagement Shape</h2>
        </div>
        <div class="content-block__body">
          <p>Most engagements are scoped, time bounded, and diagnostic first.</p>
          <p>That often looks like:</p>
          <ul>
            <li>A focused assessment tied to specific failure conditions</li>
            <li>A concrete implementation plan</li>
            <li>Optional hands on support during rebuilds or migrations</li>
          </ul>
          <p>There are no retainers by default. There are no packages.</p>
        </div>
      </div>

      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="content-block__title">Contact</h2>
        </div>
        <div class="content-block__body">
          <p>If you believe this applies to your system, you can reach out here.</p>
          <p><button type="button" class="btn" onclick="openContactSheet('Implementation Support')">Contact</button></p>
        </div>
      </div>

    </div>
  </section>
</main>

