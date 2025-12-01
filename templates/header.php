<header role="banner" class="site-header">
  <nav class="nav-primary" aria-label="Primary Navigation">
    <a href="/" class="nav-primary__brand">
      <img src="/assets/images/nrlc-logo.png" alt="NRLC.ai" height="32">
    </a>
    <button class="nav-primary__toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="nav-primary-menu">
      <span class="nav-primary__toggle-icon"></span>
      <span class="nav-primary__toggle-icon"></span>
      <span class="nav-primary__toggle-icon"></span>
    </button>
    <ul class="nav-primary__menu" id="nav-primary-menu" aria-hidden="true">
      <li class="nav-primary__item">
        <a href="/" class="nav-primary__link"<?= ($_SERVER['REQUEST_URI'] ?? '/') === '/' || ($_SERVER['REQUEST_URI'] ?? '/') === '/en-us/' ? ' aria-current="page"' : '' ?>>Home</a>
      </li>
      <li class="nav-primary__item">
        <a href="/services/" class="nav-primary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/services/') === 0 ? ' aria-current="page"' : '' ?>>Services</a>
      </li>
      <li class="nav-primary__item">
        <a href="/insights/" class="nav-primary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/insights/') === 0 ? ' aria-current="page"' : '' ?>>Insights</a>
      </li>
      <li class="nav-primary__item">
        <a href="/careers/" class="nav-primary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/careers/') === 0 ? ' aria-current="page"' : '' ?>>Careers</a>
      </li>
      <li class="nav-primary__item nav-primary__item--has-dropdown">
        <a href="/products/" class="nav-primary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/products/') === 0 ? ' aria-current="page"' : '' ?>>Products</a>
        <ul class="nav-primary__dropdown" aria-label="Products submenu">
          <li><a href="/products/data-but-structured/" class="nav-primary__dropdown-link">Data, But Structured</a></li>
          <li><a href="/products/applicants-io/" class="nav-primary__dropdown-link">Applicants.io</a></li>
          <li><a href="/products/ourcasa-ai/" class="nav-primary__dropdown-link">OurCasa.ai</a></li>
          <li><a href="/products/croutons-ai/" class="nav-primary__dropdown-link">Croutons.ai</a></li>
          <li><a href="/products/precogs/" class="nav-primary__dropdown-link">Precogs</a></li>
          <li><a href="/products/googlebot-renderer-lab/" class="nav-primary__dropdown-link">Googlebot Renderer Lab</a></li>
          <li><a href="/products/newfaq/" class="nav-primary__dropdown-link">NEWFAQ</a></li>
          <li><a href="/products/neural-command-os/" class="nav-primary__dropdown-link">Neural Command OS</a></li>
        </ul>
      </li>
      <li class="nav-primary__item">
        <a href="/catalog/" class="nav-primary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/catalog/') === 0 ? ' aria-current="page"' : '' ?>>Catalog</a>
      </li>
      <li class="nav-primary__item">
        <button class="nav-primary__link nav-primary__link--button" id="contact-trigger" type="button">Contact</button>
      </li>
    </ul>
  </nav>
  
  <?php
  // Secondary navigation for Services section
  if (strpos($_SERVER['REQUEST_URI'] ?? '', '/services/') === 0): ?>
  <nav class="nav-secondary" aria-label="Services Navigation">
    <ul class="nav-secondary__menu">
      <li class="nav-secondary__item">
        <a href="/services/" class="nav-secondary__link"<?= ($_SERVER['REQUEST_URI'] ?? '') === '/services/' ? ' aria-current="page"' : '' ?>>All Services</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/crawl-clarity/" class="nav-secondary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/services/crawl-clarity/') === 0 ? ' aria-current="page"' : '' ?>>Crawl Clarity</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/json-ld-strategy/" class="nav-secondary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/services/json-ld-strategy/') === 0 ? ' aria-current="page"' : '' ?>>JSON-LD Strategy</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/llm-seeding/" class="nav-secondary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/services/llm-seeding/') === 0 ? ' aria-current="page"' : '' ?>>LLM Seeding</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/technical-seo/" class="nav-secondary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/services/technical-seo/') === 0 ? ' aria-current="page"' : '' ?>>Technical SEO</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/services/site-audits/" class="nav-secondary__link"<?= strpos($_SERVER['REQUEST_URI'] ?? '', '/services/site-audits/') === 0 ? ' aria-current="page"' : '' ?>>Site Audits</a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
  
  <?php
  // Secondary navigation for Insights section
  if (strpos($_SERVER['REQUEST_URI'] ?? '', '/insights/') === 0): ?>
  <nav class="nav-secondary" aria-label="Insights Navigation">
    <ul class="nav-secondary__menu">
      <li class="nav-secondary__item">
        <a href="/insights/" class="nav-secondary__link"<?= ($_SERVER['REQUEST_URI'] ?? '') === '/insights/' ? ' aria-current="page"' : '' ?>>All Insights</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/semantic-modeling/" class="nav-secondary__link">Semantic Modeling</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/data-virtualization/" class="nav-secondary__link">Data Virtualization</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/enterprise-llm/" class="nav-secondary__link">Enterprise LLM</a>
      </li>
      <li class="nav-secondary__item">
        <a href="/insights/performance-caching/" class="nav-secondary__link">Performance & Caching</a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
</header>

