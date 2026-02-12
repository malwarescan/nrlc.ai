<?php
/**
 * Grounding Queries vs Fan-Out Queries: The Two Hidden Layers of AI Visibility
 * Full SEO: meta, schema (Article, FAQPage, Breadcrumb), citeable structure.
 */
require_once __DIR__ . '/../../lib/person_entity.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

$articleSlug = 'grounding-queries-fan-out-ai-visibility';
$canonicalUrl = absolute_url("/en-us/insights/{$articleSlug}/");
$domain = 'https://nrlc.ai';

$articleTitle = 'Grounding Queries vs Fan-Out Queries: The Two Hidden Layers of AI Visibility (and the Step-by-Step System to Win Both)';
$metaDescription = 'AI visibility has two layers: grounding (which sources get cited) and fan-out (which angles get explored). Use Bing AI Performance data to map grounding queries to pages, inject answer blocks, and scale via fan-out ladders. Step-by-step system with templates.';

// Override meta for this article (router already set title/excerpt; we add dates + keywords)
if (isset($GLOBALS['__page_meta']) && is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta']['description'] = $metaDescription;
  $GLOBALS['__page_meta']['datePublished'] = '2026-02-11';
  $GLOBALS['__page_meta']['dateModified'] = '2026-02-11';
  $GLOBALS['__page_meta']['keywords'] = 'grounding queries, fan-out queries, AI visibility, Bing AI Performance, AI citations, citeable content, retrieval optimization, AI search optimization, grounding queries Bing, fan-out search, AI Webmaster Tools';
}

$faqItems = [
  ['q' => 'What are grounding queries in AI search?', 'a' => 'Grounding queries are the key phrases the AI system used when retrieving content that was cited in its answer. Grounding is about selecting sources the AI can safely reference. Bing\'s AI Performance report in Webmaster Tools exposes grounding queries for your cited pages.'],
  ['q' => 'What are fan-out queries?', 'a' => 'Fan-out queries are the internal expansion of one user prompt into multiple related sub-queries (variants, comparisons, constraints, sub-questions) so the system can gather broader information before producing a final response. Fan-out decides whether you get discovered across adjacent angles the model explores.'],
  ['q' => 'Why do I need both grounding and fan-out for AI visibility?', 'a' => 'Grounding decides whether you get included as a source (citations). Fan-out decides whether you get discovered across the adjacent angles the model explores (breadth of opportunities). Winning only one layer limits your AI visibility.'],
  ['q' => 'What does Bing\'s AI Performance report show?', 'a' => 'In Bing Webmaster Tools → AI Performance you can see total citations, page-level citation activity (which URLs got cited), grounding queries (phrases used to retrieve your cited content), trends over time, and average cited pages per day. Citations are visibility-as-a-source, not rankings or clicks.'],
  ['q' => 'What is an answer block for AI citation?', 'a' => 'An answer block is a retrieval-friendly section: an H2/H3 that mirrors the intent, 1–3 sentence direct answer immediately underneath, and 3–7 bullet facts. Place at least one in the top 20–30% of the page. Use full entity names and avoid pronoun-heavy writing so content can be lifted and cited safely.'],
  ['q' => 'What is the 3-minute citeability QA checklist?', 'a' => 'Before publishing each new/edited answer block: first ~150 words must include the full subject noun, a direct answer, and at least 3 concrete facts; heading must mirror the intent phrase; bullets must be standalone sentences; no fluffy intro before the first answer block. If it doesn’t pass, don’t publish yet.'],
];

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonicalUrl . '#article',
    'headline' => $articleTitle,
    'description' => $metaDescription,
    'url' => $canonicalUrl,
    'datePublished' => '2026-02-11',
    'dateModified' => '2026-02-11',
    'author' => joel_person_author(),
    'publisher' => ['@id' => $domain . '#organization'],
    'mainEntityOfPage' => ['@id' => $canonicalUrl . '#webpage'],
    'inLanguage' => 'en-US',
    'articleSection' => 'AI SEO Research',
    'keywords' => ['grounding queries', 'fan-out queries', 'AI visibility', 'Bing AI Performance', 'AI citations', 'citeable content', 'retrieval optimization'],
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => $articleTitle,
    'description' => $metaDescription,
    'isPartOf' => ['@id' => $domain . '#website'],
    'primaryImageOfPage' => ['@id' => $canonicalUrl . '#article'],
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain . '/en-us/'],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Insights', 'item' => $domain . '/en-us/insights/'],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $articleTitle, 'item' => $canonicalUrl],
    ],
  ],
];

