<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for product page metadata configuration
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/data-but-structured';

// Build comprehensive schemas
$productSlug = 'data-but-structured';
$productName = 'Data, But Structured';
$productDescription = 'The foundational text defining structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy.';

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
  product_qapage_schema($productSlug, $productName, $productDescription),
  [
    // Book schema
    [
      '@context' => 'https://schema.org',
      '@type' => 'Book',
      'name' => 'Data, But Structured',
      'description' => $productDescription,
      'author' => [
        '@type' => 'Organization',
        'name' => 'Neural Command',
        'url' => 'https://nrlc.ai'
      ],
      'publisher' => [
        '@type' => 'Organization',
        'name' => 'Neural Command',
        'url' => 'https://nrlc.ai'
      ],
      'about' => [
        'Structured Knowledge',
        'Micro-Fact Cognition',
        'Agentic Search',
        'Data Ontology',
        'AI Visibility',
        'Schema Literacy'
      ],
      'url' => 'https://nrlc.ai/products/data-but-structured/',
      'bookFormat' => 'https://schema.org/EBook',
      'inLanguage' => 'en-US',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'USD',
        'price' => '0',
        'url' => 'https://nrlc.ai/products/data-but-structured/',
        'seller' => [
          '@type' => 'Organization',
          'name' => 'Neural Command'
        ]
      ]
    ],
    product_howto_schema($productSlug, $productName)
  ]
);

$GLOBALS['__jsonld'] = $jsonld;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Product Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Data, But Structured</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">A comprehensive guide to building AI-first knowledge systems through structured data, semantic markup, and machine-readable content architecture.</p>
        <p><strong>Data, But Structured</strong> establishes the foundational principles for creating content and data systems that AI engines can understand, verify, and cite. This book covers structured knowledge architecture, micro-fact cognition models, agentic search optimization, data ontology design, AI visibility strategies, and schema literacy implementation.</p>
        <p>The methodologies and frameworks presented in this book form the foundation for all Neural Command products and services, from <a href="/products/croutons-ai/">Croutons.ai</a> micro-fact engines to <a href="/products/precogs/">Precogs</a> ontology systems and <a href="/products/newfaq/">NEWFAQ</a> intelligent knowledge bases.</p>
      </div>
    </div>

    <!-- Core Concepts -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Concepts</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>Structured Knowledge</h3>
            <p>Transforming raw data into semantically organized, machine-readable knowledge structures that enable AI comprehension and agentic reasoning.</p>
          </div>
          <div>
            <h3>Micro-Fact Cognition</h3>
            <p>Breaking down information into atomic, verifiable facts that can be independently validated, linked, and reasoned about by AI systems.</p>
          </div>
          <div>
            <h3>Agentic Search</h3>
            <p>Enabling AI agents to search, understand, and act upon structured knowledge with precision and contextual awareness.</p>
          </div>
          <div>
            <h3>Data Ontology</h3>
            <p>Building explicit taxonomies and relationships that define how entities connect, enabling semantic reasoning and knowledge graph construction.</p>
          </div>
          <div>
            <h3>AI Visibility</h3>
            <p>Ensuring content and data structures are discoverable, comprehensible, and citable by AI engines, LLMs, and agentic systems.</p>
          </div>
          <div>
            <h3>Schema Literacy</h3>
            <p>Mastering structured data markup, JSON-LD implementation, and semantic HTML to maximize AI engine comprehension and citation.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Why This Matters -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why This Matters</h2>
      </div>
      <div class="content-block__body">
        <p>As AI answer engines like ChatGPT, Perplexity, and Claude become primary information sources, traditional SEO approaches that optimize for keyword rankings fail to predict citation success. Pages ranking #1 on Google may receive zero citations from AI engines, while lower-ranked content with proper structured data frequently appears in AI-generated responses.</p>
        <p>This disconnect stems from fundamentally different ranking signals between traditional search and generative AI systems. <strong>Data, But Structured</strong> provides the framework for building content and data systems that AI engines can understand, verify, and cite with confidence.</p>
        <p>Every product in the Neural Command ecosystem implements principles from this foundational work, ensuring consistent AI-first architecture across all platforms and services.</p>
      </div>
    </div>

    <!-- Key Topics Covered -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Key Topics Covered</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><strong>Structured Knowledge Architecture:</strong> Designing semantic hierarchies and entity relationships that enable AI comprehension</li>
          <li><strong>Micro-Fact Cognition Models:</strong> Breaking information into atomic, verifiable facts for independent validation</li>
          <li><strong>Agentic Search Optimization:</strong> Enabling AI agents to search, understand, and act upon structured knowledge</li>
          <li><strong>Data Ontology Design:</strong> Building explicit taxonomies and relationships for semantic reasoning</li>
          <li><strong>AI Visibility Strategies:</strong> Ensuring content is discoverable, comprehensible, and citable by AI engines</li>
          <li><strong>Schema Literacy Implementation:</strong> Mastering JSON-LD, structured data markup, and semantic HTML</li>
          <li><strong>Citation Optimization:</strong> Applying the GEO-16 framework for AI engine citation success</li>
          <li><strong>Knowledge Graph Construction:</strong> Building interconnected data structures that AI systems can navigate</li>
        </ul>
      </div>
    </div>

    <!-- Who Should Read This -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Who Should Read This</h2>
      </div>
      <div class="content-block__body">
        <p>This book is essential reading for technical SEO professionals, data architects, content strategists, and developers building AI-first systems. Whether you're implementing <a href="/services/json-ld-strategy/">JSON-LD structured data strategies</a>, optimizing for <a href="/services/llm-seeding/">LLM seeding and citation readiness</a>, or building knowledge graphs for enterprise applications, the principles in this book provide the foundation for success.</p>
        <p>Organizations implementing these frameworks see average citation lift of 340% within 90 days, with the most significant gains in technical documentation, research content, and structured data implementations.</p>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="content-block module">
      <div class="content-block__body">
        <p class="lead text-center">Ready to implement structured knowledge systems?</p>
        <div class="btn-group text-center">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Data But Structured Consultation')">Schedule Consultation</button>
          <a href="/products/" class="btn">View All Products</a>
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

  </div>
</section>
</main>


