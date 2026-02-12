# QA: Every URL We Implemented — Full Checklist

**Use this list to QA all implementations.** Hit each URL (local or production), confirm 200, canonical, and expected content.

---

## 1. NEW PAGES (we created these)

| # | URL | Page | QA |
|---|-----|------|-----|
| 1 | `https://nrlc.ai/en-us/bay-area/` | Bay Area hub | 200, H1, proof, FAQ, 8 city links (card-style), canonical |
| 2 | `https://nrlc.ai/en-us/insights/grounding-queries-fan-out-ai-visibility/` | Grounding vs fan-out article | 200, Article+FAQPage schema, definition in first 100 words, FAQ, sources |
| 3 | `https://nrlc.ai/en-us/tools/bing-ai-citations/` | Bing AI Citations landing | 200, 8-step workflow, templates, FAQ, CTA (nrlc.ai + croutons.ai), video placeholder |

**Local:** `http://localhost:8000/en-us/bay-area/` | `http://localhost:8000/en-us/insights/grounding-queries-fan-out-ai-visibility/` | `http://localhost:8000/en-us/tools/bing-ai-citations/`

---

## 2. BAY AREA HUB — “Cities we serve” links (exact URLs from hub)

These are the 8 city links on the Bay Area hub (ai-search-optimization only).

| # | URL |
|---|-----|
| 4 | `https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/` |
| 5 | `https://nrlc.ai/en-us/services/ai-search-optimization/san-jose/` |
| 6 | `https://nrlc.ai/en-us/services/ai-search-optimization/oakland/` |
| 7 | `https://nrlc.ai/en-us/services/ai-search-optimization/palo-alto/` |
| 8 | `https://nrlc.ai/en-us/services/ai-search-optimization/mountain-view/` |
| 9 | `https://nrlc.ai/en-us/services/ai-search-optimization/sunnyvale/` |
| 10 | `https://nrlc.ai/en-us/services/ai-search-optimization/santa-clara/` |
| 11 | `https://nrlc.ai/en-us/services/ai-search-optimization/san-mateo/` |

**QA:** Each returns 200, has “Nearby cities we serve” (Bay Area block), and for 4–9 below: local context block + local FAQs from overrides.

---

## 3. BAY AREA CITIES WITH OVERRIDES (local_problem, who_we_help, local_faqs)

These city **slugs** have entries in `data/bay_area_city_overrides.json`. Every **service+city** URL for these slugs gets the extra local block + local FAQs.

**City slugs:** `san-francisco`, `san-jose`, `palo-alto`, `oakland`, `mountain-view`, `sunnyvale`, `santa-clara`, `berkeley`, `fremont`.

**URL pattern:** `https://nrlc.ai/en-us/services/{SERVICE}/{CITY}/`

**Example services to QA (one URL per city is enough; same template):**

| City slug | Example URL to QA |
|-----------|-------------------|
| san-francisco | `https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/` |
| san-jose | `https://nrlc.ai/en-us/services/ai-search-optimization/san-jose/` |
| palo-alto | `https://nrlc.ai/en-us/services/ai-search-optimization/palo-alto/` |
| oakland | `https://nrlc.ai/en-us/services/ai-search-optimization/oakland/` |
| mountain-view | `https://nrlc.ai/en-us/services/ai-search-optimization/mountain-view/` |
| sunnyvale | `https://nrlc.ai/en-us/services/ai-search-optimization/sunnyvale/` |
| santa-clara | `https://nrlc.ai/en-us/services/ai-search-optimization/santa-clara/` |
| berkeley | `https://nrlc.ai/en-us/services/ai-search-optimization/berkeley/` |
| fremont | `https://nrlc.ai/en-us/services/ai-search-optimization/fremont/` |

**QA per URL:** 200, “Local context” block (local_problem + who_we_help), extra local FAQs in FAQ section and in FAQPage schema, “Nearby cities we serve” block with hub + nearby links.

---

## 4. CANONICAL URLs WE FIXED (must resolve and show correct canonical)

| # | URL | What we fixed |
|---|-----|----------------|
| 12 | `https://nrlc.ai/en-us/book/` | Footer/book links use this canonical. |
| 13 | `https://nrlc.ai/en-us/case-studies/` | service_city “Case Studies” links point here. |
| 14 | `https://nrlc.ai/en-us/services/generative-seo/` | Generic service: canonical in head + schema now locale-prefixed. |
| 15 | `https://nrlc.ai/en-us/services/ai-search-optimization/` | Same. |
| 16 | `https://nrlc.ai/en-us/services/site-audits/` | Same. |

**QA:** Each 200; `<link rel="canonical">` and schema `url`/`@id` use the same en-us URL (no canonical without locale).

---

## 5. GENERIC SERVICE PAGE PATTERN (all services)

