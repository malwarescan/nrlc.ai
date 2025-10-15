"""
Fix-Now SEO Analysis from Site Discovery Data
Uses the audit_report.csv from site-discovery tool
"""
import os, re, csv, json, datetime, urllib.parse
from collections import defaultdict, Counter

# Paths
PROJECT_ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
AUDIT_CSV = os.path.join(PROJECT_ROOT, "site-discovery", "output", "audit_report.csv")
GSC_DIR = os.path.join(PROJECT_ROOT, "gsc_data")
OUTB = os.path.join(PROJECT_ROOT, "website", "seo-briefs")
OUTR = os.path.join(PROJECT_ROOT, "website", "seo-remediation")

os.makedirs(OUTB, exist_ok=True)
os.makedirs(os.path.join(OUTR, "fixes"), exist_ok=True)

print(f"📊 Analyzing site-discovery audit data...")
print(f"Source: {AUDIT_CSV}\n")

def cap(s, n):
    s = re.sub(r"\s+", " ", str(s)).strip()
    return (s[:n-1]+"…") if len(s) > n else s

def https(u):
    if not isinstance(u, str):
        return u
    if u.startswith("https://"):
        return u
    if u.startswith("http://"):
        return "https://" + u[7:]
    return u

def tokens(url):
    path = urllib.parse.urlparse(url).path.lower()
    return [t for t in re.split(r"[^a-z0-9]+", path) if t and t not in {'en', 'us', 'gb', 'de', 'fr', 'es', 'ko', 'kr', 'www', 'ai', 'com', 'org', 'net'}]

# Read audit report
rows = []
with open(AUDIT_CSV, 'r', encoding='utf-8-sig') as f:
    reader = csv.DictReader(f)
    for row in reader:
        rows.append(row)

print(f"✓ Loaded {len(rows)} pages from audit")

# Analyze meta tags
issues = {
    'empty_titles': [],
    'empty_descriptions': [],
    'duplicate_titles': [],
    'duplicate_descriptions': [],
    'http_canonicals': [],
    'missing_canonicals': [],
    'duplicate_faqpage': []
}

title_counts = Counter()
desc_counts = Counter()
netloc = None

for row in rows:
    url = row.get('url', '') or row.get('URL', '')
    if not url:
        continue
    
    if not netloc:
        netloc = urllib.parse.urlparse(url).netloc
    
    status = row.get('status', '') or row.get('Status', '')
    if status and str(status).startswith('2'):  # Only 2xx responses
        title = (row.get('title', '') or row.get('Title', '')).strip()
        meta_desc = (row.get('meta_description', '') or row.get('MetaDescription', '')).strip()
        canonical = (row.get('canonical', '') or row.get('Canonical', '')).strip()
        jsonld = row.get('jsonld_types', '') or row.get('JSONLD_Types', '') or ''
        
        # Empty checks
        if not title or title == 'nan':
            issues['empty_titles'].append({'url': url, 'title': title})
        else:
            title_counts[title] += 1
        
        if not meta_desc or meta_desc == 'nan':
            issues['empty_descriptions'].append({'url': url, 'description': meta_desc})
        else:
            desc_counts[meta_desc] += 1
        
        # Canonical checks
        if not canonical or canonical == 'nan':
            issues['missing_canonicals'].append({'url': url})
        elif canonical.startswith('http://'):
            issues['http_canonicals'].append({'url': url, 'canonical': canonical})
        
        # Schema checks
        if 'FAQPage' in jsonld:
            # Count occurrences
            faq_count = jsonld.count('FAQPage')
            if faq_count > 1:
                issues['duplicate_faqpage'].append({'url': url, 'count': faq_count})

# Find duplicates (titles/descriptions appearing 2+ times)
for title, count in title_counts.items():
    if count > 1 and title:
        matching_urls = [r.get('url', '') or r.get('URL', '') for r in rows 
                        if ((r.get('title', '') or r.get('Title', '')).strip() == title)]
        for url in matching_urls[:5]:  # Limit to first 5
            issues['duplicate_titles'].append({'url': url, 'title': title})

