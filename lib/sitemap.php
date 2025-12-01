<?php
declare(strict_types=1);

/**
 * Core sitemap generation library with hreflang support
 * Supports multiple sitemap types: standard, images, videos, news
 */

function sitemap_entry_with_hreflang(string $loc, array $langs): string {
  $x = "  <url>\n    <loc>{$loc}</loc>\n";
  foreach ($langs as $code => $alt) {
    $x .= "    <xhtml:link rel=\"alternate\" hreflang=\"{$code}\" href=\"{$alt}\"/>\n";
  }
  return $x . "  </url>\n";
}

function sitemap_entry_simple(string $loc, string $lastmod = '', string $changefreq = '', string $priority = ''): string {
  $entry = "  <url>\n    <loc>{$loc}</loc>\n";
  if ($lastmod) $entry .= "    <lastmod>{$lastmod}</lastmod>\n";
  if ($changefreq) $entry .= "    <changefreq>{$changefreq}</changefreq>\n";
  if ($priority) $entry .= "    <priority>{$priority}</priority>\n";
  return $entry . "  </url>\n";
}

function sitemap_render_urlset(array $entries): string {
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
         "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" " .
         "xmlns:xhtml=\"http://www.w3.org/1999/xhtml\">\n";
  foreach ($entries as $e) $xml .= $e;
  return $xml . "</urlset>\n";
}

function sitemap_render_images(array $entries): string {
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
         "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" " .
         "xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">\n";
  foreach ($entries as $e) $xml .= $e;
  return $xml . "</urlset>\n";
}

function sitemap_render_videos(array $entries): string {
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
         "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" " .
         "xmlns:video=\"http://www.google.com/schemas/sitemap-video/1.1\">\n";
  foreach ($entries as $e) $xml .= $e;
  return $xml . "</urlset>\n";
}

function sitemap_render_news(array $entries): string {
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
         "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" " .
         "xmlns:news=\"http://www.google.com/schemas/sitemap-news/0.9\">\n";
  foreach ($entries as $e) $xml .= $e;
  return $xml . "</urlset>\n";
}

function sitemap_render_news_with_images(array $entries): string {
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
         "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" " .
         "xmlns:news=\"http://www.google.com/schemas/sitemap-news/0.9\" " .
         "xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">\n";
  foreach ($entries as $e) $xml .= $e;
  return $xml . "</urlset>\n";
}

function sitemap_render_index(array $sitemaps): string {
  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
         "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
  foreach ($sitemaps as $s) {
    $xml .= "  <sitemap><loc>{$s['loc']}</loc><lastmod>{$s['lastmod']}</lastmod></sitemap>\n";
  }
  return $xml . "</sitemapindex>\n";
}

function sitemap_write_gzipped(string $filepath, string $content): bool {
  $gz = gzopen($filepath, 'w9');
  if (!$gz) return false;
  gzwrite($gz, $content);
  gzclose($gz);
  return true;
}

function sitemap_generate_hreflang_urls(string $path): array {
  $base = 'https://nrlc.ai';
  return [
    'en-us' => "{$base}/en-us{$path}",
    'en-gb' => "{$base}/en-gb{$path}",
    'es-es' => "{$base}/es-es{$path}",
    'fr-fr' => "{$base}/fr-fr{$path}",
    'de-de' => "{$base}/de-de{$path}",
    'ko-kr' => "{$base}/ko-kr{$path}",
    'x-default' => "{$base}/en-us{$path}"
  ];
}