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

<main role="main" class="container" itemscope itemtype="https://schema.org/WebPage">
<article itemscope itemtype="https://schema.org/Article" class="section">
  <div class="section__content">

    <!-- HERO SECTION: RESEARCH & IMPLEMENTATION AUTHORITY -->
    <header class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h1 class="content-block__title" itemprop="headline">Joel Maldonado: <abbr title="Search Engine Optimization">SEO</abbr>, <dfn><abbr title="Answer Engine Optimization">AEO</abbr></dfn>, and <dfn><abbr title="Generative Engine Optimization">GEO</abbr></dfn> Research & Implementation</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-lg);" itemprop="description">
          Research and implementation at the bleeding edge of <strong>AI search</strong>, <strong>retrieval</strong>, <strong>citations</strong>, and <strong>extractability</strong>. Defining the <abbr title="Search Engine Optimization">SEO</abbr>, <dfn><abbr title="Answer Engine Optimization">AEO</abbr></dfn>, and <dfn><abbr title="Generative Engine Optimization">GEO</abbr></dfn> practices that determine how AI systems select and cite businesses.
        </p>
        <div class="btn-group" style="margin-top: var(--spacing-lg);">
          <a href="<?= absolute_url('/ai-optimization/') ?>" class="btn btn--primary" title="AI search optimization systems">AI Search Optimization Systems</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary" title="Book consultation">Book Consultation</a>
        </div>
      </div>
    </header>

    <!-- TECHNICAL DEFINITIONS SECTION: CRITICAL FOR AI EXTRACTABILITY -->
    <section class="content-block module" id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Terminology: <abbr title="Answer Engine Optimization">AEO</abbr>, <abbr title="Generative Engine Optimization">GEO</abbr>, and AI Search Optimization</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt id="aeo" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><abbr title="Answer Engine Optimization">AEO</abbr></dfn> <span itemprop="name">(Answer Engine Optimization)</span>
          </dt>
          <dd itemprop="description">
            The practice of optimizing content for AI answer engines (<strong>ChatGPT</strong>, <strong>Google AI Overviews</strong>, <strong>Claude</strong>, <strong>Perplexity</strong>) that generate direct answers without requiring users to click through to source pages. AEO focuses on <strong>entity clarity</strong>, <strong>atomic content segments</strong>, <strong>structured data</strong>, and <strong>citation-ready formatting</strong> that enables AI systems to extract, verify, and cite information confidently. Unlike traditional <abbr title="Search Engine Optimization">SEO</abbr>, AEO optimizes for <strong>extractability</strong> and <strong>trust scoring</strong> rather than page-level ranking.
          </dd>
          
          <dt id="geo" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><abbr title="Generative Engine Optimization">GEO</abbr></dfn> <span itemprop="name">(Generative Engine Optimization)</span>
          </dt>
          <dd itemprop="description">
            The practice of optimizing content for generative AI systems that retrieve, evaluate, and cite web content. GEO encompasses <strong>retrieval signal engineering</strong>, <strong>semantic structure optimization</strong>, <strong>entity relationship mapping</strong>, and <strong>confidence threshold alignment</strong>. GEO addresses the fundamental shift from page-level ranking (traditional <abbr title="Search Engine Optimization">SEO</abbr>) to <strong>segment-level retrieval</strong> and <strong>entity-level citation</strong> in AI-mediated search environments.
          </dd>
          
          <dt id="ai-search-optimization" itemscope itemtype="https://schema.org/DefinedTerm">
            <dfn><strong>AI Search Optimization</strong></dfn> <span itemprop="name">(AI Search Optimization)</span>
          </dt>
          <dd itemprop="description">
            The comprehensive discipline that encompasses <abbr title="Answer Engine Optimization">AEO</abbr>, <abbr title="Generative Engine Optimization">GEO</abbr>, and related practices for optimizing content visibility in AI-powered search systems. AI Search Optimization addresses the gap between traditional <abbr title="Search Engine Optimization">SEO</abbr> (which optimizes for crawling and ranking) and the requirements of AI systems (which prioritize <strong>extractability</strong>, <strong>entity clarity</strong>, <strong>structured data</strong>, and <strong>citation trust</strong>). This includes <strong>schema markup engineering</strong>, <strong>entity disambiguation</strong>, <strong>atomic content architecture</strong>, and <strong>retrieval signal optimization</strong>.
          </dd>
        </dl>
      </div>
    </section>

    <!-- KNOWLEDGE BASE FRAMING SECTION -->
    <section class="content-block module" id="knowledge-base" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
      <div class="content-block__body">
        <h2 class="heading-2" style="margin-top: 0;">What This Knowledge Base Contains</h2>
        <p>This site exists to explain why <strong>generative search systems</strong> behave the way they do when traditional <abbr title="Search Engine Optimization">SEO</abbr> explanations stop working.</p>
        <p>Content is organized by the <strong>conditions people experience</strong>, not by categories. When something breaks, when visibility disappears, when tools disagree with outcomes, these pages document what is happening and why.</p>
        <p>This is not a blog, not a course, and not a trend. This is <strong>infrastructure documentation</strong> for the generative search era.</p>
      </div>
    </section>

    <!-- IA ENTRY SECTION: PROBLEM-FIRST NAVIGATION -->
    <nav aria-label="Knowledge Base Navigation" class="content-block module" itemscope itemtype="https://schema.org/ItemList" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">Knowledge Base Sections</h2>
      </div>
      <div class="content-block__body">
        
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-md);">
          
          <!-- Generative Engine Optimization -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="1">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" itemprop="item">
                <span itemprop="name">When Traditional <abbr title="Search Engine Optimization">SEO</abbr> Stops Explaining Visibility</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Generative Engine Optimization</strong>: How AI systems retrieve, score, and cite content segments. Foundational mechanics, <strong>confidence scoring</strong>, and <strong>failure patterns</strong>.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a></p>
          </div>

          <!-- AI Search Diagnostics -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="2">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>" itemprop="item">
                <span itemprop="name">When Indexed Pages Never Appear in AI Results</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>AI Search Diagnostics</strong>: Symptom-first troubleshooting for sites not showing in AI results, <strong>traffic declines</strong>, and <strong>citation failures</strong>.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a></p>
          </div>

          <!-- AI Search Measurement -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="3">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>" itemprop="item">
                <span itemprop="name">When Rankings Stay Stable But Traffic Disappears</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Measuring Visibility in AI Search</strong>: What metrics exist, what can be measured, what is inferred, and what executives should expect.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a></p>
          </div>

          <!-- AI Search Strategy -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="4">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-strategy/') ?>" itemprop="item">
                <span itemprop="name">When Teams Question Whether <abbr title="Search Engine Optimization">SEO</abbr> Still Matters</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Search Strategy in the Generative Era</strong>: Calm assessment of what <abbr title="Search Engine Optimization">SEO</abbr> controls, what it lost, and how teams should adapt.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-strategy/') ?>">AI Search Strategy</a></p>
          </div>

          <!-- AI Search Operations -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="5">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-operations/') ?>" itemprop="item">
                <span itemprop="name">When Practices Stop Producing Results</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Operating <abbr title="Search Engine Optimization">SEO</abbr> in an AI-Mediated Search Environment</strong>: What to stop doing, what to keep doing, and what signals generative engines ignore.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-operations/') ?>">AI Search Operations</a></p>
          </div>

          <!-- AI Search Migrations -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="6">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>" itemprop="item">
                <span itemprop="name">When Content Needs Restructuring for AI Retrieval</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Rebuilding Content for Generative Retrieval</strong>: Step-by-step procedural guides for restructuring, migrating, and rebuilding content for AI retrieval.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>">AI Search Migrations</a></p>
          </div>

          <!-- AI Search Risk -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="7">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-risk/') ?>" itemprop="item">
                <span itemprop="name">When Brand Visibility Requires Governance</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Managing Risk in AI-Mediated Search</strong>: Brand protection, governance, and institutional trust in AI-mediated search. Enterprise risk management for AI citations and visibility.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-risk/') ?>">AI Search Risk</a></p>
          </div>

          <!-- AI Search Tools Reality -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="8">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>" itemprop="item">
                <span itemprop="name">When Tools Disagree With Lived Outcomes</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>The Limits of <abbr title="Search Engine Optimization">SEO</abbr> Tooling in AI Search</strong>: Honest assessment of what <abbr title="Search Engine Optimization">SEO</abbr> tools can and cannot see in AI-mediated search. Prevents false expectations and builds credibility.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>">AI Search Tools Reality</a></p>
          </div>

          <!-- Field Notes -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="9">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/field-notes/') ?>" itemprop="item">
                <span itemprop="name">When Observational Data Contributes to Understanding</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>Field Notes</strong>: Observational notes on AI search behavior. Written as "We observed X behavior across Y surfaces under Z constraints." No speculation, no predictions, no marketing.</p>
            <p style="font-size: 0.9rem; color: #666;"><a href="<?= absolute_url('/en-us/field-notes/') ?>">Field Notes</a></p>
          </div>

          <!-- Glossary -->
          <div itemscope itemtype="https://schema.org/ListItem" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <meta itemprop="position" content="10">
            <h3 class="heading-3" style="margin-top: 0;">
              <a href="<?= absolute_url('/en-us/glossary/') ?>" itemprop="item">
                <span itemprop="name">When Terminology Needs Stabilization</span>
              </a>
            </h3>
            <p style="margin-bottom: var(--spacing-sm);"><strong>AI Search Glossary</strong>: Standard terminology and definitions for generative search, AI-mediated search, and retrieval mechanics. Stabilizes terminology across the site and for LLMs.</p>
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
    </nav>

    <!-- TECHNICAL AUTHORITY EXPLANATION: DEEP TECHNICAL CONTENT -->
    <section class="content-block module" id="authority-explanation" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Decide What to Cite: Retrieval, Evaluation, and Citation Mechanics</h2>
      </div>
      <div class="content-block__body">
        <p><strong>AI systems do not rank pages the way search engines do.</strong> They extract <strong>entities</strong>, <strong>relationships</strong>, and <strong>evidence</strong>. When an AI system needs to answer a question, it evaluates which sources provide <strong>clear</strong>, <strong>structured</strong>, and <strong>trustworthy</strong> information that can be safely summarized and cited.</p>
        
        <p>Traditional <abbr title="Search Engine Optimization">SEO</abbr> optimizes for <strong>crawling</strong> and <strong>ranking</strong>. It measures success by position in search results and traffic volume. This approach assumes that appearing in search results is sufficient for visibility. <strong>It is not.</strong></p>
        
        <p>Pages without <strong>structured authority signals</strong> are invisible to AI answers. When AI systems cannot confidently extract what your business does, how it operates, or why it should be trusted, they default to sources that provide these signals clearly.</p>
        
        <p>This knowledge base documents how <strong>generative search systems</strong> work, why traditional <abbr title="Search Engine Optimization">SEO</abbr> explanations fail, and what actually determines AI visibility. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> explain how AI systems learn what to trust through observable <strong>retrieval</strong>, <strong>citation</strong>, and <strong>suppression</strong> judgments.</p>
        
        <p><strong>This is the gap between ranking and being referenced.</strong></p>
      </div>
    </section>

    <!-- TECHNICAL COMPARISON: DEEP DIFFERENTIATION -->
    <section class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title">The Difference: Traditional <abbr title="Search Engine Optimization">SEO</abbr> vs. AI Search Optimization</h2>
      </div>
      <div class="content-block__body">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-md);">
          <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <h3 style="margin-top: 0;">Traditional <abbr title="Search Engine Optimization">SEO</abbr> Agencies</h3>
            <ul>
              <li>Optimize pages for <strong>keywords</strong> and <strong>search queries</strong></li>
              <li>Focus on <strong>rankings</strong> and <strong>traffic volume</strong></li>
              <li>Measure success by <strong>impressions</strong> and <strong>clicks</strong></li>
              <li>Assume AI systems behave like <strong>traditional search engines</strong></li>
              <li>Optimize for <strong>page-level relevance</strong> and <strong>crawlability</strong></li>
            </ul>
          </div>
          <div style="border: 1px solid #4a90e2; padding: var(--spacing-md); border-radius: 4px; background: #f0f7ff;">
            <h3 style="margin-top: 0; color: #4a90e2;">NRLC.ai: AI Search Optimization</h3>
            <ul>
              <li>Engineer <strong>entities</strong> and <strong>relationships</strong> through structured data</li>
              <li>Optimize for <strong>AI citation</strong> and <strong>reuse</strong> in answer generation</li>
              <li>Measure success by <strong>AI visibility</strong> and <strong>reference frequency</strong></li>
              <li>Design content for <strong>LLM extraction</strong> and <strong>trust scoring</strong></li>
              <li>Optimize for <strong>segment-level retrieval</strong> and <strong>entity-level citation</strong></li>
              <li>Implement <strong>atomic content architecture</strong> and <strong>citation-ready formatting</strong></li>
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
    </section>

    <!-- AUTHORITATIVE VOICE INSERT: TECHNICAL FOUNDATION -->
    <section class="content-block module" style="margin-bottom: var(--spacing-8); border-left: 3px solid #4a90e2; padding-left: var(--spacing-md);">
      <div class="content-block__header">
        <h2 class="content-block__title">Why This Knowledge Base Exists: The Technical Foundation</h2>
      </div>
      <div class="content-block__body">
        <p>Modern visibility failures aren't due to "bad <abbr title="Search Engine Optimization">SEO</abbr>." They happen because the web is now read by <strong>machines that require structure</strong>, <strong>evidence</strong>, and <strong>consistency</strong> - and most sites were never built for that.</p>
        
        <p>When <strong>Google AI Overviews</strong> or <strong>ChatGPT</strong> needs to answer a question, it doesn't rank pages. It evaluates which sources provide information that can be <strong>extracted</strong>, <strong>verified</strong>, and <strong>cited safely</strong>. If your site doesn't provide these signals clearly, AI systems won't reference you, regardless of your search rankings.</p>
        
        <p>This knowledge base exists to bridge that gap. It documents how <strong>generative search systems</strong> work, why traditional <abbr title="Search Engine Optimization">SEO</abbr> explanations fail, and what actually determines AI visibility. For businesses that need help implementing these principles, we provide <a href="<?= absolute_url('/en-us/ai-visibility/') ?>">AI visibility optimization services</a> and <a href="<?= absolute_url('/en-us/services/') ?>">technical implementation support</a> that improve how AI systems cite and recommend your business.</p>
      </div>
    </section>

    <!-- FAQ SECTION: AI VISIBILITY QUESTIONS -->
    <section class="content-block module" style="margin-bottom: var(--spacing-8);" itemscope itemtype="https://schema.org/FAQPage">
      <div class="content-block__header">
        <h2 class="content-block__title">Questions About AI Search, ChatGPT, and Brand Visibility</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <dt itemscope itemtype="https://schema.org/Question"><strong itemprop="name">Why doesn't AI search cite my content?</strong></dt>
          <dd itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
            <span itemprop="text">AI systems like <strong>ChatGPT</strong> and <strong>Google AI Overviews</strong> do not browse the web or list pages in directories. They generate answers by extracting information from sources that are <strong>structured</strong>, <strong>consistent</strong>, and <strong>widely corroborated</strong>. Content is more likely to be cited when it is clearly defined in <strong>machine-readable formats</strong> (JSON-LD schema), uses <strong>atomic segments</strong> that survive compression, and provides <strong>unambiguous entity definitions</strong>. <a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>">AI Search Diagnostics</a> explains specific failure patterns that cause citation suppression.</span>
          </dd>
          
          <dt itemscope itemtype="https://schema.org/Question"><strong itemprop="name">Why is my site indexed but not showing in AI results?</strong></dt>
          <dd itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
            <span itemprop="text"><strong>Indexing and retrieval are different processes.</strong> A page can be indexed by search engines but ignored by generative AI systems if its content segments fail <strong>confidence thresholds</strong>, lack <strong>atomic structure</strong>, or contain <strong>ambiguity</strong> that prevents safe citation. <a href="<?= absolute_url('/en-us/ai-search-diagnostics/indexed-but-not-retrieved/') ?>">Indexed but not retrieved</a> documents the specific conditions that cause this disconnect.</span>
          </dd>
          
          <dt itemscope itemtype="https://schema.org/Question"><strong itemprop="name">How does ChatGPT decide which brands to mention?</strong></dt>
          <dd itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
            <span itemprop="text"><strong>ChatGPT</strong> and similar systems evaluate whether information about a brand can be <strong>confidently extracted</strong> and <strong>verified across multiple sources</strong>. Brands are more likely to be mentioned when their content clearly defines <strong>who they are</strong>, <strong>what they do</strong>, and <strong>how they relate to a topic</strong>, using <strong>consistent language</strong> and <strong>structure</strong> across the web. <a href="<?= absolute_url('/en-us/generative-engine-optimization/decision-traces/') ?>">Decision traces in generative search</a> explain how these judgments accumulate into patterns that influence future retrieval decisions.</span>
          </dd>
          
          <dt itemscope itemtype="https://schema.org/Question"><strong itemprop="name">Is ranking on Google enough to be featured in AI Overviews or ChatGPT?</strong></dt>
          <dd itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
            <span itemprop="text"><strong>No.</strong> Traditional rankings measure <strong>page relevance</strong>, while AI systems prioritize <strong>extractability</strong> and <strong>trust</strong>. A page can rank well and still be ignored by AI if its information isn't <strong>structured</strong>, <strong>explicit</strong>, and <strong>verifiable</strong> enough to be cited safely. <a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>">Generative Engine Optimization</a> explains the mechanics of <strong>segment-level retrieval</strong> versus <strong>page-level ranking</strong>.</span>
          </dd>
          
          <dt itemscope itemtype="https://schema.org/Question"><strong itemprop="name">Why did my traffic drop even though rankings stayed the same?</strong></dt>
          <dd itemscope itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
            <span itemprop="text">When <strong>generative AI systems</strong> answer queries directly, they reduce the need for users to <strong>click through to source pages</strong>. This creates a disconnect between traditional ranking metrics and actual traffic. Rankings may remain stable while traffic declines because AI systems are providing answers without requiring page visits. <a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>">AI Search Measurement</a> explains what can and cannot be measured in AI-mediated search.</span>
          </dd>
        </dl>
      </div>
    </section>

    <!-- IMPLEMENTATION SUPPORT: ENHANCED CTAs -->
    <section class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8); margin-top: var(--spacing-xl);">
      <div class="content-block__body">
        <h2 class="heading-2" style="margin-top: 0;">Implementation Support</h2>
        <p>For teams who need assistance applying the material above, Neural Command provides <strong>technical implementation support</strong>, <strong>AI visibility optimization services</strong>, and <strong>structured data engineering</strong>.</p>
        <div class="btn-group" style="margin-top: var(--spacing-md);">
          <a href="<?= absolute_url('/en-us/implementation/') ?>" class="btn btn--primary">Learn About Implementation Support</a>
          <a href="<?= absolute_url('/en-us/services/') ?>" class="btn btn--secondary">View Services</a>
          <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary">Book Consultation</a>
        </div>
      </div>
    </section>

  </div>
