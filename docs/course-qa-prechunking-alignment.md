# Course QA: Prechunking Alignment Analysis

## Core Prechunking Concepts (from documentation)
1. **Data Shaping** - Structuring content so facts survive extraction
2. **Croutons** - Atomic, retrievable fact structures (unit of retrieval)
3. **Precogs** - Predicted information needs, intent forecasting
4. **Chunk Boundaries** - Where retrievable units begin/end
5. **Retrieval vs Ranking** - Prechunking operates at retrieval layer, not ranking

## Prechunking Workflow (from documentation)
1. **Intent Decomposition** - Break user needs into discrete questions
2. **Crouton Inventory** - Map intents to required atomic facts
3. **Data Shaping** - Transform narrative into declarative croutons
4. **Structured Publishing** - Organize croutons preserving chunk boundaries
5. **Retrieval Validation** - Test whether croutons are actually retrieved

---

## MODULE 1: Chunk Extraction Reality

### What It Teaches
- How AI extracts chunks
- Why pages are irrelevant to retrieval
- Chunk identification skills

### ✅ Strengths
- Foundational understanding of chunk extraction
- Validates isolation (no context dependencies)

### ❌ Gaps - Missing Prechunking Connections
1. **Missing:** Why we need to prechunk (chunks are extracted, so we must shape them BEFORE extraction)
2. **Missing:** Chunk boundaries concept (where chunks begin/end)
3. **Missing:** Retrieval vs ranking distinction (chunks are retrieved, pages are ranked)
4. **Missing:** Connection to prechunking workflow (this is the problem prechunking solves)

### 🔧 Required Fixes
- Add explanation: "Because AI extracts chunks, we must prechunk content at publishing time"
- Introduce chunk boundaries concept
- Explain retrieval layer vs ranking layer
- Connect to Module 2: "This is why we write croutons"

---

## MODULE 2: Crouton Writing

### What It Teaches
- Writing atomic facts
- Atomicity validation
- No pronouns, no conjunctions

### ✅ Strengths
- Core skill for prechunking
- Validation rules align with crouton spec

