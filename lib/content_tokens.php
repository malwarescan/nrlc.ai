<?php
declare(strict_types=1);
require_once __DIR__.'/helpers.php';
require_once __DIR__.'/deterministic.php';
require_once __DIR__.'/csv.php';

// Cache for CSV data to avoid repeated file reads
$csv_cache = [];

function csv_rows_local(string $file): array { 
  global $csv_cache;
  if (!isset($csv_cache[$file])) {
    $csv_cache[$file] = csv_read_data($file);
  }
  return $csv_cache[$file];
}
function titleCaseCity(string $slug): string { return ucwords(str_replace(['-','_'],' ',$slug)); }

function service_long_intro(string $service, string $city): string {
  $s = ucfirst(str_replace('-',' ', $service));
  $c = titleCaseCity($city);
  $alts = [
    "Our $s program in $c aligns crawl clarity, schema depth, and human readability—so both search engines and LLMs can trust your pages.",
    "In $c, $s wins when duplicates are removed, entities are explicit, and structured data is complete—we engineer exactly that.",
    "$s in $c demands clean signals: canonical discipline, JSON-LD depth, and content that answers unambiguously.",
  ];
  det_seed("$service|$city|intro");
  return det_pick($alts, 1)[0];
}

function local_context_block(string $city): string {
  det_seed("local|$city");
  $c = titleCaseCity($city);
  $alts = [
    "Local infrastructure in $c often creates querystring noise (tracking params, session IDs); we neutralize it without harming UX.",
    "User behavior in $c rewards precise location-anchored entities. We encode that clarity in copy and JSON-LD for each page.",
    "ISPs/CDNs common in $c can duplicate paths via trailing slashes and case—our canonical guard consolidates them predictably.",
  ];
  return det_pick($alts, 1)[0];
}

function local_market_insights(string $city): string {
  det_seed("market|$city");
  $c = titleCaseCity($city);
  
  $marketData = [
    'New York' => [
      'industries' => 'finance, technology, media, and real estate',
      'challenges' => 'high competition, complex local regulations, and diverse user demographics',
      'opportunities' => 'enterprise clients, international businesses, and AI-first innovation hubs'
    ],
    'London' => [
      'industries' => 'financial services, fintech, consulting, and creative industries',
      'challenges' => 'GDPR compliance, multilingual content, and European market penetration',
      'opportunities' => 'EU market access, financial technology leadership, and AI research centers'
    ],
    'San Francisco' => [
      'industries' => 'technology, startups, venture capital, and software development',
      'challenges' => 'rapid technological change, high talent costs, and intense competition',
      'opportunities' => 'cutting-edge AI adoption, early-stage companies, and innovation partnerships'
    ],
    'Toronto' => [
      'industries' => 'technology, finance, healthcare, and professional services',
      'challenges' => 'bilingual requirements, seasonal variations, and cross-border regulations',
      'opportunities' => 'North American market access, skilled workforce, and AI research initiatives'
    ]
  ];
  
  $data = $marketData[$c] ?? $marketData['New York'];
  
  // REMOVED H3 - template provides H2 "Local Market Insights", this is just content
  return "<div class=\"box-padding\">
    <p><strong>$c Market Dynamics:</strong> Local businesses operate within a competitive landscape dominated by {$data['industries']}, requiring sophisticated optimization strategies that address {$data['challenges']} while capitalizing on {$data['opportunities']}.</p>
    <p>Regional search behaviors, local entity recognition patterns, and market-specific AI engine preferences drive measurable improvements in citation rates and organic visibility.</p>
  </div>";
}

function local_competition_analysis(string $city): string {
  det_seed("competition|$city");
  $c = titleCaseCity($city);
  
  $competitionInsights = [
    'New York' => 'enterprise-level competition with sophisticated technical implementations and significant resources',
    'London' => 'established financial services sector with traditional SEO approaches transitioning to AI-first strategies',
    'San Francisco' => 'technology-forward companies with early AI adoption but often lacking systematic SEO foundations',
    'Toronto' => 'mixed landscape of traditional businesses and emerging tech companies seeking competitive advantages'
  ];
  
  $insight = $competitionInsights[$c] ?? $competitionInsights['New York'];
  
  // REMOVED H3 - template provides H2 "Competitive Landscape", this is just content
  return "<div class=\"box-padding\">
    <p>The market in $c features {$insight}. Systematic crawl clarity, comprehensive structured data, and LLM seeding strategies outperform traditional SEO methods.</p>
    <p>Analysis of local competitor implementations identifies optimization gaps and leverages the GEO-16 framework to achieve superior AI engine visibility and citation performance.</p>
  </div>";
}

