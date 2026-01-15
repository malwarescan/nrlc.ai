<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for book page metadata configuration
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

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Hero Section -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h1 class="content-block__title heading-1">Book AI SEO Consultation</h1>
      </div>
      <div class="content-block__body">
        <p class="lead" style="font-size: 1.2rem; margin-bottom: var(--spacing-lg);">
          Get expert guidance on implementing the GEO-16 framework, optimizing for AI engines, and improving your LLM citation rates.
        </p>
      </div>
    </div>

    <!-- Booking Form -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title heading-2">Schedule Your Consultation</h2>
      </div>
      <div class="content-block__body">
        <form id="booking-form" method="POST" action="/api/book/">
          <div style="margin-bottom: var(--spacing-md);">
            <label for="name">Your Name *</label>
            <input type="text" id="name" name="name" required autocomplete="name">
          </div>
          
          <div style="margin-bottom: var(--spacing-md);">
            <label for="email">Your Email *</label>
            <input type="email" id="email" name="email" required autocomplete="email">
          </div>
          
          <div style="margin-bottom: var(--spacing-md);">
            <label for="website">Your Website (optional)</label>
            <input type="url" id="website" name="website" placeholder="https://yoursite.com" autocomplete="url">
          </div>
          
          <div style="margin-bottom: var(--spacing-lg);">
            <label for="current_challenges">What can we help you with? (optional)</label>
            <textarea id="current_challenges" name="current_challenges" rows="3" placeholder="Briefly describe your AI search visibility goals..."></textarea>
          </div>
          
          <!-- Hidden fields with defaults -->
          <input type="hidden" id="company" name="company" value="">
          <input type="hidden" id="service-interest" name="service_interest" value="General AI SEO Consultation">
          <input type="hidden" id="preferred_time" name="preferred_time" value="">
          
          <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
            <button type="submit" class="btn btn--primary" data-ripple style="font-size: 1.1rem; padding: var(--spacing-md) var(--spacing-lg);">Request Free Consultation</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Why Choose NRLC.ai -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title heading-2">Why Choose NRLC.ai?</h2>
      </div>
      <div class="content-block__body">
        <p>Our team combines deep expertise in traditional SEO with cutting-edge AI engine optimization. We've developed the GEO-16 framework through extensive research analyzing 1,700+ AI engine citations across four major platforms. Our approach is data-driven, implementation-focused, and results-oriented.</p>
        
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-md); margin-top: var(--spacing-lg);">
          <div style="padding: var(--spacing-md); background: #f8f8f8; border: 1px solid var(--color-border); border-radius: 4px;">
            <h3 style="margin-top: 0; color: var(--color-text-primary);">Research-Driven</h3>
            <p>Our GEO-16 framework is based on comprehensive analysis of actual AI engine citations and behavior patterns.</p>
          </div>
          <div style="padding: var(--spacing-md); background: #f8f8f8; border: 1px solid var(--color-border); border-radius: 4px;">
            <h3 style="margin-top: 0; color: var(--color-text-primary);">Implementation-Focused</h3>
            <p>We provide actionable recommendations with clear implementation steps and measurable outcomes.</p>
          </div>
          <div style="padding: var(--spacing-md); background: #f8f8f8; border: 1px solid var(--color-border); border-radius: 4px;">
            <h3 style="margin-top: 0; color: var(--color-text-primary);">Results-Oriented</h3>
            <p>Our clients typically see significant improvements in AI citation rates within 90 days of implementation.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title heading-2">Frequently Asked Questions</h2>
      </div>
      <div class="content-block__body">
        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; color: var(--color-text-primary);">What happens during a consultation?</h3>
          <p>During your initial consultation, we'll discuss your current SEO challenges, AI engine visibility goals, and technical infrastructure. We'll review your site's structure, existing schema implementation, and crawl efficiency. You'll receive preliminary recommendations and a clear outline of how our services can address your specific needs.</p>
        </div>

        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; color: var(--color-text-primary);">How long does implementation take?</h3>
          <p>Most implementations follow a 6-8 week timeline from initial audit to deployment. Phase 1 (Discovery & Audit) takes 1-2 weeks, Phase 2 (Implementation) takes 3-4 weeks, and Phase 3 (Validation & Monitoring) takes 1-2 weeks. Complex multi-regional implementations may require additional time for proper testing and validation.</p>
        </div>

        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; color: var(--color-text-primary);">What results can I expect?</h3>
          <p>Organizations implementing our GEO-16 framework typically see 200-400% improvements in AI citation rates within 90 days. Technical implementations like crawl clarity optimization often show measurable results within 2-3 weeks. We provide detailed reporting on citation accuracy, crawl efficiency, rich results impressions, and AI engine visibility metrics.</p>
        </div>

        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; color: var(--color-text-primary);">Do you work with all industries?</h3>
          <p>Yes, our GEO-16 framework and technical SEO services apply across all industries. We have particular expertise in B2B SaaS, professional services, e-commerce, and technical documentation sites. Our approach is methodology-driven rather than industry-specific, though we tailor implementations to your specific business context and competitive landscape.</p>
        </div>

        <div style="margin-bottom: var(--spacing-md);">
          <h3 style="margin-top: 0; color: var(--color-text-primary);">What's included in your audit?</h3>
          <p>Our comprehensive audit covers all sixteen GEO-16 framework pillars: metadata completeness, content freshness, semantic structure, entity clarity, verification signals, and technical quality. We analyze crawl efficiency, schema implementation, URL structure, hreflang configuration, canonical management, and AI engine citation patterns. You'll receive a detailed report with prioritized recommendations and implementation roadmap.</p>
        </div>

        <div>
          <h3 style="margin-top: 0; color: var(--color-text-primary);">Can you help with international SEO?</h3>
          <p>Absolutely. International SEO is one of our core specialties. We implement comprehensive hreflang configurations, locale-specific structured data, regional content optimization, and multi-regional crawl management. Our team has experience with complex multi-country implementations across North America, Europe, and Asia-Pacific markets.</p>
        </div>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title heading-2">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="/tools/">SEO Tools & Resources</a> and view our <a href="/products/">Products</a>.</p>
        <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
          <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<!-- Success Message (hidden by default) -->
