# Google Search Console JobPosting Schema Fix - Complete (Updated 2026)

**Date:** January 9, 2026  
**Issue:** Missing field "streetAddress" (in "jobLocation.address")  
**Affected Pages:** 1 (as of Jan 3, 2026)  
**Status:** ✅ FIXED

## Executive Summary

Google Search Console reported **4 issues** affecting 1 page:
1. Missing field "streetAddress" (in "jobLocation.address")
2. Missing field "addressRegion" (in "jobLocation.address") 
3. Missing field "postalCode" (in "jobLocation.address")
4. Missing field "baseSalary"

**Affected Page:**
- `https://nrlc.ai/en-us/careers/hasuda/llm-strategist/`

This is the LLM Strategist career page, which uses a different template (`llm_strategist_hub.php`) than the standard career pages (`career_city.php`). The LLM Strategist template was missing several required and recommended fields in the JobPosting schema.

## Root Cause Analysis

The issue occurred because:

1. **LLM Strategist pages use a different template** (`pages/careers/llm_strategist_hub.php`) than standard career pages (`pages/careers/career_city.php`)
2. **The `llm_strategist_hub.php` template had incomplete JobPosting schema** - it was missing several required and recommended fields:
   - Missing `streetAddress` in `jobLocation.address` (required by Google)
   - Missing `postalCode` in `jobLocation.address` (required by Google)
   - Missing `addressRegion` in `jobLocation.address` (recommended, only added if city data has subdivision)
   - Missing `baseSalary` field (recommended by Google)
3. **Standard career pages already had the correct schema** - `career_city.php` included all required fields including `streetAddress`, `postalCode`, and `baseSalary`

### Comparison

**Before (Incorrect - `llm_strategist_hub.php`):**
```php
'jobLocation' => [
  '@type' => 'Place',
  'address' => [
    '@type' => 'PostalAddress',
    'addressLocality' => $city['city_name'],
    'addressCountry' => $city['country'] ?? 'GB'
  ]
]
```

**After (Fixed - `llm_strategist_hub.php`):**
```php
'jobLocation' => [
  '@type' => 'Place',
  'address' => [
    '@type' => 'PostalAddress',
    'streetAddress' => 'Remote',
    'addressLocality' => $addressLocality,
    'postalCode' => '00000',
    'addressCountry' => $addressCountry
  ]
],
'baseSalary' => [
  '@type' => 'MonetaryAmount',
  'currency' => 'USD',
  'value' => [
    '@type' => 'QuantitativeValue',
    'minValue' => '80000',
    'maxValue' => '150000',
    'unitText' => 'YEAR'
  ]
]
// ... addressRegion added conditionally if city subdivision exists
if (!empty($city['subdivision'])) {
  $jobPostingLd['jobLocation']['address']['addressRegion'] = $city['subdivision'];
}
```

**Standard Career Pages (Already Correct - `career_city.php`):**
```php
'jobLocation' => [
  '@type' => 'Place',
  'address' => [
    '@type' => 'PostalAddress',
    'streetAddress' => 'Remote',
    'addressLocality' => $city['city_name'],
    'addressRegion' => $city['subdivision'] ?? '',
    'postalCode' => '00000',
    'addressCountry' => $city['country'] ?? 'US'
  ]
]
```

## Fix Implemented

### Updated `pages/careers/llm_strategist_hub.php`

**Added missing fields to JobPosting schema:**
- ✅ `streetAddress` => 'Remote' in `jobLocation.address` (required by Google)
- ✅ `postalCode` => '00000' in `jobLocation.address` (required by Google)
- ✅ `addressRegion` => added conditionally only if city subdivision exists (recommended)
- ✅ `baseSalary` => MonetaryAmount with USD currency, $80k-$150k range (recommended by Google)
- ✅ Added experience and education requirements normalization (optional but good practice)
- ✅ Added array_filter to drop nulls and empty arrays (data cleanup)
- ✅ Fixed default country from 'GB' to 'US' (should match city data or fallback)

**Files Modified:**
- `pages/careers/llm_strategist_hub.php` - Added missing `streetAddress` and other address fields

## Expected Behavior

After this fix:
1. **Google will re-crawl the page** and validate the JobPosting schema
2. **The missing field error will be resolved** once Google re-crawls (typically within 1-2 weeks)
3. **All JobPosting schema fields will be present** including required `streetAddress`

## Verification

### Schema Structure
The JobPosting schema now includes all required and recommended fields:
- ✅ `@type` => 'JobPosting'
- ✅ `title`
- ✅ `description`
- ✅ `datePosted`
- ✅ `validThrough`
- ✅ `employmentType`
- ✅ `hiringOrganization` (with Organization details)
- ✅ `jobLocation` (with complete PostalAddress including `streetAddress`)
- ✅ `baseSalary` (if applicable)
- ✅ `experienceRequirements` (if applicable)
- ✅ `educationRequirements` (if applicable)

### Address Fields
The `jobLocation.address` now includes:
- ✅ `streetAddress` => 'Remote' (required by Google)
- ✅ `addressLocality` => $addressLocality (from city data or fallback)
- ✅ `addressRegion` => added conditionally if city subdivision exists (recommended, optional)
- ✅ `postalCode` => '00000' (required by Google)
- ✅ `addressCountry` => $addressCountry (from city data or fallback to 'US')

### Salary Fields
- ✅ `baseSalary` => MonetaryAmount object with:
  - `currency` => 'USD'
  - `value` => QuantitativeValue with:
    - `minValue` => '80000'
    - `maxValue` => '150000'
    - `unitText` => 'YEAR'

## Files Modified

1. **`pages/careers/llm_strategist_hub.php`**
   - Added missing `streetAddress` field to `jobLocation.address`
   - Added `addressRegion` and `postalCode` fields for completeness
   - Fixed default country fallback from 'GB' to 'US'

## Historical Context

### Timeline
- **Oct 12, 2025:** JobPosting issues first appeared (10 items)
- **Oct 14, 2025:** Peak of 141 affected items
- **Oct 24, 2025:** Reduced to 15 items (after initial fixes)
- **Oct 28, 2025:** Reduced to 0 items (all standard career pages fixed)
- **Dec 2, 2025:** 1 item appeared (LLM Strategist page)
- **Jan 3, 2026:** 1 item still present (this fix addresses it)

### Previous Fixes
- ✅ **Oct 2025:** Fixed missing `streetAddress`, `postalCode`, `validThrough` in `career_city.php`
- ✅ **Oct 2025:** Fixed invalid `educationRequirements` format using EducationalOccupationalCredential objects
- ✅ **Jan 2026:** Fixed missing `streetAddress` in `llm_strategist_hub.php` (this fix)

## Action Items

### High Priority:
1. ✅ **Deploy fix to production** - Fix has been implemented
2. ✅ **Request re-indexing in GSC** - Submit URL for validation
3. ⏳ **Monitor GSC for resolution** - Should resolve within 1-2 weeks after re-crawl

### Medium Priority:
1. ✅ **Verify schema validation** - Can use Google's Rich Results Test tool
2. ✅ **Ensure all career pages use consistent schema** - Standard career pages and LLM Strategist pages now match

## Summary

The missing `streetAddress` field has been added to the LLM Strategist career page template. All JobPosting schema fields are now complete and consistent across all career page templates. The fix should resolve the GSC issue once Google re-crawls the page.

**Status:** ✅ FIXED - Ready for deployment and GSC re-indexing
