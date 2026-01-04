Google Search Console Remediation Pack
Generated: 2025-10-15T16:08:26.211728Z

Contents
- .env.suggested
- robots.txt
- sitemap.xml
- schema/SchemaFixes.php
- schema/schema-examples.json
- hreflang/hreflang-template.csv
- patches/https-normalize.md

Quick Start
1) Review .env.suggested and apply values.
2) Place robots.txt at site root; verify at /robots.txt.
3) Deploy sitemap.xml at /sitemap.xml; submit in Search Console.
4) Integrate schema/SchemaFixes.php in JSON-LD emitters (normalize experienceRequirements, educationRequirements; prevent duplicates; enforce https).
5) Complete hreflang-template.csv if multilingual; add <link rel="alternate" hreflang="..."> in templates.
6) Revalidate in Search Console (Structured Data, Sitemaps, Page indexing).

Detected
- Base URL guess: https://nrlc.ai
- Locales: de-de, en-gb, en-us, es-es, fr-fr, ko-kr
- Canonical URLs included: 1270
