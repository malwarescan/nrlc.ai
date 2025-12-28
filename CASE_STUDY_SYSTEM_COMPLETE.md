# NRLC AI Case Study System - Final Form

## Overview

This is not content. This is AI retrieval infrastructure.

The complete system includes:
1. **Full JSON-LD Master Template** - Canonical schema shape
2. **Prompt-Cluster → Landing-Page Routing Logic** - AI intent routes to proof
3. **Internal Authoring UI Enforcement Spec** - Schema compiler with guardrails
4. **Live AI Answer Crawler + Verification Loop** - Truth loop that closes the system

---

## 1. Full JSON-LD Master Template (Canonical)

**File:** `lib/case_study_schema.php`

This is the only allowed Case Study schema shape. It incorporates Organization, Expertise, Prompt Clusters, Outcomes, and Trust in one graph.

### Structure:
- **Organization Schema** - Neural Command entity with expertise declarations
- **DefinedTermSet** - AI Prompt Clusters taxonomy
- **CaseStudy Schema** - Main entity with hasPart structure (Situation, AI Failure, Technical Diagnosis, Intervention, Outcome)
- **WebPage Schema** - Page-level metadata
- **BreadcrumbList Schema** - Navigation structure

### Usage:
```php
require_once __DIR__ . '/../../lib/case_study_schema.php';

$schemaData = [
  'slug' => 'b2b-saas',
  'title' => 'B2B SaaS AI SEO Case Study',
  'description' => 'How a SaaS company increased AI citations by 340%...',
  'prompt_cluster' => 'invisible-brand',
  'situation' => '...',
  'ai_failure' => '...',
  'technical_diagnosis' => '...',
  'intervention' => '...',
  'outcome' => '...',
  'citation_result' => '...'
];

$schemaGraph = generate_case_study_master_schema($schemaData);
$GLOBALS['__jsonld'] = $schemaGraph;
```

---

## 2. Prompt-Cluster → Landing-Page Router

**Files:**
- `pages/ai/brand-not-showing-chatgpt.php`
- `pages/ai/competitors-recommended-instead.php`
- `pages/ai/compliance-trust-answers.php`
- `pages/ai/local-business-not-recommended.php`

**Router:** `bootstrap/router.php` (routes `/ai/{slug}/` to `pages/ai/{slug}.php`)

### Routing Logic:

| Prompt Cluster | Landing Page |
|----------------|--------------|
| Invisible Brand | `/ai/brand-not-showing-chatgpt/` |
| Competitor Hallucination | `/ai/competitors-recommended-instead/` |
| Trust Comparison | `/ai/compliance-trust-answers/` |
| Local Failure | `/ai/local-business-not-recommended/` |

### Each Landing Page:
- References 1–2 case studies (filtered by prompt cluster)
- Embeds the same prompt cluster DefinedTerm
- Answers the exact prompt humans ask AI
- Links to relevant case studies
- Includes structured data linking to case studies

**Rule:** No landing page without a case study. No case study without a landing page.

---

## 3. Internal Authoring UI (Enforcement-First)

**File:** `lib/case_study_validator.php`

This is not a CMS. This is a schema compiler with guardrails.

### Required Fields (cannot submit without):
- **Prompt cluster** (dropdown, locked to DefinedTermSet)
- **Situation** (min 150 chars)
- **AI failure description** (min 150 chars)
- **Technical diagnosis** (must reference data/entity)
- **Intervention** (must be concrete)
- **AI outcome** (must describe answer behavior)

### Hard Bans (regex enforced):
- "cutting-edge"
- "leveraged"
- "optimized content"
- "boosted visibility"
- "industry-leading"
- "game-changing"
- "revolutionary"
- "next-level"
- "synergy"
- "paradigm shift"

### Validation Rules:
- Technical diagnosis must reference: entity, data, schema, structured, markup, JSON-LD, retrieval, citation
- Intervention must include concrete actions: implemented, added, created, updated, deployed, configured, mapped
- Outcome must describe answer behavior: answer, response, citation, mention, include, recommend, return

