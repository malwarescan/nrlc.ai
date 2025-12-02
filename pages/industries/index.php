<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
?>

<section class="window container prose">
  <div class="title-bar">
    <div class="title-bar-text">Industry-Specific AI SEO Solutions</div>
  </div>
  <div class="window-body">
    <h2>AI SEO Solutions by Industry</h2>
    <p class="lead">Tailored AI optimization strategies for specific industries and verticals.</p>
    
    <div class="grid" class="grid grid-auto-fit">
      <div style="padding: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">Healthcare AI SEO</h3>
        <p>Medical content optimization for AI engines, HIPAA-compliant structured data, and healthcare entity recognition.</p>
        <a href="/industries/healthcare/" class="btn" data-ripple>Learn More</a>
      </div>
      
      <div style="padding: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">Fintech AI SEO</h3>
        <p>Financial services optimization, regulatory compliance, and fintech entity mapping for AI discovery.</p>
        <a href="/industries/fintech/" class="btn" data-ripple>Learn More</a>
      </div>
      
      <div style="padding: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">E-commerce AI SEO</h3>
        <p>Product catalog optimization, shopping AI integration, and e-commerce structured data for AI engines.</p>
        <a href="/industries/ecommerce/" class="btn" data-ripple>Learn More</a>
      </div>
      
      <div style="padding: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">SaaS AI SEO</h3>
        <p>Software-as-a-Service optimization, API documentation, and SaaS entity recognition for AI platforms.</p>
        <a href="/industries/saas/" class="btn" data-ripple>Learn More</a>
      </div>
      
      <div style="padding: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">Education AI SEO</h3>
        <p>Educational content optimization, learning management systems, and academic entity mapping.</p>
        <a href="/industries/education/" class="btn" data-ripple>Learn More</a>
      </div>
      
      <div style="padding: 1rem;">
        <h3 style="margin-top: 0; color: #000080;">Real Estate AI SEO</h3>
        <p>Property listing optimization, location-based AI discovery, and real estate structured data.</p>
        <a href="/industries/real-estate/" class="btn" data-ripple>Learn More</a>
      </div>
    </div>
    
    <!-- Related Resources -->
    <div class="window-body" style="margin-top: 2rem;">
      <h2>Related Resources</h2>
      <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization.</p>
      <p>Discover our latest <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
      <p>Browse our <a href="/tools/">SEO Tools & Resources</a> for technical SEO optimization.</p>
      <div class="text-center" style="margin-top: 1.5rem;">
        <a href="/services/" class="btn btn--primary">Get Started with AI SEO</a>
      </div>
    </div>
  </div>
</section>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"WebPage",
 "name":"Industry-Specific AI SEO Solutions",
 "description":"Tailored AI optimization strategies for specific industries and verticals.",
 "url":"https://nrlc.ai/industries/",
 "mainEntity":{
  "@type":"ItemList",
  "itemListElement":[
   {"@type":"ListItem","position":1,"name":"Healthcare AI SEO"},
   {"@type":"ListItem","position":2,"name":"Fintech AI SEO"},
   {"@type":"ListItem","position":3,"name":"E-commerce AI SEO"},
   {"@type":"ListItem","position":4,"name":"SaaS AI SEO"},
   {"@type":"ListItem","position":5,"name":"Education AI SEO"},
   {"@type":"ListItem","position":6,"name":"Real Estate AI SEO"}
  ]
 }
}
</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
