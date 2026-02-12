# QA: Citeability Implementations (Maximum AI Citation Readiness)

**Purpose:** Audit all implementations that affect how AI systems (ChatGPT, Perplexity, Google AI Overviews) and search engines retrieve, understand, and cite NRLC.ai.  
**Date:** 2026-02-11

---

## 1. Entity & Schema (Single Source of Truth)

| Check | Status | Notes |
|-------|--------|--------|
| Single Person @id sitewide | **PASS** | All author/founder references use `JOEL_PERSON_ID` (`https://nrlc.ai/en-us/about/joel-maldonado/#person`). No minted Person @ids. |
| Full Person payload only on entity home | **PASS** | Full Person (name, jobTitle, sameAs, image, etc.) only on `/en-us/about/joel-maldonado/`. Other pages use @id reference only. |
| Organization @id stable | **PASS** | `https://nrlc.ai/#organization` used in schema_builders and referenced by Service provider where updated. |
| WebSite @id stable | **PASS** | `https://nrlc.ai/#website` in ld_website_with_searchaction(). |
| Service provider references Organization @id | **PASS** | Generic service.php Service schema uses `"provider" => ["@id" => "https://nrlc.ai/#organization"]` (fixed in this QA). |
| FAQPage has @id | **PASS** | FAQPage schema uses `$canonical_url . '#faq'` on service_city, service (generic), book, services index, bay-area, home, and other money pages. |

---

## 2. Canonicals (SEO-Forward)

| Check | Status | Notes |
|-------|--------|--------|
| Money page canonicals locale-prefixed | **PASS** | Router sets canonicalPath with locale (e.g. `/en-us/services/...`, `/en-us/bay-area/`). Generic service canonicalPath fixed to use actual request path (with locale) or `/en-us` + path. |
| Schema URLs match page canonical | **PASS** | service.php uses `$GLOBALS['__page_meta']['canonicalPath']` for $canonical_url so WebPage, Service, FAQPage @id/url match <link rel="canonical">. |
| Internal links to book/case-studies use absolute_url | **PASS** | Footer and service_city use `absolute_url('/en-us/book/')`, `absolute_url('/en-us/case-studies/')`. |
| Sitemaps emit canonical URLs only | **PASS** | Sitemap generator uses get_canonical_locale_for_city() for service+city and career+city; index pages use en-us. |

---

## 3. Proof & FAQ (E-E-A-T + Rich Results)

| Check | Status | Notes |
|-------|--------|--------|
| Proof block on services index | **PASS** | "Why Neural Command" with GEO-16 and Answer First Architecture. |
| Proof block on book page | **PASS** | Consultation focus and GEO-16 mentioned in hero. |
| Proof block on generic service page | **PASS** | "Why Neural Command" section after hero. |
| Proof block on Bay Area hub | **PASS** | "Why Neural Command" and "Who We Help". |
| FAQ + FAQPage on services index | **PASS** | ld_faq() in __jsonld; visible FAQ section. |
| FAQ + FAQPage on book page | **PASS** | ld_faq() in __jsonld; visible FAQ. |
| FAQ + FAQPage on generic service page | **PASS** | $serviceFaqs used for both HTML and ld_faq() with @id. |
| FAQ + FAQPage on service+city pages | **PASS** | city_specific_faq_block + Bay Area local_faqs; single FAQPage schema with pool + local FAQs merged. |
| FAQ visible content matches schema | **PASS** | Same $serviceFaqs / $faqs array used for HTML and JSON-LD on service.php and service_city.php. |

---

## 4. Bay Area & Local

| Check | Status | Notes |
|-------|--------|--------|
| Bay Area hub at /en-us/bay-area/ | **PASS** | Route, canonical, proof, FAQ, city links (card-style). |
| Per-city overrides (local_problem, who_we_help, local_faqs) | **PASS** | data/bay_area_city_overrides.json; 9 cities (SF, San Jose, Palo Alto, Oakland, Mountain View, Sunnyvale, Santa Clara, Berkeley, Fremont). |
| Local FAQs in FAQPage schema | **PASS** | service_city merges local_faqs into $faqs before FAQPage output. |
| Nearby cities block on Bay Area city pages | **PASS** | nearby_bay_area_cities_html() in service_city.php. |
| No fabricated local claims | **PASS** | Copy uses "We serve...", methodology, no fake offices. |

---

## 5. Discoverability & Crawl

| Check | Status | Notes |
|-------|--------|--------|
| robots.txt has Sitemap | **PASS** | Sitemap: https://nrlc.ai/sitemaps/sitemap-index.xml and .xml.gz. |
| llms.txt linked in head | **PASS** | <link rel="alternate" type="text/plain" href=".../llms.txt"> in templates/head.php. |
| noindex only on non-money pages | **PASS** | noindex on 404, API, redirects, ineligible .md; not on home, services, book, city pages. |
| Head noindex when router metadata missing | **PASS** | head.php fails closed with noindex in production if __page_meta not set. |

---

## 6. Definition-in-First-100-Words (AI Extractability)

| Check | Status | Notes |
|-------|--------|--------|
| Services index | **PASS** | Definition lock + core service definitions. |
| Service+city | **PASS** | service_definition_lock() in definition-lock block. |
| Generic service | **PASS** | GBP-aligned first sentence (business provides service) + subhead. |
| Book page | **PASS** | Lead and consultation focus. |

---

## Fixes Applied During This QA

1. **Generic service canonicalPath** – Router now sets canonicalPath to actual request path (with locale) or `/en-us` + path so <link rel="canonical"> is e.g. `https://nrlc.ai/en-us/services/generative-seo/`.
2. **service.php schema URLs** – $canonical_url now derived from `__page_meta['canonicalPath']` so WebPage, Service, and FAQPage @id/url match the page canonical.
3. **Service schema provider** – Generic service page Service schema now uses `"provider" => ["@id" => "https://nrlc.ai/#organization"]` for graph consistency.

---

## Optional Next Steps (Not Blocking)

- **serviceArea in GBP** – Add Bay Area (and other) service areas to config/gbp.json and Organization schema; ensure _area_matches_gbp() in schema_builders.php is updated if shape changes.
- **CWV** – Review LCP/CLS on key money pages if GSC or CrUX show issues.
- **More Bay Area cities in overrides** – Add San Mateo, Redwood City, etc. to bay_area_city_overrides.json for more unique local content.

---

## Summary

All critical citeability implementations **pass**: single Person entity, stable Organization/WebSite @ids, locale-prefixed canonicals (including generic service), proof + FAQ + FAQPage on money pages, Bay Area overrides and local FAQs, llms.txt and sitemaps, and noindex only where appropriate. Three fixes were applied during QA (generic service canonical, service.php canonical_url, Service provider @id). The site is in a strong position for AI citation and rich results eligibility.
