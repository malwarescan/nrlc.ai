<?php
declare(strict_types=1);

/**
 * CI META GUARDRAIL - Fails CI if SEO structure violations found
 * 
 * Exit code: 0 if all pass, 1 if any fail
 */

require_once __DIR__.'/../lib/meta_directive.php';
require_once __DIR__.'/../lib/helpers.php';

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
    
    // SERP CONTROL: Title must be 45-65 chars (50-60 target)
    if ($len > 65) {
      $errors[] = "Title too long ($len chars, max 65) in $slug: " . substr($title, 0, 60) . "...";
    }
    if ($len < 45) {
      $errors[] = "Title too short ($len chars, min 45) in $slug: $title";
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

// 5. Check for duplicate first 8 words
$duplicateFirst8 = array_filter($first8Words, fn($slugs) => count($slugs) > 1);
if (!empty($duplicateFirst8)) {
  foreach ($duplicateFirst8 as $words => $slugs) {
    $errors[] = "Duplicate first 8 words '$words' in: " . implode(', ', $slugs);
  }
}

// 6. Check canonical == og:url (code path check)
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

// 7. Check HTTPS in absolute_url
$helpersFile = __DIR__.'/../lib/helpers.php';
$helpersContent = file_get_contents($helpersFile);
if (!preg_match('/\$scheme\s*=\s*\$isHttps.*production.*\?.*https.*:.*http/', $helpersContent)) {
  $warnings[] = "absolute_url() may not always return HTTPS - verify production behavior";
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

