# URLs to Monitor - Post Implementation
**Date:** January 9, 2026  
**Purpose:** Monitor META KERNEL DIRECTIVE implementation and all fixes

## Priority 1: Service × City Pages (META KERNEL DIRECTIVE)

### Top Service + Major City Combinations

#### US Cities (en-us locale)
```
https://nrlc.ai/en-us/services/crawl-clarity/new-york/
https://nrlc.ai/en-us/services/crawl-clarity/houston/
https://nrlc.ai/en-us/services/crawl-clarity/san-francisco/
https://nrlc.ai/en-us/services/json-ld-strategy/los-angeles/
https://nrlc.ai/en-us/services/json-ld-strategy/chicago/
https://nrlc.ai/en-us/services/llm-seeding/boston/
https://nrlc.ai/en-us/services/llm-seeding/seattle/
https://nrlc.ai/en-us/services/site-audits/dallas/
https://nrlc.ai/en-us/services/site-audits/austin/
https://nrlc.ai/en-us/services/technical-seo/new-york/
https://nrlc.ai/en-us/services/technical-seo/houston/
https://nrlc.ai/en-us/services/local-seo-ai/phoenix/
https://nrlc.ai/en-us/services/local-seo-ai/san-diego/
```

#### UK Cities (en-gb locale)
```
https://nrlc.ai/en-gb/services/crawl-clarity/london/
https://nrlc.ai/en-gb/services/crawl-clarity/norwich/
https://nrlc.ai/en-gb/services/json-ld-strategy/manchester/
https://nrlc.ai/en-gb/services/llm-seeding/birmingham/
https://nrlc.ai/en-gb/services/site-audits/liverpool/
https://nrlc.ai/en-gb/services/technical-seo/leeds/
https://nrlc.ai/en-gb/services/local-seo-ai/sheffield/
```

### Service Types to Monitor
- **Audit Services:** `site-audits`, `technical-audit-ai`
- **Core Services:** `crawl-clarity`, `json-ld-strategy`, `llm-seeding`, `llm-optimization`
- **Specialized Services:** `local-seo-ai`, `technical-seo`, `voice-search-optimization`
- **Industry Services:** `ecommerce-ai-seo`, `b2b-seo-ai`, `content-optimization-ai`

### City Types to Monitor
- **Major US Cities:** new-york, los-angeles, chicago, houston, phoenix, san-francisco, boston, seattle, dallas, austin
- **Major UK Cities:** london, norwich, manchester, birmingham, liverpool, leeds, sheffield
- **Test Cities:** Test at least 3-5 cities per service to verify uniqueness

## Priority 2: Career Pages (JobPosting Schema Fixes)

### LLM Strategist Career Pages
```
https://nrlc.ai/en-us/careers/hasuda/llm-strategist/
https://nrlc.ai/en-gb/careers/norwich/llm-strategist/
https://nrlc.ai/en-gb/careers/london/llm-strategist/
https://nrlc.ai/en-us/careers/houston/llm-strategist/
https://nrlc.ai/en-us/careers/new-york/llm-strategist/
```

**Monitoring Focus:**
- ✅ JobPosting schema validation (streetAddress, postalCode, addressRegion, baseSalary)
- ✅ Canonical URL correctness (should match request locale)
- ✅ Breadcrumb schema accuracy

## Priority 3: API Endpoints (Redirect Fixes)

### API Endpoints to Verify
```
https://nrlc.ai/api/book/
https://nrlc.ai/api/book (no trailing slash - should redirect to /api/book/)
```

**Monitoring Focus:**
- ✅ GET/HEAD requests redirect correctly (301)
- ✅ POST requests process correctly (no redirect)
- ✅ `noindex` headers present
- ✅ 403 response for direct GET/HEAD access

## Priority 4: Redirect Verification URLs

### Fixed Redirect Patterns

#### Booking/Contact Pages
```
https://nrlc.ai/booking/ → Should redirect to /en-us/book/
https://nrlc.ai/contact/ → Should redirect to /en-us/?contact=1
https://nrlc.ai/about/ → Should return 404 with noindex
```

#### Products Pages (Canonical Fix)
```
https://nrlc.ai/en-us/products/ → Should be indexable (no noindex)
https://nrlc.ai/en-gb/products/ → Should noindex and canonicalize to /en-us/products/
https://nrlc.ai/fr-fr/products/ → Should noindex and canonicalize to /en-us/products/
```

#### Locale Index Pages
```
https://nrlc.ai/es-es/ → Should redirect to /en-us/
https://nrlc.ai/fr-fr/ → Should redirect to /en-us/
https://nrlc.ai/de-de/ → Should redirect to /en-us/
https://nrlc.ai/ko-kr/ → Should redirect to /en-us/
```

