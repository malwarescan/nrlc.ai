# Canonical Collapse Fix - Implementation Complete

**Date:** December 28, 2025  
**Status:** ✅ Code changes implemented

## Changes Implemented

### 1. Updated Related Services Function ✅
**File:** `lib/service_enhancements.php`

- Added `$citySlug` parameter to `get_related_services_for_linking()`
- Function now generates city-specific links with correct locale
- For UK cities, links use `en-gb` locale
- For US cities, links use `en-us` locale
- Adds "Other Services in [City]" links

**Impact:** Service pages now link to other services in the same city with correct locale.

### 2. Updated Service City Template ✅
**File:** `pages/services/service_city.php`

- Updated call to `get_related_services_for_linking()` to pass `$citySlug`
- Related services now include city-specific links

**Impact:** Each service+city page now links to other services in the same city.

### 3. Added UK City Links to Services Index ✅
**File:** `pages/services/index.php`

- Added UK city detection and link generation
- Shows "Local SEO Services in UK Cities" section for en-GB locale
- Links to featured UK cities: Norwich, London, Manchester, Birmingham, Leeds, Sheffield, Southampton

**Impact:** Services index page now provides discovery path to en-GB city pages.

## Next Steps (Manual)

### 1. Submit Sitemap to Google Search Console
- Go to GSC → Sitemaps
- Submit: `https://nrlc.ai/sitemap.xml`
- Verify sitemap is processed

### 2. Request Re-indexing
- In GSC, request re-indexing of:
  - `/en-gb/services/local-seo-ai/norwich/`
  - Other UK city pages
- Monitor indexing status

### 3. Verify Internal Links
- Visit `/en-gb/services/`
- Verify UK city links are visible
- Check that links work correctly

### 4. Monitor GSC
- Watch for indexing improvements
- Check "Performance" report for en-GB pages
- Verify canonical issues resolve

## Expected Outcome

1. ✅ Google discovers en-GB pages via sitemap (already in sitemap)
2. ✅ Google discovers en-GB pages via internal links (now implemented)
3. ✅ Google crawls en-GB pages
4. ✅ Canonical resolution succeeds
5. ✅ Pages index and rank

## Timeline

- **Immediate:** Code deployed, sitemap submitted
- **Week 1:** Google re-crawls, discovers en-GB pages
- **Week 2-4:** Pages index, rankings improve

## Verification

After deployment, verify:
- [ ] UK city links visible on `/en-gb/services/`
- [ ] Related services link to same city with correct locale
- [ ] Sitemap submitted to GSC
- [ ] Re-indexing requested
- [ ] GSC shows indexing improvements

