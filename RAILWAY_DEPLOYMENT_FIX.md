# Railway Deployment Fix – Dev Team Instructions

**Date:** 2025-01-27  
**Status:** ✅ Fixed

## Summary

Railway deployments were failing because the healthcheck never found a running web server.

**Root Cause:** Healthcheck requests (HEAD) were being redirected by `canonical_guard()`, causing Railway to receive redirects instead of 200 OK responses.

## Fix Applied

### 1. Healthcheck Fix (Completed)
- Updated `bootstrap/canonical.php` to skip locale redirects for HEAD requests
- Healthcheck requests now get 200 OK responses
- Regular users still get redirected to `/en-us/` version

### 2. Dockerfile Prevention (Completed)
- Created `.railwayignore` to ensure Railway always uses Nixpacks
- Prevents accidental Dockerfile from overriding Nixpacks configuration

## Current Configuration

### Railway Configuration (`railway.toml`)
```toml
[build]
builder = "nixpacks"

[deploy]
startCommand = "php -S 0.0.0.0:$PORT -t public"
healthcheckPath = "/"
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

If a Dockerfile is accidentally added and causes Railway to ignore Nixpacks:

### Option A — Remove the Dockerfile (Recommended)
```bash
rm Dockerfile
git commit -m "Remove Dockerfile to use Nixpacks"
git push
```

### Option B — Fix the Dockerfile
If Docker must be used, ensure the Dockerfile ends with:
```dockerfile
EXPOSE ${PORT}
CMD ["php", "-S", "0.0.0.0:${PORT}", "-t", "public"]
```

### Option C — Use .railwayignore (Already Done)
The `.railwayignore` file already exists and will prevent Railway from using any Dockerfile.

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
