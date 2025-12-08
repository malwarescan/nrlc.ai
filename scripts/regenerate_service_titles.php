<?php
/**
 * REGENERATE SERVICE TITLES
 * Applies SUDO kernel rules to all service titles in service_enhancements.json
 */

declare(strict_types=1);

require_once __DIR__.'/../lib/service_enhancements.php';

$enhancementsFile = __DIR__.'/../data/service_enhancements.json';
if (!file_exists($enhancementsFile)) {
  echo "❌ service_enhancements.json not found\n";
  exit(1);
}

$enhancements = json_decode(file_get_contents($enhancementsFile), true);
$fluffWords = ['welcome', 'home', 'discover', 'learn more', 'our services', 'click here', 'explore', 'transform', 'empower'];
$updated = 0;

/**
 * Generate unique title for service
 */
function generate_service_title(string $serviceSlug, string $citySlug = '', array $existingTitles = []): string {
  $serviceName = get_service_name_from_slug($serviceSlug);
  $cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : '';
  
  // Remove brand and fluff, focus on service + city
  $baseTitle = $serviceName;
  
  // Add city if present (local intent)
  if ($cityName) {
    $title = "$serviceName $cityName";
  } else {
    // For base service pages, add a clarifier
    $title = "$serviceName Services";
  }
  
  // Ensure 50-60 chars
  $len = strlen($title);
  if ($len < 50) {
    // Add specific clarifier based on service type
    if (strpos($serviceSlug, 'seo') !== false) {
      $title = "$serviceName Services for AI Search Optimization";
    } elseif (strpos($serviceSlug, 'optimization') !== false) {
      $title = "$serviceName Services for AI Visibility";
    } elseif (strpos($serviceSlug, 'structured') !== false || strpos($serviceSlug, 'schema') !== false) {
      $title = "$serviceName Services for Structured Data";
    } else {
      $title = "$serviceName Services for AI SEO";
    }
  }
  
  // Trim to 60 chars max
  if (strlen($title) > 60) {
    // Remove city if present and still too long
    if ($cityName && strlen($title) > 60) {
      $title = "$serviceName $cityName";
      if (strlen($title) > 60) {
        // Shorten service name
        $title = substr($serviceName, 0, 40) . " $cityName";
      }
    } else {
      $title = substr($title, 0, 57) . '...';
    }
  }
  
  // Check for duplicates
  foreach ($existingTitles as $existing) {
    $words1 = array_map('strtolower', explode(' ', $title));
    $words2 = array_map('strtolower', explode(' ', $existing));
    $common = count(array_intersect($words1, $words2));
    $total = count(array_unique(array_merge($words1, $words2)));
    $similarity = $total > 0 ? ($common / $total) : 0;
    
    if ($similarity > 0.2) {
      // Add unique modifier
      if ($cityName) {
        $title = "$serviceName in $cityName";
      } else {
        $title = "$serviceName Implementation Services";
      }
    }
  }
  
  // Final length check
  if (strlen($title) < 50) {
    $title .= " for AI SEO Optimization";
  }
  if (strlen($title) > 60) {
    $title = substr($title, 0, 57) . '...';
  }
  
  return $title;
}

// Collect existing titles for duplicate checking
$existingTitles = [];
foreach ($enhancements as $enhancement) {
  if (!empty($enhancement['title'])) {
    $existingTitles[] = $enhancement['title'];
  }
}

// Regenerate titles
foreach ($enhancements as &$enhancement) {
  $serviceSlug = $enhancement['service'] ?? '';
  $citySlug = $enhancement['city'] ?? '';
  $path = $enhancement['path'] ?? '';
  
  if (empty($serviceSlug)) continue;
  
  $newTitle = generate_service_title($serviceSlug, $citySlug, $existingTitles);
  $oldTitle = $enhancement['title'] ?? '';
  
  if ($newTitle !== $oldTitle) {
    $enhancement['title'] = $newTitle;
    $updated++;
    // Update existing titles array
    if ($oldTitle) {
      $key = array_search($oldTitle, $existingTitles);
      if ($key !== false) {
        unset($existingTitles[$key]);
      }
    }
    $existingTitles[] = $newTitle;
  }
}

// Save updated enhancements
file_put_contents($enhancementsFile, json_encode($enhancements, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "=== SERVICE TITLES REGENERATED ===\n\n";
echo "Total service URLs: " . count($enhancements) . "\n";
echo "Titles updated: $updated\n";
echo "Saved to: $enhancementsFile\n\n";

echo "Run: php scripts/audit_service_titles.php\n";
echo "to verify all titles now meet requirements.\n";

