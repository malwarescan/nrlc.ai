<?php
declare(strict_types=1);
// Prechunking SEO Operator Training Course Hub
// Multi-page course structure for LLM ingestion and retrieval optimization

require_once __DIR__.'/../../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/docs/prechunking-seo/course/');

// Course module structure
$modules = [
  1 => [
    'id' => 'module-1',
    'title' => 'How LLMs Actually Chunk Content',
    'slug' => 'how-llms-chunk-content',
    'description' => 'Why "sections" are not real chunks. Token-based chunking, DOM boundary heuristics, sentence vs semantic chunking.',
    'key_truth' => 'LLMs do not respect paragraphs, headings, or visual sections. They chunk based on token limits, punctuation density, semantic similarity, and transformer attention patterns.',
    'practical_rule' => 'If a fact requires previous text, it is already broken.'
  ],
  2 => [
    'id' => 'module-2',
    'title' => 'Chunk Atomicity and Inference Cost',
    'slug' => 'chunk-atomicity-inference-cost',
    'description' => 'Why multi-fact chunks fail retrieval. Each chunk is a row. Each row should answer one question.',
    'key_truth' => 'If an LLM must resolve pronouns, infer scope, merge facts, or assume context, it increases CPU cost, hallucination risk, and citation avoidance.',
    'practical_rule' => 'One chunk = one assertion = one retrieval target.'
  ],
  3 => [
    'id' => 'module-3',
    'title' => 'Vectorization and Semantic Collisions',
    'slug' => 'vectorization-semantic-collisions',
    'description' => 'Why vague chunks lose embedding battles. Embeddings collapse meaning into dense vectors.',
    'key_truth' => 'If a chunk contains multiple ideas, mixed intent, or generic language, its vector becomes non-dominant. Your content exists but never wins nearest-neighbor retrieval.',
    'practical_rule' => 'Each chunk must be semantically narrow, lexically explicit, and intent-pure.'
  ],
  4 => [
    'id' => 'module-4',
    'title' => 'Data Structuring Beyond Pages',
    'slug' => 'data-structuring-beyond-pages',
    'description' => 'Prechunking is not just page layout. Structured layers: JSON-LD, lists, tables, definitions, repeated factual patterns.',
    'key_truth' => 'Structured data reduces inference depth, ambiguity, and retrieval risk. LLMs trust structured repetition more than prose.',
    'practical_rule' => 'Important facts must exist in multiple structural forms.'
  ],
  5 => [
    'id' => 'module-5',
    'title' => 'Cross-Page Consistency as Signal Amplification',
    'slug' => 'cross-page-consistency',
    'description' => 'Why single-page optimization fails. LLMs evaluate cross-source agreement, consistency across contexts, and repeated factual phrasing.',
    'key_truth' => 'LLMs evaluate cross-source agreement, consistency across contexts, and repeated factual phrasing. This is not duplication. This is data reinforcement.',
    'practical_rule' => 'Facts must repeat across pages, across sections, across formats. But never change meaning.'
  ],
  6 => [
    'id' => 'module-6',
    'title' => 'Prompt Reverse-Engineering (Safely)',
    'slug' => 'prompt-reverse-engineering',
    'description' => 'How to infer questions without prompt injection. You are not manipulating prompts. You are modeling question distributions.',
    'key_truth' => 'You are not manipulating prompts. You are modeling question distributions: primary user questions, follow-up questions, trust questions, safety constraints.',
    'practical_rule' => 'If a question can be asked, its answer must already exist as a chunk.'
  ],
  7 => [
    'id' => 'module-7',
    'title' => 'Citation Eligibility Engineering',
    'slug' => 'citation-eligibility-engineering',
    'description' => 'Why AI avoids citing most content. LLMs avoid citing content that sounds promotional, makes guarantees, lacks scope, or mixes opinion and fact.',
    'key_truth' => 'LLMs avoid citing content that sounds promotional, makes guarantees, lacks scope, or mixes opinion and fact.',
    'practical_rule' => 'Write chunks that are factual, scoped, boring, and safe. Boring content gets cited.'
  ],
  8 => [
    'id' => 'module-8',
    'title' => 'Measuring Prechunking Success',
    'slug' => 'measuring-prechunking-success',
    'description' => 'What to measure instead of rankings. Real metrics: retrieval appearance, answer reuse, citation frequency, near-verbatim reuse, cross-engine consistency.',
    'key_truth' => 'Real metrics are retrieval appearance, answer reuse, citation frequency, near-verbatim reuse, and cross-engine consistency. Traffic, impressions, and CTR are downstream effects, not controls.',
    'practical_rule' => 'Measure retrieval and citation, not traffic and impressions.'
  ],
  9 => [
    'id' => 'module-9',
    'title' => 'Failure Modes (Why Chunks Die)',
    'slug' => 'failure-modes-why-chunks-die',
    'description' => 'Why content disappears from AI answers. Common failures: pronouns, implied context, mixed services, marketing adjectives, narrative transitions.',
    'key_truth' => 'Common failures include pronouns, implied context, mixed services, marketing adjectives, and narrative transitions.',
    'practical_rule' => 'If a chunk cannot stand alone, delete it.'
  ]
];
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Course Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Prechunking Content Engineering</h1>
      </div>
      <div class="content-block__body">
        <p style="font-size: 1.125rem; margin-bottom: 1rem;"><strong>A Systems-Level Course for LLM Ingestion, Retrieval, and Citation</strong></p>
        <p>This is an operator course, not documentation.</p>
        <p>The goal is to teach how to design content that:</p>
        <ul>
          <li>chunks deterministically</li>
          <li>vectorizes cleanly</li>
          <li>minimizes cross-chunk inference cost</li>
          <li>survives retrieval without hallucination</li>
          <li>is safe to cite</li>
        </ul>
      </div>
    </div>

    <!-- Course Mental Model -->
    <div class="content-block module" style="background: #f5f5f5; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #000080;">
      <div class="content-block__header">
        <h2 class="content-block__title">Course Mental Model</h2>
      </div>
      <div class="content-block__body">
        <p><strong>LLMs ingest the web like a distributed data lake:</strong></p>
        <ul>
          <li>Pages = raw files</li>
          <li>DOM = semi-structured records</li>
          <li>Chunks = rows</li>
          <li>Embeddings = indexes</li>
          <li>Retrieval = approximate joins</li>
          <li>Context window = memory budget</li>
          <li>Citation = confidence threshold crossing</li>
        </ul>
        <p><strong>Prechunking is schema design for untrusted data sources.</strong></p>
      </div>
    </div>

    <!-- Course Modules -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Course Modules</h2>
      </div>
      <div class="content-block__body">
        <p>This course is broken into modules, each with a single learning objective. Each module is its own page for optimal LLM ingestion and retrieval.</p>
        
        <div style="display: grid; gap: 2rem; margin-top: 2rem;">
          <?php foreach ($modules as $num => $module): ?>
          <div style="border: 1px solid #ddd; border-radius: 4px; padding: 1.5rem;">
            <div style="display: flex; align-items: start; gap: 1rem;">
              <div style="flex-shrink: 0; width: 3rem; height: 3rem; background: #000080; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem;">
                <?= $num ?>
              </div>
              <div style="flex: 1;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem;">
                  <a href="/docs/prechunking-seo/course/<?= $module['slug'] ?>/" style="color: #000080; text-decoration: none;"><?= htmlspecialchars($module['title']) ?></a>
                </h3>
                <p style="margin: 0 0 0.75rem 0; color: #666;"><?= htmlspecialchars($module['description']) ?></p>
                <div style="background: #fff3cd; padding: 0.75rem; border-radius: 4px; border-left: 3px solid #ffc107; margin-bottom: 0.5rem;">
                  <p style="margin: 0; font-size: 0.875rem;"><strong>Key Truth:</strong> <?= htmlspecialchars($module['key_truth']) ?></p>
                </div>
                <div style="background: #d1ecf1; padding: 0.75rem; border-radius: 4px; border-left: 3px solid #0c5460;">
                  <p style="margin: 0; font-size: 0.875rem;"><strong>Practical Rule:</strong> <?= htmlspecialchars($module['practical_rule']) ?></p>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Why Multi-Page -->
    <div class="content-block module" style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px;">
      <div class="content-block__header">
        <h2 class="content-block__title">Why This Cannot Be One Page</h2>
      </div>
      <div class="content-block__body">
        <p><strong>From an LLM ingestion and retrieval perspective:</strong></p>
        <ul>
          <li>One page = mixed schema</li>
          <li>Mixed schema = higher inference cost</li>
          <li>Higher inference cost = lower retrieval probability</li>
          <li>Lower retrieval probability = zero citation</li>
        </ul>
        <p style="margin-top: 1rem;"><strong>Your own doctrine proves this must be multi-page.</strong></p>
        <p>Each module is a well-bounded, task-aligned unit with predictable structure and low inference cost.</p>
      </div>
    </div>

    <!-- Related Documentation -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Documentation</h2>
      </div>
      <div class="content-block__body">
        <p>For reference documentation and specifications:</p>
        <ul>
          <li><a href="/docs/prechunking-seo/">Prechunking SEO</a> - Discipline definition and doctrine</li>
          <li><a href="/docs/prechunking-seo/core-concepts/">Core Concepts</a> - Data shaping, croutons, precogs</li>
          <li><a href="/docs/prechunking-seo/croutons/">Crouton Specification</a> - Atomic fact structures</li>
          <li><a href="/docs/prechunking-seo/precogs/">Precog Modeling</a> - Intent forecasting</li>
          <li><a href="/docs/prechunking-seo/workflow/">Prechunking Workflow</a> - Implementation process</li>
        </ul>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema
