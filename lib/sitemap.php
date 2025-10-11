<?php
declare(strict_types=1);

require_once __DIR__.'/../config/locales.php';
require_once __DIR__.'/helpers.php';

/**
 * Entry with hreflang alternates for standard URL sitemaps.
 * $pathWithoutLocalePrefix: "/services/llm-seeding/new-york/"
 * $primaryLocaleCode: e.g., 'en-us' (we use X_DEFAULT to anchor <loc>)
 */
function sitemap_entry_with_hreflang(string $pathWithoutLocalePrefix, string $primaryLocaleCode, ?string $lastmod = null): array {
  $primary = absolute_url('/'.$primaryLocaleCode.$pathWithoutLocalePrefix);
  $alts = [];
  foreach (LOCALES as $code => $meta) {
    $hreflang = strtolower($meta['lang'].'-'.$meta['region']);
    $alts[] = ['hreflang' => $hreflang, 'href' => absolute_url('/'.$code.$pathWithoutLocalePrefix)];
  }
  $alts[] = ['hreflang' => 'x-default', 'href' => absolute_url('/'.X_DEFAULT.$pathWithoutLocalePrefix)];
  return ['loc' => $primary, 'alts' => $alts, 'lastmod' => $lastmod];
}

/** Render URLSET with hreflang alternates (standard sitemaps). */
function sitemap_render_urlset(array $urls, array $extNS = []): string {
  $ns = [
    'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
    'xmlns:xhtml' => 'http://www.w3.org/1999/xhtml',
  ];
  foreach ($extNS as $k => $v) $ns['xmlns:'.$k] = $v;

  $attrs = [];
  foreach ($ns as $k=>$v) $attrs[] = $k.'="'.$v.'"';

  $out = [];
  $out[] = '<?xml version="1.0" encoding="UTF-8"?>';
  $out[] = '<urlset '.implode(' ', $attrs).'>';

  foreach ($urls as $u) {
    $out[] = '  <url>';
    $out[] = '    <loc>'.xml($u['loc']).'</loc>';
    if (!empty($u['lastmod'])) $out[] = '    <lastmod>'.$u['lastmod'].'</lastmod>';
    if (!empty($u['alts'])) {
      foreach ($u['alts'] as $a) {
        $out[] = '    <xhtml:link rel="alternate" hreflang="'.xml($a['hreflang']).'" href="'.xml($a['href']).'"/>';
      }
    }
    $out[] = '  </url>';
  }

  $out[] = '</urlset>';
  return implode("\n", $out);
}

/** Image sitemap: per URL, one or more image:image blocks. */
function sitemap_render_images(array $items): string {
  $ns = [
    'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
    'xmlns:image' => 'http://www.google.com/schemas/sitemap-image/1.1'
  ];
  $attrs = [];
  foreach ($ns as $k=>$v) $attrs[] = $k.'="'.$v.'"';

  $out = [];
  $out[] = '<?xml version="1.0" encoding="UTF-8"?>';
  $out[] = '<urlset '.implode(' ', $attrs).'>';

  foreach ($items as $it) {
    $out[] = '  <url>';
    $out[] = '    <loc>'.xml($it['loc']).'</loc>';
    foreach ($it['images'] as $img) {
      $out[] = '    <image:image>';
      $out[] = '      <image:loc>'.xml($img['loc']).'</image:loc>';
      if (!empty($img['title']))   $out[] = '      <image:title>'.xml($img['title']).'</image:title>';
      if (!empty($img['caption'])) $out[] = '      <image:caption>'.xml($img['caption']).'</image:caption>';
      $out[] = '    </image:image>';
    }
    $out[] = '  </url>';
  }

  $out[] = '</urlset>';
  return implode("\n", $out);
}

