# DEEP ANALYSIS: Training Service Page for Cardiff
## URL: https://nrlc.ai/en-gb/services/training/cardiff/

**Date:** 2026-01-15  
**Status:** ❌ CRITICAL ISSUES FOUND

---

## 🔴 CRITICAL ISSUE #1: Intent Mismatch

**Problem:** Training is being treated as a SERVICE (done-for-you execution) when it should be EDUCATION (skill transfer).

**Evidence:**
- Page uses `/services/training/cardiff/` URL pattern (service-city template)
- Page describes a "4-phase engagement" with "implementation" and "deployment"
- CTAs say "Request a Cardiff Training" (service language)
- Pricing section describes "engagements" and "implementation costs"
- Process section describes "Step-by-Step Service Delivery"

**What Should Happen:**
- Training should be at `/training/` (educational hub)
- Training should describe courses, workshops, skill transfer
- Training should NOT have service-city pages
- Training = education, Services = execution (per TRAINING_IMPLEMENTATION.md)

**Impact:** Google will misclassify training as a service, causing intent pollution and trust dilution.

---

## 🔴 CRITICAL ISSUE #2: Massive Content Repetition

**Problem:** The phrase "In Cardiff, this approach is tailored to local market conditions and regional search behavior patterns" appears **6+ times** on the page.

**Root Cause:** `city_specific_faq_block()` function in `lib/content_tokens.php` (line 469) automatically appends this phrase to every FAQ answer that doesn't already contain the city name.

**Code:**
```php
$aEnhanced .= " In {$c}, this approach is tailored to local market conditions and regional search behavior patterns.";
```

**Impact:** 
- Makes content look AI-generated
- Hurts user experience
- Reduces credibility
- Wastes crawl budget on duplicate content

---

## 🔴 CRITICAL ISSUE #3: Generic, Meaningless FAQs

**Problem:** FAQs don't actually explain what "Training" is.

**Current FAQs:**
- "What's included in Training?" → Generic answer
- "What is Training?" → Doesn't explain it's education/skill transfer
- "How does Training work?" → Describes it as a service with "cutting-edge AI technology"
- All answers end with the same repetitive phrase

**What's Missing:**
- What training courses/workshops are offered
- Who the training is for (teams, individuals, agencies)
- What skills are taught
- How training is delivered (in-person, online, workshops)
- Duration and format
- Prerequisites

---

## 🔴 CRITICAL ISSUE #4: Service Language in Training Context

**Problem:** Page uses service execution language instead of education language.

**Examples:**
- "Request a Cardiff Training" (should be "Enroll in Training" or "View Training Courses")
- "Service Overview" (should be "Training Overview" or "What You'll Learn")
- "Process / How It Works" describes service delivery phases (should describe curriculum/learning path)
- "Implementation & Deployment" (training doesn't have "deployment")
- "Pricing for Training in Cardiff" with "engagements" (should be course pricing)

**Correct Language:**
- "Training courses for Cardiff teams"
- "What you'll learn"
- "Training format and delivery"
- "Course pricing"
- "Enroll in training"

---

## 🔴 CRITICAL ISSUE #5: Wrong Schema Markup

**Problem:** Page uses `Service` schema when it should use `Course` or `EducationalOccupationalProgram`.

**Current Schema:** `Service` with `serviceType: "Training"`  
**Should Be:** `Course` or `EducationalOccupationalProgram` with `teaches` array

**Impact:** Google will classify this as a service offering, not education, causing misclassification.

---

## 🔴 CRITICAL ISSUE #6: Content Doesn't Match Training Intent

**Problem:** Content describes optimization work being done FOR the client, not skills being taught TO the client.

**Examples:**
- "We systematically implement the designed improvements"
- "We rigorously test all changes"
- "We provide regular reporting"
- "Implementation costs reflect the depth of technical work required"

**Should Describe:**
- What skills teams will learn
- What concepts will be covered
- How teams will be able to execute after training
- What knowledge will be transferred

---

## 🔴 CRITICAL ISSUE #7: Missing Training-Specific Information

**What's Missing:**
- Training formats (one-on-one, group, workshops)
- Course curriculum/outline
- Learning objectives
- Prerequisites
- Duration (hours, days, weeks)
- Delivery method (online, in-person, hybrid)
- Who should attend
- What materials/resources are provided
- Certification or completion recognition

---

## 🔴 CRITICAL ISSUE #8: Generic Service Template Applied to Training

**Problem:** The page uses the generic `service_city.php` template which is designed for services like:
- Site Audits
- Crawl Clarity
- JSON-LD Strategy
- Technical SEO

**Training is fundamentally different:**
- Services = done-for-you execution
- Training = skill transfer/education

**Solution:** Training should NOT use service-city template. It should either:
1. Be removed (training doesn't need city-specific pages)
2. OR have a completely different template for training courses

---

## 📊 Content Quality Issues

### Repetitive Phrases Found:
1. "In Cardiff, this approach is tailored to local market conditions and regional search behavior patterns" - **6+ times**
2. "In Cardiff, WLS" - appears multiple times
3. Generic service language throughout

### Missing Information:
- What training courses are actually offered
- Training format and delivery
- Learning objectives
- Prerequisites
- Duration
- Pricing for courses (not "engagements")

---

## ✅ RECOMMENDED FIXES

### Option 1: Remove Training Service-City Pages (RECOMMENDED)
- Training should only exist at `/training/` (educational hub)
- Remove all `/services/training/{city}/` pages
- Training is education, not a location-specific service

### Option 2: Create Training-Specific Template
- If training needs city-specific pages, create a new template
- Use `Course` schema, not `Service`
- Describe courses/workshops, not service delivery
- Remove repetitive FAQ appending logic

### Option 3: Fix FAQ Repetition (IMMEDIATE)
- Remove automatic city phrase appending in `city_specific_faq_block()`
- Make FAQs actually explain what training is
- Remove generic service FAQs for training

---

## 🎯 IMMEDIATE ACTION ITEMS

1. **Fix FAQ repetition bug** - Remove line 469 in `lib/content_tokens.php` that appends repetitive phrase
2. **Decide on training structure** - Should training have city-specific pages?
3. **Fix schema** - Change from `Service` to `Course`/`EducationalOccupationalProgram`
4. **Rewrite content** - Remove service language, add training-specific information
5. **Fix CTAs** - Change from "Request" to "Enroll" or "View Courses"

---

## 📝 Notes

Per `TRAINING_IMPLEMENTATION.md`:
- Training = skill transfer (education)
- Services = done-for-you execution
- These should be completely separate
- Training should NOT compete with service pages
- Training should NOT promise execution outcomes

The current page violates all of these principles.
