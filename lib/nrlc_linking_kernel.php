<?php
declare(strict_types=1);
/**
 * NRLC LINKING SYSTEM SUDO KERNEL
 * 
 * Root-access meta directive that enforces complete SEO-first, AEO-first internal
 * and external linking architecture across NRLC.ai and related brand ecosystems.
 * 
 * Core Principle: "Every page must pass authority to a revenue page and receive
 * authority from a topical page. Nothing is orphaned. Nothing leaks authority."
 */

require_once __DIR__ . '/helpers.php';

/**
 * Get required internal links for a page based on its type and context
 * 
 * @param string $page_type Type of page (insights, services, tools, catalog, etc.)
 * @param string $page_slug Current page slug
 * @param array $metadata Page metadata (category, tags, etc.)
 * @return array Array of required links with anchor text and URLs
 */
function get_required_internal_links(string $page_type, string $page_slug = '', array $metadata = []): array {
  $links = [];
  $domain = 'https://nrlc.ai';
  
  // 1.1 Always link to Services root
  $links[] = [
    'url' => $domain . '/services/',
    'anchor' => 'AI SEO Services',
    'type' => 'revenue',
    'required' => true
  ];
  
  // 1.2 Link to primary revenue/service page
  $links[] = [
    'url' => $domain . '/services/crawl-clarity/',
    'anchor' => 'Crawl Clarity Engineering',
    'type' => 'revenue',
    'required' => true
  ];
  
  // 1.3 Link to Insights root
  $links[] = [
    'url' => $domain . '/insights/',
    'anchor' => 'AI SEO Research & Insights',
    'type' => 'topical',
    'required' => true
  ];
  
  // 1.4 Link to Tools root
  $links[] = [
    'url' => $domain . '/tools/',
    'anchor' => 'SEO Tools & Resources',
    'type' => 'topical',
    'required' => true
  ];
  
  // 1.5 Transactional CTA link
  $links[] = [
    'url' => $domain . '/services/',
    'anchor' => 'Get Started with AI SEO',
    'type' => 'transactional',
    'required' => true
  ];
  
  // Page-type specific links
  switch ($page_type) {
    case 'insights':
    case 'article':
      // Link to related insights
      $related_insights = get_related_insights($page_slug, $metadata);
      foreach ($related_insights as $insight) {
        $links[] = [
          'url' => $domain . '/insights/' . $insight['slug'] . '/',
          'anchor' => $insight['title'],
          'type' => 'related',
          'required' => false
        ];
      }
      
      // Link to specific service based on article topic
      $service_link = get_relevant_service($metadata);
      if ($service_link) {
        $links[] = $service_link;
      }
      break;
      
    case 'services':
    case 'service':
      // Link to related services
      $related_services = get_related_services($page_slug);
      foreach ($related_services as $service) {
        $links[] = [
          'url' => $domain . '/services/' . $service['slug'] . '/',
          'anchor' => $service['name'],
          'type' => 'related',
          'required' => false
        ];
      }
      
      // Link to relevant insights
      $relevant_insights = get_insights_for_service($page_slug);
      foreach ($relevant_insights as $insight) {
        $links[] = [
          'url' => $domain . '/insights/' . $insight['slug'] . '/',
          'anchor' => $insight['title'],
          'type' => 'related',
          'required' => false
        ];
      }
      break;
      
    case 'tools':
    case 'tool':
      // Link to related tools
      $related_tools = get_related_tools($page_slug);
      foreach ($related_tools as $tool) {
        $links[] = [
          'url' => $domain . '/tools/' . $tool['slug'] . '/',
          'anchor' => $tool['name'],
          'type' => 'related',
          'required' => false
        ];
      }
      
      // Link to relevant service
      $service_link = get_service_for_tool($page_slug);
      if ($service_link) {
        $links[] = $service_link;
      }
      break;
  }
  
  return $links;
}

/**
 * Get related insights based on current article
 */
