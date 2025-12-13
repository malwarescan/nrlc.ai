# INSIGHTS HUB SCHEMA COMPLIANCE — Google Search Gallery

**Date:** 2025-01-27  
**Status:** ✅ **COMPLIANT — FORBIDDEN SCHEMAS REMOVED**

---

## A) FORBIDDEN SCHEMAS REMOVED ✅

**File:** `pages/insights/index.php`

**Removed:**
- ❌ Blog schema (lines 178-192) — FORBIDDEN on hub page
- ❌ All inline JSON-LD schemas — Now uses `base_schemas()` exclusively

**Result:** Insights hub now only outputs schemas from `base_schemas()` via `templates/head.php`.

---

## B) ALLOWED SCHEMAS — COMPLIANT ✅

**File:** `lib/schema_builders.php` + `lib/helpers.php`

### B1) BreadcrumbList Schema — COMPLIANT ✅

**Updated:**
- ✅ Context-aware breadcrumbs (Home + Insights for hub)
- ✅ Added `@id`: `https://nrlc.ai/en-us/insights/#breadcrumb`
- ✅ All URLs use HTTPS via `SchemaFixes::ensureHttps()`
- ✅ Proper structure: Home (position 1) → Insights (position 2)

### B2) Organization Schema — REUSED ✅

**Verified:**
- ✅ Same `@id` as homepage: `https://nrlc.ai/en-us/#organization`
- ✅ Logo as `ImageObject` (not string)
- ✅ `sameAs` includes LinkedIn and Google Business Profile
- ✅ No duplicate Organization entities

### B3) WebSite Schema — REUSED ✅

**Verified:**
- ✅ Same structure as homepage
- ✅ `SearchAction` with proper target URL
- ✅ Site-wide schema (reused, not duplicated)

---

## C) METADATA — HUB-SPECIFIC ✅

**File:** `bootstrap/router.php` + `lib/meta_directive.php`

**Updated:**
- ✅ Added `insights_hub` type to `sudo_meta_directive_ctx()`
- ✅ Title: "Insights & Research on AI Search, SEO, and Structured Data | NRLC.ai"
- ✅ Description: "Research and insights from NRLC.ai on AI-driven search, structured data, indexing systems, and modern SEO strategy."
- ✅ Canonical: `https://nrlc.ai/en-us/insights/`
- ✅ `og:url` matches canonical exactly

**Result:** Metadata describes the hub (collection), not individual articles.

---

## D) VERIFICATION

### Validation Script
**File:** `scripts/validate_insights_hub_compliance.php`

**Checks:**
- ✅ Only allowed schema types present (Organization, WebSite, BreadcrumbList)
- ✅ No forbidden schema types (Blog, Article, FAQPage, Product, etc.)
- ✅ Organization @id matches homepage exactly
- ✅ BreadcrumbList has @id and correct structure (Home + Insights)
- ✅ Metadata is hub-specific (not article-specific)

**Run:** `php scripts/validate_insights_hub_compliance.php`

---

## E) GOOGLE SEARCH GALLERY ELIGIBILITY

### Rich Results Eligible:
1. ✅ **Breadcrumb Navigation** — BreadcrumbList with @id
2. ✅ **Organization Knowledge Panel** — Reused Organization schema
3. ✅ **Site Search Box** — Reused WebSite with SearchAction

### Rich Results NOT Eligible (Intentional):
- ❌ Article Rich Snippets (Article schema not present — correct for hub)
- ❌ FAQ Rich Snippets (FAQPage schema not present — correct for hub)
- ❌ Blog Carousel (Blog schema removed — correct for hub)

---

## F) FILES MODIFIED

1. ✅ `pages/insights/index.php` — Removed Blog schema, removed all inline JSON-LD
2. ✅ `bootstrap/router.php` — Added metadata generation for `/insights/` route
3. ✅ `lib/meta_directive.php` — Added `insights_hub` type support
4. ✅ `lib/helpers.php` — Updated `current_breadcrumbs()` to be context-aware
5. ✅ `lib/schema_builders.php` — Updated `ld_breadcrumbs()` to add @id for hub pages

---

## G) TESTING

### View-Source Verification:
1. Visit `https://nrlc.ai/en-us/insights/`
2. View page source
3. Search for `<script type="application/ld+json">`
4. Verify only 3 schemas:
   - Organization (with @id matching homepage)
   - WebSite (with SearchAction)
   - BreadcrumbList (with @id, Home + Insights)

### Google Rich Results Test:
1. Visit: https://search.google.com/test/rich-results
2. Enter: `https://nrlc.ai/en-us/insights/`
3. Expected eligible:
   - Breadcrumb navigation
   - Organization knowledge panel (reused)
   - Site search box (reused)

### Schema.org Validator:
1. Visit: https://validator.schema.org/
2. Enter: `https://nrlc.ai/en-us/insights/`
3. Verify all 3 schemas validate without errors

---

## H) COMPLIANCE CHECKLIST

- ✅ No Blog schema on insights hub
- ✅ No Article/BlogPosting schema on insights hub
- ✅ No FAQPage schema on insights hub
- ✅ No Product/SoftwareApplication schema on insights hub
- ✅ No JobPosting schema on insights hub
- ✅ Organization schema reused (same @id as homepage)
- ✅ WebSite schema reused (same structure as homepage)
- ✅ BreadcrumbList has @id
- ✅ BreadcrumbList has correct structure (Home + Insights)
- ✅ Meta title describes hub, not article
- ✅ Meta description describes collection, not content
- ✅ Canonical == og:url
- ✅ All schemas are JSON-LD
- ✅ All schemas are SSR (not client-side injected)
- ✅ All URLs are HTTPS

---

## I) INTERNAL LINKING

**Verified:**
- ✅ Each listed article links to its own canonical URL
- ✅ Insights hub is not noindex
- ✅ Links to key pillar articles present
- ✅ Contextual links to services pages present

---

**END OF INSIGHTS HUB SCHEMA COMPLIANCE REPORT**

