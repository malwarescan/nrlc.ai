<?php
declare(strict_types=1);
require_once __DIR__.'/../../lib/helpers.php';
require_once __DIR__.'/../../lib/schema_builders.php';
require_once __DIR__.'/../../lib/hreflang.php';
require_once __DIR__.'/../../lib/nrlc_linking_kernel.php';

$brand='NRLC.ai'; $domain='https://nrlc.ai'; $contact='team@nrlc.ai';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
  http_response_code(404);
  echo "Item not found";
  exit;
}

$csv = __DIR__ . '/../../data/catalog.csv';
$item = null;
if (is_file($csv)) {
  if (($fp=fopen($csv,'r'))!==false) {
    $hdr = fgetcsv($fp);
    while(($r=fgetcsv($fp))!==false){
      $row = array_combine($hdr,$r);
      if ($row['slug'] === $slug) {
        $item = $row;
        break;
      }
    }
    fclose($fp);
  }
}

if (!$item) {
  http_response_code(404);
  echo "Item not found";
  exit;
}

$url = $domain . '/catalog/' . $slug . '/';
$title = $item['name'] . ' | ' . $brand;
$desc = $item['short'] ?: $item['description'];

// Build comprehensive SEO description
$seoDesc = $item['description'] ?: $item['short'];
if ($item['type'] === 'service') {
  $seoDesc = $item['name'] . ' service by ' . $brand . '. ' . $seoDesc . ' Professional implementation with proven results.';
} elseif ($item['type'] === 'software') {
  $seoDesc = $item['name'] . ' by ' . $brand . '. ' . $seoDesc . ' Open source tools and utilities for developers.';
} else {
  $seoDesc = $item['name'] . ' from ' . $brand . '. ' . $seoDesc;
}

$GLOBALS['__page_slug'] = 'catalog/item';
$GLOBALS['pageTitle'] = $title;
$GLOBALS['pageDesc'] = $seoDesc;
?>

