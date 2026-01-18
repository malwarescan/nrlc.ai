# Multi-Surface Entity Authority Alignment Analysis
## How Cross-Domain Person @id References Build Unified Entity Authority

**Canonical Person Entity:** `https://nrlc.ai/en-us/about/joel-maldonado/#person`  
**Goal:** All surfaces reference the same @id to create unified entity prominence

---

## THE ENTITY AUTHORITY NETWORK EFFECT

### What Happens When Multiple Surfaces Reference the Same @id

When external sites (floodbarrierpros.com, other client sites, partner sites) all reference `https://nrlc.ai/en-us/about/joel-maldonado/#person`:

**Google's Knowledge Graph sees:**
```
floodbarrierpros.com → references → nrlc.ai/en-us/about/joel-maldonado/#person
clientsite2.com → references → nrlc.ai/en-us/about/joel-maldonado/#person
partnersite.com → references → nrlc.ai/en-us/about/joel-maldonado/#person
nrlc.ai → defines → nrlc.ai/en-us/about/joel-maldonado/#person (FULL PAYLOAD)
```

**Result:** Network effect builds entity prominence. Each reference:
1. Reinforces NRLC.ai as canonical source
2. Increases entity prominence signals
3. Strengthens Knowledge Graph connections
4. Builds cross-domain trust validation

---

## CRITICAL PATTERN: ONE ENTITY HOME, MANY REFERENCES

### Entity Home (NRLC.ai) - FULL PAYLOAD
**Location:** `https://nrlc.ai/en-us/about/joel-maldonado/`

**Schema Includes:**
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "name": "Joel David Maldonado",
  "jobTitle": "AI Search Optimization Researcher",
  "url": "https://nrlc.ai/en-us/about/joel-maldonado/",
  "worksFor": { "@id": "https://nrlc.ai/#organization" },
  "sameAs": [
    "https://www.linkedin.com/in/agentic-search/",
    "https://medium.com/@schemata",
    "https://github.com/malwarescan"
  ],
  "knowsAbout": ["AI", "SEO", "Structured Data", ...],
  "image": {
    "@type": "ImageObject",
    "url": "https://nrlc.ai/assets/images/joel-maldonado.png"
  }
}
```

**Properties:** FULL (all Person properties defined here)

---

### External Sites (floodbarrierpros.com, etc.) - MINIMAL REFERENCE

**Schema Pattern:**
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "name": "Joel David Maldonado",
  "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
}
```

**Properties:** MINIMAL (only @id, name, url - NO overrides)

**Why Minimal:**
- Prevents entity fragmentation
- Ensures Google resolves to canonical entity home for full data
- Avoids conflicting property values across surfaces
- Maintains single source of truth

---

## WHAT EXTERNAL SITES SHOULD/SHOULDN'T DO

### ✅ CORRECT: Minimal Person Reference

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfilePage",
      "@id": "https://externalsite.com/about/technology/#profilepage",
      "mainEntity": {
        "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
      }
    },
    {
      "@type": "Person",
      "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
      "name": "Joel David Maldonado",
      "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
      // MINIMAL - no image, no jobTitle, no sameAs, no worksFor
    }
  ]
}
```

### ❌ WRONG: Property Overrides (Causes Entity Fragmentation)

```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "name": "Joel David Maldonado",
  "image": {
    "url": "https://externalsite.com/images/joel.png"  // ❌ OVERRIDE
  },
  "jobTitle": "System Designer",  // ❌ OVERRIDE (different from entity home)
  "sameAs": ["https://different-profile.com"]  // ❌ OVERRIDE
}
```

**Problem:** Overrides create conflicting signals. Google must choose:
- Which image is canonical?
- Which jobTitle is correct?
- Which sameAs links are authoritative?

**Result:** Entity fragmentation, reduced authority, confusion in Knowledge Graph

---

## MULTI-SURFACE ALIGNMENT RULES

### Rule 1: Same @id Everywhere
**All surfaces must use:** `https://nrlc.ai/en-us/about/joel-maldonado/#person`

**Never mint:**
- `https://externalsite.com/#joel-maldonado`
- `https://nrlc.ai/#joel`
- `https://clientsite.com/about/joel`

### Rule 2: Entity Home Defines All Properties
- Full Person payload exists ONLY on `https://nrlc.ai/en-us/about/joel-maldonado/`
- All properties (image, jobTitle, sameAs, knowsAbout, worksFor) defined there
- External sites reference, never override

### Rule 3: External References Are Minimal
**Include:**
- `@id` (canonical)
- `@type` (Person)
- `name` (for display/clarity)
- `url` (entity home URL)

