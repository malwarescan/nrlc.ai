<?php declare(strict_types=1);

final class Discover {
  private string $base;
  private int $max;
  private array $queue = [];
  private array $seen = [];
  private array $report = [];

  public function __construct(string $base, int $max=300) {
    $this->base = rtrim($base,'/');
    $this->max = max(20, $max);
    $this->enqueue($this->base.'/');
  }

  private function onDomain(string $url): bool {
    $pu = parse_url($url);
    $pb = parse_url($this->base);
    return $pu && $pb && strtolower($pu['scheme'] ?? '')===strtolower($pb['scheme'] ?? '') && strtolower($pu['host'] ?? '')===strtolower($pb['host'] ?? '');
  }

  private function normalize(string $url): string {
    // Parse and rebuild to handle normalization properly
    $parts = parse_url($url);
    if (!$parts || !isset($parts['scheme'], $parts['host'])) return $url;
    
    $normalized = $parts['scheme'] . '://' . $parts['host'];
    $path = $parts['path'] ?? '/';
    
    // Collapse multiple slashes in path
    $path = preg_replace('~//+~', '/', $path);
    
    // Add trailing slash if no file extension
    if (!preg_match('~\.[a-z0-9]{2,6}$~i', $path) && !str_ends_with($path, '/')) {
      $path .= '/';
    }
    
    $normalized .= $path;
    if (isset($parts['query'])) $normalized .= '?' . $parts['query'];
    
    return $normalized;
  }

  private function enqueue(string $url): void {
    $url = $this->normalize($url);
    if (!$this->onDomain($url)) return;
    if (isset($this->seen[$url])) return;
    $path = parse_url($url, PHP_URL_PATH) ?: '/';
    if (!Robots::allowed($this->base, $path)) return;
    $this->seen[$url] = true;
    $this->queue[] = $url;
  }

  public function crawl(): array {
    // Seed from sitemaps if present
    $sitemaps = Sitemap::discover($this->base);
    echo "Found ".count($sitemaps)." sitemap(s).\n";
    
    $toProcess = $sitemaps;
    $processed = [];
    
    // Recursively fetch child sitemaps
    while ($toProcess && count($this->queue) < $this->max) {
      $smUrl = array_shift($toProcess);
      if (isset($processed[$smUrl])) continue;
      $processed[$smUrl] = true;
      
      echo "Fetching sitemap: {$smUrl}\n";
      $res = Http::get($smUrl);
      if ($res['code']===200) {
        $urls = Sitemap::urlsFromIndex($res['body']);
        echo "  → Found ".count($urls)." URLs\n";
        foreach ($urls as $u) {
          // Check if this URL is another sitemap (ends with .xml or .xml.gz)
          if (preg_match('~\.xml(\.gz)?($|\?)~i', $u)) {
            $toProcess[] = $u;
          } else {
            $this->enqueue($u);
          }
        }
      }
    }

    echo "Queue has ".count($this->queue)." URLs to crawl.\n";
    while ($this->queue && count($this->report) < $this->max) {
      $url = array_shift($this->queue);
      if (count($this->report) % 10 === 0) echo "Progress: ".count($this->report)."/{$this->max}\n";
      $this->inspect($url);
    }
    return $this->report;
  }