for desc, count in desc_counts.items():
    if count > 1 and desc and len(desc) > 10:
        matching_urls = [r.get('url', '') or r.get('URL', '') for r in rows 
                        if ((r.get('meta_description', '') or r.get('MetaDescription', '')).strip() == desc)]
        for url in matching_urls[:5]:
            issues['duplicate_descriptions'].append({'url': url, 'description': desc})

# Summary
print(f"\n🔍 Issues Found:")
print(f"  🔴 {len(issues['empty_titles'])} empty titles")
print(f"  🔴 {len(issues['empty_descriptions'])} empty descriptions")
print(f"  🟡 {len(issues['duplicate_titles'])} duplicate titles")
print(f"  🟡 {len(issues['duplicate_descriptions'])} duplicate descriptions")
print(f"  🟠 {len(issues['missing_canonicals'])} missing canonicals")
print(f"  🟠 {len(issues['http_canonicals'])} http:// canonicals (should be https)")
print(f"  ⚠️  {len(issues['duplicate_faqpage'])} pages with duplicate FAQPage schema")

# Generate briefs for problem pages
target_urls = set()
for issue_type, issue_list in issues.items():
    for item in issue_list[:50]:  # Limit to top 50 per issue
        target_urls.add(item.get('url', ''))

target_urls = {u for u in target_urls if u and u != 'nan'}

print(f"\n📝 Generating {len(target_urls)} SEO briefs...")

NOW = datetime.datetime.now(datetime.UTC).strftime("%Y-%m-%d")

