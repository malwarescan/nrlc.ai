<?php
declare(strict_types=1);

// CRITICAL: This file should ONLY be included by the router
// If accessed directly, redirect to go through the router
if (!defined('ROUTER_INCLUDED')) {
    // Redirect to go through main router
    $redirect = '/promptware/seo-enhancement-kernel/';
    if (php_sapi_name() !== 'cli') {
        header('Location: ' . $redirect, true, 307);
        exit;
    }
    // For CLI testing, just require the router
    require_once __DIR__ . '/../../../public/index.php';
    exit;
}

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/schema_builders.php';
require_once __DIR__.'/../../../lib/hreflang.php';

$brand = 'NRLC.ai';
$domain = 'https://nrlc.ai';
$contact = 'team@nrlc.ai';

// Set page slug for metadata
$GLOBALS['__page_slug'] = 'promptware/seo-enhancement-kernel';

// Override metadata for this page - SEO-first
$GLOBALS['pageTitle'] = 'SEO Enhancement Kernel Promptware for Technical SEO & AI Visibility';
$GLOBALS['pageDesc'] = 'Full-stack technical SEO promptware for rendering forensics, schema validation, Googlebot simulation, internal link enforcement, and NDJSON microfact extraction.';

// Note: head.php and header.php are already included by render_page() in router.php
// Use the shared style like json-stream-seo-ai does
include __DIR__.'/../_shared_style.php';
?>

