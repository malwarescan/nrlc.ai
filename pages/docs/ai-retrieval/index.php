<?php
declare(strict_types=1);
// AI Retrieval & LLM Citation Guide
// Expert-level guide to how AI systems retrieve and cite content

// Note: schema_builders.php is already included by router/head.php
// Only require if not already included
if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/docs/ai-retrieval/');

// Build FAQPage schema
$faqItems = [
  [
    'question' => 'How do AI systems retrieve content?',
    'answer' => 'AI systems retrieve content through a multi-step process: query interpretation, candidate document selection, segment extraction, segment scoring for answer quality, and finally surfacing or citing one or more segments. Prechunking directly affects the extraction and scoring steps.'
  ],
  [
    'question' => 'What makes content citable by LLMs?',
    'answer' => 'Content is citable when it can be quoted verbatim without clarification. This requires atomic, self-contained segments that do not depend on surrounding context, use ambiguous pronouns, or combine multiple answers in one segment.'
  ],
  [
    'question' => 'How does prechunking affect AI Overviews?',
    'answer' => 'AI Overviews surface individual segments, not full pages. Prechunking ensures those segments are self-contained and retrievable. Without prechunking, segments may be ignored, mutated, or replaced by competitor content with clearer chunks.'
  ],
  [
    'question' => 'Does content chunking help with AI retrieval?',
    'answer' => 'Content chunking helps AI systems scan and summarize content, but it does not control how content is retrieved or cited. Prechunking is required for reliable retrieval and citation in AI-driven results.'
  ],
  [
    'question' => 'Why do high-ranking pages sometimes get ignored by AI systems?',
    'answer' => 'High-ranking pages can be ignored if their content chunks are ambiguous, depend on context, or combine multiple answers. AI systems prioritize clear, atomic segments that can be cited verbatim. Prechunking solves this by engineering content at the chunk level.'
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
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'AI Retrieval & LLM Citation Guide',
    'name' => 'AI Retrieval & LLM Citation Guide',
    'description' => 'Expert guide to how AI systems retrieve and cite content. Learn how search engines and LLMs extract segments, score them for answer quality, and surface them in AI Overviews and answers.',
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
    'keywords' => 'AI retrieval, LLM citation, AI Overviews, content extraction, segment scoring, AI search',
    'inLanguage' => 'en-US',
    'proficiencyLevel' => 'Expert'
  ],
  ld_organization()
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">AI Retrieval & LLM Citation Guide</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Expert guide to how AI systems retrieve and cite content. Understand the retrieval layer that determines visibility in AI Overviews, LLM answers, and zero-click results.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How AI Retrieval Works</h2>
        </div>
        <div class="content-block__body">
          <p>Search engines and LLMs do not retrieve pages. They retrieve segments.</p>
          <p>The retrieval process operates in five steps:</p>
          <ol>
            <li><strong>Query interpretation:</strong> The system understands what the user is asking</li>
            <li><strong>Candidate document selection:</strong> Pages are identified as potential sources</li>
            <li><strong>Segment extraction:</strong> Individual segments are pulled from candidate documents</li>
            <li><strong>Segment scoring:</strong> Each segment is evaluated for answer quality and relevance</li>
            <li><strong>Surfacing or citation:</strong> One or more segments are shown to the user or cited in answers</li>
          </ol>
          <p>Prechunking directly affects steps 3 and 4. If content cannot be cleanly segmented, it will not be retrieved or cited.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Makes Content Retrievable</h2>
        </div>
        <div class="content-block__body">
          <p>Content is retrievable when segments:</p>
          <ul>
            <li>Are atomic and self-contained</li>
            <li>Answer exactly one question</li>
            <li>Do not depend on surrounding context</li>
            <li>Use explicit language, not pronouns</li>
            <li>Can be quoted verbatim without clarification</li>
          </ul>
          <p>If a segment fails any of these criteria, it will not be reliably retrieved or cited.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why High-Ranking Pages Get Ignored</h2>
        </div>
        <div class="content-block__body">
          <p>High-ranking pages can be ignored by AI systems if:</p>
          <ul>
            <li>Their content chunks are ambiguous</li>
            <li>Segments depend on context from other sections</li>
            <li>Multiple answers are combined in one segment</li>
            <li>Pronouns and references make segments unclear</li>
          </ul>
          <p>AI systems prioritize clear, atomic segments that can be cited verbatim. Page-level ranking does not guarantee segment-level retrieval.</p>
          <p>This is why prechunking matters: it engineers content at the chunk level, not the page level.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">AI Overviews and Segment Extraction</h2>
        </div>
        <div class="content-block__body">
          <p>AI Overviews surface individual segments, not full pages. Each segment must:</p>
          <ul>
            <li>Stand alone as a complete answer</li>
            <li>Be quotable verbatim</li>
            <li>Not require clarification or context</li>
          </ul>
          <p>Without prechunking, segments may be ignored, mutated, or replaced by competitor content with clearer chunks.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Three-Layer System</h2>
        </div>
        <div class="content-block__body">
          <p>Content visibility in AI-driven search operates across three layers:</p>
          
          <h3 class="heading-3">Layer 1: Content Chunking</h3>
          <p>Governs presentation and readability. Helps users and AI scan content. Applied during or after writing.</p>
          <p><a href="/docs/content-chunking/">Learn about content chunking →</a></p>

          <h3 class="heading-3">Layer 2: Prechunking</h3>
          <p>Governs extraction and retrieval. Helps systems extract and cite content. Applied before writing.</p>
          <p><a href="/docs/prechunking/">Learn about prechunking →</a></p>

          <h3 class="heading-3">Layer 3: Retrieval & Citation</h3>
          <p>Governs visibility and citation. Determines what gets seen in AI Overviews and LLM answers.</p>
          <p><em>This page covers Layer 3.</em></p>

          <p><strong>Summary:</strong> Chunking helps users and AI scan. Prechunking helps systems extract. Retrieval determines visibility and citation.</p>
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
          <h2 class="content-block__title heading-2">Prerequisites</h2>
        </div>
        <div class="content-block__body">
          <p>To fully understand AI retrieval, you should first understand:</p>
          <ul>
            <li><a href="/docs/content-chunking/">Content Chunking</a> - How content is structured for presentation</li>
            <li><a href="/docs/prechunking/">Prechunking</a> - How content is structured for extraction</li>
          </ul>
          <p>These three guides form a complete system: chunking for presentation, prechunking for extraction, and retrieval for visibility.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__body">
          <p>This mechanism explains how <a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization</a> systems retrieve, evaluate, and select sources for AI-generated answers.</p>
        </div>
      </div>

    </div>
  </section>
</main>