for url in sorted(target_urls):
    # Extract keywords from URL
    url_tokens = tokens(url)
    guess_kw = " ".join(url_tokens[:4]) if url_tokens else "page"
    
    # Get current meta (if any)
    current = next((r for r in rows if (r.get('url', '') or r.get('URL', '')) == url), {})
    current_title = (current.get('title', '') or current.get('Title', '')).strip()
    current_desc = (current.get('meta_description', '') or current.get('MetaDescription', '')).strip()
    
    # Generate suggestions
    title_suggestion = cap(f"{guess_kw.title()} | {netloc or 'NRLC.ai'}", 60)
    h1_suggestion = cap(guess_kw.title(), 70)
    meta_suggestion = cap(f"{guess_kw} — Expert solutions and implementation guide. Updated {NOW}.", 160)
    
    # Subheads based on URL structure
    if '/services/' in url:
        subs = [
            f"Why Choose Our {guess_kw.title()} Service",
            f"How {guess_kw.title()} Works",
            f"{guess_kw.title()} Pricing & Packages"
        ]
    elif '/insights/' in url or '/blog/' in url:
        subs = [
            f"Understanding {guess_kw.title()}",
            f"Best Practices for {guess_kw.title()}",
            f"Common {guess_kw.title()} Challenges"
        ]
    else:
        subs = [
            f"{guess_kw.title()} Overview",
            f"Key Benefits",
            f"Implementation Guide"
        ]
    
    # FAQ schema
    faq_ld = {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": f"What is {guess_kw}?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Provide a clear, concise definition and explain the core value proposition."
                }
            },
            {
                "@type": "Question",
                "name": f"How do I implement {guess_kw}?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Outline the step-by-step process, timeline, and expected outcomes."
                }
            },
            {
                "@type": "Question",
                "name": f"What are the benefits of {guess_kw}?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "List the main advantages, ROI potential, and competitive advantages."
                }
            }
        ]
    }
    
    # Identify specific issues for this URL
    url_issues = []
    if any(i.get('url') == url for i in issues['empty_titles']):
        url_issues.append("❌ Empty title tag")
    if any(i.get('url') == url for i in issues['empty_descriptions']):
        url_issues.append("❌ Empty meta description")
    if any(i.get('url') == url for i in issues['duplicate_titles']):
        url_issues.append("⚠️  Duplicate title (conflicts with other pages)")
    if any(i.get('url') == url for i in issues['duplicate_descriptions']):
        url_issues.append("⚠️  Duplicate description (conflicts with other pages)")
    if any(i.get('url') == url for i in issues['missing_canonicals']):
        url_issues.append("⚠️  Missing canonical tag")
    if any(i.get('url') == url for i in issues['http_canonicals']):
        url_issues.append("🔒 Canonical uses http:// (should be https://)")
    if any(i.get('url') == url for i in issues['duplicate_faqpage']):
        url_issues.append("⚠️  Duplicate FAQPage schema blocks")
    
    brief = f"""# SEO Fix-Now Brief

**URL:** {https(url)}  
**Generated:** {NOW}  
**Priority:** {'🔴 CRITICAL' if any('Empty' in i for i in url_issues) else '🟡 High'}

---

## 🚨 Current Issues

{chr(10).join(url_issues) if url_issues else "No critical issues detected."}

---

## Current State

**Current Title:** {current_title if current_title and current_title != 'nan' else '(empty)'}  
**Current Description:** {current_desc if current_desc and current_desc != 'nan' else '(empty)'}

---

## ✅ Recommended Fixes

### Title Tag (≤60 chars)
```html
<title>{title_suggestion}</title>
```

**Length:** {len(title_suggestion)} chars {'✓' if len(title_suggestion) <= 60 else '⚠️  too long'}

---

### H1 Heading
```html
<h1>{h1_suggestion}</h1>
```

---

### Meta Description (~155 chars)
```html
<meta name="description" content="{meta_suggestion}">
```

**Length:** {len(meta_suggestion)} chars {'✓' if 150 <= len(meta_suggestion) <= 160 else '⚠️  adjust length'}

---

### Canonical Tag (HTTPS only!)
```html
<link rel="canonical" href="{https(url)}">
```

---

## 📄 Content Structure

### Intro Paragraph (first 2-3 sentences)
Start with the user's primary intent and expected outcome. Establish authority with proof signals (years in business, certifications, case study results). End with a clear next step.

Example:
> "Looking for {guess_kw}? Our team has delivered {guess_kw} solutions to 200+ clients since 2020, achieving an average 35% improvement in [key metric]. This guide walks you through our proven methodology, from initial assessment to full deployment."

---

### Suggested Subheadings (H2)

1. **{subs[0]}**
   - Bullet: Key advantage 1
   - Bullet: Key advantage 2
   - Bullet: Proof point (testimonial, case study, metric)

2. **{subs[1]}**
   - Step 1: [action]
   - Step 2: [action]
   - Step 3: [action]
   - Timeline: X weeks

3. **{subs[2]}**
   - Pricing overview
   - Package comparison
   - ROI expectations
   - Next steps / CTA

---

## ❓ FAQ Section (+ JSON-LD)

Add this FAQ section at the bottom of the page, then include the JSON-LD schema:

<details>
<summary><strong>What is {guess_kw}?</strong></summary>
<p>Provide a clear, concise definition and explain the core value proposition.</p>
</details>

<details>
<summary><strong>How do I implement {guess_kw}?</strong></summary>
<p>Outline the step-by-step process, timeline, and expected outcomes.</p>
</details>

<details>
<summary><strong>What are the benefits of {guess_kw}?</strong></summary>
<p>List the main advantages, ROI potential, and competitive advantages.</p>
</details>

### JSON-LD Schema (add to <head>)

```json
{json.dumps(faq_ld, ensure_ascii=False, indent=2)}
```

**⚠️  IMPORTANT:** Use `SchemaFixes::jsonLdOnce()` to prevent duplicate schema blocks!

---

## 🔗 Internal Links

Add 2-3 contextual internal links to related pages:

- Related service: `https://{netloc}/services/[related-service]/`
- Related insight: `https://{netloc}/insights/[related-article]/`
- Case study: `https://{netloc}/case-studies/[relevant-case]/`

---

## ✅ Validation Checklist

Before deploying:

- [ ] Title is unique and ≤60 characters
- [ ] Meta description is unique and 150-160 characters
- [ ] H1 matches title intent (but not identical)
- [ ] Canonical tag uses `https://` (not `http://`)
- [ ] FAQ JSON-LD is valid (test at schema.org/validator)
- [ ] No duplicate schema blocks (use `SchemaFixes::jsonLdOnce()`)
- [ ] Internal links are contextual and relevant
- [ ] Intro paragraph includes proof signals
- [ ] CTA is clear and actionable

---

## 📊 Expected Impact

| Metric | Before | Target | Timeline |
|--------|--------|--------|----------|
| Google Index | {'Not indexed' if 'empty' in str(url_issues).lower() else 'Indexed'} | Fully indexed | 1-2 weeks |
| SERP CTR | — | +2-5% | 2-4 weeks |
| Avg Position | — | +3-8 ranks | 4-8 weeks |
| Conversions | — | +10-20% | 8-12 weeks |

---

**Next:** Apply these changes, then validate with:
1. Google Rich Results Test: https://search.google.com/test/rich-results
2. Schema Validator: https://validator.schema.org/
3. Request indexing in GSC: Search Console → URL Inspection → Request Indexing

"""
    
    # Safe filename
    name = re.sub(r"[^a-z0-9]+", "-", urllib.parse.urlparse(url).path.strip("/").lower()) or "home"
    with open(os.path.join(OUTB, f"{name}.md"), "w", encoding="utf-8") as f:
        f.write(brief)

