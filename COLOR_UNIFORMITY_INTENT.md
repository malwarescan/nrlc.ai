# Color Uniformity Intent

## Overview
NRLC.ai uses a strict 2-color + 1 shade palette to ensure visual consistency, brand coherence, and professional appearance across all pages, components, and UI elements.

---

## Color Palette

### Main Colors
1. **Primary Color:** `#12355e` (Dark Blue)
   - Primary brand color
   - Used for: Links, buttons, accents, interactive elements, hero animations
   - RGB: `rgb(18, 53, 94)`
   - RGBA: `rgba(18, 53, 94, alpha)`

2. **Secondary Color:** `#000000` (Black)
   - Text primary, strong borders, emphasis
   - Used for: Headings, body text, strong separators, active states
   - RGB: `rgb(0, 0, 0)`

### Shade Color
3. **Shade:** `#2a4a6e` (Lighter Blue)
   - Derived from primary color
   - Used for: Borders, hover states, muted text, secondary elements, subtle backgrounds
   - RGB: `rgb(42, 74, 110)`
   - RGBA: `rgba(42, 74, 110, alpha)`

---

## Uniformity Rules

### 1. Text Colors
- **Primary Text:** `#000000` (black) - All headings, body text, primary content
- **Secondary Text:** `#12355e` (primary blue) - Links, emphasized text
- **Muted Text:** `#2a4a6e` (shade) - Subtle text, captions, metadata

### 2. Background Colors
- **Primary Background:** `#ffffff` (white) - Main page backgrounds
- **Secondary Background:** `#f5f5f5` (light gray) - Section separation
- **Tertiary Background:** `#e8e8e8` (lighter gray) - Subtle separation

### 3. Border Colors
- **Standard Borders:** `#2a4a6e` (shade) - Regular borders, dividers
- **Strong Borders:** `#000000` (black) - Emphasis, strong separation

### 4. Interactive Elements
- **Links:** `#12355e` (primary)
- **Link Hover:** `#2a4a6e` (shade)
- **Link Active:** `#000000` (black)
- **Buttons Primary:** `#12355e` background, white text
- **Buttons Secondary:** White background, `#12355e` border/text

### 5. Hero Animation Colors
- **Nodes:** `rgba(18, 53, 94, 0.15)` - Subtle primary color
- **Edges/Lines:** `rgba(18, 53, 94, 0.4)` - Primary color
- **Shadows:** `rgba(18, 53, 94, 0.2)` - Primary color
- **Bullets:** `rgba(18, 53, 94, 0.8)` - Primary color with glow
- **Grids:** `rgba(18, 53, 94, 0.3)` - Primary color

---

## Prohibited Colors

### Never Use
- ❌ `#0066cc` (old brand blue)
- ❌ `#02BBFB` (cyan/teal)
- ❌ `#cc0000` (red) - unless for critical errors only
- ❌ `#00cc00` (green) - unless for success states only
- ❌ `#ff6600` (orange) - unless for warnings only
- ❌ Any color not in the 2-color + shade palette

### Exception: Status Colors (Use Sparingly)
- **Success:** `#12355e` (primary) - Use primary color
- **Error:** `#000000` (black) - Use secondary color
- **Warning:** `#2a4a6e` (shade) - Use shade color

---

## Implementation Standards

### CSS Variables
All colors must use CSS variables defined in `w3c-functional.css`:

```css
--color-primary: #12355e;
--color-secondary: #000000;
--color-shade: #2a4a6e;
```

### Direct Hex Usage
Only use direct hex values when:
- CSS variables are not available
- Hero animation rgba() conversions
- SVG fill/stroke attributes

### RGBA Conversions
When opacity is needed, convert hex to rgba:
- `#12355e` → `rgba(18, 53, 94, alpha)`
- `#000000` → `rgba(0, 0, 0, alpha)`
- `#2a4a6e` → `rgba(42, 74, 110, alpha)`

---

## Component-Specific Rules

### Buttons
- Primary: `#12355e` background, white text
- Secondary: White background, `#12355e` border/text
- Hover: `#2a4a6e` (shade)
- Active: `#000000` (black)

### Links
- Default: `#12355e` (primary)
- Hover: `#2a4a6e` (shade)
- Active: `#000000` (black)

### Borders
- Standard: `#2a4a6e` (shade)
- Strong: `#000000` (black)
- Subtle: `rgba(18, 53, 94, 0.2)` (primary with opacity)

### Hero Elements
- All animation elements use `rgba(18, 53, 94, ...)` variations
- No other colors allowed in hero section
- Background: White (`#ffffff`) or transparent

---

## Enforcement

### Code Review Checklist
- [ ] All colors use CSS variables or approved hex values
- [ ] No old brand colors (`#0066cc`, `#02BBFB`) present
- [ ] Hero animations use `rgba(18, 53, 94, ...)` only
- [ ] Text colors follow hierarchy (black → primary → shade)
- [ ] Borders use shade or black only
- [ ] Interactive elements use primary color

### Automated Checks
- Linter should flag any hex colors not in approved palette
- CSS variables should be used instead of direct hex values
- RGBA values must convert from approved hex colors only

---

## Visual Hierarchy

### Color Usage Priority
1. **Black (`#000000`):** Primary text, strong emphasis
2. **Primary (`#12355e`):** Interactive elements, brand identity
3. **Shade (`#2a4a6e`):** Subtle elements, borders, hover states

### Opacity Guidelines
- **Full Opacity (1.0):** Text, solid backgrounds, borders
- **High Opacity (0.6-0.8):** Interactive elements, buttons
- **Medium Opacity (0.3-0.5):** Subtle backgrounds, borders
- **Low Opacity (0.1-0.2):** Shadows, overlays, hints

---

## Migration Notes

### Old Colors → New Colors
- `#0066cc` → `#12355e` (primary)
- `#0052a3` → `#2a4a6e` (shade)
- `#003d7a` → `#000000` (black)
- `#02BBFB` → `#12355e` (primary)

### Status Colors Migration
- Success: `#006600` → `#12355e` (use primary)
- Error: `#cc0000` → `#000000` (use black)
- Warning: `#cc6600` → `#2a4a6e` (use shade)

---

## Brand Identity

### Color Psychology
- **Primary (`#12355e`):** Trust, professionalism, technology, depth
- **Secondary (`#000000`):** Authority, clarity, precision, contrast
- **Shade (`#2a4a6e`):** Subtlety, hierarchy, refinement

### Usage Philosophy
- Minimal color palette reinforces technical precision
- Two-color system ensures clarity and focus
- Shade provides necessary visual hierarchy without complexity
- No decorative colors—every color serves a functional purpose

---

## Maintenance

### Regular Audits
- Monthly color audit across all pages
- Verify CSS variables are used consistently
- Check for any hardcoded colors outside palette
- Ensure hero animations use correct rgba values

### Documentation Updates
- Update this document when palette changes
- Document any exceptions or special cases
- Maintain color conversion reference table

---

## Summary

**Intent:** Create a unified, professional visual identity using only 2 main colors (`#12355e` and `#000000`) plus 1 shade (`#2a4a6e`), ensuring consistency across all pages, components, and UI elements while maintaining clear visual hierarchy and brand coherence.

