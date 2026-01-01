<?php
// Master GEO Pillar Page
// Layer 2: Authoritative root for "What is Generative Engine Optimization?"

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/');

// Build FAQPage schema
$faqItems = [
  [
    'question' => 'What is Generative Engine Optimization?',
    'answer' => 'Generative Engine Optimization (GEO) is the discipline of structuring content so it can be retrieved, summarized, and cited by generative AI systems. Unlike traditional SEO, which optimizes for page-level ranking, GEO optimizes for segment-level retrieval and citation.'
  ],
  [
    'question' => 'How do generative engines retrieve information?',
    'answer' => 'Generative engines retrieve information by selecting candidate documents, extracting relevant segments, scoring those segments for answer quality and citation eligibility, and then surfacing or citing the highest-scoring segments. They do not retrieve pages as a whole.'
  ],
  [
    'question' => 'What is the difference between ranking and retrieval?',
    'answer' => 'Ranking determines page-level visibility in traditional search results. Retrieval determines segment-level visibility in AI-generated answers. A high-ranking page may be ignored by generative engines if its segments are ambiguous or context-dependent.'
  ],
  [
    'question' => 'Why does traditional SEO fail under GEO?',
    'answer' => 'Traditional SEO optimizes for page-level signals and user experience. GEO requires segment-level optimization for atomicity, clarity, and citation readiness. Page-level ranking does not guarantee segment-level retrieval.'
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
        'name' => 'Generative Engine Optimization',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle (instructional authority)
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Generative Engine Optimization: How AI Systems Retrieve and Cite Content',
    'name' => 'Generative Engine Optimization',
    'description' => 'Complete guide to GEO: how generative engines retrieve information, why traditional SEO fails, and how to structure content for AI retrieval and citation.',
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
    'keywords' => 'generative engine optimization, GEO, AI retrieval, LLM citation, AI Overviews',
    'inLanguage' => 'en-US',
    'proficiencyLevel' => 'Expert',
    'about' => [
      '@type' => 'DefinedTerm',
      '@id' => $canonicalUrl . '#geo',
      'name' => 'Generative Engine Optimization',
      'description' => 'The discipline of structuring content for retrieval and citation by generative AI systems.'
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
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Generative Engine Optimization</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">The discipline of structuring content for retrieval and citation by generative AI systems</p>
        </div>
      </div>

      <!-- Section 1: What GEO Is -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What GEO Is</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>
              Generative Engine Optimization (GEO) is the discipline of structuring content so it can be retrieved, summarized, and cited by generative AI systems. Unlike traditional SEO, which optimizes for page-level ranking, GEO optimizes for segment-level retrieval and citation.
            </p>
          </div>
          <p>GEO operates at the system level, not the marketing level. It is a mechanics discipline, not a growth hack.</p>
          <p>Traditional SEO answers: "How do I rank higher?"</p>
          <p>GEO answers: "How do I get retrieved and cited?"</p>
          <p>These are different questions with different constraints.</p>
        </div>
      </div>

      <!-- Section 2: How Generative Engines Retrieve Information -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Generative Engines Retrieve Information</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-system-truth">
            <p>
              Generative engines do not retrieve pages. They retrieve segments. The retrieval process operates in five steps: query interpretation, candidate document selection, segment extraction, segment scoring, and surfacing or citation.
            </p>
          </div>
          <p>When a user asks a question, generative engines:</p>
          
          <h3 class="heading-3">Query Interpretation</h3>
          <p>The system understands what the user is asking and identifies the intent behind the query.</p>
          
          <h3 class="heading-3">Candidate Document Selection</h3>
          <p>Pages are identified as potential sources based on relevance signals and topical alignment.</p>
          
          <h3 class="heading-3">Segment Extraction</h3>
          <p>Individual segments are pulled from candidate documents. GEO directly affects this step. If content cannot be cleanly segmented, it will not be retrieved.</p>
          
          <h3 class="heading-3">Segment Scoring</h3>
          <p>Each segment is evaluated for answer quality and citation eligibility. GEO directly affects this step. Segments that fail scoring criteria are discarded.</p>
          
          <h3 class="heading-3">Surface or Cite</h3>
          <p>One or more segments are shown to the user or cited in answers. Only segments that pass extraction and scoring are surfaced.</p>
        </div>
      </div>

      <!-- Section 3: Difference Between Ranking and Retrieval -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Difference Between Ranking and Retrieval</h2>
        </div>
        <div class="content-block__body">
          <p>Ranking determines page-level visibility in traditional search results. Retrieval determines segment-level visibility in AI-generated answers.</p>
          
          <h3 class="heading-3">Reasons a High-Ranking Page Is Ignored by Generative Engines</h3>
          <p>A high-ranking page may be ignored by generative engines if:</p>
          <ul>
            <li>Its content segments are ambiguous</li>
            <li>Segments depend on context from other sections</li>
            <li>Multiple answers are combined in one segment</li>
            <li>Pronouns and references make segments unclear</li>
          </ul>
          
          <h3 class="heading-3">What Generative Engines Prioritize Instead</h3>
          <p>Generative engines prioritize clear, atomic segments that can be cited verbatim. Page-level ranking does not guarantee segment-level retrieval.</p>
        </div>
      </div>

      <!-- Section 4: Confidence, Compression, and Citation -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Confidence, Compression, and Citation</h2>
        </div>
        <div class="content-block__body">
          <p>Generative engines evaluate segments using three primary signals:</p>
          
          <h3 class="heading-3">Confidence Scoring</h3>
          <p>Each segment receives a confidence score based on:</p>
          <ul>
            <li>Semantic alignment with the query</li>
            <li>Completeness of the answer</li>
            <li>Clarity and atomicity</li>
            <li>Absence of ambiguity</li>
          </ul>
          
          <h3 class="heading-3">Compression</h3>
          <p>Generative engines compress information to fit context windows. Segments that are too long or too short are penalized. NRLC targets segment lengths of 40-120 words for optimal retrieval probability.</p>
          
          <h3 class="heading-3">Citation Eligibility</h3>
          <p>A segment is citable if it:</p>
          <ul>
            <li>Can stand alone without context</li>
            <li>Answers exactly one question</li>
            <li>Uses explicit language, not pronouns</li>
            <li>Can be quoted verbatim without clarification</li>
          </ul>
        </div>
      </div>

      <!-- Section 5: Why Traditional SEO Fails Under GEO -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Traditional SEO Fails Under GEO</h2>
        </div>
        <div class="content-block__body">
          <div class="callout-retrieval">
            <p>
              Traditional SEO optimizes for page-level signals and user experience. GEO requires segment-level optimization for atomicity, clarity, and citation readiness. Page-level ranking does not guarantee segment-level retrieval.
            </p>
          </div>
          <p>Traditional SEO tactics that fail under GEO:</p>
          <ul>
            <li><strong>Keyword density:</strong> GEO requires semantic alignment, not keyword matching</li>
            <li><strong>Page-level optimization:</strong> GEO requires segment-level optimization</li>
            <li><strong>User experience signals:</strong> GEO requires citation-ready structure</li>
            <li><strong>Authority without clarity:</strong> Authority signals are necessary but not sufficient. GEO requires content clarity and atomicity to determine segment eligibility. Backlink accumulation alone does not guarantee retrieval if segments are ambiguous.</li>
          </ul>
          <p>This does not mean traditional SEO is obsolete. It means GEO operates at a different layer with different constraints.</p>
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">See common failure patterns →</a></p>
        </div>
      </div>

      <!-- Section 6: Observable Failure Patterns -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observable Failure Patterns</h2>
        </div>
        <div class="content-block__body">
          <p>Content disappears from AI-generated answers when:</p>
          <ul>
            <li><strong>Canonical drift:</strong> Multiple URLs serve the same content, causing confusion</li>
            <li><strong>Schema noise:</strong> Conflicting or excessive structured data reduces confidence</li>
            <li><strong>Faceted navigation:</strong> Dynamic URLs create duplicate content signals</li>
            <li><strong>AI content collapse:</strong> Content generated by AI without human verification loses trust</li>
            <li><strong>Conflicting entities:</strong> Multiple entity definitions for the same concept</li>
          </ul>
          <p>Each failure pattern has observable mechanics and mitigation strategies.</p>
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Explore all failure modes →</a></p>
        </div>
      </div>

      <!-- Section 7: How NRLC Engineers for GEO -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How NRLC Engineers for GEO</h2>
        </div>
        <div class="content-block__body">
          <p>GEO operates on decision traces. Each retrieval, citation, or suppression decision creates a trace. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> document how AI systems learn what to trust through observable judgments.</p>
          
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/extractability/') ?>">Extractability</a> explains whether a system can reliably isolate and reuse a segment during inference.</p>
          
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/inference-context-stability/') ?>">Inference Context Stability</a> explains whether a system infers the same meaning from a segment across different contexts.</p>
          
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/') ?>">Confidence Band Filtering</a> explains whether a segment clears the confidence threshold required for reuse.</p>
          
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/compression-integrity/') ?>">Compression Integrity</a> explains whether meaning survives when the system compresses content for reuse.</p>
          
          <p>NRLC applies GEO principles across three layers:</p>
          
          <h3 class="heading-3">Layer 1: Content Chunking</h3>
          <p>Structuring content for presentation and readability. Helps users and AI scan content.</p>
          <p><a href="<?= absolute_url('/en-us/insights/content-chunking-seo/') ?>">Learn about content chunking →</a></p>
          
          <h3 class="heading-3">Layer 2: Prechunking</h3>
          <p>Structuring content before writing for extraction and retrieval. Ensures segments are atomic and citable.</p>
          <p><a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">Learn about prechunking →</a></p>
          
          <h3 class="heading-3">Layer 3: Retrieval Optimization</h3>
          <p>Optimizing segments for confidence scoring and citation eligibility. Determines what gets seen in AI Overviews.</p>
          <p><a href="<?= absolute_url('/en-us/insights/ai-retrieval-llm-citation/') ?>">Learn about retrieval →</a></p>
          
          <p><strong>Summary:</strong> Chunking helps users and AI scan. Prechunking helps systems extract. Retrieval optimization determines visibility and citation.</p>
        </div>
      </div>

      <!-- Navigation to GEO Sections -->
      <div class="content-block module" style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: var(--color-background-alt, #f5f5f5);">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Explore GEO System</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-md);">
            <div>
              <h3 class="heading-3">Failure Modes</h3>
              <ul>
                <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes Index</a></li>
                <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/canonical-drift/') ?>">Canonical Drift</a></li>
              </ul>
              <p><small>Additional failure modes and fundamentals pages coming soon.</small></p>
            </div>
            <div>
              <h3 class="heading-3">Related Content</h3>
              <ul>
                <li><a href="<?= absolute_url('/en-us/insights/content-chunking-seo/') ?>">Content Chunking</a></li>
                <li><a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">Prechunking</a></li>
                <li><a href="<?= absolute_url('/en-us/insights/ai-retrieval-llm-citation/') ?>">AI Retrieval & Citation</a></li>
              </ul>
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

