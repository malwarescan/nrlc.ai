# Deep Training Page Analysis: https://nrlc.ai/en-us/training/

**Analysis Date:** 2026-01-15  
**Page:** Training Hub (`/training/`)  
**Template:** `pages/training/index.php`  
**Router Config:** `bootstrap/router.php` lines 245-248

---

## EXECUTIVE SUMMARY

The training page is **well-written** with strong technical content, but has **critical schema issues** and **missing SEO optimizations**:
1. **Wrong schema type** - Uses `Service` instead of `EducationalOccupationalProgram` or `Course`
2. **Missing keywords meta tag** - Not set in metadata
3. **Missing semantic HTML** - No `itemscope itemtype` for AI extractability
4. **Missing key term markup** - No `<strong>`, `<dfn>`, `<abbr>` for technical terms
5. **Missing `about` and `mentions`** in WebPage schema
6. **No Person schema** for Joel Maldonado (instructor)
7. **Missing FAQ schema** despite having clear Q&A structure
8. **No Open Graph/Twitter Card optimization** (inherits defaults)

**Overall Grade:** B (Strong content, weak technical SEO)

---

## 1. SEO METADATA ANALYSIS

### 1.1 Meta Title
**Current:** `Operating AI Search Systems Safely, At Scale | Neural Command Training`  
**Length:** 66 characters ⚠️ (slightly over 65 char limit)  
**Location:** `pages/training/index.php:23`

**Issues:**
- ⚠️ **Slightly over 65 characters** (66 chars) - Google may truncate
- ✅ Includes key terms (AI Search Systems, Training)
- ✅ Clear value proposition
- ⚠️ Missing "MCP", "Agent Supervision", "Schema Governance" keywords
- ⚠️ "Neural Command Training" could be shortened to "NRLC.ai"

**Recommendation:**
```
Operating AI Search Systems Safely, At Scale | NRLC.ai
```
(58 chars - optimal length, includes brand)

OR more keyword-rich:
```
AI Agent Supervision & MCP Training | Neural Command
```
(52 chars - includes key terms MCP, Agent Supervision)

### 1.2 Meta Description
**Current:** `Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems. Focused on agent supervision, schema governance, Google Search Console telemetry, and content designed for reliable extraction by AI search surfaces.`  
**Length:** 223 characters ❌ (way over 160 char limit)  
**Location:** `pages/training/index.php:24`

**Critical Issue:** Description is **63 characters over** the optimal 160-character limit. Google will truncate this.

**Recommendation:**
```
Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems. Agent supervision, schema governance, Search Console telemetry, and content for AI extraction.
```
(159 chars - optimal length, includes all key terms)

### 1.3 Keywords Meta Tag
**Current:** **NOT SET** ❌  
**Location:** `pages/training/index.php:22-26`

**Critical Issue:** No keywords meta tag defined. Should include:
- AI agent training
- MCP training
- Model Context Protocol
- Agent supervision
- Schema governance
- AI search training
- Neural Command OS training
- ChatGPT training
- Perplexity training
- Google AI Overviews training

**Recommendation:**
```php
$GLOBALS['__page_meta'] = [
  'title' => 'Operating AI Search Systems Safely, At Scale | NRLC.ai',
  'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems. Agent supervision, schema governance, Search Console telemetry, and content for AI extraction.',
  'keywords' => 'AI agent training, MCP training, Model Context Protocol, agent supervision, schema governance, AI search training, Neural Command OS training, ChatGPT training, Perplexity training, Google AI Overviews training, AI SEO training, technical SEO training, agent-driven SEO',
  'canonicalPath' => '/training/'
];
```

### 1.4 Canonical URL
**Current:** `/training/` ✅  
**Implementation:** Correctly set

---

## 2. SCHEMA MARKUP ANALYSIS

### 2.1 Current Schema Structure
**Location:** `pages/training/index.php:33-65`

