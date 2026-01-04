# Robots.txt & Sitemap Configuration

## Current Issues

Based on GSC audit data, common issues include:
- Missing or incorrect robots.txt
- Sitemap not declared in robots.txt
- Canonical inconsistencies (http vs https)

## Recommended robots.txt

```
User-agent: *
Allow: /

# Disallow admin/private areas
Disallow: /admin/
Disallow: /api/
Disallow: /cgi-bin/
Disallow: /*.json$

# Sitemap location
Sitemap: https://nrlc.ai/sitemaps/sitemap-index.xml.gz

# Preferred host (HTTPS only)
Host: nrlc.ai
```

## Sitemap Best Practices

1. **Use sitemap index** for sites with 1000+ URLs
2. **Compress with gzip** to reduce bandwidth
3. **Include only canonical URLs** (no redirects, no duplicates)
4. **Update lastmod dates** when content changes
5. **Submit to Google Search Console**

## Canonical Tag Rules

✅ **DO:**
- Use absolute URLs: `<link rel="canonical" href="https://nrlc.ai/page/">`
- Include trailing slash consistently
- Use HTTPS only
- Point to self on non-duplicate pages
- Point to original on duplicate/paginated pages

❌ **DON'T:**
- Use relative URLs
- Mix http:// and https://
- Include query parameters unless necessary
- Create canonical loops
- Use different canonicals in HTML vs HTTP header

## Hreflang Implementation

For multilingual sites:

```html
<link rel="alternate" hreflang="en-us" href="https://nrlc.ai/en-us/page/">
<link rel="alternate" hreflang="en-gb" href="https://nrlc.ai/en-gb/page/">
<link rel="alternate" hreflang="de-de" href="https://nrlc.ai/de-de/page/">
<link rel="alternate" hreflang="fr-fr" href="https://nrlc.ai/fr-fr/page/">
<link rel="alternate" hreflang="es-es" href="https://nrlc.ai/es-es/page/">
<link rel="alternate" hreflang="ko-kr" href="https://nrlc.ai/ko-kr/page/">
<link rel="alternate" hreflang="x-default" href="https://nrlc.ai/en-us/page/">
```

## Validation Steps

1. **Test robots.txt:** https://nrlc.ai/robots.txt
2. **Test sitemap:** https://nrlc.ai/sitemap.xml
3. **Search Console:** Submit sitemap in Sitemaps section
4. **Rich Results Test:** Verify canonical is correct
5. **URL Inspection:** Check indexation status

## Common Fixes

### Issue: Mixed HTTP/HTTPS Canonicals
**Fix:** Update all canonical tags to HTTPS
```php
// Use SchemaFixes helper
<link rel="canonical" href="<?= SchemaFixes::ensureHttps($url) ?>">
```

### Issue: Missing Sitemap in robots.txt
**Fix:** Add Sitemap directive
```
Sitemap: https://nrlc.ai/sitemap.xml
```

### Issue: Canonical Points to Wrong Page
**Fix:** Ensure canonical = current page URL (if not duplicate)
```php
$canonical = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$canonical = SchemaFixes::ensureHttps($canonical);
```
