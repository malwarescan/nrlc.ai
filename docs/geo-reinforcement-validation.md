# GEO REINFORCEMENT VALIDATION & CONTROLLED EXPANSION PROTOCOL

**Status:** TIER 1 COMPLETE — MONITORING PHASE  
**Date:** 2025-01-XX  
**Authority:** NRLC.ai Search + AI Visibility Program

---

## PHASE 1 — POST-IMPLEMENTATION VALIDATION ✅

### STRUCTURAL INTEGRITY CHECKS

✅ **URL Changes:** NO URL changes on Tier 1 pages
- `/en-us/services/ai-search-optimization/` - unchanged
- `/en-us/` - unchanged  
- `/insights/geo16-introduction/` - unchanged

✅ **Canonical Tags:** NO canonical modifications
- All Tier 1 pages maintain existing canonicals
- Norwich page: Self-referencing canonical (`/en-gb/services/ai-seo-norwich/`)

✅ **Hreflang:** NO hreflang changes or expansions
- No hreflang tags added or modified
- Norwich page isolated under `/en-gb/` locale

✅ **New Page Isolation:** Norwich page properly isolated
- URL: `/en-gb/services/ai-seo-norwich/`
- No cross-locale contamination
- Proper UK city routing enforced

**RESULT:** Re-indexing churn risk = **ZERO**

---

### GEO COMPLIANCE CHECKS

✅ **Geo Language:** All mentions reflect locations already inferred by Google
- United States: ✅ (existing traffic)
- United Kingdom: ✅ (existing traffic)
- Norwich: ✅ (observed in query data)
- London: ✅ (mentioned as example, not new target)

✅ **Prohibited Elements:** NO invented cities or speculative targets
- No Blackpool
- No Singapore
- No mass templating

✅ **Editorial Style:** Geo mentions are editorial, not templated
- Natural language integration
- Contextual mentions only
- No doorway patterns

**RESULT:** Passes human review + algorithmic doorway classifiers

---

### SCHEMA DISCIPLINE CHECKS

✅ **Service Schema Only:** Correct schema type
- `@type: Service` ✅
- `areaServed` properly structured ✅

✅ **Allowed Locations:**
- United States ✅
- United Kingdom ✅
- Norwich ✅

✅ **Prohibited Elements:** NO violations
- ❌ No LocalBusiness schema
- ❌ No addresses
- ❌ No coordinates
- ❌ No fake offices

**RESULT:** Remote-service geo declaration compliant with Google expectations

---

### INTERNAL LINKING HIERARCHY

✅ **Link Count:** Within 1-2 per page limit
- Homepage: 0 new links (geo clarification only)
- AI Search Optimization: 1 link (Norwich)
- GEO-16 Introduction: 2 links (AI Search Optimization + Norwich)
- Norwich page: 0 internal links (isolated)

✅ **Anchor Text:** Matches observed query language
- "AI SEO services in Norwich" ✅
- "AI search optimization services" ✅

✅ **Authority Flow:** Clean hierarchy maintained
- Authority (GEO-16) → Core Service (AI Search Optimization) → City Page (Norwich) ✅

**RESULT:** Clean topical and geographic authority flow

---

### MANDATORY TECH CHECKS

✅ **Canonical:** Norwich page has self-referencing canonical
```php
$canonicalUrl = absolute_url('/en-gb/services/ai-seo-norwich/');
```

✅ **Sitemap:** Norwich page included in XML sitemap
- Added to `ai-visibility-1.xml.gz` sitemap
- Priority: 0.8
- Changefreq: weekly

✅ **Robots.txt:** No blocking under `/en-gb/`
- Current robots.txt: `Allow: /`
- No restrictions on `/en-gb/` paths

**RESULT:** All technical checks passed

---

## PHASE 2 — GSC MONITORING PROTOCOL

### IGNORE METRICS (DO NOT REACT)
- ❌ Sitewide CTR
- ❌ Sitewide average position
- ❌ Total clicks

### MONITOR ONLY

**Query-Level (Filter: weekly)**
- `norwich`
- `seo norwich`
- `ai seo norwich`
- `seo services norwich`

**Success Conditions:**
- Impressions stable or increasing
- Average position compresses (≥20 position improvement = win)
- Clicks may remain zero initially (acceptable)

**Page-Level (Norwich page only)**
- First impressions within 7-14 days = INDEX ACCEPTANCE
- Position stabilization preferred over volatility

**Conversion Signal (CRITICAL)**
- Norwich CTA form: `openContactSheet('AI SEO Norwich')`
- ONE form submission = VALIDATION SUCCESS
- ZERO submissions = continue observation, do not expand

---

## PHASE 3 — TIMELINE EXPECTATIONS

**Week 1-2**
- Page indexed
- Initial impressions
- Positions may range 50-90 (expected)

**Week 3-4**
- Position compression begins
- Query consolidation
- Internal links start influencing rankings

**Week 4-6**
- Decision window:
  - IF clicks OR ≥20 position improvement OR ≥1 conversion → PROCEED TO EXPANSION
  - ELSE → COPY REFINEMENT ONLY (NO NEW PAGES)

**ABSOLUTE RULE:**
- NO STRUCTURAL CHANGES before Week 3 unless technical failure detected

---

## PHASE 4 — EXPANSION GATE (LOCKED)

**EXPANSION PERMITTED ONLY IF:**
- ✅ Norwich page receives clicks, OR
- ✅ Average position improves by ≥20, OR
- ✅ At least one form submission occurs

**IF CONDITIONS MET:**
- NEXT CITY 1: London
- NEXT CITY 2: San Francisco
- SAME STRUCTURE, SAME RULES, NO VARIATION

**IF CONDITIONS NOT MET:**
- ❌ DO NOT CREATE NEW CITY PAGES
- ✅ ADJUST COPY ONLY
- ✅ MAINTAIN CURRENT FOOTPRINT

**PROHIBITED UNTIL PHASE 2 COMPLETION:**
- ❌ Blackpool
- ❌ Singapore
- ❌ Any additional geo targets

---

## OPTIONAL LOW-RISK OPTIMIZATION

✅ **Implemented:** Single footer line on Norwich page
- Text: "Not in Norwich? We also work with companies across the UK and United States."
- One sentence only ✅
- No additional cities ✅
- No new schema implications ✅

---

## FINAL GOVERNANCE STATEMENT

This deployment is:
- ✅ Correctly scoped
- ✅ Data-driven
- ✅ Low-risk
- ✅ Conversion-aware

**No overbuilding permitted.**  
**No panic changes permitted.**  
**No noise chasing permitted.**

**This node is now a VALIDATION NODE.**  
**All future geo expansion is subordinate to its performance.**

---

## VALIDATION CHECKLIST

- [x] Structural integrity verified
- [x] Geo compliance verified
- [x] Schema discipline verified
- [x] Internal linking hierarchy verified
- [x] Technical checks passed
- [x] Sitemap updated
- [x] Monitoring protocol documented
- [x] Expansion gate locked

**STATUS: READY FOR MONITORING PHASE**

