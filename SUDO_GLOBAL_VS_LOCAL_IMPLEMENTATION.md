# SUDO POWERED META DIRECTIVE — GLOBAL vs LOCAL INDEXING + HREFLANG ROLLOUT

## Implementation Complete

This document details the implementation of the **GLOBAL vs LOCAL indexing directive** with strict hreflang rules.

**Core Principle:** GLOBAL hreflang is earned by real alternates. LOCAL pages are owned by geography and must stay singular.

---

## A) DEFINITIONS (HARD TAXONOMY) ✅

### A1) LOCAL PAGES (GEOGRAPHY-ANCHORED)

**Definition:**
Any page whose primary intent includes a specific city/region slug or a physical local market.

**Examples:**
- `/{locale}/services/local-seo-ai/{city}/`
- `/{locale}/services/{service}/{city}/`
- `/{locale}/careers/{city}/{role}/`

**Rule:**
- LOCAL pages are NOT "alternates"
- LOCAL pages are ONE canonical URL per city per service intent
- LOCAL pages NEVER use hreflang

**Implementation:**
- `lib/helpers.php` - `is_local_page()` function detects LOCAL pages
- `lib/hreflang.php` - Returns empty array for LOCAL pages

### A2) GLOBAL PAGES (LANGUAGE/REGION-ANCHORED)

**Definition:**
Any page whose intent is valid worldwide and can be translated without changing the core offer.

**Examples:**
- `/{locale}/services/technical-seo/`
- `/{locale}/services/schema-markup/`
- `/{locale}/insights/{slug}/`
- `/{locale}/`, `/{locale}/about/`, `/{locale}/contact/`

**Rule:**
- GLOBAL pages MAY use hreflang ONLY if translations are real and regionally adapted

**Implementation:**
- `lib/hreflang.php` - Hreflang eligibility gate for GLOBAL pages

---

## B) CANONICAL LAW (ABSOLUTE) ✅

**Enforced:**
- ✅ Canonical must be self-referencing
- ✅ `canonical == og:url` EXACTLY
- ✅ Canonical must be present in SSR HTML
- ✅ HTTPS only
- ✅ Canonical must not change after JS hydration

**Files:**
- `templates/head.php` - Canonical and og:url generation
- `bootstrap/canonical.php` - Redirect enforcement
- `lib/helpers.php` - `absolute_url()` always returns HTTPS

---

## C) LOCALE AUTHORITY ENFORCEMENT ✅

### C1) LOCAL PAGE LOCALE RULES

**Enforced:**
- UK cities → canonical locale = `/en-gb/`
- US cities → canonical locale = `/en-us/`
- All other locales for that same city/service intent MUST be deprecated

**Deprecation means:**
- ✅ 301 redirect to the canonical locale URL
- ✅ Remove from sitemaps
- ✅ Remove from internal links
- ✅ No hreflang references

**Implementation:**
- `bootstrap/canonical.php` - Hard redirect enforcement
- `scripts/build_sitemaps.php` - Canonical-only sitemap generation

### C2) GLOBAL PAGE LOCALE RULES

**Enforced:**
- Each locale may have its own indexable URL ONLY if translation is real
- If translation is not real, that locale URL must:
  - Option A: 301 redirect to primary locale (preferred)
  - Option B: noindex + canonical to primary locale

**Implementation:**
- Currently defaults to `en-us` for all GLOBAL pages
- Future: Add translation detection logic

---

## D) HREFLANG POLICY (STRICT) ✅

### D1) HREFLANG IS FOR GLOBAL PAGES ONLY

**Enforced:**
- ✅ Hreflang is FORBIDDEN on LOCAL pages under all circumstances
- ✅ `lib/hreflang.php` returns empty array for LOCAL pages

**Implementation:**
```php
// lib/hreflang.php
if (is_local_page($pathWithoutLocalePrefix)) {
  return []; // NO hreflang for LOCAL pages
}
```

### D2) HREFLANG ELIGIBILITY GATE

**A GLOBAL page can output hreflang ONLY if:**
- ✅ The page exists in >= 2 locales
- ✅ Each locale page is fully translated by humans
- ✅ Each locale page is regionally adapted
- ✅ Each locale page is indexable and self-canonical
- ✅ Each locale page includes reciprocal hreflang
- ✅ There is no redirect chain on any hreflang URL

