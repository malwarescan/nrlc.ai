# High Impression, Zero CTR URL Analysis

**Date:** 2025-01-27  
**Issue:** 45 URLs with high impressions but 0% CTR  
**Priority:** P0 - Critical SEO Issue

---

## 🔴 CRITICAL ISSUE #1: UK Cities with Wrong Locales

**Problem:** UK cities are being served with wrong locales (en-us, fr-fr, es-es, de-de, ko-kr) instead of en-gb.

**Impact:** UK users searching for these cities see pages in wrong language/locale, causing 0% CTR.

### URLs with Wrong Locales:

#### UK Cities with en-us (Should be en-gb):
1. ❌ `https://nrlc.ai/en-us/services/local-seo-ai/norwich/` → Should be `/en-gb/...`
2. ❌ `https://nrlc.ai/en-us/services/ai-seo-norwich/` → Invalid service slug? Should be `/en-gb/services/.../norwich/`
3. ❌ `https://nrlc.ai/en-us/services/semantic-seo-ai/stoke-on-trent/` → Should be `/en-gb/...`
4. ❌ `https://nrlc.ai/en-us/services/chatgpt-optimization/southport/` → Should be `/en-gb/...`
5. ❌ `https://nrlc.ai/en-us/services/voice-search-optimization/derby/` → Should be `/en-gb/...`
6. ❌ `https://nrlc.ai/en-us/services/link-building-ai/southampton/` → Should be `/en-gb/...`
7. ❌ `https://nrlc.ai/en-us/services/ranking-optimization-ai/huddersfield/` → Should be `/en-gb/...`
8. ❌ `https://nrlc.ai/en-us/services/verification-optimization-ai/blackpool/` → Should be `/en-gb/...`
9. ❌ `https://nrlc.ai/en-us/services/llm-content-strategy/norwich/` → Should be `/en-gb/...`
10. ❌ `https://nrlc.ai/en-us/services/completeness-optimization-ai/stoke-on-trent/` → Should be `/en-gb/...`
11. ❌ `https://nrlc.ai/en-us/services/generative-seo/halifax/` → Should be `/en-gb/...`
12. ❌ `https://nrlc.ai/en-us/services/mobile-seo-ai/jacksonville/` → Jacksonville is US, but check if this is correct
13. ❌ `https://nrlc.ai/en-us/services/site-audits/southport/` → Should be `/en-gb/...`
14. ❌ `https://nrlc.ai/en-us/services/generative-seo/southport/` → Should be `/en-gb/...`
15. ❌ `https://nrlc.ai/en-us/services/technical-seo/nottingham/` → Should be `/en-gb/...`
16. ❌ `https://nrlc.ai/en-us/services/ai-search-optimization/oldham/` → Should be `/en-gb/...`
17. ❌ `https://nrlc.ai/en-us/services/bard-optimization/huddersfield/` → Should be `/en-gb/...`
18. ❌ `https://nrlc.ai/en-us/services/claude-optimization/victoria/` → Victoria could be UK or Canada - need to check
19. ❌ `https://nrlc.ai/en-us/services/analytics/burnley/` → Should be `/en-gb/...`

#### UK Cities with fr-fr (Should be en-gb):
20. ❌ `https://nrlc.ai/fr-fr/services/conversion-optimization-ai/stockport/` → Should be `/en-gb/...`
21. ❌ `https://nrlc.ai/fr-fr/services/local-seo-ai/sudbury/` → Sudbury could be UK or Canada - need to check
22. ❌ `https://nrlc.ai/fr-fr/services/generative-seo/southend-on-sea/` → Should be `/en-gb/...`

#### UK Cities with es-es (Should be en-gb):
23. ❌ `https://nrlc.ai/es-es/services/international-seo/blackpool/` → Should be `/en-gb/...`
24. ❌ `https://nrlc.ai/es-es/services/contextual-seo-ai/huddersfield/` → Should be `/en-gb/...`

#### UK Cities with de-de (Should be en-gb):
25. ❌ `https://nrlc.ai/de-de/services/voice-search-optimization/sheffield/` → Should be `/en-gb/...`
26. ❌ `https://nrlc.ai/de-de/services/mobile-seo-ai/singapore/` → Singapore should be en-sg, not de-de
27. ❌ `https://nrlc.ai/de-de/services/relevance-optimization-ai/stockport/` → Should be `/en-gb/...`

#### UK Cities with ko-kr (Should be en-gb):
28. ❌ `https://nrlc.ai/ko-kr/services/multimodal-seo-ai/burnley/` → Should be `/en-gb/...`
29. ❌ `https://nrlc.ai/ko-kr/services/site-audits/belfast/` → Should be `/en-gb/...`
30. ❌ `https://nrlc.ai/ko-kr/services/local-seo-ai/oldham/` → Should be `/en-gb/...`
31. ❌ `https://nrlc.ai/ko-kr/services/llm-optimization/northampton/` → Should be `/en-gb/...`

---

## 🔴 CRITICAL ISSUE #2: Singapore with Wrong Locales

**Problem:** Singapore is being served with wrong locales instead of en-sg.