<main role="main" class="container">
<section class="section">
  <div class="section__content">
    
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="content-block module">
      <div class="content-block__body">
        <p class="small muted">
          <a href="/">Home</a> › 
          <a href="/catalog/">Catalog</a> › 
          <?= htmlspecialchars($item['name']) ?>
        </p>
      </div>
    </nav>

    <!-- Product/Service Header -->
    <div class="content-block module">
      <div class="content-block__header">
        <h1 class="content-block__title"><?= htmlspecialchars($item['name']) ?></h1>
      </div>
      <div class="content-block__body">
        <?php if (!empty($item['short'])): ?>
          <p class="lead"><?= htmlspecialchars($item['short']) ?></p>
        <?php endif; ?>
        
        <?php if (!empty($item['image_url'])): ?>
          <figure style="margin: var(--spacing-24) 0;">
            <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                 alt="<?= htmlspecialchars($item['name']) ?>" 
                 style="max-width: 100%; height: auto; border: 1px solid var(--color-border);">
          </figure>
        <?php endif; ?>
      </div>
    </div>

    <!-- Detailed Description -->
    <?php if (!empty($item['description'])): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Overview</h2>
      </div>
      <div class="content-block__body">
        <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
      </div>
    </div>
    <?php endif; ?>

    <!-- Specifications & Details -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Specifications</h2>
      </div>
      <div class="content-block__body">
        <dl>
          <?php if (!empty($item['type'])): ?>
            <dt>Type</dt>
            <dd><?= htmlspecialchars(ucfirst($item['type'])) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['category'])): ?>
            <dt>Category</dt>
            <dd><?= htmlspecialchars($item['category']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['sku'])): ?>
            <dt>SKU</dt>
            <dd><?= htmlspecialchars($item['sku']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['brand'])): ?>
            <dt>Brand</dt>
            <dd><?= htmlspecialchars($item['brand']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['price'])): ?>
            <dt>Price</dt>
            <dd><?= htmlspecialchars($item['currency'] ?: 'USD') ?> <?= htmlspecialchars($item['price']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['availability'])): ?>
            <dt>Availability</dt>
            <dd><?= htmlspecialchars($item['availability']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['delivery'])): ?>
            <dt>Delivery Method</dt>
            <dd><?= htmlspecialchars(ucfirst($item['delivery'])) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['subscription'])): ?>
            <dt>Subscription</dt>
            <dd><?= htmlspecialchars($item['subscription']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['os'])): ?>
            <dt>Operating System</dt>
            <dd><?= htmlspecialchars($item['os']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['appCategory'])): ?>
            <dt>Application Category</dt>
            <dd><?= htmlspecialchars($item['appCategory']) ?></dd>
          <?php endif; ?>
          
          <?php if (!empty($item['license_url'])): ?>
            <dt>License</dt>
            <dd><a href="<?= htmlspecialchars($item['license_url']) ?>" target="_blank" rel="noopener">View License</a></dd>
          <?php endif; ?>
        </dl>
      </div>
    </div>

    <!-- Key Features & Benefits -->
    <?php if ($item['type'] === 'service'): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Service Implementation</h2>
      </div>
      <div class="content-block__body">
        <h3>What's Included</h3>
        <ul>
          <li>Professional implementation and configuration by certified experts</li>
          <li>Comprehensive documentation and training materials</li>
          <li>Ongoing support and optimization during implementation</li>
          <li>Performance monitoring and reporting dashboards</li>
          <li>Post-implementation review and optimization recommendations</li>
        </ul>
        
        <h3>Delivery Method</h3>
        <p>This service is delivered <?= htmlspecialchars($item['delivery'] ?: 'remotely') ?> via secure communication channels. Our team works directly with your technical staff to ensure proper implementation and knowledge transfer.</p>
        
        <h3>Timeline & Process</h3>
        <p>Implementation timelines vary based on project scope, site complexity, and current technical infrastructure. Typical projects range from 2-8 weeks depending on requirements. Contact us for a detailed project timeline and custom quote based on your specific needs.</p>
      </div>
    </div>
    <?php elseif ($item['type'] === 'software'): ?>
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Software Details</h2>
      </div>
      <div class="content-block__body">
        <h3>Technical Specifications</h3>
        <ul>
          <?php if (!empty($item['os'])): ?>
            <li>Compatible with: <?= htmlspecialchars($item['os']) ?></li>
          <?php endif; ?>
          <?php if (!empty($item['appCategory'])): ?>
            <li>Application Category: <?= htmlspecialchars($item['appCategory']) ?></li>
          <?php endif; ?>
          <li>Delivery Method: <?= htmlspecialchars(ucfirst($item['delivery'] ?: 'download')) ?></li>
          <?php if (!empty($item['license_url'])): ?>
            <li>License: <a href="<?= htmlspecialchars($item['license_url']) ?>" target="_blank" rel="noopener">Open Source License</a> (view full license terms)</li>
          <?php endif; ?>
          <li>Version: 1.0.0 (current stable release)</li>
        </ul>
        
        <h3>Getting Started</h3>
        <p>This software is available for <?= htmlspecialchars($item['delivery'] ?: 'download') ?>. <?php if (!empty($item['landing_url'])): ?>Visit the <a href="<?= htmlspecialchars($item['landing_url']) ?>">product page</a> for complete installation instructions, API documentation, usage examples, and troubleshooting guides.<?php else: ?>Contact us for access credentials and detailed setup instructions.<?php endif; ?></p>
        
        <h3>Use Cases</h3>
        <p>This tool is designed for developers, technical SEO specialists, and data engineers working with structured data, JSON-LD implementation, and AI engine optimization. It integrates with common development workflows and supports automation for large-scale implementations.</p>
      </div>
    </div>
    <?php endif; ?>

    <!-- Related Information -->
    <div class="content-block module">
      <div class="content-block__header">
        <h2 class="content-block__title">Additional Information</h2>
      </div>
      <div class="content-block__body">
        <h3>Support & Resources</h3>
        <ul>
          <li>Technical documentation and implementation guides</li>
          <li>Email support: <a href="mailto:<?= htmlspecialchars($contact) ?>"><?= htmlspecialchars($contact) ?></a></li>
          <li>Phone support: <a href="tel:+12135628438">+1-213-562-8438</a></li>
          <li>Visit our <a href="/insights/">insights page</a> for related research and best practices</li>
        </ul>
        
        <h3>Related Services</h3>
        <p>This <?= htmlspecialchars($item['type'] ?: 'item') ?> is part of NRLC.ai's comprehensive suite of AI SEO and structured data services. Consider combining with other services for maximum impact. <a href="/catalog/">Browse the full catalog</a> to see all available options.</p>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="content-block module">
      <div class="content-block__body">
        <div class="btn-group">
          <?php if (!empty($item['landing_url'])): ?>
            <?php if ($item['type'] === 'service'): ?>
              <a href="<?= htmlspecialchars($item['landing_url']) ?>" class="btn btn--primary"><?= htmlspecialchars($item['name']) ?> Service</a>
            <?php elseif ($item['type'] === 'software'): ?>
              <a href="<?= htmlspecialchars($item['landing_url']) ?>" class="btn btn--primary"><?= htmlspecialchars($item['name']) ?> Docs</a>
            <?php else: ?>
              <a href="<?= htmlspecialchars($item['landing_url']) ?>" class="btn btn--primary"><?= htmlspecialchars($item['name']) ?></a>
            <?php endif; ?>
          <?php endif; ?>
          <a href="/catalog/" class="btn">Back to Catalog</a>
        </div>
      </div>
    </div>

    <!-- LINKING KERNEL: Related Resources -->
    <?php
    if (function_exists('render_internal_links_section')) {
      echo render_internal_links_section('catalog', $slug, $item, 'Related Resources');
    }
    ?>

  </div>
