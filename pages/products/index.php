<?php
// Metadata is now set by the router via sudo_meta_directive_ctx()
// See bootstrap/router.php for products/index metadata configuration
// Note: head.php and header.php are already included by router.php render_page()
// Do not set $GLOBALS['pageTitle'] or $GLOBALS['pageDesc'] here - they are ignored

require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

$domain = 'https://nrlc.ai';
$canonicalUrl = absolute_url('/en-us/products/');
$orgId = SchemaFixes::ensureHttps($domain) . '#organization';
$personId = SchemaFixes::ensureHttps($domain) . '#joel-maldonado';

// Enhance metadata with keywords
if (isset($GLOBALS['__page_meta']) && is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'AI SEO tools, structured knowledge tools, AI search tools, schema tools, Neural Command OS, Googlebot Renderer Lab, Croutons.ai, Precogs, Applicants.io, OurCasa.ai, NEWFAQ, Prompt Surface Intelligence, AI visibility tools, structured data tools';
}
?>

<main role="main" class="container" itemscope itemtype="https://schema.org/CollectionPage">
<article itemscope itemtype="https://schema.org/Article" class="section">
  <div class="section__content">
    
    <!-- Products Header Content Block -->
    <header class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title" itemprop="headline"><strong>AI Search</strong> and <strong>Structured Knowledge</strong> Tools</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" itemprop="description"><strong>AI SEO</strong> and <strong>AI visibility</strong> tools for <strong>structured knowledge</strong>, <strong>search optimization</strong>, and <strong>generative engine visibility</strong>.</p>
        <p>Explore our comprehensive <a href="<?= absolute_url('/en-us/services/') ?>" title="AI SEO services"><strong>AI SEO Services</strong></a> and discover related <a href="<?= absolute_url('/en-us/insights/') ?>" title="AI SEO research and insights"><strong>AI SEO Research & Insights</strong></a>. Learn more about our <a href="<?= absolute_url('/en-us/tools/') ?>" title="SEO tools and resources"><strong>SEO Tools & Resources</strong></a>.</p>
        <div class="btn-group" style="margin-top: var(--spacing-lg);">
          <a href="<?= absolute_url('/en-us/services/') ?>" class="btn btn--primary">View Services</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary">Book Consultation</a>
        </div>
      </div>
    </header>

    <!-- PRODUCT CATEGORIES DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
    <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Product Categories: <strong>Structured Knowledge Tools</strong>, <strong>AI Search Tools</strong>, and <strong>SEO Diagnostics</strong></h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt id="structured-knowledge-tools" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>Structured Knowledge Tools</strong></dfn>
          </dt>
          <dd itemprop="description">
            Tools that convert unstructured data into <strong>machine-verifiable truth infrastructure</strong>, enabling <strong>AI systems</strong> to extract, understand, and cite information accurately. These tools implement <strong>schema markup</strong>, <strong>entity mapping</strong>, and <strong>semantic structure</strong> that improves <strong>AI visibility</strong> and <strong>citation eligibility</strong>.
          </dd>
          
          <dt id="ai-search-tools" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>AI Search Tools</strong></dfn>
          </dt>
          <dd itemprop="description">
            Tools that optimize content for <strong>AI search systems</strong> including <strong>ChatGPT</strong>, <strong>Perplexity</strong>, <strong>Google AI Overviews</strong>, and other <strong>generative engines</strong>. These tools analyze <strong>retrieval mechanics</strong>, <strong>citation patterns</strong>, and <strong>AI visibility</strong> to improve how businesses appear in <strong>AI-generated answers</strong>.
          </dd>
          
          <dt id="seo-diagnostics-tools" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>SEO Diagnostics Tools</strong></dfn>
          </dt>
          <dd itemprop="description">
            Tools that diagnose <strong>technical SEO</strong> issues, simulate <strong>search engine crawlers</strong>, and identify problems that prevent <strong>indexing</strong> and <strong>ranking</strong>. These tools solve <strong>hydration failures</strong>, <strong>CSR/SSR drift</strong>, and <strong>crawl-time abort replication</strong> for modern <abbr title="Search Engine Optimization">SEO</abbr> diagnostics.
          </dd>
        </dl>
      </div>
    </section>

    <!-- Products List -->
    <nav aria-label="AI SEO Products" class="content-block module" itemscope itemtype="https://schema.org/ItemList">
      <div class="content-block__body">
        
        <!-- Data, But Structured -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="1">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/data-but-structured/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Data, But Structured</strong> – <strong>Structured Knowledge</strong> & <strong>Schema Literacy</strong> Book</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Foundational book defining <strong>structured knowledge</strong>, <strong>micro-fact cognition</strong>, <strong>agentic search</strong>, <strong>data ontology</strong>, <strong>AI visibility</strong>, and <strong>schema literacy</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/data-but-structured/') ?>" class="btn" title="Structured knowledge and schema literacy book">Learn More</a>
            </div>
          </div>
        </div>

        <!-- Applicants.io -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="2">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/applicants-io/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Applicants.io</strong> – <strong>AI Recruiting</strong> & <strong>JobPosting Schema</strong> Automation Tool</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description"><strong>AI recruiting</strong> platform with <strong>JobPosting schema</strong> automation, <strong>Google Jobs</strong> indexing, <strong>resume crawling</strong>, and <strong>AI-driven applicant ranking</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/applicants-io/') ?>" class="btn" title="AI recruiting and JobPosting schema automation tool">Learn More</a>
            </div>
          </div>
        </div>

        <!-- OurCasa.ai -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="3">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/ourcasa-ai/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>OurCasa.ai</strong> – <strong>Home Intelligence</strong> & <strong>Property Data</strong> Platform</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description"><strong>Home</strong> and <strong>neighborhood intelligence graph</strong> with <strong>property cognition</strong>, <strong>weather risk mapping</strong>, <strong>local incident history</strong>, and <strong>maintenance prediction</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/ourcasa-ai/') ?>" class="btn" title="Home intelligence and property data platform">Learn More</a>
            </div>
          </div>
        </div>

        <!-- Croutons.ai -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="4">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/croutons-ai/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Croutons.ai</strong> – <strong>Data Atomization</strong> & <strong>Machine-Verifiable Truth</strong> Engine</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description"><strong>Micro-fact data atomization</strong> engine converting <strong>HTML</strong>, <strong>PDFs</strong>, <strong>CSVs</strong>, <strong>NDJSON streams</strong>, and <strong>APIs</strong> into <strong>machine-verifiable truth infrastructure</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/croutons-ai/') ?>" class="btn" title="Data atomization and machine-verifiable truth engine">Learn More</a>
            </div>
          </div>
        </div>

        <!-- Precogs -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="5">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/precogs/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Precogs</strong> – <strong>Ontological Intelligence</strong> & <strong>Predictive Reasoning</strong> Engine</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description"><strong>Ontological oracle intelligence</strong> engine with <strong>predictive reasoning</strong>, <strong>multi-domain cognition</strong>, <strong>temporal simulation</strong>, and <strong>real-time agentic intelligence</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/precogs/') ?>" class="btn" title="Ontological intelligence and predictive reasoning engine">Learn More</a>
            </div>
          </div>
        </div>

        <!-- Googlebot Renderer Lab -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="6">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/googlebot-renderer-lab/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Googlebot Renderer Lab</strong> – <abbr title="Search Engine Optimization">SEO</abbr> Diagnostics & <strong>Googlebot Simulation</strong> Tool</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Real <strong>Googlebot DOM simulation</strong> solving <strong>hydration failures</strong>, <strong>CSR/SSR drift</strong>, and <strong>crawl-time abort replication</strong> for modern <abbr title="Search Engine Optimization">SEO</abbr> diagnostics.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/googlebot-renderer-lab/') ?>" class="btn" title="SEO diagnostics and Googlebot simulation tool">Learn More</a>
            </div>
          </div>
        </div>

        <!-- NEWFAQ -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="7">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/newfaq/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>NEWFAQ</strong> – <strong>FAQ</strong> & <strong>Business Intelligence</strong> Engine for <abbr title="Search Engine Optimization">SEO</abbr> Visibility</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description"><strong>Sentient FAQ</strong> and <strong>business intelligence</strong> engine that learns from <strong>queries</strong>, expands dynamically, and generates breakthrough <abbr title="Search Engine Optimization">SEO</abbr> visibility.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/newfaq/') ?>" class="btn" title="FAQ and business intelligence engine for SEO visibility">Learn More</a>
            </div>
          </div>
        </div>

        <!-- Neural Command OS -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="8">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/neural-command-os/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Neural Command OS</strong> – <strong>Agentic SEO</strong> & <strong>LLM Visibility</strong> Operating System</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Universal <strong>operating system</strong> powering <strong>agentic SEO</strong>, <strong>schema generation</strong>, <strong>authority scoring</strong>, <strong>LLM visibility modeling</strong>, and <strong>semantic linking</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/neural-command-os/') ?>" class="btn" title="Agentic SEO and LLM visibility operating system">Learn More</a>
            </div>
          </div>
        </div>

        <!-- Prompt Surface Intelligence -->
        <div class="content-block module" itemscope itemtype="https://schema.org/ListItem">
          <meta itemprop="position" content="9">
          <div class="content-block__header">
            <h2 class="content-block__title">
              <a href="<?= absolute_url('/en-us/products/prompt-surface-intelligence/') ?>" itemprop="item" style="text-decoration: none; color: inherit;">
                <span itemprop="name"><strong>Prompt Surface Intelligence</strong> – <strong>AI Search Prompt</strong> Analysis & <strong>Visibility</strong> Tool</span>
              </a>
            </h2>
          </div>
          <div class="content-block__body">
            <p itemprop="description">Identify the real <strong>prompts</strong> your website appears in across <strong>Google</strong>, <strong>AI Overviews</strong>, <strong>ChatGPT</strong>, <strong>Claude</strong>, and <strong>Perplexity</strong>.</p>
            <div class="btn-group">
              <a href="<?= absolute_url('/en-us/products/prompt-surface-intelligence/') ?>" class="btn" title="AI search prompt analysis and visibility tool">Learn More</a>
            </div>
          </div>
        </div>

      </div>
    </nav>

    <!-- Related Resources -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="<?= absolute_url('/en-us/services/') ?>"><strong>AI SEO Services</strong></a> including <a href="<?= absolute_url('/en-us/services/crawl-clarity/') ?>"><strong>Crawl Clarity Engineering</strong></a> for <strong>technical SEO</strong> optimization.</p>
        <p>Discover our latest <a href="<?= absolute_url('/en-us/insights/') ?>"><strong>AI SEO Research & Insights</strong></a> including the <a href="<?= absolute_url('/en-us/insights/geo16-introduction/') ?>"><strong>GEO-16 Framework</strong></a> for <strong>AI citation</strong> optimization.</p>
        <p>Browse our <a href="<?= absolute_url('/en-us/tools/') ?>"><strong>SEO Tools & Resources</strong></a> for <strong>technical SEO</strong> optimization.</p>
        <div class="btn-group text-center" style="margin-top: var(--spacing-md);">
          <a href="<?= absolute_url('/en-us/services/') ?>" class="btn btn--primary">Get Started with AI SEO</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary">Book Consultation</a>
        </div>
      </div>
    </section>

  </div>
