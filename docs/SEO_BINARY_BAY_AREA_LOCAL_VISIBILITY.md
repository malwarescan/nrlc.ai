# NRLC.ai — Bay Area Local Visibility Binary

**Goal:** Maximum organic + AI-citation visibility in the Bay Area (SF + Peninsula + Silicon Valley + South Bay).  
**Outcome:** Ranking and lead-gen for queries tied to San Francisco, Silicon Valley, San Jose, and surrounding cities.  
**Constraints:** No thin/duplicate location pages; every page has unique intent + unique proof/angles.  
**CMS:** PHP (router + page templates). Fixes are file/template-specific.

**Target cities (priority):** San Francisco, San Jose, Palo Alto, Mountain View, Sunnyvale, Santa Clara, Cupertino, Menlo Park, Redwood City, San Mateo, Burlingame, Foster City, Millbrae, Daly City, South San Francisco, Oakland, Berkeley, Fremont, Hayward.  
**Target counties:** San Francisco, San Mateo, Santa Clara, Alameda.

---

## TASK 1 — BAY AREA LOCAL VISIBILITY STRATEGY (BINARY SPEC)

### A) Local Landing Page Architecture (No-Duplicate, Intent-Based)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| A1 | Bay Area cities in city list | All 19 target cities exist as `city_name` in `data/cities.csv` with correct subdivision (CA) and lat/lng | Missing cities; no URLs generated for Palo Alto, Mountain View, etc. | Add rows to `data/cities.csv`: `palo-alto,US,CA,37.4419,-122.1430,en,.us` (and remaining cities). | `data/cities.csv` |
| A2 | One canonical URL per city+service | Each service+city has exactly one canonical URL (e.g. `/en-us/services/ai-search-optimization/san-francisco/`) and no duplicate path variants | Duplicate URLs; GSC “alternate chosen” | Sitemap and internal links use locale-prefixed canonical only. Router already enforces canonical locale for service+city. | `scripts/generate_categorized_sitemaps.php` (already emits locale); `bootstrap/canonical.php` |
| A3 | Bay Area hub page exists | At least one page targeting “Bay Area” / “San Francisco Bay Area” region intent with unique copy | No region-level landing; only city-level | Create hub at `/en-us/bay-area/` or `/en-us/services/ai-search-optimization/bay-area/` (or `/en-us/region/bay-area/`) with 400+ words unique copy, H1 “AI Search Optimization for the San Francisco Bay Area”, and links to SF, San Jose, Oakland, Peninsula cities. | New route in `bootstrap/router.php`; new page `pages/bay-area/index.php` or `pages/region/bay-area.php` |
| A4 | No boilerplate-only city pages | Each city page has ≥35% unique content (local problem, who we help, local proof or proxy, localized FAQ) | All city pages same except city name swap | Enforce unique blocks: “Local problem” paragraph (city-specific), “Who we help here” (industry clusters), “Local proof or proxy proof”, FAQs that match local intent. Use `data/bay_area_city_intent.json` or per-city overrides in `lib/content_tokens.php` / service_enhancements. | `pages/services/service_city.php`; `lib/content_tokens.php`; `data/service_enhancements.json` or new `data/bay_area_city_overrides.json` |
| A5 | County pages only if justified | If county pages exist, each has distinct intent (e.g. “Santa Clara County AI SEO”) and 300+ words unique | Thin county pages; doorway risk | Add county pages only as strategic consolidation: e.g. `/en-us/region/santa-clara-county/` with unique angle (tech/SaaS focus). Otherwise do not create. | Optional: `pages/region/santa-clara-county.php` etc. |

---

### B) Local Signals (NAP, Service Areas, Maps, Structured Data)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| B1 | NAP consistent and visible | Business name, phone, address match GBP and appear on site (footer or contact) | NAP missing or inconsistent | Use only `gbp_business_name()`, `gbp_phone()`, `gbp_address_display()` from `config/gbp.json`. Footer already uses these. | `config/gbp.json`; `templates/footer.php`; `lib/gbp_config.php` |
| B2 | Service area declared | Organization or LocalBusiness schema includes `areaServed` (e.g. Bay Area, CA, or list of counties/cities) | No areaServed; weak local entity | Add to `config/gbp.json`: `"serviceArea": [{"@type":"GeoCircle","geoMidpoint":{"@type":"GeoCoordinates","latitude":37.7749,"longitude":-122.4194},"geoRadius":50000}]` or `areaServed: ["San Francisco Bay Area", "Santa Clara County", "San Mateo County", "Alameda County", "San Francisco County"]`. Use in schema when rendering Organization/LocalBusiness. | `config/gbp.json`; `lib/schema_builders.php` or page-level schema |
| B3 | LocalBusiness or ProfessionalService for local queries | If targeting local pack / “near me”, one of LocalBusiness or ProfessionalService with address + areaServed | Not targeting local pack | Add optional ProfessionalService block (or extend Organization) with `areaServed` covering Bay Area. Do not invent address; use GBP address. | `lib/schema_builders.php`; homepage or Bay Area hub |
| B4 | No fake addresses | No Bay Area address unless actually present in GBP | Misleading local signals | Do not add Bay Area address to schema or copy unless added to GBP. Use only “We serve the Bay Area” + areaServed in schema. | All templates and schema |

