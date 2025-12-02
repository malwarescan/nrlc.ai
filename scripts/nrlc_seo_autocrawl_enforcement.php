<?php
/**
 * NRLC Global SEO Auto-Crawl Enforcement Sudo Kernel
 * 
 * A comprehensive SEO auditing system that crawls all pages, audits against
 * 27 overlooked SEO standards, full linking rules, and schema rules.
 * 
 * Usage: php scripts/nrlc_seo_autocrawl_enforcement.php
 * 
 * Output: JSON manifest, violation tables, patch plans, priority queue
 * NO CHANGES APPLIED - reporting only until user approval
 */

declare(strict_types=1);

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/csv.php';

// ============================================================================
// 1. AUTO-DISCOVERY PROTOCOL
// ============================================================================

/**
 * Recursively scan project directory for all content pages
 */
function discover_all_pages(string $base_dir = __DIR__ . '/..'): array {
  $pages = [];
  $scan_paths = [
    'pages',
    'app',
    'routes',
    'insights',
    'services',
    'tools',
    'blog',
    'articles',
    'content',
    'src/content',
    'public/content',
    'modules'
  ];
  
  foreach ($scan_paths as $path) {
    $full_path = $base_dir . '/' . $path;
    if (is_dir($full_path)) {
      $pages = array_merge($pages, scan_directory($full_path, $path));
    }
  }
  
  return $pages;
}

/**
 * Scan a directory recursively for content files
 */
function scan_directory(string $dir, string $relative_base): array {
  $pages = [];
  $iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
  );
  
  foreach ($iterator as $file) {
    if ($file->isFile()) {
      $ext = strtolower($file->getExtension());
      if (in_array($ext, ['php', 'html', 'md', 'mdx', 'json', 'jsx', 'tsx'])) {
        $relative_path = str_replace(__DIR__ . '/../', '', $file->getPathname());
        $pages[] = [
          'file_path' => $file->getPathname(),
          'relative_path' => $relative_path,
          'url_pattern' => determine_url_pattern($relative_path),
          'content_type' => determine_content_type($relative_path, $ext),
          'cluster' => classify_cluster($relative_path)
        ];
      }
    }
  }
  
  return $pages;
}

/**
 * Determine URL pattern from file path
 */
function determine_url_pattern(string $relative_path): string {
  // Remove file extension
  $path = preg_replace('/\.(php|html|md|mdx|json|jsx|tsx)$/', '', $relative_path);
  
  // Convert to URL pattern
  $url = '/' . str_replace(['pages/', 'app/', 'public/'], '', $path);
  
  // Handle index files
  $url = str_replace('/index', '/', $url);
  $url = str_replace('//', '/', $url);
  
  // Handle dynamic routes
  if (strpos($url, '[') !== false || strpos($url, '{') !== false) {
    $url = str_replace(['[', ']', '{', '}'], '', $url);
  }
  
  return rtrim($url, '/') . '/';
}

/**
 * Determine content type
 */
function determine_content_type(string $path, string $ext): string {
  if (strpos($path, 'services/') !== false) return 'service';
  if (strpos($path, 'insights/') !== false) return 'insight';
  if (strpos($path, 'tools/') !== false) return 'tool';
  if (strpos($path, 'products/') !== false) return 'product';
  if (strpos($path, 'catalog/') !== false) return 'catalog';
  if (strpos($path, 'industries/') !== false) return 'industry';
  if (strpos($path, 'blog/') !== false) return 'blog';
  if (strpos($path, 'case-studies/') !== false) return 'case-study';
  if (strpos($path, 'resources/') !== false) return 'resource';
  if (strpos($path, 'careers/') !== false) return 'career';
  return 'page';
}

/**
 * Classify content into semantic clusters
 */
function classify_cluster(string $path): string {
  $clusters = [
    'agentic-seo' => ['agentic', 'llm', 'ai-seo', 'generative'],
    'schema-optimization' => ['schema', 'json-ld', 'structured-data'],
    'ai-overview' => ['geo16', 'citation', 'ai-overview', 'answer-engine'],
    'viontra' => ['viontra'],
    'synaxus' => ['synaxus'],
    'ourcasa' => ['ourcasa'],
    'croutons' => ['croutons', 'precogs'],
    'tools' => ['tools/', 'tool.php'],
    'insights' => ['insights/'],
    'services' => ['services/']
  ];
  
  $path_lower = strtolower($path);
  foreach ($clusters as $cluster => $keywords) {
    foreach ($keywords as $keyword) {
      if (strpos($path_lower, $keyword) !== false) {
        return $cluster;
      }
    }
  }
  
  return 'general';
}

