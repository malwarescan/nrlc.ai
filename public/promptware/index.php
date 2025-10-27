<?php
declare(strict_types=1);

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/hreflang.php';

$brand = 'NRLC.ai';
$domain = 'https://nrlc.ai';

// Set page slug for metadata
$GLOBALS['__page_slug'] = 'promptware/index';

// Override metadata for this page
$GLOBALS['pageTitle'] = 'Promptware · NRLC.ai';
$GLOBALS['pageDesc'] = 'Open-source Promptware utilities from NRLC.ai: JSON streaming, AI manifests, and search optimization tooling.';

// Use site templates
include __DIR__.'/../../templates/head.php';
include __DIR__.'/../../templates/header.php';
?>

<style>
/* Mobile responsive styles */
@media (max-width: 768px) {
  main.container {
    padding: 1rem 0.5rem !important;
  }
  
  h1 {
    font-size: 1.5rem !important;
  }
  
  h2 {
    font-size: 1.25rem !important;
  }
  
  nav ul li {
    font-size: 0.875rem !important;
    margin-bottom: 1rem !important;
  }
  
  ol li {
    font-size: 0.875rem !important;
    margin-bottom: 0.75rem !important;
  }
}
</style>

<main class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
  <header style="margin-bottom: 3rem;">
    <h1>Promptware</h1>
    <p>Open-source, production-ready prompts + code scaffolds you can drop into your stack.</p>
  </header>

  <nav aria-label="Promptware list" style="margin-bottom: 3rem;">
    <ul>
      <li>
        <a href="/promptware/json-stream-seo-ai/">JSON Stream + SEO AI</a>
        — NDJSON streaming API + AI manifest for LLM/RAG ingestion and internal crawlers.
      </li>
      <li>
        <a href="/promptware/llm-data-to-citation/">LLM Data-to-Citation Guide</a>
        — How schema and NDJSON earn citations in LLM answers and AI Overviews.
      </li>
    </ul>
  </nav>

  <section aria-labelledby="usage" style="margin-bottom: 3rem;">
    <h2 id="usage">How to use</h2>
    <ol>
      <li>Open a promptware page.</li>
      <li>Copy the Cursor one-shot section and paste into Cursor.</li>
      <li>Commit, deploy, and verify using the included commands.</li>
    </ol>
  </section>

  <footer style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--border-color, #ddd);">
    <p>© <span id="y"></span> <?= htmlspecialchars($brand) ?> — Open Source Promptware.</p>
  </footer>
</main>
<script>document.getElementById('y').textContent=new Date().getFullYear();</script>

<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"Home","item":"<?= htmlspecialchars($domain) ?>/"},
    {"@type":"ListItem","position":2,"name":"Promptware","item":"<?= htmlspecialchars($domain) ?>/promptware/"}
  ]
}</script>

<?php include __DIR__.'/../../templates/footer.php'; ?>