---

### C) City/Service Keyword Mapping (Primary + Secondary Intents)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| C1 | Primary keyword in title/H1 | Each city page title and H1 include primary intent (e.g. “AI Search Optimization San Francisco”) | Generic title; no city in H1 | Use `service_meta_title($serviceSlug, $citySlug)` and intent-driven H1 from `service_intent_content()`. Ensure city name in H1. | `lib/service_intent_taxonomy.php`; `pages/services/service_city.php` |
| C2 | Bay Area city enhancements in meta | San Francisco, San Jose, Palo Alto, Mountain View, Oakland have enhanced meta (title/description) in enhancements data | Same meta as generic city | Add Bay Area city entries in `data/service_enhancements.json` or `data/service_keyword_enhancements.json` with title/description/h1 that include “San Francisco”, “Silicon Valley”, “Bay Area” where relevant. | `data/service_enhancements.json`; `lib/service_enhancements.php` |
| C3 | Secondary intents in copy | At least one secondary intent phrase per city (e.g. “startups in Palo Alto”, “SaaS in San Francisco”) | Only primary keyword | Add “Who we help here” block with 2–3 industry clusters per city (e.g. SF: startups, fintech, agencies; San Jose: enterprise tech, hardware; Palo Alto: VCs, startups). | `lib/content_tokens.php` (e.g. `bay_area_industry_cluster()`); or `data/bay_area_city_overrides.json` |

---

### D) Proof Localization (Clients, Case Studies, Local Relevance)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| D1 | Proof block on every local money page | Each city or Bay Area hub has a “proof” block (40–80 words): case snippet, metric, or credible proxy (e.g. “We’ve helped B2B and SaaS teams in the Bay Area improve AI citation rates”) | No proof; generic “we’re experts” | Add proof block variable per city or region. For Bay Area use: “Neural Command has worked with founders and growth teams across San Francisco, San Jose, and the Peninsula on GEO and AEO implementation. Our GEO-16 framework is used to improve AI visibility for Bay Area tech and professional services.” | `pages/services/service_city.php`; `lib/content_tokens.php`; Bay Area hub page |
| D2 | Case study with Bay Area relevance if available | At least one case study or proof page mentions Bay Area, SF, Silicon Valley, or California | No local proof | Add a “Bay Area” or “California tech” angle to an existing case study page (e.g. industry = B2B SaaS, region = national including Bay Area), or add a short “Who we help in the Bay Area” proof section on hub. | `pages/case-studies/*.php`; or new proof block in `data/` |
| D3 | No fabricated local claims | Proof does not claim “offices in San Francisco” or “clients in [city]” unless true | Misleading; E-E-A-T risk | Use only verifiable proof: “We serve the Bay Area”, “Our methodology is used by teams in tech and professional services”, or real case outcomes. | All copy and proof blocks |

---

### E) Internal Link Graph for Geo Pages (Hub/Spoke)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| E1 | Bay Area hub links to key cities | Bay Area hub page links to 8+ city pages (SF, San Jose, Oakland, Palo Alto, Mountain View, Sunnyvale, Santa Clara, San Mateo) with descriptive anchors | Hub exists but no city links | Add “Cities we serve” or “Nearby cities” section with links: “AI Search Optimization San Francisco”, “AI Search Optimization San Jose”, etc. | Bay Area hub template |
| E2 | City pages link to hub and nearby cities | Each Bay Area city page links to Bay Area hub and 4–6 nearby cities (e.g. San Jose → Sunnyvale, Santa Clara, Mountain View, Palo Alto, SF) | Orphan city pages | In `service_city.php` or content_tokens, add “Nearby cities we serve” block: for each city slug, define array of nearby city slugs; render links with `absolute_url("/en-us/services/{$serviceSlug}/{$nearbySlug}/")`. | `lib/content_tokens.php` (e.g. `nearby_bay_area_cities($citySlug)`); `pages/services/service_city.php` |
| E3 | Services index links to Bay Area hub | Services index or main nav has one link to Bay Area hub or “Bay Area” geo cluster | No path to region from services | Add “San Francisco Bay Area” link in services index or footer/region nav pointing to `/en-us/bay-area/` or equivalent. | `pages/services/index.php`; or `templates/footer.php` / nav |

