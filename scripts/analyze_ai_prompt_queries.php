<?php
/**
 * AI Prompt-Like Query Analyzer and Router
 * 
 * Identifies queries that sound like prompts to AI systems and maps them
 * to the correct pages based on deterministic routing rules.
 */

require_once __DIR__.'/../lib/helpers.php';

$queriesFile = '/Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-28 (4)/Queries.csv';
$outputFile = __DIR__.'/../ai_prompt_like_queries_mapped.csv';

// Read queries CSV
$queries = [];
if (($handle = fopen($queriesFile, 'r')) !== false) {
    $header = fgetcsv($handle, 0, ',', '"', ''); // Skip header
    while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
        if (count($row) >= 5) {
            $queries[] = [
                'query' => trim($row[0]),
                'clicks' => (int)$row[1],
                'impressions' => (int)$row[2],
                'ctr' => $row[3],
                'position' => (float)$row[4]
            ];
        }
    }
    fclose($handle);
}

// City detection helper
function detect_city_in_query(string $query): ?string {
    // Common UK cities
    $ukCities = [
        'norwich', 'london', 'manchester', 'birmingham', 'leeds', 'sheffield', 
        'southampton', 'plymouth', 'leicester', 'coventry', 'hull', 'stoke-on-trent',
        'stoke on trent', 'wolverhampton', 'derby', 'swansea', 'southend-on-sea',
        'southend on sea', 'middlesbrough', 'peterborough', 'stockport', 'brighton',
        'west bromwich', 'blackpool', 'northampton', 'norwich', 'oldham', 'huddersfield',
        'burnley', 'southport', 'halifax', 'belfast', 'glasgow', 'edinburgh', 'cardiff',
        'newcastle', 'nottingham', 'southampton', 'plymouth', 'leicester', 'coventry'
    ];
    
    // US cities
    $usCities = [
        'new york', 'los angeles', 'chicago', 'houston', 'phoenix', 'philadelphia',
        'san antonio', 'san diego', 'dallas', 'san jose', 'austin', 'jacksonville',
        'fort worth', 'columbus', 'charlotte', 'san francisco', 'indianapolis', 'seattle',
        'denver', 'washington', 'boston', 'el paso', 'nashville', 'detroit', 'oklahoma city',
        'okc', 'portland', 'las vegas', 'memphis', 'louisville', 'baltimore', 'milwaukee',
        'albuquerque', 'tucson', 'fresno', 'sacramento', 'mesa', 'kansas city', 'atlanta',
        'long beach', 'colorado springs', 'raleigh', 'miami', 'virginia beach', 'omaha',
        'oakland', 'minneapolis', 'tulsa', 'arlington', 'tampa', 'new orleans', 'cleveland',
        'windsor', 'calgary', 'ottawa', 'edmonton', 'winnipeg', 'quebec city', 'hamilton',
        'kitchener', 'barrie', 'kelowna', 'oshawa', 'guelph', 'kingston', 'sherbrooke',
        'saskatoon', 'halifax', 'sudbury', 'abbotsford', 'victoria', 'whitehorse', 'yellowknife'
    ];
    
    $queryLower = strtolower($query);
    
    foreach (array_merge($ukCities, $usCities) as $city) {
        if (strpos($queryLower, $city) !== false) {
            return $city;
        }
    }
    
    return null;
}

// Industry detection
function detect_industry_in_query(string $query): ?string {
    $industries = [
        'contractor' => ['contractor', 'contractors', 'construction', 'home improvement'],
        'veterinary' => ['vet', 'veterinary', 'veterinarian', 'animal', 'pet'],
        'immigration' => ['immigration', 'visa', 'immigration consultancy'],
        'real estate' => ['real estate', 'realtor', 'property'],
        'private school' => ['private school', 'tutoring', 'education']
    ];
    
    $queryLower = strtolower($query);
    
    foreach ($industries as $industry => $keywords) {
        foreach ($keywords as $keyword) {
            if (strpos($queryLower, $keyword) !== false) {
                return $industry;
            }
        }
    }
    
    return null;
}

