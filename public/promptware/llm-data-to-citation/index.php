<?php
declare(strict_types=1);

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/schema_builders.php';
require_once __DIR__.'/../../../lib/hreflang.php';

$brand   = 'NRLC.ai';
$domain  = 'https://nrlc.ai';
$contact = 'team@nrlc.ai';

$title = 'LLM Data-to-Citation Guide — How Schema & NDJSON Earn Citations';
$desc  = 'A practical playbook for turning your site\'s schema and NDJSON into citations inside LLM answers and AI Overviews.';
$slug  = 'llm-data-to-citation';
$url   = $domain . '/promptware/' . $slug . '/';

// Set page slug for metadata
$GLOBALS['__page_slug'] = 'promptware/llm-data-to-citation';

// Set metadata in router format
$GLOBALS['__page_meta'] = [
  'title' => $title,
  'description' => $desc,
  'canonicalPath' => '/promptware/llm-data-to-citation/'
];
// Legacy format for backwards compatibility
// Override metadata for this page
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $desc;

// Note: head.php and header.php are already included by render_page() in router.php
// Only include the shared style
include __DIR__.'/../_shared_style.php';
?>

<main class="container">
  <header>
    <nav aria-label="breadcrumb">
      <a href="/">Home</a> › <a href="/promptware/">Promptware</a> › LLM Data-to-Citation Guide
    </nav>
    <h1>LLM Data-to-Citation Guide</h1>
    <p>How to turn <strong>schema</strong> and <strong>NDJSON</strong> into <strong>citations</strong> in LLM answers and AI Overviews.</p>
  </header>

  <section id="why" aria-labelledby="why-h">
    <h2 id="why-h">Why citations happen</h2>
    <p>LLMs cite when a retrieval step fetches a verifiable passage tied to a stable URL. JSON-LD on page and an AI manifest (<code>/sitemaps/sitemap-ai.ndjson</code>) make that mapping explicit and cheap.</p>
  </section>

  <section id="ndjson" aria-labelledby="ndjson-h">
    <h2 id="ndjson-h">Publish token-lean facts via NDJSON</h2>
    <p>Expose compact JSON-LD objects (one per line) summarizing key pages/entities. Link it from <code>robots.txt</code> with an <strong>AI-Manifest</strong> line.</p>
    <pre><code>{"@context":"https://schema.org","@type":"WebPage","url":"<?= htmlspecialchars($domain) ?>/","name":"NRLC.ai — Home","inLanguage":"en","dateModified":"<?= date('Y-m-d') ?>"}
{"@context":"https://schema.org","@type":"TechArticle","url":"<?= htmlspecialchars($url) ?>","name":"LLM Data-to-Citation Guide","inLanguage":"en","dateModified":"<?= date('Y-m-d') ?>","keywords":["NDJSON","schema","RAG","citations"]}</code></pre>
    <p>Stream test:</p>
    <pre><code>curl -s <?= htmlspecialchars($domain) ?>/api/stream?limit=3 | jq .</code></pre>
  </section>

  <section id="schema" aria-labelledby="schema-h">
    <h2 id="schema-h">Minimum viable schema for citations</h2>
    <ul>
      <li><code>@type</code> (e.g., <code>TechArticle</code>), <code>name</code>, <code>url</code>, <code>dateModified</code></li>
      <li><code>@id</code> (use your canonical URL with a fragment if needed)</li>
      <li><code>isPartOf</code> and <code>BreadcrumbList</code> for site context</li>
      <li>Optional <code>Dataset</code> node if you publish <code>sitemap-ai.ndjson</code> as a downloadable asset</li>
    </ul>
  </section>

  <section id="rag" aria-labelledby="rag-h">
    <h2 id="rag-h">RAG preferences you can influence</h2>
    <ol>
      <li>Serve fast NDJSON with <code>Content-Type: application/x-ndjson</code> and long-lived cache for static files.</li>
      <li>Keep page prose concise; move machine details to JSON-LD to reduce tokens.</li>
      <li>Link your canonical "reference pages" from relevant sections to increase retrieval odds.</li>
    </ol>
    <p>See also: <a href="/promptware/json-stream-seo-ai/">JSON Stream + SEO AI</a></p>
  </section>

  <section id="faq" aria-labelledby="faq-h">
    <h2 id="faq-h">FAQ</h2>
    <details>
      <summary>Does Google still render HowTo/FAQ rich results?</summary>
      <p>Eligibility is limited, but the markup still improves machine understanding and RAG mapping. Keep it.</p>
    </details>
    <details>
      <summary>Where do I declare the AI manifest?</summary>
      <p>Add an <code>AI-Manifest:</code> line in <code>/public/robots.txt</code> pointing to <code>/sitemaps/sitemap-ai.ndjson</code>.</p>
    </details>
  </section>

  <footer>
    <p>© <span id="y"></span> <?= htmlspecialchars($brand) ?> • Contact: <?= htmlspecialchars($contact) ?></p>
  </footer>