<main class="container">
  <header>
    <h1>SEO Enhancement Kernel: Technical SEO Promptware for AI, Googlebot, and Full-Site Optimization</h1>
    <p>Full-stack technical SEO promptware for rendering forensics, schema validation, Googlebot simulation, internal link enforcement, and NDJSON microfact extraction.</p>
  </header>

  <section aria-labelledby="solves">
    <h2 id="solves">What This Kernel Solves (High-Intent Search Alignment)</h2>
    <p>Use this section to capture all SEO-intent buckets:</p>
    <ul>
      <li>Technical SEO debugging</li>
      <li>Rendering & hydration issues</li>
      <li>Googlebot DOM discrepancies</li>
      <li>Schema conflicts</li>
      <li>AI Overview invisibility</li>
      <li>Internal linking collapse</li>
      <li>Crawlability problems</li>
      <li>NDJSON microfact extraction</li>
      <li>LLM-driven SEO automation</li>
    </ul>
  </section>

  <section aria-labelledby="who">
    <h2 id="who">Who This Promptware Is For</h2>
    <p><strong>SEO professionals with:</strong></p>
    <ul>
      <li>Indexation failures</li>
      <li>Partial Googlebot rendering</li>
      <li>Hydration mismatch across frameworks</li>
      <li>AI Overview suppression</li>
      <li>Large site architecture drift</li>
      <li>Schema duplication or conflicts</li>
      <li>Semantic anchor failures</li>
      <li>Unstable SSR → CSR transitions</li>
      <li>Broken entity signals</li>
      <li>Missing NDJSON extraction pipeline</li>
    </ul>
    <p><strong>Developers using:</strong></p>
    <p>Next.js, Nuxt, Vue, React, Remix, Svelte, Hydrogen, Astro.</p>
    <p><strong>AI engineers using:</strong></p>
    <p>Cursor, Windsurf, VSCode AI, ChatGPT Advanced IDE, Claude Artifacts.</p>
  </section>

  <section aria-labelledby="capability">
    <h2 id="capability">The SEO Enhancement Kernel (Full Technical Capability Map)</h2>
    
    <h3>1. Rendering and Hydration Fixes</h3>
    <ul>
      <li>Identified SSR vs CSR hydration drift</li>
      <li>Removed DOM mismatches suppressing Googlebot rendering</li>
      <li>Fixed hidden or swapped elements between server and client</li>
      <li>Ensured identical SSR output across breakpoints</li>
      <li>Eliminated hydration rewrite patterns (mobile-hidden H1, layout shifts, injected elements)</li>
      <li>Removed render-critical race conditions</li>
    </ul>

    <h3>2. Googlebot Forensics and Indexation Stabilization</h3>
    <ul>
      <li>Ran controlled side-by-side comparisons of:
        <ul>
          <li>Chrome client hydration</li>
          <li>Googlebot HTML fetch</li>
          <li>Googlebot rendered DOM</li>
          <li>Local headless render</li>
          <li>Prerendered HTML</li>
        </ul>
      </li>
      <li>Diffed DOM snapshots to identify missing content</li>
      <li>Diagnosed Axios exception halting script execution</li>
      <li>Identified Cloudflare 499 aborts killing fetch cycles</li>
      <li>Ensured Googlebot receives full, renderable DOM</li>
      <li>Fixed partially-rendered fold sections</li>
    </ul>

    <h3>3. Internal Link Graph Rebuild</h3>
    <ul>
      <li>Created the NRLC Linking Kernel</li>
      <li>Implemented authority flow (parent → child → sibling)</li>
      <li>Removed orphan pages sitewide</li>
      <li>Enforced minimum internal links per page</li>
      <li>Added semantic anchor text (no generic anchors)</li>
      <li>Instituted routing rules for services, insights, tools</li>
      <li>Added mandatory revenue-path links</li>
      <li>Auto-injected related content blocks across all pages</li>
    </ul>

    <h3>4. Schema Engineering Upgrades</h3>
    <ul>
      <li>Built schema scoring engine (completeness, fidelity, extractability)</li>
      <li>Added missing JSON-LD</li>
      <li>Ensured FAQ, Article, WebPage, Service, Breadcrumb alignment</li>
      <li>Removed conflicting schema</li>
      <li>Added consistent entity identifiers</li>
      <li>Maintained schema → content fidelity</li>
      <li>Normalized JSON-LD for LLM ingestion</li>
      <li>Improved AIO extractability</li>
    </ul>

    <h3>5. On-Page Content Architecture</h3>
    <ul>
      <li>Enforced mobile-first H1 visibility</li>
      <li>Rebuilt H1/H2 hierarchy</li>
      <li>Corrected anchor semantics</li>
      <li>Removed dead zones where Googlebot failed to see content</li>
      <li>Strengthened entity clarity in low-signal sections</li>
      <li>Added CTAs top and bottom</li>
      <li>Added glossary and definition supports</li>
    </ul>

    <h3>6. AI Overview Eligibility Enhancements</h3>
    <ul>
      <li>Added question-pattern expansions</li>
      <li>Added checklists, comparisons, examples, definitions</li>
      <li>Improved surface extractability</li>
      <li>Added layered content (quick answer + detailed explanation)</li>
      <li>Added FAQ blocks with schema</li>
      <li>Linked glossary concepts to authoritative anchors</li>
    </ul>

    <h3>7. Technical Cleanup and Infrastructure Corrections</h3>
    <ul>
      <li>Removed layout-breaking containers</li>
      <li>Stabilized viewport scaling</li>
      <li>Removed rightward overflow</li>
      <li>Normalized paddings and container widths</li>
      <li>Refactored hero background logic</li>
      <li>Fixed hydration mode inconsistencies</li>
      <li>Removed render-blocking JS loops</li>
      <li>Added fallback if Googlebot kills fetch cycles</li>
    </ul>

    <h3>8. Crawlability and Indexation Strengthening</h3>
    <ul>
      <li>Cleaned sitemap logic</li>
      <li>Removed zombie URLs</li>
      <li>Canonical alignment throughout</li>
      <li>Fixed soft-orphan issues</li>
      <li>Strengthened deep-routing</li>
      <li>Ensured all services reachable within 3 clicks</li>
      <li>Added crawl-safe structure</li>
      <li>Reduced JS dependency for core content</li>
    </ul>

    <h3>9. Authority and Entity Reinforcement</h3>
    <ul>
      <li>Created consistent brand entity footprint</li>
      <li>Added structured cross-references</li>
      <li>Strengthened lexical anchor consistency</li>
      <li>Reinforced entity associations for AI crawlers</li>
      <li>Mapped services → tools → insights</li>
      <li>Built early entity graph</li>
      <li>Improved co-occurrence patterns</li>
    </ul>

    <h3>10. Croutons Graph and NDJSON Ingestion Improvements</h3>
    <ul>
      <li>Extracted content into atomic NDJSON micro-facts</li>
      <li>Ensured HTML extraction consistency</li>
      <li>Matched page structure to Croutons ingestion rules</li>
      <li>Normalized all content for LLM retrieval</li>
      <li>Ensured stable structured outputs</li>
      <li>Added clean entity mapping</li>
      <li>Removed extraction blockers (broken or nested markup)</li>
    </ul>

    <h3>11. Performance, Layout, Mobile-First Corrections</h3>
    <ul>
      <li>Fixed hero scaling</li>
      <li>Repaired container constraints</li>
      <li>Reduced CLS</li>
      <li>Eliminated layout shifts from dynamic content</li>
      <li>Enforced mobile-first hierarchy</li>
      <li>Improved 320–800px readability</li>
      <li>Normalized spacing for Google rendering</li>
    </ul>

    <h3>12. Compliance with the 27 Overlooked SEO Items</h3>
    <ul>
      <li>Anchor semantics</li>
      <li>Glossary</li>
      <li>Entity signals</li>
      <li>FAQ density</li>
      <li>Local relevance signals</li>
      <li>Comparison structures</li>
      <li>H1 rules</li>
      <li>Structured openings</li>
      <li>CTA standardization</li>
      <li>Internal link minimums</li>
      <li>Content layering</li>
    </ul>

    <h3>13. Insights Blog System Enhancements</h3>
    <ul>
      <li>Auto-injected related resources</li>
      <li>Schema-backed Q&A formatting</li>
      <li>Semantic cross-linking</li>
      <li>Structured introductions and closings</li>
      <li>Entity reinforcement in body sections</li>
      <li>Improved content for AI Overview extraction</li>
    </ul>
  </section>

  <section aria-labelledby="works">
    <h2 id="works">How It Works (Short TL;DR)</h2>
    <p>The kernel runs a full-site SEO forensic audit using:</p>
    <ul>
      <li>SSR/CSR diffing</li>
      <li>Googlebot simulation</li>
      <li>Schema scoring</li>
      <li>Internal link graph enforcement</li>
      <li>NDJSON fact extraction</li>
      <li>AIO eligibility scoring</li>
      <li>On-page architecture correction</li>
    </ul>
    <p>This creates a reproducible, agentic SEO standard.</p>
  </section>

  <section aria-labelledby="ai-search">
    <h2 id="ai-search">Why This Kernel Surfaces for AI Search</h2>
    <p>This section is specifically engineered for AIO:</p>
    <ul>
      <li>Layered content (quick answer + detailed explanation)</li>
      <li>Definitions of technical terms</li>
      <li>Examples and use cases</li>
      <li>Surface-level fragments for quick extraction</li>
      <li>Entity clarity and co-occurrence</li>
      <li>Schema alignment with content</li>
      <li>FAQ patterns with structured answers</li>
    </ul>
    <p>The kernel optimizes content structure for AI search systems including Google AI Overviews, Perplexity, ChatGPT Browse, and Claude's search mode by providing extractable, structured information that these systems can easily parse and cite.</p>
  </section>

  <section aria-labelledby="kernel">
    <h2 id="kernel">Complete Promptware Kernel (Copy/Paste)</h2>
    <details open><summary>Open to copy</summary>