</section>
</main>

<?php
// -------- JSON-LD EMISSION --------
$graph = [];
$webPageId = $url . '#webpage';
$breadcrumbId = $url . '#breadcrumb';
$productId = $url . '#product';

$graph[] = [
  "@context" => "https://schema.org",
  "@type" => "WebPage",
  "@id" => $webPageId,
  "url" => $url,
  "name" => $title,
  "description" => $seoDesc,
  "inLanguage" => "en",
  "isPartOf" => ["@id" => $domain . "/#website"],
  "breadcrumb" => ["@id" => $breadcrumbId],
  "about" => ["@id" => $productId]
];

if ($item['type'] === 'service') {
  $serviceId = $url . "#service";
  $graph[] = [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "@id" => $serviceId,
    "name" => $item['name'],
    "description" => $item['description'] ?: $item['short'],
    "provider" => [
      "@type" => "Organization",
      "name" => $brand,
      "url" => $domain
    ],
    "areaServed" => "Worldwide",
    "serviceType" => $item['category'] ?: "ProfessionalService",
    "offers" => [
      "@type" => "Offer",
      "price" => $item['price'] ?: "0.00",
      "priceCurrency" => $item['currency'] ?: "USD",
      "availability" => "https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url" => $url,
      "seller" => [
        "@type" => "Organization",
        "name" => $brand
      ]
    ]
  ];
} elseif ($item['type'] === 'software') {
  $appId = $url . "#app";
  $graph[] = [
    "@context" => "https://schema.org",
    "@type" => "SoftwareApplication",
    "@id" => $appId,
    "name" => $item['name'],
    "description" => $item['description'] ?: $item['short'],
    "applicationCategory" => $item['appCategory'] ?: "DeveloperApplication",
    "operatingSystem" => $item['os'] ?: "Web",
    "softwareVersion" => "1.0.0",
    "url" => $url,
    "offers" => [
      "@type" => "Offer",
      "price" => $item['price'] ?: "0.00",
      "priceCurrency" => $item['currency'] ?: "USD",
      "availability" => "https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url" => $url,
      "seller" => [
        "@type" => "Organization",
        "name" => $brand
      ]
    ],
    "license" => $item['license_url'] ?: null
  ];
} else {
  // product
  $graph[] = [
    "@context" => "https://schema.org",
    "@type" => "Product",
    "@id" => $productId,
    "name" => $item['name'],
    "description" => $item['description'] ?: $item['short'],
    "sku" => $item['sku'] ?: null,
    "brand" => [
      "@type" => "Brand",
      "name" => $item['brand'] ?: $brand
    ],
    "image" => $item['image_url'] ?: null,
    "offers" => [
      "@type" => "Offer",
      "price" => $item['price'] ?: "0.00",
      "priceCurrency" => $item['currency'] ?: "USD",
      "availability" => "https://schema.org/" . ($item['availability'] ?: "InStock"),
      "url" => $url,
      "seller" => [
        "@type" => "Organization",
        "name" => $brand
      ]
    ]
  ];
}

$graph[] = [
  "@context" => "https://schema.org",
  "@type" => "BreadcrumbList",
  "@id" => $breadcrumbId,
  "itemListElement" => [
    [
      "@type" => "ListItem",
      "position" => 1,
      "name" => "Home",
      "item" => $domain . "/"
    ],
    [
      "@type" => "ListItem",
      "position" => 2,
      "name" => "Catalog",
      "item" => $domain . "/catalog/"
    ],
    [
      "@type" => "ListItem",
      "position" => 3,
      "name" => $item['name'],
      "item" => $url
    ]
  ]
];

$graph[] = [
  "@context" => "https://schema.org",
  "@type" => "WebSite",
  "@id" => $domain . "/#website",
  "url" => $domain . "/",
  "name" => $brand
];
?>
<script type="application/ld+json"><?= json_encode(["@context" => "https://schema.org", "@graph" => $graph], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
