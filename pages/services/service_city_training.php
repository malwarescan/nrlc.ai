<?php
/**
 * TRAINING SERVICE-CITY PAGE (Special Template)
 * 
 * Training is education (skill transfer), not a service (done-for-you execution).
 * This template uses Course schema, not Service schema.
 * Content focuses on what teams will learn, not what we'll do for them.
 */

declare(strict_types=1);
require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/service_enhancements.php';
require_once __DIR__.'/../../lib/gbp_config.php';

$serviceSlug = $_GET['service'] ?? 'training';
$citySlug = $_GET['city'] ?? 'cardiff';
$pathKey = "/services/$serviceSlug/$citySlug/";

$cityTitle = titleCaseCity($citySlug);
$isUK = function_exists('is_uk_city') && is_uk_city($citySlug);

// Get locale
$currentLocale = $GLOBALS['locale'] ?? 'en-us';
$localePrefix = ($currentLocale === 'en-us') ? '' : '/' . $currentLocale;
$canonical_url = absolute_url($localePrefix . $pathKey);

// Set page metadata - SEO-OPTIMIZED
$GLOBALS['__page_slug'] = 'services/service_city_training';
$trainingKeywords = "AI SEO training, SEO training {$cityTitle}, AI search optimization training, ChatGPT optimization training, Claude optimization training, Google AI Overviews training, LLM citation training, structured data training, entity optimization training, technical SEO training";
$GLOBALS['__page_meta'] = [
  'title' => "AI SEO Training Courses in {$cityTitle} | Neural Command Training",
  'description' => "Professional AI SEO training courses for teams in {$cityTitle}. Learn how to optimize for ChatGPT, Claude, Google AI Overviews, and LLM citation systems. Hands-on training in structured data, entity optimization, and AI search visibility.",
  'keywords' => $trainingKeywords,
  'canonicalPath' => $pathKey
];

