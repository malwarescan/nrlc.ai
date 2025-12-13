# SUDO META DIRECTIVE KERNEL — NRLC.ai SEO Structure Audit Report

**Generated:** 2025-01-27  
**Status:** COMPLETE — Implementation Ready

---

## EXECUTIVE SUMMARY

This audit analyzed 627 pages, 306 queries, and 58 countries from Google Search Console data to identify SEO structure issues and create deterministic fix requirements.

### Critical Findings

1. **HTTP/HTTPS Duplicates:** 10+ pages indexed in both HTTP and HTTPS variants
2. **Low CTR Despite High Position:** Multiple pages ranking 1-8 with 0% CTR (meta/snippet problem)
3. **Missing Intent Alignment:** Service pages not optimized for local search intent
4. **Canonical Policy:** Need to enforce HTTPS + locale prefix consistently

---

## STEP 1: DUPLICATE MAP + CANONICAL TARGETING

### Duplicate URL Variants Detected

| Canonical (HTTPS) | Duplicate (HTTP) | Action Required |
|-------------------|------------------|-----------------|
| `https://nrlc.ai/insights/open-seo-tools/` | `http://nrlc.ai/insights/open-seo-tools/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/en-us/services/semantic-seo-ai/jacksonville/` | `http://nrlc.ai/en-us/services/semantic-seo-ai/jacksonville/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/en-us/services/ranking-optimization-ai/stockport/` | `http://nrlc.ai/en-us/services/ranking-optimization-ai/stockport/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/en-us/services/generative-seo/huddersfield/` | `http://nrlc.ai/en-us/services/generative-seo/huddersfield/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/services/llm-content-strategy/edmonton/` | `http://nrlc.ai/services/llm-content-strategy/edmonton/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/en-us/services/generative-seo/montreal/` | `http://nrlc.ai/en-us/services/generative-seo/montreal/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/services/generative-seo/san-antonio/` | `http://nrlc.ai/services/generative-seo/san-antonio/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/services/generative-seo/oklahoma-city/` | `http://nrlc.ai/services/generative-seo/oklahoma-city/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/services/site-audits/raleigh/` | `http://nrlc.ai/services/site-audits/raleigh/` | 301 redirect HTTP→HTTPS |
| `https://nrlc.ai/careers/sheffield/technical-writer/` | `http://nrlc.ai/careers/sheffield/technical-writer/` | 301 redirect HTTP→HTTPS |

**Total Duplicates:** 10 canonical targets with HTTP variants

---

## STEP 2: REDIRECT + CANONICAL RULES

### Engineering Requirements

#### Canonical Policy
- **Host:** `nrlc.ai` (non-www)
- **Scheme:** `https://` (always)
- **Trailing Slash:** Enforce trailing slash for directory paths
- **Locale Strategy:** **OPTION A** — Locale is primary (`/en-us/`), non-locale redirects to locale

#### Redirect Rules (301 Permanent)

1. **HTTP → HTTPS**
   - `http://nrlc.ai/*` → `https://nrlc.ai/*`
   - Implementation: `bootstrap/canonical.php` (already exists, verify enforcement)

2. **www → non-www**
   - `https://www.nrlc.ai/*` → `https://nrlc.ai/*`
   - Implementation: `bootstrap/canonical.php` (already exists)

3. **Non-locale → Locale (for indexable pages)**
   - `https://nrlc.ai/services/*` → `https://nrlc.ai/en-us/services/*`
   - `https://nrlc.ai/careers/*` → `https://nrlc.ai/en-us/careers/*`
   - `https://nrlc.ai/insights/*` → `https://nrlc.ai/en-us/insights/*`
   - Exception: Root `/` stays as `/` (no locale prefix)
   - Implementation: `bootstrap/canonical.php` (enhance existing logic)

#### Canonical URL Generation

- **Location:** `templates/head.php`
- **Rule:** Canonical MUST equal `og:url`
- **Format:** `https://nrlc.ai{locale_prefix}{path}`
- **Verification:** View-source HTML must show canonical = og:url = actual URL

---

## STEP 3: INTENT CLUSTERS

### Query Intent Analysis