// Determine locale from city
function get_locale_for_city(?string $city): string {
    if (!$city) return 'en-us';
    
    $ukCities = [
        'norwich', 'london', 'manchester', 'birmingham', 'leeds', 'sheffield',
        'southampton', 'plymouth', 'leicester', 'coventry', 'hull', 'stoke-on-trent',
        'stoke on trent', 'wolverhampton', 'derby', 'swansea', 'southend-on-sea',
        'southend on sea', 'middlesbrough', 'peterborough', 'stockport', 'brighton',
        'west bromwich', 'blackpool', 'northampton', 'oldham', 'huddersfield',
        'burnley', 'southport', 'halifax', 'belfast', 'glasgow', 'edinburgh', 'cardiff',
        'newcastle', 'nottingham'
    ];
    
    $cityLower = strtolower($city);
    foreach ($ukCities as $ukCity) {
        if (strpos($cityLower, $ukCity) !== false || strpos($cityLower, str_replace('-', ' ', $ukCity)) !== false) {
            return 'en-gb';
        }
    }
    
    return 'en-us';
}

// Normalize city slug
function normalize_city_slug(?string $city): ?string {
    if (!$city) return null;
    return str_replace([' ', ' on ', ' on-'], ['-', '-', '-'], strtolower($city));
}

// Routing function
function route_ai_prompt_query(string $query): array {
    $queryLower = strtolower($query);
    $queryType = 'ai_prompt';
    $intentClass = '';
    $recommendedPage = '';
    $confidence = 'low';
    
    // Rule 1: "looking for / help me find / consultant / agency"
    if (preg_match('/\b(looking for|help me find|consultant|agency|service|companies)\b/i', $query)) {
        $city = detect_city_in_query($query);
        $industry = detect_industry_in_query($query);
        
        if ($industry && $city) {
            $locale = get_locale_for_city($city);
            $intentClass = 'hire_recommendation';
            $recommendedPage = "https://nrlc.ai/{$locale}/ai-visibility/{$industry}/";
            $confidence = 'high';
        } elseif ($industry) {
            $intentClass = 'hire_recommendation';
            $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/{$industry}/";
            $confidence = 'high';
        } elseif ($city) {
            $locale = get_locale_for_city($city);
            $citySlug = normalize_city_slug($city);
            $intentClass = 'local_hire';
            $recommendedPage = "https://nrlc.ai/{$locale}/services/local-seo-ai/{$citySlug}/";
            $confidence = 'high';
        } else {
            $intentClass = 'hire_recommendation';
            $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/";
            $confidence = 'medium';
        }
    }
    // Rule 2: "what agencies specialize in / best agencies / companies"
    elseif (preg_match('/\b(what agencies|which agencies|best agencies|companies that specialize|agencies specialize|search engine.*companies|seo.*companies)\b/i', $query)) {
        if (preg_match('/\b(schema|schema markup|enterprise.*schema|json-ld|structured data)\b/i', $query)) {
            $intentClass = 'agency_evaluation';
            $recommendedPage = "https://nrlc.ai/en-us/services/enterprise-schema-markup/";
            $confidence = 'high';
        } else {
            // For "companies" queries, check if there's a city - if so, route to local page
            $city = detect_city_in_query($query);
            if ($city) {
                $locale = get_locale_for_city($city);
                $citySlug = normalize_city_slug($city);
                $intentClass = 'local_hire';
                $recommendedPage = "https://nrlc.ai/{$locale}/services/local-seo-ai/{$citySlug}/";
                $confidence = 'high';
            } else {
                $intentClass = 'agency_comparison';
                $recommendedPage = "https://nrlc.ai/en-gb/insights/enterprise-schema-agencies/";
                $confidence = 'medium';
            }
        }
    }
    // Rule 3: "how / what is / does ai"
    elseif (preg_match('/\b(how|what is|what does|how does|how to|explain|what are)\b/i', $query)) {
        if (preg_match('/\b(ai visibility|ai search|ai optimization)\b/i', $query)) {
            $intentClass = 'explanatory';
            $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/";
            $confidence = 'high';
        } elseif (preg_match('/\b(llm|llm strategist|llm optimization)\b/i', $query)) {
            $intentClass = 'explanatory';
            $recommendedPage = "https://nrlc.ai/en-gb/insights/glossary/llm-strategist/";
            $confidence = 'high';
        } else {
            $intentClass = 'explanatory';
            $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/";
            $confidence = 'medium';
        }
    }
    // Rule 4: Location + service prompts
    elseif (preg_match('/\b(near me|in [a-z]+|service|services)\b/i', $query)) {
        $city = detect_city_in_query($query);
        if ($city) {
            $locale = get_locale_for_city($city);
            $citySlug = normalize_city_slug($city);
            $intentClass = 'local_hire';
            $recommendedPage = "https://nrlc.ai/{$locale}/services/local-seo-ai/{$citySlug}/";
            $confidence = 'high';
        } else {
            $intentClass = 'hire_recommendation';
            $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/";
            $confidence = 'medium';
        }
    }
    // Rule 5: Tool / API / implementation queries
    elseif (preg_match('/\b(api|tracking|implementation|schema markup|json-ld|structured data|tool|tools)\b/i', $query)) {
        if (preg_match('/\b(enterprise|enterprise-level|large-scale)\b/i', $query)) {
            $intentClass = 'tool_or_service_lookup';
            $recommendedPage = "https://nrlc.ai/en-us/services/enterprise-schema-markup/";
            $confidence = 'high';
        } else {
            $intentClass = 'tool_or_service_lookup';
            $recommendedPage = "https://nrlc.ai/en-us/services/json-ld-strategy/";
            $confidence = 'medium';
        }
    }
    // Special cases
    elseif (preg_match('/\b(chatgpt|perplexity|copilot|claude|bard|ai overview)\b/i', $query)) {
        $city = detect_city_in_query($query);
        if ($city) {
            $locale = get_locale_for_city($city);
            $citySlug = normalize_city_slug($city);
            $intentClass = 'local_hire';
            $recommendedPage = "https://nrlc.ai/{$locale}/services/local-seo-ai/{$citySlug}/";
            $confidence = 'medium';
        } else {
            $intentClass = 'hire_recommendation';
            $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/";
            $confidence = 'medium';
        }
    }
    // Default fallback
    else {
        $intentClass = 'general';
        $recommendedPage = "https://nrlc.ai/en-us/ai-visibility/";
        $confidence = 'low';
    }
    
    return [
        'query' => $query,
        'query_type' => $queryType,
        'intent_class' => $intentClass,
        'recommended_page' => $recommendedPage,
        'confidence' => $confidence
    ];
}

