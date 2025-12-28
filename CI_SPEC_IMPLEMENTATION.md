# CI Spec + Generator Refactor + City Eligibility Validator

**Implementation Date:** December 28, 2025  
**Status:** ✅ Complete

## Overview

This implementation provides:
1. **Formal CI Spec** - Deployment gate that blocks deploys on canonical/sitemap/redirect/locale failures
2. **Canonical Registry Refactor** - Sitemap = single source of truth for canonical URLs
3. **City Eligibility Validator** - Prevents locale/city mismatches at build time

## Architecture

### Single Source of Truth Flow

```
cities.csv → city_locale_rules.json → build_sitemaps.php → canonical_registry.json
                                                                    ↓
                                                          Page Generator (future)
                                                                    ↓
                                                          Redirect Middleware (future)
```

### Hard Invariants (CI Blocks on Failure)

1. **A. Canonical-in-sitemap** - Every canonical URL must appear in exactly one sitemap
2. **B. Non-canonical exclusion** - No non-canonical URL may appear in any sitemap
3. **C. Redirect correctness** - Every non-canonical URL must 301 to its canonical
4. **D. Canonical target resolvability** - Canonical URL must return 200 OK
5. **E. Locale/city alignment** - URL locale must match city's country mapping
6. **F. Canonical stability** - Canonical must not point to non-existent URLs

## Files Created

### CI/CD Files

1. **`.github/workflows/qa-indexing-gate.yml`**
   - GitHub Actions workflow
   - Runs on PR and push to main/master
   - Executes all validation steps
   - Blocks deployment on critical failures

2. **`scripts/qa_enforce_gate.php`**
   - Parses QA results CSV
   - Enforces zero critical failures
   - Exits with code 1 on failure (blocks CI)

### Generator Scripts

3. **`scripts/generate_city_locale_rules.php`**
   - Reads `data/cities.csv`
   - Generates `data/city_locale_rules.json`
   - Maps cities to canonical locales
   - Supports overrides via `data/city_locale_overrides.json`

4. **`scripts/generate_canonical_registry.php`**
   - Reads sitemap files
   - Generates `data/canonical_registry.json`
   - Single source of truth for all canonical URLs
   - Includes alternates (non-canonical versions)

5. **`scripts/validate_canonical_registry.php`**
   - Validates all hard invariants
   - Checks canonical-in-sitemap
   - Checks non-canonical exclusion
   - Checks locale/city alignment

### Configuration Files

6. **`data/city_locale_rules.json`** (generated)
   - Maps each city to canonical locale
   - Lists forbidden locales
   - Example:
   ```json
   {
     "norwich": {
       "country": "GB",
       "canonical_locale": "en-gb",
       "forbidden_locales": ["en-us", "fr-fr", "es-es", "de-de", "ko-kr"]
     }
   }
   ```

7. **`data/city_locale_overrides.json`** (manual)
   - Override file for special cases
   - Only use if city legitimately needs multiple locales
   - Example: Montreal with en-ca and fr-ca

8. **`data/canonical_registry.json`** (generated)
   - Complete registry of all canonical URLs
   - Includes metadata: locale, country, city, service, alternates, sitemap
   - Example:
   ```json
   {
     "https://nrlc.ai/en-gb/services/local-seo-ai/norwich/": {
       "locale": "en-gb",
       "country": "GB",
       "city": "norwich",
       "service_slug": "local-seo-ai",
       "alternates": [
         "https://nrlc.ai/en-us/services/local-seo-ai/norwich/"
       ],
       "sitemap": "services-1.xml.gz"
     }
   }
   ```

### Updated Files

9. **`scripts/build_sitemaps.php`**
   - Now exports canonical URLs to `data/canonical_urls_from_sitemap.json`
   - Ensures sitemap and registry stay in sync

10. **`qa_verify_all_urls.php`**
    - Updated to support CLI arguments
    - Can run in `--mode=sitemap` or `--mode=pages`
    - Supports `--base` URL for CI environments
    - Adds `Severity` column (critical/warning/info)

## Usage

### Local Development

```bash
# 1. Generate city locale rules
php scripts/generate_city_locale_rules.php

# 2. Build sitemaps
php scripts/build_sitemaps.php

# 3. Generate canonical registry
php scripts/generate_canonical_registry.php

# 4. Validate registry
php scripts/validate_canonical_registry.php

# 5. Run QA verification
php qa_verify_all_urls.php --mode=sitemap --base=http://localhost:8000

# 6. Enforce gate
php scripts/qa_enforce_gate.php qa_url_verification_results.csv
```

### CI/CD (GitHub Actions)