</article>
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
        'givenName' => 'Joel',
        'familyName' => 'Maldonado',
        'jobTitle' => 'Founder & AI Search Researcher',
        'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.',
        'knowsAbout' => [
          'SEO', 'AEO', 'GEO', 'AI Search', 'Search Retrieval', 'AI Citations', 
          'Extractability', 'Generative Engine Optimization', 'LLM Seeding', 
          'Structured Data', 'Schema Markup', 'Entity Mapping', 'Answer Engine Optimization',
          'Retrieval Signal Engineering', 'Atomic Content Architecture'
        ],
        'worksFor' => [
          '@type' => 'Organization',
          '@id' => $baseUrl . '#neural-command'
        ],
        'affiliation' => [
          '@type' => 'Organization',
          '@id' => $baseUrl . '#neural-command'
        ],
        'url' => $baseUrl,
        'image' => [
          '@type' => 'ImageObject',
          'url' => $baseUrl . 'assets/images/nrlc-logo.png',
          'width' => 43,
          'height' => 43
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/',
          'https://twitter.com/neuralcommand',
          'https://www.crunchbase.com/person/joel-maldonado'
        ]
      ],
      [
        '@type' => 'Organization',
        '@id' => $baseUrl . '#neural-command',
        'name' => 'Neural Command, LLC',
        'legalName' => 'Neural Command, LLC',
        'url' => $baseUrl,
        'logo' => [
          '@type' => 'ImageObject',
          'url' => $logoUrl,
          'width' => 43,
          'height' => 43
        ],
        'founder' => [
          '@type' => 'Person',
          '@id' => $baseUrl . '#joel-maldonado'
        ],
        'foundingDate' => '2020',
        'address' => [
          '@type' => 'PostalAddress',
          'streetAddress' => '1639 11th St suite 110-a',
          'addressLocality' => 'Santa Monica',
          'addressRegion' => 'CA',
          'postalCode' => '90404',
          'addressCountry' => 'US'
        ],
        'contactPoint' => [
          '@type' => 'ContactPoint',
          'telephone' => '+1-844-568-4624',
          'contactType' => 'customer service',
          'areaServed' => 'US',
          'availableLanguage' => 'en'
        ],
        'knowsAbout' => [
          'AI Search Optimization', 'AEO', 'GEO', 'SEO', 'LLM Seeding',
          'Structured Data', 'AI Citations', 'Search Retrieval', 'Extractability',
          'Schema Markup Engineering', 'Entity Disambiguation', 'Atomic Content Architecture',
          'Retrieval Signal Optimization', 'Answer Engine Optimization'
        ],
        'areaServed' => 'Worldwide',
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/',
          'https://twitter.com/neuralcommand',
          'https://www.crunchbase.com/organization/neural-command'
        ]
      ],
      [
        '@type' => 'WebPage',
        '@id' => $baseUrl . '#webpage',
        'url' => $baseUrl,
        'name' => $GLOBALS['__page_meta']['title'] ?? 'Joel Maldonado | SEO, AEO, GEO & AI Search Research',
        'description' => $GLOBALS['__page_meta']['description'] ?? 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems.',
        'inLanguage' => 'en-US',
        'datePublished' => '2020-01-01',
        'dateModified' => date('Y-m-d'),
        'keywords' => $GLOBALS['__page_meta']['keywords'] ?? 'Joel Maldonado, SEO, AEO, GEO, AI Search, AI Search Optimization, Generative Engine Optimization, LLM Seeding, Structured Data, AI Citations, Search Retrieval',
        'about' => [
          [
            '@type' => 'Thing',
            'name' => 'AI Search Optimization',
            'description' => 'The practice of optimizing content and structured data for AI-powered search engines'
          ],
          [
            '@type' => 'Thing',
            'name' => 'AEO',
            'description' => 'Answer Engine Optimization - optimizing content for AI answer engines'
          ],
          [
            '@type' => 'Thing',
            'name' => 'GEO',
            'description' => 'Generative Engine Optimization - optimizing content for generative AI systems'
          ],
          [
            '@type' => 'Person',
            '@id' => $baseUrl . '#joel-maldonado'
          ]
        ],
        'mentions' => [
          [
            '@type' => 'SoftwareApplication',
            'name' => 'ChatGPT',
            'description' => 'AI language model by OpenAI'
          ],
          [
            '@type' => 'SoftwareApplication',
            'name' => 'Google AI Overviews',
            'description' => 'Google\'s AI-powered search overview feature'
          ],
          [
            '@type' => 'SoftwareApplication',
            'name' => 'Claude',
            'description' => 'AI language model by Anthropic'
          ],
          [
            '@type' => 'SoftwareApplication',
            'name' => 'Perplexity',
            'description' => 'AI-powered search engine'
          ]
        ],
        'author' => [
          '@type' => 'Person',
          '@id' => $baseUrl . '#joel-maldonado'
        ],
        'publisher' => [
          '@type' => 'Organization',
          '@id' => $baseUrl . '#neural-command'
        ],
        'primaryImageOfPage' => [
          '@type' => 'ImageObject',
          'url' => $logoUrl,
          'width' => 43,
          'height' => 43
        ],
        'isPartOf' => [
          '@type' => 'WebSite',
          '@id' => $baseUrl . '#website'
        ],
        'breadcrumb' => [
          '@type' => 'BreadcrumbList',
          'itemListElement' => [
            [
              '@type' => 'ListItem',
              'position' => 1,
              'name' => 'Home',
              'item' => $baseUrl
            ]
          ]
        ],
        'speakable' => [
          '@type' => 'SpeakableSpecification',
          'cssSelector' => ['h1', '.lead']
        ]
      ],
      [
        '@type' => 'WebSite',
        '@id' => $baseUrl . '#website',
        'url' => $baseUrl,
        'name' => 'Neural Command',
        'description' => 'AI Search Optimization, AEO, and GEO research and implementation. Knowledge base for AI visibility, retrieval, citations, and extractability.',
        'inLanguage' => 'en-US',
        'publisher' => [
          '@type' => 'Organization',
          '@id' => $baseUrl . '#neural-command'
        ],
        'potentialAction' => [
          '@type' => 'SearchAction',
          'target' => [
            '@type' => 'EntryPoint',
            'urlTemplate' => $baseUrl . '?q={search_term_string}'
          ],
          'query-input' => 'required name=search_term_string'
        ]
      ],
      [
        '@type' => 'Thing',
        'name' => 'AEO',
        'alternateName' => 'Answer Engine Optimization',
        'description' => 'The practice of optimizing content for AI answer engines (ChatGPT, Google AI Overviews, Claude, Perplexity) that generate direct answers without requiring users to click through to source pages.'
      ],
      [
        '@type' => 'Thing',
        'name' => 'GEO',
        'alternateName' => 'Generative Engine Optimization',
        'description' => 'The practice of optimizing content for generative AI systems that retrieve, evaluate, and cite web content.'
      ],
      [
        '@type' => 'Thing',
        'name' => 'AI Search Optimization',
        'description' => 'The comprehensive discipline that encompasses AEO, GEO, and related practices for optimizing content visibility in AI-powered search systems.'
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
    '@id' => $baseUrl . '#faq',
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
    ],
    [
      '@type' => 'Question',
      'name' => 'What is AEO (Answer Engine Optimization)?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'AEO (Answer Engine Optimization) is the practice of optimizing content for AI answer engines (ChatGPT, Google AI Overviews, Claude, Perplexity) that generate direct answers without requiring users to click through to source pages. AEO focuses on entity clarity, atomic content segments, structured data, and citation-ready formatting that enables AI systems to extract, verify, and cite information confidently.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'What is GEO (Generative Engine Optimization)?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'GEO (Generative Engine Optimization) is the practice of optimizing content for generative AI systems that retrieve, evaluate, and cite web content. GEO encompasses retrieval signal engineering, semantic structure optimization, entity relationship mapping, and confidence threshold alignment. GEO addresses the fundamental shift from page-level ranking (traditional SEO) to segment-level retrieval and entity-level citation in AI-mediated search environments.'
      ]
    ]
    ]
  ];
} catch (Throwable $e) {
  // Silent fail - FAQ schema is optional
}
?>