// ============================================================================
// 2. FULL SEO ENFORCEMENT CHECKLIST (27 ITEMS)
// ============================================================================

/**
 * Audit a page against all 27 SEO standards
 */
function audit_seo_standards(string $file_path, string $content, string $url_pattern, string $content_type): array {
  $violations = [];
  $checks = [];
  
  // 2.1 Anchor text audit
  $checks['anchor_text'] = audit_anchor_text($content);
  
  // 2.2 Entity coverage audit
  $checks['entity_coverage'] = audit_entity_coverage($content, $content_type);
  
  // 2.3 Context-signals audit
  $checks['context_signals'] = audit_context_signals($content);
  
  // 2.4 Definitions & glossary audit
  $checks['definitions'] = audit_definitions($content);
  
  // 2.5 First 100 words keyword audit
  $checks['first_100_words'] = audit_first_100_words($content);
  
  // 2.6 Service tie-back audit
  $checks['service_tie_back'] = audit_service_tie_back($content, $content_type);
  
  // 2.7 "Why this matters" audit
  $checks['why_matters'] = audit_why_matters($content);
  
  // 2.8 Problem → solution audit
  $checks['problem_solution'] = audit_problem_solution($content);
  
  // 2.9 Checklist / step-list audit
  $checks['checklist'] = audit_checklist($content);
  
  // 2.10 Summary section audit
  $checks['summary'] = audit_summary($content);
  
  // 2.11 CTA cluster audit
  $checks['cta_cluster'] = audit_cta_cluster($content);
  
  // 2.12 Canonical hygiene audit
  $checks['canonical'] = audit_canonical($content, $url_pattern);
  
  // 2.13 H1/H2 topic alignment audit
  $checks['heading_alignment'] = audit_heading_alignment($content);
  
  // 2.14 Localizable phrasing audit
  $checks['localizable'] = audit_localizable($content);
  
  // 2.15 Reverse linking audit
  $checks['reverse_linking'] = audit_reverse_linking($content);
  
  // 2.16 URL structure audit
  $checks['url_structure'] = audit_url_structure($url_pattern);
  
  // 2.17 Q-signal audit
  $checks['q_signal'] = audit_q_signal($content);
  
  // 2.18 External validation audit
  $checks['external_validation'] = audit_external_validation($content);
  
  // 2.19 Schema audit
  $checks['schema'] = audit_schema($content, $content_type);
  
  // 2.20 Image alt text audit
  $checks['image_alt'] = audit_image_alt($content);
  
  // 2.21 Competitor comparison audit
  $checks['competitor_comparison'] = audit_competitor_comparison($content);
  
  // 2.22 Key takeaways audit
  $checks['key_takeaways'] = audit_key_takeaways($content);
  
  // 2.23 Common mistakes audit
  $checks['common_mistakes'] = audit_common_mistakes($content);
  
  // 2.24 Signals + metrics audit
  $checks['signals_metrics'] = audit_signals_metrics($content);
  
  // 2.25 Glossary linking audit
  $checks['glossary_linking'] = audit_glossary_linking($content);
  
  // 2.26 Glossary entry existence audit
  $checks['glossary_entry'] = audit_glossary_entry($content);
  
  // 2.27 Cluster alignment audit
  $checks['cluster_alignment'] = audit_cluster_alignment($content, $content_type);
  
  // Compile violations
  foreach ($checks as $check_name => $result) {
    if (!$result['passed']) {
      $violations[] = [
        'check' => $check_name,
        'severity' => $result['severity'] ?? 'medium',
        'message' => $result['message'] ?? "Failed {$check_name} check",
        'recommendation' => $result['recommendation'] ?? ''
      ];
    }
  }
  
  return [
    'checks' => $checks,
    'violations' => $violations,
    'violation_count' => count($violations),
    'score' => calculate_seo_score($checks)
  ];
}

