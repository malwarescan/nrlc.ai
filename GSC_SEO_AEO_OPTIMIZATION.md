# GSC SEO/AEO Optimization Summary

**Date:** 2025-11-30  
**Status:** Complete

## Issues Found from GSC Data

### Canonical URL Issues (157 URLs)
1. **Missing locale prefix:** 122 URLs (e.g., `/careers/bristol/` instead of `/en-us/careers/bristol/`)
2. **Query parameters:** 42 URLs (UTM params should be stripped)
3. **HTTP instead of HTTPS:** 12 URLs

### Performance Issues
- **High impression, low CTR pages:** Many service pages have 0 clicks despite 50+ impressions
- **Top performing:** Job listings (17 clicks, 598 impressions, 2.84% CTR)

## Fixes Implemented

### 1. Enhanced Meta Descriptions (AEO-Optimized)
- **Service pages:** Answer-focused descriptions with benefits and call-to-action
- **Career pages:** Job-focused descriptions with salary/benefits info
- **Insight articles:** Research-focused descriptions with learning outcomes

**Before:**
```
"Professional Crawl Clarity services in New York. GEO-16 framework, structured data optimization."
```

**After:**
```
"Get Crawl Clarity in New York. Expert AI SEO services with proven results. GEO-16 framework implementation, structured data optimization, and AI engine citation readiness. Free consultation available."
```

### 2. Canonical Redirects
- Already handling HTTP → HTTPS redirects
- Already handling missing locale prefix redirects
- Already stripping UTM query parameters
- All non-canonical URLs will redirect to canonical versions

### 3. FAQPage Schema
- Already implemented on all service × city pages
- Ensures AEO optimization for answer engine queries
- Deterministic FAQ rotation (6 FAQs per page)

### 4. JobPosting Schema
- Already fully compliant
- Performing well in Google Jobs (2.84% CTR)
- Proper datePosted, validThrough, jobLocation

## High-Impression, Low-CTR Pages (Optimization Opportunities)

Top pages needing CTR improvement:
1. `/en-us/insights/open-seo-tools/` - 434 impressions, 0% CTR
2. `/en-us/services/link-building-ai/southampton/` - 192 impressions, 0% CTR
3. `/en-gb/services/mobile-seo-ai/singapore/` - 122 impressions, 0% CTR

**Action Items:**
- Enhanced meta descriptions (✅ Complete)
- FAQPage schema (✅ Already implemented)
- AEO-optimized content (✅ Already implemented)

## Verification Script

Created `scripts/verify_gsc_urls.php` to:
- Check all URLs from GSC data
- Identify canonical issues
- Find high-impression, low-CTR pages
- Generate optimization recommendations

## Next Steps

1. **Monitor GSC:** Track CTR improvements over next 2-4 weeks
2. **A/B Test:** Compare old vs new meta descriptions
3. **Content Enhancement:** Add more AEO-focused content to high-impression pages
4. **Schema Verification:** Ensure all pages have proper structured data

## Expected Results

- **CTR Improvement:** 20-40% increase on optimized pages
- **Canonical Consolidation:** All non-canonical URLs redirect properly
- **AEO Visibility:** Better appearance in answer engines (ChatGPT, Perplexity, etc.)
- **Job Listings:** Continue strong performance (already at 2.84% CTR)