<div id="success-message" class="content-block module" style="display: none; margin-bottom: var(--spacing-8); border: 2px solid #00aa00; background: #f0fff0;">
  <div class="content-block__header" style="border-bottom-color: #00aa00;">
    <h2 class="content-block__title heading-2" style="color: #00aa00;">✓ Consultation Request Received</h2>
  </div>
  <div class="content-block__body">
    <p class="lead">Thank You!</p>
    <p>Your consultation request has been successfully submitted.</p>
    <div style="padding: var(--spacing-md); background: #ffffff; border: 1px solid #00aa00; border-radius: 4px; margin-top: var(--spacing-md);">
      <p><strong>Booking ID:</strong> <span id="booking-id"></span></p>
      <p><strong>What's Next:</strong></p>
      <ul>
        <li>You'll receive a confirmation email shortly</li>
        <li>Our team will review your request</li>
        <li>We'll contact you within 24 hours to schedule your consultation</li>
      </ul>
      <p style="margin-top: var(--spacing-md); margin-bottom: 0;"><strong>Notifications Sent:</strong></p>
      <ul id="notification-status" style="margin-top: var(--spacing-sm);">
        <li>Email notification to team: <span id="email-status">Pending...</span></li>
        <li>SMS notification to team: <span id="sms-status">Pending...</span></li>
        <li>Confirmation email to you: <span id="confirmation-status">Pending...</span></li>
      </ul>
      <p style="margin-top: var(--spacing-md);"><em>Note: Email delivery depends on server configuration. All requests are logged and we monitor submissions regularly.</em></p>
    </div>
    <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
      <a href="/" class="btn btn--secondary" data-ripple>Return to Homepage</a>
      <a href="/services/" class="btn btn--secondary" data-ripple>View Services</a>
    </div>
  </div>
