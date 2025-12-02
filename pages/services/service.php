<?php
require_once __DIR__.'/../../templates/head.php';
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/nrlc_linking_kernel.php';

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
        <h2>Automatic Ontology Mapping</h2>
        <p>NRLC automatically maps your databases, APIs, warehouses, and streams to a unified ontology. No manual configuration required—our system understands your data structure and creates semantic relationships automatically.</p>
        
        <h3>How It Works</h3>
        <ul>
          <li><strong>Schema Discovery:</strong> Automatically discovers tables, columns, and relationships across all connected sources</li>
          <li><strong>Entity Recognition:</strong> Identifies entities, attributes, and relationships in your data</li>
          <li><strong>Ontology Alignment:</strong> Maps discovered structures to your semantic ontology</li>
          <li><strong>Relationship Inference:</strong> Automatically creates relationships based on foreign keys, naming patterns, and data analysis</li>
          <li><strong>Validation & Refinement:</strong> Provides tools to validate and refine mappings as needed</li>
        </ul>
        
        <h3>Benefits</h3>
        <ul>
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
        <h2>Data Virtualization Without Duplication</h2>
        <p>NRLC connects every data source into a semantic, virtualized layer. No syncing, no lifting, no duplication. Your data stays where it lives—NRLC makes it usable through a unified semantic interface.</p>
        
        <h3>Key Capabilities</h3>
        <ul>
          <li><strong>Federated Queries:</strong> Query across clouds and databases as if they were a single source</li>
          <li><strong>Intelligent Pushdown:</strong> Push computation back to source systems for optimal performance</li>
          <li><strong>Query Optimization:</strong> Automatically optimizes queries across distributed sources</li>
          <li><strong>Caching Engine:</strong> Powerful caching that reduces compute spend while maintaining freshness</li>
          <li><strong>Unified Graph View:</strong> See all your data as a connected knowledge graph regardless of source</li>
        </ul>
        
        <h3>Supported Sources</h3>
        <ul>
          <li>Data warehouses (Snowflake, Databricks, BigQuery, Redshift)</li>
          <li>Data lakes (S3, ADLS, GCS)</li>
          <li>Databases (PostgreSQL, MySQL, SQL Server, Oracle)</li>
          <li>APIs (REST, GraphQL, SOAP)</li>
          <li>BI tools (Power BI, Tableau, Looker)</li>
          <li>Cloud platforms (AWS, GCP, Azure)</li>
        </ul>
        
        <h3>Benefits</h3>
        <ul>
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
        <h2>Semantic REST API</h2>
        <p>NRLC transforms your REST layer into a semantic, self-documenting API that understands relationships and context. Query your knowledge graph through intuitive REST endpoints with automatic OpenAPI/Swagger documentation.</p>
        
        <h3>Key Features</h3>
        <ul>
          <li><strong>Nested Semantic Fetches:</strong> Request related entities in a single call using semantic relationships</li>
          <li><strong>Field-Level Precision:</strong> Request only the fields you need, reducing payload size</li>
          <li><strong>Role & Row-Level Governance:</strong> Automatic enforcement of access control based on user roles</li>
          <li><strong>Reduced Network Payload:</strong> Efficient data transfer with intelligent field selection</li>
          <li><strong>Automatic OpenAPI/Swagger:</strong> Self-documenting API with automatic schema generation</li>
        </ul>
        
        <h3>Example Endpoints</h3>
        <div class="content-block content-block--highlighted">
          <p><strong>GET</strong> /api/entities/customers</p>
          <p><strong>GET</strong> /api/entities/customers/{id}?include=orders,address</p>
          <p><strong>GET</strong> /api/entities/customers?fields=name,email&filter=status:active</p>
          <p><strong>GET</strong> /api/query?q=revenue by region</p>
        </div>
        
        <h3>Benefits</h3>
        <ul>
          <li>Intuitive API design based on your semantic model</li>
          <li>Automatic relationship traversal</li>
          <li>Built-in security and governance</li>
          <li>Self-documenting with OpenAPI/Swagger</li>
          <li>Optimized for both human developers and AI agents</li>
        </ul>
        
        <h3>Documentation</h3>
        <p>Full REST API documentation is available in OpenAPI/Swagger format. Access interactive API documentation, code samples, and integration guides.</p>
        <p><a href="/api/docs/" class="btn">View Full API Documentation</a></p>
      '
    ]
  ];
  
  $content = $serviceContent[$service] ?? null;
  
  if ($content) {
    $domain = 'https://nrlc.ai';
    $canonical_url = $domain . '/services/' . $service . '/';
    
    $GLOBALS['__jsonld'] = [
      [
        "@context" => "https://schema.org",
        "@type" => "WebPage",
        "@id" => $canonical_url . '#webpage',
        "name" => $content['title'],
        "url" => $canonical_url,
        "description" => $content['description'],
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
        "@id" => $canonical_url . '#breadcrumb',
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
            "name" => "Services",
            "item" => $domain . "/services/"
          ],
          [
            "@type" => "ListItem",
            "position" => 3,
            "name" => $content['title'],
            "item" => $canonical_url
          ]
        ]
      ],
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
    <section class="container section">
        <div class="content-block module">
          <div class="content-block__header">
            <h1 class="content-block__title"><?= htmlspecialchars($content['title']) ?></h1>
          </div>
          <div class="content-block__body">
            <p class="lead"><?= htmlspecialchars($content['description']) ?></p>
            <?= $content['content'] ?>
            <p class="text-center">
              <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($content['title']) ?>')">Book a Demo</button>
              <a href="/services/" class="btn">View All Services</a>
            </p>
          </div>
        </div>
    </section>
    </main>
    <?php
    exit; // Exit early for semantic services
  }
}

