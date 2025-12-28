# QA: Page Structure Uniformity

## Summary

All three new pages have been standardized to match the site's uniform structure.

---

## Pages Fixed

### 1. `/en-us/insights/schema-governance-and-validation/`
**File:** `pages/insights/schema-governance-and-validation.php`

**Issues Fixed:**
- ❌ Was including `head.php` and `header.php` directly (router handles this)
- ❌ Was using `<main class="container">` instead of `<main role="main" class="container">`
- ❌ Was missing `<div class="section__content">` wrapper
- ❌ Was using direct `<h1 class="h1">` and `<h2 class="h2">` instead of content-block structure
- ❌ Was missing footer include
- ❌ JSON-LD structure was inconsistent

**Fixed Structure:**
- ✅ Removed direct `head.php` and `header.php` includes (router handles via `render_page()`)
- ✅ Added `$GLOBALS['__page_slug']` and `$GLOBALS['__insights_nav_added']` flags
- ✅ Changed to `<main role="main" class="container">`
- ✅ Added `<section class="section">` with `<div class="section__content">` wrapper
- ✅ Converted all sections to `<div class="content-block module">` structure
- ✅ Used `<div class="content-block__header">` with `<h1 class="content-block__title">`
- ✅ Used `<div class="content-block__body">` for content
- ✅ Added "Navigation Back to Insights" section
- ✅ Standardized JSON-LD structure
- ✅ Added footer include

---

### 2. `/en-us/insights/enterprise-schema-markup/`
**File:** `pages/insights/enterprise-schema-markup.php`

**Issues Fixed:**
- ❌ Was including `head.php` and `header.php` directly (router handles this)
- ❌ Was using `<main class="container">` instead of `<main role="main" class="container">`
- ❌ Was missing `<div class="section__content">` wrapper
- ❌ Was using direct `<h1 class="h1">` and `<h2 class="h2">` instead of content-block structure
- ❌ Was missing footer include
- ❌ JSON-LD structure was inconsistent

**Fixed Structure:**
- ✅ Removed direct `head.php` and `header.php` includes (router handles via `render_page()`)
- ✅ Added `$GLOBALS['__page_slug']` and `$GLOBALS['__insights_nav_added']` flags
- ✅ Changed to `<main role="main" class="container">`
- ✅ Added `<section class="section">` with `<div class="section__content">` wrapper
- ✅ Converted all sections to `<div class="content-block module">` structure
- ✅ Used `<div class="content-block__header">` with `<h1 class="content-block__title">`
- ✅ Used `<div class="content-block__body">` for content
- ✅ Added "Navigation Back to Insights" section
- ✅ Standardized JSON-LD structure
- ✅ Added footer include

---

### 3. `/en-us/services/enterprise-schema-markup/`
**File:** `pages/services/enterprise-schema-markup.php`

**Issues Fixed:**
- ❌ Was missing footer include

**Fixed Structure:**
- ✅ Structure was already correct (matches standard service page format)
- ✅ Uses `<main role="main" class="container">`
- ✅ Uses `<section class="section">` with `<div class="section__content">` wrapper
- ✅ Uses `<div class="content-block module">` structure throughout
- ✅ JSON-LD is properly structured and placed before main content
- ✅ Added footer include

---

## Standard Structure Reference

### Insight Pages (Standard Format)
```php
<?php
$GLOBALS['__page_slug'] = 'insights/article';
$GLOBALS['__insights_nav_added'] = true;
// Note: head.php and header.php are already included by router.php render_page()
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Title</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Lead paragraph</p>
        <!-- Content -->
      </div>
    </div>

    <!-- More content blocks -->

    <div class="content-block module">
      <div class="content-block__body">
        <p><a href="/en-us/insights/" class="btn">← View All Research & Insights</a></p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD Schema
$GLOBALS['__jsonld'] = [...];

require_once __DIR__.'/../../templates/footer.php';
?>
```

### Service Pages (Standard Format)
```php
<?php
// Note: head.php and header.php are already included by router.php render_page()
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Title</h1>
      </div>
      <div class="content-block__body">
        <!-- Content -->
      </div>
    </div>

    <!-- More content blocks -->

  </div>
</section>
</main>

<?php require_once __DIR__.'/../../templates/footer.php'; ?>
```

---

## Verification

All pages have been verified for:
- ✅ PHP syntax (no errors)
- ✅ Consistent HTML structure
- ✅ Proper content-block module usage
- ✅ Footer includes
- ✅ JSON-LD schema structure

---

## Status

**All pages are now uniform and match the site's standard structure.**

