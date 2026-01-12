# Industries Meta Directive Enforcement Guide

This document contains the exact templates, audit checklists, and schema patterns for enforcing the Industries Meta Directive Kernel across all industry pages.

---

## 1. Exact Architectural Paragraph for /industries/

**Location:** Above the industry list, below the H1.

**Copy exactly (do not expand, do not soften):**

> Industries are separated here because AI search systems do not behave uniformly across domains. Each industry introduces different entity relationships, schema priorities, regulatory constraints, indexing behavior, and retrieval risk. Neural Command treats industries as distinct system configurations, not marketing verticals. Each industry page represents a tailored Model Context Protocol (MCP) that governs how agents operate, how schema is enforced, and how information is made extractable and stable across Google Search, ChatGPT, Perplexity, and AI Overviews.

---

## 2. Line-by-Line Audit Template (Apply to One Industry Page)

Use this audit verbatim on any industry child page (example: /industries/healthcare/, /industries/legal/, etc.).

### H1 Audit

❌ **Forbidden:**
- "AI SEO for Healthcare"
- "Healthcare SEO Services"

✅ **Required Pattern:**
- "AI Search System Configuration for Healthcare Environments"

**Rule:** If the H1 could exist on a generic agency site, it is wrong.

### Intro Paragraph Audit

The first paragraph must answer only:
- Why AI search behaves differently in this industry
- What breaks if generic SEO is applied
- What constraints are required

❌ **Disallowed:**
- Growth language
- Lead generation claims
- "We help healthcare companies…"

✅ **Required:**
- Entity ambiguity
- Compliance pressure
- Retrieval risk
- Schema strictness
- Agent constraint necessity

### MCP Presence Check

Within the first 20% of the page, the following must be explicitly stated:
- MCP governs this industry
- Agents are constrained differently here
- This is not a reusable SEO playbook

**If MCP is implied but not stated, the page fails.**

### Schema Section Audit

Any mention of schema must:
- Describe enforcement, not markup
- Reference disambiguation, authority, or eligibility
- Avoid "we generate schema" language

### Services References Audit

Services may appear only after system explanation.

**Rules:**
- Services must be contextual ("applied within this configuration")
- Services must never headline the page
- Services must never appear in the H1 or H2

### CTA Audit

✅ **Allowed:**
- "Discuss system configuration"
- "Evaluate industry constraints"

❌ **Forbidden:**
- "Get started"
- "Book a call"
- "Increase traffic"

---

## 3. Internal Anchor Text Rules — Checklist

Use this checklist for every internal link touching /industries/.

### From /industries/ Hub

✅ **Allowed:**
- Link only to industry children

❌ **Forbidden:**
- No links to services
- No conversion anchors

**Anchor text must:**
- Be industry-specific
- Avoid verbs ("optimize", "grow", "rank")
- Avoid outcomes

### From Industry Pages → OS

**Allowed anchor patterns:**
- "system architecture"
- "core operating system"
- "governing MCP"

Use once per page.

Reference Neural Command OS only in explanatory context, never promotional.

### From Industry Pages → Services

**Allowed only if:**
- Placed after system explanation
- Framed as execution inside constraints

**Anchor text must:**
- Include contextual qualifiers
- Example: "technical SEO within regulated environments"

Never link services as standalone solutions.

### Forbidden Anchor Patterns (Everywhere)

❌ **These cause intent collapse:**
- "AI SEO for [industry]"
- "SEO services"
- "industry SEO experts"
- "optimize your [industry] site"

---

## 4. Industry Schema Template (Unified Across All Children)

Use this exact schema pattern for every industry page.
Do not mix with Product or Offer schema.

```json
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "AI Search System Configuration — {{Industry Name}}",
  "description": "Industry-specific AI search system configuration defining entity constraints, schema governance, agent safety rules, and retrieval behavior for {{Industry Name}} environments.",
  "isPartOf": {
    "@type": "CollectionPage",
    "name": "Industries",
    "url": "https://nrlc.ai/en-us/industries/"
  },
  "about": {
    "@type": "Thing",
    "name": "{{Industry Name}} AI Search Environment",
    "description": "A constrained AI search environment requiring specialized Model Context Protocols, agent governance, and schema enforcement."
  },
  "mentions": {
    "@type": "SoftwareApplication",
    "name": "Neural Command OS",
    "applicationCategory": "AI Search Infrastructure",
    "url": "https://nrlc.ai/en-us/products/neural-command-os/"
  }
}
```

### Schema Rules

- ❌ No Service at top level
- ❌ No Offer
- ❌ No pricing
- ✅ OS is referenced as governing system, not product being sold
- ✅ Industry is treated as an environment, not a market

---

## Final Enforcement Note

**If:**
- An industry page can rank without the OS
- A service can rank without the industry
- Or training can rank without the system

**Then the structure is wrong.**

This setup ensures:
- ✅ Clean intent separation
- ✅ Strong crawler comprehension
- ✅ AI summaries that reflect system architecture, not agency marketing
- ✅ Zero cannibalization between OS, industries, services, and training