// Default service page with city selection
$domain = 'https://nrlc.ai';
$canonical_url = $domain . '/services/' . $service . '/';

$GLOBALS['__jsonld'] = [
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "@id" => $canonical_url . '#webpage',
    "name" => $serviceName,
    "url" => $canonical_url,
    "description" => "Professional $serviceName implementation with localized expertise and support across multiple cities.",
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
    "@id" => $canonical_url . '#breadcrumb',
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
        "name" => "Services",
        "item" => $domain . "/services/"
      ],
      [
        "@type" => "ListItem",
        "position" => 3,
        "name" => $serviceName,
        "item" => $canonical_url
      ]
    ]
  ],
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
<section class="container section">
    
    <!-- Hero Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title"><?=htmlspecialchars(ucwords(str_replace('-',' ',$service)))?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Select a city to see localized implementation and pricing for this service.</p>
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> and discover how <a href="/insights/geo16-introduction/">GEO-16 Framework</a> can optimize your AI citation rates. Learn more about our <a href="/tools/">SEO Tools & Resources</a> for technical SEO optimization.</p>
      </div>
    </div>

    <!-- City Selection Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Available Cities</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">New York</h3>
            </div>
            <div class="content-block__body">
              <p>Full service implementation in New York with local expertise and support.</p>
              <div class="btn-group">
                <a href="/services/<?=htmlspecialchars($service)?>/new-york/" class="btn btn--primary">View in New York</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">London</h3>
            </div>
            <div class="content-block__body">
              <p>Comprehensive service delivery in London with UK market expertise.</p>
              <div class="btn-group">
                <a href="/services/<?=htmlspecialchars($service)?>/london/" class="btn btn--primary">View in London</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">San Francisco</h3>
            </div>
            <div class="content-block__body">
              <p>Tech-focused implementation in San Francisco with Silicon Valley insights.</p>
              <div class="btn-group">
                <a href="/services/<?=htmlspecialchars($service)?>/san-francisco/" class="btn btn--primary">View in San Francisco</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Toronto</h3>
            </div>
            <div class="content-block__body">
              <p>Canadian market expertise with Toronto-based implementation and support.</p>
              <div class="btn-group">
                <a href="/services/<?=htmlspecialchars($service)?>/toronto/" class="btn btn--primary">View in Toronto</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Consultation Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Need Help Choosing?</h2>
      </div>
      <div class="content-block__body">
        <p>Our team can help you select the right city and service package for your needs. Contact us for personalized recommendations.</p>
        <p>Learn more about our <a href="/insights/">AI SEO Research & Insights</a> and explore our <a href="/tools/">SEO Tools & Resources</a> to enhance your search visibility.</p>
        <p class="text-center">
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
          <button type="button" class="btn" onclick="openContactSheet('<?= htmlspecialchars($serviceName) ?>')">Schedule Consultation</button>
        </p>
      </div>
    </div>

</section>
</main>

<?php
// LINKING KERNEL: Add required internal links
if (function_exists('render_internal_links_section')) {
  echo render_internal_links_section('services', $service, [], 'Related Resources');
}
?>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>

