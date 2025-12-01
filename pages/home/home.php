<?php
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
    
    <!-- Primary Mission Statement -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">The Semantic Infrastructure for the AI Internet</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">NRLC builds the semantic foundation that allows LLMs, agents, and applications to interact with enterprise data as if it were fully mapped, contextualized, and logically structured.</p>
        <p>Where data becomes knowledge. Where knowledge becomes intelligence.</p>
        <div class="btn-group">
          <a href="sms:+12135628438?body=hey, im interested in picking your brain" class="btn btn--primary">Text Us</a>
          <a href="tel:+12135628438" class="btn">Call Now</a>
          <a href="mailto:hirejoelm@gmail.com" class="btn">Email Us</a>
        </div>
      </div>
        </div>

    <!-- Unified Semantic Layer -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">A Unified Semantic Layer for the AI Era</h2>
        </div>
      <div class="content-block__body">
        <p class="lead">Stop stitching tools together. Stop forcing LLMs to interpret raw tables. Stop building bespoke pipelines for every use case.</p>
        <p>Transform databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships.</p>
        <p><a href="/services/" class="btn">See how it works</a></p>
      </div>
    </div>

    <!-- Think in Concepts -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Think in Concepts, Not Tables</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Modern data is complex. NRLC abstracts it into meaningful objects, relationships, metrics, and logical rules.</p>
        <p><strong>What this enables:</strong></p>
        <ul>
          <li>Structured data becomes a semantic graph</li>
          <li>LLMs answer with contextual accuracy</li>
          <li>Queries collapse from dozens of JOINs to concise, relationship-aware logic</li>
          <li>Applications consume data as connected concepts, not raw sources</li>
          <li>Governance is enforced automatically across the entire knowledge layer</li>
        </ul>
        <p><a href="/services/" class="btn">See it in action</a></p>
      </div>
    </div>

    <!-- Semantic Layer Re-engineered -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Semantic Layer, Re-engineered for AI</h2>
        </div>
      <div class="content-block__body">
        <p class="lead">Model your business using SQL-native ontologies, exposing reusable logic, metrics, hierarchies, and reasoning without introducing new languages or paradigms.</p>
        <p><strong>Core capabilities:</strong></p>
        <ul>
          <li>Semantic representation of every entity</li>
          <li>Explicit relationships replacing JOIN complexity</li>
          <li>Business logic encoded into reusable rules</li>
          <li>Hierarchies, classifications, inheritance</li>
          <li>Automated reasoning across the entire graph</li>
        </ul>
        <p><a href="/insights/" class="btn">Learn why teams adopt semantic modeling</a></p>
      </div>
    </div>

    <!-- Build AI Workflows -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Build AI Workflows on Structured Understanding</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">LLMs become reliable once they operate on governed, contextualized, precise data. NRLC delivers that foundation.</p>
        <p><strong>Power AI with:</strong></p>
        <ul>
          <li>Structured semantic context</li>
          <li>Verified relationships</li>
          <li>Virtualized access to all data sources</li>
          <li>SQL measures and reusable metrics</li>
          <li>Fine-grained access control</li>
        </ul>
        <p><a href="/services/" class="btn">Enterprise LLM Foundation Overview</a></p>
      </div>
    </div>

    <!-- Simplify Data Path -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Simplify the Entire Path from Data → Insight</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">NRLC connects every source into a semantic, virtualized layer with no ingestion or duplication. Your data stays where it lives — NRLC makes it usable.</p>
        <p><strong>Benefits:</strong></p>
        <ul>
          <li>Automatic mapping to the ontology</li>
          <li>Federated queries across clouds and databases</li>
          <li>Intelligent pushdown + query optimization</li>
          <li>Powerful caching engine that reduces compute spend</li>
          <li>Unified graph view across all sources</li>
        </ul>
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
            <ul>
              <li>Data warehouses</li>
              <li>Data lakes</li>
              <li>Databases</li>
              <li>Catalogs</li>
            </ul>
          </div>
          <div>
            <h4>BI Tools</h4>
            <ul>
              <li>Power BI</li>
              <li>Tableau</li>
              <li>Looker</li>
              <li>Qlik</li>
            </ul>
          </div>
          <div>
            <h4>AI Frameworks</h4>
            <ul>
              <li>Python</li>
              <li>LangChain</li>
              <li>LangGraph</li>
              <li>GraphRAG</li>
            </ul>
          </div>
          <div>
            <h4>Protocols</h4>
            <ul>
              <li>REST, SQL</li>
              <li>JDBC, ODBC</li>
              <li>OLAP, MDX</li>
            </ul>
          </div>
        </div>
        <p><a href="/services/" class="btn">View all integrations</a></p>
      </div>
      </div>

    <!-- Power Applications With Smart REST -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Power Applications With Smart REST</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Your REST layer becomes semantic, self-documenting, and deeply expressive.</p>
        <p><strong>Capabilities:</strong></p>
        <ul>
          <li>Nested semantic fetches</li>
          <li>Field-level precision</li>
          <li>Role & row-level governance</li>
          <li>Reduced network payload</li>
          <li>Automatic OpenAPI/Swagger generation</li>
        </ul>
        <p><a href="/services/rest-api/" class="btn">REST API Documentation</a></p>
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
        <p><a href="/insights/" class="btn">Learn more about semantic queries</a></p>
      </div>
    </div>

    <!-- Interactive Knowledge Graph -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Interactive Knowledge Graph Exploration</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Traverse relationships. Surface insights. Generate SQL or natural-language queries. Let LLMs act as your data analyst.</p>
        <p><a href="/services/" class="btn">Explore the Knowledge Graph</a></p>
      </div>
            </div>

    <!-- Decouple BI -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Decouple BI From Raw Data</h2>
        </div>
      <div class="content-block__body">
        <p class="lead">Stable metrics, reusable logic, and dynamic mappings eliminate the fragility of BI dashboards.</p>
        <p><strong>Benefits:</strong></p>
        <ul>
          <li>Reuse metrics across BI tools</li>
          <li>Update structures without breaking dashboards</li>
          <li>Push compute back to your warehouse</li>
          <li>Avoid vendor lock-in</li>
          <li>Speed up cloud migrations</li>
        </ul>
      </div>
    </div>

    <!-- Faster Implementation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Faster Implementation. Faster Answers.</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Rapid semantic modeling</li>
          <li>LLM-assisted entity + metric creation</li>
          <li>Up to 90% reduction in time-to-consumption</li>
          <li>No new languages — everything in SQL</li>
          <li>Deploy in SaaS, cloud, or on-premises</li>
          <li>Kubernetes-ready</li>
        </ul>
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
            <ul>
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
            <h3>AI Capabilities</h3>
            <ul>
              <li>NL2SQL Generation</li>
              <li>GraphRAG</li>
              <li>Graph Analytics</li>
              <li>LLM Data Analyst</li>
              <li>Natural Language for Excel</li>
            </ul>
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
            <ul>
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
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Resources</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>Resources</h3>
            <ul>
              <li><a href="/insights/">Knowledge Base</a></li>
              <li><a href="/services/">Documentation</a></li>
              <li><a href="/insights/">Tutorials</a></li>
              <li><a href="/services/">Ontology Catalog</a></li>
              <li><a href="/insights/">Benchmarks</a></li>
              <li><a href="/insights/">Blog</a></li>
            </ul>
          </div>
          <div>
            <h3>Company</h3>
            <ul>
              <li><a href="/insights/">News</a></li>
              <li><a href="/services/">Partners</a></li>
              <li><a href="/services/">Support</a></li>
              <li><a href="sms:+12135628438?body=hey, im interested in picking your brain">Text: +1-213-562-8438</a></li>
              <li><a href="tel:+12135628438">Call: +1-213-562-8438</a></li>
              <li><a href="mailto:hirejoelm@gmail.com">Email: hirejoelm@gmail.com</a></li>
            </ul>
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
        <ul>
          <?php foreach (array_reverse($latest_insights) as $insight): ?>
            <li>
              <h4><a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/"><?= htmlspecialchars($insight['title']) ?></a></h4>
              <p><?= htmlspecialchars(substr($insight['keywords'] ?? '', 0, 150)) ?>...</p>
              <p><a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn">Read Article</a></p>
            </li>
          <?php endforeach; ?>
        </ul>
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
