#!/usr/bin/env bash
set -euo pipefail
AI_NDJSON="public/sitemaps/sitemap-ai.ndjson"
[[ -s "$AI_NDJSON" ]] || { echo "Missing AI manifest: $AI_NDJSON"; exit 1; }
head -n 1 "$AI_NDJSON" | jq . >/dev/null 2>&1 || { echo "First line not valid JSON"; exit 1; }
LINES=$(wc -l < "$AI_NDJSON" | tr -d ' ')
echo "OK: $AI_NDJSON ($LINES rows)"