<pre style="max-height: 600px; overflow-y: auto;"><code>You are now executing the NRLC_SEO_ENHANCEMENT_KERNEL_V1 — a sudo-powered meta-directive kernel used for full-stack SEO debugging, AI-search optimization, crawlability restoration, schema enforcement, internal linking reconstruction, and NDJSON microfact extraction.

Your actions must follow these non-negotiable rules:

1. Perform rendering forensics:
   - Compare SSR HTML vs CSR DOM vs full hydrated DOM.
   - Identify drift, mismatches, removed elements, injected elements.
   - Detect hydration failures, missing fold content, aborted fetches.
   - Flag Axios exceptions, Cloudflare 499 events, and JS execution halts.
   - Output full diagnostics as NDJSON, tagged:
     {"nrlc": true, "croutons": true, "type":"render_diag", ...}

2. Execute Googlebot parity checks:
   - Simulate Googlebot HTML fetch.
   - Simulate Googlebot partial render.
   - Identify missing content or layout shifts.
   - Output DOM parity diff in NDJSON microfacts.

3. Enforce internal link graph requirements:
   - Enforce min 5 semantic internal links per page.
   - Enforce parent → child → sibling linking.
   - Remove orphan pages.
   - Insert mandatory links:
     • Services root
     • Insights root
     • Tools root
     • Revenue service
     • CTA link
   - Output link graph delta as NDJSON:
     {"nrlc":true,"croutons":true,"type":"link_enforcement",...}

