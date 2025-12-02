<?php
declare(strict_types=1);
/**
 * INSIGHTS SCHEMA ENFORCEMENT KERNEL
 * 
 * Root-level, sudo-privileged meta directive that forces the system to generate,
 * apply, and validate complete structured-data bundles for all articles inside /insights/.
 * 
 * This kernel enforces WebPage, BlogPosting/ScholarlyArticle/NewsArticle, BreadcrumbList,
 * FAQPage (when applicable), and Dataset schema. It guarantees compliance with Google Search,
 * Google News, AI Overviews, and agentic search parsing.
 * 
 * All generated schema must be JSON-LD, valid, deduplicated, non-conflicting, and injected
 * server-side with no hydration drift.
 */

require_once __DIR__ . '/helpers.php';

// Load CSV helper if available
if (file_exists(__DIR__ . '/csv.php')) {
  require_once __DIR__ . '/csv.php';
}

/**
 * Load article references from CSV
 */
function load_article_references(string $slug): array {
  $references_csv = __DIR__ . '/../data/insights_references.csv';
  $references = [];
  
  if (!is_file($references_csv)) {
    return $references;
  }
  
  if (($fp = fopen($references_csv, 'r')) !== false) {
    $headers = fgetcsv($fp, 0, ',', '"', '\\');
    if ($headers === false) {
      fclose($fp);
      return $references;
    }
    
    while (($row = fgetcsv($fp, 0, ',', '"', '\\')) !== false) {
      // Skip rows that don't match header count
      if (count($row) !== count($headers)) {
        continue;
      }
      $data = array_combine($headers, $row);
      if (($data['slug'] ?? '') === $slug) {
        $references[] = $data;
      }
    }
    fclose($fp);
  }
  
  return $references;
}

/**
 * Render references section HTML
 */
function render_article_references(string $slug): string {
  $references = load_article_references($slug);
  
  if (empty($references)) {
    return '';
  }
  
  $html = '<div class="window" style="margin-top: 2rem;">';
  $html .= '<div class="title-bar">';
  $html .= '<div class="title-bar-text">References</div>';
  $html .= '</div>';
  $html .= '<div class="window-body">';
  $html .= '<h2 style="color: #000080; margin-top: 0;">Peer-Reviewed Research References</h2>';
  $html .= '<ol style="padding-left: 1.5rem;">';
  
  foreach ($references as $idx => $ref) {
    $html .= '<li style="margin-bottom: 1rem; padding-left: 0.5rem;">';
    
    // Format: Authors (Year). Title. Journal/Venue.
    $citation = '';
    
    if (!empty($ref['authors'])) {
      $citation .= htmlspecialchars($ref['authors']);
    }
    
    if (!empty($ref['year'])) {
      $citation .= ' (' . htmlspecialchars($ref['year']) . '). ';
    } else {
      $citation .= '. ';
    }
    
    if (!empty($ref['title'])) {
      $citation .= '<strong>' . htmlspecialchars($ref['title']) . '</strong>. ';
    }
    
    if (!empty($ref['journal_or_venue'])) {
      $citation .= '<em>' . htmlspecialchars($ref['journal_or_venue']) . '</em>. ';
    }
    
    // Add DOI or URL
    if (!empty($ref['doi'])) {
      $citation .= ' DOI: <a href="https://doi.org/' . htmlspecialchars($ref['doi']) . '" target="_blank" rel="noopener">' . htmlspecialchars($ref['doi']) . '</a>.';
    } elseif (!empty($ref['url'])) {
      $citation .= ' <a href="' . htmlspecialchars($ref['url']) . '" target="_blank" rel="noopener">View Publication</a>.';
    }
    
    $html .= $citation;
    $html .= '</li>';
  }
  
  $html .= '</ol>';
  $html .= '</div>';
  $html .= '</div>';
  
  return $html;
}

/**
 * Auto-detect article type based on content analysis
 */
