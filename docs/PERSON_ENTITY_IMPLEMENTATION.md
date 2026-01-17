# Person Entity Implementation — Developer Guidelines

**Last Updated:** 2025-01-17  
**Status:** ✅ Production  
**Canonical Person ID:** `https://nrlc.ai/en-us/about/joel-maldonado/#person`

---

## CRITICAL RULE: Never Mint New Person Entities

**All author references across the NRLC ecosystem MUST use the canonical Person @id.**

### The Rule

1. **Entity Home Page Only:** The full Person JSON-LD payload exists ONLY on:
   - `https://nrlc.ai/en-us/about/joel-maldonado/`

2. **All Other Pages:** Reference the canonical Person @id only:
   ```php
   'author' => [
     '@id' => JOEL_PERSON_ID,
     '@type' => 'Person',
     'name' => 'Joel David Maldonado',
     'url' => JOEL_ENTITY_HOME_URL
   ]
   ```

3. **Never Do This:**
   ```php
   // ❌ WRONG - Don't mint a new Person entity
   'author' => [
     '@type' => 'Person',
     '@id' => 'https://nrlc.ai/#joel',  // Different @id = entity split
     'name' => 'Joel Maldonado',
     'jobTitle' => '...',  // Full object on article page
     'sameAs' => [...]
   ]
   ```

---

## Implementation Details

### Canonical Constants

Use the constants defined in `lib/person_entity.php`:

```php
require_once __DIR__ . '/../../lib/person_entity.php';

// Canonical Person @id (locked, never changes)
JOEL_PERSON_ID
// => 'https://nrlc.ai/en-us/about/joel-maldonado/#person'

// Entity home URL
JOEL_ENTITY_HOME_URL
// => 'https://nrlc.ai/en-us/about/joel-maldonado/'

// Helper function for author references
joel_person_author()
// Returns minimal Person object with @id reference
```

### Entity Home Page

**File:** `pages/about/joel-maldonado.php`

**Requirements:**
- Contains the ONLY full Person JSON-LD payload
- Person @id: `https://nrlc.ai/en-us/about/joel-maldonado/#person`
- ProfilePage.mainEntity points to Person @id
- sameAs links must be visible in HTML (not just schema)
- Image URL: `https://nrlc.ai/assets/images/joel-maldonado.png`

### Article Pages (Blog Posts, Case Studies, Insights)

**Pattern:**
```php
'author' => [
  '@id' => JOEL_PERSON_ID,
  '@type' => 'Person',
  'name' => 'Joel David Maldonado',
  'url' => JOEL_ENTITY_HOME_URL
]
```

**Do NOT include:**
- `jobTitle`
- `sameAs`
- `knowsAbout`
- `worksFor`
- `image`

These properties exist only on the entity home page.

---

## URL Structure

### Canonical Entity Home
- **URL:** `https://nrlc.ai/en-us/about/joel-maldonado/`
- **Redirect:** `/about/joel-maldonado/` → 301 → `/en-us/about/joel-maldonado/`

**Why:** Prevents entity split. Only one canonical URL serves the entity home.

---

## Validation & Guardrails

### Pre-Deploy Validation

Run before every deployment:

```bash
php scripts/validate_person_entity.php
```

**Exit code 0 = pass, 1 = fail (blocks deploy)**

This script checks:
- All Person @id references use canonical ID
- No full Person objects outside entity-home page
- No duplicate Person entities

### Post-Deploy Verification

After deployment, run:

```bash
php scripts/post_deploy_verify_person_entity.php --live
```

This verifies:
- URL redirects work correctly
- JSON-LD structure is correct
- Random articles reference canonical @id only
- Guardrail script passes

---

## Google Search Console

### URL Inspection

After deployment, inspect in GSC:
1. `https://nrlc.ai/en-us/about/joel-maldonado/`
2. 1-2 updated blog posts

**Note:** Person/ProfilePage won't show in Enhancements reports. Use URL Inspection to verify schema.

### Request Indexing

If pages aren't indexed, request indexing to force Google to reprocess the entity structure.

---

## Common Mistakes to Avoid

### ❌ Mistake 1: Creating Person on Article Pages
```php
// WRONG
'author' => [
  '@type' => 'Person',
  '@id' => 'https://nrlc.ai/blog/post-1/#author',  // New @id = entity split
  'name' => 'Joel Maldonado'
]
```

### ❌ Mistake 2: Full Person Object on Articles
```php
// WRONG
'author' => [
  '@id' => JOEL_PERSON_ID,
  '@type' => 'Person',
  'name' => 'Joel David Maldonado',
  'jobTitle' => 'AI Search Optimization Researcher',  // Only on entity home
  'sameAs' => [...]  // Only on entity home
]
```

### ❌ Mistake 3: Different @id on Different Pages
```php
// WRONG - Different @id = entity split
'@id' => 'https://nrlc.ai/#joel-maldonado'  // Wrong
'@id' => 'https://nrlc.ai/team/joel'  // Wrong
```

### ✅ Correct Pattern
```php
// CORRECT - Always use canonical @id
'author' => [
  '@id' => JOEL_PERSON_ID,  // Always the same
  '@type' => 'Person',
  'name' => 'Joel David Maldonado',
  'url' => JOEL_ENTITY_HOME_URL
]
```

---

## Files Modified

- `lib/person_entity.php` - Constants and helper function
- `pages/about/joel-maldonado.php` - Entity home page
- `bootstrap/router.php` - Route and redirect logic
- `lib/insights_schema_kernel.php` - Insights author reference
- `pages/blog/blog-post.php` - Blog template author reference
- `pages/blog/index.php` - Blog index author reference
- `pages/case-studies/*.php` - Case study author references
- `scripts/validate_person_entity.php` - Pre-deploy guardrail
- `scripts/post_deploy_verify_person_entity.php` - Post-deploy verification

---

## Questions?

If you need to add author information to a new page:

1. **Check:** Does this page need author attribution?
2. **Use:** `joel_person_author()` helper function
3. **Verify:** Run guardrail script before committing
4. **Never:** Create a new Person @id or full Person object

---

**Remember:** One Person entity, one @id, locked forever. All pages reference it.
