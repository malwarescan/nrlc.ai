<?php
declare(strict_types=1);

$brand = 'NRLC.ai';
$domain = 'https://nrlc.ai';

$hasHead   = is_file($_SERVER['DOCUMENT_ROOT'].'/partials/head.php');
$hasHeader = is_file($_SERVER['DOCUMENT_ROOT'].'/partials/header.php');
$hasFooter = is_file($_SERVER['DOCUMENT_ROOT'].'/partials/footer.php');

if ($hasHead) {
  include $_SERVER['DOCUMENT_ROOT'].'/partials/head.php';
} else {
  ?><!doctype html><html lang="en"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Promptware · <?= htmlspecialchars($brand) ?></title>
  <meta name="description" content="Open-source Promptware utilities from NRLC.ai: JSON streaming, AI manifests, and search optimization tooling.">
  <link rel="canonical" href="<?= htmlspecialchars($domain) ?>/promptware/">
  </head><body><?php
}
if ($hasHeader) include $_SERVER['DOCUMENT_ROOT'].'/partials/header.php';
?>

<main>
  <header>
    <h1>Promptware</h1>
    <p>Open-source, production-ready prompts + code scaffolds you can drop into your stack.</p>
  </header>

  <nav aria-label="Promptware list">
    <ul>
      <li>
        <a href="/promptware/json-stream-seo-ai/">JSON Stream + SEO AI</a>
        — NDJSON streaming API + AI manifest for LLM/RAG ingestion and internal crawlers.
      </li>
    </ul>
  </nav>

  <section aria-labelledby="usage">
    <h2 id="usage">How to use</h2>
    <ol>
      <li>Open a promptware page.</li>
      <li>Copy the Cursor one-shot section and paste into Cursor.</li>
      <li>Commit, deploy, and verify using the included commands.</li>
    </ol>
  </section>

  <footer>
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

<?php if (!$hasHead): ?></body></html><?php endif; ?>

