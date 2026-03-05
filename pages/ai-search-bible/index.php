<?php
declare(strict_types=1);

if (!function_exists('absolute_url')) {
  require_once __DIR__ . '/../../lib/helpers.php';
}
if (!function_exists('ld_organization')) {
  require_once __DIR__ . '/../../lib/schema_builders.php';
}
require_once __DIR__ . '/components.php';

$canonicalUrl = absolute_url('/ai-search-bible/');
$faqItems = [
  [
    'question' => 'What is fan-out retrieval?',
    'answer' => 'Fan-out retrieval is the process where an AI system expands a single prompt into multiple retrieval queries across different providers before answer synthesis.'
  ],
  [
    'question' => 'What is Reciprocal Rank Fusion?',
    'answer' => 'Reciprocal Rank Fusion is a rank-merging method that combines results from multiple retrieval systems, often rewarding broad multi-source presence over single-source rank dominance.'
  ],
  [
    'question' => 'Why does query rewriting matter in AI search?',
    'answer' => 'AI systems rewrite user prompts internally into sub-queries and intent variants, which changes which documents and entities are retrieved.'
  ],
  [
    'question' => 'What is AI search optimization?',
    'answer' => 'AI search optimization focuses on retrievability, evidence quality, and citation eligibility for AI systems, not only page-level keyword ranking.'
  ],
  [
    'question' => 'What is croutonization?',
    'answer' => 'Croutonization is a content engineering method that structures knowledge into atomic units that can be extracted, scored, and cited independently.'
  ],
  [
    'question' => 'Who should read the AI Search Bible?',
    'answer' => 'It is built for SEO teams, AI search engineers, founders, growth operators, and platform teams responsible for AI visibility and citation outcomes.'
  ]
];

$entities = [
  ['term' => 'Fan-Out Retrieval', 'definition' => 'Parallel expansion of one prompt into many targeted retrieval queries.'],
  ['term' => 'Reciprocal Rank Fusion', 'definition' => 'Rank aggregation across retrieval providers using reciprocal position weighting.'],
  ['term' => 'Entity Anchoring', 'definition' => 'Explicitly establishing brand/topic entities for attribution and citation.'],
  ['term' => 'Croutonization', 'definition' => 'Structuring content into atomic retrieval-ready knowledge units.'],
];

$references = [
  'Neural Command research notes on AI retrieval orchestration and citation mechanics.',
  'Schema.org documentation for TechArticle, FAQPage, BreadcrumbList, and Organization.',
  'Internal framework notes for fan-out coverage, query rewriting, and retrieval surfaces.'
];

