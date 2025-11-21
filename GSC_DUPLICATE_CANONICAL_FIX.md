# Google Search Console Duplicate Canonical Fix - Complete

**Date:** 2025-01-27  
**Status:** ✅ Complete

## Issue Summary

Google Search Console reported **32,599 pages** with the issue "Duplicate, Google chose different canonical than user" starting on October 26, 2025. This affected:
- Service pages without locale prefixes (e.g., `/services/json-ld-strategy/`)
- Career pages without locale prefixes
- Blog posts, resources, and other content pages without locale prefixes
- Index pages without locale prefixes

## Root Cause

URLs without locale prefixes (e.g., `/services/json-ld-strategy/`) were being served with canonical tags pointing to themselves, while Google was choosing the locale-prefixed version (e.g., `/en-us/services/json-ld-strategy/`) as the canonical. This created duplicate content issues.

**Example:**
- **URL accessed:** `https://nrlc.ai/services/json-ld-strategy/`
- **Canonical set:** `https://nrlc.ai/services/json-ld-strategy/`
- **Google's choice:** `https://nrlc.ai/en-us/services/json-ld-strategy/`

## Solution Implemented

### 1. Redirect URLs Without Locale Prefixes

**File:** `bootstrap/canonical.php`

Added logic to redirect all URLs without locale prefixes to the default locale (`en-us`) version:

```php
// Force locale prefix redirect (e.g., /services/... -> /en-us/services/...)
// This prevents duplicate canonical issues where Google chooses a different canonical
if (!preg_match('#^/([a-z]{2})-([a-z]{2})(/|$)#i', $uri)) {
  // Path doesn't have locale prefix - redirect to default locale
  // Preserve query string
  $queryString = count($query) ? '?'.http_build_query($query) : '';
  // Handle root path specially
  if ($uri === '/' || $uri === '') {
    $redirectUrl = $scheme.'://'.$host.'/'.X_DEFAULT.'/'.$queryString;
  } else {
    $redirectUrl = $scheme.'://'.$host.'/'.X_DEFAULT.$uri.$queryString;
  }
  header("Location: $redirectUrl", true, 301);
  exit;
}
```

**Redirects:**
- `/services/json-ld-strategy/` → `/en-us/services/json-ld-strategy/` (301)
- `/careers/new-york/seo-specialist/` → `/en-us/careers/new-york/seo-specialist/` (301)
- `/` → `/en-us/` (301)
- `/blog/blog-post-123/` → `/en-us/blog/blog-post-123/` (301)

**Excluded paths (no redirect):**
- `/api/*` - API endpoints
- `/robots.txt` - Robots file
- `/favicon.ico` - Favicon
- `/sitemap*` - Sitemap files

### 2. Ensure Canonical Always Includes Locale Prefix

**File:** `templates/head.php`

Added fallback logic to ensure canonical URLs always include locale prefix, even if somehow a page without locale prefix is rendered:

```php
// Ensure canonical always includes locale prefix
// If path doesn't have locale prefix, add default locale
if (!preg_match('#^/([a-z]{2})-([a-z]{2})(/|$)#i', $requestPath)) {
  // Path doesn't have locale prefix - add default locale
  require_once __DIR__.'/../config/locales.php';
  if ($requestPath === '/' || $requestPath === '') {
    $requestPath = '/'.X_DEFAULT.'/';
  } else {
    $requestPath = '/'.X_DEFAULT.$requestPath;
  }
}
```

## Files Modified

1. **`bootstrap/canonical.php`**
   - Added locale prefix redirect logic
   - Added static path exclusions
   - Added X_DEFAULT constant import

2. **`templates/head.php`**
   - Added fallback canonical URL logic to ensure locale prefix is always present

## Expected Results

1. **Duplicate Canonical Issues:** Should decrease from 32,599 to near zero as:
   - All URLs without locale prefixes redirect to locale-prefixed versions
   - Canonical URLs always match the actual URL (with locale prefix)
   - Google will no longer see duplicate versions

2. **Crawled But Not Indexed:** Should improve as:
   - Duplicate content issues are resolved
   - Canonical URLs are consistent
   - Google can properly index the correct version of each page

## Testing Recommendations

1. **Test Redirects:**
   - `https://nrlc.ai/services/json-ld-strategy/` → Should redirect to `https://nrlc.ai/en-us/services/json-ld-strategy/`
   - `https://nrlc.ai/careers/new-york/seo-specialist/` → Should redirect to `https://nrlc.ai/en-us/careers/new-york/seo-specialist/`
   - `https://nrlc.ai/` → Should redirect to `https://nrlc.ai/en-us/`
   - `https://nrlc.ai/blog/blog-post-123/` → Should redirect to `https://nrlc.ai/en-us/blog/blog-post-123/`

2. **Test Exclusions:**
   - `https://nrlc.ai/api/book/` → Should NOT redirect (API path)
   - `https://nrlc.ai/robots.txt` → Should NOT redirect (static file)
   - `https://nrlc.ai/favicon.ico` → Should NOT redirect (static file)
   - `https://nrlc.ai/sitemaps/sitemap-index.xml.gz` → Should NOT redirect (sitemap)

3. **Test Canonical URLs:**
   - Verify all canonical URLs include locale prefix
   - Verify canonical URLs match actual URLs

## Technical Details

### Redirect Behavior

- **Status Code:** 301 (Permanent Redirect)
- **Preserves:** Query strings (UTM parameters are stripped separately)
- **Default Locale:** `en-us` (defined in `config/locales.php` as `X_DEFAULT`)

### URL Patterns

**Before (causing duplicates):**
- `/services/json-ld-strategy/` → Canonical: `/services/json-ld-strategy/`
- `/en-us/services/json-ld-strategy/` → Canonical: `/en-us/services/json-ld-strategy/`
- Google sees these as duplicates and chooses `/en-us/...` version

**After (fixed):**
- `/services/json-ld-strategy/` → Redirects to `/en-us/services/json-ld-strategy/`
- `/en-us/services/json-ld-strategy/` → Canonical: `/en-us/services/json-ld-strategy/`
- Only one version exists, no duplicates

## Next Steps

1. **Deploy** changes to production
2. **Monitor** Google Search Console for improvements over the next 1-2 weeks
3. **Request re-indexing** for affected pages if needed
4. **Verify** redirects are working correctly using curl or browser dev tools
5. **Check** that duplicate canonical issues decrease in GSC

## Related Issues

This fix also addresses:
- **Crawled but not indexed** (1,045 pages) - Should improve as duplicate content issues are resolved
- **Alternate page with proper canonical tag** - Will be reduced as there are fewer duplicate versions

---

**Status:** ✅ All fixes implemented and ready for deployment

