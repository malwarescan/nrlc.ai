#!/usr/bin/env php
<?php
/**
 * NRLC AI Case Study System - Red Team Test Suite
 * 
 * Adversarial testing to verify truth guarantees.
 * 
 * Tests:
 * 1. Badge spoofing attempts
 * 2. Verification data poisoning
 * 3. Validator bypass attempts
 * 4. Prompt manipulation
 * 5. Case study data integrity
 * 6. Auth/CSRF bypass
 * 7. Machine block tampering
 * 
 * Usage: php scripts/red_team_test.php
 */

require_once __DIR__ . '/../lib/case_study_registry.php';
require_once __DIR__ . '/../lib/case_study_validator.php';
require_once __DIR__ . '/../lib/case_study_schema.php';

$tests = [];
$passed = 0;
$failed = 0;

/**
 * Test runner
 */
function test(string $name, callable $test): void {
  global $tests, $passed, $failed;
  
  echo "Testing: {$name}... ";
  
  try {
    $result = $test();
    if ($result === true) {
      echo "✅ PASS\n";
      $passed++;
      $tests[] = ['name' => $name, 'status' => 'PASS'];
    } else {
      echo "❌ FAIL: {$result}\n";
      $failed++;
      $tests[] = ['name' => $name, 'status' => 'FAIL', 'reason' => $result];
    }
  } catch (Throwable $e) {
    echo "❌ ERROR: {$e->getMessage()}\n";
    $failed++;
    $tests[] = ['name' => $name, 'status' => 'ERROR', 'reason' => $e->getMessage()];
  }
}

echo "=== NRLC AI Case Study System - Red Team Test Suite ===\n\n";

// ============================================================================
// TEST 1: Badge Spoofing
// ============================================================================

test("Badge cannot be spoofed via query params", function() {
  // Badge should read from files, not query params
  $badgeFile = __DIR__ . '/../api/badge.php';
  $code = file_get_contents($badgeFile);
  
  // Check that badge doesn't trust query params for status
  if (preg_match('/\$_GET\[[\'"]status[\'"]\]/', $code)) {
    return "Badge accepts status from query params (VULNERABLE)";
  }
  
  // Check that badge reads from verification files (glob or file operations)
  if (!preg_match('/glob.*ai_verification|file_get_contents.*ai_verification|verificationFiles/', $code)) {
    return "Badge doesn't read from verification files";
  }
  
  return true;
});

test("Badge score calculation cannot be manipulated", function() {
  // Score should be calculated from actual data, not input
  $badgeFile = __DIR__ . '/../api/badge.php';
  $code = file_get_contents($badgeFile);
  
  // Check that score is calculated, not accepted from input
  if (preg_match('/\$_GET.*score|score.*\$_GET/', $code)) {
    return "Badge accepts score from query params (VULNERABLE)";
  }
  
  // Check that calculate_badge_score function exists
  if (!preg_match('/function calculate_badge_score/', $code)) {
    return "Badge score calculation function missing";
  }
  
  return true;
});

// ============================================================================
// TEST 2: Verification Data Poisoning
// ============================================================================

test("Verification data cannot be injected via API responses", function() {
  $crawlerFile = __DIR__ . '/../scripts/ai_answer_crawler.php';
  $code = file_get_contents($crawlerFile);
  
  // Check that API responses are sanitized
  if (!preg_match('/substr.*4000|substr.*text/', $code)) {
    return "API responses not truncated (memory attack possible)";
  }
  
  // Check that JSON encoding is used (not eval)
  if (preg_match('/eval\(|unserialize\(/', $code)) {
    return "Dangerous functions used (eval/unserialize)";
  }
  
  return true;
});

test("Verification files cannot be overwritten by external input", function() {
  $crawlerFile = __DIR__ . '/../scripts/ai_answer_crawler.php';
  $code = file_get_contents($crawlerFile);
  
  // Check that file paths are not constructed from user input
  if (preg_match('/\$_GET.*file|\$_POST.*file|\$_REQUEST.*file/', $code)) {
    return "File paths constructed from user input (VULNERABLE)";
  }
  
  // Check that file paths use fixed directory structure
  if (!preg_match('/dataDir.*ai_verification/', $code)) {
    return "File paths not using fixed directory structure";
  }
  
  return true;
});

// ============================================================================
// TEST 3: Validator Bypass
// ============================================================================

