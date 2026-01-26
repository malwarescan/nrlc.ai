<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for product page metadata configuration
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/applicants-io';
$GLOBALS['pageTitle'] = 'Applicants.io | NRLC.ai';
$GLOBALS['pageDesc'] = 'AI recruiting platform with JobPosting schema automation, Google Jobs indexing, resume PDF crawling, skill extraction, and AI-driven applicant ranking. ...';

// Build comprehensive schemas
$productSlug = 'applicants-io';
$productName = 'Applicants.io';
$productDescription = 'AI recruiting platform with JobPosting schema automation, Google Jobs indexing, resume PDF crawling, skill extraction, and AI-driven applicant ranking.';
$features = [
  'JobPosting schema automation',
  'Google Jobs indexing',
  'Resume PDF crawling',
  'Skill extraction',
  'Applicant ranking',
  'Employer dashboards',
  'AI-driven shortlisting',
  'Multi-platform job distribution'
];

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
  product_platform_schemas($productSlug, $productName, $productDescription, $features, 'BusinessApplication'),
  applicants_io_schemas(),
  product_qapage_schema($productSlug, $productName, $productDescription),
  [product_howto_schema($productSlug, $productName)]
);

$GLOBALS['__jsonld'] = $jsonld;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Product Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Applicants.io: The AI-First Job Search Platform</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Capture elite talent where they search today. Applicants.io is the next-generation job search platform engineered for maximum visibility on Google Jobs, AI assistants, and high-intent candidate searches.</p>
        
        <div style="background: #fdfdfd; border-left: 4px solid #4a90e2; padding: 1.5rem; margin: 2rem 0;">
            <h3>What is Applicants.io?</h3>
            <p>Applicants.io is an AI-native recruiting platform that transforms standard job listings into high-authority "Answer-First" entities. While traditional job boards hope for clicks, Applicants.io ensures your roles are indexed, verified, and cited by the AI systems top candidates use to find their next move.</p>
            
            <h4>Who it's for</h4>
            <ul style="columns: 2;">
                <li>Growth-stage Tech Companies</li>
                <li>Enterprise Recruiting Teams</li>
                <li>Specialized Agency Recruiters</li>
                <li>AI & Machine Learning Teams</li>
            </ul>
        </div>
      </div>
    </div>

    <!-- Comparison Table -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How Applicants.io Compares</h2>
      </div>
      <div class="content-block__body">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
                <thead>
                    <tr style="background: #f8f9fa; text-align: left;">
                        <th style="padding: 1rem; border: 1px solid #ddd;">Feature</th>
                        <th style="padding: 1rem; border: 1px solid #ddd;">Traditional Job Boards</th>
                        <th style="padding: 1rem; border: 1px solid #ddd; background: #f0f7ff;">Applicants.io</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 1rem; border: 1px solid #ddd;"><strong>Indexing Speed</strong></td>
                        <td style="padding: 1rem; border: 1px solid #ddd;">24-48 hours</td>
                        <td style="padding: 1rem; border: 1px solid #ddd; background: #fdfdff;"><strong>< 2 hours (via API)</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; border: 1px solid #ddd;"><strong>AI Engine Visibility</strong></td>
                        <td style="padding: 1rem; border: 1px solid #ddd;">Accidental</td>
                        <td style="padding: 1rem; border: 1px solid #ddd; background: #fdfdff;"><strong>Native (Entity-First)</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; border: 1px solid #ddd;"><strong>Schema Compliance</strong></td>
                        <td style="padding: 1rem; border: 1px solid #ddd;">Basic / Incomplete</td>
                        <td style="padding: 1rem; border: 1px solid #ddd; background: #fdfdff;"><strong>100% (JobPosting Rich)</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem; border: 1px solid #ddd;"><strong>Candidate Intelligence</strong></td>
                        <td style="padding: 1rem; border: 1px solid #ddd;">Resume Matching</td>
                        <td style="padding: 1rem; border: 1px solid #ddd; background: #fdfdff;"><strong>AI-Driven Shortlisting</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>

    <!-- Core Capabilities -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Core Capabilities</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>JobPosting Schema Automation</h3>
            <p>Automatic generation and optimization of JobPosting structured data for maximum Google Jobs visibility and AI engine comprehension.</p>
          </div>
          <div>
            <h3>Google Jobs Indexing</h3>
            <p>Ensures job listings appear in Google Jobs search results with proper schema markup and optimization.</p>
          </div>
          <div>
            <h3>Resume PDF Crawling</h3>
            <p>Automated extraction and parsing of resume data from PDF files, enabling intelligent candidate matching.</p>
          </div>
          <div>
            <h3>Skill Extraction</h3>
            <p>AI-powered identification and categorization of candidate skills from resumes and applications.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Product FAQs -->
    <div class="content-block module" itemscope itemtype="https://schema.org/FAQPage">
      <div class="content-block__header">
        <h2 class="content-block__title">Frequently Asked Questions</h2>
      </div>
      <div class="content-block__body">
        <details style="margin-bottom: 1rem; border: 1px solid #eee; padding: 1rem;">
            <summary style="font-weight: bold; cursor: pointer;">Is Applicants.io a job board?</summary>
            <p style="margin-top: 0.5rem;">It is a <strong>Job Search Platform</strong>. While job boards just list jobs, Applicants.io optimizes your jobs as entities so they rank across Google Jobs and are recommended by AI assistants like ChatGPT.</p>
        </details>
        <details style="margin-bottom: 1rem; border: 1px solid #eee; padding: 1rem;">
            <summary style="font-weight: bold; cursor: pointer;">How does it improve candidate quality?</summary>
            <p style="margin-top: 0.5rem;">By winning the high-intent AI and Google Jobs slots, you capture candidates who are searching for specific roles rather than just browsing boards. Our AI shortlisting then sorts these high-intent applicants for you.</p>
        </details>
        <details style="margin-bottom: 1rem; border: 1px solid #eee; padding: 1rem;">
            <summary style="font-weight: bold; cursor: pointer;">Does it integrate with my existing ATS?</summary>
            <p style="margin-top: 0.5rem;">Yes. Applicants.io acts as an "Authority Layer" that sits between your ATS and the search engines, pushing optimized data while candidates flow back into your system.</p>
        </details>
      </div>
    </div>

    <div class="content-block module">
      <div class="content-block__body">
        <div class="btn-group text-center">
          <a href="/products/" class="btn">View All Products</a>
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Applicants.io Platform Demo')">Request a Demo</button>
        </div>
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
        <p>Browse our <a href="/tools/">SEO Tools & Resources</a> and view all <a href="/products/">Products</a>.</p>
        <div class="btn-group text-center">
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
        </div>
      </div>
  </div>
</section>
</main>


