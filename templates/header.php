<header role="banner" class="site-header">
  <nav class="nav-primary" aria-label="Primary Navigation">
    <a href="/" class="nav-primary__brand" title="Neural Command LLC: AI SEO - NRLC.ai Home">
      <img 
        src="/assets/images/nrlc-logo.png" 
        alt="Neural Command LLC: AI SEO - NRLC.ai Logo" 
        title="Neural Command LLC: AI SEO"
        width="43" 
        height="43" 
        loading="eager"
        itemprop="logo">
    </a>
    <button class="nav-primary__toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="nav-primary-menu">
      <span class="nav-primary__toggle-icon"></span>
      <span class="nav-primary__toggle-icon"></span>
      <span class="nav-primary__toggle-icon"></span>
    </button>
    <ul class="nav-primary__menu" id="nav-primary-menu" aria-hidden="true">
      <?php
      $homeAttrs = menu_item_seo_attrs('Home');
      $isHome = ($_SERVER['REQUEST_URI'] ?? '/') === '/' || ($_SERVER['REQUEST_URI'] ?? '/') === '/en-us/';
      ?>
      <li class="nav-primary__item">
        <a href="/" class="nav-primary__link" title="<?= $homeAttrs['title'] ?>" aria-label="<?= $homeAttrs['aria-label'] ?>"<?= $isHome ? ' aria-current="page"' : '' ?>>Home</a>
      </li>
      <?php
      $servicesAttrs = menu_item_seo_attrs('Services');
      $isServices = strpos($_SERVER['REQUEST_URI'] ?? '', '/services/') === 0;
      ?>
      <li class="nav-primary__item">
        <a href="/services/" class="nav-primary__link" title="<?= $servicesAttrs['title'] ?>" aria-label="<?= $servicesAttrs['aria-label'] ?>"<?= $isServices ? ' aria-current="page"' : '' ?>>Services</a>
      </li>
      <?php
      // AI Visibility Industries Dropdown
      $aiVisibilityAttrs = menu_item_seo_attrs('AI Visibility');
      $isAiVisibility = strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-visibility/') === 0;
      $industries = [];
      if (file_exists(__DIR__ . '/../lib/ai_visibility_industries.php')) {
        $industries = require __DIR__ . '/../lib/ai_visibility_industries.php';
      }
      ?>
      <li class="nav-primary__item nav-primary__item--has-dropdown">
        <a href="/ai-visibility/" class="nav-primary__link" title="<?= $aiVisibilityAttrs['title'] ?>" aria-label="<?= $aiVisibilityAttrs['aria-label'] ?>"<?= $isAiVisibility ? ' aria-current="page"' : '' ?>>AI Visibility</a>
        <ul class="nav-primary__dropdown" aria-label="AI Visibility Industries submenu">
          <?php foreach ($industries as $slug => $industry): ?>
            <?php
            $industryAttrs = menu_item_seo_attrs($industry['name']);
            $isCurrentIndustry = strpos($_SERVER['REQUEST_URI'] ?? '', "/ai-visibility/{$slug}/") !== false;
            ?>
            <li><a href="/ai-visibility/<?= htmlspecialchars($slug) ?>/" class="nav-primary__dropdown-link" title="<?= $industryAttrs['title'] ?>" aria-label="<?= $industryAttrs['aria-label'] ?>"<?= $isCurrentIndustry ? ' aria-current="page"' : '' ?>><?= htmlspecialchars($industry['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </li>
      <?php
      $insightsAttrs = menu_item_seo_attrs('Insights');
      $isInsights = strpos($_SERVER['REQUEST_URI'] ?? '', '/insights/') === 0;
      ?>
      <li class="nav-primary__item">
        <a href="/insights/" class="nav-primary__link" title="<?= $insightsAttrs['title'] ?>" aria-label="<?= $insightsAttrs['aria-label'] ?>"<?= $isInsights ? ' aria-current="page"' : '' ?>>Insights</a>
      </li>
      <?php
      $careersAttrs = menu_item_seo_attrs('Careers');
      $isCareers = strpos($_SERVER['REQUEST_URI'] ?? '', '/careers/') === 0;
      ?>
      <li class="nav-primary__item">
        <a href="/careers/" class="nav-primary__link" title="<?= $careersAttrs['title'] ?>" aria-label="<?= $careersAttrs['aria-label'] ?>"<?= $isCareers ? ' aria-current="page"' : '' ?>>Careers</a>
      </li>
      <?php
      $productsAttrs = menu_item_seo_attrs('Products');
      $isProducts = strpos($_SERVER['REQUEST_URI'] ?? '', '/products/') === 0;
      $dataButStructuredAttrs = menu_item_seo_attrs('Data, But Structured');
      $applicantsIoAttrs = menu_item_seo_attrs('Applicants.io');
      $ourcasaAiAttrs = menu_item_seo_attrs('OurCasa.ai');
      $croutonsAiAttrs = menu_item_seo_attrs('Croutons.ai');
      $precogsAttrs = menu_item_seo_attrs('Precogs');
      $googlebotRendererLabAttrs = menu_item_seo_attrs('Googlebot Renderer Lab');
      $newfaqAttrs = menu_item_seo_attrs('NEWFAQ');
      $neuralCommandOsAttrs = menu_item_seo_attrs('Neural Command OS');
      ?>
      <li class="nav-primary__item nav-primary__item--has-dropdown">
        <a href="/en-us/products/" class="nav-primary__link" title="<?= $productsAttrs['title'] ?>" aria-label="<?= $productsAttrs['aria-label'] ?>"<?= $isProducts ? ' aria-current="page"' : '' ?>>Products</a>
        <ul class="nav-primary__dropdown" aria-label="Products submenu">
          <li><a href="/products/data-but-structured/" class="nav-primary__dropdown-link" title="<?= $dataButStructuredAttrs['title'] ?>" aria-label="<?= $dataButStructuredAttrs['aria-label'] ?>">Data, But Structured</a></li>
          <li><a href="/products/applicants-io/" class="nav-primary__dropdown-link" title="<?= $applicantsIoAttrs['title'] ?>" aria-label="<?= $applicantsIoAttrs['aria-label'] ?>">Applicants.io</a></li>
          <li><a href="/products/ourcasa-ai/" class="nav-primary__dropdown-link" title="<?= $ourcasaAiAttrs['title'] ?>" aria-label="<?= $ourcasaAiAttrs['aria-label'] ?>">OurCasa.ai</a></li>
          <li><a href="/products/croutons-ai/" class="nav-primary__dropdown-link" title="<?= $croutonsAiAttrs['title'] ?>" aria-label="<?= $croutonsAiAttrs['aria-label'] ?>">Croutons.ai</a></li>
          <li><a href="/products/precogs/" class="nav-primary__dropdown-link" title="<?= $precogsAttrs['title'] ?>" aria-label="<?= $precogsAttrs['aria-label'] ?>">Precogs</a></li>
          <li><a href="/products/googlebot-renderer-lab/" class="nav-primary__dropdown-link" title="<?= $googlebotRendererLabAttrs['title'] ?>" aria-label="<?= $googlebotRendererLabAttrs['aria-label'] ?>">Googlebot Renderer Lab</a></li>
          <li><a href="/products/newfaq/" class="nav-primary__dropdown-link" title="<?= $newfaqAttrs['title'] ?>" aria-label="<?= $newfaqAttrs['aria-label'] ?>">NEWFAQ</a></li>
          <li><a href="/products/neural-command-os/" class="nav-primary__dropdown-link" title="<?= $neuralCommandOsAttrs['title'] ?>" aria-label="<?= $neuralCommandOsAttrs['aria-label'] ?>">Neural Command OS</a></li>
        </ul>
      </li>
      <?php
      $catalogAttrs = menu_item_seo_attrs('Catalog');
      $isCatalog = strpos($_SERVER['REQUEST_URI'] ?? '', '/catalog/') === 0;
      ?>
      <li class="nav-primary__item">
        <a href="/catalog/" class="nav-primary__link" title="<?= $catalogAttrs['title'] ?>" aria-label="<?= $catalogAttrs['aria-label'] ?>"<?= $isCatalog ? ' aria-current="page"' : '' ?>>Catalog</a>
      </li>
      <?php
      $contactAttrs = menu_item_seo_attrs('Contact');
      ?>
      <li class="nav-primary__item">
        <button class="nav-primary__link nav-primary__link--button" id="contact-trigger" type="button" title="<?= $contactAttrs['title'] ?>" aria-label="<?= $contactAttrs['aria-label'] ?>">Contact</button>
      </li>
    </ul>
  </nav>
  
  <?php
  // Secondary navigation for Services section
  if (strpos($_SERVER['REQUEST_URI'] ?? '', '/services/') === 0): 
    $allServicesAttrs = menu_item_seo_attrs('All Services');
    $crawlClarityAttrs = menu_item_seo_attrs('Crawl Clarity');
    $jsonLdStrategyAttrs = menu_item_seo_attrs('JSON-LD Strategy');
    $llmSeedingAttrs = menu_item_seo_attrs('LLM Seeding');
    $technicalSeoAttrs = menu_item_seo_attrs('Technical SEO');
    $siteAuditsAttrs = menu_item_seo_attrs('Site Audits');
    $isAllServices = ($_SERVER['REQUEST_URI'] ?? '') === '/services/';
    $isCrawlClarity = strpos($_SERVER['REQUEST_URI'] ?? '', '/services/crawl-clarity/') === 0;
    $isJsonLdStrategy = strpos($_SERVER['REQUEST_URI'] ?? '', '/services/json-ld-strategy/') === 0;
    $isLlmSeeding = strpos($_SERVER['REQUEST_URI'] ?? '', '/services/llm-seeding/') === 0;
    $isTechnicalSeo = strpos($_SERVER['REQUEST_URI'] ?? '', '/services/technical-seo/') === 0;
    $isSiteAudits = strpos($_SERVER['REQUEST_URI'] ?? '', '/services/site-audits/') === 0;
  ?>
  <nav class="nav-secondary" aria-label="Services Navigation">
    <ul class="nav-secondary__menu">
      <li class="nav-secondary__item">
        <a href="/services/" class="nav-secondary__link" title="<?= $allServicesAttrs['title'] ?>" aria-label="<?= $allServicesAttrs['aria-label'] ?>"<?= $isAllServices ? ' aria-current="page"' : '' ?>>All Services</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/crawl-clarity/" class="nav-secondary__link" title="<?= $crawlClarityAttrs['title'] ?>" aria-label="<?= $crawlClarityAttrs['aria-label'] ?>"<?= $isCrawlClarity ? ' aria-current="page"' : '' ?>>Crawl Clarity</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/json-ld-strategy/" class="nav-secondary__link" title="<?= $jsonLdStrategyAttrs['title'] ?>" aria-label="<?= $jsonLdStrategyAttrs['aria-label'] ?>"<?= $isJsonLdStrategy ? ' aria-current="page"' : '' ?>>JSON-LD Strategy</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/llm-seeding/" class="nav-secondary__link" title="<?= $llmSeedingAttrs['title'] ?>" aria-label="<?= $llmSeedingAttrs['aria-label'] ?>"<?= $isLlmSeeding ? ' aria-current="page"' : '' ?>>LLM Seeding</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/technical-seo/" class="nav-secondary__link" title="<?= $technicalSeoAttrs['title'] ?>" aria-label="<?= $technicalSeoAttrs['aria-label'] ?>"<?= $isTechnicalSeo ? ' aria-current="page"' : '' ?>>Technical SEO</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/site-audits/" class="nav-secondary__link" title="<?= $siteAuditsAttrs['title'] ?>" aria-label="<?= $siteAuditsAttrs['aria-label'] ?>"<?= $isSiteAudits ? ' aria-current="page"' : '' ?>>Site Audits</a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
  
  <?php
  // Secondary navigation for Insights section
  if (strpos($_SERVER['REQUEST_URI'] ?? '', '/insights/') === 0): 
    $allInsightsAttrs = menu_item_seo_attrs('All Insights');
    $semanticModelingAttrs = menu_item_seo_attrs('Semantic Modeling');
    $dataVirtualizationAttrs = menu_item_seo_attrs('Data Virtualization');
    $enterpriseLlmAttrs = menu_item_seo_attrs('Enterprise LLM');
    $performanceCachingAttrs = menu_item_seo_attrs('Performance & Caching');
    $isAllInsights = ($_SERVER['REQUEST_URI'] ?? '') === '/insights/';
  ?>
  <nav class="nav-secondary" aria-label="Insights Navigation">
    <ul class="nav-secondary__menu">
      <li class="nav-secondary__item">
        <a href="/insights/" class="nav-secondary__link" title="<?= $allInsightsAttrs['title'] ?>" aria-label="<?= $allInsightsAttrs['aria-label'] ?>"<?= $isAllInsights ? ' aria-current="page"' : '' ?>>All Insights</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/semantic-modeling/" class="nav-secondary__link" title="<?= $semanticModelingAttrs['title'] ?>" aria-label="<?= $semanticModelingAttrs['aria-label'] ?>">Semantic Modeling</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/data-virtualization/" class="nav-secondary__link" title="<?= $dataVirtualizationAttrs['title'] ?>" aria-label="<?= $dataVirtualizationAttrs['aria-label'] ?>">Data Virtualization</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/enterprise-llm/" class="nav-secondary__link" title="<?= $enterpriseLlmAttrs['title'] ?>" aria-label="<?= $enterpriseLlmAttrs['aria-label'] ?>">Enterprise LLM</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/performance-caching/" class="nav-secondary__link" title="<?= $performanceCachingAttrs['title'] ?>" aria-label="<?= $performanceCachingAttrs['aria-label'] ?>">Performance & Caching</a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
</header>

