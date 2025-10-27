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
    $hdr = fgetcsv($fp);
    while(($r=fgetcsv($fp))!==false){ $rows[] = array_combine($hdr,$r); }
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
<main class="container">
  <header><h1>Catalog</h1><p>All services & software from NRLC.ai.</p></header>
  <ul>
    <?php foreach ($rows as $it):
      $u = '/catalog/' . $it['slug'] . '/';
    ?>
      <li><a href="<?= htmlspecialchars($u) ?>"><?= htmlspecialchars($it['name']) ?></a> — <?= htmlspecialchars($it['short']) ?></li>
    <?php endforeach; ?>
  </ul>
  <footer><p>© <span id="y"></span> <?= htmlspecialchars($brand) ?></p></footer>
</main>
<script>document.getElementById('y').textContent=new Date().getFullYear();</script>
<script type="application/ld+json">{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"Home","item":"<?= htmlspecialchars($domain) ?>/"},
    {"@type":"ListItem","position":2,"name":"Catalog","item":"<?= htmlspecialchars($domain) ?>/catalog/"}
  ]
}</script>
<?php include __DIR__.'/../../templates/footer.php'; ?>

