<?php
/**
 * AI Visibility for High-End Contractors
 * Prechunking SEO methodology applied to repairs and renovations information engineering
 */

require_once __DIR__ . '/../../lib/schema_builders.php';

// Use canonical path from router metadata (includes locale prefix)
$canonicalPath = $GLOBALS['__page_meta']['canonicalPath'] ?? '/en-us/ai-visibility/contractor/';
$canonicalUrl = absolute_url($canonicalPath);
$domain = absolute_url('/');

// Build JSON-LD Schema
$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => 'AI Visibility for Contractors',
    'description' => 'When homeowners ask ChatGPT who the best contractor is near them, we help make sure your business shows up. Get more calls and more jobs from AI recommendations.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ],
    'breadcrumb' => [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Visibility', 'item' => absolute_url('/ai-visibility/')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'High-End Contractors', 'item' => $canonicalUrl]
      ]
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    '@id' => $canonicalUrl . '#service',
    'name' => 'AI Visibility for Contractors',
    'serviceType' => 'AI Search Optimization',
    'description' => 'Help contractors show up when people ask ChatGPT or Google AI who to hire. We structure your business information so AI systems trust and mention your company.',
    'provider' => ['@type' => 'Organization', '@id' => $domain . '#organization', 'name' => 'Neural Command LLC', 'url' => $domain],
    'url' => $canonicalUrl
  ]
];
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">

    <!-- H1 and Lead Paragraph -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">AI Visibility for Contractors</h1>
      </div>
      <div class="content-block__body">
        <p class="lead">When homeowners ask ChatGPT or Google AI questions like "Who's the best contractor near me?" or "Who installs siding in my area?", AI tools pull from trusted sources to recommend businesses. Our job is to make sure your contracting business is one of the names those AI systems trust and mention.</p>
        
        <p>This doesn't replace SEO or Google Maps. It adds a new channel where contractors are already being recommended — AI answers. We help construction and home-service companies show up more often when people ask AI who to hire.</p>
        
        <p>We do this by structuring your online presence so AI systems understand:</p>
        <ul>
          <li>what services you offer</li>
          <li>where you work</li>
          <li>what you're trusted for</li>
          <li>and why you're a legitimate contractor</li>
        </ul>
        <p>That's it. No tech yet.</p>
      </div>
    </div>

    <!-- What This Means for Contractors -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Means for Contractors</h2>
      </div>
      <div class="content-block__body">
        <p>Here's what this service does for your business:</p>
        <ul>
          <li>Your business is more likely to be mentioned when people ask ChatGPT for contractor recommendations</li>
          <li>AI answers correctly understand your service areas (not just your company name)</li>
          <li>Your services don't get confused with suppliers, DIY blogs, or directories</li>
          <li>You're positioned as a real, established contractor — not just another website</li>
        </ul>
        <p>This directly maps to getting more calls and more jobs.</p>
      </div>
    </div>

    <!-- Contractor-Specific Example -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How This Works: A Real Example</h2>
      </div>
      <div class="content-block__body">
        <p><strong>Example:</strong> A homeowner asks ChatGPT: "Who installs fiber cement siding in South Bend?"</p>
        
        <p>AI systems don't browse the web like people do. They pull from trusted structured sources. If your business data is unclear or incomplete, you're skipped — even if you rank on Google.</p>
        
        <p>Our work makes sure AI understands you as a legitimate siding contractor in that location. When someone asks that question, your business is one of the names AI considers and mentions.</p>
        
        <p>No numbers needed. Just clarity.</p>
      </div>
    </div>

    <!-- How AI Systems Answer Questions -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How AI Systems Answer Contractor Questions</h2>
      </div>
      <div class="content-block__body">
        <p>When people ask AI tools about contractors, the AI looks for clear, trustworthy information it can cite safely.</p>
        
        <p>Common questions homeowners ask AI include:</p>
        <ul>
          <li>"Is this repair necessary?"</li>
          <li>"How much should this cost?"</li>
          <li>"How do I find a trustworthy contractor?"</li>
          <li>"What questions should I ask a contractor?"</li>
          <li>"Who does [specific service] in [my city]?"</li>
        </ul>

        <p>To answer these questions reliably, AI systems look for:</p>
        <ul>
          <li>Clear cost explanations with transparency</li>
          <li>Factual explanations of repair processes and timelines</li>
          <li>Legitimate credential verification and licensing information</li>
          <li>Structured definitions of services, scopes, and limitations</li>
          <li>Consistent terminology and process clarity</li>
        </ul>

        <p>When contractor information is unclear, inconsistent, or hard to verify, AI systems either skip it or fill gaps with less accurate sources. This is why your business information needs to be structured clearly — so AI can find it, trust it, and mention it.</p>
      </div>
    </div>

    <!-- How We Structure Your Information -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How We Structure Your Business Information</h2>
      </div>
      <div class="content-block__body">
        <p>We organize your contractor business information so AI systems can find it, understand it, and trust it enough to mention your company.</p>

        <p>This means structuring your information into clear, factual units that AI can extract and cite safely. Each piece of information:</p>
        <ul>
          <li>Answers one question clearly (e.g., "What services do you offer?")</li>
          <li>Can be understood without surrounding context</li>
          <li>Remains accurate when AI extracts it</li>
          <li>Uses clear, consistent language</li>
          <li>Avoids vague or promotional claims</li>
        </ul>

        <p>This approach helps your business get mentioned more often because:</p>
        <ul>
          <li>Facts are clear and verifiable</li>
          <li>No guessing required — AI knows exactly what you do</li>
          <li>Information is structured for AI understanding, not just human reading</li>
          <li>Each fact can be cited safely without confusion</li>
        </ul>

        <p>We do this work at the publishing stage, before AI systems ever see your information. This ensures your business data is clear, trustworthy, and ready to be mentioned when people ask AI who to hire.</p>
      </div>
    </div>

    <!-- Building Trustworthy Business Information -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Building Trustworthy Business Information</h2>
      </div>
      <div class="content-block__body">
        <p>We create clear, factual information about your contracting business that AI systems can trust and cite.</p>

        <p>This is not manipulation or trickery. It's publishing truthful information about your business in a way that AI systems can understand and trust.</p>

        <p>AI systems only mention businesses they trust. Trust comes from:</p>
        <ul>
          <li>Consistency — your information appears the same way everywhere</li>
          <li>Clarity — no confusion about what you do or where you work</li>
          <li>Verification — your information matches what's found elsewhere</li>
          <li>Accuracy — factual statements, not promotional claims</li>
        </ul>

        <p>We structure your contractor business information so it:</p>
        <ul>
          <li>Defines your services clearly with specific scope and limitations</li>
          <li>Explains your processes in plain, factual language</li>
          <li>Clarifies your service areas, timelines, and requirements</li>
          <li>Removes confusion about what you do and don't do</li>
          <li>Uses consistent terminology across all your online presence</li>
        </ul>

        <p>This approach works because it tells the truth clearly — no manipulation, just clarity.</p>
      </div>
    </div>

    <!-- Understanding What Homeowners Actually Ask -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Understanding What Homeowners Actually Ask</h2>
      </div>
      <div class="content-block__body">
        <p>We study what questions homeowners ask AI tools and make sure your business information answers those questions clearly.</p>

        <p>This process involves analyzing:</p>
        <ul>
          <li>Real questions people ask about finding contractors</li>
          <li>How AI tools answer those questions and which businesses they mention</li>
          <li>What information is missing that causes AI to give generic or incomplete answers</li>
          <li>What makes AI systems trust a business enough to mention it</li>
        </ul>

        <p>We identify the questions that matter:</p>
        <ul>
          <li>Primary questions (e.g., "Is this repair necessary?" or "How much should this cost?")</li>
          <li>Follow-up questions (e.g., "How do I find a trustworthy contractor?" or "What questions should I ask?")</li>
          <li>Trust questions (e.g., "How do I know this is legitimate?" or "What are the limitations?")</li>
        </ul>

        <p>We make sure your business information answers these questions before homeowners even ask. This means publishing clear, factual information that answers not just the main question, but also the follow-up questions homeowners actually ask.</p>

        <p>This isn't gaming the system. It's identifying what information homeowners need, then making sure your business provides it clearly so AI can find it and mention your company.</p>
      </div>
    </div>

    <!-- What This Looks Like in Practice -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Looks Like in Practice</h2>
      </div>
      <div class="content-block__body">
        <p>Structuring your contractor business information produces clear, factual content that answers homeowner questions accurately.</p>

        <p>Examples of how we structure your business information:</p>
        <ul>
          <li><strong>Clear service definitions:</strong> Each service you offer is defined with specific scope, typical costs, and limitations. No vague descriptions or implied capabilities.</li>
          <li><strong>Explicit process explanations:</strong> Your repair and installation processes are explained in plain language with realistic timelines and scope boundaries. No guarantees or promotional claims.</li>
          <li><strong>Transparent costs and credentials:</strong> Your pricing and licensing information is stated clearly with specific explanations. No ambiguous claims or unclear verification.</li>
          <li><strong>Clear service areas and availability:</strong> Your service areas, availability, and project scope are stated explicitly. No implied coverage or confusing boundaries.</li>
          <li><strong>Consistent terminology:</strong> Trade terms, service names, and process descriptions use the same language everywhere. No confusion from different names for the same thing.</li>
        </ul>

        <p>This structured approach ensures your contracting business is represented accurately and safely when AI systems retrieve and cite information about your company.</p>
      </div>
    </div>

    <!-- What This Does and Does Not Do -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What This Does and Does Not Do</h2>
      </div>
      <div class="content-block__body">
        <p><strong>This service does:</strong></p>
        <ul>
          <li>Help your business show up more often when people ask AI who to hire</li>
          <li>Reduce confusion by ensuring your business information is clear and verifiable</li>
          <li>Increase accurate mentions by removing ambiguity about what you do</li>
          <li>Structure your information so AI systems can find it, understand it, and mention it safely</li>
        </ul>

        <p><strong>This service does not:</strong></p>
        <ul>
          <li>Guarantee your business will be mentioned in every AI answer</li>
          <li>Control what AI systems say or force specific recommendations</li>
          <li>Replace contractor licensing, professional judgment, or regulatory compliance</li>
          <li>Manipulate AI systems with hidden text or deceptive practices</li>
          <li>Promise specific rankings or traffic increases</li>
        </ul>

        <p>This service structures your business information so AI can find and mention it. It does not guarantee AI will mention your business every time, nor does it replace professional contractor standards or regulatory compliance.</p>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Resources</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><a href="/ai-visibility/">AI Visibility Services</a> - Overview of AI visibility optimization</li>
          <li><a href="/docs/prechunking-seo/">Prechunking SEO Documentation</a> - Technical documentation on the prechunking methodology</li>
          <li><a href="/services/site-audits/">Site Audits for AI & Search Visibility</a> - Diagnostic services for AI visibility issues</li>
        </ul>
      </div>
    </div>

  </div>
</section>
</main>