function local_implementation_strategy(string $city): string {
  det_seed("strategy|$city");
  $c = titleCaseCity($city);
  
  return "<div class=\"box-padding\">
    <h3 style=\"margin-top: 0; color: #000080;\">Localized Implementation Strategy</h3>
    <p>Global AI-first SEO best practices combined with local market intelligence. Comprehensive crawl clarity analysis identifies city-specific technical issues that impact AI engine comprehension and citation likelihood.</p>
    <p>Localized entity optimization, region-specific schema implementation, and content architecture designed for market preferences and AI engine behaviors. Compliance with local regulations while maximizing international visibility through proper hreflang implementation and multi-regional optimization.</p>
    <p>Success metrics tailored to market conditions track both traditional search performance and AI engine citation improvements across major platforms including ChatGPT, Claude, Perplexity, and emerging AI search systems.</p>
  </div>";
}

/** Rich paragraph generator per pain point to increase word count meaningfully. SEO-first content. */
function expand_pain_point(array $p, string $city): string {
  $h = htmlspecialchars($p['headline'] ?? 'Issue');
  $problem = htmlspecialchars($p['problem'] ?? '');
  $impact  = htmlspecialchars($p['impact'] ?? '');
  $solution= htmlspecialchars($p['solution'] ?? '');
  $deliver = htmlspecialchars($p['deliverables'] ?? '');
  $metric  = htmlspecialchars($p['metric'] ?? '');
  $c = htmlspecialchars(titleCaseCity($city));
  $serviceName = htmlspecialchars(ucfirst(str_replace('-', ' ', $p['service'] ?? '')));

  // SEO-first content with keywords
  $para1 = "<p><strong>Problem:</strong> {$problem} In {$c}, this SEO issue typically surfaces as crawl budget waste, duplicate content indexing, and URL canonicalization conflicts that compete for the same search queries and dilute ranking signals.</p>";
  $para2 = "<p><strong>Impact on SEO:</strong> {$impact} Our AI SEO audits in {$c} usually find wasted crawl budget on parameterized URLs, mixed-case aliases, and duplicate content that never converts. This directly impacts AI engine visibility, structured data recognition, and citation accuracy across ChatGPT, Claude, and Perplexity.</p>";
  $para3 = "<p><strong>AI SEO Solution:</strong> {$solution} We implement comprehensive technical SEO improvements including structured data optimization, entity mapping, and canonical enforcement. Our approach ensures AI engines can properly crawl, index, and cite your content. <em>Deliverables:</em> {$deliver}. <em>Expected SEO result:</em> {$metric}.</p>";

  $list = "<ul class=\"small\"><li>Before/After sitemap analysis and crawl efficiency metrics</li><li>Search Console coverage & discovered URLs trend tracking</li><li>Parameter allowlist vs. strip rules for canonical URLs</li><li>Structured data validation and rich results testing</li><li>Canonical and hreflang implementation verification</li><li>AI engine citation accuracy monitoring</li></ul>";
  // FIXED: Return only the content, not a full content-block structure
  // The template already provides the content-block wrapper and H2 heading
  return "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">$h</h3>$para1$para2$para3$list</div>";
}

function pain_points_for_service(string $service): array {
  $rows = csv_rows_local('painpoint_token_map.csv');
  return array_values(array_filter($rows, fn($r) => ($r['service'] ?? '') === $service));
}

function pain_point_section(string $service, string $city, int $count = 4): string {
  $pps = pain_points_for_service($service);
  if (!$pps) return '';
  det_seed("$service|$city|pain");
  $pick = det_pick($pps, min($count, max(1, count($pps))));
  $out = [];
  foreach ($pick as $p) { $out[] = expand_pain_point($p, $city); }
  
  // Add governance section for content depth
  $c = htmlspecialchars(titleCaseCity($city));
  $out[] = "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">Governance & Monitoring</h3>"
         ."<p>We operationalize ongoing checks: URL guards, schema validation, and crawl-stat alarms so improvements persist in {$c}.</p>"
         ."<ul class=\"small\"><li>Daily diffs of sitemaps and canonicals</li><li>Param drift alerts</li><li>Rich results coverage trends</li><li>LLM citation accuracy tracking</li></ul></div>";
  
  // FIXED: Return content only, template provides wrapper
  return implode("\n", $out);
}

