<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
require_once __DIR__ . '/../../lib/csv.php';

// Load latest insights
$insights = csv_read_data('insights.csv');
$latest_insights = array_slice($insights, -4); // Get last 4 insights
?>

<section class="container">
    
    <!-- Hero / Mission Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Optimizing the Internet for AI Understanding</div>
      </div>
      <div class="window-body">
        <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">NRLC.ai</h1>
        <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
          NRLC.ai engineers crawl clarity, structured data, and LLM seeding strategies that make your site readable by both Google and GPT.
        </p>
        <div style="text-align: center; margin-top: 2rem; display: flex; flex-direction: column; gap: 0.5rem; align-items: center;">
          <a href="/services/site-audits/new-york/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Run an AI-First Audit</a>
          <a href="/insights/geo16-framework/" class="btn" data-ripple style="width: 100%; max-width: 300px;">Explore GEO-16 Framework</a>
        </div>
      </div>
    </div>

    <!-- Core Services Window -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Core Services</div>
      </div>
      <div class="window-body">
        <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
          
          <div class="card" style="padding: 1rem; border: 1px solid #ccc;">
            <h3 style="margin-top: 0; color: #000080;">Crawl Clarity Engineering</h3>
            <p>Duplicate URLs, parameter pollution, and canonical drift waste crawl budget and confuse AI engines. Our crawl clarity service eliminates these issues through systematic URL normalization, parameter stripping, and canonical enforcement. We implement deterministic rules that persist across deployments, ensuring consistent AI engine comprehension and improved citation likelihood.</p>
            <a href="/services/crawl-clarity/new-york/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="card" style="padding: 1rem; border: 1px solid #ccc;">
            <h3 style="margin-top: 0; color: #000080;">JSON-LD & Structured Snippet Strategy</h3>
            <p>Thin or inconsistent structured data limits AI engine understanding and reduces citation opportunities. Our JSON-LD strategy implements comprehensive schema markup including Organization, Service, LocalBusiness, and FAQPage schemas. We ensure schema completeness, consistency, and validity across all content types, enabling AI engines to parse and cite your content effectively.</p>
            <a href="/services/json-ld-strategy/new-york/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="card" style="padding: 1rem; border: 1px solid #ccc;">
            <h3 style="margin-top: 0; color: #000080;">LLM Seeding Optimization</h3>
            <p>AI engines prioritize content that demonstrates entity clarity, semantic structure, and verification signals. Our LLM seeding service optimizes content for AI comprehension through systematic entity identification, relationship mapping, and credibility enhancement. We implement GEO-16 framework principles to ensure your content meets AI engine citation requirements.</p>
            <a href="/services/llm-seeding/new-york/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="card" style="padding: 1rem; border: 1px solid #ccc;">
            <h3 style="margin-top: 0; color: #000080;">AI-First Site Audits</h3>
            <p>Traditional SEO audits miss AI-specific optimization opportunities and fail to address generative search requirements. Our AI-first audits evaluate content against GEO-16 framework pillars, assess structured data completeness, and identify AI engine visibility gaps. We provide actionable recommendations for improving citation likelihood and AI engine comprehension.</p>
            <a href="/services/site-audits/new-york/" class="btn" data-ripple>Learn More</a>
          </div>

          <div class="card" style="padding: 1rem; border: 1px solid #ccc;">
            <h3 style="margin-top: 0; color: #000080;">International SEO & Hreflang Engineering</h3>
            <p>Multi-regional content requires sophisticated hreflang implementation and locale-specific optimization to ensure proper AI engine targeting. Our international SEO service implements comprehensive hreflang clusters, locale-specific structured data, and regional content optimization. We ensure AI engines understand geographic targeting and serve appropriate content to users worldwide.</p>
            <a href="/services/international-seo/new-york/" class="btn" data-ripple>Learn More</a>
          </div>

        </div>
      </div>
    </div>

    <!-- GEO-16 Framework Summary -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">GEO-16 Framework</div>
      </div>
      <div class="window-body">
        <p>The GEO-16 framework represents our comprehensive research into AI engine citation behavior, identifying sixteen critical signals that determine citation success in generative search engines. Based on analysis of 1,700 citations across four major AI engines, the framework provides actionable guidance for optimizing content structure, metadata completeness, entity clarity, and verification signals. Organizations implementing GEO-16 principles see average citation improvements of 340% within 90 days.</p>
        <div style="text-align: center; margin-top: 1rem;">
          <a href="/insights/geo16-framework/" class="btn" data-ripple>Read Full Framework</a>
        </div>
      </div>
    </div>

    <!-- Latest Insights Feed -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Latest Research & Insights</div>
      </div>
      <div class="window-body">
        <div class="list-view">
          <?php foreach (array_reverse($latest_insights) as $insight): ?>
            <div class="list-item" style="padding: 0.5rem; border-bottom: 1px solid #ccc;">
              <h4 style="margin: 0 0 0.5rem 0; color: #000080;">
                <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" style="text-decoration: none; color: inherit;">
                  <?= htmlspecialchars($insight['title']) ?>
                </a>
              </h4>
              <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem;">
                <?= htmlspecialchars(substr($insight['keywords'] ?? '', 0, 100)) ?>...
              </p>
              <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn" data-ripple style="font-size: 0.8rem;">Read Article</a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Open-Source Resources -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Open-Source Research & Tools</div>
      </div>
      <div class="window-body">
        <p>Our research builds upon foundational open-source projects that enable AI-first optimization. <a href="/insights/yago-entity-mapping/">YAGO</a> provides comprehensive entity disambiguation and canonical mapping capabilities essential for schema alignment. <a href="/insights/ocrplus-data-ingestion/">OCR++</a> technologies enable conversion of legacy documents into structured data pipelines that AI engines can parse effectively.</p>
        
        <p><a href="/insights/semantic-drift-tracking/">Semantic drift tracking</a> research helps organizations maintain content freshness and relevance over time, while <a href="/insights/ontology-based-search/">ontology-based search systems</a> improve generative retrieval capabilities. We integrate these open-source tools with our proprietary GEO-16 framework to provide comprehensive optimization solutions.</p>
        
        <p>Our <a href="/insights/open-seo-tools/">curated tool list</a> includes Lighthouse for performance auditing, Stanford CoreNLP for natural language processing, and Apache Tika for content extraction. These tools, combined with our research insights, enable organizations to implement effective AI-first optimization strategies.</p>
      </div>
    </div>

    <!-- Homepage FAQ -->
    <div class="window" style="margin-bottom: 2rem;">
      <div class="title-bar">
        <div class="title-bar-text">Frequently Asked Questions</div>
      </div>
      <div class="window-body">
        <div class="faq-section">
          <h3 style="color: #000080;">What is GEO-16?</h3>
          <p>The GEO-16 framework is a sixteen-pillar model defining on-page and off-page signals that increase AI engine citation likelihood. Based on comprehensive research analyzing 1,700 citations across four major AI engines, the framework provides actionable guidance for optimizing content structure, metadata completeness, entity clarity, and verification signals.</p>
          
          <h3 style="color: #000080;">How does LLM seeding work?</h3>
          <p>LLM seeding works by publishing crawl-clear, schema-rich content that large language models can parse and cite directly. This involves implementing comprehensive structured data, ensuring entity clarity, maintaining semantic structure, and providing verification signals that demonstrate content authority and reliability.</p>
          
          <h3 style="color: #000080;">Why Windows 98 aesthetic?</h3>
          <p>Because clarity never goes out of style. The Windows 98 aesthetic symbolizes system transparency and control — the same principles NRLC.ai applies to crawl engineering. Just as Windows 98 provided users with clear system feedback and predictable behavior, we provide organizations with transparent optimization processes and reliable results.</p>
          
          <h3 style="color: #000080;">How quickly can I see results?</h3>
          <p>Organizations implementing our GEO-16 framework typically see significant improvements in AI citation rates within 90 days. The most dramatic improvements occur in technical documentation and research content, where structured data implementation and entity clarity have the greatest impact on AI engine comprehension.</p>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div style="text-align: center; margin-top: 2rem; padding: 1rem; background: #f0f0f0; border: 1px solid #ccc;">
      <a href="/api/book/" class="btn" data-ripple style="margin-right: 1rem;">Request an Audit</a>
      <a href="/services/" class="btn" data-ripple style="margin-right: 1rem;">See Services</a>
      <a href="/insights/" class="btn" data-ripple>Read Insights</a>
    </div>

