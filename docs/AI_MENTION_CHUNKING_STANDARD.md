# AI Mention Chunking Standard
## Site-wide standard for all Insights, KB pages, and concept explainers

**Purpose:** Optimize content for Google extraction, AI answer engines, clean internal linking, and deterministic QA.

---

## Required Blocks (Every Page)

### Head
- Unique title tag
- Unique meta description
- Canonical (self)
- OpenGraph URL (self)
- JSON-LD: Article + Organization (minimum)

### Body Structure

1. **H1:** Exact topic (one H1 only)
2. **Definition Lock:** 1-paragraph (2-4 sentences, no fluff) - must appear in first 120 words
3. **H2: Mechanism** - How it works
4. **H2: Practical Implications** - What changes operationally
5. **H2: Checklist or Playbook** - Ordered list
6. **H2: Failure Modes** - What goes wrong
7. **H2: Related** - 3 internal links minimum (before FAQ)
8. **H2: FAQ** - 4-8 questions

---

## Heading Rules

- Only one H1 per page
- H2 blocks must be atomic and self-contained (each can be read alone)
- No `style=""` attributes in headings (gets indexed as text)
- Each H2 must start with a topic sentence that defines the section in plain language
- Use descriptive H2s: "Definition:", "Mechanism:", "Failure Modes:", etc.

---

## Extraction Rules (AI-Citation Tuned)

- Put tables in real `<table>` markup (not fake tables in text)
- Use ordered lists for playbooks/checklists
- Use short paragraphs (2-4 lines max)
- Repeat key entity names exactly (same casing) at least 3 times per page
- Put the primary definition in the first 120 words
- Include at least one "decision rule" (if X then Y)
- Include numeric thresholds where appropriate (latency targets, score thresholds)
- Define terms before using them heavily

---

## Internal Linking Rules (Non-Negotiable)

- Add a "Related" mini-block before FAQ
- 3 internal links minimum per page
- Anchor text is descriptive, not "click here"
- Every Insights page must link back to `/en-us/insights/` once
- Link to related GEO-16 pages, related concepts, and hub pages

---

## Schema Stack Rules (Insights)

### Minimum Required:
- `Article`
- `Organization`
- `BreadcrumbList` (recommended)

### When Applicable:
- `FAQPage` - when you have explicit Q&A
- `DefinedTerm` - 1-5 per page, only real definitions
- `HowTo` - only if you turn "What to build first" into step-by-step instructions
- `ItemList` - if you list tools/sectors as categorized items
- `Dataset` - if you present data formally

---

## Content Tone Rules

- No marketing-only claims without framing qualifier (example: "in our testing")
- No fluff, no em-dashes, no filler
- Clean, non-marketing tone
- Sales-free authority tone
- Human readable, Google crawl friendly, AI extraction ready

---

## Table Requirements

- All tables must be real HTML `<table>` markup
- Tables should be used for comparisons, decision matrices, thresholds
- Never use fake tables (text with spaces/characters)

---

## Definition Lock Template

The first paragraph after H1 must:
- Be 2-4 sentences
- Define the core concept clearly
- Appear in first 120 words
- Be self-contained (readable without context)
- Use exact entity names (consistent casing)

Example:
```
[Concept] means [clear definition]. This does not mean [common misconception]. 
[What it actually means]. [One sentence on why it matters].
```

