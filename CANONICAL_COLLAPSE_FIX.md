# Canonical Collapse Fix - Complete Implementation Plan

**Date:** December 28, 2025  
**Issue:** Google chooses en-GB as canonical but can't discover it → canonical collapse into void

## Problem Summary

### What Happened
1. Google crawled `/en-us/services/local-seo-ai/norwich/`
2. Google detected locale mismatch (en-US targeting UK city)
3. Google chose `/en-gb/services/local-seo-ai/norwich/` as canonical
4. Google rejected en-US page as duplicate
5. Google tried to crawl en-GB page but **couldn't find it**
6. Result: **Nothing indexed** (canonical collapse)

### Why Google Can't Find en-GB Pages
- ✅ Sitemap includes en-GB URLs (verified)
- ❌ No internal links to en-GB pages
- ❌ No navigation path to en-GB section
- ❌ Sitemap may not be submitted to GSC

## Current Status

### ✅ What's Working
1. **Sitemap Generation** - Correctly includes en-GB URLs for UK cities
2. **Redirects** - Non-canonical locales redirect to en-GB
3. **UK City Detection** - Correctly identifies UK cities
4. **Canonical Tags** - Set correctly in templates

### ❌ What's Missing
1. **Internal Links** - No links to en-GB pages from other pages
2. **Navigation** - No way to navigate to en-GB section
3. **Sitemap Submission** - May not be submitted to GSC
4. **Discovery Path** - Google can't discover en-GB pages

## Fix Implementation

### Phase 1: Immediate (P0)

#### 1.1 Submit Sitemap to Google Search Console
**Action:** Manual step in GSC
- Go to Google Search Console
- Navigate to Sitemaps
- Submit: `https://nrlc.ai/sitemap.xml`
- Verify sitemap is processed

#### 1.2 Add Internal Links to en-GB Pages
**Files to Modify:**
- `pages/services/index.php` - Add links to UK city pages
- `pages/home/home.php` - Add featured UK city links
- `templates/header.php` - Add en-GB navigation option

**Implementation:**
```php
// In services index page, add UK city links
if ($locale === 'en-gb' || $locale === '') {
  $ukCities = ['norwich', 'london', 'manchester', 'birmingham'];
  foreach ($ukCities as $city) {
    echo '<a href="/en-gb/services/local-seo-ai/' . $city . '/">Local SEO in ' . ucfirst($city) . '</a>';
  }
}
```

#### 1.3 Add Navigation to en-GB Section
**File:** `templates/header.php`
- Add "UK Services" link in navigation
- Link to `/en-gb/services/`
- Ensure en-GB section is discoverable

### Phase 2: Enhanced Discovery (P1)

#### 2.1 Add Related Service Links with Correct Locale
**File:** `lib/service_enhancements.php`
- Update `get_related_services_for_linking()` to include city-specific links
- For UK cities, link to other UK city pages in en-GB
- For US cities, link to other US city pages in en-US

#### 2.2 Add City-Specific Internal Links
**File:** `pages/services/service_city.php`
- Add "Other Services in [City]" section
- Link to other services for the same city
- Use correct locale (en-GB for UK, en-US for US)

#### 2.3 Add Breadcrumb Navigation
**File:** `templates/head.php` or `pages/services/service_city.php`
- Add breadcrumb navigation
- Include locale in breadcrumbs
- Make en-GB section visible in navigation path

### Phase 3: Verification (P2)

#### 3.1 Verify Sitemap Submission
- Check GSC for sitemap processing
- Verify en-GB URLs are in sitemap
- Check for sitemap errors

#### 3.2 Verify Internal Links
- Crawl site and verify en-GB pages are linked
- Check that en-GB pages are reachable from homepage
- Verify navigation works

#### 3.3 Request Re-indexing
- In GSC, request re-indexing of en-GB pages
- Specifically: `/en-gb/services/local-seo-ai/norwich/`
- Monitor indexing status

## Code Changes Required

### 1. Update Services Index Page
**File:** `pages/services/index.php`
Add UK city links section:
```php
<?php
// Add UK city links for en-GB locale
if ($locale === 'en-gb' || $locale === '') {
  require_once __DIR__.'/../../lib/helpers.php';
  $ukCities = ['norwich', 'london', 'manchester', 'birmingham', 'leeds'];
  echo '<div class="uk-cities-section">';
  echo '<h2>Local SEO Services in UK Cities</h2>';
  echo '<ul>';
  foreach ($ukCities as $city) {
    if (is_uk_city($city)) {
      echo '<li><a href="/en-gb/services/local-seo-ai/' . $city . '/">Local SEO in ' . ucwords(str_replace('-', ' ', $city)) . '</a></li>';
    }
  }
  echo '</ul>';
  echo '</div>';
}
?>
```

### 2. Update Related Services Function
**File:** `lib/service_enhancements.php`
Update to include city-specific links:
```php
function get_related_services_for_linking(string $serviceSlug, string $locale = '', string $citySlug = ''): array {
  // ... existing code ...
  
  // If city is provided, add city-specific links
  if ($citySlug) {
    require_once __DIR__.'/helpers.php';
    $isUK = is_uk_city($citySlug);
    $canonicalLocale = $isUK ? 'en-gb' : 'en-us';
    
    // Add other services for same city
    $cityServices = [
      'site-audits' => 'Site Audits',
      'technical-seo' => 'Technical SEO',
      'link-building-ai' => 'Link Building',
    ];
    
    foreach ($cityServices as $slug => $name) {
      if ($slug !== $serviceSlug) {
        $related[] = [
          'slug' => $slug,
          'name' => "$name in " . ucwords(str_replace('-', ' ', $citySlug)),
          'url' => "/$canonicalLocale/services/$slug/$citySlug/"
        ];
      }
    }
  }
  
  return $related;
}
```

### 3. Add Homepage Links to en-GB Pages
**File:** `pages/home/home.php`
Add featured UK city links:
```php
<?php
// Add UK city links section
require_once __DIR__.'/../../lib/helpers.php';
$featuredUKCities = ['norwich', 'london', 'manchester'];
echo '<section class="uk-services-section">';
echo '<h2>UK Local SEO Services</h2>';
echo '<ul>';
foreach ($featuredUKCities as $city) {
  echo '<li><a href="/en-gb/services/local-seo-ai/' . $city . '/">Local SEO in ' . ucwords(str_replace('-', ' ', $city)) . '</a></li>';
}
echo '</ul>';
echo '</section>';
?>
```

## Verification Checklist

- [ ] Sitemap submitted to GSC
- [ ] Sitemap processed without errors
- [ ] en-GB URLs visible in sitemap
- [ ] Internal links added to en-GB pages
- [ ] Navigation includes en-GB section
- [ ] Homepage links to en-GB pages
- [ ] Services index links to en-GB pages
- [ ] Related services link to en-GB pages (for UK cities)
- [ ] Breadcrumbs include locale
- [ ] Re-indexing requested in GSC
- [ ] Monitor indexing status over 1-2 weeks

## Expected Outcome

After implementation:
1. Google will discover en-GB pages via sitemap
2. Google will discover en-GB pages via internal links
3. Google will crawl en-GB pages
4. Canonical resolution will succeed
5. Pages will index and rank

## Timeline

- **Week 1:** Implement code changes, submit sitemap
- **Week 2:** Request re-indexing, monitor GSC
- **Week 3-4:** Verify indexing, check rankings

## Next Steps

1. Implement code changes (Phase 1)
2. Submit sitemap to GSC (manual)
3. Request re-indexing of en-GB pages
4. Monitor GSC for indexing status
5. Verify rankings improve

