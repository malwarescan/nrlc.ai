<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set in router.php before head.php is included
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

// Get canonical URL and domain
$canonicalUrl = absolute_url('/tools/');
$domain = absolute_url('/');
$orgId = SchemaFixes::ensureHttps($domain) . '#organization';
$personId = SchemaFixes::ensureHttps($domain) . '#joel-maldonado';

// Enhance metadata with keywords
if (isset($GLOBALS['__page_meta']) && is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['keywords'] = 'AI SEO tools, AI search tools, tool reviews, ChatGPT tools, Claude tools, Perplexity tools, Google AI Overviews tools, structured data tools, schema tools, crawl analysis tools, content optimization tools, AI visibility tools, analytics tools, competitive analysis tools, Neural Command OS, Googlebot Renderer Lab';
}

// Tool categories data
$toolCategories = [
  [
    'name' => 'AI Search Engines',
    'slug' => 'ai-search-engines',
    'description' => 'Reviews of ChatGPT, Claude, Perplexity, Bard, and other AI search platforms for SEO optimization.',
    'url' => absolute_url('/tools/ai-search-engines/')
  ],
  [
    'name' => 'Structured Data Tools',
    'slug' => 'structured-data',
    'description' => 'Schema markup generators, JSON-LD validators, and structured data testing tools.',
    'url' => absolute_url('/tools/structured-data/')
  ],
  [
    'name' => 'Crawl Analysis Tools',
    'slug' => 'crawl-analysis',
    'description' => 'Website crawlers, sitemap generators, and technical SEO analysis platforms.',
    'url' => absolute_url('/tools/crawl-analysis/')
  ],
  [
    'name' => 'Content Optimization',
    'slug' => 'content-optimization',
    'description' => 'AI content generators, optimization tools, and content analysis platforms.',
    'url' => absolute_url('/tools/content-optimization/')
  ],
  [
    'name' => 'Analytics & Monitoring',
    'slug' => 'analytics-monitoring',
    'description' => 'AI visibility tracking, citation monitoring, and performance analysis tools.',
    'url' => absolute_url('/tools/analytics-monitoring/')
  ],
  [
    'name' => 'Competitive Analysis',
    'slug' => 'competitive-analysis',
    'description' => 'AI-powered competitor research, market analysis, and benchmarking tools.',
    'url' => absolute_url('/tools/competitive-analysis/')
  ]
];

// Build comprehensive schema for tools hub
if (!isset($GLOBALS['__jsonld']) || !is_array($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

// Person schema (Joel Maldonado as tool expert/researcher)
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
    'AI SEO Tools', 'Tool Reviews', 'AI Search Tools', 'Structured Data Tools',
    'Crawl Analysis Tools', 'Content Optimization Tools', 'AI Visibility Tools',
    'Analytics Tools', 'Competitive Analysis Tools', 'Schema Tools',
    'ChatGPT Tools', 'Claude Tools', 'Perplexity Tools', 'Google AI Overviews Tools'
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

// CollectionPage schema (PRIMARY - This is a content collection)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  '@id' => $canonicalUrl . '#collection',
  'name' => 'AI SEO Tools & Platform Reviews',
  'description' => 'Comprehensive reviews and comparisons of AI SEO tools, platforms, and optimization solutions for ChatGPT, Claude, Perplexity, and Google AI Overviews.',
  'url' => $canonicalUrl,
  'inLanguage' => 'en-US',
  'datePublished' => '2024-01-01',
  'dateModified' => date('Y-m-d'),
  'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'AI SEO tools, tool reviews, AI search tools, structured data tools, schema tools, crawl analysis tools, content optimization tools, AI visibility tools, analytics tools, competitive analysis tools',
  'about' => [
    [
      '@type' => 'Thing',
      'name' => 'AI SEO Tools',
      'description' => 'Tools and platforms for optimizing content for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'
    ],
    [
      '@type' => 'Thing',
      'name' => 'Tool Reviews',
      'description' => 'Comprehensive reviews and comparisons of AI SEO tools and platforms'
    ],
    [
      '@type' => 'Thing',
      'name' => 'AI Search Optimization Tools',
      'description' => 'Tools that help businesses optimize their content for AI-powered search engines'
    ]
  ],
  'mentions' => [
    [
      '@type' => 'SoftwareApplication',
      'name' => 'ChatGPT',
      'description' => 'AI language model by OpenAI'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Perplexity',
      'description' => 'AI-powered search engine'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Google AI Overviews',
      'description' => 'Google\'s AI-powered search overview feature'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Claude',
      'description' => 'AI language model by Anthropic'
    ]
  ],
  'author' => [
    '@type' => 'Person',
    '@id' => $personId
  ],
  'publisher' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ]
];

