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
    
    <!-- Insights Header / Intent Declaration -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI Search & Retrieval Insights</h1>
      </div>
      <div class="content-block__body">
        <p>This section contains technical analyses, research-backed explanations, and system-level insights into how AI search and answer engines extract, evaluate, and cite information.</p>
      </div>
    </div>

    <!-- Featured Analysis -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Featured Analysis</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          
          <div class="content-block">
            <h3 class="content-block__title">Semantic Queries & Query Optimization</h3>
            <p>Explains how semantic relationships collapse query complexity and reduce time to value. Technical breakdown of how traditional SQL queries with dozens of JOINs become concise, relationship-aware logic.</p>
            <div class="btn-group">
              <a href="/en-us/insights/semantic-queries/" class="btn">Read Analysis</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Performance & Caching Insights</h3>
            <p>Explains intelligent pushdown optimization, query performance tuning, and caching engines that reduce compute spend while maintaining query speed and accuracy.</p>
            <div class="btn-group">
              <a href="/en-us/insights/performance-caching/" class="btn">Read Analysis</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Data Virtualization Best Practices</h3>
            <p>Explains how to connect every source into a semantic, virtualized layer with no ingestion or duplication. Covers automatic mapping, federated queries, and unified graph views.</p>
            <div class="btn-group">
              <a href="/en-us/insights/data-virtualization/" class="btn">Read Analysis</a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Technical Breakdowns -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Technical Breakdowns</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          
          <div class="content-block">
            <h3 class="content-block__title">Enterprise LLM Foundation</h3>
            <p>Explains how to build reliable AI workflows on structured understanding. Technical analysis of structured semantic context, verified relationships, and virtualized access for trustworthy LLM operations.</p>
            <div class="btn-group">
              <a href="/en-us/insights/enterprise-llm/" class="btn">Read Analysis</a>
            </div>
          </div>

          <div class="content-block">
            <h3 class="content-block__title">Knowledge Graph Exploration</h3>
            <p>Explains interactive knowledge graph techniques for traversing relationships, surfacing insights, and generating SQL or natural-language queries automatically.</p>
            <div class="btn-group">
              <a href="/en-us/insights/knowledge-graph/" class="btn">Read Analysis</a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Research & Systems -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Research & Systems</h2>
      </div>
      <div class="content-block__body">
        <p>Technical analyses spanning multiple domains within AI search and retrieval systems, from extraction mechanics to citation behavior.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 >Semantic Layer Architecture</h4>
            <p>SQL-native ontologies, reusable logic, metrics, hierarchies, and automated reasoning across knowledge graphs.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 >Data Virtualization</h4>
            <p>Federated queries, intelligent pushdown, caching strategies, and unified graph views across all data sources.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 >AI Workflow Optimization</h4>
            <p>Building reliable LLM workflows, GraphRAG implementation, NL2SQL generation, and structured semantic context for AI.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 >Query Performance</h4>
            <p>Semantic query optimization, relationship-aware logic, query complexity reduction, and performance tuning strategies.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Additional Insights -->
    <?php if (!empty($featured_insights)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Additional Insights</h2>
      </div>
      <div class="content-block__body">
        <ul style="list-style: none; padding: 0;">
          <?php foreach (array_reverse($featured_insights) as $insight): ?>
            <li style="padding: 1rem 0; border-bottom: 1px solid #e0e0e0;">
              <h3 class="content-block__title" >
                <a href="/en-us/insights/<?= htmlspecialchars($insight['slug']) ?>/" style="text-decoration: none; color: inherit;">
                  <?= htmlspecialchars($insight['title']) ?>
                </a>
              </h3>
              <?php if (!empty($insight['excerpt'])): ?>
                <p style="margin: 0 0 0.5rem 0; font-size: 0.9375rem;">
                  <?= htmlspecialchars($insight['excerpt']) ?>
                </p>
              <?php elseif (!empty($insight['keywords'])): ?>
                <p style="margin: 0 0 0.5rem 0; font-size: 0.9375rem;">
                  <?= htmlspecialchars(substr($insight['keywords'], 0, 150)) ?>
                </p>
              <?php endif; ?>
              <a href="/en-us/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn" style="display: inline-block;">Read Analysis</a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php endif; ?>


  </div>
</section>
</main>

<?php
// JSON-LD schemas are generated by base_schemas() in templates/head.php
// Insights hub ONLY includes: Organization (reused), WebSite + SearchAction (reused), BreadcrumbList
// FORBIDDEN on hub: Blog, Article, BlogPosting, FAQPage, Product, JobPosting, Event, HowTo, Review, ItemList carousel
// Do not add inline schemas here - all schemas must come from base_schemas() for consistency
?>
