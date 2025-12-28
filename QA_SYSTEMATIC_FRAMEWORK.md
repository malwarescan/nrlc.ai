# Systematic QA Framework - Complete Implementation

**Date:** December 28, 2025  
**Purpose:** Prevent canonical collapse and indexing failures

## Global QA Objective

For every URL, answer definitively:

1. ✅ **Discoverable** - Can Google find it?
2. ✅ **Crawlable** - Can Google access it?
3. ✅ **Indexable** - Should Google index it?
4. ✅ **Canonically Stable** - Does canonical point to discoverable URL?
5. ✅ **Eligible for Intent** - Does it match searcher intent?

**If any one fails → the URL is dead weight.**

---

## Phase 1: Inventory & Classification

### Purpose
Classify every URL and flag locale/city mismatches immediately.

### Process
1. Parse URL to extract:
   - Locale (en-us, en-gb, etc.)
   - City target (if applicable)
   - Service type
   - Page type

2. Determine country target:
   - UK city → UK
   - US city → US
   - No city → Global

3. **Hard Rule:** If City Target ≠ Locale Country → **FAIL**

### Example
- `/en-us/services/local-seo-ai/norwich/` → ❌ FAIL (UK city in en-us)
- `/en-gb/services/local-seo-ai/norwich/` → ✅ PASS

### Automation
- Script: `qa_systematic_framework.php` (Phase 1)
- Runs on every Pages.csv import
- Flags mismatches immediately

---

## Phase 2: Discovery QA

### Purpose
Verify Google can discover the URL.

### Process (GSC URL Inspection)
1. Go to Google Search Console → URL Inspection
2. Enter URL
3. Check required outcomes

### PASS Conditions (any one):
- ✅ "URL is on Google"
- ✅ "URL is not indexed" BUT has:
  - Last crawl date
  - Referring sitemap
  - Referring page

### FAIL Conditions (any one = FAIL):
- ❌ "URL is unknown to Google"
- ❌ "No referring sitemaps detected"
- ❌ "Referring page: None detected"
- ❌ Crawl = N/A

### Immediate Fix Checklist
If FAIL:
1. Add URL to submitted sitemap
2. Add at least 1 internal link from indexed page
3. Ensure locale root (/en-gb/, /en-us/) is navigable

### Automation
- Script: `qa_systematic_framework.php` (Phase 2)
- Checks sitemap inclusion
- Flags missing URLs

---

## Phase 3: Canonical Consistency QA

### Purpose
Prevent canonical collapse (canonical pointing to undiscoverable URL).

### Process (GSC URL Inspection)
Check these 3 fields:
1. **User-declared canonical** - Must exist
2. **Google-selected canonical** - Must match user
3. **Canonical URL** - Must be indexable

### FAIL Scenarios (critical):
- ❌ "Duplicate, Google chose different canonical"
- ❌ Google canonical points to:
  - Different locale
  - Non-discoverable URL
  - Redirected URL
  - Non-indexed URL

### Hard Rules to Enforce:
1. City pages → single locale only
2. No identical city pages across locales
3. No canonical pointing to URL that is:
   - Not in sitemap
   - Not internally linked
   - Not crawlable

### Automation
- Script: `qa_systematic_framework.php` (Phase 3)
- Validates canonical targets are in sitemap
- Checks locale consistency

---

## Phase 4: Locale & Hreflang QA

### Purpose
Prevent hreflang issues that cause canonical override.

### Process
For every locale URL:

**If hreflang exists:**
- ✅ Bidirectional linking (A → B and B → A)
- ✅ Self-referencing hreflang
- ✅ Matching canonical + hreflang locale

**If hreflang does NOT exist:**
- ✅ No duplicate content across locales

### Critical Rule:
If hreflang exists but URLs are not discoverable, Google will:
- Infer canonicals
- Override your intent
- Suppress pages

### Automation
- Script: `qa_systematic_framework.php` (Phase 4)
- Detects duplicate locales for same city
- Flags hreflang inconsistencies

---

## Phase 5: Sitemap QA

### Purpose
Ensure sitemaps are structured correctly.

### Process (GSC → Sitemaps)
For every sitemap:
1. Confirm it is Submitted
2. Confirm status = Success
3. Spot check URLs:
   - Are not redirected
   - Are not canonically overridden
   - Resolve 200

