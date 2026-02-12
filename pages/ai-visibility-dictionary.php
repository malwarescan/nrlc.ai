<?php
/**
 * AI Visibility Dictionary — canonical definitions for AI search visibility, citations, and retrieval.
 * SEO: full meta, canonical, DefinedTermSet + WebPage + BreadcrumbList schema. Anchor-linked TOC.
 */
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/schema_builders.php';

$locale = current_locale();
$canonicalUrl = absolute_url("/{$locale}/ai-visibility-dictionary/");
$domain = 'https://nrlc.ai';

$GLOBALS['__page_slug'] = 'ai-visibility-dictionary';

$terms = [
  ['id' => 'breadth', 'name' => 'Breadth', 'def' => 'Breadth is the number of distinct topics, entities, and query clusters your site covers in a way that can be retrieved and summarized by AI systems.', 'example' => 'A DNS cluster that includes TTL, MX priority, propagation, DoH vs DoT, and dig commands has more breadth than a single "DNS basics" article.', 'so_what' => 'Breadth increases the number of entry points where AI systems can discover and cite you across a topic area.'],
  ['id' => 'depth', 'name' => 'Depth', 'def' => 'Depth is how completely a single topic is answered, including steps, edge cases, examples, and failure modes.', 'example' => 'A TLS guide that includes certificate types, common misconfigurations, renewal strategy, and troubleshooting is deeper than a definition-only page.', 'so_what' => 'Depth increases the chance your page is selected as the "best single source" for a query.'],
  ['id' => 'grounding-query', 'name' => 'Grounding query', 'def' => 'A grounding query is a search an AI system runs to confirm facts from sources before producing an answer.', 'example' => 'For "DoH vs DoT," the system may run grounding queries like "DoH vs DoT privacy performance differences" to fetch authoritative explanations.', 'so_what' => 'If your page aligns with grounding queries, you get retrieved more often and cited more consistently.'],
  ['id' => 'fan-out-query', 'name' => 'Fan-out query', 'def' => 'A fan-out query is a follow-up query an AI system runs to expand coverage around the main question (related subtopics, alternatives, definitions).', 'example' => 'After retrieving "DoH vs DoT," it may fan out to "DNS leakage," "enterprise policy," or "mobile captive portals."', 'so_what' => 'Fan-out coverage is where breadth wins; it\'s how you show up across the surrounding questions.'],
  ['id' => 'citation-surface', 'name' => 'Citation surface', 'def' => 'A citation surface is a URL that repeatedly gets cited by AI systems as a source for answers.', 'example' => 'A "Best domain marketplaces" page becomes a citation surface if it\'s referenced across many marketplace-related prompts.', 'so_what' => 'Citation surfaces are your distribution hubs; improving them multiplies impact.'],
  ['id' => 'citation-gravity', 'name' => 'Citation gravity', 'def' => 'Citation gravity is the compounding effect where already-cited pages keep getting cited more because they\'re repeatedly selected and reinforced.', 'example' => 'A hub page that\'s cited in many answers becomes the default retrieval target for that topic.', 'so_what' => 'Protect and refresh pages with citation gravity; they\'re compounding assets.'],
  ['id' => 'citation-piggybacking', 'name' => 'Citation piggybacking', 'def' => 'Citation piggybacking is routing new pages through already-cited pages by adding a tight, relevant section and a small number of internal links near the top.', 'example' => 'Add "New in 2026: Marketplace safety checklist" with a link to your new checklist article inside a highly cited marketplace guide.', 'so_what' => 'It accelerates discovery, crawling, and AI selection for new content.'],
  ['id' => 'chunking', 'name' => 'Chunking', 'def' => 'Chunking is how search and AI systems split a page into retrievable sections.', 'example' => 'A long article may be retrieved as separate passages: definition, steps, FAQ, troubleshooting.', 'so_what' => 'You must write sections that stand alone; weak chunking reduces citations.'],
  ['id' => 'citation-chunk', 'name' => 'Citation chunk', 'def' => 'A citation chunk is a section engineered to be quoted: direct answer, explicit entities, one concrete example, and why it matters.', 'example' => 'An H2 that defines "MX priority," shows a sample record, then explains what breaks if mis-set.', 'so_what' => 'Strong citation chunks increase liftability and attribution.'],
  ['id' => 'prechunking', 'name' => 'Prechunking', 'def' => 'Prechunking is writing content so the "chunks" are already optimal before systems split them.', 'example' => 'Each H2 includes a 1–2 sentence answer, an example, and a "so what" line.', 'so_what' => 'Prechunking improves retrieval success and reduces summarization errors.'],
  ['id' => 'retrieval-window', 'name' => 'Retrieval window', 'def' => 'The retrieval window is the limited amount of source text the AI can bring into context for answering.', 'example' => 'The system may retrieve a few passages from 3–10 pages, not entire sites.', 'so_what' => 'If your key answer isn\'t early and self-contained, it may never enter the window.'],
  ['id' => 'attention-window', 'name' => 'Attention window', 'def' => 'The attention window is the smaller subset of retrieved text that actually influences the final answer most.', 'example' => 'The model may focus heavily on the first clean definition it sees and ignore later paragraphs.', 'so_what' => 'Put the best answer first and keep it compact.'],
  ['id' => 'entity-salience', 'name' => 'Entity salience', 'def' => 'Entity salience is how clearly your page signals the primary entities involved (products, protocols, standards, tools, brands).', 'example' => 'A page that repeatedly names "DoH," "DoT," "TLS," "DNS resolver," and "RFC" has stronger salience than vague wording.', 'so_what' => 'High salience improves correct retrieval and reduces mismatch.'],
  ['id' => 'entity-disambiguation', 'name' => 'Entity disambiguation', 'def' => 'Entity disambiguation is removing ambiguity so the AI knows which "X" you mean.', 'example' => '"Domain registry (Verisign) vs domain registrar (NameSilo)" prevents confusion with generic "registration."', 'so_what' => 'Disambiguation prevents wrong retrieval and wrong summaries.'],
  ['id' => 'entity-graph', 'name' => 'Entity graph', 'def' => 'An entity graph is the network of relationships among entities on your site (orgs, products, concepts, locations, attributes).', 'example' => 'Domain marketplace ↔ escrow ↔ transfer lock ↔ WHOIS privacy ↔ registrar policies.', 'so_what' => 'Strong graphs help AI systems understand coverage and trustworthiness.'],
  ['id' => 'canonical-cluster', 'name' => 'Canonical cluster', 'def' => 'A canonical cluster is a set of near-duplicate URLs where one should be the authoritative canonical.', 'example' => '/pricing and /pricing?rid=123 are duplicates that should resolve to one canonical URL.', 'so_what' => 'Canonical clusters dilute signals and citations unless consolidated.'],
  ['id' => 'param-pollution', 'name' => 'Param pollution', 'def' => 'Param pollution is when URL parameters create indexable duplicates that split ranking and citation signals.', 'example' => 'Tracking params create multiple versions of the homepage that get cited instead of the clean URL.', 'so_what' => 'Fixing param pollution concentrates authority and improves consistent citations.'],
  ['id' => 'index-bloat', 'name' => 'Index bloat', 'def' => 'Index bloat is having too many low-value pages indexed, reducing crawl efficiency and overall site quality signals.', 'example' => 'Infinite /whois?query= variants or thin tag pages being indexed.', 'so_what' => 'Less bloat means more crawl and weight on pages that matter.'],
  ['id' => 'crawl-budget', 'name' => 'Crawl budget', 'def' => 'Crawl budget is how much crawling search engines allocate to your site over time.', 'example' => 'A site with many duplicates wastes crawl budget and gets important pages refreshed less often.', 'so_what' => 'Better crawl efficiency helps content refreshes show up faster.'],
  ['id' => 're-crawl-trigger', 'name' => 'Re-crawl trigger', 'def' => 'A re-crawl trigger is a meaningful change that increases the likelihood a page is revisited soon.', 'example' => 'Updating title/H1, adding new sections, improving internal links, and refreshing timestamps.', 'so_what' => 'Useful when you\'re trying to push updates into search and AI retrieval quickly.'],
  ['id' => 'snippetability', 'name' => 'Snippetability', 'def' => 'Snippetability is how easily text can be lifted as a clean answer without extra context.', 'example' => '"TTL controls how long resolvers cache DNS answers; lower TTL before migrations to reduce downtime."', 'so_what' => 'High snippetability increases selection in AI answers and featured snippets.'],
  ['id' => 'answer-box', 'name' => 'Answer box', 'def' => 'An answer box is a 40–60 word summary placed near the top designed for copy/paste retrieval.', 'example' => 'A single paragraph that defines a concept, states the decision rule, and includes a constraint.', 'so_what' => 'This is the most "quotable" unit on a page.'],
  ['id' => 'source-grounding', 'name' => 'Source grounding', 'def' => 'Source grounding is when an AI ties its claims to retrieved sources rather than model memory.', 'example' => 'It cites a page for "DoH vs DoT" instead of guessing.', 'so_what' => 'Grounding is where citations come from; your goal is to be the grounded source.'],
  ['id' => 'hallucination-pressure', 'name' => 'Hallucination pressure', 'def' => 'Hallucination pressure is when the system is forced to guess because sources are missing, vague, or contradictory.', 'example' => 'A page that never gives concrete steps causes the model to improvise.', 'so_what' => 'Reduce hallucination pressure with explicit steps, examples, and definitions.'],
  ['id' => 'query-framing', 'name' => 'Query framing', 'def' => 'Query framing is structuring queries with entities, constraints, and context to force better retrieval.', 'example' => '"DoH vs DoT for enterprise networks: performance, policy control, and security tradeoffs."', 'so_what' => 'Framing determines what sources get pulled in.'],
  ['id' => 'query-expansion', 'name' => 'Query expansion', 'def' => 'Query expansion is adding related terms and synonyms to broaden retrieval coverage.', 'example' => '"WHOIS privacy" + "domain privacy" + "redacted WHOIS" + "ICANN policy."', 'so_what' => 'Expansion helps you cover variations and long-tail prompts.'],
  ['id' => 'freshness-bias', 'name' => 'Freshness bias', 'def' => 'Freshness bias is a preference for newer sources when topics change quickly.', 'example' => 'A "2026 marketplace" update can outrank and out-cite a "2024" guide.', 'so_what' => 'Refresh top citation surfaces on a predictable cadence.'],
  ['id' => 'content-decay', 'name' => 'Content decay', 'def' => 'Content decay is performance loss over time as information becomes outdated or competitors publish stronger answers.', 'example' => 'A "2025 trends" page stops being cited when 2026 sources exist.', 'so_what' => 'Refresh prevents decay and preserves citation gravity.'],
  ['id' => 'provenance', 'name' => 'Provenance', 'def' => 'Provenance is the traceable origin of a claim: who said it, where, and when.', 'example' => 'Citing official protocol docs, policy pages, or primary sources for rules and standards.', 'so_what' => 'Strong provenance increases trust and citation likelihood.'],
  ['id' => 'attribution-likelihood', 'name' => 'Attribution likelihood', 'def' => 'Attribution likelihood is how often an AI will name your brand when it uses your content.', 'example' => 'A named framework and a clearly branded definition increases attribution vs generic phrasing.', 'so_what' => 'Attribution is the difference between "being used" and "being credited."'],
  ['id' => 'link-adjacency', 'name' => 'Link adjacency', 'def' => 'Link adjacency is how close an internal link is to the extractable answer text.', 'example' => 'A link placed immediately after an answer box is more likely to be followed than one in a footer.', 'so_what' => 'Adjacency is how you route new pages through citation surfaces.'],
  ['id' => 'distribution-hub', 'name' => 'Distribution hub', 'def' => 'A distribution hub is a page designed to send authority, crawl, and users into related pages.', 'example' => 'A DNS hub that links to TTL, MX priority, propagation, and troubleshooting guides.', 'so_what' => 'Hubs turn one strong surface into many strong pages.'],
  ['id' => 'topical-moat', 'name' => 'Topical moat', 'def' => 'A topical moat is owning a dense, interlinked cluster so retrieval and citations default to your site.', 'example' => 'Multiple DNS pages with consistent internal linking and distinct coverage.', 'so_what' => 'Moats reduce competitor displacement.'],
  ['id' => 'zero-click-capture', 'name' => 'Zero-click capture', 'def' => 'Zero-click capture is winning exposure through AI answers/snippets even when users don\'t click.', 'example' => 'Being cited or named inside the AI response.', 'so_what' => 'Visibility becomes brand demand and downstream conversion.'],
  ['id' => 'citation-share', 'name' => 'Citation share', 'def' => 'Citation share is your proportion of citations in a topic cluster versus competitors.', 'example' => '40% of cited sources for "domain marketplaces" come from your site.', 'so_what' => 'Citation share is the KPI for AI visibility dominance.'],
  ['id' => 'retrieval-share', 'name' => 'Retrieval share', 'def' => 'Retrieval share is how often your pages are retrieved as sources, even if not always cited.', 'example' => 'Your page is frequently fetched but another page is the one cited.', 'so_what' => 'Improving snippetability and provenance can turn retrieval into citations.'],
];

