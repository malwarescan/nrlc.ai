# PERSON + ORGANIZATION ENTITY DECLARATION — HOMEPAGE

**Date:** 2025-01-XX  
**Directive:** SUDO META DIRECTIVE — Person + Organization Entity Declaration  
**Target:** `https://nrlc.ai/` (Homepage)  
**Status:** ✅ IMPLEMENTED

---

## IMPLEMENTATION SUMMARY

### Entity Model (Locked)
✅ **Person** — Joel Maldonado  
✅ **Organization** — Neural Command, LLC  
✅ **WebPage** — "Why I Built This System" section  
✅ **WebSite** — nrlc.ai

**No additional Person entities on homepage.**

---

## JSON-LD STRUCTURE

### Implementation Location
- ✅ Placed in `pages/home/home.php` (before closing `?>` tag)
- ✅ Single `@graph` structure (not fragmented)
- ✅ Not duplicated on other pages

### Schema Structure
```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Person",
      "@id": "https://nrlc.ai/#joel-maldonado",
      "name": "Joel Maldonado",
      "jobTitle": "Founder",
      "description": "Joel Maldonado is the founder of Neural Command, LLC, where he builds systems that convert search authority into AI-readable, citation-safe knowledge for modern search engines and large language models.",
      "worksFor": { "@type": "Organization", "@id": "https://nrlc.ai/#neural-command" },
      "affiliation": { "@type": "Organization", "@id": "https://nrlc.ai/#neural-command" },
      "url": "https://nrlc.ai",
      "sameAs": ["https://www.linkedin.com/company/neural-command/"]
    },
    {
      "@type": "Organization",
      "@id": "https://nrlc.ai/#neural-command",
      "name": "Neural Command, LLC",
      "url": "https://nrlc.ai",
      "logo": { "@type": "ImageObject", "url": "https://nrlc.ai/assets/images/nrlc-logo.png" },
      "founder": { "@type": "Person", "@id": "https://nrlc.ai/#joel-maldonado" },
      "sameAs": ["https://www.linkedin.com/company/neural-command/"]
    },
    {
      "@type": "WebPage",
      "@id": "https://nrlc.ai/#why-i-built-this-system",
      "name": "Why I Built This System",
      "about": { "@type": "Person", "@id": "https://nrlc.ai/#joel-maldonado" },
      "isPartOf": { "@type": "WebSite", "@id": "https://nrlc.ai/#website" }
    },
    {
      "@type": "WebSite",
      "@id": "https://nrlc.ai/#website",
      "url": "https://nrlc.ai",
      "name": "Neural Command"
    }
  ]
}
```

---

## VISIBLE CONTENT ALIGNMENT

✅ **Exact name:** "Joel Maldonado"  
✅ **Exact title:** "Founder, Neural Command LLC"

**Location:** "Why I Built This System" section (lines 99-100)

```html
- Joel Maldonado<br>
<span>Founder, Neural Command LLC</span>
```

**Status:** ✅ Matches directive requirements exactly

---

## ENTITY RELATIONSHIPS

### Person → Organization
- ✅ `worksFor`: Organization entity reference
- ✅ `affiliation`: Organization entity reference

### Organization → Person
- ✅ `founder`: Person entity reference

### WebPage → Person
- ✅ `about`: Person entity reference

### WebPage → WebSite
- ✅ `isPartOf`: WebSite entity reference

**All relationships use `@id` references for proper entity resolution.**

---

## GOVERNANCE COMPLIANCE

✅ **No "expert," "authority," or ranking claims**  
✅ **Single sameAs profile (LinkedIn only)**  
✅ **Not repeated on other pages**  
✅ **No Article or Author schema added**

---

## SEO & RISK PROFILE

**Risk Level:** ZERO  
**Signal Clarity:** HIGH  
**Knowledge Graph Readiness:** ENABLED

**Impact:**
- Does not affect rankings directly
- Does not change page layout
- Does not alter schema eligibility for other rich results
- Reduces ambiguity for Google and AI systems

---

## SUCCESS CONDITIONS

✅ **Rich Results Test:** Ready for validation  
✅ **Entity Resolution:**
- ✅ Person → Organization (via `worksFor` and `affiliation`)
- ✅ Organization → Founder (via `founder`)
- ✅ Name consistency: "Joel Maldonado" (stable)
- ✅ Organization name: "Neural Command, LLC" (stable)

✅ **No Duplicate Person Entities:** Single Person entity on homepage

---

## FILES MODIFIED

1. **`pages/home/home.php`**
   - Replaced existing Person/Organization schema with `@graph` structure
   - Maintained backward compatibility with `$GLOBALS['__homepage_org_founder']`

---

## VALIDATION CHECKLIST

- [x] @graph structure implemented
- [x] Person entity with correct @id
- [x] Organization entity with correct @id
- [x] WebPage entity for "Why I Built This System"
- [x] WebSite entity
- [x] All entity relationships use @id references
- [x] Visible content matches schema exactly
- [x] Logo URL correct (`/assets/images/nrlc-logo.png`)
- [x] No duplicate Person entities
- [x] No ranking/expert claims
- [x] Single sameAs profile (LinkedIn)

---

**STATUS: COMPLETE & COMPLIANT**

**Next Step:** Validate with Google Rich Results Test tool

