<?php
// Pillar Page: Content Chunking for SEO
// Entry point for the content chunking → prechunking → retrieval cluster

// Note: schema_builders.php is already included by router/head.php
if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/insights/content-chunking-seo/');

// Build FAQPage schema
$faqItems = [
  [
    'question' => 'What is content chunking in SEO?',
    'answer' => 'Content chunking is the practice of structuring written content into clear, logically grouped sections to improve readability, scannability, on-page SEO, and AI summarization.'
  ],
  [
    'question' => 'Does content chunking help AI?',
    'answer' => 'Content chunking helps AI systems scan and summarize content, but it does not control how content is retrieved or cited.'
  ],
  [
    'question' => 'Is content chunking the same as prechunking?',
    'answer' => 'No. Content chunking governs presentation and readability. Prechunking governs extraction and retrieval by AI systems.'
  ]
];

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Content Chunking for SEO: How to Structure Content for Readability and AI',
    'name' => 'Content Chunking for SEO',
    'description' => 'Learn how to structure content into digestible, scannable chunks that improve readability, SEO, and AI parsing.',
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
    'keywords' => 'content chunking, SEO content structure, readable content, scannable content',
    'inLanguage' => 'en-US'
  ],
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
  ],
  ld_organization()
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Content Chunking for SEO</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Learn how to structure content for readability, SEO, and AI parsing</p>
          <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
            <a href="#start" class="btn btn--primary">Start with Content Chunking</a>
            <a href="/insights/prechunking-content-ai-retrieval/" class="btn btn--secondary">Ready for AI Retrieval?</a>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div id="start" class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What is Content Chunking?</h2>
        </div>
        <div class="content-block__body">
          <p>Content chunking is the practice of structuring written content into digestible, logically grouped sections to improve human readability, scannability, on-page SEO, AI parsing, and featured snippet eligibility.</p>
          <p>Chunking is applied during or after writing, not strictly before. It optimizes presentation and comprehension, not retrieval mechanics.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Content Chunking Matters</h2>
        </div>
        <div class="content-block__body">
          <p>Users do not read pages linearly. They scan.</p>
          <p>Proper chunking:</p>
          <ul>
            <li>Reduces bounce rate</li>
            <li>Improves time on page</li>
            <li>Increases engagement</li>
            <li>Helps Google understand topical structure</li>
            <li>Makes content easier for AI systems to summarize</li>
          </ul>
          <p>Poor chunking results in wall-of-text fatigue, missed key points, lower UX signals, and reduced snippet eligibility.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Core Content Chunking Principles</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">1. One Idea Per Section</h3>
          <p>Each section must focus on a single concept or subtopic. If a section answers multiple questions, it must be split.</p>

          <h3 class="heading-3">2. Clear Hierarchical Headers</h3>
          <p>All pages must follow a logical hierarchy: H1 for page topic, H2 for primary sections, H3 for supporting ideas. Headers must describe what the section contains.</p>

          <h3 class="heading-3">3. Short, Scannable Paragraphs</h3>
          <p>Paragraphs should be 2–4 sentences, approximately 40–80 words. Overlong paragraphs degrade scannability and comprehension.</p>

          <h3 class="heading-3">4. Visual Separation</h3>
          <p>Content must use visual structure where appropriate: white space, lists, subheaders, and tables (sparingly). This aids both human scanning and AI section detection.</p>

          <h3 class="heading-3">5. Logical Progression</h3>
          <p>Chunks should follow a logical narrative flow when applicable: definitions → explanations → examples → implications. Narrative continuity is allowed in chunking.</p>
        </div>
      </div>

      <!-- Go Deeper Card Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Go Deeper</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-lg); margin-top: var(--spacing-md);">
            
            <div class="content-block" style="padding: var(--spacing-lg); border: 1px solid var(--color-border, #e0e0e0); border-radius: 4px;">
              <h3 class="content-block__title heading-3">Prechunking Content for AI Retrieval</h3>
              <p>Learn how content is structured before writing to enable AI extraction and citation. Understand the difference between presentation (chunking) and extraction (prechunking).</p>
              <div style="margin-top: var(--spacing-md);">
                <a href="/insights/prechunking-content-ai-retrieval/" class="btn btn--primary">Learn Prechunking →</a>
              </div>
            </div>

            <div class="content-block" style="padding: var(--spacing-lg); border: 1px solid var(--color-border, #e0e0e0); border-radius: 4px;">
              <h3 class="content-block__title heading-3">How LLMs Retrieve and Cite Content</h3>
              <p>Understand how AI systems extract, score, and surface web content. Learn about segment extraction, scoring algorithms, and citation logic in AI Overviews.</p>
              <div style="margin-top: var(--spacing-md);">
                <a href="/insights/ai-retrieval-llm-citation/" class="btn btn--primary">Learn AI Retrieval →</a>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- FAQ Section -->
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

    </div>
  </section>
</main>

