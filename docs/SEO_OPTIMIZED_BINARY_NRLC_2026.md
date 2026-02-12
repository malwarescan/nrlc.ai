# NRLC.ai SEO Optimized Binary — Maximum Organic + AI-Citation Visibility

**Website:** https://nrlc.ai  
**Brand:** Neural Command, LLC  
**CMS:** PHP (router + page templates); assume CMS-agnostic where fix is template-level.  
**Primary conversion:** Book a call / Get started form.  
**Target:** High-intent lead gen (AI Search/GEO/AEO), brand entity clarity, service + location queries.  
**Locations:** Santa Monica, CA + national (USA).  
**Related properties:** neuralcommandllc.com, nrlcmd.com, croutons.ai, viontra.com.

### Implementation status (completed)

- **Santa Monica** added to `data/cities.csv`; regenerate sitemaps to include `/en-us/services/.../santa-monica/` URLs.
- **Footer Book link** updated to canonical `absolute_url('/en-us/book/')` in `templates/footer.php`.
- **Services index Person schema:** Full Person block removed; WebPage uses `author` → `@id` reference to `JOEL_PERSON_ID` only (`lib/person_entity.php`).
- **WebSite @id:** `ld_website_with_searchaction()` in `lib/schema_builders.php` now includes `@id` => `https://nrlc.ai/#website`.
- **Services index:** Proof block ("Why Neural Command"), FAQ section (6 Q&As), and FAQPage schema added.
- **Book page:** Proof block in hero, FAQPage schema (6 Q&As), Service schema `provider` → `@id` to Organization, all Related/success links use `absolute_url('/en-us/...')`.
- **Santa Monica** added to popular cities in services "Service Locations" section.

**P2 (continued):** Footer link to neuralcommandllc.com ("Neural Command LLC") added. llms.txt linked in `<head>` via `<link rel="alternate" type="text/plain" href=".../llms.txt">`. robots.txt now lists both `sitemap-index.xml` and `sitemap-index.xml.gz`. Sitemaps regenerated; Santa Monica URLs included in geo/services sitemaps.

**SEO Forward (canonical-first):** Sitemaps now emit only canonical URLs: service+city and career+city use locale from `get_canonical_locale_for_city` (en-us, en-gb, etc.); insights, blog, tools, case-studies, book use en-us. Book page added to index-pages sitemap. `lib/seo_forward.php` and `docs/SEO_FORWARD_STANDARDS.md` added for canonical path/URL helpers and team standards. Header brand and catalog breadcrumb use `absolute_url()` for canonical links. Sitemaps regenerated.

**Next:** Verify sitemap URLs return 200 in production. Optional: CWV/LCP fixes; add proof + FAQ to individual service template for non-city service pages.

---

## TASK 1 — BINARY SPEC (PASS/FAIL CHECKLIST)

### A) Indexation & Crawl Control

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| A1 | robots.txt allows crawling | `User-agent: *` and `Allow: /` present; no accidental `Disallow: /` | Blocked resources in GSC; crawl errors | Already correct. | `public/robots.txt` |
| A2 | Sitemap discoverable | robots.txt contains `Sitemap:` URL; URL returns 200 and valid XML | Sitemap not in robots or 404 | **Fix:** Ensure robots points to index that works. Currently `Sitemap: https://nrlc.ai/sitemaps/sitemap-index.xml.gz` — verify `.xml.gz` is served or use `https://nrlc.ai/sitemaps/sitemap-index.xml` if only XML exists. | `public/robots.txt`; sitemap generation script |
| A3 | No accidental noindex on money pages | All service, book, home, location pages have no `noindex` | Money pages not indexing; "Indexed" count low in GSC | Remove or gate `noindex` so only API, redirects, and non-canonical locale variants use it. | `bootstrap/router.php`, `templates/head.php` |
| A4 | 404 returns noindex | 404 response includes `X-Robots-Tag: noindex,nofollow` | 404s indexed | Already set in router 404 handler. | `bootstrap/router.php` (404 block) |
| A5 | API/form endpoints noindex | `/api/book/` and other API paths send noindex | API URLs in index | Already applied. | `bootstrap/router.php` |

---

### B) Site Architecture & Internal Linking

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| B1 | Canonical URL consistency | One canonical per logical page; trailing slash and locale (e.g. `/en-us/`) consistent | Duplicate canonicals in GSC; "user chose different canonical" | Use `canonicalPath` from router only; ensure all links to book use locale. | Site-wide; footer link fix below |
| B2 | Book/CTA links use canonical | All "Book Consultation" / "Get started" point to `https://nrlc.ai/en-us/book/` | /book/ without locale indexed; link equity split | Replace `/book/` with `<?= absolute_url('/en-us/book/') ?>`. | `templates/footer.php` (line 32): change `href="/book/"` to `href="<?= absolute_url('/en-us/book/') ?>"` |
| B3 | Hub → money page links | Services hub links to each service; home links to services + book | Weak internal link graph to conversion pages | Add explicit links from home and services index to top 5 service URLs and /en-us/book/. | `pages/home/home.php`; `pages/services/index.php` |
| B4 | Related properties linked | At least one contextual link to neuralcommandllc.com, nrlcmd.com (and optionally croutons.ai, viontra.com) from footer or about | Brand entity not reinforced across properties | Add optional "Related" footer block: neuralcommandllc.com, nrlcmd.com with rel="noopener". | `templates/footer.php` or config-driven footer |
| B5 | Breadcrumb schema on all key templates | BreadcrumbList on service, location, and hub pages | No breadcrumb rich results | Use `ld_breadcrumbs()` or page-specific BreadcrumbList; ensure `@id` on key pages. | `lib/schema_builders.php`; each page that sets `$GLOBALS['__jsonld']` |

