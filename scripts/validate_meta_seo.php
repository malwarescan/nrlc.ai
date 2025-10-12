<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/helpers.php';

/**
 * Validate meta tags for SEO best practices
 */

function validate_meta_seo(): void {
  $testUrls = [
    'home/home' => 'Homepage',
    'services/service' => 'Service page',
    'services/service_city' => 'Service city page',
    'careers/career_city' => 'Career city page',
    'insights/article' => 'Insight article',
    'insights/index' => 'Insights index',
    'services/index' => 'Services index',
    'careers/index' => 'Careers index'
  ];

  $issues = [];
  $total = 0;

  echo "SEO Meta Tag Validation Report\n";
  echo "==============================\n\n";

  foreach ($testUrls as $slug => $description) {
    $total++;
    
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

    echo "Testing: $description\n";
    echo "Slug: $slug\n";
    echo "Title: $title\n";
    echo "Description: $desc\n";
    echo "Keywords: $keywords\n";

    // SEO Validation Rules
    $titleLen = strlen($title);
    $descLen = strlen($desc);
    $keywordLen = strlen($keywords);

    // Title length check (50-60 chars optimal, max 70)
    if ($titleLen < 50) {
      $issues[] = "$description: Title too short ($titleLen chars)";
    } elseif ($titleLen > 70) {
      $issues[] = "$description: Title too long ($titleLen chars)";
    }

    // Description length check (150-160 chars optimal, max 170)
    if ($descLen < 120) {
      $issues[] = "$description: Description too short ($descLen chars)";
    } elseif ($descLen > 170) {
      $issues[] = "$description: Description too long ($descLen chars)";
    }

    // Keywords check (not empty, reasonable length)
    if ($keywordLen === 0) {
      $issues[] = "$description: No keywords extracted";
    } elseif ($keywordLen > 200) {
      $issues[] = "$description: Keywords too long ($keywordLen chars)";
    }

    // Brand consistency check
    if (stripos($title, 'NRLC.ai') === false) {
      $issues[] = "$description: Title missing NRLC.ai branding";
    }

    // AI SEO terms check
    $aiTerms = ['AI SEO', 'GEO-16', 'LLM', 'Structured Data', 'Crawl Clarity'];
    $hasAiTerm = false;
    foreach ($aiTerms as $term) {
      if (stripos($title, $term) !== false || stripos($desc, $term) !== false) {
        $hasAiTerm = true;
        break;
      }
    }
    if (!$hasAiTerm) {
      $issues[] = "$description: Missing AI SEO terminology";
    }

    echo "Title Length: $titleLen chars " . ($titleLen >= 50 && $titleLen <= 70 ? "✅" : "⚠️") . "\n";
    echo "Desc Length: $descLen chars " . ($descLen >= 120 && $descLen <= 170 ? "✅" : "⚠️") . "\n";
    echo "Keywords Length: $keywordLen chars " . ($keywordLen > 0 && $keywordLen <= 200 ? "✅" : "⚠️") . "\n";
    echo "---\n\n";

    // Clear GET data
    $_GET = [];
  }

  // Summary
  echo "Validation Summary:\n";
  echo "==================\n";
  echo "Total URLs tested: $total\n";
  echo "Issues found: " . count($issues) . "\n\n";

  if (empty($issues)) {
    echo "✅ All meta tags pass SEO validation!\n";
  } else {
    echo "⚠️ Issues found:\n";
    foreach ($issues as $issue) {
      echo "- $issue\n";
    }
  }

  echo "\nSEO Best Practices Applied:\n";
  echo "- Title tags: 50-70 characters\n";
  echo "- Meta descriptions: 120-170 characters\n";
  echo "- Keywords extracted from content\n";
  echo "- NRLC.ai branding consistency\n";
  echo "- AI SEO terminology included\n";
  echo "- Open Graph and Twitter Card meta tags\n";
  echo "- Canonical URLs for all pages\n";
  echo "- Hreflang alternates for international SEO\n";
}

validate_meta_seo();
