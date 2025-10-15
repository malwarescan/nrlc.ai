import os, csv, json, io, datetime, re
from collections import defaultdict

# Use project-relative paths
PROJECT_ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
BASE = os.path.join(PROJECT_ROOT, "gsc_data")
OUT  = os.path.join(PROJECT_ROOT, "website", "seo-remediation")
os.makedirs(os.path.join(OUT, "fixes"), exist_ok=True)
os.makedirs(os.path.join(OUT, "analysis"), exist_ok=True)

def read_csv(name):
    p = os.path.join(BASE, name)
    if not os.path.exists(p):
        print(f"Warning: {name} not found, skipping")
        return []
    with open(p, "r", encoding="utf-8", errors="ignore") as f:
        data = f.read()
    try:
        dialect = csv.Sniffer().sniff(data[:4096]) if len(data) > 0 else csv.excel
    except:
        dialect = csv.excel
    reader = csv.reader(io.StringIO(data), dialect)
    rows = list(reader)
    hdr = [h.strip() for h in rows[0]] if rows else []
    items = [dict(zip(hdr, r)) for r in rows[1:]]
    print(f"Loaded {len(items)} rows from {name}")
    return items

print(f"Reading GSC audit data from: {BASE}")

crit = read_csv("Critical issues.csv")
non  = read_csv("Non-critical issues.csv")
meta = read_csv("Metadata.csv")
table= read_csv("Table.csv")

# Classify issues
summary = defaultdict(list)
issue_details = defaultdict(lambda: defaultdict(list))

for row in crit + non:
    issue = row.get("Issue", row.get("issue", "")).lower()
    url   = row.get("URL", row.get("url", row.get("Page", ""))).strip()
    severity = "CRITICAL" if row in crit else "Warning"
    
    if not issue:
        continue
    
    # Categorize by issue type
    if "schema" in issue or "json-ld" in issue or "structured" in issue:
        category = "schema"
    elif "title" in issue or "description" in issue or "meta" in issue or "heading" in issue:
        category = "meta"
    elif "canonical" in issue or "index" in issue or "robots" in issue or "sitemap" in issue:
        category = "canonical"
    elif "accessibility" in issue or "vitals" in issue or "performance" in issue:
        category = "accessibility"
    elif "duplicate" in issue:
        category = "duplicate"
    elif "mobile" in issue or "usability" in issue:
        category = "mobile"
    else:
        category = "other"
    
    summary[category].append(url)
    issue_details[category][issue].append({
        "url": url,
        "severity": severity,
        "full_issue": row.get("Issue", row.get("issue", issue))
    })

# Parse metadata for duplicates
duplicate_titles = defaultdict(list)
duplicate_descriptions = defaultdict(list)

for row in meta:
    title = row.get("Title", row.get("title", "")).strip()
    desc = row.get("Description", row.get("description", "")).strip()
    url = row.get("URL", row.get("url", "")).strip()
    
    if title:
        duplicate_titles[title].append(url)
    if desc:
        duplicate_descriptions[desc].append(url)

# Find actual duplicates (appearing more than once)
duplicate_titles = {k: v for k, v in duplicate_titles.items() if len(v) > 1}
duplicate_descriptions = {k: v for k, v in duplicate_descriptions.items() if len(v) > 1}

