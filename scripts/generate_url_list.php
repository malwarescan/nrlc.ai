<?php
/**
 * Generate complete URL list for crawling/analysis
 */

$baseUrl = 'http://localhost:8000';

// Read services
$servicesFile = __DIR__.'/../data/services.csv';
$servicesHandle = fopen($servicesFile, 'r');
fgetcsv($servicesHandle); // skip header
$services = [];
while (($row = fgetcsv($servicesHandle, 1000, ',', '"', '\\')) !== false) {
    if (!empty($row[0]) && $row[0] !== 'slug') {
        $services[] = ['slug' => $row[0], 'name' => $row[1] ?? ''];
    }
}
fclose($servicesHandle);

// Read cities
$citiesFile = __DIR__.'/../data/cities.csv';
$citiesHandle = fopen($citiesFile, 'r');
fgetcsv($citiesHandle); // skip header
$cities = [];
while (($row = fgetcsv($citiesHandle, 1000, ',', '"', '\\')) !== false) {
    if (!empty($row[0]) && $row[0] !== 'city_name') {
        $cities[] = ['city_name' => $row[0]];
    }
}
fclose($citiesHandle);

// Read insights
$insightsFile = __DIR__.'/../data/insights.csv';
$insightsHandle = fopen($insightsFile, 'r');
fgetcsv($insightsHandle); // skip header
$insights = [];
while (($row = fgetcsv($insightsHandle, 1000, ',', '"', '\\')) !== false) {
    if (!empty($row[0]) && $row[0] !== 'slug') {
        $insights[] = ['slug' => $row[0]];
    }
}
fclose($insightsHandle);

// Read careers
$careersFile = __DIR__.'/../data/careers.csv';
$careersHandle = fopen($careersFile, 'r');
fgetcsv($careersHandle); // skip header
$careers = [];
while (($row = fgetcsv($careersHandle, 1000, ',', '"', '\\')) !== false) {
    if (!empty($row[0]) && $row[0] !== 'slug') {
        $careers[] = ['slug' => $row[0]];
    }
}
fclose($careersHandle);

echo "📋 COMPLETE URL LIST FOR CRAWLING\n";
echo "==================================\n\n";

$urls = [];

// Homepage
$urls[] = "$baseUrl/";

// Service pages
$urls[] = "$baseUrl/services/";

// Service index pages
foreach ($services as $service) {
    $urls[] = "$baseUrl/services/{$service['slug']}/";
}

// Service + City pages (sample of 50 for testing)
$serviceCount = 0;
foreach ($services as $service) {
    foreach ($cities as $city) {
        $urls[] = "$baseUrl/services/{$service['slug']}/{$city['city_name']}/";
        $serviceCount++;
        if ($serviceCount >= 50) break 2; // Limit for initial scan
    }
}

// Insights
$urls[] = "$baseUrl/insights/";
foreach ($insights as $insight) {
    $urls[] = "$baseUrl/insights/{$insight['slug']}/";
}

// Careers
$urls[] = "$baseUrl/careers/";

// Career + City pages (sample of 20 for testing)
$careerCount = 0;
foreach ($careers as $career) {
    foreach ($cities as $city) {
        $urls[] = "$baseUrl/careers/{$city['city_name']}/{$career['slug']}/";
        $careerCount++;
        if ($careerCount >= 20) break 2; // Limit for initial scan
    }
}

// Booking
$urls[] = "$baseUrl/api/book/";

echo "📊 STATISTICS:\n";
echo "  • Total URLs in list: " . count($urls) . "\n";
echo "  • Services: " . count($services) . "\n";
echo "  • Cities: " . count($cities) . "\n";
echo "  • Insights: " . count($insights) . "\n";
echo "  • Careers: " . count($careers) . "\n";
echo "  • Service+City combinations sampled: $serviceCount\n";
echo "  • Career+City combinations sampled: $careerCount\n\n";

echo "🌐 URL LIST:\n";
echo "============\n";
foreach ($urls as $url) {
    echo "$url\n";
}

// Also write to file
$outputFile = __DIR__.'/../logs/urls_to_crawl.txt';
@mkdir(__DIR__.'/../logs', 0755, true);
file_put_contents($outputFile, implode("\n", $urls));

echo "\n✅ URL list saved to: logs/urls_to_crawl.txt\n";
echo "\n💡 FULL SITE SCALE:\n";
echo "  • Total possible service+city URLs: " . (count($services) * count($cities)) . "\n";
echo "  • Total possible career+city URLs: " . (count($careers) * count($cities)) . "\n";
echo "  • Grand total possible URLs: " . (1 + 3 + count($services) + (count($services) * count($cities)) + count($insights) + 1 + (count($careers) * count($cities)) + 1) . "\n";
?>
