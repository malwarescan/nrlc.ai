<?php
/**
 * Local Pack Engineering Resources Hub
 * URL: /resources/local-pack/
 * 
 * Teaching service businesses how Local Pack visibility actually works,
 * what gets them suppressed, and what to do instead.
 */

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/person_entity.php';
require_once __DIR__.'/../../../lib/schema_builders.php';
require_once __DIR__.'/../../../lib/policy_citations.php';

$canonicalUrl = absolute_url('/en-us/resources/local-pack/');

// Set page metadata
$GLOBALS['__page_slug'] = 'resources/local-pack';
$GLOBALS['__page_meta'] = [
  'title' => 'Local Pack Engineering for Service Businesses | Google Local Pack Resources | NRLC.ai',
  'description' => 'Learn how Local Pack visibility actually works, what gets businesses suppressed (doorway clusters, scaled content abuse), and what to do instead (entity validation, crawl cleanliness, GSC forensics, schema governance).',
  'canonicalPath' => '/resources/local-pack/'
];

// Resource articles in the hub
$localPackArticles = [
  [
    'slug' => 'city-service-pages-doorway-risk',
    'title' => 'City + Service Pages Are the New "Near Me" Spam',
    'description' => 'Templated geo pages and "near me" stuffing are doorway abuse. Learn why they get suppressed and what to build instead.',
    'pillar' => 'Doorway Pages and Scaled Content'
  ],
  [
    'slug' => 'near-me-myth',
    'title' => 'Why "Near Me" Doesn\'t Rank You (And What Actually Does)',
    'description' => '"Near me" is interpreted as local intent, not a keyword you must paste. Learn what actually moves the needle in Local Pack rankings.',
    'pillar' => 'The Local Pack System'
  ],
  [
    'slug' => 'gsc-local-forensics',
    'title' => 'Search Console Forensics for Local Businesses',
    'description' => 'Learn the four failure modes GSC reveals fast and exact workflows to catch suppression onset before it impacts visibility.',
    'pillar' => 'Search Console Forensics'
  ],
  // TODO: Coming soon
  // [
  //   'slug' => 'schema-entity-validation',
  //   'title' => 'The Only LocalBusiness Schema That Matters',
  //   'description' => 'Entity validation done correctly: NAP matching, geo coordinates, openingHours, and schema governance rules that actually work.',
  //   'pillar' => 'Schema and Entity Validation'
  // ],
  // [
  //   'slug' => 'service-area-without-doorways',
  //   'title' => 'Service Areas Without Doorway Pages',
  //   'description' => 'When to use areaServed vs serviceArea, and how to represent service areas correctly without triggering doorway abuse flags.',
  //   'pillar' => 'Schema and Entity Validation'
  // ],
  // [
  //   'slug' => 'schema-governance-multi-location',
  //   'title' => 'Schema Governance Rules for Multi-Location and SAB Businesses',
  //   'description' => 'One location page per real address, unique @id per location, parent Organization entity links. Avoid duplication traps.',
  //   'pillar' => 'Schema and Entity Validation'
  // ],
  [
    'slug' => 'local-seo-grifts',
    'title' => 'Local SEO Grifts That Keep Contractors Broke',
    'description' => 'The two grifts: "near me stuffing" and "templated city pages." What to demand from any SEO and non-negotiables for service businesses.',
    'pillar' => 'Playbooks by Trade'
  ]
];

// Pillars navigation
$pillars = [
  'The Local Pack System' => 'How Local Pack actually ranks',
  'Doorway Pages and Scaled Content' => 'How sites get suppressed',
  'Crawl Cleanliness and Index Control' => 'How to avoid self-sabotage',
  'Schema and Entity Validation' => 'The "golden schemata" done correctly',
  'Search Console Forensics' => 'How to catch failure modes fast',
  'Playbooks by Trade' => 'Plumber, roofer, HVAC, electrician, pest'
];