### Required Sitemap Rules:
- ✅ en-us URLs only in en-us sitemap
- ✅ en-gb URLs only in en-gb sitemap
- ✅ No mixed-locale sitemaps
- ✅ No orphaned locale URLs

### Hard Rule:
**If a URL is not in a sitemap → assume Google will not find it**

### Automation
- Script: `qa_systematic_framework.php` (Phase 5)
- Validates sitemap structure
- Checks locale separation

---

## Phase 6: Internal Link Graph QA

### Purpose
Ensure URLs are discoverable via internal links.

### Process
For each URL, answer:

| Question | Required |
|----------|----------|
| Is it linked from a locale hub? | YES |
| Is it linked from another indexed page? | YES |
| Is anchor text relevant? | YES |

### FAIL Conditions:
- ❌ Orphaned URL
- ❌ Only linked from footer
- ❌ Only linked from non-indexed pages

### Rule:
**Internal linking is discovery insurance.**

### Automation
- Manual check required (crawl site)
- Script validates internal link generation logic

---

## Phase 7: Intent Eligibility QA

### Purpose
Verify page matches searcher intent (after indexing).

### Process
Using Queries.csv:
1. List top queries for URL
2. Classify intent:
   - Local commercial
   - National commercial
   - Informational

### Red Flags:
- ❌ Local queries + remote-only positioning
- ❌ City queries + no local proof
- ❌ High impressions + position > 50 consistently

### Note:
This tells you whether the page is:
- Mispositioned
- Or simply uncompetitive

**Do not confuse this with indexing problems.**

### Automation
- Script: `qa_systematic_framework.php` (Phase 7)
- Analyzes impressions/position/CTR
- Flags intent misalignment

---

## Phase 8: Automated Fail-Safe Rules

### Purpose
Block bad pages before deployment.

### Rule 1: No city page without sitemap inclusion
**Block deploy if:**
- URL matches `/services/*/{city}/`
- AND not present in sitemap

### Rule 2: No duplicate city across locales
**Block deploy if:**
- Same {city} exists in more than one locale
- Unless content + intent is explicitly differentiated

### Rule 3: No canonical to undiscoverable URL
**CI check:**
- Canonical target must appear in sitemap index
- Canonical target must be internally linked

### Automation
- Script: `qa_automated_rules.php`
- Runs in CI/CD pipeline
- Blocks deployment on failure

---

## Implementation Files

1. **`qa_systematic_framework.php`** - Automated QA script
   - Runs all 8 phases
   - Generates report
   - Exits with error code on failure

2. **`qa_manual_checklist.md`** - Manual QA checklist
   - Per-URL checklist
   - GSC URL Inspection steps
   - Action items

3. **`qa_automated_rules.php`** - CI/CD fail-safe rules
   - Pre-deployment validation
   - Blocks bad pages
   - Enforces hard rules

---

## Usage

### Automated QA (Recommended)
```bash
php qa_systematic_framework.php
```

### Manual QA (Per URL)
1. Open `qa_manual_checklist.md`
2. Fill out checklist for each URL
3. Document issues and fixes

### Pre-Deployment Check
```bash
php qa_automated_rules.php
```

---

## Expected Outcomes

### After Running QA:
- ✅ All URLs classified correctly
- ✅ Locale/city mismatches flagged
- ✅ Discovery issues identified
- ✅ Canonical issues detected
- ✅ Duplicate locales found
- ✅ Intent misalignment flagged

### After Fixes:
- ✅ All URLs discoverable
- ✅ All canonicals point to discoverable URLs
- ✅ No duplicate locales
- ✅ Internal links present
- ✅ Sitemaps structured correctly

---

## Next Steps

1. **Run automated QA** - `php qa_systematic_framework.php`
2. **Review critical issues** - Fix locale mismatches first
3. **Manual QA for top pages** - Use checklist for high-traffic URLs
4. **Integrate into CI/CD** - Add `qa_automated_rules.php` to deployment pipeline
5. **Monitor GSC** - Track indexing improvements

---

## Key Principle

**You didn't hit a weird edge case.**
**You hit a repeatable architectural failure.**

This framework ensures it never happens again.

