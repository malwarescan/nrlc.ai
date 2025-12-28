# NRLC AI Case Study System - PHP-Native Implementation

## Overview

This is the complete PHP-native implementation. No framework assumptions. Plain PHP, cron, and CLI scripts.

**What changed:**
- Implementation language → PHP
- Runtime → cron + CLI
- UI → server-rendered admin + dashboards

**What did NOT change:**
- Architecture
- Schema
- Prompt taxonomy
- Enforcement
- Verification loop
- Philosophy

---

## System Components

### 1. Internal Authoring UI

**File:** `admin/case-study-editor.php`

- Server-side validation (PHP)
- Required fields enforced
- Banned phrases blocked
- JSON-LD auto-generated
- Markdown + JSON files written

**Usage:**
```
https://nrlc.ai/admin/case-study-editor.php?slug=b2b-saas
```

**Validation Rules:**
- Situation: min 150 chars
- AI Failure: min 150 chars
- Technical Diagnosis: must reference entity/data/schema
- Intervention: must describe concrete actions
- Outcome: must describe AI behavior changes

**Output:**
- `data/case-studies/{slug}.json` - Case study data
- `data/case-studies/{slug}.jsonld` - JSON-LD schema
- `data/case-studies/{slug}.md` - Human-readable markdown

---

### 2. Build-Time Validators

**File:** `bin/validate-case-study.php`

Validates JSON-LD files before deployment. Fail = no deploy.

**Usage:**
```bash
php bin/validate-case-study.php data/case-studies/b2b-saas.jsonld
```

**Validates:**
- CaseStudy entity structure
- Required fields (name, headline, description, url, problem, hasPart, result)
- hasPart sections (Situation, AI Retrieval Failure, Technical Diagnosis, Intervention, Outcome)
- Problem references DefinedTerm
- Result structure

**Exit Codes:**
- `0` = Valid
- `1` = Invalid (with error messages)

**CI/CD Integration:**
```bash
# In your deployment script
php bin/validate-case-study.php data/case-studies/*.jsonld || exit 1
```

---

### 3. AI Answer Crawler (Cron-Ready)

**File:** `scripts/ai_answer_crawler.php`

PHP-native implementation with real API calls.

**API Integration:**
- ChatGPT: OpenAI API (requires `OPENAI_API_KEY`)
- Claude: Anthropic API (requires `ANTHROPIC_API_KEY`)
- Google AI Overviews: SerpAPI (requires `SERP_API_KEY`)

**Storage:**
- Individual checks: `data/ai_verification/{slug}_{model}_{date}.json`
- Aggregate results: `data/ai_verification/aggregate_{date}.json`

**Usage:**
```bash
# Run manually
php scripts/ai_answer_crawler.php

# Or via cron (daily)
0 2 * * * cd /path/to/nrlc.ai && php scripts/ai_answer_crawler.php
```

**Output:**
- Per-case-study verification data
- Summary report with mention/citation rates
- Regression detection

---

### 4. Deltas → Auto-Update Case Studies

**File:** `bin/generate-case-study-updates.php`

Pulls latest ai_checks, compares to previous run, detects deltas, patches machine-owned blocks.

**Usage:**
```bash
php bin/generate-case-study-updates.php
```

**What It Does:**
1. Loads previous verification data
2. Loads current verification data
3. Calculates deltas (mentions, citations, regressions)
4. Updates markdown files with verification blocks
5. Saves current data as previous for next run

**Machine-Owned Block:**
```markdown
<!-- NRLC_AI_VERIFICATION_BLOCK:START -->
AI Verification Log
- Window: 2025-01-01 to 2025-01-07
- Models: ChatGPT, Claude, Google AI Overviews
- Prompt Cluster: prompt-invisible-brand
- Signals:
  - Mentions: 7/10 prompts
  - Citations: 3/10 prompts
  - Regressions: 0
  - Wins: 2
- Notable change: Brand began appearing in ChatGPT answers.
<!-- NRLC_AI_VERIFICATION_BLOCK:END -->
```

**Humans cannot edit this block.** If they do, the validator fails.

**Cron Integration:**
```bash
# Run after AI crawler (daily)
0 3 * * * cd /path/to/nrlc.ai && php bin/generate-case-study-updates.php
```

---

### 5. "Verified by AI" Badge

**File:** `api/badge.php`

TTL-bound, score-based SVG badge. States: VERIFIED / DEGRADED / UNKNOWN. Never permanent.

**Usage:**
```
https://nrlc.ai/api/badge.php?client=1&scope=client&ref=b2b-saas
```

**Parameters:**
- `client` - Client ID (optional)
- `scope` - Scope (client, case-study, cluster)
- `ref` - Case study slug or prompt cluster ID

