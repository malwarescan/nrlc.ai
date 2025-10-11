# NRLC.ai - LLM-First Programmatic SEO Platform

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/template/nrlc-ai)

A PHP 8+ programmatic SEO platform with multi-regional routing, hreflang implementation, comprehensive JSON-LD schemas, and LLM optimization features. Built for scale (30,000+ URLs) with deterministic content generation and automated sitemap workflows.

## Features

### Multi-Regional & Multilingual
- **6 Locales:** en-us, en-gb, es-es, fr-fr, de-de, ko-kr
- **Hreflang clusters** with x-default on every page
- **Locale-prefixed routing:** `/{lang}-{region}/path/`
- **Canonical URL hygiene** with query param stripping

### Programmatic SEO
- **Service × City pages** with city-aware content
- **Career × City pages** with JobPosting schema
- **Deterministic content generation** (800-1200 words/page)
- **Pain point mapping** with solutions in content + schema
- **FAQ rotation** via seeded shuffling

### JSON-LD Schema Coverage
- **Base schemas (all pages):** Organization, WebSite (with SearchAction), BreadcrumbList
- **Service pages:** Service (with OfferCatalog), LocalBusiness, FAQPage
- **Career pages:** JobPosting (fully compliant)

### Sitemap System v2
- **Standard sitemaps** with hreflang alternates
- **Image sitemaps** (Google image extension)
- **Video sitemaps** (Google video extension)
- **News sitemaps** (48h window, 1000 URL limit)
- **Gzip compression** (both .xml and .xml.gz)
- **Unified index** listing all sitemap types
- **Robots.txt automation**

### LLM Optimization
- **Agent surface** (agent.json) for capability discovery
- **SearchAction** in WebSite schema
- **Entity-weighted copy** with city/service disambiguation
- **Deep OfferCatalog** structures (pain point solutions)

## Quick Start

### Requirements
- PHP 8.0+
- Extensions: mbstring, dom, zlib

### Local Development

1. **Clone repository:**
```bash
git clone https://github.com/malwarescan/nrlc.ai.git
cd nrlc.ai
```

2. **Generate matrices:**
```bash
make matrix        # Service × city (60 rows)
make careers       # Role × city (24 rows)
```

3. **Build sitemaps:**
```bash
make build
```

4. **Start dev server:**
```bash
php -S localhost:8000 -t public public/router.php
```

5. **Open browser:**
```
http://localhost:8000/
http://localhost:8000/services/crawl-clarity/new-york/
http://localhost:8000/careers/new-york/seo-specialist/
```

### Railway Deployment

**Automatic (one-click):**
1. Click "Deploy on Railway" button above
2. Connect your GitHub repository
3. Railway auto-detects PHP and deploys

**Manual:**
1. Install Railway CLI: `npm i -g @railway/cli`
2. Login: `railway login`
3. Initialize: `railway init`
4. Deploy: `railway up`
5. Add domain: `railway domain`

**Configuration:**
- `railway.toml` - Railway-specific settings
- `nixpacks.toml` - Build configuration
- Uses PHP built-in server (no Apache needed)
- Document root: `/public`
- Sitemaps built during deployment

## Makefile Commands

```bash
make build                    # Full sitemap rebuild (all types)
make matrix                   # Generate service × city matrix
make careers                  # Generate role × city matrix
make careers_with_service     # Generate role × service × city matrix
make news                     # Fast news-only rebuild
make validate                 # Validate all sitemaps
make ping                     # Notify Google & Bing
```

## Project Structure

```
nrlc.ai/
├── public/              # Document root
│   ├── index.php        # Entry point
│   ├── router.php       # Built-in server router (Railway)
│   ├── .htaccess        # Apache config (non-Railway)
│   └── sitemaps/        # Generated sitemaps (gitignored)
├── bootstrap/           # Core initialization
│   ├── canonical.php    # URL hygiene
│   ├── env.php          # Environment setup
│   └── router.php       # Request routing
├── config/              # Configuration
│   ├── locales.php      # Locale definitions
│   ├── services.php     # Service list
│   └── careers.php      # Career roles
├── data/                # CSV data sources
│   ├── cities.csv       # City data
│   ├── services.csv     # Service definitions
│   ├── matrix.csv       # Service × city combinations
│   └── ...
├── lib/                 # Core libraries
│   ├── helpers.php      # Utilities
│   ├── hreflang.php     # Hreflang generation
│   ├── schema_builders.php  # JSON-LD schemas
│   ├── sitemap.php      # Sitemap v2 (with hreflang)
│   └── ...
├── pages/               # Page templates
│   ├── home/
│   ├── services/
│   ├── careers/
│   └── insights/
├── templates/           # HTML templates
├── scripts/             # Build & utility scripts
│   ├── build_sitemaps.php
│   ├── generate_matrix.php
│   ├── validate_sitemaps.php
│   └── ...
├── agent/
│   └── agent.json       # LLM agent surface
└── Makefile             # Build automation
```

## Scaling to 30,000+ URLs