function approach_section(string $service, string $city = ''): string {
  $rows = csv_rows_local('approach_blocks.csv');
  $blocks = array_values(array_filter($rows, fn($r)=>($r['service']??'')===$service));
  $c = $city ? titleCaseCity($city) : '';
  det_seed("approach|$service" . ($city ? "|$city" : ''));
  $pick = det_pick($blocks, max(2, min(3, count($blocks))));
  $out=[];
  foreach ($pick as $b) {
    $body = htmlspecialchars($b['body']);
    // Inject city context if available (only replace first occurrence)
    if ($city && stripos($body, $c) === false) {
      $body = preg_replace('/\. /', " in {$c}. ", $body, 1);
    }
    $out[] = "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">".htmlspecialchars($b['block_title'])."</h3><p>{$body}</p></div>";
  }
  
  // META KERNEL DIRECTIVE: Step-by-step process section
  $cityContext = $city ? " in {$c}" : '';
  $processSteps = [
    [
      'title' => 'Step 1: Discovery & Baseline Analysis',
      'description' => "We begin by analyzing your current technical infrastructure, crawl logs, Search Console data, and existing schema implementations. In this phase{$cityContext}, we identify URL canonicalization issues, duplicate content patterns, structured data gaps, and entity clarity problems that impact AI engine visibility."
    ],
    [
      'title' => 'Step 2: Strategy Design & Technical Planning',
      'description' => "Based on the baseline analysis{$cityContext}, we design a comprehensive optimization strategy that addresses crawl efficiency, schema completeness, entity clarity, and citation accuracy. This includes URL normalization rules, canonical implementation plans, structured data enhancement strategies, and local market optimization approaches tailored to your specific service and geographic context."
    ],
    [
      'title' => 'Step 3: Implementation & Deployment',
      'description' => "We systematically implement the designed improvements, starting with high-impact technical fixes like URL canonicalization, then moving to structured data enhancements, entity optimization, and content architecture improvements. Each change is tested and validated before deployment to ensure no disruptions to existing functionality or user experience."
    ],
    [
      'title' => 'Step 4: Validation & Monitoring',
      'description' => "After implementation{$cityContext}, we rigorously test all changes, validate schema markup, verify canonical behavior, and establish monitoring systems. We track crawl efficiency metrics, structured data performance, AI engine citation accuracy, and traditional search rankings to measure improvement and identify any issues."
    ],
    [
      'title' => 'Step 5: Iterative Optimization & Reporting',
      'description' => "Ongoing optimization involves continuous monitoring, iterative improvements based on performance data, and adaptation to evolving AI engine requirements. We provide regular reporting on citation accuracy, crawl efficiency, visibility metrics, and business outcomes, ensuring you understand exactly how technical improvements translate to real business results{$cityContext}."
    ]
  ];
  
  $out[] = "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">Step-by-Step Service Delivery</h3>";
  foreach ($processSteps as $idx => $step) {
    $out[] = "<div style=\"margin-bottom: 1.5rem;\"><h4 style=\"margin-top: 0; color: #333;\">{$step['title']}</h4><p>{$step['description']}</p></div>";
  }
  $out[] = "</div>";
  
  return implode("\n", $out);
}