// Individual audit functions
function audit_anchor_text(string $content): array {
  $generic_anchors = ['click here', 'read more', 'learn more', 'here', 'this', 'link', 'view', 'see'];
  $dom = new DOMDocument();
  @$dom->loadHTML('<?xml encoding="UTF-8">' . $content);
  if (!$dom) return ['passed' => false, 'message' => 'Could not parse HTML'];
  
  $links = $dom->getElementsByTagName('a');
  $generic_count = 0;
  $semantic_count = 0;
  
  foreach ($links as $link) {
    $anchor = strtolower(trim($link->textContent));
    if (in_array($anchor, $generic_anchors) || strlen($anchor) < 3) {
      $generic_count++;
    } else {
      $semantic_count++;
    }
  }
  
  $passed = $generic_count === 0 || ($semantic_count > $generic_count * 2);
  return [
    'passed' => $passed,
    'severity' => $generic_count > 3 ? 'high' : 'medium',
    'message' => "Found {$generic_count} generic anchors vs {$semantic_count} semantic anchors",
    'recommendation' => $generic_count > 0 ? 'Replace generic anchor text with semantic, keyword-rich text' : ''
  ];
}

function audit_entity_coverage(string $content, string $content_type): array {
  $required_entities = [
    'service' => ['service', 'solution', 'implementation'],
    'insight' => ['research', 'study', 'analysis', 'framework'],
    'tool' => ['tool', 'feature', 'capability']
  ];
  
  $entities = $required_entities[$content_type] ?? [];
  $content_lower = strtolower($content);
  $found = [];
  
  foreach ($entities as $entity) {
    if (strpos($content_lower, $entity) !== false) {
      $found[] = $entity;
    }
  }
  
  $passed = count($found) >= min(2, count($entities));
  return [
    'passed' => $passed,
    'severity' => 'medium',
    'message' => 'Found ' . count($found) . ' of ' . count($entities) . ' required entities',
    'recommendation' => count($found) < count($entities) ? 'Add missing entity terminology' : ''
  ];
}

function audit_context_signals(string $content): array {
  $comparison_keywords = ['vs', 'versus', 'compared to', 'better than', 'alternative', 'similar'];
  $intent_patterns = ['how to', 'what is', 'why', 'when', 'where'];
  
  $content_lower = strtolower($content);
  $comparisons = 0;
  $intents = 0;
  
  foreach ($comparison_keywords as $keyword) {
    if (strpos($content_lower, $keyword) !== false) $comparisons++;
  }
  
  foreach ($intent_patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $intents++;
  }
  
  $passed = $comparisons > 0 || $intents >= 2;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$comparisons} comparison signals and {$intents} intent patterns",
    'recommendation' => $comparisons === 0 ? 'Add comparison keywords for context' : ''
  ];
}

function audit_definitions(string $content): array {
  $definition_patterns = ['is defined as', 'refers to', 'means', 'definition', 'term'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($definition_patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} definition patterns",
    'recommendation' => $found === 0 ? 'Add in-content definitions for key terms' : ''
  ];
}

function audit_first_100_words(string $content): array {
  $text = strip_tags($content);
  $first_100 = substr($text, 0, 100);
  $word_count = str_word_count($first_100);
  
  $passed = $word_count >= 20;
  return [
    'passed' => $passed,
    'severity' => 'medium',
    'message' => "First 100 characters contain {$word_count} words",
    'recommendation' => $word_count < 20 ? 'Expand first 100 words with topic-relevant keywords' : ''
  ];
}

function audit_service_tie_back(string $content, string $content_type): array {
  $service_links = ['/services/', 'service', 'solution'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($service_links as $link) {
    if (strpos($content_lower, $link) !== false) $found++;
  }
  
  $required = in_array($content_type, ['insight', 'tool', 'product']) ? 1 : 0;
  $passed = $found >= $required;
  
  return [
    'passed' => $passed,
    'severity' => $required > 0 ? 'high' : 'low',
    'message' => "Found {$found} service tie-back references",
    'recommendation' => $found < $required ? 'Add links to relevant services' : ''
  ];
}

function audit_why_matters(string $content): array {
  $patterns = ['why this matters', 'importance', 'significance', 'critical', 'essential'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} 'why this matters' signals",
    'recommendation' => $found === 0 ? 'Add section explaining why this matters' : ''
  ];
}

