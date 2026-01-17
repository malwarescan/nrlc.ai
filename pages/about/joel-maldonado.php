<?php
/**
 * Joel Maldonado Entity Home Page
 * 
 * CANONICAL ENTITY HOME: https://nrlc.ai/en-us/about/joel-maldonado/
 * PERSON_ID: https://nrlc.ai/en-us/about/joel-maldonado/#person
 * 
 * This is the ONE canonical entity home for Joel Maldonado.
 * All authored content across NRLC ecosystem references this Person @id.
 */

require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/person_entity.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/gbp_config.php';

// Canonical URLs (locked - never change)
$entityHomeUrl = JOEL_ENTITY_HOME_URL;
$personId = JOEL_PERSON_ID;
$profilePageId = JOEL_PROFILEPAGE_ID;
$orgId = NRLC_ORG_ID;

// Set page metadata
$GLOBALS['__page_slug'] = 'about/joel-maldonado';
$GLOBALS['__page_meta'] = [
  'title' => 'Joel Maldonado | AI Search Optimization Researcher | NRLC.ai',
  'description' => 'Joel David Maldonado is an AI Search Optimization Researcher specializing in structured data, knowledge graphs, entity resolution, and answer engine optimization. Founder of Neural Command LLC.',
  'canonicalPath' => '/en-us/about/joel-maldonado/'
];

// Build JSON-LD Schema Graph (FULL PAYLOAD - only on entity home)
$GLOBALS['__jsonld'] = [
  // Organization (reference - uses GBP config for consistency)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => gbp_business_name(),
    'url' => gbp_website()
  ],
  
  // Person (FULL PAYLOAD - canonical entity)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $personId,
    'name' => 'Joel David Maldonado',
    'alternateName' => ['Joel Maldonado'],
    'url' => $entityHomeUrl,
    'jobTitle' => 'AI Search Optimization Researcher',
    'worksFor' => [
      '@id' => $orgId
    ],
    'sameAs' => [
      'https://www.linkedin.com/in/agentic-search/',
      'https://medium.com/@schemata',
      'https://github.com/malwarescan'
    ],
    'knowsAbout' => [
      'Artificial intelligence',
      'Search engine optimization',
      'Structured data',
      'Knowledge graphs',
      'Entity resolution',
      'Answer engine optimization',
      'Generative engine optimization'
    ],
    'image' => [
      '@type' => 'ImageObject',
      'url' => 'https://nrlc.ai/assets/images/joel-maldonado.png'
    ]
  ],
  
  // ProfilePage
  [
    '@context' => 'https://schema.org',
    '@type' => 'ProfilePage',
    '@id' => $profilePageId,
    'url' => $entityHomeUrl,
    'mainEntity' => [
      '@id' => $personId
    ]
  ],
  
  // BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $entityHomeUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'About',
        'item' => absolute_url('/about/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Joel Maldonado',
        'item' => $entityHomeUrl
      ]
    ]
  ],
  
  // WebPage
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $entityHomeUrl . '#webpage',
    'name' => 'Joel Maldonado',
    'url' => $entityHomeUrl,
    'description' => 'Joel David Maldonado is an AI Search Optimization Researcher specializing in structured data, knowledge graphs, entity resolution, and answer engine optimization.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => absolute_url('/') . '/#website',
      'name' => 'NRLC.ai',
      'url' => absolute_url('/')
    ],
    'inLanguage' => 'en-US'
  ]
];
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      
      <!-- Hero Block -->
      <div class="content-block module" style="background: var(--color-background-alt, #f5f5f5); padding: var(--spacing-xl); border-left: 4px solid var(--color-brand, #12355e); margin-bottom: var(--spacing-xl);">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Joel Maldonado</h1>
        </div>
        <div class="content-block__body">
          <?php if (file_exists(__DIR__ . '/../../public/assets/images/joel-maldonado.png')): ?>
            <div style="float: right; margin: 0 0 1.5rem 1.5rem; max-width: 200px;">
              <img src="<?= absolute_url('/assets/images/joel-maldonado.png') ?>" 
                   alt="Joel Maldonado" 
                   style="width: 100%; height: auto; border-radius: 4px;">
            </div>
          <?php endif; ?>
          
          <p class="lead text-lg" style="font-size: 1.1rem; margin-bottom: var(--spacing-lg);">
            Joel David Maldonado is an AI Search Optimization Researcher specializing in structured data, knowledge graphs, entity resolution, and answer engine optimization. He is the founder of Neural Command LLC, where he leads research and development of methodologies for improving brand visibility in AI-powered search engines.
          </p>
          
          <p>With over 10 years of experience in technical SEO and structured data implementation, Joel has developed frameworks including the LLM Search Strategy Framework and GEO-16 methodology for AI citation optimization. His research focuses on how AI systems extract, cite, and surface authoritative content in generative search results.</p>
          
          <h2>Profile Links</h2>
          <ul>
            <li><a href="https://www.linkedin.com/in/agentic-search/" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
            <li><a href="https://medium.com/@schemata" target="_blank" rel="noopener noreferrer">Medium</a></li>
            <li><a href="https://github.com/malwarescan" target="_blank" rel="noopener noreferrer">GitHub</a></li>
          </ul>
          
          <h2>Areas of Expertise</h2>
          <ul>
            <li>Artificial intelligence</li>
            <li>Search engine optimization</li>
            <li>Structured data</li>
            <li>Knowledge graphs</li>
            <li>Entity resolution</li>
            <li>Answer engine optimization</li>
            <li>Generative engine optimization</li>
          </ul>
          
        </div>
      </div>
      
    </div>
  </section>
</main>
