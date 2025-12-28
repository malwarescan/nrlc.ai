<?php
/**
 * Comprehensive QA for Case Study URLs
 * Tests: Meta titles, descriptions, H1, ontology, trust signals, SEO, content, intent alignment
 */

require_once __DIR__ . '/../lib/helpers.php';

$baseUrl = 'https://nrlc.ai';
$caseStudies = [
    'b2b-saas' => [
        'id' => 25,
        'industry' => 'B2B SaaS',
        'keywords' => ['B2B SaaS', 'SaaS', 'AI citations', 'structured data', 'entity mapping'],
        'expectedResults' => '340% increase in AI citations',
        'intent' => 'B2B SaaS companies looking for AI SEO case studies and proof of results'
    ],
    'ecommerce' => [
        'id' => 26,
        'industry' => 'E-commerce',
        'keywords' => ['E-commerce', 'product schema', 'AI visibility', 'online retail'],
        'expectedResults' => '250% increase in AI visibility',
        'intent' => 'E-commerce platforms seeking AI SEO optimization case studies'
    ],
    'healthcare' => [
        'id' => 27,
        'industry' => 'Healthcare',
        'keywords' => ['Healthcare', 'medical', 'AI citations', 'healthcare SEO', 'entity optimization'],
        'expectedResults' => '180% improvement in AI citation rates',
        'intent' => 'Healthcare organizations looking for medical SEO case studies'
    ],
    'fintech' => [
        'id' => 28,
        'industry' => 'Fintech',
        'keywords' => ['Fintech', 'financial services', 'compliance', 'AI mentions', 'financial SEO'],
        'expectedResults' => '290% increase in AI mentions',
        'intent' => 'Financial services companies seeking compliance-focused AI SEO case studies'
    ],
    'education' => [
        'id' => 29,
        'industry' => 'Education',
        'keywords' => ['Education', 'educational platform', 'academic content', 'AI citations'],
        'expectedResults' => '220% increase in AI citations',
        'intent' => 'Educational platforms looking for academic content optimization case studies'
    ],
    'real-estate' => [
        'id' => 30,
        'industry' => 'Real Estate',
        'keywords' => ['Real Estate', 'property', 'location-based', 'AI visibility', 'real estate SEO'],
        'expectedResults' => '160% improvement in AI visibility',
        'intent' => 'Real estate platforms seeking location-based SEO case studies'
    ]
];

$results = [];
$totalIssues = 0;
$criticalIssues = 0;