// Meta (router may set; page reinforces for head)
if (!isset($GLOBALS['__page_meta']) || !is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta'] = [];
}
$GLOBALS['__page_meta']['canonicalPath'] = "/{$locale}/ai-visibility-dictionary/";
$GLOBALS['__page_meta']['title'] = $GLOBALS['__page_meta']['title'] ?? 'AI Visibility Dictionary | Key Terms for AI Search & Citations | NRLC.ai';
$GLOBALS['__page_meta']['description'] = $GLOBALS['__page_meta']['description'] ?? 'Definitions for grounding queries, citation surfaces, prechunking, retrieval share, and 35+ terms used in AI search visibility and AI citations. Canonical reference for teams.';
$GLOBALS['__page_meta']['keywords'] = 'AI visibility dictionary, grounding query, fan-out query, citation surface, citation gravity, prechunking, snippetability, answer box, retrieval share, citation share, AI search terminology, AEO glossary';

// DefinedTermSet schema (all terms)
$definedTerms = array_map(function ($t) {
  return [
    '@type' => 'DefinedTerm',
    'name' => $t['name'],
    'description' => $t['def'],
  ];
}, $terms);

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'AI Visibility Dictionary',
    'description' => 'Definitions for AI search visibility, AI citations, and retrieval-based ranking. Each entry is written to be liftable by AI systems: direct definition, concrete example, and when it matters.',
    'isPartOf' => ['@id' => $domain . '#website'],
    'inLanguage' => 'en-US',
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain . '/en-us/'],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Visibility Dictionary', 'item' => $canonicalUrl],
    ],
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'DefinedTermSet',
    '@id' => $canonicalUrl . '#definedtermset',
    'name' => 'AI Visibility Dictionary',
    'description' => 'Definitions for AI search visibility, grounding queries, fan-out retrieval, citation surfaces, prechunking, and related SEO/AEO terminology.',
    'inLanguage' => 'en',
    'hasDefinedTerm' => $definedTerms,
  ],
];
?>

