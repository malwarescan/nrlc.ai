# Site Discovery (No Guesswork)

CLI to extract only verified data from your live site and propose a `.env` for the SEO Kit.

## Usage
php scripts/discover.php --base=https://YOURDOMAIN.tld --max=300

Outputs:
- output/detected_env.json   (all raw fields + evidence)
- output/.env.suggested      (only verified environment fields, blanks when unknown)
- output/audit_report.csv    (per-URL crawl facts)

Safe:
- On-domain only, respects robots.txt, no off-domain requests, no external libs.
- Leaves unknowns blank with comments instead of guessing.

