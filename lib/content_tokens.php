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
  
  return "<div class=\"box-padding\">
    <h3 style=\"margin-top: 0; color: #000080;\">$c Market Dynamics</h3>
    <p>Local businesses operate within a competitive landscape dominated by {$data['industries']}, requiring sophisticated optimization strategies that address {$data['challenges']} while capitalizing on {$data['opportunities']}.</p>
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
  
  return "<div class=\"box-padding\">
    <h3 style=\"margin-top: 0; color: #000080;\">Competitive Landscape in $c</h3>
    <p>The market features {$insight}. Systematic crawl clarity, comprehensive structured data, and LLM seeding strategies outperform traditional SEO methods.</p>
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

/** Rich paragraph generator per pain point to increase word count meaningfully. */
function expand_pain_point(array $p, string $city): string {
  $h = htmlspecialchars($p['headline'] ?? 'Issue');
  $problem = htmlspecialchars($p['problem'] ?? '');
  $impact  = htmlspecialchars($p['impact'] ?? '');
  $solution= htmlspecialchars($p['solution'] ?? '');
  $deliver = htmlspecialchars($p['deliverables'] ?? '');
  $metric  = htmlspecialchars($p['metric'] ?? '');
  $c = htmlspecialchars(titleCaseCity($city));

  $para1 = "<p>{$problem} In {$c}, this typically surfaces as log spikes, faceted loops, and soft-duplicate paths that compete for the same queries.</p>";
  $para2 = "<p><strong>Impact:</strong> {$impact} Our audits in {$c} usually find wasted crawl on parameterized URLs and mixed-case aliases that never convert.</p>";
  $para3 = "<p><strong>Remediation:</strong> {$solution} We ship rule-sets, tests, and monitors so consolidation persists through releases. <em>Deliverables:</em> {$deliver}. <em>Expected result:</em> {$metric}.</p>";

  $list = "<ul class=\"small\"><li>Before/After sitemap diffs</li><li>Coverage & Discovered URLs trend</li><li>Param allowlist vs. strip rules</li><li>Canonical and hreflang spot-checks</li></ul>";
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
  
  return implode("\n", $out);
}

function approach_section(string $service): string {
  $rows = csv_rows_local('approach_blocks.csv');
  $blocks = array_values(array_filter($rows, fn($r)=>($r['service']??'')===$service));
  if (!$blocks) return '';
  det_seed("approach|$service");
  $pick = det_pick($blocks, max(2, min(3, count($blocks))));
  $out=[];
  foreach ($pick as $b) {
    $out[] = "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">".htmlspecialchars($b['block_title'])."</h3><p>".htmlspecialchars($b['body'])."</p></div>";
  }
  // Add a process checklist for heft
  $out[] = "<div class=\"box-padding\"><h3 style=\"margin-top: 0; color: #000080;\">Our Process</h3><ol class=\"small\"><li>Baseline logs & GSC</li><li>Duplicate path clustering</li><li>Rule design + tests</li><li>Deploy + monitor</li><li>Re-measure & harden</li></ol></div>";
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
  return "<div class=\"box-padding\">
    <h3 style=\"margin-top: 0; color: #000080;\">Implementation Timeline</h3>
    <p>Our typical engagement in {$c} follows a structured four-phase approach designed to deliver measurable improvements quickly while building sustainable optimization practices:</p>
    <p><strong>Phase 1: Discovery & Audit (Week 1-2)</strong> — Comprehensive technical audit covering crawl efficiency, schema completeness, entity clarity, and AI engine visibility. We analyze your current state across all GEO-16 framework pillars and identify quick wins alongside strategic opportunities.</p>
    <p><strong>Phase 2: Implementation & Optimization (Week 3-6)</strong> — Systematic implementation of recommended improvements, including URL normalization, schema enhancement, content optimization, and technical infrastructure updates. Each change is tested and validated before deployment.</p>
    <p><strong>Phase 3: Validation & Monitoring (Week 7-8)</strong> — Rigorous testing of all implementations, establishment of monitoring systems, and validation of improvements through crawl analysis, rich results testing, and AI engine citation tracking.</p>
    <p><strong>Phase 4: Ongoing Optimization (Month 3+)</strong> — Continuous monitoring, iterative improvements, and adaptation to evolving AI engine requirements. Regular reporting on citation accuracy, crawl efficiency, and visibility metrics.</p>
  </div>";
}

function success_metrics_section(string $service, string $city): string {
  $s = ucfirst(str_replace('-', ' ', $service));
  $c = titleCaseCity($city);
  return "<div class=\"box-padding\">
    <h3 style=\"margin-top: 0; color: #000080;\">Success Metrics & Measurement</h3>
    <p>We measure $s success in {$c} through comprehensive tracking across multiple dimensions. Every engagement includes baseline measurement, ongoing monitoring, and detailed reporting so you can see exactly how improvements translate to business outcomes.</p>
    <p><strong>Crawl Efficiency Metrics:</strong> We track crawl budget utilization, discovered URL counts, sitemap coverage rates, and duplicate URL elimination. In {$c}, our clients typically see 35-60% reductions in crawl waste within the first month of implementation.</p>
    <p><strong>AI Engine Visibility:</strong> We monitor citation accuracy across ChatGPT, Claude, Perplexity, and other AI platforms. This includes tracking brand mentions, URL accuracy in citations, fact correctness, and citation frequency. Improvements in these metrics directly correlate with increased qualified traffic and brand authority.</p>
    <p><strong>Structured Data Performance:</strong> Rich results impressions, FAQ snippet appearances, and schema validation status are tracked weekly. We monitor Google Search Console for structured data errors and opportunities, ensuring your schema implementations deliver maximum visibility benefits.</p>
    <p><strong>Technical Health Indicators:</strong> Core Web Vitals, mobile usability scores, HTTPS implementation, canonical coverage, and hreflang accuracy are continuously monitored. These foundational elements ensure sustainable AI engine optimization and prevent technical regression.</p>
  </div>";
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