function why_this_matters_section(string $service, string $city): string {
  $s = ucfirst(str_replace('-', ' ', $service));
  $c = titleCaseCity($city);
  det_seed("why|$service|$city");
  
  $reasons = [
    [
      'title' => 'AI Engines Require Perfect Structure',
      'body' => "Large language models and AI search engines like ChatGPT, Claude, and Perplexity don't guess—they parse. When your $s implementation in $c has ambiguous entities, missing schema, or duplicate URLs, AI engines skip your content or cite competitors instead. We eliminate every structural barrier that prevents AI comprehension."
    ],
    [
      'title' => 'Citation Accuracy Drives Business Results',
      'body' => "Being mentioned isn't enough—you need accurate citations with correct URLs, current information, and proper attribution. Our $s service in $c ensures AI engines cite your brand correctly, link to the right pages, and present up-to-date information that drives qualified traffic and conversions."
    ],
    [
      'title' => 'Traditional SEO Misses AI-Specific Signals',
      'body' => "Keyword optimization and backlinks matter, but AI engines prioritize different signals: entity clarity, semantic structure, verification signals, and metadata completeness. Our $s approach in $c addresses the GEO-16 framework pillars that determine AI citation success, going beyond traditional SEO metrics."
    ],
    [
      'title' => 'Technical Debt Compounds Over Time',
      'body' => "Every parameter-polluted URL, every inconsistent schema implementation, every ambiguous entity reference makes your site harder for AI engines to understand. In $c, where competition is fierce and technical complexity is high, accumulated technical debt can cost you thousands of potential citations. We systematically eliminate this debt."
    ]
  ];
  
  $selected = det_pick($reasons, 2);
  $out = [];
  foreach ($selected as $reason) {
    $out[] = "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">{$reason['title']}</h3><p>{$reason['body']}</p></div>";
  }
  
  return implode("\n", $out);
}

function implementation_timeline_section(string $city): string {
  $c = titleCaseCity($city);
  return "<p>Our typical engagement in {$c} follows a structured four-phase approach designed to deliver measurable improvements quickly while building sustainable optimization practices:</p>
    <p><strong>Phase 1: Discovery & Audit (Week 1-2)</strong> — Comprehensive technical audit covering crawl efficiency, schema completeness, entity clarity, and AI engine visibility. We analyze your current state across all GEO-16 framework pillars and identify quick wins alongside strategic opportunities.</p>
    <p><strong>Phase 2: Implementation & Optimization (Week 3-6)</strong> — Systematic implementation of recommended improvements, including URL normalization, schema enhancement, content optimization, and technical infrastructure updates. Each change is tested and validated before deployment.</p>
    <p><strong>Phase 3: Validation & Monitoring (Week 7-8)</strong> — Rigorous testing of all implementations, establishment of monitoring systems, and validation of improvements through crawl analysis, rich results testing, and AI engine citation tracking.</p>
    <p><strong>Phase 4: Ongoing Optimization (Month 3+)</strong> — Continuous monitoring, iterative improvements, and adaptation to evolving AI engine requirements. Regular reporting on citation accuracy, crawl efficiency, and visibility metrics.</p>";
}

function success_metrics_section(string $service, string $city): string {
  $s = ucfirst(str_replace('-', ' ', $service));
  $c = titleCaseCity($city);
  return "<p>We measure $s success in {$c} through comprehensive tracking across multiple dimensions. Every engagement includes baseline measurement, ongoing monitoring, and detailed reporting so you can see exactly how improvements translate to business outcomes.</p>
    <p><strong>Crawl Efficiency Metrics:</strong> We track crawl budget utilization, discovered URL counts, sitemap coverage rates, and duplicate URL elimination. In {$c}, our clients typically see 35-60% reductions in crawl waste within the first month of implementation.</p>
    <p><strong>AI Engine Visibility:</strong> We monitor citation accuracy across ChatGPT, Claude, Perplexity, and other AI platforms. This includes tracking brand mentions, URL accuracy in citations, fact correctness, and citation frequency. Improvements in these metrics directly correlate with increased qualified traffic and brand authority.</p>
    <p><strong>Structured Data Performance:</strong> Rich results impressions, FAQ snippet appearances, and schema validation status are tracked weekly. We monitor Google Search Console for structured data errors and opportunities, ensuring your schema implementations deliver maximum visibility benefits.</p>
    <p><strong>Technical Health Indicators:</strong> Core Web Vitals, mobile usability scores, HTTPS implementation, canonical coverage, and hreflang accuracy are continuously monitored. These foundational elements ensure sustainable AI engine optimization and prevent technical regression.</p>";
}

