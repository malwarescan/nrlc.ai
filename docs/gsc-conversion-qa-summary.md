# GSC Conversion QA Audit Summary

## Overview
Comprehensive QA audit of all pages from Google Search Console performance data to ensure optimal conversion (calls/emails).

## Scripts Created

### 1. `scripts/qa_gsc_conversion_audit.php`
**Purpose:** Tests all pages from GSC data for conversion optimization

**What it checks:**
- ✅ HTTP status codes (200, redirects, errors)
- ✅ Technical SEO (title, meta description, canonical tags, noindex)
- ✅ Conversion elements:
  - Phone numbers (tel: links)
  - Email addresses (mailto: links)
  - CTA buttons (Call, Email, Book, Schedule, etc.)
  - `openContactSheet()` function calls
  - Contact forms
- ✅ Schema markup (JSON-LD)
- ✅ Conversion score (0-100)

**Output:** `scripts/gsc_conversion_audit_report.csv`

**Usage:**
```bash
php scripts/qa_gsc_conversion_audit.php https://nrlc.ai /path/to/Pages.csv
```

### 2. `scripts/analyze_conversion_audit.php`
**Purpose:** Analyzes audit results and generates actionable insights

**What it provides:**
- Overall statistics (success rate, conversion element coverage)
- Top priority pages (high impressions, low conversion score)
- Pages missing specific conversion elements
- High-value pages needing attention

**Usage:**
```bash
php scripts/analyze_conversion_audit.php
```

## Expected Conversion Elements

### Phone Numbers
- `+12135628438`
- `+1-213-562-8438`
- `213-562-8438`

### Email Addresses
- `hirejoelm@gmail.com`
- `contact@neuralcommandllc.com`

### CTA Keywords
- Call, Email, Book, Schedule, Contact, Request, Consultation, Demo, Evaluation

## Conversion Score Calculation

**Total: 100 points**

- **Conversion Elements (50 points)**
  - Phone number: 15 points
  - Email address: 15 points
  - CTA button: 20 points

- **Technical SEO (30 points)**
  - Title tag (>10 chars): 5 points
  - Meta description (>50 chars): 5 points
  - Canonical tag: 10 points
  - No noindex: 10 points

- **Schema Markup (20 points)**
  - JSON-LD schema present: 20 points

## Key Metrics to Monitor

1. **Conversion Element Coverage**
   - % of pages with phone numbers
   - % of pages with email addresses
   - % of pages with CTAs

2. **High-Value Pages**
   - Pages with >100 impressions but missing conversion elements
   - Pages with >50 impressions and conversion score <70

3. **Technical Issues**
   - Pages with noindex tags
   - Pages missing canonical tags
   - Pages missing schema markup

## Action Items

After running the audit:

1. **Review Top Priority Pages**
   - Focus on pages with highest impressions and lowest conversion scores
   - Add missing conversion elements (phone, email, CTA)

2. **Fix Technical Issues**
   - Remove noindex tags from indexable pages
   - Add canonical tags where missing
   - Add schema markup to service pages

3. **Optimize High-Value Pages**
   - Ensure all pages with >100 impressions have:
     - Phone number with tel: link
     - Email with mailto: link
     - Prominent CTA button
     - Schema markup

4. **Monitor Conversion Rates**
   - Track CTR improvements after fixes
   - Monitor conversion score improvements
   - A/B test CTA placements

## Next Steps

1. Wait for audit to complete (testing 712 pages)
2. Run analysis script: `php scripts/analyze_conversion_audit.php`
3. Review top priority pages from report
4. Implement fixes for high-value pages first
5. Re-run audit to verify improvements

