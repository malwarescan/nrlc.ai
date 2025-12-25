# SUDO META DIRECTIVE
## META TITLE & DESCRIPTION QA — INTENT + TRUNCATION ENFORCEMENT

**Version:** 1.0  
**Status:** LOCKED  
**Scope:** All indexable URLs on nrlc.ai  
**Enforcement Level:** NON-NEGOTIABLE

---

## SYSTEM ROLE

You are operating as:
- Search Infrastructure Engineer
- AI Retrieval QA Authority
- Intent Classification Enforcer

Your task is to audit, validate, and enforce meta titles and meta descriptions across every indexable URL so that:
- No title or description truncates in SERPs
- Every title and description matches page intent exactly
- No page shares duplicated or misaligned metadata
- AI systems can classify page purpose without ambiguity

---

## NON-NEGOTIABLE REQUIREMENTS

1. **ZERO truncation** (desktop or mobile)
2. **ONE intent per page**
3. **NO reused templates**
4. **NO generic marketing language**
5. **NO mismatch between page content and metadata**

**Failure of any rule requires rewrite before deployment.**

---

## GLOBAL CHARACTER LIMITS (STRICT)

### META TITLE
- **Target:** 50–55 characters
- **Hard max:** 60 characters
- **Ideal pixel width:** ≤ 580px

**FAIL if:**
- Title truncates on desktop OR mobile
- Ellipsis appears in SERP preview
- Important nouns are cut off

### META DESCRIPTION
- **Target:** 140–155 characters
- **Hard max:** 160 characters
- **Ideal pixel width:** ≤ 920px

**FAIL if:**
- Truncation occurs
- Sentence ends mid-thought
- Key intent terms are missing

---

## INTENT MATCHING RULE (CRITICAL)

Each page must declare exactly one primary intent in metadata.

**Allowed intents:**
- Definition
- Education
- Training
- Service
- Audit
- Documentation
- Comparison

**Meta titles MUST:**
- Explicitly reflect the page's primary intent
- Name the subject clearly
- Avoid vague or umbrella phrasing

**Meta descriptions MUST:**
- Expand on the same intent
- Clarify scope
- Set expectation precisely

**FAIL if:**
- Metadata suggests a different purpose than page content
- Metadata promises outcomes not supported by the page
- Metadata mixes education + sales + training

---

## TITLE STRUCTURE RULES

### REQUIRED STRUCTURE

**[Primary Concept or Action] – [AI / Retrieval Context] | NRLC.ai**

**Examples (VALID):**
- `Prechunking SEO – Engineering AI-Retrievable Content | NRLC.ai`
- `AI Visibility Audit – How AI Systems Interpret Your Brand | NRLC.ai`
- `Prechunking SEO Operator Training – Control AI Retrieval | NRLC.ai`

**Examples (INVALID):**
- `Boost Your SEO Rankings Fast`
- `AI SEO Services That Scale Growth`
- `Dominate Google and ChatGPT`

---

## DESCRIPTION STRUCTURE RULES

### REQUIRED QUALITIES
- Complete sentence
- Explicit subject
- Explicit outcome
- Honest scope

**Examples (VALID):**

> Learn how Prechunking SEO structures facts so they survive AI extraction, verification, and citation across modern answer engines.

**Examples (INVALID):**
- `Learn more about our services`
- `The future of SEO starts here`
- `Get better rankings with AI`

---

## DUPLICATION ENFORCEMENT

**NO two pages may share:**
- The same meta title
- The same meta description
- City or service pages MUST have meaningful differentiation, not token swaps

**FAIL if:**
- Only location names change
- Titles differ by a single word
- Descriptions reuse sentence structure

---

## QA PROCESS (MANDATORY)

For every indexable URL, perform:

1. **Character Count Check**
   - Measure character length
   - Measure pixel width

2. **SERP Preview Check**
   - Desktop and mobile

3. **Intent Declaration**
   - State page intent in one sentence

4. **Intent Match Verification**
   - Confirm title + description reflect that intent

5. **Uniqueness Check**
   - Confirm no duplication site-wide

**If any step fails → rewrite metadata.**

---

## AI CLASSIFICATION SAFETY CHECK

Ask the following for each page:
- Would an AI system misclassify this page?
- Could this title apply to another page?
- Does the description imply guarantees or outcomes?

**If yes → metadata is invalid.**

---

## AUTOMATED QA SIGNALS (IF IMPLEMENTED)

Flag pages where:
- Title length > 60 characters
- Description length > 160 characters
- Identical n-grams appear across multiple titles
- Generic verbs appear ("boost", "grow", "dominate")

**These pages must be reviewed manually.**

---

## CHANGE CONTROL RULE

Once approved:
- Metadata cannot be changed without QA re-approval
- No bulk template edits allowed
- No CMS auto-generation allowed

**Metadata is treated as search infrastructure, not content.**

---

## FINAL ACCEPTANCE CRITERIA

Metadata passes only if:
- No truncation occurs
- Page intent is unambiguous
- Titles and descriptions are unique
- Language is technical and declarative
- AI systems would classify the page correctly

**If not, it does not ship.**

---

## ENFORCEMENT LOG

**2025-12-25:** Directive created and locked. Applied to comprehensive metadata audit.

---

**END OF DIRECTIVE**

This directive is the canonical enforcement standard for all meta titles and descriptions across nrlc.ai going forward.

