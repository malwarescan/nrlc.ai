# Google Search Console Localization Analysis
**Date:** 2026-01-16  
**Data Source:** GSC Performance Report (Countries, Pages, Queries)

---

## EXECUTIVE SUMMARY

**Critical Finding:** You have significant untapped traffic from non-English speaking countries and UK regions that are not converting due to:
1. **Locale mismatches** - Pages in wrong locales (e.g., `ko-kr/services/site-audits/belfast/` - Belfast is UK, should be `en-gb`)
2. **Missing localized terminology** - UK uses "optimisation", US uses "optimization"
3. **No localized landing pages** - High-impression countries (Singapore, Brazil, France, Spain, Germany) have 0 clicks
4. **Query-language mismatch** - Users searching in their language but landing on English pages

---

## A) HIGH-OPPORTUNITY COUNTRIES (0 Clicks, High Impressions)

### Tier 1: Immediate Priority (20+ Impressions, 0 Clicks)
| Country | Impressions | Position | Issue | Action Needed |
|---------|-------------|---------|-------|---------------|
| **Singapore** | 79 | 39.44 | English-speaking but needs local terminology | Create `en-sg/` locale pages |
| **Brazil** | 39 | 9.54 | Portuguese-speaking, no Portuguese pages | Create `pt-br/` locale OR optimize English for Brazilian market |
| **Turkey** | 34 | 51.12 | Turkish-speaking, no Turkish pages | Create `tr-tr/` locale OR optimize English |
| **France** | 28 | 26.14 | French-speaking, has `fr-fr/` but wrong cities | Fix locale mismatches + create proper French city pages |
| **Vietnam** | 26 | 41.23 | Vietnamese-speaking, no Vietnamese pages | Create `vi-vn/` locale OR optimize English |
| **Spain** | 26 | 50.27 | Spanish-speaking, has `es-es/` but wrong cities | Fix locale mismatches + create proper Spanish city pages |
| **Australia** | 21 | 31.48 | English-speaking, needs AU terminology | Create `en-au/` locale pages |
| **Germany** | 20 | 28.85 | German-speaking, has `de-de/` but wrong cities | Fix locale mismatches + create proper German city pages |

### Tier 2: Secondary Priority (10-19 Impressions, 0 Clicks)
- **Italy** (16 impressions) - Italian-speaking
- **Indonesia** (11 impressions) - Indonesian-speaking
- **Thailand** (10 impressions) - Thai-speaking
- **South Korea** (8 impressions) - Korean-speaking, has `ko-kr/` but wrong cities
- **Philippines** (7 impressions) - English-speaking, needs PH terminology
- **Romania** (6 impressions) - Romanian-speaking
- **Mexico** (6 impressions) - Spanish-speaking
- **Switzerland** (6 impressions) - Multi-language (DE/FR/IT)
- **Malaysia** (6 impressions) - English-speaking, needs MY terminology

---

## B) LOCALE MISMATCHES (Critical Fixes Needed)

### Pages in Wrong Locales

**UK Cities in Non-UK Locales:**
- `ko-kr/services/site-audits/belfast/` → Should be `en-gb/services/site-audits/belfast/`
- `ko-kr/services/local-seo-ai/oldham/` → Should be `en-gb/services/local-seo-ai/oldham/`
- `de-de/services/technical-seo/nottingham/` → Should be `en-gb/services/technical-seo/nottingham/`
- `fr-fr/services/b2b-seo-ai/stockport/` → Should be `en-gb/services/b2b-seo-ai/stockport/`
- `fr-fr/services/contextual-seo-ai/southport/` → Should be `en-gb/services/contextual-seo-ai/southport/`
- `ko-kr/services/llm-content-strategy/stockport/` → Should be `en-gb/services/llm-content-strategy/stockport/`
- `es-es/services/site-audits/nottingham/` → Should be `en-gb/services/site-audits/nottingham/`
- `de-de/services/technical-seo/plymouth/` → Should be `en-gb/services/technical-seo/plymouth/`
- `fr-fr/careers/middlesbrough/technical-writer/` → Should be `en-gb/careers/middlesbrough/technical-writer/`
- `ko-kr/careers/leeds/seo-specialist/` → Should be `en-gb/careers/leeds/seo-specialist/`

**US Cities in Non-US Locales:**
- `es-es/services/mobile-seo-ai/chicago/` → Should be `en-us/services/mobile-seo-ai/chicago/`
- `de-de/services/ecommerce-ai-seo/detroit/` → Should be `en-us/services/ecommerce-ai-seo/detroit/`
- `fr-fr/services/content-optimization-ai/detroit/` → Should be `en-us/services/content-optimization-ai/detroit/`
- `de-de/services/ranking-optimization-ai/el-paso/` → Should be `en-us/services/ranking-optimization-ai/el-paso/`
- `fr-fr/services/ranking-optimization-ai/columbus/` → Should be `en-us/services/ranking-optimization-ai/columbus/`
- `fr-fr/services/conversion-optimization-ai/virginia-beach/` → Should be `en-us/services/conversion-optimization-ai/virginia-beach/`

