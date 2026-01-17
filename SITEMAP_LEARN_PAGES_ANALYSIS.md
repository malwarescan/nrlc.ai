# Sitemap Analysis: Learn & Course Pages

**Date:** 2026-01-27  
**Status:** ❌ LEARN PAGES NOT IN SITEMAP

---

## CURRENT SITEMAP STRUCTURE

### Existing Sitemaps
- ✅ `services-1.xml` - Service pages
- ✅ `careers-1.xml` - Career pages
- ✅ `insights-1.xml` - Insights articles
- ✅ `index-pages-1.xml` - Index/hub pages
- ✅ `products-1.xml` - Product pages
- ✅ `tools-1.xml` - Tool pages
- ✅ `geo-1.xml` - GEO research pages
- ✅ `docs-1.xml` - Documentation pages
- ❌ **NO `learn-1.xml` or `courses-1.xml`** - Missing!

### Pages NOT in Sitemap
- ❌ `/en-us/learn/` (Learn hub)
- ❌ `/en-us/learn/can-ai-do-seo/` (Course)
- ❌ `/en-us/learn/types-of-seo/` (Course)
- ❌ `/en-us/answer-first-architecture/` (Research page)

---

## ISSUE

**Problem:** Learn pages and Answer First Architecture page are not included in any sitemap.

**Impact:**
- Google won't discover these pages automatically
- Missing from sitemap index
- No hreflang exposure in sitemaps
- Slower indexing for new pages

---

## SOLUTION

### Option 1: Add to Index Pages Sitemap (Quick Fix)
Add learn pages to existing `index-pages-1.xml`:
- `/en-us/learn/`
- `/en-us/answer-first-architecture/`

### Option 2: Create Dedicated Learn Sitemap (Recommended)
Create `learn-1.xml` with all learn pages:
- `/en-us/learn/` (hub)
- `/en-us/learn/can-ai-do-seo/`
- `/en-us/learn/types-of-seo/`
- `/en-us/learn/seo-80-20-rule/` (when created)
- `/en-us/learn/chatgpt-seo/` (when created)
- `/en-us/learn/ai-30-percent-rule/` (when created)

**Also include:**
- `/en-us/answer-first-architecture/` (could go in learn sitemap or separate)

---

## RECOMMENDED IMPLEMENTATION

**Create dedicated `learn-1.xml` sitemap with:**
- Learn hub page
- All beginner course pages (current + future)
- Answer First Architecture page (research methodology)

**Benefits:**
- Clear organization (all educational content together)
- Easy to expand as more learn pages are added
- Better for Google Course Info rich results discovery
