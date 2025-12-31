<?php
declare(strict_types=1);
// Content Chunking Guide
// Public-facing guide to content chunking for SEO, UX, and AI parsing

// Note: schema_builders.php is already included by router/head.php
// Only require if not already included
if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/docs/content-chunking/');

// Build FAQPage schema
$faqItems = [
  [
    'question' => 'What is content chunking in SEO?',
    'answer' => 'Content chunking is the practice of structuring written content into clear, logically grouped sections to improve readability, scannability, on-page SEO, and AI summarization.'
  ],
  [
    'question' => 'Does content chunking help AI?',
    'answer' => 'Content chunking helps AI systems scan and summarize content, but it does not control how content is retrieved or cited. Prechunking is required for reliable retrieval and citation in AI-driven results.'
  ],
  [
    'question' => 'Is content chunking the same as prechunking?',
    'answer' => 'No. Content chunking governs presentation and readability. Prechunking governs extraction and retrieval. Chunking is applied during or after writing. Prechunking is structured before writing. They are related but not interchangeable.'
  ]
];

$GLOBALS['__jsonld'] = [
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
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Content Chunking Guide - SEO, UX, and AI Parsing',
    'name' => 'Content Chunking Guide',
    'description' => 'Complete guide to structuring content into digestible, scannable chunks for better readability, SEO, and AI parsing.',
    'url' => $canonicalUrl,
    'author' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'NRLC.ai'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'NRLC.ai'
    ],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d'),
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonicalUrl
    ],
    'keywords' => 'content chunking, content structure, SEO content, readable content, scannable content',
    'inLanguage' => 'en-US'
  ],
  ld_organization()
];
?>
<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Content Chunking Guide</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Learn how to structure content into digestible, scannable chunks that improve readability, SEO, and AI parsing.</p>
        </div>
      </div>

      <div class="content-block module">
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
          <p>All pages must follow a logical hierarchy:</p>
          <ul>
            <li><strong>H1</strong> — Page topic</li>
            <li><strong>H2</strong> — Primary sections</li>
            <li><strong>H3</strong> — Supporting ideas</li>
          </ul>
          <p>Headers must describe what the section contains. Teasing, vague, or abstract headers are disallowed.</p>

          <h3 class="heading-3">3. Short, Scannable Paragraphs</h3>
          <p>Paragraph constraints:</p>
          <ul>
            <li>2–4 sentences</li>
            <li>~40–80 words</li>
          </ul>
          <p>Overlong paragraphs degrade scannability and comprehension.</p>

          <h3 class="heading-3">4. Visual Separation</h3>
          <p>Content must use visual structure where appropriate:</p>
          <ul>
            <li>White space</li>
            <li>Lists</li>
            <li>Subheaders</li>
            <li>Tables (sparingly)</li>
          </ul>
          <p>This aids both human scanning and AI section detection.</p>

          <h3 class="heading-3">5. Logical Progression</h3>
          <p>Chunks should follow a logical narrative flow when applicable:</p>
          <ul>
            <li>Definitions → explanations → examples → implications</li>
          </ul>
          <p>Narrative continuity is allowed in chunking. This is a key distinction from prechunking.</p>

        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Good vs Bad Content Chunking</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">Poor Chunking Includes:</h3>
          <ul>
            <li>Large uninterrupted blocks of text</li>
            <li>Vague or generic headers</li>
            <li>Multiple ideas per paragraph</li>
            <li>No visual separation</li>
          </ul>

          <h3 class="heading-3">Good Chunking Includes:</h3>
          <ul>
            <li>Clear, descriptive headers</li>
            <li>Focused sections</li>
            <li>Short paragraphs</li>
            <li>Easy scanning</li>
          </ul>

        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Content Chunking Mistakes</h2>
        </div>
        <div class="content-block__body">
          <p>The following are prohibited:</p>
          <ul>
            <li>Overusing headers for every sentence</li>
            <li>Creating sections with no substantive content</li>
            <li>Breaking narrative flow unnecessarily</li>
            <li>Confusing chunking with atomic segmentation</li>
            <li>Treating chunking as a ranking hack</li>
          </ul>
          <p>Content chunking is a clarity discipline, not a growth trick.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Content Chunking vs Prechunking</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Important distinction:</strong> Content chunking and prechunking are related but distinct concepts.</p>
          
          <h3 class="heading-3">Content Chunking</h3>
          <ul>
            <li><strong>Purpose:</strong> UX, readability, scannability</li>
            <li><strong>When:</strong> Applied during or after writing</li>
            <li><strong>Focus:</strong> Presentation and comprehension</li>
            <li><strong>Governs:</strong> How content is structured for human readers</li>
          </ul>

          <h3 class="heading-3">Prechunking</h3>
          <ul>
            <li><strong>Purpose:</strong> AI retrieval, citation, LLM isolation</li>
            <li><strong>When:</strong> Structured before writing</li>
            <li><strong>Focus:</strong> Extraction and retrieval mechanics</li>
            <li><strong>Governs:</strong> How content is extracted by machines</li>
          </ul>

          <p>Chunking governs presentation. Prechunking governs extraction. They are related but NOT interchangeable.</p>
          <p><a href="/docs/prechunking/">Learn more about prechunking →</a></p>
          <p><a href="/docs/ai-retrieval/">Learn about AI retrieval and citation →</a></p>
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

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Validation Checklist</h2>
        </div>
        <div class="content-block__body">
          <p>Content passes chunking standards only if ALL are true:</p>
          <ul>
            <li>A user can scan headers and understand the page</li>
            <li>Each section has a clear, singular purpose</li>
            <li>Paragraphs are readable without effort</li>
            <li>Key ideas are visually separated</li>
            <li>The page does not feel overwhelming</li>
          </ul>
          <p>If users must read linearly to understand the page, chunking has failed.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Validate Your Content</h2>
        </div>
        <div class="content-block__body">
          <p>Use our content chunking validator to check your content:</p>
          <pre><code>php scripts/validate_content_chunking.php [file_path]</code></pre>
          <p>This validator checks:</p>
          <ul>
            <li>Header hierarchy and clarity</li>
            <li>Paragraph length (40-80 words ideal)</li>
            <li>Visual separation</li>
            <li>One idea per section</li>
            <li>Logical progression</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

