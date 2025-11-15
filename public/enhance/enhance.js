(function(){
  const reduced = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // Initialize ScrollReveal
  const sr = ScrollReveal({
    origin: 'bottom',
    distance: '20px',
    duration: 800,
    delay: 100,
    easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
    reset: false,
    useDelay: 'always',
    viewFactor: 0.2,
    viewOffset: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0
    }
  });

  // Subtle neural network layer configurations - tasteful and minimal
  const neuralConfigs = {
    input: {
      origin: 'bottom',
      distance: '20px',
      duration: 800,
      delay: 100,
      easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
      opacity: 0
    },
    hidden: {
      origin: 'bottom',
      distance: '25px',
      duration: 900,
      delay: 150,
      easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
      opacity: 0
    },
    output: {
      origin: 'bottom',
      distance: '20px',
      duration: 1000,
      delay: 200,
      easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
      opacity: 0
    }
  };

  // Minimal neural network states for background
  const neuralLayers = {
    input: { progress: 0, strength: 0.1 },
    hidden1: { progress: 0.25, strength: 0.3 },
    hidden2: { progress: 0.5, strength: 0.5 },
    output: { progress: 0.75, strength: 0.7 }
  };

  // Create background layers for neural effects
  const createBackgroundLayers = () => {
    const bg = document.createElement("div");
    bg.className = "enhance-bg";

    // Neural particles - ScrollReveal enhanced
    const particles = document.createElement("div");
    particles.className = "neural-particles";
    bg.appendChild(particles);

    // Neural glow - ScrollReveal enhanced
    const glow = document.createElement("div");
    glow.className = "neural-glow";
    bg.appendChild(glow);

    document.body.prepend(bg);
    return bg;
  };

  const bg = createBackgroundLayers();

  // Simple neural network state for background effects
  let currentLayer = 'input';

  // Update neural network state with ScrollReveal synergy
  const updateNeuralState = (scrollProgress) => {
    const root = document.documentElement.style;

    // Map scroll to neural flow progress (0-1) with easing
    const flowProgress = Math.min(1, Math.max(0, scrollProgress));
    const easedProgress = flowProgress * flowProgress * (3 - 2 * flowProgress);
    root.setProperty('--flow-progress', easedProgress);

    // Calculate synapse strength with ScrollReveal-like timing
    let synapseStrength = 0;
    if (flowProgress < 0.25) {
      synapseStrength = flowProgress * 4;
    } else if (flowProgress < 0.75) {
      synapseStrength = 0.5 + (flowProgress - 0.25) * 2;
    } else {
      synapseStrength = 1.5 + (flowProgress - 0.75) * 2;
    }
    root.setProperty('--synapse-strength', Math.min(1, synapseStrength));

    // Determine current layer - tastefully subtle
    let layer = 'input';
    if (scrollProgress > 0.25) layer = 'hidden';
    if (scrollProgress > 0.75) layer = 'output';
    currentLayer = layer;
  };

  // Setup ScrollReveal for neural network layers
  const setupScrollReveal = () => {
    const windows = Array.from(document.querySelectorAll(".window"));

    // Map sections to neural layers
    const sectionLayers = {
      0: 'input',   // Hero section
      1: 'input',   // Goldmine
      2: 'hidden',  // Services
      3: 'hidden',  // GEO-16
      4: 'hidden',  // Insights
      5: 'output',  // Open-source
      6: 'output'   // FAQ
    };

    // Apply ScrollReveal to each section with neural layer configurations
    windows.forEach((section, index) => {
      if (section) {
        const layer = sectionLayers[index] || 'hidden';
        const config = neuralConfigs[layer];

        // Reveal the section itself with minimal styling
        sr.reveal(section, {
          ...config,
          beforeReveal: function(el) {
            el.classList.add('neural-section-active');
          }
        });

        // Reveal content elements within the section - tasteful staggering
        const contentElements = section.querySelectorAll("h1, h2, h3, p, li, figure, img, .btn, .box-padding");

        if (contentElements.length > 0) {
          // Subtle staggering without visual effects
          const staggeredConfig = {
            ...config,
            interval: 50, // Gentle 50ms stagger
            beforeReveal: function(el) {
              el.classList.add('neural-element-revealed');
            }
          };

          sr.reveal(contentElements, staggeredConfig);
        }
      }
    });
  };

  // Initialize ScrollReveal
  setupScrollReveal();

  // ===== SCROLLREVEAL SYNC() IMPLEMENTATION =====
  // As documented at: https://scrollrevealjs.org/api/sync.html
  //
  // The sync() method reapplies all previous reveal() calls to capture
  // new elements added to the DOM after initial page load.
  //
  // USAGE EXAMPLES:
  //
  // 1. Direct function call:
  //    window.ScrollRevealSync();
  //
  // 2. Event-based (for external integrations):
  //    window.dispatchEvent(new Event('scrollReveal:sync'));
  //
  // 3. After AJAX content loading:
  //    fetch('/api/content').then(() => window.ScrollRevealSync());
  //
  // 4. With promises:
  //    loadMoreContent().then(() => window.ScrollRevealSync());
  //
  // 5. Automatic sync (built-in MutationObserver):
  //    // Just add elements to DOM - sync happens automatically
  //    document.body.appendChild(newElement);
  //
  // BENEFITS:
  // - No need to remember and re-pass reveal() arguments
  // - Handles dynamically loaded content seamlessly
  // - Performance optimized with debouncing
  // - Works with AJAX, SPAs, and dynamic content injection
  // ===================================================
  window.ScrollRevealSync = () => {
    console.log('ScrollReveal: Syncing reveals for dynamic content');
    sr.sync();
  };

  // Event-based sync for external integrations
  window.addEventListener('scrollReveal:sync', () => {
    console.log('ScrollReveal: Sync event received');
    sr.sync();
  });

  // Automatic sync for DOM changes (debounced for performance)
  let syncTimeout;
  const observer = new MutationObserver((mutations) => {
    // Check if any mutations added elements that might need reveals
    const hasNewElements = mutations.some(mutation =>
      mutation.type === 'childList' &&
      mutation.addedNodes.length > 0 &&
      Array.from(mutation.addedNodes).some(node =>
        node.nodeType === Node.ELEMENT_NODE &&
        (node.matches || node.webkitMatchesSelector).call(node, 'h1, h2, h3, p, li, figure, img, .btn, .box-padding')
      )
    );

    if (hasNewElements) {
      clearTimeout(syncTimeout);
      syncTimeout = setTimeout(() => {
        console.log('ScrollReveal: Auto-syncing due to DOM changes');
        sr.sync();
      }, 100); // Debounce for performance
    }
  });

  // Observe the entire document for changes
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });

  if (reduced) {
    bg.classList.add('grain');
    return;
  }

  // Neural network scroll handler - works alongside ScrollReveal
  const onScroll = () => {
    const scrollY = window.scrollY;
    const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollProgress = Math.min(1, Math.max(0, scrollY / totalHeight));

    // Update neural network background state
    updateNeuralState(scrollProgress);

    // Add grain texture at the end of the neural journey
    if (scrollProgress > 0.9 && !bg.classList.contains('grain')) {
      bg.classList.add('grain');
    } else if (scrollProgress < 0.9 && bg.classList.contains('grain')) {
      bg.classList.remove('grain');
    }
  };

  // Throttled scroll handling for smooth performance
  let scrollTimeout;
  const throttledScroll = () => {
    if (!scrollTimeout) {
      scrollTimeout = setTimeout(() => {
        onScroll();
        scrollTimeout = null;
      }, 16); // ~60fps
    }
  };

  // Initialize the neural network experience
  onScroll();

  // Start listening to scroll events
  document.addEventListener("scroll", throttledScroll, { passive: true });
  window.addEventListener("resize", () => {
    clearTimeout(scrollTimeout);
    onScroll();
  });

})();
