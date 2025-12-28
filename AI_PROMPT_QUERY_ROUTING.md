# AI Prompt-Like Query Routing System

## Overview

This system identifies and routes AI prompt-like queries (queries that sound like prompts to AI systems) to the correct pages on nrlc.ai. These queries behave differently from traditional SEO keywords—they're answered by AI systems, not ten blue links, and require precise intent routing.

## Generated Files

- **`ai_prompt_like_queries_mapped.csv`**: Complete mapping of 301 AI prompt-like queries to their recommended pages
- **`scripts/analyze_ai_prompt_queries.php`**: Automated analyzer and router script

## Routing Rules

### Rule 1: "looking for / help me find / consultant / agency"
**Pattern:** "looking for", "consultant", "agency", "service", "companies"

**Surfaces:**
- `/ai-visibility/`
- `/ai-visibility/{industry}/`
- `/services/enterprise-schema-markup/`

**Example:**
- `looking for a chatgpt consultant to boost visibility for contractors` → `/ai-visibility/contractor/`

### Rule 2: "what agencies specialize in / best agencies"
**Pattern:** "what agencies", "which agencies", "best agencies", "companies that specialize", "search engine.*companies"

**Surfaces:**
- `/services/enterprise-schema-markup/` (for schema-specific queries)
- `/insights/enterprise-schema-agencies/` (for general agency comparison - page needs to be created)

**Example:**
- `what agencies specialize in enterprise-level schema markup implementation` → `/services/enterprise-schema-markup/`
- `search engine optimisation companies derby` → `/en-gb/services/local-seo-ai/derby/` (city-specific, routes to local page)

### Rule 3: "how / what is / does ai"
**Pattern:** "what is", "how does", "how to", "explain"

**Surfaces:**
- `/ai-visibility/`
- `/insights/glossary/`
- `/insights/framework/`

**Note:** Never send these to sales pages.

### Rule 4: Location + service prompts
**Pattern:** City name, "near me", ZIP / state

**Surfaces:**
- `/services/local-seo-ai/{city}/`

**Note:** If city page does not exist → that is a content gap, not a routing issue.

### Rule 5: Tool / API / implementation queries
**Pattern:** "api", "tracking", "implementation", "schema markup"

**Surfaces:**
- `/services/json-ld-strategy/`
- `/services/enterprise-schema-markup/` (for enterprise-level queries)

## Intent Classes

- **`hire_recommendation`**: User is looking to hire a service provider
- **`agency_evaluation`**: User is evaluating agencies (e.g., "what agencies specialize in...")
- **`agency_comparison`**: User wants to compare agencies
- **`local_hire`**: User is looking for local services (city-specific)
- **`tool_or_service_lookup`**: User is looking for tools or technical services
- **`explanatory`**: User wants to understand how something works
- **`general`**: Fallback for queries that don't fit other categories

## Confidence Levels

- **`high`**: Query pattern clearly matches routing rule
- **`medium`**: Query pattern partially matches, but routing is reasonable
- **`low`**: Query pattern is weak, routing is a best guess

## Statistics

- **Total queries processed:** 1,000
- **AI prompt-like queries identified:** 301
- **Queries mapped:** 301

## Missing Pages (Content Gaps)

The following pages are referenced in the routing but may not exist yet:

1. `/en-gb/insights/enterprise-schema-agencies/` - Referenced for agency comparison queries
2. Various city-specific `/services/local-seo-ai/{city}/` pages - Some cities may not have pages yet

## Next Steps

1. **Review routing accuracy** - Manually verify high-confidence mappings
2. **Create missing pages** - Build pages referenced in routing that don't exist
3. **Integrate into router** - Consider adding query-to-page routing logic to `bootstrap/router.php`
4. **Monitor performance** - Track which queries surface which pages in GSC
5. **Refine patterns** - Update routing rules based on actual query behavior

## Usage

To regenerate the mapping:

```bash
php scripts/analyze_ai_prompt_queries.php
```

The script will:
1. Read queries from the GSC export CSV
2. Identify prompt-like queries using pattern matching
3. Route each query to the appropriate page using deterministic rules
4. Output `ai_prompt_like_queries_mapped.csv`

## Integration Options

### Option 1: Plug CSV into CMS/router
Route AI-prompt traffic intentionally to prevent dilution.

### Option 2: Add "Prompt Surface" report
Track queries → pages → impressions to identify where AI prompts fail to convert or surface.

### Option 3: Build missing pages
Any query mapped to a page that doesn't exist yet is a guaranteed AI visibility gap.

