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
      // Guard absolute_url function
      if (!function_exists('absolute_url')) {
        require_once __DIR__ . '/../lib/helpers.php';
      }
      
      // Home
      $homeAttrs = menu_item_seo_attrs('Home');
      $isHome = ($_SERVER['REQUEST_URI'] ?? '/') === '/' || ($_SERVER['REQUEST_URI'] ?? '/') === '/en-us/';
      ?>
      <li class="nav-primary__item">
        <a href="<?= absolute_url('/') ?>" class="nav-primary__link" title="<?= $homeAttrs['title'] ?>" aria-label="<?= $homeAttrs['aria-label'] ?>"<?= $isHome ? ' aria-current="page"' : '' ?>>Home</a>
      </li>
      
      <?php
      // Knowledge Base Dropdown - Contains all 10 pillars
      $kbAttrs = menu_item_seo_attrs('Knowledge Base');
      $isKnowledgeBase = strpos($_SERVER['REQUEST_URI'] ?? '', '/generative-engine-optimization/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-diagnostics/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-measurement/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-strategy/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-operations/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-migrations/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-risk/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/ai-search-tools-reality/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/field-notes/') !== false ||
                         strpos($_SERVER['REQUEST_URI'] ?? '', '/glossary/') !== false;
      
      // Individual pillar checks for active state
      $geoAttrs = menu_item_seo_attrs('Generative Engine Optimization');
      $diagnosticsAttrs = menu_item_seo_attrs('AI Search Diagnostics');
      $measurementAttrs = menu_item_seo_attrs('AI Search Measurement');
      $strategyAttrs = menu_item_seo_attrs('AI Search Strategy');
      $operationsAttrs = menu_item_seo_attrs('AI Search Operations');
      $migrationsAttrs = menu_item_seo_attrs('AI Search Migrations');
      $riskAttrs = menu_item_seo_attrs('AI Search Risk');
      $toolsRealityAttrs = menu_item_seo_attrs('AI Search Tools Reality');
      $fieldNotesAttrs = menu_item_seo_attrs('Field Notes');
      $glossaryAttrs = menu_item_seo_attrs('Glossary');
      ?>
      <li class="nav-primary__item nav-primary__item--has-dropdown">
        <a href="<?= absolute_url('/') ?>#knowledge-base" class="nav-primary__link" title="<?= $kbAttrs['title'] ?>" aria-label="<?= $kbAttrs['aria-label'] ?>"<?= $isKnowledgeBase ? ' aria-current="page"' : '' ?>>Knowledge Base</a>
        <ul class="nav-primary__dropdown" aria-label="Knowledge Base sections">
          <li><a href="<?= absolute_url('/en-us/generative-engine-optimization/') ?>" class="nav-primary__dropdown-link" title="<?= $geoAttrs['title'] ?>" aria-label="<?= $geoAttrs['aria-label'] ?>">GEO</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-diagnostics/') ?>" class="nav-primary__dropdown-link" title="<?= $diagnosticsAttrs['title'] ?>" aria-label="<?= $diagnosticsAttrs['aria-label'] ?>">Diagnostics</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-measurement/') ?>" class="nav-primary__dropdown-link" title="<?= $measurementAttrs['title'] ?>" aria-label="<?= $measurementAttrs['aria-label'] ?>">Measurement</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-strategy/') ?>" class="nav-primary__dropdown-link" title="<?= $strategyAttrs['title'] ?>" aria-label="<?= $strategyAttrs['aria-label'] ?>">Strategy</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-operations/') ?>" class="nav-primary__dropdown-link" title="<?= $operationsAttrs['title'] ?>" aria-label="<?= $operationsAttrs['aria-label'] ?>">Operations</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-migrations/') ?>" class="nav-primary__dropdown-link" title="<?= $migrationsAttrs['title'] ?>" aria-label="<?= $migrationsAttrs['aria-label'] ?>">Migrations</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-risk/') ?>" class="nav-primary__dropdown-link" title="<?= $riskAttrs['title'] ?>" aria-label="<?= $riskAttrs['aria-label'] ?>">Risk</a></li>
          <li><a href="<?= absolute_url('/en-us/ai-search-tools-reality/') ?>" class="nav-primary__dropdown-link" title="<?= $toolsRealityAttrs['title'] ?>" aria-label="<?= $toolsRealityAttrs['aria-label'] ?>">Tools Reality</a></li>
          <li><a href="<?= absolute_url('/en-us/field-notes/') ?>" class="nav-primary__dropdown-link" title="<?= $fieldNotesAttrs['title'] ?>" aria-label="<?= $fieldNotesAttrs['aria-label'] ?>">Field Notes</a></li>
          <li><a href="<?= absolute_url('/en-us/glossary/') ?>" class="nav-primary__dropdown-link" title="<?= $glossaryAttrs['title'] ?>" aria-label="<?= $glossaryAttrs['aria-label'] ?>">Glossary</a></li>
        </ul>
      </li>
      
      <?php
      // Training (Tier 0 - Authority Core)
      $trainingAttrs = menu_item_seo_attrs('Training');
      $isTraining = strpos($_SERVER['REQUEST_URI'] ?? '', '/training') !== false;
      ?>
      <li class="nav-primary__item">
        <a href="<?= absolute_url('/training/') ?>" class="nav-primary__link" title="<?= $trainingAttrs['title'] ?>" aria-label="<?= $trainingAttrs['aria-label'] ?>"<?= $isTraining ? ' aria-current="page"' : '' ?>>Training</a>
      </li>
      
      <?php
      // Insights (Tier 0 - Authority Core)
      $insightsAttrs = menu_item_seo_attrs('Insights');
      $isInsights = strpos($_SERVER['REQUEST_URI'] ?? '', '/insights/') === 0;
      ?>
      <li class="nav-primary__item">
        <a href="<?= absolute_url('/insights/') ?>" class="nav-primary__link" title="<?= $insightsAttrs['title'] ?>" aria-label="<?= $insightsAttrs['aria-label'] ?>"<?= $isInsights ? ' aria-current="page"' : '' ?>>Insights</a>
      </li>
    </ul>
    
    <!-- Tier 1 Navigation (Right Side - Utility Only, Visually Demoted) -->
    <ul class="nav-primary__menu nav-primary__menu--secondary">
      <?php
      // Tier 1: Utility items only (right-aligned, visually demoted)
      // Contact is the only Tier 1 item allowed in global nav
      $contactAttrs = menu_item_seo_attrs('Contact');
      ?>
      <li class="nav-primary__item">
        <button class="nav-primary__link nav-primary__link--secondary" id="contact-trigger" type="button" title="<?= $contactAttrs['title'] ?>" aria-label="<?= $contactAttrs['aria-label'] ?>">Contact</button>
      </li>
    </ul>
  </nav>
  
  <?php
  // Secondary navigation bar (for section-specific navigation)
  // Only shown on services/insights pages
  ?>
  
  <?php
  // Secondary navigation for Services section (when on services pages)
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
        <a href="<?= absolute_url('/services/') ?>" class="nav-secondary__link" title="<?= $allServicesAttrs['title'] ?>" aria-label="<?= $allServicesAttrs['aria-label'] ?>"<?= $isAllServices ? ' aria-current="page"' : '' ?>>All Services</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/services/crawl-clarity/') ?>" class="nav-secondary__link" title="<?= $crawlClarityAttrs['title'] ?>" aria-label="<?= $crawlClarityAttrs['aria-label'] ?>"<?= $isCrawlClarity ? ' aria-current="page"' : '' ?>>Crawl Clarity</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/services/json-ld-strategy/') ?>" class="nav-secondary__link" title="<?= $jsonLdStrategyAttrs['title'] ?>" aria-label="<?= $jsonLdStrategyAttrs['aria-label'] ?>"<?= $isJsonLdStrategy ? ' aria-current="page"' : '' ?>>JSON-LD Strategy</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/services/llm-seeding/') ?>" class="nav-secondary__link" title="<?= $llmSeedingAttrs['title'] ?>" aria-label="<?= $llmSeedingAttrs['aria-label'] ?>"<?= $isLlmSeeding ? ' aria-current="page"' : '' ?>>LLM Seeding</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/services/technical-seo/') ?>" class="nav-secondary__link" title="<?= $technicalSeoAttrs['title'] ?>" aria-label="<?= $technicalSeoAttrs['aria-label'] ?>"<?= $isTechnicalSeo ? ' aria-current="page"' : '' ?>>Technical SEO</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/services/site-audits/') ?>" class="nav-secondary__link" title="<?= $siteAuditsAttrs['title'] ?>" aria-label="<?= $siteAuditsAttrs['aria-label'] ?>"<?= $isSiteAudits ? ' aria-current="page"' : '' ?>>Site Audits</a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
  
  <?php
  // Secondary navigation for Insights section (when on insights pages)
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
        <a href="<?= absolute_url('/insights/') ?>" class="nav-secondary__link" title="<?= $allInsightsAttrs['title'] ?>" aria-label="<?= $allInsightsAttrs['aria-label'] ?>"<?= $isAllInsights ? ' aria-current="page"' : '' ?>>All Insights</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/insights/semantic-modeling/') ?>" class="nav-secondary__link" title="<?= $semanticModelingAttrs['title'] ?>" aria-label="<?= $semanticModelingAttrs['aria-label'] ?>">Semantic Modeling</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/insights/data-virtualization/') ?>" class="nav-secondary__link" title="<?= $dataVirtualizationAttrs['title'] ?>" aria-label="<?= $dataVirtualizationAttrs['aria-label'] ?>">Data Virtualization</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/insights/enterprise-llm/') ?>" class="nav-secondary__link" title="<?= $enterpriseLlmAttrs['title'] ?>" aria-label="<?= $enterpriseLlmAttrs['aria-label'] ?>">Enterprise LLM</a>
      </li>
      <li class="nav-secondary__item">
        <a href="<?= absolute_url('/insights/performance-caching/') ?>" class="nav-secondary__link" title="<?= $performanceCachingAttrs['title'] ?>" aria-label="<?= $performanceCachingAttrs['aria-label'] ?>">Performance & Caching</a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
</header>
