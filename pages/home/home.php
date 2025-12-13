<?php
// Set consumer-friendly metadata for homepage
// Note: head.php and header.php are already included by router.php render_page()
// Do not duplicate them here to avoid double headers
$GLOBALS['pageTitle'] = 'Are You Showing Up When People Ask ChatGPT About Your Bus...';
$GLOBALS['pageDesc'] = 'Search behavior has shifted to AI-driven interfaces. Google AI Overviews, ChatGPT, Claude, and Perplexity now determine visibility through LLM comprehen...';

require_once __DIR__ . '/../../lib/csv.php';

// Load services for display
$services = csv_read_data('services.csv');
$keyServices = array_filter($services, function($s) {
    $key = ['chatgpt-optimization', 'ai-overviews-optimization', 'semantic-seo-ai', 'llm-seeding', 'site-audits'];
    return in_array($s['slug'], $key);
});

// Load latest insights
$insights = csv_read_data('insights.csv');
$latest_insights = array_slice($insights, -3);
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- Hero Section: Consumer-Friendly Value Prop -->
    <div class="content-block module" style="background: linear-gradient(135deg, #0B1220 0%, #1a1f3a 100%); padding: 3rem; border-radius: 8px; margin-bottom: 3rem;">
      <div class="content-block__header">
        <h1 class="content-block__title" style="color: #fff; font-size: 2.5rem; margin-bottom: 1rem;">
          Are You Showing Up When People Ask ChatGPT About Your Business?
        </h1>
      </div>
      <div class="content-block__body" style="color: #e0e0e0;">
        <p class="lead" style="font-size: 1.25rem; color: #fff; margin-bottom: 1.5rem;">
          Search behavior has shifted to AI-driven interfaces. Google AI Overviews, ChatGPT, Claude, and Perplexity now determine visibility through LLM comprehension patterns rather than traditional keyword ranking signals.
        </p>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; color: #fff;">
          Prompt surface intelligence reveals the actual conversational inputs, AI rewrites, and semantic variants that determine citation likelihood. We map these patterns and implement structured data, entity clarity, and content architecture aligned with LLM training patterns.
        </p>
        <div class="btn-group" style="margin-top: 2rem;">
          <button type="button" class="btn btn--primary" style="font-size: 1.1rem; padding: 1rem 2rem;" onclick="openContactSheet('AI SEO Consultation')">
            Request AI Visibility Analysis
          </button>
          <a href="#how-it-works" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem; background: rgba(255,255,255,0.1); color: #fff;">
            View Methodology
          </a>
        </div>
      </div>
    </div>

    <!-- Problem Section: Why Traditional SEO Fails -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">The Problem: Search Has Changed Forever</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">
          Google AI Overviews and ChatGPT use LLM comprehension patterns that differ from traditional search ranking algorithms. Visibility requires structured data depth, entity clarity, and content architecture aligned with how AI engines process and cite information.
        </p>
        <div class="grid grid-auto-fit" style="margin-top: 2rem; gap: 1.5rem;">
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="color: #d32f2f; margin-top: 0;">Traditional SEO Limitations</h3>
            <ul>
              <li>Keyword ranking optimization only</li>
              <li>Google search results focus</li>
              <li>No AI rewrite consideration</li>
              <li>Missing ChatGPT and AI Overviews visibility</li>
            </ul>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #4caf50; border-radius: 8px; background: #f1f8f4;">
            <h3 style="color: #4caf50; margin-top: 0;">AI SEO Approach</h3>
            <ul>
              <li>AI comprehension optimization</li>
              <li>ChatGPT citation targeting</li>
              <li>Google AI Overviews visibility</li>
              <li>LLM citation attribution</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Solution Preview: What We Show You -->
    <div class="content-block module" id="how-it-works">
      <div class="content-block__header">
        <h2 class="content-block__title">See What Prompts Your Website Actually Surfaces For</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">
          Prompt surface intelligence analysis identifies the conversational inputs, AI query transformations, and semantic variants that trigger citation in ChatGPT, Google AI Overviews, Claude, and Perplexity. This reverse-engineering reveals actual visibility patterns versus assumed keyword targeting.
        </p>
        <div style="background: #f5f5f5; padding: 2rem; border-radius: 8px; margin: 2rem 0;">
          <h3 style="margin-top: 0;">Example: What We Discover</h3>
          <div style="background: #fff; padding: 1.5rem; border-left: 4px solid #2196F3; margin: 1rem 0;">
            <p><strong>User asks ChatGPT:</strong> "What are the best AI SEO services in [your city]?"</p>
            <p><strong>Your site surfaces for:</strong></p>
            <ul>
              <li>"AI SEO services [your city]"</li>
              <li>"How to optimize for ChatGPT"</li>
              <li>"AI Overviews optimization"</li>
              <li>"LLM citation strategies"</li>
            </ul>
            <p><strong>Or it doesn't surface at all.</strong> We show you which one.</p>
          </div>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn--primary" onclick="openContactSheet('Prompt Surface Intelligence Audit')">
            Request Prompt Surface Analysis
          </button>
          <a href="/products/prompt-surface-intelligence/" class="btn">View Prompt Surface Intelligence Documentation</a>
        </div>
      </div>
    </div>

    <!-- Services: What We Offer (Consumer-Friendly) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI SEO Services That Get Results</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">
          Services based on GEO-16 framework research and analysis of Google's LLMs.txt documentation. Implementation focuses on structured data depth, entity mapping, and content architecture that enables AI engine comprehension and citation.
        </p>
        <div class="grid grid-auto-fit" style="margin-top: 2rem; gap: 1.5rem;">
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">ChatGPT Optimization</h3>
            <p>Structured data implementation and entity clarity optimization for ChatGPT citation. JSON-LD schema markup, canonical discipline, and content structure that enables accurate AI comprehension and citation.</p>
            <a href="/services/chatgpt-optimization/" class="btn">View Service Details</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">AI Overviews Optimization</h3>
            <p>GEO-16 framework implementation for Google AI Overviews visibility. Structured data depth, entity mapping, and content architecture aligned with Google's LLM training documentation.</p>
            <a href="/services/ai-overviews-optimization/" class="btn">View Service Details</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">AI Visibility Audit</h3>
            <p>Comprehensive analysis of citation patterns across ChatGPT, Claude, Perplexity, and Google AI Overviews. Prompt surface intelligence reveals actual conversational inputs that trigger visibility.</p>
            <a href="/services/site-audits/" class="btn">View Service Details</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">Semantic SEO for AI</h3>
            <p>Ontology-driven content structure and entity relationships optimized for AI engine comprehension. Semantic markup, knowledge graph integration, and entity disambiguation.</p>
            <a href="/services/semantic-seo-ai/" class="btn">View Service Details</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">LLM Citation Readiness</h3>
            <p>Content architecture and structured data implementation that increases citation likelihood in LLM responses. Entity clarity, source attribution signals, and citation-friendly markup.</p>
            <a href="/services/llm-seeding/" class="btn">View Service Details</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">Local AI SEO</h3>
            <p>LocalBusiness schema implementation, geographic entity mapping, and location-anchored content structure for AI-powered local search discovery.</p>
            <a href="/services/local-seo-ai/" class="btn">View Service Details</a>
          </div>
        </div>
        <div style="text-align: center; margin-top: 2rem;">
          <a href="/services/" class="btn btn--primary">View All AI SEO Services</a>
        </div>
      </div>
    </div>

    <!-- Process: How We Do It (Simple Steps) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">AI Search Visibility Optimization Methodology</h2>
      </div>
      <div class="content-block__body">
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">1</div>
            <h3 style="margin-top: 0;">Baseline AI Visibility Analysis</h3>
            <p>Comprehensive testing across ChatGPT, Google AI Overviews, Claude, and Perplexity. Citation pattern analysis, prompt surface mapping, and visibility gap identification using deterministic testing methodologies.</p>
          </div>
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">2</div>
            <h3 style="margin-top: 0;">Prompt Surface Intelligence</h3>
            <p>Reverse-engineering of conversational inputs, AI rewrites, and semantic variants that trigger visibility. Identification of proto-prompts and query transformations that determine citation likelihood.</p>
          </div>
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">3</div>
            <h3 style="margin-top: 0;">Structured Data & Entity Optimization</h3>
            <p>Implementation of JSON-LD schema depth, entity clarity, and semantic structure aligned with LLM training patterns. GEO-16 framework application for AI engine comprehension and citation accuracy.</p>
          </div>
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">4</div>
            <h3 style="margin-top: 0;">Ongoing Visibility Monitoring</h3>
            <p>Continuous tracking of citation patterns, AI Overviews appearance rates, and prompt surface coverage. Performance metrics aligned with AI search behavior patterns and citation attribution signals.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Social Proof / Results -->
    <div class="content-block module" style="background: #f9f9f9; padding: 2rem; border-radius: 8px;">
      <div class="content-block__header">
        <h2 class="content-block__title">Why Businesses Choose AI SEO</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit" style="gap: 2rem; margin-top: 1rem;">
          <div>
            <h3 style="color: #2196F3; font-size: 2.5rem; margin: 0;">600+</h3>
            <p><strong>Impressions</strong> per month for top service pages in AI Overviews</p>
          </div>
          <div>
            <h3 style="color: #2196F3; font-size: 2.5rem; margin: 0;">836</h3>
            <p><strong>Service pages</strong> optimized for AI search across cities</p>
          </div>
          <div>
            <h3 style="color: #2196F3; font-size: 2.5rem; margin: 0;">100%</h3>
            <p><strong>Complete</strong> content sections on all service pages</p>
          </div>
        </div>
        <p style="margin-top: 2rem;">
          <strong>Research Foundation:</strong> Our methodology is based on analysis of Google's LLMs.txt documentation, reverse-engineering of AI citation patterns, and deterministic testing across multiple AI search platforms. The GEO-16 framework provides a systematic approach to AI visibility optimization.
        </p>
      </div>
    </div>

    <!-- Research & Insights -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Latest AI SEO Research & Insights</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">
          Research and analysis on Google AI Overviews behavior, ChatGPT citation patterns, LLM training documentation, and structured data implementation strategies based on reverse-engineering of AI search systems.
        </p>
        <?php if (!empty($latest_insights)): ?>
        <div class="grid grid-auto-fit" style="margin-top: 2rem; gap: 1.5rem;">
          <?php foreach (array_reverse($latest_insights) as $insight): ?>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">
              <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/">
                <?= htmlspecialchars($insight['title']) ?>
              </a>
            </h3>
            <p><?= htmlspecialchars(substr($insight['keywords'] ?? '', 0, 120)) ?>...</p>
            <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn" title="Read full article: <?= htmlspecialchars($insight['title']) ?>" aria-label="Read full article: <?= htmlspecialchars($insight['title']) ?>">Read Article</a>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div style="text-align: center; margin-top: 2rem;">
          <a href="/insights/" class="btn" title="View all research articles and insights on semantic infrastructure and AI SEO" aria-label="View all research articles and insights">View All Research & Insights</a>
        </div>
      </div>
    </div>

    <!-- Final CTA -->
    <div class="content-block module" style="background: linear-gradient(135deg, #0B1220 0%, #1a1f3a 100%); padding: 3rem; border-radius: 8px; text-align: center;">
      <div class="content-block__header">
        <h2 class="content-block__title" style="color: #fff; margin-bottom: 1rem;">
          AI Visibility Analysis & Optimization Services
        </h2>
      </div>
      <div class="content-block__body" style="color: #e0e0e0;">
        <p class="lead" style="color: #fff; font-size: 1.25rem; margin-bottom: 2rem;">
          Request an AI visibility analysis based on prompt surface intelligence and citation pattern mapping. Receive actionable insights into your current AI search visibility across ChatGPT, Google AI Overviews, Claude, and Perplexity.
        </p>
        <div class="btn-group" style="justify-content: center;">
          <button type="button" class="btn btn--primary" style="font-size: 1.1rem; padding: 1rem 2rem; background: #fff; color: #0B1220;" onclick="openContactSheet('AI SEO Consultation')">
            Request Visibility Analysis
          </button>
          <a href="tel:+12135628438" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem; background: rgba(255,255,255,0.1); color: #fff;">
            Call: +1-213-562-8438
          </a>
        </div>
        <p style="margin-top: 2rem; font-size: 0.9rem; opacity: 0.8; color: #fff !important;">
          Analysis includes prompt surface mapping, citation pattern identification, and structured data gap assessment.
        </p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// JSON-LD for SEO
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "NRLC.ai - AI SEO Services",
  "url": "https://nrlc.ai",
  "description": "AI SEO services to get your business found in ChatGPT, Google AI Overviews, and Claude. See what prompts your website surfaces for and optimize for AI search.",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://nrlc.ai/?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "NRLC.ai",
  "url": "https://nrlc.ai",
          "description": "AI SEO services based on GEO-16 framework research. ChatGPT optimization, Google AI Overviews visibility, and LLM citation pattern analysis.",
  "logo": "https://nrlc.ai/assets/images/nrlcai logo 0.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "Sales",
    "telephone": "+1-213-562-8438",
    "email": "hirejoelm@gmail.com"
  },
  "sameAs": [
    "https://nrlcmd.com",
    "https://neuralcommandllc.com"
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "AI SEO Services",
  "description": "Get your business found in ChatGPT, Google AI Overviews, Claude, and Perplexity. AI SEO optimization services for businesses of all sizes.",
  "provider": {
    "@type": "Organization",
    "name": "NRLC.ai",
    "url": "https://nrlc.ai"
  },
  "serviceType": "AI SEO Optimization",
  "areaServed": "Global",
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "AI SEO Services",
    "itemListElement": [
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "ChatGPT Optimization",
          "description": "Get your business cited when people ask ChatGPT questions about your industry or services."
        }
      },
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "AI Overviews Optimization",
          "description": "Appear in Google's AI Overviews when people search for what you offer."
        }
      },
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "AI Visibility Audit",
          "description": "See exactly where you appear in ChatGPT, Claude, Perplexity, and Google AI Overviews."
        }
      }
    ]
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is AI SEO?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "AI SEO optimizes your website to appear in AI-powered search results like ChatGPT, Google AI Overviews, Claude, and Perplexity. Unlike traditional SEO that focuses on keyword rankings, AI SEO ensures AI engines understand and cite your business when people ask questions."
      }
    },
    {
      "@type": "Question",
      "name": "How do I know if my business appears in ChatGPT?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We provide AI visibility audits that test your website across ChatGPT, Google AI Overviews, Claude, and Perplexity. We show you exactly what prompts and questions your site surfaces for, or if it doesn't appear at all."
      }
    },
    {
      "@type": "Question",
      "name": "What's the difference between traditional SEO and AI SEO?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Traditional SEO optimizes for keyword rankings in Google search results. AI SEO optimizes for AI comprehension, ensuring your business appears when people ask AI assistants like ChatGPT questions about your industry, services, or location."
      }
    },
    {
      "@type": "Question",
      "name": "How long does it take to see results from AI SEO?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "AI SEO results can appear faster than traditional SEO because AI engines continuously crawl and update their knowledge. Many businesses see improvements in AI visibility within 2-4 weeks of optimization."
      }
    }
  ]
}
</script>

