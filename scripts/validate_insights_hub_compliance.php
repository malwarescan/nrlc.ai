<?php
declare(strict_types=1);

/**
 * Validate Insights Hub Schema Compliance
 * 
 * Ensures /en-us/insights/ only includes allowed schemas:
 * - BreadcrumbList (with @id)
 * - Organization (reused, same @id as homepage)
 * - WebSite + SearchAction (reused)
 * 
 * FORBIDDEN on insights hub:
 * - Blog, Article, BlogPosting
 * - FAQPage
 * - Product, SoftwareApplication
 * - JobPosting
 * - Event, HowTo, Review, AggregateRating
 * - ItemList carousel
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';

// Simulate insights hub request
$_SERVER['REQUEST_URI'] = '/en-us/insights/';
$_SERVER['HTTP_HOST'] = 'nrlc.ai';
$_SERVER['HTTPS'] = 'on';
$_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
$_GET = [];
$_POST = [];

// Get base schemas (what insights hub should output)
$baseSchemas = base_schemas();

// Forbidden schema types
$forbidden = [
  'Blog',
  'Article',
  'BlogPosting',
  'FAQPage',
  'Product',
  'SoftwareApplication',
  'JobPosting',
  'Event',
  'HowTo',
  'Review',
  'AggregateRating',
  'ItemList'
];

// Allowed schema types
$allowed = [
  'Organization',
  'WebSite',
  'BreadcrumbList'
];

echo "INSIGHTS HUB SCHEMA COMPLIANCE VALIDATION\n";
echo str_repeat("=", 80) . "\n\n";

$errors = [];
$warnings = [];
$foundTypes = [];

foreach ($baseSchemas as $schema) {
  $type = $schema['@type'] ?? 'Unknown';
  $foundTypes[] = $type;
  
  // Check if forbidden
  if (in_array($type, $forbidden)) {
    $errors[] = "FORBIDDEN schema type found: $type";
  }
  
  // Validate Organization schema (must reuse homepage @id)
  if ($type === 'Organization') {
    $expectedId = 'https://nrlc.ai/en-us/#organization';
    $actualId = $schema['@id'] ?? '';
    if ($actualId !== $expectedId) {
      $errors[] = "Organization @id mismatch. Expected: $expectedId, Found: $actualId";
    }
    if (!isset($schema['logo']) || !is_array($schema['logo'])) {
      $errors[] = "Organization logo must be ImageObject";
    }
  }
  
  // Validate WebSite schema
  if ($type === 'WebSite') {
    if (!isset($schema['potentialAction'])) {
      $errors[] = "WebSite schema missing potentialAction (SearchAction)";
    }
  }
  
  // Validate BreadcrumbList schema
  if ($type === 'BreadcrumbList') {
    if (!isset($schema['itemListElement']) || !is_array($schema['itemListElement'])) {
      $errors[] = "BreadcrumbList schema missing itemListElement";
    } else {
      $items = $schema['itemListElement'];
      // Should have Home + Insights (2 items)
      if (count($items) !== 2) {
        $warnings[] = "BreadcrumbList should have 2 items (Home + Insights), found: " . count($items);
      }
      // Check for @id
      if (!isset($schema['@id'])) {
        $warnings[] = "BreadcrumbList missing @id (should be https://nrlc.ai/en-us/insights/#breadcrumb)";
      } else {
        $expectedId = 'https://nrlc.ai/en-us/insights/#breadcrumb';
        if ($schema['@id'] !== $expectedId) {
          $warnings[] = "BreadcrumbList @id mismatch. Expected: $expectedId, Found: {$schema['@id']}";
        }
      }
    }
  }
}

// Check for missing allowed types
foreach ($allowed as $allowedType) {
  if (!in_array($allowedType, $foundTypes)) {
    $errors[] = "Missing required schema type: $allowedType";
  }
}

// Output results
echo "SCHEMA TYPES FOUND:\n";
foreach ($foundTypes as $type) {
  $status = in_array($type, $allowed) ? '✓' : (in_array($type, $forbidden) ? '✗ FORBIDDEN' : '⚠ UNKNOWN');
  echo "  $status $type\n";
}
echo "\n";

if (!empty($errors)) {
  echo "ERRORS:\n";
  foreach ($errors as $error) {
    echo "  ✗ $error\n";
  }
  echo "\n";
}

if (!empty($warnings)) {
  echo "WARNINGS:\n";
  foreach ($warnings as $warning) {
    echo "  ⚠ $warning\n";
  }
  echo "\n";
}

// Output schema details
echo "SCHEMA DETAILS:\n";
echo str_repeat("-", 80) . "\n";
foreach ($baseSchemas as $schema) {
  $type = $schema['@type'] ?? 'Unknown';
  echo "\n$type:\n";
  echo json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
}

if (empty($errors)) {
  echo "\n✓ INSIGHTS HUB SCHEMA COMPLIANCE PASSED\n";
  exit(0);
} else {
  echo "\n❌ INSIGHTS HUB SCHEMA COMPLIANCE FAILED\n";
  exit(1);
}

