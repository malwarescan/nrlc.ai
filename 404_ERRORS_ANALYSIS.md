# 404 Errors Analysis - Google Search Console Data

**Date:** December 27, 2025  
**Issue:** Not found (404)  
**Affected Pages:** 16 (as of Dec 23, 2025)

## Executive Summary

Google Search Console shows 16 pages returning 404 errors:
- **Oct 12, 2025:** 0 → 2 pages
- **Oct 15, 2025:** 2 → 4 pages
- **Nov 23, 2025:** 4 → 12 pages
- **Dec 16, 2025:** 12 → 16 pages

## URL Breakdown

### By Category
- **Career pages without locale prefix:** 12 URLs (75.0%)
  - `/careers/sendai/`, `/careers/kurashiki/`, `/careers/northampton/`, etc.
- **www subdomain:** 1 URL (6.3%)
  - `https://www.nrlc.ai/`
- **Search pages:** 2 URLs (12.5%)
  - `/search/?q={query}`
  - `/search?q={search_term_string}`
- **Audit page:** 1 URL (6.3%)
  - `/audit/`

## Root Cause Analysis

### 1. Career Pages Without Locale Prefix (12 URLs) - PRIMARY ISSUE

**Problem:** URLs like `/careers/sendai/` are returning 404 instead of redirecting to `/en-us/careers/` or `/en-gb/careers/`.

**Current Logic:**
- `bootstrap/canonical.php` should redirect URLs without locale prefix to locale-prefixed versions
- `bootstrap/router.php` (line 321-327) tries to redirect `/careers/{city}/` to careers index, but uses `current_locale()` which may fail for URLs without locale prefix

**Fix Applied:**
- Updated router to use `get_canonical_locale_for_city()` to determine correct locale based on city
- UK cities → redirect to `/en-gb/careers/`
- Non-UK cities → redirect to `/en-us/careers/`

### 2. www.nrlc.ai (1 URL)

**Problem:** `https://www.nrlc.ai/` is returning 404.

**Current Logic:**
- `bootstrap/canonical.php` (line 59-64) redirects www to non-www
- `public/index.php` has early www redirect check

**Status:** This is likely a Railway edge configuration issue (www subdomain not configured). The code should handle it, but Railway may be returning 404 before the PHP code runs.

### 3. Search Pages (2 URLs)

**Problem:** `/search/?q={query}` and `/search?q={search_term_string}` are returning 404.

**Current Logic:**
- Router returns 404 for `/search` paths (line 75-79)

**Fix Applied:**
- Added `X-Robots-Tag: noindex, nofollow` header to prevent indexing of 404 search pages

### 4. Audit Page (1 URL)

**Problem:** `/audit/` is returning 404.

**Current Logic:**
- Router returns 404 for `/audit/` paths (line 82-86)

**Fix Applied:**
- Added `X-Robots-Tag: noindex, nofollow` header to prevent indexing of 404 audit page

## Fixes Implemented

### 1. Career Page Redirect Fix ✅
**File:** `bootstrap/router.php` (line 321-327)

**Before:**
```php
$careersIndex = current_locale() ? '/' . current_locale() . '/careers/' : '/en-us/careers/';
```

**After:**
```php
$citySlug = $m[1];
require_once __DIR__.'/../lib/helpers.php';
$canonicalLocale = function_exists('get_canonical_locale_for_city') 
  ? get_canonical_locale_for_city($citySlug) 
  : 'en-us';
$careersIndex = '/' . $canonicalLocale . '/careers/';
```

**Result:** Career pages without locale prefix now redirect to the correct locale-based careers index.

### 2. Search/Audit Pages - Added noindex ✅
**File:** `bootstrap/router.php` (line 75-86)

**Added:** `X-Robots-Tag: noindex, nofollow` header to prevent Google from indexing 404 pages.

## Expected Resolution

### Career Pages
- **Immediate:** Redirects should work correctly after deployment
- **GSC:** Request re-indexing of affected URLs, or wait for Google to re-crawl
- **Timeline:** 1-2 weeks for Google to re-crawl and update index

### www.nrlc.ai
- **Action Required:** Verify Railway domain configuration
- **Code:** Already handles www redirect, but Railway edge may be blocking it

### Search/Audit Pages
- **Immediate:** Noindex header prevents further indexing
- **GSC:** These should drop from coverage over time

## Files Modified

- `bootstrap/router.php` - Fixed career page redirect logic, added noindex to search/audit 404s

## Next Steps

1. ✅ **Deploy fixes** - Push changes to production
2. **Request re-indexing** - In Google Search Console, request re-indexing of:
   - Career pages (they should now redirect correctly)
3. **Monitor GSC** - Watch for reduction in 404 errors over next 1-2 weeks
4. **Verify Railway config** - Check if www subdomain is configured in Railway

