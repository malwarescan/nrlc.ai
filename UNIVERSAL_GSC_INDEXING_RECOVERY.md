### Universal GSC Indexing Recovery — White-Label (PHP 8+)

What this adds:
- Brand config: `config/brand.json`
- GSC importer: `scripts/gsc_import.php` → writes `./data/Table.csv`
- JSON-LD + canonical auto-emitter: `includes/jsonld_auto.php` + `includes/jsonld_bootstrap.php`
- Thin-content helper: `includes/content_expander.php`
- Sitemaps: `scripts/sitemap_build.php`, `scripts/sitemap_news.php`
- Auditor: `scripts/url_audit.php` (writes `./data/url_audit_output.csv`)
- Makefile targets: `gsc:import`, `robots:write`, `schema:selftest`, `sitemap:update`, `sitemap:news`, `ping:search`, `audit:url`

One-liner (swap your origin):
```bash
make gsc:import BASE=https://example.com ISSUE="Discovered - currently not indexed" \
&& make robots:write BASE=https://example.com \
&& make schema:selftest BASE=https://example.com \
&& make sitemap:update BASE=https://example.com LASTMOD=$(date +%F) \
&& make sitemap:news BASE=https://example.com || true \
&& make ping:search BASE=https://example.com \
&& make audit:url LIMIT=200
```

Template wiring:
- In `<head>`: `<?php require_once __DIR__.'/includes/jsonld_bootstrap.php'; ?>`
- Wrap body when rendering: `<?= maybe_expand_content($htmlBody); ?>`

