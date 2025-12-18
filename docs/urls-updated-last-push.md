# URLs UPDATED IN LAST PUSH

**Commit:** `d86a780` - "Tier 1 geo reinforcement + Norwich validation node + Monitoring phase"  
**Date:** 2025-01-XX

---

## TIER 1 REINFORCED PAGES (GEO REINFORCEMENT)

### 1. Homepage
**URL:** `https://nrlc.ai/en-us/`  
**Changes:**
- Added geo clarification line: "Serving companies across the United States and United Kingdom..."
- Changed CTA button: "Free AI Visibility Audit (US & UK)" (now uses `openContactSheet()`)
- Removed direct `/api/book/` link

---

### 2. AI Search Optimization Service Page
**URL:** `https://nrlc.ai/en-us/services/ai-search-optimization/`  
**Changes:**
- Added geo confirmation block (blue box): "We work with companies across the United States and United Kingdom, including businesses in Norwich, London, and major technology hubs. All services are delivered remotely."
- Replaced CTA: "Get a Free AI Visibility Audit" (now uses `openContactSheet()`)
- Added internal link: "AI SEO services in Norwich" → `/en-gb/services/ai-seo-norwich/`
- Updated Service schema: `areaServed` = [United States, United Kingdom, Norwich]
- Removed direct `/api/book/` link

---

### 3. GEO-16 Introduction Insight Page
**URL:** `https://nrlc.ai/en-us/insights/geo16-introduction/`  
**Changes:**
- Added contextual geo reinforcement: "We frequently see these visibility gaps surface for businesses in the US and UK, including city-specific markets like Norwich, where AI and search intent often diverge."
- Added 2 internal links:
  - "AI search optimization services" → `/en-us/services/ai-search-optimization/`
  - "AI SEO services in Norwich" → `/en-gb/services/ai-seo-norwich/`

---

## NEW PAGE CREATED

### 4. Norwich AI SEO Page (NEW)
**URL:** `https://nrlc.ai/en-gb/services/ai-seo-norwich/`  
**Status:** NEW PAGE  
**Content:**
- H1: "AI SEO & AI Visibility Services in Norwich"
- Opening paragraph with remote delivery focus
- Outcomes section (4 bullet points)
- CTA: "Get a Free AI Visibility Audit for Your Norwich Business" (uses `openContactSheet()`)
- FAQ section (3 questions)
- Footer line: "Not in Norwich? We also work with companies across the UK and United States."
- Service schema with `areaServed` = [United Kingdom, Norwich]
- Removed direct `/api/book/` link

---

## AI VISIBILITY PAGES (SCHEMA ENFORCEMENT)

### 5. AI Visibility Hub Page
**URL:** `https://nrlc.ai/en-us/ai-visibility/`  
**Changes:**
- Full schema enforcement (Organization, Service, WebPage, BreadcrumbList, FAQPage, Action)
- Organization schema: `name='NRLC.ai'` (custom implementation)
- Service schema: Primary schema with exact directive description
- All CTAs now use `openContactSheet()` (removed `/api/book/` links)

---

## INFRASTRUCTURE UPDATES

### Sitemap
**URL:** `https://nrlc.ai/sitemaps/ai-visibility-1.xml.gz`  
**Changes:**
- Added Norwich page: `/en-gb/services/ai-seo-norwich/`
- Removed `/api/book/` from index pages sitemap

### Robots.txt
**URL:** `https://nrlc.ai/robots.txt`  
**Changes:**
- Added `Disallow: /api/` to block API endpoints

---

## ENDPOINT SECURITY

### API Booking Endpoint
**URL:** `https://nrlc.ai/api/book/`  
**Changes:**
- GET requests now return 403 Forbidden
- POST requests still work (form submissions)
- Blocked from sitemap
- Blocked in robots.txt

---

## SUMMARY

**Total URLs Updated:** 5 pages + infrastructure  
**New Pages Created:** 1 (Norwich)  
**Security Fixes:** 1 endpoint (GET blocked)  
**Schema Updates:** 2 pages (ai-search-optimization, Norwich)  
**Sitemap Updates:** 1 (added Norwich, removed /api/book/)  
**Robots.txt Updates:** 1 (added /api/ disallow)

---

## TIER 1 PAGES STATUS

✅ **Homepage** - Geo clarification + CTA fix  
✅ **AI Search Optimization** - Geo block + CTA fix + internal link + schema  
✅ **GEO-16 Introduction** - Geo reinforcement + 2 internal links  
✅ **Norwich Page** - NEW PAGE (complete)  
✅ **AI Visibility Hub** - Schema enforcement + CTA fixes

**All Tier 1 pages compliant with governance rules.**