---

### C) On-Page SEO (Titles, H1, Copy, Intent)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| C1 | Home title ≤60 chars, includes brand | Title 50–60 chars; "Neural Command" or "NRLC" present | Long or unbranded title | Use: `Neural Command (NRLC) \| AI Search Optimization for AI Overviews + ChatGPT` (current is close; verify length). | `bootstrap/router.php` homepage `__page_meta` |
| C2 | Home H1 one per page, intent-clear | Single H1; includes primary offer (e.g. AI Search Optimization) | Multiple H1s; vague H1 | Keep single H1; ensure "AI Search Optimization" or equivalent in H1. | `pages/home/home.php` |
| C3 | Service pages unique title/description | Each service URL has unique meta title and description | Duplicate meta; thin snippets | Use `service_meta_title($serviceSlug, $citySlug)` and `service_meta_description(...)` for city pages; ensure non-city service pages have unique meta. | Router + `lib/service_intent_taxonomy.php`; service template |
| C4 | Book page title/description | Title ≤60 chars; description ≤155; includes "consultation" or "book" | Weak CTR; not ranking for "book AI SEO" | Set: title `Book AI SEO Consultation \| Neural Command`, description `Schedule a consultation for AI Search Optimization, GEO, and AEO. Get a strategy call with NRLC.ai experts.` | `bootstrap/router.php` book route; or `lib/meta_directive.php` if used |
| C5 | Primary keyword in first 100 words | Target keyword (e.g. AI Search Optimization, GEO, Santa Monica) in first 100 words of main content | Weak relevance signal | Add one natural inclusion of primary keyword in opening paragraph. | Per-page content (home, services, location pages) |

---

### D) Entity & E-E-A-T (Brand Clarity, Proof, Authorship)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| D1 | Single canonical Person @id | All author/founder references use `https://nrlc.ai/en-us/about/joel-maldonado/#person` | Multiple Person entities; entity split | Remove any Person schema that mints a new @id. Use `joel_person_author()` or reference by @id only. | `pages/services/index.php` (replace inline Person with reference to JOEL_PERSON_ID); any page with Person schema |
| D2 | Entity home has full Person payload | Only `/en-us/about/joel-maldonado/` has full Person (name, jobTitle, sameAs, image, etc.) | Inconsistent entity definition | Keep full payload only in `pages/about/joel-maldonado.php`; elsewhere only @id + name + url. | `pages/about/joel-maldonado.php`; `pages/services/index.php` |
| D3 | Organization sameAs includes LinkedIn | Organization schema sameAs includes official LinkedIn URL | Weak entity link | Already in gbp.json. Verify `sameAs` in ld_organization() includes LinkedIn. | `config/gbp.json`; `lib/schema_builders.php` |
| D4 | Proof block on money pages | At least one short "proof" block (e.g. methodology, GEO-16, or "used by" / results) on service and book pages | Low E-E-A-T; low trust in SERP | Add 40–80 word proof block (e.g. "Neural Command's GEO-16 framework is used to improve AI citation rates...") on services index, top service page, book page. | `pages/services/index.php`; `pages/book/index.php`; service template |
| D5 | GBP identity match | Site name, address, phone match GBP exactly | NAP inconsistency | Use only gbp_business_name(), gbp_phone(), gbp_address() from config. | `config/gbp.json`; `lib/gbp_config.php`; footer and schema |

---

