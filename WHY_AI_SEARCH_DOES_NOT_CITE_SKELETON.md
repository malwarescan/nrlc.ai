# Sentence-by-Sentence Skeleton: `/why-ai-search-does-not-cite-your-business/`

**Page Flow:** Problem articulation → False assumption break → Mechanism introduction → Category naming moment → Neutral handoff to /ai-optimization/

**Tone Lock:** Practical, direct, technical but accessible. No sales language, no premature solutions, no over-explaining.

**Internal Routing (Strict):**
```
/why-ai-search-does-not-cite-your-business/
        ↓
/insights/ai-retrieval-llm-citation.php
        ↓
/ai-optimization/
```

---

## Section 1: Hero (Intro - Problem Articulation)
**Placement:** Top of page, immediately after H1  
**Purpose:** Establish the broken expectation  
**Word Count Limit:** 100-120 words  
**Category Mention:** NO

**Scaffold:**

1. [PROBLEM ARTICULATION] Your site ranks well in search results. Your content is comprehensive and accurate. Yet when users ask AI systems questions about your industry, your business is not cited or recommended.

2. [PROBLEM ARTICULATION] You see competitors with similar content appearing in AI-generated answers. You see your own content indexed and ranking, but AI systems consistently fail to surface or cite your pages.

3. [PROBLEM ARTICULATION] This is the citation gap: the disconnect between traditional search visibility and AI-driven answer generation.

**What MUST NOT be added:**
- Solutions or fixes
- Service mentions
- "AI Optimization" term (not yet)
- Tools or techniques
- CTAs or conversion language

---

## Section 2: The Incorrect Assumption
**Placement:** After hero, before mechanism  
**Purpose:** Break the false assumption that ranking equals retrieval equals selection  
**Word Count Limit:** 120-150 words  
**Category Mention:** NO

**Scaffold:**

1. [FALSE ASSUMPTION BREAK] The assumption is that ranking equals retrieval equals selection. If your page ranks for a query, it should be retrieved. If it is retrieved, it should be selected for citation.

2. [FALSE ASSUMPTION BREAK] This assumption fails because AI systems operate differently than search engines. Search engines rank pages. AI systems extract segments.

3. [FALSE ASSUMPTION BREAK] A page can rank highly while containing segments that are ambiguous, context-dependent, or unverifiable. These segments will not be selected for citation even if the page itself ranks well.

4. [FALSE ASSUMPTION BREAK] Ranking measures page-level relevance. Retrieval measures segment-level extractability. Selection measures segment-level citation readiness. These are three separate evaluations.

**What MUST NOT be added:**
- Solutions or fixes
- "AI Optimization" term (not yet)
- How-to instructions
- Service mentions

---

## Section 3: The Actual Mechanism (High Level)
**Placement:** Middle section, after assumption break  
**Purpose:** Explain how AI systems choose sources at a high level  
**Word Count Limit:** 150-180 words  
**Category Mention:** NO  
**Link:** Link to `/insights/ai-retrieval-llm-citation.php` at the end

**Scaffold:**

1. [MECHANISM INTRODUCTION] AI systems choose sources through a multi-stage process that evaluates content at the segment level, not the page level.

2. [MECHANISM INTRODUCTION] When a user asks a question, the system first identifies candidate pages that might contain relevant information. This is similar to traditional search ranking.

3. [MECHANISM INTRODUCTION] But then the system extracts individual segments from those pages. Each segment is evaluated for relevance, completeness, atomic clarity, and citation readiness.

4. [MECHANISM INTRODUCTION] Segments that are ambiguous, context-dependent, or unverifiable are filtered out. Only segments that can stand alone and be cited verbatim are selected.

5. [MECHANISM INTRODUCTION] This is why high-ranking pages can be ignored: their segments fail segment-level evaluation even though the page itself ranks well.

6. [MECHANISM LINK] The full retrieval and citation process is explained in detail in our guide to <a href="<?= absolute_url('/en-us/insights/ai-retrieval-llm-citation/') ?>">how AI systems retrieve and cite content</a>.

**What MUST NOT be added:**
- Solutions or fixes
- "AI Optimization" term (not yet)
- Service mentions
- Detailed technical implementation

---

