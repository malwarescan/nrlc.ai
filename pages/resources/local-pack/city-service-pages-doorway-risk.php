<?php
/**
 * City + Service Pages Are the New "Near Me" Spam
 * URL: /resources/local-pack/city-service-pages-doorway-risk/
 * 
 * Teaching service businesses why templated geo pages get suppressed
 * and what to build instead.
 */

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/person_entity.php';
require_once __DIR__.'/../../../lib/schema_builders.php';
require_once __DIR__.'/../../../lib/policy_citations.php';

$canonicalUrl = absolute_url('/en-us/resources/local-pack/city-service-pages-doorway-risk/');

// Set page metadata
$GLOBALS['__page_slug'] = 'resources/local-pack/city-service-pages-doorway-risk';
$GLOBALS['__page_meta'] = [
  'title' => 'City + Service Pages Are the New "Near Me" Spam | Doorway Abuse Risk | NRLC.ai',
  'description' => 'Templated geo pages and "near me" stuffing are doorway abuse. Learn why they get suppressed, how Google clusters them, and what to build instead (service hubs + case studies, not city page farms).',
  'canonicalPath' => '/resources/local-pack/city-service-pages-doorway-risk/',
  'keywords' => 'doorway pages, scaled content abuse, local SEO spam, city pages, service area pages, Google spam policies, LocalBusiness schema, local pack suppression'
];

