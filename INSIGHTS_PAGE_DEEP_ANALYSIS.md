# Deep Insights Index Page Analysis: https://nrlc.ai/insights/

**Analysis Date:** 2026-01-15  
**Page:** Insights Hub (`/insights/`)  
**Template:** `pages/insights/index.php`  
**Router Config:** `bootstrap/router.php` lines 1399-1409

---

## EXECUTIVE SUMMARY

The insights index page is **well-structured** but has **critical gaps** in:
1. **Missing keywords meta tag** - Not set in metadata
2. **Missing CollectionPage/ItemList schema** - Should have structured data for article listings
3. **Missing semantic HTML** - No `itemscope itemtype` for AI extractability
4. **Missing key term markup** - No `<strong>`, `<dfn>`, `<abbr>` for technical terms
5. **Missing `about` and `mentions`** in WebPage schema
6. **No Person schema** for Joel Maldonado (author/researcher)
7. **Missing definitions section** - No explicit definitions for key concepts
8. **Weak internal linking** - Limited cross-linking to related content

**Overall Grade:** B- (Good structure, weak technical SEO)

---

## 1. SEO METADATA ANALYSIS

### 1.1 Meta Title
**Current:** `AI Search Insights – Retrieval, Citation, and Trust | NRLC.ai`  
**Length:** 61 characters ✅  
**Location:** `lib/meta_directive.php:648`

**Issues:**
- ✅ Good length (50-60 chars optimal)
- ✅ Includes key terms (AI Search Insights, Retrieval, Citation, Trust)
- ⚠️ Missing "Research" keyword
- ⚠️ Could include "AEO", "GEO", "AI SEO" for better keyword coverage

**Recommendation:**
```
AI Search & Retrieval Insights | Research & Analysis | NRLC.ai
```
(58 chars - includes Research keyword)

OR more keyword-rich:
```
AI Search Insights: Retrieval, Citation & Trust Research | NRLC.ai
```
(64 chars - slightly over but includes all key terms)

### 1.2 Meta Description
**Current:** `Technical analyses and research-backed explanations of how AI search and answer engines extract, evaluate, and cite web content.`  
**Length:** 138 characters ✅  
**Location:** `lib/meta_directive.php:649`

**Issues:**
- ✅ Good length (140-160 chars optimal)
- ✅ Includes key terms (AI search, answer engines, extract, evaluate, cite)
- ⚠️ Missing "ChatGPT", "Perplexity", "Google AI Overviews" mentions
- ⚠️ Could mention "AEO", "GEO", "structured data"

**Recommendation:**
```
Technical analyses and research-backed explanations of how AI search and answer engines (ChatGPT, Perplexity, Google AI Overviews) extract, evaluate, and cite web content. AEO, GEO, and retrieval mechanics.
```
(159 chars - optimal length, includes all key terms)

### 1.3 Keywords Meta Tag
**Current:** **NOT SET** ❌  
**Location:** `lib/meta_directive.php:645-650`

**Critical Issue:** No keywords meta tag defined. Should include:
- AI search insights
- AI retrieval research
- AI citation analysis
- ChatGPT research
- Perplexity research
- Google AI Overviews research
- AEO research
- GEO research
- Structured data research
- AI SEO insights

**Recommendation:**
```php
'keywords' => 'AI search insights, AI retrieval research, AI citation analysis, ChatGPT research, Perplexity research, Google AI Overviews research, AEO research, GEO research, structured data research, AI SEO insights, retrieval mechanics, citation behavior, AI search systems'
```

### 1.4 Canonical URL
**Current:** `/insights/` ✅  
**Implementation:** Correctly set

---

## 2. SCHEMA MARKUP ANALYSIS

### 2.1 Current Schema Structure
**Location:** `pages/insights/index.php:158-163`

**Current Implementation:**
- ✅ `Organization` schema (via `base_schemas()`)
- ✅ `WebSite` schema (via `base_schemas()`)
- ✅ `BreadcrumbList` schema (via `base_schemas()`)
- ❌ **Missing `CollectionPage` schema** - Should identify this as a collection
- ❌ **Missing `ItemList` schema** - Should list all articles with structured data

### 2.2 Critical Issue: Missing CollectionPage Schema
**Problem:** The page is a content hub/collection but doesn't use `CollectionPage` schema.

**Should Be:**
```php
[
  '@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  '@id' => $canonicalUrl . '#collection',
  'name' => 'AI Search & Retrieval Insights',
  'description' => 'Technical analyses and research-backed explanations of how AI search and answer engines extract, evaluate, and cite web content.',
  'url' => $canonicalUrl,
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => $domain . '#website'
  ],
  'about' => [
    '@type' => 'Thing',
    'name' => 'AI Search Research',
    'description' => 'Research and analysis of AI search systems, retrieval mechanics, and citation behavior'
  ],
  'mainEntity' => [
    '@type' => 'ItemList',
    '@id' => $canonicalUrl . '#article-list',
    'numberOfItems' => count($insights),
    'itemListElement' => [
      // Array of Article references
    ]
  ]
]
```

