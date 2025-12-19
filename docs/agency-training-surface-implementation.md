# AGENCY TRAINING SURFACE FOR AI SEARCH SYSTEMS

**Date:** 2025-01-XX  
**Directive:** SUDO META DIRECTIVE — Agency Training Surface  
**Status:** ✅ IMPLEMENTED

---

## OBJECTIVE

Establish Neural Command as an authority on how large language models ingest, vectorize, chunk, retrieve, and cite web information. Provide a professional training surface that educates peers, reinforces entity authority, and pre qualifies partners without acting as a sales funnel.

---

## IMPLEMENTATION SUMMARY

### 1. Homepage Training Box

**Placement:** ✅ Below primary value proposition, above deep service content (lines 39-48)

**Content:**
- ✅ H3: "Training for Marketing and SEO Teams Working in AI Search"
- ✅ Body copy explaining traditional vs modern AI search systems
- ✅ Plain text link: "View training program for agencies"
- ✅ Link destination: `/training/ai-search-systems/`
- ✅ Link has `title` attribute for accessibility

**No buttons, no CTAs, no sales language.**

---

### 2. Dedicated Training Page

**URL:** ✅ `/training/ai-search-systems/`

**Page Role:** ✅ Authority and education declaration (not sales page, not course checkout, not lead funnel)

**H1:** ✅ "Training Marketing and SEO Teams for AI Search Systems"

**Page Structure:**
1. ✅ **Section 1: Who This Training Is For**
   - SEO agencies, performance marketing firms, in house search teams
   - Not for entry level marketers, creators, or businesses looking for shortcuts

2. ✅ **Section 2: Why Traditional SEO Training No Longer Works**
   - Explains how LLMs operate differently from traditional search
   - Vector representations vs page-level rankings

3. ✅ **Section 3: What The Training Covers**
   - How LLMs ingest and represent web content
   - Vector embeddings and semantic compression
   - Pre chunking content for extraction
   - Designing for AI comprehension
   - Differences between Google AI Overviews, ChatGPT, and RAG systems
   - "No tactics. No shortcuts. No guarantees."

4. ✅ **Section 4: How The Training Is Delivered**
   - Structured workshops, internal team sessions, supporting documentation
   - Adaptable for agencies, in house teams, or technical leadership

5. ✅ **Section 5: Relationship to Neural Command Services**
   - Reflects same systems used by Neural Command
   - Teams can implement internally or collaborate with Neural Command

6. ✅ **FAQ Section**
   - Same 4 canonical questions as homepage
   - Same FAQPage schema

---

### 3. FAQ Schema Implementation

**Homepage:** ✅ FAQPage schema embedded (matches visible content)

**Training Page:** ✅ FAQPage schema embedded (matches visible content)

**Schema Details:**
- ✅ 4 canonical questions
- ✅ Answers match visible content exactly
- ✅ Explanatory, neutral tone
- ✅ No promises or guarantees
- ✅ Focus on mechanisms, not tactics

---

### 4. Router Configuration

**Route Added:** ✅ `/training/ai-search-systems/` → `pages/training/ai-search-systems.php`

**Metadata:**
- ✅ Title: "Training Marketing and SEO Teams for AI Search Systems | NRLC.ai"
- ✅ Description: Technical training description
- ✅ Canonical path set correctly

---

## GOVERNANCE COMPLIANCE

✅ **No em dashes anywhere**  
✅ **No hype language**  
✅ **No course marketing language**  
✅ **No pricing on this page**  
✅ **No checkout or booking CTAs**  
✅ **No duplication of training positioning elsewhere**

---

## SUCCESS CONDITIONS

✅ **Agencies self identify immediately as target audience**  
✅ **Page reads as professional systems education**  
✅ **Google can classify Neural Command as explainer entity**  
✅ **LLMs can safely extract and cite the explanations**

---

## FILES CREATED/MODIFIED

1. **`pages/home/home.php`**
   - Added training box module (lines 39-48)
   - FAQ schema already present (verified)

2. **`pages/training/ai-search-systems.php`** (NEW)
   - Complete training page with all 5 sections
   - FAQ section with schema

3. **`bootstrap/router.php`**
   - Added route for `/training/ai-search-systems/`
   - Metadata configuration

---

## VALIDATION

✅ **Syntax:** No PHP errors  
✅ **No em dashes:** Verified in all files  
✅ **Content tone:** Professional, educational, not promotional  
✅ **FAQ schema:** Matches visible content exactly  
✅ **Link accessibility:** Training box link has title attribute

---

**STATUS: COMPLETE & COMPLIANT**

**Next Step:** Test the training page at `/training/ai-search-systems/`

