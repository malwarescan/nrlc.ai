<?php
/**
 * Fix case study files to:
 * 1. Use canonical Person @id constant
 * 2. Remove full Person schema objects (only reference @id)
 */

require_once __DIR__ . '/../lib/person_entity.php';

$caseStudyFiles = [
  __DIR__ . '/../pages/case-studies/real-estate.php',
  __DIR__ . '/../pages/case-studies/education.php',
  __DIR__ . '/../pages/case-studies/fintech.php',
  __DIR__ . '/../pages/case-studies/healthcare.php',
  __DIR__ . '/../pages/case-studies/b2b-saas.php',
];

foreach ($caseStudyFiles as $file) {
  if (!file_exists($file)) {
    echo "File not found: " . basename($file) . "\n";
    continue;
  }
  
  $content = file_get_contents($file);
  $original = $content;
  
  // Add person_entity.php require if not present
  if (strpos($content, "require_once __DIR__ . '/../../lib/person_entity.php';") === false) {
    $content = str_replace(
      "require_once __DIR__ . '/../../lib/helpers.php';",
      "require_once __DIR__ . '/../../lib/helpers.php';\nrequire_once __DIR__ . '/../../lib/person_entity.php';",
      $content
    );
  }
  
  // Update personId variable
  $content = preg_replace(
    '/\$personId\s*=\s*[^;]+;/',
    "\$personId = JOEL_PERSON_ID;",
    $content
  );
  
  // Update author in Article schema (ensure it uses @id reference)
  $content = preg_replace(
    "/'author'\s*=>\s*\[[^\]]*'@id'[^\]]*\]/s",
    "'author' => ['@id' => JOEL_PERSON_ID, '@type' => 'Person', 'name' => 'Joel David Maldonado', 'url' => JOEL_ENTITY_HOME_URL]",
    $content
  );
  
  // Remove full Person schema object (look for "// 3. Person" comment and remove the entire array)
  $content = preg_replace(
    '/\s*\/\/\s*3\.\s*Person\s*\([^)]+\)\s*\[[^\]]*\]\s*,/s',
    '',
    $content
  );
  
  // Fix numbering for Organization (should be 3, not 4)
  $content = preg_replace(
    '/\/\/\s*4\.\s*Organization/',
    '// 3. Organization',
    $content
  );
  
  // Fix numbering for BreadcrumbList (should be 4, not 5)
  $content = preg_replace(
    '/\/\/\s*5\.\s*BreadcrumbList/',
    '// 4. BreadcrumbList',
    $content
  );
  
  if ($content !== $original) {
    file_put_contents($file, $content);
    echo "Fixed: " . basename($file) . "\n";
  } else {
    echo "No changes needed: " . basename($file) . "\n";
  }
}

echo "\nDone!\n";
