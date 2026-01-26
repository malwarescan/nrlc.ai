<?php
/**
 * Specialized Page: AI Search Optimization - Miami
 * Optimized based on GSC data Jan 2026
 */

$serviceSlug = 'ai-search-optimization';
$citySlug = 'miami';
$cityTitle = 'Miami';
$serviceTitle = 'AI Search Optimization';

// Set metadata for head.php
$GLOBALS['__page_meta'] = [
    'title' => 'AI Search Optimization in Miami | Win AI Overviews + ChatGPT Citations',
    'description' => 'Technical + content + schema changes that increase citations in AI Overviews/ChatGPT. Local SERP analysis + fix list + 30-day plan.',
    'keywords' => 'AI Search Optimization Miami, AI SEO Miami, ChatGPT Citations, Google AI Overviews Optimization, Miami AI Search Marketing',
    'canonicalPath' => "/en-us/services/$serviceSlug/$citySlug/"
];

// Internal links
$sanJoseUrl = '/en-us/services/ai-search-optimization/san-jose/';
$atlantaUrl = '/en-us/services/generative-seo/atlanta/';
$insightsUrl = '/en-us/insights/';

// Build JSON-LD
require_once __DIR__ . '/../../../lib/person_entity.php';
require_once __DIR__ . '/../../../lib/helpers.php';

$canonical_url = absolute_url($GLOBALS['__page_meta']['canonicalPath']);
$orgId = absolute_url('/') . '#organization';

$GLOBALS['__jsonld'] = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        '@id' => $canonical_url . '#breadcrumb',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => absolute_url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => absolute_url('/services/')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $serviceTitle, 'item' => absolute_url("/services/$serviceSlug/")],
            ['@type' => 'ListItem', 'position' => 4, 'name' => $cityTitle, 'item' => $canonical_url]
        ]
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => $canonical_url . '#service',
        'name' => "$serviceTitle in $cityTitle",
        'serviceType' => $serviceTitle,
        'description' => $GLOBALS['__page_meta']['description'],
        'provider' => ['@type' => 'Organization', '@id' => $orgId],
        'areaServed' => [
            '@type' => 'City', 
            'name' => $cityTitle, 
            'containedInPlace' => ['@type' => 'State', 'name' => 'FL'],
            'sameAs' => 'https://www.wikidata.org/wiki/Q33'
        ],
        'url' => $canonical_url,
        'mainEntityOfPage' => $canonical_url
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        '@id' => $canonical_url . '#faq',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'Why are Miami businesses losing visibility to AI Overviews?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Miami is a high-growth market where many sites have strong domain authority but weak "Entity Clarity". AI engines prioritize sites that they can easily verify against local Miami data sources and directories. If your data is inconsistent, AI systems default to more "structured" competitors.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'How does the Miami-specific SERP snapshot work?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We analyze the specific competitors currently winning the Miami AI Overview slots for your head terms. We then reverse-engineer their schema and content segments to determine the exact extractability gap you need to close.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'Does this help with multilingual AI search in Miami?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Absolutely. For Miami, we specifically optimize for Spanish/English bilingual citation signals, ensuring that cross-language retrieval in ChatGPT and Claude accurately represents your business.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'What local Miami data sources do you align with?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We align your JSON-LD with major Miami-specific directories, chambers of commerce, and local news citations that LLMs use as ground-truth verifiers for South Florida entities.'
                ]
            ]
        ]
    ]
];
?>

