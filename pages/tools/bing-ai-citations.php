<?php
/**
 * Bing AI Citations: How to Use Grounding Queries + Cited Pages to Get Cited More
 * Landing page for Bing's AI Performance report — citation-friendly, full schema, CTA Neural Command + Croutons.
 */
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

$GLOBALS['__page_slug'] = 'tools/bing-ai-citations';
$canonicalUrl = absolute_url('/en-us/tools/bing-ai-citations/');
$domain = 'https://nrlc.ai';

$faqItems = [
  ['q' => 'Does this report show clicks from AI answers?', 'a' => 'The AI Performance report focuses on citations activity, cited pages, grounding queries, and trends. For conversion tracking, use analytics and landing page engagement.'],
  ['q' => 'What does "breadth" mean?', 'a' => 'Breadth is the number of unique URLs from your site that get cited in AI answers over a period. More breadth means a larger citation footprint.'],
];

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'Bing AI Citations: How to Use Grounding Queries + Cited Pages to Get Cited More',
    'description' => 'Bing\'s AI Performance report shows which pages get cited and the grounding queries that triggered retrieval. Exact workflow to turn that data into citeable content.',
    'isPartOf' => ['@id' => $domain . '#website'],
    'inLanguage' => 'en-US',
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain . '/en-us/'],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Tools', 'item' => $domain . '/en-us/tools/'],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Bing AI Citations', 'item' => $canonicalUrl],
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

    <article>
      <header class="content-block module" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);">
        <h1 class="content-block__title">Bing AI Citations: How to Use Grounding Queries + Cited Pages to Get Cited More</h1>
        <div class="content-block__body">
          <p class="lead">Bing’s <strong>AI Performance report</strong> (inside Bing Webmaster Tools) shows two things that matter for AI visibility: <strong>which pages get cited</strong> in AI answers and the <strong>grounding queries</strong> that triggered retrieval. This page gives you the exact workflow to turn that data into citeable content.</p>
          <p>If you want the video walkthrough, watch it here:</p>
          <div class="video-embed-placeholder" style="min-height: 200px; background: #eee; border: 1px dashed #999; padding: 2rem; text-align: center; color: #666;">
            <!-- Replace with your YouTube embed: <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID" ...></iframe> -->
            <p style="margin: 0;">Add your YouTube embed above this comment in the template.</p>
          </div>
        </div>
      </header>

      <section class="content-block module">
        <h2 class="content-block__title">What the Bing AI Performance report shows</h2>
        <div class="content-block__body">
          <h3>Cited Pages</h3>
          <p><strong>Cited Pages</strong> are the URLs from your site that Bing/Copilot AI answers referenced as sources.</p>
          <p>Use this to find:</p>
          <ul>
            <li>Your current “AI winners” (the pages already being cited)</li>
            <li>Which topics your site is trusted for</li>
            <li>Where citations are concentrated (risk) vs spread out (opportunity)</li>
          </ul>

          <h3>Grounding Queries</h3>
          <p><strong>Grounding queries</strong> are the phrases Bing’s AI used to retrieve sources before generating the answer.</p>
          <p>Use this to find:</p>
          <ul>
            <li>The exact intents the AI is trying to satisfy</li>
            <li>The angles you’re missing (questions you should answer explicitly)</li>
            <li>Which sections of your pages should be rewritten into clean answer blocks</li>
          </ul>
        </div>
      </section>

      <section class="content-block module">
        <h2 class="content-block__title">The 8-step workflow to turn citations data into citeable content</h2>
        <div class="content-block__body">

          <h3>Step 1: Export your AI citations data</h3>
          <p>In <strong>Bing Webmaster Tools → AI Performance</strong>:</p>
          <ul>
            <li>Export Cited Pages</li>
            <li>Export Grounding Queries</li>
          </ul>
          <p>Do this for: <strong>Last 28 days</strong> (stable patterns) and <strong>Last 7 days</strong> (fresh demand).</p>

          <h3>Step 2: Build a URL ↔ Query mapping sheet</h3>
          <p>Create a simple table:</p>
          <p><strong>URL | Grounding query | Matching section (heading) | Answer block exists? | Fix type</strong></p>
          <p><strong>Fast method:</strong></p>
          <ul>
            <li>Open the URL</li>
            <li>Ctrl+F for the key nouns in the query</li>
            <li>Find the section that should answer it</li>
            <li>If there’s no clean answer, mark it “Missing”</li>
          </ul>

          <h3>Step 3: Score each row (don’t rewrite randomly)</h3>
          <p>Label each URL↔Query row:</p>
          <ul>
            <li><strong>A) Winner:</strong> cited and clear already</li>
            <li><strong>B) Cited but weak:</strong> cited, but answer is buried or vague</li>
            <li><strong>C) Missing answer:</strong> query matches, no clean answer exists</li>
            <li><strong>D) Wrong page:</strong> query belongs on a different URL</li>
          </ul>

          <h3>Step 4: Apply the 4 upgrades that reliably improve citeability</h3>

          <p><strong>Upgrade 1: Answer Block Injection (B + C)</strong><br>For each repeated grounding query intent:</p>
          <ul>
            <li>Add an H2/H3 heading that mirrors the intent</li>
            <li>Add a 1–3 sentence direct answer immediately under it</li>
            <li>Add 3–7 bullet facts (steps, limits, requirements, menu paths)</li>
          </ul>
          <p><strong>Placement rule:</strong> Put at least one answer block in the top 20–30% of the page.</p>

          <p><strong>Upgrade 2: Chunk Mirror (B)</strong><br>If the answer exists but is buried:</p>
          <ul>
            <li>Duplicate the best paragraph into a “Quick answer” block near the top</li>
            <li>Tighten it (shorter sentences, fewer pronouns, more proper nouns)</li>
            <li>Keep the original section too</li>
          </ul>

          <p><strong>Upgrade 3: Page Routing (D)</strong><br>When Bing is citing the wrong page:</p>
          <ul>
            <li>Add a top-of-page line on the wrong page: “For the definitive answer on X, see: [Correct URL].”</li>
            <li>Add 2–5 internal links to the correct URL with intent-matching anchor text</li>
            <li>Strengthen canonicals and navigation toward the correct page</li>
          </ul>

          <p><strong>Upgrade 4: Citation Ladder Expansion (A)</strong><br>Turn one winner page into a citation network:</p>
          <ul>
            <li>Take 1 top cited page (hub)</li>
            <li>Select 10–30 grounding queries that are narrow variants</li>
            <li>Create child pages (or child sections) for each cluster</li>
            <li>Interlink hub ↔ children</li>
          </ul>
          <p>This grows your citation footprint (more distinct URLs can be cited).</p>

          <h3>Step 5: Turn grounding queries into a content roadmap (no guessing)</h3>
          <p>Cluster grounding queries by intent:</p>
          <ul>
            <li>Definition (“what is”)</li>
            <li>How-to / steps</li>
            <li>Requirements / eligibility</li>
            <li>Cost / pricing / limits</li>
            <li>Comparisons / alternatives / best</li>
            <li>Troubleshooting / errors</li>
            <li>Use cases / scenarios</li>
          </ul>
          <p><strong>Decision rule:</strong> Repeats weekly → become a heading or a new child page. One-offs → become a short section.</p>

          <h3>Step 6: Add freshness only when the data demands it</h3>
          <p>If grounding queries include: latest, new, 2026, update, cost, pricing, requirements</p>
          <ul>
            <li>Add “Updated: Month Day, Year” near the first answer block</li>
            <li>Add a 3-bullet “What changed” mini-changelog</li>
          </ul>

          <h3>Step 7: Measure the right outcome (weekly)</h3>
          <p>Track:</p>
          <ul>
            <li>Total citations</li>
            <li>Unique cited pages (how many distinct URLs are getting cited)</li>
            <li>New URLs entering the cited list</li>
            <li>Shifts in grounding query volume</li>
          </ul>
          <p>If citations rise but unique cited pages stay flat, you’re improving a small set of pages but not expanding coverage.</p>

          <h3>Step 8: Use the 3-minute citeability checklist before publishing</h3>
          <p>For every new/edited answer block, first ~150 words must include:</p>
          <ul>
            <li>the full subject noun (entity name)</li>
            <li>a direct answer</li>
            <li>at least 3 concrete facts</li>
          </ul>
          <p>Heading mirrors the intent. Bullets are standalone sentences. No fluff before the first answer.</p>
        </div>
      </section>

      <section class="content-block module">
        <h2 class="content-block__title">Templates you can paste into any page</h2>
        <div class="content-block__body">
          <h3>Template A: AI Answer Block (grounding-ready)</h3>
          <pre style="background:#f5f5f5;padding:1rem;overflow:auto;font-size:0.9rem;">H2/H3: [Intent-aligned heading]
