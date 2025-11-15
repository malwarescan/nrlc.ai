<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/csv.php';

// Load latest insights
$insights = csv_read_data('insights.csv');
$latest_insights = array_slice($insights, -4); // Get last 4 insights
?>

<main role="main">
<section class="container">
    
    <!-- Hero / Main Value Proposition -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">nrlc.ai — The Semantic Infrastructure for the AI Internet</div>
      </div>
      <div class="window-body">
        <div class="hero-content" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem;">
          <?php
          // Cycle through available logos
          $logos = ['nrlcai logo 0.png', 'nrlcai logo 3.png', 'nrlcai logo 4.png'];
          $logoIndex = time() % count($logos);
          $selectedLogo = $logos[$logoIndex];
          ?>
          <img src="/assets/images/<?= htmlspecialchars($selectedLogo) ?>" alt="NRLC.ai Logo" class="hero-logo" style="height: 80px; width: auto; max-width: 250px;">
          <div style="flex: 1;">
            <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; color: #000080; line-height: 1.2;">
              The Semantic Infrastructure<br>for the AI Internet
            </h1>
            <p class="lead" style="font-size: 1.3rem; margin: 0; color: #000080;">
              Where data becomes knowledge.<br>Where knowledge becomes intelligence.
            </p>
          </div>
        </div>
        
        <div style="border-top: 2px solid #000080; padding-top: 1.5rem; margin-top: 1.5rem;">
          <h2 style="margin: 0 0 1rem 0; font-size: 1.5rem; color: #000080;">The Operating Layer for Agentic Systems</h2>
          <p class="lead" style="font-size: 1.1rem; margin-bottom: 1.5rem;">
            NRLC builds the semantic foundation that allows LLMs, agents, and applications to interact with enterprise data as if it were fully mapped, contextualized, and logically structured.
          </p>
          <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="/api/book/" class="btn" data-ripple style="font-size: 1rem; padding: 0.75rem 1.5rem;">Book a Demo</a>
            <a href="/services/" class="btn" data-ripple style="font-size: 1rem; padding: 0.75rem 1.5rem;">Explore the Knowledge Graph</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Unified Semantic Layer -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">A Unified Semantic Layer for the AI Era</div>
      </div>
      <div class="window-body">
        <h2 style="margin: 0 0 1rem 0; font-size: 1.75rem; color: #000080;">Stop stitching tools together.</h2>
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          Stop forcing LLMs to interpret raw tables.<br>
          Stop building bespoke pipelines for every use case.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1.5rem;">
          NRLC provides a semantic operating layer that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.
        </p>
        <a href="/services/" class="btn" data-ripple>See how it works</a>
      </div>
    </div>

    <!-- Think in Concepts -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Think in Concepts, Not Tables</div>
      </div>
      <div class="window-body">
        <h2 style="margin: 0 0 1rem 0; font-size: 1.75rem; color: #000080;">Modern data is complex. NRLC abstracts it into meaningful objects, relationships, metrics, and logical rules.</h2>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">What this enables:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Structured data becomes a semantic graph</li>
          <li>LLMs answer with contextual accuracy</li>
          <li>Queries collapse from dozens of JOINs to concise, relationship-aware logic</li>
          <li>Applications consume data as connected concepts, not raw sources</li>
          <li>Governance is enforced automatically across the entire knowledge layer</li>
        </ul>
        <a href="/services/" class="btn" data-ripple>See it in action</a>
      </div>
    </div>

    <!-- Semantic Layer Re-engineered -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">The Semantic Layer, Re-engineered for AI</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          Our ontology engine models your business using SQL-native ontologies, exposing reusable logic, metrics, hierarchies, and reasoning without introducing new languages or paradigms.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">Core capabilities:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Semantic representation of every entity</li>
          <li>Explicit relationships replacing JOIN complexity</li>
          <li>Business logic encoded into reusable rules</li>
          <li>Hierarchies, classifications, inheritance</li>
          <li>Automated reasoning across the entire graph</li>
        </ul>
        <a href="/insights/" class="btn" data-ripple>Learn why teams adopt semantic modeling</a>
      </div>
    </div>

    <!-- Build AI Workflows -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Build AI Workflows on Structured Understanding</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          LLMs become reliable once they operate on governed, contextualized, precise data.<br>
          NRLC delivers that foundation.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">Power AI with:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Structured semantic context</li>
          <li>Verified relationships</li>
          <li>Virtualized access to all data sources</li>
          <li>SQL measures and reusable metrics</li>
          <li>Fine-grained access control</li>
        </ul>
        <a href="/services/" class="btn" data-ripple>Enterprise LLM Foundation Overview</a>
      </div>
    </div>

    <!-- Simplify Data Path -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Simplify the Entire Path from Data → Insight</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          NRLC connects every source into a semantic, virtualized layer with no ingestion or duplication.<br>
          Your data stays where it lives — NRLC makes it usable.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">Benefits:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Automatic mapping to the ontology</li>
          <li>Federated queries across clouds and databases</li>
          <li>Intelligent pushdown + query optimization</li>
          <li>Powerful caching engine that reduces compute spend</li>
          <li>Unified graph view across all sources</li>
        </ul>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
          <a href="/services/data-mapping/" class="btn" data-ripple>See how data is mapped</a>
          <a href="/services/data-virtualization/" class="btn" data-ripple>Explore data virtualization</a>
          <a href="/insights/" class="btn" data-ripple>Performance & caching insights</a>
        </div>
      </div>
    </div>

    <!-- Connect Anything -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Connect Anything</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          No syncing. No lifting. No duplication.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">Supported universally:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <strong>Data Platforms:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
              <li>Data warehouses</li>
              <li>Data lakes</li>
              <li>Databases</li>
              <li>Catalogs</li>
            </ul>
          </div>
          <div>
            <strong>BI Tools:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
              <li>Power BI</li>
              <li>Tableau</li>
              <li>Looker</li>
              <li>Qlik</li>
            </ul>
          </div>
          <div>
            <strong>AI Frameworks:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
              <li>Python</li>
              <li>LangChain</li>
              <li>LangGraph</li>
              <li>GraphRAG</li>
            </ul>
          </div>
          <div>
            <strong>Protocols:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
              <li>REST, SQL</li>
              <li>JDBC, ODBC</li>
              <li>OLAP, MDX</li>
            </ul>
          </div>
        </div>
        <a href="/services/" class="btn" data-ripple>View all integrations</a>
      </div>
    </div>

    <!-- Power Applications With Smart REST -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Power Applications With Smart REST</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          Your REST layer becomes semantic, self-documenting, and deeply expressive.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">Capabilities:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Nested semantic fetches</li>
          <li>Field-level precision</li>
          <li>Role & row-level governance</li>
          <li>Reduced network payload</li>
          <li>Automatic OpenAPI/Swagger generation</li>
        </ul>
        <a href="/services/rest-api/" class="btn" data-ripple>REST API Documentation</a>
      </div>
    </div>

    <!-- Accelerated Analytics -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Accelerated Analytics</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          Semantic relationships collapse query complexity and reduce time to value.
        </p>
        <div style="background: #f0f0f0; padding: 1rem; margin: 1rem 0; border: 1px solid #ccc;">
          <p style="margin: 0 0 0.5rem 0; font-weight: 600;">Example</p>
          <p style="margin: 0 0 0.5rem 0;"><strong>Traditional SQL:</strong> 22 lines</p>
          <p style="margin: 0;"><strong>Semantic SQL:</strong> 6 lines</p>
        </div>
        <a href="/insights/" class="btn" data-ripple>Learn more about semantic queries</a>
      </div>
    </div>

    <!-- Interactive Knowledge Graph -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Interactive Knowledge Graph Exploration</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          Traverse relationships. Surface insights.<br>
          Generate SQL or natural-language queries.<br>
          Let LLMs act as your data analyst.
        </p>
        <a href="/services/" class="btn" data-ripple>Explore the Knowledge Graph</a>
      </div>
    </div>

    <!-- Decouple BI -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Decouple BI From Raw Data</div>
      </div>
      <div class="window-body">
        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1rem;">
          Stable metrics, reusable logic, and dynamic mappings eliminate the fragility of BI dashboards.
        </p>
        <p style="font-size: 1rem; margin-bottom: 1rem; font-weight: 600;">Benefits:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Reuse metrics across BI tools</li>
          <li>Update structures without breaking dashboards</li>
          <li>Push compute back to your warehouse</li>
          <li>Avoid vendor lock-in</li>
          <li>Speed up cloud migrations</li>
        </ul>
      </div>
    </div>

    <!-- Faster Implementation -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Faster Implementation. Faster Answers.</div>
      </div>
      <div class="window-body">
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Rapid semantic modeling</li>
          <li>LLM-assisted entity + metric creation</li>
          <li>Up to 90% reduction in time-to-consumption</li>
          <li>No new languages — everything in SQL</li>
          <li>Deploy in SaaS, cloud, or on-premises</li>
          <li>Kubernetes-ready</li>
        </ul>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Ready To Build Semantic Intelligence Into Your Stack?</div>
      </div>
      <div class="window-body">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
          <a href="/api/book/" class="btn" data-ripple style="font-size: 1rem; padding: 0.75rem 1.5rem;">Book a live demo</a>
          <a href="/services/" class="btn" data-ripple style="font-size: 1rem; padding: 0.75rem 1.5rem;">Start your free trial</a>
          <a href="/services/" class="btn" data-ripple style="font-size: 1rem; padding: 0.75rem 1.5rem;">Get product overview</a>
        </div>
      </div>
    </div>

    <!-- Product Overview -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Product Overview</div>
      </div>
      <div class="window-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
          <div>
            <h3 style="color: #000080; margin-top: 0;">Core Platform</h3>
            <ul style="padding-left: 1.5rem;">
              <li>Semantic Layer</li>
              <li>SQL Ontologies</li>
              <li>Enterprise LLM Foundation</li>
              <li>Ontology Modeling</li>
              <li>Virtualization</li>
              <li>Cache Engine</li>
              <li>SQL Measures</li>
              <li>Governance & Access Control</li>
            </ul>
          </div>
          <div>
            <h3 style="color: #000080; margin-top: 0;">AI Capabilities</h3>
            <ul style="padding-left: 1.5rem;">
              <li>NL2SQL Generation</li>
              <li>GraphRAG</li>
              <li>Graph Analytics</li>
              <li>LLM Data Analyst</li>
              <li>Natural Language for Excel</li>
            </ul>
          </div>
          <div>
            <h3 style="color: #000080; margin-top: 0;">Integrations</h3>
            <p style="font-size: 0.9rem; margin-bottom: 0.5rem;"><strong>Data Platforms:</strong> Databricks, Snowflake, Fabric, GCP, AWS, SAP HANA</p>
            <p style="font-size: 0.9rem; margin-bottom: 0.5rem;"><strong>BI:</strong> Power BI, Tableau, Looker, Qlik, Excel, Superset</p>
            <p style="font-size: 0.9rem; margin-bottom: 0.5rem;"><strong>AI/ML:</strong> Python, LangChain, LangGraph, Graph Algorithms</p>
            <p style="font-size: 0.9rem;"><strong>Consumption:</strong> SQL, JDBC/ODBC, MDX, REST</p>
          </div>
          <div>
            <h3 style="color: #000080; margin-top: 0;">Solutions</h3>
            <ul style="padding-left: 1.5rem; font-size: 0.9rem;">
              <li>Intelligent Semantic Layer</li>
              <li>Metrics Store</li>
              <li>Data Virtualization</li>
              <li>Data Mesh</li>
              <li>Data Fabric</li>
              <li>Digital Twin</li>
              <li>Semantic Data Lake</li>
              <li>Lakehouse Semantic Model</li>
              <li>RDF & OWL Modernization</li>
              <li>Industry models: FHIR, FIBO, Supply Chain, Telecom, Analytics</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Resources -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Resources</div>
      </div>
      <div class="window-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
          <div>
            <h3 style="color: #000080; margin-top: 0;">Resources</h3>
            <ul style="padding-left: 1.5rem;">
              <li><a href="/insights/">Knowledge Base</a></li>
              <li><a href="/services/">Documentation</a></li>
              <li><a href="/insights/">Tutorials</a></li>
              <li><a href="/services/">Ontology Catalog</a></li>
              <li><a href="/insights/">Benchmarks</a></li>
              <li><a href="/insights/">Blog</a></li>
            </ul>
          </div>
          <div>
            <h3 style="color: #000080; margin-top: 0;">Company</h3>
            <ul style="padding-left: 1.5rem;">
              <li><a href="/insights/">News</a></li>
              <li><a href="/services/">Partners</a></li>
              <li><a href="/services/">Support</a></li>
              <li><a href="/api/book/">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Latest Insights Feed -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Latest Research & Insights</div>
      </div>
      <div class="window-body">
        <div class="list-view">
          <?php foreach (array_reverse($latest_insights) as $insight): ?>
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
