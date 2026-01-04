# SEO Deployment Action Plan

## Phase 1: Infrastructure (1-2 hours)

### A. Deploy Static Files

```bash
# 1. Copy robots.txt to public root
cp website/robots.txt public/robots.txt

# Verify it's accessible
curl https://nrlc.ai/robots.txt
```

### B. Integrate SchemaFixes.php

Add to your `lib/` or equivalent:

```php
// In lib/schema_builders.php or wherever you build JSON-LD
require __DIR__ . '/../website/schema/SchemaFixes.php';

use NRLC\Schema\SchemaFixes;

// Before outputting any JSON-LD:
function buildOrganizationSchema($data) {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => SchemaFixes::ensureHttps($data['org_url']),  // Force HTTPS
        'name' => $data['org_name'],
        'logo' => SchemaFixes::ensureHttps($data['logo']),    // Force HTTPS
        'url' => SchemaFixes::ensureHttps($data['url']),
        'sameAs' => $data['social_profiles']
    ];
    
    // Prevent duplicate output if already rendered on page
    return SchemaFixes::jsonLdOnce($schema);
}

// For job postings:
function buildJobPostingSchema($job) {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $job['title'],
        // Normalize experience requirements
        'experienceRequirements' => SchemaFixes::normalizeExperienceRequirements($job['experience']),
        // Normalize education
        'educationRequirements' => SchemaFixes::normalizeEducationRequirements($job['education']),
        // ... rest of schema
    ];
    
    return SchemaFixes::jsonLdOnce($schema);
}
```

### C. Update Environment Variables

```bash
# Edit your .env file
nano .env

# Update based on site-discovery/output/.env.suggested:
DEFAULT_LOCALE=en-us
LOCALES=de-de,en-gb,en-us,es-es,fr-fr,ko-kr
SITE_NAME=NRLC.ai
ORG_URL=https://nrlc.ai
ORG_LOGO=https://nrlc.ai/assets/logo.png
ORG_SAME_AS=https://www.linkedin.com/company/neural-command/
SCHEMA_PUBLISHER_NAME=NRLC.ai
SCHEMA_PUBLISHER_LOGO=https://nrlc.ai/assets/logo.png
```

---

## Phase 2: High-Priority Pages (2-3 days)

Focus on **position 5-15 pages** with query matches.

### Priority 1: Query Match Found

**File:** `website/seo-briefs/en-us-services-conversion-optimization-ai-abbotsford.md`

**Current:** Position 19.33, 3 impressions  
**Query:** "conversion rate optimization abbotsford"

#### Actions:
1. Open page source: `pages/services/service_city.php` (or wherever this renders)

2. Update meta tags:
```php
<title>conversion rate optimization abbotsford | NRLC.ai</title>
<meta name="description" content="conversion rate optimization abbotsford — solutions, pricing, and FAQs. Updated 2025-10-15.">
```

3. Update H1:
```php
<h1>Conversion Rate Optimization Abbotsford</h1>
```

4. Expand intro paragraph with keyword:
```php
<p>Conversion rate optimization in Abbotsford helps businesses improve their digital performance through data-driven testing and user experience improvements. Our team delivers measurable results within 60-90 days, backed by case studies from similar markets.</p>
```

5. Add FAQ section with JSON-LD:
```php
<section class="faq">
  <h2>Frequently Asked Questions</h2>
  
  <div class="faq-item">
    <h3>What is conversion rate optimization abbotsford?</h3>
    <p>Conversion rate optimization abbotsford is explained in practical terms for decision-makers. This page covers fundamentals, implementation steps, and expected outcomes.</p>
  </div>
  
  <div class="faq-item">
    <h3>How does conversion rate optimization abbotsford improve results?</h3>
    <p>It addresses common bottlenecks and aligns with measurable KPIs. See our implementation notes and case-style examples.</p>
  </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is conversion rate optimization abbotsford?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "conversion rate optimization abbotsford is explained in practical terms for decision-makers. This page covers fundamentals, implementation steps, and expected outcomes."
      }
    },
    {
      "@type": "Question",
      "name": "How does conversion rate optimization abbotsford improve results?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It addresses common bottlenecks and aligns with measurable KPIs. See our implementation notes and case-style examples."
      }
    }
  ]
}
</script>
```

6. Deploy and monitor in GSC (7-14 days)

### Priority 2-10: Position 5-7 Pages

These are **closest to page 1** - small improvements = big gains.

```bash
# Find your top priority pages
grep -l "Avg Position: [5-7]\." website/seo-briefs/*.md

# For each one, repeat the same process:
# 1. Read the brief
# 2. Update title, meta, H1
# 3. Add FAQs + JSON-LD
# 4. Deploy
# 5. Monitor
```

---

## Phase 3: Content Templates (1 week)

Create reusable components for consistency.

### A. FAQ Component