// Load city data
$citiesData = csv_read_data('cities.csv');
$cityRow = null;
foreach ($citiesData as $c) {
  if (($c['city_name'] ?? '') === $citySlug) {
    $cityRow = $c;
    break;
  }
}
if (!$cityRow) {
  $cityRow = ['city_name' => $cityTitle, 'country' => $isUK ? 'GB' : 'US', 'subdivision' => ''];
}
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Hero: Training Positioning -->
    <div class="content-block module" itemscope itemtype="https://schema.org/Course">
      <div class="content-block__header">
        <h1 class="content-block__title" itemprop="name">AI SEO Training Courses for Teams in <?= htmlspecialchars($cityTitle) ?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead" itemprop="description">Professional training courses for marketing and SEO teams in <?= htmlspecialchars($cityTitle) ?> who need to understand how AI search systems work, how LLMs ingest content, and how to optimize for generative engines like ChatGPT, Claude, and Google AI Overviews.</p>
        <p><strong>Definition:</strong> AI SEO training is skill transfer for teams who need to operate AI-driven search optimization systems. This is operational training, not beginner education.</p>
        <p>We train teams to understand, supervise, and govern AI agents operating inside Model Context Protocols (MCPs), and to produce content that AI search systems can reliably extract, ground, and cite without destabilizing production SEO.</p>
        <?php if ($isUK): ?>
        <p>We've worked with businesses across <?= htmlspecialchars($cityTitle) ?> and <?= $cityRow['subdivision'] ?? 'the UK' ?> to deliver training that enables teams to execute AI-first SEO strategies effectively.</p>
        <?php endif; ?>
        <div class="btn-group text-center">
          <a href="/training/one-on-one/" class="btn btn--primary">View Training Courses</a>
          <a href="/training/" class="btn">All Training Programs</a>
        </div>
        <p class="text-center small muted">No obligation. Response within 24 hours.</p>
      </div>
    </div>

    <!-- What This Training Covers -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What You'll Learn in This Training</h2>
      </div>
      <div class="content-block__body">
        <p>This training covers three core areas that determine AI search visibility:</p>
        
        <div class="grid grid-auto-fit">
          <div class="box-padding">
            <h3 class="heading-3">Agent Operation & Supervision</h3>
            <p>Teams learn to:</p>
            <ul>
              <li>Understand how SEO agents reason and act within Model Context Protocols</li>
              <li>Interpret agent decisions through MCP constraints</li>
              <li>Approve, block, or roll back agent actions safely</li>
              <li>Distinguish between advisory signals and executable actions</li>
              <li>Avoid unbounded or heuristic-driven automation</li>
            </ul>
            <p><strong>Outcome:</strong> Teams can supervise AI-driven SEO systems without breaking production search infrastructure.</p>
          </div>

          <div class="box-padding">
            <h3 class="heading-3">AI Search Surfaces & Retrieval Mechanics</h3>
            <p><strong>We do not teach "writing for AI". We teach how AI search systems consume information.</strong></p>
            <p>Teams learn how systems like ChatGPT, Claude, Perplexity, and Google AI Overviews:</p>
            <ul>
              <li>Ingest structured and unstructured data</li>
              <li>Allocate grounding budgets</li>
              <li>Chunk, truncate, and prioritize content</li>
              <li>Resolve entities and citations</li>
              <li>Select sources under uncertainty</li>
            </ul>
            <p><strong>Outcome:</strong> Teams can design content and structure that is extractable, grounded, and stable across AI search surfaces.</p>
          </div>

          <div class="box-padding">
            <h3 class="heading-3">Content as Machine-Interpretable Information</h3>
            <p>Content teams learn to produce:</p>
            <ul>
              <li>High-signal, low-ambiguity information</li>
              <li>Content compatible with schema and entity models</li>
              <li>Formats that survive summarization and citation</li>
              <li>Information that agents and LLMs can reason about without hallucination</li>
            </ul>
            <p><strong>Outcome:</strong> Teams produce content optimized for retrievability and correctness, not volume or narrative polish.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Who This Training Is For -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Who Should Attend This Training</h2>
      </div>
      <div class="content-block__body">
        <p>This training is designed for teams in <?= htmlspecialchars($cityTitle) ?> who operate production SEO systems:</p>
        <ul>
          <li><strong>Heads of SEO</strong> - Need to understand AI search mechanics to make strategic decisions</li>
          <li><strong>Technical SEOs</strong> - Must implement structured data and entity optimization correctly</li>
          <li><strong>Founders running production systems</strong> - Need to prevent AI-induced SEO regressions</li>
          <li><strong>Engineering teams interfacing with search</strong> - Must understand how AI agents interact with search infrastructure</li>
          <li><strong>Content leads working inside AI-driven workflows</strong> - Need to produce extractable, citation-ready content</li>
        </ul>
        <p><strong>Prerequisites:</strong> This is not beginner education. Teams should have experience with production SEO systems, structured data implementation, or content optimization. If your site is already large, visible, or revenue-critical, this training is preventative infrastructure.</p>
      </div>
    </div>

    <!-- Training Format & Delivery -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Training Format & Delivery</h2>
      </div>
      <div class="content-block__body">
        <p>Training is delivered through multiple formats to accommodate different team needs:</p>
        
        <div class="grid grid-auto-fit">
          <div class="box-padding">
            <h3 class="heading-3">One-on-One Operator Training</h3>
            <p>Intensive, hands-on training for individual operators who need deep understanding of AI search systems, agent supervision, and MCP governance. Focused on operational decision-making and system safety.</p>
            <p><strong>Duration:</strong> Customizable, typically 8-16 hours over 2-4 sessions</p>
            <p><strong>Format:</strong> Online, screen-share sessions with live system interaction</p>
            <p><a href="/training/one-on-one/" class="btn btn--secondary">Learn More About One-on-One Training</a></p>
          </div>

          <div class="box-padding">
            <h3 class="heading-3">Team & Group Sessions</h3>
            <p>Group training sessions for entire teams who need coordinated understanding of AI search optimization. Covers agent supervision protocols, content standards, and schema governance at scale.</p>
            <p><strong>Duration:</strong> Typically 4-8 hours, can be split across multiple days</p>
            <p><strong>Format:</strong> Online or in-person (available in <?= htmlspecialchars($cityTitle) ?> and major cities)</p>
            <p><em>Team sessions coming soon. Contact us for availability.</em></p>
          </div>

          <div class="box-padding">
            <h3 class="heading-3">Workshops & Documentation</h3>
            <p>Focused workshops on specific topics: schema governance, entity optimization, AI citation mechanics, or Search Console telemetry interpretation. Includes documentation and reference materials.</p>
            <p><strong>Duration:</strong> 2-4 hours per workshop</p>
            <p><strong>Format:</strong> Online, interactive workshops with Q&A</p>
          </div>
        </div>
      </div>
    </div>

    <!-- What We Teach / What We Don't -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What We Teach / What We Don't</h2>
      </div>
      <div class="content-block__body">
        <div class="grid grid-auto-fit">
          <div class="box-padding">
            <h3 class="heading-3">We Teach</h3>
            <ul>
              <li>MCP literacy and governance</li>
              <li>Agent supervision and safety boundaries</li>
              <li>Schema as a control layer, not markup</li>
              <li>AI retrieval and grounding mechanics</li>
              <li>Content standards for AI extraction</li>
              <li>How to read Search Console as telemetry</li>
              <li>How to avoid AI-induced SEO regressions</li>
              <li>Entity optimization for AI search systems</li>
              <li>Structured data governance at scale</li>
            </ul>
          </div>
          <div class="box-padding">
            <h3 class="heading-3">We Do Not Teach</h3>
            <ul>
              <li>Prompt engineering for bloggers</li>
              <li>AI writing tricks or shortcuts</li>
              <li>Keyword hacks for LLMs</li>
              <li>"Rank in AI Overviews" shortcuts</li>
              <li>Generic SEO fundamentals</li>
              <li>Content automation without constraints</li>
              <li>Growth hacks or quick wins</li>
            </ul>
          </div>
        </div>
        <div class="box-padding" style="margin-top: var(--spacing-lg); padding: 1rem; border-left: 4px solid #d4a574; background: #fff8f0;">
          <p><strong>If someone is looking for growth hacks or AI copywriting shortcuts, this training is not a fit.</strong> This training exists to reduce risk and enable safe operation of AI-driven SEO systems.</p>
        </div>
      </div>
    </div>

    <!-- Why Training Matters for <?= htmlspecialchars($cityTitle) ?> Teams -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why This Training Matters for <?= htmlspecialchars($cityTitle) ?> Teams</h2>
      </div>
      <div class="content-block__body">
        <?php if ($isUK): ?>
        <p>Teams in <?= htmlspecialchars($cityTitle) ?> face unique challenges: GDPR compliance requirements, European market penetration needs, and UK-specific search behaviors that differ from US markets. AI search systems like ChatGPT, Claude, and Google AI Overviews evaluate content differently based on geographic signals, entity clarity, and structured data completeness.</p>
        <p>This training ensures <?= htmlspecialchars($cityTitle) ?> teams understand how to optimize for both traditional search and AI engines while maintaining compliance and addressing regional search behavior patterns.</p>
        <?php else: ?>
        <p>Teams in <?= htmlspecialchars($cityTitle) ?> operate in competitive markets where AI search visibility determines whether businesses get cited or ignored. Traditional SEO training doesn't cover how AI systems extract, score, and cite content segments.</p>
        <p>This training provides <?= htmlspecialchars($cityTitle) ?> teams with the operational knowledge needed to optimize for ChatGPT, Claude, Perplexity, and Google AI Overviews while maintaining stable traditional search performance.</p>
        <?php endif; ?>
        
        <div class="box-padding">
          <h3 class="heading-3">Local Market Context</h3>
          <p>Training content is contextualized for <?= htmlspecialchars($cityTitle) ?> market dynamics, including local business competition patterns, regional AI engine behavior differences, and city-specific search intent patterns. This ensures teams can apply training concepts directly to their <?= htmlspecialchars($cityTitle) ?>-based operations.</p>
        </div>
      </div>
    </div>

    <!-- Pricing -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Training Pricing for <?= htmlspecialchars($cityTitle) ?> Teams</h2>
      </div>
      <div class="content-block__body">
        <div class="box-padding">
          <p>Training pricing varies based on format, duration, and team size:</p>
          <ul>
            <li><strong>One-on-One Operator Training:</strong> <?= $isUK ? '£2,500 to £8,000' : '$3,500 to $10,000' ?> depending on scope and duration</li>
            <li><strong>Team & Group Sessions:</strong> <?= $isUK ? '£5,000 to £15,000' : '$7,000 to $20,000' ?> for teams of 5-15 people</li>
            <li><strong>Workshops:</strong> <?= $isUK ? '£1,500 to £3,500' : '$2,000 to $5,000' ?> per workshop</li>
          </ul>
          <p>Pricing includes all training materials, documentation, and follow-up support. We provide detailed proposals with clear curriculum, learning objectives, and expected outcomes before engagement begins.</p>
          <p><strong>Contact us for a customized training proposal for your <?= htmlspecialchars($cityTitle) ?> team.</strong></p>
        </div>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Frequently Asked Questions</h2>
      </div>
      <div class="content-block__body">
        <?php
        // Use the same FAQ structure as other service pages
        $faqsHtml = city_specific_faq_block('training', $citySlug, 7);
        if (!empty($faqsHtml)) {
          echo $faqsHtml;
        } else {
          // Fallback FAQ structure if no FAQs found
          ?>
          <div class="grid">
            <details class="card">
              <summary><strong>What is AI SEO training?</strong></summary>
              <p class="small muted">AI SEO training is skill transfer for teams who need to understand and operate AI-driven search optimization systems. This includes learning how AI search engines like ChatGPT, Claude, and Google AI Overviews extract, score, and cite content, as well as how to supervise AI agents, implement structured data governance, and produce content optimized for AI retrieval.</p>
            </details>

            <details class="card">
              <summary><strong>Who should attend this training?</strong></summary>
              <p class="small muted">This training is designed for Heads of SEO, Technical SEOs, founders running production systems, engineering teams interfacing with search, and content leads working inside AI-driven workflows. This is operational training, not beginner education. Teams should have experience with production SEO systems.</p>
            </details>

            <details class="card">
              <summary><strong>What training formats are available?</strong></summary>
              <p class="small muted">We offer one-on-one operator training (8-16 hours, customizable), team and group sessions (4-8 hours, for 5-15 people), and focused workshops (2-4 hours per topic). Training can be delivered online or in-person in <?= htmlspecialchars($cityTitle) ?> and major cities.</p>
            </details>

            <details class="card">
              <summary><strong>What will teams learn in this training?</strong></summary>
              <p class="small muted">Teams learn three core areas: (1) Agent operation and supervision within Model Context Protocols, (2) How AI search systems consume information and make citation decisions, and (3) How to produce content that is extractable, grounded, and stable across AI search surfaces. The goal is operational safety and system reliability, not growth hacks.</p>
            </details>

            <details class="card">
              <summary><strong>How is this training different from traditional SEO training?</strong></summary>
              <p class="small muted">Traditional SEO training focuses on keyword optimization, backlinks, and page-level rankings. This training focuses on how AI systems extract content segments, allocate grounding budgets, resolve entities, and make citation decisions. It covers agent supervision, schema governance, and content standards for AI extraction—topics not covered in traditional SEO training.</p>
            </details>

            <details class="card">
              <summary><strong>What are the prerequisites for this training?</strong></summary>
              <p class="small muted">Teams should have experience with production SEO systems, structured data implementation, or content optimization. This is not beginner education. If your site is already large, visible, or revenue-critical, this training is preventative infrastructure to reduce risk and enable safe operation of AI-driven SEO systems.</p>
            </details>

            <details class="card">
              <summary><strong>How long does it take to see results after training?</strong></summary>
              <p class="small muted">Training provides immediate knowledge transfer. Teams can begin applying concepts during training sessions. Implementation of learned concepts typically shows measurable improvements in AI engine citation accuracy, structured data performance, and Search Console stability within 2-4 weeks of applying training concepts to production systems.</p>
            </details>
          </div>
          <?php
        }
        ?>
      </div>
    </div>

    <!-- Related Resources -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Training & Resources</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li><a href="/training/">All Training Programs</a></li>
          <li><a href="/training/one-on-one/">One-on-One Operator Training</a></li>
          <li><a href="/insights/">Research & Insights</a></li>
          <li><a href="/insights/ai-retrieval-llm-citation/">How LLMs Retrieve and Cite Web Content</a></li>
          <li><a href="/insights/prechunking-content-ai-retrieval/">Prechunking Content for AI Retrieval</a></li>
        </ul>
      </div>
    </div>

    <!-- Final CTA -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Ready to Train Your Team in <?= htmlspecialchars($cityTitle) ?>?</h2>
      </div>
      <div class="content-block__body">
        <p class="lead">Get started with AI SEO training for your <?= htmlspecialchars($cityTitle) ?> team today. Our training programs deliver operational knowledge that enables safe, effective optimization for ChatGPT, Claude, Perplexity, and Google AI Overviews.</p>
        <div class="btn-group text-center">
          <a href="/training/one-on-one/" class="btn btn--primary">View Training Courses</a>
          <button type="button" class="btn" onclick="openContactSheet('Training Inquiry for <?= htmlspecialchars($cityTitle) ?>')">Contact About Training</button>
        </div>
        <p class="text-center small muted">No obligation. Response within 24 hours.</p>
      </div>
    </div>

  </div>