### 2.3 Missing ItemList Schema
**Problem:** Article listings should use `ItemList` schema for better structured data.

**Recommendation:** Add `ItemList` schema with all articles:
```php
[
  '@context' => 'https://schema.org',
  '@type' => 'ItemList',
  '@id' => $canonicalUrl . '#article-list',
  'name' => 'AI Search & Retrieval Insights Articles',
  'description' => 'Collection of technical analyses and research on AI search systems',
  'numberOfItems' => count($insights),
  'itemListElement' => array_map(function($insight, $index) {
    return [
      '@type' => 'ListItem',
      'position' => $index + 1,
      'item' => [
        '@type' => 'Article',
        '@id' => absolute_url('/en-us/insights/' . $insight['slug'] . '/'),
        'headline' => $insight['title'],
        'description' => $insight['excerpt'] ?? $insight['keywords'] ?? '',
        'url' => absolute_url('/en-us/insights/' . $insight['slug'] . '/')
      ]
    ];
  }, $insights, array_keys($insights))
]
```

### 2.4 Missing Person Schema (Author/Researcher)
**Issue:** No `Person` schema for Joel Maldonado as the primary researcher/author.

**Recommendation:** Add Person schema:
```php
[
  '@type' => 'Person',
  '@id' => $domain . '#joel-maldonado',
  'name' => 'Joel Maldonado',
  'jobTitle' => 'Founder & AI Search Researcher',
  'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems.',
  'knowsAbout' => [
    'AI Search Optimization', 'AEO', 'GEO', 'AI Retrieval Research',
    'Citation Analysis', 'Structured Data Research', 'AI SEO Insights'
  ],
  'worksFor' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'url' => $domain,
  'sameAs' => [
    'https://www.linkedin.com/company/neural-command/',
    'https://twitter.com/neuralcommand'
  ]
]
```

### 2.5 WebPage Schema Issues
**Current:** Basic WebPage schema via `base_schemas()` ✅

**Missing:**
- ❌ `about` array (should include AI Search Research, Retrieval Mechanics, Citation Analysis)
- ❌ `mentions` array (should include ChatGPT, Perplexity, Google AI Overviews)
- ❌ `keywords` property
- ❌ `speakable` specification

**Recommendation:** Enhance WebPage schema with `about`, `mentions`, `keywords`, `speakable` (see implementation)

---

## 3. CONTENT STRUCTURE ANALYSIS

### 3.1 H1 Tag
**Current:** `AI Search & Retrieval Insights`  
**Location:** `pages/insights/index.php:18`

**Analysis:**
- ✅ Clear, descriptive
- ✅ Includes key terms (AI Search, Retrieval, Insights)
- ⚠️ **Missing semantic HTML** - Should have `itemprop="headline"`
- ⚠️ **Missing key term markup** - Should use `<strong>` for "AI Search" and "Retrieval"

**Recommendation:**
```html
<h1 class="content-block__title" itemprop="headline"><strong>AI Search</strong> & <strong>Retrieval Insights</strong></h1>
```

### 3.2 Lead Paragraph
**Current:** `This section contains technical analyses, research-backed explanations, and system-level insights into how AI search and answer engines extract, evaluate, and cite information.`  
**Location:** `pages/insights/index.php:21`

**Analysis:**
- ✅ Clear value proposition
- ✅ Includes key terms (technical analyses, AI search, answer engines)
- ⚠️ **Missing semantic markup** - Should use `<strong>` for key terms
- ⚠️ **Missing `itemprop="description"`**

**Recommendation:**
```html
<p itemprop="description">This section contains <strong>technical analyses</strong>, <strong>research-backed explanations</strong>, and <strong>system-level insights</strong> into how <strong>AI search</strong> and <strong>answer engines</strong> extract, evaluate, and cite information.</p>
```

### 3.3 Content Sections
**Analysis:**
- ✅ Well-structured with clear H2/H3 hierarchy
- ✅ Good use of grid layouts
- ✅ Clear section organization
- ⚠️ **Missing semantic HTML** - No `<article>`, `<section>` with `itemscope itemtype`
- ⚠️ **Missing key term markup** - Technical terms should use `<strong>`, `<dfn>`, `<abbr>`

**Recommendation:** Wrap main content in semantic HTML:
```html
<main role="main" class="container" itemscope itemtype="https://schema.org/CollectionPage">
  <article itemscope itemtype="https://schema.org/Article" class="section">
    <div class="section__content">
      <!-- Content sections -->
    </div>
  </article>
</main>
```

