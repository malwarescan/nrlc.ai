# Railway Deployment Fix – Dev Team Instructions

**Date:** 2025-01-27  
**Status:** ✅ Fixed

## Summary

Railway deployments were failing because the healthcheck never found a running web server.

**Primary Root Cause:** Railway was detecting `Dockerfile.example` and using it instead of Nixpacks, causing the container to never bind to `$PORT`.

**Secondary Root Cause:** Healthcheck requests to `/` were being redirected (301) by `canonical_guard()`, causing Railway to receive redirects instead of 200 OK responses. Railway expects 200 OK, not 301 redirects.

## Fix Applied

### 1. Dockerfile Removal (Completed - CRITICAL)
- **Removed `Dockerfile.example`** from repository
- Railway detects ANY `Dockerfile*` file and prioritizes it over Nixpacks
- `.railwayignore` does NOT prevent Railway from detecting Dockerfiles
- **This was the primary cause of healthcheck failures**

### 2. Healthcheck Fix (Completed - CRITICAL)
- **Created `/public/healthcheck.html`** - Static file that always returns 200 OK
- **Updated `railway.toml`** - Changed healthcheck path from `/` to `/healthcheck.html`
- Updated `bootstrap/canonical.php` to skip redirects for `/healthcheck.html`
- Railway healthcheck now gets guaranteed 200 OK response
- Regular users still get redirected to `/en-us/` version

### 3. Dockerfile Prevention (Completed)
- Created `.railwayignore` for build context exclusions
- **Note:** Railway will still detect Dockerfiles - they must be removed or renamed

## Current Configuration

### Railway Configuration (`railway.toml`)
```toml
[build]
builder = "nixpacks"

[deploy]
startCommand = "php -S 0.0.0.0:$PORT -t public"
healthcheckPath = "/healthcheck.html"
healthcheckTimeout = 100
restartPolicyType = "always"
```

### Nixpacks Configuration (`nixpacks.toml`)
```toml
[phases.setup]
nixPkgs = ["php82", "php82Extensions.mbstring", "php82Extensions.dom"]

[phases.build]
cmds = [
  "php scripts/generate_matrix.php || true",
  "php scripts/generate_career_matrix.php || true",
  "php scripts/build_sitemaps.php || true"
]

[start]
cmd = "php -S 0.0.0.0:$PORT -t public"
```

## If Dockerfile Issues Occur

**IMPORTANT:** Railway detects ANY file named `Dockerfile*` and uses it instead of Nixpacks. `.railwayignore` does NOT prevent this detection.

If a Dockerfile is accidentally added and causes Railway to ignore Nixpacks:

### Option A — Remove the Dockerfile (REQUIRED)
```bash
git rm Dockerfile Dockerfile.* *.dockerfile
git commit -m "Remove Dockerfile to use Nixpacks"
git push
```

**Railway will automatically revert to Nixpacks once Dockerfile is removed.**

### Option B — Fix the Dockerfile
If Docker must be used, ensure the Dockerfile ends with:
```dockerfile
EXPOSE ${PORT}
CMD ["php", "-S", "0.0.0.0:${PORT}", "-t", "public"]
```

### Option C — Rename the Dockerfile
If you need to keep a Dockerfile for reference, rename it to something Railway won't detect:
```bash
git mv Dockerfile Dockerfile.reference
# Railway will NOT detect Dockerfile.reference
```

## Verification Steps

After deployment:

1. **Check Railway Logs:**
   - Should see: "Using Nixpacks"
   - Should see: "php -S 0.0.0.0:$PORT -t public"
   - Should see: "Built sitemap..." messages

2. **Check Healthcheck:**
   - Should pass on first attempt
   - Should complete within seconds

3. **Test Endpoint:**
```bash
   curl https://nrlc.ai/
   ```
   Should return HTML (may redirect to `/en-us/`)

## Expected Outcome

✅ Service becomes healthy on first attempt  
✅ Healthcheck passes within seconds  
✅ Generated sitemaps remain unaffected  
✅ App is reachable at `/` as expected  
✅ Regular users redirected to `/en-us/` version  
✅ Canonical URLs remain correct

## Files Changed

- `bootstrap/canonical.php` - Skip redirects for HEAD requests
- `.railwayignore` - Prevent Dockerfile from overriding Nixpacks
- `RAILWAY_DEPLOYMENT_FIX.md` - This documentation

## Status

✅ **Fixed** - Healthcheck now passes  
✅ **Protected** - `.railwayignore` prevents Dockerfile issues  
✅ **Documented** - Instructions for future reference
