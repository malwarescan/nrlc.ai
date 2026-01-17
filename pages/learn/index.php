<?php
// Learn Hub Page - Beginner Education Funnel
// Entry point for beginners learning SEO → AI SEO

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/learn/');

// Beginner pages available
$beginnerPages = [
  [
    'slug' => 'can-ai-do-seo',
    'title' => 'Can AI Do SEO?',
    'description' => 'Learn how AI enhances SEO processes but requires human oversight for strategy, context, and quality control.',
    'question' => 'Can AI Do SEO?'
  ],
  [
    'slug' => 'types-of-seo',
    'title' => 'What are the 4 Types of SEO?',
    'description' => 'Learn about the four types of SEO: on-page, off-page, technical, and local SEO.',
    'question' => 'What are the 4 types of SEO?'
  ],
  [
    'slug' => 'seo-80-20-rule',
    'title' => 'What is the 80/20 Rule in SEO?',
    'description' => 'Learn how the 80/20 rule applies to SEO: 20% of efforts drive 80% of results.',
    'question' => 'What is the 80/20 rule in SEO?'
  ],
  [
    'slug' => 'chatgpt-seo',
    'title' => 'Can ChatGPT Do SEO?',
    'description' => 'Learn which SEO tasks ChatGPT can assist with: content ideas, outlines, meta descriptions, and more.',
    'question' => 'Can ChatGPT do SEO?'
  ],
  [
    'slug' => 'ai-30-percent-rule',
    'title' => 'What is the 30% Rule in AI?',
    'description' => 'Learn about the 30% rule: AI handles ~70% of routine tasks, humans handle the rest.',
    'question' => 'What is the 30% rule in AI?'
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
        'item' => $canonicalUrl
      ]
    ]
  ],
  // EducationalContent (Collection)
  [
    '@context' => 'https://schema.org',
    '@type' => 'EducationalOccupationalProgram',
    '@id' => $canonicalUrl . '#program',
    'name' => 'Learn SEO → AI SEO: Beginner Education Hub',
    'description' => 'Beginner-friendly education on SEO fundamentals and how AI is transforming search engine optimization. Learn the basics before advancing to advanced AI SEO research.',
    'url' => $canonicalUrl,
    'provider' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'educationalCredentialAwarded' => 'None',
    'programType' => 'Educational',
    'occupationalCategory' => 'Search Engine Optimization',
    'teaches' => [
      'SEO Fundamentals',
      'Types of SEO',
      'AI and SEO Integration',
      'ChatGPT for SEO',
      'SEO Best Practices',
      'AI Search Optimization Basics'
    ],
    'about' => [
      '@type' => 'DefinedTerm',
      'name' => 'Search Engine Optimization',
      'description' => 'The practice of optimizing websites to improve their visibility in search engine results.'
    ]
  ],
  // ItemList (Collection of Beginner Pages)
  [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    '@id' => $canonicalUrl . '#itemlist',
    'name' => 'Beginner SEO Education Pages',
    'description' => 'Collection of beginner-friendly SEO education pages',
    'itemListElement' => array_map(function($page, $index) {
      return [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $page['title'],
        'item' => absolute_url('/en-us/learn/' . $page['slug'] . '/')
      ];
    }, $beginnerPages, array_keys($beginnerPages))
  ]
];

