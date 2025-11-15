<?php
declare(strict_types=1);
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/hreflang.php';

$brand='NRLC.ai'; $domain='https://nrlc.ai'; $contact='team@nrlc.ai';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
  http_response_code(404);
  echo "Item not found";
  exit;
}

$csv = __DIR__ . '/../../data/catalog.csv';
$item = null;
if (is_file($csv)) {
  if (($fp=fopen($csv,'r'))!==false) {
    $hdr = fgetcsv($fp);
    while(($r=fgetcsv($fp))!==false){
      $row = array_combine($hdr,$r);
      if ($row['slug'] === $slug) {
        $item = $row;
        break;
      }
    }
    fclose($fp);
  }
}

if (!$item) {
  http_response_code(404);
  echo "Item not found";
  exit;
}

$url = $domain . '/catalog/' . $slug . '/';
$title = $item['name'] . ' — ' . $brand;
$desc = $item['short'] ?: $item['description'];

$GLOBALS['__page_slug'] = 'catalog/item';
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $desc;
?>
<main class="container">
  <nav aria-label="breadcrumb"><a href="/">Home</a> › <a href="/catalog/">Catalog</a> › <?= htmlspecialchars($item['name']) ?></nav>
  <header>
    <h1><?= htmlspecialchars($item['name']) ?></h1>
    <?php if (!empty($item['short'])): ?><p><?= htmlspecialchars($item['short']) ?></p><?php endif; ?>
  </header>
  <?php if (!empty($item['image_url'])): ?>
  <figure><img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="max-width: 100%; height: auto;"></figure>
  <?php endif; ?>
  <section aria-labelledby="details">
    <h2 id="details">Details</h2>
    <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
    <ul>
      <?php if (!empty($item['price'])): ?>
      <li>Price: <?= htmlspecialchars($item['currency']) ?> <?= htmlspecialchars($item['price']) ?></li>
      <?php endif; ?>
      <?php if (!empty($item['subscription'])): ?>
      <li>Subscription: <?= htmlspecialchars($item['subscription']) ?></li>
      <?php endif; ?>
      <?php if (!empty($item['delivery'])): ?>
      <li>Delivery: <?= htmlspecialchars($item['delivery']) ?></li>
      <?php endif; ?>
      <?php if (!empty($item['os'])): ?>
      <li>OS: <?= htmlspecialchars($item['os']) ?></li>
      <?php endif; ?>
      <?php if (!empty($item['appCategory'])): ?>
      <li>Application Category: <?= htmlspecialchars($item['appCategory']) ?></li>
      <?php endif; ?>
      <?php if (!empty($item['sku'])): ?>
      <li>SKU: <?= htmlspecialchars($item['sku']) ?></li>
      <?php endif; ?>
      <?php if (!empty($item['availability'])): ?>
      <li>Availability: <?= htmlspecialchars($item['availability']) ?></li>
      <?php endif; ?>
    </ul>
  </section>
</main>
<?php
// -------- JSON-LD EMISSION --------
$graph = [];
$webPageId = $url . '#webpage';
$breadcrumbId = $url . '#breadcrumb';
$graph[] = [
  "@type"=>"WebPage",
  "@id"=>$webPageId,
  "url"=>$url,
  "name"=>$title,
  "description"=>$desc,
  "inLanguage"=>"en",
  "isPartOf"=>["@id"=>$domain . "/#website"],
  "breadcrumb"=>["@id"=>$breadcrumbId]
];

if ($item['type'] === 'service') {
  $graph[] = [
    "@type"=>"Service",
    "@id"=>$url . "#service",
    "name"=>$item['name'],
    "provider"=>["@type"=>"Organization","name"=>$brand],
    "areaServed"=>"Worldwide",
    "serviceType"=>$item['category'] ?: "ProfessionalService",
    "description"=>$item['description'],
    "offers"=>[
      "@type"=>"Offer",
      "price"=>$item['price'] ?: "0.00",
      "priceCurrency"=>$item['currency'] ?: "USD",
      "availability"=>"https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url"=>$url
    ]
  ];
} elseif ($item['type'] === 'software') {
  $graph[] = [
    "@type"=>"SoftwareApplication",
    "@id"=>$url . "#app",
    "name"=>$item['name'],
    "applicationCategory"=>$item['appCategory'] ?: "DeveloperApplication",
    "operatingSystem"=>$item['os'] ?: "Windows, macOS, Linux",
    "softwareVersion"=>"1.0.0",
    "url"=>$url,
    "description"=>$item['description'],
    "offers"=>[
      "@type"=>"Offer",
      "price"=>$item['price'] ?: "0.00",
      "priceCurrency"=>$item['currency'] ?: "USD",
      "availability"=>"https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url"=>$url
    ]
  ];
} else {
  // product
  $graph[] = [
    "@type"=>"Product",
    "@id"=>$url . "#product",
    "name"=>$item['name'],
    "sku"=>$item['sku'] ?: null,
    "brand"=>["@type"=>"Brand","name"=>$item['brand'] ?: $brand],
    "description"=>$item['description'],
    "image"=>$item['image_url'] ?: null,
    "offers"=>[
      "@type"=>"Offer",
      "price"=>$item['price'] ?: "0.00",
      "priceCurrency"=>$item['currency'] ?: "USD",
      "availability"=>"https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url"=>$url
    ]
  ];
}

$graph[] = [
  "@type"=>"BreadcrumbList",
  "@id"=>$breadcrumbId,
  "itemListElement"=>[
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>$domain . "/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Catalog","item"=>$domain . "/catalog/"],
    ["@type"=>"ListItem","position"=>3,"name"=>$item['name'],"item"=>$url]
  ]
];

$graph[] = [
  "@type"=>"WebSite",
  "@id"=>$domain . "/#website",
  "url"=>$domain . "/",
  "name"=>$brand
];
?>
<script type="application/ld+json"><?= json_encode(["@context"=>"https://schema.org","@graph"=>$graph], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
