# LOCALE CANONICALIZATION PLAN

**Date:** 2025-01-27  
**Goal:** Eliminate duplicate locale pages and route queries to correct canonical URLs

---

## POLICY

### Rule 1: UK City Pages → en-gb Canonical
**IF** a page targets a UK city (Norwich, Stockport, Stoke-on-Trent, Derby, Southport, Huddersfield, Blackpool, Burnley, Oldham, Halifax, Sudbury, Nottingham, Sheffield, Southampton)  
**THEN** canonical must be `/en-gb/services/{service}/{city}/`  
**ACTION:** 301 redirect all non-en-gb versions to en-gb canonical

### Rule 2: US City Pages → en-us Canonical
**IF** a page targets a US city  
**THEN** canonical must be `/en-us/services/{service}/{city}/`  
**ACTION:** 301 redirect all non-en-us versions to en-us canonical

### Rule 3: No Fake Translations
**IF** a locale page is not genuinely translated and targeted  
**THEN** it must NOT be indexable  
**ACTION:** 301 redirect to canonical OR noindex + canonical to canonical locale

### Rule 4: Hreflang Only for Real Translations
**IF** you can't translate yet  
**THEN** don't pretend — use one strong locale  
**ACTION:** Only publish hreflang for languages you truly support

---

## UK CITY REDIRECT TARGETS

### High Priority (P0 — Fix This Week):

| Current URL (Non-Canonical) | Canonical Target | Action |
|------------------------------|------------------|--------|
| `/en-us/services/semantic-seo-ai/stoke-on-trent/` | `/en-gb/services/local-seo-ai/stoke-on-trent/` | 301 redirect |
| `/en-us/services/local-seo-ai/norwich/` | `/en-gb/services/local-seo-ai/norwich/` | 301 redirect |
| `/en-us/services/chatgpt-optimization/southport/` | `/en-gb/services/local-seo-ai/southport/` | 301 redirect |
| `/en-us/services/voice-search-optimization/derby/` | `/en-gb/services/local-seo-ai/derby/` | 301 redirect |
| `/fr-fr/services/conversion-optimization-ai/stockport/` | `/en-gb/services/local-seo-ai/stockport/` | 301 redirect |
| `/en-us/services/llm-content-strategy/norwich/` | `/en-gb/services/local-seo-ai/norwich/` | 301 redirect |
| `/en-us/services/verification-optimization-ai/blackpool/` | `/en-gb/services/local-seo-ai/blackpool/` | 301 redirect |
| `/en-us/services/generative-seo/halifax/` | `/en-gb/services/local-seo-ai/halifax/` | 301 redirect |
| `/en-us/services/bard-optimization/huddersfield/` | `/en-gb/services/local-seo-ai/huddersfield/` | 301 redirect |
| `/en-us/services/ai-search-optimization/oldham/` | `/en-gb/services/local-seo-ai/oldham/` | 301 redirect |
| `/es-es/services/international-seo/blackpool/` | `/en-gb/services/local-seo-ai/blackpool/` | 301 redirect |
| `/fr-fr/services/local-seo-ai/blackpool/` | `/en-gb/services/local-seo-ai/blackpool/` | 301 redirect |
| `/de-de/services/relevance-optimization-ai/stockport/` | `/en-gb/services/local-seo-ai/stockport/` | 301 redirect |
| `/es-es/services/contextual-seo-ai/huddersfield/` | `/en-gb/services/local-seo-ai/huddersfield/` | 301 redirect |
| `/fr-fr/services/local-seo-ai/sudbury/` | `/en-gb/services/local-seo-ai/sudbury/` | 301 redirect |
| `/de-de/services/voice-search-optimization/sheffield/` | `/en-gb/services/local-seo-ai/sheffield/` | 301 redirect |

### Medium Priority (P1 — Fix Next Week):