```php
// templates/faq.php
function renderFAQ($faqs) {
    echo '<section class="faq">';
    echo '<h2>Frequently Asked Questions</h2>';
    
    foreach ($faqs as $faq) {
        echo '<div class="faq-item">';
        echo '<h3>' . htmlspecialchars($faq['question']) . '</h3>';
        echo '<p>' . htmlspecialchars($faq['answer']) . '</p>';
        echo '</div>';
    }
    
    echo '</section>';
    
    // JSON-LD
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn($faq) => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer']
            ]
        ], $faqs)
    ];
    
    echo '<script type="application/ld+json">';
    echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '</script>';
}
```

### B. Meta Tags Component

```php
// templates/meta.php
function renderMetaTags($page) {
    $title = $page['title'] ?? 'NRLC.ai';
    $desc = $page['description'] ?? '';
    $canonical = SchemaFixes::ensureHttps($page['url']);
    
    echo '<title>' . htmlspecialchars($title) . '</title>';
    echo '<meta name="description" content="' . htmlspecialchars($desc) . '">';
    echo '<link rel="canonical" href="' . htmlspecialchars($canonical) . '">';
    
    // hreflang (from website/hreflang/hreflang-template.csv)
    foreach ($page['alternates'] as $locale => $url) {
        echo '<link rel="alternate" hreflang="' . $locale . '" href="' . SchemaFixes::ensureHttps($url) . '">';
    }
}
```

---

## Phase 4: Batch Updates (2-3 weeks)

Update remaining pages in batches by content type.

### Batch 1: Services Pages (32 briefs)
- Use template approach
- Update all German (de-de) pages first
- Then English (en-us, en-gb)
- Monitor CTR changes

### Batch 2: Careers Pages (12 briefs)
- Add structured job posting schema
- Use SchemaFixes for experience/education
- Add location-specific FAQs

### Batch 3: Insights Pages (26 briefs)
- Add author schema
- Update dates
- Add internal links to related services

---

## Phase 5: Validation & Monitoring

### A. Validate Schema
```bash
# Test a few pages
curl https://nrlc.ai/en-us/services/conversion-optimization-ai/abbotsford/ | grep 'application/ld+json'

# Use Google's Rich Results Test
# https://search.google.com/test/rich-results
```

### B. Submit to GSC
1. Go to search.google.com/search-console
2. **Sitemaps** → Submit your sitemap URLs
3. **URL Inspection** → Test updated pages
4. **Performance** → Monitor position changes

### C. Track Progress
```bash
# Re-export GSC data monthly
# Download Queries.csv and Pages.csv

# Regenerate briefs
python3 tools/gsc_to_briefs.py

# Compare
diff website/seo-briefs/en-us-services-conversion-optimization-ai-abbotsford.md \
     website/seo-briefs-backup/en-us-services-conversion-optimization-ai-abbotsford.md
```

---

## Quick Reference Checklist

### For Each Page:
- [ ] Read the brief in `website/seo-briefs/`
- [ ] Update `<title>` (≤60 chars)
- [ ] Update `<meta name="description">` (150-160 chars)
- [ ] Update `<h1>` to match primary keyword
- [ ] Expand intro paragraph (mention outcome + timeline)
- [ ] Add 3-5 subheadings from brief
- [ ] Add FAQ section (3-6 Q&As)
- [ ] Add FAQPage JSON-LD from brief
- [ ] Add 2-3 internal links
- [ ] Verify all URLs use `https://`
- [ ] Test in Rich Results Tool
- [ ] Deploy to production
- [ ] Request indexing in GSC

---

## Automation Opportunities

### Create a Script to Apply Briefs

```php
// scripts/apply_seo_brief.php
$briefFile = $argv[1] ?? null;
$pageTemplate = $argv[2] ?? null;

if (!$briefFile || !$pageTemplate) {
    die("Usage: php scripts/apply_seo_brief.php website/seo-briefs/FILE.md pages/PATH.php\n");
}

// Parse brief (extract title, meta, H1, FAQs)
// Update page template
// Show diff for review
```

---

## Timeline

| Phase | Duration | Output |
|-------|----------|--------|
| Phase 1: Infrastructure | 1-2 hours | Robots.txt, SchemaFixes, .env updated |
| Phase 2: High Priority (10 pages) | 2-3 days | Position 5-15 pages optimized |
| Phase 3: Templates | 1 week | Reusable FAQ/meta components |
| Phase 4: Batch Updates (60 pages) | 2-3 weeks | All briefs applied |
| Phase 5: Monitor | Ongoing | Monthly GSC tracking |

**Total:** ~4 weeks to full deployment

---

## Success Metrics

Track in Google Search Console:

- **Position** - Target: Move pos 10-15 → pos 5-8
- **CTR** - Target: +2-5% from better titles/descriptions
- **Impressions** - Target: +20-30% from broader keyword coverage
- **Clicks** - Target: +30-50% combined effect

---

*Generated: 2025-10-15*  
*Tools: site-discovery, build_gsc_pack.py, gsc_to_briefs.py*