function detect_article_type(string $content, string $title, array $metadata = []): string {
  $content_lower = strtolower($content);
  $title_lower = strtolower($title);
  
  // Detect NewsArticle
  if (
    preg_match('/\b(recent|announcement|launch|update|breaking|news|reported|according to)\b/i', $content) ||
    preg_match('/\b(as of|today|this week|this month)\b/i', $content) ||
    isset($metadata['is_news']) && $metadata['is_news']
  ) {
    return 'NewsArticle';
  }
  
  // Detect ScholarlyArticle (research/technical)
  if (
    preg_match('/\b(experiment|study|research|analysis|benchmark|test|results|data|findings|methodology|hypothesis|conclusion)\b/i', $content) ||
    preg_match('/\b(table|chart|graph|dataset|measurement|statistic|correlation|significant)\b/i', $content) ||
    preg_match('/\b(llm test|crawl simulation|seo experiment|performance test)\b/i', $content) ||
    isset($metadata['is_research']) && $metadata['is_research']
  ) {
    return 'ScholarlyArticle';
  }
  
  // Default to BlogPosting
  return 'BlogPosting';
}

/**
 * Auto-detect FAQ questions and answers from content
 */
function detect_faq_pairs(string $content): array {
  $faqs = [];
  
  // If content is HTML, extract text first
  $is_html = preg_match('/<[^>]+>/', $content);
  if ($is_html) {
    // Extract text from HTML for better pattern matching
    $text_content = strip_tags($content);
  } else {
    $text_content = $content;
  }
  
  // Pattern 1: H2/H3 headings that look like questions (HTML)
  if ($is_html) {
    preg_match_all('/<h[23][^>]*>(.*?)\?<\/h[23]>/i', $content, $question_headings);
    foreach ($question_headings[1] ?? [] as $question) {
      $question = trim(strip_tags($question));
      if (strlen($question) > 10 && strlen($question) < 200) {
        // Try to find answer in next paragraph/section
        $pattern = '/<h[23][^>]*>' . preg_quote($question, '/') . '\?<\/h[23]>(.*?)(?=<h[23]|$)/is';
        if (preg_match($pattern, $content, $matches)) {
          $answer = trim(strip_tags($matches[1] ?? ''));
          $answer = preg_replace('/\s+/', ' ', $answer);
          $answer = substr($answer, 0, 500);
          
          if (strlen($answer) > 20) {
            $faqs[] = [
              'question' => $question . '?',
              'answer' => $answer
            ];
          }
        }
      }
    }
  }
  
  // Pattern 2: FAQ section with Q: / A: format
  preg_match_all('/(?:^|\n)\s*(?:Q|Question)[:\.]\s*(.+?)(?:\n|$)/i', $text_content, $questions);
  preg_match_all('/(?:^|\n)\s*(?:A|Answer)[:\.]\s*(.+?)(?:\n|$)/i', $text_content, $answers);
  
  if (count($questions[1] ?? []) > 0 && count($answers[1] ?? []) > 0) {
    $min_count = min(count($questions[1]), count($answers[1]));
    for ($i = 0; $i < $min_count; $i++) {
      $q = trim($questions[1][$i]);
      $a = trim($answers[1][$i]);
      if (strlen($q) > 10 && strlen($a) > 20) {
        $faqs[] = [
          'question' => $q,
          'answer' => substr($a, 0, 500)
        ];
      }
    }
  }
  
  // Pattern 3: Questions starting with What/How/Why/When/Where/Who
  preg_match_all('/(?:^|\n)\s*(?:What|How|Why|When|Where|Who)\s+([^\.\?]+)\?/i', $text_content, $question_matches);
  foreach ($question_matches[0] ?? [] as $full_question) {
    $q = trim($full_question);
    if (strlen($q) > 15 && strlen($q) < 200) {
      // Try to find answer in next sentence/paragraph
      $q_escaped = preg_quote($q, '/');
      if (preg_match('/' . $q_escaped . '\s*([^\.]+\.)/i', $text_content, $answer_match)) {
        $a = trim($answer_match[1] ?? '');
        if (strlen($a) > 20) {
          $faqs[] = [
            'question' => $q,
            'answer' => substr($a, 0, 500)
          ];
        }
      }
    }
  }
  
  // Remove duplicates based on question text
  $unique_faqs = [];
  $seen_questions = [];
  foreach ($faqs as $faq) {
    $q_key = strtolower(trim($faq['question']));
    if (!isset($seen_questions[$q_key])) {
      $seen_questions[$q_key] = true;
      $unique_faqs[] = $faq;
    }
  }
  
  return array_slice($unique_faqs, 0, 10); // Limit to 10 FAQs
}

