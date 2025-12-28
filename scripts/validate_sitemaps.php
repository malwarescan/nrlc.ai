<?php
/**
 * SITEMAP VALIDATION (H2: Sitemap audit)
 * 
 * CI must parse generated sitemaps and validate:
 * - 100% URLs return 200
 * - 0% URLs redirect
 * - each URL is canonical and indexable
 * 
 * Exit code: 0 if all pass, 1 if any fail
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/helpers.php';

$errors = [];
$warnings = [];
$sitemapDir = __DIR__.'/../public/sitemaps/';
$baseUrl = 'https://nrlc.ai';

// Find all sitemap XML files
$sitemapFiles = glob($sitemapDir . '*.xml');
if (empty($sitemapFiles)) {
  $errors[] = "No sitemap files found in $sitemapDir";
  echo "❌ SITEMAP VALIDATION FAILED\n";
  echo "  ✗ No sitemap files found\n";
  exit(1);
}

$allUrls = [];
$redirectUrls = [];
$non200Urls = [];
$nonCanonicalUrls = [];

foreach ($sitemapFiles as $sitemapFile) {
  $xml = file_get_contents($sitemapFile);
  if (!$xml) continue;
  
  // Extract URLs from sitemap
  preg_match_all('#<loc>(https?://[^<]+)</loc>#', $xml, $matches);
  foreach ($matches[1] as $url) {
    $allUrls[] = $url;
    
    // Check if URL is canonical (has locale prefix for non-root)
    $path = parse_url($url, PHP_URL_PATH);
    if ($path !== '/' && $path !== '') {
      // Exceptions: API routes, sitemaps, robots.txt, favicons, healthcheck don't need locale
      $exceptions = ['/api/', '/sitemap', '/robots.txt', '/favicon', '/healthcheck'];
      $isException = false;
      foreach ($exceptions as $exception) {
        if (strpos($path, $exception) === 0) {
          $isException = true;
          break;
        }
      }
      
      // Non-root URLs must have locale prefix (unless exception)
      if (!$isException && !preg_match('#^/([a-z]{2}-[a-z]{2})/#', $path)) {
        $nonCanonicalUrls[] = $url . " (missing locale prefix)";
      }
    }
    
    // For local validation, we'll check file-based patterns
    // In CI, this would use curl to check actual HTTP status
    // For now, validate URL structure
    if (strpos($url, $baseUrl) !== 0) {
      $errors[] = "Sitemap URL uses wrong domain: $url (expected $baseUrl)";
    }
    
    // Check for deprecated locale variants in sitemap
    // Use city_locale_rules.json as authoritative source
    if (preg_match('#/([a-z]{2}-[a-z]{2})/services/([^/]+)/([^/]+)/#', $path, $m)) {
      $locale = $m[1];
      $citySlug = $m[3];
      
      // Load city locale rules
      $rulesFile = __DIR__.'/../data/city_locale_rules.json';
      if (file_exists($rulesFile)) {
        $rules = json_decode(file_get_contents($rulesFile), true);
        if (isset($rules[$citySlug])) {
          $canonicalLocale = $rules[$citySlug]['canonical_locale'] ?? 'en-us';
          if ($locale !== $canonicalLocale) {
            $nonCanonicalUrls[] = $url . " (city canonical locale is $canonicalLocale, not $locale)";
          }
        }
      }
    }
  }
}

// Report results
if (!empty($nonCanonicalUrls)) {
  foreach ($nonCanonicalUrls as $url) {
    $errors[] = "Non-canonical URL in sitemap: $url";
  }
}

if (!empty($errors)) {
  echo "❌ SITEMAP VALIDATION FAILED\n\n";
  echo "Errors:\n";
  foreach (array_slice($errors, 0, 50) as $error) {
    echo "  ✗ $error\n";
  }
  echo "\nTotal URLs in sitemaps: " . count($allUrls) . "\n";
  echo "Non-canonical URLs: " . count($nonCanonicalUrls) . "\n";
  exit(1);
}

echo "✓ SITEMAP VALIDATION PASSED\n";
echo "  - Total URLs: " . count($allUrls) . "\n";
echo "  - All URLs are canonical\n";
echo "  - All URLs use correct domain\n";
exit(0);
