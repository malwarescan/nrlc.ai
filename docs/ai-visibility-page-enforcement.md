# AI Visibility Page Enforcement Summary

**Date:** 2025-12-18  
**Directive:** SUDO META DIRECTIVE — AI VISIBILITY SERVICE PAGE  
**Page:** `/en-us/ai-visibility/`

## Compliance Checklist

### ✅ Structured Data (JSON-LD ONLY)

1. **Organization** (SINGLE SOURCE OF TRUTH)
   - Uses `ld_organization()` function
   - Entity anchoring for all AI references

2. **Service** (REQUIRED — PRIMARY SCHEMA)
   - `name`: "AI Visibility & Trust Audit"
   - `serviceType`: "AI Visibility Optimization"
   - `description`: Explicitly states analysis of how AI systems describe businesses
   - `provider`: References Organization entity by @id

3. **WebPage**
   - `name`: "AI Visibility"
   - `description`: Professional service offering, mentions AI systems by name
   - `mainEntity`: References Service entity

4. **BreadcrumbList**
   - Home → AI Visibility
   - Reinforces site architecture

5. **FAQPage** (STRICT)
   - Only questions that appear verbatim on page
   - 5 questions matching visible content exactly
   - No paraphrasing, no additional FAQs

6. **Action** (OPTIONAL BUT RECOMMENDED)
   - `name`: "Request AI Visibility Audit"
   - `target`: `/api/book/` endpoint

### ✅ Content & Semantic Rules

**Above the Fold:**
- ✅ States WHAT the service is (professional diagnostic service)
- ✅ States WHO it is for (high-trust industries)
- ✅ States WHAT problem it solves (AI systems recommend competitors if unclear)
- ✅ Explicitly says "This is NOT traditional SEO"
- ✅ References AI systems by name: ChatGPT, Google AI Overviews, Perplexity, Claude

**Terminology Lock:**
- ✅ Uses "AI Visibility" consistently
- ✅ Uses "AI Trust Signals" 
- ✅ Uses "How AI describes your business"
- ✅ Uses "AI-generated summaries"
- ✅ Avoids "Rank higher", "Traffic growth", "Keywords" (except when contrasting with SEO)

**CTA Section:**
- ✅ "Request AI Visibility Audit" (diagnostic, not salesy)
- ✅ "See How AI Describes Your Business" (diagnostic)
- ✅ No "Get Started" or "Boost Visibility" language

### ✅ Technical Enforcement

- ✅ Canonical self-reference (handled by router)
- ✅ Meta title: "AI Visibility | How AI Describes Your Business | NRLC.ai"
- ✅ Meta description: Explains AI summaries, not rankings
- ✅ No duplicated meta titles/descriptions
- ✅ Page is crawlable, indexable (SSR, no JS-only content)

### ✅ Agentic Readiness

- ✅ Easily summarizable in 1-2 sentences
- ✅ Clearly attributable to NRLC.ai as source
- ✅ Interpretable without clicking internal links
- ✅ Primary citation candidate for "What does NRLC.ai do?"

## Intent Lock Verification

**Intent Type:** ✅ Commercial / Professional Service  
**User Intent:** ✅ "How does AI describe my business and how do I fix it"  
**NOT:** ✅ Blog/explainer, Tool/SaaS, Generic SEO language

## Files Modified

1. `pages/ai-visibility/index.php`
   - Updated schema (Service name, serviceType, description)
   - Added FAQPage schema (verbatim questions)
   - Added Action schema
   - Updated hero section (WHAT, WHO, WHAT PROBLEM)
   - Added explicit "NOT SEO" language
   - Added AI system names (ChatGPT, Google AI Overviews, Perplexity, Claude)
   - Updated terminology throughout
   - Changed FAQ to `<dl>` format for better semantic structure

2. `bootstrap/router.php`
   - Updated meta title: "AI Visibility | How AI Describes Your Business | NRLC.ai"
   - Updated meta description: Explains AI summaries, not rankings

## Schema Validation

All schema is JSON-LD only, placed in `<head>`, no microdata/RDFa.

**Service Schema:**
- Correctly references Organization entity by @id
- Name matches visible content: "AI Visibility & Trust Audit"
- Description explicitly states diagnostic nature

**FAQPage Schema:**
- Questions match visible content verbatim
- No additional questions
- No paraphrasing

## Expected Impact

1. **AI Citation Readiness:** Page is clearly a professional service, easily citable
2. **Search Engine Understanding:** Unambiguous service intent, not blog/tool
3. **Agentic System Clarity:** AI systems can summarize and attribute correctly
4. **Rich Results Eligibility:** FAQPage schema enables rich snippets

## Verification

Run validation:
```bash
# Check schema output
curl https://nrlc.ai/ai-visibility/ | grep -A 50 'application/ld+json'

# Validate with Google Rich Results Test
# https://search.google.com/test/rich-results
```

