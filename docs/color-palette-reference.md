# NRLC.ai Color Palette Reference

**Last Updated:** 2025-12-24  
**Primary CSS File:** `public/assets/css/w3c-functional.css`

---

## PRIMARY COLOR SYSTEM (W3C Functional Design)

### Core Colors

| Color Variable | Hex Code | Usage | Notes |
|---------------|----------|-------|-------|
| `--color-primary` | `#12355e` | Main color 1 - Dark blue | Primary brand color |
| `--color-secondary` | `#000000` | Main color 2 - Black | Secondary/strong elements |
| `--color-shade` | `#2a4a6e` | Lighter version of primary | Borders, muted text |

### Text Colors

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--color-text-primary` | `#000000` | Main text color (black) |
| `--color-text-secondary` | `#12355e` | Secondary text (dark blue) |
| `--color-text-muted` | `#2a4a6e` | Muted/secondary text (blue-gray) |

### Background Colors

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--color-bg-primary` | `#ffffff` | Primary background (white) |
| `--color-bg-secondary` | `#f5f5f5` | Secondary background (light gray) |
| `--color-bg-tertiary` | `#e8e8e8` | Tertiary background (lighter gray) |

### Border Colors

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--color-border` | `#2a4a6e` | Standard borders (blue-gray) |
| `--color-border-strong` | `#000000` | Strong borders (black) |

### Brand Colors

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--color-brand` | `#12355e` | Brand color (dark blue) |
| `--color-brand-hover` | `#2a4a6e` | Brand hover state |
| `--color-brand-active` | `#000000` | Brand active state |

### Status Colors

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--color-success` | `#12355e` | Success states (uses primary) |
| `--color-error` | `#000000` | Error states (uses black) |
| `--color-warning` | `#2a4a6e` | Warning states (uses shade) |

### Focus Indicator

| Color | Hex Code | Usage |
|-------|----------|-------|
| Focus outline | `#0066cc` | WCAG AAA compliant focus indicator |

### Hardcoded Colors in CSS

| Hex Code | Usage | Location |
|----------|-------|----------|
| `#000000` | Black text, borders | Body color, multiple uses |
| `#ffffff` | White background | Body background, buttons |
| `#0066cc` | Focus outline | Focus accessibility |
| `#f5f5f5` | Light gray background | Secondary backgrounds |
| `#e8e8e8` | Lighter gray | Tertiary backgrounds |
| `#f0f0f0` | Light gray variant | Some backgrounds |
| `#c0c0c0` | Medium gray | Windows 98 theme |
| `#808080` | Mid gray | Windows 98 theme |
| `#202020` | Dark gray | Dark mode (disabled) |
| `#2a2a2a` | Dark gray | Dark mode (disabled) |
| `#3a3a3a` | Dark gray | Dark mode (disabled) |

---

## SECONDARY COLOR SYSTEM (NRLC98 Theme)

**File:** `public/assets/css/nrlc98.css`  
**Note:** Retro-futuristic Windows 98 × Early Apple aesthetic

### Windows 98 Palette

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--win-bg` | `#c0c0c0` | Classic Win98 gray background |
| `--win-face` | `#e8e8e8` | Early Apple light gray |
| `--win-dark` | `#808080` | Win98 dark gray |
| `--win-light` | `#ffffff` | Pure white |
| `--win-text` | `#000000` | Classic black text |

### Brand Colors (NRLC98)

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--brand` | `#0066cc` | Early Apple blue |
| `--brand-ink` | `#003366` | Darker blue variant |

### Status Colors (NRLC98)

| Color Variable | Hex Code | Usage |
|---------------|----------|-------|
| `--ok` | `#00cc00` | Classic Apple green |
| `--warn` | `#ff9900` | Early Apple orange |
| `--err` | `#cc0000` | Classic Apple red |
| `--accent` | `#ff6600` | Early Apple accent |

### Additional NRLC98 Colors

| Hex Code | Usage |
|----------|-------|
| `#4a9eff` | Dark mode brand (disabled) |
| `#7bb3ff` | Dark mode brand-ink (disabled) |

---

## INLINE/SPECIAL USE COLORS

### Homepage Special Colors