### Usage:
```php
require_once __DIR__ . '/../../lib/case_study_validator.php';

$caseData = [
  'prompt_cluster' => 'invisible-brand',
  'situation' => '...',
  'ai_failure' => '...',
  'technical_diagnosis' => '...',
  'intervention' => '...',
  'outcome' => '...'
];

$error = validate_case_study($caseData);
if ($error) {
  // Cannot publish - show errors
  echo $error;
} else {
  // Valid - proceed with JSON-LD generation
}
```

---

## 4. Live AI Answer Crawler (Truth Loop)

**File:** `scripts/ai_answer_crawler.php`

This closes the system.

### What It Does:

For each case study:
- Store canonical test prompts (generated from prompt cluster metadata)
- Query:
  - ChatGPT (via OpenAI API)
  - Claude (via Anthropic API)
  - Google AI Overviews (via SERP API)
- Record:
  - Brand mention (yes/no)
  - Position
  - Citation presence
  - Hallucinated competitors

### Output (stored per case study):

```json
{
  "slug": "b2b-saas",
  "timestamp": "2025-01-15 10:30:00",
  "prompts": [
    {
      "prompt": "Best software for SaaS",
      "chatgpt": {
        "text": "...",
        "mentions_brand": true,
        "position": 1,
        "citation": true,
        "notes": "Correct brand attribution"
      },
      "claude": { ... },
      "google_ai_overviews": { ... }
    }
  ]
}
```

### Why This Matters:
- Case studies stay true over time
- You detect AI regression
- Proof never goes stale
- Sales claims remain defensible

This turns marketing claims into monitored system states.

### Usage:
```bash
php scripts/ai_answer_crawler.php
```

Results are saved to `data/ai_verification/{slug}_{date}.json` and `data/ai_verification/aggregate_{date}.json`.

---

## Case Study Data Registry

**File:** `lib/case_study_registry.php`

Maps case study slugs to their prompt clusters and detailed content. This is the source of truth for case study data.

### Current Case Studies:
- `b2b-saas` - Invisible Brand cluster
- `ecommerce` - Competitor Hallucination cluster
- `healthcare` - Trust Comparison cluster
- `fintech` - Trust Comparison cluster
- `education` - Invisible Brand cluster
- `real-estate` - Local Failure cluster

### Usage:
```php
require_once __DIR__ . '/../../lib/case_study_registry.php';

$caseData = get_case_study_data('b2b-saas');
// Returns full case study data array

$allCases = get_case_study_registry();
// Returns all case studies indexed by slug
```

---

## Integration Points

### Case Study Template
**File:** `pages/case-studies/case-study.php`

- Loads case study data from registry
- Uses master schema template for JSON-LD
- Displays structured content sections (Situation, AI Failure, Technical Diagnosis, Intervention, Outcome)
- Falls back to deterministic content for non-registry case studies

### Router
**File:** `bootstrap/router.php`

- Routes `/case-studies/{slug}/` to case study template
- Routes `/ai/{slug}/` to prompt-cluster landing pages
- Generates semantic metadata for case studies

---

## Next Steps (Optional)

1. **Auto-generate case studies from crawler deltas** - When AI regression is detected, automatically flag case studies for update
2. **Expose "Verified by AI" badge** - Feed live checks into a badge system showing current verification status
3. **Build client dashboard** - Show AI answer coverage, citation rates, and verification status per case study

---

## System Architecture

```
┌─────────────────────────────────────┐
│   Case Study Data Registry          │
│   (lib/case_study_registry.php)     │
└──────────────┬──────────────────────┘
               │
               ├───► Case Study Template
               │     (pages/case-studies/case-study.php)
               │     └───► Master Schema Generator
               │           (lib/case_study_schema.php)
               │
               ├───► Prompt-Cluster Landing Pages
               │     (pages/ai/*.php)
               │     └───► References case studies
               │
               └───► AI Answer Crawler
                     (scripts/ai_answer_crawler.php)
                     └───► Verifies claims remain true
```

---

## This is AI Reputation Infrastructure

This system is no longer "case studies." It is AI reputation infrastructure that:
- Structures proof in machine-readable format
- Routes AI intent to authoritative answers
- Enforces quality through validation
- Monitors truth through verification loops

Marketing never touches raw HTML. Everything is validated, structured, and verified.