$GLOBALS['__jsonld'] = [
  ld_organization(),
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Search Bible', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'The AI Search Bible',
    'name' => 'The AI Search Bible',
    'description' => 'The complete AI Search Bible explaining fan-out queries, Reciprocal Rank Fusion, entities, and retrieval surfaces across modern AI search systems.',
    'url' => $canonicalUrl,
    'author' => ['@type' => 'Organization', 'name' => 'Neural Command'],
    'publisher' => ['@type' => 'Organization', 'name' => 'Neural Command'],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonicalUrl],
    'dateModified' => date('Y-m-d'),
    'inLanguage' => 'en-US',
    'keywords' => 'AI search bible, fan-out retrieval, reciprocal rank fusion, query rewriting, entity anchoring, croutonization, AI SEO framework'
  ],
  ai_bible_build_faq_schema($canonicalUrl, $faqItems),
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">

      <div class="content-block module" style="background: var(--color-background-alt, #f7f9fc); border-left: 4px solid #12355e;">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">The AI Search Bible</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg">A complete technical framework explaining how AI search systems like ChatGPT, Gemini, Perplexity, and AI Overviews retrieve information and how to engineer content that gets cited.</p>
          <div class="btn-group" style="margin-top: var(--spacing-lg);">
            <a href="<?= htmlspecialchars(absolute_url('/ai-search-bible/full/')) ?>" class="btn btn--primary js-click-unlock">Unlock the Full Bible</a>
            <a href="#framework-overview" class="btn btn--secondary">View Framework Overview</a>
          </div>
        </div>
      </div>

      <?php ai_bible_render_tldr_block([
        'AI search is retrieval-orchestration, not classic ten-blue-links ranking.',
        'Fan-out + fusion + entity anchoring drive citation outcomes.',
        'The full AI Search Bible is paywalled and unlocks implementation specs.'
      ]); ?>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Traditional SEO Is Not Built For AI Search</h2>
        </div>
        <div class="content-block__body">
          <p>Search engines ranked pages. AI systems retrieve knowledge fragments.</p>
          <p>Instead of a single keyword query producing a ranked list, modern AI search systems operate as orchestration engines that generate parallel searches, retrieve evidence from multiple providers, and synthesize answers.</p>
          <p>Most SEO strategies were built for <strong>keyword -&gt; ranking -&gt; click</strong>. AI search works as <strong>prompt -&gt; fan-out queries -&gt; provider retrieval -&gt; fusion -&gt; answer synthesis</strong>.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">How AI Search Actually Works</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Pipeline:</strong></p>
          <p>User Prompt<br>Sonic Classifier (search trigger)<br>Prompt Type Detection<br>Fan-Out Query Expansion<br>Multi-Provider Retrieval<br>Reciprocal Rank Fusion<br>Evidence Selection<br>AI Answer Composition<br>Citation</p>
          <p>AI search systems are retrieval orchestrators. They generate multiple queries across web indexes, product databases, knowledge graphs, embeddings stores, and map providers, then merge results to build evidence-backed answers.</p>
        </div>
      </div>

      <div class="content-block module" id="fanout-query-explorer">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">AI Fan-Out Query Explorer</h2>
        </div>
        <div class="content-block__body">
          <p>See how AI search expands a single prompt into dozens of hidden queries.</p>
          <label for="fanout-prompt-input"><strong>Enter a prompt</strong></label>
          <div class="btn-group" style="margin-top: 0.5rem;">
            <input id="fanout-prompt-input" type="text" placeholder="best CRM for startups" style="min-width: 280px; flex: 1 1 auto;">
            <button id="fanout-generate-button" type="button" class="btn btn--primary">Generate Fan-Out Queries</button>
          </div>

          <div id="fanout-output-wrap" style="display: none; margin-top: var(--spacing-lg); background: #f7f9fc; border: 1px solid #dce3ef; border-radius: 6px; padding: 1rem;">
            <h3 class="heading-3">AI Fan-Out Queries</h3>
            <ul id="fanout-output-list"></ul>
            <div id="fanout-share-module" style="display: none; margin-top: 0.75rem;">
              <div class="btn-group" style="align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <button id="fanout-copy-result" type="button" class="btn btn--secondary" aria-label="Copy fan-out result">Copy result</button>
                <button id="fanout-share-x" type="button" class="btn btn--secondary" aria-label="Share fan-out result on X">Share on X</button>
                <button id="fanout-download-image" type="button" class="btn btn--secondary" aria-label="Download share image">Download image</button>
                <a id="fanout-copy-permalink" href="#" style="font-size: 0.9rem;" aria-label="Copy permalink">Permalink</a>
              </div>
            </div>
            <div id="fanout-toast" aria-live="polite" style="min-height: 1.2rem; font-size: 0.9rem; color: #1f5a2e; margin-top: 0.5rem;"></div>
            <p><em>AI search engines often generate 10-30 queries from a single prompt.</em></p>
            <p>The full AI Search Bible explains the entire system behind this process.</p>
            <a href="<?= htmlspecialchars(absolute_url('/ai-search-bible/full/')) ?>" class="btn btn--primary js-click-unlock">Unlock the AI Search Bible</a>
          </div>
        </div>
      </div>

      <?php ai_bible_render_crouton_block(
        'AI systems rewrite and fan-out prompts before retrieval.',
        'This happens before final answer synthesis and citation.',
        'Build content to cover rewritten intents and adjacent retrieval surfaces.',
        'Neural Command retrieval architecture research.'
      ); ?>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Key Discoveries From The Research</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">Fan-Out Retrieval</h3>
          <p>AI expands one prompt into multiple queries to increase evidence coverage.</p>
          <p><strong>Example:</strong> best CRM for small business -&gt; best CRM for startups, CRM comparison tools, HubSpot vs Salesforce small business, affordable CRM platforms.</p>

          <h3 class="heading-3">Reciprocal Rank Fusion</h3>
          <p>Results from multiple providers are merged. Presence across several sources can outperform a single high rank in one source.</p>

          <h3 class="heading-3">Query Rewriting</h3>
          <p>User language is rewritten internally. Example: why am I tired all day -&gt; chronic fatigue causes, vitamin deficiency fatigue, sleep disorder symptoms.</p>

          <h3 class="heading-3">Entity Anchoring</h3>
          <p>AI systems rely on entity linking. Without a structured brand entity, attribution and citation quality degrade.</p>
        </div>
      </div>

      <div class="content-block module" id="framework-overview">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Neural Command AI Visibility Framework</h2>
        </div>
        <div class="content-block__body">
          <p><strong>Architecture:</strong> Prompt Layer -&gt; Fan-Out Intelligence -&gt; Retrieval Layer -&gt; Crouton Extraction -&gt; AI Composition -&gt; Citation</p>
          <p>The framework introduces <strong>Croutonization</strong>: structuring knowledge into atomic retrieval units designed for extraction, evidence scoring, and citation by AI systems.</p>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Inside The AI Search Bible</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>Sonic classifier and search trigger systems</li>
            <li>Fan-out query generation and provider ecosystems</li>
            <li>Reciprocal Rank Fusion ranking logic</li>
            <li>Croutonized knowledge structures</li>
            <li>Retrieval surface engineering and entity graph optimization</li>
            <li>Enterprise schema strategies, citation tracking, and visibility dashboards</li>
          </ul>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Who Should Read This</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li>SEO professionals</li>
            <li>AI search engineers</li>
            <li>Growth teams</li>
            <li>Founders building AI visibility</li>
            <li>Knowledge platform developers</li>
          </ul>
        </div>
      </div>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Table of Contents (Preview)</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li>AI Search Architecture</li>
            <li>Sonic Classifier</li>
            <li>Prompt Type Routing</li>
            <li>Fan-Out Retrieval Systems</li>
            <li>Retrieval Providers</li>
            <li>Reciprocal Rank Fusion</li>
            <li>Query Rewriting</li>
            <li>Croutonization</li>
            <li>Retrieval Surface Engineering</li>
            <li>Entity Graphs</li>
            <li>AI Citation Mechanics</li>
            <li>Fan-Out Coverage Metrics</li>
            <li>AI Visibility Infrastructure</li>
          </ol>
        </div>
      </div>

      <div class="content-block module" style="background: var(--color-background-alt, #f7f9fc); border-left: 4px solid #12355e;">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Unlock The Full AI Search Bible</h2>
        </div>
        <div class="content-block__body">
          <p>The complete document includes full technical research, engineering frameworks, and implementation guides for building AI-visible knowledge systems.</p>
          <ul>
            <li>20+ chapters</li>
            <li>Implementation frameworks and developer specifications</li>
            <li>Schema models and agent skill packs</li>
            <li>AI retrieval infrastructure blueprints</li>
          </ul>
          <p><strong>Price:</strong> Set in Stripe at checkout</p>
          <div class="btn-group">
            <a href="<?= htmlspecialchars(absolute_url('/ai-search-bible/full/')) ?>" class="btn btn--primary js-click-unlock">Unlock Full Access</a>
          </div>
        </div>
      </div>

      <?php ai_bible_render_faq_accordion($faqItems); ?>
      <?php ai_bible_render_entities_glossary($entities); ?>
      <?php ai_bible_render_references($references); ?>

      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">AI Search Bible Dataset Preview</h2>
        </div>
        <div class="content-block__body">
          <p>Download: <a href="<?= htmlspecialchars(absolute_url('/fanout_queries_sample.ndjson')) ?>" download>fanout_queries_sample.ndjson</a></p>
          <pre style="white-space: pre-wrap; overflow-wrap: break-word; background: #f8f8f8; padding: 1rem; border-radius: 6px; border: 1px solid #dce3ef;">{"prompt":"best CRM","fanout":"CRM comparison tools"}
{"prompt":"best CRM","fanout":"HubSpot vs Salesforce"}
{"prompt":"best CRM","fanout":"startup CRM software"}</pre>
        </div>
      </div>

      <?php ai_bible_render_ndjson_link_area(absolute_url('/fanout_queries_sample.ndjson')); ?>

    </div>
  </section>
