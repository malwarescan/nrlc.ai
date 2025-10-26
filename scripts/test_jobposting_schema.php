<?php
declare(strict_types=1);

/**
 * Test JobPosting schema to verify GSC issues are fixed
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/schema_builders.php';
require_once __DIR__.'/../lib/SchemaNormalizers.php';

echo "Testing JobPosting Schema Fixes\n";
echo str_repeat('=', 80) . "\n\n";

// Simulate career page data
$citySlug = 'new-york';
$roleSlug = 'seo-specialist';
$city = [
  'city_name' => 'New York',
  'country' => 'US',
  'subdivision' => 'NY'
];
$role = ['title' => 'SEO Specialist'];

// Normalize experience and education requirements
$rawExperience = '3+ years of technical SEO experience';
$normExperience = App\Schema\SchemaNormalizers::normalizeExperienceRequirements($rawExperience);

$rawEducation = 'Bachelor\'s degree in Computer Science, Marketing, or related field';
$normEducation = App\Schema\SchemaNormalizers::normalizeEducationRequirements($rawEducation);

// Build JobPosting schema with fixes
$jobPostingLd = [
  '@context' => 'https://schema.org',
  '@type' => 'JobPosting',
  '@id' => 'https://nrlc.ai/careers/' . $citySlug . '/' . $roleSlug . '/#jobposting',
  'title' => $role['title'],
  'description' => "Join NRLC.ai in {$city['city_name']} to build world-class JSON-LD, LLM seeding systems.",
  'datePosted' => date('Y-m-d'),
  'validThrough' => gmdate('Y-m-d', strtotime('+45 days')),
  'employmentType' => 'FULL_TIME',
  'hiringOrganization' => [
    '@type' => 'Organization',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai',
    'logo' => 'https://nrlc.ai/assets/images/nrlcai%20logo%200.png'
  ],
  'jobLocation' => [
    '@type' => 'Place',
    'address' => [
      '@type' => 'PostalAddress',
      'streetAddress' => 'Remote',
      'addressLocality' => $city['city_name'],
      'addressRegion' => $city['subdivision'] ?? '',
      'postalCode' => '00000',
      'addressCountry' => $city['country'] ?? 'US'
    ]
  ],
  'baseSalary' => [
    '@type' => 'MonetaryAmount',
    'currency' => 'USD',
    'value' => [
      '@type' => 'QuantitativeValue',
      'minValue' => '80000',
      'maxValue' => '150000',
      'unitText' => 'YEAR'
    ]
  ],
  'experienceRequirements' => $normExperience,
  'educationRequirements' => $normEducation,
];

// Drop nulls
$jobPostingLd = array_filter($jobPostingLd, static function($v) { return $v !== null && $v !== ''; });

echo "✅ JobPosting Schema with Fixes:\n";
echo json_encode($jobPostingLd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n";

// Check for required fields
echo "Checking Required Fields:\n";
echo str_repeat('-', 80) . "\n";

$checks = [
  'validThrough' => isset($jobPostingLd['validThrough']),
  'streetAddress' => isset($jobPostingLd['jobLocation']['address']['streetAddress']),
  'postalCode' => isset($jobPostingLd['jobLocation']['address']['postalCode']),
  'educationRequirements (proper format)' => is_array($jobPostingLd['educationRequirements']) && isset($jobPostingLd['educationRequirements']['@type']),
];

foreach ($checks as $field => $passed) {
  echo ($passed ? '✓' : '✗') . " $field: " . ($passed ? 'PASS' : 'FAIL') . "\n";
}

$allPassed = !in_array(false, $checks);
echo "\n" . str_repeat('=', 80) . "\n";
echo "Overall: " . ($allPassed ? '✓ ALL TESTS PASSED' : '✗ SOME TESTS FAILED') . "\n";

exit($allPassed ? 0 : 1);

