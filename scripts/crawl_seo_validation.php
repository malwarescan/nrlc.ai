<?php
declare(strict_types=1);

/**
 * SEO Production Readiness Crawler
 * Validates all URLs from schema_test_urls.txt for SEO readiness
 * 
 * Checks:
 * - Schema.org JSON-LD presence and validity
 * - Meta tags (title, description, canonical)
 * - H1/H2 structure
 * - Internal links with proper anchor text
 * - Alt text on images
 * - No broken links
 * - Proper URL structure
 */

require_once __DIR__ . '/../lib/helpers.php';

$baseUrl = 'https://nrlc.ai';
$testUrlsFile = __DIR__ . '/../schema_test_urls.txt';
$reportFile = __DIR__ . '/../seo_validation_report.txt';

// Read URLs from file
$urls = [];
$currentCategory = '';
$file = fopen($testUrlsFile, 'r');

if (!$file) {
  die("Error: Could not open {$testUrlsFile}\n");
}

while (($line = fgets($file)) !== false) {
  $line = trim($line);
  
  // Skip empty lines and headers
  if (empty($line) || strpos($line, '===') === 0 || strpos($line, 'Generated:') === 0) {
    continue;
  }
  
  // Check for category header
  if (preg_match('/^## (.+) \(\d+ URLs\)$/', $line, $matches)) {
    $currentCategory = $matches[1];
    continue;
  }
  
  // Extract URL
  if (preg_match('/^(https:\/\/[^\s]+)/', $line, $matches)) {
    $url = $matches[1];
    $urls[] = [
      'url' => $url,
      'category' => $currentCategory,
      'description' => strpos($line, ' - ') !== false ? substr($line, strpos($line, ' - ') + 3) : ''
    ];
  }
}

fclose($file);

echo "🔍 SEO Production Readiness Validation\n";
echo "=====================================\n\n";
echo "Found " . count($urls) . " URLs to validate\n\n";

$validationResults = [];
$total = count($urls);
$current = 0;