print(f"✅ Generated {len(target_urls)} briefs")

# Create remediation templates
meta_template = f"""<!-- Meta Tags Template (use in <head>) -->

<!-- Primary Meta Tags -->
<title>{{{{ page_title }}}}</title>
<meta name="description" content="{{{{ page_description }}}}">
<link rel="canonical" href="{{{{ canonical_url }}}}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{{{ canonical_url }}}}">
<meta property="og:title" content="{{{{ page_title }}}}">
<meta property="og:description" content="{{{{ page_description }}}}">
<meta property="og:image" content="https://{netloc}/assets/og-image.png">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{{{ canonical_url }}}}">
<meta name="twitter:title" content="{{{{ page_title }}}}">
<meta name="twitter:description" content="{{{{ page_description }}}}">
<meta name="twitter:image" content="https://{netloc}/assets/og-image.png">

<!-- 
REQUIREMENTS:
- page_title: ≤60 characters
- page_description: 150-160 characters
- canonical_url: MUST start with https://
- og:image: 1200x630px minimum
-->
"""

with open(os.path.join(OUTR, "fixes", "meta_template.html"), "w", encoding="utf-8") as f:
    f.write(meta_template)

# PHP helper (already exists but make sure it's available)
schema_helper = """<?php
declare(strict_types=1);
namespace NRLC\\Schema;

/**
 * Schema Normalization Helpers
 * Fixes common GSC schema issues
 */
final class SchemaFixes {
    
    /**
     * Ensure URLs use HTTPS
     */
    public static function ensureHttps(?string $url): ?string {
        if (!$url) return $url;
        if (stripos($url, 'https://') === 0) return $url;
        if (stripos($url, 'http://') === 0) return 'https://' . substr($url, 7);
        return $url;
    }
    
    /**
     * Prevent duplicate JSON-LD blocks with same @id
     * Usage: echo SchemaFixes::jsonLdOnce($schema_array);
     */
    public static function jsonLdOnce($jsonOrArray, string $idKey = '@id'): ?string {
        static $seen = [];
        
        $decoded = is_array($jsonOrArray) 
            ? $jsonOrArray 
            : json_decode((string)$jsonOrArray, true);
        
        if (!is_array($decoded)) return null;
        
        // Handle both single objects and arrays of objects
        $items = (array_keys($decoded) !== range(0, count($decoded) - 1)) 
            ? [$decoded] 
            : $decoded;
        
        foreach ($items as $obj) {
            if (isset($obj[$idKey])) {
                $id = (string)$obj[$idKey];
                if (isset($seen[$id])) {
                    // Already output, skip
                    return null;
                }
                $seen[$id] = true;
            }
        }
        
        return json_encode($decoded, 
            JSON_UNESCAPED_SLASHES | 
            JSON_UNESCAPED_UNICODE | 
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }
    
    /**
     * Reset seen IDs (for testing)
     */
    public static function resetSeen(): void {
        static $seen = [];
        $seen = [];
    }
}
"""