Direct answer (1–3 sentences).
Bullets (3–7):
• Fact 1 (complete sentence, includes the subject noun)
• Fact 2
• Fact 3
Optional:
• “When this doesn’t apply” (1–2 sentences)
• “Sources / references” (2–5 authoritative links)</pre>

          <h3>Template B: Fan-out child page (discovery-ready)</h3>
          <pre style="background:#f5f5f5;padding:1rem;overflow:auto;font-size:0.9rem;">H1: [Narrow intent / constraint]
Two-sentence answer.
Criteria bullets (5–9).
Mini-table: Option | Best for | Tradeoff.
FAQ (3–6).
Link back to hub: “See the full guide: [Hub URL].”</pre>
        </div>
      </section>

      <section id="faq" class="content-block module" itemscope itemtype="https://schema.org/FAQPage">
        <h2 class="content-block__title">FAQ</h2>
        <div class="content-block__body">
          <dl>
            <dt><strong><?= htmlspecialchars($faqItems[0]['q']) ?></strong></dt>
            <dd><?= htmlspecialchars($faqItems[0]['a']) ?></dd>
            <dt><strong><?= htmlspecialchars($faqItems[1]['q']) ?></strong></dt>
            <dd><?= htmlspecialchars($faqItems[1]['a']) ?></dd>
          </dl>
        </div>
      </section>

      <section class="content-block module" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md);">
        <h2 class="content-block__title">Want this implemented across your site?</h2>
        <div class="content-block__body">
          <p><strong>Neural Command</strong> builds systems that turn websites into AI-retrievable, citeable knowledge assets.</p>
          <ul>
            <li><strong>Neural Command:</strong> <a href="<?= htmlspecialchars(absolute_url('/en-us/')) ?>">nrlc.ai</a></li>
            <li><strong>Croutons:</strong> <a href="https://croutons.ai" rel="noopener noreferrer">croutons.ai</a></li>
          </ul>
          <p>If you want a fast start, send us:</p>
          <ul>
            <li>Your top 25 cited pages export</li>
            <li>Your top 100 grounding queries export</li>
          </ul>
          <p>…and we’ll return an action plan: per-URL edits, answer blocks to insert, and the child pages to spawn.</p>
          <p><a href="<?= htmlspecialchars(absolute_url('/en-us/book/')) ?>" class="btn btn--primary">Book a consultation</a></p>
        </div>
      </section>

    </article>

  </div>
</section>
</main>
