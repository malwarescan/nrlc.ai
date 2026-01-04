<?php
declare(strict_types=1);
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/hreflang.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$brand='NRLC.ai'; $domain='https://nrlc.ai'; $contact='team@nrlc.ai';

$csv = __DIR__ . '/../../data/catalog.csv';
$rows = [];
if (is_file($csv)) {
  if (($fp=fopen($csv,'r'))!==false) {
    $hdr = fgetcsv($fp, escape: '\\');
    while(($r=fgetcsv($fp, escape: '\\'))!==false){ 
      $rows[] = array_combine($hdr,$r); 
    }
    fclose($fp);
  }
}

// Separate services and software for better organization
$services = array_filter($rows, fn($r) => ($r['type'] ?? '') === 'service');
$software = array_filter($rows, fn($r) => ($r['type'] ?? '') === 'software');
$products = array_filter($rows, fn($r) => ($r['type'] ?? '') !== 'service' && ($r['type'] ?? '') !== 'software');

// Build ItemList for JSON-LD
$itemListItems = [];
$position = 1;
foreach ($rows as $it) {
  $itemUrl = $domain . '/catalog/' . ($it['slug'] ?? '') . '/';
  if (!empty($it['slug'])) {
    $itemListItems[] = [
      '@type' => 'ListItem',
      'position' => $position++,
      'name' => $it['name'] ?? '',
      'item' => $itemUrl
    ];
  }
}

// Updated title and meta description per directive
$title = 'AI SEO Services & Tools Catalog — Neural Command';
$desc = 'Explore the Neural Command catalog of AI SEO services, structured data tools, and AI-visibility solutions. Improve AI engine comprehension, citation readiness, semantic retrieval, and structured retrieval performance.';

$GLOBALS['__page_slug'] = 'catalog/index';
// Set metadata in router format
$GLOBALS['__page_meta'] = [
  'title' => $title,
  'description' => $desc,
  'canonicalPath' => '/catalog/'
];
// Legacy format for backwards compatibility
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $desc;

