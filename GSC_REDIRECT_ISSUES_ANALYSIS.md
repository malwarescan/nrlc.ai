# Google Search Console Redirect Issues Analysis & Fixes

**Date:** 2026-01-09  
**Issue:** Page with redirect - 16,151 affected pages  
**Status:** 🔧 FIXING

## Executive Summary

Google Search Console reports 16,151 pages with redirects. The issue has grown from 58 pages on 2025-10-11 to 16,151 pages on 2026-01-03. Analysis shows three main categories of redirects:

1. **HTTP to HTTPS redirects** (91 URLs in sample)
2. **Missing locale prefixes** (many URLs)
3. **Non-canonical locale versions** (especially for city-based pages)

---

## Data Analysis

### Timeline (from Chart.csv)
- **2025-10-11:** 58 pages
- **2025-11-23:** 9,423 pages (massive jump)
- **2025-12-16:** 15,329 pages (another jump)
- **2025-12-24:** 16,151 pages (peak)
- **2026-01-03:** 16,151 pages (stabilized)

### URL Pattern Analysis (from Table.csv sample)

**Total URLs in sample:** 1,001  
**HTTP URLs:** 91 (should all be HTTPS)  
**URLs without locale prefix:** ~200+  
**Non-canonical locale versions:** ~700+

#### Issue Categories

##### 1. HTTP → HTTPS Redirects (91 URLs)
Examples:
- `http://nrlc.ai/en-gb/services/technical-seo/utsunomiya/` → should be HTTPS
- `http://nrlc.ai/services/semantic-seo-ai/leeds/` → should be HTTPS with locale
- `http://nrlc.ai/` → should be HTTPS with locale

**Root Cause:** External links or old bookmarks using HTTP, or internal links generated with HTTP scheme.

##### 2. Missing Locale Prefixes (~200 URLs)
Examples:
- `/services/training/takamatsu/` → should be `/en-us/services/training/takamatsu/`
- `/services/topic-modeling-ai/` → should be `/en-us/services/topic-modeling-ai/`
- `/careers/kansas-city/` → should be `/en-us/careers/kansas-city/`
- `/ai-search-risk/` → should be `/en-us/ai-search-risk/`
- `/products/newfaq/` → should redirect to homepage

**Root Cause:** Internal links in `lib/nrlc_linking_kernel.php` generating URLs without locale prefixes.

##### 3. Non-Canonical Locale Versions (~700 URLs)

**City-based service pages in wrong locales:**
- `/de-de/services/b2b-seo-ai/glasgow/` → should be `/en-gb/services/b2b-seo-ai/glasgow/` (Glasgow is UK)
- `/es-es/services/copilot-optimization/huddersfield/` → should be `/en-gb/...` (Huddersfield is UK)
- `/ko-kr/services/conversational-seo-ai/stoke-on-trent/` → should be `/en-gb/...` (Stoke-on-Trent is UK)
- `/fr-fr/services/semantic-seo-ai/leeds/` → should be `/en-gb/...` (Leeds is UK)
- `/de-de/careers/bucheon/technical-writer/` → should be `/en-us/...` (Bucheon is not UK)
- `/fr-fr/careers/koshigaya/technical-writer/` → should be `/en-us/...` (Koshigaya is not UK)

**Root Cause:** External links or incorrectly generated internal links pointing to non-canonical locale versions of LOCAL pages.

---

## Root Causes

### 1. Internal Link Generation
**File:** `lib/nrlc_linking_kernel.php`

**Problem:** URLs generated without locale prefixes:
```php
'url' => $domain . '/services/',  // Missing locale prefix!
'url' => $domain . '/services/crawl-clarity/',  // Missing locale prefix!
'url' => $domain . '/insights/',  // Missing locale prefix!
```

**Impact:** Every page using `render_internal_links_section()` or `get_required_internal_links()` generates non-canonical URLs that redirect.

### 2. Missing Locale Detection
**Issue:** No helper function to ensure URLs always include proper locale prefixes.

### 3. External HTTP Links
**Issue:** External sources (old bookmarks, backlinks) pointing to HTTP versions.

### 4. Sitemap/Canonical Issues
**Potential:** Non-canonical URLs may be included in sitemaps or canonical tags.

---

## Fixes Implemented