| Hex Code | Usage | Location |
|----------|-------|----------|
| `#fff3cd` | Prechunking course background | Homepage course CTA |
| `#ffc107` | Prechunking course border | Homepage course CTA |
| `#856404` | Prechunking course text | Homepage course CTA |
| `#4a90e2` | Blue accent (comparison boxes) | Homepage comparison section |
| `#f0f7ff` | Light blue background | Homepage comparison boxes |
| `#f9f9f9` | Light gray background | Homepage info boxes |
| `#0B1220` | Dark blue gradient start | Homepage CTA (old version) |
| `#1a1f3a` | Dark blue gradient end | Homepage CTA (old version) |
| `#e0e0e0` | Light gray text | Homepage CTA (old version) |

### Hero Animation Colors

| Hex Code | Usage | Location |
|----------|-------|----------|
| `rgba(18, 53, 94, 0.15)` | Hero overlay (primary with 15% opacity) | `hero-isometric.css` |
| `rgba(18, 53, 94, 0.25)` | Hero overlay darker | `hero-isometric.css` |
| `rgba(18, 53, 94, 0.4)` | Hero stroke | `hero-isometric.css` |
| `rgba(18, 53, 94, 0.8)` | Hero button background | `hero-isometric.css` |
| `rgba(0, 0, 0, 0.5)` | Backdrop overlay | Contact sheet |
| `rgba(0, 0, 0, 0.1)` | Border with opacity | Various |
| `rgba(0, 0, 0, 0.2)` | Border with opacity | Various |
| `rgba(0, 0, 0, 0.3)` | Shadow opacity | Dark mode (disabled) |
| `rgba(0, 0, 0, 0.4)` | Shadow opacity | Dark mode (disabled) |

### Progress Indicator Colors

| Hex Code | Usage | Location |
|----------|-------|----------|
| `#0080ff` | Progress bar blue | `progress-indicator.css` |
| `#40a0ff` | Progress bar light blue | `progress-indicator.css` |
| `#004080` | Progress bar border | `progress-indicator.css` |
| `#404040` | Dark gray background | Dark progress bar |
| `#0066cc` | Progress bar alternative | `progress-indicator.css` |
| `#3388dd` | Progress bar alternative light | `progress-indicator.css` |

---

## COLOR SUMMARY

### Primary Palette (Main Design System)
- **Dark Blue:** `#12355e` (Primary brand color)
- **Black:** `#000000` (Secondary, strong elements)
- **Blue-Gray:** `#2a4a6e` (Shade, borders, muted)
- **White:** `#ffffff` (Backgrounds)
- **Light Gray:** `#f5f5f5` (Secondary backgrounds)
- **Lighter Gray:** `#e8e8e8` (Tertiary backgrounds)

### Accent Colors (Special Use)
- **Focus Blue:** `#0066cc` (Accessibility focus indicator)
- **NRLC98 Blue:** `#0066cc` (Retro theme brand)
- **NRLC98 Orange:** `#ff6600` (Retro theme accent)
- **Yellow/Amber:** `#ffc107`, `#fff3cd` (Prechunking course highlights)

### Status Colors (NRLC98 Theme Only)
- **Green:** `#00cc00` (Success)
- **Orange:** `#ff9900` (Warning)
- **Red:** `#cc0000` (Error)

---

## COLOR USAGE GUIDELINES

### Primary Brand Colors
- Use `#12355e` for primary brand elements, buttons, links
- Use `#2a4a6e` for hover states and borders
- Use `#000000` for strong emphasis, strong borders

### Background Hierarchy
- Primary: `#ffffff` (white) - main content areas
- Secondary: `#f5f5f5` - subtle sections, cards
- Tertiary: `#e8e8e8` - alternate backgrounds

### Text Hierarchy
- Primary: `#000000` (black) - main content
- Secondary: `#12355e` (dark blue) - emphasis
- Muted: `#2a4a6e` (blue-gray) - secondary information

---

## NOTES

1. **Dark Mode:** Currently disabled - all dark mode colors are commented out
2. **WCAG Compliance:** Primary text (`#000000`) on white (`#ffffff`) provides 21:1 contrast (WCAG AAA)
3. **Focus Indicator:** Uses `#0066cc` for WCAG AAA compliant focus visibility
4. **Opacity Variants:** Primary color `#12355e` used with rgba() for overlays and effects

