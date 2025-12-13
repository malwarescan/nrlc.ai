<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is loaded automatically by router before head.php is included
require_once __DIR__ . '/../../lib/csv.php';

// Load insights data
$insights = csv_read_data('insights.csv');
$featured_insights = array_slice($insights, -6); // Get last 6 insights
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Insights Header Window -->
    <div class="window module">
      <div class="title-bar">
        <div class="title-bar-text">Semantic Infrastructure Research</div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">Research & Insights on Semantic AI</h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
          Latest research and insights on semantic infrastructure, knowledge graphs, data virtualization, and building reliable AI workflows on structured understanding.
        </p>
        <div class="btn-group text-center">
          <a href="/insights/semantic-modeling/" class="btn">Learn Why Teams Adopt Semantic Modeling</a>
          <a href="/api/book/" class="btn btn--primary">Schedule Research Consultation</a>
        </div>
      </div>
    </div>

    <!-- Featured Articles Window -->
    <div class="window module">
      <div class="title-bar">
        <div class="title-bar-text">Featured Articles</div>
      </div>
      <div class="window-body">
        <div class="grid grid-auto-fit">
          
          <div class="content-block">
            <h3 class="content-block__title">Semantic Queries & Query Optimization</h3>
            <p>How semantic relationships collapse query complexity and reduce time to value. Learn how traditional SQL queries with dozens of JOINs become concise, relationship-aware logic.</p>
            <div class="btn-group">
              <a href="/insights/semantic-queries/" class="btn">Learn More About Semantic Queries</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Performance & Caching Insights</h3>
            <p>Intelligent pushdown optimization, query performance tuning, and powerful caching engines that reduce compute spend while maintaining query speed and accuracy.</p>
            <div class="btn-group">
              <a href="/insights/performance-caching/" class="btn">Performance & Caching Insights</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Why Teams Adopt Semantic Modeling</h3>
            <p>Understanding the business value of semantic infrastructure. How organizations achieve 90% reduction in time-to-consumption and enable reliable AI workflows.</p>
            <div class="btn-group">
              <a href="/insights/semantic-modeling/" class="btn" title="Read full article: Why Teams Adopt Semantic Modeling" aria-label="Read full article: Why Teams Adopt Semantic Modeling">Read Article</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Data Virtualization Best Practices</h3>
            <p>Connecting every source into a semantic, virtualized layer with no ingestion or duplication. Automatic mapping, federated queries, and unified graph views.</p>
            <div class="btn-group">
              <a href="/insights/data-virtualization/" class="btn" title="Read full article: Data Virtualization Best Practices" aria-label="Read full article: Data Virtualization Best Practices">Read Article</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Enterprise LLM Foundation</h3>
            <p>Building reliable AI workflows on structured understanding. How structured semantic context, verified relationships, and virtualized access enable trustworthy LLM operations.</p>
            <div class="btn-group">
              <a href="/insights/enterprise-llm/" class="btn" title="Read full article: Enterprise LLM Foundation" aria-label="Read full article: Enterprise LLM Foundation">Read Article</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Knowledge Graph Exploration</h3>
            <p>Interactive knowledge graph techniques for traversing relationships, surfacing insights, and generating SQL or natural-language queries automatically.</p>
            <div class="btn-group">
              <a href="/insights/knowledge-graph/" class="btn" title="Read full article: Knowledge Graph Exploration" aria-label="Read full article: Knowledge Graph Exploration">Read Article</a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Research Categories Window -->
    <div class="window module">
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
    <div class="window module">
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
              <div class="btn-group">
                <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn" title="Read full article: <?= htmlspecialchars($insight['title']) ?>" aria-label="Read full article: <?= htmlspecialchars($insight['title']) ?>">Read Article</a>
              </div>
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
          <div class="btn-group text-center">
            <a href="/api/book/" class="btn btn--primary">Schedule Research Consultation</a>
            <a href="/services/" class="btn">Explore Our Services</a>
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
