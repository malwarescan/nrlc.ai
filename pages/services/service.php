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

    <?php if ($service === 'ai-search-optimization'): ?>
    <!-- GEO CONFIRMATION BLOCK (Tier 1 Reinforcement) -->
    <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin: var(--spacing-md) 0;">
      <div class="content-block__body">
        <p style="margin: 0; font-weight: 500;"><strong>We work with companies across the United States and United Kingdom, including businesses in Norwich, London, and major technology hubs. All services are delivered remotely.</strong></p>
      </div>
    </div>
    <?php endif; ?>

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

    <?php if ($service === 'ai-search-optimization'): ?>
    <!-- Mid-page Internal Link to Norwich (Tier 1 Reinforcement) -->
    <div class="content-block module">
      <div class="content-block__body">
        <p>Looking for <a href="/en-gb/services/ai-seo-norwich/">AI SEO services in Norwich</a>? We provide specialized AI visibility optimization for businesses in Norwich and across the UK.</p>
      </div>
    </div>
    <?php endif; ?>

    <!-- Consultation Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Need Help Choosing?</h2>
      </div>
      <div class="content-block__body">
        <p>Our team can help you select the right city and service package for your needs. Contact us for personalized recommendations.</p>
        <p>Learn more about our <a href="/insights/">AI SEO Research & Insights</a> and explore our <a href="/tools/">SEO Tools & Resources</a> to enhance your search visibility.</p>
        <p class="text-center">
          <?php if ($service === 'ai-search-optimization'): ?>
          <!-- Tier 1 CTA Replacement: Aligns with informational → commercial hybrid intent -->
          <a href="/api/book/" class="btn btn--primary">Get a Free AI Visibility Audit</a>
          <p style="margin-top: var(--spacing-sm); font-size: 0.9rem; color: #666;">See how your site appears in Google AI Overviews and ChatGPT</p>
          <?php else: ?>
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
          <button type="button" class="btn" onclick="openContactSheet('<?= htmlspecialchars($serviceName) ?>')">Schedule Consultation</button>
          <?php endif; ?>
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

