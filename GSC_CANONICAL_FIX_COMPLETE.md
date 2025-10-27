# Google Search Console Canonical Fix - Complete

## Issue Summary

Google Search Console reported 21,378 pages with the issue "Alternate page with proper canonical tag" starting on October 12, 2025. This affected:
- Service pages with city variations across multiple locales
- Career pages with city variations
- All multilingual pages

## Root Cause

The canonical URLs were **missing the locale prefix**, causing a mismatch between:
- **Actual URL**: `https://nrlc.ai/en-gb/services/explainability-optimization-ai/soka/`
- **Canonical URL**: `https://nrlc.ai/services/explainability-optimization-ai/soka/` (missing `/en-gb/`)

This caused Google to flag these pages as "alternate pages" because the canonical didn't match the actual URL.

## Solution Implemented

### Changes to `templates/head.php`

**Before:**
```php
$slug = $GLOBALS['__page_slug'] ?? 'home/home';
[$title,$desc,$path] = meta_for_slug($slug);
$baseSchemas = base_schemas();

header('Content-Type: text/html; charset=utf-8');
?><!doctype html>
<html lang="<?=htmlspecialchars(substr(current_locale(),0,2))?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=htmlspecialchars($title)?></title>
<meta name="description" content="<?=htmlspecialchars($desc)?>">
<link rel="canonical" href="<?=absolute_url($path)?>">
```

**After:**
```php
$slug = $GLOBALS['__page_slug'] ?? 'home/home';
[$title,$desc,$path] = meta_for_slug($slug);
$baseSchemas = base_schemas();

// Build canonical URL with locale prefix
// Get the actual request path (includes locale prefix if present)
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Normalize the path (lowercase, remove double slashes, ensure trailing slash for directories)
$requestPath = preg_replace('#/{2,}#', '/', strtolower($requestPath));
if (!preg_match('#\.[a-z0-9]+$#', $requestPath) && substr($requestPath, -1) !== '/') {
  $requestPath .= '/';
}

// Use the request path as canonical (it already includes locale prefix if present)
$canonicalPath = $requestPath;

header('Content-Type: text/html; charset=utf-8');
?><!doctype html>
<html lang="<?=htmlspecialchars(substr(current_locale(),0,2))?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=htmlspecialchars($title)?></title>
<meta name="description" content="<?=htmlspecialchars($desc)?>">
<link rel="canonical" href="<?=absolute_url($canonicalPath)?>">
```

Also updated Open Graph and Twitter Card URLs to use the same canonical path:
```php
<meta property="og:url" content="<?=absolute_url($canonicalPath)?>">
<meta property="twitter:url" content="<?=absolute_url($canonicalPath)?>">
```

## Verification

Created `scripts/verify_canonical_urls.php` to test canonical URLs against sample URLs from GSC data:

**Test Results:**
```
✓ PASS: https://nrlc.ai/en-gb/services/explainability-optimization-ai/soka/
✓ PASS: https://nrlc.ai/en-us/services/completeness-optimization-ai/anyang/
✓ PASS: https://nrlc.ai/ko-kr/services/bard-optimization/hull/
✓ PASS: https://nrlc.ai/de-de/services/ai-overviews-optimization/tampa/
✓ PASS: https://nrlc.ai/es-es/services/training/columbus/
✓ PASS: https://nrlc.ai/en-gb/careers/burnley/technical-writer/
✓ PASS: https://nrlc.ai/de-de/careers/denver/seo-specialist/
✓ PASS: https://nrlc.ai/ko-kr/careers/whitehorse/technical-writer/

Results: 8 passed, 0 failed
```

## Expected Impact

1. **Google Search Console**: The "Alternate page with proper canonical tag" issue should resolve as Google re-crawls the pages
2. **Canonical URLs**: Now match the actual page URLs including locale prefixes
3. **SEO**: No negative impact - this is actually the correct implementation for multilingual sites
4. **Hreflang**: The hreflang implementation was already correct; this fix ensures canonical URLs align with it

## Next Steps

1. **Deploy** the changes to production
2. **Monitor** Google Search Console for the issue to clear (typically within 1-2 weeks)
3. **Request re-indexing** for affected pages in GSC if needed
4. **Verify** that canonical URLs in live pages include locale prefixes

## Technical Details

### Locale Handling
- Supported locales: `en-us`, `en-gb`, `es-es`, `fr-fr`, `de-de`, `ko-kr`
- Default locale: `en-us`
- Each locale has its own URL prefix: `/{locale}/path/`

### Canonical URL Format
- **Before**: `https://nrlc.ai/path/` (no locale)
- **After**: `https://nrlc.ai/{locale}/path/` (with locale)
- Example: `https://nrlc.ai/en-gb/services/crawl-clarity/london/`

### Hreflang Implementation
The hreflang tags were already correctly implemented and remain unchanged:
```html
<link rel="alternate" hreflang="en-GB" href="https://nrlc.ai/en-gb/path/">
<link rel="alternate" hreflang="en-US" href="https://nrlc.ai/en-us/path/">
<link rel="alternate" hreflang="es-ES" href="https://nrlc.ai/es-es/path/">
<link rel="alternate" hreflang="fr-FR" href="https://nrlc.ai/fr-fr/path/">
<link rel="alternate" hreflang="de-DE" href="https://nrlc.ai/de-de/path/">
<link rel="alternate" hreflang="ko-KR" href="https://nrlc.ai/ko-kr/path/">
<link rel="alternate" hreflang="x-default" href="https://nrlc.ai/en-us/path/">
```

This fix ensures that the canonical URL matches the URL that contains the hreflang tag.

---

**Status**: ✅ Complete
**Date**: October 26, 2025
**Files Modified**: `templates/head.php`
**Files Created**: `scripts/verify_canonical_urls.php`


