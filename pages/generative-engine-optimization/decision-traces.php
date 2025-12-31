<?php
// Decision Traces in Generative Search
// Foundational definition page - establishes NRLC as decision-trace authority

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/decision-traces/');

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
          'url' => absolute_url('/logo.png')
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
        'name' => 'Decision Traces in Generative Search',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Decision Traces in Generative Search: How AI Systems Learn What to Trust',
    'name' => 'Decision Traces in Generative Search',
    'description' => 'Decision traces explain how generative AI systems decide what to retrieve, cite, or ignore. Learn how search decisions, confidence, and context graphs shape AI visibility.',
    'url' => $canonicalUrl,
    'author' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d'),
    'about' => [
      '@type' => 'DefinedTerm',
      'name' => 'Decision Traces in Generative Search',
      'description' => 'The observable record of how generative AI systems decide what content to retrieve, cite, or suppress based on confidence, context, and constraints.'
    ],
    'mentions' => [
      [
        '@type' => 'DefinedTerm',
        'name' => 'Generative Engine Optimization',
        'description' => 'The practice of structuring content for retrieval and citation by generative AI systems.'
      ],
      [
        '@type' => 'DefinedTerm',
        'name' => 'AI Search Diagnostics',
        'description' => 'Symptom-first troubleshooting for AI search visibility issues.'
      ],
      [
        '@type' => 'DefinedTerm',
        'name' => 'Failure Modes',
        'description' => 'Observable failure patterns that cause content to disappear from AI-generated answers.'
      ],
      [
        '@type' => 'DefinedTerm',
        'name' => 'Context Graphs',
        'description' => 'Emergent knowledge structures formed by accumulated decision traces across multiple retrieval events.'
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
          <h1 class="content-block__title heading-1">Decision Traces in Generative Search</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">How AI systems learn what to trust through observable retrieval, citation, and suppression decisions</p>
        </div>
      </div>

      <!-- What a Decision Trace Is (and Is Not) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What a Decision Trace Is (and Is Not)</h2>
        </div>
        <div class="content-block__body">
          <p>A decision trace is the observable record of a generative AI system's judgment about content. When an AI system retrieves, cites, or suppresses a content segment, that action creates a trace.</p>
          
          <p>Decision traces are not logs. Logs record events. Traces record judgments.</p>
          
          <p>Decision traces are not rankings. Rankings are static positions. Traces are dynamic confidence assessments that change with context.</p>
          
          <p>Decision traces are not metrics. Metrics aggregate data. Traces preserve the specific conditions under which a decision was made.</p>
          
          <p>Each trace contains three elements:</p>
          <ul>
            <li><strong>The content segment:</strong> What was evaluated</li>
            <li><strong>The decision:</strong> Retrieve, cite, or suppress</li>
            <li><strong>The confidence level:</strong> How certain the system was</li>
          </ul>
        </div>
      </div>

      <!-- Why Generative Search Is a Decision System -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Generative Search Is a Decision System</h2>
        </div>
        <div class="content-block__body">
          <p>Generative search systems do not rank pages. Generative search systems make decisions about segments.</p>
          
          <p>Each query triggers a sequence of decisions:</p>
          <ol>
            <li>Which documents to consider</li>
            <li>Which segments to extract</li>
            <li>Which segments to score</li>
            <li>Which segments to cite</li>
            <li>Which segments to suppress</li>
          </ol>
          
          <p>These decisions are not deterministic. The same query can produce different decisions based on:</p>
          <ul>
            <li>Available context</li>
            <li>Confidence thresholds</li>
            <li>Compression constraints</li>
            <li>Citation eligibility rules</li>
          </ul>
          
          <p>Because decisions vary, traces accumulate. Each trace becomes evidence for future decisions.</p>
        </div>
      </div>

      <!-- How Retrieval, Citation, and Suppression Encode Judgment -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Retrieval, Citation, and Suppression Encode Judgment</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">Retrieval Decisions</h3>
          <p>When a system retrieves a segment, the trace records that the segment met confidence thresholds. Retrieval means the system judged the segment relevant and trustworthy enough to consider.</p>
          
          <h3 class="heading-3">Citation Decisions</h3>
          <p>When a system cites a segment, the trace records that the segment was judged authoritative enough to attribute. Citation means the system judged the segment suitable for verbatim use or attribution.</p>
          
          <h3 class="heading-3">Suppression Decisions</h3>
          <p>When a system suppresses a segment, the trace records that the segment failed confidence or relevance thresholds. Suppression means the system judged the segment unsuitable for the current context.</p>
          
          <p>Each decision type creates a different trace. Retrieval traces indicate consideration. Citation traces indicate authority. Suppression traces indicate rejection.</p>
          
          <p>These traces accumulate into patterns. Patterns become signals. Signals inform future decisions.</p>
        </div>
      </div>

      <!-- Decision Traces vs Logs, Rankings, and Metrics -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Decision Traces vs Logs, Rankings, and Metrics</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">Decision Traces vs Logs</h3>
          <p>Logs record what happened. Traces record why it happened.</p>
          <p>A log entry might state: "Segment retrieved at 14:32:15."</p>
          <p>A trace entry states: "Segment retrieved because confidence exceeded 0.85 and relevance matched query intent."</p>
          
          <h3 class="heading-3">Decision Traces vs Rankings</h3>
          <p>Rankings are static positions. Traces are dynamic assessments.</p>
          <p>A ranking states: "Page 1, Position 3."</p>
          <p>A trace states: "Segment retrieved with high confidence in context A, suppressed in context B."</p>
          
          <h3 class="heading-3">Decision Traces vs Metrics</h3>
          <p>Metrics aggregate data. Traces preserve context.</p>
          <p>A metric states: "Average citation rate: 12%."</p>
          <p>A trace states: "Segment cited when query matched intent X, confidence Y, and compression allowed Z tokens."</p>
          
          <p>Traces preserve the conditions that produced decisions. This preservation enables pattern recognition and context graph formation.</p>
        </div>
      </div>

      <!-- How Decision Traces Accumulate Into Context Graphs -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Decision Traces Accumulate Into Context Graphs</h2>
        </div>
        <div class="content-block__body">
          <p>Context graphs are emergent knowledge structures. Context graphs form when decision traces accumulate across multiple retrieval events.</p>
          
          <p>Each trace connects:</p>
          <ul>
            <li>A content segment</li>
            <li>A decision outcome</li>
            <li>The conditions that produced the decision</li>
          </ul>
          
          <p>When traces share conditions, patterns emerge. Patterns create edges between segments. Edges form graphs.</p>
          
          <p>For example, if multiple traces show that Segment A is retrieved when Query Type X appears, and Segment B is retrieved when Query Type Y appears, the graph records that A and B are contextually distinct.</p>
          
          <p>If traces show that Segment A is consistently cited alongside Segment C, the graph records that A and C are contextually related.</p>
          
          <p>Context graphs are not built explicitly. Context graphs emerge from trace accumulation. The graph structure reflects the decision patterns that produced the traces.</p>
          
          <p>This emergence means context graphs are dynamic. As new traces accumulate, graph structures update. As graph structures update, future decisions reference updated context.</p>
        </div>
      </div>

      <!-- How NRLC Observes and Records Decision Traces -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How NRLC Observes and Records Decision Traces</h2>
        </div>
        <div class="content-block__body">
          <p>NRLC's existing systems generate decision-trace observations. These systems document how generative AI systems make retrieval, citation, and suppression decisions.</p>
          
          <h3 class="heading-3">Failure Modes as Negative Decision Traces</h3>
          <p>NRLC's <a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes catalog</a> captures negative decision traces. Each failure mode documents a pattern where confidence drops below retrieval thresholds.</p>
          <p>For example, canonical drift represents a negative trace where conflicting canonical signals cause confidence to drop. The failure mode documents the conditions that produce this negative trace.</p>
          
          <h3 class="heading-3">Diagnostics as Symptom-to-Trace Mapping</h3>
          <p>NRLC's <a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> pages map symptoms to decision traces. When a site is not showing in AI results, the diagnostic explains which decision traces produced that outcome.</p>
          <p>Each diagnostic connects observable symptoms to underlying decision patterns. This connection reveals the traces that produced the symptoms.</p>
          
          <h3 class="heading-3">Field Notes as Trace Observations</h3>
          <p>NRLC's <a href="<?= absolute_url('/en-us/field-notes/') ?>">Field Notes</a> record observed decision traces. Field notes document specific instances where retrieval, citation, or suppression decisions occurred under known conditions.</p>
          <p>These observations accumulate into evidence of decision patterns. Patterns inform understanding of how context graphs form.</p>
          
          <p>Together, these systems create a decision-trace corpus. The corpus documents how generative AI systems make judgments about content. The corpus enables pattern recognition and context graph understanding.</p>
        </div>
      </div>

      <!-- Implications for SEO, GEO, and AI Visibility -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Implications for SEO, GEO, and AI Visibility</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">Traditional SEO Operates on Rankings</h3>
          <p>Traditional SEO optimizes for static rankings. Rankings are positions. Positions are not decisions.</p>
          <p>When SEO focuses on rankings, SEO ignores decision traces. Ignoring traces means missing the conditions that produce retrieval, citation, and suppression.</p>
          
          <h3 class="heading-3">GEO Operates on Decision Traces</h3>
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> optimizes for decision traces. GEO structures content to produce positive traces.</p>
          <p>GEO ensures segments meet confidence thresholds. GEO ensures segments are citation-eligible. GEO ensures segments avoid suppression triggers.</p>
          <p>By optimizing for traces, GEO influences the conditions that produce decisions. This influence increases the likelihood of positive traces.</p>
          
          <h3 class="heading-3">AI Visibility Depends on Trace Accumulation</h3>
          <p>AI visibility is not a single decision. AI visibility is accumulated traces.</p>
          <p>When traces consistently show retrieval and citation, visibility increases. When traces consistently show suppression, visibility decreases.</p>
          <p>Understanding trace accumulation enables prediction of visibility outcomes. Prediction enables optimization strategies.</p>
          
          <h3 class="heading-3">Context Graphs Emerge from Traces</h3>
          <p>As traces accumulate, context graphs form. Context graphs influence future decisions.</p>
          <p>Content that produces positive traces becomes part of positive graph structures. Content that produces negative traces becomes part of negative graph structures.</p>
          <p>Graph position influences future trace outcomes. Understanding graph formation enables strategic trace optimization.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> — How to structure content for positive decision traces</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> — Negative decision trace patterns</li>
            <li><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> — Mapping symptoms to decision traces</li>
            <li><a href="<?= absolute_url('/en-us/field-notes/') ?>">Field Notes</a> — Observed decision trace instances</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

