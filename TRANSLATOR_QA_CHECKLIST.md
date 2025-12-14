# TRANSLATOR QA CHECKLIST (CI-ENFORCED)

**Mandatory checklist for all GLOBAL page translations before hreflang enablement.**

This checklist ensures translation quality and prevents hreflang failures.

---

## PRE-TRANSLATION REQUIREMENTS

### 1. Source Page Quality
- [ ] Source page follows Global Copy Rules
- [ ] No country-specific references
- [ ] No idioms or slang
- [ ] Clear structure: Problem → Diagnosis → Method → Proof → CTA
- [ ] Intent-stable headings

### 2. Translation Brief Provided
- [ ] Translator received mandatory brief
- [ ] Brief emphasizes: Do NOT rewrite meaning
- [ ] Brief emphasizes: Do NOT localize geography
- [ ] Brief specifies: Preserve H1 intent, CTA intent, technical terminology

---

## TRANSLATION QUALITY CHECKS

### 3. H1 Intent Preservation
- [ ] H1 translates 1:1 without losing meaning
- [ ] H1 maintains same keyword focus
- [ ] H1 length appropriate (50-60 chars)
- [ ] H1 matches source page intent

**Example:**
- ✅ Source: "Technical SEO for AI Search | NRLC.ai"
- ✅ Translation: "Technisches SEO für KI-Suche | NRLC.ai" (preserves intent)
- ❌ Bad: "SEO-Optimierung für Suchmaschinen" (loses "AI Search" focus)

### 4. Meta Title & Description
- [ ] Title length: 50-60 chars (hard max 65)
- [ ] Description length: 150-165 chars (hard max 175)
- [ ] Title intent matches H1 intent
- [ ] Description promise matches visible copy
- [ ] No generic filler text

### 5. CTA Intent Preservation
- [ ] CTA maintains same action intent
- [ ] CTA uses neutral, global language
- [ ] No city-specific references
- [ ] CTA matches source page CTA intent

**Example:**
- ✅ Source: "Talk to an SEO engineer"
- ✅ Translation: "Sprechen Sie mit einem SEO-Ingenieur" (preserves intent)
- ❌ Bad: "Kontaktieren Sie uns in Berlin" (adds geography)

### 6. Technical Terminology
- [ ] Technical terms translated consistently
- [ ] Industry-standard terms used (not invented)
- [ ] Schema.org terms preserved (if applicable)
- [ ] SEO terminology accurate

**Example:**
- ✅ "Structured data" → "Strukturierte Daten" (standard term)
- ❌ "Structured data" → "Formatierte Informationen" (loses technical meaning)

### 7. Content Structure
- [ ] Problem section translates clearly
- [ ] Diagnosis section maintains technical accuracy
- [ ] Method section preserves step-by-step logic
- [ ] Proof section maintains credibility
- [ ] CTA section matches source intent

### 8. Regional Adaptation (When Appropriate)
- [ ] Spelling adjusted (e.g., en-gb vs en-us)
- [ ] Tone matches professional norms
- [ ] Currency/format adjusted (if mentioned)
- [ ] Legal references removed (unless global)

**Note:** Regional adaptation should NOT change meaning or intent.

---

## POST-TRANSLATION VALIDATION

### 9. Canonical & Meta Tags
- [ ] Canonical tag is self-referencing
- [ ] Canonical == og:url exactly
- [ ] Canonical is HTTPS
- [ ] Meta title unique (not duplicate of other pages)
- [ ] Meta description unique (not duplicate of other pages)

### 10. Hreflang Readiness
- [ ] Page exists in >= 2 locales
- [ ] All locale versions are indexable
- [ ] All locale versions are self-canonical
- [ ] No redirect chains on any locale URL
- [ ] Page is in hreflang allowlist (after QA passes)

### 11. SEO Technical Checks
- [ ] H1 present and matches title intent
- [ ] Above-fold copy matches description promise
- [ ] Internal links point to canonical URLs
- [ ] No broken links
- [ ] Schema markup valid (if applicable)

---

## CI GUARDRAIL CHECKS (AUTOMATED)

### 12. Automated Validation
- [ ] CI guardrail passes (no errors)
- [ ] No duplicate titles/descriptions
- [ ] Title/description length within bounds
- [ ] Canonical == og:url (code path verified)
- [ ] Page not flagged as LOCAL page in allowlist

---

## TRANSLATION REJECTION CRITERIA

**Reject translation if ANY of the following:**
- ❌ H1 intent changed
- ❌ CTA intent changed
- ❌ Technical terminology incorrect
- ❌ Country-specific references added
- ❌ Meaning rewritten (not translated)
- ❌ Geography localized without approval
- ❌ Meta tags duplicate existing pages
- ❌ Content structure broken

---

## APPROVAL WORKFLOW

1. **Translator submits translation**
2. **QA reviewer checks all 12 items**
3. **If all pass:** Add to hreflang allowlist
4. **If any fail:** Return to translator with specific feedback
5. **Re-submit and re-check**

---

## TRANSLATOR FEEDBACK TEMPLATE

```
Translation QA Results for: [PAGE PATH]

✅ PASSED:
- H1 intent preserved
- CTA intent preserved
- Technical terminology accurate

❌ NEEDS REVISION:
- [Specific issue 1]
- [Specific issue 2]

Please revise and resubmit.
```

---

## QUARTERLY TRANSLATION AUDIT

Every quarter, audit all translated pages:
- [ ] Re-check H1 intent alignment
- [ ] Verify CTA performance
- [ ] Confirm technical accuracy
- [ ] Check for drift from source intent

---

**This checklist is mandatory for all GLOBAL page translations.**
**No exceptions. No shortcuts.**

