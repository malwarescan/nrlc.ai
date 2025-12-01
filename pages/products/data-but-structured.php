<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/data-but-structured';
$GLOBALS['pageTitle'] = 'Data, But Structured — Foundational Book | NRLC.ai';
$GLOBALS['pageDesc'] = 'The foundational text defining structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy.';

// Build comprehensive schemas
$productSlug = 'data-but-structured';
$productName = 'Data, But Structured';
$productDescription = 'The foundational text defining structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy.';

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
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
      'inLanguage' => 'en-US'
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
        <p class="lead">The foundational text that defines your philosophy: structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy.</p>
        <p>Everything else in the ecosystem descends from this book.</p>
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
        <p>As AI becomes the primary interface for information discovery, traditional SEO approaches fall short. This book establishes the foundation for building systems that AI engines can understand, trust, and cite.</p>
        <p>Every product in the Neural Command ecosystem implements principles from this foundational work.</p>
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
</section>
</main>


