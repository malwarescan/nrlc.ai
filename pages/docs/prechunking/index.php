<?php
declare(strict_types=1);
// Prechunking Guide
// Public-facing guide to prechunking for AI retrieval, AI Overviews, and LLM citation

// Note: schema_builders.php is already included by router/head.php
// Only require if not already included
if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/docs/prechunking/');

// Build FAQPage schema
$faqItems = [
  [
    'question' => 'What is prechunking?',
    'answer' => 'Prechunking is the process of structuring content before writing so each section can be independently retrieved and cited by AI systems. Unlike content chunking which optimizes presentation, prechunking optimizes extraction and retrieval mechanics.'
  ],
  [
    'question' => 'Why is prechunking important for AI Overviews?',
    'answer' => 'AI Overviews surface individual segments, not full pages. Prechunking ensures those segments are self-contained and retrievable. If a segment depends on surrounding context or uses ambiguous pronouns, it will not be reliably retrieved or cited.'
  ],
  [
    'question' => 'Does prechunking affect rankings?',
    'answer' => 'Prechunking does not directly affect rankings, but it strongly influences retrieval, citation, and visibility in AI-driven results. It operates at the retrieval layer, before ranking algorithms evaluate pages.'
  ],
  [
    'question' => 'How is prechunking different from content chunking?',
    'answer' => 'Content chunking governs presentation and readability. Prechunking governs extraction and retrieval. Chunking is applied during or after writing. Prechunking is structured before writing. They are related but not interchangeable.'
  ],
  [
    'question' => 'What is the ideal chunk size for AI retrieval?',
    'answer' => 'The ideal prechunk size is 40-120 words, with a hard maximum of 150 words. Each prechunk must answer exactly one question and be quotable verbatim without clarification.'
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
    'headline' => 'Prechunking Guide - AI Retrieval, AI Overviews, and LLM Citation',
    'name' => 'Prechunking Guide',
    'description' => 'Complete guide to prechunking content for AI retrieval, AI Overviews, and LLM citation. Learn how to structure content before writing so each section can be independently retrieved and cited.',
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
    'keywords' => 'prechunking, AI retrieval, LLM citation, AI Overviews, content structure, retrieval optimization',
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
          <h1 class="content-block__title heading-1">Prechunking Guide</h1>
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
          <p><a href="/docs/content-chunking/">Learn about content chunking →</a></p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Prechunking Exists</h2>
        </div>
        <div class="content-block__body">
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
          <h2 class="content-block__title heading-2">How LLM and AI Retrieval Actually Works</h2>
        </div>
        <div class="content-block__body">
          <p>Simplified retrieval process:</p>
          <ol>
            <li>User query is interpreted</li>
            <li>Candidate documents are selected</li>
            <li>Segments are extracted</li>
            <li>Segments are scored for answer quality</li>
            <li>One or more segments are surfaced or cited</li>
          </ol>
          <p>Prechunking directly affects steps 3 and 4.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The NRLC Prechunking Framework</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">Step 1: Define the Question Inventory First</h3>
          <p>Before writing, enumerate the exact questions the content must answer.</p>
          <p>Example:</p>
          <ul>
            <li>What is prechunking in SEO?</li>
            <li>How does prechunking affect LLM retrieval?</li>
            <li>What is the ideal chunk size for AI retrieval?</li>
            <li>How is prechunking different from content chunking?</li>
          </ul>
          <p>Each question becomes one prechunk. No exceptions.</p>

          <h3 class="heading-3">Step 2: Enforce Atomicity</h3>
          <p>Each prechunk must pass this test:</p>
          <p><strong>If this section were retrieved alone, would it fully answer the question without clarification?</strong></p>
          <p>If no, the prechunk fails.</p>
          <p>Atomic prechunks:</p>
          <ul>
            <li>Never reference other sections</li>
            <li>Never rely on pronouns like "this" or "above"</li>
            <li>Never summarize other prechunks</li>
          </ul>

          <h3 class="heading-3">Step 3: Use Deterministic, Query-Shaped Headers</h3>
          <p>Headers are retrieval anchors.</p>
          <p><strong>Allowed:</strong></p>
          <ul>
            <li>What is prechunking in SEO</li>
            <li>How prechunking affects AI retrieval</li>
          </ul>
          <p><strong>Disallowed:</strong></p>
          <ul>
            <li>Understanding prechunking</li>
            <li>Why this matters</li>
          </ul>
          <p>Literal language retrieves. Clever language does not.</p>

          <h3 class="heading-3">Step 4: Constrain Prechunk Size</h3>
          <p>Based on real-world retrieval behavior:</p>
          <ul>
            <li>Ideal length: 40–120 words</li>
            <li>Hard stop: ~150 words</li>
            <li>Exactly one answer per prechunk</li>
          </ul>

          <h3 class="heading-3">Step 5: Remove Narrative Glue Entirely</h3>
          <p><strong>Disallowed:</strong></p>
          <ul>
            <li>"As mentioned earlier"</li>
            <li>"In conclusion"</li>
            <li>Transitional filler</li>
          </ul>
          <p>Each prechunk must read like a standalone answer, not part of an essay.</p>

          <h3 class="heading-3">Step 6: Citation Test (Final Gate)</h3>
          <p>Each prechunk must pass:</p>
          <p><strong>Could this be quoted verbatim as an answer by an LLM?</strong></p>
          <p>If not, rewrite or split.</p>

        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Prechunking vs Content Chunking</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Content Chunking:</strong></p>
          <ul>
            <li>Purpose: UX, readability, scannability</li>
            <li>Applied: During or after writing</li>
            <li>Governs: Presentation</li>
          </ul>
          <p><strong>Prechunking:</strong></p>
          <ul>
            <li>Purpose: Retrieval, citation, AI answers</li>
            <li>Applied: Before writing</li>
            <li>Governs: Extraction</li>
          </ul>
          <p>They are related. They are not interchangeable.</p>
          <p><a href="/docs/content-chunking/">Learn about content chunking →</a></p>
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
          <h2 class="content-block__title heading-2">Validate Your Content</h2>
        </div>
        <div class="content-block__body">
          <p>Use our prechunking validator to check your content:</p>
          <pre><code>php scripts/validate_prechunking.php [file_path]</code></pre>
          <p>This validator checks:</p>
          <ul>
            <li>Question inventory structure</li>
            <li>Atomicity enforcement</li>
            <li>Query-shaped headers</li>
            <li>Chunk size constraints (40-120 words ideal, 150 max)</li>
            <li>Narrative glue elimination</li>
            <li>Citation readiness</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

