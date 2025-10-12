<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/helpers.php';

// Test different URL patterns
$testUrls = [
  'home/home' => 'Homepage',
  'services/service' => 'Service page (crawl-clarity)',
  'services/service_city' => 'Service city page (crawl-clarity/new-york)',
  'careers/career_city' => 'Career city page (new-york/seo-specialist)',
  'insights/article' => 'Insight article (geo16-framework)',
  'insights/index' => 'Insights index',
  'services/index' => 'Services index',
  'careers/index' => 'Careers index'
];

echo "Testing Meta Tags for Different URLs:\n";
echo "=====================================\n\n";

foreach ($testUrls as $slug => $description) {
  echo "Testing: $description\n";
  echo "Slug: $slug\n";
  
  // Set up test data
  if ($slug === 'services/service') {
    $_GET['service'] = 'crawl-clarity';
  } elseif ($slug === 'services/service_city') {
    $_GET['service'] = 'crawl-clarity';
    $_GET['city'] = 'new-york';
  } elseif ($slug === 'careers/career_city') {
    $_GET['city'] = 'new-york';
    $_GET['role'] = 'seo-specialist';
  } elseif ($slug === 'insights/article') {
    $_GET['slug'] = 'geo16-framework';
  }
  
  [$title, $desc, $path] = meta_for_slug($slug);
  $keywords = extract_keywords_from_title($title);
  
  echo "Title: $title\n";
  echo "Description: $desc\n";
  echo "Path: $path\n";
  echo "Keywords: $keywords\n";
  echo "Title Length: " . strlen($title) . " chars\n";
  echo "Desc Length: " . strlen($desc) . " chars\n";
  echo "Keywords Length: " . strlen($keywords) . " chars\n";
  echo "---\n\n";
  
  // Clear GET data
  $_GET = [];
}

echo "Meta tag optimization complete!\n";