| Current URL (Non-Canonical) | Canonical Target | Action |
|------------------------------|------------------|--------|
| `/en-us/services/international-seo/stoke-on-trent/` | `/en-gb/services/local-seo-ai/stoke-on-trent/` | 301 redirect |
| `/en-us/services/generative-seo/southport/` | `/en-gb/services/local-seo-ai/southport/` | 301 redirect |
| `/en-us/services/link-building-ai/southampton/` | `/en-gb/services/link-building-ai/southampton/` | 301 redirect |
| `/en-gb/services/international-seo/huddersfield/` | `/en-gb/services/local-seo-ai/huddersfield/` | 301 redirect (change service type) |

---

## IMPLEMENTATION RULES

### Redirect Logic (bootstrap/canonical.php):

```php
// UK City Detection
$ukCities = ['norwich', 'stockport', 'stoke-on-trent', 'derby', 'southport', 
             'huddersfield', 'blackpool', 'burnley', 'oldham', 'halifax', 
             'sudbury', 'nottingham', 'sheffield', 'southampton'];

// If URL contains UK city and locale is NOT en-gb
if (preg_match('#/([^/]+)/services/([^/]+)/([^/]+)/#', $path, $m)) {
  $locale = $m[1];
  $city = $m[3];
  
  foreach ($ukCities as $ukCity) {
    if (strpos($city, $ukCity) !== false || 
        strpos($city, str_replace('-', '', $ukCity)) !== false) {
      // UK city detected
      if ($locale !== 'en-gb') {
        // Redirect to en-gb canonical
        $canonical = '/en-gb/services/local-seo-ai/' . $city . '/';
        header("Location: " . absolute_url($canonical), true, 301);
        exit;
      }
      break;
    }
  }
}
```

### Canonical Tag Generation (templates/head.php):

```php
// Ensure canonical is self-referencing
$canonicalPath = $meta['canonicalPath'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// For service pages with cities, ensure correct locale
if (preg_match('#/services/([^/]+)/([^/]+)/#', $canonicalPath, $m)) {
  $city = $m[2];
  // Check if UK city and enforce en-gb
  // (logic similar to redirect above)
}
```

---

## HREFLANG STRATEGY

### Current State:
- Multiple locales exist (en-us, en-gb, fr-fr, es-es, de-de, ko-kr)
- Many are not genuinely translated
- UK cities appear in wrong locales

### Target State:
- **en-us:** Primary for US market
- **en-gb:** Primary for UK market
- **Other locales:** Only if genuinely translated

### Hreflang Implementation:
```html
<!-- Only for pages that have real translations -->
<link rel="alternate" hreflang="en-us" href="https://nrlc.ai/en-us/..." />
<link rel="alternate" hreflang="en-gb" href="https://nrlc.ai/en-gb/..." />
<link rel="alternate" hreflang="x-default" href="https://nrlc.ai/en-us/..." />
```

**Rule:** If a page doesn't have a real translation in a locale, don't include that locale in hreflang.

---

## VERIFICATION CHECKLIST

For each UK city page:
- [ ] Non-en-gb versions redirect (301) to en-gb canonical
- [ ] Canonical tag is self-referencing on en-gb page
- [ ] og:url equals canonical exactly
- [ ] Search Console shows queries mapping to en-gb page
- [ ] No duplicate content warnings in Search Console

For each US city page:
- [ ] Non-en-us versions redirect (301) to en-us canonical
- [ ] Canonical tag is self-referencing on en-us page
- [ ] og:url equals canonical exactly

---

## ROLLOUT PLAN

### Phase 1 (P0 — This Week):
1. Implement redirect logic in `bootstrap/canonical.php`
2. Create en-gb canonical pages for top 5 UK cities (Stoke-on-Trent, Norwich, Southport, Derby, Stockport)
3. Test redirects with curl
4. Monitor Search Console for query remapping

### Phase 2 (P1 — Next Week):
1. Create en-gb canonical pages for remaining UK cities (Huddersfield, Blackpool, Burnley, Oldham, Halifax, Sudbury, Nottingham, Sheffield, Southampton)
2. Apply redirects to all non-canonical versions
3. Update internal links to point to canonical URLs

### Phase 3 (P2 — This Month):
1. Audit all service pages for locale mismatches
2. Consolidate duplicate content
3. Update hreflang tags to reflect real translations only

---

**END OF LOCALE CANONICALIZATION PLAN**

