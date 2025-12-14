# GLOBAL PAGE PRIORITY MAP

**Which GLOBAL pages should exist before translation starts.**

This map ensures you translate the right pages in the right order.

---

## TIER 1 — REVENUE DRIVERS (TRANSLATE FIRST)

### Priority Order

#### 1. `/services/technical-seo/` ✅ CURRENT PILOT
- **Status:** Active pilot (en-us, en-gb)
- **Why First:** Core service, high search volume, proven demand
- **Translation Priority:** HIGH
- **Next Step:** Add non-English locale (de-de or es-es)

#### 2. `/services/schema-markup/`
- **Status:** Ready for translation
- **Why Second:** High technical SEO demand, clear differentiation
- **Translation Priority:** HIGH
- **Prerequisites:** 
  - [ ] Source page optimized
  - [ ] Meta tags finalized
  - [ ] H1/CTA aligned

#### 3. `/services/ai-search-optimization/`
- **Status:** Ready for translation
- **Why Third:** Emerging market, thought leadership opportunity
- **Translation Priority:** HIGH
- **Prerequisites:**
  - [ ] Source page optimized
  - [ ] Meta tags finalized
  - [ ] H1/CTA aligned

#### 4. `/services/crawlability-indexing/`
- **Status:** Ready for translation
- **Why Fourth:** Technical depth, enterprise appeal
- **Translation Priority:** MEDIUM-HIGH
- **Prerequisites:**
  - [ ] Source page optimized
  - [ ] Meta tags finalized
  - [ ] H1/CTA aligned

#### 5. `/services/enterprise-seo/`
- **Status:** Ready for translation
- **Why Fifth:** High-value segment, longer sales cycle
- **Translation Priority:** MEDIUM-HIGH
- **Prerequisites:**
  - [ ] Source page optimized
  - [ ] Meta tags finalized
  - [ ] H1/CTA aligned

---

## TIER 2 — TRUST & AUTHORITY (TRANSLATE AFTER TIER 1)

### Priority Order

#### 1. `/en-us/` (Homepage)
- **Status:** Ready for translation
- **Why First:** First impression, brand authority
- **Translation Priority:** MEDIUM
- **Prerequisites:**
  - [ ] Tier 1 pages translated and stable
  - [ ] Homepage copy follows Global Copy Rules
  - [ ] CTAs are global-neutral

#### 2. `/about/`
- **Status:** Ready for translation
- **Why Second:** Trust building, company story
- **Translation Priority:** MEDIUM
- **Prerequisites:**
  - [ ] Homepage translated and stable
  - [ ] About page copy follows Global Copy Rules

#### 3. `/contact/`
- **Status:** Ready for translation
- **Why Third:** Conversion path, global accessibility
- **Translation Priority:** MEDIUM
- **Prerequisites:**
  - [ ] About page translated and stable
  - [ ] Contact form supports multiple locales

#### 4. `/case-studies/` (Hub Page)
- **Status:** Ready for translation
- **Why Fourth:** Social proof, conversion support
- **Translation Priority:** MEDIUM-LOW
- **Prerequisites:**
  - [ ] Individual case studies may not need translation
  - [ ] Hub page structure follows Global Copy Rules

---

## TIER 3 — THOUGHT LEADERSHIP (TRANSLATE SELECTIVELY)

### Strategy

**Do NOT translate all insights articles.**

**Only translate insights that:**
1. Have proven SEO value (high impressions/clicks)
2. Support Tier 1 service page conversions
3. Have clear global appeal (not US-specific)
4. Demonstrate thought leadership

### Priority Criteria

#### High Priority Insights
- [ ] Article ranks in top 10 for target keywords
- [ ] Article drives conversions to service pages
- [ ] Article has evergreen value
- [ ] Article supports global positioning

#### Low Priority Insights
- [ ] Article is US-specific
- [ ] Article has low search volume
- [ ] Article is time-sensitive
- [ ] Article doesn't support conversions

### Example High-Priority Insights
- `/insights/open-seo-tools/` (if high-performing)
- `/insights/structured-data-guide/` (if high-performing)
- `/insights/ai-search-optimization/` (if high-performing)

---

## PAGE READINESS CHECKLIST

**Before translating ANY page, verify:**

### Content Readiness
- [ ] Page follows Global Copy Rules
- [ ] No country-specific references
- [ ] No idioms or slang
- [ ] Clear structure: Problem → Diagnosis → Method → Proof → CTA
- [ ] Intent-stable headings

### SEO Readiness
- [ ] Meta title: 50-60 chars, unique
- [ ] Meta description: 150-165 chars, unique
- [ ] H1 matches title intent
- [ ] Canonical is self-referencing
- [ ] Canonical == og:url

### CTA Readiness
- [ ] CTA is global-neutral
- [ ] No city-specific references
- [ ] CTA matches description promise
- [ ] CTA visible above fold

### Technical Readiness
- [ ] Page is indexable
- [ ] No redirect chains
- [ ] Internal links point to canonical URLs
- [ ] Schema markup valid (if applicable)

---

## TRANSLATION ORDER MATRIX

### Q1 2025
- ✅ `/services/technical-seo/` (en-us, en-gb) — PILOT

### Q2 2025
- `/services/technical-seo/` (add de-de or es-es)

### Q3 2025
- `/services/schema-markup/` (en-us, en-gb, de-de/es-es)
- `/services/ai-search-optimization/` (en-us, en-gb, de-de/es-es)
- `/services/crawlability-indexing/` (en-us, en-gb, de-de/es-es)
- `/services/enterprise-seo/` (en-us, en-gb, de-de/es-es)

### Q4 2025
- `/en-us/` (Homepage) (en-us, en-gb, de-de/es-es)
- `/about/` (en-us, en-gb, de-de/es-es)
- `/contact/` (en-us, en-gb, de-de/es-es)
- `/case-studies/` (en-us, en-gb, de-de/es-es)

### 2026
- High-performing insights articles (selective)

---

## PAGES TO NEVER TRANSLATE

**These pages are LOCAL-only and must NEVER be translated:**

- `/services/local-seo-ai/{city}/`
- `/services/{service}/{city}/`
- `/careers/{city}/{role}/`

**Reason:** These pages are geographically anchored. Translation would create duplicate content and confuse search engines.

---

## DECISION TREE

```
Is the page GLOBAL or LOCAL?
│
├─ LOCAL → Never translate, never hreflang
│
└─ GLOBAL → Check priority:
    │
    ├─ Tier 1 Revenue Driver? → Translate first
    │
    ├─ Tier 2 Trust & Authority? → Translate after Tier 1
    │
    └─ Tier 3 Thought Leadership? → Translate selectively
```

---

**Current Status:** Tier 1, Page 1 (technical-seo) in pilot
**Next Page:** technical-seo (add non-English locale)
**Then:** schema-markup (Tier 1, Page 2)