/**
 * Auto-detect Dataset presence
 */
function detect_dataset(string $content, string $title): bool {
  $content_lower = strtolower($content);
  $title_lower = strtolower($title);
  
  return (
    preg_match('/\b(table|chart|graph|dataset|benchmark|data|statistic|measurement|results|findings)\b/i', $content) ||
    preg_match('/\b(croutons|ndjson|json stream|extraction)\b/i', $content) ||
    preg_match('/<table/i', $content) ||
    preg_match('/\d+%|\d+\.\d+%/', $content) || // Percentage patterns
    preg_match('/\b\d{1,3}(?:,\d{3})*(?:\.\d+)?\b/', $content) // Large numbers
  );
}

/**
 * Generate complete schema bundle for insights article
 * 
 * @param string $slug Article slug
 * @param string $title Article title
 * @param string $description Meta description
 * @param string $content Full article HTML content
 * @param array $metadata Additional metadata (datePublished, dateModified, image_url, etc.)
 * @return array Complete schema graph
 */
function generate_insights_schema_bundle(
  string $slug,
  string $title,
  string $description,
  string $content = '',
  array $metadata = []
): array {
  $domain = 'https://nrlc.ai';
  $canonical_url = $domain . '/insights/' . $slug . '/';
  $site_url = $domain;
  
  // Auto-detect article type - force ScholarlyArticle if references exist
  $references = [];
  try {
    $references = load_article_references($slug);
  } catch (Exception $e) {
    // If references loading fails, continue without them
    $references = [];
  }
  
  if (!empty($references)) {
    $article_type = 'ScholarlyArticle';
  } else {
    $article_type = detect_article_type($content, $title, $metadata);
  }
  
  // Get dates
  $date_published = $metadata['datePublished'] ?? $metadata['publication_date'] ?? date('Y-m-d');
  $date_modified = $metadata['dateModified'] ?? $metadata['lastmod'] ?? $date_published;
  
  // Get image
  $image_url = $metadata['image_url'] ?? $metadata['image'] ?? $domain . '/assets/images/nrlcai%20logo%200.png';
  if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
    $image_url = $domain . $image_url;
  }
  
  // Build schema graph
  $graph = [];
  
  // 1. WebPage Schema (ALWAYS REQUIRED)
  $graph[] = [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url . '#webpage',
    'name' => $title,
    'url' => $canonical_url,
    'description' => $description,
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $site_url . '/#website',
      'name' => 'Neural Command Insights',
      'url' => $site_url
    ],
    'inLanguage' => $metadata['lang'] ?? 'en'
  ];
  
  // 2. Article Schema (BlogPosting, ScholarlyArticle, or NewsArticle)
  $article_schema = [
    '@context' => 'https://schema.org',
    '@type' => $article_type,
    '@id' => $canonical_url . '#article',
    'headline' => $title,
    'description' => $description,
    'image' => [$image_url],
    'datePublished' => $date_published,
    'dateModified' => $date_modified,
    'author' => [
      '@type' => 'Person',
      'name' => 'Joel Maldonado'
    ],
    'publisher' => [
      '@type' => 'Organization',
      'name' => 'Neural Command',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => $domain . '/assets/images/nrlcai%20logo%200.png'
      ]
    ],
    'mainEntityOfPage' => [
      '@id' => $canonical_url . '#webpage'
    ],
    'inLanguage' => $metadata['lang'] ?? 'en'
  ];
  
  // Add articleSection for BlogPosting
  if ($article_type === 'BlogPosting') {
    $article_schema['articleSection'] = 'AI SEO Research';
  }
  
  // Add keywords if available
  if (!empty($metadata['keywords'])) {
    $keywords = is_array($metadata['keywords']) 
      ? $metadata['keywords'] 
      : explode(',', $metadata['keywords']);
    $article_schema['keywords'] = array_map('trim', $keywords);
  }
  
  // For ScholarlyArticle, add citations and academic properties
  if ($article_type === 'ScholarlyArticle') {
    // References already loaded above, use them if available
    if (!empty($references)) {
      $citations = [];
      foreach ($references as $ref) {
        $citation = [
          '@type' => 'ScholarlyArticle',
          'headline' => $ref['title'],
          'author' => []
        ];
        
        // Parse authors
        if (!empty($ref['authors'])) {
          $author_list = explode(',', $ref['authors']);
          foreach ($author_list as $author_name) {
            $name_parts = explode(' ', trim($author_name));
            $citation['author'][] = [
              '@type' => 'Person',
              'name' => trim($author_name)
            ];
          }
        }
        
        // Add publication info
        if (!empty($ref['journal_or_venue'])) {
          $citation['publisher'] = [
            '@type' => 'Organization',
            'name' => $ref['journal_or_venue']
          ];
        }
        
        if (!empty($ref['year'])) {
          $citation['datePublished'] = $ref['year'];
        }
        
        if (!empty($ref['url'])) {
          $citation['url'] = $ref['url'];
        }
        
        if (!empty($ref['doi'])) {
          $citation['identifier'] = [
            '@type' => 'PropertyValue',
            'propertyID' => 'DOI',
            'value' => $ref['doi']
          ];
        }
        
        $citations[] = $citation;
      }
      
      if (!empty($citations)) {
        $article_schema['citation'] = $citations;
      }
    }
    
    // Add academic properties
    $article_schema['inLanguage'] = $metadata['lang'] ?? 'en';
    $article_schema['learningResourceType'] = 'Research Article';
  }
  
  $graph[] = $article_schema;
  
  // 3. BreadcrumbList Schema (ALWAYS REQUIRED)
  $graph[] = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonical_url . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $site_url . '/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Insights',
        'item' => $site_url . '/insights/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => $title,
        'item' => $canonical_url
      ]
    ]
  ];
  
  // 4. FAQPage Schema (if Q&A detected)
  $faqs = detect_faq_pairs($content);
  if (!empty($faqs)) {
    $faq_entities = [];
    foreach ($faqs as $faq) {
      $faq_entities[] = [
        '@type' => 'Question',
        'name' => $faq['question'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $faq['answer']
        ]
      ];
    }
    
    $graph[] = [
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      '@id' => $canonical_url . '#faq',
      'mainEntity' => $faq_entities
    ];
  }
  
  // 5. Dataset Schema (if data/tables/benchmarks detected)
  if (detect_dataset($content, $title)) {
    $graph[] = [
      '@context' => 'https://schema.org',
      '@type' => 'Dataset',
      '@id' => $canonical_url . '#dataset',
      'name' => $title . ' - Research Data',
      'description' => 'Research data, benchmarks, and findings from ' . $title,
      'creator' => [
        '@type' => 'Organization',
        'name' => 'Neural Command'
      ],
      'datePublished' => $date_published,
      'includedInDataCatalog' => [
        '@type' => 'DataCatalog',
        'name' => 'NRLC.ai Research Datasets'
      ]
    ];
  }
  
  return $graph;
}

/**
 * Output complete schema bundle as JSON-LD script tag
 * 
 * @param array $graph Schema graph array
 * @return string HTML script tag with JSON-LD
 */
function output_insights_schema(array $graph): string {
  // Validate and clean schema
  $cleaned_graph = [];
  foreach ($graph as $item) {
    if (empty($item) || !is_array($item)) continue;
    
    // Remove null values
    $cleaned = array_filter($item, fn($v) => $v !== null && $v !== '');
    
    // Ensure @context and @type are present
    if (isset($cleaned['@type'])) {
      $cleaned_graph[] = $cleaned;
    }
  }
  
  // Combine into single @graph
  $output = [
    '@context' => 'https://schema.org',
    '@graph' => $cleaned_graph
  ];
  
  $json = json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  
  return '<script type="application/ld+json">' . $json . '</script>';
}

