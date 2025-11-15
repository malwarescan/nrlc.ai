<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
?>

<main role="main">
<section class="container">
    
    <!-- Services Header Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Semantic Infrastructure Services</div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">The Semantic Infrastructure for the AI Internet</h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
          NRLC provides a semantic operating layer that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.
        </p>
        <div style="text-align: center; margin-top: 2rem; display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
          <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Book a Demo</a>
          <a href="/insights/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore Research</a>
        </div>
      </div>
    </div>

    <!-- Core Platform Services -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Core Platform</div>
      </div>
      <div class="window-body">
        <div class="grid-auto-fit">
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Semantic Layer</h3>
            <p>SQL-native ontologies exposing reusable logic, metrics, hierarchies, and reasoning without introducing new languages or paradigms. Transform your data into a semantic graph where relationships are explicit and queries collapse complexity.</p>
            <a href="/services/semantic-layer/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Data Virtualization</h3>
            <p>Connect every source into a semantic, virtualized layer with no ingestion or duplication. Your data stays where it lives — NRLC makes it usable. Automatic mapping to the ontology, federated queries, and intelligent pushdown optimization.</p>
            <a href="/services/data-virtualization/" class="btn" data-ripple>Explore Data Virtualization</a>
          </div>

          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Enterprise LLM Foundation</h3>
            <p>Structured semantic context, verified relationships, and virtualized access to all data sources. LLMs become reliable once they operate on governed, contextualized, precise data. NRLC delivers that foundation.</p>
            <a href="/services/enterprise-llm-foundation/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Knowledge Graph</h3>
            <p>Interactive knowledge graph exploration with relationship traversal, insight surfacing, and natural-language query generation. Let LLMs act as your data analyst. Generate SQL or natural-language queries automatically.</p>
            <a href="/services/knowledge-graph/" class="btn" data-ripple>Explore the Knowledge Graph</a>
          </div>

          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Ontology Modeling</h3>
            <p>Rapid semantic modeling with LLM-assisted entity and metric creation. Model your business using SQL-native ontologies with up to 90% reduction in time-to-consumption. No new languages — everything in SQL.</p>
            <a href="/services/ontology-modeling/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">REST API</h3>
            <p>Your REST layer becomes semantic, self-documenting, and deeply expressive. Nested semantic fetches, field-level precision, role & row-level governance, and automatic OpenAPI/Swagger generation.</p>
            <a href="/services/rest-api/" class="btn" data-ripple>REST API Documentation</a>
          </div>

        </div>
      </div>
    </div>

    <!-- AI Capabilities -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">AI Capabilities</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">Build AI Workflows on Structured Understanding</h2>
        <p>Power AI with structured semantic context, verified relationships, virtualized access to all data sources, SQL measures, and fine-grained access control.</p>
        
        <div class="grid-auto-fit margin-top-20">
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">NL2SQL Generation</h4>
            <p>Convert natural language queries into optimized SQL using semantic understanding of your data model.</p>
          </div>
          
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">GraphRAG</h4>
            <p>Retrieval-augmented generation powered by your knowledge graph for accurate, contextual AI responses.</p>
          </div>
          
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">Graph Analytics</h4>
            <p>Analyze relationships, patterns, and insights across your entire semantic graph with powerful graph algorithms.</p>
          </div>
          
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">LLM Data Analyst</h4>
            <p>Let LLMs act as your data analyst, generating queries, surfacing insights, and answering complex questions about your data.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Integrations -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Connect Anything</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">No syncing. No lifting. No duplication.</h2>
        <p>NRLC supports universal connectivity across data platforms, BI tools, AI frameworks, and protocols.</p>
        
        <div class="grid-auto-fit margin-top-20">
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">Data Platforms</h4>
            <p>Databricks, Snowflake, Fabric, GCP, AWS, SAP HANA, data warehouses, data lakes, databases, catalogs</p>
          </div>
          
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">BI Tools</h4>
            <p>Power BI, Tableau, Looker, Qlik, Excel, Superset. Reuse metrics across BI tools without vendor lock-in.</p>
          </div>
          
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">AI/ML Frameworks</h4>
            <p>Python, LangChain, LangGraph, GraphRAG, Graph Algorithms. Native integration with modern AI tooling.</p>
          </div>
          
          <div class="box-padding">
            <h4 style="margin-top: 0; color: #000080;">Protocols</h4>
            <p>REST, SQL, JDBC/ODBC, MDX, OLAP. Standard protocols with semantic enhancements.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Solutions -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Solutions</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">Industry-Specific Semantic Solutions</h2>
        <p>Pre-built semantic models and solutions for common use cases and industries.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Intelligent Semantic Layer</h4>
            <p>Unified semantic abstraction across all your data sources.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Metrics Store</h4>
            <p>Centralized, reusable metrics with consistent definitions.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Data Mesh</h4>
            <p>Federated data architecture with semantic governance.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Data Fabric</h4>
            <p>Unified data management across hybrid and multi-cloud environments.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Digital Twin</h4>
            <p>Semantic representation of physical systems and processes.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Industry Models</h4>
            <p>FHIR, FIBO, Supply Chain, Telecom, Analytics ontologies.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Benefits -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Key Benefits</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">Why Organizations Choose NRLC</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem;">
            <h4 style="margin-top: 0; color: #000080;">90% Faster Time-to-Consumption</h4>
            <p>Rapid semantic modeling and LLM-assisted entity creation dramatically reduce implementation time.</p>
          </div>
          
          <div style="padding: 1rem;">
            <h4 style="margin-top: 0; color: #000080;">No Data Duplication</h4>
            <p>Virtualized access means your data stays where it lives. No syncing, no lifting, no duplication.</p>
          </div>
          
          <div style="padding: 1rem;">
            <h4 style="margin-top: 0; color: #000080;">SQL-Native</h4>
            <p>Everything in SQL. No new languages or paradigms to learn. Your team already knows how to use it.</p>
          </div>
          
          <div style="padding: 1rem;">
            <h4 style="margin-top: 0; color: #000080;">Enterprise-Ready</h4>
            <p>Deploy in SaaS, cloud, or on-premises. Kubernetes-ready with fine-grained governance and access control.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action Window -->
    <div class="window">
      <div class="title-bar">
        <div class="title-bar-text">Ready to Get Started?</div>
      </div>
      <div class="window-body">
        <div style="text-align: center;">
          <h2 style="color: #000080; margin-top: 0;">Build Semantic Intelligence Into Your Stack</h2>
          <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Transform your data into a semantic knowledge graph that powers reliable AI workflows. Book a demo to see how NRLC can accelerate your AI initiatives.
          </p>
          <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
            <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Book a live demo</a>
            <a href="/insights/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore Research</a>
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
    "@type" => "Service",
    "name" => "Semantic Infrastructure Platform",
    "description" => "A unified semantic layer for the AI era that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph",
    "provider" => [
      "@type" => "Organization",
      "name" => "NRLC.ai",
      "url" => "https://nrlc.ai"
    ],
    "serviceType" => "Semantic Infrastructure Platform",
    "areaServed" => "Worldwide",
    "hasOfferCatalog" => [
      "@type" => "OfferCatalog",
      "name" => "Semantic Infrastructure Services",
      "itemListElement" => [
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Semantic Layer"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Data Virtualization"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Enterprise LLM Foundation"
          ]
        ],
        [
          "@type" => "Offer",
          "itemOffered" => [
            "@type" => "Service",
            "name" => "Knowledge Graph"
          ]
        ]
      ]
    ]
  ]
];

$GLOBALS['__jsonld'] = $jsonld;
?>
