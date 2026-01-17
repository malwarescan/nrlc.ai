# Learn Pages: Schema & Hreflang Fix

**Issue:** Learn pages need Course schema (not Article) + hreflang for translated results  
**Date:** 2026-01-27  
**Status:** IN PROGRESS

---

## CURRENT ISSUES

### 1. Schema Type
- ❌ Currently using `Article` schema
- ✅ Should use `Course` or `LearningResource` schema for educational content
- ✅ Need to maintain Answer-First Architecture

### 2. Translated Results (Hreflang)
- ❌ `/learn/` pages not in hreflang allowlist
- ❌ No hreflang tags output for learn pages
- ✅ Need to add to allowlist for translated results in GSC

---

## FIXES NEEDED

### Fix 1: Update Schema from Article to Course

**Current Schema (Article):**
```json
{
  "@type": "Article",
  "headline": "...",
  "articleSection": "Beginner Education"
}
```

**New Schema (Course):**
```json
{
  "@type": "Course",
  "name": "...",
  "description": "...",
  "provider": {
    "@type": "Organization",
    "@id": "..."
  },
  "educationalLevel": "Beginner",
  "inLanguage": "en-US",
  "teaches": ["SEO Fundamentals", "..."]
}
```

**Properties Required:**
- ✅ `name`: Course title (e.g., "Can AI Do SEO?")
- ✅ `description`: Course summary (Answer-First, under 160 chars)
- ✅ `provider`: Neural Command LLC (Organization)
- ✅ `educationalLevel`: "Beginner"
- ✅ `inLanguage`: "en-US"
- ✅ `teaches`: Array of skills/topics
- ✅ `courseCode`: Optional (e.g., "LEARN-AI-SEO-001")

### Fix 2: Add /learn/ to Hreflang Allowlist

**Add to `lib/hreflang_allowlist.php`:**
```php
'/learn/' => ['en-us', 'en-gb'], // English only for now
'/learn/can-ai-do-seo/' => ['en-us', 'en-gb'],
'/learn/types-of-seo/' => ['en-us', 'en-gb'],
// ... etc for all learn pages
```

**Or use inheritance pattern:**
```php
'/learn/' => ['en-us', 'en-gb'], // Parent
// Individual pages inherit from /learn/
```

### Fix 3: Maintain Answer-First Architecture

**Current Implementation (✅ CORRECT):**
- Direct answer in first sentence: "Yes, AI enhances SEO processes..."
- Definition lock with `<dfn>` tag
- Information in first 1-2 sentences
- Answer-First format maintained

**Schema Description Must:**
- Match the Answer-First definition (first sentence)
- Be under 160 characters for meta description
- Include the direct answer

---

## IMPLEMENTATION PLAN

1. ✅ Update schema from `Article` to `Course` on all learn pages
2. ✅ Add `/learn/` to hreflang allowlist
3. ✅ Ensure Answer-First Architecture is maintained in descriptions
4. ✅ Test schema with Rich Results Test
5. ✅ Verify hreflang tags output correctly

---

## SCHEMA COMPARISON

### Article Schema (Current)
- `@type`: Article
- `headline`: Course title
- `articleSection`: "Beginner Education"

### Course Schema (Recommended)
- `@type`: Course
- `name`: Course title
- `description`: Answer-First definition
- `provider`: Organization
- `educationalLevel`: "Beginner"
- `inLanguage`: "en-US"
- `teaches`: Skills array

**Why Course?**
- Better for educational content rich snippets
- Enables Course rich results in Google
- More semantically correct for educational content
- Supports translated results better
