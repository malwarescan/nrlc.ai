#!/usr/bin/env php
<?php
/**
 * Content Chunking Validator CLI
 * 
 * Validates content files against SUDO_META_DIRECTIVE_CONTENT_CHUNKING.md rules
 * 
 * NOTE: This validates CHUNKING (UX/readability), not PRECHUNKING (retrieval/citation)
 * 
 * Usage:
 *   php scripts/validate_content_chunking.php [file_path|directory]
 * 
 * Examples:
 *   php scripts/validate_content_chunking.php pages/services/index.php
 *   php scripts/validate_content_chunking.php pages/
 *   php scripts/validate_content_chunking.php  # Validates all .php files in pages/
 */

require_once __DIR__ . '/../lib/content_chunking_validator.php';

$validator = new ContentChunkingValidator();

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

echo "Validating " . count($files) . " file(s) against content chunking standards...\n";
echo "(This validates UX/readability chunking, not prechunking)\n\n";

$results = [];
$totalErrors = 0;
$totalWarnings = 0;
$passed = 0;
$needsImprovement = 0;

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
  
  if ($result['valid'] && empty($result['warnings'])) {
    $passed++;
  } else {
    $needsImprovement++;
  }
  
  $totalErrors += count($result['errors']);
  $totalWarnings += count($result['warnings']);
  
  // Show results for files with issues
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
echo "⚠️  Needs Improvement: {$needsImprovement}\n";
echo "Total errors: {$totalErrors}\n";
echo "Total warnings: {$totalWarnings}\n";
echo "\n";

if ($needsImprovement > 0) {
  echo "⚠️  Some content needs improvement for better chunking.\n";
  echo "Improve scannability and UX by addressing the issues above.\n";
  exit(0); // Exit 0 because chunking issues are warnings, not blockers
} else {
  echo "✅ All files pass content chunking validation.\n";
  exit(0);
}

