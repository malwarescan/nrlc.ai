<?php
require_once __DIR__.'/../../templates/head.php';
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';

$service = $_GET['service'] ?? '';
$GLOBALS['__page_slug'] = 'services/service';

// Service schema for the selection page
$serviceName = ucwords(str_replace('-',' ',$service));

// Special handling for semantic infrastructure services
$semanticServices = ['data-mapping', 'data-virtualization', 'rest-api', 'semantic-layer', 'enterprise-llm-foundation', 'knowledge-graph', 'ontology-modeling'];

if (in_array($service, $semanticServices)) {
  // Custom content for semantic infrastructure services
  $serviceContent = [
    'data-mapping' => [
      'title' => 'See How Data is Mapped',
      'description' => 'Automatic mapping to the ontology transforms your raw data sources into a coherent semantic graph.',
      'content' => '
        <h2 style="color: #000080; margin-top: 0;">Automatic Ontology Mapping</h2>
        <p>NRLC automatically maps your databases, APIs, warehouses, and streams to a unified ontology. No manual configuration required—our system understands your data structure and creates semantic relationships automatically.</p>
        
        <h3 style="color: #000080;">How It Works</h3>
        <ul style="padding-left: 1.5rem;">
          <li><strong>Schema Discovery:</strong> Automatically discovers tables, columns, and relationships across all connected sources</li>
          <li><strong>Entity Recognition:</strong> Identifies entities, attributes, and relationships in your data</li>
          <li><strong>Ontology Alignment:</strong> Maps discovered structures to your semantic ontology</li>
          <li><strong>Relationship Inference:</strong> Automatically creates relationships based on foreign keys, naming patterns, and data analysis</li>
          <li><strong>Validation & Refinement:</strong> Provides tools to validate and refine mappings as needed</li>
        </ul>
        
        <h3 style="color: #000080;">Benefits</h3>
        <ul style="padding-left: 1.5rem;">
          <li>Zero manual mapping for standard data structures</li>
          <li>Consistent semantic representation across all sources</li>
          <li>Automatic relationship discovery and creation</li>
          <li>LLM-assisted mapping for complex or ambiguous structures</li>
          <li>Version-controlled mappings that persist across deployments</li>
        </ul>
      '
    ],
    'data-virtualization' => [
      'title' => 'Explore Data Virtualization',
      'description' => 'Connect every source into a semantic, virtualized layer with no ingestion or duplication. Your data stays where it lives—NRLC makes it usable.',
      'content' => '
        <h2 style="color: #000080; margin-top: 0;">Data Virtualization Without Duplication</h2>
        <p>NRLC connects every data source into a semantic, virtualized layer. No syncing, no lifting, no duplication. Your data stays where it lives—NRLC makes it usable through a unified semantic interface.</p>
        
        <h3 style="color: #000080;">Key Capabilities</h3>
        <ul style="padding-left: 1.5rem;">
          <li><strong>Federated Queries:</strong> Query across clouds and databases as if they were a single source</li>
          <li><strong>Intelligent Pushdown:</strong> Push computation back to source systems for optimal performance</li>
          <li><strong>Query Optimization:</strong> Automatically optimizes queries across distributed sources</li>
          <li><strong>Caching Engine:</strong> Powerful caching that reduces compute spend while maintaining freshness</li>
          <li><strong>Unified Graph View:</strong> See all your data as a connected knowledge graph regardless of source</li>
        </ul>
        
        <h3 style="color: #000080;">Supported Sources</h3>
        <ul style="padding-left: 1.5rem;">
          <li>Data warehouses (Snowflake, Databricks, BigQuery, Redshift)</li>
          <li>Data lakes (S3, ADLS, GCS)</li>
          <li>Databases (PostgreSQL, MySQL, SQL Server, Oracle)</li>
          <li>APIs (REST, GraphQL, SOAP)</li>
          <li>BI tools (Power BI, Tableau, Looker)</li>
          <li>Cloud platforms (AWS, GCP, Azure)</li>
        </ul>
        
        <h3 style="color: #000080;">Benefits</h3>
        <ul style="padding-left: 1.5rem;">
          <li>No data duplication—access data in place</li>
          <li>Real-time access to live data sources</li>
          <li>Reduced storage and compute costs</li>
          <li>Simplified data governance</li>
          <li>Faster time to value</li>
        </ul>
      '
    ],
    'rest-api' => [
      'title' => 'REST API Documentation',
      'description' => 'Your REST layer becomes semantic, self-documenting, and deeply expressive. Nested semantic fetches, field-level precision, and automatic OpenAPI generation.',
      'content' => '
        <h2 style="color: #000080; margin-top: 0;">Semantic REST API</h2>
        <p>NRLC transforms your REST layer into a semantic, self-documenting API that understands relationships and context. Query your knowledge graph through intuitive REST endpoints with automatic OpenAPI/Swagger documentation.</p>
        
        <h3 style="color: #000080;">Key Features</h3>
        <ul style="padding-left: 1.5rem;">
          <li><strong>Nested Semantic Fetches:</strong> Request related entities in a single call using semantic relationships</li>
          <li><strong>Field-Level Precision:</strong> Request only the fields you need, reducing payload size</li>
          <li><strong>Role & Row-Level Governance:</strong> Automatic enforcement of access control based on user roles</li>
          <li><strong>Reduced Network Payload:</strong> Efficient data transfer with intelligent field selection</li>
          <li><strong>Automatic OpenAPI/Swagger:</strong> Self-documenting API with automatic schema generation</li>
        </ul>
        
        <h3 style="color: #000080;">Example Endpoints</h3>
        <div style="background: #f0f0f0; padding: 1rem; margin: 1rem 0; border: 1px solid #ccc; font-family: monospace;">
          <p style="margin: 0;"><strong>GET</strong> /api/entities/customers</p>
          <p style="margin: 0.5rem 0 0 0;"><strong>GET</strong> /api/entities/customers/{id}?include=orders,address</p>
          <p style="margin: 0.5rem 0 0 0;"><strong>GET</strong> /api/entities/customers?fields=name,email&filter=status:active</p>
          <p style="margin: 0.5rem 0 0 0;"><strong>GET</strong> /api/query?q=revenue by region</p>
        </div>
        
        <h3 style="color: #000080;">Benefits</h3>
        <ul style="padding-left: 1.5rem;">
          <li>Intuitive API design based on your semantic model</li>
          <li>Automatic relationship traversal</li>
          <li>Built-in security and governance</li>
          <li>Self-documenting with OpenAPI/Swagger</li>
          <li>Optimized for both human developers and AI agents</li>
        </ul>
        
        <h3 style="color: #000080;">Documentation</h3>
        <p>Full REST API documentation is available in OpenAPI/Swagger format. Access interactive API documentation, code samples, and integration guides.</p>
        <a href="/api/docs/" class="btn" data-ripple style="margin-top: 1rem;">View Full API Documentation</a>
      '
    ]
  ];
  
  $content = $serviceContent[$service] ?? null;
  
  if ($content) {
    $GLOBALS['__jsonld'] = [
      [
        "@context" => "https://schema.org",
        "@type" => "Service",
        "name" => $content['title'],
        "description" => $content['description'],
        "provider" => [
          "@type" => "Organization",
          "name" => "NRLC.ai",
          "url" => "https://nrlc.ai"
        ],
        "serviceType" => "Semantic Infrastructure",
        "offers" => [
          "@type" => "Offer",
          "name" => "Free Consultation",
          "price" => "0",
          "priceCurrency" => "USD",
          "availability" => "https://schema.org/InStock"
        ]
      ]
    ];
    ?>
    <main role="main">
    <section class="container">
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text"><?= htmlspecialchars($content['title']) ?></div>
          </div>
          <div class="window-body">
            <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;"><?= htmlspecialchars($content['title']) ?></h1>
            <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;"><?= htmlspecialchars($content['description']) ?></p>
            <?= $content['content'] ?>
            <div style="margin-top: 2rem; text-align: center;">
              <a href="/api/book/" class="btn" data-ripple>Book a Demo</a>
              <a href="/services/" class="btn" data-ripple style="margin-left: 1rem;">View All Services</a>
            </div>
          </div>
        </div>
    </section>
    </main>
    <?php
    exit; // Exit early for semantic services
  }
}