if (!isset($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

require_once __DIR__.'/../../../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;

// Course schema (PRIMARY ENTITY)
// Use production URL for @id regardless of environment
$courseId = 'https://nrlc.ai/en-us/docs/prechunking-seo/course/#course';
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Course',
  '@id' => $courseId,
  'name' => 'Prechunking SEO: Structuring Content for AI Retrieval',
  'description' => 'A technical course explaining how large language models chunk, vectorize, and retrieve web content, and how to structure data for optimal AI and search ingestion.',
  'provider' => [
    '@type' => 'Organization',
    '@id' => 'https://nrlc.ai#organization',
    'name' => 'Neural Command',
    'url' => 'https://nrlc.ai'
  ],
  'educationalLevel' => 'Advanced',
  'teaches' => [
    'LLM chunking behavior',
    'Vectorization constraints',
    'AI retrievability',
    'Data structuring for search and LLMs'
  ],
  'inLanguage' => 'en-US',
  'url' => 'https://nrlc.ai/en-us/docs/prechunking-seo/course/'
];

// LearningResource schema (SECONDARY, CRITICAL FOR AI)
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'LearningResource',
  '@id' => 'https://nrlc.ai/en-us/docs/prechunking-seo/course/#learning-resource',
  'name' => 'Prechunking SEO Course Documentation',
  'learningResourceType' => 'Course',
  'educationalUse' => 'Professional development',
  'audience' => [
    '@type' => 'Audience',
    'audienceType' => 'SEO engineers, data engineers, AI practitioners'
  ],
  'about' => [
    'Search engine indexing',
    'Large language model ingestion',
    'Vector databases',
    'Content chunking strategies'
  ]
];

// WebPage schema
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'url' => SchemaFixes::ensureHttps($canonicalUrl),
  'name' => 'Prechunking Content Engineering Course',
  'description' => 'A systems-level course for LLM ingestion, retrieval, and citation. Multi-page course structure optimized for AI ingestion.',
  'isPartOf' => [
    '@id' => SchemaFixes::ensureHttps(absolute_url('/docs/prechunking-seo/')) . '#collection'
  ],
  'breadcrumb' => [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Docs',
        'item' => SchemaFixes::ensureHttps(absolute_url('/docs/'))
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Prechunking SEO',
        'item' => SchemaFixes::ensureHttps(absolute_url('/docs/prechunking-seo/'))
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Course',
        'item' => SchemaFixes::ensureHttps($canonicalUrl)
      ]
    ]
  ]
];
?>

