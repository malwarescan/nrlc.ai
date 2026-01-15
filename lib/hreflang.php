<?php
require_once __DIR__.'/../config/locales.php';
require_once __DIR__.'/helpers.php';

/**
 * SUDO HREFLANG ALLOWLIST — GLOBAL PAGE PILOT + SAFE SCALE
 * 
 * HREFLANG POLICY (STRICT):
 * 
 * D1) HREFLANG IS FOR GLOBAL PAGES ONLY
 * - Hreflang is FORBIDDEN on LOCAL pages under all circumstances
 * 
 * D2) HREFLANG ALLOWLIST GATE (GLOBAL pages only)
 * A GLOBAL page can output hreflang ONLY if:
 * - Page is explicitly listed in hreflang_allowlist.php
 * - Page path matches allowlist key exactly
 * - All listed locales have real translations
 * - All listed locales are indexable and self-canonical
 * 
 * If page is not in allowlist, output ZERO hreflang tags.
 * 
 * @param string $pathWithoutLocalePrefix Path without locale prefix (e.g., /services/technical-seo/)
 * @return array Array of hreflang links (empty array for LOCAL pages or if not in allowlist)
 */
function hreflang_links(string $pathWithoutLocalePrefix): array {
  // D1: LOCAL pages NEVER use hreflang (hard enforcement)
  if (function_exists('is_local_page') && is_local_page($pathWithoutLocalePrefix)) {
    // LOCAL page: Return empty array (NO hreflang tags)
    return [];
  }
  
  // D2: Load allowlist (single source of truth)
  $allowlistFile = __DIR__.'/hreflang_allowlist.php';
  if (!file_exists($allowlistFile)) {
    // Allowlist file missing: return empty (fail-safe)
    return [];
  }
  
  $allowlist = require $allowlistFile;
  
  // Normalize path for matching (ensure trailing slash)
  $normalizedPath = rtrim($pathWithoutLocalePrefix, '/') . '/';
  if ($normalizedPath === '//') {
    $normalizedPath = '/';
  }
  
  // Check if page is in allowlist
  $allowedLocales = null;
  if (isset($allowlist[$normalizedPath])) {
    $allowedLocales = $allowlist[$normalizedPath];
  } else {
    // Check if this is a product page and products index is in allowlist
    // Individual product pages inherit hreflang from products index if enabled
    if (preg_match('#^/products/([^/]+)/$#', $normalizedPath, $productMatch)) {
      if (isset($allowlist['/products/'])) {
        // Product pages inherit locales from products index
        $allowedLocales = $allowlist['/products/'];
      }
    }
  }
  
  if ($allowedLocales === null) {
    // Page not in allowlist: return empty (no hreflang)
    return [];
  }
  
  // D3: Page is in allowlist (or inherits from parent) - generate hreflang for allowed locales only
  // $allowedLocales is already set above
  
  // Validate: must have at least 2 locales
  if (count($allowedLocales) < 2) {
    // Invalid allowlist entry: return empty (fail-safe)
    return [];
  }
  
  $out = [];
  foreach ($allowedLocales as $localeCode) {
    // Verify locale exists in LOCALES config
    if (!isset(LOCALES[$localeCode])) {
      continue; // Skip invalid locale
    }
    
    $meta = LOCALES[$localeCode];
    $out[] = [
      'rel' => 'alternate',
      'hreflang' => $meta['lang'].'-'.$meta['region'],
      'href' => absolute_url('/'.$localeCode.$pathWithoutLocalePrefix)
    ];
  }
  
  // Include x-default pointing to primary locale (first in allowlist, or en-us)
  $primaryLocale = !empty($allowedLocales) ? $allowedLocales[0] : X_DEFAULT;
  $out[] = [
    'rel' => 'alternate',
    'hreflang' => 'x-default',
    'href' => absolute_url('/'.$primaryLocale.$pathWithoutLocalePrefix)
  ];
  
  return $out;
}

