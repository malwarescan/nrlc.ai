# Tawk.to Chat Widget Implementation Notes

**Date:** 2025-12-24  
**Status:** Implemented Site-Wide

---

## Implementation Details

**Location:** `templates/footer.php` (lines 285-297)  
**Scope:** Site-wide (loads on all pages)  
**Property ID:** `694cc571c149db197d2ebfa7`  
**Widget ID:** `1jd9umkpa`

---

## Localhost Testing

### Expected Behavior
- ✅ Script should load on localhost
- ⚠️ Widget may not display if domain restrictions are enabled in Tawk.to dashboard
- ✅ Script will work normally on production/staging domains

### Troubleshooting Localhost

1. **Check Browser Console:**
   - Open DevTools (F12)
   - Check Console tab for Tawk.to errors
   - Check Network tab to see if `embed.tawk.to` script loads

2. **Verify Script Loading:**
   ```javascript
   // In browser console, check if Tawk_API exists:
   console.log(window.Tawk_API);
   // Should return an object if script loaded
   ```

3. **Check Tawk.to Dashboard Settings:**
   - Go to Tawk.to dashboard
   - Settings → Chat Widget → Domain Restrictions
   - Ensure localhost is allowed OR domain restrictions are disabled
   - Check "Visibility" settings - ensure widget is not hidden

4. **Test on Production:**
   - Widget should work normally on `nrlc.ai` domain
   - No special configuration needed for production

---

## Technical Notes

- Script loads asynchronously (won't block page rendering)
- Uses `crossorigin="*"` for CORS compatibility
- Standard Tawk.to implementation (no modifications)

---

## Verification Checklist

- [x] Script added to footer.php
- [x] Syntax verified (PHP lint passed)
- [ ] Tested on localhost (check console/network)
- [ ] Tested on staging/production domain
- [ ] Verified widget appears and functions correctly
- [ ] Checked domain restrictions in Tawk.to dashboard (if any)

---

## Common Issues

### Widget Not Showing on Localhost
**Cause:** Domain restrictions in Tawk.to dashboard  
**Solution:** Add `localhost` to allowed domains OR disable domain restrictions for testing

### Script Loads But Widget Doesn't Appear
**Cause:** Visibility settings or JavaScript errors  
**Solution:** 
1. Check browser console for errors
2. Verify Tawk.to dashboard visibility settings
3. Check if "Hide widget on load" is enabled

### Works on Production But Not Localhost
**Cause:** Domain restrictions  
**Solution:** This is expected if domain restrictions are enabled. Widget will work on production domain.

---

## Next Steps

1. Test widget on localhost (check browser console)
2. Verify it appears on production domain
3. Configure domain restrictions in Tawk.to dashboard if needed
4. Test chat functionality end-to-end