# Write comprehensive summary
with open(os.path.join(OUT, "analysis", "summary.md"), "w", encoding="utf-8") as f:
    f.write(f"""# GSC Audit & Remediation Summary

**Generated:** {datetime.datetime.utcnow().strftime('%Y-%m-%d %H:%M:%S')} UTC  
**Data Sources:** Critical issues, Non-critical issues, Metadata, Table data  
**Total Issues Found:** {len(crit) + len(non)}  
**Critical:** {len(crit)} | **Warnings:** {len(non)}

---

## Executive Summary

""")
    
    # Issue breakdown
    f.write("### Issues by Category\n\n")
    f.write("| Category | Count | Severity Mix |\n")
    f.write("|----------|-------|-------------|\n")
    for category in sorted(summary.keys()):
        count = len(set(summary[category]))
        crit_count = sum(1 for details in issue_details[category].values() 
                        for item in details if item['severity'] == 'CRITICAL')
        warn_count = len(set(summary[category])) - crit_count
        f.write(f"| **{category.title()}** | {count} | 🔴 {crit_count} / ⚠️ {warn_count} |\n")
    
    f.write("\n---\n\n")
    
    # Detailed breakdown by category
    for category in sorted(summary.keys()):
        if not issue_details[category]:
            continue
            
        f.write(f"## {category.title()} Issues\n\n")
        f.write(f"**Affected URLs:** {len(set(summary[category]))}\n\n")
        
        for issue_type, items in sorted(issue_details[category].items()):
            f.write(f"### {issue_type.title()}\n\n")
            f.write(f"**Count:** {len(items)}\n\n")
            
            # Show first 10 examples
            for item in items[:10]:
                severity_icon = "🔴" if item['severity'] == 'CRITICAL' else "⚠️"
                f.write(f"- {severity_icon} `{item['url']}`\n")
            
            if len(items) > 10:
                f.write(f"- ... and {len(items) - 10} more\n")
            
            f.write("\n")
        
        f.write("---\n\n")
    
    # Duplicate content analysis
    if duplicate_titles or duplicate_descriptions:
        f.write("## Duplicate Content Issues\n\n")
        
        if duplicate_titles:
            f.write(f"### Duplicate Titles ({len(duplicate_titles)})\n\n")
            for title, urls in list(duplicate_titles.items())[:5]:
                f.write(f"**Title:** \"{title[:80]}...\"\n")
                for url in urls[:3]:
                    f.write(f"- {url}\n")
                if len(urls) > 3:
                    f.write(f"- ... and {len(urls) - 3} more\n")
                f.write("\n")
        
        if duplicate_descriptions:
            f.write(f"### Duplicate Meta Descriptions ({len(duplicate_descriptions)})\n\n")
            for desc, urls in list(duplicate_descriptions.items())[:5]:
                f.write(f"**Description:** \"{desc[:80]}...\"\n")
                for url in urls[:3]:
                    f.write(f"- {url}\n")
                if len(urls) > 3:
                    f.write(f"- ... and {len(urls) - 3} more\n")
                f.write("\n")
    
    # Priority recommendations
    f.write("""## Priority Action Items

### 🔴 Critical (Fix Immediately)

1. **Schema Issues** - Fix invalid or incomplete structured data
   - Add missing required fields (title, description, datePosted, etc.)
   - Ensure all URLs use https://
   - Fix @id normalization

2. **Canonical Issues** - Resolve duplicate/missing canonicals
   - Every page needs exactly one canonical tag
   - All canonicals must use https://
   - Remove conflicting canonical declarations

3. **Indexation Blockers** - Fix robots.txt or meta robots issues
   - Ensure important pages aren't blocked
   - Remove noindex from critical pages
   - Verify sitemap URLs are crawlable

### ⚠️ Important (Fix This Week)

4. **Meta Tag Issues** - Optimize titles and descriptions
   - Fix duplicate titles (see list above)
   - Fix duplicate descriptions
   - Ensure titles ≤60 chars, descriptions 150-160 chars

5. **Duplicate Content** - Differentiate similar pages
   - Add unique value propositions
   - Expand thin content
   - Use canonical tags for true duplicates

### 📊 Improvements (Fix This Month)

6. **Accessibility** - Add alt text, ARIA labels
7. **Performance** - Optimize Core Web Vitals
8. **E-E-A-T Signals** - Add author info, dates, citations

---

## Next Steps

1. Review `/fixes/checklist.txt` for quick action items
2. Apply fixes from `/fixes/` directory
3. Test changes in Google Rich Results Test
4. Redeploy and monitor in Search Console
5. Request re-indexing for fixed pages

""")

