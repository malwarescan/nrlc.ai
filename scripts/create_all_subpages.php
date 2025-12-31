<?php
// Create all missing sub-pages for pillar pages

require_once __DIR__ . '/../lib/helpers.php';

$subPages = [
  'ai-search-measurement' => [
    'measuring-ai-visibility',
    'tracking-ai-citations',
    'reporting-ai-search-performance',
    'attribution-in-zero-click-search',
    'what-can-and-cannot-be-measured'
  ],
  'ai-search-strategy' => [
    'is-seo-still-relevant',
    'what-seo-still-controls',
    'what-seo-lost-control-over',
    'future-of-seo-teams',
    'agency-models-in-ai-search'
  ],
  'ai-search-operations' => [
    'practices-with-diminishing-returns',
    'signals-generative-engines-ignore',
    'what-to-stop-doing-in-seo',
    'what-still-matters-operationally'
  ],
  'ai-search-migrations' => [
    'restructuring-content-for-ai',
    'migrating-legacy-blogs',
    'chunking-existing-content',
    'retiring-low-confidence-pages',
    'rebuilding-sites-for-retrieval'
  ],
  'ai-search-risk' => [
    'ai-citation-risk',
    'hallucinated-brand-mentions',
    'correcting-ai-misinformation',
    'trust-and-authority-governance',
    'ai-search-compliance'
  ],
  'ai-search-tools-reality' => [
    'what-seo-tools-can-and-cannot-see',
    'limitations-of-ai-visibility-tools',
    'why-ai-search-data-is-incomplete',
    'tool-metrics-vs-reality'
  ],
  'field-notes' => [
    'google-ai-overviews',
    'chatgpt',
    'perplexity'
  ],
  'glossary' => [
    'generative-search-terms',
    'retrieval-failure-patterns',
    'ai-search-definitions'
  ]
];

$template = <<<'PHP'
<?php
// Placeholder page - content coming soon
// TODO: Add content for this page

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/{PILLAR}/{PAGE}/');

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => ['@type' => 'ImageObject', '@id' => absolute_url('/') . '#logo', 'url' => absolute_url('/logo.png')],
        'sameAs' => ['https://www.linkedin.com/company/neural-command/']
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => '{PILLAR_NAME}', 'item' => absolute_url('/en-us/{PILLAR}/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => '{PAGE_NAME}', 'item' => $canonicalUrl]
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <p><a href="<?= absolute_url('/en-us/{PILLAR}/') ?>">← Back to {PILLAR_NAME}</a></p>
      </div>
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">{PAGE_NAME}</h1>
        </div>
        <div class="content-block__body">
          <p>Content coming soon. This page is under development.</p>
        </div>
      </div>
    </div>
  </section>
</main>
PHP;

$pillarNames = [
  'ai-search-measurement' => 'Measuring Visibility in AI Search',
  'ai-search-strategy' => 'Search Strategy in the Generative Era',
  'ai-search-operations' => 'Operating SEO in an AI-Mediated Search Environment',
  'ai-search-migrations' => 'Rebuilding Content for Generative Retrieval',
  'ai-search-risk' => 'Managing Risk in AI-Mediated Search',
  'ai-search-tools-reality' => 'The Limits of SEO Tooling in AI Search',
  'field-notes' => 'Field Notes',
  'glossary' => 'AI Search Glossary'
];

foreach ($subPages as $pillar => $pages) {
  foreach ($pages as $page) {
    $file = __DIR__ . "/../pages/$pillar/$page.php";
    if (!file_exists($file)) {
      $dir = dirname($file);
      if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
      }
      
      $pageName = ucwords(str_replace('-', ' ', $page));
      $pillarName = $pillarNames[$pillar] ?? ucwords(str_replace('-', ' ', $pillar));
      
      $content = str_replace(
        ['{PILLAR}', '{PAGE}', '{PILLAR_NAME}', '{PAGE_NAME}'],
        [$pillar, $page, $pillarName, $pageName],
        $template
      );
      
      file_put_contents($file, $content);
      echo "Created: $file\n";
    }
  }
}

echo "Done! Created all missing sub-pages.\n";

