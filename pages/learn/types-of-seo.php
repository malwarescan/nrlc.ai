<?php
// What are the 4 Types of SEO? - Beginner Education Page
// Answer-First Architecture: Direct answer in first 1-2 sentences

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/learn/types-of-seo/');

// Build FAQPage schema
$faqItems = [
  [
    'question' => 'What are the 4 types of SEO?',
    'answer' => 'The four types of SEO are: (1) On-page SEO - optimizing content, titles, and HTML elements on your website, (2) Off-page SEO - building backlinks and external signals, (3) Technical SEO - optimizing site structure, speed, and crawlability, and (4) Local SEO - optimizing for location-based searches and Google Business Profile.'
  ],
  [
    'question' => 'What is on-page SEO?',
    'answer' => 'On-page SEO involves optimizing elements directly on your website, including content quality, title tags, meta descriptions, header tags (H1, H2, H3), image alt text, internal linking, URL structure, and keyword usage. It focuses on making your content relevant and accessible to both users and search engines.'
  ],
  [
    'question' => 'What is off-page SEO?',
    'answer' => 'Off-page SEO focuses on external signals that indicate your website\'s authority and credibility, including backlinks from other websites, social media mentions, citations, brand mentions, and domain authority. It builds trust and authority signals that search engines use to rank your content.'
  ],
  [
    'question' => 'What is technical SEO?',
    'answer' => 'Technical SEO involves optimizing the technical aspects of your website that affect search engine crawling and indexing, including site speed, mobile responsiveness, crawlability, site structure, XML sitemaps, robots.txt, structured data (schema markup), HTTPS security, and server configuration.'
  ],
  [
    'question' => 'What is local SEO?',
    'answer' => 'Local SEO optimizes your online presence for location-based searches, including Google Business Profile optimization, local citations, NAP (Name, Address, Phone) consistency, local keywords, location pages, and customer reviews. It helps businesses appear in local search results and Google Maps.'
  ],
  [
    'question' => 'Which type of SEO is most important?',
    'answer' => 'All four types of SEO are important, but the priority depends on your situation: (1) Start with technical SEO to ensure your site is crawlable, (2) Then focus on on-page SEO for content quality, (3) Build off-page SEO for authority, and (4) Add local SEO if you have a physical location. A balanced approach across all four types delivers the best results.'
  ],
  [
    'question' => 'How do the 4 types of SEO work together?',
    'answer' => 'The four types of SEO work together synergistically: Technical SEO ensures search engines can crawl and index your site, on-page SEO provides quality content for users and search engines, off-page SEO builds authority signals, and local SEO optimizes for location-based visibility. All four must be aligned for optimal search performance.'
  ]
];

$GLOBALS['__jsonld'] = [
  // Organization/WebSite (Site-wide)
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
        'name' => 'Learn',
        'item' => absolute_url('/en-us/learn/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'What are the 4 Types of SEO?',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // Article (Educational Content)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'What are the 4 Types of SEO?',
    'name' => 'What are the 4 Types of SEO?',
    'description' => 'The four types of SEO are: on-page, off-page, technical, and local SEO. Learn how each type works and how they complement each other for optimal search performance.',
    'url' => $canonicalUrl,
    'author' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => absolute_url('/logo.png')
      ]
    ],
    'datePublished' => '2026-01-27',
    'dateModified' => date('Y-m-d'),
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonicalUrl
    ],
    'keywords' => 'types of SEO, on-page SEO, off-page SEO, technical SEO, local SEO, SEO fundamentals, SEO for beginners',
    'inLanguage' => 'en-US',
    'articleSection' => 'Beginner Education',
    'about' => [
      '@type' => 'DefinedTerm',
      '@id' => $canonicalUrl . '#seo-types',
      'name' => 'Types of SEO',
      'description' => 'The four categories of search engine optimization: on-page, off-page, technical, and local SEO.'
    ]
  ],
  // FAQPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => array_map(function($item) {
      return [
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $item['answer']
        ]
      ];
    }, $faqItems)
  ]
];

