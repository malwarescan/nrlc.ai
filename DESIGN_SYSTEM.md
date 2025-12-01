---

name: w3c-functional-authority-design

description: Production-grade frontend design system for authoritative, information-dense interfaces. Combines W3C functional authority principles with modern interaction patterns. Prioritizes clarity, accessibility (WCAG AAA), and rapid information delivery over decorative aesthetics. Use for enterprise interfaces, technical documentation, research platforms, and any context requiring trust, credibility, and high information density.

---

# W3C Functional Authority Design System

This design system creates distinctive, production-grade interfaces that project absolute authority, trust, and standardization. Every design decision prioritizes clear, rapid delivery of complex information over decorative aesthetics.

## Core Philosophy

**Functional Authority**: Form must strictly follow function. Every visual element serves a purpose. Every interaction reduces cognitive load. Every design choice reinforces credibility.

Before writing any code, establish:

1. **Information Hierarchy**: What information is most critical? How should users navigate complexity?
2. **Trust Signals**: What visual elements convey authority and reliability?
3. **Accessibility First**: WCAG AAA compliance is non-negotiable. High contrast. Clear focus states. Semantic HTML.
4. **Density Efficiency**: Present maximum information per screen without sacrificing readability.

## Design Process Workflow

### Phase 1: Context & Authority (ALWAYS START HERE)

Understand the interface's purpose:

- What information must be communicated?
- What level of technical authority is required?
- Who are the users? (Technical professionals, executives, researchers)
- What emotional response should this evoke? (Trust, confidence, clarity)
- What makes this interface authoritative vs. generic?

### Phase 2: Design System Definition

Define design tokens BEFORE coding:

```css
/* W3C Functional Authority System */
:root {
  /* Typography — System fonts only, standards-compliant */
  --font-body: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  --font-mono: "SF Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, "Courier New", monospace;
  
  /* Color Palette — Minimalist, High Contrast (WCAG AAA) */
  --color-text-primary: #000000;      /* 21:1 contrast on white */
  --color-text-secondary: #333333;     /* 12.6:1 contrast on white */
  --color-text-muted: #666666;        /* 7:1 contrast on white */
  --color-bg-primary: #ffffff;
  --color-bg-secondary: #f5f5f5;      /* Subtle separation */
  --color-border: #cccccc;            /* Clear boundaries */
  
  /* Brand Accent — Used sparingly for links, active states */
  --color-brand: #0066cc;              /* WCAG AAA: 7:1 contrast */
  --color-brand-hover: #0052a3;
  
  /* Layout — Modular, Efficient */
  --container-max-width: 1200px;
  --container-padding: 1.5rem;
  --section-spacing: 2rem;
  --module-spacing: 1.5rem;
  
  /* Typography Scale — Size & Weight Only */
  --font-size-base: 1rem;     /* 16px minimum for WCAG AAA */
  --font-size-lg: 1.125rem;   /* 18px */
  --font-size-xl: 1.25rem;    /* 20px */
  --font-size-2xl: 1.5rem;    /* 24px */
  --font-size-3xl: 1.875rem;  /* 30px */
  --font-size-4xl: 2.25rem;   /* 36px */
  
  /* Animation — Subtle, Purposeful */
  --ease-functional: cubic-bezier(0.4, 0, 0.2, 1);
  --duration-fast: 150ms;
  --duration-base: 200ms;
  --duration-slow: 300ms;
  
  /* Focus — WCAG AAA compliant */
  --focus-outline: 3px solid #0066cc;
  --focus-outline-offset: 2px;
}
```

### Phase 3: Implementation Patterns

#### Typography Hierarchy

Use system fonts. Establish hierarchy through size, weight, and color only:

```css
/* Bad - Decorative fonts break authority */
font-family: 'Playfair Display', serif;

/* Good - System fonts, weight hierarchy */
h1 {
  font-size: var(--font-size-4xl);
  font-weight: 700;
  line-height: 1.2;
  color: var(--color-text-primary);
}

h2 {
  font-size: var(--font-size-3xl);
  font-weight: 700;
  line-height: 1.3;
  color: var(--color-text-primary);
}

p {
  font-size: var(--font-size-base);
  font-weight: 400;
  line-height: 1.6;
  color: var(--color-text-primary);
}
```

#### Color Usage

High contrast. Minimal palette. Functional purpose only:

