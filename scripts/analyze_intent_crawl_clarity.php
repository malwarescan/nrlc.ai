<?php
/**
 * Analyze Intent-Based Pages and Crawl Clarity
 * Checks: URL structure, content depth, schema presence, canonical tags, meta tags
 */

$testUrls = [
    'http://localhost:8000/',
    'http://localhost:8000/services/crawl-clarity/new-york/',
    'http://localhost:8000/services/json-ld-strategy/london/',
    'http://localhost:8000/services/llm-seeding/tokyo/',
    'http://localhost:8000/services/site-audits/toronto/',
    'http://localhost:8000/insights/geo16-framework/',
    'http://localhost:8000/careers/new-york/seo-specialist/',
    'http://localhost:8000/api/book/'
];

function analyzeUrl($url) {
    $html = @file_get_contents($url);
    if (!$html) {
        return ['error' => 'Failed to fetch'];
    }
    
    $scores = [
        'url_structure' => 0,
        'intent_clarity' => 0,
        'content_depth' => 0,
        'schema_markup' => 0,
        'crawl_clarity' => 0,
        'meta_optimization' => 0
    ];
    
    // 1. URL Structure (20 points)
    $urlParts = parse_url($url);
    $path = $urlParts['path'] ?? '/';
    
    // Clean, descriptive URLs
    if (!strpos($path, '?') && !strpos($path, '&')) {
        $scores['url_structure'] += 5;
    }
    // Hierarchical structure
    if (preg_match('#^/[a-z-]+/[a-z-]+/#', $path)) {
        $scores['url_structure'] += 5;
    }
    // No parameters
    if (empty($urlParts['query'])) {
        $scores['url_structure'] += 5;
    }
    // Lowercase, hyphenated
    if ($path === strtolower($path) && strpos($path, '_') === false) {
        $scores['url_structure'] += 5;
    }
    
    // 2. Intent Clarity (20 points)
    // Check H1 presence
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1Match)) {
        $scores['intent_clarity'] += 5;
        $h1Text = strip_tags($h1Match[1]);
        // H1 matches URL intent
        if (strlen($h1Text) > 10 && strlen($h1Text) < 100) {
            $scores['intent_clarity'] += 5;
        }
    }
    
    // Check title tag
    if (preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatch)) {
        $scores['intent_clarity'] += 5;
        $title = strip_tags($titleMatch[1]);
        if (strlen($title) >= 30 && strlen($title) <= 70) {
            $scores['intent_clarity'] += 5;
        }
    }
    
    // 3. Content Depth (20 points)
    $bodyContent = '';
    if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $html, $mainMatch)) {
        $bodyContent = $mainMatch[1];
    } elseif (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $bodyMatch)) {
        $bodyContent = $bodyMatch[1];
    }
    
    $textContent = strip_tags($bodyContent);
    $textContent = preg_replace('/\s+/', ' ', $textContent);
    $wordCount = str_word_count($textContent);
    
    if ($wordCount >= 900) $scores['content_depth'] += 20;
    elseif ($wordCount >= 600) $scores['content_depth'] += 15;
    elseif ($wordCount >= 400) $scores['content_depth'] += 10;
    elseif ($wordCount >= 200) $scores['content_depth'] += 5;
    
    // 4. Schema Markup (20 points)
    preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/is', $html, $schemaMatches);
    $schemaCount = count($schemaMatches[1]);
    
    if ($schemaCount >= 6) $scores['schema_markup'] += 20;
    elseif ($schemaCount >= 4) $scores['schema_markup'] += 15;
    elseif ($schemaCount >= 2) $scores['schema_markup'] += 10;
    elseif ($schemaCount >= 1) $scores['schema_markup'] += 5;
    
    // Check for specific schemas
    $hasOrganization = strpos($html, '"@type":"Organization"') !== false;
    $hasService = strpos($html, '"@type":"Service"') !== false;
    $hasFAQ = strpos($html, '"@type":"FAQPage"') !== false;
    
    // 5. Crawl Clarity (20 points)
    // Canonical tag
    if (preg_match('/<link rel="canonical" href="([^"]+)"/i', $html, $canonicalMatch)) {
        $scores['crawl_clarity'] += 8;
        // Canonical matches current URL
        if (rtrim($canonicalMatch[1], '/') === rtrim($url, '/')) {
            $scores['crawl_clarity'] += 2;
        }
    }
    
    // Hreflang tags
    if (strpos($html, 'hreflang') !== false) {
        $scores['crawl_clarity'] += 5;
    }
    
    // Robots meta
    if (strpos($html, 'robots') !== false && strpos($html, 'index, follow') !== false) {
        $scores['crawl_clarity'] += 5;
    }
    
    // 6. Meta Optimization (20 points)
    // Meta description
    if (preg_match('/<meta name="description" content="([^"]+)"/i', $html, $descMatch)) {
        $scores['meta_optimization'] += 5;
        $desc = $descMatch[1];
        if (strlen($desc) >= 120 && strlen($desc) <= 170) {
            $scores['meta_optimization'] += 5;
        }
    }
    
    // Open Graph tags
    $ogCount = substr_count($html, 'og:');
    if ($ogCount >= 4) $scores['meta_optimization'] += 5;
    
    // Twitter Card tags
    $twitterCount = substr_count($html, 'twitter:');
    if ($twitterCount >= 3) $scores['meta_optimization'] += 5;
    
    $totalScore = array_sum($scores);
    
    return [
        'url' => $url,
        'scores' => $scores,
        'total' => $totalScore,
        'grade' => getGrade($totalScore),
        'word_count' => $wordCount ?? 0,
        'schema_count' => $schemaCount,
        'has_canonical' => isset($canonicalMatch),
        'has_hreflang' => strpos($html, 'hreflang') !== false
    ];
}

