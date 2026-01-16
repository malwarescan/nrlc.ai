# Deep Homepage Analysis: https://nrlc.ai/

**Analysis Date:** 2026-01-15  
**Page:** Homepage (`/`)  
**Template:** `pages/home/home.php`  
**Router Config:** `bootstrap/router.php` lines 161-239

---

## EXECUTIVE SUMMARY

The homepage is **well-structured** with strong schema markup, but has **critical gaps** in:
1. **Meta title/description alignment** with actual content
2. **Missing semantic HTML** for AI extractability
3. **Incomplete Person schema** (missing `sameAs` social links)
4. **No `Article` schema** despite authoritative content
5. **Weak internal linking** to key conversion pages
6. **Missing `about` and `mentions`** in WebPage schema
7. **No `keywords` meta tag** (despite router setting it)
8. **Open Graph image** is too small (43x43px logo)

**Overall Grade:** B+ (Strong foundation, needs refinement)

---

## 1. SEO METADATA ANALYSIS

### 1.1 Meta Title
**Current:** `Joel Maldonado | SEO, AEO, GEO & AI Search Research`  
**Length:** 55 characters ✅  
**Router Config:** `bootstrap/router.php:177`

**Issues:**
- ✅ Good length (50-60 chars optimal)
- ✅ Includes target keywords (Joel Maldonado, SEO, AEO, GEO, AI Search)
- ⚠️ Missing "Research & Implementation" from H1
- ⚠️ No brand name "NRLC.ai" or "Neural Command" (could help brand recognition)

**Recommendation:**
```
Joel Maldonado: SEO, AEO, GEO Research & Implementation | NRLC.ai
```
(68 chars - slightly over, but includes brand and matches H1)

### 1.2 Meta Description
**Current:** `Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. On the bleeding edge of search, retrieval, citations, and extractability.`  
**Length:** 163 characters ✅  
**Router Config:** `bootstrap/router.php:178`

**Issues:**
- ✅ Good length (140-160 chars optimal)
- ✅ Includes key terms (SEO, AEO, GEO, AI search)
- ⚠️ Doesn't match the actual homepage content (mentions "bleeding edge" but homepage focuses on "knowledge base")
- ⚠️ Missing call-to-action or value proposition
- ⚠️ Doesn't mention "AI visibility" or "AI citations" which are core services

**Recommendation:**
```
Joel Maldonado researches and implements SEO, AEO, and GEO for AI search systems. Knowledge base documenting AI visibility, retrieval, citations, and extractability. Neural Command, LLC.
```
(165 chars - slightly over, but more aligned with content)

### 1.3 Keywords Meta Tag
**Current:** Set in router (`bootstrap/router.php:179`) but **NOT OUTPUT** in `templates/head.php`  
**Router Value:** `Joel Maldonado, SEO, AEO, GEO, AI Search, AI Search Optimization, Generative Engine Optimization, LLM Seeding, Structured Data, AI Citations, Search Retrieval`

**Critical Issue:** Keywords are set but never rendered in HTML `<head>`

**Fix Required:** Add to `templates/head.php`:
```php
<?php if (!empty($customKeywords)): ?>
<meta name="keywords" content="<?= htmlspecialchars(is_array($customKeywords) ? implode(', ', $customKeywords) : $customKeywords) ?>">
<?php endif; ?>
```

### 1.4 Canonical URL
**Current:** `/` ✅  
**Implementation:** Correctly set in router and head.php

---

## 2. SCHEMA MARKUP ANALYSIS

### 2.1 Person Schema (Joel Maldonado)
**Location:** `pages/home/home.php:288-314`  
**Type:** `@graph` within JSON-LD ✅

**Strengths:**
- ✅ Proper `@id` with fragment identifier
- ✅ `givenName` and `familyName` separated
- ✅ `jobTitle`: "Founder & AI Search Researcher"
- ✅ `description` includes key terms
- ✅ `knowsAbout` array with 10 topics
- ✅ `worksFor` and `affiliation` references Organization
- ✅ `url` points to homepage

