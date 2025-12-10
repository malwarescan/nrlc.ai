<?php
// Set unique metadata for homepage
$GLOBALS['pageTitle'] = "GEO-16 Framework Research for AI Overviews & Citations";
$GLOBALS['pageDesc'] = "AI SEO research using the GEO-16 framework. Optimize for Google AI Overviews, improve LLM citations, increase AI visibility. Structured data and technical SEO.";

require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/csv.php';

// Load latest insights
$insights = csv_read_data('insights.csv');
$latest_insights = array_slice($insights, -4); // Get last 4 insights
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Prompt Surface Intelligence Hero Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">See What Prompts Your Website Actually Surfaces For</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">
          Search has shifted to AI-driven prompts, rewrites, and intent modeling. Prompt Surface Intelligence reveals the real conversational inputs—proto-prompts, AI rewrites, and semantic variants—that determine whether your site appears in Google AI Overviews, ChatGPT, Claude, and Perplexity.
        </p>
        <div class="btn-group">
          <a href="/products/prompt-surface-intelligence/" class="btn btn--primary">View Product</a>
          <button type="button" class="btn" onclick="openContactSheet('Prompt Surface Intelligence Audit')">Request Audit</button>
        </div>
      </div>
    </div>

    <!-- LLMs.txt Hero Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Google's LLMs.txt Decoded. Your New Edge in AI SEO.</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">
          Google publicly revealed the documentation it trains its large language models on — a complete blueprint of how Search is meant to be understood. We turn that blueprint into executable AI SEO strategy, structured-data engineering, and technical implementation your competitors will never see coming.
        </p>
        <p>
          If Google teaches LLMs how Search works, we teach your site how to speak Google's language — structurally, semantically, and at scale.
        </p>
        <div class="btn-group">
          <a href="/insights/google-llms-txt-ai-seo/" class="btn btn--primary">Unlock the LLMs.txt Strategy</a>
          <a href="/services/ai-overview-optimization/" class="btn">See How AI SEO Actually Works</a>
        </div>
        <p style="margin-top: var(--spacing-24); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase; opacity: 0.7;">
          Structured data. Technical SEO. Agentic visibility. Built from the same docs Google feeds into its own models.
        </p>
      </div>
    </div>

    <!-- Unified Semantic Layer -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Unified Semantic Layer System</h2>
        </div>
      <div class="content-block__body">
        <p class="lead">Tool stitching fails. Raw table interpretation fails. Bespoke pipelines fail.</p>
        <p>Transform databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph. Use ontologies, SQL reasoning, and automated relationships.</p>
        <h3>Core Philosophy</h3>
        <p>Data requires semantic structure before it becomes queryable knowledge. Structure precedes query.</p>
        <h3>Workflow</h3>
        <p>Map sources to ontology. Establish relationships. Enable graph queries.</p>
        <div class="btn-group">
          <a href="/services/" class="btn">System Documentation</a>
        </div>
      </div>
    </div>

    <!-- Think in Concepts -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Concept Abstraction System</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Data complexity requires abstraction. This system converts tables into objects, relationships, metrics, and logical rules.</p>
        <h3>Patterns</h3>
        <p>Structured data → semantic graph. JOIN complexity → relationship-aware queries. Raw sources → connected concepts. Manual governance → automated enforcement.</p>
        <h3>Anti-Patterns</h3>
        <p>Direct table access. JOIN-heavy queries. Bespoke data pipelines. Manual relationship management.</p>
        <div class="btn-group">
          <a href="/services/" class="btn">Implementation Guide</a>
        </div>
      </div>
    </div>

    <!-- Semantic Layer Re-engineered -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Semantic Layer, Re-engineered for AI</h2>
        </div>
      <div class="content-block__body">
        <p class="lead">Model your business using SQL-native ontologies, exposing reusable logic, metrics, hierarchies, and reasoning without introducing new languages or paradigms.</p>
        <p><strong>Core capabilities:</strong> Semantic representation of every entity. Explicit relationships replacing JOIN complexity. Business logic encoded into reusable rules. Hierarchies, classifications, inheritance. Automated reasoning across the entire graph.</p>
        <div class="btn-group">
          <a href="/insights/" class="btn">Learn why teams adopt semantic modeling</a>
        </div>
      </div>
    </div>

    <!-- Build AI Workflows -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Build AI Workflows on Structured Understanding</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">LLMs become reliable once they operate on governed, contextualized, precise data. NRLC delivers that foundation.</p>
        <p><strong>Power AI with:</strong> Structured semantic context. Verified relationships. Virtualized access to all data sources. SQL measures and reusable metrics. Fine-grained access control.</p>
        <div class="btn-group">
          <a href="/services/" class="btn">Enterprise LLM Foundation Overview</a>
        </div>
      </div>
    </div>

    <!-- Simplify Data Path -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Simplify the Entire Path from Data → Insight</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">NRLC connects every source into a semantic, virtualized layer with no ingestion or duplication. Your data stays where it lives — NRLC makes it usable.</p>
        <p><strong>Benefits:</strong> Automatic mapping to the ontology. Federated queries across clouds and databases. Intelligent pushdown + query optimization. Powerful caching engine that reduces compute spend. Unified graph view across all sources.</p>
        <div class="btn-group">
          <a href="/services/data-mapping/" class="btn">See how data is mapped</a>
          <a href="/services/data-virtualization/" class="btn">Explore data virtualization</a>
          <a href="/insights/" class="btn">Performance & caching insights</a>
        </div>
      </div>
          </div>

    <!-- Connect Anything -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Connect Anything</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">No syncing. No lifting. No duplication.</p>
        <p><strong>Supported universally:</strong></p>
        <div class="grid grid-auto-fit">
          <div>
            <h4>Data Platforms</h4>
            <p>Data warehouses. Data lakes. Databases. Catalogs.</p>
          </div>
          <div>
            <h4>BI Tools</h4>
            <p>Power BI. Tableau. Looker. Qlik.</p>
          </div>
          <div>
            <h4>AI Frameworks</h4>
            <p>Python. LangChain. LangGraph. GraphRAG.</p>
          </div>
          <div>
            <h4>Protocols</h4>
            <p>REST, SQL. JDBC, ODBC. OLAP, MDX.</p>
          </div>
        </div>
        <div class="btn-group">
          <a href="/services/" class="btn">View all integrations</a>
        </div>
      </div>
      </div>

    <!-- Power Applications With Smart REST -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Power Applications With Smart REST</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Your REST layer becomes semantic, self-documenting, and deeply expressive.</p>
        <p><strong>Capabilities:</strong> Nested semantic fetches. Field-level precision. Role & row-level governance. Reduced network payload. Automatic OpenAPI/Swagger generation.</p>
        <div class="btn-group">
          <a href="/services/rest-api/" class="btn">REST API Documentation</a>
        </div>
      </div>
    </div>

    <!-- Accelerated Analytics -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Accelerated Analytics</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Semantic relationships collapse query complexity and reduce time to value.</p>
        <div class="content-block content-block--highlighted">
          <p><strong>Example</strong></p>
          <p><strong>Traditional SQL:</strong> 22 lines</p>
          <p><strong>Semantic SQL:</strong> 6 lines</p>
        </div>
        <div class="btn-group">
          <a href="/insights/" class="btn">Learn more about semantic queries</a>
        </div>
      </div>
    </div>

    <!-- Interactive Knowledge Graph -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Interactive Knowledge Graph Exploration</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Traverse relationships. Surface insights. Generate SQL or natural-language queries. Let LLMs act as your data analyst.</p>
        <div class="btn-group">
          <a href="/services/" class="btn">Explore the Knowledge Graph</a>
        </div>
      </div>
            </div>

    <!-- Decouple BI -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Decouple BI From Raw Data</h2>
        </div>
      <div class="content-block__body">
        <p class="lead">Stable metrics, reusable logic, and dynamic mappings eliminate the fragility of BI dashboards.</p>
        <p><strong>Benefits:</strong> Reuse metrics across BI tools. Update structures without breaking dashboards. Push compute back to your warehouse. Avoid vendor lock-in. Speed up cloud migrations.</p>
      </div>
    </div>

    <!-- Faster Implementation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Faster Implementation. Faster Answers.</h2>
      </div>
      <div class="content-block__body">
        <p>Rapid semantic modeling. LLM-assisted entity + metric creation. Up to 90% reduction in time-to-consumption. No new languages — everything in SQL. Deploy in SaaS, cloud, or on-premises. Kubernetes-ready.</p>
      </div>
    </div>

    <!-- Product Overview -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Product Overview</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>Core Platform</h3>
            <p>Semantic Layer. SQL Ontologies. Enterprise LLM Foundation. Ontology Modeling. Virtualization. Cache Engine. SQL Measures. Governance & Access Control.</p>
          </div>
          <div>
            <h3>AI Capabilities</h3>
            <p>NL2SQL Generation. GraphRAG. Graph Analytics. LLM Data Analyst. Natural Language for Excel.</p>
          </div>
          <div>
            <h3>Integrations</h3>
            <p><strong>Data Platforms:</strong> Databricks, Snowflake, Fabric, GCP, AWS, SAP HANA</p>
            <p><strong>BI:</strong> Power BI, Tableau, Looker, Qlik, Excel, Superset</p>
            <p><strong>AI/ML:</strong> Python, LangChain, LangGraph, Graph Algorithms</p>
            <p><strong>Consumption:</strong> SQL, JDBC/ODBC, MDX, REST</p>
          </div>
          <div>
            <h3>Solutions</h3>
            <p>Intelligent Semantic Layer. Metrics Store. Data Virtualization. Data Mesh. Data Fabric. Digital Twin. Semantic Data Lake. Lakehouse Semantic Model. RDF & OWL Modernization. Industry models: FHIR, FIBO, Supply Chain, Telecom, Analytics.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Resources</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>Resources</h3>
            <p><a href="/insights/">Knowledge Base</a>. <a href="/services/">Documentation</a>. <a href="/insights/">Tutorials</a>. <a href="/services/">Ontology Catalog</a>. <a href="/insights/">Benchmarks</a>. <a href="/insights/">Blog</a>.</p>
          </div>
          <div>
            <h3>Company</h3>
            <p><a href="/insights/">News</a>. <a href="/services/">Partners</a>. <a href="/services/">Support</a>. <a href="sms:+12135628438?body=hey, im interested in picking your brain">Text: +1-213-562-8438</a>. <a href="tel:+12135628438">Call: +1-213-562-8438</a>. <a href="mailto:hirejoelm@gmail.com">Email: hirejoelm@gmail.com</a>.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Latest Insights Feed -->
    <?php if (!empty($latest_insights)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Latest Research & Insights</h2>
      </div>
      <div class="content-block__body">
        <?php foreach (array_reverse($latest_insights) as $insight): ?>
          <div style="margin-bottom: var(--spacing-24);">
            <h4><a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/"><?= htmlspecialchars($insight['title']) ?></a></h4>
            <p><?= htmlspecialchars(substr($insight['keywords'] ?? '', 0, 150)) ?>...</p>
            <div class="btn-group">
              <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn">Read Article</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- CTA Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Ready To Build Semantic Intelligence Into Your Stack?</h2>
      </div>
      <div class="content-block__body">
        <div class="btn-group text-center">
          <a href="sms:+12135628438?body=hey, im interested in picking your brain" class="btn btn--primary">Text Us</a>
          <a href="tel:+12135628438" class="btn">Call: +1-213-562-8438</a>
          <a href="mailto:hirejoelm@gmail.com" class="btn">Email Us</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"WebSite",
 "name":"NRLC.ai",
 "url":"https://nrlc.ai",
 "description":"The Semantic Infrastructure for the AI Internet. NRLC builds the semantic foundation that allows LLMs, agents, and applications to interact with enterprise data as if it were fully mapped, contextualized, and logically structured.",
 "publisher":{"@type":"Organization","name":"NRLC.ai"},
 "potentialAction":{"@type":"SearchAction","target":"https://nrlc.ai/search/?q={query}","query-input":"required name=query"},
 "hasPart":[
   {"@type":"Service","name":"Semantic Layer"},
   {"@type":"Service","name":"SQL Ontologies"},
   {"@type":"Service","name":"Enterprise LLM Foundation"},
   {"@type":"Service","name":"Data Virtualization"},
   {"@type":"Service","name":"Knowledge Graph"}
 ],
 "about":["Semantic Infrastructure","AI Internet","Knowledge Graph","Data Virtualization","LLM Foundation"]
}
</script>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"Service",
 "name":"Semantic Infrastructure Platform",
 "description":"A unified semantic layer for the AI era that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.",
 "provider":{
  "@type":"Organization",
  "name":"NRLC.ai",
  "url":"https://nrlc.ai"
 },
 "serviceType":"Semantic Infrastructure Platform",
 "areaServed":[
  {"@type":"Country","name":"United States"},
  {"@type":"Country","name":"United Kingdom"},
  {"@type":"Country","name":"Canada"},
  {"@type":"Country","name":"South Korea"},
  {"@type":"Country","name":"Japan"},
  {"@type":"Country","name":"Singapore"}
 ],
 "hasOfferCatalog":{
  "@type":"OfferCatalog",
  "name":"Semantic Infrastructure Services",
  "itemListElement":[
   {
    "@type":"Offer",
    "itemOffered":{
     "@type":"Service",
     "name":"Semantic Layer",
     "description":"SQL-native ontologies exposing reusable logic, metrics, hierarchies, and reasoning without introducing new languages or paradigms."
    }
   },
   {
    "@type":"Offer",
    "itemOffered":{
     "@type":"Service",
     "name":"Data Virtualization",
     "description":"Connect every source into a semantic, virtualized layer with no ingestion or duplication. Your data stays where it lives — NRLC makes it usable."
    }
   },
   {
    "@type":"Offer",
    "itemOffered":{
     "@type":"Service",
     "name":"Enterprise LLM Foundation",
     "description":"Structured semantic context, verified relationships, and virtualized access to all data sources for reliable LLM operations."
    }
   },
   {
    "@type":"Offer",
    "itemOffered":{
     "@type":"Service",
     "name":"Knowledge Graph",
     "description":"Interactive knowledge graph exploration with relationship traversal, insight surfacing, and natural-language query generation."
    }
   }
  ]
 },
 "offers":{
  "@type":"Offer",
  "name":"Free Demo",
  "price":"0",
  "priceCurrency":"USD",
  "availability":"https://schema.org/InStock"
 }
}
</script>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"Organization",
 "name":"NRLC.ai",
 "url":"https://nrlc.ai",
 "description":"The Semantic Infrastructure for the AI Internet. Building the semantic foundation for agentic systems.",
 "logo":"https://nrlc.ai/assets/images/nrlcai logo 0.png",
 "contactPoint":{
  "@type":"ContactPoint",
  "contactType":"Sales",
  "email":"hirejoelm@gmail.com"
  },
 "sameAs":[
  "https://nrlcmd.com",
  "https://neuralcommandllc.com"
 ]
}
</script>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"FAQPage",
 "mainEntity":[
  {"@type":"Question","name":"What is semantic infrastructure?","acceptedAnswer":{"@type":"Answer","text":"Semantic infrastructure transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships."}},
  {"@type":"Question","name":"How does NRLC enable AI workflows?","acceptedAnswer":{"@type":"Answer","text":"NRLC provides structured semantic context, verified relationships, and virtualized access to all data sources, enabling LLMs to operate on governed, contextualized, precise data."}},
  {"@type":"Question","name":"What data sources does NRLC support?","acceptedAnswer":{"@type":"Answer","text":"NRLC supports data warehouses, data lakes, databases, catalogs, BI tools, AI frameworks, and protocols including REST, SQL, JDBC, ODBC, OLAP, Python, LangChain, LangGraph, and GraphRAG."}},
  {"@type":"Question","name":"How quickly can I implement NRLC?","acceptedAnswer":{"@type":"Answer","text":"NRLC offers rapid semantic modeling, LLM-assisted entity creation, up to 90% reduction in time-to-consumption, and can be deployed in SaaS, cloud, or on-premises environments."}}
 ]
}
</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
