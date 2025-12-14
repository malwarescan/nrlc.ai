# HREFLANG ALLOWLIST EXPANSION PLAN (BY QUARTER)

**Safe, controlled rollout of hreflang for GLOBAL pages only.**

---

## Q1 2025 — PILOT & VALIDATION

### Current Status
- ✅ `/services/technical-seo/` (en-us, en-gb) — **PILOT**

### Q1 Goals
1. Monitor pilot page for 2-4 weeks
2. Validate canonical stability in GSC
3. Confirm no indexing issues
4. Verify CTR/impressions behavior

### Q1 Deliverables
- [ ] GSC report: Canonical stability for `/services/technical-seo/`
- [ ] SERP check: No duplicate indexing
- [ ] CTR analysis: Compare en-us vs en-gb performance

### Q1 Success Criteria
- ✅ Google selects correct canonical
- ✅ No duplicate indexing
- ✅ Stable impressions/clicks
- ✅ Architecture validated

---

## Q2 2025 — EXPAND PILOT TO ONE NON-ENGLISH LOCALE

### Q2 Goals
1. Add one non-English locale to pilot page
2. Validate translation quality
3. Test hreflang with 3 locales

### Q2 Options

#### Option A: German (Recommended)
- Add `de-de` to `/services/technical-seo/`
- **Why:** Strong enterprise market, technical maturity

#### Option B: Spanish (Spain)
- Add `es-es` to `/services/technical-seo/`
- **Why:** Large EU market, easier translation

### Q2 Allowlist Update
```php
'/services/technical-seo/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
```

### Q2 Deliverables
- [ ] Professional translation of `/services/technical-seo/` to chosen locale
- [ ] Translation QA checklist passed
- [ ] Hreflang allowlist updated
- [ ] GSC validation (2-4 weeks)

### Q2 Success Criteria
- ✅ Translation quality verified
- ✅ All 3 locales indexed correctly
- ✅ Canonical stability maintained
- ✅ Ready for Tier 1 expansion

---

## Q3 2025 — TIER 1 REVENUE DRIVERS

### Q3 Goals
1. Expand hreflang to 3-4 additional Tier 1 service pages
2. Use proven locale set (en-us, en-gb, chosen Phase 2 locale)
3. Maintain quality over quantity

### Q3 Target Pages
1. `/services/schema-markup/`
2. `/services/ai-search-optimization/`
3. `/services/crawlability-indexing/`
4. `/services/enterprise-seo/`

### Q3 Allowlist Update
```php
'/services/technical-seo/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
'/services/schema-markup/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
'/services/ai-search-optimization/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
'/services/crawlability-indexing/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
'/services/enterprise-seo/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
```

### Q3 Deliverables
- [ ] 4 service pages translated to all 3 locales
- [ ] Translation QA checklist passed for all pages
- [ ] Hreflang allowlist updated
- [ ] GSC validation for all pages

### Q3 Success Criteria
- ✅ All Tier 1 pages have hreflang
- ✅ Translation quality consistent
- ✅ No indexing issues
- ✅ Revenue impact measurable

---

## Q4 2025 — TIER 2 TRUST & AUTHORITY

### Q4 Goals
1. Expand to homepage and key trust pages
2. Consider adding Phase 3 locale (fr-fr, nl-nl, or sv-se) if Phase 2 successful

### Q4 Target Pages
1. `/en-us/` (Homepage)
2. `/about/`
3. `/contact/`
4. `/case-studies/` (hub page)

### Q4 Locale Strategy
- **If Phase 2 (de-de or es-es) successful:** Add Phase 3 locale
- **If Phase 2 needs work:** Stay with 3 locales, focus on quality

### Q4 Allowlist Update
```php
// ... existing Tier 1 pages ...

'/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
  // 'fr-fr', // Only if Phase 2 successful
],
'/about/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
'/contact/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
'/case-studies/' => [
  'en-us',
  'en-gb',
  'de-de', // or 'es-es'
],
```

### Q4 Deliverables
- [ ] Homepage and trust pages translated
- [ ] Phase 3 locale added (if Phase 2 successful)
- [ ] Hreflang allowlist updated
- [ ] Year-end GSC report

### Q4 Success Criteria
- ✅ Tier 1 + Tier 2 pages have hreflang
- ✅ Phase 2 locale performing well
- ✅ Phase 3 locale added (if applicable)
- ✅ Foundation for 2026 expansion

---

## 2026 — TIER 3 THOUGHT LEADERSHIP

### 2026 Goals
1. Expand to high-performing insights articles
2. Add remaining Phase 3 locales
3. Consider regional variants (e.g., es-mx for LATAM)

### 2026 Strategy
- Only translate insights that:
  - Have proven SEO value
  - Have clear global appeal
  - Support service page conversions

---

## EXPANSION RULES (NON-NEGOTIABLE)

1. **One page family at a time**
   - Never expand horizontally (multiple pages at once)
   - Complete one page before starting the next

2. **Translation quality first**
   - Every translation must pass QA checklist
   - No auto-translation for SEO pages
   - Professional translators only

3. **GSC validation required**
   - 2-4 weeks monitoring per page
   - Canonical stability confirmed
   - No indexing issues

4. **LOCAL pages never get hreflang**
   - This is permanent
   - No exceptions

5. **Allowlist is the gate**
   - Only pages in allowlist get hreflang
   - CI guardrail enforces this

---

## QUARTERLY REVIEW CHECKLIST

Before expanding to next quarter:

- [ ] Previous quarter pages stable in GSC
- [ ] No canonical issues
- [ ] Translation quality verified
- [ ] Revenue/SEO impact measurable
- [ ] Ready for next tier

---

**Current Status:** Q1 2025 — Pilot phase
**Next Milestone:** Q2 2025 — Add non-English locale to pilot

