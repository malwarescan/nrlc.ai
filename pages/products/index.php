<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';

$GLOBALS['__page_slug'] = 'products/index';
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Products Header Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Products</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Complete product ecosystem for structured knowledge, AI visibility, and agentic intelligence.</p>
      </div>
    </div>

    <!-- Products Grid -->
    <div class="content-block module">
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          
          <!-- Data, But Structured -->
          <div class="content-block">
            <h3 class="content-block__title">Data, But Structured</h3>
            <p>Foundational book defining structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy.</p>
            <div class="btn-group">
              <a href="/products/data-but-structured/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- Applicants.io -->
          <div class="content-block">
            <h3 class="content-block__title">Applicants.io</h3>
            <p>AI recruiting platform with JobPosting schema automation, Google Jobs indexing, resume crawling, and AI-driven applicant ranking.</p>
            <div class="btn-group">
              <a href="/products/applicants-io/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- OurCasa.ai -->
          <div class="content-block">
            <h3 class="content-block__title">OurCasa.ai</h3>
            <p>Home and neighborhood intelligence graph with property cognition, weather risk mapping, local incident history, and maintenance prediction.</p>
            <div class="btn-group">
              <a href="/products/ourcasa-ai/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- Croutons.ai -->
          <div class="content-block">
            <h3 class="content-block__title">Croutons.ai</h3>
            <p>Micro-fact data atomization engine converting HTML, PDFs, CSVs, NDJSON streams, and APIs into machine-verifiable truth infrastructure.</p>
            <div class="btn-group">
              <a href="/products/croutons-ai/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- Precogs -->
          <div class="content-block">
            <h3 class="content-block__title">Precogs</h3>
            <p>Ontological oracle intelligence engine with predictive reasoning, multi-domain cognition, temporal simulation, and real-time agentic intelligence.</p>
            <div class="btn-group">
              <a href="/products/precogs/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- Googlebot Renderer Lab -->
          <div class="content-block">
            <h3 class="content-block__title">Googlebot Renderer Lab</h3>
            <p>Real Googlebot DOM simulation solving hydration failures, CSR/SSR drift, and crawl-time abort replication for modern SEO diagnostics.</p>
            <div class="btn-group">
              <a href="/products/googlebot-renderer-lab/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- NEWFAQ -->
          <div class="content-block">
            <h3 class="content-block__title">NEWFAQ</h3>
            <p>Sentient FAQ and business intelligence engine that learns from queries, expands dynamically, and generates breakthrough SEO visibility.</p>
            <div class="btn-group">
              <a href="/products/newfaq/" class="btn">Learn More</a>
            </div>
          </div>

          <!-- Neural Command OS -->
          <div class="content-block">
            <h3 class="content-block__title">Neural Command OS</h3>
            <p>Universal operating system powering agentic SEO, schema generation, authority scoring, LLM visibility modeling, and semantic linking.</p>
            <div class="btn-group">
              <a href="/products/neural-command-os/" class="btn">Learn More</a>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema
$jsonld = [
  [
    "@context" => "https://schema.org",
    "@type" => "CollectionPage",
    "name" => "Products",
    "description" => "Complete product ecosystem for structured knowledge, AI visibility, and agentic intelligence",
    "url" => "https://nrlc.ai/products/",
    "mainEntity" => [
      "@type" => "ItemList",
      "itemListElement" => [
        ["@type" => "ListItem", "position" => 1, "item" => ["@type" => "Book", "name" => "Data, But Structured"]],
        ["@type" => "ListItem", "position" => 2, "item" => ["@type" => "SoftwareApplication", "name" => "Applicants.io"]],
        ["@type" => "ListItem", "position" => 3, "item" => ["@type" => "SoftwareApplication", "name" => "OurCasa.ai"]],
        ["@type" => "ListItem", "position" => 4, "item" => ["@type" => "SoftwareApplication", "name" => "Croutons.ai"]],
        ["@type" => "ListItem", "position" => 5, "item" => ["@type" => "SoftwareApplication", "name" => "Precogs"]],
        ["@type" => "ListItem", "position" => 6, "item" => ["@type" => "SoftwareApplication", "name" => "Googlebot Renderer Lab"]],
        ["@type" => "ListItem", "position" => 7, "item" => ["@type" => "SoftwareApplication", "name" => "NEWFAQ"]],
        ["@type" => "ListItem", "position" => 8, "item" => ["@type" => "SoftwareApplication", "name" => "Neural Command OS"]]
      ]
    ]
  ]
];

$GLOBALS['__jsonld'] = $jsonld;
?>

