# Live URL Test Plan

**Date:** 2025-01-27  
**Purpose:** Verify all fixes for high-impression zero-CTR URLs  
**Status:** Ready for deployment testing

---

## 🧪 TEST CATEGORY 1: HTTP Redirects (301 Status Codes)

### Test 1.1: UK City with Wrong Locale (en-us → en-gb)
**URL:** `https://nrlc.ai/en-us/services/local-seo-ai/norwich/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-gb/services/local-seo-ai/norwich/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-gb/services/local-seo-ai/norwich/`
- [ ] No redirect chain (single redirect)

**Additional Test URLs:**
- `https://nrlc.ai/en-us/services/semantic-seo-ai/stoke-on-trent/` → `/en-gb/services/semantic-seo-ai/stoke-on-trent/`
- `https://nrlc.ai/en-us/services/chatgpt-optimization/southport/` → `/en-gb/services/chatgpt-optimization/southport/`
- `https://nrlc.ai/en-us/services/voice-search-optimization/derby/` → `/en-gb/services/voice-search-optimization/derby/`
- `https://nrlc.ai/en-us/services/link-building-ai/southampton/` → `/en-gb/services/link-building-ai/southampton/`
- `https://nrlc.ai/en-us/services/generative-seo/halifax/` → `/en-gb/services/generative-seo/halifax/`
- `https://nrlc.ai/en-us/services/technical-seo/nottingham/` → `/en-gb/services/technical-seo/nottingham/`

### Test 1.2: UK City with Wrong Locale (fr-fr → en-gb)
**URL:** `https://nrlc.ai/fr-fr/services/conversion-optimization-ai/stockport/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-gb/services/conversion-optimization-ai/stockport/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-gb/services/conversion-optimization-ai/stockport/`

**Additional Test URLs:**
- `https://nrlc.ai/fr-fr/services/local-seo-ai/sudbury/` → `/en-gb/services/local-seo-ai/sudbury/` (if Sudbury is UK)
- `https://nrlc.ai/fr-fr/services/generative-seo/southend-on-sea/` → `/en-gb/services/generative-seo/southend-on-sea/`

### Test 1.3: UK City with Wrong Locale (es-es → en-gb)
**URL:** `https://nrlc.ai/es-es/services/international-seo/blackpool/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-gb/services/international-seo/blackpool/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-gb/services/international-seo/blackpool/`

**Additional Test URLs:**
- `https://nrlc.ai/es-es/services/contextual-seo-ai/huddersfield/` → `/en-gb/services/contextual-seo-ai/huddersfield/`

### Test 1.4: UK City with Wrong Locale (de-de → en-gb)
**URL:** `https://nrlc.ai/de-de/services/voice-search-optimization/sheffield/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-gb/services/voice-search-optimization/sheffield/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-gb/services/voice-search-optimization/sheffield/`

**Additional Test URLs:**
- `https://nrlc.ai/de-de/services/relevance-optimization-ai/stockport/` → `/en-gb/services/relevance-optimization-ai/stockport/`

### Test 1.5: UK City with Wrong Locale (ko-kr → en-gb)
**URL:** `https://nrlc.ai/ko-kr/services/multimodal-seo-ai/burnley/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-gb/services/multimodal-seo-ai/burnley/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-gb/services/multimodal-seo-ai/burnley/`

**Additional Test URLs:**
- `https://nrlc.ai/ko-kr/services/site-audits/belfast/` → `/en-gb/services/site-audits/belfast/`
- `https://nrlc.ai/ko-kr/services/local-seo-ai/oldham/` → `/en-gb/services/local-seo-ai/oldham/`
- `https://nrlc.ai/ko-kr/services/llm-optimization/northampton/` → `/en-gb/services/llm-optimization/northampton/`

### Test 1.6: Singapore with Wrong Locale (de-de → en-sg)
**URL:** `https://nrlc.ai/de-de/services/mobile-seo-ai/singapore/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-sg/services/mobile-seo-ai/singapore/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-sg/services/mobile-seo-ai/singapore/`

**Additional Test URLs:**
- `https://nrlc.ai/en-us/services/ai-search-optimization/singapore/` → `/en-sg/services/ai-search-optimization/singapore/`

### Test 1.7: Missing Locale Prefix (Service+City)
**URL:** `https://nrlc.ai/services/generative-seo/singapore/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-sg/services/generative-seo/singapore/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-sg/services/generative-seo/singapore/`
- [ ] City detection works correctly

**Additional Test URLs:**
- `https://nrlc.ai/services/generative-seo/halifax/` → `/en-gb/services/generative-seo/halifax/` (UK city)
- `https://nrlc.ai/services/link-building-ai/norwich/` → `/en-gb/services/link-building-ai/norwich/` (UK city)

