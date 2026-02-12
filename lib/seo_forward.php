<?php
/**
 * SEO Forward — Canonical URL and link helpers
 *
 * Use these so every link and sitemap URL points at the canonical version.
 * Single source of truth for "default locale" and canonical path rules.
 */

if (!function_exists('seo_forward_default_locale')) {
  /**
   * Default locale for locale-specific content (insights, blog, tools, book, etc.)
   * Non-canonical locales get noindex; sitemaps and internal links should use this.
   */
  function seo_forward_default_locale(): string {
    return defined('X_DEFAULT') ? X_DEFAULT : 'en-us';
  }
}

if (!function_exists('seo_forward_canonical_path')) {
  /**
   * Return the canonical path for a given path (adds default locale where required).
   * Use for internal links to locale-specific sections so we always link to the indexable URL.
   *
   * @param string $path Path without leading locale, e.g. '/insights/geo16-introduction/'
   * @return string Path with default locale if section is locale-specific, e.g. '/en-us/insights/geo16-introduction/'
   */
  function seo_forward_canonical_path(string $path): string {
    $path = '/' . trim($path, '/');
    if ($path === '/') return $path;
    $locale = seo_forward_default_locale();
    // Sections that are canonical only in en-us (or locale-specific)
    $locale_sections = ['/insights/', '/blog/', '/tools/', '/case-studies/', '/book/', '/about/', '/learn/', '/catalog/', '/promptware/'];
    foreach ($locale_sections as $section) {
      if (strpos($path, $section) === 0) return '/' . $locale . $path;
    }
    // Services and careers: base hub stays without locale; city pages get locale from city (caller should use get_canonical_locale_for_city for those)
    return $path;
  }
}

if (!function_exists('seo_forward_canonical_url')) {
  /**
   * Full canonical URL for a path. Prefer absolute_url(seo_forward_canonical_path($path)) or absolute_url() with explicit locale.
   */
  function seo_forward_canonical_url(string $path): string {
    if (!function_exists('absolute_url')) return 'https://nrlc.ai' . seo_forward_canonical_path($path);
    return absolute_url(seo_forward_canonical_path($path));
  }
}
