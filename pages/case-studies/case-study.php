<?php
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/deterministic.php';


// Metadata is now set in router via ctx-based system
// Remove old placeholder metadata to prevent conflicts

$caseNumber = $_GET['case'] ?? '1';

// Generate deterministic content based on case number
det_seed("case|$caseNumber");

$company = det_pick([
  "TechCorp Solutions", "DataFlow Inc", "CloudFirst Systems", "AI Innovations Ltd",
  "Digital Dynamics", "SmartTech Enterprises", "NextGen Platforms", "InnovateLab Corp"
], 1)[0];

$industry = det_pick([
  "SaaS", "E-commerce", "Healthcare", "Fintech", "Education", "Manufacturing"
], 1)[0];

$challenge = det_pick([
  "Low AI engine citation rates affecting content visibility and user engagement.",
  "Inconsistent structured data implementation leading to poor semantic understanding.",
  "Complex multi-language content requiring robust hreflang and canonical management."
], 1)[0];

$solution = det_pick([
  "Comprehensive GEO-16 framework implementation with industry-specific schema markup.",
  "Advanced entity disambiguation and semantic markup optimization across all content.",
  "Automated content validation and monitoring system for sustained AI SEO performance."
], 1)[0];

$results = det_pick([
  "300% increase in AI engine citations within 90 days of implementation.",
  "85% improvement in content visibility across multiple AI platforms.",
  "50% reduction in crawl budget waste through optimized canonical and hreflang management."
], 1)[0];

$faqs = det_pick([
  ["What was the biggest challenge?", "<?= htmlspecialchars($challenge) ?>"],
  ["How did you solve it?", "<?= htmlspecialchars($solution) ?>"],
  ["What were the results?", "<?= htmlspecialchars($results) ?>"]
], 3);
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Case Study Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Case Study #<?= htmlspecialchars($caseNumber) ?>: <?= htmlspecialchars($company) ?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead">How <?= htmlspecialchars($company) ?>, a leading <?= htmlspecialchars($industry) ?> company, achieved significant improvements in AI engine visibility through strategic SEO optimization.</p>
      </div>
    </div>
    
    <!-- The Challenge -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Challenge</h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($challenge) ?></p>
      </div>
    </div>
    
    <!-- Our Solution -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Our Solution</h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($solution) ?></p>
      </div>
    </div>
    
    <!-- Results -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Results</h2>
      </div>
      <div class="content-block__body">
        <p><?= htmlspecialchars($results) ?></p>
      </div>
    </div>
    
    <!-- Key Takeaways -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Key Takeaways</h2>
      </div>
      <div class="content-block__body">
        <p>This case study demonstrates several important principles for successful AI SEO implementation in the <?= htmlspecialchars($industry) ?> sector.</p>
        
        <ul>
          <li>Strategic implementation of structured data is crucial for AI engine optimization</li>
          <li>Industry-specific schema markup significantly improves content comprehension</li>
          <li>Ongoing monitoring and optimization ensure sustained performance improvements</li>
          <li>Customized approaches tailored to specific industry requirements yield better results</li>
          <li>Comprehensive content strategy is essential for long-term success</li>
        </ul>
      </div>
    </div>
    
    <!-- Implementation Timeline -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Implementation Timeline</h2>
      </div>
      <div class="content-block__body">
        <p>The implementation process for <?= htmlspecialchars($company) ?> followed a structured timeline that ensured thorough execution and measurable results.</p>
        
        <ol>
          <li><strong>Week 1-2:</strong> Initial assessment and strategy development</li>
          <li><strong>Week 3-4:</strong> Content audit and optimization planning</li>
          <li><strong>Week 5-8:</strong> Technical implementation and content updates</li>
          <li><strong>Week 9-12:</strong> Testing, validation, and initial performance monitoring</li>
          <li><strong>Week 13-16:</strong> Optimization and refinement based on early results</li>
          <li><strong>Ongoing:</strong> Continuous monitoring and performance improvement</li>
        </ol>
      </div>
    </div>
    
    <!-- Technical Details -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Technical Details</h2>
      </div>
      <div class="content-block__body">
        <p>The technical implementation involved several key components that contributed to the success of this project:</p>
        
        <ul>
          <li><strong>Schema Markup:</strong> Implementation of comprehensive structured data across all relevant pages</li>
          <li><strong>Content Optimization:</strong> Enhancement of existing content to meet AI engine requirements</li>
          <li><strong>Technical SEO:</strong> Improvements to site structure and performance</li>
          <li><strong>Monitoring Systems:</strong> Implementation of advanced tracking and analytics</li>
          <li><strong>Quality Assurance:</strong> Comprehensive testing and validation processes</li>
        </ul>
      </div>
    </div>
    
    <!-- Lessons Learned -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Lessons Learned</h2>
      </div>
      <div class="content-block__body">
        <p>This case study provides valuable insights for other organizations considering similar AI SEO initiatives:</p>
        
        <ul>
          <li><strong>Industry Expertise:</strong> Deep understanding of sector-specific requirements is essential</li>
          <li><strong>Patience and Persistence:</strong> Results take time to materialize and require ongoing effort</li>
          <li><strong>Comprehensive Approach:</strong> Success requires attention to both technical and content aspects</li>
          <li><strong>Continuous Improvement:</strong> Regular monitoring and optimization are crucial for sustained success</li>
          <li><strong>Team Collaboration:</strong> Effective communication between all stakeholders is vital</li>
        </ul>
      </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Frequently Asked Questions</h2>
      </div>
      <div class="content-block__body">
        <div class="grid" style="gap:4px">
          <?php foreach ($faqs as $faq): ?>
          <details class="card">
            <summary><strong><?= htmlspecialchars($faq[0]) ?></strong></summary>
            <p class="small muted"><?= htmlspecialchars($faq[1]) ?></p>
          </details>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    
    <!-- Call to Action -->
    <div class="content-block module">
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="/services/" title="AI SEO Services">AI SEO Services</a> including <a href="/services/crawl-clarity/" title="Crawl Clarity Engineering">Crawl Clarity Engineering</a> for technical SEO optimization. Discover our latest <a href="/insights/" title="AI SEO Research & Insights">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/" title="GEO-16 Framework">GEO-16 Framework</a> for AI citation optimization. Browse our <a href="/tools/" title="SEO Tools & Resources">SEO Tools & Resources</a> and view more <a href="/case-studies/" title="Case Studies">Case Studies</a>.</p>
        
        <div class="btn-group text-center" style="margin-top: 1.5rem;">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Case Study Consultation')">Schedule Consultation</button>
          <a href="/services/" class="btn" title="Get Started with AI SEO">Get Started with AI SEO</a>
        </div>
      </div>
    </div>
    
  </div>
