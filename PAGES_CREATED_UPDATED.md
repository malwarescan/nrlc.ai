# Pages Created/Updated - Recent Commits

## Summary

This document lists all URLs/pages that were created or updated in recent commits.

---

## Commit: `ca43c33` - AI Prompt Query Routing System
**Date:** December 28, 2025  
**Type:** Data/Infrastructure (No new pages)

### Files Added:
- `AI_PROMPT_QUERY_ROUTING.md` - Documentation
- `ai_prompt_like_queries_mapped.csv` - Query routing data (301 queries)
- `scripts/analyze_ai_prompt_queries.php` - Query analyzer script

### Pages Created/Updated:
**None** - This commit only added data files and scripts, no actual pages were created or modified.

---

## Commit: `719bcf3` - Enterprise Schema Markup Content Cluster
**Date:** December 28, 2025  
**Type:** New Pages Created

### Pages Created:

#### 1. **Enterprise Schema Services Page (TIER 0)**
- **URL:** `/en-us/services/enterprise-schema-markup/`
- **File:** `pages/services/enterprise-schema-markup.php`
- **Purpose:** Primary answer page for "what agencies specialize in enterprise-level schema markup implementation?"
- **Status:** ✅ Created
- **Content:** Full service page with H1, lead paragraphs, sections on enterprise schema definition, benefits, approach, features, FAQs, and JSON-LD schema

#### 2. **Enterprise Schema Guide (TIER 2)**
- **URL:** `/en-us/insights/enterprise-schema-markup/`
- **File:** `pages/insights/enterprise-schema-markup.php`
- **Purpose:** Educational guide explaining what enterprise-level schema actually means
- **Status:** ✅ Created
- **Content:** Comprehensive guide with comparison tables, characteristics, knowledge graphs, pitfalls, and benefits

#### 3. **Schema Governance Guide (TIER 2)**
- **URL:** `/en-us/insights/schema-governance-and-validation/`
- **File:** `pages/insights/schema-governance-and-validation.php`
- **Purpose:** Framework and processes for enterprise-grade structured data
- **Status:** ✅ Created
- **Content:** Guide on schema governance, validation, implementation, and benefits

### Pages Updated:

#### 1. **Router Configuration**
- **File:** `bootstrap/router.php`
- **Changes:**
  - Added route handler for `/services/enterprise-schema-markup/`
  - Added metadata handling for `enterprise-schema-markup` and `schema-governance-and-validation` insight pages

#### 2. **Insights Article Registry**
- **File:** `pages/insights/article.php`
- **Changes:**
  - Added `enterprise-schema-markup` to insight articles array
  - Added `schema-governance-and-validation` to insight articles array

---

## Commit: `536ca56` - Contractor AI Visibility Page Rewrite
**Date:** December 28, 2025  
**Type:** Page Content Updated

### Pages Updated:

#### 1. **Contractor AI Visibility Page**
- **URL:** `/en-us/ai-visibility/contractor/`
- **File:** `pages/ai-visibility/contractor.php`
- **Purpose:** AI visibility services for contractors
- **Status:** ✅ Updated
- **Changes:**
  - **H1:** Changed from "AI Visibility for High-End Contractors" to "AI Visibility for Contractors"
  - **Lead Paragraphs:** Completely rewritten to use contractor-native language (e.g., "calls," "jobs," "who should I hire?") instead of technical jargon
  - **New Section:** "What This Means for Contractors" with bullet points
  - **New Section:** "How This Works: A Real Example" with concrete contractor example
  - **Section Titles:** Simplified and made contractor-friendly
  - **Content:** Rewritten throughout to remove technical jargon (LLMs, retrieval models, entity graphs) and replace with contractor-native language
  - **JSON-LD Schema:** Updated `name` and `description` properties to contractor-native language

#### 2. **Router Configuration**
- **File:** `bootstrap/router.php`
- **Changes:**
  - Updated meta description for `contractor` industry in `$prechunkingIndustries` array to be contractor-native

---

## Complete URL List

### New URLs Created (Commit 719bcf3):

1. `https://nrlc.ai/en-us/services/enterprise-schema-markup/`
2. `https://nrlc.ai/en-us/insights/enterprise-schema-markup/`
3. `https://nrlc.ai/en-us/insights/schema-governance-and-validation/`

### URLs Updated (Commit 536ca56):

1. `https://nrlc.ai/en-us/ai-visibility/contractor/`

---

## Verification

To verify these pages exist and are accessible:

```bash
# Check if pages exist
ls -la pages/services/enterprise-schema-markup.php
ls -la pages/insights/enterprise-schema-markup.php
ls -la pages/insights/schema-governance-and-validation.php
ls -la pages/ai-visibility/contractor.php

# Test URLs (if server is running)
curl -I https://nrlc.ai/en-us/services/enterprise-schema-markup/
curl -I https://nrlc.ai/en-us/insights/enterprise-schema-markup/
curl -I https://nrlc.ai/en-us/insights/schema-governance-and-validation/
curl -I https://nrlc.ai/en-us/ai-visibility/contractor/
```

---

## Related Files Modified

### Router (`bootstrap/router.php`):
- Added route for `/services/enterprise-schema-markup/`
- Added metadata handling for enterprise schema insight pages
- Updated contractor industry meta description

### Insights Registry (`pages/insights/article.php`):
- Added `enterprise-schema-markup` to insight articles
- Added `schema-governance-and-validation` to insight articles

---

## Next Steps

1. ✅ **Pages Created** - All 3 new pages are live
2. ✅ **Pages Updated** - Contractor page rewritten
3. ⏳ **Sitemap** - Verify new pages are in sitemap
4. ⏳ **Internal Links** - Add internal links to new pages from related content
5. ⏳ **GSC Submission** - Submit new URLs to Google Search Console