// Build JSON-LD Schema
$GLOBALS['__jsonld'] = [
  // Organization/WebSite
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/')
      ],
      [
        '@type' => 'WebSite',
        '@id' => absolute_url('/') . '#website',
        'url' => absolute_url('/'),
        'name' => 'NRLC.ai',
        'publisher' => [
          '@id' => absolute_url('/') . '#organization'
        ]
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
        'name' => 'Resources',
        'item' => absolute_url('/resources/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Local Pack Engineering',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // CollectionPage (Hub)
  [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $canonicalUrl . '#collection',
    'name' => 'Local Pack Engineering for Service Businesses',
    'description' => 'Resources teaching service businesses how Local Pack visibility actually works, what gets them suppressed (doorway clusters, scaled content abuse), and what to do instead (entity validation, crawl cleanliness, GSC forensics, schema governance).',
    'url' => $canonicalUrl,
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => absolute_url('/') . '#website'
    ],
    'mainEntity' => [
      '@type' => 'ItemList',
      '@id' => $canonicalUrl . '#itemlist'
    ],
    'inLanguage' => 'en-US'
  ],
  
  // ItemList (Articles in collection)
  [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    '@id' => $canonicalUrl . '#itemlist',
    'name' => 'Local Pack Engineering Resources',
    'description' => 'Articles on Local Pack visibility, doorway abuse prevention, schema governance, and GSC forensics for service businesses.',
    'numberOfItems' => count($localPackArticles),
    'itemListElement' => array_map(function($article, $index) {
      return [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $article['title'],
        'item' => [
          '@type' => 'Article',
          '@id' => absolute_url('/en-us/resources/local-pack/' . $article['slug'] . '/') . '#article',
          'headline' => $article['title'],
          'description' => $article['description'],
          'url' => absolute_url('/en-us/resources/local-pack/' . $article['slug'] . '/')
        ]
      ];
    }, $localPackArticles, array_keys($localPackArticles))
  ],
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Local Pack Engineering for Service Businesses',
    'url' => $canonicalUrl,
    'description' => 'Resources teaching service businesses how Local Pack visibility actually works, what gets them suppressed, and what to do instead.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => absolute_url('/') . '#website'
    ],
    'inLanguage' => 'en-US'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Local Pack Engineering for Service Businesses</h1>
        </div>
        <div class="content-block__body">
          <p class="lead text-lg" style="font-size: 1.25rem; margin-bottom: var(--spacing-lg);">
            Local SEO isn't keyword strings. It's entity proof + crawl cleanliness + intent alignment + trust signals, measured in Search Console.
          </p>
          
          <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);">
            <p style="margin: 0; font-size: 1rem; line-height: 1.6;">
              <strong>Note:</strong> This resource section teaches service businesses how Local Pack visibility actually works, what gets them suppressed (doorway clusters, scaled content abuse), and what to do instead (entity validation, crawl cleanliness, GSC forensics, and schema governance), without the grifter "just make 50 city pages" playbook.
            </p>
          </div>
          
          <div class="btn-group" style="margin-top: var(--spacing-lg);">
            <a href="<?= absolute_url('/en-us/resources/local-pack/city-service-pages-doorway-risk/') ?>" class="btn btn--primary" title="Start: City + Service Pages Are the New Near Me Spam">Start Reading</a>
            <a href="<?= absolute_url('/en-us/resources/') ?>" class="btn btn--secondary" title="Back to Resources">Back to Resources</a>
          </div>
        </div>
      </div>

      <!-- Resource Pillars Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Resource Pillars</h2>
        </div>
        <div class="content-block__body">
          <p>This hub is organized into six core pillars:</p>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-lg); margin-top: var(--spacing-lg);">
            <?php 
            $pillarColors = ['#f0f7ff', '#e8f4f8', '#f0f7ff', '#e8f4f8', '#f0f7ff', '#e8f4f8'];
            $pillarIndex = 0;
            foreach ($pillars as $pillar => $description): 
            ?>
            <div style="background: <?= $pillarColors[$pillarIndex % count($pillarColors)] ?>; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
              <h3 class="heading-3" style="margin-top: 0;"><?= htmlspecialchars($pillar) ?></h3>
              <p style="margin: 0;"><?= htmlspecialchars($description) ?></p>
            </div>
            <?php 
            $pillarIndex++;
            endforeach; 
            ?>
          </div>
        </div>
      </div>

      <!-- Articles Grid -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Articles</h2>
        </div>
        <div class="content-block__body">
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-lg); margin-top: var(--spacing-lg);">
            <?php foreach ($localPackArticles as $article): ?>
            <div style="background: #f9f9f9; border-left: 4px solid #0066cc; padding: var(--spacing-md); border-radius: 4px;">
              <h3 class="heading-3" style="margin-top: 0;">
                <a href="<?= absolute_url('/en-us/resources/local-pack/' . $article['slug'] . '/') ?>" title="<?= htmlspecialchars($article['title']) ?>">
                  <?= htmlspecialchars($article['title']) ?>
                </a>
              </h3>
              <p style="margin-bottom: var(--spacing-md);"><?= htmlspecialchars($article['description']) ?></p>
              <p style="font-size: 0.875rem; color: #666; margin-bottom: var(--spacing-md);"><strong>Pillar:</strong> <?= htmlspecialchars($article['pillar']) ?></p>
              <a href="<?= absolute_url('/en-us/resources/local-pack/' . $article['slug'] . '/') ?>" class="btn btn--primary btn--small" title="Read: <?= htmlspecialchars($article['title']) ?>">Read Article</a>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Foundation Sources -->
      <!-- Foundation Sources Section (standardized policy citations) -->
      <?= render_policy_citations() ?>
      
    </div>
  </section>
</main>
