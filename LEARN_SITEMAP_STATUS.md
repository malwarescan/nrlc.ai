# Learn/Course Sitemap Status

**Date:** 2026-01-27  
**Status:** ⚠️ CONFIGURED BUT NOT GENERATED

---

## CURRENT STATUS

### ✅ Sitemap Code Exists
- **File:** `scripts/build_sitemaps.php` (Section 12a)
- **Sitemap File:** `public/sitemaps/learn-1.xml` (will be created when script runs)
- **Gzipped:** `public/sitemaps/learn-1.xml.gz` (will be created when script runs)

### ❌ Sitemap NOT Generated Yet
- **Missing:** `public/sitemaps/learn-1.xml`
- **Missing:** `public/sitemaps/learn-1.xml.gz`
- **Missing from:** `public/sitemaps/sitemap-index.xml`

---

## PAGES INCLUDED IN SITEMAP CODE

### Current Learn Pages (4 pages):
1. ✅ `/en-us/learn/` - Hub page (priority: 0.9)
2. ✅ `/en-us/learn/can-ai-do-seo/` - Course (priority: 0.8)
3. ✅ `/learn/types-of-seo/` - Course (priority: 0.8)
4. ✅ `/learn/seo-80-20-rule/` - Course (priority: 0.8) **ADDED**

### Additional Pages:
5. ✅ `/en-us/answer-first-architecture/` - Research methodology (priority: 0.9)

**Total:** 5 pages in sitemap

---

## FUTURE PAGES (Commented Out)

When these pages are created, uncomment in `scripts/build_sitemaps.php`:
- `/learn/chatgpt-seo/`
- `/learn/ai-30-percent-rule/`

---

## HOW TO GENERATE SITEMAP

### Run Sitemap Generation Script:
```bash
php scripts/build_sitemaps.php
```

### Expected Output:
```
📄 Generating learn sitemap (5 URLs)...
Built learn sitemap: 5 URLs
```

### Files Created:
- `public/sitemaps/learn-1.xml`
- `public/sitemaps/learn-1.xml.gz`
- `public/sitemaps/sitemap-index.xml` (updated to include `learn-1.xml.gz`)

---

## VERIFICATION

### After Generation, Check:
1. ✅ `public/sitemaps/learn-1.xml` exists
2. ✅ `public/sitemaps/learn-1.xml.gz` exists
3. ✅ `public/sitemaps/sitemap-index.xml` includes `<sitemap><loc>https://nrlc.ai/sitemaps/learn-1.xml.gz</loc></sitemap>`
4. ✅ All 5 learn/course pages are in `learn-1.xml`

---

## NEXT STEPS

1. **Generate sitemap:** Run `php scripts/build_sitemaps.php`
2. **Verify output:** Check that `learn-1.xml` contains all 5 pages
3. **Deploy:** Push generated sitemaps to production
4. **Submit to GSC:** Submit updated sitemap index to Google Search Console

---

## SUMMARY

✅ **Sitemap code configured** in `scripts/build_sitemaps.php`  
✅ **All current courses included** (4 learn pages + 1 research page)  
⚠️ **Sitemap not yet generated** - needs to run `scripts/build_sitemaps.php`  
✅ **Ready for future courses** - commented placeholders in place
