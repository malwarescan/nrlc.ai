# GSC-Derived URL Crawl & Truth Enforcement Kernel

## Overview

This script implements a Google-grade crawler, auditor, and gatekeeper that validates every URL that has appeared in Google Search Console. It performs triple-pass validation, indexability checks, intent classification, structured data verification, and comprehensive scoring.

## Requirements

- PHP 7.4+ with cURL extension
- Access to the GSC Pages.csv export file
- Network access to crawl URLs

## Usage

### Basic Usage

```bash
php scripts/gsc_crawl_validator.php [GSC_PAGES_CSV] [OUTPUT_CSV] [MAX_URLS]
```

### Parameters

- `GSC_PAGES_CSV` (optional): Path to GSC Pages.csv file. Defaults to Downloads folder.
- `OUTPUT_CSV` (optional): Path for output CSV. Defaults to `gsc_validation_report.csv` in project root.
- `MAX_URLS` (optional): Limit number of URLs to process (useful for testing).

### Examples

```bash
# Process all URLs from default location
php scripts/gsc_crawl_validator.php

# Process with custom paths
php scripts/gsc_crawl_validator.php "/path/to/Pages.csv" "/path/to/output.csv"

# Test with first 10 URLs
php scripts/gsc_crawl_validator.php "/path/to/Pages.csv" "/path/to/output.csv" 10
```

## Validation Process

### STEP 1: URL Normalization
- Normalizes protocol (https preferred)
- Resolves www vs non-www
- Strips tracking parameters
- Records original GSC URL separately

### STEP 2: Triple-Pass Crawl

#### PASS A — Raw HTML Fetch (NO JS)
- Fetches HTML with JavaScript disabled
- Captures:
  - HTTP status code
  - HTML byte size
  - Visible text length
  - Presence of title, meta description, canonical
  - JSON-LD presence in raw HTML
- Flags: `THIN_OR_JS_DEPENDENT` if content is minimal

#### PASS B — Rendered Fetch (Googlebot Mobile Parity)
- Renders with mobile viewport simulation
- Captures:
  - Final DOM content
  - JS errors
  - Network failures
  - Render completeness
- Flags: `JS_ONLY_CONTENT`, `RENDER_FAILURE`

#### PASS C — Link Graph Validation
- Extracts all internal links
- Verifies each target returns 200
- Detects:
  - Links to 404
  - Links to redirected URLs
  - Orphaned URLs

### STEP 3: Indexability & Trust Checks
- Checks robots.txt
- Checks meta robots
- Validates canonical (must be self-referential)
- Checks redirect chains (>1 hop = FLAG, redirect→404 = CRITICAL FAIL)
- Flags: `GSC_GHOST_URL`, `NOINDEX`, `CANONICAL_MISMATCH`, `REDIRECT_CHAIN`, `REDIRECT_TO_404`

### STEP 4: Intent & Service Alignment
- Classifies page type: service / product / resource / hub / unknown
- Extracts primary service from visible content
- Determines intent: transactional / commercial / informational
- Validates first viewport contains service + outcome statement

### STEP 5: Structured Data Verification
- Parses JSON-LD from raw HTML
- Validates against visible content
- Required schemas for service pages:
  - WebPage
  - Service
  - Organization
  - BreadcrumbList
- Flags missing or JS-injected-only schema

### STEP 6: Page Scoring (0-100)

| Category | Points | Criteria |
|----------|--------|----------|
| Load & render integrity | 30 | HTTP 200 (10), HTML size >1KB (5), Text >500 chars (5), Render success (5), No JS-only content (5) |
| Indexability & canonicals | 15 | Indexable (10), Canonical OK (5) |
| Intent clarity | 20 | Intent OK (15), Has service statement (3), Has outcome (2) |
| Service depth & clarity | 15 | Has primary service (10), Service name >20 chars (5) |
| Structured data correctness | 10 | Schema OK (10) |
| Internal linking | 10 | Links OK (5), >5 internal links (5) |

### Scoring Thresholds

- **<70**: BLOCK INDEXING
- **<85**: BLOCK DEPLOY / PROMOTION
- **85+**: ELIGIBLE
- **95+**: PRIORITY PROMOTION

### STEP 7: Output CSV

The script generates a CSV with the following columns:

- `url`: Normalized URL
- `gsc_impressions`: Impressions from GSC
- `gsc_clicks`: Clicks from GSC
- `http_status`: HTTP status code
- `render_success`: yes/no
- `js_only_content`: yes/no
- `gsc_ghost_url`: yes/no (URL in GSC but returns non-200)
- `indexable`: yes/no
- `canonical_ok`: yes/no
- `intent`: transactional/commercial/informational
- `primary_service`: Extracted service name
- `schema_ok`: yes/no
- `internal_links_ok`: yes/no
- `score`: 0-100 score
- `required_action`: block | fix | promote

### STEP 8: Hard Guardrails

The script will **FAIL** (exit code 1) if:

- ANY GSC URL scores <85
- ANY GSC URL returns 404 or redirect→404
- ANY service page lacks Service schema
- ANY GSC URL is orphaned (no internal inlinks)
- ANY GSC URL does not load cleanly

**NO EXCEPTIONS. NO MANUAL OVERRIDES. NO "KNOWN ISSUES" LISTS.**

## Rate Limiting

The script includes a 0.5 second delay between requests to avoid overwhelming the server. For large crawls, consider running during off-peak hours.

## Error Handling

- Network errors are captured and reported
- Invalid URLs are skipped with warnings
- All failures are logged to the output CSV
- Exit code 1 indicates validation failures

## Example Output

```
SUDO META DIRECTIVE — GSC CRAWL & VALIDATION KERNEL
==================================================

Reading GSC URLs...
[1] Processing: https://nrlc.ai/en-us/products/applicants-io/
[2] Processing: https://nrlc.ai/en-us/products/
...

VALIDATION RESULTS:
==================
Total URLs processed: 713
Failures detected: 45

CRITICAL FAILURES:
  - https://nrlc.ai/en-us/services/llm-optimization/new-york/ (Score: 58, HTTP: 200)
    Issues: CANONICAL_MISMATCH
  ...

Output written to: gsc_validation_report.csv

VALIDATION COMPLETE.
```

## Philosophy

> Google has already told us what URLs it cares about.
> Your job is to make every one of them real, loadable, understandable, and trustworthy.
>
> If a URL exists in GSC, it must exist in reality.
> If it does not, it is a systemic failure — not a content issue.

## Notes

- The script does not infer. It verifies.
- It does not trust sitemaps, routers, or CMS state. It trusts only observed reality.
- Every URL that has EVER appeared in GSC must be crawled, rendered, validated, and scored.
- No URL is ignored. No assumptions. No sampling.

