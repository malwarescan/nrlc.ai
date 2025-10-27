<?php
declare(strict_types=1);

require_once __DIR__.'/../../../../lib/helpers.php';
require_once __DIR__.'/../../../../lib/schema_builders.php';
require_once __DIR__.'/../../../../lib/hreflang.php';

$brand = 'NRLC.ai';
$domain = 'https://nrlc.ai';
$contact = 'team@nrlc.ai';

// Set page slug for metadata
$GLOBALS['__page_slug'] = 'promptware/json-stream-seo-ai';

// Override metadata for this page
$GLOBALS['pageTitle'] = 'JSON Stream + SEO AI · Promptware · NRLC.ai';
$GLOBALS['pageDesc'] = 'Open-source JSON streaming (NDJSON) utilities and AI manifests for LLM/RAG and internal crawlers.';

// Use site templates
include __DIR__.'/../../../../templates/head.php';
include __DIR__.'/../../../../templates/header.php';
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
  
  table {
    font-size: 0.875rem !important;
    display: block !important;
    overflow-x: auto !important;
  }
  
  thead, tbody, tr {
    display: block !important;
  }
  
  td, th {
    display: block !important;
    text-align: left !important;
    padding: 0.5rem !important;
  }
  
  th {
    border-bottom: 2px solid var(--border-color, #ddd);
    font-weight: bold;
  }
  
  td {
    border-bottom: 1px solid var(--border-color, #ddd);
  }
  
  td:before {
    content: attr(data-label) ": ";
    font-weight: bold;
  }
  
  pre {
    font-size: 0.75rem !important;
    padding: 0.75rem !important;
  }
  
  details summary {
    font-size: 0.875rem !important;
  }
}
</style>

<main class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
  <header style="margin-bottom: 3rem;">
    <h1>JSON Stream + SEO AI</h1>
    <p>NDJSON streaming API + compact AI manifest for fast ingestion by LLMs, RAG systems, and internal crawlers.</p>
  </header>

  <section aria-labelledby="files" style="margin-bottom: 3rem;">
    <h2 id="files">What this installs</h2>
    <table style="width: 100%; margin-top: 1rem;">
      <thead><tr><th>Path</th><th>Description</th></tr></thead>
      <tbody>
        <tr><td data-label="Path"><code>/api/stream</code></td><td data-label="Description">Live <code>application/x-ndjson</code> stream (one JSON-LD object per line).</td></tr>
        <tr><td data-label="Path"><code>/public/sitemaps/sitemap-ai.ndjson</code></td><td data-label="Description">AI manifest (NDJSON). Built from CSV.</td></tr>
        <tr><td data-label="Path"><code>/scripts/build_ai_manifest.php</code></td><td data-label="Description">CSV → NDJSON generator.</td></tr>
        <tr><td data-label="Path"><code>/scripts/verify_ndjson.sh</code></td><td data-label="Description">Verifier using <code>jq</code>.</td></tr>
        <tr><td data-label="Path"><code>/Makefile</code></td><td data-label="Description">Convenience targets to build/verify/test.</td></tr>
        <tr><td data-label="Path"><code>/public/robots.txt</code></td><td data-label="Description">Adds <code>AI-Manifest:</code> discovery line.</td></tr>
        <tr><td data-label="Path"><code>/public/.htaccess</code></td><td data-label="Description">NDJSON headers + cache policy (Apache).</td></tr>
      </tbody>
    </table>
  </section>

  <section aria-labelledby="cursor" style="margin-bottom: 3rem;">
    <h2 id="cursor">Cursor one-shot</h2>
    <details open><summary>Open to copy</summary>
<pre style="padding: 1rem; background: var(--background-color, #fff); border: 1px solid var(--border-color, #ddd); overflow-x: auto; max-height: 600px; overflow-y: auto; word-wrap: break-word; white-space: pre-wrap;"><code style="word-wrap: break-word; white-space: pre-wrap;">You are editing a PHP 8+ project named "NRLC.ai". Create/overwrite the files below EXACTLY as specified. After writing, run `php -l` on all PHP files and print:

DONE: Promptware — JSON Stream + SEO AI (Style-Agnostic) installed.

1) STREAMING API (NDJSON; no buffering)
Create file: public/api/stream/index.php
&lt;?php
declare(strict_types=1);
header('Content-Type: application/x-ndjson; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('X-Accel-Buffering: no');
@ini_set('output_buffering','off'); @ini_set('zlib.output_compression','0'); @ob_implicit_flush(true); while (ob_get_level()&gt;0) ob_end_flush();
$domain='https://nrlc.ai'; $limit=isset($_GET['limit'])?max(1,min(500,(int)$_GET['limit'])):10;
$rows=[
  ["@context"=>"https://schema.org","@type"=>"WebPage","url"=>$domain."/","name"=>"NRLC.ai — Home","inLanguage"=>"en","dateModified"=>date('Y-m-d')],
  ["@context"=>"https://schema.org","@type"=>"CreativeWork","url"=>$domain."/promptware/","name"=>"Promptware","about"=>["NDJSON","AI manifest","RAG","LLMO"],"dateModified"=>date('Y-m-d')],
  ["@context"=>"https://schema.org","@type"=>"HowTo","url"=>$domain."/promptware/json-stream-seo-ai/","name"=>"JSON Stream + SEO AI","totalTime"=>"PT20M","dateModified"=>date('Y-m-d')],
];
$c=0; foreach($rows as $r){ if($c&gt;=$limit) break; echo json_encode($r,JSON_UNESCAPED_SLASHES)."\n"; $c++; usleep(150000);} exit;

2) AI MANIFEST (seed rows; build can overwrite)
Create file: public/sitemaps/sitemap-ai.ndjson
{"@context":"https://schema.org","@type":"WebPage","url":"https://nrlc.ai/","name":"Home","inLanguage":"en","dateModified":"2025-10-27"}
{"@context":"https://schema.org","@type":"CollectionPage","url":"https://nrlc.ai/promptware/","name":"Promptware","inLanguage":"en","dateModified":"2025-10-27"}
{"@context":"https://schema.org","@type":"TechArticle","url":"https://nrlc.ai/promptware/json-stream-seo-ai/","name":"JSON Stream + SEO AI","inLanguage":"en","dateModified":"2025-10-27","keywords":["NDJSON","AI manifest","LLM seeding","RAG"]}

