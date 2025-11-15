<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/csv.php';

// Load insights data
$insights = csv_read_data('insights.csv');
$featured_insights = array_slice($insights, -6); // Get last 6 insights
?>

<main role="main">
<section class="container">
    
    <!-- Insights Header Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Semantic Infrastructure Research</div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">Research & Insights on Semantic AI</h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
          Latest research and insights on semantic infrastructure, knowledge graphs, data virtualization, and building reliable AI workflows on structured understanding.
        </p>
        <div style="text-align: center; margin-top: 2rem; display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
          <a href="/insights/semantic-modeling/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Learn Why Teams Adopt Semantic Modeling</a>
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
            <h3 style="margin-top: 0; color: #000080;">Semantic Queries & Query Optimization</h3>
            <p>How semantic relationships collapse query complexity and reduce time to value. Learn how traditional SQL queries with dozens of JOINs become concise, relationship-aware logic.</p>
            <a href="/insights/semantic-queries/" class="btn" data-ripple>Learn More About Semantic Queries</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Performance & Caching Insights</h3>
            <p>Intelligent pushdown optimization, query performance tuning, and powerful caching engines that reduce compute spend while maintaining query speed and accuracy.</p>
            <a href="/insights/performance-caching/" class="btn" data-ripple>Performance & Caching Insights</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Why Teams Adopt Semantic Modeling</h3>
            <p>Understanding the business value of semantic infrastructure. How organizations achieve 90% reduction in time-to-consumption and enable reliable AI workflows.</p>
            <a href="/insights/semantic-modeling/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Data Virtualization Best Practices</h3>
            <p>Connecting every source into a semantic, virtualized layer with no ingestion or duplication. Automatic mapping, federated queries, and unified graph views.</p>
            <a href="/insights/data-virtualization/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Enterprise LLM Foundation</h3>
            <p>Building reliable AI workflows on structured understanding. How structured semantic context, verified relationships, and virtualized access enable trustworthy LLM operations.</p>
            <a href="/insights/enterprise-llm/" class="btn" data-ripple>Read Article</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Knowledge Graph Exploration</h3>
            <p>Interactive knowledge graph techniques for traversing relationships, surfacing insights, and generating SQL or natural-language queries automatically.</p>
            <a href="/insights/knowledge-graph/" class="btn" data-ripple>Read Article</a>
          </div>

        </div>
      </div>
    </div>

    <!-- Research Categories Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Research Categories</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">Comprehensive Semantic Infrastructure Research</h2>
        <p>Our research spans multiple domains within semantic infrastructure, from ontology modeling to AI workflow optimization. Each category represents a critical aspect of building reliable AI systems on structured data.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Semantic Layer Architecture</h4>
            <p>SQL-native ontologies, reusable logic, metrics, hierarchies, and automated reasoning across knowledge graphs.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Data Virtualization</h4>
            <p>Federated queries, intelligent pushdown, caching strategies, and unified graph views across all data sources.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">AI Workflow Optimization</h4>
            <p>Building reliable LLM workflows, GraphRAG implementation, NL2SQL generation, and structured semantic context for AI.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Query Performance</h4>
            <p>Semantic query optimization, relationship-aware logic, query complexity reduction, and performance tuning strategies.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Latest Insights Feed -->
    <?php if (!empty($featured_insights)): ?>
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Latest Research & Insights</div>
      </div>
      <div class="window-body">
        <div class="list-view">
          <?php foreach (array_reverse($featured_insights) as $insight): ?>
            <div class="list-item" style="padding: 0.5rem; border-bottom: 1px solid #ccc;">
              <h4 style="margin: 0 0 0.5rem 0; color: #000080;">
                <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" style="text-decoration: none; color: inherit;">
                  <?= htmlspecialchars($insight['title']) ?>
                </a>
              </h4>
              <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem;">
                <?= htmlspecialchars(substr($insight['keywords'] ?? '', 0, 100)) ?>...
              </p>
              <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn" data-ripple style="font-size: 0.8rem;">Read Article</a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Call to Action Window -->
    <div class="window">
      <div class="title-bar">
        <div class="title-bar-text">Stay Updated</div>
      </div>
      <div class="window-body">
        <div style="text-align: center;">
          <h2 style="color: #000080; margin-top: 0;">Join the Semantic Infrastructure Research Community</h2>
          <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Get the latest insights on semantic infrastructure, knowledge graphs, and building reliable AI workflows. Our research-driven approach ensures you stay ahead of evolving best practices and optimization opportunities.
          </p>
          <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
            <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Schedule Research Consultation</a>
            <a href="/services/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore Our Services</a>
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
    "@type" => "Blog",
    "name" => "Semantic Infrastructure Research",
    "description" => "Latest research and insights on semantic infrastructure, knowledge graphs, data virtualization, and building reliable AI workflows",
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