print(f"✅ Summary written to {os.path.join(OUT, 'analysis', 'summary.md')}")

# Schema fix helpers
schema_fixes = """<?php
declare(strict_types=1);
namespace NRLC\\Schema\\Remediation;

/**
 * Additional schema fixes for GSC audit remediation
 * Extends the base SchemaFixes class
 */
final class RemediationHelpers {
    
    /**
     * Ensure all required fields exist for a given schema type
     * Returns array with missing fields added as TODO placeholders
     */
    public static function normalizeRequiredFields(array $data, string $type): array {
        $required = [
            'JobPosting' => [
                'title' => 'Job title',
                'description' => 'Job description',
                'datePosted' => date('Y-m-d'),
                'hiringOrganization' => ['@type' => 'Organization', 'name' => 'TODO: Company name'],
                'employmentType' => 'FULL_TIME',
                'validThrough' => date('Y-m-d', strtotime('+30 days'))
            ],
            'Product' => [
                'name' => 'Product name',
                'description' => 'Product description',
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD']
            ],
            'Organization' => [
                'url' => 'https://example.com',
                'logo' => 'https://example.com/logo.png',
                'sameAs' => []
            ],
            'Article' => [
                'headline' => 'Article headline',
                'image' => 'https://example.com/image.jpg',
                'datePublished' => date('Y-m-d'),
                'author' => ['@type' => 'Person', 'name' => 'Author name']
            ],
            'LocalBusiness' => [
                'name' => 'Business name',
                'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'US'],
                'telephone' => '+1-555-0100'
            ]
        ];
        
        $defaults = $required[$type] ?? [];
        foreach ($defaults as $field => $defaultValue) {
            if (empty($data[$field])) {
                $data[$field] = $defaultValue;
            }
        }
        
        return $data;
    }
    
    /**
     * Validate and fix common schema errors
     */
    public static function validateAndFix(array $schema): array {
        // Ensure @context
        if (empty($schema['@context'])) {
            $schema['@context'] = 'https://schema.org';
        }
        
        // Ensure @type
        if (empty($schema['@type'])) {
            error_log('Schema missing @type - cannot auto-fix');
            return $schema;
        }
        
        // Add @id if URL is present
        if (empty($schema['@id']) && !empty($schema['url'])) {
            $schema['@id'] = $schema['url'] . '#' . strtolower($schema['@type']);
        }
        
        // Ensure HTTPS on all URL fields
        $urlFields = ['url', 'logo', 'image', 'sameAs'];
        foreach ($urlFields as $field) {
            if (isset($schema[$field])) {
                if (is_string($schema[$field])) {
                    $schema[$field] = \\NRLC\\Schema\\SchemaFixes::ensureHttps($schema[$field]);
                } elseif (is_array($schema[$field])) {
                    $schema[$field] = array_map(
                        [\\NRLC\\Schema\\SchemaFixes::class, 'ensureHttps'],
                        $schema[$field]
                    );
                }
            }
        }
        
        return $schema;
    }
    
    /**
     * Generate complete JobPosting from minimal data
     */
    public static function completeJobPosting(array $job): array {
        $defaults = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'datePosted' => date('Y-m-d'),
            'validThrough' => date('Y-m-d', strtotime('+60 days')),
            'employmentType' => 'FULL_TIME',
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => 'NRLC.ai',
                'url' => 'https://nrlc.ai',
                'logo' => 'https://nrlc.ai/assets/logo.png'
            ]
        ];
        
        return array_merge($defaults, $job);
    }
}
"""

with open(os.path.join(OUT, "fixes", "schema_fixes.php"), "w", encoding="utf-8") as f:
    f.write(schema_fixes)

print(f"✅ Schema fixes written")