3) CSV → NDJSON builder
Create file: scripts/build_ai_manifest.php
&lt;?php
declare(strict_types=1);
$csv=__DIR__.'/../data/ai_manifest_seed.csv'; $out=__DIR__.'/../public/sitemaps/sitemap-ai.ndjson';
if(!is_file($csv)){ @mkdir(dirname($csv),0775,true); file_put_contents($csv,"url,name,type,lang,lastmod,keywords\nhttps://nrlc.ai/,NRLC.ai — Home,WebPage,en,".date('Y-m-d').",brand\n"); }
$fp=fopen($csv,'r'); $hdr=fgetcsv($fp); @mkdir(dirname($out),0775,true); $fo=fopen($out,'w');
while(($row=fgetcsv($fp))!==false){ $rec=array_combine($hdr,$row);
  $obj=["@context"=>"https://schema.org","@type"=>$rec['type']?:'WebPage',"url"=>$rec['url'],"name"=>$rec['name'],"inLanguage"=>$rec['lang']?:'en',"dateModified"=>$rec['lastmod']?:date('Y-m-d')];
  if(!empty($rec['keywords'])){ $obj['keywords']=array_values(array_filter(array_map('trim',explode('|',$rec['keywords'])))); }
  fwrite($fo,json_encode($obj,JSON_UNESCAPED_SLASHES)."\n");
} fclose($fp); fclose($fo); echo "WROTE: $out\n";

4) Verifier (bash + jq)
Create file: scripts/verify_ndjson.sh
#!/usr/bin/env bash
set -euo pipefail
AI_NDJSON="public/sitemaps/sitemap-ai.ndjson"
[[ -s "$AI_NDJSON" ]] || { echo "Missing AI manifest: $AI_NDJSON"; exit 1; }
head -n 1 "$AI_NDJSON" | jq . >/dev/null 2>&1 || { echo "First line not valid JSON"; exit 1; }
LINES=$(wc -l < "$AI_NDJSON" | tr -d ' ')
echo "OK: $AI_NDJSON ($LINES rows)"

5) Makefile targets
Create file: Makefile
SHELL := /bin/bash
.PHONY: sitemap:ai ndjson:verify stream:test
sitemap:ai:
	php scripts/build_ai_manifest.php
ndjson:verify:
	bash scripts/verify_ndjson.sh
stream:test:
	curl -s https://nrlc.ai/api/stream?limit=3 | head -n 3 | jq .

6) robots.txt (append)
Create file if missing: public/robots.txt
User-agent: *
Disallow:

Sitemap: https://nrlc.ai/sitemaps/sitemap-index.xml.gz
AI-Manifest: https://nrlc.ai/sitemaps/sitemap-ai.ndjson

If robots.txt exists, ensure a single AI-Manifest line.

7) .htaccess (Apache headers; safe no-op on Nginx)
Create/append file: public/.htaccess
<FilesMatch "sitemap-ai\.ndjson$">
  Header set Content-Type "application/x-ndjson; charset=utf-8"
  Header set Cache-Control "public, max-age=86400, immutable"