### Test 1.8: Missing Locale Prefix (Insights)
**URL:** `https://nrlc.ai/insights/open-seo-tools/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-us/insights/open-seo-tools/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-us/insights/open-seo-tools/`

**Additional Test URLs:**
- `http://nrlc.ai/insights/open-seo-tools/` → Should also redirect to HTTPS + locale

### Test 1.9: Invalid Service Slug
**URL:** `https://nrlc.ai/en-us/services/ai-seo-norwich/`  
**Expected:** 301 redirect to `https://nrlc.ai/en-gb/services/ai-search-optimization/norwich/`  
**Verify:**
- [ ] HTTP status code: 301
- [ ] Location header: `/en-gb/services/ai-search-optimization/norwich/`
- [ ] Locale detection works (Norwich → en-gb)

---

## 🧪 TEST CATEGORY 2: Page Rendering After Redirects

### Test 2.1: UK City Page Content (After Redirect)
**URL:** `https://nrlc.ai/en-gb/services/local-seo-ai/norwich/` (final destination)  
**Verify:**
- [ ] Page loads (HTTP 200)
- [ ] H1 is present and correct
- [ ] Definition lock appears (orange box after H1)
- [ ] Trust signals in hero section
- [ ] 3 mid-page CTAs present (blue, orange, green)
- [ ] Process section properly separated
- [ ] Related services in card layout
- [ ] Bottom CTA present
- [ ] No JavaScript errors in console
- [ ] No broken images
- [ ] Content is locale-appropriate (UK spelling: "optimisation" not "optimization")

### Test 2.2: Singapore Page Content (After Redirect)
**URL:** `https://nrlc.ai/en-sg/services/mobile-seo-ai/singapore/` (final destination)  
**Verify:**
- [ ] Page loads (HTTP 200)
- [ ] All content features present (same as Test 2.1)
- [ ] Content is Singapore-appropriate

### Test 2.3: Insights Page Content (After Redirect)
**URL:** `https://nrlc.ai/en-us/insights/open-seo-tools/` (final destination)  
**Verify:**
- [ ] Page loads (HTTP 200)
- [ ] Content is properly formatted
- [ ] No broken links
- [ ] Schema markup present

---

## 🧪 TEST CATEGORY 3: Content Generation with Live Data

### Test 3.1: Service-City Page Content Generation
**URL:** `https://nrlc.ai/en-gb/services/generative-seo/liverpool/`  
**Verify:**
- [ ] Service name is correctly capitalized ("Generative SEO" not "Generative seo")
- [ ] City name is correctly formatted ("Liverpool" not "liverpool")
- [ ] Service overview section is populated
- [ ] Why Choose Us section is populated
- [ ] Process section has approach blocks + step-by-step
- [ ] Pricing section is populated
- [ ] FAQs are present (6 FAQs)
- [ ] Service area coverage section is populated
- [ ] Related services are populated
- [ ] All content is city-specific (mentions Liverpool)

### Test 3.2: Service-City Page with Missing Data
**URL:** `https://nrlc.ai/en-us/services/generative-seo/chicago/`  
**Verify:**
- [ ] Page still loads (no 500 error)
- [ ] Fallback content is displayed
- [ ] No fatal errors in logs
- [ ] Page is still functional

### Test 3.3: Service-City Page with Invalid Service Slug (After Redirect)
**URL:** `https://nrlc.ai/en-gb/services/ai-search-optimization/norwich/` (after redirect from ai-seo-norwich)  
**Verify:**
- [ ] Page loads correctly
- [ ] Content is for "AI Search Optimization" service
- [ ] City is Norwich
- [ ] All content sections are populated

---

## 🧪 TEST CATEGORY 4: Schema Validation on Live URLs

### Test 4.1: Service Schema Validation
**URL:** `https://nrlc.ai/en-gb/services/generative-seo/liverpool/`  
**Verify with Google Rich Results Test:**
- [ ] Service schema is valid
- [ ] Service schema has `description` field
- [ ] Service schema has `areaServed` with correct city
- [ ] Service schema has `provider` (Organization)
- [ ] No schema errors

### Test 4.2: FAQPage Schema Validation
**URL:** `https://nrlc.ai/en-gb/services/generative-seo/liverpool/`  
**Verify with Google Rich Results Test:**
- [ ] FAQPage schema is valid
- [ ] FAQPage has `@id` field
- [ ] FAQPage has `mainEntity` with 6 FAQs
- [ ] Each FAQ has `question` and `answer`
- [ ] No schema errors

### Test 4.3: DefinedTerm Schema Validation
**URL:** `https://nrlc.ai/en-gb/services/generative-seo/liverpool/`  
**Verify with Google Rich Results Test:**
- [ ] DefinedTerm schema is present (in definition lock)
- [ ] DefinedTerm has `name` field
- [ ] DefinedTerm has `description` field
- [ ] No schema errors