**Critical Issues:**
- ❌ **`sameAs` only has LinkedIn** - Missing:
  - Twitter/X handle
  - GitHub (if applicable)
  - Personal website/blog
  - Other professional profiles
- ❌ **`image` points to logo** (43x43px) - Should be actual headshot or professional photo
- ⚠️ **Missing `email`** (if public)
- ⚠️ **Missing `alumniOf`** (if applicable)
- ⚠️ **Missing `award`** or `honorificSuffix` (if applicable)

**Recommendation:**
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/#joel-maldonado",
  "name": "Joel Maldonado",
  "givenName": "Joel",
  "familyName": "Maldonado",
  "jobTitle": "Founder & AI Search Researcher",
  "description": "Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Founder of Neural Command, LLC, specializing in search, retrieval, citations, and extractability for AI-powered search engines.",
  "knowsAbout": [
    "SEO", "AEO", "GEO", "AI Search", "Search Retrieval", 
    "AI Citations", "Extractability", "Generative Engine Optimization", 
    "LLM Seeding", "Structured Data", "Schema Markup", "Entity Mapping"
  ],
  "worksFor": {
    "@type": "Organization",
    "@id": "https://nrlc.ai/#neural-command"
  },
  "affiliation": {
    "@type": "Organization",
    "@id": "https://nrlc.ai/#neural-command"
  },
  "url": "https://nrlc.ai",
  "image": {
    "@type": "ImageObject",
    "url": "https://nrlc.ai/assets/images/joel-maldonado.jpg",
    "width": 400,
    "height": 400
  },
  "sameAs": [
    "https://www.linkedin.com/company/neural-command/",
    "https://twitter.com/neuralcommand",
    "https://github.com/neuralcommand",
    "https://www.crunchbase.com/person/joel-maldonado"
  ]
}
```

### 2.2 Organization Schema (Neural Command)
**Location:** `pages/home/home.php:315-346`  
**Type:** `@graph` within JSON-LD ✅

**Strengths:**
- ✅ `legalName` specified
- ✅ `logo` with dimensions
- ✅ `founder` references Person
- ✅ `knowsAbout` array
- ✅ `areaServed`: "Worldwide"
- ✅ `sameAs` includes LinkedIn

**Issues:**
- ⚠️ **Missing `address`** (physical location)
- ⚠️ **Missing `contactPoint`** (phone, email)
- ⚠️ **Missing `foundingDate`**
- ⚠️ **Missing `numberOfEmployees`** (if applicable)
- ⚠️ **Missing `slogan`** or `tagline`
- ⚠️ **`sameAs` only has LinkedIn** - Missing:
  - Twitter/X
  - Facebook
  - Crunchbase
  - Google Business Profile

**Recommendation:**
```json
{
  "@type": "Organization",
  "@id": "https://nrlc.ai/#neural-command",
  "name": "Neural Command, LLC",
  "legalName": "Neural Command, LLC",
  "url": "https://nrlc.ai",
  "logo": {
    "@type": "ImageObject",
    "url": "https://nrlc.ai/assets/images/nrlc-logo.png",
    "width": 43,
    "height": 43
  },
  "founder": {
    "@type": "Person",
    "@id": "https://nrlc.ai/#joel-maldonado"
  },
  "foundingDate": "2020",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "1639 11th St suite 110-a",
    "addressLocality": "Santa Monica",
    "addressRegion": "CA",
    "postalCode": "90404",
    "addressCountry": "US"
  },
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+1-844-568-4624",
    "contactType": "customer service",
    "areaServed": "US",
    "availableLanguage": "en"
  },
  "knowsAbout": [
    "AI Search Optimization", "AEO", "GEO", "SEO", "LLM Seeding",
    "Structured Data", "AI Citations", "Search Retrieval", "Extractability"
  ],
  "areaServed": "Worldwide",
  "sameAs": [
    "https://www.linkedin.com/company/neural-command/",
    "https://twitter.com/neuralcommand",
    "https://www.crunchbase.com/organization/neural-command"
  ]
}
```

### 2.3 WebPage Schema
**Location:** `pages/home/home.php:347-389`  
**Type:** `@graph` within JSON-LD ✅

**Strengths:**
- ✅ `name` and `description` from page meta
- ✅ `inLanguage`: "en-US"
- ✅ `datePublished` and `dateModified`
- ✅ `about` references Person
- ✅ `author` and `publisher` references
- ✅ `primaryImageOfPage`
- ✅ `isPartOf` references WebSite
- ✅ `breadcrumb` with BreadcrumbList

**Critical Issues:**
- ❌ **Missing `about` array** - Should include:
  - AI Search Optimization
  - AEO
  - GEO
  - AI Visibility
  - Knowledge Base
- ❌ **Missing `mentions`** - Should include:
  - ChatGPT
  - Google AI Overviews
  - Claude
  - Perplexity
  - AI systems
- ⚠️ **`datePublished` is hardcoded** to "2020-01-01" (should be actual founding date)
- ⚠️ **Missing `keywords`** (despite router setting it)
- ⚠️ **Missing `speakable`** specification for voice search

**Recommendation:**
```json
{
  "@type": "WebPage",
  "@id": "https://nrlc.ai/#webpage",
  "url": "https://nrlc.ai",
  "name": "Joel Maldonado | SEO, AEO, GEO & AI Search Research",
  "description": "Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems.",
  "inLanguage": "en-US",
  "datePublished": "2020-01-01",
  "dateModified": "2026-01-15",
  "keywords": "Joel Maldonado, SEO, AEO, GEO, AI Search, AI Search Optimization, Generative Engine Optimization, LLM Seeding, Structured Data, AI Citations, Search Retrieval",
  "about": [
    {
      "@type": "Thing",
      "name": "AI Search Optimization",
      "description": "The practice of optimizing content and structured data for AI-powered search engines"
    },
    {
      "@type": "Thing",
      "name": "AEO",
      "description": "Answer Engine Optimization - optimizing content for AI answer engines"
    },
    {
      "@type": "Thing",
      "name": "GEO",
      "description": "Generative Engine Optimization - optimizing content for generative AI systems"
    }
  ],
  "mentions": [
    {
      "@type": "SoftwareApplication",
      "name": "ChatGPT",
      "description": "AI language model by OpenAI"
    },
    {
      "@type": "SoftwareApplication",
      "name": "Google AI Overviews",
      "description": "Google's AI-powered search overview feature"
    },
    {
      "@type": "SoftwareApplication",
      "name": "Claude",
      "description": "AI language model by Anthropic"
    }
  ],
  "about": {
    "@type": "Person",
    "@id": "https://nrlc.ai/#joel-maldonado"
  },
  "author": {
    "@type": "Person",
    "@id": "https://nrlc.ai/#joel-maldonado"
  },
  "publisher": {
    "@type": "Organization",
    "@id": "https://nrlc.ai/#neural-command"
  },
  "primaryImageOfPage": {
    "@type": "ImageObject",
    "url": "https://nrlc.ai/assets/images/nrlc-logo.png",
    "width": 43,
    "height": 43
  },
  "isPartOf": {
    "@type": "WebSite",
    "@id": "https://nrlc.ai/#website"
  },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://nrlc.ai"
      }
    ]
  },
  "speakable": {
    "@type": "SpeakableSpecification",
    "cssSelector": ["h1", ".lead"]
  }
}
```

### 2.4 WebSite Schema
**Location:** `pages/home/home.php:390-408`  
**Type:** `@graph` within JSON-LD ✅

**Strengths:**
- ✅ `name`: "Neural Command"
- ✅ `inLanguage`: "en-US"
- ✅ `publisher` references Organization
- ✅ `potentialAction` with SearchAction

**Issues:**
- ⚠️ **Missing `description`**
- ⚠️ **Missing `url`** (though it's in WebPage)
- ⚠️ **SearchAction `urlTemplate`** uses query string `?q={search_term_string}` - Does this actually work?

**Recommendation:**
```json
{
  "@type": "WebSite",
  "@id": "https://nrlc.ai/#website",
  "url": "https://nrlc.ai",
  "name": "Neural Command",
  "description": "AI Search Optimization, AEO, and GEO research and implementation. Knowledge base for AI visibility, retrieval, citations, and extractability.",
  "inLanguage": "en-US",
  "publisher": {
    "@type": "Organization",
    "@id": "https://nrlc.ai/#neural-command"
  },
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "https://nrlc.ai/search?q={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }
}
```

### 2.5 FAQPage Schema
**Location:** `pages/home/home.php:427-476`  
**Type:** Separate JSON-LD block ✅

**Strengths:**
- ✅ 5 questions covering key topics
- ✅ Proper `Question` and `Answer` structure
- ✅ Answers are concise and informative

**Issues:**
- ⚠️ **Answers don't include internal links** (though HTML does)
- ⚠️ **Missing `@id`** for FAQPage
- ⚠️ **Could add more questions** (e.g., "What is AEO?", "What is GEO?")

**Recommendation:** Add `@id` and consider expanding to 8-10 questions covering:
- What is AEO?
- What is GEO?
- How is AI SEO different from traditional SEO?
- What is AI visibility?
- How do I know if my site needs AI optimization?

---

## 3. CONTENT STRUCTURE ANALYSIS

### 3.1 H1 Tag
**Current:** `Joel Maldonado: SEO, AEO, and GEO Research & Implementation`  
**Location:** `pages/home/home.php:37`

**Analysis:**
- ✅ Includes target keywords (Joel Maldonado, SEO, AEO, GEO)
- ✅ Matches meta title intent (though meta title is shorter)
- ✅ Clear authority positioning
- ⚠️ **Missing semantic HTML** - Should be wrapped in `<article>` or have `itemscope itemtype="https://schema.org/WebPage"`

### 3.2 Lead Paragraph
**Current:** `Research and implementation at the bleeding edge of AI search, retrieval, citations, and extractability. Defining the SEO, AEO, and GEO practices that determine how AI systems select and cite businesses.`  
**Location:** `pages/home/home.php:40-42`

**Analysis:**
- ✅ Clear value proposition
- ✅ Includes key terms (AI search, retrieval, citations, extractability, SEO, AEO, GEO)
- ✅ Establishes authority
- ⚠️ **"Bleeding edge"** is marketing language (though acceptable for homepage)
- ⚠️ **Missing semantic markup** - Should use `<strong>` for key terms or `<dfn>` for definitions

### 3.3 Knowledge Base Sections
**Location:** `pages/home/home.php:59-149`

**Analysis:**
- ✅ 10 problem-first navigation sections
- ✅ Each section has:
  - H3 with "When [Problem]" pattern
  - Description paragraph
  - Link to section page
- ✅ Good internal linking structure
- ⚠️ **Missing semantic HTML** - Should use `<nav>` with `aria-label="Knowledge Base Navigation"`
- ⚠️ **Grid layout** uses inline styles instead of CSS classes
- ⚠️ **No `itemscope itemtype`** for structured content

**Recommendation:**
```html
<nav aria-label="Knowledge Base Navigation" itemscope itemtype="https://schema.org/ItemList">
  <div class="knowledge-base-grid">
    <!-- Each section should have itemscope itemtype="https://schema.org/ListItem" -->
  </div>
