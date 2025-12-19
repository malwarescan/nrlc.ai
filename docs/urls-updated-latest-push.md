# URLs UPDATED IN LATEST PUSH

**Commit:** `6cb7e0e` - "Norwich page conversion upgrade + Booking endpoint security fixes"  
**Date:** 2025-01-XX

---

## CONVERSION UPGRADE (CONTENT-ONLY)

### 1. Norwich AI SEO Page
**URL:** `https://nrlc.ai/en-gb/services/ai-seo-norwich/`  
**Changes:**
- ✅ Added proof & authority section (`id="norwich-proof"`)
  - H2: "Why Norwich Companies Trust Us With High-Value Search Visibility"
  - Pain + Trust Gap paragraph
  - Differentiation paragraph
  - H3: "Recent Work With Norwich-Area Businesses"
  - 2 anonymized case studies:
    - Norwich-Based Professional Services Firm
    - Norwich-Based B2B Company With National Reach
  - Proof disclaimer
  - H3: "Why This Matters If You're Competing in Norwich"
  - Market framing paragraphs
  - CTA block: "See Why Google Chooses Your Competitors Instead" → `/en-us/services/ai-search-optimization/`
- ✅ No schema changes
- ✅ No geo expansion
- ✅ No URL changes

---

## BOOKING ENDPOINT SECURITY FIXES (QA REMEDIATION)

### 2. Homepage
**URL:** `https://nrlc.ai/en-us/`  
**Changes:**
- ✅ Removed direct `/api/book/` link
- ✅ CTA now uses `openContactSheet('Free AI Visibility Audit (US & UK)')`
- ✅ Button text unchanged: "Free AI Visibility Audit (US & UK)"

---

### 3. AI Search Optimization Service Page
**URL:** `https://nrlc.ai/en-us/services/ai-search-optimization/`  
**Changes:**
- ✅ Removed direct `/api/book/` link
- ✅ CTA now uses `openContactSheet('Get a Free AI Visibility Audit')`
- ✅ Button text unchanged: "Get a Free AI Visibility Audit"
- ✅ Subtext unchanged: "See how your site appears in Google AI Overviews and ChatGPT"

---

### 4. AI Visibility Hub Page
**URL:** `https://nrlc.ai/en-us/ai-visibility/`  
**Changes:**
- ✅ Removed 2 direct `/api/book/` links
- ✅ CTAs now use `openContactSheet()`:
  - "Request AI Visibility Audit" → `openContactSheet('Request AI Visibility Audit')`
  - "See How AI Describes Your Business" → `openContactSheet('See How AI Describes Your Business')`
- ✅ Button text unchanged

---

## ENDPOINT SECURITY

### 5. API Booking Endpoint
**URL:** `https://nrlc.ai/api/book/`  
**Changes:**
- ✅ GET requests now return 403 Forbidden (JSON error response)
- ✅ POST requests still work (form submissions)
- ✅ Removed from sitemap
- ✅ Blocked in robots.txt (`Disallow: /api/`)

---

## INFRASTRUCTURE UPDATES

### 6. Sitemap
**URL:** `https://nrlc.ai/sitemaps/ai-visibility-1.xml.gz`  
**Changes:**
- ✅ Removed `/api/book/` from index pages sitemap
- ✅ Norwich page still included (from previous push)

### 7. Robots.txt
**URL:** `https://nrlc.ai/robots.txt`  
**Changes:**
- ✅ Added `Disallow: /api/` to block all API endpoints

---

## SUMMARY

**Total URLs Updated:** 5 pages + 1 endpoint + infrastructure  
**Conversion Upgrades:** 1 page (Norwich)  
**Security Fixes:** 4 Tier 1 pages + 1 endpoint  
**Infrastructure:** 2 files (sitemap, robots.txt)

---

## TIER 1 PAGES STATUS

✅ **Homepage** - Booking endpoint removed, CTA uses `openContactSheet()`  
✅ **AI Search Optimization** - Booking endpoint removed, CTA uses `openContactSheet()`  
✅ **Norwich Page** - Conversion upgrade added (proof section) + CTA uses `openContactSheet()`  
✅ **AI Visibility Hub** - Booking endpoints removed, CTAs use `openContactSheet()`

**All Tier 1 pages compliant with governance rules.**  
**All booking endpoint violations remediated.**

