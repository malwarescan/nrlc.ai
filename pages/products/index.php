<?php
// Set unique metadata for products overview hub (BEFORE head.php)
$GLOBALS['__page_slug'] = 'products/index';
$GLOBALS['pageTitle'] = "AI SEO Products & Service Suite – Visibility Tools";
$GLOBALS['pageDesc'] = "Explore AI-powered SEO products and services from Neural Command. Improve search visibility, structured data accuracy, and ranking performance.";

require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
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
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> and discover related <a href="/insights/">AI SEO Research & Insights</a>. Learn more about our <a href="/tools/">SEO Tools & Resources</a>.</p>
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

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="/tools/">SEO Tools & Resources</a> for technical SEO optimization.</p>
        <div class="btn-group text-center">
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema - ItemList for Product/Service Overview Hub
require_once __DIR__ . '/../../lib/helpers.php';
$domain = 'https://nrlc.ai';
$canonicalUrl = absolute_url('/products/');

$jsonld = [
  [
    "@context" => "https://schema.org",
    "@type" => "ItemList",
    "name" => "AI SEO Products & Services",
    "description" => "Overview of Neural Command's suite of AI SEO tools and services.",
    "url" => $canonicalUrl,
    "numberOfItems" => 8,
    "itemListElement" => [
      [
        "@type" => "ListItem",
        "position" => 1,
        "name" => "Data, But Structured",
        "url" => $domain . "/products/data-but-structured/",
        "description" => "Foundational book defining structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy."
      ],
      [
        "@type" => "ListItem",
        "position" => 2,
        "name" => "Applicants.io",
        "url" => $domain . "/products/applicants-io/",
        "description" => "AI recruiting platform with JobPosting schema automation, Google Jobs indexing, resume crawling, and AI-driven applicant ranking."
      ],
      [
        "@type" => "ListItem",
        "position" => 3,
        "name" => "OurCasa.ai",
        "url" => $domain . "/products/ourcasa-ai/",
        "description" => "Home and neighborhood intelligence graph with property cognition, weather risk mapping, local incident history, and maintenance prediction."
      ],
      [
        "@type" => "ListItem",
        "position" => 4,
        "name" => "Croutons.ai",
        "url" => $domain . "/products/croutons-ai/",
        "description" => "Micro-fact data atomization engine converting HTML, PDFs, CSVs, NDJSON streams, and APIs into machine-verifiable truth infrastructure."
      ],
      [
        "@type" => "ListItem",
        "position" => 5,
        "name" => "Precogs",
        "url" => $domain . "/products/precogs/",
        "description" => "Ontological oracle intelligence engine with predictive reasoning, multi-domain cognition, temporal simulation, and real-time agentic intelligence."
      ],
      [
        "@type" => "ListItem",
        "position" => 6,
        "name" => "Googlebot Renderer Lab",
        "url" => $domain . "/products/googlebot-renderer-lab/",
        "description" => "Real Googlebot DOM simulation solving hydration failures, CSR/SSR drift, and crawl-time abort replication for modern SEO diagnostics."
      ],
      [
        "@type" => "ListItem",
        "position" => 7,
        "name" => "NEWFAQ",
        "url" => $domain . "/products/newfaq/",
        "description" => "Sentient FAQ and business intelligence engine that learns from queries, expands dynamically, and generates breakthrough SEO visibility."
      ],
      [
        "@type" => "ListItem",
        "position" => 8,
        "name" => "Neural Command OS",
        "url" => $domain . "/products/neural-command-os/",
        "description" => "Universal operating system powering agentic SEO, schema generation, authority scoring, LLM visibility modeling, and semantic linking."
      ]
    ]
  ],
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "@id" => $canonicalUrl . '#webpage',
    "name" => "AI SEO Products & Service Suite",
    "url" => $canonicalUrl,
    "description" => "Explore AI-powered SEO products and services from Neural Command. Improve search visibility, structured data accuracy, and ranking performance.",
    "isPartOf" => [
      "@type" => "WebSite",
      "@id" => $domain . '/#website',
      "name" => "NRLC.ai",
      "url" => $domain
    ]
  ],
  [
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "@id" => $canonicalUrl . '#breadcrumb',
    "itemListElement" => [
      [
        "@type" => "ListItem",
        "position" => 1,
        "name" => "Home",
        "item" => $domain . "/"
      ],
      [
        "@type" => "ListItem",
        "position" => 2,
        "name" => "Products",
        "item" => $canonicalUrl
      ]
    ]
  ]
];

$GLOBALS['__jsonld'] = $jsonld;
?>

