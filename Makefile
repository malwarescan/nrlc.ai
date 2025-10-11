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
	@$(PHP) scripts/ping_sitemaps.php https://nrlc.ai/sitemaps/sitemap-index.xml.gz

validate:
	@$(PHP) scripts/validate_sitemaps.php

.PHONY: build matrix careers careers_with_service news ping validate