### E) Structured Data (Schema Strategy + @id Governance)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| E1 | Organization @id stable | One Organization @id: `https://nrlc.ai/#organization` | Multiple org @ids | Use `gbp_website() . '#organization'` everywhere (already in schema_builders). Ensure no other page mints Organization with different @id. | `lib/schema_builders.php`; all pages outputting Organization |
| E2 | WebSite has @id | WebSite schema includes `@id` for reference (e.g. `https://nrlc.ai/#website`) | WebSite not in graph | Add `'@id' => SchemaFixes::ensureHttps(gbp_website()) . '#website'` to ld_website_with_searchaction(). | `lib/schema_builders.php` |
| E3 | Homepage WebPage schema | Home has WebPage with url, name, description, isPartOf → WebSite | Missing WebPage on home | Ensure home pushes WebPage into __jsonld (or use base_schemas + home-specific WebPage). | `pages/home/home.php` (schema block); or router-injected schema |
| E4 | Service pages use Service schema | Each service page (and service+city) has Service type with provider → Organization @id | No Service rich result eligibility | Use ld_service() or equivalent; provider as `@id` reference only. | `pages/services/service_city.php`; service hub |
| E5 | FAQPage where FAQs exist | Any page with 3+ FAQs has FAQPage schema | Missing FAQ rich results | Call ld_faq($faqs) and append to __jsonld where FAQ block exists. | `lib/schema_builders.php`; pages with FAQ sections |
| E6 | No duplicate @ids | No two nodes in same page with same @id | Validation errors; graph confusion | Audit all __jsonld; ensure @ids are unique (e.g. #webpage, #breadcrumb, #service). | All pages setting `$GLOBALS['__jsonld']` |

---

### F) Local SEO (Santa Monica + Service Area)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| F1 | Santa Monica in sitemap/cities | At least one URL with "Santa Monica" or slug santa-monica in sitemap/city list | No Santa Monica pages | Add `santa-monica,US,CA,34.0195,-118.4912,en,.us` to `data/cities.csv`. Regenerate sitemaps. | `data/cities.csv`; sitemap script |
| F2 | Location page for Santa Monica | `/en-us/services/ai-search-optimization/santa-monica/` (or equivalent) exists and 200 | 404 for Santa Monica service | Cities are driven by cities.csv + service_city.php. Adding santa-monica to CSV will create URLs. Ensure router serves `/services/{service}/{city}/` for santa-monica. | `data/cities.csv`; `bootstrap/router.php` (already supports any city in CSV) |
| F3 | Address on site | GBP address appears in footer or contact | No address for local relevance | Already using gbp_address_display() in footer. If empty, fill config/gbp.json (no placeholders). | `config/gbp.json`; `templates/footer.php` |
| F4 | LocalBusiness or Organization with address | Organization schema includes address (PostalAddress) | Local entity weak | ld_organization() already uses gbp_address(). Verify gbp.json has real address. | `lib/schema_builders.php`; `config/gbp.json` |
| F5 | Service area (national) | Either areaServed or copy indicates USA / national | Misleading local-only signal | Use areaServed "US" or "United States" on Organization or Service where appropriate. | Schema and/or service page copy |

---

### G) Page Experience (CWV, Mobile, Speed)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| G1 | Viewport meta | `<meta name="viewport" content="width=device-width, initial-scale=1">` | Mobile UX issues | Already in head.php. | `templates/head.php` |
| G2 | LCP target | LCP < 2.5s on key URLs (measure in PageSpeed Insights) | Red "Poor" in CrUX | Optimize hero image (size/format); defer non-critical JS; ensure LCP element has priority. | Assets; templates |
| G3 | CLS target | CLS < 0.1 | Layout shift | Reserve space for images/ads; avoid inserting above-the-fold content after load. | CSS/templates |
| G4 | No render-blocking above fold | Critical CSS inline or minimal; JS deferred where possible | Slow FCP | Defer non-critical scripts; inline critical CSS for above-fold. | `templates/head.php`; asset pipeline |

*Note: G2–G4 require measurement; fixes are CMS-agnostic.*

---

### H) SERP CTR (Snippet Strategy)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| H1 | Meta description length | All key pages meta description 120–155 chars | Truncation; weak CTR | Trim or expand to 150–155 chars; include primary CTA or outcome. | Per-page meta in router or meta_directive |
| H2 | Title includes brand on key pages | Home and at least services, book use "NRLC" or "Neural Command" in title | Unbranded snippets | Keep current pattern: "... \| NRLC.ai" or "Neural Command" in title. | Router; meta_directive |
| H3 | No duplicate meta descriptions | Unique description per URL | Duplicate snippets in SERP | Use service_meta_description and page-specific descriptions. | Service/location meta generation |

---

### I) AI Retrieval Readiness (Extractability, Chunking, FAQ, Citations)

| # | Requirement | PASS criteria | FAIL symptoms | Exact fix | Where to apply |
|---|-------------|---------------|---------------|-----------|-----------------|
| I1 | llms.txt present and linked | `/llms.txt` exists; linked from home or agent.json | AI crawlers miss site summary | Already exists. Add `<link rel="alternate" type="text/plain" href="https://nrlc.ai/llms.txt" title="LLM-oriented site summary">` in head. | `llms.txt`; `templates/head.php` (optional link) |
| I2 | Definition-in-first-100-words | Key pages state "What we do" or definition in first 100 words | AI extracts wrong or nothing | Home already has definition lock. Replicate pattern on services index and top service page. | `pages/services/index.php`; service_city or service hub |
| I3 | FAQ on key money pages | At least 3–6 FAQs on services index and book page | No FAQ schema; weak answer targeting | Add FAQ section + ld_faq() on services index and book page. | `pages/services/index.php`; `pages/book/index.php` |
| I4 | Speakable where appropriate | SpeakableSpecification on key paragraphs (optional but helps) | — | Already on services WebPage. Add to home if desired. | `pages/home/home.php` schema |
| I5 | agent.json for AI agents | `/agent.json` exists and describes site/brand | — | Verify agent.json is reachable and accurate. | `agent/` or `public/` |

---

## TASK 2 — PRIORITIZED EXECUTION PLAN

| Priority | Item | Impact | Effort | Owner | Dependency |
|----------|------|--------|--------|-------|------------|
| **P0 (today)** | Add Santa Monica to cities.csv; regenerate sitemaps | H | S | Dev | None |
| **P0** | Fix footer Book link to canonical /en-us/book/ | M | S | Dev | None |
| **P0** | Replace services index Person schema with canonical Person @id reference only | H | S | Dev | person_entity.php |
| **P1 (this week)** | Add WebSite @id to ld_website_with_searchaction() | M | S | Dev | schema_builders.php |
| **P1** | Add proof block (40–80 words) to services index and book page | M | S | Content | — |
| **P1** | Add FAQ section + FAQPage schema to services index and book page | H | M | Content + Dev | ld_faq() |
| **P1** | Ensure sitemap URL in robots.txt returns 200 (fix .xml vs .xml.gz if needed) | H | S | Dev | robots.txt; sitemap script |
| **P2 (this month)** | Add 6 FAQs + proof block to top 5 service pages (see Task 4) | M | M | Content | — |
| **P2** | Add related-properties links (neuralcommandllc.com, nrlcmd.com) in footer | L | S | Dev | footer |
| **P2** | CWV audit and LCP/CLS fixes on home and top service pages | H | L | Dev/Design | PageSpeed data |
| **P2** | Optional: link llms.txt in head for AI crawlers | L | S | Dev | head.php |

---

## TASK 3 — URL MAP (COMPILED BLUEPRINT)

**Intent silos: 1) Money 2) Proof 3) Comparisons 4) Location 5) Resource hub.**

