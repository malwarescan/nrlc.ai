# Google Search Gallery Compliance — Implementation Update

**Date:** 2025-01-27  
**Status:** ✅ **COMPLETE — BOTH PAGES COMPLIANT**

---

## EXECUTIVE SUMMARY

Successfully implemented Google Search Gallery compliance for two critical pages:
1. **Homepage** (`/en-us/`)
2. **Insights Hub** (`/en-us/insights/`)

Both pages now output only legitimate, Google-supported rich result schemas with no over-markup, schema abuse, or misclassification.

---

## UPDATE 1: HOMEPAGE SCHEMA COMPLIANCE

### Page: `https://nrlc.ai/en-us/`
### Page Type: Brand + Organization homepage

### Changes Implemented:

#### A) Forbidden Schemas Removed ✅
- ❌ **Service schema** — Removed (belongs on service pages, not brand homepage)
- ❌ **FAQPage schema** — Removed (not homepage intent)
- ❌ **Duplicate WebSite schema** — Removed (already in `base_schemas()`)
- ❌ **Duplicate Organization schema** — Removed (already in `base_schemas()`)

**File Modified:** `pages/home/home.php`
- Removed 125+ lines of inline JSON-LD schemas
- Now relies exclusively on `base_schemas()` from `templates/head.php`

#### B) Allowed Schemas — Enhanced to Compliance ✅

**File Modified:** `lib/schema_builders.php`

1. **Organization Schema:**
   - ✅ Added `@id`: `https://nrlc.ai/en-us/#organization`
   - ✅ Logo as `ImageObject` (not string):
     ```json
     "logo": {
       "@type": "ImageObject",
       "url": "https://nrlc.ai/assets/images/nrlc-logo.png",
       "width": 43,
       "height": 43
     }
     ```
   - ✅ `sameAs` includes:
     - `https://www.linkedin.com/company/neural-command/`
     - `https://g.co/kgs/EP6p5de`
   - ✅ `url` points to canonical: `https://nrlc.ai/en-us/`

2. **WebSite Schema:**
   - ✅ `url` points to canonical: `https://nrlc.ai/en-us/`
   - ✅ `SearchAction` with proper target URL format

3. **BreadcrumbList Schema:**
   - ✅ Minimal (Home only) for homepage
   - ✅ All URLs use HTTPS

### Rich Results Eligible:
- ✅ Organization Knowledge Panel
- ✅ Site Search Box
- ✅ Breadcrumb Navigation

### Validation:
- **Script:** `scripts/validate_homepage_schema_compliance.php`
- **Status:** ✅ PASSED
- **Schemas Found:** Organization, WebSite, BreadcrumbList (3 total)
- **Forbidden Schemas:** 0

---

## UPDATE 2: INSIGHTS HUB SCHEMA COMPLIANCE

### Page: `https://nrlc.ai/en-us/insights/`
### Page Type: Content hub / editorial index (Collection, not content item)

### Changes Implemented:

#### A) Forbidden Schemas Removed ✅
- ❌ **Blog schema** — Removed (FORBIDDEN on hub page)
- ❌ **All inline JSON-LD schemas** — Removed (now uses `base_schemas()` exclusively)

**File Modified:** `pages/insights/index.php`
- Removed Blog schema definition
- Removed all inline JSON-LD injection

#### B) Allowed Schemas — Enhanced to Compliance ✅

**Files Modified:** `lib/schema_builders.php`, `lib/helpers.php`

1. **BreadcrumbList Schema:**
   - ✅ Context-aware breadcrumbs (Home + Insights for hub)
   - ✅ Added `@id`: `https://nrlc.ai/en-us/insights/#breadcrumb`
   - ✅ Correct structure: Home (position 1) → Insights (position 2)
   - ✅ Handles locale prefixes correctly

2. **Organization Schema:**
   - ✅ Reused (same `@id` as homepage: `https://nrlc.ai/en-us/#organization`)
   - ✅ No duplicate entities
   - ✅ Logo as `ImageObject`

3. **WebSite Schema:**
   - ✅ Reused (same structure as homepage)
   - ✅ `SearchAction` present

#### C) Metadata — Hub-Specific ✅

**Files Modified:** `bootstrap/router.php`, `lib/meta_directive.php`

- ✅ Added `insights_hub` type to `sudo_meta_directive_ctx()`
- ✅ **Title:** "Insights & Research on AI Search, SEO, and Structured Data | NRLC.ai"
- ✅ **Description:** "Research and insights from NRLC.ai on AI-driven search, structured data, indexing systems, and modern SEO strategy."
- ✅ **Canonical:** `https://nrlc.ai/en-us/insights/`
- ✅ `og:url` matches canonical exactly

**Result:** Metadata describes the hub (collection), not individual articles.

### Rich Results Eligible:
- ✅ Breadcrumb Navigation
- ✅ Organization Knowledge Panel (reused)
- ✅ Site Search Box (reused)

### Validation:
- **Script:** `scripts/validate_insights_hub_compliance.php`
- **Status:** ✅ PASSED
- **Schemas Found:** Organization, WebSite, BreadcrumbList (3 total)
- **Forbidden Schemas:** 0
- **BreadcrumbList:** Has @id and correct structure (Home + Insights)

---

## TECHNICAL IMPLEMENTATION DETAILS

