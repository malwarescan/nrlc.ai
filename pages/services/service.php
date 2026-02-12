<?php
// Note: head.php and header.php are already included by router.php render_page()
// Do not duplicate them here to avoid double headers
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/service_enhancements.php';
require_once __DIR__.'/../../lib/nrlc_linking_kernel.php';
require_once __DIR__.'/../../lib/service_intent_taxonomy.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$service = $_GET['service'] ?? '';
$GLOBALS['__page_slug'] = 'services/service';

// INTENT TAXONOMY: Generate H1, subhead, and CTA based on URL contract (CLASS 1: Core Service or CLASS 4: Audit)
$intentContent = service_intent_content($service, null);
$pageTitle = $intentContent['h1'];
$subhead = $intentContent['subhead'];
$ctaText = $intentContent['cta'];
$ctaQualifier = $intentContent['cta_qualifier'];

// Service schema for the selection page
$serviceName = ucwords(str_replace('-',' ',$service));

// Special handling for semantic infrastructure services
$semanticServices = ['data-mapping', 'data-virtualization', 'rest-api', 'semantic-layer', 'enterprise-llm-foundation', 'knowledge-graph', 'ontology-modeling'];

// Special handling for AI SEO services with custom content
$aiSeoServices = ['ai-overviews-optimization'];

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
            <!-- CONVERSION PRIMITIVES: Phone, Email, CTA -->
            <div class="btn-group text-center" style="margin: 1.5rem 0;">
              <a href="tel:+12135628438" class="btn btn--primary">Call</a>
              <a href="mailto:hirejoelm@gmail.com" class="btn btn--primary">Email</a>
              <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($content['title']) ?>')">Book a Demo</button>
            </div>
            <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Response within 24 hours</p>
            <p class="text-center">
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
if ($service === 'ai-overviews-optimization') {
  $domain = 'https://nrlc.ai';
  $canonical_url = $domain . '/services/ai-overviews-optimization/';
  
  // SUDO CANONICAL: Set meta title and description (final)
  // Override router meta directive to use canonical values
  $GLOBALS['__page_meta'] = [
    'title' => 'AI Overview Optimization for Google AI Search | Neural Command',
    'description' => 'Explains how Google AI Overviews select sources, what makes content citable by AI systems, and how websites optimize for AI-generated answers.',
    'canonicalPath' => '/en-us/services/ai-overviews-optimization/'
  ];
  $GLOBALS['pageTitle'] = $GLOBALS['__page_meta']['title'];
  $GLOBALS['pageDesc'] = $GLOBALS['__page_meta']['description'];
  
  // SUDO PAGE RESTRUCTURE: Full @graph schema stack (production-ready)
  $GLOBALS['__jsonld'] = [
    [
      "@context" => "https://schema.org",
      "@graph" => [
        [
          "@type" => "Organization",
          "@id" => "https://nrlc.ai/#organization",
          "name" => "Neural Command",
          "url" => "https://nrlc.ai/",
          "logo" => "https://nrlc.ai/logo.png",
          "sameAs" => [
            "https://www.linkedin.com/company/neural-command/",
            "https://g.co/kgs/EP6p5de"
          ]
        ],
        [
          "@type" => "WebPage",
          "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#webpage",
          "url" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/",
          "name" => "AI Overview Optimization for Google AI Search",
          "description" => $GLOBALS['pageDesc'],
          "isPartOf" => [
            "@id" => "https://nrlc.ai/#organization"
          ],
          "mainEntity" => [
            ["@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#article"],
            ["@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#service"],
            ["@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#faq"]
          ],
          "breadcrumb" => [
            "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#breadcrumbs"
          ]
        ],
        [
          "@type" => "Article",
          "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#article",
          "headline" => "What AI Overview Optimization Is and Why It Determines AI Visibility",
          "description" => "Explains how Google AI Overviews select sources and what structural signals make content citable by AI systems.",
          "author" => [
            "@id" => "https://nrlc.ai/#organization"
          ],
          "publisher" => [
            "@id" => "https://nrlc.ai/#organization"
          ],
          "mainEntityOfPage" => [
            "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#webpage"
          ]
        ],
        [
          "@type" => "Service",
          "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#service",
          "name" => "AI Overview Optimization",
          "serviceType" => "AI Search Optimization",
          "provider" => [
            "@id" => "https://nrlc.ai/#organization"
          ],
          "description" => "A service that restructures content to improve eligibility for citation and visibility in Google AI Overviews and AI-powered search systems.",
          "areaServed" => "Worldwide"
        ],
        [
          "@type" => "FAQPage",
          "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#faq",
          "mainEntity" => [
            [
              "@type" => "Question",
              "name" => "What are Google AI Overviews?",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Google AI Overviews are AI-generated summaries in search results that answer informational or complex queries using multiple sources."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "How does Google choose sources for AI Overviews?",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Sources are chosen based on clarity, topical relevance, structure, and how safely the information can be summarized without distortion."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "Can a service page be cited in AI Overviews?",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Yes. Service pages can be cited when they include neutral explanations, question-based headings, and schema that mirrors visible content."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "Does structured data guarantee AI Overview visibility?",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "No. Structured data improves understanding and eligibility, but inclusion depends on query type, confidence, and source selection behavior."
              ]
            ]
          ]
        ],
        [
          "@type" => "BreadcrumbList",
          "@id" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/#breadcrumbs",
          "itemListElement" => [
            [
              "@type" => "ListItem",
              "position" => 1,
              "name" => "Services",
              "item" => "https://nrlc.ai/en-us/services/"
            ],
            [
              "@type" => "ListItem",
              "position" => 2,
              "name" => "AI Overview Optimization",
              "item" => "https://nrlc.ai/en-us/services/ai-overviews-optimization/"
            ]
          ]
        ]
      ]
    ]
  ];
  ?>
  <main role="main">
  
  <!-- SECTION 1: HERO (EXPLAINER-FIRST, CRO-SECOND) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h1 class="content-block__title">What AI Overview Optimization Is and Why It Determines AI Visibility</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Google AI Overviews select sources based on clarity, structure, and citation safety — not just classic ranking signals.</p>
        <p>This page explains how source selection works and how websites structure content to become citable.</p>
        
        <div style="margin: var(--spacing-12) 0;">
          <p><strong>Hero Microproof:</strong></p>
          <ul>
            <li>How AI Overviews select sources</li>
            <li>Signals that make content citable</li>
            <li>What this service changes on your site</li>
          </ul>
        </div>
        
        <div class="btn-group" style="margin-top: var(--spacing-16);">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('AI Overview Optimization')">See how this applies to your site</button>
          <a href="#how-ai-overviews-select" class="btn">Read the source-selection signals</a>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 2: HOW AI OVERVIEWS SELECT SOURCES (MECHANISM BLOCK) -->
  <section id="how-ai-overviews-select" class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">How Google AI Overviews Select Sources</h2>
      </div>
      <div class="content-block__body">
        <p>Google AI Overviews generate answers by synthesizing information from multiple trusted sources. Pages are selected based on how clearly they explain a concept, how easily the information can be extracted, and whether the content appears reliable and neutral.</p>
        
        <p>AI systems favor pages that define topics, explain mechanisms, and answer common questions directly. Pages that read primarily as sales or promotional content are less likely to be cited.</p>
        
        <p>Source selection prioritizes content that can be summarized safely without distortion. This means pages with clear definitions, consistent terminology, and neutral explanations are more likely to be selected.</p>
        
        <p>The selection process evaluates structural signals: heading hierarchy, paragraph clarity, and how well the content answers specific questions. Pages that require interpretation or contain ambiguous claims are deprioritized.</p>
        
        <p>This mechanism ensures AI Overviews cite reliable, extractable information rather than promotional claims or vague statements.</p>
        
        <div style="margin: var(--spacing-12) 0; padding: var(--spacing-12); background: var(--color-bg-secondary, #f5f5f5); border-radius: 4px;">
          <p><strong>AI Overviews prefer pages that:</strong></p>
          <ul>
            <li>Define concepts directly</li>
            <li>Use consistent terminology (entities)</li>
            <li>Use structured headings that match real questions</li>
            <li>Provide neutral explanations that can be quoted safely</li>
            <li>Reinforce meaning with accurate JSON-LD</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 3: SIGNALS AI TRUSTS (FEATURES) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">Signals AI Models Trust on Service Pages</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit" style="gap: var(--spacing-12); margin-top: var(--spacing-12);">
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Extractability</h3>
            </div>
            <div class="content-block__body">
              <p>Short, declarative paragraphs and question-based headings that AI can summarize without guessing.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Entity Consistency</h3>
            </div>
            <div class="content-block__body">
              <p>Clean definitions and consistent terms so AI can map meaning without ambiguity.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Structured Reinforcement</h3>
            </div>
            <div class="content-block__body">
              <p>Schema that mirrors visible content and declares relationships explicitly.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 4: WHY TRADITIONAL SEO IS NOT ENOUGH (OBJECTION HANDLING) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Traditional SEO Often Fails in AI Overviews</h2>
      </div>
      <div class="content-block__body">
        <p>Traditional SEO focuses on rankings, backlinks, and keyword relevance. AI Overviews focus on comprehension, confidence, and summarization safety.</p>
        
        <p>A page can rank well in classic search while being ignored by AI systems if the content is difficult to summarize, overly promotional, or lacks clear conceptual structure.</p>
        
        <ul>
          <li>A page can rank but be non-citable</li>
          <li>Promotional framing reduces extraction safety</li>
          <li>Lack of explicit definitions lowers confidence</li>
          <li>Missing FAQ/schema reduces structured answer eligibility</li>
        </ul>
        
        <p>AI optimization addresses this gap by aligning content with how AI models interpret and reuse information.</p>
      </div>
    </div>
  </section>

  <!-- SECTION 5: TRANSFORMATION / PROCESS -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">How Content Moves From Ignored to Cited</h2>
      </div>
      <div class="content-block__body">
        <div style="margin-top: var(--spacing-12);">
          <div style="margin-bottom: var(--spacing-16);">
            <h3>Step 1 — Classification Fix</h3>
            <p>We rewrite early sections so the page reads as an explainer, not an ad.</p>
          </div>
          
          <div style="margin-bottom: var(--spacing-16);">
            <h3>Step 2 — Structural Alignment</h3>
            <p>We reshape headings and paragraphs so answers are extractable.</p>
          </div>
          
          <div style="margin-bottom: var(--spacing-16);">
            <h3>Step 3 — Schema Reinforcement</h3>
            <p>We implement layered JSON-LD that mirrors the on-page explanation.</p>
          </div>
          
          <div style="margin-bottom: var(--spacing-16);">
            <h3>Step 4 — Internal Graph Support</h3>
            <p>We link the page as a canonical explainer node across your site.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 6: PROOF BLOCKS (DELIVERABLES) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Service Produces (Concrete Outputs)</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit" style="gap: var(--spacing-12); margin-top: var(--spacing-12);">
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">AI Overview Source-Selection Audit</h3>
            </div>
            <div class="content-block__body">
              <p>Page-by-page analysis of citation eligibility and structural gaps.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Rewrite Spec for Extraction Zones</h3>
            </div>
            <div class="content-block__body">
              <p>Hero and first 30% restructured for AI-safe explanation.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Schema Stack</h3>
            </div>
            <div class="content-block__body">
              <p>WebPage + Article + FAQPage + Service + BreadcrumbList implementation.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Internal Linking Map</h3>
            </div>
            <div class="content-block__body">
              <p>Canonical explainer node establishment across your site.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Query Intent Alignment</h3>
            </div>
            <div class="content-block__body">
              <p>Prompt-surface and query intent alignment recommendations.</p>
            </div>
          </div>
        </div>
        
        <div style="margin-top: var(--spacing-16); padding: var(--spacing-12); background: var(--color-bg-secondary, #f5f5f5); border-radius: 4px;">
          <p><strong>What we do NOT do:</strong></p>
          <ul>
            <li>We do not guarantee inclusion in AI Overviews</li>
            <li>We do not fabricate authority signals or reviews</li>
            <li>We do not publish schema that contradicts visible content</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 7: SERVICE SHOWCASE (PACKAGE OPTIONS) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">Engagement Options</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit" style="gap: var(--spacing-12); margin-top: var(--spacing-12);">
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Audit Only</h3>
            </div>
            <div class="content-block__body">
              <p>For teams who will implement changes internally.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Audit + Implementation</h3>
            </div>
            <div class="content-block__body">
              <p>We implement the structural + schema changes directly.</p>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Ongoing Monitoring</h3>
            </div>
            <div class="content-block__body">
              <p>Ongoing updates as AI search layouts and citation behavior change.</p>
            </div>
          </div>
        </div>
        
        <div class="btn-group text-center" style="margin-top: var(--spacing-16);">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('AI Overview Optimization')">Request an evaluation</button>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 8: FAQ (MUST MATCH FAQPAGE SCHEMA VERBATIM) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">FAQ</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt><strong>What are Google AI Overviews?</strong></dt>
          <dd>Google AI Overviews are AI-generated summaries in search results that answer informational or complex queries using multiple sources.</dd>
          
          <dt><strong>How does Google choose sources for AI Overviews?</strong></dt>
          <dd>Sources are chosen based on clarity, topical relevance, structure, and how safely the information can be summarized without distortion.</dd>
          
          <dt><strong>Can a service page be cited in AI Overviews?</strong></dt>
          <dd>Yes. Service pages can be cited when they include neutral explanations, question-based headings, and schema that mirrors visible content.</dd>
          
          <dt><strong>Does structured data guarantee AI Overview visibility?</strong></dt>
          <dd>No. Structured data improves understanding and eligibility, but inclusion depends on query type, confidence, and source selection behavior.</dd>
        </dl>
      </div>
    </div>
  </section>

  <!-- SECTION 9: FINAL CTA (CONVERSION RELEASE VALVE) -->
  <section class="container section" style="padding: var(--spacing-8) 0;">
    <div class="content-block module" style="margin-bottom: 0;">
      <div class="content-block__header">
        <h2 class="content-block__title">See How This Applies to Your Site</h2>
      </div>
      <div class="content-block__body">
        <p>If your pages are ranking but not being cited, the issue is usually structure and extractability — not keywords.</p>
        <p>We can identify which pages are non-citable and specify the exact changes required.</p>
        
        <div class="btn-group text-center" style="margin-top: var(--spacing-16);">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('AI Overview Optimization')">Request an evaluation</button>
          <a href="/contact/" class="btn">Contact</a>
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

