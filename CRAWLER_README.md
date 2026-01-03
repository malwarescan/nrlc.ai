# NRLC Full Crawl + Line-by-Line Structure Auditor

Crawls all URLs from `docs/AI_SERVICES_LINKS.md`, saves raw HTML, generates line-numbered HTML, extracts structure data, and produces comprehensive reports.

## Setup

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Install Playwright browser:**
   ```bash
   npm run install-browser
   ```
   Or:
   ```bash
   npx playwright install --with-deps chromium
   ```

## Usage

Run the crawler:
```bash
npm run crawl
```

Or directly:
```bash
node crawl.js
```

## Input

- **Input file:** `docs/AI_SERVICES_LINKS.md`
- Extracts all URLs from the markdown file using regex pattern matching

## Output

All output is saved to `crawl-out/` directory:

### Directory Structure

```
crawl-out/
├── raw-html/           # Raw HTML for each page
│   └── <slug>.html
├── line-html/          # Line-numbered HTML (for line reference)
│   └── <slug>.lines.html
├── page-json/          # Structured data per page
│   └── <slug>.json
├── REPORT.md           # Human-readable report
└── REPORT.json         # Machine-readable rollup
```

### Per-Page JSON Structure

Each page JSON includes:
- `url` - Original URL
- `slug` - Filename-safe slug
- `status` - HTTP status code
- `finalUrl` - Final URL after redirects
- `title` - Page title
- `canonical` - Canonical URL
- `meta` - Meta tags (description, robots, OG tags)
- `headings` - Heading outline (H1-H4)
- `jsonld` - All JSON-LD blocks
- `internalLinks` - Internal links (same host)
- `textLength` - Character count
- `wordCount` - Word count
- `structureMarkdown` - Formatted structure summary
- `issues` - Detected issues array
- `timingsMs` - Crawl time in milliseconds

### Issue Detection

The crawler detects:
- HTTP status errors (non-200)
- Missing `<title>`
- Missing meta description
- Missing H1 or multiple H1s
- Missing canonical link
- Missing JSON-LD
- Thin content (textLength < 1200)

## Report Format

**REPORT.md** includes:
1. Summary (total URLs, pages crawled, failures)
2. Issue summary (grouped by issue type)
3. Per-page structure details:
   - Final URL and HTTP status
   - Title and meta tags
   - Canonical URL
   - JSON-LD types present
   - Internal link count
   - Heading outline
   - File references
   - Detected issues

## Notes

- Uses Playwright Chromium (headless) for full browser rendering
- Waits 800ms after DOM load for client-side rendering
- Timeout: 60 seconds per page
- User-Agent: "NRLC-Crawler/1.0 (+structure-audit)"

## Future Enhancements

Possible additions:
- Hreflang cluster validation
- Template vs unique content diffing
- Boilerplate ratio calculation
- Duplicate title/description detection
- Schema validation
- Link structure analysis