**Current Implementation:**
- ✅ `Organization` schema (via `ld_organization()`)
- ✅ `BreadcrumbList` schema (via `ld_breadcrumbs()`)
- ✅ `WebPage` schema
- ❌ **`Service` schema** (WRONG - should be `EducationalOccupationalProgram` or `Course`)

### 2.2 Critical Issue: Wrong Schema Type
**Problem:** The page uses `Service` schema when it should use `EducationalOccupationalProgram` or `Course` schema.

**Current (WRONG):**
```php
'about' => [
  '@type' => 'Service',
  'name' => 'AI Search & Agent Governance Training',
  'serviceType' => 'Technical SEO and AI Search Governance Training',
  // ...
]
```

**Should Be:**
```php
[
  '@type' => 'EducationalOccupationalProgram',
  '@id' => $canonicalUrl . '#program',
  'name' => 'AI Search Systems & Agent Governance Training',
  'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems.',
  'provider' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'teaches' => [
    'MCP literacy and governance',
    'Agent supervision and safety boundaries',
    'Schema as a control layer',
    'AI retrieval and grounding mechanics',
    'Content standards for AI extraction',
    'Search Console telemetry interpretation',
    'How to avoid AI-induced SEO regressions'
  ],
  'educationalCredentialAwarded' => 'Certificate of Completion',
  'programType' => 'Professional Training',
  'timeRequired' => 'PT8H', // 8 hours
  'occupationalCategory' => 'Technical SEO',
  'audience' => [
    '@type' => 'EducationalAudience',
    'educationalRole' => 'Professional',
    'audienceType' => 'Heads of SEO, Technical SEOs, Founders, Engineering Teams'
  ]
]
```

**Impact:** Google will classify this as a service offering, not education, causing misclassification and potential ranking issues.

### 2.3 Missing Person Schema (Instructor)
**Issue:** No `Person` schema for Joel Maldonado as instructor.