<main role="main" class="container">
    <!-- Visible Breadcrumbs -->
    <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom: 2rem; font-size: 0.9rem; color: #666;">
        <ol style="list-style: none; padding: 0; display: flex; gap: 0.5rem;">
            <li><a href="<?= absolute_url('/') ?>">Home</a> &gt; </li>
            <li><a href="<?= absolute_url('/services/') ?>">Services</a> &gt; </li>
            <li><?= $serviceTitle ?> &gt; </li>
            <li aria-current="page"><?= $cityTitle ?></li>
        </ol>
    </nav>

    <article class="section">
        <div class="section__content">
            <header class="content-block module">
                <div class="content-block__header">
                    <h1 class="content-block__title">AI Search Optimization in Miami</h1>
                </div>
                <div class="content-block__body">
                    <p class="lead">Dominate South Florida's generative search results by aligning your technical SEO with AI retrieval mechanics.</p>
                </div>
            </header>

            <!-- ABOVE-THE-FOLD TRUST BLOCK -->
            <section class="trust-block" style="background: #f0f7ff; border: 1px solid #4a90e2; border-radius: 8px; padding: 2rem; margin: 2rem 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="margin-top: 0; color: #0066cc;">What we change</h3>
                    <ul style="padding-left: 1.2rem;">
                        <li><strong>Crawl Clarity:</strong> Solve the "parameter sprawl" common in Miami real estate/finance sites.</li>
                        <li><strong>Entity Anchoring:</strong> Link your business to Miami-specific knowledge nodes.</li>
                        <li><strong>Atomic Content:</strong> Answer queries in the first 100 characters for high AI citation.</li>
                    </ul>
                </div>
                <div>
                    <h3 style="margin-top: 0; color: #0066cc;">What you get</h3>
                    <ul style="padding-left: 1.2rem;">
                        <li><strong>Google AI Overviews:</strong> Outrank competitors in the generative "zero-slot".</li>
                        <li><strong>Bilingual AI Accuracy:</strong> Ensure English and Spanish LLM queries find you.</li>
                        <li><strong>Direct Traffic:</strong> Drive clicks from source citations in Perplexity and ChatGPT.</li>
                    </ul>
                </div>
                <div>
                    <h3 style="margin-top: 0; color: #0066cc;">Proof Signals</h3>
                    <p style="font-style: italic; font-size: 0.95rem;">"NRLC's Miami framework fixed our metadata gap. We now own the AI overview for 'private equity Miami'."</p>
                    <p style="font-weight: bold; margin-bottom: 0;">— South FL Media Group</p>
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span style="background: #fff; padding: 0.2rem 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.8rem;">Miami SERP Verified</span>
                        <span style="background: #fff; padding: 0.2rem 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.8rem;">AEO-1 Optimized</span>
                    </div>
                </div>
                <div style="grid-column: 1 / -1; border-top: 1px solid #b3d1ff; padding-top: 1.5rem; text-align: center;">
                    <button type="button" class="btn btn--primary" onclick="openContactSheet('Miami AI SEO Consultation')">Get Your Miami AI SERP Fix List</button>
                    <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #555;">No obligation. South Florida competitor audit included.</p>
                </div>
            </section>

            <!-- MIAMI SPECIFIC SECTION -->
            <section class="content-block module">
                <div class="content-block__header">
                    <h2>Miami AI Search Intelligence Report</h2>
                </div>
                <div class="content-block__body">
                    <div style="background: #fdfdfd; border: 1px solid #eee; padding: 1.5rem; margin-bottom: 1.5rem;">
                        <h3>Miami SERP Snapshot</h3>
                        <p>We've observed that in the Miami market, AI Overviews are currently favoring <strong>"Answer-First"</strong> content over long-form landing pages. Competitors in Finance, Real Estate, and Tourism are losing the generative slot because their content is trapped in heavy JavaScript frameworks that AI engines fail to "rehydrate" correctly.</p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                        <div>
                            <h4>Miami Industries We See AI Tracking</h4>
                            <ul style="font-size: 0.95rem;">
                                <li>Fintech / Crypto Banking</li>
                                <li>Luxury Real Estate Development</li>
                                <li>Medical / Aesthetic services</li>
                                <li>International Logistics</li>
                            </ul>
                        </div>
                        <div>
                            <h4>Local Trust Sources We Align</h4>
                            <p style="font-size: 0.9rem;">We don't just optimize your site; we optimize the <strong>"Off-Site Entity Footprint"</strong> by aligning your brand data with Miami-specific sources that LLMs use to verify South Florida businesses.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQs -->
            <section class="content-block module">
                <div class="content-block__header">
                    <h2>Frequently Asked Questions</h2>
                </div>
                <div class="content-block__body">
                    <?php
                    $faqs = $GLOBALS['__jsonld'][2]['mainEntity'];
                    foreach ($faqs as $faq): ?>
                        <details style="margin-bottom: 1rem; border: 1px solid #eee; padding: 1rem; border-radius: 4px;">
                            <summary style="font-weight: bold; cursor: pointer;"><?= $faq['name'] ?></summary>
                            <p style="margin-top: 0.5rem; color: #444;"><?= $faq['acceptedAnswer']['text'] ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Internal Links -->
            <footer style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #eee;">
                <h3>Nearby Markets & Related Insights</h3>
                <ul style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 1.5rem;">
                    <li><a href="<?= $sanJoseUrl ?>">San Jose AI Search Optimization</a></li>
                    <li><a href="<?= $atlantaUrl ?>">Atlanta Generative SEO</a></li>
                    <li><a href="<?= $insightsUrl ?>">AI Search Research & Insights</a></li>
                    <li><a href="<?= absolute_url('/products/applicants-io/') ?>">Applicants.io Product</a></li>
                </ul>
            </footer>
        </div>
    </article>
</main>
