<?php
/**
 * Post-Deploy Verification Script: Person Entity Implementation
 * 
 * Verifies that Google sees exactly what we intend and nothing regressed.
 * 
 * Usage: php scripts/post_deploy_verify_person_entity.php [--live]
 * 
 * Without --live flag: Checks local files only
 * With --live flag: Checks live URLs (requires curl)
 * 
 * Exit code: 0 = all checks pass, 1 = failures found
 */

require_once __DIR__ . '/../lib/person_entity.php';

$canonicalPersonId = JOEL_PERSON_ID;
$entityHomeUrl = JOEL_ENTITY_HOME_URL;
$canonicalImageUrl = 'https://nrlc.ai/assets/images/joel-maldonado.png';
$expectedSameAs = [
  'https://www.linkedin.com/in/agentic-search/',
  'https://medium.com/@schemata',
  'https://github.com/malwarescan'
];

$checkLive = in_array('--live', $argv);

echo "=== POST-DEPLOY VERIFICATION: Person Entity ===\n\n";
echo "Canonical Person ID: $canonicalPersonId\n";
echo "Entity Home URL: $entityHomeUrl\n\n";

$errors = [];
$warnings = [];
$checks = 0;

// Check 1: URL Behavior (redirect)
if ($checkLive) {
  echo "1. URL Behavior Check (Live)...\n";
  $checks++;
  
  // Check redirect
  $ch = curl_init('https://nrlc.ai/about/joel-maldonado/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
  curl_close($ch);
  
  if ($httpCode === 301 && $redirectUrl === $entityHomeUrl) {
    echo "   ✅ /about/joel-maldonado/ correctly redirects 301 to $entityHomeUrl\n";
  } else {
    $errors[] = "   ❌ /about/joel-maldonado/ redirect check failed. Expected 301 to $entityHomeUrl, got HTTP $httpCode";
  }
  
  // Check canonical URL returns 200
  $ch = curl_init($entityHomeUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  
  if ($httpCode === 200) {
    echo "   ✅ $entityHomeUrl returns 200\n";
  } else {
    $errors[] = "   ❌ $entityHomeUrl returned HTTP $httpCode (expected 200)";
  }
} else {
  echo "1. URL Behavior Check (Skipped - use --live flag)\n";
}

// Check 2: View Source Checks (JSON-LD validation)
echo "\n2. View Source Checks (JSON-LD Validation)...\n";
$checks++;

$entityHomeFile = __DIR__ . '/../pages/about/joel-maldonado.php';
if (!file_exists($entityHomeFile)) {
  $errors[] = "   ❌ Entity home file not found: $entityHomeFile";
} else {
  $content = file_get_contents($entityHomeFile);
  
  // Check for exactly one full Person object
  $personMatches = preg_match_all('/"@type"\s*:\s*"Person"/', $content);
  if ($personMatches === 1) {
    echo "   ✅ Exactly one Person JSON-LD object found\n";
  } else {
    $errors[] = "   ❌ Found $personMatches Person objects (expected 1)";
  }
  
  // Check Person @id
  if (strpos($content, $canonicalPersonId) !== false) {
    echo "   ✅ Person @id matches canonical: $canonicalPersonId\n";
  } else {
    $errors[] = "   ❌ Person @id not found or incorrect. Expected: $canonicalPersonId";
  }
  
  // Check ProfilePage mainEntity
  if (preg_match('/"mainEntity"\s*:\s*\{[^}]*"@id"\s*:\s*"([^"]+)"/', $content, $matches)) {
    if ($matches[1] === $canonicalPersonId) {
      echo "   ✅ ProfilePage.mainEntity points to canonical Person @id\n";
    } else {
      $errors[] = "   ❌ ProfilePage.mainEntity points to wrong @id: {$matches[1]} (expected: $canonicalPersonId)";
    }
  } else {
    $errors[] = "   ❌ ProfilePage.mainEntity not found or malformed";
  }
  
  // Check Organization @id
  if (strpos($content, 'https://nrlc.ai/#organization') !== false) {
    echo "   ✅ Organization @id matches: https://nrlc.ai/#organization\n";
  } else {
    $errors[] = "   ❌ Organization @id not found or incorrect";
  }
  
  // Check sameAs URLs
  $sameAsFound = [];
  foreach ($expectedSameAs as $url) {
    if (strpos($content, $url) !== false) {
      $sameAsFound[] = $url;
    }
  }
  
  if (count($sameAsFound) === count($expectedSameAs)) {
    echo "   ✅ All sameAs URLs present and correct\n";
  } else {
    $missing = array_diff($expectedSameAs, $sameAsFound);
    $errors[] = "   ❌ Missing sameAs URLs: " . implode(', ', $missing);
  }
  
  // Check image URL
  if (strpos($content, $canonicalImageUrl) !== false) {
    echo "   ✅ Person.image.url matches: $canonicalImageUrl\n";
  } else {
    $errors[] = "   ❌ Person.image.url not found or incorrect. Expected: $canonicalImageUrl";
  }
  
  // Check sameAs links are visible in HTML (not just schema)
  $htmlContent = $content;
  $visibleLinks = 0;
  foreach ($expectedSameAs as $url) {
    // Check if URL appears in HTML anchor tags
    if (preg_match('/<a[^>]*href=["\']' . preg_quote($url, '/') . '["\'][^>]*>/i', $htmlContent)) {
      $visibleLinks++;
    }
  }
  
  if ($visibleLinks === count($expectedSameAs)) {
    echo "   ✅ All sameAs links visible in HTML\n";
  } else {
    $warnings[] = "   ⚠️  Only $visibleLinks of " . count($expectedSameAs) . " sameAs links visible in HTML";
  }
}

// Check 3: Random Articles Spot Check
echo "\n3. Random Articles Spot Check...\n";
$checks++;

$blogFiles = glob(__DIR__ . '/../pages/blog/blog-post-*.php');
$caseStudyFiles = glob(__DIR__ . '/../pages/case-studies/*.php');

// Pick 3 random blog posts
$randomBlogPosts = [];
if (count($blogFiles) >= 3) {
  $randomKeys = array_rand($blogFiles, 3);
  foreach ($randomKeys as $key) {
    $randomBlogPosts[] = $blogFiles[$key];
  }
} else {
  $randomBlogPosts = array_slice($blogFiles, 0, min(3, count($blogFiles)));
}

// Pick 1 random case study (exclude index)
$caseStudyFiles = array_filter($caseStudyFiles, function($f) {
  return basename($f) !== 'index.php';
});
$caseStudyFiles = array_values($caseStudyFiles); // Re-index array
$randomCaseStudy = count($caseStudyFiles) > 0 ? [$caseStudyFiles[array_rand($caseStudyFiles)]] : [];

$articlesToCheck = array_merge($randomBlogPosts, $randomCaseStudy);

foreach ($articlesToCheck as $file) {
  $relativePath = str_replace(__DIR__ . '/../', '', $file);
  $content = file_get_contents($file);
  
  // Check author uses only @id reference
  if (preg_match('/"author"\s*:\s*\{[^}]*"@id"\s*:\s*"([^"]+)"/', $content, $matches)) {
    if ($matches[1] === $canonicalPersonId) {
      echo "   ✅ $relativePath: Author uses canonical Person @id\n";
    } else {
      $errors[] = "   ❌ $relativePath: Author uses wrong @id: {$matches[1]}";
    }
  } else {
    $errors[] = "   ❌ $relativePath: Author field not found or malformed";
  }
  
  // Check no full Person object
  if (preg_match('/"@type"\s*:\s*"Person"[^}]*("jobTitle"|"sameAs"|"knowsAbout"|"worksFor"|"image")/', $content)) {
    $errors[] = "   ❌ $relativePath: Contains full Person object (should only reference @id)";
  } else {
    echo "   ✅ $relativePath: No full Person object (correct)\n";
  }
}

// Check 4: Guardrail Enforcement
echo "\n4. Guardrail Enforcement Check...\n";
$checks++;

$guardrailScript = __DIR__ . '/validate_person_entity.php';
if (file_exists($guardrailScript)) {
  $output = [];
  $returnCode = 0;
  exec("php $guardrailScript 2>&1", $output, $returnCode);
  
  if ($returnCode === 0) {
    echo "   ✅ Guardrail script passes\n";
  } else {
    $errors[] = "   ❌ Guardrail script failed (exit code $returnCode)";
    echo "   Guardrail output:\n";
    foreach ($output as $line) {
      echo "     $line\n";
    }
  }
} else {
  $errors[] = "   ❌ Guardrail script not found: $guardrailScript";
}

// Summary
echo "\n=== VERIFICATION SUMMARY ===\n";
echo "Checks performed: $checks\n";
echo "Errors: " . count($errors) . "\n";
echo "Warnings: " . count($warnings) . "\n\n";

if (!empty($warnings)) {
  echo "WARNINGS:\n";
  foreach ($warnings as $warning) {
    echo "$warning\n";
  }
  echo "\n";
}

if (empty($errors)) {
  echo "✅ ALL CHECKS PASSED\n";
  echo "\nNext steps:\n";
  echo "1. In Google Search Console, inspect: $entityHomeUrl\n";
  echo "2. Request indexing for 1-2 updated blog posts\n";
  echo "3. Verify Person/ProfilePage schema in URL Inspection tool\n";
  exit(0);
} else {
  echo "❌ VERIFICATION FAILED\n\n";
  echo "ERRORS:\n";
  foreach ($errors as $error) {
    echo "$error\n";
  }
  echo "\n";
  exit(1);
}
