<?php
// Metadata is handled by router via $GLOBALS['__page_meta']
require_once __DIR__ . '/../../lib/schema_builders.php';

// Prepare blog posts data for schema
$recentPosts = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$topics = ['AI SEO', 'GEO-16 Framework', 'LLM Optimization', 'Structured Data', 'Crawl Clarity', 'Entity Recognition', 'Citation Optimization', 'Technical SEO', 'Content Strategy', 'Analytics'];

$blogPostings = [];
foreach ($recentPosts as $postNum) {
  $topic = $topics[($postNum - 1) % count($topics)];
  $title = "Advanced $topic Strategies for 2025";
  $excerpt = "Comprehensive guide to $topic optimization, featuring the latest techniques and best practices for AI-powered search engines.";
  $url = absolute_url("/blog/blog-post-$postNum/");
  
  $blogPostings[] = [
    '@type' => 'BlogPosting',
    '@id' => $url . '#BlogPosting',
    'headline' => $title,
    'name' => $title,
    'description' => $excerpt,
    'url' => $url,
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $url
    ],
    'author' => [
      '@id' => 'https://nrlc.ai/en-us/about/joel-maldonado/#person',
      '@type' => 'Person',
      'name' => 'Joel David Maldonado',
      'url' => 'https://nrlc.ai/en-us/about/joel-maldonado/'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => 'https://nrlc.ai/#organization',
      'name' => 'Neural Command',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => 'https://nrlc.ai/logo.png'
      ]
    ],
    'datePublished' => date('Y-m-d', strtotime("-{$postNum} days")),
    'dateModified' => date('Y-m-d', strtotime("-{$postNum} days")),
    'keywords' => [$topic, 'AI SEO', 'Search Optimization']
  ];
}

// Blog schema
$canonicalUrl = absolute_url('/blog/');
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'Blog',
    '@id' => $canonicalUrl . '#blog',
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonicalUrl . '#webpage'
    ],
    'name' => 'NRLC.ai Blog',
    'description' => 'Insights, guides, and updates on AI SEO, structured data, and LLM optimization strategies.',
    'url' => $canonicalUrl,
    'publisher' => [
      '@type' => 'Organization',
      '@id' => 'https://nrlc.ai/#organization',
      'name' => 'Neural Command',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => 'https://nrlc.ai/logo.png'
      ]
    ],
    'blogPost' => $blogPostings
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'Blog | AI SEO Insights & Guides',
    'description' => 'Insights, guides, and updates on AI SEO, structured data, and LLM optimization strategies.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => 'https://nrlc.ai/#website',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'mainEntity' => [
      '@id' => $canonicalUrl . '#blog'
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumbs',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => 'https://nrlc.ai/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Blog',
        'item' => $canonicalUrl
      ]
    ]
  ],
  ld_organization()
];
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Blog</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Insights, guides, and updates on AI SEO, structured data, and LLM optimization strategies.</p>
      </div>
    </div>

    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Latest Posts</h2>
      </div>
      <div class="content-block__body">
        <div style="display: grid; gap: var(--spacing-lg); margin-top: var(--spacing-md);">
          <?php
          // Display recent blog posts
          $recentPosts = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
          $topics = ['AI SEO', 'GEO-16 Framework', 'LLM Optimization', 'Structured Data', 'Crawl Clarity', 'Entity Recognition', 'Citation Optimization', 'Technical SEO', 'Content Strategy', 'Analytics'];
          
          foreach ($recentPosts as $postNum) {
            $topic = $topics[($postNum - 1) % count($topics)];
            $title = "Advanced $topic Strategies for 2025";
            $excerpt = "Comprehensive guide to $topic optimization, featuring the latest techniques and best practices for AI-powered search engines.";
            $url = "/blog/blog-post-$postNum/";
            ?>
            <article style="padding: var(--spacing-md); border: 1px solid var(--color-border, #e0e0e0); border-radius: 4px;">
              <h3 style="margin-top: 0;"><a href="<?= htmlspecialchars($url) ?>"><?= htmlspecialchars($title) ?></a></h3>
              <p><?= htmlspecialchars($excerpt) ?></p>
              <p><a href="<?= htmlspecialchars($url) ?>" class="btn">Read More</a></p>
            </article>
            <?php
          }
          ?>
        </div>
      </div>
    </div>

    <div class="content-block module">
      <div class="content-block__body">
        <p><a href="/insights/" class="btn">View All Research & Insights</a></p>
      </div>
    </div>
  </div>
</section>
</main>

