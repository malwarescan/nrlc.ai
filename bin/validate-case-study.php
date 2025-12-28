#!/usr/bin/env php
<?php
/**
 * NRLC AI Case Study System - Build-Time Validator
 * 
 * Validates case study JSON-LD files before deployment.
 * Fail = no deploy.
 * 
 * Usage: php bin/validate-case-study.php content/case-studies/foo.jsonld
 */

if ($argc < 2) {
  fwrite(STDERR, "Usage: php bin/validate-case-study.php <jsonld-file>\n");
  exit(1);
}

$filePath = $argv[1];

if (!file_exists($filePath)) {
  fwrite(STDERR, "Error: File not found: {$filePath}\n");
  exit(1);
}

$content = file_get_contents($filePath);
$data = json_decode($content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
  fwrite(STDERR, "Error: Invalid JSON: " . json_last_error_msg() . "\n");
  exit(1);
}

$errors = [];

// Check if it's a graph structure
if (!isset($data['@graph']) && !is_array($data)) {
  $errors[] = "Not a valid JSON-LD graph structure";
}

// Find CaseStudy entity
$caseStudy = null;
if (isset($data['@graph'])) {
  foreach ($data['@graph'] as $item) {
    if (($item['@type'] ?? '') === 'CaseStudy') {
      $caseStudy = $item;
      break;
    }
  }
} else {
  // Single entity (not a graph)
  if (($data['@type'] ?? '') === 'CaseStudy') {
    $caseStudy = $data;
  }
}

if (!$caseStudy) {
  $errors[] = "No CaseStudy entity found";
  exit(implode("\n", $errors) . "\n");
}

// Validate required fields
$required = ['name', 'headline', 'description', 'url', 'problem', 'hasPart', 'result'];
foreach ($required as $field) {
  if (!isset($caseStudy[$field])) {
    $errors[] = "Missing required field: {$field}";
  }
}

// Validate hasPart structure
if (isset($caseStudy['hasPart']) && is_array($caseStudy['hasPart'])) {
  $requiredParts = ['Situation', 'AI Retrieval Failure', 'Technical Diagnosis', 'Intervention', 'Outcome'];
  $partNames = array_column($caseStudy['hasPart'], 'name');
  
  foreach ($requiredParts as $requiredPart) {
    if (!in_array($requiredPart, $partNames)) {
      $errors[] = "Missing required section in hasPart: {$requiredPart}";
    }
  }
  
  // Validate each part has text
  foreach ($caseStudy['hasPart'] as $part) {
    if (!isset($part['text']) || empty(trim($part['text']))) {
      $errors[] = "Part '{$part['name']}' missing or empty text";
    }
  }
} else {
  $errors[] = "hasPart is missing or not an array";
}

// Validate problem references DefinedTerm
if (isset($caseStudy['problem'])) {
  if (!isset($caseStudy['problem']['@type']) || $caseStudy['problem']['@type'] !== 'DefinedTerm') {
    $errors[] = "problem must reference a DefinedTerm";
  }
  if (!isset($caseStudy['problem']['@id'])) {
    $errors[] = "problem must have @id pointing to prompt cluster";
  }
}

// Validate result structure
if (isset($caseStudy['result'])) {
  if (!isset($caseStudy['result']['@type']) || $caseStudy['result']['@type'] !== 'Thing') {
    $errors[] = "result must be a Thing";
  }
  if (!isset($caseStudy['result']['description']) || empty(trim($caseStudy['result']['description']))) {
    $errors[] = "result must have a description";
  }
}

// Output results
if (empty($errors)) {
  echo "✓ Case study validation passed\n";
  exit(0);
} else {
  fwrite(STDERR, "✗ Case study validation failed:\n");
  foreach ($errors as $error) {
    fwrite(STDERR, "  - {$error}\n");
  }
  exit(1);
}