| URL | Intent | Primary keyword target |
|-----|--------|-------------------------|
| **Money pages (services)** | | |
| https://nrlc.ai/en-us/ | Home / brand | Neural Command, AI Search Optimization |
| https://nrlc.ai/en-us/services/ | Services hub | AI SEO services, GEO AEO services |
| https://nrlc.ai/en-us/services/ai-search-optimization/ | Service | AI search optimization |
| https://nrlc.ai/en-us/services/site-audits/ | Service | AI first site audit |
| https://nrlc.ai/en-us/services/crawl-clarity/ | Service | Crawl clarity engineering |
| https://nrlc.ai/en-us/services/json-ld-strategy/ | Service | JSON-LD structured data |
| https://nrlc.ai/en-us/services/llm-seeding/ | Service | LLM seeding citation |
| https://nrlc.ai/en-us/book/ | Conversion | Book AI SEO consultation |
| **Proof pages** | | |
| https://nrlc.ai/en-us/case-studies/ | Proof hub | AI SEO case studies |
| https://nrlc.ai/en-us/generative-engine-optimization/ | Methodology | Generative engine optimization |
| https://nrlc.ai/en-us/answer-first-architecture/ | Methodology | Answer first architecture AEO |
| https://nrlc.ai/en-us/ai-optimization/ | Methodology hub | AI optimization |
| **Comparisons / alternatives** | | |
| https://nrlc.ai/en-us/services/ (positioning) | Compare | AI SEO agency, GEO agency |
| (Optional) /alternatives/ or /vs-agencies/ | Compare | "AI SEO agency alternatives" |
| **Location pages** | | |
| https://nrlc.ai/en-us/services/ai-search-optimization/santa-monica/ | Geo service | AI search optimization Santa Monica |
| https://nrlc.ai/en-us/services/ai-search-optimization/los-angeles/ | Geo service | AI search optimization Los Angeles |
| https://nrlc.ai/en-us/services/ai-search-optimization/new-york/ | Geo service | AI search optimization New York |
| ... (other cities from cities.csv) | Geo service | [Service] [City] |
| (Optional) /location/ or /santa-monica/ landing | Location | AI SEO Santa Monica, Neural Command Santa Monica |
| **Resource hub** | | |
| https://nrlc.ai/en-us/insights/ | Hub | AI search insights |
| https://nrlc.ai/en-us/learn/ | Hub | Learn AI SEO, GEO training |
| https://nrlc.ai/en-us/glossary/ | Hub | AI search glossary |
| https://nrlc.ai/en-us/field-notes/ | Hub | AI search field notes |
| https://nrlc.ai/en-us/about/joel-maldonado/ | Entity home | Joel Maldonado, AI Search Researcher |

*Total: 20+ URLs; expand with more city×service combos from cities.csv.*

---

## TASK 4 — PAGE ASSETS FOR TOP 8 PRIORITY PAGES

### 1. Home (already strong; refinements)

- **URL slug / canonical:** `/` → canonical `https://nrlc.ai/en-us/` (or root with locale).
- **Title tag (5 variants, ≤60 chars):**
  1. Neural Command (NRLC) | AI Search Optimization for AI Overviews + ChatGPT  
  2. AI Search Optimization | GEO & AEO | Neural Command  
  3. Neural Command | AI Search Optimization, GEO & AEO Research & Implementation  
  4. NRLC.ai | AI Search Optimization for ChatGPT, Perplexity & Google AI  
  5. Neural Command | Leading GEO & AEO Research & Implementation  
- **Meta description (5 variants, ≤155 chars):**
  1. Leading research and implementation agency for AI Search Optimization (GEO/AEO). Win citations in Google AI Overviews, ChatGPT, and Perplexity.  
  2. Neural Command helps brands get cited in AI search. GEO, AEO, structured data, and AI visibility. Book a consultation.  
  3. We research and implement AI Search Optimization so your brand appears in ChatGPT, Perplexity, and Google AI Overviews.  
  4. GEO and AEO from the team that documents how AI systems cite content. Strategy and implementation for AI-powered search.  
  5. Get cited in AI search. Neural Command delivers AI Search Optimization, GEO-16, and structured data for enterprises.  
- **H1:** Joel Maldonado @ Neural Command: Leading AI Search Optimization Research & Implementation  
- **H2/H3 outline:** Core Terminology (AEO, GEO, AI Search Optimization); About This Knowledge Base; Knowledge Base Sections; [existing sections].  
- **Above-the-fold (120–180 words):** Keep current definition lock + lead; ensure "Neural Command" and "AI Search Optimization" in first 100 words.  
- **Proof block (40–80 words):** "Neural Command's GEO-16 methodology and Answer First Architecture are used to improve AI citation rates and visibility in Google AI Overviews, ChatGPT, and Perplexity. Our research documents retrieval mechanics and citation patterns that determine how AI systems select and cite businesses."  
- **FAQ (6):** What is AEO? What is GEO? What is AI Search Optimization? Who is Neural Command? How do I get cited in AI search? Where is Neural Command located?  
- **Internal links (8):** Services → /en-us/services/; Book Consultation → /en-us/book/; Generative Engine Optimization → /en-us/generative-engine-optimization/; Answer First Architecture → /en-us/answer-first-architecture/; AI Search Diagnostics → /en-us/ai-search-diagnostics/; Case Studies → /en-us/case-studies/; About Joel → /en-us/about/joel-maldonado/; Training → /en-us/training/.

