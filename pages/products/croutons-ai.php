<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for product page metadata configuration
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/croutons-ai';
$GLOBALS['pageTitle'] = 'Croutons.ai | NRLC.ai';
$GLOBALS['pageDesc'] = 'Micro-fact data atomization engine that converts raw data into verifiable, machine-readable facts. AI SEO product by NRLC.ai.';

// Build comprehensive schemas
$productSlug = 'croutons-ai';
$productName = 'Croutons.ai';
$productDescription = 'Micro-fact data atomization engine converting HTML, PDFs, CSVs, NDJSON streams, and APIs into machine-verifiable truth infrastructure.';
$features = [
  'HTML to facts conversion',
  'PDF to facts parsing',
  'CSV to facts transformation',
  'NDJSON stream processing',
  'API to facts conversion',
  'Climate and census data processing',
  'Business data atomization'
];

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
  product_platform_schemas($productSlug, $productName, $productDescription, $features, 'DeveloperApplication'),
  product_dataset_schemas($productSlug, $productName, $productDescription),
  product_qapage_schema($productSlug, $productName, $productDescription),
  [product_howto_schema($productSlug, $productName)]
);

$GLOBALS['__jsonld'] = $jsonld;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Product Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Croutons.ai</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Micro-fact data atomization engine that converts raw data into verifiable, machine-readable facts.</p>
        <p>Croutons is your "knowledge substrate" — the ingestion engine that transforms unstructured and semi-structured data into a machine-verifiable truth infrastructure for search engines, LLMs, agents, and ontology builders.</p>
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> and discover related <a href="/insights/">AI SEO Research & Insights</a>. Learn more about our <a href="/tools/">SEO Tools & Resources</a>.</p>
      </div>
    </div>

    <!-- Data Sources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Data Source Support</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>HTML → Facts</h3>
            <p>Extracts structured facts from HTML documents, web pages, and online content.</p>
          </div>
          <div>
            <h3>PDFs → Facts</h3>
            <p>Parses PDF documents to extract verifiable facts and structured information.</p>
          </div>
          <div>
            <h3>CSVs → Facts</h3>
            <p>Converts tabular data into atomic facts with proper semantic relationships.</p>
          </div>
          <div>
            <h3>NDJSON Streams → Facts</h3>
            <p>Processes streaming NDJSON data into micro-facts for real-time ingestion.</p>
          </div>
          <div>
            <h3>APIs → Facts</h3>
            <p>Transforms API responses into structured, verifiable fact statements.</p>
          </div>
          <div>
            <h3>Climate, Census, Business Data → Facts</h3>
            <p>Converts government and public datasets into machine-readable micro-facts.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Value Proposition -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Croutons Matters</h2>
      </div>
      <div class="content-block__body">
        <p>Croutons.ai solves the fundamental problem of data fragmentation. By atomizing information into micro-facts, it creates a unified across all data sources. This infrastructure enables:</p>
        <ul>
          <li>Verifiable fact statements that can trust</li>
          <li>Cross-source fact linking and validation</li>
          <li>Real-time fact ingestion from streaming sources</li>
          <li>Foundation for ontological reasoning systems</li>
          <li>Machine-readable truth layer for search engines and LLMs</li>
        </ul>
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
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Croutons.ai Product Inquiry')">Schedule Consultation</button>
          <a href="/services/" class="btn">Get Started with AI SEO</a>
        </div>
      </div>
    </div>
</section>
</main>


