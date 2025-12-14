<?php
// Note: head.php and header.php are already included by router.php render_page()
// Metadata is set by router via sudo_meta_directive_ctx()
// See bootstrap/router.php for product page metadata configuration
require_once __DIR__ . '/../../lib/product_schemas.php';

$GLOBALS['__page_slug'] = 'products/ourcasa-ai';
$GLOBALS['pageTitle'] = 'OurCasa.ai | NRLC.ai';
$GLOBALS['pageDesc'] = 'Home and neighborhood intelligence graph connecting property data, weather patterns, local incidents, and neighborhood insights. AI SEO product by NRLC.ai.';

// Build comprehensive schemas
$productSlug = 'ourcasa-ai';
$productName = 'OurCasa.ai';
$productDescription = 'Home and neighborhood intelligence graph with property cognition, weather risk mapping, local incident history, maintenance prediction, and neighborhood lifestyle knowledge.';
$features = [
  'Property cognition',
  'Weather and climate risk mapping',
  'Local incident history',
  'Maintenance prediction',
  'Home insights from NOAA and municipal data',
  'Neighborhood lifestyle knowledge',
  'Connection to local service providers'
];

$jsonld = array_merge(
  product_universal_schemas($productSlug, $productName, $productDescription),
  product_platform_schemas($productSlug, $productName, $productDescription, $features, 'LifestyleApplication'),
  ourcasa_ai_schemas(),
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
        <h1 class="content-block__title">OurCasa.ai</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Home and neighborhood intelligence graph connecting property data, weather patterns, local incidents, and neighborhood insights.</p>
        <p>OurCasa builds personal home intelligence, bridging local data, AI, and homeowner decision making.</p>
        <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> and discover related <a href="/insights/">AI SEO Research & Insights</a>. Learn more about our <a href="/tools/">SEO Tools & Resources</a>.</p>
      </div>
    </div>

    <!-- Capabilities -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Capabilities</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div>
            <h3>Property Cognition</h3>
            <p>Comprehensive understanding of property characteristics, history, and value drivers through structured data analysis.</p>
          </div>
          <div>
            <h3>Weather & Climate Risk Mapping</h3>
            <p>Integration of NOAA weather data and climate risk assessments to predict property vulnerabilities and maintenance needs.</p>
          </div>
          <div>
            <h3>Local Incident History</h3>
            <p>Historical tracking of local incidents, events, and neighborhood changes that impact property value and livability.</p>
          </div>
          <div>
            <h3>Maintenance Prediction</h3>
            <p>AI-powered predictions for maintenance needs based on property age, weather patterns, and local conditions.</p>
          </div>
          <div>
            <h3>Home Insights from NOAA & Municipal Data</h3>
            <p>Integration of government data sources to provide comprehensive property and neighborhood intelligence.</p>
          </div>
          <div>
            <h3>Neighborhood Lifestyle Knowledge</h3>
            <p>Understanding of neighborhood characteristics, amenities, demographics, and lifestyle factors.</p>
          </div>
          <div>
            <h3>Connection to Local Service Providers</h3>
            <p>Intelligent matching of homeowners with local service providers based on property needs and location.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Value Proposition -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Value Proposition</h2>
      </div>
      <div class="content-block__body">
        <p>OurCasa.ai transforms fragmented property and neighborhood data into actionable intelligence. By connecting weather patterns, local incidents, municipal records, and neighborhood insights, homeowners gain unprecedented visibility into their property's context and future needs.</p>
      </div>
    </div>

    <div class="content-block module">
      <div class="content-block__body">
        <p>Ready to implement OurCasa.ai for your property intelligence needs? Contact us to learn more about our AI-first SEO services and how we can help optimize your content for AI engines.</p>
        <div class="btn-group text-center">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('OurCasa.ai Product Inquiry')">Schedule Consultation</button>
          <a href="/products/" class="btn">View All Products</a>
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