</article>
</section>
</main>

<?php
// JSON-LD Schema - Enhanced with Person, WebPage, and Thing schemas
require_once __DIR__ . '/../../lib/helpers.php';

// Person schema (Joel Maldonado)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Person',
  '@id' => $personId,
  'name' => 'Joel Maldonado',
  'givenName' => 'Joel',
  'familyName' => 'Maldonado',
  'jobTitle' => 'Founder & AI Search Researcher',
  'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
  'knowsAbout' => [
    'AI SEO Tools', 'Structured Knowledge Tools', 'AI Search Tools',
    'SEO Diagnostics Tools', 'Neural Command OS', 'Schema Tools',
    'AI Visibility Tools', 'Structured Data Tools'
  ],
  'worksFor' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'affiliation' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'url' => $domain,
  'sameAs' => [
    'https://www.linkedin.com/company/neural-command/',
    'https://twitter.com/neuralcommand',
    'https://www.crunchbase.com/person/joel-maldonado'
  ]
];

// WebPage schema (ENHANCED)
$GLOBALS['__jsonld'][] = [
  "@context" => "https://schema.org",
  "@type" => "WebPage",
  "@id" => $canonicalUrl . '#webpage',
  "name" => $GLOBALS['__page_meta']['title'] ?? "AI Search and Structured Knowledge Tools",
  "url" => $canonicalUrl,
  "description" => $GLOBALS['__page_meta']['description'] ?? "AI SEO and AI visibility tools for structured knowledge, search optimization, and generative engine visibility.",
  "inLanguage" => "en-US",
  "datePublished" => "2024-01-01",
  "dateModified" => date('Y-m-d'),
  "keywords" => $GLOBALS['__page_meta']['keywords'] ?? "AI SEO tools, structured knowledge tools, AI search tools, schema tools, Neural Command OS, Googlebot Renderer Lab",
  "about" => [
    [
      "@type" => "Thing",
      "name" => "Structured Knowledge Tools",
      "description" => "Tools that convert unstructured data into machine-verifiable truth infrastructure"
    ],
    [
      "@type" => "Thing",
      "name" => "AI Search Tools",
      "description" => "Tools that optimize content for AI search systems including ChatGPT, Perplexity, Google AI Overviews"
    ],
    [
      "@type" => "Thing",
      "name" => "SEO Diagnostics Tools",
      "description" => "Tools that diagnose technical SEO issues and simulate search engine crawlers"
    ]
  ],
  "mentions" => [
    [
      "@type" => "SoftwareApplication",
      "name" => "ChatGPT",
      "description" => "AI language model by OpenAI"
    ],
    [
      "@type" => "SoftwareApplication",
      "name" => "Perplexity",
      "description" => "AI-powered search engine"
    ],
    [
      "@type" => "SoftwareApplication",
      "name" => "Google AI Overviews",
      "description" => "Google's AI-powered search overview feature"
    ],
    [
      "@type" => "SoftwareApplication",
      "name" => "Claude",
      "description" => "AI language model by Anthropic"
    ]
  ],
  "author" => [
    "@type" => "Person",
    "@id" => $personId
  ],
  "publisher" => [
    "@type" => "Organization",
    "@id" => $orgId
  ],
  "isPartOf" => [
    "@type" => "WebSite",
    "@id" => $domain . '/#website',
    "name" => "NRLC.ai",
    "url" => $domain
  ],
  "speakable" => [
    "@type" => "SpeakableSpecification",
    "cssSelector" => ["h1", ".lead"]
  ]
];

