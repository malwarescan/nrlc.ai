<?php
/**
 * Script to update all author schema references to use canonical Person @id
 * 
 * This updates:
 * - All blog-post-*.php files
 * - Case study files
 * - Any other files with author schema
 */

require_once __DIR__ . '/../lib/person_entity.php';

$canonicalPersonId = JOEL_PERSON_ID;
$canonicalEntityHome = JOEL_ENTITY_HOME_URL;

// Pattern 1: Simple author object with just name
$pattern1_old = '"author":{"@type":"Person","name":"Joel Maldonado"}';
$pattern1_new = '"author":{"@id":"' . $canonicalPersonId . '","@type":"Person","name":"Joel David Maldonado","url":"' . $canonicalEntityHome . '"}';

// Pattern 2: Author in PHP array format (blog-post.php)
$pattern2_old = "'author' => [\n      '@type' => 'Person',\n      'name' => 'Joel Maldonado'\n    ],";
$pattern2_new = "'author' => [\n      '@id' => '" . $canonicalPersonId . "',\n      '@type' => 'Person',\n      'name' => 'Joel David Maldonado',\n      'url' => '" . $canonicalEntityHome . "'\n    ],";

// Pattern 3: Author in PHP array format (single line)
$pattern3_old = "'author' => ['@type' => 'Person', 'name' => 'Joel Maldonado'],";
$pattern3_new = "'author' => ['@id' => '" . $canonicalPersonId . "', '@type' => 'Person', 'name' => 'Joel David Maldonado', 'url' => '" . $canonicalEntityHome . "'],";

// Pattern 4: Author with @id but wrong ID
$pattern4_old = "'@id' => \$personId,";
$pattern4_new = "'@id' => '" . $canonicalPersonId . "',";

// Find all blog post files
$blogDir = __DIR__ . '/../pages/blog/';
$blogFiles = glob($blogDir . 'blog-post-*.php');

$updated = 0;
$errors = [];

foreach ($blogFiles as $file) {
  $content = file_get_contents($file);
  $original = $content;
  
  // Replace pattern 1 (JSON string)
  $content = str_replace($pattern1_old, $pattern1_new, $content);
  
  // Replace pattern 2 (multi-line PHP)
  $content = str_replace($pattern2_old, $pattern2_new, $content);
  
  // Replace pattern 3 (single-line PHP)
  $content = str_replace($pattern3_old, $pattern3_new, $content);
  
  if ($content !== $original) {
    file_put_contents($file, $content);
    $updated++;
    echo "Updated: " . basename($file) . "\n";
  }
}

// Update case study files
$caseStudyFiles = [
  __DIR__ . '/../pages/case-studies/ecommerce.php',
  __DIR__ . '/../pages/case-studies/real-estate.php',
  __DIR__ . '/../pages/case-studies/education.php',
  __DIR__ . '/../pages/case-studies/fintech.php',
  __DIR__ . '/../pages/case-studies/healthcare.php',
  __DIR__ . '/../pages/case-studies/b2b-saas.php',
];

foreach ($caseStudyFiles as $file) {
  if (!file_exists($file)) continue;
  
  $content = file_get_contents($file);
  $original = $content;
  
  // Replace personId variable
  $content = preg_replace(
    '/\$personId\s*=\s*[^;]+;/',
    "\$personId = '" . $canonicalPersonId . "';",
    $content
  );
  
  // Update author in Article schema
  $content = preg_replace(
    "/'author'\s*=>\s*\[\s*'@type'\s*=>\s*'Person',\s*'@id'\s*=>\s*\\\$personId,\s*'name'\s*=>\s*'Joel Maldonado'\s*\]/",
    "'author' => ['@id' => '" . $canonicalPersonId . "', '@type' => 'Person', 'name' => 'Joel David Maldonado', 'url' => '" . $canonicalEntityHome . "']",
    $content
  );
  
  // Remove full Person schema object (case studies should only reference, not mint)
  // Find and remove the Person schema block
  $content = preg_replace(
    '/\s*\/\/\s*3\.\s*Person\s*\([^)]+\)\s*\[.*?\]\s*,/s',
    '',
    $content
  );
  
  if ($content !== $original) {
    file_put_contents($file, $content);
    $updated++;
    echo "Updated: " . basename($file) . "\n";
  }
}

echo "\nTotal files updated: $updated\n";
echo "Canonical Person ID: $canonicalPersonId\n";
echo "Entity Home URL: $canonicalEntityHome\n";
