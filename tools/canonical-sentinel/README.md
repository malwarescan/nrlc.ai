# Canonical Sentinel

**PHP-native canonical mismatch scanner for SEO infrastructure auditing.**

Canonical Sentinel crawls websites, extracts canonical signals, detects mismatches, scores integrity, and emits fix directives. Outputs NDJSON for Crouton/Graph processing and predicts Google indexing behavior.

---

## Architecture

```
Crawl → Extract → Normalize → Analyze → Score → Emit
```

1. **Crawl**: Discovers URLs via sitemap and link following (respects robots.txt)
2. **Extract**: Pulls canonical tags, meta robots, hreflang, internal links
3. **Normalize**: Standardizes URLs before comparison (trailing slash, params, etc.)
4. **Analyze**: Detects 9 mismatch types (self-canonical, redirects, conflicts, etc.)
5. **Score**: Calculates canonical integrity score (0-100) and predicts Google behavior
6. **Emit**: Outputs NDJSON, summary JSON, and plain-English fix directives

---

## Requirements

- PHP 8.0+
- cURL extension
- DOMDocument extension (libxml)
- No Composer dependencies
- No headless browser required

---

## Installation

```bash
cd tools/canonical-sentinel
chmod +x run.php
```

---

## Usage

### Basic Scan

```bash
php run.php --start=https://example.com
```

### Full Options

```bash
php run.php \
  --start=https://example.com \
  --scope=domain \
  --depth=5 \
  --output=./output
```

### Arguments

- `--start=URL` (required): Starting URL to crawl
- `--scope=domain|subdomain|path` (default: `domain`): Crawl scope
- `--depth=N` (default: `5`): Maximum crawl depth
- `--output=DIR` (default: `./output`): Output directory

---

## Output Files

### `canonical_scan.ndjson`

One JSON object per line (NDJSON format):

```json
{
  "url": "https://example.com/page?utm=twitter",
  "final_url": "https://example.com/page/",
  "status": 200,
  "declared_canonical": "https://example.com/page/",
  "canonical_status": 200,
  "redirect_chain": ["301 -> /page/"],
  "mismatch_types": ["PARAMETER_COLLAPSE"],
  "canonical_integrity_score": 55,
  "google_likely_ignores": true,
  "risk_level": "high"
}
```

### `canonical_summary.json`

Aggregate statistics:

```json
{
  "scan_date": "2025-01-15T10:30:00+00:00",
  "start_url": "https://example.com",
  "total_urls": 150,
  "urls_with_mismatches": 42,
  "average_score": 72.5,
  "risk_distribution": {
    "critical": 8,
    "high": 34,
    "low": 108
  },
  "mismatch_types": {
    "SELF_CANONICAL_FAILURE": 12,
    "CANONICAL_REDIRECT": 5,
    "PARAMETER_COLLAPSE": 18
  }
}
```

### `canonical_directives.txt`

Plain-English fix instructions:

```
================================================================================
URL: https://example.com/blog/post?utm=twitter
Score: 55/100
Risk: high
--------------------------------------------------------------------------------
- Query parameters in URL (utm) but missing from canonical. Either strip params from URL or include in canonical.
- Internal links point to non-canonical version of this page. Update all internal links to use canonical URL: https://example.com/blog/post/
```

---

## Mismatch Types

| Type | Description |
|------|-------------|
| `SELF_CANONICAL_FAILURE` | URL doesn't self-reference as canonical |
| `CANONICAL_REDIRECT` | Canonical URL redirects (should be direct) |
| `CANONICAL_NON_200` | Canonical URL doesn't return 200 OK |
| `HEADER_HTML_SPLIT` | HTTP Link header and HTML canonical differ |
| `SITEMAP_CONFLICT` | URL in sitemap but canonical points elsewhere |
| `INTERNAL_LINK_OVERRIDE` | Internal links point to non-canonical version |
| `HREFLANG_CONFLICT` | Hreflang targets don't match canonical structure |
| `PARAMETER_COLLAPSE` | Query params in URL but missing from canonical |
| `PROTOCOL_HOST_DRIFT` | Canonical uses different protocol or host |

---

## Scoring

**Canonical Integrity Score (0-100)**

- **+30**: Self-canonical correct
- **+20**: Canonical returns 200
- **+15**: Redirect consistency
- **+15**: Internal link alignment
- **+10**: Sitemap alignment
- **+10**: Hreflang alignment

### Thresholds

- **Score < 70**: Indexing risk (`google_likely_ignores: true`)
- **Score < 40**: Canonical failure (critical risk)

---

## Configuration

Edit `config.php` to customize:

- Crawl settings (depth, timeout, user agent)
- URL normalization rules (tracking params, trailing slash)
- Scoring weights
- Risk thresholds
- Output file names

---

## Integration

### Crouton/Graph Processing

NDJSON output is ready for graph ingestion:

```bash
php run.php --start=https://example.com
cat output/canonical_scan.ndjson | your-graph-processor
```

### CI/CD Pipeline

```yaml
- name: Scan Canonicals
  run: |
    php tools/canonical-sentinel/run.php \
      --start=https://example.com \
      --depth=3 \
      --output=./canonical-scan
  continue-on-error: true
```

### Precog Confidence Weighting

Use `canonical_integrity_score` as a confidence signal:

- High score (80+): High confidence in canonical correctness
- Medium score (50-79): Moderate confidence, review recommended
- Low score (<50): Low confidence, likely indexing issues

---

## How It Works

### URL Normalization

Before any comparison, URLs are normalized:

- Lowercase scheme + host
- Remove default ports (80, 443)
- Normalize trailing slash (configurable)
- Sort query parameters alphabetically
- Strip tracking params (utm_*, fbclid, gclid, etc.)
- Decode URL entities

**This ensures accurate canonical matching.**

### Robots.txt Respect

- Parses `/robots.txt` automatically
- Respects `User-agent: *` and `User-agent: CanonicalSentinel`
- Skips disallowed paths during crawl
- Configurable via `respect_robots` in config

### Sitemap Discovery

- Auto-discovers `/sitemap.xml` and `/sitemap_index.xml`
- Follows sitemap index chains
- Cross-references sitemap URLs with crawled URLs
- Detects sitemap/canonical conflicts

---

## Limitations

- **No JavaScript execution**: Only server-rendered HTML is analyzed
- **Rate limiting**: Respects `crawl_delay` but doesn't auto-throttle based on server response
- **Large sites**: Default `max_urls` is 1000; increase in config for larger sites
- **Authentication**: Doesn't handle authenticated pages (login required)

---

## Troubleshooting

### "Cannot write to output file"

Ensure output directory is writable:

```bash
mkdir -p output
chmod 755 output
```

### "cURL timeout"

Increase timeout in `config.php`:

```php
'crawl' => [
    'timeout' => 60, // Increase from 30
],
```

### "Memory limit exceeded"

Reduce `max_urls` in config or increase PHP memory limit:

```bash
php -d memory_limit=512M run.php --start=https://example.com
```

---

## License

Part of NRLC.ai tooling suite. Internal use.

---

## Support

For issues or feature requests, contact the NRLC.ai development team.