// ItemList schema (ENHANCED with Product references)
$GLOBALS['__jsonld'][] = [
  "@context" => "https://schema.org",
  "@type" => "ItemList",
  "@id" => $canonicalUrl . '#product-list',
  "name" => "AI SEO Products & Services",
  "description" => "Overview of Neural Command's suite of AI SEO tools and services.",
  "url" => $canonicalUrl,
  "numberOfItems" => 9,
  "itemListElement" => [
    [
      "@type" => "ListItem",
      "position" => 1,
      "name" => "Data, But Structured",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/data-but-structured/#product",
        "name" => "Data, But Structured",
        "description" => "Foundational book defining structured knowledge, micro-fact cognition, agentic search, data ontology, AI visibility, and schema literacy.",
        "url" => $domain . "/en-us/products/data-but-structured/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 2,
      "name" => "Applicants.io",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/applicants-io/#product",
        "name" => "Applicants.io",
        "description" => "AI recruiting platform with JobPosting schema automation, Google Jobs indexing, resume crawling, and AI-driven applicant ranking.",
        "url" => $domain . "/en-us/products/applicants-io/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 3,
      "name" => "OurCasa.ai",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/ourcasa-ai/#product",
        "name" => "OurCasa.ai",
        "description" => "Home and neighborhood intelligence graph with property cognition, weather risk mapping, local incident history, and maintenance prediction.",
        "url" => $domain . "/en-us/products/ourcasa-ai/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 4,
      "name" => "Croutons.ai",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/croutons-ai/#product",
        "name" => "Croutons.ai",
        "description" => "Micro-fact data atomization engine converting HTML, PDFs, CSVs, NDJSON streams, and APIs into machine-verifiable truth infrastructure.",
        "url" => $domain . "/en-us/products/croutons-ai/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 5,
      "name" => "Precogs",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/precogs/#product",
        "name" => "Precogs",
        "description" => "Ontological oracle intelligence engine with predictive reasoning, multi-domain cognition, temporal simulation, and real-time agentic intelligence.",
        "url" => $domain . "/en-us/products/precogs/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 6,
      "name" => "Googlebot Renderer Lab",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/googlebot-renderer-lab/#product",
        "name" => "Googlebot Renderer Lab",
        "description" => "Real Googlebot DOM simulation solving hydration failures, CSR/SSR drift, and crawl-time abort replication for modern SEO diagnostics.",
        "url" => $domain . "/en-us/products/googlebot-renderer-lab/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 7,
      "name" => "NEWFAQ",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/newfaq/#product",
        "name" => "NEWFAQ",
        "description" => "Sentient FAQ and business intelligence engine that learns from queries, expands dynamically, and generates breakthrough SEO visibility.",
        "url" => $domain . "/en-us/products/newfaq/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 8,
      "name" => "Neural Command OS",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/neural-command-os/#product",
        "name" => "Neural Command OS",
        "description" => "Universal operating system powering agentic SEO, schema generation, authority scoring, LLM visibility modeling, and semantic linking.",
        "url" => $domain . "/en-us/products/neural-command-os/"
      ]
    ],
    [
      "@type" => "ListItem",
      "position" => 9,
      "name" => "Prompt Surface Intelligence",
      "item" => [
        "@type" => "Product",
        "@id" => $domain . "/en-us/products/prompt-surface-intelligence/#product",
        "name" => "Prompt Surface Intelligence",
        "description" => "Identify the real prompts your website appears in across Google, AI Overviews, ChatGPT, Claude, and Perplexity.",
        "url" => $domain . "/en-us/products/prompt-surface-intelligence/"
      ]
    ]
  ]
];

// BreadcrumbList
$GLOBALS['__jsonld'][] = [
  "@context" => "https://schema.org",
  "@type" => "BreadcrumbList",
  "@id" => $canonicalUrl . '#breadcrumb',
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
      "name" => "Products",
      "item" => $canonicalUrl
    ]
  ]
];

// Thing schemas for key product concepts
$GLOBALS['__jsonld'][] = [
  "@context" => "https://schema.org",
  "@type" => "Thing",
  "name" => "Structured Knowledge Tools",
  "description" => "Tools that convert unstructured data into machine-verifiable truth infrastructure"
];
$GLOBALS['__jsonld'][] = [
  "@context" => "https://schema.org",
  "@type" => "Thing",
  "name" => "AI Search Tools",
  "description" => "Tools that optimize content for AI search systems including ChatGPT, Perplexity, Google AI Overviews"
];
$GLOBALS['__jsonld'][] = [
  "@context" => "https://schema.org",
  "@type" => "Thing",
  "name" => "SEO Diagnostics Tools",
  "description" => "Tools that diagnose technical SEO issues and simulate search engine crawlers"
];
?>