</section>
</main>

<?php
// Generate comprehensive schema
$canonicalUrl = 'https://nrlc.ai/case-studies/case-study-' . $caseNumber . '/';
$date = date('Y-m-d');

$schemaGraph = [
  // WebPage Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Case Study #' . htmlspecialchars($caseNumber) . ': ' . htmlspecialchars($company),
    'url' => $canonicalUrl,
    'description' => 'How ' . htmlspecialchars($company) . ', a leading ' . htmlspecialchars($industry) . ' company, achieved significant improvements in AI engine visibility through strategic SEO optimization.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => 'https://nrlc.ai/#website',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'inLanguage' => 'en'
  ],
  
  // BreadcrumbList Schema
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
        'name' => 'Case Studies',
        'item' => 'https://nrlc.ai/case-studies/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Case Study #' . htmlspecialchars($caseNumber) . ': ' . htmlspecialchars($company),
        'item' => $canonicalUrl
      ]
    ]
  ],
  
  // Article Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    '@id' => $canonicalUrl . '#article',
    'headline' => 'Case Study #' . htmlspecialchars($caseNumber) . ': ' . htmlspecialchars($company) . ' AI SEO Success',
    'description' => 'Detailed case study showing how ' . htmlspecialchars($company) . ' achieved significant AI SEO improvements',
    'author' => [
      '@type' => 'Person',
      'name' => 'Joel Maldonado'
    ],
    'publisher' => [
      '@type' => 'Organization',
      'name' => 'Neural Command',
      'logo' => [
        '@type' => 'ImageObject',
        'url' => 'https://nrlc.ai/assets/images/nrlcai%20logo%200.png'
      ]
    ],
    'datePublished' => $date,
    'dateModified' => $date,
    'mainEntityOfPage' => [
      '@id' => $canonicalUrl . '#webpage'
    ],
    'articleSection' => 'Case Studies',
    'keywords' => ['Case Study', 'AI SEO', htmlspecialchars($industry), 'Success Story'],
    'inLanguage' => 'en'
  ],
  
  // FAQPage Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => array_map(function($faq, $i) {
      return [
        '@type' => 'Question',
        'name' => htmlspecialchars($faq[0]),
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => htmlspecialchars($faq[1])
        ]
      ];
    }, $faqs, array_keys($faqs))
  ]
];

$GLOBALS['__jsonld'] = $schemaGraph;
?>
