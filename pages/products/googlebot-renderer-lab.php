<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for product page metadata configuration
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/googlebot-renderer-lab';
$GLOBALS['pageTitle'] = 'Googlebot DOM Simulation Tool for SEO Diagnostic Testing';
$GLOBALS['pageDesc'] = 'Real Googlebot DOM simulation that solves the #1 problem in SEO and dev teams: why Googlebot cannot render pages even when they work fine for real peopl...';

// Build comprehensive schemas
$productSlug = 'googlebot-renderer-lab';
$productName = 'Googlebot Renderer Lab';
$productDescription = 'Real Googlebot DOM simulation solving hydration failures, CSR/SSR drift, and crawl-time abort replication for modern SEO diagnostics.';
$features = [
  'Full user-agent simulation',
  'Aggressive JS cancellation simulation',
  'Hydration mismatch detection',
  'CSR/SSR drift analysis',
  'Crawl-time abort replication',
  'DOM filmstrip rendering',
  'Crawl diagnostics for frameworks'
];

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
  product_platform_schemas($productSlug, $productName, $productDescription, $features, 'DeveloperApplication'),
  googlebot_renderer_schemas(),
  product_qapage_schema($productSlug, $productName, $productDescription),
  [product_howto_schema($productSlug, $productName, [
    [
      '@type' => 'HowToStep',
      'name' => 'Enter your URL',
      'text' => 'Enter the URL you want to test in Googlebot Renderer Lab'
    ],
    [
      '@type' => 'HowToStep',
      'name' => 'Analyze rendering',
      'text' => 'Review the DOM filmstrip and identify hydration mismatches'
    ],
    [
      '@type' => 'HowToStep',
      'name' => 'Fix issues',
      'text' => 'Address identified rendering failures and verify fixes'
    ]
  ])]
);

$GLOBALS['__jsonld'] = $jsonld;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Product Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Googlebot Renderer Lab</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Real Googlebot DOM simulation that solves the #1 problem in SEO and dev teams: why Googlebot cannot render pages even when they work fine for real people.</p>
        <p>This is essential for any enterprise struggling with modern SEO failures.</p>
      </div>
    </div>

    <!-- Capabilities -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Capabilities</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>Full User-Agent Simulation</h3>
            <p>Accurate replication of Googlebot's user-agent behavior and rendering conditions.</p>
          </div>
          <div>
            <h3>Aggressive JS Cancellation Simulation</h3>
            <p>Simulates Googlebot's aggressive JavaScript cancellation policies that can abort hydration mid-execution.</p>
          </div>
          <div>
            <h3>Hydration Mismatch Detection</h3>
            <p>Identifies discrepancies between server-rendered HTML and client-side hydration results.</p>
          </div>
          <div>
            <h3>CSR/SSR Drift Analysis</h3>
            <p>Detects differences between client-side rendering and server-side rendering outcomes.</p>
          </div>
          <div>
            <h3>Crawl-Time Abort Replication</h3>
            <p>Replicates the exact conditions where Googlebot aborts page rendering during crawl.</p>
          </div>
          <div>
            <h3>DOM Filmstrip Rendering</h3>
            <p>Visual timeline of DOM changes during rendering, showing exactly where failures occur.</p>
          </div>
          <div>
            <h3>Crawl Diagnostics for Frameworks</h3>
            <p>Framework-specific diagnostics for Next.js, React, Vue, and other modern JavaScript frameworks.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Problem Solved -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Problem It Solves</h2>
      </div>
      <div class="content-block__body">
        <p>Modern websites often pass all traditional SEO audits yet fail to rank. The issue: Googlebot sees a different page than real users. Googlebot Renderer Lab replicates Googlebot's exact rendering conditions, exposing:</p>
        <ul>
          <li>Silent hydration failures that don't appear in browser DevTools</li>
          <li>JavaScript execution aborts that leave pages incomplete</li>
          <li>DOM state mismatches between server and client rendering</li>
          <li>Framework-specific rendering issues invisible to standard tools</li>
        </ul>
        <p>This tool is essential for diagnosing why pages that look perfect to users fail to index properly.</p>
      </div>
    </div>

    <div class="content-block module">
      <div class="content-block__body">
        <div class="btn-group text-center">
          <a href="/products/" class="btn">View All Products</a>
        </div>
      </div>
    </div>

  </div>
    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="/tools/">SEO Tools & Resources</a> and view all <a href="/products/">Products</a>.</p>
        <div class="btn-group text-center">
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
        </div>
      </div>
    </div>
</section>
</main>


