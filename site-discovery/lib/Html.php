<?php declare(strict_types=1);

final class Html {
  public static function dom(string $html): \DOMDocument {
    $dom = new \DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NOWARNING|LIBXML_NOERROR);
    libxml_clear_errors();
    return $dom;
  }

  public static function query(\DOMDocument $dom, string $xpathQuery): \DOMNodeList {
    $xp = new \DOMXPath($dom);
    return $xp->query($xpathQuery) ?: new class extends \DOMNodeList { public function item($i){return null;} public function count(){return 0;} };
  }

  public static function contents(\DOMNodeList $nodes): array {
    $out = [];
    foreach ($nodes as $n) $out[] = trim($n->textContent ?? '');
    return array_values(array_filter($out, fn($v)=>$v!==''));
  }

  public static function attrs(\DOMNodeList $nodes, string $attr): array {
    $out = [];
    foreach ($nodes as $n) if ($n instanceof \DOMElement && $n->hasAttribute($attr)) $out[] = trim($n->getAttribute($attr));
    return $out;
  }
}