$faqSchema = ld_faq($faqItems);
$faqSchema['@id'] = $canonicalUrl . '#faq';
$GLOBALS['__jsonld'][] = $faqSchema;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <article itemscope itemtype="https://schema.org/Article">
      <!-- Hero: definition in first ~100 words for AI extractability -->
      <header class="content-block module" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);">
        <h1 class="content-block__title" itemprop="headline"><?= htmlspecialchars($articleTitle) ?></h1>
        <div class="content-block__body">
          <p class="lead" itemprop="description"><strong>AI visibility is not one thing.</strong> There are at least two distinct layers before an AI answer appears: <strong>grounding</strong> (the system retrieves a small set of sources to keep the answer accurate and verifiable) and <strong>fan-out</strong> (the system expands the user’s prompt into multiple sub-queries and angles to explore the full decision space before synthesizing a response). Bing’s AI Performance report in Webmaster Tools is the first mainstream tool that exposes part of the grounding layer for your site—which pages were cited, and the grounding queries that led the AI to your content. This article gives you a practical method to turn that citations data into better, more citeable content, and then scale it into broader AI discovery via fan-out coverage.</p>
        </div>
      </header>

      <nav class="content-block module" aria-label="Article contents">
        <h2 class="content-block__title">Contents</h2>
        <ul>
          <li><a href="#definitions">Quick definitions (operational)</a></li>
          <li><a href="#why-both">Why you need both</a></li>
          <li><a href="#bing-report">What Bing’s AI Performance report gives you</a></li>
          <li><a href="#eight-step">The 8-step system (repeat weekly)</a></li>
          <li><a href="#fixes">The 4 highest-leverage fixes</a></li>
          <li><a href="#fan-out-clusters">Convert grounding queries into fan-out clusters</a></li>
          <li><a href="#templates">Templates you can paste into your CMS</a></li>
          <li><a href="#mistakes">Common mistakes that kill citations</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#sources">Sources</a></li>
        </ul>
      </nav>

      <section id="definitions" class="content-block module">
        <h2 class="content-block__title">Quick definitions (operational, not academic)</h2>
        <div class="content-block__body">
          <p><strong>Grounding queries</strong> — The key phrases the AI used when retrieving content that was cited in its answer. Grounding is about selecting sources the AI can safely reference.</p>
          <p><strong>Fan-out queries</strong> — The internal expansion of one prompt into multiple related sub-queries (variants, comparisons, constraints, sub-questions) to gather broader information before producing a final response.</p>
        </div>
      </section>

      <section id="why-both" class="content-block module">
        <h2 class="content-block__title">Why you need both</h2>
        <div class="content-block__body">
          <ul>
            <li><strong>Grounding</strong> decides whether you get included as a source (citations).</li>
            <li><strong>Fan-out</strong> decides whether you get discovered across the adjacent angles the model explores (breadth of opportunities).</li>
          </ul>
        </div>
      </section>

      <section id="bing-report" class="content-block module">
        <h2 class="content-block__title">What Bing’s AI Performance report actually gives you</h2>
        <div class="content-block__body">
          <p>Inside <strong>Bing Webmaster Tools → AI Performance</strong> (public preview), you can see:</p>
          <ul>
            <li>Total citations (how often your content was shown as a source in AI-generated answers)</li>
            <li>Page-level citation activity (which URLs got cited)</li>
            <li>Grounding queries (phrases used to retrieve your cited content)</li>
            <li>Trends over time</li>
            <li>Average cited pages (average number of unique pages cited per day)</li>
          </ul>
          <p><strong>Important:</strong> citations are visibility-as-a-source, not “rankings” or “clicks.”</p>
        </div>
      </section>

      <section id="eight-step" class="content-block module">
        <h2 class="content-block__title">The 8-step system: turn citations data into citeable content (repeat weekly)</h2>
        <div class="content-block__body">

          <h3 id="step-1">Step 1) Export the two datasets (two time windows)</h3>
          <p>In Bing Webmaster Tools → AI Performance:</p>
          <ul>
            <li>Export <strong>Cited Pages</strong> (URL + citations)</li>
            <li>Export <strong>Grounding Queries</strong> (query + citations)</li>
          </ul>
          <p>Run two ranges: <strong>Last 28 days</strong> (stable patterns) and <strong>Last 7 days</strong> (recent spikes). This separates durable winners from short-term demand.</p>

          <h3 id="step-2">Step 2) Build a URL↔Query mapping table (the core move)</h3>
          <p>Make a sheet with columns: <strong>URL</strong>, <strong>Grounding query</strong>, <strong>Best-matching on-page section (heading)</strong>, <strong>Answer block exists? (Y/N)</strong>, <strong>Fix type (A/B/C/D)</strong>.</p>
          <p><strong>Fast mapping method:</strong> Open the URL, Ctrl+F the main nouns from the grounding query, locate the closest heading/section that should answer it. If nothing clean exists, mark Answer block = N. This converts “interesting metrics” into “editing instructions.”</p>

          <h3 id="step-3">Step 3) Score each row so you don’t rewrite randomly</h3>
          <p>Label each URL↔Query row:</p>
          <ul>
            <li><strong>A) Winner:</strong> cited and already clear</li>
            <li><strong>B) Cited but weak:</strong> cited, but answer is buried / vague / fluffy</li>
            <li><strong>C) Missing:</strong> query matches, but there is no clean answer block</li>
            <li><strong>D) Wrong page:</strong> the query should map to a different URL (misattribution)</li>
          </ul>
          <p>Now every action has a reason.</p>

          <h3 id="step-4">Step 4) Apply the 4 highest-leverage fixes</h3>
          <p>See section <a href="#fixes">The 4 highest-leverage fixes</a> below.</p>

          <h3 id="step-5">Step 5) Convert grounding queries into fan-out clusters (your roadmap)</h3>
          <p>Cluster grounding queries into buckets: Definition (“what is”), How-to / steps, Requirements / eligibility, Cost / pricing / limits, Comparison / alternatives / “best”, Troubleshooting / errors, Use cases / scenarios. <strong>Decision rule:</strong> Repeats across multiple weeks → make it a heading or a child page. One-offs → add a short subsection; don’t spawn a new URL. Fan-out is where scale comes from.</p>

          <h3 id="step-6">Step 6) Add freshness only when the data demands it</h3>
          <p>If grounding queries contain: latest, new, 2026, update, cost, pricing, requirements — add “Updated: Month Day, Year” near the first answer block and a 3-bullet “What changed” mini-changelog. This is a strong retrieval cue when multiple sources compete.</p>

          <h3 id="step-7">Step 7) Measure the right outcomes (weekly)</h3>
          <p>Track week-over-week: Total citations, Unique cited pages, New URLs entering the cited list, Shifts in grounding query volume. <strong>Interpretation:</strong> Citations up, unique cited pages flat → you improved grounding on a small set of URLs. Unique cited pages rising → your ladder expansion is working.</p>

          <h3 id="step-8">Step 8) The 3-minute “citeability QA” checklist (before publishing)</h3>
          <p>For each new/edited answer block, first ~150 words must include: full subject noun (entity name), a direct answer, at least 3 concrete facts. Heading must mirror the intent phrase. Bullets must be standalone sentences. No fluffy intro before the first answer block. If it doesn’t pass, don’t publish it yet.</p>
        </div>
      </section>

      <section id="fixes" class="content-block module">
        <h2 class="content-block__title">The 4 highest-leverage fixes (the actual “hacks”)</h2>
        <div class="content-block__body">

          <h3>Fix 1: Answer Block Injection (for B and C)</h3>
          <p>For each repeated grounding query intent, add a retrieval-friendly answer block:</p>
          <ul>
            <li>H2/H3 that mirrors the intent (not necessarily the exact query)</li>
            <li>1–3 sentence direct answer immediately underneath</li>
            <li>3–7 bullet facts (steps, limits, requirements, menu paths, definitions)</li>
          </ul>
          <p><strong>Placement rule:</strong> Put at least one answer block in the top 20–30% of the page when possible. <strong>Chunk rule:</strong> Avoid pronouns (“this/it/they”) in the answer sentence. Repeat the full entity name at least once per block. This makes the content easier to lift and cite safely.</p>

          <h3>Fix 2: Chunk Mirror (for B)</h3>
          <p>If you already have the answer but it’s buried: duplicate it near the top as “Quick answer,” tighten it (shorter sentences, more proper nouns, fewer clauses), and keep the original section intact. This preserves what already works while creating a cleaner retrieval chunk.</p>

          <h3>Fix 3: Page Routing (for D)</h3>
          <p>When the wrong URL is being cited for a query family, steer retrieval. On the wrong page: add a top-of-page line: “For the definitive answer on [topic], see: [Correct URL].” Add 2–5 internal links to the correct page with intent-matching anchor text. Strengthen canonicals and nav so the correct page becomes the obvious primary. Goal: route future citations to the right page without waiting for luck.</p>

          <h3>Fix 4: Citation Ladder Expansion (for A)</h3>
          <p>Take one top cited URL (hub). Select 10–30 grounding queries that represent narrow variants or constraints. Create child pages (or dedicated sections) for those variants. Interlink: hub ↔ children. Why it works: fan-out exploration needs lots of narrow, clean answers across adjacent angles. “One great page” is rarely enough.</p>
        </div>
      </section>

      <section id="fan-out-clusters" class="content-block module">
        <h2 class="content-block__title">Convert grounding queries into fan-out clusters (your roadmap)</h2>
        <div class="content-block__body">
          <p>Grounding queries are not “keywords.” They’re evidence of retrieval demand. Cluster them into: Definition (“what is”), How-to / steps, Requirements / eligibility, Cost / pricing / limits, Comparison / alternatives / “best”, Troubleshooting / errors, Use cases / scenarios. Repeats across multiple weeks → make it a heading or a child page. One-offs → add a short subsection.</p>
        </div>
      </section>

      <section id="templates" class="content-block module">
        <h2 class="content-block__title">Templates you can paste into your CMS</h2>
        <div class="content-block__body">

          <h3>Template A: AI Answer Block (grounding-ready)</h3>
          <pre style="background:#f5f5f5;padding:1rem;overflow:auto;"><strong>H2/H3:</strong> [Intent-aligned heading]