// ItemList schema (Enhanced with URLs and descriptions)
$itemListElements = [];
foreach ($toolCategories as $index => $category) {
  $itemListElements[] = [
    '@type' => 'ListItem',
    'position' => $index + 1,
    'name' => $category['name'],
    'item' => $category['url'],
    'description' => $category['description']
  ];
}

$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'ItemList',
  '@id' => $canonicalUrl . '#itemlist',
  'name' => 'AI SEO Tool Categories',
  'description' => 'Comprehensive list of AI SEO tool categories and reviews',
  'itemListElement' => $itemListElements
];

// WebPage schema (Enhanced)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => 'AI SEO Tools & Platform Reviews',
  'url' => $canonicalUrl,
  'description' => 'Comprehensive reviews and comparisons of AI SEO tools, platforms, and optimization solutions for ChatGPT, Claude, Perplexity, and Google AI Overviews.',
  'inLanguage' => 'en-US',
  'datePublished' => '2024-01-01',
  'dateModified' => date('Y-m-d'),
  'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'AI SEO tools, tool reviews, AI search tools',
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => $domain . '#website',
    'name' => 'NRLC.ai',
    'url' => $domain,
    'potentialAction' => [
      '@type' => 'SearchAction',
      'target' => [
        '@type' => 'EntryPoint',
        'urlTemplate' => 'https://nrlc.ai/search?q={search_term_string}'
      ],
      'query-input' => 'required name=search_term_string'
    ]
  ],
  'about' => [
    ['@id' => $canonicalUrl . '#collection'],
    [
      '@type' => 'Thing',
      'name' => 'AI SEO Tools',
      'description' => 'Tools and platforms for optimizing content for AI search systems'
    ]
  ],
  'mentions' => [
    ['@type' => 'SoftwareApplication', 'name' => 'ChatGPT'],
    ['@type' => 'SoftwareApplication', 'name' => 'Perplexity'],
    ['@type' => 'SoftwareApplication', 'name' => 'Google AI Overviews'],
    ['@type' => 'SoftwareApplication', 'name' => 'Claude']
  ],
  'primaryImageOfPage' => [
    '@type' => 'ImageObject',
    'url' => 'https://nrlc.ai/assets/images/nrlc-logo.png',
    'width' => 43,
    'height' => 43,
    'caption' => 'NRLC.ai - AI Search Optimization'
  ],
  'author' => [
    '@type' => 'Person',
    '@id' => $personId
  ],
  'publisher' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'breadcrumb' => [
    '@id' => $canonicalUrl . '#breadcrumb'
  ],
  'mainEntity' => [
    '@id' => $canonicalUrl . '#collection'
  ],
  'speakable' => [
    '@type' => 'SpeakableSpecification',
    'cssSelector' => ['h1', '.lead']
  ]
];

// BreadcrumbList schema
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  '@id' => $canonicalUrl . '#breadcrumb',
  'itemListElement' => [
    [
      '@type' => 'ListItem',
      'position' => 1,
      'name' => 'Home',
      'item' => $domain
    ],
    [
      '@type' => 'ListItem',
      'position' => 2,
      'name' => 'Tools',
      'item' => $canonicalUrl
    ]
  ]
];

// Thing schemas (Key Concepts)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Thing',
  'name' => 'AI SEO Tools',
  'description' => 'Tools and platforms for optimizing content for AI search systems including ChatGPT, Perplexity, and Google AI Overviews'
];

$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Thing',
  'name' => 'Tool Reviews',
  'description' => 'Comprehensive reviews and comparisons of AI SEO tools and platforms'
];

// Organization schema (Enhanced)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Organization',
  '@id' => $orgId,
  'name' => 'Neural Command',
  'legalName' => 'Neural Command, LLC',
  'url' => $domain,
  'logo' => [
    '@type' => 'ImageObject',
    'url' => 'https://nrlc.ai/assets/images/nrlc-logo.png',
    'width' => 43,
    'height' => 43
  ],
  'knowsAbout' => [
    'AI SEO Tools', 'Tool Reviews', 'AI Search Tools', 'Structured Data Tools',
    'Crawl Analysis Tools', 'Content Optimization Tools', 'AI Visibility Tools',
    'Analytics Tools', 'Competitive Analysis Tools', 'Schema Tools',
    'AI Search Optimization', 'AEO', 'GEO', 'SEO'
  ]
];
?>

