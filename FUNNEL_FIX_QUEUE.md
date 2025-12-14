# FUNNEL FIX QUEUE — P0/P1/P2 Priority Ranking

**Date:** 2025-01-27  
**Source:** Pages.csv, Queries.csv, Countries.csv analysis  
**Goal:** Convert high-impression pages into lead-producing assets

---

## EVIDENCE SUMMARY

### Top Demand Markets:
- **United States:** 7,223 impressions, 6 clicks, avg position 61.32
- **United Kingdom:** 1,443 impressions, 4 clicks, avg position 46.73
- **Canada:** 443 impressions, 2 clicks, avg position 44.65

### Top Query Patterns (All 0% CTR):
- UK city "SEO + City" terms: "seo norwich" (344 imp), "seo stockport" (344 imp), "seo stoke" (313 imp), "seo derby" (294 imp), "seo southport" (293 imp), "seo huddersfield" (282 imp)
- All resolving to **en-us** pages when they should be **en-gb**

### Critical Issue:
UK city queries are landing on **en-us** service pages, causing:
- Weak relevance signals (US locale for UK queries)
- Duplicate content across locales (fr-fr, es-es, de-de, ko-kr versions of UK cities)
- Zero conversions (0% CTR on all top queries)

---

## P0 — FIX THIS WEEK (HIGHEST IMPRESSIONS, ZERO CLICKS)