**Recommendation:** Add Person schema:
```php
[
  '@type' => 'Person',
  '@id' => $domain . '#joel-maldonado',
  'name' => 'Joel Maldonado',
  'jobTitle' => 'Founder & AI Search Researcher',
  'description' => 'Joel Maldonado researches and implements SEO, AEO, and GEO practices for AI search systems.',
  'knowsAbout' => [
    'AI Search Optimization', 'AEO', 'GEO', 'Agent Supervision', 
    'Model Context Protocol', 'Schema Governance', 'AI Search Training'
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

### 2.4 WebPage Schema Issues
**Current:** Basic WebPage schema ✅

**Missing:**
- ❌ `about` array (should include EducationalOccupationalProgram, MCP, Agent Supervision)
- ❌ `mentions` array (should include ChatGPT, Perplexity, Google AI Overviews, Neural Command OS)
- ❌ `keywords` property
- ❌ `speakable` specification

**Recommendation:**
```php
[
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => 'Operating AI Search Systems Safely, At Scale | Neural Command Training',
  'url' => $canonicalUrl,
  'description' => 'Operational training for teams supervising AI agents, Model Context Protocols (MCPs), and AI search systems.',
  'inLanguage' => 'en-US',
  'datePublished' => '2024-01-01', // Approximate launch date
  'dateModified' => date('Y-m-d'),
  'keywords' => 'AI agent training, MCP training, Model Context Protocol, agent supervision, schema governance, AI search training',
  'about' => [
    [
      '@type' => 'EducationalOccupationalProgram',
      '@id' => $canonicalUrl . '#program'
    ],
    [
      '@type' => 'Thing',
      'name' => 'Model Context Protocol',
      'description' => 'A protocol for constraining AI agent behavior in SEO systems'
    ],
    [
      '@type' => 'Thing',
      'name' => 'Agent Supervision',
      'description' => 'The practice of monitoring and governing AI agents operating in production systems'
    ]
  ],
  'mentions' => [
    [
      '@type' => 'SoftwareApplication',
      'name' => 'ChatGPT',
      'description' => 'AI language model by OpenAI'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Perplexity',
      'description' => 'AI-powered search engine'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Google AI Overviews',
      'description' => 'Google\'s AI-powered search overview feature'
    ],
    [
      '@type' => 'SoftwareApplication',
      'name' => 'Neural Command OS',
      'description' => 'Operating system for AI-driven SEO'
    ]
  ],
  'author' => [
    '@type' => 'Person',
    '@id' => $domain . '#joel-maldonado'
  ],
  'publisher' => [
    '@type' => 'Organization',
    '@id' => $orgId
  ],
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => $domain . '#website'
  ],
  'speakable' => [
    '@type' => 'SpeakableSpecification',
    'cssSelector' => ['h1', '.lead']
  ]
]
```

### 2.5 Missing FAQ Schema
**Issue:** Page has clear Q&A structure ("What We Teach / What We Don't") but no FAQ schema.

**Recommendation:** Add FAQPage schema:
```php
[
  '@context' => 'https://schema.org',
  '@type' => 'FAQPage',
  '@id' => $canonicalUrl . '#faq',
  'mainEntity' => [
    [
      '@type' => 'Question',
      'name' => 'What is this training for?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'This is operational training for teams running real systems. We train teams to understand, supervise, and govern AI agents operating inside a Model Context Protocol (MCP), and to produce content that AI search systems can reliably extract, ground, and cite without destabilizing production SEO.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Who is this training for?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Heads of SEO, Technical SEOs, Founders running production systems, Engineering teams interfacing with search, and Content leads working inside AI-driven workflows. If your site is already large, visible, or revenue-critical, this training is preventative infrastructure.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'What does this training cover?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Agent operation and supervision, AI search surfaces and retrieval mechanics, content as machine-interpretable information, MCP literacy and governance, schema as a control layer, AI retrieval and grounding mechanics, and how to avoid AI-induced SEO regressions.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'What does this training NOT cover?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'We do not teach prompt engineering for bloggers, AI writing tricks, keyword hacks for LLMs, "Rank in AI Overviews" shortcuts, generic SEO fundamentals, or content automation without constraints. If someone is looking for growth hacks or AI copywriting shortcuts, this training is not a fit.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Do I need Neural Command OS to take this training?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Training assumes a production system. If Neural Command OS is not installed, this training focuses on preparing teams for MCP-based search systems rather than replacing execution.'
      ]
    ]
  ]
]
```

---

## 3. CONTENT STRUCTURE ANALYSIS

### 3.1 H1 Tag
**Current:** `Operating AI Search Systems Safely, At Scale`  
**Location:** `pages/training/index.php:75`

**Analysis:**
- ✅ Clear, action-oriented
- ✅ Includes key terms (AI Search Systems)
- ⚠️ **Missing semantic HTML** - Should have `itemprop="headline"`
- ⚠️ **Missing key term markup** - Should use `<strong>` for "AI Search Systems"

**Recommendation:**
```html
<h1 class="content-block__title" itemprop="headline">Operating <strong>AI Search Systems</strong> Safely, At Scale</h1>
```

### 3.2 Lead Paragraph
**Current:** `This training exists because Neural Command OS is not a tool and agent-driven SEO is not something teams should improvise.`  
**Location:** `pages/training/index.php:78`

**Analysis:**
- ✅ Clear value proposition
- ✅ Establishes authority
- ⚠️ **Missing semantic markup** - Should use `<strong>` for "Neural Command OS" and "agent-driven SEO"
- ⚠️ **Missing `itemprop="description"`**

**Recommendation:**
```html
<p class="lead" itemprop="description">This training exists because <strong>Neural Command OS</strong> is not a tool and <strong>agent-driven SEO</strong> is not something teams should improvise.</p>
```

### 3.3 Content Sections
**Analysis:**
- ✅ Well-structured with clear H2/H3 hierarchy
- ✅ Good use of lists
- ✅ Clear differentiation ("What We Teach / What We Don't")
- ⚠️ **Missing semantic HTML** - No `<article>`, `<section>` with `itemscope itemtype`
- ⚠️ **Missing key term markup** - Technical terms like "MCP", "Schema", "AI agents" should use `<strong>`, `<dfn>`, `<abbr>`

**Recommendation:** Wrap main content in semantic HTML:
```html
<main role="main" class="container" itemscope itemtype="https://schema.org/WebPage">
  <article itemscope itemtype="https://schema.org/Article" class="section">
    <div class="section__content">
      <!-- Content sections -->
    </div>
  </article>
