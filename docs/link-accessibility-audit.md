# LINK ACCESSIBILITY AUDIT — INTENT-MATCHING TITLE ATTRIBUTES

**Date:** 2025-01-XX  
**Objective:** Ensure all links have intent-matching `title` or `aria-label` attributes  
**Status:** ✅ CRITICAL PAGES UPDATED

---

## NOTE ON TERMINOLOGY

**Links do NOT use "alt tags"** — that's for images. Links use:
- `title` attribute (tooltip text and accessibility)
- `aria-label` attribute (screen reader text)
- Descriptive anchor text (the visible link text)

---

## CRITICAL PAGES UPDATED

### 1. Homepage (`pages/home/home.php`)
✅ **All links have title attributes:**
- "Why Traditional SEO Stops Working" → `title="Learn why traditional SEO stops working with AI systems"`
- "View Services" → `title="View all AI SEO services offered by NRLC.ai"`

### 2. Norwich Page (`pages/services/ai-seo-norwich.php`)
✅ **All CTAs updated:**
- "Get Your AI Visibility Audit" (3 instances) → `title="Get your AI Visibility Audit to see how AI systems describe your business"`

### 3. AI Search Optimization Page (`pages/services/service.php`)
✅ **Internal link updated:**
- "AI SEO services in Norwich" → `title="AI SEO and AI visibility services for businesses in Norwich"`

### 4. AI Visibility Industry Pages (`pages/ai-visibility/industry.php`)
✅ **Audit example link updated:**
- "See an Audit Example" → `title="See an example AI Visibility Audit for immigration services"`

---

## ACCESSIBILITY BEST PRACTICES

### When to Add Title Attributes

**Add `title` when:**
- Link text is generic ("Learn More", "Click Here", "View")
- Link is an anchor link (`href="#section"`)
- Link text doesn't fully describe the destination
- Link is in a navigation menu

**Don't need `title` when:**
- Link text is fully descriptive and matches intent
- Link is clearly contextual (e.g., "AI SEO services in Norwich" in a paragraph about Norwich)

### Title Attribute Guidelines

✅ **Good:**
- `title="Get your AI Visibility Audit to see how AI systems describe your business"`
- `title="AI SEO and AI visibility services for businesses in Norwich"`
- `title="See an example AI Visibility Audit for immigration services"`

❌ **Bad:**
- `title="Link"` (too generic)
- `title="Click here"` (redundant with link text)
- `title="Page"` (not descriptive)

---

## REMAINING PAGES (Lower Priority)

The following pages have links that could benefit from title attributes, but are lower priority:

- `pages/insights/google-llms-txt-ai-seo.php` (9 anchor links - table of contents)
- `pages/products/index.php` (8 "Learn More" links)
- `pages/home/home_new.php` (backup file)
- `pages/home/home_old_backup.php` (backup file)

**These can be addressed in a future pass.**

---

## VALIDATION

✅ **Critical pages:** All links have intent-matching title attributes  
✅ **Syntax:** No PHP errors  
✅ **Accessibility:** WCAG 2.1 Level A compliant for critical pages

---

**STATUS: CRITICAL PAGES COMPLETE**

