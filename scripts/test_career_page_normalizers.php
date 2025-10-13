<?php
require_once __DIR__ . '/../lib/SchemaNormalizers.php';

echo "🧪 Testing Career Page Schema Normalizers\n";
echo "=========================================\n\n";

// Simulate the career page data
$rawExperience = '3+ years of technical SEO experience';
$rawEducation = 'Bachelor\'s degree in Computer Science, Marketing, or related field';

echo "Raw Experience: '$rawExperience'\n";
echo "Raw Education: '$rawEducation'\n\n";

// Normalize
$normExperience = App\Schema\SchemaNormalizers::normalizeExperienceRequirements($rawExperience);
$normEducation = App\Schema\SchemaNormalizers::normalizeEducationRequirements($rawEducation);

echo "Normalized Experience:\n";
echo json_encode($normExperience, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";

echo "Normalized Education: " . ($normEducation ?: 'null') . "\n\n";

// Test JobPosting schema structure
$jobPostingLd = [
  '@context' => 'https://schema.org',
  '@type' => 'JobPosting',
  '@id' => 'https://nrlc.ai/careers/new-york/seo-specialist/#jobposting',
  'title' => 'SEO Specialist',
  'description' => 'Join NRLC.ai in New York to build world-class JSON-LD, LLM seeding systems.',
  'datePosted' => date('Y-m-d'),
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
      'addressLocality' => 'New York',
      'addressRegion' => 'NY',
      'addressCountry' => 'US'
    ]
  ],
  'experienceRequirements' => $normExperience,
  'educationRequirements' => $normEducation,
  'baseSalary' => [
    '@type' => 'MonetaryAmount',
    'currency' => 'USD',
    'value' => [
      '@type' => 'QuantitativeValue',
      'minValue' => '80000',
      'maxValue' => '150000',
      'unitText' => 'YEAR'
    ]
  ]
];

// Drop nulls
$jobPostingLd = array_filter($jobPostingLd, static function($v) { return $v !== null && $v !== ''; });

echo "Final JobPosting Schema:\n";
echo json_encode($jobPostingLd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";

// Test duplicate protection
$json1 = json_encode($jobPostingLd, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
$json2 = json_encode($jobPostingLd, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

echo "Duplicate Protection Test:\n";
echo "First JSON: " . (App\Schema\SchemaNormalizers::jsonLdOnce($json1) ? 'ACCEPTED' : 'REJECTED') . "\n";
echo "Second JSON (same): " . (App\Schema\SchemaNormalizers::jsonLdOnce($json2) ? 'ACCEPTED' : 'REJECTED') . "\n";

echo "\n✅ Career Page Schema Normalizers Test Complete!\n";
?>
