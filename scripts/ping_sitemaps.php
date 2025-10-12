<?php
declare(strict_types=1);

/**
 * Ping search engines with sitemap index URL
 */

$indexUrl = "https://nrlc.ai/sitemaps/sitemap-index.xml.gz";
$engines = [
  'google' => 'https://www.google.com/ping?sitemap=' . urlencode($indexUrl),
  'bing' => 'https://www.bing.com/ping?sitemap=' . urlencode($indexUrl)
];

$success = 0;
$total = count($engines);

echo "Pinging sitemap index: $indexUrl\n\n";

foreach ($engines as $name => $pingUrl) {
  echo "Pinging $name... ";
  
  $context = stream_context_create([
    'http' => [
      'method' => 'GET',
      'timeout' => 30,
      'user_agent' => 'NRLC.ai Sitemap Ping Bot/1.0'
    ]
  ]);
  
  $result = @file_get_contents($pingUrl, false, $context);
  
  if ($result !== false) {
    echo "OK\n";
    $success++;
  } else {
    echo "FAIL\n";
  }
}

echo "\nSummary: $success/$total engines pinged successfully\n";

// Optional: Log ping results
$logFile = __DIR__ . '/../logs/sitemap_pings.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) {
  mkdir($logDir, 0755, true);
}

$logEntry = date('Y-m-d H:i:s') . " - Pinged $success/$total engines\n";
file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

exit($success === $total ? 0 : 1);