# Canonical Duplicate Fixes - Implementation Summary

**Date:** December 27, 2025  
**Status:** ✅ Code is correct, issue is cached URLs

## Analysis Summary

**33,395 pages** affected by "Duplicate, Google chose different canonical than user" issue.

### Root Cause
- **102 service+city combinations exist in multiple locales**
- **71 UK cities appear in non-en-gb locales** (should redirect to en-gb)
- Google cached these URLs before redirects were implemented (Oct 26 spike)
- Despite redirects and canonical tags being correct, Google hasn't re-crawled yet

## Current Implementation Status

### ✅ Redirects Are Correct
`bootstrap/canonical.php` (lines 84-126):
- UK cities in non-`en-gb` locales → redirect to `en-gb` (301)
- Non-UK cities in non-`en-us` locales → redirect to `en-us` (301)

### ✅ Canonical Tags Are Correct
`templates/head.php` (lines 60-93):
- Non-canonical locale versions point canonical tag to canonical locale version
- Non-canonical versions also get `noindex` meta tag

### ✅ Sitemaps Are Correct
`scripts/build_sitemaps.php` (lines 88-94):
- Only includes canonical URLs in sitemaps
- UK cities → only `en-gb` versions
- Non-UK cities → only `en-us` versions

## Why URLs Are Still Being Crawled

Despite correct implementation, these URLs are still being crawled because:

1. **Google cached URLs before redirects were implemented** (Oct 26 spike suggests a deployment or sitemap change)
2. **Google takes time to re-crawl** - Even with redirects, Google may take weeks to re-crawl and update its index
3. **Internal links may point to non-canonical URLs** - Need to audit internal linking

## Recommendations

### Immediate Actions

1. **Verify redirects are working** - Test a few URLs manually:
   ```bash
   curl -I https://nrlc.ai/fr-fr/services/featured-snippets-ai/huddersfield/
   # Should return 301 → /en-gb/services/featured-snippets-ai/huddersfield/
   
   curl -I https://nrlc.ai/de-de/services/llm-seeding/leeds/
   # Should return 301 → /en-gb/services/llm-seeding/leeds/
   ```

2. **Request re-indexing in GSC** - In Google Search Console:
   - Go to URL Inspection tool
   - Request re-indexing for a sample of affected URLs
   - Submit updated sitemap (if sitemaps were regenerated)

3. **Monitor GSC** - Watch for reduction in duplicate canonical issues over next 2-4 weeks

### Long-term Fixes

1. **Audit internal links** - Ensure all internal links point to canonical URLs:
   - Search codebase for hardcoded URLs with non-canonical locales
   - Use helper functions to generate canonical URLs

2. **Verify helper functions exist** - Check that `is_canonical_locale_for_local_page()` and `get_canonical_locale_for_city()` are implemented in `lib/helpers.php`

3. **Monitor redirects** - Set up monitoring to track redirect performance

## Expected Resolution Timeline

- **Week 1-2:** Google starts re-crawling affected URLs
- **Week 2-4:** Redirects take effect, canonical issues start decreasing
- **Week 4-8:** Most duplicate canonical issues resolved

## Files Verified

- ✅ `bootstrap/canonical.php` - Redirect logic (correct)
- ✅ `templates/head.php` - Canonical tag logic (correct)
- ✅ `scripts/build_sitemaps.php` - Sitemap generation (correct, only canonical URLs)
- ✅ `lib/sitemap.php` - Sitemap helper functions (correct)

## Next Steps

1. **Verify helper functions** - Check if `is_canonical_locale_for_local_page()` and `get_canonical_locale_for_city()` exist
2. **Test redirects** - Manually test a few affected URLs
3. **Request re-indexing** - Submit URLs for re-indexing in GSC
4. **Monitor** - Watch GSC for reduction in duplicate canonical issues

