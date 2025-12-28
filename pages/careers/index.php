<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is loaded automatically by router before head.php is included
require_once __DIR__ . '/../../lib/csv.php';
require_once __DIR__ . '/../../lib/helpers.php';



// Load careers data
$careers = csv_read_data('careers.csv');
$cities = csv_read_data('cities.csv');

// Define job listings with cities
$jobListings = [
  ['role' => 'senior-seo-engineer', 'city' => 'new-york', 'title' => 'Senior SEO Engineer', 'description' => 'Build crawl clarity systems and deterministic content engines. Design and implement scalable SEO infrastructure that optimizes content for both traditional search engines and AI-powered systems.'],
  ['role' => 'llm-seeding-specialist', 'city' => 'london', 'title' => 'LLM Seeding Specialist', 'description' => 'Design structured data systems for AI model optimization. Develop and implement JSON-LD schemas, entity mapping strategies, and content architecture that maximizes AI engine comprehension.'],
  ['role' => 'technical-seo-consultant', 'city' => 'san-francisco', 'title' => 'Technical SEO Consultant', 'description' => 'Help clients optimize their crawl budget and schema implementation. Provide expert guidance on technical SEO strategies, performance optimization, and AI-first content architecture.'],
  ['role' => 'ai-research-scientist', 'city' => 'chicago', 'title' => 'AI Research Scientist', 'description' => 'Conduct cutting-edge research on AI engine behavior and citation patterns. Develop the GEO-16 framework and advance our understanding of how AI systems process and cite web content.'],
  ['role' => 'content-strategy-lead', 'city' => 'boston', 'title' => 'Content Strategy Lead', 'description' => 'Lead content strategy initiatives that optimize for AI comprehension and traditional SEO. Develop content hierarchies, entity relationships, and semantic structures.'],
  ['role' => 'devops-engineer', 'city' => 'seattle', 'title' => 'DevOps Engineer', 'description' => 'Build and maintain the infrastructure that powers our AI-first SEO platform. Implement scalable systems for crawl analysis, structured data validation, and performance monitoring.']
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Careers Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Join Our Team</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Build the future of AI-first SEO and LLM optimization. Join a team of forward-thinking engineers, researchers, and consultants shaping the next generation of search technology.</p>
        <div class="btn-group text-center">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Career Application')">Apply Now</button>
          <a href="/insights/" class="btn">Explore Our Research</a>
        </div>
      </div>
    </div>

    <!-- TIER 4: Prominent LLM Strategist Card -->
    <div class="content-block module" style="background:#f0f7ff; border:2px solid #0066cc; padding:1.5rem; margin:1.5rem 0;">
      <div class="content-block__header">
        <h2 class="content-block__title" style="margin-top:0;">LLM Strategist</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">An LLM Strategist designs and runs the systems that influence how large language models retrieve, cite, and summarize information about brands, products, or topics across AI answer engines.</p>
        <p>This role is central to our AI-first SEO approach, optimizing for citation accuracy, retrieval surface area, and entity alignment in ChatGPT, Claude, Perplexity, and Google AI Overviews.</p>
        <div class="btn-group">
          <a href="/en-gb/careers/norwich/llm-strategist/" class="btn btn--primary">Learn More About LLM Strategist</a>
          <a href="/en-gb/insights/glossary/llm-strategist/" class="btn">What is an LLM Strategist?</a>
        </div>
      </div>
    </div>

    <!-- Open Positions -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Open Positions</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <?php foreach ($jobListings as $job): 
            $cityData = array_filter($cities, fn($c) => ($c['city_name'] ?? '') === $job['city']);
            $cityName = !empty($cityData) ? reset($cityData)['city_name'] : ucwords(str_replace('-', ' ', $job['city']));
          ?>
            <div class="content-block">
              <h3 class="content-block__title"><?= htmlspecialchars($job['title']) ?></h3>
              <p><?= htmlspecialchars($job['description']) ?></p>
              <p class="small muted"><strong>Location:</strong> <?= htmlspecialchars($cityName) ?></p>
              <div class="btn-group">
                <a href="/careers/<?= htmlspecialchars($job['city']) ?>/<?= htmlspecialchars($job['role']) ?>/" class="btn btn--primary">View Role</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Company Culture -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Our Culture</h2>
      </div>
      <div class="content-block__body">
        <p>We're building the future of search technology, and we need talented individuals who share our vision of an AI-first internet.</p>
        <div class="grid grid-auto-fit">
          <div class="content-block">
            <h4>Innovation First</h4>
            <p>Work on cutting-edge AI SEO research and implementation. Be part of the team that's defining how search engines will work in the AI era.</p>
          </div>
          <div class="content-block">
            <h4>Research-Driven</h4>
            <p>Our work is grounded in rigorous research and data analysis. Contribute to the GEO-16 framework and advance the field of AI-first SEO.</p>
          </div>
          <div class="content-block">
            <h4>Remote-First</h4>
            <p>Work from anywhere in the world. We believe in flexible work arrangements that allow you to do your best work.</p>
          </div>
          <div class="content-block">
            <h4>Competitive Benefits</h4>
            <p>Comprehensive health coverage, competitive salary, equity options, and professional development opportunities.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Benefits & Perks -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Benefits & Perks</h2>
      </div>
      <div class="content-block__body">
        <p>We invest in our team's success with competitive compensation, comprehensive benefits, and opportunities for professional growth in the rapidly evolving field of AI-first SEO.</p>
        <div class="grid grid-auto-fit">
          <div class="content-block">
            <h4>Health & Wellness</h4>
            <p>100% company-paid health, dental, and vision insurance. Mental health support, wellness stipends, and flexible PTO policies that prioritize work-life balance.</p>
          </div>
          <div class="content-block">
            <h4>Financial Security</h4>
            <p>Competitive salaries, equity participation, 401(k) matching, and performance bonuses. We believe in rewarding exceptional work and long-term commitment.</p>
          </div>
          <div class="content-block">
            <h4>Professional Development</h4>
            <p>Conference attendance, training budgets, mentorship programs, and opportunities to contribute to open-source projects and industry research.</p>
          </div>
          <div class="content-block">
            <h4>Flexible Work</h4>
            <p>Remote-first culture with flexible hours, home office stipends, and the freedom to work from anywhere in the world. Focus on results, not location.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Application Process -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Application Process</h2>
      </div>
      <div class="content-block__body">
        <p>Our hiring process is designed to be transparent, efficient, and focused on finding the right cultural and technical fit for our team.</p>
        <div class="grid grid-auto-fit">
          <div class="content-block">
            <h4>1. Application</h4>
            <p>Submit your resume and cover letter through our application portal. Tell us why you're excited about AI-first SEO.</p>
          </div>
          <div class="content-block">
            <h4>2. Initial Review</h4>
            <p>Our team reviews applications and conducts initial phone screens to discuss your background and interest in the role.</p>
          </div>
          <div class="content-block">
            <h4>3. Technical Interview</h4>
            <p>Demonstrate your skills through technical challenges and discussions about AI SEO, structured data, and search optimization.</p>
          </div>
          <div class="content-block">
            <h4>4. Team Fit</h4>
            <p>Meet with potential teammates and managers to ensure cultural alignment and mutual fit for long-term success.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <div class="content-block module">
      <div class="content-block__body">
        <p class="lead text-center">Ready to build the future of AI-first SEO?</p>
        <div class="btn-group text-center">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Career Application')">Apply Now</button>
          <a href="/services/" class="btn">Learn About Our Services</a>
        </div>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="/tools/">SEO Tools & Resources</a> and view our <a href="/products/">Products</a>.</p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// WebPage Schema
$webPageLd = [
  '@context' => 'https://schema.org',
  '@type' => 'WebPage',
  '@id' => 'https://nrlc.ai/careers/#webpage',
  'name' => 'Careers at NRLC.ai',
  'url' => 'https://nrlc.ai/careers/',
  'description' => 'Join our team building the future of AI-first SEO and LLM optimization. Remote-friendly positions with competitive salary and benefits.',
  'isPartOf' => [
    '@type' => 'WebSite',
    '@id' => 'https://nrlc.ai/#website',
    'name' => 'NRLC.ai',
    'url' => 'https://nrlc.ai'
  ],
  'inLanguage' => 'en'
];

// BreadcrumbList Schema
$breadcrumbLd = [
  '@context' => 'https://schema.org',
  '@type' => 'BreadcrumbList',
  '@id' => 'https://nrlc.ai/careers/#breadcrumb',
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
      'name' => 'Careers',
      'item' => 'https://nrlc.ai/careers/'
    ]
  ]
];

// JobPosting Collection Schema - List all jobs
$jobPostings = [];
foreach ($jobListings as $job) {
  $cityData = array_filter($cities, fn($c) => ($c['city_name'] ?? '') === $job['city']);
  $cityName = !empty($cityData) ? reset($cityData)['city_name'] : ucwords(str_replace('-', ' ', $job['city']));
  $jobUrl = 'https://nrlc.ai/careers/' . $job['city'] . '/' . $job['role'] . '/';
  
  $jobPostings[] = [
    '@type' => 'JobPosting',
    '@id' => $jobUrl . '#jobposting',
    'title' => $job['title'],
    'description' => $job['description'],
    'datePosted' => date('Y-m-d'),
    'validThrough' => gmdate('Y-m-d', strtotime('+45 days')),
    'employmentType' => 'FULL_TIME',
    'hiringOrganization' => [
      '@type' => 'Organization',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'jobLocation' => [
      '@type' => 'Place',
      'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Remote',
        'addressLocality' => $cityName,
        'addressCountry' => 'US'
      ]
    ],
    'url' => $jobUrl
  ];
}

$GLOBALS['__jsonld'] = [$webPageLd, $breadcrumbLd, ...$jobPostings];
?>