<main role="main" class="container">
  <article class="content-block module" itemscope itemtype="https://schema.org/DefinedTermSet">
    <header class="section">
      <h1 class="content-block__title" itemprop="name">AI Visibility Dictionary</h1>

      <div class="content-block__body" style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);">
        <p class="lead" style="margin: 0;">This dictionary defines the key terms used in AI search visibility, AI citations, and retrieval-based ranking. Each entry is written to be liftable by AI systems: a direct definition, a concrete example, and a "so what" line that explains when it matters. Use this page as the canonical reference for your team's terminology.</p>
      </div>
    </header>

    <nav class="content-block module" aria-label="Table of contents">
      <h2 class="content-block__title">Table of contents</h2>
      <ul style="columns: 2; column-gap: 2rem; list-style: none; padding: 0;">
        <?php foreach ($terms as $t) : ?>
        <li style="margin-bottom: 0.35rem;"><a href="#<?php echo htmlspecialchars($t['id']); ?>"><?php echo htmlspecialchars($t['name']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <hr style="margin: var(--spacing-lg) 0;" aria-hidden="true">

    <div class="content-block__body dictionary-terms">
      <?php foreach ($terms as $t) : ?>
      <section id="<?php echo htmlspecialchars($t['id']); ?>" class="dictionary-term" style="margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid #e0e0e0;" itemscope itemtype="https://schema.org/DefinedTerm">
        <h2 class="content-block__title" style="font-size: 1.25rem;" itemprop="name"><?php echo htmlspecialchars($t['name']); ?></h2>
        <p><strong>Definition:</strong> <span itemprop="description"><?php echo htmlspecialchars($t['def']); ?></span></p>
        <p><strong>Example:</strong> <?php echo htmlspecialchars($t['example']); ?></p>
        <p><strong>So what:</strong> <?php echo htmlspecialchars($t['so_what']); ?></p>
      </section>
      <?php endforeach; ?>
    </div>

    <footer class="content-block module" style="margin-top: var(--spacing-xl); padding-top: var(--spacing-md); border-top: 1px solid #e0e0e0;">
      <p><a href="<?php echo absolute_url("/{$locale}/glossary/"); ?>">← Back to AI Search Glossary</a> | <a href="<?php echo absolute_url("/{$locale}/"); ?>">Home</a></p>
    </footer>
  </article>
</main>
