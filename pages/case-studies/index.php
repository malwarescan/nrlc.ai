<?php
// Note: Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for case studies index metadata configuration
// Note: head.php and header.php are already included by router.php render_page()

$canonical_url = absolute_url('/case-studies/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Page Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title heading-1">AI SEO Case Studies & Success Stories</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Real-world examples of AI SEO optimization success, featuring detailed results and implementation strategies.</p>
      </div>
    </div>

    <!-- Case Studies Grid -->
    <div class="content-block module">
      <div class="content-block__body">
        <div class="grid grid-auto-fit" style="gap: var(--spacing-lg);">
          
          <!-- Entity Semantic Poisoning at SAW.com (Real Case Study) -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">Entity Repair Case Study: SAW.com</h3>
            </div>
            <div class="content-block__body">
              <p>How entity-level semantic poisoning caused Google to misclassify SAW.com, why SEO fixes failed, and how structured entity repair restored correct business identity.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/entity-semantic-poisoning-saw/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>

          <!-- B2B SaaS Case Study -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">B2B SaaS Case Study</h3>
            </div>
            <div class="content-block__body">
              <p>How a SaaS company increased AI citations by 340% through structured data optimization and entity mapping.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/b2b-saas/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- E-commerce Case Study -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">E-commerce Case Study</h3>
            </div>
            <div class="content-block__body">
              <p>E-commerce platform achieved 250% increase in AI visibility through product schema optimization.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/ecommerce/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Healthcare Case Study -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">Healthcare Case Study</h3>
            </div>
            <div class="content-block__body">
              <p>Medical website improved AI citation rates by 180% with healthcare-specific entity optimization.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/healthcare/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Fintech Case Study -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">Fintech Case Study</h3>
            </div>
            <div class="content-block__body">
              <p>Financial services company increased AI mentions by 290% through compliance-focused optimization.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/fintech/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Education Case Study -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">Education Case Study</h3>
            </div>
            <div class="content-block__body">
              <p>Educational platform achieved 220% increase in AI citations through academic content optimization.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/education/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>
          
          <!-- Real Estate Case Study -->
          <div class="content-block" style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
            <div class="content-block__header">
              <h3 class="content-block__title" style="margin-top: 0; color: #000080;">Real Estate Case Study</h3>
            </div>
            <div class="content-block__body">
              <p>Property platform improved AI visibility by 160% with location-based entity optimization.</p>
              <p style="margin-top: var(--spacing-md);">
                <a href="/case-studies/real-estate/" class="btn btn--primary">View Case Study</a>
              </p>
            </div>
          </div>
          
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// Schema markup
$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonical_url . '#webpage',
  'name' => 'AI SEO Case Studies & Success Stories',
  'description' => 'Real-world examples of AI SEO optimization success, featuring detailed results and implementation strategies.',
  'url' => $canonical_url,
  'isPartOf' => [
    '@type' => 'WebSite',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai'
  ],
  'mainEntity' => [
    '@type' => 'ItemList',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Entity Repair Case Study: SAW.com',
        'item' => absolute_url('/case-studies/entity-semantic-poisoning-saw/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'B2B SaaS Case Study',
        'item' => absolute_url('/case-studies/b2b-saas/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'E-commerce Case Study',
        'item' => absolute_url('/case-studies/ecommerce/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Healthcare Case Study',
        'item' => absolute_url('/case-studies/healthcare/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 5,
        'name' => 'Fintech Case Study',
        'item' => absolute_url('/case-studies/fintech/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 6,
        'name' => 'Education Case Study',
        'item' => absolute_url('/case-studies/education/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 7,
        'name' => 'Real Estate Case Study',
        'item' => absolute_url('/case-studies/real-estate/')
      ]
    ]
  ]
];
?>
