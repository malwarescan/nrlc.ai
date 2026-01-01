<?php
/**
 * Quick status check for QA script
 */

$resultsFile = __DIR__ . '/../docs/search_console_qa_results.csv';
$logFile = '/tmp/qa_full_output.log';

echo "=== QA Script Status ===\n\n";

// Check if script is running
$running = false;
exec("ps aux | grep 'qa_all_search_console_urls.php' | grep -v grep", $output);
if (!empty($output)) {
  $running = true;
  echo "✅ Script is RUNNING\n";
} else {
  echo "⏸️  Script is NOT running\n";
}

echo "\n";

// Check results file
if (file_exists($resultsFile)) {
  $lines = count(file($resultsFile));
  $processed = $lines - 1; // Subtract header
  
  echo "📊 Results File Status:\n";
  echo "   URLs processed: $processed/1000\n";
  echo "   Progress: " . round(($processed / 1000) * 100, 1) . "%\n";
  
  if ($processed >= 1000) {
    echo "\n✅ QA COMPLETE! All 1000 URLs processed.\n\n";
    
    // Show summary
    $passed = 0;
    $failed = 0;
    $handle = fopen($resultsFile, 'r');
    if ($handle) {
      fgetcsv($handle); // Skip header
      while (($row = fgetcsv($handle)) !== false) {
        if (isset($row[20])) {
          if ($row[20] === 'PASS') $passed++;
          if ($row[20] === 'FAIL') $failed++;
        }
      }
      fclose($handle);
    }
    
    echo "📈 Summary:\n";
    echo "   ✅ Passed: $passed\n";
    echo "   ❌ Failed: $failed\n";
    echo "   📄 Results: $resultsFile\n";
    
    // Show top issues
    echo "\n🔍 Top Issues:\n";
    $issueCounts = [];
    $handle = fopen($resultsFile, 'r');
    if ($handle) {
      fgetcsv($handle); // Skip header
      while (($row = fgetcsv($handle)) !== false) {
        if (isset($row[21]) && !empty($row[21])) {
          $issues = explode('; ', $row[21]);
          foreach ($issues as $issue) {
            $issueType = explode(':', $issue)[0];
            $issueCounts[$issueType] = ($issueCounts[$issueType] ?? 0) + 1;
          }
        }
      }
      fclose($handle);
    }
    
    arsort($issueCounts);
    $top = 0;
    foreach ($issueCounts as $issue => $count) {
      if ($top < 10) {
        echo "   $issue: $count occurrences\n";
        $top++;
      }
    }
    
  } else {
    $remaining = 1000 - $processed;
    $estimatedMinutes = round($remaining / 10);
    echo "\n⏳ Still processing...\n";
    echo "   Estimated time remaining: ~$estimatedMinutes minutes\n";
  }
} else {
  echo "❌ Results file not found\n";
  echo "   Script may still be initializing...\n";
}

// Check log file
if (file_exists($logFile)) {
  $logSize = filesize($logFile);
  echo "\n📝 Log file: $logFile (" . round($logSize / 1024, 1) . " KB)\n";
  
  // Show last few lines
  $lastLines = array_slice(file($logFile), -5);
  if (!empty($lastLines)) {
    echo "\n   Last log entries:\n";
    foreach ($lastLines as $line) {
      echo "   " . trim($line) . "\n";
    }
  }
}

echo "\n";

