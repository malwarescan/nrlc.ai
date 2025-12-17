# AI Visibility Landing Page System

## Overview

Complete system for industry-specific AI visibility landing pages. Controls how AI systems describe, recommend, and reference businesses across 10 high-trust industries.

## Structure

- **Industry Data:** `/lib/ai_visibility_industries.php` - All industry variables in one place
- **Hub Page:** `/pages/ai-visibility/index.php` - Lists all available industries
- **Template:** `/pages/ai-visibility/industry.php` - Reusable template for all industries
- **Router:** Handles `/ai-visibility/[industry]/` URLs

## Available Industries

All 10 industries are implemented and ready:

1. **Immigration Services** - `/ai-visibility/immigration/`
2. **Financial Advisors** - `/ai-visibility/financial-advisor/`
3. **High-End Contractors** - `/ai-visibility/contractor/`
4. **Veterinary Clinics** - `/ai-visibility/veterinary/`
5. **Senior Care / Assisted Living** - `/ai-visibility/senior-care/`
6. **Private Schools / Tutoring** - `/ai-visibility/private-school/`
7. **Auto Repair / Specialty Mechanics** - `/ai-visibility/auto-repair/`
8. **Funeral & Cremation Services** - `/ai-visibility/funeral/`
9. **Real Estate Agents** - `/ai-visibility/real-estate/`
10. **Private Investigators** - `/ai-visibility/private-investigator/`

## Page Structure

Each landing page includes:

1. **Hero Section** - Industry-specific headline and subheadline
2. **Section 1** - "Your Customers Are Asking AI First" with common AI prompts
3. **Section 2** - "SEO Gets You Ranked. AI Decides Who Gets Trusted."
4. **Section 3** - "What We Do (In Plain English)"
5. **Section 4** - Industry-Specific AI Trust Signals
6. **Section 5** - "This Is Already Happening"
7. **The Offer** - AI Visibility & Trust Audit
8. **FAQ Section** - Industry-specific FAQs matching FAQPage schema

## SEO & Schema

Each page includes:

- **Meta Title:** "AI Visibility for [Industry] | Control How AI Recommends Your Business"
- **Meta Description:** Industry subheadline (exact match)
- **Self-referential canonical**
- **JSON-LD Schema:**
  - WebPage
  - Service
  - FAQPage (matches visible FAQ content exactly)
  - BreadcrumbList
  - Organization

## Adding New Industries

1. Add industry data to `/lib/ai_visibility_industries.php`
2. Follow the existing structure:
   - `name`, `slug`, `core_fear`
   - `common_ai_prompts` (array)
   - `authority_signals` (array)
   - `tone`
   - `headline`, `subheadline`
   - `section_1_title` through `section_5_title`
   - `section_1_content` through `section_5_content`
   - `faqs` (array of question/answer pairs)

3. The template automatically generates the page

## URLs

- **Hub:** `/ai-visibility/`
- **Industry Pages:** `/ai-visibility/[industry-slug]/`

## Local Testing

All pages are available at:
- http://localhost:8000/en-us/ai-visibility/
- http://localhost:8000/en-us/ai-visibility/immigration/
- http://localhost:8000/en-us/ai-visibility/financial-advisor/
- etc.

## Notes

- All content is industry-specific and pulled from the data file
- Schema matches visible content exactly
- No JS-only schema (all in raw HTML)
- Mobile-first design with proper spacing
- CTAs link to `/api/book/` for booking