function get_related_insights(string $current_slug, array $metadata = []): array {
  $insights_csv = __DIR__ . '/../data/insights.csv';
  $related = [];
  
  if (!is_file($insights_csv)) {
    return $related;
  }
  
  // Get current article keywords/category
  $current_keywords = explode(',', $metadata['keywords'] ?? '');
  $current_category = $metadata['category'] ?? '';
  
  if (($fp = fopen($insights_csv, 'r')) !== false) {
    $headers = fgetcsv($fp, 0, ',', '"', '\\');
    if ($headers !== false) {
      while (($row = fgetcsv($fp, 0, ',', '"', '\\')) !== false) {
        if (count($row) !== count($headers)) continue;
        
        $data = array_combine($headers, $row);
        if (($data['slug'] ?? '') === $current_slug) continue;
        
        // Check for keyword overlap
        $row_keywords = explode(',', $data['keywords'] ?? '');
        $overlap = count(array_intersect(
          array_map('strtolower', $current_keywords),
          array_map('strtolower', $row_keywords)
        ));
        
        if ($overlap > 0 || count($related) < 3) {
          $related[] = [
            'slug' => $data['slug'] ?? '',
            'title' => $data['title'] ?? ''
          ];
        }
        
        if (count($related) >= 3) break;
      }
    }
    fclose($fp);
  }
  
  return array_slice($related, 0, 3);
}

/**
 * Get relevant service link for an article
 */
function get_relevant_service(array $metadata = []): ?array {
  $keywords = strtolower($metadata['keywords'] ?? '');
  
  // Map keywords to services
  $service_map = [
    'schema' => ['url' => '/services/json-ld-strategy/', 'anchor' => 'JSON-LD Schema Implementation'],
    'crawl' => ['url' => '/services/crawl-clarity/', 'anchor' => 'Crawl Clarity Engineering'],
    'llm' => ['url' => '/services/llm-seeding/', 'anchor' => 'LLM Seeding & Citation Readiness'],
    'technical' => ['url' => '/services/technical-seo/', 'anchor' => 'Technical SEO & Sitemaps'],
    'audit' => ['url' => '/services/site-audits/', 'anchor' => 'AI-First Site Audits']
  ];
  
  foreach ($service_map as $key => $service) {
    if (strpos($keywords, $key) !== false) {
      return [
        'url' => 'https://nrlc.ai' . $service['url'],
        'anchor' => $service['anchor'],
        'type' => 'revenue',
        'required' => false
      ];
    }
  }
  
  return null;
}

/**
 * Get related services
 */
function get_related_services(string $current_slug): array {
  $services_csv = __DIR__ . '/../data/services.csv';
  $related = [];
  
  if (!is_file($services_csv)) {
    return $related;
  }
  
  if (($fp = fopen($services_csv, 'r')) !== false) {
    $headers = fgetcsv($fp, 0, ',', '"', '\\');
    if ($headers !== false) {
      $count = 0;
      while (($row = fgetcsv($fp, 0, ',', '"', '\\')) !== false && $count < 2) {
        if (count($row) !== count($headers)) continue;
        
        $data = array_combine($headers, $row);
        if (($data['slug'] ?? '') === $current_slug) continue;
        
        $related[] = [
          'slug' => $data['slug'] ?? '',
          'name' => $data['name'] ?? ''
        ];
        $count++;
      }
    }
    fclose($fp);
  }
  
  return $related;
}

/**
 * Get insights relevant to a service
 */
function get_insights_for_service(string $service_slug): array {
  // Map services to relevant insights
  $service_insight_map = [
    'crawl-clarity' => ['geo16-introduction', 'silent-hydration-seo'],
    'json-ld-strategy' => ['geo16-framework', 'llm-ontology-generation'],
    'llm-seeding' => ['geo16-results', 'semantic-drift-tracking'],
    'technical-seo' => ['geo16-methodology', 'open-seo-tools'],
    'site-audits' => ['geo16-implications', 'seo-landscape-analysis']
  ];
  
  $insight_slugs = $service_insight_map[$service_slug] ?? ['geo16-introduction', 'geo16-framework'];
  
  $insights_csv = __DIR__ . '/../data/insights.csv';
  $insights = [];
  
  if (is_file($insights_csv) && ($fp = fopen($insights_csv, 'r')) !== false) {
    $headers = fgetcsv($fp, 0, ',', '"', '\\');
    if ($headers !== false) {
      while (($row = fgetcsv($fp, 0, ',', '"', '\\')) !== false) {
        if (count($row) !== count($headers)) continue;
        
        $data = array_combine($headers, $row);
        if (in_array($data['slug'] ?? '', $insight_slugs)) {
          $insights[] = [
            'slug' => $data['slug'] ?? '',
            'title' => $data['title'] ?? ''
          ];
        }
      }
    }
    fclose($fp);
  }
  
  return $insights;
}

