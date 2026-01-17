<?php
/**
 * Search Console Forensics for Local Businesses
 * URL: /resources/local-pack/gsc-local-forensics/
 */

require_once __DIR__.'/../../../lib/helpers.php';
require_once __DIR__.'/../../../lib/person_entity.php';
require_once __DIR__.'/../../../lib/schema_builders.php';

$canonicalUrl = absolute_url('/en-us/resources/local-pack/gsc-local-forensics/');

$GLOBALS['__page_slug'] = 'resources/local-pack/gsc-local-forensics';
$GLOBALS['__page_meta'] = [
  'title' => 'Search Console Forensics for Local Businesses | GSC Local Pack Debug | NRLC.ai',
  'description' => 'Learn the four failure modes GSC reveals fast: indexed but not ranking, crawled not indexed, canonical chosen by Google, and discovery + crawl waste. Exact workflows to catch suppression onset.',
  'canonicalPath' => '/resources/local-pack/gsc-local-forensics/',
  'keywords' => 'Google Search Console, local pack debugging, GSC forensics, indexing issues, canonical issues, local SEO troubleshooting'
];

$faqItems = [
  [
    'question' => 'What are the four failure modes GSC reveals for local businesses?',
    'answer' => 'The four failure modes are: (1) Indexed but not ranking (quality/intent mismatch), (2) Crawled not indexed (thin/duplicate/soft value), (3) Canonical chosen by Google (self-canonical drift, duplication), (4) Discovery + crawl waste (parameter bloat, thin geo folders).'
  ],
  [
    'question' => 'How do I check if my geo pages are being suppressed?',
    'answer' => 'In GSC Pages report: filter by folder (/service-area/ or /locations/), compare date ranges (28 vs previous 28) to catch suppression onset, check "Crawled not indexed" status, and look for "Duplicate, Google chose different canonical" warnings.'
  ],
  [
    'question' => 'What does "Duplicate, Google chose different canonical" mean?',
    'answer' => 'This means you have near-identical pages competing, and Google selected a different canonical than you specified. This often indicates doorway page clustering or duplicate content issues that need consolidation.'
  ],
  [
    'question' => 'How do I use URL Inspection to debug local pack issues?',
    'answer' => 'In URL Inspection, check: (1) Canonical URL (does it match your intended canonical?), (2) Indexing status (is it indexed or excluded?), (3) Last crawl date (is Google crawling it regularly?), (4) Mobile usability (does it pass mobile-friendly test?).'
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
        'publisher' => ['@id' => absolute_url('/') . '#organization']
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
      ['@type' => 'ListItem', 'position' => 4, 'name' => 'Search Console Forensics', 'item' => $canonicalUrl]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'TechArticle',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Search Console Forensics for Local Businesses',
    'description' => 'Learn the four failure modes GSC reveals fast and exact workflows to catch suppression onset before it impacts visibility.',
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
    'keywords' => ['Google Search Console', 'local pack debugging', 'GSC forensics', 'indexing issues', 'canonical issues', 'local SEO troubleshooting'],
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
    'name' => 'Search Console Forensics for Local Businesses',
    'url' => $canonicalUrl,
    'description' => 'Learn the four failure modes GSC reveals fast and exact workflows to catch suppression onset.',
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
          <h1 class="content-block__title">Search Console Forensics for Local Businesses</h1>
        </div>
        
        <div class="content-block__body">
          
          <p class="lead">Google Search Console reveals four failure modes fast. Learn exact workflows to catch suppression onset before it impacts visibility.</p>
          
          <h2>The Four Failure Modes GSC Reveals Fast</h2>
          
          <h3>1. Indexed but Not Ranking (Quality / Intent Mismatch)</h3>
          <p><strong>Symptom:</strong> Pages are indexed, but they don't appear in search results for relevant queries.</p>
          <p><strong>What it means:</strong> Google sees your page, but quality signals or intent alignment aren't strong enough to rank it. This often happens with:</p>
          <ul>
            <li>Thin content that doesn't fully answer user queries</li>
            <li>Service pages that don't match the actual services you offer</li>
            <li>Content that targets keywords but doesn't match user intent</li>
          </ul>
          
          <h3>2. Crawled Not Indexed (Thin/Duplicate/Soft Value)</h3>
          <p><strong>Symptom:</strong> Google crawls your pages but chooses not to index them.</p>
          <p><strong>What it means:</strong> Your pages are too thin, too duplicate, or don't provide enough unique value. Common causes:</p>
          <ul>
            <li>Templated geo pages with 70%+ identical content</li>
            <li>Pages that duplicate content from other pages on your site</li>
            <li>Pages with minimal content that doesn't add value</li>
          </ul>
          
          <h3>3. Canonical Chosen by Google (Self-Canonical Drift, Duplication)</h3>
          <p><strong>Symptom:</strong> GSC shows "Duplicate, Google chose different canonical than user."</p>
          <p><strong>What it means:</strong> You have near-identical pages competing, and Google selected a different canonical than you specified. This indicates:</p>
          <ul>
            <li>Doorway page clustering (Google groups similar pages and picks one)</li>
            <li>Duplicate content issues that need consolidation</li>
            <li>Canonical tag conflicts or missing canonical tags</li>
          </ul>
          
          <h3>4. Discovery + Crawl Waste (Parameter Bloat, Thin Geo Folders)</h3>
          <p><strong>Symptom:</strong> Google discovers and crawls many pages, but most don't get indexed or ranked.</p>
          <p><strong>What it means:</strong> Your site structure creates crawl waste:</p>
          <ul>
            <li>URL parameters creating duplicate content (e.g., <code>?city=austin&service=plumber</code>)</li>
            <li>Thin geo folders with hundreds of similar pages</li>
            <li>Pagination or filtering creating excessive URL variations</li>
          </ul>
          
          <h2>Exact GSC Workflows</h2>
          
          <h3>Pages Report: Filter by Folder</h3>
          <p><strong>Workflow:</strong></p>
          <ol>
            <li>Go to <strong>Pages</strong> report in GSC</li>
            <li>Filter by folder: <code>/service-area/</code> or <code>/locations/</code> or your geo folder</li>
            <li>Check indexing status: Look for "Crawled not indexed" or "Excluded" pages</li>
            <li>Sort by "Last crawl" to see which pages Google is actively crawling</li>
          </ol>
          
          <h3>Compare Date Ranges (28 vs Previous 28)</h3>
          <p><strong>Workflow:</strong></p>
          <ol>
            <li>In <strong>Pages</strong> or <strong>Performance</strong> report, set date range to last 28 days</li>
            <li>Compare to previous 28 days</li>
            <li>Look for sudden drops in:</li>
            <ul>
              <li>Indexed pages count</li>
              <li>Impressions</li>
              <li>Clicks</li>
              <li>Average position</li>
            </ul>
            <li>If you see drops after a spam update window (check <a href="https://status.search.google.com/" target="_blank" rel="noopener noreferrer">Search Status Dashboard</a>), prioritize pruning and consolidation</li>
          </ol>
          
          <h3>Queries Report: Isolate Query Types</h3>
          <p><strong>Workflow:</strong></p>
          <ol>
            <li>Go to <strong>Performance</strong> > <strong>Queries</strong></li>
            <li>Filter queries containing "near me"</li>
            <li>Compare to queries with city names only</li>
            <li>Compare to service-only queries (no location)</li>
            <li>Identify which query types are driving traffic (or not)</li>
          </ol>
          
          <h3>URL Inspection: See Canonical, Indexing, Last Crawl</h3>
          <p><strong>Workflow:</strong></p>
          <ol>
            <li>Use <strong>URL Inspection</strong> tool for specific pages</li>
            <li>Check <strong>Canonical URL:</strong> Does it match your intended canonical?</li>
            <li>Check <strong>Indexing status:</strong> Is it indexed or excluded? Why?</li>
            <li>Check <strong>Last crawl date:</strong> Is Google crawling it regularly?</li>
            <li>Check <strong>Mobile usability:</strong> Does it pass mobile-friendly test?</li>
          </ol>
          
          <h3>Sitemaps: Detect Bloat and Stale Lastmod Spam</h3>
          <p><strong>Workflow:</strong></p>
          <ol>
            <li>Go to <strong>Sitemaps</strong> report</li>
            <li>Check how many URLs are in your sitemap</li>
            <li>Look for sitemaps with thousands of geo pages (potential bloat)</li>
            <li>Check <strong>lastmod</strong> dates: Are they all the same date? (stale lastmod spam)</li>
            <li>Compare sitemap URLs to indexed pages: Large gap indicates suppression</li>
          </ol>
          
          <h2>The "Local Pack Debug Checklist"</h2>
          <div style="background: #f5f5f5; border-left: 4px solid #1976d2; padding: 1.5rem; margin: 1.5rem 0;">
            <h3 style="margin-top: 0;">Use this checklist to diagnose local pack issues:</h3>
            <ul>
              <li><strong>If impressions are rising but clicks are dead:</strong> Snippet mismatch or wrong landing page. Your page isn't matching what users expect.</li>
              <li><strong>If "Duplicate, Google chose different canonical":</strong> You have near-identical pages competing. Consolidate using 301 redirects.</li>
              <li><strong>If geo pages are "Crawled not indexed":</strong> You're tripping thin/duplicate thresholds. Prune identical pages, add unique content.</li>
              <li><strong>If you see indexing volatility after a spam update window:</strong> Prioritize pruning and consolidation (not publishing more pages). Check <a href="https://status.search.google.com/" target="_blank" rel="noopener noreferrer">Search Status Dashboard</a> for update dates.</li>
              <li><strong>If sitemap has 500+ geo pages but only 50 are indexed:</strong> You have doorway page suppression. Consolidate immediately.</li>
            </ul>
          </div>
          
          <h2>What to Do When You Find Issues</h2>
          <ol>
            <li><strong>Document the failure mode</strong> (which of the four applies?)</li>
            <li><strong>Identify the root cause</strong> (doorway pages? thin content? canonical issues?)</li>
            <li><strong>Create a consolidation plan</strong> (which pages to merge, redirect, or remove)</li>
            <li><strong>Implement fixes</strong> (301 redirects, content consolidation, canonical fixes)</li>
            <li><strong>Monitor GSC weekly</strong> for improvements or new issues</li>
          </ol>
          
          <h2>Related Resources</h2>
          <ul>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/city-service-pages-doorway-risk/') ?>">City + Service Pages Are the New "Near Me" Spam</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/near-me-myth/') ?>">Why "Near Me" Doesn't Rank You</a></li>
            <li><a href="<?= absolute_url('/en-us/resources/local-pack/') ?>">Local Pack Engineering Hub</a></li>
          </ul>
          
        </div>
      </div>
      
    </div>
  </section>
</main>