## Section 4: The Naming Moment (Final Third)
**Placement:** Final third of page, after mechanism  
**Purpose:** Introduce "AI Optimization" as the discipline that addresses this  
**Word Count Limit:** 100-120 words  
**Category Mention:** YES (first introduction)

**Scaffold:**

1. [CATEGORY NAMING MOMENT] This gap between ranking and citation is not a bug. It is a structural mismatch between how content is organized and how AI systems extract information.

2. [CATEGORY NAMING MOMENT] The discipline that addresses this mismatch is called <a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization</a>.

3. [CATEGORY NAMING MOMENT] AI Optimization is the practice of structuring content, systems, and data so they are retrievable, interpretable, and selectable by AI-driven search and answer engines.

4. [CATEGORY NAMING MOMENT] It differs from traditional SEO because it optimizes for segment-level extraction and citation, not just page-level ranking.

5. [CATEGORY NAMING MOMENT] It differs from ML optimization because it focuses on content structure and retrieval readiness, not model training or algorithm tuning.

**What MUST NOT be added:**
- Service offers
- Pricing
- Tools or products
- CTAs beyond neutral link to category page

---

## Section 5: Neutral Handoff (Final Third)
**Placement:** End of page, after naming moment  
**Purpose:** Link to /ai-optimization/ without selling  
**Word Count Limit:** 40-60 words  
**Category Mention:** YES (link only)

**Scaffold:**

1. [NEUTRAL HANDOFF] To understand how AI Optimization addresses citation failures, see the <a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization category definition</a>.

2. [NEUTRAL HANDOFF] This page explains the problem. The category page explains the discipline.

**What MUST NOT be added:**
- Service offers
- Pricing
- Forms or CTAs
- "Get started" language
- Any conversion language

---

## Schema Requirements

**WebPage Schema:**
- `@type: WebPage`
- `name: "Why AI Search Does Not Cite Your Business"`
- `description: "Understanding why AI search systems fail to cite businesses despite high rankings and quality content."`
- `about: { @type: "Thing", name: "AI Search Citation Failure" }`

**BreadcrumbList:**
- Home → Why AI Search Does Not Cite Your Business

**NO Service schema**
**NO FAQPage schema**
**NO Product schema**

---

## Internal Link Structure

**Outbound Links (in order of appearance):**
1. `/en-us/insights/ai-retrieval-llm-citation/` (in Section 3, mechanism explanation)
2. `/ai-optimization/` (in Section 4, category naming - first mention)
3. `/ai-optimization/` (in Section 5, neutral handoff - second mention)

**Inbound Links (from Phase 2A):**
- Already established from problem pages and mechanism pages

---

## Content Boundaries

**DO:**
- Describe the problem plainly
- Explain the mechanism at a high level
- Introduce AI Optimization as a discipline
- Link neutrally to category page

**DO NOT:**
- Offer solutions or fixes
- Mention services or pricing
- Use sales language
- Over-explain technical details
- Add CTAs or forms
- Introduce tools or techniques

---

## Word Count Targets

- **Total Page:** 500-650 words
- **Section 1 (Hero):** 100-120 words
- **Section 2 (Assumption):** 120-150 words
- **Section 3 (Mechanism):** 150-180 words
- **Section 4 (Naming):** 100-120 words
- **Section 5 (Handoff):** 40-60 words

---

## Implementation Notes

1. **H1:** "Why AI Search Does Not Cite Your Business" (exact match to URL intent)
2. **Meta Description:** "Understanding why AI search systems fail to cite businesses despite high rankings and quality content."
3. **Canonical URL:** `/en-us/why-ai-search-does-not-cite-your-business/`
4. **No locale redirect:** This is a global problem page, should work at root level too
5. **Tone consistency:** Match the tone of existing problem pages (e.g., `not-cited-in-ai-overviews.php`)

---

## Verification Checklist

Before publishing, verify:
- [ ] No service mentions
- [ ] No pricing or CTAs
- [ ] "AI Optimization" appears only in final third
- [ ] Links to `/insights/ai-retrieval-llm-citation.php` in mechanism section
- [ ] Links to `/ai-optimization/` in naming moment and handoff
- [ ] Total word count: 500-650 words
- [ ] Schema includes WebPage and BreadcrumbList only
- [ ] No FAQPage, Service, or Product schema
- [ ] Tone matches existing problem pages