# Meta fixes template
meta_html = """<!-- GSC Remediation: Optimal <head> Template -->
<!DOCTYPE html>
<html lang="<?= $locale ?? 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- PRIMARY META TAGS -->
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    
    <!-- CANONICAL (HTTPS ONLY) -->
    <link rel="canonical" href="<?= SchemaFixes::ensureHttps($canonical_url) ?>">
    
    <!-- OPEN GRAPH / FACEBOOK -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SchemaFixes::ensureHttps($canonical_url) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:image" content="<?= SchemaFixes::ensureHttps($og_image) ?>">
    <meta property="og:site_name" content="NRLC.ai">
    
    <!-- TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= SchemaFixes::ensureHttps($canonical_url) ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta name="twitter:image" content="<?= SchemaFixes::ensureHttps($og_image) ?>">
    
    <!-- HREFLANG (if multilingual) -->
    <?php foreach ($hreflang_alternates as $locale => $url): ?>
    <link rel="alternate" hreflang="<?= $locale ?>" href="<?= SchemaFixes::ensureHttps($url) ?>">
    <?php endforeach; ?>
    <link rel="alternate" hreflang="x-default" href="<?= SchemaFixes::ensureHttps($default_locale_url) ?>">
    
    <!-- ROBOTS -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    
    <!-- Additional SEO -->
    <meta name="author" content="<?= $author ?? 'NRLC.ai' ?>">
    <?php if (!empty($published_date)): ?>
    <meta property="article:published_time" content="<?= $published_date ?>">
    <?php endif; ?>
    <?php if (!empty($modified_date)): ?>
    <meta property="article:modified_time" content="<?= $modified_date ?>">
    <?php endif; ?>
</head>

<!--
CHECKLIST FOR THIS PAGE:
[ ] Title ≤60 chars (currently: <?= mb_strlen($page_title) ?>)
[ ] Description 150-160 chars (currently: <?= mb_strlen($page_description) ?>)
[ ] Canonical uses HTTPS
[ ] All social meta present
[ ] Hreflang if multilingual
[ ] Author attribution present
-->
"""

with open(os.path.join(OUT, "fixes", "meta_fixes.html"), "w", encoding="utf-8") as f:
    f.write(meta_html)

print(f"✅ Meta template written")

# Robots & sitemap guide
robots_guide = """# Robots.txt & Sitemap Configuration

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
"""

with open(os.path.join(OUT, "fixes", "robots_and_sitemap.md"), "w", encoding="utf-8") as f:
    f.write(robots_guide)

print(f"✅ Robots/sitemap guide written")

