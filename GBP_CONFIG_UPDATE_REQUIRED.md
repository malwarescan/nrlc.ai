# ⚠️ ACTION REQUIRED: Update GBP Configuration

**Before deployment, you MUST update `config/gbp.json` with actual Google Business Profile data.**

---

## Quick Steps

1. **Visit your Google Business Profile:**
   - URL: https://g.co/kgs/EP6p5de
   - Or search for your business in Google

2. **Extract the following information EXACTLY as it appears in GBP:**
   - Business name (character-for-character, no abbreviations)
   - Full address (street address, city, state, ZIP code, country)
   - Primary phone number (exact format)
   - Website URL
   - Business category

3. **Update `config/gbp.json`:**
   - Open: `/Users/malware/Desktop/nrlc.ai/config/gbp.json`
   - Replace all `PLEASE_FILL_IN_FROM_GBP` values with actual GBP data
   - Ensure all values match GBP exactly (no variations)

4. **Verify:**
   - Run a test to ensure footer displays correct information
   - Check Organization schema includes correct address and phone
   - Verify all pages reference correct business name

---

## Current Placeholders

The `config/gbp.json` file currently contains:
- `"streetAddress": "PLEASE_FILL_IN_FROM_GBP"`
- `"addressLocality": "PLEASE_FILL_IN_FROM_GBP"`
- `"addressRegion": "PLEASE_FILL_IN_FROM_GBP"`
- `"postalCode": "PLEASE_FILL_IN_FROM_GBP"`
- `"businessCategory": "PLEASE_FILL_IN_FROM_GBP"`

**These MUST be replaced with actual GBP values before deployment.**

---

## What's Already Configured

✅ Business name: "Neural Command LLC"  
✅ Phone: "+1-844-568-4624"  
✅ Website: "https://nrlc.ai"  
✅ Google Business Profile URL: "https://g.co/kgs/EP6p5de"  
✅ SameAs profiles: LinkedIn and GBP URLs  

---

## Why This Matters

Per the SUDO META DIRECTIVE:
- **GBP is the canonical identity authority**
- All site values must match GBP exactly (character-for-character)
- Google uses this to validate business legitimacy
- Mismatches can hurt search rankings and AI visibility

**The website is configured to use GBP data. You just need to provide the actual GBP data.**

---

See `docs/GBP_IDENTITY_IMPLEMENTATION.md` for complete implementation details.