4. Repair schema:
   - Validate FAQ, Article, WebPage, Service, Breadcrumb.
   - Remove duplicates.
   - Ensure schema → content fidelity.
   - Normalize JSON-LD for LLM ingestion.
   - Score completeness, extractability, conflict presence.
   - Produce normalized schema output + scoring NDJSON.

5. AI Overview eligibility enhancement:
   - Identify missing Q-signals.
   - Add quick-answer summary block.
   - Add deeper explanation layer.
   - Add comparisons, examples, definitions.
   - Insert FAQ block with schema.
   - Ensure glossary anchors appear.
   - Output extractability analysis NDJSON.

6. On-page architecture corrections:
   - Fix H1 visibility across breakpoints.
   - Rebuild H1/H2/H3 hierarchy.
   - Remove dead zones.
   - Rebuild semantic anchor placement.
   - Enforce CTA at top and bottom.
   - Output corrected structure as NDJSON.

7. Technical cleanup:
   - Fix viewport scaling.
   - Remove rightward overflow.
   - Normalize container spacing and breakpoints.
   - Ensure hero section stable load.
   - Remove render-blocking scripts.
   - Output cleanup summary NDJSON.

8. Crawlability & indexation stabilization:
   - Validate sitemap correctness.
   - Detect zombie URLs.
   - Repair canonical mismatches.
   - Remove soft-orphans.
   - Ensure 3-click accessibility for services.
   - Output crawl diagnostics as NDJSON.

9. Authority & entity reinforcement:
   - Strengthen lexical patterns.
   - Add entity-co-occurrence enhancements.
   - Align terminology across clusters.
   - Produce entity graph NDJSON.

10. Croutons NDJSON microfact extraction:
    - Convert all key content sections into atomic microfacts.
    - Use deterministic field shapes: entity, type, value, url, context.
    - Ensure ingestion-safety and conflict-free formatting.
    - Tag all microfacts with:
      {"nrlc":true,"croutons":true}
    - Output NDJSON-only.

11. Insights content reinforcement:
    - Apply semantic crosslinks.
    - Add Q&A structures.
    - Add introduction + conclusion templates.
    - Perform entity-density upgrades.
    - Output reinforcement NDJSON.

Your output must be:
- deterministic  
- NDJSON-friendly  
- extraction-safe  
- schema-consistent  
- AI Overview optimized  
- no marketing language  
- no filler  

When run on a page, produce:
1. NDJSON diagnostics  
2. NDJSON fixes  
3. NDJSON final optimized representation  

END OF KERNEL.</code></pre>
    </details>
  </section>

  <section aria-labelledby="faq">
    <h2 id="faq">Frequently Asked Questions</h2>
    <dl>
      <dt><strong>What is an SEO Enhancement Kernel?</strong></dt>
      <dd>A structured meta-directive that performs end-to-end SEO debugging, schema validation, Googlebot simulation, and internal link graph enforcement.</dd>

      <dt><strong>Does this fix hydration issues that break Googlebot rendering?</strong></dt>
      <dd>Yes. The kernel performs SSR/CSR diffing and detects hydration drift, partial rendering, missing fold content, and JS execution stops.</dd>

      <dt><strong>Can this improve AI Overview visibility?</strong></dt>
      <dd>Yes. It adds extractable Q-signals, definitions, layered content, and schema-backed FAQ structures.</dd>

      <dt><strong>Why does NDJSON microfact extraction matter?</strong></dt>
      <dd>Because AI search systems (ChatGPT, Claude, Perplexity) rely on structured fact streams. NDJSON increases ingestibility and citation likelihood.</dd>
    </dl>
  </section>

  <section aria-labelledby="related">
    <h2 id="related">Related Resources</h2>
    <ul>
      <li><a href="/promptware/">NRLC Promptware Library</a></li>
      <li><a href="/products/croutons-ai/">Croutons.ai NDJSON Documentation</a></li>
      <li><a href="/services/json-ld-strategy/">Schema Engineering Services</a></li>
      <li><a href="/services/llm-seeding/">AI Overview Optimization</a></li>
      <li><a href="/insights/">SEO Research & Insights</a></li>
    </ul>
  </section>