// Citeability: schema URLs must match page canonical (locale-prefixed, e.g. /en-us/services/generative-seo/)
$canonicalPath = $GLOBALS['__page_meta']['canonicalPath'] ?? '/en-us/services/' . $service . '/';
$canonical_url = function_exists('absolute_url') ? absolute_url($canonicalPath) : ($domain . $canonicalPath);

// FAQ set for generic service pages (E-E-A-T + FAQ rich results)
$serviceFaqs = [
  ['q' => "What is {$serviceName}?", 'a' => "{$serviceName} is a professional service from Neural Command that improves how search engines and AI systems find, understand, and cite your business. We focus on entity clarity, structured data, and content that aligns with how AI systems evaluate and recommend."],
  ['q' => 'How do I get started?', 'a' => 'Book a free consultation at nrlc.ai/en-us/book/. We review your current visibility and outline a strategy. No obligation; response within 24 hours.'],
  ['q' => 'Do you work with small businesses?', 'a' => 'Yes. We work with SMBs, mid-market companies, and enterprises. Scope and approach are tailored to your size and goals.'],
  ['q' => 'How long until we see results?', 'a' => 'Timeline depends on scope—audits and structural fixes can show impact in weeks; full implementation and AI citation shifts often take longer. We outline expectations in the consultation.'],
  ['q' => 'Do you serve Santa Monica and LA?', 'a' => 'Yes. Neural Command is headquartered in Santa Monica and serves Los Angeles, California, and nationwide (including UK).']
];

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
    "provider" => ["@id" => "https://nrlc.ai/#organization"],
    "areaServed" => $service === 'ai-search-optimization' 
      ? [
          ["@type" => "Country", "name" => "United States"],
          ["@type" => "Country", "name" => "United Kingdom"],
          ["@type" => "City", "name" => "Norwich"]
        ]
      : "Global",
    "url" => $canonical_url
  ]
];