---

### 2. Services index

- **URL / canonical:** `/en-us/services/`  
- **Title (5):**  
  1. AI SEO & AI Visibility Services | Neural Command  
  2. GEO & AEO Services | AI Search Optimization | NRLC.ai  
  3. AI Search Optimization Services | Structured Data & GEO | Neural Command  
  4. Professional AI SEO Services | GEO, AEO, Site Audits | NRLC.ai  
  5. AI Visibility & Citation Services | Neural Command  
- **Meta description (5):**  
  1. Enterprise AI Search Optimization: GEO, AEO, site audits, structured data, and LLM citation. Book a consultation with Neural Command.  
  2. Get cited in ChatGPT, Perplexity, and Google AI Overviews. Our services include crawl clarity, JSON-LD, and AI visibility analytics.  
  3. From site audits to GEO-16 implementation—AI SEO services for brands that need real AI citation growth.  
  4. Technical SEO, structured data, and AI visibility services. SMB to enterprise. Santa Monica & nationwide.  
  5. AI-first site audits, schema markup, and training. The research-backed approach to AI search visibility.  
- **H1:** AI SEO and AI Visibility Services  
- **H2/H3:** [Keep existing service list]; add "Why Neural Command" (proof); "Frequently Asked Questions."  
- **Above-the-fold:** 120–180 words: define AI SEO services, GEO/AEO, and primary outcomes (citations, visibility); include "AI Search Optimization" and "Neural Command" early.  
- **Proof block:** "Neural Command implements the GEO-16 framework and Answer First Architecture to improve how often brands are cited in AI-generated answers. Our methodology is documented in peer-observed research and applied across site audits, structured data, and training."  
- **FAQ (6):** What is AI Search Optimization? What is GEO? What is AEO? Do you work with SMBs? Do you serve Santa Monica and LA? How do I get started?  
- **Internal links (8):** Book Consultation → /en-us/book/; AI Search Optimization → /en-us/services/ai-search-optimization/; Site Audits → /en-us/services/site-audits/; Crawl Clarity → /en-us/services/crawl-clarity/; Generative Engine Optimization → /en-us/generative-engine-optimization/; Case Studies → /en-us/case-studies/; Santa Monica → /en-us/services/ai-search-optimization/santa-monica/ (once live); About Joel → /en-us/about/joel-maldonado/.

---

### 3. AI Search Optimization (service)

- **URL / canonical:** `/en-us/services/ai-search-optimization/`  
- **Title (5):**  
  1. AI Search Optimization | GEO & AEO | Neural Command  
  2. AI Search Optimization Services | ChatGPT & AI Overviews | NRLC.ai  
  3. Get Cited in AI Search | AI Search Optimization | Neural Command  
  4. AI Search Optimization for Brands | GEO-16 | NRLC.ai  
  5. Professional AI Search Optimization | Neural Command  
- **Meta description (5):**  
  1. Improve how your brand appears in Google AI Overviews, ChatGPT, and Perplexity. GEO and AEO implementation from Neural Command.  
  2. AI Search Optimization that increases citations in AI-generated answers. Structured data, entity clarity, retrieval signals.  
  3. We implement GEO-16 and AEO strategies so AI systems cite your content. Strategy and technical implementation.  
  4. From diagnostics to implementation—AI Search Optimization for SMB and enterprise. Book a consultation.  
  5. Research-backed AI Search Optimization. Citations in ChatGPT, Perplexity, and Google AI Overviews.  
- **H1:** AI Search Optimization  
- **H2/H3:** What Is AI Search Optimization? What We Deliver; Why Neural Command; Process; FAQ.  
- **Above-the-fold:** Define AI Search Optimization in first 100 words; mention GEO, AEO, citations, and Neural Command.  
- **Proof block:** "Our AI Search Optimization work applies the GEO-16 methodology and Answer First Architecture to improve citation frequency. We focus on entity clarity, structured data, and retrieval-friendly content."  
- **FAQ (6):** What is AI Search Optimization? How is it different from SEO? What is GEO? What is AEO? How long until we see results? Do you work nationwide?  
- **Internal links (8):** Services → /en-us/services/; Book → /en-us/book/; Site Audits → /en-us/services/site-audits/; Crawl Clarity → /en-us/services/crawl-clarity/; GEO → /en-us/generative-engine-optimization/; Santa Monica → /en-us/services/ai-search-optimization/santa-monica/; Case Studies → /en-us/case-studies/; Training → /en-us/training/.

---

### 4. Book / Get started

- **URL / canonical:** `https://nrlc.ai/en-us/book/`  
- **Title (5):**  
  1. Book AI SEO Consultation | Neural Command  
  2. Schedule AI Search Optimization Call | NRLC.ai  
  3. Get Started | AI SEO Consultation | Neural Command  
  4. Book a GEO & AEO Strategy Call | NRLC.ai  
  5. Free AI Search Consultation | Neural Command  