</nav>
```

### 3.4 Authority Explanation Block
**Location:** `pages/home/home.php:151-163`

**Analysis:**
- ✅ Explains AI system behavior clearly
- ✅ Contrasts traditional SEO vs. AI optimization
- ✅ Includes internal link to decision traces
- ✅ Strong closing statement: "This is the gap between ranking and being referenced."
- ⚠️ **Missing semantic markup** - Should use `<article>` or `<section>` with proper `itemscope`

### 3.5 Comparison Block
**Location:** `pages/home/home.php:165-199`

**Analysis:**
- ✅ Clear contrast between "Traditional SEO Agencies" and "NRLC.ai"
- ✅ Uses visual distinction (border color, background)
- ✅ Bullet points are easy to scan
- ⚠️ **Missing semantic markup** - Should use `<dl>` (definition list) or structured comparison schema

### 3.6 FAQ Section
**Location:** `pages/home/home.php:213-236`

**Analysis:**
- ✅ 5 questions covering key topics
- ✅ Uses `<dl>` (definition list) - Good semantic HTML ✅
- ✅ Answers include internal links
- ✅ Questions match FAQPage schema
- ⚠️ **Could add more questions** (see Schema section)

---

## 4. INTERNAL LINKING ANALYSIS

### 4.1 Hero Section Links
**Current:** 1 link to `/ai-optimization/`  
**Anchor Text:** "AI search optimization systems"

**Analysis:**
- ✅ Single focused link (good for authority flow)
- ✅ Descriptive anchor text
- ⚠️ **Missing link to `/implementation/`** (mentioned in bottom section)
- ⚠️ **Missing link to `/services/`** or `/ai-visibility/`** (mentioned in "Why This Knowledge Base Exists")

### 4.2 Knowledge Base Section Links
**Current:** 10 links to various knowledge base sections

**Analysis:**
- ✅ Good internal linking structure
- ✅ All links use descriptive anchor text
- ✅ Links point to relevant content
- ⚠️ **All links use `absolute_url()`** - Should check if locale-prefixed URLs are correct

### 4.3 Authority Explanation Links
**Current:** 1 link to `/en-us/generative-engine-optimization/decision-traces/`

**Analysis:**
- ✅ Deep link to specific content
- ✅ Contextual placement
- ⚠️ **Link uses `absolute_url()`** - Should verify locale handling

### 4.4 FAQ Section Links
**Current:** 5 internal links within FAQ answers

**Analysis:**
- ✅ Links are contextual and helpful
- ✅ Anchor text is descriptive
- ✅ Links point to relevant diagnostic/explanation pages

### 4.5 Implementation Support Link
**Current:** 1 link to `/en-us/implementation/`  
**Location:** Bottom of page

**Analysis:**
- ✅ Clear call-to-action
- ✅ Placed after content (good for conversion)
- ⚠️ **Missing link to `/book/`** or contact page
- ⚠️ **Missing link to `/services/`**

**Recommendation:** Add links to:
- `/book/` (booking/consultation)
- `/services/` (services overview)
- `/contact/` (contact page)

---

## 5. AI EXTRACTABILITY ANALYSIS

### 5.1 Semantic HTML
**Issues:**
- ❌ **No `<article>` wrapper** for main content
- ❌ **No `itemscope itemtype`** on main content sections
- ❌ **No `<time>` elements** for dates
- ❌ **No `<dfn>` elements** for term definitions
- ❌ **No `<abbr>` elements** for acronyms (AEO, GEO, SEO)

**Recommendation:**
```html
<main role="main" class="container" itemscope itemtype="https://schema.org/WebPage">
  <article itemscope itemtype="https://schema.org/Article">
    <header>
      <h1 itemprop="headline">Joel Maldonado: SEO, AEO, and GEO Research & Implementation</h1>
      <p class="lead" itemprop="description">...</p>
    </header>
    <!-- Content sections -->
  </article>