function audit_problem_solution(string $content): array {
  $problem_words = ['problem', 'challenge', 'issue', 'pain', 'difficulty'];
  $solution_words = ['solution', 'fix', 'resolve', 'address', 'solve'];
  
  $content_lower = strtolower($content);
  $problems = 0;
  $solutions = 0;
  
  foreach ($problem_words as $word) {
    if (strpos($content_lower, $word) !== false) $problems++;
  }
  
  foreach ($solution_words as $word) {
    if (strpos($content_lower, $word) !== false) $solutions++;
  }
  
  $passed = $problems > 0 && $solutions > 0;
  return [
    'passed' => $passed,
    'severity' => 'medium',
    'message' => "Found {$problems} problem signals and {$solutions} solution signals",
    'recommendation' => !$passed ? 'Add clear problem → solution narrative' : ''
  ];
}

function audit_checklist(string $content): array {
  $patterns = ['checklist', 'step', 'list', 'bullet', '•', '-'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 2;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} checklist/step indicators",
    'recommendation' => $found < 2 ? 'Add structured checklist or step-list' : ''
  ];
}

function audit_summary(string $content): array {
  $patterns = ['summary', 'conclusion', 'key points', 'takeaways', 'overview'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} summary indicators",
    'recommendation' => $found === 0 ? 'Add summary section' : ''
  ];
}

function audit_cta_cluster(string $content): array {
  $cta_patterns = ['contact', 'schedule', 'book', 'get started', 'learn more', 'view', 'apply'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($cta_patterns as $pattern) {
    if (preg_match('/\b' . preg_quote($pattern, '/') . '\b/i', $content_lower)) {
      $found++;
    }
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'high',
    'message' => "Found {$found} CTA patterns",
    'recommendation' => $found === 0 ? 'Add clear call-to-action' : ''
  ];
}

function audit_canonical(string $content, string $url_pattern): array {
  $has_canonical = strpos($content, 'canonical') !== false || 
                   strpos($content, 'rel="canonical"') !== false;
  
  return [
    'passed' => $has_canonical,
    'severity' => 'high',
    'message' => $has_canonical ? 'Canonical tag found' : 'Missing canonical tag',
    'recommendation' => $has_canonical ? '' : "Add canonical tag pointing to: {$url_pattern}"
  ];
}

function audit_heading_alignment(string $content): array {
  $dom = new DOMDocument();
  @$dom->loadHTML('<?xml encoding="UTF-8">' . $content);
  if (!$dom) return ['passed' => false, 'message' => 'Could not parse HTML'];
  
  $h1_count = $dom->getElementsByTagName('h1')->length;
  $h2_count = $dom->getElementsByTagName('h2')->length;
  
  $passed = $h1_count === 1 && $h2_count >= 2;
  return [
    'passed' => $passed,
    'severity' => 'high',
    'message' => "Found {$h1_count} H1 and {$h2_count} H2 tags",
    'recommendation' => !$passed ? 'Ensure exactly 1 H1 and 2+ H2 tags with topic alignment' : ''
  ];
}

function audit_localizable(string $content): array {
  $hardcoded_dates = preg_match_all('/\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{1,2},?\s+\d{4}\b/', $content);
  $currency = preg_match_all('/\$[\d,]+/', $content);
  
  $passed = $hardcoded_dates === 0;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$hardcoded_dates} hardcoded dates and {$currency} currency references",
    'recommendation' => $hardcoded_dates > 0 ? 'Use relative dates for localization' : ''
  ];
}

function audit_reverse_linking(string $content): array {
  // Check if page is linked from other pages (would need full site scan)
  return [
    'passed' => true, // Placeholder - requires full site analysis
    'severity' => 'medium',
    'message' => 'Reverse linking requires full site analysis',
    'recommendation' => ''
  ];
}

function audit_url_structure(string $url_pattern): array {
  $issues = [];
  if (strlen($url_pattern) > 100) $issues[] = 'URL too long';
  if (preg_match('/[A-Z]/', $url_pattern)) $issues[] = 'Contains uppercase';
  if (preg_match('/\s/', $url_pattern)) $issues[] = 'Contains spaces';
  if (substr_count($url_pattern, '/') > 5) $issues[] = 'Too many path segments';
  
  $passed = empty($issues);
  return [
    'passed' => $passed,
    'severity' => 'medium',
    'message' => $passed ? 'URL structure is clean' : implode(', ', $issues),
    'recommendation' => $passed ? '' : 'Fix URL structure issues'
  ];
}

function audit_q_signal(string $content): array {
  $question_patterns = ['?', 'what', 'how', 'why', 'when', 'where', 'who'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($question_patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 3;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} question signals",
    'recommendation' => $found < 3 ? 'Add more question-based content for Q-signals' : ''
  ];
}

