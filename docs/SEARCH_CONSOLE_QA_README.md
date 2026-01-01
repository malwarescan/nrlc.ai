# Search Console URLs - Comprehensive QA

## Overview

This QA script tests all URLs from Search Console performance data against every quality assurance check we've implemented.

## Script Location

`scripts/qa_all_search_console_urls.php`

## What It Tests

For each URL, the script validates:

### Critical Checks (Failures)
1. **HTTP Status** - Must be 200
2. **Canonical Tag** - Must be present, single, and match URL
3. **Title** - Must be 30-60 characters
4. **Description** - Must be 120-160 characters  
5. **H1** - Must be present and unique (only one)

### Warning Checks (Non-blocking)
6. **JSON-LD Schema** - Should be present
7. **Viewport** - Should be present for mobile
8. **HTML Lang** - Should be declared
9. **Charset** - Should be UTF-8
10. **Footer** - Should be detected

## Input

Reads URLs from:
`/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2026-01-01/Pages.csv`

## Output

Results saved to:
`docs/search_console_qa_results.csv`

CSV columns:
- URL
- HTTP Status
- Load Time
- Canonical Found
- Canonical Matches
- Title Found
- Title Length
- Title Valid
- Description Found
- Description Length
- Description Valid
- H1 Found
- H1 Count
- Schema Found
- Schema Count
- Schema Types
- Viewport
- Lang
- Charset
- Footer
- Passed (PASS/FAIL)
- Issues (semicolon-separated)
- Warnings (semicolon-separated)

## Running the Script

```bash
# Run in foreground (will take 10-15 minutes for 1000 URLs)
php scripts/qa_all_search_console_urls.php

# Run in background
nohup php scripts/qa_all_search_console_urls.php > /tmp/qa_output.log 2>&1 &

# Monitor progress
tail -f /tmp/qa_output.log

# Check results
cat docs/search_console_qa_results.csv
```

## Analyzing Results

### Quick Summary
```bash
# Count passed/failed
grep -c ",PASS," docs/search_console_qa_results.csv
grep -c ",FAIL," docs/search_console_qa_results.csv

# Top issues
grep ",FAIL," docs/search_console_qa_results.csv | cut -d',' -f22 | sort | uniq -c | sort -rn
```

### Common Issues to Fix

1. **Title too long** - Reduce to 60 chars max
2. **Description too long** - Reduce to 160 chars max
3. **Canonical mismatch** - Fix canonical to match actual URL
4. **Missing H1** - Add H1 tag
5. **Multiple H1s** - Ensure only one H1 per page

## Notes

- Script processes ~100 URLs per minute
- Total runtime: ~10-15 minutes for 1000 URLs
- All URLs are tested against production (https://nrlc.ai)
- Results are cumulative - re-running will overwrite previous results