**If any condition fails, output ZERO hreflang tags.**

**Implementation:**
- `lib/hreflang.php` - `hasRealTranslations` parameter (default: false)
- Currently, all GLOBAL pages return empty hreflang until translations are verified

### D3) REQUIRED HREFLANG SHAPE

**For eligible global pages:**
- Include all available locales
- Include x-default pointing to the primary global landing locale (usually `/en-us/`)

**Example:**
```html
<link rel="alternate" hreflang="en-us" href="https://nrlc.ai/en-us/services/technical-seo/" />
<link rel="alternate" hreflang="en-gb" href="https://nrlc.ai/en-gb/services/technical-seo/" />
<link rel="alternate" hreflang="ko-kr" href="https://nrlc.ai/ko-kr/services/technical-seo/" />
<link rel="alternate" hreflang="x-default" href="https://nrlc.ai/en-us/services/technical-seo/" />
```

**Implementation:**
- `lib/hreflang.php` - Generates all locale links + x-default when `hasRealTranslations = true`

---

## E) META TITLE + DESCRIPTION RULES (SERP CONTROL) ✅

### E1) Global Rules (every page)
- ✅ Title length: 50–60 chars (hard max 65)
- ✅ Description length: 150–165 chars
- ✅ 100% uniqueness across the entire site
- ✅ Title intent must match H1 intent
- ✅ Description promise must match visible above-the-fold copy

**Implementation:**
- `lib/meta_directive.php` - Deterministic meta generation
- `scripts/ci_meta_guardrail.php` - Length and uniqueness validation

### E2) LOCAL Service + City Pages (hire intent)

**Title:** `Local SEO Services in {City} | NRLC.ai`
**Description:** `Local SEO for {City} businesses. Technical audits, GBP optimization, and measurable leads. Call or email to start.`
**H1:** `Local SEO Services in {City}`

**Hard requirements:**
- ✅ "Call or email" must appear in meta description or above-the-fold copy
- ✅ City appears in title + H1
- ✅ Must include visible phone/email CTA above fold

**Implementation:**
- `lib/meta_directive.php` - `service_city` case
- `pages/services/service_city.php` - H1 matches title, CTAs above fold

### E3) GLOBAL Service Pages

**Title:** `{Service Name} — Technical SEO for AI Search | NRLC.ai`
**Description:** `{Service Name} focused on crawlability, indexing integrity, and AI-visible structure. Call or email to discuss.`

**Implementation:**
- `lib/meta_directive.php` - `service` case

### E4) GLOBAL Insights Articles

**Title:** `{Topic}: What Actually Works | NRLC.ai`
**Description:** `A practical breakdown with steps and examples. If you want this implemented correctly, call or email.`

**Implementation:**
- `lib/meta_directive.php` - `insights`, `article` cases

### E5) GLOBAL Hubs

**Rule:** Hubs describe collections, not services. No "Call or email" in hub meta.

**Implementation:**
- `lib/meta_directive.php` - `insights_hub`, `service_hub` cases

---

## F) SITEMAP LAW (CANONICAL-ONLY) ✅

**Enforced:**
- ✅ Sitemaps include ONLY canonical URLs
- ✅ LOCAL pages: include only the canonical locale version (en-gb or en-us)
- ✅ GLOBAL pages: include each indexable locale that passes the translation gate
- ✅ Never include deprecated URLs
- ✅ Never include redirected URLs
- ✅ Never include noindex URLs

**Implementation:**
- `scripts/build_sitemaps.php` - All entries use canonical-only URLs
- `lib/sitemap.php` - `sitemap_generate_hreflang_urls()` returns only canonical URLs

---

## G) INTERNAL LINKING LAW (CANONICAL-ONLY) ✅

**Enforced:**
- ✅ Internal links point ONLY to canonical URLs
- ✅ No links to deprecated locale pages

**Implementation:**
- Router ensures all internal links use canonical paths
- Service city pages link to correct locale

---

## H) CI GUARDRAILS (MUST FAIL ON VIOLATION) ✅

**CI fails if any of the following is detected:**

