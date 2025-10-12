<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/csv.php';

/** Default: role × city; --with-service: role × service × city */
$withService = in_array('--with-service', $argv, true);

$roles    = csv_read_data('careers.csv');   // header: slug
$cities   = csv_read_data('cities.csv');    // header: city_name
$services = $withService ? csv_read_data('services.csv') : [];

if (!$roles || !$cities) {
  fwrite(STDERR, "ERR: Missing or unreadable data/careers.csv or data/cities.csv\n");
  exit(2);
}

$today = gmdate('Y-m-d');
$outPath = __DIR__ . '/../data/career_matrix.csv';
$fh = fopen($outPath, 'w');
fputcsv($fh, ['role','service','city','lastmod']);

$count = 0;
foreach ($roles as $r) {
  $role = trim($r['slug'] ?? '');
  if ($role === '') continue;

  foreach ($cities as $c) {
    $city = trim($c['city_name'] ?? '');
    if ($city === '') continue;

    if ($withService && $services) {
      foreach ($services as $s) {
        $svc = trim($s['slug'] ?? '');
        if ($svc === '') continue;
        fputcsv($fh, [$role, $svc, $city, $today]);
        $count++;
      }
    } else {
      fputcsv($fh, [$role, '', $city, $today]);
      $count++;
    }
  }
}
fclose($fh);
echo "Wrote data/career_matrix.csv ($count rows) ".($withService?'with':'without')." service dimension\n";