# Content rewrites guide
content_guide = """# Content Quality & E-E-A-T Improvements

## Overview

Google's Search Essentials emphasize **E-E-A-T**: Experience, Expertise, Authoritativeness, and Trustworthiness.

## Content Quality Checklist

### ✅ Basic Requirements

- [ ] **Clear Purpose** - State page intent in first 50 words
- [ ] **Unique Value** - Differentiate from competitors
- [ ] **Comprehensive** - Answer user questions thoroughly
- [ ] **Well-Structured** - Use H1 → H2 → H3 hierarchy
- [ ] **Scannable** - Short paragraphs, bullet points, subheadings
- [ ] **Updated** - Show publish and modified dates
- [ ] **Mobile-Friendly** - Readable on all devices

### 🎯 E-E-A-T Signals

#### 1. Experience
- Add first-hand accounts or case studies
- Include "our process" or "our approach" sections
- Show real results/outcomes

#### 2. Expertise
- **Author Attribution:** Add bylines with qualifications
  ```html
  <div class="author-info">
    <span>By John Smith, Senior SEO Strategist</span>
    <span>Published: 2025-10-15</span>
    <span>Updated: 2025-10-15</span>
  </div>
  ```
- Demonstrate technical knowledge
- Use industry terminology correctly

#### 3. Authoritativeness
- Cite authoritative sources
- Link to research, studies, official guidelines
- Show industry recognition or awards

#### 4. Trustworthiness
- **Contact Information:** Make it easy to reach you
- **About/Team Pages:** Show real people
- **Privacy Policy & Terms:** Link in footer
- **HTTPS:** Secure all pages
- **Transparency:** Disclose affiliations, sponsorships

## Content Improvement Patterns

### Pattern 1: Thin Content → Comprehensive Guide

**Before (Thin):**
```
LLM Seeding is important for SEO. Contact us to learn more.
```

**After (Comprehensive):**
```
# LLM Seeding for AI Search Optimization

LLM seeding is the practice of optimizing content for large language models 
to improve visibility in AI-powered search experiences like ChatGPT, Perplexity, 
and Google's AI Overviews.

## Why LLM Seeding Matters

As of 2025, 40% of searches now involve AI assistance. Traditional SEO tactics 
don't fully address how LLMs:
- Parse and interpret content structure
- Prioritize factual accuracy over keyword density
- Value clear, direct answers

## Our LLM Seeding Process

### 1. Content Audit (Week 1)
We analyze your existing content for:
- Semantic clarity
- Factual accuracy
- Citation quality
- Structured data completeness

### 2. Optimization (Weeks 2-3)
We implement:
- Entity-based keyword mapping
- FAQ schema for Q&A optimization
- Citation-rich supporting content
- Clear hierarchical structure

### 3. Monitoring (Ongoing)
Track mentions in:
- ChatGPT responses
- Perplexity citations
- Google AI Overviews
- Other LLM interfaces

## Expected Outcomes

Clients typically see:
- 30-50% increase in AI search citations within 60 days
- Improved brand visibility in LLM-generated answers
- Better positioning as authoritative source

[Contact us for a free LLM readiness audit →]
```

### Pattern 2: Generic → Location-Specific

**Before:**
```
We provide conversion optimization services.
```

**After:**
```
# Conversion Rate Optimization in Abbotsford

Businesses in Abbotsford face unique challenges: a competitive local market,
diverse customer base, and need to differentiate from Vancouver metro competitors.

Our CRO services are tailored to Abbotsford businesses:
- Local market research and competitor analysis
- A/B testing optimized for B.C. audiences
- Mobile optimization (70% of Abbotsford traffic is mobile)
- Seasonal adjustments for Fraser Valley shopping patterns

## Abbotsford Success Stories

[Client example] increased conversions by 43% in 90 days by optimizing 
their checkout flow for mobile users and adding local trust signals.

## Why Choose Local CRO Expertise?

Working with a team familiar with Abbotsford market dynamics means:
- Faster setup (we understand local regulations)
- Better testing hypotheses (we know what works here)
- Local case studies and benchmarks

[Request a free CRO audit for your Abbotsford business →]
```

### Pattern 3: Add FAQ Section

Every page should have 3-6 FAQs with schema:

```html
<section class="faq">
  <h2>Frequently Asked Questions</h2>
  
  <div class="faq-item">
    <h3>What is conversion rate optimization?</h3>
    <p>Conversion rate optimization (CRO) is the systematic process of 
    increasing the percentage of website visitors who complete desired actions...</p>
  </div>
  
  <div class="faq-item">
    <h3>How long does CRO take to show results?</h3>
    <p>Most businesses see measurable improvements within 60-90 days. Initial 
    tests launch within 2 weeks, with iterative improvements ongoing...</p>
  </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is conversion rate optimization?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Conversion rate optimization (CRO) is the systematic process..."
      }
    }
  ]
}
</script>
```

## Content Templates

### Service Page Template

```
H1: [Service] in [Location]

Intro (50-100 words):
- What is this service?
- Who is it for?
- Key benefit/outcome

H2: Why [Service] Matters for [Location] Businesses
- Local context
- Specific challenges
- Market trends

H2: Our [Service] Process
H3: Step 1 - [Name]
H3: Step 2 - [Name]
H3: Step 3 - [Name]

H2: What to Expect
- Timeline
- Deliverables
- Success metrics

H2: Frequently Asked Questions
[3-6 Q&As with schema]

H2: Get Started
[Clear CTA]

Author byline
Last updated date
Related services (internal links)
```

## Quick Wins

1. **Add dates** to all pages (published + last modified)
2. **Add author info** to blog posts and guides
3. **Expand thin content** to 500+ words minimum
4. **Add FAQs** with schema to every service page
5. **Link to authoritative sources** (studies, official docs)
6. **Add internal links** to related content (3-5 per page)
7. **Optimize intro** - answer "what is this?" in first paragraph

## Content Scoring

Rate each page 1-10 on:
- [ ] Depth (comprehensive vs thin)
- [ ] Originality (unique vs generic)
- [ ] Authority (cited vs uncited)
- [ ] Structure (clear hierarchy vs flat)
- [ ] Actionability (clear next steps vs vague)

**Target:** Average 7+ across all metrics
"""

