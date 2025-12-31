# Content Chunking vs Prechunking

## Critical Distinction

**Content Chunking** and **Prechunking** are related but distinct concepts. They must NOT be conflated.

## Content Chunking

**Purpose:** UX, readability, scannability  
**When:** Applied during or after writing  
**Focus:** Presentation and comprehension  
**Governs:** How content is structured for human readers

### Key Characteristics:
- Short, scannable paragraphs (40-80 words)
- Clear hierarchical headers (H1 → H2 → H3)
- Visual separation (lists, white space)
- Logical narrative flow allowed
- One idea per section

### Validator:
```bash
php scripts/validate_content_chunking.php
```

### Directive:
`SUDO_META_DIRECTIVE_CONTENT_CHUNKING.md`

---

## Prechunking

**Purpose:** AI retrieval, citation, LLM isolation  
**When:** Structured before writing  
**Focus:** Extraction and retrieval mechanics  
**Governs:** How content is extracted by machines

### Key Characteristics:
- Atomic, self-contained chunks
- Query-shaped headers (resemble search queries)
- No narrative glue or transitions
- Citation-ready (quotable verbatim)
- Independent retrieval (no context needed)

### Validator:
```bash
php scripts/validate_prechunking.php
```

### Directive:
`SUDO_META_DIRECTIVE_PRECHUNKING.md`

---

## Comparison Table

| Aspect | Content Chunking | Prechunking |
|--------|------------------|-------------|
| **Purpose** | UX, readability | Retrieval, citation |
| **When Applied** | During/after writing | Before writing |
| **Paragraph Length** | 40-80 words | 40-120 words (150 max) |
| **Headers** | Descriptive, hierarchical | Query-shaped, question-like |
| **Narrative Flow** | Allowed | Prohibited |
| **Context Dependencies** | Acceptable | Forbidden |
| **Focus** | Human scanning | Machine extraction |
| **Validator** | `validate_content_chunking.php` | `validate_prechunking.php` |

---

## NRLC Workflow

1. **First:** Chunk for humans (Content Chunking)
   - Structure for readability
   - Clear sections
   - Scannable format

2. **Then (if needed):** Prechunk for machines (Prechunking)
   - Optimize for retrieval
   - Ensure citation eligibility
   - Enable independent extraction

---

## Terminology Rules

**DO:**
- Use "content chunking" when referring to UX/readability
- Use "prechunking" when referring to retrieval/citation
- Maintain strict terminological precision

**DON'T:**
- Use "chunking" when you mean "prechunking"
- Mix retrieval doctrine into UX guides
- Collapse or blur these concepts

---

## When to Use Which

### Use Content Chunking For:
- All blog posts
- All guides
- All documentation
- Any content meant for human readers

### Use Prechunking For:
- Content that needs AI citation
- Content targeting AI Overviews
- Content requiring LLM retrieval
- High-priority SEO pages

### Use Both For:
- High-value content that needs both human readability AND AI retrieval
- Apply chunking first, then prechunking

---

## Enforcement

Both directives are **CANONICAL** and **ENFORCED**.

- Content Chunking: Required for all content
- Prechunking: Required for AI-optimized content

Terminological misuse is not allowed.