<main role="main" class="container" itemscope itemtype="https://schema.org/CollectionPage">
<article itemscope itemtype="https://schema.org/Article" class="section">
  <div class="section__content">
    
    <!-- Tools Header Content Block -->
    <header class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title" itemprop="headline"><strong>AI SEO Tools</strong> & <strong>Platform Reviews</strong></h1>
      </div>
      <div class="content-block__body">
        <p class="lead" itemprop="description">Comprehensive reviews and comparisons of <strong>AI SEO tools</strong>, <strong>platforms</strong>, and <strong>optimization solutions</strong> for <strong>ChatGPT</strong>, <strong>Claude</strong>, <strong>Perplexity</strong>, and <strong>Google AI Overviews</strong>.</p>
        <p>We evaluate <strong>AI search tools</strong>, <strong>structured data tools</strong>, <strong>crawl analysis platforms</strong>, and <strong>content optimization solutions</strong> to help you choose the right tools for <strong>AI search optimization</strong> and <strong>AI visibility</strong>.</p>
        <p>Explore our comprehensive <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" title="AI SEO services"><strong>AI SEO Services</strong></a> and discover our latest <a href="<?= htmlspecialchars($localePrefix . '/insights/') ?>" title="AI SEO research and insights"><strong>AI SEO Research & Insights</strong></a>.</p>
      </div>
    </header>

    <!-- DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
    <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">What Are <strong>AI SEO Tools</strong> and Why Do They Matter?</h2>
      </div>
      <div class="content-block__body">
        <p><dfn><strong>AI SEO Tools</strong></dfn> are software platforms and utilities designed to help businesses optimize their content for <strong>AI-powered search engines</strong> including <strong>ChatGPT</strong>, <strong>Claude</strong>, <strong>Perplexity</strong>, and <strong>Google AI Overviews</strong>. Unlike traditional SEO tools that focus on keyword rankings and backlinks, <strong>AI SEO tools</strong> address <strong>entity clarity</strong>, <strong>structured data</strong>, <strong>citation signals</strong>, and <strong>AI visibility metrics</strong>.</p>
        
        <p><strong>AI SEO Tools</strong> differ from traditional SEO tools in several ways:</p>
        <ul>
          <li><strong>Entity Optimization:</strong> AI SEO tools focus on entity clarity and structured data rather than keyword density</li>
          <li><strong>Citation Tracking:</strong> AI SEO tools measure how often AI systems cite your content, not just search rankings</li>
          <li><strong>Structured Data Focus:</strong> AI SEO tools prioritize schema markup and JSON-LD validation over meta tags</li>
          <li><strong>AI Visibility Metrics:</strong> AI SEO tools track visibility across multiple AI platforms, not just Google search results</li>
        </ul>
        
        <p>This tools hub provides comprehensive reviews and comparisons to help you choose the right <strong>AI SEO tools</strong> for your business needs.</p>
      </div>
    </section>

    <!-- Tool Categories Grid -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Tool Categories</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <?php foreach ($toolCategories as $category): ?>
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title"><?= htmlspecialchars($category['name']) ?></h3>
            </div>
            <div class="content-block__body">
              <p><?= htmlspecialchars($category['description']) ?></p>
              <div class="btn-group">
                <a href="<?= htmlspecialchars($category['url']) ?>" class="btn btn--primary">View Reviews</a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Related Resources Section -->
    <section class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>" title="AI SEO services"><strong>AI SEO Services</strong></a> including <a href="<?= htmlspecialchars($localePrefix . '/services/crawl-clarity/') ?>" title="Crawl clarity engineering service"><strong>Crawl Clarity Engineering</strong></a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="<?= htmlspecialchars($localePrefix . '/insights/') ?>" title="AI SEO research and insights"><strong>AI SEO Research & Insights</strong></a> including the <a href="<?= htmlspecialchars($localePrefix . '/insights/geo16-introduction/') ?>" title="GEO-16 framework for AI citation optimization"><strong>GEO-16 Framework</strong></a> for <strong>AI citation</strong> optimization.</p>
        <p>Browse our <a href="<?= htmlspecialchars($localePrefix . '/products/') ?>" title="AI SEO products and tools"><strong>AI SEO Products & Tools</strong></a> including <a href="<?= absolute_url('/products/neural-command-os/') ?>" title="Neural Command OS"><strong>Neural Command OS</strong></a> and <a href="<?= absolute_url('/products/googlebot-renderer-lab/') ?>" title="Googlebot Renderer Lab"><strong>Googlebot Renderer Lab</strong></a>.</p>
        <div class="btn-group text-center" style="margin-top: var(--spacing-lg);">
          <a href="<?= absolute_url('/en-us/services/') ?>" class="btn btn--primary">Get Started with AI SEO</a>
          <a href="<?= absolute_url('/en-us/products/') ?>" class="btn btn--secondary">View All Products</a>
        </div>
      </div>
    </section>

  </div>
</article>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