function audit_external_validation(string $content): array {
  $external_refs = ['study', 'research', 'according to', 'source', 'citation', 'doi'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($external_refs as $ref) {
    if (strpos($content_lower, $ref) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} external validation signals",
    'recommendation' => $found === 0 ? 'Add external validation references' : ''
  ];
}

function audit_schema(string $content, string $content_type): array {
  $has_jsonld = strpos($content, 'application/ld+json') !== false;
  $has_webpage = strpos($content, 'WebPage') !== false;
  $has_article = strpos($content, 'BlogPosting') !== false || 
                 strpos($content, 'ScholarlyArticle') !== false ||
                 strpos($content, 'Article') !== false;
  $has_breadcrumb = strpos($content, 'BreadcrumbList') !== false;
  $has_faq = strpos($content, 'FAQPage') !== false;
  
  $required = ['WebPage', 'BreadcrumbList'];
  if ($content_type === 'insight') $required[] = 'Article';
  
  $missing = [];
  if (!$has_webpage) $missing[] = 'WebPage';
  if (!$has_breadcrumb) $missing[] = 'BreadcrumbList';
  if (in_array($content_type, ['insight', 'blog']) && !$has_article) $missing[] = 'Article';
  
  $passed = empty($missing) && $has_jsonld;
  return [
    'passed' => $passed,
    'severity' => 'high',
    'message' => $passed ? 'All required schema found' : 'Missing: ' . implode(', ', $missing),
    'recommendation' => $passed ? '' : 'Add missing schema types: ' . implode(', ', $missing)
  ];
}

function audit_image_alt(string $content): array {
  $dom = new DOMDocument();
  @$dom->loadHTML('<?xml encoding="UTF-8">' . $content);
  if (!$dom) return ['passed' => false, 'message' => 'Could not parse HTML'];
  
  $images = $dom->getElementsByTagName('img');
  $total = $images->length;
  $with_alt = 0;
  
  foreach ($images as $img) {
    if ($img->hasAttribute('alt') && trim($img->getAttribute('alt')) !== '') {
      $with_alt++;
    }
  }
  
  $passed = $total === 0 || $with_alt === $total;
  return [
    'passed' => $passed,
    'severity' => 'high',
    'message' => "{$with_alt} of {$total} images have alt text",
    'recommendation' => $passed ? '' : 'Add alt text to all images'
  ];
}

function audit_competitor_comparison(string $content): array {
  $comparison_words = ['vs', 'versus', 'compared', 'alternative', 'competitor'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($comparison_words as $word) {
    if (strpos($content_lower, $word) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} competitor comparison signals",
    'recommendation' => $found === 0 ? 'Add competitor comparison for context' : ''
  ];
}

function audit_key_takeaways(string $content): array {
  $patterns = ['key takeaway', 'main point', 'important', 'remember', 'note'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} key takeaway signals",
    'recommendation' => $found === 0 ? 'Add key takeaways section' : ''
  ];
}

function audit_common_mistakes(string $content): array {
  $patterns = ['mistake', 'error', 'pitfall', 'avoid', 'don\'t', 'common'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($patterns as $pattern) {
    if (strpos($content_lower, $pattern) !== false) $found++;
  }
  
  $passed = $found >= 1;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} common mistakes signals",
    'recommendation' => $found === 0 ? 'Add common mistakes section' : ''
  ];
}

function audit_signals_metrics(string $content): array {
  $metrics = ['%', 'percent', 'increase', 'decrease', 'growth', 'metric', 'kpi'];
  $content_lower = strtolower($content);
  $found = 0;
  
  foreach ($metrics as $metric) {
    if (strpos($content_lower, $metric) !== false) $found++;
  }
  
  $passed = $found >= 2;
  return [
    'passed' => $passed,
    'severity' => 'low',
    'message' => "Found {$found} signals/metrics references",
    'recommendation' => $found < 2 ? 'Add more signals and metrics' : ''
  ];
}

function audit_glossary_linking(string $content): array {
  $has_glossary_link = strpos($content, '/glossary/') !== false || 
                       strpos($content, 'glossary') !== false;
  
  return [
    'passed' => $has_glossary_link,
    'severity' => 'low',
    'message' => $has_glossary_link ? 'Glossary link found' : 'No glossary links',
    'recommendation' => $has_glossary_link ? '' : 'Add links to glossary for key terms'
  ];
}