with open(os.path.join(OUT, "fixes", "content_rewrites.md"), "w", encoding="utf-8") as f:
    f.write(content_guide)

print(f"✅ Content guide written")

# Developer checklist
checklist = """GSC REMEDIATION CHECKLIST

=== CRITICAL (Fix This Week) ===

SCHEMA / STRUCTURED DATA
[ ] Replace all http:// with https:// in JSON-LD schema URLs
[ ] Add missing required fields to JobPosting schema:
    - title, description, datePosted, hiringOrganization, employmentType, validThrough
[ ] Add missing required fields to Product schema:
    - name, description, offers
[ ] Add missing required fields to Organization schema:
    - url, logo, sameAs
[ ] Add @id to all schema blocks for deduplication
[ ] Validate all schema in Google Rich Results Test

CANONICAL & INDEXING
[ ] Ensure every page has exactly ONE canonical tag
[ ] All canonicals must use https://
[ ] Remove http:// canonicals from templates
[ ] Verify robots.txt allows crawling of important pages
[ ] Submit updated sitemap to Google Search Console
[ ] Check for canonical conflicts (HTML tag vs HTTP header)

META TAGS
[ ] Fix duplicate titles (see analysis/summary.md)
[ ] Fix duplicate meta descriptions
[ ] Ensure all titles ≤ 60 characters
[ ] Ensure all descriptions 150-160 characters
[ ] Add Open Graph tags to all pages
[ ] Add Twitter Card tags to all pages

=== IMPORTANT (Fix This Month) ===

CONTENT QUALITY
[ ] Add author attribution to blog posts and guides
[ ] Add publish dates to all content pages
[ ] Add "last updated" dates to evergreen content
[ ] Expand thin content pages (< 300 words) to 500+ words
[ ] Add FAQ section with schema to service pages
[ ] Add 3-5 internal links per page
[ ] Link to authoritative external sources

HREFLANG (if multilingual)
[ ] Add hreflang tags to all localized pages
[ ] Include x-default hreflang
[ ] Ensure hreflang URLs are canonical
[ ] Verify bidirectional hreflang links

ACCESSIBILITY
[ ] Add alt text to all images
[ ] Ensure color contrast meets WCAG AA
[ ] Add ARIA labels to interactive elements
[ ] Test keyboard navigation
[ ] Verify screen reader compatibility

=== ONGOING MAINTENANCE ===

PERFORMANCE
[ ] Optimize images (WebP, proper sizing)
[ ] Lazy-load below-the-fold images
[ ] Defer non-critical JavaScript
[ ] Minimize CSS and JS
[ ] Monitor Core Web Vitals (LCP < 2.5s, FID < 100ms, CLS < 0.1)

MONITORING
[ ] Weekly: Check Google Search Console for new issues
[ ] Monthly: Re-run GSC audit and regenerate reports
[ ] Quarterly: Content quality audit
[ ] Quarterly: Backlink profile review

=== VALIDATION ===

After applying fixes:
[ ] Test in Google Rich Results Test: https://search.google.com/test/rich-results
[ ] Test in Mobile-Friendly Test: https://search.google.com/test/mobile-friendly
[ ] Test in PageSpeed Insights: https://pagespeed.web.dev/
[ ] Request indexing in Google Search Console for critical pages
[ ] Monitor performance tab for position/CTR changes

=== DEPLOYMENT WORKFLOW ===

For each fix:
1. Create feature branch: `git checkout -b fix/gsc-schema-urls`
2. Apply fix using templates from /fixes/
3. Test locally
4. Commit: `git commit -m "fix(schema): force HTTPS on all URLs"`
5. Push and deploy
6. Validate in Rich Results Test
7. Request re-indexing in GSC
8. Monitor for 7-14 days

=== RESOURCES ===

- Google Search Essentials: https://developers.google.com/search/docs/essentials
- Schema.org Documentation: https://schema.org/
- Core Web Vitals Guide: https://web.dev/vitals/
- E-E-A-T Guidelines: https://developers.google.com/search/docs/appearance/page-experience

Generated: {}
""".format(datetime.datetime.utcnow().strftime('%Y-%m-%d %H:%M:%S UTC'))