#### Locale Insights Pages
```
https://nrlc.ai/ko-kr/insights/ → Should redirect to /en-us/insights/
https://nrlc.ai/es-es/insights/ → Should redirect to /en-us/insights/
```

#### Products/Blog/Promptware/Careers in Non-Canonical Locales
```
https://nrlc.ai/es-es/products/ → Should redirect to /en-us/products/
https://nrlc.ai/fr-fr/blog/ → Should redirect to /en-us/blog/
https://nrlc.ai/de-de/promptware/ → Should redirect to /en-us/promptware/
https://nrlc.ai/ko-kr/careers/ → Should redirect to /en-us/careers/
```

## Priority 5: Google Search Console Monitoring

### GSC Issues to Monitor Resolution

1. **"Page with redirect" (16,151 pages)**
   - Monitor for reduction over next 1-2 weeks
   - Check redirect URLs are working correctly

2. **"Alternate page with proper canonical tag" (14,330 pages)**
   - Monitor "Failed" category reduction
   - Verify "Pending" remains informational only

3. **"Not found (404)" (18 pages)**
   - Verify all 18 URLs now return proper 404 with noindex
   - Check redirects working (booking → book, contact → ?contact=1)

4. **"Duplicate, Google chose different canonical than user" (33,183 pages)**
   - Monitor for resolution as Google re-crawls
   - Verify canonical tags match actual URLs

5. **"Crawled - currently not indexed" (10,050 pages)**
   - Monitor for improvement (may require content quality improvements)
   - Verify technical issues resolved

6. **"Job Postings" Schema Errors**
   - Verify `streetAddress` fix
   - Verify `addressRegion` fix (conditional)
   - Verify `postalCode` fix
   - Verify `baseSalary` fix

## Priority 6: Content Quality Monitoring

### Service × City Page Content Checks

For each service+city combination, verify:

1. **8-Section Template Present:**
   - ✅ Hero Section with H1
   - ✅ Service Overview (~150 words)
   - ✅ Why Choose Us in [City]
   - ✅ Process / How It Works (5 steps)
   - ✅ Pricing (city-adjusted)
   - ✅ FAQ (5-7 questions, city-specific)
   - ✅ Service Area Coverage
   - ✅ Primary CTA

2. **Content Length:**
   - Minimum 1,200 words
   - Target 1,800+ words
   - Actual: ~3,100 words (exceeds requirement)

3. **Uniqueness Vectors (Minimum 3 per page):**
   - ✅ Geographic specificity (city + subdivision)
   - ✅ Market-specific challenges
   - ✅ City-specific usage patterns
   - ✅ Neighborhood lists (for major cities)
   - ✅ Regional trust signals

4. **City-Specific Context:**
   - City name appears throughout content
   - Local references present
   - Market context city-specific
   - FAQs reference city context

## Priority 7: Performance Monitoring

### Page Load Performance
```
Monitor: Average page load time for service+city pages
Target: < 2 seconds
Check: Content generation performance (should be fast due to caching)
```

### Indexing Status
```
Monitor: Google Search Console → Coverage → Valid pages
Check: Increase in indexed service+city pages
Verify: Pages appear in sitemap correctly
```

### Crawl Statistics
```
Monitor: Google Search Console → Settings → Crawl Stats
Check: Crawl efficiency improvements
Verify: Reduced crawl waste from canonicalization
```

## Priority 8: Schema Validation

### Structured Data Monitoring

1. **Service Schema:**
   ```
   Verify: Service schema present on all service+city pages
   Check: Service name, type, provider correct
   Validate: areaServed includes city
   ```

2. **JobPosting Schema (Career Pages):**
   ```
   Verify: All required fields present
   - streetAddress: "Remote"
   - postalCode: "00000"
   - addressRegion: (conditional, if city subdivision exists)
   - baseSalary: Complete MonetaryAmount object
   ```

3. **FAQPage Schema:**
   ```
   Verify: FAQPage schema present if FAQs exist
   Check: 5-7 questions per page
   Validate: City context in answers
   ```

4. **BreadcrumbList Schema:**
   ```
   Verify: Breadcrumbs correct
   Check: Locale in breadcrumb URLs matches page locale
   ```

## Testing Checklist Per URL

For each URL monitored, verify:

