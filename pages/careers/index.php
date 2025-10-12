<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/csv.php';

// Load careers data
$careers = csv_read_data('careers.csv');
$featured_careers = array_slice($careers, 0, 6); // Get first 6 careers
?>

<section class="container">
    
    <!-- Careers Header Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Careers at NRLC.ai</div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">Join Our Team</h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
          Build the future of AI-first SEO and LLM optimization. Join a team of forward-thinking engineers, researchers, and consultants shaping the next generation of search technology.
        </p>
        <div style="text-align: center; margin-top: 2rem; display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
          <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Apply Now</a>
          <a href="/insights/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore Our Research</a>
        </div>
      </div>
    </div>

    <!-- Open Positions Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Open Positions</div>
      </div>
      <div class="window-body">
        <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
          
          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Senior SEO Engineer</h3>
            <p>Build crawl clarity systems and deterministic content engines. Design and implement scalable SEO infrastructure that optimizes content for both traditional search engines and AI-powered systems. Work with cutting-edge technologies to solve complex technical challenges.</p>
            <a href="/careers/new-york/senior-seo-engineer/" class="btn" data-ripple>View Role</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">LLM Seeding Specialist</h3>
            <p>Design structured data systems for AI model optimization. Develop and implement JSON-LD schemas, entity mapping strategies, and content architecture that maximizes AI engine comprehension and citation likelihood.</p>
            <a href="/careers/london/llm-seeding-specialist/" class="btn" data-ripple>View Role</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Technical SEO Consultant</h3>
            <p>Help clients optimize their crawl budget and schema implementation. Provide expert guidance on technical SEO strategies, performance optimization, and AI-first content architecture for enterprise clients.</p>
            <a href="/careers/san-francisco/technical-seo-consultant/" class="btn" data-ripple>View Role</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">AI Research Scientist</h3>
            <p>Conduct cutting-edge research on AI engine behavior and citation patterns. Develop the GEO-16 framework and advance our understanding of how AI systems process and cite web content.</p>
            <a href="/careers/chicago/ai-research-scientist/" class="btn" data-ripple>View Role</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">Content Strategy Lead</h3>
            <p>Lead content strategy initiatives that optimize for AI comprehension and traditional SEO. Develop content hierarchies, entity relationships, and semantic structures that maximize search engine and AI engine performance.</p>
            <a href="/careers/boston/content-strategy-lead/" class="btn" data-ripple>View Role</a>
          </div>

          <div style="padding: 1rem;">
            <h3 style="margin-top: 0; color: #000080;">DevOps Engineer</h3>
            <p>Build and maintain the infrastructure that powers our AI-first SEO platform. Implement scalable systems for crawl analysis, structured data validation, and performance monitoring across client projects.</p>
            <a href="/careers/seattle/devops-engineer/" class="btn" data-ripple>View Role</a>
          </div>

        </div>
      </div>
    </div>

    <!-- Company Culture Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Our Culture</div>
      </div>
      <div class="window-body">
        <h2 style="color: #000080; margin-top: 0;">Why Join NRLC.ai?</h2>
        <p>We're building the future of search technology, and we need talented individuals who share our vision of an AI-first internet.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Innovation First</h4>
            <p>Work on cutting-edge AI SEO research and implementation. Be part of the team that's defining how search engines will work in the AI era.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Research-Driven</h4>
            <p>Our work is grounded in rigorous research and data analysis. Contribute to the GEO-16 framework and advance the field of AI-first SEO.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Remote-First</h4>
            <p>Work from anywhere in the world. We believe in flexible work arrangements that allow you to do your best work.</p>
          </div>
          
          <div style="padding: 1rem; background: #f8f8f8;">
            <h4 style="margin-top: 0; color: #000080;">Competitive Benefits</h4>
            <p>Comprehensive health coverage, competitive salary, equity options, and professional development opportunities.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action Window -->
    <div class="window">
      <div class="title-bar">
        <div class="title-bar-text">Ready to Apply?</div>
      </div>
      <div class="window-body">
        <div style="text-align: center;">
          <h2 style="color: #000080; margin-top: 0;">Start Your Journey with NRLC.ai</h2>
          <p style="font-size: 1.1rem; margin-bottom: 2rem;">
            Join a team that's shaping the future of search technology and AI-first SEO optimization.
          </p>
          <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
            <a href="/api/book/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Apply Now</a>
            <a href="/services/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Learn About Our Services</a>
          </div>
        </div>
      </div>
    </div>

</section>

<?php
// JSON-LD Schema
$jsonld = [
  [
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "name" => "Careers at NRLC.ai",
    "description" => "Join our team building the future of AI-first SEO and LLM optimization",
    "url" => "https://nrlc.ai/careers/",
    "publisher" => [
      "@type" => "Organization",
      "name" => "NRLC.ai",
      "url" => "https://nrlc.ai"
    ]
  ]
];

$GLOBALS['__jsonld'] = $jsonld;
?>
