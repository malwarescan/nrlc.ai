# SUDO PATCH KERNEL — Implementation Complete

**Date:** 2025-01-27  
**Status:** ✅ **PATCHES APPLIED — VERIFICATION REQUIRED**

---

## A) ROOT "/" REDIRECT BUG — FIXED ✅

**File:** `bootstrap/canonical.php`

**Change:** Added early return for root path before locale redirect logic (lines 49-52)

```php
// Root "/" must remain canonical as "/" (do not force locale).
// This prevents breaking the homepage URL.
if ($uri === '/' || $uri === '') {
  return;
}
```

**Verification Required:**
- `curl -I https://nrlc.ai/` should return 200 (not 301)
- `curl -I http://nrlc.ai/` should 301 to `https://nrlc.ai/` (then 200)
- `curl -I https://www.nrlc.ai/` should 301 to `https://nrlc.ai/`

---

## B) QUERY PARAM STRIPPING — FIXED ✅

**File:** `bootstrap/canonical.php`

**Change:** Removed blanket query param stripping (line 82)

**Before:**
```php
$strip = ['utm_source','utm_medium','utm_campaign','utm_term','utm_content','gclid','fbclid'];
$query = array_diff_key($query, array_flip($strip));
```

**After:**
```php
// Strip only known spam/junk params, preserve UTMs for analytics
// Canonical tags will ignore UTMs, but we keep them in redirects for tracking
$strip = []; // Keep all params in redirects - canonical tag handles UTM exclusion
```

**Note:** Canonical tags in `templates/head.php` already exclude UTMs via `absolute_url()` which doesn't include query params.

---

## C) DUPLICATE META AT SCALE — PARTIALLY FIXED ⚠️

### C1) Context-Based Meta Directive — IMPLEMENTED ✅

**File:** `lib/meta_directive.php`

**New Function:** `sudo_meta_directive_ctx(array $ctx)`

**Features:**
- Deterministic metadata generation from context
- Type-specific lead-ins to ensure uniqueness:
  - `blog_post`: "Learn how to"
  - `case_study`: "See how we"
  - `resource`: "Download or reference"
  - `tool`: "Use this tool to"
  - `industry`: "SEO and AI visibility for"
- Collision-proof suffixes per type
- Length validation (title <= 65, description <= 175)
- Slug-based fallbacks if title/excerpt missing

### C2) Router Integration — IMPLEMENTED ✅

**File:** `bootstrap/router.php`

**Routes Updated:**
- `/blog/blog-post-(\d+)/` — Sets ctx with topic rotation
- `/case-studies/case-study-(\d+)/` — Sets ctx with company rotation
- `/resources/resource-(\d+)/` — Sets ctx with resource type rotation
- `/tools/([^/]+)/` — Sets ctx with tool name
- `/industries/([^/]+)/` — Sets ctx with industry name

**Metadata stored in:** `$GLOBALS['__page_meta']` (takes precedence in `templates/head.php`)

### C3) Template Files Updated — PARTIAL ⚠️

**Files Updated:**
- `pages/blog/blog-post.php` — Removed placeholder metadata
- `pages/case-studies/case-study.php` — Removed placeholder metadata
- `pages/resources/resource.php` — Commented placeholder metadata
- `pages/tools/tool.php` — Removed placeholder metadata
- `pages/industries/industry.php` — Removed placeholder metadata

**Issue:** Individual numbered files (e.g., `blog-post-1.php`, `case-study-1.php`) still contain old metadata and include `head.php` directly, bypassing router metadata.

**Status:** Router metadata takes precedence when router handles request, but individual files that include `head.php` directly will use their own metadata.

---

## D) CI GUARDRAIL ENHANCED — IMPLEMENTED ✅

**File:** `scripts/ci_meta_guardrail.php`

**Enhancements:**
- Limits error output to first 50 errors
- Writes JSON artifact (`ci_meta_guardrail_report.json`) for PR diffing
- Still fails CI (exit code 1) when duplicates found

**Current Status:** ❌ **FAILS** — Still detecting duplicates in individual numbered files

**Next Step:** Update CI guardrail to check rendered output OR remove old metadata from individual files.

---

## E) TEMPLATES/HEAD.PHP UPDATED — IMPLEMENTED ✅

**File:** `templates/head.php`

**Change:** Added support for `$GLOBALS['__page_meta']` (ctx-based metadata)

