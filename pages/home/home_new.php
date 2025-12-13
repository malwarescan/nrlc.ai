<?php
// Set consumer-friendly metadata for homepage
$GLOBALS['pageTitle'] = 'Are You Showing Up When People Ask ChatGPT About Your Bus...';
$GLOBALS['pageDesc'] = 'Traditional SEO isn\'t enough anymore. When people ask ChatGPT, Google AI Overviews, or Claude about your industry, is your business the answer they get?';

require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
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
          Traditional SEO isn't enough anymore. When people ask ChatGPT, Google AI Overviews, or Claude about your industry, is your business the answer they get?
        </p>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; color: #fff;">
          We help businesses of all sizes get discovered in AI-powered search. See exactly what prompts your website surfaces for, then optimize to appear when it matters most.
        </p>
        <div class="btn-group" style="margin-top: 2rem;">
          <button type="button" class="btn btn--primary" style="font-size: 1.1rem; padding: 1rem 2rem;" onclick="openContactSheet('AI SEO Consultation')">
            Get Your Free AI Visibility Audit
          </button>
          <a href="#how-it-works" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem; background: rgba(255,255,255,0.1); color: #fff;">
            See How It Works
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
          Google AI Overviews and ChatGPT are rewriting how people find businesses. If you're not optimized for AI search, you're invisible to millions of potential customers.
        </p>
        <div class="grid grid-auto-fit" style="margin-top: 2rem; gap: 1.5rem;">
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="color: #d32f2f; margin-top: 0;">❌ Traditional SEO</h3>
            <ul>
              <li>Optimizes for keyword rankings</li>
              <li>Focuses on Google search results</li>
              <li>Doesn't account for AI rewrites</li>
              <li>Misses ChatGPT and AI Overviews</li>
            </ul>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #4caf50; border-radius: 8px; background: #f1f8f4;">
            <h3 style="color: #4caf50; margin-top: 0;">✅ AI SEO</h3>
            <ul>
              <li>Optimizes for AI comprehension</li>
              <li>Appears in ChatGPT answers</li>
              <li>Shows up in Google AI Overviews</li>
              <li>Gets cited by AI assistants</li>
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
          We analyze your site to reveal the exact conversational prompts, questions, and AI rewrites that determine whether you appear in ChatGPT, Google AI Overviews, Claude, and Perplexity.
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
            Get Your Prompt Surface Report
          </button>
          <a href="/products/prompt-surface-intelligence/" class="btn">Learn More About Prompt Surface Intelligence</a>
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
          We offer specialized services to make your business discoverable in AI-powered search, from ChatGPT to Google AI Overviews.
        </p>
        <div class="grid grid-auto-fit" style="margin-top: 2rem; gap: 1.5rem;">
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">🎯 ChatGPT Optimization</h3>
            <p>Get your business cited when people ask ChatGPT questions about your industry, services, or location.</p>
            <a href="/services/chatgpt-optimization/" class="btn" style="margin-top: 1rem;">Learn More →</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">🔍 AI Overviews Optimization</h3>
            <p>Appear in Google's AI Overviews when people search for what you offer. Get the top AI-generated answer.</p>
            <a href="/services/ai-overviews-optimization/" class="btn" style="margin-top: 1rem;">Learn More →</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">📊 AI Visibility Audit</h3>
            <p>See exactly where you appear (or don't) in ChatGPT, Claude, Perplexity, and Google AI Overviews.</p>
            <a href="/services/site-audits/" class="btn" style="margin-top: 1rem;">Get Started →</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">🚀 Semantic SEO for AI</h3>
            <p>Optimize your content structure so AI engines understand and cite your business accurately.</p>
            <a href="/services/semantic-seo-ai/" class="btn" style="margin-top: 1rem;">Learn More →</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">💬 LLM Citation Readiness</h3>
            <p>Make your content AI-friendly so ChatGPT, Claude, and other AI assistants cite you as a source.</p>
            <a href="/services/llm-seeding/" class="btn" style="margin-top: 1rem;">Learn More →</a>
          </div>
          <div style="padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: 8px;">
            <h3 style="margin-top: 0;">🌍 Local AI SEO</h3>
            <p>Get found when people ask AI assistants about businesses in your city or region.</p>
            <a href="/services/local-seo-ai/" class="btn" style="margin-top: 1rem;">Learn More →</a>
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
        <h2 class="content-block__title">How We Help You Get Found in AI Search</h2>
      </div>
      <div class="content-block__body">
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">1</div>
            <h3 style="margin-top: 0;">Analyze Your Current AI Visibility</h3>
            <p>We test your site across ChatGPT, Google AI Overviews, Claude, and Perplexity to see where you appear (and where you don't).</p>
          </div>
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">2</div>
            <h3 style="margin-top: 0;">Identify What Prompts You Surface For</h3>
            <p>We reveal the exact questions, prompts, and AI rewrites that determine your visibility in AI search.</p>
          </div>
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">3</div>
            <h3 style="margin-top: 0;">Optimize for AI Comprehension</h3>
            <p>We implement structured data, semantic markup, and AI-friendly content so AI engines understand and cite your business.</p>
          </div>
          <div>
            <div style="background: #2196F3; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">4</div>
            <h3 style="margin-top: 0;">Track Your AI Visibility Growth</h3>
            <p>We monitor your appearance in AI Overviews, ChatGPT citations, and other AI search results to measure success.</p>
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
        <p style="margin-top: 2rem; font-style: italic;">
          "Traditional SEO got us rankings. AI SEO gets us cited by ChatGPT and featured in Google AI Overviews. That's where our customers are asking questions now."
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
          Learn how AI search works and stay ahead of the curve with our research on Google AI Overviews, ChatGPT optimization, and LLM citation strategies.
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
            <a href="/insights/<?= htmlspecialchars($insight['slug']) ?>/" class="btn">Read Article →</a>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div style="text-align: center; margin-top: 2rem;">
          <a href="/insights/" class="btn">View All Research & Insights</a>
        </div>
      </div>
    </div>

    <!-- Final CTA -->
    <div class="content-block module" style="background: linear-gradient(135deg, #0B1220 0%, #1a1f3a 100%); padding: 3rem; border-radius: 8px; text-align: center;">
      <div class="content-block__header">
        <h2 class="content-block__title" style="color: #fff; margin-bottom: 1rem;">
          Ready to Get Found in ChatGPT & AI Overviews?
        </h2>
      </div>
      <div class="content-block__body" style="color: #e0e0e0;">
        <p class="lead" style="color: #fff; font-size: 1.25rem; margin-bottom: 2rem;">
          Get a free AI visibility audit and see exactly what prompts your website surfaces for in ChatGPT, Google AI Overviews, and other AI assistants.
        </p>
        <div class="btn-group" style="justify-content: center;">
          <button type="button" class="btn btn--primary" style="font-size: 1.1rem; padding: 1rem 2rem; background: #fff; color: #0B1220;" onclick="openContactSheet('AI SEO Consultation')">
            Get Your Free Audit
          </button>
          <a href="tel:+12135628438" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem; background: rgba(255,255,255,0.1); color: #fff;">
            Call: +1-213-562-8438
          </a>
        </div>
        <p style="margin-top: 2rem; font-size: 0.9rem; opacity: 0.8;">
          No commitment. No sales pitch. Just real insights into your AI search visibility.
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
  "description": "AI SEO services for businesses of all sizes. Get found in ChatGPT, Google AI Overviews, and AI-powered search.",
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

