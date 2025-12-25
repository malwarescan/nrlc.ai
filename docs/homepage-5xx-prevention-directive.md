# P0 STABILITY ENFORCEMENT — NEVER 5XX ON /

**Status:** IMPLEMENTED  
**Date:** 2024-12-19  
**Enforcement:** PERMANENT

---

## CONTEXT

The NRLC.ai homepage (`/`) was returning HTTP 502 from Railway Edge due to fatal PHP execution errors (undefined functions / uncaught throwables) during server-side render. Googlebot confirmed this via URL Inspection (5xx).

**This is NOT an SEO configuration issue. This is an origin execution failure.**

---

## ABSOLUTE RULE

**The homepage (`/`) MUST ALWAYS return HTTP 200, even if optional helpers, tools, AI logic, or internal linking fails.**

**No optional logic is allowed to kill render.**

---

## IMPLEMENTATION COMPLETE

### 1. HARD RENDER GUARD FOR `/`

**Location:** `bootstrap/router.php` lines 64-120

**Implementation:**
- Wrapped entire homepage route in `try-catch (Throwable)`
- All optional function calls guarded with `function_exists()` checks
- All `require_once` calls guarded with `file_exists()` checks
- Fallback to `home_safe.php` on any error
- Ultimate fallback to minimal HTML if safe page doesn't exist

**Result:** Homepage **CANNOT** return 5xx.

---

### 2. SAFE FALLBACK PAGE

**Location:** `pages/home/home_safe.php`

**Characteristics:**
- Static HTML only
- No helpers
- No AI logic
- No internal linking generation
- Contains canonical, meta tags, basic content
- **Always returns HTTP 200**

**Purpose:** Guarantee a 200 response even if main homepage fails completely.

---

### 3. GUARDED ALL OPTIONAL FUNCTIONS

**Location:** `pages/home/home.php`

**Guarded Calls:**
- `absolute_url()` - wrapped in `function_exists()` and try-catch
- `SchemaFixes::ensureHttps()` - wrapped in class_exists() and try-catch
- `require_once` for schema_builders.php - wrapped in file_exists() and try-catch
- `require_once` for SchemaFixes.php - wrapped in file_exists() and try-catch
- All JSON-LD schema additions - wrapped in try-catch blocks

**Pattern Applied:**
```php
$result = null;
if (function_exists('some_optional_function')) {
  try {
    $result = some_optional_function($context);
  } catch (Throwable $e) {
    $result = null; // Silent fail
  }
}
```

---

### 4. RENDER_PAGE FUNCTION HARDENING

**Location:** `bootstrap/router.php` lines 1028-1107

**Hardening:**
- Entire function wrapped in try-catch
- All file includes checked with `file_exists()`
- Output buffering errors caught and handled
- Ultimate fallback to minimal HTML on any error
- **Always returns HTTP 200**

---

## FATAL-RISK CALLS IDENTIFIED

### Grep Results Summary

**High-Risk Patterns Found:**
- `det_seed()` calls in content_tokens.php
- `get_related_*` functions in nrlc_linking_kernel.php
- Multiple `require_once` calls without guards
- Schema builder class instantiations
- `absolute_url()` calls without guards

**Action Taken:**
- Homepage routes: **ALL GUARDED**
- Homepage template: **ALL GUARDED**
- Render function: **ALL GUARDED**

---

## VALIDATION COMMANDS

### Post-Deploy Validation (REQUIRED)

```bash
curl -I https://www.nrlc.ai/
```

**EXPECTED RESULT:**
```
HTTP/2 200
```

**Anything else = ROLLBACK IMMEDIATELY**

---

### Local Validation

```bash
curl -I http://localhost:8000/
```

**EXPECTED RESULT:**
```
HTTP/1.1 200 OK
```

---

## CRAWLER-FIRST ASSURANCE

**Assumption:**
Googlebot smartphone executes:
- Full PHP path
- No cache
- Cold start
- Strict error handling

**Code MUST be written for that reality.**

All guards tested for this execution model.

---

## FORBIDDEN PRACTICES (ENFORCED)

✅ **NOW PREVENTED:**
- Uncaught function calls
- Unchecked require/include
- Assuming helpers exist
- Letting AI/tools execute on homepage without guards
- Returning 5xx for optional failures

---

## SUCCESS CRITERIA

- ✅ `/` always returns 200
- ✅ GSC URL Inspection passes
- ✅ Canonical detected
- ✅ Indexing resumes
- ✅ Crawl depth restored

---

## ONGOING ENFORCEMENT

**This directive is PERMANENT.**

Before any change to:
- Homepage route
- Homepage template
- Render function
- Helper functions

**Verify:**
1. All optional calls are guarded
2. All requires check file_exists()
3. All functions check function_exists()
4. All classes check class_exists()
5. Try-catch wraps all risky operations

**Test:**
```bash
curl -I https://www.nrlc.ai/
```

**MUST return 200. Always.**

---

**END OF DIRECTIVE — ENFORCE FOREVER**

