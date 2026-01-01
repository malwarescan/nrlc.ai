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

// JSON-LD Schema
$canonicalUrl = absolute_url('/promptware/llm-data-to-citation/');

$GLOBALS['__jsonld'] = [
  // About / Entity Graph (Site-wide)
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => absolute_url('/') . '#logo',
          'url' => absolute_url('/assets/images/nrlc-logo.png')
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ],
      [
        '@type' => 'WebSite',
        '@id' => absolute_url('/') . '#website',
        'url' => absolute_url('/'),
        'name' => 'NRLC.ai',
        'publisher' => [
          '@id' => absolute_url('/') . '#organization'
        ],
        'inLanguage' => 'en-US'
      ]
    ]
  ],
  // BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Promptware',
        'item' => absolute_url('/promptware/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'LLM Data-to-Citation Guide',
        'item' => $canonicalUrl
      ]
    ]
  ],
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => $title,
    'name' => 'LLM Data-to-Citation Guide',
    'description' => $desc,
    'url' => $canonicalUrl,
    'author' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC',
      'logo' => [
        '@type' => 'ImageObject',
        '@id' => absolute_url('/') . '#logo',
        'url' => absolute_url('/assets/images/nrlc-logo.png')
      ]
    ],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d'),
    'mainEntityOfPage' => [
      '@id' => $canonicalUrl . '#webpage'
    ],
    'about' => ['NDJSON', 'schema', 'RAG', 'citations'],
    'keywords' => ['NDJSON', 'schema', 'RAG', 'citations', 'LLM', 'AI Overviews']
  ],
  // FAQPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'Does Google still render HowTo/FAQ rich results?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Eligibility is limited, but the markup still improves machine understanding and RAG mapping. Keep it.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Where do I declare the AI manifest?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Add an AI-Manifest line in /public/robots.txt pointing to /sitemaps/sitemap-ai.ndjson.'
        ]
      ]
    ]
  ],
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => $title,
    'description' => $desc,
    'inLanguage' => 'en-US',
    'isPartOf' => [
      '@id' => absolute_url('/') . '#website'
    ],
    'breadcrumb' => [
      '@id' => $canonicalUrl . '#breadcrumb'
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Back Link -->
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <div class="content-block__body">
          <p><a href="<?= absolute_url('/promptware/') ?>">← Back to Promptware</a></p>
        </div>
      </div>

      <!-- Hero Block -->
      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">LLM Data-to-Citation Guide</h1>
        </div>
        <div class="content-block__body">
          <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-md);">
            How to turn <strong>schema</strong> and <strong>NDJSON</strong> into <strong>citations</strong> in LLM answers and AI Overviews.
          </p>
        </div>
      </div>

      <!-- Why Citations Happen -->
      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="heading-2">Why citations happen</h2>
        </div>
        <div class="content-block__body">
          <p>LLMs cite when a retrieval step fetches a verifiable passage tied to a stable URL. JSON-LD on page and an AI manifest (<code>/sitemaps/sitemap-ai.ndjson</code>) make that mapping explicit and cheap.</p>
        </div>
      </div>

      <!-- Publish token-lean facts via NDJSON -->
      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="heading-2">Publish token-lean facts via NDJSON</h2>
        </div>
        <div class="content-block__body">
          <p>Expose compact JSON-LD objects (one per line) summarizing key pages/entities. Link it from <code>robots.txt</code> with an <strong>AI-Manifest</strong> line.</p>
          <pre style="background: #f5f5f5; padding: var(--spacing-md); border: 1px solid #ddd; overflow-x: auto; margin-top: var(--spacing-md);"><code>{"@context":"https://schema.org","@type":"WebPage","url":"<?= htmlspecialchars($domain) ?>/","name":"NRLC.ai — Home","inLanguage":"en","dateModified":"<?= date('Y-m-d') ?>"}
{"@context":"https://schema.org","@type":"TechArticle","url":"<?= htmlspecialchars($url) ?>","name":"LLM Data-to-Citation Guide","inLanguage":"en","dateModified":"<?= date('Y-m-d') ?>","keywords":["NDJSON","schema","RAG","citations"]}</code></pre>
          <p style="margin-top: var(--spacing-md);">Stream test:</p>
          <pre style="background: #f5f5f5; padding: var(--spacing-md); border: 1px solid #ddd; overflow-x: auto;"><code>curl -s <?= htmlspecialchars($domain) ?>/api/stream?limit=3 | jq .</code></pre>
        </div>
      </div>

      <!-- Minimum viable schema for citations -->
      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="heading-2">Minimum viable schema for citations</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><code>@type</code> (e.g., <code>TechArticle</code>), <code>name</code>, <code>url</code>, <code>dateModified</code></li>
            <li><code>@id</code> (use your canonical URL with a fragment if needed)</li>
            <li><code>isPartOf</code> and <code>BreadcrumbList</code> for site context</li>
            <li>Optional <code>Dataset</code> node if you publish <code>sitemap-ai.ndjson</code> as a downloadable asset</li>
          </ul>
        </div>
      </div>

      <!-- RAG preferences you can influence -->
      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="heading-2">RAG preferences you can influence</h2>
        </div>
        <div class="content-block__body">
          <ol>
            <li>Serve fast NDJSON with <code>Content-Type: application/x-ndjson</code> and long-lived cache for static files.</li>
            <li>Keep page prose concise; move machine details to JSON-LD to reduce tokens.</li>
            <li>Link your canonical "reference pages" from relevant sections to increase retrieval odds.</li>
          </ol>
          <p style="margin-top: var(--spacing-md);">See also: <a href="<?= absolute_url('/promptware/json-stream-seo-ai/') ?>">JSON Stream + SEO AI</a></p>
        </div>
      </div>

      <!-- FAQ -->
      <div class="content-block module" style="margin-bottom: var(--spacing-8);">
        <div class="content-block__header">
          <h2 class="heading-2">FAQ</h2>
        </div>
        <div class="content-block__body">
          <details style="margin-bottom: var(--spacing-md); padding: var(--spacing-md); border: 1px solid #ddd;">
            <summary style="font-weight: var(--font-weight-semibold); cursor: pointer;">Does Google still render HowTo/FAQ rich results?</summary>
            <p style="margin-top: var(--spacing-md);">Eligibility is limited, but the markup still improves machine understanding and RAG mapping. Keep it.</p>
          </details>
          <details style="padding: var(--spacing-md); border: 1px solid #ddd;">
            <summary style="font-weight: var(--font-weight-semibold); cursor: pointer;">Where do I declare the AI manifest?</summary>
            <p style="margin-top: var(--spacing-md);">Add an <code>AI-Manifest:</code> line in <code>/public/robots.txt</code> pointing to <code>/sitemaps/sitemap-ai.ndjson</code>.</p>
          </details>
        </div>
      </div>

    </div>
  </section>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
