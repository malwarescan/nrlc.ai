# BOOKING API REMOVAL — AI VISIBILITY PAGES

**Date:** 2025-01-XX  
**Issue:** Buttons with "Request Your AI Visibility Audit" were linking to `/api/book/` instead of opening contact modal  
**Status:** ✅ FIXED

---

## FIXES APPLIED

### 1. `pages/ai-visibility/audit-example.php` (Line 149)
**Before:**
```php
<a href="/api/book/" class="btn" data-ripple>Request Your AI Visibility Audit</a>
```

**After:**
```php
<button type="button" class="btn" onclick="openContactSheet('Request Your AI Visibility Audit')" data-ripple>Request Your AI Visibility Audit</button>
```

---

### 2. `pages/ai-visibility/industry.php` (Line 110-111)
**Before:**
```php
<a href="/api/book/" class="btn" data-ripple>See How AI Describes Your Firm</a>
<a href="/api/book/" class="btn btn--secondary" data-ripple>Request an AI Visibility Audit</a>
```

**After:**
```php
<button type="button" class="btn" onclick="openContactSheet('See How AI Describes Your Firm')" data-ripple>See How AI Describes Your Firm</button>
<button type="button" class="btn btn--secondary" onclick="openContactSheet('Request an AI Visibility Audit')" data-ripple>Request an AI Visibility Audit</button>
```

---

### 3. `pages/ai-visibility/industry.php` (Line 229)
**Before:**
```php
<a href="/api/book/" class="btn" data-ripple>Request Your AI Visibility Audit</a>
```

**After:**
```php
<button type="button" class="btn" onclick="openContactSheet('Request Your AI Visibility Audit')" data-ripple>Request Your AI Visibility Audit</button>
```

---

## VERIFICATION

✅ **All AI Visibility pages now use `openContactSheet()`**  
✅ **No `/api/book/` links remain in AI Visibility pages**  
✅ **Syntax validated — no PHP errors**

---

## REMAINING `/api/book/` LINKS (Non-Critical)

The following pages still have `/api/book/` links but are **NOT** AI Visibility audit pages:
- `pages/insights/*.php` (11 files) — Research/insight pages
- These are lower priority and can be fixed separately

**AI Visibility pages are now 100% compliant.**

---

## GOVERNANCE ENFORCEMENT

**Rule:** All audit/contact CTAs must use `openContactSheet()`, NOT direct links to `/api/book/`

**Exception:** The `/api/book/` endpoint is still functional for POST requests (form submissions), but GET requests are blocked (403 Forbidden).

---

**STATUS: AI VISIBILITY PAGES FIXED ✅**