**Pattern:** `https://nrlc.ai/en-us/services/{SERVICE}/`

**Examples to QA:**

| # | URL |
|---|-----|
| 17 | `https://nrlc.ai/en-us/services/generative-seo/` |
| 18 | `https://nrlc.ai/en-us/services/ai-search-optimization/` |
| 19 | `https://nrlc.ai/en-us/services/site-audits/` |
| 20 | `https://nrlc.ai/en-us/services/crawl-clarity/` |
| 21 | `https://nrlc.ai/en-us/services/retrieval-optimization-ai/` |

**QA:** 200, proof block (“Why Neural Command”), FAQ section, FAQPage schema, canonical = same en-us URL, Service schema `provider` = `@id` organization.

---

## 6. INDEX / MONEY PAGES WE TOUCHED

| # | URL | What we did |
|---|-----|-------------|
| 22 | `https://nrlc.ai/en-us/` | Home (schema/canonical context). |
| 23 | `https://nrlc.ai/en-us/services/` | Services index: Bay Area link to /en-us/bay-area/, proof, FAQ, Person @id. |

---

## 7. REDIRECTS (must 301 to canonical)

| From | To |
|------|----|
| `/bay-area/` (no locale) | `https://nrlc.ai/en-us/bay-area/` |

---

## 8. SITEMAP URLS (should list our new pages)

- **Index:** `https://nrlc.ai/sitemaps/sitemap-index.xml`
- **Index pages:** `https://nrlc.ai/sitemaps/index-pages-1.xml` → must contain `https://nrlc.ai/en-us/bay-area/`
- **Insights:** `https://nrlc.ai/sitemaps/insights-1.xml` → must contain `https://nrlc.ai/en-us/insights/grounding-queries-fan-out-ai-visibility/`
- **Tools:** `https://nrlc.ai/sitemaps/tools-1.xml` → must contain `https://nrlc.ai/en-us/tools/bing-ai-citations/`
- **Services:** `https://nrlc.ai/sitemaps/services-1.xml` → contains service+city URLs (including Bay Area cities)

---

## 9. FLAT LIST — EVERY UNIQUE URL TO HIT (copy-paste for QA)

```
https://nrlc.ai/en-us/bay-area/
https://nrlc.ai/en-us/insights/grounding-queries-fan-out-ai-visibility/
https://nrlc.ai/en-us/tools/bing-ai-citations/
https://nrlc.ai/en-us/services/ai-search-optimization/san-francisco/
https://nrlc.ai/en-us/services/ai-search-optimization/san-jose/
https://nrlc.ai/en-us/services/ai-search-optimization/oakland/
https://nrlc.ai/en-us/services/ai-search-optimization/palo-alto/
https://nrlc.ai/en-us/services/ai-search-optimization/mountain-view/
https://nrlc.ai/en-us/services/ai-search-optimization/sunnyvale/
https://nrlc.ai/en-us/services/ai-search-optimization/santa-clara/
https://nrlc.ai/en-us/services/ai-search-optimization/san-mateo/
https://nrlc.ai/en-us/services/ai-search-optimization/berkeley/
https://nrlc.ai/en-us/services/ai-search-optimization/fremont/
https://nrlc.ai/en-us/book/
https://nrlc.ai/en-us/case-studies/
https://nrlc.ai/en-us/services/generative-seo/
https://nrlc.ai/en-us/services/ai-search-optimization/
https://nrlc.ai/en-us/services/site-audits/
https://nrlc.ai/en-us/services/crawl-clarity/
https://nrlc.ai/en-us/services/retrieval-optimization-ai/
https://nrlc.ai/en-us/
https://nrlc.ai/en-us/services/
```

---

## 10. BAY AREA SERVICE+CITY COVERAGE (all 19 Bay Area cities × services)

**Bay Area city slugs** (from `lib/bay_area.php` / cities.csv):  
san-francisco, san-jose, oakland, palo-alto, mountain-view, sunnyvale, santa-clara, san-mateo, cupertino, menlo-park, redwood-city, burlingame, foster-city, millbrae, daly-city, south-san-francisco, berkeley, fremont, hayward.

**URL pattern for each:** `https://nrlc.ai/en-us/services/{service}/{city}/`

For **full** QA of every Bay Area service+city URL, generate all combinations of (service slug from sitemap/router) × (19 city slugs). The **critical** QA subset is: **new hub (1) + 8 hub city links (2) + 9 override cities (3)** as in sections 1–3 above.

---

**Summary:** 3 new pages, 8 hub city links, 9 override cities (sample one URL per city), 5 canonical/fixed URLs, 5 generic service examples, 2 index pages, 1 redirect, 4 sitemap checks = **22+ distinct URLs** in the flat list. Use section 9 for a quick crawl/QA pass.
