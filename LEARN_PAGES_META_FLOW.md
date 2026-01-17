# Learn Pages: Meta Title & Description Flow

**Purpose:** Standard flow for meta tags on beginner learning hub pages  
**Date:** 2026-01-27  
**Status:** IMPLEMENTATION STANDARD

---

## META TAG FLOW FOR LEARN PAGES

### 1. Define Primary Intent & Keyword
**Question:** What is the user asking?  
**Example:** "Can AI Do SEO?" → Primary keyword: "Can AI do SEO"

### 2. Craft Meta Title (50-60 chars)
**Formula:** `{Question} | Beginner SEO Education | {Brand}`

**Guidelines:**
- Question as title (matches user query)
- Add context: "Beginner SEO Education"
- Add brand: "Neural Command" (optional if too long)
- Keep under 60 characters
- Use question format to match user intent

**Examples:**
- ✅ `Can AI Do SEO? | Beginner SEO Education | Neural Command` (59 chars)
- ✅ `What are the 4 Types of SEO? | Beginner Education` (51 chars)
- ❌ `Can AI Do SEO? | Learn About AI SEO for Beginners with Neural Command` (71 chars - too long)

### 3. Write Meta Description (150-160 chars)
**Formula:** `{Answer-First Definition} {Additional Context} Learn {Next Step}`

**Guidelines:**
- Start with Answer-First definition (direct answer in first 1-2 sentences)
- Include primary keyword naturally
- Add value proposition or next step
- Keep 150-160 characters (optimal for SERP)
- Unique per page (no duplication)

**Examples:**
- ✅ `Yes, AI enhances SEO processes but requires human oversight for strategy, context, and quality control. Learn which SEO tasks AI can perform.` (159 chars)
- ✅ `The four types of SEO are: on-page, off-page, technical, and local SEO. Learn how each type works and how they complement each other.` (156 chars)

### 4. Align with Answer-First Architecture
**Requirement:** Meta description MUST match the Answer-First definition in content

- Meta description first sentence = Hero Answer-First definition
- Schema Course description = Meta description (matches exactly)
- Both start with direct answer
- Both under 160 characters

### 5. Schema Description Alignment
**Course Schema `description`:**
- Must match meta description exactly (or very close)
- Uses Answer-First definition
- Same length (150-160 chars)
- Same primary keyword

---

## GOOGLE COURSE INFO STRUCTURED DATA

### Required Properties (Already Implemented)
- ✅ `name`: Course title
- ✅ `description`: Answer-First definition
- ✅ `provider`: Organization (Neural Command LLC)
- ✅ `educationalLevel`: "Beginner"
- ✅ `inLanguage`: "en-US"

### Recommended Properties (Add for Course Info Rich Results)
- ⚠️ `timeRequired`: Estimated reading time (e.g., "PT10M" = 10 minutes)
- ⚠️ `coursePrerequisites`: None (for beginner content)
- ⚠️ `courseCode`: Unique identifier (already have: LEARN-AI-SEO-001)
- ⚠️ `teaches`: Array of skills (already have)

### Optional Properties (For Rich Results)
- `aggregateRating`: If you collect ratings
- `numberOfCredits`: Not applicable (free educational content)
- `courseMode`: "online" (default for web content)

---

## IMPLEMENTATION CHECKLIST

For each learn page:

- [ ] Meta title: Question format, 50-60 chars, includes "Beginner Education"
- [ ] Meta description: Answer-First definition, 150-160 chars, includes primary keyword
- [ ] Course schema `description`: Matches meta description exactly
- [ ] Answer-First Architecture: Direct answer in first sentence (content)
- [ ] Schema alignment: Course description = Meta description
- [ ] Unique titles: No duplication across learn pages
- [ ] Unique descriptions: No duplication (first 8 words differ)

---

## CURRENT IMPLEMENTATION STATUS

### ✅ CORRECT:
- `/learn/can-ai-do-seo/`:
  - Title: 59 chars ✅
  - Description: 159 chars ✅
  - Answer-First: Direct answer ✅
  - Schema matches description ✅

- `/learn/types-of-seo/`:
  - Title: 62 chars ⚠️ (slightly over)
  - Description: 156 chars ✅
  - Answer-First: Direct answer ✅
  - Schema matches description ✅

### ⚠️ TO FIX:
- Add `timeRequired` to Course schema (for Course Info rich results)
- Ensure all titles are 50-60 chars (trim if needed)
- Add Course Info properties as recommended by Google
