# GSC Remediation Pack - Real Data Summary

## 📊 Extracted from Google Search Console

**Data Source:** 1,334 GSC records across 4 CSV files  
**Generated:** October 15, 2025  
**Base URL:** https://nrlc.ai

---

## 🌍 Internationalization Detected

**6 Locales Found:**
- 🇩🇪 de-de (German - Germany)
- 🇬🇧 en-gb (English - UK)
- 🇺🇸 en-us (English - US)
- 🇪🇸 es-es (Spanish - Spain)
- 🇫🇷 fr-fr (French - France)
- 🇰🇷 ko-kr (Korean - South Korea)

**Default Locale:** de-de (alphabetically first - update to en-us if needed)

---

## 📄 Content Analysis

**1,270 Unique Canonical URLs** including:

### Services (GEO-16 Cities)
- Agentic SEO, Crawl Clarity, Technical SEO, International SEO
- Cities: New York, London, Singapore, Seoul, Tokyo, Newcastle, Toronto

### Careers
- Schema Engineer, LLM Strategist, Technical Writer, SEO Specialist
- Cities: New York, Seoul, Tokyo, London, Singapore

### Insights
- GEO-16 Framework, LLM Ontology Generation
- Geo16-introduction, implications, methodology

### Blog & Resources
- 100+ blog posts across all locales
- 500+ resource pages

---

## ✅ Files Ready for Deployment

### 1. `.env.suggested`
Copy to your project root:
```bash
cp website/.env.suggested .env
```

**Update these values:**
- `SITE_NAME=NRLC.ai` (currently "Your Site")
- `ORG_LOGO=https://nrlc.ai/assets/logo.png` (add your actual logo)
- `DEFAULT_LOCALE=en-us` (currently de-de)
- Add social profiles to `ORG_SAME_AS`

### 2. `robots.txt`
```bash
cp website/robots.txt public/robots.txt
```

### 3. `sitemap.xml`
1,270 URLs ready for submission:
```bash
cp website/sitemap.xml public/sitemap.xml
```

### 4. `schema/SchemaFixes.php`
Integrate in your JSON-LD generators:
```php
use NRLC\Schema\SchemaFixes;

// Prevent duplicate @ids
$jsonld = SchemaFixes::jsonLdOnce($schema);

// Normalize URLs to HTTPS
$url = SchemaFixes::ensureHttps('http://nrlc.ai/logo.png');
// Returns: 'https://nrlc.ai/logo.png'

// Normalize job requirements
$exp = SchemaFixes::normalizeExperienceRequirements("3+ years");
// Returns: ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>36]
```

### 5. `hreflang/hreflang-template.csv`
120 rows (20 pages × 6 locales) showing proper hreflang alternates.

Use this to add hreflang tags to your templates:
```html
<link rel="alternate" hreflang="de-de" href="https://nrlc.ai/de-de/services/..." />
<link rel="alternate" hreflang="en-gb" href="https://nrlc.ai/en-gb/services/..." />
<link rel="alternate" hreflang="en-us" href="https://nrlc.ai/en-us/services/..." />
<link rel="alternate" hreflang="es-es" href="https://nrlc.ai/es-es/services/..." />
<link rel="alternate" hreflang="fr-fr" href="https://nrlc.ai/fr-fr/services/..." />
<link rel="alternate" hreflang="ko-kr" href="https://nrlc.ai/ko-kr/services/..." />
<link rel="alternate" hreflang="x-default" href="https://nrlc.ai/en-us/services/..." />
```

### 6. `patches/https-normalize.md`
Search & replace patterns to ensure all URLs use HTTPS.

---

## 🚀 Next Steps

### 1. Update Configuration
```bash
# Edit .env
nano .env

# Change these:
SITE_NAME=NRLC.ai
DEFAULT_LOCALE=en-us
ORG_LOGO=https://nrlc.ai/assets/logo.png
ORG_SAME_AS=https://www.linkedin.com/company/neural-command/
SCHEMA_PUBLISHER_NAME=NRLC.ai
SCHEMA_PUBLISHER_LOGO=https://nrlc.ai/assets/logo.png
```

### 2. Deploy Files
```bash
# Deploy to production
cp website/robots.txt /path/to/production/public/
cp website/sitemap.xml /path/to/production/public/

# Or via Railway/hosting panel:
# Upload robots.txt and sitemap.xml to site root
```

### 3. Integrate Schema Fixes
Add to your `lib/schema_builders.php` or equivalent:
```php
require __DIR__ . '/../website/schema/SchemaFixes.php';

// In your JSON-LD generator:
$jsonld = SchemaFixes::jsonLdOnce([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => SchemaFixes::ensureHttps($orgUrl),
    // ...
]);
```

### 4. Submit to Google Search Console
1. Go to [search.google.com/search-console](https://search.google.com/search-console)
2. Select property: nrlc.ai
3. **Sitemaps** → Add new sitemap → `https://nrlc.ai/sitemap.xml`
4. **URL Inspection** → Test a few URLs to verify robots.txt
5. **Core Web Vitals** → Check structured data validation

### 5. Validate
- [ ] Verify robots.txt: https://nrlc.ai/robots.txt
- [ ] Verify sitemap: https://nrlc.ai/sitemap.xml
- [ ] Test structured data: [Rich Results Test](https://search.google.com/test/rich-results)
- [ ] Check hreflang: [Hreflang Tags Testing Tool](https://technicalseo.com/tools/hreflang/)

---

## 📈 Impact

**Before:**
- Mixed http:// and https://
- Potential duplicate @ids in JSON-LD
- No standardized job requirements

**After:**
- ✅ All 1,270 URLs normalized to HTTPS
- ✅ Duplicate prevention with `jsonLdOnce()`
- ✅ Structured experience/education requirements
- ✅ Complete 6-locale hreflang mapping
- ✅ GSC-ready sitemap and robots.txt

---

## 🔄 Regeneration

To regenerate with fresh GSC data:
```bash
# 1. Export from Google Search Console
# 2. Place CSVs in gsc_data/
# 3. Run:
python3 tools/build_gsc_pack.py

# 4. Review updated files
cat website/.env.suggested
cat website/README.txt
```

---

*Generated from real Google Search Console data*  
*Tool: tools/build_gsc_pack.py*
