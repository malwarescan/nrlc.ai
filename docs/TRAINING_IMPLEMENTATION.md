# Training & Classes Offering Implementation

**Date:** 2025-01-27  
**Directive:** META DIRECTIVE — Training & Classes Offering (NRLC.AI)  
**Status:** ✅ IMPLEMENTED

---

## Implementation Summary

Training offering introduced as separate intent class from services. Training is education (skill transfer), services are execution. Clear separation prevents intent pollution and Google classification confusion.

---

## Files Created

### 1. `pages/training/index.php`
**Role:** Educational offering hub (NOT sales page, NOT curriculum dump)

**Above-the-fold requirements (met):**
- ✅ Clearly states: "This is training"
- ✅ States: "For marketing teams and operators"
- ✅ States: "Focused on modern search (SEO + AEO + GEO)"

**Must NOT (verified):**
- ✅ Does NOT compete with service pages
- ✅ Does NOT promise execution outcomes
- ✅ Does NOT use "we'll do it for you" language

**Schema:** Uses `EducationalOccupationalProgram` (NOT Service)

### 2. `pages/training/one-on-one.php`
**Role:** High-intent educational offering (skill transfer, not delivery)

**Allowed language (used):**
- ✅ "hands-on"
- ✅ "operator-level"
- ✅ "execution-aware"
- ✅ "instrumentation"
- ✅ "decision frameworks"

**Forbidden language (NOT used):**
- ✅ No "we manage"
- ✅ No "we optimize for you"
- ✅ No "done-for-you"
- ✅ No "agency"

**Schema:** Uses `Course` (NOT Service)

---

## Files Updated

### 1. `templates/header.php`
**Changes:**
- Added "Training" to top-level navigation
- Placed after Knowledge Base, before secondary nav
- Links to `/training/`
- Active state detection for training pages

### 2. `bootstrap/router.php`
**Changes:**
- Added route for `/training/` → renders `training/index`
- Added route for `/training/one-on-one/` → renders `training/one-on-one`
- Preserved existing `/training/ai-search-systems/` route

### 3. `pages/ai-visibility/index.php`
**Changes:**
- Added "AI Visibility by Industry" section listing all 10 industry pages

---

## URL Structure

```
/training/
├── index.php (hub page)
├── one-on-one.php (one-on-one training)
└── ai-search-systems.php (existing legacy page)
```

**Future expansion (not yet implemented):**
- `/training/team-training/`
- `/training/seo-training/`
- `/training/aeo-training/`
- `/training/geo-training/`

---

## Schema Implementation

### Training Index (`/training/`)
- ✅ `EducationalOccupationalProgram` schema
- ✅ `provider` references Organization @id
- ✅ `teaches` array lists skills
- ✅ NO Service schema
- ✅ NO LocalBusiness schema

### One-on-One Training (`/training/one-on-one/`)
- ✅ `Course` schema
- ✅ `provider` references Organization @id
- ✅ `teaches` array lists skills
- ✅ NO Service schema
- ✅ NO LocalBusiness schema

---

## Intent Model (Locked)

**Services = done-for-you execution** → nrlcmd.com  
**Research / Framing = understanding AI visibility** → nrlc.ai  
**Training = skill transfer** → nrlc.ai

Training is neither research nor services. It is its own intent class.

---

## Navigation Placement

**Top-level navigation:**
- Home
- Knowledge Base (dropdown)
- **Training** ← NEW (parallel to Knowledge Base)
- [Secondary nav: Contact, Implementation, Careers]

**DO NOT:**
- ❌ Place training near Contact
- ❌ Place training under Services
- ❌ Cross-link training as a service

Training is parallel, not downstream.

---

## Internal Linking Rules

**Allowed:**
- ✅ Research pages MAY link to training contextually
- ✅ Training pages MAY link to research
- ✅ Training pages describe services (not promotional)

**Forbidden:**
- ❌ Training pages MUST NOT link directly to service CTAs
- ❌ Service mentions must be descriptive, not promotional

---

## SEO Outcome (Intended)

This structure ensures Google classifies:
- **nrlc.ai as:**
  - Research authority
  - Educational authority
  - Skill transfer source
- **nrlcmd.com as:**
  - Execution vendor
  - Commercial operator

**No overlap. No cannibalization. No trust dilution.**

---

## Implementation Order (Completed)

✅ 1. Create `/training/` index page  
✅ 2. Create `/training/one-on-one/`  
✅ 3. Add "Training" to top-level nav  
⏳ 4. Wait 2–3 weeks before adding more training pages

**Next steps (after 2–3 weeks):**
- Monitor Google classification
- Add team training page if signals are positive
- Add specialized tracks (SEO, AEO, GEO) if needed

---

## Core Principle (DO NOT BREAK)

**Training exists to:** teach operators how modern search works  
**Services exist to:** execute when they don't want to

As long as that line is never crossed, both offerings will reinforce each other instead of competing.

---

**Implementation Complete.** Training offering is live and properly classified as education, not services.

