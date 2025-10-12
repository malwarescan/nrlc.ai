<?php
declare(strict_types=1);

/**
 * Validate all sitemap files for proper XML structure and content
 */

$dir = __DIR__ . '/../public/sitemaps/';
$errors = 0;
$total = 0;

if (!is_dir($dir)) {
  echo "ERROR: Sitemaps directory not found: $dir\n";
  exit(1);
}

// Check all XML files (both .xml and .xml.gz)
$files = array_merge(
  glob("$dir/*.xml"),
  glob("$dir/*.xml.gz")
);

if (empty($files)) {
  echo "WARNING: No sitemap files found in $dir\n";
  exit(0);
}

foreach ($files as $file) {
  $total++;
  $basename = basename($file);
  echo "$basename: ";
  
  // Handle gzipped files
  if (str_ends_with($file, '.gz')) {
    $gz = gzopen($file, 'rb');
    if (!$gz) {
      echo "FAIL (cannot open gzip)\n";
      $errors++;
      continue;
    }
    
    $content = '';
    while (!gzeof($gz)) {
      $content .= gzread($gz, 8192);
    }
    gzclose($gz);
    
    if (empty($content)) {
      echo "FAIL (empty gzip content)\n";
      $errors++;
      continue;
    }
    
    $xml = @simplexml_load_string($content);
  } else {
    $xml = @simplexml_load_file($file);
  }
  
  if ($xml === false) {
    echo "FAIL (invalid XML)\n";
    $errors++;
    continue;
  }
  
  // Additional validation based on file type
  $isValid = true;
  $urlCount = 0;
  
  if (str_contains($basename, 'sitemap-index')) {
    // Validate sitemap index
    if (!isset($xml->sitemap)) {
      $isValid = false;
    } else {
      $urlCount = count($xml->sitemap);
    }
  } else {
    // Validate regular sitemap
    if (!isset($xml->url)) {
      $isValid = false;
    } else {
      $urlCount = count($xml->url);
    }
  }
  
  if (!$isValid) {
    echo "FAIL (invalid structure)\n";
    $errors++;
  } else {
    echo "OK ($urlCount entries)\n";
  }
}

// Check robots.txt
$robotsFile = __DIR__ . '/../public/robots.txt';
if (file_exists($robotsFile)) {
  $robotsContent = file_get_contents($robotsFile);
  $sitemapCount = substr_count($robotsContent, 'Sitemap:');
  echo "robots.txt: " . ($sitemapCount === 1 ? "OK ($sitemapCount Sitemap directive)" : "WARN ($sitemapCount Sitemap directives)") . "\n";
} else {
  echo "robots.txt: MISSING\n";
  $errors++;
}

echo "\nSummary: $total files checked, $errors errors\n";
exit($errors > 0 ? 1 : 0);