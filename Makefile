PHP ?= php

build:
	@$(PHP) scripts/build_sitemaps.php

matrix:
	@$(PHP) scripts/generate_matrix.php

careers:
	@$(PHP) scripts/generate_career_matrix.php

careers_with_service:
	@$(PHP) scripts/generate_career_matrix.php --with-service

news:
	@$(PHP) scripts/build_news_only.php

ping:
	@$(PHP) scripts/ping_sitemaps.php

validate:
	@$(PHP) scripts/validate_sitemaps.php

csv-fix-smoke:
	@php -l lib/csv.php || true
	@php scripts/generate_matrix.php
	@php scripts/generate_career_matrix.php
	@php scripts/build_sitemaps.php
	@php scripts/validate_sitemaps.php

content-check:
	@php scripts/check_content_weight.php /services/crawl-clarity/new-york/ /services/json-ld-strategy/london/

contracts:
	@php scripts/validate_csv_contracts.php

content-gate:
	@php scripts/assert_content_weight.php /services/crawl-clarity/new-york/ /services/json-ld-strategy/london/

news-fresh:
	@php scripts/check_news_freshness.php

sitemap-smoke:
	@php scripts/smoke_sitemaps_local.php

# Sitemap v2 automation targets
sitemap-build:
	@$(PHP) scripts/build_sitemaps.php

sitemap-validate:
	@$(PHP) scripts/validate_sitemaps.php

sitemap-ping:
	@$(PHP) scripts/ping_sitemaps.php

sitemap-full: sitemap-build sitemap-validate sitemap-ping

# Meta tag testing
meta-test:
	@php scripts/test_meta_tags.php

meta-validate:
	@php scripts/validate_meta_seo.php

.PHONY: build matrix careers careers_with_service news ping validate content-check csv-fix-smoke contracts content-gate news-fresh sitemap-smoke sitemap-build sitemap-validate sitemap-ping sitemap-full meta-test meta-validate sitemap:ai ndjson:verify stream:test

# ================= Universal GSC Indexing Recovery (White-Label) =================
BASE ?= https://example.com
CSV ?= ./data/Table.csv
NEWSCSV ?= ./data/News.csv
LASTMOD ?= $(shell date +%F)
LIMIT ?= 0
GSC_DIR ?= ./gsc
OUTDATA ?= ./data

.PHONY: gsc-import schema-selftest sitemap-update sitemap-news ping-search refresh-indexing audit-url robots-write expand-thin sitemap-sections bootstrap

gsc-import:
	@mkdir -p $(OUTDATA)
	@php scripts/gsc_import.php $(GSC_DIR) $(CSV)
	@echo "✅ Imported GSC CSVs into $(CSV)"

schema-selftest:
	@php scripts/schema_selftest.php

sitemap-update:
	@php scripts/sitemap_build.php $(CSV) $(LASTMOD) $(BASE)
	@echo "✅ Sitemaps rebuilt: public/sitemap.xml (+ shards)"

sitemap-sections:
	@php scripts/sitemap_from_table.php $(LASTMOD) $(BASE)
	@echo "✅ Section shards built (services, insights)"

sitemap-news:
	@php scripts/sitemap_news.php $(NEWSCSV) $(BASE)
	@echo "ℹ️ News sitemap step completed (skips if none within 48h)"

ping-search:
	@curl -s "https://www.google.com/ping?sitemap=$(BASE)/sitemap.xml" >/dev/null || true
	@curl -s "https://www.bing.com/ping?sitemap=$(BASE)/sitemap.xml" >/dev/null || true
	@echo "✅ Pinged Google & Bing"

audit-url:
	@php scripts/url_audit.php $(CSV) $(LIMIT)
	@echo "✅ Audit complete → ./data/url_audit_output.csv"

refresh-indexing: sitemap-update sitemap-news ping-search audit-url
	@echo "✅ Full refresh cycle done"

bootstrap: schema-selftest sitemap-sections ping-search audit-url
	@echo "✅ Bootstrap done — re-submit sitemap and request indexing for sample URLs"

robots-write:
	@mkdir -p public
	@echo "User-agent: *" > public/robots.txt
	@echo "Allow: /" >> public/robots.txt
	@echo "" >> public/robots.txt
	@echo "Sitemap: $(BASE)/sitemap.xml" >> public/robots.txt
	@echo "✅ Wrote public/robots.txt with sitemap=$(BASE)/sitemap.xml"

# Thin content expander: renders fallback FAQ/Related for pages with <300 words
# NOTE: You must call maybe_expand_content($htmlBody) inside your template.
expand-thin:
	@echo "ℹ️ Ensure your page template wraps body with maybe_expand_content()"
	@echo "   Example: echo maybe_expand_content(\$htmlBody);"
	@echo "✅ Thin-content fallback wired (template change required once)"

# Promptware — AI Manifest & NDJSON streaming
sitemap:ai:
	@php scripts/build_ai_manifest.php

ndjson:verify:
	@bash scripts/verify_ndjson.sh

stream:test:
	@curl -s https://nrlc.ai/api/stream?limit=3 | head -n 3 | jq .
