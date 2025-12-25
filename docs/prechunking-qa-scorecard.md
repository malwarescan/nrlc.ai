# Prechunking SEO QA Scorecard
## Academic AI-Search Insights Integration

**Purpose:** Per-page, per-system, per-release quality assurance checklist  
**Status:** Active enforcement standard  
**Version:** 1.0

---

## SCORING SYSTEM

**Pass/Fail Criteria:** Each item must pass for page to be approved.  
**Violations:** Treat as retrieval regressions, not content issues.

---

## CHECKLIST ITEMS

### 1. Query–Chunk Semantic Alignment

**Goal:** Ensure AI systems see your chunks as the most semantically aligned candidate for likely questions.

**Checklist:**
- [ ] Primary query phrasing appears verbatim in at least one crouton
- [ ] Secondary query variants are covered in separate croutons (not merged)
- [ ] No crouton relies on synonyms alone when literal phrasing is common
- [ ] Headers mirror how users actually ask questions, not marketing language

**Why:** LLMs overweight semantic overlap between query and source text when selecting citations.

**Fail Condition:** If primary query phrasing is absent or only present via synonyms → REWRITE.

---

### 2. Atomic Extractability Enforcement (Crouton Hardening)

**Goal:** Ensure every fact can survive isolation without mutation.

**Checklist:**
- [ ] One fact per sentence
- [ ] No conjunctions ("and", "but", "also") inside factual claims
- [ ] Explicit subject and predicate
- [ ] No pronouns ("this", "it", "they")
- [ ] No implied context

**Isolation Test:**
1. Copy the sentence alone
2. If meaning degrades → FAIL

**Why:** Research shows LLM failures emerge when facts require surrounding context. Those facts are skipped or altered.

**Fail Condition:** Any sentence that fails isolation test → REWRITE.

---

### 3. Redundant Truth Reinforcement (Ethical Signal Amplification)

**Goal:** Increase AI confidence without manipulation.

**Checklist:**
- [ ] Key facts appear in more than one location on the domain
- [ ] Wording is consistent across appearances
- [ ] No contradictions across pages
- [ ] Reinforcement is factual, not persuasive

**Important Constraint:** This is reinforcement of truth, not preference manipulation.

**Why:** Academic work shows repeated, consistent signals increase confidence and retrieval likelihood.

**Fail Condition:** Contradictory facts or inconsistent wording across domain → FIX.

---

### 4. Entity and Relationship Explicitness

**Goal:** Make entities unambiguous for extraction and graph building.

**Checklist:**
- [ ] Every brand, system, or concept is explicitly named
- [ ] Relationships are stated directly ("X does Y for Z")
- [ ] No metaphors or figurative language
- [ ] Schema aligns exactly with on-page text

**Why:** LLMs extract entities and relationships, not prose meaning.

**Fail Condition:** Implied relationships or ambiguous entity naming → REWRITE.

---

### 5. Context Noise Reduction

**Goal:** Reduce ambiguity that causes AI to discard or misclassify content.

**Checklist:**
- [ ] No narrative transitions
- [ ] No rhetorical questions inside factual sections
- [ ] No mixed intents in a single section
- [ ] No opinion blended into factual statements

**Why:** Research shows ambiguous or overloaded text degrades model confidence and retrieval reliability.

**Fail Condition:** Mixed signals or ambiguous phrasing in factual sections → REWRITE.

---

### 6. Citation-Ready Assertion Design

**Goal:** Make statements safe to cite verbatim.

**Checklist:**
- [ ] Assertions are factual, not promotional
- [ ] No guarantees or exaggerated claims
- [ ] Clear scope (who, what, where)
- [ ] Safe for summarization without caveats

**Why:** LLMs avoid citing text that appears risky or promotional.

**Fail Condition:** Promotional language or unsupported claims in citation-eligible text → REWRITE.

---

### 7. Intent Forecast Coverage (Precogs Integration)

**Goal:** Cover follow-up questions before they are asked.

**Checklist:**
- [ ] Primary query defined
- [ ] Next 3–5 likely follow-up questions mapped
- [ ] Each follow-up has required croutons
- [ ] Trust questions explicitly answered

**Why:** Research shows overlap strength matters more than novelty. Being ready beats being clever.

**Fail Condition:** Missing croutons for likely follow-up questions → ADD.

---

### 8. AI Classification Safety Check

**Goal:** Ensure AI systems classify the page correctly.

**Checklist:**
- [ ] Page intent can be stated in one sentence
- [ ] Meta title and description reflect same intent
- [ ] No conflicting cues (service vs education vs training)
- [ ] Headers align with content purpose

**Fail Condition:** If the page could be misclassified → REWRITE.

---

## QA FLAGS (Automated Detection)

Flag pages where:
- Semantic mismatch between query and crouton
- Multi-fact sentences
- Inconsistent entity naming
- Promotional language in citation-eligible text
- Pronoun usage in factual claims
- Conjunctions in factual statements
- Mixed intents in single sections

**Action Required:** Treat violations as retrieval regressions, not content issues.

---

## PASS/FAIL CRITERIA

**Page passes only if:**
- All 8 checklist items pass
- No QA flags triggered
- Isolation tests pass for all factual sentences
- Intent classification is unambiguous

**If any item fails → page does not ship.**

---

## INTEGRATION WITH COURSE

This scorecard maps directly to course modules:

| Checklist Item | Course Module |
|----------------|---------------|
| Query–Chunk Semantic Alignment | Module 4 (Precogs) |
| Atomic Extractability | Module 2 (Croutons) |
| Redundant Truth Reinforcement | Module 5 (Prechunking in Practice) |
| Entity Explicitness | Module 3 (Data Shaping) |
| Context Noise Reduction | Module 1 (Chunk Extraction Reality) |
| Citation-Ready Assertion Design | Module 6 (Validation) |
| Intent Forecast Coverage | Module 4 (Precogs) |
| AI Classification Safety | Module 6 (Validation) |

---

**END OF SCORECARD**