// Filter for prompt-like queries
function is_prompt_like(string $query): bool {
    $queryLower = strtolower($query);
    
    // Patterns that indicate AI prompt-like queries
    $promptPatterns = [
        '/\b(looking for|help me find|find me|need|want|searching for)\b/i',
        '/\b(what|which|who|how|where|when|why)\b.*\b(agencies|companies|services|consultants|experts)\b/i',
        '/\b(near me|in [a-z]+|service|services)\b/i',
        '/\b(how|what is|what does|how does|how to|explain)\b.*\b(ai|llm|seo|visibility)\b/i',
        '/\b(api|tracking|implementation|schema|json-ld|tool|tools)\b/i',
        '/\b(chatgpt|perplexity|copilot|claude|bard|ai overview)\b/i',
        '/\b(best|top|leading|specialize|specializes)\b.*\b(agencies|companies|services)\b/i',
        '/\b(get a quote|get quote|quote for)\b/i',
        '/\b(are there|is there|can you|do you)\b/i',
        '/\b(search engine.*companies|seo.*companies|companies.*derby|companies.*norwich)\b/i',
        '/\b(how does|how do|how can|how will)\b/i'
    ];
    
    foreach ($promptPatterns as $pattern) {
        if (preg_match($pattern, $query)) {
            return true;
        }
    }
    
    return false;
}

// Process queries
$mappedQueries = [];
foreach ($queries as $queryData) {
    $query = $queryData['query'];
    
    // Skip empty queries
    if (empty($query)) continue;
    
    // Only process prompt-like queries
    if (is_prompt_like($query)) {
        $mapped = route_ai_prompt_query($query);
        $mappedQueries[] = $mapped;
    }
}

// Write output CSV
$output = fopen($outputFile, 'w');
fputcsv($output, ['query', 'query_type', 'intent_class', 'recommended_page', 'confidence']);

foreach ($mappedQueries as $mapped) {
    fputcsv($output, [
        $mapped['query'],
        $mapped['query_type'],
        $mapped['intent_class'],
        $mapped['recommended_page'],
        $mapped['confidence']
    ], ',', '"', '');
}

fclose($output);

echo "Processed " . count($queries) . " queries\n";
echo "Identified " . count($mappedQueries) . " AI prompt-like queries\n";
echo "Output written to: $outputFile\n";

// Print summary by intent class
$summary = [];
foreach ($mappedQueries as $mapped) {
    $intent = $mapped['intent_class'];
    if (!isset($summary[$intent])) {
        $summary[$intent] = 0;
    }
    $summary[$intent]++;
}

echo "\nSummary by intent class:\n";
foreach ($summary as $intent => $count) {
    echo "  $intent: $count\n";
}

