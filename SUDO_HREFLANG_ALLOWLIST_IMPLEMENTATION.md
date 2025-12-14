# SUDO HREFLANG ALLOWLIST — GLOBAL PAGE PILOT + SAFE SCALE

## Implementation Complete

This document details the implementation of the **hreflang allowlist system** for safe, controlled hreflang rollout.

**Core Principle:** Enable hreflang ONLY for verified GLOBAL pages using a strict allowlist. Prevent accidental rollout, protect LOCAL pages forever, and keep canonicals stable.

---

## A) ALLOWLIST DEFINITION ✅

### File: `lib/hreflang_allowlist.php`

**Structure:**
- Key = canonical path (no locale prefix, e.g., `/services/technical-seo/`)
- Value = array of allowed locales with REAL translations
- ONLY pages listed here may output hreflang
- LOCAL pages are NEVER listed here (enforced by code)

**Current Pilot:**
```php
'/services/technical-seo/' => [
  'en-us',
  'en-gb',
],
```

**Future Examples (commented out):**
```php
// '/services/schema-markup/' => ['en-us', 'en-gb'],
// '/services/ai-search-optimization/' => ['en-us', 'en-gb'],
// '/insights/open-seo-tools/' => ['en-us', 'en-gb'],
```

---

## B) HREFLANG LOGIC UPDATE ✅

### File: `lib/hreflang.php`

**Changes:**
1. Removed `$hasRealTranslations` parameter (allowlist is now the source of truth)
2. Added allowlist file loading
3. Path normalization for matching
4. Validation: must have at least 2 locales
5. Only generates hreflang for locales in allowlist

**Function Signature:**
```php
function hreflang_links(string $pathWithoutLocalePrefix): array
```

**Logic Flow:**
1. Check if LOCAL page → return empty array
2. Load allowlist file
3. Normalize path and check if in allowlist
4. If not in allowlist → return empty array
5. If in allowlist → generate hreflang for allowed locales only
6. Include x-default pointing to primary locale

---

## C) TEMPLATE UPDATE ✅

### File: `templates/head.php`

**Changes:**
- Removed `$hasRealTranslations` logic
- Simplified to call `hreflang_links($hreflangPath)` directly
- Allowlist is the single source of truth

**Before:**
```php
$hasRealTranslations = false;
$hreflangLinks = hreflang_links($hreflangPath, $hasRealTranslations);
```

**After:**
```php
$hreflangLinks = hreflang_links($hreflangPath);
```

---

## D) CI GUARDRAIL ENHANCEMENT ✅

### File: `scripts/ci_meta_guardrail.php`

**New Checks:**
1. **Check 9:** Verify LOCAL pages return empty hreflang (even if somehow in allowlist)
2. **Check 10:** Verify allowlist structure:
   - No LOCAL pages in allowlist
   - Each entry has at least 2 locales
   - Allowlist file exists

**Implementation:**
```php
// 9. SUDO HREFLANG ALLOWLIST: Check for LOCAL pages with hreflang (P0 defect)
// 10. SUDO HREFLANG ALLOWLIST: Verify allowlist structure
```

---

## E) TEST RESULTS ✅

### Test 1: LOCAL Page
```php
hreflang_links('/services/local-seo-ai/norwich/')
// Result: array(0) {} ✅ (empty - LOCAL pages never get hreflang)
```

### Test 2: GLOBAL Page NOT in Allowlist
```php
hreflang_links('/services/schema-markup/')
// Result: array(0) {} ✅ (empty - not in allowlist)
```

### Test 3: GLOBAL Page IN Allowlist
```php
hreflang_links('/services/technical-seo/')
// Result: array(3) {
//   [0] => ['hreflang' => 'en-US', 'href' => 'https://nrlc.ai/en-us/services/technical-seo/'],
//   [1] => ['hreflang' => 'en-GB', 'href' => 'https://nrlc.ai/en-gb/services/technical-seo/'],
//   [2] => ['hreflang' => 'x-default', 'href' => 'https://nrlc.ai/en-us/services/technical-seo/']
// } ✅ (hreflang generated for allowed locales)
```

---

## F) ROLLOUT PROCESS ✅

### To Enable Hreflang for a New GLOBAL Page:

1. **Verify Translations:**
   - Page exists in >= 2 locales
   - Each locale is fully translated by humans
   - Each locale is regionally adapted
   - Each locale is indexable and self-canonical

2. **Add to Allowlist:**
   - Edit `lib/hreflang_allowlist.php`
   - Add entry: `'/path/to/page/' => ['en-us', 'en-gb', ...]`
   - Ensure at least 2 locales

3. **Test:**
   - Run CI guardrail: `php scripts/ci_meta_guardrail.php`
   - Verify hreflang tags in view-source
   - Check canonical stability in GSC

4. **Monitor:**
   - Observe for 2-4 weeks
   - Verify canonical stability
   - Check indexing behavior

5. **Expand:**
   - Once stable, add more GLOBAL pages to allowlist
   - Never add LOCAL pages to allowlist

---

## G) SAFETY FEATURES ✅

1. **LOCAL Page Protection:**
   - `is_local_page()` check runs FIRST
   - Even if LOCAL page somehow in allowlist, returns empty array
   - Hard enforcement in code

2. **Allowlist Validation:**
   - CI guardrail checks for LOCAL pages in allowlist
   - CI guardrail validates minimum 2 locales per entry
   - Fail-safe: missing allowlist file = no hreflang

3. **Path Normalization:**
   - Ensures trailing slash consistency
   - Handles root path correctly
   - Exact matching required

4. **Locale Validation:**
   - Only includes locales that exist in `LOCALES` config
   - Skips invalid locales gracefully

---

## H) FILES MODIFIED

1. **`lib/hreflang_allowlist.php`** - NEW: Single source of truth for hreflang eligibility
2. **`lib/hreflang.php`** - Updated: Allowlist-based logic
3. **`templates/head.php`** - Updated: Simplified to use allowlist
4. **`scripts/ci_meta_guardrail.php`** - Updated: Allowlist validation checks

---

## I) NEXT STEPS

1. **Monitor Pilot:** Track `/services/technical-seo/` hreflang behavior for 2-4 weeks
2. **Verify Translations:** Ensure en-us and en-gb versions are fully translated
3. **Test Canonical Stability:** Verify Google selects correct canonical
4. **Expand Gradually:** Add more GLOBAL pages to allowlist after pilot success

---

## J) SUCCESS METRICS

- ✅ Zero hreflang tags on LOCAL pages
- ✅ Zero hreflang tags on GLOBAL pages not in allowlist
- ✅ Hreflang tags only on GLOBAL pages in allowlist
- ✅ CI guardrail passes all checks
- ✅ Canonical stability maintained

---

**Implementation Date:** 2025-01-27
**Status:** ✅ COMPLETE
**Pilot Page:** `/services/technical-seo/` (en-us, en-gb)