</main>
<script>document.getElementById('y').textContent=new Date().getFullYear();</script>

<!-- Combined JSON-LD graph (rich results + LLM comprehension) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@graph":[
    {
      "@type":"WebPage",
      "@id":"<?= htmlspecialchars($url) ?>#webpage",
      "url":"<?= htmlspecialchars($url) ?>",
      "name":"<?= htmlspecialchars($title) ?>",
      "description":"<?= htmlspecialchars($desc) ?>",
      "inLanguage":"en",
      "isPartOf":{"@id":"<?= htmlspecialchars($domain) ?>/#website"},
      "breadcrumb":{"@id":"<?= htmlspecialchars($url) ?>#breadcrumb"}
    },
    {
      "@type":"TechArticle",
      "@id":"<?= htmlspecialchars($url) ?>#article",
      "headline":"<?= htmlspecialchars($title) ?>",
      "about":["NDJSON","schema","RAG","citations"],
      "author":{"@type":"Organization","name":"<?= htmlspecialchars($brand) ?>"},
      "publisher":{"@type":"Organization","name":"<?= htmlspecialchars($brand) ?>"},
      "datePublished":"<?= date('Y-m-d') ?>",
      "dateModified":"<?= date('Y-m-d') ?>",
      "mainEntityOfPage":{"@id":"<?= htmlspecialchars($url) ?>#webpage"}
    },
    {
      "@type":"BreadcrumbList",
      "@id":"<?= htmlspecialchars($url) ?>#breadcrumb",
      "itemListElement":[
        {"@type":"ListItem","position":1,"name":"Home","item":"<?= htmlspecialchars($domain) ?>/"},
        {"@type":"ListItem","position":2,"name":"Promptware","item":"<?= htmlspecialchars($domain) ?>/promptware/"},
        {"@type":"ListItem","position":3,"name":"LLM Data-to-Citation Guide","item":"<?= htmlspecialchars($url) ?>"}
      ]
    },
    {
      "@type":"FAQPage",
      "@id":"<?= htmlspecialchars($url) ?>#faq",
      "mainEntity":[
        {"@type":"Question","name":"Does Google still render HowTo/FAQ rich results?","acceptedAnswer":{"@type":"Answer","text":"Eligibility is limited, but the markup still improves machine understanding and RAG mapping."}},
        {"@type":"Question","name":"Where do I declare the AI manifest?","acceptedAnswer":{"@type":"Answer","text":"Add an AI-Manifest line in robots.txt pointing to /sitemaps/sitemap-ai.ndjson."}}
      ]
    },
    {
      "@type":"SoftwareSourceCode",
      "@id":"<?= htmlspecialchars($url) ?>#code",
      "name":"NRLC.ai Promptware — JSON Stream + SEO AI",
      "codeRepository":"<?= htmlspecialchars($domain) ?>/promptware/json-stream-seo-ai/",
      "programmingLanguage":"PHP",
      "runtimePlatform":"PHP 8+",
      "license":"https://opensource.org/licenses/MIT"
    },
    {
      "@type":"Dataset",
      "@id":"<?= htmlspecialchars($domain) ?>/sitemaps/sitemap-ai.ndjson#dataset",
      "name":"NRLC.ai AI Manifest (NDJSON)",
      "description":"Compact JSON-LD rows for site pages, services, and insights optimized for LLM/RAG ingestion and AI engine citation mapping. Each NDJSON line contains structured metadata (name, URL, dateModified, keywords) to enable fast retrieval and accurate citations in AI Overviews and LLM responses.",
      "creator":{"@type":"Organization","name":"<?= htmlspecialchars($brand) ?>"},
      "distribution":[{"@type":"DataDownload","encodingFormat":"application/x-ndjson","contentUrl":"<?= htmlspecialchars($domain) ?>/sitemaps/sitemap-ai.ndjson"}],
      "license":"https://opensource.org/licenses/MIT"
    },
    {
      "@type":"WebSite",
      "@id":"<?= htmlspecialchars($domain) ?>/#website",
      "url":"<?= htmlspecialchars($domain) ?>/",
      "name":"<?= htmlspecialchars($brand) ?>",
      "potentialAction":{"@type":"SearchAction","target":"<?= htmlspecialchars($domain) ?>/search?q={query}","query-input":"required name=query"}
    }
  ]
}</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>