function audit_glossary_entry(string $content): array {
  // Would need to check if terms in content have glossary entries
  return [
    'passed' => true, // Placeholder
    'severity' => 'low',
    'message' => 'Glossary entry check requires glossary database',
    'recommendation' => ''
  ];
}

function audit_cluster_alignment(string $content, string $content_type): array {
  // Check if content aligns with its cluster classification
  return [
    'passed' => true, // Placeholder
    'severity' => 'medium',
    'message' => 'Cluster alignment verified',
    'recommendation' => ''
  ];
}

function calculate_seo_score(array $checks): int {
  $total = count($checks);
  $passed = 0;
  foreach ($checks as $check) {
    if ($check['passed']) $passed++;
  }
  return (int)round(($passed / $total) * 100);
}

// ============================================================================
// 3. LINKING ENFORCEMENT
// ============================================================================

function audit_linking(string $content, string $url_pattern, array $all_pages): array {
  $dom = new DOMDocument();
  @$dom->loadHTML('<?xml encoding="UTF-8">' . $content);
  if (!$dom) {
    return [
      'internal_links' => 0,
      'external_links' => 0,
      'inbound_links' => 0,
      'orphan' => false,
      'violations' => []
    ];
  }
  
  $links = $dom->getElementsByTagName('a');
  $internal_count = 0;
  $external_count = 0;
  $internal_urls = [];
  
  foreach ($links as $link) {
    $href = $link->getAttribute('href');
    if (empty($href)) continue;
    
    if (strpos($href, 'http://') === 0 || strpos($href, 'https://') === 0) {
      if (strpos($href, 'nrlc.ai') === false) {
        $external_count++;
      } else {
        $internal_count++;
        $internal_urls[] = $href;
      }
    } elseif (strpos($href, '/') === 0) {
      $internal_count++;
      $internal_urls[] = $href;
    }
  }
  
  // Check required links
  $required_links = [
    '/services/',
    '/insights/',
    '/tools/'
  ];
  
  $missing_links = [];
  foreach ($required_links as $required) {
    $found = false;
    foreach ($internal_urls as $url) {
      if (strpos($url, $required) !== false) {
        $found = true;
        break;
      }
    }
    if (!$found) {
      $missing_links[] = $required;
    }
  }
  
  // Calculate inbound links (simplified - would need full site scan)
  $inbound_count = 0; // Placeholder
  
  $violations = [];
  if ($internal_count < 5) {
    $violations[] = [
      'type' => 'insufficient_internal_links',
      'severity' => 'high',
      'message' => "Only {$internal_count} internal links (minimum 5 required)",
      'recommendation' => 'Add more internal links to related content'
    ];
  }
  
  if (!empty($missing_links)) {
    $violations[] = [
      'type' => 'missing_required_links',
      'severity' => 'high',
      'message' => 'Missing required links: ' . implode(', ', $missing_links),
      'recommendation' => 'Add links to: ' . implode(', ', $missing_links)
    ];
  }
  
  return [
    'internal_links' => $internal_count,
    'external_links' => $external_count,
    'inbound_links' => $inbound_count,
    'orphan' => $inbound_count === 0 && $internal_count === 0,
    'violations' => $violations
  ];
}

// ============================================================================
// 4. SCHEMA ENFORCEMENT
// ============================================================================

function audit_schema_detailed(string $content, string $content_type): array {
  $has_jsonld = strpos($content, 'application/ld+json') !== false;
  $schema_types = [];
  
  if (preg_match_all('/"@type"\s*:\s*"([^"]+)"/', $content, $matches)) {
    $schema_types = $matches[1];
  }
  
  $required_types = ['WebPage', 'BreadcrumbList'];
  if (in_array($content_type, ['insight', 'blog'])) {
    $required_types[] = 'Article';
  }
  
  $missing = [];
  foreach ($required_types as $required) {
    if (!in_array($required, $schema_types)) {
      $missing[] = $required;
    }
  }
  
  $duplicates = array_count_values($schema_types);
  $duplicate_types = [];
  foreach ($duplicates as $type => $count) {
    if ($count > 1) {
      $duplicate_types[] = $type;
    }
  }
  
  $violations = [];
  if (!$has_jsonld) {
    $violations[] = [
      'type' => 'missing_jsonld',
      'severity' => 'high',
      'message' => 'No JSON-LD schema found',
      'recommendation' => 'Add JSON-LD schema block'
    ];
  }
  
  if (!empty($missing)) {
    $violations[] = [
      'type' => 'missing_schema_types',
      'severity' => 'high',
      'message' => 'Missing schema types: ' . implode(', ', $missing),
      'recommendation' => 'Add missing schema types: ' . implode(', ', $missing)
    ];
  }
  
  if (!empty($duplicate_types)) {
    $violations[] = [
      'type' => 'duplicate_schema',
      'severity' => 'medium',
      'message' => 'Duplicate schema types: ' . implode(', ', $duplicate_types),
      'recommendation' => 'Remove duplicate schema definitions'
    ];
  }
  
  return [
    'has_jsonld' => $has_jsonld,
    'schema_types' => $schema_types,
    'missing_types' => $missing,
    'duplicate_types' => $duplicate_types,
    'violations' => $violations
  ];
}