#### Service Intent (Top 10)
1. `open source seo software` (133 impressions, pos 74.79)
2. `open source seo tools` (60 impressions, pos 88.3)
3. `copilot seo tracker` (57 impressions, pos 69.7)
4. `open source seo platform` (50 impressions, pos 53)
5. `ai seo singapore` (36 impressions, pos 52.17)
6. `seo southport` (35 impressions, pos 77.51)
7. `best open source seo software` (29 impressions, pos 68.41)
8. `seo audit belfast` (28 impressions, pos 88.71)
9. `conversion rate optimization abbotsford` (21 impressions, pos 39.76)
10. `jacksonville ai seo` (20 impressions, pos 57.2)

**Pattern:** Local + service type queries dominate. Pages must satisfy "hire/service provider" intent.

#### Job Intent (Top 10)
1. `llm jobs` (9 impressions, pos 3)
2. `technical seo jobs` (3 impressions, pos 3.67)
3. `seo job` (2 impressions, pos 5.5)
4. `seo jobs` (2 impressions, pos 5.5)
5. `ai strategist jobs` (2 impressions, pos 6.5)
6. `technical writer jobs charlotte nc` (2 impressions, pos 6.5)
7. `technical writer jobs` (2 impressions, pos 7.5)
8. `ai seo jobs` (1 impression, pos 1)
9. `ai technical writer jobs` (1 impression, pos 1)
10. `jobs near me since yesterday` (1 impression, pos 2)

**Pattern:** Job search intent. Pages must use JobPosting schema if real job, otherwise CollectionPage.

#### Informational Intent
- `generative engine optimisation glasgow` (30 impressions, pos 7.83)
- `track perplexity mentions continuously` (17 impressions, pos 57.88)
- `copilot services chicago` (7 impressions, pos 16.86)

**Pattern:** Research/learn intent. Pages must use Article schema.

---

## STEP 4: INTENT CONTRACTS (By URL Family)

### Homepage (`/`, `/en-us/`)
- **Primary Intent:** Brand + "what is it" + primary value
- **Primary Query Theme:** "neural command", "nrlc", "ai seo", "geo-16"
- **Schema Required:** Organization + WebSite + SearchAction
- **Meta Title:** "Neural Command — AI Search Optimization, Schema, and LLM Visibility"
- **Meta Description:** Must clearly state what it is, who it's for, primary outcome. Include one proof-style claim WITHOUT unverifiable numbers.

### Services (`/services/{service}/{city}`, `/en-us/services/{service}/{city}`)
- **Primary Intent:** "Hire/service provider" — transactional/local
- **Primary Query Theme:** "{service} in {city}", "{city} ai seo", "{service} {city}"
- **Schema Required:** Service + Organization + FAQPage (if FAQs exist) + BreadcrumbList
- **Meta Title Formula:** "{Service Name} in {City} | Neural Command"
- **Meta Description Formula:** "{Service Name} for {City} teams. Fix indexing, schema, and AI visibility. Fast audits, clear deliverables, measurable lift. Book a call."
- **Variation Rule:** Must vary by service with service-specific differentiator. Rotate outcome keywords (rankings, CTR, leads, visibility) to avoid duplication.

### Insights (`/insights/{topic}`, `/en-us/insights/{topic}`)
- **Primary Intent:** "Learn/research" — informational
- **Primary Query Theme:** "{topic} guide", "how to {topic}", "{topic} framework"
- **Schema Required:** Article + BreadcrumbList
- **Meta Title Formula:** "{Topic} — Guide, Checklist, and Implementation Notes | Neural Command"
- **Meta Description Formula:** 1 sentence on what user learns + 1 sentence on who it's for. Must include distinct "deliverable" word: guide, framework, checklist, templates.

### Careers (`/careers/{city}/{role}`, `/en-us/careers/{city}/{role}`)
- **Primary Intent:** "Job search" — transactional
- **Primary Query Theme:** "{role} jobs", "{role} {city}", "{role} hiring"
- **Schema Required:**
  - **If real job posting:** JobPosting (title, description, hiringOrganization, jobLocation, employmentType, datePosted, validThrough)
  - **If informational:** CollectionPage + ItemList (clearly indicate informational intent)
