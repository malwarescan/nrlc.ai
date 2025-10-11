<?php
require_once __DIR__.'/../config/locales.php';

function i18n_set_locale(string $langRegion): void {
  $GLOBALS['locale'] = normalize_lang_region($langRegion);
}
function current_locale(): string {
  return $GLOBALS['locale'] ?? 'en-us';
}
function normalize_lang_region(string $lr): string {
  $lr = strtolower($lr);
  return LOCALES[$lr] ? $lr : 'en-us';
}