---

### F) CTR & SERP Features (FAQ, Reviews, Sitelinks)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| F1 | FAQ on every local money page | Each city page and Bay Area hub has 5–7 FAQs with FAQPage schema | No FAQ; no rich result | Use `city_specific_faq_block($serviceSlug, $citySlug, 6)` and `ld_faq()` in schema. Ensure FAQs are city/region specific (not generic). | `pages/services/service_city.php`; `lib/content_tokens.php`; `data/faq_pools.csv` or bay-area FAQ set |
| F2 | Unique FAQ set per city where possible | At least 2 FAQs per city are city-specific (e.g. “Do you work with startups in Palo Alto?”) | Same FAQ set on every city | Add city-specific FAQ pool or override: e.g. in `data/faq_pools.csv` add `city` or `region` column and filter; or add `data/bay_area_faq_overrides.json` with 2–3 questions per city. | `data/faq_pools.csv`; `lib/content_tokens.php` |
| F3 | Reviews schema only if real | If using AggregateRating, only if real reviews exist; otherwise omit | Fake reviews; penalty | Do not add AggregateRating unless you have real review data. Omit. | All schema |

---

### G) AI Retrieval Readiness for Local Queries

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| G1 | Definition in first 100 words | Each local page states “who we are / what we do” and includes region or city in first 100 words | Vague opening; no geo in first chunk | Ensure `service_definition_lock()` or hero copy includes city/region in first 100 words. e.g. “Neural Command provides AI Search Optimization (GEO/AEO) for businesses in [City] and the Bay Area.” | `lib/content_tokens.php`; `pages/services/service_city.php` |
| G2 | llms.txt mentions Bay Area | `/llms.txt` includes at least one line referencing Bay Area, San Francisco, or Silicon Valley service | AI crawlers don’t associate site with Bay Area | Add to `llms.txt`: “- [Bay Area AI Search Optimization](https://nrlc.ai/en-us/bay-area/): AI Search Optimization and GEO/AEO services for San Francisco, San Jose, Silicon Valley, and the greater Bay Area.” | `llms.txt` |
| G3 | areaServed in schema for local pages | Service schema on city pages includes `areaServed` (city name or Place) | No area in schema | In `ld_service()` or city-page schema, set `areaServed` to `["@type":"City","name":"San Francisco"]` or AdministrativeArea for county. | `lib/schema_builders.php`; city page schema |

---

### H) Indexation Control (Canonicals, Sitemap, Noindex)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| H1 | Canonical on every local page | Every city and Bay Area hub has a single canonical URL (locale-prefixed) | Duplicate canonicals; wrong canonical | Router sets `canonicalPath` to actual path including locale (e.g. `/en-us/services/ai-search-optimization/san-francisco/`). Head outputs that canonical. | `bootstrap/router.php`; `templates/head.php` |
| H2 | Sitemap includes all Bay Area city URLs | Sitemap lists canonical URLs for all service+city combinations for the 19 Bay Area cities | Missing cities in sitemap | Cities are driven by `data/cities.csv`. After adding cities, run `php scripts/generate_categorized_sitemaps.php`. Sitemap already emits locale-prefixed URLs. | `data/cities.csv`; `scripts/generate_categorized_sitemaps.php` |
| H3 | Noindex on pagination or filters | If any local page has pagination or query params, those are noindex or canonical to main | Indexed ?page= or ?sort= | Ensure only main local URLs are indexable; use canonical to self and noindex on param variants if any. | Router or head logic for local pages |
| H4 | Bay Area hub in sitemap | If Bay Area hub exists, it is in sitemap index or index-pages | Hub not discoverable | Add `https://nrlc.ai/en-us/bay-area/` to `get_index_pages()` or a dedicated geo sitemap. | `scripts/generate_categorized_sitemaps.php` |

---

## TASK 2 — URL MAP (BAY AREA GEO CLUSTER)

Implementation-ready URL map. Intent and primary keyword per URL.

### Bay Area hub (region intent)

| URL | Intent | Primary keyword |
|-----|--------|-----------------|
| https://nrlc.ai/en-us/bay-area/ | Region hub: AI SEO / GEO for the Bay Area | AI Search Optimization Bay Area, San Francisco Bay Area SEO |
| https://nrlc.ai/en-us/bay-area/ai-search-optimization/ | Service + region (optional; only if distinct from generic hub) | AI Search Optimization San Francisco Bay Area |

### City pages (distinct intent per city)

| URL | Intent | Primary keyword |
|-----|--------|-----------------|
| https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/ | SF: startups, fintech, agencies | AI Search Optimization San Francisco |
| https://nrlc.ai/en-us/services/ai-search-optimization/san-jose/ | San Jose: enterprise tech, hardware | AI Search Optimization San Jose |
| https://nrlc.ai/en-us/services/ai-search-optimization/oakland/ | Oakland: local business, diversity of industries | AI Search Optimization Oakland |
| https://nrlc.ai/en-us/services/ai-search-optimization/palo-alto/ | Palo Alto: VCs, startups, high-growth | AI Search Optimization Palo Alto |
| https://nrlc.ai/en-us/services/ai-search-optimization/mountain-view/ | Mountain View: tech HQs, B2B | AI Search Optimization Mountain View |
| https://nrlc.ai/en-us/services/ai-search-optimization/sunnyvale/ | Sunnyvale: tech, hardware | AI Search Optimization Sunnyvale |
| https://nrlc.ai/en-us/services/ai-search-optimization/santa-clara/ | Santa Clara: enterprise, events | AI Search Optimization Santa Clara |
| https://nrlc.ai/en-us/services/ai-search-optimization/cupertino/ | Cupertino: tech, consumer tech | AI Search Optimization Cupertino |
| https://nrlc.ai/en-us/services/ai-search-optimization/menlo-park/ | Menlo Park: VC, startups | AI Search Optimization Menlo Park |
| https://nrlc.ai/en-us/services/ai-search-optimization/redwood-city/ | Redwood City: biotech, life sciences | AI Search Optimization Redwood City |
| https://nrlc.ai/en-us/services/ai-search-optimization/san-mateo/ | San Mateo: fintech, mid-Peninsula | AI Search Optimization San Mateo |
| https://nrlc.ai/en-us/services/ai-search-optimization/berkeley/ | Berkeley: education, research, local business | AI Search Optimization Berkeley |
| https://nrlc.ai/en-us/services/ai-search-optimization/fremont/ | Fremont: manufacturing, tech | AI Search Optimization Fremont |
| https://nrlc.ai/en-us/services/ai-search-optimization/hayward/ | Hayward: local business, logistics | AI Search Optimization Hayward |
| (+ same pattern for burlingame, foster-city, millbrae, daly-city, south-san-francisco) | Peninsula / North Bay suburbs | [City] AI Search Optimization |

Repeat for 1–2 other money services (e.g. crawl-clarity, site-audits) only where you have unique intent/angle; avoid full matrix of 19 cities × 10 services without unique content.

### County pages (strategic consolidation)

| URL | Intent | Primary keyword |
|-----|--------|-----------------|
| https://nrlc.ai/en-us/region/santa-clara-county/ | Santa Clara County: Silicon Valley tech | AI Search Optimization Santa Clara County |
| https://nrlc.ai/en-us/region/san-mateo-county/ | San Mateo County: Peninsula, biotech/fintech | AI Search Optimization San Mateo County |
| (Optional) Alameda, SF County | Only if unique angle + 300+ words | County + AI SEO |

### Proof / relevance

| URL | Intent | Primary keyword |
|-----|--------|-----------------|
| https://nrlc.ai/en-us/case-studies/ | Proof hub; filter or mention Bay Area | AI SEO case studies |
| (Add Bay Area filter or one case with “Bay Area” / “California tech” in copy) | Local relevance | Bay Area AI SEO case study |

**Total:** 1 hub + 19 city pages (per primary service) + 0–2 county pages + proof = 20–25 URLs minimum. Expand to 30–50 if multiple services with unique angles per city.

---

## TASK 3 — PAGE TEMPLATE (REUSABLE “LOCAL MONEY PAGE”)

Single reusable template that prevents duplication via required unique fields.

### Title formula (variables: {Service}, {City}, {Region})

- Pattern: `{Service} {City} | GEO & AEO | Neural Command` or `{Service} in {City} | Bay Area AI SEO | NRLC.ai`  
- Max 60 characters.

**5 examples:**

1. AI Search Optimization San Francisco | GEO & AEO | Neural Command  
2. AI Search Optimization San Jose | Silicon Valley AI SEO | NRLC.ai  
3. AI Search Optimization Palo Alto | Bay Area GEO | Neural Command  
4. AI Search Optimization Mountain View | AI SEO for Tech | NRLC.ai  
5. AI Search Optimization Oakland | East Bay AI SEO | Neural Command  

### Meta description formula

- Pattern: `{Service} for {City} and the Bay Area. {Proof or outcome}. Book a consultation.`  
- Max 155 characters.

**5 examples:**

1. AI Search Optimization for San Francisco and the Bay Area. GEO and AEO for startups and agencies. Book a free consultation with Neural Command.  
2. AI Search Optimization in San Jose and Silicon Valley. Improve AI citations for tech and enterprise. Book a call with NRLC.ai.  
3. AI Search Optimization for Palo Alto and the Peninsula. GEO-16 for VCs and high-growth teams. Book a consultation.  
4. AI Search Optimization in Mountain View. Technical SEO and AI visibility for B2B tech. Response within 24 hours.  
5. AI Search Optimization for Oakland and the East Bay. Structured data and AI citations for local businesses. Book a call.  

### H1 formula

- `{Service} in {City}`  
- Example: **AI Search Optimization in San Francisco**

### Section blocks (required unique fields)

- **Local problem (city-specific):** 1 paragraph, 60–100 words. Must reference city/region and one concrete local pain (e.g. “In San Francisco, startups compete for AI visibility with limited in-house SEO; in San Jose, enterprise teams need schema at scale”). Stored in `data/bay_area_city_overrides.json` or similar keyed by `city_slug`.  
- **Who we help here:** 2–4 industry clusters for that city (e.g. SF: startups, fintech, marketing agencies; San Jose: enterprise software, hardware, semiconductors). Bullet or short paragraph.  
- **Local proof or proxy proof:** 40–80 words. Case snippet, metric, or “We work with teams in [City/region] on…” No fabricated offices or client names unless true.  
- **How we work:** Same core 3–5 steps sitewide; one localized bullet (e.g. “We align with your Bay Area market and time zone for kickoffs”).  
- **FAQs that match local intent:** 5–7 questions; at least 2 city/region specific (e.g. “Do you work with startups in Palo Alto?”, “What’s included in a Bay Area AI visibility audit?”).  
- **Nearby cities we serve:** Internal link module. 6–8 links: “AI Search Optimization San Jose”, “AI Search Optimization Oakland”, etc. Data: `nearby_bay_area_cities($citySlug)` returning array of city slugs.  

### Minimum word counts and uniqueness

- Minimum **400 words** unique body copy per city page.  
- **35%+ unique copy** per city: local problem, who we help, proof, and at least 2 FAQs must be city-specific.  
- No single template fill where only city name is swapped; at least local problem + who we help + 2 FAQs are from data/overrides.

---

## TASK 4 — TOP 8 PRIORITY BAY AREA PAGES (FULL ASSETS)

### 1. Bay Area hub

- **URL/canonical:** `https://nrlc.ai/en-us/bay-area/`  
- **Title (5):**  
  1. AI Search Optimization San Francisco Bay Area | Neural Command  
  2. Bay Area GEO & AEO | SF, San Jose, Silicon Valley | NRLC.ai  
  3. AI SEO for the Bay Area | San Francisco, San Jose, Oakland | Neural Command  
  4. Bay Area AI Search Optimization | GEO-16 | NRLC.ai  
  5. San Francisco Bay Area AI SEO | Neural Command  
- **Meta (5):**  
  1. AI Search Optimization and GEO for the San Francisco Bay Area. San Francisco, San Jose, Palo Alto, Oakland. Book a consultation.  
  2. We help Bay Area startups and enterprises get cited in AI search. GEO, AEO, structured data. Book a call.  
  3. Neural Command delivers AI Search Optimization across SF, Silicon Valley, and the Peninsula. Response within 24 hours.  
  4. Bay Area AI visibility audits and GEO-16 implementation. From San Francisco to San Jose. Book a free consultation.  
  5. GEO and AEO for the Bay Area. Improve AI citations in ChatGPT, Perplexity, and Google AI Overviews.  
- **H1:** AI Search Optimization for the San Francisco Bay Area  
- **H2/H3:** What We Do in the Bay Area; Who We Help (Startups, Enterprise, Agencies); Why Neural Command; How We Work; Cities We Serve; FAQ.  
- **Above-the-fold (120–180 words):** Neural Command provides AI Search Optimization (GEO and AEO) for the San Francisco Bay Area—San Francisco, San Jose, Oakland, the Peninsula, and Silicon Valley. We help founders, growth leads, and marketing teams get cited in ChatGPT, Perplexity, and Google AI Overviews. Our GEO-16 framework and structured data engineering improve how AI systems retrieve and cite your brand. Whether you’re in San Francisco, Palo Alto, or San Jose, we focus on unique intent and proof, not thin location pages.  
- **Proof block (40–80 words):** Neural Command has worked with B2B and SaaS teams across the Bay Area on GEO and AEO implementation. Our methodology is used to improve AI citation rates for tech and professional services. We serve San Francisco, San Jose, Oakland, and the Peninsula with the same research-backed approach we use nationwide.  
- **FAQ (6):** What is AI Search Optimization? Do you serve the whole Bay Area? What’s the difference between GEO and AEO? Do you work with startups in San Francisco? How do I get started? Where is Neural Command based?  
- **Internal links (8):** AI Search Optimization San Francisco → /en-us/services/ai-search-optimization/san-francisco/; San Jose → /en-us/services/ai-search-optimization/san-jose/; Oakland → /en-us/services/ai-search-optimization/oakland/; Palo Alto → /en-us/services/ai-search-optimization/palo-alto/; Services → /en-us/services/; Book → /en-us/book/; Case Studies → /en-us/case-studies/; GEO → /en-us/generative-engine-optimization/.  

### 2. San Francisco (service + city)

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/`  
- **Title (5):**  
  1. AI Search Optimization San Francisco | Neural Command  
  2. AI SEO San Francisco | GEO & AEO | NRLC.ai  
  3. San Francisco AI Search Optimization | Bay Area | Neural Command  
  4. AI Search Optimization in San Francisco | NRLC.ai  
  5. GEO & AEO San Francisco | Neural Command  
- **Meta (5):**  
  1. AI Search Optimization for San Francisco and the Bay Area. GEO and AEO for startups and agencies. Book a free consultation.  
  2. Get cited in AI search. We help SF startups and growth teams with structured data and AI visibility. Response within 24 hours.  
  3. San Francisco AI SEO from Neural Command. Improve visibility in ChatGPT, Perplexity, and Google AI Overviews.  
  4. GEO-16 and AEO for San Francisco businesses. Technical SEO and AI citation growth. Book a call.  
  5. AI Search Optimization in San Francisco. We serve SOMA, Financial District, Mission, and citywide.  
- **H1:** AI Search Optimization in San Francisco  
- **H2/H3:** Why San Francisco Businesses Need AI Search Optimization; Who We Help in San Francisco; Service Overview; Why Choose Us; Process; FAQ; Nearby Cities.  
- **Above-the-fold (120–180 words):** Neural Command provides AI Search Optimization (GEO and AEO) for businesses in San Francisco and the Bay Area. In a market where startups and agencies compete for visibility in ChatGPT, Perplexity, and Google AI Overviews, we focus on entity clarity, structured data, and citation-ready content. We work with founders, growth leads, and marketing directors across San Francisco—from the Financial District to SOMA and the Mission—to improve how AI systems retrieve and cite their brands. Our GEO-16 methodology is designed for tech and professional services that need measurable AI visibility, not just traditional SEO.  
- **Proof block (40–80 words):** We’ve worked with B2B and SaaS teams in San Francisco and the Bay Area on GEO and AEO implementation. Our approach improves AI citation rates and aligns with how AI systems evaluate and cite content. We serve SF startups and agencies with the same research-backed framework we use nationwide.  
- **FAQ (6):** What is AI Search Optimization? Do you work with startups in San Francisco? What is GEO? How long until we see results? Do you serve the whole Bay Area? How do I get started?  
- **Internal links (8):** Bay Area → /en-us/bay-area/; San Jose → /en-us/services/ai-search-optimization/san-jose/; Oakland → /en-us/services/ai-search-optimization/oakland/; Palo Alto → /en-us/services/ai-search-optimization/palo-alto/; Services → /en-us/services/; Book → /en-us/book/; Case Studies → /en-us/case-studies/; GEO → /en-us/generative-engine-optimization/.  

### 3. San Jose

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/san-jose/`  
- **Title (5):** AI Search Optimization San Jose | Silicon Valley | Neural Command; AI SEO San Jose | GEO & AEO | NRLC.ai; San Jose AI Search Optimization | NRLC.ai; AI Search Optimization in San Jose | Neural Command; Silicon Valley AI SEO | San Jose | NRLC.ai  
- **Meta (5):** AI Search Optimization for San Jose and Silicon Valley. GEO and AEO for enterprise tech. Book a consultation.; San Jose and South Bay AI SEO. Improve AI citations for tech and hardware. Book a call.; Neural Command serves San Jose with GEO-16 and structured data. Response within 24 hours.; AI Search Optimization in San Jose. We work with enterprise and startups in the South Bay.; Silicon Valley AI visibility from Neural Command. San Jose, Santa Clara, Sunnyvale.  
- **H1:** AI Search Optimization in San Jose  
- **H2/H3:** Why San Jose & Silicon Valley; Who We Help; Service Overview; Why Choose Us; Process; FAQ; Nearby Cities.  
- **Above-the-fold:** Focus on San Jose as heart of Silicon Valley; enterprise tech, hardware, semiconductors; AI visibility for B2B and scale-ups.  
- **Proof block:** Work with teams in San Jose and the South Bay on GEO and AEO; tech and enterprise focus.  
- **FAQ (6):** What is AI Search Optimization? Do you work with enterprise in San Jose? What is GEO? Do you serve all of Silicon Valley? How do we get started? What’s included in an audit?  
- **Internal links (8):** Bay Area → /en-us/bay-area/; San Francisco → …/san-francisco/; Mountain View → …/mountain-view/; Sunnyvale → …/sunnyvale/; Santa Clara → …/santa-clara/; Services, Book, Case Studies, GEO.  

### 4. Palo Alto

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/palo-alto/`  
- **Title (5):** AI Search Optimization Palo Alto | Neural Command; AI SEO Palo Alto | Peninsula & Silicon Valley | NRLC.ai; Palo Alto AI Search Optimization | GEO | Neural Command; AI Search Optimization in Palo Alto | NRLC.ai; GEO & AEO Palo Alto | Neural Command  
- **Meta (5):** AI Search Optimization for Palo Alto and the Peninsula. GEO for VCs and high-growth startups. Book a consultation.; Palo Alto AI SEO. We help startups and growth teams get cited in AI search. Book a call.; Neural Command serves Palo Alto with GEO-16 and AEO. Response within 24 hours.; AI Search Optimization in Palo Alto. Improve visibility in ChatGPT and Perplexity.; Peninsula AI visibility. Palo Alto, Menlo Park, Mountain View.  
- **H1:** AI Search Optimization in Palo Alto  
- **Above-the-fold:** Palo Alto and Peninsula; VCs, startups, high-growth; AI visibility and citation.  
- **Proof + FAQ + internal links:** Same structure as above; nearby: Menlo Park, Mountain View, Redwood City, San Francisco, San Jose.  

### 5. Mountain View

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/mountain-view/`  
- **Title/Meta/H1:** Emphasize Mountain View and Silicon Valley tech HQs; B2B and enterprise.  
- **Above-the-fold, proof, FAQ, internal links:** Same template; nearby: Sunnyvale, Palo Alto, Santa Clara, San Jose, Los Altos (if added).  

### 6. Oakland

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/oakland/`  
- **Title/Meta/H1:** Oakland and East Bay; diverse industries, local business, downtown and Jack London Square.  
- **Above-the-fold, proof, FAQ, internal links:** Same template; nearby: Berkeley, San Francisco, San Jose, Fremont, Hayward.  

### 7. Sunnyvale

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/sunnyvale/`  
- **Title/Meta/H1:** Sunnyvale and South Bay; tech, hardware, B2B.  
- **Internal links:** San Jose, Mountain View, Santa Clara, Cupertino, Palo Alto, Bay Area hub, Services, Book.  

### 8. Santa Clara

- **URL/canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/santa-clara/`  
- **Title/Meta/H1:** Santa Clara and Silicon Valley; enterprise, events, tech.  
- **Internal links:** San Jose, Sunnyvale, Cupertino, Mountain View, Bay Area hub, Services, Book, Case Studies.  

---

## TASK 5 — STRUCTURED DATA PACK (BAY AREA)

- **Organization + WebSite (site-wide):** Already defined; use `https://nrlc.ai/#organization` and `https://nrlc.ai/#website`. Add `areaServed` to Organization when you have a defined service area (see B2).  
- **ProfessionalService / LocalBusiness:** Use only if you want to compete for local pack. Optional block with same NAP as GBP and `areaServed`: Bay Area, San Francisco Bay Area, or list of counties. **TODO:** If no Bay Area address, do not add a second address; add only `areaServed` (e.g. `["San Francisco Bay Area", "Santa Clara County", "San Mateo County", "Alameda County"]`). Placement: homepage or Bay Area hub JSON-LD.  
- **Service schema for service+city pages:** Use existing `ld_service()` with `areaServed` set to the city. Example:

```json
{
  "@context": "https://schema.org",
  "@type": "Service",
  "@id": "https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/#service",
  "name": "AI Search Optimization in San Francisco",
  "description": "AI Search Optimization (GEO and AEO) for businesses in San Francisco and the Bay Area.",
  "serviceType": "AI Search Optimization",
  "provider": { "@id": "https://nrlc.ai/#organization" },
  "areaServed": {
    "@type": "City",
    "name": "San Francisco",
    "containedInPlace": { "@type": "State", "name": "California" }
  },
  "url": "https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/"
}
```

- **AreaServed strategy:** For Organization: one of (a) `"areaServed": "United States"`, or (b) multiple `AdministrativeArea` (e.g. Santa Clara County, San Mateo County) + “San Francisco Bay Area” as text. Do not list 19 cities in Organization; keep that for Service per page.  
- **BreadcrumbList:** Home → Bay Area (or Services) → [City] or Home → Services → [Service] → [City]. Use `absolute_url()` for each item.  
- **FAQPage:** Use `ld_faq()` for local pages with 5–7 Q&As; include at least 2 local-intent questions.  

**TODO (address/phone):** Do not invent. Use only GBP values from `config/gbp.json`. If you add a Bay Area office later, add it to GBP and then to schema.

---

## TASK 6 — GO LIVE GATE (LOCAL)

### Remaining FAIL items only

1. **A3 — Bay Area hub page:** Create `/en-us/bay-area/` (or equivalent) with 400+ words unique copy, H1, proof, FAQ, and links to 8+ city pages.  
2. **B2 — Service area in config/schema:** Add `serviceArea` to `config/gbp.json` (or schema) and use it in Organization/ProfessionalService so `areaServed` includes Bay Area / counties.  
3. **A4 — Unique content per city:** Implement “local problem” and “who we help” (and 2+ local FAQs) per Bay Area city via overrides or data file so each page has ≥35% unique copy.  
4. **E1/E2/E3 — Hub and city links:** Add Bay Area hub; add “Nearby cities” on city pages; add link to Bay Area from services index or nav.  
5. **G2 — llms.txt:** Add one Bay Area / region link and line to `llms.txt`.  
6. **H4 — Hub in sitemap:** Once hub exists, add its URL to sitemap (index-pages or geo).  

### Single highest-leverage next change for Bay Area rankings

**Create the Bay Area hub page and add it to the sitemap.**

- **Why:** Right now there is no single page that owns “Bay Area” and “San Francisco Bay Area” region intent. A dedicated hub with unique copy, proof, and links to SF, San Jose, Oakland, Palo Alto, etc. gives one clear target for region queries and distributes link equity to city pages.  
- **Action:**  
  1. Add route in `bootstrap/router.php` for `/bay-area/` (canonical path `/en-us/bay-area/`).  
  2. Create `pages/bay-area/index.php` (or `pages/region/bay-area.php`) with the Task 4 hub content (title, meta, H1, sections, proof, FAQ, 8 internal links).  
  3. Add `https://nrlc.ai/en-us/bay-area/` to `get_index_pages()` in `scripts/generate_categorized_sitemaps.php`.  
  4. Add one link to “San Francisco Bay Area” from `pages/services/index.php` or footer.  

**Implemented in this repo:** (1) All 19 Bay Area target cities added to `data/cities.csv`. (2) San Jose, Oakland, Palo Alto, Mountain View, Sunnyvale, Santa Clara added to neighborhood coverage in `lib/content_tokens.php` for richer service-area copy. (3) Bay Area hub page created at `/en-us/bay-area/` with unique copy, proof block, FAQ, and links to 8 city pages; route and canonical redirect in `bootstrap/router.php`; hub URL added to sitemap index-pages. (4) Services index updated with Bay Area link and SF/San Jose in popular cities. (5) `llms.txt` updated with Bay Area AI Search Optimization link.

---

*Document version: 1.0. CMS: PHP. ASSUMPTION: No Bay Area physical office; NAP remains Santa Monica (GBP). AreaServed is declarative only.*
