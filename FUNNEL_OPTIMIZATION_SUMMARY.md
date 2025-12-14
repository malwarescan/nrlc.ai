# FUNNEL OPTIMIZATION KERNEL — EXECUTIVE SUMMARY

**Date:** 2025-01-27  
**Status:** ✅ **DELIVERABLES COMPLETE**

---

## CRITICAL FINDINGS

### 1. Locale Mismatch Crisis
- **Problem:** UK city queries ("seo norwich", "seo stockport", etc.) are landing on **en-us** pages
- **Impact:** 0% CTR on all top UK city queries (2,000+ impressions, 0 clicks)
- **Root Cause:** Service pages generated without locale-aware routing

### 2. Duplicate Content Factory
- **Problem:** Same UK cities appear across multiple locales (en-us, fr-fr, es-es, de-de, ko-kr)
- **Impact:** Search Console shows duplicate content warnings, weak relevance signals
- **Example:** Norwich appears in 5+ locale variants, all competing for same queries

### 3. Missing Conversion Elements
- **Problem:** High-impression service pages lack above-fold CTAs (Call/Email)
- **Impact:** Users can't contact you even if they want to
- **Evidence:** 709 impressions on Stoke-on-Trent page, 0 clicks, 0 conversions

---

## DELIVERABLES CREATED

### ✅ 1. FUNNEL_FIX_QUEUE.md
- **P0 (Fix This Week):** 5 pages with 1,000+ combined impressions, 0 clicks
- **P1 (Fix Next Week):** 5 pages with 500+ combined impressions, 0 clicks
- **P2 (Fix This Month):** Additional pages needing optimization
- **Each entry includes:** Exact redirect targets, meta title/description, H1, CTA requirements

### ✅ 2. QUERY_TO_PAGE_MAP.csv
- **544 rows** mapping queries to intent, target locale, canonical URL
- **Columns:** Query | Intent | Target Locale | Canonical URL | Current URL(s) | Action
- **Key Insight:** 90%+ of UK city queries should route to **en-gb**, not **en-us**

### ✅ 3. META_PATCH_PLAN.csv
- **Meta updates** for all high-impression service pages (100+ impressions)
- **Columns:** URL | Current Title | New Title | Current Desc | New Desc | H1 | Primary CTA Text
- **Formula Applied:** UK cities → "Local SEO in {City} | NRLC.ai"

### ✅ 4. LOCALE_CANONICALIZATION_PLAN.md
- **Redirect rules** for UK city pages (en-us → en-gb, fr-fr → en-gb, etc.)
- **Implementation code** for `bootstrap/canonical.php`
- **Verification checklist** for each redirect

---

## TOP 5 PRIORITY FIXES (P0)

1. **Stoke-on-Trent** (709 imp, 0 clicks)
   - Redirect: `/en-us/services/semantic-seo-ai/stoke-on-trent/` → `/en-gb/services/local-seo-ai/stoke-on-trent/`
   - Title: "Local SEO in Stoke-on-Trent | NRLC.ai"

2. **Norwich** (703 imp, 0 clicks)
   - Redirect: `/en-us/services/local-seo-ai/norwich/` → `/en-gb/services/local-seo-ai/norwich/`
   - Title: "Local SEO in Norwich | NRLC.ai"

3. **Southport** (364 imp, 0 clicks)
   - Redirect: `/en-us/services/chatgpt-optimization/southport/` → `/en-gb/services/local-seo-ai/southport/`
   - Title: "Local SEO in Southport | NRLC.ai"

4. **Derby** (364 imp, 0 clicks)
   - Redirect: `/en-us/services/voice-search-optimization/derby/` → `/en-gb/services/local-seo-ai/derby/`
   - Title: "Local SEO in Derby | NRLC.ai"

5. **Open SEO Tools** (262 imp, 0 clicks)
   - Convert to lead magnet with email capture
   - Title: "Open Source SEO Tools: What Works + How to Implement | NRLC.ai"

---

## CONVERSION TEMPLATE REQUIREMENTS

### Above the Fold (All Service Pages):
```
H1: "Local SEO in {City}" (exact match query)
Subhead: "Rank in Maps + organic, convert calls, and fix the technical issues that block leads."
CTA Row: [Call] [Email] [Book a Call] (all visible, no hiding)
Proof Strip: "GBP, citations, technical audits, content strategy, reporting"
```

