<?php
// Compression Integrity in Generative Search
// Canonical reference page - establishes compression integrity as foundational GEO concept

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/compression-integrity/');

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
        'name' => 'Compression Integrity',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Compression Integrity in Generative Search',
    'name' => 'Compression Integrity in Generative Search',
    'description' => 'Compression integrity describes whether content segments preserve their meaning when generative systems compress them for inference and reuse, determining semantic survivability under abstraction.',
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
      'name' => 'Compression Integrity',
      'description' => 'Whether a content segment preserves its meaning when a generative system compresses it for inference and reuse.'
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
        'name' => 'Confidence Band Filtering',
        'description' => 'How generative systems exclude content that falls below an internal confidence threshold for reuse.'
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
          <h1 class="content-block__title heading-1">Compression Integrity in Generative Search</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">Semantic survivability under abstraction</p>
        </div>
      </div>

      <!-- Opening Section -->
      <div class="content-block module">
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Compression integrity describes whether a content segment preserves its meaning when a generative system compresses it for inference and reuse.</p>
          </div>
          
          <p>Generative systems do not reuse full text. They reduce content into shorter internal representations. If meaning degrades during this reduction, the system cannot safely reuse the segment.</p>
          
          <p>Compression integrity is about semantic survivability under abstraction.</p>
        </div>
      </div>

      <!-- Section 1: What Compression Integrity Is -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Compression Integrity Is</h2>
        </div>
        <div class="content-block__body">
          <p>Generative systems operate under strict context limits.</p>
          
          <p>To reason, they compress retrieved content into condensed representations.</p>
          
          <p>Compression integrity measures whether the core meaning of a segment survives that process without distortion, omission, or contradiction.</p>
          
          <p>If the compressed form misrepresents the original claim, reuse becomes unsafe.</p>
        </div>
      </div>

      <!-- Section 2: Why Compression Integrity Matters -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Compression Integrity Matters</h2>
        </div>
        <div class="content-block__body">
          <p>Inference relies on compressed representations, not original text.</p>
          
          <p>If compression alters meaning, the system risks producing incorrect or misleading answers.</p>
          
          <p>To manage this risk, systems deprioritize segments whose meaning changes when summarized, abstracted, or paraphrased.</p>
          
          <p>This exclusion happens silently and consistently.</p>
        </div>
      </div>

      <!-- Section 3: Compression Integrity vs Confidence Band Filtering -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Compression Integrity vs Confidence Band Filtering</h2>
        </div>
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/') ?>">Confidence band filtering</a> evaluates whether a segment is trustworthy enough to reuse.</p>
          
          <p>Compression integrity evaluates whether that trust survives abstraction.</p>
          
          <p>A segment can clear the confidence band in full form but fail once compressed.</p>
          
          <p>When this happens, the system filters it out downstream.</p>
        </div>
      </div>

      <!-- Section 4: How Compression Happens in Practice -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Compression Happens in Practice</h2>
        </div>
        <div class="content-block__body">
          <p>Compression occurs when systems:</p>
          <ul>
            <li>Summarize multiple segments into a single representation</li>
            <li>Abstract examples into general rules</li>
            <li>Remove qualifiers to fit context limits</li>
            <li>Merge overlapping ideas</li>
          </ul>
          
          <p>Each step increases the risk of semantic loss.</p>
          
          <p>Segments that rely on nuance, qualifiers, or compound logic are most vulnerable.</p>
        </div>
      </div>

      <!-- Section 5: Common Causes of Compression Failure -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Causes of Compression Failure</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">Compound Claims</h3>
          <p>Multiple mechanisms combined into one statement.</p>
          <p>Compression removes one and distorts the rest.</p>
          
          <h3 class="heading-3">Implicit Constraints</h3>
          <p>Conditions implied rather than stated.</p>
          <p>Compression strips them away.</p>
          
          <h3 class="heading-3">Narrative Framing</h3>
          <p>Meaning depends on sequence or buildup.</p>
          <p>Compression removes ordering.</p>
          
          <h3 class="heading-3">Example Dependence</h3>
          <p>Claims rely on examples rather than explicit rules.</p>
          <p>Compression drops the example and collapses the meaning.</p>
        </div>
      </div>

      <!-- Section 6: Observable Signs of Broken Compression Integrity -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Observable Signs of Broken Compression Integrity</h2>
        </div>
        <div class="content-block__body">
          <p>These patterns appear repeatedly:</p>
          <ul>
            <li>Systems paraphrase your idea incorrectly</li>
            <li>Citations omit critical qualifiers</li>
            <li>Partial reuse that changes the claim</li>
            <li>Ideas appear but attribution is avoided</li>
            <li>Similar but simpler sources are cited instead</li>
          </ul>
          
          <p>These are not authority failures. They are compression failures.</p>
        </div>
      </div>

      <!-- Section 7: Auditing for Compression Integrity -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Auditing for Compression Integrity</h2>
        </div>
        <div class="content-block__body">
          <p>Test how meaning behaves under reduction.</p>
          <ul>
            <li>Summarize the segment in one sentence and compare meaning</li>
            <li>Remove qualifiers and see if the claim still holds</li>
            <li>Ask whether the segment can be safely paraphrased</li>
            <li>Compare how competing sources phrase the same idea</li>
          </ul>
          
          <p>If compression changes intent, integrity is low.</p>
        </div>
      </div>

      <!-- Section 8: Compression Integrity and Decision Tracing -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Compression Integrity and Decision Tracing</h2>
        </div>
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces</a> reflect long term reuse patterns.</p>
          
          <p>Segments that repeatedly fail under compression generate negative traces.</p>
          
          <p>Over time, the system avoids them entirely, even if they are accurate.</p>
          
          <p>Compression integrity failures harden quickly.</p>
        </div>
      </div>

      <!-- Section 9: Practical Heuristics -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Practical Heuristics</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>Write one claim per segment</li>
            <li>State constraints explicitly</li>
            <li>Separate rules from examples</li>
            <li>Avoid chaining multiple mechanisms</li>
            <li>Favor precision over nuance</li>
          </ul>
          
          <p>These increase the chance that compressed meaning remains correct.</p>
        </div>
      </div>

      <!-- Section 10: Why This Matters -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why This Matters</h2>
        </div>
        <div class="content-block__body">
          <p>Generative systems do not reuse content verbatim. They reuse compressed meaning.</p>
          
          <p>If meaning does not survive compression, the content is unusable.</p>
          
          <p>Compression integrity determines whether your ideas persist or disappear.</p>
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
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/') ?>">Confidence Band Filtering in Generative Search</a> - Whether segments clear the reuse threshold</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision Traces in Generative Search</a> - How systems repeatedly choose or suppress content</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> - Observable failure patterns</li>
            <li><a href="<?= absolute_url('/en-us/glossary/compression-integrity/') ?>">Compression Integrity (Glossary)</a> - Definition and key characteristics</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

