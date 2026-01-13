<?php
// Confidence Band Filtering in Generative Search
// Canonical reference page - establishes confidence band filtering as foundational GEO concept

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/');

$GLOBALS['__jsonld'] = [
  // About / Entity Graph
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
          'url' => absolute_url('/assets/images/nrlc-logo.png')
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
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
        'item' => absolute_url('/en-us/generative-engine-optimization/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Confidence Band Filtering',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Confidence Band Filtering in Generative Search',
    'name' => 'Confidence Band Filtering in Generative Search',
    'description' => 'Confidence band filtering describes how generative systems exclude content that falls below an internal confidence threshold for reuse, creating a gate between retrieval and citation.',
    'url' => $canonicalUrl,
    'author' => [
      '@type' => 'Person',
      'name' => 'Joel D. Maldonado',
      'url' => absolute_url('/')
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonicalUrl
    ],
    'about' => [
      '@type' => 'DefinedTerm',
      'name' => 'Confidence Band Filtering',
      'description' => 'How generative systems exclude content that falls below an internal confidence threshold for reuse at inference time.'
    ],
    'mentions' => [
      [
        '@type' => 'DefinedTerm',
        'name' => 'Extractability',
        'description' => 'The degree to which content can be isolated and reused by a generative system without semantic loss or ambiguity.'
      ],
      [
        '@type' => 'DefinedTerm',
        'name' => 'Inference Context Stability',
        'description' => 'Whether a generative system infers the same meaning from a content segment across different prompts, queries, and retrieval contexts.'
      ],
      [
        '@type' => 'DefinedTerm',
        'name' => 'Decision Traces',
        'description' => 'The observable patterns by which generative systems repeatedly decide what information to retrieve, cite, or suppress.'
      ]
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Confidence Band Filtering in Generative Search</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">The gate between retrieval and citation</p>
        </div>
      </div>

      <!-- Opening Section -->
      <div class="content-block module">
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Confidence band filtering describes how generative systems exclude content that falls below an internal confidence threshold for reuse. This filtering happens at inference time. It is not ranking. It is a gate that determines whether a segment is safe enough to cite or incorporate into an answer.</p>
          </div>
          
          <p>A segment can be indexed, extractable, and even retrieved, yet still be excluded because the system cannot maintain sufficient confidence in its meaning, provenance, or fit for the query.</p>
        </div>
      </div>

      <!-- Section 1: What Confidence Band Filtering Is -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Confidence Band Filtering Is</h2>
        </div>
        <div class="content-block__body">
          <p>Generative systems reuse information under uncertainty. To manage error risk, they apply internal thresholds that determine which segments are eligible for reuse.</p>
          
          <p>A confidence band is the range in which a segment is considered safe to reuse. When a segment falls below that range, the system filters it out even if it appears relevant.</p>
          
          <p>This creates a discontinuity. You do not slide down in visibility. You disappear.</p>
        </div>
      </div>

      <!-- Section 2: Why Confidence Bands Exist -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Confidence Bands Exist</h2>
        </div>
        <div class="content-block__body">
          <p>Generative answers carry reputational risk for the system. Wrong reuse is more costly than omission.</p>
          
          <p>Confidence bands reduce error by preferring segments that are consistent, unambiguous, and repeatedly supported by other signals.</p>
          
          <p>This is why authority alone does not guarantee citation. If the system cannot justify reuse with confidence, it opts out.</p>
        </div>
      </div>

      <!-- Section 3: Confidence Band Filtering vs Ranking -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Confidence Band Filtering vs Ranking</h2>
        </div>
        <div class="content-block__body">
          <p>Ranking is about ordering results. Confidence band filtering is about eligibility for reuse.</p>
          
          <p>Traditional SEO assumes a graded landscape. Confidence bands create a threshold landscape.</p>
          
          <p>You can be high ranking and still never be cited. You can be cited without being top ranked.</p>
          
          <p>If you treat citation as an extension of ranking, you will misdiagnose the system.</p>
          
          <p>Even segments that clear the confidence band can be excluded if meaning degrades under <a href="<?= absolute_url('/en-us/generative-engine-optimization/compression-integrity/') ?>">compression integrity</a> failure.</p>
        </div>
      </div>

      <!-- Section 4: What Pushes a Segment Below the Band -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Pushes a Segment Below the Band</h2>
        </div>
        <div class="content-block__body">
          <p>A segment drops below the confidence band when the system cannot reliably preserve meaning under inference.</p>
          
          <p>Common causes include:</p>
          <ul>
            <li>Ambiguous wording</li>
            <li>Implicit scope</li>
            <li>Overloaded terminology</li>
            <li>Contradictory adjacent context</li>
            <li>Unstable paraphrase behavior</li>
            <li>Weak support or corroboration in nearby sources</li>
          </ul>
        </div>
      </div>

      <!-- Section 5: Observable Signs of Confidence Band Filtering -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observable Signs of Confidence Band Filtering</h2>
        </div>
        <div class="content-block__body">
          <p>These patterns show up repeatedly:</p>
          <ul>
            <li>Pages that rank but never get cited</li>
            <li>Content that appears in retrieval but not in outputs</li>
            <li>Visibility that collapses after minor edits</li>
            <li>Inconsistent or partial citation where key claims are omitted</li>
            <li>Systems that paraphrase around your idea instead of quoting or citing it</li>
          </ul>
        </div>
      </div>

      <!-- Section 6: How to Audit for Confidence Band Filtering -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How to Audit for Confidence Band Filtering</h2>
        </div>
        <div class="content-block__body">
          <p>Audit behavior, not tools.</p>
          <ul>
            <li>Isolate a single claim and test whether it survives paraphrase without meaning shift</li>
            <li>Tighten scope and remove qualifiers, then re-test</li>
            <li>Separate the claim from narrative and surrounding mixed topics</li>
            <li>Compare whether the system cites alternative sources for the same claim</li>
          </ul>
          
          <p>If your claim is relevant but repeatedly excluded, you are likely below the confidence band.</p>
        </div>
      </div>

      <!-- Section 7: Confidence Bands and Decision Tracing -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Confidence Bands and Decision Tracing</h2>
        </div>
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision tracing</a> captures repeated inclusion and exclusion.</p>
          
          <p>Confidence band filtering explains why exclusions persist. Once a segment is repeatedly filtered out, it forms a negative pattern. Over time, the system stops considering it as eligible evidence.</p>
          
          <p>This creates long-lived suppression that does not respond to traditional SEO fixes.</p>
        </div>
      </div>

      <!-- Section 8: Practical Heuristics -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Practical Heuristics</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>Write single-claim segments with explicit scope</li>
            <li>Define terms before using them as load-bearing concepts</li>
            <li>Avoid mixing multiple mechanisms in one paragraph</li>
            <li>Remove language that forces conditional interpretation</li>
            <li>Separate examples from rules</li>
          </ul>
          
          <p>These changes increase the system's ability to justify reuse.</p>
        </div>
      </div>

      <!-- Section 9: Why This Matters -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why This Matters</h2>
        </div>
        <div class="content-block__body">
          <p>Generative systems do not cite what is merely relevant. They cite what they can reuse with confidence.</p>
          
          <p>If you are below the confidence band, you can do everything "right" in traditional SEO and still fail to appear in generative outputs.</p>
          
          <p>Confidence band filtering is the gate between retrieval and citation.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module" style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: var(--color-background-alt, #f5f5f5);">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/extractability/') ?>">Extractability in Generative Search</a> - Whether content can be isolated and reused</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/inference-context-stability/') ?>">Inference Context Stability in Generative Search</a> - Whether systems infer the same meaning every time</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision Traces in Generative Search</a> - How systems repeatedly choose or suppress content</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> - Observable failure patterns</li>
            <li><a href="<?= absolute_url('/en-us/glossary/confidence-band-filtering/') ?>">Confidence Band Filtering (Glossary)</a> - Definition and key characteristics</li>
          </ul>
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

