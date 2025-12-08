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

// Special handling for AI SEO services with custom content
$aiSeoServices = ['ai-overview-optimization'];

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

// Special handling for AI Overview Optimization
if ($service === 'ai-overview-optimization') {
  $domain = 'https://nrlc.ai';
  $canonical_url = $domain . '/services/ai-overview-optimization/';
  
  // Get enhancement data if available
  $enhancement = get_service_enhancement('ai-overview-optimization', '');
  $pageTitle = $enhancement['title'] ?? 'Google AI Overviews Optimization Services';
  $pageDesc = $enhancement['description'] ?? 'Optimize your content for Google AI Overviews and AI-powered search experiences. Increase citation rates, improve AI visibility, and surface in AI-generated answers.';
  
  // Ensure title is 50-60 chars and unique
  if (strlen($pageTitle) < 50 || strlen($pageTitle) > 60) {
    $pageTitle = 'Google AI Overviews Optimization & Citation Services';
  }
  
  $GLOBALS['pageTitle'] = $pageTitle;
  $GLOBALS['pageDesc'] = $pageDesc;
  
  $GLOBALS['__jsonld'] = [
    [
      "@context" => "https://schema.org",
      "@type" => "WebPage",
      "@id" => $canonical_url . '#webpage',
      "name" => "AI Overview Optimization",
      "url" => $canonical_url,
      "description" => $pageDesc,
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
          "name" => "AI Overview Optimization",
          "item" => $canonical_url
        ]
      ]
    ],
    [
      "@context" => "https://schema.org",
      "@type" => "Service",
      "name" => "AI Overview Optimization",
      "description" => $pageDesc,
      "provider" => [
        "@type" => "Organization",
        "name" => "Neural Command LLC",
        "url" => "https://nrlc.ai"
      ],
      "serviceType" => "AI SEO Optimization",
      "areaServed" => "Global",
      "url" => $canonical_url,
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
          <h1 class="content-block__title">AI Overview Optimization</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">Optimize your content for Google AI Overviews and AI-powered search experiences. Increase citation rates, improve AI visibility, and surface in AI-generated answers.</p>
          
          <h2>What Is AI Overview Optimization?</h2>
          <p>AI Overview Optimization ensures your content is structured, cited, and surfaced in Google AI Overviews and other AI-powered search experiences. Unlike traditional SEO that targets search rankings, AI Overview Optimization focuses on making your content citable, verifiable, and authoritative for large language models.</p>
          
          <h3>How AI Overviews Work</h3>
          <p>Google AI Overviews use large language models to generate direct answers from web content. These models prioritize:</p>
          <ul>
            <li><strong>Structured Data:</strong> Content marked up with JSON-LD schema (Article, FAQPage, HowTo, etc.)</li>
            <li><strong>Verifiability:</strong> Clear citations, sources, and factual claims</li>
            <li><strong>Completeness:</strong> Comprehensive answers that address the full query</li>
            <li><strong>Authority:</strong> Content from trusted, authoritative sources</li>
            <li><strong>Freshness:</strong> Recent publication dates and regular updates</li>
          </ul>
          
          <h3>Our Approach</h3>
          <p>NRLC.ai implements the GEO-16 framework for AI Overview Optimization:</p>
          <ul>
            <li><strong>Structured Data Implementation:</strong> Comprehensive JSON-LD schema markup for all content types</li>
            <li><strong>Content Optimization:</strong> Rewrite content for AI citation with clear facts, sources, and structure</li>
            <li><strong>Technical SEO:</strong> Ensure proper rendering, canonical URLs, and metadata for AI crawlers</li>
            <li><strong>Citation Readiness:</strong> Format content for easy extraction and citation by AI models</li>
            <li><strong>Monitoring & Measurement:</strong> Track AI Overview appearances and citation rates</li>
          </ul>
          
          <h3>Key Benefits</h3>
          <ul>
            <li>Increase visibility in Google AI Overviews and AI-powered search</li>
            <li>Improve citation rates from AI answer engines</li>
            <li>Surface in AI-generated answers across ChatGPT, Perplexity, Claude, and other LLMs</li>
            <li>Build authority and trust signals for AI systems</li>
            <li>Future-proof your SEO strategy for AI-first search</li>
          </ul>
          
          <h3>Implementation Process</h3>
          <ol>
            <li><strong>Audit:</strong> Analyze current content structure, schema markup, and AI visibility</li>
            <li><strong>Strategy:</strong> Develop AI Overview optimization plan based on GEO-16 framework</li>
            <li><strong>Implementation:</strong> Add structured data, optimize content, and improve technical signals</li>
            <li><strong>Testing:</strong> Validate schema markup and test AI Overview appearance</li>
            <li><strong>Monitoring:</strong> Track AI Overview citations and optimize based on performance</li>
          </ol>
          
          <h3>Related Services</h3>
          <p>AI Overview Optimization works best when combined with:</p>
          <ul>
            <li><a href="/services/llm-seeding/">LLM Seeding & Citation Readiness</a> — Prepare content for AI citation</li>
            <li><a href="/services/json-ld-strategy/">JSON-LD & Structured Data Strategy</a> — Implement comprehensive schema markup</li>
            <li><a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> — Ensure technical SEO for AI crawlers</li>
          </ul>
          
          <div class="btn-group text-center" style="margin-top: var(--spacing-32);">
            <button type="button" class="btn btn--primary" onclick="openContactSheet('AI Overview Optimization')">Schedule Consultation</button>
            <a href="/services/" class="btn">View All Services</a>
            <a href="/insights/google-llms-txt-ai-seo/" class="btn">Learn About LLMs.txt</a>
          </div>
        </div>
      </div>
  </section>
  </main>
  <?php
  exit; // Exit early for AI Overview Optimization
}

// Default service page with city selection
$domain = 'https://nrlc.ai';

// Use exact canonical URL from Pages.csv if available
$enhancement = get_service_enhancement($service, '');
$canonical_url = $enhancement['canonical'] ?? ($domain . '/services/' . $service . '/');

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
    "serviceType" => get_service_type_from_slug($service),
    "provider" => [
      "@type" => "Organization",
      "name" => "Neural Command LLC",
      "url" => "https://nrlc.ai"
    ],
    "areaServed" => "Global",
    "url" => $canonical_url
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
        <?php
        $enhancement = get_service_enhancement($service, '');
        $intro = $enhancement['intro'] ?? null;
        $queryAlignedContent = get_query_aligned_content($service, '');
        ?>
        <?php if ($intro): ?>
        <p class="lead"><?= htmlspecialchars($intro) ?><?= $queryAlignedContent ? ' ' . htmlspecialchars($queryAlignedContent) : '' ?></p>
        <?php else: ?>
        <p class="lead">Select a city to see localized implementation and pricing for this service.<?= $queryAlignedContent ? ' ' . htmlspecialchars($queryAlignedContent) : '' ?></p>
        <?php endif; ?>
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
// STEP 5: Internal Linking Repair
// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Get related services for lateral linking
$relatedServices = get_related_services_for_linking($service, $locale);
?>

<!-- STEP 5: Related Services Footer Block -->
<section class="content-block module">
  <div class="content-block__header">
    <h2 class="content-block__title">Related Services</h2>
  </div>
  <div class="content-block__body">
    <ul>
      <?php foreach ($relatedServices as $related): ?>
      <li><a href="<?= htmlspecialchars($related['url']) ?>"><?= htmlspecialchars($related['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <p><a href="<?= htmlspecialchars($localePrefix . '/') ?>">Home</a> | <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>">All Services</a></p>
  </div>
</section>

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