/**
 * Get related tools
 */
function get_related_tools(string $current_slug): array {
  // Return a couple of common tools
  return [
    ['slug' => 'json-ld-validator', 'name' => 'JSON-LD Validator'],
    ['slug' => 'schema-generator', 'name' => 'Schema Generator']
  ];
}

/**
 * Get service link for a tool
 */
function get_service_for_tool(string $tool_slug): ?array {
  return [
    'url' => 'https://nrlc.ai/services/json-ld-strategy/',
    'anchor' => 'JSON-LD Strategy Service',
    'type' => 'revenue',
    'required' => false
  ];
}

/**
 * Audit page for internal linking compliance
 * 
 * @param string $content Page HTML content
 * @param string $page_type Page type
 * @param string $page_slug Page slug
 * @return array Audit results with score and recommendations
 */
function audit_page_links(string $content, string $page_type, string $page_slug = ''): array {
  // Extract all internal links from content
  preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $content, $matches);
  
  $internal_links = [];
  $external_links = [];
  $domain = 'https://nrlc.ai';
  
  foreach ($matches[1] ?? [] as $idx => $url) {
    $anchor = strip_tags($matches[2][$idx] ?? '');
    
    if (strpos($url, $domain) === 0 || strpos($url, '/') === 0) {
      $internal_links[] = [
        'url' => $url,
        'anchor' => trim($anchor)
      ];
    } else {
      $external_links[] = [
        'url' => $url,
        'anchor' => trim($anchor)
      ];
    }
  }
  
  // Count link types
  $revenue_links = 0;
  $topical_links = 0;
  $transactional_links = 0;
  
  foreach ($internal_links as $link) {
    $url_lower = strtolower($link['url']);
    if (strpos($url_lower, '/services/') !== false) {
      $revenue_links++;
    }
    if (strpos($url_lower, '/insights/') !== false || strpos($url_lower, '/tools/') !== false) {
      $topical_links++;
    }
    if (strpos($url_lower, 'contact') !== false || strpos($url_lower, 'get-started') !== false || strpos($url_lower, 'demo') !== false) {
      $transactional_links++;
    }
  }
  
  // Calculate score
  $score = 'F';
  $issues = [];
  
  $total_internal = count($internal_links);
  
  if ($total_internal >= 8 && $revenue_links >= 2 && $topical_links >= 2 && $transactional_links >= 1) {
    $score = 'A';
  } elseif ($total_internal >= 5 && $revenue_links >= 1 && $topical_links >= 1) {
    $score = 'B';
  } elseif ($total_internal >= 3) {
    $score = 'C';
  } else {
    $score = 'F';
    $issues[] = 'Insufficient internal links';
  }
  
  if ($revenue_links < 1) {
    $issues[] = 'Missing revenue/service links';
  }
  
  if ($topical_links < 1) {
    $issues[] = 'Missing topical/insight links';
  }
  
  if ($transactional_links < 1) {
    $issues[] = 'Missing transactional CTA link';
  }
  
  // Check for bad anchor text
  $bad_anchors = ['click here', 'read more', 'learn more', 'here', 'this', 'link'];
  foreach ($internal_links as $link) {
    $anchor_lower = strtolower($link['anchor']);
    if (in_array($anchor_lower, $bad_anchors) || strlen($anchor_lower) < 3) {
      $issues[] = 'Poor anchor text: "' . $link['anchor'] . '"';
    }
  }
  
  return [
    'score' => $score,
    'total_internal' => $total_internal,
    'revenue_links' => $revenue_links,
    'topical_links' => $topical_links,
    'transactional_links' => $transactional_links,
    'external_links' => count($external_links),
    'issues' => $issues,
    'recommendations' => generate_link_recommendations($page_type, $page_slug, $score, $issues)
  ];
}

