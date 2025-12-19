# SUDO META DIRECTIVE — HOMEPAGE CONVERSION & SEO UPGRADE

**Authority:** Senior Conversion + Technical SEO Engineer  
**Target:** `/en-us/` (Homepage)  
**Mode:** HARD ENFORCEMENT / NO ABSTRACTION  
**Status:** CRITICAL PRIORITY

---

## OBJECTIVE

Transform the homepage from a "trying to be everything" authority hub into a decisive commercial classifier that:
1. Instantly self-qualifies $10k/month buyers
2. Routes users into 3 distinct intent paths (not button sprawl)
3. Provides machine-quotable entity signals for Google + LLMs
4. Anchors service classification with explicit "we are NOT an SEO agency" positioning
5. Strengthens internal linking to core money pages

**This is NOT a redesign. This is surgical conversion + SEO signal injection.**

---

## PART 1: HERO SECTION REWRITE (ABOVE-THE-FOLD)

### CURRENT PROBLEM
- Abstract headline ("Search Visibility Isn't Enough Anymore")
- Doesn't answer "Who is this for?" in 3 seconds
- Value prop is conceptual, not concrete
- Missing explicit "NOT an SEO agency" statement

### REQUIRED STRUCTURE

**H1 (Must Answer 4 Questions in One Line):**
- Who is this for?
- What problem do they solve?
- Why them vs alternatives?
- What should I do next?

**H1 Template (Choose ONE):**
```
Option A: "AI Search Optimization for Companies Already Spending on SEO"
Option B: "We're Not an SEO Agency. We Engineer AI Visibility for Google AI Overviews and LLM Citations."
Option C: "If You're Paying for SEO But Not Appearing in AI Answers, This Is Why"
```

**Subheadline (Lead Paragraph - REQUIRED):**
Must explicitly state:
- "We are NOT an SEO agency"
- "We specialize in AI search systems (Google AI Overviews, LLM citations, machine trust)"
- "We work with companies already spending money on SEO"

**Example Structure:**
```
<p class="lead">
  NRLC.ai is not an SEO agency. We engineer AI visibility for Google AI Overviews, ChatGPT, Perplexity, and Claude. We work with companies already investing in SEO who need their search authority to translate into AI citations.
</p>
```

**Authority Line (Keep, But Tighten):**
```
<p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-sm);">
  Led by Joel Maldonado — 20+ years in search, structured data, and algorithmic visibility.
</p>
```

**Geo Line (Keep):**
```
<p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-lg);">
  Serving companies across the United States and United Kingdom, with proven results in competitive local and international markets.
</p>
```

---

## PART 2: CTA GOVERNANCE (HOMEPAGE-SPECIFIC)

### CURRENT PROBLEM
- Mixed CTAs without hierarchy
- Single action focus (audit only)
- No intent path separation

### REQUIRED STRUCTURE

**3 Intent Paths (NOT Button Sprawl):**

**Path 1: Commercial Service (Primary)**
- Label: "AI Search Optimization"
- Destination: `/en-us/services/ai-search-optimization/`
- Visual: Primary button
- Buyer Stage: Commercial / Ready to buy
- Anchor Text: "AI Search Optimization" (descriptive, not generic)

**Path 2: Evaluation / Trust (Secondary)**
- Label: "AI Visibility Audit"
- Destination: `openContactSheet('AI Visibility Audit')`
- Visual: Secondary button
- Buyer Stage: Evaluation / Trust building
- Anchor Text: "AI Visibility Audit"

**Path 3: Authority & Education (Tertiary)**
- Label: "Insights & Research"
- Destination: `/insights/geo16-introduction/`
- Visual: Text link or tertiary button
- Buyer Stage: Research / Authority building
- Anchor Text: "AI Search Research" (descriptive)

**Hero CTA Block (REQUIRED):**
```html
<div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; margin-top: var(--spacing-lg);">
  <a href="/en-us/services/ai-search-optimization/" class="btn btn--primary">AI Search Optimization</a>
  <button type="button" class="btn btn--secondary" onclick="openContactSheet('AI Visibility Audit')">AI Visibility Audit</button>
  <a href="/insights/geo16-introduction/" class="btn" style="text-decoration: underline;">AI Search Research</a>
</div>
```

**Visual Hierarchy Rules:**
- Primary button: Largest, most prominent
- Secondary button: Medium prominence
- Tertiary link: Subtle, not competing

**NO OTHER CTAs ABOVE THE FOLD**

---

## PART 3: MACHINE-QUOTABLE DECLARATIVE STATEMENTS

### CURRENT PROBLEM
- Abstract marketing copy
- LLMs can't extract clear "what this company does" signals
- Missing explicit contrasts