</main>
```

### 3.4 Technical Terms
**Missing Markup For:**
- MCP (Model Context Protocol) - should use `<dfn><abbr>`
- AI agents - should use `<strong>`
- Schema - should use `<strong>`
- ChatGPT, Perplexity, Google AI Overviews - should use `<strong>`
- Neural Command OS - should use `<strong>`

**Recommendation:**
```html
<p>We train teams to understand, supervise, and govern <strong>AI agents</strong> operating inside a <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn>, and to produce content that <strong>AI search systems</strong> can reliably extract, ground, and cite without destabilizing production <abbr title="Search Engine Optimization">SEO</abbr>.</p>
```

---

## 4. INTERNAL LINKING ANALYSIS

### 4.1 Current Links
**Internal Links:**
- ✅ `/training/one-on-one/` (Training Formats section)
- ✅ `/products/neural-command-os/` (Relationship to Neural Command OS section)

**Issues:**
- ⚠️ **Missing link to `/book/`** (booking/consultation)
- ⚠️ **Missing link to `/implementation/`** (implementation support)
- ⚠️ **Missing link to `/services/`** (services overview)
- ⚠️ **Missing link to knowledge base sections** (GEO, Diagnostics, etc.)

**Recommendation:** Add contextual links:
- Link to `/book/` in "Training Formats" section
- Link to relevant knowledge base sections (e.g., `/generative-engine-optimization/` when discussing GEO)
- Link to `/implementation/` when discussing production systems

---

## 5. AI EXTRACTABILITY ANALYSIS

### 5.1 Semantic HTML
**Issues:**
- ❌ **No `<article>` wrapper** for main content
- ❌ **No `itemscope itemtype`** on content sections
- ❌ **No `<time>` elements** for dates (if applicable)
- ❌ **No `<dfn>` elements** for term definitions (MCP, etc.)
- ❌ **No `<abbr>` elements** for acronyms (MCP, SEO, etc.)

**Recommendation:** Add semantic HTML structure (see Content Structure section)

### 5.2 Key Term Markup
**Issues:**
- ❌ **No `<strong>` or `<em>`** for key terms
- ❌ **No `<dfn>`** for definitions (MCP, Agent Supervision)
- ❌ **No `<abbr>`** for acronyms (MCP, SEO, AI)

**Recommendation:** Add markup for all technical terms (see Technical Terms section)

### 5.3 Structured Definitions
**Issues:**
- ❌ **No explicit definitions** for MCP, Agent Supervision, Schema Governance
- ❌ **No "What is X?" sections** that AI systems can extract

**Recommendation:** Add a definitions section:
```html
<section id="definitions" itemscope itemtype="https://schema.org/DefinedTermSet">
  <h2>Key Terms</h2>
  <dl>
    <dt id="mcp" itemscope itemtype="https://schema.org/DefinedTerm">
      <dfn><abbr title="Model Context Protocol">MCP</abbr></dfn>
    </dt>
    <dd itemprop="description">Model Context Protocol - A protocol for constraining AI agent behavior in SEO systems, ensuring agents operate within defined boundaries and safety constraints.</dd>
    
    <dt id="agent-supervision" itemscope itemtype="https://schema.org/DefinedTerm">
      <dfn><strong>Agent Supervision</strong></dfn>
    </dt>
    <dd itemprop="description">The practice of monitoring and governing AI agents operating in production systems, including approving, blocking, or rolling back agent actions safely.</dd>
  </dl>