**Canadian Cities in Non-Canadian Locales:**
- `de-de/services/claude-optimization/victoria/` → Should be `en-us/services/claude-optimization/victoria/` (or `en-ca/` if you support it)
- `es-es/careers/guelph/seo-specialist/` → Should be `en-us/services/...` or `en-ca/`

**Impact:** These pages are likely being indexed but not ranking well because:
1. Google sees locale mismatch (Korean page for UK city)
2. Users from those countries don't click (wrong language)
3. Canonical issues may be suppressing rankings

---

## C) TERMINOLOGY LOCALIZATION NEEDS

### UK vs US Spelling (Critical for UK Traffic)

**Queries showing UK terminology:**
- "search engine optimisation" (UK) vs "search engine optimization" (US)
- "optimisation" appears in queries: "ai overviews optimisation cambridge", "chatgpt ranking optimisation service"
- "specialist" vs "expert" or "consultant"

**Current Issue:** Your pages likely use US spelling ("optimization") but UK users search with UK spelling ("optimisation").

**Recommendation:** 
- Create `en-gb/` versions of high-traffic pages with UK spelling
- Use "optimisation" in titles, descriptions, and content for UK pages
- Use "specialist" terminology for UK pages

### Country-Specific Terminology

**Singapore:**
- Queries: "singapore ai seo", "ai optimization singapore", "ai search agency in singapore"
- Needs: `en-sg/` locale with Singapore-specific terminology and local context

**Australia:**
- Queries: "claude seo agency melbourne"
- Needs: `en-au/` locale with Australian terminology

**Canada:**
- Already has some traffic (2 clicks, 213 impressions)
- Consider `en-ca/` locale for Canadian cities

---

## D) QUERY ANALYSIS - LOCALIZATION OPPORTUNITIES

### High-Impression Queries with 0 Clicks (Localization Needed)

1. **"seo training cardiff"** (121 impressions, 0 clicks, position 16.37)
   - UK city, UK spelling
   - Page exists: `https://nrlc.ai/en-us/services/training/cardiff/`
   - **Issue:** Should be `en-gb/services/training/cardiff/` with UK spelling

2. **"search engine optimisation southport"** (40 impressions, 0 clicks, position 21.52)
   - UK city, UK spelling ("optimisation")
   - **Issue:** Page likely uses US spelling ("optimization")

3. **"singapore ai seo"** (23 impressions, 0 clicks, position 35.43)
   - Singapore-specific query
   - **Issue:** No Singapore-optimized page exists

4. **"ai optimization singapore"** (8 impressions, 0 clicks, position 24.88)
   - Singapore-specific query
   - **Issue:** No Singapore-optimized page exists

5. **"ai search agency in singapore"** (8 impressions, 0 clicks, position 70.5)
   - Singapore-specific query
   - **Issue:** No Singapore-optimized page exists

### UK-Specific Queries (Need en-gb Pages)

- "seo specialist hull" (49 impressions, 0 clicks)
- "seo audit belfast" (26 impressions, 0 clicks)
- "technical seo nottingham" (25 impressions, 0 clicks)
- "seo strategy stockport" (18 impressions, 0 clicks)
- "ai seo glasgow" (17 impressions, 0 clicks)
- "technical seo services newcastle" (17 impressions, 0 clicks)
- "link building strategies in southampton" (11 impressions, 0 clicks)
- "seo conference in huddersfield" (10 impressions, 0 clicks)
- "seo conference in middlesbrough" (9 impressions, 0 clicks)
- "seo conference in peterborough" (8 impressions, 0 clicks)
- "seo conference in northampton" (8 impressions, 0 clicks)

**All of these need `en-gb/` pages with UK spelling.**

---

## E) RECOMMENDATIONS

### Priority 1: Fix Locale Mismatches (Immediate)

1. **Redirect wrong-locale pages to correct locales:**
   - All UK cities in `ko-kr/`, `fr-fr/`, `es-es/`, `de-de/` → Redirect to `en-gb/`
   - All US cities in non-`en-us/` locales → Redirect to `en-us/`
   - All Canadian cities → Determine canonical locale (probably `en-us/` or create `en-ca/`)

2. **Update router logic:**
   - Ensure `get_canonical_locale_for_city()` correctly maps cities to locales
   - Add redirect logic for locale mismatches

### Priority 2: Create UK Locale Pages (High Impact)

1. **Create `en-gb/` versions of high-traffic UK city pages:**
   - Cardiff, Hull, Belfast, Nottingham, Stockport, Glasgow, Newcastle, Southampton, Huddersfield, Middlesbrough, Peterborough, Northampton

