# SUDO-POWERED META DIRECTIVE SYSTEM

## Overview

The SUDO-POWERED META DIRECTIVE is an authoritative metadata enforcement system that ensures every page's title and meta description align with the page's actual content and intent.

## How It Works

### 1. Automatic Intent Analysis
When a page is rendered, the system:
- Analyzes page content (H1, lead paragraphs, H2s)
- Extracts primary keywords
- Determines page type (service, product, article, etc.)
- Identifies user intent (transactional, informational, navigational, local)

### 2. Metadata Generation
Based on intent analysis, the system generates:
- **Optimal Title**: 50-60 characters, includes primary keyword, matches H1 when appropriate
- **Optimal Description**: 150-160 characters, uses lead paragraph when available

### 3. Validation & Enforcement
- Compares existing metadata with generated optimal metadata
- Calculates alignment score (0.0 to 1.0)
- **SUDO Authority**: Overrides metadata if misaligned (< 0.5 score)

## Integration

The system is automatically integrated into `bootstrap/router.php`:
- Runs before `head.php` is included
- Works for all pages that go through `render_page()`
- No manual configuration needed

## Files

- `lib/meta_directive.php` - Core system with intent analysis and metadata generation
- `bootstrap/router.php` - Integration point (load_page_metadata function)

## Key Functions

### `analyze_page_intent($filePath, $slug)`
Extracts:
- H1 heading
- Lead paragraph
- Key phrases from H2s
- Page type
- Primary keyword
- User intent

### `sudo_meta_directive($filePath, $slug, $currentTitle, $currentDesc)`
**SUDO-POWERED**: Returns authoritative [title, description] that matches page intent.

### `validate_metadata_alignment($current, $generated, $intent)`
Returns alignment score (0.0-1.0) indicating how well current metadata matches intent.

## Example

For `pages/services/index.php`:
- **H1**: "The Semantic Infrastructure for the AI Internet"
- **Lead**: "NRLC provides a semantic operating layer..."
- **Generated Title**: "The Semantic Infrastructure for the AI Internet | NRLC.ai" (57 chars)
- **Generated Desc**: Uses lead paragraph (160 chars)

## Benefits

1. **Automatic**: Works for all pages without manual configuration
2. **Intent-Aligned**: Metadata always matches page content
3. **SEO-Optimized**: Titles 50-60 chars, descriptions 150-160 chars
4. **Authoritative**: SUDO authority ensures consistency
5. **Content-Driven**: Uses actual page content (H1, lead) when available

## Related Directives

- **Content Chunking Directive**: `SUDO_META_DIRECTIVE_CONTENT_CHUNKING.md` - UX/readability content structure (chunking for humans)
- **Prechunking Directive**: `SUDO_META_DIRECTIVE_PRECHUNKING.md` - AI retrieval and citation structure (prechunking for machines)
- **Prechunking QA Enforcement**: `docs/sudo-meta-directive-prechunking-qa-enforcement.md` - QA validation rules

**Important Distinction:**
- **Content Chunking** = UX, readability, scannability (presentation)
- **Prechunking** = Retrieval, citation, LLM isolation (extraction)

## Status

✅ **ACTIVE** - System is live and enforcing metadata alignment on all pages.

