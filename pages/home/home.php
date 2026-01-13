<?php
// Metadata is now set by the router via sudo_meta_directive_ctx()
// See bootstrap/router.php lines 64-76 for homepage metadata configuration
// Note: head.php and header.php are already included by router.php render_page()
// Do not set $GLOBALS['pageTitle'] or $GLOBALS['pageDesc'] here - they are ignored

// GUARD ALL OPTIONAL FUNCTION CALLS - Fail closed, not fatal
$canonicalUrl = '/';
$domain = '/';

if (function_exists('absolute_url')) {
  try {
    $canonicalUrl = absolute_url('/');
    $domain = absolute_url('/');
  } catch (Throwable $e) {
    // Silent fail - use defaults
  }
}

// Guard schema_builders require
if (file_exists(__DIR__ . '/../../lib/schema_builders.php')) {
  try {
    require_once __DIR__ . '/../../lib/schema_builders.php';
  } catch (Throwable $e) {
    // Silent fail - schema is optional
  }
}
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- HERO SECTION: AUTHORITY POSITIONING -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h1 class="content-block__title">Leading Agency and Research Authority for AI Search Optimization, AEO, and GEO</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-lg);">
          NRLC is a leading agency and research authority for how AI search systems select, cite, and mention businesses. We specialize in AEO and GEO systems that determine which businesses are selected, cited, and trusted by AI search engines.
        </p>
        <div style="margin-top: var(--spacing-lg);">
          <a href="/ai-optimization/" class="btn btn--secondary" title="AI search optimization systems">AI search optimization systems</a>
        </div>
      </div>
    </div>

    <!-- KNOWLEDGE BASE FRAMING SECTION -->
    <div class="content-block module" id="knowledge-base" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__body">
        <h2 class="heading-2" style="margin-top: 0;">What This Knowledge Base Contains</h2>
        <p>This site exists to explain why generative search systems behave the way they do when traditional SEO explanations stop working.</p>
        <p>Content is organized by the conditions people experience, not by categories. When something breaks, when visibility disappears, when tools disagree with outcomes, these pages document what is happening and why.</p>
        <p>This is not a blog, not a course, and not a trend. This is infrastructure documentation for the generative search era.</p>
      </div>
    </div>

    <!-- IA ENTRY SECTION: PROBLEM-FIRST NAVIGATION -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Knowledge Base Sections</h2>
      </div>
      <div class="content-block__body">
        
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-md);">
          
          <!-- Generative Engine Optimization -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">When Traditional SEO Stops Explaining Visibility</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Generative Engine Optimization: How AI systems retrieve, score, and cite content segments. Foundational mechanics, confidence scoring, and failure patterns.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a></p>
          </div>

          <!-- AI Search Diagnostics -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">When Indexed Pages Never Appear in AI Results</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">AI Search Diagnostics: Symptom-first troubleshooting for sites not showing in AI results, traffic declines, and citation failures.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a></p>
          </div>

          <!-- AI Search Measurement -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">When Rankings Stay Stable But Traffic Disappears</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Measuring Visibility in AI Search: What metrics exist, what can be measured, what is inferred, and what executives should expect.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a></p>
          </div>

          <!-- AI Search Strategy -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-strategy/') ?>">When Teams Question Whether SEO Still Matters</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Search Strategy in the Generative Era: Calm assessment of what SEO controls, what it lost, and how teams should adapt.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-strategy/') ?>">AI Search Strategy</a></p>
          </div>

          <!-- AI Search Operations -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-operations/') ?>">When Practices Stop Producing Results</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Operating SEO in an AI-Mediated Search Environment: What to stop doing, what to keep doing, and what signals generative engines ignore.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-operations/') ?>">AI Search Operations</a></p>
          </div>

          <!-- AI Search Migrations -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>">When Content Needs Restructuring for AI Retrieval</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Rebuilding Content for Generative Retrieval: Step-by-step procedural guides for restructuring, migrating, and rebuilding content for AI retrieval.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>">AI Search Migrations</a></p>
          </div>

          <!-- AI Search Risk -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-risk/') ?>">When Brand Visibility Requires Governance</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Managing Risk in AI-Mediated Search: Brand protection, governance, and institutional trust in AI-mediated search. Enterprise risk management for AI citations and visibility.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-risk/') ?>">AI Search Risk</a></p>
          </div>

          <!-- AI Search Tools Reality -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>">When Tools Disagree With Lived Outcomes</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">The Limits of SEO Tooling in AI Search: Honest assessment of what SEO tools can and cannot see in AI-mediated search. Prevents false expectations and builds credibility.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>">AI Search Tools Reality</a></p>
          </div>

          <!-- Field Notes -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/field-notes/') ?>">When Observational Data Contributes to Understanding</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">Field Notes: Observational notes on AI search behavior. Written as "We observed X behavior across Y surfaces under Z constraints." No speculation, no predictions, no marketing.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/field-notes/') ?>">Field Notes</a></p>
          </div>

          <!-- Glossary -->
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 class="heading-3" style="margin-top: 0;"><a href="<?= absolute_url('/en-us/glossary/') ?>">When Terminology Needs Stabilization</a></h3>
            <p style="margin-bottom: var(--spacing-sm);">AI Search Glossary: Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics. Stabilizes terminology across the site and for LLMs.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/glossary/') ?>">Glossary</a></p>
          </div>

        </div>

        <style>
          @media (min-width: 768px) {
            .content-block__body > div[style*="grid-template-columns"] {
              grid-template-columns: 1fr 1fr !important;
            }
          }
        </style>

      </div>
    </div>

    <!-- AUTHORITY EXPLANATION BLOCK -->
    <div class="content-block module" id="authority-explanation" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Decide What to Cite</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems do not rank pages the way search engines do. They extract entities, relationships, and evidence. When an AI system needs to answer a question, it evaluates which sources provide clear, structured, and trustworthy information that can be safely summarized and cited.</p>
        <p>Traditional SEO optimizes for crawling and ranking. It measures success by position in search results and traffic volume. This approach assumes that appearing in search results is sufficient for visibility. It is not.</p>
        <p>Pages without structured authority signals are invisible to AI answers. When AI systems cannot confidently extract what your business does, how it operates, or why it should be trusted, they default to sources that provide these signals clearly.</p>
        <p>This knowledge base documents how generative search systems work, why traditional SEO explanations fail, and what actually determines AI visibility. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> explain how AI systems learn what to trust through observable retrieval, citation, and suppression judgments.</p>
        <p><strong>This is the gap between ranking and being referenced.</strong></p>
      </div>
    </div>

    <!-- COMPARISON BLOCK -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">The Difference</h2>
      </div>
      <div class="content-block__body">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-md);">
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 style="margin-top: 0;">Traditional SEO Agencies</h3>
            <ul>
              <li>Optimize pages for keywords</li>
              <li>Focus on rankings and traffic</li>
              <li>Measure success by impressions and clicks</li>
              <li>Assume AI systems behave like search engines</li>
            </ul>
          </div>
          <div style="border: 1px solid #4a90e2; padding: var(--spacing-md); border-radius: 4px; background: #f0f7ff;">
            <h3 style="margin-top: 0; color: #4a90e2;">NRLC.ai</h3>
            <ul>
              <li>Engineer entities and relationships</li>
              <li>Optimize for AI citation and reuse</li>
              <li>Measure success by AI visibility and reference frequency</li>
              <li>Design content for LLM extraction and trust scoring</li>
            </ul>
          </div>
        </div>
        <style>
          @media (min-width: 768px) {
            .content-block__body > div[style*="grid-template-columns"] {
              grid-template-columns: 1fr 1fr !important;
            }
          }
        </style>
      </div>
    </div>

    <!-- AUTHORITATIVE VOICE INSERT -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8); border-left: 3px solid #4a90e2; padding-left: var(--spacing-md);">
      <div class="content-block__header">
        <h2 class="content-block__title">Why This Knowledge Base Exists</h2>
      </div>
      <div class="content-block__body">
        <p>Modern visibility failures aren't due to "bad SEO." They happen because the web is now read by machines that require structure, evidence, and consistency - and most sites were never built for that.</p>
        <p>When Google AI Overviews or ChatGPT needs to answer a question, it doesn't rank pages. It evaluates which sources provide information that can be extracted, verified, and cited safely. If your site doesn't provide these signals clearly, AI systems won't reference you, regardless of your search rankings.</p>
        <p>This knowledge base exists to bridge that gap. It documents how generative search systems work, why traditional SEO explanations fail, and what actually determines AI visibility. For businesses that need help implementing these principles, we provide <a href="<?= absolute_url('/en-us/ai-visibility/') ?>">AI visibility optimization services</a> that improve how AI systems cite and recommend your business.</p>
      </div>
    </div>

    <!-- FAQ SECTION: AI VISIBILITY QUESTIONS -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Questions About AI Search, ChatGPT, and Brand Visibility</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt><strong>Why doesn't AI search cite my content?</strong></dt>
          <dd>AI systems like ChatGPT and Google AI Overviews do not browse the web or list pages in directories. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. Content is more likely to be cited when it is clearly defined in machine-readable formats, uses atomic segments that survive compression, and provides unambiguous entity definitions. <a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> explains specific failure patterns that cause citation suppression.</dd>
          
          <dt><strong>Why is my site indexed but not showing in AI results?</strong></dt>
          <dd>Indexing and retrieval are different processes. A page can be indexed by search engines but ignored by generative AI systems if its content segments fail confidence thresholds, lack atomic structure, or contain ambiguity that prevents safe citation. <a href="<?= absolute_url('/en-us/ai-search-diagnostics/indexed-but-not-retrieved/') ?>">Indexed but not retrieved</a> documents the specific conditions that cause this disconnect.</dd>
          
          <dt><strong>How does ChatGPT decide which brands to mention?</strong></dt>
          <dd>ChatGPT and similar systems evaluate whether information about a brand can be confidently extracted and verified across multiple sources. Brands are more likely to be mentioned when their content clearly defines who they are, what they do, and how they relate to a topic, using consistent language and structure across the web. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> explain how these judgments accumulate into patterns that influence future retrieval decisions.</dd>
          
          <dt><strong>Is ranking on Google enough to be featured in AI Overviews or ChatGPT?</strong></dt>
          <dd>No. Traditional rankings measure page relevance, while AI systems prioritize extractability and trust. A page can rank well and still be ignored by AI if its information isn't structured, explicit, and verifiable enough to be cited safely. <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> explains the mechanics of segment-level retrieval versus page-level ranking.</dd>
          
          <dt><strong>Why did my traffic drop even though rankings stayed the same?</strong></dt>
          <dd>When generative AI systems answer queries directly, they reduce the need for users to click through to source pages. This creates a disconnect between traditional ranking metrics and actual traffic. Rankings may remain stable while traffic declines because AI systems are providing answers without requiring page visits. <a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> explains what can and cannot be measured in AI-mediated search.</dd>
        </dl>
      </div>
    </div>

    <!-- IMPLEMENTATION SUPPORT: MOVED TO BOTTOM, VISUALLY SECONDARY -->
    <div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8); margin-top: var(--spacing-xl);">
      <div class="content-block__body">
        <h2 class="heading-2" style="margin-top: 0;">Implementation Support</h2>
        <p>For teams who need assistance applying the material above, Neural Command provides implementation support.</p>
        <p><a href="<?= absolute_url('/en-us/implementation/') ?>">Learn about implementation support →</a></p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// PERSON + ORGANIZATION ENTITY DECLARATION - HOMEPAGE
