# Precise Instructions: Flood Barrier Pros Technology Page
## Entity Authority Alignment Fix

**URL:** https://www.floodbarrierpros.com/about/technology/  
**Date:** 2025-01-17  
**Status:** Remove image override to achieve perfect entity alignment

---

## CURRENT ISSUE

The page currently overrides the `image` property with a non-canonical URL:
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "image": {
    "url": "https://www.floodbarrierpros.com/assets/images/joel-maldonado.png"  // ❌ WRONG
  }
}
```

**Problem:** This creates property conflict. Entity home uses `https://nrlc.ai/assets/images/joel-maldonado.png`

---

## EXACT SCHEMA TO USE (COPY-PASTE)

Replace the current Person schema with this **minimal reference**:

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfilePage",
      "@id": "https://www.floodbarrierpros.com/about/technology/#profilepage",
      "url": "https://www.floodbarrierpros.com/about/technology/",
      "mainEntity": {
        "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
      }
    },
    {
      "@type": "Person",
      "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
      "name": "Joel David Maldonado",
      "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
    }
  ]
}
```

**Key Change:** Remove the `image` property entirely.

---

## HTML DISPLAY (Visual Image - Separate from Schema)

If you want to display Joel's photo on the page visually, you can:

**Option A: Use canonical image (recommended)**
```html
<img src="https://nrlc.ai/assets/images/joel-maldonado.png" 
     alt="Joel Maldonado" 
     style="width: 200px; height: auto; border-radius: 4px;">
```

**Option B: Host your own copy (visual only)**
```html
<!-- Fine for HTML display, but NOT in schema -->
<img src="/assets/images/joel-maldonado.png" 
     alt="Joel Maldonado" 
     style="width: 200px; height: auto; border-radius: 4px;">
```

**Rule:** HTML `<img>` tags are separate from schema. You can display any image visually. But schema must use canonical source or omit image property.

---

## OPTIONAL: Add BreadcrumbList Schema

For SERP breadcrumb enhancement, add:

```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "@id": "https://www.floodbarrierpros.com/about/technology/#breadcrumb",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://www.floodbarrierpros.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "About",
      "item": "https://www.floodbarrierpros.com/about/"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Technology",
      "item": "https://www.floodbarrierpros.com/about/technology/"
    }
  ]
}
```

---

## COMPLETE JSON-LD BLOCK (All Schemas Combined)

```json
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfilePage",
      "@id": "https://www.floodbarrierpros.com/about/technology/#profilepage",
      "url": "https://www.floodbarrierpros.com/about/technology/",
      "mainEntity": {
        "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
      }
    },
    {
      "@type": "Person",
      "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
      "name": "Joel David Maldonado",
      "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.floodbarrierpros.com/about/technology/#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.floodbarrierpros.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "About",
          "item": "https://www.floodbarrierpros.com/about/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Technology",
          "item": "https://www.floodbarrierpros.com/about/technology/"
        }
      ]
    }
  ]
}
</script>
```

---

## CHECKLIST

- [ ] Remove `image` property from Person schema
- [ ] Use minimal Person reference (only @id, name, url)
- [ ] Keep ProfilePage.mainEntity pointing to canonical Person @id
- [ ] (Optional) Add BreadcrumbList schema
- [ ] (Optional) Display image in HTML using canonical URL or local copy
- [ ] Validate schema with Google Rich Results Test
- [ ] Test that Person @id matches exactly: `https://nrlc.ai/en-us/about/joel-maldonado/#person`

---

## VALIDATION

After making changes, validate with:
1. **Google Rich Results Test:** https://search.google.com/test/rich-results
2. **Schema Markup Validator:** https://validator.schema.org/
3. **URL Inspection (GSC):** Verify schema is detected correctly

---

## WHY THIS MATTERS

**Current State:** 8.5/10 (image override issue)

**After Fix:** 10/10 (perfect entity alignment)

**Impact:**
- Eliminates property conflicts across surfaces
- Strengthens entity unification signal
- Maximizes cross-domain entity authority
- Ensures Google resolves to canonical entity home for all properties

---

**Next Step:** Replace the Person schema JSON-LD block with the minimal reference above.
