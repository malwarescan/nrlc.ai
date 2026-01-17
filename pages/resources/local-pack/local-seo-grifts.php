<?php
/**
 * Local SEO Grifts That Keep Contractors Broke
 * URL: /resources/local-pack/local-seo-grifts/
 * 
 * Flagship problem-first page breaking the two grifts as the same failure mode.
 * Sentence-by-sentence skeleton implementation.
 */

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/person_entity.php';
require_once __DIR__.'/../../../lib/schema_builders.php';
require_once __DIR__.'/../../../lib/policy_citations.php';

$canonicalUrl = absolute_url('/en-us/resources/local-pack/local-seo-grifts/');

// Set page metadata
$GLOBALS['__page_slug'] = 'resources/local-pack/local-seo-grifts';
$GLOBALS['__page_meta'] = [
  'title' => 'Local SEO Grifts That Keep Contractors Broke | Doorway Abuse & Scaled Content | NRLC.ai',
  'description' => 'The two grifts: "near me stuffing" and "templated city pages." What to demand from any SEO and non-negotiables for service businesses.',
  'canonicalPath' => '/resources/local-pack/local-seo-grifts/',
  'keywords' => 'local SEO grifts, doorway abuse, scaled content abuse, near me stuffing, city pages, service businesses, contractors, Google spam policies'
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
        'item' => absolute_url('/en-us/resources/local-pack/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => 'Local SEO Grifts That Keep Contractors Broke',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Local SEO Grifts That Keep Contractors Broke',
    'description' => 'The two grifts: "near me stuffing" and "templated city pages." What to demand from any SEO and non-negotiables for service businesses.',
    'url' => $canonicalUrl,
    'author' => [
      '@id' => JOEL_PERSON_ID,
      '@type' => 'Person',
      'name' => 'Joel David Maldonado',
      'url' => JOEL_ENTITY_HOME_URL
    ],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => absolute_url('/logo.png')
      ]
    ],
    'datePublished' => '2025-01-17',
    'dateModified' => date('Y-m-d'),
    'mainEntityOfPage' => [
      '@type' => 'WebPage',
      '@id' => $canonicalUrl . '#webpage'
    ],
    'articleSection' => 'Local Pack Engineering',
    'keywords' => ['local SEO grifts', 'doorway abuse', 'scaled content abuse', 'near me stuffing', 'city pages', 'service businesses', 'contractors', 'Google spam policies'],
    'inLanguage' => 'en-US',
    'about' => [
      '@type' => 'DefinedTerm',
      'name' => 'Local SEO Grifts',
      'description' => 'Tactics that exploit service businesses through doorway abuse and scaled content abuse patterns.'
    ]
  ],
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Local SEO Grifts That Keep Contractors Broke',
    'url' => $canonicalUrl,
    'description' => 'The two grifts: "near me stuffing" and "templated city pages." What to demand from any SEO and non-negotiables for service businesses.',
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
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Local SEO Grifts That Keep Contractors Broke</h1>
        </div>
        <div class="content-block__body">
          
          <!-- INTRO (top 8–12 sentences) -->
          <p>If someone tells you to rank "near me" by stuffing it into titles and headers, you're being sold a string trick.</p>
          
          <p>If someone tells you to make 30 city pages by swapping the city name, you're being sold the same string trick with more paperwork.</p>
          
          <p>Different wrapper, same failure mode: hacking phrases instead of proving an entity.</p>
          
          <p>And it's popular because it's easy to pitch to a service business owner who's desperate to rank.</p>
          
          <p>It sometimes produces a little movement, just enough to keep a contract alive.</p>
          
          <p>Then the explanations start: "Google volatility," "competition," "we need more pages."</p>
          
          <p>Meanwhile the site gets noisier, not clearer.</p>
          
          <p>Local visibility doesn't come from keyword theatrics.</p>
          
          <p>It comes from entity proof, intent alignment, and crawl cleanliness.</p>
          
          <p>This page explains the trap, why it works just enough to be profitable for grifters, and what the system actually rewards.</p>
          
        </div>
      </div>
      
      <!-- FALSE ASSUMPTION BREAK (next 6–10 sentences, immediately after intro) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The False Assumption</h2>
        </div>
        <div class="content-block__body">
          <p>The false assumption is that Local Pack is a text ranking game.</p>
          
          <p>It isn't.</p>
          
          <p>Local Pack is entity-first.</p>
          
          <p>Your site supports the entity, but it doesn't replace entity legitimacy.</p>
          
          <p>So when people focus on strings, they're optimizing the part that matters least.</p>
          
          <p>Worse: they create patterns that look like manipulation.</p>
          
          <p>And Google has explicit policy language for that pattern.</p>
          
          <p>If you've been told to "scale location pages" with light edits, read the policy definitions and you'll see why that's high-risk.</p>
        </div>
      </div>
      
      <!-- MECHANISM INTRO (middle section, 10–14 sentences) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Mechanism</h2>
        </div>
        <div class="content-block__body">
          <p>There are two policy buckets that map to the "city page farm" play.</p>
          
          <p>First: doorway abuse.</p>
          
          <p>Second: scaled content abuse.</p>
          
          <p>Doorway abuse is when pages exist mainly to rank for similar searches rather than provide distinct value.</p>
          
          <p>Scaled content abuse is when large amounts of unoriginal content are produced primarily to manipulate rankings.</p>
          
          <p>City-service templates can land in both buckets when they're thin and repetitive.</p>
          
          <p>The risk isn't theoretical; the web is full of local sites that quietly get clustered, suppressed, or ignored.</p>
          
          <p>Not because one page is "bad," but because the pattern across the site is obvious.</p>
          
          <p>Near-me stuffing is the same pattern: trying to force relevance with a phrase.</p>
          
          <p>That's why the two tactics usually travel together.</p>
          
          <p>They're not strategy; they're a script.</p>
        </div>
      </div>
      
      <!-- POLICY CITATION BLOCK (short, hard anchored; place immediately after sentence 29) -->
      <?= render_policy_citations() ?>
      
      <!-- CATEGORY NAMING MOMENT (final third; 6–10 sentences) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Actually Works</h2>
        </div>
        <div class="content-block__body">
          <p>Here's the category: Local Pack visibility is an engineering problem, not a copywriting problem.</p>
          
          <p>It's identity, consistency, and proof.</p>
          
          <p>Proof that you exist as a legitimate entity.</p>
          
          <p>Proof that you provide a specific service.</p>
          
          <p>Proof that you operate in a geography.</p>
          
          <p>And proof that your site architecture isn't a template factory.</p>
          
          <p>If you don't build those proofs, you can publish pages forever and still lose.</p>
          
          <p>If you do build them, you often need fewer pages than you think.</p>
        </div>
      </div>
      
      <!-- NEUTRAL HANDOFF (last 6–8 sentences + link) -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Next Steps</h2>
        </div>
        <div class="content-block__body">
          <p>If you want the operational version of this, don't start with more pages.</p>
          
          <p>Start with crawl cleanliness, entity validation, and a tight set of pages that match real demand.</p>
          
          <p>Then use Search Console to confirm what's indexed, what's being ignored, and where cannibalization is happening.</p>
          
          <p>If you're about to build location pages, you need a rule: each page must contain unique local proof, not a swapped city name.</p>
          
          <p>If you can't produce that proof, consolidate.</p>
          
          <p>I keep the implementation-level playbooks in the Local Pack resources and schema governance section.</p>
          
          <p>Start here: <a href="<?= absolute_url('/en-us/resources/local-pack/') ?>">Local Pack Engineering Hub</a></p>
          
          <p>Then: <a href="<?= absolute_url('/en-us/resources/local-pack/schema-entity-validation/') ?>">Schema and Entity Validation</a></p>
          
          <p>Then: <a href="<?= absolute_url('/en-us/resources/local-pack/gsc-local-forensics/') ?>">Search Console Forensics</a></p>
        </div>
      </div>
      
      <!-- Related Resources -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Resources</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/city-service-pages-doorway-risk/') ?>">City + Service Pages Are the New "Near Me" Spam</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/near-me-myth/') ?>">Why "Near Me" Doesn't Rank You (And What Actually Does)</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/') ?>">Local Pack Engineering Hub</a></li>
          </ul>
        </div>
      </div>
      
    </div>
  </section>
</main>
