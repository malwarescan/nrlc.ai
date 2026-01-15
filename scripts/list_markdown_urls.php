#!/usr/bin/env php
<?php
/**
 * List all available Markdown (.md) URLs
 * 
 * Generates a complete list of all eligible pages that have Markdown representations
 */

require_once __DIR__ . '/../lib/markdown_exposure.php';
require_once __DIR__ . '/../lib/helpers.php';

$baseUrl = 'https://nrlc.ai';
$markdownUrls = [];

// Insights articles
$insightArticles = [
  // GEO-16 articles
  'geo16-introduction',
  'geo16-framework',
  'geo16-methodology',
  'geo16-results',
  'geo16-implications',
  'geo16-conclusion',
  // Additional insights
  'llm-ontology-generation',
  'semantic-seo-in-news',
  'semantic-queries',
  'semantic-modeling',
  'data-virtualization',
  'performance-caching',
  'enterprise-llm',
  'knowledge-graph',
  'seo-landscape-analysis',
  'ocrplus-data-ingestion',
  'semantic-drift-tracking',
  'yago-entity-mapping',
  'ontology-based-search',
  'open-seo-tools',
  'industry-insights',
  'tool-reviews',
  'goldmine-google-title-selection',
  'silent-hydration-seo',
  'google-llms-txt-ai-seo',
  'indexing-suppression-paid-search',
  // Enterprise Schema cluster
  'enterprise-schema-markup',
  'schema-governance-and-validation',
  // LLM Strategist cluster
  'glossary/llm-strategist',
  'llm-strategist-vs-seo-strategist',
  'ai-search-roles',
  'llm-search-strategy-framework',
  'how-llm-strategists-influence-retrieval',
  'llm-strategist-faq',
  'how-to-become-an-llm-strategist',
  // Content chunking cluster
  'content-chunking-seo',
  'prechunking-content-ai-retrieval',
  'ai-retrieval-llm-citation',
  'grounding-budgets-prechunking',
  // ChatGPT business mentions
  'how-to-get-your-business-mentioned-in-chatgpt',
  // Medical information retrieval research
  'semantic-constraint-medical-information-retrieval',
];

foreach ($insightArticles as $slug) {
  // Both with and without locale prefix
  $markdownUrls[] = $baseUrl . '/insights/' . $slug . '.md';
  $markdownUrls[] = $baseUrl . '/en-us/insights/' . $slug . '.md';
}

// Case studies
$caseStudySlugs = [
  'entity-semantic-poisoning-saw',
  'b2b-saas',
  'ecommerce',
  'healthcare',
  'fintech',
  'education',
  'real-estate',
];

foreach ($caseStudySlugs as $slug) {
  // Both with and without locale prefix
  $markdownUrls[] = $baseUrl . '/case-studies/' . $slug . '.md';
  $markdownUrls[] = $baseUrl . '/en-us/case-studies/' . $slug . '.md';
}

// Sort and deduplicate
$markdownUrls = array_unique($markdownUrls);
sort($markdownUrls);

// Output
echo "# Available Markdown URLs\n\n";
echo "Total: " . count($markdownUrls) . " URLs\n\n";
echo "## Insights Articles\n\n";
foreach ($markdownUrls as $url) {
  if (strpos($url, '/insights/') !== false) {
    echo "- $url\n";
  }
}

echo "\n## Case Studies\n\n";
foreach ($markdownUrls as $url) {
  if (strpos($url, '/case-studies/') !== false) {
    echo "- $url\n";
  }
}

echo "\n## All URLs (Complete List)\n\n";
foreach ($markdownUrls as $url) {
  echo "$url\n";
}