### Test 4.4: Organization Schema Validation
**URL:** `https://nrlc.ai/en-gb/services/generative-seo/liverpool/`  
**Verify with Google Rich Results Test:**
- [ ] Organization schema is valid
- [ ] Organization schema does NOT have invalid `offers` field
- [ ] Organization has required fields (name, url, logo)
- [ ] No schema errors

### Test 4.5: BreadcrumbList Schema Validation
**URL:** `https://nrlc.ai/en-gb/services/generative-seo/liverpool/`  
**Verify with Google Rich Results Test:**
- [ ] BreadcrumbList schema is valid
- [ ] BreadcrumbList has correct hierarchy
- [ ] BreadcrumbList includes locale in path
- [ ] No schema errors

---

## 📊 TEST SUMMARY CHECKLIST

### Critical URLs (High Priority - Test First):
1. [ ] `https://nrlc.ai/en-us/services/local-seo-ai/norwich/` → Redirect to `/en-gb/`
2. [ ] `https://nrlc.ai/services/generative-seo/singapore/` → Redirect to `/en-sg/`
3. [ ] `https://nrlc.ai/en-us/services/ai-seo-norwich/` → Redirect to `/en-gb/services/ai-search-optimization/norwich/`
4. [ ] `https://nrlc.ai/insights/open-seo-tools/` → Redirect to `/en-us/insights/open-seo-tools/`
5. [ ] `https://nrlc.ai/fr-fr/services/conversion-optimization-ai/stockport/` → Redirect to `/en-gb/`
6. [ ] `https://nrlc.ai/de-de/services/mobile-seo-ai/singapore/` → Redirect to `/en-sg/`
7. [ ] `https://nrlc.ai/ko-kr/services/site-audits/belfast/` → Redirect to `/en-gb/`

### Content Verification URLs:
8. [ ] `https://nrlc.ai/en-gb/services/generative-seo/liverpool/` → Verify all content features
9. [ ] `https://nrlc.ai/en-sg/services/mobile-seo-ai/singapore/` → Verify all content features
10. [ ] `https://nrlc.ai/en-us/services/generative-seo/chicago/` → Verify error handling

### Schema Validation URLs:
11. [ ] `https://nrlc.ai/en-gb/services/generative-seo/liverpool/` → Validate all schemas
12. [ ] `https://nrlc.ai/en-gb/services/technical-seo/nottingham/` → Validate all schemas

---

## 🔧 TESTING TOOLS

### For HTTP Redirect Testing:
- **curl:** `curl -I -L https://nrlc.ai/en-us/services/local-seo-ai/norwich/`
- **Browser DevTools:** Network tab → Check status codes and redirect chains
- **Online Tools:** Redirect Checker, HTTP Status Code Checker

### For Schema Validation:
- **Google Rich Results Test:** https://search.google.com/test/rich-results
- **Schema.org Validator:** https://validator.schema.org/
- **Google Search Console:** Check for schema errors

### For Content Verification:
- **Browser:** Manual inspection
- **View Source:** Check HTML structure
- **Console:** Check for JavaScript errors

---

## 📝 TEST RESULTS TEMPLATE

```
TEST DATE: [DATE]
TESTER: [NAME]
ENVIRONMENT: [Production/Staging]

TEST 1.1: UK City Wrong Locale (en-us → en-gb)
URL: https://nrlc.ai/en-us/services/local-seo-ai/norwich/
Status: [PASS/FAIL]
HTTP Status: [301/200/500]
Redirect To: [URL]
Notes: [Any issues]

[... continue for all tests ...]
```

---

## ✅ SUCCESS CRITERIA

**All tests must pass:**
- ✅ All redirects return 301 status code
- ✅ All redirects go to correct canonical URL
- ✅ All final destination pages return 200 status code
- ✅ All content features are present on final pages
- ✅ All schemas validate without errors
- ✅ No JavaScript errors in console
- ✅ No broken images or links
- ✅ Content is locale-appropriate

---

## 🚨 KNOWN ISSUES TO WATCH FOR

1. **Redirect Chains:** Ensure single redirect, not multiple
2. **Canonical Tags:** Verify canonical matches final URL
3. **Hreflang Tags:** Verify hreflang includes all alternate locales
4. **Content Locale:** Verify UK pages use UK spelling
5. **Schema Errors:** Watch for missing required fields
6. **500 Errors:** Watch for unguarded function calls causing fatal errors

---

## 📈 POST-DEPLOYMENT MONITORING

After deployment, monitor:
1. **Google Search Console:** Check for redirect chains, canonical issues
2. **Server Logs:** Check for 500 errors, fatal errors
3. **Analytics:** Monitor CTR improvements on fixed URLs
4. **Schema Errors:** Check GSC for schema validation errors

---

**Ready for deployment testing!**