Direct answer (1–3 sentences).
<strong>Bullets (3–7):</strong>
• Fact 1 (complete sentence, includes the subject noun)
• Fact 2
• Fact 3
Optional: “When this doesn’t apply” (1–2 sentences); “Sources / References” (2–5 authoritative links)</pre>

          <h3>Template B: Fan-Out Child Page (discovery-ready)</h3>
          <pre style="background:#f5f5f5;padding:1rem;overflow:auto;"><strong>H1:</strong> [Narrow intent / constraint]
Two-sentence answer.
Criteria bullets (5–9).
Mini-table: Option | Best for | Tradeoff.
FAQ (3–6).
Link back to hub: “See the full guide: [Hub URL].”</pre>
        </div>
      </section>

      <section id="mistakes" class="content-block module">
        <h2 class="content-block__title">Common mistakes that kill citations</h2>
        <div class="content-block__body">
          <ul>
            <li>Long intros before the answer (answer must come first)</li>
            <li>Pronoun-heavy writing that breaks when extracted</li>
            <li>One mega-page trying to cover everything (instead of hub + child pages)</li>
            <li>Publishing “topical content” that isn’t structured into retrievable chunks</li>
          </ul>
        </div>
      </section>

      <section class="content-block module" style="background: #f9f9f9; border-left: 4px solid #0066cc; padding: var(--spacing-md);">
        <h2 class="content-block__title">Execution note (Neural Command / Croutons)</h2>
        <div class="content-block__body">
          <p>At Neural Command, we treat Bing’s AI Performance data as a content engineering input: map grounding queries to page sections, inject retrieval-first answer blocks, then build fan-out ladders so the site becomes a network of citeable chunks instead of isolated pages. If you want that system operationalized across your site, that’s what we build at <a href="<?= htmlspecialchars(absolute_url('/en-us/')) ?>">nrlc.ai</a> and within our Croutons approach.</p>
          <p><a href="<?= htmlspecialchars(absolute_url('/en-us/book/')) ?>" class="btn btn--primary">Book a consultation</a></p>
        </div>
      </section>

      <section id="faq" class="content-block module" itemscope itemtype="https://schema.org/FAQPage">
        <h2 class="content-block__title">Frequently asked questions</h2>
        <div class="content-block__body">
          <dl>
            <?php foreach ($faqItems as $faq): ?>
            <dt><strong><?= htmlspecialchars($faq['q']) ?></strong></dt>
            <dd><?= htmlspecialchars($faq['a']) ?></dd>
            <?php endforeach; ?>
          </dl>
        </div>
      </section>

      <footer id="sources" class="content-block module">
        <h2 class="content-block__title">Sources</h2>
        <div class="content-block__body">
          <ul>
            <li>Microsoft Bing Webmaster Blog: “Introducing AI Performance in Bing Webmaster Tools (Public Preview)” (Feb 2026).</li>
            <li>Bing Webmaster Tools Help: “AI Performance” documentation.</li>
            <li>Search Engine Land: coverage of Bing Webmaster Tools AI Performance report.</li>
            <li>Search Engine Journal: coverage of AI citation performance data and grounding queries.</li>
            <li>SEMrush: explanation of query fan-out in AI search systems.</li>
            <li>iPullRank and Suso Digital: practical descriptions of query fan-out and how it expands one prompt into many sub-queries.</li>
          </ul>
        </div>
      </footer>

    </article>

  </div>
</section>
</main>