2. **Use UK spelling:**
   - "optimisation" not "optimization"
   - "specialist" terminology
   - UK-specific CTAs and terminology

3. **Update content tokens:**
   - Add UK spelling variants in `lib/content_tokens.php`
   - Create locale-aware content generation

### Priority 3: Create Locale-Specific Pages for High-Opportunity Countries

1. **Singapore (`en-sg/`):**
   - 79 impressions, 0 clicks
   - Create Singapore-specific pages
   - Use Singapore terminology and local context

2. **Australia (`en-au/`):**
   - 21 impressions, 0 clicks
   - Create Australia-specific pages
   - Use Australian terminology

3. **Consider other high-impression countries:**
   - Brazil (39 impressions) - Portuguese or English optimized for Brazil?
   - France (28 impressions) - Fix existing `fr-fr/` pages + create proper French city pages
   - Spain (26 impressions) - Fix existing `es-es/` pages + create proper Spanish city pages
   - Germany (20 impressions) - Fix existing `de-de/` pages + create proper German city pages

### Priority 4: Terminology Localization System

1. **Create locale-aware terminology mapping:**
   ```php
   // lib/locale_terminology.php
   $terminology = [
     'en-us' => ['optimization', 'specialist', 'consultant'],
     'en-gb' => ['optimisation', 'specialist', 'consultant'],
     'en-sg' => ['optimisation', 'specialist', 'consultant'],
     'en-au' => ['optimisation', 'specialist', 'consultant'],
   ];
   ```

2. **Update meta descriptions and titles:**
   - Use locale-appropriate spelling in titles
   - Use locale-appropriate terminology in descriptions

3. **Update content generation:**
   - Make `service_intent_content()` locale-aware
   - Use locale-specific terminology in CTAs

---

## F) EXPECTED IMPACT

### If You Fix Locale Mismatches:
- **UK traffic:** Could convert 561 impressions (currently 3 clicks, 0.53% CTR) → Potential 5-10% CTR = 28-56 clicks
- **US traffic:** Could convert 1513 impressions (currently 2 clicks, 0.13% CTR) → Potential 2-5% CTR = 30-75 clicks

### If You Create UK Locale Pages:
- **UK-specific queries:** 200+ impressions currently with 0 clicks → Potential 10-20 clicks with proper UK pages

### If You Create Singapore Pages:
- **Singapore traffic:** 79 impressions, 0 clicks → Potential 5-10 clicks with Singapore-optimized pages

### If You Create Other Locale Pages:
- **Combined opportunity:** 200+ impressions from France, Spain, Germany, Australia, Brazil → Potential 10-20 clicks

**Total Potential:** 70-160 additional clicks per month from proper localization

---

## G) IMPLEMENTATION CHECKLIST

### Immediate Fixes (This Week)
- [ ] Fix locale mismatches (redirect wrong-locale pages)
- [ ] Update router to enforce canonical locales
- [ ] Create `en-gb/` versions of top 10 UK city pages
- [ ] Add UK spelling to content generation

### Short-Term (This Month)
- [ ] Create `en-sg/` locale and Singapore pages
- [ ] Create `en-au/` locale and Australia pages
- [ ] Fix existing `fr-fr/`, `es-es/`, `de-de/` pages (remove wrong cities)
- [ ] Create proper French, Spanish, German city pages for their countries

### Long-Term (Next Quarter)
- [ ] Evaluate need for Portuguese (Brazil), Turkish, Vietnamese pages
- [ ] Create comprehensive locale terminology system
- [ ] Implement locale-aware content generation
- [ ] Monitor GSC for improvements in localized traffic

---

## H) TECHNICAL IMPLEMENTATION NOTES

### Current Locale System
- Locales defined in `config/locales.php`
- Router handles locale detection and canonicalization
- `get_canonical_locale_for_city()` should map cities to correct locales

### What Needs to Change
1. **Router:** Add redirect logic for locale mismatches
2. **Content Tokens:** Add locale-aware terminology
3. **Meta Directive:** Use locale-appropriate spelling in titles/descriptions
4. **Service Intent Content:** Make terminology locale-aware

### Files to Modify
- `bootstrap/router.php` - Add locale mismatch redirects
- `lib/content_tokens.php` - Add locale terminology
- `lib/service_intent_taxonomy.php` - Make terminology locale-aware
- `lib/meta_directive.php` - Use locale spelling in meta tags
- `config/locales.php` - Add new locales (en-sg, en-au, etc.)

---

## CONCLUSION

You have significant untapped traffic from:
1. **UK users** searching with UK spelling but landing on US-spelled pages
2. **Non-English countries** (Singapore, Brazil, France, Spain, Germany) with no localized pages
3. **Wrong-locale pages** that are confusing Google and users

**Priority:** Fix locale mismatches first (quick win), then create UK locale pages (high impact), then expand to other high-opportunity countries.
