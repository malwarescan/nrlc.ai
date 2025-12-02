# Quick Fix: CSS Changes Not Showing

## The Problem
CSS changes are in the files but not visible in the browser.

## The Solution: Hard Refresh

**Do this FIRST:**

1. **Chrome/Edge:**
   - Press `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
   - OR: Open DevTools (F12) → Right-click refresh button → "Empty Cache and Hard Reload"

2. **Firefox:**
   - Press `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
   - OR: Press `Ctrl+F5`

3. **Safari:**
   - Press `Cmd+Option+R`
   - OR: Safari menu → Develop → Empty Caches

## Verify Changes Are Applied

After hard refresh, check in browser DevTools:

1. **Open DevTools** (F12)
2. **Inspect the `<html>` element:**
   - Should see: `overflow-x: hidden` and `max-width: 100vw`

3. **Inspect `.hero-isometric`:**
   - Should see: `max-width: 100vw` and `overflow: hidden`

4. **Check Network tab:**
   - CSS files should have `?v=...` query parameter
   - Status should be 200 (not 304 cached)

## If Still Not Working

### Option 1: Clear All Cache
- Chrome: Settings → Privacy → Clear browsing data → Cached images and files
- Firefox: Settings → Privacy → Clear Data → Cached Web Content
- Safari: Safari menu → Preferences → Advanced → Show Develop menu → Develop → Empty Caches

### Option 2: Check CSS File Directly
Open in browser:
- `http://localhost:8000/assets/css/hero-isometric.css?v=...`
- `http://localhost:8000/assets/css/w3c-functional.css?v=...`

Look for these lines:
- `overflow-x: hidden;`
- `max-width: 100vw;`

### Option 3: Disable Cache in DevTools
1. Open DevTools (F12)
2. Go to Network tab
3. Check "Disable cache" checkbox
4. Keep DevTools open while testing
5. Reload page

## Expected Result

After hard refresh, you should see:
- ✅ No horizontal scrolling
- ✅ Hero section constrained to viewport
- ✅ Content properly centered

## Changes Made (For Reference)

**w3c-functional.css:**
- Added `overflow-x: hidden` to html and body
- Added `max-width: 100vw` to html and body

**hero-isometric.css:**
- Added `max-width: 100vw` to `.hero-isometric`
- Added `max-width: 100%` to `.hero-grid`, `.hero-cognition`, `.hero-foreground`
- Added proper container constraints and padding tokens

All changes are confirmed in the files (modified Dec 1 20:48).

