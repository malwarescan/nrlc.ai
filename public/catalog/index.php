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
    while(($r=fgetcsv($fp, escape: '\\'))!==false){ $rows[] = array_combine($hdr,$r); }
    fclose($fp);
  }
}
$title='Catalog — Services & Software — '.$brand;
$desc='All NRLC.ai services and software.';

$GLOBALS['__page_slug'] = 'catalog/index';
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $desc;

include __DIR__.'/../../templates/head.php';
include __DIR__.'/../../templates/header.php';
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
        <p class="lead">All services & software from NRLC.ai.</p>
      </div>
    </div>

    <!-- Catalog Items Grid -->
    <?php if (!empty($rows)): ?>
    <div class="content-block module">
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <?php foreach ($rows as $it):
            $u = '/catalog/' . $it['slug'] . '/';
            $type = $it['type'] ?? 'service';
            $description = $it['description'] ?? $it['short'] ?? '';
          ?>
            <div class="content-block">
              <h3 class="content-block__title"><?= htmlspecialchars($it['name']) ?></h3>
              <p><?= htmlspecialchars($it['short']) ?></p>
              <?php if ($description && $description !== $it['short']): ?>
                <p class="small muted"><?= htmlspecialchars($description) ?></p>
              <?php endif; ?>
              <div class="btn-group">
                <a href="<?= htmlspecialchars($u) ?>" class="btn">View Details</a>
                <?php if (!empty($it['landing_url'])): ?>
                  <a href="<?= htmlspecialchars($it['landing_url']) ?>" class="btn btn--primary">Learn More</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

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