// GUARD ALL OPTIONAL FUNCTION CALLS - Fail closed, not fatal
// SUDO META DIRECTIVE: Entity declaration for Knowledge Graph consolidation

// Initialize defaults
$baseUrl = $canonicalUrl;
$logoUrl = $domain . '/assets/images/nrlc-logo.png';

// Guard SchemaFixes require and usage
if (file_exists(__DIR__ . '/../../lib/SchemaFixes.php')) {
  try {
    require_once __DIR__ . '/../../lib/SchemaFixes.php';
    if (class_exists('\NRLC\Schema\SchemaFixes') && function_exists('absolute_url')) {
      try {
        $baseUrl = \NRLC\Schema\SchemaFixes::ensureHttps(absolute_url('/'));
        $logoUrl = \NRLC\Schema\SchemaFixes::ensureHttps(absolute_url('/assets/images/nrlc-logo.png'));
      } catch (Throwable $e) {
        // Silent fail - use defaults
      }
    }
  } catch (Throwable $e) {
    // Silent fail - use defaults
  }
}

// Initialize JSON-LD array if not exists
if (!isset($GLOBALS['__jsonld']) || !is_array($GLOBALS['__jsonld'])) {
  $GLOBALS['__jsonld'] = [];
}

// Guard schema addition - wrap in try-catch
try {
  $GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Person',
        '@id' => $baseUrl . '#joel-maldonado',
        'name' => 'Joel Maldonado',
        'jobTitle' => 'Founder',
        'description' => 'Joel Maldonado is the founder of Neural Command, LLC, where he builds systems that convert search authority into AI-readable, citation-safe knowledge for modern search engines and large language models.',
        'worksFor' => [
          '@type' => 'Organization',
          '@id' => $baseUrl . '#neural-command'
        ],
        'affiliation' => [
          '@type' => 'Organization',
          '@id' => $baseUrl . '#neural-command'
        ],
        'url' => $baseUrl,
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ],
      [
        '@type' => 'Organization',
        '@id' => $baseUrl . '#neural-command',
        'name' => 'Neural Command, LLC',
        'url' => $baseUrl,
        'logo' => [
          '@type' => 'ImageObject',
          'url' => $logoUrl
        ],
        'founder' => [
          '@type' => 'Person',
          '@id' => $baseUrl . '#joel-maldonado'
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ],
      [
        '@type' => 'WebPage',
        '@id' => $baseUrl . '#why-i-built-this-system',
        'name' => 'Why This Knowledge Base Exists',
        'about' => [
          '@type' => 'Person',
          '@id' => $baseUrl . '#joel-maldonado'
        ],
        'isPartOf' => [
          '@type' => 'WebSite',
          '@id' => $baseUrl . '#website'
        ]
      ],
      [
        '@type' => 'WebSite',
        '@id' => $baseUrl . '#website',
        'url' => $baseUrl,
        'name' => 'Neural Command'
      ]
    ]
  ];
} catch (Throwable $e) {
  // Silent fail - schema is optional
}