// Meta tags
$GLOBALS['__page_meta'] = [
  'title' => 'What are the 4 Types of SEO? | Beginner SEO Education | Neural Command',
  'description' => 'The four types of SEO are: on-page, off-page, technical, and local SEO. Learn how each type works and how they complement each other for optimal search performance.',
  'keywords' => 'types of SEO, on-page SEO, off-page SEO, technical SEO, local SEO, SEO fundamentals, SEO for beginners',
  'canonicalPath' => '/en-us/learn/types-of-seo/'
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">What are the 4 Types of SEO?</h1>
        </div>
        <div class="content-block__body">
          <!-- Answer-First: Direct answer in first sentence -->
          <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);" itemscope itemtype="https://schema.org/DefinedTerm">
            <p style="margin: 0; font-size: 1.1rem; line-height: 1.6; font-weight: 600;">
              <dfn itemprop="name">The four types of SEO are:</dfn> (1) <strong>On-page SEO</strong> - optimizing content on your website, (2) <strong>Off-page SEO</strong> - building backlinks and external signals, (3) <strong>Technical SEO</strong> - optimizing site structure and crawlability, and (4) <strong>Local SEO</strong> - optimizing for location-based searches.
            </p>
          </div>
          
          <p class="lead text-lg" style="font-size: 1.1rem; margin-bottom: var(--spacing-lg);">
            Each type of SEO focuses on different aspects of search engine optimization, and they work together to improve your website's visibility in search results.
          </p>
          
          <div class="btn-group" style="margin-top: var(--spacing-lg);">
            <a href="<?= absolute_url('/en-us/learn/seo-80-20-rule/') ?>" class="btn btn--primary" title="Learn: What is the 80/20 Rule in SEO?">Next: 80/20 Rule</a>
            <a href="<?= absolute_url('/en-us/learn/') ?>" class="btn btn--secondary" title="Back to Learn Hub">Back to Learn Hub</a>
          </div>
        </div>
      </div>

      <!-- The 4 Types List -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The 4 Types of SEO Explained</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-lg); margin-top: var(--spacing-lg);">
            
            <!-- Type 1: On-Page SEO -->
            <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
              <h3 class="heading-3">1. On-Page SEO</h3>
              <p><strong>Focus:</strong> Optimizing content, titles, and HTML elements directly on your website.</p>
              <p><strong>Examples:</strong></p>
              <ul>
                <li>Content quality and relevance</li>
                <li>Title tags and meta descriptions</li>
                <li>Header tags (H1, H2, H3)</li>
                <li>Image alt text</li>
                <li>Internal linking</li>
                <li>URL structure</li>
                <li>Keyword usage</li>
              </ul>
            </div>
            
            <!-- Type 2: Off-Page SEO -->
            <div style="background: #e8f4f8; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
              <h3 class="heading-3">2. Off-Page SEO</h3>
              <p><strong>Focus:</strong> Building backlinks and external signals that indicate authority.</p>
              <p><strong>Examples:</strong></p>
              <ul>
                <li>Backlinks from other websites</li>
                <li>Social media mentions</li>
                <li>Citations and directory listings</li>
                <li>Brand mentions</li>
                <li>Domain authority</li>
                <li>Online reputation</li>
              </ul>
            </div>
            
            <!-- Type 3: Technical SEO -->
            <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
              <h3 class="heading-3">3. Technical SEO</h3>
              <p><strong>Focus:</strong> Optimizing site structure, speed, and crawlability.</p>
              <p><strong>Examples:</strong></p>
              <ul>
                <li>Site speed and performance</li>
                <li>Mobile responsiveness</li>
                <li>Crawlability and indexing</li>
                <li>Site structure and navigation</li>
                <li>XML sitemaps</li>
                <li>Robots.txt</li>
                <li>Structured data (schema markup)</li>
                <li>HTTPS security</li>
              </ul>
            </div>
            
            <!-- Type 4: Local SEO -->
            <div style="background: #e8f4f8; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
              <h3 class="heading-3">4. Local SEO</h3>
              <p><strong>Focus:</strong> Optimizing for location-based searches.</p>
              <p><strong>Examples:</strong></p>
              <ul>
                <li>Google Business Profile optimization</li>
                <li>Local citations</li>
                <li>NAP (Name, Address, Phone) consistency</li>
                <li>Local keywords</li>
                <li>Location pages</li>
                <li>Customer reviews</li>
                <li>Google Maps optimization</li>
              </ul>
            </div>
            
          </div>
        </div>
      </div>

      <!-- Detailed Explanations -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Each Type Works</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">On-Page SEO</h3>
          <p>On-page SEO involves optimizing elements directly on your website to make your content relevant and accessible to both users and search engines. This includes writing high-quality content that answers user queries, using relevant keywords naturally, optimizing title tags and meta descriptions, using proper header hierarchy, adding descriptive image alt text, and creating a logical internal linking structure.</p>
          
          <h3 class="heading-3">Off-Page SEO</h3>
          <p>Off-page SEO focuses on external signals that indicate your website's authority and credibility. The primary signal is backlinks—links from other websites pointing to your site. Search engines view backlinks as votes of confidence: the more high-quality backlinks you have, the more authoritative your site appears. Off-page SEO also includes social media mentions, brand mentions, citations, and your overall online reputation.</p>
          
          <h3 class="heading-3">Technical SEO</h3>
          <p>Technical SEO ensures search engines can crawl, index, and understand your website effectively. It involves optimizing site speed, ensuring mobile responsiveness, fixing crawl errors, creating proper site structure, submitting XML sitemaps, configuring robots.txt, implementing structured data (schema markup), and ensuring HTTPS security. Technical SEO is foundational—if search engines can't crawl your site properly, other SEO efforts won't matter.</p>
          
          <h3 class="heading-3">Local SEO</h3>
          <p>Local SEO optimizes your online presence for location-based searches, helping businesses appear in local search results and Google Maps. Key elements include optimizing your Google Business Profile, ensuring NAP (Name, Address, Phone) consistency across directories, creating location-specific content, building local citations, and earning positive customer reviews. Local SEO is essential for businesses with physical locations or local service areas.</p>
          
        </div>
      </div>

      <!-- How They Work Together -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How the 4 Types Work Together</h2>
        </div>
        <div class="content-block__body">
          <p>The four types of SEO are interdependent and work best when aligned:</p>
          
          <div style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin: var(--spacing-lg) 0;">
            <p><strong>Technical SEO</strong> ensures search engines can crawl and index your site.</p>
            <p><strong>On-page SEO</strong> provides quality content that users and search engines find valuable.</p>
            <p><strong>Off-page SEO</strong> builds authority signals that search engines use to rank your content.</p>
            <p><strong>Local SEO</strong> optimizes for location-based visibility (if applicable).</p>
          </div>
          
          <p>For example: Technical SEO ensures your site is crawlable, on-page SEO creates quality content, off-page SEO builds authority through backlinks, and local SEO helps you appear in location-based searches. All four must work together for optimal search performance.</p>
          
          <h3 class="heading-3">Priority Order</h3>
          <ol>
            <li><strong>Start with Technical SEO:</strong> Ensure your site is crawlable and fast</li>
            <li><strong>Then On-Page SEO:</strong> Create quality, relevant content</li>
            <li><strong>Build Off-Page SEO:</strong> Earn backlinks and build authority</li>
            <li><strong>Add Local SEO:</strong> If you have a physical location or local service area</li>
          </ol>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Frequently Asked Questions</h2>
        </div>
        <div class="content-block__body">
          <?php foreach ($faqItems as $faq): ?>
            <div style="margin-bottom: var(--spacing-md); padding-bottom: var(--spacing-md); border-bottom: 1px solid #e0e0e0;">
              <h3 class="heading-3"><?= htmlspecialchars($faq['question']) ?></h3>
              <p><?= htmlspecialchars($faq['answer']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Progression Footer -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-top: var(--spacing-xl);">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Continue Learning</h2>
        </div>
        <div class="content-block__body">
          <p>Explore more beginner education pages:</p>
          <ul>
            <li><a href="<?= absolute_url('/en-us/learn/can-ai-do-seo/') ?>">Can AI Do SEO?</a></li>
            <li><a href="<?= absolute_url('/en-us/learn/seo-80-20-rule/') ?>">What is the 80/20 Rule in SEO?</a></li>
            <li><a href="<?= absolute_url('/en-us/learn/chatgpt-seo/') ?>">Can ChatGPT Do SEO?</a></li>
          </ul>
          <p style="margin-top: var(--spacing-lg);">
            <strong>Ready for advanced research?</strong> Explore Neural Command's foundational research on <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization (GEO)</a> and <a href="<?= absolute_url('/en-us/answer-first-architecture/') ?>">Answer First Architecture</a>.
          </p>
        </div>
      </div>

    </div>
  </section>
</main>