// FAQ items
$faqItems = [
  [
    'question' => 'What is doorway abuse in local SEO?',
    'answer' => 'Doorway abuse is creating pages made to rank for specific, similar queries without adding unique value. In local SEO, this typically means templated city + service pages where 70%+ of content is identical across pages, with only city names swapped.'
  ],
  [
    'question' => 'What is scaled content abuse?',
    'answer' => 'Scaled content abuse is generating many pages primarily to manipulate rankings and not help users, typically unoriginal. Google\'s spam policies explicitly target this pattern, which includes thin geo page farms.'
  ],
  [
    'question' => 'How does Google detect and suppress doorway pages?',
    'answer' => 'Google clusters near-identical pages, selects a representative page, and suppresses the rest. The system can also drag down the entire domain\'s quality perception, not just the geo folder. This happens through SpamBrain, Google\'s AI-based spam prevention system.'
  ],
  [
    'question' => 'What is the Doorway Risk Test?',
    'answer' => 'The Doorway Risk Test checks: (1) If 70%+ of words are identical across geo pages, you\'re in the danger zone. (2) If pages have no unique photos from that area, danger. (3) If there\'s no localized proof (jobs, permits, reviews, staff presence, neighborhood language), danger. (4) If internal links point to the same conversion URL with only city swapped, danger.'
  ],
  [
    'question' => 'What should I build instead of city page farms?',
    'answer' => 'Build one strong service hub page per core service, a small number of "coverage" pages only where you can prove uniqueness, and a case study layer that serves as the scalable geo-proof system (projects, photos, testimonials, constraints, neighborhoods).'
  ]
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
        'name' => 'City + Service Pages Are the New "Near Me" Spam',
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // TechArticle
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'City + Service Pages Are the New "Near Me" Spam',
    'description' => 'Templated geo pages and "near me" stuffing are doorway abuse. Learn why they get suppressed, how Google clusters them, and what to build instead (service hubs + case studies, not city page farms).',
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
    'keywords' => ['doorway pages', 'scaled content abuse', 'local SEO spam', 'city pages', 'service area pages', 'Google spam policies', 'LocalBusiness schema', 'local pack suppression'],
    'inLanguage' => 'en-US',
    'about' => [
      '@type' => 'DefinedTerm',
      'name' => 'Doorway Abuse',
      'description' => 'Pages made to rank for specific, similar queries without adding unique value, violating Google\'s spam policies.'
    ]
  ],
  
  // FAQPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => array_map(function($item) {
      return [
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $item['answer']
        ]
      ];
    }, $faqItems)
  ],
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'City + Service Pages Are the New "Near Me" Spam',
    'url' => $canonicalUrl,
    'description' => 'Templated geo pages and "near me" stuffing are doorway abuse. Learn why they get suppressed and what to build instead.',
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
          <h1 class="content-block__title heading-1">City + Service Pages Are the New "Near Me" Spam</h1>
        </div>
        <div class="content-block__body">
          
          <!-- Answer-First: Direct answer in first sentence -->
          <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin-bottom: var(--spacing-lg);" itemscope itemtype="https://schema.org/DefinedTerm">
            <p style="margin: 0; font-size: 1.1rem; line-height: 1.6; font-weight: 600;">
              <dfn itemprop="name">Templated geo pages and "near me" stuffing are both string hacks.</dfn> They avoid the hard part: proving a real entity with real geography and real work.
            </p>
          </div>
          
          <p class="lead text-lg" style="font-size: 1.1rem; margin-bottom: var(--spacing-lg);">
            When service businesses create pages like <code>/austin-hvac/</code>, <code>/round-rock-hvac/</code>, <code>/cedar-park-hvac/</code> with 70%+ identical content, they're not building authority. They're building a suppression target.
          </p>
          
          <div class="btn-group" style="margin-top: var(--spacing-lg);">
            <a href="<?= absolute_url('/en-us/resources/local-pack/near-me-myth/') ?>" class="btn btn--primary" title="Next: Why Near Me Doesn't Rank You">Next Article</a>
            <a href="<?= absolute_url('/en-us/resources/local-pack/') ?>" class="btn btn--secondary" title="Back to Local Pack Hub">Back to Hub</a>
          </div>
        </div>
      </div>
          
      <!-- The Shared Failure Mode Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Shared Failure Mode</h2>
        </div>
        <div class="content-block__body">
          <p>"Near me" stuffing and templated geo pages are both string hacks. They avoid the hard part: proving a real entity with real geography and real work. When service businesses create pages like <code>/san-antonio-siding/</code>, <code>/new-braunfels-siding/</code>, <code>/boerne-siding/</code> with 70%+ identical content, they're not building authority. They're building a suppression target.</p>
        </div>
      </div>

      <!-- What Google Actually Calls This Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What Google Actually Calls This</h2>
        </div>
        <div class="content-block__body">
          <p>Google's spam policies explicitly define two patterns that map to thin geo page farms:</p>
          
          <h3 class="heading-3">Doorway Abuse</h3>
          <p><strong>Definition:</strong> Pages made to rank for specific, similar queries without adding unique value.</p>
          <p>This is the policy framing that maps to thin template farms where city names are swapped but content remains 70%+ identical.</p>
          
          <h3 class="heading-3">Scaled Content Abuse</h3>
          <p><strong>Definition:</strong> Many pages generated primarily to manipulate rankings and not help users, typically unoriginal.</p>
          <p>When you generate 50 city pages with swapped city names, you're in scaled content abuse territory.</p>
        </div>
      </div>
      
      <!-- Policy Citations Block (standardized format) -->
      <?= render_policy_citations() ?>

      <!-- Why It Kinda Works Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Why It "Kinda Works" Sometimes (And Why Grifters Love It)</h2>
        </div>
        <div class="content-block__body">
          <p>There's a non-zero chance of temporary visibility before clustering/suppression stabilizes. This creates a perfect grift:</p>
          <ul>
            <li><strong>Easy to sell:</strong> "We'll create 50 city pages for you" sounds impressive</li>
            <li><strong>Hard for owners to verify:</strong> They see pages indexed, assume it's working</li>
            <li><strong>Easy to drag out for 90 days:</strong> "Give it time to rank" while suppression builds</li>
          </ul>
        </div>
      </div>

      <!-- The Deduplication Reality Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Deduplication Reality (How Thin Geo Pages Die)</h2>
        </div>
        <div class="content-block__body">
          <p>Here's what actually happens:</p>
          <ol>
            <li><strong>Near-identical pages get clustered.</strong> Google's SpamBrain system identifies pages with 70%+ similarity.</li>
            <li><strong>The system selects a representative and suppresses the rest.</strong> One page might rank; the other 49 get demoted or de-indexed.</li>
            <li><strong>The "site quality" perception can drag the whole domain down.</strong> It's not just the geo folder. Your entire site's trust signals can suffer.</li>
          </ol>
        </div>
      </div>

      <!-- The Replacement Strategy Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The Replacement Strategy (What to Build Instead)</h2>
        </div>
        <div class="content-block__body">
          <p>Instead of city page farms, build:</p>
          
          <h3 class="heading-3">1. One Strong Service Hub Page Per Core Service</h3>
          <p>Create a comprehensive service page that covers the service itself, not 50 variations. Example: <code>/hvac-services/</code> instead of <code>/austin-hvac/</code>, <code>/round-rock-hvac/</code>, etc.</p>
          
          <h3 class="heading-3">2. A Small Number of "Coverage" Pages Only Where You Can Prove Uniqueness</h3>
          <p>If you have a real office, real jobs, real permits, real reviews, or real staff presence in a specific city, create ONE page for that city. But only if you can prove it with unique content, photos, and localized proof.</p>
          
          <h3 class="heading-3">3. A Case Study Layer That Is the Scalable Geo-Proof System</h3>
          <p>Case studies are your scalable geo-proof system. Each project has:</p>
          <ul>
            <li>Real photos from that location</li>
            <li>Testimonials with neighborhood context</li>
            <li>Project constraints and specifics</li>
            <li>Neighborhood language and local references</li>
          </ul>
          <p>This proves real work in real places without creating doorway pages.</p>
        </div>
      </div>

      <!-- Doorway Risk Test Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">The "Doorway Risk Test" Checklist</h2>
        </div>
        <div class="content-block__body">
          <div style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin: var(--spacing-lg) 0;">
            <h3 class="heading-3" style="margin-top: 0;">Use this checklist to assess your geo pages:</h3>
            <ul>
              <li><strong>If 70%+ of the words are identical across geo pages,</strong> you are in the danger zone.</li>
              <li><strong>If the page has no unique photos from that area,</strong> danger.</li>
              <li><strong>If there is no localized proof</strong> (jobs, permits context, reviews, staff presence, neighborhood language), danger.</li>
              <li><strong>If internal links point to the same conversion URL with only city swapped,</strong> danger.</li>
              <li><strong>If these pages exist primarily to capture query permutations,</strong> danger under scaled content abuse framing.</li>
            </ul>
            <p><strong>If you answer "yes" to 3+ items, you're likely in doorway abuse territory.</strong></p>
          </div>
        </div>
      </div>

      <!-- What to Do Next Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">What to Do Next</h2>
        </div>
        <div class="content-block__body">
          <p>If you have doorway pages:</p>
          <ol>
            <li><strong>Audit your geo pages</strong> using the Doorway Risk Test above</li>
            <li><strong>Consolidate identical pages</strong> using 301 redirects to your service hub</li>
            <li><strong>Keep only pages with unique proof</strong> (real photos, real jobs, real reviews from that area)</li>
            <li><strong>Build case studies</strong> as your scalable geo-proof system</li>
            <li><strong>Monitor Search Console</strong> for indexing and ranking changes after consolidation</li>
          </ol>
        </div>
      </div>

      <!-- Related Resources Section -->
      <div class="content-block module">
        <div class="content-block__header">
          <h2 class="content-block__title heading-2">Related Resources</h2>
        </div>
        <div class="content-block__body">
          <ul>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/near-me-myth/') ?>">Why "Near Me" Doesn't Rank You (And What Actually Does)</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/gsc-local-forensics/') ?>">Search Console Forensics for Local Businesses</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/') ?>">Local Pack Engineering Hub</a></li>
          </ul>
          
        </div>
      </div>
      
    </div>
  </section>
</main>
