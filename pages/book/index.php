<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

$GLOBALS['__page_slug'] = 'book/index';
$GLOBALS['__jsonld'] = [
  ld_organization(),
  ld_website_with_searchaction(),
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'AI SEO Consultation Booking',
    'description' => 'Schedule a consultation with NRLC.ai experts for AI-first SEO strategy, GEO-16 framework implementation, and LLM optimization.',
    'provider' => [
      '@type' => 'Organization',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'serviceType' => 'AI SEO Consultation',
    'areaServed' => 'Worldwide',
    'offers' => [
      '@type' => 'Offer',
      'name' => 'Free Initial Consultation',
      'price' => '0',
      'priceCurrency' => 'USD',
      'availability' => 'https://schema.org/InStock'
    ]
  ]
];
?>

<main role="main">
<section class="container">
        
        <!-- Hero / Mission Window -->
        <div class="window" style="margin-bottom: 2rem;">
          <div class="title-bar">
            <div class="title-bar-text">Book AI SEO Consultation</div>
          </div>
          <div class="window-body">
            <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">Schedule Your AI SEO Consultation</h1>
            <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">Get expert guidance on implementing the GEO-16 framework, optimizing for AI engines, and improving your LLM citation rates.</p>
            
            <form id="booking-form" method="POST" action="/api/book/" style="margin-top: 2rem;">
              <div class="grid-2">
                <div>
                  <label for="name">Full Name *</label>
                  <input type="text" id="name" name="name" required>
                </div>
                <div>
                  <label for="email">Email Address *</label>
                  <input type="email" id="email" name="email" required>
                </div>
              </div>
              
              <div class="grid-2">
                <div>
                  <label for="company">Company/Organization</label>
                  <input type="text" id="company" name="company">
                </div>
                <div>
                  <label for="service-interest">Service Interest *</label>
                  <select id="service-interest" name="service_interest" required>
                    <option value="">Select a service...</option>
                    <option value="site-audits">AI-First Site Audits</option>
                    <option value="crawl-clarity">Crawl Clarity Engineering</option>
                    <option value="json-ld-strategy">JSON-LD & Structured Data</option>
                    <option value="llm-seeding">LLM Seeding Optimization</option>
                    <option value="general-consultation">General AI SEO Consultation</option>
                  </select>
                </div>
              </div>
              
              <div>
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="3" placeholder="Tell us about your goals and challenges..."></textarea>
              </div>
              
              <div style="text-align: center; margin-top: 2rem;">
                <button type="submit" class="btn" data-ripple style="width: 100%; max-width: 300px;">Request Free Consultation</button>
              </div>
            </form>
    </div>
  </div>

  <!-- Why Choose NRLC.ai Window -->
  <div class="window" style="margin-bottom: 2rem;">
    <div class="title-bar">
      <div class="title-bar-text">Why Choose NRLC.ai?</div>
    </div>
    <div class="window-body">
      <p>Our team combines deep expertise in traditional SEO with cutting-edge AI engine optimization. We've developed the GEO-16 framework through extensive research analyzing 1,700+ AI engine citations across four major platforms. Our approach is data-driven, implementation-focused, and results-oriented.</p>
      
      <div class="grid-auto-fit margin-top-20">
        <div class="box-padding" style="background: #f8f8f8;">
          <h4 style="margin-top: 0; color: #000080;">Research-Driven</h4>
          <p>Our GEO-16 framework is based on comprehensive analysis of actual AI engine citations and behavior patterns.</p>
        </div>
        <div class="box-padding" style="background: #f8f8f8;">
          <h4 style="margin-top: 0; color: #000080;">Implementation-Focused</h4>
          <p>We provide actionable recommendations with clear implementation steps and measurable outcomes.</p>
        </div>
        <div class="box-padding" style="background: #f8f8f8;">
          <h4 style="margin-top: 0; color: #000080;">Results-Oriented</h4>
          <p>Our clients typically see significant improvements in AI citation rates within 90 days of implementation.</p>
        </div>
      </div>
    </div>
  </div>

</section>
</main>

<script>
document.getElementById('booking-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  
  // Show loading state
  submitBtn.textContent = 'Submitting...';
  submitBtn.disabled = true;
  
  try {
    const response = await fetch('/api/book/', {
      method: 'POST',
      body: formData
    });
    
    const result = await response.json();
    
    if (result.ok) {
      // Show success message
      alert('Thank you! Your consultation request has been submitted. We\'ll contact you within 24 hours to schedule your session.');
      this.reset();
    } else {
      throw new Error(result.error || 'Submission failed');
    }
  } catch (error) {
    alert('Sorry, there was an error submitting your request. Please try again or contact us directly.');
    console.error('Booking error:', error);
  } finally {
    // Restore button state
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  }
});
</script>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