// Meta tags
$GLOBALS['__page_meta'] = [
  'title' => 'Learn SEO → AI SEO: Beginner Education Hub | Neural Command',
  'description' => 'Beginner-friendly education on SEO fundamentals and how AI is transforming search engine optimization. Learn the basics before advancing to advanced AI SEO research.',
  'keywords' => 'Learn SEO, SEO basics, SEO for beginners, AI SEO, SEO education, SEO fundamentals, types of SEO, ChatGPT SEO, Neural Command',
  'canonicalPath' => '/en-us/learn/'
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Learn SEO → AI SEO: Beginner Education Hub</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">
            Beginner-friendly education on SEO fundamentals and how AI is transforming search engine optimization. Learn the basics before advancing to advanced AI SEO research.
          </p>
          
          <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);">
            <p style="margin: 0; font-size: 1rem; line-height: 1.6;">
              <strong>Note:</strong> This is beginner education content from Neural Command Research Lab. For advanced research on GEO, AEO, and AI search optimization, visit our <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Advanced Research Hub</a>.
            </p>
          </div>
          
          <div class="btn-group" style="margin-top: var(--spacing-lg);">
            <a href="<?= absolute_url('/en-us/learn/can-ai-do-seo/') ?>" class="btn btn--primary" title="Start Learning: Can AI Do SEO?">Start Learning</a>
            <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" class="btn btn--secondary" title="Ready for Advanced Research?">Advanced Research</a>
          </div>
        </div>
      </div>

      <!-- What This Is Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What This Is</h2>
        </div>
        <div class="content-block__body">
          <p>This is a beginner education hub designed for people who are new to SEO or want to understand how AI is transforming search engine optimization. Each page answers a specific beginner question using <strong>Answer-First Architecture</strong>, placing direct answers in the first 1-2 sentences.</p>
          
          <p>This content is part of Neural Command's educational mission: teaching beginners the fundamentals before they advance to advanced AI SEO research.</p>
          
          <h3 class="heading-3">Who This Is For</h3>
          <ul>
            <li><strong>Beginners:</strong> People new to SEO who want to understand the basics</li>
            <li><strong>Marketers:</strong> Those familiar with marketing but not SEO fundamentals</li>
            <li><strong>Business Owners:</strong> Entrepreneurs wanting to understand how SEO works</li>
            <li><strong>Students:</strong> Learners studying digital marketing and SEO</li>
          </ul>
          
          <h3 class="heading-3">Who This Is NOT For</h3>
          <ul>
            <li><strong>Advanced SEOs:</strong> See our <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Advanced Research Hub</a> for expert content</li>
            <li><strong>Enterprise Teams:</strong> Visit our <a href="<?= absolute_url('/en-us/training/') ?>">Training</a> section for operational training</li>
            <li><strong>Implementation Teams:</strong> See our <a href="<?= absolute_url('/en-us/services/') ?>">Services</a> for enterprise implementation</li>
          </ul>
        </div>
      </div>

      <!-- Beginner Pages Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Beginner Education Pages</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-lg); margin-top: var(--spacing-lg);">
            <?php foreach ($beginnerPages as $page): ?>
              <div style="background: #f9f9f9; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
                <h3 class="heading-3" style="margin-top: 0;">
                  <a href="<?= absolute_url('/en-us/learn/' . $page['slug'] . '/') ?>" title="<?= htmlspecialchars($page['title']) ?>">
                    <?= htmlspecialchars($page['title']) ?>
                  </a>
                </h3>
                <p style="margin-bottom: var(--spacing-md);"><?= htmlspecialchars($page['description']) ?></p>
                <a href="<?= absolute_url('/en-us/learn/' . $page['slug'] . '/') ?>" class="btn btn--primary btn--small" title="Read: <?= htmlspecialchars($page['title']) ?>">Learn More</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Progression Guide -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Your Learning Path</h2>
        </div>
        <div class="content-block__body">
          <p>Follow this progression path from beginner to advanced:</p>
          
          <div style="background: #e8f4f8; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin: var(--spacing-lg) 0;">
            <h3 class="heading-3">Level 1: SEO Basics (You Are Here)</h3>
            <p>Start with beginner questions to understand SEO fundamentals:</p>
            <ul>
              <li><a href="<?= absolute_url('/en-us/learn/can-ai-do-seo/') ?>">Can AI Do SEO?</a></li>
              <li><a href="<?= absolute_url('/en-us/learn/types-of-seo/') ?>">What are the 4 Types of SEO?</a></li>
              <li><a href="<?= absolute_url('/en-us/learn/seo-80-20-rule/') ?>">What is the 80/20 Rule in SEO?</a></li>
            </ul>
          </div>
          
          <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin: var(--spacing-lg) 0;">
            <h3 class="heading-3">Level 2: AI + SEO Integration</h3>
            <p>Learn how AI tools assist with SEO tasks:</p>
            <ul>
              <li><a href="<?= absolute_url('/en-us/learn/chatgpt-seo/') ?>">Can ChatGPT Do SEO?</a></li>
              <li><a href="<?= absolute_url('/en-us/learn/ai-30-percent-rule/') ?>">What is the 30% Rule in AI?</a></li>
            </ul>
          </div>
          
          <div style="background: #f9f9f9; border-left: 4px solid #4a90e2; padding: var(--spacing-md); margin: var(--spacing-lg) 0;">
            <h3 class="heading-3">Level 3: Advanced AI SEO Research</h3>
            <p>Ready for advanced research? Explore Neural Command's foundational research:</p>
            <ul>
              <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization (GEO)</a></li>
              <li><a href="<?= absolute_url('/en-us/answer-first-architecture/') ?>">Answer First Architecture</a></li>
              <li><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a></li>
            </ul>
          </div>
          
          <div style="background: #f0f7ff; border-left: 4px solid #12355e; padding: var(--spacing-md); margin: var(--spacing-lg) 0;">
            <h3 class="heading-3">Level 4: Enterprise Implementation</h3>
            <p>Need help implementing AI SEO strategies? Explore Neural Command's services:</p>
            <ul>
              <li><a href="<?= absolute_url('/en-us/services/') ?>">AI Search Optimization Services</a></li>
              <li><a href="<?= absolute_url('/en-us/training/') ?>">Advanced Training for Teams</a></li>
              <li><a href="<?= absolute_url('/en-us/book/') ?>">Book a Consultation</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>
