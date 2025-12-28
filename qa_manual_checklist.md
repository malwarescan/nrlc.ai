# Manual QA Checklist - Per URL

**Use this checklist for every URL in GSC Pages.csv**

## URL: `_________________`

### PHASE 1: INVENTORY & CLASSIFICATION

- [ ] **Locale:** `en-us` / `en-gb` / `other: _____`
- [ ] **Country Target:** `UK` / `US` / `Global`
- [ ] **City Target:** `_________________`
- [ ] **Intent Type:** `Local service` / `National service` / `Informational`
- [ ] **Page Type:** `Service` / `City` / `Blog` / `Product`

**Validation:**
- [ ] City Target matches Locale Country (UK city → en-gb, US city → en-us)
- [ ] If mismatch → **FAIL** (redirect required)

---

### PHASE 2: DISCOVERY QA (GSC URL Inspection)

**Go to:** Google Search Console → URL Inspection → Enter URL

#### Required Outcomes (PASS if ANY):
- [ ] "URL is on Google" ✅
- [ ] "URL is not indexed" BUT has:
  - [ ] Last crawl date: `_________________`
  - [ ] Referring sitemap: `_________________`
  - [ ] Referring page: `_________________`

#### FAIL Conditions (any one = FAIL):
- [ ] "URL is unknown to Google" ❌
- [ ] "No referring sitemaps detected" ❌
- [ ] "Referring page: None detected" ❌
- [ ] Crawl = N/A ❌

**If FAIL → Immediate Actions:**
- [ ] Add URL to submitted sitemap
- [ ] Add at least 1 internal link from indexed page
- [ ] Ensure locale root (/en-gb/, /en-us/) is navigable

---

### PHASE 3: CANONICAL CONSISTENCY QA

**Still in URL Inspection:**

- [ ] **User-declared canonical:** `_________________`
- [ ] **Google-selected canonical:** `_________________`
- [ ] **Canonical URL:** `_________________`

**Validation:**
- [ ] User-declared canonical exists
- [ ] Google-selected canonical matches user-declared
- [ ] Canonical URL is indexable (check in URL Inspection)

**FAIL Scenarios:**
- [ ] "Duplicate, Google chose different canonical" ❌
- [ ] Google canonical points to different locale ❌
- [ ] Google canonical points to non-discoverable URL ❌
- [ ] Google canonical points to redirected URL ❌
- [ ] Google canonical points to non-indexed URL ❌

**Hard Rules:**
- [ ] City pages → single locale only
- [ ] No identical city pages across locales
- [ ] Canonical target is in sitemap
- [ ] Canonical target is internally linked
- [ ] Canonical target is crawlable

---

### PHASE 4: LOCALE & HREFLANG QA

**Check page source for hreflang tags:**

- [ ] Hreflang exists: `Yes` / `No`

**If hreflang exists:**
- [ ] Bidirectional linking (A → B and B → A)
- [ ] Self-referencing hreflang present
- [ ] Canonical + hreflang locale match

**If hreflang does NOT exist:**
- [ ] No duplicate content across locales
- [ ] Content is unique per locale

**Validation:**
- [ ] All hreflang URLs are discoverable
- [ ] All hreflang URLs are in sitemap
- [ ] All hreflang URLs are internally linked

---

### PHASE 5: SITEMAP QA

**Go to:** GSC → Sitemaps

**For each sitemap:**
- [ ] Status = `Success`
- [ ] Submitted date: `_________________`
- [ ] URLs discovered: `_________________`

**Spot Check URLs:**
- [ ] URL is not redirected (200 OK)
- [ ] URL is not canonically overridden
- [ ] URL resolves correctly

**Required Sitemap Rules:**
- [ ] en-us URLs only in en-us sitemap
- [ ] en-gb URLs only in en-gb sitemap
- [ ] No mixed-locale sitemaps
- [ ] No orphaned locale URLs

**If URL not in sitemap:**
- [ ] Add to appropriate sitemap
- [ ] Resubmit sitemap to GSC
- [ ] Verify in next crawl

---

### PHASE 6: INTERNAL LINK GRAPH QA

**Answer these questions:**

- [ ] Is it linked from a locale hub? `Yes` / `No`
  - If No → Add link from `/en-gb/services/` or `/en-us/services/`
- [ ] Is it linked from another indexed page? `Yes` / `No`
  - If No → Add internal link
- [ ] Is anchor text relevant? `Yes` / `No`
  - Example: "Local SEO in Norwich" for `/en-gb/services/local-seo-ai/norwich/`

**FAIL Conditions:**
- [ ] Orphaned URL (no internal links) ❌
- [ ] Only linked from footer ❌
- [ ] Only linked from non-indexed pages ❌

**Internal Linking Requirements:**
- [ ] At least 1 link from locale hub
- [ ] At least 1 link from related service page
- [ ] Anchor text includes city name
- [ ] Link uses correct locale

---

### PHASE 7: INTENT ELIGIBILITY QA (After Indexing)

**Using Queries.csv, find queries for this URL:**

**Top Queries:**
1. `_________________` (Impressions: `_____`, Position: `_____`)
2. `_________________` (Impressions: `_____`, Position: `_____`)
3. `_________________` (Impressions: `_____`, Position: `_____`)

**Intent Classification:**
- [ ] Local commercial
- [ ] National commercial
- [ ] Informational

**Red Flags:**
- [ ] Local queries + remote-only positioning ❌
- [ ] City queries + no local proof ❌
- [ ] High impressions + position > 50 consistently ❌

**Validation:**
- [ ] Queries match page intent
- [ ] Position is competitive (< 20 for commercial)
- [ ] CTR > 0% (if impressions > 100)

---

### PHASE 8: AUTOMATED FAIL-SAFE RULES

**These should be enforced in CI/CD:**

- [ ] **Rule 1:** No city page without sitemap inclusion
  - URL matches `/services/*/{city}/`
  - URL is present in sitemap

- [ ] **Rule 2:** No duplicate city across locales
  - Same {city} exists in only one locale
  - OR content + intent is explicitly differentiated

- [ ] **Rule 3:** No canonical to undiscoverable URL
  - Canonical target appears in sitemap index
  - Canonical target is internally linked

---

## FINAL VERDICT

- [ ] **PASS** - URL is eligible to rank
- [ ] **FAIL** - Critical issues found (see above)
- [ ] **WARN** - Minor issues, review recommended

**Issues Found:**
1. `_________________`
2. `_________________`
3. `_________________`

**Actions Taken:**
1. `_________________`
2. `_________________`
3. `_________________`

---

**Next Review Date:** `_________________`