</main>

<script>
(function () {
  var PAGE_URL = 'https://nrlc.ai/ai-search-bible';
  var state = {
    prompt: '',
    normalizedPrompt: '',
    queries: [],
    resultId: '',
    permalink: PAGE_URL
  };

  function track(eventName, payload) {
    if (typeof window.gtag === 'function') {
      window.gtag('event', eventName, payload || {});
    }
  }

  function normalizePrompt(prompt) {
    return prompt.replace(/\s+/g, ' ').trim();
  }

  function escapeHtml(text) {
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
  }

  function showToast(message) {
    var toast = document.getElementById('fanout-toast');
    if (!toast) return;
    toast.textContent = message;
    window.setTimeout(function () {
      if (toast.textContent === message) {
        toast.textContent = '';
      }
    }, 1800);
  }

  function generateFanOut(prompt) {
    var normalized = normalizePrompt(prompt);
    var withoutBest = normalized.replace(/^best\s+/i, '').trim();
    var base = withoutBest || normalized;
    var queries = [
      'best ' + base,
      base + ' comparison',
      base + ' tools',
      base + ' pricing',
      base + ' alternatives',
      base + ' reviews',
      base + ' guide',
      base + ' software'
    ];

    // Keep deterministic ordering and remove duplicates.
    return Array.from(new Set(queries.map(function (q) { return normalizePrompt(q); })));
  }

  function shaFallback(input) {
    var hash = 5381;
    for (var i = 0; i < input.length; i++) {
      hash = ((hash << 5) + hash) + input.charCodeAt(i);
      hash = hash & hash;
    }
    return ('00000000' + (hash >>> 0).toString(16)).slice(-8);
  }

  function sha256Hex(input) {
    if (window.crypto && window.crypto.subtle && window.TextEncoder) {
      return window.crypto.subtle.digest('SHA-256', new window.TextEncoder().encode(input))
        .then(function (buffer) {
          var bytes = Array.from(new Uint8Array(buffer));
          return bytes.map(function (b) { return b.toString(16).padStart(2, '0'); }).join('');
        })
        .catch(function () {
          return Promise.resolve(shaFallback(input));
        });
    }
    return Promise.resolve(shaFallback(input));
  }

  function updatePromptInUrl(prompt) {
    var url = new URL(window.location.href);
    if (prompt) {
      url.searchParams.set('prompt', prompt);
    } else {
      url.searchParams.delete('prompt');
    }
    window.history.replaceState({}, '', url.toString());
    state.permalink = url.toString();
    return state.permalink;
  }

  function buildCopyBlock() {
    var lines = ['Prompt: ' + state.prompt, 'Fan-Out Queries:'];
    state.queries.forEach(function (query) { lines.push('- ' + query); });
    lines.push('Result ID: ' + state.resultId);
    lines.push('Source: https://nrlc.ai/ai-search-bible');
    lines.push('AI Fan-Out Query Explorer by Neural Command');
    return lines.join('\n');
  }

  function safePromptForX(prompt) {
    var cleaned = prompt.replace(/[\u201C\u201D"]/g, '').trim();
    if (cleaned.length > 90) return cleaned.slice(0, 87) + '...';
    return cleaned;
  }

  function buildXIntentUrl() {
    var promptShort = safePromptForX(state.prompt);
    var shareLink = PAGE_URL + '?prompt=' + encodeURIComponent(state.prompt) + '&rid=' + encodeURIComponent(state.resultId);
    var text = [
      'I tested a prompt in Neural Command\'s AI Fan-Out Query Explorer.',
      'Prompt: "' + promptShort + '"',
      'Generated ' + state.queries.length + ' fan-out queries.',
      shareLink
    ].join('\n');

    while (text.length > 280 && promptShort.length > 20) {
      promptShort = promptShort.slice(0, Math.max(20, promptShort.length - 10)).replace(/\.\.\.$/, '') + '...';
      text = [
        'I tested a prompt in Neural Command\'s AI Fan-Out Query Explorer.',
        'Prompt: "' + promptShort + '"',
        'Generated ' + state.queries.length + ' fan-out queries.',
        shareLink
      ].join('\n');
    }

    return 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(text);
  }

  function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(text);
    }
    return new Promise(function (resolve, reject) {
      try {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.focus();
        ta.select();
        var ok = document.execCommand('copy');
        document.body.removeChild(ta);
        if (ok) resolve(); else reject(new Error('copy failed'));
      } catch (err) {
        reject(err);
      }
    });
  }

  function ensureHtml2Canvas() {
    if (window.html2canvas) {
      return Promise.resolve(window.html2canvas);
    }
    return new Promise(function (resolve, reject) {
      var script = document.createElement('script');
      script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
      script.async = true;
      script.onload = function () { resolve(window.html2canvas); };
      script.onerror = function () { reject(new Error('Failed to load html2canvas')); };
      document.head.appendChild(script);
    });
  }

  function downloadFanOutImage() {
    return ensureHtml2Canvas().then(function (html2canvas) {
      var card = document.createElement('div');
      card.style.position = 'fixed';
      card.style.left = '-10000px';
      card.style.top = '-10000px';
      card.style.width = '1200px';
      card.style.background = '#ffffff';
      card.style.color = '#0f172a';
      card.style.padding = '48px';
      card.style.border = '1px solid #dce3ef';
      card.style.borderRadius = '12px';
      card.style.fontFamily = 'system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif';
      var topQueries = state.queries.slice(0, 10).map(function (query) {
        return '- ' + query;
      }).join('\n');
      card.innerHTML = ''
        + '<h2 style="margin:0 0 16px 0; font-size:40px;">AI Fan-Out Query Explorer</h2>'
        + '<p style="margin:0 0 20px 0; font-size:22px;"><strong>Prompt:</strong> ' + escapeHtml(state.prompt) + '</p>'
        + '<pre style="margin:0; padding:20px; background:#f8fafc; border:1px solid #dce3ef; border-radius:8px; font-size:22px; line-height:1.45; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">'
        + escapeHtml(topQueries)
        + '</pre>'
        + '<p style="margin:20px 0 0 0; font-size:18px; color:#334155;">nrlc.ai</p>';
      document.body.appendChild(card);
      return html2canvas(card, { backgroundColor: '#ffffff', scale: 2 }).then(function (canvas) {
        document.body.removeChild(card);
        var link = document.createElement('a');
        link.download = 'ai-fanout-query-explorer.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      }).catch(function (err) {
        if (document.body.contains(card)) {
          document.body.removeChild(card);
        }
        throw err;
      });
    });
  }

  function renderResult(outputList, outputWrap, shareModule) {
    outputList.innerHTML = state.queries.map(function (item) {
      return '<li>' + escapeHtml(item) + '</li>';
    }).join('');
    outputWrap.style.display = 'block';
    shareModule.style.display = 'block';
  }

  function generateAndRender(promptValue, options) {
    options = options || {};
    var prompt = normalizePrompt(promptValue || '');
    if (!prompt) return Promise.resolve();
    state.prompt = prompt;
    state.normalizedPrompt = prompt.toLowerCase();
    state.queries = generateFanOut(prompt);
    updatePromptInUrl(prompt);
    return sha256Hex(state.normalizedPrompt).then(function (rid) {
      state.resultId = rid;
      try {
        window.localStorage.setItem('fanout_result_id', rid);
      } catch (e) {}
      renderResult(outputList, outputWrap, shareModule);
      if (options.scrollToOutput) {
        outputWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  }

  var input = document.getElementById('fanout-prompt-input');
  var button = document.getElementById('fanout-generate-button');
  var outputWrap = document.getElementById('fanout-output-wrap');
  var outputList = document.getElementById('fanout-output-list');
  var shareModule = document.getElementById('fanout-share-module');
  var copyResultBtn = document.getElementById('fanout-copy-result');
  var shareXBtn = document.getElementById('fanout-share-x');
  var downloadBtn = document.getElementById('fanout-download-image');
  var copyPermalinkLink = document.getElementById('fanout-copy-permalink');

  if (button && input && outputWrap && outputList && shareModule) {
    button.addEventListener('click', function () {
      generateAndRender(input.value || '', { scrollToOutput: false });
    });

    input.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        generateAndRender(input.value || '', { scrollToOutput: false });
      }
    });
  }

  if (copyResultBtn) {
    copyResultBtn.addEventListener('click', function () {
      copyText(buildCopyBlock()).then(function () {
        showToast('Copied');
        track('fanout_copy_result', {
          result_id: state.resultId,
          query_count: state.queries.length,
          prompt_length: state.prompt.length
        });
      }).catch(function () {
        showToast('Copy failed');
      });
    });
  }

  if (shareXBtn) {
    shareXBtn.addEventListener('click', function () {
      window.open(buildXIntentUrl(), '_blank', 'noopener,noreferrer');
      track('fanout_share_x', {
        result_id: state.resultId,
        query_count: state.queries.length,
        prompt_length: state.prompt.length
      });
    });
  }

  if (downloadBtn) {
    downloadBtn.addEventListener('click', function () {
      downloadFanOutImage().then(function () {
        showToast('Image downloaded');
        track('fanout_download_image', {
          result_id: state.resultId,
          query_count: state.queries.length,
          prompt_length: state.prompt.length
        });
      }).catch(function () {
        showToast('Image failed');
      });
    });
  }

  if (copyPermalinkLink) {
    copyPermalinkLink.addEventListener('click', function (event) {
      event.preventDefault();
      var permalink = state.permalink || updatePromptInUrl(state.prompt);
      copyText(permalink).then(function () {
        showToast('Copied');
        track('fanout_copy_permalink', {
          result_id: state.resultId,
          query_count: state.queries.length,
          prompt_length: state.prompt.length
        });
      }).catch(function () {
        showToast('Copy failed');
      });
    });
  }

  track('view_ai_search_bible_landing');

  var initialPrompt = normalizePrompt((new URL(window.location.href)).searchParams.get('prompt') || '');
  if (initialPrompt && input) {
    input.value = initialPrompt;
    generateAndRender(initialPrompt, { scrollToOutput: true });
  }

  var buttons = document.querySelectorAll('.js-click-unlock');
  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      track('click_unlock', { page: 'ai-search-bible-landing' });
    });
  });
})();
</script>
