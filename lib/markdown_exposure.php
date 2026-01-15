<?php
/**
 * Machine-Native Markdown Exposure System
 * 
 * Converts eligible HTML pages to Markdown format for AI agent consumption.
 * Implements META DIRECTIVE KERNEL: NRLC.AI — MACHINE-NATIVE CONTENT EXPOSURE
 */

/**
 * Check if a page is eligible for Markdown exposure
 * 
 * Eligible pages:
 * - Insights / Articles
 * - Research / Doctrine
 * - Case Studies (editorial only)
 * - Training / Educational content
 * 
 * NOT eligible:
 * - Service landing pages
 * - Conversion funnels
 * - Pricing pages
 * - Authentication-gated content
 * - API endpoints
 * - Dashboards
 * - Admin routes
 */
function is_markdown_eligible($path): bool {
  // Remove locale prefix for eligibility check
  $checkPath = $path;
  if (preg_match('#^/([a-z]{2})-([a-z]{2})(.+)$#i', $checkPath, $m)) {
    $checkPath = $m[3];
  }
  
  // Insights and research articles
  if (preg_match('#^/insights/#', $checkPath)) {
    return true;
  }
  
  // Case studies (editorial only - check if it's a specific case study page)
  if (preg_match('#^/case-studies/([^/]+)/$#', $checkPath)) {
    // Only editorial case studies (not generic case-study.php or index)
    $slug = basename($checkPath, '/');
    if ($slug !== 'case-study' && $slug !== 'index') {
      return true;
    }
  }
  
  // Training/educational content (if exists)
  if (preg_match('#^/training/#', $checkPath)) {
    return true;
  }
  
  // Research pages (if exists)
  if (preg_match('#^/research/#', $checkPath)) {
    return true;
  }
  
  return false;
}

/**
 * Convert HTML content to Markdown
 * 
 * Extracts semantic content from HTML, removing:
 * - Navigation
 * - Footers
 * - CTAs
 * - Conversion copy
 * - Layout artifacts
 * - JS references
 * - Embeds
 * - Ads
 */
function html_to_markdown($html, $pageMeta): string {
  // Load DOMDocument
  $dom = new DOMDocument();
  @$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  
  // Remove unwanted elements
  $xpath = new DOMXPath($dom);
  
  // Remove navigation, headers, footers, CTAs, buttons
  $removeSelectors = [
    '//nav',
    '//header',
    '//footer',
    '//*[contains(@class, "nav")]',
    '//*[contains(@class, "header")]',
    '//*[contains(@class, "footer")]',
    '//*[contains(@class, "btn")]',
    '//*[contains(@class, "cta")]',
    '//*[contains(@class, "conversion")]',
    '//script',
    '//style',
    '//noscript',
    '//iframe',
    '//embed',
    '//object',
  ];
  
  foreach ($removeSelectors as $selector) {
    $nodes = $xpath->query($selector);
    foreach ($nodes as $node) {
      $node->parentNode->removeChild($node);
    }
  }
  
  // Extract main content
  $main = $xpath->query('//main')->item(0);
  if (!$main) {
    $main = $xpath->query('//article')->item(0);
  }
  if (!$main) {
    $main = $xpath->query('//body')->item(0);
  }
  
  if (!$main) {
    return '';
  }
  
  // Convert to Markdown
  $markdown = '';
  
  // Add frontmatter
  $markdown .= "---\n";
  $markdown .= "title: " . ($pageMeta['title'] ?? 'Untitled') . "\n";
  $markdown .= "description: " . ($pageMeta['description'] ?? '') . "\n";
  if (isset($pageMeta['datePublished'])) {
    $markdown .= "datePublished: " . $pageMeta['datePublished'] . "\n";
  }
  if (isset($pageMeta['dateModified'])) {
    $markdown .= "dateModified: " . $pageMeta['dateModified'] . "\n";
  }
  if (isset($pageMeta['author'])) {
    $markdown .= "author: " . $pageMeta['author'] . "\n";
  }
  $markdown .= "organization: Neural Command LLC\n";
  $markdown .= "canonical: " . ($pageMeta['canonical'] ?? '') . "\n";
  if (isset($pageMeta['topics'])) {
    $markdown .= "topics: " . (is_array($pageMeta['topics']) ? implode(', ', $pageMeta['topics']) : $pageMeta['topics']) . "\n";
  }
  if (isset($pageMeta['entities'])) {
    $markdown .= "entities: " . (is_array($pageMeta['entities']) ? implode(', ', $pageMeta['entities']) : $pageMeta['entities']) . "\n";
  }
  $markdown .= "---\n\n";
  
  // Convert DOM to Markdown
  $markdown .= dom_to_markdown($main, $xpath);
  
  // Add attribution block
  $canonicalUrl = $pageMeta['canonical'] ?? '';
  $markdown .= "\n\n---\n\n";
  $markdown .= "Source: " . $canonicalUrl . "\n";
  $markdown .= "Publisher: Neural Command LLC\n";
  $markdown .= "License: Editorial use with attribution\n";
  
  return $markdown;
}

