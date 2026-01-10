<?php
// Spoke 2: AI Retrieval & LLM Citation
// Expert layer - links back to both pillar and spoke 1

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

// Get canonical URL with proper locale prefix
// Use canonical path from meta directive if available, otherwise use request URI
$canonicalPath = $GLOBALS['__page_meta']['canonicalPath'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (preg_match('#^/([a-z]{2}-[a-z]{2})/insights/ai-retrieval-llm-citation/#i', $canonicalPath, $m)) {
  $canonicalUrl = absolute_url($canonicalPath);
} else {
  // Fallback: use en-us as default for insights pages
  $canonicalUrl = absolute_url('/en-us/insights/ai-retrieval-llm-citation/');
}

// Build FAQPage schema (lift-optimized) - Expanded from 2 to 6 questions
$faqItems = [
  [
    'question' => 'How do LLMs retrieve web content?',
    'answer' => 'LLMs do not browse web pages like users. They select, score, and assemble information from individual content segments before producing an answer. The retrieval process operates in five steps: query interpretation, candidate document selection, segment extraction, segment scoring, and surfacing or citation. Each step evaluates segments for answer quality, relevance, and completeness.'
  ],
  [
    'question' => 'How does AI decide what content to cite?',
    'answer' => 'AI systems decide which content to cite based on a scoring system that evaluates multiple factors: (1) Segment relevance to the query—how closely the segment matches user intent, (2) Completeness of the answer—whether it fully addresses the question, (3) Atomic clarity—whether the segment can stand alone without context, (4) Source authority signals—domain trust, entity consistency, and structured data, (5) Confidence thresholds—minimum score required for citation. The highest-scoring segments that meet confidence thresholds are selected for citation. This is why prechunking matters: it ensures segments score highly on all these factors, making them more likely to be cited in AI-generated answers.'
  ],
  [
    'question' => 'What factors determine if content gets cited by AI?',
    'answer' => 'Several factors determine citation likelihood: segment relevance (how closely it matches the query), completeness (whether it fully answers the question), atomic clarity (self-contained without context dependencies), explicit language (no pronouns or ambiguous references), verbatim quotability (can be cited without clarification), source authority (trust signals from the domain), entity consistency (consistent naming across platforms), and structured data (machine-readable signals). Content that scores highly across these factors is more likely to be cited.'
  ],
  [
    'question' => 'Why do high-ranking pages get ignored by AI systems?',
    'answer' => 'High-ranking pages can be ignored by AI systems if their content chunks are ambiguous, segments depend on context from other sections, multiple answers are combined in one segment, or pronouns and references make segments unclear. AI systems prioritize clear, atomic segments that can be cited verbatim. Page-level ranking does not guarantee segment-level retrieval because AI systems evaluate and extract at the segment level, not the page level.'
  ],
  [
    'question' => 'How is AI citation different from traditional SEO?',
    'answer' => 'Traditional SEO optimizes for page-level rankings in search results, while AI citation optimization focuses on segment-level retrieval and citation in AI-generated answers. AI systems extract individual segments, score them for relevance and completeness, and cite the highest-scoring segments—regardless of page ranking. This means even well-ranking pages may be ignored if their individual segments are ambiguous or context-dependent. AI citation requires prechunking (structuring content before writing) to ensure segments are atomic, self-contained, and citation-ready.'
  ],
  [
    'question' => 'What is prechunking and how does it affect AI citations?',
    'answer' => 'Prechunking is the practice of structuring content before writing so each section can be independently retrieved and cited by AI systems. Unlike content chunking (which helps presentation and readability), prechunking governs extraction and retrieval at the segment level. Prechunking directly affects steps 3 and 4 of the retrieval process (segment extraction and segment scoring). If content cannot be cleanly segmented, it will not be retrieved or cited. Prechunked content ensures segments are atomic, self-contained, and score highly on relevance, completeness, and citation readiness factors.'
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
        'name' => 'AI Retrieval & LLM Citation',
        'item' => $canonicalUrl
      ]
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
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'How LLMs Retrieve and Cite Web Content',
    'name' => 'How LLMs Retrieve and Cite Web Content',
    'description' => 'Understand how AI systems extract, score, and surface content for answers and citations.',
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
    'keywords' => 'AI retrieval, LLM citation, AI Overviews, content extraction, segment scoring',
    'inLanguage' => 'en-US',
    'proficiencyLevel' => 'Expert'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Back Links to Pillar and Spoke 1 -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <div class="content-block__body">
          <p style="margin-bottom: var(--spacing-sm);">
            <a href="<?= absolute_url('/en-us/insights/content-chunking-seo/') ?>" class="btn btn--secondary">← Start with Content Chunking</a>
          </p>
          <p>
            <a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>" class="btn btn--secondary">← Learn Prechunking</a>
          </p>
        </div>
      </div>

      <!-- Hero Block -->
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">How LLMs Retrieve and Cite Web Content</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">Expert guide to how AI systems retrieve and cite content. Understand the retrieval layer that determines visibility in AI Overviews, LLM answers, and zero-click results.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How LLM Retrieval Works</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-retrieval">
            <p>
              LLMs do not browse web pages like users; they select, score, and assemble information from individual segments before producing an answer.
            </p>
          </div>
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
          <h2 class="content-block__title heading-2">Common Misconceptions</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-system-truth">
            <p>
              Visibility in AI-generated answers depends more on segment clarity and relevance than on traditional page-level optimization.
            </p>
          </div>
          <p>Many content creators assume that high page rankings or comprehensive content automatically translate to AI citations. However, AI systems evaluate and extract at the segment level, meaning that even well-ranking pages may be ignored if their individual segments are ambiguous or context-dependent.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How LLMs Decide Which Content to Cite</h2>
        </div>
        <div class="content-block__body">
          <p>LLMs use a multi-factor decision system to determine which content segments to cite in their answers. The decision process evaluates segments against several criteria and assigns scores based on citation readiness.</p>
          
          <h3 class="heading-3">Decision Criteria</h3>
          <p>LLMs evaluate segments using six primary factors:</p>
          <ol>
            <li><strong>Segment Relevance Score:</strong> How closely the segment matches the query intent. Segments that directly address the question receive higher relevance scores.</li>
            <li><strong>Completeness Score:</strong> Whether the segment fully answers the question without requiring additional context. Complete answers score higher than partial answers.</li>
            <li><strong>Confidence Threshold:</strong> Minimum confidence level required for citation. Segments below the threshold are filtered out, even if they are relevant.</li>
            <li><strong>Source Authority:</strong> Trust signals from the source domain, including domain age, backlink profile, entity consistency, and structured data implementation.</li>
            <li><strong>Atomic Clarity:</strong> Whether the segment can stand alone without context from surrounding sections. Atomic segments that answer exactly one question score higher.</li>
            <li><strong>Verification Signals:</strong> Structured data, entity consistency, canonical control, and other machine-readable signals that help AI systems verify and trust the content.</li>
          </ol>
          
          <h3 class="heading-3">Scoring and Selection Process</h3>
          <p>The scoring process weights these factors differently depending on the query type and AI system. For factual queries, relevance and completeness are heavily weighted. For exploratory queries, atomic clarity and verification signals may carry more weight.</p>
          
          <p>Once scored, segments are ranked by their composite score. The highest-scoring segments that meet confidence thresholds are selected for citation. Multiple segments may be cited if they provide complementary information or if the query requires a comprehensive answer.</p>
          
          <div class="callout-system-truth">
            <p><strong>Key Insight:</strong> The decision process happens at the segment level, not the page level. This is why prechunking matters: it ensures each segment scores highly on all decision factors, maximizing citation likelihood.</p>
          </div>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Retrieval and Citation Work</h2>
        </div>
        <div class="content-block__body">
          <p>When AI systems need to answer a question, they don't read entire pages. Instead, they extract specific segments that directly address the query, score those segments for relevance and completeness, and then use the highest-scoring segments to generate their response.</p>
          
          <div class="callout-example">
            <strong>Example:</strong>
            <p>
              When a user asks how AI summarizes web content, an LLM may retrieve only a single paragraph explaining section-level evaluation rather than the full article, and use that segment to generate its response.
            </p>
          </div>
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
          <p><a href="<?= absolute_url('/en-us/insights/content-chunking-seo/') ?>">Learn about content chunking →</a></p>

          <h3 class="heading-3">Layer 2: Prechunking</h3>
          <p>Governs extraction and retrieval. Helps systems extract and cite content. Applied before writing.</p>
          <p><a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">Learn about prechunking →</a></p>

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

      <!-- Prerequisites Section -->
      <div class="content-block module" style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: var(--color-background-alt, #f5f5f5);">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Prerequisites</h2>
        </div>
        <div class="content-block__body">
          <p>To fully understand AI retrieval, you should first understand:</p>
          <ul>
            <li><a href="<?= absolute_url('/en-us/insights/content-chunking-seo/') ?>">Content Chunking</a> - How content is structured for presentation</li>
            <li><a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">Prechunking</a> - How content is structured for extraction</li>
          </ul>
          <p>These three guides form a complete system: chunking for presentation, prechunking for extraction, and retrieval for visibility.</p>
        </div>
      </div>

    </div>
  </section>
</main>