/** Video sitemap: per URL, one or more video:video blocks. */
function sitemap_render_videos(array $items): string {
  $ns = [
    'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
    'xmlns:video' => 'http://www.google.com/schemas/sitemap-video/1.1'
  ];
  $attrs = [];
  foreach ($ns as $k=>$v) $attrs[] = $k.'="'.$v.'"';

  $out = [];
  $out[] = '<?xml version="1.0" encoding="UTF-8"?>';
  $out[] = '<urlset '.implode(' ', $attrs).'>';

  foreach ($items as $it) {
    $out[] = '  <url>';
    $out[] = '    <loc>'.xml($it['loc']).'</loc>';
    foreach ($it['videos'] as $v) {
      $out[] = '    <video:video>';
      $out[] = '      <video:thumbnail_loc>'.xml($v['thumbnail']).'</video:thumbnail_loc>';
      $out[] = '      <video:content_loc>'.xml($v['content']).'</video:content_loc>';
      $out[] = '      <video:title>'.xml($v['title']).'</video:title>';
      $out[] = '      <video:description>'.xml($v['description']).'</video:description>';
      if (!empty($v['duration']))        $out[] = '      <video:duration>'.intval($v['duration']).'</video:duration>';
      if (!empty($v['publication_date']))$out[] = '      <video:publication_date>'.$v['publication_date'].'</video:publication_date>';
      $out[] = '    </video:video>';
    }
    $out[] = '  </url>';
  }

  $out[] = '</urlset>';
  return implode("\n", $out);
}

/** News sitemap: only recent (<=48h), max 1000 per file (we shard before calling). */
function sitemap_render_news(array $newsItems, string $publicationName, string $publicationLanguage): string {
  $ns = [
    'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
    'xmlns:news' => 'http://www.google.com/schemas/sitemap-news/0.9'
  ];
  $attrs = [];
  foreach ($ns as $k=>$v) $attrs[] = $k.'="'.$v.'"';

  $out = [];
  $out[] = '<?xml version="1.0" encoding="UTF-8"?>';
  $out[] = '<urlset '.implode(' ', $attrs).'>';

  foreach ($newsItems as $n) {
    $out[] = '  <url>';
    $out[] = '    <loc>'.xml($n['loc']).'</loc>';
    $out[] = '    <news:news>';
    $out[] = '      <news:publication>';
    $out[] = '        <news:name>'.xml($publicationName).'</news:name>';
    $out[] = '        <news:language>'.xml($publicationLanguage).'</news:language>';
    $out[] = '      </news:publication>';
    $out[] = '      <news:publication_date>'.$n['publication_date'].'</news:publication_date>';
    $out[] = '      <news:title>'.xml($n['title']).'</news:title>';
    if (!empty($n['keywords'])) $out[] = '      <news:keywords>'.xml($n['keywords']).'</news:keywords>';
    $out[] = '    </news:news>';
    $out[] = '  </url>';
  }

  $out[] = '</urlset>';
  return implode("\n", $out);
}

/** Render a sitemapindex. */
function sitemap_render_index(array $sitemaps): string {
  $out = [];
  $out[] = '<?xml version="1.0" encoding="UTF-8"?>';
  $out[] = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
  foreach ($sitemaps as $loc) {
    $out[] = '  <sitemap><loc>'.xml($loc).'</loc></sitemap>';
  }
  $out[] = '</sitemapindex>';
  return implode("\n", $out);
}

/** Write .xml and .xml.gz in /public/sitemaps and return [xmlUrl, gzUrl]. */
function sitemap_write_files(string $basename, string $xml): array {
  $dir = __DIR__.'/../public/sitemaps';
  if (!is_dir($dir)) @mkdir($dir, 0775, true);
  $xmlPath = $dir.'/'.$basename.'.xml';
  file_put_contents($xmlPath, $xml);
  $gzPath = $xmlPath.'.gz';
  $gz = gzopen($gzPath, 'w9'); gzwrite($gz, $xml); gzclose($gz);
  $base = absolute_url('/sitemaps/'.$basename.'.xml');
  return [$base, $base.'.gz'];
}

/** Simple XML escaper. */
function xml(string $s): string {
  return htmlspecialchars($s, ENT_XML1|ENT_COMPAT, 'UTF-8');
}
