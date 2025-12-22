<?php
declare(strict_types=1);
// Specialized template for site-audits city pages
// This template implements the META DIRECTIVE: CITY AUDIT SERVICE PAGES — CONVERSION & TRUST SYSTEM
// Authority-led, not transactional. Diagnostic-first routing.

require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/content_tokens.php';
require_once __DIR__.'/../../lib/csv.php';
require_once __DIR__.'/../../lib/nrlc_linking_kernel.php';

// Assume $serviceSlug, $citySlug, $currentUrl are provided by router
$serviceSlug = $_GET['service'] ?? 'site-audits';
$citySlug    = $_GET['city']    ?? '';
$pathKey = "/services/$serviceSlug/$citySlug/";

$serviceTitle = 'Site Audit';
$cityTitle = titleCaseCity($citySlug);

// Use router's meta title for H1 (ensures H1 matches title for SERP control)
$meta = $GLOBALS['__page_meta'] ?? null;
if ($meta && isset($meta['title'])) {
  // Extract H1 from title (remove " | NRLC.ai" suffix for H1)
  $h1Title = preg_replace('/\s*\|\s*NRLC\.ai\s*$/i', '', $meta['title']);
  $pageTitle = $h1Title;
} else {
  // Fallback if meta not set
  $pageTitle = "Site Audit Services in $cityTitle";
}

// Load city data for schema
$citiesData = csv_read_data('cities.csv');
$cityRow = null;
foreach ($citiesData as $c) {
  if (($c['city_name'] ?? '') === $citySlug) {
    $cityRow = $c;
    break;
  }
}
if (!$cityRow) {
  $cityTitle = ucwords(str_replace(['-','_'],' ',$citySlug));
  $cityRow = ['city_name' => $cityTitle, 'country' => 'US', 'subdivision' => ''];
}

// Set page metadata for head.php
$GLOBALS['__page_slug'] = 'services/service_city_audit';

// Detect locale from URL
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$locale = '';
if (preg_match('#^/([a-z]{2}-[a-z]{2})/#', $currentPath, $matches)) {
  $locale = $matches[1];
}
$localePrefix = $locale ? "/$locale" : '';