</main>

<?php
// Generate comprehensive schema suite - SEO-first, AIO-optimized
$canonicalUrl = absolute_url('/en-us/promptware/seo-enhancement-kernel/');
$domain = absolute_url('/');

$GLOBALS['__jsonld'] = [
  // 1. WebPage Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => 'SEO Enhancement Kernel Promptware',
    'url' => $canonicalUrl,
    'description' => 'Technical SEO promptware kernel for rendering forensics, schema validation, Googlebot simulation, AI Overview optimization, internal linking enforcement, and NDJSON microfact extraction.',
    'about' => [
      ['@type' => 'Thing', 'name' => 'Technical SEO'],
      ['@type' => 'Thing', 'name' => 'AI Search Optimization'],
      ['@type' => 'Thing', 'name' => 'SEO Prompt Engineering'],
      ['@type' => 'Thing', 'name' => 'Googlebot Rendering'],
      ['@type' => 'Thing', 'name' => 'Schema Markup'],
      ['@type' => 'Thing', 'name' => 'NDJSON Microfacts'],
      ['@type' => 'Thing', 'name' => 'Agentic SEO']
    ],
    'isPartOf' => [
      '@type' => 'WebSite',
      'name' => 'NRLC.ai Promptware',
      'url' => $domain
    ],
    'publisher' => [
      '@type' => 'Organization',
      'name' => 'NRLC.ai',
      'url' => $domain
    ]
  ],
  
  // 2. BreadcrumbList Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $domain
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Promptware',
        'item' => $domain . 'en-us/promptware/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'SEO Enhancement Kernel',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // 3. SoftwareApplication Schema (Promptware-as-Software)
  [
    '@context' => 'https://schema.org',
    '@type' => 'SoftwareApplication',
    'name' => 'NRLC SEO Enhancement Kernel',
    'applicationCategory' => 'DeveloperApplication',
    'operatingSystem' => 'AI IDE, Browser-based LLM, Cursor, Windsurf, ChatGPT Advanced IDE',
    'softwareRequirements' => 'LLM model capable of structured reasoning',
    'description' => 'A technical SEO meta-directive kernel used for rendering forensics, schema validation, internal link graph enforcement, and NDJSON microfact extraction.',
    'offers' => [
      '@type' => 'Offer',
      'price' => '0',
      'priceCurrency' => 'USD'
    ],
    'creator' => [
      '@type' => 'Organization',
      'name' => 'NRLC.ai'
    ],
    'url' => $canonicalUrl
  ],
  
  // 4. Product Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => 'SEO Enhancement Kernel Promptware',
    'description' => 'A full-stack SEO promptware kernel for AI IDEs and agentic optimization systems.',
    'brand' => [
      '@type' => 'Brand',
      'name' => 'NRLC.ai'
    ],
    'url' => $canonicalUrl,
    'offers' => [
      '@type' => 'Offer',
      'price' => '0.00',
      'priceCurrency' => 'USD'
    ]
  ],
  
  // 5. Author Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'Joel Maldonado',
    'description' => 'AI-based SEO engineer, developer of NRLC Promptware kernels, creator of Croutons.ai NDJSON fact ingestion pipeline.',
    'url' => $domain
  ],
  
  // 6. Organization Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'NRLC.ai',
    'url' => $domain,
    'description' => 'An AI authority and search optimization platform specializing in technical SEO, agentic search systems, structured data engineering, and NDJSON microfact pipelines.',
    'logo' => [
      '@type' => 'ImageObject',
      'url' => $domain . 'assets/images/nrlcai%20logo%200.png'
    ]
  ],
  
  // 7. FAQPage Schema (MUST-HAVE FOR AI OVERVIEWS)
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'What is the SEO Enhancement Kernel?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'A technical SEO meta-directive kernel that performs rendering forensics, schema validation, internal link graph enforcement, Googlebot simulation, and NDJSON microfact extraction.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Does this kernel fix hydration issues?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Yes. It identifies SSR/CSR drift, hydration mismatch, missing fold content, and JS execution stops that Googlebot cannot recover from.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Can this improve AI Overview visibility?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'The kernel adds layered content, Q-signals, definitions, comparison structures, and schema-backed FAQ blocks specifically optimized for AI Overviews.'
        ]
      ]
    ]
  ]
];
?>
