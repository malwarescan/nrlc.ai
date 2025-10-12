<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/csv.php';

$services = csv_read_data('services.csv'); // expected header: slug
$cities   = csv_read_data('cities.csv');   // expected header: city_name

if (!$services || !$cities) {
  fwrite(STDERR, "ERR: Missing or unreadable data/services.csv or data/cities.csv\n");
  exit(2);
}

$today = gmdate('Y-m-d');
$outPath = __DIR__ . '/../data/matrix.csv';
$fh = fopen($outPath, 'w');
fputcsv($fh, ['service','city','lastmod']);
$rows = 0;
foreach ($services as $s) {
  $svc = trim($s['slug'] ?? '');
  if ($svc === '') continue;
  foreach ($cities as $c) {
    $city = trim($c['city_name'] ?? '');
    if ($city === '') continue;
    fputcsv($fh, [$svc, $city, $today]);
    $rows++;
  }
}
fclose($fh);
echo "Wrote data/matrix.csv ($rows rows)\n";