#!/usr/bin/env php
<?php
/**
 * Fix ALL Canonical Inconsistencies in service_enhancements.json
 * 
 * Ensures every canonical URL follows proper locale-prefixed pattern:
 * - UK cities: /en-gb/services/{service}/{city}/
 * - Non-UK cities: /en-us/services/{service}/{city}/ (or no prefix for en-us)
 */

require_once __DIR__ . '/../lib/helpers.php';

echo "Loading service enhancements...\n";
$enhancementsFile = __DIR__ . '/../data/service_enhancements.json';

if (!file_exists($enhancementsFile)) {
    die("Service enhancements file not found\n");
}

$data = json_decode(file_get_contents($enhancementsFile), true);
if (!$data) {
    die("Failed to parse JSON\n");
}

$fixed = 0;
$ukCities = ['london', 'manchester', 'birmingham', 'glasgow', 'edinburgh', 'leeds', 'sheffield', 'newcastle', 'brighton', 'nottingham', 'plymouth', 'bristol', 'cardiff', 'southampton', 'stoke-on-trent', 'coventry', 'hull', 'blackpool', 'swansea', 'derby', 'wolverhampton', 'sunderland', 'northampton', 'portsmouth', 'luton', 'wolverhampton', 'southend-on-sea', 'salford', 'bury', 'rochdale', 'oldham', 'stockport', 'bolton', 'wigan', 'burnley', 'blackburn', 'preston', 'halifax', 'huddersfield', 'wakefield', 'leeds', 'bradford', 'sheffield', 'doncaster', 'rotherham', 'barnsley', 'gateshead', 'south-shields', 'newcastle-upon-tyne', 'sunderland', 'middlesbrough', 'stockton-on-tees', 'darlington', 'hartlepool', 'redcar', 'cleveland', 'peterborough', 'cambridge', 'huntingdon', 'norwich', 'great-yarmouth', 'lowestoft', 'ipswich', 'colchester', 'chelmsford', 'southend-on-sea', 'basildon', 'braintree', 'maldon', 'rochford', 'castle-point', 'thurrock', 'epping-forest', 'harlow', 'uttoxeter', 'tamworth', 'lichfield', 'cannock', 'stafford', 'newcastle-under-lyme', 'crewe', 'nantwich', 'congleton', 'macclesfield', 'wilmslow', 'altrincham', 'sale', 'stretford', ' Eccles', 'swinton', 'walkden', 'farnworth', 'kearsley', 'little-lever', 'radcliffe', 'whitefield', 'prestwich', 'heywood', 'middleton', 'chadderton', 'failsworth', 'milnrow', 'newhey', 'saddleworth', 'ashton-under-lyne', 'dukinfield', 'hyde', 'mossley', 'stalybridge', 'droylsden', 'audenshaw', 'longdendale', 'tameside', 'glossop', 'mottram-in-longdendale', 'hollingworth', 'padfield', 'tintwistle', 'dinting', 'hadfield', 'gamesley', 'charlestown', 'broadbottom', 'hattersley', 'godley', 'newton', 'mossley', 'uppermill', 'delph', 'dobcross', 'diggle', 'saddleworth', 'greenfield'];

foreach ($data as &$item) {
    $city = $item['city'] ?? '';
    $service = $item['service'] ?? '';
    $currentCanonical = $item['canonical'] ?? '';
    
    if (!$city || !$service || !$currentCanonical) {
        continue; // Skip invalid entries
    }
    
    // Determine correct locale
    $isUK = in_array($city, $ukCities);
    $correctLocale = $isUK ? 'en-gb' : 'en-us';
    $localePrefix = ($correctLocale === 'en-us') ? '' : '/' . $correctLocale;
    
    // Generate correct canonical
    $correctCanonical = 'https://nrlc.ai' . $localePrefix . '/services/' . $service . '/' . $city . '/';
    
    if ($currentCanonical !== $correctCanonical) {
        echo "FIXING: {$service} + {$city}\n";
        echo "  OLD: {$currentCanonical}\n";
        echo "  NEW: {$correctCanonical}\n\n";
        $item['canonical'] = $correctCanonical;
        $fixed++;
    }
}

if ($fixed > 0) {
    echo "Fixed {$fixed} canonical inconsistencies\n";
    file_put_contents($enhancementsFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "Updated service_enhancements.json\n";
} else {
    echo "No fixes needed\n";
}
