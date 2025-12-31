<?php
// Spoke 1: Prechunking Content for AI Retrieval
// Advanced layer - links back to pillar, forward to spoke 2

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/insights/prechunking-content-ai-retrieval/');

// Build FAQPage schema (lift-optimized)
$faqItems = [
  [
    'question' => 'What is prechunking?',
    'answer' => 'Prechunking is the process of structuring content before writing so each section can be independently retrieved, scored, and cited by AI systems.'
  ],
  [
    'question' => 'Why is prechunking important for AI Overviews?',
    'answer' => 'AI Overviews surface individual content segments rather than full pages. Prechunking ensures those segments are self-contained and retrievable.'
  ],
  [
    'question' => 'Does prechunking affect search rankings?',
    'answer' => 'Prechunking does not directly affect rankings, but it strongly influences retrieval, citation, and visibility in AI-generated answers.'
  ]
];

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
        'name' => 'Insights',
        'item' => absolute_url('/en-us/insights/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Prechunking Content for AI Retrieval',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // Article
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Prechunking Content for AI Retrieval, AI Overviews, and LLM Citation',
    'name' => 'Prechunking Content for AI Retrieval',
    'description' => 'Learn how to structure content before writing so each section can be independently retrieved and cited by AI systems.',
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
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d'),
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonicalUrl
    ],
    'keywords' => 'prechunking, AI retrieval, LLM citation, AI Overviews, content structure',
    'inLanguage' => 'en-US'
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
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Back Link to Pillar -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <div class="content-block__body">
          <p><a href="/insights/content-chunking-seo/" class="btn btn--secondary">← Start with Content Chunking</a></p>
        </div>
      </div>

      <!-- Hero Block -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Prechunking Content for AI Retrieval</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Learn how to structure content before writing so each section can be independently retrieved, scored, and cited by search engines and large language models.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Is Prechunking?</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>
              Prechunking is the process of structuring content before writing so each section can be independently retrieved, scored, and cited by AI systems.
            </p>
          </div>
          <p>Prechunking is the discipline of structuring content before writing so that each unit can be independently retrieved, scored, and cited by search engines and large language models.</p>
          <p>Unlike content chunking, which optimizes presentation and readability, prechunking optimizes extraction and retrieval mechanics.</p>
          <p><strong>Prechunked content is designed to survive isolation.</strong></p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Prechunking Is Not</h2>
        </div>
        <div class="content-block__body">
          <p>Prechunking is not:</p>
          <ul>
            <li>Improving readability</li>
            <li>Reducing paragraph length</li>
            <li>Visual formatting</li>
            <li>Traditional UX optimization</li>
          </ul>
          <p>Those are content chunking concerns. Prechunking operates at the retrieval layer, not the presentation layer.</p>
          <p><a href="/insights/content-chunking-seo/">Learn about content chunking →</a></p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Prechunking Exists</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-retrieval">
            <p>
              AI systems do not retrieve pages as a whole; they extract and score individual content segments before generating answers.
            </p>
          </div>
          <p>Search engines and LLMs do not retrieve pages. They retrieve segments.</p>
          <p>If a segment:</p>
          <ul>
            <li>Depends on surrounding context</li>
            <li>References other sections</li>
            <li>Uses ambiguous pronouns</li>
            <li>Combines multiple answers</li>
          </ul>
          <p>It will not be reliably retrieved or cited. Prechunking exists to solve this failure mode.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The NRLC Prechunking Framework</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">Step 1: Define the Question Inventory First</h3>
          <p>Before writing, enumerate the exact questions the content must answer. Each question becomes one prechunk. No exceptions.</p>

          <h3 class="heading-3">Step 2: Enforce Atomicity</h3>
          <p>Each prechunk must pass this test: <strong>If this section were retrieved alone, would it fully answer the question without clarification?</strong> If no, the prechunk fails.</p>

          <h3 class="heading-3">Step 3: Use Deterministic, Query-Shaped Headers</h3>
          <p>Headers are retrieval anchors. Use literal language like "What is prechunking in SEO" not abstract language like "Understanding prechunking".</p>

          <h3 class="heading-3">Step 4: Constrain Prechunk Size</h3>
          <p>Ideal length: 40–120 words. Hard stop: ~150 words. Exactly one answer per prechunk.</p>

          <h3 class="heading-3">Step 5: Remove Narrative Glue Entirely</h3>
          <p>Disallowed: "As mentioned earlier", "In conclusion", transitional filler. Each prechunk must read like a standalone answer.</p>

          <h3 class="heading-3">Step 6: Citation Test (Final Gate)</h3>
          <p>Each prechunk must pass: <strong>Could this be quoted verbatim as an answer by an LLM?</strong> If not, rewrite or split.</p>

          <div class="callout-example">
            <strong>Example:</strong>
            <p>
              Instead of writing a long explanation about AI retrieval, a prechunked page would define one section that answers "What is AI retrieval?" and another that answers "How are content segments scored?", ensuring each section can stand alone if retrieved independently.
            </p>
          </div>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Frequently Asked Questions</h2>
        </div>
        <div class="content-block__body">
          <?php foreach ($faqItems as $faq): ?>
            <div style="margin-bottom: var(--spacing-md);">
              <h3 class="heading-3"><?= htmlspecialchars($faq['question']) ?></h3>
              <p><?= htmlspecialchars($faq['answer']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Forward Link to Spoke 2 -->
      <div class="content-block module" style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: var(--color-background-alt, #f5f5f5); border-left: 4px solid var(--color-brand, #12355e);">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Next: AI Retrieval & Citation</h2>
        </div>
        <div class="content-block__body">
          <p>Ready to understand how AI systems actually retrieve and cite content? Learn about segment extraction, scoring algorithms, and citation logic.</p>
          <div style="margin-top: var(--spacing-md);">
            <a href="/insights/ai-retrieval-llm-citation/" class="btn btn--primary">Learn AI Retrieval →</a>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>