// Default service page with city selection
$GLOBALS['__jsonld'] = [
  [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "name" => $serviceName,
    "description" => "Professional $serviceName implementation with localized expertise and support across multiple cities.",
    "provider" => [
      "@type" => "Organization",
      "name" => "NRLC.ai",
      "url" => "https://nrlc.ai"
    ],
    "serviceType" => "AI-First SEO Services",
    "areaServed" => [
      ["@type" => "City", "name" => "New York"],
      ["@type" => "City", "name" => "London"],
      ["@type" => "City", "name" => "San Francisco"],
      ["@type" => "City", "name" => "Toronto"]
    ],
    "offers" => [
      "@type" => "Offer",
      "name" => "Free Consultation",
      "price" => "0",
      "priceCurrency" => "USD",
      "availability" => "https://schema.org/InStock"
    ]
  ]
];
?>

<main role="main">
<section class="container">
    
    <!-- Hero Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text"><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;"><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">Select a city to see localized implementation and pricing for this service.</p>
      </div>
    </div>

    <!-- City Selection Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Available Cities</div>
      </div>
      <div class="window-body">
        <div class="grid-auto-fit">
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">New York</h3>
            <p>Full service implementation in New York with local expertise and support.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/new-york/" class="btn" data-ripple>View in New York</a>
          </div>
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">London</h3>
            <p>Comprehensive service delivery in London with UK market expertise.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/london/" class="btn" data-ripple>View in London</a>
          </div>
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">San Francisco</h3>
            <p>Tech-focused implementation in San Francisco with Silicon Valley insights.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/san-francisco/" class="btn" data-ripple>View in San Francisco</a>
          </div>
          
          <div class="box-padding">
            <h3 style="margin-top: 0; color: #000080;">Toronto</h3>
            <p>Canadian market expertise with Toronto-based implementation and support.</p>
            <a href="/services/<?=htmlspecialchars($service)?>/toronto/" class="btn" data-ripple>View in Toronto</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Consultation Window -->
    <div class="window">
      <div class="title-bar">
        <div class="title-bar-text">Need Help Choosing?</div>
      </div>
      <div class="window-body">
        <p>Our team can help you select the right city and service package for your needs. Contact us for personalized recommendations.</p>
        <div class="center margin-top-20">
          <a href="/api/book/" class="btn" data-ripple>Schedule Consultation</a>
        </div>
      </div>
    </div>

</section>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>

