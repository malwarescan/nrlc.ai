# SERP Intelligence (GSC → Fix Plan)

## Inputs (put beside `main.py` or pass `--data-dir`)
- `Queries.csv` — columns: Query, Page, Clicks, Impressions, CTR, Position
- `Pages.csv` — columns: Page, Clicks, Impressions, CTR, Position
- `Countries.csv` — columns: Country, Query, Page, Clicks, Impressions, CTR, Position

## What it does
- Filters to **top-10 avg position** queries.
- Maps **query → page → country intent**.
- Fetches each page and audits: `<title>`, meta description, H1/H2, word count, canonical, robots noindex, present JSON-LD types.
- Builds **semantic predictions** from co-occurring queries per URL.
- Outputs:
  - `out/serp_intel_audit.csv`
  - `out/recommendations.md`
  - `out/url_cards/*.md`
  - `out/schema_suggestions.ndjson`
  - `out/summary.json`

## Run
```bash
pip install -e .
python3 main.py --data-dir . --out-dir out
```

## Notes
- Title target length: 40–65 chars. Meta description: 120–160. Thin content threshold: 800 words (tune in code).
- Schema suggestions are starter scaffolds; fill real values (offers, address, dates, images).
- Respect robots/terms of your site; this only fetches your pages.