  private function inspect(string $url): void {
    $res = Http::get($url);
    $row = [
      'url'=>$url,
      'status'=>$res['code'],
      'title'=>'',
      'meta_description'=>'',
      'canonical'=>'',
      'hreflang'=>[],
      'jsonld_types'=>[],
      'org_id'=>'',
      'org_name'=>'',
      'org_logo'=>'',
      'org_sameAs'=>[],
      'website_id'=>'',
      'publisher_name'=>'',
      'publisher_logo'=>'',
      'images'=>[],
      'links'=>[],
      'locale_guess'=>$this->guessLocale($url),
    ];
    if ($res['code']>=200 && $res['code']<400 && $res['body']) {
      $dom = Html::dom($res['body']);

      // title
      $t = Html::query($dom, '//title');
      $row['title'] = Html::contents($t)[0] ?? '';

      // meta description
      $md = Html::query($dom, '//meta[translate(@name, "ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="description"]');
      $row['meta_description'] = Html::attrs($md, 'content')[0] ?? '';

      // canonical
      $cn = Html::query($dom, '//link[translate(@rel,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="canonical"]');
      $row['canonical'] = Html::attrs($cn, 'href')[0] ?? '';

      // hreflang
      $hl = Html::query($dom, '//link[translate(@rel,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="alternate" and @hreflang]');
      foreach ($hl as $n) if ($n instanceof \DOMElement) $row['hreflang'][] = ['hreflang'=>strtolower($n->getAttribute('hreflang')), 'href'=>trim($n->getAttribute('href'))];

      // images
      $imgs = Html::query($dom, '//img[@src]');
      $row['images'] = array_slice(array_values(array_unique(Html::attrs($imgs,'src'))), 0, 20);

      // internal links (for small expansion)
      $as = Html::query($dom, '//a[@href]');
      $hrefs = Html::attrs($as,'href');
      foreach ($hrefs as $h) {
        $h = $this->absolve($url, $h);
        if ($this->onDomain($h)) $row['links'][] = $h;
      }
      // JSON-LD blocks
      $jsonScripts = Html::query($dom, '//script[@type="application/ld+json"]');
      foreach ($jsonScripts as $js) {
        $data = Json::tryDecode($js->textContent ?? '');
        $items = isset($data['@type']) ? [$data] : (is_array($data) ? $data : []);
        foreach ($items as $it) {
          if (!is_array($it)) continue;
          $type = is_string($it['@type'] ?? '') ? $it['@type'] : (is_array($it['@type'] ?? null) ? implode(',', $it['@type']) : '');
          if ($type) $row['jsonld_types'][] = $type;

          // Organization facts
          if (stripos($type,'Organization')!==false) {
            $row['org_id'] = $it['@id'] ?? ($it['url'] ?? '');
            $row['org_name'] = $it['name'] ?? $row['org_name'];
            $row['org_logo'] = is_string($it['logo'] ?? '') ? $it['logo'] : ($it['logo']['url'] ?? $row['org_logo']);
            if (!empty($it['sameAs']) && is_array($it['sameAs'])) $row['org_sameAs'] = array_values(array_filter($it['sameAs'], 'is_string'));
          }

          // WebSite facts
          if (stripos($type,'WebSite')!==false) {
            $row['website_id'] = $it['@id'] ?? ($it['url'] ?? '');
            if (isset($it['publisher']['name'])) $row['publisher_name'] = $it['publisher']['name'];
            if (isset($it['publisher']['logo']['url'])) $row['publisher_logo'] = $it['publisher']['logo']['url'];
          }
        }
      }

      // enqueue a few internal links
      foreach (array_slice(array_unique($row['links']), 0, 15) as $next) $this->enqueue($next);
    }
    $this->report[] = $row;
  }

  private function absolve(string $base, string $href): string {
    if (preg_match('~^https?://~i', $href)) return $href;
    if (str_starts_with($href,'//')) {
      $scheme = parse_url($base, PHP_URL_SCHEME) ?: 'https';
      return $scheme.':'.$href;
    }
    $b = parse_url($base);
    if (str_starts_with($href,'/')) return $b['scheme'].'://'.$b['host'].$href;
    $path = isset($b['path']) ? preg_replace('~/[^/]*$~','/',$b['path']) : '/';
    return $b['scheme'].'://'.$b['host'].$path.$href;
  }

  private function guessLocale(string $url): string {
    $path = parse_url($url, PHP_URL_PATH) ?: '/';
    if (preg_match('~^/([a-z]{2}(?:-[a-z0-9]{2})?)/~i', $path, $m)) return strtolower($m[1]);
    return '';
  }
}