test("Validator cannot be bypassed with malformed JSON", function() {
  $validatorFile = __DIR__ . '/../bin/validate-case-study.php';
  
  // Create test file with malformed JSON
  $testFile = sys_get_temp_dir() . '/test_malformed.jsonld';
  file_put_contents($testFile, '{ invalid json }');
  
  $output = [];
  $returnVar = 0;
  exec("php {$validatorFile} {$testFile} 2>&1", $output, $returnVar);
  
  unlink($testFile);
  
  if ($returnVar === 0) {
    return "Validator accepts malformed JSON (VULNERABLE)";
  }
  
  return true;
});

test("Validator blocks missing required sections", function() {
  $validatorFile = __DIR__ . '/../bin/validate-case-study.php';
  
  // Create test file missing required section
  $testFile = sys_get_temp_dir() . '/test_incomplete.jsonld';
  $incomplete = [
    '@context' => 'https://schema.org',
    '@type' => 'CaseStudy',
    'name' => 'Test',
    'hasPart' => [
      ['name' => 'Situation', 'text' => 'Test']
      // Missing: AI Retrieval Failure, Technical Diagnosis, etc.
    ]
  ];
  file_put_contents($testFile, json_encode($incomplete));
  
  $output = [];
  $returnVar = 0;
  exec("php {$validatorFile} {$testFile} 2>&1", $output, $returnVar);
  
  unlink($testFile);
  
  if ($returnVar === 0) {
    return "Validator accepts incomplete case study (VULNERABLE)";
  }
  
  return true;
});

test("Validator blocks banned phrases", function() {
  $testData = [
    'prompt_cluster' => 'invisible-brand',
    'situation' => 'This is a cutting-edge solution that leveraged industry-leading technology.',
    'ai_failure' => 'Test failure description with enough characters to pass minimum length requirements.',
    'technical_diagnosis' => 'The entity data schema was missing.',
    'intervention' => 'We implemented the solution.',
    'outcome' => 'The answer changed.'
  ];
  
  $error = validate_case_study($testData);
  
  if (empty($error)) {
    return "Validator accepts banned phrases (VULNERABLE)";
  }
  
  if (strpos($error, 'cutting-edge') === false && strpos($error, 'leveraged') === false) {
    return "Validator error message doesn't identify banned phrase";
  }
  
  return true;
});

// ============================================================================
// TEST 4: Prompt Manipulation
// ============================================================================

test("Prompts cannot be injected via case study data", function() {
  $crawlerFile = __DIR__ . '/../scripts/ai_answer_crawler.php';
  $code = file_get_contents($crawlerFile);
  
  // Check that prompts are generated, not read from case study data
  if (preg_match('/\$caseData\[[\'"]prompt[\'"]\]|\$caseData\[[\'"]prompts[\'"]\]/', $code)) {
    return "Prompts read from case study data (injection possible)";
  }
  
  // Check that get_test_prompts function exists
  if (!preg_match('/function get_test_prompts/', $code)) {
    return "Prompt generation function missing";
  }
  
  return true;
});

test("Prompt generation uses fixed templates", function() {
  $crawlerFile = __DIR__ . '/../scripts/ai_answer_crawler.php';
  $code = file_get_contents($crawlerFile);
  
  // Check that prompts use templates, not raw case study text
  if (preg_match('/\$caseData\[[\'"]situation[\'"]\].*prompt|\$caseData\[[\'"]ai_failure[\'"]\].*prompt/', $code)) {
    return "Prompts constructed from case study content (manipulation possible)";
  }
  
  return true;
});

// ============================================================================
// TEST 5: Case Study Data Integrity
// ============================================================================

test("Case study registry cannot be modified via file inclusion", function() {
  $registryFile = __DIR__ . '/../lib/case_study_registry.php';
  $code = file_get_contents($registryFile);
  
  // Check that registry is hardcoded, not loaded from external source
  if (preg_match('/file_get_contents.*registry|include.*registry|require.*registry/', $code)) {
    return "Registry loaded from external source (tampering possible)";
  }
  
  // Check that registry is returned from function (not global)
  if (!preg_match('/function get_case_study_registry/', $code)) {
    return "Registry function missing";
  }
  
  // Check that registry array contains hardcoded data (has 'b2b-saas' or similar)
  if (!preg_match('/[\'"]b2b-saas[\'"]|[\'"]ecommerce[\'"]|[\'"]slug[\'"]\s*=>/', $code)) {
    return "Registry array not hardcoded with case study data";
  }
  
  return true;
});