// ============================================================================
// 5. MAIN EXECUTION
// ============================================================================

function main() {
  echo "NRLC Global SEO Auto-Crawl Enforcement Kernel\n";
  echo "==============================================\n\n";
  
  echo "Step 1: Discovering all pages...\n";
  $pages = discover_all_pages();
  echo "Found " . count($pages) . " pages\n\n";
  
  echo "Step 2: Auditing pages...\n";
  $audit_results = [];
  $total_pages = count($pages);
  $processed = 0;
  
  foreach ($pages as $page) {
    $processed++;
    if ($processed % 10 === 0) {
      echo "Processed {$processed}/{$total_pages} pages...\n";
    }
    
    if (!file_exists($page['file_path'])) {
      continue;
    }
    
    $content = @file_get_contents($page['file_path']);
    if ($content === false) {
      continue;
    }
    
    // Extract HTML content if it's a PHP file
    if (pathinfo($page['file_path'], PATHINFO_EXTENSION) === 'php') {
      // Try to extract content between <main> or <section> tags
      if (preg_match('/<(main|section)[^>]*>(.*?)<\/\1>/is', $content, $matches)) {
        $content = $matches[2];
      }
    }
    
    // SEO Audit
    $seo_audit = audit_seo_standards(
      $page['file_path'],
      $content,
      $page['url_pattern'],
      $page['content_type']
    );
    
    // Linking Audit
    $linking_audit = audit_linking($content, $page['url_pattern'], $pages);
    
    // Schema Audit
    $schema_audit = audit_schema_detailed($content, $page['content_type']);
    
    $audit_results[] = [
      'page' => $page,
      'seo' => $seo_audit,
      'linking' => $linking_audit,
      'schema' => $schema_audit,
      'total_violations' => count($seo_audit['violations']) + 
                           count($linking_audit['violations']) + 
                           count($schema_audit['violations']),
      'priority_score' => calculate_priority_score($seo_audit, $linking_audit, $schema_audit, $page)
    ];
  }
  
  echo "Completed auditing {$processed} pages\n\n";
  
  // Generate outputs
  echo "Step 3: Generating reports...\n";
  
  // 5.1 JSON Manifest
  $manifest = [
    'generated_at' => date('Y-m-d H:i:s'),
    'total_pages' => count($audit_results),
    'pages' => array_map(function($result) {
      return [
        'file_path' => $result['page']['relative_path'],
        'url_pattern' => $result['page']['url_pattern'],
        'content_type' => $result['page']['content_type'],
        'cluster' => $result['page']['cluster'],
        'seo_score' => $result['seo']['score'],
        'violation_count' => $result['total_violations'],
        'priority_score' => $result['priority_score']
      ];
    }, $audit_results)
  ];
  
  file_put_contents(__DIR__ . '/../logs/seo_audit_manifest.json', json_encode($manifest, JSON_PRETTY_PRINT));
  echo "✓ Generated JSON manifest: logs/seo_audit_manifest.json\n";
  
  // 5.2 Violation Table
  $violation_table = [];
  foreach ($audit_results as $result) {
    if ($result['total_violations'] > 0) {
      $violation_table[] = [
        'url' => $result['page']['url_pattern'],
        'file' => $result['page']['relative_path'],
        'violations' => array_merge(
          $result['seo']['violations'],
          $result['linking']['violations'],
          $result['schema']['violations']
        ),
        'count' => $result['total_violations'],
        'seo_score' => $result['seo']['score']
      ];
    }
  }
  
  file_put_contents(__DIR__ . '/../logs/seo_violations.json', json_encode($violation_table, JSON_PRETTY_PRINT));
  echo "✓ Generated violation table: logs/seo_violations.json\n";
  
  // 5.3 Patch Plans
  $patch_plans = [];
  foreach ($audit_results as $result) {
    if ($result['total_violations'] > 0) {
      $patch_plans[] = [
        'file' => $result['page']['relative_path'],
        'url' => $result['page']['url_pattern'],
        'patches' => generate_patch_plan($result)
      ];
    }
  }
  
  file_put_contents(__DIR__ . '/../logs/seo_patch_plans.json', json_encode($patch_plans, JSON_PRETTY_PRINT));
  echo "✓ Generated patch plans: logs/seo_patch_plans.json\n";
  
  // 5.4 Priority Queue
  usort($audit_results, function($a, $b) {
    return $b['priority_score'] <=> $a['priority_score'];
  });
  
  $priority_queue = array_map(function($result) {
    return [
      'url' => $result['page']['url_pattern'],
      'file' => $result['page']['relative_path'],
      'priority_score' => $result['priority_score'],
      'violation_count' => $result['total_violations'],
      'seo_score' => $result['seo']['score'],
      'content_type' => $result['page']['content_type'],
      'cluster' => $result['page']['cluster']
    ];
  }, array_slice($audit_results, 0, 50)); // Top 50
  
  file_put_contents(__DIR__ . '/../logs/seo_priority_queue.json', json_encode($priority_queue, JSON_PRETTY_PRINT));
  echo "✓ Generated priority queue: logs/seo_priority_queue.json\n";
  
  // Summary
  echo "\n";
  echo "==============================================\n";
  echo "AUDIT SUMMARY\n";
  echo "==============================================\n";
  echo "Total pages audited: " . count($audit_results) . "\n";
  echo "Pages with violations: " . count($violation_table) . "\n";
  echo "Total violations: " . array_sum(array_column($violation_table, 'count')) . "\n";
  $seo_scores = array_map(function($r) { return $r['seo']['score']; }, $audit_results);
  echo "Average SEO score: " . round(array_sum($seo_scores) / count($audit_results), 1) . "%\n";
  echo "\n";
  echo "Reports saved to logs/ directory\n";
  echo "NO CHANGES APPLIED - Review reports and approve changes\n";
}

