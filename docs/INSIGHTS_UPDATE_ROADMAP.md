# Insights Pages Update Roadmap
## AI Mention Optimization - Complete Implementation Plan

This document tracks the systematic update of all Insights pages to the standardized AI-mention optimized structure.

---

## Standards Created

✅ **AI_MENTION_CHUNKING_STANDARD.md** - Site-wide chunking standard
✅ **AI_MENTION_ELIGIBILITY_LINT.md** - Pass/fail linting checklist

---

## Pages to Update (17 total)

### Priority 1: Core Technical Pages (High Traffic Potential)
- [x] **how-to-get-your-business-mentioned-in-chatgpt** - ✅ COMPLETE
- [ ] **semantic-queries** - In progress
- [ ] **performance-caching** 
- [ ] **data-virtualization**
- [ ] **enterprise-llm**
- [ ] **knowledge-graph**

### Priority 2: SEO/Technical SEO Pages
- [ ] **google-llms-txt-ai-seo**
- [ ] **silent-hydration-seo**
- [ ] **goldmine-google-title-selection**

### Priority 3: Thin Content (Needs Expansion)
- [ ] **tool-reviews** - Currently very thin
- [ ] **industry-insights** - Currently very thin
- [ ] **open-seo-tools**

### Priority 4: GEO-16 Research Cluster
- [ ] **geo16-introduction**
- [ ] **geo16-results** - ⚠️ Tables need conversion to real HTML
- [ ] **geo16-implications** - ⚠️ Inline styles in headings
- [ ] **geo16-conclusion** - ⚠️ Inline styles in headings

---

## Update Template

Each page gets:
1. **Definition Lock** (2-4 sentences, first 120 words)
2. **H2: Mechanism** - How it works
3. **H2: Comparison/Table** (where applicable)
4. **H2: Implementation/Playbook** - Ordered list
5. **H2: Failure Modes** - What goes wrong
6. **H2: Related** - 3 internal links
7. **H2: FAQ** - 4-8 questions
8. **Schema Stack** - Article + FAQPage + DefinedTerm + Organization + BreadcrumbList

---

## Critical Fixes Required

### geo16-results
- **Issue:** Tables appear as plain text rows in extraction
- **Fix:** Convert to real HTML `<table>` markup

### geo16-implications & geo16-conclusion
- **Issue:** Inline style strings leaking into headings
- **Fix:** Remove all `style=""` attributes from headings, use CSS classes

### tool-reviews & industry-insights
- **Issue:** Extremely thin pages (low word count)
- **Fix:** Expand to full standardized structure with all required H2 blocks

---

## Progress Tracking

**Completed:** 1/17 (5.9%)
**In Progress:** 1/17
**Remaining:** 15/17

---

## Next Steps

1. Complete semantic-queries update (template)
2. Update performance-caching
3. Update data-virtualization
4. Update enterprise-llm
5. Update knowledge-graph
6. Fix GEO-16 pages (tables + inline styles)
7. Expand thin content pages
8. Update remaining SEO pages

