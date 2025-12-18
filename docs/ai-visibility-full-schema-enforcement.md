# AI Visibility Page - Full Schema Enforcement

**Page:** `https://nrlc.ai/en-us/ai-visibility/`  
**Directive:** SUDO META DIRECTIVE — FULL SCHEMA APPLICATION  
**Status:** ✅ COMPLIANT

## Schema Implementation Summary

### 1. Organization Schema (MANDATORY, SINGLE SOURCE OF TRUTH)
✅ **Implemented**
- `@type`: `Organization`
- `name`: `NRLC.ai` (per directive requirement)
- `url`: Canonical site root
- `logo`: Absolute URL with ImageObject structure
- `sameAs`: Verified brand profiles only (LinkedIn, Google Business Profile)
- `@id`: `{domain}#organization` (referenced by all other schemas)

**Purpose:** Anchor all AI statements and citations to a real-world entity.

### 2. Service Schema (PRIMARY — NON-NEGOTIABLE)
✅ **Implemented**
- `@type`: `Service`
- `name`: `"AI Visibility & Trust Audit"`
- `serviceType`: `"AI Visibility Optimization"`
- `description`: `"Professional analysis of how AI systems describe, summarize, and trust a business, including the signals influencing AI-generated answers."`
- `provider`: References Organization entity by `@id`
- `url`: Canonical page URL

**Purpose:** Defines page intent as a commercial service. Without this, the page is NOT a service in Google's eyes. This is the strongest schema on the page.

### 3. WebPage Schema (MANDATORY)
✅ **Implemented**
- `@type`: `WebPage`
- `name`: `"AI Visibility"`
- `url`: Canonical page URL
- `isPartOf`: References main website entity (WebSite)
- `mainEntity`: References Service entity by `@id`

**Purpose:** Clarifies page-level purpose vs entity-level purpose.

### 4. BreadcrumbList (MANDATORY)
✅ **Implemented**
- `@type`: `BreadcrumbList`
- Structure: Home → AI Visibility
- URLs match real crawlable paths

**Purpose:** Reinforces site architecture and topical containment.

### 5. FAQPage Schema (STRICT, ZERO TOLERANCE)
✅ **Implemented**
- `@type`: `FAQPage`
- **5 questions** that appear verbatim on the page
- **Answers match visible content word-for-word** (verified)
- NO paraphrasing
- NO additional FAQs

**Questions:**
1. "Can you control what ChatGPT says about my business?"
2. "Is this different from SEO?"
3. "Will this replace Google rankings?"
4. "Is this safe and compliant?"
5. "How long does it take to see changes?"

**Purpose:** AI question-answer extraction, Rich eligibility, LLM grounding.

### 6. Action Schema (RECOMMENDED — CONVERSION SIGNAL)
✅ **Implemented**
- `@type`: `Action`
- `name`: `"Request AI Visibility Audit"`
- `actionStatus`: `"https://schema.org/PotentialActionStatus"`
- `target`: EntryPoint pointing to `/api/book/`

**Purpose:** Tell AI systems this page exists to trigger a professional audit request, not passive reading.

## Meta & Technical Enforcement

### Meta Title
✅ **Compliant**
- Contains "AI Visibility"
- Contains "NRLC"
- Unique site-wide: `"AI Visibility | How AI Describes Your Business | NRLC.ai"`

### Meta Description
✅ **Compliant**
- Explains AI-generated summaries and AI trust
- Does NOT mention rankings, keywords, or traffic growth
- Text: `"AI Visibility & Trust Audit: Analysis of how AI systems like ChatGPT, Google AI Overviews, Perplexity, and Claude describe businesses and the signals influencing AI-generated summaries. Professional diagnostic service from NRLC.ai."`

### Canonical
✅ **Compliant**
- Self-referencing only
- No parameters
- No alternates

### Indexing
✅ **Compliant**
- Page is crawlable
- No JS-only content required for understanding
- No blocked resources

## Semantic Content Enforcement

### Above the Fold
✅ **Compliant**
- Explicitly states this is NOT traditional SEO
- References AI systems by name (ChatGPT, Google AI Overviews, Perplexity, Claude)
- States that AI outputs are learned from signals

### Language Lock
✅ **Compliant**
- Uses consistently: "AI Visibility", "AI Trust Signals", "How AI describes your business", "AI-generated summaries"
- Avoids: Keyword optimization language, ranking promises, growth claims

## Agentic Readiness Test

✅ **PASSES**

**Test Question 1:** "What does NRLC.ai do?"
- **Answer:** Page is easily summarizable in 1-2 sentences
- **Attribution:** Clearly attributable to NRLC.ai
- **Citation:** Primary citation candidate for professional service

**Test Question 2:** "How can I control what AI says about my business?"
- **Answer:** Page directly addresses this with the AI Visibility & Trust Audit service
- **Intent:** Unambiguously commercial/professional service (not blog/tool)

## Ship Blockers Check

✅ **NO BLOCKERS**
- ✅ Service schema present
- ✅ Organization referenced by all other schemas
- ✅ FAQ matches visible content verbatim
- ✅ Meta titles/descriptions unique
- ✅ Page reads as commercial service (not informational)

## Schema Output Location

All schema is output in `<head>` as JSON-LD only:
- No microdata
- No RDFa
- No duplication across pages

## Files Modified

1. `pages/ai-visibility/index.php` - Complete schema overhaul
2. `bootstrap/router.php` - Meta title/description enforcement

## Compliance Date

2025-01-XX - Full schema enforcement completed per SUDO META DIRECTIVE.