</FilesMatch>
<IfModule mod_headers.c>
  <Location "/api/stream">
    Header set Cache-Control "no-cache, no-store, must-revalidate"
  </Location>
</IfModule>

Validation
- php -l public/api/stream/index.php
- php -l scripts/build_ai_manifest.php

Then print:
DONE: Promptware — JSON Stream + SEO AI (Style-Agnostic) installed.
</code></pre>
    </details>
  </section>

  <section aria-labelledby="verify" style="margin-bottom: 3rem;">
    <h2 id="verify">Verify</h2>
    <pre style="padding: 1rem; background: var(--background-color, #fff); border: 1px solid var(--border-color, #ddd); overflow-x: auto; word-wrap: break-word; white-space: pre-wrap;"><code style="word-wrap: break-word; white-space: pre-wrap;">make sitemap-ai
make ndjson-verify
curl -s <?= htmlspecialchars($domain) ?>/api/stream?limit=3 | head -n 3 | jq .</code></pre>
  </section>

  <footer style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--border-color, #ddd);">
    <p>MIT Licensed — © <span id="y"></span> <?= htmlspecialchars($brand) ?> • Contact: <?= htmlspecialchars($contact) ?></p>
  </footer>
</main>
<script>document.getElementById('y').textContent=new Date().getFullYear();</script>

<!-- Schemas -->
<!-- 1. BreadcrumbList (eligible for rich results) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"Home","item":"<?= htmlspecialchars($domain) ?>/"},
    {"@type":"ListItem","position":2,"name":"Promptware","item":"<?= htmlspecialchars($domain) ?>/promptware/"},
    {"@type":"ListItem","position":3,"name":"JSON Stream + SEO AI","item":"<?= htmlspecialchars($domain) ?>/promptware/json-stream-seo-ai/"}
  ]
}</script>

<!-- 2. TechArticle (primary schema for docs page) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"TechArticle",
  "headline":"JSON Stream + SEO AI — Promptware",
  "about":["NDJSON","AI manifest","RAG","LLMO"],
  "author":{"@type":"Organization","name":"NRLC.ai"},
  "publisher":{"@type":"Organization","name":"NRLC.ai"},
  "datePublished":"2025-10-27",
  "dateModified":"2025-10-27",
  "inLanguage":"en",
  "mainEntityOfPage":"<?= htmlspecialchars($domain) ?>/promptware/json-stream-seo-ai/"
}</script>

<!-- 3. HowTo (optional; may not render rich results but good for LLM understanding) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"HowTo",
  "name":"Install JSON Stream + SEO AI",
  "totalTime":"PT20M",
  "tool":[{"@type":"HowToTool","name":"PHP 8+"},{"@type":"HowToTool","name":"jq"}],
  "step":[
    {"@type":"HowToStep","name":"Install API","text":"Add /api/stream returning application/x-ndjson."},
    {"@type":"HowToStep","name":"Build AI Manifest","text":"Generate sitemap-ai.ndjson from CSV."},
    {"@type":"HowToStep","name":"Verify","text":"Use jq/head to validate JSON lines."}
  ]
}</script>

<!-- 4. SoftwareSourceCode (excellent for dev docs and LLM ingestion) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"SoftwareSourceCode",
  "name":"Promptware — JSON Stream + SEO AI",
  "codeRepository":"<?= htmlspecialchars($domain) ?>/promptware/json-stream-seo-ai/",
  "programmingLanguage":"PHP",
  "runtimePlatform":"PHP 8+",
  "license":"https://opensource.org/licenses/MIT"
}</script>

<!-- 5. APIReference (for the /api/stream endpoint) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"APIReference",
  "name":"NDJSON Stream API",
  "description":"Streams JSON-LD objects one per line with content-type application/x-ndjson.",
  "url":"<?= htmlspecialchars($domain) ?>/api/stream",
  "programmingLanguage":"HTTP",
  "targetPlatform":"Web"
}</script>

<!-- 6. Dataset (for the NDJSON manifest - may appear in Dataset Search) -->
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"Dataset",
  "name":"NRLC.ai AI Manifest (NDJSON)",
  "description":"Compact JSON-LD rows for site pages to aid LLM/RAG ingestion.",
  "creator":{"@type":"Organization","name":"NRLC.ai"},
  "license":"https://opensource.org/licenses/MIT",
  "distribution":[{
    "@type":"DataDownload",
    "encodingFormat":"application/x-ndjson",
    "contentUrl":"<?= htmlspecialchars($domain) ?>/sitemaps/sitemap-ai.ndjson"
  }]
}</script>

<?php include __DIR__.'/../../../../templates/footer.php'; ?>

