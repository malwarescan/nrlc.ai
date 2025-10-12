<?php
function absolute_url(string $path): string {
  $scheme = ($_SERVER['HTTPS'] ?? '') === 'on' ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
  if ($path === '') $path = '/';
  return $scheme.'://'.$host.$path;
}

function without_locale_prefix(string $path): string {
  return preg_replace('#^/[a-z]{2}-[a-z]{2}#i','',$path);
}

function current_breadcrumbs(): array {
  return [
    ['name'=>'Home','url'=>absolute_url('/')],
  ];
}

function inject_jsonld(array $schemas): void {
  $GLOBALS['__jsonld'] = array_merge($GLOBALS['__jsonld'] ?? [], $schemas);
}

function csv_to_map(string $file, string $key): array {
  $path = __DIR__.'/../data/'.$file;
  if (!file_exists($path)) return [];
  $fh = fopen($path,'r');
  $hdr = fgetcsv($fh);
  $map = [];
  while ($row = fgetcsv($fh)) {
    $assoc = array_combine($hdr, $row);
    $map[$assoc[$key]] = $assoc;
  }
  fclose($fh);
  return $map;
}

function csv_to_rows(string $file): array {
  $path = __DIR__.'/../data/'.$file;
  if (!file_exists($path)) return [];
  $fh = fopen($path,'r');
  $hdr = fgetcsv($fh);
  $rows = [];
  while ($row = fgetcsv($fh)) {
    if (count($row) === count($hdr) && !empty(array_filter($row))) {
      $rows[] = array_combine($hdr, $row);
    }
  }
  fclose($fh);
  return $rows;
}

function asset_url(string $path): string {
  $abs = __DIR__ . '/../public' . $path;
  $ver = file_exists($abs) ? substr(md5((string)@filemtime($abs)),0,8) : '0';
  return $path . '?v=' . $ver;
}

if (!function_exists('absolute_url')) {
  function absolute_url(string $path): string {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
    return rtrim("$scheme://$host", '/') . '/' . ltrim($path, '/');
  }
}

function meta_for_slug(string $slug): array {
  switch ($slug) {
    case 'home/home':
      return ['NRLC.ai — LLM-First SEO & Structured Data','Crawl clarity, JSON-LD, LLM seeding & optimization across every major city.','/'];
    case 'services/service':
      $s = $_GET['service'] ?? '';
      return [ucwords(str_replace('-',' ',$s)).' — NRLC.ai',"$s services by NRLC.ai","/services/$s/"];
    case 'services/service_city':
      $s = $_GET['service'] ?? '';
      $c = $_GET['city'] ?? '';
      return [ucwords(str_replace('-',' ',$s))." in ".ucwords(str_replace('-',' ',$c)).' — NRLC.ai',"$s for $c by NRLC.ai","/services/$s/$c/"];
    case 'careers/career_city':
      $c = $_GET['city'] ?? '';
      $r = $_GET['role'] ?? '';
      return [ucwords(str_replace('-',' ',$r))." in ".ucwords(str_replace('-',' ',$c)).' — Careers at NRLC.ai',"Open role in $c","/careers/$c/$r/"];
    default:
      return ['NRLC.ai','LLM-First SEO','/'];
  }
}

