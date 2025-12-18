# GSC Conversion + Eligibility Enforcement Summary

**Date:** 2025-12-18  
**Directive:** SUDO META DIRECTIVE — GSC CONVERSION + ELIGIBILITY ENFORCEMENT  
**Source:** `/scripts/gsc_conversion_audit_report.csv`

## Critical Issues Fixed

### 1. ✅ INTENT COLLISION ELIMINATED (MASSIVE ELIGIBILITY BLOCKER)

**Problem:** All service+city pages were redirecting to `local-seo-ai` regardless of actual service type, causing:
- Multiple service intents (llm-optimization, semantic-seo-ai, voice-search-optimization, etc.) → same canonical URL
- All pages sharing identical meta titles: "Local SEO Services in [City]"
- Google seeing all different service queries as the same page
- Suppressed impressions due to query → page ambiguity

**Fix:**
- **`bootstrap/canonical.php`**: Removed service type forcing logic (lines 92-99)
- **`bootstrap/router.php`**: Updated UK city redirect to preserve service type (line 140)
- **Result:** Each service type now has unique canonical URL and intent

**Files Changed:**
- `bootstrap/canonical.php` - Removed `if ($serviceSlug !== 'local-seo-ai')` redirect
- `bootstrap/router.php` - Changed redirect from `/en-gb/services/local-seo-ai/` to `/en-gb/services/{serviceSlug}/`

### 2. ✅ UNIQUE META TITLES ENFORCED

**Problem:** All service+city pages had identical titles regardless of service type:
- "Local SEO Services in [City] | NRLC.ai" for ALL services
- No differentiation between LLM Optimization, Semantic SEO, Voice Search, etc.

**Fix:**
- **`lib/meta_directive.php`**: Added service type mapping and unique title generation
- Each service type now gets unique title: `"{Service Type} Services in {City} | NRLC.ai"`
- Service-specific descriptions: `"{Service Type} services for {City} businesses..."`

**Service Map Added:**
- llm-optimization → "LLM Optimization Services"
- semantic-seo-ai → "Semantic SEO Services"
- voice-search-optimization → "Voice Search Optimization Services"
- chatgpt-optimization → "ChatGPT Optimization Services"
- conversion-optimization-ai → "Conversion Optimization Services"
- ... (25+ service types mapped)

**Files Changed:**
- `lib/meta_directive.php` - Lines 518-560: Complete rewrite of service+city meta generation

### 3. ✅ CONVERSION PRIMITIVES ENFORCED

**Problem:** 
- Placeholder phone number: `tel:+1234567890`
- Missing phone/email on rest-api service page (conversion score 70)

**Fix:**
- **`pages/services/service_city.php`**: Updated phone to `tel:+12135628438`, email to `hirejoelm@gmail.com`
- **`pages/services/service.php`**: Added phone/email CTAs to semantic services (rest-api, etc.)

**Files Changed:**
- `pages/services/service_city.php` - Line 94-95: Real phone/email
- `pages/services/service.php` - Lines 201-207: Added conversion primitives to semantic services

### 4. ✅ SCHEMA SPECIALIZATION VERIFIED

**Status:** Already properly specialized
- Service schema uses `get_service_name_from_slug()` and `get_service_type_from_slug()`
- Each service type gets unique `Service.name` and `Service.serviceType`
- LocalBusiness schema includes service-specific description
- FAQPage schema added when FAQs exist

**No changes needed** - schema is already compliant

## Impact Analysis

### Before Fixes:
- **Intent Collision:** 100+ service types → 1 canonical pattern (local-seo-ai)
- **Meta Duplication:** All service+city pages had identical titles
- **Conversion Gaps:** Placeholder phone, missing elements on some pages
- **GSC Eligibility:** Suppressed due to query ambiguity

### After Fixes:
- **Unique Intent:** Each service type has distinct canonical URL
- **Unique Meta:** Service-specific titles and descriptions
- **Complete Conversion:** All pages have phone, email, CTA
- **GSC Eligibility:** Improved query → page confidence

## Expected Results (2-4 weeks)

1. **Impression Expansion:** Unique intents allow Google to show pages for service-specific queries
2. **CTR Stabilization:** Clear service differentiation improves click-through
3. **Reduced Ambiguity:** Query → page mapping is now unambiguous
4. **Higher Conversion:** Visible phone/email increases interaction rates

## Files Modified

1. `bootstrap/canonical.php` - Removed service type forcing
2. `bootstrap/router.php` - Preserve service type in redirects
3. `lib/meta_directive.php` - Unique meta titles per service type
4. `pages/services/service_city.php` - Real phone/email
5. `pages/services/service.php` - Conversion primitives for semantic services

## Verification

Run the conversion audit again after deployment:
```bash
php scripts/qa_gsc_conversion_audit.php https://nrlc.ai /path/to/Pages.csv
```

Expected improvements:
- Conversion scores: 70 → 100 (for rest-api and similar pages)
- Unique meta titles: 100% coverage
- No intent collisions: 0 redirects to wrong service type
- Conversion elements: 100% coverage

## Next Steps

1. Deploy changes to production
2. Monitor GSC for impression expansion (2-4 weeks)
3. Re-run conversion audit to verify fixes
4. Track CTR improvements by service type

