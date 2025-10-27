<?php
declare(strict_types=1);
/**
 * Variables provided:
 * $brand, $domain, $contact
 * $item (assoc): slug,type,name,short,description,price,currency,sku,brand,os,appCategory,delivery,subscription,availability,image_url,category,license_url,landing_url
 * $url: canonical page URL for this item
 *
 * This template inherits templates/* if present, else falls back to minimal head.
 */

$hasHead   = is_file(__DIR__.'/../lib/helpers.php');
$hasHeader = is_file(__DIR__.'/header.php');
$hasFooter = is_file(__DIR__.'/footer.php');

$title = $item['name'] . ' — ' . $brand;
$desc  = $item['short'] ?: $item['description'];

// Set global vars for templates
$GLOBALS['__page_slug'] = 'catalog/' . $item['slug'];
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $desc;

if ($hasHead) {
  require_once __DIR__.'/../lib/helpers.php';
  require_once __DIR__.'/../lib/schema_builders.php';
  require_once __DIR__.'/../lib/hreflang.php';
  include __DIR__.'/head.php';
} else {
  ?><!doctype html><html lang="en"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($desc) ?>">
  <link rel="canonical" href="<?= htmlspecialchars($url) ?>">
  </head><body><?php
}
if ($hasHeader) include __DIR__.'/header.php';
?>

<main class="container">
  <nav aria-label="breadcrumb"><a href="/">Home</a> › <a href="/catalog/">Catalog</a> › <?= htmlspecialchars($item['name']) ?></nav>
  <header>
    <h1><?= htmlspecialchars($item['name']) ?></h1>
    <?php if (!empty($item['short'])): ?><p><?= htmlspecialchars($item['short']) ?></p><?php endif; ?>
  </header>

  <?php if (!empty($item['image_url'])): ?>
    <figure><img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></figure>
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

  <footer><p>© <span id="y"></span> <?= htmlspecialchars($brand) ?> • Contact: <?= htmlspecialchars($contact) ?></p></footer>
</main>
<script>document.getElementById('y').textContent=new Date().getFullYear();</script>

<?php
// -------- JSON-LD EMISSION (WebPage + {Service|SoftwareApplication|Product} + BreadcrumbList) --------
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
}
elseif ($item['type'] === 'software') {
  $schema = [
    "@type"=>"SoftwareApplication",
    "@id"=>$url . "#app",
    "name"=>$item['name'],
    "applicationCategory"=>$item['appCategory'] ?: "DeveloperApplication",
    "operatingSystem"=>$item['os'] ?: "Windows, macOS, Linux",
    "softwareVersion"=>"1.0.0",
    "url"=>$url,
    "description"=>$item['description'],
    "publisher"=>[
      "@type"=>"Organization",
      "name"=>$brand,
      "url"=>$domain
    ],
    "offers"=>[
      "@type"=>"Offer",
      "price"=>$item['price'] ?: "0.00",
      "priceCurrency"=>$item['currency'] ?: "USD",
      "availability"=>"https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url"=>$url
    ]
  ];
  
  // Add screenshot/image if available
  if (!empty($item['image_url'])) {
    $schema['screenshot'] = $item['image_url'];
  }
  
  // Add download URL for free/open source software
  if (strpos(strtolower($item['description']), 'open source') !== false || (empty($item['price']) || $item['price'] == '0.00')) {
    $schema['downloadUrl'] = $url;
  }
  
  $graph[] = $schema;
}
else { // product
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

<?php
if ($hasFooter) include __DIR__.'/footer.php';
if (!$hasHead): ?></body></html><?php endif; ?>

