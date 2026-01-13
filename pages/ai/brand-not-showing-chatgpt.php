<?php
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/case_study_registry.php';
require_once __DIR__ . '/../../lib/case_study_schema.php';

// Get case studies for this prompt cluster
$registry = get_case_study_registry();
$relevantCases = array_filter($registry, function($case) {
  return $case['prompt_cluster'] === 'invisible-brand';
});

$promptClusterMeta = get_prompt_cluster_metadata('invisible-brand');

// Set page metadata
require_once __DIR__ . '/../../lib/meta_directive.php';
$ctx = [
  'type' => 'insight',
  'slug' => 'ai/brand-not-showing-chatgpt',
  'title' => 'Brand Not Showing in ChatGPT Answers: Why AI Omits Legitimate Brands',
  'excerpt' => 'When AI systems like ChatGPT omit your brand despite authority, the problem is usually missing entity signals, incomplete structured data, or weak citation signals. Here\'s how to fix it.',
  'canonicalPath' => '/ai/brand-not-showing-chatgpt/'
];
$GLOBALS['__page_meta'] = sudo_meta_directive_ctx($ctx);
?>
<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Brand Not Showing in ChatGPT Answers: Why AI Omits Legitimate Brands</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">When AI systems like ChatGPT omit your brand despite authority, the problem is usually missing entity signals, incomplete structured data, or weak citation signals. Here's how to fix it.</p>
        
        <p>This is the "Invisible Brand" problem: your company has market authority, comprehensive content, and strong domain signals, but AI systems consistently fail to cite or recommend you when users ask relevant questions.</p>
      </div>
    </div>
    
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why AI Systems Omit Brands</h2>
      </div>
      <div class="content-block__body">
        <p>AI systems like ChatGPT, Claude, and Perplexity rely on structured signals to understand and cite brands. When these signals are missing or incomplete, even authoritative brands become invisible.</p>
        
        <ul>
          <li><strong>Missing Entity Disambiguation:</strong> AI systems can't map your brand to industry taxonomies or knowledge graphs</li>
          <li><strong>Incomplete Structured Data:</strong> Product or service schema exists but lacks relationships and expertise declarations</li>
          <li><strong>Weak Citation Signals:</strong> Content isn't organized into atomic, factual units that AI systems extract for citations</li>
        </ul>
      </div>
    </div>
    
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Real Case Studies</h2>
      </div>
      <div class="content-block__body">
        <p>These case studies demonstrate how brands fixed the "invisible brand" problem:</p>
        
        <div class="grid" style="gap: 1rem;">
          <?php foreach ($relevantCases as $case): ?>
          <div class="card">
            <h3><a href="/case-studies/<?= htmlspecialchars($case['slug']) ?>/"><?= htmlspecialchars($case['title']) ?></a></h3>
            <p><?= htmlspecialchars($case['description']) ?></p>
            <p><a href="/case-studies/<?= htmlspecialchars($case['slug']) ?>/" class="btn">View Case Study</a></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How to Fix It</h2>
      </div>
      <div class="content-block__body">
        <p>The solution requires three components:</p>
        
        <ol>
          <li><strong>Entity Mapping:</strong> Create clear entity relationships using JSON-LD schema that map your brand to industry taxonomies</li>
          <li><strong>Structured Data:</strong> Implement comprehensive schema (Service, Product, Organization) with expertise declarations and relationships</li>
          <li><strong>Atomic Content:</strong> Organize content into factual, citable units that AI systems can extract and attribute</li>
        </ol>
        
        <p><a href="/services/enterprise-schema-markup/" class="btn btn--primary">Get Enterprise Schema Implementation</a></p>
      </div>
    </div>
    
    <div class="content-block module">
      <div class="content-block__body">
        <p>This is a failure state within <a href="<?= absolute_url('/ai-optimization/') ?>">AI Optimization</a>, where systems fail to retrieve or select a source during AI-driven search and answer generation.</p>
      </div>
    </div>
    
  </div>
</section>
</main>

<?php
// Generate schema for this landing page
$canonicalUrl = absolute_url('/ai/brand-not-showing-chatgpt/');
$schemaGraph = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Brand Not Showing in ChatGPT Answers',
    'url' => $canonicalUrl,
    'description' => $GLOBALS['__page_meta']['description'],
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => 'https://nrlc.ai/#website',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'inLanguage' => 'en',
    'about' => [
      '@type' => 'DefinedTerm',
      '@id' => 'https://nrlc.ai/#prompt-invisible-brand',
      'name' => 'Invisible Brand in AI Answers',
      'description' => 'AI omits a legitimate brand despite authority.'
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => 'https://nrlc.ai/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'AI Prompt Clusters',
        'item' => 'https://nrlc.ai/ai/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Brand Not Showing in ChatGPT',
        'item' => $canonicalUrl
      ]
    ]
  ]
];

// Add references to case studies
foreach ($relevantCases as $case) {
  $caseUrl = absolute_url("/case-studies/{$case['slug']}/");
  $schemaGraph[] = [
    '@context' => 'https://schema.org',
    '@type' => 'CaseStudy',
    '@id' => $caseUrl . '#case-study',
    'name' => $case['title'],
    'url' => $caseUrl,
    'about' => [
      '@type' => 'DefinedTerm',
      '@id' => 'https://nrlc.ai/#prompt-invisible-brand'
    ]
  ];
}

$GLOBALS['__jsonld'] = $schemaGraph;
?>