</main>
```

### 5.2 Key Term Markup
**Issues:**
- ❌ **No `<strong>` or `<em>`** for key terms
- ❌ **No `<dfn>`** for definitions (AEO, GEO)
- ❌ **No `<abbr>`** for acronyms

**Recommendation:**
```html
<p>Research and implementation at the bleeding edge of <strong>AI search</strong>, <strong>retrieval</strong>, <strong>citations</strong>, and <strong>extractability</strong>. Defining the <abbr title="Search Engine Optimization">SEO</abbr>, <dfn><abbr title="Answer Engine Optimization">AEO</abbr></dfn>, and <dfn><abbr title="Generative Engine Optimization">GEO</abbr></dfn> practices that determine how AI systems select and cite businesses.</p>
```

### 5.3 Structured Definitions
**Issues:**
- ❌ **No explicit definitions** for AEO, GEO, AI Search Optimization
- ❌ **No "What is X?" sections** that AI systems can extract

**Recommendation:** Add a definitions section:
```html
<section id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet">
  <h2>Key Terms</h2>
  <dl>
    <dt id="aeo" itemscope itemtype="https://schema.org/DefinedTerm">
      <dfn><abbr title="Answer Engine Optimization">AEO</abbr></dfn>
    </dt>
    <dd itemprop="description">Answer Engine Optimization - The practice of optimizing content for AI answer engines like ChatGPT, Google AI Overviews, and Claude.</dd>
    
    <dt id="geo" itemscope itemtype="https://schema.org/DefinedTerm">
      <dfn><abbr title="Generative Engine Optimization">GEO</abbr></dfn>
    </dt>
    <dd itemprop="description">Generative Engine Optimization - The practice of optimizing content for generative AI systems that retrieve, evaluate, and cite web content.</dd>
  </dl>
