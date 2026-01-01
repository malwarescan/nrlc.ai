# Operational Guides Index

This directory contains copy-ready operational material for GBP-aligned service pages.

---

## Quick Reference

### 1. Service Page Classifier Audit
**File:** `SERVICE_PAGE_CLASSIFIER_AUDIT.md`  
**Purpose:** Line-by-line checklist for auditing service pages  
**When to use:** Before launching any service page, during reviews  
**Script:** `scripts/audit_service_page.php` (automated audit)

### 2. Post-GBP Stabilization Checklist
**File:** `POST_GBP_STABILIZATION_CHECKLIST.md`  
**Purpose:** 30-day do/don't list after GBP alignment  
**When to use:** Immediately after GBP implementation, follow for 30 days  
**Schedule:** Week-by-week action items

### 3. Exact Signals to Watch in GSC
**File:** `EXACT_SIGNALS_TO_WATCH_IN_GSC.md`  
**Purpose:** Specific metrics to monitor in Google Search Console  
**When to use:** Daily (first week), then weekly for 30 days  
**Tool:** Google Search Console only

---

## Usage Workflow

### Before Launch (Service Pages)
1. Build/update service page
2. Run `php scripts/audit_service_page.php <url>`
3. Fix any failures
4. Re-run audit until all checks pass
5. Launch

### After GBP Implementation
1. Follow `POST_GBP_STABILIZATION_CHECKLIST.md` (30 days)
2. Monitor `EXACT_SIGNALS_TO_WATCH_IN_GSC.md` (daily/weekly)
3. Document findings weekly
4. After 30 days, evaluate and decide next steps

---

## Related Documentation

- `GBP_IDENTITY_IMPLEMENTATION.md` - Complete GBP implementation details
- `GBP_CONFIG_UPDATE_REQUIRED.md` - Quick guide to update GBP config
- `SEARCH_CONSOLE_QA_README.md` - QA script documentation

---

## Key Principles

1. **GBP is the canonical identity authority** - All identity signals must match exactly
2. **Stability is the ranking catalyst** - No changes during 30-day stabilization
3. **Classification before optimization** - Service pages must be classifiable in under 3 seconds
4. **GSC signals are the truth** - Ignore third-party tools during stabilization window

---

**All guides are copy-ready operational material. No fluff, no theory.**