### Core Functions Updated:

1. **`lib/schema_builders.php`:**
   - `ld_organization()` — Added @id, ImageObject logo, enhanced sameAs
   - `ld_website_with_searchaction()` — Ensured canonical URL consistency
   - `ld_breadcrumbs()` — Made context-aware, added @id for hub pages, handles locale prefixes

2. **`lib/helpers.php`:**
   - `current_breadcrumbs()` — Made context-aware, handles locale prefixes, adds Insights/Services/Careers breadcrumbs

3. **`lib/meta_directive.php`:**
   - `sudo_meta_directive_ctx()` — Added `insights_hub` type support

4. **`bootstrap/router.php`:**
   - Added metadata generation for `/insights/` route using ctx-based system

### Schema Output Location:

Both pages output schemas via `templates/head.php` (lines 120-122):
```php
foreach ($baseSchemas as $s) {
  echo '<script type="application/ld+json">'.json_encode($s, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
```

**No additional schemas** are injected via `$GLOBALS['__jsonld']` on these pages.

---

## COMPLIANCE CHECKLIST — BOTH PAGES

### Homepage (`/en-us/`):
- ✅ No Service schema
- ✅ No FAQPage schema
- ✅ No Product/SoftwareApplication schema
- ✅ Organization schema has @id
- ✅ Organization logo is ImageObject
- ✅ Organization sameAs includes LinkedIn and Google Business
- ✅ WebSite schema has SearchAction
- ✅ BreadcrumbList is minimal (Home only)
- ✅ Canonical == og:url
- ✅ All schemas are JSON-LD
- ✅ All schemas are SSR (not client-side injected)
- ✅ All URLs are HTTPS

### Insights Hub (`/en-us/insights/`):
- ✅ No Blog schema
- ✅ No Article/BlogPosting schema
- ✅ No FAQPage schema
- ✅ No Product/SoftwareApplication schema
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

## FILES MODIFIED SUMMARY

### Homepage Compliance:
1. ✅ `pages/home/home.php` — Removed Service, FAQPage, duplicate schemas
2. ✅ `lib/schema_builders.php` — Enhanced Organization, WebSite, BreadcrumbList

### Insights Hub Compliance:
1. ✅ `pages/insights/index.php` — Removed Blog schema, removed inline JSON-LD
2. ✅ `bootstrap/router.php` — Added metadata generation for `/insights/` route
3. ✅ `lib/meta_directive.php` — Added `insights_hub` type support
4. ✅ `lib/helpers.php` — Updated `current_breadcrumbs()` to be context-aware
5. ✅ `lib/schema_builders.php` — Updated `ld_breadcrumbs()` to add @id for hub pages

**Total Files Modified:** 5 files

---

## VALIDATION SCRIPTS

### Homepage:
```bash
php scripts/validate_homepage_schema_compliance.php
```
**Output:** ✅ PASSED

### Insights Hub:
```bash
php scripts/validate_insights_hub_compliance.php
```
**Output:** ✅ PASSED

---

## TESTING RECOMMENDATIONS

### Google Rich Results Test:
1. Visit: https://search.google.com/test/rich-results
2. Test URLs:
   - `https://nrlc.ai/en-us/`
   - `https://nrlc.ai/en-us/insights/`
3. Expected eligible rich results:
   - Organization knowledge panel
   - Site search box
   - Breadcrumb navigation

### Schema.org Validator:
1. Visit: https://validator.schema.org/
2. Test both URLs
3. Verify all schemas validate without errors

### View-Source Verification:
1. Visit both pages
2. View page source
3. Search for `<script type="application/ld+json">`
4. Verify:
   - Homepage: 3 schemas (Organization, WebSite, BreadcrumbList)
   - Insights Hub: 3 schemas (Organization, WebSite, BreadcrumbList)
   - No forbidden schemas present

---

## KEY PRINCIPLES APPLIED

1. **Intent Alignment:** Schemas match page intent (homepage = brand, hub = collection)
2. **No Over-Markup:** Only legitimate, Google-supported schemas
3. **No Schema Abuse:** No attempts to force rich results through inappropriate schemas
4. **Entity Reuse:** Organization and WebSite schemas reused across pages (same @id)
5. **SSR Only:** All schemas server-side rendered, stable across hydration
6. **Canonical Consistency:** canonical == og:url on all pages

---

## NEXT STEPS (OPTIONAL)

If extending to other hub pages:
- Services hub (`/en-us/services/`)
- Careers hub (`/en-us/careers/`)
- Tools hub (`/en-us/tools/`)

Apply the same pattern:
1. Remove any forbidden schemas
2. Use `base_schemas()` exclusively
3. Add hub-specific metadata via router
4. Ensure BreadcrumbList has @id and correct structure
5. Validate with compliance script

---

## SUCCESS METRICS

- ✅ **0 forbidden schemas** on homepage
- ✅ **0 forbidden schemas** on insights hub
- ✅ **3 allowed schemas** on each page (Organization, WebSite, BreadcrumbList)
- ✅ **100% SSR** (no client-side schema injection)
- ✅ **100% HTTPS** (all URLs use HTTPS)
- ✅ **100% validation pass** (both compliance scripts pass)

---

**END OF GOOGLE SEARCH GALLERY COMPLIANCE UPDATE**

