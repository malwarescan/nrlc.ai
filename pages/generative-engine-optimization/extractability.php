<?php
// Extractability in Generative Search
// Canonical reference page - establishes extractability as foundational GEO concept

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/generative-engine-optimization/extractability/');

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
        'name' => 'Extractability',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Extractability in Generative Search',
    'name' => 'Extractability in Generative Search',
    'description' => 'Extractability is the degree to which content can be isolated, compressed, and reused by generative systems without semantic loss, enabling retrieval and citation in AI search.',
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
      'name' => 'Extractability',
      'description' => 'The degree to which a piece of content can be interpreted, isolated, compressed, and reused by a generative retrieval system without semantic loss, contradiction, or ambiguity.'
    ],
    'mentions' => [
      [
        '@type' => 'DefinedTerm',
        'name' => 'Content Chunking',
        'description' => 'The act of dividing content into smaller pieces for presentation and readability.'
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
          <h1 class="content-block__title heading-1">Extractability in Generative Search</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">The foundation of generative visibility</p>
        </div>
      </div>

      <!-- Opening Section -->
      <div class="content-block module">
        <div class="content-block__body">
          <div class="callout-definition">
            <strong>Definition:</strong>
            <p>Extractability is the degree to which a piece of content can be interpreted, isolated, compressed, and reused by a generative retrieval system without semantic loss, contradiction, or ambiguity.</p>
          </div>
          
          <p>In generative search systems, visibility is not determined by page ranking. It is determined by whether specific content segments can be reliably reused during inference. If a system cannot extract a segment with confidence, that segment is excluded regardless of authority, backlinks, or traditional SEO signals.</p>
          
          <p>Extractability is not about readability for humans. It is about interpretability for models.</p>
        </div>
      </div>

      <!-- Section 1: What Extractability Is -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Extractability Is</h2>
        </div>
        <div class="content-block__body">
          <p>Generative systems do not operate on pages as atomic units. They parse content into semantic segments, transform those segments into internal representations, and select only the segments they can safely reuse when constructing an answer.</p>
          
          <p>A segment is extractable when it can stand on its own as a complete and unambiguous assertion. It must survive isolation, compression, and reuse without relying on surrounding narrative or implied context.</p>
          
          <p>If a segment cannot be cleanly extracted, it cannot be cited.</p>
        </div>
      </div>

      <!-- Section 2: Why Extractability Matters -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Extractability Matters</h2>
        </div>
        <div class="content-block__body">
          <p>Traditional search works because linear documents can be crawled, indexed, and ranked as wholes. Generative systems work differently.</p>
          
          <p>They break content into semantic units. They compress those units into representations suitable for inference. They reuse only the units that preserve meaning under compression.</p>
          
          <p>If a unit cannot be isolated without losing meaning, it is rejected at inference time.</p>
          
          <p>This explains visibility failures that traditional SEO cannot account for:</p>
          <ul>
            <li>Pages with strong authority but narrative-heavy content are ignored</li>
            <li>Content that depends on surrounding explanation never appears</li>
            <li>Structural fixes do not change outcomes because the underlying segments remain unusable</li>
          </ul>
          
          <p>Extractability is the first gating condition for generative visibility. Extractable content can still fail when compressed representations lose semantic fidelity through <a href="<?= absolute_url('/en-us/generative-engine-optimization/compression-integrity/') ?>">compression integrity</a> failure.</p>
        </div>
      </div>

      <!-- Section 3: Extractability vs Content Chunking -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Extractability vs Content Chunking</h2>
        </div>
        <div class="content-block__body">
          <p>Content chunking is the act of dividing content into smaller pieces. Extractability is the quality of those pieces.</p>
          
          <p>Chunking is the method. Extractability is the outcome.</p>
          
          <p>Content can be properly chunked and still fail if each chunk requires external context, combines multiple assertions, or embeds ambiguity. Chunking without extractability produces segments that exist structurally but cannot be reused inferentially.</p>
        </div>
      </div>

      <!-- Section 4: How Generative Systems Use Extractable Content -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How Generative Systems Use Extractable Content</h2>
        </div>
        <div class="content-block__body">
          <p>Generative systems operate within bounded context windows. They can only attend to a limited set of tokens at once.</p>
          
          <p>Extractable segments must therefore:</p>
          <ul>
            <li>Remain meaningful when isolated</li>
            <li>Fit within inference constraints</li>
            <li>Preserve intent under compression</li>
          </ul>
          
          <p>Segments that require adjacent explanation, prior narrative, or conditional interpretation cannot be reliably included in reasoning. The system excludes them to avoid error.</p>
        </div>
      </div>

      <!-- Section 5: Signs of Poor Extractability -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Signs of Poor Extractability</h2>
        </div>
        <div class="content-block__body">
          <p>When extractability fails, the same patterns appear consistently:</p>
          <ul>
            <li>A claim never surfaces regardless of query phrasing</li>
            <li>Paraphrasing does not improve visibility</li>
            <li>Headings, metadata, and schema changes have no effect</li>
            <li>Embedding similarity is unstable under minor rewrites</li>
          </ul>
          
          <p>These are not ranking artifacts. They are extraction failures.</p>
        </div>
      </div>

      <!-- Section 6: Common Extractability Failure Modes -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Common Extractability Failure Modes</h2>
        </div>
        <div class="content-block__body">
          
          <h3 class="heading-3">Semantic Entanglement</h3>
          <p>Multiple claims are combined into a single segment.</p>
          <p><strong>Example:</strong> "This process increases visibility and reduces load time while improving content quality."</p>
          <p>The system cannot isolate any one claim with confidence.</p>
          
          <h3 class="heading-3">Narrative Dependency</h3>
          <p>Segments depend on prior context.</p>
          <p><strong>Example:</strong> "As discussed above..."</p>
          <p>Without the surrounding narrative, the segment collapses.</p>
          
          <h3 class="heading-3">Conditional Assertions</h3>
          <p>Meaning depends on branching logic.</p>
          <p><strong>Example:</strong> "If you optimize X it usually helps, but sometimes when Y..."</p>
          <p>The ambiguity prevents stable reuse.</p>
        </div>
      </div>

      <!-- Section 7: Auditing for Extractability -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Auditing for Extractability</h2>
        </div>
        <div class="content-block__body">
          <p>Extractability can be tested directly.</p>
          
          <ul>
            <li><strong>Paraphrase the segment.</strong> If simplification changes meaning, the segment is not atomic.</li>
            <li><strong>Isolate the segment.</strong> If it no longer makes sense alone, it is not extractable.</li>
            <li><strong>Test embedding stability.</strong> If representations diverge under small rewrites, reuse will be inconsistent.</li>
          </ul>
          
          <p>These are practical diagnostics, not theoretical exercises.</p>
        </div>
      </div>

      <!-- Section 8: Extractability and Decision Tracing -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Extractability and Decision Tracing</h2>
        </div>
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision tracing</a> explains which content a system repeatedly chooses or suppresses over time. Extractability determines whether content enters that decision process at all.</p>
          
          <p>Non-extractable content never forms part of a decision trace. It is invisible at the inference layer.</p>
          
          <p>Extractability is the entry condition. Decision tracing explains persistence.</p>
        </div>
      </div>

      <!-- Section 9: Necessary but Not Sufficient -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Necessary but Not Sufficient</h2>
        </div>
        <div class="content-block__body">
          <p>Extractability alone does not guarantee citation.</p>
          
          <p>Once a segment is extractable, the system still evaluates confidence, consistency, and competition against other segments. Even extractable content can be suppressed if it produces unstable interpretation across different contexts. <a href="<?= absolute_url('/en-us/generative-engine-optimization/inference-context-stability/') ?>">Inference context stability</a> determines whether the system infers the same meaning each time. <a href="<?= absolute_url('/en-us/generative-engine-optimization/confidence-band-filtering/') ?>">Confidence band filtering</a> determines whether the segment clears the threshold required for reuse. Decision traces determine whether extractable content continues to be selected or gradually suppressed.</p>
          
          <p>Extractability gets content considered. Confidence band filtering determines inclusion. Decision tracing determines long-term visibility.</p>
        </div>
      </div>

      <!-- Section 10: Practical Heuristics -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Practical Heuristics</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>Each segment should express one claim</li>
            <li>Avoid referential language</li>
            <li>Limit compound sentences</li>
            <li>Define entities explicitly before use</li>
            <li>Separate examples from general rules</li>
          </ul>
          
          <p>These are structural requirements, not stylistic preferences.</p>
        </div>
      </div>

      <!-- Section 11: Extractable vs Non-Extractable Example -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Extractable vs Non-Extractable Example</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Non-extractable:</strong></p>
          <p>"SEO problems persist despite fixes because AI systems don't use ranking signals the way search engines do."</p>
          
          <p><strong>Extractable:</strong></p>
          <ul>
            <li>"AI systems do not use ranking signals the way search engines do."</li>
            <li>"SEO problems persist despite fixes when ranking signals are prioritized."</li>
          </ul>
          
          <p>Each assertion can stand alone.</p>
        </div>
      </div>

      <!-- Section 12: Why This Matters -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why This Matters</h2>
        </div>
        <div class="content-block__body">
          <p>Generative search does not reward pages. It reuses assertions.</p>
          
          <p>If content cannot be extracted, nothing downstream matters. Not authority. Not optimization. Not tooling.</p>
          
          <p>Extractability is the foundation of generative visibility.</p>
        </div>
      </div>

      <!-- Related Systems -->
      <div class="content-block module" style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: var(--color-background-alt, #f5f5f5);">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Systems</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision Traces in Generative Search</a> — How systems repeatedly choose or suppress content</li>
            <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/failure-modes/') ?>">Failure Modes</a> — Observable failure patterns</li>
            <li><a href="<?= absolute_url('/en-us/insights/prechunking-content-ai-retrieval/') ?>">Prechunking</a> — Structuring content for extraction</li>
            <li><a href="<?= absolute_url('/en-us/glossary/extractability/') ?>">Extractability (Glossary)</a> — Definition and key characteristics</li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

