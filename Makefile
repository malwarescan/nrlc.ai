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

.PHONY: build matrix careers careers_with_service news ping validate content-check csv-fix-smoke contracts content-gate news-fresh sitemap-smoke sitemap-build sitemap-validate sitemap-ping sitemap-full meta-test meta-validate

