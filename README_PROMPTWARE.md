# NRLC.ai — Promptware

This directory hosts open-source, production-ready "promptware":
- Turnkey Cursor one-shots
- Minimal, style-agnostic docs that inherit site CSS
- Schemas (HowTo, SoftwareSourceCode, BreadcrumbList)

## Installed Sets
- **JSON Stream + SEO AI** — NDJSON streaming API + AI manifest (+ Makefile, verifier, robots, headers)

## Verify
```bash
make sitemap:ai
make ndjson:verify
curl -s https://nrlc.ai/api/stream?limit=3 | head -n 3 | jq .
```

## License
MIT — see LICENSE

