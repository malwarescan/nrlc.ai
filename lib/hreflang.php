<?php
require_once __DIR__.'/../config/locales.php';
require_once __DIR__.'/helpers.php';

function hreflang_links(string $pathWithoutLocalePrefix): array {
  $out = [];
  foreach (LOCALES as $code => $meta) {
    $out[] = [
      'rel' => 'alternate',
      'hreflang' => $meta['lang'].'-'.$meta['region'],
      'href' => absolute_url('/'.$code.$pathWithoutLocalePrefix)
    ];
  }
  $out[] = ['rel'=>'alternate','hreflang'=>'x-default','href'=> absolute_url('/'.X_DEFAULT.$pathWithoutLocalePrefix)];
  return $out;
}