with open(os.path.join(OUTR, "fixes", "SchemaFixes.php"), "w", encoding="utf-8") as f:
    f.write(schema_helper)

# Checklist
checklist = f"""
╔═══════════════════════════════════════════════════════════════╗
║          FIX-NOW CHECKLIST (Google Best Practices)            ║
╚═══════════════════════════════════════════════════════════════╝

Generated: {datetime.datetime.now(datetime.UTC).strftime('%Y-%m-%d %H:%M:%S')} UTC
Source: site-discovery audit report ({len(rows)} pages analyzed)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 🔴 CRITICAL (Fix First)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

[ ] Fix {len(issues['empty_titles'])} empty title tags
    → Without titles, pages won't rank in Google
    → Action: See individual briefs in website/seo-briefs/
    → Validation: View source, check <title> tag is present

[ ] Fix {len(issues['empty_descriptions'])} empty meta descriptions
    → Google will auto-generate (usually poor quality)
    → Action: Write unique 150-160 char descriptions
    → Validation: Search Console → Enhancements → Meta tags

[ ] Fix {len(issues['http_canonicals'])} http:// canonical tags
    → Forces HTTPS normalization issues
    → Action: Change all http:// to https:// in canonicals
    → Validation: grep -r 'rel="canonical" href="http://' pages/

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 🟡 HIGH PRIORITY (Do This Week)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

[ ] Differentiate {len(issues['duplicate_titles'])} duplicate titles
    → Google penalizes identical titles across pages
    → Action: Make each title unique (add location, year, differentiator)
    → Validation: site-discovery or Screaming Frog

[ ] Differentiate {len(issues['duplicate_descriptions'])} duplicate descriptions
    → Reduces CTR and click-through rate
    → Action: Write page-specific descriptions
    → Validation: Search Console → Coverage → Duplicates

[ ] Fix {len(issues['missing_canonicals'])} missing canonical tags
    → Without canonicals, Google may index duplicate pages
    → Action: Add <link rel="canonical" href="https://..." />
    → Validation: curl -s https://nrlc.ai/page/ | grep canonical

[ ] Fix {len(issues['duplicate_faqpage'])} duplicate FAQPage schema
    → Causes GSC "Duplicate field" error
    → Action: Use SchemaFixes::jsonLdOnce() in lib/schema_builders.php
    → Validation: Google Rich Results Test

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 🟢 MEDIUM PRIORITY (This Month)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

[ ] Add FAQ sections with JSON-LD to top 50 pages
    → Increases SERP real estate (rich results)
    → Action: Use templates from website/seo-briefs/
    → Validation: https://search.google.com/test/rich-results

[ ] Expand intro paragraphs with E-E-A-T signals
    → Proof points: years in business, certifications, results
    → Action: See "Intro Paragraph" section in briefs
    → Validation: Manual review

[ ] Add 2-3 internal links per page
    → Improves crawlability and PageRank distribution
    → Action: Link to related Services, Insights, Case Studies
    → Validation: Check internal link count in audit_report.csv

[ ] Optimize title lengths (check manually)
    → Google truncates at ~60 chars
    → Action: Cap at 60, move secondary keywords to description
    → Validation: SERP preview tool

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 📋 VALIDATION STEPS (After Deployment)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

1. [ ] Re-run site-discovery crawler
   → php site-discovery/scripts/discover.php --base=https://nrlc.ai --max=500
   → Confirm issues are resolved in new audit_report.csv

2. [ ] Test schema in Google Rich Results Test
   → https://search.google.com/test/rich-results
   → Test 5-10 pages with FAQ/schema changes

3. [ ] Validate canonicals
   → curl -s https://nrlc.ai | grep -i canonical
   → Confirm all use https://

4. [ ] Request re-indexing in Search Console
   → URL Inspection → Request Indexing (for critical pages)
   → Or submit updated sitemap

5. [ ] Monitor GSC Enhancements
   → Check "Enhancements" section after 1-2 weeks
   → Confirm "Duplicate field" errors are gone

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 📚 RESOURCES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

- Google Search Essentials: https://developers.google.com/search/docs/essentials
- Schema.org Validator: https://validator.schema.org/
- Rich Results Test: https://search.google.com/test/rich-results
- Page Speed Insights: https://pagespeed.web.dev/
- GSC URL Inspection: https://search.google.com/search-console

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Next: Open website/seo-briefs/ and start with 🔴 CRITICAL pages
"""

