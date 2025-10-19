<?php
declare(strict_types=1);

/**
 * JSON-LD Auto Emitter (Organization + WebPage + optional Article) + Canonical
 * Usage in your base layout <head>:
 *   <?php require_once __DIR__.'/includes/jsonld_bootstrap.php'; ?>
 */

if (!defined('JSONLD_EMITTED')) define('JSONLD_EMITTED', false);

function brand_cfg(): array {
  $path = __DIR__.'/../config/brand.json';
  $cfg = is_file($path) ? json_decode((string)file_get_contents($path), true) : [];
  $cfg += ['name'=>'Brand','domain'=>'example.com','logo'=>'https://example.com/logo.png','sameAs'=>[]];
  return $cfg;
}
function base_origin(?string $fallback=null): string {
  $cfg = brand_cfg();
  $env = getenv('BASE_ORIGIN') ?: $fallback;
  return rtrim($env ?: ('https://'.$cfg['domain']), '/');
}
function current_url(): string {
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $host   = $_SERVER['HTTP_HOST'] ?? (brand_cfg()['domain'] ?? 'example.com');
  $uri    = $_SERVER['REQUEST_URI'] ?? '/';
  return $scheme.'://'.$host.$uri;
}
function slug_headline(string $url): string {
  $path = parse_url($url, PHP_URL_PATH) ?? '/';
  $slug = trim(basename(rtrim($path,'/')), '/');
  if ($slug === '') return 'Untitled';
  $slug = str_replace(['-','_','%20'], ' ', $slug);
  $out = [];
  foreach (preg_split('/\s+/', $slug) as $w) $out[] = ctype_digit($w) ? $w : mb_convert_case($w, MB_CASE_TITLE, 'UTF-8');
  return trim(implode(' ', $out));
}
function is_article_path(string $url): bool {
  $path = parse_url($url, PHP_URL_PATH) ?? '';
  return (bool)preg_match('#/(blog|articles?|research|insights|news)/#i', $path);
}
function org_block(string $base): array {
  $cfg = brand_cfg();
  return [
    '@context'=>'https://schema.org',
    '@type'=>'Organization',
    '@id'=> $base.'/#organization',
    'name'=>$cfg['name'],
    'url'=>$base,
    'logo'=>['@type'=>'ImageObject','url'=>$cfg['logo']],
    'sameAs'=>$cfg['sameAs']
  ];
}
function webpage_block(string $url, string $name, string $base): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'WebPage',
    '@id'=> rtrim($url,'/').'/#webpage',
    'url'=> $url,
    'name'=> $name,
    'isPartOf'=>['@id'=> $base.'/#website']
  ];
}

function service_block(string $url, string $name, string $base): array {
  $cfg = brand_cfg();
  return [
    '@context'=>'https://schema.org',
    '@type'=>'Service',
    '@id'=> rtrim($url,'/').'/#service',
    'name'=> $name,
    'provider'=> [ '@type'=>'Organization', 'name'=>$cfg['name'], 'url'=>$base ],
    'areaServed'=> ['@type'=>'AdministrativeArea','name'=>'Global'],
    'serviceType'=> $name,
    'url'=> $url
  ];
}
function article_block(string $url, string $headline, ?string $desc, ?string $date, string $base): array {
  $cfg = brand_cfg();
  return [
    '@context'=>'https://schema.org',
    '@type'=>'Article',
    '@id'=> rtrim($url,'/').'/#article',
    'mainEntityOfPage'=>['@type'=>'WebPage','@id'=> rtrim($url,'/').'/'],
    'headline'=> $headline,
    'description'=> $desc ?: $headline,
    'author'=>['@type'=>'Organization','name'=>$cfg['name']],
    'publisher'=>['@type'=>'Organization','name'=>$cfg['name'],'logo'=>['@type'=>'ImageObject','url'=>$cfg['logo']]],
    'datePublished'=> $date ?: date('Y-m-d'),
    'dateModified'=> date('Y-m-d')
  ];
}
function breadcrumbs_block(string $url): ?array {
  $parts = array_values(array_filter(explode('/', trim(parse_url($url, PHP_URL_PATH) ?? '', '/'))));
  if (count($parts) < 2) return null;
  $scheme = parse_url($url, PHP_URL_SCHEME) ?: 'https';
  $host   = parse_url($url, PHP_URL_HOST) ?: (brand_cfg()['domain'] ?? 'example.com');
  $items=[]; $accum=''; $pos=1;
  foreach ($parts as $p) {
    $accum .= '/'.$p;
    $items[] = [
      '@type'=>'ListItem','position'=>$pos++,
      'name'=> mb_convert_case(str_replace(['-','_'],' ',$p), MB_CASE_TITLE, 'UTF-8'),
      'item'=> $scheme.'://'.$host.$accum.'/'
    ];
  }
  return ['@context'=>'https://schema.org','@type'=>'BreadcrumbList','@id'=>rtrim($url,'/').'/#breadcrumbs','itemListElement'=>$items];
}
function jsonld_for_request(array $opts=[]): void {
  if (defined('JSONLD_EMITTED') && JSONLD_EMITTED === true) return;
  $base   = base_origin($opts['base'] ?? null);
  $url    = $opts['url']   ?? current_url();
  $title  = $opts['title'] ?? ($GLOBALS['pageTitle'] ?? null);
  $desc   = $opts['desc']  ?? ($GLOBALS['pageDesc'] ?? null);
  $canon  = $opts['canonical'] ?? $url;
  $name   = $title ?: slug_headline($url);
  $blocks = [ org_block($base), webpage_block($url,$name,$base) ];
  if (preg_match('#^/services/#i', parse_url($url, PHP_URL_PATH) ?? '')) {
    $blocks[] = service_block($url,$name,$base);
  }
  if (is_article_path($url)) $blocks[] = article_block($url,$name,$desc,$opts['date'] ?? null,$base);
  if ($bc = breadcrumbs_block($url)) $blocks[] = $bc;
  if (!empty($opts['emitCanonical'])) {
    echo '<link rel="canonical" href="'.htmlspecialchars($canon, ENT_QUOTES|ENT_HTML5).'">'.PHP_EOL;
  }
  echo '<script type="application/ld+json">'.json_encode($blocks, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'.PHP_EOL;
  define('JSONLD_EMITTED', true);
}


