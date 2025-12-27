# Indexing Suppression Analysis - Google Search Console Data

**Date:** December 27, 2025  
**Issue:** Crawled - currently not indexed  
**Affected Pages:** 10,036 (as of Dec 23, 2025)

## Executive Summary

Google Search Console shows a massive spike in indexing suppression:
- **Nov 23, 2025:** 1,199 → 9,785 pages (8x increase)
- **Dec 16, 2025:** 9,785 → 10,036 pages

Analysis of 1,000 sample URLs reveals the primary issue: **985 service pages with city slugs (98.5% of suppressed URLs)** are being crawled but not indexed, indicating Google sees them as low-value or duplicate content.

## URL Breakdown

### By Category
- **Service pages with locale:** 988 URLs (98.8%)
- **URLs without locale prefix:** 5 URLs (0.5%)
- **HTTP URLs:** 5 URLs (0.5%)
- **API endpoints:** 2 URLs (0.2%)

### By Locale
- **en-us:** 741 URLs (74.1%)
- **en-gb:** 72 URLs (7.2%)
- **es-es:** 52 URLs (5.2%)
- **ko-kr:** 46 URLs (4.6%)
- **fr-fr:** 44 URLs (4.4%)
- **de-de:** 33 URLs (3.3%)

## Root Causes

### 1. Service+City Page Template Redundancy (PRIMARY ISSUE)
**985 service pages** are being suppressed. These pages likely suffer from:
- Insufficient informational differentiation between cities
- Near-duplicate template structures
- Weak entity clarity
- Low incremental value per page

**Evidence:** 25 service+city combinations exist in multiple locales (e.g., `claude-optimization/kansas-city` appears in both `de-de` and `en-us`), suggesting Google sees these as duplicate content.

### 2. URLs Without Locale Prefix (5 URLs)
These should redirect but may be getting indexed before redirect:
- `/services/entity-recognition-ai/fukaya/`
- `/services/personalization-ai/mesa/`
- `/services/copilot-optimization/sayama/`
- `/services/retrieval-optimization-ai/atlanta/`
- `/services/verification-optimization-ai/sagamihara/`

### 3. HTTP URLs (5 URLs)
These should redirect to HTTPS:
- `http://nrlc.ai/en-us/services/b2b-seo-ai/belfast/`
- `http://nrlc.ai/en-gb/services/link-building-ai/ulsan/`
- `http://nrlc.ai/de-de/services/link-building-ai/ageo/`
- `http://nrlc.ai/es-es/services/link-building-ai/sendai/`
- `http://nrlc.ai/en-us/services/topic-modeling-ai/leicester/`

### 4. API Endpoints (2 URLs)
These should be noindex:
- `https://nrlc.ai/api/book`
- `https://nrlc.ai/api/book/`

## Immediate Fixes Required

### 1. Add noindex to API Endpoints
API endpoints should not be indexed. Add robots meta tag or X-Robots-Tag header.

### 2. Verify Redirects Work
- HTTP → HTTPS redirects (should already be in place)
- URLs without locale → locale-prefixed URLs (should already be in place)

### 3. Service Page Content Differentiation
The primary issue is that service+city pages lack sufficient differentiation. Per the indexing suppression article, pages need:
- **Per-page informational differentiation**
- **Strengthened entity clarity**
- **Clear canonical intent**
- **Pages that resolve user intent decisively**

## Recommendations

### Short-term (Fix Technical Issues)
1. ✅ Add noindex to `/api/*` endpoints
2. ✅ Verify HTTP → HTTPS redirects work
3. ✅ Verify locale redirects work
4. ✅ Request re-indexing of fixed URLs in GSC

### Medium-term (Content Quality)
1. **Review service+city page templates** - Ensure each city page has unique, valuable content
2. **Strengthen entity signals** - Add location-specific schema, local business information
3. **Improve content differentiation** - Each city page should answer city-specific questions
4. **Review non-English locales** - Ensure de-de, es-es, fr-fr, ko-kr pages have sufficient unique content (not just translations)

### Long-term (Structural)
1. **Consider consolidating service+city pages** - If pages can't be differentiated, consider fewer, higher-quality pages
2. **Implement content quality scoring** - Monitor pages for template redundancy
3. **Add city-specific content** - Local testimonials, case studies, local market data

## Alignment with Indexing Suppression Research

This data validates the findings in the "Indexing Suppression, Perceived Page Quality, and Indirect Effects on Paid Search Auction Dynamics" article:

> "Common contributing factors include insufficient informational differentiation, near duplicate template structures, weak canonical signaling, low entity clarity, and intent overlap with existing indexed URLs."

The 985 suppressed service pages likely exhibit these exact characteristics, leading Google to see them as low marginal utility rather than valuable content.