```css
/* Bad - Decorative gradients */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Good - Functional separation */
.content-block {
  background-color: var(--color-bg-primary);
  border: 1px solid var(--color-border);
  padding: var(--module-spacing);
}

.content-block--highlighted {
  background-color: var(--color-bg-secondary);
  border-color: var(--color-text-primary);
}
```

#### Layout Strategies

Modular segmentation. Clear hierarchy. Efficient negative space:

```css
/* Modular content blocks */
.content-block {
  margin-bottom: var(--module-spacing);
  padding: var(--module-spacing);
  border: 1px solid var(--color-border);
}

.content-block__header {
  margin-bottom: var(--spacing-md);
  border-bottom: 2px solid var(--color-border);
  padding-bottom: var(--spacing-sm);
}

.content-block__title {
  font-size: var(--font-size-2xl);
  font-weight: 700;
  margin: 0;
}

.content-block__body {
  margin-top: var(--spacing-md);
}
```

#### Navigation — Deep Multi-Tiered

W3C-style navigation with clear hierarchy:

```css
.nav-primary {
  display: flex;
  flex-wrap: wrap;
  border-bottom: 2px solid var(--color-border-strong);
}

.nav-primary__item {
  margin-right: var(--spacing-lg);
}

.nav-primary__link {
  display: block;
  padding: var(--spacing-sm) 0;
  font-weight: 500;
  color: var(--color-text-primary);
  text-decoration: none;
  border-bottom: 2px solid transparent;
  transition: border-color var(--duration-fast) var(--ease-functional);
}

.nav-primary__link:hover,
.nav-primary__link[aria-current="page"] {
  border-bottom-color: var(--color-brand);
}
```

### Phase 4: Animation & Interaction

#### Subtle Entrance Animations

Purposeful, not decorative:

```css
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.content-block {
  animation: fadeInUp var(--duration-slow) var(--ease-functional) both;
}

.content-block:nth-child(1) { animation-delay: 0ms; }
.content-block:nth-child(2) { animation-delay: 50ms; }
.content-block:nth-child(3) { animation-delay: 100ms; }
```

#### Focus States — WCAG AAA

Clear, visible focus indicators:

```css
a:focus-visible,
button:focus-visible,
input:focus-visible {
  outline: var(--focus-outline);
  outline-offset: var(--focus-outline-offset);
  border-radius: 0; /* Sharp corners maintain authority */
}
```

#### Hover States — Functional Feedback

Subtle, purposeful:

```css
a:hover {
  color: var(--color-brand-hover);
  text-decoration-thickness: 2px;
}

.btn:hover {
  background-color: var(--color-brand-hover);
  transform: translateY(-1px); /* Subtle lift */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
```

## Critical Anti-Patterns to Avoid

### The "Generic AI Look" Checklist

NEVER do all of these together:

- ❌ Purple/blue gradient backgrounds
- ❌ Decorative fonts (Playfair, Inter, custom webfonts)
- ❌ Rounded corners everywhere (border-radius: 16px)
- ❌ Drop shadows on all cards
- ❌ #6366F1 as primary color
- ❌ Centered hero with subheading
- ❌ 3-column feature cards with icons
- ❌ "Modern", "Clean", "Simple" as only descriptors
- ❌ Excessive whitespace
- ❌ Decorative icons without purpose

### Common Pitfalls

1. **Over-decoration**: Every visual element must serve a function.
2. **Low contrast**: WCAG AAA requires 7:1 contrast minimum.
3. **Weak hierarchy**: Use size, weight, and color to establish clear information hierarchy.
4. **Generic patterns**: Avoid cookie-cutter layouts. Design for specific content.
5. **Accessibility afterthought**: Build accessibility in from the start.

## Framework-Specific Guidelines

### PHP Templates

For PHP templating, emphasize semantic HTML and modular components:

```php
<!-- Modular content block -->
<div class="content-block module">
  <div class="content-block__header">
    <h2 class="content-block__title"><?= htmlspecialchars($title) ?></h2>
  </div>
  <div class="content-block__body">
    <?= $content ?>
  </div>
</div>
```

### React Components

For React, emphasize composition and accessibility:

