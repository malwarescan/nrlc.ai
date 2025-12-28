<?php
/**
 * TIER 1: Glossary Definition Page
 * URL: /en-gb/insights/glossary/llm-strategist/
 * Primary Intent: "what is an llm strategist"
 */

$hubLink = '<p><a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> role overview | <a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> definition</p>';

$definition = '<div class="card" style="padding:1.5rem; background:#f9f9f9; border-left:4px solid #0066cc; margin:1rem 0;">
  <p><strong>An LLM Strategist</strong> designs and runs the systems that influence how large language models retrieve, cite, and summarize information about a brand, product, or topic across AI answer engines like ChatGPT, Claude, Perplexity, and Google AI Overviews.</p>
  <p>Unlike traditional SEO roles that focus on search engine rankings, LLM Strategists optimize for retrieval accuracy, citation attribution, and entity alignment—ensuring AI systems correctly understand and reference brands when users ask questions.</p>
</div>';

$coreResponsibilities = '<h2>Core Responsibilities</h2>
<ul>
  <li>Design structured data architectures that enable accurate entity recognition and citation in AI systems</li>
  <li>Develop retrieval optimization strategies that increase brand visibility in ChatGPT, Claude, Perplexity, and Google AI Overviews</li>
  <li>Create and maintain canonical control systems that ensure AI engines cite the correct authoritative sources</li>
  <li>Track and analyze citation rates, retrieval surface area, and entity alignment metrics</li>
  <li>Test and validate how AI systems retrieve and cite brand information across different query types</li>
</ul>';

$skills = '<h2>Skills</h2>
<ul>
  <li>Technical SEO foundation (structured data, schema.org, canonical tags)</li>
  <li>Entity recognition systems knowledge</li>
  <li>Data modeling and information architecture</li>
  <li>Retrieval optimization understanding</li>
  <li>Citation mechanics knowledge</li>
  <li>Analytics and measurement capabilities</li>
  <li>Technical implementation experience (JSON-LD, schema markup)</li>
</ul>';

$misconceptions = '<h2>Common Misconceptions</h2>
<ul>
  <li><strong>"LLM Strategists just do SEO for AI."</strong> No—LLM Strategists optimize for retrieval and citation accuracy, not search rankings. The systems and metrics are different.</li>
  <li><strong>"This is just content optimization."</strong> LLM Strategists work with structured data, entity recognition, and canonical control—technical systems, not just content.</li>
  <li><strong>"AI systems can\'t be influenced."</strong> Structured data, entity alignment, and canonical control directly influence how AI systems retrieve and cite information.</li>
  <li><strong>"This is only for big brands."</strong> Any brand that wants accurate AI citations needs LLM strategy—from startups to enterprises.</li>
</ul>';

$canonicalUrl = 'https://nrlc.ai/en-gb/insights/glossary/llm-strategist/';
?>
<main class="container">
  <h1>What is an LLM Strategist?</h1>
  <?=$hubLink?>
  <?=$definition?>
  <?=$coreResponsibilities?>
  <?=$skills?>
  <?=$misconceptions?>
  <p><a href="/en-gb/careers/norwich/llm-strategist/">Learn more about the LLM Strategist role</a></p>
</main>

<?php
$breadcrumbLd = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  '@id' => $canonicalUrl . '#breadcrumb',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://nrlc.ai/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Insights', 'item' => 'https://nrlc.ai/en-gb/insights/'],
    ['@type' => 'ListItem', 'position' => 3, 'name' => 'What is an LLM Strategist?', 'item' => $canonicalUrl]
  ]
];

$webPageLd = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => 'What is an LLM Strategist?',
  'url' => $canonicalUrl,
  'description' => 'An LLM Strategist designs and runs the systems that influence how large language models retrieve, cite, and summarize information about brands, products, or topics across AI answer engines.',
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => 'https://nrlc.ai/#website',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai'
  ],
  'inLanguage' => 'en-GB',
  'about' => [
    '@type' => 'Thing',
    'name' => 'LLM Strategist'
  ]
];

$GLOBALS['__jsonld'] = [$breadcrumbLd, $webPageLd];
?>

