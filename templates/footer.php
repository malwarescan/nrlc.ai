<?php
$blocks = $GLOBALS['__jsonld'] ?? [];
foreach ($blocks as $b) {
  echo '<script type="application/ld+json">'.json_encode($b, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
?>
<!-- Hero Isometric Animation Script -->
<script src="<?= asset_url('/assets/js/hero-animation.js') ?>" defer></script>
<footer class="site-footer">
  <div class="site-footer__content">
    <p><small>© <?= date('Y') ?> NRLC.ai — The Semantic Infrastructure for the AI Internet</small></p>
    <ul class="site-footer__links">
      <li><a href="https://nrlcmd.com" target="_blank" rel="noopener" class="site-footer__link">NRL CMD</a></li>
      <li><a href="https://neuralcommandllc.com" target="_blank" rel="noopener" class="site-footer__link">Neural Command LLC</a></li>
      <li><a href="https://www.crunchbase.com/organization/neural-command" target="_blank" rel="noopener" class="site-footer__link">Crunchbase</a></li>
      <li><a href="https://share.google/vAJ5zksUOr1wELBXp" target="_blank" rel="noopener" class="site-footer__link">Google Business</a></li>
      <li><a href="https://www.linkedin.com/company/neural-command/" target="_blank" rel="noopener" class="site-footer__link">LinkedIn</a></li>
    </ul>
  </div>
</footer>
<!-- Contact Bottom Sheet -->
<div id="contact-sheet" class="contact-sheet" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="contact-sheet-title">
  <div class="contact-sheet__backdrop"></div>
  <div class="contact-sheet__content">
    <div class="contact-sheet__handle"></div>
    <h2 id="contact-sheet-title" class="contact-sheet__title">Contact</h2>
    <div class="contact-sheet__options" id="contact-options">
      <!-- Options will be populated by JavaScript -->
    </div>
    <div class="contact-sheet__fallback">
      <small>Prefer another method? <a href="mailto:contact@neuralcommandllc.com">contact@neuralcommandllc.com</a></small>
    </div>
  </div>
</div>

<script>
(function() {
  'use strict';
  
  // Mobile navigation toggle
  const navToggle = document.querySelector('.nav-primary__toggle');
  const navMenu = document.querySelector('.nav-primary__menu');
  
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      const currentExpanded = this.getAttribute('aria-expanded') === 'true';
      const newExpanded = !currentExpanded;
      
      // Update button state
      this.setAttribute('aria-expanded', String(newExpanded));
      
      // Update menu visibility - when expanded=true, menu should be visible (aria-hidden=false)
      navMenu.setAttribute('aria-hidden', String(!newExpanded));
      
      // Force a reflow to ensure CSS updates
      void navMenu.offsetHeight;
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
      if (!navToggle.contains(event.target) && !navMenu.contains(event.target)) {
        navToggle.setAttribute('aria-expanded', 'false');
        navMenu.setAttribute('aria-hidden', 'true');
      }
    });
    
    // Close menu when window is resized to desktop size
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        if (window.innerWidth > 768) {
          navToggle.setAttribute('aria-expanded', 'false');
          navMenu.setAttribute('aria-hidden', 'true');
        }
      }, 250);
    });
  }
  
  // Contact Bottom Sheet
  const contactTrigger = document.getElementById('contact-trigger');
  const contactSheet = document.getElementById('contact-sheet');
  const contactBackdrop = contactSheet?.querySelector('.contact-sheet__backdrop');
  const contactOptions = document.getElementById('contact-options');
  
  // Detect device type
  function detectDevice() {
    const ua = navigator.userAgent || navigator.vendor || window.opera;
    const isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
    const isAndroid = /android/i.test(ua);
    const isMobile = isIOS || isAndroid;
    
    return { isIOS, isAndroid, isMobile };
  }
  
  // Build contact options based on device and service type
  function buildContactOptions(serviceType = '') {
    const device = detectDevice();
    const options = [];
    
    // Build message body with service type if provided
    let smsBody = 'hey, im interested in picking your brain';
    let emailSubject = 'Consultation Request';
    let emailBody = 'I\'m interested in scheduling a consultation.';
    
    if (serviceType) {
      smsBody = `hey, im interested in ${serviceType} - consultation request`;
      emailSubject = `Consultation Request - ${serviceType}`;
      emailBody = `I'm interested in scheduling a consultation for: ${serviceType}`;
    }
    
    // Always show SMS/iMessage options, but order and enable based on device
    if (device.isIOS) {
      // On iOS, show iMessage first, then SMS (both enabled)
      options.push({
        label: 'iMessage',
        action: () => {
          window.location.href = 'sms:+12135628438?body=' + encodeURIComponent(smsBody);
        },
        enabled: true
      });
      options.push({
        label: 'SMS',
        action: () => {
          window.location.href = 'sms:+12135628438?body=' + encodeURIComponent(smsBody);
        },
        enabled: true
      });
    } else {
      // On Android or Desktop, show SMS first, then iMessage
      options.push({
        label: 'SMS',
        action: () => {
          window.location.href = 'sms:+12135628438?body=' + encodeURIComponent(smsBody);
        },
        enabled: device.isMobile
      });
      options.push({
        label: 'iMessage',
        action: () => {
          window.location.href = 'sms:+12135628438?body=' + encodeURIComponent(smsBody);
        },
        enabled: false // Only enabled on iOS
      });
    }
    
    options.push({
      label: 'Call',
      action: () => {
        window.location.href = 'tel:+12135628438';
      },
      enabled: true
    });
    
    options.push({
      label: 'Email',
      action: () => {
        const emailUrl = 'mailto:hirejoelm@gmail.com?subject=' + encodeURIComponent(emailSubject) + '&body=' + encodeURIComponent(emailBody);
        window.location.href = emailUrl;
      },
      enabled: true
    });
    
    return options;
  }
  
  // Store current service type
  let currentServiceType = '';
  
  // Render contact options
  function renderContactOptions() {
    if (!contactOptions) return;
    
    const options = buildContactOptions(currentServiceType);
    
    contactOptions.innerHTML = options.map((option, index) => {
      const isDisabled = !option.enabled;
      return `
        <button 
          class="contact-sheet__option ${isDisabled ? 'contact-sheet__option--disabled' : ''}" 
          type="button"
          ${isDisabled ? 'disabled' : ''}
          data-action="${index}"
        >
          ${option.label}
          ${isDisabled && (option.label === 'SMS' || option.label === 'iMessage') ? '<small class="contact-sheet__option-hint">Send from your phone</small>' : ''}
        </button>
      `;
    }).join('');
    
    // Attach event listeners
    options.forEach((option, index) => {
      const button = contactOptions.querySelector(`[data-action="${index}"]`);
      if (button && option.enabled) {
        button.addEventListener('click', function() {
          option.action();
          closeContactSheet();
        });
      }
    });
  }
  
  // Open contact sheet with optional service type
  function openContactSheet(serviceType = '') {
    if (!contactSheet) return;
    currentServiceType = serviceType;
    renderContactOptions();
    contactSheet.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    
    // Trigger animation
    setTimeout(() => {
      contactSheet.classList.add('contact-sheet--open');
    }, 10);
  }
  
  // Make openContactSheet globally available
  window.openContactSheet = openContactSheet;
  
  // Close contact sheet
  function closeContactSheet() {
    if (!contactSheet) return;
    contactSheet.classList.remove('contact-sheet--open');
    setTimeout(() => {
      contactSheet.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }, 300);
  }
  
  // Initialize
  if (contactTrigger && contactSheet) {
    contactTrigger.addEventListener('click', openContactSheet);
    
    if (contactBackdrop) {
      contactBackdrop.addEventListener('click', closeContactSheet);
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && contactSheet.getAttribute('aria-hidden') === 'false') {
        closeContactSheet();
      }
    });
  }
})();
</script>
</body></html>

