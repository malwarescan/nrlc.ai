#!/usr/bin/env php
<?php
/**
 * Prechunking Content Validator CLI
 * 
 * Validates content files against SUDO_META_DIRECTIVE_PRECHUNKING.md rules
 * 
 * Usage:
 *   php scripts/validate_prechunking.php [file_path|directory]
 * 
 * Examples:
 *   php scripts/validate_prechunking.php pages/services/index.php
 *   php scripts/validate_prechunking.php pages/
 *   php scripts/validate_prechunking.php  # Validates all .php files in pages/
 */

require_once __DIR__ . '/../lib/prechunking_validator.php';

$validator = new PrechunkingValidator();

// Get target from command line or default to pages/
$target = $argv[1] ?? __DIR__ . '/../pages/';
$target = realpath($target);

if (!$target) {
  echo "Error: Target not found: {$argv[1]}\n";
  exit(1);
}

$files = [];

if (is_file($target)) {
  $files[] = $target;
} elseif (is_dir($target)) {
  $iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS)
  );
  
  foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
      $files[] = $file->getPathname();
    }
  }
} else {
  echo "Error: Target is neither a file nor directory: {$target}\n";
  exit(1);
}

if (empty($files)) {
  echo "No PHP files found to validate.\n";
  exit(0);
}

echo "Validating " . count($files) . " file(s) against prechunking rules...\n\n";

$results = [];
$totalErrors = 0;
$totalWarnings = 0;
$passed = 0;
$failed = 0;

foreach ($files as $filePath) {
  // Read file content
  $content = file_get_contents($filePath);
  if ($content === false) {
    echo "Warning: Could not read file: {$filePath}\n";
    continue;
  }
  
  // Validate
  $result = $validator->validate($content, $filePath);
  $results[] = $result;
  
  if ($result['valid']) {
    $passed++;
  } else {
    $failed++;
  }
  
  $totalErrors += count($result['errors']);
  $totalWarnings += count($result['warnings']);
  
  // Show results for failed files
  if (!$result['valid'] || !empty($result['warnings'])) {
    echo $validator->getSummary($result);
    echo "\n" . str_repeat('-', 80) . "\n\n";
  }
}

// Summary
echo "\n";
echo "Validation Summary\n";
echo "==================\n";
echo "Files processed: " . count($files) . "\n";
echo "✅ Passed: {$passed}\n";
echo "❌ Failed: {$failed}\n";
echo "Total errors: {$totalErrors}\n";
echo "Total warnings: {$totalWarnings}\n";
echo "\n";

if ($failed > 0) {
  echo "❌ VALIDATION FAILED\n";
  echo "Content must pass all prechunking rules before publishing.\n";
  exit(1);
} else {
  echo "✅ All files pass prechunking validation.\n";
  exit(0);
}