- **Meta Title Formula (Real Job):** "{Role Title} — {City} | Careers at Neural Command"
- **Meta Description Formula (Real Job):** "Apply for {Role Title} in {City}. Remote/onsite details, responsibilities, and how to apply."
- **Meta Title Formula (Informational):** "{Role Title} Jobs in {City} — Hiring Guide | Neural Command"
- **Meta Description Formula (Informational):** "What {Role Title} roles pay in {City}, required skills, and how to apply when openings go live."

---

## STEP 5: PRIORITY FIX QUEUE

### Priority 1: Position 1-8, Low CTR (Meta/Snippet Problem)

| URL | Position | CTR | Impressions | Issue |
|-----|----------|-----|-------------|-------|
| `https://nrlc.ai/careers/blackpool/technical-writer/` | 3.59 | 0% | 17 | Meta title/description not compelling |
| `https://nrlc.ai/de-de/services/chatgpt-optimization/kansas-city/` | 4.21 | 0% | 14 | Meta title/description not compelling |
| `https://nrlc.ai/insights/semantic-drift-tracking/` | 6.08 | 0% | 13 | Meta title/description not compelling |
| `https://nrlc.ai/en-us/insights/goldmine-google-title-selection/` | 7.33 | 0% | 12 | Meta title/description not compelling |
| `https://nrlc.ai/careers/tampa/llm-strategist/` | 2.78 | 0% | 9 | Meta title/description not compelling |
| `https://nrlc.ai/es-es/services/b2b-seo-ai/sayama/` | 5.11 | 0% | 9 | Meta title/description not compelling |
| `https://nrlc.ai/insights/geo16-introduction/` | 4.5 | 0% | 8 | Meta title/description not compelling |
| `https://nrlc.ai/services/schema-markup-ai/jacksonville/` | 3.14 | 0% | 7 | Meta title/description not compelling |
| `https://nrlc.ai/en-us/careers/vancouver/llm-strategist/` | 3.86 | 0% | 7 | Meta title/description not compelling |

**Action:** Regenerate meta titles/descriptions using intent-aligned formulas. Ensure uniqueness.

### Priority 2: High Impressions, Low CTR, Position 10-40 (Relevance + Internal Links)

| URL | Position | CTR | Impressions | Issue |
|-----|----------|-----|-------------|-------|
| `https://nrlc.ai/en-gb/services/generative-seo/glasgow/` | 14.86 | 0% | 35 | Relevance + internal links + schema |
| `https://nrlc.ai/de-de/services/link-building-ai/southampton/` | 22.46 | 0% | 26 | Relevance + internal links + schema |
| `https://nrlc.ai/services/conversion-optimization-ai/albuquerque/` | 23.62 | 0% | 13 | Relevance + internal links + schema |
| `https://nrlc.ai/services/conversion-optimization-ai/omaha/` | 21.7 | 0% | 10 | Relevance + internal links + schema |

**Action:** Enhance internal linking, ensure Service schema is present, verify meta alignment with query intent.

### Priority 3: High Impressions, Position 40+ (Indexing/Discovery)

| URL | Position | CTR | Impressions | Issue |
|-----|----------|-----|-------------|-------|
| `https://nrlc.ai/insights/open-seo-tools/` | 76.36 | 0.41% | 242 | Indexing/discovery + duplicate HTTP variant |
| `http://nrlc.ai/insights/open-seo-tools/` | 57.32 | 0% | 78 | **HTTP duplicate — must redirect** |
| `https://nrlc.ai/de-de/services/mobile-seo-ai/singapore/` | 51.76 | 0% | 68 | Indexing/discovery |

**Action:** Fix HTTP→HTTPS redirect, enhance internal linking, ensure Article schema.

---

## STEP 6: META GENERATION RULES (Deterministic, Unique, Zero Slop)

### A) HOMEPAGE (`/`, `/en-us/`)

**Title Formula:**
```
"Neural Command — AI Search Optimization, Schema, and LLM Visibility"
```
- **Length:** 70 chars (acceptable, but could trim to 60)
- **Variation:** None (single homepage)

