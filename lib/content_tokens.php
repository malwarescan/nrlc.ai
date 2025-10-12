<?php
declare(strict_types=1);
require_once __DIR__.'/helpers.php';
require_once __DIR__.'/deterministic.php';
require_once __DIR__.'/csv.php';

function csv_rows_local(string $file): array { return csv_read_data($file); }
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
  return "<h3 class=\"h2\">$h</h3>$para1$para2$para3$list";
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
  $out[] = "<h3 class=\"h2\">Governance & Monitoring</h3>"
         ."<p>We operationalize ongoing checks: URL guards, schema validation, and crawl-stat alarms so improvements persist in {$c}.</p>"
         ."<ul class=\"small\"><li>Daily diffs of sitemaps and canonicals</li><li>Param drift alerts</li><li>Rich results coverage trends</li><li>LLM citation accuracy tracking</li></ul>";
  
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
    $out[] = "<h3 class=\"h2\">".htmlspecialchars($b['block_title'])."</h3><p>".htmlspecialchars($b['body'])."</p>";
  }
  // Add a process checklist for heft
  $out[] = "<ol class=\"small\"><li>Baseline logs & GSC</li><li>Duplicate path clustering</li><li>Rule design + tests</li><li>Deploy + monitor</li><li>Re-measure & harden</li></ol>";
  return implode("\n", $out);
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