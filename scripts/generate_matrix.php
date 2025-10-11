<?php
declare(strict_types=1);

// Reads data/services.csv + data/cities.csv and emits data/matrix.csv
// Columns: service,city,lastmod (YYYY-MM-DD)

function csv_rows(string $path): array {
  if (!file_exists($path)) return [];
  $fh = fopen($path,'r');
  $hdr = fgetcsv($fh);
  $rows = [];
  while ($r = fgetcsv($fh)) $rows[] = array_combine($hdr, $r);
  fclose($fh);
  return $rows;
}

$root = dirname(__DIR__);
$services = csv_rows($root.'/data/services.csv'); // slug,name
$cities   = csv_rows($root.'/data/cities.csv');   // city,...

if (!$services || !$cities) {
  fwrite(STDERR, "Missing data/services.csv or data/cities.csv\n");
  exit(1);
}

$today = gmdate('Y-m-d');
$out = fopen($root.'/data/matrix.csv','w');
fputcsv($out, ['service','city','lastmod']);

foreach ($services as $s) {
  $svc = trim($s['slug']);
  if ($svc==='') continue;
  foreach ($cities as $c) {
    $city = trim($c['city']);
    if ($city==='') continue;
    fputcsv($out, [$svc, $city, $today]);
  }
}
fclose($out);
echo "Wrote data/matrix.csv (".(count($services)*count($cities))." rows)\n";