</section>
```

### 5.4 Entity Clarity
**Strengths:**
- ✅ Person schema clearly identifies Joel Maldonado
- ✅ Organization schema clearly identifies Neural Command
- ✅ WebPage schema links Person and Organization

**Issues:**
- ⚠️ **No explicit "Who is Joel Maldonado?"** section
- ⚠️ **No explicit "What is Neural Command?"** section
- ⚠️ **No `Thing` schema** for key concepts (AEO, GEO, AI Search Optimization)

---

## 6. OPEN GRAPH & TWITTER CARD ANALYSIS

### 6.1 Open Graph Tags
**Location:** `templates/head.php:204-225`

**Current Implementation:**
```html
<meta property="og:type" content="website">
<meta property="og:url" content="https://nrlc.ai/">
<meta property="og:title" content="Joel Maldonado | SEO, AEO, GEO & AI Search Research">
<meta property="og:description" content="Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. On the bleeding edge of search, retrieval, citations, and extractability.">
<meta property="og:site_name" content="NRLC.ai">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://nrlc.ai/assets/images/nrlc-logo.png">
<meta property="og:image:secure_url" content="https://nrlc.ai/assets/images/nrlc-logo.png">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="43">
<meta property="og:image:height" content="43">
<meta property="og:image:alt" content="NRLC.ai - AI Search Optimization, AEO, and GEO Research">
```

**Critical Issues:**
- ❌ **Image is 43x43px** - Too small! OG images should be **1200x630px** minimum
- ❌ **Missing `og:image:width` and `og:image:height`** should be 1200 and 630
- ⚠️ **Missing `og:type`** - Should be `profile` if focusing on Joel, or `website` if focusing on company
- ⚠️ **Missing `profile:first_name` and `profile:last_name`** (if using `og:type="profile"`)

**Recommendation:**
```html
<meta property="og:type" content="profile">
<meta property="og:url" content="https://nrlc.ai/">
<meta property="og:title" content="Joel Maldonado | SEO, AEO, GEO & AI Search Research">
<meta property="og:description" content="Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. Knowledge base documenting AI visibility, retrieval, citations, and extractability.">
<meta property="og:site_name" content="NRLC.ai">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://nrlc.ai/assets/images/og-homepage.jpg">
<meta property="og:image:secure_url" content="https://nrlc.ai/assets/images/og-homepage.jpg">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Joel Maldonado - SEO, AEO, GEO Research & Implementation">
<meta property="profile:first_name" content="Joel">
<meta property="profile:last_name" content="Maldonado">
```

### 6.2 Twitter Card Tags
**Location:** `templates/head.php:226-233`

**Current Implementation:**
```html
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://nrlc.ai/">
<meta name="twitter:title" content="Joel Maldonado | SEO, AEO, GEO & AI Search Research">
<meta name="twitter:description" content="Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems. On the bleeding edge of search, retrieval, citations, and extractability.">
<meta name="twitter:image" content="https://nrlc.ai/assets/images/nrlc-logo.png">
<meta name="twitter:image:alt" content="NRLC.ai - AI Search Optimization, AEO, and GEO Research">
<meta name="twitter:creator" content="@neuralcommand">
<meta name="twitter:site" content="@neuralcommand">
```

**Issues:**
- ❌ **Image is 43x43px** - Too small! Twitter large image should be **1200x675px** minimum
- ⚠️ **Using `summary_large_image`** but image is tiny - Should use proper 1200x675px image

**Recommendation:** Same as Open Graph - use 1200x630px (or 1200x675px for Twitter) image

---

## 7. TECHNICAL SEO ANALYSIS

### 7.1 HTML Structure
**Strengths:**
- ✅ Proper `<main>` element
- ✅ Proper `<section>` elements
- ✅ Proper heading hierarchy (H1 → H2 → H3)
- ✅ Semantic lists (`<ul>`, `<dl>`)

**Issues:**
- ❌ **No `<article>` wrapper** for main content
- ❌ **No `itemscope itemtype`** on content sections
- ❌ **Inline styles** used instead of CSS classes (lines 35, 43, 50, 66, etc.)
- ❌ **No `lang` attribute** on `<html>` tag (should be checked in `head.php`)

### 7.2 Accessibility
**Strengths:**
- ✅ Proper heading hierarchy
- ✅ Semantic HTML elements
- ✅ Descriptive link text

**Issues:**
- ⚠️ **Missing `aria-label`** on navigation sections
- ⚠️ **Missing `alt` text** check (if images are added)
- ⚠️ **No skip navigation link**

### 7.3 Performance
**Issues:**
- ⚠️ **Inline styles** add to HTML size
- ⚠️ **No lazy loading** mentioned (if images are added)
- ⚠️ **No preload** for critical resources

---

## 8. CONVERSION OPTIMIZATION ANALYSIS

### 8.1 Call-to-Action (CTA) Analysis
**Current CTAs:**
1. Hero: "AI search optimization systems" → `/ai-optimization/`
2. Bottom: "Learn about implementation support →" → `/implementation/`

**Issues:**
- ⚠️ **Only 2 CTAs** on entire homepage
- ⚠️ **No direct booking/contact CTA** in hero
- ⚠️ **No service-specific CTAs**
- ⚠️ **CTAs are text links, not buttons** (except hero which uses `btn btn--secondary`)

**Recommendation:**
- Add "Book Consultation" button in hero
- Add "View Services" button after knowledge base sections
- Add "Contact Us" link in footer (if not already present)

### 8.2 Trust Signals
**Current:**
- ✅ Authority positioning (research & implementation)
- ✅ Knowledge base (10 sections)
- ✅ Clear differentiation from competitors

**Missing:**
- ❌ No testimonials/case studies link
- ❌ No client logos
- ❌ No "As featured in" section
- ❌ No awards/certifications

### 8.3 Social Proof
**Current:**
- ⚠️ No social proof visible on homepage
- ⚠️ No testimonials
- ⚠️ No case study highlights

**Recommendation:** Add a "Featured Case Study" or "Recent Results" section

---

## 9. PRIORITY FIXES

### 🔴 CRITICAL (Fix Immediately)
1. **Add `keywords` meta tag** to `templates/head.php` (router sets it but it's not output)
2. **Fix Open Graph image** - Replace 43x43px logo with 1200x630px image
3. **Fix Twitter Card image** - Same as above
4. **Add `sameAs` social links** to Person schema (Twitter, GitHub, etc.)
5. **Add `about` and `mentions`** to WebPage schema

### 🟡 HIGH PRIORITY (Fix This Week)
6. **Add semantic HTML** - Wrap content in `<article>` with `itemscope itemtype`
7. **Add key term markup** - Use `<strong>`, `<dfn>`, `<abbr>` for SEO, AEO, GEO
8. **Add definitions section** - Explicit definitions for AEO, GEO, AI Search Optimization
9. **Enhance Person schema** - Add headshot image, more `sameAs` links
10. **Enhance Organization schema** - Add address, contactPoint, foundingDate

### 🟢 MEDIUM PRIORITY (Fix This Month)
11. **Add more CTAs** - Booking, services, contact
12. **Add trust signals** - Case studies, testimonials, client logos
13. **Improve internal linking** - Add links to `/book/`, `/services/`, `/contact/`
14. **Expand FAQ schema** - Add more questions (8-10 total)
15. **Add `speakable`** to WebPage schema for voice search

### 🔵 LOW PRIORITY (Nice to Have)
16. **Remove inline styles** - Move to CSS classes
17. **Add skip navigation link** - Accessibility improvement
18. **Add preload** for critical resources
19. **Add structured definitions** - `DefinedTermSet` schema for AEO, GEO, etc.
20. **Add `Thing` schema** for key concepts

---

## 10. SUMMARY SCORECARD

| Category | Score | Grade |
|----------|-------|-------|
| **SEO Metadata** | 7/10 | B |
| **Schema Markup** | 8/10 | B+ |
| **Content Structure** | 8/10 | B+ |
| **Internal Linking** | 7/10 | B |
| **AI Extractability** | 6/10 | C+ |
| **Open Graph/Twitter** | 5/10 | C |
| **Technical SEO** | 7/10 | B |
| **Conversion Optimization** | 6/10 | C+ |
| **Overall** | **6.8/10** | **B-** |

**Key Strengths:**
- Strong schema foundation (Person, Organization, WebPage, WebSite, FAQPage)
- Clear authority positioning
- Good internal linking structure
- Comprehensive knowledge base navigation

**Key Weaknesses:**
- Missing `keywords` meta tag output
- Tiny Open Graph/Twitter images (43x43px)
- Missing semantic HTML for AI extractability
- Incomplete Person/Organization schema (`sameAs`, address, contactPoint)
- Weak conversion optimization (only 2 CTAs)

---

## 11. RECOMMENDED ACTION PLAN

### Phase 1: Critical Fixes (This Week)
1. Add `keywords` meta tag to `templates/head.php`
2. Create 1200x630px Open Graph image
3. Update Open Graph and Twitter Card tags with new image
4. Add `sameAs` social links to Person schema
5. Add `about` and `mentions` to WebPage schema

### Phase 2: AI Extractability (Next Week)
6. Wrap main content in `<article>` with `itemscope itemtype`
7. Add `<strong>`, `<dfn>`, `<abbr>` markup for key terms
8. Add definitions section with `DefinedTermSet` schema
9. Add `speakable` to WebPage schema

### Phase 3: Schema Enhancement (Week 3)
10. Enhance Person schema (headshot, more `sameAs`)
11. Enhance Organization schema (address, contactPoint, foundingDate)
12. Expand FAQ schema (8-10 questions)
13. Add `Thing` schema for key concepts (AEO, GEO, AI Search Optimization)

### Phase 4: Conversion Optimization (Week 4)
14. Add "Book Consultation" CTA in hero
15. Add "View Services" button after knowledge base
16. Add trust signals section (case studies, testimonials)
17. Improve internal linking to `/book/`, `/services/`, `/contact/`

---

**Analysis Complete** ✅
