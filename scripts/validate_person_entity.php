<?php
/**
 * Guardrail Script: Validates Person Entity Consistency
 * 
 * This script fails if:
 * 1. Any file contains a Person @id that is NOT the canonical Person ID
 * 2. Any file mints a full Person object outside the entity-home page
 * 
 * Usage: php scripts/validate_person_entity.php
 * Exit code: 0 = pass, 1 = fail
 */

require_once __DIR__ . '/../lib/person_entity.php';

$canonicalPersonId = JOEL_PERSON_ID;
$entityHomePath = 'pages/about/joel-maldonado.php';

$errors = [];
$checkedFiles = 0;

// Patterns to check
$patterns = [
  // Pattern 1: Person with @id that's not canonical
  '/"@type"\s*:\s*"Person"[^}]*"@id"\s*:\s*"([^"]+)"/',
  "/'@type'\s*=>\s*'Person'[^}]*'@id'\s*=>\s*'([^']+)'/",
  '/@type.*Person.*@id.*["\']([^"\']+)#person["\']/i',
];

// Directories to check
$directories = [
  __DIR__ . '/../pages',
  __DIR__ . '/../lib',
  __DIR__ . '/../bootstrap',
];

// Exclude entity home page from full Person object check
$excludeFromFullCheck = [realpath(__DIR__ . '/../' . $entityHomePath)];

function checkFile($filePath, $canonicalPersonId, $entityHomePath, &$errors) {
  global $checkedFiles;
  $checkedFiles++;
  
  $content = file_get_contents($filePath);
  $relativePath = str_replace(__DIR__ . '/../', '', $filePath);
  
  // Check 1: Find all Person @id references
  if (preg_match_all('/"@id"\s*:\s*"([^"]+#person)"/i', $content, $matches)) {
    foreach ($matches[1] as $foundId) {
      if ($foundId !== $canonicalPersonId) {
        $errors[] = "❌ $relativePath: Found non-canonical Person @id: $foundId (expected: $canonicalPersonId)";
      }
    }
  }
  
  if (preg_match_all("/'@id'\s*=>\s*'([^']+#person)'/i", $content, $matches)) {
    foreach ($matches[1] as $foundId) {
      if ($foundId !== $canonicalPersonId) {
        $errors[] = "❌ $relativePath: Found non-canonical Person @id: $foundId (expected: $canonicalPersonId)";
      }
    }
  }
  
  // Check 2: Find full Person objects (outside entity home)
  $isEntityHome = (strpos($filePath, $entityHomePath) !== false);
  
  if (!$isEntityHome) {
    // Check for full Person objects with multiple properties (not just @id reference)
    $personObjectPattern = '/"@type"\s*:\s*"Person"[^}]*("name"|"jobTitle"|"sameAs"|"knowsAbout"|"worksFor"|"image")/';
    if (preg_match($personObjectPattern, $content)) {
      // Check if it's just a reference (only @id and maybe name/url) vs full object
      $fullObjectPattern = '/"@type"\s*:\s*"Person"[^}]*("jobTitle"|"sameAs"|"knowsAbout"|"worksFor"|"image")/';
      if (preg_match($fullObjectPattern, $content)) {
        $errors[] = "❌ $relativePath: Found full Person object with extended properties (jobTitle/sameAs/knowsAbout/worksFor/image). Only entity-home page should have full Person object.";
      }
    }
    
    // PHP array format check
    $phpFullObjectPattern = "/'@type'\s*=>\s*'Person'[^}]*('jobTitle'|'sameAs'|'knowsAbout'|'worksFor'|'image')/";
    if (preg_match($phpFullObjectPattern, $content)) {
      $errors[] = "❌ $relativePath: Found full Person object in PHP format with extended properties. Only entity-home page should have full Person object.";
    }
  }
  
  // Check 3: Look for old Person @id patterns
  $oldPatterns = [
    '/#joel-maldonado/',
    '/joel-maldonado#/',
    '/#joel[^"]*"/',
  ];
  
  foreach ($oldPatterns as $pattern) {
    if (preg_match($pattern, $content) && !$isEntityHome) {
      $errors[] = "⚠️  $relativePath: Found potential old Person @id pattern. Verify it uses canonical Person ID.";
    }
  }
}

// Scan directories
foreach ($directories as $dir) {
  if (!is_dir($dir)) continue;
  
  $iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
  );
  
  foreach ($iterator as $file) {
    if ($file->isFile() && preg_match('/\.php$/', $file->getFilename())) {
      checkFile($file->getPathname(), $canonicalPersonId, $entityHomePath, $errors);
    }
  }
}

// Output results
echo "=== Person Entity Validation ===\n\n";
echo "Canonical Person ID: $canonicalPersonId\n";
echo "Entity Home Page: $entityHomePath\n";
echo "Files checked: $checkedFiles\n\n";

if (empty($errors)) {
  echo "✅ PASS: All Person entities use canonical @id. No full Person objects found outside entity-home.\n";
  exit(0);
} else {
  echo "❌ FAIL: Found " . count($errors) . " issue(s):\n\n";
  foreach ($errors as $error) {
    echo "$error\n";
  }
  echo "\n";
  exit(1);
}
