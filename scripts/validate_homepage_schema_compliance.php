<?php
declare(strict_types=1);

/**
 * Validate Homepage Schema Compliance
 * 
 * Ensures homepage (/en-us/) only includes allowed schemas:
 * - Organization (with @id, logo as ImageObject, sameAs)
 * - WebSite (with SearchAction)
 * - BreadcrumbList (minimal)
 * 
 * FORBIDDEN on homepage:
 * - FAQPage
 * - JobPosting
 * - Product / SoftwareApplication
 * - Article / BlogPosting
 * - Event
 * - HowTo
 * - Review (without AggregateRating + visible reviews)
 * - Service
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';

// Simulate homepage request
$_SERVER['REQUEST_URI'] = '/en-us/';
$_SERVER['HTTP_HOST'] = 'nrlc.ai';
$_SERVER['HTTPS'] = 'on';
$_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
$_GET = [];
$_POST = [];

// Get base schemas (what homepage should output)
$baseSchemas = base_schemas();

// Forbidden schema types
$forbidden = [
  'FAQPage',
  'JobPosting',
  'Product',
  'SoftwareApplication',
  'Article',
  'BlogPosting',
  'Event',
  'HowTo',
  'Review',
  'Service'
];

// Allowed schema types
$allowed = [
  'Organization',
  'WebSite',
  'BreadcrumbList'
];

echo "HOMEPAGE SCHEMA COMPLIANCE VALIDATION\n";
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
  
  // Validate Organization schema
  if ($type === 'Organization') {
    if (!isset($schema['@id'])) {
      $errors[] = "Organization schema missing @id";
    }
    if (!isset($schema['logo'])) {
      $errors[] = "Organization schema missing logo";
    } elseif (!is_array($schema['logo']) || ($schema['logo']['@type'] ?? '') !== 'ImageObject') {
      $errors[] = "Organization logo must be ImageObject, found: " . (is_array($schema['logo']) ? ($schema['logo']['@type'] ?? 'string') : 'string');
    }
    if (!isset($schema['sameAs']) || !is_array($schema['sameAs'])) {
      $errors[] = "Organization schema missing sameAs array";
    }
    if (!isset($schema['url'])) {
      $errors[] = "Organization schema missing url";
    }
  }
  
  // Validate WebSite schema
  if ($type === 'WebSite') {
    if (!isset($schema['potentialAction'])) {
      $errors[] = "WebSite schema missing potentialAction (SearchAction)";
    } elseif (($schema['potentialAction']['@type'] ?? '') !== 'SearchAction') {
      $errors[] = "WebSite potentialAction must be SearchAction";
    }
  }
  
  // Validate BreadcrumbList schema
  if ($type === 'BreadcrumbList') {
    if (!isset($schema['itemListElement']) || !is_array($schema['itemListElement'])) {
      $errors[] = "BreadcrumbList schema missing itemListElement";
    } elseif (count($schema['itemListElement']) > 3) {
      $warnings[] = "BreadcrumbList has more than 3 items (should be minimal for homepage)";
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
  echo "\n✓ HOMEPAGE SCHEMA COMPLIANCE PASSED\n";
  exit(0);
} else {
  echo "\n❌ HOMEPAGE SCHEMA COMPLIANCE FAILED\n";
  exit(1);
}

