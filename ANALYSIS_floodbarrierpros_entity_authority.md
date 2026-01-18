# Deep Analysis: Cross-Domain Entity Authority
## Flood Barrier Pros → NRLC.ai Person Entity Reference

**URL Analyzed:** https://www.floodbarrierpros.com/about/technology/  
**Date:** 2025-01-17

---

## WHAT THEY'RE DOING RIGHT ✅

### 1. **Canonical Person @id Reference (PERFECT)**
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "name": "Joel David Maldonado",
  "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
}
```

**Analysis:**
- ✅ Uses canonical Person @id from NRLC.ai (not minting new entity)
- ✅ Cross-domain entity linking (builds Knowledge Graph connections)
- ✅ URL points to entity home
- ✅ Name matches canonical entity

**Impact:** This creates a cross-domain entity link. Google sees:
- floodbarrierpros.com references `https://nrlc.ai/en-us/about/joel-maldonado/#person`
- This reinforces NRLC.ai as the canonical source for this Person entity
- External validation of entity authority

### 2. **ProfilePage Structure (CORRECT)**
```json
{
  "@type": "ProfilePage",
  "@id": "https://www.floodbarrierpros.com/about/technology/#profilepage",
  "mainEntity": {
    "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
  }
}
```

**Analysis:**
- ✅ ProfilePage.mainEntity points to canonical Person @id
- ✅ Declares this page is ABOUT the Person entity
- ✅ Doesn't mint a new Person entity on this page

---

## POTENTIAL ISSUES ⚠️

### Issue 1: Image URL Override
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "image": {
    "@type": "ImageObject",
    "url": "https://www.floodbarrierpros.com/assets/images/joel-maldonado.png"
  }
}
```

**Analysis:**
- ⚠️ **RISK:** Overriding `image` property on external site
- The canonical Person entity (on NRLC.ai) defines: `https://nrlc.ai/assets/images/joel-maldonado.png`
- External site uses: `https://www.floodbarrierpros.com/assets/images/joel-maldonado.png`

**Best Practice:**
- External sites should reference the canonical Person @id ONLY
- Should NOT override properties that are defined on the entity home
- If they need a different image, they should use it in their OWN schema (not on the Person reference)

**Recommendation:**
- External sites should use MINIMAL Person reference:
  ```json
  {
    "@type": "Person",
    "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
    "name": "Joel David Maldonado",
    "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
  }
  ```
- NO `image`, NO `jobTitle`, NO `sameAs` - these belong only on entity home

---

## WHAT THIS MEANS FOR ENTITY AUTHORITY

### Cross-Domain Entity Building (STRONG SIGNAL)

When external sites reference the canonical Person @id:

1. **Knowledge Graph Reinforcement**
   - Google sees: Multiple domains reference same Person @id
   - Strengthens NRLC.ai as canonical entity source
   - Builds entity authority through external validation

2. **Trust Signal**
   - External attribution reinforces expertise
   - Cross-domain links increase entity prominence
   - Signals that this Person entity is recognized beyond own domain

3. **E-E-A-T Benefits**
   - External references to Person = Experience signal
   - Cross-domain validation = Authority signal
   - Consistent @id usage = Trust signal

---

## SCHEMA QUALITY COMPARISON

### Flood Barrier Pros Technology Page:
- ✅ ProfilePage with mainEntity reference
- ✅ Person @id reference (canonical)
- ⚠️ Image override (should be removed)
- ❌ No Organization reference linking to NRLC.ai (if applicable)
- ❌ Missing BreadcrumbList (for SERP breadcrumbs)

### NRLC.ai Entity Home (Gold Standard):
- ✅ Full Person payload (ONLY on entity home)
- ✅ ProfilePage.mainEntity → Person @id
- ✅ Organization reference (worksFor)
- ✅ sameAs links (visible in HTML + schema)
- ✅ Image from canonical source
- ✅ BreadcrumbList
- ✅ WebPage schema

---

## RECOMMENDATIONS FOR EXTERNAL SITES

### Pattern for External Sites Referencing Canonical Person:

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfilePage",
      "@id": "https://externalsite.com/about/technology/#profilepage",
      "url": "https://externalsite.com/about/technology/",
      "mainEntity": {
        "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
      }
    },
    {
      "@type": "Person",
      "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
      "name": "Joel David Maldonado",
      "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
      // DO NOT ADD: image, jobTitle, sameAs, worksFor
    }
  ]
}
```

**Key Rules:**
1. ✅ Always use canonical Person @id
2. ✅ Use minimal Person reference (name, url, @id only)
3. ❌ DO NOT override properties defined on entity home
4. ❌ DO NOT mint new Person entities
5. ✅ Use ProfilePage.mainEntity to declare relationship

---

## VERDICT

**Status:** ✅ **MOSTLY CORRECT** - Strong cross-domain entity linking

**Strengths:**
- Canonical Person @id usage is perfect
- ProfilePage structure is correct
- Cross-domain entity authority building works

**Improvements Needed:**
- Remove `image` override (use canonical source only)
- Consider adding BreadcrumbList
- Ensure Organization schema exists (separate from Person)

**Entity Authority Impact:** **HIGH** - This external reference significantly reinforces NRLC.ai as the canonical Person entity source.
