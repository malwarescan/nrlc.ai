<?php
// Metadata is handled by router via $GLOBALS['__page_meta']

// Note: head.php and header.php are already included by router.php render_page()
// Do not duplicate them here to avoid double headers

$slug = $_GET['slug'] ?? '';

// Handle GEO-16 articles
$geo16_articles = [
  'geo16-introduction' => 'geo16-introduction.php',
  'geo16-framework' => 'geo16-framework.php', 
  'geo16-methodology' => 'geo16-methodology.php',
  'geo16-results' => 'geo16-results.php',
  'geo16-implications' => 'geo16-implications.php',
  'geo16-conclusion' => 'geo16-conclusion.php'
];

// Handle additional insight articles
$insight_articles = [
  'llm-ontology-generation' => 'llm-ontology-generation.php',
  'semantic-seo-in-news' => 'semantic-seo-in-news.php',
  'semantic-queries' => 'semantic-queries.php',
  'semantic-modeling' => 'semantic-modeling.php',
  'data-virtualization' => 'data-virtualization.php',
  'performance-caching' => 'performance-caching.php',
  'enterprise-llm' => 'enterprise-llm.php',
  'knowledge-graph' => 'knowledge-graph.php',
  'seo-landscape-analysis' => 'seo-landscape-analysis.php',
  'ocrplus-data-ingestion' => 'ocrplus-data-ingestion.php',
  'semantic-drift-tracking' => 'semantic-drift-tracking.php',
  'yago-entity-mapping' => 'yago-entity-mapping.php',
  'ontology-based-search' => 'ontology-based-search.php',
  'open-seo-tools' => 'open-seo-tools.php',
  'industry-insights' => 'industry-insights.php',
  'tool-reviews' => 'tool-reviews.php',
  'goldmine-google-title-selection' => 'goldmine-google-title-selection.php',
  'silent-hydration-seo' => 'silent-hydration-seo.php',
  'google-llms-txt-ai-seo' => 'google-llms-txt-ai-seo.php',
  'indexing-suppression-paid-search' => 'indexing-suppression-paid-search.php',
  // Enterprise Schema cluster pages
  'enterprise-schema-markup' => 'enterprise-schema-markup.php',
  'schema-governance-and-validation' => 'schema-governance-and-validation.php',
  // LLM Strategist cluster pages
  'glossary/llm-strategist' => 'glossary-llm-strategist.php',
  'llm-strategist-vs-seo-strategist' => 'llm-strategist-vs-seo-strategist.php',
  'ai-search-roles' => 'ai-search-roles.php',
  'llm-search-strategy-framework' => 'llm-search-strategy-framework.php',
  'how-llm-strategists-influence-retrieval' => 'how-llm-strategists-influence-retrieval.php',
  'llm-strategist-faq' => 'llm-strategist-faq.php',
  'how-to-become-an-llm-strategist' => 'how-to-become-an-llm-strategist.php',
  // Content chunking cluster pages
  'content-chunking-seo' => 'content-chunking-seo.php',
  'prechunking-content-ai-retrieval' => 'prechunking-content-ai-retrieval.php',
  'ai-retrieval-llm-citation' => 'ai-retrieval-llm-citation.php',
  // Localized slugs (es-es, fr-fr, de-de, ko-kr slugs map to same file)
  'goldmine-seleccion-titulos-google' => 'goldmine-google-title-selection.php',
  'goldmine-selection-titres-google' => 'goldmine-google-title-selection.php',
  'goldmine-google-titelauswahl' => 'goldmine-google-title-selection.php',
  'goldmine-google-제목-선정' => 'goldmine-google-title-selection.php'
];

// Combine all articles
$all_articles = array_merge($geo16_articles, $insight_articles);

if (isset($all_articles[$slug])) {
  // Set flag before including article so article can check if nav is needed
  $GLOBALS['__insights_nav_needed'] = true;
  include __DIR__ . '/' . $all_articles[$slug];
  // Add navigation back to insights index if article didn't add it
  if (!isset($GLOBALS['__insights_nav_added'])) {
    echo '<div class="content-block module">';
    echo '<div class="content-block__body">';
    echo '<p><a href="/insights/" class="btn">← View All Research & Insights</a></p>';
    echo '</div>';
    echo '</div>';
  }
  return;
}

// Default insights page
?>
<main class="container">
  <h1>Insights</h1>
  <p>Publishing soon.</p>
</main>

