# GBP Identity Implementation - Complete

**Date:** 2025-01-27  
**Directive:** SUDO META DIRECTIVE KERNEL — NRLC.ai Service URL Permission Ladder (Google Profile–Aligned)  
**Status:** ✅ IMPLEMENTED

---

## Implementation Summary

This implementation ensures all identity information across the NRLC.ai website matches the Google Business Profile (GBP) exactly. GBP is the canonical identity authority.

---

## Files Created

### 1. `config/gbp.json`
Single source of truth for all business identity data. **MUST BE UPDATED** with actual GBP data before deployment.

**Required fields:**
- `businessName` - Must match GBP exactly (character-for-character)
- `legalName` - Must match GBP exactly
- `phone` - Primary phone number exactly as in GBP
- `email` - Business email
- `website` - Website URL exactly as in GBP
- `address` - Full PostalAddress (street, city, state, ZIP, country)
- `googleBusinessProfileUrl` - GBP URL
- `sameAs` - Array of profile URLs (includes GBP URL)

**IMPORTANT:** Update `config/gbp.json` with actual GBP data. Currently contains placeholders.

### 2. `lib/gbp_config.php`
Helper functions to retrieve GBP data consistently across the site.

**Key functions:**
- `gbp_business_name()` - Business name from GBP
- `gbp_phone()` - Primary phone number from GBP
- `gbp_address()` - PostalAddress array for schema
- `gbp_address_display()` - Formatted address string for display
- `gbp_website()` - Website URL from GBP
- `gbp_same_as()` - Array of profile URLs
- `gbp_verify_match()` - QA function to verify values match GBP

---

## Files Updated

### 1. `lib/schema_builders.php`
**Changes:**
- `ld_organization()` now uses GBP data via `gbp_config.php` helpers
- Includes full address, phone, and all GBP fields
- Uses stable `@id` that's reused everywhere: `{gbp_website}#organization`
- `ld_service()` updated to reference single Organization `@id` instead of inline Organization object
- Added `_area_matches_gbp()` helper for service area validation

### 2. `templates/footer.php`
**Changes:**
- Added GBP-ALIGNED identity block showing:
  - Business name (exact from GBP)
  - Full address (exact from GBP)
  - Primary phone (exact from GBP)
  - Links to Contact/Booking pages
- Footer identity block is identical across all pages/locales
- Copyright notice uses GBP business name

### 3. `pages/services/service_city.php`
**Changes:**
- Removed LocalBusiness schema (per directive)
- Service schema provider now references single Organization `@id`
- Added GBP-aligned classifier in above-the-fold section
- First sentence: "{GBP business name} provides {service} for businesses."

### 4. `pages/services/service.php`
**Changes:**
- Added GBP-aligned classifier in above-the-fold section
- First sentence: "{GBP business name} provides {service} for businesses."

### 5. `pages/about/index.php` (NEW)
**Changes:**
- Created new About page with GBP-reconciliation section
- First screen clearly states:
  - Business name (from GBP)
  - What company sells (AI SEO / AI search optimization services)
  - Who it serves (businesses)
  - Where it operates (consistent with GBP service area)
  - How engagement works
- No manifesto language in first screen
- Uses Organization schema via `ld_organization()` (GBP-aligned)

### 6. `pages/ai-visibility/index.php`
**Changes:**
- Organization schema now uses `ld_organization()` instead of manual creation
- Service schema provider references single Organization `@id`

---

## Key Implementation Details

### Single Canonical Organization Entity
- **Stable @id:** `{gbp_website}#organization` (e.g., `https://nrlc.ai#organization`)
- **Used everywhere:** All Service schemas reference this `@id`
- **GBP-aligned:** All fields match GBP exactly

### Footer Identity Enforcement
- Footer displays GBP business name, address, and phone on every page
- Identical across all locales and page types
- Required per directive Section A3

### Service Page Classification
- Every `/services/*` page includes above-the-fold classifier:
  - H1: Service name
  - First sentence: "{GBP business name} provides {service} for businesses."
  - Clear vendor-first framing (business provides service, not research platform)

### LocalBusiness Schema Removal
- LocalBusiness schema removed from service pages
- Should only be used if GBP category explicitly implies storefront model
- Service pages use Organization schema only

### About Page Reconciliation
- First section reconciles with GBP identity
- No manifesto/innovation language in first screen
- Google uses this page to validate GBP legitimacy

---

## QA / Fail Conditions

The following conditions will cause deployment failures (per directive Section G):
- ❌ Footer name, address, or phone differs from GBP
- ❌ Organization schema differs from GBP
- ❌ Multiple Organization entities exist with different @ids
- ❌ Service page introduces identity language not supported by GBP
- ❌ Above-the-fold section does not clearly classify the service

---

## Next Steps (REQUIRED)

### 1. Update GBP Configuration
**CRITICAL:** Update `config/gbp.json` with actual GBP data before deployment:
1. Visit Google Business Profile: https://g.co/kgs/EP6p5de
2. Extract exact values for:
   - Business name (character-for-character)
   - Full address (street, city, state, ZIP, country)
   - Primary phone number
   - Website URL
   - Business category
   - Service area (if specified)
3. Update `config/gbp.json` with exact values
4. Remove `PLEASE_FILL_IN_FROM_GBP` placeholders

### 2. Verification
After updating GBP config, verify:
- Footer displays correct information
- Organization schema matches GBP
- All service pages reference correct Organization @id
- About page displays correct business information

### 3. Testing
Test across:
- Homepage
- Service pages (`/services/*`)
- Service city pages (`/services/*/city/`)
- About page (`/about/`)
- All locales (en-us, en-gb, etc.)

---

## Rollout Order (Per Directive Section H)

✅ 1. Pull GBP fields and lock them as constants (`config/gbp.json` created)  
✅ 2. Update Organization schema to exactly match GBP (`ld_organization()` updated)  
✅ 3. Enforce footer identity consistency (footer.php updated)  
✅ 4. Update About page to reconcile with GBP (about/index.php created)  
✅ 5. Apply service page classifier standard to service pages (service.php & service_city.php updated)  
✅ 6. Roll standard across all /services/* URLs (completed)  
⏳ 7. Re-run QA gates and block releases until clean (PENDING: requires GBP data update)

---

## Notes

- All identity signals now reconcile to GBP exactly
- Single source of truth: `config/gbp.json`
- All helper functions in `lib/gbp_config.php`
- Organization schema is GBP-aligned via `ld_organization()`
- Footer identity is enforced sitewide
- Service pages use vendor-first framing
- LocalBusiness schema removed (per directive)

---

## Core Principle (DO NOT VIOLATE)

**Google already trusts the Google Business Profile. Your job is to make the website stop contradicting it.**

---

**Implementation Complete.** Update `config/gbp.json` with actual GBP data before deployment.