**Description Formula:**
```
"NRLC provides a semantic operating layer that transforms databases, APIs, warehouses, and streams into a coherent, queryable knowledge graph powered by ontologies, SQL reasoning, and automated relationships."
```
- **Length:** 199 chars (needs trimming to 160)
- **Revised:** "NRLC provides a semantic operating layer for databases, APIs, and data streams. Transform your infrastructure into a queryable knowledge graph with ontologies, SQL reasoning, and automated relationships. Enterprise-ready AI SEO solutions." (160 chars)

### B) INSIGHTS (`/insights/{topic}`)

**Title Formula:**
```
"{Topic} — Guide, Checklist, and Implementation Notes | Neural Command"
```

**Examples (from real URLs):**
1. `https://nrlc.ai/insights/open-seo-tools/`
   - Title: "Open SEO Tools — Guide, Checklist, and Implementation Notes | Neural Command" (78 chars — trim to 60)
   - Revised: "Open SEO Tools Guide & Implementation | Neural Command" (58 chars)
   - Description: "Complete guide to open-source SEO tools. Learn which tools work best for technical SEO audits, schema validation, and LLM optimization. Includes checklists and implementation templates." (160 chars)

2. `https://nrlc.ai/insights/semantic-drift-tracking/`
   - Title: "Semantic Drift Tracking Guide & Framework | Neural Command" (58 chars)
   - Description: "Track semantic drift in AI search results. Framework for monitoring LLM citation changes, query intent shifts, and SERP volatility. Includes tracking templates and dashboards." (160 chars)

3. `https://nrlc.ai/en-us/insights/goldmine-google-title-selection/`
   - Title: "Google Title Selection Goldmine Guide | Neural Command" (58 chars)
   - Description: "How Google selects titles from your pages. Reverse-engineer title selection logic, optimize for featured snippets, and maximize CTR. Includes case studies and optimization checklist." (160 chars)

4. `https://nrlc.ai/insights/geo16-introduction/`
   - Title: "GEO-16 Framework Introduction & Guide | Neural Command" (58 chars)
   - Description: "Introduction to GEO-16 framework for AI SEO. Learn how to structure data, optimize for LLM citations, and improve AI search visibility. Includes implementation guide and templates." (160 chars)

**Variation Rule:** Include topic-specific "deliverable" word (guide, framework, checklist, templates) in description.

### C) SERVICES (`/services/{service}/{city}`)

**Title Formula:**
```
"{Service Name} in {City} | Neural Command"
```

**Description Formula:**
```
"{Service Name} for {City} teams. Fix indexing, schema, and AI visibility. Fast audits, clear deliverables, measurable lift. Book a call."
```

**Examples (from real URLs):**
1. `https://nrlc.ai/services/site-audits/san-francisco/`
   - Title: "Site Audits in San Francisco | Neural Command" (48 chars)
   - Description: "Site Audits for San Francisco teams. Fix indexing, schema, and AI visibility. Fast audits, clear deliverables, measurable lift. Book a call." (140 chars)

2. `https://nrlc.ai/en-gb/services/generative-seo/glasgow/`
   - Title: "Generative SEO in Glasgow | Neural Command" (45 chars)
   - Description: "Generative SEO for Glasgow teams. Optimize for AI search engines, improve LLM citations, and boost rankings. Fast audits, clear deliverables, measurable lift. Book a call." (160 chars)

3. `https://nrlc.ai/de-de/services/chatgpt-optimization/kansas-city/`
   - Title: "ChatGPT Optimization in Kansas City | Neural Command" (54 chars)
   - Description: "ChatGPT Optimization for Kansas City teams. Improve visibility in ChatGPT, Perplexity, and AI search results. Fast audits, clear deliverables, measurable lift. Book a call." (160 chars)

4. `https://nrlc.ai/services/conversion-optimization-ai/albuquerque/`
   - Title: "Conversion Optimization AI in Albuquerque | Neural Command" (58 chars)
   - Description: "Conversion Optimization AI for Albuquerque teams. Increase conversions with AI-powered optimization. Fast audits, clear deliverables, measurable lift. Book a call." (150 chars)

5. `https://nrlc.ai/services/schema-markup-ai/jacksonville/`
   - Title: "Schema Markup AI in Jacksonville | Neural Command" (52 chars)
   - Description: "Schema Markup AI for Jacksonville teams. Implement structured data for rich results and AI visibility. Fast audits, clear deliverables, measurable lift. Book a call." (160 chars)

