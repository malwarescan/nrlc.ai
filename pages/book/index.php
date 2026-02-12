<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for book page metadata configuration
require_once __DIR__ . '/../../lib/schema_builders.php';
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/gbp_config.php';

$orgId = 'https://nrlc.ai/#organization';
$canonicalUrl = absolute_url('/en-us/book/');

$GLOBALS['__page_slug'] = 'book/index';
$GLOBALS['__jsonld'] = [
  ld_organization(),
  ld_website_with_searchaction(),
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'AI SEO Consultation Booking',
    'description' => 'Schedule a consultation with NRLC.ai experts for AI-first SEO strategy, GEO-16 framework implementation, and LLM optimization.',
    'provider' => [ '@type' => 'Organization', '@id' => $orgId ],
    'serviceType' => 'AI SEO Consultation',
    'areaServed' => 'Worldwide',
    'url' => $canonicalUrl,
    'offers' => [
      '@type' => 'Offer',
      'name' => 'Free Initial Consultation',
      'price' => '0',
      'priceCurrency' => 'USD',
      'availability' => 'https://schema.org/InStock'
    ]
  ],
  ld_faq([
    ['q' => 'What happens during a consultation?', 'a' => 'We discuss your current SEO challenges, AI engine visibility goals, and technical infrastructure. We review your site\'s structure, existing schema, and crawl efficiency and give preliminary recommendations.'],
    ['q' => 'Is the consultation free?', 'a' => 'Yes. The initial consultation is free with no obligation.'],
    ['q' => 'How long is the call?', 'a' => 'Typically 30–45 minutes. We\'ll outline how our services can address your specific needs.'],
    ['q' => 'Do you work with small businesses?', 'a' => 'Yes. We work with SMBs, mid-market companies, and enterprises.'],
    ['q' => 'Do you serve Santa Monica and LA?', 'a' => 'Yes. Neural Command is headquartered in Santa Monica and serves Los Angeles, California, and nationwide.'],
    ['q' => 'What if I\'m not ready to implement?', 'a' => 'No problem. The consultation is exploratory. We\'ll leave you with a clear picture and next steps when you\'re ready.']
  ])
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
        <p style="background: #f0f7ff; border-left: 4px solid #0066cc; padding: var(--spacing-md); margin: 0;">Neural Command consultations focus on your current AI visibility and a clear path to improvement. We use the <strong>GEO-16</strong> and <strong>Answer First Architecture</strong> to guide strategy and implementation so you get cited in ChatGPT, Perplexity, and Google AI Overviews.</p>
      </div>
    </div>

    <!-- Booking Form -->
    <div class="content-block module" style="margin-bottom: var(--spacing-8);">
      <div class="content-block__header">
        <h2 class="content-block__title heading-2">Schedule Your Consultation</h2>
      </div>
      <div class="content-block__body">
        <form id="booking-form">
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
            <input type="text" id="website" name="website" placeholder="yoursite.com or https://yoursite.com">
          </div>
          
          <div style="margin-bottom: var(--spacing-lg);">
            <label for="current_challenges">What can we help you with? (optional)</label>
            <textarea id="current_challenges" name="current_challenges" rows="3" placeholder="Briefly describe your AI search visibility goals..."></textarea>
          </div>
          
          <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
            <button type="submit" class="btn btn--primary" data-ripple style="font-size: 1.1rem; padding: var(--spacing-md) var(--spacing-lg);">Email Us</button>
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
        <p>Explore our comprehensive <a href="<?= htmlspecialchars(absolute_url('/en-us/services/')) ?>">AI SEO Services</a> including <a href="<?= htmlspecialchars(absolute_url('/en-us/services/crawl-clarity/')) ?>">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
        <p>Discover our latest <a href="<?= htmlspecialchars(absolute_url('/en-us/insights/')) ?>">AI SEO Research & Insights</a> including the <a href="<?= htmlspecialchars(absolute_url('/en-us/insights/geo16-introduction/')) ?>">GEO-16 Framework</a> for AI citation optimization.</p>
        <p>Browse our <a href="<?= htmlspecialchars(absolute_url('/en-us/tools/')) ?>">SEO Tools & Resources</a> and view our <a href="<?= htmlspecialchars(absolute_url('/en-us/products/')) ?>">Products</a>.</p>
        <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
          <a href="<?= htmlspecialchars(absolute_url('/en-us/services/')) ?>" class="btn btn--primary">Get Started with AI SEO</a>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<!-- Success Message (hidden by default) -->
<div id="success-message" class="content-block module" style="display: none; margin-bottom: var(--spacing-8); border: 2px solid #00aa00; background: #f0fff0;">
  <div class="content-block__header" style="border-bottom-color: #00aa00;">
    <h2 class="content-block__title heading-2" style="color: #00aa00;">✓ Email Client Opened</h2>
  </div>
  <div class="content-block__body">
    <p class="lead">Thank You!</p>
    <p>Your email client should have opened with a pre-filled message to us.</p>
    <div style="padding: var(--spacing-md); background: #ffffff; border: 1px solid #00aa00; border-radius: 4px; margin-top: var(--spacing-md);">
      <p><strong>What's Next:</strong></p>
      <ul>
        <li>Review the email that opened in your email client</li>
        <li>Click "Send" to send it to us</li>
        <li>We'll respond within 24 hours</li>
      </ul>
      <p style="margin-top: var(--spacing-md);"><strong>If your email client didn't open:</strong></p>
      <p style="margin-bottom: 0;"><a href="mailto:info@neuralcommand.com?subject=Consultation Request">Click here to email us directly</a></p>
    </div>
    <div class="btn-group" style="justify-content: center; margin-top: var(--spacing-lg);">
      <a href="<?= htmlspecialchars(absolute_url('/en-us/')) ?>" class="btn btn--secondary" data-ripple>Return to Homepage</a>
      <a href="<?= htmlspecialchars(absolute_url('/en-us/services/')) ?>" class="btn btn--secondary" data-ripple>View Services</a>
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
document.getElementById('booking-form').addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Get form values
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const website = document.getElementById('website').value.trim();
  const challenges = document.getElementById('current_challenges').value.trim();
  
  // Build email subject
  const subject = encodeURIComponent('Consultation Request from ' + name);
  
  // Build email body
  let body = 'New consultation request:\n\n';
  body += 'Name: ' + name + '\n';
  body += 'Email: ' + email + '\n';
  if (website) {
    body += 'Website: ' + website + '\n';
  }
  if (challenges) {
    body += '\nRequesting help with:\n' + challenges + '\n';
  }
  body = encodeURIComponent(body);
  
  // Create mailto link
  const mailtoLink = 'mailto:info@neuralcommand.com?subject=' + subject + '&body=' + body;
  
  // Open email client
  window.location.href = mailtoLink;
  
  // Show success message
  const formBlock = this.closest('.content-block');
  const successMessage = document.getElementById('success-message');
  const sectionContent = document.querySelector('.section__content');
  
  // Hide form, show success
  formBlock.style.display = 'none';
  sectionContent.insertBefore(successMessage, formBlock);
  successMessage.style.display = 'block';
  
  // Update success message
  document.getElementById('booking-id').textContent = 'N/A (Email sent via your email client)';
  document.getElementById('email-status').textContent = '✓ Opening email client...';
  document.getElementById('email-status').style.color = '#00aa00';
  document.getElementById('sms-status').textContent = 'N/A';
  document.getElementById('confirmation-status').textContent = 'N/A';
  
  // Scroll to success message
  successMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