### REQUIRED ADDITIONS

**Add This Block Immediately After Hero (Before Authority Explanation):**

```html
<!-- MACHINE-QUOTABLE ENTITY SIGNALS -->
<div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8);">
  <div class="content-block__body">
    <p style="margin: 0; font-weight: 500;"><strong>What NRLC.ai Does:</strong></p>
    <ul style="margin: var(--spacing-sm) 0 0 0; padding-left: 1.5rem;">
      <li>NRLC.ai engineers authority signals for AI-driven search systems.</li>
      <li>Traditional SEO optimizes pages. AI search systems evaluate trust graphs.</li>
      <li>NRLC.ai structures content so Google AI Overviews, ChatGPT, and Perplexity can confidently cite your business.</li>
      <li>NRLC.ai is not an SEO agency. We specialize in AI visibility, not keyword rankings.</li>
    </ul>
  </div>
</div>
```

**Why This Works:**
- Short, declarative sentences
- Explicit contrasts ("Traditional SEO vs AI search")
- System descriptions AI can quote
- Clear "we do X, not Y" positioning

---

## PART 4: SERVICE ENTITY LANGUAGE ENFORCEMENT

### CURRENT PROBLEM
- Service classification is implicit
- Google doesn't get strong "service business" signal
- Missing explicit service names

### REQUIRED ADDITIONS

**Update "What We Actually Do" Section:**

Add explicit service names:
- "AI Search Optimization" (primary service)
- "AI Visibility & Trust Audit" (evaluation service)

**Add Service Links Within Content:**

In "What We Actually Do" section, link to:
- `/en-us/services/ai-search-optimization/` (anchor: "AI Search Optimization")
- `/en-us/ai-visibility/` (anchor: "AI Visibility & Trust Audit")

**Example:**
```html
<p>We provide <a href="/en-us/services/ai-search-optimization/">AI Search Optimization</a> and <a href="/en-us/ai-visibility/">AI Visibility & Trust Audit</a> services for companies that need their search authority to translate into AI citations.</p>
```

---

## PART 5: INTERNAL LINKING ENFORCEMENT

### CURRENT PROBLEM
- Weak internal linking
- Missing descriptive anchor text
- Not funneling authority to money pages

### REQUIRED LINKS (Minimum)

**Homepage Must Link To:**

1. **AI Search Optimization** (Core Service)
   - URL: `/en-us/services/ai-search-optimization/`
   - Anchor: "AI Search Optimization" (not "View Services" or "Learn More")
   - Placement: Hero CTA (primary), "What We Actually Do" section, final CTA

2. **AI Visibility Hub** (Supporting Service)
   - URL: `/en-us/ai-visibility/`
   - Anchor: "AI Visibility & Trust Audit"
   - Placement: Hero CTA (secondary), "What We Actually Do" section

3. **GEO-16 Introduction** (Proof / Authority)
   - URL: `/insights/geo16-introduction/`
   - Anchor: "AI Search Research" or "GEO-16 Framework"
   - Placement: Hero CTA (tertiary), Authority Explanation section

**Anchor Text Rules:**
- NO generic anchors: "Learn More", "View Services", "Click Here"
- YES descriptive anchors: "AI Search Optimization", "AI Visibility Audit", "GEO-16 Framework"

**Link Placement:**
- Hero: 3 CTAs (as specified in Part 2)
- "What We Actually Do": At least 2 service links
- Final CTA: Link to primary service

---

## PART 6: CONVERSION PSYCHOLOGY (CONTROLLED FRICTION)

### CURRENT PROBLEM
- Feels too open, too accessible
- Missing selectivity signals
- No premium positioning

### REQUIRED ADDITIONS

**Add Selectivity Statement (After Hero, Before Machine-Quotable Block):**

```html
<div class="content-block module" style="background: #fff3cd; border-left: 3px solid #ffc107; padding: var(--spacing-md); margin-bottom: var(--spacing-md);">
  <div class="content-block__body">
    <p style="margin: 0; font-size: 0.9rem; color: #856404;">
      <strong>This service is not for everyone.</strong> We work with companies already investing in SEO who need their search authority to translate into AI citations. If you're looking for keyword optimization or link building, traditional SEO agencies are a better fit.
    </p>
  </div>
</div>
```

**Why This Works:**
- Signals selectivity
- Self-qualifies buyers
- Increases lead quality
- Subtle friction that filters tire-kickers

---

## PART 7: SCHEMA ENFORCEMENT

### CURRENT STATUS
- Organization schema exists
- Person schema (Joel) exists
- Missing Service schema on homepage

### REQUIRED ADDITIONS

**Add Service Schema to Homepage:**

