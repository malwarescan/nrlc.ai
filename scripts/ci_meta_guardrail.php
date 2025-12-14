<?php
declare(strict_types=1);

/**
 * CI META GUARDRAIL - Fails CI if SEO structure violations found
 * 
 * Exit code: 0 if all pass, 1 if any fail
 */

require_once __DIR__.'/../lib/meta_directive.php';
require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../config/locales.php';
require_once __DIR__.'/../lib/hreflang.php';

$errors = [];
$warnings = [];

// 1. Scan all page files for metadata
$pageFiles = glob(__DIR__.'/../pages/**/*.php');
$titles = [];
$descriptions = [];
$first8Words = [];
$missingMeta = [];

foreach ($pageFiles as $file) {
  $content = file_get_contents($file);
  $slug = str_replace([__DIR__.'/../pages/', '.php'], '', $file);
  
  $hasTitle = preg_match('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=/s', $content);
  $hasDesc = preg_match('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=/s', $content);
  
  if (!$hasTitle || !$hasDesc) {
    $missingMeta[] = $slug;
  }
  
  // Extract title
  if (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageTitle[\'"]\s*\]\s*=\s*[\'"]([^\'"]+)[\'"]\s*;/s', $content, $m)) {
    $title = $m[1];
    $len = strlen($title);
    
    // C1: Title uniqueness law - 50-60 chars target, hard max 65, min 50
    if ($len > 65) {
      $errors[] = "Title too long ($len chars, max 65) in $slug: " . substr($title, 0, 60) . "...";
    }
    if ($len < 50) {
      $errors[] = "Title too short ($len chars, min 50) in $slug: $title";
    }
    
    if (!isset($titles[$title])) {
      $titles[$title] = [];
    }
    $titles[$title][] = $slug;
  }
  
  // Extract description
  if (preg_match('/\$GLOBALS\s*\[\s*[\'"]pageDesc[\'"]\s*\]\s*=\s*[\'"]([^\'"]+)[\'"]\s*;/s', $content, $m)) {
    $desc = $m[1];
    $len = strlen($desc);
    
    // SERP CONTROL: Description must be 130-175 chars (150-165 target)
    if ($len > 175) {
      $errors[] = "Description too long ($len chars, max 175) in $slug: " . substr($desc, 0, 60) . "...";
    }
    if ($len < 130) {
      $errors[] = "Description too short ($len chars, min 130) in $slug: " . substr($desc, 0, 60) . "...";
    }
    
    if (!isset($descriptions[$desc])) {
      $descriptions[$desc] = [];
    }
    $descriptions[$desc][] = $slug;
    
    // Check first 8 words
    $words = explode(' ', $desc);
    $first8 = implode(' ', array_slice($words, 0, 8));
    if (!isset($first8Words[$first8])) {
      $first8Words[$first8] = [];
    }
    $first8Words[$first8][] = $slug;
  }
}

// 2. Check for missing metadata
if (!empty($missingMeta)) {
  $warnings[] = "Pages without explicit metadata (will use meta_directive): " . implode(', ', array_slice($missingMeta, 0, 10));
}

// 3. Check for duplicate titles
$duplicateTitles = array_filter($titles, fn($slugs) => count($slugs) > 1);
if (!empty($duplicateTitles)) {
  foreach ($duplicateTitles as $title => $slugs) {
    $errors[] = "Duplicate title '$title' in: " . implode(', ', $slugs);
  }
}

// 4. Check for duplicate descriptions
$duplicateDescs = array_filter($descriptions, fn($slugs) => count($slugs) > 1);
if (!empty($duplicateDescs)) {
  foreach ($duplicateDescs as $desc => $slugs) {
    $errors[] = "Duplicate description in: " . implode(', ', $slugs);
  }
}

// 5. SUDO POWERED: GLOBAL vs LOCAL INDEXING CHECKS
require_once __DIR__.'/../lib/helpers.php';

// H) CI GUARDRAILS - Check 1: LOCAL page outputs hreflang
// This is a P0 defect - LOCAL pages must NEVER output hreflang
$headFile = __DIR__.'/../templates/head.php';
$headContent = file_get_contents($headFile);
// Verify that hreflang_links() is called and returns empty for LOCAL pages
if (strpos($headContent, 'hreflang_links') === false) {
  $warnings[] = "templates/head.php may not be calling hreflang_links()";
}