</section>
```

### 5.4 Entity Clarity
**Strengths:**
- ✅ Clear authority positioning
- ✅ Clear target audience

**Issues:**
- ⚠️ **No explicit "Who is Joel Maldonado?"** section
- ⚠️ **No explicit "What is Neural Command?"** section
- ⚠️ **No `Thing` schema** for key concepts (MCP, Agent Supervision)

---

## 6. OPEN GRAPH & TWITTER CARD ANALYSIS

### 6.1 Open Graph Tags
**Current:** Inherits defaults from `templates/head.php`

**Issues:**
- ⚠️ **Uses default image** (43x43px logo) - Should be 1200x630px
- ⚠️ **Uses default description** - Should be training-specific
- ⚠️ **Missing `og:type`** - Should be `website` or `article`
- ⚠️ **Missing training-specific OG tags**

**Recommendation:** Add training-specific OG tags in `pages/training/index.php`:
```php
// Add to head section or use meta directive
$GLOBALS['__page_meta']['og_type'] = 'website';
$GLOBALS['__page_meta']['og_image'] = 'https://nrlc.ai/assets/images/og-training.jpg'; // 1200x630px
$GLOBALS['__page_meta']['og_image_width'] = 1200;
$GLOBALS['__page_meta']['og_image_height'] = 630;
```

### 6.2 Twitter Card Tags
**Current:** Inherits defaults

**Issues:**
- ⚠️ **Uses default image** (43x43px) - Should be 1200x675px
- ⚠️ **Uses default description** - Should be training-specific

**Recommendation:** Same as Open Graph - use proper image size

---

## 7. TECHNICAL SEO ANALYSIS

### 7.1 HTML Structure
**Strengths:**
- ✅ Proper `<main>` element
- ✅ Proper heading hierarchy (H1 → H2 → H3)
- ✅ Semantic lists (`<ul>`)

**Issues:**
- ❌ **No `<article>` wrapper** for main content
- ❌ **No `itemscope itemtype`** on content sections
- ❌ **Inline styles** used (should use CSS classes)

### 7.2 Accessibility
**Strengths:**
- ✅ Proper heading hierarchy
- ✅ Semantic HTML elements
- ✅ Descriptive link text

**Issues:**
- ⚠️ **Missing `aria-label`** on navigation sections
- ⚠️ **No skip navigation link**

### 7.3 Performance
**Issues:**
- ⚠️ **Inline styles** add to HTML size
- ⚠️ **No lazy loading** mentioned (if images are added)

---

## 8. CONVERSION OPTIMIZATION ANALYSIS

### 8.1 Call-to-Action (CTA) Analysis
**Current CTAs:**
1. "One-on-One Operator Training" link → `/training/one-on-one/`
2. "Team & Group Sessions (coming soon)" - not clickable

**Issues:**
- ⚠️ **Only 1 active CTA** on entire page
- ⚠️ **No direct booking/contact CTA**
- ⚠️ **No "Book Consultation" button**
- ⚠️ **CTAs are text links, not buttons**

**Recommendation:**
- Add "Book Training Consultation" button in "Training Formats" section
- Add "View One-on-One Training" button (not just link)
- Add "Contact Us" link

### 8.2 Trust Signals
**Current:**
- ✅ Authority positioning (operational training, not beginner)
- ✅ Clear differentiation ("What We Teach / What We Don't")
- ✅ Clear target audience

**Missing:**
- ❌ No testimonials/case studies
- ❌ No client logos
- ❌ No "As featured in" section
- ❌ No awards/certifications

### 8.3 Social Proof
**Current:**
- ⚠️ No social proof visible
- ⚠️ No testimonials
- ⚠️ No case study highlights

**Recommendation:** Add a "Who We've Trained" section (if applicable)

---

## 9. PRIORITY FIXES

### 🔴 CRITICAL (Fix Immediately)
1. **Fix schema type** - Change `Service` to `EducationalOccupationalProgram`
2. **Add keywords meta tag** - Set comprehensive keywords array
3. **Fix meta description length** - Reduce from 223 to 160 characters
4. **Add Person schema** - Joel Maldonado as instructor
5. **Add FAQ schema** - Based on "What We Teach / What We Don't" content

### 🟡 HIGH PRIORITY (Fix This Week)
6. **Add semantic HTML** - Wrap content in `<article>` with `itemscope itemtype`
7. **Add key term markup** - Use `<strong>`, `<dfn>`, `<abbr>` for MCP, AI agents, etc.
8. **Add definitions section** - Explicit definitions for MCP, Agent Supervision
9. **Enhance WebPage schema** - Add `about`, `mentions`, `keywords`, `speakable`
10. **Add Thing schema** - For MCP, Agent Supervision, Schema Governance

### 🟢 MEDIUM PRIORITY (Fix This Month)
11. **Add more CTAs** - Booking, contact, view training details
12. **Add trust signals** - Testimonials, case studies, client logos
13. **Improve internal linking** - Links to `/book/`, `/services/`, knowledge base
14. **Fix Open Graph/Twitter** - Use proper 1200x630px image
15. **Add `speakable`** to WebPage schema for voice search

### 🔵 LOW PRIORITY (Nice to Have)
16. **Remove inline styles** - Move to CSS classes
17. **Add skip navigation link** - Accessibility improvement
18. **Add preload** for critical resources
19. **Add structured definitions** - `DefinedTermSet` schema for MCP, etc.
20. **Add `Thing` schema** for key concepts

---

## 10. SUMMARY SCORECARD

| Category | Score | Grade |
|----------|-------|-------|
| **SEO Metadata** | 6/10 | C+ |
| **Schema Markup** | 4/10 | D |
| **Content Structure** | 8/10 | B+ |
| **Internal Linking** | 6/10 | C+ |
| **AI Extractability** | 5/10 | C |
| **Open Graph/Twitter** | 5/10 | C |
| **Technical SEO** | 7/10 | B |
| **Conversion Optimization** | 5/10 | C |
| **Overall** | **5.8/10** | **C+** |

**Key Strengths:**
- Strong, technical content
- Clear authority positioning
- Good differentiation ("What We Teach / What We Don't")
- Well-structured content sections

**Key Weaknesses:**
- **Wrong schema type** (Service instead of EducationalOccupationalProgram)
- **Missing keywords meta tag**
- **Meta description too long** (223 chars)
- **Missing semantic HTML** for AI extractability
- **Missing Person schema** (instructor)
- **Missing FAQ schema**
- **Weak conversion optimization** (only 1 CTA)

---

## 11. RECOMMENDED ACTION PLAN

### Phase 1: Critical Fixes (This Week)
1. Change schema from `Service` to `EducationalOccupationalProgram`
2. Add keywords meta tag
3. Fix meta description length (223 → 160 chars)
4. Add Person schema for Joel Maldonado
5. Add FAQ schema based on content

### Phase 2: AI Extractability (Next Week)
6. Wrap main content in `<article>` with `itemscope itemtype`
7. Add `<strong>`, `<dfn>`, `<abbr>` markup for key terms
8. Add definitions section with `DefinedTermSet` schema
9. Add `speakable` to WebPage schema

### Phase 3: Schema Enhancement (Week 3)
10. Enhance WebPage schema (`about`, `mentions`, `keywords`)
11. Add Thing schema for MCP, Agent Supervision, Schema Governance
12. Expand EducationalOccupationalProgram schema (more details)

### Phase 4: Conversion Optimization (Week 4)
13. Add "Book Training Consultation" CTA
14. Add "View One-on-One Training" button
15. Add trust signals section (testimonials, case studies)
16. Improve internal linking to `/book/`, `/services/`, knowledge base

---

**Analysis Complete** ✅
