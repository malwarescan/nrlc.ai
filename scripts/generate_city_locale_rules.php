<?php
/**
 * City Locale Rules Generator
 * 
 * Generates data/city_locale_rules.json from cities.csv
 * This is the authoritative mapping of city → canonical locale
 */

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/csv.php';

$citiesCsv = __DIR__ . '/../data/cities.csv';
$outputFile = __DIR__ . '/../data/city_locale_rules.json';

if (!file_exists($citiesCsv)) {
    fwrite(STDERR, "ERROR: cities.csv not found: $citiesCsv\n");
    exit(1);
}

echo "=== GENERATING CITY LOCALE RULES ===\n\n";

// Load cities
$citiesData = csv_read_data('cities.csv');
$rules = [];
$errors = [];

// Country code to locale mapping
$countryToLocale = [
    'GB' => 'en-gb',
    'US' => 'en-us',
    'CA' => 'en-us', // Default to en-us for Canada (can be overridden)
    'AU' => 'en-au', // Australia uses en-au (Australian English)
    'SG' => 'en-sg', // Singapore uses en-sg (Singapore English)
    // Add more as needed
];

// All available locales (for forbidden list)
$allLocales = ['en-us', 'en-gb', 'en-sg', 'en-au', 'fr-fr', 'es-es', 'de-de', 'ko-kr'];

foreach ($citiesData as $row) {
    $citySlug = $row['city_name'] ?? '';
    if (empty($citySlug)) {
        continue;
    }
    
    // Determine country from CSV (preferred) or fallback to helper
    $country = strtoupper(trim($row['country'] ?? ''));
    if (empty($country)) {
        // Fallback: use is_uk_city helper
        $isUK = is_uk_city($citySlug);
        $country = $isUK ? 'GB' : 'US';
    }
    
    // Get canonical locale
    $canonicalLocale = $countryToLocale[$country] ?? 'en-us';
    
    // Build forbidden locales (all except canonical)
    $forbiddenLocales = array_filter($allLocales, fn($l) => $l !== $canonicalLocale);
    
    $rules[$citySlug] = [
        'country' => $country,
        'canonical_locale' => $canonicalLocale,
        'forbidden_locales' => array_values($forbiddenLocales)
    ];
}

// Load overrides if they exist
$overridesFile = __DIR__ . '/../data/city_locale_overrides.json';
if (file_exists($overridesFile)) {
    $overrides = json_decode(file_get_contents($overridesFile), true);
    if (is_array($overrides)) {
        echo "Loading overrides from city_locale_overrides.json\n";
        foreach ($overrides as $city => $override) {
            // Skip comment/example keys
            if (strpos($city, '_') === 0) {
                continue;
            }
            if (isset($rules[$city])) {
                // Merge override
                if (isset($override['canonical_locale'])) {
                    $rules[$city]['canonical_locale'] = $override['canonical_locale'];
                }
                if (isset($override['allowed_locales'])) {
                    // If allowed_locales specified, forbidden = all - allowed
                    $allowed = $override['allowed_locales'];
                    $rules[$city]['forbidden_locales'] = array_values(array_filter($allLocales, fn($l) => !in_array($l, $allowed)));
                }
            } else {
                // New city from override
                $rules[$city] = $override;
            }
        }
    }
}

// Validate all cities have canonical locale
foreach ($rules as $city => $rule) {
    if (empty($rule['canonical_locale'])) {
        $errors[] = "City '$city' missing canonical_locale";
    }
}

if (!empty($errors)) {
    fwrite(STDERR, "ERROR: Validation failures:\n");
    foreach ($errors as $error) {
        fwrite(STDERR, "  - $error\n");
    }
    exit(1);
}

// Write rules file
$outputDir = dirname($outputFile);
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

file_put_contents($outputFile, json_encode($rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Generated rules for " . count($rules) . " cities\n";
echo "Output: $outputFile\n";
echo "\n✅ City locale rules generated successfully\n";