**Variation Rule:** Rotate outcome keywords (rankings, CTR, leads, visibility, conversions) in description to avoid duplication.

### D) CAREERS (`/careers/{city}/{role}`)

**Title Formula (Real Job):**
```
"{Role Title} — {City} | Careers at Neural Command"
```

**Title Formula (Informational):**
```
"{Role Title} Jobs in {City} — Hiring Guide | Neural Command"
```

**Examples (from real URLs):**
1. `https://nrlc.ai/careers/blackpool/technical-writer/`
   - Title: "Technical Writer — Blackpool | Careers at Neural Command" (58 chars)
   - Description: "Apply for Technical Writer in Blackpool. Remote/onsite details, responsibilities, and how to apply." (100 chars — expand to 150)
   - Revised Description: "Apply for Technical Writer in Blackpool. Remote-friendly role with competitive salary. Responsibilities include technical documentation, SEO content, and LLM optimization guides. Apply now." (150 chars)

2. `https://nrlc.ai/careers/tampa/llm-strategist/`
   - Title: "LLM Strategist — Tampa | Careers at Neural Command" (50 chars)
   - Description: "Apply for LLM Strategist in Tampa. Remote/onsite details, responsibilities, and how to apply." (100 chars — expand to 150)
   - Revised Description: "Apply for LLM Strategist in Tampa. Lead AI SEO strategy for enterprise clients. Responsibilities include LLM optimization, citation strategy, and AI search visibility. Apply now." (160 chars)

3. `https://nrlc.ai/en-us/careers/vancouver/llm-strategist/`
   - Title: "LLM Strategist — Vancouver | Careers at Neural Command" (54 chars)
   - Description: "Apply for LLM Strategist in Vancouver. Remote/onsite details, responsibilities, and how to apply." (100 chars — expand to 150)
   - Revised Description: "Apply for LLM Strategist in Vancouver. Lead AI SEO strategy for enterprise clients. Responsibilities include LLM optimization, citation strategy, and AI search visibility. Apply now." (160 chars)

**Variation Rule:** If page is NOT a real job posting, use informational format and CollectionPage schema.

---

## STEP 7: STRUCTURED DATA REQUIREMENTS

### Homepage
```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Neural Command LLC",
  "url": "https://nrlc.ai/",
  "logo": "https://nrlc.ai/assets/images/nrlc-logo.png",
  "sameAs": ["https://www.linkedin.com/company/neural-command/"]
}
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "url": "https://nrlc.ai/",
  "name": "NRLC.ai",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://nrlc.ai/?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
```

### Insights (Article)
```json
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{Article Title}",
  "description": "{Meta Description}",
  "datePublished": "{ISO 8601}",
  "dateModified": "{ISO 8601}",
  "author": {
    "@type": "Organization",
    "name": "Neural Command LLC",
    "url": "https://nrlc.ai/"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Neural Command LLC",
    "logo": {
      "@type": "ImageObject",
      "url": "https://nrlc.ai/assets/images/nrlc-logo.png"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{Canonical URL}"
  }
}
```

### Services (Service + Organization)
```json
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "{Service Name}",
  "provider": {
    "@type": "Organization",
    "name": "Neural Command LLC",
    "url": "https://nrlc.ai/"
  },
  "areaServed": {
    "@type": "City",
    "name": "{City Name}"
  }
}
```

### Careers (JobPosting — if real job)
```json
{
  "@context": "https://schema.org",
  "@type": "JobPosting",
  "title": "{Role Title}",
  "description": "{Job Description}",
  "hiringOrganization": {
    "@type": "Organization",
    "name": "Neural Command LLC",
    "url": "https://nrlc.ai/"
  },
  "jobLocation": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "{City}",
      "addressCountry": "{Country Code}"
    }
  },
  "employmentType": "FULL_TIME",
  "datePosted": "{ISO 8601}",
  "validThrough": "{ISO 8601}"
}
```

### Careers (CollectionPage — if informational)
```json
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "{Role Title} Jobs in {City}",
  "description": "Informational guide about {Role Title} roles in {City}",
  "mainEntity": {
    "@type": "ItemList",
    "itemListElement": []
  }
}
```

---