**Priority Order:**
1. `$GLOBALS['__page_meta']` (ctx-based, from router)
2. `$GLOBALS['pageTitle']` + `$GLOBALS['pageDesc']` (legacy)
3. `meta_for_slug()` (fallback)

**Canonical Path:**
- Root `/` stays as `/` (no locale prefix)
- Other paths get locale prefix if missing

---

## F) VERIFICATION CHECKLIST

### 1. Root Behavior
- [ ] `curl -I https://nrlc.ai/` returns 200 (not 301 to /en-us/)
- [ ] `curl -I http://nrlc.ai/` returns 301 → `https://nrlc.ai/`
- [ ] `curl -I https://www.nrlc.ai/` returns 301 → `https://nrlc.ai/`

### 2. SSR Head Tags (View-Source)
Test URLs:
- [ ] `https://nrlc.ai/en-us/blog/blog-post-1/`
- [ ] `https://nrlc.ai/en-us/case-studies/case-study-1/`
- [ ] `https://nrlc.ai/en-us/resources/resource-1/`
- [ ] `https://nrlc.ai/en-us/tools/chatgpt/`
- [ ] `https://nrlc.ai/en-us/industries/healthcare/`

For each URL, verify:
- [ ] Unique `<title>` (not duplicate)
- [ ] Unique `<meta name="description">` (not duplicate)
- [ ] `<link rel="canonical">` is HTTPS and self-referencing
- [ ] `<meta property="og:url">` equals canonical exactly

### 3. CI Guardrail
- [ ] Run `php scripts/ci_meta_guardrail.php`
- [ ] Should pass (exit code 0) after all duplicates eliminated
- [ ] JSON artifact generated for tracking

### 4. Meta Uniqueness
- [ ] No duplicate titles across all pages
- [ ] No duplicate descriptions across all pages
- [ ] No duplicate first 8 words across all pages

---

## G) REMAINING ISSUES

### Issue 1: Individual Numbered Files
**Problem:** Files like `blog-post-1.php`, `case-study-1.php`, etc. include `head.php` directly and set their own metadata, bypassing router.

**Options:**
1. **Remove old metadata** from individual files (they'll use router metadata via `render_page()`)
2. **Update CI guardrail** to check rendered output instead of file contents
3. **Route individual files** through router instead of direct inclusion

**Recommendation:** Option 1 — Remove old metadata assignments from individual files since router metadata takes precedence when accessed via router.

### Issue 2: Tools Individual Files
**Problem:** Individual tool files (e.g., `pages/tools/chatgpt.php`) may include `head.php` directly.

**Status:** Router sets metadata for `/tools/{tool}/` routes, but individual files might bypass router.

---

## H) FILES MODIFIED

1. ✅ `bootstrap/canonical.php` — Root redirect fix, query param policy
2. ✅ `lib/meta_directive.php` — Added `sudo_meta_directive_ctx()`
3. ✅ `templates/head.php` — Added support for ctx-based metadata
4. ✅ `bootstrap/router.php` — Added ctx-based metadata for blog, case-studies, resources, tools, industries
5. ✅ `pages/blog/blog-post.php` — Removed placeholder metadata
6. ✅ `pages/case-studies/case-study.php` — Removed placeholder metadata
7. ✅ `pages/resources/resource.php` — Commented placeholder metadata
8. ✅ `pages/tools/tool.php` — Removed placeholder metadata
9. ✅ `pages/industries/industry.php` — Removed placeholder metadata
10. ✅ `scripts/ci_meta_guardrail.php` — Enhanced with JSON artifact output

---

## I) NEXT STEPS

1. **Verify root redirect** — Test with curl commands
2. **Test SSR output** — View-source 10 sample URLs
3. **Fix individual numbered files** — Remove old metadata or route through router
4. **Re-run CI guardrail** — Should pass after individual files fixed
5. **Monitor GSC** — Watch for CTR improvements on previously duplicate pages

---

## J) STOP CONDITIONS STATUS

- ✅ **Root "/" no longer redirects to "/en-us/"** — Fixed in code
- ⚠️ **Template pages still emit duplicates** — Router metadata works, but individual files need cleanup
- ✅ **Canonical == og:url** — Verified in code (same variable)
- ✅ **All canonicals are HTTPS** — Verified in code
- ⚠️ **CI guardrail still fails** — Due to individual numbered files with old metadata

---

**END OF PATCH KERNEL REPORT**