- **Meta description (5):**  
  1. Schedule a consultation for AI Search Optimization, GEO, and AEO. Get a strategy call with Neural Command experts.  
  2. Book a call to discuss AI visibility, structured data, and citation strategy. No obligation. Response within 24 hours.  
  3. Get your AI search strategy session. We'll review your visibility in ChatGPT, Perplexity, and Google AI Overviews.  
  4. Book a consultation with NRLC.ai. AI Search Optimization, GEO-16, and implementation support.  
  5. Start with a free consultation. Discuss GEO, AEO, and how to get cited in AI-powered search.  
- **H1:** Book an AI SEO Consultation  
- **H2/H3:** What to Expect; Why Book With Neural Command; FAQ.  
- **Above-the-fold:** 120–180 words: what the consultation covers (AI visibility, GEO/AEO, next steps); CTA above fold.  
- **Proof block:** "Neural Command consultations focus on your current AI visibility and a clear path to improvement. We use GEO-16 and Answer First Architecture to guide strategy and implementation."  
- **FAQ (6):** What happens in the consultation? Is it free? How long is the call? Do you work with small businesses? Do you serve Santa Monica and LA? What if I'm not ready to implement?  
- **Internal links (8):** Services → /en-us/services/; AI Search Optimization → /en-us/services/ai-search-optimization/; GEO → /en-us/generative-engine-optimization/; Case Studies → /en-us/case-studies/; About → /en-us/about/joel-maldonado/; Training → /en-us/training/; Contact → /en-us/ (contact=1); Home → /en-us/.

---

### 5. Santa Monica (service + city)

- **URL / canonical:** `https://nrlc.ai/en-us/services/ai-search-optimization/santa-monica/` (after adding city).  
- **Title (5):**  
  1. AI Search Optimization Santa Monica | Neural Command  
  2. AI SEO & GEO Santa Monica, CA | NRLC.ai  
  3. Santa Monica AI Search Optimization | Get Cited in AI | Neural Command  
  4. GEO & AEO Santa Monica | AI Visibility | NRLC.ai  
  5. AI Search Optimization Santa Monica, CA | Neural Command  
- **Meta description (5):**  
  1. AI Search Optimization for Santa Monica and LA. GEO, AEO, and structured data. Neural Command is based in Santa Monica. Book a consultation.  
  2. Get cited in AI search. We serve Santa Monica, Los Angeles, and nationwide. AI Search Optimization and GEO-16 implementation.  
  3. Santa Monica-based AI SEO agency. Improve visibility in ChatGPT, Perplexity, and Google AI Overviews.  
  4. Neural Command offers AI Search Optimization in Santa Monica. Strategy and implementation for AI citations.  
  5. GEO and AEO for Santa Monica businesses. Structured data, site audits, and AI visibility. Book a call.  
- **H1:** AI Search Optimization in Santa Monica  
- **H2/H3:** Why Santa Monica Businesses Need AI Search Optimization; What We Deliver; Why Neural Command; Process; Service Area; FAQ.  
- **Above-the-fold:** 120–180 words: Santa Monica + LA relevance; AI Search Optimization and GEO/AEO; Neural Command based in Santa Monica.  
- **Proof block:** "Neural Command is headquartered in Santa Monica and serves businesses locally and nationwide. Our GEO-16 and AEO methodologies help brands get cited in AI-generated search results."  
- **FAQ (6):** Do you serve Santa Monica? What is AI Search Optimization? What is GEO? How do I get started? Do you work with SMBs in LA? What does a typical engagement include?  
- **Internal links (8):** Services → /en-us/services/; AI Search Optimization (national) → /en-us/services/ai-search-optimization/; Book → /en-us/book/; Los Angeles → /en-us/services/ai-search-optimization/los-angeles/; Case Studies → /en-us/case-studies/; GEO → /en-us/generative-engine-optimization/; About → /en-us/about/joel-maldonado/; Home → /en-us/.

---

### 6. Generative Engine Optimization (methodology)

- **URL / canonical:** `/en-us/generative-engine-optimization/`  
- **Title (5):**  
  1. Generative Engine Optimization (GEO) | Neural Command  
  2. What Is GEO? Research & Implementation | NRLC.ai  
  3. GEO for AI Search | ChatGPT, Perplexity, AI Overviews | Neural Command  
  4. Generative Engine Optimization Guide | GEO-16 | NRLC.ai  
  5. GEO Research & Implementation | Neural Command  
- **Meta (5):**  
  1. Neural Command's research on Generative Engine Optimization (GEO). How AI systems retrieve and cite content. Implementation for ChatGPT, Perplexity, AI Overviews.  
  2. GEO is optimizing for generative AI search. Learn our methodology and how we implement it for brands.  
  3. Foundational GEO research and implementation. Retrieval signals, citation patterns, and extractability.  
  4. What is GEO? How it differs from SEO. Our GEO-16 framework and implementation services.  
  5. GEO for ChatGPT, Perplexity, and Google AI Overviews. Research-backed implementation from Neural Command.  
- **H1:** Generative Engine Optimization (GEO)  
- **H2/H3:** What Is GEO? When SEO Stops Explaining; Our Research; Implementation; FAQ.  
- **Above-the-fold:** Define GEO in first 100 words; mention Neural Command and key surfaces (ChatGPT, Perplexity, AI Overviews).  
- **Proof block:** "Neural Command documents GEO through systematic research and implements it via the GEO-16 framework. Our work focuses on retrieval signal engineering and citation-ready content."  
- **FAQ (6):** What is GEO? How is GEO different from SEO? What is GEO-16? Which AI systems does GEO target? How do I get started with GEO? Who is Neural Command?  
- **Internal links (8):** Services → /en-us/services/; Book → /en-us/book/; AEO → /en-us/answer-first-architecture/; AI Search Optimization → /en-us/services/ai-search-optimization/; Case Studies → /en-us/case-studies/; Insights → /en-us/insights/; About Joel → /en-us/about/joel-maldonado/; Training → /en-us/training/.