</section>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"WebSite",
 "name":"NRLC.ai",
 "url":"https://nrlc.ai",
 "description":"NRLC.ai optimizes web ecosystems for AI discovery and LLM citation through Crawl Clarity, JSON-LD Strategy, and GEO-16 Framework research.",
 "publisher":{"@type":"Organization","name":"NRLC.ai"},
 "potentialAction":{"@type":"SearchAction","target":"https://nrlc.ai/search/?q={query}","query-input":"required name=query"},
 "hasPart":[
   {"@type":"Service","name":"Crawl Clarity Engineering"},
   {"@type":"Service","name":"JSON-LD & Structured Snippet Strategy"},
   {"@type":"Service","name":"LLM Seeding Optimization"},
   {"@type":"Service","name":"AI-First Site Audits"},
   {"@type":"Service","name":"International SEO & Hreflang Engineering"}
 ],
 "about":["AI SEO","GEO-16","Crawl Clarity","Structured Data","LLM Seeding"]
}
</script>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"FAQPage",
 "mainEntity":[
  {"@type":"Question","name":"What is GEO-16?","acceptedAnswer":{"@type":"Answer","text":"A sixteen-pillar model defining on-page and off-page signals that increase AI engine citation likelihood."}},
  {"@type":"Question","name":"How does LLM seeding work?","acceptedAnswer":{"@type":"Answer","text":"By publishing crawl-clear, schema-rich content that large language models can parse and cite directly."}},
  {"@type":"Question","name":"Why Windows 98 aesthetic?","acceptedAnswer":{"@type":"Answer","text":"It symbolizes system transparency and control — the same principles NRLC.ai applies to crawl engineering."}},
  {"@type":"Question","name":"How quickly can I see results?","acceptedAnswer":{"@type":"Answer","text":"Organizations implementing our GEO-16 framework typically see significant improvements in AI citation rates within 90 days."}}
 ]
}
</script>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>