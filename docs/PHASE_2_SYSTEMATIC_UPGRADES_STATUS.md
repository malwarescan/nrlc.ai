# Phase 2: Systematic Page Upgrades - STATUS

## Execution Summary

Phase 2 systematic upgrades are in progress. Pages are being updated to the validated template standard.

---

## ✅ Completed Pages

### 1. performance-caching
**Status:** COMPLETE ✅
**URL:** `/en-us/insights/performance-caching/`

**Template Compliance:**
- ✅ H1: "Performance Caching for Semantic and AI-Driven Systems"
- ✅ Definition block (within first 120 words)
- ✅ Mechanism section
- ✅ Operational implications
- ✅ Checklist (ordered list - 7 steps)
- ✅ Failure modes
- ✅ Related links (4 internal)
- ✅ FAQ (4 questions)

**Schema:**
- ✅ Article schema
- ✅ FAQPage schema (3 questions)
- ✅ DefinedTerm schemas (3 terms)
- ✅ BreadcrumbList schema
- ✅ Organization schema

---

### 2. data-virtualization
**Status:** COMPLETE ✅
**URL:** `/en-us/insights/data-virtualization/`

**Template Compliance:**
- ✅ H1: "Data Virtualization for AI and Semantic Systems"
- ✅ Definition block (within first 120 words)
- ✅ Mechanism section
- ✅ When to use (operational implications variant)
- ✅ Decision table (real HTML `<table>`)
- ✅ Operational implications for AI systems
- ✅ Performance constraints and thresholds
- ✅ Checklist (ordered list - 8 steps)
- ✅ Failure modes
- ✅ Related links (4 internal)
- ✅ FAQ (4 questions)

**Schema:**
- ✅ Article schema
- ✅ FAQPage schema (4 questions)
- ✅ DefinedTerm schema (Data Virtualization)
- ✅ BreadcrumbList schema
- ✅ Organization schema

---

## 🔧 Automation & CI Infrastructure

### Batch Automation Script
**File:** `scripts/insights_lint_and_fix.js`
**Status:** CREATED ✅

**Features:**
- Removes inline styles from headings (safe auto-fix)
- Flags fake tables (div-based) for manual conversion
- Validates exactly one H1 per page
- Checks for required H2 sections
- CI-ready (non-zero exit code on violations)

**Usage:**
```bash
# Check mode (CI behavior)
node scripts/insights_lint_and_fix.js --root ./pages/insights --check

# Fix mode (safe auto-fix only)
node scripts/insights_lint_and_fix.js --root ./pages/insights --fix
```

**Enforced Rules:**
1. Exactly one H1 per page
2. No inline styles in h1–h6
3. No fake tables (div-based table structures)
4. Required H2 sections must exist:
   - Definition
   - Mechanism
   - Operational Implications
   - Checklist
   - Failure Modes
   - FAQ

---

### CI Lint Workflow
**File:** `.github/workflows/insights-lint.yml`
**Status:** CREATED ✅

**Triggers:**
- Pull requests
- Pushes to main/master branches

**Actions:**
- Runs Node.js 20
- Executes insights lint script in check mode
- Fails build if violations found

**Local Dev Command:**
```bash
node scripts/insights_lint_and_fix.js --root ./pages/insights --check
```

---

## 📋 Next Pages (In Order)

1. **semantic-queries** (already updated, may need refinement)
2. **enterprise-llm**
3. **knowledge-graph**
4. Remaining Insights pages (as per roadmap)

---

## 🎯 Template Standard (Enforced)

Every updated page must follow this structure:

**Required Blocks (in order):**
1. H1 – exact topic
2. Definition lock (2–4 sentences, plain language)
3. Mechanism – how it works
4. Operational implications – what changes in practice
5. Checklist / playbook – ordered list
6. Failure modes – why it breaks
7. Related links – minimum 3 internal
8. FAQ – minimum 4 questions

**Schema Requirements:**
- Article schema
- FAQPage schema (if FAQ exists)
- DefinedTerm schemas (for core terms)
- BreadcrumbList schema
- Organization schema

**Technical Requirements:**
- No inline styles in headings
- Real HTML tables (not div-based)
- Exactly one H1 per page
- Clean, machine-extractable structure

---

## ✅ QA Validation

All completed pages validated:
- ✅ No syntax errors
- ✅ Pages load correctly
- ✅ Schema outputs properly
- ✅ All required sections present
- ✅ Clean heading structure
- ✅ Real HTML tables where applicable

---

## Status Summary

**Phase 1:** COMPLETE (critical fixes)
**Phase 2:** IN PROGRESS (2/4+ core pages complete)
**Automation:** COMPLETE (script + CI workflow ready)
**Template:** VALIDATED (performance-caching, data-virtualization as reference)

**Next Step:** Continue with enterprise-llm, then knowledge-graph, then remaining pages.

