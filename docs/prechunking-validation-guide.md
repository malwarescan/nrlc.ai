# Prechunking Content Validation Guide

## Overview

The NRLC Prechunking System enforces content structure for AI retrieval and citation eligibility. All content must pass prechunking validation before publishing.

## What is Prechunking?

Prechunking is the discipline of structuring content **before writing** so that every section is:
- **Atomic** - Self-contained and independent
- **Retrievable** - Can be extracted and understood alone
- **Citable** - Safe to quote verbatim without clarification

## Core Rules

1. **Question Inventory First** - Enumerate exact questions before writing
2. **Atomicity** - Each chunk answers exactly ONE question
3. **Query-Shaped Headers** - Headers must resemble search queries
4. **Chunk Size** - 40-120 words ideal, 150 words maximum
5. **No Narrative Glue** - Eliminate transitions and essay-style flow
6. **Citation Test** - Every chunk must be quotable verbatim

## Validation

### Using the CLI Validator

```bash
# Validate a single file
php scripts/validate_prechunking.php pages/services/index.php

# Validate all files in a directory
php scripts/validate_prechunking.php pages/

# Validate all pages (default)
php scripts/validate_prechunking.php
```

### Using the PHP Library

```php
require_once __DIR__ . '/lib/prechunking_validator.php';

$validator = new PrechunkingValidator();
$result = $validator->validate($content, $filePath);

if (!$result['valid']) {
  // Block publishing
  foreach ($result['errors'] as $error) {
    echo "ERROR: {$error}\n";
  }
}
```

## Validation Checklist

Before publishing, content MUST pass:

- [ ] Headers are query-shaped (not abstract/clever)
- [ ] Each chunk is atomic (no references to other sections)
- [ ] Chunk sizes are 40-120 words (150 max)
- [ ] No narrative glue phrases ("as mentioned earlier", "in conclusion")
- [ ] No promotional language in citation-eligible text
- [ ] All chunks can be quoted verbatim without clarification

## Common Failures

### ❌ Abstract Headers
```
Bad: "Understanding Prechunking"
Good: "What is prechunking in SEO"
```

### ❌ Non-Atomic Chunks
```
Bad: "As mentioned earlier, prechunking improves retrieval."
Good: "Prechunking improves AI retrieval by structuring content as atomic chunks."
```

### ❌ Overlong Chunks
```
Bad: 200+ word paragraphs
Good: 40-120 word focused chunks
```

### ❌ Narrative Glue
```
Bad: "In conclusion, prechunking is essential."
Good: "Prechunking is essential for AI retrieval."
```

## Integration

The prechunking validator can be integrated into:
- **CI/CD pipelines** - Block deployment on validation failure
- **CMS workflows** - Require validation before publishing
- **Content review** - Automated QA before manual review

## Related Documentation

- **Primary Directive**: `SUDO_META_DIRECTIVE_PRECHUNKING.md`
- **QA Scorecard**: `docs/prechunking-qa-scorecard.md`
- **QA Enforcement**: `docs/sudo-meta-directive-prechunking-qa-enforcement.md`

## Status

✅ **ACTIVE** - Prechunking validation is enforced for all content.