---

### 7. Case studies index

- **URL / canonical:** `/en-us/case-studies/`  
- **Title (5):**  
  1. AI SEO & GEO Case Studies | Neural Command  
  2. Case Studies | AI Search Optimization Results | NRLC.ai  
  3. GEO & AEO Case Studies | Neural Command  
  4. AI Visibility Case Studies | Neural Command  
  5. Client Results | AI Search Optimization | NRLC.ai  
- **Meta (5):**  
  1. Case studies in AI Search Optimization, GEO, and AEO. How Neural Command improves AI citations and visibility.  
  2. Real outcomes: AI visibility, structured data, and citation growth. Case studies by industry.  
  3. See how we implement GEO and AEO for ecommerce, B2B, healthcare, and more.  
  4. Neural Command case studies. Methodology and results in AI-powered search.  
  5. From audits to implementation—case studies in AI search optimization.  
- **H1:** AI Search Optimization Case Studies  
- **H2/H3:** By industry (e.g. Ecommerce, B2B, Healthcare); Methodology; FAQ.  
- **Above-the-fold:** What these case studies show (AI visibility, GEO/AEO, outcomes); mention Neural Command.  
- **Proof block:** "These case studies illustrate how Neural Command's GEO-16 and AEO methodologies improve AI citation rates and visibility across industries."  
- **FAQ (6):** What types of projects do you document? Which industries? How do you measure success? Can I see a similar case? How do I get started? Where is Neural Command based?  
- **Internal links (8):** Services → /en-us/services/; Book → /en-us/book/; GEO → /en-us/generative-engine-optimization/; Ecommerce case → (specific); B2B case → (specific); About → /en-us/about/joel-maldonado/; Santa Monica → /en-us/services/ai-search-optimization/santa-monica/; Training → /en-us/training/.

---

### 8. About Joel (entity home)

- **URL / canonical:** `https://nrlc.ai/en-us/about/joel-maldonado/`  
- **Title (5):**  
  1. Joel Maldonado | AI Search Optimization Researcher | NRLC.ai  
  2. Joel Maldonado | Founder, Neural Command | GEO & AEO  
  3. About Joel Maldonado | Neural Command  
  4. Joel Maldonado | AI Search Researcher | NRLC.ai  
  5. Joel Maldonado | GEO & AEO Research | Neural Command  
- **Meta (5):**  
  1. Joel David Maldonado is an AI Search Optimization Researcher. Founder of Neural Command, LLC. Structured data, knowledge graphs, and answer engine optimization.  
  2. Joel Maldonado leads research and implementation of GEO and AEO at Neural Command. Over 10 years in technical SEO and structured data.  
  3. Founder of Neural Command. Research focuses on how AI systems extract, cite, and surface authoritative content in generative search.  
  4. Joel Maldonado: AI Search Optimization, GEO-16, LLM Search Strategy Framework. Based in Santa Monica.  
  5. Meet the founder. Joel Maldonado researches and implements AI Search Optimization for Neural Command.  
- **H1:** Joel Maldonado  
- **H2/H3:** Profile Links; Areas of Expertise; [existing].  
- **Above-the-fold:** Keep current lead; ensure "Neural Command," "AI Search Optimization," "Santa Monica" or "founded Neural Command" early.  
- **Proof block:** "Joel has developed frameworks including the LLM Search Strategy Framework and GEO-16 methodology for AI citation optimization. His research focuses on how AI systems extract, cite, and surface authoritative content."  
- **FAQ (6):** Who is Joel Maldonado? What is Neural Command? What is GEO-16? Where is Joel based? How can I work with Neural Command? What does Joel specialize in?  
- **Internal links (8):** Neural Command / Home → /en-us/; Services → /en-us/services/; Book → /en-us/book/; GEO → /en-us/generative-engine-optimization/; LinkedIn (external); Medium (external); GitHub (external); Case Studies → /en-us/case-studies/.

---

## TASK 5 — STRUCTURED DATA PACK (NRLC.AI)

Production-ready JSON-LD. Use stable @ids under `https://nrlc.ai/#...` and `https://nrlc.ai/.../#...`. Address/phone only if present on site (from GBP); otherwise TODO.

### Site-wide: Organization

```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "@id": "https://nrlc.ai/#organization",
  "name": "Neural Command, LLC",
  "legalName": "Neural Command, LLC",
  "url": "https://nrlc.ai",
  "logo": {
    "@type": "ImageObject",
    "url": "https://nrlc.ai/assets/images/nrlc-logo.png",
    "width": 43,
    "height": 43
  },
  "sameAs": [
    "https://www.linkedin.com/company/neural-command/",
    "https://g.co/kgs/EP6p5de"
  ],
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "1639 11th St suite 110-a",
    "addressLocality": "Santa Monica",
    "addressRegion": "CA",
    "postalCode": "90404",
    "addressCountry": "US"
  },
  "telephone": "+1 844-568-4624"
}
```

*If address/telephone must not appear on site, omit them in markup and add a TODO in code to pull from gbp_config when approved.*

### Site-wide: WebSite