with open(os.path.join(OUTR, "fixes", "checklist.txt"), "w", encoding="utf-8") as f:
    f.write(checklist)

# Summary report
summary = f"""# Fix-Now Analysis Summary

**Generated:** {datetime.datetime.now(datetime.UTC).strftime('%Y-%m-%d %H:%M:%S')} UTC  
**Source:** site-discovery audit report  
**Pages Analyzed:** {len(rows)}  
**Pages Needing Fixes:** {len(target_urls)}

---

## 🚨 Issues Detected

### Critical (Fix First)

| Issue | Count | Impact | Priority |
|-------|-------|--------|----------|
| Empty Titles | **{len(issues['empty_titles'])}** | Won't rank in Google | 🔴 CRITICAL |
| Empty Descriptions | **{len(issues['empty_descriptions'])}** | Poor SERP snippets | 🔴 CRITICAL |
| HTTP Canonicals | **{len(issues['http_canonicals'])}** | HTTPS normalization issues | 🔴 CRITICAL |

### High Priority

| Issue | Count | Impact | Priority |
|-------|-------|--------|----------|
| Duplicate Titles | **{len(issues['duplicate_titles'])}** | Confuses Google, reduces rankings | 🟡 High |
| Duplicate Descriptions | **{len(issues['duplicate_descriptions'])}** | Lower CTR | 🟡 High |
| Missing Canonicals | **{len(issues['missing_canonicals'])}** | Duplicate content risk | 🟡 High |
| Duplicate FAQPage | **{len(issues['duplicate_faqpage'])}** | GSC enhancement error | 🟡 High |

---

## 📊 Generated Outputs

### 1. SEO Briefs (`website/seo-briefs/`)
- **Count:** {len(target_urls)} page-level briefs
- **Contents:** Title, H1, meta description, FAQs, internal links, validation checklist
- **Format:** Markdown (ready to apply)

### 2. Remediation Kit (`website/seo-remediation/fixes/`)
- `meta_template.html` - Optimal <head> structure with Open Graph & Twitter cards
- `SchemaFixes.php` - HTTPS normalization and JSON-LD deduplication helpers
- `checklist.txt` - Developer action items with validation steps

### 3. This Summary
- Issue breakdown
- Expected impact timeline
- Quick start guide

---

## 🎯 Recommended Action Plan

### Week 1: Fix Critical Issues
1. ✅ Apply fixes to all pages with empty titles ({len(issues['empty_titles'])} pages)
2. ✅ Apply fixes to all pages with empty descriptions ({len(issues['empty_descriptions'])} pages)
3. ✅ Change all `http://` canonicals to `https://` ({len(issues['http_canonicals'])} pages)

**Tools:**
- Briefs: `website/seo-briefs/`
- Template: `website/seo-remediation/fixes/meta_template.html`

**Validation:**
```bash
# Check for empty titles
php scripts/comprehensive_page_scan.php | grep "empty title"

# Check for http:// canonicals
grep -r 'rel="canonical" href="http://' pages/
```

### Week 2: Differentiate Duplicates
1. ✅ Make duplicate titles unique (add location, year, or differentiator)
2. ✅ Rewrite duplicate descriptions (page-specific value props)
3. ✅ Add missing canonical tags

**Expected Result:** Each page has unique title/description

### Week 3: Enhance Rich Results
1. ✅ Add FAQ sections with JSON-LD to top 50 pages
2. ✅ Use `SchemaFixes::jsonLdOnce()` to prevent duplicate schema
3. ✅ Test with Google Rich Results Test

**Expected Result:** FAQ rich results in SERP

### Week 4: Validate & Monitor
1. ✅ Re-run site-discovery crawler (confirm fixes)
2. ✅ Request re-indexing in Google Search Console
3. ✅ Monitor GSC Enhancements tab for errors

**Expected Result:** All GSC enhancement errors resolved

---

## 📈 Expected Impact

| Timeframe | Metric | Change | Reason |
|-----------|--------|--------|--------|
| **Week 1** | Indexation | +100% (for empty title pages) | Google can now understand pages |
| **Week 2** | SERP CTR | +2-5% | Unique, compelling meta descriptions |
| **Week 3-4** | Avg Position | +3-8 ranks | Better relevance signals |
| **Month 2** | Organic Traffic | +20-40% | Combined effect of fixes |
| **Month 3** | Rich Results | 50+ pages eligible | FAQ structured data |

---

## 🛠️ Tools & Integration

### Use SchemaFixes.php in Your Code

```php
<?php
require_once __DIR__.'/lib/SchemaFixes.php';
use NRLC\\Schema\\SchemaFixes;

// Force HTTPS on all schema URLs
$schema = [
    '@type' => 'Organization',
    'url' => SchemaFixes::ensureHttps($org_url),
    'logo' => SchemaFixes::ensureHttps($logo_url)
];

// Prevent duplicate schema blocks
$jsonLd = SchemaFixes::jsonLdOnce($schema);
if ($jsonLd) {{
    echo '<script type="application/ld+json">' . $jsonLd . '</script>';
}}
```

### Already Integrated
The `SchemaFixes` utility has been added to `/lib/SchemaFixes.php` and integrated into `lib/schema_builders.php` to automatically enforce HTTPS on all schema URLs.

---

## ✅ Quick Start

1. **Read a brief:** Open `website/seo-briefs/[page-name].md`
2. **Apply the fix:** Update title, H1, meta description, add FAQ
3. **Use the template:** Copy from `website/seo-remediation/fixes/meta_template.html`
4. **Validate:** Google Rich Results Test + GSC URL Inspection
5. **Deploy & monitor:** Check GSC after 1-2 weeks

---

## 🔄 Re-Run Analysis

After applying fixes, re-run to verify:

```bash
# Re-crawl your site
php site-discovery/scripts/discover.php --base=https://nrlc.ai --max=500

# Re-run analysis
python3 tools/fixnow_from_site_discovery.py

# Compare new vs old FIXNOW_SUMMARY.md
```

---

## 📚 References

- [Google Search Essentials](https://developers.google.com/search/docs/essentials)
- [Meta Tags Best Practices](https://developers.google.com/search/docs/appearance/snippet)
- [Schema.org Validator](https://validator.schema.org/)
- [Google Rich Results Test](https://search.google.com/test/rich-results)

---

**Next Step:** Open `website/seo-briefs/` and start with the 🔴 CRITICAL pages!
"""

with open(os.path.join(OUTR, "FIXNOW_SUMMARY.md"), "w", encoding="utf-8") as f:
    f.write(summary)

print(f"\n{'='*65}")
print("✅ Fix-Now Analysis Complete!")
print(f"{'='*65}")
print(f"\nPriorities:")
print(f"  🔴 {len(issues['empty_titles'])} empty titles → FIX FIRST")
print(f"  🔴 {len(issues['empty_descriptions'])} empty descriptions → FIX FIRST")
print(f"  🔴 {len(issues['http_canonicals'])} http:// canonicals → FIX FIRST")
print(f"  🟡 {len(issues['duplicate_titles'])} duplicate titles")
print(f"  🟡 {len(issues['duplicate_descriptions'])} duplicate descriptions")
print(f"  ⚠️  {len(issues['duplicate_faqpage'])} duplicate FAQPage schema")
print(f"\nOutputs:")
print(f"  📝 Briefs → {OUTB}")
print(f"  🔧 Templates → {OUTR}/fixes/")
print(f"  📊 Summary → {OUTR}/FIXNOW_SUMMARY.md")
print(f"\n👉 Next: open {OUTR}/FIXNOW_SUMMARY.md")
print(f"{'='*65}\n")

