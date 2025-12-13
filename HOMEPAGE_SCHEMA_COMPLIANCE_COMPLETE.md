# HOMEPAGE SCHEMA COMPLIANCE — Google Search Gallery

**Date:** 2025-01-27  
**Status:** ✅ **COMPLIANT — FORBIDDEN SCHEMAS REMOVED**

---

## A) FORBIDDEN SCHEMAS REMOVED ✅

**File:** `pages/home/home.php`

**Removed:**
- ❌ Service schema (lines 317-361) — FORBIDDEN on homepage
- ❌ FAQPage schema (lines 363-402) — FORBIDDEN on homepage
- ❌ Duplicate WebSite schema (lines 281-294) — Already in `base_schemas()`
- ❌ Duplicate Organization schema (lines 296-315) — Already in `base_schemas()`

**Result:** Homepage now only outputs schemas from `base_schemas()` via `templates/head.php`.

---

## B) ALLOWED SCHEMAS — UPDATED TO COMPLIANCE ✅

**File:** `lib/schema_builders.php`

### B1) Organization Schema — COMPLIANT ✅

**Updated:**
- ✅ Added `@id`: `https://nrlc.ai/en-us/#organization`
- ✅ Logo as `ImageObject` (not string):
  ```json
  "logo": {
    "@type": "ImageObject",
    "url": "https://nrlc.ai/assets/images/nrlcai logo 0.png",
    "width": 43,
    "height": 43
  }
  ```
- ✅ `sameAs` array includes:
  - `https://www.linkedin.com/company/neural-command/`
  - `https://g.co/kgs/EP6p5de`
- ✅ `url` points to canonical homepage: `https://nrlc.ai/en-us/`

### B2) WebSite Schema — COMPLIANT ✅

**Updated:**
- ✅ `url` points to canonical homepage: `https://nrlc.ai/en-us/`
- ✅ `potentialAction` with `SearchAction`:
  ```json
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://nrlc.ai/?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
  ```

### B3) BreadcrumbList Schema — MINIMAL ✅

**Updated:**
- ✅ Minimal breadcrumb (Home only) for homepage
- ✅ All URLs use HTTPS via `SchemaFixes::ensureHttps()`
- ✅ Fallback to Home breadcrumb if `current_breadcrumbs()` returns empty

---

## C) SCHEMA OUTPUT LOCATION

**Homepage schemas are output in `templates/head.php` (lines 120-122):**
```php
foreach ($baseSchemas as $s) {
  echo '<script type="application/ld+json">'.json_encode($s, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
```

**No additional schemas** are injected via `$GLOBALS['__jsonld']` on homepage.

---

## D) VERIFICATION

### Validation Script
**File:** `scripts/validate_homepage_schema_compliance.php`

**Checks:**
- ✅ Only allowed schema types present (Organization, WebSite, BreadcrumbList)
- ✅ No forbidden schema types (Service, FAQPage, Product, JobPosting, etc.)
- ✅ Organization has `@id`, logo as ImageObject, sameAs array
- ✅ WebSite has SearchAction
- ✅ BreadcrumbList is minimal

**Run:** `php scripts/validate_homepage_schema_compliance.php`

---

## E) GOOGLE SEARCH GALLERY ELIGIBILITY

### Rich Results Eligible:
1. ✅ **Organization Knowledge Panel** — Organization schema with @id, logo, sameAs
2. ✅ **Site Search Box** — WebSite with SearchAction
3. ✅ **Breadcrumb Navigation** — BreadcrumbList (minimal)

### Rich Results NOT Eligible (Intentional):
- ❌ FAQ Rich Snippets (FAQPage removed — not homepage intent)
- ❌ Service Listings (Service schema removed — belongs on service pages)
- ❌ Product Snippets (Product schema not present — correct)
- ❌ Job Postings (JobPosting schema not present — correct)

---

## F) FILES MODIFIED

1. ✅ `pages/home/home.php` — Removed all inline JSON-LD (Service, FAQPage, duplicates)
2. ✅ `lib/schema_builders.php` — Updated Organization, WebSite, BreadcrumbList to compliance

---

## G) TESTING

### View-Source Verification:
1. Visit `https://nrlc.ai/en-us/`
2. View page source
3. Search for `<script type="application/ld+json">`
4. Verify only 3 schemas:
   - Organization (with @id, ImageObject logo, sameAs)
   - WebSite (with SearchAction)
   - BreadcrumbList (minimal)

### Google Rich Results Test:
1. Visit: https://search.google.com/test/rich-results
2. Enter: `https://nrlc.ai/en-us/`
3. Expected eligible:
   - Organization knowledge panel
   - Site search box
   - Breadcrumb navigation

### Schema.org Validator:
1. Visit: https://validator.schema.org/
2. Enter: `https://nrlc.ai/en-us/`
3. Verify all 3 schemas validate without errors

---

## H) COMPLIANCE CHECKLIST

- ✅ No FAQPage schema on homepage
- ✅ No Service schema on homepage
- ✅ No Product/SoftwareApplication schema on homepage
- ✅ No JobPosting schema on homepage
- ✅ No Article/BlogPosting schema on homepage
- ✅ Organization schema has @id
- ✅ Organization logo is ImageObject (not string)
- ✅ Organization sameAs includes LinkedIn and Google Business
- ✅ WebSite schema has SearchAction
- ✅ BreadcrumbList is minimal (Home only)
- ✅ All schemas are JSON-LD
- ✅ All schemas are SSR (not client-side injected)
- ✅ All URLs are HTTPS
- ✅ Canonical URL is `/en-us/`

---

**END OF HOMEPAGE SCHEMA COMPLIANCE REPORT**