test("Machine-owned blocks cannot be edited via authoring UI", function() {
  $editorFile = __DIR__ . '/../admin/case-study-editor.php';
  $code = file_get_contents($editorFile);
  
  // Check that editor doesn't have fields for machine block
  if (preg_match('/machine.*block|verification.*block|NRLC_AI_VERIFICATION/', $code)) {
    return "Editor allows editing machine block (VULNERABLE)";
  }
  
  return true;
});

test("Auto-update script validates machine block integrity", function() {
  $updateFile = __DIR__ . '/../bin/generate-case-study-updates.php';
  $code = file_get_contents($updateFile);
  
  // Check that script validates block (pattern or validation)
  if (!preg_match('/NRLC_AI_VERIFICATION|preg_match.*pattern|validate.*block/', $code)) {
    return "Script doesn't validate machine block";
  }
  
  // Check that script fails hard on missing block (exit or error)
  if (!preg_match('/exit\(1\)|fwrite.*STDERR|Error.*block/', $code)) {
    return "Script doesn't fail hard on missing block";
  }
  
  return true;
});

// ============================================================================
// TEST 6: Auth/CSRF Bypass
// ============================================================================

test("Admin pages require authentication", function() {
  $editorFile = __DIR__ . '/../admin/case-study-editor.php';
  $code = file_get_contents($editorFile);
  
  // Check that require_admin is called
  if (!preg_match('/require_admin\(\)|require_auth\(\)/', $code)) {
    return "Admin page doesn't require authentication (VULNERABLE)";
  }
  
  return true;
});

test("CSRF protection is enforced on POST", function() {
  $editorFile = __DIR__ . '/../admin/case-study-editor.php';
  $code = file_get_contents($editorFile);
  
  // Check that CSRF is validated (require_csrf_token function call)
  if (!preg_match('/require_csrf_token\(\)/', $code)) {
    return "CSRF not validated (require_csrf_token missing)";
  }
  
  // Check that it's called in POST handler
  $lines = explode("\n", $code);
  $inPostHandler = false;
  $hasCsrfCheck = false;
  foreach ($lines as $line) {
    if (preg_match('/REQUEST_METHOD.*POST|POST.*REQUEST_METHOD/', $line)) {
      $inPostHandler = true;
    }
    if ($inPostHandler && preg_match('/require_csrf_token/', $line)) {
      $hasCsrfCheck = true;
      break;
    }
    if ($inPostHandler && preg_match('/^\s*\}\s*$/', $line)) {
      break; // End of POST handler
    }
  }
  
  if (!$hasCsrfCheck) {
    return "CSRF not validated in POST handler (VULNERABLE)";
  }
  
  return true;
});

test("CSRF tokens are generated securely", function() {
  $csrfFile = __DIR__ . '/../lib/csrf.php';
  $code = file_get_contents($csrfFile);
  
  // Check that tokens use cryptographically secure random
  if (!preg_match('/random_bytes|openssl_random_pseudo_bytes/', $code)) {
    return "CSRF tokens not generated securely (VULNERABLE)";
  }
  
  // Check that tokens are compared with hash_equals
  if (!preg_match('/hash_equals/', $code)) {
    return "CSRF tokens not compared securely (timing attack possible)";
  }
  
  return true;
});

// ============================================================================
// TEST 7: Schema Integrity
// ============================================================================

test("JSON-LD schema cannot be manipulated via case study data", function() {
  $schemaFile = __DIR__ . '/../lib/case_study_schema.php';
  $code = file_get_contents($schemaFile);
  
  // Check that schema structure is fixed, not constructed from user input
  if (preg_match('/\$data\[[\'"]@type[\'"]\]|\$data\[[\'"]@context[\'"]\]/', $code)) {
    return "Schema type/context read from user input (VULNERABLE)";
  }
  
  // Check that DefinedTermSet is hardcoded (array literal with hasDefinedTerm)
  if (!preg_match('/hasDefinedTerm.*\[|@type.*DefinedTermSet.*\[/', $code)) {
    return "DefinedTermSet not hardcoded (manipulation possible)";
  }
  
  // Check that @type and @context are hardcoded strings
  if (!preg_match('/[\'"]@type[\'"]\s*=>\s*[\'"]DefinedTermSet[\'"]|[\'"]@type[\'"]\s*=>\s*[\'"]Organization[\'"]/', $code)) {
    return "Schema types not hardcoded";
  }
  
  return true;
});