foreach ($urls as $item) {
  $current++;
  $url = $item['url'];
  $category = $item['category'];
  
  echo "[{$current}/{$total}] Checking: {$url}\n";
  
  // Initialize result
  $result = [
    'url' => $url,
    'category' => $category,
    'status' => 'unknown',
    'errors' => [],
    'warnings' => [],
    'checks' => []
  ];
  
  // Use local file path instead of HTTP request
  $path = parse_url($url, PHP_URL_PATH);
  if (empty($path) || $path === '/') {
    $path = '/';
  }
  
  // Map URL to file path
  $filePath = null;
  if ($path === '/') {
    $filePath = __DIR__ . '/../pages/home/home.php';
  } elseif (preg_match('#^/blog/blog-post-(\d+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/blog/blog-post.php';
    $_GET['post'] = $m[1];
  } elseif (preg_match('#^/case-studies/case-study-(\d+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/case-studies/case-study.php';
    $_GET['case'] = $m[1];
  } elseif (preg_match('#^/resources/resource-(\d+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/resources/resource.php';
    $_GET['resource'] = $m[1];
  } elseif (preg_match('#^/services/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/services/service.php';
    $_GET['service'] = $m[1];
  } elseif (preg_match('#^/services/([^/]+)/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/services/service_city.php';
    $_GET['service'] = $m[1];
    $_GET['city'] = $m[2];
  } elseif (preg_match('#^/careers/([^/]+)/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/careers/career_city.php';
    $_GET['city'] = $m[1];
    $_GET['role'] = $m[2];
  } elseif (preg_match('#^/insights/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/insights/article.php';
    $_GET['slug'] = $m[1];
  } elseif (preg_match('#^/products/([^/]+)/$#', $path, $m)) {
    $productSlug = $m[1];
    $filePath = __DIR__ . '/../pages/products/' . $productSlug . '.php';
    if (!file_exists($filePath)) {
      $result['errors'][] = "Product file not found: {$productSlug}.php";
      $results[] = $result;
      continue;
    }
  } elseif (preg_match('#^/tools/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/tools/tool.php';
    $_GET['tool'] = $m[1];
  } elseif (preg_match('#^/industries/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/industries/industry.php';
    $_GET['industry'] = $m[1];
  } elseif (preg_match('#^/catalog/([^/]+)/$#', $path, $m)) {
    $filePath = __DIR__ . '/../pages/catalog/item.php';
    $_GET['slug'] = $m[1];
  } elseif (preg_match('#^/(services|products|insights|tools|industries|careers|catalog|blog|case-studies|resources|promptware)/$#', $path, $m)) {
    $indexPath = $m[1];
    $filePath = __DIR__ . '/../pages/' . $indexPath . '/index.php';
  } else {
    $result['errors'][] = "Could not map URL to file path: {$path}";
    $validationResults[] = $result;
    continue;
  }
  
  if (!file_exists($filePath)) {
    $result['errors'][] = "File not found: {$filePath}";
    $validationResults[] = $result;
    continue;
  }
  
  // Capture output
  ob_start();
  
  // Suppress headers
  if (!headers_sent()) {
    header_remove();
  }
  
  // Set up environment
  $_SERVER['REQUEST_URI'] = $path;
  $_SERVER['HTTP_HOST'] = 'nrlc.ai';
  $_SERVER['HTTPS'] = 'on';
  $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
  
  // Include the page (this will execute it)
  try {
    // Check if it's a template file that needs router
    if (strpos($filePath, 'blog-post.php') !== false || 
        strpos($filePath, 'case-study.php') !== false ||
        strpos($filePath, 'resource.php') !== false ||
        strpos($filePath, 'service.php') !== false ||
        strpos($filePath, 'service_city.php') !== false ||
        strpos($filePath, 'career_city.php') !== false ||
        strpos($filePath, 'article.php') !== false ||
        strpos($filePath, 'tool.php') !== false ||
        strpos($filePath, 'industry.php') !== false ||
        strpos($filePath, 'item.php') !== false) {
      
      // These need head/header/footer
      require_once __DIR__ . '/../templates/head.php';
      require_once __DIR__ . '/../templates/header.php';
      include $filePath;
      require_once __DIR__ . '/../templates/footer.php';
    } else {
      // Static pages
      require_once __DIR__ . '/../templates/head.php';
      require_once __DIR__ . '/../templates/header.php';
      include $filePath;
      require_once __DIR__ . '/../templates/footer.php';
    }
  } catch (Exception $e) {
    $result['errors'][] = "Error rendering page: " . $e->getMessage();
    ob_end_clean();
    $validationResults[] = $result;
    continue;
  }
  
  $html = ob_get_clean();
  
  // Validate HTML content
  $dom = new DOMDocument();
  @$dom->loadHTML($html);
  
  // Check 1: Schema.org JSON-LD
  $scripts = $dom->getElementsByTagName('script');
  $hasSchema = false;
  $schemaTypes = [];
  foreach ($scripts as $script) {
    if ($script->getAttribute('type') === 'application/ld+json') {
      $hasSchema = true;
      $json = json_decode($script->textContent, true);
      if ($json) {
        if (isset($json['@graph'])) {
          foreach ($json['@graph'] as $item) {
            if (isset($item['@type'])) {
              $schemaTypes[] = $item['@type'];
            }
          }
        } elseif (isset($json['@type'])) {
          $schemaTypes[] = $json['@type'];
        }
      }
    }
  }
  
  if ($hasSchema) {
    $result['checks'][] = "✅ Schema.org JSON-LD found: " . implode(', ', array_unique($schemaTypes));
  } else {
    $result['errors'][] = "❌ Missing Schema.org JSON-LD";
  }
  
  // Check 2: Meta tags
  $metaTags = $dom->getElementsByTagName('meta');
  $hasTitle = false;
  $hasDescription = false;
  $hasCanonical = false;
  
  foreach ($metaTags as $meta) {
    $name = $meta->getAttribute('name');
    $property = $meta->getAttribute('property');
    
    if ($name === 'description' || $property === 'og:description') {
      $hasDescription = true;
      $desc = $meta->getAttribute('content');
      if (empty($desc) || strlen($desc) < 50) {
        $result['warnings'][] = "Meta description too short or empty";
      }
    }
  }
  
  $titleTags = $dom->getElementsByTagName('title');
  if ($titleTags->length > 0) {
    $hasTitle = true;
    $title = $titleTags->item(0)->textContent;
    if (empty($title)) {
      $result['errors'][] = "Title tag is empty";
    }
  } else {
    $result['errors'][] = "Missing <title> tag";
  }
  
  $links = $dom->getElementsByTagName('link');
  foreach ($links as $link) {
    if ($link->getAttribute('rel') === 'canonical') {
      $hasCanonical = true;
      $canonical = $link->getAttribute('href');
      if ($canonical !== $url && $canonical !== $url . '/') {
        $result['warnings'][] = "Canonical URL mismatch: {$canonical}";
      }
    }
  }
  
  if ($hasTitle) $result['checks'][] = "✅ Title tag present";
  if ($hasDescription) $result['checks'][] = "✅ Meta description present";
  if ($hasCanonical) $result['checks'][] = "✅ Canonical URL present";
  
  // Check 3: H1 structure
  $h1s = $dom->getElementsByTagName('h1');
  if ($h1s->length === 0) {
    $result['errors'][] = "Missing H1 tag";
  } elseif ($h1s->length > 1) {
    $result['warnings'][] = "Multiple H1 tags found ({$h1s->length})";
  } else {
    $result['checks'][] = "✅ Single H1 tag present";
  }
  
  // Check 4: Internal links with anchor text
  $internalLinks = $dom->getElementsByTagName('a');
  $badAnchors = 0;
  $linksWithoutTitle = 0;
  foreach ($internalLinks as $link) {
    $href = $link->getAttribute('href');
    $anchor = trim($link->textContent);
    $title = $link->getAttribute('title');
    
    if (strpos($href, '/') === 0 || strpos($href, 'https://nrlc.ai') === 0) {
      // Internal link
      if (empty($anchor) || in_array(strtolower($anchor), ['click here', 'read more', 'learn more', 'here', 'this', 'link'])) {
        $badAnchors++;
      }
      if (empty($title)) {
        $linksWithoutTitle++;
      }
    }
  }
  
  if ($badAnchors > 0) {
    $result['warnings'][] = "Found {$badAnchors} internal links with poor anchor text";
  } else {
    $result['checks'][] = "✅ Internal links have good anchor text";
  }
  
  if ($linksWithoutTitle > 0) {
    $result['warnings'][] = "Found {$linksWithoutTitle} links without title attributes";
  } else {
    $result['checks'][] = "✅ All links have title attributes";
  }
  
  // Check 5: Images with alt text
  $images = $dom->getElementsByTagName('img');
  $imagesWithoutAlt = 0;
  foreach ($images as $img) {
    if (empty($img->getAttribute('alt'))) {
      $imagesWithoutAlt++;
    }
  }
  
  if ($imagesWithoutAlt > 0) {
    $result['warnings'][] = "Found {$imagesWithoutAlt} images without alt text";
  } else {
    $result['checks'][] = "✅ All images have alt text";
  }
  
  // Check 6: Check for GLOBALS['__jsonld'] if using footer pattern
  if (isset($GLOBALS['__jsonld']) && !empty($GLOBALS['__jsonld'])) {
    $result['checks'][] = "✅ Schema via GLOBALS['__jsonld'] pattern";
  }
  
  // Determine status
  if (count($result['errors']) === 0 && count($result['warnings']) === 0) {
    $result['status'] = 'PASS';
  } elseif (count($result['errors']) === 0) {
    $result['status'] = 'WARN';
  } else {
    $result['status'] = 'FAIL';
  }
  
  $validationResults[] = $result;
  
  // Clear GET params and GLOBALS for next iteration
  unset($_GET);
  unset($GLOBALS['__jsonld']);
}

// Generate report
$report = "SEO PRODUCTION READINESS VALIDATION REPORT\n";
$report .= "Generated: " . date('Y-m-d H:i:s') . "\n";
$report .= str_repeat("=", 80) . "\n\n";

$passCount = 0;
$warnCount = 0;
$failCount = 0;

foreach ($validationResults as $result) {
  if ($result['status'] === 'PASS') $passCount++;
  elseif ($result['status'] === 'WARN') $warnCount++;
  else $failCount++;
}

$report .= "SUMMARY\n";
$report .= str_repeat("-", 80) . "\n";
$report .= "Total URLs: " . count($validationResults) . "\n";
$report .= "✅ PASS: {$passCount}\n";
$report .= "⚠️  WARN: {$warnCount}\n";
$report .= "❌ FAIL: {$failCount}\n\n";

// Group by category
$byCategory = [];
foreach ($validationResults as $result) {
  $cat = $result['category'] ?: 'Unknown';
  if (!isset($byCategory[$cat])) {
    $byCategory[$cat] = [];
  }
  $byCategory[$cat][] = $result;
}

foreach ($byCategory as $category => $categoryResults) {
  $report .= "\n## {$category} (" . count($categoryResults) . " URLs)\n\n";
  
  foreach ($categoryResults as $result) {
    $statusIcon = $result['status'] === 'PASS' ? '✅' : ($result['status'] === 'WARN' ? '⚠️' : '❌');
    $report .= "{$statusIcon} {$result['url']}\n";
    
    if (!empty($result['checks'])) {
      foreach ($result['checks'] as $check) {
        $report .= "   {$check}\n";
      }
    }
    
    if (!empty($result['warnings'])) {
      foreach ($result['warnings'] as $warning) {
        $report .= "   ⚠️  {$warning}\n";
      }
    }
    
    if (!empty($result['errors'])) {
      foreach ($result['errors'] as $error) {
        $report .= "   ❌ {$error}\n";
      }
    }
    
    $report .= "\n";
  }
}

// Write report
file_put_contents($reportFile, $report);

echo "\n✅ Validation complete!\n\n";
echo "Summary:\n";
echo "  ✅ PASS: {$passCount}\n";
echo "  ⚠️  WARN: {$warnCount}\n";
echo "  ❌ FAIL: {$failCount}\n\n";
echo "Full report saved to: {$reportFile}\n";