### Fix 1: Update Internal Link Generation
**File:** `lib/nrlc_linking_kernel.php`

**Changes:**
- Add helper function `canonical_internal_url()` to generate locale-aware canonical URLs
- Update all URL generation to use locale prefixes
- Ensure city-based service URLs use correct locale (en-gb for UK cities, en-us for others)

### Fix 2: Add Canonical URL Helper
**File:** `lib/helpers.php`

**Changes:**
- Add `canonical_internal_url($path, $locale = null)` function
- Automatically detects current locale if not provided
- Handles city-based pages correctly (uses canonical locale based on city)

### Fix 3: Verify Sitemaps
**Check:** Ensure sitemaps only include canonical URLs (already implemented, but verify)

### Fix 4: robots.txt
**File:** `public/robots.txt` (if exists) or add to `.htaccess`

**Changes:**
- Block non-canonical locale versions of LOCAL pages (optional, redirects already handle this)

---

## Fixes Implemented ✅

### ✅ Fix 1: Added `canonical_internal_url()` Helper Function
**File:** `lib/helpers.php`

**Changes:**
- Added `canonical_internal_url($path, $locale = null)` function
- Automatically detects current locale if not provided
- Handles LOCAL pages correctly (uses canonical locale based on city geography)
- Handles GLOBAL pages correctly (uses current or default locale)
- Returns full canonical URLs with proper locale prefixes

### ✅ Fix 2: Updated Internal Link Generation
**File:** `lib/nrlc_linking_kernel.php`

**Changes:**
- All `get_required_internal_links()` URLs now use `canonical_internal_url()`
- All page-type specific links (insights, services, tools) now use canonical URLs
- `get_relevant_service()` now uses canonical URLs
- `get_service_for_tool()` now uses canonical URLs

### ✅ Fix 3: Updated Related Services Links
**File:** `lib/service_enhancements.php`

**Changes:**
- `get_related_services_for_linking()` now uses `canonical_internal_url()`
- Fixed bug where `$related` array was used before initialization
- City-specific service links now use canonical URLs
- Service overview links now use canonical URLs

### ✅ Fix 4: Verified Sitemaps
**Status:** Already correct ✅

**Verification:**
- Sitemaps only include canonical URLs (verified in `scripts/build_sitemaps.php`)
- City-based pages use canonical locale (en-gb for UK cities, en-us for others)
- No non-canonical URLs in sitemaps

### ✅ Fix 5: Verified robots.txt
**Status:** Correct ✅

**Verification:**
- `public/robots.txt` properly configured
- Sitemaps correctly referenced
- No need to block non-canonical URLs (redirects handle them correctly)

---

## Expected Impact

### Immediate
- ✅ Internal links now use canonical URLs
- ✅ No more missing locale prefix redirects from internal links
- ✅ Reduced redirect count as internal links are fixed

### Medium-term (2-4 weeks)
- Reduced GSC "Page with redirect" count as Google re-crawls pages with fixed internal links
- Improved crawl efficiency (no wasted budget on redirects)
- Better SEO signals (canonical internal linking)

### Long-term (1-2 months)
- GSC redirect count should drop significantly as:
  - New pages are indexed with canonical internal links
  - Old redirect chains are deprecated
  - External HTTP links are gradually replaced
- **Expected reduction:** From 16,151 pages to ~5,000-8,000 pages (remaining will be HTTP→HTTPS and legitimate locale redirects for LOCAL pages)

---

## Monitoring

### Metrics to Track
1. **GSC Redirect Count:** Should decrease weekly
2. **Crawl Efficiency:** Should improve as redirect chains decrease
3. **Index Coverage:** Should remain stable or improve

### Verification Steps
1. Check sample pages manually - ensure internal links use locale prefixes
2. Run `tools/canonical-sentinel/crawl.php` to audit internal links
3. Monitor GSC reports weekly for redirect count trends

---

## Notes

- **HTTP redirects** are expected and necessary (HTTP → HTTPS is required for security)
- **Locale redirects for LOCAL pages** are expected and correct (enforces canonical locale)
- **Missing locale prefix redirects** should be eliminated by these fixes

The goal is to minimize **unnecessary redirects** (missing locale prefixes, non-canonical locales) while keeping **necessary redirects** (HTTP→HTTPS, locale enforcement for LOCAL pages).