```json
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "@id": "https://nrlc.ai/#website",
  "url": "https://nrlc.ai/en-us/",
  "name": "NRLC.ai",
  "publisher": { "@id": "https://nrlc.ai/#organization" },
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://nrlc.ai/?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
```

### Home: WebPage (home)

```json
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "https://nrlc.ai/en-us/#webpage",
  "url": "https://nrlc.ai/en-us/",
  "name": "Neural Command (NRLC) | AI Search Optimization for AI Overviews + ChatGPT",
  "description": "Leading research and implementation agency for AI Search Optimization (GEO/AEO). We help enterprise brands win citations in Google AI Overviews, ChatGPT, and Perplexity through technical excellence.",
  "isPartOf": { "@id": "https://nrlc.ai/#website" },
  "about": { "@id": "https://nrlc.ai/#organization" },
  "inLanguage": "en-US"
}
```

### LocalBusiness (optional — use if you want local rich results)

Use only if you explicitly want LocalBusiness; otherwise Organization + address is enough.

```json
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "@id": "https://nrlc.ai/#localbusiness",
  "name": "Neural Command, LLC",
  "url": "https://nrlc.ai",
  "image": "https://nrlc.ai/assets/images/nrlc-logo.png",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "1639 11th St suite 110-a",
    "addressLocality": "Santa Monica",
    "addressRegion": "CA",
    "postalCode": "90404",
    "addressCountry": "US"
  },
  "telephone": "+1 844-568-4624",
  "areaServed": { "@type": "Country", "name": "United States" },
  "parentOrganization": { "@id": "https://nrlc.ai/#organization" }
}
```

### BreadcrumbList pattern (generic)

```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "@id": "https://nrlc.ai/en-us/services/#breadcrumb",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://nrlc.ai/en-us/" },
    { "@type": "ListItem", "position": 2, "name": "Services", "item": "https://nrlc.ai/en-us/services/" }
  ]
}
```

Use `absolute_url()` and current path in production. For service+city: Home → Services → [Service name] → [City].

### Service schema pattern (for service pages)

```json
{
  "@context": "https://schema.org",
  "@type": "Service",
  "@id": "https://nrlc.ai/en-us/services/ai-search-optimization/#service",
  "name": "AI Search Optimization",
  "description": "Professional AI Search Optimization that improves how your brand appears in Google AI Overviews, ChatGPT, Perplexity, and other generative search engines. Includes GEO and AEO implementation.",
  "serviceType": "AI Search Optimization",
  "provider": { "@id": "https://nrlc.ai/#organization" },
  "areaServed": { "@type": "Country", "name": "United States" },
  "url": "https://nrlc.ai/en-us/services/ai-search-optimization/"
}
```

For city pages, append " in [City]" to name and set areaServed to the city/region as appropriate.

### FAQPage pattern

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "@id": "https://nrlc.ai/en-us/services/#faq",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is AI Search Optimization?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "AI Search Optimization is the practice of optimizing content and technical signals so that AI systems like ChatGPT, Perplexity, and Google AI Overviews can retrieve, evaluate, and cite your brand. It includes GEO (Generative Engine Optimization) and AEO (Answer Engine Optimization)."
      }
    },
    {
      "@type": "Question",
      "name": "How do I get started?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Book a consultation at nrlc.ai/en-us/book/. We'll review your current AI visibility and outline a strategy for GEO and AEO implementation."
      }
    }
  ]
}
```

Add more questions per page; keep answers concise. Use `ld_faq($faqs)` in PHP where you have an array of q/a.

---

## TASK 6 — GO LIVE GATE

### Remaining FAIL items only (must fix before “go live” for this binary)

1. **F1/F2 — Santa Monica missing:** Add `santa-monica,US,CA,34.0195,-118.4912,en,.us` to `data/cities.csv`; regenerate sitemaps so Santa Monica service URLs exist and are listed.
2. **B2 — Footer Book link:** Change `href="/book/"` to `href="<?= absolute_url('/en-us/book/') ?>"` in `templates/footer.php`.
3. **D1/D2 — Services index Person schema:** In `pages/services/index.php`, remove the inline Person object that mints a new @id. Replace with a reference: `"author": { "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person" }` (and ensure no full Person payload there). Use `joel_person_author()` from `lib/person_entity.php` where author is needed.
4. **A2 — Sitemap URL:** Verify the URL in robots.txt (`sitemap-index.xml.gz` or `.xml`) returns 200 and valid content; fix path or generation if not.
5. **E2 — WebSite @id:** Add `'@id' => 'https://nrlc.ai/#website'` to the WebSite schema in `lib/schema_builders.php` (ld_website_with_searchaction).

### The single highest-leverage next change

**Add Santa Monica to `data/cities.csv` and fix the footer Book link.**

- **Why:** Santa Monica is your stated location and GBP address; without it you have no dedicated location page for your own city. The footer Book link is the most repeated CTA; making it canonical ensures one clear conversion URL and avoids duplicate indexing of /book/.
- **Action:**  
  1. Append one line to `data/cities.csv`: `santa-monica,US,CA,34.0195,-118.4912,en,.us`  
  2. In `templates/footer.php`, replace `<a href="/book/">` with `<a href="<?= absolute_url('/en-us/book/') ?>">`  
  3. Regenerate sitemaps so `/en-us/services/.../santa-monica/` URLs are included.

---

*Document version: 1.0. CMS: PHP. Assumptions: locale canonical is en-us for US pages; book form posts to /api/book/; related properties (neuralcommandllc.com, nrlcmd.com, croutons.ai, viontra.com) are cross-linked only where you confirm.*