function faq_block(string $service, string $city, int $count = 6): string {
  $rows = csv_rows_local('faq_pools.csv');
  $pool = array_values(array_filter($rows, fn($r)=>($r['service']??'')===$service));
  if (!$pool) return '';
  det_seed("faq|$service|$city");
  $pick = det_pick($pool, min($count, max(3, count($pool))));
  $out = ["<div class=\"grid\" style=\"gap:4px\">"];
  foreach ($pick as $qa) {
    $q = htmlspecialchars($qa['question']); $a = htmlspecialchars($qa['answer']);
    $out[] = "<details class=\"card\"><summary><strong>$q</strong></summary><p class=\"small muted\">$a</p></details>";
  }
  $out[]="</div>";
  return implode("\n", $out);
}

function word_count_html(string $html): int {
  $text = trim(strip_tags(preg_replace('/\s+/',' ', $html)));
  return $text ? str_word_count($text) : 0;
}

/**
 * META KERNEL DIRECTIVE: Service Overview Section (~150 words)
 * Explains what the service is and why it matters in THIS city
 */
function service_overview_section(string $service, string $city, ?array $cityRow = null): string {
  $s = ucfirst(str_replace('-', ' ', $service));
  $c = titleCaseCity($city);
  det_seed("overview|$service|$city");
  
  // Get city-specific context for uniqueness vectors
  $subdivision = $cityRow['subdivision'] ?? '';
  $country = $cityRow['country'] ?? 'US';
  $lat = $cityRow['lat'] ?? null;
  $lng = $cityRow['lng'] ?? null;
  
  // Build city context for uniqueness (UNIQUENESS VECTOR 1: Geographic specificity)
  $cityContext = $c;
  $regionContext = '';
  if ($subdivision) {
    $cityContext .= ", {$subdivision}";
    $regionContext = " in {$subdivision}";
  }
  
  // UNIQUENESS VECTOR 2: Market-specific challenges based on subdivision/country
  $marketContext = '';
  if ($country === 'GB') {
    $marketContext = "GDPR compliance, European market penetration, and UK-specific search behaviors";
  } elseif ($subdivision === 'CA') {
    $marketContext = "bilingual content requirements, cross-border regulations, and California-specific business compliance";
  } elseif ($subdivision === 'NY') {
    $marketContext = "high competition density, enterprise-level technical requirements, and New York-specific market dynamics";
  } else {
    $marketContext = "regional search behavior patterns, local business competition, and market-specific optimization needs";
  }
  
  // UNIQUENESS VECTOR 3: City-specific usage patterns (inferred from location)
  $usagePattern = '';
  if (($lat && $lat > 40.5 && $lat < 41.0) || stripos($c, 'New York') !== false) {
    $usagePattern = "dense urban search patterns, mobile-first user behavior, and rapid information retrieval needs";
  } elseif ($country === 'GB') {
    $usagePattern = "European AI engine preferences, UK-specific citation patterns, and cross-platform visibility requirements";
  } else {
    $usagePattern = "local search intent patterns, regional AI engine behaviors, and city-specific user expectations";
  }
  
  $overviews = [
    "$s is a comprehensive AI-first SEO optimization service that ensures your business appears accurately in AI-powered search engines like ChatGPT, Claude, and Perplexity. In {$cityContext}, where {$marketContext} create unique challenges for traditional SEO, our $s service addresses entity clarity, structured data completeness, and citation accuracy—three pillars that determine whether AI systems recommend your brand when users ask location-specific questions. The {$usagePattern} in {$c} require technical implementations that go beyond keyword optimization.",
    
    "When businesses in {$c} need $s, they're typically facing a critical visibility gap: traditional search rankings don't translate to AI engine recommendations. Large language models require perfectly structured entities, unambiguous location signals, and comprehensive schema markup. {$cityContext} businesses must navigate {$marketContext}, which makes technical SEO foundation critical. Our $s implementation transforms technical SEO debt into AI engine authority, ensuring your brand gets cited correctly with accurate URLs, current information, and proper attribution—especially important given {$c}'s {$usagePattern}.",
    
    "$s in {$cityContext} isn't just about rankings—it's about being discoverable when users ask AI assistants for recommendations. AI engines parse your structured data, evaluate entity relationships, and determine citation trustworthiness. The {$marketContext} in {$c} means businesses need more sophisticated optimization than generic SEO templates. Our $s service ensures every signal AI engines need is present: canonical URLs, location-anchored entities, verification signals, and metadata completeness. Given {$c}'s {$usagePattern}, this technical foundation determines whether AI systems cite you or competitors."
  ];
  
  $selected = det_pick($overviews, 1)[0];
  return "<p>{$selected}</p>";
}