```jsx
const ContentBlock = ({ title, children, highlighted = false }) => {
  return (
    <article 
      className={`content-block module ${highlighted ? 'content-block--highlighted' : ''}`}
      role="region"
      aria-labelledby={title ? `block-${title.toLowerCase().replace(/\s+/g, '-')}` : undefined}
    >
      {title && (
        <div className="content-block__header">
          <h2 className="content-block__title" id={`block-${title.toLowerCase().replace(/\s+/g, '-')}`}>
            {title}
          </h2>
        </div>
      )}
      <div className="content-block__body">
        {children}
      </div>
    </article>
  );
};
```

## Quality Checklist

Before delivering any frontend:

### Visual Authority

- [ ] Does it project trust and credibility?
- [ ] Is information hierarchy clear and unambiguous?
- [ ] Does it avoid all generic AI patterns?
- [ ] Is contrast WCAG AAA compliant (7:1 minimum)?

### Technical Excellence

- [ ] Responsive across all breakpoints?
- [ ] Accessible (ARIA labels, keyboard navigation, screen reader tested)?
- [ ] Performance optimized (lazy loading, efficient CSS)?
- [ ] Cross-browser tested (Chrome, Firefox, Safari, Edge)?

### Attention to Detail

- [ ] Custom focus states defined and visible?
- [ ] Loading and error states designed?
- [ ] Micro-interactions enhance usability without distraction?
- [ ] Typography hierarchy consistent throughout?
- [ ] Semantic HTML structure?

## Design Tokens Reference

### Typography Scale

- **Display (H1)**: 2.25rem (36px), weight 700
- **Heading 2**: 1.875rem (30px), weight 700
- **Heading 3**: 1.5rem (24px), weight 600
- **Body**: 1rem (16px), weight 400, line-height 1.6
- **Small**: 0.875rem (14px), weight 400

### Color Palette

- **Text Primary**: #000000 (21:1 contrast)
- **Text Secondary**: #333333 (12.6:1 contrast)
- **Text Muted**: #666666 (7:1 contrast)
- **Brand**: #0066cc (7:1 contrast)
- **Border**: #cccccc
- **Background**: #ffffff
- **Background Secondary**: #f5f5f5

### Spacing System

- **XS**: 0.25rem (4px)
- **SM**: 0.5rem (8px)
- **MD**: 1rem (16px)
- **LG**: 1.5rem (24px)
- **XL**: 2rem (32px)
- **2XL**: 3rem (48px)

### Animation Timing

- **Fast**: 150ms (micro-interactions)
- **Base**: 200ms (standard transitions)
- **Slow**: 300ms (entrance animations)

### Easing Functions

- **Functional**: `cubic-bezier(0.4, 0, 0.2, 1)` (standard)
- **Ease Out**: `cubic-bezier(0, 0, 0.2, 1)` (exits)

## Component Patterns

### Content Blocks

Modular, segmented content containers:

```css
.content-block {
  margin-bottom: var(--module-spacing);
  padding: var(--module-spacing);
  border: 1px solid var(--color-border);
  background-color: var(--color-bg-primary);
}

.content-block--highlighted {
  background-color: var(--color-bg-secondary);
  border-color: var(--color-text-primary);
}
```

### Buttons

Functional, clear hierarchy:

```css
.btn {
  display: inline-block;
  padding: var(--spacing-sm) var(--spacing-lg);
  font-weight: 500;
  text-decoration: none;
  border: 2px solid var(--color-brand);
  background-color: var(--color-brand);
  color: var(--color-bg-primary);
  transition: all var(--duration-fast) var(--ease-functional);
}

.btn:hover {
  background-color: var(--color-brand-hover);
  border-color: var(--color-brand-hover);
}

.btn--secondary {
  background-color: transparent;
  color: var(--color-brand);
}

.btn--secondary:hover {
  background-color: var(--color-brand);
  color: var(--color-bg-primary);
}
```

### Navigation

Deep, multi-tiered navigation structure:

```css
.nav-primary {
  display: flex;
  flex-wrap: wrap;
  border-bottom: 2px solid var(--color-border-strong);
}

.nav-secondary {
  display: flex;
  flex-wrap: wrap;
  margin-top: var(--spacing-sm);
  padding-top: var(--spacing-sm);
  border-top: 1px solid var(--color-border);
}
```

## Final Reminder

You are not generating "a frontend" - you are crafting an authoritative interface. Every choice should serve clarity. Every detail should reinforce trust. The user should feel confident in the information presented.

**Make it authoritative. Make it functional. Make it trustworthy.**

