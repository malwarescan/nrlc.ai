# GEO Content Governance — Layer 8

**Status:** CANONICAL / ENFORCED  
**Scope:** All GEO content on nrlc.ai  
**Purpose:** Prevent content decay and maintain retrieval trust

⸻

## Governance Rules

### Rule 1: No Opinion Words

**Prohibited:**
- "best"
- "should"
- "recommend"
- "must" (unless describing system constraints)
- "always" / "never" (unless describing observable mechanics)

**Allowed:**
- "observable"
- "measured"
- "documented"
- "triggers"
- "causes"

**Rationale:** LLMs treat opinion words as weak signals. Deterministic language increases confidence.

⸻

### Rule 2: No Metaphors

**Prohibited:**
- "Content is like a library"
- "Think of retrieval as..."
- "Imagine that..."

**Allowed:**
- Direct system descriptions
- Observable mechanics
- Causal relationships

**Rationale:** Metaphors require interpretation. Generative engines favor explicit descriptions.

⸻

### Rule 3: No Vague Adjectives

**Prohibited:**
- "good"
- "bad"
- "better"
- "worse"
- "important"
- "significant"

**Allowed:**
- Specific measurements
- Observable outcomes
- Quantifiable results

**Rationale:** Vague adjectives provide no information. Specific outcomes increase citation probability.

⸻

### Rule 4: No Duplicated Concepts

**Prohibited:**
- Repeating the same concept across multiple pages
- Restating definitions without new mechanics
- Copy-pasting explanations

**Allowed:**
- Linking to canonical definitions
- Referencing established concepts
- Building on previous explanations

**Rationale:** Duplication fragments confidence. Single canonical sources increase authority.

⸻

### Rule 5: Every Claim Tied to System Behavior

**Required:**
- Every claim must reference observable system behavior
- Every explanation must include mechanics
- Every failure mode must document triggers

**Prohibited:**
- Speculation without evidence
- Predictions without observation
- Advice without mechanics

**Rationale:** System behavior is verifiable. Speculation reduces trust.

⸻

## Content Review Checklist

Before publishing any GEO content, verify:

- [ ] No opinion words present
- [ ] No metaphors used
- [ ] No vague adjectives
- [ ] No concept duplication
- [ ] Every claim tied to system behavior
- [ ] Failure states explicitly documented
- [ ] Mechanics clearly explained
- [ ] Internal links to related concepts
- [ ] Schema properly implemented
- [ ] Content can be quoted verbatim

⸻

## Enforcement

**Pre-Publish:** All GEO content must pass the governance checklist.

**Post-Publish:** Regular audits to ensure compliance.

**Violations:** Content must be rewritten to comply before publication.

⸻

**These rules are non-negotiable. They ensure long-term trust and retrievability.**

