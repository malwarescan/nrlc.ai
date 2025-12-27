# Canonical Duplicate Analysis - Google Search Console Data

**Date:** December 27, 2025  
**Issue:** Duplicate, Google chose different canonical than user  
**Affected Pages:** 33,395 (as of Dec 23, 2025)

## Executive Summary

Google Search Console shows a massive spike in canonical duplicate issues:
- **Oct 26, 2025:** 195 → 16,480 pages (84x increase)
- **Oct 29, 2025:** 16,480 → 25,486 pages
- **Nov 23, 2025:** 25,486 → 36,059 pages (peak)
- **Dec 16, 2025:** 36,059 → 33,395 pages (slight decrease)

Analysis of 1,000 sample URLs reveals the primary issue: **102 service+city combinations exist in multiple locales**, causing Google to choose a different canonical than what the page specifies.

## URL Breakdown

### By Locale
- **en-gb:** 344 URLs (34.4%) - Mostly UK cities
- **de-de:** 263 URLs (26.3%)
- **es-es:** 135 URLs (13.5%)
- **fr-fr:** 119 URLs (11.9%)
- **ko-kr:** 117 URLs (11.7%)
- **en-us:** 22 URLs (2.2%) - Very few

### Key Findings

1. **102 service+city combinations exist in multiple locales**
   - Example: `llm-seeding/leeds` exists in `en-gb`, `es-es`, and `de-de`
   - Example: `agentic-seo/kumamoto` exists in `ko-kr`, `en-gb`, and `de-de`

2. **71 UK cities appear in non-en-gb locales**
   - `huddersfield` in `fr-fr`
   - `swansea` in `de-de`
   - `middlesbrough` in `fr-fr` and `es-es`
   - `coventry` in `de-de` and `ko-kr`
   - And 67 more combinations

## Root Cause

The "Duplicate, Google chose different canonical than user" issue occurs when:

1. **Multiple locale versions of the same page exist** (e.g., `/en-gb/services/llm-seeding/leeds/` and `/de-de/services/llm-seeding/leeds/`)
2. **Each version has a canonical tag pointing to itself** (or the wrong canonical)
3. **Google chooses a different canonical** (usually the `en-us` or `en-gb` version for UK cities) than what the page specifies

### Why This Happens

For UK cities:
- The canonical should be `en-gb` (per `bootstrap/canonical.php` logic)
- But if the page exists in multiple locales (e.g., `fr-fr`, `de-de`), Google may:
  - Crawl the non-canonical version before redirects happen
  - See a canonical tag pointing to itself
  - Choose `en-gb` as the canonical instead (because it's the "correct" locale for UK cities)

For non-UK cities:
- The canonical should be `en-us` (per `bootstrap/canonical.php` logic)
- But if the page exists in multiple locales, Google may choose `en-us` as canonical even if the page specifies a different locale

## Current Implementation Status

### ✅ Redirects Are Implemented
`bootstrap/canonical.php` (lines 84-126) already redirects:
- UK cities in non-`en-gb` locales → `en-gb` (301)
- Non-UK cities in non-`en-us` locales → `en-us` (301)

### ✅ Canonical Tags Are Set
`templates/head.php` (lines 60-93) already sets canonical tags:
- Non-canonical locale versions point to canonical locale version
- Non-canonical versions also get `noindex` meta tag

## Why URLs Are Still Being Crawled

Despite redirects and canonical tags, these URLs are still being crawled because:

1. **Google cached URLs before redirects were implemented** (Oct 26 spike suggests a deployment or sitemap change)
2. **Sitemaps may include non-canonical URLs** (need to verify sitemap generation)
3. **Internal links may point to non-canonical URLs** (need to audit internal linking)
4. **Google may be crawling from old cached data** (takes time to re-crawl after redirects)

## Recommendations

### Immediate Actions

1. **Verify redirects are working** - Test a few URLs manually:
   ```bash
   curl -I https://nrlc.ai/fr-fr/services/featured-snippets-ai/huddersfield/
   # Should return 301 → /en-gb/services/featured-snippets-ai/huddersfield/
   ```

2. **Audit sitemap generation** - Ensure sitemaps only include canonical URLs:
   - UK cities → only `en-gb` versions
   - Non-UK cities → only `en-us` versions

3. **Request re-indexing** - In Google Search Console, request re-indexing of:
   - All affected URLs
   - Sitemap files

### Long-term Fixes

1. **Ensure sitemaps only include canonical URLs** - Filter out non-canonical locale versions
2. **Audit internal links** - Ensure all internal links point to canonical URLs
3. **Monitor GSC** - Watch for reduction in duplicate canonical issues over next 2-4 weeks

## Files to Review

- `bootstrap/canonical.php` - Redirect logic (already correct)
- `templates/head.php` - Canonical tag logic (already correct)
- Sitemap generation code - Need to verify it only includes canonical URLs
- Internal link generation - Need to verify all links use canonical URLs

