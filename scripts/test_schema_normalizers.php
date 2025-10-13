<?php
require_once __DIR__ . '/../lib/SchemaNormalizers.php';

echo "🧪 Testing Schema Normalizers\n";
echo "=============================\n\n";

// Test Experience Requirements Normalization
echo "📋 EXPERIENCE REQUIREMENTS TESTS:\n";
echo "----------------------------------\n";

$experienceTests = [
    'no experience',
    'entry level',
    '0-1 years',
    '1 year',
    '2 years',
    '3+ years',
    '1-3 years',
    '36 months',
    '24 months',
    '2+ yrs',
    '5+ years experience',
    'senior level (5+ years)',
    'some experience preferred',
    'bachelor degree required'
];

foreach ($experienceTests as $test) {
    $result = App\Schema\SchemaNormalizers::normalizeExperienceRequirements($test);
    $type = is_array($result) ? 'OccupationalExperienceRequirements' : 'Text';
    $value = is_array($result) ? $result['monthsOfExperience'] . ' months' : $result;
    echo "Input:  '$test'\n";
    echo "Output: $type - $value\n";
    echo "JSON:   " . json_encode($result, JSON_UNESCAPED_SLASHES) . "\n\n";
}

echo "\n📚 EDUCATION REQUIREMENTS TESTS:\n";
echo "--------------------------------\n";

$educationTests = [
    'no degree',
    'high school diploma',
    'hs diploma',
    'associate degree',
    'aa',
    'bachelor degree',
    'bs in computer science',
    'master degree',
    'ma',
    'doctorate',
    'phd',
    'some college preferred',
    'certification required'
];

foreach ($educationTests as $test) {
    $result = App\Schema\SchemaNormalizers::normalizeEducationRequirements($test);
    echo "Input:  '$test'\n";
    echo "Output: " . ($result ?: 'null') . "\n\n";
}

echo "\n🔒 DUPLICATE JSON-LD PROTECTION TESTS:\n";
echo "--------------------------------------\n";

$testJson1 = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'JobPosting',
    '@id' => 'https://example.com/job1',
    'title' => 'Test Job'
]);

$testJson2 = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'JobPosting',
    '@id' => 'https://example.com/job1', // Same ID
    'title' => 'Test Job 2'
]);

$testJson3 = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'JobPosting',
    '@id' => 'https://example.com/job3', // Different ID
    'title' => 'Test Job 3'
]);

echo "First job: " . ($result1 = App\Schema\SchemaNormalizers::jsonLdOnce($testJson1) ? 'ACCEPTED' : 'REJECTED') . "\n";
echo "Second job (same ID): " . ($result2 = App\Schema\SchemaNormalizers::jsonLdOnce($testJson2) ? 'ACCEPTED' : 'REJECTED') . "\n";
echo "Third job (different ID): " . ($result3 = App\Schema\SchemaNormalizers::jsonLdOnce($testJson3) ? 'ACCEPTED' : 'REJECTED') . "\n";

echo "\n✅ Schema Normalizers Test Complete!\n";
?>
