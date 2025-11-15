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
                  <label for="website">Website URL</label>
                  <input type="url" id="website" name="website" placeholder="https://example.com">
                </div>
              </div>
              
              <div>
                <label for="service-interest">Service Interest *</label>
                <select id="service-interest" name="service_interest" required>
                  <option value="">Select a service...</option>
                  <option value="AI-First Site Audits">AI-First Site Audits</option>
                  <option value="Crawl Clarity Engineering">Crawl Clarity Engineering</option>
                  <option value="JSON-LD & Structured Data">JSON-LD & Structured Data</option>
                  <option value="LLM Seeding Optimization">LLM Seeding Optimization</option>
                  <option value="International SEO & Hreflang">International SEO & Hreflang</option>
                  <option value="General AI SEO Consultation">General AI SEO Consultation</option>
                </select>
              </div>
              
              <div>
                <label for="current_challenges">Current Challenges</label>
                <textarea id="current_challenges" name="current_challenges" rows="3" placeholder="Tell us about your current SEO challenges and goals..."></textarea>
              </div>
              
              <div>
                <label for="preferred_time">Preferred Time for Consultation</label>
                <input type="text" id="preferred_time" name="preferred_time" placeholder="e.g., Next week, weekday mornings, etc.">
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

  <!-- FAQ Window -->
  <div class="window" style="margin-bottom: 2rem;">
    <div class="title-bar">
      <div class="title-bar-text">Frequently Asked Questions</div>
    </div>
    <div class="window-body">
      <h2 style="color: #000080; margin-top: 0;">Common Questions About Our Services</h2>
      
      <div class="box-padding" style="margin-bottom: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">What happens during a consultation?</h3>
        <p>During your initial consultation, we'll discuss your current SEO challenges, AI engine visibility goals, and technical infrastructure. We'll review your site's structure, existing schema implementation, and crawl efficiency. You'll receive preliminary recommendations and a clear outline of how our services can address your specific needs.</p>
      </div>

      <div class="box-padding" style="margin-bottom: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">How long does implementation take?</h3>
        <p>Most implementations follow a 6-8 week timeline from initial audit to deployment. Phase 1 (Discovery & Audit) takes 1-2 weeks, Phase 2 (Implementation) takes 3-4 weeks, and Phase 3 (Validation & Monitoring) takes 1-2 weeks. Complex multi-regional implementations may require additional time for proper testing and validation.</p>
      </div>

      <div class="box-padding" style="margin-bottom: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">What results can I expect?</h3>
        <p>Organizations implementing our GEO-16 framework typically see 200-400% improvements in AI citation rates within 90 days. Technical implementations like crawl clarity optimization often show measurable results within 2-3 weeks. We provide detailed reporting on citation accuracy, crawl efficiency, rich results impressions, and AI engine visibility metrics.</p>
      </div>

      <div class="box-padding" style="margin-bottom: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">Do you work with all industries?</h3>
        <p>Yes, our GEO-16 framework and technical SEO services apply across all industries. We have particular expertise in B2B SaaS, professional services, e-commerce, and technical documentation sites. Our approach is methodology-driven rather than industry-specific, though we tailor implementations to your specific business context and competitive landscape.</p>
      </div>

      <div class="box-padding" style="margin-bottom: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">What's included in your audit?</h3>
        <p>Our comprehensive audit covers all sixteen GEO-16 framework pillars: metadata completeness, content freshness, semantic structure, entity clarity, verification signals, and technical quality. We analyze crawl efficiency, schema implementation, URL structure, hreflang configuration, canonical management, and AI engine citation patterns. You'll receive a detailed report with prioritized recommendations and implementation roadmap.</p>
      </div>

      <div class="box-padding">
        <h3 style="margin-top: 0; color: #000080;">Can you help with international SEO?</h3>
        <p>Absolutely. International SEO is one of our core specialties. We implement comprehensive hreflang configurations, locale-specific structured data, regional content optimization, and multi-regional crawl management. Our team has experience with complex multi-country implementations across North America, Europe, and Asia-Pacific markets.</p>
      </div>
    </div>
  </div>

</section>
</main>

