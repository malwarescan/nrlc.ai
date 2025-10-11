<?php
declare(strict_types=1);

// Usage: php scripts/ping_sitemaps.php https://nrlc.ai/sitemaps/sitemap-index.xml.gz
$index = $argv[1] ?? null;
if (!$index) {
  fwrite(STDERR, "Usage: php scripts/ping_sitemaps.php <absolute-index-url>\n");
  exit(1);
}

$targets = [
  'google' => 'https://www.google.com/ping?sitemap=',
  'bing'   => 'https://www.bing.com/ping?sitemap='
];

foreach ($targets as $name => $base) {
  $url = $base . rawurlencode($index);
  $ctx = stream_context_create(['http'=>['method'=>'GET','timeout'=>10,'header'=>"User-Agent: NRLC-Sitemap-Ping\r\n"]]);
  $res = @file_get_contents($url, false, $ctx);
  $code = 0;
  if (isset($http_response_header[0]) && preg_match('#\s(\d{3})\s#',$http_response_header[0],$m)) $code = (int)$m[1];
  echo strtoupper($name).": $url -> HTTP $code\n";
}

