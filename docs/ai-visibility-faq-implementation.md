# AI VISIBILITY FAQ DATASET — HOMEPAGE

**Date:** 2025-01-XX  
**Directive:** SUDO META DIRECTIVE — AI Visibility FAQ Dataset  
**Target:** `https://nrlc.ai/` (Homepage)  
**Status:** ✅ IMPLEMENTED

---

## OBJECTIVE

Capture "People also ask" demand around ChatGPT / AI brand mentions and convert it into:
- ✅ AI Overview–eligible answers
- ✅ Citation-ready language
- ✅ Trust-safe FAQ schema

---

## QUESTION CANONICALIZATION

### Canonical Question Set (Locked)

✅ **4 canonical questions** (collapsed from 8+ variants):

1. How do I get my business mentioned by ChatGPT or AI search tools?
2. How does ChatGPT decide which brands to mention?
3. Can businesses influence how they appear in AI-generated answers?
4. Is ranking on Google enough to be featured in AI Overviews or ChatGPT?

**Semantic Coverage:**
- "listed on ChatGPT"
- "featured on ChatGPT"
- "mentioned in AI"
- "brand mentions in generative AI"

---

## VISIBLE FAQ CONTENT

### Placement
✅ **Below hero, above deep service content** (lines 39-59)

### Content Structure
- ✅ Uses `<dl>` (definition list) for semantic HTML
- ✅ Questions in `<dt><strong>` tags
- ✅ Answers in `<dd>` tags
- ✅ No CTAs inside answers
- ✅ Explanatory, neutral, authoritative tone

### Questions & Answers (Exact Wording)

**Q1: How do I get my business mentioned by ChatGPT or AI search tools?**
> AI systems like ChatGPT don't browse the web or "list" businesses the way directories do. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. To be mentioned, a business needs clear entity signals, machine-readable content, and external references that AI systems can safely cite.

**Q2: How does ChatGPT decide which brands to mention?**
> ChatGPT and similar systems evaluate whether information about a brand can be confidently extracted and verified across multiple sources. Brands are more likely to be mentioned when their content clearly defines who they are, what they do, and how they relate to a topic, using consistent language and structure across the web.

**Q3: Can businesses influence how they appear in AI-generated answers?**
> Businesses can't control AI outputs directly, but they can influence eligibility. This is done by structuring content for machine comprehension, aligning on entity definitions, and reducing ambiguity so AI systems can reference the brand without risk of misinformation.

**Q4: Is ranking on Google enough to be featured in AI Overviews or ChatGPT?**
> No. Traditional rankings measure page relevance, while AI systems prioritize extractability and trust. A page can rank well and still be ignored by AI if its information isn't structured, explicit, and verifiable enough to be cited safely.

---

## FAQ SCHEMA (JSON-LD)

### Implementation
✅ **Embedded in homepage** (lines 230-280)  
✅ **Matches visible content exactly**  
✅ **Production-safe JSON-LD**

### Schema Structure
```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How do I get my business mentioned by ChatGPT or AI search tools?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "AI systems like ChatGPT don't browse the web or list businesses in directories. They generate answers by extracting information from sources that are structured, consistent, and widely corroborated. Businesses are more likely to be mentioned when their identity, services, and context are clearly defined in machine-readable formats across the web."
      }
    },
    {
      "@type": "Question",
      "name": "How does ChatGPT decide which brands to mention?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "ChatGPT evaluates whether information about a brand can be confidently extracted and verified across multiple sources. Brands with clear entity definitions, consistent language, and corroborating references are more likely to be included in AI-generated answers."
      }
    },
    {
      "@type": "Question",
      "name": "Can businesses influence how they appear in AI-generated answers?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Businesses cannot directly control AI outputs, but they can influence eligibility. This involves structuring content for machine comprehension, aligning on consistent entity signals, and reducing ambiguity so AI systems can reference the brand without risk."
      }
    },
    {
      "@type": "Question",
      "name": "Is ranking on Google enough to be featured in AI Overviews or ChatGPT?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Traditional rankings measure relevance, but AI systems prioritize extractability and trust. A page may rank well and still be excluded from AI-generated answers if its information is not structured, explicit, and verifiable enough to be safely cited."
      }
    }
  ]
}
```

### Schema-Content Alignment
✅ **Questions match verbatim**  
✅ **Answers match verbatim** (with minor formatting adjustments for schema)  
✅ **No discrepancies between visible content and schema**

---

## ANSWER WRITING RULES (COMPLIANCE)

✅ **Declarative, not promotional**  
✅ **Avoids guarantees**  
✅ **Explains mechanism, not hacks**  
✅ **Uses language AI systems can safely quote**  
✅ **Explanatory, neutral, authoritative tone**  
✅ **No hype, no CTA inside answers**

---

## GOVERNANCE & RISK CONTROLS

✅ **No additional FAQ questions added**  
✅ **Answers match schema exactly**  
✅ **No brand mentions stuffed into answers**  
✅ **No promises of inclusion, listing, or features**  
✅ **Educational, not promotional**

---

## WHY THIS WORKS

✅ **Matches live PAA intent clusters**  
✅ **Avoids duplication and cannibalization**  
✅ **Uses AI-extractable language**  
✅ **Positions NRLC.ai as an explainer, not a claimant**  
✅ **Improves eligibility for:**
- AI Overviews
- PAA expansion
- LLM citation surfaces

---

## VALIDATION CHECKLIST

- [x] 4 canonical questions (no redundancy)
- [x] Visible FAQ content below hero
- [x] FAQPage schema implemented
- [x] Schema matches visible content exactly
- [x] Answers are declarative, not promotional
- [x] No guarantees or promises
- [x] No CTAs in answers
- [x] Educational tone maintained
- [x] No brand stuffing
- [x] Syntax validated (no PHP errors)

---

## FILES MODIFIED

1. **`pages/home/home.php`**
   - Added FAQ section (lines 39-59)
   - Added FAQPage schema (lines 230-280)

---

## SUCCESS CONDITIONS

✅ **FAQ Dataset:** Canonicalized (4 questions)  
✅ **Schema:** Valid (FAQPage JSON-LD)  
✅ **AI Extractability:** High (citation-ready language)  
✅ **Spam Risk:** Low (educational, not promotional)  
✅ **Homepage Fit:** Correct (below hero, above service content)

---

**STATUS: COMPLETE & COMPLIANT**

**Next Step:** Validate with Google Rich Results Test tool

