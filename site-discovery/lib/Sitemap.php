<?php declare(strict_types=1);

final class Sitemap {
  public static function discover(string $base): array {
    $candidates = [
      rtrim($base,'/').'/sitemap.xml',
      rtrim($base,'/').'/sitemap_index.xml',
      rtrim($base,'/').'/sitemap-index.xml',
    ];
    // Look in robots.txt
    $robots = Http::get(rtrim($base,'/').'/robots.txt');
    if ($robots['code'] === 200) {
      foreach (preg_split("/\r\n|\n|\r/", $robots['body']) as $line) {
        if (stripos($line,'Sitemap:')===0) {
          $candidates[] = trim(substr($line,8));
        }
      }
    }
    // Deduplicate
    $candidates = array_values(array_unique($candidates));
    $found = [];
    foreach ($candidates as $url) {
      $res = Http::get($url);
      $ct = $res['headers']['content-type'] ?? '';
      // Accept XML or gzip (for .xml.gz sitemaps)
      if ($res['code'] === 200 && (stripos($ct, 'xml') !== false || stripos($ct, 'gzip') !== false)) {
        $found[] = $url;
      }
    }
    return $found;
  }

  public static function urlsFromIndex(string $xml): array {
    // Handle gzip-compressed XML
    if (substr($xml, 0, 2) === "\x1f\x8b") {
      $xml = gzdecode($xml) ?: $xml;
    }
    $out = [];
    $xr = new \XMLReader();
    if (!@$xr->XML($xml)) return [];
    while (@$xr->read()) {
      if ($xr->nodeType === \XMLReader::ELEMENT && in_array($xr->name, ['loc','url','sitemap','urlset','sitemapindex'], true)) {
        if ($xr->name === 'loc') $out[] = trim($xr->readInnerXML());
      }
    }
    return array_values(array_filter($out));
  }
}

