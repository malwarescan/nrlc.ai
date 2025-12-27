# Deployment Verification Checklist

## ✅ Completed Changes

1. **P0: 502 Error Fixes**
   - ✅ Added `/healthz` endpoint (always returns 200)
   - ✅ Updated Railway config to use `/healthz`
   - ✅ Ensured `/` route never returns 5xx (fallback in place)
   - ✅ Verified port binding: `php -S 0.0.0.0:$PORT -t public`

2. **Meta/H1/CTA Alignment**
   - ✅ Meta title formula: `{Service} in {Location} | Conversion + AI Visibility | NRLC.ai`
   - ✅ Meta description: Conversion-first messaging
   - ✅ H1: `{Service} for {Location} Businesses`
   - ✅ Subhead: Matches meta description
   - ✅ Primary CTA: `Request a {Location} {Service}` (service-named)
   - ✅ Secondary CTA: "See Proof / Case Studies"

3. **Full Localization**
   - ✅ fr-fr (French): Meta, H1, CTA, qualifiers
   - ✅ es-es (Spanish): Meta, H1, CTA, qualifiers
   - ✅ de-de (German): Meta, H1, CTA, qualifiers
   - ✅ ko-kr (Korean): Meta, H1, CTA, qualifiers
   - ✅ en-us, en-gb (English): Already correct

## 🧪 Post-Deployment Tests

### 1. Healthcheck
```bash
curl -I https://www.nrlc.ai/healthz
# Expected: HTTP/2 200
```

### 2. Homepage
```bash
curl -I https://www.nrlc.ai/
# Expected: HTTP/2 200 (may redirect to /en-us/)
```

### 3. Service Page - en-us
```bash
curl -s https://www.nrlc.ai/en-us/services/chatgpt-optimization/southport/ | grep -E "<title>|<h1"
# Expected:
# - Title: "Chatgpt Optimization in Southport | Conversion + AI Visibility | NRLC.ai"
# - H1: "Chatgpt Optimization for Southport Businesses"
```

### 4. Service Page - fr-fr (Localization)
```bash
curl -s https://www.nrlc.ai/fr-fr/services/chatgpt-optimization/southport/ | grep -E "<title>|<h1"
# Expected:
# - Title: "Chatgpt Optimization à Southport | Conversion + visibilité IA | NRLC.ai"
# - H1: "Chatgpt Optimization pour les entreprises de Southport"
```

### 5. Service Page - ko-kr (Localization)
```bash
curl -s https://www.nrlc.ai/ko-kr/services/chatgpt-optimization/southport/ | grep -E "<title>|<h1"
# Expected:
# - Title: "Southport Chatgpt Optimization | 전환 + AI 가시성 | NRLC.ai"
# - H1: "Southport 비즈니스를 위한 Chatgpt Optimization"
```

## 📊 Monitoring (Next 1-2 Weeks)

1. **Google Search Console**
   - Monitor 5xx errors (should decrease)
   - Check coverage for `/healthz` (should be 200)
   - Watch for crawl errors clearing

2. **Performance Metrics**
   - Track CTR for international pages (fr-fr, es-es, de-de, ko-kr)
   - Compare before/after CTR for all 47 service pages
   - Identify which locales/services improved most

3. **Railway Logs**
   - Verify healthcheck passes consistently
   - Check for any 502 errors
   - Monitor deployment stability

## 🔄 Next Steps (After Data)

- If CTR improves: Continue monitoring, consider 7-section restructure
- If CTR still low: Implement 7-section conversion-first outline
- If specific pages lag: Target those pages for optimization

## 📝 Notes

- Localization functions work correctly when locale is set
- Locale detection may need refinement for HTTP requests
- Core logic is correct; test after deployment to verify HTTP flow

