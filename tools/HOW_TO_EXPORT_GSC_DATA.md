# How to Export the Right GSC Data

## What You Need

To generate actionable SEO briefs, export these reports from Google Search Console:

---

## 1. **Performance Report → Pages** (CRITICAL for striking distance)

**Path:** `Performance > Search Results > Pages tab`

### Export Settings:
- **Date Range:** Last 3 months (or 6 if you have low traffic)
- **Filters:** None (export all pages)
- **Columns to include:**
  - Page URL
  - Clicks
  - Impressions
  - CTR
  - Position

### How to Export:
1. Go to https://search.google.com/search-console
2. Select your property: `https://nrlc.ai`
3. Click **Performance** in left sidebar
4. Click **Pages** tab at top
5. Scroll to bottom of page
6. Click **Export** → **Download CSV**
7. Save as: `gsc_data/Pages.csv`

**This is the most important file!** It contains position data for finding striking-distance pages.

---

## 2. **Performance Report → Queries** (Optional but helpful)

**Path:** `Performance > Search Results > Queries tab`

### Export Settings:
- **Date Range:** Last 3 months
- **Filters:** None
- **Columns:**
  - Query
  - Clicks
  - Impressions
  - CTR
  - Position

### How to Export:
1. Same steps as above, but click **Queries** tab instead
2. Export → Download CSV
3. Save as: `gsc_data/Queries.csv`

**Use:** Matches high-value queries to pages for content optimization.

---

## 3. **Page Indexing → Crawled Pages** (Optional)

**Path:** `Indexing > Pages > (any table with URLs)`

### How to Export:
1. Click **Indexing** > **Pages**
2. Click any issue (e.g., "Duplicate titles", "Missing descriptions")
3. Export the URL list
4. Save as: `gsc_data/Table.csv`

**Use:** Find meta tag issues (duplicates, missing descriptions).

---

## 4. **Manual Inspection Checks** (For meta validation)

If you want to include title/description analysis:

### Using Screaming Frog (Recommended):
1. Download Screaming Frog SEO Spider (free for 500 URLs)
2. Enter: `https://nrlc.ai`
3. Crawl your site
4. Export: **Internal > HTML** tab
5. Save as: `gsc_data/Metadata.csv`

**Columns should include:**
- Address (URL)
- Title 1
- Meta Description 1
- H1-1

### OR Using GSC Performance Report:
1. In **Performance > Pages** view
2. For each high-priority URL, manually note:
   - Current title tag
   - Current meta description
3. Create a CSV with columns: `URL,Title,Description`

---

## Current Status

✅ You have: `Table.csv` (URLs from indexing)  
✅ You have: `Metadata.csv` (shows duplicate FAQPage issue)  
❌ **Missing:** `Pages.csv` with position data (most important!)  
❌ **Missing:** `Queries.csv` with search terms  

---

## Quick Fix Now

Since you have **duplicate FAQPage** reported in Metadata.csv, that's a fixable issue!

The tool `SchemaFixes::jsonLdOnce()` we created earlier will deduplicate schema blocks automatically.

**Action:**
1. Export `Pages.csv` from Performance report (see above)
2. Re-run: `python3 tools/fixnow_from_gsc.py`
3. Apply the generated briefs to your striking-distance pages

---

## Expected File Structure After Export

```
gsc_data/
├── Pages.csv          ← Position data (REQUIRED)
├── Queries.csv        ← Search terms (optional)
├── Table.csv          ← URL list from indexing (you have this)
├── Metadata.csv       ← Meta tags & issues (you have this)
└── HOW_TO_EXPORT.md   ← This file
```

---

## Alternative: Use Site-Discovery Tool

If you can't access GSC or want to verify meta tags from your live site:

```bash
php site-discovery/scripts/discover.php --base=https://nrlc.ai --max=500
```

This will crawl your site and generate:
- `output/audit_report.csv` with all meta tags
- Evidence of duplicate/missing titles and descriptions
- Can be used instead of GSC Metadata.csv

---

## Questions?

**Where is the Performance report?**  
https://search.google.com/search-console → Performance (left sidebar)

**How far back should I export?**  
- High traffic site: 3 months  
- Low traffic site: 6-12 months  
- More data = better striking-distance detection

**What if I have multiple properties?**  
Export from your main property (usually the one with `https://` and no `www.` prefix issues)

**Can I use a different tool?**  
Yes! Any tool that exports URLs with position data works. Just ensure the CSV has these columns:
- A URL column (named anything with "url", "page", "address")
- A position column (named anything with "position", "avg position")

---

*Once you have Pages.csv, re-run the tool and you'll see striking-distance pages and actionable briefs!*