### P0-1: https://nrlc.ai/en-us/services/semantic-seo-ai/stoke-on-trent/
**Metrics:** 709 impressions, 0 clicks, position 77.55  
**Query Match:** "seo stoke" (313 imp), "seo stoke on trent" (132 imp), "seo services stoke on trent" (84 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/semantic-seo-ai/stoke-on-trent/` → `/en-gb/services/local-seo-ai/stoke-on-trent/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/stoke-on-trent/`
3. **Meta Title:** "Local SEO in Stoke-on-Trent | NRLC.ai"
4. **Meta Description:** "Local SEO for Stoke-on-Trent businesses. Technical fixes, GBP optimization, content that ranks, and measurable leads. Call or email to talk."
5. **H1:** "Local SEO in Stoke-on-Trent"
6. **Above-fold CTA:** Call | Email | Book a Call (sticky on mobile)
7. **Add FAQ section** (visible on-page) with FAQPage schema
8. **Internal links:** Add from Insights hub + relevant articles

---

### P0-2: https://nrlc.ai/en-us/services/local-seo-ai/norwich/
**Metrics:** 703 impressions, 0 clicks, position 62.38  
**Query Match:** "seo norwich" (344 imp), "norwich seo" (279 imp), "seo services norwich" (216 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/local-seo-ai/norwich/` → `/en-gb/services/local-seo-ai/norwich/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/norwich/`
3. **Meta Title:** "Local SEO in Norwich | NRLC.ai"
4. **Meta Description:** "Local SEO for Norwich businesses. Technical fixes, GBP optimization, content that ranks, and measurable leads. Call or email to talk."
5. **H1:** "Local SEO in Norwich"
6. **Above-fold CTA:** Call | Email | Book a Call (sticky on mobile)
7. **Add FAQ section** (visible on-page) with FAQPage schema
8. **Internal links:** Add from Insights hub + relevant articles

---

### P0-3: https://nrlc.ai/en-us/services/chatgpt-optimization/southport/
**Metrics:** 364 impressions, 0 clicks, position 50.26  
**Query Match:** "seo southport" (293 imp), "search engine optimisation southport" (253 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/chatgpt-optimization/southport/` → `/en-gb/services/local-seo-ai/southport/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/southport/`
3. **Meta Title:** "Local SEO in Southport | NRLC.ai"
4. **Meta Description:** "Local SEO for Southport businesses. Technical fixes, GBP optimization, content that ranks, and measurable leads. Call or email to talk."
5. **H1:** "Local SEO in Southport"
6. **Above-fold CTA:** Call | Email | Book a Call (sticky on mobile)
7. **Add FAQ section** (visible on-page) with FAQPage schema
8. **Internal links:** Add from Insights hub + relevant articles

---

### P0-4: https://nrlc.ai/en-us/services/voice-search-optimization/derby/
**Metrics:** 364 impressions, 0 clicks, position 89.96  
**Query Match:** "seo derby" (294 imp), "derby seo" (69 imp), "search engine optimisation companies derby" (67 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/voice-search-optimization/derby/` → `/en-gb/services/local-seo-ai/derby/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/derby/`
3. **Meta Title:** "Local SEO in Derby | NRLC.ai"
4. **Meta Description:** "Local SEO for Derby businesses. Technical fixes, GBP optimization, content that ranks, and measurable leads. Call or email to talk."
5. **H1:** "Local SEO in Derby"
6. **Above-fold CTA:** Call | Email | Book a Call (sticky on mobile)
7. **Add FAQ section** (visible on-page) with FAQPage schema
8. **Internal links:** Add from Insights hub + relevant articles

---

### P0-5: https://nrlc.ai/en-us/insights/open-seo-tools/
**Metrics:** 262 impressions, 0 clicks, position 57.27  
**Query Match:** "best open source seo software" (189 imp), "open source seo platform" (183 imp)

**Actions:**
1. **Convert to lead magnet:** Add gated download (PDF guide) with email capture
2. **Meta Title:** "Open Source SEO Tools: What Works + How to Implement | NRLC.ai"
3. **Meta Description:** "A practical breakdown of open source SEO tools with steps, examples, and a direct path to implementation. If you want this done, call or email."
4. **H1:** "Open Source SEO Tools: What Works + How to Implement"
5. **Above-fold CTA:** Download Guide (email capture) | Call | Email
6. **Add mid-article CTA:** Link to "Technical SEO audit and fixes" service
7. **Add bottom CTA block:** Call/Email with "Work with me" section

---

## P1 — FIX NEXT WEEK (HIGH IMPRESSIONS, LOW CTR)

### P1-1: https://nrlc.ai/fr-fr/services/conversion-optimization-ai/stockport/
**Metrics:** 320 impressions, 0 clicks, position 81.61  
**Query Match:** "seo stockport" (344 imp), "stockport seo" (111 imp)

**Actions:**
1. **301 Redirect:** `/fr-fr/services/conversion-optimization-ai/stockport/` → `/en-gb/services/local-seo-ai/stockport/`
2. **Same as P0-1 through P0-4** (create en-gb canonical with Local SEO focus)

---

### P1-2: https://nrlc.ai/en-us/services/llm-content-strategy/norwich/
**Metrics:** 212 impressions, 0 clicks, position 94.44  
**Query Match:** "seo norwich" (344 imp), "norwich seo" (279 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/llm-content-strategy/norwich/` → `/en-gb/services/local-seo-ai/norwich/`
2. **Consolidate to P0-2** (same canonical target)

---

### P1-3: https://nrlc.ai/en-us/services/verification-optimization-ai/blackpool/
**Metrics:** 183 impressions, 0 clicks, position 44.75  
**Query Match:** "seo blackpool" (253 imp), "best seo blackpool" (129 imp), "seo services blackpool" (68 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/verification-optimization-ai/blackpool/` → `/en-gb/services/local-seo-ai/blackpool/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/blackpool/`
3. **Apply same template as P0 pages**

---

### P1-4: https://nrlc.ai/en-gb/services/international-seo/huddersfield/
**Metrics:** 173 impressions, 0 clicks, position 75.86  
**Query Match:** "seo huddersfield" (282 imp), "huddersfield seo" (71 imp)

**Actions:**
1. **Keep en-gb** (already correct locale)
2. **Change service type:** `/en-gb/services/international-seo/huddersfield/` → `/en-gb/services/local-seo-ai/huddersfield/`
3. **Apply same template as P0 pages**

---

### P1-5: https://nrlc.ai/en-us/services/generative-seo/halifax/
**Metrics:** 153 impressions, 0 clicks, position 80.35  
**Query Match:** "seo halifax" (135 imp), "seo services halifax" (99 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/generative-seo/halifax/` → `/en-gb/services/local-seo-ai/halifax/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/halifax/`
3. **Apply same template as P0 pages**

---

## P2 — FIX THIS MONTH (MEDIUM IMPRESSIONS, NEED OPTIMIZATION)

### P2-1: https://nrlc.ai/en-us/services/link-building-ai/southampton/
**Metrics:** 128 impressions, 0 clicks, position 14.84  
**Query Match:** "link building strategies in southampton" (67 imp), "link building strategies southampton" (55 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/link-building-ai/southampton/` → `/en-gb/services/link-building-ai/southampton/`
2. **Create en-gb canonical:** `/en-gb/services/link-building-ai/southampton/`
3. **Meta Title:** "Link Building in Southampton | NRLC.ai"
4. **Meta Description:** "Link building for Southampton businesses. Technical fixes, citation building, content that ranks, and measurable leads. Call or email to talk."
5. **Apply conversion template**

---

### P2-2: https://nrlc.ai/en-us/services/bard-optimization/huddersfield/
**Metrics:** 126 impressions, 0 clicks, position 69.83  
**Query Match:** "seo huddersfield" (282 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/bard-optimization/huddersfield/` → `/en-gb/services/local-seo-ai/huddersfield/`
2. **Consolidate to P1-4** (same canonical target)

---

### P2-3: https://nrlc.ai/en-us/services/ai-search-optimization/oldham/
**Metrics:** 124 impressions, 0 clicks, position 53.02  
**Query Match:** "seo oldham" (148 imp)

**Actions:**
1. **301 Redirect:** `/en-us/services/ai-search-optimization/oldham/` → `/en-gb/services/local-seo-ai/oldham/`
2. **Create en-gb canonical:** `/en-gb/services/local-seo-ai/oldham/`
3. **Apply same template as P0 pages**

---

## CONVERSION TEMPLATE REQUIREMENTS (ALL P0/P1/P2 PAGES)

### Above the Fold:
1. **H1:** Exact match query phrasing (e.g., "Local SEO in Norwich")
2. **Subhead:** "Rank in Maps + organic, convert calls, and fix the technical issues that block leads."
3. **CTA Row:** Call | Email | Book a Call (all visible, no hiding)
4. **Proof Strip:** "GBP, citations, technical audits, content strategy, reporting"

### Body Sections (Order):
1. What you get in 30 days (bullets)
2. The problems we fix (crawl/indexing, GBP, reviews, citations, content)
3. The process (Audit → Fix → Build → Track)
4. Proof / credibility (tools + approach + case snippet)
5. Pricing expectation (range or "project-based, starts at…")
6. FAQ (visible questions only, with FAQPage schema)
7. Final CTA block (repeat Call/Email)

### UI Requirements:
- **Sticky CTA:** Mobile (fixed bottom bar) + Desktop (sticky right rail "Talk to Joel" card)
- **Contact card:** Real email/phone + timezone + "Response time: within 24 hours"
- **No generic CTAs:** Ban "Learn more" as primary CTA

---

## LOCALE CONSOLIDATION PRIORITY

### Immediate (P0):
- All UK city pages currently in **en-us** → redirect to **en-gb**
- All UK city pages in **fr-fr**, **es-es**, **de-de**, **ko-kr** → redirect to **en-gb**

### Next Phase (P1):
- Create **en-gb** equivalents for all UK cities in Queries.csv:
  - Norwich, Stockport, Stoke-on-Trent, Derby, Southport, Huddersfield, Blackpool, Burnley, Oldham, Halifax, Sudbury, Nottingham, Sheffield, Southampton

### Canonical Rules:
- UK city queries → **en-gb** canonical
- US city queries → **en-us** canonical
- Self-referencing canonicals only (no cross-canonical)

---

## INTERNAL LINKING STRATEGY

### From Insights Hub:
- Add "Start here" section with 3-5 pillar articles
- Add "Work with me" block linking to top services (Local SEO in Norwich, etc.)

### From Individual Insights Articles:
- One mid-article contextual link to relevant service
- One bottom CTA block with Call/Email
- Anchor text: "Local SEO in Norwich", "Technical SEO audit and fixes", etc.

---

## VERIFICATION CHECKLIST (PER P0 PAGE)

- [ ] View-source: unique `<title>`, unique meta description
- [ ] View-source: canonical self-referencing, og:url equals canonical
- [ ] Mobile: Above-fold CTA (Call/Email) visible without scrolling
- [ ] Desktop: Sticky right rail CTA visible
- [ ] Non-canonical locale versions: 301 redirect to canonical en-gb
- [ ] Search Console: Queries map to correct locale page
- [ ] FAQ section visible on-page (if FAQPage schema is used)

---

**END OF FUNNEL FIX QUEUE**

