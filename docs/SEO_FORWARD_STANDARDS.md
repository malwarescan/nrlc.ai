# SEO Forward Standards — NRLC.ai

**Principle:** Every URL we emit (sitemaps, internal links, canonicals) is the **canonical** indexable URL. No discovery of non-canonical variants first.

---

## 1. Sitemaps

- **Service + city:** Emit locale-prefixed canonical only.  
  `https://nrlc.ai/{locale}/services/{service}/{city}/`  
  `locale` = `get_canonical_locale_for_city($city)` → en-us, en-gb, en-sg, en-au.
- **Career + city + role:** Same rule.  
  `https://nrlc.ai/{locale}/careers/{city}/{role}/`
- **Insights, blog, tools, case-studies, book, catalog, promptware:** Canonical is en-us.  
  Emit `https://nrlc.ai/en-us/insights/...`, `https://nrlc.ai/en-us/book/`, etc.
- **Global hubs** (no locale in URL):  
  `https://nrlc.ai/`, `https://nrlc.ai/services/`, `https://nrlc.ai/insights/`, etc.  
  Keep as-is; these are the canonical hub URLs.

## 2. Internal links

- **Always link to the canonical URL.** Use `absolute_url('/en-us/book/')`, `absolute_url('/en-us/services/')`, etc.
- **Locale-specific sections:** Use default locale in path: `/en-us/insights/...`, `/en-us/learn/`, `/en-us/book/`.
- **Helper:** `lib/seo_forward.php` — `seo_forward_canonical_path($path)` and `seo_forward_canonical_url($path)` for new templates.

## 3. Meta and schema

- **Canonical tag:** Must match the URL that should be indexed (locale-prefixed where that’s the canonical).
- **One canonical per logical page.** No duplicate Person @ids; reference `JOEL_PERSON_ID` only.  
  Organization @id: `https://nrlc.ai/#organization`. WebSite @id: `https://nrlc.ai/#website`.

## 4. New pages

- Set `canonicalPath` in router to the canonical path (with locale if applicable).
- Add meta title (≤60 chars) and description (≤155 chars); include brand where appropriate.
- One H1 per page; primary keyword in first 100 words.
- Add a proof block (40–80 words) and FAQ (3–6) with FAQPage schema on money/authority pages.

## 5. AI / LLM

- Keep `/llms.txt` and link from `<head>` (`rel="alternate" type="text/plain"`).
- Definition or answer-in-first-100-words on key pages for extractability.

---

**Checklist before launch:** Sitemap URLs = canonicals; internal links use `absolute_url()` with canonical path; no duplicate Person/Organization @ids; book and conversion URLs in sitemap.
