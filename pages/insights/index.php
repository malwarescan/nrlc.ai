<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/csv.php';

// Load insights data
$insights = csv_read_data('insights.csv');
$featured_insights = array_slice($insights, -6); // Get last 6 insights
?>

<section class="container">
    
    <!-- Insights Header Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">SEO Insights & Research</div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">AI-First SEO Research</h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
          Latest research and insights on AI-first SEO, crawl optimization, and LLM seeding. Stay ahead of the curve with our comprehensive analysis of search engine evolution.
        </p>
        <div style="text-align: center; margin-top: 2rem; display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
          <a href="/insights/geo16-framework/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore GEO-16 Framework</a>
          <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Schedule Research Consultation</a>
        </div>
      </div>
    </div>

    <!-- Featured Articles Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Featured Articles</div>
      </div>
      <div class="window-body">
        <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
          
          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">GEO-16 Framework Introduction</h3>
            <p>Understanding the sixteen-pillar model that defines on-page and off-page signals increasing AI engine citation likelihood. Based on comprehensive research analyzing 1,700 citations across four major AI engines.</p>
            <a href="/insights/geo16-introduction/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">LLM Ontology Generation</h3>
            <p>How large language models build ontologies and schema graphs for better content understanding. Explore the intersection of AI comprehension and structured data optimization.</p>
            <a href="/insights/llm-ontology-generation/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Semantic SEO in News Media</h3>
            <p>How publishers use structured metadata for semantic SEO in news media. Learn advanced techniques for optimizing content for both traditional search and AI-powered systems.</p>
            <a href="/insights/semantic-seo-in-news/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">OCR++ Data Ingestion</h3>
            <p>Advanced OCR and AI data extraction techniques for turning PDFs into structured data pipelines. Transform unstructured content into AI-readable formats.</p>
            <a href="/insights/ocrplus-data-ingestion/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Semantic Drift Tracking</h3>
            <p>Tracking topic drift in AI citations and maintaining content relevance over time. Understand how AI engines evolve their understanding of your content.</p>
            <a href="/insights/semantic-drift-tracking/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Open Source SEO Tools</h3>
            <p>Curated list of open-source SEO tools you can actually use. Discover powerful tools for AI-first SEO optimization and structured data implementation.</p>
            <a href="/insights/open-seo-tools/" class="btn" data-ripple>Read Article</a>
          </div>

        </div>
      </div>
    </div>

    <!-- Research Methodology Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Our Research Methodology</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">Evidence-Based AI SEO Research</h2>
        <p>Our research methodology combines academic rigor with practical implementation to deliver actionable insights for AI-first SEO optimization.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">1. Data Collection</h4>
            <p>Systematic collection of AI engine citations, structured data implementations, and performance metrics across diverse industries.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">2. Analysis Framework</h4>
            <p>Application of the GEO-16 framework to identify patterns and correlations between technical implementation and AI engine performance.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">3. Validation Testing</h4>
            <p>Rigorous testing of hypotheses through controlled experiments and real-world implementation across client projects.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">4. Publication & Updates</h4>
            <p>Regular publication of findings with ongoing updates as AI engines evolve and new patterns emerge in search behavior.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action Window -->
    <div class="window">
      <div class="title-bar">
        <div class="title-bar-text">Stay Updated</div>
      </div>
      <div class="window-body">
        <div style="text-align: center;">
          <h2 style="color: #000080; margin-top: 0;">Join the AI SEO Research Community</h2>
          <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Get the latest insights on AI-first SEO optimization and join forward-thinking businesses preparing for the future of search.
          </p>
          <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
            <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Schedule Research Consultation</a>
            <a href="/services/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore Our Services</a>
          </div>
        </div>
      </div>
    </div>

</section>

<?php
// JSON-LD Schema
$jsonld = [
  [
    "@context" => "https://schema.org",
    "@type" => "Blog",
    "name" => "AI-First SEO Research",
    "description" => "Latest research and insights on AI-first SEO, crawl optimization, and LLM seeding",
    "publisher" => [
      "@type" => "Organization",
      "name" => "NRLC.ai",
      "url" => "https://nrlc.ai"
    ],
    "url" => "https://nrlc.ai/insights/",
    "inLanguage" => "en"
  ]
];

$GLOBALS['__jsonld'] = $jsonld;
?>
