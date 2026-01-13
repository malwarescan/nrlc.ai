<?php
// Flagship intake page: Why AI Search Does Not Cite Your Business
// Problem naming page - establishes category authority without solutions

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../lib/schema_builders.php';
}

// Get canonical URL with proper locale prefix
$canonicalPath = $GLOBALS['__page_meta']['canonicalPath'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (preg_match('#^/([a-z]{2}-[a-z]{2})/ai-visibility/why-ai-search-does-not-cite-your-business/#i', $canonicalPath, $m)) {
  $canonicalUrl = absolute_url($canonicalPath);
} else {
  // Fallback: use en-us as default for ai-visibility pages
  $canonicalUrl = absolute_url('/en-us/ai-visibility/why-ai-search-does-not-cite-your-business/');
}

$GLOBALS['__jsonld'] = [
  // About / Entity Graph (Site-wide)
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => absolute_url('/') . '#logo',
          'url' => absolute_url('/logo.png')
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ],
      [
        '@type' => 'WebSite',
        '@id' => absolute_url('/') . '#website',
        'url' => absolute_url('/'),
        'name' => 'NRLC.ai',
        'publisher' => [
          '@id' => absolute_url('/') . '#organization'
        ],
        'inLanguage' => 'en-US'
      ],
      [
        '@type' => 'AboutPage',
        '@id' => absolute_url('/en-us/about/') . '#aboutpage',
        'url' => absolute_url('/en-us/about/'),
        'name' => 'About Neural Command LLC',
        'isPartOf' => [
          '@id' => absolute_url('/') . '#website'
        ],
        'about' => [
          '@id' => absolute_url('/') . '#organization'
        ],
        'publisher' => [
          '@id' => absolute_url('/') . '#organization'
        ],
        'inLanguage' => 'en-US'
      ]
    ]
  ],
  // BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'AI Visibility',
        'item' => absolute_url('/en-us/ai-visibility/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Why AI Search Does Not Cite Your Business',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'Why AI Search Does Not Cite Your Business',
    'description' => 'Understanding why AI search systems fail to cite businesses despite high rankings and quality content.',
    'isPartOf' => [
      '@id' => absolute_url('/') . '#website'
    ],
    'about' => [
      '@type' => 'Thing',
      'name' => 'AI Search Citation Failure',
      'description' => 'The problem of AI search systems not citing businesses in generated answers despite content quality and search rankings.'
    ],
    'publisher' => [
      '@id' => absolute_url('/') . '#organization'
    ],
    'inLanguage' => 'en-US'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <!-- Hero Section (Intro - Authority Formation) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Why AI Search Does Not Cite Your Business</h1>
        </div>
        <div class="content-block__body">
          <p>Most organizations struggle with AI visibility because they approach citation as an extension of traditional SEO rather than a retrieval mismatch problem. They assume that high search rankings and quality content will automatically translate to AI citations. But AI systems don't browse websites like users; they extract segments through context relationships that determine citation readiness. AI visibility optimization solves this through systematic content structuring that enables reliable segment extraction and citation. This approach enables businesses to achieve consistent AI citation and visibility optimization across search engines and AI platforms.</p>
        </div>
      </div>

      <!-- Section 2: "Why AI Search Does Not Cite Businesses" (Middle - Mechanism Deep Dive) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why AI Search Does Not Cite Businesses</h2>
        </div>
        <div class="content-block__body">
          <p>When businesses fail to appear in AI-generated answers, the issue isn't content quality or search rankings. They believe that optimizing for search engines will naturally extend to AI citation systems. But AI systems evaluate content at the segment level through extraction processes that require specific structural readiness. AI visibility optimization provides systematic content structuring that ensures reliable segment extraction and citation. Businesses use this approach to achieve consistent AI citation through structured content optimization and segment-level verification.</p>
        </div>
      </div>

      <!-- Section 3: "AI Visibility Optimization for Citation Failure" (Middle - Concrete Application) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">AI Visibility Optimization for Citation Failure</h2>
        </div>
        <div class="content-block__body">
          <p>AI search citation failures stem from content that appears high-quality at the page level but fails segment-level extraction. Businesses assume that comprehensive content will be naturally extracted and cited by AI systems. But citation depends on segment relationships that must be structured for AI extraction and verification. AI visibility optimization acts as systematic content structuring that governs segment extraction and citation relationships. Organizations assess citation issues against structured content rules, simulate extraction improvements, and apply changes that maintain segment integrity across their content.</p>
        </div>
      </div>

      <!-- Section 4: "What AI Visibility Optimization Provides" (Final Third - Framework Establishment) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What AI Visibility Optimization Provides</h2>
        </div>
        <div class="content-block__body">
          <p>Without systematic structuring, AI citation becomes a series of disconnected optimizations that don't compound effectively. Organizations assume that accumulating more content features will eventually create the necessary citation coherence. But true AI visibility requires foundational content structuring that defines how segments relate and validate for extraction. The AI visibility optimization framework provides systematic content structuring, segment extraction rules, and citation verification logic. These capabilities enable systematic AI citation optimization and visibility management.</p>
        </div>
      </div>

      <!-- Section 5: Handoff to /ai-optimization/ (Final Third - Neutral Transition) -->
      <div class="content-block module">
        <div class="content-block__body">
          <p>For organizations ready to implement systematic AI citation and visibility optimization, the framework extends to comprehensive content structuring and LLM extraction readiness. Learn how AI visibility optimization enables systematic content structuring and AI citation management.</p>
          <p><a href="<?= absolute_url('/en-us/insights/ai-retrieval-llm-citation/') ?>">Learn how AI systems retrieve and cite content →</a></p>
          <p><a href="<?= absolute_url('/en-us/ai-optimization/') ?>">Explore AI Optimization →</a></p>
        </div>
      </div>

    </div>
  </section>
</main>