/**
 * Convert DOM node to Markdown recursively
 */
function dom_to_markdown($node, $xpath): string {
  $markdown = '';
  
  foreach ($node->childNodes as $child) {
    if ($child->nodeType === XML_TEXT_NODE) {
      $text = trim($child->textContent);
      if (!empty($text)) {
        $markdown .= $text . "\n\n";
      }
    } elseif ($child->nodeType === XML_ELEMENT_NODE) {
      $tagName = strtolower($child->tagName);
      
      switch ($tagName) {
        case 'h1':
          $markdown .= '# ' . trim($child->textContent) . "\n\n";
          break;
        case 'h2':
          $markdown .= '## ' . trim($child->textContent) . "\n\n";
          break;
        case 'h3':
          $markdown .= '### ' . trim($child->textContent) . "\n\n";
          break;
        case 'h4':
          $markdown .= '#### ' . trim($child->textContent) . "\n\n";
          break;
        case 'h5':
          $markdown .= '##### ' . trim($child->textContent) . "\n\n";
          break;
        case 'h6':
          $markdown .= '###### ' . trim($child->textContent) . "\n\n";
          break;
        case 'p':
          $text = trim($child->textContent);
          if (!empty($text)) {
            $markdown .= $text . "\n\n";
          }
          break;
        case 'ul':
        case 'ol':
          $markdown .= dom_to_markdown($child, $xpath);
          break;
        case 'li':
          $text = trim($child->textContent);
          if (!empty($text)) {
            $markdown .= '- ' . $text . "\n";
          }
          break;
        case 'strong':
        case 'b':
          $markdown .= '**' . trim($child->textContent) . '**';
          break;
        case 'em':
        case 'i':
          $markdown .= '*' . trim($child->textContent) . '*';
          break;
        case 'code':
          $markdown .= '`' . trim($child->textContent) . '`';
          break;
        case 'a':
          $href = $child->getAttribute('href');
          $text = trim($child->textContent);
          if (!empty($href) && !empty($text)) {
            // Only include internal links
            if (strpos($href, 'http') !== 0 || strpos($href, 'nrlc.ai') !== false) {
              $markdown .= '[' . $text . '](' . $href . ')';
            } else {
              $markdown .= $text;
            }
          } else {
            $markdown .= $text;
          }
          break;
        case 'blockquote':
          $text = trim($child->textContent);
          $lines = explode("\n", $text);
          foreach ($lines as $line) {
            if (!empty(trim($line))) {
              $markdown .= '> ' . trim($line) . "\n";
            }
          }
          $markdown .= "\n";
          break;
        default:
          // Recursively process child nodes
          $markdown .= dom_to_markdown($child, $xpath);
          break;
      }
    }
  }
  
  return $markdown;
}

/**
 * Get Markdown URL for a given path
 */
function get_markdown_url($path): string {
  // Remove trailing slash if present
  $path = rtrim($path, '/');
  // Add .md extension
  return $path . '.md';
}

/**
 * Serve Markdown response with proper headers
 */
function serve_markdown($markdown, $canonicalUrl): void {
  // Set headers
  header('Content-Type: text/markdown; charset=UTF-8');
  header('X-NRLC-Canonical: ' . $canonicalUrl);
  header('X-NRLC-Format: markdown');
  header('X-NRLC-Audience: machine');
  header('X-NRLC-Experiment: md-exposure-v1');
  
  // Log Markdown fetch
  error_log("MARKDOWN_FETCH: " . $canonicalUrl . " | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . " | UA: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'));
  
  // Output Markdown
  echo $markdown;
  exit;
}
