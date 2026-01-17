<?php

/**
 * SUDO HREFLANG ALLOWLIST — GLOBAL PAGE PILOT + SAFE SCALE
 * 
 * SINGLE SOURCE OF TRUTH for hreflang eligibility.
 * 
 * Rules:
 * - Key = canonical path (no locale prefix, e.g., /services/technical-seo/)
 * - Value = array of allowed locales with REAL translations
 * - ONLY pages listed here may output hreflang
 * - LOCAL pages are NEVER listed here (enforced by code)
 * 
 * To enable hreflang for a GLOBAL page:
 * 1. Verify page exists in >= 2 locales
 * 2. Verify each locale is fully translated by humans
 * 3. Verify each locale is regionally adapted
 * 4. Add entry to this allowlist
 * 5. Test canonical stability for 2-4 weeks
 */

return [

  // PILOT — start with ONE global service page
  '/services/technical-seo/' => [
    'en-us',
    'en-gb',
    // add non-English locales ONLY when translations are real
    // 'de-de',
    // 'es-es',
  ],

  // Products index page - enable hreflang for translated products
  '/products/' => [
    'en-us',
    'en-gb',
    // Add more locales as products are translated
    // 'de-de',
    // 'es-es',
  ],

  // Learn Hub - beginner education pages
  '/learn/' => [
    'en-us',
    'en-gb',
    // Add more locales as learn pages are translated
  ],

  // Individual learn pages - inherit hreflang from /learn/ if needed
  // Learn pages matching /learn/{slug}/ pattern can inherit from /learn/

  // Future examples (DO NOT ENABLE YET)
  // '/services/schema-markup/' => ['en-us', 'en-gb'],
  // '/services/ai-search-optimization/' => ['en-us', 'en-gb'],
  // '/insights/open-seo-tools/' => ['en-us', 'en-gb'],

];