### ❌ Gaps - Missing Prechunking Connections
1. **Missing:** WHY croutons matter (they're the unit of retrieval, not pages)
2. **Missing:** Reference to crouton specification documentation
3. **Missing:** Examples from crouton spec (valid vs invalid patterns)
4. **Missing:** Connection to retrieval (AI cites croutons, not pages)
5. **Missing:** Versioning rules (mentioned in spec but not taught)

### 🔧 Required Fixes
- Add: "Croutons are the unit of retrieval. AI systems cite croutons, not pages."
- Link to crouton specification docs
- Include examples from spec (valid/invalid patterns)
- Explain retrieval context: "When AI extracts a crouton, it must remain accurate"

---

## MODULE 3: Data Shaping

### What It Teaches
- Transforming narrative to declarative
- Removing narrative connectors
- Creating crouton inventory

### ✅ Strengths
- Core prechunking skill
- Validates declarative structure

### ❌ Gaps - Missing Prechunking Connections
1. **Missing:** Connection to prechunking workflow (this is workflow step 3)
2. **Missing:** How data shaping relates to chunk boundaries
3. **Missing:** Structured publishing aspect (workflow step 4)
4. **Missing:** Why narrative fails (context is lost during extraction)
5. **Missing:** Connection to Module 1 (chunks are extracted, so we shape them)

### 🔧 Required Fixes
- Add workflow context: "This is step 3 of the prechunking workflow"
- Explain chunk boundary planning during shaping
- Introduce structured publishing concept
- Connect to Module 1: "Because chunks are extracted, we shape content before publishing"

---

## MODULE 4: Precog Modeling

### What It Teaches
- Predicting follow-up questions
- Mapping required croutons
- Intent forecasting

### ✅ Strengths
- Core prechunking skill
- Teaches intent forecasting

### ❌ Gaps - Missing Prechunking Connections
1. **Missing:** Connection to intent decomposition (workflow step 1)
2. **Missing:** How precogs map to crouton inventory (workflow step 2)
3. **Missing:** Trust gap identification (mentioned in docs but not taught)
4. **Missing:** Why precogs matter (missing croutons cause AI to cite competitors)
5. **Missing:** Connection to retrieval validation (Module 6)

### 🔧 Required Fixes
- Add: "Precog modeling is part of intent decomposition (workflow step 1)"
- Explain: "Each precog maps to required croutons (workflow step 2)"
- Teach trust gap identification
- Connect to Module 6: "Missing precogs cause retrieval failures"

---

## MODULE 5: Prechunking Application

### What It Teaches
- Auditing real pages
- Refactoring content
- Before/after comparison

### ✅ Strengths
- Practical application
- Full workflow practice

### ❌ Gaps - Missing Prechunking Connections
1. **Missing:** Intent decomposition step (workflow step 1)
2. **Missing:** Structured publishing (workflow step 4) - chunk boundary planning
3. **Missing:** Chunk boundary planning (how to group related croutons)
4. **Missing:** Connection to all previous modules (this should synthesize everything)
5. **Missing:** Why this is "prechunking" (shaping before extraction, not after)

### 🔧 Required Fixes
- Add intent decomposition to exercise
- Add chunk boundary planning to artifacts
- Add structured publishing step
- Connect all modules: "This synthesizes Modules 1-4"
- Emphasize: "Prechunking happens at publishing time, before AI extraction"

---

## MODULE 6: Validation and Iteration

### What It Teaches
- Verifying retrieval success
- Identifying which croutons appeared
- Failure analysis

### ✅ Strengths
- Core validation skill
- Teaches retrieval inspection

### ❌ Gaps - Missing Prechunking Connections
1. **Missing:** Connection to retrieval vs ranking (this validates retrieval, not ranking)
2. **Missing:** Chunk boundary validation (are related facts retrieved together?)
3. **Missing:** Citation tracking (are croutons attributed correctly?)
4. **Missing:** Competitive comparison (why did competitors get cited instead?)
5. **Missing:** Iteration loop back to earlier modules (failed validation → return to shaping)

### 🔧 Required Fixes
- Add: "This validates retrieval layer, not ranking layer"
- Add chunk boundary validation
- Add citation tracking
- Add competitive analysis
- Add iteration loop: "Failed validation requires returning to data shaping (Module 3)"

---

## OVERALL COURSE GAPS

### Missing Core Concepts
1. **Retrieval vs Ranking** - Only mentioned in Module 1, not reinforced throughout
2. **Chunk Boundaries** - Not taught as a concept, only implied
3. **Structured Publishing** - Workflow step 4 is missing entirely
4. **Intent Decomposition** - Workflow step 1 is not explicitly taught
5. **Workflow Integration** - Modules don't connect to the 5-step workflow

### Missing Prechunking Context
- Why "prechunking" (shaping BEFORE extraction, not after)
- How modules connect to the full workflow
- How retrieval differs from ranking
- Why competitors get cited (missing croutons)
- How chunk boundaries affect retrieval

### Required Course-Wide Fixes
1. Add workflow diagram/explanation to overview
2. Connect each module to workflow steps
3. Reinforce retrieval vs ranking throughout
4. Add chunk boundary concept to Module 1 and Module 3
5. Add structured publishing to Module 5
6. Add iteration loops to Module 6

---

## PRIORITY FIXES

### P0 (Critical - Course doesn't teach prechunking without these)
1. Module 1: Add "why prechunking" and retrieval vs ranking
2. Module 2: Add "croutons are unit of retrieval" and link to spec
3. Module 5: Add intent decomposition and structured publishing
4. Module 6: Add retrieval vs ranking context and iteration loops

### P1 (Important - Course is incomplete without these)
1. Module 3: Add chunk boundary planning
2. Module 4: Add intent decomposition connection
3. Overview: Add workflow diagram
4. All modules: Connect to workflow steps

### P2 (Nice to have - Course works but could be better)
1. Add more examples from documentation
2. Add cross-module references
3. Add competitive analysis examples