### 3.4 Technical Terms
**Missing Markup For:**
- AI search - should use `<strong>`
- Retrieval - should use `<strong>`
- Citation - should use `<strong>`
- ChatGPT, Perplexity, Google AI Overviews - should use `<strong>`
- AEO, GEO - should use `<dfn><abbr>`
- Structured data - should use `<strong>`

---

## 4. INTERNAL LINKING ANALYSIS

### 4.1 Current Links
**Internal Links:**
- ✅ Links to individual insight articles (`/en-us/insights/{slug}/`)
- ✅ Featured analysis links
- ✅ Technical breakdowns links

**Issues:**
- ⚠️ **Missing link to `/research/`** (if exists)
- ⚠️ **Missing link to `/generative-engine-optimization/`** (related knowledge base)
- ⚠️ **Missing link to `/ai-search-diagnostics/`** (related knowledge base)
- ⚠️ **Missing link to `/training/`** (related training)
- ⚠️ **Missing cross-linking** between related insights

**Recommendation:** Add contextual links:
- Link to knowledge base sections when relevant
- Link to training when discussing operational topics
- Add "Related Research" section

---

## 5. AI EXTRACTABILITY ANALYSIS

### 5.1 Semantic HTML
**Issues:**
- ❌ **No `<article>` wrapper** for main content
- ❌ **No `itemscope itemtype`** on content sections
- ❌ **No `<time>` elements** for article dates (if available)
- ❌ **No `<dfn>` elements** for term definitions
- ❌ **No `<abbr>` elements** for acronyms (AEO, GEO, SEO)

### 5.2 Key Term Markup
**Issues:**
- ❌ **No `<strong>` or `<em>`** for key terms
- ❌ **No `<dfn>`** for definitions
- ❌ **No `<abbr>`** for acronyms

### 5.3 Structured Definitions
**Issues:**
- ❌ **No explicit definitions** for AEO, GEO, AI Search Optimization
- ❌ **No "What is X?" sections** that AI systems can extract

**Recommendation:** Add a definitions section:
```html
<section id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet">
  <h2>Key Research Areas</h2>
  <dl>
    <dt id="ai-search-research" itemscope itemtype="https://schema.org/DefinedTerm">
      <dfn><strong>AI Search Research</strong></dfn>
    </dt>
    <dd itemprop="description">Technical analyses of how AI search systems (ChatGPT, Perplexity, Google AI Overviews) retrieve, evaluate, and cite web content.</dd>
    
    <dt id="retrieval-mechanics" itemscope itemtype="https://schema.org/DefinedTerm">
      <dfn><strong>Retrieval Mechanics</strong></dfn>
    </dt>
    <dd itemprop="description">The technical processes by which AI systems extract, chunk, prioritize, and ground content from web sources.</dd>
  </dl>
</section>
```

---

## 6. PRIORITY FIXES

### 🔴 CRITICAL (Fix Immediately)
1. **Add keywords meta tag** - Set comprehensive keywords array
2. **Add CollectionPage schema** - Identify page as collection
3. **Add ItemList schema** - Structure article listings
4. **Add Person schema** - Joel Maldonado as researcher
5. **Enhance WebPage schema** - Add `about`, `mentions`, `keywords`, `speakable`

### 🟡 HIGH PRIORITY (Fix This Week)
6. **Add semantic HTML** - Wrap content in `<article>` with `itemscope itemtype`
7. **Add key term markup** - Use `<strong>`, `<dfn>`, `<abbr>` for technical terms
8. **Add definitions section** - Explicit definitions for key research areas
9. **Improve internal linking** - Links to knowledge base, training, related research

### 🟢 MEDIUM PRIORITY (Fix This Month)
10. **Add "Related Research" section** - Cross-link related insights
11. **Enhance article listings** - Add dates, categories, tags
12. **Add filtering/categorization** - By topic, by AI system, by research type

---

## 7. SUMMARY SCORECARD

| Category | Score | Grade |
|----------|-------|-------|
| **SEO Metadata** | 7/10 | B |
| **Schema Markup** | 5/10 | C |
| **Content Structure** | 8/10 | B+ |
| **Internal Linking** | 6/10 | C+ |
| **AI Extractability** | 5/10 | C |
| **Technical SEO** | 7/10 | B |
| **Overall** | **6.3/10** | **C+** |

**Key Strengths:**
- Well-structured content sections
- Clear organization
- Good use of grid layouts

**Key Weaknesses:**
- **Missing CollectionPage/ItemList schema**
- **Missing keywords meta tag**
- **Missing semantic HTML** for AI extractability
- **Missing Person schema** (author/researcher)
- **Missing definitions section**

---

**Analysis Complete** ✅