// Check 2: City slug exists in >1 locale as indexable
$cityPagePattern = '#/services/([^/]+)/([^/]+)/#';
$cityLocales = []; // Track city slugs and their locales
foreach ($pageFiles as $file) {
  $content = file_get_contents($file);
  $slug = str_replace([__DIR__.'/../pages/', '.php'], '', $file);
  
  // Check if this is a service city page
  if (preg_match($cityPagePattern, $slug, $m)) {
    $citySlug = $m[2];
    $isUK = function_exists('is_uk_city') ? is_uk_city($citySlug) : false;
    
    // Track city and locale
    if (!isset($cityLocales[$citySlug])) {
      $cityLocales[$citySlug] = [];
    }
    if (preg_match('#/([a-z]{2}-[a-z]{2})/#', $slug, $localeMatch)) {
      $cityLocales[$citySlug][] = $localeMatch[1];
    }
    
    // Check if UK city is under wrong locale
    if ($isUK && preg_match('#/(en-us|es-es|fr-fr|de-de|ko-kr)/#', $slug)) {
      $errors[] = "UK city '$citySlug' under wrong locale in: $slug (must be en-gb)";
    }
    
    // Check if non-UK city is under en-gb (unless it's actually a UK city)
    if (!$isUK && preg_match('#/en-gb/#', $slug)) {
      $warnings[] = "Non-UK city '$citySlug' under en-gb in: $slug (verify locale)";
    }
  }
}

// Check for cities appearing in multiple locales (violation)
foreach ($cityLocales as $city => $locales) {
  $uniqueLocales = array_unique($locales);
  if (count($uniqueLocales) > 1) {
    $errors[] = "City '$city' exists in multiple locales: " . implode(', ', $uniqueLocales) . " (must be single canonical)";
  }
}

// 6. Check for duplicate first 8 words in descriptions (I3: Template anti-duplication rule)
$duplicateFirst8 = array_filter($first8Words, fn($slugs) => count($slugs) > 1);
if (!empty($duplicateFirst8)) {
  // Group by template family to detect template-level duplication
  $templateFamilies = [];
  foreach ($duplicateFirst8 as $words => $slugs) {
    foreach ($slugs as $slug) {
      // Detect template family from slug pattern
      $family = 'unknown';
      if (preg_match('#^blog/blog-post#', $slug)) $family = 'blog_post';
      elseif (preg_match('#^case-studies/case-study#', $slug)) $family = 'case_study';
      elseif (preg_match('#^resources/resource#', $slug)) $family = 'resource';
      elseif (preg_match('#^tools/#', $slug)) $family = 'tool';
      elseif (preg_match('#^industries/#', $slug)) $family = 'industry';
      
      if (!isset($templateFamilies[$family])) {
        $templateFamilies[$family] = [];
      }
      $templateFamilies[$family][] = $slug;
    }
    
    // If ≥ 10 pages in family share first 8 words, it's a template duplication violation
    if (count($slugs) >= 10) {
      $errors[] = "Template duplication: '$words' repeated across " . count($slugs) . " pages: " . implode(', ', array_slice($slugs, 0, 5)) . "...";
    } else {
      $errors[] = "Duplicate first 8 words '$words' in: " . implode(', ', $slugs);
    }
  }
}

// 6b. Check for duplicate first 5 words in titles (I3: Template anti-duplication rule)
$first5WordsTitles = [];
foreach ($titles as $title => $slugs) {
  $words = explode(' ', $title);
  $first5 = implode(' ', array_slice($words, 0, 5));
  if (!isset($first5WordsTitles[$first5])) {
    $first5WordsTitles[$first5] = [];
  }
  $first5WordsTitles[$first5] = array_merge($first5WordsTitles[$first5], $slugs);
}
$duplicateFirst5Titles = array_filter($first5WordsTitles, fn($slugs) => count($slugs) > 1);
foreach ($duplicateFirst5Titles as $words => $slugs) {
  // Allow "Local SEO Services in" pattern (required by intent)
  if (stripos($words, 'Local SEO Services in') === 0) {
    continue; // This is intentional for LOCAL_SERVICE_CITY pages
  }
  if (count($slugs) >= 10) {
    $errors[] = "Template title duplication: '$words' repeated across " . count($slugs) . " pages: " . implode(', ', array_slice($slugs, 0, 5)) . "...";
  }
}

// 7. Check canonical == og:url (code path check)
$headFile = __DIR__.'/../templates/head.php';
$headContent = file_get_contents($headFile);
$canonicalLine = null;
$ogUrlLine = null;

if (preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']<\?=absolute_url\(([^)]+)\)\?>/', $headContent, $m)) {
  $canonicalLine = $m[1];
}
if (preg_match('/<meta\s+property=["\']og:url["\']\s+content=["\']<\?=absolute_url\(([^)]+)\)\?>/', $headContent, $m)) {
  $ogUrlLine = $m[1];
}

if ($canonicalLine !== $ogUrlLine) {
  $errors[] = "Canonical and og:url use different variables: canonical=$canonicalLine, og:url=$ogUrlLine";
}

// 8. Check HTTPS in absolute_url
$helpersFile = __DIR__.'/../lib/helpers.php';
$helpersContent = file_get_contents($helpersFile);
if (!preg_match('/\$scheme\s*=\s*\$isHttps.*production.*\?.*https.*:.*http/', $helpersContent)) {
  $warnings[] = "absolute_url() may not always return HTTPS - verify production behavior";
}