**Badge States:**
- **VERIFIED** (score ≥ 70): Green badge
- **DEGRADED** (score 40-69): Orange badge
- **UNKNOWN** (score < 40): Gray badge

**Scoring:**
- 50 points for brand mentions
- 50 points for citations
- Based on latest verification data

**Caching:**
- 5-minute cache (300 seconds)
- SVG format for easy embedding

**Example:**
```html
<img src="/api/badge.php?client=1&ref=b2b-saas" alt="AI Verification Badge">
```

---

### 6. Client Dashboard

**File:** `app/clients/overview.php`

Plain PHP + JS charts. No SPA required.

**Pages:**
- `/app/clients/{id}/overview.php` - Main dashboard
- `/app/clients/{id}/clusters.php` - Prompt clusters
- `/app/clients/{id}/prompts.php` - Individual prompts
- `/app/clients/{id}/regressions.php` - Regression queue

**Metrics:**
- Coverage Score (0-100%)
- Mention Rate (%)
- Citation Rate (%)
- Regression Count
- Total Prompts

**Features:**
- Real-time badge display
- Regression alerts
- Coverage trend charts (Chart.js)
- Case study links

**Data Sources:**
- `ai_checks` - Individual verification checks
- `ai_badges` - Badge status
- `prompts` - Test prompts
- `case_studies` - Case study registry

---

## File Structure

```
nrlc.ai/
├── admin/
│   └── case-study-editor.php          # Authoring UI
├── api/
│   └── badge.php                      # Badge SVG endpoint
├── app/
│   └── clients/
│       └── overview.php               # Client dashboard
├── bin/
│   ├── validate-case-study.php        # Build-time validator
│   └── generate-case-study-updates.php # Auto-update script
├── lib/
│   ├── case_study_registry.php        # Case study data
│   ├── case_study_schema.php          # JSON-LD generator
│   └── case_study_validator.php       # Validation rules
├── scripts/
│   └── ai_answer_crawler.php          # AI crawler (cron)
└── data/
    ├── case-studies/                   # Case study files
    └── ai_verification/                # Verification data
```

---

## Cron Setup

**Recommended Schedule:**

```cron
# Daily AI verification (2 AM)
0 2 * * * cd /path/to/nrlc.ai && php scripts/ai_answer_crawler.php

# Daily case study updates (3 AM, after crawler)
0 3 * * * cd /path/to/nrlc.ai && php bin/generate-case-study-updates.php
```

**Environment Variables:**
```bash
export OPENAI_API_KEY="sk-..."
export ANTHROPIC_API_KEY="sk-ant-..."
export SERP_API_KEY="..."
```

---

## Database Schema (Optional)

If you want to use a database instead of files:

```sql
CREATE TABLE case_studies (
  id SERIAL PRIMARY KEY,
  slug VARCHAR(255) UNIQUE NOT NULL,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  prompt_cluster VARCHAR(255) NOT NULL,
  industry VARCHAR(255) NOT NULL,
  situation TEXT NOT NULL,
  ai_failure TEXT NOT NULL,
  technical_diagnosis TEXT NOT NULL,
  intervention TEXT NOT NULL,
  outcome TEXT NOT NULL,
  citation_result TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT NOW(),
  updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE ai_checks (
  id SERIAL PRIMARY KEY,
  case_slug VARCHAR(255) NOT NULL,
  prompt TEXT NOT NULL,
  model VARCHAR(50) NOT NULL,
  mentions_brand BOOLEAN DEFAULT FALSE,
  citation BOOLEAN DEFAULT FALSE,
  position INTEGER,
  raw_answer TEXT,
  notes TEXT,
  created_at TIMESTAMP DEFAULT NOW(),
  FOREIGN KEY (case_slug) REFERENCES case_studies(slug)
);

CREATE INDEX idx_ai_checks_case_slug ON ai_checks(case_slug);
CREATE INDEX idx_ai_checks_created_at ON ai_checks(created_at);
```

---

## Next Steps

1. **Add Authentication** - Protect admin and dashboard pages
2. **Database Integration** - Replace file storage with database (optional)
3. **Email Alerts** - Send notifications on regressions
4. **API Endpoints** - Expose metrics via JSON API
5. **Export Reports** - Generate PDF/CSV reports

---

## This is AI Reputation Infrastructure

This system is no longer "case studies." It is AI reputation infrastructure that:
- Structures proof in machine-readable format
- Routes AI intent to authoritative answers
- Enforces quality through validation
- Monitors truth through verification loops
- Updates automatically based on live AI behavior

**Marketing never touches raw HTML or JSON-LD. Everything is validated, structured, and verified.**