<!-- Success Message Window (hidden by default, will replace form window) -->
<div id="success-window" class="window" style="display: none; margin-bottom: 2rem; border: 3px solid #00aa00;">
  <div class="title-bar" style="background: #00aa00; color: white;">
    <div class="title-bar-text">✓ Consultation Request Received</div>
  </div>
  <div class="window-body">
    <h2 style="color: #00aa00; margin-top: 0;">Thank You!</h2>
    <p class="lead">Your consultation request has been successfully submitted.</p>
    <div class="box-padding" style="background: #f0fff0; border: 1px solid #00aa00; margin-top: 1rem;">
      <p><strong>Booking ID:</strong> <span id="booking-id"></span></p>
      <p><strong>What's Next:</strong></p>
      <ul>
        <li>You'll receive a confirmation email shortly</li>
        <li>Our team will review your request</li>
        <li>We'll contact you within 24 hours to schedule your consultation</li>
      </ul>
      <p style="margin-bottom: 0;"><strong>Notifications Sent:</strong></p>
      <ul id="notification-status" style="margin-top: 0.5rem;">
        <li>Email notification to team: <span id="email-status">Pending...</span></li>
        <li>SMS notification to team: <span id="sms-status">Pending...</span></li>
        <li>Confirmation email to you: <span id="confirmation-status">Pending...</span></li>
      </ul>
      <p style="margin-top: 1rem;"><em>Note: Email delivery depends on server configuration. All requests are logged and we monitor submissions regularly.</em></p>
    </div>
    <div style="text-align: center; margin-top: 1.5rem;">
      <a href="/" class="btn" data-ripple>Return to Homepage</a>
      <a href="/services/" class="btn" data-ripple style="margin-left: 1rem;">View Services</a>
    </div>
  </div>
</div>

<!-- Error Message Window (hidden by default, will replace form window) -->
<div id="error-window" class="window" style="display: none; margin-bottom: 2rem; border: 3px solid #cc0000;">
  <div class="title-bar" style="background: #cc0000; color: white;">
    <div class="title-bar-text">⚠ Submission Error</div>
  </div>
  <div class="window-body">
    <h2 style="color: #cc0000; margin-top: 0;">Submission Failed</h2>
    <p id="error-message"></p>
    <p>Please try again or contact us directly:</p>
    <ul>
      <li>Email: <a href="mailto:hirejoelm@gmail.com">hirejoelm@gmail.com</a></li>
      <li>Phone: +1-844-568-4624</li>
    </ul>
    <div style="text-align: center; margin-top: 1.5rem;">
      <button id="retry-btn" class="btn" data-ripple>Try Again</button>
    </div>
  </div>
</div>

<script>
document.getElementById('booking-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  const formWindow = this.closest('.window');
  const successWindow = document.getElementById('success-window');
  const errorWindow = document.getElementById('error-window');
  const mainSection = document.querySelector('main section.container');
  
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
      // REPLACE form window with success window in the same location
      formWindow.style.display = 'none';
      
      // Insert success window in the first position of main section
      mainSection.insertBefore(successWindow, mainSection.firstChild);
      
      // Show success message
      document.getElementById('booking-id').textContent = result.booking_id || 'N/A';
      
      // Update notification status
      const notifications = result.notifications || {};
      document.getElementById('email-status').textContent = notifications.email_sent ? '✓ Sent' : '✗ Not sent (check mail config)';
      document.getElementById('email-status').style.color = notifications.email_sent ? '#00aa00' : '#ff9900';
      document.getElementById('sms-status').textContent = notifications.sms_sent ? '✓ Logged' : '✗ Failed';
      document.getElementById('sms-status').style.color = notifications.sms_sent ? '#00aa00' : '#ff9900';
      document.getElementById('confirmation-status').textContent = notifications.confirmation_sent ? '✓ Sent' : '✗ Not sent (check mail config)';
      document.getElementById('confirmation-status').style.color = notifications.confirmation_sent ? '#00aa00' : '#ff9900';
      
      successWindow.style.display = 'block';
      
      // Scroll to top of success window
      window.scrollTo({ top: 0, behavior: 'smooth' });
      
      // Reset form
      this.reset();
    } else {
      throw new Error(result.error || result.errors?.join(', ') || 'Submission failed');
    }
  } catch (error) {
    // REPLACE form window with error window
    formWindow.style.display = 'none';
    
    // Insert error window in the first position of main section
    mainSection.insertBefore(errorWindow, mainSection.firstChild);
    
    // Show error message
    document.getElementById('error-message').textContent = error.message || 'Sorry, there was an error submitting your request.';
    errorWindow.style.display = 'block';
    
    // Scroll to top of error window
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    console.error('Booking error:', error);
  } finally {
    // Restore button state (only if form is still visible)
    if (formWindow.style.display !== 'none') {
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    }
  }
});

// Retry button - show form window again
document.getElementById('retry-btn').addEventListener('click', function() {
  const formWindow = document.querySelector('#booking-form').closest('.window');
  const errorWindow = document.getElementById('error-window');
  const submitBtn = document.querySelector('#booking-form button[type="submit"]');
  
  // Hide error, show form
  errorWindow.style.display = 'none';
  formWindow.style.display = 'block';
  
  // Restore button state
  submitBtn.textContent = 'Request Free Consultation';
  submitBtn.disabled = false;
  
  // Scroll to form
  formWindow.scrollIntoView({ behavior: 'smooth' });
});
</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