// JSON-LD Schema
$canonicalUrl = $domain . '/catalog/';
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    '@id' => $canonicalUrl . '#itemlist',
    'name' => 'AI SEO Services & Tools Catalog',
    'description' => $desc,
    'itemListElement' => $itemListItems
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $domain . '/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Catalog',
        'item' => $canonicalUrl
      ]
    ]
  ],
  ld_organization()
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Catalog Header Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI SEO Services & Tools Catalog</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">The Neural Command catalog provides AI SEO services, structured data tools, and AI-visibility solutions designed to improve AI engine comprehension, citation readiness, and semantic retrieval performance. Our services and tools address the core challenges of generative AI indexing: ensuring that AI systems can accurately retrieve, understand, and cite your content.</p>
        <p>This catalog includes professional AI SEO services for enterprise teams, structured data implementation tools for developers, and open source utilities for semantic retrieval optimization. Each offering is designed to improve how AI systems—including ChatGPT, Google AI Overviews, and answer engines—comprehend, index, and reference your content. Whether you need crawl clarity engineering to reduce crawl waste, JSON-LD strategy for structured data implementation, or LLM seeding for citation readiness, our catalog provides solutions that enhance AI engine comprehension and structured retrieval performance.</p>
        <p><strong>Enterprise impact:</strong> Our AI SEO services and structured data tools help organizations achieve measurable improvements in AI visibility, citation frequency, and semantic retrieval accuracy. <strong>AI visibility improvement:</strong> By optimizing for AI engine comprehension and citation readiness, businesses increase their chances of being referenced in AI-generated answers and search results.</p>
      </div>
    </div>

    <!-- Services Section -->
    <?php if (!empty($services)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI SEO Services</h2>
      </div>
      <div class="content-block__body">
        <p>Professional AI SEO services designed to improve AI engine comprehension, citation readiness, and semantic retrieval. Each service includes implementation, documentation, and ongoing support for enterprise teams.</p>
        <div class="grid grid-auto-fit">
          <?php foreach ($services as $it):
            $u = '/catalog/' . $it['slug'] . '/';
            $description = $it['description'] ?? $it['short'] ?? '';
            $landingUrl = !empty($it['landing_url']) ? $it['landing_url'] : null;
            if ($landingUrl && preg_match('#^https?://[^/]+(/.+)$#', $landingUrl, $m)) {
              $landingUrl = $m[1];
            }
          ?>
            <div class="content-block">
              <div class="content-block__header">
                <h3 class="content-block__title"><?= htmlspecialchars($it['name']) ?></h3>
              </div>
              <div class="content-block__body">
                <p><?= htmlspecialchars($it['short']) ?></p>
                <?php if ($description && $description !== $it['short']): ?>
                  <p class="small muted"><?= htmlspecialchars(substr($description, 0, 200)) ?><?= strlen($description) > 200 ? '...' : '' ?></p>
                <?php endif; ?>
                
                <div class="btn-group" style="margin-top: 1rem;">
                  <?php if ($landingUrl): ?>
                    <a href="<?= htmlspecialchars($landingUrl) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service for AI engine comprehension and citation readiness" class="btn btn--primary">Learn more: <?= htmlspecialchars($it['name']) ?> for AI visibility</a>
                  <?php else: ?>
                    <a href="<?= htmlspecialchars($u) ?>" title="View detailed information about <?= htmlspecialchars($it['name']) ?>" class="btn btn--primary">View Details</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Software Section -->
    <?php if (!empty($software)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Structured Data Tools & Software</h2>
      </div>
      <div class="content-block__body">
        <p>Open source utilities and developer tools for structured data implementation, semantic retrieval optimization, and AI-visibility solutions. All tools include comprehensive documentation and are available for download or direct use.</p>
        <div class="grid grid-auto-fit">
          <?php foreach ($software as $it):
            $u = '/catalog/' . $it['slug'] . '/';
            $description = $it['description'] ?? $it['short'] ?? '';
            $landingUrl = !empty($it['landing_url']) ? $it['landing_url'] : null;
            if ($landingUrl && preg_match('#^https?://[^/]+(/.+)$#', $landingUrl, $m)) {
              $landingUrl = $m[1];
            }
          ?>
            <div class="content-block">
              <div class="content-block__header">
                <h3 class="content-block__title"><?= htmlspecialchars($it['name']) ?></h3>
              </div>
              <div class="content-block__body">
                <p><?= htmlspecialchars($it['short']) ?></p>
                <?php if ($description && $description !== $it['short']): ?>
                  <p class="small muted"><?= htmlspecialchars(substr($description, 0, 200)) ?><?= strlen($description) > 200 ? '...' : '' ?></p>
                <?php endif; ?>
                
                <div class="btn-group" style="margin-top: 1rem;">
                  <?php if ($landingUrl): ?>
                    <a href="<?= htmlspecialchars($landingUrl) ?>" title="Access <?= htmlspecialchars($it['name']) ?> documentation for structured data tools and AI-visibility solutions" class="btn btn--primary">View <?= htmlspecialchars($it['name']) ?> Documentation</a>
                  <?php else: ?>
                    <a href="<?= htmlspecialchars($u) ?>" title="View detailed information about <?= htmlspecialchars($it['name']) ?>" class="btn btn--primary">View Details</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Products Section (if any) -->
    <?php if (!empty($products)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Products</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <?php foreach ($products as $it):
            $u = '/catalog/' . $it['slug'] . '/';
            $description = $it['description'] ?? $it['short'] ?? '';
            $landingUrl = !empty($it['landing_url']) ? $it['landing_url'] : null;
            if ($landingUrl && preg_match('#^https?://[^/]+(/.+)$#', $landingUrl, $m)) {
              $landingUrl = $m[1];
            }
          ?>
            <div class="content-block">
              <div class="content-block__header">
                <h3 class="content-block__title"><?= htmlspecialchars($it['name']) ?></h3>
              </div>
              <div class="content-block__body">
                <p><?= htmlspecialchars($it['short']) ?></p>
                <?php if ($description && $description !== $it['short']): ?>
                  <p class="small muted"><?= htmlspecialchars(substr($description, 0, 200)) ?><?= strlen($description) > 200 ? '...' : '' ?></p>
                <?php endif; ?>
                
                <div class="btn-group" style="margin-top: 1rem;">
                  <?php if ($landingUrl): ?>
                    <a href="<?= htmlspecialchars($landingUrl) ?>" title="View <?= htmlspecialchars($it['name']) ?> product information and features" class="btn btn--primary">View Product</a>
                  <?php else: ?>
                    <a href="<?= htmlspecialchars($u) ?>" title="View detailed information about <?= htmlspecialchars($it['name']) ?>" class="btn btn--primary">View Details</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Related Topics -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Topics</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><a href="<?= absolute_url('/insights/') ?>">Explore AI SEO research and insights</a> - Research on semantic retrieval, AI engine comprehension, and citation readiness</li>
          <li><a href="<?= absolute_url('/insights/semantic-queries/') ?>">Semantic Queries and Path Traversal</a> - How relationship traversal works in semantic systems</li>
          <li><a href="<?= absolute_url('/insights/data-virtualization/') ?>">Data Virtualization for AI Systems</a> - Unified access to distributed data sources for AI visibility</li>
          <li><a href="<?= absolute_url('/insights/performance-caching/') ?>">Performance Caching for Semantic Systems</a> - Caching layers and thresholds for AI-driven architectures</li>
        </ul>
      </div>
    </div>

    <!-- Contact CTA -->
    <div class="content-block module">
      <div class="content-block__body">
        <p class="lead">Need help choosing the right AI SEO service or structured data tool?</p>
        <div class="btn-group">
          <a href="sms:+12135628438?body=Interested in catalog items" class="btn btn--primary" title="Contact us via SMS about catalog items and services" aria-label="Contact us via SMS">Contact Us</a>
          <a href="<?= absolute_url('/services/') ?>" class="btn" title="View all available AI SEO services and solutions" aria-label="View all services">View All AI SEO Services</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