with open(os.path.join(OUT, "fixes", "checklist.txt"), "w", encoding="utf-8") as f:
    f.write(checklist)

print(f"✅ Checklist written")

# Create index file
index_content = f"""# GSC Remediation Package

**Generated:** {datetime.datetime.utcnow().strftime('%Y-%m-%d %H:%M:%S')} UTC

## Contents

### Analysis
- `analysis/summary.md` - Complete breakdown of all issues found

### Fixes
- `fixes/schema_fixes.php` - PHP helpers for schema normalization
- `fixes/meta_fixes.html` - HTML template for optimal <head> tags
- `fixes/robots_and_sitemap.md` - Canonical and sitemap best practices
- `fixes/content_rewrites.md` - Content quality and E-E-A-T guide
- `fixes/checklist.txt` - Developer action checklist

## Quick Start

1. **Review Issues:** Open `analysis/summary.md`
2. **Prioritize:** Start with CRITICAL items in `fixes/checklist.txt`
3. **Apply Fixes:** Use templates from `fixes/` directory
4. **Test:** Validate in Google Rich Results Test
5. **Deploy:** Push changes and request re-indexing in GSC
6. **Monitor:** Track improvements in Search Console

## Issue Summary

- **Total Issues:** {len(crit) + len(non)}
- **Critical:** {len(crit)}
- **Warnings:** {len(non)}
- **Categories:** {len(summary)}

### Top Issues
"""

for category in sorted(summary.keys(), key=lambda k: len(summary[k]), reverse=True)[:5]:
    index_content += f"- **{category.title()}:** {len(set(summary[category]))} URLs affected\n"

index_content += """
## Tools Used

- Google Search Console data exports
- Python remediation builder
- Schema.org validation
- Google Search Essentials guidelines
"""

with open(os.path.join(OUT, "README.md"), "w", encoding="utf-8") as f:
    f.write(index_content)

print(f"✅ Index written")

print(f"""
{'='*60}
✅ GSC Remediation Package Generated Successfully!
{'='*60}

Output directory: {OUT}

Files created:
  📊 analysis/summary.md     - Detailed issue breakdown
  🔧 fixes/schema_fixes.php   - Schema normalization helpers
  🏷️  fixes/meta_fixes.html   - Optimal <head> template
  🤖 fixes/robots_and_sitemap.md - Canonical best practices
  ✍️  fixes/content_rewrites.md - E-E-A-T improvements
  ✅ fixes/checklist.txt      - Developer action items
  📖 README.md                - Package overview

Next steps:
1. Review: open {os.path.join(OUT, 'analysis', 'summary.md')}
2. Start: open {os.path.join(OUT, 'fixes', 'checklist.txt')}
3. Apply fixes from /fixes/ directory
4. Test in Rich Results Test
5. Deploy and monitor in GSC
""")