### Body Sections (Order):
1. What you get in 30 days (bullets)
2. The problems we fix (crawl/indexing, GBP, reviews, citations, content)
3. The process (Audit → Fix → Build → Track)
4. Proof / credibility (tools + approach + case snippet)
5. Pricing expectation (range or "project-based, starts at…")
6. FAQ (visible questions only, with FAQPage schema)
7. Final CTA block (repeat Call/Email)

### UI Requirements:
- **Mobile:** Fixed bottom bar with Call + Email
- **Desktop:** Sticky right rail "Talk to Joel" card
- **Contact card:** Real email/phone + timezone + "Response time: within 24 hours"

---

## META DIRECTIVE RULES

### UK Local SEO Pages (en-gb):
- **Title:** "Local SEO in {City} | NRLC.ai"
- **Description:** "Local SEO for {City} businesses. Technical fixes, GBP optimization, content that ranks, and measurable leads. Call or email to talk." (155-165 chars)

### AI SEO Service Pages (Non-City):
- **Title:** "{Service Name} | AI Search Optimization | NRLC.ai"
- **Description:** "Improve visibility across Google and AI-driven search with structured data, indexing integrity, and intent-aligned content. Call or email."

### Insights Articles (Funnel):
- **Title:** "{Topic}: What Works + How to Implement | NRLC.ai"
- **Description:** "A practical breakdown with steps, examples, and a direct path to implementation. If you want this done, call or email."

---

## STRUCTURED DATA RULES

### Service Pages:
- ✅ BreadcrumbList (required)
- ✅ Organization (site-wide, reuse)
- ✅ FAQPage schema (only if FAQ visible on-page)
- ❌ ProfessionalService / LocalBusiness (only if real business address/service area displayed)

### Homepage / Insights Hub:
- ✅ Keep current minimal base schemas (Organization, WebSite, BreadcrumbList)
- ❌ No FAQPage on hubs

---

## INTERNAL LINKING STRATEGY

### From Insights Hub:
- Add "Start here" section with 3-5 pillar articles
- Add "Work with me" block linking to top services

### From Individual Insights Articles:
- One mid-article contextual link to relevant service
- One bottom CTA block with Call/Email
- Anchor text: "Local SEO in Norwich", "Technical SEO audit and fixes", etc.

---

## IMPLEMENTATION PRIORITY

### Phase 1 (This Week — P0):
1. Implement UK city redirect logic in `bootstrap/canonical.php`
2. Create en-gb canonical pages for top 5 UK cities
3. Add above-fold CTAs to all P0 pages
4. Update meta titles/descriptions via router

### Phase 2 (Next Week — P1):
1. Create en-gb canonical pages for remaining UK cities
2. Apply conversion template to all P1 pages
3. Update internal links to point to canonical URLs

### Phase 3 (This Month — P2):
1. Audit all service pages for locale mismatches
2. Consolidate duplicate content
3. Update hreflang tags to reflect real translations only

---

## VERIFICATION CHECKLIST

For each P0 page:
- [ ] View-source: unique `<title>`, unique meta description
- [ ] View-source: canonical self-referencing, og:url equals canonical
- [ ] Mobile: Above-fold CTA (Call/Email) visible without scrolling
- [ ] Desktop: Sticky right rail CTA visible
- [ ] Non-canonical locale versions: 301 redirect to canonical en-gb
- [ ] Search Console: Queries map to correct locale page

---

## EXPECTED OUTCOMES

### Short Term (1-2 weeks):
- UK city queries route to correct en-gb pages
- CTR improvement on top 5 P0 pages (target: 2-5% from 0%)
- Reduced duplicate content warnings in Search Console

### Medium Term (1-2 months):
- All high-impression service pages have conversion elements
- Internal linking drives traffic from Insights to Services
- Search Console shows improved query-to-page mapping

### Long Term (3-6 months):
- Measurable lead generation from organic search
- Reduced bounce rate on service pages (users can contact you)
- Improved rankings for UK city queries (better relevance signals)

---

## STOP CONDITIONS (MUST NOT SHIP IF ANY TRUE)

- ❌ Any UK city query resolves to en-us as canonical
- ❌ Any duplicated locale page remains indexable without real translation
- ❌ Any high-impression service page lacks above-fold Call/Email CTA
- ❌ Any page reuses descriptions at scale

---

**END OF FUNNEL OPTIMIZATION SUMMARY**