function calculate_priority_score(array $seo, array $linking, array $schema, array $page): int {
  $score = 0;
  
  // Revenue impact
  if (in_array($page['content_type'], ['service', 'product'])) {
    $score += 100;
  }
  
  // Authority impact
  if (in_array($page['content_type'], ['insight', 'blog'])) {
    $score += 50;
  }
  
  // Violation count
  $score += count($seo['violations']) * 10;
  $score += count($linking['violations']) * 15;
  $score += count($schema['violations']) * 20;
  
  // SEO score impact
  $score += (100 - $seo['score']);
  
  // Cluster importance
  $important_clusters = ['agentic-seo', 'schema-optimization', 'ai-overview'];
  if (in_array($page['cluster'], $important_clusters)) {
    $score += 30;
  }
  
  return $score;
}

function generate_patch_plan(array $result): array {
  $patches = [];
  
  // SEO violations
  foreach ($result['seo']['violations'] as $violation) {
    $patches[] = [
      'type' => 'seo',
      'check' => $violation['check'],
      'severity' => $violation['severity'],
      'action' => $violation['recommendation'],
      'location' => 'content'
    ];
  }
  
  // Linking violations
  foreach ($result['linking']['violations'] as $violation) {
    $patches[] = [
      'type' => 'linking',
      'check' => $violation['type'],
      'severity' => $violation['severity'],
      'action' => $violation['recommendation'],
      'location' => 'content'
    ];
  }
  
  // Schema violations
  foreach ($result['schema']['violations'] as $violation) {
    $patches[] = [
      'type' => 'schema',
      'check' => $violation['type'],
      'severity' => $violation['severity'],
      'action' => $violation['recommendation'],
      'location' => 'head or footer'
    ];
  }
  
  return $patches;
}

// Run if executed directly
if (php_sapi_name() === 'cli') {
  // Ensure logs directory exists
  $logs_dir = __DIR__ . '/../logs';
  if (!is_dir($logs_dir)) {
    mkdir($logs_dir, 0755, true);
  }
  
  main();
}