</section>
</main>

<?php
// CRITICAL: Use Course schema, NOT Service schema for training
require_once __DIR__.'/../../lib/SchemaFixes.php';
use NRLC\Schema\SchemaFixes;
$orgId = SchemaFixes::ensureHttps(gbp_website()) . '#organization';

// Build comprehensive schema for SEO and extractability
$GLOBALS['__jsonld'] = [
  // 1. Course Schema (PRIMARY - Training is education, not service)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Course',
    '@id' => $canonical_url . '#course',
    'name' => "AI SEO Training Courses for Teams in {$cityTitle}",
    'description' => "Professional training courses for marketing and SEO teams in {$cityTitle} who need to understand how AI search systems work, how LLMs ingest content, and how to optimize for generative engines like ChatGPT, Claude, and Google AI Overviews.",
    'provider' => [
      '@type' => 'Organization',
      '@id' => $orgId,
      'name' => 'Neural Command',
      'url' => 'https://nrlc.ai'
    ],
    'teaches' => [
      'Agent operation and supervision within Model Context Protocols',
      'AI search system retrieval and citation mechanics',
      'Content optimization for AI extraction',
      'Structured data governance at scale',
      'Entity optimization for AI search systems',
      'Schema as a control layer',
      'Search Console telemetry interpretation',
      'How to avoid AI-induced SEO regressions'
    ],
    'courseCode' => 'AI-SEO-TRAINING',
    'educationalLevel' => 'Professional',
    'learningResourceType' => 'Training Course',
    'timeRequired' => 'PT8H', // 8 hours minimum
    'inLanguage' => 'en-US',
    'availableLanguage' => ['en-US', 'en-GB'],
    'audience' => [
      '@type' => 'EducationalAudience',
      'educationalRole' => 'Professional',
      'audienceType' => 'Heads of SEO, Technical SEOs, Engineering Teams, Content Leads'
    ],
    'offers' => [
      '@type' => 'Offer',
      'priceCurrency' => $isUK ? 'GBP' : 'USD',
      'price' => $isUK ? '2500' : '3500',
      'priceSpecification' => [
        '@type' => 'UnitPriceSpecification',
        'price' => $isUK ? '2500' : '3500',
        'priceCurrency' => $isUK ? 'GBP' : 'USD',
        'valueAddedTaxIncluded' => true
      ],
      'availability' => 'https://schema.org/InStock',
      'url' => $canonical_url
    ],
    'areaServed' => [
      '@type' => 'City',
      'name' => $cityTitle
    ]
  ],

  // 2. WebPage Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonical_url . '#webpage',
    'name' => "AI SEO Training Courses in {$cityTitle} | Neural Command Training",
    'url' => $canonical_url,
    'description' => "Professional AI SEO training courses for teams in {$cityTitle}. Learn how to optimize for ChatGPT, Claude, Google AI Overviews, and LLM citation systems.",
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => 'https://nrlc.ai/#website',
      'name' => 'NRLC.ai',
      'url' => 'https://nrlc.ai'
    ],
    'about' => [
      '@id' => $canonical_url . '#course'
    ],
    'primaryImageOfPage' => [
      '@type' => 'ImageObject',
      'url' => 'https://nrlc.ai/assets/images/nrlc-logo.png'
    ],
    'inLanguage' => 'en-US',
    'datePublished' => '2024-01-01',
    'dateModified' => date('Y-m-d')
  ],

  // 3. BreadcrumbList
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonical_url . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => 'https://nrlc.ai/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Training',
        'item' => 'https://nrlc.ai/training/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => "Training in {$cityTitle}",
        'item' => $canonical_url
      ]
    ]
  ],

  // 4. FAQPage Schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonical_url . '#faq',
    'mainEntity' => [
      [
        '@type' => 'Question',
        'name' => 'What is AI SEO training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'AI SEO training is skill transfer for teams who need to understand and operate AI-driven search optimization systems. This includes learning how AI search engines like ChatGPT, Claude, and Google AI Overviews extract, score, and cite content, as well as how to supervise AI agents, implement structured data governance, and produce content optimized for AI retrieval.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'Who should attend this training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'This training is designed for Heads of SEO, Technical SEOs, founders running production systems, engineering teams interfacing with search, and content leads working inside AI-driven workflows. This is operational training, not beginner education. Teams should have experience with production SEO systems.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What training formats are available?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'We offer one-on-one operator training (8-16 hours, customizable), team and group sessions (4-8 hours, for 5-15 people), and focused workshops (2-4 hours per topic). Training can be delivered online or in-person in ' . $cityTitle . ' and major cities.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What will teams learn in this training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Teams learn three core areas: (1) Agent operation and supervision within Model Context Protocols, (2) How AI search systems consume information and make citation decisions, and (3) How to produce content that is extractable, grounded, and stable across AI search surfaces. The goal is operational safety and system reliability, not growth hacks.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'How is this training different from traditional SEO training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Traditional SEO training focuses on keyword optimization, backlinks, and page-level rankings. This training focuses on how AI systems extract content segments, allocate grounding budgets, resolve entities, and make citation decisions. It covers agent supervision, schema governance, and content standards for AI extraction—topics not covered in traditional SEO training.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'What are the prerequisites for this training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Teams should have experience with production SEO systems, structured data implementation, or content optimization. This is not beginner education. If your site is already large, visible, or revenue-critical, this training is preventative infrastructure to reduce risk and enable safe operation of AI-driven SEO systems.'
        ]
      ],
      [
        '@type' => 'Question',
        'name' => 'How long does it take to see results after training?',
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => 'Training provides immediate knowledge transfer. Teams can begin applying concepts during training sessions. Implementation of learned concepts typically shows measurable improvements in AI engine citation accuracy, structured data performance, and Search Console stability within 2-4 weeks of applying training concepts to production systems.'
        ]
      ]
    ]
  ],

  // 5. Organization Schema (reference)
  [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => $orgId,
    'name' => 'Neural Command',
    'url' => 'https://nrlc.ai',
    'knowsAbout' => [
      'AI SEO Training',
      'AI Search Optimization',
      'LLM Citation Systems',
      'Structured Data Governance',
      'Entity Optimization',
      'Model Context Protocols',
      'Agent Supervision'
    ]
  ]
];
?>
