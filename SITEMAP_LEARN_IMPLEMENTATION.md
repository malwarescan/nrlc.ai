# Sitemap Analysis & Implementation: Learn Pages

**Date:** 2026-01-27  
**Status:** ✅ IMPLEMENTED

---

## ISSUE FOUND

**Problem:** Learn pages and Answer First Architecture page were **NOT included in any sitemap**.

**Missing Pages:**
- ❌ `/en-us/learn/` (Learn hub)
- ❌ `/en-us/learn/can-ai-do-seo/` (Course)
- ❌ `/en-us/learn/types-of-seo/` (Course)
- ❌ `/en-us/answer-first-architecture/` (Research page)

**Impact:**
- Google won't discover these pages automatically
- Missing from sitemap index
- No hreflang exposure in sitemaps
- Slower indexing for new pages

---

## SOLUTION IMPLEMENTED

### New Sitemap: `learn-1.xml`

**Created dedicated Learn sitemap** in `scripts/build_sitemaps.php` (Section 12a).

**Pages Included:**
1. `/en-us/learn/` - Hub page (priority: 0.9)
2. `/en-us/learn/can-ai-do-seo/` - Course (priority: 0.8)
3. `/en-us/learn/types-of-seo/` - Course (priority: 0.8)
4. `/en-us/answer-first-architecture/` - Research methodology (priority: 0.9)

**Future Pages (commented out, ready to uncomment):**
- `/en-us/learn/seo-80-20-rule/`
- `/en-us/learn/chatgpt-seo/`
- `/en-us/learn/ai-30-percent-rule/`

---

## IMPLEMENTATION DETAILS

### File: `scripts/build_sitemaps.php`

**Added Section 12a (after index-pages sitemap):**
```php
// 12. Learn & Course pages sitemap (Beginner Education Hub)
$learnEntries = [];
$learnPages = [
  '/learn/',  // Hub page
  '/learn/can-ai-do-seo/',
  '/learn/types-of-seo/',
  '/answer-first-architecture/',
];

foreach ($learnPages as $path) {
  $canonicalUrl = "https://nrlc.ai/en-us{$path}";
  
  // Get actual lastmod from file timestamp
  $pageFile = __DIR__ . '/../pages' . str_replace('/', '', $path) . '.php';
  if (!file_exists($pageFile)) {
    $pageFile = __DIR__ . '/../pages' . rtrim($path, '/') . '/index.php';
  }
  
  $lastmod = file_exists($pageFile) ? date('Y-m-d', filemtime($pageFile)) : $today;
  $priority = ($path === '/learn/' || $path === '/answer-first-architecture/') ? '0.9' : '0.8';
  
  $learnEntries[] = sitemap_entry_simple($canonicalUrl, $lastmod, 'weekly', $priority);
}

// Generate learn-1.xml and learn-1.xml.gz
```

**Features:**
- ✅ Dynamically reads `lastmod` from actual file timestamps
- ✅ Priority assignment (hub pages = 0.9, courses = 0.8)
- ✅ Automatically added to sitemap index
- ✅ Gzipped version generated
- ✅ Ready for future learn pages (commented placeholders)

---

## NEXT STEPS

### 1. Regenerate Sitemaps
Run sitemap generation script:
```bash
php scripts/build_sitemaps.php
```

### 2. Verify Output
Check generated files:
- `public/sitemaps/learn-1.xml`
- `public/sitemaps/learn-1.xml.gz`
- `public/sitemaps/sitemap-index.xml` (should include learn-1.xml.gz)

### 3. Submit to Google Search Console
After deployment, submit updated sitemap index to GSC.

### 4. Future Learn Pages
When creating new learn pages, add them to the `$learnPages` array in `scripts/build_sitemaps.php`.

---

## VERIFICATION

### Files Modified
- ✅ `scripts/build_sitemaps.php` - Added Section 12a (Learn sitemap)

### Files to Generate (after running script)
- ✅ `public/sitemaps/learn-1.xml`
- ✅ `public/sitemaps/learn-1.xml.gz`
- ✅ `public/sitemaps/sitemap-index.xml` (updated to include learn-1.xml.gz)

---

## BENEFITS

1. **Google Discovery:** Learn pages will be discovered automatically
2. **Course Info Rich Results:** Course schema pages in sitemap help Google identify educational content
3. **Indexing Speed:** Faster indexing for new learn pages
4. **Organization:** Dedicated sitemap keeps educational content separate
5. **Scalability:** Easy to add future learn pages

---

## STATUS

✅ **IMPLEMENTATION COMPLETE**

Ready to:
1. Run sitemap generation script
2. Deploy updated sitemaps
3. Submit to Google Search Console
