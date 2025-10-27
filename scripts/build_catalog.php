<?php
declare(strict_types=1);

$brand   = 'NRLC.ai';
$domain  = 'https://nrlc.ai';
$contact = 'team@nrlc.ai';

$csvPath   = __DIR__ . '/../data/catalog.csv';
$pagesDir  = __DIR__ . '/../public/catalog';
$template  = __DIR__ . '/../templates/catalog_page_template.php';
$feedsDir  = __DIR__ . '/../feeds';
$merchant  = $feedsDir . '/merchant_products.json';
$aiNdjson  = __DIR__ . '/../public/sitemaps/sitemap-ai.ndjson';

if (!is_file($csvPath)) { fwrite(STDERR, "Missing CSV: $csvPath\n"); exit(1); }
if (!is_file($template)) { fwrite(STDERR, "Missing template: $template\n"); exit(1); }
@mkdir($pagesDir, 0775, true);
@mkdir($feedsDir, 0775, true);

// Read CSV
$fp = fopen($csvPath, 'r'); $hdr = fgetcsv($fp, escape: '\\'); $items = [];
while (($row = fgetcsv($fp, escape: '\\')) !== false) { $items[] = array_combine($hdr, $row); }
fclose($fp);

// Generate pages & collect feed + ndjson
$feed = ["entries"=>[]];
$ndjRows = [];

foreach ($items as $item) {
  $slug = trim($item['slug'] ?? '');
  if ($slug === '') continue;
  $dir = $pagesDir . '/' . $slug;
  @mkdir($dir, 0775, true);
  $url = $domain . '/catalog/' . $slug . '/';

  // Render page using template
  ob_start();
  // Set vars for template
  $GLOBALS['brand'] = $brand;
  $GLOBALS['domain'] = $domain;
  $GLOBALS['contact'] = $contact;
  $GLOBALS['item'] = $item;
  $GLOBALS['url'] = $url;
  
  // Capture output
  include $template;
  $html = ob_get_clean();
  
  file_put_contents($dir . '/index.php', $html);

  // NDJSON row (for RAG)
  $ndj = [
    "@context"=>"https://schema.org",
    "@type"=>$item['type']==='service' ? "Service" : ($item['type']==='software' ? "SoftwareApplication" : "Product"),
    "url"=>$url,
    "name"=>$item['name'],
    "inLanguage"=>"en",
    "dateModified"=>date('Y-m-d')
  ];
  $ndjRows[] = $ndj;

  // Merchant JSON entry (only for product/software with an Offer)
  if (in_array($item['type'], ['product','software'], true)) {
    $feed['entries'][] = [
      "offerId"      => $item['sku'] ?: $slug,
      "title"        => $item['name'],
      "description"  => $item['description'],
      "link"         => $url,
      "imageLink"    => $item['image_url'] ?: null,
      "availability" => $item['availability'] ?: "InStock",
      "price"        => [
        "value"    => $item['price'] ?: "0.00",
        "currency" => $item['currency'] ?: "USD"
      ],
      "brand"        => $item['brand'] ?: $brand,
      "googleProductCategory" => $item['category'] ?: "Software",
      "subscriptionCost" => !empty($item['subscription']) ? $item['subscription'] : null
    ];
  }
}

// Write Merchant JSON (preview/export only)
file_put_contents($merchant, json_encode($feed, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));

// Append NDJSON rows
@mkdir(dirname($aiNdjson), 0775, true);
$fo = fopen($aiNdjson, 'a');
foreach ($ndjRows as $o) fwrite($fo, json_encode($o, JSON_UNESCAPED_SLASHES) . "\n");
fclose($fo);

echo "Generated pages: " . count($items) . PHP_EOL;
echo "Merchant export : $merchant" . PHP_EOL;
echo "AI NDJSON rows  : " . count($ndjRows) . " appended to $aiNdjson" . PHP_EOL;