### 1. Expand Cities
Add 500+ cities to `data/cities.csv`:
```csv
city,country,subdivision,lat,lng,lang,ccTLD
san-francisco,US,CA,37.7749,-122.4194,en,.us
paris,FR,IDF,48.8566,2.3522,fr,.fr
...
```

### 2. Generate Full Matrix
```bash
make matrix
# Output: Wrote data/matrix.csv (5000 rows)
# 10 services × 500 cities = 5,000 combinations
```

### 3. Rebuild Sitemaps
```bash
make build
# Generates ~10 shards with full hreflang
```

### 4. Validate & Deploy
```bash
make validate
git add .
git commit -m "Scale to 30k URLs"
git push origin main
# Railway auto-deploys
```

## URL Structure

### Service Pages
```
/services/{service}/                              # Service overview
/services/{service}/{city}/                       # Service × city
/{locale}/services/{service}/{city}/              # Localized version
```

**Examples:**
- `/services/crawl-clarity/new-york/`
- `/en-gb/services/json-ld-strategy/london/`
- `/ko-kr/services/llm-seeding/seoul/`

### Career Pages
```
/careers/{city}/{role}/                           # Career × city
/{locale}/careers/{city}/{role}/                  # Localized version
```

**Examples:**
- `/careers/new-york/seo-specialist/`
- `/careers/london/schema-engineer/`

### Sitemaps
```
/sitemaps/sitemap-index.xml.gz                    # Unified index (gzipped)
/sitemaps/services-1.xml.gz                       # Service pages
/sitemaps/careers-1.xml.gz                        # Career pages
/sitemaps/images-1.xml.gz                         # Image sitemap
/sitemaps/videos-1.xml.gz                         # Video sitemap
/sitemaps/news-insights-1.xml.gz                  # News articles (48h)
```

## Cron Setup (Production)

### Full Rebuild (Every 6 Hours)
```cron
0 */6 * * * cd /var/www/nrlc.ai && make build >> /var/log/nrlc_build.log 2>&1
```

### News Fast Update (Every 30 Minutes)
```cron
*/30 * * * * cd /var/www/nrlc.ai && make news >> /var/log/nrlc_news.log 2>&1
```

### Ping After Build
```cron
5 */6 * * * cd /var/www/nrlc.ai && make ping >> /var/log/nrlc_ping.log 2>&1
```

## Environment Variables

Set in Railway dashboard or `.env` (local):

```bash
# Optional - defaults to current domain
BASE_URL=https://nrlc.ai

# PHP configuration
PHP_MEMORY_LIMIT=256M
PHP_MAX_EXECUTION_TIME=60
```

## Troubleshooting

### 404 Errors
**Railway:** Ensure `railway.toml` is present and document root is `/public`
**Apache:** Verify mod_rewrite is enabled and `.htaccess` is read

### Sitemap Issues
```bash
# Validate sitemaps
make validate

# Check specific file
xmllint public/sitemaps/services-1.xml --noout

# Verify gzipped files
gunzip -c public/sitemaps/services-1.xml.gz | xmllint - --noout
```

### PHP Errors
Enable display_errors in `bootstrap/env.php`:
```php
ini_set('display_errors', '1');
```

## Performance

### Current Scale (6 cities)
- Build time: 0.5s
- Memory: <50MB
- Disk: 200KB sitemaps (gzipped)

### At Scale (500 cities)
- Build time: 8-12s
- Memory: <100MB
- Disk: 1.5MB sitemaps (gzipped)

## Documentation

- **[SCAFFOLD_COMPLETE.md](SCAFFOLD_COMPLETE.md)** - Initial platform scaffold guide
- **[SITEMAP_V2_COMPLETE.md](SITEMAP_V2_COMPLETE.md)** - Sitemap v2 implementation details
- **[SITEMAP_UTILITIES_COMPLETE.md](SITEMAP_UTILITIES_COMPLETE.md)** - Utilities & automation guide

## Tech Stack

- **Backend:** PHP 8.0+
- **Server:** Apache (production) or PHP built-in (Railway/dev)
- **Data:** CSV-based (no database required)
- **Encoding:** UTF-8
- **Line endings:** LF (Unix)

## Contributing

1. Create feature branch: `git checkout -b feature/description`
2. Make changes with tests
3. Run validation: `make validate`
4. Commit: `git commit -m "Description"`
5. Push: `git push origin feature/description`
6. Create Pull Request

## License

Proprietary - All rights reserved

## Support

- **Issues:** https://github.com/malwarescan/nrlc.ai/issues
- **Website:** https://nrlc.ai
- **Phone:** +1-844-568-4624

## Roadmap

- [ ] Database backend (PostgreSQL) for 100k+ URLs
- [ ] Admin dashboard for content management
- [ ] Real-time analytics integration
- [ ] A/B testing framework
- [ ] Automated translation (DeepL API)
- [ ] GraphQL API for headless CMS
- [ ] Redis caching layer

---

**Built with crawl clarity, JSON-LD precision, and LLM-first thinking.**

