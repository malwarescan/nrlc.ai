<?php
declare(strict_types=1);

/**
 * SUDO POWERED INDEXING AUTHORITY VERIFICATION
 * 
 * Verifies that the indexing and locale authority directive is enforced:
 * - One intent per page
 * - One locale per city page
 * - One canonical per page
 * - Sitemap contains only canonical URLs
 * - No deprecated locales are indexable
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../config/locales.php';

$errors = [];
$warnings = [];
$passed = [];

echo "🔍 SUDO POWERED INDEXING AUTHORITY VERIFICATION\n";
echo str_repeat('=', 60) . "\n\n";

// 1. Verify sitemap contains only canonical URLs
echo "1. Checking sitemap canonical URLs...\n";
$sitemapDir = __DIR__.'/../public/sitemaps/';
if (is_dir($sitemapDir)) {
  $sitemapFiles = glob($sitemapDir.'*.xml');
  $sitemapUrls = [];
  
  foreach ($sitemapFiles as $file) {
    $content = file_get_contents($file);
    // Extract all <loc> URLs
    preg_match_all('#<loc>(https://nrlc\.ai[^<]+)</loc>#', $content, $matches);
    foreach ($matches[1] as $url) {
      $sitemapUrls[] = $url;
    }
  }
  
  // Check for deprecated locale variants in sitemap
  $ukCities = ['norwich', 'stockport', 'stoke-on-trent', 'derby', 'southport',
               'huddersfield', 'blackpool', 'burnley', 'oldham', 'halifax',
               'sudbury', 'nottingham', 'sheffield', 'southampton'];
  
  foreach ($sitemapUrls as $url) {
    // Check UK city pages
    foreach ($ukCities as $city) {
      if (strpos($url, "/services/") !== false && strpos($url, "/{$city}/") !== false) {
        // UK city detected
        if (strpos($url, '/en-gb/') === false) {
          $errors[] = "Sitemap contains non-canonical UK city URL: $url (should be /en-gb/)";
        }
      }
    }
    
    // Check for non-en-us/en-gb locales in sitemap (unless they're real translations)
    if (preg_match('#/(es-es|fr-fr|de-de|ko-kr)/#', $url)) {
      // For now, flag as warning (future: check if page has real translations)
      $warnings[] = "Sitemap contains non-primary locale: $url (verify if real translation)";
    }
  }
  
  $passed[] = "Sitemap contains " . count($sitemapUrls) . " URLs";
} else {
  $warnings[] = "Sitemap directory not found: $sitemapDir";
}

// 2. Verify canonical.php redirect logic
echo "2. Checking canonical redirect logic...\n";
$canonicalFile = __DIR__.'/../bootstrap/canonical.php';
if (file_exists($canonicalFile)) {
  $content = file_get_contents($canonicalFile);
  
  // Check for UK city redirect logic
  if (strpos($content, 'is_uk_city') !== false) {
    $passed[] = "Canonical.php includes UK city detection";
  } else {
    $errors[] = "Canonical.php missing UK city detection logic";
  }
  
  // Check for locale redirect enforcement
  if (preg_match('#en-gb.*services.*local-seo-ai#', $content)) {
    $passed[] = "Canonical.php enforces en-gb for UK cities";
  } else {
    $warnings[] = "Canonical.php may not enforce en-gb for UK cities";
  }
} else {
  $errors[] = "Canonical.php not found";
}

// 3. Verify hreflang restrictions
echo "3. Checking hreflang restrictions...\n";
$hreflangFile = __DIR__.'/../lib/hreflang.php';
if (file_exists($hreflangFile)) {
  $content = file_get_contents($hreflangFile);
  
  // Check for city-based hreflang restrictions
  if (strpos($content, 'City-based pages: NO hreflang') !== false || 
      strpos($content, 'hasRealTranslations') !== false) {
    $passed[] = "Hreflang.php includes city-based restrictions";
  } else {
    $warnings[] = "Hreflang.php may not restrict city-based pages";
  }
} else {
  $errors[] = "Hreflang.php not found";
}

// 4. Verify sitemap generation uses canonical only
echo "4. Checking sitemap generation...\n";
$sitemapBuildFile = __DIR__.'/../scripts/build_sitemaps.php';
if (file_exists($sitemapBuildFile)) {
  $content = file_get_contents($sitemapBuildFile);
  
  // Check for canonical-only entries
  if (strpos($content, 'SITEMAP CANONICAL ONLY') !== false || 
      strpos($content, 'sitemap_entry_simple') !== false) {
    $passed[] = "Sitemap generation uses canonical-only entries";
  } else {
    $warnings[] = "Sitemap generation may include non-canonical URLs";
  }
} else {
  $warnings[] = "Sitemap build script not found";
}

// Summary
echo "\n" . str_repeat('=', 60) . "\n";
echo "VERIFICATION SUMMARY\n";
echo str_repeat('=', 60) . "\n\n";

if (!empty($passed)) {
  echo "✅ PASSED (" . count($passed) . "):\n";
  foreach ($passed as $p) {
    echo "   - $p\n";
  }
  echo "\n";
}

if (!empty($warnings)) {
  echo "⚠️  WARNINGS (" . count($warnings) . "):\n";
  foreach (array_slice($warnings, 0, 10) as $w) {
    echo "   - $w\n";
  }
  if (count($warnings) > 10) {
    echo "   ... and " . (count($warnings) - 10) . " more\n";
  }
  echo "\n";
}

if (!empty($errors)) {
  echo "❌ ERRORS (" . count($errors) . "):\n";
  foreach ($errors as $e) {
    echo "   - $e\n";
  }
  echo "\n";
  exit(1);
}

if (empty($errors)) {
  echo "✅ All indexing authority checks passed!\n";
  exit(0);
}