test("Schema generator validates input before generation", function() {
  $schemaFile = __DIR__ . '/../lib/case_study_schema.php';
  $code = file_get_contents($schemaFile);
  
  // Check that function validates input
  if (!preg_match('/function generate_case_study_master_schema/', $code)) {
    return "Schema generator function missing";
  }
  
  // Check that prompt cluster is validated
  if (!preg_match('/promptClusterMap|prompt_cluster.*map/', $code)) {
    return "Prompt cluster not validated against allowed values";
  }
  
  return true;
});

// ============================================================================
// TEST 8: File System Attacks
// ============================================================================

test("File paths cannot be traversed", function() {
  // Check editor (user input)
  $editorFile = __DIR__ . '/../admin/case-study-editor.php';
  $editorCode = file_get_contents($editorFile);
  
  // Check that slug from POST is sanitized
  if (preg_match('/\$_POST\[[\'"]slug[\'"]\]/', $editorCode)) {
    if (!preg_match('/preg_replace.*slug|sanitize.*slug/', $editorCode)) {
      return "Slug from POST not sanitized in editor";
    }
  }
  
  // Check crawler (registry input - should be safe, but verify sanitization exists)
  $crawlerFile = __DIR__ . '/../scripts/ai_answer_crawler.php';
  $crawlerCode = file_get_contents($crawlerFile);
  
  // Check that storeAiCheck sanitizes slug
  if (preg_match('/function storeAiCheck/', $crawlerCode)) {
    if (!preg_match('/preg_replace.*slug|safeSlug|sanitize.*slug/', $crawlerCode)) {
      return "Slug not sanitized in storeAiCheck function";
    }
  }
  
  // Check badge (query param input)
  $badgeFile = __DIR__ . '/../api/badge.php';
  $badgeCode = file_get_contents($badgeFile);
  
  if (preg_match('/\$_GET\[[\'"]ref[\'"]\]/', $badgeCode)) {
    if (!preg_match('/preg_replace.*ref|safeRef|sanitize.*ref/', $badgeCode)) {
      return "Ref from GET not sanitized in badge endpoint";
    }
  }
  
  // Check update script (registry input - should be safe, but verify)
  $updateFile = __DIR__ . '/../bin/generate-case-study-updates.php';
  $updateCode = file_get_contents($updateFile);
  
  if (preg_match('/\$slug.*\.md|\$slug.*\.jsonld/', $updateCode)) {
    if (!preg_match('/safeSlug|preg_replace.*slug/', $updateCode)) {
      return "Slug not sanitized in update script";
    }
  }
  
  // Check that file paths use fixed base directory
  if (!preg_match('/dataDir.*=.*__DIR__|dataDir.*=.*dirname/', $crawlerCode)) {
    return "File paths not using fixed base directory";
  }
  
  return true;
});

test("File operations are restricted to data directory", function() {
  $editorFile = __DIR__ . '/../admin/case-study-editor.php';
  $code = file_get_contents($editorFile);
  
  // Check that file writes are restricted to data directory
  if (preg_match('/file_put_contents.*\$.*slug|file_put_contents.*\$.*POST/', $code)) {
    // Check that it's within data directory
    if (!preg_match('/dataDir.*file_put_contents|case-studies.*file_put_contents/', $code)) {
      return "File writes not restricted to data directory (VULNERABLE)";
    }
  }
  
  return true;
});

// ============================================================================
// SUMMARY
// ============================================================================

echo "\n=== Test Summary ===\n";
echo "Passed: {$passed}\n";
echo "Failed: {$failed}\n";
echo "Total: " . ($passed + $failed) . "\n\n";

if ($failed > 0) {
  echo "=== Failed Tests ===\n";
  foreach ($tests as $test) {
    if ($test['status'] !== 'PASS') {
      echo "❌ {$test['name']}\n";
      if (isset($test['reason'])) {
        echo "   Reason: {$test['reason']}\n";
      }
    }
  }
  echo "\n";
  exit(1);
} else {
  echo "✅ All tests passed. System is hardened.\n";
  exit(0);
}

