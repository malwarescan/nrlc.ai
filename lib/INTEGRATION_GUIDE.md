# SchemaFixes Integration Guide

## Add to lib/schema_builders.php

Add this at the top after the require statements:

```php
<?php
require_once __DIR__.'/helpers.php';
require_once __DIR__.'/SchemaFixes.php';  // ← ADD THIS

use NRLC\Schema\SchemaFixes;  // ← ADD THIS
```

## Update Functions

### 1. Fix ld_organization() - Force HTTPS

```php
function ld_organization(): array {
  return [
    '@context'=>'https://schema.org',
    '@type'=>'Organization',
    'name'=>'NRLC.ai',
    'url'=> SchemaFixes::ensureHttps(absolute_url('/')),      // ← WRAP WITH ensureHttps
    'logo'=> SchemaFixes::ensureHttps(absolute_url('/assets/logo.png')),  // ← WRAP WITH ensureHttps
    'sameAs'=>['https://www.linkedin.com/company/neural-command/']
  ];
}
```

### 2. Fix ld_website_with_searchaction() - Force HTTPS

```php
function ld_website_with_searchaction(): array {
  return [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'url' => SchemaFixes::ensureHttps(absolute_url('/')),  // ← ADD
    'name' => 'NRLC.ai',
    'potentialAction' => [
      '@type' => 'SearchAction',
      'target' => SchemaFixes::ensureHttps(absolute_url('/?q={search_term_string}')),  // ← ADD
      'query-input' => 'required name=search_term_string'
    ]
  ];
}
```

### 3. Prevent Duplicate Output

At the end of schema_builders.php, change how you output:

```php
// OLD WAY:
// echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';

// NEW WAY:
function output_schema($schema) {
    $json = SchemaFixes::jsonLdOnce($schema);  // ← Deduplicates by @id
    if ($json) {
        echo '<script type="application/ld+json">' . $json . '</script>';
    }
}
```

## Example: Job Posting with Normalized Requirements

```php
function ld_job_posting($job): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        '@id' => SchemaFixes::ensureHttps($job['url']),
        'title' => $job['title'],
        'description' => $job['description'],
        'datePosted' => $job['date_posted'],
        'hiringOrganization' => [
            '@type' => 'Organization',
            'name' => 'NRLC.ai',
            'url' => SchemaFixes::ensureHttps('https://nrlc.ai'),
            'logo' => SchemaFixes::ensureHttps('https://nrlc.ai/assets/logo.png')
        ],
        'jobLocation' => [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $job['city'],
                'addressCountry' => $job['country']
            ]
        ],
        // ← NORMALIZE THESE:
        'experienceRequirements' => SchemaFixes::normalizeExperienceRequirements($job['experience'] ?? ''),
        'educationRequirements' => SchemaFixes::normalizeEducationRequirements($job['education'] ?? '')
    ];
}

// Usage examples:
// normalizeExperienceRequirements("3 years")  → ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>36]
// normalizeExperienceRequirements("5+ years") → ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>60]
// normalizeEducationRequirements("bachelor's degree") → "Bachelor's degree"
// normalizeEducationRequirements("phd")               → "Doctorate"
```

---

## Testing

```bash
# 1. Deploy to staging/production
git add lib/SchemaFixes.php lib/schema_builders.php
git commit -m "Integrate SchemaFixes for HTTPS normalization and duplicate prevention"
git push

# 2. Test a page
curl -s https://nrlc.ai/ | grep -A 20 'application/ld+json'

# 3. Validate in Google Rich Results
# https://search.google.com/test/rich-results
```

---

## Immediate Benefits

✅ All schema URLs will be forced to HTTPS  
✅ No duplicate @id values across page  
✅ Job experience/education properly structured  
✅ Google can better understand your content