function getGrade($score) {
    if ($score >= 90) return 'A+';
    if ($score >= 85) return 'A';
    if ($score >= 80) return 'A-';
    if ($score >= 75) return 'B+';
    if ($score >= 70) return 'B';
    if ($score >= 65) return 'B-';
    if ($score >= 60) return 'C+';
    if ($score >= 55) return 'C';
    if ($score >= 50) return 'C-';
    return 'D';
}

echo "🔍 INTENT & CRAWL CLARITY ANALYSIS\n";
echo "===================================\n\n";

$results = [];
$totalScores = [
    'url_structure' => 0,
    'intent_clarity' => 0,
    'content_depth' => 0,
    'schema_markup' => 0,
    'crawl_clarity' => 0,
    'meta_optimization' => 0
];

foreach ($testUrls as $url) {
    echo "📄 Analyzing: $url\n";
    $result = analyzeUrl($url);
    
    if (isset($result['error'])) {
        echo "   ❌ Error: {$result['error']}\n\n";
        continue;
    }
    
    echo "   Score: {$result['total']}/120 (Grade: {$result['grade']})\n";
    echo "   Word Count: {$result['word_count']}\n";
    echo "   Schema Count: {$result['schema_count']}\n";
    echo "   Breakdown:\n";
    echo "     • URL Structure: {$result['scores']['url_structure']}/20\n";
    echo "     • Intent Clarity: {$result['scores']['intent_clarity']}/20\n";
    echo "     • Content Depth: {$result['scores']['content_depth']}/20\n";
    echo "     • Schema Markup: {$result['scores']['schema_markup']}/20\n";
    echo "     • Crawl Clarity: {$result['scores']['crawl_clarity']}/20\n";
    echo "     • Meta Optimization: {$result['scores']['meta_optimization']}/20\n";
    echo "\n";
    
    $results[] = $result;
    foreach ($totalScores as $key => $value) {
        $totalScores[$key] += $result['scores'][$key];
    }
}

echo "\n📊 OVERALL SITE ANALYSIS\n";
echo "========================\n\n";

$avgScores = [];
$count = count($results);
foreach ($totalScores as $key => $value) {
    $avgScores[$key] = $count > 0 ? round($value / $count, 1) : 0;
}

$overallAvg = $count > 0 ? round(array_sum($totalScores) / ($count * 6), 1) : 0;
$overallGrade = getGrade($overallAvg);

echo "Pages Analyzed: $count\n\n";
echo "Average Scores:\n";
echo "  • URL Structure: {$avgScores['url_structure']}/20 (" . round(($avgScores['url_structure']/20)*100) . "%)\n";
echo "  • Intent Clarity: {$avgScores['intent_clarity']}/20 (" . round(($avgScores['intent_clarity']/20)*100) . "%)\n";
echo "  • Content Depth: {$avgScores['content_depth']}/20 (" . round(($avgScores['content_depth']/20)*100) . "%)\n";
echo "  • Schema Markup: {$avgScores['schema_markup']}/20 (" . round(($avgScores['schema_markup']/20)*100) . "%)\n";
echo "  • Crawl Clarity: {$avgScores['crawl_clarity']}/20 (" . round(($avgScores['crawl_clarity']/20)*100) . "%)\n";
echo "  • Meta Optimization: {$avgScores['meta_optimization']}/20 (" . round(($avgScores['meta_optimization']/20)*100) . "%)\n\n";

echo "🎯 OVERALL SCORE: $overallAvg/20 (Grade: $overallGrade)\n";
echo "Overall Percentage: " . round(($overallAvg/20)*100) . "%\n\n";

// Recommendations
echo "💡 RECOMMENDATIONS:\n";
echo "===================\n";
if ($avgScores['url_structure'] < 15) {
    echo "⚠️  URL Structure: Improve URL naming and hierarchy\n";
}
if ($avgScores['intent_clarity'] < 15) {
    echo "⚠️  Intent Clarity: Strengthen H1 tags and title optimization\n";
}
if ($avgScores['content_depth'] < 15) {
    echo "⚠️  Content Depth: Increase word count to 900+ words per page\n";
}
if ($avgScores['schema_markup'] < 15) {
    echo "⚠️  Schema Markup: Add more comprehensive structured data\n";
}
if ($avgScores['crawl_clarity'] < 15) {
    echo "⚠️  Crawl Clarity: Ensure canonical tags and hreflang are present\n";
}
if ($avgScores['meta_optimization'] < 15) {
    echo "⚠️  Meta Optimization: Improve meta descriptions and social tags\n";
}

if ($overallAvg >= 18) {
    echo "✅ Excellent! Site is well-optimized for intent and crawl clarity\n";
} elseif ($overallAvg >= 15) {
    echo "✅ Good! Minor improvements recommended\n";
} elseif ($overallAvg >= 12) {
    echo "⚠️  Fair. Several areas need improvement\n";
} else {
    echo "❌ Needs significant improvement across multiple areas\n";
}
?>
