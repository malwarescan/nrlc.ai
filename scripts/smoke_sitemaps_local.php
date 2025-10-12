<?php
$dir = __DIR__ . '/../public/sitemaps';
$files = glob($dir.'/*.xml.gz');
if(!$files){ echo "ERR: no .xml.gz files\n"; exit(2); }
$ok = true;
foreach ($files as $f) {
  $gz = gzopen($f, 'rb'); if(!$gz){ echo "ERR: cannot open $f\n"; $ok = false; continue; }
  $chunk = gzread($gz, 200); gzclose($gz);
  if (strpos($chunk, '<sitemapindex')===false && strpos($chunk,'<urlset')===false) {
    echo "ERR: $f not valid XML start\n"; $ok = false;
  } else {
    echo "OK: $f gzip+xml\n";
  }
}
exit($ok?0:1);