/**
 * META KERNEL DIRECTIVE: Pricing Section
 * City-adjusted pricing with transparent ranges
 */
function pricing_section(string $service, string $city, ?array $cityRow = null): string {
  $s = ucfirst(str_replace('-', ' ', $service));
  $c = titleCaseCity($city);
  det_seed("pricing|$service|$city");
  
  $country = $cityRow['country'] ?? 'US';
  $isUK = ($country === 'GB');
  
  // Determine pricing based on service type and location
  $isAudit = strpos($service, 'audit') !== false || strpos($service, 'site-audits') !== false;
  
  if ($isAudit) {
    $priceRange = $isUK ? '£3,500 to £18,000' : '$4,500 to $23,000';
    $currency = $isUK ? 'GBP' : 'USD';
    $currencySymbol = $isUK ? '£' : '$';
  } else {
    // General service pricing
    $priceRange = $isUK ? '£2,500 to £12,000' : '$3,500 to $15,000';
    $currency = $isUK ? 'GBP' : 'USD';
    $currencySymbol = $isUK ? '£' : '$';
  }
  
  $factors = [
    'site architecture complexity',
    'number of service locations',
    'current technical SEO debt level',
    'scale of structured data implementation needed',
    'AI engine visibility goals',
    'local market competition intensity'
  ];
  
  det_seed("pricing|factors|$service|$city");
  $selectedFactors = det_pick($factors, 3);
  $factorsText = implode(', ', array_slice($selectedFactors, 0, -1)) . ', and ' . end($selectedFactors);
  
  $content = "<div class=\"box-padding\">";
  // REMOVED H3 - template now provides H2 wrapper
  $content .= "<p>Our {$s} engagements in {$c} typically range from <strong>{$priceRange}</strong>, depending on scope, complexity, and desired outcomes. Pricing is influenced by {$factorsText}.</p>";
  
  if ($isAudit) {
    $content .= "<p>Audit and diagnostic work focuses on interpretation, decision clarity, and actionable recommendations—not automated scans or generic checklists. If you're seeking a low-cost automated report, this engagement model may not be the right fit.</p>";
  } else {
    $content .= "<p>Implementation costs reflect the depth of technical work required: URL normalization, schema enhancement, entity optimization, and AI engine citation readiness. We provide detailed proposals with clear scope, deliverables, and expected outcomes before engagement begins.</p>";
  }
  
  $content .= "<p>Every engagement includes baseline measurement, ongoing monitoring during implementation, and detailed reporting so you can see exactly how improvements translate to business outcomes. <strong>Contact us for a customized proposal for {$s} in {$c}.</strong></p>";
  $content .= "</div>";
  
  return $content;
}

/**
 * META KERNEL DIRECTIVE: Service Area Coverage Section
 * Lists neighborhoods/areas or describes geographic coverage
 */
