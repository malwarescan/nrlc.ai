# Vertical Centering Root Cause Analysis

## Root Cause Identified

### Issue 1: Insufficient Parent Height
**Location:** `.hero-isometric` (line 15)
**Problem:** Using `min-height: 50vh` instead of `min-height: 100vh`
**Impact:** Hero section doesn't take full viewport height, preventing proper vertical centering

### Issue 2: Missing Flex Direction on Parent
**Location:** `.hero-isometric` (line 26)
**Problem:** Has `display: flex` and `align-items: center` but missing `flex-direction: column` and `justify-content: center`
**Impact:** Content centers horizontally but not vertically

### Issue 3: Child Container Height Collapse
**Location:** `.hero-foreground` (line 444)
**Problem:** Has `min-height: auto` which collapses to content height
**Impact:** Child doesn't fill parent, so `justify-content: center` has no effect

### Issue 4: Missing Header Height Compensation
**Location:** Header structure
**Problem:** If header is fixed/sticky, hero needs padding-top compensation
**Impact:** Content pushed down, not centered in viewport

## Container Path Analysis

```
html (overflow-x: hidden ✅)
└── body (overflow-x: hidden ✅)
    └── header.site-header (needs height check)
    └── section.hero-isometric (❌ min-height: 50vh - TOO SHORT)
        ├── div.hero-grid (absolute, z-index: 2)
        ├── div.hero-cognition (absolute, z-index: 2)
        └── div.hero-foreground (❌ min-height: auto - COLLAPSES)
            └── div.content-block (content)
```

## Fixes Required

1. Change `.hero-isometric` `min-height` from `50vh` to `100vh` (mobile-first)
2. Add `flex-direction: column` and `justify-content: center` to `.hero-isometric`
3. Change `.hero-foreground` `min-height` from `auto` to `100%` to fill parent
4. Add header height compensation if header is fixed/sticky
5. Ensure proper mobile-first breakpoint handling