/**
 * Generate link recommendations based on audit
 */
function generate_link_recommendations(string $page_type, string $page_slug, string $score, array $issues): array {
  $recommendations = [];
  
  if ($score === 'F' || $score === 'C') {
    $required_links = get_required_internal_links($page_type, $page_slug);
    foreach ($required_links as $link) {
      if ($link['required']) {
        $recommendations[] = [
          'action' => 'add',
          'url' => $link['url'],
          'anchor' => $link['anchor'],
          'reason' => 'Required ' . $link['type'] . ' link'
        ];
      }
    }
  }
  
  return $recommendations;
}

/**
 * Render internal links section HTML
 * 
 * @param string $page_type Page type
 * @param string $page_slug Page slug
 * @param array $metadata Page metadata
 * @param string $section_title Section title
 * @return string HTML for links section
 */
function render_internal_links_section(string $page_type, string $page_slug = '', array $metadata = [], string $section_title = 'Related Resources'): string {
  $links = get_required_internal_links($page_type, $page_slug, $metadata);
  
  if (empty($links)) {
    return '';
  }
  
  // Filter to show both required and some related links
  $display_links = array_filter($links, function($link) {
    return $link['required'] || $link['type'] === 'related';
  });
  
  if (empty($display_links)) {
    return '';
  }
  
  $html = '<div class="content-block module">';
  $html .= '<div class="content-block__header">';
  $html .= '<h2 class="content-block__title">' . htmlspecialchars($section_title) . '</h2>';
  $html .= '</div>';
  $html .= '<div class="content-block__body">';
  $html .= '<ul>';
  
  foreach ($display_links as $link) {
    $html .= '<li>';
    $html .= '<a href="' . htmlspecialchars($link['url']) . '">';
    $html .= htmlspecialchars($link['anchor']);
    $html .= '</a>';
    $html .= '</li>';
  }
  
  $html .= '</ul>';
  $html .= '</div>';
  $html .= '</div>';
  
  return $html;
}

/**
 * Inject required links into content if missing
 * 
 * @param string $content Page HTML content
 * @param string $page_type Page type
 * @param string $page_slug Page slug
 * @param array $metadata Page metadata
 * @return string Content with injected links
 */
function inject_required_links(string $content, string $page_type, string $page_slug = '', array $metadata = []): string {
  $audit = audit_page_links($content, $page_type, $page_slug);
  
  // If score is A, no changes needed
  if ($audit['score'] === 'A') {
    return $content;
  }
  
  // Get required links
  $required_links = get_required_internal_links($page_type, $page_slug, $metadata);
  
  // Check which required links are missing
  $missing_links = [];
  foreach ($required_links as $link) {
    if (!$link['required']) continue;
    
    // Check if link exists in content
    $url_pattern = preg_quote($link['url'], '/');
    if (!preg_match('/' . $url_pattern . '/i', $content)) {
      $missing_links[] = $link;
    }
  }
  
  // Inject missing links before closing main tag or at end of content
  if (!empty($missing_links)) {
    $links_html = '<div class="content-block module">';
    $links_html .= '<div class="content-block__header">';
    $links_html .= '<h2 class="content-block__title">Related Resources</h2>';
    $links_html .= '</div>';
    $links_html .= '<div class="content-block__body">';
    $links_html .= '<ul>';
    
    foreach ($missing_links as $link) {
      $links_html .= '<li><a href="' . htmlspecialchars($link['url']) . '">' . htmlspecialchars($link['anchor']) . '</a></li>';
    }
    
    $links_html .= '</ul>';
    $links_html .= '</div>';
    $links_html .= '</div>';
    
    // Insert before closing main or section tag
    if (preg_match('/(<\/main>|<\/section>)/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
      $pos = $matches[0][1];
      $content = substr_replace($content, $links_html . "\n" . $matches[0][0], $pos, 0);
    } else {
      $content .= $links_html;
    }
  }
  
  return $content;
}