// 9. SUDO HREFLANG ALLOWLIST: Check for LOCAL pages with hreflang (P0 defect)
// Verify LOCAL pages return empty hreflang even if somehow in allowlist
if (function_exists('is_local_page')) {
  $testLocalPaths = [
    '/services/local-seo-ai/norwich/',
    '/services/technical-seo/austin/',
    '/careers/london/seo-specialist/'
  ];
  
  foreach ($testLocalPaths as $testPath) {
    if (is_local_page($testPath)) {
      $hreflangResult = hreflang_links($testPath); // LOCAL should return empty regardless of allowlist
      if (!empty($hreflangResult)) {
        $errors[] = "LOCAL page '$testPath' returns hreflang (must return empty array)";
      }
    }
  }
}

// 10. SUDO HREFLANG ALLOWLIST: Verify allowlist structure
$allowlistFile = __DIR__.'/../lib/hreflang_allowlist.php';
if (file_exists($allowlistFile)) {
  $allowlist = require $allowlistFile;
  
  // Check for LOCAL pages in allowlist (should never happen)
  foreach (array_keys($allowlist) as $path) {
    if (function_exists('is_local_page') && is_local_page($path)) {
      $errors[] = "LOCAL page '$path' found in hreflang allowlist (LOCAL pages must never be in allowlist)";
    }
    
    // Validate allowlist entry has at least 2 locales
    if (count($allowlist[$path]) < 2) {
      $errors[] = "Allowlist entry '$path' has fewer than 2 locales (minimum 2 required for hreflang)";
    }
  }
} else {
  $warnings[] = "Hreflang allowlist file not found: $allowlistFile (hreflang will be disabled for all pages)";
}

// I) CI GUARDRAILS - Check 7: Allowlisted hreflang alternate redirects or non-200
// This would require actual HTTP requests in CI environment
// For now, validate allowlist structure and log that HTTP validation is needed
if (file_exists($allowlistFile)) {
  $allowlist = require $allowlistFile;
  foreach ($allowlist as $path => $locales) {
    // In CI, would check each locale URL returns 200 and is self-canonical
    // For now, just note that HTTP validation is required
    $warnings[] = "Hreflang quality gate: HTTP validation required for allowlisted path '$path' (check all locales return 200, are self-canonical, and have reciprocal tags)";
  }
}

// I) CI GUARDRAILS - Check 9: Any sitemap URL redirects or is non-canonical
// Run sitemap validation script
$sitemapValidationScript = __DIR__.'/validate_sitemaps.php';
if (file_exists($sitemapValidationScript)) {
  $output = [];
  $returnCode = 0;
  exec("php $sitemapValidationScript 2>&1", $output, $returnCode);
  if ($returnCode !== 0) {
    $errors[] = "Sitemap validation failed: " . implode("\n", array_slice($output, 0, 10));
  }
} else {
  $warnings[] = "Sitemap validation script not found: $sitemapValidationScript";
}

// I) CI GUARDRAILS - Check 10: Title/H1 intent mismatch (semantic mismatch detected via template rules)
// This requires parsing rendered HTML, which is complex in file-based scan
// For now, validate that router sets intent context
$routerFile = __DIR__.'/../bootstrap/router.php';
$routerContent = file_get_contents($routerFile);
if (strpos($routerContent, 'sudo_meta_directive_ctx') === false) {
  $warnings[] = "Router may not be using sudo_meta_directive_ctx() for all routes (intent contracts may not be enforced)";
}

// Output results with top offenders
if (!empty($errors)) {
  echo "❌ CI META GUARDRAIL FAILED\n\n";
  echo "Errors:\n";
  $errorCount = 0;
  foreach ($errors as $error) {
    echo "  ✗ $error\n";
    $errorCount++;
    if ($errorCount >= 50) {
      echo "  ... (showing first 50 errors, total: " . count($errors) . ")\n";
      break;
    }
  }
  echo "\n";
  
  // Write JSON artifact for PR diffing
  $artifact = [
    'timestamp' => date('c'),
    'total_errors' => count($errors),
    'duplicate_titles' => count($duplicateTitles),
    'duplicate_descriptions' => count($duplicateDescs),
    'duplicate_first8' => count($duplicateFirst8),
    'top_duplicate_titles' => array_slice(array_keys($duplicateTitles), 0, 20),
    'top_duplicate_descriptions' => array_slice(array_keys($duplicateDescs), 0, 20),
    'errors' => array_slice($errors, 0, 100)
  ];
  file_put_contents(__DIR__.'/../ci_meta_guardrail_report.json', json_encode($artifact, JSON_PRETTY_PRINT));
  echo "Artifact written to: ci_meta_guardrail_report.json\n";
}

if (!empty($warnings)) {
  echo "Warnings:\n";
  foreach ($warnings as $warning) {
    echo "  ⚠ $warning\n";
  }
  echo "\n";
}

if (empty($errors)) {
  echo "✓ CI META GUARDRAIL PASSED\n";
  echo "  - All titles <= 65 chars\n";
  echo "  - All descriptions <= 175 chars\n";
  echo "  - No duplicate titles\n";
  echo "  - No duplicate descriptions\n";
  echo "  - No duplicate first 8 words\n";
  echo "  - Canonical == og:url (code path verified)\n";
  exit(0);
} else {
  exit(1);
}