The workflow automatically:
1. Generates city locale rules
2. Builds sitemaps
3. Generates canonical registry
4. Validates registry
5. Starts local server
6. Runs QA verification
7. Enforces zero critical failures
8. Uploads artifacts

## City Locale Mapping Rules

### Default Mappings

- **GB** → `en-gb`
- **US** → `en-us`
- **CA** → `en-us` (default, can override)
- **AU** → `en-us` (default, can override)
- **Others** → Must be explicitly defined

### Enforcement

- **Unknown city** → Build fails
- **Unknown country mapping** → Build fails
- **City locale uniqueness** → Each city has exactly one canonical locale
- **Explicit overrides only** → Multi-locale cities must be allowlisted

## How This Prevents Canonical Collapse

### Before (Problem)
1. Google chose `en-gb` canonical for `/en-us/services/local-seo-ai/norwich/`
2. `en-gb` URL was not in sitemap
3. `en-gb` URL was not internally linked
4. Result: Both URLs became "unknown to Google"

### After (Solution)
1. **City locale rules** ensure Norwich → `en-gb` only
2. **Sitemap generator** only includes `en-gb` for UK cities
3. **Canonical registry** tracks all canonical URLs
4. **CI gate** blocks deploy if canonical not in sitemap
5. **Internal linking** (future) ensures discoverability

## Next Steps (Future Refactor)

### Phase 1: Registry Consumption (Not Yet Implemented)

1. **Page Generator Refactor**
   - Read from `canonical_registry.json` instead of raw loops
   - Only generate pages listed in registry
   - Hard stop if page not in registry

2. **Redirect Middleware Refactor**
   - Consult `canonical_registry.json` for redirects
   - 301 non-canonical to canonical if exists in registry
   - 404 if canonical not in registry (prevents ghost alternates)

### Phase 2: Internal Linking (Not Yet Implemented)

1. **Locale Hub Pages**
   - Create hub pages that link to canonical pages
   - Example: `/en-gb/services/` → links to all UK city pages

2. **CI Check**
   - Each canonical must have at least one inbound link
   - Warn initially, hard-fail later

## Testing

### Run Full Validation

```bash
# Complete validation pipeline
php scripts/generate_city_locale_rules.php && \
php scripts/build_sitemaps.php && \
php scripts/generate_canonical_registry.php && \
php scripts/validate_canonical_registry.php && \
php qa_verify_all_urls.php --mode=sitemap && \
php scripts/qa_enforce_gate.php qa_url_verification_results.csv
```

### Expected Output

```
✅ City locale rules generated successfully
✅ Built services sitemap: 11913 URLs
✅ Canonical registry generated successfully
✅ VALIDATION PASSED: All invariants satisfied
✅ QA GATE PASSED: 0 critical failures
```

## Troubleshooting

### City Locale Rules Fail

**Error:** `City 'X' missing canonical_locale`

**Fix:** Check `data/cities.csv` has valid country codes, or add override in `data/city_locale_overrides.json`

### Canonical Registry Validation Fails

**Error:** `INVARIANT A FAIL: Canonical URL not in sitemap`

**Fix:** Ensure `scripts/build_sitemaps.php` runs before `scripts/generate_canonical_registry.php`

### CI Gate Fails

**Error:** `QA GATE FAILED: X critical failures`

**Fix:** Review `qa_url_verification_results.csv` for details. Fix issues and re-run.

## Files Summary

| File | Type | Purpose |
|------|------|---------|
| `.github/workflows/qa-indexing-gate.yml` | CI/CD | GitHub Actions workflow |
| `scripts/qa_enforce_gate.php` | CI/CD | Gate enforcer |
| `scripts/generate_city_locale_rules.php` | Generator | City → locale mapping |
| `scripts/generate_canonical_registry.php` | Generator | Canonical URL registry |
| `scripts/validate_canonical_registry.php` | Validator | Invariant checker |
| `data/city_locale_rules.json` | Data | Generated city rules |
| `data/city_locale_overrides.json` | Config | Manual overrides |
| `data/canonical_registry.json` | Data | Generated registry |
| `qa_verify_all_urls.php` | QA | URL verification (updated) |
| `scripts/build_sitemaps.php` | Generator | Sitemap builder (updated) |

## Status

✅ **CI Spec** - Complete  
✅ **City Eligibility Validator** - Complete  
✅ **Canonical Registry Generator** - Complete  
✅ **Registry Validator** - Complete  
⏳ **Page Generator Refactor** - Future  
⏳ **Redirect Middleware Refactor** - Future  
⏳ **Internal Linking** - Future

