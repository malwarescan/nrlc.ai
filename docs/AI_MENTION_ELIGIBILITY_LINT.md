# AI Mention Eligibility Linting Checklist
## Pass/Fail CI Gate - If it fails, it does not ship

Use this checklist before deploying any Insights, KB, or concept page.

---

## A) Entity + Consistency

- [ ] H1 exactly matches the topic and URL intent
- [ ] Primary entity names are consistent site-wide (same spelling, same casing)
- [ ] First paragraph contains the core definition (Definition Lock)
- [ ] No contradictory descriptions across the page
- [ ] Key entity names repeated exactly (same casing) at least 3 times per page

---

## B) Structure + Chunking

- [ ] Definition lock present (2-4 sentences, in first 120 words)
- [ ] Mechanism section present (H2: "Mechanism:" or "How it works")
- [ ] Playbook/checklist section present (H2 with ordered list)
- [ ] Failure modes section present (H2: "Failure Modes:" or "What goes wrong")
- [ ] FAQ section present (minimum 4 questions)
- [ ] Related section present (3 internal links minimum)
- [ ] Tables are real HTML tables (if any tables exist)
- [ ] Only one H1 per page
- [ ] H2 blocks are atomic and self-contained

---

## C) AI-Citation Readiness

- [ ] At least one "decision rule" exists (if X then Y)
- [ ] At least one numeric threshold exists where appropriate (latency targets, score thresholds)
- [ ] Terms are defined before being used heavily
- [ ] No marketing-only claims without a framing qualifier (example: "in our testing")
- [ ] Short paragraphs (2-4 lines max)
- [ ] Ordered lists used for playbooks/checklists

---

## D) Technical SEO

- [ ] Title tag unique
- [ ] Meta description unique
- [ ] Canonical is self and matches final URL
- [ ] OG:url matches canonical
- [ ] No inline CSS strings inside headings (`style=""` attributes)
- [ ] JSON-LD validates (no trailing commas, correct @context, stable @id)
- [ ] All headings use semantic HTML (no style attributes)

---

## E) Schema Presence (Insights Baseline)

- [ ] Article schema present
- [ ] Organization schema present
- [ ] FAQPage present when FAQ exists
- [ ] BreadcrumbList present (recommended)
- [ ] DefinedTerm present when core terms are defined (1-5 per page)

---

## F) Internal Linking

- [ ] "Related" section with 3 internal links minimum
- [ ] Link back to `/en-us/insights/` present
- [ ] Anchor text is descriptive, not "click here"
- [ ] Links connect to related concepts/hub pages

---

## Automatic Fail Conditions

**Page fails if:**
- Missing Definition Lock in first 120 words
- Missing required H2 sections (Mechanism, Playbook, Failure Modes, FAQ)
- Fake tables (text-based) instead of real HTML tables
- Inline style attributes in headings
- Missing Article schema
- Missing Organization schema
- Contradictory entity names on same page
- No internal links in Related section

---

## Validation Commands

```bash
# Check for inline styles in headings
grep -r 'style=' pages/insights/*.php | grep -i 'h[1-6]'

# Check for fake tables (look for text-based table patterns)
grep -r '|.*|' pages/insights/*.php

# Validate JSON-LD (requires jq)
# Check each page's JSON-LD output
```

---

## Pre-Deploy Checklist

Before pushing any Insights page:
1. Run entity consistency check
2. Verify all required H2 sections exist
3. Validate JSON-LD schema
4. Check for inline styles in headings
5. Verify internal links work
6. Confirm Definition Lock is in first 120 words
7. Test page loads without errors