foreach ($caseStudies as $slug => $config) {
    echo "\n" . str_repeat('=', 80) . "\n";
    echo "QA: /case-studies/{$slug}/\n";
    echo str_repeat('=', 80) . "\n";
    
    $url = "{$baseUrl}/case-studies/{$slug}/";
    $urlEnUs = "{$baseUrl}/en-us/case-studies/{$slug}/";
    
    $pageResults = [
        'slug' => $slug,
        'url' => $url,
        'issues' => [],
        'warnings' => [],
        'passed' => []
    ];
    
    // Test 1: Fetch page content
    $ch = curl_init($urlEnUs);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; CaseStudyQA/1.0)');
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // curl_close() deprecated in PHP 8.5+ - not needed
    
    if ($httpCode !== 200) {
        $pageResults['issues'][] = "CRITICAL: HTTP {$httpCode} - Page not accessible";
        $criticalIssues++;
        $results[$slug] = $pageResults;
        continue;
    }
    
    if (empty($html)) {
        $pageResults['issues'][] = "CRITICAL: Empty response";
        $criticalIssues++;
        $results[$slug] = $pageResults;
        continue;
    }
    
    $pageResults['passed'][] = "Page accessible (HTTP 200)";
    
    // Test 2: Meta Title
    if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches)) {
        $title = trim(strip_tags($matches[1]));
        $titleLength = strlen($title);
        
        // Check title length (optimal: 50-60 chars, max: 65)
        if ($titleLength < 30) {
            $pageResults['issues'][] = "CRITICAL: Meta title too short ({$titleLength} chars) - Should be 50-60 chars";
            $criticalIssues++;
        } elseif ($titleLength > 65) {
            $pageResults['warnings'][] = "Meta title too long ({$titleLength} chars) - Should be 50-60 chars";
        } else {
            $pageResults['passed'][] = "Meta title length OK ({$titleLength} chars)";
        }
        
        // Check for industry keywords
        $titleLower = strtolower($title);
        $hasIndustryKeyword = false;
        foreach ($config['keywords'] as $keyword) {
            if (stripos($titleLower, strtolower($keyword)) !== false) {
                $hasIndustryKeyword = true;
                break;
            }
        }
        
        if (!$hasIndustryKeyword) {
            $pageResults['issues'][] = "CRITICAL: Meta title missing industry keywords - Should include: " . implode(', ', $config['keywords']);
            $criticalIssues++;
        } else {
            $pageResults['passed'][] = "Meta title contains industry keywords";
        }
        
        // Check for "Case Study" in title
        if (stripos($titleLower, 'case study') === false) {
            $pageResults['warnings'][] = "Meta title should include 'Case Study' for clarity";
        } else {
            $pageResults['passed'][] = "Meta title includes 'Case Study'";
        }
        
        // Check for brand
        if (stripos($titleLower, 'nrlc') === false && stripos($titleLower, 'neural command') === false) {
            $pageResults['warnings'][] = "Meta title should include brand name (NRLC.ai or Neural Command)";
        } else {
            $pageResults['passed'][] = "Meta title includes brand";
        }
        
        echo "✓ Title: {$title}\n";
    } else {
        $pageResults['issues'][] = "CRITICAL: No meta title found";
        $criticalIssues++;
    }
    
    // Test 3: Meta Description
    if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\'](.*?)["\']/is', $html, $matches)) {
        $description = trim($matches[1]);
        $descLength = strlen($description);
        
        // Check description length (optimal: 140-160 chars, max: 175)
        if ($descLength < 100) {
            $pageResults['issues'][] = "CRITICAL: Meta description too short ({$descLength} chars) - Should be 140-160 chars";
            $criticalIssues++;
        } elseif ($descLength > 175) {
            $pageResults['warnings'][] = "Meta description too long ({$descLength} chars) - Should be 140-160 chars";
        } else {
            $pageResults['passed'][] = "Meta description length OK ({$descLength} chars)";
        }
        
        // Check for results/metrics
        $descLower = strtolower($description);
        if (stripos($descLower, strtolower($config['expectedResults'])) === false) {
            $pageResults['warnings'][] = "Meta description should mention results: {$config['expectedResults']}";
        } else {
            $pageResults['passed'][] = "Meta description includes results";
        }
        
        // Check for industry keywords
        $hasIndustryKeyword = false;
        foreach ($config['keywords'] as $keyword) {
            if (stripos($descLower, strtolower($keyword)) !== false) {
                $hasIndustryKeyword = true;
                break;
            }
        }
        
        if (!$hasIndustryKeyword) {
            $pageResults['warnings'][] = "Meta description should include industry keywords";
        } else {
            $pageResults['passed'][] = "Meta description includes industry keywords";
        }
        
        echo "✓ Description: {$description}\n";
    } else {
        $pageResults['issues'][] = "CRITICAL: No meta description found";
        $criticalIssues++;
    }
    
    // Test 4: H1 Tag
    if (preg_match('/<h1[^>]*class=["\'][^"\']*content-block__title[^"\']*["\'][^>]*>(.*?)<\/h1>/is', $html, $matches)) {
        $h1 = trim(strip_tags($matches[1]));
        $h1Length = strlen($h1);
        
        // Check H1 length
        if ($h1Length < 10) {
            $pageResults['issues'][] = "CRITICAL: H1 too short ({$h1Length} chars)";
            $criticalIssues++;
        } elseif ($h1Length > 100) {
            $pageResults['warnings'][] = "H1 too long ({$h1Length} chars) - Should be concise";
        } else {
            $pageResults['passed'][] = "H1 length OK ({$h1Length} chars)";
        }
        
        // Check for industry keywords in H1
        $h1Lower = strtolower($h1);
        $hasIndustryKeyword = false;
        foreach ($config['keywords'] as $keyword) {
            if (stripos($h1Lower, strtolower($keyword)) !== false) {
                $hasIndustryKeyword = true;
                break;
            }
        }
        
        if (!$hasIndustryKeyword) {
            $pageResults['issues'][] = "CRITICAL: H1 missing industry keywords - Should include: " . implode(', ', $config['keywords']);
            $criticalIssues++;
        } else {
            $pageResults['passed'][] = "H1 contains industry keywords";
        }
        
        // Check for "Case Study" in H1
        if (stripos($h1Lower, 'case study') === false) {
            $pageResults['warnings'][] = "H1 should include 'Case Study' for clarity";
        } else {
            $pageResults['passed'][] = "H1 includes 'Case Study'";
        }
        
        echo "✓ H1: {$h1}\n";
    } else {
        $pageResults['issues'][] = "CRITICAL: No H1 tag found";
        $criticalIssues++;
    }
    
    // Test 5: Canonical URL
    if (preg_match('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\'](.*?)["\']/is', $html, $matches)) {
        $canonical = trim($matches[1]);
        $expectedCanonical = $urlEnUs;
        
        if ($canonical !== $expectedCanonical && $canonical !== $url) {
            $pageResults['warnings'][] = "Canonical URL mismatch - Expected: {$expectedCanonical}, Found: {$canonical}";
        } else {
            $pageResults['passed'][] = "Canonical URL correct";
        }
        
        // Check if canonical uses slug (not numeric ID)
        if (strpos($canonical, 'case-study-') !== false && strpos($canonical, $slug) === false) {
            $pageResults['issues'][] = "CRITICAL: Canonical URL uses numeric ID instead of semantic slug";
            $criticalIssues++;
        } else {
            $pageResults['passed'][] = "Canonical URL uses semantic slug";
        }
    } else {
        $pageResults['issues'][] = "CRITICAL: No canonical URL found";
        $criticalIssues++;
    }
    
    // Test 6: JSON-LD Schema
    if (preg_match('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $matches)) {
        $jsonLd = trim($matches[1]);
        $schema = json_decode($jsonLd, true);
        
        if ($schema === null) {
            $pageResults['issues'][] = "CRITICAL: Invalid JSON-LD schema";
            $criticalIssues++;
        } else {
            $pageResults['passed'][] = "JSON-LD schema is valid";
            
            // Check for required schema types
            $hasWebPage = false;
            $hasArticle = false;
            $hasBreadcrumb = false;
            $hasFAQ = false;
            
            if (is_array($schema)) {
                foreach ($schema as $item) {
                    if (isset($item['@type'])) {
                        if ($item['@type'] === 'WebPage') $hasWebPage = true;
                        if ($item['@type'] === 'Article') $hasArticle = true;
                        if ($item['@type'] === 'BreadcrumbList') $hasBreadcrumb = true;
                        if ($item['@type'] === 'FAQPage') $hasFAQ = true;
                    }
                }
            } elseif (isset($schema['@type'])) {
                if ($schema['@type'] === 'WebPage') $hasWebPage = true;
                if ($schema['@type'] === 'Article') $hasArticle = true;
                if ($schema['@type'] === 'BreadcrumbList') $hasBreadcrumb = true;
                if ($schema['@type'] === 'FAQPage') $hasFAQ = true;
            }
            
            if (!$hasWebPage) {
                $pageResults['issues'][] = "CRITICAL: Missing WebPage schema";
                $criticalIssues++;
            } else {
                $pageResults['passed'][] = "WebPage schema present";
            }
            
            if (!$hasArticle) {
                $pageResults['warnings'][] = "Should include Article schema for case studies";
            } else {
                $pageResults['passed'][] = "Article schema present";
            }
            
            if (!$hasBreadcrumb) {
                $pageResults['warnings'][] = "Should include BreadcrumbList schema";
            } else {
                $pageResults['passed'][] = "BreadcrumbList schema present";
            }
            
            if (!$hasFAQ) {
                $pageResults['warnings'][] = "Should include FAQPage schema if FAQs are present";
            } else {
                $pageResults['passed'][] = "FAQPage schema present";
            }
        }
    } else {
        $pageResults['warnings'][] = "No JSON-LD schema found";
    }
    
    // Test 7: Trust Signals
    // Check for author information
    if (stripos($html, 'joel maldonado') !== false || stripos($html, 'neural command') !== false) {
        $pageResults['passed'][] = "Author/company information present";
    } else {
        $pageResults['warnings'][] = "Should include author/company information for trust";
    }
    
    // Check for dates
    if (preg_match('/\b(20\d{2}|january|february|march|april|may|june|july|august|september|october|november|december)\b/i', $html)) {
        $pageResults['passed'][] = "Date information present";
    } else {
        $pageResults['warnings'][] = "Should include publication/update dates";
    }
    
    // Check for results/metrics in content
    if (stripos($html, strtolower($config['expectedResults'])) !== false) {
        $pageResults['passed'][] = "Results/metrics mentioned in content";
    } else {
        $pageResults['warnings'][] = "Should prominently display results: {$config['expectedResults']}";
    }
    
    // Test 8: Content Quality
    // Check for key sections
    $requiredSections = ['Challenge', 'Solution', 'Results'];
        foreach ($requiredSections as $section) {
            if (stripos($html, $section) !== false) {
                $pageResults['passed'][] = "Section '{$section}' present";
            } else {
                $pageResults['issues'][] = "CRITICAL: Missing required section '{$section}'";
                $criticalIssues++;
            }
        }
    
    // Check for CTA
    if (stripos($html, 'consultation') !== false || stripos($html, 'contact') !== false || stripos($html, 'get started') !== false) {
        $pageResults['passed'][] = "Call-to-action present";
    } else {
        $pageResults['warnings'][] = "Should include clear call-to-action";
    }
    
    // Test 9: Internal Links
    if (stripos($html, '/services/') !== false || stripos($html, '/insights/') !== false) {
        $pageResults['passed'][] = "Internal links present";
    } else {
        $pageResults['warnings'][] = "Should include internal links to services/insights";
    }
    
    // Test 10: Intent Alignment
    $intentKeywords = array_merge($config['keywords'], ['case study', 'ai seo', 'results', 'success']);
    $intentMatchCount = 0;
    $htmlLower = strtolower($html);
    foreach ($intentKeywords as $keyword) {
        if (stripos($htmlLower, strtolower($keyword)) !== false) {
            $intentMatchCount++;
        }
    }
    
    $intentMatchPercent = ($intentMatchCount / count($intentKeywords)) * 100;
    if ($intentMatchPercent < 50) {
        $pageResults['issues'][] = "CRITICAL: Low intent alignment ({$intentMatchPercent}%) - Content doesn't match expected intent";
        $criticalIssues++;
    } else {
        $pageResults['passed'][] = "Intent alignment OK ({$intentMatchPercent}%)";
    }
    
    // Test 11: Ontology - Check for industry-specific entities
    $ontologyTerms = [
        'b2b-saas' => ['saas', 'software', 'b2b', 'enterprise'],
        'ecommerce' => ['ecommerce', 'e-commerce', 'retail', 'products', 'shopping'],
        'healthcare' => ['healthcare', 'medical', 'health', 'patient', 'clinical'],
        'fintech' => ['fintech', 'financial', 'banking', 'payment', 'compliance'],
        'education' => ['education', 'educational', 'academic', 'learning', 'student'],
        'real-estate' => ['real estate', 'property', 'realty', 'location', 'geographic']
    ];
    
    if (isset($ontologyTerms[$slug])) {
        $ontologyMatchCount = 0;
        foreach ($ontologyTerms[$slug] as $term) {
            if (stripos($htmlLower, $term) !== false) {
                $ontologyMatchCount++;
            }
        }
        
        $ontologyMatchPercent = ($ontologyMatchCount / count($ontologyTerms[$slug])) * 100;
        if ($ontologyMatchPercent < 60) {
            $pageResults['warnings'][] = "Low ontology alignment ({$ontologyMatchPercent}%) - Should include more industry-specific terms";
        } else {
            $pageResults['passed'][] = "Ontology alignment OK ({$ontologyMatchPercent}%)";
        }
    }
    
    // Summary
    $issueCount = count($pageResults['issues']);
    $warningCount = count($pageResults['warnings']);
    $passCount = count($pageResults['passed']);
    
    echo "\n";
    echo "Results: {$passCount} passed, {$warningCount} warnings, {$issueCount} issues\n";
    
    if ($issueCount > 0) {
        echo "\nIssues:\n";
        foreach ($pageResults['issues'] as $issue) {
            echo "  ❌ {$issue}\n";
        }
    }
    
    if ($warningCount > 0) {
        echo "\nWarnings:\n";
        foreach ($pageResults['warnings'] as $warning) {
            echo "  ⚠️  {$warning}\n";
        }
    }
    
    $totalIssues += $issueCount;
    $results[$slug] = $pageResults;
}

// Final Summary
echo "\n" . str_repeat('=', 80) . "\n";
echo "FINAL SUMMARY\n";
echo str_repeat('=', 80) . "\n";
echo "Total Critical Issues: {$criticalIssues}\n";
echo "Total Issues: {$totalIssues}\n";
echo "\n";

foreach ($results as $slug => $result) {
    $status = count($result['issues']) > 0 ? '❌ FAIL' : (count($result['warnings']) > 0 ? '⚠️  WARN' : '✅ PASS');
    echo "{$status} /case-studies/{$slug}/ - " . count($result['issues']) . " issues, " . count($result['warnings']) . " warnings\n";
}

if ($criticalIssues === 0 && $totalIssues === 0) {
    echo "\n✅ ALL CASE STUDIES PASS QA\n";
    exit(0);
} else {
    echo "\n❌ QA FAILED - Fix issues before deployment\n";
    exit(1);
}

