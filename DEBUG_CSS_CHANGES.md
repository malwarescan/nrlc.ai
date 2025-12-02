# Debug: Why CSS Changes Aren't Showing

## Changes Confirmed in Files

✅ **w3c-functional.css** - Lines 20-21, 34-35:
- `overflow-x: hidden` on html
- `max-width: 100vw` on html  
- `overflow-x: hidden` on body
- `max-width: 100vw` on body

✅ **hero-isometric.css** - Multiple locations:
- Line 14: `max-width: 100vw` on `.hero-isometric`
- Line 50: `max-width: 100%` on `.hero-grid`
- Line 115: `max-width: 100%` on `.hero-cognition`
- Line 446: `max-width: 100%` on `.hero-foreground`
- Line 449: `max-width: var(--container-max-width)` on desktop `.hero-foreground`

## Cache Busting

The `asset_url()` function uses file modification time for cache busting:
```php
function asset_url(string $path): string {
  $abs = __DIR__ . '/../public' . $path;
  $ver = file_exists($abs) ? substr(md5((string)@filemtime($abs)),0,8) : '0';
  return $path . '?v=' . $ver;
}
```

This means CSS files should auto-update when files change.

## Possible Issues

### 1. Browser Cache
**Solution:** Hard refresh the page:
- **Chrome/Firefox:** `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
- **Safari:** `Cmd+Option+R`
- Or clear browser cache completely

### 2. CSS Not Loading
**Check:** Open browser DevTools → Network tab → Reload page → Look for CSS files
- Should see `w3c-functional.css?v=...` and `hero-isometric.css?v=...`
- Check if they return 200 status
- Check if the `?v=` parameter changes after file modification

### 3. CSS Specificity Conflicts
**Check:** Inspect element in DevTools → Check Computed styles
- Look for `overflow-x` and `max-width` values
- Check if other CSS rules are overriding our changes
- Look for `!important` flags that might conflict

### 4. Other CSS Files Loading After
**Check:** In DevTools → Sources → Check CSS load order
- `w3c-functional.css` should load first
- `hero-isometric.css` should load after
- Check if other CSS files (like `tailwind.css`, `nrlc98.css`) are overriding

### 5. Inline Styles
**Check:** Look for inline `style=""` attributes on elements
- Inline styles override CSS files
- Check `<html>`, `<body>`, and `.hero-isometric` elements

## Debugging Steps

1. **Verify CSS is loading:**
   ```javascript
   // In browser console:
   Array.from(document.styleSheets).forEach(sheet => {
     console.log(sheet.href);
   });
   ```

2. **Check computed styles:**
   ```javascript
   // In browser console:
   const hero = document.querySelector('.hero-isometric');
   console.log(getComputedStyle(hero).overflowX);
   console.log(getComputedStyle(hero).maxWidth);
   ```

3. **Check for conflicts:**
   ```javascript
   // In browser console:
   const html = document.documentElement;
   console.log(getComputedStyle(html).overflowX);
   console.log(getComputedStyle(html).maxWidth);
   ```

4. **Force reload CSS:**
   - Open DevTools → Network tab
   - Check "Disable cache"
   - Reload page

## Expected Behavior

After changes:
- ✅ No horizontal scrolling on any page
- ✅ Hero section never exceeds viewport width
- ✅ Background layers constrained to container
- ✅ Content properly centered with max-width constraints

## If Still Not Working

1. Check if PHP server is running and serving updated files
2. Verify file permissions allow reading CSS files
3. Check server logs for 404 errors on CSS files
4. Try accessing CSS files directly: `http://localhost:8000/assets/css/hero-isometric.css?v=...`
5. Check if there's a CDN or proxy caching CSS files