**Never Include on External Sites:**
- `image` (use canonical source)
- `jobTitle` (may differ across contexts)
- `sameAs` (entity home is source of truth)
- `knowsAbout` (entity home defines expertise)
- `worksFor` (entity home defines relationships)
- `description` (entity home defines description)

### Rule 4: ProfilePage Pattern for Attribution
External sites declaring "this is about Joel Maldonado" should use:
```json
{
  "@type": "ProfilePage",
  "mainEntity": {
    "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
  }
}
```

This tells Google: "This page is ABOUT the Person entity" without redefining the entity.

---

## ENTITY AUTHORITY BUILDING ACROSS SURFACES

### Surface Types and Their Role

| Surface Type | Schema Pattern | Purpose | Authority Impact |
|-------------|----------------|---------|------------------|
| **Entity Home** (NRLC.ai) | Full Person payload | Canonical definition | HIGH - Source of truth |
| **Client Sites** (floodbarrierpros.com) | Minimal Person reference | External validation | MEDIUM - Cross-domain trust |
| **Partner Sites** | Minimal Person reference | Network expansion | MEDIUM - Authority signal |
| **Social Profiles** | Not schema, but sameAs links | Identity unification | HIGH - SameAs consolidation |
| **NRLC.ai Articles** | Minimal Person reference | Internal linking | HIGH - Domain authority |

### Authority Signal Stacking

**Each external reference adds:**
1. **Cross-Domain Validation** - "Multiple sites recognize this entity"
2. **Trust Signal** - "External attribution = legitimacy"
3. **Prominence Boost** - "More references = more important entity"
4. **Knowledge Graph Strength** - "Unified entity across domains"

**Formula:**
```
Entity Authority = (Entity Home Quality × Domain Authority) + (External References × Cross-Domain Validation) + (SameAs Unification × Identity Consistency)
```

---

## FLOOD BARRIER PROS SPECIFIC ANALYSIS

### What They Did Right ✅

1. **Canonical @id Usage**
   ```json
   "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
   ```
   - Perfect - no entity fragmentation

2. **ProfilePage Structure**
   ```json
   "@type": "ProfilePage",
   "mainEntity": { "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person" }
   ```
   - Correct - declares relationship without redefining entity

3. **Name Consistency**
   - Uses "Joel David Maldonado" (matches entity home)

### What Should Be Fixed ⚠️

**Issue: Image Override**
```json
{
  "@type": "Person",
  "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
  "image": {
    "url": "https://www.floodbarrierpros.com/assets/images/joel-maldonado.png"
  }
}
```

**Problem:**
- Overrides canonical image: `https://nrlc.ai/assets/images/joel-maldonado.png`
- Creates property conflict across surfaces
- Weakens entity unification signal

**Fix:**
- Remove `image` property entirely
- Let entity home define image
- Google will resolve to canonical source

---

## BEST PRACTICE TEMPLATE FOR EXTERNAL SITES

### Minimal Person Reference (Copy-Paste Template)

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfilePage",
      "@id": "https://yoursite.com/page/#profilepage",
      "url": "https://yoursite.com/page/",
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

**Properties Included:** `@id`, `@type`, `name`, `url`  
**Properties Excluded:** `image`, `jobTitle`, `sameAs`, `knowsAbout`, `worksFor`, `description`

---

## ENTITY AUTHORITY SCORING

### Current Flood Barrier Pros Implementation

**Score: 8.5/10**

**Deductions:**
- -1.0: Image property override (should use canonical source)
- -0.5: Missing BreadcrumbList (minor SERP enhancement)

**Strengths:**
- ✅ Perfect @id usage
- ✅ ProfilePage structure correct
- ✅ Minimal Person reference (except image override)
- ✅ Cross-domain entity linking established

---

## RECOMMENDATION FOR MULTI-SURFACE ALIGNMENT

### 1. Document the Pattern
Create a public "Entity Reference Guide" that external sites can follow:
- Template JSON-LD for external sites
- List of allowed vs forbidden properties
- Canonical @id (locked, never changes)

### 2. Monitor External References
- Check for property overrides
- Verify @id consistency
- Ensure minimal reference pattern

### 3. Validate Cross-Domain Alignment
- Use Google's Knowledge Graph API (if available)
- Monitor entity resolution in Search Console
- Track entity prominence signals

---

## VERDICT

**Flood Barrier Pros Implementation:** ✅ **EXCELLENT** (with one fix needed)

**Multi-Surface Alignment Status:** ✅ **STRONG FOUNDATION**

**Entity Authority Impact:** **HIGH** - Cross-domain references significantly reinforce canonical Person entity authority.

**Action Item:** Remove `image` override to achieve perfect alignment.
