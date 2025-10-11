<?php
declare(strict_types=1);

// Validates all files under public/sitemaps.
// - Ensures XML well-formedness
// - For urlset: checks presence of base namespace
// - Simple size sanity checks (not empty, < 51MB uncompressed)

$root = dirname(__DIR__);
$dir = $root.'/public/sitemaps';
if (!is_dir($dir)) { fwrite(STDERR, "No sitemaps dir\n"); exit(1); }

$ok = true;
$files = glob($dir.'/*.xml');
$gz    = glob($dir.'/*.xml.gz');
$all   = array_merge($files, $gz);

foreach ($all as $f) {
  $content = null;
  if (str_ends_with($f, '.gz')) {
    $content = @gzdecode(file_get_contents($f));
  } else {
    $content = @file_get_contents($f);
  }
  if ($content === false || $content === '') {
    echo "EMPTY: $f\n"; $ok = false; continue;
  }
  if (strlen($content) > 51 * 1024 * 1024) {
    echo "WARN oversize (>51MB): $f\n";
  }

  $dom = new DOMDocument('1.0','UTF-8');
  $dom->preserveWhiteSpace = false;
  $dom->formatOutput = false;
  if (!@$dom->loadXML($content, LIBXML_NOBLANKS|LIBXML_NOERROR|LIBXML_NOWARNING)) {
    echo "BAD XML: $f\n"; $ok = false; continue;
  }

  $rootEl = $dom->documentElement->tagName;
  if ($rootEl === 'urlset') {
    $ns = $dom->documentElement->getAttribute('xmlns');
    if (strpos($ns, 'sitemaps.org') === false) {
      echo "WARN urlset missing base xmlns: $f\n";
    }
  } elseif ($rootEl === 'sitemapindex') {
    // fine
  } else {
    echo "WARN unknown root <$rootEl> in $f\n";
  }

  echo "OK: $f\n";
}

exit($ok ? 0 : 2);

