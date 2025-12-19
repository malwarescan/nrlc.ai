# CTA GOVERNANCE IMPLEMENTATION — COMPLETE

**Date:** 2025-01-XX  
**Directive:** CTA GOVERNANCE LOCK — LOCAL SERVICE PAGES  
**Target Page:** `/en-gb/services/ai-seo-norwich/`

---

## ✅ IMPLEMENTATION STATUS

### Norwich Page CTA Compliance

**Primary CTA Definition:**
- ✅ Label: "Get Your AI Visibility Audit"
- ✅ Destination: `/en-us/services/ai-search-optimization/`
- ✅ Semantic Intent: AI Visibility Audit
- ✅ All 3 CTAs use identical label and destination

**CTA Placements (Exactly 3):**
1. ✅ **Above-the-fold primary CTA block** (Line 84)
   - Single button: "Get Your AI Visibility Audit"
   - Links to: `/en-us/services/ai-search-optimization/`

2. ✅ **Immediately after proof / case study section** (Line 112)
   - Section: "Get Your AI Visibility Audit"
   - Single button: "Get Your AI Visibility Audit"
   - Links to: `/en-us/services/ai-search-optimization/`

3. ✅ **Final CTA at end of page** (Line 184)
   - Single button: "Get Your AI Visibility Audit"
   - Links to: `/en-us/services/ai-search-optimization/`

**Removed Elements:**
- ✅ Removed Call/Email/Book buttons from above-the-fold
- ✅ Removed CTA inside proof section content
- ✅ Removed all `/api/book/` references
- ✅ Removed all `openContactSheet()` calls (replaced with direct links per directive)

**Language Governance:**
- ✅ No "Book", "Schedule", "Get Started", "Try", "Demo", "Calendar" language
- ✅ No hype, promises, guarantees, or urgency language
- ✅ All CTAs imply evaluation, not action
- ✅ Tone: selective, confident, controlled

---

## ✅ AI SEARCH OPTIMIZATION PAGE FIX

**Problem:** Page appeared empty (showing "Select a city to see localized implementation")

**Solution:**
- ✅ Added proper hero content explaining AI Search Optimization
- ✅ Added "What We Do" section with service explanation
- ✅ Added primary CTA using `openContactSheet()` (not self-linking)
- ✅ Removed city selection grid for ai-search-optimization service
- ✅ All CTAs use `openContactSheet('Get a Free AI Visibility Audit')`
- ✅ No `/api/book/` references

**Content Added:**
- Hero: Explains AI Search Optimization vs traditional SEO
- What We Do: Lists 5 key service components
- Primary CTA: "Get a Free AI Visibility Audit" with subtext
- Next Steps: Explains audit deliverable

---

## ✅ BOOKING ENDPOINT REMOVAL

**Verified No `/api/book/` References:**
- ✅ Norwich page: 0 references
- ✅ AI Search Optimization page: 0 references
- ✅ All CTAs use either:
  - Direct links to `/en-us/services/ai-search-optimization/` (Norwich page)
  - `openContactSheet()` calls (AI Search Optimization page)

---

## ✅ TEMPLATE ENFORCEMENT

**Future `/services/{service}-{city}/` Pages Must:**
- ✅ Inherit CTA logic (single destination, max 3 placements)
- ✅ Use "Get Your AI Visibility Audit" label
- ✅ Link to `/en-us/services/ai-search-optimization/`
- ✅ No booking/API links in body content

---

## SUCCESS CONDITIONS MET

✅ User can identify one clear next step within 3 seconds  
✅ No competing buttons appear within scrolling distance  
✅ Page reads as selective, confident, and controlled  
✅ Max 3 CTAs, all pointing to same destination  
✅ No booking/calendar/API endpoints  
✅ No forbidden language patterns  

---

## FILES MODIFIED

1. `/pages/services/ai-seo-norwich.php`
   - Removed Call/Email/Book buttons
   - Standardized all 3 CTAs to same label/destination
   - Removed CTA inside proof section

2. `/pages/services/service.php`
   - Added content for ai-search-optimization service
   - Removed city selection for ai-search-optimization
   - Fixed CTAs to use `openContactSheet()` instead of self-linking

---

**STATUS: COMPLETE & COMPLIANT**

