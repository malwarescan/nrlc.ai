#!/usr/bin/env php
<?php
/**
 * Fix Canonical Duplicate Issues
 * 
 * Problem: UK cities in service_enhancements.json sometimes have en-us canonicals
 * instead of en-gb, causing Google to see canonical conflicts.
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
$ukCities = ['london', 'manchester', 'birmingham', 'glasgow', 'edinburgh', 'leeds', 'sheffield', 'newcastle', 'brighton', 'nottingham', 'plymouth', 'bristol', 'cardiff', 'southampton', 'stoke-on-trent', 'coventry', 'hull', 'blackpool', 'swansea', 'derby', 'wolverhampton', 'sunderland', 'northampton', 'portsmouth', 'luton', 'wolverhampton', 'southend-on-sea', 'salford', 'bury', 'rochdale', 'oldham', 'stockport', 'bolton', 'wigan', 'burnley', 'blackburn', 'preston', 'halifax', 'huddersfield', 'wakefield', 'leeds', 'bradford', 'sheffield', 'doncaster', 'rotherham', 'barnsley', 'gateshead', 'south-shields', 'newcastle-upon-tyne', 'sunderland', 'middlesbrough', 'stockton-on-tees', 'darlington', 'hartlepool', 'redcar', 'cleveland', 'peterborough', 'cambridge', 'huntingdon', 'norwich', 'great-yarmouth', 'lowestoft', 'ipswich', 'colchester', 'chelmsford', 'southend-on-sea', 'basildon', 'braintree', 'maldon', 'rochford', 'castle-point', 'thurrock', 'epping-forest', 'harlow', 'uttoxeter', 'tamworth', 'lichfield', 'cannock', 'stafford', 'newcastle-under-lyme', 'crewe', 'nantwich', 'congleton', 'macclesfield', 'wilmslow', 'altrincham', 'sale', 'stretford', ' Eccles', 'swinton', 'walkden', 'farnworth', 'kearsley', 'little-lever', 'radcliffe', 'whitefield', 'prestwich', 'heywood', 'middleton', 'chadderton', 'failsworth', 'milnrow', 'newhey', 'saddleworth', 'ashton-under-lyne', 'dukinfield', 'hyde', 'mossley', 'stalybridge', 'droylsden', 'audenshaw', 'longdendale', 'tameside', 'glossop', 'mottram-in-longdendale', 'hollingworth', 'padfield', 'tintwistle', 'dinting', 'hadfield', 'gamesley', 'charlestown', 'broadbottom', 'hattersley', 'godley', 'newton', 'mossley', 'uppermill', 'delph', 'dobcross', 'diggle', 'saddleworth', 'greenfield', 'mossley', 'uppermill', 'delph', 'dobcross', 'diggle', 'saddleworth', 'greenfield'];

foreach ($data as &$item) {
    $city = $item['city'] ?? '';
    $canonical = $item['canonical'] ?? '';
    
    // Check if this is a UK city with wrong canonical
    if (in_array($city, $ukCities) && strpos($canonical, '/en-us/services/') !== false) {
        // Fix: Change en-us to en-gb for UK cities
        $fixedCanonical = str_replace('/en-us/services/', '/en-gb/services/', $canonical);
        echo "FIXING UK CITY: {$city}\n";
        echo "  OLD: {$canonical}\n";
        echo "  NEW: {$fixedCanonical}\n\n";
        $item['canonical'] = $fixedCanonical;
        $fixed++;
    }
}

if ($fixed > 0) {
    echo "Fixed {$fixed} UK city canonical URLs\n";
    file_put_contents($enhancementsFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "Updated service_enhancements.json\n";
} else {
    echo "No fixes needed\n";
}
