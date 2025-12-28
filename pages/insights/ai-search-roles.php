<?php
/**
 * TIER 1: AI Search Roles Ecosystem Page
 * URL: /en-gb/insights/ai-search-roles/
 * Primary Intent: "ai search roles"
 */

$hubLink = '<p>The <a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> is a key role in the AI search ecosystem. Learn more about the <a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> role.</p>';

$llmStrategistCard = '<div class="card" style="padding:1.5rem; margin:1rem 0; border:2px solid #0066cc;">
  <h2 style="margin-top:0;">LLM Strategist</h2>
  <p><strong>Primary Focus:</strong> Designs and runs systems that influence how large language models retrieve, cite, and summarize information about brands, products, or topics across AI answer engines.</p>
  <p><strong>Key Responsibilities:</strong></p>
  <ul>
    <li>Design structured data architectures for entity recognition and citation</li>
    <li>Develop retrieval optimization strategies for ChatGPT, Claude, Perplexity, Google AI Overviews</li>
    <li>Create canonical control systems for authoritative source citation</li>
    <li>Track citation rates, retrieval surface area, and entity alignment metrics</li>
  </ul>
  <p><strong>Skills Required:</strong> Technical SEO foundation, entity recognition systems, data modeling, retrieval optimization, citation mechanics, analytics.</p>
  <p><a href="/en-gb/careers/norwich/llm-strategist/">Learn more about the LLM Strategist role</a></p>
</div>';

$otherRoles = '<h2>Other AI Search Roles</h2>

<div class="card" style="padding:1rem; margin:1rem 0;">
  <h3>SEO Strategist</h3>
  <p>Focuses on search engine rankings and organic traffic. Optimizes for traditional search engines (Google, Bing) using keywords, backlinks, content, and technical SEO.</p>
  <p><strong>Key Difference:</strong> SEO Strategists target search rankings; LLM Strategists target AI retrieval and citation accuracy.</p>
</div>

<div class="card" style="padding:1rem; margin:1rem 0;">
  <h3>Technical SEO Engineer</h3>
  <p>Implements technical SEO infrastructure: crawl optimization, site speed, structured data, hreflang, canonical tags. Works on the technical foundation that enables both SEO and LLM strategy.</p>
  <p><strong>Key Difference:</strong> Technical SEO Engineers build infrastructure; LLM Strategists optimize how AI systems use that infrastructure.</p>
</div>

<div class="card" style="padding:1rem; margin:1rem 0;">
  <h3>Content Strategist (AI-Focused)</h3>
  <p>Creates content optimized for AI comprehension and retrieval. Focuses on structured content, entity clarity, and information architecture that makes content easy for AI systems to process.</p>
  <p><strong>Key Difference:</strong> Content Strategists create content; LLM Strategists design the systems that influence how AI systems retrieve and cite that content.</p>
</div>

<div class="card" style="padding:1rem; margin:1rem 0;">
  <h3>Data Engineer (SEO/AI)</h3>
  <p>Builds data pipelines, structured data systems, and entity recognition infrastructure. Creates the technical systems that enable LLM strategy.</p>
  <p><strong>Key Difference:</strong> Data Engineers build systems; LLM Strategists design strategies for how those systems influence AI retrieval.</p>
</div>';

$canonicalUrl = 'https://nrlc.ai/en-gb/insights/ai-search-roles/';
?>
<main class="container">
  <h1>AI Search Roles</h1>
  <?=$hubLink?>
  <p>The AI search ecosystem includes multiple specialized roles, each optimizing for different systems and outcomes. Understanding these roles helps you build the right team for AI-first visibility.</p>
  <?=$llmStrategistCard?>
  <?=$otherRoles?>
  <p><a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> role overview</p>
</main>

<?php
$breadcrumbLd = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  '@id' => $canonicalUrl . '#breadcrumb',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://nrlc.ai/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Insights', 'item' => 'https://nrlc.ai/en-gb/insights/'],
    ['@type' => 'ListItem', 'position' => 3, 'name' => 'AI Search Roles', 'item' => $canonicalUrl]
  ]
];

$itemListLd = [
  '@context' => 'https://schema.org',
  '@type' => 'ItemList',
  '@id' => $canonicalUrl . '#roles',
  'name' => 'AI Search Roles',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'LLM Strategist', 'item' => 'https://nrlc.ai/en-gb/careers/norwich/llm-strategist/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'SEO Strategist', 'item' => $canonicalUrl . '#seo-strategist'],
    ['@type' => 'ListItem', 'position' => 3, 'name' => 'Technical SEO Engineer', 'item' => $canonicalUrl . '#technical-seo-engineer'],
    ['@type' => 'ListItem', 'position' => 4, 'name' => 'Content Strategist (AI-Focused)', 'item' => $canonicalUrl . '#content-strategist'],
    ['@type' => 'ListItem', 'position' => 5, 'name' => 'Data Engineer (SEO/AI)', 'item' => $canonicalUrl . '#data-engineer']
  ]
];

$webPageLd = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => 'AI Search Roles',
  'url' => $canonicalUrl,
  'description' => 'Overview of AI search roles including LLM Strategist, SEO Strategist, Technical SEO Engineer, Content Strategist, and Data Engineer.',
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => 'https://nrlc.ai/#website',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai'
  ],
  'inLanguage' => 'en-GB'
];

$GLOBALS['__jsonld'] = [$breadcrumbLd, $itemListLd, $webPageLd];
?>

