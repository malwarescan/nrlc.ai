<?php
/**
 * Why "Near Me" Doesn't Rank You (And What Actually Does)
 * URL: /resources/local-pack/near-me-myth/
 */

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/person_entity.php';
require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/en-us/resources/local-pack/near-me-myth/');

$GLOBALS['__page_slug'] = 'resources/local-pack/near-me-myth';
$GLOBALS['__page_meta'] = [
  'title' => 'Why "Near Me" Doesn\'t Rank You (And What Actually Does) | Local Pack Rankings | NRLC.ai',
  'description' => '"Near me" is interpreted as local intent, not a keyword you must paste. Learn what actually moves the needle in Local Pack rankings: entity legitimacy, relevance, and proximity as a constraint.',
  'canonicalPath' => '/resources/local-pack/near-me-myth/',
  'keywords' => 'near me SEO, local pack rankings, local intent, entity legitimacy, proximity, local SEO myths'
];

$faqItems = [
  [
    'question' => 'Do I need to include "near me" in my title tags to rank in Local Pack?',
    'answer' => 'No. "Near me" is interpreted as local intent by Google, not a keyword you must paste. Stuffing "near me" in title tags is a quality downgrade and can trigger spam signals.'
  ],
  [
    'question' => 'What actually moves the needle in Local Pack rankings?',
    'answer' => 'Priority order: (1) Entity legitimacy and prominence signals (GBP verification, citations, reviews), (2) Relevance (category fit + service clarity), (3) Proximity as a constraint (not an excuse). Proximity matters, but only after entity legitimacy and relevance are established.'
  ],
  [
    'question' => 'Where is "near me" language acceptable?',
    'answer' => 'In FAQ or body copy once, naturally, aligned to user language. Never in title/H1 spam blocks. Use it where users would naturally say it, not as a keyword stuffing tactic.'
  ]
];