function service_area_coverage_section(string $city, ?array $cityRow = null): string {
  $c = titleCaseCity($city);
  det_seed("coverage|$city");
  
  // Get city data for coverage
  $subdivision = $cityRow['subdivision'] ?? '';
  $country = $cityRow['country'] ?? 'US';
  
  // Generate city-specific neighborhoods/areas based on common patterns
  // This can be enhanced later with actual neighborhood data
  $majorCities = [
    'New York' => ['Manhattan', 'Brooklyn', 'Queens', 'Bronx', 'Staten Island'],
    'Los Angeles' => ['Downtown LA', 'Hollywood', 'Santa Monica', 'Pasadena', 'Long Beach'],
    'Chicago' => ['Loop', 'River North', 'Lincoln Park', 'Wicker Park', 'Lakeview'],
    'London' => ['Westminster', 'Camden', 'Islington', 'Hackney', 'Tower Hamlets'],
    'San Francisco' => ['Financial District', 'Mission District', 'SOMA', 'Castro', 'Pacific Heights'],
    'Houston' => ['Downtown', 'Montrose', 'Heights', 'Galleria', 'Medical Center'],
    'Dallas' => ['Downtown', 'Deep Ellum', 'Uptown', 'Oak Lawn', 'Bishop Arts'],
    'Boston' => ['Downtown', 'Back Bay', 'Cambridge', 'Somerville', 'Charlestown'],
    'Seattle' => ['Downtown', 'Capitol Hill', 'Ballard', 'Fremont', 'Queen Anne']
  ];
  
  $neighborhoods = $majorCities[$c] ?? [];
  
  if (!empty($neighborhoods)) {
    $neighborhoodList = implode(', ', array_slice($neighborhoods, 0, -1)) . ', and ' . end($neighborhoods);
    $content = "<div class=\"box-padding\">";
    $content .= "<h3 style=\"margin-top: 0; color: #000080;\">Service Area Coverage in {$c}</h3>";
    $content .= "<p>We provide AI-first SEO services throughout {$c} and surrounding areas, including {$neighborhoodList}. Our approach is tailored to local market dynamics and search behavior patterns specific to each neighborhood and business district.</p>";
    $content .= "<p>Whether your business serves a specific {$c} neighborhood or operates across multiple areas, our {$c}-based optimization strategies ensure maximum visibility in both traditional search results and AI-powered search engines. Geographic relevance signals, local entity optimization, and neighborhood-specific content strategies all contribute to improved AI engine citation accuracy.</p>";
    $content .= "<p><strong>Ready to improve your AI engine visibility in {$c}?</strong> Contact us to discuss your specific location and service needs.</p>";
    $content .= "</div>";
  } else {
    // Generic coverage for cities without neighborhood data
    $regionText = $subdivision ? ", {$subdivision}" : '';
    $content = "<div class=\"box-padding\">";
    // REMOVED H3 - this section should not have its own heading, it's part of service area coverage
    $content .= "<p>We provide comprehensive AI-first SEO services throughout {$c}{$regionText} and surrounding metropolitan areas. Our localization strategies account for city-specific search patterns, local business competition, and regional AI engine behavior differences.</p>";
    $content .= "<p>Our {$c} optimization approach ensures maximum geographic relevance and entity clarity, improving citation accuracy across ChatGPT, Claude, Perplexity, and other AI search platforms. Location-anchored entity signals, local market schema, and city-specific content strategies all contribute to superior AI engine visibility.</p>";
    $content .= "<p><strong>Interested in AI engine optimization for your {$c} business?</strong> Contact us to discuss your coverage area and specific optimization goals.</p>";
    $content .= "</div>";
  }
  
  return $content;
}

/**
 * META KERNEL DIRECTIVE: Enhanced FAQ with City-Specific Context
 * Makes FAQs city-specific by injecting city context (5-7 questions)
 */
function city_specific_faq_block(string $service, string $city, int $count = 6): string {
  $rows = csv_rows_local('faq_pools.csv');
  $pool = array_values(array_filter($rows, fn($r)=>($r['service']??'')===$service));
  if (!$pool) return '';
  
  $c = titleCaseCity($city);
  det_seed("faq|$service|$city");
  $pick = det_pick($pool, min($count, max(5, min(7, count($pool))))); // Ensure 5-7 questions
  
  $out = ["<div class=\"grid\" style=\"gap:4px\">"];
  foreach ($pick as $qa) {
    $q = htmlspecialchars($qa['question']);
    $a = htmlspecialchars($qa['answer']);
    
    // Inject city-specific context into answer
    // Make answer relevant to this specific city
    $aEnhanced = $a;
    if (stripos($a, 'in') === false || stripos($a, $c) === false) {
      // Add city context if not already present (only replace first occurrence)
      $aEnhanced = preg_replace('/\. /', " in {$c}. ", $aEnhanced, 1);
    }
    
    // Ensure answer addresses local scenarios
    if (stripos($aEnhanced, 'local') === false && stripos($aEnhanced, 'city') === false) {
      // Add local context at end if missing
      if (!preg_match('/in ' . preg_quote($c, '/') . '\.?\s*$/i', $aEnhanced)) {
        $aEnhanced .= " In {$c}, this approach is tailored to local market conditions and regional search behavior patterns.";
      }
    }
    
    $out[] = "<details class=\"card\"><summary><strong>$q</strong></summary><p class=\"small muted\">$aEnhanced</p></details>";
  }
  $out[]="</div>";
  return implode("\n", $out);
}