$faqSchema = ld_faq($serviceFaqs);
$faqSchema['@id'] = $canonical_url . '#faq';
$GLOBALS['__jsonld'][] = $faqSchema;
?>

<main role="main">
<section class="container section">
    
    <!-- Hero Content Block (GBP-ALIGNED: Above-the-fold classifier) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title"><?= htmlspecialchars($pageTitle) ?></h1>
      </div>
      <div class="content-block__body">
        <?php
        // GBP-ALIGNED: First sentence must clearly state business provides service
        $gbpName = gbp_business_name();
        echo '<p class="lead">' . htmlspecialchars($gbpName . ' provides ' . $serviceName . ' for businesses.') . '</p>';
        ?>
        <p class="lead"><?= htmlspecialchars($subhead) ?></p>
        <!-- INTENT TAXONOMY CTA: Must name the service explicitly -->
        <div class="btn-group text-center" style="margin: 1.5rem 0;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('<?= htmlspecialchars($ctaText) ?>')"><?= htmlspecialchars($ctaText) ?></button>
        </div>
        <p style="text-align: center; font-size: 0.9rem; color: #666; margin-top: 0.5rem;"><?= htmlspecialchars($ctaQualifier) ?></p>
      </div>
    </div>

    <!-- Proof block: E-E-A-T and methodology (META DIRECTIVE: money page proof) -->
    <div class="content-block module" style="background: #f9f9f9; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Neural Command</h2>
      </div>
      <div class="content-block__body">
        <p>Neural Command implements the <strong>GEO-16 framework</strong> and <strong>Answer First Architecture</strong> to improve how often brands are cited in AI-generated answers. Our methodology is documented in peer-observed research and applied across site audits, structured data, and training. We focus on entity clarity, retrieval signals, and citation-ready content so AI systems can extract and cite your brand with confidence.</p>
      </div>
    </div>

    <?php if ($service === 'ai-search-optimization'): ?>
    <!-- GEO CONFIRMATION BLOCK (Tier 1 Reinforcement) -->
    <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; margin: var(--spacing-md) 0;">
      <div class="content-block__body">
        <p style="margin: 0; font-weight: 500;"><strong>We work with companies across the United States and United Kingdom, including businesses in Norwich, London, and major technology hubs. All services are delivered remotely.</strong></p>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($service === 'site-audits'): ?>
    <!-- PRICING & SCOPE SECTION (META DIRECTIVE: PRICING & RESULTS TRANSPARENCY) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Pricing & Scope</h2>
      </div>
      <div class="content-block__body">
        <?php
        // Currency detection: UK pages use GBP, US pages use USD
        $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $isUK = (strpos($currentPath, '/en-gb/') === 0);
        if ($isUK) {
          $priceRange = '£3,500 to £18,000';
        } else {
          // USD equivalent maintaining same positioning
          $priceRange = '$4,500 to $23,000';
        }
        ?>
        <p>Audit and diagnostic engagements typically range from <strong><?= htmlspecialchars($priceRange) ?></strong>, depending on scope and complexity.</p>
        <p>Cost is driven by factors such as site architecture, content structure, scale, and the level of ambiguity in how your site is currently interpreted by search engines and language models.</p>
        <p>This is not a per-page or per-URL exercise. Smaller sites can be more complex than larger ones, and visibility issues are rarely linear.</p>
        <p>If your goal is a low-cost checklist or automated scan, this will not be a fit.</p>
      </div>
    </div>

    <!-- HOW RESULTS ARE ACHIEVED SECTION (META DIRECTIVE: PRICING & RESULTS TRANSPARENCY) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How results are achieved</h2>
      </div>
      <div class="content-block__body">
        <p>Results do not come from applying fixes blindly.</p>
        <p>They come from reducing ambiguity and aligning how systems interpret your site.</p>
        <p>Our work focuses on clarifying entity relationships, resolving conflicting signals, and aligning structure and content with how search engines and language models actually process information.</p>
        <p>This approach avoids surface-level recommendations and prioritizes changes that meaningfully affect how your site is understood and surfaced.</p>
        <p>There are no shortcuts, and there are no guarantees. Results depend on implementation, context, and how systems evolve over time.</p>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($service !== 'ai-search-optimization'): ?>
    <?php
    // DYNAMIC CITY LISTING: Get all available cities for this service
    $availableCities = get_cities_for_service($service, 0); // 0 = all cities
    
    // Prioritize major cities for display (show top 12, then "View All" if more exist)
    $majorCities = ['new-york', 'london', 'san-francisco', 'toronto', 'los-angeles', 'chicago', 'boston', 'seattle', 'manchester', 'birmingham', 'edinburgh', 'glasgow'];
    $prioritizedCities = [];
    $otherCities = [];
    
    foreach ($availableCities as $city) {
      if (in_array($city['city'], $majorCities)) {
        $prioritizedCities[] = $city;
      } else {
        $otherCities[] = $city;
      }
    }
    
    // Sort prioritized cities by the order in $majorCities
    usort($prioritizedCities, function($a, $b) use ($majorCities) {
      $posA = array_search($a['city'], $majorCities);
      $posB = array_search($b['city'], $majorCities);
      if ($posA === false) $posA = 999;
      if ($posB === false) $posB = 999;
      return $posA <=> $posB;
    });
    
    // Combine: prioritized first, then others (alphabetically)
    $displayCities = array_merge($prioritizedCities, $otherCities);
    $showAllLink = count($availableCities) > 12;
    $displayCities = array_slice($displayCities, 0, 12);
    
    // Build ItemList schema for city listings
    $cityListItems = [];
    foreach ($displayCities as $index => $city) {
      $cityUrl = canonical_internal_url("/services/{$service}/{$city['city']}/");
      $cityListItems[] = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $city['name'],
        'item' => $cityUrl
      ];
    }
    ?>
    
    <!-- City Selection Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Available Cities</h2>
      </div>
      <div class="content-block__body">
        <?php if (empty($displayCities)): ?>
          <p>Service available globally. <a href="/contact/">Contact us</a> to discuss your location-specific needs.</p>
        <?php else: ?>
          <p>We provide <?= htmlspecialchars($serviceName) ?> services in cities across the United States, United Kingdom, and internationally. Select a city below to view location-specific information and expertise.</p>
          
          <div class="grid grid-auto-fit">
            <?php foreach ($displayCities as $city): 
              // Generate service-specific description
              $cityDescription = get_service_city_description($service, $city['name'], $city['isUK']);
              
              // Generate canonical URL with proper locale prefix
              $cityUrl = canonical_internal_url("/services/{$service}/{$city['city']}/");
              $cityPath = parse_url($cityUrl, PHP_URL_PATH);
              
              // Get related services in this city (for cross-linking)
              $relatedServices = get_related_services_in_city($service, $city['city'], 2);
            ?>
            <div class="content-block">
              <div class="content-block__header">
                <h3 class="content-block__title"><?= htmlspecialchars($city['name']) ?></h3>
              </div>
              <div class="content-block__body">
                <p><?= htmlspecialchars($cityDescription) ?></p>
                
                <div class="btn-group" style="margin-bottom: var(--spacing-sm);">
                  <a href="<?= htmlspecialchars($cityPath) ?>" class="btn btn--primary" title="<?= htmlspecialchars($serviceName) ?> in <?= htmlspecialchars($city['name']) ?>">View in <?= htmlspecialchars($city['name']) ?></a>
                </div>
                
                <?php if (!empty($relatedServices)): ?>
                  <div style="margin-top: var(--spacing-sm); padding-top: var(--spacing-sm); border-top: 1px solid #e0e0e0;">
                    <p style="font-size: 0.875rem; color: #666; margin-bottom: 0.5rem;">Also available in <?= htmlspecialchars($city['name']) ?>:</p>
                    <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.875rem;">
                      <?php foreach ($relatedServices as $related): ?>
                        <li style="margin-bottom: 0.25rem;">
                          <a href="<?= htmlspecialchars($related['url']) ?>" title="<?= htmlspecialchars($related['name']) ?>"><?= htmlspecialchars($related['name']) ?></a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          
          <?php if ($showAllLink): ?>
            <div style="margin-top: var(--spacing-lg); text-align: center;">
              <p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-sm);">
                We provide services in <?= count($availableCities) ?> cities worldwide.
              </p>
              <p>
                <a href="/contact/?service=<?= urlencode($service) ?>" class="btn btn--secondary" title="Contact us for services in your city">Contact Us for Your City</a>
              </p>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
    
    <?php
    // Add ItemList schema for city listings (SEO best practice)
    if (!empty($cityListItems)) {
      $GLOBALS['__jsonld'][] = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        '@id' => $canonical_url . '#city-list',
        'name' => "Available Cities for {$serviceName}",
        'description' => "Cities where {$serviceName} services are available",
        'itemListElement' => $cityListItems
      ];
    }
    ?>
    <?php endif; ?>

    <?php if ($service === 'ai-search-optimization'): ?>
    <!-- Mid-page Internal Link to Norwich (Tier 1 Reinforcement) -->
    <div class="content-block module">
      <div class="content-block__body">
        <p>Looking for <a href="/en-gb/services/ai-seo-norwich/" title="AI SEO and AI visibility services for businesses in Norwich">AI SEO services in Norwich</a>? We provide specialized AI visibility optimization for businesses in Norwich and across the UK.</p>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($service === 'ai-search-optimization'): ?>
    <!-- Service Explanation for AI Search Optimization -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Do</h2>
      </div>
      <div class="content-block__body">
        <p>We analyze how AI systems currently describe your business, your services, and your competitors. Then we restructure your website and digital signals so AI assistants understand exactly what you do, trust your expertise, reference your business accurately, and prefer you when explaining relevant options.</p>
        <p>This includes:</p>
        <ul>
          <li>Service definition clarity—unambiguous descriptions that AI systems can extract and cite</li>
          <li>Consistent terminology—using the same language across all pages and signals</li>
          <li>Structured data completeness—schema markup that reinforces entity relationships</li>
          <li>Authority signal alignment—content that demonstrates expertise without hype</li>
          <li>Intent matching—pages that answer the questions AI systems are actually answering</li>
        </ul>
        <p>We don't try to trick AI. We make your business unambiguous.</p>
      </div>
    </div>

    <!-- Primary CTA (Placement 1: Above-the-fold equivalent) -->
    <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; margin: var(--spacing-md) 0;">
      <div class="content-block__body">
        <p style="margin: 0 0 var(--spacing-sm) 0; font-weight: 500;"><strong>See How AI Systems Currently Describe Your Business</strong></p>
        <p style="margin: 0;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Get a Free AI Visibility Audit')">Get a Free AI Visibility Audit</button>
        </p>
        <p style="margin-top: var(--spacing-sm); font-size: 0.9rem; color: #666; margin-bottom: 0;">See how your site appears in Google AI Overviews and ChatGPT</p>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($service === 'site-audits'): ?>
    <!-- CTA STRUCTURE (DIAGNOSTIC-FIRST) -->
    <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; margin-top: var(--spacing-lg);">
      <div class="content-block__body">
        <p style="margin: 0 0 var(--spacing-md) 0; font-weight: 500;"><strong>Run a Diagnostic First</strong></p>
        <p style="margin: 0 0 var(--spacing-md) 0; font-size: 0.9rem; color: #666;">Understand your visibility issues before requesting an audit.</p>
        <p style="margin: 0 0 var(--spacing-md) 0;">
          <a href="<?= htmlspecialchars($localePrefix . '/resources/diagnostic/') ?>" class="btn btn--primary" title="Run a diagnostic to understand your visibility issues">Run a Diagnostic First</a>
        </p>
        <p style="margin: var(--spacing-md) 0 0 0; font-size: 0.9rem; color: #666;">Or, if you are ready to request an audit:</p>
        <p style="margin: var(--spacing-sm) 0 0 0;">
          <button type="button" class="btn btn--secondary" onclick="openContactSheet('Site Audit Request')" title="Request a site audit">Request an Audit</button>
        </p>
      </div>
    </div>
    <?php elseif ($service === 'ai-search-optimization'): ?>
    <!-- Consultation Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Next Steps</h2>
      </div>
      <div class="content-block__body">
        <p>An AI Visibility Audit measures how ChatGPT, Google AI Overviews, Perplexity, and Claude currently describe your business. You'll receive a breakdown of where competitors are being favored, what AI Trust Signals are missing, and a prioritized fix list.</p>
        <p class="text-center">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Get a Free AI Visibility Audit')">Get a Free AI Visibility Audit</button>
        </p>
        <p style="margin-top: var(--spacing-sm); font-size: 0.9rem; color: #666; text-align: center;">See how your site appears in Google AI Overviews and ChatGPT</p>
      </div>
    </div>
    <?php else: ?>
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
    <?php endif; ?>

    <!-- FAQ section (META DIRECTIVE: 3–6 FAQs + FAQPage schema) -->
    <div class="content-block module" id="faq" itemscope itemtype="https://schema.org/FAQPage">
      <div class="content-block__header">
        <h2 class="content-block__title">Frequently Asked Questions</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <?php foreach ($serviceFaqs as $faq): ?>
          <dt><strong><?= htmlspecialchars($faq['q']) ?></strong></dt>
          <dd><?= htmlspecialchars($faq['a']) ?></dd>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>

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
    <div class="content-block module">
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
    </div>

    <?php
    // LINKING KERNEL: Add required internal links
    if (function_exists('render_internal_links_section')) {
      echo render_internal_links_section('services', $service, [], 'Related Resources');
    }
    ?>

  </div>
</section>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>

