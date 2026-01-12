<?php

$GLOBALS['pageDesc'] = 'Industry-specific AI search system configurations where schema priorities, entity graphs, indexing constraints, and agent safety rules differ materially.';
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Hero Block -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Industries Where AI Search Behavior, Schema Requirements, and Agent Constraints Differ Materially</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Industries are separated here because AI search systems do not behave uniformly across domains. Each industry introduces different entity relationships, schema priorities, regulatory constraints, indexing behavior, and retrieval risk. Neural Command treats industries as distinct system configurations, not marketing verticals. Each industry page represents a tailored Model Context Protocol (MCP) that governs how agents operate, how schema is enforced, and how information is made extractable and stable across Google Search, ChatGPT, Perplexity, and AI Overviews.</p>
      </div>
    </div>

    <!-- Industry Configurations Grid -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Industry Configurations</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Healthcare AI Search Configuration</h3>
            </div>
            <div class="content-block__body">
              <p>Healthcare-specific entity graphs, HIPAA-compliant schema governance, medical terminology disambiguation, and agent constraints for regulatory compliance.</p>
              <div class="btn-group">
                <a href="/industries/healthcare/" class="btn">View Healthcare Configuration</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Fintech AI Search Configuration</h3>
            </div>
            <div class="content-block__body">
              <p>Financial services entity mapping, regulatory compliance schemas, fintech terminology recognition, and agent safety rules for financial data.</p>
              <div class="btn-group">
                <a href="/industries/fintech/" class="btn">View Fintech Configuration</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">E-commerce AI Search Configuration</h3>
            </div>
            <div class="content-block__body">
              <p>Product catalog entity graphs, shopping schema priorities, e-commerce structured data patterns, and agent constraints for inventory data.</p>
              <div class="btn-group">
                <a href="/industries/ecommerce/" class="btn">View E-commerce Configuration</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">SaaS AI Search Configuration</h3>
            </div>
            <div class="content-block__body">
              <p>Software entity recognition, API documentation schema, SaaS terminology mapping, and agent constraints for technical documentation.</p>
              <div class="btn-group">
                <a href="/industries/saas/" class="btn">View SaaS Configuration</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Education AI Search Configuration</h3>
            </div>
            <div class="content-block__body">
              <p>Academic entity graphs, educational content schema priorities, learning management system patterns, and agent constraints for academic data.</p>
              <div class="btn-group">
                <a href="/industries/education/" class="btn">View Education Configuration</a>
              </div>
            </div>
          </div>
          
          <div class="content-block">
            <div class="content-block__header">
              <h3 class="content-block__title">Real Estate AI Search Configuration</h3>
            </div>
            <div class="content-block__body">
              <p>Property entity mapping, location-based schema priorities, real estate structured data patterns, and agent constraints for location data.</p>
              <div class="btn-group">
                <a href="/industries/real-estate/" class="btn">View Real Estate Configuration</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Architecture Callout -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">System Architecture</h2>
      </div>
      <div class="content-block__body">
        <div class="callout-system-truth" style="padding: var(--spacing-6, 1.5rem); border-left: 4px solid var(--color-brand, #12355e); background: var(--color-background-alt, #f5f5f5); margin: var(--spacing-6, 1.5rem) 0;">
          <p>Industry configurations operate within <a href="/products/neural-command-os/">Neural Command OS</a>, which installs the Model Context Protocol and agent execution layer. Each industry page documents how the MCP adapts to domain-specific requirements.</p>
          <p style="margin-top: var(--spacing-4, 1rem);">For implementation details, see <a href="/services/">AI SEO Services</a> and <a href="/training/">Training</a> for operational governance. For research on AI search behavior, see <a href="/insights/">AI SEO Research & Insights</a> including the <a href="/insights/geo16-introduction/">GEO-16 Framework</a> for AI citation optimization.</p>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"CollectionPage",
 "name":"Industry-Specific AI Search System Configurations",
 "description":"Industry-specific AI search system configurations where schema priorities, entity graphs, indexing constraints, and agent safety rules differ materially. Each industry represents a distinct Model Context Protocol (MCP) configuration.",
 "url":"https://nrlc.ai/industries/",
 "about":{
  "@type":"SoftwareApplication",
  "name":"Neural Command OS",
  "url":"https://nrlc.ai/products/neural-command-os/"
 },
 "mainEntity":{
  "@type":"ItemList",
  "itemListElement":[
   {"@type":"ListItem","position":1,"name":"Healthcare AI Search Configuration","url":"https://nrlc.ai/industries/healthcare/"},
   {"@type":"ListItem","position":2,"name":"Fintech AI Search Configuration","url":"https://nrlc.ai/industries/fintech/"},
   {"@type":"ListItem","position":3,"name":"E-commerce AI Search Configuration","url":"https://nrlc.ai/industries/ecommerce/"},
   {"@type":"ListItem","position":4,"name":"SaaS AI Search Configuration","url":"https://nrlc.ai/industries/saas/"},
   {"@type":"ListItem","position":5,"name":"Education AI Search Configuration","url":"https://nrlc.ai/industries/education/"},
   {"@type":"ListItem","position":6,"name":"Real Estate AI Search Configuration","url":"https://nrlc.ai/industries/real-estate/"}
  ]
 }
}
</script>

<?php
// Note: footer.php is already included by router.php render_page()
// Do not duplicate it here to avoid double footers
?>
