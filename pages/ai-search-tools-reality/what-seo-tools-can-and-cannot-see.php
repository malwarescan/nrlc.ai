<?php
// Placeholder page - content coming soon
// TODO: Add content for this page

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

$canonicalUrl = absolute_url('/en-us/ai-search-tools-reality/what-seo-tools-can-and-cannot-see/');

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
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'The Limits of SEO Tooling in AI Search', 'item' => absolute_url('/en-us/ai-search-tools-reality/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'What Seo Tools Can And Cannot See', 'item' => $canonicalUrl]
    ]
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      <div class="content-block module" style="margin-bottom: var(--spacing-md);">
        <p><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>">← Back to The Limits of SEO Tooling in AI Search</a></p>
      </div>
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">What Seo Tools Can And Cannot See</h1>
        </div>
        <div class="content-block__body">
          <p>Content coming soon. This page is under development.</p>
        </div>
      </div>
    </div>
  </section>
</main>