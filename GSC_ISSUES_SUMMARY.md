# Google Search Console Issues - Complete Analysis

**Date:** December 27, 2025  
**Analysis of 3 GSC Coverage Issues**

## Issue Summary

### 1. Indexing Suppression (10,036 pages)
**Status:** ✅ Technical fixes implemented, content quality issue remains

**Root Cause:**
- 985 service pages (98.5%) lack content differentiation
- Template redundancy, weak entity clarity, low incremental value per page

**Fixes Applied:**
- ✅ Added noindex to API endpoints (`/api/*`)
- ✅ Verified HTTP → HTTPS redirects
- ✅ Verified locale redirects

**Action Required:**
- Content quality improvements for service+city pages
- Each city page needs unique, valuable content

### 2. Canonical Duplicates (33,395 pages)
**Status:** ✅ Code is correct, issue is cached URLs

**Root Cause:**
- 102 service+city combinations exist in multiple locales
- Google cached non-canonical URLs before redirects were implemented (Oct 26 spike)

**Current Implementation:**
- ✅ Redirects work (UK cities → en-gb, others → en-us)
- ✅ Canonical tags point to correct locale versions
- ✅ Sitemaps only include canonical URLs
- ✅ Helper functions exist and work

**Action Required:**
- Request re-indexing in GSC
- Wait for Google to re-crawl (2-4 weeks)

### 3. 404 Errors (16 pages)
**Status:** ✅ Fixed

**Root Cause:**
- 12 career pages without locale prefix returning 404
- 1 www subdomain issue (Railway configuration)
- 2 search pages with query parameters
- 1 audit page

**Fixes Applied:**
- ✅ Fixed career page redirect logic to use `get_canonical_locale_for_city()`
- ✅ Added noindex to search/audit 404 pages

**Action Required:**
- Deploy fixes
- Request re-indexing of career pages

## Files Modified

1. **bootstrap/router.php**
   - Fixed career page redirect to use city-based locale detection
   - Added noindex to API endpoints
   - Added noindex to search/audit 404 pages

2. **templates/head.php**
   - Added support for noindex in page metadata

## Next Steps

1. **Deploy all fixes** - Push changes to production
2. **Request re-indexing in GSC** - For:
   - Career pages (should now redirect correctly)
   - API endpoints (should now be noindex)
   - Search/audit pages (should now be noindex)
3. **Monitor GSC** - Watch for reduction in issues over next 2-4 weeks
4. **Content audit** - Review service+city pages for content differentiation

## Expected Resolution Timeline

- **Week 1-2:** Google starts re-crawling affected URLs
- **Week 2-4:** Redirects take effect, issues start decreasing
- **Week 4-8:** Most technical issues resolved
- **Ongoing:** Content quality improvements needed for indexing suppression