```php
// In pages/home/home.php, add to $GLOBALS['__jsonld'] array:

$GLOBALS['__jsonld'][] = [
  '@context' => 'https://schema.org',
  '@type' => 'Service',
  'name' => 'AI Search Optimization',
  'serviceType' => 'AI Visibility Optimization',
  'provider' => [
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => 'NRLC.ai'
  ],
  'description' => 'AI Search Optimization services for Google AI Overviews, ChatGPT, Perplexity, and Claude. Engineers authority signals for AI-driven search systems.',
  'areaServed' => [
    ['@type' => 'Country', 'name' => 'United States'],
    ['@type' => 'Country', 'name' => 'United Kingdom']
  ]
];
```

**Why This Matters:**
- Explicitly classifies homepage as service business
- Helps Google understand primary offering
- Improves AI citation accuracy

---

## PART 8: META TITLE & DESCRIPTION UPDATE

### CURRENT STATUS
- Meta title likely generic
- Description may not emphasize "NOT SEO agency"

### REQUIRED UPDATES

**Meta Title (Router):**
```
"AI Search Optimization | Not an SEO Agency | NRLC.ai"
```

**Meta Description:**
```
"NRLC.ai engineers AI visibility for Google AI Overviews, ChatGPT, and LLM citations. We're not an SEO agency. We work with companies already spending on SEO who need search authority to translate into AI citations."
```

**Update in `bootstrap/router.php`:**
```php
if ($path === '/' || $path === '') {
  $ctx = [
    'type' => 'home',
    'slug' => 'home/home',
    'canonicalPath' => '/'
  ];
  $GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
  // Override for homepage-specific meta
  $GLOBALS['__page_meta']['title'] = 'AI Search Optimization | Not an SEO Agency | NRLC.ai';
  $GLOBALS['__page_meta']['description'] = 'NRLC.ai engineers AI visibility for Google AI Overviews, ChatGPT, and LLM citations. We\'re not an SEO agency. We work with companies already spending on SEO who need search authority to translate into AI citations.';
  // ... rest of homepage setup
}
```

---

## PART 9: IMPLEMENTATION CHECKLIST

### Phase 1: Hero + CTAs (CRITICAL)
- [ ] Rewrite H1 to answer 4 questions
- [ ] Add explicit "NOT an SEO agency" statement
- [ ] Implement 3 intent path CTAs (not button sprawl)
- [ ] Update meta title/description

### Phase 2: Machine Signals (HIGH PRIORITY)
- [ ] Add machine-quotable declarative statements block
- [ ] Add selectivity statement (controlled friction)
- [ ] Update "What We Actually Do" with service links

### Phase 3: Schema + Internal Linking (MEDIUM PRIORITY)
- [ ] Add Service schema to homepage
- [ ] Strengthen internal links with descriptive anchors
- [ ] Verify all 3 required links present

### Phase 4: Quality Gates
- [ ] Verify no generic anchor text ("Learn More", "View Services")
- [ ] Verify all CTAs have distinct destinations
- [ ] Verify schema validates
- [ ] Verify meta title/description unique
- [ ] Test on mobile (CTAs stack correctly)

---

## SUCCESS CRITERIA

**Conversion:**
- $10k/month buyer can self-qualify in 3 seconds
- Clear intent path separation (no CTA confusion)
- Selectivity signals increase lead quality

**SEO:**
- Google classifies homepage as service business
- Strong entity signals for AI systems
- Internal linking funnels authority to money pages

**AI/LLM Visibility:**
- Machine-quotable statements extractable
- Clear "we do X, not Y" positioning
- Explicit service classification

---

## GOVERNANCE RULES

**DO:**
- Keep existing structure (no full redesign)
- Maintain authority explanation, comparison, Joel's voice sections
- Preserve existing schema (Organization, Person)
- Add Service schema without breaking existing

**DON'T:**
- Remove existing content blocks (unless explicitly stated)
- Change URLs or canonicals
- Add new pages or sections
- Break mobile layout

**CONTENT-ONLY CHANGES:**
- Hero rewrite
- CTA restructuring
- Content additions (machine-quotable, selectivity)
- Internal link strengthening
- Schema additions

---

## FINAL NOTES

This directive is surgical, not cosmetic. Every change addresses a specific conversion or SEO gap identified in the analysis.

**Priority Order:**
1. Hero rewrite + CTA governance (Part 1 + 2)
2. Machine-quotable statements (Part 3)
3. Service entity language (Part 4)
4. Internal linking (Part 5)
5. Conversion psychology (Part 6)
6. Schema + Meta (Part 7 + 8)

**If you do nothing else, do Parts 1, 2, and 3. Those are the conversion killers.**

---

**STATUS: READY FOR IMPLEMENTATION**