$GLOBALS['__jsonld'] = [
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
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Resources', 'item' => absolute_url('/resources/')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => 'Local Pack Engineering', 'item' => absolute_url('/en-us/resources/local-pack/')],
      ['@type' => 'ListItem', 'position' => 4, 'name' => 'Why "Near Me" Doesn\'t Rank You', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Why "Near Me" Doesn\'t Rank You (And What Actually Does)',
    'description' => '"Near me" is interpreted as local intent, not a keyword you must paste. Learn what actually moves the needle in Local Pack rankings: entity legitimacy, relevance, and proximity as a constraint.',
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
      'logo' => ['@type' => 'ImageObject', 'url' => absolute_url('/logo.png')]
    ],
    'datePublished' => '2025-01-17',
    'dateModified' => date('Y-m-d'),
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage'],
    'articleSection' => 'Local Pack Engineering',
    'keywords' => ['near me SEO', 'local pack rankings', 'local intent', 'entity legitimacy', 'proximity', 'local SEO myths'],
    'inLanguage' => 'en-US'
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => array_map(function($item) {
      return [
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']]
      ];
    }, $faqItems)
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Why "Near Me" Doesn\'t Rank You (And What Actually Does)',
    'url' => $canonicalUrl,
    'description' => '"Near me" is interpreted as local intent, not a keyword you must paste. Learn what actually moves the needle.',
    'isPartOf' => ['@type' => 'WebSite', '@id' => absolute_url('/') . '#website'],
    'inLanguage' => 'en-US'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title">Why "Near Me" Doesn't Rank You (And What Actually Does)</h1>
        </div>
        <div class="content-block__body">
          <p class="lead">"Near me" is interpreted as local intent, not a keyword you must paste. Stuffing it in title tags is a quality downgrade that can trigger spam signals.</p>
        </div>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">"Near Me" Is Interpreted as Local Intent, Not a Keyword You Must Paste</h2>
        </div>
        <div class="content-block__body">
          <p>When users search "plumber near me," Google understands the local intent without requiring you to include "near me" in your title tags. The search engine interprets the query as:</p>
          <ul>
            <li>User wants a plumber</li>
            <li>User wants results close to their location</li>
            <li>User wants to see Local Pack results</li>
          </ul>
          <p>You don't need to mirror this language in your content. Google's algorithm handles local intent automatically.</p>
        </div>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why Stuffing It Is a Quality Downgrade</h2>
        </div>
        <div class="content-block__body">
          <p>Including "near me" in title tags, H1s, or repeated throughout content:</p>
          <ul>
            <li><strong>Signals keyword stuffing:</strong> Over-optimization triggers quality filters</li>
            <li><strong>Reduces readability:</strong> "Plumber Near Me Near Me" reads like spam</li>
            <li><strong>Wastes valuable title space:</strong> Title tags have ~60 character limits; use them for service clarity, not keyword repetition</li>
            <li><strong>Can trigger doorway abuse flags:</strong> Combined with templated geo pages, "near me" stuffing reinforces scaled content abuse patterns</li>
          </ul>
        </div>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Actually Moves the Needle (Priority Order)</h2>
        </div>
        <div class="content-block__body">
          <h3 class="heading-3">1. Entity Legitimacy and Prominence Signals</h3>
          <p><strong>This is the foundation.</strong> Before proximity matters, Google must trust your entity:</p>
          <ul>
            <li><strong>Google Business Profile verification:</strong> Verified, complete, accurate</li>
            <li><strong>Citation consistency:</strong> NAP (Name, Address, Phone) matches exactly across GBP, website, and citations</li>
            <li><strong>Review signals:</strong> Real reviews from real customers, not fake review farms</li>
            <li><strong>Entity prominence:</strong> Mentions in local directories, industry associations, news coverage</li>
          </ul>
          
          <h3 class="heading-3">2. Relevance (Category Fit + Service Clarity)</h3>
          <p><strong>After legitimacy, relevance determines ranking.</strong></p>
          <ul>
            <li><strong>Category alignment:</strong> Your GBP categories match the services you actually offer</li>
            <li><strong>Service clarity:</strong> Your website clearly describes what you do, who you serve, and where you operate</li>
            <li><strong>Content alignment:</strong> Your service pages match the queries users actually search</li>
            <li><strong>Schema accuracy:</strong> LocalBusiness schema matches your actual business type and services</li>
          </ul>
          
          <h3 class="heading-3">3. Proximity as a Constraint, Not an Excuse</h3>
          <p><strong>Proximity matters, but only after entity legitimacy and relevance are established.</strong></p>
          <p>If you're not legitimate and relevant, being "near" won't help. If you are legitimate and relevant, proximity becomes the tiebreaker:</p>
          <ul>
            <li>User in Austin searches "plumber"</li>
            <li>Google shows legitimate, relevant plumbers</li>
            <li>Among equally legitimate/relevant options, closer ones rank higher</li>
          </ul>
          <p>Proximity is a constraint, not an excuse to skip entity work.</p>
        </div>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Where "Near Me" Language Is Acceptable</h2>
        </div>
        <div class="content-block__body">
          <p>You can use "near me" language naturally, but only where users would naturally say it:</p>
          
          <h3 class="heading-3">Acceptable Uses</h3>
          <ul>
            <li><strong>FAQ sections:</strong> "Do you serve customers near me?" (natural user question)</li>
            <li><strong>Body copy:</strong> "We provide emergency plumbing services to customers near you" (natural language)</li>
            <li><strong>Service area descriptions:</strong> "We serve Austin and surrounding areas near you" (informative, not keyword stuffing)</li>
          </ul>
          
          <h3 class="heading-3">Never Do This</h3>
          <ul>
            <li><strong>Title tags:</strong> "Plumber Near Me | Near Me Plumber | Plumber Near Me Austin"</li>
            <li><strong>H1 spam blocks:</strong> "Plumber Near Me | Emergency Plumber Near Me | 24/7 Plumber Near Me"</li>
            <li><strong>Repeated stuffing:</strong> Using "near me" 10+ times on a single page</li>
            <li><strong>Meta descriptions:</strong> "Best plumber near me. Call plumber near me today. Plumber near me available 24/7."</li>
          </ul>
        </div>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Bottom Line</h2>
        </div>
        <div class="content-block__body">
          <p>Focus on entity legitimacy, relevance, and service clarity. Proximity will follow. Don't stuff "near me" in your titles. It's a quality downgrade that can hurt more than help.</p>
        </div>
      </div>
      
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Resources</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/city-service-pages-doorway-risk/') ?>">City + Service Pages Are the New "Near Me" Spam</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/gsc-local-forensics/') ?>">Search Console Forensics for Local Businesses</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/') ?>">Local Pack Engineering Hub</a></li>
          </ul>
        </div>
      </div>
      
    </div>
  </section>
</main>
