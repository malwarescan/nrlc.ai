<?php
/**
 * Specialized Page: AI Search Optimization - San Jose
 * Optimized based on GSC data Jan 2026
 */

$serviceSlug = 'ai-search-optimization';
$citySlug = 'san-jose';
$cityTitle = 'San Jose';
$serviceTitle = 'AI Search Optimization';

// Set metadata for head.php
$GLOBALS['__page_meta'] = [
    'title' => 'AI Search Optimization in San Jose | Win AI Overviews + ChatGPT Citations',
    'description' => 'Technical + content + schema changes that increase citations in AI Overviews/ChatGPT. Local SERP analysis + fix list + 30-day plan.',
    'keywords' => 'AI Search Optimization San Jose, AI SEO San Jose, ChatGPT Citations, Google AI Overviews Optimization, San Jose AI Search Marketing',
    'canonicalPath' => "/en-us/services/$serviceSlug/$citySlug/"
];

// Internal links for later
$miamiUrl = '/en-us/services/ai-search-optimization/miami/';
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
            'containedInPlace' => ['@type' => 'State', 'name' => 'CA'],
            'sameAs' => 'https://www.wikidata.org/wiki/Q16553'
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
                'name' => 'How long does it take to see results in AI Overviews?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'For San Jose businesses, we typically see citation changes within 14-30 days of implementing our Technical + Content + Schema stack. Major citation shifts often correlate with the next core update or LLM refresh.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'Does this help with ChatGPT and Perplexity citations?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. Our AI Search Optimization specifically targets the retrieval signals used by ChatGPT (OpenAI Search), Perplexity, and Claude. We focus on entity clarity and verifiable facts that these models prioritize.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'How does the San Jose local pack overlap with AI results?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'In San Jose, Google often blends Local Pack data with AI Overviews. We optimize your GBP signals and schema simultaneously to ensure you don\'t lose local map visibility while gaining AI citations.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'What is the pricing model for AI SEO in San Jose?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We offer project-based AI audits (one-time) and ongoing citation management. In a high-competition market like San Jose, most clients benefit from a 90-day citation sprint followed by monthly maintenance.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'Will my traditional SEO rankings decrease?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'No. Our "Answer-First" architecture actually strengthens traditional SEO signals by improving content quality and crawl clarity. Most San Jose clients see an increase in both traditional rankings and AI citations.'
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
                    <h1 class="content-block__title">AI Search Optimization in San Jose</h1>
                </div>
                <div class="content-block__body">
                    <p class="lead">Capture high-intent traffic by winning citations in Google AI Overviews, ChatGPT, and Perplexity for your San Jose business.</p>
                </div>
            </header>

            <!-- ABOVE-THE-FOLD TRUST BLOCK -->
            <section class="trust-block" style="background: #f0f7ff; border: 1px solid #4a90e2; border-radius: 8px; padding: 2rem; margin: 2rem 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="margin-top: 0; color: #0066cc;">What we change</h3>
                    <ul style="padding-left: 1.2rem;">
                        <li><strong>Crawl Clarity:</strong> Eliminate technical noise that prevents AI indexing.</li>
                        <li><strong>Entity Anchoring:</strong> Explicitly define your San Jose business in Knowledge Graphs.</li>
                        <li><strong>Atomic Content:</strong> Format your answers for easy LLM extraction.</li>
                    </ul>
                </div>
                <div>
                    <h3 style="margin-top: 0; color: #0066cc;">What you get</h3>
                    <ul style="padding-left: 1.2rem;">
                        <li><strong>AI Overviews Coverage:</strong> Increased visibility in Google's generative answers.</li>
                        <li><strong>ChatGPT Citations:</strong> Influence the sources OpenAI refers to for San Jose queries.</li>
                        <li><strong>SERP Domination:</strong> Own the space between ads and organic blue links.</li>
                    </ul>
                </div>
                <div>
                    <h3 style="margin-top: 0; color: #0066cc;">Proof Signals</h3>
                    <p style="font-style: italic; font-size: 0.95rem;">"Within 30 days of the San Jose sprint, our brand citations in AI Overviews increased by 40%."</p>
                    <p style="font-weight: bold; margin-bottom: 0;">— LLM Strategist Lab</p>
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span style="background: #fff; padding: 0.2rem 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.8rem;">GEO-16 Certified</span>
                        <span style="background: #fff; padding: 0.2rem 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.8rem;">JSON-LD Verified</span>
                    </div>
                </div>
                <div style="grid-column: 1 / -1; border-top: 1px solid #b3d1ff; padding-top: 1.5rem; text-align: center;">
                    <button type="button" class="btn btn--primary" onclick="openContactSheet('San Jose AI SEO Consultation')">Get Your 30-Day Fix List</button>
                    <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #555;">No obligation. Local San Jose SERP analysis included.</p>
                </div>
            </section>

            <section class="content-block module">
                <div class="content-block__header">
                    <h2>San Jose AI Authority Implementation</h2>
                </div>
                <div class="content-block__body">
                    <p>San Jose is a globally unique tech market. AI engines interpret San Jose businesses through a lens of technical excellence and innovation. If your site structure lacks <strong>entity clarity</strong>, the LLMs will default to competitors with better-structured data—even if they have less domain authority.</p>
                    <p>Our San Jose-specific AI Search Optimization framework fixes the "Ranking but No Clicks" pattern by aligning your page snippets with true user intent. We don't just optimize for keywords; we optimize for <strong>citation likelihood</strong>.</p>
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
                    <li><a href="<?= $miamiUrl ?>">Miami AI Search Optimization</a></li>
                    <li><a href="<?= $atlantaUrl ?>">Atlanta Generative SEO</a></li>
                    <li><a href="<?= $insightsUrl ?>">AI Search Research & Insights</a></li>
                    <li><a href="<?= absolute_url('/products/applicants-io/') ?>">Applicants.io Product</a></li>
                </ul>
            </footer>
        </div>
    </article>
</main>
