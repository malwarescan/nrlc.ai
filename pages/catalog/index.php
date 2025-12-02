<?php
declare(strict_types=1);
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/hreflang.php';

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

$title='Catalog — Services & Software | '.$brand;
$desc='Complete catalog of NRLC.ai services and software. Professional AI SEO services, structured data implementation, and open source tools for developers.';

$GLOBALS['__page_slug'] = 'catalog/index';
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $desc;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Catalog Header Content Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Catalog</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Complete catalog of professional services and software tools from NRLC.ai.</p>
        <p>Browse our comprehensive selection of AI SEO services, structured data implementation tools, and open source utilities designed for modern web development and search engine optimization.</p>
      </div>
    </div>

    <!-- Services Section -->
    <?php if (!empty($services)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Professional Services</h2>
      </div>
      <div class="content-block__body">
        <p>Expert AI SEO and structured data implementation services. Each service includes professional implementation, comprehensive documentation, and ongoing support.</p>
        <div class="grid grid-auto-fit">
          <?php foreach ($services as $it):
            $u = '/catalog/' . $it['slug'] . '/';
            $description = $it['description'] ?? $it['short'] ?? '';
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
                
                <!-- Link Tree -->
                <div class="link-tree" style="margin-top: 1rem; margin-bottom: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--color-border, #ddd); font-size: 0.8125rem; font-family: 'Courier New', monospace;">
                  <strong style="display: block; margin-bottom: 0.5rem; color: var(--color-text-primary, #1a1a1a); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.75rem;">Reference Links</strong>
                  <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.375rem;">
                    <li><a href="<?= htmlspecialchars($u) ?>" title="View detailed information about <?= htmlspecialchars($it['name']) ?> - <?= htmlspecialchars($it['short']) ?>" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Details</a></li>
                    <?php if (!empty($it['landing_url'])): ?>
                      <?php if ($it['type'] === 'service'): ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service page with implementation details, pricing, and availability" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Service Page</a></li>
                      <?php elseif ($it['type'] === 'software'): ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Access <?= htmlspecialchars($it['name']) ?> documentation, API reference, and technical specifications" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Documentation</a></li>
                      <?php else: ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> product information, features, and specifications" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Product Page</a></li>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($it['type'] === 'service'): ?>
                      <li><a href="/services/" title="Browse all AI SEO services including crawl clarity, structured data, and LLM optimization" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">All Services</a></li>
                      <?php if (strpos(strtolower($it['name']), 'crawl') !== false || strpos(strtolower($it['slug']), 'crawl') !== false): ?>
                        <li><a href="/insights/geo16-introduction/" title="Learn about the GEO-16 framework for AI citation optimization and generative engine optimization" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">GEO-16 Framework</a></li>
                      <?php elseif (strpos(strtolower($it['name']), 'json') !== false || strpos(strtolower($it['slug']), 'json') !== false): ?>
                        <li><a href="/insights/" title="Explore structured data insights, JSON-LD implementation guides, and schema optimization research" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Structured Data Insights</a></li>
                      <?php elseif (strpos(strtolower($it['name']), 'llm') !== false || strpos(strtolower($it['slug']), 'llm') !== false): ?>
                        <li><a href="/insights/geo16-introduction/" title="Research on LLM optimization, AI citation readiness, and generative engine optimization strategies" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">LLM Optimization Research</a></li>
                      <?php else: ?>
                        <li><a href="/insights/" title="Discover AI SEO research, insights, and best practices for optimizing content for AI-powered search engines" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">AI SEO Research</a></li>
                      <?php endif; ?>
                    <?php elseif ($it['type'] === 'software'): ?>
                      <li><a href="/tools/" title="Browse SEO tools, utilities, and resources for developers and SEO professionals" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Tools Directory</a></li>
                      <li><a href="/promptware/" title="Access open source promptware repository with AI prompts, templates, and utilities" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Promptware Repository</a></li>
                    <?php else: ?>
                      <li><a href="/products/" title="View all NRLC.ai products including software applications and AI SEO tools" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">All Products</a></li>
                    <?php endif; ?>
                    <li><a href="/catalog/" title="Browse complete catalog of NRLC.ai services, software, and products" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Catalog Index</a></li>
                  </ul>
                </div>
                
                <div class="btn-group">
                  <?php if (!empty($it['landing_url'])): ?>
                    <?php if ($it['type'] === 'service'): ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service - <?= htmlspecialchars($it['short']) ?>" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?> Service</a>
                    <?php elseif ($it['type'] === 'software'): ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> documentation and technical specifications" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?> Docs</a>
                    <?php else: ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> product details and features" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?></a>
                    <?php endif; ?>
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
        <h2 class="content-block__title">Software & Tools</h2>
      </div>
      <div class="content-block__body">
        <p>Open source utilities, developer tools, and software applications. All tools include comprehensive documentation and are available for download or direct use.</p>
        <div class="grid grid-auto-fit">
          <?php foreach ($software as $it):
            $u = '/catalog/' . $it['slug'] . '/';
            $description = $it['description'] ?? $it['short'] ?? '';
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
                
                <!-- Link Tree -->
                <div class="link-tree" style="margin-top: 1rem; margin-bottom: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--color-border, #ddd); font-size: 0.8125rem; font-family: 'Courier New', monospace;">
                  <strong style="display: block; margin-bottom: 0.5rem; color: var(--color-text-primary, #1a1a1a); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.75rem;">Reference Links</strong>
                  <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.375rem;">
                    <li><a href="<?= htmlspecialchars($u) ?>" title="View detailed information about <?= htmlspecialchars($it['name']) ?> - <?= htmlspecialchars($it['short']) ?>" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Details</a></li>
                    <?php if (!empty($it['landing_url'])): ?>
                      <?php if ($it['type'] === 'service'): ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service page with implementation details, pricing, and availability" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Service Page</a></li>
                      <?php elseif ($it['type'] === 'software'): ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Access <?= htmlspecialchars($it['name']) ?> documentation, API reference, and technical specifications" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Documentation</a></li>
                      <?php else: ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> product information, features, and specifications" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Product Page</a></li>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($it['type'] === 'service'): ?>
                      <li><a href="/services/" title="Browse all AI SEO services including crawl clarity, structured data, and LLM optimization" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">All Services</a></li>
                      <?php if (strpos(strtolower($it['name']), 'crawl') !== false || strpos(strtolower($it['slug']), 'crawl') !== false): ?>
                        <li><a href="/insights/geo16-introduction/" title="Learn about the GEO-16 framework for AI citation optimization and generative engine optimization" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">GEO-16 Framework</a></li>
                      <?php elseif (strpos(strtolower($it['name']), 'json') !== false || strpos(strtolower($it['slug']), 'json') !== false): ?>
                        <li><a href="/insights/" title="Explore structured data insights, JSON-LD implementation guides, and schema optimization research" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Structured Data Insights</a></li>
                      <?php elseif (strpos(strtolower($it['name']), 'llm') !== false || strpos(strtolower($it['slug']), 'llm') !== false): ?>
                        <li><a href="/insights/geo16-introduction/" title="Research on LLM optimization, AI citation readiness, and generative engine optimization strategies" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">LLM Optimization Research</a></li>
                      <?php else: ?>
                        <li><a href="/insights/" title="Discover AI SEO research, insights, and best practices for optimizing content for AI-powered search engines" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">AI SEO Research</a></li>
                      <?php endif; ?>
                    <?php elseif ($it['type'] === 'software'): ?>
                      <li><a href="/tools/" title="Browse SEO tools, utilities, and resources for developers and SEO professionals" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Tools Directory</a></li>
                      <li><a href="/promptware/" title="Access open source promptware repository with AI prompts, templates, and utilities" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Promptware Repository</a></li>
                    <?php else: ?>
                      <li><a href="/products/" title="View all NRLC.ai products including software applications and AI SEO tools" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">All Products</a></li>
                    <?php endif; ?>
                    <li><a href="/catalog/" title="Browse complete catalog of NRLC.ai services, software, and products" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Catalog Index</a></li>
                  </ul>
                </div>
                
                <div class="btn-group">
                  <?php if (!empty($it['landing_url'])): ?>
                    <?php if ($it['type'] === 'service'): ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service - <?= htmlspecialchars($it['short']) ?>" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?> Service</a>
                    <?php elseif ($it['type'] === 'software'): ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> documentation and technical specifications" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?> Docs</a>
                    <?php else: ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> product details and features" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?></a>
                    <?php endif; ?>
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
                
                <!-- Link Tree -->
                <div class="link-tree" style="margin-top: 1rem; margin-bottom: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--color-border, #ddd); font-size: 0.8125rem; font-family: 'Courier New', monospace;">
                  <strong style="display: block; margin-bottom: 0.5rem; color: var(--color-text-primary, #1a1a1a); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.75rem;">Reference Links</strong>
                  <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.375rem;">
                    <li><a href="<?= htmlspecialchars($u) ?>" title="View detailed information about <?= htmlspecialchars($it['name']) ?> - <?= htmlspecialchars($it['short']) ?>" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Details</a></li>
                    <?php if (!empty($it['landing_url'])): ?>
                      <?php if ($it['type'] === 'service'): ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service page with implementation details, pricing, and availability" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Service Page</a></li>
                      <?php elseif ($it['type'] === 'software'): ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Access <?= htmlspecialchars($it['name']) ?> documentation, API reference, and technical specifications" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;"><?= htmlspecialchars($it['name']) ?> Documentation</a></li>
                      <?php else: ?>
                        <li><a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> product information, features, and specifications" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Product Page</a></li>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($it['type'] === 'service'): ?>
                      <li><a href="/services/" title="Browse all AI SEO services including crawl clarity, structured data, and LLM optimization" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">All Services</a></li>
                      <?php if (strpos(strtolower($it['name']), 'crawl') !== false || strpos(strtolower($it['slug']), 'crawl') !== false): ?>
                        <li><a href="/insights/geo16-introduction/" title="Learn about the GEO-16 framework for AI citation optimization and generative engine optimization" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">GEO-16 Framework</a></li>
                      <?php elseif (strpos(strtolower($it['name']), 'json') !== false || strpos(strtolower($it['slug']), 'json') !== false): ?>
                        <li><a href="/insights/" title="Explore structured data insights, JSON-LD implementation guides, and schema optimization research" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Structured Data Insights</a></li>
                      <?php elseif (strpos(strtolower($it['name']), 'llm') !== false || strpos(strtolower($it['slug']), 'llm') !== false): ?>
                        <li><a href="/insights/geo16-introduction/" title="Research on LLM optimization, AI citation readiness, and generative engine optimization strategies" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">LLM Optimization Research</a></li>
                      <?php else: ?>
                        <li><a href="/insights/" title="Discover AI SEO research, insights, and best practices for optimizing content for AI-powered search engines" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">AI SEO Research</a></li>
                      <?php endif; ?>
                    <?php elseif ($it['type'] === 'software'): ?>
                      <li><a href="/tools/" title="Browse SEO tools, utilities, and resources for developers and SEO professionals" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Tools Directory</a></li>
                      <li><a href="/promptware/" title="Access open source promptware repository with AI prompts, templates, and utilities" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Promptware Repository</a></li>
                    <?php else: ?>
                      <li><a href="/products/" title="View all NRLC.ai products including software applications and AI SEO tools" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">All Products</a></li>
                    <?php endif; ?>
                    <li><a href="/catalog/" title="Browse complete catalog of NRLC.ai services, software, and products" style="color: var(--color-brand, #0066cc); text-decoration: none; border-bottom: 1px dotted currentColor;">Catalog Index</a></li>
                  </ul>
                </div>
                
                <div class="btn-group">
                  <?php if (!empty($it['landing_url'])): ?>
                    <?php if ($it['type'] === 'service'): ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="Explore <?= htmlspecialchars($it['name']) ?> service - <?= htmlspecialchars($it['short']) ?>" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?> Service</a>
                    <?php elseif ($it['type'] === 'software'): ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> documentation and technical specifications" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?> Docs</a>
                    <?php else: ?>
                      <a href="<?= htmlspecialchars($it['landing_url']) ?>" title="View <?= htmlspecialchars($it['name']) ?> product details and features" class="btn btn--primary"><?= htmlspecialchars($it['name']) ?></a>
                    <?php endif; ?>
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

    <!-- Contact CTA -->
    <div class="content-block module">
      <div class="content-block__body">
        <p class="lead">Need help choosing the right service or tool?</p>
        <div class="btn-group">
          <a href="sms:+12135628438?body=Interested in catalog items" class="btn btn--primary">Contact Us</a>
          <a href="/services/" class="btn">View All Services</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"Home","item":"<?= htmlspecialchars($domain) ?>/"},
    {"@type":"ListItem","position":2,"name":"Catalog","item":"<?= htmlspecialchars($domain) ?>/catalog/"}
  ]
}</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>