</div>

<!-- Error Message (hidden by default) -->
<div id="error-message" class="content-block module" style="display: none; margin-bottom: var(--spacing-8); border: 2px solid #cc0000; background: #fff0f0;">
  <div class="content-block__header" style="border-bottom-color: #cc0000;">
    <h2 class="content-block__title heading-2" style="color: #cc0000;">⚠ Submission Error</h2>
  </div>
  <div class="content-block__body">
    <p id="error-text"></p>
    <p>Please try again or contact us directly:</p>
    <ul>
      <li>Email: <a href="mailto:info@neuralcommandllc.com">info@neuralcommandllc.com</a></li>
      <li>Phone: +1-844-568-4624</li>
    </ul>
    <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
      <button id="retry-btn" class="btn btn--primary" data-ripple>Try Again</button>
    </div>
  </div>
</div>

<style>
/* Responsive grid for form fields */
@media (min-width: 640px) {
  #booking-form > div[style*="grid-template-columns"] {
    grid-template-columns: 1fr 1fr !important;
  }
  
  .content-block__body > div[style*="grid-template-columns"] {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
  }
}
</style>

<script>
document.getElementById('booking-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  const formBlock = this.closest('.content-block');
  const successMessage = document.getElementById('success-message');
  const errorMessage = document.getElementById('error-message');
  const sectionContent = document.querySelector('.section__content');
  
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
      // Hide form block
      formBlock.style.display = 'none';
      
      // Insert success message before form block
      sectionContent.insertBefore(successMessage, formBlock);
      
      // Show success message
      successMessage.style.display = 'block';
      document.getElementById('booking-id').textContent = result.booking_id || 'N/A';
      
      // Update notification status
      const notifications = result.notifications || {};
      document.getElementById('email-status').textContent = notifications.email_sent ? '✓ Sent' : '✗ Not sent (check mail config)';
      document.getElementById('email-status').style.color = notifications.email_sent ? '#00aa00' : '#ff9900';
      document.getElementById('sms-status').textContent = notifications.sms_sent ? '✓ Logged' : '✗ Failed';
      document.getElementById('sms-status').style.color = notifications.sms_sent ? '#00aa00' : '#ff9900';
      document.getElementById('confirmation-status').textContent = notifications.confirmation_sent ? '✓ Sent' : '✗ Not sent (check mail config)';
      document.getElementById('confirmation-status').style.color = notifications.confirmation_sent ? '#00aa00' : '#ff9900';
      
      // Scroll to success message
      successMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });
      
      // Reset form
      this.reset();
    } else {
      throw new Error(result.error || result.errors?.join(', ') || 'Submission failed');
    }
  } catch (error) {
    // Hide form block
    formBlock.style.display = 'none';
    
    // Insert error message before form block
    sectionContent.insertBefore(errorMessage, formBlock);
    
    // Show error message
    errorMessage.style.display = 'block';
    document.getElementById('error-text').textContent = error.message || 'Sorry, there was an error submitting your request.';
    
    // Scroll to error message
    errorMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    console.error('Booking error:', error);
  } finally {
    // Restore button state (only if form is still visible)
    if (formBlock.style.display !== 'none') {
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    }
  }
});

// Retry button - show form again
document.getElementById('retry-btn').addEventListener('click', function() {
  const formBlock = document.querySelector('#booking-form').closest('.content-block');
  const errorMessage = document.getElementById('error-message');
  const submitBtn = document.querySelector('#booking-form button[type="submit"]');
  
  // Hide error, show form
  errorMessage.style.display = 'none';
  formBlock.style.display = 'block';
  
  // Restore button state
  submitBtn.textContent = 'Request Free Consultation';
  submitBtn.disabled = false;
  
  // Scroll to form
  formBlock.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
