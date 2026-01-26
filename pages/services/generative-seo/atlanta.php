<?php
/**
 * Specialized Page: Generative SEO - Atlanta
 * Optimized based on GSC data Jan 2026
 */

$serviceSlug = 'generative-seo';
$citySlug = 'atlanta';
$cityTitle = 'Atlanta';
$serviceTitle = 'Generative SEO';

// Set metadata for head.php
$GLOBALS['__page_meta'] = [
    'title' => 'Generative SEO in Atlanta | Optimize for AI Overviews + ChatGPT',
    'description' => 'Win citations in Google AI Overviews and ChatGPT. Our Atlanta Generative SEO framework fixes indexing gaps and improves AI engine retrieval.',
    'keywords' => 'Generative SEO Atlanta, AI Overviews Optimization, ChatGPT SEO Atlanta, LLM Seeding Atlanta, AI Search Marketing',
    'canonicalPath' => "/en-us/services/$serviceSlug/$citySlug/"
];

// Internal links
$sanJoseUrl = '/en-us/services/ai-search-optimization/san-jose/';
$miamiUrl = '/en-us/services/ai-search-optimization/miami/';
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
            'containedInPlace' => ['@type' => 'State', 'name' => 'GA'],
            'sameAs' => 'https://www.wikidata.org/wiki/Q23556'
        ],
        'url' => $canonical_url,
        'mainEntityOfPage' => $canonical_url
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        '@id' => $canonical_url . '#deliverables',
        'name' => 'Generative SEO Deliverables - Atlanta',
        'description' => 'Key deliverables for our Atlanta-based Generative SEO engagements.',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'AI Citation Gap Analysis'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Entity Relationship Schema Deployment'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Atomic Content Architecture Update'],
            ['@type' => 'ListItem', 'position' => 4, 'name' => 'LLM Proof-of-Citation Audit (ChatGPT/Claude)']
        ]
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        '@id' => $canonical_url . '#faq',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'How is Generative SEO different from traditional SEO in Atlanta?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Traditional SEO focuses on keywords and backlinks for Google ranking. Generative SEO focuses on "Extractability" and "Citation Signal Engineering"—ensuring AI models can easily summarize and reference your brand as a source.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'What "Answer-First" signals do you implement?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We restructure your Atlanta target pages so the primary answer is in the first 1-2 sentences, wrapped in specific HTML patterns that AI engines are trained to retrieve first.'
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
                    <h1 class="content-block__title">Generative SEO in Atlanta</h1>
                </div>
                <div class="content-block__body">
                    <p class="lead">Stop guessing why your Atlanta brand isn't being cited. We engineer the structural and semantic signals AI engines require.</p>
                </div>
            </header>

            <!-- ABOVE-THE-FOLD TRUST BLOCK -->
            <section class="trust-block" style="background: #fdfdfd; border: 1px solid #ddd; border-radius: 8px; padding: 2rem; margin: 2rem 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="margin-top: 0; color: #333;">What we change</h3>
                    <ul style="padding-left: 1.2rem; font-size: 0.95rem;">
                        <li><strong>Snippet Architecture:</strong> Optimize for the "zero-slot" AI summary.</li>
                        <li><strong>Knowledge Graph Ties:</strong> Ensure Atlanta-specific entity verification.</li>
                        <li><strong>Structured Data:</strong> Beyond basic schema—we build entity relationship maps.</li>
                    </ul>
                </div>
                <div>
                    <h3 style="margin-top: 0; color: #333;">Strategic Deliverables</h3>
                    <ul style="padding-left: 1.2rem; font-size: 0.95rem;">
                        <li><strong>AI Visibility Audit:</strong> Where you rank vs. where you are cited.</li>
                        <li><strong>The 30-Day Fix List:</strong> Immediate technical changes for Atlanta market.</li>
                        <li><strong>Citation Managed Service:</strong> Ongoing LLM seeding.</li>
                    </ul>
                </div>
                <div style="text-align: center;">
                    <button type="button" class="btn btn--primary" onclick="openContactSheet('Atlanta Generative SEO Consultation')">Download the Atlanta AI Audit</button>
                    <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #555;">Get your free AI extraction report today.</p>
                </div>
            </section>

            <!-- BEFORE & AFTER OPTIMIZATION -->
            <section class="content-block module">
                <div class="content-block__header">
                    <h2>Generative SEO Performance Benchmarks</h2>
                </div>
                <div class="content-block__body">
                    <p>In Atlanta's competitive B2B and Services market, traditional SEO signals are often ignored by AI engines if they lack <strong>extractability</strong>. Here is what we transform:</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin-top: 2rem;">
                        <div style="padding: 1.5rem; background: #fff5f5; border: 1px solid #ffcdd2;">
                            <h4 style="color: #c62828; margin-top: 0;">Before Optimization</h4>
                            <p style="font-size: 0.9rem;">Generic meta-tags, JavaScript-heavy content, and siloed pages. Google indexes but AI engines fail to verify. 0% AI Citation Rate.</p>
                        </div>
                        <div style="padding: 1.5rem; background: #f1f8e9; border: 1px solid #c5e1a5;">
                            <h4 style="color: #2e7d32; margin-top: 0;">After Generative Framework</h4>
                            <p style="font-size: 0.9rem;">Atomic fact segments, explicit JSON-LD entity maps, and citation-ready headers. AI systems summarize your brand accurately. >40% AI Citation Rate.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Deliverables Section -->
            <section class="content-block module">
                <div class="content-block__header">
                    <h2>Atlanta Generative SEO Deliverables</h2>
                </div>
                <div class="content-block__body">
                    <ul class="list-check" style="list-style: none; padding: 0;">
                        <?php
                        $items = $GLOBALS['__jsonld'][2]['itemListElement'];
                        foreach ($items as $item): ?>
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                                <strong><?= $item['name'] ?></strong> — Focused on Atlanta market signals.
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>

            <!-- FAQs -->
            <section class="content-block module">
                <div class="content-block__header">
                    <h2>Frequently Asked Questions</h2>
                </div>
                <div class="content-block__body">
                    <?php
                    $faqs = $GLOBALS['__jsonld'][3]['mainEntity'];
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
                    <li><a href="<?= $miamiUrl ?>">Miami AI Search Optimization</a></li>
                    <li><a href="<?= $insightsUrl ?>">AI Search Research & Insights</a></li>
                    <li><a href="<?= absolute_url('/products/applicants-io/') ?>">Applicants.io Product</a></li>
                </ul>
            </footer>
        </div>
    </article>
</main>
