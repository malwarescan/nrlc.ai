<?php
declare(strict_types=1);

/**
 * Generates data/career_matrix.csv
 * Default: role × city (no service dimension)
 * Optional: --with-service to produce role × service × city
 *
 * Columns:
 *   role,service,city,lastmod
 *
 * Usage:
 *   php scripts/generate_career_matrix.php
 *   php scripts/generate_career_matrix.php --with-service
 */

function csv_rows(string $path): array {
  if (!file_exists($path)) return [];
  $fh = fopen($path,'r');
  $hdr = fgetcsv($fh);
  $rows = [];
  while ($r = fgetcsv($fh)) $rows[] = array_combine($hdr, $r);
  fclose($fh);
  return $rows;
}

$withService = in_array('--with-service', $argv, true);

$root     = dirname(__DIR__);
$roles    = csv_rows($root.'/data/careers.csv');   // slug,title
$cities   = csv_rows($root.'/data/cities.csv');    // city,country,...
$services = $withService ? csv_rows($root.'/data/services.csv') : [];

if (!$roles || !$cities) {
  fwrite(STDERR, "Missing data/careers.csv or data/cities.csv\n");
  exit(1);
}

$today = gmdate('Y-m-d');
$out   = fopen($root.'/data/career_matrix.csv','w');
fputcsv($out, ['role','service','city','lastmod']);

$count = 0;
foreach ($roles as $r) {
  $role = trim($r['slug'] ?? '');
  if ($role==='') continue;
  foreach ($cities as $c) {
    $city = trim($c['city'] ?? '');
    if ($city==='') continue;

    if ($withService && $services) {
      foreach ($services as $s) {
        $svc = trim($s['slug'] ?? '');
        if ($svc==='') continue;
        fputcsv($out, [$role, $svc, $city, $today]);
        $count++;
      }
    } else {
      // keep service column blank for simplicity
      fputcsv($out, [$role, '', $city, $today]);
      $count++;
    }
  }
}
fclose($out);

echo "Wrote data/career_matrix.csv ($count rows) with".($withService?'':'out')." service dimension.\n";

