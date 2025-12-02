# Uniform Hero Content Implementation

## Overview
All pages across the NRLC.ai site now use a uniform hero content structure that communicates NRLC's research, philosophy, and applications in a consistent, authoritative tone.

---

## Mandatory Structure

Every hero section follows this exact 3-line structure:

### Line 1: Research Statement (WHAT WE STUDY)
**Text:** "NRLC researches structured cognition, ontological reasoning, micro-fact architectures, and agentic search systems."

### Line 2: Philosophical Statement (WHY IT MATTERS)
**Text:** "Data becomes intelligence only through structure, verification, and ontology."

### Line 3: Applications Statement (WHERE IT IS USED)
**Text:** "Applied to schema engines, onboarding intelligence, renderer labs, microfact pipelines, and domain cognition models."

---

## Tone Requirements

All hero content uses:
- ✅ Authoritative research tone
- ✅ Engineering-level clarity
- ✅ Precise vocabulary
- ✅ Philosophical rigor
- ✅ Zero marketing fluff
- ✅ Zero startup slogans
- ✅ Zero AI-slop
- ✅ Zero generic adjectives

---

## Pages Updated

### Core Pages
- ✅ **Homepage** (`pages/home/home.php`)
- ✅ **Products Index** (`pages/products/index.php`)
- ✅ **Services Index** (`pages/services/index.php`)
- ✅ **Insights Index** (`pages/insights/index.php`)

### Product Pages (8 products)
- ✅ **Applicants.io** (`pages/products/applicants-io.php`)
- ✅ **Croutons.ai** (`pages/products/croutons-ai.php`)
- ✅ **Precogs** (`pages/products/precogs.php`)
- ✅ **NEWFAQ** (`pages/products/newfaq.php`)
- ✅ **OurCasa.ai** (`pages/products/ourcasa-ai.php`)
- ✅ **Data, But Structured** (`pages/products/data-but-structured.php`)
- ✅ **Googlebot Renderer Lab** (`pages/products/googlebot-renderer-lab.php`)
- ✅ **Neural Command OS** (`pages/products/neural-command-os.php`)

### Service Pages
- ✅ **Service Pages** (`pages/services/service.php`)
- ✅ **Service City Pages** (`pages/services/service_city.php`)

### Insights Articles
- ✅ **All Insights Articles** (`pages/insights/article.php` - router adds hero to all articles)
- ✅ **Silent Hydration SEO** (`pages/insights/silent-hydration-seo.php`)
- ✅ **GEO-16 Framework** (`pages/insights/geo16-framework.php`)

### Other Pages
- ✅ **Book/Consultation** (`pages/book/index.php`)
- ✅ **Careers** (`pages/careers/index.php`)
- ✅ **Resources** (`pages/resources/resource.php`)
- ✅ **Catalog Items** (`pages/catalog/item.php`)
- ✅ **Industries Index** (`pages/industries/index.php`)
- ✅ **Tools Index** (`pages/tools/index.php`)

---

## HTML Structure

All hero sections use this consistent HTML structure:

```html
<!-- Uniform Hero Section -->
<section class="hero-isometric">
  <div class="hero-foreground">
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Structured Intelligence Systems</h1>
      </div>
      <div class="content-block__body">
        <!-- Line 1: Research Statement -->
        <p class="lead">NRLC researches structured cognition, ontological reasoning, micro-fact architectures, and agentic search systems.</p>
        
        <!-- Line 2: Philosophical Statement -->
        <p>Data becomes intelligence only through structure, verification, and ontology.</p>
        
        <!-- Line 3: Applications Statement -->
        <p>Applied to schema engines, onboarding intelligence, renderer labs, microfact pipelines, and domain cognition models.</p>
      </div>
    </div>
  </div>
</section>
```

---

## Implementation Details

### Homepage
- Uses full `hero-isometric` section with background animation
- Hero content follows uniform structure
- Buttons included in hero section

### Other Pages
- Use simplified `hero-isometric` section (no background animation)
- Hero content follows uniform structure
- Buttons optional (can be excluded if not needed)

### Insights Articles
- Hero added via router (`pages/insights/article.php`)
- All articles automatically receive uniform hero
- Article-specific H1 changed to H2 to maintain hierarchy

---

## Heading Hierarchy

After adding uniform hero sections, page-specific headings were adjusted:

- **Before:** Page-specific content used `<h1>` for main title
- **After:** Page-specific content uses `<h2>` for main title
- **Reason:** Uniform hero uses `<h1>` for "Structured Intelligence Systems"

This maintains proper HTML heading hierarchy while ensuring consistent hero content.

---

## Template Function

A reusable template function was created (but not yet used):

**File:** `templates/hero_uniform.php`

**Function:** `render_uniform_hero_content($include_buttons = true)`

This function can be used in the future to ensure consistency, but currently all pages have the hero HTML directly embedded for maximum control.

---

## Prohibited Content

The following are **strictly prohibited** in hero sections:

- ❌ Marketing adjectives ("revolutionizing", "transforming", "cutting-edge")
- ❌ Filler intros ("In today's digital world...")
- ❌ Conversational language ("Hey there!", "Welcome!")
- ❌ Startup clichés ("We're disrupting...")
- ❌ Buzzwords ("AI-powered", "cloud-native")
- ❌ Rhetorical questions ("Want to grow your business?")
- ❌ Emotional tone
- ❌ Value proposition phrasing ("Unlock the potential...")

---

## Responsive Consistency

Hero content remains **identical** across all breakpoints:
- Mobile
- Tablet
- Desktop
- Ultra-wide
- Reduced-motion mode
- Dark/light modes

Only layout adapts; text never changes or shortens.

---

## Enforcement

### Automatic Checks
All hero sections should verify:
- ✅ Contains research statement
- ✅ Contains philosophical statement
- ✅ Contains applications statement
- ✅ Follows 3-line structure
- ✅ Uses consistent tone
- ✅ No prohibited phrases

### Manual Review
When adding new pages:
1. Include uniform hero section
2. Use exact 3-line structure
3. Maintain consistent tone
4. Change page-specific H1 to H2

---

## Future Maintenance

### Adding New Pages
1. Copy hero HTML structure from any existing page
2. Ensure exact text matches uniform structure
3. Change page-specific main heading to H2
4. Verify tone matches research institute aesthetic

### Updating Hero Content
If hero content needs to change:
1. Update all pages simultaneously
2. Maintain 3-line structure
3. Preserve authoritative tone
4. Test across all breakpoints

---

## Summary

**Status:** ✅ Complete

All pages across the site now use uniform hero content that:
- Communicates NRLC's research focus
- Expresses philosophical worldview
- Lists practical applications
- Maintains consistent tone and structure
- Provides clear visual hierarchy

The implementation ensures that every visitor, regardless of entry point, receives the same foundational understanding of NRLC's mission, philosophy, and applications.