// Also set founder for backward compatibility - GUARDED
try {
  $GLOBALS['__homepage_org_founder'] = [
    '@type' => 'Person',
    '@id' => $baseUrl . '#joel-maldonado',
    'name' => 'Joel Maldonado'
  ];
} catch (Throwable $e) {
  // Silent fail
}

// FAQ SCHEMA: AI Visibility Questions (optimized for search intent) - GUARDED
try {
  $GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
    [
      '@type' => 'Question',
      'name' => 'Why doesn\'t AI search cite my content?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'AI systems like ChatGPT and Google AI Overviews do not browse the web or list pages in directories. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. Content is more likely to be cited when it is clearly defined in machine-readable formats, uses atomic segments that survive compression, and provides unambiguous entity definitions.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Why is my site indexed but not showing in AI results?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Indexing and retrieval are different processes. A page can be indexed by search engines but ignored by generative AI systems if its content segments fail confidence thresholds, lack atomic structure, or contain ambiguity that prevents safe citation.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'How does ChatGPT decide which brands to mention?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'ChatGPT and similar systems evaluate whether information about a brand can be confidently extracted and verified across multiple sources. Brands are more likely to be mentioned when their content clearly defines who they are, what they do, and how they relate to a topic, using consistent language and structure across the web.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Is ranking on Google enough to be featured in AI Overviews or ChatGPT?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'No. Traditional rankings measure page relevance, while AI systems prioritize extractability and trust. A page can rank well and still be ignored by AI if its information isn\'t structured, explicit, and verifiable enough to be cited safely.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Why did my traffic drop even though rankings stayed the same?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'When generative AI systems answer queries directly, they reduce the need for users to click through to source pages. This creates a disconnect between traditional ranking metrics and actual traffic. Rankings may remain stable while traffic declines because AI systems are providing answers without requiring page visits.'
      ]
    ]
    ]
  ];
} catch (Throwable $e) {
  // Silent fail - FAQ schema is optional
}
?>