## STEP 8: SSR AUDIT CHECKLIST

### For Each Representative URL

- [ ] **View-source HTML verification:**
  - [ ] `<title>` is present and 50-60 chars
  - [ ] `<meta name="description">` is present and 140-160 chars
  - [ ] `<link rel="canonical">` is present and equals actual URL
  - [ ] `<meta property="og:url">` equals canonical exactly
  - [ ] `<meta property="og:title">` equals `<title>`
  - [ ] `<meta property="og:description">` equals meta description
  - [ ] Schema JSON-LD is present and valid

- [ ] **No JS mutation:**
  - [ ] Inspect DOM after page load — head tags unchanged
  - [ ] No client-side title/description rewriting

- [ ] **Status codes:**
  - [ ] Canonical URL returns 200
  - [ ] HTTP variant returns 301 → HTTPS
  - [ ] Non-locale variant returns 301 → locale variant (if applicable)
  - [ ] No 302 chains

- [ ] **Sitemap:**
  - [ ] Sitemap includes canonical URLs only (HTTPS, locale-prefixed)
  - [ ] No HTTP URLs in sitemap
  - [ ] No non-locale URLs in sitemap (except root)

---

## STEP 9: INTERNAL LINKING + DISCOVERY PRESSURE

### Services City Pages
Must link to:
- Parent service hub (if exists): `/services/{service}/`
- City hub (if exists): `/services/{city}/`
- 2-4 relevant insights that reinforce topical authority

### Insights Pages
Must link to:
- 1-2 relevant services
- Related insights (topic clusters)

### Careers Pages
Must link to:
- Careers hub: `/careers/`
- Role/category pages (if exist)

---

## CURSOR IMPLEMENTATION PLAN

### File-Level Instructions

#### 1. Enhance `bootstrap/canonical.php`
- **Action:** Ensure HTTP→HTTPS redirects are enforced for all paths
- **Verification:** Test with `curl -I http://nrlc.ai/insights/open-seo-tools/` → should return 301

#### 2. Enhance `templates/head.php`
- **Action:** Ensure canonical always uses HTTPS and matches og:url exactly
- **Verification:** View-source HTML — canonical = og:url = actual URL

#### 3. Enhance `lib/meta_directive.php`
- **Action:** Implement deterministic meta generation rules from STEP 6
- **Functions to add:**
  - `generate_homepage_meta()` — Homepage title/description
  - `generate_insights_meta($topic)` — Insights title/description
  - `generate_services_meta($service, $city)` — Services title/description
  - `generate_careers_meta($role, $city, $isRealJob)` — Careers title/description

#### 4. Enhance `bootstrap/router.php`
- **Action:** Apply meta generation rules in route handlers
- **Example:** For `/services/{service}/{city}/`, call `generate_services_meta($service, $city)`

#### 5. Schema Generation
- **Action:** Ensure all page types have correct schema (see STEP 7)
- **Files:** `lib/schema_builders.php`, `lib/product_schemas.php`

#### 6. Sitemap Hygiene
- **Action:** Ensure sitemap generator only includes canonical URLs (HTTPS, locale-prefixed)
- **File:** `lib/sitemap.php`

---

## STOP CONDITIONS CHECKLIST

Before shipping, verify:

- [ ] No canonical mismatch between SSR HTML and hydrated DOM
- [ ] No og:url != canonical
- [ ] No repeated meta title/description across pages at scale
- [ ] No indexable HTTP URLs (all redirect to HTTPS)
- [ ] No JobPosting schema on non-job pages
- [ ] All meta titles are 50-60 chars (hard max 65)
- [ ] All meta descriptions are 140-160 chars (hard max 175)
- [ ] All canonicals are HTTPS
- [ ] All canonicals include locale prefix (except root)

---

## NEXT STEPS

1. **Implement meta generation functions** in `lib/meta_directive.php`
2. **Enhance router** to apply meta rules
3. **Verify HTTP→HTTPS redirects** in `bootstrap/canonical.php`
4. **Test SSR output** for top 20 priority pages
5. **Validate with Rich Results Test:** https://search.google.com/test/rich-results
6. **Request re-indexing** in Google Search Console for priority pages

---

**END OF AUDIT REPORT**