- [ ] Page loads without errors (HTTP 200)
- [ ] All 8 sections render correctly
- [ ] Content is unique (not duplicate across cities)
- [ ] City name appears in content
- [ ] Pricing shows correct currency (USD/GBP)
- [ ] FAQs include city context
- [ ] Service area coverage present
- [ ] CTAs functional
- [ ] Canonical URL matches actual URL
- [ ] Schema markup valid (test with Rich Results Test)
- [ ] Mobile-friendly
- [ ] Fast load time (< 2 seconds)
- [ ] No console errors
- [ ] Meta title/description present and correct

## Monitoring Schedule

### Week 1-2 (Immediate)
- **Daily:** Check top 20 service+city combinations load correctly
- **Daily:** Verify GSC errors reducing
- **Daily:** Test redirect URLs working
- **Daily:** Validate schema markup for career pages

### Week 3-4 (Short-term)
- **3x/week:** Check GSC indexing status
- **3x/week:** Verify content uniqueness (compare 3-5 cities per service)
- **3x/week:** Monitor crawl statistics
- **Weekly:** Check page load performance

### Month 2+ (Long-term)
- **Weekly:** Monitor GSC for full resolution of issues
- **Weekly:** Check indexing status for all service+city pages
- **Monthly:** Review content quality and uniqueness
- **Monthly:** Performance review

## Key Metrics to Track

1. **Indexing:**
   - Number of indexed service+city pages
   - GSC coverage report improvements
   - Indexing errors reduction

2. **Content Quality:**
   - Word count per page (target: 1,200-1,800+)
   - Uniqueness score (no duplicate content)
   - City-specific references count

3. **Technical:**
   - Page load times
   - Schema validation errors
   - Redirect chain lengths
   - Canonical accuracy

4. **SEO Performance:**
   - Organic impressions for service+city pages
   - Rankings for "[service] in [city]"
   - Click-through rates
   - Conversion rates (if tracking)

## Tools for Monitoring

1. **Google Search Console**
   - Coverage reports
   - Performance reports
   - Core Web Vitals
   - Mobile Usability

2. **Schema Validator**
   - Google Rich Results Test: https://search.google.com/test/rich-results
   - Schema.org Validator: https://validator.schema.org/

3. **Page Speed Tools**
   - Google PageSpeed Insights
   - WebPageTest
   - Lighthouse

4. **Content Quality**
   - Manual review for uniqueness
   - Word count checks
   - Duplicate content detectors

5. **Uptime Monitoring**
   - Pingdom, UptimeRobot, or similar
   - Monitor critical service+city combinations

## Alerts to Set Up

### Critical Alerts
- Page returns 500 error
- Page returns 404 (should not happen for valid service+city combos)
- Schema validation errors
- Redirect loops detected

### Warning Alerts
- Page load time > 3 seconds
- Missing schema markup
- Canonical URL mismatch
- Missing required sections (8-section template)

## Quick Reference: Sample Monitoring URLs

### Service × City (US - en-us)
```
https://nrlc.ai/en-us/services/crawl-clarity/new-york/
https://nrlc.ai/en-us/services/json-ld-strategy/houston/
https://nrlc.ai/en-us/services/llm-seeding/san-francisco/
https://nrlc.ai/en-us/services/site-audits/chicago/
https://nrlc.ai/en-us/services/technical-seo/boston/
```

### Service × City (UK - en-gb)
```
https://nrlc.ai/en-gb/services/crawl-clarity/london/
https://nrlc.ai/en-gb/services/json-ld-strategy/norwich/
https://nrlc.ai/en-gb/services/llm-seeding/manchester/
https://nrlc.ai/en-gb/services/site-audits/birmingham/
https://nrlc.ai/en-gb/services/technical-seo/liverpool/
```

### Career Pages
```
https://nrlc.ai/en-us/careers/hasuda/llm-strategist/
https://nrlc.ai/en-gb/careers/norwich/llm-strategist/
```

### Redirect Test URLs
```
https://nrlc.ai/booking/ → /en-us/book/
https://nrlc.ai/contact/ → /en-us/?contact=1
https://nrlc.ai/api/book → /api/book/
```

### Canonical Test URLs
```
https://nrlc.ai/en-us/products/ (should be indexable)
https://nrlc.ai/en-gb/products/ (should noindex → /en-us/products/)
```

## Notes

- **Total Service × City Combinations:** ~200+ cities × ~50+ services = 10,000+ potential pages
- **Priority Monitoring:** Focus on top 50-100 combinations initially
- **Automated Testing:** Consider setting up automated tests for critical URLs
- **GSC Monitoring:** Most important tool for tracking indexing and coverage issues

---

**Last Updated:** January 9, 2026  
**Next Review:** January 16, 2026
