<?php
/**
 * TIER 4: Author/Entity Page
 * URL: /en-gb/about/llm-strategy-team/
 * Purpose: Anchor E-E-A-T for the LLM Strategist role
 */

$hubLink = '<p>Our LLM Strategy team defines and implements the <a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> methodology. Learn more about the <a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> role.</p>';

$teamIntro = '<h2>LLM Strategy Team</h2>
<p>The LLM Strategy team at NRLC.ai defines the methodology, frameworks, and best practices for LLM Strategist roles. Our team combines technical SEO expertise, AI system knowledge, and strategic thinking to advance how brands optimize for AI answer engines.</p>';

$teamMembers = '<h2>Team Members</h2>

<div class="card" style="padding:1.5rem; margin:1rem 0;">
  <h3>Joel Maldonado</h3>
  <p><strong>Role:</strong> Founder & LLM Strategy Lead</p>
  <p><strong>Background:</strong> 10+ years in technical SEO, structured data, and AI optimization. Developed the LLM Search Strategy Framework and GEO-16 methodology for AI citation optimization.</p>
  <p><strong>Credentials:</strong> Published research on AI engine behavior, citation patterns, and retrieval optimization. Contributor to schema.org and structured data best practices.</p>
  <p><strong>Contact:</strong> <a href="mailto:contact@neuralcommandllc.com">contact@neuralcommandllc.com</a></p>
</div>

<div class="card" style="padding:1.5rem; margin:1rem 0;">
  <h3>Technical SEO Team</h3>
  <p><strong>Focus:</strong> Structured data implementation, entity recognition systems, canonical control, and citation tracking infrastructure.</p>
  <p><strong>Expertise:</strong> JSON-LD schema design, entity alignment, retrieval optimization, and AI system testing methodologies.</p>
</div>

<div class="card" style="padding:1.5rem; margin:1rem 0;">
  <h3>Research & Development</h3>
  <p><strong>Focus:</strong> AI engine behavior research, citation pattern analysis, and framework development.</p>
  <p><strong>Expertise:</strong> GEO-16 framework, retrieval mechanics, entity recognition systems, and citation accuracy measurement.</p>
</div>';

$methodology = '<h2>Methodology & Frameworks</h2>
<p>Our team has developed the LLM Search Strategy Framework, a 7-step methodology for optimizing brand visibility in AI answer engines. This framework is used by LLM Strategists worldwide to systematically improve citation rates, retrieval surface area, and entity alignment.</p>
<p><a href="/en-gb/insights/llm-search-strategy-framework/">Learn more about the LLM Search Strategy Framework</a></p>';

$qualifications = '<h2>Why We're Qualified</h2>
<ul>
  <li><strong>Technical Expertise:</strong> Deep understanding of structured data, entity recognition systems, and AI retrieval mechanics</li>
  <li><strong>Research Background:</strong> Published research on AI engine behavior, citation patterns, and retrieval optimization</li>
  <li><strong>Practical Experience:</strong> Implemented LLM strategy for hundreds of brands across multiple industries</li>
  <li><strong>Framework Development:</strong> Created the LLM Search Strategy Framework and GEO-16 methodology</li>
  <li><strong>Industry Leadership:</strong> Contributor to schema.org, structured data best practices, and AI SEO standards</li>
</ul>';

$canonicalUrl = 'https://nrlc.ai/en-gb/about/llm-strategy-team/';
?>
<main class="container">
  <h1>LLM Strategy Team</h1>
  <?=$hubLink?>
  <?=$teamIntro?>
  <?=$teamMembers?>
  <?=$methodology?>
  <?=$qualifications?>
  <p><a href="/en-gb/careers/norwich/llm-strategist/">LLM Strategist</a> role overview | <a href="/en-gb/insights/llm-search-strategy-framework/">LLM Search Strategy Framework</a></p>
</main>

<?php
$breadcrumbLd = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  '@id' => $canonicalUrl . '#breadcrumb',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://nrlc.ai/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'About', 'item' => 'https://nrlc.ai/en-gb/about/'],
    ['@type' => 'ListItem', 'position' => 3, 'name' => 'LLM Strategy Team', 'item' => $canonicalUrl]
  ]
];

$organizationLd = [
  '@context' => 'https://schema.org',
  '@type' => 'Organization',
  '@id' => $canonicalUrl . '#organization',
  'name' => 'NRLC.ai LLM Strategy Team',
  'url' => 'https://nrlc.ai',
  'description' => 'Team that defines and implements LLM Strategist methodology, frameworks, and best practices for AI answer engine optimization.',
  'member' => [
    [
      '@type' => 'Person',
      'name' => 'Joel Maldonado',
      'jobTitle' => 'Founder & LLM Strategy Lead',
      'email' => 'contact@neuralcommandllc.com'
    ]
  ]
];

$webPageLd = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => $canonicalUrl . '#webpage',
  'name' => 'LLM Strategy Team',
  'url' => $canonicalUrl,
  'description' => 'The LLM Strategy team at NRLC.ai defines the methodology, frameworks, and best practices for LLM Strategist roles.',
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => 'https://nrlc.ai/#website',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai'
  ],
  'inLanguage' => 'en-GB',
  'about' => [
    '@id' => $canonicalUrl . '#organization'
  ]
];

$GLOBALS['__jsonld'] = [$breadcrumbLd, $organizationLd, $webPageLd];
?>