32. ❌ `https://nrlc.ai/de-de/services/mobile-seo-ai/singapore/` → Should be `/en-sg/...`
33. ❌ `https://nrlc.ai/services/generative-seo/singapore/` → Missing locale, should be `/en-sg/...`
34. ❌ `https://nrlc.ai/en-us/services/ai-search-optimization/singapore/` → Should be `/en-sg/...`

---

## 🔴 CRITICAL ISSUE #3: Missing Locale Prefix

**Problem:** URLs missing locale prefix entirely.

35. ❌ `https://nrlc.ai/services/generative-seo/singapore/` → Should be `/en-sg/services/...`
36. ❌ `https://nrlc.ai/insights/open-seo-tools/` → Should be `/en-us/insights/...`
37. ❌ `http://nrlc.ai/insights/open-seo-tools/` → HTTP (not HTTPS) + missing locale

---

## 🔴 CRITICAL ISSUE #4: Invalid Service Slugs

**Problem:** Invalid or non-existent service slugs.

38. ❌ `https://nrlc.ai/en-us/services/ai-seo-norwich/` → "ai-seo-norwich" is not a valid service slug
   - Should be: `/en-gb/services/{valid-service}/norwich/`

---

## ⚠️ ISSUE #5: Insights Pages

**Problem:** Insights pages may be missing recent improvements.

39. ❌ `https://nrlc.ai/en-us/insights/open-seo-tools/`
40. ❌ `https://nrlc.ai/insights/open-seo-tools/`
41. ❌ `http://nrlc.ai/insights/open-seo-tools/`
42. ❌ `https://nrlc.ai/en-us/insights/silent-hydration-seo/`

---

## ⚠️ ISSUE #6: Training Pages

**Problem:** Training pages may need updates.

43. ❌ `https://nrlc.ai/en-us/services/training/cardiff/` → Cardiff is UK, should be `/en-gb/...`

---

## ⚠️ ISSUE #7: Non-Service Pages

44. ❌ `https://nrlc.ai/` → Homepage (may need verification)
45. ❌ `https://nrlc.ai/en-us/generative-engine-optimization/decision-traces/` → Non-standard path

---

## 📊 SUMMARY BY ISSUE TYPE

| Issue Type | Count | Priority |
|------------|-------|----------|
| UK cities with wrong locale (en-us) | 19 | P0 |
| UK cities with wrong locale (fr-fr) | 3 | P0 |
| UK cities with wrong locale (es-es) | 2 | P0 |
| UK cities with wrong locale (de-de) | 3 | P0 |
| UK cities with wrong locale (ko-kr) | 4 | P0 |
| Singapore with wrong locale | 3 | P0 |
| Missing locale prefix | 3 | P0 |
| Invalid service slug | 1 | P0 |
| Insights pages | 4 | P1 |
| Training pages | 1 | P1 |
| Other | 2 | P1 |

**Total:** 45 URLs

---

## 🎯 ROOT CAUSE ANALYSIS

### Why Zero CTR?

1. **Locale Mismatch:** UK users searching for "SEO Norwich" see `/en-us/` page → Wrong language expectations → No click
2. **Wrong Language:** French/German/Spanish/Korean pages for UK cities → Users don't understand → No click
3. **Missing Locale:** Pages without locale prefix → Google may not understand target audience → Lower ranking
4. **Invalid URLs:** Broken service slugs → 404 or wrong content → No click
5. **HTTP vs HTTPS:** HTTP URLs → Security warnings → No click

### Why High Impressions?

- Google is indexing these pages (they exist)
- Pages match search queries (city + service)
- But users don't click because:
  - Wrong locale/language
  - Wrong expectations
  - Broken URLs

---

## ✅ FIXES NEEDED

### P0 (Critical - Fix Immediately):

1. **Implement Locale Redirects for UK Cities**
   - All UK cities → Redirect to `/en-gb/` canonical
   - Update `bootstrap/canonical.php` to enforce this

2. **Implement Locale Redirects for Singapore**
   - Singapore → Redirect to `/en-sg/` canonical

3. **Fix Missing Locale Prefixes**
   - Add locale prefix to all URLs
   - Redirect non-locale URLs to locale-prefixed versions

4. **Fix Invalid Service Slugs**
   - Remove or redirect invalid service slugs
   - Ensure all service slugs are valid

5. **HTTP → HTTPS Redirects**
   - Ensure all HTTP URLs redirect to HTTPS

### P1 (High Priority):

6. **Update Insights Pages**
   - Add definition locks
   - Add proper CTAs
   - Ensure proper structure

7. **Update Training Pages**
   - Ensure locale correctness
   - Add proper structure

---

## 🔧 IMPLEMENTATION PLAN

### Step 1: Verify Canonical Redirects Are Working
- Check `bootstrap/canonical.php` has UK city → en-gb redirects
- Check Singapore → en-sg redirects
- Test redirects are actually happening

### Step 2: Fix Missing Locale Prefixes
- Update router to always require locale prefix
- Add redirects for non-locale URLs

### Step 3: Fix Invalid Service Slugs
- Remove or redirect invalid slugs
- Add validation

### Step 4: Verify All Pages Have Recent Improvements
- Definition locks
- CTAs
- Proper structure

---

## 📝 NEXT STEPS

1. Verify canonical redirects are working
2. Test a sample of URLs to confirm redirects
3. Fix any missing redirects
4. Update insights/training pages if needed
5. Monitor GSC for improved CTR after fixes