$canonicalUrl = absolute_url($pathKey);
$domain = absolute_url('/');
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- SECTION 1: HERO (CONTEXT + DIFFERENTIATION) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title">Site Audit Services in <?= htmlspecialchars($cityTitle) ?></h1>
      </div>
      <div class="content-block__body">
        <p class="lead">Most site audits surface issues. Very few explain why visibility actually breaks down.</p>
      </div>
    </div>

    <!-- SECTION 2: AUTHORITY FRAMING (CRITICAL) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Why most site audits miss the real problem</h2>
      </div>
      <div class="content-block__body">
        <p>Most audits focus on surface-level checks like missing tags, generic best practices, or tool outputs.</p>
        <p>We approach audits differently. We look at how search engines and language models actually interpret your site, where ambiguity exists, and why visibility fails in practice even when everything looks "technically fine."</p>
      </div>
    </div>

    <!-- SECTION 3: WHAT THIS AUDIT IS FOR (DECISION VALUE) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What this audit is actually for</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Understanding why your site is not surfacing consistently</li>
          <li>Identifying which signals matter and which do not</li>
          <li>Avoiding investment in fixes that will not change outcomes</li>
          <li>Deciding what is worth implementing next</li>
        </ul>
        <p><strong>This audit is not a checklist. It is a decision-support tool.</strong></p>
      </div>
    </div>

    <!-- SECTION 4: HOW WE INTERPRET SYSTEMS (PROOF OF THINKING) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How we interpret search and AI systems</h2>
      </div>
      <div class="content-block__body">
        <p>In many audits, we see sites that are technically clean but still invisible.</p>
        <p>The issue is rarely a missing tag. It is usually how content, structure, entities, and context are interpreted together across search engines and language models.</p>
        <p>This audit focuses on those interactions, not isolated metrics.</p>
      </div>
    </div>

    <!-- SECTION 5: WHAT YOU RECEIVE (OUTCOMES, NOT TOOLS) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">What you get from the audit</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Clear explanation of how your site is being interpreted</li>
          <li>Identification of ambiguity and conflicting signals</li>
          <li>Prioritized areas that actually affect visibility</li>
          <li>Context for what cannot be inferred without deeper access</li>
        </ul>
      </div>
    </div>

    <!-- SECTION 6: LOCATION CONTEXT (LIGHT, TRUST-ONLY) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">About audits in <?= htmlspecialchars($cityTitle) ?></h2>
      </div>
      <div class="content-block__body">
        <p>While this page references <?= htmlspecialchars($cityTitle) ?>, the issues we audit are not local quirks.</p>
        <p>Visibility problems are systemic and depend on how your site is interpreted across search and AI systems, regardless of location.</p>
      </div>
    </div>

    <!-- SECTION 7: QUALIFICATION (FILTER) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Who this is for</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <li>Businesses already investing in SEO or AI visibility</li>
          <li>Teams responsible for growth or discoverability</li>
          <li>Decision-makers seeking clarity, not tactics</li>
        </ul>
        <p>If you are looking for a cheap checklist audit, this is not a fit.</p>
      </div>
    </div>

    <!-- PRICING & SCOPE SECTION (META DIRECTIVE: PRICING & RESULTS TRANSPARENCY) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Pricing & Scope</h2>
      </div>
      <div class="content-block__body">
        <?php
        // Currency detection: UK pages use GBP, US pages use USD
        $isUK = ($locale === 'en-gb' || ($cityRow['country'] ?? '') === 'GB' || ($cityRow['country'] ?? '') === 'UK');
        if ($isUK) {
          $priceRange = '£3,500 to £18,000';
        } else {
          // USD equivalent maintaining same positioning
          $priceRange = '$4,500 to $23,000';
        }
        ?>
        <p>Audit and diagnostic engagements typically range from <strong><?= htmlspecialchars($priceRange) ?></strong>, depending on scope and complexity. This work focuses on interpretation and decision clarity, not automated or per-page checks.</p>
        <p>If your goal is a low-cost checklist or automated scan, this will not be a fit.</p>
      </div>
    </div>

    <!-- HOW RESULTS ARE ACHIEVED SECTION (META DIRECTIVE: PRICING & RESULTS TRANSPARENCY) -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">How results are achieved</h2>
      </div>
      <div class="content-block__body">
        <p>Results do not come from applying fixes blindly.</p>
        <p>They come from reducing ambiguity and aligning how systems interpret your site.</p>
        <p>Our work focuses on clarifying entity relationships, resolving conflicting signals, and aligning structure and content with how search engines and language models actually process information.</p>
        <p>This approach avoids surface-level recommendations and prioritizes changes that meaningfully affect how your site is understood and surfaced.</p>
        <p>There are no shortcuts, and there are no guarantees. Results depend on implementation, context, and how systems evolve over time.</p>
      </div>
    </div>

    <!-- SECTION 8: CTA STRUCTURE (CRITICAL - DIAGNOSTIC FIRST) -->
    <div class="content-block module" style="background: #f0f7ff; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-top: var(--spacing-lg);">
      <div class="content-block__body">
        <p style="margin: 0 0 var(--spacing-md) 0; font-weight: 500;"><strong>Run a Diagnostic First</strong></p>
        <p style="margin: 0 0 var(--spacing-md) 0; font-size: 0.9rem; color: #666;">Understand your visibility issues before requesting an audit.</p>
        <p style="margin: 0 0 var(--spacing-md) 0;">
          <a href="<?= htmlspecialchars($localePrefix . '/resources/diagnostic/') ?>" class="btn btn--primary" title="Run a diagnostic to understand your visibility issues">Run a Diagnostic First</a>
        </p>
        <p style="margin: var(--spacing-md) 0 0 0; font-size: 0.9rem; color: #666;">Or, if you are ready to request an audit:</p>
        <p style="margin: var(--spacing-sm) 0 0 0;">
          <button type="button" class="btn btn--secondary" onclick="openContactSheet('Site Audit Request - <?= htmlspecialchars($cityTitle) ?>')" title="Request a site audit">Request an Audit</button>
        </p>
      </div>
    </div>

    <?php
    // STEP 5: Internal Linking Repair
    // Get related services for lateral linking
    $relatedServices = get_related_services_for_linking('site-audits', $locale);
    ?>

    <!-- STEP 5: Related Services Footer Block -->
    <?php if (!empty($relatedServices)): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Related Services</h2>
      </div>
      <div class="content-block__body">
        <ul>
          <?php foreach ($relatedServices as $related): ?>
          <li><a href="<?= htmlspecialchars($related['url']) ?>"><?= htmlspecialchars($related['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <p><a href="<?= htmlspecialchars($localePrefix . '/') ?>">Home</a> | <a href="<?= htmlspecialchars($localePrefix . '/services/') ?>">All Services</a></p>
      </div>
    </div>
    <?php endif; ?>

    <?php
    // LINKING KERNEL: Add required internal links
    if (function_exists('render_internal_links_section')) {
      echo render_internal_links_section('services', 'site-audits', ['city' => $citySlug], 'Related Resources');
    }
    ?>

  </div>
</section>
</main>

<?php
// SCHEMA: Service, WebPage, BreadcrumbList only (no Offer, Product, Review, AggregateRating)
$GLOBALS['__jsonld'] = array_merge($GLOBALS['__jsonld'] ?? [], [
  [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'Site Audit Services',
    'serviceType' => 'Site Audit',
    'description' => 'Site audit services that explain why visibility breaks down, not just surface-level issues. Focus on how search engines and AI systems interpret your site.',
    'provider' => [
      '@type' => 'Organization',
      'name' => 'Neural Command LLC',
      'url' => $domain
    ],
    'url' => $canonicalUrl
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => $pageTitle,
    'url' => $canonicalUrl,
    'description' => 'Site audit services in ' . $cityTitle . '. We explain why visibility breaks down, not just surface-level issues.',
    'isPartOf' => [
      '@type' => 'WebSite',
      '@id' => $domain . '/#website',
      'name' => 'NRLC.ai',
      'url' => $domain
    ]
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => $domain . '/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Services',
        'item' => $domain . '/services/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Site Audits',
        'item' => $domain . '/services/site-audits/'
      ],
      [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => $cityTitle,
        'item' => $canonicalUrl
      ]
    ]
  ]
]);
?>