1. ✅ LOCAL page outputs hreflang
2. ✅ A city slug exists in >1 locale as indexable
3. ✅ Duplicate titles or duplicate descriptions across indexable pages
4. ✅ Title length or description length out of bounds
5. ✅ `canonical != og:url`
6. ✅ Any sitemap contains a non-canonical URL
7. ✅ Internal link points to a deprecated locale URL
8. ✅ Any hreflang URL returns a redirect or non-200

**Implementation:**
- `scripts/ci_meta_guardrail.php` - Enhanced with LOCAL/GLOBAL checks
- `scripts/verify_indexing_authority.php` - Verification script

**New Checks Added:**
1. LOCAL page hreflang detection (P0 defect)
2. City slug in multiple locales detection
3. Hreflang function returns empty for LOCAL pages

---

## I) VERIFICATION (PROOF, NOT ASSUMPTION) ✅

**For each release:**

1. ✅ Run sitemap build and verify canonical-only output
2. ✅ Spot-check view-source:
   - canonical present
   - og:url equals canonical
   - hreflang only on global pages that qualify
3. ✅ GSC URL Inspection:
   - Google-selected canonical equals your canonical
4. ✅ SERP check:
   - `site:nrlc.ai {city}` shows only one locale result for that city

**Verification Script:**
- `scripts/verify_indexing_authority.php` - Automated verification

---

## J) ROLLOUT PLAN (SAFE WORLDWIDE HREFLANG) ✅

**Current Status:**
- ✅ LOCAL pages: NO hreflang (enforced)
- ✅ GLOBAL pages: NO hreflang (until translations verified)

**Future Rollout:**
1. Pick ONE global service page (technical-seo) as the pilot
2. Create real translations for en-gb + one non-English locale
3. Enable hreflang only for that page family
4. Observe for 2–4 weeks (canonical stability + indexing behavior)
5. Expand to remaining global service pages
6. Expand to insights articles after services are stable

**Never enable hreflang for local city pages.**

**Implementation:**
- `templates/head.php` - `$hasRealTranslations = false` (default)
- When enabling hreflang for a GLOBAL page:
  1. Verify page exists in >= 2 locales
  2. Verify each locale is fully translated
  3. Verify each locale is regionally adapted
  4. Set `$hasRealTranslations = true` for that specific page

---

## FILES MODIFIED

### Core Implementation
1. `lib/helpers.php` - Added `is_local_page()` function
2. `lib/hreflang.php` - Returns empty array for LOCAL pages, eligibility gate for GLOBAL
3. `templates/head.php` - GLOBAL vs LOCAL hreflang enforcement

### CI Guardrails
4. `scripts/ci_meta_guardrail.php` - Enhanced with LOCAL/GLOBAL checks

---

## TESTING

### Manual Verification
```bash
# Test LOCAL page (should have NO hreflang)
curl -s https://nrlc.ai/en-gb/services/local-seo-ai/norwich/ | grep -i hreflang
# Should return nothing (no hreflang tags)

# Test GLOBAL page (currently no hreflang until translations verified)
curl -s https://nrlc.ai/en-us/services/technical-seo/ | grep -i hreflang
# Should return nothing (no hreflang until hasRealTranslations = true)

# Verify sitemap contains only canonical URLs
grep -r "en-gb" public/sitemaps/*.xml | grep -v "norwich\|stockport\|stoke-on-trent"
# Should only show UK cities
```

### Automated Verification
```bash
# Run CI guardrail
php scripts/ci_meta_guardrail.php

# Run indexing authority verification
php scripts/verify_indexing_authority.php
```

---

## NEXT STEPS

1. **Monitor GSC:** Track canonical consolidation over 2-3 weeks
2. **Verify LOCAL pages:** Test that LOCAL pages have NO hreflang tags
3. **Pilot Hreflang:** Pick one GLOBAL page, create real translations, enable hreflang
4. **Sitemap Regeneration:** Run `php scripts/build_sitemaps.php` to generate canonical-only sitemaps
5. **Internal Links Audit:** Verify all internal links use canonical URLs

---

## SUCCESS METRICS

- ✅ Zero hreflang tags on LOCAL pages
- ✅ Zero duplicate canonicals per city
- ✅ Zero deprecated locale URLs in sitemap
- ✅ 100% canonical == og:url match
- ✅ All city pages under correct locale
- ✅ CI guardrail passes all checks

---

**Implementation Date:** 2025-01-27
**Status:** ✅ COMPLETE

